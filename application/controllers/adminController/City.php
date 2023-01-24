<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class City extends MY_Controller{

    function __construct()
    {
        parent::__construct();
        if(!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('City_model');
        $this->load->model('State_model');
        $this->load->model('Country_model');        
    }    
    
    function index(){
        
        //access control start
        $cn             = $this->router->fetch_class().''.'.php';
        $mn             = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $this->load->library('pagination');
        $data['title']          = 'Cities/Districts';
        $params['limit']        = RECORDS_PER_PAGE; 
        $params['offset']       = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config                 = $this->config->item('pagination');
        $config['base_url']     = site_url('adminController/city/index?');
        $config['total_rows']   = $this->City_model->get_all_city_count();
        
        //$this->load->library('form_validation');         
        //$this->form_validation->set_rules('city_id_fake', 'Type city', 'required');

        if($this->input->get('submit') == 'search'){
            $params['search']       = $this->input->get('search');
            $params['country_id']   = $this->input->get('country_id');
            $params['state_id']     = $this->input->get('state_id');
            $params['status']       = $this->input->get('status');
            $params['limit']        = RECORDS_PER_PAGE; 
            $params['offset']       = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
            $config['base_url']     = site_url('adminController/city/index?search='.$params['search'].'&country_id='.$params['country_id'].'&state_id='.$params['state_id'].'&status='.$params['status'].'&submit=search'); 
            $config['total_rows']   = $this->City_model->searchCity($params,true);
            $getCityData            = $this->City_model->searchCity($params);
            $data['city']           = $getCityData;
            $data['all_state_list'] = $this->State_model->get_all_state_by_country($params['country_id']);

            if(!empty($getCityData)) {
                $this->session->set_flashdata('flsh_msg', SEARCH_MSG);
            } else {
                $this->session->set_flashdata('flsh_msg', SEARCH_MSG_404);
            }
        } else {
            $data['city'] = $this->City_model->get_all_city($params);
        }

        $this->pagination->initialize($config);
        $data["total_rows"]         = $config['total_rows'];
        $data['all_country_list']   = $this->Country_model->get_all_country_active();        
        $data['_view']              = 'city/index';
        $this->load->view('layouts/main',$data);
        
    }

    function add(){   

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Add City';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('city_name','City Name','required|trim');
        $this->form_validation->set_rules('state_id','State name','required|integer');
		$this->form_validation->set_rules('country_id','Country name','required|integer');        
		
		if($this->form_validation->run())     
        {   
            $by_user= $_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'country_id' => $this->input->post('country_id'),
                'state_id' => $this->input->post('state_id'),
				'city_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('city_name')))),               
                'by_user' => $by_user,
            ); 
            $id = $this->City_model->add_city($params);
            if($id){
                $Get_country_byId = $this->Country_model->Get_country_byId($params['country_id']);
                $country_name = $Get_country_byId['name'];

                $getStateName = $this->State_model->getStateName($params['state_id']);
                $state_name = $getStateName['state_name'];
                //activity update start              
                    $activity_name= CITY_ADD;
                    $description= 'New city '.$params['city_name'].' in country/state '.$country_name.'/'.$state_name.' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/city/index');
            }else{                    
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/city/add');
            }
            
        }
        else
        {			
			$data['all_country_list'] = $this->Country_model->get_all_country_active();
            $data['_view'] = 'city/add';
            $this->load->view('layouts/main',$data);
        }
    }

    function edit($city_id){ 

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit city';
        $data['city'] = $this->City_model->get_city($city_id);
        if(isset($data['city']['city_id']))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('city_name','City name','required|trim');
            $this->form_validation->set_rules('state_id','state name','required|integer');
            $this->form_validation->set_rules('country_id','country name','required|integer');           
		
			if($this->form_validation->run())     
            {   
                $by_user= $_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'country_id' => $this->input->post('country_id'),
                    'state_id' => $this->input->post('state_id'),
					'city_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('city_name')))),                    
                    'by_user' => $by_user,
                );
                $id = $this->City_model->update_city($city_id,$params);
                if($id){

                $Get_country_byId1 = $this->Country_model->Get_country_byId($data['city']['country_id']);
                $country_name1 = $Get_country_byId1['name'];
                $getStateName1 = $this->State_model->getStateName($data['city']['state_id']);
                $state_name1 = $getStateName1['state_name'];

                $Get_country_byId2 = $this->Country_model->Get_country_byId($params['country_id']);
                $country_name2 = $Get_country_byId2['name'];
                $getStateName2 = $this->State_model->getStateName($params['state_id']);
                $state_name2 = $getStateName2['state_name'];

                $oldData = $data['city']['city_name'].'/'.$state_name1.'/'.$country_name1;
                $newData = $params['city_name'].'/'.$state_name2.'/'.$country_name2;
                //activity update start              
                    $activity_name= CIYY_UPDATE;
                    $description= ''.$oldData.' update to '.$newData.'';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/city/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/city/edit/'.$city);
                }                
            }
            else
            {				
				$data['all_country_list'] = $this->Country_model->get_all_country();
                $data['all_state_list'] = $this->State_model->get_state_list($data['city']['country_id']);
                $data['_view'] = 'city/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

    function ajax_get_state_list(){       

        $country_id = $this->input->post('country_id');
        if(isset($country_id)){            
            $response =  $this->State_model->get_state_list($country_id);
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'list not available!', 'status'=>'false'];
            echo json_encode($response);
        }
    }

    function ajax_get_city_list(){        

        $state_id = $this->input->post('state_id');
        if(isset($state_id)){            
            $response =  $this->City_model->get_city_list($state_id);
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'list not available!', 'status'=>'false'];
            echo json_encode($response);
        }
    }

    /*function remove($city_id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $city = $this->City_model->get_city($city_id);
        if(isset($city['city_id']))
        {
            $this->City_model->delete_city($city_id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/city/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/    
    
}
