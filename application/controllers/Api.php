<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
    }

    public function getApiUrl() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        echo json_encode([
            'status' => ['error' => FALSE],
            'api_url' => API_URL
        ]);
    }

    public function checkIfAppIsLatest() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $app_is_latest = TRUE;

        $app_platform = $this->input->post('app_platform');
        $current_app_version = strtolower($app_platform) == 'ios' ? $this->utl->getSetValue('CURRENT_APP_VERSION_IOS') : $this->utl->getSetValue('CURRENT_APP_VERSION_ANDROID');

        $app = [
            'app_name' => $this->input->post('app_name'),
            'app_version_code' => $this->input->post('app_version_code'),
            'app_version' => $this->input->post('app_version'),
            'app_package_name' => $this->input->post('app_package_name')
        ];


        if (version_compare($current_app_version['st_value'], $app['app_version']) > 0) {
            $app_is_latest = FALSE;
        }

        $json = json_encode([
            'status' => ['error' => FALSE],
            'app_status' => [
                'app_is_latest' => $app_is_latest,
                'app_package_name' => APP_PACKAGE_NAME,
                'app_id' => ''
            ],
            'current_app_version' => $current_app_version['st_value'],
            'platform' => $app_platform
        ]);

        log_message(SYSTEM_LOG, 'Checking app version ... FROM: ' . $json);

        echo $json;
        die();
    }

    public function getDepartments() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');
        $depts = $this->mnt->getDepartments();
        $json = [
            'status' => [
                'error' => FALSE,
            ],
            'depts' => $depts
        ];
        echo json_encode($json);
        die();
    }

    public function clearRequestAttachments() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $user_id = $this->input->post('user_id');

        $attachments = $this->utl->getAttachments(NULL, ['att.att_type' => 'TRIP_REQUEST', 'att.att_status' => '0', 'att_usr_id' => $user_id]);

        if ($attachments) {
            $att_ids = array_column($attachments, "att_id");
            $this->utl->removeAttachments($att_ids);
        }

        $json = [
            'status' => [
                'error' => FALSE,
            ]
        ];
        echo json_encode($json);
        die();
    }

    public function deleteUploadedFile() {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $user_id = $this->input->post('user_id');
        $att_id = $this->input->post('att_id');
        $att_type = $this->input->post('att_type');
        $ref = null;
        $path = "";


        switch ($att_type) {
            case 'MEDICAL_FITNESS':
                $attachment = $this->utl->getAttachments(NULL, ['att.att_type' => $att_type, 'att.att_id' => $att_id], 1);
                $ref = $user_id;
                $path = FCPATH . 'uploads/medical/';
                break;

            case 'DRIVER_LICENSE':
                $attachment = $this->utl->getAttachments(NULL, ['att.att_type' => $att_type, 'att.att_id' => $att_id], 1);
                $ref = $user_id;
                $path = FCPATH . 'uploads/license/';
                break;

            case 'TRIP_REQUEST':
                $attachment = $this->utl->getAttachments(NULL, ['att.att_type' => $att_type, 'att.att_id' => $att_id], 1);
                $ref = $user_id;
                $path = FCPATH . 'uploads/request/';
                break;

            default:
                $attachment = FALSE;
                break;
        }


        if (!$attachment) {
            cus_json_error('Cant remove file');
        }

        $path .= $attachment['att_name'];

        log_message(SYSTEM_LOG, $path);

        $res = $this->utl->removeFile($attachment['att_id']);


        if (!$res) {
            cus_json_error('File not removed');
        }

        if (file_exists($path)) {
            unlink($path);
        }

        $json = [
            'status' => [
                'error' => FALSE,
            ],
            'attachments' => $this->utl->getAttachments(NULL, ['att.att_type' => $att_type, 'att.att_ref' => $ref])
        ];
        echo json_encode($json);
        die();
    }

    public function upload() {

        //set Content-Type to JSON
        header('Content-Type: application/json; charset=utf-8');

        $user_id = $this->uri->segment(4);

        if (!$this->usr->is_logged_in AND empty($user_id)) {
            $err = TRUE;
            $err_msg = MSG_EXPIRY_SESSION;
        }

        if (empty($user_id)) {
            $user_id = $this->usr->user_id;
        }

        //$this->load->library('resize');

        $type = $this->uri->segment(3);
        $err = FALSE;
        $err_msg = "";
        $reference = NULL;

        switch ($type) {
            case 'IMPORT':
                $location = "./uploads/imports/";
                $upload_config = [
                    'upload_path' => $location,
                    'allowed_types' => '*',
                    'max_size' => 1240 * 2,
                    'overwrite' => FALSE,
                    'encrypt_name' => TRUE
                ];

                break;

            case 'DRIVER_LICENSE':
                $location = "./uploads/license/";
                $upload_config = [
                    'upload_path' => $location,
                    'allowed_types' => '*',
                    'max_size' => 1240 * 5,
                    'overwrite' => FALSE,
                    'encrypt_name' => TRUE
                ];
                $reference = $user_id;
                break;

            case 'TRIP_REQUEST':
                $location = "./uploads/request/";
                $upload_config = [
                    'upload_path' => $location,
                    'allowed_types' => '*',
                    'max_size' => 1240 * 5,
                    'overwrite' => FALSE,
                    'encrypt_name' => TRUE
                ];
                $reference = NULL;
                break;

            case 'MEDICAL_FITNESS':
                $location = "./uploads/medical/";
                $upload_config = [
                    'upload_path' => $location,
                    'allowed_types' => '*',
                    'max_size' => 1240 * 5,
                    'overwrite' => FALSE,
                    'encrypt_name' => TRUE
                ];
                $reference = $user_id;
                break;

            default:
                $location = "./uploads/temp/";
                $upload_config = [
                    'upload_path' => $location,
                    'allowed_types' => '*',
                    'max_size' => 1240 * 2,
                    'overwrite' => FALSE,
                    'encrypt_name' => TRUE
                ];
                break;
        }



        // Create folder if no exist
        if (!file_exists($location)) {
            mkdir($location, 0777, true);
        }

        $this->upload->initialize($upload_config);

        if (!$this->upload->do_upload('file')) {
            $err_msg = strip_tags($this->upload->display_errors());
            $err = true;
        }

        $upfile = $this->upload->data('file_name');

        if (!$err) {
            $data = [
                'file_data' => [
                    'att_type' => $type,
                    'att_name' => $upfile,
                    'att_timestamp' => date('Y-m-d H:i:s'),
                    'att_og_name' => 'test',
                    'att_ref' => $reference,
                    'att_usr_id' => $user_id
                ]
            ];

            $res = $this->utl->savetempFile($data);

            if (!$res) {
                http_response_code(401);
                $json = ['status' => 'fail', 'filename' => $upfile, 'error' => 'File was not saved, please try again'];
            } else {
                http_response_code(200);
                $json = [
                    'status' => 'success',
                    'filename' => $upfile,
                    'type' => $type,
                    'att_id' => $res,
                    'att_type' => $type,
                    'attachments' => $this->utl->getAttachments(NULL, ['att.att_ref' => $reference, 'att.att_type' => $type])
                ];
            }
        } else {
            http_response_code(401);
            $json = ['status' => 'fail', 'filename' => $upfile, 'error' => $err_msg];
        }


        //echo error message as JSON
        echo json_encode($json);
    }

    public function requestApproval() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');


        if (empty($this->usr->user_id)) {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $user_id = $this->input->post('user_id');
        } else {
            $user_id = $this->usr->user_id;
        }

        $user = $this->usr->getUserInfo($user_id, 'ID');

        $tr_id = $this->input->post('tr_id');
        $usn = $user['usr_email'];

        $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $tr_id], 1);

        if (!$trip) {
            // trip request was not found so redirect back
            cus_json_error('Trip request was not found or may have been removed from the system');
        }

        if (!in_array(strtolower($trip['tr_status']), ['new', 'paused', 'pending'])) {
            cus_json_error('Trip request is not in the right status to request for approval');
        }


        $driver = $this->driver->getDriverProfiles(NULL, ['dp.dp_usr_id' => $user['usr_id']], 1);
        if (!$driver) {
            cus_json_error('Your driver profile can not be found');
        }
        $timestamp = date('Y-m-d H:i:s');

        if (empty($trip['ap_tr_id'])) {
            //if request has no approval added yet
            $approval_data = [
                'ap_tr_id' => $trip['tr_id'],
                'ap_usr_id' => $driver['usr_id'],
                'ap_sent_time' => $timestamp,
                'ap_status' => 'PENDING',
                'ap_insert_time' => $timestamp
            ];
            $res = $this->approval->saveApprovalStatus([
                'approval_data' => $approval_data,
                'tr_data' => ['tr_status' => 'PENDING'],
                'tr_id' => $trip['tr_id']
            ]);
        } else {
            //if request has na approval already
            $approval_data = [
                'ap_status' => 'PENDING',
                'ap_sent_time' => $timestamp
            ];

            $res = $this->approval->updateApprovalStatus([
                'approval_data' => $approval_data,
                'tr_id' => $trip['tr_id'],
                'ad_name' => $trip['ap_ad_name'],
                'tr_data' => ['tr_status' => 'PENDING']
            ]);
        }

        if (!$res) {
            cus_json_error('Approval request was not sent.');
        }

        $requestor_fcm_tokens = $this->fbm->getFirebaseTokens(['ft_token'], NULL, NULL, ['ft_user_id' => [$driver['dp_ao_ad_name']]]);

        if ($requestor_fcm_tokens) {
            $payload = [
                'msg' => 'You have new trip request to approve',
                'tr_id' => $trip['tr_id'],
                'title' => 'Trip Approval Request',
                'type' => 'TR_APPROVAL'
            ];
            $this->sendPush($payload, array_column($requestor_fcm_tokens, 'ft_token'), $usn);
        }



        $json = [
            'status' => [
                'error' => FALSE,
            ],
            'request' => $this->getRequestAndApprovalDetails($trip['tr_id'], $ad_name)
        ];

        echo json_encode($json);
        die();
    }

    function getRequestAndApprovalDetails($trip_id, $user_id) {

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            cus_json_error("User profile not found. Contact the system admin");
        }

        $cols = [
            'dp.dp_ao_title',
            'dp.dp_status',
            'dp.dp_usr_id',
            'dp.dp_email',
            'dp.dp_full_name',
            'dp.dp_medical_by_osha',
            'dp.dp_medical_date',
            'dp.dp_status',
            'dp.dp_phone_number',
            'dp.dp_license_number',
            'dp.dp_license_expiry',
            'dept.dept_name',
            'tr.tr_usr_id',
            'tr.tr_id',
            'tr.tr_journey_purpose purpose',
            'tr.tr_vehicle_reg_no vehicle_reg_no',
            'tr.tr_vehicle_type vehicle_type',
            'tr.tr_medical_by_osha medical_done_by_osha',
            'tr.tr_reason_finish_after_17 reason',
            'tr.tr_work_finish_time finish_time',
            'tr.tr_difense_driver_training difensive',
            'tr.tr_for_by_for_training four_by_four',
            'tr.tr_suitable_license suitable',
            'tr.tr_fit_for_use fit_for_use',
            'tr.tr_dispatch_time dispatch_time',
            'tr.tr_arraival_time arrival_time',
            'tr.tr_departure_location departure_location',
            'tr.tr_destination_location destination_location',
            'tr.tr_stop_locations stop_locations',
            'tr.tr_distance distance',
            'tr.tr_timestamp timestamp',
            'tr.tr_status status'
        ];

        $trip = $this->trip->getTripRequests($cols, ['tr.tr_id' => $trip_id], 1);

        if (!$trip) {
            // trip request was not found so redirect back
            cus_json_error('Trip request was not found or may have been removed from the system');
        }



        $can_approve = FALSE;
        // Check user approal requests
        $request_to_approve = $this->approval->getRequestApprovals(['auth.auth_tr_id'], "auth.auth_tr_id = '" . $trip['tr_id'] . "' AND auth.auth_status IS NULL AND r.r_notification_status = '1'", NULL, ['auth.auth_usr_title' => $this->usr->getUserApprovalTitles($user['usr_id']), 'tr.tr_status' => ['INPROGRESS']]);

        

        if ($request_to_approve) {
            $can_approve = in_array($trip['tr_id'], array_column($request_to_approve, 'auth_tr_id'));
        }

        // get trip approvals

        $approvals = $this->approval->getRequestRoute(null, ['r.r_tr_id' => $trip['tr_id']]);

        foreach ($approvals as $key => $a) {
            $approvals[$key]['auth_comment'] = strip_tags($a['auth_comment']);
            $approvals[$key]['can_approve'] = ($can_approve AND $a['r_tr_id'] === $trip['tr_id']) ? TRUE : FALSE; //($trip['tr_id'] == $a['ap_tr_id'] && $a['ap_ad_name'] == $ad_name && in_array(strtolower($trip['status']), ['pending'])) ? TRUE : FALSE;
        }

        $trip['stop_locations'] = !empty($trip['stop_locations']) ? $trip['stop_locations'] : 'N/A';
        $trip['dispatch_time'] = cus_nice_timestamp($trip['dispatch_time']);
        $trip['arrival_time'] = cus_nice_timestamp($trip['arrival_time']);
        $trip['dp_license_expiry'] = cus_nice_date($trip['dp_license_expiry']);
        $trip['can_approve_dp'] = (strtolower($trip['dp_ao_title']) == strtolower($user['usr_title']) && in_array(strtolower($trip['dp_status']), ['inprogress'])) ? TRUE : FALSE;

        $trip['is_my_application'] = (strtolower($user_id) == strtolower($trip['tr_usr_id'])) ? TRUE : FALSE;
        $trip['can_edit'] = ($trip['is_my_application'] == TRUE AND in_array(strtolower($trip['status']), ['paused'])) ? TRUE : FALSE;
        $trip['can_request_approval'] = ($trip['is_my_application'] == TRUE AND in_array(strtolower($trip['status']), ['paused'])) ? TRUE : FALSE;

        $trip['attachments'] = $this->utl->getAttachments(NULL, ['att.att_ref' => $trip['tr_id'], 'att.att_type' => 'TRIP_REQUEST']);
        $trip['attachment_counts'] = count($trip['attachments']);


        $trip['approvals'] = $approvals;

        return $trip;
    }

    public function getRequestDetails() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $user_id = $this->input->post('user_id');
        $trip_id = $this->input->post('tr_id');

        $request = $this->getRequestAndApprovalDetails($trip_id, $user_id);

        if (!$request) {
            cus_json_error('Trip request was not found or may have been removed from the system');
        }

        $json = json_encode([
            'status' => ['error' => FALSE],
            'request' => $request,
            'license_attachments' => $this->utl->getAttachments(['att.att_name', 'att.att_id', 'att.att_status', 'att_type'], ['att.att_ref' => $request['dp_usr_id'], 'att.att_type' => 'DRIVER_LICENSE', 'att.att_status' => '1']),
            'medical_attachments' => $this->utl->getAttachments(['att.att_name', 'att.att_id', 'att.att_status', 'att_type'], ['att.att_ref' => $request['dp_usr_id'], 'att.att_type' => 'MEDICAL_FITNESS', 'att.att_status' => '1'])
        ]);

        echo $json;
        die();
    }

    public function getTripReuests() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');


        $_POST = json_decode(file_get_contents('php://input'), true);

        $type = $this->input->post('type');
        $user_id = $this->input->post('user_id');

        $select_columns = [
            'tr.tr_destination_location',
            'tr.tr_status', 'tr.tr_arraival_time',
            'tr.tr_dispatch_time',
            'tr.tr_journey_purpose',
            'tr.tr_id',
            'tr.tr_timestamp',
            'dp.dp_full_name',
            'dp.dp_email',
            'tr.tr_vehicle_type',
            'tr.tr_vehicle_reg_no'
        ];

        switch ($type) {

            // Geting all trips if type is all
            case 'ALL':
                $datatables = [
                    'select_columns' => $select_columns,
                    'search_columns' => [
                        'tr.tr_ad_name', 'dp.dp_full_name', 'tr.tr_journey_purpose'
                    ],
                    'order_columns' => [],
                    'default_order_column' => [
                        'tr.tr_timestamp' => 'DESC'
                    ],
                    'cond' => NULL,
                    'where_in' => ['tr.tr_status' => ['COMPLETED', 'APPROVED', 'INPROGRESS']]
                ];
                break;

            case 'MY':
                $datatables = [
                    'select_columns' => $select_columns,
                    'search_columns' => [
                        'tr.tr_ad_name', 'dp.dp_full_name'
                    ],
                    'order_columns' => [],
                    'default_order_column' => [
                        'tr.tr_timestamp' => 'DESC'
                    ],
                    'default_order_column' => [
                        'tr.tr_timestamp' => 'DESC'
                    ],
                    'cond' => ['tr.tr_usr_id' => $user_id],
                    'where_in' => NULL
                ];
                break;

            case 'INCOMING':

                $request_to_approve = $this->approval->getRequestApprovals(['auth.auth_tr_id'], "auth.auth_status IS NULL AND r.r_notification_status = '1'", NULL, ['auth.auth_usr_title' => $this->usr->getUserApprovalTitles($user_id), 'tr.tr_status' => ['INPROGRESS']]);

                if ($request_to_approve) {
                    $tr_ids = array_column($request_to_approve, "auth_tr_id");
                } else {
                    $tr_ids = FALSE;
                }
                
                $datatables = [
                    'select_columns' => $select_columns,
                    'search_columns' => [
                        'tr.tr_ad_name', 'dp.dp_full_name'
                    ],
                    'order_columns' => [],
                    'default_order_column' => [
                        'tr.tr_timestamp' => 'DESC'
                    ],
                    'default_order_column' => [
                        'tr.tr_timestamp' => 'DESC'
                    ],
                    'cond' => NULL,
                    'where_in' => ['tr.tr_status' => ['INPROGRESS'], 'tr.tr_id' => $tr_ids]
                ];
                break;


            default:
                break;
        }

        $list = $this->trip->get_datatables_trips($datatables);
        $requests = [];

        foreach ($list as $a) {

            $row = [
                'tr_id' => $a->tr_id,
                'fullname' => $a->dp_full_name,
                'purpose' => $a->tr_journey_purpose,
                'request_status' => $a->tr_status,
                'ionic_color' => cus_ionic_color($a->tr_status),
                'request_date' => cus_nice_timestamp($a->tr_timestamp),
                'requested_vehicle' => $a->tr_vehicle_type . ' - ' . $a->tr_vehicle_reg_no
            ];

            $requests[] = $row;
        }

        $output = array(
            "status" => ['error' => FALSE],
            "recordsTotal" => $this->trip->count_all_trips($datatables),
            "recordsFiltered" => $this->trip->count_filtered_trips($datatables),
            "list" => $requests,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function getSections() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $sections = $this->mnt->getSections(NULL, ['sec.sec_dept_id' => $this->uri->segment(3)]);

        $json = [
            'status' => [
                'error' => FALSE,
            ],
            'sections' => $sections
        ];

        echo json_encode($json);
        die();
    }

    public function submitApproveDriverProfile() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $tr_id = 0;
        // Check user session status and the platform used
        if (!empty($_POST) && !$this->usr->is_logged_in) {
            $this->usr->setSessMsg(MSG_EXPIRY_SESSION, 'error', 'user');
        } elseif (empty($_POST)) {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $user_id = $this->input->post('user_id');
        } else {
            $user_id = $this->usr->user_id;
            $tr_id = $this->input->post('tr_id');
        }

        $user = $this->usr->getUserInfo($user_id, 'ID');

        $usn = $user['usr_email'];

        $driver_user_id = $this->input->post('driver_usr_id');

        $driver = $this->driver->getDriverProfiles(NULL, ['dp_usr_id' => $driver_user_id], 1);

        if (!$driver) {
            cus_json_error('Driver profile was not found or it may have been removed from the system');
        }

        if (strtolower($user['usr_id']) == $driver['dp_usr_id']) {
            cus_json_error('Access denied');
        }

        if (in_array(strtolower($driver['dp_status']), ['APPROVED'])) {
            cus_json_error('Driver profile is alread approved');
        }


        $res = $this->driver->updateDriverDetails(['driver_data' => ['dp_status' => 'APPROVED']], $driver['dp_usr_id']);

        if (!$res) {
            cus_json_error("Nothing was updated");
        }


        $this->usr->setSessMsg('Driver profile updated successfully. You may now proceed with trip request approval.', 'success');

        echo json_encode([
            'status' => [
                'error' => FALSE,
                'redirect' => TRUE,
                'redirect_url' => site_url('trip/previewrequest/' . $tr_id)
            ]
        ]);
    }

    public function submitApproveRequest() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');


        // Check user session status and the platform used
        if (!empty($_POST) && !$this->usr->is_logged_in) {
            $this->usr->setSessMsg(MSG_EXPIRY_SESSION, 'error', 'user');
        } elseif (empty($_POST)) {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $trip_id = $this->input->post('tr_id');
            $usn = $this->input->post('ad_name');
        } else {
            $usn = $this->usr->user_ad_name;
            $trip_id = $this->uri->segment(3);
        }

        $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $trip_id], 1);



        if (!$trip) {
            // trip request was not found so redirect back
            cus_json_error('Trip request was not found or may have been removed from the system');
        }

        $approver = $this->approval->getApprovalOfficials(NULL, ['ao_ad_name' => $usn], 1);

        if (!$approver) {
            cus_json_error('Access denied.');
        }

        $approval_status = $this->approval->getRequestApprovals(NULL, ['ap.ap_ad_name' => $approver['ao_ad_name'], 'ap.ap_tr_id' => $trip['tr_id']], 1);

        if (!$approval_status) {
            cus_json_error('Access denied. You are not the right person to approve this trip request.');
        }


        if (in_array(strtolower($approval_status['ap_status']), ['approved', 'disapproved'])) {
            cus_json_error('Looks like this trip request has been approved or dissaproved, Please review the details');
        }

        $driver = $this->driver->getDriverProfiles(['dp_status'], ['dp_usr_id' => $trip['tr_usr_id']], 1);

        if (!$driver) {
            cus_json_error('Driver profile was not found. Contact the system admin.');
        }

        if (in_array(strtolower($driver['dp_status']), ['pending'])) {
            cus_json_error('You should approve driver profile before approving this trip request.');
        }


        $validations = [
            ['field' => 'comment', 'label' => 'Approval Comment', 'rules' => 'trim']
        ];

        $this->form_validation->set_rules($validations);

        log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Attempting to approve trip request');

        if ($this->form_validation->run() == FALSE) {
            // Invalid inputs
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Failed to approve trip request');
            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'fields_error',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            die();
        } else {


            $requestor_fcm_tokens = $this->fbm->getFirebaseTokens(['ft_token'], NULL, NULL, ['ft_user_id' => [$trip['tr_ad_name']]]);

            $post_comment = $this->input->post('comment');
            $comment = "";
            $comment .= "APPROVED\n";
            $comment .= !empty($post_comment) ? ($post_comment . "\n") : "";

            $comment .= '<b>' . $approver['ao_ad_name'] . '</b>' . ' - ' . $approver['ao_email'] . "\n" . date('Y-m-d H:i:s') . "\n";

            if (!empty($trip['ap_comments'])) {
                $comment .= "\n\n\n" . $trip['ap_comments'];
            }

            $approval_data = [
                'ap_approval_time' => date('Y-m-d H:i:s'),
                'ap_comments' => $comment,
                'ap_status' => 'APPROVED'
            ];

            $res = $this->approval->updateApprovalStatus(['approval_data' => $approval_data, 'tr_data' => ['tr_status' => 'APPROVED'], 'tr_id' => $trip['tr_id'], 'ad_name' => $usn]);

            if ($res) {

                // Notify requestor by push notification
                if ($requestor_fcm_tokens) {
                    $payload = [
                        'msg' => 'Your trip request has been approved successfully',
                        'tr_id' => $trip['tr_id'],
                        'title' => 'Trip Request Approval',
                        'type' => 'TR_APPROVAL'
                    ];
                    $this->sendPush($payload, array_column($requestor_fcm_tokens, 'ft_token'), $usn);
                }

                $this->usr->setSessMsg('Trip request approved successfully', 'success');
                $json = json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => TRUE,
                        'redirect_url' => site_url('trip/previewrequest/' . $trip['tr_id'])
                    ],
                    'approval' => $approval_status,
                    'request' => $this->getRequestAndApprovalDetails($trip['tr_id'], $trip['tr_ad_name'])
                ]);

                echo $json;
            } else {
                cus_json_error('Approval status was not updated');
            }
        }
    }

    public function submitDisapproveRequest() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');


        // Check user session status and the platform used
        if (!empty($_POST) && !$this->usr->is_logged_in) {
            $this->usr->setSessMsg(MSG_EXPIRY_SESSION, 'error', 'user');
        } elseif (empty($_POST)) {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $trip_id = $this->input->post('tr_id');
            $usn = $this->input->post('ad_name');
            $field = 'comment';
        } else {
            $usn = $this->usr->user_ad_name;
            $trip_id = $this->uri->segment(3);
            $field = 'dis_comment';
        }

        $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $trip_id], 1);

        if (!$trip) {
            // trip request was not found so redirect back
            cus_json_error('Trip request was not found or may have been removed from the system');
        }


        $approver = $this->approval->getApprovalOfficials(NULL, ['ao_ad_name' => $usn], 1);

        if (!$approver) {
            cus_json_error('Access denied.');
        }

        $approval_status = $this->approval->getRequestApprovals(NULL, ['ap.ap_ad_name' => $approver['ao_ad_name'], 'ap.ap_tr_id' => $trip['tr_id']], 1);

        if (!$approval_status) {
            cus_json_error('Access denied. You are not the right person to approve this trip request.');
        }


        if (in_array(strtolower($approval_status['ap_status']), ['approved', 'disapproved'])) {
            cus_json_error('Looks like this trip request has been approved or dissaproved, Please review the details');
        }

        $validations = [
            ['field' => $field, 'label' => 'Disapproval Comment', 'rules' => 'trim|required']
        ];

        $this->form_validation->set_rules($validations);

        log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Attempting to approve trip request');

        if ($this->form_validation->run() == FALSE) {
            // Invalid inputs
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => api/submitLogin => ' . $usn . ' - Failed to approve trip request');
            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'fields_error',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            die();
        } else {

            $requestor_fcm_tokens = $this->fbm->getFirebaseTokens(['ft_token'], NULL, NULL, ['ft_user_id' => [$trip['tr_ad_name']]]);

            $post_comment = $this->input->post('dis_comment');
            $comment = "";
            $comment .= "DISAPPROVED\n";
            $comment .= !empty($post_comment) ? $post_comment . "\n" : "";

            $comment .= '<b>' . $approver['ao_full_name'] . '</b>' . ' - ' . $approver['ao_email'] . "\n" . date('Y-m-d H:i:s') . "\n";

            if (!empty($trip['ap_comments'])) {
                $comment .= "\n\n\n" . $trip['ap_comments'];
            }

            $approval_data = [
                'ap_approval_time' => date('Y-m-d H:i:s'),
                'ap_comments' => $comment,
                'ap_status' => 'DISAPPROVED'
            ];

            $res = $this->approval->updateApprovalStatus(['approval_data' => $approval_data, 'tr_data' => ['tr_status' => 'DISAPPROVED'], 'tr_id' => $trip['tr_id'], 'ad_name' => $usn]);

            if ($res) {

                // Notify requestor by push notification
                if ($requestor_fcm_tokens) {
                    $payload = [
                        'msg' => 'Your trip request has been disapproval',
                        'tr_id' => $trip['tr_id'],
                        'title' => 'Trip Request Disapproval',
                        'type' => 'TR_APPROVAL'
                    ];
                    $this->sendPush($payload, array_column($requestor_fcm_tokens, 'ft_token'), $usn);
                }


                $this->usr->setSessMsg('Trip request disapproved successfully', 'success');
                $json = json_encode([
                    'status' => ['error' => FALSE, 'redirect' => TRUE, 'redirect_url' => site_url('trip/previewrequest/' . $trip['tr_id'])],
                    'approval' => $approval_status,
                    'request' => $this->getRequestAndApprovalDetails($trip['tr_id'], $trip['tr_ad_name'])
                ]);
                echo $json;
            } else {
                cus_json_error('Approval status was not updated');
            }
        }
    }

    public function getDriverDetails() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $user_id = $this->input->post('user_id');

        $driver = $this->driver->getDriverProfiles(NULL, ['dp_usr_id' => $user_id], 1);

        if (!$driver) {
            cus_json_error('Drivers profile not found.');
        }

        $driver['ao_full_name'] = "";
        $driver['ao_title'] = "";
        $driver['ao_phone_number'] = "";

        $line_managers = $this->usr->getUsersList("usr_title IS NOT NULL AND usr_role IN ('ADMIN','MANAGER')", ['usr_phone', 'usr_title', 'usr_fullname', 'usr_email ao_email', 'usr_ad_name ao_ad_name', 'usr_fullname ao_full_name']);

        foreach ($line_managers as $key => $ln) {
            $line_managers[$key]['ao_full_name'] = $ln['usr_fullname'] . ' - ' . $ln['usr_title'];
            if (strtolower($driver['dp_ao_title']) == strtolower($ln['usr_title'])) {
                $driver['ao_full_name'] = $ln['usr_fullname'];
                $driver['ao_title'] = $ln['usr_title'];
                $driver['ao_phone_number'] = cus_phone_with_255($ln['usr_phone']);
            }
        }

        $json = [
            'status' => [
                'error' => FALSE
            ],
            'driver_details' => $driver,
            'line_managers' => $line_managers,
            'medical_attachments' => $this->utl->getAttachments(NULL, ['att.att_type' => 'MEDICAL_FITNESS', 'att.att_ref' => $driver['dp_usr_id']]),
            'license_attachments' => $this->utl->getAttachments(NULL, ['att.att_type' => 'DRIVER_LICENSE', 'att.att_ref' => $driver['dp_usr_id']])
        ];
        echo json_encode($json);
        die();
    }

    public function submitDriverDetails() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $type = NULL;

        // If post variable is empty the request could be from mobile app
        if (empty($_POST)) {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $user_id = $this->input->post('user_id');
        } else {
            $user_id = $this->usr->user_id;
            $type = 'WEB';
        }

        $user = $this->usr->getUserInfo($user_id, 'ID');

        $usn = $user['usr_email'];

        $validations = [
            ['field' => 'name', 'label' => 'driver full name', 'rules' => 'trim|required'],
            ['field' => 'phone', 'label' => 'phone number', 'rules' => 'trim|required|numeric|callback_validateDriverPhoneNumber'],
            ['field' => 'email', 'label' => 'email address', 'rules' => 'trim|required|valid_email|callback_validateDriverEmail'],
            ['field' => 'dept', 'label' => 'department', 'rules' => 'trim|required'],
            ['field' => 'section', 'label' => 'section', 'rules' => 'trim|required'],
            //['field' => 'medical_by_osha', 'label' => 'medical done by osha', 'rules' => 'trim|required|callback_validateYesNo'],
            //['field' => 'medical_fitness_date', 'label' => 'medical fitness date', 'rules' => 'trim|callback_validateMedicalFitnessDate'],
            //['field' => 'medical_file_attachment', 'label' => 'medical fitness report', 'rules' => 'callback_validateMedicalFile'],
            ['field' => 'manager', 'label' => 'line manager', 'rules' => 'trim|required|callback_validateLineManager'],
            ['field' => 'license_attachment', 'label' => 'license attachment', 'rules' => 'callback_validateLicenseAttachment'],
            ['field' => 'license', 'label' => 'driver licence number', 'rules' => 'trim|required|callback_validateDriverLicence'],
            ['field' => 'license_expiry', 'label' => 'license expiry date', 'rules' => 'trim|required|callback_validateLicenseExpiry'],
        ];

        $this->form_validation->set_rules($validations);

        log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Submitting drivers details');

        if ($this->form_validation->run() == FALSE) {
            // Invalid inputs
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Failed to save driver details');
            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'fields_error',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            die();
        } else {

            $phone_number = $this->input->post('phone');
            $license_expiry = str_replace('/', '-', $this->input->post('license_expiry'));
            //$mf_date = str_replace('/', '-', $this->input->post('medical_fitness_date'));
            $timestamp = date('Y-m-d H:i:d');
            //$medical_by_osha = $this->input->post('medical_by_osha');




            $license_attachments = $this->utl->getAttachments(NULL, ['att_type' => 'DRIVER_LICENSE', 'att_status' => '0', 'att_ref' => $user['usr_id']]);
            $medical_attachments = $this->utl->getAttachments(NULL, ['att_type' => 'MEDICAL_FITNESS', 'att_status' => '0', 'att_ref' => $user['usr_id']]);


            $driver_data = [
                'dp_phone_number' => cus_phone_with_255($phone_number),
                'dp_full_name' => $this->input->post('name'),
                'dp_email' => $this->input->post('email'),
                'dp_dept_id' => $this->input->post('dept'),
                'dp_section_id' => $this->input->post('section'),
                'dp_license_number' => $this->input->post('license'),
                'dp_license_expiry' => date('Y-m-d', strtotime($license_expiry)),
                'dp_updated_time' => $timestamp,
                'dp_status' => 'PENDING',
                'dp_ao_title' => $this->input->post('manager'),
                    //'dp_medical_by_osha' => $medical_by_osha,
                    //'dp_medical_date' => strtolower($medical_by_osha) == 'yes' ? date('Y-m-d', strtotime($mf_date)) : NULL
            ];

            $data = [
                'driver_data' => $driver_data,
                'user_id' => $user['usr_id'],
                'user_email' => $user['usr_email'],
                'timestamp' => $timestamp,
                'license_attachments' => $license_attachments,
                'medical_attachments' => $medical_attachments
            ];

            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Submitted data :: ' . json_encode($data));

            $res = $this->driver->saveDriverDetails($data);

            if (!$res) {
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - driver profile was not updated');
                cus_json_error('Nothing was updated.');
            }

            //Stuff went well lets get it.

            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - updated the driver profile successfully');



            // Get the driver info
            $driver = $this->driver->getDriverProfiles(NULL, ['dp.dp_usr_id' => $user['usr_id']], 1);

            if (!$driver) {
                cus_json_error('Something went wrong please try again');
            }

            // Prepare data to continue

            $driver_details = [
                "name" => $driver['dp_full_name'],
                "phone" => $driver["dp_phone_number"],
                "manager" => $driver['dp_ao_title'],
                "medical_by_osha" => $driver['dp_medical_by_osha'],
                "medical_fitness_date" => $driver['dp_medical_date'],
                "email" => $driver["dp_email"],
                "dept" => $driver["dp_dept_id"],
                "section" => $driver["dp_section_id"],
                "license" => $driver["dp_license_number"],
                "license_expiry" => date('Y-m-d', strtotime($driver["dp_license_expiry"])),
                "licence_attachments" => [],
                "line_manager" => $driver['usr_fullname'] . ' - ' . $driver['usr_title'],
                "dept_section" => $driver['dept_name'] . ' - ' . $driver['sec_name']
            ];




            $this->usr->setSessMsg('Driver profile updated successfully', 'success');

            if ($type == 'WEB') {
                $user_session = $this->session->userdata['logged_in'];
                $user_session['user_page'] = "HOME";
                $this->usr->setSessMsg('Driver profile updated successfully', 'success');
                $this->session->set_userdata(['logged_in' => $user_session]);
            }

            $json = [
                'status' => ['error' => FALSE, 'redirect' => TRUE, 'redirect_url' => site_url('driver/updateprofile')],
                'driver_details' => $driver_details,
                'line_managers' => $this->usr->getUsersList("usr_title IS NOT NULL AND usr_role IN ('ADMIN','MANAGER')", ['usr_title', 'usr_ad_name', 'usr_fullname'])
            ];

            echo json_encode($json);
        }
    }

    public function submitRequestTrip() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        // If post variable is empty the request could be from mobile app
        if (empty($_POST)) {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $user_id = $this->input->post('user_id');
        } else {
            $user_id = $this->usr->user_id;
        }

        $user = $this->usr->getUserInfo($user_id, 'ID');

        $usn = $user['usr_email'];

        $edit_id = $this->input->post('edit_id');


        // Check if its in edit mode
        if (!empty($edit_id)) {

            $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $edit_id, 'tr.tr_usr_id' => $user['usr_id']], 1);

            if (!$trip) {
                cus_json_error('Trip was not found or may have been removed from the system');
            }

            if (!in_array(strtolower($trip['tr_status']), ['paused', 'new', 'pending'])) {
                cus_json_error('Trip request is not in the right state to be edited');
            }

            $mode = 'edit';
        } else {
            $mode = 'add';
        }
        $validations = [
            ['field' => 'journey_purpose', 'label' => 'journey purpose', 'rules' => 'trim|required'],
            ['field' => 'vehicle_reg_number', 'label' => 'vehicle registration number', 'rules' => 'trim|required'],
            //['field' => 'medical_by_osha', 'label' => 'medical done by osha', 'rules' => 'trim|required', 'errors' => ['required' => 'You should select whether driver medical fitness assessment has done by OSHA']],
            ['field' => 'reason_finish_after_17', 'label' => 'reason', 'rules' => 'trim|callback_validateWorkFinishAfter17h00'],
            ['field' => 'work_finish_time', 'label' => '', 'rules' => 'trim|required|callback_validateYesNo', 'errors' => ['required' => 'You should select whether work will finish after 17h00']],
            ['field' => 'vehicle_type', 'label' => 'vehicle type', 'rules' => 'trim|required'],
            ['field' => 'difense_driver_training', 'label' => 'difense driver training', 'rules' => 'trim|required', 'errors' => ['required' => 'You should select whether driver has attended defensive driver training']],
            ['field' => 'for_by_for_training', 'label' => '4X4 off road driver training', 'rules' => 'trim|required', 'errors' => ['required' => 'You should select whether driver has attended 4X4 off road driving training']],
            ['field' => 'suitable_license', 'label' => '4X4 off road driver training', 'rules' => 'trim|required', 'errors' => ['required' => 'You should select whether driver\'s license is suitable for vehicle being used']],
            ['field' => 'fit_for_use', 'label' => 'vehicle fit for intended use', 'rules' => 'trim|required'],
            ['field' => 'dispatch_time', 'label' => 'departure time', 'rules' => 'trim|required'],
            ['field' => 'arraival_time', 'label' => 'arrival time', 'rules' => 'trim|required'],
            ['field' => 'departure_location', 'label' => 'departure location', 'rules' => 'trim|required'],
            ['field' => 'destination_location', 'label' => 'destination location', 'rules' => 'trim|required'],
            ['field' => 'stop_locations', 'label' => 'stop locations and reason', 'rules' => 'trim'],
            ['field' => 'distance', 'label' => 'distance covered', 'rules' => 'trim|required|numeric|callback_validateDistance']
        ];

        if ($mode == 'add') {
            $validations[] = ['field' => 'file', 'label' => 'attachment', 'rules' => 'callback_validateAttachment'];
        }

        $this->form_validation->set_rules($validations);



        log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Submitting drivers details : ' . $mode . ' MODE');

        if ($this->form_validation->run() == FALSE) {
            // Invalid inputs
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Failed to save driver details');
            $json = json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'fields_error',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Failure reasons : ' . $json);
            echo $json;

            die();
        } else {

            $driver = $this->driver->getDriverProfiles(NULL, ['dp.dp_usr_id' => $user['usr_id']], 1);


            if (!$driver) {
                cus_json_error("Driver profile not exist");
            }

            $work_finish_time = $this->input->post('work_finish_time');
            $reason_finish_after_17 = $this->input->post('reason_finish_after_17');

            if (strtolower($work_finish_time) == 'NO') {
                $reason_finish_after_17 = NULL;
            }

            $dispatch_time = str_replace('/', '-', $this->input->post('dispatch_time'));
            $arrival_time = str_replace('/', '-', $this->input->post('arraival_time'));


            $ma = $this->driver->getDriverMedicalAssessment(["ma.ma_date"], "ma.ma_date <='" . date('Y-m-d', strtotime($arrival_time)) . "'", 1);
            $dp = $this->driver->getDriverProfiles(["dp.dp_license_number"], "dp.dp_license_number <= '" . date('Y-m-d', strtotime($arrival_time)) . "'", 1);

            if (!$dp) {
                cus_json_error("Driver licence is not valid to be used for the selected date");
            }

            $trip_data = [
                'tr_journey_purpose' => $this->input->post('journey_purpose'),
                'tr_vehicle_reg_no' => $this->input->post('vehicle_reg_number'),
                'tr_medical_by_osha' => $ma ? 'YES' : 'NO', //$driver['dp_medical_by_osha']
                'tr_reason_finish_after_17' => $reason_finish_after_17,
                'tr_work_finish_time' => $work_finish_time,
                'tr_vehicle_type' => $this->input->post('vehicle_type'),
                'tr_difense_driver_training' => $this->input->post('difense_driver_training'),
                'tr_for_by_for_training' => $this->input->post('for_by_for_training'),
                'tr_suitable_license' => $this->input->post('suitable_license'),
                'tr_fit_for_use' => $this->input->post('fit_for_use'),
                'tr_dispatch_time' => date('Y-m-d H:i:s', strtotime($dispatch_time)),
                'tr_arraival_time' => date('Y-m-d H:i:s', strtotime($arrival_time)),
                'tr_departure_location' => $this->input->post('departure_location'),
                'tr_destination_location' => $this->input->post('destination_location'),
                'tr_stop_locations' => $this->input->post('stop_locations'),
                'tr_distance' => (int) $this->input->post('distance'),
                'tr_timestamp' => date('Y-m-d H:i:s'),
                'tr_status' => 'PAUSED',
                'tr_usr_id' => $user['usr_id']
            ];

            $data = ['trip_data' => $trip_data, 'mode' => $mode, 'tr_id' => $edit_id, 'ma' => $ma];
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Saving trip data : ' . json_encode($data));

            $res = $this->trip->saveTrip($data);

            if (!$res) {

                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Trip data not saved');
                // failed to save trip details
                cus_json_error('Unable to save your trip details, Pleas try again.');
            }
            $this->usr->setSessMsg('Trip request was ' . $mode . 'ed successfully. Cofirm the details and request for approval', 'success');
            $json = [
                'status' => ['error' => FALSE, 'redirect' => TRUE, 'redirect_url' => site_url('trip/previewrequest/' . $res)],
                'tr_id' => $res
            ];

            echo json_encode($json);

            die();
        }
    }

    public function validateUsn($usn) {
        if (empty($usn)) {
            return TRUE;
        }
        return TRUE;
    }

    public function validatePwd($pwd) {

        if (empty($pwd)) {
            return TRUE;
        }

        if (!$this->validateAd('', '')) {
            $this->form_validation->set_message('validatePwd', 'Invalid username or passowrd');
            return FALSE;
        }

        return TRUE;
    }

    public function validateDriverEmail($email) {

        if ($this->usr->is_logged_in) {
            $user_id = $this->usr->user_id;
        } else {
            $user_id = $this->input->post('user_id');
        }

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (empty($email)) {
            return TRUE;
        }

        $driver = $this->driver->getDriverProfiles(NULL, ['dp_usr_id <>' => $user['usr_id'], 'dp_email' => $email], 1);
        if ($driver) {
            $this->form_validation->set_message('validateDriverEmail', 'Email address is being used by other driver');
            return FALSE;
        }

        return TRUE;
    }

    public function validateDriverPhoneNumber($phone) {

        if ($this->usr->is_logged_in) {
            $user_id = $this->usr->user_id;
        } else {
            $user_id = $this->input->post('user_id');
        }

        $user = $this->usr->getUserInfo($user_id, 'ID');


        if (empty($phone)) {
            return TRUE;
        }

        $driver = $this->driver->getDriverProfiles(NULL, ['dp_usr_id <>' => $user['usr_id'], 'dp_phone_number' => cus_phone_with_255($phone)], 1);

        if ($driver) {
            $this->form_validation->set_message('validateDriverPhoneNumber', 'Phone number  is being used by other driver');
            return FALSE;
        }
        return TRUE;
    }

    public function validateDriverLicence($license) {

        if ($this->usr->is_logged_in) {
            $user_id = $this->usr->user_id;
        } else {
            $user_id = $this->input->post('user_id');
        }

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (empty($license)) {
            return TRUE;
        }
        $driver = $this->driver->getDriverProfiles(NULL, ['dp_usr_id <>' => $user['usr_id'], 'dp_license_number' => $license], 1);
        if ($driver) {
            $this->form_validation->set_message('validateDriverLicence', 'License number is being used by other driver');
            return FALSE;
        }
        return TRUE;
    }

    public function validateLicenseExpiry($license_expiry) {

        //$user_id = $this->input->post('user_id');
        if (empty($license_expiry)) {
            return TRUE;
        }

        $license_expiry = str_replace('/', '-', $license_expiry);

        if (time() > strtotime($license_expiry)) {
            $this->form_validation->set_message(__FUNCTION__, 'License is already expired');
            return FALSE;
        }
        return TRUE;
    }

    public function validateLicense($license) {
        return TRUE;
    }

    public function validateAd($user_ref, $pass) {

        if (TESTING_MODE) {
            return TRUE;
        }

        /*
          $user = $this->usr->getUserInfo($user_ref, 'AD');

          if ($user) {
          // Login in AD
          // Connect to AD
          $ad = @ldap_connect("ldap://10.10.87.29:389");

          // Check connection status
          if (!$ad) {
          log_message(SYSTEM_LOG, 'user/validateAd - ' . $user['usr_email'] . ' ' . $this->input->ip_address() . 'Could not connect to AD');
          return FALSE;
          }

          // Bind LDAP
          ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
          $bd = @ldap_bind($ad, $user_ref . "@VODACOMTZ.CORP", $pass);


          // Checks login
          if (!$bd) {
          //Invalid credentials
          log_message(SYSTEM_LOG, 'user/validateAd - ' . $user['usr_email'] . ' ' . $this->input->ip_address() . 'Failed to login user to AD');

          return FALSE;
          }

          ldap_unbind($ad);
          }

          return TRUE;
         * 
         * 
         */
    }

    public function validateWorkFinishAfter17h00($reason) {

        $work_time = $this->input->post('work_finish_time');

        if (strtolower($work_time) == 'yes' AND empty($reason)) {

            $this->form_validation->set_message('validateWorkFinishAfter17h00', 'You should enter the reason if work will finish after 17h00');
            return FALSE;
        }

        return TRUE;
    }

    public function validateYesNo($ye_no) {
        if (empty($ye_no)) {
            return TRUE;
        }

        if (!in_array(strtolower($ye_no), ['yes', 'no'])) {
            $this->form_validation->set_message(__FUNCTION__, 'Select a valid option');
            return FALSE;
        }

        return TRUE;
    }

    public function validateDistance($distance) {

        if (empty($distance)) {
            return true;
        }

        if ((int) $distance < 150) {
            $this->form_validation->set_message(__FUNCTION__, 'Estimated travelling distance must be greater than 150km to request a trip');
            return FALSE;
        }

        return TRUE;
    }

    public function logout() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $ad_name = $this->input->post('ad_name');
        $key = $this->input->post('key');
        $firebase_token = $this->input->post('firebase_token');

        $session_status = $this->usr->validateSession($ad_name, $key);

        if ($session_status) {
            // Do sometging here
            //jo_json_general_error('Seomething went wrong.. Please Re-Open JO App');
        }

        $this->fbm->unsubscribe($firebase_token);

        echo json_encode(['status' => ['error' => FALSE]]);
        die();
    }

    // Firebase functions

    public function updateFirebaseToken() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $ad_name = $this->input->post('ad_name');
        $key = $this->input->post('key');

        $session_status = $this->usr->validateSession($ad_name, $key);

        if (!$session_status) {
            cus_json_error('Your session may have been expired. Please login again');
        }

        $this->fbm->firebaseToken($ad_name);

        echo json_encode(['status' => ['error' => FALSE]]);
    }

    public function unsubscribeFirebaseToken() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $this->fbm->unsubscribe($this->input->post('firebase_token'));

        echo json_encode(['status' => ['error' => FALSE]]);
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

    public function validateMedicalFile() {

        $md_by_osha = $this->input->post('medical_by_osha');


        $ad_name = $this->usr->user_email;

        if (empty($ad_name)) {
            $ad_name = $this->input->post('ad_name');
        }

        $user = $this->usr->getAnymousUser($ad_name);

        if (in_array($md_by_osha, ['YES'])) {

            $attachments = $this->utl->getAttachments(NULL, ['att_type' => 'MEDICAL_FITNESS', 'att_ref' => $user['usr_ad_name']]);
            if (count($attachments) == 0) {
                $this->form_validation->set_message(__FUNCTION__, 'If attended medical fitness you should attach a file');
                return FALSE;
            }
        }

        return TRUE;
    }

    public function validateLicenseAttachment() {

        $user_id = $this->usr->user_id;

        if (empty($user_id)) {
            $user_id = $this->input->post('user_id');
        }

        $user = $this->usr->getUserInfo($user_id, 'ID');

        $attachments = $this->utl->getAttachments(NULL, ['att_type' => 'DRIVER_LICENSE', 'att_ref' => $user['usr_id']]);
        if (count($attachments) == 0) {
            $this->form_validation->set_message(__FUNCTION__, 'You should attach a copy of drivers license');
            return FALSE;
        }

        return TRUE;
    }

    public function validateMedicalFitnessDate($date) {

        $md_by_osha = $this->input->post('medical_by_osha');

        if (in_array(strtolower($md_by_osha), ['yes'])) {
            if (empty($date)) {
                $this->form_validation->set_message(__FUNCTION__, 'If attended medical fitness you should select assessment date');
                return FALSE;
            }
        }

        return TRUE;
    }

    public function validateLineManager($line_manager) {

        if (empty($line_manager)) {
            return TRUE;
        }

        $ao = $this->usr->getUsersList(['usr_title' => $line_manager], ['usr_title'], 1);

        if (!$ao) {
            $this->form_validation->set_message('Select a valid line manager');
            return FALSE;
        }
        return TRUE;
    }

    public function validateAttachment() {

        $user_id = $this->usr->user_id;
        if (empty($user_id)) {
            $user_id = $this->input->post('user_id');
        }

        $user = $this->usr->getUserInfo($user_id, 'ID');


        $attachment = $this->utl->getAttachments(NULL, ['att.att_type' => 'TRIP_REQUEST', 'att.att_status' => '0', 'att.att_usr_id' => $user['usr_id']]);

        if (!$attachment) {
            $this->form_validation->set_message(__FUNCTION__, 'Attachment is required.');
            return FALSE;
        }

        return TRUE;
    }

}
