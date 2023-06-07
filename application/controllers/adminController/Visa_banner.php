<?php
/**
 * @package         WOSA
 * @subpackage      CMS/Visa Banner
 * @author          Harpreet
 *
 **/
class Visa_banner extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Visa_banner_model');  
    }
    function index()
    {
        //access control start
       $cn = $this->router->fetch_class().''.'.php';
       $mn = $this->router->fetch_method();        
       if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
       $data['title'] = 'Visa Services Banner';
       $data['banner'] = $this->Visa_banner_model->select_banner();
        $data['_view'] = 'visa_banner/index';
        $this->load->view('layouts/main',$data);
    }
    function add()
    {
         //access control start
       $cn = $this->router->fetch_class().''.'.php';
       $mn = $this->router->fetch_method();        
       if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
       //access control ends
        $by_user=$_SESSION['UserId'];
        $data['title'] = 'Add Visa Services Banner';        
        $config['encrypt_name']  = TRUE;   
        if(!file_exists(VISA_BANNER_IMAGE_PATH)){
            mkdir(VISA_BANNER_IMAGE_PATH, 0777, true);
        }     
        $errorUploadType='';
        if(!empty($_FILES['banner']['name'])){
                $insertedid=[];
                $filesCount = count($_FILES['banner']['name']); 
                for($i = 0; $i < $filesCount; $i++){ 
                    $_FILES['file']['name']     = $_FILES['banner']['name'][$i]; 
                    $_FILES['file']['type']     = $_FILES['banner']['type'][$i]; 
                    $_FILES['file']['tmp_name'] = $_FILES['banner']['tmp_name'][$i]; 
                    $_FILES['file']['error']     = $_FILES['banner']['error'][$i]; 
                    $_FILES['file']['size']     = $_FILES['banner']['size'][$i]; 
                    $config['upload_path']   = VISA_BANNER_IMAGE_PATH;
                    $config['allowed_types'] = WEBP_FILE_TYPES;
                    $this->load->library('upload',$config);
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file')){ 
                        // Uploaded file data 
                        $fileData = $this->upload->data(); 
                        $uploadData[$i]['file_name'] = $fileData['file_name']; 
                        $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
                    }else{  
                        $errorUploadType .= $_FILES['file']['name'].' | ';  
                    }
                    $params = array('banner_img'=>$uploadData[$i]['file_name'],'added_by'=>$by_user);
                    $insertedid[]=$this->Visa_banner_model->insert_banner($params);
                }
                if(!empty($insertedid))
                {
                        $activity_name= "Visa Banner Added";
                        $description= ''.json_encode($params).'';
                        $res=$this->addUserActivity($activity_name,$description,0,$by_user);
                        //activity update end
                        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                        redirect('adminController/visa_banner/index');
                        
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/visa_banner/add');
                }           
        }
        $data['_view'] = 'visa_banner/add';
        $this->load->view('layouts/main',$data);
    }
    function remove($id)
    {
        $data = $this->Visa_banner_model->get_banner_by_id($id);
        $removedID = $this->Visa_banner_model->remove_banner($id);
        if($removedID)
        {
             unlink(VISA_BANNER_IMAGE_PATH.$data->banner_img);
             $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/visa_banner/index');
        }
        else{
            $this->session->set_flashdata('flsh_msg', DEL_MSG_FAILED);
            redirect('adminController/visa_banner/add');
        }  
       

    }
}