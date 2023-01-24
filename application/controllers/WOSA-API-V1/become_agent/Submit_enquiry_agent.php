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
     
class Submit_enquiry_agent extends REST_Controller {
    
public function __construct() {
    
    error_reporting(0);
    parent::__construct();
    $this->load->database();
    $this->load->model('Become_agent_model');
    $this->load->library('email');
    $this->email->set_mailtype("html");
    $this->email->set_newline("\r\n");    
}

public function index_post()
{        
   if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
    }else{
        $std_data   = json_decode(file_get_contents('php://input')); 
        $name=$std_data->fname.' '.$std_data->lname;
        $email=$std_data->email;
        $booking_id=$this->Become_agent_model->booking_detail_save($std_data);
        if($booking_id){           
            $subject = 'Hi! your enquiry sent successfully';
            $email_message='Thank you for contacting us. Our team will get in touch with you soon.';
            $mailData['fname']          = $name;                
            $mailData['email']          = $email;
            $mailData['email_message']  = $email_message;
            $mailData['thanks']         = THANKS;
            $mailData['team']           = WOSA;
            $this->sendEmail_enquiry_($subject,$mailData);	
            $data['error_message'] = [ "success" => 1, "message" => "success", 'data'=>1 ];
            $this->set_response($data, REST_Controller::HTTP_CREATED);  		
        }else{          
            $data['error_message'] = [ "success" => 0, "message" => "Oops..Failed to send enquiry! try again.", 'data'=>0 ];
        }
        $this->set_response($data, REST_Controller::HTTP_CREATED);        
       
    }           
    
}


}//class closed