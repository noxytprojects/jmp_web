<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utility extends CI_Controller {

    var $extended = null;
    public function __construct() {
        parent::__construct();
        $this->load->library('upload');
    }
    
    
    public function removeUpload() {
        
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');
        
        
        $att_id = $this->uri->segment(3);
        $type = $this->uri->segment(4);
        $path = "";
        
        
        switch ($type) {
            case 'DRIVER_LICENSE':
                $attachment  = $this->utl->getAttachments(NULL, ['att.att_type' => $type,'att.att_id' => $att_id], 1);
                $path = FCPATH . 'uploads/license/';
                break;
            
            case 'MEDICAL_FITNESS':
                $attachment  = $this->utl->getAttachments(NULL, ['att.att_type' => $type,'att.att_id' => $att_id], 1);
                $path = FCPATH . 'uploads/medical/';
                break;
            
            case 'TRIP_REQUEST':
                $attachment  = $this->utl->getAttachments(NULL, ['att.att_type' => $type,'att.att_id' => $att_id], 1);
                $path = FCPATH . 'uploads/request/';
                break;


            default:
                $attachment = FALSE;
                break;
        }
        
        
        
        if(!$attachment){
            cus_json_error('Cant remove file');
        }
        
        $path .= $attachment['att_name'];
        
        log_message(SYSTEM_LOG, $path);
        
        $res = $this->utl->removeFile($attachment['att_id']);
        
        
        if(!$res){
            cus_json_error('File not removed');
        }
        
        if(file_exists($path)){
            unlink($path);
        }
        
        echo json_encode(['status' => ['error' => FALSE]]);
        
    }
    public function upload() {

        //set Content-Type to JSON
        header('Content-Type: application/json; charset=utf-8');

        $type = $this->uri->segment(3);
        $reference = $this->uri->segment(4);

        /*
          if (!$this->usr->is_logged_in ) {

          $_POST = json_decode(file_get_contents('php://input'), true);

          $err = TRUE;
          $err_msg = MSG_EXPIRY_SESSION;
          } */

        //$this->load->library('resize');

        
        $err = FALSE;
        $err_msg = "";
        $user_id = 0;

        switch ($type) {

            case 'PTW_REQUEST':

                $location = "./uploads/ptw/";
                $upload_config = [
                    'upload_path' => $location,
                    'allowed_types' => 'jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|pptx',
                    'max_size' => 1240 * 2,
                    'overwrite' => FALSE,
                    'encrypt_name' => TRUE
                ];
                $user_id = $reference;
                $reference= NULL;
                
                break;

            case 'CLOSURE_ATTACHMENT':

                $permit = $this->permit->getPermitDetails(NULL, ['p_id' => $reference], 1);

                if (!$permit) {
                    $err = TRUE;
                    $err_msg = 'Permit was not found or may have been removed from the system';
                }

                $location = "./uploads/ptw/";
                $upload_config = [
                    'upload_path' => $location,
                    'allowed_types' => 'jpg|png|jpeg',
                    'max_size' => 1240 * 2,
                    'overwrite' => FALSE,
                    'encrypt_name' => TRUE
                ];
                $reference = $permit['p_id'];
                $user_id = $permit['p_user_id'];
                break;

            default:
                $location = "./uploads/temp/";
                $upload_config = [
                    'upload_path' => $location,
                    'allowed_types' => '*',
                    'max_size' => 1240 * 2,
                    'overwrite' => FALSE,
                    'encrypt_name' => TRUE
                ];
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
            $data = [
                'file_data' => [
                    'att_type' => $type,
                    'att_name' => $upfile,
                    'att_timestamp' => date('Y-m-d H:i:s'),
                    'att_og_name' => 'test',
                    'att_ref' => $reference,
                    'att_ad_name' => $user_id
                ]
            ];

            $res = $this->utl->savetempFile($data);

            if (!$res) {
                http_response_code(401);
                $json = ['status' => 'fail', 'filename' => $upfile, 'error' => 'File was not saved, please try again'];
            } else {
                http_response_code(200);
                $json = [
                    'status' => 'success',
                    'filename' => $upfile,
                    'type' => $type,
                    'att_id' => $res,
                    'att_type' => $type,
                    'attachments' => $this->utl->getAttachments(NULL, ['att.att_ref' => $reference, 'att.att_type' => $type])
                ];
            }
        } else {
            http_response_code(401);
            $json = ['status' => 'fail', 'filename' => $upfile, 'error' => $err_msg];
        }


        //echo error message as JSON
        echo json_encode($json);
    }

    public function apiDeleteUploadedFile() {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $user_id = $this->input->post('user_id');
        $att_id = $this->input->post('att_id');
        $att_type = $this->input->post('att_type');
        $ref = null;
        $path = "";


        switch ($att_type) {
            case 'CLOSURE_ATTACHMENT':
                $attachment = $this->utl->getAttachments(NULL, ['att.att_type' => $att_type, 'att.att_id' => $att_id], 1);
                $ref = $attachment['att_ref'];
                $path = FCPATH . 'uploads/ptw/';
                break;


            default:
                $attachment = FALSE;
                break;
        }


        if (!$attachment) {
            cus_json_error('Cant remove file');
        }

        $path .= $attachment['att_name'];

        log_message(SYSTEM_LOG, $path);

        $res = $this->utl->removeFile($attachment['att_id']);


        if (!$res) {
            cus_json_error('File not removed');
        }

        if (file_exists($path)) {
            unlink($path);
        }

        $json = [
            'status' => [
                'error' => FALSE,
            ],
            'attachments' => $this->utl->getAttachments(NULL, ['att.att_type' => $att_type, 'att.att_ref' => $ref])
        ];
        echo json_encode($json);
        die();
    }

    public function removeUploadBk() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');


        $att_id = $this->uri->segment(3);
        $type = $this->uri->segment(4);
        $path = "";


        switch ($type) {
            case 'CLOSURE_ATTACHMENT':
                $attachment = $this->utl->getAttachments(NULL, ['att.att_type' => $type, 'att.att_id' => $att_id], 1);
                $path = FCPATH . 'uploads/ptw/';
                break;


            default:
                $attachment = FALSE;
                break;
        }



        if (!$attachment) {
            cus_json_error('Cant remove file');
        }

        $path .= $attachment['att_name'];

        log_message(SYSTEM_LOG, $path);

        $res = $this->utl->removeFile($attachment['att_id']);


        if (!$res) {
            cus_json_error('File not removed');
        }

        if (file_exists($path)) {
            unlink($path);
        }

        echo json_encode(['status' => ['error' => FALSE]]);
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

    public function removeTempFiles($uploads) {
        foreach ($uploads as  $upload) {
            $path = './uploads/request/' . $upload['att_name'];
            //Remove Image
            if (file_exists($path)) {
                unlink($path);
            }
            $this->removeFile($upload['att_id']);
        }
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
                'curr_menu' => 'MANAGEMENT',
                'inbox_count' => $this->usr->getInbox(),
                'curr_sub_menu' => 'MANAGEMENT',
                'inbox_count' => $this->usr->getInbox(),
                'extended_count' => count($this->extended)
            ],
            'content_data' => [
                'module_name' => 'System Parameters',
                'sts' => $sts
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => ['inbox' => $this->usr->getInbox(),]
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

    public function validateUserTitle($title) {

        if (empty($title)) {
            return TRUE;
        }

        if (!in_array($title, USER_TITLE)) {
            $this->form_validation->set_message(__FUNCTION__, 'Enter a valid user title');
            return FALSE;
        }

        return TRUE;
    }

    public function submiteditst() {


        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $st_id = $this->input->post('edit_st_id');

        $setting = $this->utl->getSetInfo($st_id);

        if (!$setting) {
            cus_json_error('Setting was not available, contact system developer');
        }

        $validations = !empty($setting['st_validation']) ? $setting['st_validation'] : 'trim|required';

        if (!$this->usr->is_logged_in) {
            cus_json_error('Your session has expired, Please login again');
        }

        $validations = [
            ['field' => 'edit_stvalue', 'label' => 'Value', 'rules' => $validations]
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

    // App status

    public function getApiUrl() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        echo json_encode([
            'status' => ['error' => FALSE],
            'api_url' => API_URL
        ]);
    }

    public function checkIfAppIsLatest() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $_POST = json_decode(file_get_contents('php://input'), true);

        $app_is_latest = TRUE;

        $app_platform = $this->input->post('app_platform');
        $current_app_version = strtolower($app_platform) == 'ios' ? $this->utl->getSetValue('CURRENT_APP_VERSION_IOS') : $this->utl->getSetValue('CURRENT_APP_VERSION_ANDROID');



        $app = [
            'app_name' => $this->input->post('app_name'),
            'app_version_code' => $this->input->post('app_version_code'),
            'app_version' => $this->input->post('app_version'),
            'app_package_name' => $this->input->post('app_package_name')
        ];


        if (version_compare($current_app_version, $app['app_version']) > 0) {
            $app_is_latest = FALSE;
        }

        $json = json_encode([
            'status' => ['error' => FALSE],
            'app_status' => [
                'app_is_latest' => $app_is_latest,
                'app_package_name' => APP_PACKAGE_NAME,
                'app_id' => ''
            ],
            'current_app_version' => $current_app_version,
            'platform' => $app_platform
        ]);

        log_message(SYSTEM_LOG, 'Checking app version ... FROM: ' . $json);

        echo $json;
        die();
    }


}
