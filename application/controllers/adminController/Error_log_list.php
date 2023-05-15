<?php

class Error_log_list extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->model(['Error_log_detail_model']);
    }
    function index()
    {
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $params=[];
        if($this->input->post('dateTime'))
        {
            $params['log_date'] = date('Y-m-d',strtotime($this->input->post('dateTime')));
        }
        if($this->input->post('reset'))
        {
            unset($params);
        }
        $data['list']=$this->Error_log_detail_model->getlist($params);  
        $data['title'] = 'Error Log List';
        $data['_view'] = 'error_log/index';
        $this->load->view('layouts/main',$data);      
    }
}