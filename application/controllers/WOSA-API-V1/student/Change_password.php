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
     
class Change_password extends REST_Controller {
    
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
            $getPassword = $this->Student_model->getPassword($id);
            if(md5($std_data->cp)!= $getPassword['password']){
            	$data['error_message'] = [ "success" => 0, "message" => "your current password is wrong! Please try again with correct." ];
            }elseif($std_data->np!=$std_data->cnp){
            	$data['error_message'] = [ "success" => 0, "message" => "Password mismatched. Please re-enter." ];
            }else{
            	$params = array(                                           
                	'password' => md5($std_data->cnp),
            	);
            	$idd = $this->Student_model->update_student($id,$params);
            	if($idd){
            		$data['error_message'] = [ "success" => 1, "message" => "Password changed successfully." ];
            	}else{
            		$data['error_message'] = [ "success" => 0, "message" => "Faild to change.Try again" ];
            	}
            	
            }           
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED); 
    }

}//class closed