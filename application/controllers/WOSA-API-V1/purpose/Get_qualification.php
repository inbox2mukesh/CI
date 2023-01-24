<?php
/**
 * @package         WOSA
 * @subpackage      Purpose
 * @author          Vikrant
 **/

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Get_qualification extends REST_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Purposes_master_model');
    }
	
    function index_get()
    {
        if(!$this->Authenticate($this->input->get_request_header('API-KEY'))) 
		{
			$data['error_message'] = ["success" => 2, "message" => UNAUTHORIZED, "data" => ''];
        } 
		else 
		{
			$bData =  $this->Purposes_master_model->getAllQualificationActive();
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