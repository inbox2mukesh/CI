<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password extends MY_Controller {

    function __construct() {
        parent::__construct();   
        $this->load->model('User_model');   
        $this->load->helper('common');   
    }

    function index()
    {
        
        if($this->_is_logged_in()){
            redirect('adminController/dashboard');
            exit;
        }
        $data = array();
        $data['error'] = '';
        $data['message'] = '';
        $data['base_url'] = base_url();
        if (isset($_REQUEST['sbmt_fp']) && $_REQUEST['sbmt_fp'] <> "") {
            extract($_REQUEST);  
            $res = $this->User_model->checkEmail($email);
            if($res>0){                
                if(ENVIRONMENT!='production'){
                    $plain_pwd = PLAIN_PWD;  
                }else{
                    $plain_pwd = $this->_getorderTokens(PWD_LEN);
                }
                $is_personal=0;
                $recieveremail = $res['email'];
                if(empty($res['email']))
                {
                    $is_personal=1;
                    $recieveremail = $res['personal_email'];
                }
                $params = array('password'=> md5($plain_pwd));
                $updated = $this->User_model->update_user_pwd($recieveremail,$params,$is_personal);
                
                if(base_url()!=BASEURL ){ //and $updated
                    //MAIL
                    $email_content = forgot_password_email($plain_pwd);
                    $subject = $email_content['subject'];
                    $email_message= $email_content['content'];
                    $mailData               = array();
                    $mailData['email']      = $recieveremail;
                    $mailData['password']   = $plain_pwd;
                    $mailData['email_message'] = $email_message;
                    $mailData['thanks']        = THANKS;
                    $mailData['team']          = WOSA;               
                    $this->sendEmailToadm_fp_($subject,$mailData);
                    //activity update start              
                        $activity_name= FORGOT_PASSWORD;
                        $uaID = 'forgot_password'.$email;                        
                        $description = 'Password recovery';
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);  
                    //activity update end
                }

                $this->session->set_flashdata('flsh_msg', ADMIN_FP_SUC_MSG);
                redirect('/adminController/login');
            }else{
               $this->session->set_flashdata('flsh_msg', ADMIN_FP_ERR_MSG);
               redirect('/adminController/forgot_password');
            }
        }       
        $data['title'] = 'Forgot Password';
        $data['_view'] = 'forgot_password';
        $this->load->view('layouts/login_layout',$data);
    }   

}

?>