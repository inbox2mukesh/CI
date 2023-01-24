<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
   class State extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('State_model');
        $this->load->model('Country_model');        
    }    
    
    function index()
    {
        //access control start
        $cn                     = $this->router->fetch_class().''.'.php';
        $mn                     = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si']             = 0;
        //access control ends
        
        $this->load->library('pagination');
       
        $data['title']          = 'States';
        $params['limit']        = RECORDS_PER_PAGE; 
        $params['offset']       = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config                 = $this->config->item('pagination');
        $config['base_url']     = site_url('adminController/state/index?');
        $config['total_rows']   = $this->State_model->get_all_state_count();
        
        // $this->load->library('form_validation');         
        // $this->form_validation->set_rules('state_id_fake', 'Type state', 'required');

        if($this->input->get("submit") == "search"){ 
            $params['search']       = trim($this->input->get('search'));
            $params['country_id']   = $this->input->get('country_id');
            $params['status']       = $this->input->get('status');
            $params['limit']        = RECORDS_PER_PAGE; 
            $params['offset']       = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
            $config['base_url']     = site_url('adminController/state/index?search='.$params['search'].'&country_id='.$params['country_id'].'&status='.$params['status'].'&submit=search'); 
            $config['total_rows']   = $this->State_model->searchState($params,true);
            //$config['total_rows'] = count($this->State_model->getsearchStateCount($country,$status));
            
            $getStateData           = $this->State_model->searchState($params);
            $data['state']          = $getStateData;

            if(!empty($getStateData)) {
                $this->session->set_flashdata('flsh_msg', SEARCH_MSG);
            } else{
                $this->session->set_flashdata('flsh_msg', SEARCH_MSG_404);
            } 

        } else{
            $data['state'] = $this->State_model->get_all_state($params);
        }

        $this->pagination->initialize($config);
        $data['total_rows']         = $config['total_rows'];
        $data['all_country_list']   = $this->Country_model->get_all_country();        
        $data['_view']              = 'state/index';
        $this->load->view('layouts/main',$data);
    }
    
    function add(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Add state';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('state_name','State name','required|trim|is_unique[state.state_name]');
		$this->form_validation->set_rules('country_id','Country','required');        
		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'country_id' => $this->input->post('country_id'),
				'state_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('state_name')))),                
                'by_user' => $by_user,
            );
            $dup = $this->State_model->dupliacte_state($params['country_id'],$params['state_name']);
            if($dup=='DUPLICATE'){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/state/add');
            }else{
                $id = $this->State_model->add_state($params);
                if($id){
                    $Get_country_byId = $this->Country_model->Get_country_byId($params['country_id']);
                    $country_name = $Get_country_byId['name'];
                    //activity update start              
                        $activity_name= STATE_ADD;
                        $description= 'New state '.$params['state_name'].' in country '.$country_name.' added';
                        $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/state/index');
                }else{                    
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/state/add');
                } 
            }
        }
        else
        {			
			$data['all_country_list'] = $this->Country_model->get_all_country_active();            
            $data['_view'] = 'state/add';
            $this->load->view('layouts/main',$data);
        }
    }
    
    function edit($state_id)
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Edit state';
        $data['state'] = $this->State_model->get_state($state_id);
        if(isset($data['state']['state_id']))
        {
            $this->load->library('form_validation');
			$this->form_validation->set_rules('state_name','State name','required|trim');
			$this->form_validation->set_rules('country_id','Country','required');           
		
			if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'country_id' => $this->input->post('country_id'),
					'state_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('state_name')))),                     
                    'by_user' => $by_user,
                );
                $id = $this->State_model->update_state($state_id,$params);
                if($id){
                    $Get_country_byId=$this->Country_model->Get_country_byId($data['state']['country_id']);
                    $country_name1 = $Get_country_byId['name'];

                    $Get_country_byId=$this->Country_model->Get_country_byId($params['country_id']);
                    $country_name2 = $Get_country_byId['name'];
                    //activity update start              
                        $activity_name= STATE_UPDATE;
                        $description= 'State '.$data['state']['state_name'].' in country '.$country_name1.' updated to  '.$params['state_name'].' in country '.$country_name2.'';
                        $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/state/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/state/edit/'.$category_id);
                }                
            }
            else
            {				
				$data['all_country_list'] = $this->Country_model->get_all_country();
                $data['_view'] = 'state/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

    
    /*function remove($state_id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        $state = $this->State_model->get_state($state_id);
        if(isset($state['state_id']))
        {
            $this->State_model->delete_state($state_id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/state/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/

    
    
}
