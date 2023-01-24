<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/ 
//require_once APPPATH . 'libraries/phpqrcode/qrlib.php';
class Center_location extends MY_Controller{
    
    function __construct(){
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Center_location_model');
        $this->load->model('Country_model');
        $this->load->model('State_model');
        $this->load->model('City_model');
        $this->load->model('User_model');
        $this->load->model('Division_master_model');
        $this->load->model('Center_division_model');
        //$this->load->model('Center_head_model');
        //$this->load->model('Center_academy_management_model');
        //$this->load->model('Center_visa_management_model');
        //$this->load->model('Department_model');         
    }

    function ajax_loadFuntionalBranchListByDivision(){

        $division_ids = $this->input->post('division_ids', true);
        $response = $this->Center_location_model->funtionalBranchListByDivision($division_ids);
        $x = '<select name="center_id[]" id="center_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple="multiple">
            <option value="" disabled="disabled">Select Functional Branch</option>';
            foreach ($response as $b){
                $y .= '<option value="'.$b['center_id'].'">'.$b['center_name'].'</option>';  
            }
        $z= '</select>
            <span class="text-danger"><?php echo form_error("center_id[]");?></span>';

        $result = $x.$y.$z;
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    function ajax_GetBranchAddress(){

        $center_id = $this->input->post('center_id', true);
        $response = $this->Center_location_model->GetBranchAddress($center_id);         
        if($response){                           
            header('Content-Type: application/json');           
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    /*function Generate_QR_Code_($center_id){

        $data['center_location'] = $this->Center_location_model->get_centerName($center_id);
        $center_name = $data['center_location']['center_name'];
        $qrDir = QR_CODE_PATH;        
        $fileName = $center_name;
        $codeContents = base_url('walkin/walkin_registration/'.$center_name);
        QRcode::png($codeContents, $qrDir.''.$fileName.'.png', QR_ECLEVEL_L, 5);
        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
        redirect('adminController/center_location/index');
    }*/
   
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
        $config['base_url'] = site_url('adminController/center_location/index?');
        $config['total_rows'] = $this->Center_location_model->get_all_center_location_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Our Branches';
        $centerLocationData = $this->Center_location_model->get_all_center_location($params);        
        foreach ($centerLocationData as $key => $c) {
            $mData = $this->Center_division_model->getCenterDivisions($c['center_id']);
            foreach ($mData as $key2 => $m) {                
                $centerLocationData[$key]['centerDivisions'][$key2]=$m;                       
            }               
        }
        $data['center_location'] = $centerLocationData;
        $data['_view'] = 'center_location/index';
        $this->load->view('layouts/main',$data);
    }

    function add(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
            $data['title'] = 'Add Branch/Independent body';
            $independent_body=$this->input->post('independent_body');
            $physical_branch=1;
            if(isset($_POST['physical_branch'])){   
                $physical_branch=$this->input->post('physical_branch');  
            }
            $this->load->library('form_validation');
            $this->form_validation->set_rules('center_name','Branch name','required|trim|min_length[4]|max_length[25]');
            $this->form_validation->set_rules('center_code','Branch code','required|trim|max_length[3]|is_unique[center_location.center_code]');
            $this->form_validation->set_rules('branch_divisions[]','divisions', 'required');

            if($independent_body==1){

            }elseif($physical_branch==1){
                $this->form_validation->set_rules('is_overseas','overseas','required');
                $this->form_validation->set_rules('country_id','country','required|integer');
                $this->form_validation->set_rules('state_id','state','required|integer');
                $this->form_validation->set_rules('city_id','city','required|integer');
                $this->form_validation->set_rules('address_line_1','address','required|trim|max_length[150]');
                $this->form_validation->set_rules('contact','contact','required|trim|max_length[60]');
            }else{
                $this->form_validation->set_rules('contact','contact','required|trim|max_length[60]');
            }        
            
        
        if($this->form_validation->run()){
            
            $country_id=$state_id=$city_id=$address_line_1=$latitude=$longitude='';
            if($physical_branch==1 and $independent_body==0){                
                $is_overseas=$this->input->post('is_overseas');
                $country_id=$this->input->post('country_id');
                $state_id=$this->input->post('state_id');
                $city_id=$this->input->post('city_id');
                $zip_code=$this->input->post('zip_code');
                $address_line_1=$this->input->post('address_line_1');
                $latitude=$this->input->post('latitude');
                $longitude  =$this->input->post('longitude');
                $independent_body = 0;                
            }elseif($independent_body==1){
                $is_overseas=0;
                $country_id=NULL;
                $state_id=NULL;
                $city_id=NULL;
                $zip_code=NULL;
                $address_line_1=NULL;
                $latitude=NULL;
                $longitude  =NULL;
                $physical_branch=0;
                $address_line_1='';
            }else{
                $is_overseas=$this->input->post('is_overseas');
            }
            if($country_id==INDIA_ID){
                $is_overseas=0;
            }else{
                $is_overseas=1;
            }
            $params = array(
                'independent_body'=> $independent_body,
                'is_overseas' => $is_overseas,             
                'center_name' => strtoupper(trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('center_name'))))),
                'center_code' => strtoupper(trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('center_code'))))),
                'feedbackLink'=> $this->input->post('feedbackLink'),
                'contact' => $this->input->post('contact'),
                'email' => $this->input->post('email'),
                'country_id' =>$country_id, 
                'state_id' => $state_id, 
                'city_id' => $city_id, 
                'zip_code' => $zip_code,
                'address_line_1' =>$address_line_1, 
                'latitude' => $latitude,
                'longitude' =>$longitude,   
                'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                'physical_branch' =>$physical_branch,
                'by_user' => $_SESSION['UserId'],
            );            
            $idd = $this->Center_location_model->add_center_location($params);
            if($idd > 0){                
                $branch_divisions=$this->input->post('branch_divisions');
                $created=$modified=date('Y-m-d H:i:s');
                foreach($branch_divisions as $division_id){                  
                    $division_array[]=array(
                        'division_id' =>$division_id,
                        'by_user'  => $_SESSION['UserId'],
                        'center_id'=>$idd,
                        'created'=>$created,
                        'modified'=>$modified
                    );
                }                
                $this->Center_location_model->add_division_branch($division_array); 
                //activity update start              
                    $activity_name= BRANCH_ADD;
                    $description= 'New branch as '.$params['center_name'].' added';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                //activity update end               
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                if($this->Role_model->_has_access_('center_location','index')){
                    redirect('adminController/center_location/index');
                }else{
                    redirect('adminController/center_location/add');
                }
            }elseif($idd == 'exist') {
                $this->session->set_flashdata('flsh_msg', DUP_MSG);
                redirect('adminController/center_location/add');
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/center_location/add');
            }
            
        }else{            
            $data['all_country_list']= $this->Country_model->get_all_country_active();
            $data['all_division_list']= $this->Division_master_model->get_all_division_active();
            $data['_view'] = 'center_location/add';
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
        $data['title'] = 'Edit Branch';
        $data['center_location'] = $this->Center_location_model->get_center_location($id);
        if(isset($data['center_location']['center_id']))
        {  
            $physical_branch=$data['center_location']['physical_branch'];
            if(isset($_POST['physical_branch'])){   
                $physical_branch=$this->input->post('physical_branch');  
            }
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('center_name','Branch name','required|trim|min_length[4]|max_length[25]');
            $this->form_validation->set_rules('center_code','Branch code','required|trim|max_length[3]');
            if($physical_branch==1){
                if($this->input->post('is_overseas') == Null) {
                    $this->form_validation->set_rules('is_overseas','overseas','required');
                }  
                $this->form_validation->set_rules('country_id','country','required|integer');
                $this->form_validation->set_rules('state_id','state','required|integer');
                $this->form_validation->set_rules('city_id','city','required|integer');
                $this->form_validation->set_rules('address_line_1','address','required|trim|max_length[150]');
            }
            $this->form_validation->set_rules('branch_divisions[]','divisions', 'required');
            if($this->form_validation->run())     
            {   
                
                $country_id=$state_id=$city_id=$address_line_1=$latitude=$longitude='';
                if($physical_branch==1){
                    $is_overseas=$this->input->post('is_overseas');
                    $country_id=$this->input->post('country_id');
                    $state_id=$this->input->post('state_id');
                    $city_id=$this->input->post('city_id');$zip_code=$this->input->post('zip_code');
                    $address_line_1=$this->input->post('address_line_1');
                    $latitude=$this->input->post('latitude');
                    $longitude  =$this->input->post('longitude');                    
                }else{
                    $is_overseas=$this->input->post('is_overseas');
                    $country_id=$this->input->post('country_id');
                }
                if($country_id!=DEFAULT_COUNTRY){
                    $is_overseas=1;
                }else{
                    $is_overseas=0;
                }
                $params = array(  
                    'is_overseas' => $is_overseas,             
                    'center_name' => strtoupper(trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('center_name'))))),
                    'center_code' => strtoupper(trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('center_code'))))),
                    'feedbackLink'=> $this->input->post('feedbackLink'),
                    'contact' => $this->input->post('contact'),
                    'email' => $this->input->post('email'),
                    'country_id' =>$country_id, 
                    'state_id' => $state_id, 
                    'city_id' => $city_id, 
                    'zip_code' => $zip_code,
                    'address_line_1' =>$address_line_1, 
                    'latitude' => $latitude,
                    'longitude' =>$longitude,   
                    'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                    'physical_branch' =>$physical_branch,
                    'by_user' => $_SESSION['UserId'],
                );              
                $idd = $this->Center_location_model->update_center_location($id,$params,$data['center_location']['center_name'],$data['center_location']['center_code']);
                $center_id=$data['center_location']['center_id'];
                if($idd==1){
                    
                    if($this->input->post('branch_divisions')){
                        $branch_divisions = $this->input->post('branch_divisions');
                    }else{
                        $branch_divisions = 'noo';
                    }
                    if($branch_divisions !='noo'){
                        $created=$modified=date('Y-m-d H:i:s');
                        foreach($branch_divisions as $division_id){
                            $division_array[]=array(
                                'division_id' =>$division_id,
                                'by_user'  => $_SESSION['UserId'],
                                'center_id'=>$center_id,
                                'created'=>$created,
                                'modified'=>$modified
                            );
                        }                        
                        $this->Center_location_model->add_division_branch($division_array);
                    }
                    if($this->input->post('center_heads')){
                        $center_heads = $this->input->post('center_heads');
                    }else{
                        
                        $center_heads = 'noo';
                    }
                    if($center_heads !='noo'){
                        
                        $created=$modified=date('Y-m-d H:i:s');
                        
                        foreach($center_heads as $user_id){
                            $center_heads_array=array(
                                'user_id' =>$user_id,
                                'by_user'  => $_SESSION['UserId'],
                                'center_id'=>$center_id,
                                'created'=>$created,
                                'modified'=>$modified
                            );
                            $this->Center_location_model->add_center_heads($center_heads_array);
                        }
                        
                    }
                    if($this->input->post('center_visa_managements')){
                        $center_visa_managements = $this->input->post('center_visa_managements');
                    }else{
                        
                        $center_visa_managements = 'noo';
                    }
                    if($center_visa_managements !='noo'){
                        
                        $created=$modified=date('Y-m-d H:i:s');
                        
                        foreach($center_visa_managements as $user_id){
                            $center_visa_managements_array=array(
                                'user_id' =>$user_id,
                                'by_user'  => $_SESSION['UserId'],
                                'center_id'=>$center_id,
                                'created'=>$created,
                                'modified'=>$modified
                            );
                            $this->Center_location_model->add_center_visa_managements($center_visa_managements_array);
                        }
                        
                    }
                    if($this->input->post('center_academy_managements')){
                        $center_academy_managements = $this->input->post('center_academy_managements');
                    }else{
                        
                        $center_academy_managements = 'noo';
                    }
                    if($center_academy_managements !='noo'){
                        
                        $created=$modified=date('Y-m-d H:i:s');
                        
                        foreach($center_academy_managements as $user_id){
                            $center_academy_managements_array=array(
                                'user_id' =>$user_id,
                                'by_user'  => $_SESSION['UserId'],
                                'center_id'=>$center_id,
                                'created'=>$created,
                                'modified'=>$modified
                            );
                            $this->Center_location_model->add_center_academy_managements($center_academy_managements_array);
                        }
                        
                    }
                    //activity update start              
                    $activity_name= BRANCH_UPDATE;
                    $description= 'Branch updated';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG); 
                    if($this->Role_model->_has_access_('center_location','index')){
                        redirect('adminController/center_location/index');
                    }else{
                        redirect('adminController/center_location/edit/'.$id);
                    }
                }elseif($idd==2){
                    $this->session->set_flashdata('flsh_msg', DUP_MSG);           
                    redirect('adminController/center_location/edit/'.$id);
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/center_location/edit/'.$id);
                }
            }else{
                $data['all_country_list'] = $this->Country_model->get_all_country_active();
                $data['all_state_list'] = $this->State_model->get_state_list($data['center_location']['country_id']);
                $data['all_city_list'] = $this->City_model->get_city_list($data['center_location']['state_id']);                
                $data['all_division_list']=$this->Division_master_model->get_all_division_active();
                $data['center_divisions']=$this->Center_division_model->get_center_divisions_ids($id);                
                $data['user_list'] = $this->User_model->getUserListByFunctionalBranchId($id);
                //$data['center_heads']=$this->Center_head_model->get_center_head_users($id);
                //$data['center_academy_managements']=$this->Center_academy_management_model->get_center_academy_management_users($id);                
                //$data['center_visa_managements']=$this->Center_visa_management_model->get_center_visa_management_users($id);                
                $data['_view'] = 'center_location/edit';
                $this->load->view('layouts/main',$data);
                
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

    function view_branch_details($id){  

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $data['title'] = 'Branch Details';
        $data['center_location'] = $this->Center_location_model->get_center_location($id);
        if(isset($data['center_location']['center_id']))
        {  
            $physical_branch=$data['center_location']['physical_branch'];
            if(isset($_POST['physical_branch'])){   
                $physical_branch=$this->input->post('physical_branch');  
            }
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('center_name','Branch name','required|trim');
            $this->form_validation->set_rules('center_code','Branch code','required|trim');
            if($physical_branch==1){
                $this->form_validation->set_rules('is_overseas','overseas','required');
                $this->form_validation->set_rules('country_id','country','required');
                $this->form_validation->set_rules('state_id','state','required');
                $this->form_validation->set_rules('city_id','city','required');
                $this->form_validation->set_rules('address_line_1','address','required|trim');
            }
            $this->form_validation->set_rules('branch_divisions[]','divisions', 'required');
            if($this->form_validation->run())     
            {   
                
                $country_id=$state_id=$city_id=$address_line_1=$latitude=$longitude='';
                if($physical_branch==1){
                    $is_overseas=$this->input->post('is_overseas');
                    $country_id=$this->input->post('country_id');
                    $state_id=$this->input->post('state_id');
                    $city_id=$this->input->post('city_id');$zip_code=$this->input->post('zip_code');
                    $address_line_1=$this->input->post('address_line_1');
                    $latitude=$this->input->post('latitude');
                    $longitude  =$this->input->post('longitude');                    
                }else{
                    $is_overseas=$this->input->post('is_overseas');
                }
                $params = array(  
                    'is_overseas' => $is_overseas,             
                    'center_name' => $this->input->post('center_name'),
                    'center_code' => $this->input->post('center_code'),
                    'feedbackLink'=> $this->input->post('feedbackLink'),
                    'contact' => $this->input->post('contact'),
                    'email' => $this->input->post('email'),
                    'country_id' =>$country_id, 
                    'state_id' => $state_id, 
                    'city_id' => $city_id, 
                    'zip_code' => $zip_code,
                    'address_line_1' =>$address_line_1, 
                    'latitude' => $latitude,
                    'longitude' =>$longitude,   
                    'active' => $this->input->post('active'),
                    'physical_branch' =>$physical_branch,
                    'by_user' => $_SESSION['UserId'],
                );              
                $id = $this->Center_location_model->update_center_location($id,$params);
                $center_id=$data['center_location']['center_id'];
                if($id){
                    
                    if($this->input->post('branch_divisions')){
                        $branch_divisions = $this->input->post('branch_divisions');
                    }else{
                        $branch_divisions = 'noo';
                    }
                    if($branch_divisions !='noo'){
                        $created=$modified=date('Y-m-d H:i:s');
                        foreach($branch_divisions as $division_id){
                            $division_array[]=array(
                                'division_id' =>$division_id,
                                'by_user'  => $_SESSION['UserId'],
                                'center_id'=>$center_id,
                                'created'=>$created,
                                'modified'=>$modified
                            );
                        }                        
                        $this->Center_location_model->add_division_branch($division_array);
                    }
                    if($this->input->post('center_heads')){
                        $center_heads = $this->input->post('center_heads');
                    }else{
                        
                        $center_heads = 'noo';
                    }
                    if($center_heads !='noo'){
                        
                        $created=$modified=date('Y-m-d H:i:s');
                        
                        foreach($center_heads as $user_id){
                            $center_heads_array=array(
                                'user_id' =>$user_id,
                                'by_user'  => $_SESSION['UserId'],
                                'center_id'=>$center_id,
                                'created'=>$created,
                                'modified'=>$modified
                            );
                            $this->Center_location_model->add_center_heads($center_heads_array);
                        }
                        
                    }
                    if($this->input->post('center_visa_managements')){
                        $center_visa_managements = $this->input->post('center_visa_managements');
                    }else{
                        
                        $center_visa_managements = 'noo';
                    }
                    if($center_visa_managements !='noo'){
                        
                        $created=$modified=date('Y-m-d H:i:s');
                        
                        foreach($center_visa_managements as $user_id){
                            $center_visa_managements_array=array(
                                'user_id' =>$user_id,
                                'by_user'  => $_SESSION['UserId'],
                                'center_id'=>$center_id,
                                'created'=>$created,
                                'modified'=>$modified
                            );
                            $this->Center_location_model->add_center_visa_managements($center_visa_managements_array);
                        }
                        
                    }
                    if($this->input->post('center_academy_managements')){
                        $center_academy_managements = $this->input->post('center_academy_managements');
                    }else{
                        
                        $center_academy_managements = 'noo';
                    }
                    if($center_academy_managements !='noo'){
                        
                        $created=$modified=date('Y-m-d H:i:s');
                        
                        foreach($center_academy_managements as $user_id){
                            $center_academy_managements_array=array(
                                'user_id' =>$user_id,
                                'by_user'  => $_SESSION['UserId'],
                                'center_id'=>$center_id,
                                'created'=>$created,
                                'modified'=>$modified
                            );
                            $this->Center_location_model->add_center_academy_managements($center_academy_managements_array);
                        }
                        
                    }
                    //activity update start              
                    $activity_name= BRANCH_UPDATE;
                    $description= 'Branch updated';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                    //activity update end
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);           
                    redirect('adminController/center_location/index');
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/center_location/edit/'.$id);
                }
            }
            else
            {
                $data['all_country_list'] = $this->Country_model->get_all_country_active();
                $data['all_state_list'] = $this->State_model->get_state_list($data['center_location']['country_id']);
                $data['all_city_list'] = $this->City_model->get_city_list($data['center_location']['state_id']);                
                $data['all_division_list']=$this->Division_master_model->get_all_division_active();
                $data['center_divisions']=$this->Center_division_model->get_center_divisions_ids($id);
                $data['user_list'] = $this->User_model->getUserListByFunctionalBranchId($id);
                //$data['center_heads']=$this->Center_head_model->get_center_head_users($id);
                //$data['center_academy_managements']=$this->Center_academy_management_model->get_center_academy_management_users($id);                
                //$data['center_visa_managements']=$this->Center_visa_management_model->get_center_visa_management_users($id);                
                $data['_view'] = 'center_location/view_branch_details';
                $this->load->view('layouts/main',$data);
                
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }   
    
    /*function remove($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $center_location = $this->Center_location_model->get_center_location($id);
        if(isset($center_location['center_id']))
        {
            $this->Center_location_model->delete_center_location($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/center_location/index');
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/  

    
    function ajax_delete_user_center_head(){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $center_id = $this->input->post('center_id', true);
        $user_id = $this->input->post('user_id', true);
        if($user_id!=''){
            $del = $this->Center_location_model->delete_user_center_head($center_id,$user_id);
            if($del){  
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

    function ajax_delete_user_center_visa_managements(){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $center_id = $this->input->post('center_id', true);
        $user_id = $this->input->post('user_id', true);
        if($user_id!=''){
            $del = $this->Center_location_model->delete_user_center_visa_managements($center_id,$user_id);
            if($del){  
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
    
    function ajax_delete_user_center_academy_managements(){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $center_id = $this->input->post('center_id', true);
        $user_id = $this->input->post('user_id', true);
        if($user_id!=''){
            $del = $this->Center_location_model->delete_user_center_academy_managements($center_id,$user_id);
            if($del){  
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
    
    
    /*function add_center_department_($center_id){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
		if(!$this->_has_access($cn,'index')) {redirect('adminController/error_cl/index');}
        if(empty($center_id)){redirect('adminController/error_cl/index');}        
		$data['center_id'] =$center_id;
		$data['si'] = 0;
	    $center_location_data=$data['center_location'] = $this->Center_location_model->get_center_location($center_id);
	     if(empty($center_location_data)){redirect('adminController/error_cl/index');}        
         //access control ends
            $data['title'] = 'Add Decentralised Department In '.$center_location_data['center_name'].' Branch';
            $this->load->library('form_validation');
            $this->form_validation->set_rules('division_id[]','Division','required|trim');
            $this->form_validation->set_rules('department_id','Department','required');            
            $this->form_validation->set_rules('department_executive_management_tier[]','Executive Management Tier','required|trim');
            $this->form_validation->set_rules('department_management_tier[]','Department Management Tier','required|trim');            
            $this->form_validation->set_rules('department_head','Department Head','required|trim');
            
        if($this->form_validation->run())     
        {   
            
            $department_id=$this->input->post('department_id');
            $total_employee_tier=$this->input->post('total_employee_tier');
            
            $params = array(
                'department_id' => $this->input->post('department_id'),
                'by_user' => $_SESSION['UserId'],
                'department_head' => $this->input->post('department_head'),
                'center_id' => $center_id,
                'total_employee_tier'=>$total_employee_tier
            );
            $department_executive_management_tier = $this->input->post('department_executive_management_tier');$department_management_tier = $this->input->post('department_management_tier');
			
            $idd = $this->Department_model->add_center_department($params);
            if($idd){
				
                $division_ids = $this->input->post('division_id');
				foreach($division_ids as $division_id) {                  
                    $params2=array(
                        'division_id' =>$division_id,
                        'department_id'=>$department_id,
                        'by_user'  => $_SESSION['UserId'],
						'center_id'=>$center_id
                    );
                    $this->Department_model->add_center_department_division($params2);
                }
                foreach ($department_executive_management_tier as $user_id) {                  
                    $params=array(
                        'user_id' =>  $user_id,
                        'department_id'=> $department_id,
                        'by_user'  => $_SESSION['UserId'],
                        'center_id'=>$center_id
                    );
                    $this->Department_model->add_center_department_executive_management_tier($params);
                }
                foreach ($department_management_tier as $user_id) {                  
                    
                    $params=array(
                        'user_id' =>  $user_id,
                        'department_id'=>$department_id,
                        'by_user'  => $_SESSION['UserId'],
                        'center_id'=> $center_id
                    );
                    $this->Department_model->add_center_department_management_tier($params);
                    
                }
                if($total_employee_tier > 0){
                     
                        $j=1;
                        for($i=1; $i<=$total_employee_tier; $i++){
                            
                            $department_employee_tier=$this->input->post('department_employee_tier'.$i);
                            $tire_sn=$this->input->post('tire_sn'.$i);
                            
                            if(!empty($tire_sn)){
                                
                               $user_id=implode(",",$department_employee_tier);
                              
                               $department_employee_tier_array[]=array(
                                'user_id' =>  $user_id,
                                'department_id'=>$department_id,
                                'by_user'  => $_SESSION['UserId'],
                                 'center_id'=> $center_id,
                                 'tier'     => $tire_sn,
                                );
                                
                            }
                        } 
                        $this->Department_model->add_center_department_employee_tier($department_id,$center_id,$department_employee_tier_array);
                  
                }
				
				$getDivisionName=$this->Division_master_model->getAllDivisionName($division_ids);
				$division_name = implode(',',$getDivisionName);
				
				$getDepartmentName=$this->Department_model->getDeptName($department_id);
				//activity update start              
				$activity_name= DEPARTMENT_ADD;
				$description= 'Department '.$getDepartmentName['department_name']. ' added In '.$center_location_data['center_name'].' Branch with having division '.$division_name;
				
				$res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
				//activity update end
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/center_location/list_center_department_/'.$center_id);
                
            }else{
                $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                redirect('adminController/center_location/add_center_department_');
            }
        }else{
			
            $data['all_division_list']=$this->Center_division_model->getCenterDivisions($center_id);
            $data['_view'] = 'center_location/add_center_department';
            $this->load->view('layouts/main',$data);
        }
    }
    
    
    function edit_center_department_($center_id,$id){
    
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();
        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        if(empty($center_id)){redirect('adminController/error_cl/index');}
        if(empty($id)){redirect('adminController/error_cl/index');}
        $data['department'] = $this->Department_model->get_center_department($id);
		$center_location_data=$this->Center_location_model->get_center_location($center_id);
        if(isset($data['department']['id']))
        { 
            $data['center_id'] =$center_id;
            $division_id=$data['department']['division_id'];
            $data['si'] = 0;
             //access control ends
            $data['title'] = 'Edit Department';
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('department_id','Department','required');
            $this->form_validation->set_rules('department_head','Department Head','required|trim');
            $data['department_division'] = $this->Department_model->getDivisionByCenterDepartmentId($center_id,$data['department']['department_id']);
			
            $data['executive_management_tier_user_list'] = $this->Department_model->getCenterExecutiveManagementTierUserListByDepartmentId($center_id,$data['department']['department_id']);
            $data['management_tier_user_list'] = $this->Department_model->getCenterManagementTierUserListByDepartmentId($center_id,$data['department']['department_id']);
			
            $data['employee_tier_user_ids']=$this->Department_model->getCenterEmployeeTierIdsByDepartmentId($center_id,$data['department']['department_id']);
			
            $old_department_id=$data['department']['department_id'];
            $data['old_department_id']=$old_department_id;
            if(empty($data['executive_management_tier_user_list'])){
                
                $this->form_validation->set_rules('department_executive_management_tier[]','Executive Management Tier','required|trim');
            }
            if(empty($data['management_tier_user_list'])){
                $this->form_validation->set_rules('department_management_tier[]','Department Management Tier','required|trim');
                
            }
            
            if($this->form_validation->run())     
            {   
                
                $department_id=$this->input->post('department_id');
                $total_employee_tier=$this->input->post('total_employee_tier');
                $paramsNew=$params = array(
				    'department_id'=>$department_id,
                    'by_user' => $_SESSION['UserId'],
                    'department_head' => $this->input->post('department_head'),
                    'center_id' => $center_id,
                    'total_employee_tier'=>$total_employee_tier
                );
                $department_executive_management_tier = $this->input->post('department_executive_management_tier');$department_management_tier = $this->input->post('department_management_tier');
                $idd = $this->Department_model->update_center_department($id,$params);
                
                if($idd){
                    $created=$modified=date('Y-m-d H:i:s');
                    foreach ($department_executive_management_tier as $user_id) {                  
                        $params=array(
                            'user_id' =>  $user_id,
                            'department_id'=> $department_id,
                            'by_user'  => $_SESSION['UserId'],
                            'created'  => $created,
                            'modified'  => $modified,
                            'center_id'=>$center_id
                            
                        );
                        $this->Department_model->add_center_department_executive_management_tier($params);
                        
                    }
                    
                    foreach ($department_management_tier as $user_id) {                  
                        
                        $params=array(
                            'user_id' =>  $user_id,
                            'department_id'=>$department_id,
                            'by_user'  => $_SESSION['UserId'],
                            'created'  => $created,
                            'modified'  => $modified,
                            'center_id'=> $center_id
                        );
                        $this->Department_model->add_center_department_management_tier($params);
                    }
                    
                    #this code run only if department change
                    if($department_id !=$old_department_id){
                        
                        $this->Department_model->update_center_department_management_tier($department_id,$center_id,$old_department_id);
                        
                        $this->Department_model->update_center_department_executive_management_tier($department_id,$center_id,$old_department_id);
                        
                    }
                    $department_employee_tier_array=array();
                    if($total_employee_tier > 0){
                         
                            $j=1;
                            for($i=1; $i<=$total_employee_tier; $i++){
                                
                                $department_employee_tier=$this->input->post('department_employee_tier'.$i);
                                $tire_sn=$this->input->post('tire_sn'.$i);
								$tier_title=$this->input->post('tier_title'.$i);
                                if(!empty($tire_sn)){
                                    
                                   $user_id=implode(",",$department_employee_tier);
                             
                                   $department_employee_tier_array[]=array(
                                    'user_id' =>  $user_id,
                                    'department_id'=>$department_id,
                                    'by_user'  => $_SESSION['UserId'],
                                    'created'  => $created,
                                    'modified' => $modified,
                                     'center_id'=> $center_id,
									  'tier'=> $tire_sn,
                                     'tier_title'=> $tier_title,
                                    );
                                    //$j++;
                                   
                                }
                            }
                    }
                    $this->Department_model->add_center_department_employee_tier($department_id,$center_id,$department_employee_tier_array,$old_department_id);
					
					$activity_name= DEPARTMENT_UPDATE;
					$getDepartmentName=$this->Department_model->getDeptName($department_id);
					
					$description= 'Department '.$getDepartmentName['department_name']. ' updated In '.$center_location_data['center_name'].' Branch oldData Data '.json_encode($data['department']).' And new data'.json_encode($paramsNew);
					
					$res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
					
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/Center_location/list_center_department_/'.$center_id);
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/center_location/edit_center_department_');
                }
            }else{
                
                $data['user_list'] = $this->User_model->getUserListByFunctionalBranchIdAndDivisionId($center_id,$division_id);
                $data['all_division_list'] =$this->Center_division_model->getCenterDivisions($center_id);
                $data['_view'] = 'center_location/edit_center_department';
                $this->load->view('layouts/main',$data);
                
            }
        }else
            show_error(ITEM_NOT_EXIST);
        
    }
	
    function list_center_department_($center_id){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        if(empty($center_id)){redirect('adminController/error_cl/index');}
        
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/center_location/list_center_department_/'.$center_id.'/?');
        $config['total_rows'] = $this->Department_model->get_all_center_department_count($center_id);
        
        $this->pagination->initialize($config);
        
        $data['center_location'] = $this->Center_location_model->get_center_location($center_id);
        
        $center_department=$data['center_department'] = $this->Department_model->get_all_center_department($center_id,$params);
        
        $data['center_id']=$center_id;
        $data['title'] = ucfirst($data['center_location']['center_name']).' Branch Department';
        
        foreach($center_department as $key=>$department){
            
            $department_id=$department['department_id'];
			$data['center_department'][$key]['division_name'] = $this->Department_model->getDivisionByCenterDepartmentId($center_id,$department_id);
			
            $data['center_department'][$key]['executive_management_tier_user_list'] = $this->Department_model->getCenterExecutiveManagementTierUserListByDepartmentId($center_id,$department_id);
            
            $data['center_department'][$key]['management_tier_user_list'] = $this->Department_model->getCenterManagementTierUserListByDepartmentId($center_id,$department_id);
            
            //$data['center_department'][$key]['employee_tier']=$this->Department_model->getCenterEmployeeTierNameByDepartmentId($center_id,$department_id);
        }
        $data['_view'] = 'center_location/list_center_department';
        $this->load->view('layouts/main',$data);
    }
    
    function view_center_department_($center_id,$department_id){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        if(empty($center_id)){redirect('adminController/error_cl/index');}
        if(empty($department_id)){redirect('adminController/error_cl/index');}
        
        $data['center_location'] = $this->Center_location_model->get_center_location($center_id);
        
        $center_department=$data['center_department'] =$data['department'] = $this->Department_model->getCenterDepartmentByCenterIdAndDepartmentId($center_id,$department_id);
        $data['center_id']=$center_id;
        
        $data['title'] =$center_department['department_name'].' Department';
        $department_id=$center_department['department_id'];
		$data['center_department']['department_division'] = $this->Department_model->getDivisionByCenterDepartmentId($center_id,$department_id);
		
        $data['center_department']['executive_management_tier_user_list'] = $this->Department_model->getCenterExecutiveManagementTierUserListByDepartmentId($center_id,$department_id);
		
        $data['center_department']['management_tier_user_list'] = $this->Department_model->getCenterManagementTierUserListByDepartmentId($center_id,$department_id);
        
        $data['center_department']['employee_tier']=$this->Department_model->getCenterEmployeeTierNameByDepartmentId($center_id,$department_id);
        $data['_view'] = 'center_location/view_center_department';
        $this->load->view('layouts/main',$data);
        
    }*/
    
    /*function remove_center_department($id)
    {
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $department = $this->Department_model->get_center_department($id);
        
        $department_id=$department['department_id'];
        $center_id=$department['center_id'];
        
        if(isset($department['id']))
        {
            $this->Department_model->delete_cenater_department($id,$department_id,$center_id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            redirect('adminController/Center_location/view_center_department/'.$center_id);
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/
    
    /*function ajax_get_department_list(){       

        $division_id = $this->input->post('division_id');
        $center_id = $this->input->post('center_id');
        if(!empty($division_id) && !empty($center_id)){
			
            $response['department_list'] =  $this->Department_model->getDecentralisedDepartmentByDivisionId($division_id);
            $response['user_list'] =  $this->User_model->getUserListByFunctionalBranchIdAndDivisionId($center_id,$division_id);
            echo json_encode($response);
			
        }else{
            
            header('Content-Type: application/json');
            $response = ['msg'=>'list not available!', 'status'=>'false'];
            echo json_encode($response);
        }
    }*/
    
    /*function delete_user_center_department_management_tier_(){
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $department_id = $this->input->post('department_id', true);
        $center_id = $this->input->post('center_id', true);
        $user_id = $this->input->post('user_id', true);
        
        if($user_id!=''){
            $del = $this->Department_model->delete_user_center_department_management_tier($center_id,$department_id,$user_id);
            if($del){
                $getDeptName = $this->Department_model->getDeptName($department_id);
		        $department_name = $getDeptName['department_name'];
				$center_location_data=$data['center_location'] = $this->Center_location_model->get_center_location($center_id);
            	//activity update start              
				$activity_name= USER_DEPT_MGMT_TIER_DELETE;
			    $description= 'Employee '.$employeeCode.' with Branch
				'.$center_location_data['center_name'].'And Departmet '.$department_name.' removed from department management tier';
				$res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);				
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
    
    function delete_user_center_executive_management_tier_(){
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $department_id = $this->input->post('department_id', true);
        $user_id = $this->input->post('user_id', true);
        $center_id = $this->input->post('center_id', true);
        if($user_id!=''){
            $del = $this->Department_model->delete_user_center_executive_management_tier($center_id,$department_id,$user_id);
            if($del){
				
                $getDeptName = $this->Department_model->getDeptName($department_id);
		        $department_name = $getDeptName['department_name'];
				$center_location_data=$data['center_location'] = $this->Center_location_model->get_center_location($center_id);
            	//activity update start              
				$activity_name= USER_EXEC_MGMT_TIER_DELETE;
				$description= 'Employee '.$employeeCode.' with  Branch
				'.$center_location_data['center_name'].' And Departmet '.$department_name.' removed from executive management tier';
				$res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);    				
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
    }*/
    
    function ajax_check_department_availibility(){
        
        $department_id = $this->input->post('department_id', true);
        $center_id = $this->input->post('center_id', true);
        $old_department_id = $this->input->post('old_department_id', true);
        $return=$this->Department_model->check_department_availibility($department_id,$center_id,$old_department_id);
        if($return==0){
			echo 'true';
		}else{
			echo 'false';
		}
		exit();
    }
    /*********Start New Function***************/ 
    
}
