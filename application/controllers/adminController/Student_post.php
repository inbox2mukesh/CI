<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Student_post extends MY_Controller{
    
    function __construct(){

        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Student_post_model');
        $this->load->model('User_model');
        $this->load->model('Student_model');
        $this->load->model('Classroom_model');
    }

    function post_reply_($post_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Post Reply';
        $data['postData'] = $this->Student_post_model->getPost($post_id);
        $data['allPostReply'] = $this->Student_post_model->getPostReply($post_id);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('post_reply_text','Enter your reply','required|trim');
        
        if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
                'post_id'  => $post_id,
                'post_reply_text'  => $this->input->post('post_reply_text'),
                'post_reply_image'  => $this->input->post('post_reply_image'),                
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'by_user' => $by_user,
            );
            if(!file_exists(POST_REPLY_IMAGE_PATH)){
                mkdir(POST_REPLY_IMAGE_PATH, 0777, true);
            }
            $config['upload_path']   = POST_REPLY_IMAGE_PATH;
            $config['allowed_types'] = STUDENT_POST_ALLOWED_TYPES;
            $config['encrypt_name']  = FALSE;         
            $this->load->library('upload',$config);

                if($this->upload->do_upload("post_reply_image")){
                    $data = array('upload_data' => $this->upload->data());
                    $image= $data['upload_data']['file_name'];
                    $params = array(
                        'post_id'  => $post_id,
                        'post_reply_text'  => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('post_reply_text')))),
                        'post_reply_image'  => $image,                
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'by_user' => $by_user,
                    );                                      
                    
                }else{
                    $params = array(
                        'post_id'  => $post_id,
                        'post_reply_text'  => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('post_reply_text')))),
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'by_user' => $by_user,
                    );
                    
                }
                $idd = $this->Student_post_model->add_post_reply($params);
                $studentpostUID = $this->Student_post_model->get_studentpostUID($post_id);
               // print_r($studentpostUID);
               // die();
                if($idd){
                     //activity update start              
                 $activity_name= "Replied againist student(".$studentpostUID['UID'].") post";
                 $description= ''.json_encode($params).'';
                 $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                 //activity update end  
                    $params = array('isReplied'=>1);
                    $this->Student_post_model->update_post($post_id,$params);
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/student_post/view_student_post');
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/student_post/post_reply_/'.$post_id);
                } 
        }else{            
            $data['_view'] = 'student_post/post_reply';
            $this->load->view('layouts/main',$data);
        } 
    }

    
    function view_student_post(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}        
        //access control ends 

        //user branch   
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
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

        $data['title'] = 'All Student Posts';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/student_post/view_student_post?');
        $config['total_rows'] = $this->Student_post_model->get_all_student_post_count($rawArr);
        $this->pagination->initialize($config);        
        $data['student_post'] = $this->Student_post_model->get_all_student_post($rawArr,$params);
        $data['_view'] = 'student_post/view_student_post';
        $this->load->view('layouts/main',$data);
    }

    

    
    
}
