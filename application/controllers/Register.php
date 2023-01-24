<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Register extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();      
    }
    /*
     * Listing of Batch_master
     */
    function index()
    {   
        $data['segment'] = $this->_getURI();
        $data['title'] = 'Register';
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        ); 
        //feddback url
        //$data['feedbackLink'] = json_decode($this->_curlGetData(base_url(GET_FL_URL), $headers));
        $data['complaintSubject'] = json_decode($this->_curlGetData(base_url(GET_COMPLAINT_SUBJECT), $headers));
        $data['Offers'] = json_decode($this->_curlGetData(base_url(GET_OFFERS_URL), $headers));
        $data['shortBranches'] = $this->_common($headers);
        $data['countryCode'] = json_decode($this->_curlGetData(base_url().GET_ALL_CNT_CODE_URL, $headers));
        $data['allCnt'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/register');
        $this->load->view('aa-front-end/includes/footer');
    }
   
    
}
