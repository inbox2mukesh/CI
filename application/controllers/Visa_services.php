<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Navjeet
 *
 **/
class Visa_services extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();             
    }    
    function index()
    {   
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
        $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
         //SERVICE_DATA/enquiry_purpose is same 
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $data['title'] = 'VISA Service';        
        $this->load->model('Country_model');     
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/visa-services',$data);
        $this->load->view('aa-front-end/includes/footer');
    }       
}
