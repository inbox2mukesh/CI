<?php

/**

 * @package         WOSA

 * @subpackage      ..

 * @author          Navjeet

 *

 **/

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';    

     

class Verify_session extends REST_Controller {

    

public function __construct() {



    error_reporting(0);

    parent::__construct();

    $this->load->database();

    $this->load->model('Counseling_session_model'); 

}





public function index_post()

{  

    if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            

        $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];

    }else{

        

        $std_data   = json_decode(file_get_contents('php://input'));

        if(!empty($std_data)){

                             

                $id = $std_data->id;

                $user_otp = $std_data->otp;

                $DBOtpdata = $this->Counseling_session_model->getOTP($id);

               $db_otp = $DBOtpdata['OTP'];

               

                               if($db_otp==$user_otp){

                    $params = array(                        

                        'active'=>1,

                        'is_otp_verified'=>1                

                    );

                    $idd = $this->Counseling_session_model->update_student_session($id,$params);
                    $session_data = $this->Counseling_session_model->get_student_session($id);                    

                    $data['error_message'] = [ "success" => 1, "message" => 'Dear '.$session_data['fname'].', OTP verified successfully.Please pay booking amount to complete your process','payamount'=> $session_data['amount']];

                    

                }else{

                     $data['error_message'] = [ "success" => 0, "message" => '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> OOps..Wrong Verification Code entered. Please try again with correct!<a href="#" class="alert-link"></a>.</div>', 'id'=>'']; 

                }    

                      

        }else{

            $data['error_message'] = [ "success" => 0, "message" => '<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Something went wrong. Please try again!<a href="#" class="alert-link"></a>.</div>', 'id'=>''];   

        }

    }  

    $this->set_response($data, REST_Controller::HTTP_CREATED);     

    

}







}//class closed