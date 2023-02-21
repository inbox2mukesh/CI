<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Navjeet
 *
 **/
class Sitemap extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();         
    }
    
    function index()
    {          
        $headers = array(
           'API-KEY:'.WOSA_API_KEY,   
       );
       $this->load->helper('xml');
       $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
       $data['serviceData']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));     
       $data['faqData'] = json_decode($this->_curlGetData(base_url(GET_ALL_FAQ_URL), $headers));        
       $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
      // header('Content-type: text/xml');
      $data['title'] = 'Sitemap';
       $this->load->view('aa-front-end/includes/header',$data);
    
        $this->load->view("aa-front-end/sitemap");
       $this->load->view('aa-front-end/includes/footer');
     //   $this->load->view('aa-front-end/sitemap');
    
    }   
    
}
