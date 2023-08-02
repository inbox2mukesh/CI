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
     
class Free_resource_contents extends REST_Controller {  
     
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

          $count  = $this->input->get_request_header('COUNT') ? true : false;
          $offset = $this->input->get_request_header('OFFSET');
          $limit  = $this->input->get_request_header('LIMIT');

          $params = array();
          $params['offset'] = $offset ? $offset : 0;
          $params['limit']  = $limit ? $limit : FRONTEND_RECORDS_PER_PAGE;
          $bData = $this->Free_resources_modal->get_free_resources_listing_frontend($params,$count);
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