<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Package_master extends MY_Controller{
    
    function __construct(){

        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Package_master_model');  
        $this->load->model('Test_module_model');   
        $this->load->model('Programe_master_model');
        $this->load->model('Center_location_model');
        $this->load->model('Category_master_model');   
        $this->load->model('Batch_master_model'); 
        $this->load->model('Classroom_model');   
        $this->load->model('Course_timing_model');  
        $this->load->model('Duration_type_model');   
        $this->load->model('Country_model');   
        //$this->load->model('Discount_model');
        $this->load->model('Online_class_schedule_model');
    }    

    function add_online_pack(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        
        $data['all_testModule'] = $this->Package_master_model->get_all_testModule();
        $data['title'] = 'Add Online Pack';
        $this->load->library('form_validation');
		$this->form_validation->set_rules('package_name','Pack name','required|trim|max_length[60]');
        $this->form_validation->set_rules('country_type','Country Type','required|trim');
        if($this->input->post("country_type") == COUNTRY_TYPE[0]) {
            $this->form_validation->set_rules('country_id_single','Country','required|trim|integer');
        }
        else if($this->input->post("country_type") == COUNTRY_TYPE[1]) {
            $this->form_validation->set_rules('country_id_multiple[]','Country','required|trim|integer|callback_auto_checkMultiCountryValidation[country_id_multiple]');
        }
        $this->form_validation->set_rules('discounted_amount','Real Price','required|trim|max_length[5]|integer');
        $this->form_validation->set_rules('fake_amount','Fake Price','required|trim|max_length[5]|integer');
        $this->form_validation->set_rules('duration_type','Duration type','required');
		$this->form_validation->set_rules('duration','Duration','required|trim|max_length[3]|integer');
        $this->form_validation->set_rules('course_timing[]','Course timing','required');
        $this->form_validation->set_rules('batch_id[]','Batch','required');
        $this->form_validation->set_rules('test_module_id','Course','required|integer');
        $this->form_validation->set_rules('programe_id','Programe','required|integer');
        $this->form_validation->set_rules('category_id[]','Category','required');
        $this->form_validation->set_rules('package_desc','Description','required');
        
        if(empty($_FILES['image']['name'])){
            $this->form_validation->set_rules('image', 'Image', 'required');
        }
        $data['all_category'] = $this->Category_master_model->get_category_forPack($this->input->post('test_module_id'),$this->input->post('programe_id'));
		
		if($this->form_validation->run()){

            $by_user=$_SESSION['UserId'];

            if(!file_exists(PACKAGE_FILE_PATH)){
                mkdir(PACKAGE_FILE_PATH, 0777, true);
            }
            // $config['upload_path']      = PACKAGE_FILE_PATH;
            // $config['allowed_types']    = WEBP_FILE_TYPES;
            // $config['encrypt_name']     = FALSE;         
            // $this->load->library('upload',$config);
            // if($this->upload->do_upload("image"))
            // {
            //     $data1 = array('upload_data' => $this->upload->data());
            //     $image= $data1['upload_data']['file_name'];                     
            // }else{                          
            //     $image=NULL; 
            // }
           
            $sorcePath= COMMON_IMAGE_PATH;
			$destinationPath  = PACKAGE_FILE_PATH;
			
			$this->auto_move_file_common_to_main($sorcePath. $this->input->post('upload_image_hidden'), $destinationPath);

            if($this->input->post("country_type") == COUNTRY_TYPE[0]) {
                $countryId = $this->input->post("country_id_single");
            }
            else if($this->input->post("country_type") == COUNTRY_TYPE[1]) {
                $countryId  = $this->input->post("country_id_multiple");
            }

            if(!is_array($countryId) && $countryId) {
                $countryIds[] = $countryId;
            }
            else {
                $countryIds = $countryId;
            }

            //pr($countryIds,1);

            if($countryIds) {
                foreach($countryIds as $countryId) {
                    $this->db->trans_start(); 
                    $params = array(
                        'division_id'       => ACADEMY_DIVISION_PKID,
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'publish'           => $this->input->post('publish') ? $this->input->post('publish') : 0,
                        'is_offline'        => 0,
                        'country_id'        => $countryId,
                        'currency_code'     => $this->input->post("currency_code"),
                        'center_id'         => ONLINE_BRANCH_ID,
                        'package_name'      => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('package_name')))),
                        'amount'            => $this->input->post('fake_amount'),
                        'discounted_amount' => $this->input->post('discounted_amount'),
                        'duration_type'     => $this->input->post('duration_type'),
                        'duration'          => $this->input->post('duration'),
                        'test_module_id'    => $this->input->post('test_module_id'),
                        'programe_id'       => $this->input->post('programe_id'),
                        'package_desc'      => $this->input->post('package_desc',false),
                        'image'             => $this->input->post('upload_image_hidden'),
                        'by_user'           => $by_user, 
                    ); 
                    $duplicacy=$this->Package_master_model->check_package_duplicacy($params,$package_id=0); 
                    if($duplicacy==0){
                        $idd = $this->Package_master_model->add_package_master($params);
                    }else{
                        $idd = 0;
                        $this->session->set_flashdata('flsh_msg', DUP_MSG);
                        redirect('adminController/package_master/add_online_pack');
                    }
                    if($idd){
                        // $this->auto_loadCaching(CACHE_ENGINE);
                        // $this->auto_cacheUpdate_front(WOSA_API_DIR,'online_courses');
                        $course_timing = $this->input->post('course_timing');
                        $batch_id = $this->input->post('batch_id');
                        $category_id = $this->input->post('category_id');
                        if(!empty($course_timing)){
                        foreach($course_timing as $c){
                                $params1 = array('package_id'=>$idd, 'course_timing_id'=>$c);
                                $this->Package_master_model->add_package_course_timing($params1);
                        } 
                        }
                        if(!empty($batch_id)){
                        foreach($batch_id as $c){
                                $params2 = array('package_id'=>$idd, 'batch_id'=>$c);
                                $this->Package_master_model->add_package_batch($params2);
                        } 
                        }
                        if(!empty($category_id)){
                        foreach($category_id as $c){
                                $params3 = array('package_id'=>$idd, 'category_id'=>$c);
                                $this->Package_master_model->add_package_category($params3);
                        } 
                        }
                        sort($category_id, SORT_NUMERIC);
                        $category_ids = implode(',', $category_id);
                        //create automatic classroom here for all active batches
                        foreach ($batch_id as $btc){                                  
                                $params2 = array(
                                    'batch_id' => $btc, 
                                    'classroom_name' => 'ONL'.rand(1000,9999),
                                    'test_module_id' => $this->input->post('test_module_id'),
                                    'programe_id' => $this->input->post('programe_id'),
                                    'category_id'=> $category_ids,
                                    'center_id'=> ONLINE_BRANCH_ID,
                                    'active' => 1,
                                    'by_user' => $by_user,
                                );
                                $dup = $this->Classroom_model->dupliacte_classroom2($params2['classroom_name'],$params2['test_module_id'],$params2['programe_id'],$params2['category_id'],$params2['batch_id'],$params2['center_id']);
                                if($dup==2){
                                }else{
                                    $idd2 = $this->Classroom_model->add_classroom($params2);
                                }                                                      
                        }
                        //creat classroom ends

                        //activity update start              
                            $activity_name= ONLINE_PACKAGE_ADD;
                            $description= 'New online pack '.$params['package_name'].' having PK-ID '.$idd.'added';
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        //activity update end    
                        $this->db->trans_complete();
                        
                        if($this->db->trans_status() === FALSE){
                            $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                            redirect('adminController/package_master/add_online_pack');
                        }elseif($idd){
                            $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                            //redirect('adminController/package_master/online_pack/'.$params['test_module_id']);
                        }else{
                            $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                            redirect('adminController/package_master/add_online_pack');
                        }
                    }
                }

                if($idd) {
                    redirect('adminController/package_master/online_pack/'.$params['test_module_id']);
                }
            }       
        }else{
            //$data['all_country_currency_code']      = $this->Discount_model->get_all_discount_country();
            $data['course_timing'] = $this->Course_timing_model->get_all_course_timing_active();
            $data['all_test_module'] = $this->Test_module_model->get_all_test_module_active();
            $data['all_programe_masters']=$this->Programe_master_model->get_all_programe_masters_active();
            $data['all_batch'] = $this->Batch_master_model->get_all_batch_active();
            $data['all_duration_type']=$this->Duration_type_model->get_all_duration_type_active();
            $data['_view'] = 'package_master/add_online_pack';
            $this->load->view('layouts/main',$data);
        }
    }
    
    function edit_online_pack_($package_id){   

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit Online Pack';
        $this->load->library('form_validation');

        $data['package_master'] = $this->Package_master_model->get_package_master($package_id);
        $data['prev_course_timing'] = $this->Package_master_model->get_prev_course_timing($package_id);
        $data['prev_batch'] = $this->Package_master_model->get_prev_batch($package_id);
        $data['prev_category'] = $this->Package_master_model->get_prev_category($package_id);
        $data['all_category'] = $this->Category_master_model->get_category_forPack($data['package_master']['test_module_id'],$data['package_master']['programe_id']);

        if(isset($data['package_master']['package_id'])){

            $this->form_validation->set_rules('package_name','Pack name','required|trim|max_length[60]');
            $this->form_validation->set_rules('discounted_amount','Real Price','required|trim|max_length[5]|integer');
            $this->form_validation->set_rules('fake_amount','Fake Price','required|trim|max_length[5]|integer');
            $this->form_validation->set_rules('duration_type','Duration type','required');
            $this->form_validation->set_rules('duration','Duration','required|trim|max_length[3]|integer');
            $this->form_validation->set_rules('course_timing[]','Course timing','required');
            $this->form_validation->set_rules('batch_id[]','Batch','required');
            $this->form_validation->set_rules('test_module_id','Course','required|integer');
            $this->form_validation->set_rules('programe_id','Programe','required|integer');
            $this->form_validation->set_rules('category_id[]','Category','required');
            $this->form_validation->set_rules('package_desc','Description','required');
			if($this->form_validation->run()){

                $by_user=$_SESSION['UserId'];
                if(!file_exists(PACKAGE_FILE_PATH)){
                    mkdir(PACKAGE_FILE_PATH, 0777, true);
                }
                /* $config['upload_path']      = PACKAGE_FILE_PATH;
                $config['allowed_types']    = WEBP_FILE_TYPES;
                $config['encrypt_name']     = FALSE;         
                $this->load->library('upload',$config);

                if($this->upload->do_upload("image")){
                    $data1 = array('upload_data' => $this->upload->data());
                    $image= $data1['upload_data']['file_name']; 
                    unlink(PACKAGE_FILE_PATH.$data['package_master']['image']);                  
                }else{                          
                    $image=$data['package_master']['image']; 
                } */
                if($this->input->post('upload_image_hidden'))
                {
                    $sorcePath= COMMON_IMAGE_PATH;
                    $destinationPath  = PACKAGE_FILE_PATH;                    
                    $this->auto_move_file_common_to_main($sorcePath. $this->input->post('upload_image_hidden'), $destinationPath);
                    $image= $this->input->post('upload_image_hidden');
                    unlink(PACKAGE_FILE_PATH.$data['package_master']['image']);    
                }
               else {
                $image=$data['package_master']['image']; 
               }



                $params = array(
					'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'publish'           => $this->input->post('publish') ? $this->input->post('publish') : 0,
                    'is_offline'        => 0,
                    'center_id'         => ONLINE_BRANCH_ID,
                    'country_id'        => $this->input->post("country_id"),
                    'package_name'      => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('package_name')))),
                    'amount'            => $this->input->post('fake_amount'),
                    'discounted_amount' => $this->input->post('discounted_amount'),
                    'duration_type'     => $this->input->post('duration_type'),
                    'duration'          => $this->input->post('duration'),
                    'test_module_id'    => $this->input->post('test_module_id'),
                    'programe_id'       => $this->input->post('programe_id'),
                    'package_desc'      => $this->input->post('package_desc',false),
                    'image'             => $image,
                    'by_user'           => $by_user,
                );
                $this->db->trans_start();
                $duplicacy = $this->Package_master_model->check_package_duplicacy($params,$package_id); 
                if($duplicacy==0){
                    $idd=$this->Package_master_model->update_package_master($package_id,$params);
                }else{
                    $idd = 0;
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);
                    redirect('adminController/package_master/edit_online_pack_/'.$package_id);
                }
                
                if($idd){
                    // $this->auto_loadCaching(CACHE_ENGINE);
                    // $this->auto_cacheUpdate_front(WOSA_API_DIR,'online_courses');
                    $course_timing = $this->input->post('course_timing');
                    $batch_id = $this->input->post('batch_id');
                    $category_id = $this->input->post('category_id');
                    if(!empty($course_timing)){
                        $this->Package_master_model->delete_package_course_timing($package_id);
                        foreach($course_timing as $c){
                            $params1 = array('package_id'=>$package_id, 'course_timing_id'=>$c);
                            $this->Package_master_model->add_package_course_timing($params1);
                        } 
                    }
                    if(!empty($batch_id)){
                       $this->Package_master_model->delete_package_batch($package_id);
                        foreach($batch_id as $c){
                            $params2 = array('package_id'=>$package_id, 'batch_id'=>$c);
                            $this->Package_master_model->add_package_batch($params2);
                        } 
                    }
                    if(!empty($category_id)){
                        $this->Package_master_model->delete_package_category($package_id);
                        foreach($category_id as $c){
                            $params3 = array('package_id'=>$package_id, 'category_id'=>$c);
                            $this->Package_master_model->add_package_category($params3);
                        } 
                    } 
                    sort($category_id, SORT_NUMERIC);
                    $category_ids = implode(',', $category_id);
                    //create automatic classroom here for all active batches
                    foreach ($batch_id as $btc){                                  
                            $params2 = array(
                                'batch_id' => $btc, 
                                'classroom_name' => 'ONL'.rand(1000,9999),
                                'test_module_id' => $this->input->post('test_module_id'),
                                'programe_id' => $this->input->post('programe_id'),
                                'category_id'=> $category_ids,
                                'center_id'=> ONLINE_BRANCH_ID,
                                'active' => 1,
                                'by_user' => $by_user,
                            );
                            $dup = $this->Classroom_model->dupliacte_classroom2($params2['classroom_name'],$params2['test_module_id'],$params2['programe_id'],$params2['category_id'],$params2['batch_id'],$params2['center_id']);
                            if($dup==2){
                            }else{
                                $idd2 = $this->Classroom_model->add_classroom($params2);
                            }                                                      
                    }
                    //creat classroom ends

                    //activity update start 
                        $newData =  ''.json_encode($params).'';                  
                        $oldData = ''.json_encode($data['package_masters']).'';
                        $activity_name= ONLINE_PACKAGE_UPDATE;
                        $description= 'Package update FROM '.$oldData.' TO '.$newData.'';
                        $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                    //activity update end
                    $this->db->trans_complete();
                }else{
                   $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);
                   redirect('adminController/package_master/edit_online_pack/'.$package_id); 
                }
                
                if($this->db->trans_status() === FALSE){
                    $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                    redirect('adminController/package_master/edit_online_pack/'.$package_id);
                }elseif($idd){
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);
                    redirect('adminController/package_master/online_pack/'.$params['test_module_id']);
                }else{
                   $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);
                   redirect('adminController/package_master/edit_online_pack/'.$package_id);
                }

            }else{
                //$data['all_country_currency_code']  = $this->Discount_model->get_all_discount_country();
                $data['course_timing']              = $this->Course_timing_model->get_all_course_timing_active();
                $data['all_test_module']            = $this->Test_module_model->get_all_test_module_active();
                $data['all_programe_masters']       = $this->Programe_master_model->get_all_programe_masters_active();
                $data['all_batch']                  = $this->Batch_master_model->get_all_batch_active();
                $data['all_duration_type']          = $this->Duration_type_model->get_all_duration_type_active();
                $data['_view']                      = 'package_master/edit_online_pack';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }    
    
    function add_offline_pack(){  

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        
        $data['all_testModule'] = $this->Package_master_model->get_all_testModule();
        $data['title'] = 'Add Inhouse Pack';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('package_name','Pack name','required|trim|max_length[60]');
        $this->form_validation->set_rules('discounted_amount[]','Real Price','trim|max_length[5]|integer');
        $this->form_validation->set_rules('fake_amount[]','Fake Price','trim|max_length[5]|integer');
        $this->form_validation->set_rules('duration_type','Duration type','required');
        $this->form_validation->set_rules('duration','Duration','required|trim|max_length[3]|integer');
        $this->form_validation->set_rules('course_timing[]','Course timing','required');
        $this->form_validation->set_rules('batch_id[]','Batch','required');
        $this->form_validation->set_rules('test_module_id','Course','required');
        $this->form_validation->set_rules('programe_id','Programe','required|integer');
        $this->form_validation->set_rules('category_id[]','Category','required|integer');
        $this->form_validation->set_rules('country_id','Country','required|integer');

        if(empty($_FILES['image']['name'])){
            $this->form_validation->set_rules('image', 'Image', 'required');
        }  
        $data['all_category'] = $this->Category_master_model->get_category_forPack($this->input->post('test_module_id'),$this->input->post('programe_id'));
        
        if($this->form_validation->run()){
            
            $by_user=$_SESSION['UserId'];

            if(!file_exists(PACKAGE_FILE_PATH)){
                mkdir(PACKAGE_FILE_PATH, 0777, true);
            }
            $config['upload_path']      = PACKAGE_FILE_PATH;
            $config['allowed_types']    = PACKAGE_FILE_TYPES;
            $config['encrypt_name']     = FALSE;         
            $this->load->library('upload',$config);

            if($this->upload->do_upload("image")){
                $data1 = array('upload_data' => $this->upload->data());
                $image= $data1['upload_data']['file_name'];                     
            }else{                          
                $image=NULL; 
            }
            $this->db->trans_start(); 

            $branchCB = $this->input->post('branchCB');
            
            $discounted_amount  = $this->input->post('discounted_amount');
            $fake_amount        = $this->input->post('fake_amount');
            $course_timing      = $this->input->post('course_timing');
            $batch_id           = $this->input->post('batch_id');
            $category_id        = $this->input->post('category_id');

            $i                  = 0;
            foreach ($branchCB as $br){                
                $params = array(
                    'division_id'       => ACADEMY_DIVISION_PKID,
                    'country_id'        => $this->input->post('country_id'),
                    'center_id'         => $br,                
                    'amount'            => $fake_amount[$i],
                    'discounted_amount' => $discounted_amount[$i],
                    'currency_code'     => $this->input->post('currency_code'),
                    'package_name'      => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('package_name')))),
                    'duration_type'     => $this->input->post('duration_type'),
                    'duration'          => $this->input->post('duration'),
                    'test_module_id'    => $this->input->post('test_module_id'),
                    'programe_id'       => $this->input->post('programe_id'),
                    'package_desc'      => $this->input->post('package_desc',false),
                    'active'            => $this->input->post('active') ? $this->input->post('active') : 0,
                    'publish'           => $this->input->post('publish') ? $this->input->post('publish') : 0,
                    'is_offline'        => 1,
                    'image'             => $image,
                    'by_user'           => $by_user,
                );

                $checkDuplicacyParams               = $params;
                $checkDuplicacyParams["country_id"] = $this->input->post('country_id');

                $duplicacy = $this->Package_master_model->check_package_duplicacy($checkDuplicacyParams,$package_id=0); 
                if($duplicacy==0) {
                    $idd = $this->Package_master_model->add_package_master($params);
                } else{
                    $idd = 0;
                }
                
                if(!empty($course_timing and $idd)){
                   foreach($course_timing as $c){
                        $params1 = array('package_id'=>$idd, 'course_timing_id'=>$c);
                        $this->Package_master_model->add_package_course_timing($params1);
                   } 
                }
                if(!empty($batch_id and $idd)){
                   foreach($batch_id as $c){
                        $params2 = array('package_id'=>$idd, 'batch_id'=>$c);
                        $batchId = $this->Package_master_model->add_package_batch($params2);
                   } 
                }
                if(!empty($category_id and $idd)){
                   foreach($category_id as $c){
                        $params3 = array('package_id'=>$idd, 'category_id'=>$c);
                        $categoryIdCheck = $this->Package_master_model->add_package_category($params3);
                        
                   } 
                }
                $i++;
            }
            if($idd){                
                
                sort($category_id, SORT_NUMERIC);
                $category_ids = implode(',', $category_id);
                //create automatic classroom here for all active batches/branches
                foreach ($branchCB as $br){
                    //get partial branch name here
                    $brNameData = $this->Center_location_model->get_centerCode($br);
                    $branch  = $brNameData['center_code'];
                    foreach($batch_id as $btc){
                        $params2 = array(
                            'batch_id' => $btc, 
                            'classroom_name' => $branch.rand(10001,99999),
                            'test_module_id' => $this->input->post('test_module_id'),
                            'programe_id' => $this->input->post('programe_id'),
                            'category_id' => $category_ids,
                            'center_id'=> $br,
                            'active' => 1,
                            'by_user' => $by_user,
                        );
                        $dup = $this->Classroom_model->dupliacte_classroom2($params2['classroom_name'],$params2['test_module_id'],$params2['programe_id'],$params2['category_id'],$params2['batch_id'],$params2['center_id']);
                        if($dup==2){
                        }else{
                            $idd2 = $this->Classroom_model->add_classroom($params2);
                        }               
                    }
                }
                //creat classroom ends

                //activity update start              
                    $activity_name= OFFLINE_PACKAGE_ADD;
                    $description= 'New inhouse pack '.$params['package_name'].' having PK-ID '.$idd.'added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
                    $this->db->trans_complete();
                    if($this->db->trans_status() === FALSE){
                        $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                        redirect('adminController/package_master/add_offline_pack');
                    }elseif($idd){
                        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                        redirect('adminController/package_master/offline_pack/'.$params['test_module_id']);
                    }else{
                       $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                       redirect('adminController/package_master/add_offline_pack');
                    }
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/package_master/add_offline_pack');
                }  
                      
        }else{
            $allCountries                 = $this->Country_model->get_all_active_countries_with_active_physical_branches(ACADEMY_DIVISION_PKID);

            $data['all_countries']        = $allCountries;
            $data['all_country_branches'] = $this->auto_getActivePhysicalBranchesofAllCountries($allCountries);
            $data['all_branch']           = $this->Center_location_model->getNonOverseasIsPhysicalBranch();
            $data['course_timing']        = $this->Course_timing_model->get_all_course_timing_active();
            $data['all_test_module']      = $this->Test_module_model->get_all_test_module_active();
            $data['all_programe_masters'] = $this->Programe_master_model->get_all_programe_masters_active();
            $data['all_batch']            = $this->Batch_master_model->get_all_batch_active();
            $data['all_duration_type']    = $this->Duration_type_model->get_all_duration_type_active();
            $data['_view']                = 'package_master/add_offline_pack';
            $this->load->view('layouts/main',$data);
            }
    }

    function edit_offline_pack_($package_id){ 

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit Inhouse Pack';
        $data['package_master'] = $this->Package_master_model->get_package_master($package_id);
        $data['prev_course_timing'] = $this->Package_master_model->get_prev_course_timing($package_id);
        $data['prev_batch'] = $this->Package_master_model->get_prev_batch($package_id);
        $data['prev_category'] = $this->Package_master_model->get_prev_category($package_id);
        $data['all_category'] = $this->Category_master_model->get_category_forPack($data['package_master']['test_module_id'],$data['package_master']['programe_id']);

        if(isset($data['package_master']['package_id'])){

            $this->load->library('form_validation');
            $this->form_validation->set_rules('package_name','Pack name','required|trim|max_length[60]');
            $this->form_validation->set_rules('discounted_amount','Price','required|trim|max_length[5]|integer');
            $this->form_validation->set_rules('fake_amount','Fake Price','trim|max_length[5]|integer');
            $this->form_validation->set_rules('duration_type','Duration type','required');
            $this->form_validation->set_rules('duration','Duration','required|trim|max_length[3]|integer');
            $this->form_validation->set_rules('course_timing[]','Course timing','required');
            $this->form_validation->set_rules('batch_id[]','Batch','required');
            $this->form_validation->set_rules('test_module_id','Course','required|integer');
            $this->form_validation->set_rules('programe_id','Programe','required|integer');
            $this->form_validation->set_rules('category_id[]','Category','required');           
            $this->form_validation->set_rules('center_id','Center Id','required');
        
            if($this->form_validation->run()){

                $by_user=$_SESSION['UserId'];
                if(!file_exists(PACKAGE_FILE_PATH)){
                    mkdir(PACKAGE_FILE_PATH, 0777, true);
                }
                $config['upload_path']      = PACKAGE_FILE_PATH;
                $config['allowed_types']    = PACKAGE_FILE_TYPES;
                $config['encrypt_name']     = FALSE;         
                $this->load->library('upload',$config);

                if($this->upload->do_upload("image")){
                    $data1 = array('upload_data' => $this->upload->data());
                    $image= $data1['upload_data']['file_name'];  
                    unlink(PACKAGE_FILE_PATH.$data['package_master']['image']);                   
                }else{                          
                    $image=$data['package_master']['image']; 
                }
                $params = array(
                    'active'            => $this->input->post('active') ? $this->input->post('active') : 0,
                    'publish'           => $this->input->post('publish') ? $this->input->post('publish') : 0,
                    'is_offline'        => 1,
                    'center_id'         => $this->input->post('center_id'),
                    'package_name'      => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('package_name')))),
                    'amount'            => $this->input->post('fake_amount'),
                    'discounted_amount' => $this->input->post('discounted_amount'),
                    'duration_type'     => $this->input->post('duration_type'),
                    'duration'          => $this->input->post('duration'),
                    'test_module_id'    => $this->input->post('test_module_id'),
                    'programe_id'       => $this->input->post('programe_id'),
                    'package_desc'      => $this->input->post('package_desc',false),
                    'image'             => $image,
                    'by_user'           => $by_user,
                );
                $this->db->trans_start();
                $duplicacy = $this->Package_master_model->check_package_duplicacy($params,$package_id); 
                if($duplicacy==0){
                    $idd = $this->Package_master_model->update_package_master($package_id,$params);
                }else{
                    $idd = 0;
                    $this->session->set_flashdata('flsh_msg',DUP_MSG);
                    redirect('adminController/package_master/edit_offline_pack_/'.$package_id);
                }                

                if($idd){
                    $course_timing = $this->input->post('course_timing');
                    $batch_id = $this->input->post('batch_id');
                    $category_id = $this->input->post('category_id');
                    if(!empty($course_timing)){
                        $this->Package_master_model->delete_package_course_timing($package_id);
                        foreach($course_timing as $c){
                            $params1 = array('package_id'=>$package_id, 'course_timing_id'=>$c);
                            $this->Package_master_model->add_package_course_timing($params1);
                        } 
                    }
                    if(!empty($batch_id)){
                       $this->Package_master_model->delete_package_batch($package_id);
                        foreach($batch_id as $c){
                            $params2 = array('package_id'=>$package_id, 'batch_id'=>$c);
                            $this->Package_master_model->add_package_batch($params2);
                        } 
                    }
                    if(!empty($category_id)){
                        $this->Package_master_model->delete_package_category($package_id);
                        foreach($category_id as $c){
                            $params3 = array('package_id'=>$package_id, 'category_id'=>$c);
                            $this->Package_master_model->add_package_category($params3);
                        } 
                    } 
                    sort($category_id, SORT_NUMERIC);
                    $category_ids = implode(',', $category_id);
                    //create automatic classroom here for all active batches/branches                    
                    //get partial branch name here
                    $brNameData = $this->Center_location_model->get_centerCode($this->input->post('center_id'));
                    $branch  = $brNameData['center_code'];
                        foreach ($batch_id as $btc){
                            $params2 = array(
                                'batch_id' => $btc, 
                                'classroom_name' => $branch.rand(10001,99999),
                                'test_module_id' => $this->input->post('test_module_id'),
                                'programe_id' => $this->input->post('programe_id'),
                                'category_id'=>$category_ids,
                                'center_id'=> $this->input->post('center_id'),
                                'active' => 1,
                                'by_user' => $by_user,
                            );
                            $dup = $this->Classroom_model->dupliacte_classroom2($params2['classroom_name'],$params2['test_module_id'],$params2['programe_id'],$params2['category_id'],$params2['batch_id'],$params2['center_id']);
                            if($dup==2){
                            }else{
                                $idd2 = $this->Classroom_model->add_classroom($params2);
                            }               
                        }                    
                    //creat classroom ends

                    //activity update start
                    $package_name = $data['package_master']['package_name'];
                    $discounted_amount = $data['package_master']['discounted_amount'];
                    $category_name = $data['package_master']['category_name'];

                    $getTestName = $this->Test_module_model->getTestName($data['package_master']['test_module_id']);
                    $test_module_name = $getTestName['test_module_name'];

                    $getTestName2 = $this->Test_module_model->getTestName($params['test_module_id']);
                    $test_module_name2 = $getTestName2['test_module_name'];

                    $newData =  ''.$params['package_name'].' with amount '.$params['discounted_amount'].' for course '.$test_module_name2.'/'.$params['category_name'].' having PK-ID '.$package_id.'';                  
                    $oldData = 'Pack '.$package_name.' with amount '.$discounted_amount.' for course '.$test_module_name.'/'.$category_name.' updated to';

                    $activity_name= OFFLINE_PACKAGE_UPDATE;
                    $description= ''.$oldData.' '.$newData.'';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                    //activity update end
                    $this->db->trans_complete();                    
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);
                    redirect('adminController/package_master/edit_offline_pack/'.$package_id);
                } 

                if($this->db->trans_status() === FALSE){
                    $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                    redirect('adminController/package_master/edit_offline_pack/'.$package_id);
                }elseif($idd){
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);
                    redirect('adminController/package_master/offline_pack/'.$params['test_module_id']);
                }else{
                   $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);
                   redirect('adminController/package_master/edit_offline_pack/'.$package_id);
                } 

            }else{
                $allCountries                 = $this->Country_model->get_all_active_countries_with_active_physical_branches(ACADEMY_DIVISION_PKID);
    
                $data['all_countries']          = $allCountries;
                $data['all_country_branches']   = $this->auto_getActivePhysicalBranchesofAllCountries($allCountries);
                $data['course_timing']          = $this->Course_timing_model->get_all_course_timing_active();
                $data['all_test_module']        = $this->Test_module_model->get_all_test_module_active();
                $data['all_programe_masters']   = $this->Programe_master_model->get_all_programe_masters_active();
                $data['all_batch']              = $this->Batch_master_model->get_all_batch_active();
                $data['all_duration_type']      = $this->Duration_type_model->get_all_duration_type_active();
                $data['all_branch']             = $this->Center_location_model->getNonOverseasIsPhysicalBranch();
                $data['_view']                  = 'package_master/edit_offline_pack';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }   

    function auto_getActivePhysicalBranchesofAllCountries($allCountries=array()) {
        if($allCountries) {
            $countryBranchesArray = array();
            $number               = 0;
            foreach($allCountries as $country) {
                $countryBranchesArray[$number]["country_id"] = $country["country_id"];
                $countryBranchesArray[$number]["branches"] = $this->Country_model->get_all_active_physical_branches_by_country_id($country["country_id"],ACADEMY_DIVISION_PKID);
                $number++;
            }
            return $countryBranchesArray;
        }
    }

    function online_pack($test_module_id=0){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['all_testModule']=$this->Package_master_model->get_all_testModule_online();        

        $this->load->library('pagination');
        $params['limit']        = RECORDS_PER_PAGE;
        $params['offset']       = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config                 = $this->config->item('pagination');
        $config['base_url']     = site_url('adminController/package_master/online_pack/'.$test_module_id.'?');
        $config['total_rows']   = $this->Package_master_model->get_online_package_masters($test_module_id,$params,true);
        $data['title']          = 'Online Class Pack';
        
        if($this->input->get("submit") == "search") {
            if(strstr(trim($this->input->get("search")),PREFIX_ONLINE_PACK_ID)) {
                $params['prefix_id']      = str_replace(PREFIX_ONLINE_PACK_ID,"",$this->input->get("search"));
            }
            $params["search"]           = strtolower(trim($this->input->get("search")));
            $params["country_id"]       = $this->input->get("country_id");
            $params["programe_id"]      = $this->input->get("programe_id");
            $params["category_id"]      = $this->input->get("category_id");
            $params["batch_id"]         = $this->input->get("batch_id");
            $params["duration"]         = $this->input->get("duration");
            $params["duration_type"]    = $this->input->get("duration_type");
            $params["course_timing"]    = $this->input->get("course_timing");
            $params["status"]           = $this->input->get("status");

            $batchIdSearchQueryString       = "";

            if($params["batch_id"]) {
                $batchIdCount               = 1;
                $countTotalBatchIds         = count($params["batch_id"]); 
                $batchIdSearchQueryString   = "&";

                foreach($params["batch_id"] as $batchId) {
                    if($countTotalBatchIds == $batchIdCount) {
                        $batchIdSearchQueryString .= "batch_id[]=".$batchId;
                    }
                    else {
                        $batchIdSearchQueryString .= "batch_id[]=".$batchId."&";
                    }
                    $batchIdCount++;
                }
            }

            $categoryIdSearchQueryString    = "";

            if($params["category_id"]) {
                $catgegoryIdCount              = 1;
                $countTotalCategoryIds         = count($params["category_id"]); 
                $categoryIdSearchQueryString   = "&";

                foreach($params["category_id"] as $categoryId) {
                    if($countTotalCategoryIds == $catgegoryIdCount) {
                        $categoryIdSearchQueryString .= "category_id[]=".$categoryId;
                    }
                    else {
                        $categoryIdSearchQueryString .= "category_id[]=".$categoryId."&";
                    }
                    $catgegoryIdCount++;
                }
            }

            $courseTimingIdSearchQueryString    = "";

            if($params["course_timing"]) {
                $courseTimingIdCount               = 1;
                $countTotalCourseTimingIds         = count($params["course_timing"]); 
                $courseTimingIdSearchQueryString   = "&";

                foreach($params["course_timing"] as $courseTimingId) {
                    if($countTotalCourseTimingIds == $courseTimingIdCount) {
                        $courseTimingIdSearchQueryString .= "course_timing[]=".$courseTimingId;
                    }
                    else {
                        $courseTimingIdSearchQueryString .= "course_timing[]=".$courseTimingId."&";
                    }
                    $courseTimingIdCount++;
                }
            }

           /* $countryIdSearchQueryString    = "";
            if($params["country_id"]) {
                $countryIdCount                     = 1;
                $countTotalCountryIds               = count($params["country_id"]); 
                $countryIdSearchQueryString         = "&";

                foreach($params["country_id"] as $countryId) {
                    if($countTotalCountryIds == $countryIdCount) {
                        $countryIdSearchQueryString .= "country_id[]=".$countryId;
                    }
                    else {
                        $countryIdSearchQueryString .= "country_id[]=".$countryId."&";
                    }
                    $countryIdCount++;
                }
            }*/

            $test_module_id = $this->input->get("test_module_id") ? $this->input->get("test_module_id") :  $test_module_id;
            $config['base_url'] = site_url('adminController/package_master/online_pack/?search='.$params["search"].'&test_module_id='.$test_module_id.'&programe_id='.$params["programe_id"].'&duration='.$params["duration"].'&duration_type='.$params["duration_type"].$batchIdSearchQueryString.$categoryIdSearchQueryString.$courseTimingIdSearchQueryString.'&status='.$params["status"].'&submit=search');
            

            $packageData    = $this->Package_master_model->search_online_package_masters($test_module_id,$params);

            $config['total_rows'] = $this->Package_master_model->search_online_package_masters($test_module_id,$params,true);
        }
        else {
            $packageData = $this->Package_master_model->get_online_package_masters($test_module_id,$params);
        }

        $this->pagination->initialize($config);

        foreach($packageData as $key => $c){
            $catData=$this->Package_master_model->getPackCategory($c['package_id']);
            foreach ($catData as $key2 => $c) {                
                $packageData[$key]['Package_category'][$key2]=$c;                       
            }             
        }
        foreach($packageData as $key => $c){ 
            $batchData=$this->Package_master_model->getPackBatch($c['package_id']);
            foreach ($batchData as $key2 => $b) {                
                $packageData[$key]['Package_batch'][$key2]=$b;                       
            }               
        }
        foreach($packageData as $key => $c){ 
            $timingData=$this->Package_master_model->getPackTiming($c['package_id']);
            foreach ($timingData as $key2 => $b) {                
                $packageData[$key]['Package_timing'][$key2]=$b;                       
            }               
        }
        
        //$data['all_countries']          = $this->Discount_model->get_all_discount_country();
        $data['package_masters']        = $packageData;
        $data['test_module_id']         = $test_module_id;
        $data['total_rows']             = $config['total_rows'];
        $data['course_timing']          = $this->Course_timing_model->get_all_course_timing_active();
        $data['all_test_module']        = $this->Test_module_model->get_all_test_module_active();
        if($test_module_id) {
            $data['all_programe_masters'] = $this->Programe_master_model->getTestPrograme($test_module_id);
        }
        else {
            $data['all_programe_masters'] = $this->Programe_master_model->get_all_programe_masters_active();
        }

        if(isset($params["programe_id"]) && !empty($params["programe_id"])) {
            $data["all_category"]       = $this->Category_master_model->get_category_forPack($test_module_id,$params["programe_id"]);
        }
        
        $data['all_batch']              = $this->Batch_master_model->get_all_batch_active();
        $data['all_duration_type']      = $this->Duration_type_model->get_all_duration_type_active();
        $data['_view']                  = 'package_master/online_pack';
        $this->load->view('layouts/main',$data);
    } 

    // function offline_pack($test_module_id=0){

    //     //access control start
    //     $cn = $this->router->fetch_class().''.'.php';
    //     $mn = $this->router->fetch_method();        
    //     if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
    //     $data['si'] = 0;
    //     //access control ends
    //     $data['all_testModule'] = $this->Package_master_model->get_all_testModule_offline();       

    //     $this->load->library('pagination');
    //     $params['limit'] = RECORDS_PER_PAGE; 
    //     $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
    //     $config = $this->config->item('pagination');
    //     $config['base_url'] = site_url('adminController/package_master/offline_pack/'.$test_module_id.'?');
    //     $config['total_rows'] = $this->Package_master_model->get_offline_package_masters($test_module_id, $params,true);
    //     //$this->pagination->initialize($config);
    //     $data['title'] = 'Inhouse Class Packages';

    //     if($this->input->get("submit") == "search") {
    //         if(strstr(trim($this->input->get("search")),PREFIX_INHOUSE_PACK_ID)) {
    //             $params['prefix_id']      = str_replace(PREFIX_INHOUSE_PACK_ID,"",$this->input->get("search"));
    //         }
    //         $params["search"]           = strtolower(trim($this->input->get("search")));
    //         $params["country_id"]       = $this->input->get("country_id");
    //         $params["programe_id"]      = $this->input->get("programe_id");
    //         $params["category_id"]      = $this->input->get("category_id");
    //         $params["center_id"]        = $this->input->get("center_id");
    //         $params["batch_id"]         = $this->input->get("batch_id");
    //         $params["duration"]         = $this->input->get("duration");
    //         $params["duration_type"]    = $this->input->get("duration_type");
    //         $params["course_timing"]    = $this->input->get("course_timing");
    //         $params["status"]           = $this->input->get("status");

    //         $centerIdSearchQueryString       = "";

    //         if($params["center_id"]) {
    //             $centerIdCount              = 1;
    //             $countTotalCenterIds        = count($params["center_id"]); 
    //             $centerIdSearchQueryString   = "&";

    //             foreach($params["center_id"] as $centerId) {
    //                 if($countTotalBatchIds == $centerIdCount) {
    //                     $centerIdSearchQueryString .= "center_id[]=".$centerId;
    //                 }
    //                 else {
    //                     $centerIdSearchQueryString .= "center_id[]=".$centerId."&";
    //                 }
    //                 $centerIdCount++;
    //             }
    //         }

    //         $batchIdSearchQueryString       = "";

    //         if($params["batch_id"]) {
    //             $batchIdCount               = 1;
    //             $countTotalBatchIds         = count($params["batch_id"]); 
    //             $batchIdSearchQueryString   = "&";

    //             foreach($params["batch_id"] as $batchId) {
    //                 if($countTotalBatchIds == $batchIdCount) {
    //                     $batchIdSearchQueryString .= "batch_id[]=".$batchId;
    //                 }
    //                 else {
    //                     $batchIdSearchQueryString .= "batch_id[]=".$batchId."&";
    //                 }
    //                 $batchIdCount++;
    //             }
    //         }

    //         $categoryIdSearchQueryString    = "";

    //         if($params["category_id"]) {
    //             $catgegoryIdCount              = 1;
    //             $countTotalCategoryIds         = count($params["category_id"]); 
    //             $categoryIdSearchQueryString   = "&";

    //             foreach($params["category_id"] as $categoryId) {
    //                 if($countTotalCategoryIds == $catgegoryIdCount) {
    //                     $categoryIdSearchQueryString .= "category_id[]=".$categoryId;
    //                 }
    //                 else {
    //                     $categoryIdSearchQueryString .= "category_id[]=".$categoryId."&";
    //                 }
    //                 $catgegoryIdCount++;
    //             }
    //         }

    //         $courseTimingIdSearchQueryString    = "";

    //         if($params["course_timing"]) {
    //             $courseTimingIdCount               = 1;
    //             $countTotalCourseTimingIds         = count($params["course_timing"]); 
    //             $courseTimingIdSearchQueryString   = "&";

    //             foreach($params["course_timing"] as $courseTimingId) {
    //                 if($countTotalCourseTimingIds == $courseTimingIdCount) {
    //                     $courseTimingIdSearchQueryString .= "course_timing[]=".$courseTimingId;
    //                 }
    //                 else {
    //                     $courseTimingIdSearchQueryString .= "course_timing[]=".$courseTimingId."&";
    //                 }
    //                 $courseTimingIdCount++;
    //             }
    //         }

    //         $countryIdSearchQueryString    = "";

    //         if($params["country_id"]) {
    //             $countryIdCount                     = 1;
    //             $countTotalCountryIds               = count($params["country_id"]); 
    //             $countryIdSearchQueryString         = "&";

    //             foreach($params["country_id"] as $countryId) {
    //                 if($countTotalCountryIds == $countryIdCount) {
    //                     $countryIdSearchQueryString .= "country_id[]=".$countryId;
    //                 }
    //                 else {
    //                     $countryIdSearchQueryString .= "country_id[]=".$countryId."&";
    //                 }
    //                 $countryIdCount++;
    //             }
    //         }

    //         $test_module_id = $this->input->get("test_module_id") ? $this->input->get("test_module_id") :  $test_module_id;

    //         $config['base_url'] = site_url('adminController/package_master/offline_pack/?search='.$params["search"].'&test_module_id='.$test_module_id.'&programe_id='.$params["programe_id"].'&duration='.$params["duration"].'&duration_type='.$params["duration_type"].$countryIdSearchQueryString.$batchIdSearchQueryString.$categoryIdSearchQueryString.$centerIdSearchQueryString.$courseTimingIdSearchQueryString.'&status='.$params["status"].'&submit=search');
            

    //         $packageData    = $this->Package_master_model->search_offline_package_masters($test_module_id,$params);

    //         $config['total_rows'] = $this->Package_master_model->search_offline_package_masters($test_module_id,$params,true);
    //     }
    //     else {
    //         $packageData = $this->Package_master_model->get_offline_package_masters($test_module_id,$params);
    //     }

    //     $this->pagination->initialize($config);

    //     foreach($packageData as $key => $c){
    //         $catData=$this->Package_master_model->getPackCategory($c['package_id']);
    //         foreach ($catData as $key2 => $c) {                
    //             $packageData[$key]['Package_category'][$key2]=$c;                       
    //         }             
    //     }
    //     foreach($packageData as $key => $c){ 
    //         $batchData=$this->Package_master_model->getPackBatch($c['package_id']);
    //         foreach ($batchData as $key2 => $b) {                
    //             $packageData[$key]['Package_batch'][$key2]=$b;                       
    //         }               
    //     }
    //     foreach($packageData as $key => $c){ 
    //         $timingData=$this->Package_master_model->getPackTiming($c['package_id']);
    //         foreach ($timingData as $key2 => $b) {                
    //             $packageData[$key]['Package_timing'][$key2]=$b;                       
    //         }               
    //     }

    //     $allCountries                   = $this->Country_model->get_all_active_countries_with_active_physical_branches(ACADEMY_DIVISION_PKID);
    //     $data['all_countries']          = $allCountries;
    //     $data['package_masters']        = $packageData;
    //     $data['total_rows']             = $config['total_rows'];
    //     $data['test_module_id']         = $test_module_id;
    //     $data['course_timing']          = $this->Course_timing_model->get_all_course_timing_active();
    //     $data['all_test_module']        = $this->Test_module_model->get_all_test_module_active();
    //     if($test_module_id) {
    //         $data['all_programe_masters'] = $this->Programe_master_model->getTestPrograme($test_module_id);
    //     }
    //     else {
    //         $data['all_programe_masters'] = $this->Programe_master_model->get_all_programe_masters_active();
    //     }

    //     if(isset($params["programe_id"]) && !empty($params["programe_id"])) {
    //         $data["all_category"]       = $this->Category_master_model->get_category_forPack($test_module_id,$params["programe_id"]);
    //     }
        
    //     $data['all_batch']              = $this->Batch_master_model->get_all_batch_active();
    //     $data['all_duration_type']      = $this->Duration_type_model->get_all_duration_type_active();  
    //     $data['all_branch']             = $this->Center_location_model->getNonOverseasIsPhysicalBranch();
    //     $data['_view'] = 'package_master/offline_pack';
    //     $this->load->view('layouts/main',$data);
    // }

    function ajax_get_online_package_list(){        
       
        $test_module_id = $this->input->post('test_module_id');
        $programe_id = $this->input->post('programe_id');
        if(isset($programe_id)){            
            $response =  $this->Package_master_model->get_package_list_online($test_module_id,$programe_id);
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'Online pack list not available!', 'status'=>'false'];
            echo json_encode($response);
        }
    }

    function ajax_get_offline_package_list(){      
       
        $test_module_id = $this->input->post('test_module_id');
        $programe_id = $this->input->post('programe_id');
        $center_id = $this->input->post('center_id');
        if(isset($programe_id)){            
            $response =  $this->Package_master_model->get_package_list_offline($test_module_id,$programe_id,$center_id);
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'Inhouse pack list not available!', 'status'=>'false'];
            echo json_encode($response);
        }
    }

    function ajax_getPackBatch(){

        $package_id = $this->input->post('package_id', true);
        if(isset($package_id)){            
            $response =  $this->Package_master_model->getPackBatch($package_id);            
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'batch not loaded', 'status'=>'false', 'packBatch'=>[] ];
            echo json_encode($response);
        }
    }

    function ajax_getPackPrice(){       
       
        $package_id = $this->input->post('package_id');
        if(isset($package_id)){            
            $response =  $this->Package_master_model->getPackPrice($package_id);
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'price error!', 'status'=>'false'];
            echo json_encode($response);
        }
    }
    function ajax_getPackPrice_new(){       
       
        $package_id = $this->input->post('package_id');
        $response = [];
        if(isset($package_id)){            
            $response['packprice'] =  $this->Package_master_model->getPackPrice($package_id);
            $response['cgst'] =  $this->Package_master_model->get_tax_detail('CGST');
            $response['sgst'] =  $this->Package_master_model->get_tax_detail('SGST');
            $packprice = $response['packprice']['discounted_amount'];
            $cgst = $this->Package_master_model->get_tax_detail('CGST');
            $sgst = $this->Package_master_model->get_tax_detail('SGST');
            $cgst_tax_per = (!empty($cgst))?$cgst['tax_per']:0;
            $sgst_tax_per = (!empty($sgst))?$sgst['tax_per']:0;
            $cgst_tax = number_format(($packprice * $cgst_tax_per)/100);
            $sgst_tax = number_format(($packprice * $sgst_tax_per)/100);
            $response['totalamt'] = $packprice + $cgst_tax + $sgst_tax;
            // $packinfo = $this->load->view('student/practicepack_info',['packageData'=>$packageData,'cgst'=>$cgst['tax_per'],'sgst'=>$sgst['tax_per'],'amountpaid'=>$paidamt],true);
            // $response = array('packinfo'=>$packinfo,'amountpayable'=>$totalamt);
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'price error!', 'status'=>'false'];
            echo json_encode($response);
        }
    }

    function ajax_getOnlineOfflinePackInfo(){

        $package_id = $this->input->post('package_id', true);
        $payingamt = $this->input->post('paidamount', true);
        $discount_type = $this->input->post('discounttype', true);
        $waiveramt = $this->input->post('waiveramt', true);
        $cgst = $this->Package_master_model->get_tax_detail('CGST');
        $sgst = $this->Package_master_model->get_tax_detail('SGST');
        $category_name =null;
        $batch_name =null;
        $course_timing =null;
        if(isset($package_id)){            
            $packageData =  $this->Package_master_model->getOnlineOfflinePackInfo($package_id);
            foreach($packageData as $key => $c){
                $catData=$this->Package_master_model->getPackCategory($c['package_id']);
                foreach ($catData as $key2 => $c) {                
                    $packageData[$key]['Package_category'][$key2]=$c;                       
                }             
            }
            foreach($packageData as $key => $c){ 
                $batchData=$this->Package_master_model->getPackBatch($c['package_id']);
                foreach ($batchData as $key2 => $b) {                
                    $packageData[$key]['Package_batch'][$key2]=$b;                       
                }               
            }
            foreach($packageData as $key => $c){ 
                $timingData=$this->Package_master_model->getPackTiming($c['package_id']);
                foreach ($timingData as $key2 => $b) {                
                    $packageData[$key]['Package_timing'][$key2]=$b;                       
                }               
            }
            $package_amt = $packageData[0]['package_amount'] ;
            if($discount_type == 'Waiver')
            {
                $package_amt = $package_amt - $waiveramt;
            } 
            $cgst_tax_per = (!empty($cgst))?$cgst['tax_per']:0;
            $sgst_tax_per = (!empty($sgst))?$sgst['tax_per']:0;
            $cgst_tax = ($package_amt * $cgst_tax_per)/100;
            $sgst_tax = ($package_amt * $sgst_tax_per)/100;
            $totalamt = $package_amt + $cgst_tax + $sgst_tax;
            $packinfo = $this->load->view('student/packageinfo',['packageData'=>$packageData,'cgst'=>$cgst_tax_per,'sgst'=>$sgst_tax_per,'cgst_amt'=>$cgst_tax,'sgst_amt'=>$sgst_tax,'amountpaid'=>$payingamt,'package_amt'=>$package_amt,'amountpayable'=>$totalamt,'discount_type'=>$discount_type,'waiveramt'=>$waiveramt],true);
            $response = array('packinfo'=>$packinfo,'amountpayable'=>$totalamt,'packamount'=>$package_amt);
            //$response = $this->load->view('student/packageinfo',['packageData'=>$packageData,'cgst'=>$cgst['tax_per'],'sgst'=>$sgst['tax_per']],true);            
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'package info error!', 'status'=>'false'];
            echo json_encode($response);
        }
    }

    function ajax_getPracticePackInfo(){

        $package_id = $this->input->post('package_id', true);
        $paidamt = $this->input->post('paidamount', true);
        $discount_type = $this->input->post('discounttype', true);
        $waiveramt = $this->input->post('waiveramt', true);
        $category_name =null;
        $batch_name =null;
        if(isset($package_id)){            
            $packageData =  $this->Package_master_model->getPracticePackInfo($package_id);
            foreach($packageData as $key => $c){
                $catData=$this->Package_master_model->getPackCategorypp($c['package_id']);
                foreach ($catData as $key2 => $c) {                
                    $packageData[$key]['Package_category'][$key2]=$c;                       
                }             
            }
            foreach($packageData as $key => $c){ 
                $batchData=$this->Package_master_model->getPackBatchpp($c['package_id']);
                foreach ($batchData as $key2 => $b) {                
                    $packageData[$key]['Package_batch'][$key2]=$b;                       
                }               
            }
            foreach($packageData as $key => $c){ 
                $timingData=$this->Package_master_model->getPackTiming($c['package_id']);
                foreach ($timingData as $key2 => $b) {                
                    $packageData[$key]['Package_timing'][$key2]=$b;                       
                }               
            } 
            
            $package_amt = $packageData[0]['package_amount'] ; 
            if($discount_type == 'Waiver')
            {
                $package_amt = $package_amt - $waiveramt;
            }         
            $cgst = $this->Package_master_model->get_tax_detail('CGST');
            $sgst = $this->Package_master_model->get_tax_detail('SGST');
            $cgst_tax_per = (!empty($cgst))?$cgst['tax_per']:0;
            $sgst_tax_per = (!empty($sgst))?$sgst['tax_per']:0;
            $cgst_tax = ($package_amt * $cgst_tax_per)/100;
            $sgst_tax = ($package_amt * $sgst_tax_per)/100;
            
            
            $totalamt = $package_amt + $cgst_tax + $sgst_tax;
            
            $packinfo = $this->load->view('student/practicepack_info',['packageData'=>$packageData,'cgst'=>$cgst_tax_per,'sgst'=>$sgst_tax_per,'cgst_amt'=>$cgst_tax,'sgst_amt'=>$sgst_tax,'amountpaid'=>$paidamt,'amountpayable'=>$totalamt,'package_amt'=>$package_amt,'discount_type'=>$discount_type,'waiveramt'=>$waiveramt],true);
            $response = array('packinfo'=>$packinfo,'amountpayable'=>$totalamt,'packamount'=>$package_amt);
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'package info error!', 'status'=>'false'];
            echo json_encode($response);
        }
    }


    function ajax_getPackageSchedule(){
        
        $package_id = $this->input->post('package_id', true);
        $pack_category_id = null;
        $batch_id = $this->input->post('batch_id', true);
        if(isset($package_id) and isset($batch_id)){            
            $packageData=  $this->Package_master_model->getPackageProfile($package_id);

            $packageCategory = $this->Package_master_model->getPackCategoryId($package_id);
            foreach ($packageCategory as $pc) {
                $pack_category_id .= $pc['category_id'].',';
            }
            $pack_category_id = rtrim($pack_category_id, ',');
            $packageClassroom = $this->Classroom_model->findClassroom($packageData['test_module_id'],$packageData['programe_id'],$pack_category_id,$batch_id,$packageData['center_id']);
            $packageSchedule = $this->Online_class_schedule_model->getPackageSchedule($packageClassroom['id']);
            if($packageSchedule['dateTime']){
                $upcomingSchedule = ' | Next Live Class on: '.$packageSchedule['dateTime'];
            }else{
                $upcomingSchedule = '';
            }            

            header('Content-Type: application/json');
            $response = ['msg'=>$upcomingSchedule, 'status'=>'true'];
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'Something wrong!', 'status'=>'false'];
            echo json_encode($response);
        }
    }

    function auto_checkMultiCountryValidation($empty="",$fieldName="") {
        $countryCount = count($this->input->post($fieldName));
    
        if($countryCount == 1) {
            $this->form_validation->set_message('auto_checkMultiCountryValidation','Please select atleast two countries.');
            return false;
        }
        else {
            return true;
        }
    }

    function auto_get_package_ids_according_to_action($postData=array()) {
        $test_module_id = 0;
        $packageIds     = $postData["records"];
        $allRecords     = $postData["all_records_selected"];
        $isSearch       = $postData["is_search"];
        $listType       = $postData["list_type"];
        $params         = array();
        $searhParams    = array();
        $packageData    = array();

        if($allRecords && $isSearch && !empty($postData["search_parameters"])) {
            $searchParameters = (array)json_decode($postData["search_parameters"]);
            
            if(isset($searchParameters["search"]) && !empty($searchParameters["search"])) {
                $searhParams["search"]   = $searchParameters["search"];
            }
            if(isset($searchParameters["country_id"]) && !empty($searchParameters["country_id"])) {
                $searhParams["country_id"]   = $searchParameters["country_id"];
            }
            if(isset($searchParameters["test_module_id"]) && !empty($searchParameters["test_module_id"])) {
                $test_module_id   = $searchParameters["test_module_id"];
            }
            if(isset($searchParameters["program_id"]) && !empty($searchParameters["program_id"])) {
                $searhParams["program_id"]   = $searchParameters["program_id"];
            }
            if(isset($searchParameters["duration"]) && !empty($searchParameters["duration"])) {
                $searhParams["duration"]   = $searchParameters["duration"];
            }
            if(isset($searchParameters["duration_type"]) && !empty($searchParameters["duration_type"])) {
                $searhParams["duration_type"]   = $searchParameters["duration_type"];
            }
            if(isset($searchParameters["status"]) && !empty($searchParameters["status"])) {
                $searhParams["status"]   = $searchParameters["status"];
            }

            if($listType == "online_pack") {
                $packageData = $this->Package_master_model->search_online_package_masters($test_module_id,$searhParams);
            }
            elseif($listType == "offline_pack") {
                $packageData = $this->Package_master_model->search_offline_package_masters($test_module_id,$searhParams);
            }

            if($packageData) {
                $packageIds = array_map(function($elem){return $elem["package_id"];},$packageData);
            }
        }
        elseif($allRecords && !$isSearch) {
            if($listType == "online_pack") {
                $packageData = $this->Package_master_model->get_online_package_masters($test_module_id,$params);
            }
            elseif($listType == "offline_pack") {
                $packageData = $this->Package_master_model->get_offline_package_masters($test_module_id,$params);
            }

            if($packageData) {
                $packageIds = array_map(function($elem){return $elem["package_id"];},$packageData);
            }
        }

        return $packageIds;
    }

    function active_deactive_() {

        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}

    
        $action     = $this->input->post("action");
        $packageIds = $this->auto_get_package_ids_according_to_action($_POST);

        if($packageIds) {
            if($action == LIST_RECORD_ACTIONS[0]) {
                $params['active'] = 1;
            }
            elseif($action == LIST_RECORD_ACTIONS[1]) {
                $params['active']   = 0;
                $params['publish']  = 0;
            }
            
            $this->db->trans_start();
            $idd = $this->Package_master_model->update_package_master_active_inactive_publish_unpublish_on_web($packageIds,$params);
            $this->db->trans_complete();

            if($this->db->trans_status() === FALSE){
                $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                die(0);
            }elseif($idd){
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                echo 1;
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                die(0);
            }
        }
    }

    function publish_unpublish_() {

        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}

    
        $action     = $this->input->post("action");
        $packageIds = $this->auto_get_package_ids_according_to_action($_POST);

        if($packageIds) {
            if($action == LIST_RECORD_ACTIONS[2]) {
                $params['publish'] = 1;
            }
            elseif($action == LIST_RECORD_ACTIONS[3]) {
                $params['publish'] = 0;
            }

            $this->db->trans_start();
            $idd = $this->Package_master_model->update_package_master_active_inactive_publish_unpublish_on_web($packageIds,$params);
            $this->db->trans_complete();

            if($this->db->trans_status() === FALSE){
                $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                die(0);
            }elseif($idd){
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                echo 1;
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                die(0);
            }
        }
    }

    /*function remove_online_pack($package_id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        $package_master = $this->Package_master_model->get_package_master($package_id);
        if(isset($package_master['package_id']))
        {
            $id = $this->Package_master_model->delete_package_master($package_id);
            if($id){
                $this->session->set_flashdata('flsh_msg', DEL_MSG);
                redirect('adminController/package_master/online_pack/'.$package_master['test_module_id']);
             }else{redirect('adminController/package_master/online_pack');}  
        }
        else
            show_error(ITEM_NOT_EXIST);
    } 

    function remove_offline_pack($package_id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        $package_master = $this->Package_master_model->get_package_master($package_id);
        if(isset($package_master['package_id']))
        {
            $id = $this->Package_master_model->delete_package_master($package_id);
            if($id){
                $this->session->set_flashdata('flsh_msg', DEL_MSG);
                redirect('adminController/package_master/offline_pack/'.$package_master['test_module_id']);
            }else{redirect('adminController/package_master/offline_pack');}  
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/      
    
}
