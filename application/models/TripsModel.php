<?php

Class TripsModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Ajax retrieve trips starts here

    private function _select_trips($data) {

        $this->db->select($data['select_columns'])
                ->from('trip_request tr')
                ->join('drivers_profile dp', 'dp_ad_name = tr_ad_name', 'INNER')
                ->join('approval ap', 'ap.ap_tr_id = tr.tr_id', 'LEFT OUTER');

        if ($data['where_in'] != NULL) {
            foreach ($data['where_in'] as $key => $wn) {
                $this->db->where_in($key, $wn);
            }
        }

        if (null !== $data['cond']) {
            $this->db->where($data['cond']);
        }
    }

    private function _get_datatables_trips($data) {

        $this->_select_trips($data);

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

    function get_datatables_trips($data) {

        $this->_get_datatables_trips($data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_trips($data) {
        $this->_get_datatables_trips($data);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_trips($data) {
        $this->_select_trips($data);
        return $this->db->count_all_results();
    }

    // Ajax retrieve trips ends here

    public function saveTrip($data) {

        $this->db->trans_start();

        switch ($data['mode']) {

            // edit request
            case 'edit':
                $this->db->where('tr_id', $data['tr_id'])->update('trip_request', $data['trip_data']);
                $tr_id = $data['tr_id'];
                break;
                ;

            //Add new request
            case 'add':
                $this->db->insert('trip_request', $data['trip_data']);
                $tr_id = $this->db->insert_id();
                $this->db->where('att_type','TRIP_REQUEST')->where('att_ref IS NULL')->where('att_status','0')->update('attachment',['att_ref' =>$tr_id,'att_status'=> '1']);
                break;
            
            default :
                $tr_id = false;
                break;
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $tr_id;
        }
    }

    public function getTripRequests($cols = null, $cond = null, $limit = null, $where_in = null) {


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

        $res = $this->db->from('trip_request tr')
                        ->join('drivers_profile dp', 'dp_ad_name = tr_ad_name', 'INNER')
                        ->join('department dept', 'dept.dept_id = dp.dp_dept_id')
                        ->join('section sec', 'sec.sec_id = dp.dp_section_id')
                        ->join('approval ap', 'ap.ap_tr_id = tr.tr_id', 'LEFT OUTER')->get();

        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }

}
