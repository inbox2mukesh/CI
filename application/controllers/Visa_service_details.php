<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Visa_service_details extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();       
    }
    
    function index($id)
    {   
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
            'SERVICE_ID:'.$id,   
        );
        $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
         //SERVICE_DATA/enquiry_purpose is same 
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $data['serviceDetails'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_BY_ID_URL), $headers));
        $data['serviceDataAll'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));
        $data['title'] = 'Visa service details';      
        $this->load->model('Country_model');     
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/visa-service-details',$data);
        $this->load->view('aa-front-end/includes/footer');
    }   
    
}
