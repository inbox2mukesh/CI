<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Provinces extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();              
    }
    
    function province_details($id)
    { 
        $headers_p = array(
            'API-KEY:'.WOSA_API_KEY,  
            'PROVINCE-ID:'.$id,             
        );
        $data['title'] = 'Provinces Details';        
        $data['provinceDetailse'] = json_decode($this->_curlGetData(base_url(GET_PROVINCES), $headers_p));
        $data['provinceDetails']=$data['provinceDetailse']->error_message->data;
        $data['provinceImages'] = json_decode($this->_curlGetData(base_url(GET_PROVINCES_IMAGES), $headers_p));       
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,             
        );
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers)); 
        $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/province-details');
        $this->load->view('aa-front-end/includes/footer');
    }   
    
}
