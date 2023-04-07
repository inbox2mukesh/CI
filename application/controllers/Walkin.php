<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Walkin extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('cookie', 'url'));
        $this->load->model('Center_location_model');
        $this->load->model('Student_model');
        $this->load->model('Walkin_model');
    }

    public function resendOTP(){

        $id = $this->input->post('id', true);
        $otp = rand(1000,10000);
        $email_content = otp_send_verification_email($otp);
        $email_message = $email_content['content'];
        $subject = $email_content['subject'];
        $params=array('OTP'=>$otp);
        $updateOTP = $this->Walkin_model->update_walkin($id,$params);
        $mobileEmailData = $this->Walkin_model->getOTP($id);

        //$this->_call_smaGateway($mobileEmailData['mobile'],$message);
        if(base_url()!=BASEURL){
            //MAIL
            // $subject = "OTP verification- WOSA";
            // $email_message='Hi, please confirm your details by entering the OTP '.$otp.' Valid for 10 minutes only Regards Western Overseas';
            $mailData = []; 
            $mailData['fname']         = $mobileEmailData['fname'];
            $mailData['email']         = $mobileEmailData['email'];               
            $mailData['email_message'] = $email_message;
            $mailData['thanks']        = THANKS;
            $mailData['team']          = WOSA;               
            $this->sendEmailTostd_walkinOTP_($subject,$mailData);
        }
        if($id and $updateOTP){  
            header('Content-Type: application/json');
            $response = ['msg'=>'success', 'status'=>'true'];
            echo json_encode($response);
        }else{  
            header('Content-Type: application/json');
            $response = ['msg'=>'failed', 'status'=>'false'];
            echo json_encode($response);
        }

    }
    function walkin_registration_1($center_name){

        $data['title'] = 'Student Walk-In Registration';
        $data['title1'] = 'Student Walk-In';
        $data['title2'] = ' Registration';
        $this->load->library('form_validation');  
        $this->form_validation->set_rules('country_code','Country code','required');
        $this->form_validation->set_rules('wkn_mobile','Mobile no.','required|trim');
        $this->form_validation->set_rules('wkn_email','Email','required|trim'); 
        $this->form_validation->set_rules('wkn_enquiry_purpose_id','Visit purpose','required');     
        $this->form_validation->set_rules('wkn_fname','First name','required');
        $this->form_validation->set_rules('wkn_gender_name','Gender','required');
        $this->form_validation->set_rules('wkn_dob','Birth date','required');
        $this->form_validation->set_rules('qualification_id','Qualification','required');
        $this->form_validation->set_rules('wkn_country_id','Prefered Country','required');
        $centerData = $this->Center_location_model->get_centerId($center_name);
        $center_id = $centerData['center_id'];
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,
        );        
        if($this->form_validation->run())     
        {            
            if($this->input->post('country_id') and !$this->input->post('country_id2')){
                $country_id = $this->input->post('country_id');
            }elseif($this->input->post('country_id2') and !$this->input->post('country_id')){
                $country_id = $this->input->post('country_id2');
            }elseif($this->input->post('country_id') and $this->input->post('country_id2')){
                $country_id = $this->input->post('country_id2');
            }elseif(!$this->input->post('country_id') and !$this->input->post('country_id2')){
                $country_id=NULL;
            }else{
                $country_id=NULL;
            }
            $params = array(
                'center_id'=> $center_id,
                'country_code' => $this->input->post('country_code'),
                'mobile'=> $this->input->post('wkn_mobile'),
                'email' => $this->input->post('wkn_email'),
                'enquiry_purpose_id'=> $this->input->post('wkn_enquiry_purpose_id'),
                'sub_events'        => $this->input->post('wkn_sub_events'),
                'test_module_id'    => $this->input->post('wkn_test_module_id'), 
                'programe_id'       => $this->input->post('wkn_programe_id'),
                'free_demo'         => $this->input->post('wkn_free_demo'),
                'fname' => $this->input->post('wkn_fname'), 
                'lname' => $this->input->post('wkn_lname'),
                'gender_name' => $this->input->post('wkn_gender_name'),
                'dob' => $this->input->post('wkn_dob'),
                'country_id' => $country_id,
                'qualification_id' => $this->input->post('wkn_qualification_id')
            );
            $response= json_decode($this->_curPostData(base_url(SUBMIT_WALKIN_STD_URL), $headers, $params));
            if($response->error_message->success==1){
                $_SESSION['walkin_lastId_std'] = $response->error_message->dataId;
                delete_cookie('center_id');
                delete_cookie('country_code');
                delete_cookie('mobile');
                delete_cookie('email');                
                delete_cookie('fname');
                delete_cookie('lname');                
                delete_cookie('enquiry_purpose_id');
                delete_cookie('test_module_id');
                delete_cookie('programe_id');
                delete_cookie('free_demo');
                delete_cookie('gender_name');
                delete_cookie('dob');
                delete_cookie('country_id');
                delete_cookie('qualification_id');
                $msg = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> '.$response->error_message->message.' <a href="#" class="alert-link"></a>.
                </div>';
                $this->session->set_flashdata('flsh_msg',  $msg);
                redirect('walkin/student_walkin_otp');
            }elseif ($response->error_message->success==2){
                unset($_SESSION['walkin_lastId_std']);
                $msg = '<div class="alert alert-info alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>NOTICE:</strong> '.$response->error_message->message.' <a href="#" class="alert-link"></a>.
                </div>';
                $this->session->set_flashdata('flsh_msg',  $msg);
                redirect('walkin/walkin_registration/'.$center_name);
            }
            else{
                set_cookie('center_id',$center_id,'3600');
                set_cookie('country_code',$this->input->post('country_code'),'3600');
                set_cookie('mobile',$this->input->post('mobile'),'3600');
                set_cookie('email',$this->input->post('email'),'3600');
                set_cookie('enquiry_purpose_id',$this->input->post('enquiry_purpose_id'),'3600');
                set_cookie('test_module_id',$this->input->post('test_module_id'),'3600');
                set_cookie('programe_id',$this->input->post('programe_id'),'3600');
                set_cookie('free_demo',$this->input->post('free_demo'),'3600');                
                set_cookie('fname',$this->input->post('fname'),'3600');
                set_cookie('lname',$this->input->post('lname'),'3600'); 
                set_cookie('gender_name',$this->input->post('gender_name'),'3600');
                set_cookie('dob',$this->input->post('dob'),'3600');
                set_cookie('country_id',$country_id,'3600');
                set_cookie('qualification_id',$this->input->post('qualification_id'),'3600');
                unset($_SESSION['walkin_lastId_std']);
                $msg = '<div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong> '.$response->error_message->message.' <a href="#" class="alert-link"></a>.
                </div>';
                $this->session->set_flashdata('flsh_msg',  $msg);
                redirect('walkin/walkin_registration/'.$center_name);
            }            
        }
        else
        { 
            $data['center_id_enc'] = $center_id;
            $data['center_id'] = $center_id;
            $data['center_name'] = $center_name;
            $data['segment'] = $this->_getURI();
            $data['shortBranches'] = $this->_common($headers);
           // $data['feedbackLink'] = json_decode($this->_curlGetData(base_url(GET_FL_URL), $headers));
            $data['complaintSubject']=json_decode($this->_curlGetData(base_url(GET_COMPLAINT_SUBJECT), $headers));
            $data['Offers']=json_decode($this->_curlGetData(base_url(GET_OFFERS_URL), $headers));
            $data['enquiry_purpose']= json_decode($this->_curlGetData(base_url(GET_ENQ_PURPOSE_URL), $headers));
            $data['allCnt']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_URL), $headers));
            $data['allEnqBranch']=json_decode($this->_curlGetData(base_url(GET_ENQ_BRANCH_URL), $headers));
            $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
            $data['allQua']=json_decode($this->_curlGetData(base_url(GET_ALL_QUA_URL), $headers));
            $data['allTest']=json_decode($this->_curlGetData(base_url(GET_ALL_TEST_URL), $headers));
            $data['allPgm']=json_decode($this->_curlGetData(base_url(GET_ALL_PGM_URL), $headers));
            $data['allGnd']=json_decode($this->_curlGetData(base_url(GET_ALL_GND_URL), $headers));
            $this->load->view('aa-front-end/includes/header',$data);
            $this->load->view('aa-front-end/walkin_registration_1');
            $this->load->view('aa-front-end/includes/footer');
        }

    }


    function walkin_registration($center_name){       


        $data['title'] = 'Student Walk-In Registration';
        $data['title1'] = 'Student Walk-In';
        $data['title2'] = ' Registration';
        $this->load->library('form_validation');  
        $this->form_validation->set_rules('country_code','Country code','required');
        $this->form_validation->set_rules('wkn_mobile','Mobile no.','required|trim');
        $this->form_validation->set_rules('wkn_email','Email','required|trim'); 
        $this->form_validation->set_rules('wkn_enquiry_purpose_id','Visit purpose','required');     
        $this->form_validation->set_rules('wkn_fname','First name','required');
        $this->form_validation->set_rules('wkn_gender_name','Gender','required');
        $this->form_validation->set_rules('wkn_dob','Birth date','required');
        $this->form_validation->set_rules('wkn_qualification_id','Qualification','required');
        $this->form_validation->set_rules('wkn_country_id','Prefered Country','required');
        $centerData = $this->Center_location_model->get_centerId($center_name);
        $center_id = $centerData['center_id'];
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,
        );  
             
        if($this->form_validation->run())     
        {            
            if($this->input->post('wkn_country_id') and !$this->input->post('country_id2')){
                $country_id = $this->input->post('wkn_country_id');
            }elseif($this->input->post('country_id2') and !$this->input->post('wkn_country_id')){
                $country_id = $this->input->post('country_id2');
            }elseif($this->input->post('wkn_country_id') and $this->input->post('country_id2')){
                $country_id = $this->input->post('country_id2');
            }elseif(!$this->input->post('wkn_country_id') and !$this->input->post('country_id2')){
                $country_id=NULL;
            }else{
                $country_id=NULL;
            }
            $params = array(
                'center_id'=> $center_id,
                'country_code' => $this->input->post('country_code'),
                'mobile'=> $this->input->post('wkn_mobile'),
                'email' => $this->input->post('wkn_email'),
                'enquiry_purpose_id'=> $this->input->post('wkn_enquiry_purpose_id'),
                'sub_events'        => $this->input->post('wkn_sub_events'),
                'test_module_id'    => $this->input->post('wkn_test_module_id'), 
                'programe_id'       => $this->input->post('wkn_programe_id'),
                'free_demo'         => $this->input->post('wkn_free_demo'),
                'fname' => $this->input->post('wkn_fname'), 
                'lname' => $this->input->post('wkn_lname'),
                'gender_name' => $this->input->post('wkn_gender_name'),
                'dob' => $this->input->post('wkn_dob'),
                'country_id' => $country_id,
                'qualification_id' => $this->input->post('wkn_qualification_id')
            );
            
            $response= json_decode($this->_curPostData(base_url(SUBMIT_WALKIN_STD_URL), $headers, $params));
            if($response->error_message->success==1){
                $_SESSION['walkin_lastId_std'] = $response->error_message->dataId;
                delete_cookie('center_id');
                delete_cookie('country_code');
                delete_cookie('mobile');
                delete_cookie('email');                
                delete_cookie('fname');
                delete_cookie('lname');                
                delete_cookie('enquiry_purpose_id');
                delete_cookie('test_module_id');
                delete_cookie('programe_id');
                delete_cookie('free_demo');
                delete_cookie('gender_name');
                delete_cookie('dob');
                delete_cookie('country_id');
                delete_cookie('qualification_id');
               /* $msg = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> '.$response->error_message->message.' <a href="#" class="alert-link"></a>.
                </div>';*/
                header('Content-Type: application/json');
                $response = ['msg'=>'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$response->error_message->message.'<a href="#" class="alert-link"></a>.</div>', 'status'=>1];
            echo json_encode($response);
                //$this->session->set_flashdata('flsh_msg',  $msg);
                //redirect('walkin/student_walkin_otp');

            }
            elseif ($response->error_message->success==2){
                unset($_SESSION['walkin_lastId_std']);
                header('Content-Type: application/json');
                $response = ['msg'=>'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$response->error_message->message.'<a href="#" class="alert-link"></a>.</div>', 'status'=>0];
                echo json_encode($response);
                /*$msg = '<div class="alert alert-info alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>NOTICE:</strong> '.$response->error_message->message.' <a href="#" class="alert-link"></a>.
                </div>';
                $this->session->set_flashdata('flsh_msg',  $msg);
                redirect('walkin/walkin_registration/'.$center_name);*/
            }
            else{
                set_cookie('center_id',$center_id,'3600');
                set_cookie('country_code',$this->input->post('country_code'),'3600');
                set_cookie('mobile',$this->input->post('mobile'),'3600');
                set_cookie('email',$this->input->post('email'),'3600');
                set_cookie('enquiry_purpose_id',$this->input->post('enquiry_purpose_id'),'3600');
                set_cookie('test_module_id',$this->input->post('test_module_id'),'3600');
                set_cookie('programe_id',$this->input->post('programe_id'),'3600');
                set_cookie('free_demo',$this->input->post('free_demo'),'3600');                
                set_cookie('fname',$this->input->post('fname'),'3600');
                set_cookie('lname',$this->input->post('lname'),'3600'); 
                set_cookie('gender_name',$this->input->post('gender_name'),'3600');
                set_cookie('dob',$this->input->post('dob'),'3600');
                set_cookie('country_id',$country_id,'3600');
                set_cookie('qualification_id',$this->input->post('qualification_id'),'3600');
                unset($_SESSION['walkin_lastId_std']);
                /*$msg = '<div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong> '.$response->error_message->message.' <a href="#" class="alert-link"></a>.
                </div>';
                $this->session->set_flashdata('flsh_msg',  $msg);*/

                header('Content-Type: application/json');
                $response = ['msg'=>'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$response->error_message->message.'<a href="#" class="alert-link"></a>.</div>', 'status'=>0];
                echo json_encode($response);

               // redirect('walkin/walkin_registration/'.$center_name);
            }            
        }
        else
        { 
            $data['center_id_enc'] = $center_id;
            $data['center_id'] = $center_id;
            $data['center_name'] = $center_name;
            $data['segment'] = $this->_getURI();
            //$data['shortBranches'] = $this->_common($headers);
           // $data['feedbackLink'] = json_decode($this->_curlGetData(base_url(GET_FL_URL), $headers));
            $data['complaintSubject']=json_decode($this->_curlGetData(base_url(GET_COMPLAINT_SUBJECT), $headers));
            $data['Offers']=json_decode($this->_curlGetData(base_url(GET_OFFERS_URL), $headers));
            $data['enquiry_purpose']= json_decode($this->_curlGetData(base_url(GET_ENQ_PURPOSE_URL), $headers));
            $data['allCnt']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_URL), $headers));
            $data['allEnqBranch']=json_decode($this->_curlGetData(base_url(GET_ENQ_BRANCH_URL), $headers));
            $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
            $data['allQua']=json_decode($this->_curlGetData(base_url(GET_ALL_QUA_URL), $headers));
            $data['allTest']=json_decode($this->_curlGetData(base_url(GET_ALL_TEST_URL), $headers));
            $data['allPgm']=json_decode($this->_curlGetData(base_url(GET_ALL_PGM_URL), $headers));
            $data['allGnd']=json_decode($this->_curlGetData(base_url(GET_ALL_GND_URL), $headers));
            $data['GET_GOOGLE_FEEDBACK_BRANCH'] = json_decode($this->_curlGetData(base_url(GET_GOOGLE_FEEDBACK_BRANCH), $headers));
        //get feedback branch dropdown option list
        $data['FEEDBACK_TOPIC'] = json_decode($this->_curlGetData(base_url(GET_FEEDBACK_TOPIC_URL), $headers));
          $data['complaintSubject'] = json_decode($this->_curlGetData(base_url(GET_COMPLAINT_SUBJECT), $headers));
            $this->load->view('aa-front-end/includes/header',$data);
            $this->load->view('aa-front-end/walkin_registration');
            $this->load->view('aa-front-end/includes/footer');
        }

    }

    
    function student_walkin_otp(){        
        
        $data['title'] = 'Student Walkin OTP verification';
        if(isset($_SESSION['walkin_lastId_std'])){
            $s = $_SESSION['walkin_lastId_std'];
        }else{
            $s = 0;
        }
        $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'LAST-ID:'.$s,  
        ); 
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('wkn_reg_otp','OTP','required');      
        
        if($this->form_validation->run()){
            $params = array(
                'otp'=> $this->input->post('wkn_reg_otp'),
            );
            $response = json_decode($this->_curPostData(base_url(VERIFY_WALKIN_STD_URL), $headers, $params));
            if($response->error_message->success==1){
                unset($_SESSION['walkin_lastId_std']);
                /*$msg = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> '.$response->error_message->message.'<a href="#" class="alert-link"></a>.
                </div>';               
                $this->session->set_flashdata('flsh_msg', $msg);
                redirect('walkin/student_walkin_thanks');*/

              header('Content-Type: application/json');
                $response = ['msg'=>'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$response->error_message->message.'<a href="#" class="alert-link"></a>.</div>', 'status'=>1];
                echo json_encode($response);



            }elseif($response->error_message->success==0){  
              /*  $msg = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>WRONG:</strong>  '.$response->error_message->message.'<a href="#" class="alert-link"></a>.
                </div>';              
                $this->session->set_flashdata('flsh_msg', $msg);
                redirect('walkin/student_walkin_otp');*/
                header('Content-Type: application/json');
                $response = ['msg'=>'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$response->error_message->message.'<a href="#" class="alert-link"></a>.</div>', 'status'=>0];
                echo json_encode($response);


            }else{
                /*$msg = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>WRONG:</strong>  '.$response->error_message->message.'<a href="#" class="alert-link"> </a>.
                </div>';
                $this->session->set_flashdata('flsh_msg', $msg);
                redirect('walkin/student_walkin_otp');*/
                header('Content-Type: application/json');
                $response = ['msg'=>'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> '.$response->error_message->message.'<a href="#" class="alert-link"></a>.</div>', 'status'=>2];
                echo json_encode($response);
            }          
        }
        else
        {            
            $data['title'] = 'Thanks';
            $headers = array(
                'API-KEY:'.WOSA_API_KEY
            ); 
            $data['segment'] = $this->_getURI();       
            $data['shortBranches'] = $this->_common($headers);
            $data['allCnt']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_URL), $headers));
            //$data['feedbackLink']=json_decode($this->_curlGetData(base_url(GET_FL_URL), $headers));
             $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
            $this->load->view('aa-front-end/includes/header',$data);
            $this->load->view('aa-front-end/student_walkin_otp');
            $this->load->view('aa-front-end/includes/footer');
        }
        
    }

    function student_walkin_thanks(){

        $data['title'] = 'Thanks for Walk In!';
        //unset($_SESSION['walkin_lastId_std']);
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,
        ); 
        //feddback url
        //$data['feedbackLink'] = json_decode($this->_curlGetData(base_url(GET_FL_URL), $headers));
        $data['segment'] = $this->_getURI();      
        $data['shortBranches'] = $this->_common($headers);
            
        $data['allCnt'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/student_walkin_thanks');
        $this->load->view('aa-front-end/includes/footer');
    }
    
}
 