<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shareholder extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function cdsUploads() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Login is required', 'error', 'user/index');
        }

        if (!in_array(strtolower($this->usr->user_role), ['admin'])) {
            $this->usr->setSessMsg('Access denied. You do not have privileges to perform requested action', 'error', 'shareholder/cdsaccounts');
        }

        $temp_uploads = $this->shareholder->getCdsImportedFiles(NULL, ['cds_upload_status' => 'TEMP', 'cds_upload_user_id' => $this->usr->user_id], NULL);

        if (!empty($temp_uploads)) {
            $this->utl->removeTempImports($temp_uploads);
        }

        $uploads = $this->shareholder->getCdsImportedFiles(NULL, ['cds_upload_status' => 'PROCESSED'], NULL);

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_cds_uploads',
            'menu_data' => [
                'curr_menu' => 'SHAREHOLDERS',
                'curr_sub_menu' => 'SHAREHOLDERS'
            ],
            'content_data' => [
                'module_name' => 'CDS Acoounts File Upload',
                'uploads' => $uploads,
            ],
            'modals_data' => [
                'modals' => ['modal_upload_cds_accounts']
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function cdsAccounts() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Login is required', 'error', 'user/index');
        }

        $cds_accounts = $this->shareholder->getCdsAccounts();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_cds_accounts',
            'menu_data' => [
                'curr_menu' => 'SHAREHOLDERS',
                'curr_sub_menu' => 'SHAREHOLDERS'
            ],
            'content_data' => [
                'module_name' => 'CDS Acoounts List',
                'cds_accounts' => $cds_accounts,
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function ajaxCdsAccounts() {

        if (!$this->usr->is_logged_in) {

            echo json_encode([
                "draw" => $_POST['draw'],
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
                    ]
            );
            die();
        }

        $year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);
        //round((($a->cds_acc_shares/ (int)$year['year_total_share']) * 100),2) . "%";

        $data = [];
        $list = $this->shareholder->get_datatables_cds_accounts(['year_id' => $this->usr->year_id]);
        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $a->cds_acc_number;
            $row[] = $a->cds_acc_fullname;
            $row[] = $a->cds_acc_phone;
            $row[] = $a->cds_acc_phone_2;
            $row[] = $a->cds_acc_address;
            $row[] = $a->cds_acc_address_2;
            $row[] = $a->cds_acc_address_3;
            $row[] = $a->cds_acc_address_4;
            $row[] = $a->cds_acc_nationality;
            $row[] = $a->cds_acc_next_of_kin;
            $row[] = $a->cds_acc_email;
            $row[] = $a->cds_acc_id;
            $row[] = $a->cds_acc_contract_1;
            $row[] = $a->cds_acc_contract_2;
            $row[] = $a->cds_acc_shares;
            $row[] = ($year['year_total_share'] > 0) ? round((($a->cds_acc_shares / (int) $year['year_total_share']) * 100), 2) . "%" : 0 . '%';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->shareholder->count_all_cds_accounts(['year_id' => $this->usr->year_id]),
            "recordsFiltered" => $this->shareholder->count_filtered_cds_accounts(['year_id' => $this->usr->year_id]),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function ajaxAttendance() {

        if (!$this->usr->is_logged_in) {

            echo json_encode([
                "draw" => $_POST['draw'],
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
                    ]
            );
            die();
        }


        $year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);
        //round((($a->cds_acc_shares/ (int)$year['year_total_share']) * 100),2) . "%";
        $data = [];
        $datatables = [
            'select_columns' => [
                'att.att_id',
                'catt.cds_att_type',
                'cacc.cds_acc_fullname',
                'att.att_has_smartphone',
                'cacc.cds_acc_number',
                'rep.att_fullname representative',
                'att.att_phone_number',
                'att.att_language',
                'cacc.cds_acc_shares',
            ],
            'search_columns' => ['cacc.cds_acc_fullname', 'rep.att_fullname', 'cacc.cds_acc_number', 'rep.att_phone_number', 'att.att_phone_number', 'cacc.cds_acc_email'],
            'order_columns' => [null, 'cds_acc_number', 'cds_acc_fullname', NULL, 'att_fullname', NULL, NULL, 'cds_acc_shares'],
            'default_order_column' => ['catt.cds_att_timestamp' => 'DESC'],
            'year_id' => $year['year_id']
        ];

        $list = $this->shareholder->get_datatables_attendanace($datatables);
        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = array();

            $att_type = "";
            if ($a->cds_att_type == 'SELF') {
                $att_type = '<h4><span class="badge badge-success">SELF</span></h4>';
            } elseif ($a->cds_att_type == 'REPRESENTED') {
                $att_type = '<h4><span class="badge badge-warning">REPRESENTED</span></h4>';
            }
            $channel = "";

            switch ($a->att_has_smartphone) {

                case '1':
                    $channel = 'WEB';
                    break;
                case '0':
                    $channel = 'SMS';
                    break;
                case '2':
                    $channel = 'MANUAL';
                    break;
            }

            $links = '<div class="dropdown">
                        <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                            <a href="' . site_url('shareholder/editattendance/' . $a->att_id) . '" class="dropdown-item edit_user text-info request_form"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Attendee</a>
                            <a href="' . site_url('shareholder/deleteattendee/' . $a->att_id) . '" class="dropdown-item del_user text-danger confirm" title="delete this attendee"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete Attendee</a>
                        </div>
                    </div>';

            $row[] = $no;
            $row[] = $a->cds_acc_number;
            $row[] = ucwords($a->cds_acc_fullname) . '<h6><span class="badge badge-secondary">' . $a->att_language . '</span></h6>';
            $row[] = $att_type;
            $row[] = $a->cds_att_type == 'REPRESENTED' ? ucwords($a->representative) : "";
            $row[] = $a->att_phone_number;
            $row[] = $channel;
            $row[] = $a->cds_acc_shares;
            $row[] = ($year['year_total_share'] > 0) ? round((($a->cds_acc_shares / (int) $year['year_total_share']) * 100), 2) . "%" : 0 . '%';
            $row[] = $links;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->shareholder->count_all_attendanace($datatables),
            "recordsFiltered" => $this->shareholder->count_filtered_attendanace($datatables),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function ajaxSelectShareholders() {
        
        
        if (!$this->usr->is_logged_in) {
            cus_json_error('Your seesion might have been expired please refresh the page.');
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');
        
        $cond = NULL;
        
        $res = $this->shareholder->getCdsAccounts(['cds_acc_number id','cds_acc_fullname text'], $cond, NULL,TRUE, ['val' => $this->input->get('q'), 'columns' => ['cds_acc_fullname','cds_acc_number']]);
        
        echo json_encode(['items' => $res,'term' => $this->input->get('q')]);
        
        die();
        
    }

    public function attendance() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Login is required', 'error', 'user/index');
        }

        //$cols = ['rep.att_id', 'cacc.cds_acc_number', 'cacc.cds_acc_fullname', 'catt.cds_att_type', 'rep.att_fullname', 'att.att_phone_number', 'att.att_language', 'att.att_has_smartphone', 'cacc.cds_acc_shares'];
        //$attendance = $this->shareholder->getAttendace($cols, ['att.att_year_id' => $this->usr->year_id]);

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_attendance',
            'menu_data' => [
                'curr_menu' => 'SHAREHOLDERS',
                'curr_sub_menu' => 'SHAREHOLDERS'
            ],
            'content_data' => [
                'module_name' => 'Attendance',
                //'attendance' => $attendance,
            ],
            'modals_data' => [
                'modals' => ['modal_add_attendance', 'modal_edit_attendance'],
                //'cds_accounts' => $this->shareholder->getCdsAccounts(NULL, NULL, NULL, TRUE)
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function submitAddAttendance() {

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your seesion might have been expired please refresh the page.');
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $validations = [
                ['field' => 'add_att_form', 'label' => 'Form', 'rules' => 'trim|callback_validateMeetingYear'],
                ['field' => 'cds_number', 'label' => 'CDS account number', 'rules' => 'trim|required|callback_validateCdsOrSh', 'errors' => ['required' => 'CDS Account Number is required otherwise select Representative']],
                ['field' => 'full_name', 'label' => 'User Fullname', 'rules' => 'trim|required'],
                ['field' => 'represented_cds_numbers[]', 'label' => 'represented shareholders', 'rules' => 'trim|callback_validateRepresentedShareHolders'],
                ['field' => 'phone_number', 'label' => 'user phone', 'rules' => 'trim|required|callback_validatePhoneNumber'],
                ['field' => 'address', 'label' => 'user address', 'rules' => 'trim|required'],
                ['field' => 'has_smartphone', 'label' => 'has smartphone', 'rules' => 'trim|callback_validateHasSmartphone', 'errors' => ['required' => 'You should select type of mobile phone of this attendee']]
        ];

        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {

            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'display',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            die();
        } else {

            // Get form data
            $cds_number = $this->input->post('cds_number');
            $rep_cds_numbers = $this->input->post('represented_cds_numbers[]');
            $rep_cds_numbers = !empty($rep_cds_numbers) ? $rep_cds_numbers : [];
            $shareholders = [];
            $vote_status = $this->input->post('has_smartphone') == '2' ? '2' : '1';

            $pin = $this->utl->getSetValue('AGM_PIN');
            if ($cds_number == 'REPRESENTATIVE') {
                $has_smartphone = '2';
            } else {
                $has_smartphone = $this->input->post('has_smartphone');
            }

            $att_status = $has_smartphone == '2' ? '2' : '0';

            $vote_data = [];

            // Get completed and running resolutions 
            $ress = $this->resolution->getResolutions(['res_year_id' => $this->usr->year_id], NULL);

            // If attendee is shareholde then put him as self attendee to his/her shares otherwise initialize represented share holder
            if ($cds_number != 'REPRESENTATIVE') {
                $shareholders[] = [
                    'att_data' => [
                        'att_fullname' => $this->input->post('full_name'),
                        'att_phone_number' => !empty($this->input->post('phone_number')) ? cus_phone_with_255($this->input->post('phone_number')) : '',
                        'att_address' => $this->input->post('address'),
                        'att_has_smartphone' => $has_smartphone,
                        'att_user_id' => $this->usr->user_id,
                        'att_year_id' => $this->usr->year_id,
                        'att_smartphone_pin' => sha1($pin),
                        'att_timestamp' => date('Y-m-d H:i:s'),
                        'att_status' => $att_status,
                        'att_attends_as' => 'SHAREHOLDER'
                    ],
                    'shareholder_data' => [
                        'cds_att_type' => 'SELF',
                        'cds_att_acc_number' => $cds_number,
                        'cds_att_timestamp' => date('Y-m-d H:i:s')
                    ],
                    'is_attendee' => TRUE
                ];
            } else {

                $shareholders[] = [
                    'att_data' => [
                        'att_fullname' => $this->input->post('full_name'),
                        'att_phone_number' => !empty($this->input->post('phone_number')) ? cus_phone_with_255($this->input->post('phone_number')) : '',
                        'att_address' => $this->input->post('address'),
                        'att_has_smartphone' => $has_smartphone,
                        'att_user_id' => $this->usr->user_id,
                        'att_year_id' => $this->usr->year_id,
                        'att_smartphone_pin' => sha1('1234'),
                        'att_timestamp' => date('Y-m-d H:i:s'),
                        'att_status' => $att_status,
                        'att_attends_as' => 'REPRESENTATIVE'
                    ],
                    'shareholder_data' => [],
                    'is_attendee' => TRUE
                ];
            }

            foreach ($rep_cds_numbers as $rcn) {

                $sh = $this->shareholder->getCdsAccounts(NULL, ['cds_acc_number' => $rcn], 1, FALSE);

                if ($sh) {
                    $shareholders[] = [
                        'att_data' => [
                            'att_fullname' => $sh['cds_acc_fullname'],
                            'att_phone_number' => !empty($sh['cds_acc_phone']) ? cus_phone_with_255($sh['cds_acc_phone']) : '',
                            'att_address' => $sh['cds_acc_address'],
                            'att_has_smartphone' => 2,
                            'att_user_id' => $this->usr->user_id,
                            'att_year_id' => $this->usr->year_id,
                            'att_smartphone_pin' => sha1('1234'),
                            'att_timestamp' => date('Y-m-d H:i:s'),
                            'att_status' => 2,
                            'att_attends_as' => 'SHAREHOLDER'
                        ],
                        'shareholder_data' => [
                            'cds_att_type' => 'REPRESENTED',
                            'cds_att_acc_number' => $rcn,
                            'cds_att_timestamp' => date('Y-m-d H:i:s')
                        ],
                        'is_attendee' => FALSE
                    ];
                }
            }

            //echo '<pre>';            print_r($shareholders); die();

            $res = $this->shareholder->saveAttendance(['shareholders' => $shareholders, 'year_id' => $this->usr->year_id, 'vote_data' => $vote_data, 'ress' => $ress]);

            if ($res) {
                log_message(SYSTEM_LOG, 'shareholder/submitAddAttendance - ' . $this->usr->user_email . ' -> ' . $this->input->ip_address() . 'registered new attendee. att_id : ' . $res);
                $this->session->set_flashdata('success', 'Attendance saved successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => TRUE,
                        'redirect_url' => site_url('shareholder/attendance'),
                    ]
                ]);
                die();
            } else {
                cus_json_error('Something went wrong. Attendance was not saved.');
            }
        }
    }

    public function removecdsUpload() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Login is required', 'error', 'user/index');
        }

        $upload_id = $this->uri->segment(3);

        $upload = $this->shareholder->getCdsImportedFiles(NULL, ['cds_upload_id' => $upload_id], 1);

        if (!$upload) {
            $this->usr->setSessMsg('File was not found or may have been removed form the system', 'error', 'shareholder/cdsuploads');
        }

        if (!$this->usr->yearIsActive($this->usr->year_id)) {
            $this->usr->setSessMsg('Unable to remove cds upload because meeting year is closed', 'error', 'shareholder/cdsuploads');
        }

        $res = $this->utl->removeImport($upload, $this->usr->year_id);

        if ($res) {
            $this->usr->setSessMsg('Uploaded cds file removed successfully', 'success', 'shareholder/cdsuploads');
        } else {
            $this->usr->setSessMsg('Something went wrong uploaded CDS file was not removed', 'error', 'shareholder/cdsuploads');
        }
    }

    public function submitEditAttendance() {

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your seesion might have been expired please refresh the page.');
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $validations = [
                ['field' => 'edit_att_form', 'label' => 'Form', 'rules' => 'trim|callback_validateMeetingYear'],
                ['field' => 'edit_cds_number', 'label' => 'CDS account number', 'rules' => 'trim',],
                ['field' => 'edit_full_name', 'label' => 'User Fullname', 'rules' => 'trim|required'],
                ['field' => 'edit_represented_cds_numbers[]', 'label' => 'represented shareholders', 'rules' => 'trim|callback_validateEditRepresentedShareHolders'],
                ['field' => 'edit_phone_number', 'label' => 'user phone', 'rules' => 'trim|required|callback_validateEditPhoneNumber'],
                ['field' => 'edit_address', 'label' => 'user address', 'rules' => 'trim|required'],
                ['field' => 'language', 'label' => 'Attendee language', 'rules' => 'trim|callback_validateEditAttLanguage'],
                ['field' => 'edit_has_smartphone', 'label' => 'has smartphone', 'rules' => 'trim|callback_validateEditHasSmartphone', 'errors' => ['required' => 'You should select type of mobile phone of this attendee']]
        ];

        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {

            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'display',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            die();
        } else {

            // get edited attendance id
            $att_id = $this->uri->segment(3);

            // fetch attendee details
            $att = $this->shareholder->getAttendees(NULL, ['att.att_id' => $att_id], 1);


            // if not exist notify user
            if (!$att) {
                cus_json_error('Attendee was not found or may have been removed from the system');
            }

            $cds_number = $this->shareholder->getAttendace(NULL, ['catt.cds_att_att_id' => $att['att_id'], 'cds_att_type' => 'SELF'], 1);

            if ($cds_number) {
                $cds_number = $cds_number['cds_att_acc_number'];
            } else {
                $cds_number = 'REPRESENTATIVE';
            }

            /*
              $rep_cds_numbers = $this->input->post('edit_represented_cds_numbers[]');
              $rep_cds_numbers = !empty($rep_cds_numbers) ? $rep_cds_numbers : [];
              $shareholders = [];

              $cds_number = $this->shareholder->getAttendace(NULL, ['catt.cds_att_att_id' => $att['att_id'], 'cds_att_type' => 'SELF'], 1);

              if ($cds_number) {
              $cds_number = $cds_number['cds_att_acc_number'];
              } else {
              $cds_number = 'REPRESENTATIVE';
              }

              // Create attendee data to insert
              $attendee_data = [
              'att_fullname' => $this->input->post('edit_full_name'),
              'att_phone_number' => !empty($this->input->post('edit_phone_number')) ? cus_phone_with_255($this->input->post('edit_phone_number')) : '',
              'att_address' => $this->input->post('edit_address'),
              'att_has_smartphone' => $this->input->post('edit_has_smartphone'),
              'att_user_id' => $this->usr->user_id,
              'att_language' => $this->input->post('language')
              //                'att_status' => 0,
              //                'att_wlc_prockey' => NULL,
              //                'att_wlc_retry' => 0
              ];


              // If attendee is shareholde then put him as self attendee to his/her shares otherwise initialize represented share holder
              if ($cds_number != 'REPRESENTATIVE') {
              $shareholders[] = ['cds_att_type' => 'SELF', 'cds_att_acc_number' => $cds_number, 'cds_att_timestamp' => date('Y-m-d H:i:s')];
              }

              foreach ($rep_cds_numbers as $rcn) {
              $shareholders[] = ['cds_att_type' => 'REPRESENTED', 'cds_att_acc_number' => $rcn, 'cds_att_timestamp' => date('Y-m-d H:i:s')];
              } */


            // Get form data
            $rep_cds_numbers = $this->input->post('edit_represented_cds_numbers[]');
            $rep_cds_numbers = !empty($rep_cds_numbers) ? $rep_cds_numbers : [];
            $shareholders = [];
            $vote_status = $this->input->post('edit_has_smartphone') == '2' ? '2' : '1';



            if ($cds_number == 'REPRESENTATIVE') {
                $has_smartphone = '2';
            } else {
                $has_smartphone = $this->input->post('eidt_has_smartphone');
            }

            $att_status = $has_smartphone == '2' ? '2' : '0';


            // If attendee is shareholde then put him as self attendee to his/her shares otherwise initialize represented share holder
            if ($cds_number != 'REPRESENTATIVE') {
                $shareholders[] = [
                    'att_data' => [
                        'att_fullname' => $this->input->post('edit_full_name'),
                        'att_phone_number' => !empty($this->input->post('edit_phone_number')) ? cus_phone_with_255($this->input->post('phone_number')) : '',
                        'att_address' => $this->input->post('edit_address'),
                        'att_has_smartphone' => $has_smartphone,
                        'att_user_id' => $this->usr->user_id,
                        'att_year_id' => $this->usr->year_id,
                        'att_smartphone_pin' => sha1('1234'),
                        'att_timestamp' => date('Y-m-d H:i:s'),
                        'att_status' => $att_status,
                        'att_attends_as' => 'SHAREHOLDER'
                    ],
                    'shareholder_data' => [
                        'cds_att_type' => 'SELF',
                        'cds_att_acc_number' => $cds_number,
                        'cds_att_timestamp' => date('Y-m-d H:i:s')
                    ],
                    'is_attendee' => TRUE
                ];
            } else {

                $shareholders[] = [
                    'att_data' => [
                        'att_fullname' => $this->input->post('edit_full_name'),
                        'att_phone_number' => !empty($this->input->post('edit_phone_number')) ? cus_phone_with_255($this->input->post('phone_number')) : '',
                        'att_address' => $this->input->post('edit_address'),
                        'att_has_smartphone' => $has_smartphone,
                        'att_user_id' => $this->usr->user_id,
                        'att_year_id' => $this->usr->year_id,
                        'att_smartphone_pin' => sha1('1234'),
                        'att_timestamp' => date('Y-m-d H:i:s'),
                        'att_status' => $att_status,
                        'att_attends_as' => 'REPRESENTATIVE'
                    ],
                    'shareholder_data' => [],
                    'is_attendee' => TRUE
                ];
            }

            foreach ($rep_cds_numbers as $rcn) {

                $sh = $this->shareholder->getCdsAccounts(NULL, ['cds_acc_number' => $rcn], 1, FALSE);

                if ($sh) {
                    $shareholders[] = [
                        'att_data' => [
                            'att_fullname' => $sh['cds_acc_fullname'],
                            'att_phone_number' => !empty($sh['cds_acc_phone']) ? cus_phone_with_255($sh['cds_acc_phone']) : '',
                            'att_address' => $sh['cds_acc_address'],
                            'att_has_smartphone' => 2,
                            'att_user_id' => $this->usr->user_id,
                            'att_year_id' => $this->usr->year_id,
                            'att_smartphone_pin' => sha1('1234'),
                            'att_timestamp' => date('Y-m-d H:i:s'),
                            'att_status' => 2,
                            'att_attends_as' => 'SHAREHOLDER'
                        ],
                        'shareholder_data' => [
                            'cds_att_type' => 'REPRESENTED',
                            'cds_att_acc_number' => $rcn,
                            'cds_att_timestamp' => date('Y-m-d H:i:s')
                        ],
                        'is_attendee' => FALSE
                    ];
                }
            }

            $res = $this->shareholder->saveEditAttendance(['shareholders' => $shareholders, 'year_id' => $this->usr->year_id, 'att_id' => $att['att_id']]);

            if ($res) {
                log_message(SYSTEM_LOG, 'shareholder/submitEditAttendance - ' . $this->usr->user_email . ' -> ' . $this->input->ip_address() . 'edited attendee details. att_id : ' . $att['att_id']);
                $this->session->set_flashdata('success', 'Attendance changes saved successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => TRUE,
                        'redirect_url' => site_url('shareholder/attendance'),
                    ]
                ]);
                die();
            } else {
                cus_json_error('Something went wrong. Attendance changes was not saved.');
            }
        }
    }

    public function submitImportCdsAccounts() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');


        if (!$this->usr->is_logged_in) {
            cus_json_error('Your seesion might have been expired please refresh the page.');
        }

        $validations = [
                ['field' => 'form', 'label' => 'form', 'rules' => 'callback_validateImportForm'],
                ['field' => 'file', 'label' => 'file', 'rules' => 'callback_validateImportFile'],
                ['field' => 'upload_notes', 'label' => 'upload notes', 'rules' => 'trim'],
        ];

        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {

            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'display',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            die();
        } else {

            $notes = $this->input->post('upload_notes');
            $current_cds_accounts = $this->shareholder->getCdsAccounts(NULL, ['cds_acc_year_id' => $this->usr->year_id]);

            $cds_numbers = array_column($current_cds_accounts, 'cds_acc_number');

            $temp_file = $this->shareholder->getCdsImportedFiles(NULL, ['cds_upload_user_id' => $this->usr->user_id, 'cds_upload_status' => 'TEMP'], 1);

            $shareholders = [];
            $ignored_rows = 0;

            $path = './uploads/imports/' . $temp_file['cds_upload_file_path'];
            //Remove Image
            if (!file_exists($path)) {
                cus_json_error('File was not found, please refresh the page');
            }

            // Importing excel file and read it
            require_once APPPATH . '/third_party/Phpexcel/Bootstrap.php';

            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
            $excel_obj = $reader->load($path);
            $work_sheet = $excel_obj->getActiveSheet();
            $last_rows = $work_sheet->getHighestRow();

            for ($i = IMPORT_START_ROW; $i <= $last_rows; $i++) {

                $cds_number = $work_sheet->getCell(COL_SHAREHOLDER_CDS_NUMBER . $i)->getValue();
                $full_name = $work_sheet->getCell(COL_SHAREHOLDER_NAME . $i)->getValue();

                // Checks if row has CDS number and full name so we make sure its a valid share holder
                if (!empty($cds_number) AND ! empty($full_name) AND ! in_array($cds_number, $cds_numbers)) {
                    $excel_phone_number = $work_sheet->getCell(COL_SHAREHOLDER_PHONE_NUMBER . $i)->getValue();
                    $shareholders[] = [
                        'cds_acc_upload_id' => (int) $temp_file['cds_upload_id'],
                        'cds_acc_year_id' => (int) $this->usr->year_id,
                        'cds_acc_number' => $cds_number,
                        'cds_acc_timestamp' => date('Y-m-d H:i:s'),
                        'cds_acc_fullname' => $full_name,
                        'cds_acc_phone' => !empty($excel_phone_number) ? cus_phone_with_255($excel_phone_number) : '',
                        'cds_acc_address' => (string) $work_sheet->getCell(COL_SHAREHOLDER_ADDRESS . $i)->getValue(),
                        'cds_acc_shares' => (int) $work_sheet->getCell(COL_SHAREHOLDER_SHARES . $i)->getValue(),
                        'cds_acc_nationality' => (string) $work_sheet->getCell(COL_SHAREHOLDER_NATIONALITY . $i)->getValue(),
                        'cds_acc_address_2' => (string) $work_sheet->getCell(COL_SHAREHOLDER_ADDRESS_2 . $i)->getValue(),
                        'cds_acc_address_3' => (string) $work_sheet->getCell(COL_SHAREHOLDER_ADDRESS_3 . $i)->getValue(),
                        'cds_acc_address_4' => (string) $work_sheet->getCell(COL_SHAREHOLDER_ADDRESS_4 . $i)->getValue(),
                        'cds_acc_next_of_kin' => (string) $work_sheet->getCell(COL_SHAREHOLDER_NEXT_OF_KIN . $i)->getValue(),
                        'cds_acc_phone_2' => (string) $work_sheet->getCell(COL_SHAREHOLDER_PHONE_NUMBER_2 . $i)->getValue(),
                        'cds_acc_email' => (string) $work_sheet->getCell(COL_SHAREHOLDER_EMAIL . $i)->getValue(),
                        'cds_acc_contract_1' => (string) $work_sheet->getCell(COL_SHAREHOLDER_CONTRACT_1 . $i)->getValue(),
                        'cds_acc_contract_2' => (string) $work_sheet->getCell(COL_SHAREHOLDER_CONTRACT_2 . $i)->getValue(),
                        'cds_acc_id' => (string) $work_sheet->getCell(COL_SHAREHOLDER_ID . $i)->getValue()
                    ];
                } else {
                    $ignored_rows++;
                }
            }

            $file_data = [
                'cds_upload_status' => 'PROCESSED',
                'cds_upload_notes' => $notes,
                'cds_upload_year_id' => (int) $this->usr->year_id, 'cds_upload_ignored_rows' => $ignored_rows
            ];

            $res = $this->shareholder->saveCdsImport(['shareholders' => $shareholders, 'file_data' => $file_data, 'upload_id' => $temp_file['cds_upload_id'], 'year_id' => $this->usr->year_id]);

            if ($res) {
                log_message(SYSTEM_LOG, 'shareholder/submitImportCdsAccounts - ' . $this->usr->user_email . ' -> ' . $this->input->ip_address() . 'imported  CDS Accounts from excel.');
                $this->session->set_flashdata('success', 'CDS accounts uploaded successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => TRUE,
                        'redirect_url' => site_url('shareholder/cdsuploads')
                    ]
                ]);

                die();
            } else {
                cus_json_error('Something went wrong. Refresh the page and try again.');
            }
        }
    }

    public function editAttendance() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');


        if (!$this->usr->is_logged_in) {
            cus_json_error('Your seesion might have been expired please refresh the page.');
        }

        $att_id = $this->uri->segment(3);

        $att = $this->shareholder->getAttendees(NULL, ['att.att_id' => $att_id], 1);

        if (!$att) {
            cus_json_error('Attendee was not found or may have been removed from the system');
        }

        $att_cds_number = $this->shareholder->getAttendace(NULL, ['catt.cds_att_rep_id' => $att['att_id'], 'cds_att_type' => 'SELF'], 1);

        if ($att_cds_number) {
            $att_cds_number = $att_cds_number['cds_att_acc_number'];
        } else {
            $att_cds_number = 'REPRESENTATIVE';
        }

        $selected_cds_accounts = $this->shareholder->getAttendace(NULL, ['catt.cds_att_rep_id' => $att['att_id'], 'cds_att_type <>' => 'SELF']);

        $available_cds_accounts = $this->shareholder->getCdsAccounts(NULL, ['cds_acc_year_id' => $this->usr->year_id], NULL, TRUE);

        $cds_accounts[] = ['text' => '', 'id' => ''];


        foreach ($selected_cds_accounts as $key => $acc) {
            $cds_accounts[] = ['text' => $acc['cds_acc_number'] . ' - ' . $acc['cds_acc_fullname'], 'id' => $acc['cds_acc_number']];
        }

        foreach ($available_cds_accounts as $key => $acc) {
            $cds_accounts[] = ['text' => $acc['cds_acc_number'] . ' - ' . $acc['cds_acc_fullname'], 'id' => $acc['cds_acc_number']];
        }

        $selected_cds_accounts = array_column($selected_cds_accounts, 'cds_acc_number');

        $json = json_encode([
            'status' => [
                'error' => FALSE,
                'redirect' => FALSE,
                'pop_form' => TRUE,
                'form_type' => 'editAttendance',
                'form_url' => site_url('shareholder/submitEditAttendance/' . $att['att_id'])
            ],
            'selected_cds' => $selected_cds_accounts,
            'cds_accounts' => $cds_accounts,
            'att' => $att,
            'att_cds_number' => $att_cds_number
        ]);

        echo $json;
    }

    public function deleteAttendee() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Login is required!', 'error', 'user');
        }

        //get attendee

        $att_id = $this->uri->segment(3);
        $att = $this->shareholder->getAttendees(NULL, ['att.att_id' => $att_id], 1);

        if (!$att) {
            $this->usr->setSessMsg('Attendee may have already been removed', 'error', 'shareholder/attendance');
        }

//        $votes = $this->voting->getVoteAnswers(['att.att_id' =>$att['att_id']], NULL, 1);
//        
//        if($votes){
//            $this->usr->setSessMsg('Attendee can not be removed because he/she is already voted for one or more resolutions', 'error', 'shareholder/attendance');
//        }

        $res = $this->shareholder->confirmDeleteAttendee($att['att_id']);

        if ($res) {
            $this->usr->setSessMsg('Attendee removed successfully', 'success', 'shareholder/attendance');
        } else {
            $this->usr->setSessMsg('Nothing has changed', 'warning', 'shareholder/attendance');
        }
    }

    // Form validations
    public function validateRepresentedShareHolders($rep_cds_number) {

        $cds_number = $this->input->post('cds_number');


        if ($cds_number == 'REPRESENTATIVE' AND empty($rep_cds_number)) {
            $this->form_validation->set_message('validateRepresentedShareHolders', 'You should select atleast one shareholder to be presented by this attendee');
            return FALSE;
        }

        $shareholder = $this->shareholder->getAttendace(NULL, ['cds_att_acc_number' => $rep_cds_number], 1);

        if ($shareholder) {
            $msg = $shareholder['cds_att_type'] == 'SELF' ? $shareholder['cds_acc_fullname'] . ' is already registered' : $shareholder['cds_acc_fullname'] . ' is represented by ' . $shareholder['att_fullname'];
            $this->form_validation->set_message('validateRepresentedShareHolders', $msg);
        }

        return TRUE;
    }

    public function validateEditRepresentedShareHolders($rep_cds_number) {

        $att_id = $this->uri->segment(3);

        $att = $this->shareholder->getAttendees(NULL, ['att.att_id' => $att_id], 1);

        if (!$att) {
            cus_json_error('Attendee was not found or may have been removed from the system');
        }

        $att_cds_number = $this->shareholder->getAttendace(NULL, ['catt.cds_att_att_id' => $att['att_id'], 'cds_att_type' => 'SELF'], 1);

        if ($att_cds_number) {
            $cds_number = $att_cds_number['cds_att_acc_number'];
        } else {
            $cds_number = 'REPRESENTATIVE';
        }


        if ($cds_number == 'REPRESENTATIVE' AND empty($rep_cds_number)) {
            $this->form_validation->set_message('validateEditRepresentedShareHolders', 'You should select atleast one shareholder to be presented by this attendee');
            return FALSE;
        }

        $shareholder = $this->shareholder->getAttendace(NULL, ['cds_att_acc_number' => $rep_cds_number], 1);

        if ($shareholder) {
            $msg = $shareholder['cds_att_type'] == 'SELF' ? $shareholder['cds_acc_fullname'] . ' is already registered' : $shareholder['cds_acc_fullname'] . ' is represented by ' . $shareholder['att_fullname'];
            $this->form_validation->set_message('validateEditRepresentedShareHolders', $msg);
        }

        return TRUE;
    }

    public function validateCdsOrSh($cds_number) {

        $shareholder_exist = $this->shareholder->getCdsAccounts(NULL, ['cds_acc_number' => $cds_number], 1);

        if (!$shareholder_exist AND $cds_number != 'REPRESENTATIVE') {
            $this->form_validation->set_message('validateCdsOrSh', 'Select a valid shareholder CDS account number');
            return FALSE;
        }

        $shareholder = $this->shareholder->getAttendace(NULL, ['cds_att_acc_number' => $cds_number], 1);
        if ($shareholder) {
            $msg = $shareholder['cds_att_type'] == 'SELF' ? $shareholder['cds_acc_fullname'] . ' is already registered' : $shareholder['cds_acc_fullname'] . ' is represented by ' . $shareholder['att_fullname'];
            $this->form_validation->set_message('validateCdsOrSh', $msg);
        }
        return TRUE;
    }

    public function validateImportFile() {

        $temp_file = $this->shareholder->getCdsImportedFiles(NULL, ['cds_upload_user_id' => $this->usr->user_id, 'cds_upload_status' => 'TEMP'], 1);

        if (!$temp_file) {
            $this->form_validation->set_message('validateImportFile', 'You shoul attach an excel file to continue.');
            return FALSE;
        }
    }

    public function validatePhoneNumber($phone_number) {

        $phone_type = $this->input->post('has_smartphone');
        $cds_number = $this->input->post('cds_number');

        if (in_array($phone_type, [1, 0]) AND empty(trim($phone_number)) AND $cds_number != 'REPRESENTATIVE') {
            $this->form_validation->set_message('validatePhoneNumber', 'Phone number field is required if attendee has a mobile phone');
            return FALSE;
        }


//        elseif (in_array($phone_type, [2]) AND ! empty(trim($phone_number))) {
//            $this->form_validation->set_message('validatePhoneNumber', 'If attendee does not have mobile phone this field should be empty');
//            return FALSE;
//        }

        if (!empty($phone_number)) {

            $res = $this->shareholder->getAttendees(NULL, ['att_phone_number' => cus_phone_with_255($phone_number), 'att_year_id' => $this->usr->year_id], 1);
            if ($res) {
                $this->form_validation->set_message('validatePhoneNumber', 'Phone number is already been registered to ' . $res['att_fullname']);
                return FALSE;
            }
        }

        return TRUE;
    }

    public function validateEditPhoneNumber($phone_number) {

        $att_id = $this->uri->segment(3);

        $att = $this->shareholder->getAttendees(NULL, ['att.att_id' => $att_id], 1);

        if (!$att) {
            cus_json_error('Attendee was not found or may have been removed from the system');
        }

        $att_cds_number = $this->shareholder->getAttendace(NULL, ['catt.cds_att_att_id' => $att['att_id'], 'cds_att_type' => 'SELF'], 1);

        if ($att_cds_number) {
            $cds_number = $att_cds_number['cds_att_acc_number'];
        } else {
            $cds_number = 'REPRESENTATIVE';
        }

        $phone_type = $this->input->post('edit_has_smartphone');

        if (in_array($phone_type, [1, 0]) AND empty(trim($phone_number)) AND $cds_number != 'REPRESENTATIVE') {
            $this->form_validation->set_message('validateEditPhoneNumber', 'Phone number field is required if attendee has a mobile phone');
            return FALSE;
        }

//        elseif (in_array($phone_type, [2]) AND ! empty(trim($phone_number)) AND $cds_number != 'REPRESENTATIVE') {
//            $this->form_validation->set_message('validateEditPhoneNumber', 'If attendee does not have mobile phone this field should be empty');
//            return FALSE;
//        }

        if (!empty($phone_number)) {

            $res = $this->shareholder->getAttendees(NULL, ['att_phone_number' => cus_phone_with_255($phone_number), 'att_year_id' => $this->usr->year_id, 'att_id <>' => $att['att_id']], 1);
            if ($res) {
                $this->form_validation->set_message('validateEditPhoneNumber', 'Phone number is already been registered to ' . $res['att_fullname']);
                return FALSE;
            }
        }
        return TRUE;
    }

    public function validateEditAttLanguage($language) {

        $att_id = $this->uri->segment(3);

        $att = $this->shareholder->getAttendees(NULL, ['att.att_id' => $att_id], 1);

        if (!$att) {
            cus_json_error('Attendee was not found or may have been removed from the system');
        }

        if ($att['att_attends_as'] != 'REPRESENTATIVE' AND empty($language)) {
            $this->form_validation->set_message('validateEditAttLanguage', 'Attendee language is required field');
            return FALSE;
        }


        return TRUE;
    }

    public function validateImportForm() {

        $res = $this->resolution->getResolutions("(res.res_status IN('COMPLETED','RUNNING') AND res.res_year_id = '" . $this->usr->year_id . "' )", NULL, 1);

        if ($res) {
            $this->form_validation->set_message('validateImportForm', 'CDS Accounts cannot be uploaded because resolution voting has started');
            return FALSE;
        }

        if (!$this->usr->yearIsActive($this->usr->year_id)) {
            $this->form_validation->set_message('validateImportForm', 'CDS Accounts cannot be uploaded because resolution year is closed');
            return FALSE;
        }

        return TRUE;
    }

    public function validateHasSmartphone($has_smartphone) {

        $cds_number = $this->input->post('cds_number');


        if ($cds_number != 'REPRESENTATIVE' AND ! in_array($has_smartphone, ['0', '1', '2'])) {
            $this->form_validation->set_message('validateHasSmartphone', 'Attendee voting channel is required');
            return FALSE;
        }
        return TRUE;
    }

    public function validateEditHasSmartphone($has_smartphone) {

        $att_id = $this->uri->segment(3);

        $att = $this->shareholder->getAttendees(NULL, ['att.att_id' => $att_id], 1);

        if (!$att) {
            cus_json_error('Attendee was not found or may have been removed from the system');
        }


        if ($att['att_attends_as'] != 'REPRESENTATIVE' AND ! in_array($has_smartphone, [0, 1, 2])) {
            $this->form_validation->set_message('validateEditHasSmartphone', 'Attendee voting channel is required');
            return FALSE;
        }

        return TRUE;
    }

    public function validateMeetingYear() {

        if (!$this->usr->yearIsActive($this->usr->year_id)) {
            $this->form_validation->set_message('validateMeetingYear', 'Your form cannot be submitted because the meeting year is closed');
            return FALSE;
        }

        return TRUE;
    }

}
