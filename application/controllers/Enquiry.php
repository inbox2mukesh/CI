<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Enquiry extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Student_enquiry_model');  
        $this->load->model('Student_model');
        $this->load->model('Country_model');
        $this->load->model('Student_service_masters_model');
        $this->load->model('Center_location_model');
        $this->load->model('Student_journey_model'); 
    }    

    function enquiry_submit() 
    {       
        $piece=explode('|',$this->input->post('country_code'));
        $student_params = array(                             
        'fname' => $this->input->post('fname'), 
        'lname' => $this->input->post('lname'),               
        'country_code' => $piece[0],
        'country_iso3_code' => $piece[1],
        'mobile'=> $this->input->post('mobile'),
        'email' => $this->input->post('email'),
        'dob'=> $this->input->post('dob'),          

        );
        $headers = array(
        'API-KEY:'.WOSA_API_KEY, 
        'MOBILE:'.$this->input->post('mobile', true), 
        'EMAIL:'.$this->input->post('email', true), 
        );           
           // check student mobile no/email is exist in db or not
        $response= json_decode($this->_curlGetData(base_url(GET_STUDENT_EXISTENCE_URL), $headers));
        if($response->error_message->success==0 AND $response->error_message->message == 'fresh'){ 
            //New registration and insert enquiry data api
            $response_reg= json_decode($this->_curPostData(base_url(SUBMIT_STD_URL), $headers, $student_params));
                if($response_reg->error_message->success==1){                               
                    $today = date('d-m-Y');
                    // insert the enquiry with student id and other parameters  
                    $student_enq_params = array(      
                    'student_id' => $response_reg->error_message->data,                        
                    'enquiry_purpose_id' => $this->input->post('enquiry_purpose_id'), 
                    'message' => $this->input->post('message'),
                    'todayDate'=> $today,
                    );  
                    $headers_enqq = array(
                        'API-KEY:'.WOSA_API_KEY,                       
                        'SENDEMAIL-FLAG:0',            
                        );                   
                    $response_enq= json_decode($this->_curPostData(base_url(SUBMIT_ENQUIRY_URL), $headers_enqq, $student_enq_params));                      
                    if($response_enq->error_message->success==1){                   
                        header('Content-Type: application/json');
                        $response = ['status'=>2,'enquiry_id'=>$response_enq->error_message->enquiry_id];
                        echo json_encode($response);               
                    }
                    else{                   
                        header('Content-Type: application/json');
                        $response = ['status'=>0,'enquiry_id'=>''];
                        echo json_encode($response);               
                    }
                }
                else{                   
                    header('Content-Type: application/json');
                    $response = ['status'=>0,'enquiry_id'=>''];
                    echo json_encode($response);               
                }                    
        }
        // CASE 2 : existing user having active=1 and is_otp_verified=1, then  call login process then redirect to checkout page
        elseif($response->error_message->message=="existing" AND $response->error_message->active == 1 AND $response->error_message->is_otp_verified == 1 )
        {  
            //user already found with active status then only new enquiry is created
            $today = date('d-m-Y');           
            $student_enq_params = array(      
            'student_id' => $response->error_message->student_id,                        
            'enquiry_purpose_id' => $this->input->post('enquiry_purpose_id'), 
            'message' => $this->input->post('message'),
            'todayDate'=> $today,
            );   
            $headers_enqq = array(
                'API-KEY:'.WOSA_API_KEY,                  
                'SENDEMAIL-FLAG:1',            
                );           
            $response= json_decode($this->_curPostData(base_url(SUBMIT_ENQUIRY_URL), $headers_enqq, $student_enq_params));     
            if($response->error_message->success==1){                   
                header('Content-Type: application/json');
                $response = ['status'=>1,'enquiry_id'=>$response->error_message->enquiry_id];
                echo json_encode($response);               
            }
            else{                   
                header('Content-Type: application/json');
                $response = ['status'=>0,'enquiry_id'=>''];
            }
        }
        // CASE 3 : existing user having active=0 and is_otp_verified=0, then  call opt verification process then redirect to checkout page    
        elseif($response->error_message->message=="existing" AND $response->error_message->active == 0 AND $response->error_message->is_otp_verified == 0 )
        {
            /*
            //user already found with de-active status then update the opt,send opt and new enquiry is created
                1. otp update
                2. send otp
                3.otp pop open  
            */
            $today = date('d-m-Y');
            // insert the enquiry with student id and other parameters 
            $student_enq_params = array(      
            'student_id' => $response->error_message->student_id,                        
            'enquiry_purpose_id' => $this->input->post('enquiry_purpose_id'), 
            'message' => $this->input->post('message'),
            'todayDate'=> $today,
            );  
            $headers_enqq = array(
                'API-KEY:'.WOSA_API_KEY,                  
                'SENDEMAIL-FLAG:0',            
                );   
            //$enquiry_id = $this->Student_enquiry_model->add_enquiry($student_enq_params);  
            $response_enq1= json_decode($this->_curPostData(base_url(SUBMIT_ENQUIRY_URL), $headers_enqq, $student_enq_params));  

            $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'STUDENT-ID:'.$response->error_message->student_id, 
            'SEND-EMAIL-FLAG:1',             
            );               
            //  
            $response1= json_decode($this->_curPostData(base_url(UPDATE_OTP), $headers, $student_params));
            if($response1->error_message->success==1)
            {
                //opt send success
                //open otp popup                    
                header('Content-Type: application/json');
                $response2 = ['status'=>2,'enquiry_id'=>$response_enq1->error_message->enquiry_id];
                echo json_encode($response2);
            }
            else 
            {
                    //error....opt not send
                header('Content-Type: application/json');
                $response2 = ['status'=>0,'enquiry_id'=>''];
                echo json_encode($response2);  
            }
        }
          // CASE 4 : for blocked user 
          elseif($response->error_message->message=="existing" AND $response->error_message->active == 0 AND $response->error_message->is_otp_verified == 1 )
          {
             //user already found with active status then only new enquiry is created
            $today = date('d-m-Y');           
            $student_enq_params = array(      
            'student_id' => $response->error_message->student_id,                        
            'enquiry_purpose_id' => $this->input->post('enquiry_purpose_id'), 
            'message' => $this->input->post('message'),
            'todayDate'=> $today,
            );     
            $headers_enqq = array(
                'API-KEY:'.WOSA_API_KEY,                  
                'SENDEMAIL-FLAG:1',            
                );          
            $response= json_decode($this->_curPostData(base_url(SUBMIT_ENQUIRY_URL), $headers_enqq, $student_enq_params));     
            if($response->error_message->success==1){                   
                header('Content-Type: application/json');
                $response = ['status'=>2,'enquiry_id'=>$response->error_message->enquiry_id];
                echo json_encode($response);               
            }
            else{                   
                header('Content-Type: application/json');
                $response = ['status'=>0,'enquiry_id'=>''];
            }

          }
            //die();

    }

    public function send_otp(){       
        
        if(base_url()!=BASEURL){
            $otp = rand(1000,10000);
        }else{
            $otp=1234;
        }
       $country_code= $this->input->post('country_code', true);
       $iso3_code=explode('|',$country_code);     
        $today = date('d-m-Y');
        $message = 'Hi, please confirm your details by entering the Verification code '.$otp.'Verification code is Valid for 10 minutes only Regards</br>'.COMPANY;        
        $params=array(
            'todayDate'=> $today,
            'fname' => $this->input->post('fname', true),
            'lname' => $this->input->post('lname', true),
            'email'    => $this->input->post('email', true),
            'country_code' => $iso3_code[0],
            'country_iso3_code' => $iso3_code[1],
            'mobile' => $this->input->post('mobile', true),             
            'enquiry_purpose_id' => $this->input->post('enquiry_purpose_id', true),
            'sub_events'    => $this->input->post('sub_events', true),
            'test_module_id'    => $this->input->post('test_module_id', true), 
            'programe_id' => $this->input->post('programe_id', true),
            'free_demo' => $this->input->post('free_demo', true),  
            'center_id' => $this->input->post('center_id', true), 
            'country_id' => $this->input->post('country_id', true),
            'message' => $this->input->post('message', true),
            'active'=> 0,
            'OTP'=> $otp,
            'is_otp_verified'=>0,
            'dob'=>$this->input->post('dob', true),
        );
        $enquiry_id = $this->Student_enquiry_model->add_enquiry($params);
        if(base_url()!=BASEURL){ 
            $ccode=ltrim($params['country_code'],"+");
            $opt_mobileno=$ccode.''.$params['mobile'];
            //$this->_call_smaGateway($opt_mobileno,$message);
        }

        
        if(base_url()!=BASEURL){
            
            //MAIL
            $subject = "Verification code verification- WOSA";
            $email_message='Hi, please confirm your details by entering the Verification code '.$otp.'Verification code is Valid for 10 minutes only Regards</br>'.COMPANY;
            $mailData=[]; 
            $mailData['fname']         = $params['fname'];
            $mailData['email']         = $params['email'];               
            $mailData['email_message'] = $email_message;
            $mailData['thanks']        = THANKS;
            $mailData['team']          = WOSA;               
           echo  $this->sendEmailTostd_walkinOTP_($subject,$mailData);
        }
        
        if($enquiry_id){  
            header('Content-Type: application/json');
            $response = ['msg'=>'success', 'status'=>'true', 'enquiry_id'=>$enquiry_id,'student_params'=>$params];
            echo json_encode($response);
        }else{  
            header('Content-Type: application/json');
            $response = ['msg'=>'failed', 'status'=>'false', 'enquiry_id'=>'','params'=>[] ];
            echo json_encode($response);
        }
    }

    public function verify_otp(){
      
    $otp = $this->input->post('otp', true);
    $enquiry_id = $this->input->post('enquiry_id', true);   
    $params=array(
        'active'=> 1,
        'is_email_verified'=> 1,    
    );
    $headers = array(
        'API-KEY:'.WOSA_API_KEY,
        'ENQ-ID:'.$enquiry_id,
        'ENQ-OTP:'.$otp,
    );  
    // $update_id = $this->Student_enquiry_model->update_enquiry($enquiry_id, $params);

    $response = json_decode($this->_curPostData(base_url(VERIFY_ENQ_OTP_STD_URL), $headers, $params));      
    if ($response->error_message->success == 1) {  
        $headersd = array(
            'API-KEY:' . WOSA_API_KEY,
            'LAST-ID:' . $response->error_message->data,
        );
        $paramsd = array(
            'otp' => $this->input->post('otp'),
        );
        $response = json_decode($this->_curPostData(base_url(VERIFY_STD_URL), $headersd, $paramsd)); 
        header('Content-Type: application/json');
        $response = ['msg' => "", 'status' =>1];
        echo json_encode($response);           
    }
    else if($response->error_message->success == 2)
    {
        header('Content-Type: application/json');
        $response = ['msg' => "", 'status' =>2];
        echo json_encode($response);  

    }
    else {
        header('Content-Type: application/json');
        $response = ['msg' => "", 'status' =>0];
        echo json_encode($response);  
    }
    
     
} 


    /* public function verify_otpold(){
      
        $otp = $this->input->post('otp', true);
        $enquiry_id = $this->input->post('enquiry_id', true);
      //  $this->db->trans_start();
        $DBotp = $this->Student_enquiry_model->getOTP($enquiry_id);          
        if($DBotp['OTP']==$otp){
            $params=array(
                'active'=> 1,
                'is_email_verified'=> 1,
            );
            $headers = array(
                'API-KEY:'.WOSA_API_KEY,
                'ENQ-ID:'.$enquiry_id,
                'ENQ-OTP:'.$otp,

                );  
    // $update_id = $this->Student_enquiry_model->update_enquiry($enquiry_id, $params);

$update_id = json_decode($this->_curPostData(base_url(VERIFY_ENQ_OTP_STD_URL), $headers, $params));
die();


            if($update_id){
                $enqData = $this->Student_enquiry_model->get_enquiry_data($enquiry_id);
                $subject = 'Hi! your enquiry sent successfully';
                $email_message = 'Hi! your enquiry sent successfully at our Enquiry team. We will get back to soon.';
                $mailData['fname']          = $enqData['fname'];                
                $mailData['email']          = $enqData['email'];
                $mailData['email_message']  = $email_message;
                $mailData['thanks']         = THANKS;
                $mailData['team']           = WOSA;
                
                $message1='Thank you for getting in touch with us, we will contact you regarding your query shortly.Regards Western Overseas';
                $message2 ='Hi, we would like to thank you for choosing Western Overseas. Kindly share your feedback <https://western-overseas.com/aca-erp/> Regards Western Overseas';
                if(base_url()!=BASEURL){ 

                    $ccode=ltrim($enqData['country_code'],"+");
                    $opt_mobileno=$ccode.''.$enqData['mobile'];
                   // $this->_call_smaGateway($opt_mobileno,$message1);
                   // $this->_call_smaGateway($opt_mobileno,$message2);
                }
                if(base_url()!=BASEURL){
                    $this->sendEmail_enquiry_($subject,$mailData);
                }
                //student reg process here..
                $pack_cb=''; $fresh = 0; $service_id=10;
                $today = date('d-m-Y');
                $todaystr = strtotime($today);
                $token= 0;
                $data['CountryIdData']=$this->Country_model->get_country_id($enqData['country_code']);
                $country_id = $data['CountryIdData']['country_id'];
                $maxid = $this->Student_model->getMax_UID();
                $UID = $this->_calculateUID($maxid);
                if(ENVIRONMENT!='production'){
                    $plain_pwd = PLAIN_PWD;  
                }else{
                    $plain_pwd = $this->_getorderTokens(PWD_LEN);
                }
                if($enqData['email']!=''){
                    $username = $enqData['email'];
                }else{
                    $username = $enqData['mobile'];
                }
                if($enqData['programe_id']){
                    $programe_id=$enqData['programe_id'];
                }else{
                    $programe_id=0;
                }
                if($enqData['test_module_id']){
                    $test_module_id=$enqData['test_module_id'];
                }else{
                    $test_module_id=0;
                }
                if($enqData['center_id']){
                    $center_id=$enqData['center_id'];
                }else{
                    $center_id=0;
                }
                $params = array(
                    'today'           =>  $todaystr,
                    'waitingToken'    =>  $token,   
                    'UID'             =>  $UID,
                    'service_id'      =>  $service_id,               
                    'programe_id'     =>  $programe_id,
                    'test_module_id'  =>  $test_module_id,
                    'center_id'       =>  $center_id,
                    'all_center_id'   =>  $center_id,              
                    'email'           =>  $enqData['email'],
                    'username'        =>  $username,
                    'password'        =>  md5($plain_pwd),
                    'mobile'          =>  $enqData['mobile'],
                    'OTP'             =>  $enqData['OTP'],
                    'is_otp_verified' =>  1,
                    'country_code'    =>  $enqData['country_code'],
                    'country_iso3_code' => $enqData['country_iso3_code'],
                    'country_id'      =>  $country_id,
                    'fname'           =>  ucfirst($enqData['fname']),
                    'lname'           =>  ucfirst($enqData['lname']),
                    'active'            => 1,
                    'fresh'             => $fresh,
                );
                $student_id = $this->Student_model->add_student($params);
                if($student_id!='duplicate'){

                    $studentStatus = $this->_calculateStatus($params['service_id'],$params['center_id'],$params['test_module_id'],$params['programe_id'],$pack_cb);
                    $student_identity = $studentStatus['student_identity'];
                    $details = $studentStatus['details'];
                    $params2 = array('student_identity'=> $student_identity);
                    $params3 = array('student_id'=>$student_id, 'student_identity'=> $$studentStatus['details'],'details'=> $details,'by_user'=>$by_user);
                    $idd = $this->Student_model->update_student($student_id, $params2);
                    $std_journey = $this->Student_journey_model->update_studentJourney($params3);

                    $subject='Registration successfull- WOSA'; 
                    $email_message='Hi '.ucfirst($this->input->post('fname')).', You are registered successfully at Western Overseas.Details are as below:';
                        $mailData=[];
                        $mailData['password']       = $plain_pwd;
                        $mailData['username']       = $username;
                        $mailData['fname']          = $enqData['fname'];                
                        $mailData['email']          = $enqData['email'];
                        $mailData['email_message']  = $email_message;
                        $mailData['thanks']         = THANKS;
                        $mailData['team']           = WOSA;
                        if(base_url()!=BASEURL){               
                            $this->sendEmailTostd_creds_($subject,$mailData);
                        }                 
                  //  $this->db->trans_complete();
                    if($this->db->trans_status() === FALSE){
                        header('Content-Type: application/json');
                        $response = ['msg'=>'failed', 'status'=>'false'];
                        echo json_encode($response);
                    }else{
                        header('Content-Type: application/json');
                        $response = ['msg'=>'success', 'status'=>'true'];
                        echo json_encode($response); 
                    }
                
            }else{  
                //if duplicate do nothing
                header('Content-Type: application/json');
                $response = ['msg'=>'success', 'status'=>'true'];
                echo json_encode($response);
            }

        }else{
           
            header('Content-Type: application/json');
            $response = ['msg'=>'success', 'status'=>'true'];
            echo json_encode($response);
        }
                
    }else{
        header('Content-Type: application/json');
        $response = ['msg'=>'failed', 'status'=>'false'];
        echo json_encode($response);
    }
}  */

    public function resendOTP(){

        $enquiry_id = $this->input->post('enquiry_id', true);
        $resend_for = $this->input->post('resend_for', true);
        if(base_url()!=BASEURL){
            $otp = rand(1000,10000);
        }else{
            $otp = 0000;
        }
        $res = $this->Student_enquiry_model->get_student_by_enqid($enquiry_id);
        $student_id=$res['student_id'];       

        $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'STUDENT-ID:'.$student_id,             
            'SEND-EMAIL-FLAG:1',             
            );               
            //  
            $response1= json_decode($this->_curPostData(base_url(UPDATE_OTP), $headers, $student_params=NULL));
            if($response1->error_message->success==1)
            {
                //opt send success
                //open otp popup                    
                header('Content-Type: application/json');
                $response2 = ['status'=>1,'enquiry_id'=>$enquiry_id];
                echo json_encode($response2);
            }
            else 
            {
                    //error....opt not send
                header('Content-Type: application/json');
                $response2 = ['status'=>0,'enquiry_id'=>''];
                echo json_encode($response2);  
            }
/* 
        //old 
        $message = 'Hi, please confirm your details by entering the Verification code '.$otp.' Valid for 10 minutes only Regards Western Overseas';
        $params=array('OTP'=>$otp);
        $updateOTP = $this->Student_enquiry_model->update_enquiry($enquiry_id,$params);
        $mobileEmailData = $this->Student_enquiry_model->getEnquiry_mobileEmail($enquiry_id);
        if(base_url()!=BASEURL){

            $ccode=ltrim($mobileEmailData['country_code'],"+");
            $opt_mobileno=$ccode.''.$mobileEmailData['mobile'];
            //$this->_call_smaGateway($opt_mobileno,$message);
          
        }
        if(base_url()!=BASEURL){
            //MAIL
            $subject = "Verification code verification- WOSA";
            $email_message='Hi, please confirm your details by entering the Verification code '.$otp.' Valid for 10 minutes only Regards Western Overseas';
            $mailData=[]; 
            $mailData['fname']         = 'User';
            $mailData['email']         = $mobileEmailData['email'];               
            $mailData['email_message'] = $email_message;
            $mailData['thanks']        = THANKS;
            $mailData['team']          = WOSA;               
            $this->sendEmailTostd_walkinOTP_($subject,$mailData);
        }
        if($enquiry_id and $updateOTP){  
            header('Content-Type: application/json');
            $response = ['msg'=>'success', 'status'=>'true'];
            echo json_encode($response);
        }else{  
            header('Content-Type: application/json');
            $response = ['msg'=>'failed', 'status'=>'false'];
            echo json_encode($response);
        } */

    } 


}
