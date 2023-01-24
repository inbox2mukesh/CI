<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Category_master extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        if(!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Programe_master_model');
        $this->load->model('Category_master_model');
        $this->load->model('Test_module_model');
    }
    
    function index($test_module_id=0){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['all_testModule'] = $this->Category_master_model->get_all_testModule();

        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/category_master/index/'.$test_module_id.'?');
        $config['total_rows'] = $this->Category_master_model->get_all_category_masters_count($test_module_id);
        $this->pagination->initialize($config);
        $data['category_masters'] = $this->Category_master_model->get_all_category_masters($test_module_id,$params);
        $data['title'] = 'Category- List';
        $data['_view'] = 'category_master/index';
        $this->load->view('layouts/main',$data);
    }

    function add(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['all_testModule'] = $this->Category_master_model->get_all_testModule();
        $data['title'] = 'Add category';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('category_name','Category Name','required|trim|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('programe_id','Program','required|trim|integer');
        $this->form_validation->set_rules('test_module_id','Course','required|trim|integer');
		
		if($this->form_validation->run())     
        {   
            
            $params = array(				
				'programe_id' => $this->input->post('programe_id'),
				'category_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('category_name')))),                
                'test_module_id' => $this->input->post('test_module_id'),
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'by_user' => $_SESSION['UserId'],
            );
            $dup = $this->Category_master_model->dupliacte_category_master($params['test_module_id'],$params['programe_id'],$params['category_name']);
            if($dup=='DUPLICATE'){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/category_master/add');
            }else{
                $id = $this->Category_master_model->add_category_master($params);
                if($id){
                    $getTestName = $this->Test_module_model->getTestName($params['test_module_id']);
                    $test_module_name = $getTestName['test_module_name'];
                    $getProgramName = $this->Programe_master_model->getProgramName($params['programe_id']);
                    $programe_name = $getProgramName['programe_name'];
                    //activity update start              
                        $activity_name= CATEGORY_ADD;
                        $description= 'New category as '.$params['category_name'].' for course '.$test_module_name.'-'.$programe_name.' added';
                        $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    if($this->Role_model->_has_access_('category_master','index')){
                        redirect('adminController/category_master/index/'.$params['test_module_id']);
                    }else{
                        redirect('adminController/category_master/add');
                    }                   
                    
                }else{                    
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/category_master/add');
                } 
            }

        }else{
            $data['all_test_module'] = $this->Test_module_model->get_all_test_module_active();
			$data['all_programe_masters']=$this->Programe_master_model->get_all_programe_masters_active();
            $data['_view'] = 'category_master/add';
            $this->load->view('layouts/main',$data);
        }
    }
    
    function edit($category_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit category';
        $data['category_master'] = $this->Category_master_model->get_category_master($category_id);
        if(isset($data['category_master']['category_id']))
        {
            $this->load->library('form_validation');
			$this->form_validation->set_rules('category_name','Category Name','required|trim|min_length[3]|max_length[30]');
			$this->form_validation->set_rules('programe_id','Program','required|trim|integer');
            $this->form_validation->set_rules('test_module_id','Test module','required|trim|integer');
		
			if($this->form_validation->run()){ 


                $params = array(
					'category_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('category_name')))),
                    'test_module_id' => $this->input->post('test_module_id'),
                    'programe_id' => $this->input->post('programe_id'),
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'by_user' => $_SESSION['UserId'],
                );
                $dup = $this->Category_master_model->dupliacte_category_master2($params['test_module_id'],$params['programe_id'],$params['category_name'],$category_id);
                if($dup=='DUPLICATE'){
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);
                    redirect('adminController/category_master/edit/'.$category_id);
                }else{
                    $id= $this->Category_master_model->update_category_master($category_id,$params);
                }
                
                if($id){
                    $getTestName = $this->Test_module_model->getTestName($params['test_module_id']);
                    $test_module_name = $getTestName['test_module_name'];
                    $getProgramName = $this->Programe_master_model->getProgramName($params['programe_id']);
                    $programe_name = $getProgramName['programe_name'];
                    //activity update start              
                        $activity_name= CATEGORY_UPDATE;
                        $description= 'Category '.$data['category_master']['category_name'].' updated as '.$params['category_name'].' for course '.$test_module_name.'-'.$programe_name.'';
                        $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);
                    if($this->Role_model->_has_access_('category_master','index')){
                        redirect('adminController/category_master/index/'.$params['test_module_id']);
                    }else{
                        redirect('adminController/category_master/edit/'.$category_id);
                    }
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/category_master/edit/'.$category_id);
                } 
                               
            }else{				
                $data['all_test_module']= $this->Test_module_model->get_all_test_module_active();
				$data['all_programe_masters'] = $this->Programe_master_model->get_all_programe_masters_active();
                $data['_view'] = 'category_master/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }    

    //ajax
    function ajax_get_category_forPack(){

        $test_module_id = $this->input->post('test_module_id');
        $programe_id = $this->input->post('programe_id');
        if(isset($test_module_id)){          
            
        $response= $this->Category_master_model->get_category_forPack($test_module_id,$programe_id);
        echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'list not available!', 'status'=>'false'];
            echo json_encode($response);
        } 
    }

    //ajax
    function ajax_get_category_forPackMulti(){

        $test_module_id = $this->input->post('test_module_id');
        $programe_id = $this->input->post('programe_id');
        if(isset($test_module_id)){ 
            $response=$this->Category_master_model->get_category_forPackMulti($test_module_id,$programe_id);
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'list not available!', 'status'=>'false'];
            echo json_encode($response);
        } 
    }

    //ajax
    /*function get_category_name(){        

        $category_id = $this->input->post('category_id');
        if(isset($category_id)){
            $response = $this->Category_master_model->get_category_name_audio($category_id);
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'value not exist!', 'status'=>'false'];
            echo json_encode($response);
        }
    }*/

    /*function remove($category_id){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        
        $category_master = $this->Category_master_model->get_category_master($category_id);
        if(isset($category_master['category_id']))
        {
            $getTestName = $this->Test_module_model->getTestName($category_master['test_module_id']);
            $test_module_name = $getTestName['test_module_name'];
            $getProgramName = $this->Programe_master_model->getProgramName($category_master['programe_id']);
            $programe_name = $getProgramName['programe_name'];
            //activity update start              
                $activity_name= CATEGORY_DELETE;
                $description= 'Category '.$category_master['category_name'].' having PK-ID '.$category_id.' for course '.$test_module_name.'-'.$programe_name.' deleted';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
            //activity update end
            $del = $this->Category_master_model->delete_category_master($category_id);
            if($del){
                $this->session->set_flashdata('flsh_msg', DEL_MSG);
                redirect('adminController/category_master/index/'.$category_master['test_module_id']);
                
            }else{
                $this->session->set_flashdata('flsh_msg', DEL_MSG_FAILED);
                redirect('adminController/category_master/index');
            }
            
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/
    
}
