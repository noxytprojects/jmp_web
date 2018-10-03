<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Market extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('contents/view_market_status');
    }
    
    public function dashboard() {
        $this->load->view('contents/view_market_dashboard_2');
    }

    public function ajaxMarketStatus() {

        $data = [];
        $datatables = [
            'search_columns' => ['qtyb'],
            'order_columns' => ['qtyb'],
            'default_order_column' => ['qtyb' => 'ACS'],
			'trading_date' => date('Y-m-d')
        ];

        $list = $this->market->get_datatables_instruments($datatables);
		//echo '<pre>'; print_r($list);

        foreach ($list as $a) {
            $row = array();
            $qtyb = !empty($a['qtyb']) ? $a['qtyb'] : 0;
            $qtyo = !empty($a['qtyo']) ? $a['qtyo'] : 0.00;
            $offer = !empty($a['offer']) ? $a['offer'] : 0.00;
            $bid = !empty($a['bid']) ? $a['bid'] : 0;
			$lchangeo  = !empty($a['lchanges']) ? $a['lchanges'] : 0.00;
			$lchangeb  = !empty($a['lchangeb']) ? $a['lchangeb'] : 0.00;
			$market_cap = !empty($a['market_cap']) ? ($a['market_cap']/1000000000) : 0;
			
			if($lchangeo < 0){
				$lchangeo = '<span  style="font-size:12px;" class="badge badge-danger">-' .cus_price_form($lchangeo) . '</span>';
			}elseif($lchangeo > 0){
				$lchangeo = '<span  style="font-size:12px;" class="badge badge-success">+' .cus_price_form($lchangeo) . '</span>';
			}
			
			if($lchangeb < 0){
				$lchangeb = '<span  style="font-size:12px;" class="badge badge-danger">-' .cus_price_form($lchangeb) . '</span>';
			}elseif($lchangeb > 0){
				$lchangeb = '<span  style="font-size:12px;" class="badge badge-success">+' .cus_price_form($lchangeb) . '</span>';
			}

            $row[] = $a['instru_name'];
            $row[] = '<span style="font-size:12px;" class="badge badge-info">' . $qtyb . '</span>';
            $row[] = '<span  style="font-size:12px;" class="badge badge-info">' .cus_price_form($bid) . '</span>';
			$row[] = $lchangeb;
            $row[] = '<span style="font-size:12px;" class="badge badge-warning">' . cus_price_form($offer) . '</span>';
			

            $row[] = '<span  style="font-size:12px;" class="badge badge-warning">' . $qtyo . '</span>';
			$row[] = $lchangeo;
            //$row[] = !empty($a['last']) ? $a['last'] : 0.00; //$a['last'];
            //$row[] = !empty($a['lchange']) ? $a['lchange'] : 0.00; //$a['lchange'];
            $row[] = !empty($a['time']) ? date('H:i:s', strtotime($a['time'])) : "00:00:00";
            $row[] = !empty($a['high']) ? $a['high'] : 0.00; //$a['high'];
            $row[] = !empty($a['low']) ? $a['low'] : 0.00; //$a['low'];
            $row[] = !empty($a['volume']) ? $a['volume'] : 0; //$a['volume'];
            $row[] = cus_price_form_french($market_cap); //$a['market_cap'];
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->market->count_all_instruments($datatables),
            "recordsFiltered" => $this->market->count_filtered_instruments($datatables),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function marketWatch() {

        $data = [
            'menu' => 'menu/view_market_watch_menu',
            'content' => 'contents/view_market_watch',
            'menu_data' => ['curr_menu' => 'MARKET', 'curr_sub_menu' => 'MARKET'],
            'content_data' => [
                'module_name' => 'Market Watch',
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

}
