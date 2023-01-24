<?php
/**
 * @package         WOSA front
 * @subpackage      IELTS/PTE..
 * @author          Navjeet
 *
 **/
class Become_agent extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();   
    }
    
    function index()
    {   
		$headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
        //$data['segment'] = $this->_getURI();
        $data['title'] = 'Become An Agent';
        $data['title1'] = 'Become An Agent';
        $data['title2'] = ' Become An Agent';

		$data['newsData']=json_decode($this->_curlGetData(base_url(GET_NEWS_DATA_URL), $headers));
		$data['serviceData']=json_decode($this->_curlGetData(base_url(GET_SERVICE_DATA_URL), $headers));
		$data['countryCode']=json_decode($this->_curlGetData(base_url(GET_ALL_CNT_CODE_URL), $headers));
        $this->load->view('aa-front-end/includes/header',$data);
        $this->load->view('aa-front-end/become_agent',$data);
        $this->load->view('aa-front-end/includes/footer');
    }  
	
	function save_booking(){

		$headers = array(
            'API-KEY:'.WOSA_API_KEY,   
        );
		$this->load->library('form_validation');
        $this->form_validation->set_rules('fname','fname','required|trim');
        $this->form_validation->set_rules('mobile','Valid mobile no.','required|trim');       
        $this->form_validation->set_rules('email','Valid Email Id','required|trim');
        $this->form_validation->set_rules('city','City','required|trim');       
        $this->form_validation->set_rules('country','country','required|trim');       
        $this->form_validation->set_rules('address','address','trim');       
        $this->form_validation->set_rules('org_name','org_name','trim');       
        if($this->form_validation->run())     
        { 
			$params = array(                
				'fname' => $this->input->post('fname', TRUE),
				'lname' => $this->input->post('lname', TRUE),
				'email' => $this->input->post('email', TRUE),
				'country_code' => $this->input->post('country_code', TRUE),
				'mobile' => $this->input->post('mobile', TRUE),			
				'city' => $this->input->post('city', TRUE),
				'country' => $this->input->post('country', TRUE),              
				'org_name' => $this->input->post('org_name', TRUE),                
				'address' => $this->input->post('address', TRUE),		               
				'contact_date' => date('d-m-Y'),  
				'created' => date('d-m-Y h:i:s'),  
				'modified' => date('d-m-Y h:i:s'),  
			);    
			$response= json_decode($this->_curPostData(base_url(SUBMIT_ENQUIRY_AGENT), $headers, $params));
			echo $response->error_message->data;
			
		}else{
			echo 0;
		}		 
	}	
    
}
