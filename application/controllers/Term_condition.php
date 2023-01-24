<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Term_condition extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();     
    }
    
    function index()
    {  
        $data['title'] = "Term & condition";
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
        $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
            'CONTENT-TYPE:'.'tc', //tc=term & condition
        );         
        $data['GET_CONTENTS'] = json_decode($this->_curlGetData(base_url(GET_CONTENTS), $headers));    
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/term_condition');
        $this->load->view('aa-front-end/includes/footer');
    }
   
    
}