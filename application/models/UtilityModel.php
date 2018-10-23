<?php

Class UtilityModel extends CI_Model {

    public function __construct() {
        
    }

    public function getOptions($tagname) {

        $this->db->where('o.option_tag_name', $tagname);
        $this->db->from('options o');
        $this->db->order_by('o.option_sequence ASC');

        $q = $this->db->get();
        return $q->result_array();
    }

    public function getSetValue($st_name) {

        $this->db->where('st_name', $st_name);
        $this->db->from('settings');
        $this->db->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row_array();
        } else {
            return FALSE;
        }
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
        $this->db->insert('sms', $msg_data);
        return $this->db->affected_rows();
    }

    public function saveTempFile($data) {

        $this->db->trans_start();

        $this->db->insert('attachment', $data['file_data']);

        $att_id = $this->db->insert_id();

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $att_id;
        }
    }

    public function getTempFile($filename) {
        $res = $this->db->where('temp_att_name', $filename)->get('tbl_temp_attachments');
        return $res->row_array();
    }

    public function getUploadedFile($file_id) {
        $res = $this->db->where('hall_attachment_id', $file_id)->get('tbl_halls_attachments');
        return $res->row_array();
    }

    public function getAttachments($cols = null, $cond = null, $limit = null, $where_in = null) {


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


        $res = $this->db->get('attachment att');



        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }

    public function getImports($cols = null, $cond = null, $limit = null, $where_in = null) {

        if ($cond !== null) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit($limit);
        }

        if ($cols != NULL) {
            $this->db->select($cols);
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

    public function removeFile($att_id) {
        $this->db->where("att_id", $att_id);
        $this->db->delete('attachment');
        return $this->db->affected_rows();
    }

    public function removeUploadedFile($file_id) {
        $this->db->where("hall_attachment_id", $file_id);
        $q = $this->db->delete('tbl_halls_attachments');
    }

    public function getUniversities($cols = NULL, $cond = NULL, $limit = NULL) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db->get('universities uni');

        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function checkIfFileAttached($token) {
        $res = $this->db->where('att_temp_token', $token)->where('att_status', 'TEMP')->get('attachments');
        return $res->result_array();
    }

    public function checkReplacementAttachments($appl_id) {
        $res = $this->db->where('att_appl_id', $appl_id)->where('att_status', 'TEMP_REPLACE')->get('attachments');
        return $res->result_array();
    }

    public function getEduLevels($cols = NULL, $cond = NULL, $limit = NULL) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db->order_by('edu_level_id')->get('edu_levels');

        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
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
                ->from('ycc_settings')
                ->order_by('st_label')
                ->get();

        return $res->result_array();
    }

    public function getSetInfo($st_id) {

        $this->db->where('st_id', $st_id);
        $this->db->from('ycc_settings');
        $this->db->limit(1);

        $q = $this->db->get();

        if ($q->num_rows() == 1) {
            return $q->row_array();
        } else {
            return FALSE;
        }
    }

    public function saveEditSt($st_data, $st_id) {

        $this->db->where('st_id', $st_id)->update('ycc_settings', $st_data);
        //log_message('ycc', $this->session->userdata['logged_in']['user_fullname'] . ' saveEditSt updated setting ' . $st_id);
        return $this->db->affected_rows();
    }

    public function saveUni($data) {
        $this->db->insert('universities', $data['uni_data']);
        return $this->db->affected_rows();
    }

    public function saveEditUni($data) {
        $this->db->where(['uni_id' => $data['uni_id']])->update('universities', $data['uni_data']);
        return $this->db->affected_rows();
    }

    public function getImportedList($cols = NULL, $cond = NULL, $limit = NULL) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }
        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db->from('students_list sl')
                ->join('universities uni', 'uni.uni_id = sl.sl_uni_id', 'INNER')
                ->get();

        if ($limit === 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit === 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
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
            $path = './uploads/imports/' . $upload['import_path'];
            //Remove Image
            if (file_exists($path)) {
                unlink($path);
            }
            $this->removeUploadedImport($upload['import_id']);
        }
    }

    public function removeUploadedImport($file_id) {
        $this->db->where("import_id", $file_id);
        $q = $this->db->delete('imports');
    }

    public function saveStudentImport($data) {

        $this->db->trans_start();

        if (!empty($data['students'])) {
            $this->db->insert_batch('students_list', $data['students']);
        }

        $this->db->where('import_id', $data['import_id'])->update('imports', $data['file_data']);

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function removeImport($upload) {

        $this->db->trans_start();

        $this->db->where('import_id', $upload['import_id'])->delete('imports');

        $this->db->where('sl_file_id', $upload['import_id'])->delete('students_list');


        $this->removeUploadedImport($upload['import_id']);

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $path = './uploads/imports/' . $upload['import_path'];
            if (file_exists($path)) {
                unlink($path);
            }
            $this->db->trans_commit();
            return true;
        }
    }

    public function confirmDeleteCollege($uni_id) {
        $this->db->where(['uni_id' => $uni_id])->delete('universities');
        return $this->db->affected_rows();
    }

    public function saveDl($data) {
        $this->db->insert('daily_logs', $data);
        return $this->db->insert_id();
    }

    private function _get_datatables_query_daily_logs($data) {

        $this->db->select($data['select_columns']);
        $this->db->from('daily_logs');

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

        //$this->db->group_by($this->applicant_group_by_columns);
    }

    function get_datatables_daily_logs($data) {

        $this->_get_datatables_query_daily_logs($data);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_daily_logs($data) {
        $this->_get_datatables_query_daily_logs($data);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_daily_logs($data) {
        $this->db->select('dl_id')->from('daily_logs');
        return $this->db->count_all_results();
    }

    public function getNacteAccademicYear() {
        return '' . ((int) date('Y') - 1) . '.' . date('Y');
    }

    public function removeAttachments($att_ids) {

        foreach ($att_ids as $id) {

            $att = $this->getAttachments(NULL, ['att_id' => $id], 1);

            switch ($att['att_type']) {
                case 'DRIVER_LICENSE':
                    $path = FCPATH . 'uploads/license/';
                    break;

                case 'MEDICAL_FITNESS':
                    $path = FCPATH . 'uploads/medical/';
                    break;
                
                case 'TRIP_REQUEST':
                    $path = FCPATH . 'uploads/request/';
                    break;

                default:
                    $att = FALSE;
                    break;
            }

            if ($att) {
                $path .= $att['att_name'];
                log_message(SYSTEM_LOG, 'Deleting path:'. $path);
                $res = $this->removeFile($att['att_id']);

                if ($res AND file_exists($path)) {
                    unlink($path);
                }
            }
        }
    }

}
