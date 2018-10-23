<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function cacheFields() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your session might have been expired please refresh the page');
        }

        // Initialize valid fields
        $valid_fields = ['dept'];

        // initialize post inputs
        $field = $this->input->post('field');
        $value = $this->input->post('value');

        if (!in_array($field, $valid_fields)) {
            cus_json_error('Invalid field encountered, Please contact system developer');
        }

        switch ($field) {

                
            case 'dept':
                
                $selections [] = ['text' => '', 'id' => ''];
                
                $sections = $this->mnt->getSections(NULL, ['sec.sec_dept_id' => $value]);
                
                foreach($sections as $section){
                    $selections[] = ['text' => $section['sec_name'],'id' => $section['sec_id'] ];
                }
                
                $json = ['status' => ['error' => false],'selections' => $selections];
                
                break;
        }

        echo json_encode($json);
        die();
    }

}
