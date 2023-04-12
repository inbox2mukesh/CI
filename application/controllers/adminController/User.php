<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 class User extends MY_Controller{
    
    function __construct(){

        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        
        $this->load->model('User_model');
        $this->load->model('Role_model');
        $this->load->model('User_role_model');
        $this->load->model('Gender_model');
        $this->load->model('Center_location_model');
        $this->load->model('Designation_master_model'); 
        $this->load->model('Country_model');
        $this->load->model('State_model');
        $this->load->model('City_model');
        $this->load->model('Test_module_model');
        $this->load->model('Programe_master_model');
        $this->load->model('Batch_master_model'); 
        $this->load->model('Category_master_model'); 
        $this->load->model('Division_master_model');
        $today = date('d-m-Y');
        $todaystr = strtotime($today);
        $this->User_model->deactivateEmployeeOnExitDate($todaystr);
        $by_user=$_SESSION['UserId'];
    }

    function ajax_refresh_live_time(){

        echo date("d-M-Y h:i A");
    }

    function auto_clean_employee(){

        if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){
            $del = $this->User_model->clean_employee_tran();
            $by_user = $_SESSION['UserId'];
            if($del){            
                //activity update start
                    $activity_name= 'EMPLOYEE_CLEANED';
                    $description= '';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->session->set_flashdata('flsh_msg', DEL_MSG);
                redirect('adminController/user/employee_list');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/user/employee_list');
            }
        }else{
            $this->session->set_flashdata('flsh_msg', FAILED_MSG);
            redirect('adminController/user/employee_list');
        }
                
                       
    }

    function remove_trainer_batch_($user_batch_id,$user_id){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends       
       
        $del = $this->User_model->delete_User_Batch($user_batch_id,base64_decode($user_id));
        if($del){
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/user/manage_trainer_access_/'.$user_id);
        }else{
            $this->session->set_flashdata('flsh_msg', FAILED_MSG);
            redirect('adminController/user/manage_trainer_access_/'.$user_id);
        }               
    }

    function remove_trainer_access_($user_test_module_id,$user_id){ 
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends        
        $user_id2 =  base64_decode($user_id);
        $by_user = $_SESSION['UserId'];            
        //activity update start
            $activity_name= TRAINER_ACCESS_REMOVED;
            $description= '';
            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
        //activity update end
        $this->User_model->remove_trainer_access_($user_test_module_id,$user_id2);
        $this->session->set_flashdata('flsh_msg', DEL_MSG);
        redirect('adminController/user/manage_trainer_access_/'.$user_id);
    }

    function manage_trainer_access_($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends 
        $id = base64_decode($id);
        $data['title'] = 'Manage trainer';
        $data['user'] = $this->User_model->get_user($id);
        $get_user_role = $this->User_model->get_user_roleName($id);
        $roleName = $get_user_role['name'];       
        
        $pattern = "/Trainer/i";
        $isTrainer = preg_match($pattern, $roleName);
        if(!$isTrainer){
            $this->session->set_flashdata('flsh_msg', AUTHENTIC_MSD);
            redirect('adminController/user/employee_list');
        }else{
            
        }        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fake','fake','required');
        if($this->form_validation->run()){
            
            $category_id=[];$batch_id=[];$batchSaved=0;
            $isProfileSaved = 0;$batchSaved=0;
                
            $test_module_id = $this->input->post('test_module_id');
            $programe_id = $this->input->post('programe_id'); 

            $category_id = $this->input->post('category_id');
            sort($category_id, SORT_NUMERIC);
            $category_ids = implode(',', $category_id);

            $batch_id = $this->input->post('batch_id');

            if(!empty($batch_id)){
                foreach ($batch_id as $b) {                  
                    $params2=array(
                        'user_id' =>  $id,
                        'batch_id'=> $b,
                        'by_user'=>$by_user
                    );
                    $this->User_model->add_user_batch($params2);
                }
                $batchSaved=1;
            }else{
                $batchSaved=0;
            }

            if($this->input->post('test_module_id') and $this->input->post('programe_id') and !empty($this->input->post('category_id'))){
                foreach($category_id as $c){
                    $params =array(
                        'test_module_id'=>$this->input->post('test_module_id'),
                        'programe_id'=>$this->input->post('programe_id'),
                        'category_id'=>$c,
                        'user_id'=> $id,
                        'by_user'=>$by_user,
                    );
                    $idd = $this->User_model->add_trainer_profile($params);
                    $isProfileSaved=1;                    
                }
                if($isProfileSaved == 1){
                    $params =array(
                        'test_module_id'=>$this->input->post('test_module_id'),
                        'programe_id'=>$this->input->post('programe_id'),
                        'category_id'=>$category_ids,
                        'user_id'=> $id,
                        'by_user'=>$by_user,
                    );
                    $idd = $this->User_model->add_trainer_profile($params);
                    //activity update start              
                        $activity_name= TRAINER_ACCESS_UPDATED;
                        $description= '';
                        $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                    //activity update end
                }              
                
            }else{
                $isProfileSaved=0;
            }
            
            if($isProfileSaved==1){
                $this->session->set_flashdata('flsh_msg', UPDATE_MSG);
                redirect('adminController/user/manage_trainer_access_/'.base64_encode($id));
            }elseif($isProfileSaved==0 and $batchSaved==0){                
                $this->session->set_flashdata('flsh_msg', '<div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>WARNING:</strong> Transaction failed? Please select course, programe and category<a href="#" class="alert-link"></a>.
                </div>');
                redirect('adminController/user/manage_trainer_access_/'.base64_encode($id)); 
            }else{
                if($batchSaved==1 or $isProfileSaved==1){
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/user/manage_trainer_access_/'.base64_encode($id));
                }else{
                    $this->session->set_flashdata('flsh_msg', '<div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>WARNING:</strong> Transaction failed? Please select course, programe and category<a href="#" class="alert-link"></a>.
                </div>');
                    redirect('adminController/user/manage_trainer_access_/'.base64_encode($id));
                }                
            }            
                
        }else{ 
            $data['trainerbatchList'] = $this->User_model->get_user_batch($id);
            $trainerAccessList= $this->User_model->get_trainer_access_list($id);

            foreach($trainerAccessList as $key => $cd){
                $pattern = "/,/i";
                $isMultipeCategory = preg_match($pattern, $cd['category_id']);
                if($isMultipeCategory){
                    $cat_arr = explode(',', $cd['category_id']);
                    $cat_arr_count = count($cat_arr);
                    for ($i=0; $i < $cat_arr_count; $i++) { 
                        $get_category_name = $this->Category_master_model->get_category_name($cat_arr[$i]);
                        foreach ($get_category_name as $key2 => $m) {                
                            $trainerAccessList[$key]['Category'][$key2].=$m.', ';                       
                        }                    
                    }
                }else{
                    $get_category_name = $this->Category_master_model->get_category_name($cd['category_id']);
                    foreach ($get_category_name as $key2 => $m) {                
                        $trainerAccessList[$key]['Category'][$key2]=$m;                       
                    }
                }
            }            
            $data['trainer_access_list'] = $trainerAccessList;
            $data['all_programe_masters'] = $this->Programe_master_model->get_all_programe_masters_active();
            $data['all_test_module']= $this->Test_module_model->get_all_test_module_active();
            $data['all_batches']= $this->Batch_master_model->get_all_batch_active();
            $data['_view'] = 'user/manage_trainer_access';
            $this->load->view('layouts/main',$data);
        }    
            
    }

    function employee_list(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}        
        //access control ends
        $UserFunctionalBranch=$this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/user/employee_list?');
        $config['total_rows'] = $this->User_model->get_all_employee_count($_SESSION['roleName'],$userBranch);
        //echo $config['total_rows'];
        $this->pagination->initialize($config);
        $data['title'] = 'Employee'; 
        $userData= $this->User_model->get_all_employee($_SESSION['roleName'],$userBranch,$params);
            foreach ($userData as $key => $c) {
                
                $mData = $this->User_model->get_user_branch($c['id']);
                foreach ($mData as $key2 => $m) {                
                    $userData[$key]['Branch'][$key2]=$m;                       
                } 
                $cntData = $this->User_model->get_user_country($c['id']);
                foreach ($cntData as $key2 => $cnt) {                
                    $userData[$key]['Country'][$key2]=$cnt;                       
                }
                
                $divisionData = $this->User_model->get_user_division($c['id']);
                foreach ($divisionData as $key3 => $division) {                
                    $userData[$key]['Division'][$key3]=$division;                       
                }
                
                $centralisedDepartmentData=$this->User_model->get_user_centralised_department($c['id']);
                foreach ($centralisedDepartmentData as $key4 => $department) {                
                    $userData[$key]['centralised_department'][$key4]=$department;
                }
                $decentralisedDepartmentData=$this->User_model->get_user_decentralised_department($c['id']);
                foreach ($decentralisedDepartmentData as $key4 => $department) {                
                    $userData[$key]['decentralised_department'][$key4]=$department;
                }                            
            } 
        $data['all_programe_masters']=$this->Programe_master_model->get_all_programe_masters_active();
        $data['all_test_module'] = $this->Test_module_model->get_all_test_module_active();
        $data['all_batches'] = $this->Batch_master_model->get_all_batch_active();           
        $data['user'] = json_encode($userData);
        $data['_view'] = 'user/index';
        $this->load->view('layouts/main',$data);
    }
    
    function add(){   

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        
        $data['title'] = 'Add Employee'; 
        $this->load->library('form_validation');
        $this->form_validation->set_rules('employeeCode','Employe Code','required|trim');
        $this->form_validation->set_rules('fname','First name','required'); 
        $this->form_validation->set_rules('gender_name','Gender','required');
        $this->form_validation->set_rules('dob','DOB','required');  
        $this->form_validation->set_rules('DOJ','Joining date','required');
        $this->form_validation->set_rules('personal_email','Personal Email','required|valid_email|max_length[60]');
        $this->form_validation->set_rules('country_code_pers','Country code','required');
        $this->form_validation->set_rules('personal_contact','Personal Contact','max_length[10]');
        $this->form_validation->set_rules('center_id_home','Home Branch','required|integer'); 
        $this->form_validation->set_rules('emp_designation','Designation','required|integer');
        $this->form_validation->set_rules('division_id[]','Division','required');
        $this->form_validation->set_rules('center_id[]','Functional branch','required'); 
        $this->form_validation->set_rules('country_id2','Employee country','required|integer');
        $this->form_validation->set_rules('state_id','state','required|integer');
        $this->form_validation->set_rules('city_id','city','required|integer');
        $this->form_validation->set_rules('residential_address','Residential address','required|trim|max_length[100]');    
        
        if($this->form_validation->run())     
        {    
            $role_id = $this->input->post('role_id');
            if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){
                $plain_pwd = PLAIN_PWD;  
            }else{
                $plain_pwd = $this->_getorderTokens(PWD_LEN);
            }            
            
            $country_id = $this->input->post('country_id');//functional country
            $center_id = $this->input->post('center_id');
            $programe_id = $this->input->post('programe_id');
            $test_module_id = $this->input->post('test_module_id');
            $batch_id = $this->input->post('batch_id');
            $category_id = $this->input->post('category_id');
            //$mail_sent = $this->input->post('mail_sent');           
            $division_id = $this->input->post('division_id');

            $country_id2 = $this->input->post('country_id2');//address countrt
            $state_id = $this->input->post('state_id');
            $city_id = $this->input->post('city_id');
            if(!file_exists(EMP_IMAGE_PATH)){
                mkdir(EMP_IMAGE_PATH, 0777, true);
            }
            $config['upload_path']   = EMP_IMAGE_PATH;
            $config['allowed_types'] = EMP_ALLOWED_TYPES;
            $config['encrypt_name']  = FALSE;
            $this->load->library('upload',$config);

            if($this->upload->do_upload("image")){                    
                $data = array('upload_data' => $this->upload->data());
                $image= $data['upload_data']['file_name'];                
            }else{
                $image='';               
            } 
            $params = array(
                'employeeCode' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('employeeCode')))),
                'image'     => $image,                    
                'fname'     => ucfirst($this->input->post('fname')),
                'lname'     => ucfirst($this->input->post('lname')),
                'gender'    => $this->input->post('gender_name'),
                'dob'       => $this->input->post('dob'),
                'center_id_home' => $this->input->post('center_id_home'),
                'emp_designation'=> $this->input->post('emp_designation'),
                'DOB_str'   => strtotime($this->input->post('dob')),
                'MA'        => $this->input->post('MA'),
                'MA_str'    => strtotime($this->input->post('MA')),
                'DOJ'       => $this->input->post('DOJ'),
                'DOJ_str'   => strtotime($this->input->post('DOJ')),
                'personal_email' => $this->input->post('personal_email'),
                'country_code_pers'=> $this->input->post('country_code_pers'), 
                'personal_contact'=>$this->input->post('personal_contact') ? $this->input->post('personal_contact') : NULL,
                'country_id'=>$this->input->post('country_id2'),
                'state_id'=>$this->input->post('state_id'),
                'city_id'=>$this->input->post('city_id'),
                'residential_address'=>$this->input->post('residential_address'),
                'password'  => md5($plain_pwd),
                'by_user'   => $by_user,
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'mail_sent' => $mail_sent,                
            );
            $this->db->trans_start();
            $id = $this->User_model->add_user($params);
            if($id){
                if(!empty($country_id)){
                    foreach ($country_id as $c) {                  
                        $params3=array(
                            'user_id' =>   $id,
                            'country_id'=> $c,
                            'by_user'   => $by_user,
                        );
                        $this->User_model->add_user_country($params3);
                    } 
                }                
                foreach ($center_id as $c) {                  
                    $params4=array(
                        'user_id' =>  $id,
                        'center_id'=> $c,
                        'by_user'  => $by_user,
                    );
                    $this->User_model->add_user_branch($params4);
                }
                $created=$modified=date('Y-m-d H:i:s');
                
                foreach ($division_id as $d) {                  
                    $params6=array(
                        'user_id' =>  $id,
                        'division_id'=> $d,
                        'by_user'  => $by_user,
                        'created'=>$created,
                        'modified'=>$modified
                    );
                    $this->User_model->add_user_division($params6);
                }
                //activity update start              
                    $activity_name= NEW_EMPLOYEE_REG;
                    unset($params['id']);//unset extras from array
                        //$diff1 =  json_encode(array_diff($data['user'], $params));//old
                        //$diff2 =  json_encode(array_diff($params,$data['user']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, json_encode($params));
                    //$description= ''.json_encode($params).'';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                $this->db->trans_complete();
                if($this->db->trans_status() === FALSE){
                    $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                    redirect('adminController/user/add');
                }
                
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/user/employee_list');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/user/add');
            }
            
        }else{             
            $data['all_genders'] = $this->Gender_model->get_all_gender_active();
            $data['all_branch'] = $this->Center_location_model->get_branch();
            $data['all_designation']=$this->Designation_master_model->get_all_designation_active();
            $data['all_countryNoIndia'] = $this->Country_model->getAllCountryNameAPI_deal();
            $data['all_country_code'] = $this->Country_model->getAllCountryCode();
            $data['all_division'] = $this->Division_master_model->get_all_division_active();
            $data['all_country_list'] = $this->Country_model->get_all_country_active();
            $data['_view'] = 'user/add';
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
        $id = base64_decode($id);

        $data['title'] = 'Edit Employee'; 
        $data['user'] = $this->User_model->get_user_data($id);
        $data['user_role'] = $this->User_model->get_user_role($id);
        $data['user_country'] = $this->User_model->get_user_country($id);
        $data['user_branch'] = $this->User_model->get_user_branch($id);                
        $data['user_division'] = $this->User_model->get_user_division($id);
        $data['si'] = 0;
        $division_ids=array();
        $data['branch_list']=array();
        foreach($data['user_division'] as $key=>$val){
            $division_ids[]=$val['division_id'];
        }
        if(!empty($division_ids)){
            $data['branch_list']=$this->Center_location_model->funtionalBranchListByDivision($division_ids);
        }
        if(isset($data['user']['id'])){
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('employeeCode','Employe Code','required|trim|integer');
            $this->form_validation->set_rules('fname','First name','required'); 
            $this->form_validation->set_rules('gender_name','Gender','required');
            $this->form_validation->set_rules('dob','DOB','required|max_length[10]');  
            $this->form_validation->set_rules('DOJ','Joining date','required|max_length[10]');
            $this->form_validation->set_rules('personal_email','Personal Email','required|valid_email|max_length[60]');
            $this->form_validation->set_rules('personal_contact','Personal Contact','required|max_length[10]');
            $this->form_validation->set_rules('center_id_home','Home Branch','required|integer');
            $this->form_validation->set_rules('emp_designation','Designation','required|integer');
            $this->form_validation->set_rules('country_id2','country','required|integer');
            $this->form_validation->set_rules('state_id','state','required|integer');
            $this->form_validation->set_rules('city_id','city','required|integer');
            $this->form_validation->set_rules('residential_address','Address','required|trim');
            //$this->form_validation->set_rules('division_id[]','Division','required');
             
            if($this->form_validation->run())     
            {   
                
                $by_user=$_SESSION['UserId'];
                $upload = 0;
                if($this->input->post('country_id')){
                    $country_id = $this->input->post('country_id');
                }else{
                    $country_id = 'noo';
                }

                if($this->input->post('center_id')){
                    $center_id = $this->input->post('center_id');
                }else{
                    $center_id = 'noo';
                }                 
                if($this->input->post('division_id')){
                    $division_id = $this->input->post('division_id');
                }else{
                    $division_id = 'noo';
                }               
                if(!file_exists(EMP_IMAGE_PATH)){
                    mkdir(EMP_IMAGE_PATH, 0777, true);
                }
                $config['upload_path']   = EMP_IMAGE_PATH;
                $config['allowed_types'] = EMP_ALLOWED_TYPES;
                $config['encrypt_name']  = FALSE;
                $this->load->library('upload',$config);                
                if($this->upload->do_upload("image")){                   
                    $data1 = array('upload_data' => $this->upload->data());
                    $image= $data1['upload_data']['file_name'];
                    $upload = 1;
                    unlink($this->input->post('uploaded_image'));
                }else{                   
                    $image=$data['user']['image'];
                }
                $DOE = $this->input->post('DOE');
                if($DOE==''){
                   $DOE_str = NULL;
                }else{
                    $DOE_str = strtotime($DOE);
                }

                $activep = $this->input->post('active');
                $active= isset($activep) ? 1 : 0;

                if($active==0){
                    $portal_access =0;
                    
                    $params = array(
                    'employeeCode' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('employeeCode')))),
                    'image'     => $image,                    
                    'fname'     => ucfirst($this->input->post('fname')),
                    'lname'     => ucfirst($this->input->post('lname')),
                    'gender'    => $this->input->post('gender_name'),
                    'dob'       => $this->input->post('dob'),
                    'center_id_home' => $this->input->post('center_id_home'),
                    'DOB_str'   => strtotime($this->input->post('dob')),
                    'MA'        => $this->input->post('MA'),
                    'MA_str'    => strtotime($this->input->post('MA')),
                    'DOJ'       => $this->input->post('DOJ'),
                    'DOJ_str'   => strtotime($this->input->post('DOJ')),
                    'DOE'       => $DOE,
                    'DOE_str'   => $DOE_str,
                    'email'     => $this->input->post('email'),
                    'personal_email' => $this->input->post('personal_email'),
                    'country_code_offc'=> $this->input->post('country_code_offc'),
                    'mobile'    => $this->input->post('mobile'), 
                    'country_code_pers'=> $this->input->post('country_code_pers'),
                    'personal_contact'=> $this->input->post('personal_contact'),
                    'country_id'=>$this->input->post('country_id2'),
                    'state_id'=>$this->input->post('state_id'),
                    'city_id'=>$this->input->post('city_id'),               
                    'residential_address' => $this->input->post('residential_address'),
                    'by_user'   => $by_user,
                    'active' => $active,
                    'portal_access'=> $portal_access,
                    'emp_designation'=> $this->input->post('emp_designation'),                    
                );
                }else{
                    $params = array(
                    'employeeCode' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('employeeCode')))),
                    'image'     => $image,                    
                    'fname'     => ucfirst($this->input->post('fname')),
                    'lname'     => ucfirst($this->input->post('lname')),
                    'gender'    => $this->input->post('gender_name'),
                    'dob'       => $this->input->post('dob'),
                    'center_id_home' => $this->input->post('center_id_home'),
                    'DOB_str'   => strtotime($this->input->post('dob')),
                    'MA'        => $this->input->post('MA'),
                    'MA_str'    => strtotime($this->input->post('MA')),
                    'DOJ'       => $this->input->post('DOJ'),
                    'DOJ_str'   => strtotime($this->input->post('DOJ')),
                    'DOE'       => $DOE,
                    'DOE_str'   => $DOE_str,
                    'email'     => $this->input->post('email'),
                    'personal_email' => $this->input->post('personal_email'),
                    'country_code_offc'=> $this->input->post('country_code_offc'),
                    'mobile'    => $this->input->post('mobile'), 
                    'country_code_pers'=> $this->input->post('country_code_pers'),
                    'personal_contact'=> $this->input->post('personal_contact'),
                    'country_id'=>$this->input->post('country_id2'),
                    'state_id'=>$this->input->post('state_id'),
                    'city_id'=>$this->input->post('city_id'),               
                    'residential_address' => $this->input->post('residential_address'),
                    'by_user'   => $by_user,
                    'active' => $active,
                    'emp_designation'=> $this->input->post('emp_designation'),                    
                );
                }
                
                
                if($this->input->post('active') ==0) 
                {
                   $this->User_model->remove_trainer_access($id);
                } 
                $idd = $this->User_model->update_user($id,$params); 
                if($idd){                  

                    if($country_id!='noo'){
                       foreach ($country_id as $c){                   
                            $params1=array(
                                'user_id' => $id,
                                'country_id'=> $c,
                                'by_user'   =>  $by_user,
                            );
                            $this->User_model->add_user_country($params1);
                        } 
                    }
                    if($center_id!='noo'){
                       foreach ($center_id as $c){                   
                            $params2=array(
                                'user_id' => $id,
                                'center_id'=> $c,
                                'by_user'   =>  $by_user,
                            );
                            $this->User_model->add_user_branch($params2);
                        } 
                    }
                                        
                    if($division_id !='noo'){                        
                        foreach ($division_id as $d){                  
                            $params3=array(
                                'user_id' =>  $id,
                                'division_id'=> $d,
                                'by_user'  => $by_user,
                            );
                            $this->User_model->add_user_division($params3);
                        }
                    }
                    //activity update start              
                        $activity_name= EMPLOYEE_PROFILE_UPDATE;
                        if($upload==0){
                            unset($data['user']['id'],$data['user']['created'],$data['user']['modified'],$data['user']['DOB_str'],$data['user']['MA_str'],$data['user']['DOJ_str'],$data['user']['DOE_str'],$data['user']['image']);//unset extras
                            unset($params['DOB_str'],$params['MA_str'],$params['DOJ_str'],$params['DOE_str'],$params['image']);//unset extras
                        }else{
                            unset($data['user']['id'],$data['user']['created'],$data['user']['modified'],$data['user']['DOB_str'],$data['user']['MA_str'],$data['user']['DOJ_str'],$data['user']['DOE_str']);//unset extras
                            unset($params['DOB_str'],$params['MA_str'],$params['DOJ_str'],$params['DOE_str']);//unset extras
                        }                       
                        $uaID  = 'user'.$id;
                        $diff1 =  json_encode(array_diff($data['user'], $params));//old
                        $diff2 =  json_encode(array_diff($params,$data['user']));//new
                        $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                        $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                        if($diff1!=$diff2){
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        }                       
                    //activity update end                  
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);
                    redirect('adminController/user/employee_list');
                
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);
                    redirect('adminController/user/edit/'.$id);
                }          
                
            }else{                
                $data['all_genders'] = $this->Gender_model->get_all_gender_active();
                $data['all_branch'] = $this->Center_location_model->get_branch();
                $data['all_designation'] = $this->Designation_master_model->get_all_designation_active();
                $data['all_countryNoIndia'] = $this->Country_model->getAllCountryNameAPI_deal();
                $data['all_division'] = $this->Division_master_model->get_all_division_active();
                $data['all_country_code'] = $this->Country_model->getAllCountryCode();
                $data['all_country_list'] = $this->Country_model->get_all_country_active();
                $data['all_state_list'] = $this->State_model->get_state_list($data['user']['country_id']);
                $data['all_city_list'] = $this->City_model->get_city_list($data['user']['state_id']);
                $data['_view'] = 'user/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

    function view_user_profile_($id){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}        
        //access control ends
        $id = base64_decode($id);

        $data['title'] = 'Employee profile';  
        $data['user'] = $this->User_model->get_user_view($id);
        $data['_view'] = 'user/view_user_profile';
        $this->load->view('layouts/main',$data);
    }

    function profile_(){
        
        //self profile
        $data['si'] = 0;
        $data['title'] = 'Profile';
        $today = date('d-m-Y');
        //$today2 = date('d-m-Y', strtotime($today. ' - 1 days'));
        $todaystr = strtotime($today);
        $UserActivityData= $this->User_model->getUserActivityToday($_SESSION['UserId'],$todaystr);
        $mData = $this->User_model->get_user_branch($_SESSION['UserId']);
        $fb ='';
        foreach ($mData as $b) {
            $fb .= $b['center_name'].', ';
        }
        $data['userFunctionalBranch']=@$fb;
        $data['UserActivityData']=$UserActivityData;
        $data['_view'] = 'user/profile';
        $this->load->view('layouts/main',$data);
    }

    function user_activity_(){
        
        //$this->benchmark->mark('code_start');
        $data['si'] = 0;        
        $today = date('d-m-Y');
        $today2 = date('d-m-Y', strtotime($today. ' - 5 days'));
        $todaystr = strtotime($today);
        
        //$this->load->library('Cacher');
        //$this->cacher->initiate_cache(CACHE_ENGINE); 
        $this->load->library('pagination');        
        $data['title'] = 'Your activity';
        //$this->db->cache_on();
        $data['UserActivityData']= $this->User_model->getUserActivityToday2($_SESSION['UserId'],$todaystr,$today2);
        $this->db->cache_off();
        $data['_view'] = 'user/user_activity';
        $this->load->view('layouts/main',$data);
        $this->benchmark->mark('code_end');
        //echo $this->benchmark->elapsed_time('code_start', 'code_end');
    }

    function ajax_check_old_pwd(){     

        $id=$_SESSION['UserId'];
        $params = array(
            'password' => md5($this->input->post('old_pwd', true)),                
        );
        $res = $this->User_model->check_old_pwd($id,$params['password']);
            if($res){ 
                header('Content-Type: application/json');
                $response = ['msg'=>'', 'status'=>'true'];
                echo json_encode($response);
            }else{
                header('Content-Type: application/json');
                $response = ['msg'=>'', 'status'=>'false'];
                echo json_encode($response);
            }
    }

    function change_password(){
        $data['si'] = 0;
        $data['title'] = 'Change password'; 
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('op','Old password','required|max_length[14]');
        $this->form_validation->set_rules('psw','New password','required|max_length[14]'); 
        $this->form_validation->set_rules('rnp','re-enter new password','required|max_length[14]|matches[psw]');           

        if($this->form_validation->run())  
        {
            $id=$_SESSION['UserId'];
            $params = array(                
                'password' => md5($this->input->post('psw')),              
            );            
            $id = $this->User_model->change_password($id,$params);
            if($id){  
                //activity update start 
                    $by_user = $id;             
                    $activity_name= EMPLOYEE_PASSWORD_CHANGE;
                    $description='Employee changed his/her password';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end               
                $this->session->set_flashdata('flsh_msg', PWD_CHANGE_SUCCESS_MSG);              
                redirect('adminController/login/logout');
            }else{
                $this->session->set_flashdata('flsh_msg', PWD_CHANGE_FAILED_MSG);
                redirect('adminController/user/profile_');
            }            
        }else{
            $data['_view'] = 'user/profile';
            $this->load->view('layouts/main',$data);
        }

    }

    function ajax_check_user_division_count(){

        $user_id = $this->input->post('user_id', true);
        $response = $this->User_model->check_user_division_count($user_id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function ajax_check_user_functional_branch_count(){

        $user_id = $this->input->post('user_id', true);
        $response = $this->User_model->check_user_functional_branch_count($user_id);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function ajax_getUserSpecialAccess(){        

        $user_id = $this->input->post('user_id', true);
        $role_id = $this->input->post('role_id', true);
        /*if($_SESSION['roleName']==ADMIN){
            $all_roles= $this->Role_model->get_all_roles_active_not_super_admin();
        }else{
            $all_roles= $this->Role_model->get_all_roles_active_not_super_admin();
        }*/
        $all_roles= $this->Role_model->get_all_roles_active_not_super_admin();

        $x ='<select name="role_id" id="role_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="display_trainerCourse(this.value);"><option value="">Select role</option>';                        
            foreach($all_roles as $r){                
                $selected=($r['id'] == $role_id) ? ' selected="selected"' : "";
                $x .= '<option value="'.$r['id'].'" "'.$selected.'">'.$r['name'].'</option>';
            } 
                        
            $x .= '</select><span class="text-danger role_id_err"></span>';

        $roldDD = $x; 
        $userData = $this->User_model->getUserSpecialAccess($user_id);
        if($roldDD){                
            header('Content-Type: application/json');
            $response = ['roldDD'=>$roldDD, 'waiver_power'=>$userData['waiver_power'], 'waiver_upto'=>$userData['waiver_upto'], 'refund_power'=>$userData['refund_power'], 'portal_access'=>$userData['portal_access'] ];
            echo json_encode($response);
        } 
    }
    
    function Update_Special_Access_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $by_user=$_SESSION['UserId'];      
        //access control ends

        $this->load->library('form_validation');  
        $this->form_validation->set_rules('role_id', 'Role', 'trim');      
        $this->form_validation->set_rules('portal_access', 'portal_access', 'trim');
        $this->form_validation->set_rules('waiver_power', 'waiver_power', 'trim');        
        $this->form_validation->set_rules('refund_power', 'refund_power', 'trim');

        if($this->form_validation->run() == false){
            header('Content-Type: application/json');
            $response=['msg'=>'<span class="text-danger">Give all access value</span>','status'=>'false'];
            echo json_encode($response);
        }else{ 
            $role_id= $this->input->post('role_id', true);
            $portal_access= $this->input->post('portal_access', true); 
            $user_id= $this->input->post('user_id', true); 
            $sendMail_pa = $this->input->post('sendMail_pa', true); 

            $portal_access_hidden= $this->input->post('portal_access_hidden', true);
            $role_id_hidden= $this->input->post('role_id_hidden', true);

            $getUserInfo = $this->User_model->getUserInfo($user_id);
            
            if($sendMail_pa==1 and $portal_access==1){

                $fname = $getUserInfo['fname'];
                $lname = $getUserInfo['lname'];
                $name = $fname.' '.$lname;
                $personal_email = $getUserInfo['personal_email'];
                $official_email = $getUserInfo['email'];
                $employeeCode = $getUserInfo['employeeCode'];
                if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){
                    $plain_pwd = PLAIN_PWD;  
                }else{
                    $plain_pwd = $this->_getorderTokens(PWD_LEN);
                }
                if($official_email!=''){
                    $final_email_id = $official_email;
                }else{
                    $final_email_id = $personal_email;
                }
                $datas = array(
                    'portal_access'=> $portal_access,
                    'waiver_power' => $this->input->post('waiver_power', true),
                    'waiver_upto'  => $this->input->post('waiver_upto', true),
                    'refund_power' => $this->input->post('refund_power', true),
                    'by_user'      => $by_user,
                    'password'     => md5($plain_pwd),
                );
                
                if($final_email_id <> ""){
                    $subject='Welcome, your are now active member  at '.COMPANY.' CRM ';
                    $data = array(
                        'name'=> $name,
                        'email'=> $final_email_id,
                        'email_message'=> 'You are now active member  at '.COMPANY.' CRM. your login details are as follows:',
                        'username'=> $employeeCode,
                        'password'=> $plain_pwd,
                        'thanks'=> THANKS,
                        'team'=> WOSA,
                    );
                    if(base_url()!=BASEURL){                       
                        $this->sendEmail_toAdminCreds_($subject,$data);    
                    }else{
                    }                   
                }

            }else{
                $datas = array(
                    'portal_access' => $this->input->post('portal_access', true),
                    'waiver_power' => $this->input->post('waiver_power', true),
                    'waiver_upto' => $this->input->post('waiver_upto', true),
                    'refund_power' => $this->input->post('refund_power', true),
                    'by_user'      => $by_user
                );
            }
            if($portal_access_hidden !=$this->input->post('portal_access', true) || $role_id_hidden !=$this->input->post('role_id', true) ) 
            {
               $this->User_model->remove_trainer_access($user_id);
            } 
            
            $idd = $this->User_model->update_user($user_id,$datas);
            if($idd){
                    $role_count = $this->User_role_model->check_user_role($user_id);
                    if($role_count==0){
                        $params=array(
                            'user_id'=> $user_id,
                            'role_id'=> $role_id,
                        );
                        $rid = $this->User_role_model->add_user_role($params);
                    }else{
                        $params=array(
                            'role_id'=> $role_id,
                        );
                        $rid = $this->User_role_model->update_user_role($user_id,$params);
                        $this->db->delete('trainer_access_list',array('user_id'=>$user_id));
                    }
            }

            $jsonData = array(
                'portal_access'=> $this->input->post('portal_access', true),
                'waiver_power' => $this->input->post('waiver_power', true),
                'waiver_upto'  => $this->input->post('waiver_upto', true),
                'refund_power' => $this->input->post('refund_power', true),
                'by_user'      => $by_user,
                'role_id'      => $role_id,
            );
            //activity update start
                $activity_name = UPDATE_SPECIAL_ACCESS;
                $uaID = 'trainer_access'.$user_id;
                $description = str_replace(UA_FIND, UA_REPLACE, json_encode($jsonData));
                $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
            if($idd){                
                header('Content-Type: application/json');
                $response = ['msg'=>SUCCESS_MSG, 'status'=>'true'];
                echo json_encode($response);
            }else{
                header('Content-Type: application/json');
                $response = ['msg'=>FAILED_MSG, 'status'=>'false'];
                echo json_encode($response);
            }                
            
        }
    }

    function ajax_check_employeeCode_availibility(){

        $employeeCode = $this->input->post('employeeCode', true);
        if($employeeCode!=''){
            $count = $this->User_model->check_employeeCode_availibility($employeeCode);       
            if($count<=0){
                header('Content-Type: application/json');
                $response = ['msg'=>'<span class="text-success">Wow! its available..carry on</span>', 'status'=>'true'];
                echo json_encode($response);
            }else{                
                header('Content-Type: application/json');
                $response = ['msg'=>'<span class="text-danger">Oops! '.$employeeCode.' already exist. Please try another</span>', 'status'=>'false'];
                echo json_encode($response);
            } 

        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'<span class="text-danger">Please enter valid employee code</span>', 'status'=>'false'];
            echo json_encode($response);
        }

    }

    function ajax_check_employeeCode_availibility_edit(){

        $employeeCode = $this->input->post('employeeCode', true);
        $user_id = $this->input->post('user_id', true);
        $getEmployeeCode = $this->User_model->getEmployeeCode($user_id);
        $employeeCode_old = $getEmployeeCode['employeeCode'];

        if($employeeCode!='' && $user_id!=''){
            $count = $this->User_model->check_employeeCode_availibility_edit($employeeCode,$employeeCode_old);       
            if($count<=0){
                header('Content-Type: application/json');
                $response = ['msg'=>'<span class="text-success">Its ok..carry on</span>', 'status'=>'true'];
                echo json_encode($response);
            }else{                
                header('Content-Type: application/json');
                $response = ['msg'=>'<span class="text-danger">Oops! '.$employeeCode.' already exist. Please try another</span>', 'status'=>'false'];
                echo json_encode($response);
            } 

        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'<span class="text-danger">Please enter valid employee code</span>', 'status'=>'false'];
            echo json_encode($response);
        }

    }

    function ajax_check_personal_email_availibility(){
        
        $email = $this->input->post('email', true);
        $page = $this->input->post('page', true);
        if($email!=''){
            $count = $this->User_model->check_personal_email_availibility($email);            
            if($count<=0){  
                header('Content-Type: application/json');
                $response = ['msg'=>'<span class="text-success">Wow! its available..carry on</span>', 'status'=>'true'];
                echo json_encode($response);
            }else{
                if($page=='add'){
                    header('Content-Type: application/json');
                    $response = ['msg'=>'<span class="text-danger">Oops! '.$email.' already exist. Please try another</span>', 'status'=>'false'];
                    echo json_encode($response);
                }else{
                   header('Content-Type: application/json');
                    $response = ['msg'=>'<span class="text-danger"></span>', 'status'=>'true'];
                    echo json_encode($response); 
                }                
            } 

        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'<span class="text-danger">Please enter valid Email Id</span>', 'status'=>'false'];
            echo json_encode($response);
        }     
                  
    }

    function ajax_check_official_email_availibility(){

        $email = $this->input->post('email', true);
        $user_id = $this->input->post('user_id', true);
        $getOfficialEmail = $this->User_model->getOfficialEmail($user_id);
        $OfficialEmail_old = $getOfficialEmail['email'];
        if($email!=''){
            $count = $this->User_model->check_official_email_availibility($email,$OfficialEmail_old);
            if($count<=0){  
                header('Content-Type: application/json');
                $response = ['msg'=>'<span class="text-success">Wow! its available..carry on</span>', 'status'=>'true'];
                echo json_encode($response);
            }else{  
                
               header('Content-Type: application/json');
               $response = ['msg'=>'<span class="text-danger">Oops! '.$email.' already exist. Please try another</span>', 'status'=>'false'];
                echo json_encode($response);              
            } 

        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'<span class="text-danger">Please enter valid Email Id</span>', 'status'=>'false'];
            echo json_encode($response);
        }     
                  
    }

    function ajax_check_personal_mobile_availibility(){

        $personal_contact = $this->input->post('personal_contact', true);
        if($personal_contact!=''){
            $count = $this->User_model->check_personal_mobile_availibility($personal_contact);
            if($count<=0){  
                header('Content-Type: application/json');
                $response = ['msg'=>'<span class="text-success">Wow! its available..carry on</span>', 'status'=>'true'];
                echo json_encode($response);
            }else{                  
                header('Content-Type: application/json');
                $response = ['msg'=>'<span class="text-danger">Oops! '.$personal_contact.' already exist. Please try another</span>', 'status'=>'false'];
                echo json_encode($response);
            } 

        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'<span class="text-danger">Please enter personal contact no</span>', 'status'=>'false'];
            echo json_encode($response);
        }
    }

    function ajax_check_personal_mobile_availibility_edit(){

        $personal_contact = $this->input->post('personal_contact', true);
        $user_id = $this->input->post('user_id', true);
        $getPersonalMobile = $this->User_model->getPersonalMobile($user_id);
        $personal_contact_old = $getPersonalMobile['personal_contact'];
        if($personal_contact!=''){
            $count = $this->User_model->check_personal_mobile_availibility_edit($personal_contact,$personal_contact_old);
            if($count<=0){  
                header('Content-Type: application/json');
                $response = ['msg'=>'<span class="text-success">its Ok ..carry on</span>', 'status'=>'true'];
                echo json_encode($response);
            }else{                  
                header('Content-Type: application/json');
                $response = ['msg'=>'<span class="text-danger">Oops! '.$personal_contact.' already exist. Please try another</span>', 'status'=>'false'];
                echo json_encode($response);
            } 

        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'<span class="text-danger">Please enter personal contact no</span>', 'status'=>'false'];
            echo json_encode($response);
        }
    }   

    function delete_User_Branch_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId']; 

        $center_id = $this->input->post('center_id', true);
        $get_centerName = $this->Center_location_model->get_centerName($center_id);
        $center_name = $get_centerName['center_name'];

        $user_id = $this->input->post('user_id', true);
        $getUserInfo = $this->User_model->getUserInfo($user_id);
        $employeeCode = $getUserInfo['employeeCode'];

        if($user_id!=''){
            $del = $this->User_model->delete_User_Branch($center_id,$user_id);
            if($del){  
                //activity update start           
                    $activity_name= EMPLOYEE_BRANCH_REMOVAL;
                    $description='Emmployee '.$employeeCode.' branch '.$center_name.' removed';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                header('Content-Type: application/json');
                $response = 1;
                echo json_encode($response);
            }else{  
                header('Content-Type: application/json');
                $response = 0;
                echo json_encode($response);
            } 

        }else{
            header('Content-Type: application/json');
            $response = 0;
            echo json_encode($response);
        }         
    } 

    function delete_User_Country_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId']; 

        $country_id = $this->input->post('country_id', true);
        $user_id = $this->input->post('user_id', true);

        $getCountryName = $this->Country_model->getCountryName($country_id);
        $country_name = $getCountryName['name'];

        $getUserInfo = $this->User_model->getUserInfo($user_id);
        $employeeCode = $getUserInfo['employeeCode'];

        if($user_id!=''){
            $del = $this->User_model->delete_User_Country($country_id,$user_id);
            if($del){ 
                //activity update start              
                    $activity_name= EMPLOYEE_COUNTRY_REMOVAL;
                    $description='Employee with Employee code '.$employeeCode.' functional country as '.$country_name.' deleted';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end 
                header('Content-Type: application/json');
                $response = 1;
                echo json_encode($response);
            }else{  
                header('Content-Type: application/json');
                $response = 0;
                echo json_encode($response);
            } 

        }else{
            header('Content-Type: application/json');
            $response = 0;
            echo json_encode($response);
        }         
    }

    function delete_User_Batch_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $batch_id =  $this->input->post('batch_id', true);
        $user_id = $this->input->post('user_id', true);

        $getBatchName = $this->Batch_master_model->getBatchName($batch_id);
        $batch_name = $getBatchName['batch_name'];

        $getUserInfo = $this->User_model->getUserInfo($user_id);
        $employeeCode = $getUserInfo['employeeCode'];
        if($user_id!=''){
            $del = $this->User_model->delete_User_Batch($batch_id,$user_id);           
            if($del){ 
                 //activity update start              
                    $activity_name= EMPLOYEE_BATCH_DELETE;
                    $description= 'Batch '.$batch_name.' access for employee '.$employeeCode.' removed';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end  
                header('Content-Type: application/json');
                $response = 1;
                echo json_encode($response);
            }else{  
                header('Content-Type: application/json');
                $response = 0;
                echo json_encode($response);
            } 

        }else{
            header('Content-Type: application/json');
            $response = 0;
            echo json_encode($response);
        }         
    }    

    function delete_User_Category_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $category_id =  $this->input->post('category_id', true);
        $user_id = $this->input->post('user_id', true);

        $getUserInfo = $this->User_model->getUserInfo($user_id);
        $employeeCode = $getUserInfo['employeeCode'];

        /*$get_category_name = $this->Category_master_model->get_category_name($category_id);
        $category_name = $get_category_name['category_name'];*/

        if($user_id!=''){
            $del = $this->User_model->delete_User_Category($category_id,$user_id);           
            if($del){ 
                //activity update start              
                    $activity_name= EMPLOYEE_CATEGORY_DELETE;
                    $description= 'Course-category '.$category_id.' accesss for employee '.$employeeCode.' removed';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end 
                header('Content-Type: application/json');
                $response = 1;
                echo json_encode($response);
            }else{  
                header('Content-Type: application/json');
                $response = 0;
                echo json_encode($response);
            } 

        }else{
            header('Content-Type: application/json');
            $response = 0;
            echo json_encode($response);
        }         
    }
    
    function delete_user_division_(){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId']; 

        $division_id =  $this->input->post('division_id', true);
        $user_id = $this->input->post('user_id', true);

        $getDivisionName = $this->Division_master_model->getDivisionName($division_id);
        $division_name = $getDivisionName['division_name'];

        $getUserInfo = $this->User_model->getUserInfo($user_id);
        $employeeCode = $getUserInfo['employeeCode'];

        if($user_id!=''){
            $del = $this->User_model->delete_User_Division($division_id,$user_id);           
            if($del){ 
                //activity update start              
                    $activity_name= EMPLOYEE_DIVISION_REMOVAL;
                    $description= 'Employee with employee code '.$employeeCode.' division as '.$division_name.' removed';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end 
                header('Content-Type: application/json');
                $response = 1;
                echo json_encode($response);
            }else{  
                header('Content-Type: application/json');
                $response = 0;
                echo json_encode($response);
            } 

        }else{
            header('Content-Type: application/json');
            $response = 0;
            echo json_encode($response);
        } 
    }       

    function user_activity_report($action="") {
        //access control start
        $cn     = $this->router->fetch_class().''.'.php';
        $mn     = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $this->load->library('pagination');

        $data['si']             = 0;
        $data['title']          = 'User Activity Report';

        $today                  = date('d-m-Y');
        $todaystr               = strtotime($today);
        $params['limit']        = RECORDS_PER_PAGE; 
        $params['offset']       = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config                 = $this->config->item('pagination');
        $config['base_url']     = site_url('adminController/user/user_activity_report?');
        $config['total_rows']   = count($this->User_model->getUserActivityToday($_SESSION['UserId'],$todaystr));

        $userActivitySearch      = array('employee_id' => '','from_date' => '', 'to_date' => '', 'center_id' => '', 'active' => '');
        
        if(!isset($_SESSION['userActivitySearch'])){
            $_SESSION['userActivitySearch'] = $userActivitySearch;
        }

        if($this->input->server('REQUEST_METHOD') === 'POST'){
            $action = $this->input->post('action');
            if($action == 'search') {
                $config['base_url']                   = site_url('adminController/user/user_activity_report/search/');
                $userActivitySearch['center_id']       = $this->input->post("center_id");
                $userActivitySearch['employee_id']     = $this->input->post("employee_id");
                $userActivitySearch['from_date']       = $this->input->post("from_date");
                $userActivitySearch['to_date']         = $this->input->post("to_date");
                $userActivitySearch['active']          = $this->input->post("employee_status");
            }
            
        } else {
            if($action == 'search'){
                $config['base_url']                            = site_url('adminController/user/user_activity_report/search/');
                $userActivitySearch['center_id']       = $_SESSION['userActivitySearch']['center_id'];
                $userActivitySearch['employee_id']     = $_SESSION['userActivitySearch']['employee_id'];
                $userActivitySearch['from_date']       = $_SESSION['userActivitySearch']['from_date'];
                $userActivitySearch['to_date']         = $_SESSION['userActivitySearch']['to_date'];
                $userActivitySearch['active']          = $_SESSION['userActivitySearch']['active'];
                $userActivitySearch['status']          = $_SESSION['userActivitySearch']['status'];
            }
        }
        
        $_SESSION['userActivitySearch']         = $userActivitySearch;
        $params['userActivitySearch']           = $userActivitySearch;
        $params['userActivitySearch']['limit']  = RECORDS_PER_PAGE; 
        $params['userActivitySearch']['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        if($action == 'search') {
            $config['total_rows']   = $this->User_model->searchUserActivity($params['userActivitySearch'],true);
            $UserActivityData       = $this->User_model->searchUserActivity($params['userActivitySearch']);
        }
        else {
            $UserActivityData   = $this->User_model->getUserActivityToday($_SESSION['UserId'],$todaystr,$params);
            //$UserActivityData   = $this->User_model->searchUserActivity($params);
        }


        $this->pagination->initialize($config);
        
        $data['employeesList']          = $this->User_model->getAllUsersList();
        $data['UserActivityData']       = $UserActivityData;
        $data['center_location']        = $this->Center_location_model->get_overall_active_center_location($params);
        $data['_view']                  = 'user/user_activity_report.php';
        $this->load->view('layouts/main',$data);
    }

    function ajax_get_users_list() {
        $params = array();
        if(!empty($this->input->post("branch_id"))) {
            $params["branch_id"] = $this->input->post("branch_id");
            if(!is_array($params["branch_id"])) {
                $params["branch_id"][] = $this->input->post("branch_id");
            }
        }

        if(!empty($this->input->post("employee_status"))) {
            $params["active"] = $this->input->post("employee_status");
            if(!is_array($params["active"])) {
                $params["active"][] = $this->input->post("active");
            }
        }

        if(!empty($this->input->post("employee_id"))) {
            $params["employee_id"] = $this->input->post("employee_id");
            if(!is_array($params["employee_id"])) {
                $params["employee_id"][] = $this->input->post("employee_id");
            }
        }
        
        $employeeslist["employees"]  = $this->User_model->getAllUsersList($params);
        if($employeeslist["employees"]) {
            echo json_encode($employeeslist);
        }
        else {
            echo 0;
        }
        
    }

    function user_activate_deactivete_(){  
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
            $idd = $this->User_model->update_user_active_one($id, $active, $table, $pk);
            //activity update start              
                $activity_name= ACTIVATION;
                $description= ''.$table.' data Activated/opened having PK-ID '.$id.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
        }else{
            $idd = $this->User_model->update_user_active_null($id, $active, $table, $pk);
            //activity update start              
                $activity_name= DEACTIVATION;
                $description= ''.$table.' data De-activated/closed having PK-ID '.$id.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
        }
        echo $idd;       
    }  
    
}
