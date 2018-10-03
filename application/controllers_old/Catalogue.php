<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogue extends CI_Controller {

    var $is_logged_in = false;
    var $language = null;
    var $att_id = null;
    var $login_name = null;
    var $attend_as = null;
    var $att_phone = null;
    var $att_pin = null;

    public function __construct() {
        parent::__construct();

        if (isset($this->session->userdata['sh_logged_in'])) {
            $this->is_logged_in = TRUE;
            $this->att_id = $this->session->userdata['sh_logged_in']['att_id'];
            $this->language = $this->session->userdata['sh_logged_in']['att_language'];
            $this->login_name = $this->session->userdata['sh_logged_in']['att_fullname'];
            $this->attend_as = $this->session->userdata['sh_logged_in']['att_attends_as'];
            $this->att_phone = $this->session->userdata['sh_logged_in']['att_phone'];
            $this->att_pin = $this->session->userdata['sh_logged_in']['att_pin'];
        }
    }

    public function index() {

        // Check if user has already logged in and redirect to dashboard
        if ($this->is_logged_in) {
            redirect('catalogue/vote');
        }

        // Prepare error message
        $content_data['alert'] = "";

        if (null !== $this->session->flashdata('error')) {
            $content_data['alert'] .= '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('error') . '</div>';
        }
        if (null !== $this->session->flashdata('success')) {
            $content_data['alert'] .= '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('success') . '</div>';
        }

        $this->load->view('contents/view_shareholder_login', $content_data);
    }

    public function submitshareholderlogin() {

        // Validate Login Credentials
        $this->form_validation->set_error_delimiters('<p class="rmv_error text-danger">', '</p>');
        $validations = [
                ['field' => 'phone', 'label' => 'Phone Number', 'rules' => 'trim|required|callback_validateLoginPhone'],
                ['field' => 'pin', 'label' => 'PIN Number', 'rules' => 'trim|required|callback_validateLoginPin']
        ];

        //log_message(SYSTEM_LOG, 'user/submitLogin - ' . $this->input->post('loginUsername') . ' Attempting to login');
        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {
            $this->index();
        } else {


            $phone_number = cus_phone_with_255($this->input->post('phone'));
            $pin = $this->input->post('pin');

            $att = $this->shareholder->getAttendees(NULL, ['att_phone_number' => $phone_number], 1);


            if (!$att) {
                $this->usr->setSessMsg('Your details was not found please try to login again', 'error', 'catalogue');
            }

            //log_message(SYSTEM_LOG, 'user/submitLogin - ' . $this->input->post('loginUsername') . ' Logged in');

            $this->session->set_userdata([
                'sh_logged_in' => [
                    'att_id' => $att['att_id'],
                    'att_language' => $att['att_language'],
                    'att_fullname' => $att['att_fullname'],
                    'att_attends_as' => $att['att_attends_as'],
                    'att_phone' => $att['att_phone_number'],
                    'att_pin' => $pin,
                ]
            ]);

            log_message(SYSTEM_LOG, 'catalogue/submitshareholderlogin - att_id_' . $att['att_id'] . ' -> '.$this->input->ip_address().'logged in for votting.');

            if (empty($att['att_language'])) {

                redirect('catalogue/selectlanguage');
            } else {
                redirect('catalogue/vote');
            }
        }
    }

    public function validateLoginPhone($phone_number) {


        if (!empty($phone_number)) {

            $att = $this->shareholder->getAttendees(NULL, ['att_phone_number' => cus_phone_with_255($phone_number), 'att_has_smartphone' => '1'], 1);

            if (!$att) {

                $this->form_validation->set_message('validateLoginPhone', 'Invalid phone number.');
                return FALSE;
            }
        }

        return TRUE;
    }

    public function validateLoginPin($pin) {


        $phone_number = cus_phone_with_255($this->input->post('phone'));


        $att = $this->shareholder->getAttendees(NULL, ['att_phone_number' => $phone_number], 1);


        if (!empty($pin) AND $att) {

            if ($att['att_smartphone_pin'] !== sha1($pin)) {
                $this->form_validation->set_message('validateLoginPin', 'PIN does not match to a phone number.');
                return FALSE;
            }
        }

        return TRUE;
    }

    public function vote() {

        // Check if user has not logged in and redirect to login page
        if (!$this->is_logged_in) {
            $this->usr->setSessMsg("Please Login to vote", 'error', 'catalogue');
        }
        $choices = [];

        $res = $this->resolution->getResolutionToVote($this->att_id);

        if ($res) {
            $choices = $this->resolution->getResolutionChoices(['rc.choice_res_id' => $res['res_id']]);
        }



        $data = [
            'menu' => 'menu/view_sh_menu',
            'content' => 'catalogue/view_vote',
            'menu_data' => [
                'curr_menu' => 'VOTE',
                'curr_sub_menu' => 'VOTE',
                'name' => $this->login_name,
                'attend_as' => $this->attend_as
            ],
            'content_data' => [
                'module_name' => $this->language == 'SW' ? 'Piga Kura' : 'Voting',
                'res' => $res,
                'choices' => $choices,
                'lang' => $this->language
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['logout' => 'catalogue/logout']
        ];

        $this->load->view('view_base', $data);
    }

    public function selectLanguage() {

        // Check if user has not logged in and redirect to login page
        if (!$this->is_logged_in) {
            $this->usr->setSessMsg("Please Login to vote", 'error', 'catalogue');
        }
        $choices = [];


        $data = [
            'menu' => 'menu/view_sh_menu',
            'content' => 'catalogue/view_select_language',
            'menu_data' => [
                'curr_menu' => 'LANGUAGE',
                'curr_sub_menu' => 'LANGUAGE',
                'name' => $this->login_name,
                'attend_as' => $this->attend_as
            ],
            'content_data' => [
                'module_name' => $this->language == 'SW' ? 'Chagua Lugha' : 'Select Language',
                'lang' => $this->language
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['logout' => 'catalogue/logout']
        ];

        $this->load->view('view_base', $data);
    }

    public function submitSelectLanguage() {

        
        // Check if user has not logged in and redirect to login page
        if (!$this->is_logged_in) {
            $this->usr->setSessMsg("Please Login to vote", 'error', 'catalogue');
        }
        
        // Validate Login Credentials
        $this->form_validation->set_error_delimiters('<p class="rmv_error text-danger">', '</p>');
        $validations = [
                ['field' => 'lang', 'label' => 'Language', 'rules' => 'trim|required', 'errors' => ['required' => $this->language == 'SW' ? 'Tafadhali chagua lugha uendelee' : 'Please select language to continue']]
        ];

        //log_message(SYSTEM_LOG, 'user/submitLogin - ' . $this->input->post('loginUsername') . ' Attempting to login');
        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {
            $this->selectLanguage();
        } else {

            $att_data = ['att_language' => $this->input->post('lang')];

            $this->shareholder->updateAttendance($att_data, $this->att_id);

            $sh_data = $this->session->userdata['sh_logged_in'];

            $sh_data['att_language'] = $att_data['att_language'];

            $this->session->set_userdata('sh_logged_in', $sh_data);
            log_message(SYSTEM_LOG, 'catalogue/submitSelectLanguage - att_id_' . $this->att_id . ' -> '.$this->input->ip_address().'changed profile language. lang : ' . $att_data['att_language']);

            redirect('catalogue/vote');
        }
    }

    public function logout() {

        if (null !== $this->session->flashdata('error')) {
            $this->session->set_flashdata('error', $this->session->flashdata('error'));
        }

        if (null !== $this->session->flashdata('error')) {
            $this->session->set_flashdata('error', $this->session->flashdata('error'));
        }
        if (isset($this->session->userdata['sh_logged_in'])) {

            log_message(SYSTEM_LOG, ' catalogue/logout - att_id_' . $this->att_id . ' -> '.$this->input->ip_address().'logged out.');

            $this->session->unset_userdata('sh_logged_in');
            redirect('catalogue?phone=' . $this->att_phone . '&pin=' . $this->att_pin);
        } else {
            redirect('catalogue');
        }
    }

    public function submitVote() {

        // Check if user has not logged in and redirect to login page
        if (!$this->is_logged_in) {
            $this->usr->setSessMsg("Please Login to vote", 'error', 'catalogue');
        }


        $res = $this->resolution->getResolutionToVote($this->att_id);

        if (!$res) {
            $this->usr->setSessMsg((($this->language == 'SW') ? 'Kura yako haikuhesabiwa' : 'Your vote was not counted.'), 'error', 'catalogue/vote');
        }

        if ($res['res_status'] != 'RUNNING') {
            $msg = ($this->language == 'SW') ? 'Kura yako haijahesabiwa kwasababu upigaji kura wa azimio namba ' . $res['res_number'] . ' umesitishwa.' : 'Your vote was not counted because resolution number ' . $res['res_number'] . ' voting has stopped';
            $this->usr->setSessMsg($msg, 'error', 'catalogue/vote');
        }

        $this->form_validation->set_error_delimiters('<p class="rmv_error text-danger">', '</p>');
        $validations = [
                ['field' => 'vote_form', 'label' => 'Form', 'rules' => 'validateVoteForm']
        ];


        if ($res['res_vote_type'] == '3') {
            $validations[] = ['field' => 'answer[]', 'label' => 'Answer', 'rules' => 'trim|callback_validateMsAnswer[' . $res['res_id'] . ']', 'errors' => ['required' => ($this->language == 'SW') ? 'Bofya jibu lako kati ya hapo juu kisha ukusanye.' : 'You should select your answer']];
        } else {
            $validations[] = ['field' => 'answer', 'label' => 'Answer', 'rules' => 'trim|required', 'errors' => ['required' => ($this->language == 'SW') ? 'Bofya jibu lako kati ya hapo juu kisha ukusanye.' : 'You should select your answer']];
        }


        //log_message(SYSTEM_LOG, 'user/submitLogin - ' . $this->input->post('loginUsername') . ' Attempting to login');
        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {
            $this->vote();
        } else {

            if ($res['res_vote_type'] == '3') {

                $selections = $this->input->post('answer[]');

                foreach ($selections as $key => $s) {
                    
                    $voting_data[] = [
                        'res_id' => $res['res_id'],
                        'att_id' => $this->att_id,
                        'selection' => $key + 1,
                        'answer_data' => [
                            'vote_answer' => $s,
                            'vote_channel' => 'WEB',
                            'vote_status' => 3,
                            'vote_type' => $res['res_vote_type'],
                            'vote_timestamp' => date('Y-m-d H:i:s')
                        ]
                    ];
                }
                
            } else {
                
                $voting_data[] = [
                        'res_id' => $res['res_id'],
                        'att_id' => $this->att_id,
                        'selection' => 1,
                        'answer_data' => [
                            'vote_answer' => $this->input->post('answer'),
                            'vote_channel' => 'WEB',
                            'vote_status' => 3,
                            'vote_type' => $res['res_vote_type'],
                            'vote_timestamp' => date('Y-m-d H:i:s')
                        ]
                    ];
            }

            //echo '<pre>';            print_r($voting_data); die();
            
            if ($this->resolution->updateVote(['voting_data' => $voting_data])) {
                log_message(SYSTEM_LOG, 'catalogue/submitVote - att_id_' . $this->att_id . ' -> '.$this->input->ip_address().'votted for resolution. res_id : ' . $res['res_id']);
                $this->usr->setSessMsg((($this->language == 'SW') ? 'Umefanikiwa kupiga kura' : 'Your vote submitted successfully.'), 'success', 'catalogue/vote');
            } else {
                log_message(SYSTEM_LOG, 'catalogue/submitVote - att_id_' . $this->att_id . ' -> '.$this->input->ip_address().'failed to vote for res_id : ' . $res['res_id']);
                $this->usr->setSessMsg((($this->language == 'SW') ? 'Tatizo limetokea, Kura yako haikuhesabiwa' : 'Something went wrong, your vote was not counted.'), 'error', 'catalogue/vote');
            }
        }
    }

    public function validateVoteForm() {

        if (!$this->usr->yearIsActive($this->usr->year_id)) {
            $this->form_validation->set_message('validateForm', 'Resolution year is closed. No changes is allowed');
            return FALSE;
        }
        return true;
    }

    public function validateMsAnswer($answer, $res_id) {

        $res = $this->resolution->getResolutions(['res.res_id' => $res_id], null, 1);

        if (!$res) {
            $this->form_validation->set_message('validateMsAnswer', (($this->language == 'SW') ? 'Azimio hili halijapatikana au litakua limeondolewa.' : 'This resolution can not be found or it may have been removed!'));
            return FALSE;
        }

        $selections = $this->input->post('answer[]');

        if (count($selections) != (int) $res['res_max_selection']) {
            $this->form_validation->set_message('validateMsAnswer', (($this->language == 'SW') ? 'Unatakiwa kuchagua majibu yasiyopungua na yasiyozidi ' . $res['res_max_selection'] . ' kati ya hapo juu' : 'You should select maximum and minimum of ' . $res['res_max_selection'] . ' option(s) from the above choices'));
            return FALSE;
        }

        return TRUE;
    }

}
