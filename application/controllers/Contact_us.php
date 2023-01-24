<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Contact_us extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();      
        //$this->load->model('Country_model');       
    }

    function index()
    {  
        //$data['segment'] = $this->_getURI();
        $data['title'] = 'Contact Us';
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
        $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['newsData']=json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $data['serviceData']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $data['serviceDataAll']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));
        $data['longBranchesOverseas'] = json_decode($this->_curlGetData(base_url(GET_LONG_BRANCH_OVERSEAS_URL), $headers));  
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/contact-us');
        $this->load->view('aa-front-end/includes/footer');
    }


   
    
}
