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
     
class Get_class_schedule_long_count extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();
        $this->load->model('Online_class_schedule_model');
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
          $id = $this->input->get_request_header('ID');
          $classroom_id = $this->input->get_request_header('CLASSROOM-ID');

          $current_DateTime = date("d-m-Y G:i:00");
          $current_DateTimeStr = strtotime($current_DateTime);
          $current_DateTimeStr_after = $current_DateTimeStr - 3600;
          $limit = $this->input->get_request_header('LIMIT');
          $offset = $this->input->get_request_header('OFFSET');
          $classdate = $this->input->get_request_header('CLASS-DATED');         
          $classname = $this->input->get_request_header('CLASS-NAME');
          $type = $this->input->get_request_header('ACTION-TYPE');
          if($classdate !="")
          {
           $date=date_create($classdate);
           $filterclassdater= date_format($date,"d-m-Y");
          }
          

          $data = $this->Online_class_schedule_model->get_weekly_schedule_all_count($current_DateTimeStr_after,$classroom_id,$limit,$offset,$classname,$type,$filterclassdater);
          
        }        
        $this->set_response($data, REST_Controller::HTTP_CREATED);
        
    }
        
}