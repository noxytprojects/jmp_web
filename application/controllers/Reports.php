<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

     var $extended = [];

    public function __construct() {
        parent::__construct();
        if ($this->usr->is_logged_in) {
            $this->extended = $this->usr->getExtendedPermitCount();
        }
    }
    public function dashboard() {
        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg(MSG_SESSION_EXPIRY, 'error', 'user');
        }

        $data['dashboard'] = $this->report->get_dashboard();
//        $data['to5auths'] = $this->approversmodel->geTop5tAuthReport();
//        $data['graph'] = $this->usermodel->getGraph();



        $data = [
            'dashboard' => $this->report->get_dashboard(),
            'menu' => 'menu/view_sys_menu',
            'content' => 'reports/dashboard',
            'menu_data' => ['curr_menu' => 'REPORT', 'curr_sub_menu' => 'REPORT','extended_count' => count($this->extended),'inbox_count' => $this->usr->getInboxPermitCount()],
            'content_data' => ['module_name' => 'Dashboard'],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['inbox' => $this->usr->getInbox()]
        ];

        $this->load->view('view_base', $data);
    }

    public function detailedReport() {

        // Check if user has logged in 
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg(MSG_SESSION_EXPIRY, 'error', 'user');
        }

        // Check For Filters if submitted
        if (null !== $this->input->post('rpt_sbt')) {

            $date_range_segments = [];
            $filter = NULL;

            $date_range = (NULL !== $this->input->post('date_range') AND ! empty($this->input->post('date_range'))) ? $this->input->post('date_range') : 'ALL';
            $perm_type = in_array($this->input->post('perm_type'), PERM_TYPES) ? $this->input->post('perm_type') : 'ALL';
            $perm_status = in_array($this->input->post('perm_status'), PERM_STATUSES) ? $this->input->post('perm_status') : 'ALL';

            if (!empty($date_range)) {

                $date_range_segments = explode('to', $date_range);
                if (sizeof($date_range_segments) == 2) {
                    $filter = ["DATE(p.p_from_date) >=" => trim($date_range_segments[0]), "DATE(p.p_from_date) <=" => trim($date_range_segments[1])];
                } else {
                    $filter = 'ALL';
                }
            }

            $filter = [
                'date_range' => $filter,
                'perm_type' => $perm_type,
                'perm_status' => $perm_status
            ];



            $this->session->set_userdata(['filter_permits_rpt' => $filter]);
        } else {
            // If not submitted then clear filter sessions
            $this->utl->clearFilterSessions();
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'reports/view_detailed_report',
            'menu_data' => ['curr_menu' => 'REPORT', 'curr_sub_menu' => 'REPORT','inbox_count' => $this->usr->getInboxPermitCount(),'extended_count' => count($this->extended)],
            'content_data' => ['module_name' => 'Permits Detailed Report'],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['inbox' => $this->usr->getInbox(),'extended' => $this->extended]
        ];

        $this->load->view('view_base', $data);
    }

    public function ajaxDetailedReport() {

        if (!$this->usr->is_logged_in) {
            echo json_encode(
                    [
                        "draw" => $_POST['draw'],
                        "recordsTotal" => 0,
                        "recordsFiltered" => 0,
                        "data" => [],
                        "status" => ['error' => TRUE, 'error_msg' => 'User has not logged in']
                    ]
            );
            die();
        }

        $data = [];
        $datatables = [
            'select_columns' => [
                'p.p_id',
                'p.p_reference',
                'p.p_description',
                'p.p_from_date',
                'p.p_to_date',
                'p.p_timestamp',
                'p.p_type',
                'p.p_status',
                'u.usr_fullname',
                'u.usr_email',
                'u.usr_contractor',
                'p.p_site',
                's.site_name',
                's.site_region'
            ],
            'search_columns' => [
                'p.p_description',
                'p.p_status',
                'p.p_reference',
                'p.p_site',
                's.site_name',
                's.site_region',
                'u.usr_fullname',
                'u.usr_contractor'
            ],
            'order_columns' => [
                NULL
            ],
            'default_order_column' => [
                'p.p_timestamp' => 'DESC'
            ],
            'cond' => NULL,
            'group_by' => TRUE,
            'where_in' => ['p.p_status' => ['BROADCASTED', 'CLOSED']]
        ];

        $list = $this->report->get_datatables_permits($datatables);
        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = [];
            $status = cus_status_template($a->p_status);

//            $links = '<div class="dropdown">
//                        <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
//                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
//                            <a href="' . site_url('permits/pdfptwpreview/' . $a->p_id) . '" class="dropdown-item edit_user text-info" target="_blank"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
//                                <a href="' . site_url('permits/ptwpreview/' . $a->p_id) . '?url=' . urlencode(site_url('permits/mypermits')) . '&module=' . urldecode("My Permit Requests") . '" class="dropdown-item text-success"> <i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;Approval Satatus</a>
//                        </div>
//                    </div>';

            $row[] = $no;
            $row[] = '<div nowrap="nowrap">' . $a->p_reference . '<div>';
            $row[] = '<div style="min-width:250px;">' . ucwords(cus_ellipsis($a->p_description, 200)) . '</div>';
            $row[] = '<div nowrap="nowrap">' . cus_nice_date($a->p_timestamp) . '<div>';
            $row[] = '<div nowrap="nowrap"><b>' . ucwords($a->usr_fullname) . '</b><br/>' . $a->usr_contractor . '</div>';
            $row[] = '<div nowrap="nowrap">' . cus_nice_timestamp($a->p_from_date) . '<br/>To<br/>' . cus_nice_timestamp($a->p_to_date) . '</div>';
            $row[] = '<div nowrap="nowrap">' . $a->p_type . '</div>'; //($a->p_type == 'WAH' ? 'WORKING AT HEIGHT' : 'ELECTRICAL') 
            $row[] = $status;
            $row[] = '<div nowrap="nowrap">' . $a->p_site . '</div>';
            $row[] = '<div nowrap="nowrap">' . $a->site_name . '</div>';
            $row[] = '<div nowrap="nowrap">' . $a->site_region . '</div>';
//            $row[] = $links;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report->count_all_permits($datatables),
            "recordsFiltered" => $this->report->count_filtered_permits($datatables),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    
    public function excelUsers() {


        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)
        //$cond = ['usr_status <>' => 'DELETED'];
        $users = $this->usr->getUsersList();

        $html = $this->load->view('export/view_export_excel_users', ['users' => $users], true); // render the view into HTML

        $file = "users-" . date('Ymd-His', time()) . ".xls";

        header("Content-type: application/vnd.ms-excel");

        header("Content-Disposition: attachment; filename=$file");

        echo $html;
    }

}
