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
     
class Class_attendance extends REST_Controller {
    
  public function __construct(){

      error_reporting(0);
      parent::__construct();
      $this->load->database();
      $this->load->model('Attendance_model'); 
  }

  public function index_post(){  

      if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
          $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
      }else{      
          
          $std_data   = json_decode(file_get_contents('php://input'));
           if(!empty($std_data)){
                       
              $today = date('d-m-Y');
              $todaystr = strtotime($today);
              $time =  date('H:i');
              $is_offline=$std_data->is_offline;
              if($is_offline == 0){
                $type="Online";
              }else {
                $type="Inhouse";
              }
              $type="Online";
              $attendanceCode = $type.'-'.$todaystr;
              $params = array(
                  'attendanceCode'=> $attendanceCode,
                  'time'=> $time,
                  'date'=> $today,
                  'strDate'=> $todaystr,
                  'student_id'=>$std_data->student_id,
                  'type'=>$type,
                  'classroom_id'=>$std_data->classroom_id,
                  'sch_id'=>$std_data->sch_id,                
                  'active'=>1,
                  'morning'=>1,// 1=p,0=a   
                  'created'=>date("d-m-Y h:i:s"),
                  'modified'=>date("d-m-Y h:i:s"),
              ); 
              $count_attendance = $this->Attendance_model->get_attendance($std_data->student_id,$std_data->classroom_id,$std_data->sch_id,$today);
        

         if($count_attendance == 0)
         {
            $id = $this->Attendance_model->add_attendance($params); 
              if($id){
                                 
                  $data['error_message'] = [ "success" => 1, "message" => 'Submitted successfully'];

              }else{
                  $data['error_message'] = [ "success" => 0, "message" => 'OOps..Failed to submit request. Please try again!'];
              } 

         }  
                           
                        
          }else{
              $data['error_message'] = [ "success" => 0, "message" => ' OOps..Failed to submit request. Please try again!'];   
          }
      }  
      $this->set_response($data, REST_Controller::HTTP_CREATED);      
  }


}//class closed