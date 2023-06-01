<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';    
     
class Buy_pack extends REST_Controller{
    
    public function __construct(){
        
        error_reporting(0);
        parent::__construct();
        $this->load->database();
        $this->load->model('Student_model');         
        $this->load->model('Package_master_model');
        $this->load->model('Practice_package_model');
        $this->load->model('Student_package_model');
        $this->load->model('Student_service_masters_model');
        $this->load->model('Student_journey_model');
        $this->load->model('Classroom_model');
        //$this->load->model('Discount_model');
        $this->load->model('Center_location_model');
        $this->load->model('Test_module_model');
        $this->load->model('Programe_master_model'); 
        $this->load->model('Batch_master_model');
        $this->load->model('Country_model');
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from(ADMISSION_EMAIL, FROM_NAME);
        $this->load->helper('common'); 
    }

    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            
                $std_data   = json_decode(file_get_contents('php://input'));
                $student_package_id = $this->buyWhenLoggedin($std_data);
                if($student_package_id){
                    $data['error_message'] = [ "success" => 1, "message" => "success", 'student_package_id'=> $student_package_id];
                    $this->set_response($data, REST_Controller::HTTP_CREATED);  
                }else{
                    $data['error_message'] = [ "success" => 0, "message" => "Oops..Failed to place order! try again.", 'student_package_id'=>''];
                    $this->set_response($data, REST_Controller::HTTP_CREATED);
                }
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED);
    }    

    function buyWhenLoggedin($std_data){

        //loggedin member start
            if($std_data->pack_type=='inhouse' or $std_data->pack_type=='online'){
                $package_data = $this->Package_master_model->get_package_master($std_data->package_id);
            }elseif($std_data->pack_type=='practice'){
                $package_data = $this->Practice_package_model->get_package($std_data->package_id);
            }else{
                $package_data=[];
            }          
            
            $package_name     = $package_data['package_name'];
            $discounted_amount= $package_data['discounted_amount']*100;                             
            $subscribed_on= $std_data->pack_startdate;
            $datee=date_create($subscribed_on);
            $duration_type=$std_data->duration_type;           
            $duration      = $std_data->duration;
            $pkduration = $duration.' '.$duration_type;
            
            if($duration_type=='Day'){
                 $duration = $duration;
            }elseif($duration_type=='Week'){
                $duration = $duration*7;                
            }elseif($duration_type=='Month'){
                $duration = $duration*30;                
            }else{
                $duration = 0;
            }
            if($duration >0)
            {
                $duration=$duration-1;
              //  $duration=$duration;
            }           
            $duration = $duration.' days';

            date_add($datee,date_interval_create_from_date_string($duration));
            $expired_on = date_format($datee,"d-m-Y");          
            $pack_batch_id=$std_data->pack_batch_id;            
            //$order_id = time().$this->_getorderTokens(6);
            //getting pack profile
            $pack_test_module_id= $package_data['test_module_id'];
            $pack_programe_id= $package_data['programe_id'];
            $pack_category_id= "";
            $pack_center_id= $std_data->center_id;
            if($std_data->pack_type=='online'){
               $pack_type='online';
               $service_id=ENROLL_SERVICE_ID;           
               $pack_cb='online';  
               $batch_id=  $pack_batch_id;
               //$findClassroom = $this->Classroom_model->findClassroom($pack_test_module_id,$pack_programe_id,$pack_category_id,$batch_id,$pack_center_id);
               $packageCategory = $this->Package_master_model->getPackCategoryId($std_data->package_id);
               foreach ($packageCategory as $pc) {
                   $pack_category_id .= $pc['category_id'].',';
               }
               $pack_category_id = rtrim($pack_category_id, ',');
               $findClassroom = $this->Classroom_model->findClassroom($pack_test_module_id,$pack_programe_id,$pack_category_id,$batch_id,$pack_center_id);
               $classroom_id=$findClassroom['id'];

            }elseif($std_data->pack_type=='inhouse'){
                $pack_type='offline';
                $service_id=ENROLL_SERVICE_ID;           
                $pack_cb='offline';  
                $batch_id=$pack_batch_id;
                /* findClassroom = $this->Classroom_model->findClassroom($pack_test_module_id,$pack_programe_id,$pack_category_id,$batch_id,$pack_center_id);
                $classroom_id=$findClassroom['id']; */
                $packageCategory = $this->Package_master_model->getPackCategoryId($std_data->package_id);
               foreach ($packageCategory as $pc) {
                   $pack_category_id .= $pc['category_id'].',';
               }
               $pack_category_id = rtrim($pack_category_id, ',');            
               $findClassroom = $this->Classroom_model->findClassroom($pack_test_module_id,$pack_programe_id,$pack_category_id,$batch_id,$pack_center_id);
               $classroom_id=$findClassroom['id'];               

            }elseif($std_data->pack_type=='practice'){
                $pack_type='practice';
                $service_id=ACADEMY_SERVICE_REGISTRATION_ID;           
                $pack_cb='practice'; 
                $batch_id= NULL;//static allocation
                $classroom_id=NULL;
            }else{
                $pack_type='';
                $service_id=0;           
                $pack_cb='';
                $batch_id= NULL;//static allocation
                $classroom_id=NULL;
            }
            $other_discount = $std_data->other_discount;
            if($other_discount==''){$other_discount=0;}else{$other_discount =$other_discount*100;} 

            $amount_paid = $std_data->amount_paid;
            if($amount_paid==''){$amount_paid=0;}else{$amount_paid =$amount_paid*100;} 
            //wallet case: start
            $use_wallet = $std_data->use_wallet;
                if($use_wallet){                    
                    $walletData = $this->Student_model->getWalletAmount($std_data->student_id);
                    $wallet     = $walletData['wallet'];                    
                    if($wallet==$discounted_amount){
                        $finalWalletAmount = 0;
                        $paidBywallet =  $wallet;
                    }elseif($wallet>$discounted_amount){
                        $finalWalletAmount = $wallet-$discounted_amount;
                        $paidBywallet =  $discounted_amount;
                    }elseif($wallet<$discounted_amount){
                        $finalWalletAmount = 0;
                        $paidBywallet =  $wallet;
                    }else{}                    
                    $updateWallet = $this->Student_model->update_student_wallet_payment($std_data->student_id,$finalWalletAmount);
                    if($paidBywallet>0){
                        $withdrawlData= array(
                            'student_id'=> $std_data->student_id,
                            'withdrawl_method'=> AUTO,
                            'withdrawl_amount'=> $paidBywallet,
                            'remarks'=> 'Auto Deduction for '.$pack_cb.' pack',
                        );
                        $this->Student_model->add_withdrawl($withdrawlData);
                    }                    
                    
                }else{                   
                    $wallet=0;
                    $paidBywallet=0;
                }            
            // Wallet case: end
            // if($std_data->status=='captured'){
            //     $active=1;
            // }else{
            //     $active=0;
            // }
            $subscribed_on= strtotime($std_data->pack_startdate);
            $today=date("d-m-Y");
            $today=strtotime($today);           
            // if($subscribed_on>$today){
            //     $active = 0;
            // }else{
            //     $active = 1;
            // }
            $active=0;
            $params2 = array(
                'student_id'    => $std_data->student_id,
                'package_id'    => $std_data->package_id,
                'test_module_id'=> $pack_test_module_id,
                'programe_id'   => $pack_programe_id,
                'category_id'   => $pack_category_id,                
                'center_id'     => $pack_center_id,
                'batch_id'      => $batch_id,
                'contact'       => $std_data->mobile,
                'email'         => $std_data->email,
                'pack_type'     => $pack_type, 
                'classroom_id'  => $classroom_id,                           
                'payment_id'    => $std_data->payment_id,
                'order_id'      => $std_data->order_id,                
                'amount'        => $discounted_amount*100,
                'other_discount'=> $other_discount,
                'promocode_used'=> $std_data->promocode,
                'amount_paid'   => $amount_paid+$paidBywallet,
                'amount_paid_by_wallet' => $paidBywallet,
                'currency'      => $std_data->currency,
                'status'        => $std_data->status,
                'captured'      => $std_data->captured, 
                'method'        => $std_data->method,
                'active'        => $active,
                'subscribed_on' => $std_data->pack_startdate,
                'subscribed_on_str' => strtotime($std_data->pack_startdate),
                'expired_on'    => $expired_on,
                'expired_on_str'    =>strtotime($expired_on),
                'pack_country_id'    => $std_data->pack_country_id,
                'package_duration'    => $pkduration,
                'package_name'    =>$package_data['package_name'],
                'checkout_token_no'    =>$std_data->checkout_token_no,
                'country_code'    =>$std_data->country_code,
                'requested_on' => date("d-m-Y h:i:s A"),
                'cgst_amt'=>$std_data->cgst_amt*100,
                'sgst_amt'=>$std_data->sgst_amt*100,
                'total_paid_ext_tax'=>$std_data->total_paid_ext_tax*100,
            );       
            $this->db->insert('student_package', $params2);

            //print_r($this->db->last_query());exit;
            $student_package_id =  $this->db->insert_id();
            // start-----comment code as on now
            //promocode updation start//
            /*     $promoCodeId = $std_data->promoCodeId_val;
                $bulk_id = $std_data->bulk_id;
                if($other_discount>0 and $promoCodeId and !$bulk_id){
                    $promo_params = array('student_id'=> $std_data->student_id, 'promoCodeId'=>$promoCodeId);
                    $this->db->insert('student_promocodes', $promo_params);
                    $this->Discount_model->update_remaining_uses($promoCodeId);
                }else if($other_discount>0 and $bulk_id and $promoCodeId){
                    $promo_params = array('student_id'=> $std_data->student_id, 'promoCodeId'=>$promoCodeId,'bulk_id'=>$bulk_id, 'by_user'=>$by_user);
                    $this->db->insert('student_promocodes', $promo_params);
                    $this->Discount_model->update_bulk_remaining_uses($bulk_id,$promoCodeId);
                }else{
                    //do nothing
                } */
            //promocode updation end//
            /* if($use_wallet and $paidBywallet>0){

                $remarks1 = "Initial payment and with Wallet worth: Rs. ".$paidBywallet/100;
                if($other_discount>0){
                    $remarks2 = " Promo Discount worth Rs. ".number_format($other_discount/100,2);
                }else{
                    $remarks2 = '';
                }

            }else{

                $remarks1 = "Initial payment";
                if($other_discount>0){
                    $remarks2 = " Promo Discount worth Rs. ".number_format($other_discount/100,2);
                }else{
                    $remarks2 = '';
                }
            }
            $remarks  =  $remarks1.' | '.$remarks2;
            $params3 = array(                    
                'student_package_id'=> $student_package_id,
                'remarks'           => $remarks,
                'amount'            => $amount_paid+$paidBywallet,                   
                'student_id'        => $std_data->student_id,
                'type'              => '+'
            );
            $idd2 = $this->Student_package_model->update_transaction($params3);
             */
            // ends-----comment code as on now
            ///////////////////status update/////////////////////////            
           /*  $center_id= $params2['center_id'];
            $test_module_id = $params2['test_module_id'];
            $programe_id = $params2['programe_id'];
            $studentStatus = $this->_calculateStatus($service_id,$center_id,$test_module_id,$programe_id,$pack_cb);
            $student_identity = $studentStatus['student_identity'];
            $details = $studentStatus['details'];
            $params3 = array('student_identity'=> $student_identity,'service_id'=> $service_id,'fresh'=> 2);
            $params4 = array('student_id'=>$std_data->student_id, 'student_identity'=>$student_identity,'details'=> $details);
            $idd = $this->Student_model->update_student($std_data->student_id,$params3);
            $std_journey=$this->Student_journey_model->update_studentJourney($params4);
            $type='Inhouse';
            //////////////////status update end/////////////////////////

            $getTestName = $this->Test_module_model->getTestName($pack_test_module_id);
            $getProgramName = $this->Programe_master_model->getProgramName($pack_programe_id);
            $getBatchName = $this->Batch_master_model->getBatchName($batch_id);
            $get_centerName = $this->Center_location_model->get_centerName($pack_center_id);
            
            $subject = 'Dear User, your package subscribed successfully at '.COMPANY.'';
            $email_message='Your package subscribed successfully at '.COMPANY.' details are as below:';
                $mailData                   = $this->Student_model->getMailData($std_data->student_id);
                $mailData['email_message']  = $email_message;
                $mailData['test_module_name']=$getTestName['test_module_name'];
                $mailData['programe_name']  = $getProgramName['programe_name'];
                $mailData['batch_name']     = $getBatchName['batch_name'];
                $mailData['center_name']    = $get_centerName['center_name'];
                $mailData['thanks']         = THANKS;
                $mailData['team']           = WOSA;
            if(base_url()!=BASEURL){
                $this->sendEmailTostd_packsubs_($subject,$mailData);
                $ccode=ltrim($std_data->country_code,"+");
                $opt_mobileno=$ccode.''.$std_data->mobile;
                $this->_call_smaGateway($opt_mobileno,PACK_SUBSCRIPTION_SMS);
                
            }else{
                $message = '';
            } */
            return $student_package_id;            
            //loggedin member end

    }

    


}//class closed