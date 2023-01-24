<?php
/**
 * @package         WOSA
 * @subpackage      Purpose
 * @author          Vikrant
 **/

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Get_course extends REST_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Test_module_model');
    }
	
    function index_get()
    {
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) 
		{
			$data['error_message'] = ["success" => 2, "message" => UNAUTHORIZED, "data" => ''];
        } 
		else 
		{
			$bData = $this->Test_module_model->get_all_test_module_active();
            if(!empty($bData)) 
			{
				$data['error_message'] = ["success" => 1, "message" => "success", "data" => $bData];
            } 
			else 
			{
                $data['error_message'] = ["success" => 0, "message" => "No event found!", "data" => $bData];
            }
        }
        $this->set_response($data, REST_Controller::HTTP_CREATED);
    }
	
}