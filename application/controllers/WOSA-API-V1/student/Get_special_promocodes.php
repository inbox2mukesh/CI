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
     
class Get_special_promocodes extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();        
        //$this->load->model('Discount_model');
        $this->load->model('Student_model');
    }

    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
          $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $student_id = $this->input->get_request_header('STUDENT-ID');
          $aData = $this->Student_model->get_student_info_forSMS($student_id);
          $mobile = $aData['mobile'];
          $email = $aData['email'];
          $bData = $this->Discount_model->getSpecialPromocodes($mobile,$email);
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No promocode found!", "data"=> $bData];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}