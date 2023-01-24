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
     
class Submit_student_post extends REST_Controller {
    
    public function __construct(){
        
        error_reporting(0);
        parent::__construct();
        $this->load->database();
        $this->load->model('Student_post_model');
    }

    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{
            
            $std_data   = json_decode(file_get_contents('php://input'));
            //student add
            if(!empty($std_data)){

                $classroom_id = $this->input->get_request_header('CLASSROOM-ID');
                if($std_data->post_image!=''){
                
                    $unique_id =  uniqid().'-'.$std_data->student_id;
                    if($std_data->type=='jpeg'){
                        $img  = str_replace('data:image/jpeg;base64,', '', $std_data->post_image);
                    }elseif($std_data->type=='JPEG'){
                        $img  = str_replace('data:image/JPEG;base64,', '', $std_data->post_image);
                    }elseif($std_data->type=='jpg'){
                        $img  = str_replace('data:image/jpg;base64,', '', $std_data->post_image);
                    }elseif($std_data->type=='JPG'){
                        $img  = str_replace('data:image/JPG;base64,', '', $std_data->post_image);
                    }elseif($std_data->type=='png'){
                        $img  = str_replace('data:image/png;base64,', '', $std_data->post_image);
                    }elseif($std_data->type=='PNG'){
                        $img  = str_replace('data:image/PNG;base64,', '', $std_data->post_image);
                    }elseif($std_data->type=='pdf'){
                        $img  = str_replace('data:image/pdf;base64,', '', $std_data->post_image);
                    }elseif($std_data->type=='PDF'){
                        $img  = str_replace('data:image/PDF;base64,', '', $std_data->post_image);
                    }else{
                        $img='';
                        $data['error_message'] = [ "success" => 0, "message" => "Un-supported file format.", 'data'=> ''];
                    }
                    $img  = str_replace(' ', '+', $img);
                    $img_data = base64_decode($img);
                    $file = STUDENT_POST_PIC_FILE_PATH . $unique_id .'.'.$std_data->type;
                    $post_pic_url = site_url($file);
                    $success = file_put_contents($file, $img_data);

                    //image resize start
                    $config['image_library'] = 'gd2';
                    $config['source_image']  = $file;
                    $config['create_thumb']  = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    //$config['width']          = 75;
                    //$config['height']         = 75;
                    $config['thumb_marker']   = '';
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    //image resize end

                    $std_params = array(                
                        'student_id'=> $std_data->student_id,
                        'classroom_id'=> $classroom_id, 
                        'post_text' =>  $std_data->post_text,
                        'active' =>     $std_data->active,                
                        'post_image'=>  $post_pic_url,
                    );
                }else{
                    $std_params = array(                
                        'student_id'=> $std_data->student_id,  
                        'classroom_id'=> $classroom_id,                           
                        'post_text' =>  $std_data->post_text,
                        'active' =>     $std_data->active,
                    );
                }            
                $postId = $this->Student_post_model->add_student_post($std_params);          
                $data['error_message'] = [ "success" => 1, "message" => "Hi! Your post submitted succesfully.", 'data'=> $postId];           
            }else{
                 $data['error_message'] = [ "success" => 0, "message" => "Oh! Your post failed to submit.Try again.", 'data'=>'' ];   
            }
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED);     
        
    }


}//class closed