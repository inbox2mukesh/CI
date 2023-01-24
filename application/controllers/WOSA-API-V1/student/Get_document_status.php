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
     
class Get_document_status extends REST_Controller {  
     
    public function __construct() {
      parent::__construct();
      $this->load->database();        
      $this->load->model('Student_model');
    } 
    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $student_id = $this->input->get_request_header('STUDENT-ID');
          $bData = $this->Student_model->RTdocFieldDisplay($student_id);

          if($bData>0){
            $data['error_message'] = [ "success" => 1, "message" => "success", "docStatus"=> 1];
          }else{
             $data['error_message'] = [ "success" => 1, "message" => "success", "docStatus"=> 0];
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}