<?php

$content_data['error_msg'] ="";
$content_data['success_msg']="";

if( null !== $this->session->flashdata('error')){
    $content_data['error_msg']  = '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
       '.$this->session->flashdata('error').'
    </div>';

}
if(null !== $this->session->flashdata('success')){
    $content_data['success_msg'] = '<div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
       '.$this->session->flashdata('success').'
    </div>';
}

$this->load->view('catalog/static/view_catalog_header', $menu_data);
$this->load->view($content, $content_data);
$this->load->view('catalog/static/view_catalog_footer',$footer_data);
