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
     
class Update_profile extends REST_Controller {
    
    public function __construct() {
        
        //error_reporting(1);
        parent::__construct();
        $this->load->database();
        $this->load->model('Student_model');
    }

    
    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            $id = $this->input->get_request_header('STUDENT-ID');
            $std_data   = json_decode(file_get_contents('php://input'));
            $params = array(
                'fname' => ucfirst($std_data->fname),
                'lname' => ucfirst($std_data->lname),                           
                'father_name' => ucfirst($std_data->father_name),
                'gender' => $std_data->gender,
                'dob' => $std_data->dob,
                /*'country_code' => $std_data->country_code,
                'mobile' => $std_data->mobile,
                'email' => $std_data->email,*/
                'residential_address' => $std_data->residential_address,
                'profileUpdate'=> 1,
                 'father_dob' => $std_data->father_dob,
                'mother_name' => $std_data->mother_name,
                'mother_dob' => $std_data->mother_dob,
                'parents_anniversary' => $std_data->parents_anniversary,
                'gaurdian_contact' => $std_data->gaurdian_contact,
                'qualification_id' => $std_data->qualification_id,
                'int_country_id' => $std_data->int_country_id,
                'source_id' => $std_data->source_id, 
                'gar_country_code' => $std_data->gar_country_code, 
                'country_id' => $std_data->country_id, 
                'state_id' => $std_data->state_id, 
                'city_id' => $std_data->city_id, 
                'zip_code' => $std_data->zip_code, 
            );

            $idd = $this->Student_model->update_student($id,$params);
            $studentInfo = $this->Student_model->get_studentfull_profile($id);
            if($idd){
                $data['error_message'] = [ "success" => 1, "message" => "Profile Update successfully." , 'data'=> $studentInfo];
            }else{
                 $data['error_message'] = [ "success" => 0, "message" => "Failed to update. Try again!" , 'data'=> ''];
            }           
                        
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED); 
    }

}//class closed