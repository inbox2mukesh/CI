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
     
class Submit_student_post_comment extends REST_Controller {
    
    public function __construct(){
        
        error_reporting(0);
        parent::__construct();
        $this->load->database();
        $this->load->model('Student_post_model');
    }

    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            
            $std_data   = json_decode(file_get_contents('php://input'));
            //student add
            if(!empty($std_data)){
                $std_params = array( 
                    'post_id'=>$std_data->post_id,
                    'post_reply_text'=> $std_data->post_reply_text, 
                    'active' =>  1,          
                    'by_student'=> $std_data->by_student,
                );                           
                $commentId = $this->Student_post_model->add_post_reply($std_params);          
                $data['error_message'] = [ "success" => 1, "message" => "Hi! Your comment added succesfully.", 'data'=> $commentId];           
            }else{
                 $data['error_message'] = [ "success" => 0, "message" => "Oh! failed to submit comment .Try again.", 'data'=>'' ];
            }
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED);     
        
    }


}//class closed