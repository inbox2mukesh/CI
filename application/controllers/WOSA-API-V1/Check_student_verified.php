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

class Check_student_verified extends REST_Controller{    
    
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
            $me = $this->input->get_request_header('MOBILE-EMAIL');
            $bData = $this->Student_model->checkStudentVerifiedStatus($me); 
            if(!empty($bData))
            {
                $data['error_message'] = ['is_otp_verified'=>$bData['is_otp_verified']];
            }
            else
            {
              $data['error_message'] = ['is_otp_verified'=>0 ];
            }            
            
        }
        $this->set_response($data, REST_Controller::HTTP_CREATED);        
    }
            
}