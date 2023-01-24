<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class My_login extends MY_Controller{
    
    function __construct(){       
        parent::__construct();   
        $this->load->helper('cookie');   
        //$this->load->model('Discount_model'); 
    }
   
    public function index(){   
       
        if($this->session->userdata('student_login_data')){
            redirect('our_students/student_dashboard/');
            exit;
        }
        $data['title'] = 'Sign In';       
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username','required|trim');
        $this->form_validation->set_rules('password','Password','required');
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
        $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));  
        $data['serviceData']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        // all academic service title:----need to create api 
        $headers1 = array(
            'API-KEY:' . WOSA_API_KEY,
            'NEWS_TAGS:' ,
            'LIMIT:' .RECORDS_PER_PAGE,
            'OFFSET:0',
        );
        $data['newsData']=json_decode($this->_curlGetData(base_url(GET_All_NEWS_DATA_URL), $headers1));
       // $data['shortBranches'] = $this->_common($headers);
        if($this->form_validation->run())     
        {
            $params = array(                             
                'username' => $this->input->post('username'), 
                'password' => $this->input->post('password'),
                'rememberme_f' => $this->input->post('rememberme_f'),         
            );
            $response=json_decode($this->_curPostData(base_url(LOGIN_STD_URL), $headers, $params));
            if($response->error_message->success==1){
                $this->session->set_userdata('student_login_data',$response->error_message->data);
                $student_login_data = $this->session->userdata('student_login_data');
                //print_r($student_login_data);die;
                $rememberme_f =  $params['rememberme_f'];
                if(isset($rememberme_f) && $rememberme_f == "on"){
                    $mp_username_f = $params['username'];
                    $mp_pwd_f = $params['password'];
                    set_cookie('wosa_username_f',$mp_username_f,COOKIE_EXPIRY);
                    set_cookie('wosa_pwd_f',$mp_pwd_f,COOKIE_EXPIRY);
                }else{
                    delete_cookie('wosa_username_f');
                    delete_cookie('wosa_pwd_f');
                }
                $msg = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> '.$response->error_message->message.'<a href="#" class="alert-link"></a>.
                </div>';               
                $this->session->set_flashdata('flsh_msg', $msg);
                if($response->error_message->data->profileUpdate==0){
                    redirect('our_students/update_profile');
                }else{
                    redirect('our_students/student_classroom');
                }
                
            
            }else{                
                $msg ='<div class="alert alert-danger alert-dismissible wht-bg">
                   
                  '.$response->error_message->message.'<a href="#" class="alert-link"></a>
                </div>';
                $this->session->set_flashdata('flsh_msg', $msg);
                redirect('/my_login');
            }

        }else{           
            $this->load->view('aa-front-end/includes/header',$data);
            $this->load->view('aa-front-end/student_login');
            $this->load->view('aa-front-end/includes/footer');
        }
        
    }
	function stu_login()
	{       
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username','required|trim');
        $this->form_validation->set_rules('password','Password','required');
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
             
        if($this->form_validation->run())     
        {
            $params = array(                             
                'username' => $this->input->post('username'), 
                'password' => $this->input->post('password'),
                'rememberme_f' => $this->input->post('rememberme_f'),         
            );
			//print_r($params);
			//die();
            $response=json_decode($this->_curPostData(base_url(LOGIN_STD_URL), $headers, $params));
            if($response->error_message->success==1)
            {


                $this->session->set_userdata('student_login_data',$response->error_message->data);
                $student_login_data = $this->session->userdata('student_login_data');
                //print_r($student_login_data);die;
                $rememberme_f =  $params['rememberme_f'];
                if(isset($rememberme_f) && $rememberme_f == "on"){
                    $mp_username_f = $params['username'];
                    $mp_pwd_f = $params['password'];
                    set_cookie('wosa_username_f',$mp_username_f,COOKIE_EXPIRY);
                    set_cookie('wosa_pwd_f',$mp_pwd_f,COOKIE_EXPIRY);
                }else{
                    delete_cookie('wosa_username_f');
                    delete_cookie('wosa_pwd_f');
                }
                /*$current_DateTime = date("Y-m-d G:i A");
                $current_DateTimeStr = strtotime($current_DateTime);
                $this->Discount_model->deactivate_discount($current_DateTimeStr);*/

                $msg = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> '.$response->error_message->message.'<a href="#" class="alert-link"></a>.
                </div>';               
                $this->session->set_flashdata('flsh_msg', $msg);

                if(isset($_SESSION['actionFor']) AND $_SESSION['actionFor'] == "booking")
                {
                   // $this->load->helper('url');
                header('Content-Type: application/json');
                  $response = ['msg'=>"", 'status'=>'3'];
                 echo json_encode($response);
                   // redirect('/Checkout/');

                }
                 else if(isset($_SESSION['actionFor']) AND $_SESSION['actionFor'] == "booking_session")
                {
                   // $this->load->helper('url');
                header('Content-Type: application/json');
                  $response = ['msg'=>"", 'status'=>'4'];
                 echo json_encode($response);
                   // redirect('/Checkout/');

                }
                else if(isset($_SESSION['actionFor']) AND $_SESSION['actionFor'] == "booking_events")
                {
                   /*do action*/
                }
                else
                 {
                    if($response->error_message->data->profileUpdate==0){
                    // redirect('our_students/update_profile');
                    header('Content-Type: application/json');
                    $response = ['msg'=>$msg, 'status'=>1];
                    echo json_encode($response);
                    }else{
                    // redirect('our_students/student_classroom');
                    header('Content-Type: application/json');
                    $response = ['msg'=>$msg, 'status'=>2];
                    echo json_encode($response);
                    }
                }             
                
            
            }else{                
                $msg ='<div class="alert alert-danger alert-dismissible wht-bg">
                    
                   '.$response->error_message->message.'<a href="#" class="alert-link"></a>
                </div>';
				 header('Content-Type: application/json');
                 $response = ['msg'=>$msg, 'status'=>-1];
                 echo json_encode($response);
				
				
               /// $this->session->set_flashdata('flsh_msg', $msg);
                //redirect('/My_login');
            }

        }
		else{
            
        }
        
		
	}

    public function student_logout(){

        $headers = array(
            'API-KEY:'.WOSA_API_KEY,
            'ID:'.$this->session->userdata('student_login_data')->id 
        ); 
        $params = array(                                
            'loggedIn' => 0,
        );
        $response= json_decode($this->_curPostData(base_url(UPDATE_LOGOUT_STD_URL), $headers, $params));
        if($response->error_message->success==1){
            unset($_SESSION['lastId_std']);
            unset($_SESSION["firstId"]);
            unset($_SESSION["firstId2"]);
            unset($_SESSION['booking_id']);
            unset($_SESSION['student_id']);
            unset($_SESSION['mobile']); 
            unset($_SESSION['time_slot']);
            unset($_SESSION['walkin_lastId_std']);
            unset($_SESSION['packActive']);
            unset($_SESSION['compId']);
            unset($_SESSION['classroom_id']);
            unset($_SESSION['classroom_name']);
            unset($_SESSION['classroom_Validity']);
            unset($_SESSION['classroom_daysleft']);
            unset($_SESSION['book_packid']);            
            unset($_SESSION['checkout_token_no']);            
            unset($_SESSION['actionFor']);
            unset($_SESSION['book_pack_type']);
            //unset($_SESSION['active_country']);
            $this->session->set_userdata('student_login_data', '');
            $this->session->unset_userdata('student_login_data');
           // $this->session->sess_destroy();
            redirect('/my_login');
        }else{
            redirect('/my_login');
        }
    }
   
    
}
