<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function updateProfile() {

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'jmp/view_update_profile',
            'menu_data' => ['curr_menu' => 'DRIVER', 'curr_sub_menu' => 'DRIVER'],
            'content_data' => ['module_name' => 'All Applicants'],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }


}
