<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Forgot_password extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();       
    }
    
    function index()
    {   
        if($this->session->userdata('student_login_data')){
            redirect('/our_students/student_dashboard');
            exit;
        }
        $data['segment'] = $this->_getURI();
        $data['title'] = 'Forgot Password?';
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
        //feddback url
        $data['feedbackLink'] = json_decode($this->_curlGetData(base_url(GET_FL_URL), $headers));
        $data['Offers'] = json_decode($this->_curlGetData(base_url(GET_OFFERS_URL), $headers));
        //$data['shortBranches'] = $this->_common($headers);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','Email','required|trim');
        if($this->form_validation->run())     
        {
            $params = array(                             
                'email' => $this->input->post('email'),        
            );
            $response= json_decode($this->_curPostData(base_url(FP_STD_URL), $headers, $params));
            if($response->error_message->success==1){
                $msg = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>SUCCESS:</strong> '.$response->error_message->message.' <a href="#" class="alert-link"></a>.
                </div>';               
                $this->session->set_flashdata('flsh_msg', $msg);
                redirect('/my_login');
            }else{                
                $msg ='<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong> '.$response->error_message->message.'<a href="#" class="alert-link"></a>.
                </div>';
                $this->session->set_flashdata('flsh_msg', $msg);
                redirect('/Forgot_password');
            }

        }else{
           // $data['allCnt'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_URL), $headers));
            $this->load->view('aa-front-end/includes/header',$data);
            $this->load->view('aa-front-end/forgot_password');
            $this->load->view('aa-front-end/includes/footer');
        }
        
    }

    function send_forgot_pass()
    {
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','Email','required|trim');
        if($this->form_validation->run())     
        {
            $params = array(                             
                'email' => $this->input->post('email'),        
            );
            $response= json_decode($this->_curPostData(base_url(FP_STD_URL), $headers, $params));
            if($response->error_message->success==1){
                $msg = '<div class="alert alert-success alert-dismissible">                   
                    <strong>SUCCESS:</strong> '.$response->error_message->message.'</div>';               
               // $this->session->set_flashdata('flsh_msg', $msg);
                header('Content-Type: application/json');
                $response = ['msg'=>$msg, 'status'=>1];
               echo json_encode($response);
                //redirect('/My_login');
            }else{                
                $msg ='<div class="alert alert-danger alert-dismissible bg-white">                    
                   '.$response->error_message->message.'</div>';
                //$this->session->set_flashdata('flsh_msg', $msg);
                header('Content-Type: application/json');
                $response = ['msg'=>$msg, 'status'=>0];
               echo json_encode($response);
                //redirect('/Forgot_password');
            }

        }

    }
   
    
}
