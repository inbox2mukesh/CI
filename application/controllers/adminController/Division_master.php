<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Neelu
 *
 **/
class Division_master extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Division_master_model');       
    }
    
    function index(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/division_master/index?');
        $config['total_rows'] = $this->Division_master_model->get_all_division_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Division';
        $data['division_master'] = $this->Division_master_model->get_all_division($params);
        $data['_view'] = 'division_master/index';
        $this->load->view('layouts/main',$data);
    }
    
    function add(){  

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Add Division';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('division_name','Division name','required|trim|is_unique[division_masters.division_name]');
		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'division_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('division_name')))),
                'by_user' => $by_user,
            );            
            $idd = $this->Division_master_model->add_division($params);			
            if($idd){	
                //activity update start              
                    $activity_name= DIVISION_ADD;
                    $description= 'New division as '.$params['division_name'].' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end			
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                if($this->Role_model->_has_access_('division_master','index')){
                    redirect('adminController/division_master/index');
                }else{
                    redirect('adminController/division_master/add');
                }
            }elseif($idd==2){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/division_master/add');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/division_master/add');
            } 
                       
        }else{      
            $data['_view'] = 'division_master/add';
            $this->load->view('layouts/main',$data);
        }
    } 
	
    function edit($id){   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Edit Division';
        $data['division_master'] = $this->Division_master_model->get_division($id);
        if(isset($data['division_master']['id']))
        {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('division_name','division name','required|trim');	
		
			if($this->form_validation->run())
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'division_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('division_name')))),
                    'by_user' => $by_user,
                );
                $idd = $this->Division_master_model->update_division($id,$params,$data['division_master']['division_name']);
                if($idd==1){
                        
                    //activity update start              
                        $activity_name= DIVISION_MASTER_UPDATE;
                        unset($data['division_master']['id'],$data['division_master']['created'],$data['division_master']['modified']);//unset extras from array
                        $uaID = 'division_master'.$id;
                        $diff1 =  json_encode(array_diff($data['division_master'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['division_master']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG); 
                    if($this->Role_model->_has_access_('division_master','index')){
                        redirect('adminController/division_master/index');
                    }else{
                        redirect('adminController/division_master/edit/'.$id);
                    } 
                }elseif($idd==2){
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);           
                    redirect('adminController/division_master/edit/'.$id);
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/division_master/edit/'.$id);
                }
            }else{                
                $data['_view'] = 'division_master/edit';
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
        $by_user=$_SESSION['UserId'];

        $division_master = $this->Division_master_model->get_division($id);
        if(isset($division_master['id']))
        {
            //activity update start              
                $activity_name= DIVISION_MASTER_DELETE;
                $description= 'Division '.$division_master['division_name'].' having PK-ID '.$division_master['id'].' deleted';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
            $this->Division_master_model->delete_division($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/division_master/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/
    
}
