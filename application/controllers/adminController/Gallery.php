<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Gallery extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Gallery_model');        
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
        $config['base_url'] = site_url('adminController/gallery/index?');
        $config['total_rows'] = $this->Gallery_model->get_all_gallery_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Gallery';
        $data['gallery'] = $this->Gallery_model->get_all_gallery($params);        
        $data['_view'] = 'gallery/index';
        $this->load->view('layouts/main',$data);
    }
    
    function add(){  
 
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
       /*  ini_set('upload_max_filesize', '750M');
        ini_set('post_max_size', '750M');                               
        ini_set('max_input_time', 3600);                                
        ini_set('max_execution_time', 3600); */
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title','Title','required|trim');
        $data['title'] = 'Add gallery';
        if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
                'active' => $this->input->post('active'),
                'image'  => $this->input->post('image'),
                'media_type' => $this->input->post('media_type'),
                'title'  => $this->input->post('title'),
                'by_user' => $by_user,
            );
            if(!is_dir(GALLERY_IMAGE_PATH)){
                mkdir(GALLERY_IMAGE_PATH, 0755, true);
            }
            $params = array(
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'image' =>  $this->input->post('file_hidden'),
                'media_type' => $this->input->post('media_type'),
                'title' => $this->input->post('title'),
                'by_user' => $by_user,
            );

            $id = $this->Gallery_model->add_gallery($params);
            if($id){
                //activity update start              
                    $activity_name= GALLAEY_ADD;
                    $description= 'New gallery '.$params['title'].' with file '.$params['image'].' having type '.$params['media_type'].' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/gallery/index');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/gallery/add');
            }  


            /* $config['upload_path']   = GALLERY_IMAGE_PATH;
            $config['allowed_types'] = GALLERY_ALLOWED_TYPES;
            $config['encrypt_name']  = FALSE;         
            $this->load->library('upload',$config);

                if($this->upload->do_upload("image")){
                    $data = array('upload_data' => $this->upload->data());
                    $image= $data['upload_data']['file_name'];
                    $params = array(
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'image' => $image,
                        'media_type' => $this->input->post('media_type'),
                        'title' => $this->input->post('title'),
                        'by_user' => $by_user,
                    );
                    $id = $this->Gallery_model->add_gallery($params);
                    if($id){
                        //activity update start              
                            $activity_name= GALLAEY_ADD;
                            $description= 'New gallery '.$params['title'].' with file '.$image.' having type '.$params['media_type'].' added';
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        //activity update end
                        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                        redirect('adminController/gallery/index');
                    }else{
                        $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                        redirect('adminController/gallery/add');
                    }                    
                    
                }else{
                    $params = array(
                        'active' => $this->input->post('active'),                        
                        'media_type' => $this->input->post('media_type'),
                        'title' => $this->input->post('title'),
                        'by_user' => $by_user,
                    );
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/gallery/add');
                }  */
        }
        else
        {            
            $data['_view'] = 'gallery/add';
            $this->load->view('layouts/main',$data);
        }
    }
    
    function edit($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        ini_set('upload_max_filesize', '750M');
        ini_set('post_max_size', '750M');                               
        ini_set('max_input_time', 3600);                                
        ini_set('max_execution_time', 3600);
        $data['gallery'] = $this->Gallery_model->get_gallery($id);
        $data['title'] = 'Edit gallery';
        if(isset($data['gallery']['id']))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title','Title','required|trim'); 
            if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
               $params = array(
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'image' => $this->input->post('file_hidden'),
                        'media_type' => $this->input->post('media_type'),
                        'title' => $this->input->post('title'),
                        'by_user' => $by_user,
                    );  
                if(!file_exists(GALLERY_IMAGE_PATH)){
                    mkdir(GALLERY_IMAGE_PATH, 0755, true);
                }
                /* $config['upload_path']   = GALLERY_IMAGE_PATH;
                $config['allowed_types'] = GALLERY_ALLOWED_TYPES;
                $config['encrypt_name']  = FALSE;         
                $this->load->library('upload',$config);

                if($this->upload->do_upload("image")){
                    $data = array('upload_data' => $this->upload->data());
                    $image= $data['upload_data']['file_name'];
                    $params = array(
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'image' => $image,
                        'media_type' => $this->input->post('media_type'),
                        'title' => $this->input->post('title'),
                        'by_user' => $by_user,
                    );                    
                }else{
                   // $params = array(
                     //   'active' => $this->input->post('active'),
                    //    'media_type' => $this->input->post('media_type'),
                     //   'title' => $this->input->post('title'),
                     //   'by_user' => $by_user,
                   // );
                } */
                
                $idd = $this->Gallery_model->update_gallery($id,$params);
                if($idd){
                    $oldData = 'Gallery '.$data['gallery']['title'].'/'.$data['gallery']['media_type'].'/'.$data['gallery']['image'].' updated to ';
                    $newData = ''.$params['title'].'/'.$params['media_type'].'/'.$params['image'].'';
                    //activity update start              
                        $activity_name= GALLAEY_UPDATE;
                        $description= ''.$oldData.''.$newData.'';
                        $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/gallery/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/gallery/edit/'.$id);
                }                
            }
            else
            {
                $data['_view'] = 'gallery/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }   
    

    /*function activate_deactivete_()
    {  
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $by_user=$_SESSION['UserId'];

        $id = $this->input->post('id', true);
        $active = $this->input->post('active', true);
        $table = $this->input->post('table', true);
        $pk = $this->input->post('pk', true);
        
        if($active==1){
            $idd = $this->Gallery_model->update_one($id, $active, $table, $pk);
            //activity update start              
                $activity_name= ACTIVATION;
                $description= ''.$table.' data Activated/opened having PK-ID '.$id.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
        }else{
            $idd = $this->Gallery_model->update_null($id, $active, $table, $pk);
            //activity update start              
                $activity_name= DEACTIVATION;
                $description= ''.$table.' data De-activated/closed having PK-ID '.$id.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
        }

        echo $idd;       
    }*/    
    
}
