<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trip extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function ajaxTripRequests() {

        if (!$this->usr->is_logged_in) {
            echo json_encode([
                "draw" => $_POST['draw'],
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
                "status" => [
                    'error' => TRUE,
                    'error_msg' => 'User has not logged in'
                ]
                    ]
            );
            die();
        }

        $data = [];
        $datatables = [
            'select_columns' => [
                'tr.tr_destination_location',
                'tr.tr_status', 'tr.tr_arraival_time',
                'tr.tr_dispatch_time',
                'tr.tr_id',
                'tr.tr_timestamp',
                'dp.dp_full_name',
                'dp.dp_email',
                'tr.tr_vehicle_type',
                'tr.tr_vehicle_reg_no'
            ],
            'search_columns' => [
                'tr.tr_ad_name', 'dp.dp_full_name'
            ],
            'order_columns' => [
                NULL, 'tr.tr_timestamp', 'dp.dp_full_name', NULL, NULL, NULL, NULL, NULL
            ],
            'default_order_column' => [
                'tr.tr_timestamp' => 'DESC'
            ],
            'cond' => NULL,
            'where_in' => ['tr.tr_status' => ['COMPLETED', 'APPROVED','INPROGRESS']]
        ];

        $list = $this->trip->get_datatables_trips($datatables);
        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = [];
            $status = cus_status_template($a->tr_status);

            $links = '<div class="dropdown">
                        <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                            <a href="' . site_url('trip/pdfpreviewtrip/' . $a->tr_id) . '" class="dropdown-item edit_user text-info" target="_blank"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                <a href="' . site_url('trip/previewrequest/' . $a->tr_id) . '" class="dropdown-item text-success"> <i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;Approval Satatus</a>
                        </div>
                    </div>';

            $row[] = $no;
            $row[] = '<div nowrap="nowrap">' . cus_nice_date($a->tr_timestamp) . '<div>';
            $row[] = '<div nowrap="nowrap"><b>' . ucwords($a->dp_full_name) . '</b><br/>' . $a->dp_email . '</div>';
            $row[] = '<div nowrap="nowrap"><b>' . $a->tr_vehicle_type . '</b><br/><i>' . $a->tr_vehicle_reg_no . '</i></div>';
            $row[] = '<div nowrap="nowrap">' . cus_nice_timestamp($a->tr_dispatch_time) . '<br/>' . cus_nice_timestamp($a->tr_arraival_time) . '</div>';
            $row[] = '<div nowrap="nowrap">' . $a->tr_destination_location . '<div>';
            $row[] = $status;
            $row[] = $links;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->trip->count_all_trips($datatables),
            "recordsFiltered" => $this->trip->count_filtered_trips($datatables),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function ajaxInboxTripRequests() {

        if (!$this->usr->is_logged_in) {
            echo json_encode([
                "draw" => $_POST['draw'],
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
                "status" => [
                    'error' => TRUE,
                    'error_msg' => 'User has not logged in'
                ]
                    ]
            );
            die();
        }
        
        $request_to_approve = $this->approval->getRequestApprovals(['auth.auth_tr_id'], "auth.auth_status IS NULL AND r.r_notification_status = '1'", NULL, ['auth.auth_usr_title' => $this->usr->getUserApprovalTitles(),'tr.tr_status' => ['INPROGRESS']]);

        if ($request_to_approve) {
            $tr_ids = array_column($request_to_approve, "auth_tr_id");
        } else {
            $tr_ids = FALSE;
        }
        
        $data = [];
        $datatables = [
            'select_columns' => [
                'tr.tr_destination_location',
                'tr.tr_status', 'tr.tr_arraival_time',
                'tr.tr_dispatch_time',
                'tr.tr_id',
                'tr.tr_timestamp',
                'dp.dp_full_name',
                'dp.dp_email',
                'tr.tr_vehicle_type',
                'tr.tr_vehicle_reg_no'
            ],
            'search_columns' => [
                'tr.tr_journey_purpose', 'dp.dp_full_name'
            ],
            'order_columns' => [
                NULL, 'tr.tr_timestamp', 'dp.dp_full_name', NULL, NULL, NULL, NULL, NULL
            ],
            'default_order_column' => [
                'tr.tr_timestamp' => 'DESC'
            ],
            'cond' => [],
            'where_in' => ['tr.tr_status' => ['INPROGRESS'],'tr.tr_id'=> $tr_ids]
        ];

        $list = $this->trip->get_datatables_trips($datatables);
        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = [];
            $status = cus_status_template($a->tr_status);

            $links = '<div class="dropdown">
                        <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                            <a href="' . site_url('trip/pdfpreviewtrip/' . $a->tr_id) . '" class="dropdown-item edit_user text-info" target="_blank"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                <a href="' . site_url('trip/previewrequest/' . $a->tr_id) . '" class="dropdown-item text-success"> <i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;Approval Satatus</a>
                        </div>
                    </div>';

            $row[] = $no;
            $row[] = '<div nowrap="nowrap">' . cus_nice_date($a->tr_timestamp) . '<div>';
            $row[] = '<div nowrap="nowrap"><b>' . ucwords($a->dp_full_name) . '</b><br/>' . $a->dp_email . '</div>';
            $row[] = '<div nowrap="nowrap"><b>' . $a->tr_vehicle_type . '</b><br/><i>' . $a->tr_vehicle_reg_no . '</i></div>';
            $row[] = '<div nowrap="nowrap">' . cus_nice_timestamp($a->tr_dispatch_time) . '<br/>' . cus_nice_timestamp($a->tr_arraival_time) . '</div>';
            $row[] = '<div nowrap="nowrap">' . $a->tr_destination_location . '<div>';
            $row[] = $status;
            $row[] = $links;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->trip->count_all_trips($datatables),
            "recordsFiltered" => $this->trip->count_filtered_trips($datatables),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function ajaxMyTripRequests() {

        if (!$this->usr->is_logged_in) {
            echo json_encode([
                "draw" => $_POST['draw'],
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
                "status" => [
                    'error' => TRUE,
                    'error_msg' => 'User has not logged in'
                ]
                    ]
            );
            die();
        }

        $data = [];
        $datatables = [
            'select_columns' => [
                'tr.tr_destination_location',
                'tr.tr_status', 'tr.tr_arraival_time',
                'tr.tr_dispatch_time',
                'tr.tr_departure_location',
                'tr.tr_id',
                'tr.tr_timestamp',
                'tr.tr_journey_purpose',
                'dp.dp_full_name',
                'dp.dp_email',
                'tr.tr_vehicle_type',
                'tr.tr_vehicle_reg_no'
            ],
            'search_columns' => [
                'tr.tr_ad_name', 'dp.dp_full_name'
            ],
            'order_columns' => [
                NULL, 'tr.tr_timestamp', NULL, NULL, NULL, NULL, NULL
            ],
            'default_order_column' => [
                'tr.tr_timestamp' => 'DESC'
            ],
            'cond' => ['tr.tr_usr_id' => $this->usr->user_id],
            'where_in' => NULL
        ];

        $list = $this->trip->get_datatables_trips($datatables);
        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = [];
            $status = cus_status_template($a->tr_status);

            $links = '<div class="dropdown">
                        <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                            <a href="' . site_url('trip/pdfpreviewtrip/' . $a->tr_id) . '" class="dropdown-item edit_user text-info" target="_blank"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                <a href="' . site_url('trip/previewrequest/' . $a->tr_id) . '" class="dropdown-item text-success"> <i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;Approval Satatus</a>
                        </div>
                    </div>';

//            $row[] = $no;//tr_journey_purpose
            $row[] = '<div nowrap="nowrap">' . ucwords($a->tr_journey_purpose) . '<div>';
            $row[] = '<div nowrap="nowrap">' . cus_nice_date($a->tr_timestamp) . '<div>';
            // $row[] = '<div nowrap="nowrap"><b>' . ucwords($a->dp_full_name) . '</b><br/>' . $a->dp_email . '</div>';
            $row[] = '<div nowrap="nowrap"><b>' . $a->tr_vehicle_type . '</b><br/><i>' . $a->tr_vehicle_reg_no . '</i></div>';
            $row[] = '<div nowrap="nowrap">' . $a->tr_departure_location . '<br/>' . cus_nice_timestamp($a->tr_dispatch_time) . '</div>';
            $row[] = '<div nowrap="nowrap">' . $a->tr_destination_location . '<br/>' . cus_nice_timestamp($a->tr_arraival_time) . '</div>';

            $row[] = $status;
            $row[] = $links;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->trip->count_all_trips($datatables),
            "recordsFiltered" => $this->trip->count_filtered_trips($datatables),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function requests() {

        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Loging in is requires', 'error', 'user');
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_trip_request',
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP','inbox_count' => $this->usr->getInbox()],
            'content_data' => ['module_name' => 'All Trip Requests'],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['inbox' => $this->usr->getInbox(),]
        ];

        $this->load->view('view_base', $data);
    }

    public function inbox() {

        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Loging in is requires', 'error', 'user');
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_inbox_trip_request',
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP','inbox_count' => $this->usr->getInbox()],
            'content_data' => ['module_name' => 'Incoming Requests'],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['inbox' => $this->usr->getInbox(),]
        ];

        $this->load->view('view_base', $data);
    }

    public function requestTrip() {

        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Loging in is requires', 'error', 'user');
        }
        
        $attachments = $this->utl->getAttachments(NULL, ['att.att_type' => 'TRIP_REQUEST','att.att_status'=>'0','att_usr_id' => $this->usr->user_id]);

        if($attachments){
            $att_ids = array_column($attachments, "att_id");
            $this->utl->removeAttachments($att_ids);
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_request_trip',
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP','inbox_count' => $this->usr->getInbox()],
            'content_data' => [
                'module_name' => 'Request A Trip',
                'attachments' => $this->utl->getAttachments(NULL, ['att_type' => 'TRIP_REQUEST','att_usr_id' => $this->usr->user_id,'att_status' => '0'])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['inbox' => $this->usr->getInbox(),]
        ];

        $this->load->view('view_base', $data);
    }

    public function myRequests() {
        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Loging in is requires', 'error', 'user');
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_my_trip_requests',
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP','inbox_count' => $this->usr->getInbox()],
            'content_data' => ['module_name' => 'My Trip Requests'],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['inbox' => $this->usr->getInbox(),]
        ];

        $this->load->view('view_base', $data);
    }

    public function requestApprovalBk() {

        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Loging in is requires', 'error', 'user');
        }

        $trip_id = $this->uri->segment(3);

        $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $trip_id], 1);

        if (!$trip) {
            // trip request was not found so redirect back
            $this->usr->setSessMsg('Trip request was not found or may have been removed from the system', 'error', site_url('trip/requests'));
        }

        if (!in_array(strtolower($trip['tr_status']), ['new', 'paused'])) {
            $this->usr->setSessMsg('Trip request is not in the right status to request for approval', 'error', 'trip/previewrequest/' . $trip['tr_id']);
        }

        $driver = $this->driver->getDriverProfiles(NULL, ['dp.dp_ad_name' => $this->usr->user_ad_name], 1);
        if (!$driver) {
            $this->usr->setSessMsg('Your driver profile can not be found', 'error', 'trip/previewrequest/' . $trip['tr_id']);
        }

        $timestamp = date('Y-m-d H:i:s');

        if (empty($trip['ap_tr_id'])) {
            //if request has no approval added yet
            $approval_data = [
                'ap_tr_id' => $trip['tr_id'],
                'ap_ad_name' => $driver['dp_ao_ad_name'],
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
                'tr_id' => $trip['trip_id'],
                'ad_name' => $trip['ap_ad_name'],
                'tr_data' => ['tr_status' => 'PENDING']
            ]);
        }

        if ($res) {
            $this->usr->setSessMsg('Approval request sent successfully.', 'sucess', 'trip/previewrequest/' . $trip['tr_id']);
        } else {
            $this->usr->setSessMsg('Approval request was not sent.', 'error', 'trip/previewrequest/' . $trip['tr_id']);
        }
    }
    
    public function requestApproval() {
        
        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg(MSG_SESSION_EXPIRY, 'error', 'user');
        }

        $r_id = $this->uri->segment(3);
        
        $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $r_id], 1);

        if (!$trip) {
            // trip request was not found so redirect back
            $this->usr->setSessMsg('Trip request was not found or may have been removed from the system', 'error', site_url('trip/requests'));
        }

        if (!in_array(strtolower($trip['tr_status']), ['new', 'paused'])) {
            $this->usr->setSessMsg('Trip request is not in the right status to request for approval', 'error', 'trip/previewrequest/' . $trip['tr_id']);
        }

        
        $user = $this->usr->getUserInfo($this->usr->user_id, 'ID');

        $res = $this->_createAndSubmitRoute($trip, $user);

        if ($res) {
            $this->usr->setSessMsg('Approval request sent successfully.', 'success', 'trip/previewrequest/' . $trip['tr_id'] . '?url=' . urlencode(site_url('permits/mypermits')) . '&module=' . urlencode("My Trip Requests"));
        } else {
            $this->usr->setSessMsg('Approval request was not sent.', 'error', 'trip/previewrequest/' . $trip['tr_id'] . '?url=' . urlencode(site_url('permits/mypermits')) . '&module=' . urlencode("My Trip Requests"));
        }
    }
    
    private function _createAndSubmitRoute($trip, $user, $source = 'web') {

        $usn = $user['usr_email'];

        if (!$trip) {
            // trip request was not found so redirect back
            $source == 'mobile' ? cus_json_error('Trip request was not found or may have been removed from the system') : $this->usr->setSessMsg('Trip request was not found or may have been removed from the system', 'error', site_url('trip/previewrequest/'. $trip['tr_id']));
        }

        if (!in_array(strtolower($trip['tr_status']), ['new', 'paused'])) {
            $source == 'mobile' ? cus_json_error('Trip request is not in the right status  for approval request') : $this->usr->setSessMsg('Permit request is not in the right status  for approval request', 'error', 'permit/ptwpreview/' . $trip['tr_id']);
        }

        log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Requesting approval for Trip request :' . $trip['tr_id']);

        $new_route = [];

        $timestamp = date('Y-m-d H:i:s');
      
        $offs = [];

        $manager = $this->usr->getUsersList(['usr_title' => $trip['dp_ao_title']], ['usr_title'], 1);
        
        if($manager){
            $offs[] = $manager['usr_title'];
        }
       
        $sequence = 1;

        foreach ($offs as $off) {
            $new_route[] = [
                'r_tr_id' => $trip['tr_id'],
                'r_usr_title' => $off,
                'r_sequence' => $sequence,
                'r_notification_status' => 0,
                'r_insert_date' => $timestamp,
                'r_last_update' => $timestamp,
                'r_type' => 0
            ];
            $sequence++;
        }

        if (empty($new_route)) {
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Route is empty. No Approval detected for this PTW :' . $permit['p_id']);
            $source == 'mobile' ? cus_json_error('Approval request was not sent. No approval official available to approve your request.') : $this->usr->setSessMsg('Approval request was not sent. No approval official available to approve your request.', 'error', 'permits/ptwpreview/' . $permit['p_id']);
        }

        $new_route[] = [
            'r_tr_id' => $trip['tr_id'],
            'r_usr_title' => 'ALL',
            'r_sequence' => $sequence,
            'r_notification_status' => 0,
            'r_insert_date' => $timestamp,
            'r_last_update' => $timestamp,
            'r_type' => 0
        ];


        $data = [
            'new_route' => $new_route,
            'tr_id' => $trip['tr_id']
        ];

        $res = $this->approval->saveRoute($data);

        if ($res) {
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Approval route created for Trip request :' . $trip['tr_id'] . ' Route:' . json_encode($data));
        } else {
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Failed to create route for Trip Request :' . $trip['tr_id'] . ' Route:' . json_encode($data));
        }

        sleep(3); // allow few seconds for a script to update the request
        return $res;
    }

    public function previewRequest() {
        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Loging in is requires', 'error', 'user');
        }

        $trip_id = $this->uri->segment(3);

        $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $trip_id], 1);

        if (!$trip) {
            // trip request was not found so redirect back
            $this->usr->setSessMsg('Trip request was not found or may have been removed from the system', 'error', site_url('trip/requests'));
        }
        
        $can_approve = FALSE;

        $request_to_approve = $this->approval->getRequestApprovals(['auth.auth_tr_id'], "auth.auth_tr_id = '" . $trip['tr_id'] . "' AND auth.auth_status IS NULL AND r.r_notification_status = '1'", 1, ['auth.auth_usr_title' => $this->usr->getUserApprovalTitles(),'tr.tr_status' => ['INPROGRESS']]);

        if ($request_to_approve) {
            
            $can_approve = in_array($trip['tr_id'], [$request_to_approve['auth_tr_id']]);
            
        }

        $cols_ap = ['auth.auth_usr_title', 'u.usr_email email', 'u.usr_phone phone', 'u.usr_fullname fullname', 'auth.auth_approved_date', 'auth.auth_comment'];
        $approvers_approved = $this->approval->getRequestApprovals($cols_ap, "auth.auth_tr_id = '" . $trip['tr_id'] . "' AND auth.auth_status IS NOT NULL");

        
        $cols_pa = ['r.r_usr_title', 'u.usr_email email', 'u.usr_phone phone', 'u.usr_fullname fullname'];
        $pending_approval = $this->approval->getRequestRoute($cols_pa, "r.r_tr_id = '" . $trip['tr_id'] . "' AND auth.auth_status IS NULL");
                
        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_preview_request',
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP','inbox_count' => $this->usr->getInbox()],
            'content_data' => [
                'module_name' => 'Trip Approval Satatus',
                'trip' => $trip,
                'pending_approval' => $pending_approval,
                'approvers_approved' => $approvers_approved,
                'is_my_application' => $this->usr->user_id == $trip['tr_usr_id'] ? TRUE : FALSE,
                'can_approve' => $can_approve, //$this->usr->user_ad_name == $trip['ap_ad_name'] ? TRUE : FALSE,
                'attachments' => $this->utl->getAttachments(NULL, ['att.att_type' => 'TRIP_REQUEST','att.att_ref' => $trip['tr_id']])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['inbox' => $this->usr->getInbox(),]
        ];

        $this->load->view('view_base', $data);
    }

    public function editTripRequest() {
        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Loging in is requires', 'error', 'user');
        }

        $trip_id = $this->uri->segment(3);

        $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $trip_id], 1);

        if (!$trip) {
            // trip request was not found so redirect back
            $this->usr->setSessMsg('Trip request was not found or may have been removed from the system', 'error', site_url('trip/requests'));
        }
        
        $incomplete_uploads = $this->utl->getAttachments(NULL, "att.att_ref IS NULL AND att.att_usr_id ='".$this->usr->user_id."' AND att.att_status = '0' ");
        
        $this->utl->removeTempFiles($incomplete_uploads);

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_edit_request',
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP','inbox_count' => $this->usr->getInbox()],
            'content_data' => [
                'module_name' => 'Edit Trip Request',
                'attachments' => $this->utl->getAttachments(NULL, ['att.att_type' => 'TRIP_REQUEST','att.att_ref' => $trip['tr_id']]),
                'trip' => $trip,
                'is_my_application' => $this->usr->user_id == $trip['tr_usr_id'] ? TRUE : FALSE,
                'can_approve' => FALSE,//$this->usr->user_ad_name == $trip['ap_ad_name'] ? TRUE : FALSE
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['inbox' => $this->usr->getInbox(),]
        ];

        $this->load->view('view_base', $data);
    }

    public function pdfPreviewTrip() {

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)
        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }


        $trip_id = $this->uri->segment(3);

        $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $trip_id], 1);

        if (!$trip) {
            // trip request was not found so redirect back
            $this->usr->setSessMsg('Trip request was not found or may have been removed from the system', 'error', site_url('trip/requests'));
        }

        $time = date('Y-m-d H:i:s');
        $data = [
            'trip' => $trip
        ];

        $html = $this->load->view('export/view_export_pdf_trip_request', $data, true); // render the view into HTML

        $this->load->library('pdf');

        $pdf = $this->pdf->load('c', 'A4');

        //$pdf->SetWatermarkImage(base_url(). 'assets/img/approved.png');
        //$pdf->showWatermarkImage = true;

        $pdf->SetFooter(SYSTEM_NAME . ' - Printed by ' . ucwords($this->usr->full_name) . '<br/>' . cus_nice_timestamp($time) . '|{PAGENO}|Powered By Noxyt Software Solution <br/>www.noxyt.com'); // Add a footer for good measure ;)

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output();
        return;
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

}
