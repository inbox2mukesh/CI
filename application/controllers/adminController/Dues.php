<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Dues extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        if(!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('User_model');
        $this->load->model('Center_location_model');
        $this->load->model('Programe_master_model');
        $this->load->model('Test_module_model');  
        $this->load->model('Student_package_model');     
    } 

    function recoverable_dues($date=NULL){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $this->auto_PreventformResubmissionError();

        $UserFunctionalBranch=$this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }
        $data['title'] = 'Recoverable Dues';
        $this->load->library('form_validation');         
        $this->form_validation->set_rules('dateType', 'Select date type', 'required');
        $this->form_validation->set_rules('pack_type', 'Select Pack Type', 'required');
        $center_id = $this->input->post('center_id');
        if(isset($center_id)){
            $brCount = count($center_id);
        }else{
            $brCount = 0;
        }
            
        if($brCount==0){
            $this->form_validation->set_rules('center_id','Branch','required');   
        }
        if($this->form_validation->run())     
        { 
            if($this->input->post('dateType')){
                $dateType = $this->input->post('dateType');
            }else{
                $dateType='';
            } 
            
            $test_module_id = $this->input->post('test_module_id');
            $programe_id = $this->input->post('programe_id');

            $params = array(
                'center_id' => $center_id,
                'dateType'=> $this->input->post('dateType'),
                'pack_type' => $this->input->post('pack_type'),
                'test_module_id' => $test_module_id,           
                'programe_id' => $programe_id,
                'date_from'  => $this->input->post('date_from'), 
                'date_to'  => $this->input->post('date_to'),              
            );                    
            $getDuesdata = $this->Student_package_model->getDuesReport($params);
            $data['duesData']=$getDuesdata;
            if(!empty($getDuesdata)){
                $this->session->set_flashdata('flsh_msg', SEARCH_MSG);
            }else{
                $this->session->set_flashdata('flsh_msg', SEARCH_MSG_404);
            }
            

        }else{

            if($date){
                $today = $date;
                $params = array(
                    'date_from'  => $today, 
                    'date_to'  => $today,
                );
                $data['duesData']=$this->Student_package_model->getDuesReportYTT($userBranch,$_SESSION['roleName'],$params);
            }else{
                $today = date('d-m-Y');
                $params = array(
                    'date_from'  => $today, 
                    'date_to'  => $today,
                );
                $data['duesData']=$this->Student_package_model->getDuesReportYTT($userBranch,$_SESSION['roleName'],$params);
            }
            
        }
        $data['all_branch'] = $this->Center_location_model->getFunctionalBranch($_SESSION['roleName'],$userBranch);
        $data['all_programe_masters']=$this->Programe_master_model->getPgm_forStudent();
        $data['all_test_module']=$this->Test_module_model->get_all_test_module_active();
        $data['_view'] = 'dues/recoverable_dues';
        $this->load->view('layouts/main', $data);
    }   
    
    function irrecoverable_dues($date=NULL){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends

        $this->auto_PreventformResubmissionError();        

        $UserFunctionalBranch=$this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }
        $data['title'] = 'Irrecoverable Dues';
        $this->load->library('form_validation');         
        $this->form_validation->set_rules('dateType', 'Select date type', 'required');
        $this->form_validation->set_rules('pack_type', 'Select Pack Type', 'required');
        $center_id = $this->input->post('center_id');

        if(isset($center_id)){
            $brCount = count($center_id);
        }else{
            $brCount = 0;
        }
        if($brCount==0){
            $this->form_validation->set_rules('center_id','Branch','required');   
        }
        if($this->form_validation->run())     
        { 
            if($this->input->post('dateType')){
                $dateType = $this->input->post('dateType');
            }else{
                $dateType='';
            }         
            $test_module_id = $this->input->post('test_module_id');
            $programe_id = $this->input->post('programe_id');

            $params = array(
                'center_id' => $center_id,
                'dateType'=> $this->input->post('dateType'),
                'pack_type' => $this->input->post('pack_type'),
                'test_module_id' => $test_module_id,           
                'programe_id' => $programe_id,
                'date_from'  => $this->input->post('date_from'), 
                'date_to'  => $this->input->post('date_to'),              
            );                    
            $getIrrDuesdata = $this->Student_package_model->getIrrDuesReport($params);
            $data['irrDuesData']=$getIrrDuesdata;
            if(!empty($getIrrDuesdata)){
                $this->session->set_flashdata('flsh_msg', SEARCH_MSG);
            }else{
                $this->session->set_flashdata('flsh_msg', SEARCH_MSG_404);
            }
            

        }else{

            if($date){
                $today = $date;
                $params = array(
                    'date_from'  => $today, 
                    'date_to'  => $today,
                );
                $data['irrDuesData']=$this->Student_package_model->getDuesReportYTT($userBranch,$_SESSION['roleName'],$params);
            }else{
                $today = date('d-m-Y');
                $params = array(
                    'date_from'  => $today, 
                    'date_to'  => $today,
                );
                $data['irrDuesData']=$this->Student_package_model->getDuesReportYTT($userBranch,$_SESSION['roleName'],$params);
            }
            
        }
        $data['all_branch'] = $this->Center_location_model->getFunctionalBranch($_SESSION['roleName'],$userBranch);
        $data['all_programe_masters']=$this->Programe_master_model->getPgm_forStudent();
        $data['all_test_module']=$this->Test_module_model->get_all_test_module_active();
        $data['_view'] = 'dues/irrecoverable_dues';
        $this->load->view('layouts/main', $data);
    }
    
    
}
