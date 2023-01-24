<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Neelu
 *
 **/
class Content_type_master extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Content_type_masters_model');       
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
        $config['base_url'] = site_url('adminController/content_type_master/index?');
        $config['total_rows'] = $this->Content_type_masters_model->get_all_content_type_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Content Type';
        $data['content_type_master'] = $this->Content_type_masters_model->get_all_content_type($params);
        $data['_view'] = 'content_type_master/index';
        $this->load->view('layouts/main',$data);
    }
    
    function add()
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Add Content Type';
        $this->load->library('form_validation');		
        $this->form_validation->set_rules('content_type_name','Content Type','required|trim|is_unique[content_type_masters.content_type_name]|min_length[4]|max_length[25]');
		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'content_type_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('content_type_name')))),
                'by_user' => $by_user,
            );            
            $id = $this->Content_type_masters_model->add_content_type($params);			
            if($id){	
                //activity update start              
                    $activity_name= CONTENT_TYPE_ADD;
                    $description= 'New content type '.$params['content_type_name'].' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end			
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                if($this->Role_model->_has_access_('complaint_subject','index')){
                    redirect('adminController/content_type_master/index');
                }else{
                    redirect('adminController/content_type_master/add');
                }
                
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/content_type_master/add');
            }            
        }
        else
        {      
            $data['_view'] = 'content_type_master/add';
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

        $data['title'] = 'Edit Content Type';
        $data['content_type_master'] = $this->Content_type_masters_model->get_content_type($id);
        if(isset($data['content_type_master']['id'])){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('content_type_name','Content Type','required|trim|min_length[4]|max_length[25]');
		
			if($this->form_validation->run())
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'content_type_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('content_type_name')))),
                    'by_user' => $by_user,
                );
                $idd = $this->Content_type_masters_model->update_content_type($id,$params);
                if($idd){               

                    //activity update start              
                        $activity_name= CONTENT_TYPE_UPDATE;
                        unset($data['content_type_master']['id'],$data['content_type_master']['created'],$data['content_type_master']['modified']);//unset extras from array
                        $uaID = 'content_type_master'.$id;
                        $diff1 =  json_encode(array_diff($data['content_type_master'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['content_type_master']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/content_type_master/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/content_type_master/edit/'.$id);
                }
            }else{                
                $data['_view'] = 'content_type_master/edit';
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

        $content_type_master = $this->Content_type_masters_model->get_content_type($id);
        if(isset($content_type_master['id']))
        {
            $this->Content_type_masters_model->delete_content_type($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/content_type_master/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/
    
    function ajax_check_content_type_duplicacy(){

        $content_type_name = $this->input->post('content_type_name'); 
        $content_id = $this->input->post('content_id');  
        if($content_type_name and $content_id) {
            echo $response= $this->Content_type_masters_model->check_content_type_duplicacy2($content_type_name,$content_id);
        }else{
            echo $response=$this->Content_type_masters_model->check_content_type_duplicacy($content_type_name); 
        }
    }
}
