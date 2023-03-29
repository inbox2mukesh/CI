<?php
//ob_start();
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Our_students extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Enquiry_purpose_model');
        $this->load->model('News_model');
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . @$_SESSION['classroom_id'],               
        );           
        $GLOBALS['curPack']=json_decode($this->_curlGetData(base_url(GET_CUR_PACK_URL), $headers)); 
        $GLOBALS['allClassSchedule']=json_decode($this->_curlGetData(base_url(GET_CLASS_SCH_URL_LONG_COUNT), $headers));
        $GLOBALS['countryCode'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $GLOBALS['announcements'] = json_decode($this->_curlGetData(base_url(GET_ANNOUNCEMENTS_URL), $headers));
        $GLOBALS['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $GLOBALS['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        
    }
    function createClassroomSession()
    {
        $classroom_id = $this->input->post('classroom_id', true);
        $classroom_Validity = $this->input->post('classroom_Validity', true);
        $classroom_daysleft = $this->input->post('classroom_daysleft', true);
        $classroom_isoffline = $this->input->post('classroom_isoffline', true);
        $package_id = $this->input->post('package_id', true);
        $student_package_id = $this->input->post('student_package_id', true);
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'CLASSROOM-ID:' . $classroom_id,
        );
        if ($classroom_id) {
            $_SESSION['classroom_id'] = $classroom_id;
            $_SESSION['stucurrent_package_id'] = $student_package_id;
            $classroomData = json_decode($this->_curlGetData(base_url(GET_CLASSROOM_NAME), $headers));
            $classroom_name = $classroomData->error_message->data->classroom_name;
            $_SESSION['classroom_name'] = $classroom_name;
            $_SESSION['classroom_Validity'] = $classroom_Validity;
            $_SESSION['classroom_daysleft'] = $classroom_daysleft;
            $_SESSION['classroom_isoffline'] = $classroom_isoffline;
            //$_SESSION['classroom_name'] =$classroom_name;
            $response = 1;
        } else {
            $_SESSION['classroom_id'] = 0;
            $_SESSION['classroom_name'] = 'n/a';
            $_SESSION['classroom_isoffline'] = 0;
            $response = 0;
        }
        echo $response;
    }
    function student_classroom()
    {
      
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif (!$_SESSION['classroom_id'] or $_SESSION['classroom_id'] == 0) {
            redirect('our_students/student_dashboard');
            exit;
        } else {
            $data['title'] = 'Student Dashboard';
            /*---------COMMON API CALL-----*/  
            $data['curPack']= $GLOBALS['curPack'];
            $data['allClassSchedule'] = $GLOBALS['allClassSchedule'];
            $data['countryCode'] = $GLOBALS['countryCode']; 
            $data['announcements']=$GLOBALS['announcements'];
            $data['serviceData']=$GLOBALS['serviceData'];
            $data['newsData']=$GLOBALS['newsData'];
            /*---------ENDS-----*/       
            $data['segment'] = $this->_getURI3(); //for student profile side menu           
            //$data['stdPost'] = json_decode($this->_curlGetData(base_url(GET_STD_POST_URL), $headers));
            $headers_a = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-PACK-ID:' . $_SESSION['stucurrent_package_id'],
            );            
            $data['STU_PACK_START_DATE'] = json_decode($this->_curlGetData(base_url(STU_PACK_START_DATE), $headers_a));
            $headers_b = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],
                'STUDENT-PACK-START-DATE:' . $data['STU_PACK_START_DATE']->error_message->data->subscribed_on_str,
                'STUDENT-PACK-END-DATE:' . strtotime($data['STU_PACK_START_DATE']->error_message->data->expired_on),
            );
           
            //print_r($headers_b);
            $data['allClassroomMaterial'] = json_decode($this->_curlGetData(base_url(GET_ALL_CLASSROOM_MATERIAL), $headers_b));
            $headers_count = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],                
            );            
            $data['allSharedDocsCount'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_COUNT_URL), $headers_count));          
			
			
			 $headers_re_count = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],
                'STUDENT-PACK-START-DATE:' . $data['STU_PACK_START_DATE']->error_message->data->subscribed_on_str,
                'STUDENT-PACK-END-DATE:' . strtotime($data['STU_PACK_START_DATE']->error_message->data->expired_on),              
            );
         $data['REC_LEC_URL_COUNT'] = json_decode($this->_curlGetData(base_url(GET_REC_LEC_URL_COUNT), $headers_re_count)); 
         //$data['callfromview'] = $this;
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/student_classroom');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function ajax_liveClasses()
    {
            $headers_a = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-PACK-ID:' . $_SESSION['stucurrent_package_id'],
            );   
            $data['allClassSchedule'] = $GLOBALS['allClassSchedule'];         
            $data['STU_PACK_START_DATE'] = json_decode($this->_curlGetData(base_url(STU_PACK_START_DATE), $headers_a));
            $headers_b = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'STUDENT-PACK-START-DATE:' . $data['STU_PACK_START_DATE']->error_message->data->subscribed_on_str,
            'STUDENT-PACK-END-DATE:' . strtotime($data['STU_PACK_START_DATE']->error_message->data->expired_on),
            );
            $data['allClassroomMaterial'] = json_decode($this->_curlGetData(base_url(GET_ALL_CLASSROOM_MATERIAL), $headers_b));

            $headers_count = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],                
            );            
            $data['allSharedDocsCount'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_COUNT_URL), $headers_count));          
            $headers_re_count = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'STUDENT-PACK-START-DATE:' . $data['STU_PACK_START_DATE']->error_message->data->subscribed_on_str,
            'STUDENT-PACK-END-DATE:' . strtotime($data['STU_PACK_START_DATE']->error_message->data->expired_on),              
            );
            $data['REC_LEC_URL_COUNT'] = json_decode($this->_curlGetData(base_url(GET_REC_LEC_URL_COUNT), $headers_re_count)); 			
            $this->load->view('aa-front-end/includes/student_all_classroom_material_ajax', $data);        
    }
    function student_dashboard()
    {   
       /*  $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
        );
       echo $this->_curlGetData(base_url(GET_CUR_PACK_URL), $headers);    */
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else { 

             $this->load->model('Package_master_model'); 
             $this->load->model('Student_package_model');
            
            $today=strtotime(date('d-m-Y'));
            $yesterday = date('d-m-Y', strtotime($today. ' - 1 days'));
            $yesterdayStr = strtotime($yesterday);
            $this->Package_master_model->DeactivateExpiredPack($today);
            $this->Student_package_model->calculateIrrDuesForExpiredPack($today);
            $this->Package_master_model->startPackByStartDate($today); 
            $this->Package_master_model->startPackOnHold($today);        
            $this->Package_master_model->activatePackWhichIsOnHold_finished($today);        
            $this->Student_package_model->suspendPackAfterDueCommittmentDate($yesterdayStr);
            $this->Student_package_model->updateDueCommittmentDate();           
            

            $data['title'] = 'Student Classroom';
            /*---------COMMON API CALL-----*/  
            $data['curPack']= $GLOBALS['curPack'];
            $data['countryCode'] = $GLOBALS['countryCode']; 
            $data['serviceData']=$GLOBALS['serviceData'];
            $data['newsData']=$GLOBALS['newsData'];
            /*---------ENDS-----*/   
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
            );
            $data['segment'] = $this->_getURI3(); //for student profile side menu 
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
            );
            $data['STD_WALLET_HISTORY'] = json_decode($this->_curlGetData(base_url(GET_STD_WALLET_HISTORY), $headers));           
            $data['wallet'] = json_decode($this->_curlGetData(base_url(GET_WALLET), $headers));            
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/student_dashboard');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function student_classroomForum()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif (!$_SESSION['classroom_id'] or $_SESSION['classroom_id'] == 0) {
            redirect('our_students/student_classroom');
            exit;
        } else {
            $data['title'] = 'Student Classroom Forum';
            /*---------COMMON API CALL-----*/  
            $data['curPack']= $GLOBALS['curPack'];
            $data['allClassSchedule'] = $GLOBALS['allClassSchedule'];
            $data['countryCode'] = $GLOBALS['countryCode'];
            $data['serviceData']=$GLOBALS['serviceData'];
            $data['newsData']=$GLOBALS['newsData']; 
            /*---------ENDS-----*/               
            $data['segment'] = $this->_getURI3(); //for student profile side menu            
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/student_classroomforum');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function student_class_post()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        }
        $data['title'] = 'Student Forum';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('post_text', 'Write Post', 'required|trim');
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
        );
        if ($this->form_validation->run()) {
            if (!empty($_FILES['post_image']['name'])) {
                $config['upload_path']   = TEMP_PATH;
                $config['allowed_types'] = STUDENT_POST_ALLOWED_TYPES;
                $config['encrypt_name']  = FALSE;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload("post_image")) {
                    $Imgdata = array('upload_data' => $this->upload->data());
                    $image = $Imgdata['upload_data']['file_name'];
                    $path = base_url(TEMP_PATH . $image);
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data_img = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data_img);
                    $params = array(
                        'post_text' => $this->input->post('post_text'),
                        'student_id' => @$this->session->userdata('student_login_data')->id,
                        'post_image' => $base64,
                        'type' => $type,
                        'active' => 1,
                    );
                } else {
                    $params = array(
                        'post_text' => $this->input->post('post_text'),
                        'student_id' => @$this->session->userdata('student_login_data')->id,
                        'type' => '',
                        'post_image' => NULL,
                        'active' => 1,
                    );
                }
            } else {
                $params = array(
                    'post_text' => $this->input->post('post_text'),
                    'student_id' => @$this->session->userdata('student_login_data')->id,
                    'type' => '',
                    'post_image' => NULL,
                    'active' => 1,
                );
            }
            $response = json_decode($this->_curPostData(base_url(SUBMIT_STD_POST_URL), $headers, $params));
            if ($response->error_message->success == 1) {
                $msg = '<div class="alert alert-success mt-10 text-center post_success_msg" role="alert"> ' . $response->error_message->message . '</a></span></div>';
                $this->session->set_flashdata('flsh_msg',  $msg);
                redirect('our_students/student_classroomForum');
                // redirect('our_students/student_classroomForum');
            } else {
                $msg = '<div class="alert alert-danger mt-10 text-center post_failed_msg" role="alert" > ' . $response->error_message->message . '</a></span></div>';
                $this->session->set_flashdata('flsh_msg',  $msg);
                redirect('our_students/student_classroomForum');
            }
        } else {
        }
    }
    function student_class_post_comment()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('post_reply_text', 'Write Post', 'required|trim');
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
        );
        if ($this->form_validation->run()) {
            $params = array(
                'post_id' => $this->input->post('post_id'),
                'by_student' => @$this->session->userdata('student_login_data')->id,
                'post_reply_text' => $this->input->post('post_reply_text'),
                'active' => 1,
            );
            $response = json_decode($this->_curPostData(base_url(SUBMIT_STD_POST_COMMENT_URL), $headers, $params));
            if ($response->error_message->success == 1) {
                $msg = '<div class="alert alert-success mt-10 text-center post_success_msg" role="alert"> ' . $response->error_message->message . '</a></span></div>';
                $this->session->set_flashdata('flsh_msg',  $msg);
                redirect('our_students/student_classroomForum');
                // redirect('our_students/student_classroomForum');
            } else {
                $msg = '<div class="alert alert-danger mt-10 text-center post_failed_msg" role="alert" > ' . $response->error_message->message . '</a></span></div>';
                $this->session->set_flashdata('flsh_msg',  $msg);
                redirect('our_students/student_classroomForum');
            }
        }
    }
    function registration_pg()
    {
        $data['countryCode'] = $GLOBALS['countryCode']; 
        $this->session->unset_userdata('student_login_data');
        if ($this->session->userdata('student_login_data')) {
            redirect('/our_students/student_dashboard');
            exit;
        }
        $data['title'] = 'Student Registration';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('country_code', 'Country code', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile no.', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('regnewdob', 'DOB', 'required|trim');
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
        );     
        if ($this->form_validation->run()) {
            $params = array(
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'country_code' => $this->input->post('country_code'),
                'mobile' => $this->input->post('mobile'),
                'email' => $this->input->post('email'),
                'dob' => $this->input->post('regnewdob')
            );          
            $response = json_decode($this->_curPostData(base_url(SUBMIT_STD_URL), $headers, $params));
            if ($response->error_message->success == 1) {
                $_SESSION['lastId_std'] = $response->error_message->data;
                $msg = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> ' . $response->error_message->message . ' <a href="#" class="alert-link"></a>.
                </div>';                
                $this->session->set_flashdata('flsh_msg',  $msg);
                redirect('our_students/student_otp');
            } else {
                unset($_SESSION['lastId_std']);
                $msg = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong> ' . $response->error_message->message . ' <a href="#" class="alert-link"></a>.
                </div>';
                $this->session->set_flashdata('flsh_msg',  $msg);
                redirect('our_students/registration');
            }
        } else {
            $data['segment'] = $this->_getURI();
           
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/registration');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function registration()
    {
        $data['countryCode'] = $GLOBALS['countryCode']; 
        $this->session->unset_userdata('student_login_data');
        if ($this->session->userdata('student_login_data')) {
            //redirect('/our_students/student_dashboard');
            // exit;
        }
        $data['title'] = 'Student Registration';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('country_code', 'Country code', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile no.', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('dob', 'DOB', 'required|trim');
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
        );
        $country_code= $this->input->post('country_code');
        $iso3_code=explode('|',$country_code); 
        if ($this->form_validation->run()) {
            $params = array(
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'country_code' => $iso3_code[0],
                'country_iso3_code' => $iso3_code[1],
                'mobile' => $this->input->post('mobile'),
                'email' => $this->input->post('email'),
                'dob' => $this->input->post('dob')
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
                $response_reg = json_decode($this->_curPostData(base_url(SUBMIT_STD_URL), $headers, $params));      
                if ($response_reg->error_message->success == 1) {
                    $_SESSION['lastId_std'] = $response_reg->error_message->data;
                    $msg = '<div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>SUCCESS:</strong> ' . $response_reg->error_message->message . ' <a href="#" class="alert-link"></a>.
                    </div>';
                    header('Content-Type: application/json');
                    $response = ['msg' => $msg, 'status' =>1];
                    echo json_encode($response);               
                } else
                {
                    unset($_SESSION['lastId_std']);                  
                    $msg = '<div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong> Somethink went wrong. Try Again <a href="#" class="alert-link"></a>.
                    </div>';
                    header('Content-Type: application/json');
                    $response = ['msg' => $msg, 'status' =>0];
                    echo json_encode($response);          
                }                                
            }
             // CASE 2 : existing user having active=1 and is_otp_verified=1, then  call login process then redirect to checkout page
        elseif($response->error_message->message=="existing" AND $response->error_message->active == 1 AND $response->error_message->is_otp_verified == 1 )
        {  
           
            //user already found with active status then only new enquiry is created
            unset($_SESSION['lastId_std']);
            //echo "ppppppp";
            header('Content-Type: application/json');
            $msg = '<div class="alert alert-warning alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>FAILED:</strong> Your Email or Mobile no already registered with us! Please try with diffrent ids or login <a href="#" class="alert-link"></a>.
            </div>';
            $response = ['msg' => $msg, 'status' => '2'];
            echo json_encode($response); 
        }
          // CASE 3 : existing user having active=0 and is_otp_verified=0, then  call opt verification process then redirect to checkout page    
        elseif($response->error_message->message=="existing" AND $response->error_message->active == 0 AND $response->error_message->is_otp_verified == 0 )
        {
            
            $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'STUDENT-ID:'.$response->error_message->student_id, 
            'SEND-EMAIL-FLAG:1',               
            );               
            //  
            $response1= json_decode($this->_curPostData(base_url(UPDATE_OTP), $headers, $student_params=null));
            if($response1->error_message->success==1)
            {
                //opt send success
                //open otp popup                    
                $_SESSION['lastId_std'] = $response->error_message->student_id;
                $msg = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> Verification code sent on your Email. Please enter.. <a href="#" class="alert-link"></a>.
                </div>'.'ppp'.$response->error_message->student_id;
                header('Content-Type: application/json');
                $response = ['msg' => $msg, 'status' =>1];
                echo json_encode($response);    
            }
            else 
            {                    //error....opt not send
                unset($_SESSION['lastId_std']);
                $msg = '<div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong> Somethink went wrong. Try Again <a href="#" class="alert-link"></a>.
                </div>';
                header('Content-Type: application/json');
                $response = ['msg' => $msg, 'status' =>0];
                echo json_encode($response);    
            }
        }
        else {
            unset($_SESSION['lastId_std']);
                $msg = '<div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong> Something went wrong. contact to admin <a href="#" class="alert-link"></a>.
                </div>';
                header('Content-Type: application/json');
                $response = ['msg' => $msg, 'status' =>0];
                echo json_encode($response); 
        }
           
        } else {
            $data['segment'] = $this->_getURI();           
            $data['allEnqBranch'] = json_decode($this->_curlGetData(base_url(GET_ENQ_BRANCH_URL), $headers));
       
            $data['allQua'] = json_decode($this->_curlGetData(base_url(GET_ALL_QUA_URL), $headers));
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/registration');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function student_otp()
    {
        
        if ($this->session->userdata('student_login_data')) {
            // redirect('/our_students/student_dashboard');
            // exit;
        }
        $data['title'] = 'Student Verification Code';
        $data['title2'] = 'verification';
        if (isset($_SESSION['lastId_std'])) {
            $s = $_SESSION['lastId_std'];
        } else {
            $s = 0;
            redirect('/our_students/student_dashboard');
        }
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'LAST-ID:' . $s,
        );

        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('otp', 'OTP', 'required');
        if ($this->form_validation->run()) {
            $params = array(
                'otp' => $this->input->post('otp'),
            );
            $response = json_decode($this->_curPostData(base_url(VERIFY_STD_URL), $headers, $params));
           
            if ($response->error_message->success == 1) {
                if (isset($_SESSION['actionFor']) and $_SESSION['actionFor'] == 'booking') {
                    // $this->load->helper('url');
                    $this->session->set_userdata('student_login_data', $response->error_message->data);
                   
                    header('Content-Type: application/json');
                    $response = ['msg' => "", 'status' => '2'];
                    echo json_encode($response);
                    // redirect('/Checkout/');
                } else if (isset($_SESSION['actionFor']) and $_SESSION['actionFor'] == "booking_session") {
                    // $this->load->helper('url');
                    $this->session->set_userdata('student_login_data', $response->error_message->data);
                    header('Content-Type: application/json');
                    $response = ['msg' => "", 'status' => '3'];
                    echo json_encode($response);
                    // redirect('/Checkout/');
                } else if (isset($_SESSION['actionFor']) and $_SESSION['actionFor'] == "booking_events") {
                    /*do action*/
                } else {
                    unset($_SESSION['lastId_std']);
                    $this->session->set_userdata('student_login_data', $response->error_message->data);
                    header('Content-Type: application/json');
                    $msg = '<div class="alert alert-success alert-dismissible">
                    <strong>SUCCESS:</strong> ' . $response->error_message->message . '<a href="' . base_url('our_students/student_dashboard') . '" class="alert-link">Go to dashboard</a>.
                    </div>';
                    $response = ['msg' => $msg, 'status' => 'true'];
                    echo json_encode($response);
                }
            } elseif ($response->error_message->success == 0) {
                header('Content-Type: application/json');
                $msg = '<div class="alert alert-danger alert-dismissible">
                    <strong>WRONG:</strong>  ' . $response->error_message->message . '<a href="#" class="alert-link"></a>.
                </div>';
                $response = ['msg' => $msg, 'status' => 'false'];
                echo json_encode($response);
            } else {
                header('Content-Type: application/json');
                $msg = '<div class="alert alert-danger alert-dismissible">
                    <strong>WRONG:</strong>  ' . $response->error_message->message . '<a href="#" class="alert-link"> </a>.
                </div>';
                $response = ['msg' => $msg, 'status' => 'false'];
                echo json_encode($response);
            }
        } else {
            $response = ['msg' => $msg, 'status' => 'false'];
            echo json_encode($response);
        }
    }
    function update_profile()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        }
        $data['title'] = 'Profile';
        $data['title1'] = 'Your';
        $data['title2'] = ' Profile';
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id
        );
        /*---------COMMON API CALL-----*/   
        $data['countryCode'] = $GLOBALS['countryCode'];  
        $data['serviceData']=$GLOBALS['serviceData'];
        $data['newsData']=$GLOBALS['newsData'];  
        //get country code list
     
        $data['allcountry'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_URL), $headers));        
        $data['segment'] = $this->_getURI();
        // $data['shortBranches'] = $this->_common($headers);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fname', 'First name', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('dob', 'Date of birth', 'required|trim');
        $this->form_validation->set_rules('stu_country', 'Country', 'required|trim');
        $this->form_validation->set_rules('stu_state', 'State', 'required|trim');
        $this->form_validation->set_rules('stu_city', 'City', 'required|trim');
        $this->form_validation->set_rules('zip_code', 'Zip Code', 'required|trim');
        if ($this->form_validation->run()) {
            $params = array(
                'fname' => $this->input->post('fname'),
                'lname' => $this->input->post('lname'),
                'father_name' => $this->input->post('father_name'),
                'gender' => $this->input->post('gender'),
                'dob' => $this->input->post('dob'),
                'residential_address' => $this->input->post('residential_address'),
                'father_dob' => $this->input->post('father_dob'),
                'mother_name' => $this->input->post('mother_name'),
                'mother_dob' => $this->input->post('mother_dob'),
                'parents_anniversary' => $this->input->post('parents_anniversary'),
                'gaurdian_contact' => $this->input->post('gaurdian_contact'),
                'qualification_id' => $this->input->post('qualification_id'),
                'int_country_id' => $this->input->post('int_country_id'),
                'source_id' => $this->input->post('source_id'),
                'country_id' => $this->input->post('stu_country'),
                'state_id' => $this->input->post('stu_state'),
                'city_id' => $this->input->post('stu_city'),
                'zip_code' => $this->input->post('zip_code'),
                
            );
            $response = json_decode($this->_curPostData(base_url(UPDATE_STD_URL), $headers, $params));
            if ($response->error_message->success == 1) {                
                $this->session->set_userdata('student_login_data',$response->error_message->data);
                $this->session->userdata('student_login_data')->profileUpdate = 1;
                $msg = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> ' . $response->error_message->message . '<a href="#" class="alert-link"></a>.
                </div>';
                $this->session->set_flashdata('flsh_msg', $msg);
                redirect('our_students/student_dashboard');
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong>  ' . $response->error_message->message . '<a href="#" class="alert-link"> </a>.
                </div>';
                $this->session->set_flashdata('flsh_msg', $msg);
                redirect('our_students/update_profile');
            }
        } else {
            $data['stdInfo'] = json_decode($this->_curlGetData(base_url(GET_STD_INFO_URL), $headers));
            $data['allGenders'] = json_decode($this->_curlGetData(base_url(GET_ALL_GND_URL), $headers));
            $data['allCnt'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_URL), $headers));
            // Get all qualification list
            $data['allQua'] = json_decode($this->_curlGetData(base_url(GET_ALL_QUA_URL), $headers));
            // Get source list
            $headers2 = array(
                'API-KEY:' . WOSA_API_KEY,
                'COUNTRY-ID:' .$data['stdInfo']->error_message->data->country_id,
            );
            $data['allstate'] = json_decode($this->_curlGetData(base_url(GET_ALL_STATE_URL), $headers2));
            ; 
            if($this->input->post('stu_state'))
            {
            $st_id=$this->input->post('stu_state');
            }
            else {
            $st_id="";
            }
            if($data['stdInfo']->error_message->data->state_id !="")
            {
            $st_id=$data['stdInfo']->error_message->data->state_id;
            }
            $headers3 = array(
                'API-KEY:' . WOSA_API_KEY,
                'STATE-ID:' .$st_id,
            );
            $data['allcity'] = json_decode($this->_curlGetData(base_url(GET_ALL_CITY_URL), $headers3));     
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/update_profile');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function ajax_get_state()
    {
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'COUNTRY-ID:' .$this->input->post('id'),
        );
        $data['allstate'] = json_decode($this->_curlGetData(base_url(GET_ALL_STATE_URL), $headers));
        $this->load->view('aa-front-end/ajax_state_list',$data);
    }
    function ajax_get_city()
    {
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'STATE-ID:' .$this->input->post('id'),
        );
        $data['allcity'] = json_decode($this->_curlGetData(base_url(GET_ALL_CITY_URL), $headers));
        $this->load->view('aa-front-end/ajax_city_list',$data);
    }
    function change_password()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        }
        $data['title'] = 'Change Password';
        $data['title1'] = 'Change';
        $data['title2'] = ' Password';
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'ID:' . @$this->session->userdata('student_login_data')->id
        );       
        $data['segment'] = $this->_getURI();        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cp', 'Current Password', 'required');
        $this->form_validation->set_rules('np', 'New Password', 'required');
        $this->form_validation->set_rules('cnp', 'Confirm New Password', 'required');
        if ($this->form_validation->run()) {
            $params = array(
                'cp' => $this->input->post('cp'),
                'np' => $this->input->post('np'),
                'cnp' => $this->input->post('cnp'),
            );
            $response = json_decode($this->_curPostData(base_url(CHANGE_PWD_URL), $headers, $params));
            if ($response->error_message->success == 1) {
                header('Content-Type: application/json');
                $response = ['msg' => $response->error_message->message, 'status' => 'true'];
                echo json_encode($response);
                die();
            } else {
                header('Content-Type: application/json');
                $response = ['msg' => $response->error_message->message, 'status' => 'false'];
                echo json_encode($response);
                die();
            }
        } else {
            $data['stdInfo'] = json_decode($this->_curlGetData(base_url(GET_STD_INFO_URL), $headers));
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/change_password');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function announcements()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else {
            $data['title'] = 'Classroom Announcements';
            $data['title1'] = 'Classroom';
            $data['title2'] = ' Announcements';
            /*---------COMMON API CALL-----*/  
            $data['curPack']= $GLOBALS['curPack'];
            $data['allClassSchedule'] = $GLOBALS['allClassSchedule'];
            $data['countryCode'] = $GLOBALS['countryCode']; 
          
            $data['serviceData']=$GLOBALS['serviceData'];
            $data['newsData']=$GLOBALS['newsData'];
            /*---------ENDS-----*/
           // $data['announcements']=$GLOBALS['announcements'];
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],   
                'LIMIT:' .LOAD_MORE_LIMIT_10,
                'OFFSET:0',            
            ); 
            $data['announcements'] = json_decode($this->_curlGetData(base_url(GET_ANNOUNCEMENTS_URL), $headers));
            $headers_count = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],                           
            );
            $data['announcements_count'] = json_decode($this->_curlGetData(base_url(GET_ANNOUNCEMENTS_COUNT_URL), $headers_count)); 
            $data['segment'] = $this->_getURI3(); //for student profile side menu
            $data['segment2'] = $this->_getURI2(); //for getting announcement id         
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/announcements');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function ajax_loadmore_announcement()
    {
        $offset=$this->input->post('offset')+LOAD_MORE_LIMIT_10;
        $headers1 = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'LIMIT:' .LOAD_MORE_LIMIT_10,
            'OFFSET:'.$offset,
        );
        $data['announcements'] = json_decode($this->_curlGetData(base_url(GET_ANNOUNCEMENTS_URL), $headers1));
        $next_offset=$offset+LOAD_MORE_LIMIT_10;
        $headers_count = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'LIMIT:' .LOAD_MORE_LIMIT_10,
            'OFFSET:'.$next_offset,
        );
        $data['announcements_count'] = json_decode($this->_curlGetData(base_url(GET_ANNOUNCEMENTS_COUNT_URL), $headers_count)); 
        // $this->load->view('aa-front-end/shared_documents_ajax',$data);
        ob_start();
        $this->load->view('aa-front-end/announcements_ajax',$data);
        $abc["html"] = ob_get_clean();
        $abc["count"] =  $data['announcements_count'];
        echo json_encode($abc);
    }
    function ajax_refresh_announcement()
    {
       
        $headers1 = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'LIMIT:' .LOAD_MORE_LIMIT_10,
            'OFFSET:0',
        );
        $data['announcements'] = json_decode($this->_curlGetData(base_url(GET_ANNOUNCEMENTS_URL), $headers1));      
        $headers_count = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            
        );
        $data['announcements_count'] = json_decode($this->_curlGetData(base_url(GET_ANNOUNCEMENTS_COUNT_URL), $headers_count)); 
        $data["open"]=1;
        // $this->load->view('aa-front-end/shared_documents_ajax',$data);
        ob_start();        
        $this->load->view('aa-front-end/announcements_ajax',$data);
        $abc["html"] = ob_get_clean();
        $abc["count"] =  $data['announcements_count'];
        echo json_encode($abc);
    }
    function shared_documents()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else {
            $data['title'] = 'Classroom Material';
            $data['title1'] = 'Classroom';
            $data['title2'] = ' Material';
            /*---------COMMON API CALL -----*/  
            $data['curPack']= $GLOBALS['curPack'];
            $data['allClassSchedule'] = $GLOBALS['allClassSchedule'];
            $data['countryCode'] = $GLOBALS['countryCode']; 
            $data['serviceData']=$GLOBALS['serviceData'];
            $data['newsData']=$GLOBALS['newsData'];
            /*---------ENDS-----*/   
            $headers1 = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],
                'LIMIT:' .LOAD_MORE_LIMIT,
                'OFFSET:0',
            );
        
            $data['allSharedDocs'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_URL), $headers1));
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . @$this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],                
            );            
            $data['allSharedDocsCount'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_COUNT_URL), $headers));  
             
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],
                'LIMIT:' .LOAD_MORE_LIMIT,
                'OFFSET:0',
            );
            
            $data['segment'] = $this->_getURI3(); //for student profile side menu  
            $data['SHARED_DOCS_CONTENT_TYPE_URL'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_CONTENT_TYPE_URL), $headers));
            //$data['callfromview'] = $this;
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/shared_documents');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function shared_documents_view($sdid)
    {
       //$sdid=$this->auto_mydecryption($sdid);
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else {
            $data['title'] = 'Shared Documents';
            $data['title1'] = 'Shared';
            $data['title2'] = ' Documents';
            /*---------COMMON API CALL -----*/  
            $data['curPack']= $GLOBALS['curPack'];
            $data['allClassSchedule'] = $GLOBALS['allClassSchedule'];
            $data['countryCode'] = $GLOBALS['countryCode']; 
            $data['serviceData']=$GLOBALS['serviceData'];
            $data['newsData']=$GLOBALS['newsData'];
            /*---------ENDS-----*/   
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            );           
            
            $data['segment'] = $this->_getURI3(); //for student profile side menu       
            $data['allSharedDocs'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_URL), $headers));           
            $data['SHARED_DOCS_CONTENT_TYPE_URL'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_CONTENT_TYPE_URL), $headers));
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'CLASSROOM-DOCUMENT-ID:' . $sdid,
            );
           
            $data['allSharedDocsDesc'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_DESC_URL), $headers));
            //$data['callfromview'] = $this;
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/shared_documents_view');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function recorded_lectures()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else {
            $data['title'] = 'Recorded Lectures';
            $data['title1'] = 'Recorded';
            $data['title2'] = ' Lectures';
            /*---------COMMON API CALL -----*/  
            $data['curPack']= $GLOBALS['curPack'];
            $data['allClassSchedule'] = $GLOBALS['allClassSchedule'];
            $data['countryCode'] = $GLOBALS['countryCode']; 
            $data['serviceData']=$GLOBALS['serviceData'];
            $data['newsData']=$GLOBALS['newsData'];
            /*---------ENDS-----*/              
           
            $headers_a = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-PACK-ID:' . $_SESSION['stucurrent_package_id'],
            );     
            $data['STU_PACK_START_DATE'] = json_decode($this->_curlGetData(base_url(STU_PACK_START_DATE), $headers_a));           
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],
                'STUDENT-PACK-START-DATE:' . $data['STU_PACK_START_DATE']->error_message->data->subscribed_on_str,
                'STUDENT-PACK-END-DATE:' . strtotime($data['STU_PACK_START_DATE']->error_message->data->expired_on),
                'LIMIT:' .LOAD_MORE_LIMIT,
                'OFFSET:0',
            );          
            $data['segment'] = $this->_getURI3(); //for student profile 
            $data['REC_LEC_URL'] = json_decode($this->_curlGetData(base_url(GET_REC_LEC_URL), $headers)); 
            $data['GET_REC_LEC_CONTENT_TYPE_URL'] = json_decode($this->_curlGetData(base_url(GET_REC_LEC_CONTENT_TYPE_URL), $headers));
           
            $headers_1 = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],
                'STUDENT-PACK-START-DATE:' . $data['STU_PACK_START_DATE']->error_message->data->subscribed_on_str,
                'STUDENT-PACK-END-DATE:' . strtotime($data['STU_PACK_START_DATE']->error_message->data->expired_on),              
            );
            $data['REC_LEC_URL_COUNT'] = json_decode($this->_curlGetData(base_url(GET_REC_LEC_URL_COUNT), $headers_1));           
            // all academic service title:----need to create api           
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/recorded_lectures');
            $this->load->view('aa-front-end/includes/footer');


            

        }
    }
    function ajax_loadmore_recordedlectures()
    {
        $type=$this->input->post('type', true);
        $rl_content_type   = $this->input->post('rl_content_type', true);
        $rl_search   = $this->input->post('rl_search', true);
        if($type=="loadmore")
        {
            $offset=$this->input->post('offset')+LOAD_MORE_LIMIT;
        }
        else 
        {
            $offset=0;
        }        
        $headers_a = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-PACK-ID:' . $_SESSION['stucurrent_package_id'],
        );            
        $data['STU_PACK_START_DATE'] = json_decode($this->_curlGetData(base_url(STU_PACK_START_DATE), $headers_a));           
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'STUDENT-PACK-START-DATE:' . $data['STU_PACK_START_DATE']->error_message->data->subscribed_on_str,
            'STUDENT-PACK-END-DATE:' . strtotime($data['STU_PACK_START_DATE']->error_message->data->expired_on),
            'LIMIT:' .LOAD_MORE_LIMIT,
            'OFFSET:'.$offset,
            'CONTENT-TYPE-ID:' . $rl_content_type,
            'SEARCH-TEXT:' . $rl_search,
        );      
        $data['REC_LEC_URL'] = json_decode($this->_curlGetData(base_url(GET_REC_LEC_URL), $headers));  
        $next_offset=$offset+LOAD_MORE_LIMIT;
        $headers_1 = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'STUDENT-PACK-START-DATE:' . $data['STU_PACK_START_DATE']->error_message->data->subscribed_on_str,
            'STUDENT-PACK-END-DATE:' . strtotime($data['STU_PACK_START_DATE']->error_message->data->expired_on),  
            'LIMIT:' .LOAD_MORE_LIMIT,
            'OFFSET:'.$next_offset,
            'CONTENT-TYPE-ID:' . $rl_content_type,
            'SEARCH-TEXT:' . $rl_search,
        );
        $data['REC_LEC_URL_COUNT'] = json_decode($this->_curlGetData(base_url(GET_REC_LEC_URL_COUNT), $headers_1));         
       

        ob_start();
        $this->load->view('aa-front-end/recorded_lectures_ajax', $data);
        $abc["html"] = ob_get_clean();
        $abc["count"] =  $data['REC_LEC_URL_COUNT'];
        echo json_encode($abc);
    }
    
    function live_class_shedules()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else {
            $data['title'] = 'Live Class Schedules';
            $data['title1'] = 'Live Class';
            $data['title2'] = ' Schedules';
            /*---------COMMON API CALL-----*/  
            $data['curPack']= $GLOBALS['curPack'];
            $data['allClassSchedule'] = $GLOBALS['allClassSchedule'];
            $data['countryCode'] = $GLOBALS['countryCode']; 
            $data['announcements']=$GLOBALS['announcements'];
            /*---------ENDS-----*/   
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'ID:' . $this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            );                     
            $data['segment'] = $this->_getURI3(); //for student profile side menu
           
            $data['allOrder'] = json_decode($this->_curlGetData(base_url(GET_ALL_ORDER_URL), $headers));            
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/live_class_shedules');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    
    function order_history()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else {
            $data['title'] = 'Order History';
            $data['title1'] = 'Order';
            $data['title2'] = ' History';
            /*---------COMMON API CALL-----*/  
            $data['curPack']= $GLOBALS['curPack'];
            $data['countryCode'] = $GLOBALS['countryCode']; 
            $data['serviceData']=$GLOBALS['serviceData'];
            $data['newsData']=$GLOBALS['newsData'];
            $data['announcements']=$GLOBALS['announcements'];
            /*---------ENDS-----*/              
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . @$_SESSION['classroom_id'],
            );
            $data['segment'] = $this->_getURI3(); //for student profile side menu                  
            $data['allOrder'] = json_decode($this->_curlGetData(base_url(GET_ALL_ORDER_URL), $headers));          
             $data['allOrder'] =$data['allOrder']->error_message->data;         
            function date_compare($a, $b)
            {
                //return new DateTime($b->requested_on ) <=> new \DateTime( $a->requested_on );// sort in asc order
                return new DateTime($b->requested_on ) <=> new \DateTime( $a->requested_on );// sort in desc order
            }    
            usort($data['allOrder'] , 'date_compare');
            $data['allOrderDate'] = json_decode($this->_curlGetData(base_url(GET_ALL_ORDER_DATE_URL), $headers));
            $data['allOrderDate'] =$data['allOrderDate']->error_message->data;
            function super_unique($array)
            {
              $result = array_map("unserialize", array_unique(array_map("serialize", $array)));
              foreach ($result as $key => $value)
              {
                if ( is_array($value) )
                {
                  $result[$key] = super_unique($value);
                }
              }
              return $result;
            }
            $data['allOrderDate']=super_unique($data['allOrderDate']); // remove duplicate date
            usort( $data['allOrderDate'] , 'date_compare');// reset date to desc order         
          
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/order_history');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function ajax_order_history()
    {
      $orderdate   = $this->input->post('orderdate', true);
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . @$_SESSION['classroom_id'],
            'ORDER-DATE:' . $orderdate,
        );
        $data['allOrder'] = json_decode($this->_curlGetData(base_url(GET_ALL_ORDER_URL), $headers)); 
        $data['allOrder'] =$data['allOrder']->error_message->data;
        function date_compare($a, $b)
        {
            return new DateTime($b->requested_on ) <=> new \DateTime( $a->requested_on );// sort in desc order
        }    
        usort($data['allOrder'] , 'date_compare');   
      //  print_r($data['allOrder']);
        $this->load->view('aa-front-end/order_history_ajax', $data);  
    }
    function download_order_reciept($student_package_id)
    {
        $student_package_id = base64_decode($student_package_id);
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else {
            $data['title'] = 'Order Reciept';
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
                'STUDENT-PACKAGE-ID:' . $student_package_id,
            );
            $pdfFilePath = "OrderReciept-" . $student_package_id . ".pdf";
            $data['Reciept_data']= json_decode($this->_curlGetData(base_url(GET_RECIEPT_URL), $headers));
            $html = $this->load->view('aa-front-end/pdf/reciept_pdf', $data, true);
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf = new \Mpdf\Mpdf([
                'default_font' => 'Open Sans'
            ]);
            $pdf->WriteHTML($html, 2);
            $pdf->Output($pdfFilePath, "D");
            exit;
        }
    }
    
  
    function class_attandance()
    {
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
        );
        $params = array(
            'student_id' => $this->session->userdata('student_login_data')->id,
            'classroom_id' => $_SESSION['classroom_id'],
            'sch_id' => $this->input->post('sch_id', true),
            'is_offline' => $this->input->post('is_offline', true),
        );
      
        $response = json_decode($this->_curPostData(base_url(SEND_CLASS_ATTENDANCE), $headers, $params));
        print_r($response);
    }
  
    function attendance()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else {
            $data['title'] = 'Classroom Announcements';
            $data['title1'] = 'Classroom';
            $data['title2'] = ' Announcements';
            /*---------COMMON API CALL-----*/  
            $data['curPack']= $GLOBALS['curPack'];
            $data['countryCode'] = $GLOBALS['countryCode'];  
            /*---------ENDS-----*/   
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            );             
            //get country code list
                   
            $data['segment'] = $this->_getURI3(); //for student profile side menu
            $data['segment2'] = $this->_getURI2(); //for getting announcement id          
            
            $data['announcements'] = json_decode($this->_curlGetData(base_url(GET_ALL_ANNOUNCEMENTS_URL), $headers));     
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/attendance'); 
        }
    }
    function live_class_shedules_all()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else {
            $data['title'] = 'Live Class Schedules';
            $data['title1'] = 'Live Class';
            $data['title2'] = ' Schedules';
            /*---------COMMON API CALL -----*/  
            $data['curPack']= $GLOBALS['curPack'];
            $data['allClassSchedule'] = $GLOBALS['allClassSchedule'];
            $data['serviceData']=$GLOBALS['serviceData'];
            $data['newsData']=$GLOBALS['newsData'];
            /*---------ENDS-----*/   
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'ID:' . $this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . $_SESSION['classroom_id'],
                'LIMIT:' .LOAD_MORE_LIMIT,
                'OFFSET:0',
            );              
            $data['segment'] = $this->_getURI3(); //for student profile side menu
            $data['ClassSchedulea'] = json_decode($this->_curlGetData(base_url(GET_CLASS_SCH_URL_LONG), $headers));          
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/live_class_shedules_all');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function ajax_loadmore()
    {
        $type=$this->input->post('type', true);       
        if($type=="loadmore")
        {
            $offset=$this->input->post('offset')+LOAD_MORE_LIMIT;
        }
        else 
        {
            $offset=0;
        }      
        $class_date   = $this->input->post('class_date', true);
        $classname   = $this->input->post('classname', true);
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'ID:' . $this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'LIMIT:' .LOAD_MORE_LIMIT,
            'OFFSET:'.$offset,
            'CLASS-DATED:'.$class_date, 
            'CLASS-NAME:'.$classname , 
            'ACTION-TYPE:'.$type , 

        );        
        $data['classSchedule'] = json_decode($this->_curlGetData(base_url(GET_CLASS_SCH_URL_LONG), $headers));
       
        $next_offset=$offset+LOAD_MORE_LIMIT;
        $headersp = array(
            'API-KEY:' . WOSA_API_KEY,
            'ID:' . $this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'LIMIT:' .LOAD_MORE_LIMIT,
            'OFFSET:'.$next_offset,
            'CLASS-DATED:'.$class_date, 
            'CLASS-NAME:'.$classname , 
            'ACTION-TYPE:'.$type ,
        );
        $data['allClassSchedule'] = json_decode($this->_curlGetData(base_url(GET_CLASS_SCH_URL_LONG_COUNT), $headersp));
        ob_start();
        $this->load->view('aa-front-end/includes/ajax_student_live_classes_all',$data);
        $abc["html"] = ob_get_clean();
        $abc["count"] =  $data['allClassSchedule'];
        echo json_encode($abc);
    }
    function ajax_searchClass()
    {
        $_SESSION['timelimit']=5000;
        $class_date   = $this->input->post('class_date', true);
        $classname   = $this->input->post('classname', true);
        $headers = array(
        'API-KEY:'.WOSA_API_KEY,  
        'CLASSROOM-ID:'.$_SESSION['classroom_id'],     
        'DATE:'.$class_date, 
         'CLASSNAME:'.$classname ,               
        );
        $data['classSchedule'] = json_decode($this->_curlGetData(base_url(GET_CLASS_SCH_URL_LONG_FILTER), $headers));
        $this->load->view('aa-front-end/includes/ajax_student_live_classes',$data);       
    }
   
    function ajax_announcements()
    {
        $headers = array(
                'API-KEY:'.WOSA_API_KEY,
                'ID:'.$this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:'.$_SESSION['classroom_id'],
            );
        //GET_CLASS_SCH_URL_LONG
         $data['announcements'] = json_decode($this->_curlGetData(base_url(GET_ANNOUNCEMENTS_URL), $headers));
        $this->load->view('aa-front-end/includes/student_announcements_ajax',$data);
    }
    function ajax_shareddocuement()
    {
        $headers = array(
                'API-KEY:'.WOSA_API_KEY,
                'ID:'.$this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:'.$_SESSION['classroom_id'],
                'LIMIT:' .LOAD_MORE_LIMIT,
                'OFFSET:0',
            );
        //GET_CLASS_SCH_URL_LONG
        $data['allSharedDocs'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_URL), $headers));
        $next_offset=0+1;
        $headers1 = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'LIMIT:' .LOAD_MORE_LIMIT,
            'OFFSET:'.$next_offset,
        );
        $data['allSharedDocsCount'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_COUNT_URL), $headers1));       
        //$data['callfromview'] = $this;
        ob_start();
        $this->load->view('aa-front-end/shared_documents_ajax',$data);
        $abc["html"] = ob_get_clean();
        $abc["count"] =  $data['allSharedDocsCount'];
        echo json_encode($abc);
    }
    function ajax_loadmore_classroomDoc()
    {
        $offset=$this->input->post('offset')+LOAD_MORE_LIMIT;
        $headers1 = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'LIMIT:' .LOAD_MORE_LIMIT,
            'OFFSET:'.$offset,
        );
        $data['allSharedDocs'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_URL), $headers1));
        $next_offset=$offset+LOAD_MORE_LIMIT;
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'LIMIT:' .LOAD_MORE_LIMIT,
            'OFFSET:'.$next_offset,
        );
        $data['allSharedDocsCount'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_COUNT_URL), $headers));
        // $this->load->view('aa-front-end/shared_documents_ajax',$data);
        //$data['callfromview'] = $this;
        ob_start();
        $this->load->view('aa-front-end/shared_documents_ajax',$data);
        $abc["html"] = ob_get_clean();
        $abc["count"] =  $data['allSharedDocsCount'];
        echo json_encode($abc);
    }
    function searchSharedDoc()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        }
        
        $sd_content_type   = $this->input->post('sd_content_type', true);
        $sd_search   = $this->input->post('sd_search', true);
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'ID:' . $this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'CONTENT-TYPE-ID:' . $sd_content_type,
            'SEARCH-TEXT:' . $sd_search,
            'LIMIT:' .LOAD_MORE_LIMIT,
            'OFFSET:0',
        );       
        $data['allSharedDocs'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_URL_FILTER), $headers));
        $next_offset=0+LOAD_MORE_LIMIT;
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'CONTENT-TYPE-ID:' . $sd_content_type,
            'SEARCH-TEXT:' . $sd_search,
            'LIMIT:' .LOAD_MORE_LIMIT,
            'OFFSET:'.$next_offset,
        );
        $data['allSharedDocsCount'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_URL_FILTER_COUNT), $headers)); 
        //$data['callfromview'] = $this;       
        ob_start();
        $this->load->view('aa-front-end/shared_documents_ajax',$data);
        $abc["html"] = ob_get_clean();
        $abc["count"] =  $data['allSharedDocsCount'];
        echo json_encode($abc);


    }
    function ajax_searchSharedDoc()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        }
        $offset=$this->input->post('offset');
        $sd_content_type   = $this->input->post('sd_content_type', true);
        $sd_search   = $this->input->post('sd_search', true);
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'ID:' . $this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'CONTENT-TYPE-ID:' . $sd_content_type,
            'SEARCH-TEXT:' . $sd_search,
            'LIMIT:' .LOAD_MORE_LIMIT,
            'OFFSET:'.$offset,
        );
        $data['allSharedDocs'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_URL_FILTER), $headers));
        $next_offset=$offset+LOAD_MORE_LIMIT;
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
            'CLASSROOM-ID:' . $_SESSION['classroom_id'],
            'CONTENT-TYPE-ID:' . $sd_content_type,
            'SEARCH-TEXT:' . $sd_search,
            'LIMIT:' .LOAD_MORE_LIMIT,
            'OFFSET:'.$next_offset,
        );
        $data['allSharedDocsCount'] = json_decode($this->_curlGetData(base_url(GET_SHARED_DOCS_URL_FILTER_COUNT), $headers));  
        //$data['callfromview'] = $this;      
        ob_start();
        $this->load->view('aa-front-end/shared_documents_ajax',$data);
        $abc["html"] = ob_get_clean();
        $abc["count"] =  $data['allSharedDocsCount'];
        echo json_encode($abc);


    }
    function ajax_changeprofilepic()
    {
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,           
        );
      
        if(empty($_FILES['update_pp']['name'])){
            $this->form_validation->set_rules('image', 'Image', 'required');
        }
    



        if (!empty($_FILES['update_pp']['name'])) {
            if(!file_exists(TEMP_PATH)){
                mkdir(TEMP_PATH, 0777, TRUE);
            }
            $config['upload_path']   = TEMP_PATH;
            $config['allowed_types'] = EMP_ALLOWED_TYPES;
            $config['encrypt_name']  = false;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('update_pp')) {
                                
                $Imgdata = array('upload_data' => $this->upload->data());
                $image = $Imgdata['upload_data']['file_name'];
                $path = base_url(TEMP_PATH . $image);
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data_img = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data_img);           
                
            }            

            $params = array(
                'profile_image' => $base64,
                'type' => $type,                
            );
        $response = json_decode($this->_curPostData(base_url(SUBMIT_PROFILE_PIC_URL), $headers, $params));
           
        echo $response->error_message->success;
        if ($response->error_message->success == 1) {
            $this->session->set_userdata('student_login_data',$response->error_message->data);
          //  print_r( $this->session->student_login_data);

            }
      

            // if ($response->error_message->success == 1) {
            //     header('Content-Type: application/json');
            //     $response = ['msg' => $response->error_message->message, 'status' => 'true'];
            //     echo json_encode($response);
            // } else {
            //     header('Content-Type: application/json');
            //     $response = ['msg' => $response->error_message->message, 'status' => 'false'];
            //     echo json_encode($response);
            // }
        } 
        
    }



     /* function download_reality_test_acknowledge()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else {
            $data['title'] = 'Reality Test Acknowledgement';           
            $test_module_name = "ONLINE-CD_IELTS";
            if ($test_module_name == 'CD_IELTS') {
                $pdfFilePath = "CD_IELTS Acknowledgement -" . $student_package_id . ".pdf";
                //$data['Reciept_data'] = json_decode($this->_curlGetData(base_url(GET_RECIEPT_URL), $headers));
                $html = $this->load->view('aa-front-end/pdf/acknowledge/cd_ielts_test_acknowledgement', $data, true);
            } elseif ($test_module_name == 'IELTS') {
                $pdfFilePath = "IELTS Acknowledgement -" . $student_package_id . ".pdf";
                //$data['Reciept_data'] = json_decode($this->_curlGetData(base_url(GET_RECIEPT_URL), $headers));
                $html = $this->load->view('aa-front-end/pdf/acknowledge/ielts_test_acknowledgement', $data, true);
            } elseif ($test_module_name == 'PTE') {
                $pdfFilePath = "PTE Acknowledgement -" . $student_package_id . ".pdf";
                //$data['Reciept_data'] = json_decode($this->_curlGetData(base_url(GET_RECIEPT_URL), $headers));
                $html = $this->load->view('aa-front-end/pdf/acknowledge/pte_test_acknowledgement', $data, true);
            } elseif ($test_module_name == 'ONLINE-PTE') {
                $pdfFilePath = "ONLINE-PTEAcknowledgement -" . $student_package_id . ".pdf";
                //$data['Reciept_data'] = json_decode($this->_curlGetData(base_url(GET_RECIEPT_URL), $headers));
                $html = $this->load->view('aa-front-end/pdf/acknowledge/online_pte_test_acknowledgement', $data, true);
            } elseif ($test_module_name == 'ONLINE-CD_IELTS') {
                $pdfFilePath = "ONLINE-CD_IELTS Acknowledgement -" . $student_package_id . ".pdf";
                //$data['Reciept_data'] = json_decode($this->_curlGetData(base_url(GET_RECIEPT_URL), $headers));
                $html = $this->load->view('aa-front-end/pdf/acknowledge/online_cdielts_test_acknowledgement', $data, true);
            } else {
                $pdfFilePath = "RT Acknowledgement -" . $student_package_id . ".pdf";
                //$data['Reciept_data'] = json_decode($this->_curlGetData(base_url(GET_RECIEPT_URL), $headers));
                $html = $this->load->view('aa-front-end/pdf/acknowledge/ielts_test_acknowledgement', $data, true);
            }           
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf = new \Mpdf\Mpdf([
                'default_font' => 'Open Sans'
            ]);
            $pdf->WriteHTML($html, 2);
            $pdf->Output($pdfFilePath, "D");
            exit;
        }
    }*/

    // function student_complains()
    // {
    //     $data['countryCode'] = $GLOBALS['countryCode']; 
    //     if (!$this->session->userdata('student_login_data')) {
    //         redirect('/my_login');
    //         exit;
    //     } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
    //         redirect('our_students/update_profile');
    //         exit;
    //     } else {
    //         $data['title'] = 'Complaints History';
    //         $data['title1'] = 'Complaints';
    //         $data['title2'] = ' History';
    //         /*---------COMMON API CALL-----*/  
    //         $data['curPack']= $GLOBALS['curPack'];
    //         $data['announcements']=$GLOBALS['announcements'];
    //         /*---------ENDS-----*/   
    //         $headers = array(
    //             'API-KEY:' . WOSA_API_KEY,
    //             'mobile:' . $this->session->userdata('student_login_data')->mobile,
    //             'email:' . $this->session->userdata('student_login_data')->email,
    //         );
           
    //         $data['segment'] = $this->_getURI3(); //for student profile side menu             
    //         $data['allOrder'] = json_decode($this->_curlGetData(base_url(GET_ALL_ORDER_URL), $headers));          
    //         $this->load->view('aa-front-end/includes/header', $data);
    //         $this->load->view('aa-front-end/student_complaint');
    //         $this->load->view('aa-front-end/includes/footer');
    //     }
    // }
    // get student request list
    // function student_request()
    // {
    //     if (!$this->session->userdata('student_login_data')) {
    //         redirect('/my_login');
    //         exit;
    //     } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
    //         redirect('our_students/update_profile');
    //         exit;
    //     } else {
    //         $data['title'] = 'Request History';
    //         $data['title1'] = 'Request';
    //         $data['title2'] = ' History';
    //         /*---------COMMON API CALL-----*/  
    //         $data['curPack']= $GLOBALS['curPack'];
    //         $data['countryCode'] = $GLOBALS['countryCode']; 
    //         $data['announcements']=$GLOBALS['announcements'];
    //         /*---------ENDS-----*/   
    //         $headers = array(
    //             'API-KEY:' . WOSA_API_KEY,
    //             'mobile:' . $this->session->userdata('student_login_data')->mobile,
    //             'email:' . $this->session->userdata('student_login_data')->email,
    //         );          
    //         $data['segment'] = $this->_getURI3(); //for student profile side menu     
            
    //         $data['student_complaints'] = json_decode($this->_curlGetData(base_url(GET_STUDENT_COMPLAINTS), $headers));
    //         $headers_req = array(
    //             'API-KEY:' . WOSA_API_KEY,
    //             'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
    //         );
    //         $data['studentRequest'] = json_decode($this->_curlGetData(base_url(GET_STUDENT_REQUESTS), $headers_req));
    //         $data['allOrder'] = json_decode($this->_curlGetData(base_url(GET_ALL_ORDER_URL), $headers));
    //         $headers_plain = array(
    //             'API-KEY:' . WOSA_API_KEY,
    //         );
    //         $data['requestSubject'] = json_decode($this->_curlGetData(base_url(GET_REQUEST_SUBJECT), $headers_plain));          
    //         $this->load->view('aa-front-end/includes/header', $data);
    //         $this->load->view('aa-front-end/student_request');
    //         $this->load->view('aa-front-end/includes/footer');
    //     }
    // }
    // submit student request form
    // function sendStudentRequest()
    // {
    //     $headers = array(
    //         'API-KEY:' . WOSA_API_KEY,
    //     );
    //     $att_file = $this->input->post('req_attachment_file', true);
    //     if (!empty($_FILES['req_attachment_file']['name'])) {
    //         $config['upload_path']   = TEMP_PATH;
    //         $config['allowed_types'] = STUDENT_POST_ALLOWED_TYPES;
    //         $config['encrypt_name']  = TRUE;
    //         $this->load->library('upload', $config);
    //         if ($this->upload->do_upload('req_attachment_file')) {
    //             $Imgdata = array('upload_data' => $this->upload->data());
    //             $image = $Imgdata['upload_data']['file_name'];
    //             $path = base_url(TEMP_PATH . $image);
    //             $file = TEMP_PATH . $image;
    //             $post_pic_url = $file;
    //             $type = pathinfo($path, PATHINFO_EXTENSION);
    //             $data_img = file_get_contents($path);
    //             $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data_img);
    //             $params = array(
    //                 'request_subject' => $this->input->post('request_subject', true),
    //                 'request_text' => $this->input->post('request_text', true),
    //                 'student_id' => $this->session->userdata('student_login_data')->id,
    //                 'attachment_file' => $base64,
    //                 'type' => $type
    //             );
    //         } else {
    //             $params = array(
    //                 'request_subject' => $this->input->post('request_subject', true),
    //                 'request_text' => $this->input->post('request_text', true),
    //                 'attachment_file' => NULL,
    //                 'student_id' => $this->session->userdata('student_login_data')->id,
    //             );
    //         }
    //     } else {
    //         $params = array(
    //             'request_subject' => $this->input->post('request_subject', true),
    //             'request_text' => $this->input->post('request_text', true),
    //             'attachment_file' => NULL,
    //             'student_id' => $this->session->userdata('student_login_data')->id,
    //         );
    //     }
    //     $response = json_decode($this->_curPostData(base_url(SEND_REQUEST_URL), $headers, $params));
    //     if ($response->error_message->success == 1) {
    //         header('Content-Type: application/json');
    //         $response = ['msg' => $response->error_message->message, 'status' => 'true'];
    //         echo json_encode($response);
    //     } else {
    //         header('Content-Type: application/json');
    //         $response = ['msg' => $response->error_message->message, 'status' => 'false'];
    //         echo json_encode($response);
    //     }
    // }
    
    // function reality_test_booking()
    // {
    //     if (!$this->session->userdata('student_login_data')) {
    //         redirect('/my_login');
    //         exit;
    //     } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
    //         redirect('our_students/update_profile');
    //         exit;
    //     } else {
    //         $data['title'] = 'Reality Test Booking';
    //         $data['title1'] = 'Reality Test';
    //         $data['title2'] = ' Booking';
    //         /*---------COMMON API CALL-----*/  
    //         $data['curPack']= $GLOBALS['curPack'];
    //         $data['countryCode'] = $GLOBALS['countryCode']; 
    //         $data['announcements']=$GLOBALS['announcements'];
    //         /*---------ENDS-----*/   
    //         $headers = array(
    //             'API-KEY:' . WOSA_API_KEY,
    //             'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
    //         );               
    //         $data['segment'] = $this->_getURI3(); //for student profile side menu            
    //         $data['RT_booking'] = json_decode($this->_curlGetData(base_url(REALITY_TEST_BOOKING), $headers));
                   
    //         $this->load->view('aa-front-end/includes/header', $data);
    //         $this->load->view('aa-front-end/reality_test_booking');
    //         $this->load->view('aa-front-end/includes/footer');
    //     }
    // }
    // function exam_booking()
    // {
    //     if (!$this->session->userdata('student_login_data')) {
    //         redirect('/my_login');
    //         exit;
    //     } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
    //         redirect('our_students/update_profile');
    //         exit;
    //     } else {
    //         $data['title'] = 'Exam Booking';
    //         $data['title1'] = 'Exam';
    //         $data['title2'] = ' Booking';
    //         /*---------COMMON API CALL-----*/  
    //         $data['curPack']= $GLOBALS['curPack'];
    //         $data['countryCode'] = $GLOBALS['countryCode']; 
    //         $data['announcements']=$GLOBALS['announcements'];
    //         /*---------ENDS-----*/   
    //         $headers = array(
    //             'API-KEY:' . WOSA_API_KEY,
    //             'ID:' . $this->session->userdata('student_login_data')->id,
    //             'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
    //         );          
    //         $data['segment'] = $this->_getURI3(); //for student profile side menu    
    //         $data['Exam_booking'] = json_decode($this->_curlGetData(base_url(EXAM_BOOKING), $headers));
                     
    //         $this->load->view('aa-front-end/includes/header', $data);
    //         $this->load->view('aa-front-end/exam_booking');
    //         $this->load->view('aa-front-end/includes/footer');
    //     }
    // }
    // function session_booking()
    // {
    //     if (!$this->session->userdata('student_login_data')) {
    //         redirect('/my_login');
    //         exit;
    //     } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
    //         redirect('our_students/update_profile');
    //         exit;
    //     } else {
    //         $data['title'] = 'Session Booking';
    //         $data['title1'] = 'Session ';
    //         $data['title2'] = ' Booking';
    //         /*---------COMMON API CALL-----*/  
    //         $data['curPack']= $GLOBALS['curPack'];
    //         $data['countryCode'] = $GLOBALS['countryCode']; 
    //         $data['announcements']=$GLOBALS['announcements'];
    //         /*---------ENDS-----*/   
    //         $headers = array(
    //             'API-KEY:' . WOSA_API_KEY,
    //             'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
    //         );          
    //         $data['segment'] = $this->_getURI3(); //for student profile side menu     
    //         $data['session_booking'] = json_decode($this->_curlGetData(base_url(GET_STUDENT_SESSION_URL), $headers));
    //         $this->load->view('aa-front-end/includes/header', $data);
    //         $this->load->view('aa-front-end/session_booking');
    //         $this->load->view('aa-front-end/includes/footer');
    //     }
    // }

    // function reality_test_reports()
    // {
    //     if (!$this->session->userdata('student_login_data')) {
    //         redirect('/my_login');
    //         exit;
    //     } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
    //         redirect('our_students/update_profile');
    //         exit;
    //     } else {
    //         $data['title'] = 'Reality Test Reports';
    //         $data['title1'] = 'Reality Test';
    //         $data['title2'] = ' Reports';
    //         /*---------COMMON API CALL-----*/  
    //         $data['curPack']= $GLOBALS['curPack'];
    //         $data['countryCode'] = $GLOBALS['countryCode']; 
    //         $data['announcements']=$GLOBALS['announcements'];
    //         /*---------ENDS-----*/   
    //         $headers = array(
    //             'API-KEY:' . WOSA_API_KEY,
    //             'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
    //             'CLASSROOM-ID:' . @$_SESSION['classroom_id'],
    //         );
           
          
           
    //         $data['segment'] = $this->_getURI3(); //for student profile side menu         
    //         $data['RT_reports'] = json_decode($this->_curlGetData(base_url(GET_RT_REPORTS_URL), $headers));
    //         $this->load->view('aa-front-end/includes/header', $data);
    //         $this->load->view('aa-front-end/reality_test_reports');
    //         $this->load->view('aa-front-end/includes/footer');
    //     }
    // }
    // function reality_test_reports_download($report_id, $test_module_name)
    // {
    //     if (!$this->session->userdata('student_login_data')) {
    //         redirect('/my_login');
    //         exit;
    //     } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
    //         redirect('our_students/update_profile');
    //         exit;
    //     } else {
    //         $data['title'] = 'Reality Test Report';
    //         $html = "";
    //         $headers = array(
    //             'API-KEY:' . WOSA_API_KEY,
    //             'ID:' . $this->session->userdata('student_login_data')->id,
    //             'REPORT-ID:' . $report_id,
    //             'TEST:' . $test_module_name,
    //             'CLASSROOM-ID:' . @$_SESSION['classroom_id'],
    //         );
    //         $pdfFilePath = "RealityTestReport-" . $report_id . $test_module_name . ".pdf";
    //         $data['RT_report_data'] = json_decode($this->_curlGetData(base_url(GET_RT_REPORT_DATA_URL), $headers));
    //         if ($test_module_name == 'IELTS' or $test_module_name == 'CD_IELTS') {
    //             $html = $this->load->view('aa-front-end/pdf/reality_test_report_pdf_ielts', $data, true);
    //         } elseif ($test_module_name == 'PTE') {
    //             $html = $this->load->view('aa-front-end/pdf/reality_test_report_pdf_pte', $data, true);
    //         } else {
    //         }
    //         $this->load->library('m_pdf');
    //         $pdf = $this->m_pdf->load();
    //         $pdf = new \Mpdf\Mpdf([
    //             'default_font' => 'Open Sans'
    //         ]);
    //         $pdf->WriteHTML($html, 2);
    //         $pdf->Output();
    //         exit;
    //     }
    // }
    function mock_test_reports()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else {
            $data['title'] = 'Mock Test Reports';
            $data['title1'] = 'Mock Test';
            $data['title2'] = ' Reports';
            /*---------COMMON API CALL-----*/  
            $data['curPack']= $GLOBALS['curPack'];
            $data['countryCode'] = $GLOBALS['countryCode']; 
            $data['announcements']=$GLOBALS['announcements'];           
            $data['serviceData']=$GLOBALS['serviceData'];
            $data['newsData']=$GLOBALS['newsData'];
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
                'CLASSROOM-ID:' . @$_SESSION['classroom_id'],
            );
            /*---------COMMON API CALL-----*/       
                      
           
            $data['segment'] = $this->_getURI3(); //for student profile side   
            $data['RT_reports'] = json_decode($this->_curlGetData(base_url(GET_MOCK_REPORTS_URL), $headers));
            $this->load->view('aa-front-end/includes/header', $data);
            $this->load->view('aa-front-end/mock_test_reports');
            $this->load->view('aa-front-end/includes/footer');
        }
    }
    function mock_test_reports_download($report_id, $test_module_name)
    {
       
        if(!$this->session->userdata('student_login_data')){
            redirect('/my_login');
            exit;
        }elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        }else{
            $report_id=base64_decode($report_id);
            $test_module_name=base64_decode($test_module_name);
            $data['title'] = 'Mock Test Report';
            $html = "";
            $headers = array(
                'API-KEY:' . WOSA_API_KEY,
                'STUDENT-ID:' . $this->session->userdata('student_login_data')->id,
                'REPORT-ID:' . $report_id,
                'TEST:' . $test_module_name,
                'CLASSROOM-ID:' . @$_SESSION['classroom_id'],
            );
            $pdfFilePath = "MockTestReport-" . $report_id . $test_module_name . ".pdf";
            $data['RT_report_data'] = json_decode($this->_curlGetData(base_url(GET_MOCK_REPORT_DATA_URL), $headers));
            if($test_module_name == IELTS or $test_module_name == IELTS_CD) {
                $html = $this->load->view('aa-front-end/pdf/mock_test_report_pdf_ielts', $data, true);
            }elseif($test_module_name == PTE){
                $html = $this->load->view('aa-front-end/pdf/mock_test_report_pdf_pte', $data, true);
            }elseif($test_module_name == TOEFL){
                $html = $this->load->view('aa-front-end/pdf/mock_test_report_pdf_toefl', $data, true);
            }else{
            }
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf = new \Mpdf\Mpdf([
                'default_font' => 'Open Sans'
            ]);
            $pdf->WriteHTML($html, 2);
            $pdf->Output();
            exit;
        }
    }
    function student_autoLogin()
    {
        if (!$this->session->userdata('student_login_data')) {
            redirect('/my_login');
            exit;
        } elseif ($this->session->userdata('student_login_data')->profileUpdate == 0) {
            redirect('our_students/update_profile');
            exit;
        } else {

                $headers_fourmodule= array(
                'authorization:'.FOURMODULE_KEY,                           
                );  
                $params_fourmodule = array(
                "api" => "login", 
                "action"=>'Auto_login', 
                "centre_id"=>FOURMODULE_ONL_BRANCH_ID, 
                "domain_id"=>FOURMODULE_DOMAIN_ID,                        
                "token"=>$this->session->userdata('student_login_data')->UID,                                      
                );                          
                // Call AUTO login api
                try{
                    echo $this->_curPostData_fourmodules(FOURMODULE_URL, $headers_fourmodule, $params_fourmodule);                    
                }
                catch (Exception $e){
                    echo  $e->getMessage();
                }
               


        }

    }
}
