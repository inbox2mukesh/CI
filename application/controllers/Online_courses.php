<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Online_courses extends MY_Controller
{
    function __construct()
    {
        parent::__construct();            
    }
    function index()
    {
        //$data['segment'] = $this->_getURI();
        $data['title'] = 'Online Class Courses';
        $data['title1'] = 'Online Class';
        $data['title2'] = ' Courses';
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'COUNTRY-ID:' . DEFAULT_COUNTRY,
            'LIMIT:' .LOAD_MORE_LIMIT_8,
            'OFFSET:0',
        );
        /*---------COMMON API CALL FOR HEADER-----*/ 
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        //get country code list
        $data['countryCode'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        /*-------END-COMMON API CALL FOR HEADER------*/
        $data['allOnlineCourseTestModule'] = json_decode($this->_curlGetData(base_url(GET_ONN_COURSE), $headers));
        $data['allOnlineCoursePgm'] = json_decode($this->_curlGetData(base_url(GET_ONN_PGM), $headers));
        $data['allOnlineCourseDuration'] = json_decode($this->_curlGetData(base_url(GET_ONN_COURSE_DURATION), $headers));
        $data['allOnlineCourseCategory'] = json_decode($this->_curlGetData(base_url(GET_ONN_COURSE_MODULE), $headers));       
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));        
        $data['OnlinePack'] = json_decode($this->_curlGetData(base_url(GET_ONLINE_PACK), $headers));
       
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'COUNTRY-ID:' . DEFAULT_COUNTRY,
            'LIMIT:0',
            'OFFSET:0',
        );
        $data['OnlinePackCount'] = json_decode($this->_curlGetData(base_url(GET_ONLINE_PACK_COUNT), $headers));       
        $this->load->view('aa-front-end/includes/header', $data);
        $this->load->view('aa-front-end/online_courses');
        $this->load->view('aa-front-end/includes/footer');
    }
    function ajax_loadmore_onlinepack()
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
        $data['countryCode'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['OnlinePack'] = json_decode($this->_curlGetData(base_url(GET_ONLINE_PACK), $headers));
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
        $data['OnlinePackCount'] = json_decode($this->_curlGetData(base_url(GET_ONLINE_PACK_COUNT), $headers_a)); 
        ob_start();
        $this->load->view('aa-front-end/ajax_online_course_content', $data);
        $abc["html"] = ob_get_clean();
        $abc["count"] =  $data['OnlinePackCount'];
        echo json_encode($abc);
    }
   

    function GetOnlinePack()
    {
        
        $offset=0;
        $test_module_id   = $this->input->post('test_module_id', true);
        $programe_id = $this->input->post('programe_id', true);       
        $category_id = $this->input->post('category_id', true);
        $duration = $this->input->post('duration', true);
        $course_type = $this->input->post('course_type', true);
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'COUNTRY-ID:' . DEFAULT_COUNTRY,
            'LIMIT:' .LOAD_MORE_LIMIT_8,
            'OFFSET:'.$offset,
            'TEST-MODULE-ID:' . $test_module_id,
            'PROGRAME-ID:' . $programe_id,
            'CATEGORY-ID:' . $category_id,
            'DURATION:' . $duration,
            'COURSE-TYPE:' . $course_type,
        );
        $data['countryCode'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $data['OnlinePack'] = json_decode($this->_curlGetData(base_url(GET_ONLINE_PACK), $headers));
        
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
            'COURSE-TYPE:' . $course_type,
            
        );
        $data['OnlinePackCount'] = json_decode($this->_curlGetData(base_url(GET_ONLINE_PACK_COUNT), $headers_a));
       
      
        ob_start();
        $this->load->view('aa-front-end/ajax_online_course_content', $data);
        $abc["html"] = ob_get_clean();
        $abc["count"] =  $data['OnlinePackCount'];
        echo json_encode($abc);
    }
    function GetDuation()
    {
        $test_module_id = $this->input->post('test_module_id', true);
        $programe_id = $this->input->post('programe_id', true);
        $category_id = $this->input->post('category_id', true);
        $course_type = $this->input->post('course_type', true); 
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'TEST-MODULE-ID:' . $test_module_id, 
            'PROGRAME-ID:' . $programe_id,           
            'CATEGORY-ID:' . $category_id,           
            'COURSE-ID:' . $course_type,           
            'COUNTRY-ID:' . DEFAULT_COUNTRY,
        );
        $data['allOnlineCourseDuration'] = json_decode($this->_curlGetData(base_url(GET_ONN_COURSE_DURATION), $headers));
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
        $Getcategory = json_decode($this->_curlGetData(base_url(GET_ONN_COURSE_MODULE), $headers));
        foreach ($Getcategory->error_message->data as $p) {
            $catOption .= '<option value=' . $p->category_id . '>' . $p->category_name . '</option>';
        }
        echo $catOption;
    }
    
    function GetPackageBatch()
    {
        $packid   = $this->input->post('packid', true);
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'PACKAGE-ID:' . $packid,
        );
        $data['PackBatch'] = json_decode($this->_curlGetData(base_url(GET_PACKPAGE_BATCH), $headers));
        $data['count_PackBatch']=count($data['PackBatch']->error_message->data);
        $data['package_id']=$packid;
        $this->load->view('aa-front-end/ajax_batch_list.php', $data);
    }
    
    function GetPackageSchedule()
    {
        $packid   = $this->input->post('packid', true);
        $branchid   = $this->input->post('branchid', true);
        $module_id   = $this->input->post('module_id', true);
        $programe_id   = $this->input->post('programe_id', true);
        $center_id   = $this->input->post('center_id', true);
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'PACKAGE-ID:' . $packid,
            'TEST-MODULE-ID:' . $module_id,
            'PROGRAME-ID:' . $programe_id,
            'CENTER-ID:' . $center_id,
            'BATCH-ID:' . $branchid,
        );
        $class_sch = json_decode($this->_curlGetData(base_url(GET_CLASSROOM_SCHEDULE), $headers));
        $class_sch->error_message->data->dateTime;
        if ($class_sch->error_message->data->dateTime != "") {
            $date = date_create($class_sch->error_message->data->dateTime);
            echo "<i class='fa fa-info-circle mr-5 text-red'></i>Next Live class on: <span class='mob-break1'></span><span class='font-weight-600 text-blue'>" . date_format($date, "d M Y \a\\t\ H:i A").'<span>';
        } else {
            echo "";
        }
    }

    function resendStuOTP()
    {
        /*1. otp update
            2. send otp
            3.otp pop open  
        */
      
        $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'STUDENT-ID:'.$_SESSION['lastId_std'],  
            'SEND-EMAIL-FLAG:1',            
            );               
            //  
            $response1= json_decode($this->_curPostData(base_url(UPDATE_OTP), $headers, $params));
            if($response1->error_message->success==1)
            {
                //opt send success
                //open otp popup
                $_SESSION['lastId_std'] = $_SESSION['lastId_std'];
                $_SESSION['actionFor'] = "booking"; // booking=online,offline,practice,reality test booking
                $msg = '';
                header('Content-Type: application/json');
                $response2 = ['msg'=>$msg, 'status'=>'true'];
                echo json_encode($response2);
            }
            else 
            {
                    //error....opt not send
                unset($_SESSION['lastId_std']);
                unset($_SESSION['actionFor']);
                header('Content-Type: application/json');
                $opterror="Error...Try again";
                $msg = '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>FAILED:</strong> '.$opterror.' <a href="#" class="alert-link"></a>.
                </div>';
                $response2 = ['msg'=>$msg, 'status'=>'false'];
                echo json_encode($response2);  
            }
    }
    function GetCourseType()
    {       
        $test_module_id   = $this->input->post('test_module_id', true);
        $programe_id = $this->input->post('programe_id', true);        
        $category_id = $this->input->post('category_id', true);        
        $headers = array(
            'API-KEY:' . WOSA_API_KEY,
            'TEST-MODULE-ID:' . $test_module_id,
            'PROGRAME-ID:' . $programe_id,          
            'CATEGORY-ID:' . $category_id,          
        );
        $catOption = '<option value="">Select Course Type</option>';
        $Getcoursetype= json_decode($this->_curlGetData(base_url(GET_ONN_COURSE_TYPE), $headers));
        foreach ($Getcoursetype->error_message->data as $p) {
            $catOption .= '<option value=' . $p->id . '>' . $p->course_timing . '</option>';
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