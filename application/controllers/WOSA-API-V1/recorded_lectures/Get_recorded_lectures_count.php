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
     
class Get_recorded_lectures_count extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();
        $this->load->model('Live_lecture_model');
    }
    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $classroom_id = $this->input->get_request_header('CLASSROOM-ID');          
          $startdate = $this->input->get_request_header('STUDENT-PACK-START-DATE');          
          $enddate = $this->input->get_request_header('STUDENT-PACK-END-DATE');        
          $limit = $this->input->get_request_header('LIMIT');
          $offset = $this->input->get_request_header('OFFSET');  
          $contentType_id = $this->input->get_request_header('CONTENT-TYPE-ID');
          $search_text = $this->input->get_request_header('SEARCH-TEXT');    
          $data = $this->Live_lecture_model->getRecordedLectures_count($classroom_id,$contentType_id,$search_text,$startdate,$enddate,$limit,$offset);
        
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}