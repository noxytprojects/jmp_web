<?php

Class UserModel extends CI_Model {
    
    
    var $is_logged_in = false;
    var $user_id = null;
    var $is_admin = false;
    var $is_support = false;
    var $user_role = null;
    var $year_id = null;
    var $user_email = "";
    var $user_fullname ="";
    
    public function __construct() {
        parent::__construct();
        
        if($this->isLogedin()){
            
            $this->user_id = $this->session->userdata['logged_in']['user_id'];
            $this->user_email = $this->session->userdata['logged_in']['user_email'];
            $this->user_fullname = $this->session->userdata['logged_in']['user_fullname'];
            $this->user_role = $this->session->userdata['logged_in']['user_role'];
            $this->year_id =  $this->session->userdata['logged_in']['user_meeting_year_id'];
            $this->is_logged_in = TRUE;
            $this->is_admin = $this->user_role == 'ADMIN'? TRUE : FALSE;
            $this->is_support = $this->user_role == 'SUPPORT'? TRUE : FALSE;
            $this->updateLastActivityTime();
        }
    }
    
    public function setSessMsg($msg, $type, $url) {
        $this->session->set_flashdata($type, $msg);
        redirect($url);
    }
    
    
    public function getUserInfo($user, $type = null) {
        
        if($type == 'AD'){
            $this->db->where('u.usr_ad_name',$user);
        }elseif($type == 'ID'){
            $this->db->where('u.usr_id',$user);
        }elseif($type == 'EMAIL'){
            $this->db->where('u.usr_email',$user);
        }
        
        
        $this->db->from('users u');
        $this->db->limit(1);
        
        $q = $this->db->get();
        
        if($q->num_rows() == 1){
            return $q->row_array();
        }else{
            return FALSE;
        }
        
    }
    
    
    public function isLogedin() {

        $this->load->library('user_agent');
        
        $user_agent = $this->agent->agent_string();
        
        if (isset($this->session->userdata['logged_in'])) {
            
            $user = $this->getUserInfo($this->session->userdata['logged_in']['user_id'], 'ID');
            
            if(!$user){
                return false;
            }
            
            if(sha1($user_agent) != $user['usr_user_agent']){
                return FALSE;
            }
            
            return true;
        } else {
            return false;
        }
        
    }
    
    
    public function yearIsActive($year_id) {
        
        $year = $this->utl->getMeetingYears(['year_id' => $year_id], 1);
        
        if($year['year_status'] == 'OPENED'){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }
    
    
    
    
    
    public function getUsersList($cond = null) {
        
        if(!empty($cond)){
             $this->db->where($cond);
        }
        $res = $this->db
                ->from('users')
                ->order_by('usr_ad_name')
                ->get();
        
        return $res->result_array();
    }
    
    
    public function saveUserDetails($user_data) {
        
        $this->db->trans_start();
        //$this->db->trans_strict(FALSE);
        
        $this->db->insert('users', $user_data);
        
        $user_id = $this->db->insert_id();
        
        //$this->db->where('usr_id',$user_id)->update('ycc_users', ['usr_admin_id' => $user_id]);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            return FALSE;
        } else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    
     public function saveEditUser($user_data,$user_id) {
        
        $this->db->where('usr_id',$user_id)->update('users',$user_data);
        //log_message(SYSTEM_LOG, $this->session->userdata['logged_in']['user_fullname'] . ' saveEditUser updated user '. $user_id . ' data:' . json_encode($user_data));
        
        return $this->db->affected_rows();
        
    }
    
    
    public function confirmDeleteUser($user_data, $user_id) {
        $this->db->where('usr_id',$user_id)->update('users',$user_data);
        return $this->db->affected_rows();
    }
    
    public function getAnymousUser($user) {
        
        $res = $this->db->where('usr_email',$user)->or_where('usr_ad_name',$user)->limit(1)->get('users');
        
        if($res->num_rows() == 1){
            return $res->row_array();
        } else {
            return FALSE;
        }
    }
    
    
    public function updateLastActivityTime() {
        
        $this->load->library('user_agent');
        
        $user_agent = $this->agent->agent_string();
        
        $this->db->where('usr_id', $this->user_id)->update('users',['usr_last_activity_time'=> date('Y-m-d H:i:s'),'usr_user_agent' => sha1($user_agent)]);
    }
   
}