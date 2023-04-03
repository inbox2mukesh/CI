<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Faq_master extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        if(!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Faq_master_model');
        $this->load->model('Test_module_model');        
    }
   
    function index()
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        //$data['all_testModule'] = $this->Faq_master_model->get_all_testModule();
       
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/faq_master/index/?');

        $config['total_rows'] = $this->Faq_master_model->get_all_faq_master_count();
        $this->pagination->initialize($config);
        $data['faq_master'] = $this->Faq_master_model->get_all_faq_master($params);
        $data['title'] = 'FAQs- All';
        $data['_view'] = 'faq_master/index';
        $this->load->view('layouts/main',$data);    
    }

    function add()
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        //$data['all_testModule'] = $this->Faq_master_model->get_all_testModule();
        
        $data['title'] = 'Add FAQs';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('question','Question','required|trim');
		$this->form_validation->set_rules('answer','Answer','required|trim');
        //$this->form_validation->set_rules('test_module_id','Test module','required');
		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(				
				'question' => $this->input->post('question'),
				'answer' => $this->input->post('answer'),                
                //'test_module_id' => $this->input->post('test_module_id'),
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'by_user' => $by_user,
            );
            $id = $this->Faq_master_model->add_faq_master($params);
            if($id){
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG); 
                if($this->Role_model->_has_access_('faq_master','index')){
                    redirect('adminController/faq_master/index');
                }else{
                    redirect('adminController/faq_master/add');
                }                  
                redirect('adminController/faq_master/index');
            }else{                    
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/faq_master/add');
            } 
            
        }
        else
        {			
            //$data['all_test_module'] = $this->Test_module_model->getAllCourse();
            $data['_view'] = 'faq_master/add';
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
        $data['title'] = 'Edit FAQs';
        $data['faq_master'] = $this->Faq_master_model->get_faq_master($id);
        if(isset($data['faq_master']['id']))
        {
            $this->load->library('form_validation');
			$this->form_validation->set_rules('question','Question','required|trim');
            $this->form_validation->set_rules('answer','Answer','required|trim');
            //$this->form_validation->set_rules('test_module_id','Test module','required');
		
			if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(                
                    'question' => $this->input->post('question'),
                    'answer' => $this->input->post('answer'),                
                    //'test_module_id' => $this->input->post('test_module_id'),
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'by_user' => $by_user,
                );
                $id = $this->Faq_master_model->update_faq_master($id,$params);
                if($id){
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);
                    redirect('adminController/faq_master/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/faq_master/edit/'.$id);
                }                
            }
            else
            {				
                //$data['all_test_module'] = $this->Test_module_model->getAllCourse();
                $data['_view'] = 'faq_master/edit';
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
        $faq_master = $this->Faq_master_model->get_faq_master($id);
        if(isset($faq_master['id']))
        {
            $del = $this->Faq_master_model->delete_faq_master($id);
            if($del){
                $this->session->set_flashdata('flsh_msg', DEL_MSG);                
                redirect('adminController/faq_master/index');
            }else{
                $this->session->set_flashdata('flsh_msg', DEL_MSG_FAILED);
                redirect('adminController/faq_master/index');
            }
            
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/
    
}
