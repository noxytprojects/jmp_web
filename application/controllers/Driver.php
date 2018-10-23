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

        $driver = $this->driver->getDriverProfiles(NULL, ['dp.dp_ad_name' => $this->usr->ad_name], 1);

        $depts = $this->mnt->getDepartments();

        $sections = $this->mnt->getSections(NULL, ['sec.sec_dept_id' => $driver['dp_dept_id']]);
        
        $license_attachments = $this->utl->getAttachments(NULL, ['att.att_type' =>'DRIVER_LICENSE','att.att_ref'=> $this->usr->ad_name]);
        $medical_attachments = $this->utl->getAttachments(NULL, ['att.att_type' =>'MEDICAL_FITNESS','att.att_ref'=> $this->usr->ad_name]);
        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_update_profile',
            'menu_data' => ['curr_menu' => 'DRIVER', 'curr_sub_menu' => 'DRIVER'],
            'content_data' => [
                'module_name' => 'Udpate Driver Profile',
                'depts' => $depts,
                'sections' => $sections,
                'driver' => $driver,
                'ad_name' => $this->usr->ad_name,
                'license_attachments' => $license_attachments,
                'medical_attachments' => $medical_attachments,
                'managers' => $this->approval->getApprovalOfficials()
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

}
