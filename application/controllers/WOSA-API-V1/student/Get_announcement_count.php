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
     
class Get_announcement_count extends REST_Controller { 
     
    public function __construct() {
      parent::__construct();
      $this->load->database();
      $this->load->model('Announcements_model');
    }

    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          //$id = $this->input->get_request_header('ID');
          $classroom_id = $this->input->get_request_header('CLASSROOM-ID');
          $limit = $this->input->get_request_header('LIMIT');
          $offset = $this->input->get_request_header('OFFSET');  
          $data = $this->Announcements_model->get_student_announcement_count($classroom_id,$limit,$offset);
          
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}