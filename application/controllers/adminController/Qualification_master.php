<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Qualification_master extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if ( !$this->_is_logged_in()) {redirect('adminController/login'); }
        $this->load->model('Qualification_master_model');       
    }

    function ajax_check_qualification_name_duplicacy(){

        $qualification_name = $this->input->post('qualification_name'); 
        $qualification_id = $this->input->post('qualification_id');  
        if($qualification_id and $qualification_name) {
            echo $response= $this->Qualification_master_model->check_qualification_name_duplicacy2($qualification_name,$qualification_id);
        }else{
            echo $response=$this->Qualification_master_model->check_qualification_name_duplicacy($qualification_name); 
        }
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
        $config['base_url'] = site_url('adminController/qualification_master/index?');
        $config['total_rows'] = $this->Qualification_master_model->get_all_qualification_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Qualification';
        $data['qualification_master'] = $this->Qualification_master_model->get_all_qualification($params);
        $data['_view'] = 'qualification_master/index';
        $this->load->view('layouts/main',$data);
    }
    
    function add(){  

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Add Qualification';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('qualification_name','Qualification name','required|trim|is_unique[qualification_masters.qualification_name]');
		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'qualification_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('qualification_name')))),
                'by_user' => $by_user,
            );            
            $idd = $this->Qualification_master_model->add_qualification($params);
            if($idd==2){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/qualification_master/add');
            }elseif($idd==1){                
                //activity update start              
                    $activity_name= QUALIFICATION_ADD;
                    $description= 'New qualification '.$params['qualification_name'].' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/qualification_master/index');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/qualification_master/add');
            }            
        }
        else
        {      
            $data['_view'] = 'qualification_master/add';
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

        $data['title'] = 'Edit Qualification';
        $data['qualification_master'] = $this->Qualification_master_model->get_qualification($id);
        if(isset($data['qualification_master']['id']))
        {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('qualification_name','Qualification name','required|trim');	
		
			if($this->form_validation->run())
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'qualification_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('qualification_name')))),
                    'by_user' => $by_user,
                );
                $idd = $this->Qualification_master_model->update_qualification($id,$params,$data['qualification_master']['qualification_name']);
                if($idd==1){                    
                    //activity update start             
                        $activity_name= QUALIFICATION_UPDATE;
                        unset($data['qualification_master']['id'],$data['qualification_master']['created'],$data['qualification_master']['modified']);//unset extras from array
                        $uaID = 'qualification_master'.$id;
                        $diff1 =  json_encode(array_diff($data['qualification_master'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['qualification_master']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/qualification_master/index');
                }elseif($idd==2){
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);           
                    redirect('adminController/qualification_master/edit/'.$id);
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/qualification_master/edit/'.$id);
                }
            }
            else
            {                
                $data['_view'] = 'qualification_master/edit';
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

        $qualification_master = $this->Qualification_master_model->get_qualification($id);
        if(isset($qualification_master['id']))
        {
            $del= $this->Qualification_master_model->delete_qualification($id);
            if($del){
                //activity update start              
                    $activity_name= QUALIFICATION_DELETE;
                    $description= 'Qualification '.$qualification_master['qualification_name'].' having PK-ID '.$id.' deleted';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', DEL_MSG);
                redirect('adminController/qualification_master/index');
            }else{
                $this->session->set_flashdata('flsh_msg', DEL_MSG_FAILED);
                redirect('adminController/qualification_master/index');
            }
            
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/    
    
}
