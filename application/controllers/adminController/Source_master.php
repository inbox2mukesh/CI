<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Source_master extends MY_Controller{
    
    function __construct()
    {   
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Source_master_model');       
    }
    function ajax_check_source_duplicacy(){

        $source_name = $this->input->post('source_name'); 
        $source_id = $this->input->post('source_id'); 
        $response=$this->Source_master_model->check_source_duplicacy($source_name,$source_id);
		if($response==0){
			echo 'true';
		}else{
			echo 'false';
		}
		exit();
    }

    function index()
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/source_master/index?');
        $config['total_rows'] = $this->Source_master_model->get_all_source_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Sources';
        $data['source_master'] = $this->Source_master_model->get_all_source($params);
        // $data['origin_pack'] = getOMLeads();
        $data['_view'] = 'source_master/index';
        $this->load->view('layouts/main',$data);
    }

    function add() {
        //access control start
        $cn = $this->router->fetch_class() . '' . '.php';
        $mn = $this->router->fetch_method();
        if (!$this->_has_access($cn, $mn)) {
            redirect('adminController/error_cl/index');
        }
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Add Source';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('source_name', 'Source name', 'required|trim|is_unique[source_masters.source_name]');
        if ($this->form_validation->run()) {
			
			$this->db->trans_start();
            $by_user=$_SESSION['UserId'];
            $params = array(
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'source_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $this->input->post('source_name')))),
                'by_user' => $by_user
            );
            $idd = $this->Source_master_model->add_source($params);
            if ($idd) {
				
				$origin_type_array=$this->input->post('origin_type');
				$origin_array=$this->input->post('origin');
				if(!empty($origin_type_array)){
					
					foreach($origin_type_array as $key=>$origin_type){
						
						
						$origin=$origin_array[$key];
						$medium_array=$this->input->post('medium'.$key);
						foreach($medium_array as $medium){
							
							if(!empty($origin_type) && !empty($origin) && !empty($medium)){
								
								$params=array();
								$params['origin_type']=$origin_type;
								$params['origin']=$origin;
								$params['medium']=$medium;
								$params['source_id']=$idd;
								$params['by_user']=$by_user;
								$this->Source_master_model->add_om($params);
							} 
						}
					}
				}
                $activity_name = SOURCE_ADD;
                $description = 'New source as ' . $params['source_name'] . ' added';
                $this->addUserActivity($activity_name, $description, 0, $by_user);
				$this->db->trans_complete();
				
				if($this->db->trans_status() === FALSE){
				    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/source_master/add');
				}
				
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/source_master/index');
            }else {
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/source_master/add');
            }
        } else {
            // $data['origin_pack'] = getOMForSource();
            $data['_view'] = 'source_master/add';
            $this->load->view('layouts/main', $data);
        }
    }

    /*
     * Editing a batch
     */
    function edit($id) {
		
        //access control start
        $cn = $this->router->fetch_class() . '' . '.php';
        $mn = $this->router->fetch_method();
        if (!$this->_has_access($cn, $mn)) {
            redirect('adminController/error_cl/index');
        }
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit source';
        $data['source_master'] = $this->Source_master_model->get_source($id);
		// $data['origin_pack'] = getOMLeads();
        if (isset($data['source_master']['id'])) {
			if($data['source_master']['is_static']==1){
				 redirect('adminController/error_cl/index');
			}
            $data['source_om'] = $this->Source_master_model->get_source_om($id);
            $this->load->library('form_validation');
            $this->form_validation->set_rules('source_name', 'Source name', 'required|trim');
            if($_POST['source_name'] !=$data['source_master']['source_name']){
				$this->form_validation->set_rules('source_name', 'Source name', 'required|trim|is_unique[source_masters.source_name]');
			}
            if ($this->form_validation->run()) {
				
				$this->db->trans_start();
                $by_user=$_SESSION['UserId'];
                $params = array(
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'source_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $this->input->post('source_name')))),
                    'by_user' => $by_user,
                );
                $idd = $this->Source_master_model->update_source($id, $params);
				
                if ($idd) {
					$origin_type_array=$this->input->post('origin_type');
					$origin_array=$this->input->post('origin');
					$this->Source_master_model->delete_source_om($id);
					if(!empty($origin_type_array)){
						
						foreach($origin_type_array as $key=>$origin_type){
							
							
							$origin=$origin_array[$key];
							$medium_array=$this->input->post('medium'.$key);
							foreach($medium_array as $medium){
								
								if(!empty($origin_type) && !empty($origin) && !empty($medium)){
									
									$params=array();
									$params['origin_type']=$origin_type;
									$params['origin']=$origin;
									$params['medium']=$medium;
									$params['source_id']=$idd;
									$params['by_user']=$by_user;
									$this->Source_master_model->add_om($params);
								} 
							}
						}
					}
					$activity_name = SOURCE_MASTER_UPDATE;
					$description = 'Source ' . $data['source_master']['source_name'] . ' updated as ' . $params['source_name'] . '';
					$this->addUserActivity($activity_name, $description, 0, $by_user);
					
					if($this->db->trans_status() === FALSE){
						
						$this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);
						redirect('adminController/source_master/edit/' . $id);
					}
				
					$this->session->set_flashdata('flsh_msg', UPDATE_MSG);
					redirect('adminController/source_master/index');
                } 
				else {
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);
                    redirect('adminController/source_master/edit/' . $id);
                }
            } else {
                // $data['origin_pack'] = getOMLeads();
                $data['_view'] = 'source_master/edit';
                $this->load->view('layouts/main', $data);
            }
        } else
            show_error(ITEM_NOT_EXIST);
    }
	 /*
     * view_ 
     */
    function view_($id) {
		
        //access control start
        $cn = $this->router->fetch_class() . '' . '.php';
        $mn = $this->router->fetch_method();
        if (!$this->_has_access($cn, $mn)) {
            redirect('adminController/error_cl/index');
        }
        $data['si'] = 0;
        //access control ends
        $data['title'] ='Source Diteles';
        $data['source_master'] = $this->Source_master_model->get_source($id);
		// $data['origin_pack'] = getOMLeads();
        if (isset($data['source_master']['id'])) {
			
            $data['source_om'] = $this->Source_master_model->get_source_om($id);
			// $data['origin_pack'] = getOMLeads();
            $data['_view'] = 'source_master/view';
            $this->load->view('layouts/main', $data);
        } else
            show_error(ITEM_NOT_EXIST);
    }

    /*
     * Deleting batch_master
     */
    /*function remove($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $source_master = $this->Source_master_model->get_source($id);
        if(isset($source_master['id']))
        {
            $this->Source_master_model->delete_source($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/source_master/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/    
    
}
