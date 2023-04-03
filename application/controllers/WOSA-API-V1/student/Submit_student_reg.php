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
     
class Submit_student_reg extends REST_Controller{
    
public function __construct(){
    
    error_reporting(0);
    parent::__construct();
    $this->load->database();
    $this->load->model('Student_model');
    $this->load->model('Country_model');
    $this->load->model('Student_journey_model');
    $this->load->model('Student_service_masters_model');
    $this->load->model('Center_location_model');
}


public function index_post()
{  
    if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
        $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
    }else{
        
        $std_data   = json_decode(file_get_contents('php://input'));
        $mobile_count =  $this->Student_model->check_std_mobile_availibility($std_data->mobile);
        $email_count  =  $this->Student_model->check_std_email_availibility($std_data->email);
        $tc = $mobile_count+$email_count;
        //student add
        if($tc==0){
            $otp = rand(1000,10000);      
            $ccode=ltrim($std_data->country_code,"+");
            $opt_mobileno=$ccode.''.$std_data->mobile;
            if (DEFAULT_COUNTRY == 101) //india
            { 
                if(base_url()!=BASEURL){           
                $message = 'Hi, please confirm your details by entering the OTP '.$otp.' Valid for 10 minutes only Regards Western Overseas';
                $this->_call_smaGateway($opt_mobileno,$message);  
                }             
            }
            else { // other country
                if(base_url()!=BASEURL){
                    $subject = "Verification code- WOSA";
                    $email_message='Hi, please confirm your details by entering the <b>Verification code '.$otp.'</b> Verification code is Valid for 10 minutes only'.COMPANY;
                    $mailData=[]; 
                    $mailData['fname']         = $std_data->fname;
                    $mailData['email']         = $std_data->email;               
                    $mailData['email_message'] = $email_message;
                    $mailData['thanks']        = THANKS;
                    $mailData['team']          = WOSA;               
                    $this->sendEmailTostd_walkinOTP_($subject,$mailData);
                }
            }            
           
            $countryData =$this->Country_model->get_country_id($std_data->country_code);
            $country_id = $countryData['country_id'];
            $maxid = $this->Student_model->getMax_UID();
			$UID = $this->_calculateUID($maxid);
            $service_id =ONLINE_SIGNUP;
            

            if(isset($std_data->center_id)){
                $center_id = $std_data->center_id;
            }else{
                $center_id=ONLINE_BRANCH_ID;//Online
            }

            if(isset($std_data->test_module_id)){
                $test_module_id = $std_data->test_module_id;
            }else{
                $test_module_id=NULL;
            }

            if(isset($std_data->programe_id)){
                $programe_id = $std_data->programe_id;
            }else{
                $programe_id=0;

            }
            if(isset($std_data->pack_type)){
                $pack_cb = $std_data->pack_type;
            }else{
                $pack_cb='';

            }
            if(isset($test_module_id)and isset($programe_id) and isset($center_id)){
                $response = $this->_calculateStatus($service_id,$center_id,$test_module_id,$programe_id,$pack_cb);
                $student_identity = $response['student_identity'];
                $details = $response['details'];
            }else{
                 $student_identity = 'WA13-'.ONLINE_BRANCH_ID.'-0';
            }
           

            $std_params = array( 
                'UID'   => $UID,
                'student_identity' => $student_identity, 
                'fresh'=>1,
                'service_id' => $service_id,                             
                'fname' => ucfirst($std_data->fname), 
                'lname' => ucfirst($std_data->lname), 
                'dob'=> $std_data->dob,              
                'country_code' => $std_data->country_code,
                'country_iso3_code' => $std_data->country_iso3_code,
                'mobile'=> $std_data->mobile,
                'center_id'=>$center_id,
                'all_center_id'=>$center_id,
                'test_module_id'=>$test_module_id,
                'programe_id'=>$programe_id,
                'country_id' => $country_id,
                'email' => $std_data->email,
                'username' => $std_data->email,                
                'OTP'=> $otp,
                'active' => 0,                
                'is_otp_verified'=>0,
                'is_email_verified'=>0,
            );
            $last_id = $this->Student_model->add_student($std_params);
            $std_params2 = array('student_id'=>$last_id, 'student_identity'=> $std_params['student_identity'],'details'=> $details);
            $this->Student_journey_model->update_studentJourney($std_params2);          
            $data['error_message'] = [ "success" => 1, "message" => "Verification code sent on your Email. Please enter..", 'data'=> $last_id];           
        }else{
            $data['error_message'] = [ "success" => 0, "message" => "Your Email or Mobile no already registered with us! Please try with diffrent ids or login", 'data'=>'' ];
            $this->set_response($data, REST_Controller::HTTP_CREATED);   
        }
    }  
    $this->set_response($data, REST_Controller::HTTP_CREATED);     
    
}



}//class closed