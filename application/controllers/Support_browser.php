<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Navjeet
 *
 **/
class Support_browser extends MY_Controller{
    
    function __construct(){
        parent::__construct();       
    }
    function index(){       
        
        //$this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/support_browser');
        //$this->load->view('aa-front-end/includes/footer');
    }      
    
}
