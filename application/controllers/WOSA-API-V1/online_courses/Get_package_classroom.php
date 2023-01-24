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
     
class Get_package_classroom extends REST_Controller {  
     
    public function __construct() {
      parent::__construct();
      $this->load->database();        
      $this->load->model('Online_class_schedule_model');
      $this->load->model('Package_master_model');
      $this->load->model('Classroom_model');
    }

    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $package_id = $this->input->get_request_header('PACKAGE-ID'); 
          $test_module_id = $this->input->get_request_header('TEST-MODULE-ID'); 
          $programe_id = $this->input->get_request_header('PROGRAME-ID'); 
          $center_id = $this->input->get_request_header('CENTER-ID'); 
          $batch_id = $this->input->get_request_header('BATCH-ID');    
          $packageCategory = $this->Package_master_model->getPackCategoryId($package_id);
            foreach ($packageCategory as $pc) {
                $pack_category_id .= $pc['category_id'].',';
            }
          $pack_category_id = rtrim($pack_category_id, ',');
          $packageClassroom = $this->Classroom_model->findClassroom($test_module_id,$programe_id,$pack_category_id,$batch_id,$center_id);
          $classroomid=$packageClassroom['id'];
          $bData = $this->Online_class_schedule_model->getPackageSchedule($classroomid);
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Course duration found!", "data"=> $bData];     
          }  
        }      
        $this->set_response($data, REST_Controller::HTTP_CREATED);        
    }
        
}