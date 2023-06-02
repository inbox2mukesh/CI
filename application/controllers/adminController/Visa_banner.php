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
        $this->load->model('Enquiry_purpose_model');  
    }
    function index()
    {
        //access control start
       $cn = $this->router->fetch_class().''.'.php';
       $mn = $this->router->fetch_method();        
       if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
       $data['title'] = 'Visa Services Banner';
       $data['banner'] = $this->Enquiry_purpose_model->select_banner();
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
        if($this->input->post())
        {
            if(!empty($_FILES['banner']['name']) && count(array_filter($_FILES['banner']['name'])) > 0){ 
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
                    $this->Enquiry_purpose_model->insert_banner($params);
                }
            }
        }
        $data['_view'] = 'visa_banner/add';
        $this->load->view('layouts/main',$data);
    }
}