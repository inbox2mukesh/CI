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
     
class Update_profile_logout extends REST_Controller {
    
public function __construct() {
    
    //error_reporting(1);
    parent::__construct();
    $this->load->database();
    $this->load->model('Student_model');
}

    /**
        * enquiry submission from this method.
        *
        * @return Response
    */
    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            $id = $this->input->get_request_header('ID');
            $std_data   = json_decode(file_get_contents('php://input'));
            $params = array(               
                'loggedIn' => $std_data->loggedIn,
            );
            $idd = $this->Student_model->update_student($id,$params);
            if($idd){
                $data['error_message'] = [ "success" => 1, "message" => "Logged out successfully." , 'data'=> ''];
            }else{
                 $data['error_message'] = [ "success" => 0, "message" => "Failed to Logg out. Try again!" , 'data'=> ''];
            }
            
                        
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED); 
    }

}//class closed