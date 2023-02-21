<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Latest_news extends MY_Controller{
    function __construct()
    {
        parent::__construct();  
    }
    function getSearchedNews(){
        $this->load->model('News_model'); 
        $searchText = trim($this->input->post('searchText'));
        $response['newsData']= $this->News_model->getSearchedNews($searchText);        
        $this->load->view('aa-front-end/latest-news-ajax.php', $response);        
    }
    function index($tags=NULL)
    {
       
        $uri = $this->_getURI3();
         if($tags !=NULL)
        {
            $tags=base64_decode($tags);
        } 
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
        );
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $offset = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('latest_news/index?');
        $headers1 = array(
            'API-KEY:' . WOSA_API_KEY,
            'NEWS_TAGS:' . $tags,
            'LIMIT:' .RECORDS_PER_PAGE,
            'OFFSET:'.$offset,
        );
        $data['newsData']=json_decode($this->_curlGetData(base_url(GET_All_NEWS_DATA_URL), $headers1));
        $headers1_count = array(
            'API-KEY:' . WOSA_API_KEY,
            'NEWS_TAGS:' . $tags,
            'OFFSET:'.$offset,
        );
        //$data['callfromview'] = $this;
        $data['countnewsData']=json_decode($this->_curlGetData(base_url(GET_All_NEWS_DATA_URL), $headers1_count));
        $config['total_rows'] = count($data['countnewsData']->error_message->data);
        $this->pagination->initialize($config);
        $data['title'] = 'Latest news';
        $data['serviceData']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
        $data['pinnedNewsData']=json_decode($this->_curlGetData(base_url(GET_PINNED_NEWS_DATA_URL), $headers1));
        $data['uri'] = $uri;
        $data['newsTag']=json_decode($this->_curlGetData(base_url(GET_NEWS_TAGS_DATA_URL), $headers));
        $data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/latest-news',$data);
        $this->load->view('aa-front-end/includes/footer');
    }   
    function post($id){
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
