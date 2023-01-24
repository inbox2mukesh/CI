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
     
class Get_student_post extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();
        $this->load->model('Student_post_model');
    }

    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $id = $this->input->get_request_header('STUDENT-ID');
          $classroom_id = $this->input->get_request_header('CLASSROOM-ID');          
          $bData = $this->Student_post_model->get_student_post($id,$classroom_id);
          foreach ($bData as $key => $c) {
              $data2['c'] = $this->Student_post_model->getPostReplyAPI($c['post_id']);
              $bData[$key]['Reply']= $data2['c'];                      
          }
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Post found!", "data"=> $bData];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}
