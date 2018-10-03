<?php

Class ResolutionModel extends CI_Model {

    public function saveResolution($data) {

        $res_id = null;

        $this->db->trans_start();

        $this->db->insert('resolutions', $data['res_data']);

        $res_id = $this->db->insert_id();

        if (!empty($data['choices']) AND ( $data['res_data']['res_vote_type'] == 2 OR $data['res_data']['res_vote_type'] == 3)) {

            foreach ($data['choices'] as $key => $ch) {
                $data['choices'][$key]['choice_res_id'] = $res_id;
            }

            $this->db->insert_batch('resolution_choices', $data['choices']);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        } else {

            $this->db->trans_commit();
            return $res_id;
        }
    }

    public function saveEditResolution($data) {



        $this->db->trans_start();

        $this->db->where('res_id', $data['res_id'])->update('resolutions', $data['res_data']);

        $this->db->where('choice_res_id', $data['res_id'])->delete('resolution_choices');

        if (!empty($data['choices']) AND ( $data['res_data']['res_vote_type'] == 2 OR $data['res_data']['res_vote_type'] == 3)) {

            foreach ($data['choices'] as $key => $ch) {
                $data['choices'][$key]['choice_res_id'] = $data['res_id'];
            }

            $this->db->insert_batch('resolution_choices', $data['choices']);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        } else {

            $this->db->trans_commit();
            return $data['res_id'];
        }
    }

    public function getResolutions($cond = null, $cols = null, $limit = null) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }


        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db->from('resolutions res')
                ->join('users u', 'u.usr_id = res.res_usr_id', 'INNER')
                ->join('resolution_types rt', 'rt.res_type_id = res.res_res_type_id', 'INNER')
                ->order_by('res.res_number', 'ASC')
                ->get();


        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function updateResolution($data, $cond) {

        $this->db->where($cond)->update('resolutions', $data);

        return $this->db->affected_rows();
    }

    public function initiateVoting($data) {

        $this->db->trans_start();

        if ($this->db->dbdriver == 'pdo') {
            $vote_data = $this->db->select("'" . $data['res_id'] . "' vote_res_id,'" . $data['res_vote_type'] . "' vote_type, CASE WHEN att_has_smartphone = '2' THEN '2' ELSE '1' END AS vote_status,'" . $data['year_id'] . "' vote_year_id, att_id vote_att_id, '" . date('Y-m-d H:i:s') . "' vote_timestamp")
                    ->from('attendants')
                    ->where(['att_year_id' => $data['year_id'], 'att_attends_as' => 'SHAREHOLDER'])
                    ->get();
        } elseif ($this->db->dbdriver == 'mysqli') {
            $vote_data = $this->db->select("'" . $data['res_id'] . "' vote_res_id,'" . $data['res_vote_type'] . "' vote_type, if(att_has_smartphone = '2','2','1') vote_status,'" . $data['year_id'] . "' vote_year_id, att_id vote_att_id, '" . date('Y-m-d H:i:s') . "' vote_timestamp")
                    ->from('attendants')
                    ->where(['att_year_id' => $data['year_id'], 'att_attends_as' => 'SHAREHOLDER'])
                    ->get();
        }

        $vote_data = $vote_data->result_array();

        if ($data['res_max_selection'] > 0) {
            for ($i = 0; $i < $data['res_max_selection']; $i++) {

                foreach ($vote_data as $key => $vd) {
                    $vote_data[$key]['vote_selection'] = $i + 1;
                }
                //echo '<pre>';print_r($vote_data);die();


                $this->db->insert_batch('votes', $vote_data);
            }
        } else {
            foreach ($vote_data as $key => $vd) {
                $vote_data[$key]['vote_selection'] = 1;
            }
            $this->db->insert_batch('votes', $vote_data);
        }


        $this->db->set(['res_status' => 'RUNNING'])->where('res_id', $data['res_id'])->update('resolutions');

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function completeVoting($data) {

        $this->db->trans_start();

        //$this->db->where(['vote_res_id' => $data['res_id'], 'vote_status' => '2'])->update('votes', ['vote_status' => '4']);
        $this->db->where(['vote_res_id' => $data['res_id']])->where('vote_answer IS NULL')->update('votes', ['vote_answer' => 'N/A']);
        $this->db->set(['res_status' => 'COMPLETED'])->where('res_id', $data['res_id'])->update('resolutions');

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function getResolutionChoices($cond = null, $cols = null, $limit = null) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db->from('resolution_choices rc')
                ->join('resolutions res', 'res.res_id = rc.choice_res_id', 'INNER')
                ->order_by('rc.choice_letter', 'ACS')
                ->get();


        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function getResVotingResult($cond = null, $cols = null, $limit = null) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db->select("res_id , vote_status, vote_answer, SUM(cds_acc_shares) as shares")
                ->from("agm_cds_attendance")
                ->join("agm_attendants", "att_id = cds_att_att_id", 'INNER')
                ->join("agm_votes", "vote_att_id = att_id", "INNER")
                ->join("agm_resolutions", "vote_res_id = res_id", "INNER")
                ->join("agm_cds_accounts", "cds_acc_number = cds_att_acc_number", "INNER")
                ->group_by('vote_answer, vote_status, res_id')
                ->get();

        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function getResVotingAttCount($res_id) {

        $this->db->select('COUNT(*) attendees');

        if ($this->db->dbdriver == 'mysqli') {
            $this->db->select(
                    "SUM(if(att.att_has_smartphone = 0 AND v.vote_status IN ('3','4'),1,0)) sms_attendees_votes,
                    SUM(if(att.att_has_smartphone = 0,1,0)) sms_attendees,
                    SUM(if(att.att_has_smartphone = 1 AND v.vote_status IN ('3','4'),1,0)) web_attendees_votes,
                    SUM(if(att.att_has_smartphone = 1,1,0)) web_attendees,
                    SUM(if(att.att_has_smartphone = 2 AND v.vote_status IN ('3','4'),1,0)) manual_attendees_votes,SUM(if(att.att_has_smartphone = 2,1,0)) manual_attendees");
        } elseif ($this->db->dbdriver == 'pdo') {
            
            $this->db->select(
                "SUM( CASE WHEN att.att_has_smartphone = 0 AND v.vote_status IN ('3','4') THEN 1 ELSE 0 END) AS sms_attendees_votes,
                 SUM( CASE WHEN att.att_has_smartphone = 0 THEN 1 ELSE 0 END) sms_attendees,
                 SUM( CASE WHEN att.att_has_smartphone = 1 AND v.vote_status IN ('3','4') THEN 1 ELSE 0 END) AS web_attendees_votes,
                 SUM( CASE WHEN att.att_has_smartphone = 1 THEN 1 ELSE 0 END) web_attendees,
                 SUM( CASE WHEN att.att_has_smartphone = 2 AND v.vote_status IN ('3','4') THEN 1 ELSE 0 END) AS manual_attendees_votes,SUM( CASE WHEN att.att_has_smartphone = 2 THEN 1 ELSE 0 END) manual_attendees");
        }

        $this->db->from("agm_votes v,agm_attendants att");
        $this->db->where('v.vote_att_id = att.att_id');
        $this->db->where(["v.vote_res_id" => $res_id]);
        $this->db->limit(1);
        $res = $this->db->group_by("v.vote_res_id,v.vote_type")->get();

        if ($res->num_rows() == 1) {
            return $res->row_array();
        } else {
            return FALSE;
        }



        //        $q="SELECT 
        //
            //COUNT(*) attendees,
        //
            //SUM(if(att.att_has_smartphone = 0 AND v.vote_status IN ('3','4'),1,0)) sms_attendees_votes,
        //SUM(if(att.att_has_smartphone = 0,1,0)) sms_attendees,
        //
            //SUM(if(att.att_has_smartphone = 1 AND v.vote_status IN ('3','4'),1,0)) web_attendees_votes,
        //SUM(if(att.att_has_smartphone = 1,1,0)) web_attendees,
        //
            //SUM(if(att.att_has_smartphone = 2 AND v.vote_status IN ('3','4'),1,0)) manual_attendees_votes,
        //SUM(if(att.att_has_smartphone = 2,1,0)) manual_attendees
        //
            //FROM agm_votes v,agm_attendants att 
        //
            //WHERE v.vote_att_id = att.att_id AND v.vote_res_id = '1' 
        //
            //GROUP BY v.vote_res_id";
    }

    public function getResolutionToVote($att_id) {


        $res = $this->db->from('resolutions res')
                ->join('votes v', 'v.vote_res_id = res.res_id')
                ->where(['v.vote_att_id' => $att_id, 'vote_status' => 2])->where('vote_answer IS NULL')
                ->limit(1)
                ->get();

        if ($res->num_rows() == 1) {
            return $res->row_array();
        }
    }

    public function updateVote($data) {

        $this->db->trans_start();

        foreach ($data['voting_data'] as $key => $vd) {

            $this->db->where(['vote_res_id' => $vd['res_id'], 'vote_att_id' => $vd['att_id'], 'vote_selection' => $vd['selection']])
                    ->where("(vote_answer = 'N/A' OR vote_answer IS NULL )")
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


        return $this->db->affected_rows();
    }

    public function getResolutionTypes($cond = null, $cols = null, $limit = null) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db->order_by('res_type_sequence')->get('resolution_types');

        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }

        $res = $this->db->order_by('res_type_sequence')->get('resolution_types');
        return $res->result_array();
    }

    public function getNextResolutionNumber($year_id) {
        $res = $this->db->where('res_year_id', $year_id)->get('resolutions');

        return 1 + (int) $res->num_rows();
    }

    public function getManaualVotingResolutions($cond = null, $cols = null, $limit = null) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        } else {
            $cols = ['res.res_id', 'res.res_vote_type', 'res.res_sms_en', 'res.res_number', 'res.res_max_selection'];
            $this->db->select($cols);
            $this->db->group_by($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }


        $res = $this->db->from('resolutions res')
                ->join('resolution_types rt', 'rt.res_type_id = res.res_res_type_id', 'INNER')
                ->join('votes v', "v.vote_res_id = res.res_id", 'INNER')
                ->where("(v.vote_answer IN ('N/A') OR v.vote_answer IS NULL) AND v.vote_status = '2' ")
                ->get();

        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function getEditManaualVotingResolutions($cond = null, $cols = null, $limit = null) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        } else {
            $cols = ['res.res_id', 'res.res_vote_type', 'res.res_sms_en', 'res.res_number', 'res.res_max_selection'];
            $this->db->select($cols);

            if ($this->db->dbdriver == 'pdo') {
                $this->db->select("vote_answer = STUFF(( SELECT ',' + v.vote_answer 
														FROM " . $this->db->dbprefix . "votes v 
														WHERE v.vote_res_id = res.res_id AND v.vote_att_id = '" . $cond['v.vote_att_id'] . "'
														FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 1, '')"
                );
            } elseif ($this->db->dbdriver == 'mysqli') {
                $this->db->select('GROUP_CONCAT(v.vote_answer) vote_answer');
            }

            $this->db->group_by($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db->from('resolutions res')
                ->join('resolution_types rt', 'rt.res_type_id = res.res_res_type_id', 'INNER')
                ->join('votes v', "v.vote_res_id = res.res_id", 'INNER')
                ->where("(v.vote_answer IS NOT NULL) AND v.vote_status = '3' AND v.vote_channel = 'MANUAL' ")
                ->get();

        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function saveResolutionCategory($cat_data) {

        $this->db->trans_start();
        $this->db->trans_strict(FALSE);

        $this->db->insert('resolution_types', $cat_data);
        $res_cat_id = $this->db->insert_id();
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            //log_message('ycc', $this->session->userdata['logged_in']['user_fullname'] . ' saveUserDetails Failed to Add User');
            return FALSE;
        } else {

            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            // log_message('ycc', $this->session->userdata['logged_in']['user_fullname'] . ' saveUserDetails - ID: ' . $user_id . ' User Added Successfully');
            return $res_cat_id;
        }
    }

    public function deleteResolutionCategory($res_type_id) {

        $this->db->where('res_type_id', $res_type_id)->delete('resolution_types');

        return $this->db->affected_rows();
    }

}
