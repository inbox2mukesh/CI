<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';    
     
class Submit_error_log extends REST_Controller {
    function __construct()
    {
        error_reporting(1);
        parent::__construct();
        $this->load->database();
        $this->load->model(['Error_log_detail_model']);
    }
    function index_post() {
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
    }else{
        $std_data   = json_decode(file_get_contents('php://input'));     
        $params=array(                         
            'ip_address' => $std_data->ipaddress,            
            'user_agent' => $std_data->useragent,   
            'log_date' => date('Y-m-d H:i:s'),
            'error_log_url' =>$std_data->error_log_url,
        ); 
        return $this->Error_log_detail_model->insert_log($params);
    }

    }

}