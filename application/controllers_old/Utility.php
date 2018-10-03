<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utility extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
    }

    public function upload() {

        //set Content-Type to JSON
        header('Content-Type: application/json; charset=utf-8');

        //$this->load->library('resize');
        $type = $this->uri->segment(3);

        $err = FALSE;
        $err_msg = "";
        $data = [];

        switch ($type) {

            case 'IMPORT':

                if ($this->shareholder->getCdsImportedFiles(NULL, ['cds_upload_status' => 'TEMP'], 1)) {
                    $err_msg = 'Multiple files encountered. Please refresh the page';
                    $err = true;
                }

                if (!$this->usr->is_logged_in) {
                    $err_msg = 'Your session might have been expired, pls refresh the page';
                    $err = true;
                }
                $location = "./uploads/imports/";

                $upload_config = [
                    'upload_path' => $location,
                    'allowed_types' => 'xlsx',
                    'max_size' => 1240 * 2,
                    'overwrite' => FALSE,
                    'encrypt_name' => TRUE
                ];

                $data['file_data'] = ['cds_upload_user_id' => $this->usr->user_id, 'cds_upload_status' => 'TEMP', 'cds_upload_year_id' => $this->usr->year_id, 'cds_upload_timestamp' => date('Y-m-d H:i:s')];

                break;
        }

        // Create folder if no exist
        if (!file_exists($location)) {
            mkdir($location, 0777, true);
        }

        $this->upload->initialize($upload_config);

        if (!$this->upload->do_upload('file')) {
            $err_msg = strip_tags($this->upload->display_errors());
            $err = true;
        }

        $upfile = $this->upload->data('file_name');

        if (!$err) {
            http_response_code(200);
            $this->utl->savetempFile($data, $upfile, $type);
            $json = ['status' => 'success', 'filename' => $upfile, 'type' => $type];
        } else {
            http_response_code(401);
            $json = ['status' => 'fail', 'filename' => $upfile, 'error' => $err_msg . $location];
        }


        //echo error message as JSON
        echo json_encode($json);
    }

    public function removeupload($file) {


        $temp_file = $this->utl->getAttachments(['att_name' => $file], 1, ['TEMP', 'TEMP_REPLACE']); //,


        if ($temp_file) {

            $path = './uploads/temp/' . $temp_file['att_name'];

            //Remove Image
            if (file_exists($path)) {
                unlink($path);
            }
            $this->utl->removeFile($temp_file['att_name']);
        }
    }

    public function removeimport($file) {

        if (!$this->usr->is_logged_in) {
            echo json_encode(['status' => ['error' => false]]);
            return;
        }

        $temp_file = $this->shareholder->getCdsImportedFiles(NULL, ['cds_upload_file_path' => $file, 'cds_upload_user_id' => $this->usr->user_id], 1); //,
        if ($temp_file) {
            $path = './uploads/imports/' . $temp_file['cds_upload_file_path'];
            //Remove Image
            if (file_exists($path)) {
                unlink($path);
            }
            $this->utl->removeUploadedImport($temp_file['cds_upload_id']);
        }
        echo json_encode(['status' => ['error' => false]]);
    }

    public function removeuploaded($file_ile) {

        $admin_id = $this->session->userdata['logged_in']['user_admin_id'];

        $temp_file = $this->utl->getUploadedFile($file_ile);


        if ($temp_file) {

            $path = './uploads/' . $admin_id . '/' . $temp_file['hall_attachment_name'];
            $thumb_square_path = './uploads/' . $admin_id . '/thumb_square_' . $temp_file['hall_attachment_name'];
            $thumb_rectangle_path = './uploads/' . $admin_id . '/thumb_rectangle_' . $temp_file['hall_attachment_name'];

            //Remove Image
            if (file_exists($path)) {
                unlink($path);
            }
            //Remove Thumbnauls
            if (file_exists($thumb_square_path)) {
                unlink($thumb_square_path);
            }
            if (file_exists($thumb_rectangle_path)) {
                unlink($thumb_rectangle_path);
            }

            $this->utl->removeUploadedFile($temp_file['hall_attachment_id']);
        }
    }

    public function download() {

        $subscribers = [
                ['user_username' => 'Mike Sange', 'user_name' => 'Mike', 'gender' => 'MALE', 'user_email' => 'mbsanga13@gmail.com', 'user_address' => 'Dar Es Salaam', 'user_job' => 'Programmer']
        ];

        require_once APPPATH . '/third_party/Phpexcel/Bootstrap.php';

        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Webeasystep.com ')
                ->setLastModifiedBy('Ahmed Fakhr')
                ->setTitle('Phpecxel codeigniter tutorial')
                ->setSubject('integrate codeigniter with PhpExcel')
                ->setDescription('this is the file test');

        // add style to the header
        $styleArray = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'top' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'fill' => array(
                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startcolor' => array(
                    'argb' => 'FFA0A0A0',
                ),
                'endcolor' => array(
                    'argb' => 'FFFFFFFF',
                ),
            ),
        );

        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);

        // auto fit column to content
        foreach (range('A', 'F') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
        }
        // set the names of header cells
        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("A2", 'Username')
                ->setCellValue("B2", 'Name')
                ->setCellValue("C2", 'UserEmail')
                ->setCellValue("D2", 'UserAddress')
                ->setCellValue("E2", 'UserJob')
                ->setCellValue("F2", 'Gender');


        // Add some data
        $x = 3;
        foreach ($subscribers as $sub) {
            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("A$x", $sub['user_username'])
                    ->setCellValue("B$x", $sub['user_name'])
                    ->setCellValue("C$x", $sub['gender'])
                    ->setCellValue("D$x", $sub['user_email'])
                    ->setCellValue("E$x", $sub['user_address'])
                    ->setCellValue("F$x", $sub['user_job']);
            $x++;
        }



        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Users Information');

        // set right to left direction
        //$spreadsheet->getActiveSheet()->setRightToLeft(true);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="subscribers_sheet.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Excel2007');
        $writer->save('php://output');
        exit;

        //  create new file and remove Compatibility mode from word title
    }

    public function setList() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Login is required', 'error', 'user/index');
        }

        $cond = ['st_type' => 1];
        $sts = $this->utl->getSetList($cond);

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_settings',
            'menu_data' => [
                'curr_menu' => 'CONFIG',
                'curr_sub_menu' => 'CONFIG'
            ],
            'content_data' => [
                'module_name' => 'System Parameters',
                'sts' => $sts
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function editSet() {


        header('Content-type: text/json');

        if (!$this->usr->isLogedin()) {
            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'pop',
                    "error_msg" => 'Your Session has expired, Please Login again'
                ]
            ]);

            die();
            header('Access-Control-Allow-Origin: *');
        }

        $edit_st_id = $this->uri->segment(3);
        $res = $this->utl->getSetInfo($edit_st_id, 'ID');
        if ($res) {

            echo json_encode([
                'status' => [
                    'error' => FALSE
                ],
                'st_data' => $res
            ]);

            die();
        } else {
            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'pop',
                    "error_msg" => 'Setting not found.'
                ]
            ]);

            die();
        }
    }

    public function submiteditst() {


        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your session has expired, Please login again');
        }

        $validations = [
                ['field' => 'edit_stvalue', 'label' => 'Value', 'rules' => 'trim|required']
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
        } else {

            $st_id = $this->input->post('edit_st_id');
            $st_value = $this->input->post('edit_stvalue');




            $st_data = [
                'st_value' => $st_value
            ];

            $res = $this->utl->saveEditSt($st_data, $st_id);


            if ($res) {
                $this->session->set_flashdata('success', 'Parameter updated successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE
                    ],
                    'url' => site_url('utility/setlist')
                ]);
            } else {
                cus_json_error('Nothing was updated');
            }
        }
    }

    public function submitAddMeetingYear() {


        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your session has expired, Please login again');
        }


        $opened_year = $this->utl->getMeetingYears(['year_status' => 'OPENED'], 1);

        if ($opened_year) {
            cus_json_error('Close the OPENED meeting year before adding the new one');
        }

        $validations = [
                ['field' => 'year_name', 'label' => 'Year Name', 'rules' => 'trim|required|is_unique[' . $this->db->dbprefix . 'years.year_name]'],
                ['field' => 'meeting_date', 'label' => 'Meeting Date', 'rules' => 'trim|required|callback_validateMeetingDate'],
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
        } else {

            $year_data = [
                'year_name' => $this->input->post('year_name'),
                'year_status' => 'OPENED',
                'year_meeting_date' => date('Y-m-d', strtotime($this->input->post('meeting_date')))
            ];

            $res = $this->utl->saveYear(['year_data' => $year_data]);


            if ($res) {
                $this->session->set_flashdata('success', 'Meeting year added successfully successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => TRUE,
                        'redirect_url' => site_url('utility/meetingyears')
                    ]
                ]);
                die();
            } else {
                cus_json_error('Meeting year not added, Refresh the page and try again');
            }
        }
    }

    public function validateMeetingDate($date) {

        $year = (int) $this->input->post('year_name');


        if (empty($date) OR empty($year)) {
            return TRUE;
        }

        $date = (int) date('Y-m-d', strtotime($date));

        if ($date !== $year) {
            $this->form_validation->set_message('validateMeetingDate', 'Date should be from above selected year');
            return FALSE;
        }

        return TRUE;
    }

    public function closeYear() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Login is required', 'error', 'user/index');
        }


        $year_id = $this->uri->segment(3);

        $year = $this->utl->getMeetingYears(['year_id' => $year_id], 1);

        if (!$year) {
            $this->usr->setSessMsg('Meeting year was not found or it may have been removed', 'error', 'utility/meetingyears');
        }

        $res = $this->utl->updateMeetingYear(['year_status' => 'CLOSED'], $year['year_id']);

        if ($res) {
            log_message(SYSTEM_LOG, 'utility/closeYear' . $this->usr->user_email . ' '.$this->input->ip_address().'Closed meeting year : ' . $year['year_id']);
            $this->usr->setSessMsg('Meeting year ' . $year['year_name'] . ' closed successfully', 'success', 'utility/meetingyears');
        } else {
            $this->usr->setSessMsg('Year status was not changed', 'success', 'utility/meetingyears');
        }
    }

    public function meetingYears() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Login is required', 'error', 'user/index');
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_meeting_years',
            'menu_data' => [
                'curr_menu' => 'CONFIG',
                'curr_sub_menu' => 'CONFIG'
            ],
            'content_data' => [
                'module_name' => 'Meeting Years',
                'years' => $this->utl->getMeetingYears(),
                'year_id' => $this->usr->year_id
            ],
            'modals_data' => ['modals' => ['modal_add_meeting_year']],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function outgoingSMS() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Login is required', 'error', 'user/index');
        }

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_outgoing_sms',
            'menu_data' => [
                'curr_menu' => 'CONFIG',
                'curr_sub_menu' => 'CONFIG'
            ],
            'content_data' => [
                'module_name' => 'Outgoing SMS',
                'years' => $this->utl->getMeetingYears()
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function reSendSms() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Login is required', 'error', 'user/index');
        }

        $id = $this->uri->segment(3);

        if ($this->utl->reSendSms($id)) {
            $this->usr->setSessMsg('Sms reset successfully', 'success', 'utility/outgoingsms');
        } else {
            $this->usr->setSessMsg('Sms not reset successfully', 'error', 'utility/outgoingsms');
        }
    }

    public function ajaxOutgoingSms() {

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

        $data = [];
        $list = $this->utl->get_datatables_outgoing_sms([]);
        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = array();

            $status = "";
            $link = "";

            if ($a->IsSent == 1) {
                $status = '<h4><span class="badge badge-success">SENT</span></h4>';
                $link = '<a class="btn btn-sm btn-outline-info confirm" title="resend this sms" href="' . site_url('utility/resendsms/' . $a->Id) . '"><i class="fa fa-refresh"></i></a>';
            } else {
                $status = '<h4><span class="badge badge-success">PENDING</span></h4>';
            }

            $row[] = $no;
            $row[] = $a->MessageTo;
            $row[] = $a->MessageFrom;
            $row[] = $a->MessageText;
            $row[] = $status;
            $row[] = $link;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->utl->count_all_outgoing_sms([]),
            "recordsFiltered" => $this->utl->count_filtered_outgoing_sms([]),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function switchYear() {

        if (!$this->usr->is_logged_in) {
            $this->usr->setSessMsg('Your session may have been expired. Login is required', 'error', 'user/index');
        }

        $year_id = $this->uri->segment(3);

        $year = $this->utl->getMeetingYears(['year_id' => $year_id], 1);

        if (!$year) {
            $this->usr->setSessMsg('Year was not found or may have been removed form the system', 'error', 'utility/meetingyears');
        }

        $res = $this->usr->saveEditUser(['usr_last_selected_year' => $year['year_id']], $this->usr->user_id);

        if ($res) {
            $this->session->userdata['logged_in']['user_meeting_year_id'] = $year['year_id'];
            $this->session->userdata['logged_in']['user_meeting_year_name'] = $year['year_name'];
            $this->usr->setSessMsg('System year switched to '.$year['year_name'].' successfully', 'success', 'user/dashboard');
        } else {
            $this->usr->setSessMsg('Something went wrong, Please try again', 'error', 'utility/meetingyears');
        }
    }
    

}
