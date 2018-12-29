<?php

Class DriverModel extends CI_Model {

    public function __construct() {
        parent::__construct();

    }
 
    public function getDriverProfiles($cols = null, $cond = null, $limit = null, $where_in = null) {

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


        $res = $this->db->from('drivers_profile dp')
                ->join('department dept','dept.dept_id = dp.dp_dept_id','INNER')
                ->join('users u','u.usr_id = dp.dp_usr_id')
                ->join('users ao','ao.usr_title = dp.dp_ao_title')
                ->join('section sec','sec.sec_id = dp.dp_section_id','INNER')->get();
        

        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }
    
    public function saveDriverDetails($data) {
        $this->db->trans_start();

        $res = $this->getDriverProfiles(NULL, ['dp_usr_id' => $data['user_id']], 1);
        
        if($res){
            $this->db->where('dp_usr_id',$res['dp_usr_id'])->update('drivers_profile',$data['driver_data']);
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => '.__CLASS__.'/'.__FUNCTION__.' => ' . $data['user_email'] . ' - Updating driver details for the first time.');
            
        }else{
            $data['driver_data']['dp_usr_id'] = $data['user_id'];
            $data['driver_data']['dp_created_time'] = $data['timestamp'];
            $this->db->insert('drivers_profile', $data['driver_data']);
        }
        
        
        // Set new licence attachment status to 1 if exist and delete ther old one
        if($data['license_attachments']){
            $this->db->where(['att_ref' => $data['user_id'],'att_status' => '1','att_type' =>'DRIVER_LICENSE'])->delete('attachment');
            $this->db->where(['att_ref' => $data['user_id'],'att_status' => '0','att_type' =>'DRIVER_LICENSE'])->update('attachment',['att_status' => 1]);
        }
        
        
        // Set new edical attachment status to 1 if exist and delete ther old one
        if($data['medical_attachments']){
            $this->db->where(['att_ref' => $data['user_id'],'att_status' => '1','att_type' =>'MEDICAL_FITNESS'])->delete('attachment');
            $this->db->where(['att_ref' => $data['user_id'],'att_status' => '0','att_type' =>'MEDICAL_FITNESS'])->update('attachment',['att_status' => 1]);
        }
        
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    
    
    public function updateDriverDetails($data,$driver_usr_id) {
        
        $this->db->trans_start();

        $this->db->where('dp_usr_id',$driver_usr_id)->update('drivers_profile', $data['driver_data']);
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        
    }
    
    public function getDriverMedicalAssessment($cols = null, $cond = null, $limit = null, $where_in = null) {


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



    $res = $this->db->from('medical_assessment ma')
            ->join('drivers_profile dp','dp.dp_email = ma.ma_emp_email','INNER')->get();


    if ($limit == 1 AND $res->num_rows() == 1) {
        return $res->row_array();
    } elseif ($limit == 1 AND $res->num_rows() != 1) {
        return false;
    } else {
        return $res->result_array();
    }
}

}
