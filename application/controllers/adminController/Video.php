<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Video extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if ( !$this->_is_logged_in()) {redirect('adminController/login'); }        
        $this->load->model('Video_model'); 
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
        $config['base_url'] = site_url('adminController/video/index/?');
        $config['total_rows'] = $this->Video_model->get_all_videos_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Video- ALL';
        $data['videos'] = $this->Video_model->get_all_videos();        
        $data['_view'] = 'video/index';
        $this->load->view('layouts/main',$data);
    }    

    /*
     * Adding a new video
     */
    function add()
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Add Video';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('video_url','Video URL','required|trim');
		if($this->form_validation->run())
        {   
            $by_user=$_SESSION['UserId'];
                
            $params = array( 
                'video_url' => $this->input->post('video_url') ? $this->input->post('video_url') : NULL,
                'active'=> $this->input->post('active') ? $this->input->post('active') : 0,
                'by_user' => $by_user,
            ); 
            $id = $this->Video_model->add_video($params);
            
            if($id){
                //activity update start              
                $activity_name= "Video Added";
                $description= ''.json_encode($params).'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                //activity update end  
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/video/index/'.$params['test_module_id']);
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/video/add');
            }               
                
        }else{             
            $data['_view'] = 'video/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    
    function edit($video_id)
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Edit Video';
        $data['video'] = $this->Video_model->get_video($video_id);
        
        if(isset($data['video']['video_id']))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('video_url','Video URL','required|trim');		
			if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array( 
                    'video_url' => $this->input->post('video_url') ? $this->input->post('video_url') : NULL,
                    'active'=> $this->input->post('active') ? $this->input->post('active') : 0,
                    'by_user' => $by_user,
                );    

                $id = $this->Video_model->update_video($video_id,$params);
                if($id){
                //activity update start                            
                $activity_name= "Video Updated";
                unset($data['video'] ['video_id'],$data['video']['created'],$data['video']['modified']);//unset extras from array               
                          
                $uaID = 'video'.$id;
                $diff1 =  json_encode(array_diff($data['video'], $params));//old
                $diff2 =  json_encode(array_diff($params,$data['video']));//new
                
                $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                if($diff1!=$diff2){
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                }                                        
                //activity update end
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/video/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/video/edit/'.$video_id);
                }
                
            }
            else
            {                
                $data['_view'] = 'video/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
    function remove($video_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $video = $this->Video_model->get_video($video_id);
        if(isset($video['video_id']))
        {
            $del = $this->Video_model->delete_video($video_id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            if($del){
                redirect('adminController/video/index');
            }else{
                redirect('adminController/video/index');
            }            
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
}
