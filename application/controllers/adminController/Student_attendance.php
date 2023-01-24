<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Student_attendance extends MY_Controller{
    
    function __construct(){

        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}
        $this->load->model('Test_module_model');   
        $this->load->model('Programe_master_model'); 
        $this->load->model('Batch_master_model');
        $this->load->model('Classroom_model');
        $this->load->model('Category_master_model');
        $this->load->model('Center_location_model');  
        $this->load->model('User_model');
        $this->load->model('Student_model');  
        $this->load->model('Student_package_model');
        $this->load->model('Student_attendance_model');            
    } 
    function auto_sync_attendance(){
        
        $today = date('d-m-Y');
        $strDate = strtotime($today);
        $backupAttendance = $this->Student_attendance_model->backupAttendance($strDate);
        redirect('adminController/student_attendance/attendance_report');
    }

    function attendance_report(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        $data['si'] = 0;
        //access control ends

        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }        
        $data['title'] = 'Attendance Report';
        $this->load->library('form_validation');
        //b1 
        $UID = $this->input->post('UID');
        $byMonth2 = $this->input->post('byMonth2');
        //b2
        $classroom_id = $this->input->post('classroom_id');        
        $byMonth1 = $this->input->post('byMonth1');
        $allPresent1 = $this->input->post('allPresent1');        
        $hiddenField = $this->input->post('hiddenField');
        $this->form_validation->set_rules('hiddenField','hidden Field','required');        
        if($this->form_validation->run()){
            $classroomData2 = [];
            $pattern = "/Trainer/i";
            $isTrainer = preg_match($pattern, $_SESSION['roleName']);
            if($isTrainer){
                $UserAccessAsTrainer=$this->User_model->getUserAccessAsTrainer($_SESSION['UserId']);
                if(!empty($UserAccessAsTrainer)){
                    foreach ($UserAccessAsTrainer as $u) {
                       $classroomData1 = $this->Classroom_model->get_classroom_by_access($u['test_module_id'],$u['programe_id'],$u['category_id'],$u['batch_id'],$u['center_id'],$params);
                       if(!empty($classroomData1)){
                        array_push($classroomData2, $classroomData1);
                       }           
                    }
                }else{
                    $classroomData2 = [];
                }                
            }else{
                $classroomData2 = $this->Classroom_model->get_all_classroom($_SESSION['roleName'],$userBranch,$params);                
            } 
            //$data['all_trainer']=$this->User_model->get_all_trainer_active($_SESSION['roleName'],$userBranch);
            foreach($classroomData2 as $key => $cd){
                $pattern = "/,/i";
                $isMultipeCategory = preg_match($pattern, $cd['category_id']);
                if($isMultipeCategory){
                    $cat_arr = explode(',', $cd['category_id']);
                    $cat_arr_count = count($cat_arr);
                    for ($i=0; $i < $cat_arr_count; $i++) { 
                        $get_category_name = $this->Category_master_model->get_category_name($cat_arr[$i]);
                        foreach ($get_category_name as $key2 => $m) {                
                            $classroomData2[$key]['Category'][$key2].=$m.', ';                       
                        }                    
                    }
                }else{
                    $get_category_name = $this->Category_master_model->get_category_name($cd['category_id']);
                    foreach ($get_category_name as $key2 => $m) {                
                        $classroomData2[$key]['Category'][$key2]=$m;                       
                    }
                }
            }            
            $data['all_classroom']=$classroomData2; 

            $by_user=$_SESSION['UserId']; 

                if($UID){
                    $data['attendanceData'] = $this->Student_attendance_model->getStudentByUID($UID,$byMonth2,$userBranch,$_SESSION['roleName']);
                }else if( (!$byMonth1 and !$allPresent1) and ($classroom_id) ){  
                    //echo 'BranchCoursePgmBatch';die;                
                    $data['attendanceData'] = $this->Student_attendance_model->getStudentByClassroom($classroom_id,$userBranch,$_SESSION['roleName']);
                }else if($byMonth1 and !$allPresent1){  
             //echo 'byMonth1';die;                
                    $data['attendanceData'] = $this->Student_attendance_model->getStudentByMonth($classroom_id,$byMonth1,$userBranch,$_SESSION['roleName']);
                // echo 'byMonth1';die;  
                }else if($allPresent1 and !$byMonth1){
                    //echo 'allPresent1';die;                 
                    $data['attendanceData'] = $this->Student_attendance_model->getStudentByPresenseDay($classroom_id,$allPresent1,$userBranch,$_SESSION['roleName']);
                }else{
                    $data['attendanceData'] = [];
                }

                if(!empty($data['attendanceData'])){
                    $this->session->set_flashdata('flsh_msg', SEARCH_MSG); 
                    $data['_view'] = 'student_attendance/attendance_report';
                    $this->load->view('layouts/main',$data); 
                }else{

                    $this->session->set_flashdata('flsh_msg', SEARCH_MSG_404);
                    $data['_view'] = 'student_attendance/attendance_report';
                    $this->load->view('layouts/main',$data);
                }

        }else{
            $classroomData2 = [];
            $pattern = "/Trainer/i";
            $isTrainer = preg_match($pattern, $_SESSION['roleName']);
            if($isTrainer){
                $UserAccessAsTrainer=$this->User_model->getUserAccessAsTrainer($_SESSION['UserId']);
                if(!empty($UserAccessAsTrainer)){
                    foreach ($UserAccessAsTrainer as $u) {
                       $classroomData1 = $this->Classroom_model->get_classroom_by_access($u['test_module_id'],$u['programe_id'],$u['category_id'],$u['batch_id'],$u['center_id'],$params);
                       if(!empty($classroomData1)){
                        array_push($classroomData2, $classroomData1);
                       }           
                    }
                }else{
                    $classroomData2 = [];
                }                
            }else{
                $classroomData2 = $this->Classroom_model->get_all_classroom($_SESSION['roleName'],$userBranch,$params);                
            } 
            //$data['all_trainer']=$this->User_model->get_all_trainer_active($_SESSION['roleName'],$userBranch);
            foreach($classroomData2 as $key => $cd){
                $pattern = "/,/i";
                $isMultipeCategory = preg_match($pattern, $cd['category_id']);
                if($isMultipeCategory){
                    $cat_arr = explode(',', $cd['category_id']);
                    $cat_arr_count = count($cat_arr);
                    for ($i=0; $i < $cat_arr_count; $i++) { 
                        $get_category_name = $this->Category_master_model->get_category_name($cat_arr[$i]);
                        foreach ($get_category_name as $key2 => $m) {                
                            $classroomData2[$key]['Category'][$key2].=$m.', ';                       
                        }                    
                    }
                }else{
                    $get_category_name = $this->Category_master_model->get_category_name($cd['category_id']);
                    foreach ($get_category_name as $key2 => $m) {                
                        $classroomData2[$key]['Category'][$key2]=$m;                       
                    }
                }
            }            
            $data['all_classroom']=$classroomData2;
            $data['attendanceData'] = [];            
            $data['_view'] = 'student_attendance/attendance_report';
            $this->load->view('layouts/main',$data);
        }

    }           

    function download_csv_($student_id,$pack_type,$classroom_id=null){

        $data['title'] = 'Attendance CSV Data';         
        $this->load->library("excel");
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns = array("Date", "Time", "Attendance", "Classroom", "Marked By", "Marked On");
        $column = 0;
        foreach($table_columns as $field)
        {
           $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
           $column++;
        }
        $studentData= $this->Student_model->getstudentInfo($student_id);
        $s = $studentData['fname'].' '.$studentData['lname'].'- '.$studentData['UID'];          
        $data['AttendanceHistory'] =$this->Student_attendance_model->getAttendanceHistory($student_id,$pack_type,$classroom_id);
        $excel_row = 2;
        foreach($data['AttendanceHistory'] as $c){

                    if($c['morning']==1){
                        $presence_m='P';
                        $color_m="green";                        
                    }else if($c['morning']==0){
                        $presence_m='AB';
                        $color_m="red";
                    }else{
                        $presence_m=NA;
                        $color_m="gray";
                    }

                    if($c['evening']==1){
                        $presence_e='P';
                        $color_e="green";                        
                    }else if($c['evening']==0){
                        $presence_e='AB';
                        $color_e="red";
                    }else{
                        $presence_e=NA;
                        $color_e="gray";
                    }
                    $by_user = $c['ufname'].' '.$c['ulname'];
                    if($c['ufname'] !="")
                    {
                        $by_user = $c['ufname'].' '.$c['ulname'];

                    }
                    else {
                        $by_user = "Self";
                    }
                    $date=date_create($c['date']);
                    $att_date = date_format($date,"M d, Y");
                      
           $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $att_date);
           $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $c['time']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $presence_m);          
           $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $c['classroom_name']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $by_user);
           $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $c['created']);
           $excel_row++;
          }
          $fileVame= $s.'-Attendance-History'.'.xls';
          $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename='.$fileVame);
          $object_writer->save('php://output');
    }

    function download_csv_ByMonth_($student_id,$pack_type,$date,$classroom_id){

        $data['title'] = 'Attendance CSV Data By Month';         
        $this->load->library("excel");
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns = array("Date", "Time", "Attendance", "Classroom", "Marked By", "Marked On");
        $column = 0;
        foreach($table_columns as $field)
        {
           $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
           $column++;
        }
        $studentData= $this->Student_model->getstudentInfo($student_id);
        $s = $studentData['fname'].' '.$studentData['lname'].'- '.$studentData['UID'];          
        $data['AttendanceHistory'] =$this->Student_attendance_model->getAttendanceHistoryByMonth($student_id,$pack_type,$date,$classroom_id);
        $excel_row = 2;
        foreach($data['AttendanceHistory'] as $c){

                    if($c['morning']==1){
                        $presence_m='P';
                        $color_m="green";                        
                    }else if($c['morning']==0){
                        $presence_m='AB';
                        $color_m="red";
                    }else{
                        $presence_m=NA;
                        $color_m="gray";
                    }

                    if($c['evening']==1){
                        $presence_e='P';
                        $color_e="green";                        
                    }else if($c['evening']==0){
                        $presence_e='AB';
                        $color_e="red";
                    }else{
                        $presence_e=NA;
                        $color_e="gray";
                    }
                    $by_user = $c['ufname'].' '.$c['ulname'];
                    if($c['ufname'] !="")
                    {
                        $by_user = $c['ufname'].' '.$c['ulname'];

                    }
                    else {
                        $by_user = "Self";
                    }
                    $date=date_create($c['date']);
                    $att_date = date_format($date,"M d, Y");
                      
           $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $att_date);
           $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $c['time']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $presence_m);          
           $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $c['classroom_name']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $by_user);
           $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $c['created']);
           $excel_row++;
          }
          $fileVame= $s.'-Attendance-History-ByMonth'.'.xls';
          $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename='.$fileVame);
          $object_writer->save('php://output');
    }

    function download_csv_PresenseDay_($student_id,$pack_type,$strDate,$classroom_id){

        $data['title'] = 'Attendance CSV data by Presense Day';         
        $this->load->library("excel");
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns = array("Date", "Time", "Attendance", "Classroom", "Marked By", "Marked On");
        $column = 0;
        foreach($table_columns as $field)
        {
           $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
           $column++;
        }
        $studentData= $this->Student_model->getstudentInfo($student_id);
        $s = $studentData['fname'].' '.$studentData['lname'].'- '.$studentData['UID'];          
        $data['AttendanceHistory'] =$this->Student_attendance_model->getAttendanceHistoryByPresenseDay($student_id,$pack_type,$strDate,$classroom_id);
        $excel_row = 2;
        foreach($data['AttendanceHistory'] as $c){

                    if($c['morning']==1){
                        $presence_m='P';
                        $color_m="green";                        
                    }else if($c['morning']==0){
                        $presence_m='AB';
                        $color_m="red";
                    }else{
                        $presence_m=NA;
                        $color_m="gray";
                    }

                    if($c['evening']==1){
                        $presence_e='P';
                        $color_e="green";                        
                    }else if($c['evening']==0){
                        $presence_e='AB';
                        $color_e="red";
                    }else{
                        $presence_e=NA;
                        $color_e="gray";
                    }
                    $by_user = $c['ufname'].' '.$c['ulname'];
                    if($c['ufname'] !="")
                    {
                        $by_user = $c['ufname'].' '.$c['ulname'];

                    }
                    else {
                        $by_user = "Self";
                    }
                    $date=date_create($c['date']);
                    $att_date = date_format($date,"M d, Y");
                      
           $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $att_date);
           $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $c['time']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $presence_m);           
           $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $c['classroom_name']);
           $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $by_user);
           $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $c['created']);
           $excel_row++;
          }
          $fileVame= $s.'-Attendance-History-PresenseDay'.'.xls';
          $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename='.$fileVame);
          $object_writer->save('php://output');
    }

    function ajax_getAttendanceHistory(){

        $student_id = $this->input->post('student_id');
        $pack_type = $this->input->post('pack_type');
        $classroom_id = $this->input->post('classroom_id');
        $attendanceHistory=$this->Student_attendance_model->getAttendanceHistory($student_id,$pack_type,$classroom_id);
      
        $studentData= $this->Student_model->getstudentInfo($student_id);
        $s = $studentData['fname'].' '.$studentData['lname'].'- '.$studentData['UID'];
        $x = '<h4 class="text-success">'.$s.'</h4>        
      
        <div class="table-responsive table-cb-none mheight200 mt-10">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>                        
                        <th>Date</th>
                        <th>Time</th>
                        <th>Attendance</th>                        
                        <th>Classroom</th>
                        <th>Marked By</th>
                        <th>Marked On</th>
                    </tr>
                </thead>
                <tbody id="myTable">';
                     
            foreach($attendanceHistory as $c){                    
                    
                    if($c['morning']==1){
                        $presence_m='P';
                        $color_m="green";                        
                    }else if($c['morning']==0){
                        $presence_m='AB';
                        $color_m="red";
                    }else{
                        $presence_m=NA;
                        $color_m="gray";
                    }

                    if($c['evening']==1){
                        $presence_e='P';
                        $color_e="green";                        
                    }else if($c['evening']==0){
                        $presence_e='AB';
                        $color_e="red";
                    }else{
                        $presence_e=NA;
                        $color_e="gray";
                    }

                    $by_user = $c['ufname'].' '.$c['ulname'];
                    if($c['ufname'] == "")
                    {
                       $by_user="Self"; 
                    }
                    $date=date_create($c['date']);
                    $att_date = date_format($date,"M d, Y");
                    
                    $y .= '<tr>                        
                        <td>'.$att_date.'</td>     
                        <td>'.$c['time'].'</td> 
                        <td style="color:'.$color_m.'">'.$presence_m.'</td>                        
                        <td>'.$c['classroom_name'].'</td> 
                        <td>'.$by_user.'</td>
                        <td>'.$c['created'].'</td>
                    </tr>';
            }
                   
        $z = '</tbody></table></div>';
        $resp=$x.$y.$z;
        header('Content-Type: application/json');
        $response = ['msg'=>$resp, 'status'=>'true'];
        echo json_encode($response);
    }

    function ajax_getAttendanceHistoryByMonth(){

        $student_id = $this->input->post('student_id');
        $pack_type = $this->input->post('pack_type');
        $date = $this->input->post('date');
        $classroom_id = $this->input->post('classroom_id');
        $attendanceHistory= $this->Student_attendance_model->getAttendanceHistoryByMonth($student_id,$pack_type,$date,$classroom_id);
        $studentData= $this->Student_model->getstudentInfo($student_id);
        $s = $studentData['fname'].' '.$studentData['lname'].'- '.$studentData['UID'];
        $x = '<h4 class="text-success">'.$s.'</h4>        
        <div class="table-responsive table-cb-none mheight200 mt-10">
        <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>                        
                        <th>Date</th>
                        <th>Time</th>
                        <th>Attendance</th>                       
                        <th>Classroom</th>
                        <th>Marked By</th>
                        <th>Marked On</th>
                    </tr>
                </thead>
                <tbody id="myTable">';
                     
            foreach($attendanceHistory as $c){                    
                    
                    if($c['morning']==1){
                        $presence_m='P';
                        $color_m="green";                        
                    }else if($c['morning']==0){
                        $presence_m='AB';
                        $color_m="red";
                    }else{
                        $presence_m=NA;
                        $color_m="gray";
                    }

                    if($c['evening']==1){
                        $presence_e='P';
                        $color_e="green";                        
                    }else if($c['evening']==0){
                        $presence_e='AB';
                        $color_e="red";
                    }else{
                        $presence_e=NA;
                        $color_e="gray";
                    }

                    $by_user = $c['ufname'].' '.$c['ulname'];
                    if($c['ufname'] == "")
                    {
                       $by_user="Self"; 
                    }
                    $date=date_create($c['date']);
                    $att_date = date_format($date,"M d, Y");
                    
                    $y .= '<tr>                        
                        <td>'.$att_date.'</td>     
                        <td>'.$c['time'].'</td> 
                        <td style="color:'.$color_m.'">'.$presence_m.'</td>
                        <td>'.$c['classroom_name'].'</td> 
                        <td>'.$by_user.'</td>
                        <td>'.$c['created'].'</td>
                    </tr>';
            }
                   
        $z = '</tbody></table></div>';
        $resp=$x.$y.$z;
        header('Content-Type: application/json');
        $response = ['msg'=>$resp, 'status'=>'true'];
        echo json_encode($response);
    }

    function ajax_getAttendanceHistoryByPresenseDay(){

        $student_id = $this->input->post('student_id');
        $pack_type = $this->input->post('pack_type');
        $strDate = $this->input->post('date');
        $classroom_id = $this->input->post('classroom_id');
        $attendanceHistory= $this->Student_attendance_model->getAttendanceHistoryByPresenseDay($student_id,$pack_type,$strDate,$classroom_id);
        $studentData= $this->Student_model->getstudentInfo($student_id);
        $s = $studentData['fname'].' '.$studentData['lname'].'- '.$studentData['UID'];
        $x = '<h4 class="text-success">'.$s.'</h4> 
        <div class="table-responsive table-cb-none mheight200 mt-10">
        <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>                        
                        <th>Date</th>
                        <th>Time</th>
                        <th>Attendance</th>                        
                        <th>Classroom</th>
                        <th>Marked By</th>
                        <th>Marked On</th>
                    </tr>
                </thead>
                <tbody id="myTable">';
                     
            foreach($attendanceHistory as $c){                    
                    
                    if($c['morning']==1){
                        $presence_m='P';
                        $color_m="green";                        
                    }else if($c['morning']==0){
                        $presence_m='AB';
                        $color_m="red";
                    }else{
                        $presence_m=NA;
                        $color_m="gray";
                    }

                    if($c['evening']==1){
                        $presence_e='P';
                        $color_e="green";                        
                    }else if($c['evening']==0){
                        $presence_e='AB';
                        $color_e="red";
                    }else{
                        $presence_e=NA;
                        $color_e="gray";
                    }

                    $by_user = $c['ufname'].' '.$c['ulname'];
                    if($c['ufname'] == "")
                    {
                       $by_user="Self"; 
                    }
                    $date=date_create($c['date']);
                    $att_date = date_format($date,"M d, Y");
                    
                    $y .= '<tr>                        
                        <td>'.$att_date.'</td>     
                        <td>'.$c['time'].'</td> 
                        <td style="color:'.$color_m.'">'.$presence_m.'</td>
                       
                        <td>'.$c['classroom_name'].'</td> 
                        <td>'.$by_user.'</td>
                        <td>'.$c['created'].'</td>
                    </tr>';
            }
                   
        $z = '</tbody></table></div></div>';
        $resp=$x.$y.$z;
        header('Content-Type: application/json');
        $response = ['msg'=>$resp, 'status'=>'true'];
        echo json_encode($response);
    }

    function ajax_loadStudents(){

        //if student have any inouse package then this be loaded
        $classroom_id = $this->input->post('classroom_id'); 
        $response= $this->Student_attendance_model->loadStudents($classroom_id);
        echo json_encode($response);
    }    
   
    /*function mark_attendance(){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}        
        //access control ends

        $UserFunctionalBranch= $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }
        $data['title'] = 'Mark Attendance';
        $this->load->library('form_validation');        
        $this->form_validation->set_rules('spell','spell','required');
        $this->form_validation->set_rules('classroom_id','classroom','required');        
        if($this->form_validation->run()){

            $by_user=$_SESSION['UserId'];
                $time = date('H:i');
                $date = date('d-m-Y');
                $attendance_id = $this->input->post('attendance_id');//hidden              
                $allStudent = $this->input->post('allStudent');//hidden
                $allStudentArr = explode(",",$allStudent);

                $attendance_cb = $this->input->post('attendance_cb');
                $reInsaert_absent=array_diff($allStudentArr,$attendance_cb);
                $spell = $this->input->post('spell');
                $attendanceCode = INHOUSE.'-'.time();
                $this->db->trans_start();
                if($spell=='Morning'){
                    $res = $this->morning_attendance_($attendanceCode,$attendance_id,$attendance_cb,$reInsaert_absent,$date,$time,$by_user);
                }else if($spell=='Evening'){
                    $res = $this->evening_attendance_($attendanceCode,$attendance_id,$attendance_cb,$reInsaert_absent,$date,$time,$by_user);
                }else{
                    $res= 0;
                } 
                //activity update start 
                if($res!=0){
                    $activity_name= MARKED_INHOUSE_ATTENDANCE;
                    $description= 'Marked inhouse attendance for '.$spell.' Spell';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                }  
                //activity update end               
                $this->db->trans_complete();
                if($this->db->trans_status() === FALSE){
                    $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                    redirect('adminController/student_attendance/mark_attendance');
                }else if($res and $this->db->trans_status() === TRUE) {                                 
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);               
                    redirect('adminController/student_attendance/mark_attendance');
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/student_attendance/mark_attendance');
                }

        }else{            
            $classroomData2 = [];
            $pattern = "/Trainer/i";
            $isTrainer = preg_match($pattern, $_SESSION['roleName']);
            if($isTrainer){
                $UserAccessAsTrainer=$this->User_model->getUserAccessAsTrainer($_SESSION['UserId']);
                if(!empty($UserAccessAsTrainer)){
                    foreach ($UserAccessAsTrainer as $u) {
                       $classroomData1 = $this->Classroom_model->get_classroom_by_access($u['test_module_id'],$u['programe_id'],$u['category_id'],$u['batch_id'],$u['center_id'],$params);
                       if(!empty($classroomData1)){
                        array_push($classroomData2, $classroomData1);
                       }           
                    }
                }else{
                    $classroomData2 = [];
                }                
            }else{
                $classroomData2 = $this->Classroom_model->get_all_classroom($_SESSION['roleName'],$u['test_module_id'],$u['programe_id'],$u['category_id'],$u['batch_id'],$u['center_id'],$params);
                $data['all_test_module']= $this->Test_module_model->get_all_test_module_active();
                $data['all_batches'] = $this->Batch_master_model->get_all_batch_active();
                $data['all_branch'] = $this->Center_location_model->getAcademyBranch($_SESSION['roleName'],$userBranch);               
            }
            foreach($classroomData2 as $key => $cd){
                $pattern = "/,/i";
                $isMultipeCategory = preg_match($pattern, $cd['category_id']);
                if($isMultipeCategory){
                    $cat_arr = explode(',', $cd['category_id']);
                    $cat_arr_count = count($cat_arr);
                    for ($i=0; $i < $cat_arr_count; $i++) { 
                        $get_category_name = $this->Category_master_model->get_category_name($cat_arr[$i]);
                        foreach ($get_category_name as $key2 => $m) {                
                            $classroomData2[$key]['Category'][$key2].=$m.', ';                       
                        }                    
                    }
                }else{
                    $get_category_name = $this->Category_master_model->get_category_name($cd['category_id']);
                    foreach ($get_category_name as $key2 => $m) {                
                        $classroomData2[$key]['Category'][$key2]=$m;                       
                    }
                }
            }            
            $data['all_classroom']=$classroomData2;            
            //$data['classroom_id']=$classroom_id2;
            $data['_view'] = 'student_attendance/index';
            $this->load->view('layouts/main',$data);
        }
        
    }*/

    /*function morning_attendance_($attendanceCode,$attendance_id,$attendance_cb,$reInsaert_absent,$date,$time,$by_user){
        
        $update =0; $strDate= strtotime($date);
        //presense student case:     
        foreach($attendance_cb as $at){
            $params1 = array( 'attendanceCode' => $attendanceCode, 'student_id' => $at, 'type' => INHOUSE,'morning'=> 1, 'time' => $time, 'date'=> $date, 'strDate'=> $strDate, 'by_user' => $by_user
            );                                                       
            $dup = $this->Student_attendance_model->dupliacte_attendance($params1['student_id'],$params1['type'],$params1['date']);          
            if($dup!='DUPLICATE'){
                $ins = $this->Student_attendance_model->add_attendance($params1);
            }else{
                foreach ($attendance_id as $attid){
                    $getStudenId = $this->Student_attendance_model->getStudenId($attid);
                    $exist = in_array( $getStudenId['student_id'], $attendance_cb); 
                    if($exist==1){ $morning = 1;}else{ $morning = 0;}                               
                    $params2 = array('attendanceCode' => $attendanceCode, 'type' => INHOUSE,'morning'=> $morning, 'time' => $time, 'date' => $date, 'strDate'=> $strDate, 'by_user' => $by_user
                    );                                                               
                    $up = $this->Student_attendance_model->update_attendance($attid,$params2);
                } 
                $update = 1;                           
            }                       
        }
        //absent students case:
        if($update==0){
           foreach($reInsaert_absent as $ab){                                  
                $params3 = array( 'attendanceCode' => $attendanceCode, 'student_id' => $ab,'type' => INHOUSE,'morning'=> 0, 'time' => $time, 'date'=> $date, 'strDate'=> $strDate, 'by_user' => $by_user
                );
                $reIns = $this->Student_attendance_model->add_attendance($params3);
            } 
        } 
        //update classroom
        $allMarkedStudents = $this->Student_attendance_model->getAllMarkedStudents($attendanceCode);
        foreach ($allMarkedStudents as $ams){
            $inhoseClassroom = $this->Student_package_model->getInhoseClassroom($ams['student_id']);
            $params4= array('classroom_id'=>$inhoseClassroom['classroom_id']);
            $upCls = $this->Student_attendance_model->updateClassroom($ams['student_id'],$params4);
        }
        if($upCls and ($ins or $up or $reIns)){ return 1; }else{ return 0; }        

    }

    function evening_attendance_($attendanceCode,$attendance_id,$attendance_cb,$reInsaert_absent,$date,$time,$by_user){
        
        $update =0; $strDate= strtotime($date);  
        //presense student case:
        foreach($attendance_cb as $at){
            $params1 = array( 'attendanceCode' => $attendanceCode, 'student_id' => $at, 'type' => INHOUSE,'evening'=> 1, 'time' => $time, 'date'=> $date, 'strDate'=> $strDate, 'by_user' => $by_user
            );                                             
            $dup = $this->Student_attendance_model->dupliacte_attendance($params1['student_id'],$params1['type'],$params1['date']);          
            if($dup!='DUPLICATE'){
                $ins = $this->Student_attendance_model->add_attendance($params1);
            }else{
                //update case
                foreach ($attendance_id as $attid){
                    $getStudenId = $this->Student_attendance_model->getStudenId($attid);
                    $exist = in_array( $getStudenId['student_id'], $attendance_cb); 
                    if($exist==1){ $evening = 1;}else{ $evening = 0;}   
                    $params2 = array('attendanceCode' => $attendanceCode, 'type' => INHOUSE,'evening'=> $evening, 'time' => $time, 'date'=> $date, 'strDate'=> $strDate, 'by_user' => $by_user
                    );                                                               
                    $up = $this->Student_attendance_model->update_attendance($attid,$params2);
                } 
                $update = 1;                           
            }
        }
        //absent students case:
        if($update==0){
            foreach($reInsaert_absent as $ab){                                    
                $params3 = array( 'attendanceCode' => $attendanceCode, 'student_id' => $ab, 'type' => INHOUSE,'evening'=> 0, 'time' => $time, 'date'=> $date, 'strDate'=> $strDate, 'by_user' => $by_user
                );
                $reIns = $this->Student_attendance_model->add_attendance($params3);
            }
        }
        //update classroom
        $allMarkedStudents = $this->Student_attendance_model->getAllMarkedStudents($attendanceCode);
        foreach ($allMarkedStudents as $ams){
            $inhoseClassroom = $this->Student_package_model->getInhoseClassroom($ams['student_id']);
            $params4= array('classroom_id'=>$inhoseClassroom['classroom_id']);
            $upCls = $this->Student_attendance_model->updateClassroom($ams['student_id'],$params4);
        }
        if($upCls and ($ins or $up or $reIns)){ return 1; }else{ return 0; }

    }*/

           
    
}
