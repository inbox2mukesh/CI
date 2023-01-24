<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Other_contents extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Other_contents_model');       
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
        $config['base_url'] = site_url('adminController/other_contents/index?');
        $config['total_rows'] = $this->Other_contents_model->get_all_contents_count();
        $this->pagination->initialize($config);
        $data['title'] = 'All contents';
        $data['other_contents'] = $this->Other_contents_model->get_all_contents($params);
        $data['_view'] = 'other_contents/index';
        $this->load->view('layouts/main',$data);
    }
   
    function add(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Add contents';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('content_title','Title','required|trim');
        $this->form_validation->set_rules('content_type','Type','required');
		$this->form_validation->set_rules('content_desc','Description','trim');		
		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'content_title' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('content_title')))),			
				'content_type' => $this->input->post('content_type'),
                'content_desc' => $this->input->post('content_desc',false),
                'by_user' => $by_user,
            );            
            $id = $this->Other_contents_model->add_contents($params);
            if($id){
                 //activity update start              
                 $activity_name= "Other Content Added";
                 $description= ''.json_encode($params).'';
                 $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                 //activity update end  
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/other_contents/index');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/other_contents/add');
            } 

        }else{      
            $data['_view'] = 'other_contents/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    
    function edit($content_id){

       
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit batch';
        $data['other_contents'] = $this->Other_contents_model->get_contents($content_id);
        if(isset($data['other_contents']['content_id']))
        {
            $data['title'] = 'Edit contents';
            $this->load->library('form_validation');
            $this->form_validation->set_rules('content_title','Title','required|trim');
            $this->form_validation->set_rules('content_type','Type','required');
            $this->form_validation->set_rules('content_desc','Description','trim');			
		
			if($this->form_validation->run())
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'content_title' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('content_title')))),         
                    'content_type' => $this->input->post('content_type'),
                    'content_desc' => $this->input->post('content_desc',false),
                    'by_user' => $by_user,
                ); 
                $id = $this->Other_contents_model->update_contents($content_id,$params);
                if($id){
                    //activity update start                            
                $activity_name= "Other Content Updated";
                unset($data['other_contents']['content_id'],$data['other_contents']['created'],$data['other_contents']['modified']);//unset extras from array               
                          
                $uaID = 'other_contents'.$id;
                $diff1 =  json_encode(array_diff($data['other_contents'], $params));//old
                $diff2 =  json_encode(array_diff($params,$data['other_contents']));//new
                
                $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                if($diff1!=$diff2){
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                }                                        
                //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/other_contents/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/other_contents/edit/'.$content_id);
                }
            }
            else
            {                
                $data['_view'] = 'other_contents/edit';
                $this->load->view('layouts/main',$data);                
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
    
    /*function remove($content_id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $other_contents = $this->Other_contents_model->get_batch($content_id);
        if(isset($other_contents['content_id']))
        {
            $this->Other_contents_model->delete_contents($content_id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/other_contents/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/    
    
}
