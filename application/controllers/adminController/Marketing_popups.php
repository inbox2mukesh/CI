<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Marketing_popups extends MY_Controller{
    
    function __construct(){
        parent::__construct();
        //$this->checkFirstLogin();
        $this->load->model('Marketing_popups_model');  

        $today = date('d-m-Y');
        $todaystr = strtotime($today);
        $this->Marketing_popups_model->deactivate_popup($todaystr);
        $this->Marketing_popups_model->activate_popup($todaystr);      
    }
    
    function index(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect(WOSA_ADMIN_URL.'error_cl/index');}
        $data['si'] = 1;
        //access control ends
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url(WOSA_ADMIN_URL.'marketing_popups/index?');
        $config['total_rows'] = $this->Marketing_popups_model->get_all_marketing_popups_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Marketing popups';
        $data['marketing_popups'] = $this->Marketing_popups_model->get_all_marketing_popups($params);        
        $data['_view'] = 'marketing_popups/index';
        $this->load->view('layouts/main',$data);
    }

    function add(){   
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect(WOSA_ADMIN_URL.'error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title','Title','required|trim');
        $this->form_validation->set_rules('link','Link','required|trim');
        $this->form_validation->set_rules('marketing_date','Date','required');
        $data['title'] = 'Add Marketing popup';
        if($this->form_validation->run())     
        {   
            if(!file_exists(MARKETING_POPUPS_IMAGE_PATH)){
                mkdir(MARKETING_POPUPS_IMAGE_PATH, 0777, true);
            }
            
            $by_user=$_SESSION['UserId'];
            $marketing_date=$this->input->post('marketing_date');
            $marketing_date_arr=explode(' - ',$marketing_date);
            $start_date=trim($marketing_date_arr[0]);
            $end_date=trim($marketing_date_arr[1]);

            $params = array(
                'start_date'=> $start_date, 
                'startDateStr'=> strtotime($start_date),
                'end_date'=> $end_date, 
                'endDateStr'=>strtotime($end_date),
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'image'  => $this->input->post('image'),
                'title'  => $this->input->post('title'),
                'link' => $this->input->post('link'),
                'desc' => $this->input->post('desc'),
                'by_user' => $by_user,
            );
            $config['upload_path']   = MARKETING_POPUPS_IMAGE_PATH;
            $config['allowed_types'] = MARKETING_POPUPS_ALLOWED_TYPES;
            $config['encrypt_name']  = FALSE;         
            $this->load->library('upload',$config);

                if($this->upload->do_upload("image")){
                    $data1 = array('upload_data' => $this->upload->data());
                    $image= $data1['upload_data']['file_name'];
                    $params = array(
                        'start_date'=> $start_date, 
                        'startDateStr'=> strtotime($start_date),
                        'end_date'=> $end_date, 
                        'endDateStr'=>strtotime($end_date),
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'image' => $image,
                        'title' => $this->input->post('title'),
                        'link' => $this->input->post('link'),
                        'desc' => $this->input->post('desc'),
                        'by_user' => $by_user,
                    );
                    $id = $this->Marketing_popups_model->add_marketing_popups($params);
                    if($id){
                        //activity update start              
                            $activity_name= MARKETING_POPUP_ADD;
                            $description= 'New marketing popup having file '.$image.' with link '.$params['link'].'';
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        //activity update end
                        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                        redirect('adminController/marketing_popups/index');
                    }else{
                        $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                        redirect('adminController/marketing_popups/add');
                    }                    
                    
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/marketing_popups/add');
                } 
        }
        else
        {            
            $data['_view'] = 'marketing_popups/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    
    function edit($id)
    { 
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect(WOSA_ADMIN_URL.'error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['marketing_popups'] = $this->Marketing_popups_model->get_marketing_popups($id);
        $data['title'] = 'Edit Marketing Popups';
        if(isset($data['marketing_popups']['id']))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title','Title','required|trim'); 
            $this->form_validation->set_rules('link','Link','required|trim');
            $this->form_validation->set_rules('marketing_date','Date','required');
            if($this->form_validation->run())     
            {   
                $user = $this->session->userdata('admin_login_data');
                foreach ($user as $d){$by_user=$d->id;}

                $marketing_date=$this->input->post('marketing_date');
                $marketing_date_arr=explode(' - ',$marketing_date);
                $start_date=trim($marketing_date_arr[0]);
                $end_date=trim($marketing_date_arr[1]);

                $params = array(
                    'start_date'=> $start_date, 
                    'startDateStr'=> strtotime($start_date),
                    'end_date'=> $end_date, 
                    'endDateStr'=>strtotime($end_date),
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'title' => $this->input->post('title'),
                    'link' => $this->input->post('link'),
                    'by_user' => $by_user,
                );
                $config['upload_path']   = MARKETING_POPUPS_IMAGE_PATH;
                $config['allowed_types'] = MARKETING_POPUPS_ALLOWED_TYPES;
                $config['encrypt_name']  = FALSE;        
                $this->load->library('upload',$config);

                if($this->upload->do_upload("image")){
                    $data1 = array('upload_data' => $this->upload->data());
                    $image= $data1['upload_data']['file_name'];
                    $params = array(
                        'start_date'=> $start_date, 
                        'startDateStr'=> strtotime($start_date),
                        'end_date'=> $end_date, 
                        'endDateStr'=>strtotime($end_date),
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'image' => $image,
                        'title' => $this->input->post('title'),
                        'link' => $this->input->post('link'),
                        'desc' => $this->input->post('desc'),
                        'by_user' => $by_user,
                    );                    
                }else{
                    $params = array(
                        'start_date'=> $start_date, 
                        'startDateStr'=> strtotime($start_date),
                        'end_date'=> $end_date, 
                        'endDateStr'=>strtotime($end_date),
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'title' => $this->input->post('title'),
                        'link' => $this->input->post('link'),
                        'desc' => $this->input->post('desc'),
                        'by_user' => $by_user,
                    );
                }
                $idd = $this->Marketing_popups_model->update_marketing_popups($id,$params);
                if($idd){
                    //activity update start              
                        $activity_name= MARKETING_POPUP_UPDATE;
                        $description= 'Marketing popup having file '.$data['marketing_popups']['image'].' with link '.$data['marketing_popups']['link'].' updated to file '.$params['image'].' with link '.$params['link'].'';
                        $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/marketing_popups/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);
                    redirect('adminController/marketing_popups/edit/'.$id);           
                }                
            }
            else
            {
                $data['_view'] = 'marketing_popups/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
    function remove($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect(WOSA_ADMIN_URL.'error_cl/index');}
        //access control ends
        $user = $this->session->userdata('admin_login_data');
        foreach ($user as $d){$by_user=$d->id;}

        $marketing_popups = $this->Marketing_popups_model->get_marketing_popups($id);
        if(isset($marketing_popups['id']))
        {           
            //activity update start              
                $activity_name= MARKETING_POPUP_DELETE;
                $description= 'Marketing popup with file '.$marketing_popups['image'].' and link '.$marketing_popups['link'].' having PK-ID '.$id.' deleted';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
            $this->Marketing_popups_model->delete_marketing_popups($id);
            $del_picture=$marketing_popups['image'];
            unlink(MARKETING_POPUPS_IMAGE_PATH.$del_picture);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect(WOSA_ADMIN_URL.'marketing_popups/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

    
}
