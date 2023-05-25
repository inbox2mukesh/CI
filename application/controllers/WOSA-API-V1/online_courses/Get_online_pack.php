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
     
class Get_online_pack extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();        
        $this->load->model('Package_master_model');
    }

    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
          $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $test_module_id = $this->input->get_request_header('TEST-MODULE-ID');
          $programe_id = $this->input->get_request_header('PROGRAME-ID');
          $category_id = $this->input->get_request_header('CATEGORY-ID');
          $duration = $this->input->get_request_header('DURATION');
          $country_id = $this->input->get_request_header('COUNTRY-ID');
          $limit = $this->input->get_request_header('LIMIT');
          $offset = $this->input->get_request_header('OFFSET'); 
          $course_type = $this->input->get_request_header('COURSE-TYPE'); 
          // $this->auto_loadCaching(CACHE_ENGINE);
          $bData = $this->Package_master_model->Get_online_pack($test_module_id,$programe_id,$category_id,$duration,$country_id,$course_type,$limit,$offset);
          // $this->auto_cacheOff();  
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Pack found!", "data"=> $bData];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}