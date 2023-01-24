<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class News_article extends MY_Controller{
    
    function __construct(){
        parent::__construct();        
    }
    
    function index($id){
        //$id = $this->auto_mydecryption($id);   
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
            'NEWS-ID:'.$id,   
        );
        //$data['callfromview'] = $this;
        $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));      
        $data['title'] = 'News Article';
        $data['serviceData']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));      
        $data['serviceDataAll']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));
        $data['newsArticleData']=json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_BY_ID_URL), $headers));
        $data['pinnedNewsData']=json_decode($this->_curlGetData(base_url(GET_PINNED_NEWS_DATA_URL), $headers));
        $data['newsTag'] = json_decode($this->_curlGetData(base_url(GET_NEWS_TAGS_DATA_URL), $headers));
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/news-article',$data);
        $this->load->view('aa-front-end/includes/footer');
    }   
    
}
