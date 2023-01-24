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
     
class Book_session extends REST_Controller{
    
    public function __construct(){
        
        error_reporting(0);
        parent::__construct();
        $this->load->database();
        $this->load->model('Counseling_session_model');
        $this->load->model('Test_module_model');
        $this->load->model('Center_location_model');
        $this->load->model('Time_slot_model');
        $this->load->model('Package_master_model');
        $this->load->model('Student_service_masters_model');
        $this->load->model('Student_model');
        $this->load->model('Student_journey_model');

        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(FROM_EMAIL, FROM_NAME);
    }

    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            
            $std_data   = json_decode(file_get_contents('php://input'));

                $booking_id = $this->book_session($std_data);
                if($booking_id>0){
                    $data['error_message'] = [ "success" => 1, "message" => "success", 'booking_id'=> $booking_id];
                    $this->set_response($data, REST_Controller::HTTP_CREATED);  
                }else{
                    $data['error_message'] = [ "success" => 0, "message" => "Oops..Failed to place order! try again.", 'booking_id'=>$booking_id];
                    $this->set_response($data, REST_Controller::HTTP_CREATED);
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