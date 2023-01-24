<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Student_reality_test_video extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();    
    }

    function index()
    {  
        $data['segment'] = $this->_getURI();
        $data['title'] = 'Reality Test video';
        $data['title1'] = 'Reality Test';
        $data['title2'] = ' Video';
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        ); 
        //feddback url
       // $data['feedbackLink']=json_decode($this->_curlGetData(base_url(GET_FL_URL), $headers));
        $data['complaintSubject'] = json_decode($this->_curlGetData(base_url(GET_COMPLAINT_SUBJECT), $headers));
        $data['Offers']=json_decode($this->_curlGetData(base_url(GET_OFFERS_URL), $headers));
        $data['shortBranches'] = $this->_common($headers);
        $data['All_TSMT'] = json_decode($this->_curlGetData(base_url(GET_ALL_RT_VIDEO), $headers));
        //print_r($data['All_TSMT']);
        $data['allCnt'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_URL), $headers));
         $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
          $data['GET_GOOGLE_FEEDBACK_BRANCH'] = json_decode($this->_curlGetData(base_url(GET_GOOGLE_FEEDBACK_BRANCH), $headers));    
        $data['FEEDBACK_TOPIC'] = json_decode($this->_curlGetData(base_url(GET_FEEDBACK_TOPIC_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/student_testimonial');
        $this->load->view('aa-front-end/includes/footer');
    }

    


   
    
}
