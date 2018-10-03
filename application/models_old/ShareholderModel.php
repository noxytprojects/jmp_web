<?php

Class ShareholderModel extends CI_Model {

    // Cds accounts variables

    var $cds_accounts_search_columns = ['cds_acc_number', 'cds_acc_fullname', 'cds_acc_phone'];
    var $cds_accounts_order_columns = [null, 'cds_acc_number', 'cds_acc_fullname', null, 'cds_acc_address', 'cds_acc_shares', 'cds_acc_shares'];
    var $cds_accounts_default_order_columns = ['cds_acc_fullname'];

    public function getCdsAccounts($cols = NULL, $cond = NULL, $limit = NULL, $not_in_attendance = FALSE, $where_like = NULL) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        if ($not_in_attendance) {
            $this->db->where('cds_acc_number NOT IN (SELECT cds_att_acc_number FROM ' . $this->db->dbprefix . 'cds_attendance )', NULL, FALSE);
        }

        if ($where_like != NULL) {

            foreach ($where_like['columns'] as $i => $col) {
                if ($i == 0) {
                    $this->db->group_start();
                    $this->db->like($col, $where_like['val']);
                } else {
                    $this->db->or_like($col, $where_like['val']);
                }
                
                if((count($where_like['columns']) - 1) == $i){
                    $this->db->group_end();
                }
            }
            
        }
        $this->db->order_by('cds_acc_fullname');

        $res = $this->db->get('cds_accounts');

        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() < 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function getAttendace($cols = NULL, $cond = NULL, $limit = NULL) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db->from('cds_attendance catt')
                ->join('cds_accounts cacc', 'cacc.cds_acc_number = catt.cds_att_acc_number', 'INNER')
                ->join('attendants att', 'att.att_id = catt.cds_att_att_id', 'INNER')
                ->join('attendants rep', 'rep.att_id = catt.cds_att_rep_id', 'INNER')
                ->order_by('catt.cds_att_timestamp', 'DESC')
                ->get();




        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function getAttendees($cols = NULL, $cond = NULL, $limit = NULL) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db->from('attendants att')
                ->get();

        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND ! $res) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function getShareRegitered($year_id) {

        $res = $this->db->select('catt.cds_att_year_id , SUM(cds.cds_acc_shares) tot_shares')
                ->from('cds_attendance catt , cds_accounts cds')->where('cds.cds_acc_number = catt.cds_att_acc_number')->where('catt.cds_att_year_id', $year_id)
                ->group_by('catt.cds_att_year_id')
                ->get();

        if ($res->num_rows() == 1) {
            $sr = $res->row_array();
            return $sr['tot_shares'];
        } else {
            return FALSE;
        }
    }

    public function getCdsCounts($year_id) {

        $res = $this->db->select('cds_acc_year_id,COUNT(cds_acc_number) tot_cds')
                ->from('cds_accounts')->where('cds_acc_year_id', $year_id)
                ->group_by('cds_acc_year_id')
                ->get();

        if ($res->num_rows() == 1) {
            $sr = $res->row_array();
            return $sr['tot_cds'];
        } else {
            return FALSE;
        }
    }

    public function saveAttendance($data) {

        $attendee_id = NULL;

        $this->db->trans_start();

        // loop throug all shereholders 

        foreach ($data['shareholders'] as $key => $sh) {

            $vote_data = [];

            $this->db->insert('attendants', $sh['att_data']);
            $vote_status = $sh['att_data']['att_has_smartphone'] == '2' ? '2' : '1';

            $sh_attendee_id = $this->db->insert_id();
            if ($sh['is_attendee']) {
                $attendee_id = $sh_attendee_id;
            }

            if (!empty($sh['shareholder_data'])) {
                $sh['shareholder_data']['cds_att_att_id'] = $sh_attendee_id;
                $sh['shareholder_data']['cds_att_rep_id'] = $attendee_id;
                $sh['shareholder_data']['cds_att_year_id'] = $data['year_id'];
                $this->db->insert('cds_attendance', $sh['shareholder_data']);
            }


            // If attendee is shareholder check if there are resolutions that has been voted for
            if ($sh['att_data']['att_attends_as'] == 'SHAREHOLDER') {

                // Loop through each resolution
                foreach ($data['ress'] as $r) {

                    // Check resolution status if ist ruuning or completed
                    switch ($r['res_status']) {

                        // Check if its running
                        case 'RUNNING':

                            // if res type is 3 e should insert multiple selection votes
                            if ($r['res_vote_type'] == '3') {

                                for ($i = 1; $i <= $r['res_max_selection']; $i++) {

                                    $vote_data[] = [
                                        'vote_res_id' => $r['res_id'],
                                        'vote_timestamp' => date('Y-m-d H:i:s'),
                                        'vote_status' => $vote_status,
                                        'vote_answer' => NULL,
                                        'vote_year_id' => $data['year_id'],
                                        'vote_type' => $r['res_vote_type'],
                                        'vote_att_id' => $sh_attendee_id,
                                        'vote_selection' => $i
                                    ];
                                }
                            } else {
                                // else insert just one
                                $vote_data[] = [
                                    'vote_res_id' => $r['res_id'],
                                    'vote_timestamp' => date('Y-m-d H:i:s'),
                                    'vote_status' => $vote_status,
                                    'vote_answer' => NULL,
                                    'vote_year_id' => $data['year_id'],
                                    'vote_type' => $r['res_vote_type'],
                                    'vote_att_id' => $sh_attendee_id,
                                    'vote_selection' => 1
                                ];
                            }

                            break;

                        // Check if its completed
                        case 'COMPLETED':

                            // if res type is 3 e should insert multiple selection votes
                            if ($r['res_vote_type'] == '3') {

                                for ($i = 1; $i <= $r['res_max_selection']; $i++) {
                                    $vote_data[] = [
                                        'vote_res_id' => $r['res_id'],
                                        'vote_timestamp' => date('Y-m-d H:i:s'),
                                        'vote_status' => '2',
                                        'vote_answer' => 'N/A',
                                        'vote_year_id' => $data['year_id'],
                                        'vote_type' => $r['res_vote_type'],
                                        'vote_att_id' => $sh_attendee_id,
                                        'vote_selection' => $i
                                    ];
                                }
                            } else {
                                $vote_data[] = [
                                    'vote_res_id' => $r['res_id'],
                                    'vote_timestamp' => date('Y-m-d H:i:s'),
                                    'vote_status' => '2',
                                    'vote_answer' => 'N/A',
                                    'vote_year_id' => $data['year_id'],
                                    'vote_type' => $r['res_vote_type'],
                                    'vote_att_id' => $sh_attendee_id,
                                    'vote_selection' => 1
                                ];
                            }
                            break;
                    }
                }
            }

            // Check if there is vote data to insert
            if (!empty($vote_data)) {
                $this->db->insert_batch('votes', $vote_data);
            }
        }



        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $attendee_id;
        }
    }

    public function getCdsImportedFiles($cols = NULL, $cond = NULL, $limit = NULL) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db->from('cds_uploads upl')
                ->join('users u', 'u.usr_id = upl.cds_upload_user_id', 'INNER')
                ->join('years y', 'y.year_id = upl.cds_upload_year_id', 'INNER')
                ->order_by('upl.cds_upload_timestamp', 'DESC')
                ->get();


        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function saveCdsImport($data) {

        $total_shares = 0;

        $this->db->trans_start();

        //$this->db->truncate('agm_attendants');
        //$this->db->truncate('agm_cds_attendance');
        //$this->db->where('cds_acc_year_id', $data['year_id'])->delete('cds_accounts');
        if (!empty($data['shareholders'])) {
            $this->db->insert_batch('cds_accounts', $data['shareholders']);
        }
        //$this->db->insert_string('cds_accounts', $data['shareholders']) . ' ON DUPLICATE KEY UPDATE cds_upload_id= \'' . $data['upload_id'] . '\'';

        $this->db->where('cds_upload_id', $data['upload_id'])->update('cds_uploads', $data['file_data']);

        $res = $this->db->select('cds_acc_year_id, SUM(cds_acc_shares) total_shares')
                ->where('cds_acc_year_id', $data['year_id'])
                ->group_by('cds_acc_year_id')
                ->get('cds_accounts');

        if ($res->num_rows() == 1) {
            $res = $res->row_array();
            $total_shares = $res['total_shares'];
        }

        $this->db->set('year_total_share', $total_shares)
                ->where('year_id', $data['year_id'])
                ->update('years');

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function updateAttendance($data, $att_id) {

        $this->db->where(['att_id' => $att_id])->update('attendants', $data);
        return $this->db->affected_rows();
    }

    public function getManaualVotingAttendees($cond = null, $cols = null, $limit = null) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }


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
                                FROM " . $this->db->dbprefix . "attendants a) AS cds", 'cds.att_id = att.att_id', 'INNER')
                    ->get();
        }


        // For mysql database because its using mysqli driver
        if ($this->db->dbdriver == 'mysqli') {
            $res = $this->db->from('attendants att')
                    ->join("(SELECT vote_att_id FROM  " . $this->db->dbprefix . "votes "
                            . "WHERE ((vote_answer IN ('N/A') OR vote_answer IS NULL) AND vote_status = '2')"
                            . "GROUP BY vote_att_id) AS v", 'v.vote_att_id = att.att_id', 'INNER')
                    ->join("(SELECT cds_att_att_id, GROUP_CONCAT(cds_att_acc_number SEPARATOR ', ') cds_accounts "
                            . "FROM " . $this->db->dbprefix . "cds_attendance GROUP BY cds_att_att_id) AS cds", 'cds.cds_att_att_id = att.att_id', 'INNER')
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

    public function getEditManaualVotingAttendees($cond = null, $cols = null, $limit = null) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }


        // Query to change
        // For Mbezi Server beacause its using PDO 
        if ($this->db->dbdriver == 'pdo') {
            $res = $this->db->from('attendants att')
                    ->join("(SELECT vote_att_id FROM  " . $this->db->dbprefix . "votes "
                            . "WHERE (vote_status = '3' AND vote_channel = 'MANUAL') "
                            . "GROUP BY vote_att_id) AS v", 'v.vote_att_id = att.att_id', 'INNER')
                    ->join("(SELECT
                                a.att_id,
                                cds_accounts = STUFF((SELECT ',' + cds.cds_att_acc_number
                                FROM " . $this->db->dbprefix . "cds_attendance cds WHERE cds.cds_att_att_id = a.att_id FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '')
                                FROM " . $this->db->dbprefix . "attendants a) AS cds", 'cds.att_id = att.att_id', 'INNER')
                    ->get();
        }


        // For mysql database because its using mysqli driver
        if ($this->db->dbdriver == 'mysqli') {
            $res = $this->db->from('attendants att')
                    ->join("(SELECT vote_att_id FROM  " . $this->db->dbprefix . "votes "
                            . "WHERE ( vote_status = '3' AND vote_channel = 'MANUAL')"
                            . "GROUP BY vote_att_id) AS v", 'v.vote_att_id = att.att_id', 'INNER')
                    ->join("(SELECT cds_att_att_id, GROUP_CONCAT(cds_att_acc_number SEPARATOR ', ') cds_accounts "
                            . "FROM " . $this->db->dbprefix . "cds_attendance GROUP BY cds_att_att_id) AS cds", 'cds.cds_att_att_id = att.att_id', 'INNER')
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

    // Updates
    // Save edit attendance 
    public function saveEditAttendance($data) {

        $where_in = [];

        $this->db->trans_start();

        $atts = $this->db->where('cds_att_rep_id', $data['att_id'])->get('cds_attendance');

        if ($atts->num_rows() > 0) {
            $where_in = $atts->result_array();
            $where_in = array_column($where_in, 'cds_att_att_id');
        }
        $this->db->where('cds_att_rep_id', $data['att_id'])->delete('cds_attendance');


        if (!empty($where_in)) {
            $this->db->where_in('att_id', $where_in)->delete('attendants');
        }

        $this->db->where('att_id', $data['att_id'])->delete('attendants');


        foreach ($data['shareholders'] as $key => $sh) {

            $this->db->insert('attendants', $sh['att_data']);
            $vote_status = $sh['att_data']['att_has_smartphone'] == '2' ? '2' : '1';

            $sh_attendee_id = $this->db->insert_id();
            if ($sh['is_attendee']) {
                $attendee_id = $sh_attendee_id;
            }

            if (!empty($sh['shareholder_data'])) {
                $sh['shareholder_data']['cds_att_att_id'] = $sh_attendee_id;
                $sh['shareholder_data']['cds_att_rep_id'] = $attendee_id;
                $sh['shareholder_data']['cds_att_year_id'] = $data['year_id'];
                $this->db->insert('cds_attendance', $sh['shareholder_data']);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    // Remove attendee
    public function confirmDeleteAttendee($att_id) {

        $where_in = [];

        $this->db->trans_start();

//        //$this->db->where('vote_att_id', $att_id)->delete('votes');
//        $this->db->where('cds_att_att_id', $att_id)->delete('cds_attendance');
//        $this->db->where('att_id', $att_id)->delete('attendants');

        $atts = $this->db->where('cds_att_rep_id', $att_id)->get('cds_attendance');

        if ($atts->num_rows() > 0) {
            $where_in = $atts->result_array();
            $where_in = array_column($where_in, 'cds_att_att_id');
        }
        $this->db->where('cds_att_rep_id', $att_id)->delete('cds_attendance');


        if (!empty($where_in)) {
            $this->db->where_in('att_id', $where_in)->delete('attendants');
        }

        $this->db->where('att_id', $att_id)->delete('attendants');



        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getShareholdersProxies($cond = null, $cols = null, $limit = null) {

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

            //$this->db->where('att.att_attends_as','REPRESENTATIVE');

            $res = $this->db->from('attendants att')
                    ->join("(SELECT catt.cds_att_rep_id, SUM(cds.cds_acc_shares) total_shares FROM " . $this->db->dbprefix . "cds_accounts cds, " . $this->db->dbprefix . "cds_attendance catt WHERE cds.cds_acc_number = catt.cds_att_acc_number AND catt.cds_att_type ='REPRESENTED'  GROUP BY catt.cds_att_rep_id) AS tot", "tot.cds_att_rep_id = att.att_id", "INNER")
                    ->join("(SELECT a.att_id,
					
                                cds_accounts = STUFF(
                                (SELECT  ',<br/>'+ cds.cds_att_acc_number + ' - ' + acc.cds_acc_fullname +' ('+ CONVERT(varchar(10),acc.cds_acc_shares )+')'  
                                FROM " . $this->db->dbprefix . "cds_attendance cds, " . $this->db->dbprefix . "cds_accounts acc WHERE cds.cds_att_rep_id = a.att_id AND acc.cds_acc_number = cds.cds_att_acc_number AND cds.cds_att_type = 'REPRESENTED' FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 6, '')
                                FROM " . $this->db->dbprefix . "attendants a) AS cds", 'cds.att_id = att.att_id', 'INNER')
                    ->get();
        } elseif ($this->db->dbdriver == 'mysqli') {

            //$this->db->where('att.att_attends_as','REPRESENTATIVE');

            $res = $this->db->from('attendants att')
                    ->join("(SELECT catt.cds_att_rep_id,SUM(cds.cds_acc_shares) total_shares, GROUP_CONCAT(cds.cds_acc_number,' - ',cds.cds_acc_fullname,' ','(',cds.cds_acc_shares,')' SEPARATOR ',<br/>') cds_accounts "
                            . "FROM " . $this->db->dbprefix . "cds_attendance catt," . $this->db->dbprefix . "cds_accounts cds WHERE cds.cds_acc_number = catt.cds_att_acc_number  AND catt.cds_att_type = 'REPRESENTED' GROUP BY cds_att_rep_id) AS cds", 'cds.cds_att_rep_id = att.att_id', 'INNER')
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

    //Ajax Calls
    //
    //AJAX RETRIEVING CDS ACCOUNTS

    private function _get_datatables_cds_accounts($data) {

        $this->db->select('*');

        $this->db->where(['cds_acc_year_id' => $data['year_id']])->from('cds_accounts');

        $i = 0;
        foreach ($this->cds_accounts_search_columns as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cds_accounts_search_columns) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->cds_accounts_order_columns[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->cds_accounts_default_order_columns)) {
            $order = $this->cds_accounts_default_order_columns;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_cds_accounts($data) {

        $this->_get_datatables_cds_accounts($data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_cds_accounts($data) {
        $this->_get_datatables_cds_accounts($data);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_cds_accounts($data) {

        $this->db->select('cds_acc_number');
        $this->db->where('cds_acc_year_id', $data['year_id'])->get('cds_accounts');

        return $this->db->count_all_results();
    }

    //AJAX RETRIEVING ATTENDANCE

    private function _get_datatables_attendanace($data) {


        $this->db->select($data['select_columns'])
                ->from('cds_attendance catt')
                ->join('cds_accounts cacc', 'cacc.cds_acc_number = catt.cds_att_acc_number', 'INNER')
                ->join('attendants att', 'att.att_id = catt.cds_att_att_id', 'INNER')
                ->join('attendants rep', 'rep.att_id = catt.cds_att_rep_id', 'INNER')
                ->where('catt.cds_att_year_id', $data['year_id']);

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

    function get_datatables_attendanace($data) {

        $this->_get_datatables_attendanace($data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_attendanace($data) {
        $this->_get_datatables_attendanace($data);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_attendanace($data) {

        $this->db->select('catt.cds_att_acc_number');
        $this->db->from('cds_attendance catt')
                ->join('cds_accounts cacc', 'cacc.cds_acc_number = catt.cds_att_acc_number', 'INNER')
                ->join('attendants att', 'att.att_id = catt.cds_att_att_id', 'INNER')
                ->join('attendants rep', 'rep.att_id = catt.cds_att_rep_id', 'INNER')
                ->where('catt.cds_att_year_id', $data['year_id']);

        return $this->db->count_all_results();
    }

    //AJAX FINISHES HERE
}
