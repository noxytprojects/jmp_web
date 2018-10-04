<?php

Class ApprovalModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function updateApprovalStatus($data) {
        $this->db->trans_start();

        $this->db->where(['ap_tr_id'=>$data['tr_id'],'ap_ad_name' => $data['ad_name']])
                ->update('approval', $data['approval_data']);
        $this->db->where('tr_id',$data['tr_id'])->update('trip_request',$data['tr_data']);
        
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    
    public function saveApprovalStatus($data) {
        
        $this->db->trans_start();

        $this->db->insert('approval', $data['approval_data']);
        $this->db->where('tr_id',$data['tr_id'])->update('trip_request',$data['tr_data']);
        
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}
