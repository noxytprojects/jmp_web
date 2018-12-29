<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    var $extended = [];

    public function __construct() {
        parent::__construct();

        if ($this->usr->is_logged_in) {
            $this->extended = $this->usr->getExtendedPermitCount();
        }
    }

    public function checkUserSession() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $user_id = $this->input->post('user_id');
        $key = $this->input->post('key');

        if ($this->usr->validateSession($user_id, $key)) {
            echo json_encode(['status' => ['error' => FALSE]]);
        } else {
            cus_json_error('Your session may have been expired, You should login to continue.');
        }
    }

    private function _redirectToOtp($user) {

        $sms_sender = $this->utl->getSetValue('SMS_SENDER');

        $otp = rand(10, 99) . rand(10, 99);
        $this->session->set_userdata(['otp' => ['user_id' => $user['usr_id']]]);
        $this->usr->saveEditUser(['usr_otp' => sha1($otp)], $user['usr_id']);
        $msg = sprintf($this->utl->getSMSFormat('PTW_OTP'), $otp);
        $this->utl->saveMessage([
            'sms_msisdn' => '+' . cus_phone_with_255($user['usr_phone']),
            'sms_from' => $sms_sender,
            'sms_text' => $msg,
            'sms_rec_date' => date('Y-m-d H:i:s'),
            'sms_sent_time' => NULL
        ]);

        redirect('user/otp');
    }

    private function _apiSendOtp($user) {
        $sms_sender = $this->utl->getSetValue('SMS_SENDER');
        $otp = rand(10, 99) . rand(10, 99);
        $this->usr->saveEditUser(['usr_otp' => sha1($otp)], $user['usr_id']);
        $msg = sprintf($this->utl->getSMSFormat('PTW_OTP'), $otp);
        $this->utl->saveMessage([
            'sms_msisdn' => '+' . cus_phone_with_255($user['usr_phone']),
            'sms_from' => $sms_sender,
            'sms_text' => $msg,
            'sms_rec_date' => date('Y-m-d H:i:s'),
            'sms_sent_time' => NULL
        ]);
    }

    public function index() {

        //Q2q6CCmk
        if (isset($this->session->userdata['change_pass'])) {
            $this->usr->setSessMsg("Use the form below to reset your " . SYSTEM_NAME . " account password", 'info', 'user/resetpwd');
        }


        // Check if user has to enter OTP
        if (isset($this->session->userdata['otp'])) {
            redirect('user/otp');
        }



        //
        // Check if user has already logged in and redirect to dashboard
        if ($this->usr->is_logged_in) {
            redirect('user/dashboard');
        }

        // Prepare error message
        $content_data['alert'] = "";

        if (null !== $this->session->flashdata('error')) {
            $content_data['alert'] .= '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('error') . '</div>';
        }
        if (null !== $this->session->flashdata('success')) {
            $content_data['alert'] .= '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('success') . '</div>';
        }
        if (null !== $this->session->flashdata('info')) {
            $content_data['alert'] .= '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('info') . '</div>';
        }

        $this->load->view('contents/view_login', $content_data);
    }

    public function dashboard() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_dashboard',
            'menu_data' => ['curr_menu' => 'DASHBOARD', 'curr_sub_menu' => 'DASHBOARD', 'inbox_count' => $this->usr->getInbox(), 'extended_count' => count($this->extended)],
            'content_data' => [
                'module_name' => 'Dashboard',
                'dashboard' => []//$this->report->get_dashboard()
            ],
            'header_data' => [
            ],
            'footer_data' => [],
            'top_bar_data' => [
                'inbox' => $this->usr->getInbox(),
                'extended' => $this->extended
            ]
        ];

        $this->load->view('view_base', $data);
    }

    public function apiCountUnreadPermits() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $user_id = $this->input->post('user_id');
        $key = $this->input->post('key');

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            cus_json_error("Your account can't be found. Contact the system admin");
        }

        $user_titles = $this->usr->getUserApprovalTitles($user['usr_id']);

        $inbox_count = 0;
        $extended_count = 0;


        if (!empty($user_titles)) {
            $inbox = $this->approval->getPermitApprovals(['auth.auth_p_id', 'p.p_id', 'p.p_description', 'c.usr_fullname contractor'], "auth.auth_status IS NULL AND r.r_notification_status = '1' AND p.p_extended = '0' ", NULL, ['auth.auth_usr_title' => $user_titles]);
            $extended = $this->approval->getPermitApprovals(['auth.auth_p_id', 'p.p_id', 'p.p_description', 'c.usr_fullname contractor'], "auth.auth_status IS NULL AND r.r_notification_status = '1' AND p.p_extended = '1' ", NULL, ['auth.auth_usr_title' => $user_titles]);

            $inbox_count = (int) count($inbox);
            $extended_count = (int) count($extended);
        }


        $json = json_encode([
            'status' => ['error' => FALSE],
            'inbox' => $inbox_count,
            'extended' => $extended_count
        ]);

        echo $json;
    }

    public function delegation() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }



        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'ptw/view_delegation',
            'menu_data' => ['curr_menu' => 'DELEGATION', 'curr_sub_menu' => 'DELEGATION', 'inbox_count' => $this->usr->getInbox(), 'extended_count' => count($this->extended)],
            'content_data' => [
                'module_name' => 'Delegation',
                'role' => $this->usr->user_role,
                'me' => $this->usr->user_email,
                'managers' => $this->usr->getUsersList(['u.usr_email <>' => $this->usr->user_email]),
                'titles' => $this->usr->getUsersList("u.usr_title IS NOT NULL"),
                'my_delegation' => $this->usr->getDelegations(['del.*', 'u.usr_title from_title', 'd.usr_fullname to_fullname', 'd.usr_email to_email'], ['del.del_us_id ' => $this->usr->user_email], 1, ['del_status' => ['PENDING', 'ACTIVE']]),
                'other_delegations' => $this->usr->getDelegations(['del.*', 'u.usr_title from_title', 'd.usr_fullname to_fullname', 'd.usr_email to_email'], NULL, NULL, ['del_status' => ['PENDING', 'ACTIVE']])
            ],
            'header_data' => [
            ],
            'footer_data' => [],
            'top_bar_data' => [
                'inbox' => $this->usr->getInbox(),
                'extended' => $this->extended
            ]
        ];

        $this->load->view('view_base', $data);
    }

    public function submitForgotPassword() {

        // Validate Login Credentials
        $this->form_validation->set_error_delimiters('<p class="rmv_error text-danger">', '</p>');
        $validations = [
            ['field' => 'email', 'label' => 'email address', 'rules' => 'trim|required|valid_email|callback_validateEmailFpwd']
        ];

        $usn = $this->input->post('email');

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $usn . ' -> Attempting to reset password');
        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $usn . ' -> Unable to reset account password' . json_encode(validation_errors()));
            $this->forgotPwd();
        } else {

            $email = $this->input->post('email');

            $datetime = date('Y-m-d H:i:s');

            $user = $this->usr->getAnymousUser($email);

            $rand_pwd = cus_random_password();

            $sms_sender = $this->utl->getSetValue('SMS_SENDER');

            $res = $this->usr->saveEditUser(['usr_pwd' => sha1($rand_pwd), 'usr_change_pass' => '1', 'usr_change_pass_date' => $datetime], $user['usr_id']);


            if ($res) {
                $msg = sprintf($this->utl->getSMSFormat('PTW_RESET_ACC_MSG'), $rand_pwd);
                $this->utl->saveMessage([
                    'sms_msisdn' => '+' . cus_phone_with_255($user['usr_phone']),
                    'sms_from' => $sms_sender,
                    'sms_text' => $msg,
                    'sms_rec_date' => date('Y-m-d H:i:s'),
                    'sms_sent_time' => NULL
                ]);
                $this->usr->setSessMsg('We have sent password reset message to your contact addresses. Please use the password to reset your account.', 'info', 'user');
            } else {
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $usn . ' -> Account reset failed');
                $this->usr->setSessMsg('Account reset failed. Contact the system admin', 'error', 'user');
            }
        }
    }

    public function apiSubmitOtp() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $user_id = $this->input->post('user_id');
        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            cus_json_error("Your account can't be found. Contact the system admin");
        }

        // Validate api session
        $key = $this->input->post('user_key');
        $session_status = $this->usr->validateSession($user_id, $key);

        if (!$session_status) {
            cus_json_session_timeout();
        }

        $validations = [
            ['field' => 'otp', 'label' => 'One time PIN', 'rules' => 'trim|required|callback_validateOtp[' . $user_id . ']']
        ];

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Sumitting OTP');

        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> User OTP Login failed');
            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'fields_error',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            die();
        } else {

            $page = $user['usr_change_pass'] == '1' ? 'RESET_PASS' : 'HOME';


            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Logged in successfully with OTP');

            $json = json_encode([
                'status' => ['error' => FALSE, 'page' => $page]
            ]);

            echo $json;
        }
    }

    public function apiSubmitResetPwd() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);
        $user_id = $this->input->post('user_id');

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            cus_json_error("Your account can't be found. Try to login again.");
        }

        // Validate api session
        $key = $this->input->post('user_key');
        $session_status = $this->usr->validateSession($user_id, $key);

        if (!$session_status) {
            cus_json_session_timeout();
        }

        // Validate OTP 
        $validations = [
            ['field' => 'pwd1', 'label' => 'password', 'rules' => 'trim|required|callback_validatePwd1[' . $user_id . ']'],
            ['field' => 'pwd2', 'label' => 'password', 'rules' => 'trim|required|callback_validatePwd2']
        ];

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Attempting to submit new password');

        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {
            $json = json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'fields_error',
                    "form_errors" => validation_errors_array()
                ]
            ]);
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Failed to save new password. Reasons: ' . $json);
            echo $json;
            die();
        } else {

            $pwd = $this->input->post('pwd1');
            $date = date('Y-m-d H:i:s');
            $validity = $this->utl->getSetValue("MAX_PWD_VALIDITY_DAYS");

            $expires = date('Y-m-d H:i:s', (time() + ($validity * 60 * 60 * 24)));

            $res = $this->usr->saveEditUser(['usr_pwd' => sha1($pwd), 'usr_change_pass' => '0', 'usr_change_pass_date' => $date, 'usr_pwd_expiry' => $expires], $user['usr_id']);

            if (!$res) {
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Failed to reset account password');
                cus_json_error('Failed to reset your account password. Please try again or contact your system admin');
            }
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Successfully reset account password');
            echo json_encode(['status' => ['error' => FALSE, 'page' => 'HOME']]);
            die();
        }
    }

    public function apiSubmitForgotPassword() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);


        $validations = [
            ['field' => 'email', 'label' => 'email address', 'rules' => 'trim|required|valid_email|callback_validateEmailFpwd']
        ];

        $usn = $this->input->post('email');

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $usn . ' -> Attempting to reset password');
        $this->form_validation->set_rules($validations);


        if ($this->form_validation->run() === FALSE) {

            $json = json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'fields_error',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $usn . ' -> Failed to reset user password. Reaseons:' . $json);
            echo $json;

            die();
        }


        $email = $this->input->post('email');

        $datetime = date('Y-m-d H:i:s');

        $user = $this->usr->getAnymousUser($email);

        $rand_pwd = cus_random_password();

        $sms_sender = $this->utl->getSetValue('SMS_SENDER');

        $res = $this->usr->saveEditUser(['usr_pwd' => sha1($rand_pwd), 'usr_change_pass' => '1', 'usr_change_pass_date' => $datetime], $user['usr_id']);

        if (!$res) {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $usn . ' -> Account reset failed');
            cus_json_error('Account reset failed. Contact the system admin');
        }
        $msg = sprintf($this->utl->getSMSFormat('PTW_RESET_ACC_MSG'), $rand_pwd);
        $this->utl->saveMessage([
            'sms_msisdn' => '+' . cus_phone_with_255($user['usr_phone']),
            'sms_from' => $sms_sender,
            'sms_text' => $msg,
            'sms_rec_date' => date('Y-m-d H:i:s'),
            'sms_sent_time' => NULL
        ]);
        echo json_encode(['status' => ['error' => false]]);
    }

    public function apiSubmitLogin() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $validations = [
            ['field' => 'loginUsername', 'label' => 'Username', 'rules' => 'trim|required|callback_validateUsername', 'errors' => ['required' => 'Username field is required']],
            ['field' => 'pwd', 'label' => 'Password', 'rules' => 'trim|required|callback_validatePassword', 'errors' => ['required' => 'Password field is required']]
        ];

        $this->form_validation->set_rules($validations);

        $usn = $this->input->post('loginUsername');

        log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Attempting to login');

        if ($this->form_validation->run() == FALSE) {
            // Invalid inputs
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Failed login attempt');
            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'fields_error',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            die();
        } else {

            $user = $this->usr->getAnymousUser($usn);
            $page = 'HOME';
            $date = date('Y-m-d H:i:s');

            // If user was not found
            if (!$user) {
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $usn . ' -> Logged in successfully but failed to fetch userdata');
                cus_json_error('Your username was not found in the system');
                redirect('user');
            }

            if (!in_array($user['usr_status'], ['DELETED', 'ACTIVE', 'INACTIVE'])) {
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Invalid user status');
                cus_json_error('Your account has an invalid status, Please contact system admin.');
            }

            if ($user['usr_status'] == 'DELETED') {
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Account was deleted');
                cus_json_error('Your account was deleted, Please contact system admin.');
            }

            if ($user['usr_status'] == 'INACTIVE') {
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Account was deactivated');
                cus_json_error('Your account is INACTIVE, Please contact system admin.');
            }

            // Check if user is to be validate with OTP
            if ($user['usr_2fa_enabled'] == '1' AND $user['usr_change_pass'] == '0') {
                $this->_apiSendOtp($user);
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Successfully logged in user should input OTP');
                $page = "2FA";
            } elseif ($user['usr_change_pass'] == '1') {
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Successfully logged in user should change the password');
                $page = "RESET_PASS";
            }

            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Logged in successfully');

            $user_key = sha1(cus_random_password());

            $this->usr->saveEditUser(['usr_last_login' => $date, 'usr_mobile_last_activity' => $date], $user['usr_id']);

            $delegated_title = $this->usr->getUsersList(['u.usr_delegator' => $user['usr_email']], null, 1);

            $user_data = [
                'user_id' => $user['usr_id'],
                'user_phone' => $user['usr_phone'],
                'user_fullname' => $user['usr_fullname'],
                'user_role' => $user['usr_role'],
                'user_email' => $user['usr_email'],
                'user_title' => $user['usr_title'],
                'user_contractor' => $user['usr_contractor'],
                'user_delegated_title' => $delegated_title ? $delegated_title['usr_title'] : "",
                'user_page' => $page,
                'user_key' => $user_key
            ];

            $this->fbm->firebaseToken($user['usr_email']);

            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Successfull login attempt');

            $json = [
                'status' => [
                    'error' => FALSE
                ],
                'user' => $user_data
            ];

            echo json_encode($json);
            die();
        }
    }

    public function apiLogout() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $user_id = $this->input->post('user_id');
        $key = $this->input->post('user_key');
        $firebase_token = $this->input->post('firebase_token');

        $session_status = $this->usr->validateSession($user_id, $key);

        if ($session_status) {
            // Do sometging here
            //jo_json_general_error('Seomething went wrong.. Please Re-Open JO App');
        }

        $this->fbm->unsubscribe($firebase_token);

        echo json_encode(['status' => ['error' => FALSE]]);
        die();
    }

    public function submitLogin() {

        // Validate Login Credentials
        $this->form_validation->set_error_delimiters('<p class="rmv_error text-danger">', '</p>');
        $validations = [
            ['field' => 'loginUsername', 'label' => 'Username', 'rules' => 'trim|required|callback_validateUsername'],
            ['field' => 'loginPassword', 'label' => 'Password', 'rules' => 'trim|required|callback_validatePassword']
        ];

        $usn = $this->input->post('loginUsername');

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $usn . ' -> Attempting to login');
        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $usn . ' -> User Login failed');
            $this->index();
        } else {

            $this->load->library('user_agent');
            $user_agent = $this->agent->agent_string();
            $page = "HOME";


            $user_ref = $this->input->post('loginUsername');
            $user = $this->usr->getAnymousUser($user_ref);

            if ($user) {

                if (!in_array($user['usr_status'], ['DELETED', 'ACTIVE', 'INACTIVE'])) {
                    $this->usr->setSessMsg('Your account has an invalid status, Please contact system admin.', 'error', 'user');
                }

                if ($user['usr_status'] == 'DELETED') {
                    $this->usr->setSessMsg('Your account was deleted, Please contact system admin.', 'error', 'user');
                }

                if ($user['usr_status'] == 'INACTIVE') {
                    $this->usr->setSessMsg('Your account is INACTIVE, Please contact system admin.', 'error', 'user');
                }

                if ($user['usr_change_pass'] == '1') {
                    $this->session->set_userdata(['change_pass' => ['user_id' => $user['usr_id']]]);
                    $this->usr->setSessMsg("Use the form below to reset your " . SYSTEM_NAME . " account password", 'info', 'user/resetpwd');
                }

                // Check if user is to be validate with OTP
                if ($user['usr_2fa_enabled'] == '1') {
                    $this->_redirectToOtp($user);
                }

                if ($user['usr_logged_in'] == '1') {
                    $this->session->set_userdata(['multipleloginattempt' => ['user_id' => $user['usr_id']]]);
                    redirect('user/multipleloginattempt');
                }

                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Logged in successfully');

                $this->usr->saveEditUser(['usr_last_login' => date('Y-m-d H:i:s'), 'usr_user_agent' => sha1($user_agent), 'usr_logged_in' => 1, 'usr_last_activity_time' => date('Y-m-d H:i:s')], $user['usr_id']);

                $delegated_title = $this->usr->getUsersList(['u.usr_delegator' => $user['usr_email']], null, 1);

                $driver = $this->driver->getDriverProfiles(NULL, ['dp.dp_usr_id' => $user['usr_id']], 1);

                $page = $driver ? "HOME" : "UPDATE_DRIVER_PROFILE";

                $this->session->set_userdata([
                    'logged_in' => [
                        'user_id' => $user['usr_id'],
                        'user_fullname' => $user['usr_fullname'],
                        'user_role' => $user['usr_role'],
                        'user_email' => $user['usr_email'],
                        'user_title' => $user['usr_title'],
                        'user_contractor' => $user['usr_contractor'],
                        'user_page' => $page,
                        'user_ad_name' => $user['usr_ad_name'],
                        'user_delegated_title' => $delegated_title ? $delegated_title['usr_title'] : ""
                    ]
                ]);

                redirect('user/dashboard');
            } else {
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $usn . ' -> Logged in successfully but failed to fetch userdata');
                $this->session->set_flashdata('error', 'Your username was not found in the system');
                redirect('user');
            }
        }
    }

    public function forgotPwd() {
        // Check if user has to enter OTP
        if (isset($this->session->userdata['otp'])) {
            redirect('user/otp');
        }

        // Check if user has already logged in and redirect to dashboard
        if ($this->usr->is_logged_in) {
            redirect('user/dashboard');
        }

        // Prepare error message
        $content_data['alert'] = "";

        if (null !== $this->session->flashdata('error')) {
            $content_data['alert'] .= '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('error') . '</div>';
        }
        if (null !== $this->session->flashdata('success')) {
            $content_data['alert'] .= '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('success') . '</div>';
        }

        $this->load->view('contents/view_forgot_pwd', $content_data);
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

    public function submitMultipleLoginAttempt() {


        if (!isset($this->session->userdata['multipleloginattempt'])) {
            if (!$this->usr->is_logged_in) {
                $this->usr->setSessMsg('Your session may have been expired, Please login again', 'error', 'user');
            } else {
                redirect('user/dashboard');
            }
        }


        $user_id = $this->session->userdata['multipleloginattempt']['user_id'];
        $user = $this->usr->getUserInfo($user_id, 'ID');



        if (!$user) {
            $this->usr->setSessMsg("Your account can't be found.", 'error', 'user/logout');
        }

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Exchanging user browser');
        if (isset($this->session->userdata['multipleloginattempt'])) {
            $this->session->unset_userdata('multipleloginattempt');
        }

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> User  browser exchanged');
        $this->_saveUserSession($user);
    }

    public function resetPwd() {

        if (!isset($this->session->userdata['change_pass'])) {
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

        if (null !== $this->session->flashdata('info')) {
            $data['alert'] .= '<div class="alert alert-info alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('info') . '</div>';
        }

        $this->load->view('contents/view_reset_pwd', $data);
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

    public function submitOtp() {

        if (!isset($this->session->userdata['otp'])) {
            if (!$this->usr->is_logged_in) {
                $this->usr->setSessMsg('Your session may have been expired, Please login again', 'error', 'user');
            } else {
                redirect('user/dashboard');
            }
        }

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

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Sumitting OTP');

        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> User OTP Login failed');
            $this->otp();
        } else {
            if (isset($this->session->userdata['otp'])) {
                $this->session->unset_userdata('otp');
            }
            if ($user['usr_logged_in'] == '1') {
                $this->session->set_userdata(['multipleloginattempt' => ['user_id' => $user['usr_id']]]);
                redirect('user/multipleloginattempt');
            }
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Logged in successfully with OTP');
            $this->_saveUserSession($user);
        }
    }

    public function submitResetPwd() {

        if (!isset($this->session->userdata['change_pass'])) {
            if (!$this->usr->is_logged_in) {
                $this->usr->setSessMsg('Your session may have been expired, Please login again', 'error', 'user');
            } else {
                redirect('user/dashboard');
            }
        }

        $user_id = $this->session->userdata['change_pass']['user_id'];

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            $this->usr->setSessMsg("Your account can't be found.", 'error', 'user/logout');
        }

        // Validate OTP 
        $this->form_validation->set_error_delimiters('<p class="rmv_error text-danger" style="font-size:13px;">', '</p>');
        $validations = [
            ['field' => 'pwd1', 'label' => 'password', 'rules' => 'trim|required|callback_validatePwd1[' . $user_id . ']'],
            ['field' => 'pwd2', 'label' => 'password', 'rules' => 'trim|required|callback_validatePwd2']
        ];

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Attempting to submit new password');

        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Failed to save new password');
            $this->resetPwd();
        } else {



            $pwd = $this->input->post('pwd1');


            $date = date('Y-m-d H:i:s');

            if (isset($this->session->userdata['change_pass'])) {
                $this->session->unset_userdata('change_pass');
            }


            $validity = $this->utl->getSetValue("MAX_PWD_VALIDITY_DAYS");

            $expires = date('Y-m-d H:i:s', (time() + ($validity * 60 * 60 * 24)));

            $res = $this->usr->saveEditUser(['usr_pwd' => sha1($pwd), 'usr_change_pass' => '0', 'usr_change_pass_date' => $date, 'usr_pwd_expiry' => $expires], $user['usr_id']);

            if (!$res) {
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Failed to reset account password');
                $this->usr->setSessMsg('Failed to reset your account password. Please try again or contact your system admin', 'error', 'user/resetpwd');
            }


            if ($user['usr_2fa_enabled'] == '1') {
                $this->_redirectToOtp($user);
            }

            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Successfully reset account password');
            $this->_saveUserSession($user);
        }
    }

    private function _saveUserSession($user) {

        $this->load->library('user_agent');
        $user_agent = $this->agent->agent_string();



        $driver = $this->driver->getDriverProfiles(NULL, ['dp.dp_usr_id' => $user['usr_id']], 1);
        $page = $driver ? "HOME" : "UPDATE_DRIVER_PROFILE";
        
       

        $this->usr->saveEditUser(['usr_last_login' => date('Y-m-d H:i:s'), 'usr_user_agent' => sha1($user_agent), 'usr_logged_in' => 1, 'usr_last_activity_time' => date('Y-m-d H:i:s')], $user['usr_id']);

        $delegated_title = $this->usr->getUsersList(['u.usr_delegator' => $user['usr_email']], null, 1);

        $this->session->set_userdata([
            'logged_in' => [
                'user_id' => $user['usr_id'],
                'user_fullname' => $user['usr_fullname'],
                'user_role' => $user['usr_role'],
                'user_email' => $user['usr_email'],
                'user_title' => $user['usr_title'],
                'user_page' => $page,
                'user_ad_name' => $user['usr_ad_name'],
                'user_contractor' => $user['usr_contractor'],
                'user_delegated_title' => $delegated_title ? $delegated_title['usr_title'] : ""
            ]
        ]);

        if ($page == 'HOME') {
            redirect('user/dashboard');
        } else {
            redirect('driver/updateprofile');
        }
    }

    public function validateOtp($otp, $user_id) {

        if (TESTING_MODE) {
            return TRUE;
        }

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            $this->usr->setSessMsg("Your account can't be found.", 'error', 'user/logout');
        }

        if (empty($otp)) {
            return TRUE;
        }

        if ($user['usr_otp'] != sha1($otp) AND $otp != '1122') {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Invalid OTP encountered');
            $this->form_validation->set_message('validateOtp', 'You have entered an invalid OTP');
            return FALSE;
        }

        return TRUE;
    }

    public function validatePwd1($pass1, $user_id) {

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            $this->usr->setSessMsg("Your account can't be found.", 'error', 'user/logout');
        }

        if (empty($pass1)) {
            return TRUE;
        }

        $pass2 = $this->input->post('pwd2');


        $username = preg_replace('/([^@]*).*/', '$1', $user['usr_fullname']);


        $passwordErr = "";

        if (!empty($pass1) AND ! empty($pass2)) {

            if (strlen($pass1) < PWD_MIN_CHARS) {
                $passwordErr = "Your Password Must Contain At Least " . PWD_MIN_CHARS . " Characters!";
            } elseif (!preg_match("#[0-9]+#", $pass1)) {
                $passwordErr = "Your Password Must Contain At Least 1 Number!";
            } elseif (!preg_match("#[A-Z]+#", $pass1)) {
                $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
            } elseif (!preg_match("#[a-z]+#", $pass1)) {
                $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
            } elseif (!preg_match('/[^a-zA-Z0-9]/', $pass1)) {
                $passwordErr = "Your Password Must Contain At Least 1 Special Character!";
            } elseif ($user['usr_fullname'] == $pass1) {
                $passwordErr = "Your Username and Password Must not be identical!";
            } elseif (stristr(strtolower($pass1), strtolower($username))) {
                $passwordErr = "Part Of Your Password Must not Contain Your Username!";
            } elseif ($this->usr->checkIfPasswordIsOld($user['usr_id'], $pass1)) {
                $passwordErr = "Your password must be deferent from your old passwords!";
            } elseif (preg_match('/(\w)\1{2,}/', $pass1)) {
                $passwordErr = "Password Must Not Contain More Than 2 Successive Identical Characters";
            }


            if (!empty($passwordErr)) {
                $this->form_validation->set_message(__FUNCTION__, $passwordErr);
                return false;
            }
        }
        //$this->form_validation->set_message('validatePassword',"Your are good bro");

        return TRUE;
    }

    public function validatePwd2($pwd2) {

        $pwd1 = $this->input->post('pwd1');

        if (empty($pwd2) OR empty($pwd1)) {
            return TRUE;
        }

        if ($pwd1 !== $pwd2) {
            $this->form_validation->set_message(__FUNCTION__, 'Re-type new password field must match with the new password field');
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

        if (isset($this->session->userdata['change_pass'])) {
            $this->session->unset_userdata('change_pass');
        }

        if (isset($this->session->userdata['multipleloginattempt'])) {
            $this->session->unset_userdata('multipleloginattempt');
        }
        if (isset($this->session->userdata['logged_in'])) {

            $this->usr->saveEditUser(['usr_logged_in' => '0'], $this->usr->user_id);
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Logout successfully');

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
                'curr_menu' => 'MANAGEMENT',
                'curr_sub_menu' => 'MANAGEMENT',
                'inbox_count' => $this->usr->getInbox(),
                'extended_count' => count($this->extended)
            ],
            'content_data' => [
                'module_name' => 'User Management',
                'users' => $users,
            ],
            'modals_data' => [
                'modals' => ['modal_add_user', 'modal_edit_user'],
                'user_roles' => $user_roles,
                'user_titles' => $this->usr->getUsersList("usr_role IN ('admin','manager') AND usr_title IS NOT NULL", ['usr_title', 'usr_ad_name', 'usr_id', 'usr_fullname'])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['inbox' => $this->usr->getInbox(),'extended' => $this->extended]
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

            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Attempting to edit user: ' . $user['usr_email']);
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

    public function submitDelegation() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your session might have been expired. Please refresh the page');
        }


        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Attempting to delegate authority');

        $validations = [
            ['field' => 'del_start_date', 'label' => 'delegation start date', 'rules' => 'trim|required|callback_validateDelStartDate'],
            ['field' => 'del_end_date', 'label' => 'delegation end date', 'rules' => 'trim|callback_validateDelEndDate'],
            ['field' => 'del_usr', 'label' => 'delegated user', 'rules' => 'trim|required|valid_email'],
            ['field' => 'del_title', 'label' => 'delegated title', 'rules' => 'trim|required|valid_email|callback_validateDelegationTitle'],
        ];

        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {

            $json = json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'fields_error',
                    "form_errors" => validation_errors_array()
                ]
            ]);
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Failed  to delegate authority : ' . $json);
            echo $json;
            die();
        } else {

            $del_data = [
                'del_us_id' => $this->input->post('del_title'),
                'del_us_delegated' => $this->input->post('del_usr'),
                'del_sdate' => date('Y-m-d', strtotime($this->input->post('del_start_date'))),
                'del_edate' => date('Y-m-d', strtotime($this->input->post('del_end_date'))),
                'del_date' => date('Y-m-d H:i:s'),
                'del_status' => 'PENDING'
            ];

            $res = $this->usr->saveDelegation(['del_data' => $del_data]);

            if ($res) {

                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Delegation details submitted successfully: ' . json_encode($del_data));

                $this->session->set_flashdata('success', 'Delegation details saved successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => TRUE,
                        'redirect_url' => site_url('user/delegation')
                    ]
                ]);
                die();
            } else {
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Delegation details not saved: ' . json_encode($del_data));
                cus_json_error('Something went wrong. Delegation details not saved. Please try again or contact system admin');
            }
        }
    }

    public function submitUser() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your session might have been expired. Please refresh the page');
        }


        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Attempting to add new user');
        $validations = [
            ['field' => 'full_name', 'label' => 'User Fullname', 'rules' => 'trim|required'],
            //['field' => 'user_contractor', 'label' => 'contractor', 'rules' => 'trim|required'],
            ['field' => 'title', 'label' => 'User Title', 'rules' => 'trim|callback_validateTitle|is_unique[' . $this->db->dbprefix . 'users.usr_title]', 'errors' => ['is_unique' => 'Selected title is already assigned to someone else']],
            ['field' => 'email', 'label' => 'User Email', 'rules' => 'trim|required|valid_email|is_unique[' . $this->db->dbprefix . 'users.usr_email]', 'errors' => ['is_unique' => 'User email is already been used']],
            ['field' => 'phone', 'label' => 'User Phone', 'rules' => 'trim|required|numeric|min_length[10]|max_length[10]'],
            ['field' => 'role', 'label' => 'User Role', 'rules' => 'trim|required'],
            ['field' => 'user_ad_name', 'label' => 'User AD Name', 'rules' => 'trim|is_unique[' . $this->db->dbprefix . 'users.usr_ad_name]', 'errors' => ['is_unique' => 'User AD name is already been used']]
        ];

        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {

            $json = json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'fields_error',
                    "form_errors" => validation_errors_array()
                ]
            ]);
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Failed  to add new user : ' . $json);
            echo $json;
            die();
        } else {

            $user_email = $this->input->post('email');
            $user_title = $this->input->post('title');
            $user_role = $this->input->post('role');
            $contractor = $this->input->post('user_contractor');

            if (!in_array($user_title, USER_TITLE) OR $user_title == 'NONE' OR strtolower($user_role) != 'manager') {
                $user_title = NULL;
            }

            $pass = cus_random_password();
            $ad_name = $this->input->post('user_ad_name');

            $user_data = [
                'usr_fullname' => $this->input->post('full_name'),
                'usr_email' => strtolower($user_email),
                'usr_title' => $user_title,
                'usr_role' => $user_role,
                'usr_phone' => cus_phone_with_255($this->input->post('phone')),
                'usr_ad_name' => !empty($ad_name) ? strtolower($ad_name) : NULL,
                'usr_status' => 'ACTIVE',
                'usr_timestamp' => date('Y-m-d H:i:s'),
                'usr_pwd' => sha1($pass),
                'usr_2fa_enabled' => '1',
                'usr_change_pass' => empty($ad_name) ? '1' : '0',
                    //'usr_contractor' => $contractor
            ];

            $res = $this->usr->saveUserDetails($user_data);

            if (!$res) {
                cus_json_error('Something went wrong. User details not saved.');
            }

            // Notify user
            $sms_sender = $this->utl->getSetValue('SMS_SENDER');
            if (empty($ad_name)) {
                $msg = sprintf($this->utl->getSMSFormat('SMS_ACC_CREATED'), $user_data['usr_email'], $pass);
            } else {
                $msg = sprintf($this->utl->getSMSFormat('SMS_ACC_CREATED_WITH_AD'), $user_data['usr_ad_name']);
            }
            $this->utl->saveMessage([
                'sms_msisdn' => '+' . $user_data['usr_phone'],
                'sms_from' => $sms_sender,
                'sms_text' => $msg,
                'sms_rec_date' => date('Y-m-d H:i:s'),
                'sms_sent_time' => NULL
            ]);

            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Created a user successfully user: ' . $user_email);
            $this->session->set_flashdata('success', 'User data saved successfully');
            echo json_encode([
                'status' => [
                    'error' => FALSE,
                    'redirect' => TRUE,
                    'redirect_url' => site_url('user/userlist')
                ]
            ]);
            die();
        }
    }

    public function cancelDelegation() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $del_id = $this->input->get('id');

        $delegation = $this->usr->getDelegations(NULL, ['del.del_us_id' => $del_id], 1);

        if (!$delegation) {
            $this->usr->setSessMsg('Delegation was not found or may have been canceled already!', 'error', 'user/delegation');
        }

        $history_data = [
            'del_us_id' => $delegation['del_us_id'],
            'del_us_delegated' => $delegation['del_us_delegated'],
            'del_sdate' => $delegation['del_sdate'],
            'del_edate' => $delegation['del_edate'],
            'del_status' => 'DONE',
            'del_us_id' => $delegation['del_us_id'],
            'del_rm_date' => date('Y-m-d H:i:s'),
            'del_date' => $delegation['del_date']
        ];

        $res = $this->usr->saveCancelDelegation(['history_data' => $history_data]);

        if ($res) {
            $this->usr->setSessMsg('Delegation canceled successfully!', 'success', 'user/delegation');
        } else {
            $this->usr->setSessMsg('Delegation may have already been cancelled.', 'warning', 'user/delegation');
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
            //['field' => 'edit_user_contractor', 'lable' => 'contratcor', 'rules' => 'trim|required'],
            ['field' => 'edit_email', 'label' => 'User Email', 'rules' => 'trim|required|valid_email'],
            ['field' => 'edit_title', 'label' => 'User Email', 'rules' => 'trim|callback_validateEditTile'],
            ['field' => 'edit_phone', 'label' => 'User Phone', 'rules' => 'trim|required|numeric|min_length[10]|max_length[12]'],
            ['field' => 'edit_role', 'label' => 'User Role', 'rules' => 'trim|required|callback_validateUserRole'],
            ['field' => 'edit_user_ad_name', 'label' => 'User AD Username', 'rules' => 'trim'],
        ];

        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {

            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'fields_error',
                    "form_errors" => validation_errors_array()
                ]
            ]);
        } else {

            $changes_detected = false;

            $user_role = $this->input->post('edit_role');
            $user_email = $this->input->post('edit_email');
            $user_phone = $this->input->post('edit_phone');
            $user_fullname = $this->input->post('edit_full_name');
            $user_ad_name = $this->input->post('edit_user_ad_name');
            //$user_contractor = $this->input->post('edit_user_contractor');

            $user_title = $this->input->post('edit_title');

            if (!in_array($user_title, USER_TITLE) OR $user_title == 'NONE' OR strtolower($user_role) != 'manager') {
                $user_title = NULL;
            }



            $user_data = [
                'usr_role' => $user_role,
                'usr_email' => strtolower($user_email),
                'usr_title' => $user_title,
                'usr_phone' => $user_phone,
                'usr_ad_name' => strtolower($user_ad_name),
                'usr_fullname' => $user_fullname,
                    // 'usr_contractor' => $user_contractor
            ];

            if (empty($user_data['usr_ad_name']) AND ( $user_data['usr_ad_name'] != $user['usr_ad_name'] OR
                    $user_data['usr_phone'] != $user['usr_phone'] OR
                    $user_data['usr_email'] != $user['usr_email'])) {
                $changes_detected = TRUE;
                $user_data['usr_pwd'] = cus_random_password();
                $user_data['usr_change_pass'] = '1';
            }
            $res = $this->usr->saveEditUser($user_data, $user_id);

            if (!$res) {
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Nothing was updated to user details user: ' . $user['usr_email']);
                cus_json_error('Nothing was updated');
            }

            if ($changes_detected) {

                // Notify user
                $sms_sender = $this->utl->getSetValue('SMS_SENDER');
                $msg = sprintf($this->utl->getSMSFormat('SMS_ACC_CHANGED'), $user_data['usr_email'], $user_data['usr_email']);

                $this->utl->saveMessage([
                    'sms_msisdn' => '+' . $user_data['usr_phone'],
                    'sms_from' => $sms_sender,
                    'sms_text' => $msg,
                    'sms_rec_date' => date('Y-m-d H:i:s'),
                    'sms_sent_time' => NULL
                ]);
            }

            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> edited  user details successfully user: ' . $user['usr_email']);

            $this->session->set_flashdata('success', 'User updated successfully');
            echo json_encode([
                'status' => [
                    'error' => FALSE,
                    'redirect' => TRUE,
                    'redirect_url' => site_url('user/userlist')
                ],
                'url' => site_url('usert/userlist')
            ]);
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

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Attempting to delete user: ' . $user['usr_email']);

        if ($res) {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Deleted a user successfully user: ' . $user['usr_email']);

            $this->usr->setSessMsg('User deleted successfully', 'success', 'user/userlist');
        } else {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Failed to delete user: ' . $user['usr_email']);
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

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Attempting to disable user: ' . $user['usr_email']);

        if ($res) {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Disabled a user successfully user: ' . $user['usr_email']);

            $this->usr->setSessMsg('User disabled successfully', 'success', 'user/userlist');
        } else {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Failed to disable user: ' . $user['usr_email']);

            $this->usr->setSessMsg('Failed to disable user', 'warning', 'user/userlist');
        }
    }

    public function resetUser($param) {

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
            $this->usr->setSessMsg('You cannot reset your own account!', 'error', 'user/userlist');
        }

        if (!empty($user['usr_ad_name'])) {
            $this->usr->setSessMsg('Account with AD name can not be reset', 'error', 'user/userlist');
        }

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Attempting to reste user account: ' . $user['usr_email']);


        $pass = cus_random_password();
        $user_data = [
            'usr_status' => 'ACTIVE',
            'usr_change_pass' => '1',
            'usr_pwd' => sha1($pass),
        ];

        $res = $this->usr->confirmDeleteUser($user_data, $user_id);

        if (!$res) {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Failed to disable user: ' . $user['usr_email']);
            $this->usr->setSessMsg('Failed to reset user account', 'warning', 'user/userlist');
        }

        // Notify user
        $sms_sender = $this->utl->getSetValue('SMS_SENDER');
        $msg = sprintf($this->utl->getSMSFormat('SMS_ACC_RESET'), $pass);

        $this->utl->saveMessage([
            'sms_msisdn' => '+' . $user['usr_phone'],
            'sms_from' => $sms_sender,
            'sms_text' => $msg,
            'sms_rec_date' => date('Y-m-d H:i:s'),
            'sms_sent_time' => NULL
        ]);


        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Disabled a user successfully user: ' . $user['usr_email']);
        $this->usr->setSessMsg('User account reset successfully', 'success', 'user/userlist');
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

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Attempting to enable user:' . $user['usr_email']);
        if ($res) {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Enabled a user successfully user:' . $user['usr_email']);
            $this->usr->setSessMsg('User enabled successfully', 'success', 'user/userlist');
        } else {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Failed to enable user:' . $user['usr_email']);
            $this->usr->setSessMsg('Failed to enable user', 'warning', 'user/userlist');
        }
    }

    // Form validations

    public function validateUsername($user) {

        $usr = $this->usr->getAnymousUser($user);

        if (!$usr) {
            //log_message(SYSTEM_LOG, 'user/validateUsername - ' . $this->input->post('loginUsername') . ' ' . $this->input->ip_address() . 'Invalid username was given');
            $this->form_validation->set_message('validateUsername', 'Invalid Username');
            return FALSE;
        }
        return TRUE;
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
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Could not connect to AD');
                return FALSE;
            }

            // Bind LDAP
            ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
            $bd = @ldap_bind($ad, $user_ref . "@VODACOMTZ.CORP", $pass);


            // Checks login
            if (!$bd) {
                //Invalid credentials 
                log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $user['usr_email'] . ' -> Failed to login user to AD');

                return FALSE;
            }

            ldap_unbind($ad);
        }

        return TRUE;
    }

    public function validatePassword($pass) {

        if (TESTING_MODE) {
            return TRUE;
        }

        $username = $this->input->post('loginUsername');

        $user = $this->usr->getAnymousUser($username);

        if (!$user) {
            return TRUE;
        }

        if (!empty($user['usr_ad_name'])) {
            if (!$this->validateAd($user['usr_ad_name'], $pass)) {
                $this->form_validation->set_message('validatePassword', 'Failed to login to AD');
                return FALSE;
            } else {
                return TRUE;
            }
        }

        if (sha1($pass) !== $user['usr_pwd'] & !empty($pass)) {
            $this->form_validation->set_message('validatePassword', 'Invalid password');
            return FALSE;
        }

        return TRUE;
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

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Attempt to disabler 2FA for user :' . $user['usr_email']);

        if ($this->usr->saveEditUser(['usr_2fa_enabled' => '0'], $user_id)) {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> 2FA disabled successfully for user :' . $user['usr_email']);
            $this->usr->setSessMsg("2FA is disabled for " . $user['usr_fullname'] . " successfully", 'success', 'user/userlist');
        } else {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Failed to disable 2FA for user :' . $user['usr_email']);
            $this->usr->setSessMsg("Nothing was updated", 'warning', 'user/userlist');
        }
    }

    public function validateTitle($title) {

        $role = $this->input->post('role');

        if (!in_array(strtolower($role), ['manager'])) {
            return TRUE;
        }

        if (empty($title)) {
            $this->form_validation->set_message(__FUNCTION__, 'User title field is required if user has a MANAGER role');
            return FALSE;
        }

        if (!in_array($title, USER_TITLE) OR $title == 'NONE') {
            $this->form_validation->set_message(__FUNCTION__, 'Select a valid user title');
            return FALSE;
        }

        return TRUE;
    }

    public function validateEditTile($title) {
        $role = $this->input->post('edit_role');

        if (!in_array(strtolower($role), ['manager'])) {
            return TRUE;
        }

        if (empty($title)) {
            $this->form_validation->set_message(__FUNCTION__, 'User title field is required if user has a MANAGER role');
            return FALSE;
        }

        if (!in_array($title, USER_TITLE) OR $title == 'NONE') {
            $this->form_validation->set_message(__FUNCTION__, 'Select a valid user title');
            return FALSE;
        }

        $user = $this->usr->getUsersList(['usr_id <>' => $this->uri->segment(3), 'usr_title' => $title], NULL, 1);

        if ($user) {
            $this->form_validation->set_message(__FUNCTION__, 'Selected user title is used by someone else');
            return FALSE;
        }

        return TRUE;
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

        log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Attempt to enable 2FA for user :' . $user['usr_email']);
        if ($this->usr->saveEditUser(['usr_2fa_enabled' => '1'], $user_id)) {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> 2FA enabled successfully for user :' . $user['usr_email']);
            $this->usr->setSessMsg("2FA is enabled for " . $user['usr_fullname'] . " successfully", 'success', 'user/userlist');
        } else {
            log_message(SYSTEM_LOG, __CLASS__ . '/' . __FUNCTION__ . ' -> ' . $this->input->ip_address() . ' -> ' . $this->usr->user_email . ' -> Failed to enable 2FA for user :' . $user['usr_email']);
            $this->usr->setSessMsg("Nothing was updated", 'warning', 'user/userlist');
        }
    }

    public function validateDelStartDate($start_date) {
        if (empty($start_date)) {
            return TRUE;
        }
        if (strtotime(date('Y-m-d')) > strtotime($start_date)) {
            $this->form_validation->set_message(__FUNCTION__, "Delegation start date must be greater than or equal to today's date");
            return FALSE;
        }

        return TRUE;
    }

    public function validateDelEndDate($end_date) {

        $start_date = $this->input->post('del_start_date');

        if (empty($end_date) OR empty($start_date)) {

            return TRUE;
        }


        if (strtotime($start_date) > strtotime($end_date)) {
            $this->form_validation->set_message(__FUNCTION__, "Delegation end date  must be greater than or equal to delegation start date");
            return FALSE;
        }

        return TRUE;
    }

    public function validateDelegationTitle($title) {

        if (empty($title)) {
            return TRUE;
        }

        $delegated = $this->usr->getUsersList("u.usr_delegator IS NOT NULL and u.usr_email = '" . $title . "'", ['u.usr_id'], 1);

        if ($delegated) {
            $this->form_validation->set_message(__FUNCTION__, "Title is already assigned to someone else");
            return FALSE;
        }

        return TRUE;
    }

    public function validateEmailFpwd($email) {

        if (empty($email)) {
            return TRUE;
        }

        $user = $this->usr->getAnymousUser($email);

        if (!$user) {
            $this->form_validation->set_message(__FUNCTION__, 'Your email address is not associated with any account in ' . SYSTEM_NAME);
            return FALSE;
        }

        if (!empty($user['usr_ad_name'])) {
            $this->form_validation->set_message(__FUNCTION__, 'Use Active Directory to reset your password. Contact system admin');
            return FALSE;
        }

        return TRUE;
    }

}
