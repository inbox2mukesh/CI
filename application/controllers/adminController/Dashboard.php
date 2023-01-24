<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/ 
class Dashboard extends MY_Controller{

    function __construct(){
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}         
    }      

    function index(){ 
        
        $this->load->model('User_model');
        $by_user=$_SESSION['UserId'];
        $today = date('d-m-Y');
        $todaystr = strtotime($today);

        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url(WOSA_ADMIN_URL.'dashboard/index?');
         $data['UserActivityData'] = $this->User_model->getUserActivityToday($_SESSION['UserId'],$todaystr,$params); 
        $config['total_rows'] = count($data['UserActivityData']);
        $this->pagination->initialize($config);
              
        $data['title'] = 'Dashboard (Home)';
        $data['_view'] = 'dashboard';
        $this->load->view('layouts/main',$data);
    }
    
}
