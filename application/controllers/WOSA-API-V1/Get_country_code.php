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
     
class Get_country_code extends REST_Controller {  
     
    public function __construct(){
      parent::__construct();
      $this->load->database();        
      $this->load->model('Country_model');
    } 
    public function index_get(){ 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $this->auto_loadCaching(CACHE_ENGINE);
            $bData = $this->Country_model->getAllCountryCode();
            if(!empty($bData)){
              $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];
            }else{
              $data['error_message'] = [ "success" => 0, "message" => "No Country code found!", "data"=> $bData];     
            }
            $this->auto_cacheOff();   
        } 
        $this->set_response($data, REST_Controller::HTTP_CREATED);    
    }        
}