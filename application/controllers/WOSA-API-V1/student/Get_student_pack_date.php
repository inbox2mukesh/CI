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
     
class Get_student_pack_date extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();        
        $this->load->model('Student_package_model');
    } 
    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
          $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $id = $this->input->get_request_header('STUDENT-PACK-ID');
          $bData = $this->Student_package_model->get_pack_startdate($id);
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Pack found!", "data"=> $bData];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}