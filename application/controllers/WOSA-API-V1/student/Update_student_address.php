<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Navjeet
 *
 **/
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';    
     
class Update_student_address extends REST_Controller {
    
    public function __construct() {
        
        //error_reporting(1);
        parent::__construct();
        $this->load->database();
        $this->load->model('Student_model');
    }

    
    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            $id = $this->input->get_request_header('STUDENT-ID');
            $std_data   = json_decode(file_get_contents('php://input'));
            $idd = $this->Student_model->update_student($id,$std_data);            
            if($idd){
                $datar = $this->Student_model->get_studentfull_profile($id);
                $data['error_message'] = [ "success" => 1, "message" => "Profile Update successfully." , 'data'=>$datar];
            }else{
                $data['error_message'] = [ "success" => 0, "message" => "Failed to update. Try again!" , 'data'=>''];
            }           
                        
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED); 
    }

}//class closed