<?php

$content_data['error_msg'] = "";
$content_data['success_msg'] = "";
$content_data['current_url'] = '?url='. urlencode(current_url()) .'?'.$_SERVER['QUERY_STRING'];


// Profile Data Above Menu
if ($this->usr->isLogedin()) {
    $menu_data['full_name'] = $this->session->userdata['logged_in']['user_fullname'];
    $menu_data['role'] = $this->session->userdata['logged_in']['user_role'];
    $menu_data['ad_name'] = $this->session->userdata['logged_in']['user_ad_name'];
    $menu_data['page'] = $this->session->userdata['logged_in']['user_page'];
}


$alert = "";
if (null !== $this->session->flashdata('error')) {
    $alert .= '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
       ' . $this->session->flashdata('error') . '
    </div>';
}

if (null !== $this->session->flashdata('success')) {
    $alert .= '<div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
       ' . $this->session->flashdata('success') . '
    </div>';
}

if (null !== $this->session->flashdata('warning')) {
    $alert .= '<div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
       ' . $this->session->flashdata('warning') . '
    </div>';
}

if (null !== $this->session->flashdata('info')) {
    $alert .= '<div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
       ' . $this->session->flashdata('info') . '
    </div>';
}

$content_data['alert'] = $alert;

$modals_data = isset($modals_data)? $modals_data : ['modals' => []];

$this->load->view('static/view_header', $header_data);
$this->load->view('static/view_top_bar', $top_bar_data);
$this->load->view($menu, $menu_data);
$this->load->view('static/view_modals', $modals_data);
$this->load->view($content, $content_data);
$this->load->view('static/view_footer', $footer_data);
