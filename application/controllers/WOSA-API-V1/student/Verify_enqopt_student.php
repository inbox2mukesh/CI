<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          
 *
 **/
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';    
     
class Verify_enqopt_student extends REST_Controller {
    
    public function __construct() {
        
        error_reporting(0);
        parent::__construct();
        $this->load->database();
        $this->load->model('Student_enquiry_model');
        $this->load->helper('common'); 
    }

    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            $enquiry_id = $this->input->get_request_header('ENQ-ID');
            $otp = $this->input->get_request_header('ENQ-OTP');
            $std_data   = json_decode(file_get_contents('php://input'));          
            $DBotp = $this->Student_enquiry_model->getOTP($enquiry_id);           
            if($DBotp['OTP']==$otp) {               
                    $idd = $this->Student_enquiry_model->update_enquiry($enquiry_id, $std_data);               
                    if($idd){
                        
                        $enqData = $this->Student_enquiry_model->get_enquiry_data($enquiry_id);
                        // $subject = 'Hi! your enquiry sent successfully';
                        // $email_message = "Hi! your enquiry sent successfully at our Enquiry team.<br> Your Enquiry Id:$enqData[enquiry_no].<br> We will get back to soon.";
                        $enquiry_content = enquiry_email($enqData['enquiry_no']);
                        $subject = $enquiry_content['subject'];
                        $email_message = $enquiry_content['content'];

                        $mailData['fname']          = $enqData['fname'];                
                        $mailData['email']          = $enqData['email'];
                        $mailData['email_message']  = $email_message;
                        $mailData['thanks']         = THANKS;
                        $mailData['team']           = WOSA;                    
                        $this->sendEmail_enquiry_($subject,$mailData);
                        $data['error_message'] = [ "success" => 1, "message" => "success",'data'=>$enqData['id']];
                            
                    }else{
                        $data['error_message'] = [ "success" => 2, "message" => "Oops..failed to update. Please try again!",'data'=>''];
                    }

                }else{
                    $data['error_message'] = [ "success" => 0, "message" => "Ohh..Wrong Verification code entered! Please try again!"  ];
                }
            //$this->set_response($data, REST_Controller::HTTP_CREATED); 
            
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED);     
        
    }

    

}//class closed