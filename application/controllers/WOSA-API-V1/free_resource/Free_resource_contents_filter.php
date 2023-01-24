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
     
class Free_resource_contents_filter extends REST_Controller {  
     
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
          //test type is changed with free resource topic      
          $test_type = $this->input->get_request_header('TEST-TYPE');
          $content_test_type = $this->input->get_request_header('CONTENT-TEST-TYPE');
          $upload_time = $this->input->get_request_header('UPLOAD-TIME');
          $search_text = $this->input->get_request_header('SEARCH-TEXT');
          $bData = $this->Free_resources_modal->getFreeResourceFilterTestType($test_type,$content_test_type,$upload_time,$search_text);

         // $bData = $this->Free_resources_modal->getFreeResourceContents($content_test_type);
          foreach ($bData as $key => $c) {
              $data2['c'] = $this->Free_resources_modal->getFreeResourceContentsTopic($c['id']);
              $bData[$key]['Course']= $data2['c'];                      
            }

          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No content found!", "data"=> $bData];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}