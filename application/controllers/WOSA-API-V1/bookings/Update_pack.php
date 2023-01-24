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
     
class Update_pack extends REST_Controller{
    
    public function __construct(){
        
        error_reporting(0);
        parent::__construct();
        $this->load->database();
        
        $this->load->model('Student_model');         
        $this->load->model('Package_master_model');
        $this->load->model('Practice_package_model');
        $this->load->model('Student_package_model');
        $this->load->model('Student_service_masters_model');
        $this->load->model('Student_journey_model');
        $this->load->model('Classroom_model');
        //$this->load->model('Discount_model');
        $this->load->model('Center_location_model');
        $this->load->model('Test_module_model');
        $this->load->model('Programe_master_model'); 
        $this->load->model('Batch_master_model');
        $this->load->model('Country_model');     
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(ADMISSION_EMAIL, FROM_NAME);
    }

    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            $student_pack_id= $this->input->get_request_header('STUDENT-PACK-ID');
        
            $std_data   = json_decode(file_get_contents('php://input'));            
            unset($std_data->email_send_flag);  
            $std_data1   = json_decode(file_get_contents('php://input'));   
           
            $sdata = $this->Student_package_model->update_student_pack($student_pack_id,$std_data);
            $studata = $this->Student_package_model->get_student_pack_detail($student_pack_id);                
            $package_data = $this->Package_master_model->get_package_master($studata['package_id']);
            $pack_batch_id=$studata['batch_id'];
            $method=$studata['method'];
            $pack_test_module_id= $package_data['test_module_id'];
            $pack_programe_id= $package_data['programe_id'];
            $pack_center_id= $studata['center_id'];
            if($studata['pack_type']=='online'){
                $pack_type='online';
                $service_id=ENROLL_SERVICE_ID;           
                $pack_cb='online';  
                $batch_id=  $pack_batch_id;
            
        }elseif($studata['pack_type']=='inhouse'){
            $pack_type='offline';
            $service_id=ENROLL_SERVICE_ID;           
            $pack_cb='offline';  
            $batch_id=$pack_batch_id;
        }elseif($studata['pack_type']=='practice'){
            $pack_type='practice';
            $service_id=ACADEMY_SERVICE_REGISTRATION_ID;           
            $pack_cb='practice'; 
            $batch_id= NULL;//static allocation
            $classroom_id=NULL;
        }
            if($std_data->status == "succeeded")
            { 
                $center_id= $studata['center_id'];
                $test_module_id = $studata['test_module_id'];
                $programe_id = $studata['programe_id'];
                $studentStatus = $this->_calculateStatus($service_id,$center_id,$test_module_id,$programe_id,$pack_cb);
              
                $student_identity = $studentStatus['student_identity'];
                $details = $studentStatus['details'];
                $params3 = array('student_identity'=> $student_identity,'service_id'=> $service_id,'fresh'=> 2);
                $params4 = array('student_id'=>$studata['student_id'], 'student_identity'=>$student_identity,'details'=> $details);
                $idd = $this->Student_model->update_student($studata['student_id'],$params3);
                $std_journey=$this->Student_journey_model->update_studentJourney($params4);               
                
                $getTestName = $this->Test_module_model->getTestName($pack_test_module_id);
                $getProgramName = $this->Programe_master_model->getProgramName($pack_programe_id);
                $getBatchName = $this->Batch_master_model->getBatchName($batch_id);
                $get_centerName = $this->Center_location_model->get_centerName($pack_center_id);
                           
                $subject = 'Dear User, your package subscribed successfully at '.COMPANY.'';
                $email_message='Your package subscribed successfully at '.COMPANY.' details are as below:';
                if($pack_type == "online" || $pack_type == "offline" )
                {
                    $mailData= $this->Student_model->getMailData($student_pack_id);
                }
                else if($pack_type == "practice")
                 {
                    $mailData= $this->Student_model->getMailData_pp($student_pack_id);
                }
                else
                {
                    $mailData=[];
                }
                
                $mailData['email_message']  = $email_message;
                $mailData['test_module_name']=$getTestName['test_module_name'];
                $mailData['programe_name']  = $getProgramName['programe_name'];
                $mailData['batch_name']     = $getBatchName['batch_name'];
                $mailData['center_name']    = $get_centerName['center_name'];
                $mailData['method']         = $method;
                $mailData['thanks']         = THANKS;
                $mailData['team']           = WOSA;
                if(base_url()!=BASEURL){
                    $this->sendEmailTostd_packsubs_($subject,$mailData);
                    $ccode=ltrim($studata['country_code'],"+");
                    $opt_mobileno=$ccode.''.$studata['mobile'];
                    //$this->_call_smaGateway($opt_mobileno,PACK_SUBSCRIPTION_SMS);
                }else{
                    //$message = '';
                } 
            }else{
                
                if($std_data1->email_send_flag == 1){  
                    $subject = 'Dear User, your package subscribtion failed at '.COMPANY.'';               
                    $getTestName = $this->Test_module_model->getTestName($pack_test_module_id);
                    $getProgramName = $this->Programe_master_model->getProgramName($pack_programe_id);
                    $getBatchName = $this->Batch_master_model->getBatchName($batch_id);
                    $get_centerName = $this->Center_location_model->get_centerName($pack_center_id);
                    $mailData                   = $this->Student_model->getMailData($student_pack_id);
                    $email_message='Your package subscribtion failed at '.COMPANY.': Payment-ID:'.$mailData['payment_id'];
                    $mailData['payment_id']  = $mailData['payment_id'];                
                    $mailData['email_message']  = $email_message;                
                    $mailData['thanks']         = THANKS;
                    $mailData['team']           = WOSA;
                    if(base_url()!=BASEURL){
                        $this->sendEmailTostd_packsubsfail_($subject,$mailData);
                        $ccode=ltrim($studata['country_code'],"+");
                        $opt_mobileno=$ccode.''.$studata['mobile'];
                        // $this->_call_smaGateway($opt_mobileno,PACK_SUBSCRIPTION_SMS);
                    }
                }
            }

            if($sdata){
                $data['error_message'] = [ "success" => 1, "message" => "success"]; 
            }else{
                $data['error_message'] = [ "success" => 0, "message" => "Oops..Failed to place order! try again."];
            }          
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED);
    }    
}//class closed