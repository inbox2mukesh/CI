<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Practice_packages extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Practice_package_model');  
        $this->load->model('Test_module_model');   
        $this->load->model('Programe_master_model');
        $this->load->model('Category_master_model');
        $this->load->model('Duration_type_model'); 
        //$this->load->model('Discount_model');
    }
    
    function index($test_module_id=0){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['all_testModule'] = $this->Practice_package_model->get_all_testModule();
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url']=site_url('adminController/practice_packages/index/'.$test_module_id.'?');
        //$config['total_rows'] = $this->Practice_package_model->get_all_packages_count($test_module_id);
        $config['total_rows']=$this->Practice_package_model->get_all_packages($test_module_id,'',true);
        $data['title'] = 'Practice Packages';

        if($this->input->get("submit") == "search") {
            if(strstr(trim($this->input->get("search")),PREFIX_PRACTICE_PACK_ID)) {
                $params['prefix_id']    = str_replace(PREFIX_PRACTICE_PACK_ID,"",$this->input->get("search"));
            }
            $params["search"]           = strtolower(trim($this->input->get("search")));
            $params["country_id"]       = $this->input->get("country_id");
            $params["programe_id"]      = $this->input->get("programe_id");
            $params["category_id"]      = $this->input->get("category_id");
            $params["duration"]         = $this->input->get("duration");
            $params["duration_type"]    = $this->input->get("duration_type");
            $params["status"]           = $this->input->get("status");

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

           //$countryIdSearchQueryString    = "";
            /*if($params["country_id"]) {
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
            $config['base_url'] = site_url('adminController/practice_packages/index/?search='.$params["search"].'&test_module_id='.$test_module_id.'&programe_id='.$params["programe_id"].'&duration='.$params["duration"].'&duration_type='.$params["duration_type"].$batchIdSearchQueryString.$categoryIdSearchQueryString.$courseTimingIdSearchQueryString.'&status='.$params["status"].'&submit=search');
            
            $packageData = $this->Practice_package_model->search_practice_package_masters($test_module_id,$params);

            $config['total_rows'] = $this->Practice_package_model->search_practice_package_masters($test_module_id,$params,true);
        }
        else {
            $packageData = $this->Practice_package_model->get_all_packages($test_module_id,$params);
        }

        $this->pagination->initialize($config);

        foreach($packageData as $key => $c){
            $catData=$this->Practice_package_model->getPackCategory($c['package_id']);
            foreach ($catData as $key2 => $c) {                
                $packageData[$key]['Package_category'][$key2]=$c;                       
            }             
        }
        
        //$data['all_countries']          = $this->Discount_model->get_all_discount_country();
        $data['practice_packages']      = $packageData;
        $data['total_rows']             = $config['total_rows'];
        $data['test_module_id']         = $test_module_id;
        $data['all_test_module']        = $this->Test_module_model->get_all_test_module_active();
        $data['all_duration_type']      = $this->Duration_type_model->get_all_duration_type_active();

        if($test_module_id) {
            $data['all_programe_masters'] = $this->Programe_master_model->getTestPrograme($test_module_id);
        }
        else {
            $data['all_programe_masters'] = $this->Programe_master_model->get_all_programe_masters_active();
        }

        if(isset($params["programe_id"]) && !empty($params["programe_id"])) {
            $data["all_category"]       = $this->Category_master_model->get_category_forPack($test_module_id,$params["programe_id"]);
        }
        $data['_view'] = 'practice_packages/index';
        $this->load->view('layouts/main',$data);
    }

    function add(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['all_testModule'] = $this->Practice_package_model->get_all_testModule();
        $data['title'] = 'Add Practice Package';
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
        $this->form_validation->set_rules('discounted_amount','Price','required|trim|max_length[5]|integer');
        $this->form_validation->set_rules('duration_type','Duration type','required');
        $this->form_validation->set_rules('duration','Duration','required|trim|max_length[3]|integer');
        $this->form_validation->set_rules('test_module_id','Course','required|integer');
        $this->form_validation->set_rules('programe_id','Programe','required|integer');
        $this->form_validation->set_rules('category_id[]','Category','required');
        if(empty($_FILES['image']['name'])){
            $this->form_validation->set_rules('image', 'Image', 'required');
        }
        $this->form_validation->set_rules('package_desc','Description','required');
        $data['all_category'] = $this->Category_master_model->get_category_forPack($this->input->post('test_module_id'),$this->input->post('programe_id')); 	
		
		if($this->form_validation->run()){ 

            $by_user=$_SESSION['UserId'];                     

            if(!file_exists(PACKAGE_FILE_PATH)){
                mkdir(PACKAGE_FILE_PATH, 0777, true);
            }
            $config['upload_path']      = PACKAGE_FILE_PATH;
            $config['allowed_types']    = WEBP_FILE_TYPES;
            $config['encrypt_name']     = FALSE;         
            $this->load->library('upload',$config);

            if($this->upload->do_upload("image")){
                $data1 = array('upload_data' => $this->upload->data());
                $image= $data1['upload_data']['file_name'];                     
            }else{                          
                $image=NULL; 
            }
           

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

            if($countryIds) {
                foreach($countryIds as $countryId) {
                    $this->db->trans_start();
                    $params = array(                		
                        'division_id'           => ACADEMY_DIVISION_PKID,		
                        'package_name'          => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('package_name')))),
                        'country_id'            => $countryId,               
                        'currency_code'         => $this->input->post("currency_code"),
                        'amount'                => $this->input->post('fake_amount'),
                        'discounted_amount'     => $this->input->post('discounted_amount'),
                        'test_module_id'        => $this->input->post('test_module_id'),
                        'programe_id'           => $this->input->post('programe_id'),
                        'center_id'             => ONLINE_BRANCH_ID,
                        'duration_type'         => $this->input->post('duration_type'),
                        'duration'              => $this->input->post('duration'),
                        'image'                 => $image,
                        'mock_test_count'       => $this->input->post('mock_test_count'),
                        'reading_test_count'    => $this->input->post('reading_test_count'),
                        'listening_test_count'  => $this->input->post('listening_test_count'),
                        'writing_test_count'    => $this->input->post('writing_test_count'),
                        'speaking_test_count'   => $this->input->post('speaking_test_count'),	
                        'package_desc'          => $this->input->post('package_desc',false),			
                        'active'                => $this->input->post('active') ? $this->input->post('active') : 0,
                        'publish'               => $this->input->post('publish') ? $this->input->post('publish') : 0,
                        'by_user'               => $by_user,
                    ); 
                    $duplicacy=$this->Practice_package_model->check_package_duplicacy($params,$package_id=0); 
                    if($duplicacy==0){
                        $idd = $this->Practice_package_model->add_package($params);
                    }else{
                        $idd = 0;
                        $this->session->set_flashdata('flsh_msg', DUP_MSG);
                        redirect('adminController/practice_packages/add');
                    }
                    
                    if($idd){
                        $this->auto_loadCaching(CACHE_ENGINE);
                        $this->auto_cacheUpdate_front(WOSA_API_DIR,'practice_packs'); 
                        $category_id = $this->input->post('category_id');
                        if(!empty($category_id)){
                        foreach($category_id as $c){
                                $params3 = array('package_id'=>$idd, 'category_id'=>$c);
                                $this->Practice_package_model->add_package_category($params3);
                        }
                       
                        }
                        //activity update start              
                            $activity_name= PRACTICE_PACKAGE_ADD;
                            $description= 'New practice pack '.json_encode($params).' added';
                            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                        //activity update end                
                    }else{
                        $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                        redirect('adminController/practice_packages/add');
                    }
                    $this->db->trans_complete();

                    if($this->db->trans_status() === FALSE){
                        $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                        redirect('adminController/practice_packages/add');
                    }elseif($idd){
                        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                        //redirect('adminController/practice_packages/index/'.$params['test_module_id']);
                    }else{
                       $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                       redirect('adminController/practice_packages/add');
                    }
                }

                if($idd) {
                    redirect('adminController/practice_packages/index/'.$params['test_module_id']);
                }
            }
        }else{            
            //$data['all_country_currency_code']      = $this->Discount_model->get_all_discount_country(); 
            $data['all_test_module'] = $this->Test_module_model->get_all_test_module_active();
            $data['all_programe_masters'] = $this->Programe_master_model->get_all_programe_masters_active(); 
            $data['all_duration_type']=$this->Duration_type_model->get_all_duration_type_active();
            $data['_view'] = 'practice_packages/add';
            $this->load->view('layouts/main',$data);
        }
    }
    
    function edit($package_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Edit Practice Package';
        $data['practice_packages'] = $this->Practice_package_model->get_package($package_id);
        $data['prev_category'] = $this->Practice_package_model->get_prev_category($package_id);
        $data['all_category'] = $this->Category_master_model->get_category_forPack($data['practice_packages']['test_module_id'],$data['practice_packages']['programe_id']);

        if(isset($data['practice_packages']['package_id'])){

            $this->load->library('form_validation');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('package_name','Pack name','required|trim|max_length[60]');
            $this->form_validation->set_rules('discounted_amount','Price','required|trim|max_length[5]|integer');
            $this->form_validation->set_rules('duration_type','Duration type','required');
            $this->form_validation->set_rules('duration','Duration','required|trim|max_length[3]|integer');
            $this->form_validation->set_rules('test_module_id','Course','required|integer');
            $this->form_validation->set_rules('programe_id','Programe','required|integer');
            $this->form_validation->set_rules('category_id[]','Category','required'); 			
            $this->form_validation->set_rules('package_desc','Description','required');           
            if($this->input->post('hidden_image') =="" && empty($_FILES['image']['name'])){
                $this->form_validation->set_rules('image', 'Image', 'required');
            }
			if($this->form_validation->run()){

                $by_user=$_SESSION['UserId'];
                if(!file_exists(PACKAGE_FILE_PATH)){
                mkdir(PACKAGE_FILE_PATH, 0777, true);
                }
                $config['upload_path']      = PACKAGE_FILE_PATH;
                $config['allowed_types']    = WEBP_FILE_TYPES;
                $config['encrypt_name']     = FALSE;         
                $this->load->library('upload',$config);

                if($this->upload->do_upload("image")){
                    $data1 = array('upload_data' => $this->upload->data());
                    $image= $data1['upload_data']['file_name'];
                    unlink(PACKAGE_FILE_PATH.$data['practice_packages']['image']);
                }else{                          
                    $image=$data['practice_packages']['image']; 
                }
                $params = array(
                    'test_module_id' => $this->input->post('test_module_id'),
                    'programe_id' => $this->input->post('programe_id'),             
                    'package_name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('package_name')))),
                    'country_id'   => $this->input->post("country_id"),
                    'package_desc' => $this->input->post('package_desc',false),
                    'duration_type' => $this->input->post('duration_type'),
                    'amount' => $this->input->post('fake_amount'),
                    'discounted_amount' => $this->input->post('discounted_amount'),
                    'duration' => $this->input->post('duration'),
                    'mock_test_count' => $this->input->post('mock_test_count'),
                    'reading_test_count' => $this->input->post('reading_test_count'),
                    'listening_test_count' => $this->input->post('listening_test_count'),
                    'writing_test_count' => $this->input->post('writing_test_count'),
                    'speaking_test_count' => $this->input->post('speaking_test_count'),             
                    'active'      => $this->input->post('active') ? $this->input->post('active') : 0,
                    'publish'     => $this->input->post('publish') ? $this->input->post('publish') : 0,
                    'image' => $image,
                    'by_user' => $by_user,
                );
                $this->db->trans_start();
                $duplicacy = $this->Practice_package_model->check_package_duplicacy($params,$package_id); 
                if($duplicacy==0){
                    $idd = $this->Practice_package_model->update_package($package_id,$params);
                }else{
                    $idd = 0;
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);
                    redirect('adminController/practice_packages/edit/'.$package_id);
                }
                $category_id = $this->input->post('category_id');
                if($idd){
                    $this->auto_loadCaching(CACHE_ENGINE);
                    $this->auto_cacheUpdate_front(WOSA_API_DIR,'practice_packs');
                    if(!empty($category_id)){
                        $this->Practice_package_model->delete_package_category($package_id);
                        foreach($category_id as $c){
                            $params3 = array('package_id'=>$package_id, 'category_id'=>$c);
                            $this->Practice_package_model->add_package_category($params3);
                        } 
                       
                    }
                    $package_name = $data['practice_packages']['package_name'];
                    $discounted_amount = $data['practice_packages']['discounted_amount'];

                    $getTestName = $this->Test_module_model->getTestName($data['practice_packages']['test_module_id']);
                    $test_module_name = $getTestName['test_module_name'];

                    $getTestName2 = $this->Test_module_model->getTestName($params['test_module_id']);
                    $test_module_name2 = $getTestName2['test_module_name'];

                    $newData =  ''.$params['package_name'].' with amount '.$params['discounted_amount'].' for course '.$test_module_name2.' having PK-ID '.$package_id.'';                  
                    $oldData = 'Pack '.$package_name.' with amount '.$discounted_amount.' for course '.$test_module_name.' updated to';
                    //activity update start              
                    $activity_name= PRACTICE_PACKAGE_UPDATE;
                    $description= ''.$oldData.' '.$newData.'';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                    //activity update end
                    $this->db->trans_complete();                    
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/practice_packages/edit/'.$package_id);
                } 

                if($this->db->trans_status() === FALSE){
                    $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                    redirect('adminController/practice_packages/edit/'.$package_id);
                }elseif($idd){
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);
                    redirect('adminController/practice_packages/index/'.$params['test_module_id']);
                }else{
                   $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);
                   redirect('adminController/practice_packages/edit/'.$package_id);
                } 

            }else{
                //$data['all_country_currency_code']  = $this->Discount_model->get_all_discount_country();
                $data['all_test_module']= $this->Test_module_model->get_all_test_module_active();
                $data['all_programe_masters']=$this->Programe_master_model->get_all_programe_masters_active();
                $data['all_duration_type']=$this->Duration_type_model->get_all_duration_type_active();
                $data['_view'] = 'practice_packages/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

    /*function remove($package_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        $practice_packages = $this->Practice_package_model->get_package($package_id);
        if(isset($practice_packages['package_id']))
        {
            $id = $this->Practice_package_model->delete_package($package_id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            if($id){
                redirect('adminController/practice_packages/index/'.$practice_packages['test_module_id']);
            }else{
                redirect('adminController/practice_packages/index');
            }  
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/ 

    function ajax_get_package_list(){       
       
        $test_module_id = $this->input->post('test_module_id');
        $programe_id = $this->input->post('programe_id');
        if(isset($programe_id)){            
            $response =  $this->Practice_package_model->get_package_list($test_module_id,$programe_id);
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'list not available!', 'status'=>'false'];
            echo json_encode($response);
        }
    }

    function ajax_getPackPrice(){        
       
        $package_id = $this->input->post('package_id');
        if(isset($package_id)){            
            $response =  $this->Practice_package_model->getPackPrice($package_id);
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'price error!', 'status'=>'false'];
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

            $packageData = $this->Practice_package_model->search_practice_package_masters($test_module_id,$searhParams);

            if($packageData) {
                $packageIds = array_map(function($elem){return $elem["package_id"];},$packageData);
            }
        }
        elseif($allRecords && !$isSearch) {
            $packageData = $this->Practice_package_model->get_all_packages($test_module_id,$params);
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
            $idd = $this->Practice_package_model->update_practice_package_master_active_inactive_publish_unpublish_on_web($packageIds,$params);
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
            $idd = $this->Practice_package_model->update_practice_package_master_active_inactive_publish_unpublish_on_web($packageIds,$params);
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
}
