<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Resolutions extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function captureResolution() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $res_number = $this->resolution->getNextResolutionNumber($this->usr->year_id);

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_capture_resolution',
            'menu_data' => ['curr_menu' => 'RESOLUTIONS', 'curr_sub_menu' => 'RESOLUTIONS'],
            'content_data' => [
                'module_name' => 'Capture Resolution',
                'res_types' => $this->resolution->getResolutionTypes(),
                'res_number' => $res_number
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function editResolution() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $res_id = $this->uri->segment(3);
        $res = $this->resolution->getResolutions(['res.res_id' => $res_id], NULL, 1);

        if (!$res) {
            $this->usr->setSessMsg('Resolution was not found or may have been removed from the system', 'error', 'resolutions/resolutionlist');
        }

        if (!in_array($res['res_status'], ['NEW', 'PENDING'])) {
            $this->usr->setSessMsg('Resolution can not be edited with a current status.', 'error', 'resolutions/previewresolution/' . $res['res_id']);
        }

        $choices = $this->resolution->getResolutionChoices(['rc.choice_res_id' => $res['res_id']]);

        $qn_type = "";

        if ($res['res_vote_type'] == '1') {
            $qn_type = 'YESNO';
        } elseif ($res['res_vote_type'] == '2') {
            $qn_type = 'MULTI';
        } elseif ($res['res_vote_type'] == '3') {
            $qn_type = 'MS';
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_edit_resolution',
            'menu_data' => ['curr_menu' => 'RESOLUTIONS', 'curr_sub_menu' => 'RESOLUTIONS'],
            'content_data' => [
                'module_name' => 'Capture Resolution',
                'res_types' => $this->resolution->getResolutionTypes(),
                'res' => $res,
                'choices' => $choices,
                'qn_type' => $qn_type
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function resolutionList() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $resolutions = $this->resolution->getResolutions(['res_year_id' => $this->usr->year_id]);

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_resolution_list',
            'menu_data' => ['curr_menu' => 'RESOLUTIONS', 'curr_sub_menu' => 'RESOLUTIONS'],
            'content_data' => [
                'module_name' => 'Resolution List - ' . $this->session->userdata['logged_in']['user_meeting_year_name'],
                'res_types' => $this->resolution->getResolutionTypes(),
                'resolutions' => $resolutions
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function submitResolutution() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $validations = [
                ['field' => 'res_type_id', 'label' => 'Resolution Type', 'rules' => 'trim|required'],
                ['field' => 'res_desc_en', 'label' => 'Resolution SMS (English)', 'rules' => 'trim|required'],
                ['field' => 'res_desc_sw', 'label' => 'Resolution SMS (Swahili)', 'rules' => 'trim|required'],
                ['field' => 'qn_type', 'label' => 'Question type', 'rules' => 'trim|required'],
                ['field' => 'max_selection', 'label' => 'Maxmum Selection', 'rules' => 'trim|numeric|callback_validateMaxSelection'],
        ];


        $this->form_validation->set_rules($validations);
        $this->form_validation->set_error_delimiters('<p class="rmv_error text-danger">', '</p>');

        if ($this->form_validation->run() === FALSE) {

            $this->captureResolution();
        } else {

            $qn_type = $this->input->post('qn_type');
            $res_desc_en = $this->input->post('res_desc_en');
            $res_desc_sw = $this->input->post('res_desc_sw');
            $letter = $this->input->post('letter[]');
            $qn_desc_en = $this->input->post('qn_desc_en[]');
            $qn_desc_sw = $this->input->post('qn_desc_sw[]');
            $res_number = $this->input->post('res_number');//$this->resolution->getNextResolutionNumber($this->usr->year_id);
            $res_type_id = $this->input->post('res_type_id');
            $max_selection = (int) $this->input->post('max_selection');


            if ($qn_type == 'MS') {
                $qn_type = 3;
            } elseif ($qn_type == 'MULTI') {
                $qn_type = 2;
                $max_selection = 0;
            } else {
                $qn_type = 1;
                $max_selection = 0;
            }

            $choices = [];

            if ($qn_type === 3 OR $qn_type === 2) {

                foreach ($letter as $i => $l) {

                    if (!empty($letter[$i]) AND ! empty($qn_desc_en[$i]) AND ! empty($qn_desc_sw[$i])) {
                        $choices[] = [
                            'choice_letter' => $letter[$i],
                            'choice_description_en' => $qn_desc_en[$i],
                            'choice_description_sw' => $qn_desc_sw[$i]
                        ];
                    }
                }
            }

            $res_data = [
                'res_res_type_id' => $res_type_id,
                'res_number' => $res_number,
                'res_sms_sw' => $res_desc_sw,
                'res_sms_en' => $res_desc_en,
                'res_timestamp' => date('Y-m-d H:i:s'),
                'res_status' => 'PENDING',
                'res_vote_type' => $qn_type,
                'res_usr_id' => $this->usr->user_id,
                'res_year_id' => $this->usr->year_id,
                'res_max_selection' => $max_selection,
                'res_selections' => count($choices)
            ];

            $res = $this->resolution->saveResolution(['res_data' => $res_data, 'choices' => $choices]);

            if ($res) {
                log_message(SYSTEM_LOG, 'resolutions/submitResolutution - ' . $this->usr->user_email . ' -> '.$this->input->ip_address().'added new resolution. res_id : ' . $res);
                $this->usr->setSessMsg('Resolution added successfull, confirm the details', 'success', site_url('resolutions/previewresolution/' . $res));
            } else {
                log_message(SYSTEM_LOG, 'resolutions/submitResolutution - ' . $this->usr->user_email . ' -> '.$this->input->ip_address().'failed to add new resolution');
                $this->usr->setSessMsg('Something went wrong please try again.', 'error', 'resolutions/captureresolution');
            }
        }
    }

    public function submitEditResolutution() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }


        $res_id = $this->uri->segment(3);
        $res = $this->resolution->getResolutions(['res.res_id' => $res_id], NULL, 1);

        if (!$res) {
            $this->usr->setSessMsg('Resolution was not found or may have been removed from the system', 'error', 'resolutions/resolutionlist');
        }


        if (!in_array($res['res_status'], ['NEW', 'PENDING'])) {
            $this->usr->setSessMsg('Resolution can not be edited with a current status.', 'error', 'resolutions/previewresolution/' . $res['res_id']);
        }


        $validations = [
            //['field' => 'edit_cat_form', 'label' => 'Form', 'rules' => 'trim|callback_validateMeetingYear'],
                ['field' => 'res_type_id', 'label' => 'Resolution Type', 'rules' => 'trim|required'],
                ['field' => 'res_desc_en', 'label' => 'Resolution SMS (English)', 'rules' => 'trim|required'],
                ['field' => 'res_desc_sw', 'label' => 'Resolution SMS (Swahili)', 'rules' => 'trim|required'],
                ['field' => 'qn_type', 'label' => 'Question type', 'rules' => 'trim|required'],
                ['field' => 'res_number', 'label' => 'Resolution Number', 'rules' => 'trim|required'],
                ['field' => 'max_selection', 'label' => 'Maxmum Selection', 'rules' => 'trim|numeric|callback_validateMaxSelection'],
        ];





        $this->form_validation->set_rules($validations);
        $this->form_validation->set_error_delimiters('<p class="rmv_error text-danger">', '</p>');

        if ($this->form_validation->run() === FALSE) {

            $this->editResolution();
        } else {

            $qn_type = $this->input->post('qn_type');
            $res_desc_en = $this->input->post('res_desc_en');
            $res_desc_sw = $this->input->post('res_desc_sw');
            $letter = $this->input->post('letter[]');
            $qn_desc_en = $this->input->post('qn_desc_en[]');
            $qn_desc_sw = $this->input->post('qn_desc_sw[]');
            $res_number = $this->input->post('res_number'); //$this->resolution->getNextResolutionNumber($this->usr->year_id);
            $res_type_id = $this->input->post('res_type_id');

            $max_selection = (int) $this->input->post('max_selection');


            if ($qn_type == 'MS') {
                $qn_type = 3;
            } elseif ($qn_type == 'MULTI') {
                $qn_type = 2;
                $max_selection = 0;
            } else {
                $qn_type = 1;
                $max_selection = 0;
            }

            $choices = [];
            if ($qn_type === 3 OR $qn_type === 2) {

                foreach ($letter as $i => $l) {

                    if (!empty($letter[$i]) AND ! empty($qn_desc_en[$i]) AND ! empty($qn_desc_sw[$i])) {
                        $choices[] = [
                            'choice_letter' => $letter[$i],
                            'choice_description_en' => $qn_desc_en[$i],
                            'choice_description_sw' => $qn_desc_sw[$i]
                        ];
                    }
                }
            }

            $res_data = [
                'res_res_type_id' => $res_type_id,
                'res_sms_sw' => $res_desc_sw,
                'res_sms_en' => $res_desc_en,
                'res_vote_type' => $qn_type,
                'res_usr_id' => $this->usr->user_id,
                'res_max_selection' => $max_selection,
                'res_selections' => count($choices),
                'res_number' => $res_number
            ];

            $res = $this->resolution->saveEditResolution(['res_data' => $res_data, 'choices' => $choices, 'res_id' => $res['res_id']]);

            if ($res) {
                log_message(SYSTEM_LOG, 'resolutions/submitEditResolutution - ' . $this->usr->user_email . ' -> '.$this->input->ip_address().'edited a resolution. res_id : ' . $res);
                $this->usr->setSessMsg('Resolution edited successfull.', 'success', site_url('resolutions/previewresolution/' . $res));
            } else {
                log_message(SYSTEM_LOG, 'resolutions/submitEditResolutution - ' . $this->usr->user_email . ' -> '.$this->input->ip_address().'failed to edit resolution');
                $this->usr->setSessMsg('Something went wrong please try again.', 'error', 'resolutions/captureresolution');
            }
        }
    }

    public function previewResolution() {


        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $res_id = $this->uri->segment(3);

        $res = $this->resolution->getResolutions(['res_id' => $res_id], NULL, 1);

        if (!$res) {
            $this->usr->setSessMsg('Resolution was not found or it may have been removed from the system', 'error', 'resolutions/resolutionlist');
        }


        $choices = $this->resolution->getResolutionChoices(['rc.choice_res_id' => $res['res_id']]);
        $shares_registered = (float) $this->shareholder->getShareRegitered($this->usr->year_id);

        $dividend = $res['res_max_selection'] > 0? (int)$res['res_max_selection'] : 1;
        
        $votes = [];
        

        $pnd = 0;
        $abs = 0;

        $year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);

        if ($res['res_status'] == 'COMPLETED' OR $res['res_status'] == 'RUNNING') {
            $votes = $this->resolution->getResVotingResult(['res_id' => $res['res_id']]);
            
        }

        //echo '<pre>';print_r($vote_att_counts);die();

        foreach ($votes as $v) {
            if ($v['vote_answer'] == 'N/A' OR $v['vote_answer'] == NULL) {
                $pnd += $v['shares'];
            }
            if ($v['vote_answer'] == 'ABS') {
                $abs += $v['shares'];
            }
        };

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_preview_resolution',
            'menu_data' => ['curr_menu' => 'RESOLUTIONS', 'curr_sub_menu' => 'RESOLUTIONS'],
            'content_data' => [
                'module_name' => 'Preview Resolution',
                'res' => $res,
                'votes' => $votes,
                'pnd' => $pnd,
                'abs' => $abs,
                'year' => $year,
                'choices' => $choices,
                'dividend' => $dividend,
                'shares_registered' => $shares_registered,
                'vote_att_count' => $this->resolution->getResVotingAttCount($res['res_id'])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function confirmResolution() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $res_id = $this->uri->segment(3);

        $res = $this->resolution->getResolutions(['res_id' => $res_id], NULL, 1);

        if (!$res) {
            $this->usr->setSessMsg('Resolution was not found or it may have been removed from the system', 'error', 'resolutions/resolutionlist');
        }

        if ($res['res_status'] != 'PENDING') {
            $this->usr->setSessMsg('Resolution is not in a right statue to be confirmed so it can be voted', 'error', 'resolutions/previewresolution/' . $res['res_id']);
        }


        $data = ['res_status' => 'NEW'];

        if ($this->resolution->updateResolution($data, ['res_id' => $res['res_id']])) {
            log_message(SYSTEM_LOG, 'resolutions/confirmResolution - ' . $this->usr->user_email . ' -> '.$this->input->ip_address().'confirmed resolution details. res_id : ' . $res['res_id']);
            $this->usr->setSessMsg('Resolution was updated successfully', 'success', site_url('resolutions/previewresolution/' . $res['res_id']));
        } else {
            $this->usr->setSessMsg('Nothing was updated', 'warning', site_url('resolutions/previewresolution/' . $res['res_id']));
        }
    }

    public function startVoting() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $res_id = $this->uri->segment(3);

        $min_percent = (float) $this->utl->getSetValue('MIN_PERCENTAGE');

        $agm_year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);
        $shares_registered = (float) $this->shareholder->getShareRegitered($this->usr->year_id);

        $total_capital = $agm_year['year_total_share'];
        $percent = $total_capital > 0 ? round(($shares_registered / $total_capital) * 100, 2) : 0;



        $res = $this->resolution->getResolutions(['res_id' => $res_id], NULL, 1);

        
        
        if (!$res) {
            $this->usr->setSessMsg('Resolution was not found or it may have been removed from the system', 'error', 'resolutions/resolutionlist');
        }

        
        if(!$this->usr->yearIsActive($this->usr->year_id)){
            $this->usr->setSessMsg('Resolution cannot be started because meeting year is CLOSED', 'error', 'resolutions/previewresolution/' . $res['res_id']);
        }
        
        if ($percent < $min_percent) {

            $this->usr->setSessMsg('Resolution can not be started because minimum percentage of quorum is not met', 'error', 'resolutions/previewresolution/' . $res['res_id']);
        }

        $running_res = $this->resolution->getResolutions(['res_status' => 'RUNNING'], NULL, 1);

        if ($running_res) {
            $this->usr->setSessMsg('Stop the running resolution before starting another. <a href="' . site_url('resolutions/previewresolution/' . $running_res['res_id']) . '">Open running resolution</a>', 'error', 'resolutions/previewresolution/' . $res['res_id']);
        }
        
        


        if ($res['res_status'] != 'NEW') {
            $this->usr->setSessMsg('Resolution is not in a right statue to be voted', 'error', 'resolutions/previewresolution/' . $res['res_id']);
        }


        $data = [
            'res_id' => $res['res_id'],
            'res_vote_type' => $res['res_vote_type'],
            'res_max_selection' => (int) $res['res_max_selection'],
            'year_id' => $this->usr->year_id
        ];

        if ($this->resolution->initiateVoting($data)) {
            log_message(SYSTEM_LOG, 'resolutions/startVoting - ' . $this->usr->user_email . ' -> '.$this->input->ip_address().'started  resolution voting. res_id : ' . $res['res_id']);
            $this->usr->setSessMsg('Resolution voting strarted successfully', 'success', site_url('resolutions/previewresolution/' . $res['res_id']));
        } else {
            $this->usr->setSessMsg('Something went wrong, resolution voting not started', 'warning', site_url('resolutions/previewresolution/' . $res['res_id']));
        }
    }

    public function stopVoting() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }

        $res_id = $this->uri->segment(3);

        $res = $this->resolution->getResolutions(['res_id' => $res_id], NULL, 1);

        if (!$res) {
            $this->usr->setSessMsg('Resolution was not found or it may have been removed from the system', 'error', 'resolutions/resolutionlist');
        }


        if ($res['res_status'] != 'RUNNING') {
            $this->usr->setSessMsg('Resolution is not in a right statue to be stopped for voting', 'error', 'resolutions/previewresolution/' . $res['res_id']);
        }

        $data = [
            'res_id' => $res['res_id'],
            'year_id' => $this->usr->user_id
        ];

        if ($this->resolution->completeVoting($data)) {
            log_message(SYSTEM_LOG, 'resolutions/stopVoting - ' . $this->usr->user_email . ' -> '.$this->input->ip_address().'stopped  resolution voting. res_id : ' . $res['res_id']);
            $this->usr->setSessMsg('Resolution voting stopped successfully', 'success', site_url('resolutions/previewresolution/' . $res['res_id']));
        } else {
            $this->usr->setSessMsg('Something went wrong, resolution voting not started', 'warning', site_url('resolutions/previewresolution/' . $res['res_id']));
        }
    }

    public function votingAnswers() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required", 'error', 'user');
        }


        $res_id = $this->uri->segment(3);

        $res = $this->resolution->getResolutions(['res_id' => $res_id], NULL, 1);

        if (!$res) {
            $this->usr->setSessMsg('Resolution was not found or it may have been removed from the system', 'error', 'resolutions/resolutionlist');
        }



        $answers = $this->voting->getVoteAnswers(['res.res_id' => $res['res_id']]);

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_vote_answers',
            'menu_data' => ['curr_menu' => 'RESOLUTIONS', 'curr_sub_menu' => 'RESOLUTIONS'],
            'content_data' => [
                'module_name' => 'Voting Answers',
                'answers' => $answers,
                'res' => $res
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function resolutionCategories() {


        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Login is required', 'error', 'user/index');
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_resolution_categories',
            'menu_data' => [
                'curr_menu' => 'RESOLUTIONS',
                'curr_sub_menu' => 'RESOLUTIONS'
            ],
            'content_data' => [
                'module_name' => 'Resolution Categories',
                'cats' => $this->resolution->getResolutionTypes(),
            ],
            'modals_data' => [
                'modals' => ['modal_add_cat']
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function submitResolutionCategory() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your session might have been expired. Please refresh the page');
        }


        $validations = [
                ['field' => 'add_cat_form', 'label' => 'Form', 'rules' => 'trim|callback_validateMeetingYear'],
                ['field' => 'desc', 'label' => 'category description', 'rules' => 'trim|required|is_unique[' . $this->db->dbprefix . 'resolution_types.res_type_description]'],
                ['field' => 'seq', 'label' => 'sequence number', 'rules' => 'trim|required|numeric']
        ];

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

            $cat_data = [
                'res_type_description' => $this->input->post('desc'),
                'res_type_sequence' => $this->input->post('seq')
            ];

            $res = $this->resolution->saveResolutionCategory($cat_data);

            if ($res) {

                log_message(SYSTEM_LOG, 'resolutions/submitResolutionCategory - ' . $this->usr->user_email . ' -> '.$this->input->ip_address().'added new resolution category. res_type_id : ' . $res);
                $this->session->set_flashdata('success', 'Resolution category added successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => TRUE,
                        'redirect_url' => site_url('resolutions/resolutioncategories')
                    ]
                ]);
                die();
            } else {
                cus_json_error('Something went wrong resolution category not added.');
            }
        }
    }

    public function deleteResolutionCategory() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('login is rwquired', 'error', 'user');
        }

        $cat_id = $this->uri->segment(3);

        $cat = $this->resolution->getResolutionTypes(['res_type_id' => $cat_id], NULL, 1);

        if (!$cat) {
            $this->usr->setSessMsg('Resolution may have been removed successfully', 'error', 'resolutions/resolutioncategories');
        }

        $res = $this->resolution->getResolutions(['res.res_res_type_id' => $cat['res_type_id']]);

        if ($res) {
            $this->usr->setSessMsg('Category can not be deleted because its accociated with one or more resolution', 'warning', 'resolutions/resolutioncategories');
        }

        $res = $this->resolution->deleteResolutionCategory($cat['res_type_id']);

        if ($res) {
            $this->usr->setSessMsg('Resolution category deleted successfully', 'success', 'resolutions/resolutioncategories');
        } else {
            $this->usr->setSessMsg('Category was not deleted', 'warning', 'resolutions/resolutioncategories');
        }
    }

    public function validateMeetingYear() {

        if (!$this->usr->yearIsActive($this->usr->year_id)) {
            $this->form_validation->set_message('validateMeetingYear', 'Your form cannot be submitted because the meeting year is closed');
            return FALSE;
        }

        return TRUE;
    }

    public function validateMaxSelection($max_selection) {

        $qn_type = $this->input->post("qn_type");

        if ($qn_type == 'MS') {

            if (empty($this->input->post("max_selection"))) {
                $this->form_validation->set_message('validateMaxSelection', 'Maximum selection should be a number greater than one');
                return FALSE;
            }
        }

        return TRUE;
    }

}
