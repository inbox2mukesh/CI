<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/ 
class Role extends MY_Controller{
    
    function __construct(){
        parent::__construct();
        if ( !$this->_is_logged_in()) {redirect('adminController/login'); }
        $this->load->model('Role_model'); 
    }

    function auto_clean_assigned_role()
    {
        if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){
            $this->Role_model->clean_assigned_role();
            $by_user=$_SESSION['UserId'];
            //activity update start           
                $activity_name= EMPTY_ROLE_ACCESS;
                $description='Role access cleaned';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
            redirect('adminController/role/index');
        }else{
            return 0;
        }        
        
    }    

    function ajax_get_module_desc(){

        $controller_id = $this->input->post('controller_id', TRUE);
        if($controller_id!=''){
            $get_module_desc = $this->Role_model->get_module_desc($controller_id);
            $controller_desc = $get_module_desc['controller_desc'];
            $controller_alias = $get_module_desc['controller_alias'];
            header('Content-Type: application/json');
            $response=['controller_desc'=>$controller_desc,'controller_alias'=> $controller_alias, 'status'=>'true'];
            echo json_encode($response);

        }else{
            header('Content-Type: application/json');
            $response=['controller_desc'=>$controller_desc,'controller_alias'=> $controller_alias,'status'=>'false'];
            echo json_encode($response);
        }

    }

    function ajax_get_method_desc(){

        $method_id = $this->input->post('method_id', TRUE);
        if($method_id!=''){
            $get_method_desc = $this->Role_model->get_method_desc($method_id);
            $method_desc = $get_method_desc['method_desc'];
            $method_alias = $get_method_desc['method_alias'];
            header('Content-Type: application/json');
            $response=['method_desc'=>$method_desc,'method_alias'=> $method_alias, 'status'=>'true'];
            echo json_encode($response);

        }else{
            header('Content-Type: application/json');
            $response=['method_desc'=>$method_desc,'method_alias'=> $method_alias,'status'=>'false'];
            echo json_encode($response);
        }
    }

    function add_Method_Description_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId']; 

        $method_id = $this->input->post('method_id', TRUE);
        $method_desc = $this->input->post('method_desc', TRUE);
        $method_alias = $this->input->post('method_alias', TRUE);

        $params = array('method_desc'=>$method_desc, 'method_alias'=>$method_alias);

        if($method_id!=''){
            $up = $this->Role_model->update_method_desc($method_id,$params);
            if($up){  
                //activity update start           
                    $activity_name= METHOD_DESCRIPTION_UPDATE;
                    $description='method description updated';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                header('Content-Type: application/json');
                $response = ['msg'=>SUCCESS_MSG, 'status'=>'true'];
                echo json_encode($response);
            }else{  
                header('Content-Type: application/json');
                $response = ['msg'=>FAILED_MSG, 'status'=>'false'];
                echo json_encode($response);
            } 

        }else{
            header('Content-Type: application/json');
            $response = 0;
            echo json_encode($response);
        }
    }

    function add_Module_Description_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];        

        $controller_id = $this->input->post('controller_id', TRUE);
        $module_desc = $this->input->post('module_desc', TRUE);
        $module_alias = $this->input->post('module_alias', TRUE);

        $params = array('controller_desc'=>$module_desc, 'controller_alias'=>$module_alias);

        if($controller_id!=''){
            $up = $this->Role_model->update_module_desc($controller_id,$params);
            if($up){  
                //activity update start           
                    $activity_name= MODULE_DESCRIPTION_UPDATE;
                    $description='Module description updated';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                header('Content-Type: application/json');
                $response = ['msg'=>SUCCESS_MSG, 'status'=>'true'];
                echo json_encode($response);
            }else{  
                header('Content-Type: application/json');
                $response = ['msg'=>FAILED_MSG, 'status'=>'false'];
                echo json_encode($response);
            } 

        }else{
            header('Content-Type: application/json');
            $response = 0;
            echo json_encode($response);
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
        $config['base_url'] = site_url('adminController/role/index?');
        $config['total_rows'] = $this->Role_model->get_all_roles_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Roles';
        $data['roles'] = $this->Role_model->get_all_roles($params);        
        $data['_view'] = 'role/index';
        $this->load->view('layouts/main',$data);
    }
    
    function add(){ 

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        
        $data['title'] = 'Add Role';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name','Role name','required|trim');      
        if($this->form_validation->run())     
        {   
            $by_user=$_SESSION['UserId'];
            $params = array(
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('name')))),
                'by_user' => $by_user,
            );            
            $id = $this->Role_model->add_role($params);
            if($id=='duplicate'){
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/role/index');
            }elseif($id and $id!='duplicate'){
                //activity update start              
                    $activity_name= ROLE_ADD;
                    $description= 'New role '.$params['name'].' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/role/index');                
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/role/add');
            }            
        }
        else
        {            
            $data['_view'] = 'role/add';
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
        
        $data['title'] = 'Edit Role';
        $data['role'] = $this->Role_model->get_role($id);
        
        if(isset($data['role']['id']))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name','Role name','required|trim');      
            if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('name')))),
                    'by_user' => $by_user,
                );
                $idd = $this->Role_model->update_role($id,$params);
                if($idd=='duplicate'){
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);           
                    redirect('adminController/role/index');
                }elseif($idd and $idd!='duplicate'){
                    //activity update start              
                        $activity_name= ROLE_UPDATE;
                        unset($data['role']['id'],$data['role']['created'],$data['role']['modified']);//unset extras from array
                        $uaID = 'role'.$id;
                        $diff1 =  json_encode(array_diff($data['role'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['role']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                        
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/role/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/role/edit/'.$id);
                } 
            }
            else
            {
                $data['_view'] = 'role/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
    function remove($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        
        $role = $this->Role_model->get_role($id);
        if(isset($role['id']))
        {
            //activity update start              
                $activity_name= ROLE_DELETE;
                $description= 'Role '.$role['name'].' having PK-ID '.$id.' deleted';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
            $this->Role_model->delete_role($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/role/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
    function manage_role_($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}        
        //access control ends

        $data['title'] = 'Manage Role';
        $data['role'] = $this->Role_model->get_role($id);
        $data['roledata'] = $this->Role_model->get_role_data($id);
        if(isset($data['role']['id']))
        {            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('ok','OK required','trim');      
            if($this->form_validation->run())     
            {  
                $this->Role_model->delete_role_access($id); 
                $by_user=$_SESSION['UserId'];

                $cb_method[] = $this->input->post('cb_method');
                
                foreach ($cb_method[0] as $c) {

                    $arr = explode("~", $c, 2);
                    $controller_id = $arr[0];
                    $method_id = $arr[1];
                    $params = array(
                        'role_id' => $id,
                        'controller_id'=>$controller_id,
                        'method_id' => $method_id,
                        'by_user' => $by_user,
                    );
                    $idd = $this->Role_model->add_access($params);
                }

                if($idd){
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/role/manage_role_/'.$id);
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);
                    redirect('adminController/role/manage_role_/'.$id);
                }

            }else{
                $cData = $this->Role_model->get_all_controller();
                foreach ($cData as $key => $c) {
                    $cData[$key]['Methods'] = $this->Role_model->get_all_methods($c['id']);
                }
                $data['controllers'] = $cData;
                $data['_view'] = 'role/manage_role'; 
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

    function _is_checked($role_id,$controller_id,$method_id){
        
        return $this->Role_model->check_duplicate_access($role_id,$controller_id,$method_id);
    }    

    function manage_controller(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends

        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/role/manage_controller?');
        $config['total_rows'] = $this->Role_model->get_all_controller_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Controllers';
        $data['controllerCount'] = $config['total_rows'];
        $data['all_controller_list'] = $this->Role_model->get_all_controller($params);        
        $data['_view'] = 'role/manage_controller';
        $this->load->view('layouts/main',$data);
    }

    function manage_controller_method(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Methods';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/role/manage_controller_method?');
        $config['total_rows'] = $this->Role_model->get_all_method_count();
        $this->pagination->initialize($config);
        $this->load->library('form_validation');         
        $this->form_validation->set_rules('fake_id', 'Type method', 'required');

        if($this->form_validation->run()){ 

            $controller_id = $this->input->post('controller_id');
            $params['limit'] = RECORDS_PER_PAGE; 
            $params['offset']= ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
            $config = $this->config->item('pagination');
            $config['base_url'] = site_url('adminController/role/manage_controller_method?'); 
            $config['total_rows'] = count($this->Role_model->getsearchMethodCount($controller_id));
            $this->pagination->initialize($config);
            $getMethodData = $this->Role_model->searchMethod($controller_id);
            $data['all_method_list']=$getMethodData;
            if(!empty($getMethodData)){
                $this->session->set_flashdata('flsh_msg', SEARCH_MSG);
            }else{
                $this->session->set_flashdata('flsh_msg', SEARCH_MSG_404);
            } 
            $data['all_controller_list'] = $this->Role_model->get_all_controller();        
            $data['_view'] = 'role/manage_controller_method';
            $this->load->view('layouts/main',$data);

        }else{
            $data['all_method_list'] = $this->Role_model->get_all_method_list($params);
            $data['all_controller_list'] = $this->Role_model->get_all_controller();        
            $data['_view'] = 'role/manage_controller_method';
            $this->load->view('layouts/main',$data);
        }
    }
    
    function run_role(){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends 
        $by_user=$_SESSION['UserId'];
               
        $controllers = get_filenames(APPPATH . 'controllers/adminController', FALSE, TRUE);
        foreach($controllers as $k => $v ){
            if(strpos($v, '.php') === FALSE){
                unset($controllers[$k] );
            }
        }

        foreach($controllers as $controller){            
            $excludedController=array(
                'Dashboard.php','Ckeditor.php','Login.php','Error_cl.php','Cron_tab.php','Forgot_password.php','Gender.php','Leads.php','Time_slot_master.php','Student_post.php','Discount.php','Classroom_post.php',
            );
            if(in_array($controller, $excludedController)){

            }else{
                $controller_data = $this->Role_model->check_controller($controller);
                if(count($controller_data)>0){
                    $id = $controller_data[0]['id'];
                    $params = array(
                        'controller_name' => $controller,
                    );
                    $this->Role_model->update_controller($id,$params);
                    $controller_id=$id;

                }else{
                    $params = array(
                        'controller_name' => $controller,
                        'controller_alias' => $controller,
                    );
                    $controller_id = $this->Role_model->add_controller($params);
                } 
                include_once APPPATH . 'controllers/adminController/' . $controller;
                $methods = get_class_methods(str_replace( '.php', '', $controller));
                foreach($methods as $method){ 

                    $excludedMethod=array(                    
                        'walk_dir', 
                        'CheckImgExt', 
                        'browse',
                        'get_instance',
                        'logout',
                        'Forgot_password', 
                        'profile_', 
                        'change_password',
                        'dashboard',
                        'crypto_rand_secure_',
                        'getUnicode_',
                        'schedule_discount',
                        'morning_attendance_',
                        'evening_attendance_',
                        'addUserActivity',
                        'clear_all_',
                        'displayRefundHistory_',
                        'adjust_online_and_inhouse_pack_',
                        'adjust_practice_pack_',
                        'student_transaction_', 
                        'user_activity_',
                        'set_erp_softly',
                        'set_erp_hardly',
                        'add_money_to_wallet',
                    );  
                    if(in_array($method, $excludedMethod)){              

                    }else{

                        $method_data = $this->Role_model->check_method($method,$controller_id);
                        if(count($method_data)>0){
                        }else{
                            //starting from _ajax
                            //starting from sendEmail
                            //starting from sendSMS
                            //starting from _
                            //starting from cronJob_  
                            //starting from auto_                      
                            if(substr($method, 0, 5) === "ajax_" or substr($method, 0, 9) === "sendEmail" or substr($method, 0, 7) === "sendSMS" or substr($method, 0, 1) === "_" or substr($method, 0, 8) === "cronJob_" or substr($method, 0, 5) === "auto_"){
                                $bool=0;
                            }else{
                                $bool=1;
                            }
                            if($bool==1){
                                $params = array(
                                    'controller_id'=>$controller_id,
                                    'method_name' => $method,
                                    'method_alias' => $method,
                                );
                                $this->Role_model->add_method($params);
                            }else{

                            }                        
                        }                    
                    }         
                    
                }                
            }           

        }
        //activity update start              
            $activity_name= ROLE_REFRESH;
            $description= 'All the module refreshed';
            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
        //activity update end
        redirect('adminController/role/index');
    }

    function ajax_getRoleName(){

        $role_id = $this->input->post('role_id', TRUE);
        $getRoleName = $this->Role_model->getRoleName($role_id);
        $roleName=$getRoleName['name'];
        if($roleName){
            header('Content-Type: application/json');
            $response = ['msg'=>'success', 'status'=>'true','roleName'=>$roleName ];
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'failed', 'status'=>'false','roleName'=>'' ];
            echo json_encode($response);
            
        }
    }

    /*function updateMenuPriority_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $id = $this->input->post('id', TRUE);
        $val = $this->input->post('val', TRUE);
        $params=array('menuPriority'=>$val);
        $up = $this->Role_model->update_controller($id,$params);
        if($up){
            //activity update start              
                $activity_name= MENU_ORDER_UPDATE;
                $description= '';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
            header('Content-Type: application/json');
            $response = ['msg'=>'success', 'status'=>'true' ];
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'failed', 'status'=>'false' ];
            echo json_encode($response);
            
        }
    }*/

    /*function resetMenuPriority_(){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $params=array('menuPriority'=>500);
        $up = $this->Role_model->resetMenuPriority($params);
        if($up){
            //activity update start              
                $activity_name= RESET_MENU_ORDER;
                $description= '';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
            header('Content-Type: application/json');
            $response = ['msg'=>'success', 'status'=>'true' ];
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'failed', 'status'=>'false' ];
            echo json_encode($response);
            
        }
    }*/

    /*function remove_controller($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        $role = $this->Role_model->get_controller($id);
        if(isset($role['id']))
        {
            $this->Role_model->delete_controller($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/role/manage_controller');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
    function remove_method($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        $role = $this->Role_model->get_method($id);
        if(isset($role['id']))
        {
            $this->Role_model->delete_method($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/role/manage_controller');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/
    
}
