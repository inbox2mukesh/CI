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
     
class Get_shared_doc_count extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();
        $this->load->model('Classroom_documents_modal');
    }
    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $bData = [];
          $classroom_id = $this->input->get_request_header('CLASSROOM-ID'); 
          $limit = $this->input->get_request_header('LIMIT');
          $offset = $this->input->get_request_header('OFFSET');         
          $data = $this->Classroom_documents_modal->getClassroomDocsID_count($classroom_id,$limit,$offset);
          
          // foreach ($aData as $key => $c) {
          //     $data2['c'] = $this->Classroom_documents_modal->getClassroomDocs($c['classroom_documents_id']);
          //     $bData[$key]['Content']= $data2['c'];
          //     $data2['d'] = $this->Classroom_documents_modal->getClassroomContentType($c['classroom_documents_id']);  
          //     $bData[$key]['ContentType']= $data2['d'];                    
          // }          

          // if(!empty($bData)){
          //   $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          // }else{
          //   $data['error_message'] = [ "success" => 0, "message" => "No Doc found!", "data"=> $bData];     
          // }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}