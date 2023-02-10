<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Free_resources extends MY_Controller
{
    function __construct()
    {
        parent::__construct();    
    }
    function index()
    {
        $data['segment'] = $this->_getURI();
        $data['title'] = "Free Resources";
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
        );
        $data['countryCode'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));        
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));    
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers)); 
        $data['FREE_RESOURCE_CONTENT'] = json_decode($this->_curlGetData(base_url(FREE_RESOURCE_CONTENT), $headers));
        $data['FREE_RESOURCE_COURSE_LIST'] = json_decode($this->_curlGetData(base_url(GET_FREE_RESOURCE_COURSE), $headers));
        $data['FREE_RESOURCE_CONTENT_TYPE'] = json_decode($this->_curlGetData(base_url(GET_FREE_RESOURCE_CONTENT_TYPE), $headers));
        $this->load->view('aa-front-end/includes/header', $data);
        $this->load->view('aa-front-end/free_resources');
        $this->load->view('aa-front-end/includes/footer');
    }
    function free_resource_post($id = 0)
    {
        //$id = base64_decode($id);
        $headers1 = array(
            'API-KEY:' . WOSA_API_KEY,
            'ID:' . $id,
        );
        $x=json_decode($this->_curlGetData(base_url(CHECK_FREE_RESOURCE), $headers1));
        $isActiveContent = $x->error_message->data;
        if($isActiveContent<=0){
            redirect('free_resources/index');
        }
        //$data['segment'] = $this->_getURI();
        $data['title'] = "Free Resources Post";
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
        );

        $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['serviceData']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $data['newsData']=json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'ID:' . $id,
        );
        
        $data['FREE_RESOURCE_SECTION'] = json_decode($this->_curlGetData(base_url(FREE_RESOURCE_SECTION), $headers));
        $this->load->view('aa-front-end/includes/header', $data);
        $this->load->view('aa-front-end/free_resources_post');
        $this->load->view('aa-front-end/includes/footer');
    }
    function searchFreeResource()
    {
        $testtype_select   = $this->input->post('testtype_select', true);
        $contenttype_select   = $this->input->post('contenttype_select', true);
        $uploadtime_select   = $this->input->post('uploadtime_select', true);
        $testtype_search   = $this->input->post('testtype_search', true);
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'TEST-TYPE:' . $testtype_select,
            'CONTENT-TEST-TYPE:' . $contenttype_select,
            'UPLOAD-TIME:' . $uploadtime_select,
            'SEARCH-TEXT:' . $testtype_search
        );
        $data['FREE_RESOURCE_CONTENT'] = json_decode($this->_curlGetData(base_url(FREE_RESOURCE_CONTENT_FILTER), $headers));
        $this->load->view('aa-front-end/free_resources_ajax', $data);
    }
}
