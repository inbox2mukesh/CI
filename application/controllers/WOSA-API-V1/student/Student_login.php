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
     
class Student_login extends REST_Controller {
    
    public function __construct() {
        
        error_reporting(0);
        parent::__construct();
        $this->load->database();
        $this->load->model('Student_model');
        $this->load->helper('cookie');
    }
    
    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            
            $std_data = json_decode(file_get_contents('php://input'));
            $logData  = $this->Student_model->check_studentLogin($std_data->username,$std_data->password);
            if($logData>0){
                $studentId = $this->Student_model->get_studentId($std_data->username,$std_data->password);             
                $params = array(                                
                    'loggedIn' => 1,
                    'is_email_verified'=>1,
                );
                session_regenerate_id();
                // Multiple Login Checking    // Added by Vikram 6 dec 2022
                $token = $this->_getorderTokens(8);   
                $checkTokenCount = $this->Student_model->checkTokenCount($studentId['id']);
                if($checkTokenCount>0){
                    $params_token = array('token'=> $token);
                    $this->Student_model->updateStudentToken($studentId['id'],$params_token);
                }else{
                    $params_token = array('token'=> $token,'student_id'=>$studentId['id']);
                    $this->Student_model->addStudentToken($params_token);
                }

                $idd = $this->Student_model->update_student($studentId['id'],$params);
                $studentInfo = $this->Student_model->get_studentfull_profile($studentId['id']);
              //  $studentInfo['token'] = $token;
                if( $studentInfo['profileUpdate'] == 0)
                {
                    $data['error_message'] = ["success" =>1,"message" =>"Please Verify and Update your Details to continue further." , 'data'=> $studentInfo ];
                }
                else {
                    $data['error_message'] = ["success" =>1,"message" =>"Loggedin successfully." , 'data'=> $studentInfo ];
                }

            }else{
                $data['error_message'] = ["success" => 0,"message" =>"You have entered the wrong username and password, Please try again." , 'data'=>[] ];
            }            
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED); 
    }

}//class closed