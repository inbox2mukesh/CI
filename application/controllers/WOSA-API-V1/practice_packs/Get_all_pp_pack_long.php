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
     
class Get_all_pp_pack_long extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();        
        $this->load->model('Practice_package_model');
    }       
    /**
     * Get All branches for at enquiry from this method.
     *
     * @return Response
    */
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{ 
            $country_id = $this->input->get_request_header('COUNTRY-ID');
            $test_module_id = $this->input->get_request_header('TEST-MODULE-ID');
            $programe_id = $this->input->get_request_header('PROGRAME-ID');           
            $duration = $this->input->get_request_header('DURATION');
            $limit = $this->input->get_request_header('LIMIT');
            $offset = $this->input->get_request_header('OFFSET');
            $category_id = $this->input->get_request_header('CATEGORY-ID');
           
          $bData = $this->Practice_package_model->get_all_package_active($country_id,$test_module_id,$programe_id,$duration,$limit,$offset,$category_id);
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Pack found!", "data"=> $bData];     
          } 
         }      
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}