<?php

Class UtilityModel extends CI_Model {

    var $outgoing_sms_search_columns = ['MessageTo', 'MessageFrom', 'MessageText'];
    var $outgoing_sms_order_columns = ['Id', null, null, null, null];
    var $outgoing_sms_default_order_columns = ['Id' => 'DESC'];
    var $smsdb = null;

    public function __construct() {
        $this->smsdb = $this->load->database('db2', TRUE);
    }

    public function getOptions($tagname) {

        $this->db->where('o.option_tag_name', $tagname);
        $this->db->from('options o');
        $this->db->order_by('o.option_sequence ASC');

        $q = $this->db->get();
        return $q->result_array();
    }

    public function savetempFile($data, $upfile, $type = 'TEMP') {

        switch ($type) {
            case 'IMPORT':
                $data['file_data']['cds_upload_file_path'] = $upfile;
                $this->db->insert('cds_uploads', $data['file_data']);
                break;
        }
        return $this->db->insert_id();
    }

    public function getTempFile($co) {
        $res = $this->db->where('temp_att_name', $filename)->get('tbl_temp_attachments');
        return $res->row_array();
    }

    public function getUploadedFile($file_id) {
        $res = $this->db->where('hall_attachment_id', $file_id)->get('tbl_halls_attachments');
        return $res->row_array();
    }

    public function getAttachments($cond = null, $limit = null, $where_in = null) {

        if ($cond !== null) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit($limit);
        }

        if ($where_in !== NULL) {
            $this->db->where_in($where_in);
        }

        $q = $this->db->get('ycc_attachments');

        if ($limit == 1 AND $q->num_rows() == 1) {
            return $q->row_array();
        } elseif ($limit == 1 AND $q->num_rows() < 1) {
            return FALSE;
        } else {
            return $q->result_array();
        }
    }

    public function getImports($cond = null, $limit = null, $where_in = null) {

        if ($cond !== null) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit($limit);
        }

        if ($where_in !== NULL) {
            $this->db->where_in('import_id', $where_in);
        }

        $q = $this->db->get('imports');

        if ($limit == 1 AND $q->num_rows() == 1) {
            return $q->row_array();
        } elseif ($limit == 1 AND $q->num_rows() < 1) {
            return FALSE;
        } else {
            return $q->result_array();
        }
    }

    public function removeFile($filename) {
        $this->db->where("att_name", $filename);
        $q = $this->db->delete('attachments');
    }

    public function removeUploadedFile($file_id) {
        $this->db->where("hall_attachment_id", $file_id);
        $q = $this->db->delete('tbl_halls_attachments');
    }

    public function getUniversities() {
        $res = $this->db->get('universities');
        return $res->result_array();
    }

    public function checkIfFileAttached($token) {
        $res = $this->db->where('att_temp_token', $token)->where('att_status', 'TEMP')->get('attachments');
        return $res->result_array();
    }

    public function checkReplacementAttachments($appl_id) {
        $res = $this->db->where('att_appl_id', $appl_id)->where('att_status', 'TEMP_REPLACE')->get('attachments');
        return $res->result_array();
    }

    public function getEduLevels() {
        $res = $this->db->order_by('edu_level_id')->get('edu_levels');
        return $res->result_array();
    }

    public function clearFilterSessions() {
        if (isset($this->session->userdata['filter_applications_rpt'])) {
            $this->session->unset_userdata('filter_applications_rpt');
        }
        if (isset($this->session->userdata['filter_university_summary_rpt'])) {
            $this->session->unset_userdata['filter_university_summary_rpt'];
        }
    }

    public function getSetList($cond = null) {

        if (!empty($cond)) {
            $this->db->where($cond);
        }
        $res = $this->db
                ->from('settings')
                ->order_by('st_label')
                ->get();

        return $res->result_array();
    }

    public function getMeetingYears($cond = null, $limit = null) {

        if (null !== $cond) {
            $this->db->where($cond);
        }

        if (NULL !== $limit) {
            $this->db->limit($limit);
        }

        $res = $this->db->from('years')->order_by('year_name', 'desc')->get();

        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function updateMeetingYear($data, $year_id) {

        $this->db->trans_start();

        $this->db->where('year_id', $year_id)->update('years', $data);
        $this->db->where(['vote_answer' => 'N/A', 'vote_status' => '2'])->update('votes', ['vote_status' => '4']);

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getSetInfo($st_id) {

        $this->db->where('st_id', $st_id);
        $this->db->from('settings');
        $this->db->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row_array();
        } else {
            return FALSE;
        }
    }

    public function getSetValue($st_name) {

        $this->db->where('st_name', $st_name);
        $this->db->from('settings');
        $this->db->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            $st = $q->row_array();
            return $st['st_value'];
        } else {
            return NULL;
        }
    }

    public function saveEditSt($st_data, $st_id) {

        $this->db->where('st_id', $st_id)->update('settings', $st_data);
        log_message(SYSTEM_LOG, $this->session->userdata['logged_in']['user_fullname'] . ' saveEditSt updated setting ' . $st_id);
        return $this->db->affected_rows();
    }

    public function getImportedList() {
        $res = $this->db->from('students_list s')
                ->join('universities uni', 'uni.uni_id = s.sl_uni_id', 'INNER')
                ->get();

        return $res->result_array();
    }

    public function getImportedFiles() {
        $res = $this->db->from('imports i')
                ->join('users u', 'u.usr_id = i.import_user_id', 'INNER')
                ->join('universities uni', 'uni.uni_id = i.import_uni_id', 'INNER')
                ->order_by('i.import_timestamp')
                ->get();

        return $res->result_array();
    }

    public function removeTempImports($uploads) {
        foreach ($uploads as $key => $upload) {
            $path = './uploads/imports/' . $upload['cds_upload_file_path'];
            //Remove Image
            if (file_exists($path)) {
                unlink($path);
            }
            $this->removeUploadedImport($upload['cds_upload_id']);
        }
    }

    public function removeUploadedImport($file_id) {
        $this->db->where("cds_upload_id", $file_id);
        $q = $this->db->delete('cds_uploads');
    }

    public function removeImport($upload, $year_id) {

        $total_shares = 0;

        $this->db->trans_start();

        $this->db->where('cds_acc_upload_id', $upload['cds_upload_id'])->delete('cds_accounts');

        $res = $this->db->select('cds_acc_year_id, SUM(cds_acc_shares) total_shares')
                ->where('cds_acc_year_id', $year_id)
                ->group_by('cds_acc_year_id')
                ->get('cds_accounts');

        if ($res->num_rows() == 1) {
            $res = $res->row_array();
            $total_shares = $res['total_shares'];
        }

        $this->db->set('year_total_share', $total_shares)
                ->where('year_id', $year_id)
                ->update('years');

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $path = './uploads/imports/' . $upload['cds_upload_file_path'];
            if (file_exists($path)) {
                unlink($path);
            }
            $this->removeUploadedImport($upload['cds_upload_id']);
            $this->db->trans_commit();
            return true;
        }
    }

    public function reSendSms($id) {

        $this->smsdb->where('Id', $id)->update('MessageOut', ['IsSent' => 0]);
        return $this->smsdb->affected_rows();
    }

    //Ajax Calls
    //AJAX RETRIEVING OUTGOING SMSs

    private function _get_datatables_outgoing_sms($data) {

        $this->smsdb->select('*');
        $this->smsdb->from('MessageOut');
        //$this->db->where(['cds_acc_year_id' => $data['year_id']])->from('cds_accounts');

        $i = 0;
        foreach ($this->outgoing_sms_search_columns as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->smsdb->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->smsdb->like($item, $_POST['search']['value']);
                } else {
                    $this->smsdb->or_like($item, $_POST['search']['value']);
                }

                if (count($this->outgoing_sms_search_columns) - 1 == $i) //last loop
                    $this->smsdb->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->smsdb->order_by($this->outgoing_sms_order_columns[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->outgoing_sms_default_order_columns)) {
            $order = $this->outgoing_sms_default_order_columns;
            $this->smsdb->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_outgoing_sms($data) {

        $this->_get_datatables_outgoing_sms($data);
        if ($_POST['length'] != -1)
            $this->smsdb->limit($_POST['length'], $_POST['start']);

        $query = $this->smsdb->get();
        return $query->result();
    }

    function count_filtered_outgoing_sms($data) {
        $this->_get_datatables_outgoing_sms($data);
        $query = $this->smsdb->get();
        return $query->num_rows();
    }

    public function count_all_outgoing_sms($data) {
        $this->smsdb->select('Id');
        $this->smsdb->from('MessageOut');
        return $this->smsdb->count_all_results();
    }
    
    public function saveYear($data) {
        $this->db->insert('years',$data['year_data']);
        return $this->db->insert_id();
    }
    
    public function getSMSFormat($msg_tag) {
        
        $this->db->where('ws_key', $msg_tag);
        $this->db->from('smscontent');
        $this->db->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            $res = $q->row_array();
            return $res['ws_format'];
        } else {
            return 'Something went wrong. Contact Your System Admin';
        }
        
    }
    
    public function saveMessage($msg_data) {
        $this->smsdb->insert('MessageOut',$msg_data);
        return $this->smsdb->affected_rows();
    }

    // AJAX FINISHES
}
