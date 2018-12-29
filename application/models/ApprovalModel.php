<?php

Class ApprovalModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Ajax approval officials start here

    public function saveRoute($data) {

        $this->db->trans_start();

        $this->db->insert_batch('route', $data['new_route']);
        $this->db->where('tr_id', $data['tr_id'])->update('trip_request', ['tr_status' => 'NEW']);

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    private function _select_ao($data) {

        $this->db->select($data['select_columns'])
                ->from('approval_officials ao');

        if ($data['where_in'] != NULL) {
            foreach ($data['where_in'] as $key => $wn) {
                $this->db->where_in($key, $wn);
            }
        }

        if (null !== $data['cond']) {
            $this->db->where($data['cond']);
        }
    }

    private function _get_datatables_ao($data) {

        $this->_select_ao($data);

        $i = 0;
        foreach ($data['search_columns'] as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($data['search_columns']) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($data['order_columns'][$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($data['default_order_column'])) {
            $order = $data['default_order_column'];
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_ao($data) {

        $this->_get_datatables_depts($data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_ao($data) {
        $this->_get_datatables_ao($data);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_ao($data) {
        $this->_select_ao($data);
        return $this->db->count_all_results();
    }

    // End of Ajax Call

    public function updateApprovalStatusBk($data) {
        $this->db->trans_start();

        $this->db->where(['ap_tr_id' => $data['tr_id'], 'ap_ad_name' => $data['ad_name']])
                ->update('approval', $data['approval_data']);
        $this->db->where('tr_id', $data['tr_id'])->update('trip_request', $data['tr_data']);

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    public function updateApprovalStatus($data) {

        $this->db->trans_start();

        $this->db->where(['auth_usr_email' => $data['approval']['auth_usr_email'], 'auth_tr_id' => $data['approval']['auth_tr_id']])->update('authoriser', $data['approval_data']);
        $this->db->where('tr_id', $data['approval']['auth_tr_id'])->update('trip_request', ['tr_proc_key' => NULL, 'tr_route_state' => '0']);

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
        $this->db->where('tr_id', $data['tr_id'])->update('trip_request', $data['tr_data']);

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
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


        $res = $this->db->from('approval_officials ao')->order_by('ao_title', 'ACS')->get();



        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }

    public function getRequestRoute($cols = null, $cond = null, $limit = null, $where_in = null) {

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


        $res = $this->db->from('route r')
                ->join('authoriser auth', 'r.r_usr_title = auth.auth_usr_title AND r.r_tr_id = auth.auth_tr_id', 'LEFT OUTER')
                ->join('trip_request tr', 'tr.tr_id = r.r_tr_id', 'INNER')
                ->join('users u', 'u.usr_title = r.r_usr_title')
                ->get();




        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
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


        $res = $this->db
                ->from('authoriser auth')
                ->join('route r', 'r.r_usr_title = auth.auth_usr_title AND r.r_tr_id = auth.auth_tr_id', 'INNER')
                ->join('users u', 'u.usr_email = auth.auth_usr_email', 'LEFT OUTER')
                ->join('trip_request tr', 'tr.tr_id = auth.auth_tr_id', 'INNER')
                ->join('drivers_profile dp','dp.dp_usr_id = tr.tr_usr_id')
                ->join('users c', 'c.usr_id = tr.tr_usr_id')
                ->order_by('r_sequence', 'ACS')
                ->get();



        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }

}
