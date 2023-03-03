<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..COPY OF FREE-RESOURSE
 * @author          Navjeet
 *
 **/
class Test_preparation_material extends MY_Controller{
	
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Test_preparation_material_model');
		$this->load->model('Test_module_model');
		$this->load->model('Content_type_masters_model');
		$this->load->model('Test_preparation_material_topic_model');
		
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
        $config['base_url'] = site_url('adminController/test_preparation_material/index?');
        $config['total_rows'] = $this->Test_preparation_material_model->get_all_free_resources_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Test Preparation Material';
        $data['free_resources'] = $this->Test_preparation_material_model->get_all_free_resources($params);	
		foreach($data['free_resources']  as $key=>$free_resources)
		{
			$data['free_resources'][$key]['free_resources_test_list']=$this->Test_preparation_material_model->getTestByFreeResourcesId($free_resources['id']);			
		}		
        $data['_view'] = 'test_preparation_material/index';
        $this->load->view('layouts/main',$data);	
    }

    function add()
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['title'] = 'Add Test Preparation Material';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('content_type_id','content type','required|trim');
        $this->form_validation->set_rules('title','title','required|trim');
		$this->form_validation->set_rules('free_resources_topic[]','test type','required|trim');
		$this->form_validation->set_rules('description','description','required|trim');
		$this->form_validation->set_rules('URLslug','URL slug','required|trim');
		if (empty($_FILES['image']['name']))
		{
			$this->form_validation->set_rules('image', 'image', 'required');
		}
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
			$total_section=$this->input->post('total_section');
			if(!file_exists(TEST_PREPARATION_IMAGE_PATH)){
                mkdir(TEST_PREPARATION_IMAGE_PATH, 0777, true);
            }
			$config['upload_path']   = TEST_PREPARATION_IMAGE_PATH;
            $config['allowed_types'] = WEBP_FILE_TYPES;
            $config['encrypt_name']  = FALSE;
            $this->load->library('upload',$config);
			
			
			if($this->upload->do_upload("image")){
				
                $data = array('upload_data' => $this->upload->data());
                $image= $data['upload_data']['file_name'];                
            }else{
                $image='';               
            }
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'isPinned' => $this->input->post('isPinned') ? $this->input->post('isPinned') : 0,              
                'total_section' => $total_section,
                'by_user' => $by_user,
				'content_type_id' => $this->input->post('content_type_id'),
				'title' => $this->input->post('title'),
				'description'=>$this->input->post('description',false),
				'URLslug'=>$this->input->post('URLslug'),
				'image'=>$image
            );
			
            $free_resources_topic = $this->input->post('free_resources_topic');
            $id = $this->Test_preparation_material_model->add_free_resources($params);
			
            if($id){
				
				$free_resources_id=$id;
				$created=$modified=date('Y-m-d H:i:s');
				foreach ($free_resources_topic as $topic_id) {                  
                    $params=array(
                        'topic_id' =>$topic_id,
                        'test_preparation_material_id'=> $free_resources_id,
                        'by_user'  => $by_user,
						'created'  => $created,
						'modified'  => $modified,
                    );
                   $this->Test_preparation_material_model->add_free_resources_test($params);
                }

				//die();
				if($total_section > 0){
					 
						$j=1;
						for($i=1; $i<=$total_section; $i++){
							
							
							
							$section_no=$this->input->post('section_no'.$i);
							$section_type=$this->input->post('section_type'.$i);
							if(!empty($section_no)){
								
								if($section_type=='text'){
									
									//$section=$this->input->post('free_resources_section'.$i);
									$section=$_POST['free_resources_section'.$i];
									
								}else if($section_type=='image'){
									$this->upload->initialize($config);
									if(!file_exists(TEST_PREPARATION_IMAGE_PATH)){
						                mkdir(TEST_PREPARATION_IMAGE_PATH, 0777, true);
						            }
									$config['upload_path']   = TEST_PREPARATION_IMAGE_PATH;
									$config['allowed_types'] = WEBP_FILE_TYPES;
									$config['encrypt_name']  = FALSE;
									$this->load->library('upload',$config);
									$this->upload->initialize($config);
									$section='';
									
									if($this->upload->do_upload('free_resources_section'.$i)){
										
									    $data = array('upload_data' => $this->upload->data());
									    $section= $data['upload_data']['file_name'];                
									}
								}else if($section_type=='video'){
									if(!file_exists(TEST_PREPARATION_VIDEO_PATH)){
						                mkdir(TEST_PREPARATION_VIDEO_PATH, 0777, true);
						            }
									$config['upload_path']   = TEST_PREPARATION_VIDEO_PATH;
									$config['allowed_types'] = FREE_RESOURCES_VIDEO_TYPES;
									$config['encrypt_name'] = FALSE;
									
									$this->load->library('upload',$config);
									$this->upload->initialize($config);
									$section='';
									
									if($this->upload->do_upload('free_resources_section'.$i)){
										
									    $data = array('upload_data' => $this->upload->data());
									    $section= $data['upload_data']['file_name'];                
									}else{
										
										//echo $this->upload->display_errors();
										
									}
								}else if($section_type=='audio'){
									if(!file_exists(TEST_PREPARATION_AUDIO_PATH)){
						                mkdir(TEST_PREPARATION_AUDIO_PATH, 0777, true);
						            }
									$config['upload_path']   = TEST_PREPARATION_AUDIO_PATH;
									$config['allowed_types'] = '*';
									$config['encrypt_name']  = FALSE;
									$this->load->library('upload',$config);
									$this->upload->initialize($config);
									$section='';
									
									if($this->upload->do_upload('free_resources_section'.$i)){
									    $data = array('upload_data' => $this->upload->data());
									    $section= $data['upload_data']['file_name'];                
									}
								}
								
							    $free_resources_section_array[]=array(
								'section' =>  $section,
								'test_preparation_material_id'=>$free_resources_id,
								'section_number'=>$section_no,
								'type'=>$section_type,
								'by_user'  => $by_user,
								'created'  => $created,
								'modified' => $modified
							    );
							}
						} 
						$this->Test_preparation_material_model->add_free_resources_section($free_resources_id,$free_resources_section_array);
				}
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/test_preparation_material/index');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/test_preparation_material/add');
            }            
        }
        else
        {  	        
			//$data['course_list']=$this->Test_module_model->get_all_test_module_active();
			$data['topic_list']=$this->Test_preparation_material_topic_model->get_all_topic_active();
			$data['content_type_list']=$this->Content_type_masters_model->get_all_content_type_active();
            $data['_view'] = 'test_preparation_material/add';
            $this->load->view('layouts/main',$data);
        }
    }
	
    function edit($id=null)
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit Test Preparation Material';
        $data['free_resources'] = $this->Test_preparation_material_model->get_free_resources($id);
        if(isset($data['free_resources']['id']))
        {   
            $this->load->library('form_validation');
            $this->form_validation->set_rules('content_type_id','content type','required|trim');
			$this->form_validation->set_rules('title','title','required|trim');
			//$this->form_validation->set_rules('free_resources_topic[]','test type','required|trim');
			$this->form_validation->set_rules('description','description','required|trim');
			$this->form_validation->set_rules('URLslug','URL slug','required|trim');			
			$data['free_resources_test_list'] = $this->Test_preparation_material_model->getTestByFreeResourcesId($id);			
			$data['free_resources_section_list']=$this->Test_preparation_material_model->getSectionByFreeResourcesId($id);			
			if(empty($data['free_resources_test_list'])){
				$this->form_validation->set_rules('free_resources_topic[]','test type','required|trim');
			}
			
			if($this->form_validation->run())
            { 
                $by_user=$_SESSION['UserId'];				
				$total_section=$this->input->post('total_section');
				if(!file_exists(TEST_PREPARATION_IMAGE_PATH)){
					mkdir(TEST_PREPARATION_IMAGE_PATH, 0777, true);
				}
				$config['upload_path']   = TEST_PREPARATION_IMAGE_PATH;
				$config['allowed_types'] = WEBP_FILE_TYPES;
				$config['encrypt_name']  = FALSE;
				$this->load->library('upload',$config);
				
				
				if($this->upload->do_upload("image")){
					
					$data = array('upload_data' => $this->upload->data());
					$image= $data['upload_data']['file_name'];  
					unlink(TEST_PREPARATION_IMAGE_PATH.$this->input->post('old_image'));              
				}else{
					$image=$this->input->post('old_image');               
				}
				$params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				    'isPinned' => $this->input->post('isPinned') ? $this->input->post('isPinned') : 0,      
					'total_section' => $total_section,
					'by_user' => $by_user,
					'content_type_id' => $this->input->post('content_type_id'),
					'title' => $this->input->post('title'),
					'description'=>$this->input->post('description',false),
					'URLslug'=>$this->input->post('URLslug'),
					'image'=>$image
				);
			
               $free_resources_topic = $this->input->post('free_resources_topic');
			
				$free_resources_id=$id;
                $id = $this->Test_preparation_material_model->update_free_resources($id,$params);
				
                if($id){
					
					$created=$modified=date('Y-m-d H:i:s');
					if(!empty($free_resources_topic)){
						
						foreach ($free_resources_topic as $topic_id) {                 
							$params=array(
								'topic_id' =>$topic_id,
								'test_preparation_material_id'=> $free_resources_id,
								'by_user'  => $by_user,
								'created'  => $created,
								'modified'  => $modified,
							);
							$this->Test_preparation_material_model->add_free_resources_test($params);
						}
					}
					if($total_section > 0){
						$j=1;
						for($i=1; $i<=$total_section; $i++){
							
							
							
							$section_no=$this->input->post('section_no'.$i);
							$section_type=$this->input->post('section_type'.$i);
							$old_section=$this->input->post('old_section'.$i);
							#pr($_FILES);
							if(!empty($section_no)){
								
								if($section_type=='text'){
									
									//$section=$this->input->post('free_resources_section'.$i);
									$section=$_POST['free_resources_section'.$i];
									
								}else if($section_type=='image'){
									$this->upload->initialize($config);
									if(!file_exists(TEST_PREPARATION_IMAGE_PATH)){
										mkdir(TEST_PREPARATION_IMAGE_PATH, 0777, true);
									}
									$config['upload_path']   = TEST_PREPARATION_IMAGE_PATH;
									$config['allowed_types'] = WEBP_FILE_TYPES;
									$config['encrypt_name']  = FALSE;
									$this->load->library('upload',$config);
									$this->upload->initialize($config);
									$section=$old_section;
									
									if($this->upload->do_upload('free_resources_section'.$i)){
										
									    $data = array('upload_data' => $this->upload->data());
									    $section= $data['upload_data']['file_name'];                
									}else{
										
										$this->upload->display_errors();
										
										
									}
								}else if($section_type=='video'){
									if(!file_exists(TEST_PREPARATION_VIDEO_PATH)){
										mkdir(TEST_PREPARATION_VIDEO_PATH, 0777, true);
									}
									$config['upload_path']   = TEST_PREPARATION_VIDEO_PATH;
									$config['allowed_types'] = FREE_RESOURCES_VIDEO_TYPES;
									$config['encrypt_name'] = FALSE;
									
									$this->load->library('upload',$config);
									$this->upload->initialize($config);
									$section=$old_section;
									
									if($this->upload->do_upload('free_resources_section'.$i)){
										
									    $data = array('upload_data' => $this->upload->data());
									    $section= $data['upload_data']['file_name'];                
									}else{
										
										//echo $this->upload->display_errors();
										
									}
								}else if($section_type=='audio'){
									if(!file_exists(TEST_PREPARATION_AUDIO_PATH)){
										mkdir(TEST_PREPARATION_AUDIO_PATH, 0777, true);
									}
									$config['upload_path'] = TEST_PREPARATION_AUDIO_PATH;
									$config['allowed_types'] = '*';
									$config['encrypt_name']  = FALSE;
									$this->load->library('upload',$config);
									
									$this->upload->initialize($config);
									
									$section=$old_section;
									
									if($this->upload->do_upload('free_resources_section'.$i)){
										
									    $data = array('upload_data' => $this->upload->data());
									    $section= $data['upload_data']['file_name'];                
									}else{
										
										//echo $this->upload->display_errors();
										
									}
								}
								
							    $free_resources_section_array[]=array(
								'section' =>  $section,
								'test_preparation_material_id'=>$free_resources_id,
								'section_number'=>$section_no,
								'type'=>$section_type,
								'by_user'  => $by_user,
								'created'  => $created,
								'modified' => $modified
							    );
							}
						}
                        #pr($free_resources_section_array,1);						
						$this->Test_preparation_material_model->add_free_resources_section($free_resources_id,$free_resources_section_array,$free_resources_id);
						
				    }
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/test_preparation_material/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/test_preparation_material/edit/'.$id);
                }
            }
            else
            {
				$data['topic_list']=$this->Test_preparation_material_topic_model->get_all_topic_active();				
				//$data['course_list']=$this->Test_module_model->get_all_test_module_active();
			    $data['content_type_list']=$this->Content_type_masters_model->get_all_content_type_active();
                $data['_view'] = 'test_preparation_material/edit';
                $this->load->view('layouts/main',$data);				
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
	
	function view_details_($id){
		
		//access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
		if(empty($id)){redirect('adminController/error_cl/index');}
		$data['si']=0;
		
		$data['title'] ='Test Preparation Material Detail';
		$data['free_resources'] = $this->Test_preparation_material_model->getFreeResourcesById($id);
		$data['free_resources_test_list'] = $this->Test_preparation_material_model->getTestByFreeResourcesId($id);
		//print_r($data['free_resources_test_list']);
		$data['free_resources_section_list']=$this->Test_preparation_material_model->getSectionByFreeResourcesId($id);
		$data['_view'] = 'test_preparation_material/view';
		$this->load->view('layouts/main',$data);
		
	}
   
    function ajax_delete_free_resources_test(){       
        $free_resources_id = $this->input->post('free_resources_id', true);
        $test_module_id = $this->input->post('test_module_id', true);
        if($test_module_id!=''){
			
            $del = $this->Test_preparation_material_model->delete_free_resources_test($free_resources_id,$test_module_id);
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
