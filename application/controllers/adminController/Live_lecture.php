<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Live_lecture extends MY_Controller{
    
    function __construct(){

        parent::__construct();
        if ( !$this->_is_logged_in()) {redirect('adminController/login'); }        
        $this->load->model('Live_lecture_model');
        $this->load->model('Classroom_model');   
        $this->load->model('User_model');
        $this->load->model('Test_module_model');   
        $this->load->model('Programe_master_model'); 
        $this->load->model('Batch_master_model');
        $this->load->model('Category_master_model');
        $this->load->model('Center_location_model'); 
        $this->load->model('Content_type_masters_model');
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
        $config['base_url'] = site_url('adminController/live_lecture/index/?');
        $config['total_rows'] = $this->Live_lecture_model->get_all_live_lectures_count($rawArr);
        $this->pagination->initialize($config);
        $data['title'] = 'Classroom Lectures';
        $data['live_lectures'] = $this->Live_lecture_model->get_all_live_lectures($rawArr,$params);
        $data['_view'] = 'live_lecture/index';
        $this->load->view('layouts/main',$data);
    }
    
    function add($classroom_id2=0){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

       $userBranch=[];
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        foreach ($UserFunctionalBranch as $b){
        array_push($userBranch,$b['center_id']);
        }

        $data['title'] = 'Add classroom lecture';
        $data['classroom_id'] = $classroom_id2;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('classroom_id[]','Classroom','required');
        $this->form_validation->set_rules('content_type_id','Content type','required');
		$this->form_validation->set_rules('live_lecture_title','Live lecture title','required|trim');
		$this->form_validation->set_rules('video_url','Video URL','required|trim|callback_auto_mp4allowonly[video_url]');
        $this->form_validation->set_rules('lecture_date','Lecture Date','required|trim');
        $params = [];
    

       /* if (empty($_FILES['screenshot']['name']))
        {
        $this->form_validation->set_rules('screenshot','screenshot','required|trim');
        }*/		
      
        if($this->form_validation->run())
        {  
           
            $lecture_date=$this->input->post('lecture_date');
            //$lecture_date=date_create($this->input->post('lecture_date'));
            //$lecture_date=date_format($lecture_date,"Y-m-d");
            $by_user=$_SESSION['UserId'];
            if(!file_exists(LIVE_LECTURE_IMAGE_PATH)){
                mkdir(LIVE_LECTURE_IMAGE_PATH, 0777, true);
            }            
            $config['upload_path']      = LIVE_LECTURE_IMAGE_PATH;
            $config['allowed_types']    = WEBP_FILE_TYPES;
            $config['encrypt_name']     = FALSE;         
            $this->load->library('upload',$config);           
           
                 
            if($this->upload->do_upload("screenshot")){             
                $data = array('upload_data' => $this->upload->data());
                $image= site_url(LIVE_LECTURE_IMAGE_PATH).$data['upload_data']['file_name'];
                $classroom_id=$this->input->post('classroom_id');
                foreach ($classroom_id as $c){
                    if($c>0){
                        
                        $params = array(                                
                            'classroom_id' => $c,
                            'content_type_id' => $this->input->post('content_type_id'),
                            'live_lecture_title' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('live_lecture_title')))),
                            'video_url' => $this->input->post('video_url') ? $this->input->post('video_url') : NULL,
                            'screenshot' => $image,
                            'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                            'by_user' => $by_user,
                            'lecture_date' =>$lecture_date,
                            'lecture_strdate' => strtotime($lecture_date)
                        ); 
                        $idd = $this->Live_lecture_model->add_live_lecture($params);
                    }                    
                }

            }else{
                $classroom_id=$this->input->post('classroom_id');
                foreach ($classroom_id as $c){  
                    if($c>0){         
                        $params = array(                                
                            'classroom_id' => $c,
                            'content_type_id' => $this->input->post('content_type_id'),
                            'live_lecture_title' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('live_lecture_title')))),
                            'video_url' => $this->input->post('video_url') ? $this->input->post('video_url') : NULL,
                            'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                            'by_user' => $by_user,
                            'lecture_date' =>$lecture_date,
                            'lecture_strdate' => strtotime($lecture_date)
                        );
                     $idd = $this->Live_lecture_model->add_live_lecture($params); 
                    }
                }
            }            
            if($idd){
              
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/live_lecture/index/'.$params['test_module_id']);
            }else{
               
                 $this->session->set_flashdata('flsh_msg', FAILED_MSG);
               redirect('adminController/live_lecture/add');
            }               
                
        }else{  
           // print_r($_FILES);                        
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
            $data['content_type_list']=$this->Content_type_masters_model->get_all_content_type_active(); 
            foreach($classroomData2 as $key => $cd){
                $pattern = "/,/i";
                $isMultipeCategory = preg_match($pattern, $cd['category_id']);
                if($isMultipeCategory){
                    $cat_arr = explode(',', $cd['category_id']);
                    $cat_arr_count = count($cat_arr);
                    for($i=0; $i < $cat_arr_count; $i++){ 
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
            $data['_view'] = 'live_lecture/add';
            $this->load->view('layouts/main',$data);
        }
    }
    function auto_mp4allowonly($video_url)
    {
       $video_ext = end(explode('.',$video_url));
     
       if(strtolower($video_ext) !='mp4')
        {
            $this->form_validation->set_message('auto_mp4allowonly','Invalid url only MP4 is allowed');
            return false;
        }
        else {
           return true;
        }
    }
    

    function edit($live_lecture_id){ 

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $userBranch=[];
        $params = [];
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $data['title'] = 'Edit classroom lecture';
        $data['live_lecture'] = $this->Live_lecture_model->get_live_lecture($live_lecture_id);
        
        if(isset($data['live_lecture']['live_lecture_id'])){

            $this->load->library('form_validation');
            $this->form_validation->set_rules('classroom_id','Classroom','required');
            $this->form_validation->set_rules('content_type_id','Content type','required');
			$this->form_validation->set_rules('live_lecture_title','Live lecture title','required|trim');
            $this->form_validation->set_rules('video_url','Video URL','required|trim|callback_auto_mp4allowonly[video_url]');
            $this->form_validation->set_rules('lecture_date','Lecture Date','required|trim');
            
            /*$file_hidden=$this->input->post('file_hidden');
            if ($file_hidden =="" && empty($_FILES['screenshot']['name']))
        {
             $this->form_validation->set_rules('screenshot','screenshot','required|trim');
        }	*/	
			if($this->form_validation->run())     
            {   
                $lecture_date=$this->input->post('lecture_date');
                $by_user=$_SESSION['UserId'];
                $params = array(					
					'classroom_id' => $this->input->post('classroom_id'),
                    'content_type_id' => $this->input->post('content_type_id'),
					'live_lecture_title' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('live_lecture_title')))),
					'video_url' => $this->input->post('video_url') ? $this->input->post('video_url') : NULL,
					'screenshot' => $this->input->post('screenshot') ? $this->input->post('screenshot') : NULL,
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'by_user' => $by_user,
                    'lecture_date' =>$lecture_date,
                    'lecture_strdate' => strtotime($lecture_date)
                );
                        if(!file_exists(LIVE_LECTURE_IMAGE_PATH)){
                            mkdir(LIVE_LECTURE_IMAGE_PATH, 0777, true);
                        }
                        $config['upload_path']  = LIVE_LECTURE_IMAGE_PATH;
                        $config['allowed_types']= WEBP_FILE_TYPES;
                        $config['encrypt_name'] = FALSE;         
                        $this->load->library('upload',$config);

                        if($this->upload->do_upload("screenshot")){
                            $data = array('upload_data' => $this->upload->data());
                            $image= site_url(LIVE_LECTURE_IMAGE_PATH).$data['upload_data']['file_name'];

                            $params = array(                                
                                'classroom_id' => $this->input->post('classroom_id'),
                                'content_type_id' => $this->input->post('content_type_id'),
                                'live_lecture_title' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('live_lecture_title')))),
                                'video_url' => $this->input->post('video_url') ? $this->input->post('video_url') : NULL,
                                'screenshot' => $image,
                                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                                'by_user' => $by_user,
                                'lecture_date' =>$lecture_date,
                            'lecture_strdate' => strtotime($lecture_date)
                            ); 
                            
                            $file_hidden=end(explode("/",$this->input->post('file_hidden')));
                            if (!empty($_FILES['screenshot']['name']))
                            {
                            unlink(LIVE_LECTURE_IMAGE_PATH.$file_hidden);
                            }

                        }else{                            
                            $params = array(                                
                                'classroom_id' => $this->input->post('classroom_id'),
                                'content_type_id' => $this->input->post('content_type_id'),
                                'live_lecture_title' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('live_lecture_title')))),
                                'video_url' => $this->input->post('video_url') ? $this->input->post('video_url') : NULL,
                                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                                'by_user' => $by_user,
                                'lecture_date' =>$lecture_date,
                            'lecture_strdate' => strtotime($lecture_date)
                            ); 
                        }

                $idd = $this->Live_lecture_model->update_live_lecture($live_lecture_id,$params);
                if($idd){
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/live_lecture/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/live_lecture/edit/'.$live_lecture_id);
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
            $data['content_type_list']=$this->Content_type_masters_model->get_all_content_type_active(); 
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
            $data['_view'] = 'live_lecture/edit';
            $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

   
    /*function remove($live_lecture_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        $live_lecture = $this->Live_lecture_model->get_live_lecture($live_lecture_id);
        
        if(isset($live_lecture['live_lecture_id'])){
            $del = $this->Live_lecture_model->delete_live_lecture($live_lecture_id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            if($del){
                redirect('adminController/live_lecture/index');
            }else{
                redirect('adminController/live_lecture/index');
            }            
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/
    
}
