<?php
/**
 * @package         WOSA
 * @subpackage      ....
 * @author          Navjeet
 *
 **/
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';   
     
class Get_final_session extends REST_Controller {  
     
    public function __construct() {
      error_reporting(0);
      parent::__construct();
      $this->load->database();        
      $this->load->model('Counseling_session_model');
    } 

    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $session_type = $this->input->get_request_header('SESSION-TYPE');          
          $date = $this->input->get_request_header('DATE-ID');
          $time_slot = $this->input->get_request_header('TIME-SLOT');
         
          $bData=$this->Counseling_session_model->Get_final_session($session_type,$date,$time_slot);
          
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];   
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No time slot found!", "data"=> $bData];
          }        
          
      }
      $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
} 