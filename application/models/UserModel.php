<?php

Class UserModel extends CI_Model {

    var $is_logged_in = false;
    var $user_id = null;
    var $user_ad_name = null;
    var $is_admin = false;
    var $is_support = false;
    var $user_role = null;
    var $year_id = null;
    var $user_email = "";
    var $user_fullname = "";
    var $user_title = "";
    var $user_contractor = "";
    var $user_delegated_title = "";
    var $last_activity = null;

    public function __construct() {
        parent::__construct();

        if ($this->isLogedin()) {
            $this->user_id = $this->session->userdata['logged_in']['user_id'];
            $this->user_email = $this->session->userdata['logged_in']['user_email'];
            $this->user_ad_name = $this->session->userdata['logged_in']['user_ad_name'];
            $this->user_fullname = $this->session->userdata['logged_in']['user_fullname'];
            $this->user_role = $this->session->userdata['logged_in']['user_role'];
            $this->user_contractor = $this->session->userdata['logged_in']['user_contractor'];
            $this->is_logged_in = TRUE;
            $this->is_admin = $this->user_role == 'ADMIN' ? TRUE : FALSE;
            $this->is_support = $this->user_role == 'SUPPORT' ? TRUE : FALSE;
            $this->user_title = $this->session->userdata['logged_in']['user_title'];
            $this->user_delegated_title = $this->session->userdata['logged_in']['user_delegated_title'];
            $this->updateLastActivityTime();
        }

        $this->_updateUserActivity();
    }

    private function _updateUserActivity() {
        $vals = json_decode(file_get_contents('php://input'), true);
        if (isset($vals['user_id'])) {
            $user = $this->getUserInfo($vals['user_id'], 'ID');
            if ($user) {
                $this->last_activity = !empty($user['usr_mobile_last_activity']) ? $user['usr_mobile_last_activity'] : date('Y-m-d H:i:s');
                log_message(SYSTEM_LOG, 'Updating user last activity for ' . $user['usr_email']);

                if (!isset($vals['ignore_update'])) {
                    $this->db->where('usr_id', $vals['user_id'])->update('users', ['usr_mobile_last_activity' => date('Y-m-d H:i:s')]);
                }
            }
        }
    }

    public function setSessMsg($msg, $type, $url = NULL) {
        $this->session->set_flashdata($type, $msg);

        if (NULL !== $url) {
            redirect($url);
        }
    }

    public function getUserInfo($user, $type = null) {

        if ($type == 'AD') {
            $this->db->where('u.usr_ad_name', $user);
        } elseif ($type == 'ID') {
            $this->db->where('u.usr_id', $user);
        } elseif ($type == 'EMAIL') {
            $this->db->where('u.usr_email', $user);
        }


        $this->db->from('users u');
        $this->db->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row_array();
        } else {
            return FALSE;
        }
    }

    public function isLogedin() {

        $this->load->library('user_agent');

        $user_agent = $this->agent->agent_string();

        if (isset($this->session->userdata['logged_in'])) {

            $user = $this->getUserInfo($this->session->userdata['logged_in']['user_id'], 'ID');

            if (!$user) {
                return false;
            }

            if (sha1($user_agent) != $user['usr_user_agent']) {
                return FALSE;
            }

            return true;
        } else {
            return false;
        }
    }

    public function yearIsActive($year_id) {

        $year = $this->utl->getMeetingYears(['year_id' => $year_id], 1);

        if ($year['year_status'] == 'OPENED') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getUsersList($cond = null, $cols = null, $limit = null, $where_in = null) {


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

        $res = $this->db
                ->from('users u')
                ->order_by('u.usr_fullname')
                ->get();


        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }

    public function saveUserDetails($user_data) {

        $this->db->trans_start();
        //$this->db->trans_strict(FALSE);

        $this->db->insert('users', $user_data);

        //$user_id = $this->db->insert_id();
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

    public function saveEditUser($user_data, $user_id) {


        $this->db->trans_start();

        $this->db->where('usr_id', $user_id)->update('users', $user_data);

        if (isset($user_data['usr_pwd']) AND isset($user_data['usr_change_pass'])) {

            if ($user_data['usr_change_pass'] == '0') {
                $this->addNewPassword($user_id, $user_data['usr_pwd']);
            }
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

    public function addNewPassword($user_id, $password) {

        //Initialize 
        $data = ["pass_user_id" => $user_id, "pass_itself" => $password];

        // Counting password changes
        $tot_pass = $this->db->where('pass_user_id', $user_id)->from('password_changes')->count_all_results();

        // Insert ne password
        $this->db->insert('password_changes', $data);
        // Delete very old password if PASS_CHANGES_MAX_COUNT reached

        if ($tot_pass >= 10) {
            $this->db->where("pass_timestamp IS NOT NULL AND pass_user_id ='" . $user_id . "'")->order_by('pass_timestamp', 'DESC')->limit(1)->delete('password_changes');
        }
    }

    public function confirmDeleteUser($user_data, $user_id) {
        $this->db->where('usr_id', $user_id)->update('users', $user_data);
        return $this->db->affected_rows();
    }

    public function getAnymousUser($emai_or_ad_name, $cols = NULL) {

        if (NULL !== $cols) {
            $this->db->selct($cols);
        }
        $res = $this->db->where('usr_email', $emai_or_ad_name)->or_where('usr_ad_name', $emai_or_ad_name)->limit(1)->get('users');

        if ($res->num_rows() == 1) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }

    public function updateLastActivityTime() {

        $this->load->library('user_agent');

        $user_agent = $this->agent->agent_string();

        $this->db->where('usr_id', $this->user_id)->update('users', ['usr_mobile_last_activity' => date('Y-m-d H:i:s'), 'usr_user_agent' => sha1($user_agent)]);
    }

    public function checkIfPasswordIsOld($usr_id, $password) {

        $q = $this->db->where('pass_user_id', $usr_id)
                ->where('pass_itself', sha1($password))
                ->get('password_changes');

        if ($q->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getInbox() {
        $permits_to_approve = $this->approval->getRequestApprovals(['auth.auth_tr_id', 'tr.tr_id', 'tr.tr_journey_purpose', 'dp.dp_full_name'], "auth.auth_status IS NULL AND r.r_notification_status = '1' ", NULL, ['auth.auth_usr_title' => $this->getUserApprovalTitles()]);
        return $permits_to_approve;
    }

    public function getExtendedPermitCount() {
        //$permits_to_approve = $this->approval->getPermitApprovals(['auth.auth_p_id', 'p.p_id', 'p.p_description', 'c.usr_fullname contractor'], "auth.auth_status IS NULL AND r.r_notification_status = '1' AND p.p_extended = '1' ", NULL, ['auth.auth_usr_title' => $this->getUserApprovalTitles()]);
        return [];//$permits_to_approve;
    }

    public function getUserApprovalTitles($user_id = NULL) {

        $approval_titles = ['NONE'];

        if (NULL === $user_id) {
            $user_id = $this->user_id;
        }

        $user = $this->getUserInfo($user_id, 'ID');

        if (!empty($user['usr_title'])) {
            $approval_titles[] = $user['usr_title'];
        }

        $delegated_title = $this->getUsersList(['u.usr_delegator' => $user['usr_email']], null, 1);

        if ($delegated_title) {
            $approval_titles[] = $delegated_title['usr_title'];
        }
        return $approval_titles;
    }

    public function getDelegations($cols = null, $cond = null, $limit = null, $where_in = null) {


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


        $res = $this->db->from('delegation del')
                ->join('users u', 'u.usr_email = del.del_us_id', 'INNER')
                ->join('users d', 'd.usr_email =  del.del_us_delegated')
                ->get();



        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }

    public function saveCancelDelegation($data) {
        $this->db->trans_start();

        $this->db->where('usr_email', $data['history_data']['del_us_id'])->update('users', ['usr_delegator' => NULL]);
        $this->db->where('del_us_id', $data['history_data']['del_us_id'])->delete('delegation');
        $this->db->insert('delegation_history', $data['history_data']);

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function saveDelegation($data) {

        $this->db->trans_start();

        $this->db->insert('delegation', $data['del_data']);

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function validateSession($user, $key) {
        
        $_user = $this->getUserInfo($user, 'ID');

        if ($_user) {

            $time_elapse = strtotime($this->last_activity) + (int) $this->config->item('sess_expiration');
            $current_time = time();

            log_message(SYSTEM_LOG, 'session => ' . $this->config->item('sess_expiration') . ', seconds left ' . ($time_elapse - $current_time) . ' time elapse => ' . $time_elapse . '/' . date('Y-m-d H:i:s', $time_elapse) . ',  current_time =>' . $current_time . '/' . date('Y-m-d H:i:s', $current_time));


            if (( $time_elapse > $current_time)) { //$_user[0]->joPassword == $key AND
                return TRUE;
            } else {
                
                // Revert user last activity
                log_message(SYSTEM_LOG, 'update user session to previous ' . $_user['usr_email'] . ' time: '. $this->last_activity);
                $this->db->where('usr_id', $_user['usr_id'])->update('users', ['usr_mobile_last_activity' => $this->last_activity]);
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}
