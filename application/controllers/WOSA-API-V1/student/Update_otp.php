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
     
class Update_otp extends REST_Controller { 
     
    public function __construct() {
      parent::__construct();
      $this->load->database();
      $this->load->model('Student_model');
      $this->load->helper('common'); 
    }

    
    public function index_post()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $student_id = $this->input->get_request_header('STUDENT-ID');
          $send_email_flag = $this->input->get_request_header('SEND-EMAIL-FLAG');
          $mobileData = $this->Student_model->get_student_short($student_id);        
          
          $otp = rand(1000,10000);         
          
          if(base_url()!=BASEURL){
            $params = array('OTP'=>$otp);
            $updated = $this->Student_model->update_student($student_id,$params);
            //$this->_call_smaGateway($mobile,$message);
          }else{
            $params = array('OTP'=>$otp);
            $updated = $this->Student_model->update_student($student_id,$params);
          }
          
          if($send_email_flag ==1){
            // $subject = "Verification code- WOSA";
            // $email_message='Hi, please confirm your details by entering the <b>Verification code '.$otp.'</b> Verification Code is Valid for 10 minutes only Regards '.COMPANY;
            $email_content = otp_send_verification_email($otp);
            $email_message = $email_content['content'];
            $subject = $email_content['subject'];

            $mailData=[]; 
            $mailData['fname']         = $mobileData['fname'];
            $mailData['email']         = $mobileData['email'];               
            $mailData['email_message'] = $email_message;
            $mailData['thanks']        = THANKS;
            $mailData['team']          = WOSA;               
            echo $email = $this->sendEmailTostd_walkinOTP_($subject,$mailData);
        }

         
          if($updated){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=>  "OTP updated"];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "failed", "data"=> "No OTP updated"];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}