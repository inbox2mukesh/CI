<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Designation_master extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Designation_master_model');       
    }

    function ajax_check_check_designation_duplicacy(){

        $designation_name = $this->input->post('designation_name'); 
        $designation_id = $this->input->post('designation_id');  
        if($designation_id and $designation_name) {
            echo $response= $this->Designation_master_model->check_compalint_subject_duplicacy2($designation_name,$designation_id);
        }else{
            echo $response=$this->Designation_master_model->check_compalint_subject_duplicacy($designation_name); 
        }
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
        $config['base_url'] = site_url('adminController/designation_master/index?');
        $config['total_rows'] = $this->Designation_master_model->get_all_designation_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Designation/Post';
        $data['designation_master'] = $this->Designation_master_model->get_all_designation($params);
        $data['_view'] = 'designation_master/index';
        $this->load->view('layouts/main',$data);
    }
    
    function add(){  

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Add Designation/Post';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('designation_name','Designation name','required|trim|is_unique[designation_masters.designation_name]');
		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'designation_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('designation_name')))),
                'by_user' => $by_user,
            );            
            $idd = $this->Designation_master_model->add_designation($params);
            if($idd==1){
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);                
                if($this->Role_model->_has_access_('designation_master','index')){
                    redirect('adminController/designation_master/index');
                }else{
                    redirect('adminController/designation_master/add');
                }
            }elseif($idd==2){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/designation_master/add');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/designation_master/add');
            }            
        }
        else
        {      
            $data['_view'] = 'designation_master/add';
            $this->load->view('layouts/main',$data);
        }
    }  

   
    function edit($id)
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Edit Designation/Post';
        $data['designation_master'] = $this->Designation_master_model->get_designation($id);
        if(isset($data['designation_master']['id']))
        {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('designation_name','Designation name','required|trim');	
		
			if($this->form_validation->run())
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'designation_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('designation_name')))),
                    'by_user' => $by_user,
                );
                $idd = $this->Designation_master_model->update_designation($id,$params,$data['designation_master']['designation_name']);
                if($idd==1){
                    //activity update start              
                        $activity_name= DESIGNATION_MASTER_UPDATED;
                        unset($data['designation_master']['id'],$data['designation_master']['created'],$data['designation_master']['modified']);//unset extras from array
                        $uaID = 'designation_master'.$id;
                        $diff1 =  json_encode(array_diff($data['designation_master'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['designation_master']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/designation_master/index');
                }elseif($idd==2){
                    $this->session->set_flashdata('flsh_msg',DUP_MSG);           
                    redirect('adminController/designation_master/edit/'.$id);
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/designation_master/edit/'.$id);
                }
            }
            else
            {                
                $data['_view'] = 'designation_master/edit';
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

        $designation_master = $this->Designation_master_model->get_designation($id);
        if(isset($designation_master['id']))
        {
            $this->Designation_master_model->delete_designation($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/designation_master/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }  */  
    
}
