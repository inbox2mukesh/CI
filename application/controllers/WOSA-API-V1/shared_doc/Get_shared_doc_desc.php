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
     
class Get_shared_doc_desc extends REST_Controller {  
     
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
          //$classroom_id = $this->input->get_request_header('CLASSROOM-ID'); 
          $classroom_documents_id = $this->input->get_request_header('CLASSROOM-DOCUMENT-ID');
          
          $data2['c'] = $this->Classroom_documents_modal->getClassroomDocs($classroom_documents_id);
          $bData['Content']= $data2['c'];
          $data2['d'] = $this->Classroom_documents_modal->getClassroomContentType($classroom_documents_id);  
          $bData['ContentType']= $data2['d']; 
          $data2['e'] = $this->Classroom_documents_modal->getClassroomContentDesc($classroom_documents_id);  
          $bData['ContentDesc']= $data2['e'];         

          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Doc found!", "data"=> $bData];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}