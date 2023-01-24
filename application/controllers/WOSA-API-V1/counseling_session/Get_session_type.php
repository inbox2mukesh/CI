<?php
/**
 * @package         WOSA
 * @subpackage      ........
 * @author          Navjeet
 *
 **/
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';   
     
class Get_session_type extends REST_Controller {  
     
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
          $bData = $this->Counseling_session_model->getSessionType();
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];   
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No session found!", "data"=> $bData];     
          }        
          
      }
      $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}