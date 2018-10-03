<?php

Class VotingModel extends CI_Model {

    public function saveManualVoting($data, $cond) {

        $this->db->trans_start();

        foreach ($data['voting_data'] as $key => $vd) {

            $this->db->where(['vote_res_id' => $vd['res_id'], 'vote_att_id' => $vd['att_id'], 'vote_selection' => $vd['selection']])
                    ->where($cond)
                    ->update('votes', $vd['answer_data']);
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

    public function getVoteAnswers($cond = null, $cols = null, $limit = null) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }


        if ($this->db->dbdriver == 'pdo') {

            $res = $this->db->from('votes v')
                    ->join('resolutions res', 'res.res_id = v.vote_res_id', 'INNER')
                    ->join('attendants att', 'att.att_id = v.vote_att_id', 'INNER')
                    ->join("(SELECT att.cds_att_att_id, SUM(cds.cds_acc_shares) shares "
                            . "FROM " . $this->db->dbprefix . "cds_accounts cds," . $this->db->dbprefix . "cds_attendance att "
                            . "WHERE cds.cds_acc_number = att.cds_att_acc_number GROUP BY att.cds_att_att_id ) AS sh", 'sh.cds_att_att_id = att.att_id', 'INNER')
                    ->join("(SELECT a.att_id, 
                                cds_accounts = STUFF((SELECT ',' + cds.cds_att_acc_number 
                                FROM " . $this->db->dbprefix . "cds_attendance cds WHERE cds.cds_att_att_id = a.att_id FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '')
                                FROM " . $this->db->dbprefix . "attendants a) AS cds", 'cds.att_id = att.att_id', 'INNER')
                    ->join('resolution_choices rch', 'rch.choice_letter = v.vote_answer AND rch.choice_res_id = res.res_id ', 'LEFT OUTER')
                    ->get();
        } elseif ($this->db->dbdriver == 'mysqli') {

            $res = $this->db->from('votes v')
                    ->join('resolutions res', 'res.res_id = v.vote_res_id', 'INNER')
                    ->join('attendants att', 'att.att_id = v.vote_att_id', 'INNER')
                    ->join("(SELECT att.cds_att_att_id, SUM(cds.cds_acc_shares) shares "
                            . "FROM " . $this->db->dbprefix . "cds_accounts cds," . $this->db->dbprefix . "cds_attendance att "
                            . "WHERE cds.cds_acc_number = att.cds_att_acc_number GROUP BY att.cds_att_att_id ) AS sh", 'sh.cds_att_att_id = att.att_id', 'INNER')
                    ->join("(SELECT cds_att_att_id, GROUP_CONCAT(cds_att_acc_number SEPARATOR ', ') cds_accounts "
                            . "FROM " . $this->db->dbprefix . "cds_attendance GROUP BY cds_att_att_id) AS cds", 'cds.cds_att_att_id = att.att_id', 'INNER')
                    ->join('resolution_choices rch', 'rch.choice_letter = v.vote_answer AND rch.choice_res_id = res.res_id ', 'LEFT OUTER')
                    ->get();
        }


        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    //AJAX RETRIEVING APPLICANTS
    private function get_filtered_manual_voting_attendee($data) {

        // Query to change
        // For Mbezi Server beacause its using PDO 
        if ($this->db->dbdriver == 'pdo') {
            $res = $this->db->from('attendants att')
                    ->join("(SELECT vote_att_id FROM  " . $this->db->dbprefix . "votes "
                            . "WHERE ((vote_answer IN ('N/A') OR vote_answer IS NULL) AND vote_status = '2') "
                            . "GROUP BY vote_att_id) AS v", 'v.vote_att_id = att.att_id', 'INNER')
                    ->join("(SELECT
                                a.att_id,
                                cds_accounts = STUFF((SELECT ',' + cds.cds_att_acc_number
                                FROM " . $this->db->dbprefix . "cds_attendance cds WHERE cds.cds_att_att_id = a.att_id FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '')
                                FROM " . $this->db->dbprefix . "attendants a) AS cds", 'cds.att_id = att.att_id', 'INNER');
            $this->db->where_in('att.att_has_smartphone',$data['att_has_smartphone_in']);
        }


        // For mysql database because its using mysqli driver
        if ($this->db->dbdriver == 'mysqli') {
            $res = $this->db->from('attendants att')
                    ->join("(SELECT vote_att_id FROM  " . $this->db->dbprefix . "votes "
                            . "WHERE ((vote_answer IN ('N/A') OR vote_answer IS NULL) AND vote_status = '2')"
                            . "GROUP BY vote_att_id) AS v", 'v.vote_att_id = att.att_id', 'INNER')
                    ->join("(SELECT cds_att_att_id, GROUP_CONCAT(cds_att_acc_number SEPARATOR ', ') cds_accounts "
                    . "FROM " . $this->db->dbprefix . "cds_attendance GROUP BY cds_att_att_id) AS cds", 'cds.cds_att_att_id = att.att_id', 'INNER');
            $this->db->where_in('att.att_has_smartphone',$data['att_has_smartphone_in']);
        }
        
    }

    private function _get_datatables_manual_voting_attendees($data) {

        $this->get_filtered_manual_voting_attendee($data);
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
        } else if (isset($data['default_order_columns'])) {
            $order = $data['default_order_columns'];
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_manual_voting_attendees($data) {

        $this->_get_datatables_manual_voting_attendees($data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_manual_voting_attendees($data) {
        $this->_get_datatables_manual_voting_attendees($data);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_manual_voting_attendees($data) {
        $this->get_filtered_manual_voting_attendee($data);
        return $this->db->count_all_results();
    }

}
