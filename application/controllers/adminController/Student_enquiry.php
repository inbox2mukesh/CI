<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon 
 *
 **/
class Student_enquiry extends MY_Controller{
    
    function __construct(){
        
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}        
        $this->load->model('Student_enquiry_model');
        $this->load->model('Test_module_model');
        $this->load->model('Programe_master_model');
        $this->load->model('Center_location_model'); 
        $this->load->model('Student_model');
        $this->load->model('Country_model');
        $this->load->model('Student_journey_model');
        $this->load->model('Student_service_masters_model');
        $this->load->model('Enquiry_purpose_model');
        $this->load->model('User_model');                              
    } 

    /*function add_new_enquiry(){

            //access control start
            $cn = $this->router->fetch_class().''.'.php';
            $mn = $this->router->fetch_method();        
            if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
            $data['si'] = 0;
            //access control ends
            $UserFunctionalBranch = $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
            $userBranch=[];
            foreach ($UserFunctionalBranch as $b){
                array_push($userBranch,$b['center_id']);
            }        
            $data['title'] = 'Add new enquiry';
            $this->load->library('form_validation');        
            $this->form_validation->set_rules('subject','Offer Subject','required');
            $this->form_validation->set_rules('body','Offer Body','required');
            if($this->form_validation->run())
            {   
                $by_user=$_SESSION['UserId'];
                $today = date('d-m-Y');
                $params=array(
                'todayDate'=>$today,
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'dob' => $this->input->post('dob'),
                'email'    => $this->input->post('email'),
                'country_code' => $this->input->post('country_code'),
                'mobile' => $this->input->post('mobile'),             
                'enquiry_purpose_id' => $this->input->post('enquiry_purpose_id'),
                'sub_events'    => $this->input->post('sub_events'),
                'test_module_id'    => $this->input->post('test_module_id'), 
                'programe_id' => $this->input->post('programe_id'),
                'free_demo' => $this->input->post('free_demo'),  
                'center_id' => $this->input->post('center_id'), 
                'country_id' => $this->input->post('country_id'),
                'message' => $this->input->post('message'),
                'active'=> 1,
                'OTP'=> $otp,
                'is_otp_verified'=>0,
            );     
            $enquiry_id = $this->Student_enquiry_model->add_enquiry($params);
            if($enquiry_id){            
                $subject = 'Hi! your enquiry sent successfully';
                $email_message = 'Hi! your enquiry sent successfully at our Enquiry team. We will get back to soon.';
                $mailData['fname']          = $params['fname'];                
                $mailData['email']          = $params['email'];
                $mailData['email_message']  = $email_message;
                $mailData['thanks']         = THANKS;
                $mailData['team']           = WOSA;
                    
                $message1='Thank you for getting in touch with us, we will contact you regarding your query shortly.Regards Western Overseas';
                $message2 ='Hi, we would like to thank you for choosing Western Overseas. Kindly share your feedback <https://western-overseas.com/aca-erp/> Regards Western Overseas';
                if(base_url()!=BASEURL){ 
                    //$this->_call_smaGateway($params['mobile'],$message1);
                   // $this->_call_smaGateway($params['mobile'],$message2);
                }
                if(base_url()!=BASEURL){
                    $this->sendEmail_enquiry_($subject,$mailData);
                }       
                //activity update start              
                    $activity_name= ENQUIRY_ADD;
                    $description= 'New enquiry having PK-ID '.$enquiry_id.' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/student_enquiry/enquiry');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/student_enquiry/add_new_enquiry');
            } 
              
        }else{  
            $data['all_programe_masters']=$this->Programe_master_model->get_all_programe_masters_active();
            $data['all_test_module'] = $this->Test_module_model->get_all_test_module_active();
            $data['all_country_code'] = $this->Country_model->get_all_country_active();
            $data['all_services'] = $this->Student_service_masters_model->get_all_services_for_addEnq();
            $data['all_purpose'] = $this->Enquiry_purpose_model->get_all_enquiry_purpose_active();
            $data['allCnt'] = $this->Country_model->getAllCountryNameAPI_deal();
            $data['all_branch'] = $this->Center_location_model->getFunctionalBranchWithoutOnline($_SESSION['roleName'],$userBranch);
            $data['_view'] = 'student_enquiry/add_new_enquiry';
            $this->load->view('layouts/main',$data);
        }

    }*/ 

    function reply_to_student_enquiry_($enquiry_id){   
       
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $enquiry_id = base64_decode($enquiry_id);

        $data['title'] = 'Reply to enquiry';
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('admin_reply','Reply','required|trim');
        
        if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(                
                'enquiry_id' => $enquiry_id,
                'admin_reply' => $this->input->post('admin_reply'),
                'by_user' => $by_user,
            );
            $id = $this->Student_enquiry_model->add_reply($params);
            if($id){

                $params2= array('isReplied' => 1);
                $this->db->where('enquiry_id',$enquiry_id);
                $this->db->update('students_enquiry',$params2);
                $stdInfo = $this->Student_enquiry_model->get_enquiry($enquiry_id);
                $test_module_name = $stdInfo['test_module_name'];
                $email = $stdInfo['email'];
                $mobile = $stdInfo['mobile'];
                $fname = $stdInfo['fname'];  
                $admin_reply =   $this->input->post('admin_reply');
                $email_content = admin_enquiry_reply_email($stdInfo['enquiry_no'],$admin_reply) ;          
                $subject= $email_content['subject']; 
                $email_message = $email_content['content']; 
                    $mailData=[];                    
                    $mailData['fname']          = $fname;                
                    $mailData['email']          = $email;
                    $mailData['email_message']  = $email_message;
                    $mailData['thanks']         = THANKS;
                    $mailData['team']           = WOSA;
                    if(base_url()!=BASEURL){               
                        $this->sendEmailTostd_enqReply_($subject,$mailData);
                    }
                    //activity update start              
                    $activity_name= ENQUIRY_REPLY;
                    $description= 'An enquiry reply having reply ID '.$id.' sent';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
               redirect('adminController/student_enquiry/enquiry');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
               redirect('adminController/student_enquiry/reply_to_student_enquiry_/'.$enquiry_id);
            }            
        }else{            
            $data['enquiryData'] =$this->Student_enquiry_model->get_enquiry($enquiry_id);
            $data['preReplies'] = $this->Student_enquiry_model->get_preReplies($enquiry_id);
            $data['_view'] = 'student_enquiry/reply_to_student_enquiry';
            $this->load->view('layouts/main',$data);
        }
    }

    function ajax_add_student_from_enquiry(){
    
        $by_user=$_SESSION['UserId'];
        $enquiry_id = $this->input->post('enquiry_id', true);
        $params=array(
            'active'=> 1,
            'is_otp_verified'=> 1,
        );
        $this->db->trans_start();
        $update_id = $this->Student_enquiry_model->update_enquiry($enquiry_id, $params);

        $enqData = $this->Student_enquiry_model->get_enquiry_data($enquiry_id);
        //activity update start              
            $activity_name= ENQUIRY_ADD;
            $description= 'New enquiry having PK-ID '.$enquiry_id.' added';
            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
        //activity update end
        // $subject = 'Hi! your enquiry sent successfully';
        // $email_message = 'Hi! your enquiry sent successfully at our Enquiry team. We will get back to soon.';
        $enquiry_content = enquiry_email($enquiry_id);
        $subject = $enquiry_content['subject'];
        $email_message = $enquiry_content['content'];
        $mailData['fname']          = $enqData['fname'];                
        $mailData['email']          = $enqData['email'];
        $mailData['email_message']  = $email_message;
        $mailData['thanks']         = THANKS;
        $mailData['team']           = WOSA;
                
        $message1='Thank you for getting in touch with us, we will contact you regarding your query shortly.Regards Western Overseas';
        $message2 ='Hi, we would like to thank you for choosing Western Overseas. Kindly share your feedback <https://western-overseas.com/aca-erp/> Regards Western Overseas';
        if(base_url()!=BASEURL){ 
            //$this->_call_smaGateway($enqData['mobile'],$message1);
           // $this->_call_smaGateway($enqData['mobile'],$message2);
        }
        if(base_url()!=BASEURL){
            $this->sendEmail_enquiry_($subject,$mailData);
        }
                //student reg process here..
                $pack_cb=''; $fresh = 0; $service_id=10;
                $today = date('d-m-Y');
                $todaystr = strtotime($today);
                $token= 0;
                $data['CountryIdData'] =$this->Country_model->get_country_id($enqData['country_code']);
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
                    'country_id'      =>  $country_id,
                    'fname'           =>  ucfirst($enqData['fname']),
                    'lname'           =>  ucfirst($enqData['lname']),
                    'dob'             =>  $enqData['dob'],
                    'active'          => 1,
                    'fresh'           => $fresh,
                );
                $student_id = $this->Student_model->add_student($params);
                if($student_id!='duplicate'){                   

                    $studentStatus = $this->_calculateStatus($params['service_id'],$params['center_id'],$params['test_module_id'],$params['programe_id'],$pack_cb);
                    $student_identity = $studentStatus['student_identity'];
                    $details = $studentStatus['details'];

                    $params2 = array('student_identity'=> $student_identity);
                    $params3 = array('student_id'=>$student_id, 'student_identity'=> $student_identity,'details'=> $details,'by_user'=>$by_user);
                    $idd = $this->Student_model->update_student($student_id, $params2);
                    $std_journey = $this->Student_journey_model->update_studentJourney($params3);
                    $email_content = student_registration();
                    $subject = $email_content['subject'];
                    $email_message = $email_content['content'];
                    $footer_text = $email_content['email_footer_content'];
                    // $subject='Registration successfull- WOSA'; 
                    // $email_message='Dear '.ucfirst($this->input->post('fname')).', You are registered successfully at Western Overseas.Details are as below:';
                        $mailData=[];
                        $mailData['password']       = $plain_pwd;
                        $mailData['fname']          = $enqData['fname'];                
                        $mailData['email']          = $enqData['email'];
                        $mailData['email_message']  = $email_message;
                        $mailData['thanks']         = THANKS;
                        $mailData['team']           = WOSA;
                        $mailData['email_footer_text'] = $footer_text;
                        if(base_url()!=BASEURL){               
                            $this->sendEmailTostd_creds_($subject,$mailData);
                        }                 
                    $this->db->trans_complete();
                    if($this->db->trans_status() === FALSE){
                        header('Content-Type: application/json');
                        $response = ['msg'=>'failed', 'status'=>'false'];
                        echo json_encode($response);
                    }else{
                        header('Content-Type: application/json');
                        $response = ['msg'=>'success', 'status'=>'true'];
                        echo json_encode($response); 
                    }
    
        } 

    }

    
    function enquiry($enquiry_purpose_id=0){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}        
        //access control ends
        /*$UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }*/

        $data['all_purpose'] = $this->Student_enquiry_model->get_all_purpose();
        $data['all_enquiryDates'] = $this->Student_enquiry_model->get_all_enquiryDates();
        $data['title'] = 'Enquiry By Students';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/student_enquiry/enquiry/'.$enquiry_purpose_id.'?');
        $config['total_rows'] = $this->Student_enquiry_model->get_all_enquiry_count($enquiry_purpose_id);
        $this->pagination->initialize($config);        
        $data['enquiry'] = $this->Student_enquiry_model->get_all_enquiry($enquiry_purpose_id,$params);
        $data['_view'] = 'student_enquiry/enquiry'; 
        $this->load->view('layouts/main',$data);
    }

    function ajax_filterEnquiryByDate($filterDate){
        
        $UserFunctionalBranch=$this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $data['all_purpose'] = $this->Student_enquiry_model->get_all_purpose();
        $data['all_enquiryDates'] = $this->Student_enquiry_model->get_all_enquiryDates();
        $data['title'] = 'Enquiry By Date';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/student_enquiry/enquiry/'.$filterDate.'?');
        $config['total_rows'] = $this->Student_enquiry_model->get_all_enquiry_count_filterDate($filterDate);
        $this->pagination->initialize($config);        
        $data['enquiry'] = $this->Student_enquiry_model->get_all_enquiry_filterDate($filterDate,$params);
        $data['_view'] = 'student_enquiry/enquiry';
        $this->load->view('layouts/main',$data);
    }

    function enquiry_not_replied(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}        
        //access control ends
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }
        
        $data['all_purpose'] = $this->Student_enquiry_model->get_all_purpose();
        $data['all_enquiryDates'] = $this->Student_enquiry_model->get_all_enquiryDates();

        $data['title'] = 'Enquiry By Students';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('student_enquiry/enquiry_not_replied?');
        $config['total_rows'] = $this->Student_enquiry_model->get_all_no_enquiry_count();
        $this->pagination->initialize($config);
        
        $data['enquiry'] = $this->Student_enquiry_model->get_all_enquiry_not_replied($params);
        $data['_view'] = 'student_enquiry/enquiry';
        $this->load->view('layouts/main',$data);
    }
    
    
}
