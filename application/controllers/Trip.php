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
            'where_in' => NULL
        ];

        $list = $this->trip->get_datatables_trips($datatables);
        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = [];
            $status = "";

            switch ($a->tr_status) {
                case 'NEW':
                    $status = '<h4><span class="badge badge-info">NEW</span></h4>';
                    break;

                case 'PENDING':
                    $status = '<h4><span class="badge badge-danger">PENDING</span></h4>';
                    break;

                default:
                    break;
            }
            $links = '<div class="dropdown">
                        <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                            <a href="' . site_url('trip/pdfpreviewtrip/' . $a->tr_id) . '" class="dropdown-item edit_user text-info request_form"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                            <a href="' . site_url('trip/deleteattendee/' . $a->tr_id) . '" class="dropdown-item del_user text-danger confirm" title="delete this attendee"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete Attendee</a>
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
            $status = "";

            switch ($a->tr_status) {
                case 'NEW':
                    $status = '<h4><span class="badge badge-info">NEW</span></h4>';
                    break;

                case 'PENDING':
                    $status = '<h4><span class="badge badge-danger">PENDING</span></h4>';
                    break;

                default:
                    break;
            }
            $links = '<div class="dropdown">
                        <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                            <a href="' . site_url('trip/pdfpreviewtrip/' . $a->tr_id) . '" class="dropdown-item edit_user text-info request_form"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
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
            $status = "";

            switch ($a->tr_status) {
                case 'NEW':
                    $status = '<h4><span class="badge badge-info">NEW</span></h4>';
                    break;

                case 'PENDING':
                    $status = '<h4><span class="badge badge-danger">PENDING</span></h4>';
                    break;

                default:
                    break;
            }
            $links = '<div class="dropdown">
                        <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                            <a href="' . site_url('trip/pdfpreviewtrip/' . $a->tr_id) . '" class="dropdown-item edit_user text-info request_form"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                <a href="' . site_url('trip/previewrequest/' . $a->tr_id) . '" class="dropdown-item text-success"> <i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;Approval Satatus</a>
                        </div>
                    </div>';

            $row[] = $no;
            $row[] = '<div nowrap="nowrap">' . cus_nice_date($a->tr_timestamp) . '<div>';
           // $row[] = '<div nowrap="nowrap"><b>' . ucwords($a->dp_full_name) . '</b><br/>' . $a->dp_email . '</div>';
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

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_request_trip',
            'menu_data' => ['curr_menu' => 'TRIP', 'curr_sub_menu' => 'TRIP'],
            'content_data' => ['module_name' => 'Request A Trip'],
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
    
    public function previewRequest() {
        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Loging in is requires', 'error', 'user');
        }
        
        $trip_id = $this->uri->segment(3);
        
        $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $trip_id], 1);
        
        if(!$trip){
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
                'is_my_application' => $this->usr->ad_name == $trip['tr_ad_name']? TRUE : FALSE,
                'can_approve' => $this->usr->ad_name == $trip['ap_ad_name'] ? TRUE : FALSE
                ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

}
