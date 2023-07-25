<?php 

class Error_404 extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
        
    }
    function index()
    {
        $headers = array(
            'API-KEY:'.WOSA_API_KEY,            
        );
        $params = array(
        'ipaddress'=>$this->get_client_ip(), 
        'useragent'=>$_SERVER['HTTP_USER_AGENT'], 
        'error_log_url'=>$this->session->get_userdata('current_url')['current_url'],
        ); 
        $response= json_decode($this->_curPostData(base_url(ERROR_LOG), $headers, $params));
        $this->output->set_status_header('404');
        $data['heading']= '404 Error';
        $data['message'] ='Oops, Page not found';
        $this->load->view('errors/html/error_404',$data);
        
    }
    function error_404_redirect()
    {
    
        $REDIRECT_QUERY_STRING = str_replace('/aus-staging','',$_SERVER['REDIRECT_URL']);
        $REDIRECT_QUERY_STRING = str_replace('/aus','',$_SERVER['REDIRECT_URL']);

        $badurl = array('/immigration_tools/converter_a','/visa-service-details/student-extension','/visa-services/post/tourist-visa-australia','/visa-services/post/gsm-visa-australia','/visa-service-details/gsm-visa-australia','/articles/post/migration-agent-in-Melbourne-australia','/visa-services/post/partner-visa-australia','/articles/post/migration-agent-in-perth-australia','/visa-services/post/student-visa-australia','/visa-services/post/parent-visa-Australia','/visa-services/post/family-sponsored-visa-australia','/visa-services/post/citizenship-australia','/visa-services/post/employer-sponsored-visa-Australia','/why_australia','/immigration_tools/converter_b','/immigration_tools/geteducation_level/','/immigration_tools/getcandidate_age/');
        if(in_array($REDIRECT_QUERY_STRING,$badurl)){
            redirect('/');
        }
        $this->session->set_userdata('current_url',current_url());
        redirect('error_404');
    }
    
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
}