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
     
class Get_pp_category extends REST_Controller {  
     
    public function __construct() {
      parent::__construct();
      $this->load->database();        
      $this->load->model('Practice_package_model');
    }

    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $test_module_id = $this->input->get_request_header('TEST-MODULE-ID');
          $programe_id = $this->input->get_request_header('PROGRAME-ID');
          $duration = $this->input->get_request_header('DURATION');
          
          $bData = $this->Practice_package_model->Get_onlineCourse_category($test_module_id,$programe_id,$duration);
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Course module found!", "data"=> $bData];     
          }  
        }      
        $this->set_response($data, REST_Controller::HTTP_CREATED);        
    }      
}