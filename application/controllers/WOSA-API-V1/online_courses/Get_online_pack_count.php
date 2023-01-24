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
     
class Get_online_pack_count extends REST_Controller {  
     
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
          $data = $this->Package_master_model->Get_online_pack_count($test_module_id,$programe_id,$category_id,$duration,$country_id,$limit,$offset);
         
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}