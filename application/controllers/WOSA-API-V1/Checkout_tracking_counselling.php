<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          
 *
 **/
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';    
     
class Checkout_tracking_counselling extends REST_Controller{
    
    public function __construct(){
        
        error_reporting(0);
        parent::__construct();
        $this->load->database();        
    }

    public function index_post()
    {  
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) {            
            $data['error_message'] = [ "success" => 2, "message" => UNAUTHORIZED, "data"=>''];
        }else{            
        
            $std_data   = json_decode(file_get_contents('php://input'));                   
            $this->db->where('checkout_token_no',$std_data->checkout_token_no);
            $result = $this->db->get('checkout_page_history_counselling')->num_rows();
            if($result > 0)
            {                
                $this->db->update('checkout_page_history_counselling', $std_data, array('checkout_token_no' => $std_data->checkout_token_no));
            }
            else {
                $this->db->insert('checkout_page_history_counselling', $std_data);   
                
            }

                            
        }  
        $this->set_response($data, REST_Controller::HTTP_CREATED);
    }    
}//class closed