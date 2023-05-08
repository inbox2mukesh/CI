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
     
class Get_pack_details extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();        
        $this->load->model('Package_master_model');
        $this->load->model('Practice_package_model');
         //$this->load->model('Realty_test_model');
    }

    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
          $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          
          $pack_type = $this->input->get_request_header('PACK-TYPE');
          $package_id = $this->input->get_request_header('PACKAGE-ID');
          $cgst = $this->Package_master_model->get_tax_detail('CGST');
          $sgst = $this->Package_master_model->get_tax_detail('SGST');
          $cgst_per = (!empty($cgst))?$cgst['tax_per']:0;
          $sgst_per = (!empty($sgst))?$sgst['tax_per']:0;
          if($pack_type=='offline' or $pack_type=='inhouse' or $pack_type=='online'){
            $bData = $this->Package_master_model->getPackageDetails($package_id);
          }elseif($pack_type=='practice'){
            $bData = $this->Practice_package_model->getPackageDetails($package_id);
          }/* elseif($pack_type=='reality test'){
            $bData = $this->Realty_test_model->get_rt_info($package_id);
            $data2=$this->Realty_test_model->get_all_real_test_info($package_id,$bData['test_module_id']);
          $bData['Info']= $data2;
          } */else{
            $bData = [];
          }
          
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData,"cgst_tax_per"=>$cgst_per, "sgst_tax_per"=>$sgst_per];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Pack found!", "data"=> $bData];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}