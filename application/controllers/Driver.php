<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function updateProfile() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg(MSG_EXPIRY_SESSION, 'error', 'user');
        }

        $driver = $this->driver->getDriverProfiles(NULL, ['dp.dp_usr_id' => $this->usr->user_id], 1);

        if(!$driver){
            
           $user = $this->usr->getAnymousUser($this->usr->user_email);
           $driver = [
               'dp_full_name' => $user['usr_fullname'],
               'dp_dept_id' => "",
               'dp_phone_number' => $user['usr_phone'],
               'dp_email' => $user['usr_email'],
               'dp_ao_title' => "",
               'dp_license_number' => "",
               'dp_license_expiry' => "",
               'dp_medical_by_osha' => "",
               'dp_medical_date' => ""
           ];
        }
        
        $depts = $this->mnt->getDepartments();
        $sections = $this->mnt->getSections(NULL, ['sec.sec_dept_id' => $driver['dp_dept_id']]);
        
        $license_attachments = $this->utl->getAttachments(NULL, ['att.att_type' =>'DRIVER_LICENSE','att.att_ref'=> $this->usr->user_id]);
        $medical_attachments = $this->utl->getAttachments(NULL, ['att.att_type' =>'MEDICAL_FITNESS','att.att_ref'=> $this->usr->user_id]);
        
        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_update_profile',
            'menu_data' => ['curr_menu' => 'DRIVER', 'curr_sub_menu' => 'DRIVER','inbox_count' => $this->usr->getInbox()],
            'content_data' => [
                'module_name' => 'Udpate Driver Profile',
                'depts' => $depts,
                'sections' => $sections,
                'driver' => $driver,
                'ad_name' => $this->usr->user_ad_name,
                'license_attachments' => $license_attachments,
                'medical_attachments' => $medical_attachments,
                'managers' => $this->usr->getUsersList("usr_title IS NOT NULL AND usr_role IN ('ADMIN','MANAGER')", ['usr_title','usr_ad_name','usr_fullname']) //$this->approval->getApprovalOfficials()
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['inbox' => $this->usr->getInbox(),]
        ];

        $this->load->view('view_base', $data);
    }

}
