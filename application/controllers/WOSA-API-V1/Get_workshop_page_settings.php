<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Rajan Bansal
 *
 **/
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';   
     
class Get_workshop_page_settings extends REST_Controller {  
     
    public function __construct() {
       parent::__construct();
        $this->load->database();        
        $this->load->model('Workshop_booking_model');
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
          $bData = $this->Workshop_booking_model->getWorkshopPageSettings();
          if(!empty($bData)){
            $data['error_message'] = [ "success" => 1, "message" => "success", "data"=> $bData];    
          }else{
            $data['error_message'] = [ "success" => 0, "message" => "No Data found!", "data"=> $bData];     
          }
        }      
        $this->set_response($data, REST_Controller::HTTP_OK);
        
    }
        
}