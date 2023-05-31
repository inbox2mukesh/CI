<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Navjeet
 *
 **/
class About_online_pack extends MY_Controller{
    
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
        $data['serviceData']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $data['serviceData_p'] = json_decode($this->_curlGetData(base_url(GET_ACADEMY_SERVICE_URL), $headers));
        // $data['title'] = 'About online pack';        
        $this->load->model('Country_model');     
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/about_online_pack',$data);
        $this->load->view('aa-front-end/includes/footer');
    }  
    
    function view($id)
    {   
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
            'SERVICE_ID:'.$id,   
        );
        $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
         //SERVICE_DATA/enquiry_purpose is same 
       //  print_r($this->_curlGetData(base_url(GET_SERVICE_DATA_BY_ID_URL), $headers));
        // die();
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $data['serviceDetails'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_BY_ID_URL), $headers));
        $data['serviceDataAll'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));
        $data['title'] = 'About online pack view';      
        $this->load->model('Country_model');     
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/about_online_pack_detail',$data);
        $this->load->view('aa-front-end/includes/footer');
    }  
}
