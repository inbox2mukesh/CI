<?php
/**
 * @package         Fourmodule
 * @subpackage      Check user
 * @author          Harpreet Rattu
 *
 **/
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';   
     
class Checkuserexists_api extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        // $this->load->database();        
        // $this->load->model('Student_package_model');
    } 
    
    public function index_get()
    {
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
          $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $id = $this->input->get_request_header('STUDENT-ID');
          $test_module_id = $this->input->get_request_header('TEST-MODULE-ID');
          $programe_id = $this->input->get_request_header('PROGRAME-ID');
          //FOURMODULE_URL
        //   $data = $this->Student_package_model->identify_api($id,$test_module_id,$programe_id);
        
        /*   if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Pack found!", "data"=> $bData];     
          } */
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}