<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Offline_courses extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();     
    }

    function index()
    {        
        $data['segment'] = $this->_getURI();
        $data['title'] = 'Inhouse Courses';
        $data['title1'] = 'Inhouse';
        $data['title2'] = ' Courses';
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        ); 


         /*---------COMMON API CALL FOR HEADER-----*/
          $data['allcountry']= json_decode($this->_curlGetData(base_url(GET_CNT_URL), $headers)); 
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
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,             
            'COUNTRY-ID:'.$_SESSION['active_country'],
        );
        $data['allOfflineCourseBranch']=json_decode($this->_curlGetData(base_url(GET_OFF_BRANCH), $headers));
        $data['allOfflineCourseTestModule']=json_decode($this->_curlGetData(base_url(GET_OFF_COURSE), $headers));
        $data['allOfflineCoursePgm']=json_decode($this->_curlGetData(base_url(GET_OFF_PGM), $headers)); 
        $data['allOfflineCourseDuration']=json_decode($this->_curlGetData(base_url(GET_OFF_COURSE_DURATION), $headers));
        $data['allOfflineCourseCategory']=json_decode($this->_curlGetData(base_url(GET_OFF_COURSE_MODULE), $headers));
       
        $data['OfflinePack']=json_decode($this->_curlGetData(base_url(GET_OFFLINE_PACK),$headers));
       
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/offline_courses');
        $this->load->view('aa-front-end/includes/footer');

    }

    function Getcategory(){

        $test_module_id   = $this->input->post('test_module_id', true);
        $programe_id = $this->input->post('programe_id', true);
        $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'TEST-MODULE-ID:'.$test_module_id,
            'PROGRAME-ID:'.$programe_id,
        );
        $catOption ='<option value="">All Module</option>';
        $Getcategory=json_decode($this->_curlGetData(base_url(GET_OFF_COURSE_MODULE),$headers));
        foreach ($Getcategory->error_message->data as $p){            
            $catOption .= '<option value='.$p->category_id.'>'.$p->category_name.'</option>';
        }
        echo $catOption;
    }

    function GetOfflinePack(){

        $center_id   = $this->input->post('center_id', true);
        $test_module_id   = $this->input->post('test_module_id', true);
        $programe_id = $this->input->post('programe_id', true);
        $category_id = $this->input->post('category_id', true);
        $duration = $this->input->post('duration', true);
        $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'CENTER-ID:'.$center_id,
            'TEST-MODULE-ID:'.$test_module_id,
            'PROGRAME-ID:'.$programe_id,  
            'CATEGORY-ID:'.$category_id,
            'DURATION:'.$duration,
             'COUNTRY-ID:'.$_SESSION['active_country'],
        );
          $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['OfflinePack']=json_decode($this->_curlGetData(base_url(GET_OFFLINE_PACK),$headers));
        /*foreach ($data['OfflinePack']->error_message->data as $p){

            $img=site_url('resources-f/images/courses/course-1.jpg');
            $test_module_name = $p->test_module_name;
            if($test_module_name==IELTS_CD or $test_module_name==IELTS){
                $programe_name = ' | '.$p->programe_name;
            }else{
                $programe_name='';
            }
            $package_name=$p->package_name;
            $category_name=$p->category_name;
            if($category_name){
                $category_name= $category_name.' '.'(Single)';
            }else{
                $category_name='All (LRWS)';
            }

            if($p->amount==$p->discounted_amount)
            {
                 $price1=$p->amount;
                $price2=$p->amount;
                $flag=0;
                $amount = '<span> Price <ins><span class="font-weight-400 price"> '.$p->amount.'</span></ins></span>';
            }elseif($p->amount>$p->discounted_amount)
            {
                $flag=1;
                 $price1=$p->amount;
                $price2=$p->discounted_amount;
                $amount = '<span> Price: <ins><span class="font-weight-400 price"><strike>'.$p->amount.'</strike></span></ins></span><br/>
                <span> Offer Price: <ins><span class="font-weight-400 price">'.$p->discounted_amount.'</span></ins></span>';
            }else{
$flag=0;
            }
           
              $response .= '<div class="grid-card-container mt-10">
                            <div class="grid-card">
                                <div class="service-block bg-white mb-20">
                                    <a href="#" data-toggle="modal" data-target="#exampleModal" data-keyboard="false" data-backdrop="static">
                                        <div class="thumb"> <img alt="featured project" src="'.$img.'" class="img-responsive img-fullwidth"> <span class="title">'.$package_name.'</span> </div>
                                        <div class="content clearfix font-14 font-weight-500">
                                            <div class="disc">
                                                <h3>'.$test_module_name.$programe_name.'</h3>
                                                <p><span class="font-weight-600">Module:</span> <span class="font-12">'.$category_name.'</span> </p>
                                                <p><span class="font-weight-600">Duration:</span> '.$p->duration.' Days</p>';
                                                if($flag ==1)
                                                {
                                            $response .= '<p><span class="font-weight-600"> Price: </span> Rs. <strike>'.$price1.'</strike></p>';
                                        }
                                            $response .= '</div>
                                            <div class="ftr-btm text-center"> <span class="more-info pull-left">More Info</span> <span class="purchase font-weight-600 pull-right">Buy Now: <span class="text-red">Rs</span> <span class="font-16 text-red">'.$price2.'</span> </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> ';
        }
       echo $response;*/
        $this->load->view('aa-front-end/ajax_offline_course_content',$data);
    }   
    
}
