<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Rajan Bansal 
 *
 **/
class Workshop_booking extends MY_Controller{
    
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
        $this->load->model('Workshop_booking_model');
        $this->load->helper('common');                            
    } 
    
    function index($enquiry_purpose_id=0){

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
        $data['all_enquiryDates'] = $this->Workshop_booking_model->get_all_workshop_bookings_dates();
        $data['title'] = 'Workshop Booking List';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/workshop_booking/index/'.$enquiry_purpose_id.'?');
        $config['total_rows'] = $this->Workshop_booking_model->get_all_workshop_booking_count($enquiry_purpose_id);
        $this->pagination->initialize($config);        
        $data['enquiry'] = $this->Workshop_booking_model->get_all_workshop_bookings($enquiry_purpose_id,$params);
        $data['_view'] = 'workshop_booking/index'; 
        $this->load->view('layouts/main',$data);
    }

    function ajax_filterWorkshopBookingByDate($filterDate) {
        $UserFunctionalBranch=$this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $data['all_purpose'] = $this->Student_enquiry_model->get_all_purpose();
        $data['all_enquiryDates'] = $this->Workshop_booking_model->get_all_workshop_bookings_dates();
        $data['title'] = 'Workshop Booking By Date';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/workshop_booking/index/'.$filterDate.'?');
        $config['total_rows'] = $this->Workshop_booking_model->get_all_workshop_booking_count_filterDate($filterDate);
        $this->pagination->initialize($config);        
        $data['enquiry'] = $this->Workshop_booking_model->get_all_workshop_booking_filterDate($filterDate,$params);
        $data['_view'] = 'workshop_booking/index';
        $this->load->view('layouts/main',$data);
    }
}
