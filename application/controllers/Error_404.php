<?php 

class Error_404 extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        $this->output->set_status_header('404');
        $data['heading']= '404 Error';
        $data['message'] ='Oops, Page not found';
        $this->load->view('errors/html/error_404',$data);
    }
    function error_404_redirect()
    {
        redirect('error_404');
    }
}