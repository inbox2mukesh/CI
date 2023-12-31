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
     
class Get_reciept extends REST_Controller {  
     
    public function __construct() {
      parent::__construct();
      $this->load->database();        
      $this->load->model(['Student_package_model','Package_master_model']);
    }
    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $student_id = $this->input->get_request_header('STUDENT-ID');
          $student_package_id = $this->input->get_request_header('STUDENT-PACKAGE-ID');
          $cgst = $this->Package_master_model->get_tax_detail('CGST');
          $sgst = $this->Package_master_model->get_tax_detail('SGST');
          $cgst_per = (!empty($cgst))?$cgst['tax_per']:0;
          $sgst_per = (!empty($sgst))?$sgst['tax_per']:0;
          $packTypedata = $this->Student_package_model->get_pack_type($student_package_id);
          $pack_type= $packTypedata['pack_type'];
          if($pack_type=='online' or $pack_type=='offline'){
            $bData = $this->Student_package_model->get_reciept($student_id,$student_package_id);
          }elseif($pack_type=='practice'){
            $bData = $this->Student_package_model->get_reciept_pp($student_id,$student_package_id);
          }else{
            
          }
          
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData,"cgst_tax_per"=>$cgst_per, "sgst_tax_per"=>$sgst_per];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No order found!", "data"=> $bData];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}