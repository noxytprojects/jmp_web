<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utility extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
    }
    
    
    public function removeUpload() {
        
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');
        
        
        $att_id = $this->uri->segment(3);
        $type = $this->uri->segment(4);
        $path = "";
        
        
        switch ($type) {
            case 'DRIVER_LICENSE':
                $attachment  = $this->utl->getAttachments(NULL, ['att.att_type' => $type,'att.att_id' => $att_id], 1);
                $path = FCPATH . 'uploads/license/';
                break;
            
            case 'MEDICAL_FITNESS':
                $attachment  = $this->utl->getAttachments(NULL, ['att.att_type' => $type,'att.att_id' => $att_id], 1);
                $path = FCPATH . 'uploads/medical/';
                break;
            
            case 'TRIP_REQUEST':
                $attachment  = $this->utl->getAttachments(NULL, ['att.att_type' => $type,'att.att_id' => $att_id], 1);
                $path = FCPATH . 'uploads/request/';
                break;


            default:
                $attachment = FALSE;
                break;
        }
        
        
        
        if(!$attachment){
            cus_json_error('Cant remove file');
        }
        
        $path .= $attachment['att_name'];
        
        log_message(SYSTEM_LOG, $path);
        
        $res = $this->utl->removeFile($attachment['att_id']);
        
        
        if(!$res){
            cus_json_error('File not removed');
        }
        
        if(file_exists($path)){
            unlink($path);
        }
        
        echo json_encode(['status' => ['error' => FALSE]]);
        
    }


}
