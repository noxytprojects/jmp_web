<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function sendPush($payload, $receivers, $usn) {

        log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Sending push notification. Payload : ' . json_encode(['payload' => $payload, 'receivers' => $receivers]));

        $firebase = new Firebase();
        $push = new Push();
        $push->setTitle(SYSTEM_NAME);
        $push->setMessage($payload['msg']);
        $push->setImage('');
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);
        $push->setReceiver($receivers);
        $json = $push->getPush();

        $fcm = $firebase->sendFcm($json);

        log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - push notification sent : ' . $fcm);
    }

    public function submitApproval() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');


        // Check user session status and the platform used
        if (!$this->usr->is_logged_in) {

            $_POST = json_decode(file_get_contents('php://input'), true);
            $user_id = $this->input->post('user_id');

            $user = $this->usr->getUserInfo($user_id, 'ID');

            if (!$user) {
                cus_json_error(MSG_EXPIRY_SESSION);
            }

            // Validate api session
            $key = $this->input->post('user_key');
            $session_status = $this->usr->validateSession($user_id, $key);

            if (!$session_status) {
                cus_json_session_timeout();
            }


            $usn = $user['usr_email'];
            $fullname = $user['usr_fullname'];
            $trip_id = $action = $this->input->post('trip_id');
            $approval_titles = $this->usr->getUserApprovalTitles($user['usr_id']);
        } else {
            $usn = $this->usr->user_email;
            $fullname = $this->usr->user_fullname;
            $trip_id = $this->uri->segment(3);
            $approval_titles = $this->usr->getUserApprovalTitles();
        }


        $action = $this->input->post('action');
        $comment = "";
        $status = "";
        $sms_contractor = "";
        $sms_approver = "";

        $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $trip_id], 1);

        if (!$trip) {
            // trip request was not found so redirect back
            $this->usr->setSessMsg('Trip request was not found or may have been removed from the system', 'error', site_url('trip/requests'));
        }

        //Check if can approve

        $approval = $this->approval->getRequestApprovals(NULL, "auth.auth_tr_id = '" . $trip['tr_id'] . "' AND auth.auth_status IS NULL AND r.r_notification_status = '1'", 1, ['auth.auth_usr_title' => $approval_titles, 'tr.tr_status' => ['INPROGRESS']]);

        if (!$approval) {
            cus_json_error("Access denied. Contact system admin");
        }
        
        $driver = $this->driver->getDriverProfiles(['dp_status'], ['dp_usr_id' => $trip['tr_usr_id']], 1);

        if (!$driver) {
            cus_json_error('Driver profile was not found. Contact the system admin.');
        }

        if (in_array(strtolower($driver['dp_status']), ['pending'])) {
            cus_json_error('You should approve driver profile before approving this trip request.');
        }

        $validations = [];

        switch (strtolower($action)) {

            case 'approve':

                $comment .= "APPROVED\n";

                $status = "APPROVED";
                $validations[] = ['field' => 'comment', 'label' => 'Approval Comment', 'rules' => 'trim'];
                $sms_contractor = "Hello " . $trip['dp_full_name'] . " \nYour trip request for (" . cus_ellipsis($trip['tr_journey_purpose'], 70) . ") have been approved by " . $approval['auth_usr_title'];
                break;

            case 'disapprove':
                $comment .= "DISAPPROVED\n\n";

                $status = "DISAPPROVED";
                $validations[] = ['field' => 'dis_comment', 'label' => 'Disapproval Comment', 'rules' => 'trim|required'];
                $sms_contractor = "Hello " . $trip['dp_full_name'] . " \nYour permit for (" . cus_ellipsis($trip['tr_journey_purpose'], 70) . ") have been disapproved by " . $approval['auth_usr_title'];
                break;

            default :
                cus_json_error("Invalid action encountered, contact the system admin");
                break;
        }

        $this->form_validation->set_rules($validations);

        log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Attempting to ' . strtolower($action) . ' Trip request : ' . $trip['tr_id']);

        if ($this->form_validation->run() == FALSE) {
            // Invalid inputs

            $json = json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'fields_error',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Failed to ' . strtolower($action) . ' Trip request: ' . $trip['tr_id'] . ' Reason(s): ' . json_encode($json));

            echo $json;
            die();
        } else {


            $requestor_fcm_tokens = $this->fbm->getFirebaseTokens(['ft_token'], NULL, NULL, ['ft_user_id' => [$trip['tr_usr_id']]]);

            $post_comment = strtolower($action) == 'approve' ? $this->input->post('comment') : $this->input->post('dis_comment');

            $comment .= !empty($post_comment) ? ($post_comment . "\n") : "";

            $comment .= '<b>' . ucwords($fullname) . '</b>' . ' - ' . $usn . " - " . date('Y-m-d H:i:s') . "\n";

            // If comment not empty append with previous
            $comment .= !empty($approval['auth_comment']) ? "\n" . $approval['auth_comment'] : "";

            $approval_data = [
                'auth_approved_date' => date('Y-m-d H:i:s'),
                'auth_comment' => $comment,
                'auth_status' => $status
            ];


            //echo json_encode(['status' => ['error' => false],'data' => $approval_data]);            die();


            $res = $this->approval->updateApprovalStatus(['approval_data' => $approval_data, 'approval' => $approval]);


            if ($res) {

                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Successfully ' . strtolower($action) . 'd trip request: ' . $trip['tr_id']);
                // Notify requestor by push notification

                if ($requestor_fcm_tokens) {
                    $payload = [
                        'msg' => 'Your trip request has been '.$action.'d',
                        'tr_id' => $trip['tr_id'],
                        'title' => 'Trip Request Approval',
                        'type' => 'TR_APPROVAL'
                    ];
                    $this->sendPush($payload, array_column($requestor_fcm_tokens, 'ft_token'), $usn);
                }

                $sms_sender = $this->utl->getSetValue('SMS_SENDER');
                $this->utl->saveMessage([
                    'sms_msisdn' => '+' . cus_phone_with_255($trip['dp_phone_number']),
                    'sms_from' => $sms_sender,
                    'sms_text' => $sms_contractor,
                    'sms_rec_date' => date('Y-m-d H:i:s'),
                    'sms_sent_time' => NULL
                ]);
                $this->usr->setSessMsg('Trip request ' . strtolower($action) . 'd successfully', 'success');
                $json = json_encode([
                    'status' => ['error' => FALSE, 'redirect' => TRUE, 'redirect_url' => site_url('trip/previewrequest/' . $trip['tr_id'])]
                ]);
                echo $json;
            } else {
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Failed to ' . strtolower($action) . ' Trip Request : ' . $trip['tr_id']);
                cus_json_error('Approval status was not updated');
            }
        }
    }

}
