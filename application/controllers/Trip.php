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
            'where_in' => ['tr.tr_status' => ['COMPLETED', 'APPROVED']]
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
            'cond' => ['ap.ap_ad_name' => $this->usr->ad_name],
            'where_in' => ['tr.tr_status' => ['PENDING']]
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
            'cond' => ['tr.tr_ad_name' => $this->usr->ad_name],
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
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP'],
            'content_data' => ['module_name' => 'All Trip Requests'],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
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
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP'],
            'content_data' => ['module_name' => 'Incoming Requests'],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function requestTrip() {

        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Loging in is requires', 'error', 'user');
        }
        
        $attachments = $this->utl->getAttachments(NULL, ['att.att_type' => 'TRIP_REQUEST','att.att_status'=>'0','att_ad_name' => $this->usr->ad_name]);

        if($attachments){
            $att_ids = array_column($attachments, "att_id");
            $this->utl->removeAttachments($att_ids);
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_request_trip',
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP'],
            'content_data' => [
                'module_name' => 'Request A Trip',
                'attachments' => $this->utl->getAttachments(NULL, ['att_type' => 'TRIP_REQUEST','att_ad_name' => $this->usr->ad_name,'att_status' => '0'])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
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
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP'],
            'content_data' => ['module_name' => 'My Trip Requests'],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function requestApproval() {

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

        $driver = $this->driver->getDriverProfiles(NULL, ['dp.dp_ad_name' => $this->usr->ad_name], 1);
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
        
        
         
                
        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_preview_request',
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP'],
            'content_data' => [
                'module_name' => 'Trip Approval Satatus',
                'trip' => $trip,
                'is_my_application' => $this->usr->ad_name == $trip['tr_ad_name'] ? TRUE : FALSE,
                'can_approve' => $this->usr->ad_name == $trip['ap_ad_name'] ? TRUE : FALSE,
                'attachments' => $this->utl->getAttachments(NULL, ['att.att_type' => 'TRIP_REQUEST','att.att_ref' => $trip['tr_id']])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
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

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_edit_request',
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP'],
            'content_data' => [
                'module_name' => 'Edit Trip Request',
                'trip' => $trip,
                'is_my_application' => $this->usr->ad_name == $trip['tr_ad_name'] ? TRUE : FALSE,
                'can_approve' => $this->usr->ad_name == $trip['ap_ad_name'] ? TRUE : FALSE
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
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
