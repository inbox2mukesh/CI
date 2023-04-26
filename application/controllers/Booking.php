<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          
 *
 **/
require_once APPPATH . '/libraries/traits/fourmoduleTrait.php';
class Booking extends MY_Controller{
    use fourmoduleTrait;
    function __construct(){
        parent::__construct();   
        $this->load->library("session");

        $this->load->helper(['url','foumodule_api']);

        require_once('application/libraries/stripe-php/init.php');
        $this->headers_fourmodule= array('authorization:'.FOURMODULE_KEY);   
    }

    function index(){        
        redirect('/');
    }
    /*-----check booking for new/login user-----------*/
    function check_booking(){                  
       
        if(isset($_SESSION['lastId_std'])){
            unset($_SESSION['lastId_std']);
        }
        if(isset($_SESSION['actionFor'])){
            unset($_SESSION['actionFor']);
        }
        if(isset($_SESSION['book_packid'])){
            unset($_SESSION['book_packid']);
        }
        if(isset($_SESSION['book_pack_type'])){
            unset($_SESSION['book_pack_type']);
        }
        $package_id = $this->input->post('package_id', TRUE);        
        if(empty($package_id)){
            redirect('/');
            die();
        }
        $_SESSION['book_packid']= $package_id;
        $_SESSION['book_pack_type']= $this->input->post('pack_type', TRUE);       
        $_SESSION['front']= $base64_front;
        $_SESSION['back']= $base64_back;
        $_SESSION['type']= $type;
        $_SESSION['pack_batch_id']= $this->input->post('batch_id', TRUE);
        $pdatep=date_create($this->input->post('packstartdate'));
        $pdate=date_format($pdatep,"d-m-Y");
        $_SESSION['packstartdate']= $pdate;
        $_SESSION['pack_country_id']= $this->input->post('pack_country_id', TRUE);
        $_SESSION['duration_type']= $this->input->post('duration_type', TRUE);
        
        //check student is already logged in or not
        if($this->session->userdata('student_login_data')){
            // if yes  then direclty redirect to checkout page 
            header('Content-Type: application/json');
            $response = ['msg'=>'redirectToCheckout', 'status'=>3];
            echo json_encode($response);
        }else{
            //if No then start check all parametres
            $params = array(                             
                'fname' => $this->input->post('online_fname', TRUE), 
                'lname' => $this->input->post('online_lname', TRUE),               
                'country_code' => $this->input->post('online_country_code', TRUE),
                'mobile'=> $this->input->post('onlinec_mobile', TRUE),
                'email' => $this->input->post('online_email', TRUE),
                'dob'=> $this->input->post('dob', TRUE),
                /*'int_country'=> $this->input->post('int_country'), 
                'qualification'=> $this->input->post('qualification'), 
                'document_type'=> $this->input->post('document_type'),
                'front'=> $this->input->post('front'), 
                'back'=> $this->input->post('back'),   
                'programe_id'=> $this->input->post('programe_id'),
                'center_id'=> $this->input->post('center_id'),*/
            );
            $headers = array(
                'API-KEY:'.WOSA_API_KEY, 
                'MOBILE:'.$this->input->post('onlinec_mobile', TRUE), 
                'EMAIL:'.$this->input->post('online_email', TRUE),             
            );
           
           // check student mobile no/email is exist in db or not
            $response= json_decode($this->_curlGetData(base_url(GET_STUDENT_EXISTENCE_URL), $headers));
           
            /* CASE For student booking*/
            // CASE 1 : Fresh user, call registration api once registration process done then redirect to checkout page
            if($response->error_message->success==0 AND $response->error_message->message == 'fresh'){   
                $country_code= $this->input->post('online_country_code', TRUE);
                $iso3_code=explode('|',$country_code);          
                //call register api
                $params = array(                             
                    'fname' => $this->input->post('online_fname', TRUE), 
                    'lname' => $this->input->post('online_lname', TRUE),               
                    'country_code' => $iso3_code[0],
                    'country_iso3_code' => $iso3_code[1],
                    'mobile'=> $this->input->post('onlinec_mobile', TRUE),
                    'email' => $this->input->post('online_email', TRUE),
                    'dob'=> $this->input->post('dob', TRUE),
                    'test_module_id'=> $this->input->post('test_module_id', TRUE),
                    'programe_id'=> $this->input->post('programe_id', TRUE),
                    'center_id'=>$this->input->post('center_id', TRUE),                                    
                    'pack_type'=> $_SESSION['book_pack_type'],
                    'pack_type'=> $_SESSION['book_pack_type'],                       
                    /*'int_country'=> $this->input->post('int_country'), 
                    'qualification'=> $this->input->post('qualification'), 
                    'document_type'=> $this->input->post('document_type'),
                    'front'=> $this->input->post('front'), 
                    'back'=> $this->input->post('back'),   
                    'programe_id'=> $this->input->post('programe_id'),
                    'center_id'=> $this->input->post('center_id'),*/                             
                );            
                $response= json_decode($this->_curPostData(base_url(SUBMIT_STD_URL), $headers, $params));
                
                if($response->error_message->success==1){
                    $_SESSION['lastId_std'] = $response->error_message->data;
                    $_SESSION['UID'] = $response->error_message->UID;
                    $_SESSION['actionFor'] = "booking"; // booking=online,offline,practice,reality test booking
                    $msg = '<div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>SUCCESS:</strong> '.$response->error_message->message.' <a href="#" class="alert-link"></a>.
                    </div>';
                    header('Content-Type: application/json');
                    $response = ['msg'=>$msg, 'status'=>'true'];
                    echo json_encode($response);                
                }else{
                    unset($_SESSION['lastId_std']);
                    unset($_SESSION['actionFor']);
                    header('Content-Type: application/json');
                    $msg = '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>FAILED:</strong> '.$response->error_message->message.' <a href="#" class="alert-link"></a>.
                    </div>';
                    $response = ['msg'=>$msg, 'status'=>'false'];
                    echo json_encode($response);              
                }
            }
            // CASE 2 : existing user having active=1 and is_otp_verified=1, then  call login process then redirect to checkout page
            elseif($response->error_message->message=="existing" AND $response->error_message->active == 1 AND $response->error_message->is_otp_verified == 1){            
                $_SESSION['lastId_std'] = $response->error_message->student_id;
                  $_SESSION['actionFor'] = "booking"; // booking=online,offline,practice,reality test booking
                //echo "existing";
                header('Content-Type: application/json');
                $response = ['msg'=>"existing", 'status'=>2];
                echo json_encode($response);
            }
            // CASE 3 : existing user having active=0 and is_otp_verified=0, then  call opt verification process then redirect to checkout page    
            elseif($response->error_message->message=="existing" AND $response->error_message->active == 0 AND $response->error_message->is_otp_verified == 0){
                /*1. otp update
                  2. send otp
                  3.otp pop open  
                */ 
                $headers = array(
                    'API-KEY:'.WOSA_API_KEY, 
                    'STUDENT-ID:'.$response->error_message->student_id,
                    'SEND-EMAIL-FLAG:1',              
                );                
                $response1= json_decode($this->_curPostData(base_url(UPDATE_OTP), $headers, $params));
                if($response1->error_message->success==1){
                    //opt send success
                    //open otp popup
                    $_SESSION['lastId_std'] = $response->error_message->student_id;
                    $_SESSION['actionFor'] = "booking"; // booking=online,offline,practice,reality test booking
                    $msg = '';
                    header('Content-Type: application/json');
                    $response2 = ['msg'=>$msg, 'status'=>'true'];
                    echo json_encode($response2);
                }else{
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
            // CASE 4 : for blocked user 
            elseif($response->error_message->message=="existing" AND $response->error_message->active == 0 AND $response->error_message->is_otp_verified == 1){
                unset($_SESSION['lastId_std']);
                unset($_SESSION['actionFor']);
                header('Content-Type: application/json');
                $opterror='Dear user you are blocked from the system. Please contact to our admin or  <a href="#" class="anc_clickhere" onclick="anc_clickhere('.$package_id.')" data-toggle="modal" data-target="#modal-complaint">click here</a> to raise complaint ';
                $msg = '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>FAILED:</strong> '.$opterror.' <a href="#" class="alert-link"></a>.
                </div>';
                $response2 = ['msg'=>$msg, 'status'=>'false'];
                echo json_encode($response2);

            }
        }          
    }// ends----check_booking()
    // ends----check_booking()
    
    /*apply promotion code */
    function checkout(){

        if(isset($_SESSION['checkout_token_no'])){
            unset($_SESSION['checkout_token_no']);
        }
        $_SESSION['checkout_token_no']='CT_'. $this->_getorderTokens('12');
       // echo $_SESSION['fourmodule_identify_api'];
        //echo $_SESSION['lastId_std'];
        if(isset($this->session->userdata('student_login_data')->id)){
            $_SESSION['lastId_std']=$this->session->userdata('student_login_data')->id;
        }
        if(!isset($_SESSION['lastId_std'])){
            redirect('/');
            die();
        }
        
        if(!isset($_SESSION['book_packid'])){
           redirect('/');
            die();
        }
        $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'PACK-TYPE:'.$_SESSION['book_pack_type'],
            'PACKAGE-ID:'.$_SESSION['book_packid'],             
        );       
        
        $data['title'] = 'Checkout';    
        $data['packdetail']= json_decode($this->_curlGetData(base_url(GET_PACK_DETAILS_URL), $headers));
        if(empty($data['packdetail'])){
            redirect('/');
            die();
        }
        //echo $_SESSION['book_pack_type'];
        // fourmodule api checking 
        if($_SESSION['book_pack_type'] == "practice" || $_SESSION['book_pack_type'] == "online")
        {     
            if(isset($_SESSION['fourmodule_pack_id']))       
            {
                unset($_SESSION['fourmodule_pack_id']);
            }
            $headers_fourmodule = array(
            'Authorization:'.FOURMODULE_KEY,                                      
            );        

            if($this->session->userdata('student_login_data')->country_code == "+91")
            {
                $set_pack_type=0; // for india
            }
            else {
                $set_pack_type=1; // for other countries
            }
            //fourmodule pack id is set
            
             
            
           // echo $_SESSION['fourmodule_pack_id'].'pp';
           // die();
            // $params_list_pack = array( 'api'=>"enrolment",'action'=>"pack_list",'centre_id'=>FOURMODULE_ONL_BRANCH_ID,'pack_type'=>$set_pack_type,'domain_id'=>FOURMODULE_DOMAIN_ID); 
            // $response=$this->_curPostData_fourmodules(FOURMODULE_URL, $headers_fourmodule, $params_list_pack);           
            ///*identify which api is call based on pack info            
            // $headers1 = array(
            // 'API-KEY:'.WOSA_API_KEY, 
            // 'STUDENT-ID:'.$_SESSION['lastId_std'],                           
            // 'TEST-MODULE-ID:'.$data['packdetail']->error_message->data->test_module_id,            
            // 'PROGRAME-ID:'.$data['packdetail']->error_message->data->programe_id,            
            // );
            $this->load->model(['Test_module_model','Programe_master_model']);
            $getTestName = $this->Test_module_model->getTestName($data['packdetail']->error_message->data->test_module_id);
            $getProgramName = $this->Programe_master_model->getProgramName($data['packdetail']->error_message->data->programe_id);
            $fetch_fourmodule_pack_id=fetch_fourmodule_pack_id($getTestName['test_module_name'],$getProgramName['programe_name'],$set_pack_type);
            $_SESSION['fourmodule_pack_id']=$fetch_fourmodule_pack_id;
            $params = array(                          
                "pack_id"=>$fetch_fourmodule_pack_id,            
            );    
            $headers1 = array(
                'username'=>$this->session->userdata('student_login_data')->UID,
                'action'=>'checkUser',            
                );
            $param_base = $this->_fourmoduleapi__bind_params();
            $params_fourmodule =array_merge($param_base,$headers1);
            $identify_api= $this->_identify_fourmoduleapi($params_fourmodule,$params);
            // $identify_api= json_decode($this->_curlGetData(base_url(IDENTIFY_FOURMODULE_API), $headers1));                
            $_SESSION['fourmodule_identify_api']=$identify_api;
            // 1=Enrollment api 2=Re-Enrollment api 3=Add-program api 
      }
      //---ends-----------  
 
        $headers1 = array(
            'API-KEY:'.WOSA_API_KEY, 
            'STUDENT-ID:'.$_SESSION['lastId_std'],
            'PACK-TYPE:'.$_SESSION['book_pack_type'],
            'PACKAGE-ID:'.$_SESSION['book_packid'],            
        );
        $headers2 = array(
            'API-KEY:'.WOSA_API_KEY,
            'STUDENT-ID:'.$_SESSION['lastId_std'],
        );
        $data['allcountry']= json_decode($this->_curlGetData(base_url(GET_CNT_URL), $headers));
        $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers)); 
        $data['STD_WALLET_HISTORY']=json_decode($this->_curlGetData(base_url(GET_STD_WALLET_HISTORY), $headers2));
        $data['wallet']=json_decode($this->_curlGetData(base_url(GET_WALLET), $headers2));
      
        // all academic and visa service title:----need to create api 
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers)); 
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        // all academic service title:----need to create api 
        $data['serviceDataAll'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));
        $headers3 = array(
            'API-KEY:'.WOSA_API_KEY,   
            'CONTENT-TYPE:'.'tcc', //tc=term & condition
        );         
        $data['term_cond'] = json_decode($this->_curlGetData(base_url(GET_CONTENTS), $headers3)); 
       // print_r($data['term_cond'] ); 
       
       /* ---checkout page tracking ---------- */
       $headers_checkout_tracking = array(
        'API-KEY:'.WOSA_API_KEY,          
        );
      
        $params_checkout_tracking = array(                             
            'student_id'=>$this->session->userdata('student_login_data')->id,  
            'checkout_token_no'=>$_SESSION['checkout_token_no'],  
            'page'=>"checkout",  
            'active'=>1, 
            'created'=>date("d-m-Y h:i:s"),             
            'modified'=>date("d-m-Y h:i:s"),             
            );     
         $response= json_decode($this->_curPostData(base_url(CHECKOUT_TRACKING_URL), $headers_checkout_tracking, $params_checkout_tracking));  
        /* ----ends---- */
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/checkout');
        $this->load->view('aa-front-end/includes/footer');
    }



 /*apply promotion code */
   /*  function apply_promocode()
    {
        $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'STUDENT-ID:'.$_SESSION['lastId_std'],
            'PACK-TYPE:'.$_SESSION['book_pack_type'],
            'PACKAGE-ID:'.$_SESSION['book_packid'], 
            'PROMOCODE-ID:'.$this->input->post('promocodeid'),             
        );
        $params='';
       $response=json_decode($this->_curPostData(base_url(APPLY_PROMOCODES), $headers, $params));      
       header('Content-Type: application/json');
                  $response = ['msg'=>$response->error_message->message, 'status'=>$response->error_message->success,'discount'=>$response->error_message->discount];
        echo json_encode($response);
    } */
    /*apply promotion code */
   /*  function apply_bulk_promocode()
    {
        $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'STUDENT-ID:'.$_SESSION['lastId_std'],
            'PACK-TYPE:'.$_SESSION['book_pack_type'],
            'PACKAGE-ID:'.$_SESSION['book_packid'], 
            'PROMOCODE:'.$this->input->post('entered_promocode'),             
        );
        $params='';
       $response=json_decode($this->_curPostData(base_url(APPLY_BULK_PROMOCODES), $headers, $params));      
       header('Content-Type: application/json');
                  $response = ['msg'=>$response->error_message->message, 'status'=>$response->error_message->success,'discount'=>$response->error_message->discount,'bulk_id'=>$response->error_message->bulk_id,'promoCodeId'=>$response->error_message->promoCodeId];
        echo json_encode($response);
    } */
 /*buy pack api call*/
    function post_pack_booking()
    {
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,            
        );   
        $headers1 = array(
            'API-KEY:'.WOSA_API_KEY, 
            'STUDENT-ID:'.$_SESSION['lastId_std'],               
        );          
        $data['STD_INFO']=json_decode($this->_curlGetData(base_url(GET_STD_INFO_URL), $headers1));       
        //for reality test case
        if($_SESSION['book_pack_type'] == "reality test")
        {
            //27
            $transaction_id=rand();
            $currency="INR";
            $status="captured";
            $method="card";
            $params = array(                             
            'student_id'=>$data['STD_INFO']->error_message->data->id,  
            "fname" => $data['STD_INFO']->error_message->data->fname, 
            "lname" => $data['STD_INFO']->error_message->data->lname, 
            "country_code"  => $data['STD_INFO']->error_message->data->country_code, 
            "mobile" => $data['STD_INFO']->error_message->data->mobile, 
            "email"  => $data['STD_INFO']->error_message->data->email,             
            "dob" => $data['STD_INFO']->error_message->data->dob, 
            "package_id" => $_SESSION['book_packid'], 
            "amount_paid" => $this->input->post('payable_amount'), 
            "other_discount" =>  $this->input->post('promocode_amount'), 
            "use_wallet" =>  $this->input->post('wallet_amount_used'), 
            "promoCodeId_val" =>  $this->input->post('promocode_applied_id'), 
            "bulk_id" =>  $this->input->post('bulk_id'), 
            "transaction_id" => $transaction_id,
            "int_country" => $_SESSION['int_country'],
            "qualification" => $_SESSION['qualification'], 
            "document_type" => $_SESSION['document_type'], 
            "front" => $_SESSION['front'], 
            "back" => $_SESSION['back'], 
            "type" => $_SESSION['type'], 
            "time_slots" => $_SESSION['time_slots'],
            "programe_id" =>$_SESSION['programe_id'],  
            "center_id" => $_SESSION['center_id'],
            "pack_type"  => $_SESSION['book_pack_type'], 
            "pack_type"  => $_SESSION['book_pack_type'], 
            "currency"=>  $this->input->post('currency_code'),
            "pack_country_id"=>$_SESSION['pack_country_id'],
            "pack_batch_id"=>$_SESSION['pack_batch_id'],  
            "pack_startdate"=>$_SESSION['packstartdate'], 
            "duration_type"=>$_SESSION['duration_type'], 
            "duration"=>$this->input->post('duration'),                               
            "status"=>$status,
            "captured"=> 1,
            "method"=>$method ,
            "promocode"=>$this->input->post('promocode')      
            );     
         $response= json_decode($this->_curPostData(base_url(BUY_REALITY_TEST), $headers, $params)); 
        }
        else  //for other case
        {

            $transaction_id='';           
            $status="initiated";
            $method="";
            $captured = 0;
            $order_id = time().$this->_getorderTokens(6);
            $payment_id ='pay_'.$order_id;
            $params = array(                             
            'student_id'=>$data['STD_INFO']->error_message->data->id,  
            "fname" => $data['STD_INFO']->error_message->data->fname, 
            "lname" => $data['STD_INFO']->error_message->data->lname, 
            "country_code"  => $data['STD_INFO']->error_message->data->country_code, 
            "mobile" => $data['STD_INFO']->error_message->data->mobile, 
            "email"  => $data['STD_INFO']->error_message->data->email, 
            "center_id" => $this->input->post('center_id'), 
            "dob" => $data['STD_INFO']->error_message->data->dob, 
            "package_id" => $_SESSION['book_packid'], 
            "amount_paid" => $this->input->post('payable_amount'), 
            "other_discount" =>  $this->input->post('promocode_amount'), 
            "use_wallet" =>  $this->input->post('wallet_amount_used'), 
            "promoCodeId_val" =>  $this->input->post('promocode_applied_id'), 
            "bulk_id" =>  $this->input->post('bulk_id'), 
            "transaction_id" => $transaction_id, 
            "pack_type"  => $_SESSION['book_pack_type'], 
            "currency"=>  $this->input->post('currency_code'),
            "pack_country_id"=>$_SESSION['pack_country_id'],
            "pack_batch_id"=>$_SESSION['pack_batch_id'],  
            "pack_startdate"=>$_SESSION['packstartdate'], 
            "duration_type"=>$_SESSION['duration_type'],  
            "duration"=>$this->input->post('duration'),
            "status"=>$status,
            "captured"=> $captured,
            "method"=>$method ,           
            "promocode"=>$this->input->post('promocode'), 
            "payment_id"=>$payment_id,      
            "order_id"=>$order_id,      
            "checkout_token_no"=>$_SESSION['checkout_token_no'],      
            );               
            
            $response= json_decode($this->_curPostData(base_url(BUY_PACK), $headers, $params));
        }      
        if($response->error_message->success==1)
        {
             $_SESSION['current_student_package_id']=$response->error_message->student_package_id;
             $_SESSION['current_student_order_id']=$order_id;
            $response = ['msg'=>"Successfully", 'status'=>1];//redirect to strip checkout page
            header('Content-Type: application/json');                              
            echo json_encode($response);                   
        }
        else
        {
            header('Content-Type: application/json');// error occur
            $response = ['msg'=>"Error....try again", 'status'=>0];
            echo json_encode($response);
            die();
                   
        }
    }      
    
    
    function make_payment()
    {   
       if($this->session->userdata('student_login_data')->zip_code =="" || $this->session->userdata('student_login_data')->country_name =="" || $this->session->userdata('student_login_data')->state_name =="" || $this->session->userdata('student_login_data')->city_name =="" || $this->session->userdata('student_login_data')->residential_address =="") 
       {
        $data['address_field_action']=1;

       }  
       else{
        $data['address_field_action']=0;
       }
        if(isset($this->session->userdata('student_login_data')->id))
        {
            $_SESSION['lastId_std']=$this->session->userdata('student_login_data')->id;
        }
          if(!isset($_SESSION['lastId_std']))
        {
            redirect('/');
            die();
        }
        
        if(!isset($_SESSION['book_packid']))
        {
           redirect('/');
            die();
        }
        $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'PACK-TYPE:'.$_SESSION['book_pack_type'],
            'PACKAGE-ID:'.$_SESSION['book_packid'],            
        );
       

        $data['title'] = 'Checkout';    
        $data['packdetail']= json_decode($this->_curlGetData(base_url(GET_PACK_DETAILS_URL), $headers));
        if(empty($data['packdetail']))
        {
            redirect('/');
            die();
        }
      
        $headers2 = array(
            'API-KEY:'.WOSA_API_KEY,
            'STUDENT-ID:'.$_SESSION['lastId_std'],
            );
            $data['allcountry']= json_decode($this->_curlGetData(base_url(GET_CNT_URL), $headers));       
            $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers)); 
        $data['STD_WALLET_HISTORY']=json_decode($this->_curlGetData(base_url(GET_STD_WALLET_HISTORY), $headers2));
        $data['wallet']=json_decode($this->_curlGetData(base_url(GET_WALLET), $headers2));
       
        // all academic and visa service title:----need to create api 
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers)); 
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        // all academic service title:----need to create api 
        $data['serviceDataAll'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));
        $data['allcountry'] = json_decode($this->_curlGetData(base_url(GET_ALL_CNT_URL), $headers));
        $headers_state = array(
            'API-KEY:' . WOSA_API_KEY,
            'COUNTRY-ID:' . $this->session->userdata('student_login_data')->country_id ,
        );
        $data['allstate'] = json_decode($this->_curlGetData(base_url(GET_ALL_STATE_URL), $headers_state));

        $headers_city = array(
            'API-KEY:' . WOSA_API_KEY,
            'STATE-ID:' .$this->session->userdata('student_login_data')->state_id ,
        );
        $data['allcity'] = json_decode($this->_curlGetData(base_url(GET_ALL_CITY_URL), $headers_city));

        $headers3 = array(
            'API-KEY:'.WOSA_API_KEY,   
            'CONTENT-TYPE:'.'tcc', //tc=term & condition
        );         
        $data['term_cond'] = json_decode($this->_curlGetData(base_url(GET_CONTENTS), $headers3)); 

        /* ---checkout page tracking ---------- */
       $headers_checkout_tracking = array(
        'API-KEY:'.WOSA_API_KEY,          
        );
      
        $params_checkout_tracking = array(                             
            'student_id'=>$this->session->userdata('student_login_data')->id,  
            'checkout_token_no'=>$_SESSION['checkout_token_no'],  
            'page'=>"checkout_stripe",  
            'active'=>1, 
            'created'=>date("d-m-Y h:i:s"),             
            'modified'=>date("d-m-Y h:i:s"),          
            );     
         $response= json_decode($this->_curPostData(base_url(CHECKOUT_TRACKING_URL), $headers_checkout_tracking, $params_checkout_tracking));  
        /* ----ends---- */
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/checkout_stripe');
        $this->load->view('aa-front-end/includes/footer');       
    }

    // this function used for handle all payment action and updates
    public function handlePayment()
    {
        ini_set('display_errors', 1);  
        // checking for address field is getting and then need to update address w.r.t student         
        if($this->input->post('address_field_action', TRUE) ==1)
        {
            // here we update the address of the student
            $headers = array(
                'API-KEY:'.WOSA_API_KEY, 
                'STUDENT-ID:'.$this->session->userdata('student_login_data')->id,                  
            );  
            $params = array(                             
            'country_id'=>$this->input->post('country', TRUE),  
            'state_id'=>$this->input->post('state', TRUE),  
            'city_id'=>$this->input->post('city', TRUE),  
            'zip_code'=>$this->input->post('zip_code', TRUE),  
            'residential_address'=>$this->input->post('residential_address', TRUE),            
            ); 
            $response= json_decode($this->_curPostData(base_url(UPDATE_STUDENT_ADDRESS), $headers, $params));
            if($response->error_message->success==1 )
            { 
                $this->session->set_userdata('student_login_data',$response->error_message->data);

                 $params_address = array(                             
                    'line1'=> $response->error_message->data->residential_address,  
                    'postal_code'=>$response->error_message->data->zip_code,  
                    'city'=>$response->error_message->data->city_name,  
                    'state'=>$response->error_message->data->state_name,  
                    'country'=>$response->error_message->data->country_name,            
                    );                     

            }

        }
        else {
            $params_address = array(                             
                'line1'=>$this->session->userdata('student_login_data')->residential_address,  
                'postal_code'=>$this->session->userdata('student_login_data')->zip_code,  
                'city'=>$this->session->userdata('student_login_data')->city_name,  
                'state'=> $this->session->userdata('student_login_data')->state_name,  
                'country'=>$this->session->userdata('student_login_data')->country_name,            
                );  
        }
       
        // create a new stripe payment instance object
        $stripe = new \Stripe\StripeClient($this->config->item('stripe_secret'));
        //payment method create object:Instead of creating a PaymentMethod directly, we recommend using the PaymentIntents API to accept a payment immediately or the SetupIntent API to collect payment method details ahead of a future payment.
      try{
        $paymentMethods_create = $stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
              'number' => $this->input->post('number', TRUE),
              'exp_month' => $this->input->post('exp_month', TRUE),
              'exp_year' => $this->input->post('exp_year', TRUE),
              'cvc' =>$this->input->post('card_cvc', TRUE),
            ],
          ]);  

      }catch (Exception $e){
         /*
            Fail due tp exception error occur            
            update the pack status and other necessary fields 
            active=>2---handle for fail order pack status
           */       
          
          $params = array(
            "active" => 2, 
            "status"=>'failed', 
            "payment_full_response"=>json_encode($e->getMessage()),      
            "email_send_flag"=>1,                                     
            );             
            $update_pack=$this->update_pack($params);  
            if($update_pack) 
            {
               $this->session->set_flashdata('exception_msg', $e->getMessage());                  
               redirect('booking/fail_view'); 
            } 
      }               
     try{
            /*---- fetch package detail and send detail to gateway ----*/
            $headers = array(
                'API-KEY:'.WOSA_API_KEY, 
                'PACK-TYPE:'.$_SESSION['book_pack_type'],
                'PACKAGE-ID:'.$_SESSION['book_packid'],  
            ); 
           $packdetail= json_decode($this->_curlGetData(base_url(GET_PACK_DETAILS_URL), $headers));
            /*
            // create payment:After the PaymentIntent is created, attach a payment method and confirm to continue the payment.            
            .Metadata is useful for storing additional, structured information on an object. For example, you could store your user's corresponding unique identifier from your system on a Stripe Customer object.
            .International payments for services:Every international payment for services is required to have the buyer’s name, billing address and a description of the service being exported.
            */   
           $res_create= $stripe->paymentIntents->create(
          ['amount' => $this->input->post('payable_amount')*100, 'currency' => $this->input->post('currency_code'), 'payment_method_types' => ['card'],'return_url'=>site_url(PAYMENT_STATUS_URL),'confirm'=>true,'payment_method' =>$paymentMethods_create, 'description' => 'online course','receipt_email' => $this->session->userdata('student_login_data')->email, 'shipping' => [
            'name' => $this->session->userdata('student_login_data')->fname.' '. $this->session->userdata('student_login_data')->lname,
            'address' => $params_address, 
          ],'metadata'=>['std_id' =>$this->session->userdata('student_login_data')->id,'std_phone'=>$this->session->userdata('student_login_data')->country_code.' '.$this->session->userdata('student_login_data')->mobile,'std_email'=>$this->session->userdata('student_login_data')->email,
          'std_order_id'=> $_SESSION['current_student_order_id'],
          'std_packagetype'=>ucwords($_SESSION['book_pack_type']),
          'std_package_name'=>$packdetail->error_message->data->package_name,
          'std_package_programe'=>$packdetail->error_message->data->programe_name,
          'std_package_test_module'=>$packdetail->error_message->data->test_module_name,
          'std_package_category'=>$packdetail->error_message->data->category_name,
          'std_package_duration'=>$packdetail->error_message->data->duration.' '. $packdetail->error_message->data->duration_type,
          'std_package_course_timing'=>$packdetail->error_message->data->course_timing,
          //'std_package_desc'=>strip_tags($packdetail->error_message->data->package_desc),
          //commented becoz of lenth issue          
          ]]
        );
        }

        //catch exception
        catch(Exception $e){           
           /*
            Fail due tp exception error occur            
            update the pack status and other necessary fields 
            active=>2---handle for fail order pack status
           */
            $params = array(
                "active" => 2, 
                "status"=>'failed', 
                "payment_full_response"=>json_encode($e->getMessage()),   
                "email_send_flag"=>1,                                        
                );             
                $update_pack=$this->update_pack($params);  
                if($update_pack) 
                {
                   $this->session->set_flashdata('exception_msg', $e->getMessage());                  
                   redirect('booking/fail_view'); 
                } 
        }
        
        //check response for next process
        if($res_create->charges->data[0]['captured'] ==1  && $res_create->charges->data[0]['status'] =="succeeded")
        {  
      
          // 1=Enrollment api   2=Re-Enrollment api 3=Add-program api
          if(isset($_SESSION['fourmodule_identify_api']))
          {
           
           if($_SESSION['fourmodule_identify_api'] == 1)//Enrollment api
           {
                $headers_fourmodule= array(
                'authorization:'.FOURMODULE_KEY,                           
                );  
                $params_fourmodule = array(
                "api" => "enrolment", 
                "action"=>'enrol_student', 
                "centre_id"=>FOURMODULE_ONL_BRANCH_ID, 
                "domain_id"=>FOURMODULE_DOMAIN_ID,        
                "pack_id"=>$_SESSION['fourmodule_pack_id'],                                     
                "name"=>$this->session->userdata('student_login_data')->fname.' '. $this->session->userdata('student_login_data')->lname,                                        
                "token"=>$this->session->userdata('student_login_data')->UID,                                        
                "start_date"=>$packdetail->error_message->data->subscribed_on, 
                "end_date"=>$packdetail->error_message->data->expired_on, 
                "username"=>$this->session->userdata('student_login_data')->UID,
                "password"=>$this->session->userdata('student_login_data')->plain_pwd,                                       
                );                          
                // Call Enrollment apie
               $response_fourmodule= $this->_curPostData_fourmodules(FOURMODULE_URL, $headers_fourmodule, $params_fourmodule);
            }
           else if($_SESSION['fourmodule_identify_api'] == 2)//Re-Enrollment api
           {
                $headers_fourmodule = array(
                'Authorization:'.FOURMODULE_KEY,                                      
                );
                $params_fourmodule = array(
                "api" => "enrolment", 
                "action"=>'Re_enrolment', 
                "centre_id"=>FOURMODULE_ONL_BRANCH_ID, 
                "domain_id"=>FOURMODULE_DOMAIN_ID,        
                "pack_id"=>$_SESSION['fourmodule_pack_id'],                                     
                "name"=>$this->session->userdata('student_login_data')->fname.' '. $this->session->userdata('student_login_data')->lname,                                        
                "token"=>$this->session->userdata('student_login_data')->UID,                                        
                "start_date"=>$packdetail->error_message->data->subscribed_on,                                        
                "end_date"=>$packdetail->error_message->data->expired_on,                                        
                ); 
                $response_fourmodule=$this->_curPostData_fourmodules(FOURMODULE_URL, $headers_fourmodule, $params_fourmodule);
            }
           else {
            $headers_fourmodule = array(
                'Authorization:'.FOURMODULE_KEY,                                      
                );
                $params_fourmodule = array(
                "api" => "enrolment", 
                "action"=>'Add_program', 
                "centre_id"=>FOURMODULE_ONL_BRANCH_ID, 
                "domain_id"=>FOURMODULE_DOMAIN_ID,        
                "pack_id"=>$_SESSION['fourmodule_pack_id'],                                     
                "name"=>$this->session->userdata('student_login_data')->fname.' '. $this->session->userdata('student_login_data')->lname,                                        
                "token"=>$this->session->userdata('student_login_data')->UID,                                        
                "start_date"=>$packdetail->error_message->data->subscribed_on,                                        
                "end_date"=>$packdetail->error_message->data->expired_on,                                        
                ); 
                $response_fourmodule=$this->_curPostData_fourmodules(FOURMODULE_URL, $headers_fourmodule, $params_fourmodule); 
           }
            //print_r($response_fourmodule);

            $response_fourmodule_p=json_decode($response_fourmodule);
            $response_fourmodule_success_status=$response_fourmodule_p->success;
        } else {
            $response_fourmodule_p='';
            $response_fourmodule_success_status='0';
            $_SESSION['fourmodule_identify_api']=0;
        }         
         $params_fourmoduleh=json_encode($params_fourmodule);
            /*-----
            Success payment 
            STATUS:succeeded=Customer completed payment on your checkout page
            ------*/        
           /* call api to get student pack start end date */          
            $headers = array(
                'API-KEY:'.WOSA_API_KEY, 
                'STUDENT-PACK-ID:'. $_SESSION['current_student_package_id'],             
            );
            $packdetail= json_decode($this->_curlGetData(base_url(STU_PACK_START_DATE), $headers));             
            $packdetail->error_message->data->subscribed_on_str;
            $today=date("d-m-Y");
            $today=strtotime($today);
             // check for active pack status it should be 0 or 1 on the basis of pack start date and current date
            if($packdetail->error_message->data->subscribed_on_str>$today){
                $active = 0;// de-active pack
                $packCloseReason = "have to be start";
            }else{
                $active = 1;// active pack
                $packCloseReason = NULL;
            }
            /* ---ends----- */
            /* ---update the pack status and other necessary fields */         
            $params = array(    
            "active"=>$active,                        
            "status"=>$res_create->charges->data[0]['status'],
            "captured"=> $res_create->charges->data[0]['captured'],
            "method"=>$res_create->payment_method_types[0],           
            "payment_id"=>$res_create->id,      
            "payment_full_response"=>json_encode($res_create),                 
            "email_send_flag"=>1,                 
            "fourmodule_status"=>$response_fourmodule_success_status,                 
            "fourmodule_response"=>$response_fourmodule,                 
            "fourmodule_api_called"=>$_SESSION['fourmodule_identify_api'],   
            "fourmodule_json"=>$params_fourmoduleh,               
            );  
            $update_pack=$this->update_pack($params);  
            if($update_pack) 
            {
            redirect('booking/success_view');
            }  
        }
         // payment is created but status is pendind and need next action ex:opt enter form
        else if($res_create->status=="requires_action"){
            /*
            Next action required             
            STATUS:requires_action=Customer did not complete the checkout
            */  
            /* ---update the pack status and other necessary fields */    
            /* $params = array(   
            "payment_id"=>$res_create->id,                                     
            "status"=>$res_create->status,  
            "email_send_flag"=>0,                              
            );  */  
            $params = array(   
            "payment_id"=>$res_create->id,                                     
            "status"=>$res_create->status,  
            "active"=>2, 
            "email_send_flag"=>0,                              
            );          
            $this->update_pack($params);             
          // check if next action key is set then open next action url 
          if(isset($res_create->next_action)){
            /* ---checkout page tracking ---------- */
            $headers_checkout_tracking = array(
            'API-KEY:'.WOSA_API_KEY,          
            );
            $params_checkout_tracking = array(                             
            'student_id'=>$this->session->userdata('student_login_data')->id,  
            'checkout_token_no'=>$_SESSION['checkout_token_no'],  
            'page'=>"stripe_opt_form",  
            'active'=>1, 
            'created'=>date("d-m-Y h:i:s"),             
            'modified'=>date("d-m-Y h:i:s"),             
            );     
            $response= json_decode($this->_curPostData(base_url(CHECKOUT_TRACKING_URL), $headers_checkout_tracking, $params_checkout_tracking));  
            /* ----ends---- */
            //redirect to stripe action page i.e opt popup page
            redirect($res_create->next_action->redirect_to_url->url);
          }else{
            //do some thing here: next action is not set
            if(isset($res_create->last_payment_error)){
                $this->session->set_flashdata('exception_msg', $res_create->last_payment_error['message']);  
            }
            $custom_fail_status=$res_create->status;
            if($custom_fail_status == ""){
                $custom_fail_status="fail"; //custom fail status added
            }
            /* ---update the pack status and other necessary fields 
            active=>2---handle for fail order pack status
           */
            $params = array(
                "active" => 2,                                        
                "payment_id"=>$res_create->id,                                     
                "status"=>$custom_fail_status,     
                "payment_full_response"=>json_encode($res_create), 
                "email_send_flag"=>1,                                        
            );             
            $update_pack=$this->update_pack($params);  
            if($update_pack){
                redirect('booking/fail_view'); 
            }  
          }
        }
        else if($res_create->status=="requires_payment_method"){
            /*
            Fail payment 
            STATUS:requires_payment_method=Customer’s payment failed on your checkout page
            */
            /* ---update the pack status and other necessary fields 
            active=>2---handle for fail order pack status
           */
            if(isset($res_create->last_payment_error)){
                $this->session->set_flashdata('exception_msg', $res_create->last_payment_error['message']);  
            }
            $params = array(
            "active" => 2,     
            "payment_id"=>$res_create->id,                                     
            "status"=>$res_create->status, 
            "payment_full_response"=>json_encode($res_create), 
            "email_send_flag"=>1,                                         
            );             
            $update_pack=$this->update_pack($params);  
            if($update_pack) {
              redirect('booking/fail_view'); 
            }    
         }
        else{
             // Handle unsuccessful, processing, or canceled payments and API errors here
            $custom_fail_status=$res_create->status;
            if(isset($res_create->last_payment_error)){
                $this->session->set_flashdata('exception_msg', $res_create->last_payment_error['message']);  
            }
            if($custom_fail_status == ""){
                $custom_fail_status="fail"; //custom fail status added
            }
            /* ---update the pack status and other necessary fields 
            active=>2---handle for fail order pack status
           */
            $params = array(
                "active" => 2,                                      
            "status"=>$custom_fail_status,   
            "payment_full_response"=>json_encode($res_create),  
            "email_send_flag"=>1,                       
            );             
            $update_pack=$this->update_pack($params);  
            if($update_pack) {redirect('booking/fail_view');}          
        }         
    } /* ---ends---- */
  
   /* payment status return url from gateway*/
    function payment_status(){
        //When completing a payment on the client now inspect the returned PaymentIntent to determine its current status
    



        $stripe = new \Stripe\StripeClient($this->config->item('stripe_secret'));

        try{
            //Check PaymentIntent status on the client
            $res_retrieve= $stripe->paymentIntents->retrieve(
            $_GET['payment_intent']      
            );
        }catch(Exception $e){
            /*
            Fail due tp exception error occur            
            update the pack status and other necessary fields 
            active=>2---handle for fail order pack status
            */
            $params = array(
            "active" => 2, 
            "status"=>'failed', 
            "payment_full_response"=>json_encode($e->getMessage()),   
            "email_send_flag"=>1,                                                 
            );             
            $update_pack=$this->update_pack($params);  
            if($update_pack) 
            {
            $this->session->set_flashdata('exception_msg', $e->getMessage());                  
            redirect('booking/fail_view'); 
            } 
        }
        
       //fetch current status      
        if($res_retrieve->charges->data[0]['status'] =='succeeded'){    
               
            /*
            Success payment 
                STATUS:succeeded=Customer completed payment on your checkout page
            */  
             /* call api to get student pack start end date */          
             $headers = array(
                'API-KEY:'.WOSA_API_KEY, 
                'STUDENT-PACK-ID:'. $_SESSION['current_student_package_id'],             
            );
            $packdetail= json_decode($this->_curlGetData(base_url(STU_PACK_START_DATE), $headers));             
            $packdetail->error_message->data->subscribed_on_str;
            $packdetail->error_message->data->subscribed_on;
            $packdetail->error_message->data->expired_on;
          
            if(isset($_SESSION['fourmodule_identify_api']))
            {
            // 1=Enrollment api   2=Re-Enrollment api 3=Add-program api
           if($_SESSION['fourmodule_identify_api'] == 1)//Enrollment api
           {
                $headers_fourmodule= array(
                'authorization:'.FOURMODULE_KEY,                           
                );  
                $params_fourmodule = array(
                "api" => "enrolment", 
                "action"=>'enrol_student', 
                "centre_id"=>FOURMODULE_ONL_BRANCH_ID, 
                "domain_id"=>FOURMODULE_DOMAIN_ID,        
                "pack_id"=>$_SESSION['fourmodule_pack_id'],                                     
                "name"=>$this->session->userdata('student_login_data')->fname.' '. $this->session->userdata('student_login_data')->lname,                                        
                "token"=>$this->session->userdata('student_login_data')->UID,                                        
                "start_date"=>$packdetail->error_message->data->subscribed_on,                            
                "end_date"=>$packdetail->error_message->data->expired_on,
                "username"=>$this->session->userdata('student_login_data')->UID,
                "password"=>$this->session->userdata('student_login_data')->plain_pwd,                                        
                );                          
                // Call Enrollment apie
               $response_fourmodule= $this->_curPostData_fourmodules(FOURMODULE_URL, $headers_fourmodule, $params_fourmodule);
            }
           else if($_SESSION['fourmodule_identify_api'] == 2)//Re-Enrollment api
           {
                $headers_fourmodule = array(
                'Authorization:'.FOURMODULE_KEY,                                      
                );
                $params_fourmodule = array(
                "api" => "enrolment", 
                "action"=>'Re_enrolment', 
                "centre_id"=>FOURMODULE_ONL_BRANCH_ID, 
                "domain_id"=>FOURMODULE_DOMAIN_ID,        
                "pack_id"=>$_SESSION['fourmodule_pack_id'],                                     
                "name"=>$this->session->userdata('student_login_data')->fname.' '. $this->session->userdata('student_login_data')->lname,                                        
                "token"=>$this->session->userdata('student_login_data')->UID,                                        
                "start_date"=>$packdetail->error_message->data->subscribed_on,                         
                "end_date"=>$packdetail->error_message->data->expired_on,                                        
                ); 
                $response_fourmodule=$this->_curPostData_fourmodules(FOURMODULE_URL, $headers_fourmodule, $params_fourmodule);
            }
           else {
            $headers_fourmodule = array(
                'Authorization:'.FOURMODULE_KEY,                                      
                );
                $params_fourmodule = array(
                "api" => "enrolment", 
                "action"=>'Add_program', 
                "centre_id"=>FOURMODULE_ONL_BRANCH_ID, 
                "domain_id"=>FOURMODULE_DOMAIN_ID,        
                "pack_id"=>$_SESSION['fourmodule_pack_id'],                                     
                "name"=>$this->session->userdata('student_login_data')->fname.' '. $this->session->userdata('student_login_data')->lname,                                        
                "token"=>$this->session->userdata('student_login_data')->UID,                                        
                "start_date"=>$packdetail->error_message->data->subscribed_on,                                        
                "end_date"=>$packdetail->error_message->data->expired_on,                                        
                ); 

              
                $response_fourmodule=$this->_curPostData_fourmodules(FOURMODULE_URL, $headers_fourmodule, $params_fourmodule); 
           }
            //print_r($response_fourmodule);
            $response_fourmodule_p=json_decode($response_fourmodule);
            $response_fourmodule_success_status=$response_fourmodule_p->success; 
           // fourmodule api ends-----------------
        } else {
            $response_fourmodule_p='';
            $response_fourmodule_success_status='0';
            $_SESSION['fourmodule_identify_api']=0;
        } 
        $params_fourmoduleh=json_encode($params_fourmodule);
            $today=date("d-m-Y");
            $today=strtotime($today);
             // check for active pack status it should be 0 or 1 on the basis of pack start date and current date
             if($packdetail->error_message->data->subscribed_on_str>$today){
                $active = 0;// de-active pack
                $packCloseReason = "have to be start";
            }else{
                $active = 1;// active pack
                $packCloseReason = NULL;
            }
            /* ---ends----- */  
            /* ---update the pack status and other necessary fields */           
            $params = array(    
                "active"=>$active,                        
                "status"=>$res_retrieve->charges->data[0]['status'],
                "captured"=> $res_retrieve->charges->data[0]['captured'],
                "method"=>$res_retrieve->payment_method_types[0],           
                "payment_id"=>$res_retrieve->id,      
                "payment_full_response"=>json_encode($res_retrieve),    
                "email_send_flag"=>1,            
                "packCloseReason"=>$packCloseReason,  
                "fourmodule_status"=>$response_fourmodule_success_status,                 
                "fourmodule_response"=>$response_fourmodule,                 
                "fourmodule_api_called"=>$_SESSION['fourmodule_identify_api'],   
                "fourmodule_json"=>$params_fourmoduleh,         
                );             
                $update_pack=$this->update_pack($params);   
                if($update_pack)
                {
                    redirect('booking/success_view');
                }                         
        }else{
            $res_retrieve->last_payment_error['message'];
            $e = $res_retrieve->last_payment_error;
            // Handle unsuccessful, processing, or canceled payments and API errors here  
            switch ($e->code) {            
                case "payment_intent_authentication_failure":                  
                   $this->session->set_flashdata('exception_msg',"A payment error occurred: Your order has been cancelled");                 
                break;
                case "card_declined":                  
                    $this->session->set_flashdata('exception_msg',"The card has been declined.");              
                break;
                case "expired_card":                  
                    $this->session->set_flashdata('exception_msg',"The card has expired. Check the expiration date or use a different card.");               
                  break; 
                case "incorrect_cvc":                    
                    $this->session->set_flashdata('exception_msg',"The card’s security code is incorrect. Check the card’s security code or use a different card.");            
                  break; 
                case "invalid_expiry_month":                   
                    $this->session->set_flashdata('exception_msg',"The card’s expiration month is incorrect. Check the expiration date or use a different card.");                 
                break;
                break;  case "invalid_expiry_year":                   
                    $this->session->set_flashdata('exception_msg',"The card’s expiration year is incorrect. Check the expiration date or use a different card.");  
                break;  case "incorrect_number":                    
                    $this->session->set_flashdata('exception_msg',"The card number is incorrect. Check the card’s number or use a different card.");              
                break;                 
                default:               
                $this->session->set_flashdata('exception_msg',"Booking failed due to some Error. Please Try again.");    
                //error_log("Another problem occurred, maybe unrelated to Stripe.");
              }
              //echo $this->session->flashdata('exception_msg');       
            /*  if(isset($res_retrieve->last_payment_error))
            {
                $this->session->set_flashdata('exception_msg', $res_retrieve->last_payment_error['message']);  
            } */            
            $custom_fail_status=$res_retrieve->charges->data[0]['status'];
            if($custom_fail_status == ""){
                $custom_fail_status="failed"; //custom added status 'fail' if not received any status
            }
           /* ---update the pack status and other necessary fields 
            active=>2---handle for fail order pack status
           */    
            $params = array(    
                "active"=>2,                        
                "status"=>$custom_fail_status,                      
                "payment_id"=>$res_retrieve->id,      
                "payment_full_response"=>json_encode($res_retrieve), 
                "email_send_flag"=>1,               
            );             
            $update_pack=$this->update_pack($params);  
            if($update_pack) {redirect('booking/fail_view');}                     
        }
    }
   /*--------update pack status as per parmater passed------- */
    function update_pack($params){
        $headers = array(
            'API-KEY:'.WOSA_API_KEY, 
            'STUDENT-PACK-ID:'.$_SESSION['current_student_package_id'],
        );            
      $response= json_decode($this->_curPostData(base_url(UPDATE_PACK), $headers, $params));
      return $response->error_message->success;
    }     
    /*-------- success page view------- */
    function success_view(){
        /* checking required session active or set while hit the action */
        if(isset($this->session->userdata('student_login_data')->id))
        {
            $_SESSION['lastId_std']=$this->session->userdata('student_login_data')->id;
        }
          if(!isset($_SESSION['lastId_std']))
        {
            redirect('/');
            die();
        }
        
        if(!isset($_SESSION['book_packid']))
        {
           redirect('/');
            die();
        }
        /* ---checkout page tracking ---------- */
        $headers_checkout_tracking = array(
            'API-KEY:'.WOSA_API_KEY,          
            );

            $params_checkout_tracking = array(                             
            'student_id'=>$this->session->userdata('student_login_data')->id,  
            'checkout_token_no'=>$_SESSION['checkout_token_no'],  
            'page'=>"success",  
            'active'=>1, 
            'created'=>date("d-m-Y h:i:s"),             
            'modified'=>date("d-m-Y h:i:s"),         
            );     
            $response= json_decode($this->_curPostData(base_url(CHECKOUT_TRACKING_URL), $headers_checkout_tracking, $params_checkout_tracking));  
            /* ----ends---- */
            
        /*--Unset required session on success/fail-- */
        unset($_SESSION['lastId_std']);   
        unset($_SESSION['current_student_package_id']);   
        unset($_SESSION['book_packid']);            
        unset($_SESSION['actionFor']);
        unset($_SESSION['book_pack_type']);   
        unset($_SESSION['checkout_token_no']);
        unset($_SESSION['current_student_order_id']); 
        unset($_SESSION['fourmodule_pack_id']); 
        unset($_SESSION['fourmodule_identify_api']); 
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,             
            
        );
        $data['allcountry']= json_decode($this->_curlGetData(base_url(GET_CNT_URL), $headers));       
        $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));        
        $this->load->model('Enquiry_purpose_model'); 
        $this->load->model('News_model'); 
        // all academic and visa service title:----need to create api 
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers)); 
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        // all academic service title:----need to create api 
        $data['serviceDataAll'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));
        $headers3 = array(
        'API-KEY:'.WOSA_API_KEY,   
        'CONTENT-TYPE:'.'tcc', //tc=term & condition
        );         
        $data['term_cond'] = json_decode($this->_curlGetData(base_url(GET_CONTENTS), $headers3)); 
        // print_r($data['term_cond'] ); 
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/success');
        $this->load->view('aa-front-end/includes/footer');

    }
    /*-------- fail page view------- */
    function fail_view()
    {
        /* checking required session active or set while hit the action */
        if(isset($this->session->userdata('student_login_data')->id))
        {
            $_SESSION['lastId_std']=$this->session->userdata('student_login_data')->id;
        }
          if(!isset($_SESSION['lastId_std']))
        {
            redirect('/');
            die();
        }
        
        if(!isset($_SESSION['book_packid']))
        {
           redirect('/');
            die();
        }
        /* ---checkout page tracking ---------- */
        $headers_checkout_tracking = array(
            'API-KEY:'.WOSA_API_KEY,          
            );

            $params_checkout_tracking = array(                             
                'student_id'=>$this->session->userdata('student_login_data')->id,  
                'checkout_token_no'=>$_SESSION['checkout_token_no'],  
                'page'=>"fail",  
                'active'=>1, 
                'created'=>date("d-m-Y h:i:s"),             
                'modified'=>date("d-m-Y h:i:s"),        
                );     
            $response= json_decode($this->_curPostData(base_url(CHECKOUT_TRACKING_URL), $headers_checkout_tracking, $params_checkout_tracking));  
            /* ----ends---- */
        /*--Unset required session on success/fail-- */
        unset($_SESSION['lastId_std']);   
        unset($_SESSION['current_student_package_id']);   
        unset($_SESSION['book_packid']);            
        unset($_SESSION['actionFor']);
        unset($_SESSION['book_pack_type']);  
        unset($_SESSION['checkout_token_no']);   
        unset($_SESSION['current_student_order_id']);   
        unset($_SESSION['fourmodule_pack_id']); 
        unset($_SESSION['fourmodule_identify_api']); 
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,             
            
        );
        $data['allcountry']= json_decode($this->_curlGetData(base_url(GET_CNT_URL), $headers));       
        $data['countryCode']= json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));        
        
        // all academic and visa service title:----need to create api 
        $data['serviceData'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers)); 
        $data['newsData'] = json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
        // all academic service title:----need to create api 
        $data['serviceDataAll'] = json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_All_URL), $headers));
        $headers3 = array(
        'API-KEY:'.WOSA_API_KEY,   
        'CONTENT-TYPE:'.'tcc', //tc=term & condition
        );         
        $data['term_cond'] = json_decode($this->_curlGetData(base_url(GET_CONTENTS), $headers3)); 
        $data['exception_msg']= $this->session->flashdata('exception_msg');       
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/fail');
        $this->load->view('aa-front-end/includes/footer');    
    }     
   
}