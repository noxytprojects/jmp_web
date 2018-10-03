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
        $valid_fields = ['cds_number'];

        // initialize post inputs
        $field = $this->input->post('field');
        $value = $this->input->post('value');

        if (!in_array($field, $valid_fields)) {
            cus_json_error('Invalid field encountered, Please contact system developer');
        }

        switch ($field) {

            case 'cds_number':

                $rep_cds [] = ['text' => '', 'id' => ''];

                $cds_accounts = $this->shareholder->getCdsAccounts(NULL, ['cds_acc_number <>' => $value], NULL, TRUE);
                $shareholder = $this->shareholder->getCdsAccounts(NULL, ['cds_acc_number' => $value], 1);

                foreach ($cds_accounts as $c) {
                    $rep_cds[] = ['text' => $c['cds_acc_number'] . ' - ' . $c['cds_acc_fullname'], 'id' => $c['cds_acc_number']];
                }
                $json = ['status' => ['error' => FALSE], 'rep_cds' => $rep_cds, 'shareholder' => $shareholder];
                

                break;
        }

        echo json_encode($json);
        die();
    }

}
