<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/ 
class Country extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Country_model');       
    }
    
    function index(){

        //access control start
        $cn         = $this->router->fetch_class().''.'.php';
        $mn         = $this->router->fetch_method();        
        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}

        //access control ends
        $this->load->library('pagination');
        $data['si']             = 0;
        $data['title']          = 'Countries';
        $params['limit']        = RECORDS_PER_PAGE; 
        $params['offset']       = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config                 = $this->config->item('pagination');
        $config['base_url']     = site_url('adminController/country/index?');
        $config['total_rows']   = $this->Country_model->get_all_country_count();

        
        //$this->load->library('form_validation');         
        //$this->form_validation->set_rules('country_id_fake', 'Type country', 'required');

        if($this->input->get('submit') == "search"){
            $params["search"]       = trim($this->input->get('search'));
            $params["we_deal"]      = $this->input->get('we_deal');
            $params["status"]       = $this->input->get('status');
            $config['base_url']     = site_url('adminController/country/index?search='.$params["search"].'&we_deal='.$params["we_deal"].'&status='.$params["status"].'&submit=search'); 
            $config['total_rows']   = $this->Country_model->searchCountry($params,true);
            $getCountrydata         = $this->Country_model->searchCountry($params);
            $data['country']        = $getCountrydata;

            if(!empty($getCountrydata)) {
                $this->session->set_flashdata('flsh_msg', SEARCH_MSG);
            } else {
                $this->session->set_flashdata('flsh_msg', SEARCH_MSG_404);
            } 
        }else {
            $data['country']=$this->Country_model->get_all_country($params);
        }
        $this->pagination->initialize($config);        
        $data['total_rows'] =  $config['total_rows'];
        $data['_view']      = 'country/index';
        $this->load->view('layouts/main',$data);        
    }
    
    function add(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Add country';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('name','Country name','required|trim|is_unique[country.name]');
		$this->form_validation->set_rules('iso3','ISO3 name','required|trim|is_unique[country.iso3]');
		$this->form_validation->set_rules('country_code','Country code','required|trim');
        $this->form_validation->set_rules('currency_code','currency code','required|trim');
        $this->form_validation->set_rules('phoneNo_limit','Max length','trim|integer|max_length[2]');
        $this->form_validation->set_rules('min_phoneNo_limit','Min length','trim|integer|max_length[2]');		
		
		if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('name')))),
				'iso3' => $this->input->post('iso3'),
				'country_code' => '+'.$this->input->post('country_code'),
                'phoneNo_limit' => $this->input->post('phoneNo_limit'), 
                'min_phoneNo_limit' => $this->input->post('min_phoneNo_limit'),
                'flag' => $this->input->post('flag'), 
                'currency_code' => $this->input->post('currency_code'), 				
                'we_deal?' => $this->input->post('we_deal?'), 
                'by_user' => $by_user,
            );            
            $idd = $this->Country_model->add_country($params);
            if($idd){
                //activity update start              
                    $activity_name= COUNTRY_ADD;
                    $description= 'New country '.$params['name'].' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);                
                if($this->Role_model->_has_access_('country','index')){
                    redirect('adminController/country/index');
                }else{
                    redirect('adminController/country/add');
                }                   
                
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/country/add');
            }            
                
        }else{            
            $data['_view'] = 'country/add';
            $this->load->view('layouts/main',$data);
        }
    }  

   
    function edit($country_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Edit country';
        $data['country'] = $this->Country_model->get_country($country_id);
        if(isset($data['country']['country_id']))
        {            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name','Country Name','required|trim');
            $this->form_validation->set_rules('iso3','ISO3 name','required|trim');
            $this->form_validation->set_rules('country_code','Country code','required|trim');
            $this->form_validation->set_rules('currency_code','currency code','required|trim'); 
            $this->form_validation->set_rules('phoneNo_limit','Max length','trim|integer|max_length[2]');
            $this->form_validation->set_rules('min_phoneNo_limit','Min length','trim|integer|max_length[2]');	
		
			if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('name')))),
                    'iso3' => $this->input->post('iso3'),
                    'country_code' => '+'.$this->input->post('country_code'),
                    'phoneNo_limit' => $this->input->post('phoneNo_limit'), 
                    'min_phoneNo_limit' => $this->input->post('min_phoneNo_limit'),
                    'flag' => $this->input->post('flag'),   
                    'currency_code' => $this->input->post('currency_code'),                 
                    'we_deal?' => $this->input->post('we_deal?'),           
                    'by_user' => $by_user,
                ); 
                $id = $this->Country_model->update_country($country_id,$params);
                if($id){
                    //activity update start              
                        $activity_name= COUNTRY_UPDATE;
                        unset($data['country']['country_id'],$data['country']['created'],$data['country']['modified']);//unset extras from array
                        $jsID = 'country'.$id;
                        $diff1 =  json_encode(array_diff($data['country'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['country']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" id="'.$jsID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG); 
                    if($this->Role_model->_has_access_('country','index')){
                        redirect('adminController/country/index');
                    }else{
                        redirect('adminController/country/edit/'.$id);
                    }          
                    
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/country/edit/'.$id);
                }
            }
            else
            {
                $data['_view'] = 'country/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }   
   
    /*function remove($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $country = $this->Country_model->get_country($id);
        if(isset($country['country_id']))
        {
            $this->Country_model->delete_country($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/country/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/    
    
}
