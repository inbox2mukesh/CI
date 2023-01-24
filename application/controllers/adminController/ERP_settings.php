<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class ERP_settings extends MY_Controller{

    function __construct(){
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');} 
        $this->load->database();
    }

    function settings(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends            
        
        $data['title'] = 'Settings';
        $data['_view'] = 'erp_settings/settings';
        $this->load->view('layouts/main',$data);
    }

    function set_erp_softly(){
        
        $this->load->model('User_model');
        if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){
            $this->User_model->auto_init_erp_softly();
            //activity update start           
                $activity_name= AUTO_ENIT_ERP_SOFT;
                $description='ERP Initiated (Softly)';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
            //activity update end
            redirect('adminController/dashboard/index');
        }
    }

    function set_erp_hardly(){
        
        $this->load->model('User_model');
        if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){
            $this->User_model->auto_init_erp_hardly();            
            //activity update start           
                $activity_name= AUTO_ENIT_ERP_HARD;
                $description='ERP Initiated (Hardly)';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
            //activity update end
            redirect('adminController/dashboard/index');
        }
    }

    function add_money_to_wallet(){
        
        $this->load->model('Student_model');
        if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){
            $this->Student_model->add_money_to_wallet();
            $by_user=$_SESSION['UserId'];
            //activity update start           
                $activity_name= ADD_MONEY_TO_WALLET;
                $description='Added test money to wallet';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
            redirect('adminController/student/index');
        }        
    }
    function empty_counselling(){
        
        $this->load->model('Counseling_session_model');
        if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){
            $this->Counseling_session_model->empty_counselling();            
            //activity update start           
                $activity_name= AUTO_ENIT_ERP_HARD;
                $description='ERP Initiated (Hardly)';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
            //activity update end
            redirect('adminController/counseling_session/index');
        }
    }
    
}
