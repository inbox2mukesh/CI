<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Test_module extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Test_module_model');       
    }

    function ajax_check_course_name_duplicacy(){

        $test_module_name = $this->input->post('test_module_name'); 
        $test_module_id = $this->input->post('test_module_id');  
        if($test_module_id and $test_module_name) {
            echo $response= $this->Test_module_model->check_course_name_duplicacy2($test_module_name,$test_module_id);
        }else{
            echo $response= $this->Test_module_model->check_course_name_duplicacy($test_module_name); 
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
        $config['base_url'] = site_url('adminController/test_module/index?');
        $config['total_rows'] = $this->Test_module_model->get_all_test_module_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Courses';
        $data['test_modules'] = $this->Test_module_model->get_all_test_module($params);
        $data['_view'] = 'test_module/index';
        $this->load->view('layouts/main',$data);
    }
    
    function add(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Add Course';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('test_module_name','Course name','required|trim|is_unique[test_module.test_module_name]');
		$this->form_validation->set_rules('test_module_desc','Course description','trim');		
		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'test_module_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('test_module_name')))), 	
				'test_module_desc' => $this->input->post('test_module_desc'),
                'by_user' => $by_user,
            );            
            $idd = $this->Test_module_model->add_test_module($params);
            if($idd==1){
                //activity update start              
                    $activity_name= COURSE_ADD;
                    $description= 'New course as '.$params['test_module_name'].' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                if($this->Role_model->_has_access_('test_module','index')){
                    redirect('adminController/test_module/index');
                }else{
                    redirect('adminController/test_module/add');
                }
            }elseif($idd==2){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/test_module/add');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/test_module/add');
            }            
        }
        else
        { 
            $data['_view'] = 'test_module/add';
            $this->load->view('layouts/main',$data);
        }
    }

    function edit($test_module_id){ 

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit course';
        $data['test_module'] = $this->Test_module_model->get_test_module($test_module_id);
        if(isset($data['test_module']['test_module_id'])){
           
            $this->load->library('form_validation');
            $this->form_validation->set_rules('test_module_name','Course name','required|trim');
            $this->form_validation->set_rules('test_module_desc','Course description','trim');	
		
			if($this->form_validation->run()){

                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'test_module_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('test_module_name')))),
					'test_module_desc' => $this->input->post('test_module_desc'),
                    'by_user' => $by_user,
                );
                $idd = $this->Test_module_model->update_test_module($test_module_id,$params,$data['test_module']['test_module_name']);
                if($idd==1){
                    
                    //activity update start             
                        $activity_name= COURSE_UPDATE;
                        unset($data['test_module']['test_module_id'],$data['test_module']['created'],$data['test_module']['modified']);//unset extras from array
                        $uaID = 'test_module'.$test_module_id;
                        $diff1 =  json_encode(array_diff($data['test_module'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['test_module']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/test_module/index');
                }elseif($idd==2){
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);           
                    redirect('adminController/test_module/edit/'.$test_module_id);
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/test_module/edit/'.$test_module_id);
                }
            }
            else
            {                
                $data['_view'] = 'test_module/edit';
                $this->load->view('layouts/main',$data);                
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
    
    /*function remove($test_module_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $test_module = $this->Test_module_model->get_test_module($test_module_id);
        if(isset($test_module['test_module_id']))
        {
            //activity update start              
                $activity_name= COURSE_DELETE;
                $description= 'Course '.$test_module['test_module_name'].' having PK-ID as '.$test_module_id.' deleted';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
            $del= $this->Test_module_model->delete_test_module($test_module_id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/test_module/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/ 
    
}
