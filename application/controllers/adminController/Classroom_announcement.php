<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Classroom_announcement extends MY_Controller{
    
    function __construct(){
        
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login'); }
        $this->load->model('Announcements_model');
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
        $classroom_id=0;
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/classroom_announcement/index/?');
        $config['total_rows'] = $this->Announcements_model->get_all_announcements_count($rawArr,$classroom_id);
        $this->pagination->initialize($config);
        $data['title'] = 'Classroom Announcements';
        $data['announcements'] = $this->Announcements_model->get_all_announcements($rawArr,$params);
        $data['_view'] = 'classroom_announcements/index';
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

        $data['title'] = 'Add Classroom Announcement';
        $data['classroom_id'] = $classroom_id;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('classroom_id[]','Classroom','required'); 
		$this->form_validation->set_rules('subject','Announcement Subject','required|trim');
       // $this->form_validation->set_rules('body','Announcement Body','required|trim');
		
        if($this->form_validation->run()){ 

            $by_user=$_SESSION['UserId'];
            if(!file_exists(ANNOUNCEMENT_FILE_PATH)){
                mkdir(ANNOUNCEMENT_FILE_PATH, 0777, true);
            }         
            $config['upload_path']      = ANNOUNCEMENT_FILE_PATH;
            $config['allowed_types']    = WEBP_FILE_TYPES;
            $config['encrypt_name']     = FALSE;         
            $this->load->library('upload',$config);

                if($this->upload->do_upload("media_file")){
                    $data1 = array('upload_data' => $this->upload->data());
                    $image= $data1['upload_data']['file_name'];                     
                }else{                          
                    $image=NULL; 
                }
                $classroom_id=$this->input->post('classroom_id');

                    foreach ($classroom_id as $c){
                        $params = array(                
                            'classroom_id'=>$c, 
                            'subject' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('subject')))),
                            'body' => $this->input->post('body',false),                    
                            'media_file'=>$image,
                            'active'=>$this->input->post('active') ? $this->input->post('active') : 0,
                            'by_user' => $by_user,
                        );
                        $id = $this->Announcements_model->add_announcements($params);
                    }
                    
                    if($id){
                        foreach ($classroom_id as $c){
                            $classroom_name_data = $this->Classroom_model->Get_classroom_data($c);
                            $classroom_name .= $classroom_name_data['classroom_name'].', ';
                        }
                        //activity update start              
                            $activity_name= CLASSROOM_ANNOUNCEMENT_ADD;
                            $description= 'New announcement as a subject '.$params['subject'].' for classroom(s) '.$classroom_name.' added';
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        //activity update end                        
                        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                        redirect('adminController/classroom_announcement/index');
                    }else{
                        $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                        redirect('adminController/classroom_announcement/add');
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
            $data['all_trainer']=$this->User_model->get_all_trainer_active($_SESSION['roleName'],$userBranch);
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
            $data['_view'] = 'classroom_announcements/add';
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
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $data['title'] = 'Edit Classroom Announcement';
        $data['announcements'] = $this->Announcements_model->get_announcements($id);
        $classroom_id = $data['online_class_schedule']['classroom_id'];

        if(isset($data['announcements']['id'])){

            $this->load->library('form_validation');
            $this->form_validation->set_rules('classroom_id','Classroom','required|integer'); 
            $this->form_validation->set_rules('subject','Announcement Subject','required|trim');
           // $this->form_validation->set_rules('body','Announcement Body','required|trim');	

			if($this->form_validation->run()){   
                $by_user=$_SESSION['UserId'];
                $params = array(
                    'classroom_id'=>$this->input->post('classroom_id'),
					'subject' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('subject')))),
                    'body' => $this->input->post('body',false),                    
					'media_file' => $this->input->post('media_file') ? $this->input->post('media_file') : NULL,
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'by_user' => $by_user,
                );
                        if(!file_exists(ANNOUNCEMENT_FILE_PATH)){
                            mkdir(ANNOUNCEMENT_FILE_PATH, 0777, true);
                        }
                        $config['upload_path']  = ANNOUNCEMENT_FILE_PATH;
                        $config['allowed_types']= WEBP_FILE_TYPES;
                        $config['encrypt_name'] = FALSE;         
                        $this->load->library('upload',$config);

                        if($this->upload->do_upload("media_file")){
                            $data1 = array('upload_data' => $this->upload->data());
                            $image= $data1['upload_data']['file_name'];

                            unlink(ANNOUNCEMENT_FILE_PATH.$this->input->post('hid_media_file'));

                            $params = array(                    
                                'classroom_id'=>$this->input->post('classroom_id'), 
                                'subject' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('subject')))),
                                'body' => $this->input->post('body',false),                    
                                'media_file' => $image,
                                'active' => $this->input->post('active'),
                                'by_user' => $by_user,
                            );
                        }else{                            
                            $params = array(                    
                                'classroom_id'=>$this->input->post('classroom_id'),
                                'subject' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('subject')))),
                                'body' => $this->input->post('body',false),
                                'active' => $this->input->post('active'),
                                'by_user' => $by_user,
                            );
                        }

                $id = $this->Announcements_model->update_announcements($id,$params);
                if($id){  
                        $classroom_name_data1 = $this->Classroom_model->Get_classroom_data($data['announcements']['classroom_id']);
                        $classroom_name1 = $classroom_name_data1['classroom_name'];

                        $classroom_name_data2 = $this->Classroom_model->Get_classroom_data($params['classroom_id']);
                        $classroom_name2 = $classroom_name_data2['classroom_name'];

                        $oldData = 'Announcement for classroom '.$classroom_name1.' having subject '.$data['announcements']['subject'].' updated to ';

                        $newData = ''.$classroom_name2.' having subject '.$params['subject'].'';
                        //activity update start              
                            $activity_name= CLASSROOM_ANNOUNCEMENT_UPDATE;
                            $description= ''.$oldData.''.$newData.'';
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        //activity update end
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/classroom_announcement/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/classroom_announcement/edit/'.$id);
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
            $data['classroom_id']=$classroom_id2; 
            $data['_view'] = 'classroom_announcements/edit';
            $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }    

    function ajax_delete_media_file()
    {
       $id= $this->input->post('id');
       $file= $this->input->post('file');
      
        $params = array(                    
        'media_file'=>NULL       
        );
       $res = $this->Announcements_model->update_announcements($id,$params);
       if($res)
       {
       unlink($file);

       }
       echo $res;
    }

    /*function remove($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        $announcements = $this->Announcements_model->get_announcements($id);
        if(isset($announcements['id']))
        {
            $del = $this->Announcements_model->delete_announcements($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            if($del){
                redirect('adminController/classroom_announcement/index');
            }else{
                redirect('adminController/classroom_announcement/index');
            }
            
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/
    
}
