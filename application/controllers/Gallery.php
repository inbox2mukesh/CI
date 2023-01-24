<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Gallery extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();  
         
    }
    
    function index()
    {   
        $data['title'] = 'Gallery';
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
        $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));    
        $data['photoData']= json_decode($this->_curlGetData(base_url(GET_PHOTO_GALLERY_DATA_URL), $headers));  
        $data['newsData']= json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $data['serviceData']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/gallery',$data);
        $this->load->view('aa-front-end/includes/footer');
    }   
    
}
