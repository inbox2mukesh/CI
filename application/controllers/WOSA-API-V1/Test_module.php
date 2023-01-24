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
    
     
class Test_module extends REST_Controller {
    
      /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('Test_module_model');
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
            $bData = $this->Test_module_model->get_all_test_module_enqActive();
            if(!empty($bData)){
                $data['error_message'] = [ "success" => 1, "message" => "success", 'data' => $bData ];  
            }else{
                $data['error_message'] = [ "success" => 0, "message" => "data not found", 'data' => $bData ];
            }  
        }
        $this->response($data, REST_Controller::HTTP_OK);
        
    }
            
}