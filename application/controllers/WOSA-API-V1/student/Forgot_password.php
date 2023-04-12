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
     
class Forgot_password extends REST_Controller {
    
public function __construct() {
    
    error_reporting(0);
    parent::__construct();
    $this->load->database();
    $this->load->model('Student_model');
    $this->load->helper(['common','foumodule_api']); 
}

    /**
        * enquiry submission from this method.
        *
        * @return Response
    */
    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))){
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            
            $std_data   = json_decode(file_get_contents('php://input'));
            $logData = $this->Student_model->check_std_email_availibility_fp($std_data->email);
            if($logData>0){
                $stdData=$this->Student_model->get_studentId_byEmail($std_data->email);
                $lastId = $stdData['id'];
                if(ENVIRONMENT!='production'){
                    $plain_pwd = PLAIN_PWD;  
                }else{
                    $plain_pwd = $this->_getorderTokens(PWD_LEN);
                }
                $params = array( 
                    'password' => md5($plain_pwd),
                );
                $idd = $this->Student_model->update_student($lastId,$params);
                if($idd){
                    
                    if(base_url()!=BASEURL){
                        $mailData = $this->Student_model->get_student_short($lastId);
                        // $subject = 'Dear User, your password has been reset successfully';
                        // $email_message = 'Dear User, your password has been reset successfully. Your new password are as below:';
                        $email_content = forgot_password_email($plain_pwd);
                        $subject = $email_content['subject'];
                        $email_message = $email_content['content'];
                        $mailData['password']       = $plain_pwd;
                        $mailData['email_message']  = $email_message;
                        $mailData['thanks']         = THANKS;
                        $mailData['team']           = WOSA;
                        $this->sendEmailTostd_creds_($subject,$mailData);
                    }
                    $response_fourmodule = fourmodule_new_password($stdData['UID'],$plain_pwd);
                    $data['error_message'] = [ "success" => 1, "message" => "Your new password has been sent on your email." ];
                        
                }else{
                    $data['error_message'] = [ "success" => 0, "message" => "Oops..failed to generate. Please try again!" , 'data'=>[] ];
                }
                
                
            }else{
                $data['error_message'] = [ "success" => 0, "message" => "You have entered the wrong email, Please try again." ];
            }            
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED); 
    }

    

}//class closed