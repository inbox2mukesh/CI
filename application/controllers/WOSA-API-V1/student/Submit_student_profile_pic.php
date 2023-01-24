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
     
class Submit_student_profile_pic extends REST_Controller {
    
    public function __construct(){
        error_reporting(0);
        parent::__construct();
        $this->load->database();
        $this->load->model('Student_model');
    }

    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            
            $std_data   = json_decode(file_get_contents('php://input'));
            //student add
            if(!empty($std_data)){

               $student_id = $this->input->get_request_header('STUDENT-ID');
              
                if($std_data->profile_image!=''){
                
                    $unique_id =  uniqid().'-'.$student_id;
                    if($std_data->type=='jpeg'){
                        $img  = str_replace('data:image/jpeg;base64,', '', $std_data->profile_image);
                    }elseif($std_data->type=='JPEG'){
                        $img  = str_replace('data:image/JPEG;base64,', '', $std_data->profile_image);
                    }elseif($std_data->type=='jpg'){
                        $img  = str_replace('data:image/jpg;base64,', '', $std_data->profile_image);
                    }elseif($std_data->type=='JPG'){
                        $img  = str_replace('data:image/JPG;base64,', '', $std_data->profile_image);
                    }elseif($std_data->type=='png'){
                        $img  = str_replace('data:image/png;base64,', '', $std_data->profile_image);
                    }elseif($std_data->type=='PNG'){
                        $img  = str_replace('data:image/PNG;base64,', '', $std_data->profile_image);
                    }elseif($std_data->type=='pdf'){
                        $img  = str_replace('data:image/pdf;base64,', '', $std_data->profile_image);
                    }elseif($std_data->type=='PDF'){
                        $img  = str_replace('data:image/PDF;base64,', '', $std_data->profile_image);
                    }else{
                        $img='';
                        $data['error_message'] = [ "success" => 0, "message" => "Un-supported file format.", 'data'=> ''];
                    }
                    if(!file_exists(PROFILE_PIC_FILE_PATH)){
                        mkdir(PROFILE_PIC_FILE_PATH, 0777, TRUE);
                    }
                    $img  = str_replace(' ', '+', $img);
                    $img_data = base64_decode($img);
                    $file = PROFILE_PIC_FILE_PATH . $unique_id .'.'.$std_data->type;
                    $post_pic_url = site_url($file);
                    $success = file_put_contents($file, $img_data);
                    $std_params = array('profile_pic'=>  $file);
                }           
                $updateid = $this->Student_model->update_student($student_id,$std_params);
                $studentInfo = $this->Student_model->get_studentfull_profile($student_id); 
                $studentInfo['token'] = $studentInfo['token'];
               if( $updateid)
                {
                    $data['error_message'] = ["success" =>1,"message" =>"Please Verify and Update your Details to continue further." , 'data'=> $studentInfo ];
                }
                else {
                    $data['error_message'] = ["success" =>1,"message" =>"Loggedin successfully." , 'data'=> $studentInfo ];
                }
                         
            }else{
                 $data['error_message'] = [ "success" => 0, "message" => "Oh! Your post failed to submit.Try again.", 'data'=>'' ];   
            }
        }  
       // pr($data);
        $this->set_response($data, REST_Controller::HTTP_CREATED);     
        
    }


}//class closed