<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Classroom_post extends MY_Controller{
    
    function __construct(){

        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login'); }
        $this->load->model('Classroom_post_model');
        $this->load->model('Classroom_model');
        $this->load->model('User_model');
        $this->load->model('Test_module_model');   
        $this->load->model('Programe_master_model'); 
        $this->load->model('Batch_master_model');
        $this->load->model('Category_master_model');
        $this->load->model('Center_location_model');
    }

    function index(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $userBranch=[];
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $classroomData2 = [];
        $pattern = "/Trainer/i";
        $isTrainer = preg_match($pattern, $_SESSION['roleName']);
        if($isTrainer){
            $UserAccessAsTrainer=$this->User_model->getUserAccessAsTrainer($_SESSION['UserId']);
            if(!empty($UserAccessAsTrainer)){
                foreach ($UserAccessAsTrainer as $u) {
                    $classroomData1 = $this->Classroom_model->get_classroomID_by_access($u['test_module_id'],$u['programe_id'],$u['category_id'],$u['batch_id'],$u['center_id']);
                    if(!empty($classroomData1)){
                        array_push($classroomData2, $classroomData1);
                    }           
                }
            }else{
                $classroomData2 = [];
            }                
        }else{
            $classroomData2 = $this->Classroom_model->get_all_classroomID($_SESSION['roleName'],$userBranch);                
        }
        $rawArr = [];
        foreach ($classroomData2 as $c) {
            array_push($rawArr, $c['id']);
        }
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE;
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/classroom_post/index/?');
        $config['total_rows'] = $this->Classroom_post_model->get_all_classroom_post_count($rawArr);
        $this->pagination->initialize($config);
        $data['title'] = 'Classroom post- ALL';
        $data['classroom_post']= $this->Classroom_post_model->get_all_classroom_post($rawArr,$params);
        $data['_view'] = 'classroom_post/index';
        $this->load->view('layouts/main',$data);

    } 
    
    function add($classroom_id2=0){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        $params=[];
        //access control ends
        $userBranch=[];
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $data['title'] = 'Add Classroom Post';
        $data['classroom_id'] = $classroom_id2;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('classroom_id[]','Classroom','required');
		$this->form_validation->set_rules('subject','Post Subject','required|trim');
        $this->form_validation->set_rules('body','Post Body','required|trim');
		
        if($this->form_validation->run()){ 

            $by_user=$_SESSION['UserId'];  
            if(!file_exists(CLASSPOST_FILE_PATH)){
                mkdir(CLASSPOST_FILE_PATH, 0777, true);
            }
            $config['upload_path']      = CLASSPOST_FILE_PATH;
            $config['allowed_types']    = CLASSPOST_ALLOWED_TYPES;
            $config['encrypt_name']     = FALSE;         
            $this->load->library('upload',$config);

                if($this->upload->do_upload("media_file")){
                    $data = array('upload_data' => $this->upload->data());
                    $image= $data['upload_data']['file_name'];                     
                }else{                          
                    $image=NULL; 
                }
                $classroom_id=$this->input->post('classroom_id');

                    foreach ($classroom_id as $c){
                        $params = array(                
                            'classroom_id'=>$c, 
                            'subject' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('subject')))),
                            'body' => $this->input->post('body'),                    
                            'media_file' => $image,
                            'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                            'by_user' => $by_user,
                        );
                        $id = $this->Classroom_post_model->add_classroom_post($params);
                    }
                    
                    if($id){
                        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                        redirect('adminController/classroom_post/index');
                    }else{
                        $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                        redirect('adminController/classroom_post/add');
                    }            
                
        }else{
            $classroomData2 = [];
            $pattern = "/Trainer/i";
            $isTrainer = preg_match($pattern, $_SESSION['roleName']);
            if($isTrainer){
                $UserAccessAsTrainer=$this->User_model->getUserAccessAsTrainer($_SESSION['UserId']);
                if(!empty($UserAccessAsTrainer)){
                    foreach ($UserAccessAsTrainer as $u) {
                       $classroomData1 = $this->Classroom_model->get_classroom_by_access($u['test_module_id'],$u['programe_id'],$u['category_id'],$u['batch_id'],$u['center_id'],$params);
                       if(!empty($classroomData1)){
                        array_push($classroomData2, $classroomData1);
                       }           
                    }
                }                
            }else{
                $classroomData2 = $this->Classroom_model->get_all_classroom($_SESSION['roleName'],$userBranch,$params);
                $data['all_test_module']= $this->Test_module_model->get_all_test_module_active();
                $data['all_batches'] = $this->Batch_master_model->get_all_batch_active();
                $data['all_branch'] = $this->Center_location_model->getAcademyBranch($_SESSION['roleName'],$userBranch);               
            }
            foreach($classroomData2 as $key => $cd){
                $pattern = "/,/i";
                $isMultipeCategory = preg_match($pattern, $cd['category_id']);
                if($isMultipeCategory){
                    $cat_arr = explode(',', $cd['category_id']);
                    $cat_arr_count = count($cat_arr);
                    for ($i=0; $i < $cat_arr_count; $i++) { 
                        $get_category_name = $this->Category_master_model->get_category_name($cat_arr[$i]);
                        foreach ($get_category_name as $key2 => $m) {                
                            $classroomData2[$key]['Category'][$key2].=$m.', ';                       
                        }                    
                    }
                }else{
                    $get_category_name = $this->Category_master_model->get_category_name($cd['category_id']);
                    foreach ($get_category_name as $key2 => $m) {                
                        $classroomData2[$key]['Category'][$key2]=$m;                       
                    }
                }
            }            
            $data['all_classroom']=$classroomData2;            
            $data['classroom_id']=$classroom_id2; 
            $data['_view'] = 'classroom_post/add';
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

        $userBranch=[];
        $params=[];
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }
        $data['title'] = 'Edit Classroom Post';
        $data['classroom_post'] = $this->Classroom_post_model->get_classroom_post($id);
        
        if(isset($data['classroom_post']['id'])){

            $this->load->library('form_validation');
            $this->form_validation->set_rules('classroom_id','Classroom','required');
			$this->form_validation->set_rules('subject','Post Subject','required|trim');
            $this->form_validation->set_rules('body','Post Body','required|trim');		
			if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
                    'classroom_id'=>$this->input->post('classroom_id'), 
					'subject' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('subject')))),
                    'body' => $this->input->post('body'),                    
					'media_file' => $this->input->post('media_file') ? $this->input->post('media_file') : NULL,
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'by_user' => $by_user,
                );
                        if(!file_exists(CLASSPOST_FILE_PATH)){
                            mkdir(CLASSPOST_FILE_PATH, 0777, true);
                        }
                        $config['upload_path']      = CLASSPOST_FILE_PATH;
                        $config['allowed_types']    = CLASSPOST_ALLOWED_TYPES;
                        $config['encrypt_name']     = FALSE;          
                        $this->load->library('upload',$config);

                        if($this->upload->do_upload("media_file")){
                            $data = array('upload_data' => $this->upload->data());
                            $image= $data['upload_data']['file_name'];

                            $params = array(                    
                                'classroom_id'=>$this->input->post('classroom_id'), 
                                'subject' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('subject')))),
                                'body' => $this->input->post('body'),                    
                                'media_file' => $image,
                                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                                'by_user' => $by_user,
                            ); 

                        }else{
                            
                            $params = array(                    
                                'classroom_id'=>$this->input->post('classroom_id'),
                                'subject' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('subject')))),
                                'body' => $this->input->post('body'),
                                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                                'by_user' => $by_user,
                            );
                        }

                $idd = $this->Classroom_post_model->update_classroom_post($id,$params);
                if($idd){
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/classroom_post/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/classroom_post/edit/'.$id);
                }
                
            }else{

            $classroomData2 = [];
            $pattern = "/Trainer/i";
            $isTrainer = preg_match($pattern, $_SESSION['roleName']);
            if($isTrainer){
                $UserAccessAsTrainer=$this->User_model->getUserAccessAsTrainer($_SESSION['UserId']);
                if(!empty($UserAccessAsTrainer)){
                    foreach ($UserAccessAsTrainer as $u) {
                       $classroomData1 = $this->Classroom_model->get_classroom_by_access($u['test_module_id'],$u['programe_id'],$u['category_id'],$u['batch_id'],$u['center_id'],$params);
                       if(!empty($classroomData1)){
                        array_push($classroomData2, $classroomData1);
                       }           
                    }
                }else{
                    $classroomData2 = [];
                }                
            }else{
                $classroomData2 = $this->Classroom_model->get_all_classroom($_SESSION['roleName'],$userBranch,$params);
                $data['all_test_module']= $this->Test_module_model->get_all_test_module_active();
                $data['all_batches'] = $this->Batch_master_model->get_all_batch_active();
                $data['all_branch'] = $this->Center_location_model->getAcademyBranch($_SESSION['roleName'],$userBranch);               
            }
            foreach($classroomData2 as $key => $cd){
                $pattern = "/,/i";
                $isMultipeCategory = preg_match($pattern, $cd['category_id']);
                if($isMultipeCategory){
                    $cat_arr = explode(',', $cd['category_id']);
                    $cat_arr_count = count($cat_arr);
                    for ($i=0; $i < $cat_arr_count; $i++) { 
                        $get_category_name = $this->Category_master_model->get_category_name($cat_arr[$i]);
                        foreach ($get_category_name as $key2 => $m) {                
                            $classroomData2[$key]['Category'][$key2].=$m.', ';                       
                        }                    
                    }
                }else{
                    $get_category_name = $this->Category_master_model->get_category_name($cd['category_id']);
                    foreach ($get_category_name as $key2 => $m) {                
                        $classroomData2[$key]['Category'][$key2]=$m;                       
                    }
                }
            }            
            $data['all_classroom']=$classroomData2;            
            //$data['classroom_id']=$id; 
            $data['_view'] = 'classroom_post/edit';
            $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }    

    function remove($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        $classroom_post = $this->Classroom_post_model->get_classroom_post($id);
        if(isset($classroom_post['id']))
        {
            $del = $this->Classroom_post_model->delete_classroom_post($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            if($del){
                redirect('adminController/classroom_post/index');
            }else{
                redirect('adminController/classroom_post/index');
            }
            
        }else
            show_error(ITEM_NOT_EXIST);
    }
    
}
