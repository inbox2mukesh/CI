<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/libraries/traits/erpEncryption.php';
class Login extends MY_Controller{
 use erpEncryption;
    function __construct() {
        parent::__construct();
        $this->load->helper(array('cookie', 'url'));
    }

    function index(){
        
        if($this->_is_logged_in()){ redirect('adminController/dashboard');exit;}
        $data = array();
        $data['error'] = '';
        $data['message'] = '';
        $data['base_url'] = base_url();
        $data['callfromview'] = $this;
        
        if(isset($_REQUEST['sbmt']) && $_REQUEST['sbmt'] <> ""){
            extract($_REQUEST);
            $this->load->model('User_model');
            $employeeCode = filter_var($email, FILTER_SANITIZE_STRING);
            $password = filter_var($passwrd, FILTER_SANITIZE_STRING);
            $res = $this->User_model->doLogin($employeeCode,$passwrd,1);
            if($res){
                $this->session->set_userdata(SESSION_VAR, $res);
                $datas = $this->session->userdata(SESSION_VAR);
                foreach($datas as $d){
                    session_regenerate_id();
                    $token = $this->_getorderTokens(8);
                    $_SESSION['token'] = $token;                    
                    $_SESSION['employeeCode'] = $d->employeeCode;
                    $_SESSION['UserId'] = $d->id;
                    $_SESSION['roleId'] = $d->role_id;
                    $_SESSION['roleName'] = $d->role_name;
                    $_SESSION['homeBranch'] = $d->homeBranch;
                    $_SESSION['homeBranchId'] = $d->homeBranchId;
                    $checkTokenCount = $this->User_model->checkTokenCount($email);
                    if($checkTokenCount>0){
                        $params_token = array('token'=> $token);
                        $this->User_model->updateUserToken($email,$params_token);
                    }else{
                        $params_token = array('token'=> $token,'username'=>$email);
                        $this->User_model->addUserToken($params_token);
                    }                    
                }                
                if(isset($rememberme) && $rememberme == "on"){ 
                    $mp_username = $this->dataEncryption($email);
                    $mp_pwd = $this->dataEncryption($passwrd);
                    set_cookie(COOKIE_USERNAME,$mp_username,COOKIE_EXPIRY);
                    set_cookie(COOKIE_PWD,$mp_pwd,COOKIE_EXPIRY);
                }else{
                    delete_cookie(COOKIE_USERNAME);
                    delete_cookie(COOKIE_PWD);
                }
                //activity update start 
                    $by_user = $_SESSION['UserId'];              
                    $activity_name= SIGNIN;
                    $description= '';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                redirect('/adminController/dashboard');
            }else{
               $this->session->set_flashdata('flsh_msg', ADMIN_LOGIN_ERR_MSG);
               redirect('/adminController/login');
            }
        }
        $data['_view'] = 'login';
        $this->load->view('layouts/login_layout',$data);
    }

    public function logout($response=''){
        
        $by_user = $_SESSION['UserId'];
        //delete_cookie('user_Latitude');
        //delete_cookie('user_Longitude');
        
        //activity update start              
            $activity_name= SIGNOUT;
            $description= urldecode($response);
            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
        //activity update end
        $this->session->set_userdata(SESSION_VAR, '');
        $this->session->unset_userdata(SESSION_VAR);
        if(isset($_SESSION['UserId'])){
            session_unset($_SESSION['UserId']);
        }
        if(isset($_SESSION['roleId'])){
            session_unset($_SESSION['roleId']);
        }
        if(isset($_SESSION['roleName'])){
            session_unset($_SESSION['roleName']);
        }
        if(isset($_SESSION['homeBranch'])){
            session_unset($_SESSION['homeBranch']);
        }
        if(isset($_SESSION['homeBranchId'])){
            session_unset($_SESSION['homeBranchId']);
        }
        if(isset($_SESSION['token'])){
           session_unset($_SESSION['token']);
        }        
        session_unset($_SESSION['UserId']);
        session_unset($_SESSION['roleId']);
        session_unset($_SESSION['roleName']);
        session_unset($_SESSION['homeBranch']);
        session_unset($_SESSION['homeBranchId']);
        session_unset($_SESSION['date']);
        session_unset($_SESSION['employeeCode']);
        session_unset($_SESSION['userActivitySearch']['center_id']);
        session_unset($_SESSION['userActivitySearch']['employee_id']);
        session_unset($_SESSION['userActivitySearch']['from_date']);
        session_unset($_SESSION['userActivitySearch']['to_date']);
        session_unset($_SESSION['userActivitySearch']['active']);
        session_unset($_SESSION['userActivitySearch']['status']);
       // $this->session->sess_destroy();        
        redirect('adminController/login');
    }

}

?>