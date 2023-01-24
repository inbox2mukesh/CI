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
    
     
class Get_recorded_lectures_cat extends REST_Controller {
    
      /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('Live_lecture_model');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_get()
    {        
       if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{ 
            $classroom_id = $this->input->get_request_header('CLASSROOM-ID');
            $bData1 = $this->Live_lecture_model->get_recorded_lectures_cat_new($classroom_id);
            $test_module_id=$bData1['test_module_id'];
            $programe_id=$bData1['programe_id'];
            $bData = $this->Live_lecture_model->get_recorded_lectures_cat($test_module_id,$programe_id);
            if(!empty($bData)){
                $data['error_message'] = [ "success" => 1, "message" => "success", 'data' => $bData ];  
            }else{
                $data['error_message'] = [ "success" => 0, "message" => "data not found", 'data' => $bData ];
            }  
        }
        $this->response($data, REST_Controller::HTTP_OK);
        
    }
            
}