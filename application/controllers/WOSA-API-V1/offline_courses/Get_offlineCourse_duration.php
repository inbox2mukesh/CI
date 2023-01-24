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
     
class Get_offlineCourse_duration extends REST_Controller {  
     
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
          $country_id = $this->input->get_request_header('COUNTRY-ID');
          $bData = $this->Package_master_model->Get_offlineCourse_duration($country_id);
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Course duration found!", "data"=> $bData];     
          }  
        }      
        $this->set_response($data, REST_Controller::HTTP_CREATED);        
    }
        
}