<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Provinces extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login'); }
        $this->load->model('Provinces_model');
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
        $config['base_url'] = site_url('adminController/provinces/index/?');
        $config['total_rows'] = $this->Provinces_model->get_all_provinces_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Provinces';
        $data['provinces'] = $this->Provinces_model->get_all_provinces($params);
        $data['_view'] = 'provinces/index';
        $this->load->view('layouts/main',$data);

    } 

    function add()
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends        

        $data['title'] = 'Add Province';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('province_name','Province Name','required|trim');
		if($this->form_validation->run())
        {   
            $by_user=$_SESSION['UserId'];            
            $config['upload_path']      = PROVINCES_FILE_PATH;
            $config['allowed_types']    = WEBP_FILE_TYPES;
            $config['encrypt_name']     = FALSE;         
            $this->load->library('upload',$config);
            if($this->upload->do_upload("parent_image")){
                $data = array('upload_data' => $this->upload->data());
                $image= $data['upload_data']['file_name'];
            }else{
                $image=NULL;
            }               
            $params = array( 
                'province_name' => $this->input->post('province_name'),
                'parent_image' => $image,
                'about' => $this->input->post('about',false)? $this->input->post('about',false) : NULL,
                'education'=>$this->input->post('education')? $this->input->post('education') : NULL,
                'jobs'=>$this->input->post('jobs')? $this->input->post('jobs') : NULL, 
                'way_of_life'=>$this->input->post('way_of_life')? $this->input->post('way_of_life') : NULL, 
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'by_user' => $by_user,
            );
            $id = $this->Provinces_model->add_provinces($params);
            if($id){     
                $count = count($_FILES['files']['name']);      
                for($i=0;$i<$count;$i++){ 

                    if(!empty($_FILES['files']['name'][$i])){

                      $_FILES['file']['name'] = $_FILES['files']['name'][$i];  
                      $_FILES['file']['type'] = $_FILES['files']['type'][$i];  
                      $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];  
                      $_FILES['file']['error'] = $_FILES['files']['error'][$i];  
                      $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                      $config['file_name'] = $_FILES['files']['name'][$i];
                      if($this->upload->do_upload('file')){  
                        $uploadData = $this->upload->data();  
                        $filename = $uploadData['file_name'];                 
                        $data['totalFiles'][] = $filename;  
                      } 

                    $params2 = array('province_id'=>$id,'image'=> $filename);
                    $this->Provinces_model->add_provinces_image($params2);

                    }
                }
            }                     
                    
            if($id){
                //activity update start              
                $activity_name= "New Provinces Added";
                $description= ''.json_encode($params).'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                //activity update end  
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/provinces/index');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/provinces/add');
            }            
                
        }else{

            $data['_view'] = 'provinces/add';
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

        $data['title'] = 'Edit Province';
        $data['provinces'] = $this->Provinces_model->get_provinces($id);
        /*$bookingData=$data['provinces'];        
        foreach ($bookingData as $key => $c) {
            $mData = $this->Provinces_model->getprovincesImages($data['provinces']['id']);
            foreach ($mData as $key2 => $m) {                
                $bookingData['ImgData'][$key2]=$m;                       
            }              
        }
        $data['provinces']=$bookingData;*/

        
        if(isset($data['provinces']['id']))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('province_name','Province Name','required|trim');		
			if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $config['upload_path']      = PROVINCES_FILE_PATH;
                $config['allowed_types']    = WEBP_FILE_TYPES;
                $config['encrypt_name']     = FALSE;         
                $this->load->library('upload',$config);
                if($this->upload->do_upload("parent_image")){
                    $data = array('upload_data' => $this->upload->data());
                    $image= $data['upload_data']['file_name'];
                    $params = array( 
                        'province_name' => $this->input->post('province_name'),
                        'parent_image' => $image,
                        'about' => $this->input->post('about',false)? $this->input->post('about',false) : NULL,
                        'education'=>$this->input->post('education')? $this->input->post('education') : NULL,
                        'jobs'=>$this->input->post('jobs')? $this->input->post('jobs') : NULL, 
                        'way_of_life'=>$this->input->post('way_of_life')? $this->input->post('way_of_life') : NULL, 
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'by_user' => $by_user,
                    );
                    unlink($this->input->post('hid_parent_image'));         
                   
                }else{
                    $params = array( 
                        'province_name' => $this->input->post('province_name'),
                        //'parent_image' => $image,
                        'about' => $this->input->post('about',false)? $this->input->post('about',false) : NULL,
                        'education'=>$this->input->post('education')? $this->input->post('education') : NULL,
                        'jobs'=>$this->input->post('jobs')? $this->input->post('jobs') : NULL, 
                        'way_of_life'=>$this->input->post('way_of_life')? $this->input->post('way_of_life') : NULL, 
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'by_user' => $by_user,
                    );
                }       

                $idd = $this->Provinces_model->update_provinces($id,$params);
                $config['upload_path']  = PROVINCES_FILE_PATH;
                $config['allowed_types']= WEBP_FILE_TYPES;
                $config['encrypt_name'] = FALSE;       
                $this->load->library('upload',$config);

                if($idd){     
                    $count = count($_FILES['files']['name']);      
                    for($i=0;$i<$count;$i++)
					{ 
				//echo $i;
					if($i==0)
					{
					//	echo $id;
					 $this->Provinces_model->delete_provinces_images($id);	
					}

                        if(!empty($_FILES['files']['name'][$i])){

                          $_FILES['file']['name'] = $_FILES['files']['name'][$i];  
                          $_FILES['file']['type'] = $_FILES['files']['type'][$i];  
                          $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];  
                          $_FILES['file']['error'] = $_FILES['files']['error'][$i];  
                          $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                          $config['file_name'] = $_FILES['files']['name'][$i];
                          if($this->upload->do_upload('file')){  
                            $uploadData = $this->upload->data();  
                            $filename = $uploadData['file_name'];                 
                            $data['totalFiles'][] = $filename;  
                          } 

                          $params2 = array('province_id'=>$id,'image'=> $filename);
                          $this->Provinces_model->add_provinces_image($params2);

                        }
                    }
                } 
			//	die();
                if($id){
                    //activity update start                            
                $activity_name= "Provinces Updated";
                unset($data['provinces']['id'],$data['provinces']['created'],$data['provinces']['modified']);//unset extras from array               
                          
                $uaID = 'provinces'.$id;
                $diff1 =  json_encode(array_diff($data['provinces'], $params));//old
                $diff2 =  json_encode(array_diff($params,$data['provinces']));//new
                
                $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                if($diff1!=$diff2){
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                }                                        
                //activity update end
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/provinces/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/provinces/edit/'.$id);
                }
                
            }
            else
            {
                 
                $data['_view'] = 'provinces/edit';
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

        $provinces = $this->Provinces_model->get_provinces($id);
        if(isset($provinces['id']))
        {
            $del1 = $this->Provinces_model->delete_provinces($id);
            $del2 = $this->Provinces_model->delete_provinces_images($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            if($del1 && $del2){
                redirect('adminController/provinces/index');
            }else{
                redirect('adminController/provinces/index');
            }
            
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
}
