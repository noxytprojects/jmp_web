<?php

Class FirebaseModel extends CI_Model {

    public function checkFirebaseTokenExist($token) {

        $res = $this->db->where('ft_token', $token)->get('firebase_tokens');
        if ($res->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateFirebaseToken($user, $token, $token_exist) {

        $res = $this->db->where('ft_user_id', $user)->where('ft_token', $token)->get('firebase_tokens');

        if ($res->num_rows() > 0) {
            
        } else {
            if ($token_exist) {
                $this->db->set(['ft_user_id' => $user])->where(['ft_token' => $token])->update('firebase_tokens');
            } else {
                $data = ['ft_user_id' => $user, 'ft_token' => $token];
                $this->db->insert('firebase_tokens', $data);
            }
        }
    }

    public function firebaseToken($user) {
        $firebase_token = $this->input->post('firebase_token');
        if (!empty($firebase_token) AND ! is_array($firebase_token)) {
            $token_exist = $this->checkFirebaseTokenExist($firebase_token);
            $this->updateFirebaseToken($user, $firebase_token, $token_exist);
        }
    }
    
    
    public function unsubscribe($token) {
        $this->db->delete('firebase_tokens',['ft_token' => $token]);
    }
    
    public function getFirebaseTokens($cols = null, $cond = null, $limit = null, $where_in = null) {


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

    $res = $this->db->from('firebase_tokens')->get();

    if ($limit == 1 AND $res->num_rows() == 1) {
        return $res->row_array();
    } elseif ($limit == 1 AND $res->num_rows() != 1) {
        return false;
    } else {
        return $res->result_array();
    }
}

}
