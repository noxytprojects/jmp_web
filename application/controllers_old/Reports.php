<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function quorum() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }

        $shares_registered = 0;
        $shareholders_registered = 0;
        $total_capital = 0;

        $agm_year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);
        $share_value = (float) $this->utl->getSetValue('SHARE_VALUE');
        $shares_registered = (float) $this->shareholder->getShareRegitered($this->usr->year_id);
        $shareholders_registered = (int) $this->shareholder->getCdsCounts($this->usr->year_id);

        $total_capital = $agm_year['year_total_share'];
        $shares_registered = $shares_registered;
        $percent = $total_capital > 0 ? round(($shares_registered / $total_capital) * 100, 2) : 0;


        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'reports/view_report_quorum',
            'menu_data' => ['curr_menu' => 'REPORTS', 'curr_sub_menu' => 'REPORTS'],
            'content_data' => [
                'module_name' => 'Quorum Report ' . $this->session->userdata['logged_in']['user_meeting_year_name'],
                'shares_registered' => $shares_registered,
                'total_capital' => $total_capital,
                'year' => $agm_year,
                'percent' => $percent,
                'shareholders_registered' => $shareholders_registered
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }
    
    public function attendanceSummary() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }

        $shares_registered = 0;
        $shareholders_registered = 0;
        $total_capital = 0;

        $agm_year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);
        $share_value = (float) $this->utl->getSetValue('SHARE_VALUE');
        $shares_registered = (float) $this->shareholder->getShareRegitered($this->usr->year_id);
        $shareholders_registered = (int) $this->shareholder->getCdsCounts($this->usr->year_id);

        $total_capital = $agm_year['year_total_share'];
        $shares_registered = $shares_registered;
        $percent = $total_capital > 0 ? round(($shares_registered / $total_capital) * 100, 2) : 0;
        
        $shareholders_attendance = $this->shareholder->getAttendace(['catt.cds_att_acc_number'], ['catt.cds_att_year_id' => $this->usr->year_id, 'catt.cds_att_type' => 'SELF','att.att_attends_as' => 'SHAREHOLDER'], NULL);
        $shareholders_attendance = count($shareholders_attendance);
        $proxy_attendance = $this->shareholder->getAttendees(['att.att_id'], ['att.att_attends_as' =>'REPRESENTATIVE','att.att_year_id' => $this->usr->year_id]);
        $proxy_attendance = count($proxy_attendance);


        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'reports/view_report_attendance_summary',
            'menu_data' => ['curr_menu' => 'REPORTS', 'curr_sub_menu' => 'REPORTS'],
            'content_data' => [
                'module_name' => 'Attendance Summary Report ' . $this->session->userdata['logged_in']['user_meeting_year_name'],
                'shares_registered' => $shares_registered,
                'total_capital' => $total_capital,
                'year' => $agm_year,
                'percent' => $percent,
                'shareholders_registered' => $shareholders_registered,
                'shareholders_attendance' => $shareholders_attendance,
                'proxy_attendance' => $proxy_attendance
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function proxy() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }

     
        $proxies = $this->shareholder->getShareholdersProxies(['att.att_year_id' => $this->usr->year_id]);

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'reports/view_report_proxy',
            'menu_data' => ['curr_menu' => 'REPORTS', 'curr_sub_menu' => 'REPORTS'],
            'content_data' => [
                'module_name' => 'Shareholders Proxy Report',
                'proxies' => $proxies,
                'year' => $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1)
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function attendanceReport() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }
        $cols = ['att.att_id', 'cacc.cds_acc_number', 'cacc.cds_acc_fullname', 'catt.cds_att_type', 'rep.att_fullname', 'att.att_phone_number', 'att.att_language', 'att.att_has_smartphone', 'cacc.cds_acc_shares'];
        $attendance = $this->shareholder->getAttendace($cols, ['att.att_year_id' => $this->usr->year_id]);

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'reports/view_report_attendance',
            'menu_data' => ['curr_menu' => 'REPORTS', 'curr_sub_menu' => 'REPORTS'],
            'content_data' => [
                'module_name' => 'Attendance Report',
                'attendance' => $attendance,
                'year' => $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1)
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function excelProxy() {


        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)

        $proxies = $this->shareholder->getShareholdersProxies(['att.att_year_id' => $this->usr->year_id]);
        $year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);

        $html = $this->load->view('export/view_export_excel_proxies', ['proxies' => $proxies, 'year' => $year], true); // render the view into HTML



        $file = "shareholders-proxies-report-" . date('Ymd-His', time()) . ".xls";

        header("Content-type: application/vnd.ms-excel");

        header("Content-Disposition: attachment; filename=$file");

        echo $html;
    }

    public function excelAttendance() {


        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)

        $attendance = $this->shareholder->getAttendace(NULL, ['att.att_year_id' => $this->usr->year_id]);
        $year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);


        $html = $this->load->view('export/view_export_excel_attendance', ['attendance' => $attendance, 'year' => $year], true); // render the view into HTML



        $file = "shareholders-proxies-report-" . date('Ymd-His', time()) . ".xls";

        header("Content-type: application/vnd.ms-excel");

        header("Content-Disposition: attachment; filename=$file");

        echo $html;
    }

    public function pdfExportQuorumReport() {

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)
        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }

        $shares_registered = 0;
        $shareholders_registered = 0;
        $total_capital = 0;

        $agm_year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);
        $shares_registered = (float) $this->shareholder->getShareRegitered($this->usr->year_id);
        $shareholders_registered = (int) $this->shareholder->getCdsCounts($this->usr->year_id);

        $total_capital = $agm_year['year_total_share'];
        $shares_registered = $shares_registered;
        $percent = $total_capital > 0 ? round(($shares_registered / $total_capital) * 100, 2) : 0;

        $time = date('d-m-Y H:i:s');

        $data = [
            'shares_registered' => $shares_registered,
            'total_capital' => $total_capital,
            'year' => $agm_year,
            'percent' => $percent,
            'shareholders_registered' => $shareholders_registered,
            'user' => strtoupper($this->usr->user_fullname),
            'time' => $time
        ];

        $html = $this->load->view('export/view_export_pdf_quorum', $data, true); // render the view into HTML

        $this->load->library('pdf');

        $pdf = $this->pdf->load('c', 'A4');

        $pdf->SetFooter(SYSTEM_NAME . ' - Printed by ' . ucwords($this->usr->user_fullname) . '<br/>' . $time . '||Powered By Noxyt Software Solution <br/>www.noxyt.com'); // Add a footer for good measure ;)

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output();
        return;
    }
    
    public function pdfExportAttendenceSummary() {
        
        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)
        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }

        $shares_registered = 0;
        $shareholders_registered = 0;
        $total_capital = 0;

        $agm_year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);
        $shares_registered = (float) $this->shareholder->getShareRegitered($this->usr->year_id);
        $shareholders_registered = (int) $this->shareholder->getCdsCounts($this->usr->year_id);

        $total_capital = $agm_year['year_total_share'];
        $shares_registered = $shares_registered;
        $percent = $total_capital > 0 ? round(($shares_registered / $total_capital) * 100, 2) : 0;
        $shareholders_attendance = $this->shareholder->getAttendace(['catt.cds_att_acc_number'], ['catt.cds_att_year_id' => $this->usr->year_id, 'catt.cds_att_type' => 'SELF','att.att_attends_as' => 'SHAREHOLDER'], NULL);
        $shareholders_attendance = count($shareholders_attendance);
        $proxy_attendance = $this->shareholder->getAttendees(['att.att_id'], ['att.att_attends_as' =>'REPRESENTATIVE','att.att_year_id' => $this->usr->year_id]);
        $proxy_attendance = count($proxy_attendance);

        $time = date('d-m-Y H:i:s');

        $data = [
            'shares_registered' => $shares_registered,
            'total_capital' => $total_capital,
            'year' => $agm_year,
            'percent' => $percent,
            'shareholders_registered' => $shareholders_registered,
            'user' => strtoupper($this->usr->user_fullname),
            'time' => $time,
            'shareholders_attendance' => $shareholders_attendance,
            'proxy_attendance' => $proxy_attendance
        ];

        $html = $this->load->view('export/view_export_pdf_attendance_summary', $data, true); // render the view into HTML

        $this->load->library('pdf');

        $pdf = $this->pdf->load('c', 'A4');

        $pdf->SetFooter(SYSTEM_NAME . ' - Printed by ' . ucwords($this->usr->user_fullname) . '<br/>' . $time . '||Powered By Noxyt Software Solution <br/>www.noxyt.com'); // Add a footer for good measure ;)

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output();
        return;
    }
    
    public function pdfAttendanceReport() {

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)
        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)

        $attendance = $this->shareholder->getAttendace(NULL, ['att.att_year_id' => $this->usr->year_id]);
        $year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);

        $time = date('d-m-Y H:i:s');
        $data = ['attendance' => $attendance, 'year' => $year,'user' => $this->usr->user_fullname,'time' => $time];
        $html = $this->load->view('export/view_export_pdf_attendance', $data, true); // render the view into HTML

        $this->load->library('pdf');

        $pdf = $this->pdf->load('c', 'A4');

        $pdf->SetFooter(SYSTEM_NAME . ' - Printed by ' . ucwords($this->usr->user_fullname) . '<br/>' . $time . '||Powered By Noxyt Software Solution <br/>www.noxyt.com'); // Add a footer for good measure ;)

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output();
        return;
    }
    
    public function pdfProxiesReport() {

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)
        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)

        $proxies = $this->shareholder->getShareholdersProxies(['att.att_year_id' => $this->usr->year_id]);
        $year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);

        $time = date('d-m-Y H:i:s');
        $data = ['proxies' => $proxies, 'year' => $year,'user' => $this->usr->user_fullname,'time' => $time];
        $html = $this->load->view('export/view_export_pdf_proxy', $data, true); // render the view into HTML

        $this->load->library('pdf');

        $pdf = $this->pdf->load('c', 'A4');

        $pdf->SetFooter(SYSTEM_NAME . ' - Printed by ' . ucwords($this->usr->user_fullname) . '<br/>' . $time . '||Powered By Noxyt Software Solution <br/>www.noxyt.com'); // Add a footer for good measure ;)

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output();
        return;
    }

    public function resolutionReport() {

        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }

        $resolutions = $this->resolution->getResolutions(['res_year_id' => $this->usr->year_id, 'res_status <>' => 'PENDING']);

        $choices = $this->resolution->getResolutionChoices(['res.res_year_id' => $this->usr->year_id]);
        $shares_registered = (float) $this->shareholder->getShareRegitered($this->usr->year_id);
        $year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);

        $votes = $this->resolution->getResVotingResult();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'reports/view_report_resolutions',
            'menu_data' => ['curr_menu' => 'REPORTS', 'curr_sub_menu' => 'REPORTS'],
            'content_data' => [
                'module_name' => 'Resolutions Report - ' . $this->session->userdata['logged_in']['user_meeting_year_name'],
                'res_types' => $this->resolution->getResolutionTypes(),
                'resolutions' => $resolutions,
                'votes' => $votes,
                'year' => $year,
                'choices' => $choices,
                'shares_registered' => $shares_registered
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function pdfExportResolutionReport() {

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)
        // Check if user has not logged in and redirect to login page
        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg("Your session may have been expired. Login is required.", 'error', 'user');
        }

        $resolutions = $this->resolution->getResolutions(['res_year_id' => $this->usr->year_id, 'res_status <>' => 'PENDING']);

        $choices = $this->resolution->getResolutionChoices(['res.res_year_id' => $this->usr->year_id]);
        $shares_registered = (float) $this->shareholder->getShareRegitered($this->usr->year_id);
        $year = $this->utl->getMeetingYears(['year_id' => $this->usr->year_id], 1);

        $votes = $this->resolution->getResVotingResult();

        $time = date('m-d-Y H:i:s');

        $data = [
            'res_types' => $this->resolution->getResolutionTypes(),
            'resolutions' => $resolutions,
            'votes' => $votes,
            'year' => $year,
            'choices' => $choices,
            'shares_registered' => $shares_registered,
            'user' => strtoupper($this->usr->user_fullname),
            'time' => $time
        ];

        $html = $this->load->view('export/view_export_pdf_resolution', $data, true); // render the view into HTML


        $this->load->library('pdf');

        $pdf = $this->pdf->load('c', 'A4');

        $pdf->SetFooter(SYSTEM_NAME . ' - Report by ' . ucwords($this->usr->user_fullname) . '<br>' . $time . '|{PAGENO}|Powered By Noxyt Software Solution<br/>www.noxyt.com'); // Add a footer for good measure ;)

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output();
        return;
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
