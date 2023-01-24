<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Batch_master extends MY_Controller{
    
    function __construct(){
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Batch_master_model');        
    }

    function ajax_check_batch_duplicacy(){

        $batch_name = $this->input->post('batch_name'); 
        $batch_id = $this->input->post('batch_id');  
        if($batch_id and $batch_name) {
            echo $response= $this->Batch_master_model->check_batch_duplicacy2($batch_name,$batch_id);
        }else{
            echo $response=$this->Batch_master_model->check_batch_duplicacy($batch_name); 
        }
    }
    
    function index(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends 

        $this->auto_loadCaching(CACHE_ENGINE);
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/batch_master/index?');
        $config['total_rows'] = $this->Batch_master_model->get_all_batch_count();
        $this->pagination->initialize($config);
        $data['title'] = 'All Batches';
        $data['batch_master'] = $this->Batch_master_model->get_all_batch($params); 
        $this->auto_cacheOff();       
        $data['_view'] = 'batch_master/index';
        $this->load->view('layouts/main',$data);

    }

    function add(){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends               

        $data['title'] = 'Add Batch';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('batch_name','Batch name','required|trim|is_unique[batch_master.batch_name]|min_length[4]|max_length[20]');
		$this->form_validation->set_rules('batch_desc','Description','trim');		
		
		if($this->form_validation->run()){            
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'batch_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('batch_name')))),			
				'batch_desc' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('batch_desc')))),
                'by_user' => $_SESSION['UserId'],
            );                        
            $idd = $this->Batch_master_model->add_batch($params);            
            if($idd==1){
                $this->auto_cacheUpdate($this->router->fetch_class());$this->auto_cacheOff();
                //activity update start              
                    $activity_name= BATCH_ADD;
                    $description= ''.json_encode($params).'';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                if($this->Role_model->_has_access_('batch_master','index')){
                    redirect('adminController/batch_master/index');
                }else{
                    redirect('adminController/batch_master/add');
                }
                
            }elseif($idd==2){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/batch_master/add');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/batch_master/add');
            }  

        }else{      
            $data['_view'] = 'batch_master/add';
            $this->load->view('layouts/main',$data);
        }        
    }
    
    function edit($batch_id){  

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Edit batch';
        $data['batch_master'] = $this->Batch_master_model->get_batch($batch_id);
        if(isset($data['batch_master']['batch_id'])){

            $data['title'] = 'Edit Batch';
            $this->load->library('form_validation');
            $this->form_validation->set_rules('batch_name','Batch name','required|trim|min_length[4]|max_length[20]');
            $this->form_validation->set_rules('batch_desc','Description','trim');			
		
			if($this->form_validation->run()){              
                
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'batch_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('batch_name')))),	
					'batch_desc' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('batch_desc')))),
                    'by_user' => $_SESSION['UserId'],
                );
                $idd = $this->Batch_master_model->update_batch($batch_id,$params,$data['batch_master']['batch_name']);                
                if($idd==1){
                    $this->auto_cacheUpdate($this->router->fetch_class());$this->auto_cacheOff();
                    //activity update start             
                        $activity_name= BATCH_MASTER_UPDATE;
                        unset($data['batch_master']['batch_id'],$data['batch_master']['created'],$data['batch_master']['modified']);//unset extras from array
                        $uaID = 'batch_master'.$id;
                        $diff1 =  json_encode(array_diff($data['batch_master'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['batch_master']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG); 
                    if($this->Role_model->_has_access_('batch_master','index')){
                        redirect('adminController/batch_master/index');
                    }else{
                        redirect('adminController/batch_master/edit/'.$batch_id);
                    }          
                    redirect('adminController/batch_master/index');
                }elseif($idd==2){
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);           
                    redirect('adminController/batch_master/edit/'.$batch_id);
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/batch_master/edit/'.$batch_id);
                }

            }else{                
                $data['_view'] = 'batch_master/edit';
                $this->load->view('layouts/main',$data);                
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }    
    
}
