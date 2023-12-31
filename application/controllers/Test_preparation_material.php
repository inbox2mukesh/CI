<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          navjeet
 *
 **/
class Test_preparation_material extends MY_Controller
{
    function __construct()
    {
        parent::__construct();    
    }
    function index()
    {

        $data['segment'] = $this->_getURI();
        $data['title'] = "Posts";
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
    
        $data['TEST_PREPARATION_MATERIAL_CONTENT'] = json_decode($this->_curlGetData(base_url(TEST_PREPARATION_MATERIAL_CONTENT), $headers));        

        $data["total_rows"]     = 0;
        $data["total_pages"]    = 0;
        if(isset($data['TEST_PREPARATION_MATERIAL_CONTENT']->error_message->data) && $data['TEST_PREPARATION_MATERIAL_CONTENT']->error_message->data) {
            $countHeaders           = $headers;
            $countHeaders[]         = 'COUNT:true';
            $totalRowsResult        = json_decode($this->_curlGetData(base_url(TEST_PREPARATION_MATERIAL_CONTENT), $countHeaders));

            if(isset($totalRowsResult->error_message->data) && $totalRowsResult->error_message->data) {
                $totalRows = $totalRowsResult->error_message->data;
                $data["total_pages"]    = $totalPages = ceil($totalRows / FRONTEND_RECORDS_PER_PAGE);
            }
            else {
                $data["total_pages"]    = 0;
            }
        }
        $data['countryCode'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));        
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));    
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers)); 
        $data['FREE_RESOURCE_COURSE_LIST'] = json_decode($this->_curlGetData(base_url(GET_TEST_PREPARATION_MATERIAL_COURSE), $headers));
        $data['FREE_RESOURCE_CONTENT'] = json_decode($this->_curlGetData(base_url(TEST_PREPARATION_MATERIAL_CONTENT), $headers));
        $data['FREE_RESOURCE_CONTENT_TYPE'] = json_decode($this->_curlGetData(base_url(GET_TEST_PREPARATION_MATERIAL_CONTENT_TYPE), $headers));//content type DD
        $this->load->view('aa-front-end/includes/header', $data);
        $this->load->view('aa-front-end/test_preparation_material',$data);
        $this->load->view('aa-front-end/includes/footer',$data);
    }
    function post($id = 0)
    {
        //$id = base64_decode($id);
      
        $headers1 = array(
            'API-KEY:' . WOSA_API_KEY,
            'ID:' . $id,
        );
        $x=json_decode($this->_curlGetData(base_url(CHECK_TEST_PREPARATION_MATERIAL), $headers1));
        $isActiveContent = $x->error_message->data;
       
        if($isActiveContent<=0){
            redirect('test-preparation-material');
        }

        //$data['segment'] = $this->_getURI();
        $data['title'] = "Test Preparation Material";
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
        
        $data['FREE_RESOURCE_SECTION'] = json_decode($this->_curlGetData(base_url(TEST_PREPARATION_MATERIAL_SECTION), $headers));
        $data['TEST_PREPARATION_SECTION_LIMITED'] = json_decode($this->_curlGetData(base_url(TEST_PREPARATION_MATERIAL_SECTION_LIMITED), $headers));
        $this->load->view('aa-front-end/includes/header', $data);
        $this->load->view('aa-front-end/test_preparation_material_post');
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
        $data['FREE_RESOURCE_CONTENT'] = json_decode($this->_curlGetData(base_url(TEST_PREPARATION_MATERIAL_CONTENT_FILTER), $headers));
        $this->load->view('aa-front-end/test_preparation_material_ajax', $data);
    }
}
