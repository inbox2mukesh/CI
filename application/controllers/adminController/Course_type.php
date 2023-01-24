<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Navjeet
 *
 **/
class Course_type extends MY_Controller{
    
    function __construct(){

        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Course_type_model');       
    }
    // check duplicate course type 
    function ajax_check_course_type_duplicacy(){

        $name = $this->input->post('batch_name'); 
        $id = $this->input->post('course_id');  
        if($id and $name) {
            echo $response= $this->Course_type_model->check_course_type_duplicacy2($name,$id);
        }else{
            echo $response=$this->Course_type_model->check_course_type_duplicacy($name); 
        }
    }
    // list content type
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
        $config['base_url'] = site_url('adminController/course_type/index?');
        $config['total_rows'] = $this->Course_type_model->get_all_course_type_count();
        $this->pagination->initialize($config);
        $data['title'] = 'All Course Type';
        $data['course_type'] = $this->Course_type_model->get_all_course_type($params);
        $data['_view'] = 'course_type/index';
        $this->load->view('layouts/main',$data);
    }
   // add new content type
    function add(){
       
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Add Course Type';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('course_timing','Course Type','required|trim|is_unique[batch_master.batch_name]|min_length[4]|max_length[20]');			
		
		if($this->form_validation->run()){

            $by_user=$_SESSION['UserId'];
            $params = array(
				'active' => $this->input->post('active') ? $this->input->post('active') : 0,
				'course_timing' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('course_timing')))),				
                'by_user' => $by_user,
            );            
            $idd = $this->Course_type_model->add_course_type($params);
            if($idd==1){
                //activity update start              
                    $activity_name= COURSE_TYPE_ADD;
                    $description= ''.json_encode($params).'';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                if($this->Role_model->_has_access_('course_type','index')){
                    redirect('adminController/course_type/index');
                }else{
                    redirect('adminController/course_type/add');
                }
                
            }elseif($idd==2){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/course_type/add');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/course_type/add');
            }  

        }else{      
            $data['_view'] = 'course_type/add';
            $this->load->view('layouts/main',$data);
        }        
    }
    // edit content type
    function edit($id){  
      
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Edit Course Type';
        $data['course_type'] = $this->Course_type_model->get_course_type($id);
        if(isset($data['course_type']['id'])){

            $data['title'] = 'Edit Course Type';
            $this->load->library('form_validation');
            $this->form_validation->set_rules('course_timing','Course Type','required|trim|min_length[4]|max_length[20]');
           	if($this->form_validation->run())
            {            
                $by_user=$_SESSION['UserId'];
                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
					'course_timing' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('course_timing')))),	
					'by_user' => $by_user,
                );
                $idd = $this->Course_type_model->update_course_type($id,$params,$data['course_type']['course_timing']);                
                if($idd==1){
                    //activity update start             
                        $activity_name= COURSE_TYPE_MASTER_UPDATE;
                        unset($data['course_type']['id'],$data['course_type']['created'],$data['course_type']['modified']);//unset extras from array
                        $uaID = 'course_type'.$id;
                        $diff1 =  json_encode(array_diff($data['course_type'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['course_type']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG); 
                    if($this->Role_model->_has_access_('course_type','index')){
                        redirect('adminController/course_type/index');
                    }else{
                        redirect('adminController/course_type/edit/'.$id);
                    }          
                    redirect('adminController/course_type/index');
                }elseif($idd==2){
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);           
                    redirect('adminController/course_type/edit/'.$id);
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/course_type/edit/'.$id);
                }

            }else{                
                $data['_view'] = 'course_type/edit';
                $this->load->view('layouts/main',$data);                
            }
        }
        else           
        show_error(ITEM_NOT_EXIST);
    }   
}