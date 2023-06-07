<?php
/**
 * @package         WOSA
 * @subpackage      VISA Banner//front end
 * @author          Harpreet
 *
 **/
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';   
     
class Get_all_visa_banner extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();        
        $this->load->model('Visa_banner_model');
    }
    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            $bData =  $this->Visa_banner_model->select_banner(5);
            if(!empty($bData)){
              $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
            }else{
              $data['error_message'] = [ "success" => 0, "message" => "No Country found!", "data"=> $bData];     
            } 
        }       
        $this->set_response($data, REST_Controller::HTTP_CREATED);       
    }
        
}