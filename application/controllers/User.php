<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        if (isset($this->session->userdata['otp'])) {
            redirect('user/otp');
        }

        // Check if user has already logged in and redirect to dashboard
        if ($this->usr->isLogedin()) {
            redirect('trpi/requests');
        }


        // Prepare error message
        $content_data['alert'] = "";

        if (null !== $this->session->flashdata('error')) {
            $content_data['alert'] .= '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('error') . '</div>';
        }
        if (null !== $this->session->flashdata('success')) {
            $content_data['alert'] .= '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('success') . '</div>';
        }

        $this->load->view('contents/view_login', $content_data);
    }

    public function validateAd($user_ref, $pass) {

        if (TESTING_MODE) {
            return TRUE;
        }

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
    }

    public function validatePassword($pass) {

        $username = $this->input->post('loginUsername');
        if (!empty($username)) {

            if (!$this->validateAd($username, $pass)) {
                $this->form_validation->set_message('validatePassword', 'Username or password is incorrect');
                return FALSE;
            } else {
                return TRUE;
            }
        }
        return TRUE;
    }

    public function otp() {

        if (!isset($this->session->userdata['otp'])) {
            if (!$this->usr->is_logged_in) {
                $this->usr->setSessMsg('Your session may have been expired, Please login again', 'error', 'user');
            } else {
                redirect('user/dashboard');
            }
        }
        // Prepare error message
        $data['alert'] = "";

        if (null !== $this->session->flashdata('error')) {
            $data['alert'] .= '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('error') . '</div>';
        }
        if (null !== $this->session->flashdata('success')) {
            $data['alert'] .= '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('success') . '</div>';
        }

        $this->load->view('contents/view_2fa', $data);
    }

    public function multipleLoginAttempt() {

        if (!isset($this->session->userdata['multipleloginattempt'])) {
            if (!$this->usr->is_logged_in) {
                $this->usr->setSessMsg('Your session may have been expired, Please login again', 'error', 'user');
            } else {
                redirect('user/dashboard');
            }
        }
        // Prepare error message
        $data['alert'] = "";

        if (null !== $this->session->flashdata('error')) {
            $data['alert'] .= '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('error') . '</div>';
        }
        if (null !== $this->session->flashdata('success')) {
            $data['alert'] .= '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('success') . '</div>';
        }

        $this->load->view('contents/view_multiple_login', $data);
    }

    public function submitLogin() {

        // Validate Login Credentials
        $this->form_validation->set_error_delimiters('<p class="rmv_error text-danger">', '</p>');
        $validations = [
                ['field' => 'loginUsername', 'label' => 'Username', 'rules' => 'trim|required'],
                ['field' => 'loginPassword', 'label' => 'Password', 'rules' => 'trim|required|callback_validatePassword']
        ];

        $usn = $this->input->post('loginUsername');

        log_message(SYSTEM_LOG, 'user/submitLogin - ' . $usn . ' -> ' . $this->input->ip_address() . 'Attempting to login');
        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {
            log_message(SYSTEM_LOG, 'user/submitLogin - ' . $usn . ' -> ' . $this->input->ip_address() . 'User Login failed');
            $this->index();
        } else {

            $user = [
                'ad_name' => $usn,
                'phone_number' => "",
                'full_name' => "",
                'token' => sha1(rand(1111, 9999)),
                'driver_details' => FALSE,
                'role' => 'NONE',
                'page' => '',
                'email' => ''
            ];

            $page = "";

            $manager = $this->approval->getApprovalOfficials(NULL, ['ao_ad_name' => $usn], 1);

            $driver = $this->driver->getDriverProfiles(NULL, ['dp.dp_ad_name' => $usn], 1);
            $hod = $this->mnt->getDepartments(NULL, ['dept_hod_ad_name' => $usn], 1);
            $lm = $this->mnt->getSections(NULL, ['sec_tl_ad_name' => $usn], 1);


            if ($manager) {
                // if is Manager
                $user['ad_name'] = $manager['ao_ad_name'];
                $user['phone_number'] = $manager['ao_phone_number'];
                $user['full_name'] = $manager['ao_full_name'];
                $user['role'] = 'LINE MANAGER';
                $user['email'] = $manager['ao_email'];

                $page = "HOME";
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => user/submitLogin => ' . $usn . ' - Logon user is Line Manager');
            
                
            } elseif ($hod) {
                // if is HOD
                $user['ad_name'] = $hod['dept_hod_ad_name'];
                $user['phone_number'] = $hod['dept_hod_phone'];
                $user['full_name'] = $hod['dept_hod_full_name'];
                $user['role'] = 'HOD';
                $user['email'] = $hod['dept_hod_email'];

                $page = "HOME";
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => user/submitLogin => ' . $usn . ' - Logon user is HOD');
            } elseif ($lm) {

                // If is line manager
                $user['ad_name'] = $lm['sec_tl_ad_name'];
                $user['phone_number'] = $lm['sec_tl_phone_number'];
                $user['full_name'] = $lm['sec_tl_full_name'];
                $user['role'] = 'LINE MANAGER';
                $user['email'] = $lm['sec_tl_email'];
                $page = "HOME";

                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => user/submitLogin => ' . $usn . ' - Logon user is Line Manager');
            } elseif ($driver) {

                // If user is driver
                $driver_details = [
                    "name" => $driver['dp_full_name'],
                    "phone" => $driver["dp_phone_number"],
                    "email" => $driver["dp_email"],
                    "dept" => $driver["dp_dept_id"],
                    "section" => $driver["dp_section_id"],
                    "license" => $driver["dp_license_number"],
                    "license_expiry" => date('Y-m-d', strtotime($driver["dp_license_expiry"])),
                    "licence_attachments" => [],
                    "line_manager" => $driver['sec_tl_full_name'] . ' - ' . $driver['sec_tl_phone_number'],
                    "dept_section" => $driver['dept_name'] . ' - ' . $driver['sec_name']
                ];

                $user['ad_name'] = $driver['dp_ad_name'];
                $user['phone_number'] = $driver['dp_phone_number'];
                $user['full_name'] = $driver['dp_full_name'];
                $user['driver_details'] = $driver_details;
                $user['email'] = $driver['dp_email'];
                $user['role'] = 'DRIVER';

                $page = "HOME";
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => user/submitLogin => ' . $usn . ' - Logon user is Driver');
            } else {
                $user['role'] = 'DRIVER';
                $page = 'UPDATE_DRIVER_PROFILE';
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => user/submitLogin => ' . $usn . ' - Logon user is NEW so will have to update his/her driver profile');
            }

            $user['page'] = $page;

            $this->session->set_userdata([
                'logged_in' => $user
            ]);


            switch ($page) {
                case 'HOME':
                    redirect('trip/requests');
                    break;
                case 'UPDATE_DRIVER_PROFILE':
                    redirect('driver/updateprofile');
                    break;
            }


            /*

              $this->load->library('user_agent');
              $user_agent = $this->agent->agent_string();

              $user_ref = $this->input->post('loginUsername');
              $user = $this->usr->getAnymousUser($user_ref);

              if ($user) {

              if (!in_array($user['usr_status'], ['DELETED', 'ACTIVE', 'INACTIVE'])) {
              $this->usr->setSessMsg('Your has an invalid status, Please contact system admin.', 'error', 'user');
              }

              if ($user['usr_status'] == 'DELETED') {
              $this->usr->setSessMsg('Your account was deleted, Please contact system admin.', 'error', 'user');
              }

              if ($user['usr_status'] == 'INACTIVE') {
              $this->usr->setSessMsg('Your account is INACTIVE, Please contact system admin.', 'error', 'user');
              }


              // Check if user is to be validate with OTP
              if ($user['usr_2fa_enabled'] == '1') {
              $sms_sender = $this->utl->getSetValue('SMS_SENDER');
              $otp = rand(10, 99) . rand(10, 99);
              $this->session->set_userdata(['otp' => ['user_id' => $user['usr_id']]]);
              $this->usr->saveEditUser(['usr_otp' => sha1($otp)], $user['usr_id']);
              $msg = sprintf($this->utl->getSMSFormat('YCC_OTP'), $otp);
              $this->utl->saveMessage([
              'sms_msisdn' => cus_phone_with_255($user['usr_phone']),
              'sms_from' => $sms_sender['st_value'],
              'sms_text' => $msg,
              'sms_status' => 'RECORDED',
              'sms_rec_date' => date('Y-m-d H:i:s')
              ]);

              redirect('user/otp');
              }


              if ($user['usr_logged_in'] == '1') {
              $this->session->set_userdata(['multipleloginattempt' => ['user_id' => $user['usr_id']]]);
              redirect('user/multipleloginattempt');
              }

              // Continue if user dont have to be validated with 2FA
              log_message(SYSTEM_LOG, 'user/submitLogin - ' . $user_ref . ' -> ' . $this->input->ip_address() . 'Logged in successfully');
              $this->usr->saveEditUser(['usr_last_login' => date('Y-m-d H:i:s'), 'usr_user_agent' => sha1($user_agent), 'usr_logged_in' => 1, 'usr_last_activity_time' => date('Y-m-d H:i:s')], $user['usr_id']);
              $this->session->set_userdata([
              'logged_in' => [
              'user_id' => $user['usr_id'],
              'user_fullname' => $user['usr_fullname'],
              'user_role' => $user['usr_role'],
              'user_email' => $user['usr_email'],
              'user_ad_name' => $user['usr_ad_name']
              ]
              ]);
              redirect('user/dashboard');
              } else {
              log_message(SYSTEM_LOG, 'user/submitLogin - ' . $this->input->post('loginUsername') . ' -> ' . $this->input->ip_address() . 'Logged in successfully but failed to fetch userdata');
              $this->session->set_flashdata('error', 'Your username was not found in the system');
              redirect('user');
              }

             */
        }
    }

    public function submitMultipleLoginAttempt() {

        if (!isset($this->session->userdata['multipleloginattempt'])) {
            if (!$this->usr->is_logged_in) {
                $this->usr->setSessMsg('Your session may have been expired, Please login again', 'error', 'user');
            } else {
                redirect('user/dashboard');
            }
        }

        $this->load->library('user_agent');
        $user_agent = $this->agent->agent_string();
        $user_id = $this->session->userdata['multipleloginattempt']['user_id'];

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            $this->usr->setSessMsg("Your account can't be found.", 'error', 'user/logout');
        }


        log_message(SYSTEM_LOG, 'user/submitMultipleLoginAttempt - ' . $user['usr_ad_name'] . ' -> ' . $this->input->ip_address() . 'Exchang user browser');

        if (isset($this->session->userdata['multipleloginattempt'])) {
            $this->session->unset_userdata('multipleloginattempt');
        }

        $this->usr->saveEditUser(['usr_last_login' => date('Y-m-d H:i:s'), 'usr_user_agent' => sha1($user_agent), 'usr_logged_in' => 1, 'usr_last_activity_time' => date('Y-m-d H:i:s')], $user['usr_id']);
        $this->session->set_userdata([
            'logged_in' => [
                'user_id' => $user['usr_id'],
                'user_fullname' => $user['usr_fullname'],
                'user_role' => $user['usr_role'],
                'user_email' => $user['usr_email'],
                'user_ad_name' => $user['usr_ad_name']
            ]
        ]);
        redirect('user/dashboard');
    }

    public function submitOtp() {

        if (!isset($this->session->userdata['otp'])) {
            if (!$this->usr->is_logged_in) {
                $this->usr->setSessMsg('Your session may have been expired, Please login again', 'error', 'user');
            } else {
                redirect('user/dashboard');
            }
        }
        $this->load->library('user_agent');
        $user_agent = $this->agent->agent_string();


        $user_id = $this->session->userdata['otp']['user_id'];

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            $this->usr->setSessMsg("Your account can't be found.", 'error', 'user/logout');
        }

        // Validate OTP 
        $this->form_validation->set_error_delimiters('<p class="rmv_error text-danger">', '</p>');
        $validations = [
                ['field' => 'otp', 'label' => 'One time PIN', 'rules' => 'trim|required|callback_validateOtp[' . $user_id . ']']
        ];



        log_message(SYSTEM_LOG, 'user/submitOtp - ' . $user['usr_ad_name'] . ' -> ' . $this->input->ip_address() . 'Sumitting OTP');
        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {
            log_message(SYSTEM_LOG, 'user/submitOtp - ' . $user['usr_ad_name'] . ' -> ' . $this->input->ip_address() . 'User Login failed');
            $this->otp();
        } else {



            if (isset($this->session->userdata['otp'])) {
                $this->session->unset_userdata('otp');
            }


            if ($user['usr_logged_in'] == '1') {
                $this->session->set_userdata(['multipleloginattempt' => ['user_id' => $user['usr_id']]]);
                redirect('user/multipleloginattempt');
            }

            log_message(SYSTEM_LOG, 'user/submitOtp - ' . $user['usr_ad_name'] . ' -> ' . $this->input->ip_address() . 'Logged in successfully');
            //$this->usr->saveEditUser(['usr_last_login' => date('Y-m-d H:i:s')], $user['usr_id']);
            $this->usr->saveEditUser(['usr_last_login' => date('Y-m-d H:i:s'), 'usr_user_agent' => sha1($user_agent), 'usr_logged_in' => 1, 'usr_last_activity_time' => date('Y-m-d H:i:s')], $user['usr_id']);
            $this->session->set_userdata([
                'logged_in' => [
                    'user_id' => $user['usr_id'],
                    'user_fullname' => $user['usr_fullname'],
                    'user_role' => $user['usr_role'],
                    'user_email' => $user['usr_email'],
                    'user_ad_name' => $user['usr_ad_name']
                ]
            ]);
            redirect('user/dashboard');
        }
    }

    public function validateOtp($otp, $user_id) {

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            $this->usr->setSessMsg("Your account can't be found.", 'error', 'user/logout');
        }

        if (empty($otp)) {
            return TRUE;
        }

        if ($user['usr_otp'] != sha1($otp)) {
            log_message(SYSTEM_LOG, 'user/validateOtp - ' . $user['usr_ad_name'] . ' -> ' . $this->input->ip_address() . 'Invalid OTP encountered');
            $this->form_validation->set_message('validateOtp', 'You have entered an invalid OTP');
            return FALSE;
        }

        return TRUE;
    }

    public function logout() {

        if (null !== $this->session->flashdata('error')) {
            $this->session->set_flashdata('error', $this->session->flashdata('error'));
        }

        if (null !== $this->session->flashdata('error')) {
            $this->session->set_flashdata('error', $this->session->flashdata('error'));
        }

        if (isset($this->session->userdata['otp'])) {
            $this->session->unset_userdata('otp');
        }

        if (isset($this->session->userdata['multipleloginattempt'])) {
            $this->session->unset_userdata('multipleloginattempt');
        }

        if (isset($this->session->userdata['logged_in'])) {

            log_message(SYSTEM_LOG, 'user/logout - ' . $this->usr->ad_name . '  ' . $this->input->ip_address() . 'Logged out');
            //$this->usr->saveEditUser(['usr_logged_in' => 0], $this->usr->user_id);
            $this->session->unset_userdata('logged_in');
            redirect('user/index');
        } else {
            redirect('user/index');
        }
    }

    // User management

    public function userList() {


        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Login is required', 'error', 'user/index');
        }

        $user_roles = $this->utl->getOptions('USER_ROLE');

        $cond = ['usr_status <>' => 'DELETED'];
        $users = $this->usr->getUsersList($cond);



        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_users',
            'menu_data' => [
                'curr_menu' => 'CONFIG',
                'curr_sub_menu' => 'CONFIG'
            ],
            'content_data' => [
                'module_name' => 'User Management',
                'users' => $users,
            ],
            'modals_data' => [
                'modals' => ['modal_add_user', 'modal_edit_user'],
                'user_roles' => $user_roles
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function editUser() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your session might have been expired. Please refresh the page');
        }

        $edit_user_id = $this->uri->segment(3);
        $user = $this->usr->getUserInfo($edit_user_id, 'ID');


        if ($user) {

            log_message(SYSTEM_LOG, 'user/editUser - ' . $this->usr->user_ad_name . ' ' . $this->input->ip_address() . 'Attempting to edit user: ' . $user['usr_email']);

            echo json_encode([
                'status' => [
                    'error' => FALSE,
                    'redirect' => FALSE,
                    'pop_form' => TRUE,
                    'form_type' => 'editUser',
                    'form_url' => site_url('user/submitedituser/' . $user['usr_id'])
                ],
                'user_data' => $user
            ]);

            die();
        } else {
            cus_json_error('User not found.');
        }
    }

    public function submitUser() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your session might have been expired. Please refresh the page');
        }


        $validations = [
                ['field' => 'full_name', 'label' => 'User Fullname', 'rules' => 'trim|required'],
                ['field' => 'email', 'label' => 'User Email', 'rules' => 'trim|required|valid_email|is_unique[' . $this->db->dbprefix . 'users.usr_email]', 'errors' => ['is_unique' => 'User email is already been used']],
                ['field' => 'phone', 'label' => 'User Phone', 'rules' => 'trim|required|numeric|min_length[10]|max_length[10]'],
                ['field' => 'role', 'label' => 'User Role', 'rules' => 'trim|required'],
                ['field' => 'user_ad_name', 'label' => 'User AD Name', 'rules' => 'trim|is_unique[' . $this->db->dbprefix . 'users.usr_ad_name]', 'errors' => ['is_unique' => 'User AD name is already been used']]
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

            $user_data = [
                'usr_fullname' => $this->input->post('full_name'),
                'usr_email' => $this->input->post('email'),
                'usr_role' => $this->input->post('role'),
                'usr_phone' => cus_phone_with_255($this->input->post('phone')),
                'usr_ad_name' => $this->input->post('user_ad_name'),
                'usr_status' => 'ACTIVE',
                'usr_timestamp' => date('Y-m-d H:i:s')
            ];

            $res = $this->usr->saveUserDetails($user_data);

            if ($res) {

                log_message(SYSTEM_LOG, 'usert/submitUser - ' . $this->usr->user_ad_name . ' -> ' . $this->input->ip_address() . 'created a user successfully user: ' . $this->input->post('email'));

                $this->session->set_flashdata('success', 'User data saved successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => TRUE,
                        'redirect_url' => site_url('user/userlist')
                    ]
                ]);
                die();
            } else {
                cus_json_error('Something went wrong. User details not saved.');
            }
        }
    }

    public function submitEditUser() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');



        if (!$this->usr->isLogedin()) {
            cus_json_error('Your session has expired, Please login again');
        }

        $user_id = $this->uri->segment(3);
        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            cus_json_error('User was not found or may have been removed from the system');
        }

        if ($this->usr->user_role != 'ADMIN') {
            cus_json_error('Access denied');
        }



        $user_role = $this->session->userdata['logged_in']['user_role'];

        $validations = [
                ['field' => 'edit_full_name', 'label' => 'User Fullname', 'rules' => 'trim|required'],
                ['field' => 'edit_email', 'label' => 'User Email', 'rules' => 'trim|required|valid_email'],
                ['field' => 'edit_phone', 'label' => 'User Phone', 'rules' => 'trim|required|numeric|min_length[10]|max_length[12]'],
                ['field' => 'edit_role', 'label' => 'User Role', 'rules' => 'trim|required|callback_validateUserRole'],
                ['field' => 'edit_user_ad_name', 'label' => 'User AD Username', 'rules' => 'trim|required'],
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
        } else {

            $user_role = $this->input->post('edit_role');
            $user_email = $this->input->post('edit_email');
            $user_phone = $this->input->post('edit_phone');
            $user_fullname = $this->input->post('edit_full_name');
            $user_ad_name = $this->input->post('edit_user_ad_name');



            $user_data = [
                'usr_role' => $user_role,
                'usr_email' => $user_email,
                'usr_phone' => $user_phone,
                'usr_ad_name' => $user_ad_name,
                'usr_fullname' => $user_fullname
            ];



            $res = $this->usr->saveEditUser($user_data, $user_id);


            if ($res) {
                log_message(SYSTEM_LOG, 'user/submitEditUser -  ' . $this->usr->user_ad_name . ' -> ' . $this->input->ip_address() . 'edited  user details successfully user: ' . $user['usr_email']);
                $this->session->set_flashdata('success', 'User updated successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => TRUE,
                        'redirect_url' => site_url('user/userlist')
                    ],
                    'url' => site_url('usert/userlist')
                ]);
            } else {
                log_message(SYSTEM_LOG, 'usert/submitEditUser - ' . $this->usr->user_ad_name . ' ' . $this->input->ip_address() . 'Nothing was updated to user details');
                cus_json_error('Nothing was updated');
            }
        }
    }

    public function submitDelUser() {

        if (!$this->usr->isLogedin()) {
            $this->usr->setSessMsg('Your session may have been expired. Login is required.', 'error', 'user');
        }

        $user_id = $this->uri->segment(3);

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            $this->usr->setSessMsg('User was not found or may have been removed', 'error', 'user/userlist');
        }

        if (!$this->usr->is_admin) {
            $this->usr->setSessMsg('Access denied!', 'error', 'user/userlist');
        }

        if (strtolower($this->usr->user_email) == strtolower($user['usr_email'])) {
            $this->usr->setSessMsg('You cannot delete yourself!', 'error', 'user/userlist');
        }

        $user_data = [
            'usr_status' => 'DELETED'
        ];

        $res = $this->usr->confirmDeleteUser($user_data, $user_id);

        log_message(SYSTEM_LOG, 'user/submitDelUser - ' . $this->usr->user_ad_name . ' -> ' . $this->input->ip_address() . 'Attempting to delete user: ' . $user['usr_email']);
        if ($res) {

            log_message(SYSTEM_LOG, 'user/submitDelUser - ' . $this->usr->user_ad_name . ' -> ' . $this->input->ip_address() . 'deleted a user successfully user: ' . $user['usr_email']);
            $this->usr->setSessMsg('User deleted successfully', 'success', 'user/userlist');
        } else {
            log_message(SYSTEM_LOG, 'user/submitDelUser - ' . $this->usr->user_ad_name . ' -> ' . $this->input->ip_address() . 'failed to delete user: ' . $user['usr_email']);
            $this->usr->setSessMsg('Failed to delete user', 'warning', 'user/userlist');
        }
    }

    public function disableUser() {

        if (!$this->usr->isLogedin()) {
            $this->usr->setSessMsg('Your session may have been expired. Login is required.', 'error', 'user');
        }

        $user_id = $this->uri->segment(3);

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            $this->usr->setSessMsg('User was not found or may have been removed', 'error', 'user/userlist');
        }

        if (!$this->usr->is_admin) {
            $this->usr->setSessMsg('Access denied!', 'error', 'user/userlist');
        }

        if (strtolower($this->usr->user_email) == strtolower($user['usr_email'])) {
            $this->usr->setSessMsg('You cannot disable yourself!', 'error', 'user/userlist');
        }

        $user_data = [
            'usr_status' => 'INACTIVE'
        ];

        $res = $this->usr->confirmDeleteUser($user_data, $user_id);

        log_message(SYSTEM_LOG, 'user/disableUser - ' . $this->usr->user_ad_name . ' -> ' . $this->input->ip_address() . 'Attempting to disable user: ' . $user['usr_email']);
        if ($res) {

            log_message(SYSTEM_LOG, 'user/disableUser - ' . $this->usr->user_ad_name . ' -> ' . $this->input->ip_address() . 'disabled a user successfully user: ' . $user['usr_email']);
            $this->usr->setSessMsg('User disabled successfully', 'success', 'user/userlist');
        } else {
            log_message(SYSTEM_LOG, 'user/disableUser - ' . $this->usr->user_ad_name . ' -> ' . $this->input->ip_address() . 'failed to disable user: ' . $user['usr_email']);
            $this->usr->setSessMsg('Failed to disable user', 'warning', 'user/userlist');
        }
    }

    public function submitEnableUser() {

        if (!$this->usr->isLogedin()) {
            $this->usr->setSessMsg('Your session may have been expired. Login is required.', 'error', 'user');
        }

        $user_id = $this->uri->segment(3);

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            $this->usr->setSessMsg('User was not found or may have been removed', 'error', 'user/userlist');
        }

        if (!$this->usr->is_admin) {
            $this->usr->setSessMsg('Access denied!', 'error', 'user/userlist');
        }

        if (strtolower($this->usr->user_email) == strtolower($user['usr_email'])) {
            $this->usr->setSessMsg('You cannot enable yourself!', 'error', 'user/userlist');
        }

        $user_data = [
            'usr_status' => 'ACTIVE'
        ];

        $res = $this->usr->confirmDeleteUser($user_data, $user_id);

        log_message(SYSTEM_LOG, 'user/submitEnableUser - ' . $this->usr->user_ad_name . ' -> ' . $this->input->ip_address() . 'Attempting to enable user: ' . $user['usr_email']);
        if ($res) {
            log_message(SYSTEM_LOG, 'user/submitEnableUser - ' . $this->usr->user_ad_name . ' -> ' . $this->input->ip_address() . 'enabled a user successfully user: ' . $user['usr_email']);
            $this->usr->setSessMsg('User enabled successfully', 'success', 'user/userlist');
        } else {
            log_message(SYSTEM_LOG, 'user/submitEnableUser - ' . $this->usr->user_ad_name . ' -> ' . $this->input->ip_address() . 'failed to enable user: ' . $user['usr_email']);
            $this->usr->setSessMsg('Failed to enable user', 'warning', 'user/userlist');
        }
    }

    public function validateUserRole($user_role) {

        $user_roles = $this->utl->getOptions('USER_ROLE');
        $user_roles = array_column($user_roles, 'option_name');

        if (!in_array($user_role, $user_roles) AND ! empty($user_role)) {
            $this->form_validation->set_message('validateUserRole', 'Select a valid user role');
            return FALSE;
        }
        return TRUE;
    }

    public function disable2fa() {

        if (!$this->usr->is_admin) {
            $this->usr->setSessMsg('Access denied!', 'error', 'user/userlist');
        }

        $user_id = $this->uri->segment(3);

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            $this->usr->setSessMsg("User was not found or may have been removed from the system.", 'error', 'user/userlist');
        }

        if ($this->usr->saveEditUser(['usr_2fa_enabled' => '0'], $user_id)) {
            $this->usr->setSessMsg("2FA is disabled for " . $user['usr_fullname'] . " successfully", 'success', 'user/userlist');
        } else {
            $this->usr->setSessMsg("Nothing was updated", 'warning', 'user/userlist');
        }
    }

    public function enable2fa() {

        if (!$this->usr->is_admin) {
            $this->usr->setSessMsg('Access denied!', 'error', 'user/userlist');
        }

        $user_id = $this->uri->segment(3);

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            $this->usr->setSessMsg("User was not found or may have been removed from the system.", 'error', 'user/userlist');
        }

        if ($this->usr->saveEditUser(['usr_2fa_enabled' => '1'], $user_id)) {
            $this->usr->setSessMsg("2FA is enabled for " . $user['usr_fullname'] . " successfully", 'success', 'user/userlist');
        } else {
            $this->usr->setSessMsg("Nothing was updated", 'warning', 'user/userlist');
        }
    }

}
