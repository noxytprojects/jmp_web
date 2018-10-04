<?php

Class MaintenanceModel extends CI_Model {


    public function __construct() {
        parent::__construct();
    }
    
    // For ajax calls
    private function _select_depts($data) {
        
        $this->db->select($data['select_columns'])
                ->from('department dept');
        
        if ($data['where_in'] != NULL) {
            foreach ($data['where_in'] as $key => $wn) {
                $this->db->where_in($key, $wn);
            }
        }
        
        if(null !== $data['cond']){
            $this->db->where($data['cond']);
        }
        
    }

    private function _get_datatables_depts($data) {
        
        $this->_select_depts($data);
        
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

    function get_datatables_depts($data) {

        $this->_get_datatables_depts($data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_depts($data) {
        $this->_get_datatables_depts($data);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_depts($data) {
        $this->_select_depts($data);
        return $this->db->count_all_results();
    }
    
    public function getSections($cols = null, $cond = null, $limit = null, $where_in = null) {

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


        $res = $this->db->from('section sec')
                ->join('department dept','dept.dept_id = sec.sec_dept_id','INNER')->get();
        

        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }
    public function getDepartments($cols = null, $cond = null, $limit = null, $where_in = null) {

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


        $res = $this->db->from('department dept')->get();
        

        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }
    
    
    public function saveDepartment($data) {
        $this->db->trans_start();
        $this->db->insert('department', $data['dept_data']);
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    
    public function deleteDept($dept_id) {
        $this->db->where('dept_id',$dept_id)->delete('department');
        return $this->db->affected_rows();
    }
    
    public function saveEditDepartment($data,$dept_id) {
        $this->db->where('dept_id',$dept_id)->update('department',$data['dept_data']);
        return $this->db->affected_rows();
    }
}
