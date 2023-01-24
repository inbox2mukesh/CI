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
     
class Get_recorded_lectures_short_listening extends REST_Controller {  
     
    public function __construct() {
      parent::__construct();
      $this->load->database();
      $this->load->model('Live_lecture_model');
    }       
    /**
     * Get All branches for at enquiry from this method.
     *
     * @return Response
    */
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          //$id = $this->input->get_request_header('ID');
          $classroom_id = $this->input->get_request_header('CLASSROOM-ID');
          
          $bData = $this->Live_lecture_model->get_live_lectures_short_listening($classroom_id);
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Schedule found!", "data"=> $bData];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}