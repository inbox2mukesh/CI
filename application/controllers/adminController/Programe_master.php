<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Programe_master extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Programe_master_model');       
    }

    function ajax_check_programe_duplicacy(){

        $programe_name = $this->input->post('programe_name'); 
        $programe_id = $this->input->post('programe_id');  
        if($programe_id and $programe_name) {
            echo $response= $this->Programe_master_model->check_programe_duplicacy2($programe_name,$programe_id);
        }else{
            echo $response= $this->Programe_master_model->check_programe_duplicacy($programe_name); 
        }
    }

    function ajax_getPrograme(){
        
        $test_module_id = $this->input->post('test_module_id', true);
        $getTestPrograme = $this->Programe_master_model->getTestPrograme($test_module_id);
        header('Content-Type: application/json');
        $response = ['msg'=>$getTestPrograme, 'status'=>'true'];
        echo json_encode($response);
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
        $config['base_url'] = site_url('adminController/programe_master/index?');
        $config['total_rows'] = $this->Programe_master_model->get_all_programe_masters_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Program';
        $data['programe_masters'] = $this->Programe_master_model->get_all_programe_masters($params);
        $data['_view'] = 'programe_master/index';
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

        $data['title'] = 'Add Program';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('programe_name','Program name','required|trim|min_length[3]|max_length[100]|is_unique[programe_masters.programe_name]');
	
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'programe_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('programe_name')))),
                'by_user' => $by_user,
            ); 
            //print_r($params);die;           
            $idd = $this->Programe_master_model->add_programe_master($params);
            if($idd==1){
                //activity update start              
                    $activity_name= PROGRAME_ADD;
                    $description= 'New programe '.$params['programe_name'].' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                if($this->Role_model->_has_access_('programe_master','index')){
                    redirect('adminController/programe_master/index');
                }else{
                    redirect('adminController/programe_master/add');
                }
                
            }elseif($idd==2){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/programe_master/add');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/programe_master/add');
            }  
        }
        else
        {            
            $data['_view'] = 'programe_master/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    
    function edit($programe_id=0){
       
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit Program';
        $data['programe_master'] = $this->Programe_master_model->get_programe_master($programe_id);
        
        if(isset($data['programe_master']['programe_id']))
        {
            $this->load->library('form_validation');
			$this->form_validation->set_rules('programe_name','Program name','required|trim|min_length[3]|max_length[100]');		
			if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'programe_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('programe_name')))),
                    'by_user' => $by_user,
                );
                $idd = $this->Programe_master_model->update_programe_master($programe_id,$params,$data['programe_master']['programe_name']);
                if($idd==1){
                    
                    //activity update start             
                        $activity_name= PROGRAME_UPDATE;
                        unset($data['programe_master']['programe_id'],$data['programe_master']['created'],$data['programe_master']['modified']);//unset extras from array
                        $uaID = 'programe_master'.$programe_id;
                        $diff1 =  json_encode(array_diff($data['programe_master'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['programe_master']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG); 
                    if($this->Role_model->_has_access_('programe_master','index')){
                        redirect('adminController/programe_master/index');
                    }else{
                        redirect('adminController/programe_master/edit/'.$programe_id);
                    }          
                    redirect('adminController/programe_master/index');
                }elseif($idd==2){
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);           
                    redirect('adminController/programe_master/edit/'.$programe_id);
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/programe_master/edit/'.$programe_id);
                }  

            }
            else
            {
                $data['_view'] = 'programe_master/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
    /*function remove($programe_id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $programe_master = $this->Programe_master_model->get_programe_master($programe_id);
        if(isset($programe_master['programe_id']))
        {
            $this->db->trans_start(); 
            //activity update start              
                $activity_name= PROGRAME_DELETE;
                $description= 'Programe '.$programe_master['programe_name'].' having PK-ID '.$programe_id.' deleted';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
            $del = $this->Programe_master_model->delete_programe_master($programe_id);
            $this->db->trans_complete();
            if($del){
                $this->session->set_flashdata('flsh_msg', DEL_MSG);
                redirect('adminController/programe_master/index');
            }else{
                $this->session->set_flashdata('flsh_msg', DEL_MSG_FAILED);
                redirect('adminController/programe_master/index');
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/
    
}
