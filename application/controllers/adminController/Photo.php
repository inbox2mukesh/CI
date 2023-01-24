<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Photo extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Photo_model');        
    }
    /*
     * Listing of photo
     */
    function index($test_module_id=0)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $this->load->library('Cacher');
        $this->cacher->initiate_cache(CACHE_ENGINE);

        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/photo/index/'.$test_module_id.'?');
        $config['total_rows'] = $this->Photo_model->get_all_photo_count($test_module_id);
        $this->pagination->initialize($config);
        $data['title'] = 'Photo';        
        $data['photo'] = $this->Photo_model->get_all_photo($test_module_id,$params);
        $data['_view'] = 'photo/index';
        $this->load->view('layouts/main',$data); 
    }
    /*
     * Adding a new photo
     */
    function add()
    {   
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $this->load->library('Cacher');
        $this->cacher->initiate_cache(CACHE_ENGINE);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('image','image','trim');
        $data['title'] = 'Add Photo';
        if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            if(!file_exists(PACKAGE_FILE_PATH)){
                mkdir(PHOTO_IMAGE_PATH, 0777, true);
            }
            $config['upload_path']   = PHOTO_IMAGE_PATH;
            $config['allowed_types'] = WEBP_FILE_TYPES;
            $config['encrypt_name']  = FALSE;         
            $this->load->library('upload',$config);

                if($this->upload->do_upload("image")){
                    $data = array('upload_data' => $this->upload->data());
                    $image= $data['upload_data']['file_name'];
                }else{
                    //echo $this->upload->display_errors();
                    $image=NULL;
                }

                $params = array(
                    'image'=> $image,
                    'active'=>$this->input->post('active') ? $this->input->post('active') : 0,                 
                    'by_user'=> $by_user,
                );                               
                $idd = $this->Photo_model->add_photo($params);                
                    if($idd){  
                          //activity update start              
                          $activity_name= "Photo Added";
                          $description= ''.json_encode($params).'';
                          $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                          //activity update end                      
                        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                        redirect('adminController/photo/index/'.$params['test_module_id']);
                    }else{
                        $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                        redirect('adminController/photo/add');
                    } 
        }
        else
        {  
            $data['_view'] = 'photo/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a photo
     */
    function edit($id)
    { 
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['photo'] = $this->Photo_model->get_photo($id);
        $data['title'] = 'Edit Photo';
        $flag_mediaFile=0;
        if(isset($data['photo']['id']))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('image','image','trim');
            if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
                    'active' => $this->input->post('active'),
                    'by_user' => $by_user,
                );
                if(!file_exists(PACKAGE_FILE_PATH)){
                    mkdir(PHOTO_IMAGE_PATH, 0777, true);
                }
                $config['upload_path']   = PHOTO_IMAGE_PATH;
                $config['allowed_types'] = WEBP_FILE_TYPES;
                $config['encrypt_name']  = FALSE;         
                $this->load->library('upload',$config);

                if($this->upload->do_upload("image")){
                    $flag_mediaFile=1;
                    $datag= array('upload_data' => $this->upload->data());
                    $image= $datag['upload_data']['file_name'];
                    $params = array(
                        'image' => $image,
                        'active'=> $this->input->post('active') ? $this->input->post('active') : 0,                      
                        'by_user' => $by_user,
                    );  
                    unlink($this->input->post('hid_image'));                   
                }else{
                    $params = array(
                        //'image' => $image,
                        'active'=>$this->input->post('active') ? $this->input->post('active') : 0,                        
                        'by_user' => $by_user,
                    );
                }
                //$idd = $this->Photo_model->update_photo($id,$params);
                $idd = $this->Photo_model->update_photo($id,$params);              

                if($idd){
                //activity update start                            
                $activity_name= "Photo Updated";
                unset($data['photo'] ['id'],$data['photo']['created'],$data['photo']['modified']);//unset extras from array               
                if($flag_mediaFile==0)
                {
                    unset($data['photo'] ['image']);
                }             
                $uaID = 'photo'.$idd;
                $diff1 =  json_encode(array_diff($data['photo'], $params));//old
                $diff2 =  json_encode(array_diff($params,$data['photo']));//new
                $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                if($diff1!=$diff2){
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                }                                        
                //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/photo/index/'.$params['test_module_id']);
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/photo/edit/'.$id);
                }                
            }
            else
            {
                $data['_view'] = 'photo/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    } 

    /*
     * Deleting photo
     */
    function remove($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $photo = $this->Photo_model->get_photo($id);
        if(isset($photo['id']))
        {
            $this->Photo_model->delete_photo($id);
            $del_picture=$photo['image'];
            unlink(PHOTO_IMAGE_PATH.$del_picture);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/photo/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

    function activate_deactivete()
    {  
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $id = $this->input->post('id', true);
        $active = $this->input->post('active', true);
        $table = $this->input->post('table', true);
        $pk = $this->input->post('pk', true);
        
        if($active==1)
            $id = $this->Photo_model->update_one($id, $active, $table, $pk);
        else
            $id = $this->Photo_model->update_null($id, $active, $table, $pk);
        echo $id;       
    }

    
    
}
