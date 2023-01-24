<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Free_resources_topic extends MY_Controller{
    
    function __construct(){

        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Free_resources_topic_model');       
    }

    function ajax_check_freeresourcetopic_duplicacy(){
        $topic = $this->input->post('topic'); 
        $topic_id = $this->input->post('topic_id');  
        if($topic_id and $topic) {
            echo $response= $this->Free_resources_topic_model->check_topic_duplicacy2($topic,$topic_id);
        }else{
            echo $response=$this->Free_resources_topic_model->check_topic_duplicacy($topic); 
        }
    }
    
    function index(){
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}        
        //access control ends
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/batch_master/index?');
        $config['total_rows'] = $this->Free_resources_topic_model->get_all_topic_count();
        $this->pagination->initialize($config);
        $data['title'] = 'All Topic';
        $data['topic_master'] = $this->Free_resources_topic_model->get_all_topic($params);
        $data['_view'] = 'free_resources_topic/index';
        $this->load->view('layouts/main',$data);
    }

    function add(){        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Add Topic';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('topic','Topic','required|trim|is_unique[batch_master.batch_name]|min_length[4]|max_length[100]');			
		if($this->form_validation->run()){
            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'topic' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('topic')))),			
				'by_user' => $by_user,
            );            
            $idd = $this->Free_resources_topic_model->add_topic($params);
            if($idd==1){
                //activity update start              
                    $activity_name= FREE_RESOURCES_TOPIC_ADD;
                    $description= ''.json_encode($params).'';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                if($this->Role_model->_has_access_('free_resources_topic','index')){
                    redirect('adminController/free_resources_topic/index');
                }else{
                    redirect('adminController/free_resources_topic/add');
                }                
            }elseif($idd==2){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/free_resources_topic/add');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/free_resources_topic/add');
            }  
        }else{      
            $data['_view'] = 'free_resources_topic/add';
            $this->load->view('layouts/main',$data);
        }        
    }
    
    function edit($topic_id){  

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['title'] = 'Edit topic';
        $data['topic_master'] = $this->Free_resources_topic_model->get_topic($topic_id);
        if(isset($data['topic_master']['topic_id'])){         
            $this->load->library('form_validation');
            $this->form_validation->set_rules('topic','Topic','required|trim|min_length[4]|max_length[100]');
             if($this->form_validation->run()){               
                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'topic' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('topic')))),	
					'by_user' => $by_user,
                );
                $idd = $this->Free_resources_topic_model->update_topic($topic_id,$params,$data['topic_master']['topic']);                
                if($idd==1){
                    //activity update start             
                        $activity_name= FREE_RESOURCES_TOPIC_UPDATE;
                        unset($data['topic_master']['topic_id'],$data['topic_master']['created'],$data['topic_master']['modified']);//unset extras from array
                        $uaID = 'topic_master'.$idd;
                        $diff1 =  json_encode(array_diff($data['topic_master'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['topic_master']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG); 
                    if($this->Role_model->_has_access_('free_resources_topic','index')){
                        redirect('adminController/free_resources_topic/index');
                    }else{
                        redirect('adminController/free_resources_topic/edit/'.$topic_id);
                    }          
                    redirect('adminController/free_resources_topic/index');
                }elseif($idd==2){
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);           
                    redirect('adminController/free_resources_topic/edit/'.$topic_id);
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/free_resources_topic/edit/'.$topic_id);
                }

            }else{                
                $data['_view'] = 'free_resources_topic/edit';
                $this->load->view('layouts/main',$data);                
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }        
    
}