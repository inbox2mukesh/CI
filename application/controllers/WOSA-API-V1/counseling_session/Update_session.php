<?php
/**
 * @package         WOSA
 * @subpackage      ..
 * @author          Navjeet
 *
 **/
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';    
     
class Update_session extends REST_Controller {    
public function __construct() {

    error_reporting(0);
    parent::__construct();
    $this->load->database();
    $this->load->model('Counseling_session_model'); 
}
public function index_post()
{  
    if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
        $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
    }else{
       $id=$this->input->get_request_header('STUDENT-SESSION-ID');
       $std_data   = json_decode(file_get_contents('php://input'));            
       unset($std_data->email_send_flag);  
       $std_data1   = json_decode(file_get_contents('php://input'));   
        if(!empty($std_data1)){
               
            $idd = $this->Counseling_session_model->update_student_session($id,$std_data);
            $session_data = $this->Counseling_session_model->get_student_session($id);
             if($std_data1->email_send_flag == 1)
             {
                $mailData = [];  
                // $subject='SESSION BOOKING CONFIRMATION - Western Overseas Immigration';
                // $email_message='Thankyou for booking an session. Here are the details:'; 
                $email_content = session_booked(); 
                $subject = $email_content['subject'];
                $email_message= $email_content['content'];
                $mailData['student_name']        =$session_data['fname'].' '.$session_data['lname'];                        
                $mailData['refno']               = $session_data['sessBookingNo']; 
                $mailData['email']               = $session_data['email'];   
                $mailData['session_type']         = $session_data['session_type'];
                $mailData['service_id']         = $session_data['enquiry_purpose_name'];                 
                $mailData['booked_date']         = $session_data['booking_date'].' '.$session_data['booking_time_slot'];                            
                $mailData['amount']       =$session_data['amount'];

                $mailData['total_amount']       =$session_data['payment_gross'];
                $mailData['payment_status']       = $session_data['payment_status'];
                $mailData['email_message']       = $email_message;
                $mailData['thanks']              = THANKS;
                $mailData['team']                = WOSA; 
                $this->sendEmailTostd_Aptbooking($subject,$mailData);

               /* email send to admin */
               $mailData1 = [];  
                // $subject='NEW SESSION BOOKING MADE - Western Overseas Immigration';
                // $email_message='New session booking made. Here are the details:'; 
                $email_content = session_booked(); 
                $subject = $email_content['subject'];
                $email_message= $email_content['content'];
                $mailData1['student_name']        =$session_data['fname'].' '.$session_data['lname'];                        
                $mailData1['refno']               = $session_data['sessBookingNo']; 
                $mailData1['email']               = CU_EMAIL2;   
              //  $mailData1['email']               = "navjeet2008@gmail.com";  
                $mailData1['session_type']         = $session_data['session_type'];
                $mailData1['service_id']         = $session_data['enquiry_purpose_name'];                 
                $mailData1['booked_date']         = $session_data['booking_date'].' '.$session_data['booking_time_slot'];                            
                $mailData1['amount']       =$session_data['amount'];
                $mailData1['total_amount']       =$session_data['payment_gross'];
                $mailData1['payment_status']       = $session_data['payment_status'];
                $mailData1['email_message']       = $email_message;
                $mailData1['mobile']               = $session_data['mobile']; 
                $mailData1['useremail']               = $session_data['email']; 
                $mailData1['thanks']              = THANKS;
                $mailData1['team']                = WOSA;                 
                $this->sendEmailTostd_Aptbooking_admin($subject,$mailData1);
            } 
        $data['error_message'] = [ "success" => 1, "message" => 'Dear '.$session_data['fname'].' '.'Payment successfully done'];                
        }else{
            $data['error_message'] = [ "success" => 0, "message" => '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Something went wrong. Please try again!<a href="#" class="alert-link"></a>.</div>', 'id'=>''];   
        }
    }  
    $this->set_response($data, REST_Controller::HTTP_CREATED);     
    
}



}//class closed