<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Common extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        if(!$this->_is_logged_in()) {redirect('adminController/login');}       
    }    
       
    public function auto_common_file_upload()
    {      
        $fileType = $this->input->post('fileType');
        if ($fileType == 'image') //image
        {
            if (!file_exists(COMMON_IMAGE_PATH)) {
                mkdir(COMMON_IMAGE_PATH, 0777, true);
            }
        } elseif ($fileType == 'video') { // video
            if (!file_exists(COMMON_VIDEO_PATH)) {
                mkdir(COMMON_VIDEO_PATH, 0777, true);
            }
        } else {
            if (!file_exists(COMMON_AUDIO_PATH)) {
                mkdir(COMMON_AUDIO_PATH, 0777, true);
            }
        }
        $fileInfo = $this->auto_checkCommonfileType($fileType);
        $config['upload_path'] = $fileInfo['path'];
        $config['allowed_types'] = $fileInfo['type'];
        $config['encrypt_name']  = TRUE;
 
        $this->load->library('upload',$config);
		$this->upload->initialize($config);
        if($this->upload->do_upload("upload_file")){
            $data = array('upload_data' => $this->upload->data());
            $file = $data['upload_data']['file_name'];                
        }else{
            $file='';               
        }
        echo  $file;
    }

    function auto_checkCommonfileType($fileType){
        switch ($fileType) {
          case "video":
            return ['path' =>COMMON_VIDEO_PATH,'type' =>COMMON_VIDEO_TYPE]; 
            break;
            case "image":
            return ['path' =>COMMON_IMAGE_PATH,'type' =>COMMON_IMAGE_TYPE]; 
            break;
          default:
          return ['path' =>COMMON_AUDIO_PATH,'type' =>COMMON_AUDIO_TYPE]; 
        }
    }
}