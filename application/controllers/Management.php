<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Management extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function ajaxDepartments() {

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
                'dept.dept_name', 'dept.dept_hod_full_name', 'dept.dept_hod_ad_name', 'dept.dept_hod_email', 'dept.dept_hod_phone', 'dept.dept_id'
            ],
            'search_columns' => [
                'dept.dept_name', 'dept.dept_hod_ad_name', 'dept.dept_hod_phone', 'dept.dept_hod_email', 'dept.dept_hod_full_name'
            ],
            'order_columns' => [
                NULL, NULL, NULL, NUll, NULL, NULL, NULL
            ],
            'default_order_column' => [
                'dept.dept_name' => 'ASC'
            ],
            'cond' => NULL,
            'where_in' => NULL
        ];

        $list = $this->mnt->get_datatables_depts($datatables);
        $no = $_POST['start'];

        foreach ($list as $a) {

            $no++;
            $row = [];

            $links = '<div class="dropdown">
                        <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                            <a href="' . site_url('management/requesteditdepartment/' . $a->dept_id) . '" class="dropdown-item text-info request_form" target="_blank"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Details</a>
                                <a href="' . site_url('management/deletedepartment/' . $a->dept_id) . '" class="dropdown-item text-danger confirm" title=" delete department"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                        </div>
                    </div>';

            $row[] = $no;

            $row[] = '<div nowrap="nowrap">' . strtoupper($a->dept_name) . '<div>';
            $row[] = '<div nowrap="nowrap">' . $a->dept_hod_ad_name . '<div>';
            $row[] = '<div nowrap="nowrap"><b>' . ucwords($a->dept_hod_full_name) . '</b></div>';
            $row[] = '<div nowrap="nowrap">' . $a->dept_hod_phone . '</div>';
            $row[] = '<div nowrap="nowrap">' . $a->dept_hod_email . '</div>';
            $row[] = $links;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mnt->count_all_depts($datatables),
            "recordsFiltered" => $this->mnt->count_filtered_depts($datatables),
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

    public function departments() {

        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Loging in is requires', 'error', 'user');
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_departments',
            'menu_data' => ['curr_menu' => 'MANAGEMENT', 'curr_sub_menu' => 'MANAGEMENT'],
            'content_data' => ['module_name' => 'Manage Departments'],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function submitAddDepartment() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');


        // Check user session status and the platform used
        if (!$this->usr->is_logged_in) {
            cus_json_error(MSG_EXPIRY_SESSION);
        }

        $usn = $this->usr->ad_name;

        $validations = [
                ['field' => 'dept_name', 'label' => 'department name', 'rules' => 'trim|required'],
                ['field' => 'hod_ad_name', 'label' => 'HOD AD name', 'rules' => 'trim|required|is_unique[' . $this->db->dbprefix . 'department.dept_hod_ad_name]', 'errors' => ['is_unique' => 'HOD AD name is already in use.']],
                ['field' => 'hod_full_name', 'label' => 'HOD full name', 'rules' => 'trim|required'],
                ['field' => 'hod_phone', 'label' => 'HOD phone number', 'rules' => 'trim|required|callback_validateHODPhoneNumber|is_unique[' . $this->db->dbprefix . 'department.dept_hod_phone]', 'errors' => ['is_unique' => 'HOD Phone number is already in use.']],
                ['field' => 'hod_email', 'label' => 'HOD email address', 'rules' => 'trim|required|valid_email|is_unique[' . $this->db->dbprefix . 'department.dept_hod_ad_email]', 'errors' => ['is_unique' => 'HOD email address is already in use.']]
        ];

        $this->form_validation->set_rules($validations);

        log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Attempting to add new department');

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

            $phone = $this->input->post('hod_phone');
            $dept_data = [
                'dept_name' => $this->input->post('dept_name'),
                'dept_hod_full_name' => $this->input->post('hod_full_name'),
                'dept_hod_ad_name' => $this->input->post('hod_ad_name'),
                'dept_hod_email' => $this->input->post('hod_email'),
                'dept_hod_phone' => cus_phone_with_255($phone),
                'dept_status' => 'ACTIVE'
            ];

            $res = $this->mnt->saveDepartment(['dept_data' => $dept_data]);
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Adding new department: ' . json_encode($dept_data));

            if ($res) {
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Department added successfully');
                $this->usr->setSessMsg('Department added successfully', 'success');
                $json = json_encode([
                    'status' => ['error' => FALSE, 'redirect' => TRUE, 'redirect_url' => site_url('management/departments')]
                ]);
                echo $json;
            } else {
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Department was not added');
                cus_json_error('Department  was not added');
            }
        }
    }

    public function submitEditDepartment() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');


        // Check user session status and the platform used
        if (!$this->usr->is_logged_in) {
            cus_json_error(MSG_EXPIRY_SESSION);
        }
        $usn = $this->usr->ad_name;
        
        $dept_id = $this->uri->segment(3);

        $dept = $this->mnt->getDepartments(NULL, ['dept.dept_id' => $dept_id], 1);

        if (!$dept) {
            cus_json_error('Department was not found or it may have been removed from the system');
        }

        $validations = [
                ['field' => 'edit_dept_name', 'label' => 'department name', 'rules' => 'trim|required'],
                ['field' => 'edit_hod_ad_name', 'label' => 'HOD AD name', 'rules' => 'trim|required|callback_validateEditHODAdName'],
                ['field' => 'edit_hod_full_name', 'label' => 'HOD full name', 'rules' => 'trim|required'],
                ['field' => 'edit_hod_phone', 'label' => 'HOD phone number', 'rules' => 'trim|required|callback_validateEditHODPhoneNumber'],
                ['field' => 'edit_hod_email', 'label' => 'HOD email address', 'rules' => 'trim|required|valid_email|callback_validateEditHODEmail']
        ];

        $this->form_validation->set_rules($validations);

        log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Attempting to edit new department');

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

            $phone = $this->input->post('edit_hod_phone');
            $dept_data = [
                'dept_name' => $this->input->post('edit_dept_name'),
                'dept_hod_full_name' => $this->input->post('edit_hod_full_name'),
                'dept_hod_ad_name' => $this->input->post('edit_hod_ad_name'),
                'dept_hod_email' => $this->input->post('edit_hod_email'),
                'dept_hod_phone' => cus_phone_with_255($phone),
                'dept_status' => 'ACTIVE'
            ];

            $res = $this->mnt->saveEditDepartment(['dept_data' => $dept_data], $dept['dept_id']);
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - edited department: ' . json_encode($dept_data));

            if ($res) {
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Department edited successfully');
                $this->usr->setSessMsg('Department edited successfully', 'success');
                $json = json_encode([
                    'status' => ['error' => FALSE, 'redirect' => TRUE, 'redirect_url' => site_url('management/departments')]
                ]);
                echo $json;
            } else {
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Department was not edited');
                cus_json_error('Department  was not edited');
            }
        }
    }
    public function validateHODPhoneNumber($phone) {
        if (empty($phone)) {
            return TRUE;
        }
        return TRUE;
    }

    public function deleteDepartment() {

        // Check user session status and the platform used
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg(MSG_EXPIRY_SESSION, 'error', 'user');
        }
        $usn = $this->usr->ad_name;

        $dept_id = $this->uri->segment(3);

        $dept = $this->mnt->getDepartments(NULL, ['dept.dept_id' => $dept_id], 1);

        if (!$dept) {
            $this->usr->setSessMsg('Department may have already been removed', 'error', 'management/departments');
        }

        log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Attempting to delete department: ' . $dept['dept_name']);

        $dept_has_drivers = $this->trip->getTripRequests(NULL, ['dp.dp_dept_id' => $dept['dept_id']]);

        if ($dept_has_drivers) {
            $this->usr->setSessMsg('Department can not be deleted because there is/are driver(s) associated with it', 'error', 'management/departments');
        }
        
        
        $dept_has_sections = $this->mnt->getSections(NULL, ['sec.sec_dept_id' => $dept['dept_id']]);
        
        if ($dept_has_sections) {
            $this->usr->setSessMsg('Department can not be deleted because there is/are section(s) associated with it', 'error', 'management/departments');
        }

        $res = $this->mnt->deleteDept($dept['dept_id']);

        if ($res) {
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' -  department deleted successfully : ' . $dept['dept_name']);
            $this->usr->setSessMsg('Department was deleted successfully', 'success', 'management/departments');
        } else {
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - department was not deleted : ' . $dept['dept_name']);
            $this->usr->setSessMsg('Department was not deleted', 'error', 'management/departments');
        }
    }

    public function requestEditDepartment() {

        header('Content-type: text/json');
        header('Access-Control-Allow-Origin: *');

        if (!$this->usr->is_logged_in) {
            cus_json_error(MSG_EXPIRY_SESSION);
        }

        $dept_id = $this->uri->segment(3);

        $dept = $this->mnt->getDepartments(NULL, ['dept.dept_id' => $dept_id], 1);

        if (!$dept) {
            cus_json_error('Department was not found or it may have been removed from the system');
        }

        echo json_encode([
            'status' => [
                'error' => FALSE,'pop_form' => TRUE, 'form_type' => 'editDepartment','form_url' => site_url('management/submiteditdepartment/'. $dept['dept_id'])
            ],
            'dept' => $dept
        ]);
    }
    
    public function validateEditHODPhoneNumber($phone) {
        if(empty($phone)){
            return TRUE;
        }
        
        return TRUE;
    }
    
    public function validateEditHODEmail($email) {
        if(empty($email)){
            return TRUE;
        }
        
        return TRUE;
    }
    
    public function validateEditHODAdName($ad_name) {
        if(empty($ad_name)){
            return TRUE;
        }
        
        return TRUE;
    }

}
