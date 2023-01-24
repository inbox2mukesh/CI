<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Demo_counselling_session extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();      
    }

    function index()
    {  
        $data['segment'] = $this->_getURI();
        $data['title'] = 'Demo & Counselling Session';
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
        $this->load->helper('text');
        $data['complaintSubject'] = json_decode($this->_curlGetData(base_url(GET_COMPLAINT_SUBJECT), $headers));
        $data['Offers'] = json_decode($this->_curlGetData(base_url(GET_OFFERS_URL), $headers));
        //$data['shortBranches'] = $this->_common($headers);
        $data['enquiry_purpose'] = json_decode($this->_curlGetData(base_url(GET_ENQ_PURPOSE_URL), $headers));
        $data['allTest'] = json_decode($this->_curlGetData(base_url(GET_ALL_TEST_URL), $headers));
        $data['allPgm'] = json_decode($this->_curlGetData(base_url(GET_ALL_PGM_URL), $headers));
        $data['GET_SESSION_TYPE_URL'] = json_decode($this->_curlGetData(base_url(GET_SESSION_TYPE_URL), $headers));
        $data['allEnqBranch'] = json_decode($this->_curlGetData(base_url(GET_ENQ_BRANCH_URL), $headers));
        $data['countryCode'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['mPopupData']=json_decode($this->_curlGetData(base_url(GET_MPOPUP_URL), $headers));
         $data['GET_GOOGLE_FEEDBACK_BRANCH'] = json_decode($this->_curlGetData(base_url(GET_GOOGLE_FEEDBACK_BRANCH), $headers));    
        $data['FEEDBACK_TOPIC'] = json_decode($this->_curlGetData(base_url(GET_FEEDBACK_TOPIC_URL), $headers));	
        //for practice pack
        $data['AllTestModule_PP'] = json_decode($this->_curlGetData(base_url(GET_ALL_PRACTICE_TEST_MODULE_URL), $headers));
        $data['All_CD_IELTS_Pack_PP'] =json_decode($this->_curlGetData(base_url(GET_CD_IELTS_PP_PACK_URL), $headers));
        $data['All_IELTS_Pack_PP'] =json_decode($this->_curlGetData(base_url(GET_IELTS_PP_PACK_URL), $headers));
        $data['All_PTE_Pack_PP'] =json_decode($this->_curlGetData(base_url(GET_PTE_PP_PACK_URL), $headers));
        $data['All_SE_Pack_PP'] =json_decode($this->_curlGetData(base_url(GET_SE_PP_PACK_URL), $headers));
        $data['All_Pack_PP'] =json_decode($this->_curlGetData(base_url(GET_ALL_PP_PACK_URL), $headers));
           //for reality test
        $data['AllTestModule_RT'] = json_decode($this->_curlGetData(base_url(GET_ALL_RT_MODULE_URL), $headers));
        $data['ALL_RT_short'] = json_decode($this->_curlGetData(base_url(GET_ALL_RT_SHORT_URL), $headers));
        $data['IELTS_RT_short'] = json_decode($this->_curlGetData(base_url(GET_IELTS_RT_short_URL), $headers));
        $data['CD_IELTS_RT_short'] = json_decode($this->_curlGetData(base_url(GET_CD_IELTS_RT_short_URL), $headers));
        $data['PTE_RT_short'] = json_decode($this->_curlGetData(base_url(GET_PTE_RT_short_URL), $headers));
        $data['All_TSMT'] = json_decode($this->_curlGetData(base_url(GET_ALL_SHORT_TESTIMONIALS_URL), $headers));
        //Ttextual tsmt
        $data['All_TXT_TSMT'] = json_decode($this->_curlGetData(base_url(GET_TEXTUAL_TESTIMONIAL_SHORT), $headers));  
        //for recent results
        $data['All_RR_short']= json_decode($this->_curlGetData(base_url(GET_ALL_RR_URL_SHORT), $headers));
         //Products
        $data['All_PRODUCTS'] =json_decode($this->_curlGetData(base_url(GET_ALL_PRODUCTS_URL), $headers));
        $data['FREE_RESOURCE_CONTENT_FEATURED'] = json_decode($this->_curlGetData(base_url(FREE_RESOURCE_CONTENT_FEATURED), $headers));

        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/demo_counselling_session');
        $this->load->view('aa-front-end/includes/footer');
    }

   /*Get session course list*/
    function GetSessionCourse()
    {
        $session_type   = $this->input->post('session_type', true);
        $headers = array(
        'API-KEY:'.WOSA_API_KEY,       
        'SESSION-TYPE:'.$session_type               
        );
        $data['SESSION_COURSE_URL'] = json_decode($this->_curlGetData(base_url(GET_SESSION_COURSE_URL), $headers));        
        $this->load->view('aa-front-end/demo_counselling_session_courselist_ajax',$data);
    }

    /*Get session Branch/Coaching Plateform list*/
     function GetSessionBranch()
    {
        $session_type   = $this->input->post('session_type', true);
        $headers = array(
        'API-KEY:'.WOSA_API_KEY,       
        'SESSION-TYPE:'.$session_type               
        );
        $data['SESSION_BRANCH_URL'] = json_decode($this->_curlGetData(base_url(GET_SESSION_BRANCH_URL), $headers));        
        $this->load->view('aa-front-end/demo_counselling_session_branchlist_ajax',$data);
    }

    function getSessionDates()
    {
         $session_type=$this->input->post('session_type');
         $sessionCourse=$this->input->post('sessionCourse');
         $sessionBranch=$this->input->post('sessionBranch');
         $headers = array(
        'API-KEY:'.WOSA_API_KEY,       
        'SESSION-TYPE:'.$session_type,
        'COURSE-ID:'.$sessionCourse,
        'BRANCH-ID:'.$sessionBranch                   
         );
        $response = json_decode($this->_curlGetData(base_url(GET_SESSION_DATES_URL), $headers));
        end($response->error_message->data);
        $lastkey=key($response->error_message->data);

        $session_date_from=$response->error_message->data[0]->session_date;
        $session_date_to=$response->error_message->data[$lastkey]->session_date;
        foreach($response->error_message->data as $val)
        {
               $min_date=date_create($val->session_date);
               $datap[] = date_format($min_date,"d-m-Y");

        }            
        $session_date_from=date_create($session_date_from);
        $session_date_from= date_format($session_date_from,"d-m-Y");

        $session_date_to=date_create($session_date_to);
        $session_date_to= date_format($session_date_to,"d-m-Y");

        $data['min_date'] = $session_date_from;
        $data['max_date'] = $session_date_to;
        $pp=json_encode($datap);
        $data['dt_range']=json_decode($pp); 
        echo json_encode($data);        
    }

    function getSessionTimeSlot()
    {
        $session_type=$this->input->post('sessionType');
        $sessionCourse=$this->input->post('sessionCourse');
        $sessionBranch=$this->input->post('sessionBranch');
        $sessionDates=$this->input->post('sessionDates');
        $sessionDates=date_create($sessionDates);
        $sessionDates= date_format($sessionDates,"Y-m-d");
        $headers = array(
        'API-KEY:'.WOSA_API_KEY,       
        'SESSION-TYPE:'.$session_type,
        'COURSE-ID:'.$sessionCourse,
        'BRANCH-ID:'.$sessionBranch,  
        'DATE-ID:'.$sessionDates,                  
        );
        $data['SESSION_TIMESLOT_URL'] = json_decode($this->_curlGetData(base_url(GET_SESSION_TIMESLOT_URL), $headers));   
        $this->load->view('aa-front-end/demo_counselling_session_timeslot_ajax',$data);
    }

    function getFinalSession()
    {
        $session_type=$this->input->post('sessionType');
        $sessionCourse=$this->input->post('sessionCourse');
        $sessionBranch=$this->input->post('sessionBranch');
        $sessionDates=$this->input->post('sessionDates');
        $sessionTimeSlot=$this->input->post('sessionTimeSlot');
        $sessionDates=date_create($sessionDates);
        $sessionDates= date_format($sessionDates,"Y-m-d");
        $headers = array(
        'API-KEY:'.WOSA_API_KEY,       
        'SESSION-TYPE:'.$session_type,
        'COURSE-ID:'.$sessionCourse,
        'BRANCH-ID:'.$sessionBranch,  
        'DATE-ID:'.$sessionDates,      
        'TIME-SLOT:'.$sessionTimeSlot,               
        );
        $data['FINAL_SESSION_URL'] = json_decode($this->_curlGetData(base_url(GET_FINAL_SESSION_URL), $headers)); 
        header('Content-Type: application/json');
         foreach($data['FINAL_SESSION_URL']->error_message->data as $p)
         {
            header('Content-Type: application/json');
            $response = ['counseling_sessions_group_id'=>$p->counseling_sessions_group_id, 'zoom_link'=>$p->zoom_link];
            echo json_encode($response);
         }
    }

    function book_session()
    {
        $headers = array(
        'API-KEY:'.WOSA_API_KEY                  
        );      
        if(isset($_SESSION['params_data']))
        {
        unset($_SESSION['params_data']);
        }
        if(isset($_SESSION['actionFor']))
        {
        unset($_SESSION['actionFor']);
        }
        if(isset($_SESSION['book_packid']))
        {
        unset($_SESSION['book_packid']);
        }
       //check student is already logged in or not
        if($this->session->userdata('student_login_data'))
        {
            //student is Logged In
            $params = array(                             
            'student_id'=>$this->session->userdata('student_login_data')->id,
            'fname'=>$this->input->post('dc_fname'),
            'lname'=>$this->input->post('dc_lname'),
            'dob'=>$this->input->post('dc_dob'),
            'email'=>$this->input->post('dc_email'),
            'country_code'=>$this->input->post('dc_country_code'),
            'mobile'=>$this->input->post('dc_mobile'),
            'session_type'=>$this->input->post('dc_session_type'),
            'test_module_id'=>$this->input->post('dc_course'),
            'programe_id'=>$this->input->post('dc_programe'),
            'center_id'=>$this->input->post('dc_coaching'),
            'booking_date'=>$this->input->post('dc_bookingdate'),
            'booking_time_slot'=>$this->input->post('dc_timeslot'),
            'session_id'=>$this->input->post('sessiongroupid'),
            'booking_link'=>$this->input->post('sessionzoomlink'), 
            'active'=>1          
            );          
                     
            $response=json_decode($this->_curPostData(base_url(BOOK_SESSION), $headers, $params)); 
            if($response->error_message->success==1)
            {
                header('Content-Type: application/json');
                $response = ['status'=>1];
                echo json_encode($response);  
            } 
            else 
            {
                header('Content-Type: application/json');
                $response = ['status'=>0];
                echo json_encode($response);  
            }           
            
        }
        else 
        {
            $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'MOBILE:'.$this->input->post('dc_mobile', true),  
            'EMAIL:'.$this->input->post('online_email', true),                       
            );
           // check student mobile no/email is exist in db or not
            $response= json_decode($this->_curlGetData(base_url(GET_STUDENT_EXISTENCE_URL), $headers));  


           // CASE 1 : Fresh user, call registration api once registration process done then redirect to checkout page
            if($response->error_message->success==0 AND $response->error_message->message == 'fresh')
            {           
               //call register api
                $params = array(                             
                    'fname' => $this->input->post('dc_fname'), 
                    'lname' => $this->input->post('dc_lname'),               
                    'country_code' => $this->input->post('dc_country_code'),
                    'mobile'=> $this->input->post('dc_mobile'),
                    'email' => $this->input->post('dc_email'),
                    'dob'=> $this->input->post('dc_dob'),
                    'test_module_id'=>$this->input->post('dc_course'),
                    'programe_id'=>$this->input->post('dc_programe'),
                    'center_id'=>$this->input->post('dc_coaching'),
                    'booking_date'=>$this->input->post('dc_bookingdate'),
                    'booking_time_slot'=>$this->input->post('dc_timeslot'),
                    'session_id'=>$this->input->post('sessiongroupid'),
                    'session_type'=>$this->input->post('dc_session_type'),
                    'booking_link'=>$this->input->post('sessionzoomlink'), 
                    'active'=>1                                                    
                );
                $_SESSION['params_data'] =$params;       
                $response= json_decode($this->_curPostData(base_url(SUBMIT_STD_URL), $headers, $params));
               if($response->error_message->success==1)
                {
                    $_SESSION['lastId_std'] = $response->error_message->data;
                    $_SESSION['actionFor'] = 'booking_session'; // session booking
                    $msg = '<div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>SUCCESS:</strong> '.$response->error_message->message.' <a href="#" class="alert-link"></a>.
                    </div>';
                    header('Content-Type: application/json');
                    $response = ['msg'=>$msg, 'status'=>2];
                    echo json_encode($response);                
                }
                else
                {
                    unset($_SESSION['lastId_std']);
                    unset($_SESSION['actionFor']);
                    header('Content-Type: application/json');
                    $msg = '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>FAILED:</strong> '.$response->error_message->message.' <a href="#" class="alert-link"></a>.
                    </div>';
                    $response = ['msg'=>$msg, 'status'=>'false'];
                   echo json_encode($response);              
                }

            }
            // CASE 2 : existing user having active=1 and is_otp_verified=1 
            elseif($response->error_message->message=="existing" AND $response->error_message->active == 1 AND $response->error_message->is_otp_verified == 1 )
            {
                $params = array(                             
                    'fname' => $this->input->post('dc_fname'), 
                    'lname' => $this->input->post('dc_lname'),               
                    'country_code' => $this->input->post('dc_country_code'),
                    'mobile'=> $this->input->post('dc_mobile'),
                    'email' => $this->input->post('dc_email'),
                    'dob'=> $this->input->post('dc_dob'),
                    'test_module_id'=>$this->input->post('dc_course'),
                    'programe_id'=>$this->input->post('dc_programe'),
                    'center_id'=>$this->input->post('dc_coaching'),
                    'booking_date'=>$this->input->post('dc_bookingdate'),
                    'booking_time_slot'=>$this->input->post('dc_timeslot'),
                    'session_id'=>$this->input->post('sessiongroupid'),
                    'session_type'=>$this->input->post('dc_session_type'),
                    'booking_link'=>$this->input->post('sessionzoomlink'), 
                    'active'=>1                                                    
                );
                $_SESSION['params_data'] =$params;             
                $_SESSION['lastId_std'] = $response->error_message->student_id;
                $_SESSION['actionFor'] = 'booking_session'; // session booking
                //echo "existing";
                header('Content-Type: application/json');
                $response = ['msg'=>"existing", 'status'=>3];
                echo json_encode($response);
            }
            // CASE 3 : existing user having active=0 and is_otp_verified=0 
            elseif($response->error_message->message=="existing" AND $response->error_message->active == 0 AND $response->error_message->is_otp_verified == 0 )
            {           
                /*1. otp update
                  2. send otp
                  3.otp pop open  
                */ 
               $params = array(                             
                'fname' => $this->input->post('dc_fname'), 
                'lname' => $this->input->post('dc_lname'),               
                'country_code' => $this->input->post('dc_country_code'),
                'mobile'=> $this->input->post('dc_mobile'),
                'email' => $this->input->post('dc_email'),
                'dob'=> $this->input->post('dc_dob'),
                'test_module_id'=>$this->input->post('dc_course'),
                'programe_id'=>$this->input->post('dc_programe'),
                'center_id'=>$this->input->post('dc_coaching'),
                'booking_date'=>$this->input->post('dc_bookingdate'),
                'booking_time_slot'=>$this->input->post('dc_timeslot'),
                'session_id'=>$this->input->post('sessiongroupid'),
                'session_type'=>$this->input->post('dc_session_type'),
                'booking_link'=>$this->input->post('sessionzoomlink'), 
                'active'=>1                                                    
                );
                $_SESSION['params_data'] =$params; 

                $headers = array(
                'API-KEY:'.WOSA_API_KEY, 
                'STUDENT-ID:'.$response->error_message->student_id,             
                );               
                //  
                $response1= json_decode($this->_curPostData(base_url(UPDATE_OTP), $headers, $params));
                if($response1->error_message->success==1)
                {
                    //opt send success
                    //open otp popup
                    $_SESSION['lastId_std'] = $response->error_message->student_id;
                     $_SESSION['actionFor'] = "booking_session"; // booking=online,offline,practice,reality test booking
                    $msg = '';
                    header('Content-Type: application/json');
                    $response2 = ['msg'=>$msg, 'status'=>2];
                    echo json_encode($response2);
                }
                else 
                {
                     //error....opt not send
                    unset($_SESSION['lastId_std']);
                    unset($_SESSION['actionFor']);
                    header('Content-Type: application/json');
                    $opterror="Error...Try again";
                    $msg = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong> '.$opterror.' <a href="#" class="alert-link"></a>.
                    </div>';
                    $response2 = ['msg'=>$msg, 'status'=>'false'];
                    echo json_encode($response2);  
                }


               
            }
             // CASE 4 : for blocked user 
            elseif($response->error_message->message=="existing" AND $response->error_message->active == 0 AND $response->error_message->is_otp_verified == 1 )
            {
                unset($_SESSION['lastId_std']);
                unset($_SESSION['actionFor']);
                header('Content-Type: application/json');
                $opterror='Dear user you are blocked from the system. Please contact to our admin or  <a href="#" class="anc_clickhere" onclick="anc_clickhere()" data-toggle="modal" data-target="#modal-complaint">click here</a> to raise complaint ';
                $msg = '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>FAILED:</strong> '.$opterror.' <a href="#" class="alert-link"></a>.
                </div>';
                $response2 = ['msg'=>$msg, 'status'=>4];
                echo json_encode($response2);

            }

        }
      
    }

    function post_book_session()
    {
        $headers = array(
        'API-KEY:'.WOSA_API_KEY                  
        );
        $booking_date=date_create( $_SESSION['params_data']['booking_date']);
        $booking_date=date_format($booking_date,"Y-m-d");
        $params = array(                             
            'student_id'=>$_SESSION['lastId_std'],
            'fname'=> $_SESSION['params_data']['fname'],
            'lname'=> $_SESSION['params_data']['lname'],
            'dob'=> $_SESSION['params_data']['dob'],
            'email'=> $_SESSION['params_data']['email'],
            'country_code'=> $_SESSION['params_data']['country_code'],
            'mobile'=> $_SESSION['params_data']['mobile'],
            'session_type'=> $_SESSION['params_data']['session_type'],
            'test_module_id'=> $_SESSION['params_data']['test_module_id'],
            'programe_id'=> $_SESSION['params_data']['programe_id'],
            'center_id'=> $_SESSION['params_data']['center_id'],
            'booking_date'=> $booking_date,
            'booking_time_slot'=> $_SESSION['params_data']['booking_time_slot'],
            'session_id'=> $_SESSION['params_data']['session_id'],
            'booking_link'=> $_SESSION['params_data']['booking_link'], 
            'active'=>1          
            );            
                     
            $response=json_decode($this->_curPostData(base_url(BOOK_SESSION), $headers, $params));
            if($response->error_message->success==1)
            {
                header('Content-Type: application/json');
                $response = ['status'=>1];
                echo json_encode($response);  
            } 
            else 
            {
                header('Content-Type: application/json');
                $response = ['status'=>0];
                echo json_encode($response);  
            }  
    }    
}
