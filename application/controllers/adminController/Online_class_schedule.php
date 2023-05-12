<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Online_class_schedule extends MY_Controller{
    
    function __construct(){

        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}       
        $this->load->model('Online_class_schedule_model');
        $this->load->model('User_model'); 
        $this->load->model('Classroom_model');
        $this->load->model('Test_module_model');   
        $this->load->model('Programe_master_model'); 
        $this->load->model('Batch_master_model');
        $this->load->model('Category_master_model');
        $this->load->model('Center_location_model');           
    }
    
    function index($classroom_id=NULL){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $userBranch=[];
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }       

        $current_DateTime = date("d-m-Y G:i:00");
        $current_DateTimeStr = strtotime($current_DateTime);
        //$current_DateTimeStr_after = $current_DateTimeStr - 3600;
        $this->Online_class_schedule_model->deactivate_shedule($current_DateTimeStr);

        $classroomData2 = [];
        $pattern = "/Trainer/i";
        $isTrainer = preg_match($pattern, $_SESSION['roleName']);
        if($isTrainer){
            $UserAccessAsTrainer=$this->User_model->getUserAccessAsTrainer($_SESSION['UserId']);
            if(!empty($UserAccessAsTrainer)){
                foreach ($UserAccessAsTrainer as $u) {
                    $classroomData1 = $this->Classroom_model->get_classroomID_by_access($u['test_module_id'],$u['programe_id'],$u['category_id'],$u['batch_id'],$u['center_id']);
                    if(!empty($classroomData1)){
                        array_push($classroomData2, $classroomData1);
                    }           
                }
            }else{
                $classroomData2 = [];
            }                
        }else{
            $classroomData2 = $this->Classroom_model->get_all_classroomID($_SESSION['roleName'],$userBranch);                
        }
        $rawArr = [];
        foreach ($classroomData2 as $c) {
            array_push($rawArr, $c['id']);
        }     
        if($classroom_id == 0)
        {
            $classroom_id="";
        }     
        $data['classroom_id'] = $classroom_id;
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        if($classroom_id>0){
            $config['base_url'] = site_url('adminController/online_class_schedule/index/'.$classroom_id.'/?');
        }else{
           $config['base_url'] = site_url('adminController/online_class_schedule/index/?'); 
        }        
        $config['total_rows'] = $this->Online_class_schedule_model->get_all_schedule_count($rawArr,$classroom_id);
        $this->pagination->initialize($config);
        $data['title'] = 'Class Schedule';
        
        $data['online_class_schedule'] = $this->Online_class_schedule_model->get_all_schedule($rawArr,$params,$classroom_id);
        
        $data['_view'] = 'online_class_schedule/index';
        $this->load->view('layouts/main',$data);
    }

    function ajax_check_duplicate_sch()
    {
       $classroom_id=$this->input->post('classroom_id',TRUE);//2
       if(is_array($classroom_id) == 1) 
       {
        // MULTIPLE OPTION CASE
        $class_arr= $this->input->post('classroom');//2
        $duplicate_arr=array();
        foreach($classroom_id as $kry=>$c)
        {   
            
            if ($c == $class_arr[$kry]['id'])
            {
               $class_name=$class_arr[$kry]['name'];
            }
         
            $tillDate = $this->input->post('till_date');            
            $dateTime = $this->input->post('dateTime');
            $class_duration="+".$this->input->post('class_duration');
            $classDate_dateTime = trim(substr($dateTime,0,10));
            $date_create=date_create($classDate_dateTime);
            $classDate_from = date_format($date_create,"d-m-Y");
            $calssTime = trim(substr($this->input->post('dateTime'),11));
           
            $datetime1 = strtotime($classDate_from);
            $datetime2 = strtotime($tillDate);
            $Diff = $datetime2-$datetime1;
            $dayDiff=$Diff/86400;
           // fetch count of all schedule
            $check_already_exist_schedule=$this->auto_check_already_exist_schedule($c);           
            for($i=0;$i<=$dayDiff;$i++)
                {
                    $thisdate = date('d-m-Y', strtotime($this->input->post('dateTime') . ' +'.$i.' day'));
                    $dateTime = date('d-m-Y H:i:s', strtotime($this->input->post('dateTime') . ' +'.$i.' day'));
                    $nameOfDay = date('D', strtotime($dateTime));
                    $dateTimeStr = strtotime($dateTime);

                    $enddate_end= date('d-m-Y G:i:s', strtotime($class_duration.' minutes', strtotime($dateTime)));
                    $strdate_end = strtotime($enddate_end);
                    $dateTime.':'.$dateTimeStr.' : '.$enddate_end.':'.$strdate_end.'<br>';  
                                    
                    //if schedule exist for this class                   
                    if($check_already_exist_schedule >0)
                    {                                      
                        $params = array(
                        'class_id' => $c,
                        'curr_date' =>$thisdate,
                        'st_date' => $dateTimeStr,
                        'end_date' => $strdate_end,
                        'online_class_schedule' => $this->input->post('online_class_schedule'),
                        );   
                        //now check the current datetime is duplicate or not 
                        $get_schedule_startenddate=$this->Online_class_schedule_model->get_schedule_startenddate($params);                      
                        if(empty($get_schedule_startenddate))//duplicate found
                        {
                            $duplicate_arr[$class_name]['duplicate'][]=$thisdate;
                           
                        }
                        else
                        { //duplicate not found
                         
                            $duplicate_arr[$class_name]['valid'][]=$thisdate;                           
                        }
                    }
                    else {
                        $duplicate_arr[$class_name]['valid'][]=$thisdate;
                    }
                } 
        }
        
       }
       else
       {
        //SINGLE OPTION CASE
            $c=$this->input->post('classroom_id');//2       
            $class_arr= $this->input->post('classroom');//2
            $class_name=$class_arr[0]['name'];      
            $duplicate_arr=array();         
           // $tillDate = $this->input->post('till_date');            
            $dateTime = $this->input->post('dateTime');
            $class_duration="+".$this->input->post('class_duration');
            $classDate_dateTime = trim(substr($dateTime,0,10));
            $date_create=date_create($classDate_dateTime);
            $classDate_from = date_format($date_create,"d-m-Y");
            $calssTime = trim(substr($this->input->post('dateTime'),11));
           
            $datetime1 = strtotime($classDate_from);
            $tillDate= date('d-m-Y G:i:s', strtotime($class_duration.' minutes', strtotime($dateTime)));           


            $datetime2 = strtotime($tillDate);
            $Diff = $datetime2-$datetime1;
            $dayDiff=$Diff/86400;
            $selecteddate = date('d-m-Y', strtotime($this->input->post('dateTime')));
            $edit_online_class_schedule= $this->input->post('online_class_schedule');
            $check_already_exist_schedule= $this->Online_class_schedule_model->get_selectedclassroomschedule_count($c,$selecteddate,$edit_online_class_schedule);

           // $check_already_exist_schedule=$this->auto_check_already_exist_schedule($c); 
            
            
            for($i=0;$i<=$dayDiff;$i++)
                {
                    $thisdate = date('d-m-Y', strtotime($this->input->post('dateTime') . ' +'.$i.' day'));
                    $dateTime = date('d-m-Y H:i:s', strtotime($this->input->post('dateTime') . ' +'.$i.' day'));
                    $nameOfDay = date('D', strtotime($dateTime));
                    $dateTimeStr = strtotime($dateTime);

                    $enddate_end= date('d-m-Y G:i:s', strtotime($class_duration.' minutes', strtotime($dateTime)));
                    $strdate_end = strtotime($enddate_end);
                    $dateTime.':'.$dateTimeStr.' : '.$enddate_end.':'.$strdate_end.'<br>';  
                                    
                    //if schedule exist for this class
                     $check_already_exist_schedule;
                    if($check_already_exist_schedule >0)
                    {  
                                     
                        $params = array(
                        'class_id' => $c,
                        'curr_date' =>$thisdate,
                        'st_date' => $dateTimeStr,
                        'end_date' => $strdate_end,
                        'online_class_schedule' => $this->input->post('online_class_schedule'),
                        );   
                        //now check the current datetime is duplicate or not 
                        $get_schedule_startenddate=$this->Online_class_schedule_model->get_schedule_startenddate($params);                      
                        if(empty($get_schedule_startenddate))//duplicate found
                        {
                            $duplicate_arr[$class_name]['duplicate'][]=$thisdate;                          
                        }
                        else
                        { //duplicate not found
                             $duplicate_arr[$class_name]['valid'][]=$thisdate;                           
                        }
                    }
                    else {
                        $duplicate_arr[$class_name]['valid'][]=$thisdate;
                    }
                }         

       }
       

       $y = array_column($duplicate_arr, 'duplicate');       
       if(!empty($y))
        {
            $data['data'] = $duplicate_arr;
            $this->load->view('online_class_schedule/ajax_duplicate_data', $data);
        }
        else {
            echo 1;
        }    

    }

    function add($classroom_id2=NULL){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        $params=[];
        //access control ends
        //echo date_default_timezone_get();
        $userBranch=[];
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        
        $data['classroom_id'] = (isset($classroom_id))?$classroom_id:'';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('classroom_id[]','Classroom','required'); 
        $this->form_validation->set_rules('dateTime','Date Time','required|trim|min_length[16]|max_length[19]');
        $this->form_validation->set_rules('till_date','Date Till','required|trim|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('class_duration','Class duration','required|trim|integer|min_length[2]|max_length[3]');  
		$this->form_validation->set_rules('topic','Class Topic','required|trim|max_length[50]');
		
		if($this->form_validation->run()){

            $tillDate = $this->input->post('till_date');            
            $dateTime = $this->input->post('dateTime_');
            $class_duration="+".$this->input->post('class_duration');
            $classDate_dateTime = trim(substr($dateTime,0,10));
            $date_create=date_create($classDate_dateTime);
            $classDate_from = date_format($date_create,"d-m-Y");
            $calssTime = trim(substr($this->input->post('dateTime'),11));
           
            $datetime1 = strtotime($classDate_from);
            $datetime2 = strtotime($tillDate);
            $Diff = $datetime2-$datetime1;
            $dayDiff=$Diff/86400;
            $dtetime = explode(",",$dateTime);
            $dteTimeStr ='';
            for($d=0;$d<count($dtetime);$d++)
            {
                $date = new DateTime($dtetime[$d]);
                $dateTime = $date->format('d-m-Y G:i:00');            
                $nameOfDay = date('D', strtotime($this->input->post('dateTime')));
                $dteTimeStr .= strtotime($dateTime).',';                
            }
            $date = new DateTime($dateTime);
            $dateTime = $date->format('d-m-Y G:i:00');            
            $nameOfDay = date('D', strtotime($this->input->post('dateTime')));
            $dateTimeStr = strtotime($dateTime);
            $classroom_id=$this->input->post('classroom_id');

            foreach($classroom_id as $c){ 
            // for($i=0;$i<=$dayDiff;$i++){

                $thisdate = date('d-m-Y', strtotime($this->input->post('dateTime') . ' +'.$i.' day'));
                $dateTime = date('d-m-Y H:i:s', strtotime($this->input->post('dateTime') . ' +'.$i.' day'));
                $nameOfDay = date('D', strtotime($dateTime));
                $dateTimeStr = strtotime($dateTime);  
                $enddate_end= date('d-m-Y H:i:s', strtotime($class_duration.' minutes', strtotime($dateTime)));
                $strdate_end = strtotime($enddate_end);
                $params = array(
                    'classroom_id' => $c,
                    'dateTime'=> $this->input->post('dateTime_'),
                    'strdate'=>  rtrim($dteTimeStr,','),
                    'strdate_end'=>  $strdate_end,
                    'dayname' => $nameOfDay,
                    'till_date' => $tillDate,
                    'topic' => $this->input->post('topic'),
                    'class_duration' => $this->input->post('class_duration'),
                    'trainer_id' => $this->input->post('trainer_id'),
                    'conf_URL' => $this->input->post('conf_URL'),
                    'active' => 1,
                    'by_user' => $_SESSION['UserId'],
                ); 
                // pr($params,1);          
                $idd = $this->Online_class_schedule_model->add_schedule($params);
                // }  
            }       
 
            if($idd){
                if($classroom_id2){
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);                   
                    redirect('adminController/online_class_schedule/index/'.$classroom_id2);
                 }else{
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/online_class_schedule/index');
                 } 
                
                
            }else{
                if($classroom_id2){
                   $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                   redirect('adminController/online_class_schedule/add/'.$classroom_id2); 
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/online_class_schedule/add');
                }                
            } 
                       
        }
        $dropvalues = $this->auto_fetch_dropvalues_by_trainer_access($params,$userBranch);
        $data['title'] = 'Add new schedule';
        $data['classroom_id']=$classroom_id2;            
        $data['_view'] = 'online_class_schedule/add';
        $this->load->view('layouts/main',array_merge($data,$dropvalues));
    }
    function auto_fetch_dropvalues_by_trainer_access($params=null,$userBranch=null)
    {
        $data = [];
        $pattern = "/Trainer/i";
        $isTrainer = preg_match($pattern, $_SESSION['roleName']);
        if($isTrainer){
            $UserAccessAsTrainer=$this->User_model->getUserAccessAsTrainer($_SESSION['UserId']);
            unset($classroomData2);
            if(!empty($UserAccessAsTrainer)){
                foreach ($UserAccessAsTrainer as $u) {
                   $classroomData1 = $this->Classroom_model->get_classroom_by_access($u['test_module_id'],$u['programe_id'],$u['category_id'],$u['batch_id'],$u['center_id'],$params);
                   if(!empty($classroomData1)){
                    array_push($classroomData2, $classroomData1);
                   }           
                }
            }              
        }else{
            $classroomData2 = $this->Classroom_model->get_all_classroom($_SESSION['roleName'],$userBranch,$params);
            $data['all_test_module']= $this->Test_module_model->get_all_test_module_active();
            $data['all_batches'] = $this->Batch_master_model->get_all_batch_active();
            $data['all_branch'] = $this->Center_location_model->getAcademyBranch($_SESSION['roleName'],$userBranch);                
        }
        $data['all_classroom']= $this->auto_getclassroomlist($classroomData2);
        return $data;

    }
    function auto_getclassroomlist($classroomData2=[])
    {
        $class = [];
        foreach($classroomData2 as $key => $cd){
            $classroomData2[$key]['category_name']=null;
            $pattern = "/,/i";
            $isMultipeCategory = preg_match($pattern, $cd['category_id']);
            if($isMultipeCategory){
                $cat_arr = explode(',', $cd['category_id']);
                $cat_arr_count = count($cat_arr);
                for ($i=0; $i < $cat_arr_count; $i++) { 
                    $categoryname ='';
                    $get_category_name = $this->Category_master_model->get_category_name($cat_arr[$i]);
                    if(is_array($get_category_name)){
                    foreach ($get_category_name as $key2 => $m) {                
                        // $classroomData2[$key]['Category'][$key2].=$m.', ';    
                        //$classroomData2[$key]['category_name'].=$m.', '; 
                        $categoryname .=$m.', ';      
                    } 
                }                   
                }
            }else{
                $categoryname ='';
                $get_category_name = $this->Category_master_model->get_category_name($cd['category_id']);
                foreach ($get_category_name as $key2 => $m) {                
                    // $classroomData2[$key]['Category'][$key2]=$m;  
                    //$classroomData2[$key]['category_name']=$m; 
                    $categoryname .=$m.', ';                        
                }
            }
            $classroomData2[$key]['category_name']=$categoryname;
            
        }
        
            // echo '<pre>';
            // print_r($classroomData2);
            return $classroomData2;
    }
    function auto_check_already_exist_schedule($id)
    {
        return  $this->Online_class_schedule_model->get_all_schedule_count($id);
    }

    function edit($id){   
        
        //access control start
        $data = [];
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends
        $userBranch=[];
        $params=[];
        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }

        $data['title'] = 'Edit schedule';
        $data['online_class_schedule'] = $this->Online_class_schedule_model->get_schedule($id);
        $classroom_id = $data['online_class_schedule']['classroom_id'];

        if(isset($data['online_class_schedule']['id'])){

            $this->load->library('form_validation');
            $this->form_validation->set_rules('classroom_id','Classroom','required'); 
            $this->form_validation->set_rules('class_duration','Class duration','required|trim|integer|min_length[2]|max_length[3]');  
            $this->form_validation->set_rules('topic','Class Topic','required|trim|max_length[50]');
            $class_duration="+".$this->input->post('class_duration');
            $prev_dateTime = $this->input->post('prev_dateTime');
            if($prev_dateTime==''){
                $this->form_validation->set_rules('dateTime','Date Time','required|min_length[16]|max_length[19]');
            }     
		
			if($this->form_validation->run()){ 
                $dateTime = $this->input->post('dateTime');
                if($dateTime!=''){
                    //check alreary added schedule is there or not in this class   
                    $thisdate = date('d-m-Y', strtotime($this->input->post('dateTime')));
                    $dateTime = $this->input->post('dateTime');
                    $date = new DateTime($dateTime);
                    $dateTime = $date->format('d-m-Y G:i:00');            
                    $nameOfDay = date('D', strtotime($this->input->post('dateTime')));
                    $dateTimeStr = strtotime($dateTime);
                    $enddate_end= date('d-m-Y G:i:s', strtotime($class_duration.' minutes', strtotime($dateTime)));
                    $strdate_end = strtotime($enddate_end);
 
                        $params = array(
                            'classroom_id'=>$this->input->post('classroom_id'),                       
                            'dateTime' => $dateTime,
                            'strdate_end' => $strdate_end,
                            'strdate' =>  $dateTimeStr,
                            'dayname' => $nameOfDay, 
                            'till_date' => $this->input->post('till_date'),
                            'topic' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('topic')))),
                            'class_duration' => $this->input->post('class_duration'),
                            'conf_URL' => $this->input->post('conf_URL'),
                            'active'=> $this->input->post('active') ? $this->input->post('active') : 0,
                            'by_user'=> $_SESSION['UserId'],
                        );                    
                   
                }
                else{
                    $enddate_end= date('d-m-Y G:i:s', strtotime($class_duration.' minutes', strtotime($prev_dateTime)));
                    $strdate_end = strtotime($enddate_end);
                    $params = array(
                        'classroom_id'=>$this->input->post('classroom_id'), 
                        'dateTime'=>$prev_dateTime,   
                        'strdate_end' => $strdate_end,                      
                        'topic' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ",$this->input->post('topic')))),
                        'till_date' => $this->input->post('till_date'),
                        'class_duration' => $this->input->post('class_duration'),
                        'conf_URL' => $this->input->post('conf_URL'),
                        'active' => $this->input->post('active') ? $this->input->post('active') : 0,
                        'by_user' => $_SESSION['UserId'],
                    );
                }
                $idh = $this->Online_class_schedule_model->update_schedule($id,$params);
                if($idh){                   
                    $this->session->set_flashdata('flsh_msg', UPDATE_MSG);
                    redirect('adminController/online_class_schedule/index/'.$classroom_id);
                }else{
                    $this->session->set_flashdata('flsh_msg', UPDATE_FAILED_MSG);           
                    redirect('adminController/online_class_schedule/edit/'.$id);
                }

            }
            // else{
               
            // $classroomData2 = [];
            // $pattern = "/Trainer/i";
            // $isTrainer = preg_match($pattern, $_SESSION['roleName']);
            // if($isTrainer){
            //     $UserAccessAsTrainer=$this->User_model->getUserAccessAsTrainer($_SESSION['UserId']);
            //     if(!empty($UserAccessAsTrainer)){
            //         foreach ($UserAccessAsTrainer as $u) {
            //            $classroomData1 = $this->Classroom_model->get_classroom_by_access($u['test_module_id'],$u['programe_id'],$u['category_id'],$u['batch_id'],$u['center_id'],$params);
            //            if(!empty($classroomData1)){
            //             array_push($classroomData2, $classroomData1);
            //            }           
            //         }
            //     }else{
            //         $classroomData2 = [];
            //     }                
            // }else{
            //     $classroomData2 = $this->Classroom_model->get_all_classroom($_SESSION['roleName'],$userBranch,$params);
            //     $data['all_test_module']= $this->Test_module_model->get_all_test_module_active();
            //     $data['all_batches'] = $this->Batch_master_model->get_all_batch_active();
            //     $data['all_branch'] = $this->Center_location_model->getAcademyBranch($_SESSION['roleName'],$userBranch);                
            // }
            // foreach($classroomData2 as $key => $cd){
            //     $pattern = "/,/i";
            //     $isMultipeCategory = preg_match($pattern, $cd['category_id']);
            //     if($isMultipeCategory){
            //         $cat_arr = explode(',', $cd['category_id']);
            //         $cat_arr_count = count($cat_arr);
            //         for ($i=0; $i < $cat_arr_count; $i++) { 
            //             $get_category_name = $this->Category_master_model->get_category_name($cat_arr[$i]);
            //             foreach ($get_category_name as $key2 => $m) {                
            //                 $classroomData2[$key]['Category'][$key2].=$m.', ';                       
            //             }                    
            //         }
            //     }else{
            //         $get_category_name = $this->Category_master_model->get_category_name($cd['category_id']);
            //         foreach ($get_category_name as $key2 => $m) {                
            //             $classroomData2[$key]['Category'][$key2]=$m;                       
            //         }
            //     }
            // }   
                 
            // $data['all_classroom']=$classroomData2;            
            // $data['classroom_id']=$id;
            // $data['all_batches'] = $this->Batch_master_model->get_all_batch_active();
            // $data['all_branch'] = $this->Center_location_model->getAcademyBranch($_SESSION['roleName'],$userBranch);
            // $data['_view'] = 'online_class_schedule/edit';
            // $this->load->view('layouts/main',$data);
            // }
            $dropvalues = $this->auto_fetch_dropvalues_by_trainer_access($params,$userBranch);
            $data['title'] = 'Edit schedule';
            $data['classroom_id']=$id;
            $data['_view'] = 'online_class_schedule/edit';
            $this->load->view('layouts/main',array_merge($data,$dropvalues));
        }
        else
            show_error(ITEM_NOT_EXIST);
    }
    
    /*function remove($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        $online_class_schedule = $this->Online_class_schedule_model->get_schedule($id);
        
        if(isset($online_class_schedule['id'])){
            $del = $this->Online_class_schedule_model->delete_schedule($id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            if($del){
                redirect('adminController/online_class_schedule/index');
            }else{
                redirect('adminController/online_class_schedule/index');
            }            
        }
        else
            show_error(ITEM_NOT_EXIST);
    }*/   
}
