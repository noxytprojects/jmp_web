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
    
    
    public function getRequestApprovals($cols = null, $cond = null, $limit = null, $where_in = null) {


        if ($cols !== NULL) {
            $this->db->select($cols);
        }

        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit !== NULL) {
            $this->db->limit($limit);
        }

        if ($where_in != NULL) {
            foreach ($where_in as $key => $wn) {
                $this->db->where_in($key, $wn);
            }
        }

        
        $res = $this->db->from('approval ap')
                ->join('section sec','sec.sec_tl_ad_name = ap.ap_ad_name')
                ->join('trip_request tr','tr.tr_id = ap.ap_tr_id')->get();



        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }
    
    
    public function getApprovalOfficials($cols = null, $cond = null, $limit = null, $where_in = null) {


    if ($cols !== NULL) {
        $this->db->select($cols);
    }

    if ($cond !== NULL) {
        $this->db->where($cond);
    }

    if ($limit !== NULL) {
        $this->db->limit($limit);
    }

    if ($where_in != NULL) {
        foreach ($where_in as $key => $wn) {
            $this->db->where_in($key, $wn);
        }
    }


    $res = $this->db->from('approval_officials ao')->get();
    
    
    if ($limit == 1 AND $res->num_rows() == 1) {
        return $res->row_array();
    } elseif ($limit == 1 AND $res->num_rows() != 1) {
        return false;
    } else {
        return $res->result_array();
    }
}

}
