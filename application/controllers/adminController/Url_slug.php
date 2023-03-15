<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          navjeet
 *
 **/
defined('BASEPATH') OR exit('No direct script access allowed');

class Url_slug extends MY_Controller {

    function __construct() {
        parent::__construct();        
    }

    function ajax_check_url_()
	{
        $this->load->model('Url_slug_model');
        $url = $this->input->post('url', true);
        $type = $this->input->post('type', true);
        $edit_id = $this->input->post('edit_id', true);
        if ($url != '') {
            $return = $this->Url_slug_model->checkUrl($url,$type,$edit_id);
        }
        echo $return;
	}
}

?>