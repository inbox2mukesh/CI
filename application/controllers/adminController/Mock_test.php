<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Mock_test extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}        
        $this->load->model('Mock_test_model');
        $this->load->model('Student_model');
        $this->load->model('Test_module_model');  
        $this->load->model('Programe_master_model'); 
        $this->load->model('Center_location_model');
        $this->load->model('Student_service_masters_model');
        $this->load->model('Student_journey_model'); 
        $this->load->model('Student_package_model');                   
    }

    function ViewUploadedReport_($id,$test_module_id=null){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends         
        if($test_module_id==IELTS_ID) {
           $data['title'] = 'Mock Test Report- IELTS';
        }elseif($test_module_id==IELTS_CD_ID) {
           $data['title'] = 'Mock Test Report- CD-IELTS';
        }elseif($test_module_id==PTE_ID) {
           $data['title'] = 'Mock Test Report- PTE';
        }elseif($test_module_id==TOEFL_ID) {
           $data['title'] = 'Mock Test Report- TOEFL';
        }else{
            $data['title'] = '';
        } 
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/mock_test/ViewUploadedReport_/'.$id.'/'.$test_module_id.'?');
        if($test_module_id==IELTS_ID){
            $config['total_rows'] = $this->Mock_test_model->get_ielts_report_count($id);
        }elseif($test_module_id==IELTS_CD_ID) {
           $config['total_rows'] = $this->Mock_test_model->get_ielts_report_count($id);
        }elseif($test_module_id==PTE_ID) {
           $config['total_rows'] = $this->Mock_test_model->get_pte_report_count($id);
        }elseif($test_module_id==TOEFL_ID) {
           $config['total_rows'] = $this->Mock_test_model->get_toefl_report_count($id);
        }else{
            $config['total_rows'] = 0;
        } 
        $this->pagination->initialize($config);
        if($test_module_id==IELTS_ID) {
            $data['report'] = $this->Mock_test_model->get_ielts_report($id, $params);
        }elseif($test_module_id==IELTS_CD_ID) {
           $data['report'] = $this->Mock_test_model->get_ielts_report($id, $params);
        }elseif($test_module_id==PTE_ID) {
           $data['report'] = $this->Mock_test_model->get_pte_report($id, $params);
        }elseif($test_module_id==TOEFL_ID) {
           $data['report'] = $this->Mock_test_model->get_toefl_report($id, $params);
        }else{
            $data['report'] = [];
        }   
        
        if($test_module_id==IELTS_ID or $test_module_id==IELTS_CD_ID){
            $data['_view'] = 'mock_test/ViewUploadedReport_ielts';
        }elseif($test_module_id==PTE_ID) {
           $data['_view'] = 'mock_test/ViewUploadedReport_pte';
        }elseif($test_module_id==TOEFL_ID) {
           $data['_view'] = 'mock_test/ViewUploadedReport_toefl';
        }else{
            $data['_view'] = '';
        }
        $this->load->view('layouts/main',$data);

    }

    function edit_ielts_report_($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Edit IELTS Report';
        $data['reportRow'] = $this->Mock_test_model->get_ieltsReport_row($id);
        $uploadedcsvrow = $data['reportRow']['CSVgroupId'];
        if(isset($data['reportRow']['id']))
        {
            $this->load->library('form_validation');           
            $this->form_validation->set_rules('listening','listening','required');  
            if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(                                    
                    'Test_Type' => $this->input->post('Test_Type'),
                    'Centre_Number' => $this->input->post('Centre_Number'),                    
                    'Candidate_Number' => $this->input->post('Candidate_Number'),
                    'Candidate_ID' => $this->input->post('Candidate_ID'),
                    'Date_of_Test' => $this->input->post('Date_of_Test'),
                    'Date_of_Report' => $this->input->post('Date_of_Report'),
                    'listening' => $this->input->post('listening'),
                    'reading' => $this->input->post('reading'),
                    'writing' => $this->input->post('writing'),
                    'speaking' => $this->input->post('speaking'),
                    'oa' => $this->input->post('oa'),
                ); 
                $test_module_id=IELTS_ID; 
                $idd = $this->Mock_test_model->update_ielts_reportRow($id,$params);
                if($idd){
                    
                    //activity update start                            
                    $activity_name= "Edited IELTS Report Score";
                    unset($data['reportRow']['id'],$data['reportRow']['created'],$data['reportRow']['modified'],$data['reportRow']['CSVgroupId']);//unset extras from array              
                            
                    $uaID = 'Edited_IELTS_Report_Score'.$idd;
                    $diff1 =  json_encode(array_diff($data['reportRow'], $params));//old
                    $diff2 =  json_encode(array_diff($params,$data['reportRow']));//new
                   // $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                    $description = $diff1.UA_SEP.$diff2;
                    $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                    if($diff1!=$diff2){
                        $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                    }                                        
                    //activity update end

                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                   redirect('adminController/mock_test/ViewUploadedReport_/'.$uploadedcsvrow.'/'.$test_module_id);
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/mock_test/edit_ielts_report_/'.$id);
                }
                
            }else{     

                $data['_view'] = 'mock_test/edit_ielts_report';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

    function edit_pte_report_($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Edit PTE Report';
        $data['reportRow'] = $this->Mock_test_model->get_pteReport_row($id);
        $uploadedcsvrow = $data['reportRow']['CSVgroupId'];
        if(isset($data['reportRow']['id']))
        {
            $this->load->library('form_validation');           
            $this->form_validation->set_rules('listening','listening','required');  
            if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(                                    
                    'Test_Taker_ID' => $this->input->post('Test_Taker_ID'),
                    'Registration_ID' => $this->input->post('Registration_ID'),                    
                    'Test_Centre_ID' => $this->input->post('Test_Centre_ID'),
                    'Date_of_Test' => $this->input->post('Date_of_Test'),
                    'Date_of_Report' => $this->input->post('Date_of_Report'),
                    'oa' => $this->input->post('oa'),
                    'listening' => $this->input->post('listening'),
                    'reading' => $this->input->post('reading'),
                    'writing' => $this->input->post('writing'),
                    'speaking' => $this->input->post('speaking'),
                    'gr' => $this->input->post('gr'),
                    'of' => $this->input->post('of'),
                    'pr' => $this->input->post('pr'),
                    'sp' => $this->input->post('sp'),
                    'vo' => $this->input->post('vo'),
                    'wd' => $this->input->post('wd'),
                ); 
                $test_module_id=PTE_ID; 
                $idd = $this->Mock_test_model->update_pte_reportRow($id,$params);
                if($idd){
                     //activity update start                            
                     $activity_name= "Edited PTE Report Score";
                     unset($data['reportRow']['id'],$data['reportRow']['created'],$data['reportRow']['modified'],$data['reportRow']['CSVgroupId']);//unset extras from array              
                             
                     $uaID = 'Edited_PTE_Report_Score'.$idd;
                     $diff1 =  json_encode(array_diff($data['reportRow'], $params));//old
                     $diff2 =  json_encode(array_diff($params,$data['reportRow']));//new
                    // $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                     $description = $diff1.UA_SEP.$diff2;
                     $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                     if($diff1!=$diff2){
                         $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                     }                                        
                     //activity update end
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/mock_test/ViewUploadedReport_/'.$uploadedcsvrow.'/'.$test_module_id);
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/mock_test/edit_pte_report_/'.$id);
                }
                
            }else{     

                $data['_view'] = 'mock_test/edit_pte_report';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

    function edit_toefl_report_($id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $data['title'] = 'Edit TOEFL Report';
        $data['reportRow'] = $this->Mock_test_model->get_toeflReport_row($id);
        $uploadedrowid = $data['reportRow']['CSVgroupId'];
        if(isset($data['reportRow']['id']))
        {
            $this->load->library('form_validation');           
            $this->form_validation->set_rules('listening','listening','required');  
            if($this->form_validation->run())     
            {   
                $by_user=$_SESSION['UserId'];
                $params = array(                                    
                    'Test_Taker_ID' => $this->input->post('Test_Taker_ID'),
                    'Registration_ID' => $this->input->post('Registration_ID'),                    
                    'Test_Centre_ID' => $this->input->post('Test_Centre_ID'),
                    'Date_of_Test' => $this->input->post('Date_of_Test'),
                    'Date_of_Report' => $this->input->post('Date_of_Report'),
                    'oa' => $this->input->post('oa'),
                    'listening' => $this->input->post('listening'),
                    'reading' => $this->input->post('reading'),
                    'writing' => $this->input->post('writing'),
                    'speaking' => $this->input->post('speaking'),                    
                ); 
                $test_module_id=TOEFL_ID; 
                $idd = $this->Mock_test_model->update_toefl_reportRow($id,$params);
                if($idd){
                     //activity update start                            
                     $activity_name= "Edited TOEFL Report Score";
                     unset($data['reportRow']['id'],$data['reportRow']['created'],$data['reportRow']['modified'],$data['reportRow']['CSVgroupId']);//unset extras from array              
                             
                     $uaID = 'Edited_TOEFL_Report_Score'.$idd;
                     $diff1 =  json_encode(array_diff($data['reportRow'], $params));//old
                     $diff2 =  json_encode(array_diff($params,$data['reportRow']));//new
                    // $description = str_replace(UA_FIND, UA_REPLACE, $diff1.UA_SEP.$diff2);
                     $description = $diff1.UA_SEP.$diff2;
                     $description = '<a href="javascript:void(0);" class="'.$uaID.'">'.$description.'</a>';
                     if($diff1!=$diff2){
                         $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                     }                                        
                     //activity update end
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/mock_test/ViewUploadedReport_/'.$uploadedrowid.'/'.$test_module_id);
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/mock_test/edit_toefl_report_/'.$id);
                }
                
            }else{     

                $data['_view'] = 'mock_test/edit_toefl_report';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

    /*function get_mockTest_list(){

        $response =  $this->Mock_test_model->get_mockTest_list();
        echo json_encode($response);      
    } 

    function ajax_get_time_slot(){

        $id = $this->input->post('id', true);
        $response = $this->Mock_test_model->get_time_slot($id);        
        if($response){    
            header('Content-Type: application/json');           
            echo json_encode($response);
        }else{
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }*/
    

    function upload_mock_test(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}     
        //access control ends    
        $data['title'] = 'Upload Mock test report(.CSV)';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('test_module_id','Test','required');
        $this->form_validation->set_rules('programe_id','program','required');
        $this->form_validation->set_rules('title','CSV title','required|trim');   
        // $this->form_validation->set_rules('active','active','required');
        $params = [];
        $by_user=$_SESSION['UserId'];
        
        if($this->form_validation->run())    
        { 
            $test_module_id = $this->input->post('test_module_id');
            $programe_id = $this->input->post('programe_id');
            $test_module_name= $this->Test_module_model->getTestName($test_module_id);         
            $programe_name= $this->Programe_master_model->getProgramName($programe_id);         
            $activity_name_title= "Mock test report for ".$test_module_name['test_module_name'].' '.$programe_name['programe_name'].' uploaded' ;
            $title = $this->input->post('title');
            $active = $this->input->post('active');
            $this->db->trans_start();
            $params1 = array(
                'test_module_id'=>$test_module_id,
                'programe_id'=> $programe_id,
                'title'=>$title,
                'active'=>1,
                'by_user'=> $by_user
            );
            $id = $this->Mock_test_model->saveCSV($params1);

            $file = $_FILES['csvFile']['tmp_name'];
            $handle = fopen($file, "r");
            $errorcnt= 0;
            $c =0;
            $candidate_id= [];
            $params2 = [];
            $errormsg = '';//'Invalid Score is added or Repeative Candidate IDs';
            if($test_module_id==IELTS_ID or $test_module_id==IELTS_CD_ID){
                
                
                while(($filesop = fgetcsv($handle, 1000, ",")) !== false){
                
                    $Test_Type          = $filesop[0];
                    $Centre_Number      = $filesop[1];
                    $Candidate_Number   = $filesop[2];//Booking Id
                    $Candidate_ID       = $filesop[3];//UID
                    $Date_of_Test       = $filesop[4];
                    $Date_of_Report     = $filesop[5];
                    $listening          = $filesop[6];
                    $reading            = $filesop[7];
                    $writing            = $filesop[8];
                    $speaking           = $filesop[9];
                    $oa                 = $filesop[10];
                    if(!in_array($Candidate_ID,$candidate_id))
                    {
                        $candidate_id[]=$Candidate_ID;                        
                        
                        if($this->validate_IELTS_score($listening) != 1 || $this->validate_IELTS_score($reading) != 1 || $this->validate_IELTS_score($writing) != 1 || $this->validate_IELTS_score($speaking) != 1)
                        {
                            $errorcnt++;
                            $errormsg ='Invalid Score';                             
                        }
                    }
                    else{
                        $errorcnt++;
                        $errormsg ='Repeative Candidate IDs.'; 
                    }
                    if($Candidate_Number !='')
                    {
                        $params2[] = [
                            'CSVgroupId'        => $id,
                            'Test_Type'         => $Test_Type,
                            'Centre_Number'     => $Centre_Number,
                            'Candidate_Number'  => $Candidate_Number,
                            'Candidate_ID'      => $Candidate_ID,
                            'Date_of_Test'      => $Date_of_Test,
                            'Date_of_Report'    => $Date_of_Report,
                            'listening'         => $listening,
                            'reading'           => $reading,
                            'writing'           => $writing,
                            'speaking'          => $speaking,
                            'oa'                => $oa
                        ];

                    }
                }
                if($errorcnt == 0)
                {
                    $idd=$this->Mock_test_model->saveCSVrecords_ielts($params2);
                }

            }else if($test_module_id==PTE_ID){

                while(($filesop = fgetcsv($handle, 1000, ",")) !== false){
                    $Test_Taker_ID = $filesop[0];
                    $Registration_ID = $filesop[1];
                    $Test_Centre_ID = $filesop[2];
                    $Date_of_Test = $filesop[3];
                    $Date_of_Report = $filesop[4];
                    $oa = $filesop[5];
                    $listening = $filesop[6];
                    $reading = $filesop[7];
                    $writing = $filesop[8];
                    $speaking = $filesop[9];
                    $gr = $filesop[10];
                    $of = $filesop[11];
                    $pr = $filesop[12];
                    $sp = $filesop[13];
                    $vo = $filesop[14];
                    $wd = $filesop[15];

                    if(!in_array($Registration_ID,$candidate_id))
                    {
                            $candidate_id[]=$Registration_ID;  
                            if($this->validate_PTE_score($listening) != 2 || $this->validate_PTE_score($reading) != 2 || $this->validate_PTE_score($writing) != 2 || $this->validate_PTE_score($speaking) != 2 || $this->validate_PTE_score($gr)!= 2|| $this->validate_PTE_score($of)!= 2|| $this->validate_PTE_score($pr)!= 2|| $this->validate_PTE_score($sp)!= 2|| $this->validate_PTE_score($vo)!= 2 || $this->validate_PTE_score($wd)!= 2)
                            {
                                $errorcnt++;
                                $errormsg ='Invalid Score';                             
                            }                    
                    }
                    else{
                        $errorcnt++;
                        $errormsg ='Repeative Candidate IDs.'; 
                    }
                    
                   
                    $params2[] = [
                        'CSVgroupId'        => $id,
                        'Test_Taker_ID'     => $Test_Taker_ID,
                        'Registration_ID'   => $Registration_ID,
                        'Test_Centre_ID'    => $Test_Centre_ID,
                        'Date_of_Test'      => $Date_of_Test,
                        'Date_of_Report'    => $Date_of_Report,
                        'oa'                => $oa,
                        'listening'         => $listening,
                        'reading'           => $reading,
                        'writing'           => $writing,
                        'speaking'          => $speaking,
                        'gr'                => $gr,
                        'of'                => $of,
                        'pr'                => $pr,
                        'sp'                => $sp,
                        'vo'                => $vo,
                        'wd'                => $wd,
                    ];
                }
                if($errorcnt == 0)
                {
                    $idd=$this->Mock_test_model->saveCSVrecords_pte($params2);
                }
            }else if($test_module_id==TOEFL_ID){

                while(($filesop = fgetcsv($handle, 1000, ",")) !== false){
                
                    $Test_Taker_ID = $filesop[0];
                    $Registration_ID = $filesop[1];
                    $Test_Centre_ID = $filesop[2];
                    $Date_of_Test = $filesop[3];
                    $Date_of_Report = $filesop[4];
                    $oa = $filesop[5];
                    $listening = $filesop[6];
                    $reading = $filesop[7];
                    $speaking = $filesop[8];
                    $writing = $filesop[9];
                    if(!in_array($Registration_ID,$candidate_id))
                    {
                            $candidate_id[]=$Registration_ID; 
                            if($this->validate_TOEFL_score($listening) != 2 || $this->validate_TOEFL_score($reading) != 2 || $this->validate_TOEFL_score($writing) != 2 || $this->validate_TOEFL_score($speaking) != 2 || $this->validate_TOEFL_score('',$oa)!= 2)
                            {
                                $errorcnt++;
                                $errormsg ='Invalid Score is added'; 
                            }                        
                    }
                    else{
                        $errorcnt++;
                        $errormsg ='Repeative Candidate IDs.'; 
                    }
                    
                    $params2[] = [
                        'CSVgroupId'        => $id,
                        'Test_Taker_ID'     => $Test_Taker_ID,
                        'Registration_ID'   => $Registration_ID,
                        'Test_Centre_ID'    => $Test_Centre_ID,
                        'Date_of_Test'      => $Date_of_Test,
                        'Date_of_Report'    => $Date_of_Report,
                        'oa'                => $oa,
                        'listening'         => $listening,
                        'reading'           => $reading,
                        'writing'           => $writing,
                        'speaking'          => $speaking,                        
                    ];
                    // if($c>0){
                    //     $idd=$this->Mock_test_model->saveCSVrecords_toefl($params2);
                    // }
                    // $c = $c + 1;
                }
                if($errorcnt == 0)
                {
                    $idd=$this->Mock_test_model->saveCSVrecords_toefl($params2);
                }

            }else{
                if($errormsg != '')
                {
                    $this->session->set_flashdata('flsh_msg', '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong>'.$errormsg.'<a href="#" class="alert-link"></a>.
                </div>');
                }
                else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                } 
                redirect('adminController/mock_test/upload_mock_test');
            }

            $this->db->trans_complete();
            if($this->db->trans_status() === FALSE){
                $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                redirect('adminController/mock_test/upload_mock_test');
            }else if($idd){
                 //activity update start              
                 $activity_name= $activity_name_title;
                 $description= ''.json_encode($params).'';
                 $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$_SESSION['UserId']);
                 //activity update end  
                $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                redirect('adminController/mock_test/all_MockTest_Uploaded');
            }else{
                if($errormsg != '')
                {
                    $this->session->set_flashdata('flsh_msg', '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>FAILED:</strong>'.$errormsg.'<a href="#" class="alert-link"></a>.
                </div>');
                }
                else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                }                
                redirect('adminController/mock_test/upload_mock_test');
            }            
        }
        else
        {  
            $data['all_test_module'] = $this->Test_module_model->get_all_test_module_active();
            $data['all_programe_masters'] = $this->Programe_master_model->get_all_programe_masters_active();
            $data['_view'] = 'mock_test/upload_mt_csv';
            $this->load->view('layouts/main',$data);
        }

    }

    function validate_IELTS_score($score=null)
    {
        $pattern_score ="/[^0-9abnABN.]/";
        $pattern_status = "/\b(na)*(NA)*(ab)*(AB)\b/i";
        $validate = 1;
        // echo preg_match($pattern_status,$score);
        if(preg_match($pattern_status,$score) == 0 && preg_match($pattern_score,$score) != 0)
        {
            $validate--;
        }
        elseif($score > 9)
        {
            $validate--;
        }
        return $validate;
    }
    function validate_PTE_score($score=null)
    {
        $pattern_score ="/[^0-9abnABN]/";
        $pattern_status = "/\b(na)*(NA)*(ab)*(AB)\b/i";
        $validate = 2;
        // echo preg_match($pattern_status,$score);
        if(preg_match($pattern_status,$score) == 0 && preg_match($pattern_score,$score) != 0)
        {
            $validate--;
        }
        elseif($score > 90)
        {
            $validate--;
        }
        return $validate;
    }
    function validate_TOEFL_score($score=null,$overall=null)
    {
        $pattern_score ="/[^0-9abnABN]/";
        $pattern_status = "/\b(na)*(NA)*(ab)*(AB)\b/i";
        $validate = 2;
        // echo preg_match($pattern_status,$score);
        if(preg_match($pattern_status,$score) == 0 && preg_match($pattern_score,$score) != 0)
        {
            $validate--;
        }
        elseif($score > 30 )
        {
            $validate--;
        }
        elseif($overall!=null && $overall > 120 )
        {
            $validate--;
        }
        return $validate;
    }

    function all_MockTest_Uploaded(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/mock_test/all_MockTest_Uploaded?');
        $config['total_rows'] = $this->Mock_test_model->get_all_mtcsv_count();
        $this->pagination->initialize($config);
        $data['title'] = 'Mock test report CSV';
        $data['all_rt_csv'] = $this->Mock_test_model->get_all_mt_csv($params);
        $data['_view'] = 'mock_test/all_MockTest_Uploaded';
        $this->load->view('layouts/main',$data);
    }

    function remove_mock_test_report_CSV_($id,$test_module_id){

         //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $mock_test_report = $this->Mock_test_model->get_mock_test_report($id);
        if(isset($mock_test_report['id']))
        {
            $del = $this->Mock_test_model->delete_mock_test_report($id,$test_module_id);
            $this->session->set_flashdata('flsh_msg', DEL_MSG);
            if($del){
                redirect('adminController/mock_test/all_MockTest_Uploaded/'.$mock_test_report['id']);
            }else{
                redirect('adminController/mock_test/all_MockTest_Uploaded');
            }            
        }
        else
            show_error(ITEM_NOT_EXIST);

    } 

    

    
    

    /*function search_mock_test(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        
        //access control ends
        $data['all_testModule'] = $this->Mock_test_model->get_all_testModule();

        $data['title'] = 'Search Mock Test schedule';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('from_date','From Date','required|trim');
        $this->form_validation->set_rules('to_date','To Date','required|trim');
        
        if($this->form_validation->run())     
        { 
            $params = array(
                'test_module_id' => $this->input->post('test_module_id')? $this->input->post('test_module_id') : NULL,
                'programe_id' => $this->input->post('programe_id')? $this->input->post('programe_id') : NULL,
                'center_id' => $this->input->post('center_id')? $this->input->post('center_id') : NULL,
                'from_date'=>  $this->input->post('from_date'),                
                'to_date'=> $this->input->post('to_date'),
            );            
            $data['searched_data'] = $this->Mock_test_model->search_mock_test_schedule($params);

                $data['all_test_module'] = $this->Test_module_model->get_all_test_module_enqActive();
                $data['all_programe_masters'] = $this->Programe_master_model->get_all_programe_masters_active();
                $data['all_branch'] = $this->Center_location_model->get_all_branch();
                if(!empty($data['searched_data'])){
                    $this->session->set_flashdata('flsh_msg', SEARCH_MSG);
                }else{
                    $this->session->set_flashdata('flsh_msg', SEARCH_MSG_404);
                }
                $data['_view'] = 'mock_test/search_schedule';
                $this->load->view('layouts/main',$data);
        }else{

           $data['all_test_module'] = $this->Test_module_model->get_all_test_module_enqActive();
           $data['all_programe_masters'] = $this->Programe_master_model->get_all_programe_masters_active();
           $data['all_branch'] = $this->Center_location_model->get_all_branch();
           $data['_view'] = 'mock_test/search_schedule';
           $this->load->view('layouts/main',$data);
        }
    }*/      
    
}
