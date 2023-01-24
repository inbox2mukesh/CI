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
     
class Create_session extends REST_Controller{
    
    public function __construct(){
        
        error_reporting(0);
        parent::__construct();
        $this->load->database();
        $this->load->model('Counseling_session_model');    
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(ADMIN_EMAIL, FROM_NAME);
    }

    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            
            $std_data   = json_decode(file_get_contents('php://input'));
            if(!empty($std_data))
            {
             if(base_url()!=BASEURL)
             {
                $otp = rand(1000,10000);
             }else
             {
                $otp=1234;
             } 
               //$otp=1234;
             $message = 'Hi, please confirm your details by entering the Verification Code '.$otp.' Valid for 10 minutes only Regards Western Overseas';         
             $old_booking_no= $this->Counseling_session_model->get_last_sessionNo();  
            
            // $old_booking_no="Ref1111";
                    if($old_booking_no !="")
                    {
                    $p=explode('f',$old_booking_no);
                    //echo $p[1];
                    $new_book_no= ++$p[1];
                    }
                    else 
                    {
                    $new_book_no= "1111";
                    }  
                    $order_id="Ref".$new_book_no; 

             $params = array( 
               'fname' => ucfirst($std_data->fname),                   
                'mobile'=> $std_data->mobile,
                'email' => $std_data->email,
                'session_id'=> $std_data->session_id,
                'session_type'=> $std_data->session_type,
                'booking_date'=> $std_data->booking_date,
                'booking_date_str'=> $std_data->booking_date_str,
                'booking_time_slot'=> $std_data->booking_time_slot,
                'service_id'=> $std_data->service_id,
                'message'=> $std_data->message,
                'sessBookingNo'=> $order_id,
                'active'=>0,
                'amount'=> $std_data->amount,
              'country_code'=>$std_data->country_code ,// new field added           
              'checkout_token_no'=>$std_data->checkout_token_no       
             );

            $id = $this->Counseling_session_model->add_counseling_session($params);
            $session_data = $this->Counseling_session_model->get_student_session($id);
            if($id){

/* 
                $mailData = [];  
                $subject='BOOKING CREATED - Western Overseas Immigration';
                $email_message='Thankyou for connecting with us. Your details have been submitted, once we receive the payment confirmation we will send you the booking acknowledgement.'; 
                $mailData['student_name']        =$session_data['fname'].' '.$session_data['lname'];                        
                $mailData['refno']               = $session_data['sessBookingNo']; 
                $mailData['email']               = $session_data['email'];  

                $mailData['email_message']       = $email_message;
                $mailData['thanks']              = THANKS;
                $mailData['team']                = WOSA; 
                $this->sendEmailTostd_ApiBookingCreated($subject,$mailData);

                 // email send to admin 
                $mailData1 = [];  
                $email_message='New session booking has been initiated. The user will either pay through Paypal or through email. Incase user pays through Paypal another email will be sent with confirmation. If the user pays through email, you will have to manually confirm booking through the Admin Panel.<br>Here are the details:';
                $subject='New session booking has been initiated - Western Overseas Immigration #'.date('d-m-Y'); 
                $mailData1['student_name']        =$session_data['fname'].' '.$session_data['lname'];                        
                $mailData1['refno']               = $session_data['sessBookingNo']; 
                $mailData1['email']               = CU_EMAIL2;   
                //$mailData1['email']               = "wosa.developer5@gmail.com";  
                $mailData1['session_type']         = $session_data['session_type'];
                $mailData1['service_id']         = $session_data['enquiry_purpose_name'];                 
                $mailData1['booked_date']         = $session_data['booking_date'].' '.$session_data['booking_time_slot'];                            
                $mailData1['amount']       =$session_data['amount'];

                $mailData1['total_amount']       =$session_data['payment_gross'];
                $mailData1['payment_status']       = "Not Confirmed";
                $mailData1['email_message']       = $email_message;
                 $mailData['mobile']               = $session_data['mobile']; 
                 $mailData['useremail']               = $session_data['email']; 
                $mailData1['thanks']              = THANKS;
                $mailData1['team']                = WOSA; 
                $this->sendEmailTostd_Aptbooking_admin($subject,$mailData1);
                //ends

 */
                //$this->_call_smaGateway($params['mobile'],$message);                
                $data['error_message'] = [ "success" => 1, "message" => '<div class="alert alert-info alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Verification Code sent on your mobile no. Please enter.<a href="#" class="alert-link"></a>.</div>', "id"=>$id,"sessid"=>$order_id];

            }else{
                $data['error_message'] = [ "success" => 0, "message" => '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> OOps..Failed to send Verification Code. Please try again!<a href="#" class="alert-link"></a>.</div>', 'id'=>''];
            }  
            }     
            
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED);
    }
    

    function book_session($std_data){

        //$this->db->trans_start();
        $params1 = array(
            'student_id'    => $std_data->student_id,
            'session_id'=>$std_data->session_id,
            'session_type'       => $std_data->session_type,
            'test_module_id'     => $std_data->test_module_id, 
            'programe_id'=> $std_data->programe_id,
            'center_id'  => $std_data->center_id,
            'booking_date'      => $std_data->booking_date,
            'booking_date_str'      => strtotime($std_data->booking_date),
            'booking_time_slot'=>$std_data->booking_time_slot,
            'booking_link'=>$std_data->booking_link,
            'active'        => 1
        );       
        $this->db->insert('session_booking', $params1);
        $booking_id =  $this->db->insert_id(); 
        if($booking_id>0){
            $booking_done=1;  
        }else{
            $booking_done=0;  
        }        
        ///////////////////status update/////////////////////////             
            $pack_cb='sess';
            $service_id=ACADEMY_SERVICE_REGISTRATION_ID;
            $center_id= $std_data->center_id;
            $test_module_id = $std_data->test_module_id;
            $programe_id = $std_data->programe_id;
            $studentStatus = $this->_calculateStatus($service_id,$center_id,$test_module_id,$programe_id,$pack_cb);
            $student_identity = $studentStatus['student_identity'];
            $details = $studentStatus['details'];
                        
            $params3 = array(
                'student_identity'=> $student_identity,
                'service_id'     => $service_id,
            );                       
            $params4 = array('student_id'=>$std_data->student_id, 'student_identity'=> $student_identity,'details'=> $details);
            $offlineCount=$this->Package_master_model->getOfflinePackActiveCount($std_data->student_id);
            $onlineCount=$this->Package_master_model->getOnlinePackActiveCount($std_data->student_id);
            if($offlineCount==0 or $onlineCount==0){
                $idd = $this->Student_model->update_student($std_data->student_id,$params3);
                $std_journey = $this->Student_journey_model->update_studentJourney($params4);
            }else{                
                $std_journey = $this->Student_journey_model->update_studentJourney($params4);
            }
        //////////////////status update end/////////////////////////

        
        //$this->db->trans_complete();        
        if($booking_done==1){

            if(base_url()!=BASEURL){
                $message='Hi, thanks for booking an event with us. Event details are sent on your email. For more info login to westernoverseas.online Regards Western Overseas';
                $ccode=ltrim($std_data->country_code,"+");
               $opt_mobileno=$ccode.''.$std_data->mobile;
               //$this->_call_smaGateway($opt_mobileno,$message);
                //$this->_call_smaGateway($mobile,$message);
            }
            $subject = 'Dear '.$std_data->fname.', your session booked successfully';
            $email_message= 'Your session booked successfully. Details are as below:';
                        
            $mailData['fname']  = $std_data->fname;
            $mailData['session_type']  = $std_data->session_type;
            $mailData['date']  = $std_data->booking_date;
            $mailData['time_slot']  = $std_data->booking_time_slot;            
            $mailData['booking_link']  = $std_data->booking_link;            
            $mailData['email_message']  = $email_message;            
            $mailData['thanks']         = THANKS;
            $mailData['team']           = WOSA;
            if(base_url()!=BASEURL){                
                $this->load->library('email');
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");
                $this->email->from(ADMISSION_EMAIL, FROM_NAME);
                $this->email->to($email);
                $this->email->subject($subject);
                $body = $this->load->view('emails/sendEmail_SessionBooking.php',$mailData,TRUE);
                $this->email->message($body);
                $this->email->send();
            }
            return $booking_id;

        }else{ 
            return 0; 
        }

    }

    


}//class closed