<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/ 
class Gender extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Gender_model');       
    }
    
    function index()
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/gender/index?');
        $config['total_rows'] = $this->Gender_model->get_all_gender_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Gender';
        $data['gender'] = $this->Gender_model->get_all_gender($params);        
        $data['_view'] = 'gender/index';
        $this->load->view('layouts/main',$data);
    }

   
    function add()
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['title'] = 'Add gender';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('gender_name','Gender name','required|trim');		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active'),
				'gender_name' => $this->input->post('gender_name'),
                'by_user' => $by_user,
            );            
            $id = $this->Gender_model->add_gender($params);
            if($id){
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/gender/index');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/gender/add');
            }            
        }
        else
        {            
            $data['_view'] = 'gender/add';
            $this->load->view('layouts/main',$data);
        }
    }  

   
    function edit($id)
    {         
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['title'] = 'Edit gender';
        $data['gender'] = $this->Gender_model->get_gender($id);
        
        if(isset($data['gender']['id']))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('gender_name','Gender name','required|trim');		
			if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active'),
					'gender_name' => $this->input->post('gender_name'),
                    'by_user' => $by_user,
                );
                $idd = $this->Gender_model->update_gender($id,$params); 
                if($idd){
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/gender/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/gender/edit/'.$id);
                } 
            }
            else
            {
                $data['_view'] = 'gender/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }    
    
    /*function remove($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $gender = $this->Gender_model->get_gender($id);
        if(isset($gender['id']))
        {
            $this->Gender_model->delete_gender($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/gender/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/
    
}
