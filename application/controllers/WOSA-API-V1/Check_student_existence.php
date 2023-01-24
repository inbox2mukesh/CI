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

class Check_student_existence extends REST_Controller{    
    
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
            $mobile = $this->input->get_request_header('MOBILE');
            $email = $this->input->get_request_header('EMAIL');
            $bData = $this->Student_model->checkStudentExistence($mobile,$email); 
            if(!empty($bData)){
                $data['error_message'] = [ "success" => 1, "message" => "existing", 'student_id' => $bData['id'], 'active' => $bData['active'], 'fresh' => $bData['fresh'], 'is_otp_verified'=>$bData['is_email_verified'] ];
            }else{
              $data['error_message'] = [ "success" => 0, "message" => "fresh", 'student_id' => null, 'active' => null, 'fresh' => null, 'is_otp_verified'=>null ];
            }            
            
        }
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
            
}