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
     
class Submit_enquiry extends REST_Controller {
    
public function __construct() {
    
    error_reporting(0);
    parent::__construct();
    $this->load->database();
    $this->load->model('Student_enquiry_model');
    $this->load->library('email');
    $this->email->set_mailtype("html");
    $this->email->set_newline("\r\n");    
    $this->load->helper('common'); 
}

public function index_post()
{        
   if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
    }else{
        $std_data   = json_decode(file_get_contents('php://input'));   
        $sendemail_flag=$this->input->get_request_header('SENDEMAIL-FLAG');    
        $enquiry_no=$this->_getorderTokens(12);    
        $params=array(                         
            'enquiry_purpose_id' => $std_data->enquiry_purpose_id,            
            'student_id' => $std_data->student_id,            
            'message' =>$std_data->message,            
            'todayDate' =>$std_data->todayDate,            
            'enquiry_no' =>$enquiry_no,            
        );    
        
        $enquiry_id = $this->Student_enquiry_model->add_enquiry($params); 
        if($enquiry_id){
           
            $enqData = $this->Student_enquiry_model->get_enquiry_data($enquiry_id);
           
           if($sendemail_flag == 1){
            // $subject = 'Hi, Your enquiry sent successfully';
            // $email_message = "Hi, Your enquiry sent successfully at our Enquiry team.<br><b>Enquiry ID</b>: $enquiry_no.<br> We will get back to you soon.";
            $enquiry_content = enquiry_email($enquiry_no);
            $subject = $enquiry_content['subject'];
            $email_message = $enquiry_content['content'];
            $mailData['fname']          = $enqData['fname'];                
            $mailData['email']          = $enqData['email'];           
            $mailData['email_message']  = $email_message;           
            $mailData['thanks']         = THANKS;
            $mailData['team']           = WOSA;
           
            if(base_url()!=BASEURL){
                $this->sendEmail_enquiry_($subject,$mailData);
            }
           }
            
            $data['error_message'] = [ "success" => 1, "message" => "success", 'enquiry_id'=> $enquiry_id];
            $this->set_response($data, REST_Controller::HTTP_CREATED);   
        }else{
            $data['error_message'] = [ "success" => 0, "message" => "Oops..Failed to send enquiry! try again.", 'enquiry_id'=>''];
            $this->set_response($data, REST_Controller::HTTP_CREATED);
        }                    
        
    }
           
    
}


}//class closed