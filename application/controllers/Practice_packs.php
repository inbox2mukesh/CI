<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Practice_packs extends MY_Controller{
    function __construct()
    {
        parent::__construct();         
    }
    function index()
    {  
        //$data['segment'] = $this->_getURI();
        $data['title'] = 'Practice Packs';
        $data['title1'] = 'Practice';
        $data['title2'] = ' Packs';
        $headers = array(
            'API-KEY:' .WOSA_API_KEY, 
            'LIMIT:' .LOAD_MORE_LIMIT_8,
            'OFFSET:0',
        );           
        $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));       
        $data['AllTestModule_PP'] = json_decode($this->_curlGetData(base_url(GET_ALL_PRACTICE_TEST_MODULE_URL), $headers));
        $data['AllPack_PP'] = json_decode($this->_curlGetData(base_url(GET_ALL_PP_PACK_URL_LONG), $headers));
        $data['allppTestModule']=json_decode($this->_curlGetData(base_url(GET_PP_COURSE), $headers));
      //  $data['allppCoursePgm']=json_decode($this->_curlGetData(base_url(GET_PP_PGM), $headers));
        $data['allppDuration']=json_decode($this->_curlGetData(base_url(GET_PP_DURATION), $headers));
        $data['serviceData']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $data['newsData']=json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'COUNTRY-ID:' . DEFAULT_COUNTRY,
            'LIMIT:0',
            'OFFSET:0',
        );       
        $data['AllPack_PP_count'] = json_decode($this->_curlGetData(base_url(GET_ALL_PP_PACK_URL_LONG_COUNT), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/practice_packs');
        $this->load->view('aa-front-end/includes/footer');
    }
    function ajax_loadmore_practicepack()
    {
        $offset=$this->input->post('offset')+LOAD_MORE_LIMIT_8;
        $test_module_id   = $this->input->post('test_module_id', true);
        $programe_id = $this->input->post('programe_id', true);       
        $category_id = $this->input->post('category_id', true);
        $duration = $this->input->post('duration', true);
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'COUNTRY-ID:' . DEFAULT_COUNTRY,
            'LIMIT:' .LOAD_MORE_LIMIT_8,
            'OFFSET:'.$offset,
            'TEST-MODULE-ID:' . $test_module_id,
            'PROGRAME-ID:' . $programe_id,
            'CATEGORY-ID:' . $category_id,
            'DURATION:' . $duration,
        );
        $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['OnlinePack'] = json_decode($this->_curlGetData(base_url(GET_ALL_PP_PACK_URL_LONG), $headers));
        $next_offset=$offset+LOAD_MORE_LIMIT_8;
        $headers_a = array(
            'API-KEY:' . WOSA_API_KEY,
            'COUNTRY-ID:' . DEFAULT_COUNTRY,            
            'LIMIT:' .LOAD_MORE_LIMIT_8,
            'OFFSET:'.$next_offset,
            'TEST-MODULE-ID:' . $test_module_id,
            'PROGRAME-ID:' . $programe_id,
            'CATEGORY-ID:' . $category_id,
            'DURATION:' . $duration,
        );
        $data['AllPack_PP_count'] = json_decode($this->_curlGetData(base_url(GET_ALL_PP_PACK_URL_LONG_COUNT), $headers_a));    
        ob_start();
        $this->load->view('aa-front-end/ajax_practice_pack_content', $data);
        $abc["html"] = ob_get_clean();
        $abc["count"] =  $data['AllPack_PP_count'];
        echo json_encode($abc);
    }
    function GetPracticePack()
    {
        $offset=0;    
        $test_module_id   = $this->input->post('test_module_id', true);
        $programe_id = $this->input->post('programe_id', true);       
        $category_id = $this->input->post('category_id', true);
        $duration = $this->input->post('duration', true);
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'COUNTRY-ID:' . DEFAULT_COUNTRY,
            'LIMIT:' .LOAD_MORE_LIMIT_8,
            'OFFSET:'.$offset,
            'TEST-MODULE-ID:' . $test_module_id,
            'PROGRAME-ID:' . $programe_id,
            'CATEGORY-ID:' . $category_id,
            'DURATION:' . $duration
        );
        $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['OnlinePack'] = json_decode($this->_curlGetData(base_url(GET_ALL_PP_PACK_URL_LONG), $headers));
        $next_offset=$offset+LOAD_MORE_LIMIT_8;
        $headers_a = array(
            'API-KEY:' . WOSA_API_KEY,
            'COUNTRY-ID:' . DEFAULT_COUNTRY,            
            'LIMIT:' .LOAD_MORE_LIMIT_8,
            'OFFSET:'.$next_offset,
            'TEST-MODULE-ID:' . $test_module_id,
            'PROGRAME-ID:' . $programe_id,
            'CATEGORY-ID:' . $category_id,
            'DURATION:' . $duration,
        );
        $data['AllPack_PP_count'] = json_decode($this->_curlGetData(base_url(GET_ALL_PP_PACK_URL_LONG_COUNT), $headers_a));    
        ob_start();
        $this->load->view('aa-front-end/ajax_practice_pack_content', $data);
        $abc["html"] = ob_get_clean();
        $abc["count"] =  $data['AllPack_PP_count'];
        echo json_encode($abc);
    } 
    function GetDuation()
    {
        $test_module_id = $this->input->post('test_module_id', true);
        $programe_id = $this->input->post('programe_id', true);  
        $category_id = $this->input->post('category_id', true);     
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'TEST-MODULE-ID:' . $test_module_id,            
            'PROGRAME-ID:' . $programe_id, 
            'CATEGORY-ID:' . $category_id,             
            'COUNTRY-ID:' . DEFAULT_COUNTRY,
        );
        $data['allOnlineCourseDuration']=json_decode($this->_curlGetData(base_url(GET_PP_DURATION), $headers));
        $this->load->view('aa-front-end/ajax_online_duation', $data);
    }  
    function Getcategory()
    {
        $test_module_id   = $this->input->post('test_module_id', true);
        $programe_id = $this->input->post('programe_id', true);
        $duration = $this->input->post('duration', true);
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'TEST-MODULE-ID:' . $test_module_id,
            'PROGRAME-ID:' . $programe_id,
            'DURATION:' . $duration,
        );
        $catOption = '<option value="">Select Module</option>';
        $Getcategory = json_decode($this->_curlGetData(base_url(GET_PP_CATEGORY), $headers));
        foreach ($Getcategory->error_message->data as $p) {
            $catOption .= '<option value=' . $p->category_id . '>' . $p->category_name . '</option>';
        }
        echo $catOption;
    }
    function GetPrograme()
    {       
        $test_module_id   = $this->input->post('test_module_id', true);            
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'TEST-MODULE-ID:' . $test_module_id,
                
        );
      
        $catOption = '<option value="">Select Program</option>';
        $Getcoursetype= json_decode($this->_curlGetData(base_url(GET_ONL_PGM), $headers));
        $count=count($Getcoursetype->error_message->data);
        foreach ($Getcoursetype->error_message->data as $p) {
            if($count == 1)
            {
                $op_sel="selected";
            }
            else {$op_sel="";}
            $catOption .= '<option value=' . $p->programe_id . ' '.$op_sel.'>' . $p->programe_name.'</option>';
        }
        echo $catOption;
    }
}