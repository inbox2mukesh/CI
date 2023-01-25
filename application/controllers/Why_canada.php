<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Why_canada extends MY_Controller{
    function __construct()
    {
        parent::__construct();       
    }
    function index()
    {
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
        $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['title'] = 'Why Australia?';
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));      
        $data['provinceData'] = json_decode($this->_curlGetData(base_url(GET_PROVINCES_SHORT), $headers));      
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/why-canada',$data);
        $this->load->view('aa-front-end/includes/footer');
    }   
}
