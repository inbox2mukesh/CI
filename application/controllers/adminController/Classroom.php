<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Classroom extends MY_Controller{
    
    function __construct(){
        
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Test_module_model');   
        $this->load->model('Programe_master_model'); 
        $this->load->model('Batch_master_model');
        $this->load->model('Classroom_model');
        $this->load->model('Category_master_model');
        $this->load->model('Center_location_model');  
        $this->load->model('User_model');
    }

    /*function add(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control end

        $data['title'] = 'Add new classroom';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('classroom_name','Classroom name','required|trim|is_unique[classroom.classroom_name]');        
        $this->form_validation->set_rules('test_module_id','Course','required|integer');
        $this->form_validation->set_rules('programe_id','Programe','required|integer');
        $this->form_validation->set_rules('category_id[]','Category','required'); 
        $this->form_validation->set_rules('batch_id[]','Batch','required');           
        $this->form_validation->set_rules('center_id','Branch','required|integer');         
        
        $data['all_programe_masters'] = $this->Category_master_model->getProgramByCourse($this->input->post('test_module_id'));
        $data['all_category'] = $this->Category_master_model->get_category_forPack($this->input->post('test_module_id'),$this->input->post('programe_id'));
        $by_user= $_SESSION['UserId'];

        if($this->form_validation->run()){              
            
            $category_id = $this->input->post('category_id');
            sort($category_id, SORT_NUMERIC);
            $category_ids = implode(',', $category_id);
            $batch_id = $this->input->post('batch_id');            
            
            foreach($batch_id as $btc){
                $classroom_name =  trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('classroom_name')))).rand(1000,99999);
                $params = array(
                    'classroom_name' => $classroom_name,
                    'test_module_id' => $this->input->post('test_module_id'),
                    'programe_id' => $this->input->post('programe_id'),
                    'batch_id' => $btc,                
                    'category_id' => $category_ids ? $category_ids : NULL,
                    'center_id'=> $this->input->post('center_id'),
                    'active' => $this->input->post('active'),
                    'by_user' => $by_user,
                );
                $dup = $this->Classroom_model->dupliacte_classroom($params['classroom_name'],$params['test_module_id'],$params['programe_id'],$params['category_id'],$btc,$params['center_id']);
            
                if($dup==2){
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);
                    redirect('adminController/classroom/add');
                }else{
                    $idd = $this->Classroom_model->add_classroom($params);
                }
            }        
           
            if($idd){
                //activity update start              
                    $activity_name= CLASSROOM_ADD;
                    $description= 'New classroom '.$params['classroom_name'].' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/classroom/index');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/classroom/add');
            }  

        }else{
            $pattern = "/Trainer/i";
            $isTrainer = preg_match($pattern, $_SESSION['roleName']);
            
            if($isTrainer){
                $userCourseAccess=[];$userBranch=[];$userBatch=[];$FunctionalCoursesList=[];  
                $userCourseAccess=$this->Test_module_model->getFunctionalCourses($by_user);
                foreach ($userCourseAccess as $u) {
                    array_push($FunctionalCoursesList,$u['test_module_id']);
                }                

                $UserFunctionalBranch=$this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
                foreach ($UserFunctionalBranch as $b){            
                    array_push($userBranch,$b['center_id']);
                }

                $UserFunctionalBatch=$this->User_model->getUserFunctionalBatch($_SESSION['UserId']);
                foreach($UserFunctionalBatch as $b){                    
                    array_push($userBatch,$b['batch_id']);
                }
                $data['all_test_module'] = $this->Test_module_model->getFunctionalCoursesList($FunctionalCoursesList);
                $data['all_batches']=$this->Batch_master_model->getFunctionalBatch($userBatch);
                $data['all_branch']=$this->Center_location_model->getFunctionalBranch($userBranch);
            }else{
                $data['all_test_module']= $this->Test_module_model->get_all_test_module_active();
                $data['all_programe_masters']=$this->Programe_master_model->get_all_programe_masters_active();
                $data['all_batches'] = $this->Batch_master_model->get_all_batch_active();
                $data['all_branch'] = $this->Center_location_model->getAcademyBranch();
            }             
            $data['_view'] = 'classroom/add';
            $this->load->view('layouts/main',$data);
        }
    }*/
    
    function edit($id){ 

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control end
        $data['title'] = 'Edit classroom';
        $data['classroom'] = $this->Classroom_model->get_classroom($id);
        //print_r($data['classroom']);
        if(isset($data['classroom']['id'])){
            $this->load->library('form_validation');
            $data['prev_category1'] = $this->Classroom_model->get_prev_category($id);
            $data['prev_category2'] = explode(',', $data['prev_category1']['category_id']);
            $data['prev_category'] = $this->Category_master_model->get_category_arr($data['prev_category2']);
            $data['all_category'] = $this->Category_master_model->get_category_forPack($data['classroom']['test_module_id'],$data['classroom']['programe_id']);
            $data['all_programe_masters'] = $this->Category_master_model->getProgramByCourse($data['classroom']['test_module_id']);
            $by_user= $_SESSION['UserId'];

            $this->form_validation->set_rules('classroom_name','Classroom name','required|trim');
            /*$this->form_validation->set_rules('test_module_id','Course','required|integer');
            $this->form_validation->set_rules('programe_id','Programe','required|integer');
            $this->form_validation->set_rules('category_id[]','Category','required'); 
            $this->form_validation->set_rules('batch_id[]','Batch','required');           
            $this->form_validation->set_rules('center_id','Branch','required|integer');*/ 
        
            if($this->form_validation->run()){

                $category_id = $this->input->post('category_id');
                sort($category_id, SORT_NUMERIC);
                $category_ids = implode(',', $category_id);

                $params = array(
                    'classroom_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('classroom_name')))),
                    /*'test_module_id' => $this->input->post('test_module_id'),
                    'programe_id' => $this->input->post('programe_id'),
                    'batch_id' => $this->input->post('batch_id'),                
                    'category_id' => $category_ids ? $category_ids : NULL,
                    'center_id'=> $this->input->post('center_id'),*/
                    'active' => $this->input->post('active'),
                    'by_user' => $by_user,
                );
                $id = $this->Classroom_model->update_classroom($id,$params);
                if($id){
                    /*$getTestName = $this->Test_module_model->getTestName($data['classroom']['test_module_id']);
                    $test_module_name1 = $getTestName['test_module_name'];

                    $getProgramName = $this->Programe_master_model->getProgramName($data['classroom']['programe_id']);
                    $programe_name1 = $getProgramName['programe_name'];

                    $get_centerName = $this->Center_location_model->get_centerName($data['classroom']['center_id']);
                    $center_name1 = $get_centerName['center_name'];

                    $getBatchName = $this->Batch_master_model->getBatchName($data['classroom']['batch_id']);
                    $batch_name1 = $getBatchName['batch_name']; */                   
                    $oldData = ''.$data['classroom']['classroom_name'].' with updated to ';

                   /* $getTestName2 = $this->Test_module_model->getTestName($params['test_module_id']);
                    $test_module_name2 = $getTestName2['test_module_name'];

                    $getProgramName2 = $this->Programe_master_model->getProgramName($params['programe_id']);
                    $programe_name2 = $getProgramName2['programe_name'];

                    $get_centerName2 = $this->Center_location_model->get_centerName($params['center_id']);
                    $center_name2 = $get_centerName2['center_name'];

                    $getBatchName2 = $this->Batch_master_model->getBatchName($params['batch_id']);
                    $batch_name2 = $getBatchName2['batch_name'];*/                    
                    $newData = $params['classroom_name'];
                    //activity update start              
                        $activity_name= CLASSROOM_UPDATE;
                        $description= ''.$oldData.''.$newData.'';
                        $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);
                    redirect('adminController/classroom/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/classroom/edit/'.$id);
                } 

            }else{                
                $pattern = "/Trainer/i";
                $isTrainer = preg_match($pattern, $_SESSION['roleName']);
                
                if($isTrainer){
                    $userCourseAccess=[];$userBranch=[];$userBatch=[];$FunctionalCoursesList=[];  
                $userCourseAccess=$this->Test_module_model->getFunctionalCourses($by_user);
                foreach ($userCourseAccess as $u) {
                    array_push($FunctionalCoursesList,$u['test_module_id']);
                }
                $data['all_test_module'] = $this->Test_module_model->getFunctionalCoursesList($FunctionalCoursesList);
                $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);        
                foreach ($UserFunctionalBranch as $b){            
                    array_push($userBranch,$b['center_id']);
                }
                $UserFunctionalBatch=$this->User_model->getUserFunctionalBatch($_SESSION['UserId']);        
                foreach($UserFunctionalBatch as $b){                    
                    array_push($userBatch,$b['batch_id']);
                }
                $data['all_batches']=$this->Batch_master_model->getFunctionalBatch($userBatch);
                $data['all_branch']=$this->Center_location_model->getFunctionalBranch($userBranch);
                }else{
                    $data['all_test_module']= $this->Test_module_model->get_all_test_module_active();
                    $data['all_programe_masters']=$this->Programe_master_model->get_all_programe_masters_active();
                    $data['all_batches'] = $this->Batch_master_model->get_all_batch_active();
                    $data['all_branch'] = $this->Center_location_model->getAcademyBranch($_SESSION['roleName'],$userBranch);
                }                              
                $data['_view'] = 'classroom/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    } 

    function index(){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $data['title'] = 'Classrooms';
        $userBranch=[];
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }
        
        $UserAccessAsTrainer = $this->User_model->getUserAccessAsTrainer($_SESSION['UserId']);
        $classroomData2 = [];
        if(!empty($UserAccessAsTrainer)){
            foreach ($UserAccessAsTrainer as $u) {
               $classroomData1 = $this->Classroom_model->get_classroom_by_access($u['test_module_id'],$u['programe_id'],$u['category_id'],$u['batch_id'],$u['center_id'],$params);
               if(!empty($classroomData1)){
                array_push($classroomData2, $classroomData1);
               }           
            }
        }else{
            $classroomData2 = $this->Classroom_model->get_all_classroom($_SESSION['roleName'],$userBranch,$params);                     
        }
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset']= ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/classroom/index/?'); 
        $config['total_rows']=count($classroomData2);      
        $this->pagination->initialize($config);        

        $UserAccessAsTrainer = $this->User_model->getUserAccessAsTrainer($_SESSION['UserId']);
        $classroomData2 = [];
        if(!empty($UserAccessAsTrainer)){
            foreach ($UserAccessAsTrainer as $u) {
               $classroomData1 = $this->Classroom_model->get_classroom_by_access($u['test_module_id'],$u['programe_id'],$u['category_id'],$u['batch_id'],$u['center_id'],$params);
               if(!empty($classroomData1)){
                array_push($classroomData2, $classroomData1);
               }           
            }
        }else{
            $classroomData2 = $this->Classroom_model->get_all_classroom($_SESSION['roleName'],$userBranch,$params);                     
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
        $data['classroom']=$classroomData2;
        $data['all_test_module'] = $this->Test_module_model->get_all_test_module_active();
        $data['all_batches'] = $this->Batch_master_model->get_all_batch_active();
        $data['all_branch'] = $this->Center_location_model->getAcademyBranch($_SESSION['roleName'],$userBranch);
        $data['_view'] = 'classroom/index';
        $this->load->view('layouts/main',$data);
    } 

    function ajax_show_classroom_desc(){ 
         
        $classroomname = $this->input->post('classroomname');
        $classroom_id =  $this->input->post('classroom_id');    
        $response= $this->Classroom_model->show_classroom_desc($classroom_id);
        $category_id = $response['category_id'];

            $pattern = "/,/i";
            $isMultipeCategory = preg_match($pattern, $category_id);
            if($isMultipeCategory){               
                $cat_arr = explode(',', $category_id);
                $cat_arr_count = count($cat_arr);
                for ($i=0; $i < $cat_arr_count; $i++) { 
                    $get_category_name = $this->Category_master_model->get_category_name($cat_arr[$i]);
                    $catName .= $get_category_name['category_name'].', ';                    
                }
            }else{               
                $get_category_name = $this->Category_master_model->get_category_name($category_id);
                foreach ($get_category_name as $m) {                
                        $catName = $m;                       
                }
            }

        $res="";
        $res.=$response['test_module_name'].' | '.$response['programe_name'];
        if($catName)
        {
        $res.=' | '.rtrim($catName,', ');
        }
        $res.=' | '.$response['batch_name'];
        echo $res;        
    }

    function ajax_loadClassroom(){        
       
        $test_module_id = $this->input->post('test_module_id');
        $programe_id = $this->input->post('programe_id');
        
        $category_id = $this->input->post('category_id');
        sort($category_id, SORT_NUMERIC);
        $category_id = implode(',', $category_id);

        $batch_id = $this->input->post('batch_id');
        $center_id = $this->input->post('center_id');
        
        $role_id= $_SESSION['roleId'];
        $role_name= $_SESSION['roleName'];
        if($role_name != ADMIN){
            $UserFunctionalBranch=$this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
            $userBranch=[];
            foreach ($UserFunctionalBranch as $b){
                array_push($userBranch,$b['center_id']);
            }
        }else{
            $userBranch=[];
        }

        //$response= $this->Classroom_model->loadClassroom($test_module_id,$programe_id,$category_id,$batch_id,$center_id,$userBranch);
        //echo json_encode($response);

        $classroomData2= $this->Classroom_model->loadClassroom($test_module_id,$programe_id,$category_id,$batch_id,$center_id,$userBranch);
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
        echo json_encode($classroomData2);
    }

    function ajax_loadClassroom2(){        
       
        $test_module_id = $this->input->post('test_module_id');
        $programe_id = $this->input->post('programe_id');
        
        $category_id = $this->input->post('category_id');
        sort($category_id, SORT_NUMERIC);
        $category_id = implode(',', $category_id);

        $batch_id = $this->input->post('batch_id');
        $center_id = $this->input->post('center_id');
       
        $role_id= $_SESSION['roleId'];
        $role_name= $_SESSION['roleName'];
        if($role_name != ADMIN){
            $UserFunctionalBranch=$this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
            $userBranch=[];
            foreach ($UserFunctionalBranch as $b){
                array_push($userBranch,$b['center_id']);
            }
        }else{
            $userBranch=[];
        }             
        $classroomData2= $this->Classroom_model->loadClassroom2($test_module_id,$programe_id,$category_id,$batch_id,$center_id,$userBranch);
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
        echo json_encode($classroomData2);
    }  
     

    function classroom_students_($classroom_id){        
       
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends

        $data['title'] = 'Classroom Students';     
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/classroom/classroom_students/?');
        $config['total_rows']=$this->Classroom_model->classroom_student_count($classroom_id);
        $this->pagination->initialize($config);        
        $data['classroom_students']=$this->Classroom_model->classroomStudent($classroom_id,$params);
        $data['_view'] = 'classroom/classroom_students';
        $this->load->view('layouts/main',$data);
    } 

    function classroom_docs_($classroom_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends

        $data['title'] = 'Classroom Documents';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url']=site_url('adminController/classroom/classroom_docs_/'.$classroom_id.'/?');
        $config['total_rows']= $this->Classroom_model->classroom_docs_count($classroom_id);
        $this->pagination->initialize($config);        
        $data['classroom_docs']=$this->Classroom_model->classroomDocs($classroom_id,$params);
        foreach($data['classroom_docs']  as $key=>$classroom_documents){
			
			$data['classroom_docs'][$key]['classroom_documents_content_type']=$this->Classroom_model->getContentTypeByClassroomDocumentsId($classroom_documents['id']);
		}        
        $data['_view'] = 'classroom/classroom_docs';
        $this->load->view('layouts/main',$data);
    }

    function classroom_lecture_($classroom_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $data['title'] = 'Classroom- Lectures';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/classroom/classroom_lecture_/'.$classroom_id.'/?');
        $config['total_rows'] = $this->Classroom_model->classroom_live_lectures_count($classroom_id);
        $this->pagination->initialize($config);        
        $data['classroom_lecture']=$this->Classroom_model->classroomLectures($classroom_id,$params);
        $data['_view'] = 'classroom/classroom_lecture';
        $this->load->view('layouts/main',$data);        
    }

    function classroom_post_($classroom_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $data['title'] = 'All Student Posts';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/classroom/classroom_post/?');
        $config['total_rows'] = $this->Classroom_model->classroom_post_count($classroom_id);
        $this->pagination->initialize($config);        
        $data['classroom_post']=$this->Classroom_model->ClassroomPost($classroom_id,$params);      
        $data['_view'] = 'classroom/classroom_post';
        $this->load->view('layouts/main',$data);        
    }

    function classroom_announcements_($classroom_id){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $data['title'] = 'Classroom Announcements';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/classroom/classroom_announcements_/'.$classroom_id.'/'.'?');
        $config['total_rows']=$this->Classroom_model->classroom_announcements_count($classroom_id);
        $this->pagination->initialize($config);      
        $data['classroom_announcements'] = $this->Classroom_model->classroomAnnouncements($classroom_id,$params);      
        $data['_view'] = 'classroom/classroom_announcements';
        $this->load->view('layouts/main',$data);
    } 

    function ajax_validate_classroom_name(){

        $classroom_name = $this->input->post('classroom_name'); 
        $classroom_id = $this->input->post('classroom_id');  
        if($classroom_id and $classroom_name) {
            echo $response= $this->Classroom_model->check_classroom_name_duplicacy2($classroom_name,$classroom_id);
        }else{
            echo $response= $this->Classroom_model->check_classroom_name_duplicacy($classroom_name); 
        }        
    } 
    
    /*function remove($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $classroom = $this->Classroom_model->get_classroom($id);
        if(isset($classroom['id']))
        {
            $del = $this->Classroom_model->delete_classroom($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            if($del){
                redirect('adminController/classroom/index');
            }else{
                redirect('adminController/classroom/index');
            }            
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/   
    
}
