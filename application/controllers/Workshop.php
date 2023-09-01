<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Rajan Bansal
 *
 **/
class Workshop extends MY_Controller{
    
    function __construct(){
        parent::__construct();       
    }
    function index(){
        if(!isset($_SESSION['active_country']))
        {
            $_SESSION['active_country']=INDIA_ID;
        }
        $this->load->helper('text');
        $today = date('d-m-Y');
        $todaystr = strtotime($today);
        $data['segment'] = $this->_getURI();
        // $data['title'] = COMPANY;
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        ); 
        //$data['callfromview'] = $this;
        $data['newsData']=json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['serviceDataAll']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));  
        $data['FREE_RESOURCE_CONTENT'] = json_decode($this->_curlGetData(base_url(FREE_RESOURCE_CONTENT_SHORT), $headers));               
        //SERVICE_DATA/enquiry_purpose is same 
        $data['serviceData']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));

        $settingsData = json_decode($this->_curlGetData(base_url(GET_WORKSHOP_PAGE_SETTINGS), $headers));

        if(isset($settingsData->error_message->data) && $settingsData->error_message->data) {
            if($settingsData->error_message->data->active == 0) {
                redirect("/");
            }
        }
        else {
            redirect("/");
        }
        
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/workshop');
        $this->load->view('aa-front-end/includes/footer');
    }      
    
}
