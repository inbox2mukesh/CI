<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Error_cl extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {
            redirect('adminController/login');
        }
    }
    /*
     * error page
     */
    function index()
    {       
        //$data['title']   = 'Forbidden';
        $data['heading'] = 'Forbidden & Un-authorized'; 
        $data['message'] = 'You are not authorized member to access this page !';      
        $this->load->view('error/error_forbidden', $data);
    }

    
    
}
