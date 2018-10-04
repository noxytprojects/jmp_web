<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
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

    public function getSections() {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $sections = $this->mnt->getSections(NULL, ['sec_dept_id' => $this->uri->segment(3)]);

        $json = [
            'status' => [
                'error' => FALSE,
            ],
            'sections' => $sections
        ];

        echo json_encode($json);
        die();
    }

    public function submitApproveRequest() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');


        // Check user session status and the platform used
        if (!empty($_POST) && !$this->usr->is_logged_in) {
            $this->usr->setSessMsg(MSG_EXPIRY_SESSION, 'error', 'user');
        } elseif (empty($_POST)) {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $trip_id = $this->input->post('trip_id');
        } else {
            $usn = $this->usr->ad_name;
            $trip_id = $this->uri->segment(3);
        }

        $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $trip_id], 1);

        if (!$trip) {
            // trip request was not found so redirect back
            cus_json_error('Trip request was not found or may have been removed from the system');
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

            $post_comment = $this->input->post('comment');
            $comment = "";
            $comment .= "APPROVED\n";
            $comment .= !empty($post_comment) ? ($post_comment . "\n") : "";

            $comment .= '<b>' . $this->usr->full_name . '</b>' . ' - ' . $this->usr->email . "\n" . date('Y-m-d H:i:s') . "\n";

            if (!empty($trip['ap_comments'])) {
                $comment .= "\n\n\n" . $trip['ap_comments'];
            }

            $approval_data = [
                'ap_approval_time' => date('Y-m-d H:i:s'),
                'ap_comments' => $comment,
                'ap_status' => 'APPROVED'
            ];

            $res = $this->approval->updateApprovalStatus(['approval_data' => $approval_data, 'tr_data' => ['tr_status' => 'APPROVED'], 'tr_id' => $trip['tr_id'], 'ad_name' => $this->usr->ad_name]);

            if ($res) {

                $this->usr->setSessMsg('Trip request approved successfully', 'success');
                $json = json_encode([
                    'status' => ['error' => FALSE, 'redirect' => TRUE, 'redirect_url' => site_url('trip/previewrequest/' . $trip['tr_id'])]
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
            $trip_id = $this->input->post('trip_id');
        } else {
            $usn = $this->usr->ad_name;
            $trip_id = $this->uri->segment(3);
        }

        $trip = $this->trip->getTripRequests(NULL, ['tr.tr_id' => $trip_id], 1);

        if (!$trip) {
            // trip request was not found so redirect back
            cus_json_error('Trip request was not found or may have been removed from the system');
        }

        $validations = [
                ['field' => 'dis_comment', 'label' => 'Disapproval Comment', 'rules' => 'trim|required']
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

            $post_comment = $this->input->post('dis_comment');
            $comment = "";
            $comment .= "DISAPPROVED\n";
            $comment .= !empty($post_comment) ? $post_comment . "\n" : "";

            $comment .= '<b>' . $this->usr->full_name . '</b>' . ' - ' . $this->usr->email . "\n" . date('Y-m-d H:i:s') . "\n";

            if (!empty($trip['ap_comments'])) {
                $comment .= "\n\n\n" . $trip['ap_comments'];
            }

            $approval_data = [
                'ap_approval_time' => date('Y-m-d H:i:s'),
                'ap_comments' => $comment,
                'ap_status' => 'DISAPPROVED'
            ];

            $res = $this->approval->updateApprovalStatus(['approval_data' => $approval_data, 'tr_data' => ['tr_status' => 'DISAPPROVED'], 'tr_id' => $trip['tr_id'], 'ad_name' => $this->usr->ad_name]);

            if ($res) {

                $this->usr->setSessMsg('Trip request disapproved successfully', 'success');
                $json = json_encode([
                    'status' => ['error' => FALSE, 'redirect' => TRUE, 'redirect_url' => site_url('trip/previewrequest/' . $trip['tr_id'])]
                ]);
                echo $json;
            } else {
                cus_json_error('Approval status was not updated');
            }
        }
    }

    public function submitLogin() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $validations = [
                ['field' => 'usn', 'label' => 'Username', 'rules' => 'trim|required|callback_validateUsn', 'errors' => ['required' => 'Username field is required']],
                ['field' => 'pwd', 'label' => 'Password', 'rules' => 'trim|required|callback_validatePwd', 'errors' => ['required' => 'Password field is required']]
        ];

        $this->form_validation->set_rules($validations);

        $usn = $this->input->post('usn');

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

            $user = [
                'ad_name' => $this->input->post('usn'),
                'phone_number' => "",
                'full_name' => "",
                'token' => sha1(rand(1111, 9999)),
                'driver_details' => FALSE,
                'role' => 'NONE'
            ];

            $page = "";

            $driver = $this->driver->getDriverProfiles(NULL, ['dp.dp_ad_name' => $usn], 1);
            $hod = $this->mnt->getDepartments(NULL, ['dept_hod_ad_name' => $usn], 1);
            $lm = $this->mnt->getSections(NULL, ['sec_tl_ad_name' => $usn], 1);


            if ($hod) {

                // if is HOD
                $user['ad_name'] = $hod['dept_hod_ad_name'];
                $user['phone_number'] = $hod['dept_hod_phone'];
                $user['full_name'] = $hod['dept_hod_full_name'];
                $user['role'] = 'HOD';

                $page = "HOME";
                log_message(SYSTEM_LOG, $this->input->ip_address() .' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => '. $usn . ' - Logon user is HOD');
            } elseif ($lm) {

                // If is line manager
                $user['ad_name'] = $lm['sec_tl_ad_name'];
                $user['phone_number'] = $lm['sec_tl_phone_number'];
                $user['full_name'] = $lm['sec_tl_full_name'];
                $user['role'] = 'LINE MANAGER';
                $page = "HOME";

                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Logon user is Line Manager');
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
                $user['role'] = 'DRIVER';

                $page = "HOME";
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Logon user is Driver');
            } else {
                $page = 'UPDATE_DRIVER_PROFILE';
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Logon user is NEW so will have to update his/her driver profile');
            }

            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Successfull login attempt');

            $json = [
                'status' => [
                    'error' => FALSE,
                    'page' => $page,
                ],
                'user' => $user
            ];

            echo json_encode($json);
            die();
        }
    }

    public function getDriverDetails() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        

        $ad_name = $this->input->post('ad_name');

        $driver = $this->driver->getDriverProfiles(NULL, ['dp_ad_name' => $ad_name], 1);

        if (!$driver) {
            cus_json_error('Drivers profile not found.');
        }

        $json = [
            'status' => [
                'error' => FALSE
            ],
            'driver_details' => $driver
        ];
        echo json_encode($json);
        die();
    }

    public function submitDriverDetails() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

       
        $validations = [
                ['field' => 'name', 'label' => 'driver full name', 'rules' => 'trim|required'],
                ['field' => 'phone', 'label' => 'phone number', 'rules' => 'trim|required|numeric|callback_validateDriverPhoneNumber'],
                ['field' => 'email', 'label' => 'email address', 'rules' => 'trim|required|valid_email|callback_validateDriverEmail'],
                ['field' => 'dept', 'label' => 'department', 'rules' => 'trim|required'],
                ['field' => 'section', 'label' => 'section', 'rules' => 'trim|required'],
                ['field' => 'license', 'label' => 'driver licence number', 'rules' => 'trim|required|callback_validateDriverLicence'],
                ['field' => 'license_expiry', 'label' => 'license expiry date', 'rules' => 'trim|required'],
        ];

        $this->form_validation->set_rules($validations);

        $usn = $this->input->post('ad_name');

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
            $license_expiry = $this->input->post('license_expiry');
            $timestamp = date('Y-m-d H:i:d');

            $driver_data = [
                'dp_phone_number' => cus_phone_with_255($phone_number),
                'dp_full_name' => $this->input->post('name'),
                'dp_email' => $this->input->post('email'),
                'dp_dept_id' => $this->input->post('dept'),
                'dp_section_id' => $this->input->post('section'),
                'dp_license_number' => $this->input->post('license'),
                'dp_license_expiry' => $license_expiry,
                'dp_updated_time' => $timestamp,
                'dp_status' => 'PENDING'
            ];

            $data = ['driver_data' => $driver_data, 'ad_name' => $usn, 'timestamp' => $timestamp];

            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Submitted data :: ' . json_encode($data));

            $res = $this->driver->saveDriverDetails($data);

            if (!$res) {
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => '  . $usn . ' - driver profile was not updated');
                cus_json_error('Nothing was updated.');
            }

            //Stuff went well lets get it.

            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - updated the driver profile successfully');


            // Get the driver info
            $driver = $this->driver->getDriverProfiles(NULL, ['dp.dp_ad_name' => $usn], 1);

            if (!$driver) {
                cus_json_error('Something went wrong please try again');
            }

            // Prepare data to continue

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

            $user = [
                'ad_name' => $driver['dp_ad_name'],
                'phone_number' => $driver['dp_phone_number'],
                'full_name' => $driver['dp_full_name'],
                'driver_details' => $driver_details,
                'token' => sha1(rand(1111, 9999)),
                'page' => 'HOME',
                'role' => 'DRIVER'
            ];

            $json = [
                'status' => ['error' => FALSE],
                'user' => $user
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
            $usn = $this->input->post('ad_name');
        } else {
            $usn = $this->usr->ad_name;
        }

        $validations = [
                ['field' => 'journey_purpose', 'label' => 'journey purpose', 'rules' => 'trim|required'],
                ['field' => 'vehicle_reg_number', 'label' => 'vehicle registration number', 'rules' => 'trim|required'],
                ['field' => 'medical_by_osha', 'label' => 'medical done by osha', 'rules' => 'trim|required', 'errors' => ['required' => 'You should select whether driver medical fitness assessment has done by OSHA']],
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

        $this->form_validation->set_rules($validations);



        log_message(SYSTEM_LOG, $this->input->ip_address() .' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Submitting drivers details');

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

            $work_finish_time = $this->input->post('work_finish_time');
            $reason_finish_after_17 = $this->input->post('reason_finish_after_17');

            if (strtolower($work_finish_time) == 'NO') {
                $reason_finish_after_17 = NULL;
            }

            $trip_data = [
                'tr_journey_purpose' => $this->input->post('journey_purpose'),
                'tr_vehicle_reg_no' => $this->input->post('vehicle_reg_number'),
                'tr_medical_by_osha' => $this->input->post('medical_by_osha'),
                'tr_reason_finish_after_17' => $reason_finish_after_17,
                'tr_work_finish_time' => $work_finish_time,
                'tr_vehicle_type' => $this->input->post('vehicle_type'),
                'tr_difense_driver_training' => $this->input->post('difense_driver_training'),
                'tr_for_by_for_training' => $this->input->post('for_by_for_training'),
                'tr_suitable_license' => $this->input->post('suitable_license'),
                'tr_fit_for_use' => $this->input->post('fit_for_use'),
                'tr_dispatch_time' => date('Y-m-d H:i:s', strtotime($this->input->post('dispatch_time'))),
                'tr_arraival_time' => date('Y-m-d H:i:s', strtotime($this->input->post('arraival_time'))),
                'tr_departure_location' => $this->input->post('departure_location'),
                'tr_destination_location' => $this->input->post('destination_location'),
                'tr_stop_locations' => $this->input->post('stop_locations'),
                'tr_distance' => (int) $this->input->post('distance'),
                'tr_timestamp' => date('Y-m-d H:i:s'),
                'tr_status' => 'NEW',
                'tr_ad_name' => $usn
            ];

            $data = ['trip_data' => $trip_data];
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Saving trip data : ' . json_encode($data));

            $res = $this->trip->saveTrip($data);

            if (!$res) {
                log_message(SYSTEM_LOG, $this->input->ip_address() . ' => ' . __CLASS__ . '/' . __FUNCTION__ . ' => ' . $usn . ' - Trip data not savedpwd');
                // failed to save trip details
                cus_json_error('Unable to save your trip details, Pleas try again.');
            }
            $this->usr->setSessMsg('Trip request was added successfully. Cofirm the details and request for approval', 'success');
            $json = [
                'status' => ['error' => FALSE, 'redirect' => TRUE, 'redirect_url' => site_url('trip/previewrequest/' . $res)]
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

        $usn = $this->input->post('ad_name');

        if (empty($email)) {
            return TRUE;
        }

        $driver = $this->driver->getDriverProfiles(NULL, ['dp_ad_name <>' => $usn, 'dp_email' => $email], 1);
        if ($driver) {
            $this->form_validation->set_message('validateDriverEmail', 'Email address is being used by other driver');
            return FALSE;
        }

        return TRUE;
    }

    public function validateDriverPhoneNumber($phone) {

        $usn = $this->input->post('ad_name');

        if (empty($phone)) {
            return TRUE;
        }
        $driver = $this->driver->getDriverProfiles(NULL, ['dp_ad_name <>' => $usn, 'dp_phone_number' => cus_phone_with_255($phone)], 1);
        if ($driver) {
            $this->form_validation->set_message('validateDriverPhoneNumber', 'Phone number  is being used by other driver');
            return FALSE;
        }
        return TRUE;
    }

    public function validateDriverLicence($license) {

        $usn = $this->input->post('ad_name');

        if (empty($license)) {
            return TRUE;
        }
        $driver = $this->driver->getDriverProfiles(NULL, ['dp_ad_name <>' => $usn, 'dp_license_number' => $license], 1);
        if ($driver) {
            $this->form_validation->set_message('validateDriverLicence', 'License number is being used by other driver');
            return FALSE;
        }
        return TRUE;
    }

    public function validateLicenseExpiry($license_expiry) {

        $usn = $this->input->post('ad_name');

        if (empty($license)) {
            return TRUE;
        }

        if (time() > strtotime($time)) {
            $this->form_validation->set_message('validateDriverLicence', 'License number is being used by other driver');
            return FALSE;
        }
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

}
