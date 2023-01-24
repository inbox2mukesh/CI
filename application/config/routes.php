<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$route['default_controller'] = 'login';
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

$route['make-stripe-payment'] = "booking";
$route['handlePayment']['post'] = "booking/handlePayment";



if(CheckEventUrl()){
	
	$route['(:any)'] = "Book_events/index/$1";
}
function CheckEventUrl(){
	#pr($_SERVER);
	$source_dir =APPPATH . 'controllers';
	$_filedata = array();
	if (is_dir($source_dir)) {
		if ($dh = opendir($source_dir)) {
			$i=0;
			while(($file = readdir($dh)) !== false) {
				if($file !='.' && $file !='..'){
					$file=str_replace('.php','',$file);
					$_filedata[]=strtolower($file);
				}
			}
			closedir($dh);
		}
	}
	$REQUEST_URI=isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI']:'';
	#pr($_filedata);
	if(!empty($REQUEST_URI)){
		
		$REQUEST_URI_ARRAY=explode('/',$REQUEST_URI);
		#pr($REQUEST_URI_ARRAY,1);
		$controller_name=$REQUEST_URI_ARRAY[2];
		//$REDIRECT_QUERY_STRING=strtolower($REDIRECT_QUERY_STRING);
		if(in_array($controller_name,$_filedata)){
			return false;
		}
		return true;
	}
	return false;
}












