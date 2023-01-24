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
class Get_all_mock_report extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database(); 
        $this->load->model('Mock_test_model');
        $this->load->model('Student_model');
    }      
    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))){            
          $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
          
        }else{
          $id = $this->input->get_request_header('STUDENT-ID');
          $UIDdata = $this->Student_model->get_UID($id);
          $UID = $UIDdata['UID'];
          $ieltsData = $this->Mock_test_model->get_all_mt_report_ielts($UID);
          $pteData = $this->Mock_test_model->get_all_mt_report_pte($UID); 
          $toeflData = $this->Mock_test_model->get_all_mt_report_toefl($UID);

          $bData = array_merge($ieltsData, $pteData, $toeflData);

          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Test found!", "data"=> $bData];     
          } 
        }       
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}