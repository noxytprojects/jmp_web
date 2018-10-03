<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Voting extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_manual_sh_list',
            'menu_data' => ['curr_menu' => 'VOTING', 'curr_sub_menu' => 'VOTING'],
            'content_data' => [
                'module_name' => 'Manual Voting - Manual Attendees List'
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function manualVotingForWebAndSms() {
        
        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_manual_sh_list_web_sms',
            'menu_data' => ['curr_menu' => 'VOTING', 'curr_sub_menu' => 'VOTING'],
            'content_data' => [
                'module_name' => 'Manual Voting - SMS And Web Attendees'
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function ajaxManualVottingAttendees() {

        if (!$this->usr->is_logged_in) {

            echo json_encode([
                "draw" => $_POST['draw'],
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
                    ]
            );
            die();
        }

        $datatalbe = [
            'search_columns' => ['att.att_fullname', 'att.att_phone_number'],
            'default_order_column' => ['att.att_fullname' => 'ACS'],
            'order_columns' => [NULL, NULL, 'att.att_fullname', NULL, NULL],
            'att_has_smartphone_in' => ['2']
        ];

        $data = [];
        $list = $this->voting->get_datatables_manual_voting_attendees($datatalbe);
        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $a->cds_accounts;
            $row[] = $a->att_fullname;
            $row[] = $a->att_phone_number;
            $row[] = $a->att_address;
            $row[] = '<a href="' . site_url('voting/manualvoting/' . $a->att_id) . '" class="btn btn-sm btn-outline-success"><i class="fa fa-check-circle-o"></i>&nbsp;VOTE</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->voting->count_all_manual_voting_attendees($datatalbe),
            "recordsFiltered" => $this->voting->count_all_manual_voting_attendees($datatalbe),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }
    
    public function ajaxManualVottingAttendeesWebSms() {

        if (!$this->usr->is_logged_in) {

            echo json_encode([
                "draw" => $_POST['draw'],
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
                    ]
            );
            die();
        }

        $datatalbe = [
            'search_columns' => ['att.att_fullname', 'att.att_phone_number'],
            'default_order_column' => ['att.att_fullname' => 'ACS'],
            'order_columns' => [NULL, NULL, 'att.att_fullname', NULL, NULL],
            'att_has_smartphone_in' => ['1','0']
        ];

        $data = [];
        $list = $this->voting->get_datatables_manual_voting_attendees($datatalbe);
        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $a->cds_accounts;
            $row[] = $a->att_fullname;
            $row[] = $a->att_phone_number;
            $row[] = $a->att_address;
            $row[] = '<a href="' . site_url('voting/manualvoting/' . $a->att_id) . '" class="btn btn-sm btn-outline-success"><i class="fa fa-check-circle-o"></i>&nbsp;VOTE</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->voting->count_all_manual_voting_attendees($datatalbe),
            "recordsFiltered" => $this->voting->count_all_manual_voting_attendees($datatalbe),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function edit() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $atts = $this->shareholder->getEditManaualVotingAttendees(['att_year_id' => $this->usr->year_id]);

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_edit_manual_sh_list',
            'menu_data' => ['curr_menu' => 'VOTING', 'curr_sub_menu' => 'VOTING'],
            'content_data' => [
                'module_name' => 'Edit Manual Voting',
                'atts' => $atts,
                'type'=>'manual'
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }
    
    public function editWebSms() {
        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $atts = $this->shareholder->getEditManaualVotingAttendees(['att_year_id' => $this->usr->year_id,'att_status <>' =>'2']);

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_edit_manual_sh_list',
            'menu_data' => ['curr_menu' => 'VOTING', 'curr_sub_menu' => 'VOTING'],
            'content_data' => [
                'module_name' => 'Edit Manual Votes - Web & SMS Attendees List',
                'atts' => $atts,
                'type' =>'websms'
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function manualVoting() {


        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $att_id = $this->uri->segment(3);

        //$att = $this->shareholder->getAttendace(NULL, ['att.att_id' => $att_id], 1);

        $att = $this->shareholder->getManaualVotingAttendees(['att.att_year_id' => $this->usr->year_id, 'att.att_id' => $att_id], NULL, 1);

        if (!$att) {
            $this->usr->setSessMsg('Attendee may have already been voted for all resolutions', 'error', 'voting');
        }

        $ress = $this->resolution->getManaualVotingResolutions(['v.vote_att_id' => $att['att_id']]);

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_manual_voting',
            'menu_data' => ['curr_menu' => 'VOTING', 'curr_sub_menu' => 'VOTING'],
            'content_data' => [
                'module_name' => 'Manual Voting',
                'ress' => $ress,
                'att_id' => $att_id,
                'att' => $att,
                'res_types' => $this->resolution->getResolutionTypes(),
                'res_choices' => $this->resolution->getResolutionChoices(['res.res_year_id' => $this->usr->year_id], NULL)
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function editManualVoting() {


        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $att_id = $this->uri->segment(3);

        //$att = $this->shareholder->getAttendace(NULL, ['att.att_id' => $att_id], 1);

        $att = $this->shareholder->getEditManaualVotingAttendees(['att.att_year_id' => $this->usr->year_id, 'att.att_id' => $att_id], NULL, 1);

        if (!$att) {
            $this->usr->setSessMsg('Attendee may have already been voted for all resolutions', 'error', 'voting');
        }

        $ress = $this->resolution->getEditManaualVotingResolutions(['v.vote_att_id' => $att['att_id']]);

        //echo '<pre>'; print_r($ress); die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_edit_manual_voting',
            'menu_data' => ['curr_menu' => 'VOTING', 'curr_sub_menu' => 'VOTING'],
            'content_data' => [
                'module_name' => 'Edit Manual Voting',
                'ress' => $ress,
                'att_id' => $att_id,
                'att' => $att,
                'res_types' => $this->resolution->getResolutionTypes(),
                'res_choices' => $this->resolution->getResolutionChoices(['res.res_year_id' => $this->usr->year_id], NULL)
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function submitManualVoting() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your session might have been expired. Please refresh the page');
        }

        $att_id = $this->uri->segment(3);

        $cols = ['att.att_id'];
        $att = $this->shareholder->getAttendace($cols, ['att.att_id' => $att_id], 1);

        if (!$att) {
            cus_json_error('Attendee was not found or may have been removed from the system');
        }

        $ress = $this->resolution->getManaualVotingResolutions(['v.vote_att_id' => $att['att_id']]);

        if (empty($ress)) {
            cus_json_error('Selected attendee has no resolution to vote');
        }

        if (!$this->usr->yearIsActive($this->usr->year_id)) {
            cus_json_error('Request can not be processed because resolution year is CLOSED');
        }

        $validations = [];

        foreach ($ress as $key => $res) {

            if ($res['res_vote_type'] == '3') {
                $validations[] = ['field' => 'answer_' . $res['res_id'] . '[]', 'label' => 'Answer', 'rules' => 'trim|callback_validateMultipleSelection[' . $res['res_id'] . ']', 'errors' => ['required' => 'You should select one option from above.']];
            } else {
                $validations[] = ['field' => 'answer_' . $res['res_id'], 'label' => 'Answer', 'rules' => 'trim|required', 'errors' => ['required' => 'You should select one option from above.']];
            }
        }


        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {

            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'display',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            die();
        } else {

            $voting_data = [];

            foreach ($ress as $key => $res) {

                if ($res['res_vote_type'] == '3') {

                    $selections = $this->input->post('answer_' . $res['res_id'] . '[]');

                    foreach ($selections as $key => $s) {
                        $voting_data[] = [
                            'res_id' => $res['res_id'],
                            'att_id' => $att['att_id'],
                            'selection' => $key + 1,
                            'answer_data' => [
                                'vote_answer' => $s,
                                'vote_channel' => 'MANUAL',
                                'vote_status' => 3,
                                'vote_timestamp' => date('Y-m-d H:i:s')
                            ]
                        ];
                    }
                } else {

                    $voting_data[] = [
                        'res_id' => $res['res_id'],
                        'att_id' => $att['att_id'],
                        'selection' => 1,
                        'answer_data' => [
                            'vote_answer' => $this->input->post('answer_' . $res['res_id']),
                            'vote_channel' => 'MANUAL',
                            'vote_status' => 3,
                            'vote_timestamp' => date('Y-m-d H:i:s')
                        ]
                    ];
                }
            }

            //echo '<pre>';            print_r($voting_data);            die();

            $res = $this->voting->saveManualVoting(['voting_data' => $voting_data], "(vote_answer = 'N/A' OR vote_answer IS NULL )");

            if ($res) {

                log_message(SYSTEM_LOG, 'voting/submitManualVoting - ' . $this->usr->user_email . ' -> '.$this->input->ip_address().'manualy votted for attendee. att_id : ' . $att['att_id']);
                $this->session->set_flashdata('success', 'Voting submitted successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => TRUE,
                        'redirect_url' => site_url('voting')
                    ]
                ]);
                die();
            } else {
                cus_json_error('Something went wrong. Voting failed.');
            }
        }
    }

    public function submitEditManualVoting() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your session might have been expired. Please refresh the page');
        }

        $att_id = $this->uri->segment(3);

        $cols = ['att.att_id'];
        $att = $this->shareholder->getAttendace($cols, ['att.att_id' => $att_id], 1);

        if (!$att) {
            cus_json_error('Attendee was not found or may have been removed from the system');
        }

        $ress = $this->resolution->getEditManaualVotingResolutions(['v.vote_att_id' => $att['att_id']]);

        if (empty($ress)) {
            cus_json_error('Selected attendee has no manual resolution votes to be edited');
        }

        if (!$this->usr->yearIsActive($this->usr->year_id)) {
            cus_json_error('Request can not be processed because resolution year is CLOSED');
        }

        $validations = [];

        foreach ($ress as $key => $res) {

            if ($res['res_vote_type'] == '3') {
                $validations[] = ['field' => 'answer_' . $res['res_id'] . '[]', 'label' => 'Answer', 'rules' => 'trim|callback_validateMultipleSelection[' . $res['res_id'] . ']', 'errors' => ['required' => 'You should select one option from above.']];
            } else {
                $validations[] = ['field' => 'answer_' . $res['res_id'], 'label' => 'Answer', 'rules' => 'trim|required', 'errors' => ['required' => 'You should select one option from above.']];
            }
        }


        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {

            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'display',
                    "form_errors" => validation_errors_array()
                ]
            ]);

            die();
        } else {

            $voting_data = [];

            foreach ($ress as $key => $res) {

                if ($res['res_vote_type'] == '3') {

                    $selections = $this->input->post('answer_' . $res['res_id'] . '[]');

                    foreach ($selections as $key => $s) {
                        $voting_data[] = [
                            'res_id' => $res['res_id'],
                            'att_id' => $att['att_id'],
                            'selection' => $key + 1,
                            'answer_data' => [
                                'vote_answer' => $s,
                                'vote_channel' => 'MANUAL',
                                'vote_status' => 3,
                                'vote_timestamp' => date('Y-m-d H:i:s')
                            ]
                        ];
                    }
                } else {

                    $voting_data[] = [
                        'res_id' => $res['res_id'],
                        'att_id' => $att['att_id'],
                        'selection' => 1,
                        'answer_data' => [
                            'vote_answer' => $this->input->post('answer_' . $res['res_id']),
                            'vote_channel' => 'MANUAL',
                            'vote_status' => 3,
                            'vote_timestamp' => date('Y-m-d H:i:s')
                        ]
                    ];
                }
            }

            $res = $this->voting->saveManualVoting(['voting_data' => $voting_data], "(vote_channel = 'MANUAL' AND vote_status = '3')");

            if ($res) {

                log_message(SYSTEM_LOG, 'voting/submitManualVoting - ' . $this->usr->user_email . ' -> '.$this->input->ip_address().'manualy votted for attendee. att_id : ' . $att['att_id']);
                $this->session->set_flashdata('success', 'Changes submitted successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => TRUE,
                        'redirect_url' => site_url('voting/edit')
                    ]
                ]);
                die();
            } else {
                cus_json_error('Something went wrong. Changes was not saved.');
            }
        }
    }

    public function ajaxVotingResults() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $res_id = $this->uri->segment(3);



        $res = $this->resolution->getResolutions(['res_id' => $res_id], NULL, 1);

        if (!$res) {
            cus_json_error('Resolution was not found or it may have been removed from the system');
        }

        $choices = $this->resolution->getResolutionChoices(['rc.choice_res_id' => $res['res_id']]);

        $shares_registered = (float) $this->shareholder->getShareRegitered($this->usr->year_id);

        $total_attendees_voted = 0;
        
        $vote_att_count = $this->resolution->getResVotingAttCount($res['res_id']);
        
        if($vote_att_count){
            $total_attendees_voted = (int)$vote_att_count['manual_attendees_votes'] + (int)$vote_att_count['sms_attendees_votes'] + (int)$vote_att_count['web_attendees_votes'];
        }
        $dividend = $res['res_max_selection'] > 0? (int)$res['res_max_selection'] : 1;
        
        $votes = [];



        $year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);

        if ($res['res_status'] == 'COMPLETED' OR $res['res_status'] == 'RUNNING') {
            $votes = $this->resolution->getResVotingResult(['res_id' => $res['res_id']]);
        }

        //echo '<pre>';print_r($votes);die();

        $pnd = 0;
        foreach ($votes as $v) {
            if ($v['vote_answer'] == 'N/A' OR $v['vote_answer'] == NULL) {
                $pnd += $v['shares'];
            }
        };

        $pnd_percent = $shares_registered > 0 ? round((($pnd / $shares_registered) * 100), 2) . '%' : '0%';


        $abs = 0;
        foreach ($votes as $v) {
            if ($v['vote_answer'] == 'ABS') {
                $abs += $v['shares'];
            }
        };

        $abs_percent = $shares_registered > 0 ? round((($abs / $shares_registered) * 100), 2) . '%' : '0%';


        if (($res['res_status'] == 'COMPLETED' OR $res['res_status'] == 'RUNNING') AND $res['res_vote_type'] == '1') {

            // If resolution type is YES/NO
            $for = 0;
            foreach ($votes as $v) {
                if ($v['vote_answer'] == 'YES') {
                    $for = $v['shares'];
                }
            }
            $for_percent = $shares_registered > 0 ? round((($for / $shares_registered) * 100), 2) . '%' : '0%';


            $agst = 0;
            foreach ($votes as $v) {
                if ($v['vote_answer'] == 'NO') {
                    $agst = $v['shares'];
                }
            }
            $agst_percent = $shares_registered > 0 ? round((($agst / $shares_registered) * 100), 2) . '%' : '0%';

            echo json_encode([
                'status' => ['error' => FALSE],
                'res_type' => 1,
                'res_result' => [
                    'for' => $for,
                    'for_percent' => $for_percent,
                    'agst' => $agst,
                    'agst_percent' => $agst_percent,
                    'abs' => $abs,
                    'abs_percent' => $abs_percent,
                    'pnd' => $pnd,
                    'pnd_percent' => $pnd_percent
                ],
                'vote_att_counts' => $vote_att_count,
                'total_attendees_voted' => $total_attendees_voted,
                'dividend' => $dividend
            ]);
        } elseif (($res['res_status'] == 'COMPLETED' OR $res['res_status'] == 'RUNNING') AND ( $res['res_vote_type'] == '2' OR $res['res_vote_type'] == '3')) {


            // If resolution type is Multiple choices
            $choice_data = [];

            foreach ($choices as $key => $ch) {

                $vt = 0;

                foreach ($votes as $v) {
                    if ($v['vote_answer'] == $ch['choice_letter']) {
                        $vt = $v['shares'];
                    }
                }

                $choice_data['choice_' . $ch['choice_letter'] . '_data'] = $vt;
                $choice_data['choice_' . $ch['choice_letter'] . '_percent_data'] = $shares_registered > 0 ? round((($vt / $shares_registered) * 100), 2) . '%' : '&nbsp;&nbsp;0%';
            }

            //$choice_data['abs_data'] = $abs;
            //$choice_data['abs_percent_data'] = $abs_percent;
            $choice_data['pnd_data'] = $pnd;
            $choice_data['pnd_percent_data'] = $pnd_percent;

            echo json_encode([
                'status' => ['error' => FALSE],
                'res_type' => 2,
                'res_result' => $choice_data,
                'vote_att_counts' => $vote_att_count,
                'total_attendees_voted' => $total_attendees_voted,
                'dividend' => $dividend
            ]);
        }
    }

    public function validateMultipleSelection($selected, $res_id) {

        $res = $this->resolution->getResolutions(['res.res_id' => $res_id], null, 1);

        if (!$res) {
            $this->form_validation->set_message('validateMultipleSelection', 'This resolution can not be found or it may have been removed!');
            return FALSE;
        }

        $selections = $this->input->post('answer_' . $res['res_id'] . '[]');

        if (count($selections) != (int) $res['res_max_selection']) {
            $this->form_validation->set_message('validateMultipleSelection', 'You should select maximum and minimum of ' . $res['res_max_selection'] . ' option(s) from the above choices');
            return FALSE;
        }

        return TRUE;
    }

}
