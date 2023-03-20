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
     
class Verify_student extends REST_Controller {
    
    public function __construct() {
        
        error_reporting(0);
        parent::__construct();
        $this->load->database();
        $this->load->model('Student_model');
    }

    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            $lastId = $this->input->get_request_header('LAST-ID');
            $std_data   = json_decode(file_get_contents('php://input'));
            
            $user_otp = $std_data->otp;
            $OTPdata = $this->Student_model->getOTP($lastId);
            $db_otp = $OTPdata['OTP'];

            if($user_otp==$db_otp){ 
                if(ENVIRONMENT!='production'){
                    $plain_pwd = PLAIN_PWD;  
                }else{
                    $plain_pwd = $this->_getorderTokens(PWD_LEN);
                }  
                if (DEFAULT_COUNTRY == 101) //india
                {
                    $params = array(                                
                        'active' => 1,
                        'is_otp_verified'=>1,
                        'loggedIn'=>1,
                        'password' => md5($plain_pwd),
                    );   
                }
                else {// other countries
                    $params = array(                                
                        'active' => 1,
                        'is_email_verified'=>1,
                        'loggedIn'=>1,
                        'password' => md5($plain_pwd),
                    );
                }
                
               
                $idd = $this->Student_model->update_student($lastId,$params);                  
                if($idd==1){
                    
                    $studentInfo = $this->Student_model->get_student($lastId);
                    $username=$studentInfo['username'];
                    $message='Hi, you have successfully registered on westernoverseas.online Unique ID: '.$username.' Password: '.$plain_pwd.' Regards '.COMPANY;
                   //$this->_call_smaGateway($studentInfo['mobile'],$message);

                    if(base_url()!=BASEURL){
                        $subject = 'Dear '.$studentInfo['fname'].', you are registered successfully at '.COMPANY.'';
                        $email_message = 'You are registered successfully at '.COMPANY.' Your details are as below:';
                        $mailData  = $this->Student_model->getMailData_forReg($lastId);
                        $mailData['UID']            = $mailData['UID'];
                        $mailData['password']       = $plain_pwd;
                        $mailData['email_message']  = $email_message;
                        $mailData['thanks']         = THANKS;
                        $mailData['team']           = WOSA;
                        $this->sendEmailTostd_creds_($subject,$mailData);
                    }

                    if (DEFAULT_COUNTRY == 101) //india
                    {

                    $data['error_message'] = [ "success" => 1, "message" => "Dear User, Your Mobile verified and you are registered successfully. Please check your email/mobile for more information." , 'data'=> $studentInfo];
                    }
                    else {
                        $data['error_message'] = [ "success" => 1, "message" => "Dear User, Your Email verified and you are registered successfully. Please check your email for more information." , 'data'=> $studentInfo];
                    }
                        
                }else{
                    $data['error_message'] = [ "success" => 3, "message" => "Oops..failed to register. Please try again!" , 'data'=>[] ];
                }

            }else{
                $data['error_message'] = [ "success" => 0, "message" => "Ohh..Wrong Verification code entered! Please try again!" , 'data'=>[]  ];
            }
            //$this->set_response($data, REST_Controller::HTTP_CREATED); 
            
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED);     
        
    }

    

}//class closed