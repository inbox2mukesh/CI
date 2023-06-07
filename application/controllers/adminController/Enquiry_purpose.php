<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Enquiry_purpose extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Enquiry_purpose_model');    
        $this->load->model('Division_master_model'); 
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
        $config['base_url'] = site_url('adminController/enquiry_purpose/index?');
        $config['total_rows'] = $this->Enquiry_purpose_model->get_all_enquiry_purpose_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Enquiry Purpose';
        $data['enquiry_purpose'] = $this->Enquiry_purpose_model->get_all_enquiry_purpose($params);
		foreach($data['enquiry_purpose'] as $key=>$val){
			
		    $data['enquiry_purpose'][$key]['divisions']=$this->Enquiry_purpose_model->getDivisionByeEnquiryPurposeId($val['id']);
		}
        $data['_view'] = 'enquiry_purpose/index';
        $this->load->view('layouts/main',$data);
		
    }
 
    function add()
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['title'] = 'Add Enquiry purpose';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('enquiry_purpose_name','enquiry purpose name','required|trim|is_unique[enquiry_purpose_masters.enquiry_purpose_name]|max_length[50]');
		
        $this->form_validation->set_rules('division_id[]','Division','required');
        $this->form_validation->set_rules('URLslug','Url Slug','required|trim');
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'enquiry_purpose_name'=> trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('enquiry_purpose_name')))),
                'image'  => $this->input->post('image'),
                'about_service' => $this->input->post('about_service',false),
                'URLslug' => $this->input->post('URLslug'),
                'by_user'             =>$by_user,
            );
            $config['upload_path']   = SERVICE_IMAGE_PATH;
            $config['allowed_types'] = WEBP_FILE_TYPES;
            $config['encrypt_name']  = TRUE;   
            if(!file_exists(SERVICE_IMAGE_PATH)){
                mkdir(SERVICE_IMAGE_PATH, 0777, true);
            }     
            $this->load->library('upload',$config);
            if($this->upload->do_upload("image")){
                $data = array('upload_data' => $this->upload->data());
                $image= $data['upload_data']['file_name'];
                $params = array(
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				    'enquiry_purpose_name'=> trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('enquiry_purpose_name')))),
                    'image'  => $image,
                    'about_service' => $this->input->post('about_service',false),
                    'by_user' => $by_user,
                    'URLslug' => $this->input->post('URLslug'),
                    'seo_keywords'=>$this->input->post('keywords'),
                    'seo_title'=>$this->input->post('seo_title'),
                    'seo_desc'=>$this->input->post('seo_desc'),
                );                     
        }else{           
            $params = array(
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'enquiry_purpose_name'=> trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('enquiry_purpose_name')))),
                'about_service' => $this->input->post('about_service',false),
                'by_user' => $by_user,
                 'URLslug' => $this->input->post('URLslug'),
                 'seo_keywords'=>$this->input->post('keywords'),
                 'seo_title'=>$this->input->post('seo_title'),
                 'seo_desc'=>$this->input->post('seo_desc'),
                );
        }
        $id = $this->Enquiry_purpose_model->add_enquiry_purpose($params);
            if($id){
				
				$division_id = $this->input->post('division_id');
				foreach ($division_id as $d) 
				{                  
					if($d>0)
					{
						$params_div=array(
						'enquiry_purpose_id' =>$id,
						'division_id'        =>$d,
						'by_user'            =>$by_user
						);
						
						if($this->Enquiry_purpose_model->add_enquiry_purpose_division($params_div)){
									
							$activity_name = ENQUIRY_PURPOSE_DIVISION_ADD;
							$description = 'Enquiry Purpose   division id-'.$d.' Added in Enquiry Purpose  PK ID-'.$id;
							$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
						}
					}
					
				}
				//activity update start              
                $activity_name = ENQUIRY_PURPOSE_ADD;
                $description = 'New Enquiry Purpose' . $params['enquiry_purpose_name'] . ' added';
                $res = $this->addUserActivity($activity_name, $description, $student_package_id = 0, $by_user);
                //activity update end
				$this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
				redirect('adminController/enquiry_purpose/index');
			}else{                    
				$this->session->set_flashdata('flsh_msg', FAILED_MSG);
				redirect('adminController/enquiry_purpose/add');
			}    
        }else{  
            $data['all_division'] = $this->Division_master_model->get_all_division_active();   
            $data['_view'] = 'enquiry_purpose/add';
            $this->load->view('layouts/main',$data);
        }
    }
    
    function edit($id)
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit Enquiry Purpose';
        $data['enquiry_purpose'] = $this->Enquiry_purpose_model->get_enquiry_purpose($id);
		
        if(isset($data['enquiry_purpose']['id']))
        {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('enquiry_purpose_name','enquiry_purpose name','required|trim|max_length[50]');
			
			if(!empty($_POST) && $data['enquiry_purpose']['enquiry_purpose_name'] !=$_POST['enquiry_purpose_name']){
				
				$this->form_validation->set_rules('enquiry_purpose_name','enquiry purpose name','required|trim|is_unique[enquiry_purpose_masters.enquiry_purpose_name ]|max_length[50]');
			}
			$data['enquiryPurposeDivisions']=$this->Enquiry_purpose_model->getDivisionByeEnquiryPurposeId($id);
			
			if(empty($data['enquiryPurposeDivisions'])){
				
		        $this->form_validation->set_rules('division_id[]','division','required');
		    }
            $this->form_validation->set_rules('URLslug','Url Slug','required|trim');
			
			if($this->form_validation->run())
            {   
                $by_user=$_SESSION['UserId'];
                $modified=date('Y-m-d H:i:s');
                $params = array(
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'enquiry_purpose_name'=> trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('enquiry_purpose_name')))),
                    'image'  => $this->input->post('image'),
                    'about_service' => $this->input->post('about_service',false),
                    'by_user'             =>$by_user,
                    'URLslug' => $this->input->post('URLslug'),
                );
                if(!file_exists(SERVICE_IMAGE_PATH)){
					mkdir(SERVICE_IMAGE_PATH, 0777, true);
				}
                $config['upload_path']   = SERVICE_IMAGE_PATH;
                $config['allowed_types'] = WEBP_FILE_TYPES;
                $config['encrypt_name']  = TRUE;         
                $this->load->library('upload',$config);
                if($this->upload->do_upload("image")){
                    $data = array('upload_data' => $this->upload->data());
                    $image= $data['upload_data']['file_name'];                    
                    unlink($this->input->post('hid_image'));                     
                    $params = array(
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'enquiry_purpose_name'=> trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('enquiry_purpose_name')))),
                        'image'  => $image,
                        'about_service' => $this->input->post('about_service',false),
                        'by_user' => $by_user,
                        'URLslug' => $this->input->post('URLslug'),
                        'seo_keywords'=>$this->input->post('keywords'),
                         'seo_title'=>$this->input->post('seo_title'),
                         'seo_desc'=>$this->input->post('seo_desc'),
                    );                     
            }else{
               //echo $this->upload->display_errors();
                    $params = array(
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'enquiry_purpose_name'=> trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('enquiry_purpose_name')))),
                        //'image'  => $image,
                        'about_service' => $this->input->post('about_service',false),
                        'by_user' => $by_user,
                        'URLslug' => $this->input->post('URLslug'),
                        'seo_keywords'=>$this->input->post('keywords'),
                        'seo_title'=>$this->input->post('seo_title'),
                        'seo_desc'=>$this->input->post('seo_desc'),
                    );
            }
				$result = $this->Enquiry_purpose_model->update_enquiry_purpose($id,$params);
				if($result){
					
					$division_id = $this->input->post('division_id');
					foreach ($division_id as $d) 
					{                  
						if($d>0)
						{
							$params_div=array(
							'enquiry_purpose_id' =>$id,
							'division_id'        =>$d,
							'by_user'            =>$by_user,
							);
							if($this->Enquiry_purpose_model->add_enquiry_purpose_division($params_div)){
									
									$activity_name = ENQUIRY_PURPOSE_DIVISION_ADD;
									$description = 'Enquiry Purpose   division id-'.$d.' Added in Enquiry Purpose  PK ID-'.$id;
									$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
						    }
						}

					}
				    //activity update start              
					$activity_name = ENQUIRY_PURPOSE_UPDATE;
					$description = 'Enquiry purpose name' . $data['enquiry_purpose']['enquiry_purpose_name'] . ' updated to ' . $params['enquiry_purpose_name'] . '';
					$res = $this->addUserActivity($activity_name, $description, $student_package_id = 0, $by_user);
					//activity update end
					$this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
					redirect('adminController/enquiry_purpose/index');
				}else{
					$this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
					redirect('adminController/enquiry_purpose/edit/'.$id);
				}
				
            }
            else
            {                
                $data['all_division'] = $this->Division_master_model->get_all_division_active(); 
                $data['_view'] = 'enquiry_purpose/edit';
                $this->load->view('layouts/main',$data);                
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    function delete_enquiry_purpose_division_(){		
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control end
		$enquiry_purpose_id =  $this->input->post('enquiry_purpose_id', true);
        $division_id = $this->input->post('division_id', true);
		$by_user=$_SESSION['UserId'];
        if($enquiry_purpose_id!='' && !empty($division_id)){
		
			$enquiryPurposeDivisions=$this->Enquiry_purpose_model->getDivisionByeEnquiryPurposeId($enquiry_purpose_id);
			if(count($enquiryPurposeDivisions) > 1){
				
               $del = $this->Enquiry_purpose_model->delete_enquiry_purpose_division($enquiry_purpose_id,$division_id);
			   if($del){
					$activity_name = ENQUIRY_PURPOSE_REMOVE;
					$description = 'enquiry purpose  division id-'.$division_id.' Remove From enquiry purpose  PK ID-'.$enquiry_purpose_id;
					$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
				}
			   
			}else{
				$del=false;
			}
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
