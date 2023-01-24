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
     
class Get_mock_report_data extends REST_Controller {  
     
    public function __construct(){

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
          $report_id = $this->input->get_request_header('REPORT-ID');
          $test_module_name = $this->input->get_request_header('TEST');
          $UIDdata = $this->Student_model->get_UID($id);
          $UID = $UIDdata['UID'];
          
          if($test_module_name==IELTS or $test_module_name==IELTS_CD){
              $bData = $this->Mock_test_model->get_mt_report_data_ielts($report_id,$UID);              
          }elseif($test_module_name==PTE){
              $bData = $this->Mock_test_model->get_mt_report_data_pte($report_id,$UID);
          }elseif($test_module_name==TOEFL){
              $bData = $this->Mock_test_model->get_mt_report_data_toefl($report_id,$UID);
          }else{
            $bData = [];
          }
          $bData['test_module_name'] = $test_module_name;
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No data found!", "data"=> $bData];     
          } 
        }       
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}