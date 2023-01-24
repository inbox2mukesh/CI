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
     
class Get_class_schedule_short extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();
        $this->load->model('Online_class_schedule_model');
    }
    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $id = $this->input->get_request_header('ID');
          $classroom_id = $this->input->get_request_header('CLASSROOM-ID');

          $current_DateTime = date("d-m-Y G:i:00");
          $current_DateTimeStr = strtotime($current_DateTime);
         
         $current_DateTimeStr_after = $current_DateTimeStr-3600;
        $this->Online_class_schedule_model->deactivate_classshedule($current_DateTimeStr,$classroom_id);
          $bData = $this->Online_class_schedule_model->get_weekly_schedule($current_DateTimeStr_after,$classroom_id);
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No classes found!", "data"=> $bData];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}