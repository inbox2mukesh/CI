<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Student_testimonial extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();    
    }

    function index()
    {  
        $data['segment'] = $this->_getURI();
        $data['title'] = 'Student Testimonials';
        $data['title1'] = 'Student';
        $data['title2'] = ' Testimonials';
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        ); 
         /*---------COMMON API CALL FOR HEADER-----*/
        //get complain subject list
        $data['complaintSubject'] = json_decode($this->_curlGetData(base_url(GET_COMPLAINT_SUBJECT), $headers));
        //get offer marquee
        $data['Offers'] = json_decode($this->_curlGetData(base_url(GET_OFFERS_URL), $headers));
        //get country code list
        $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
         //get feedback branch dropdown option list
        $data['GET_GOOGLE_FEEDBACK_BRANCH'] = json_decode($this->_curlGetData(base_url(GET_GOOGLE_FEEDBACK_BRANCH), $headers));
        //get feedback branch dropdown option list
        $data['FEEDBACK_TOPIC'] = json_decode($this->_curlGetData(base_url(GET_FEEDBACK_TOPIC_URL), $headers));
         $data['mPopupData']=json_decode($this->_curlGetData(base_url(GET_MPOPUP_URL), $headers));
        /*-------END-COMMON API CALL FOR HEADER------*/
        
        $data['All_TSMT'] = json_decode($this->_curlGetData(base_url(GET_ALL_TESTIMONIALS_URL), $headers));
        $data['TSMT_COURSE'] = json_decode($this->_curlGetData(base_url(GET_TESTIMONIALS_COURSE_URL), $headers));
       // print_r($data['TSMT_COURSE']);
        /*------NOT USED API ----------*/
        //$data['shortBranches'] = $this->_common($headers);
        //feddback url
        //$data['feedbackLink']=json_decode($this->_curlGetData(base_url(GET_FL_URL), $headers));
        /*------ENDS NOT USED API ----------*/
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/student_testimonial');
        $this->load->view('aa-front-end/includes/footer');
    }

    function student_testimonial_text()
    {  
        $data['segment'] = $this->_getURI();
        $data['title'] = 'Student Testimonials';
        $data['title1'] = 'Student';
        $data['title2'] = ' Testimonials';
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );  
        /*---------COMMON API CALL FOR HEADER-----*/
        //get complain subject list
        $data['complaintSubject'] = json_decode($this->_curlGetData(base_url(GET_COMPLAINT_SUBJECT), $headers));
        //get offer marquee
        $data['Offers'] = json_decode($this->_curlGetData(base_url(GET_OFFERS_URL), $headers));
        //get country code list
        $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
         //get feedback branch dropdown option list
        $data['GET_GOOGLE_FEEDBACK_BRANCH'] = json_decode($this->_curlGetData(base_url(GET_GOOGLE_FEEDBACK_BRANCH), $headers));
        //get feedback branch dropdown option list
        $data['FEEDBACK_TOPIC'] = json_decode($this->_curlGetData(base_url(GET_FEEDBACK_TOPIC_URL), $headers));
         $data['mPopupData']=json_decode($this->_curlGetData(base_url(GET_MPOPUP_URL), $headers));
        /*-------END-COMMON API CALL FOR HEADER------*/        
        $data['All_TXT_TSMT'] = json_decode($this->_curlGetData(base_url(GET_TEXTUAL_TESTIMONIAL_LONG), $headers));
              
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/student_testimonial_text');
        $this->load->view('aa-front-end/includes/footer');
    }

    function searchTestimonial()
     {
        $testtype_select   = $this->input->post('testtype_select', true);
        $testimonial_select   = $this->input->post('testimonial_select', true);
        $headers = array(
        'API-KEY:'.WOSA_API_KEY,       
        'TEST-TYPE:'.$testtype_select,  
        'SEARCH-TEXT:'.$testimonial_select               
        );
       $data['All_TSMT'] = json_decode($this->_curlGetData(base_url(TESTIMONIAL_FILTER), $headers)); 
        $this->load->view('aa-front-end/student_testimonial_ajax',$data);
    }
    
}
