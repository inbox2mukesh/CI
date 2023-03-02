<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          
 *
 **/
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';   
     
class Free_resource_section_limited extends REST_Controller {  
     
    public function __construct() {
      parent::__construct();
      $this->load->database();        
      $this->load->model('Free_resources_modal');
    } 
    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{        
          $id = $this->input->get_request_header('ID');
          $bData = $this->Free_resources_modal->getFreeResourceContentSpecificLimited($id);
          /* $idd= $bData['basic']['content'][0]['id'];
          foreach ($bData as $key => $c) {
          
              $data2['c'] = $this->Test_preparation_material_model->getFreeResourceContentsTopic($idd);
              $bData[$key]['Course']= $data2['c'];                      
          }
          $frs = $this->Test_preparation_material_model->getFreeResourceSections($idd);
          foreach ($frs as $d) {
              //$data2['c'] = $this->Free_resources_modal->getFreeResourceContentsCourse($id);
              $bData['allSection'][]= $d;                      
          } */


          //$bData = array_merge($bData,$frs);

          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No section found!", "data"=> $bData];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}