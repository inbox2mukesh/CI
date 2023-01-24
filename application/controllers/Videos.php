<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Videos extends MY_Controller{
    
    function __construct()
    {
        parent::__construct(); 		 
    }
    
    function index()
    {   
        $data['title'] = 'Video';
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
        $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));       
        $data['videoData']= json_decode($this->_curlGetData(base_url(GET_VIDEO_GALLERY_DATA_URL), $headers));  
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/videos',$data);
        $this->load->view('aa-front-end/includes/footer');
    }   
    
}
