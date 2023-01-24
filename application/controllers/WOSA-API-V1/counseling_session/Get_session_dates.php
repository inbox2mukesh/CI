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
     
class Get_session_dates extends REST_Controller {  
     
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
       // $session_type = $this->input->get_request_header('SESSION-TYPE');
        $finalDateArr=[];
        $CSGroupId = $this->Counseling_session_model->getSessionTypeIDs();
              foreach ($CSGroupId as $b){
                array_push($finalDateArr,$b['counseling_sessions_group_id']);
              }
        $bData = $this->Counseling_session_model->getSessionDates($finalDateArr,$session_type);
        if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData, 'groupId'=>$CSGroupId, 'dateRange'=> $dData];   
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No branch found!", "data"=> $bData, 'groupId'=>$CSGroupId, 'dateRange'=> $dData];
          }        
          
      }
      $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }

        
} 