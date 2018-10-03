<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pdf {


	function Pdf()

	{

		$CI = & get_instance();

		log_message('Debug', 'mPDF class is loaded.');

	}


	function load($param=NULL, $file_size = NULL)

	{

		include_once APPPATH.'/third_party/mpdf/mpdf.php';


		if ($param == NULL)

		{

			$param = '"en-GB-x","A4","","",10,10,10,10,6,3';

		}
                
                if($file_size == NULL){
                    $file_size = 'A4';
                }


		return new mPDF($param, $file_size);

	}

}
