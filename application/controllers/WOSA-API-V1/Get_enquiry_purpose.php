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
     
class Get_enquiry_purpose extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();        
        $this->load->model('Enquiry_purpose_model');
    }       
    /**
     * Get All Enquiry_purpose for at enquiry from this method.
     *
     * @return Response
    */
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            $apiData = $this->Enquiry_purpose_model->get_all_enquiry_purpose_active();
            if(!empty($apiData)){
              $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $apiData];    
            }else{
                  $data['error_message'] = [ "success" => 0, "message" => "No Enquiry Purpose found!", "data"=> $apiData ];     
            } 
        }       
        $this->set_response($data, REST_Controller::HTTP_CREATED);       
    }
        
}