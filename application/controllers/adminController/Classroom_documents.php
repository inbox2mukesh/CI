<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Neelu
 *
 **/
class Classroom_documents extends MY_Controller{
	
    function __construct(){

        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
		
		$this->load->model('Classroom_documents_modal');
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
        $config['base_url'] = site_url('adminController/classroom_documents/index?');
        $config['total_rows'] = $this->Classroom_documents_modal->get_all_classroom_documents_count($rawArr);
        $this->pagination->initialize($config);
        $data['title'] = 'Classroom Documents';
      
        $data['classroom_documents'] = $this->Classroom_documents_modal->get_all_classroom_documents($rawArr,$params);		
	    foreach($data['classroom_documents']  as $key=>$classroom_documents){			
			$data['classroom_documents'][$key]['classroom_documents_content_type']=$this->Classroom_documents_modal->getContentTypeByClassroomDocumentsId($classroom_documents['id']);
		}
        $data['_view'] = 'classroom_documents/index';
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
		
        $data['title'] = 'Add classroom document';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title','title','required|trim');
		$this->form_validation->set_rules('classroom_id[]','classroom','required');
		$this->form_validation->set_rules('content_type_id[]','content type','required');

		if($this->form_validation->run()){

            $by_user=$_SESSION['UserId'];
			$total_section=$this->input->post('total_section');
            $params = array(
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'total_section' => $total_section,
                'by_user' => $by_user,
				'title' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('title')))),
            );			
            $classroom_ids = $this->input->post('classroom_id');
			$content_type_ids = $this->input->post('content_type_id');
            $id = $this->Classroom_documents_modal->add_classroom_documents($params);
			
            if($id){				
				$classroom_documents_id=$id;
				foreach ($classroom_ids as $classroom_id) {                  
                    $params=array(
                        'classroom_id' =>$classroom_id,
                        'classroom_documents_id'=>$classroom_documents_id,
                        'by_user'  => $by_user,
                    );
                    $this->Classroom_documents_modal->add_classroom_documents_class($params);
                }
				
				foreach ($content_type_ids as $content_type_id) {                  
                    $params=array(
                        'content_type_id' =>$content_type_id,
                        'classroom_documents_id'=>$classroom_documents_id,
                        'by_user'  => $by_user,
                    );
                    $this->Classroom_documents_modal->add_classroom_documents_content_type($params);
                }				
				if($total_section > 0){					 
						$j=1;
						for($i=1; $i<=$total_section; $i++){
							
							$section_no=$this->input->post('section_no'.$i);
							$section_type=$this->input->post('section_type'.$i);
							if(!empty($section_no)){
								
								if($section_type=='text'){									
									$section=$this->input->post('classroom_documents_section'.$i,false);
									//$section=$_POST['classroom_documents_section'.$i];
									
								}else if($section_type=='image'){
									if(!file_exists(CLASSROOM_DOCUMENTS_IMAGE_PATH)){
                                        mkdir(CLASSROOM_DOCUMENTS_IMAGE_PATH, 0777, true);
                                    }
									$config['upload_path']   = CLASSROOM_DOCUMENTS_IMAGE_PATH;
									$config['allowed_types'] = WEBP_FILE_TYPES;
									$config['encrypt_name']  = FALSE;
									$this->load->library('upload',$config);
									$this->upload->initialize($config);
									$section='';
									
									if($this->upload->do_upload('classroom_documents_section'.$i)){
									    $data = array('upload_data' => $this->upload->data());
									    $section= $data['upload_data']['file_name'];                
									}
								}else if($section_type=='video'){
									if(!file_exists(CLASSROOM_DOCUMENTS_VIDEO_PATH)){
                                        mkdir(CLASSROOM_DOCUMENTS_VIDEO_PATH, 0777, true);
                                    }
									$config['upload_path']   = CLASSROOM_DOCUMENTS_VIDEO_PATH;
									$config['allowed_types'] = CLASSROOM_DOCUMENTS_VIDEO_TYPES;
									$config['encrypt_name'] = FALSE;
									
									$this->load->library('upload',$config);
									$this->upload->initialize($config);
									$section='';
									
									if($this->upload->do_upload('classroom_documents_section'.$i)){
									    $data = array('upload_data' => $this->upload->data());
									    $section= $data['upload_data']['file_name'];                
									}else{										
										//echo $this->upload->display_errors();	
									}
								}else if($section_type=='audio'){
									if(!file_exists(CLASSROOM_DOCUMENTS_AUDIO_PATH)){
                                        mkdir(CLASSROOM_DOCUMENTS_AUDIO_PATH, 0777, true);
                                    }
                                   
									$config['upload_path']   = CLASSROOM_DOCUMENTS_AUDIO_PATH;
									$config['allowed_types'] = CLASSROOM_DOCUMENTS_AUDIO_TYPES;
									$config['encrypt_name']  = FALSE;
									$this->load->library('upload',$config);
									$this->upload->initialize($config);
									$section='';
									
									if($this->upload->do_upload('classroom_documents_section'.$i)){	
									    $data = array('upload_data' => $this->upload->data());
									    $section= $data['upload_data']['file_name'];                
									}
                                    else{	
                                      
									}
								}
								
							    $classroom_documents_section_array[]=array(
									'section' =>  $section,
									'classroom_documents_id'=>$classroom_documents_id,
									'section_number'=>$section_no,
									'type'=>$section_type,
									'by_user'  => $by_user,
							    );
							}
						} 
						$this->Classroom_documents_modal->add_classroom_documents_section($classroom_documents_id,$classroom_documents_section_array);
				}
                
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/classroom_documents/index');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
            redirect('adminController/classroom_documents/add');
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
			$data['content_type_list']=$this->Content_type_masters_model->get_all_content_type_active();
			$data['classroom_id']=$classroom_id2;
            $data['_view'] = 'classroom_documents/add';
            $this->load->view('layouts/main',$data);
        }
    }
	
    function edit($id=null){  

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
            $rawArr = [];
	        foreach ($classroomData2 as $c) {
	            array_push($rawArr, $c['id']);
	        }        
            $data['all_classroom']=$classroomData2;		
        	$data['title'] = 'Edit Classroom Documents';
        	$data['classroom_documents'] = $this->Classroom_documents_modal->get_classroom_documents($id);
	        if(isset($data['classroom_documents']['id'])){   

	            $this->load->library('form_validation');
				$this->form_validation->set_rules('title','title','required|trim');
				$data['classroom_documents_class']=$this->Classroom_documents_modal->getClassByClassroomDocumentsId($rawArr,$id);				
				$data['classroom_documents_section_list']=$this->Classroom_documents_modal->getSectionByClassroomDocumentsId($id);				
				$data['classroom_documents_content_type']=$this->Classroom_documents_modal->getContentTypeByClassroomDocumentsId($id);			
				if(empty($data['classroom_documents_class'])){					
					$this->form_validation->set_rules('classroom_id[]','classroom','required|trim');
				}
				if(empty($data['classroom_documents_content_type'])){					
					$this->form_validation->set_rules('content_type_id[]','content type','required|trim');
				}

				if($this->form_validation->run()){

	                $by_user=$_SESSION['UserId'];					
					$total_section=$this->input->post('total_section');
					$params = array(
						'active' => $this->input->post('active') ? $this->input->post('active') : 0,
						'total_section' => $total_section,
						'by_user' => $by_user,
						'title' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('title')))),
					);			
	                $classroom_ids = $this->input->post('classroom_id');
				    $content_type_ids = $this->input->post('content_type_id');
					$classroom_documents_id=$id;
	                $id = $this->Classroom_documents_modal->update_classroom_documents($id,$params);
	                if($id){
						if(!empty($classroom_ids)){
							
							foreach ($classroom_ids as $classroom_id) {                  
								$params=array(
									'classroom_id' =>$classroom_id,
									'classroom_documents_id'=>$classroom_documents_id,
									'by_user'  => $by_user,
								);
								$this->Classroom_documents_modal->add_classroom_documents_class($params);
							}
						}
						
						if(!empty($content_type_ids)){
							
							foreach ($content_type_ids as $content_type_id) {                  
							$params=array(
								'content_type_id' =>$content_type_id,
								'classroom_documents_id'=>$classroom_documents_id,
								'by_user'  => $by_user,
							);
							$this->Classroom_documents_modal->add_classroom_documents_content_type($params);
							}	
						}
						if($total_section > 0){
							$j=1;
							for($i=1; $i<=$total_section; $i++){
								
								$section_no=$this->input->post('section_no'.$i);
								$section_type=$this->input->post('section_type'.$i);
								$old_section=$this->input->post('old_section'.$i);
								if(!empty($section_no)){
									
									if($section_type=='text'){
										$section=$this->input->post('classroom_documents_section'.$i,false);
									}else if($section_type=='image'){
                                        
										if(!file_exists(CLASSROOM_DOCUMENTS_IMAGE_PATH)){
                                            mkdir(CLASSROOM_DOCUMENTS_IMAGE_PATH, 0777, true);
                                        }
										$config['upload_path']   = CLASSROOM_DOCUMENTS_IMAGE_PATH;
										$config['allowed_types'] = WEBP_FILE_TYPES;
										$config['encrypt_name']  = FALSE;
                                        $this->upload->initialize($config);
										$this->load->library('upload',$config);
										$section=$old_section;
										
										if($this->upload->do_upload('classroom_documents_section'.$i)){	
										    $data = array('upload_data' => $this->upload->data());
										    $section= $data['upload_data']['file_name'];                
										}else{										
											$this->upload->display_errors();
										}
									}else if($section_type=='video'){
										if(!file_exists(CLASSROOM_DOCUMENTS_VIDEO_PATH)){
                                            mkdir(CLASSROOM_DOCUMENTS_VIDEO_PATH, 0777, true);
                                        }
										$config['upload_path']   = CLASSROOM_DOCUMENTS_VIDEO_PATH;
										$config['allowed_types'] = CLASSROOM_DOCUMENTS_VIDEO_TYPES;
										$config['encrypt_name'] = FALSE;
										
										$this->load->library('upload',$config);
										$this->upload->initialize($config);
										$section=$old_section;
										
										if($this->upload->do_upload('classroom_documents_section'.$i)){	
										    $data = array('upload_data' => $this->upload->data());
										    $section= $data['upload_data']['file_name'];                
										}else{										
											//echo $this->upload->display_errors();
										}
									}else if($section_type=='audio'){
										if(!file_exists(CLASSROOM_DOCUMENTS_AUDIO_PATH)){
                                            mkdir(CLASSROOM_DOCUMENTS_AUDIO_PATH, 0777, true);
                                        }
										$config['upload_path'] = CLASSROOM_DOCUMENTS_AUDIO_PATH;
										$config['allowed_types'] = CLASSROOM_DOCUMENTS_AUDIO_TYPES;
										$config['encrypt_name']  = FALSE;
										$this->load->library('upload',$config);		
										$this->upload->initialize($config);								
										$section=$old_section;
										
										if($this->upload->do_upload('classroom_documents_section'.$i)){	
										    $data = array('upload_data' => $this->upload->data());
										    $section= $data['upload_data']['file_name'];                
										}else{										
											//echo $this->upload->display_errors();
										}
									}
									
								    $classroom_documents_section_array[]=array(
										'section' =>  $section,
										'classroom_documents_id'=>$classroom_documents_id,
										'section_number'=>$section_no,
										'type'=>$section_type,
										'by_user'  => $by_user,
								    );
								}
							}
	                        //pr($classroom_documents_section_array,1);						
							$this->Classroom_documents_modal->add_classroom_documents_section($classroom_documents_id,$classroom_documents_section_array,$classroom_documents_id);						
					    }
	                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
	                    redirect('adminController/classroom_documents/index');
	                }else{
	                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
	                    redirect('adminController/classroom_documents/edit/'.$id);
	                }

	            }else{			 
					$data['content_type_list']=$this->Content_type_masters_model->get_all_content_type_active();
	            	$data['_view'] = 'classroom_documents/edit';
	            	$this->load->view('layouts/main',$data);				
	            }
	        }
	        else
	            show_error(ITEM_NOT_EXIST);
    }
	
	
	function view_document_details_($id){
		
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
            $rawArr = [];
	        foreach ($classroomData2 as $c) {
	            array_push($rawArr, $c['id']);
	        }        
        //$data['all_classroom']=$classroomData2;	
		$data['title'] ='Classroom Documents Details';
		$data['classroom_documents']=$this->Classroom_documents_modal->getClassroomDocumentsById($id);
		$data['classroom_documents_class']=$this->Classroom_documents_modal->getClassByClassroomDocumentsId($rawArr,$id);
		$data['classroom_documents_content_type']=$this->Classroom_documents_modal->getContentTypeByClassroomDocumentsId($id);		
		$data['classroom_documents_section_list']=$this->Classroom_documents_modal->getSectionByClassroomDocumentsId($id);
		$data['_view'] = 'classroom_documents/view';
		$this->load->view('layouts/main',$data);		
	}

    /*function remove($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $classroom_documents = $this->Classroom_documents_modal->get_Classroom_documents($id);
        if(isset($classroom_documents['id']))
        {
            $this->Classroom_documents_modal->delete_Classroom_documents($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/classroom_documents/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/
	
    function ajax_delete_classroom_documents_class(){
        
        $classroom_documents_id = $this->input->post('classroom_documents_id', true);
        $classroom_id = $this->input->post('classroom_id', true);
        if($classroom_id!=''){
			
            $del = $this->Classroom_documents_modal->delete_classroom_documents_class($classroom_documents_id,$classroom_id);
            if($del){  
                header('Content-Type: application/json');
                $response = 1;
                echo json_encode($response);
            }else{ 
                header('Content-Type: application/json');
                $response = 0;
                echo json_encode($response);
            }
        }else{
            header('Content-Type: application/json');
            $response = 0;
            echo json_encode($response);
        }         
    }
	 function ajax_delete_classroom_documents_content_type(){
        
        $classroom_documents_id = $this->input->post('classroom_documents_id', true);
        $content_type_id = $this->input->post('content_type_id', true);
        if($content_type_id!=''){
			
            $del = $this->Classroom_documents_modal->delete_classroom_documents_content_type($classroom_documents_id,$content_type_id);
            if($del){  
                header('Content-Type: application/json');
                $response = 1;
                echo json_encode($response);
            }else{ 
                header('Content-Type: application/json');
                $response = 0;
                echo json_encode($response);
            }
        }else{
            header('Content-Type: application/json');
            $response = 0;
            echo json_encode($response);
        }         
    }
	
}
