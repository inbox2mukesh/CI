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
     
class Get_all_classroom_material extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();
        $this->load->model('Online_class_schedule_model');
        $this->load->model('Classroom_documents_modal');
        $this->load->model('Live_lecture_model');
        $this->load->model('Announcements_model');
    }
    
    public function index_get()
    { 
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
          $id = $this->input->get_request_header('ID');
          $classroom_id = $this->input->get_request_header('CLASSROOM-ID');

          $current_DateTime = date("d-m-Y G:i:00");
          $current_DateTimeStr = strtotime($current_DateTime);
         
         $current_DateTimeStr_after = $current_DateTimeStr-MAX_CLASS_DURATION;//=4 hour
         $limit = '3';
         $offset = '0';  
         $startdate = $this->input->get_request_header('STUDENT-PACK-START-DATE');          
         $enddate = $this->input->get_request_header('STUDENT-PACK-END-DATE');   
          //fetch schedule
          $this->Online_class_schedule_model->deactivate_classshedule($current_DateTimeStr,$classroom_id);
          $bData_sch = $this->Online_class_schedule_model->get_weekly_schedule($current_DateTimeStr_after,$classroom_id);
        
         //fetch classroom doc
          $aData_sharedoc = $this->Classroom_documents_modal->getClassroomDocsID($classroom_id,$limit,$offset);          
          foreach ($aData_sharedoc as $key => $c) {
              $data2['c'] = $this->Classroom_documents_modal->getClassroomDocs($c['classroom_documents_id']);
              $bData_SD[$key]['Content']= $data2['c'];
              $data2['d'] = $this->Classroom_documents_modal->getClassroomContentType($c['classroom_documents_id']);  
              $bData_SD[$key]['ContentType']= $data2['d'];                    
          } 
          //fetch Recorded lecture 
          $b_RD = $this->Live_lecture_model->getRecordedLectures($classroom_id,$startdate,$enddate,$limit,$offset);        
          $bData['classroom_schedule']= $bData_sch;
          $bData['classroom_doc']= $bData_SD;
          $bData['classroom_lecture']= $b_RD;          
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No classes found!", "data"=> $bData];     
          }
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}