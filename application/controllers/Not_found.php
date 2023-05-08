<?php 

class Not_found extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        $data['heading']= '404 Error';
        $data['message'] ='Oops, Page not found';
        $this->load->view('errors/html/error_404',$data);
    }
}