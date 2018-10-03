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

        $res = $this->getDriverProfiles(NULL, ['dp_ad_name' => $data['ad_name']], 1);
        
        if($res){
            $this->db->where('dp_ad_name',$res['dp_ad_name'])->update('drivers_profile',$data['driver_data']);
            log_message(SYSTEM_LOG, $this->input->ip_address() . ' => DriverModel/saveDriverDetails => ' . $res['dp_ad_name'] . ' - Updating driver details for the first time.');
            
        }else{
            $data['driver_data']['dp_ad_name'] = $data['ad_name'];
            $data['driver_data']['dp_created_time'] = $data['timestamp'];
            $this->db->insert('drivers_profile', $data['driver_data']);
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

}
