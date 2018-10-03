<?php

Class MarketModel extends CI_Model {

    private function _get_datatables_instruments($data) {

        $this->db->select('inst.instru_contract,inst.instru_name,td_b.qtyb,td_b.bid,td_s.qtyo,td_s.offer, time, high, low,last, lchange,volume,lchanges,lchangeb, market_cap');
        $this->db->from('instrument inst')
                ->join("(SELECT td_change lchangeb,td_contract_name td_contract_b, td_last_qty qtyb,td_last_dealt_price bid FROM ".$this->db->dbprefix."trading_data td "
                        . "INNER JOIN (SELECT td_contract_name td_contract_1, MAX(td_id) td_last_dealt_time_b "
                                    . "FROM ".$this->db->dbprefix."trading_data WHERE CONVERT(date,td_update_time) = '".$data['trading_date']."' AND td_last_action = 'BUY'"
                                    . "GROUP By td_contract_name) last_td "
                        . "ON td.td_contract_name = last_td.td_contract_1 AND td.td_id = last_td.td_last_dealt_time_b) td_b", "td_b.td_contract_b = inst.instru_contract","LEFT OUTER")
                
                
                ->join("(SELECT td_change lchanges, td_contract_name td_contract_s, td_last_qty qtyo,td_last_dealt_price offer FROM ".$this->db->dbprefix."trading_data td "
                        . "INNER JOIN (SELECT td_contract_name td_contract_2, MAX(td_id) td_last_dealt_time_s "
                                    . "FROM ".$this->db->dbprefix."trading_data WHERE CONVERT(date,td_update_time) = '".$data['trading_date']."' AND td_last_action = 'SELL'"
                                    . "GROUP By td_contract_name) last_td "
                        . "ON td.td_contract_name = last_td.td_contract_2 AND td.td_id = last_td.td_last_dealt_time_s) td_s", "td_s.td_contract_s = inst.instru_contract","LEFT OUTER")
                
                
                ->join("(SELECT td_market_cap market_cap, td_day_volume volume,td_change lchange, td_update_time time,td_last_traded_qty last,td_high_price high,td_low_price low,td_contract_name td_contract_a FROM ".$this->db->dbprefix."trading_data td "
                        . "INNER JOIN (SELECT td_contract_name td_contract_3, MAX(td_id) td_last_dealt_time_a "
                                    . "FROM ".$this->db->dbprefix."trading_data WHERE CONVERT(date,td_update_time) = '".$data['trading_date']."'"
                                    . "GROUP By td_contract_name) last_td "
                        . "ON td.td_contract_name = last_td.td_contract_3 AND td.td_id = last_td.td_last_dealt_time_a) td_a", "td_a.td_contract_a = inst.instru_contract","LEFT OUTER");
						//$this->db->where('inst.instru_show','1');
						
						$this->db->order_by('td_b.qtyb','DESC');
						$this->db->order_by('td_s.qtyo','DESC');
						
					
        
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

    function get_datatables_instruments($data) {

        $this->_get_datatables_instruments($data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result_array();
    }

    function count_filtered_instruments($data) {
        $this->_get_datatables_instruments($data);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_instruments($data) {

        $this->db->select('instru_contract');
        $this->db->get('instrument');

        return $this->db->count_all_results();
    }

}
