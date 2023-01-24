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
     
class Get_session_branch extends REST_Controller {  
     
    public function __construct() {
      error_reporting(0);
      parent::__construct();
      $this->load->database();        
      $this->load->model('Counseling_session_model');
    } 

    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $session_type = $this->input->get_request_header('SESSION-TYPE');
          $aData = $this->Counseling_session_model->getSessionTypeIDs($session_type);
          $arr=[];
          foreach ($aData as $b){
              array_push($arr,$b['counseling_sessions_group_id']);
          }
          $bData = $this->Counseling_session_model->getSessionBranch($arr);
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData, 'groupId'=>$aData];   
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No branch found!", "data"=> $bData, 'groupId'=>$aData];     
          }        
          
      }
      $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}