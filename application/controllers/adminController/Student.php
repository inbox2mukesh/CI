<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

require_once APPPATH . '/libraries/traits/getEmployeFunctionalBranch.php';
require_once APPPATH . '/libraries/traits/fourmoduleTrait.php';
class Student extends MY_Controller{
    protected $headers_fourmodule = [];
    use getEmployeFunctionalBranch;
    use fourmoduleTrait;
    function __construct(){
        parent::__construct();
        if (!$this->_is_logged_in()) {redirect('adminController/login');}        
        
        $this->load->model('Student_model'); 
        $this->load->model('User_model'); 
        $this->load->model('Test_module_model');
        $this->load->model('Programe_master_model'); 
        $this->load->model('Batch_master_model');       
        $this->load->model('Package_master_model');
        $this->load->model('Practice_package_model');
        $this->load->model('Student_package_model');
        $this->load->model('Student_service_masters_model');
        $this->load->model('Student_journey_model');
        $this->load->model('Refund_model'); 
        $this->load->model('Country_model');
        $this->load->model('Center_location_model');
        $this->load->model('Waiver_model');
        $this->load->model('Student_attendance_model'); 
        $this->load->helper('common'); 
        //echo date('d-m-Y');
        $today=strtotime(date('d-m-Y'));
        $tax_detail = get_tax_details();
        //echo date('d-m-Y');
        $yesterday = date('d-m-Y', strtotime(date('d-m-Y'). ' - 1 days'));
        $yesterdayStr = strtotime($yesterday);
        $this->Package_master_model->DeactivateExpiredPack($today);
        $this->Student_package_model->calculateIrrDuesForExpiredPack($today);
        $this->Package_master_model->startPackByStartDate($today,$tax_detail); 
        $this->Package_master_model->startPackOnHold($today);        
        $this->Package_master_model->activatePackWhichIsOnHold_finished($today);        
        $this->Student_package_model->suspendPackAfterDueCommittmentDate($yesterdayStr);
        $this->Student_package_model->updateDueCommittmentDate();
        $this->Student_attendance_model->backupAttendance($today);
        $this->Waiver_model->deactivateApprovedWaiverNotUsedAfterTwoDays($today);
        $this->Refund_model->deactivateApprovedRefundNotUsedAfterTwoDays($today); 
        $this->headers_fourmodule= array('authorization:'.FOURMODULE_KEY); 
    }

    function clear_all_(){
        if(ENVIRONMENT=='development' or ENVIRONMENT=='testing' or ENVIRONMENT=='staging'){
            $this->Student_model->delete_all_student_tran();
            $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
            redirect('adminController/student/index');
        }else{
            $this->session->set_flashdata('flsh_msg', FAILED_MSG);
            redirect('adminController/student/index');
        }
    }

    function student_verification(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        $data['title'] = 'Verify Mobile/Email';
        $this->load->library('form_validation');    
        if(DEFAULT_COUNTRY == 101)
        {
            $this->form_validation->set_rules('country_code','Country code','required|trim');
            $this->form_validation->set_rules('mobile','Mobile No.','required|trim');
            $this->form_validation->set_rules('mobileOTP','OTP','required|trim'); 
        }
        else {
            $this->form_validation->set_rules('email','Email','required|trim');
            $this->form_validation->set_rules('emailOTP','OTP','required|trim');  
        }        
                 
        if($this->form_validation->run())
         { 
            if(ENVIRONMENT!='production'){
                $plain_pwd = PLAIN_PWD;  
            }else{
                $plain_pwd = $this->_getorderTokens(PWD_LEN);
            }           
                  
            if(DEFAULT_COUNTRY == 101)
            {
               $country_code=$this->input->post('country_code');
                $mobile=$this->input->post('mobile');
                $opt=$this->input->post('mobileOTP');
                $studentid = $this->Student_model->verfiy_StudentOTP_by_mobile($country_code,$mobile,$opt);
                if($studentid['id'])
                { 
                    
                    $params = array('is_otp_verified'=>1,'active'=>1,'password' => md5($plain_pwd));                               
                    $idd = $this->Student_model->update_student($studentid['id'],$params);
                    if(base_url()!=BASEURL){               
                        $studentInfo = $this->Student_model->get_student($studentid['id']);
                        // $subject = 'Dear '.$studentInfo['fname'].', you are registered successfully at '.COMPANY.'';
                        // $email_message = 'You are registered successfully at '.COMPANY.' Your details are as below:';
                        $email_content = student_registration();
                        $subject = $email_content['subject'];
                        $email_message = $email_content['content'];
                        $footer_text = $email_content['email_footer_content'];

                        $mailData  = $this->Student_model->getMailData_forReg($studentid['id']);
                        $mailData['UID']            = $mailData['UID'];
                        $mailData['password']       = $plain_pwd;
                        $mailData['email_message']  = $email_message;
                        $mailData['thanks']         = THANKS;
                        $mailData['team']           = WOSA;
                        $mailData['email_footer_text'] = $footer_text;
                        $this->sendEmailTostd_creds_($subject,$mailData);
                    } 
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);

                    redirect('adminController/student/student_verification'); 
                }
                else {
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/student/student_verification');
                }
            }
            else {
                $email=$this->input->post('email');
                $opt=$this->input->post('emailOTP');  
                $studentid = $this->Student_model->verfiy_StudentOTP($email,$opt);
                if($studentid['id'])
                { 
                    $params = array('is_email_verified'=>1,'active'=>1,'password' => md5($plain_pwd));                               
                    $idd = $this->Student_model->update_student($studentid['id'],$params);  

                    if(base_url()!=BASEURL){                
                        $studentInfo = $this->Student_model->get_student($studentid['id']);
                        $subject = 'Dear '.$studentInfo['fname'].', you are registered successfully at '.COMPANY.'';
                        $email_message = 'You are registered successfully at '.COMPANY.' Your details are as below:';
                        $mailData  = $this->Student_model->getMailData_forReg($studentid['id']);
                        $mailData['UID']            = $mailData['UID'];
                        $mailData['password']       = $plain_pwd;
                        $mailData['email_message']  = $email_message;
                        $mailData['thanks']         = THANKS;
                        $mailData['team']           = WOSA;
                        $this->sendEmailTostd_creds_($subject,$mailData);
                    }
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/student/student_verification'); 
                }
                else {
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/student/student_verification');
                }
            } 
            // send email to student 
            
          

         }
         else {
            $data['all_country_code'] = $this->Country_model->getAllCountryCode();
            $data['_view']='student/student_verification';
            $this->load->view('layouts/main',$data);
         }           
       
    }

    function ajax_checkDuplicateInhousePackBooking(){

        $package_id = $this->input->post('package_id', TRUE);
        $student_id = $this->input->post('student_id', TRUE);
        $type = $this->input->post('type', TRUE);
        echo $count = $this->Student_package_model->checkDuplicateInhousePackBooking($package_id,$student_id,$type);
    }

    function ajax_validateDocExpiryField(){

        $docTypeid = $this->input->post('docTypeid', TRUE);
        $this->load->model('Document_type_model');
        $resp = $this->Document_type_model->getDocumentExpiryType($docTypeid);
        $have_expiry_date = $resp['have_expiry_date'];
        header('Content-Type: application/json');
        if($have_expiry_date){
          $response = ['msg'=>$have_expiry_date, 'status'=>'true'];  
        }else{
          $response = ['msg'=>'N', 'status'=>'false'];
        }        
        echo json_encode($response);
    }

    //non-real function
    function ajax_do_upload_doc_image(){

        if(!file_exists(STD_DOC_FILE_PATH)){
            mkdir(STD_DOC_FILE_PATH, 0777, TRUE);
        }
        $config['upload_path']      = STD_DOC_FILE_PATH;
        $config['allowed_types']    = STD_DOC_TYPES;
        $config['encrypt_name']     = FALSE;         
        $this->load->library('upload',$config);
        if($this->upload->do_upload("fileDoc")){
            $data = array('upload_data' => $this->upload->data());
            $image= $data['upload_data']['file_name'];
            echo $image;
        }
    }

    //non-real function
    function ajax_do_upload_withdrawl_image(){ 

        if(!file_exists(STD_WITHDRAWL_FILE_PATH)){
            mkdir(STD_WITHDRAWL_FILE_PATH, 0777, TRUE);
        }
        $config['upload_path']      = STD_WITHDRAWL_FILE_PATH;
        $config['allowed_types']    = STD_WITHDRAWL_TYPES;
        $config['encrypt_name']     = FALSE;         
        $this->load->library('upload',$config);
        if($this->upload->do_upload("withdrawl_image")){
            $data = array('upload_data' => $this->upload->data());
            $image= $data['upload_data']['file_name'];
            echo $image;
        }
    }

    function getWaiverHistory_(){
       
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}        
        $by_user = $_SESSION['UserId'];
        $student_id = $this->input->post('student_id', TRUE);
        $waiverHistoryData = $this->Waiver_model->getWaiverHistory_($student_id);
        $y='';
        $x = '<h3 class="text-danger">Previous Waiver History</h3>
        <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>                        
                        <th>Sr.</th>
                        <th>Type</th>
                        <th>Requested to</th>
                        <th>Request From</th>
                        <th>Ref. By</th>
                        <th>Requested Amount</th>
                        <th>Actual Used Amount</th>
                        <th>Remarks</th>
                        <th>Created</th>
                        <th>Status 1</th>
                        <th>Status 2</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="myTable">';
            $sr=1;         
            foreach($waiverHistoryData as $c){ 

                $wid = $c['wid'];
                $sid = $c['sid'];

                if($c['active']==1 and $c['approve']==1){
                    $status = '<span class="text-success">Active to use</span>';
                }else if($c['active']==0 and $c['approve']==1){
                    $status = '<span class="text-info">can not use</span>';
                }else if($c['active']==0 and $c['approve']==3){
                    $status = '<span class="text-danger">Expired</span>';
                }else if($c['active']==1 and $c['approve']==0){
                    $status = '<span class="text-warning">Pending for approval- Can not use</span>';
                }else{
                    $status = '<span class="text-warning">Pending for approval- Can not use</span>';
                }


                if($c['active']==1 and $c['approve']==1){
                    $status2 =  '<span class="text-success"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="Active to use">'.ACTIVE.'</a></span>';
                }else if($c['active']==0 and $c['approve']==1){
                    $status2 = '<span class="text-danger"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="can not use">'.DEACTIVE.'</a></span>';
                }else if($c['active']==0 and $c['approve']==3){

                    $status2 = '<span class="text-danger"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="Expired">'.DEACTIVE.'</a></span>';
                }else if($c['active']==1 and $c['approve']==0){

                    $status2 = '<span class="text-info"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="Pending for approval- Can not use">'.DEACTIVE.'</a></span>';
                }else{
                    $status2 = '<span class="text-info"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="Pending for approval- Can not use">'.DEACTIVE.'</a></span>';
                }
                
                if($c['to_id']==$by_user and $c['approve']==0){                            
                            
                    $a1 = '<a href="javascript:void(0);" class="btn btn-warning btn-xs"title="Approve" data-toggle="modal" data-target="#modal-waiver-history1" id='.$wid.' onclick=senddatatomodal(this.id,"'.$sid.'","A")>Approve</span></a>';

                    $a2 = '<a href="javascript:void(0);" class="btn btn-warning btn-xs"title="Approve" data-toggle="modal" data-target="#modal-waiver-history1" id='.$wid.' onclick=senddatatomodal(this.id,"'.$sid.'","R")>Reject</span></a>';

                }elseif($c['to_id']==$by_user and $c['approve']==1 and $c['active']==1){
                                
                    $a1 = '<a href="javascript:void(0);" class="btn btn-success btn-xs" data-toggle="tooltip" title="Approved">Approved</span> </a>';

                    $a2 = '<a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Disapprove" onclick=disApprove_waiver("'.$wid.'")>Back to pending</span> </a>';                               

                }elseif($c['to_id']==$by_user and $c['approve']==2 and $c['active']==1){
                    
                    $a1 = '<a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Rejected">Rejected</span> </a>';

                    $a2 = '<a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Disapprove" onclick=disApprove_waiver("'.$wid.'")>Back to pending</span> </a>';

                }elseif($c['to_id']!=$by_user and $c['approve']==0){
                                
                    $a1 = '<a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Pending">Pending</span> </a>';
                               
                    $a2 = '<a href="'.site_url('adminController/waiver/remove/'.$wid).'" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm("Are you sure you want to delete this item?"");"><span class="fa fa-trash"></span> </a>';

                }elseif($c['to_id']!=$by_user and $c['approve']==1){

                    $a1 = '<a href="javascript:void(0);" class="btn btn-success btn-xs" data-toggle="tooltip" title="Approved">Approved</span> </a>';

                    $a2 = '<a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Do expire" onclick=doExpire_waiver("'.$wid.'")>Do expire</span> </a>';

                }elseif($c['to_id']!=$by_user and $c['approve']==2){
                                
                    $a1 = '<a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Rejected">Rejected</span> </a>';
                    $a2 ='';
                }else{ 
                                
                    $a1 = '<a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Expired">Expired</span> </a>';
                    $a2 ='';
                }
                $action = $a1.$a2;             
                    
                    
                    $y .= '<tr>                        
                        <td>'.$sr.'</td>
                        <td>'.$c['waiver_type'].'</td>                         
                        <td>'.$c['to_fname'].' '.$c['to_lname'].'-'.$c['to_employeeCode'].'</td>
                        <td>'.$c['from_fname'].' '.$c['from_lname'].'-'.$c['from_employeeCode'].'</td>
                        <td>'.$c['ref_fname'].' '.$c['ref_lname'].'-'.$c['ref_employeeCode'].'</td>
                        <td>'.$c['amount'].'</td>
                        <td>'.$c['actually_used_amount'].'</td>  
                        <td>'.$c['remarks'].'</td>
                        <td>'.$c['created'].'</td>
                        <td>'.$status.'</td>
                        <td>'.$status2.'</td>
                        <td>'.$action.'</td>                       
                    </tr>';
                    $sr++;
            }
                   
        $z = '</tbody>
                </table></div>';

        $resp=$x.$y.$z;
        header('Content-Type: application/json');
        $response = ['msg'=>$resp, 'status'=>'true'];
        echo json_encode($response);
    }

    function getRefundHistory_(){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        $student_id = $this->input->post('student_id', TRUE);
        $refundHistoryData = $this->Refund_model->getRefundHistory($student_id);
        $y='';
        $x = '<div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>                        
                        <th>Sr.</th>
                        <th>Refund Requested to</th>
                        <th>Refund Requested From</th>
                        <th>Ref. By</th>
                        <th>Requested Refund Amount</th>
                        <th>Remarks</th>
                        <th>Created</th>
                        <th>Status 1</th>
                        <th>Status 2</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="myTable">';
            $sr=1;         
            foreach($refundHistoryData as $c){ 

                $wid = $c['wid'];
                $sid = $c['sid'];

                if($c['active']==1 and $c['approve']==1){
                    $status = '<span class="text-success">Active to use</span>';
                }else if($c['active']==0 and $c['approve']==1){
                    $status = '<span class="text-info">can not use</span>';
                }else if($c['active']==0 and $c['approve']==3){
                    $status = '<span class="text-danger">Expired</span>';
                }else if($c['active']==1 and $c['approve']==0){
                    $status = '<span class="text-warning">Pending for approval- Can not use</span>';
                }else{
                    $status = '<span class="text-warning">Pending for approval- Can not use</span>';
                }


                if($c['active']==1 and $c['approve']==1){
                    $status2 = '<span class="text-success"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="Active to use">'.ACTIVE.'</a></span>';
                }else if($c['active']==0 and $c['approve']==1){
                    $status2 = '<span class="text-danger"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="can not use">'.DEACTIVE.'</a></span>';
                }else if($c['active']==0 and $c['approve']==3){

                    $status2 = '<span class="text-danger"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="Expired">'.DEACTIVE.'</a></span>';
                }else if($c['active']==1 and $c['approve']==0){
                    $status2 = '<span class="text-info"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="Pending for approval- Can not use">'.DEACTIVE.'</a></span>';
                }else{
                    $status2 = '<span class="text-info"><a href="javascript:void(0);" id='.$c['wid'].' data-toggle="tooltip" title="Pending for approval- Can not use">'.DEACTIVE.'</a></span>';
                }                
                
                if($c['to_id']==$by_user and $c['approve']==0){                            

                    $a1 = '<a href="javascript:void(0);" class="btn btn-warning btn-xs"title="Approve" data-toggle="modal" data-target="#modal-refund-history1" id='.$wid.' onclick=senddatatomodal_refund(this.id,"'.$sid.'","A")>Approve</span> </a>';

                    $a2 = '<a href="javascript:void(0);" class="btn btn-warning btn-xs"title="Approve" data-toggle="modal" data-target="#modal-refund-history1" id='.$wid.' onclick=senddatatomodal_refund(this.id,"'.$sid.'","R")>Reject</span> </a>';

                }elseif($c['to_id']==$by_user and $c['approve']==1 and $c['active']==1){
                                
                    $a1 = '<a href="javascript:void(0);" class="btn btn-success btn-xs" data-toggle="tooltip" title="Approved">Approved</span> </a>';

                    $a2 = '<a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Disapprove" onclick=disApprove_refund("'.$wid.'")>Back to pending</span> </a>';                                

                }elseif($c['to_id']==$by_user and $c['approve']==2 and $c['active']==1){
                                
                    $a1 = '<a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Rejected">Rejected</span> </a>';

                    $a2 = '<a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Disapprove" onclick=disApprove_refund("'.$wid.'")>Back to pending</span> </a>';

                }elseif($c['to_id']!=$by_user and $c['approve']==0){
                    
                    $a1 = '<a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Pending">Pending</span> </a>';
                               
                    $a2 = '<a href="'.site_url('adminController/refund/remove/'.$wid).'" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete" onclick="return confirm("Are you sure you want to delete this item?");"><span class="fa fa-trash"></span> </a>';

                }elseif($c['to_id']!=$by_user and $c['approve']==1){
                                
                    $a1 = '<a href="javascript:void(0);" class="btn btn-success btn-xs" data-toggle="tooltip" title="Approved">Approved</span> </a> ';

                    $a2 = '<a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Do expire" onclick=doExpire_refund("'.$wid.'")>Do expire</span> </a>';

                }elseif($c['to_id']!=$by_user and $c['approve']==2){
                    $a1 = '<a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Rejected">Rejected</span> </a>';
                    $a2 = '';

                }else{
                    $a1 = '<a href="javascript:void(0);" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Expired">Expired</span> </a>';

                    $a2 = '';
                }
                $action = $a1.$a2; 
                    
                    $y .= '<tr>                        
                        <td>'.$sr.'</td> 
                        <td>'.$c['to_fname'].' '.$c['to_lname'].'-'.$c['to_employeeCode'].'</td>
                        <td>'.$c['from_fname'].' '.$c['from_lname'].'-'.$c['from_employeeCode'].'</td>
                        <td>'.$c['ref_fname'].' '.$c['ref_lname'].'-'.$c['ref_employeeCode'].'</td>  
                        <td>'.$c['amount'].'</td>    
                        <td>'.$c['remarks'].'</td> 
                        <td>'.$c['created'].'</td>
                        <td>'.$status.'</td>
                        <td>'.$status2.'</td>
                        <td>'.$action.'</td>                       
                    </tr>';
                    $sr++;
            }
                   
        $z = '</tbody>
                </table></div>';
        $resp=$x.$y.$z;
        header('Content-Type: application/json');
        $response = ['msg'=>$resp, 'status'=>'true'];
        echo json_encode($response);
    }

    //non-real function
    function getWalletTransactionHistory_(){        
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $student_id = $this->input->post('student_id', TRUE);
        $walletHistoryData = $this->Student_model->getWalletTransactionHistory($student_id);
        $y='';
        $x = '<h3 class="text-danger">Previous History</h3>
      
        <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>                        
                        <th>Payment Mode</th>
                        <th>Withdrawal Amount</th>
                        <th>Deposited Amount</th>
                        <th>Transaction Id</th>
                        <th>Payment Screenshot</th>
                        <th>Remarks</th>
                        <th>Done By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="myTable">';
                     
            foreach($walletHistoryData as $c){ 
                    
                    $withdrawl_amount = $c['withdrawl_amount']/100;
                    $deposited_amount = $c['deposited_amount']/100;
                    if($c['withdrawl_image']){
                        $img = $c['withdrawl_image'];
                        $url = base_url('uploads/student_withdrawl/'.$img);
                        $withdrawl_image = '<a href="'.$url.'" target="_blank">View Payment Screenshot</a>';
                    }else{
                       $withdrawl_image=NA; 
                    }                
                    
                    $y .= '<tr>                        
                        <td>'.$c['withdrawl_method'].'</td>     
                        <td>'.$withdrawl_amount.'</td> 
                        <td>'.$deposited_amount.'</td>
                        <td>'.$c['withdrawl_tran_id'].'</td>
                        <td>'.$withdrawl_image.'</td>
                        <td><div class="td-text">'.$c['remarks'].'</div></td>
                        <td>'.$c['fname'].'</td>
                        <td>'.$c['created'].'</td>
                    </tr>';
            }
                   
        $z = '</tbody>
                </table></div>';

        $resp=$x.$y.$z;
        header('Content-Type: application/json');
        $response = ['msg'=>$resp, 'status'=>'true'];
        echo json_encode($response);
     }

    //non-real function
    function add_withdrawl_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('withdrawl_method', 'Payment Mode', 'required');
        $this->form_validation->set_rules('withdrawl_amount', 'Withdrawl Amount', 'required|trim');
        if($this->form_validation->run() == false) {
            header('Content-Type: application/json');
            $response = ['msg'=>'<span class="text-danger">Please enter Withdrawl Amount/Mode</span>', 'status'=>'false'];
            echo json_encode($response);
        }else{            
            $datas = array(
                'student_id'       => $this->input->post('student_id', TRUE),
                'withdrawl_image'  => $this->input->post('withdrawl_image_id', TRUE) ? $this->input->post('withdrawl_image_id', TRUE) : NULL,
                'withdrawl_method'  => $this->input->post('withdrawl_method', TRUE),
                
                'withdrawl_amount'  => $this->input->post('withdrawl_amount', TRUE)*100,
                'withdrawl_tran_id' => $this->input->post('withdrawl_tran_id', TRUE),
                'remarks'=> $this->input->post('student_withdrawl_remarks', TRUE),
                'by_user'      => $by_user
            );            
            $id = $this->Student_model->add_withdrawl($datas);
            if($id){
                $walletData = $this->Student_model->getWalletAmount($datas['student_id']);
                $wallet     = $walletData['wallet'];
                $finalWalletAmount = $wallet-$datas['withdrawl_amount'];                
                $updateWallet = $this->Student_model->update_student_wallet_payment($datas['student_id'],$finalWalletAmount);
                if($updateWallet){
                    $remarks='Withdrawl from wallet';
                    $params3 = array(                    
                        'student_package_id'=> 0,
                        'remarks'           => $remarks,
                        'amount'            => $datas['withdrawl_amount'],                   
                        'student_id'        => $datas['student_id'],
                        'type'              => '-',
                        'by_user'           => $by_user
                    );        
                    $idd2 = $this->Student_package_model->update_transaction($params3);
                }
                $get_UID = $this->Student_model->get_UID($datas['student_id']);
                $UID = $get_UID['UID'];
                $withdrawl_amount = $datas['withdrawl_amount']/100;
                //activity update start
                    $activity_name = WALLET_WITHDRAWL;
                    $description='Withdrawal from wallet worth '.CURRENCY.' '.$withdrawl_amount.' for '.$UID.' ';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
                //activity update end
            }else{
                header('Content-Type: application/json');
                $response = ['msg'=>FAILED_MSG, 'status'=>'false'];
                echo json_encode($response);
            }

            if($id and $idd2){ 
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

    //non-real function
    function add_document_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $this->load->model('Document_type_model');
        $by_user=$_SESSION['UserId'];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('document_typeDoc', 'Doc Type', 'trim');
        if($this->form_validation->run() == FALSE) {
            header('Content-Type: application/json');
            $response=['msg'=>'<span class="text-danger">Doc Type!</span>','status'=>'false'];
            echo json_encode($response);
        }else{            
            $datas = array(
                'student_id'    => $this->input->post('student_id', TRUE),
                'document_type' => $this->input->post('document_type', TRUE),
                'document_no' => $this->input->post('document_no', TRUE),
                'document_expiry' => $this->input->post('document_expiry', TRUE),
                'document_file' => $this->input->post('image_id', TRUE) ? $this->input->post('image_id', TRUE) : NULL,
                'active'       => $this->input->post('active', TRUE),
                'by_user'      => $by_user
            );            
            $id = $this->Student_model->add_document($datas);
            $get_UID = $this->Student_model->get_UID($datas['student_id']);
            $UID = $get_UID['UID'];
            $documentType=$this->Document_type_model->getDocumentType($datas['document_type']);
            $document_type_name = $documentType['document_type_name'];
            //activity update start
                $activity_name = DOC_ADDED;
                $description = 'Document File '.$document_type_name.' uploaded for student '.$UID.' ';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
            if($id){                
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

    //non-real function
    function add_session_status_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $this->load->model('Counseling_session_model');
        $by_user=$_SESSION['UserId'];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('session_booking_remarks', 'Remarks', 'required|trim');
        if($this->form_validation->run() == FALSE) {
            header('Content-Type: application/json');
            $response=['msg'=>'<span class="text-danger">Remarks!</span>','status'=>'false'];
            echo json_encode($response);
        }else{            
            $booking_id = $this->input->post('session_booking_id', TRUE);
            $datas = array(                
                'remarks'=> $this->input->post('session_booking_remarks', TRUE),
                'is_attended' => $this->input->post('is_attended', TRUE),
                'by_user'     => $by_user
            );            
            $id = $this->Student_model->update_session_status($booking_id,$datas);            
            $getStudentId = $this->Counseling_session_model->getStudentId($booking_id);
            $student_id = $getStudentId['student_id'];
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID'];
            //activity update start
                $activity_name = COUNSELLING_SESSION_STAUS;
                $description = 'Counselling session status added for student '.$UID.' ';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end
            if($id){ 
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
    
    function edit($id){
        $id = base64_decode($id);
        $wid = null;
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['title'] = 'Manage Student';
        $by_user=$_SESSION['UserId']; 
        $this->load->model('Gender_model');
        $this->load->model('Counseling_session_model');
        $this->load->model('Source_master_model');
        $this->load->model('Qualification_master_model');
        $this->load->model('Document_type_model');
        //$data['user_functional_branch']=$this->auto_getEmployeFunctionalBranch($_SESSION['UserId']);
        
        //date_default_timezone_set(TIME_ZONE);
        /*$current_DateTime = date("Y-m-d G:i A");
        $current_DateTimeStr = strtotime($current_DateTime);
        $this->Discount_model->deactivate_discount($current_DateTimeStr);*/

        $userInfo=$this->User_model->getUserInfo($by_user);
        $byUserDetails=$userInfo['fname'].' '.$userInfo['lname'].'- '.$userInfo['employeeCode'];
       
        $homeBranch=$this->User_model->getUserHomeBranch($_SESSION['UserId']);
        $enrolledBy_homeBranch = $homeBranch['center_id_home'];

        $UserFunctionalBranch=$this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }
        //Branch type calculation start
        if($_SESSION['roleName']!=ADMIN){
            if(in_array(ONLINE_BRANCH_ID, $userBranch)){
               $userVirtualBranch=1;
            }else{
               $userVirtualBranch=0; 
            }

            if(!empty($userBranch) and $userVirtualBranch==1 and count($userBranch)>1){
                $userPhysicalBranch=1;
            }else if(!empty($userBranch) and $userVirtualBranch==0 and count($userBranch)>0){
                $userPhysicalBranch=1;
            }else{
                $userPhysicalBranch=0;
            }  
        }else{
            $userVirtualBranch=1;
            $userPhysicalBranch=1;
        }      
        //Branch type calculation ends

        $data['userVirtualBranch']=$userVirtualBranch;
        $data['userPhysicalBranch']=$userPhysicalBranch;        
        $data['student'] = $this->Student_model->get_student($id);
        //Getting pack subscribed
        $offlineCount=$this->Package_master_model->getOfflinePackTakenCount($id);        
        $onlineCount=$this->Package_master_model->getOnlinePackActiveCount($id);
        $ppCount=$this->Practice_package_model->getpp_PackActiveCount($id);
        $cgst = $this->Package_master_model->get_tax_detail('CGST');
        $sgst = $this->Package_master_model->get_tax_detail('SGST');
        $data['cgst_tax_per'] = (!empty($cgst))?$cgst['tax_per']:0;
        $data['sgst_tax_per'] = (!empty($sgst))?$sgst['tax_per']:0;
        $rtCount = 0;
        $examCount=0;
        //get session booked
        $data['student_counselling']=$this->Counseling_session_model->get_student_counselling($id,'Bysid');        
        //get offline class package taken if any
        $data['student_package_offline'] = $this->Package_master_model->get_student_pack_subscribed_offline($id,'Bysid');
        //get online class package taken
        $data['student_package_online'] = $this->Package_master_model->get_student_pack_subscribed_online($id,'Bysid');        
        //get practice package taken if any
        $data['student_package_pp'] = $this->Practice_package_model->get_student_pack_subscribed($id,'Bysid');
        $data['WSdocFieldDisplay']=$data['docFieldDisplay']=$data['RTdocFieldDisplay']=$this->Student_model->RTdocFieldDisplay($id);        
        //Get waiver approved if any
        $data['waiver_approved']=$this->Waiver_model->get_waiver_approved_count($id,$by_user);
    //    pr($data['waiver_approved'],1 );
        if($data['waiver_approved']>0){
            $data['waiver_approved_details'] = $this->Waiver_model->get_waiver_approved_details($id,$by_user);
            $wid = $data['waiver_approved_details']['wid'];
            $data['waiver_amount_given'] = $data['waiver_approved_details']['amount'];
            $data['waiver_from_name']= $data['waiver_approved_details']['from_fname'].' '.$data['waiver_approved_details']['from_lname'];
            // pr($data['waiver_approved_details'],1);
        }
        //Get refund approved if any
        $data['refund_approved']=$this->Refund_model->get_refund_approved_count($id,$by_user);
        if($data['refund_approved']>0){
            $data['refund_approved_details'] = $this->Refund_model->get_refund_approved_details($id,$by_user);
            $rid = $data['refund_approved_details']['wid'];
        }             

        if(isset($data['student']['id']))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fname','First name','required|trim');         
                if($this->input->post('mail_sent', TRUE)){$mail_sent=$this->input->post('mail_sent');}else{$mail_sent = FALSE;}
                if($this->input->post('pack_cb', TRUE)){$pack_cb=$this->input->post('pack_cb');}else{$pack_cb=FALSE;}
                if($pack_cb=='online'){
                    $fresh=2;
                    $this->form_validation->set_rules('test_module_id','Course','required');
                    $this->form_validation->set_rules('programe_id','Program','required');
                    $this->form_validation->set_rules('package_id','Online Class Package','required');
                    $this->form_validation->set_rules('method','Payment mode','required');
                    $this->form_validation->set_rules('amount_paid','Amount','required|trim');
                    $this->form_validation->set_rules('start_date','Pack starting date','required');
                    $this->form_validation->set_rules('batch_id','Batch','required');
                }elseif($pack_cb=='offline'){
                    $fresh=2;
                    $this->form_validation->set_rules('test_module_id','Course','required');
                    $this->form_validation->set_rules('programe_id','Program','required');
                    $this->form_validation->set_rules('package_id_off','Inhouse Package','required');
                    $this->form_validation->set_rules('method_off','Payment mode','required');
                    $this->form_validation->set_rules('amount_paid_off','Amount','required|trim');
                    $this->form_validation->set_rules('start_date_off','Pack starting date','required');
                     $this->form_validation->set_rules('batch_id_off','Batch','required');
                }elseif($pack_cb=='pp'){ 
                    $fresh=2;
                    $this->form_validation->set_rules('test_module_id','Course','required');
                    $this->form_validation->set_rules('programe_id','Program','required');
                    $this->form_validation->set_rules('package_id_pp','Practice Package','required');
                    $this->form_validation->set_rules('method_pp','Payment mode','required');
                    $this->form_validation->set_rules('amount_paid_pp','Amount','required|trim');
                    $this->form_validation->set_rules('start_date_pp','Pack starting date','required');
                }else{ $fresh=1; }

                if($this->form_validation->run()){ 
                    
                    if(!file_exists(PROFILE_PIC_FILE_PATH)){
                        mkdir(PROFILE_PIC_FILE_PATH, 0777, TRUE);
                    }
                    $config['upload_path']   = PROFILE_PIC_FILE_PATH;
                    $config['allowed_types'] = EMP_ALLOWED_TYPES;
                    $config['encrypt_name']  = FALSE;        
                    $this->load->library('upload',$config);
                    if($this->upload->do_upload("profile_pic")){
                        $data = array('upload_data' => $this->upload->data());
                        $profile_pic= PROFILE_PIC_FILE_PATH.$data['upload_data']['file_name'];
                        unlink($this->input->post('hid_profile_pic'));
                       // $this->input->post('hid_profile_pic')
                    }else{
                        $profile_pic=$data['student']['profile_pic'];
                    }
                    $plain_pwd='';
                    if($this->input->post('service_id', TRUE)){
                        $service_id=$this->input->post('service_id', TRUE);
                    }else{
                        $service_id = $data['student']['service_id'];
                    }
                    
                    if($this->input->post('center_id', TRUE)){
                        $center_id= $this->input->post('center_id', TRUE);
                    }else{
                        if($pack_cb=='online'){
                            $center_id = ONLINE_BRANCH_ID;
                        }else{
                            $center_id = $data['student']['center_id'];
                        }                          
                    }                    

                    if($this->input->post('test_module_id', TRUE)){
                        $test_module_id = $this->input->post('test_module_id', TRUE);
                    }else{
                        $test_module_id = $data['student']['test_module_id'];
                    }

                    if($this->input->post('programe_id', TRUE)){
                        $programe_id = $this->input->post('programe_id', TRUE);
                    }else{
                        $programe_id = $data['student']['programe_id'];
                    }
                    $studentStatus = $this->_calculateStatus($service_id,$center_id,$test_module_id,$programe_id,$pack_cb);
                    $student_identity = $studentStatus['student_identity'];
                    $details = $studentStatus['details'];
                    
                    if($pack_cb=='online' or $pack_cb=='pp'){
                        $params = array(
                            'service_id'        => $service_id,
                            'test_module_id'    => $test_module_id,
                            'programe_id'       => $programe_id,
                            'center_id'         => $center_id,
                            'profile_pic'       => $profile_pic,
                            'source_id'         => $this->input->post('source_id', TRUE),
                            'gender'            => $this->input->post('gender_name', TRUE),
                            'fname'             => ucfirst($this->input->post('fname', TRUE)),
                            'lname'             => ucfirst($this->input->post('lname', TRUE)),
                            'father_name'       => ucfirst($this->input->post('father_name', TRUE)),
                            'mother_name'       => ucfirst($this->input->post('mother_name', TRUE)),
                            'father_dob'        =>  $this->input->post('father_dob', TRUE),
                            'mother_dob'        =>  $this->input->post('mother_dob', TRUE),
                            'parents_anniversary'=> $this->input->post('parents_anniversary', TRUE), 
                            'gaurdian_contact'   => $this->input->post('gaurdian_contact', TRUE),                 
                            'dob'               =>$this->input->post('dob', TRUE),
                            'int_country_id'    =>$this->input->post('int_country_id', TRUE),
                            'qualification_id'  =>$this->input->post('qualification_id', TRUE),
                            'residential_address'=> $this->input->post('residential_address', TRUE),
                            'active'            => $this->input->post('active', TRUE),
                            'by_user'           => $by_user,
                            'fresh'             => $fresh,
                        ); 
                    }else{                        
                        $params = array(
                            'student_identity'  => $student_identity,
                            'service_id'        => $service_id,
                            'test_module_id'    => $test_module_id,
                            'programe_id'       => $programe_id,
                            'center_id'         => $center_id,
                            'profile_pic'       => $profile_pic,
                            'source_id'         => $this->input->post('source_id', TRUE),
                            'gender'            => $this->input->post('gender_name', TRUE),
                            'fname'             => ucfirst($this->input->post('fname', TRUE)),
                            'lname'             => ucfirst($this->input->post('lname', TRUE)),
                            'father_name'       => ucfirst($this->input->post('father_name', TRUE)),
                            'mother_name'       => ucfirst($this->input->post('mother_name', TRUE)),
                            'father_dob'        => $this->input->post('father_dob', TRUE),
                            'mother_dob'        => $this->input->post('mother_dob', TRUE),
                            'parents_anniversary'=>$this->input->post('parents_anniversary', TRUE), 
                            'gaurdian_contact'  => $this->input->post('gaurdian_contact', TRUE),                
                            'dob'               => $this->input->post('dob', TRUE),
                            'int_country_id'    => $this->input->post('int_country_id', TRUE),
                            'qualification_id'  => $this->input->post('qualification_id', TRUE),
                            'residential_address' => $this->input->post('residential_address', TRUE),
                            'active'              => $this->input->post('active', TRUE),
                            'by_user'             => $by_user,
                            'fresh'               => $fresh,
                        );
                    }       
                    $this->db->trans_start(); 
                    $params2 = array('student_id'=>$id, 'student_identity'=> $student_identity,'details'=> $details,'by_user'=>$by_user);                               
                    $idd = $this->Student_model->update_student($id,$params);                    
                    if(!$pack_cb or $pack_cb=='none'){
                        $std_journey = $this->Student_journey_model->update_studentJourney($params2);
                    }
                    if($pack_cb=='online'){
                        $this->sell_online_pack_($wid,$this->input->post('package_id', TRUE),$id,$mail_sent,$enrolledBy_homeBranch);
                    }elseif($pack_cb=='offline'){
                        $this->sell_inhouse_pack_($wid,$this->input->post('package_id_off', TRUE),$id,$mail_sent,$enrolledBy_homeBranch);
                    }elseif($pack_cb=='pp'){
                        $this->sell_practice_pack_($wid,$this->input->post('package_id_pp', TRUE),$id,$mail_sent,$offlineCount,$onlineCount,$ppCount,$enrolledBy_homeBranch);
                       //die();
                    }else{ /*...do nothing...*/ }
                    
                    //get branch collection
                    $branchCollection = $this->Student_package_model->branchCollection($id);
                    //update all centers
                    $params_all_center=array('all_center_id'=>$branchCollection['all_center_id']);
                    $this->Student_model->update_student($id,$params_all_center);
                    
                    $this->db->trans_complete();                
                    if($this->db->trans_status() === FALSE){
                        $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                        redirect('adminController/student/edit/'.base64_encode($id));
                    }elseif($idd){
                        $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                        redirect('adminController/student/edit/'.base64_encode($id));
                    }else{
                        $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                        redirect('adminController/student/edit/'.base64_encode($id));
                    }
            }else{  
                $data['all_programe_masters']=$this->Programe_master_model->getPgm_forStudent();
                $data['all_test_module']=$this->Test_module_model->get_all_test_module_active();
                $data['all_batches']=$this->Batch_master_model->get_all_batch_active();
                $data['all_genders']=$this->Gender_model->get_all_gender_active();
                $data['all_country_code']=$this->Country_model->get_all_country_active();
                $data['all_branch'] = $this->Center_location_model->getAcademyBranch($_SESSION['roleName'],$userBranch);
                $data['all_source']=$this->Source_master_model->get_all_source();
                $data['all_services']=$this->Student_service_masters_model->get_all_services_for_editStd();
                $data['allCnt']=$this->Country_model->getAllCountryNameAPI_deal();
                $data['allQua']=$this->Qualification_master_model->get_all_qualification_active();
                $data['allDocType']=$this->Document_type_model->get_all_document_type_active();
                $data['_view'] = 'student/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
    }

    //non-real function
    function adjust_online_and_inhouse_pack_($student_package_id){                

        $data['title'] = 'Adjustment- Online Pack';
        $by_user=$_SESSION['UserId'];
        $userBranch = null;
        $get_sid = $this->Student_package_model->get_sid($student_package_id);
        $student_id =  $get_sid['student_id'];
        $serviceId  = $this->Student_model->get_studentService($student_id);
        $service_id =  $serviceId['service_id'];
        $test_module_id =  $serviceId['test_module_id'];
        $programe_id =  $serviceId['programe_id'];
        $center_id =  $serviceId['center_id'];
        $getPackageId = $this->Student_package_model->getExamPackageId($student_package_id);
        $cgst = $this->Package_master_model->get_tax_detail('CGST');
        $sgst = $this->Package_master_model->get_tax_detail('SGST');
        $data['cgst_tax_per'] = (!empty($cgst))?$cgst['tax_per']:0;
        $data['sgst_tax_per'] = (!empty($sgst))?$sgst['tax_per']:0;
        $tax_arr = json_encode(['cgst'=>$data['cgst_tax_per'],'sgst'=>$data['sgst_tax_per']]);
        $package_id = $getPackageId['package_id'];
        /////////////////////////////////////////////////////////////              
        if($student_package_id && $student_id)
        {            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('payment_type','Payment type','required');
            $payment_type = $this->input->post('payment_type', TRUE);
            if($payment_type=='Add payment'){
                $this->form_validation->set_rules('add_payment','Payment amount','required|trim|integer');
            }elseif($payment_type=='Adjustment-PE'){                  
                $this->form_validation->set_rules('add_payment_pe','Extension amount','required|trim|integer');
                $this->form_validation->set_rules('expired_on','Expiry date','required|trim');
            }elseif($payment_type=='Adjustment-BS'){                  
                $this->form_validation->set_rules('center_id','Branch','required|integer');
            }elseif($payment_type=='Adjustment-CS'){                  
                $this->form_validation->set_rules('test_module_id','Course','required|integer');
                $this->form_validation->set_rules('programe_id','Program','required|integer');
                $this->form_validation->set_rules('add_payment_cs','Payment amount','required|trim|integer');
            }elseif($payment_type=='Pack on Hold'){                   
                $this->form_validation->set_rules('holdDateFrom','Pack hold date from','required|trim');
                $this->form_validation->set_rules('holdDateTo','Pack hold date till','required|trim');
            }elseif($payment_type=='Terminate-Pack'){                 
                $this->form_validation->set_rules('termination_reason','Termination reason','required|trim');
            }elseif($payment_type=='Change DCD'){                    
                $this->form_validation->set_rules('new_due_committment_date','Due committment date','required|trim');
            }elseif($payment_type=='Reactivate-Pack-Against-PR'){
                
            }
            elseif($payment_type=='Manage start date'){                    
                $this->form_validation->set_rules('new_start_date','New Start Date','required|trim');
            }
            else{  }
            // $org_pr = $this->input->post('add_payment', TRUE);
            // $cgst_amt = (($org_pr * $data['cgst_tax_per'])/100);
            // $sgst_amt = (($org_pr * $data['sgst_tax_per'])/100);
            // $cgst_amt_ttl = ($cgst_amt + $this->input->post('cgst_amt'))*100;
            // $sgst_amt_ttl = ($sgst_amt + $this->input->post('sgst_amt'))*100;

            if($this->form_validation->run()){                
                //tran start
                $this->db->trans_start();                                
                if($payment_type=='Add payment'){
                    
                    $org_pr = $this->input->post('add_payment', TRUE);
                    $use_wallet = $this->input->post('use_wallet', TRUE); 
                    $remarks = $this->input->post('remarks', TRUE);                    
                    $cgst_amt = (($org_pr * $data['cgst_tax_per'])/100);
                    $sgst_amt = (($org_pr * $data['sgst_tax_per'])/100);
                    $cgst_amt_ttl = ($cgst_amt + $this->input->post('cgst_amt'))*100;
                    $sgst_amt_ttl = ($sgst_amt + $this->input->post('sgst_amt'))*100;
                    //$current_amt_ext_tax = ($this->input->post('base_amt')+$org_pr)*100;
                    $amount_paid = ($org_pr +$cgst_amt+$sgst_amt)*100;
                    //$amount_paid = ($current_amt_inc_tax + $this->input->post('amount',TRUE))*100;
                    if($this->input->post('due_commitment_date_next')){
                        $due_commitment_date = strtotime($this->input->post('due_commitment_date_next', TRUE));
                    }else{
                        $due_commitment_date ='';
                    }
                    //$add_payment,$use_wallet,$due_commitment_date,$remarks,$student_package_id,$student_id,$total_amt,$cgst_amt,$sgst_amt,$tax_arr,$totalpayment                    
                    $response = $this->add_payment_($org_pr*100,$use_wallet,$due_commitment_date,$remarks,$student_package_id,$student_id,$amount_paid,$cgst_amt*100,$sgst_amt*100,$tax_arr);                    

                }elseif($payment_type=='Adjustment-PE'){
                    $org_pr = $this->input->post('add_payment_pe', TRUE);
                    $use_wallet = $this->input->post('use_wallet_pe', TRUE);    
                    $add_payment = $this->input->post('add_payment_pe', TRUE)*100;
                    $ext_remarks = $this->input->post('extension_remarks', TRUE); 
                    $newDate = date("d-m-Y", strtotime($this->input->post('expired_on')));
                    $total_amt = $this->input->post('totalpayableamt',TRUE)*100;
                    $cgst_amt = (($org_pr * $data['cgst_tax_per'])/100);
                    $sgst_amt = (($org_pr * $data['sgst_tax_per'])/100);
                    $cgst_amt_ttl = ($cgst_amt + $this->input->post('cgst_amt'))*100;
                    $sgst_amt_ttl = ($sgst_amt + $this->input->post('sgst_amt'))*100;
                    $total_tax = ($cgst_amt + $sgst_amt)*100;
                    $total_amt = $add_payment + $total_tax;
                    // $cgst_amt_ttl = ($cgst_amt + $this->input->post('cgst_amt'))*100;
                    // $sgst_amt_ttl = ($sgst_amt + $this->input->post('sgst_amt'))*100;
                    // $response = $this->pack_extension_adjustment_($add_payment,$use_wallet,$newDate,$student_package_id,$student_id,$total_amt,$total_tax,$tax_arr);

                    $response = $this->pack_extension_adjustment_($add_payment,$use_wallet,$newDate,$student_package_id,$student_id,$total_amt,$total_tax,$tax_arr,$ext_remarks);                 

                }elseif($payment_type=='Adjustment-BS'){
                    
                    $center_id = $this->input->post('center_id', TRUE);
                    $amount_paid =  $get_sid['amount_paid'];
                    $cutting_amount = $this->input->post('add_payment_bs', TRUE)*100;                
                    $restAmount = $amount_paid-$cutting_amount;                    
                    $response = $this->branch_switch_adjustment_($center_id,$service_id,$student_package_id,$student_id,$test_module_id,$programe_id,$amount_paid,$cutting_amount,$restAmount);

                }elseif($this->input->post('payment_type')=='Adjustment-CS'){                    
                    $programe_id = $this->input->post('programe_id', TRUE);
                    $test_module_id = $this->input->post('test_module_id', TRUE);
                    $amount_paid =  $get_sid['amount_paid'];
                    $cutting_amount = $this->input->post('add_payment_cs', TRUE)*100;
                    $restAmount = $amount_paid-$cutting_amount;
                    $response = $this->course_switch_adjustment_($programe_id,$test_module_id,$service_id,$student_package_id,$student_id,$amount_paid,$cutting_amount,$restAmount,$center_id);

                }elseif($this->input->post('payment_type')=='Pack on Hold'){                    
                    $holdDateFrom = $this->input->post('holdDateFrom', TRUE);
                    $holdDateTo = $this->input->post('holdDateTo', TRUE);
                    $application_file = $this->input->post('application_file', TRUE);
                    $response = $this->do_pack_on_hold_($holdDateFrom,$holdDateTo,$application_file,$student_package_id,$student_id);
                }elseif($this->input->post('payment_type')=='Batch Update'){
                    $batch_id = $this->input->post('batch_id_adj', TRUE);
                    $response = $this->updateBatch_($batch_id,$student_package_id,$student_id);
                }elseif($payment_type=='Terminate-Pack'){
                    $termination_reason = $this->input->post('termination_reason', TRUE);
                    $response = $this->terminate_pack_($termination_reason,$student_package_id,$student_id);
                }elseif($this->input->post('payment_type')=='Unhold-Pack'){
                    $response=$this->unhold_pack_($student_package_id,$student_id);
                }elseif($payment_type=='Reactivate-Pack'){
                    $response=$this->reactivate_pack_($student_package_id,$student_id);
                }elseif($payment_type=='Change DCD'){
                    
                    if($this->input->post('new_due_committment_date', TRUE)){
                        $new_due_committment_date = strtotime($this->input->post('new_due_committment_date', TRUE));
                    }else{
                        $new_due_committment_date='';
                    }
                    $response = $this->updateNewDueCommittmentDate_($student_package_id,$new_due_committment_date,$student_id);
                }elseif($payment_type=='Reactivate-Pack-Against-PR'){
                    
                    $response = $this->reactivate_pack_against_partial_refund_($student_package_id,$student_id);
                }
                elseif($payment_type=='Manage start date'){
                    
                    $new_start_date = $this->input->post('new_start_date', TRUE);    
                    
                    $response = $this->manage_pack_start_date($new_start_date,$student_package_id,$student_id);                    

                }
            else{ /*... do nothing ...*/ }

                $this->db->trans_complete();
                if($this->db->trans_status() === FALSE){
                    $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                    redirect('adminController/student/adjust_online_and_inhouse_pack_/'.$student_package_id);
                }elseif($response){
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/student/edit/'.base64_encode($student_id));
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/student/adjust_online_and_inhouse_pack_/'.$student_package_id);
                }   
                
            }else{
                
                $data['wallet'] = $this->Student_model->getWalletAmount($student_id);
                $data['student_package'] = $this->Package_master_model->get_student_pack_subscribed($student_package_id,'Byspid');
                $catData=$this->Package_master_model->getPackCategory($data['student_package'][0]['package_id']);
                foreach ($catData as $key2 => $c) {                
                    $data['student_package'][0]['Package_category'][$key2]=$c;
                }
                $data['all_branch']=$this->Center_location_model->getAcademyBranch($_SESSION['roleName'],$userBranch);
                $data['all_programe_masters']=$this->Programe_master_model->get_all_programe_masters_active();
                $data['all_test_module']=$this->Test_module_model->get_all_test_module_active();
                $data['all_batches']=$this->Package_master_model->getPackBatch($package_id);
                $data['_view'] = 'student/update_student_pack_payment';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
        ////////////////////////////////////////////////////////////
        
    }   
    
   
    //non-real function
    function adjust_practice_pack_($student_package_id)
    {               
        $userBranch =null;
        $data['title'] = 'Adjustment- Practice Pack';
        $by_user=$_SESSION['UserId'];
        $get_sid = $this->Student_package_model->get_sid($student_package_id);
        $student_id =  $get_sid['student_id'];
        $serviceId  = $this->Student_model->get_studentService($student_id);
        $service_id =  $serviceId['service_id'];
        $test_module_id =  $serviceId['test_module_id'];
        $programe_id =  $serviceId['programe_id'];
        $center_id =  $serviceId['center_id'];
        $cgst = $this->Package_master_model->get_tax_detail('CGST');
        $sgst = $this->Package_master_model->get_tax_detail('SGST');
        $data['cgst_tax_per'] = (!empty($cgst))?$cgst['tax_per']:0;
        $data['sgst_tax_per'] = (!empty($sgst))?$sgst['tax_per']:0;
        $tax_arr = json_encode(['cgst'=>$data['cgst_tax_per'],'sgst'=>$data['sgst_tax_per']]);
        /////////////////////////////////////////////////////////////            
        if($student_package_id and $student_id){

            $this->load->library('form_validation');
            $payment_type = $this->input->post('payment_type', TRUE);
            $this->form_validation->set_rules('payment_type','Payment type','required');
                if($payment_type=='Add payment'){
                    $this->form_validation->set_rules('add_payment','Payment amount','required|integer');
                }elseif($payment_type=='Adjustment-PE'){
                    $this->form_validation->set_rules('add_payment_pe','Extension amount','required|integer');
                    $this->form_validation->set_rules('expired_on','Expiry date','required');
                }elseif($payment_type=='Adjustment-BS'){
                    $this->form_validation->set_rules('center_id','Branch','required|integer');
                }elseif($payment_type=='Adjustment-CS'){
                    $this->form_validation->set_rules('test_module_id','Course','required|integer');
                    $this->form_validation->set_rules('programe_id','Program','required|integer');
                    $this->form_validation->set_rules('add_payment_cs','Payment amount','required|integer');
                }elseif($payment_type=='Pack on Hold'){                    
                    $this->form_validation->set_rules('holdDateFrom','Pack hold date from','required');
                    $this->form_validation->set_rules('holdDateTo','Pack hold date till','required');
                }elseif($payment_type=='Terminate-Pack'){                    
                    $this->form_validation->set_rules('termination_reason','Termination reason','required');
                }elseif($payment_type=='Change DCD'){                    
                    $this->form_validation->set_rules('new_due_committment_date','Due committment date','required');
                }
                elseif($payment_type=='Manage start date'){                    
                    $this->form_validation->set_rules('new_start_date','New Start Date','required|trim');
                }
            else{ /*... do nothing ...*/ }       
        
            if($this->form_validation->run()){                
                //tran start
                $this->db->trans_start();                
                if($payment_type=='Add payment'){
                    // $org_pr = $this->input->post('add_payment', TRUE);
                    // $use_wallet = $this->input->post('use_wallet', TRUE); 
                    // $add_payment = $this->input->post('add_payment', TRUE)*100;
                    // $remarks = $this->input->post('remarks', TRUE);
                    // $total_amt = $this->input->post('totalpayableamt',TRUE)*100;
                    // $cgst_amt = (($org_pr * $data['cgst_tax_per'])/100);
                    // $sgst_amt = (($org_pr * $data['sgst_tax_per'])/100);
                    // $cgst_amt_ttl = ($cgst_amt + $this->input->post('cgst_amt'))*100;
                    // $sgst_amt_ttl = ($sgst_amt + $this->input->post('sgst_amt'))*100;
                    // $initial_payment = ($this->input->post('base_amt')+$org_pr)*100;
                    $org_pr = $this->input->post('add_payment', TRUE);
                    $use_wallet = $this->input->post('use_wallet', TRUE); 
                    $remarks = $this->input->post('remarks', TRUE);                    
                    $cgst_amt = (($org_pr * $data['cgst_tax_per'])/100);
                    $sgst_amt = (($org_pr * $data['sgst_tax_per'])/100);
                    //$cgst_amt_ttl = ($cgst_amt + $this->input->post('cgst_amt'))*100;
                    //$sgst_amt_ttl = ($sgst_amt + $this->input->post('sgst_amt'))*100;
                    $amount_paid = ($org_pr +$cgst_amt+$sgst_amt)*100;
                    if($this->input->post('due_commitment_date_next', TRUE)){
                        $due_commitment_date = strtotime($this->input->post('due_commitment_date_next', TRUE));
                    }else{
                        $due_commitment_date ='';
                    }                    
                    $response = $this->add_payment_($org_pr*100,$use_wallet,$due_commitment_date,$remarks,$student_package_id,$student_id,$amount_paid,$cgst_amt*100,$sgst_amt*100,$tax_arr);  

                }elseif($payment_type=='Adjustment-PE'){
                    $org_pr = $this->input->post('add_payment_pe', TRUE);
                    $use_wallet = $this->input->post('use_wallet', TRUE); 
                    //$add_payment = $this->input->post('add_payment', TRUE)*100;
                    $remarks = $this->input->post('remarks', TRUE);
                    $ext_remarks = $this->input->post('extension_remarks', TRUE);
                    $cgst_amt = (($org_pr * $data['cgst_tax_per'])/100)*100;
                    $sgst_amt = (($org_pr * $data['sgst_tax_per'])/100)*100;
                    $use_wallet = $this->input->post('use_wallet_pe', TRUE);
                    $add_payment = $this->input->post('add_payment_pe', TRUE)*100;
                    $newDate = date("d-m-Y", strtotime($this->input->post('expired_on', TRUE)));
                    $total_tax = $cgst_amt + $sgst_amt;
                    $total_amt = $add_payment + $total_tax;
                    // $cgst_amt_ttl = ($cgst_amt + $this->input->post('cgst_amt'))*100;
                    // $sgst_amt_ttl = ($sgst_amt + $this->input->post('sgst_amt'))*100;
                    $response = $this->pack_extension_adjustment_($add_payment,$use_wallet,$newDate,$student_package_id,$student_id,$total_amt,$total_tax,$tax_arr,$ext_remarks);                     

                }elseif($payment_type=='Adjustment-BS'){
                    $center_id = $this->input->post('center_id', TRUE);                    
                    $response = $this->branch_switch_adjustment_($center_id,$service_id,$student_package_id,$student_id,$test_module_id,$programe_id);                

                }elseif($payment_type=='Adjustment-CS'){
                    $programe_id = $this->input->post('programe_id', TRUE);
                    $test_module_id = $this->input->post('test_module_id', TRUE);
                    $amount_paid =  $get_sid['amount_paid'];
                    $cutting_amount = $this->input->post('add_payment_cs', TRUE)*100;
                    $restAmount = $amount_paid-$cutting_amount;
                    $response = $this->course_switch_adjustment_($programe_id,$test_module_id,$service_id,$student_package_id,$student_id,$amount_paid,$cutting_amount,$restAmount,$center_id);

                }elseif($payment_type=='Pack on Hold'){                    
                    $holdDateFrom = $this->input->post('holdDateFrom', TRUE);
                    $holdDateTo = $this->input->post('holdDateTo', TRUE);
                    $application_file = $this->input->post('application_file', TRUE);
                    $response = $this->do_pack_on_hold_($holdDateFrom,$holdDateTo,$application_file,$student_package_id,$student_id);

                }elseif($payment_type=='Terminate-Pack'){                  
                    $termination_reason = $this->input->post('termination_reason', TRUE);
                    $response = $this->terminate_pack_($termination_reason,$student_package_id,$student_id);
                }elseif($payment_type=='Unhold-Pack'){
                    $response = $this->unhold_pack_($student_package_id,$student_id);
                }elseif($this->input->post('payment_type')=='Reactivate-Pack'){
                    $response = $this->reactivate_pack_($student_package_id,$student_id);
                }elseif($payment_type=='Change DCD'){
                    
                    if($this->input->post('new_due_committment_date')){
                        $new_due_committment_date = strtotime($this->input->post('new_due_committment_date'));
                    }else{
                        $new_due_committment_date='';
                    }
                    $response = $this->updateNewDueCommittmentDate_($student_package_id,$new_due_committment_date,$student_id);
                }
                elseif($payment_type=='Reactivate-Pack-Against-PR'){                    
                    $response = $this->reactivate_pack_against_partial_refund_($student_package_id,$student_id);
                }
                elseif($payment_type=='Manage start date'){
                    
                    $new_start_date = $this->input->post('new_start_date', TRUE);    
                    
                    $response = $this->manage_pack_start_date($new_start_date,$student_package_id,$student_id);                    

                }
            else{ /*... do nothing ...*/ }              
                $this->db->trans_complete();
                if($this->db->trans_status() === FALSE){
                    $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                    redirect('adminController/student/adjust_practice_pack_/'.$student_package_id);
                }elseif($response){
                    $this->session->set_flashdata('flsh_msg', SUCCESS_MSG);
                    redirect('adminController/student/edit/'.base64_encode($student_id));
                }else{
                    $this->session->set_flashdata('flsh_msg', FAILED_MSG);
                    redirect('adminController/student/adjust_practice_pack_/'.$student_package_id);
                }      
                
            }else{

               $data['wallet'] = $this->Student_model->getWalletAmount($student_id);
               $data['student_package_pp'] = $this->Practice_package_model->get_student_pack_subscribed($student_package_id,'Byspid');
               $catData=$this->Package_master_model->getPackCategorypp($data['student_package_pp'][0]['package_id']);
                foreach ($catData as $key2 => $c) {                
                    $data['student_package_pp'][0]['Package_category'][$key2]=$c;
                }  
               $data['all_branch'] = $this->Center_location_model->getAcademyBranch($_SESSION['roleName'],$userBranch);
               $data['all_programe_masters'] = $this->Programe_master_model->get_all_programe_masters_active();
               $data['all_test_module']=$this->Test_module_model->get_all_test_module_active();
               $data['_view'] = 'student/update_student_pack_payment_pp';
               $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error(ITEM_NOT_EXIST);
        ////////////////////////////////////////////////////////////        
    } 
       

    //non-real function
    function sell_online_pack_($wid,$package_id,$sid,$mail_sent,$enrolledBy_homeBranch)
    {
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='sell_online_pack_';        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends 
        $this->load->helper('foumodule_api_helper');
        $by_user=$_SESSION['UserId'];
        $this->load->model('Classroom_model');      
        $pack_category_id=null; 
        $package_data= $this->Package_master_model->get_package_master($package_id);
        $duration_type = $package_data['duration_type_name'];
        $duration      = $package_data['duration'];         
        $dt = $duration.' '.$duration_type;
        if($duration_type=='Day'){
            $duration = $duration;
        }elseif($duration_type=='Week'){
           $duration = $duration*7;                
        }elseif($duration_type=='Month'){
           $duration = $duration*30;                
        }else{
           $duration = 0;
        }
        if($duration >0){
           $duration=$duration-1;
          //  $duration=$duration;
        }      
        $duration = $duration.' days'; 
        $discount_code = null;
        $centerCode = null;
        $batch_id= null;$pack_center_id  = null; 
        // $amt_ext_tax_paid = $this->input->post('amount_paid');
        // $cgst = $this->Package_master_model->get_tax_detail('CGST');
        // $sgst = $this->Package_master_model->get_tax_detail('SGST');
        // $package_name       = $package_data['package_name'];
        // $discountedamount  = $package_data['discounted_amount'];
        // $pack_basic_amt = $package_data['discounted_amount'];
        // $cgst_tax = number_format(($amt_ext_tax_paid * $cgst['tax_per'])/100);
        // $sgst_tax = number_format(($amt_ext_tax_paid * $sgst['tax_per'])/100);
        // $amount_paid = ($discountedamount + $sgst_tax + $cgst_tax);
        // // pr($sgst_tax,1);
        // //calculate total amount including tax
        // $total_cgst_tax = number_format(($pack_basic_amt * $cgst['tax_per'])/100);
        // $total_sgst_tax = number_format(($pack_basic_amt * $sgst['tax_per'])/100);
        // $discounted_amount = ($discountedamount + $total_sgst_tax + $total_cgst_tax)*1000; 

        $amt_ext_tax_paid = $this->input->post('amount_paid');
        $cgst = $this->Package_master_model->get_tax_detail('CGST');
        $sgst = $this->Package_master_model->get_tax_detail('SGST');
        $package_name       = $package_data['package_name'];
        $discountedamount  = $package_data['discounted_amount']*100;
        $pack_basic_amt = $package_data['discounted_amount'];
        $cgst_tax = ($amt_ext_tax_paid * $cgst['tax_per'])/100;
        $sgst_tax = ($amt_ext_tax_paid * $sgst['tax_per'])/100;
        $amount_paid = ($discountedamount + $sgst_tax + $cgst_tax);
        $tax_detail = json_encode(['cgst'=>$cgst['tax_per'],'sgst'=>$sgst['tax_per']]);
        // pr($sgst_tax,1);
        //calculate total amount including tax
        $total_cgst_tax = ($pack_basic_amt * $cgst['tax_per'])/100;
        $total_sgst_tax = ($pack_basic_amt * $sgst['tax_per'])/100;
        $discounted_amount = ($package_data['discounted_amount'] + $total_sgst_tax + $total_cgst_tax)*100; 
        // pr($discounted_amount,1);
        //$duration = $duration.' days';
        $startDate = $this->input->post('start_date');
        //$subscribed_on = date("Y-m-d", strtotime($this->input->post('start_date')));
        $subscribed_on = date("d-m-Y", strtotime($this->input->post('start_date')));
        $datee=date_create($subscribed_on);
        date_add($datee,date_interval_create_from_date_string($duration));
        $expired_on = date_format($datee,"d-m-Y");
        $order_id = time().$this->_getorderTokens(6);
        //getting pack profile
        $pack_test_module_id= $package_data['test_module_id'];
        $pack_programe_id= $package_data['programe_id'];

        //$pack_category_id= $package_data['category_id'];
        $package_category_data= $this->Package_master_model->getPackCategoryId($package_id);
        foreach ($package_category_data as $pc) {
            $pack_category_id .= $pc['category_id'].',';
        }
        $pack_category_id = rtrim($pack_category_id, ',');

        $batch_id= $this->input->post('batch_id');
        $pack_center_id=$package_data['center_id'];
        $findClassroom = $this->Classroom_model->findClassroom($pack_test_module_id,$pack_programe_id,$pack_category_id,$batch_id,$pack_center_id);
        $classroom_id=$findClassroom['id'];

        $discount_type = $this->input->post('discount_type');        
        if($discount_type=='Waiver'){
            $other_discount = 0;
            $updateWaiver = 1;
            $waiver = $this->input->post('waiver');
            if($waiver==''){$waiver=0;}else{$waiver =$waiver*100;}
        }elseif($discount_type=='Discount'){
            $waiver = 0;
            $updateWaiver = 0;
            $other_discount = $this->input->post('other_discount');
            if($other_discount==''){$other_discount=0;}else{$other_discount =$other_discount*100;}
        }elseif($discount_type=='None'){
            $updateWaiver = 0;
            $waiver = 0; $other_discount = 0;
        }else{
            $updateWaiver = 0;
            $waiver = 0; $other_discount = 0;
        }    
        
        
        $amount_payable = $this->input->post('amount_payable',TRUE);//$this->input->post('amount_paid');
        if($amount_paid==''){$amount_paid=0;}else{$amount_paid =$amount_paid*100;}
        $amt_ext_tax_paid_m = $amt_ext_tax_paid * 100;
        $amount_due = ($package_data['discounted_amount']*100)-($amt_ext_tax_paid_m+$waiver+$other_discount);//+$other_discount
        // pr($amount_due,1);
        if($amount_due<=0){
            $amount_due=0;
        }
        if($discounted_amount<$waiver){
            $actually_used_amount = $discounted_amount/100;
        }elseif($discounted_amount==$waiver){
            $actually_used_amount = $waiver/100;
        }else{
            $actually_used_amount=$waiver/100;
        }

        if($this->input->post('tran_id')!=''){
            $tran_id =$this->input->post('tran_id');
        }else{
            $tran_id=NULL;
        } 
        if(!file_exists(PAYMENT_SCREENSHOT_FILE_PATH_ONLINE)){
            mkdir(PAYMENT_SCREENSHOT_FILE_PATH_ONLINE, 0777, TRUE);
        }           
        $config['upload_path']      = PAYMENT_SCREENSHOT_FILE_PATH_ONLINE;
        $config['allowed_types']    = PAYMENT_SCREENSHOT_TYPES;
        $config['encrypt_name']     = FALSE; 
        $this->upload->initialize($config);        
        $this->load->library('upload',$config);
        if($this->upload->do_upload("payment_file")){
            $data = array('upload_data' => $this->upload->data());
            $payment_file= $data['upload_data']['file_name'];
        }else{ $payment_file='';}            
        if($amount_due>0){            
            $due_commitment_date=strtotime($this->input->post('due_commitment_date'));
        }else{$due_commitment_date='';}
            //wallet case: start
            $use_wallet = $this->input->post('use_wallet_on');
                if($use_wallet and $amount_due>0){
                    
                    $walletData = $this->Student_model->getWalletAmount($sid);
                    $wallet     = $walletData['wallet'];
                    if($amount_due<=$wallet){
                       
                       $finalWalletAmount = $wallet-$amount_due;//1099-1099=0
                       $amount_due = 0;
                       $paidBywallet =  $wallet- $finalWalletAmount;                  

                    }elseif($amount_due>$wallet){

                       $finalWalletAmount = 0;
                       $amount_due = $amount_due-$wallet;
                       $paidBywallet =  $wallet- $finalWalletAmount;

                    }else{
                        $finalWalletAmount = 0;
                        $amount_due = 0;
                        $paidBywallet =  $wallet- $finalWalletAmount;
                    }
                    $updateWallet = $this->Student_model->update_student_wallet_payment($sid,$finalWalletAmount);
                    if($paidBywallet>0){
                        $withdrawlData= array(
                            'student_id'=> $sid,
                            'withdrawl_method'=> AUTO,
                            'withdrawl_amount'=> $paidBywallet,
                            'remarks'=> 'Auto Deduction for Online pack',
                            'by_user'=> $by_user,
                        );
                        $this->Student_model->add_withdrawl($withdrawlData);
                    }                    
                    
                }else{                   
                    $wallet=0;
                    $paidBywallet=0;
                }            
            //Wallet case: end
            $mobile= $this->input->post('mobile', TRUE);
            $country_code= $this->input->post('country_code_hidden', TRUE);
            if($due_commitment_date==0){
                $due_commitment_date='';
            }
            //promocode get start//
                /*$promoCodeId = $this->input->post('promoCodeId_val');
                $bulk_id = $this->input->post('bulk_id');
                $bulk_promoCodeId = $this->input->post('bulk_promoCodeId_val');

                if($other_discount>0 and $promoCodeId and !$bulk_id){                
                    $getPromocode = $this->Discount_model->getPromocode($promoCodeId);
                    $discount_code = $getPromocode['discount_code'];
                }else if($other_discount>0 and $bulk_id and $bulk_promoCodeId){                
                    $getPromocode = $this->Discount_model->getBulkPromocode($bulk_id,$promoCodeId);
                    $discount_code = $getPromocode['discount_code'];
                }else{
                    $discount_code = NULL;
                }*/
            //promocode get end//
            $subscribed_on_t= strtotime($subscribed_on);
            $today=date("d-m-Y");
            $today=strtotime($today);
            if($subscribed_on_t>$today){
                $active = 0;
                $packCloseReason = 'Have to be start';
            }else{
                $active = 1;
                $packCloseReason = NULL;
            }
            $params2 = array(
                'student_id'    => $sid,
                'package_id'    => $this->input->post('package_id', TRUE), 
                'package_name'  => $package_name,
                'test_module_id'=> $pack_test_module_id,                
                'programe_id'   => $pack_programe_id,
                'category_id'   => $pack_category_id,
                'center_id'     => ONLINE_BRANCH_ID,
                'batch_id'      => $batch_id,
                'country_code'  => $country_code,
                'contact'       => $mobile,
                'email'         => $this->input->post('email', TRUE),
                'pack_type'     => 'online',  
                'classroom_id'  => $classroom_id,                            
                'payment_id'    => 'pay_'.$order_id,
                'order_id'      => $order_id,
                'amount'        => $discountedamount,
                'cgst_amt'      => $cgst_tax*100,
                'sgst_amt'      => $sgst_tax*100,
                'total_amt'     => $discounted_amount*100,
                'tax_detail'    =>$tax_detail,
                'waiver_by'     => $this->input->post('waiver_by', TRUE),
                'other_discount'=> $other_discount,
                'promocode_used'=> $discount_code,
                'waiver'        => $actually_used_amount*100,
                'amount_paid'   =>($amount_payable)*100,
                'amount_due'    => $amount_due,
                'amount_paid_by_wallet' => $paidBywallet,
                'package_duration'=>$dt,
                'tran_id'       => $tran_id,
                'payment_file'  => $payment_file,
                'due_commitment_date'=> $due_commitment_date,
                'currency'      => CURRENCY,
                'status'        => 'succeeded',
                'captured'      => 1, 
                'method'        => $this->input->post('method', TRUE),
                'by_user'       => $by_user,
                'active'        => $active,
                'packCloseReason'=> $packCloseReason,
                'enrolledBy'    => $by_user,
                'enrolledBy_homeBranch' => $enrolledBy_homeBranch,
                'subscribed_on' => $subscribed_on,
                'subscribed_on_str' => strtotime($subscribed_on),
                'expired_on'    => $expired_on,
                'expired_on_str' => strtotime($expired_on).' +24 hours',
                'requested_on' => date("d-m-Y h:i:s A"),
                'total_paid_ext_tax'=>$amt_ext_tax_paid*100
            );
            // pr($params2,1);
            $this->db->insert('student_package', $params2);
            $student_package_id =  $this->db->insert_id();
            //promocode updation start// 
            /*if($other_discount>0 and $promoCodeId and !$bulk_id){
                $promo_params = array('student_id'=> $sid, 'promoCodeId'=>$promoCodeId,'by_user'=>$by_user);
                $this->db->insert('student_promocodes', $promo_params);
                $this->Discount_model->update_remaining_uses($promoCodeId);
            }else if($other_discount>0 and $bulk_id and $bulk_promoCodeId){
                $promo_params = array('student_id'=> $sid, 'promoCodeId'=>$bulk_promoCodeId,'bulk_id'=>$bulk_id, 'by_user'=>$by_user);
                $this->db->insert('student_promocodes', $promo_params);
                $this->Discount_model->update_bulk_remaining_uses($bulk_id,$bulk_promoCodeId);
            }else{

            }*/
            //promocode updation end//

            if($use_wallet && $paidBywallet>0){

                $remarks1 = "Initial payment and with Wallet worth: Rs. ".$paidBywallet/100;
                if($discount_type=='Waiver' and $waiver>0){
                    $remarks2 = " Waiver worth Rs. ".number_format($actually_used_amount,2);
                }elseif($discount_type=='Discount' and $other_discount>0){
                    $remarks2=" Promo Discount worth Rs. ".number_format($other_discount/100,2);
                }elseif($discount_type=='None'){
                    $remarks2 = '';
                }else{
                    $remarks2 = '';
                }

            }else{

                $remarks1 = "Initial payment (Incl. Tax) CGST@".$cgst['tax_per'].' - '.CURRENCY.' '.$cgst_tax.' SGST@'.$sgst['tax_per'].'-'.CURRENCY.' '.$sgst_tax;
                if($discount_type=='Waiver' and $waiver>0){
                    $remarks2 = " Waiver worth Rs. ".number_format($actually_used_amount,2);
                }elseif($discount_type=='Discount' and $other_discount>0){
                    $remarks2=" Promo Discount worth Rs. ".number_format($other_discount/100,2);
                }elseif($discount_type=='None'){
                    $remarks2 = '';
                }else{
                    $remarks2 = '';
                }
            }
            $remarks  =  $remarks1.' | '.$remarks2;
            $params3 = array(                    
                'student_package_id'=> $student_package_id,
                'remarks'           => $remarks,
                'amount'            => ($amt_ext_tax_paid+$paidBywallet)*100, 
                'cgst_amt'          => $cgst_tax*100,
                'sgst_amt'          => $sgst_tax*100,
                'total_amt'         => $amount_payable*100,
                'tax_detail'        => $tax_detail,                     
                'student_id'        => $sid,
                'type'              => '+',
                'by_user'           => $by_user,
                'created'           => date("d-m-Y h:i:s A"),
                 'modified'          => date("d-m-Y h:i:s A"),
            );
            // pr($params3,1);
            $idd2 = $this->Student_package_model->update_transaction($params3);
            if($wid and $updateWaiver==1){
                $params4 = array('active'=>0,'actually_used_amount'=>$actually_used_amount);
                $idd3 = $this->Waiver_model->update_waiver_request($wid,$params4);
            }

            ///////////////////status update/////////////////////////
            if($params2['amount_paid']<=500 and $params2['amount_paid']>0){
                $service_id=REGISTRATION_COACHING;                
            }elseif($params2['amount_paid']==0){
                $service_id=WAIVED_OFF_SERVICE_ID;
            }else{
                $service_id=ENROLL_SERVICE_ID;
            }            
            $pack_cb='online';
            $center_id= $params2['center_id'];            
            $test_module_id = $params2['test_module_id'];
            $programe_id = $params2['programe_id'];
            $studentStatus = $this->_calculateStatus($service_id,$center_id,$test_module_id,$programe_id,$pack_cb);
            $student_identity = $studentStatus['student_identity'];
            $details = $studentStatus['details'];
            $params3 = array(
                'student_identity'=> $student_identity,
                'service_id'     => $service_id,
                'fresh'          => 2,
            );          
            $params4 =array('student_id'=>$sid, 'student_identity'=> $student_identity,'details'=> $details,'by_user'=>$by_user);
            $idd = $this->Student_model->update_student($sid,$params3);
            $std_journey=$this->Student_journey_model->update_studentJourney($params4);

            $get_UID = $this->Student_model->get_UID($sid);
            $UID = $get_UID['UID'];
            $PLAIN_PWD = $get_UID['plain_pwd'];
            //activity update start
            $activity_name = SOLD_ONLINE_PACK;
            $description = 'Sold Online pack to student '.$UID.' ';
            $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
            //activity update end

            
            
            //////////////////status update end/////////////////////////
            $getTestName = $this->Test_module_model->getTestName($pack_test_module_id);
            $getProgramName = $this->Programe_master_model->getProgramName($pack_programe_id);
            $getBatchName = $this->Batch_master_model->getBatchName($batch_id);
            $get_centerName = $this->Center_location_model->get_centerName($pack_center_id);

            if(isset($mail_sent))
            {
                $mailData                   = $this->Student_model->getMailData($student_package_id);
                // $subject = 'Dear User, your package subscribed successfully at '.COMPANY.'';
                // $email_message='Your package subscribed successfully at '.COMPANY.' details are as below:';
                $email_content = package_purchase($mailData['package_name']);
                $subject = $email_content['subject'];
                $email_message = $email_content['content'];
                $mailData['email_footer_content'] = $email_content['email_footer_content'];
                $mailData['email_message']  = $email_message;
                $mailData['cgst_per']  = $cgst['tax_per'];
                $mailData['sgst_per']  = $sgst['tax_per'];
                // $mailData['cgst_amt']  = $cgst_tax;
                // $mailData['sgst_amt']  = $sgst_tax;
                $mailData['test_module_name']= $getTestName['test_module_name'];
                $mailData['programe_name']  = $getProgramName['programe_name'];
                $mailData['batch_name']     = $getBatchName['batch_name'];
                $mailData['center_name']    = $get_centerName['center_name'];
                $mailData['thanks']         = THANKS;
                $mailData['team']           = WOSA;
                if(base_url()!=BASEURL){
                    $this->sendEmailTostd_packsubs_($subject,$mailData);
                    //$this->_call_smaGateway($this->input->post('mobile'),PACK_SUBSCRIPTION_SMS);
                }
            }else{ /*do nothing*/ }
            
            $paack_type = ($country_code == '+91' || $country_code == '91')?'0':'1';
            $fetch_fourmodule_pack_id=fetch_fourmodule_pack_id($getTestName['test_module_name'],$getProgramName['programe_name'],$paack_type);         
        
        $params = array(                          
            "pack_id"=>$fetch_fourmodule_pack_id,            
        );
        $headers1 = array(
            'username'=>$mailData['UID'],
            'action'=>'checkUser',            
            );
        $param_base = $this->_fourmoduleapi__bind_params();
        $params_fourmodule =array_merge($param_base,$headers1);
        $identify_api= $this->_identify_fourmoduleapi($params_fourmodule,$params);
        
        $usrfulname = $mailData['fname'].' '. $mailData['lname'];              
       // 1=Enrollment api   2=Re-Enrollment api 3=Add-program api
      if(isset($identify_api))
      {
        // $param_base = $this->_fourmoduleapi__bind_params();
        $params = array(      
                    "pack_id"=>$fetch_fourmodule_pack_id,                                     
                    "name"=>$usrfulname,                                        
                    "token"=>$UID,                                        
                    "start_date"=>$mailData['subscribed_on'],                                        
                    "end_date"=>$mailData['expired_on'], 
                    "username"=>$UID,
                    "password"=>$PLAIN_PWD,                                        
                    );   
        $params_fourmodule = $this->__setFourmoduleapi($identify_api,$params);      
        $response_fourmodule=$this->_curPostData_fourmodules(FOURMODULE_URL, $this->headers_fourmodule, $params_fourmodule); 
        // pr($response_fourmodule,1);
        $response_fourmodule_p=json_decode($response_fourmodule);
        $response_fourmodule_success_status=$response_fourmodule_p->success;
        } else {
            $response_fourmodule_p='';
            $response_fourmodule_success_status='0';
            $identify_api=0;
        } 
        $params_fourmoduleh=json_encode($params_fourmodule);
        $params_fourmodule = array(       
            "fourmodule_status"=>$response_fourmodule_success_status,                 
            "fourmodule_response"=>$response_fourmodule,                 
            "fourmodule_api_called"=>$identify_api,                                         
            "fourmodule_json"=>$params_fourmoduleh,                                         
            );
           // echo $student_package_id; 
         //  print_r($params_fourmodule);
        $this->Student_model->updateFourmoduleStatus($student_package_id,$params_fourmodule);  
            
    }
    //formodule api function

    

    //non-real function
    function sell_practice_pack_($wid,$package_id,$sid,$mail_sent,$offlineCount,$onlineCount,$ppCount,$enrolledBy_homeBranch)
    {
        
        $discount_code = null;
        $centerCode = null;
        $batch_id= null;$pack_center_id  = null; 

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='sell_practice_pack_';        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        $this->load->helper('foumodule_api_helper');
        $package_data  = $this->Practice_package_model->get_package($package_id); 
        $duration      = $package_data['duration'];
        $duration_type = $package_data['duration_type_name'];
        $duration      = $package_data['duration'];
        $pack_center_id = $package_data['center_id'];
        
        $dt = $duration.' '.$duration_type;        
        
        if($duration_type=='Day'){
            $duration = $duration;
        }elseif($duration_type=='Week'){
           $duration = $duration*7;                
        }elseif($duration_type=='Month'){
           $duration = $duration*30;                
        }else{
           $duration = 0;
        }
        if($duration >0){
        $duration=$duration-1;
           //$duration=$duration;
        }      
        $duration = $duration.' days';
        // $amt_ext_tax_paid = $this->input->post('amount_paid_pp')*100;
        // $cgst = $this->Package_master_model->get_tax_detail('CGST');
        // $sgst = $this->Package_master_model->get_tax_detail('SGST');
        
        $package_name       = $package_data['package_name'];
        // $discountedamount  = $package_data['discounted_amount']*100;
        // $pack_basic_amt = $package_data['discounted_amount'];
        // $cgst_tax = number_format(($amt_ext_tax_paid * $cgst['tax_per'])/100)*100;
        // $sgst_tax = number_format(($amt_ext_tax_paid * $sgst['tax_per'])/100)*100;
        // $discounted_amount = ($discountedamount + $sgst_tax + $cgst_tax); 
        $amt_ext_tax_paid = $this->input->post('amount_paid_pp');
        $cgst = $this->Package_master_model->get_tax_detail('CGST');
        $sgst = $this->Package_master_model->get_tax_detail('SGST');
        $package_name       = $package_data['package_name'];
        $discountedamount  = $package_data['discounted_amount']*100;
        $pack_basic_amt = $package_data['discounted_amount'];
        $cgst_tax = ($amt_ext_tax_paid * $cgst['tax_per'])/100;
        $sgst_tax = ($amt_ext_tax_paid * $sgst['tax_per'])/100;
        $amount_paid = ($discountedamount + $sgst_tax + $cgst_tax);
        $tax_detail = json_encode(['cgst'=>$cgst['tax_per'],'sgst'=>$sgst['tax_per']]);
        //calculate total amount including tax
        $total_cgst_tax = ($pack_basic_amt * $cgst['tax_per'])/100;
        $total_sgst_tax = ($pack_basic_amt * $sgst['tax_per'])/100;
        $discounted_amount = ($package_data['discounted_amount'] + $total_sgst_tax + $total_cgst_tax)*100; 
        // pr($cgst_tax,1);
       // $duration = $duration.' days';
        $subscribed_on = date("d-m-Y", strtotime($this->input->post('start_date_pp')));
        $datee=date_create($subscribed_on);
        date_add($datee,date_interval_create_from_date_string($duration));
        $expired_on = date_format($datee,"d-m-Y");
        $order_id = time().$this->_getorderTokens(6);
        //getting pack profile
        $pack_test_module_id= $package_data['test_module_id'];
        $pack_programe_id= $package_data['programe_id'];
        //$pack_category_id= $package_data['category_id']; //N/A        

        $discount_type = $this->input->post('discount_type_pp');        
        if($discount_type=='Waiver'){
            $other_discount = 0;
            $updateWaiver = 1;
            $waiver = $this->input->post('waiver_pp');
            if($waiver==''){$waiver=0;}else{$waiver =$waiver*100;}
        }elseif($discount_type=='Discount'){
            $waiver = 0;
            $updateWaiver = 0;
            $other_discount = $this->input->post('other_discount_pp', TRUE);
            if($other_discount==''){$other_discount=0;}else{$other_discount =$other_discount*100;}
        }elseif($discount_type=='None'){
            $updateWaiver = 0;
            $waiver = 0; $other_discount = 0;
        }else{
            $updateWaiver = 0;
            $waiver = 0; $other_discount = 0;
        }        
        
        $amount_payable = $this->input->post('amount_payable_pp',TRUE);////$this->input->post('amount_paid_pp', TRUE);
        if($amount_paid==''){$amount_paid=0;}else{$amount_paid =$amount_paid*100;} 
        //$amount_due = $discounted_amount-($amount_paid+$waiver+$other_discount);
        // $amount_due = $package_data['discounted_amount']-$amt_ext_tax_paid;
        $amt_ext_tax_paid_m = $amt_ext_tax_paid*100;
        $amount_due = ($package_data['discounted_amount']*100)-($amt_ext_tax_paid_m+$waiver+$other_discount);//+$other_discount
        // pr($amount_due,1);
        if($amount_due<=0){
            $amount_due=0;
        }
        if($discounted_amount<$waiver){
            $actually_used_amount = $discounted_amount/100;
        }elseif($discounted_amount==$waiver){
            $actually_used_amount = $waiver/100;
        }else{
            $actually_used_amount=$waiver/100;
        }

        if($this->input->post('tran_id_pp')!=''){
            $tran_id =$this->input->post('tran_id_pp');
        }else{
            $tran_id=NULL;
        } 
        if(!file_exists(PAYMENT_SCREENSHOT_FILE_PATH_PP)){
            mkdir(PAYMENT_SCREENSHOT_FILE_PATH_PP, 0777, TRUE);
        }          
        $config['upload_path']      = PAYMENT_SCREENSHOT_FILE_PATH_PP;
        $config['allowed_types']    = PAYMENT_SCREENSHOT_TYPES;
        $config['encrypt_name']     = FALSE;  
        $this->upload->initialize($config);       
        $this->load->library('upload',$config);
        if($this->upload->do_upload("payment_file_pp")){
            $data = array('upload_data' => $this->upload->data());
            $payment_file= $data['upload_data']['file_name'];
        }else{ $payment_file='';}            
        if($amount_due>0){
            $due_commitment_date=strtotime($this->input->post('due_commitment_date_pp'));
        }else{$due_commitment_date='';}
        
        // $amount_due = $discounted_amount-($amount_paid+$waiver+$other_discount);
        //wallet case: start
            $use_wallet = $this->input->post('use_wallet_pp');
                if($use_wallet and $amount_due>0){
                    
                    $walletData = $this->Student_model->getWalletAmount($sid);
                    $wallet     = $walletData['wallet'];
                    if($amount_due<=$wallet){
                       
                       $finalWalletAmount = $wallet-$amount_due;//1099-1099=0
                       $amount_due = 0;
                       $paidBywallet =  $wallet- $finalWalletAmount;                  

                    }elseif($amount_due>$wallet){

                       $finalWalletAmount = 0;
                       $amount_due = $amount_due-$wallet;
                       $paidBywallet =  $wallet- $finalWalletAmount;

                    }else{
                        $finalWalletAmount = 0;
                        $amount_due = 0;
                        $paidBywallet =  $wallet- $finalWalletAmount;
                    }
                    $updateWallet = $this->Student_model->update_student_wallet_payment($sid,$finalWalletAmount);
                    if($paidBywallet>0){
                        $withdrawlData= array(
                            'student_id'=> $sid,
                            'withdrawl_method'=> AUTO,
                            'withdrawl_amount'=> $paidBywallet,
                            'remarks'=> 'Auto Deduction for practice pack',
                            'by_user'=> $by_user,
                        );
                        $this->Student_model->add_withdrawl($withdrawlData);
                    }
                    
                }else{                   
                    $wallet=0;
                    $paidBywallet=0;
                }            
            // Wallet case: end
            $mobile= $this->input->post('mobile', TRUE);
            $country_code= $this->input->post('country_code_hidden', TRUE);
            if($due_commitment_date==0){
                $due_commitment_date='';
            }
            //promocode get start//
                /*$promoCodeId = $this->input->post('promoCodeId_val');
                $bulk_id = $this->input->post('bulk_id');
                $bulk_promoCodeId = $this->input->post('bulk_promoCodeId_val');

                if($other_discount>0 and $promoCodeId and !$bulk_id){                
                    $getPromocode = $this->Discount_model->getPromocode($promoCodeId);
                    $discount_code = $getPromocode['discount_code'];
                }else if($other_discount>0 and $bulk_id and $bulk_promoCodeId){                
                    $getPromocode = $this->Discount_model->getBulkPromocode($bulk_id,$promoCodeId);
                    $discount_code = $getPromocode['discount_code'];
                }else{
                    $discount_code = NULL;
                }*/
            //promocode get end//
            $subscribed_on_t= strtotime($subscribed_on);
            $today=date("d-m-Y");
            $today=strtotime($today);
            if($subscribed_on_t>$today){
                $active = 0;
                $packCloseReason = 'Have to be start';
            }else{
                $active = 1;
                $packCloseReason = NULL;
            }
            $params2 = array(
                'student_id'    => $sid,
                'package_id'    => $this->input->post('package_id_pp', TRUE),
                'test_module_id'=> $pack_test_module_id,
                'programe_id'   => $pack_programe_id,                
                'center_id'     => ONLINE_BRANCH_ID,
                'country_code'  => $country_code,
                'contact'       => $mobile,
                'email'         => $this->input->post('email', TRUE),                                
                'pack_type'     => 'practice',                
                'payment_id'    => 'pay_'.$order_id,
                'order_id'      => $order_id,
                'tran_id'       => $tran_id,
                'amount'        => $discountedamount,
                'cgst_amt'      => $cgst_tax*100,
                'sgst_amt'      => $sgst_tax*100,
                'total_amt'     => $discounted_amount,
                'tax_detail'    =>$tax_detail,
                'amount_paid_by_wallet' => $paidBywallet,
                'waiver_by'     => $this->input->post('waiver_by_pp', TRUE),
                'other_discount'=> $other_discount,
                'promocode_used'=> $discount_code,
                'waiver'        => $actually_used_amount*100,
                'amount_paid'   => $amount_payable*100,
                'amount_due'    => $amount_due,                
                'payment_file'  => $payment_file,
                'due_commitment_date'=> $due_commitment_date,
                'currency'      => CURRENCY,
                'status'        => 'succeeded',
                'captured'      => 1, 
                'method'        => $this->input->post('method_pp', TRUE),
                'by_user'       => $by_user,
                'active'        => $active,
                'packCloseReason'=> $packCloseReason,
                'enrolledBy'    => $by_user,
                'enrolledBy_homeBranch' => $enrolledBy_homeBranch,
                'subscribed_on' => $subscribed_on,
                'subscribed_on_str' => strtotime($subscribed_on),
                'expired_on'    => $expired_on,
                'expired_on_str' => strtotime($expired_on).' +24 hours',
                'package_name'    => $package_name,
                'package_duration'=>$dt,
                'requested_on' => date("d-m-Y h:i:s A"),
                'total_paid_ext_tax'=>$amt_ext_tax_paid*100
            );   
            // pr($params2,1);    
        $this->db->insert('student_package', $params2);
        $student_package_id =  $this->db->insert_id();
        //promocode updation start//
            /*if($other_discount>0 and $promoCodeId and !$bulk_id){
                $promo_params = array('student_id'=> $sid, 'promoCodeId'=>$promoCodeId,'by_user'=>$by_user);
                $this->db->insert('student_promocodes', $promo_params);
                $this->Discount_model->update_remaining_uses($promoCodeId);
            }else if($other_discount>0 and $bulk_id and $bulk_promoCodeId){
                $promo_params = array('student_id'=> $sid, 'promoCodeId'=>$bulk_promoCodeId,'bulk_id'=>$bulk_id, 'by_user'=>$by_user);
                $this->db->insert('student_promocodes', $promo_params);
                $this->Discount_model->update_bulk_remaining_uses($bulk_id,$bulk_promoCodeId);
            }else{

            }*/
        //promocode updation end//
        if($use_wallet and $paidBywallet>0){

            $remarks1 = "Initial payment and with Wallet worth: Rs. ".$paidBywallet/100;
            if($discount_type=='Waiver' && $waiver>0){
                $remarks2 = " Waiver worth Rs. ".number_format($actually_used_amount,2);
            }elseif($discount_type=='Discount' && $other_discount>0){
                $remarks2 = " Promo Discount worth Rs. ".number_format($other_discount/100,2);
            }elseif($discount_type=='None'){
                $remarks2 = '';
            }else{
                $remarks2 = '';
            }

        }else{

            $remarks1 = "Initial payment (Incl. Tax) CGST@".$cgst['tax_per'].' - '.CURRENCY.' '.$cgst_tax.' SGST@'.$sgst['tax_per'].'-'.CURRENCY.' '.$sgst_tax;
            if($discount_type=='Waiver' && $waiver>0){
                $remarks2 = " Waiver worth Rs. ".number_format($actually_used_amount,2);
            }elseif($discount_type=='Discount' && $other_discount>0){
                $remarks2 = " Promo Discount worth Rs. ".number_format($other_discount/100,2);
            }elseif($discount_type=='None'){
                $remarks2 = '';
            }else{
                $remarks2 = '';
            }
        }
        $remarks  =  $remarks1.' | '.$remarks2;
        $params3 = array(                    
            'student_package_id'=> $student_package_id,
            'remarks'           => $remarks,
            'amount'            => ($amt_ext_tax_paid+$paidBywallet)*100, 
            'cgst_amt'          => $cgst_tax*100,
            'sgst_amt'          => $sgst_tax*100,
            'total_amt'         => $amount_payable*100,
            'tax_detail'        => $tax_detail,                 
            'student_id'        => $sid,
            'type'              => '+',
            'by_user'           => $by_user,
            'created'           => date("d-m-Y h:i:s A"),
            'modified'          => date("d-m-Y h:i:s A"),
        );
        $idd2 = $this->Student_package_model->update_transaction($params3);
        if($wid and $updateWaiver==1){
            $params4 = array('active'=>0,'actually_used_amount'=>$actually_used_amount);
            $idd3 = $this->Waiver_model->update_waiver_request($wid,$params4);
        }
        ///////////////////status update/////////////////////////
        $service_id=ACADEMY_SERVICE_REGISTRATION_ID;        
        $pack_cb='practice';
        $center_id= $params2['center_id'];
        $center_name = (isset($centerCode['center_name']) && $centerCode['center_name']!='') ? $centerCode['center_name']:'';
        $test_module_id = $params2['test_module_id'];
        $programe_id = $params2['programe_id'];
        $studentStatus = $this->_calculateStatus($service_id,$center_id,$test_module_id,$programe_id,$pack_cb);
        $student_identity = $studentStatus['student_identity'];
        $details = $studentStatus['details'];
        
        if($offlineCount==0 or $onlineCount==0){            
            $params3 = array(
                'student_identity'=> $student_identity,
                'service_id'     => $service_id,
                'fresh'          => 2,
                'center_id'=> $center_id
            );
            $params4 = array('student_id'=>$sid, 'student_identity'=> $student_identity,'details'=> $details,'by_user'=>$by_user);                                
            $idd = $this->Student_model->update_student($sid,$params3);
            $std_journey = $this->Student_journey_model->update_studentJourney($params4);
        }else{            
            $params4 = array('student_id'=>$sid, 'student_identity'=> $student_identity,'details'=> $details,'by_user'=>$by_user);
            $std_journey=$this->Student_journey_model->update_studentJourney($params4);
        }
        //$datas['student_id']
        $get_UID = $this->Student_model->get_UID($sid);
        $UID = $get_UID['UID'];
        $PLAIN_PWD = $get_UID['plain_pwd'];
        //activity update start
            $activity_name = SOLD_PRACTICE_PACK;
            $description = 'Practice pack sold to student '.$UID.' ';
            $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
        //activity update end
        $getTestName = $this->Test_module_model->getTestName($pack_test_module_id);
        $getProgramName = $this->Programe_master_model->getProgramName($pack_programe_id);        
        $get_centerName = $this->Center_location_model->get_centerName($pack_center_id);        
        //////////////////status update end///////////////////////// 
        // $subject = 'Dear User, your package subscribed successfully at '.COMPANY.'';
        // $email_message='Your package subscribed successfully at '.COMPANY.' details are as below:';
        $mailData                   = $this->Student_model->getMailData_pp($student_package_id);
        $email_content = package_purchase($mailData['package_name']);
        $subject = $email_content['subject'];
        $email_message = $email_content['content'];
        $mailData['email_message']  = $email_message;
        $mailData['cgst_per']  = $cgst['tax_per'];
        $mailData['sgst_per']  = $sgst['tax_per'];
        $mailData['cgst_amt']  = $cgst_tax;
        $mailData['sgst_amt']  = $sgst_tax;
        $mailData['test_module_name']= $getTestName['test_module_name'];
        $mailData['programe_name']  = $getProgramName['programe_name'];
        $mailData['center_name']    = $get_centerName['center_name'];
        $mailData['thanks']         = THANKS;
        $mailData['team']           = WOSA;
        if(base_url()!=BASEURL){
            $this->sendEmailTostd_packsubs_($subject,$mailData);
            //$this->_call_smaGateway($this->input->post('mobile'),PACK_SUBSCRIPTION_SMS);
        }
        // fourmodule api start---
        
        if($country_code == "+91")
        {
            $set_pack_type=0; // for india
        }
        else {
            $set_pack_type=1; // for other countries
        }
        // $fetch_fourmodule_pack_id=fetch_fourmodule_pack_id($getTestName['test_module_name'],$getProgramName['programe_name'],$set_pack_type);         
        
        // $headers1 = array(
        // 'API-KEY:'.WOSA_API_KEY, 
        // 'STUDENT-ID:'.$sid,                           
        // 'TEST-MODULE-ID:'.$pack_test_module_id,            
        // 'PROGRAME-ID:'.$pack_programe_id,            
        // );
        // $identify_api= json_decode($this->_curlGetData(base_url(IDENTIFY_FOURMODULE_API), $headers1));                
       // 1=Enrollment api   2=Re-Enrollment api 3=Add-program api
       //$fetch_fourmodule_pack_id=fetch_fourmodule_pack_id($getTestName['test_module_name'],$getProgramName['programe_name'],$set_pack_type);     
        
        $paack_type = ($country_code == '+91' || $country_code == '91')?'0':'1';
        $fetch_fourmodule_pack_id=fetch_fourmodule_pack_id($getTestName['test_module_name'],$getProgramName['programe_name'],$paack_type);         
                
                $params = array(                          
                    "pack_id"=>$fetch_fourmodule_pack_id,            
                );
                $headers1 = array(
                    'username'=>$mailData['UID'],
                    'action'=>'checkUser',            
                    );
                $param_base = $this->_fourmoduleapi__bind_params();
                $params_fourmodule =array_merge($param_base,$headers1);
                $identify_api= $this->_identify_fourmoduleapi($params_fourmodule,$params);
                
                $usrfulname = $mailData['fname'].' '. $mailData['lname'];              
                // 1=Enrollment api   2=Re-Enrollment api 3=Add-program api
                if(isset($identify_api))
                {
                // $param_base = $this->_fourmoduleapi__bind_params();
                $params = array(      
                            "pack_id"=>$fetch_fourmodule_pack_id,                                     
                            "name"=>$usrfulname,                                        
                            "token"=>$UID,                                        
                            "start_date"=>$mailData['subscribed_on'],                                        
                            "end_date"=>$mailData['expired_on'], 
                            "username"=>$UID,
                            "password"=>$PLAIN_PWD,                                        
                            );   
                $params_fourmodule = $this->__setFourmoduleapi($identify_api,$params);      
                $response_fourmodule=$this->_curPostData_fourmodules(FOURMODULE_URL, $this->headers_fourmodule, $params_fourmodule); 
                // pr($response_fourmodule,1);
                $response_fourmodule_p=json_decode($response_fourmodule);
                $response_fourmodule_success_status=$response_fourmodule_p->success;
                } else {
            $response_fourmodule_p='';
            $response_fourmodule_success_status='0';
        $identify_api=0;
        } 
        $params_fourmoduleh=json_encode($params_fourmodule);
        $params_fourmodule = array(       
            "fourmodule_status"=>$response_fourmodule_success_status,                 
            "fourmodule_response"=>$response_fourmodule,                 
            "fourmodule_api_called"=>$identify_api,                                         
            "fourmodule_json"=>$params_fourmoduleh,                                         
            );
           // echo $student_package_id; 
         //  print_r($params_fourmodule);
        $this->Student_model->updateFourmoduleStatus($student_package_id,$params_fourmodule);      
    // fourmodule api ends---
   
       // die();
    }  

    function sell_inhouse_pack_($wid,$package_id,$sid,$mail_sent,$enrolledBy_homeBranch){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='sell_inhouse_pack_';     
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        $this->load->model('Classroom_model');

        $package_data  = $this->Package_master_model->get_package_master($package_id);
        $duration_type = $package_data['duration_type_name'];
        $duration      = $package_data['duration'];
        $dt = $duration.' '.$duration_type;        
        
        if($duration_type=='Day'){
            $duration = $duration;
        }elseif($duration_type=='Week'){
           $duration = $duration*7;                
        }elseif($duration_type=='Month'){
           $duration = $duration*30;                
        }else{
           $duration = 0;
        }
        if($duration >0){
           $duration=$duration-1;
           //$duration=$duration;
        }      
        $duration = $duration.' days';
        $pack_category_id = null;
        $package_name     = $package_data['package_name'];
        $discounted_amount= $this->input->post('amount_payable');///$package_data['discounted_amount']*100;
        //$duration = $duration.' days';
        $startDate = $this->input->post('start_date_off');
        $subscribed_on= date("d-m-Y", strtotime($this->input->post('start_date_off')));
        $datee=date_create($subscribed_on);
        date_add($datee,date_interval_create_from_date_string($duration));
        $expired_on = date_format($datee,"d-m-Y");
        $order_id = time().$this->_getorderTokens(6);
        //getting pack profile
        $pack_test_module_id= $package_data['test_module_id'];
        $pack_programe_id= $package_data['programe_id'];
        $package_category_data= $this->Package_master_model->getPackCategoryId($package_id);
        foreach ($package_category_data as $pc) {
            $pack_category_id .= $pc['category_id'].',';
        }
        $pack_category_id = rtrim($pack_category_id, ',');

        $pack_center_id= $this->input->post('center_id');
        $batch_id= $this->input->post('batch_id_off');
        $findClassroom = $this->Classroom_model->findClassroom($pack_test_module_id,$pack_programe_id,$pack_category_id,$batch_id,$pack_center_id);
        $classroom_id=$findClassroom['id'];        

        $discount_type = $this->input->post('discount_type_off', TRUE);        
        if($discount_type=='Waiver'){
            $other_discount = 0;
            $updateWaiver = 1;
            $waiver = $this->input->post('waiver_off');
            if($waiver==''){$waiver=0;}else{$waiver =$waiver*100;}            
        }elseif($discount_type=='Discount'){
            $waiver = 0;
            $updateWaiver = 0;
            $other_discount = $this->input->post('other_discount_off');
            if($other_discount==''){$other_discount=0;}else{$other_discount =$other_discount*100;}
        }elseif($discount_type=='None'){
            $updateWaiver = 0;
            $waiver = 0; $other_discount = 0;
        }else{
            $updateWaiver = 0;
            $waiver = 0; $other_discount = 0;
        }        
        $amount_paid = $this->input->post('amount_paid_off', TRUE);
        if($amount_paid==''){$amount_paid=0;}else{$amount_paid =$amount_paid*100;} 
        $amount_due = $discounted_amount-($amount_paid+$waiver+$other_discount);
        
        if($amount_due<=0){
            $amount_due=0;
        }
        if($discounted_amount<$waiver){
            $actually_used_amount = $discounted_amount/100;
        }elseif($discounted_amount==$waiver){
            $actually_used_amount = $waiver/100;
        }else{
            $actually_used_amount=$waiver/100;
        }

        if($this->input->post('tran_id_off', TRUE)!=''){
            $tran_id =$this->input->post('tran_id_off', TRUE);
        }else{
            $tran_id=NULL;
        }
        if(!file_exists(PAYMENT_SCREENSHOT_FILE_PATH_INHOUSE)){
            mkdir(PAYMENT_SCREENSHOT_FILE_PATH_INHOUSE, 0777, TRUE);
        }           
        $config['upload_path']      = PAYMENT_SCREENSHOT_FILE_PATH_INHOUSE;
        $config['allowed_types']    = PAYMENT_SCREENSHOT_TYPES;
        $config['encrypt_name']     = FALSE; 
        $this->upload->initialize($config);        
        $this->load->library('upload',$config);
        if($this->upload->do_upload("payment_file_off")){
            $data = array('upload_data' => $this->upload->data());
            $payment_file= $data['upload_data']['file_name'];
        }else{ $payment_file='';}            
        if($amount_due>0){
            $due_commitment_date=strtotime($this->input->post('due_commitment_date_off'));
        }else{$due_commitment_date='';}            

        //wallet case: start
        $use_wallet = $this->input->post('use_wallet_off');
                if($use_wallet and $amount_due>0){
                    
                    $walletData = $this->Student_model->getWalletAmount($sid);
                    $wallet     = $walletData['wallet'];
                    if($amount_due<=$wallet){
                       
                       $finalWalletAmount = $wallet-$amount_due;
                       $amount_due = 0;
                       $paidBywallet =  $wallet- $finalWalletAmount;

                    }elseif($amount_due>$wallet){

                       $finalWalletAmount = 0;
                       $amount_due = $amount_due-$wallet;
                       $paidBywallet =  $wallet- $finalWalletAmount;

                    }else{
                        $finalWalletAmount = 0;
                        $amount_due = 0;
                        $paidBywallet =  $wallet- $finalWalletAmount;
                    }
                    $updateWallet = $this->Student_model->update_student_wallet_payment($sid,$finalWalletAmount);
                    if($paidBywallet>0){
                        $withdrawlData= array(
                            'student_id'=> $sid,
                            'withdrawl_method'=> AUTO,
                            'withdrawl_amount'=> $paidBywallet,
                            'remarks'=> 'Auto Deduction for Inhouse pack',
                            'by_user'=> $by_user,
                        );
                        $this->Student_model->add_withdrawl($withdrawlData);
                    }                    
                    
                }else{                   
                    $wallet=0;
                    $paidBywallet=0;
                }            
        // Wallet case: end
        $mobile= $this->input->post('mobile', TRUE);
        $country_code= $this->input->post('country_code_hidden', TRUE);
        if($due_commitment_date==0){
            $due_commitment_date='';
        }
        //promocode get start//
            $promoCodeId = $this->input->post('promoCodeId_val');
            $bulk_id = $this->input->post('bulk_id');
            $bulk_promoCodeId = $this->input->post('bulk_promoCodeId_val');

            if($other_discount>0 and $promoCodeId and !$bulk_id){                
                $getPromocode = $this->Discount_model->getPromocode($promoCodeId);
                $discount_code = $getPromocode['discount_code'];
            }else if($other_discount>0 and $bulk_id and $bulk_promoCodeId){                
                $getPromocode = $this->Discount_model->getBulkPromocode($bulk_id,$promoCodeId);
                $discount_code = $getPromocode['discount_code'];
            }else{
                $discount_code = NULL;
            }
        //promocode get end//
            $subscribed_on_t= strtotime($subscribed_on);
            $today=date("d-m-Y");
            $today=strtotime($today);
            if($subscribed_on_t>$today){
                $active = 0;
                $packCloseReason = 'Have to be start';
            }else{
                $active = 1;
                $packCloseReason = NULL;
            }
            $params2 = array(
                'student_id'    => $sid,
                'package_name'  => $package_name,
                'package_id'    => $this->input->post('package_id_off', TRUE),
                'test_module_id'=> $pack_test_module_id,
                'programe_id'   => $pack_programe_id,
                'category_id'   => $pack_category_id,                
                'center_id'     => $pack_center_id,
                'batch_id'      => $batch_id,
                'country_code'  => $country_code,
                'contact'       => $mobile,
                'email'         => $this->input->post('email', TRUE),
                'pack_type'     => 'offline', 
                'classroom_id'  => $classroom_id,                           
                'payment_id'    => 'pay_'.$order_id,
                'order_id'      => $order_id,
                'tran_id'       => $tran_id,
                'amount'        => $discounted_amount,
                'waiver_by'     => $this->input->post('waiver_by_off', TRUE),
                'other_discount'=> $other_discount,
                'promocode_used'=> $discount_code,
                'waiver'        => $actually_used_amount*100,
                'amount_paid'   => $amount_paid+$paidBywallet,
                'amount_paid_by_wallet' => $paidBywallet,
                'amount_due'    => $amount_due,                
                'payment_file'  => $payment_file,
                'package_duration'=> $dt,
                'due_commitment_date'=> $due_commitment_date,
                'currency'      => CURRENCY,
                'status'        => 'succeeded',
                'captured'      => 1, 
                'method'        => $this->input->post('method_off', TRUE),
                'by_user'       => $by_user,
                'active'        => $active,
                'packCloseReason'=>$packCloseReason,
                'enrolledBy'    => $by_user,
                'enrolledBy_homeBranch' => $enrolledBy_homeBranch,
                'subscribed_on' => $subscribed_on,
                'subscribed_on_str' => strtotime($subscribed_on),
                'expired_on'    => $expired_on,
                'expired_on_str' => strtotime($expired_on).' +24 hours',
                'requested_on' => date("d-m-Y h:i:s A"),
            );       
        $this->db->insert('student_package', $params2);
        $student_package_id =  $this->db->insert_id();
        //promocode updation start//
            if($other_discount>0 and $promoCodeId and !$bulk_id){
                $promo_params = array('student_id'=> $sid, 'promoCodeId'=>$promoCodeId,'by_user'=>$by_user);
                $this->db->insert('student_promocodes', $promo_params);
                $this->Discount_model->update_remaining_uses($promoCodeId);
            }else if($other_discount>0 and $bulk_id and $bulk_promoCodeId){
                $promo_params = array('student_id'=> $sid, 'promoCodeId'=>$bulk_promoCodeId,'bulk_id'=>$bulk_id, 'by_user'=>$by_user);
                $this->db->insert('student_promocodes', $promo_params);
                $this->Discount_model->update_bulk_remaining_uses($bulk_id,$bulk_promoCodeId);
            }else{
                /* do nothing */
            }
        //promocode updation end//

        if($use_wallet and $paidBywallet>0){

            $remarks1 = "Initial payment and with Wallet worth: Rs. ".$paidBywallet/100;
            if($discount_type=='Waiver' and $waiver>0){
                $remarks2 = " Waiver worth Rs. ".number_format($actually_used_amount,2);
            }elseif($discount_type=='Discount' and $other_discount>0){
                $remarks2 = " Promo Discount worth Rs. ".number_format($other_discount/100,2);
            }elseif($discount_type=='None'){
                $remarks2 = '';
            }else{
                $remarks2 = '';
            }

        }else{

            $remarks1 = "Initial payment";
            if($discount_type=='Waiver' and $waiver>0){
                $remarks2 = " Waiver worth Rs. ".number_format($actually_used_amount,2);
            }elseif($discount_type=='Discount' and $other_discount>0){
                $remarks2 = " Promo Discount worth Rs. ".number_format($other_discount/100,2);
            }elseif($discount_type=='None'){
                $remarks2 = '';
            }else{
                $remarks2 = '';
            }
        }
        $remarks  =  $remarks1.' | '.$remarks2;
        $params3 = array(                    
            'student_package_id'=> $student_package_id,
            'remarks'           => $remarks,
            'amount'            => $amount_paid+$paidBywallet,                   
            'student_id'        => $sid,
            'type'              => '+',
            'by_user'           => $by_user,
            'created'           => date("d-m-Y h:i:s A"),
            'modified'          => date("d-m-Y h:i:s A"),
        );
        $idd2 = $this->Student_package_model->update_transaction($params3);
        if($wid and $updateWaiver==1){
            $params4 = array('active'=>0,'actually_used_amount'=>$actually_used_amount);
            $idd3 = $this->Waiver_model->update_waiver_request($wid,$params4);
        }        

        ///////////////////status update/////////////////////////
            if($params2['amount_paid']<=500 and $params2['amount_paid']>0){
                $service_id=REGISTRATION_COACHING;
            }elseif($params2['amount_paid']==0){
                $service_id=WAIVED_OFF_SERVICE_ID;
            }else{
                $service_id=ENROLL_SERVICE_ID;
            }            
            $pack_cb='offline';
            $center_id= $params2['center_id'];
            $test_module_id = $params2['test_module_id'];
            $programe_id = $params2['programe_id'];
            $studentStatus = $this->_calculateStatus($service_id,$center_id,$test_module_id,$programe_id,$pack_cb);
            $student_identity = $studentStatus['student_identity'];
            $details = $studentStatus['details'];
            $params3 = array('student_identity'=> $student_identity,'service_id'=> $service_id,'fresh'=> 2);
            $params4 = array('student_id'=>$sid, 'student_identity'=>$student_identity,'details'=> $details,'by_user'=>$by_user);
            $idd = $this->Student_model->update_student($sid,$params3);
            $std_journey=$this->Student_journey_model->update_studentJourney($params4);
            
            $get_UID = $this->Student_model->get_UID($sid);
            $UID = $get_UID['UID'];         
           
            //activity update start
            $activity_name = SOLD_INHOUSE_PACK;
            $uaID = 'student_adjustment'.$student_package_id;
            $studentLink= base_url('adminController/student/student_full_details_/'.base64_encode($sid));

            $anchor_text_emp=$UID;
            $attribs_emp=array('title' => 'Go to student');
            $uri_emp = base_url('adminController/student/student_full_details_/'.base64_encode($sid));
            $empLink = anchor($uri_emp, $anchor_text_emp, $attribs_emp);

            $description = 'Inhouse pack sold to '.$empLink.' ';            
            $uri = base_url('adminController/student/adjust_online_and_inhouse_pack_/'.$student_package_id);
            $anchor_text=' | Pack link';
            $attribs=array('class' => $uaID,'title' => 'Go to pack');
            $packLink = anchor($uri, $anchor_text, $attribs);   
            $description .= $packLink;     
            $res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
            //activity update end

            //////////////////status update end/////////////////////////
           
            $getTestName = $this->Test_module_model->getTestName($pack_test_module_id);
            $getProgramName = $this->Programe_master_model->getProgramName($pack_programe_id);
            $getBatchName = $this->Batch_master_model->getBatchName($batch_id);
            $get_centerName = $this->Center_location_model->get_centerName($pack_center_id);
            if(isset($mail_sent)){
                // $subject = 'Dear User, your package subscribed successfully at '.COMPANY.'';
                // $email_message='Your package subscribed successfully at '.COMPANY.' details are as below:';
                $mailData                   = $this->Student_model->getMailData($student_package_id);
                $email_content = package_purchase($mailData['package_name']);
                $subject = $email_content['subject'];
                $email_message = $email_content['content'];
                $mailData['email_message']  = $email_message;
                $mailData['test_module_name']= $getTestName['test_module_name'];
                $mailData['programe_name']  = $getProgramName['programe_name'];
                $mailData['batch_name']     = $getBatchName['batch_name'];
                $mailData['center_name']    = $get_centerName['center_name'];
                $mailData['thanks']         = THANKS;
                $mailData['team']           = WOSA;
                if(base_url()!=BASEURL){
                    $this->sendEmailTostd_packsubs_($subject,$mailData);
                    //$this->_call_smaGateway($this->input->post('mobile'),PACK_SUBSCRIPTION_SMS); 
                }
            }else{ /*do nothing*/ }   
    }  

    //non-real function
    function updateNewDueCommittmentDate_($student_package_id,$new_due_committment_date,$student_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='updateNewDueCommittmentDate_';         
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $getCurrentDueCommittmentDate = $this->Student_package_model->getCurrentDueCommittmentDate($student_package_id);
        $currentDueCommittmentDate = $getCurrentDueCommittmentDate['due_commitment_date'];

        if($currentDueCommittmentDate!=''){
            $dcd = date('M d, y', $currentDueCommittmentDate);
        }else{
            $dcd = 'N/A';
        }

        if($currentDueCommittmentDate!=''){
            $ncd = date('M d, y', $new_due_committment_date);
        }else{
            $ncd = 'N/A';
        }
//echo $new_due_committment_date;

            $today=date("d-m-Y");
            $today=strtotime($today);
            if($new_due_committment_date>=$today){               
                $params = array(  
                    'due_commitment_date' => $new_due_committment_date,                  
                    'by_user'             => $by_user,
                    'active'             => 1,
                    'packCloseReason'             => NULL,
        
                );
            }
            else {
                $params = array(  
                    'due_commitment_date' => $new_due_committment_date,                  
                    'by_user'             => $by_user,                   
        
                );
            }

        $params2 = array(                    
            'student_package_id'=> $student_package_id,
            'amount'            => 0,
            'remarks'           => 'Due committment date changed on request FROM '.$dcd.' TO '.$ncd.' ',
            'student_id'        => $student_id,
            'type'              => '-',
            'by_user'           => $by_user,
            'created'           => date("d-m-Y h:i:s A"),
            'modified'          => date("d-m-Y h:i:s A"),
        );
        $idd1 = $this->Student_package_model->updateNewDueCommittmentDate($student_package_id,$params);
        $idd2 = $this->Student_package_model->update_transaction($params2);
        if($idd1 and $idd2){
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID'];
            //activity update start
                $activity_name= DUE_DATE_EXTENSION;
                $description='Due committment date extended FROM '.$dcd.' TO '.$ncd.' for student '.$UID.' ';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
            //activity update end              
            return 1;
        }else{
            return 0;
        }

    }

    //non-real function
    function add_payment_($add_payment,$use_wallet,$due_commitment_date,$remarks,$student_package_id,$student_id,$total_amt,$cgst_amt,$sgst_amt,$tax_arr){        
         
       //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='add_payment_';       
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $getPackExpiry = $this->Student_package_model->getPackExpiry($student_package_id);
        //$expired_on = strtotime($getPackExpiry['expired_on']);//Y-m-d 2023-01-18
        $expired_on_str = $getPackExpiry['expired_on_str'];
        $today= strtotime(date("d-m-Y"));
        if($expired_on_str>=$today){
            $packRestart=1;
            $packCloseReason=NULL;
        }else{
            $packRestart=0;
            $packCloseReason=$getPackExpiry['packCloseReason'];
        }      
        
        $walllet = $this->Student_model->getWalletAmount($student_id);
        $walletAmount=$walllet['wallet'];

        $getDues=$this->Student_package_model->getDues($student_package_id);
        $amount_due = $getDues['amount_due'];
       
        if($use_wallet){
            //use wallet case
            if($walletAmount>=$amount_due){
                $add_payment = $amount_due;
                $finalWalletAmount = $walletAmount-$amount_due;
            }else{
                $add_payment = $add_payment + $walletAmount;
                $finalWalletAmount = 0;
            }  

            if($add_payment<$amount_due){
                $this->form_validation->set_rules('due_commitment_date_next','Due committment date','required');
            }
            $params = array(                    
                // 'add_payment'   => $add_payment,
                // 'due_commitment_date' => $due_commitment_date,                  
                // 'by_user'       => $by_user,
                // 'active'        => $packRestart,
                // 'packCloseReason'=> $packCloseReason,
                // 'cgst_amt'          =>$cgst_amt,
                // 'sgst_amt'          =>$sgst_amt,
                // 'total_amt'         =>$total_amt,
                // 'tax_detail'        =>$tax_arr,
                // 'total_amt_ext_tax' =>$totalpayment,
                // 'amount_paid' =>$totalpayment,
                'add_payment'   => $add_payment,
                'due_commitment_date' => $due_commitment_date,                  
                'by_user'       => $by_user,
                'active'        => $packRestart,
                'packCloseReason'=> $packCloseReason,
                'cgst_amt'          =>$cgst_amt,
                'sgst_amt'          =>$sgst_amt,
                'tax_detail'        =>$tax_arr,
                'amount_paid' =>$total_amt,
            ); 
            $params2 = array(                    
                'student_package_id'=> $student_package_id,
                'amount'            => $add_payment,
                'cgst_amt'          =>$cgst_amt,
                'sgst_amt'          =>$sgst_amt,
                'total_amt'         =>$total_amt,
                'tax_detail'        =>$tax_arr,
                'remarks'           =>'Add Payment |'+$remarks,
                'student_id'        => $student_id,
                'type'              => '+',
                'by_user'           => $by_user,
                'created'           => date("d-m-Y h:i:s A"),
                'modified'          => date("d-m-Y h:i:s A"),
            ); 
            
            // pr($params,1);
            $idd1=$this->Student_package_model->update_student_pack_payment($student_package_id,$params);
            $idd2 = $this->Student_package_model->update_transaction($params2); 
            $finalWalletAmount = $walletAmount-$total_amt;
            $idd3=$this->Student_model->update_student_wallet_payment($student_id,$finalWalletAmount);
            if($idd1 and $idd2){ 
                return 1;
            }else{
                return 0;
            }            
            //use wallet case end

        }else{
            
            if($add_payment<$amount_due){
                $this->form_validation->set_rules('due_commitment_date_next','Due committment date','required');
            }
            $params = array(                    
                // 'add_payment'   => $add_payment,
                // 'due_commitment_date' => $due_commitment_date,                  
                // 'by_user'       => $by_user,
                // 'packCloseReason'=> $packCloseReason,
                // 'active'        => $packRestart,
                // 'cgst_amt'          =>$cgst_amt,
                // 'sgst_amt'          =>$sgst_amt,
                // 'total_amt'         =>$total_amt,
                // 'tax_detail'        =>$tax_arr,
                // 'total_amt_ext_tax' =>$totalpayment,
                'add_payment'   => $add_payment,
                'due_commitment_date' => $due_commitment_date,                  
                'by_user'       => $by_user,
                'active'        => $packRestart,
                'packCloseReason'=> $packCloseReason,
                'cgst_amt'          =>$cgst_amt,
                'sgst_amt'          =>$sgst_amt,
                'tax_detail'        =>$tax_arr,
                'amount_paid' =>$total_amt,
            ); 
            $params2 = array(                    
                'student_package_id'=> $student_package_id,
                'amount'            => $add_payment,
                'cgst_amt'          =>$cgst_amt,
                'sgst_amt'          =>$sgst_amt,
                'total_amt'         =>$total_amt,
                'tax_detail'        =>$tax_arr,
                'remarks'           =>'Add Payment |'+$remarks,
                'student_id'        => $student_id,
                'type'              => '+',
                'by_user'           => $by_user,
                'created'           => date("d-m-Y h:i:s A"),
                'modified'          => date("d-m-Y h:i:s A"),
            );
            // pr($params,1);
            if($params2['amount']>0){
                 
                $idd1 = $this->Student_package_model->update_student_pack_payment($student_package_id,$params);
                $idd2 = $this->Student_package_model->update_transaction($params2);
                if($idd1 and $idd2){ 
                    $add_payment = CURRENCY .$add_payment/100;
                    $get_UID = $this->Student_model->get_UID($student_id);
                    $UID = $get_UID['UID'];
                //activity update start
                    $activity_name= PAYMENT_ADDED;
                    $description= 'Payment worth  '.CURRENCY.' '.$add_payment.' recieved from student '.$UID.' ';
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
                //activity update end              
                    return 1;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }       
            
    }

    //non-real function
    function partial_refund_($add_payment,$remarks,$student_package_id,$student_id,$pack_status_pr,$pack_cb){        

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='partial_refund_';       
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $getAmountPaid=$this->Student_package_model->getAmountPaid($student_package_id);
        $org_amount_paid = $getAmountPaid['amount_paid'];
        if($add_payment<$org_amount_paid){
            $validRefund = 1;
        }else if($add_payment>=$org_amount_paid){
            $validRefund = 0;
        }else{
            $validRefund = 0;
        }

        if($pack_status_pr==0 || $pack_status_pr==1){
            $packCloseReason='Partial Refund';
        }else{
            $packCloseReason=NULL;
        }

        $params = array(                    
            'add_payment'    => $add_payment,                 
            'by_user'        => $by_user,
            'packCloseReason'=> $packCloseReason,
            'active'         => $pack_status_pr,
        ); 
        $params2 = array(                    
            'student_package_id'=> $student_package_id,
            'amount'            => $add_payment,
            'remarks'           => $remarks,
            'student_id'        => $student_id,
            'type'              => '-',
            'by_user'           => $by_user,
            'created'           => date("d-m-Y h:i:s A"),
            'modified'          => date("d-m-Y h:i:s A"),
        ); 
        if($validRefund==1){
            $idd1 = $this->Student_package_model->update_student_pack_payment_refund($student_package_id,$params);
            $updateWallet = $this->Student_model->update_student_wallet($student_id,$add_payment);
            $idd2 = $this->Student_package_model->update_transaction($params2);
            if($pack_status_pr==0){
               $idd3 = $this->Student_package_model->transferDueToIrrDue($student_package_id); 
            }else{
                $idd3 = 1;
            }
            if($pack_cb=='offline'){
                $remarkSuffix = 'for Inhouse pack';
            }elseif($pack_cb=='online'){
                $remarkSuffix = 'for Online pack';
            }elseif($pack_cb=='pp'){
                $remarkSuffix = 'for Practice pack';
            }else{
                $remarkSuffix = 'something wrong';
            }
            $withdrawlData= array(
                'student_id'=> $student_id,
                'withdrawl_method'=> AUTO,
                'deposited_amount'=> $add_payment,
                'remarks'=> 'Partially Refunded to wallet '.$remarkSuffix.' ',
                'by_user'=> $by_user,
            );
            $idd4 = $this->Student_model->add_withdrawl($withdrawlData);       
            if($idd1 and $idd2 and $idd3 and $idd4){
                $get_UID = $this->Student_model->get_UID($student_id);
                $UID = $get_UID['UID'];
                //activity update start
                    $add_payment = CURRENCY.' '.$add_payment;
                    $activity_name= PARTIAL_REFUND;
                    $description= 'Payment worth  '.CURRENCY.' '.$add_payment.' as partial refund to wallet for student '.$UID.'';               
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
                //activity update end
                return 1;

            }else{
                return 0;
            }
        }else{
            return 0;
        }      
        
    }

    //non-real function
    function full_refund_($add_payment,$remarks,$student_package_id,$student_id,$center_id,$test_module_id,$programe_id,$pack_status_pr,$pack_cb){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='full_refund_';        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        $wsCount = 0;
        $getAmountPaid=$this->Student_package_model->getAmountPaid($student_package_id);
        $org_amount_paid = $getAmountPaid['amount_paid'];
        $student_identity = null;
        $offlineCount=$this->Package_master_model->getOfflinePackActiveCount($student_id);
        $onlineCount=$this->Package_master_model->getOnlinePackActiveCount($student_id);
        $ppCount=$this->Practice_package_model->getpp_PackActiveCount($student_id);
        
        /*$rtCount = $this->Realty_test_model->getRtPackActiveCount($student_id);
        $examCount=$this->Package_master_model->getExamActiveCount($student_id);*/
        $rtCount = 0;
        $examCount=0;

        $academyCoachingSum = $offlineCount+$onlineCount;//1
        $academyServiceSum = $ppCount+$wsCount+$rtCount+$examCount;//0       

        if($academyCoachingSum==1 and $academyServiceSum==0){
            $service_id=DROPPED;//dropped 
        }elseif($academyCoachingSum==1 and $academyServiceSum>1){
            $service_id=ACADEMY_SERVICE_REGISTRATION_ID;//Registration - Academy Service 
        }elseif($academyCoachingSum==0 and $academyServiceSum==1){
            $service_id=UNREGISTERED_SERVICE_ID;//unRegistration - Academy Service
        }else{
            $service_id=0;//dont do any update
        }

        $getTestName = $this->Test_module_model->getTestName($test_module_id);
        $getProgramName = $this->Programe_master_model->getProgramName($programe_id);
        $test_module_name = $getTestName['test_module_name'];
        $programe_name = $getProgramName['programe_name'];

        $examBooked = $test_module_name.'-'.$programe_name;
        $userInfo=$this->User_model->getUserInfo($by_user);
        $byUserDetails =  $userInfo['fname'].' '.$userInfo['lname'].'- '.$userInfo['employeeCode'];
        $tranHistory='- <b>Full Refund</b> done for booked <b>'.$examBooked.'</b> <i>[ created on- '.TODAY.', By: '.$byUserDetails.'  ]</i> <br/>';

        if($pack_cb=='offline'){
            $remarkSuffix = 'for Inhose pack';
        }elseif($pack_cb=='online'){
            $remarkSuffix = 'for Online pack';
        }elseif($pack_cb=='pp'){
            $remarkSuffix = 'for Practice pack';
        }else{
            $remarkSuffix = 'something wrong';
        }

        if($add_payment==$org_amount_paid){
            $validRefund = 1;
        }else if($add_payment>$org_amount_paid){
            $validRefund = 0;
        }else{
            $validRefund = 0;
        }

        if($service_id>0 and $validRefund==1){

            $studentStatus = $this->_calculateStatus($service_id,$center_id,$test_module_id,$programe_id,$pack_cb);
            $student_identity = $studentStatus['student_identity'];
            $details = $studentStatus['details'];
            $params = array(                    
                'add_payment'   => $add_payment,                   
                'by_user'       => $by_user,
                'packCloseReason'=>'Full Refund',
                'active'         => $pack_status_pr,
            ); 
            $params2 = array(                    
                'student_package_id'=> $student_package_id,
                'amount'            => $add_payment,
                'remarks'           => $remarks,
                'student_id'        => $student_id,
                'type'              => '-',
                'by_user'           => $by_user,
                'created'           => date("d-m-Y h:i:s A"),
                'modified'          => date("d-m-Y h:i:s A"),
            );
            $params3 = array(                    
                'service_id'   => $service_id,                   
                'by_user'      => $by_user,
                'student_identity'=> $student_identity
            ); 
            $params4 = array('student_id'=>$student_id, 'student_identity'=> $student_identity,'details'=>$details, 'by_user'=>$by_user);
            $idd1 = $this->Student_package_model->update_student_pack_payment_full_refund($student_package_id,$params);
            $updateWallet= $this->Student_model->update_student_wallet($student_id,$add_payment);
            $idd2 = $this->Student_package_model->update_transaction($params2);
            $idd3 = $this->Student_model->update_student($student_id,$params3);
            $idd4 = $this->Student_journey_model->update_studentJourney($params4);
            $idd5 = $this->Student_package_model->transferDueToIrrDue($student_package_id);          
            
            $withdrawlData= array(
                'student_id'=> $student_id,
                'withdrawl_method'=> AUTO,
                'deposited_amount'=> $org_amount_paid,
                'remarks'=> 'Fully Refunded to wallet '.$remarkSuffix.' ',
                'by_user'=> $by_user,
            );
            $idd6 = $this->Student_model->add_withdrawl($withdrawlData);
            $idd7 = $this->Student_package_model->updateTranHistory($student_package_id,$tranHistory);
            if($idd1 and $idd2 and $idd3 and $idd4 and $idd5 and $idd6 and $idd7){
                $get_UID = $this->Student_model->get_UID($student_id);
                $UID = $get_UID['UID'];
                //activity update start
                    $add_payment = CURRENCY.' '.$org_amount_paid;
                    $activity_name= FULL_REFUND;
                    $description= 'Payment worth  '.CURRENCY.' '.$add_payment.' as full refund to wallet for student '.$UID.'';               
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
                //activity update end
                return 1;
            }else{
                return 0;
            }
        }else if($service_id==0 and $validRefund==1){
            //for service_id=0         
            $params = array(                    
                'add_payment'    => $add_payment,                   
                'by_user'        => $by_user,
                'packCloseReason'=> 'Full Refund',
                'active'         => $pack_status_pr,
            );
            $params2 = array(                    
                'student_package_id'=> $student_package_id,
                'amount'            => $add_payment,
                'remarks'           => $remarks,
                'student_id'        => $student_id,
                'type'              => '-',
                'by_user'           => $by_user,
                'created'           => date("d-m-Y h:i:s A"),
                'modified'          => date("d-m-Y h:i:s A"),
            );
            $params3 = array(                    
                'service_id'   => $service_id,                   
                'by_user'     => $by_user,
                'student_identity'=> $student_identity
            );            
            $idd1 = $this->Student_package_model->update_student_pack_payment_full_refund($student_package_id,$params);
            $updateWallet= $this->Student_model->update_student_wallet($student_id,$add_payment);
            $idd2 = $this->Student_package_model->update_transaction($params2);
            $idd3 = $this->Student_model->update_student($student_id,$params3);
            $withdrawlData= array(
                'student_id'=> $student_id,
                'withdrawl_method'=> AUTO,
                'deposited_amount'=> $org_amount_paid,
                'remarks'=> 'Fully Refunded to wallet '.$remarkSuffix.' ',
                'by_user'=> $by_user,
            );
            $idd4 = $this->Student_model->add_withdrawl($withdrawlData);
            $this->Student_package_model->updateTranHistory($student_package_id,$tranHistory);
            $idd5 = $this->Student_package_model->transferDueToIrrDue($student_package_id);
            if($idd1 and $idd2 and $idd3 and $idd4 and $idd5){                
                $get_UID = $this->Student_model->get_UID($student_id);
                $UID = $get_UID['UID'];
                //activity update start
                    $add_payment = CURRENCY.' '.$org_amount_paid;
                    $activity_name= FULL_REFUND;
                    $description= 'Payment worth  '.CURRENCY.' '.$add_payment.' as full refund to wallet for student '.$UID.'';               
                    $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
                //activity update end
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
        
    }

    //non-real function
    function pack_extension_adjustment_($add_payment,$use_wallet,$newDate,$student_package_id,$student_id,$total_amt,$total_tax,$tax_arr,$ext_remarks){
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='pack_extension_adjustment_';        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        $wsCount = 0;
        $service_id=0;
        //get offline class package taken if any
        $offlineCount=$this->Package_master_model->getOfflinePackActiveCount($student_id);
        $onlineCount=$this->Package_master_model->getOnlinePackActiveCount($student_id);
        $ppCount=$this->Practice_package_model->getpp_PackActiveCount($student_id);
        $rtCount = 0;

        $academyServiceSum = $ppCount+$wsCount+$rtCount;
        $academyCoachingSum = $offlineCount+$onlineCount;

        if($academyCoachingSum==1 and $academyServiceSum==0 and $service_id!=ENROLL_SERVICE_ID){
            $service_id=ENROLL_SERVICE_ID;
            $stdData = $this->Student_model->get_studentService($student_id);
            $test_module_id=$stdData['test_module_id'];
            $programe_id=$stdData['programe_id'];
            $center_id=$stdData['center_id'];
        }elseif($academyCoachingSum==1 and $academyServiceSum>0 and $service_id!=ENROLL_SERVICE_ID){
            $service_id=ENROLL_SERVICE_ID;//Registration - Academy Service 
            $stdData = $this->Student_model->get_studentService($student_id);
            $test_module_id=$stdData['test_module_id'];
            $programe_id=$stdData['programe_id'];
            $center_id=$stdData['center_id'];
        }else{
            $service_id=0;//dont do any update
        }
        $walllet = $this->Student_model->getWalletAmount($student_id);
        $walletAmount=$walllet['wallet'];

        if($service_id>0){            
            $pack_cb=''; 
            $studentStatus = $this->_calculateStatus($service_id,$center_id,$test_module_id,$programe_id,$pack_cb);
            $student_identity = $studentStatus['student_identity'];
            $details = $studentStatus['details'];
        }else{/** do nothing..*/}   
         
        if($use_wallet==0){                       
            $params = array(                    
                'add_payment'   => $add_payment,                  
                'by_user'       => $by_user,
                'active'        => 1,
                'packCloseReason'=> NULL,
                'expired_on'    => $newDate,
                'expired_on_str' => strtotime($newDate).' +24 hours',
                'total_amt'         =>$total_amt,
                'total_tax' =>$total_tax,
                'ext_total_amt'=>$total_amt,
                'ext_remarks'=>$ext_remarks,
            );
            $params2 = array(                    
                'student_package_id'=> $student_package_id,
                'amount'            => $add_payment,
                'remarks'           => 'Pack Extension',
                'student_id'        => $student_id,
                'type'              => '+',
                'by_user'           => $by_user,
                'created'           => date("d-m-Y h:i:s A"),
                'modified'          => date("d-m-Y h:i:s A"),
                'user_remarks'      =>$ext_remarks,
            ); 
            $idd1 = $this->Student_package_model->update_student_pack_payment_pack_extension($student_package_id,$params);
            $idd2 = $this->Student_package_model->update_transaction($params2);
            if($service_id>0){
                $params3 = array(                    
                    'service_id'   => $service_id,                   
                    'by_user'     => $by_user,
                    'student_identity'=> $student_identity
                ); 
                $params4 = array('student_id'=>$student_id, 'student_identity'=> $student_identity,'details'=>$details, 'by_user'=>$by_user);
                $idd3 = $this->Student_model->update_student($student_id,$params3);
                $idd4 = $this->Student_journey_model->update_studentJourney($params4);
            }else{$idd3=1; $idd4=1;}

        }else{          
            
            //wallet case: start
            if($add_payment<$walletAmount){

                $finalWalletAmount=$walletAmount-$add_payment;

            }else{
                $finalWalletAmount = 0;
            }
            $params = array(                    
                'add_payment'   => $add_payment,                  
                'by_user'       => $by_user,
                'active'        => 1,
                'packCloseReason'=> NULL,
                'expired_on'    => $newDate,
                'expired_on_str' => strtotime($newDate).' +24 hours',
                'total_amt'         =>$total_amt,
                'tax_detail'        =>$tax_arr,
                'total_tax' =>$total_tax,
                'ext_total_amt'=>$total_amt,
                'ext_remarks'=>$ext_remarks,
            );
            $params2 = array(                    
                'student_package_id'=> $student_package_id,
                'amount'            => $add_payment,
                'remarks'           => 'Pack Extension',
                'student_id'        => $student_id,
                'type'              => '+',
                'by_user'           => $by_user,
                'created'           => date("d-m-Y h:i:s A"),
                'modified'          => date("d-m-Y h:i:s A"),
                'user_remarks'      =>$ext_remarks,
            );                    
            $idd1 = $this->Student_package_model->update_student_pack_payment_pack_extension($student_package_id,$params);
            $idd2 = $this->Student_package_model->update_transaction($params2);
            if($service_id>0){
                $params3 = array(                    
                    'service_id'   => $service_id,                   
                    'by_user'     => $by_user,
                    'student_identity'=> $student_identity
                ); 
                $params4 = array('student_id'=>$student_id, 'student_identity'=> $student_identity,'details'=>$details, 'by_user'=>$by_user);
                $idd3 = $this->Student_model->update_student($student_id,$params3);
                $idd4 = $this->Student_journey_model->update_studentJourney($params4);
            }else{$idd3=1; $idd4=1;}
            $this->Student_model->update_student_wallet_payment($student_id,$finalWalletAmount);
            //wallet case: end
        }        

        if($idd1 and $idd2 and $idd3 and $idd4){
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID'];
            //activity update start
                // $add_payment = CURRENCY .' '.$add_payment;
                $activity_name= PACK_EXTENSION;
                $payment_n = $add_payment/100;
                $description= 'Payment worth '.CURRENCY.' '.$payment_n.' recieved for pack extension from student '.$UID.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
            //activity update end
            return 1;

        }else{
            return 0;
        }
    }
    
    //non-real function
    //$center_id,$service_id,$student_package_id,$student_id,$test_module_id,$programe_id); 
    function branch_switch_adjustment_($center_id=null,$service_id=null,$student_package_id=null,$student_id=null,$test_module_id=null,$programe_id=null,$amount_paid=null,$cutting_amount=null,$restAmount=null){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='branch_switch_adjustment_';        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $centerName = $this->Center_location_model->get_centerName($center_id);
        $center_name = $centerName['center_name'];       
        $params1 = array(                    
            'center_id'     => $center_id,
            'test_module_id'=> $test_module_id,                   
            'programe_id'   => $programe_id,
            'by_user'       => $by_user,
        );        
        $params2 = array(                    
            'cutting_amount' => $cutting_amount,
            'restAmount' => $restAmount,                   
            'by_user'     => $by_user,
            'packCloseReason'=>'Branch switched',
            'active'      => 0
        );        
        $params3 = array(                    
            'student_package_id'=> $student_package_id,
            'amount'            => $restAmount,
            'remarks'           => 'Branch switched to '.$center_name.' and amount transfered to student wallet',
            'student_id'        => $student_id,
            'type'              => '-',
            'by_user'           => $by_user,
            'created'           => date("d-m-Y h:i:s A"),
            'modified'          => date("d-m-Y h:i:s A"),
        );
        $idd1 =$this->Student_model->update_student($student_id,$params1); 
        $idd2 =$this->Student_package_model->update_student_package($student_package_id,$params2);
        $idd3 = $this->Student_package_model->update_transaction($params3);
        $idd4 = $this->Student_model->update_student_wallet($student_id,$restAmount);
        $idd5 = $this->Student_package_model->transferDueToIrrDue($student_package_id);
        if($idd1 and $idd2 and $idd3 and $idd4 and $idd5){
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID'];
            //activity update start
                $add_payment = CURRENCY.' '.$cutting_amount/100;
                $activity_name= BRANCH_SWITCH;
                $description= 'Branch switched with switch charge worth '.CURRENCY.' '.$add_payment.' recieved from student '.$UID.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
            //activity update end
            return 1;
        }else{
            return 0;
        }
    }

    //non-real function
    function course_switch_adjustment_($programe_id,$test_module_id,$service_id,$student_package_id,$student_id,$amount_paid,$cutting_amount,$restAmount,$center_id){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='course_switch_adjustment_';        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $params1 = array(                    
            'programe_id'   => $programe_id,
            'test_module_id'=> $test_module_id,          
            'by_user'       => $by_user,
        ); 
        $params2 = array(                    
            'cutting_amount' => $cutting_amount, 
            'restAmount'  => $restAmount,                
            'by_user'     => $by_user,
            'packCloseReason'=> 'Course switched',
            'active'      => 0
        ); 
        $testName = $this->Test_module_model->getTestName($test_module_id);
        $test_module_name = $testName['test_module_name'];
        if($programe_id==GT_ID){
            $programe_name='GT';
        }elseif($programe_id==ACD_ID) {
            $programe_name='ACD';
        }else{
            $programe_name=NONE;
        }
        $test_name =  $test_module_name.'-'.$programe_name;            
        $params3 = array(                    
            'student_package_id'=> $student_package_id,
            'amount'            => $restAmount,
            'remarks'           => 'Course switched to '.$test_module_name.'-'.$programe_name,
            'student_id'        => $student_id,
            'type'              => '-',
            'by_user'           => $by_user,
            'created'           => date("d-m-Y h:i:s A"),
            'modified'          => date("d-m-Y h:i:s A"),
        );
        $idd1=$this->Student_model->update_student($student_id,$params1);
        $idd2=$this->Student_model->update_student_wallet($student_id,$restAmount);
        $idd3 =$this->Student_package_model->update_student_package($student_package_id,$params2);        
        $idd4=$this->Student_package_model->update_transaction($params3); 
        $idd5 = $this->Student_package_model->transferDueToIrrDue($student_package_id);
        $withdrawlData= array(
            'student_id'=> $student_id,
            'withdrawl_method'=> AUTO,
            'deposited_amount'=> $restAmount,
            'remarks'=> 'Course switch except cutting amount to wallet',
            'by_user'=> $by_user,
        );
        $idd6 = $this->Student_model->add_withdrawl($withdrawlData);
        if($idd1 and $idd2 and $idd3 and $idd4 and $idd5 and $idd6){
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID']; 
            //activity update start
                $add_payment = CURRENCY.' '.$cutting_amount/100;
                $activity_name= COURSE_SWITCH;
                $description= 'Course switched with switch charge worth '.CURRENCY.' '.$add_payment.' recieved from student '.$UID.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
            //activity update end
            return 1;
        }else{
            return 0;
        }
    }

    function updateBatch_($batch_id,$student_package_id,$student_id){
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='updateBatch_';      
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        $this->load->model('Classroom_model');

        //getting pack profile
        $getPackProfile= $this->Student_package_model->getPackProfile($student_package_id); 
        $pack_test_module_id= $getPackProfile['test_module_id'];
        $pack_programe_id= $getPackProfile['programe_id'];
        $pack_category_id= $getPackProfile['category_id'];
        $pack_center_id=$getPackProfile['center_id'];
        $prev_batch_id=$getPackProfile['batch_id'];

        $findClassroom = $this->Classroom_model->findClassroom($pack_test_module_id,$pack_programe_id,$pack_category_id,$batch_id,$pack_center_id);
        $classroom_id=$findClassroom['id'];

        $getBatchNamePrev = $this->Batch_master_model->getBatchName($prev_batch_id);
        $batch_name_prev = $getBatchNamePrev['batch_name'];

        $getBatchName = $this->Batch_master_model->getBatchName($batch_id);
        $batch_name_new = $getBatchName['batch_name'];
        $params1 = array(                    
            'batch_id'=> $batch_id,
            'classroom_id'=>$classroom_id,                 
            'by_user'=> $by_user,
            'packCloseReason'=>NULL
        );
        $idd1=$this->Student_package_model->update_student_pack($student_package_id,$params1);

        $params2 = array(                    
            'student_package_id'=> $student_package_id,
            'amount'            => 0,
            'remarks'           => 'Batch updated FROM '.$batch_name_prev.' TO '.$batch_name_new.'',
            'student_id'        => $student_id,
            'type'              => 'N/A',
            'by_user'           => $by_user,
            'created'           => date("d-m-Y h:i:s A"),
            'modified'          => date("d-m-Y h:i:s A"),
        ); 
        $idd2 = $this->Student_package_model->update_transaction($params2);

        $getStudentCurrentStatus = $this->Student_model->getStudentCurrentStatus($student_id);
        $student_identity = $getStudentCurrentStatus['student_identity'];

        $params3 = array('student_id'=>$student_id,'details'=>$params2['remarks'], 'student_identity'=> $student_identity,'by_user'=>$by_user);
        $idd3 = $this->Student_journey_model->update_studentJourney($params3);
        if($idd1 and $idd2 and $idd3){
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID'];
            //activity update start                
                $activity_name= BATCH_UPDATE;
                $description= 'Batch updated/changed FROM '.$batch_name_prev.' TO '.$batch_name_new.' for student '.$UID.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
            //activity update end
            return 1;
        }else{
            return 0;
        }

    }

    function terminate_pack_($termination_reason,$student_package_id,$student_id){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='terminate_pack_';        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        $getDues=$this->Student_package_model->getDues($student_package_id);
        //$amount_due = $getDues['amount_due'];
        $irr_dues = $getDues['amount_due']+$getDues['irr_dues'];
        $params1 = array(                    
            'by_user'     => $by_user,
            'active'      => 0,
            'is_terminated'=> 1,
            'packCloseReason'=>'Pack Terminated',
            'amount_due'=> 0,
            'irr_dues'=> $irr_dues
        );                    
        $params2 = array(                    
            'student_package_id'=> $student_package_id,
            'amount'            => 0,
            'remarks'           => 'Termination reason: '.$termination_reason,
            'student_id'        => $student_id,
            'type'              => '+',
            'by_user'           => $by_user,
            'created'           => date("d-m-Y h:i:s A"),
            'modified'          => date("d-m-Y h:i:s A"),
        );
        $idd1=$this->Student_package_model->update_student_pack($student_package_id,$params1);
        $idd2=$this->Student_package_model->update_transaction($params2); 
        
        $service_id=TERMINATION_ID;$pack_cb='';
        $getStudentCurrentStatus = $this->Student_model->getStudentCurrentStatus($student_id);
        $test_module_id = $getStudentCurrentStatus['test_module_id'];
        $programe_id = $getStudentCurrentStatus['programe_id'];
        $center_id = $getStudentCurrentStatus['center_id'];
        $studentStatus = $this->_calculateStatus($service_id,$center_id,$test_module_id,$programe_id,$pack_cb);
        $student_identity = $studentStatus['student_identity'];
        $details = $studentStatus['details']; 
        $params3 = array('student_id'=>$student_id,'details'=>$details.' / '.$params2['remarks'], 'student_identity'=> $student_identity,'by_user'=>$by_user);
        $idd3 = $this->Student_journey_model->update_studentJourney($params3);
        $params4 = array('student_identity'=> $student_identity,'service_id'=> $service_id,'by_user'=>$by_user);
        $idd4=$this->Student_model->update_student($student_id,$params4);

        if($idd1 and $idd2 and $idd3){
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID'];
            //activity update start                
                $activity_name= PACK_TERMINATION;
                $description = 'Pack terminated for student '.$UID.' ';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
            //activity update end
            return 1;
        }else{
            return 0;
        }
    }
    function manage_pack_start_date($new_start_date,$student_package_id,$student_id){          
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='manage_pack_start_date';        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        $packdata= $this->Package_master_model->get_pack_id($student_package_id);
        $package_id=$packdata['package_id'];
        $currtent_start_date=$packdata['subscribed_on'];
        $pack_type=$packdata['pack_type'];
        if($pack_type=="online")
        {
            $package_data= $this->Package_master_model->get_package_master($package_id);
        }
        else {
            $package_data= $this->Package_master_model->get_package_master_pp($package_id);
        }
        
        $duration_type = $package_data['duration_type_name'];
        $duration      = $package_data['duration'];         
        $dt = $duration.' '.$duration_type;
        if($duration_type=='Day'){
            $duration = $duration;
        }elseif($duration_type=='Week'){
           $duration = $duration*7;                
        }elseif($duration_type=='Month'){
           $duration = $duration*30;                
        }else{
           $duration = 0;
        }
        if($duration >0){
           $duration=$duration-1;
          //  $duration=$duration;
        }      
        $duration = $duration.' days';         
    
        $subscribed_on = date("d-m-Y", strtotime($new_start_date));
        $datee=date_create($subscribed_on);
        date_add($datee,date_interval_create_from_date_string($duration));
        $expired_on = date_format($datee,"d-m-Y");
        $params1 = array(                    
            'subscribed_on'=> $new_start_date,
            'subscribed_on_str'=> strtotime($new_start_date),          
            'expired_on'=> $expired_on,
            'expired_on_str' => strtotime($expired_on),              
            'by_user'=> $by_user,            
        ); 
        $idd1=$this->Student_package_model->update_student_pack($student_package_id,$params1);
        $params2 = array(                    
            'student_package_id'=> $student_package_id,
            'amount'            => 0,
            'remarks'           => 'Start Date updated from '.$currtent_start_date. ' To '.$new_start_date,
            'student_id'        => $student_id,
            'type'              => 'N/A',
            'by_user'           => $by_user,
            'created'           => date("d-m-Y h:i:s A"),
            'modified'          => date("d-m-Y h:i:s A"),
        ); 
        $idd2 = $this->Student_package_model->update_transaction($params2);
        if($idd1 and $idd2 ){
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID'];
            //activity update start 
                $activity_name= MANAGE_START_DATE;
                $description= 'Start Date updated from '.$currtent_start_date. ' to '.$new_start_date.' for student '.$UID.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
            //activity update end
            unset($_SESSION['current_start_date']);
            $emailcontent = package_purchase_update($currtent_start_date,$new_start_date); 
            $email_message = $emailcontent['content'];
            $subject = $emailcontent['subject'];
            $mailData                   = $this->Student_model->getMailData($student_package_id);
            $mailData['email_message']  = $email_message;            
            $mailData['thanks']         = THANKS;
            $mailData['team']           = WOSA; 
            $mailData['email_footer_text'] =  $emailcontent['email_footer_text'];         
            if(base_url()!=BASEURL){
                $this->sendEmailTostd_manage_start_date($subject,$mailData);
                //$this->_call_smaGateway($this->input->post('mobile'),PACK_SUBSCRIPTION_SMS);
            }
            return 1;
          
        }else{
            unset($_SESSION['current_start_date']);
            return 0;
        }      
       
    }

    function do_pack_on_hold_($holdDateFrom,$holdDateTo,$application_file,$student_package_id,$student_id){          
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='do_pack_on_hold_';        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        if(!file_exists(PACK_HOLD_FILE_PATH)){
            mkdir(PACK_HOLD_FILE_PATH, 0777, TRUE);
        }
        $config['upload_path']   = PACK_HOLD_FILE_PATH;
        $config['allowed_types'] = PACK_HOLD_TYPES;
        $config['encrypt_name']  = FALSE;

        $this->load->library('upload',$config);
        if($this->upload->do_upload("application_file")){
            $data1 = array('upload_data' => $this->upload->data());
            $application_file=$data1['upload_data']['file_name'];
        }else{
            $application_file=NULL;
        }
        $holdDateFrom = date('d-m-Y', strtotime($holdDateFrom));
        $holdDateTo = date('d-m-Y', strtotime($holdDateTo));

        $today = date('d-m-Y');
        $todayStr =strtotime($today);

        $holdDateFrom_str = strtotime($holdDateFrom);
        $holdDateTo_str = strtotime($holdDateTo);
        $diffStr = abs($holdDateTo_str-$holdDateFrom_str);
        $diff = ($diffStr/86400) + 1;
        $diff = round($diff);        
       
        $getPackExpiry = $this->Student_package_model->getPackExpiry($student_package_id);
        $currentExpiryDate = $getPackExpiry['expired_on'];
        $newExpiryDate = date('d-m-Y', strtotime($currentExpiryDate . ' +'.$diff.' days'));
        $closingFromToday = abs($todayStr-$holdDateFrom_str); 

        if($closingFromToday==0){
            $active=0;
            $onHold=1;
            $packCloseReason="Pack on hold";
        }else{
            $active=1;
            $onHold=0;
            $packCloseReason=NULL;
        }
        if($application_file){
            $params1 = array(                    
                'holdDateFrom'=> $holdDateFrom,
                'holdDateTo'=> $holdDateTo,
                'application_file'=>$application_file,
                'expired_on'=> $newExpiryDate,
                'expired_on_str' => strtotime($newExpiryDate),
                'onHold'=>$onHold,      
                'by_user'=> $by_user,
                'packCloseReason'=>$packCloseReason,
                'active'=> $active
            ); 
            $idd1=$this->Student_package_model->update_student_pack($student_package_id,$params1);
            $params2 = array(                    
                'student_package_id'=> $student_package_id,
                'amount'            => 0,
                'remarks'           => 'Pack On hold from '.$holdDateFrom. ' till '.$holdDateTo,
                'student_id'        => $student_id,
                'type'              => 'N/A',
                'by_user'           => $by_user,
                'created'           => date("d-m-Y h:i:s A"),
                'modified'          => date("d-m-Y h:i:s A"),
            ); 
            $idd2 = $this->Student_package_model->update_transaction($params2);

            $getStudentCurrentStatus = $this->Student_model->getStudentCurrentStatus($student_id);
            $student_identity = $getStudentCurrentStatus['student_identity'];
            $params3 = array('student_id'=>$student_id,'details'=>$params2['remarks'], 'student_identity'=> $student_identity,'by_user'=>$by_user);
            $idd3 = $this->Student_journey_model->update_studentJourney($params3);
        }
       
        
        if($idd1 and $idd2 and $idd3){
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID'];
            //activity update start                
                $activity_name= PACK_HOLD;
                $description= 'Pack on hold from '.$holdDateFrom. ' till '.$holdDateTo.' for student '.$UID.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
            //activity update end
            return 1;
        }else{
            return 0;
        }
    }

    function unhold_pack_($student_package_id,$student_id){        
        
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='unhold_pack_';       
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];

        $getPackHoldData =$this->Student_package_model->getPackExpiry2($student_package_id);
        $currentExpiryDate = $getPackHoldData['expired_on'];
        $holdDateFrom = $getPackHoldData['holdDateFrom'];
        $holdDateTo = $getPackHoldData['holdDateTo'];
        $old_application_file = $getPackHoldData['application_file'];

        $holdDateFrom = date('d-m-Y', strtotime($holdDateFrom));
        $holdDateTo = date('d-m-Y', strtotime($holdDateTo));

        $holdDateFrom_str = strtotime($holdDateFrom);
        $holdDateTo_str = strtotime($holdDateTo);
        $diffStr = abs($holdDateTo_str-$holdDateFrom_str);
        $diff = ($diffStr/86400) + 1;
        $diff = round($diff);
        $newExpiryDate = date('d-m-Y', strtotime($currentExpiryDate . ' -'.$diff.' days'));
        $today = date('d-m-Y');
        $params1 = array( 
            'onHold' => 0,      
            'by_user' => $by_user,
            'packCloseReason' => NULL,
            'active'=> 1,
            'expired_on'=> $newExpiryDate,
            'expired_on_str'=> strtotime($newExpiryDate),
            'holdDateFrom'=>NULL,
            'holdDateTo'=>NULL,
            'application_file'=>NULL,
        ); 
        $idd1=$this->Student_package_model->update_student_pack($student_package_id,$params1);
        $params2 = array(                    
            'student_package_id'=> $student_package_id,
            'amount'            => 0,
            'remarks'           => 'Pack On hold is realeased on '.$today. ' ',
            'student_id'        => $student_id,
            'type'              => 'N/A',
            'by_user'           => $by_user,
            'file'              => $old_application_file,
            'created'           => date("d-m-Y h:i:s A"),
            'modified'          => date("d-m-Y h:i:s A"),
        ); 
        $idd2 = $this->Student_package_model->update_transaction($params2);
        if($idd1 and $idd2){
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID'];
            //activity update start                
                $activity_name= PACK_UNHOLD;
                $description= 'Pack on hold is realeased on '.$today. ' for student '.$UID.' ';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);                
            //activity update end
            return 1;
        }else{
            return 0;
        }

    }

    function reactivate_pack_against_partial_refund_($student_package_id=0,$student_id=0){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='reactivate_pack_against_partial_refund_';         
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        $params = array(                    
            'by_user'     => $by_user,
            'active'      => 1            
        );
        $idd1=$this->Student_package_model->update_student_pack($student_package_id,$params);
         
        if($idd1){
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID']; 
            //activity update start                
                $activity_name= PACK_REACTIVATION;
                $description= 'Pack Re-Activated against partial refund mistake for student '.$UID.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
            //activity update end
            return 1;
        }else{
            return 0;
        }
    }

    function reactivate_pack_($student_package_id=0,$student_id=0){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn='reactivate_pack_';         
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $by_user=$_SESSION['UserId'];
        $getDues=$this->Student_package_model->getDues($student_package_id);
        $irr_dues = $getDues['irr_dues'];
        $amount_due = $getDues['amount_due'];
        $amount_due  =  $amount_due + $irr_dues;            
        
        $params1 = array(                    
            'by_user'     => $by_user,
            'active'      => 1,
            'is_terminated'=> 0,
            'amount_due'=> $amount_due,
            'irr_dues'=>0,
            'packCloseReason'=> NULL
        );                    
        $params2 = array(                    
            'student_package_id'=> $student_package_id,
            'amount'            => 0,
            'remarks'           => 'Pack Re-Activated',
            'student_id'        => $student_id,
            'type'              => '+',
            'by_user'           => $by_user,
            'created'           => date("d-m-Y h:i:s A"),
            'modified'          => date("d-m-Y h:i:s A"),
        );
        $idd1=$this->Student_package_model->update_student_pack($student_package_id,$params1);
        $idd2=$this->Student_package_model->update_transaction($params2); 
        if($idd1 and $idd2){
            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID']; 
            //activity update start                
                $activity_name= PACK_REACTIVATION;
                $description= 'Pack Re-Activated for student '.$UID.'';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
            //activity update end
            return 1;
        }else{
            return 0;
        }
        
    }

    function student_transaction_($student_package_id,$student_id){        

        $student_id = base64_decode($student_id);

        $data['title'] = 'Transaction summary';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset']=($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/student/student_trans?');
        $config['total_rows'] = $this->Student_model->get_all_students_trans_count($student_package_id,$student_id);
        $this->pagination->initialize($config);
        $data['studentData']  = $this->Student_model->getstudentInfo($student_id);
        $data['students_tran'] = $this->Student_model->get_all_students_trans($student_package_id,$student_id);        
        $data['_view'] = 'student/student_trans';
        $this->load->view('layouts/main',$data);
    }

    //non-real function
    function ajax_check_std_email_availibility(){

        $data=array(
            'email' => $this->input->post('email', TRUE),       
        ); 
        $email = $data['email'];
        if($email!='') {

            $count = $this->Student_model->check_std_email_availibility($data['email']);
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

    //non-real function
    function ajax_check_std_mobile_availibility(){

        $data=array(
            'mobile' => $this->input->post('mobile', TRUE),       
        ); 
        $mobile = $data['mobile'];
        if($mobile!='') {

            if(strlen($mobile)!=10){

                header('Content-Type: application/json');
                $response = ['msg'=>'<span class="text-danger">Please enter valid Number of 10 digit</span>', 'status'=>'false'];
                echo json_encode($response);

            }elseif(!is_numeric($mobile)){
                header('Content-Type: application/json');
                $response = ['msg'=>'<span class="text-danger">Please enter valid Number. Alphabets not allowed</span>', 'status'=>'false'];
                echo json_encode($response);

            }else{

                $count = $this->Student_model->check_std_mobile_availibility($mobile);
                if($count<=0){  
                    header('Content-Type: application/json');
                    $response = ['msg'=>'<span class="text-success">Wow! its available..carry on</span>', 'status'=>'true'];
                    echo json_encode($response); 
                }else{  
                    header('Content-Type: application/json');
                    $response = ['msg'=>'<span class="text-danger">Oops! '.$mobile.' already exist. Please try another</span>', 'status'=>'false'];
                    echo json_encode($response);
                }
            }             

        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'<span class="text-danger">Please enter valid Contact no.</span>', 'status'=>'false'];
            echo json_encode($response);
        }       
                  
    }

    //non-real function
    function ajax_get_otp(){

        $mobile = $this->input->post('mobile', TRUE);
        $exist = $this->Student_model->check_std_mobile_availibility($mobile);
        if($mobile!='' and $exist==0){            
            if(strlen($mobile)!=10){
                header('Content-Type: application/json');
                $response = ['msg'=>'Please enter valid Number of 10 digit', 'status'=>'false', 'otp'=>''];
                echo json_encode($response);
            }elseif(!is_numeric($mobile)){
                header('Content-Type: application/json');
                $response = ['msg'=>'Please enter valid Number. Alphabets not allowed', 'status'=>'false', 'otp'=>''];
                echo json_encode($response);
            }else{
                if(base_url()!=BASEURL){ 
                    $otp = rand(1000,10000);
                    $message = 'Hi, please confirm your details by entering the OTP '.$otp.' Valid for 10 minutes only Regards Western Overseas';
                   //$this->_call_smaGateway($mobile,$message);
                }else{
                    $otp = 1234;
                    $message = 'Hi, please confirm your details by entering the OTP '.$otp.' Valid for 10 minutes only Regards Western Overseas';
                }
                header('Content-Type: application/json');
                $response = ['msg'=>'OTP sent.Please check', 'status'=>'true', 'otp'=>$otp];
                echo json_encode($response);                
            }             

        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'Please enter valid/unique Contact no.', 'status'=>'false', 'otp'=>''];
            echo json_encode($response);
        }
    }

    function ajax_send_mobile_otp(){

        $mobile = $this->input->post('mobile', TRUE);
        $country_code = $this->input->post('country_code', TRUE);
                    
            if(strlen($mobile)!=10){
                header('Content-Type: application/json');
                $response = ['msg'=>'Please enter valid Number of 10 digit', 'status'=>'false', 'otp'=>''];
                echo json_encode($response);
            }elseif(!is_numeric($mobile)){
                header('Content-Type: application/json');
                $response = ['msg'=>'Please enter valid Number. Alphabets not allowed', 'status'=>'false', 'otp'=>''];
                echo json_encode($response);
            }else{
                
                $data_user = $this->Student_model->get_studentId_byMobile($country_code,$mobile); 
				                            
                if(!empty($data_user))
                {
                     $id=$data_user['id'];   
                    if(base_url()!=BASEURL){ 
                        $otp = rand(1000,10000);
                        $message = 'Hi, please confirm your details by entering the OTP '.$otp.' Valid for 10 minutes only Regards Western Overseas';
                       $this->_call_smaGateway($mobile,$message);
                    }else{
                        $otp = 1234;
                        $message = 'Hi, please confirm your details by entering the OTP '.$otp.' Valid for 10 minutes only Regards Western Overseas';
                    }
					 $params2 = array('OTP'=>$otp);                               
                    $idd = $this->Student_model->update_student($id,$params2);
                    header('Content-Type: application/json');
                     $response = ['msg'=>'OTP sent on this mobile number, Please check', 'status'=>'true', 'otp'=>$otp];
                     echo json_encode($response);   
                }  
                else {
                    header('Content-Type: application/json');
                $response = ['msg'=>'Fail to send OTP. Try again', 'status'=>'false'];
                echo json_encode($response);   
                }
                             
            } 
    } 

    function ajax_send_email_otp(){

        $email = $this->input->post('email', TRUE);       
        $data_user = $this->Student_model->get_studentId_byEmail($email); 
        $id=$data_user['id'];       
        if($id)
        {
            $otp = rand(1000,10000);            
            // $subject='Email OTP verification';                   
            // $email_message='Hi, please confirm your details by entering the OTP '.$otp.' Valid for 10 minutes only Regards Western Overseas';
            $email_content = otp_send_verification_email($otp);
            $email_message = $email_content['content'];
            $subject = $email_content['subject'];
            $mailData                 = [];
            $mailData['fname']        = 'User';
            $mailData['email']        = $email;
            $mailData['email_message']= $email_message;
            $mailData['thanks']       = THANKS;
            $mailData['team']         = WOSA;
            if(base_url()!=BASEURL){               
                $this->sendEmailTostd_walkinOTP_($subject,$mailData);
            } 
            $params2 = array('OTP'=>$otp);                               
            $idd = $this->Student_model->update_student($id,$params2); 
            header('Content-Type: application/json');
            $response = ['msg'=>'OTP sent on this email, Please check', 'status'=>'true', 'otp'=>$otp];
            echo json_encode($response);   
        }  
        else {
            header('Content-Type: application/json');
            $response = ['msg'=>'Fail to send OTP. Try again', 'status'=>'false'];
            echo json_encode($response);   
        }     
                
         
    }

    //non-real function
    function ajax_show_waiver(){        

        $id = $this->input->post('student_id', TRUE);
        $by_user = $this->input->post('by_user', TRUE);
        $wid = 0;
        $amount = 0;
        $remarks = null;                
        $name = null;
        if($id!=''){ 
            $waiver_approved = $this->Waiver_model->get_waiver_approved_count($id,$by_user);
            if($waiver_approved>0){

                $data['waiver_approved_details'] = $this->Waiver_model->get_waiver_approved_details($id,$by_user);
                $wid = $data['waiver_approved_details']['wid'];
                $amount = $data['waiver_approved_details']['amount'];
                $remarks = $data['waiver_approved_details']['remarks'];                
                $name = $data['waiver_approved_details']['from_fname'].' '.$data['waiver_approved_details']['from_lname'];
                
                header('Content-Type: application/json');
                $response = ['msg'=>'Wow! waiver approved for this student', 'status'=>'true', 'wid'=>$wid, 'amount'=>$amount,'remarks'=>$remarks,'name'=>$name ];
                echo json_encode($response);
            }else{
                header('Content-Type: application/json');
                $response = ['msg'=>'No waiver approved any for this student', 'status'=>'false', 'wid'=>$wid, 'amount'=>$amount,'remarks'=>$remarks,'name'=>$name ];
                echo json_encode($response);
            }                        

        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'Invalid Student', 'status'=>'false'];
            echo json_encode($response);
        }
    }

    //non-real function
    function ajax_show_refund(){
            
        $id = $this->input->post('student_id', TRUE);
        $by_user = $this->input->post('by_user', TRUE);
        $type = $this->input->post('type', TRUE);
        $wid = 0;
        $amount = 0;
        $remarks = null;                
        $name = null;
        if($id!='') { 

            $refund_approved = $this->Refund_model->get_refund_approved_count($id,$by_user);
            if($refund_approved>0){

                $data['refund_approved_details'] = $this->Refund_model->get_refund_approved_details($id,$by_user);
                $wid = $data['refund_approved_details']['wid'];
                $amount = $data['refund_approved_details']['amount'];
                $remarks = $data['refund_approved_details']['remarks'];                
                $name = $data['refund_approved_details']['from_fname'].' '.$data['refund_approved_details']['from_lname'];
                
                header('Content-Type: application/json');
                $response = ['msg'=>'Wow! refund approved for this student', 'status'=>'true', 'wid'=>$wid, 'amount'=>$amount,'remarks'=>$remarks,'name'=>$name,'type'=>$type ];
                echo json_encode($response);
            }else{
                header('Content-Type: application/json');
                $response = ['msg'=>'No refund approved for this student', 'status'=>'false', 'wid'=>@$wid, 'amount'=>$amount,'remarks'=>$remarks,'name'=>$name ];
                echo json_encode($response);
            }                        

        }else{
            header('Content-Type: application/json');
            $response = ['msg'=>'Invalid Student', 'status'=>'false'];
            echo json_encode($response);
        }
    }

    //non-real function
    function remburse_waiver_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $wid = $this->input->post('wid', TRUE);
        $waiver = $this->input->post('waiver', TRUE)*100;
        $waiver_by = $this->input->post('waiver_by', TRUE);
        $student_package_id = $this->input->post('student_package_id', TRUE);
        $student_id = $this->input->post('student_id', TRUE);
        $by_user = $this->input->post('by_user', TRUE);

        $getDues=$this->Student_package_model->getDues($student_package_id);
        $amount_due = $getDues['amount_due']/100;

        $waiver2 = $this->input->post('waiver', TRUE);

        if($amount_due==0){
            $allowed = 0;
            header('Content-Type: application/json');
            $response = ['msg'=>'You are not allowed to Reimbursed waiver because you have no dues.', 'status'=>'false'];
            echo json_encode($response);
        }elseif($amount_due==$waiver2){
            $allowed = 1;
        }elseif($amount_due>$waiver2){
            $allowed = 1;
        }elseif($amount_due<$waiver2){
            $allowed = 0;
            header('Content-Type: application/json');
            $response = ['msg'=>'You are not allowed to Reimbursed waiver because waiver amount is greater than dues.', 'status'=>'false'];
            echo json_encode($response);
        }else{
            $allowed = 0;
            header('Content-Type: application/json');
            $response = ['msg'=>'You are not allowed to Reimbursed waiver because you have no dues.', 'status'=>'false'];
            echo json_encode($response);
        }

        $params = array(                    
            'add_payment'   => $waiver, 
            'waiver'        => $waiver,
            'waiver_by'     => $waiver_by,             
            'by_user'       => $by_user,
            'active'        => 1,
        ); 
        $params2 = array(                    
            'student_package_id'=> $student_package_id,
            'amount'            => $waiver,
            'remarks'           => 'Waiver Rembursed',
            'student_id'        => $student_id,
            'type'              => '+',
            'by_user'           => $by_user,
            'created'           => date("d-m-Y h:i:s A"),
            'modified'          => date("d-m-Y h:i:s A"),
        ); 
        $params4 = array('active'=>0,'actually_used_amount'=>$waiver); 
        $idd1=null;$idd2=null;$idd3=null;
        if($allowed==1){
            $idd1 = $this->Student_package_model->update_student_pack_payment_for_waiver_remburse($student_package_id,$params);
            $idd2 = $this->Student_package_model->update_transaction($params2);        
            $idd3 = $this->Waiver_model->update_waiver_request($wid,$params4);

            $get_UID = $this->Student_model->get_UID($student_id);
            $UID = $get_UID['UID'];           
            //activity update start
                $waiver = $waiver/100;
                $activity_name = WAIVER_REMBURSE;
                $description = 'Waiver Reimbursed worth '.CURRENCY.'  '.$waiver.' for student '.$UID.' ';
                $res=$this->addUserActivity($activity_name,$description,$student_package_id,$by_user);
            //activity update end
            if($idd1 && $idd2 && $idd3){
                header('Content-Type: application/json');
                $response = ['msg'=>'Wow! Waiver Reimbursed successfully for this student', 'status'=>'true'];
                echo json_encode($response);
            }else{
                header('Content-Type: application/json');
                $response = ['msg'=>'Oh.! Waiver Reimbursed failed! Try later', 'status'=>'false'];
                echo json_encode($response);
            }
        }              
       
                
    }

    //non-real function
    function remburse_refund_(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $wid = $this->input->post('wid', TRUE);
        $refund = $this->input->post('refund', TRUE);
        $refund_by = $this->input->post('refund_by', TRUE);
        $student_package_id = $this->input->post('student_package_id', TRUE);
        $student_id = $this->input->post('student_id', TRUE);
        $by_user = $this->input->post('by_user', TRUE);
        $pack_status_pr = $this->input->post('pack_status_pr', TRUE);
        $type = $this->input->post('type', TRUE);
        $pack_cb = $this->input->post('pack_cb', TRUE);
        
        $add_payment = $refund*100;       
        $remarks = $type;
        if($type=='Full Refund' and $pack_cb!='exam') {
            $stdData = $this->Student_model->get_studentService($student_id);
            $center_id=$stdData['center_id'];
            $test_module_id=$stdData['test_module_id'];
            $programe_id=$stdData['programe_id'];
            $response = $this->full_refund_($add_payment,$remarks,$student_package_id,$student_id,$center_id,$test_module_id,$programe_id,$pack_status_pr,$pack_cb);

        }else if($type=='Full Refund' and $pack_cb=='exam') {
            $stdData = $this->Student_model->get_studentService($student_id);
            $center_id=$stdData['center_id'];
            $stdData2 = $this->Student_package_model->getBookedExamCourse($student_package_id);
            $test_module_id=$stdData2['test_module_id'];
            $programe_id=$stdData2['programe_id'];
            $response = $this->full_refund_($add_payment,$remarks,$student_package_id,$student_id,$center_id,$test_module_id,$programe_id,$pack_status_pr,$pack_cb);

        }elseif($type=='Partial Refund'){            
            $response = $this->partial_refund_($add_payment,$remarks,$student_package_id,$student_id,$pack_status_pr,$pack_cb);
        }else{
            $response=0;
        }
        
        if($response==1){  
            $params = array('active'=>0);  
            $this->Refund_model->update_refund_request($wid,$params);     
            $this->session->set_flashdata('flsh_msg','<div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success:</strong> Wow! refunded to wallet successfully for this student!.<a href="#" class="alert-link"></a>.
        </div>');          
            header('Content-Type: application/json');

            $response = ['msg'=>'Wow! refunded to wallet successfully for this student', 'status'=>'true'];
            echo json_encode($response);

        }else{
            header('Content-Type: application/json');
            $this->session->set_flashdata('<div class="alert alert-warning alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>WARNING:</strong> Oh.! Refund process failed(may be due to refund type partial/full issue.<a href="#" class="alert-link"></a>.
        </div>');  
            $response = ['msg'=>'Oh.! Refund process failed(may be due to refund type partial/full issue)! Try later', 'status'=>'false'];
            echo json_encode($response);
        }        
    }    

    //non-real function
    function student_full_details_($id){

        $id = base64_decode($id);
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $data['title'] = 'Students Full Details';
        $data['basic'] = $this->Student_model->get_studentfull_profile_admin($id);
        $data['journey'] = $this->Student_journey_model->get_journey($id);              
        $data['student_package_offline']= $this->Package_master_model->get_student_pack_subscribed_offline($id,'Bysid');
        $data['student_package_online']= $this->Package_master_model->get_student_pack_subscribed_online($id,'Bysid');
        $data['student_package_pp'] = $this->Practice_package_model->get_student_pack_subscribed($id,'Bysid');
        $data['std_docs']=$this->Student_model->getSudentDocuments($id);                
        $get_UID=$this->Student_model->get_UID($id);
        $UID = $get_UID['UID'];
        $this->load->model('Mock_test_model');
        $data['mtReportIELTS']=$this->Mock_test_model->get_std_mt_report_data_ielts($UID);
        $data['mtReportPTE']=$this->Mock_test_model->get_std_mt_report_data_pte($UID);
        $data['mtReportTOEFL']=$this->Mock_test_model->get_std_mt_report_data_toefl($UID);

        $stdInfo=$this->Student_model->get_student_info_forSMS($id);
        $email = $stdInfo['email'];
        $mobile = $stdInfo['mobile'];
        $data['_view'] = 'student/details';
        $this->load->view('layouts/main',$data);
    }       
    
    function index(){
        
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
        $data['title'] = 'All Students';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset']=($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/student/index?');
        $config['total_rows'] = $this->Student_model->get_all_students_count($_SESSION['roleName'],$userBranch);
        $this->pagination->initialize($config);
        $studentsData= $this->Student_model->get_all_students($_SESSION['roleName'],$userBranch,$params);
        foreach($studentsData as $key => $c){

            $mData_off = $this->Package_master_model->getOfflinePackTakenCount($c['id']);
            $studentsData[$key]['offlineCount']=$mData_off; 

            $mData_on = $this->Package_master_model->getOnlinePackTakenCount($c['id']);
            $studentsData[$key]['onlineCount']=$mData_on;

            $mData_pp = $this->Practice_package_model->getpp_PackTakenCount($c['id']);
            $studentsData[$key]['ppCount']=$mData_pp;

            $mData = $this->Student_package_model->getPackProfile2($c['id']);
            foreach ($mData as $key2 => $m){                
                $studentsData[$key]['Pack'][$key2]=$m;                       
            }                          
        }
        $data['students']=$studentsData;     
        $data['_view'] = 'student/index';
        $this->load->view('layouts/main',$data);
    }

    function online_registration_leads(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends

        $data['title'] = 'Sign Up leads';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE;
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/student/online_registration_leads?');
        $config['total_rows'] = $this->Student_model->get_all_students_count_ol();
        $this->pagination->initialize($config);        
        $data['students'] = $this->Student_model->get_all_students_ol($params);
        $data['_view'] = 'student/online_registration_leads';
        $this->load->view('layouts/main',$data);

    }

    function inactive_student(){

        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        $UserFunctionalBranch = $this->User_model->getUserFunctionalBranch($_SESSION['UserId']);
        $userBranch=[];
        foreach ($UserFunctionalBranch as $b){
            array_push($userBranch,$b['center_id']);
        }
        $data['title'] = 'Students- Inactive';
        $this->load->library('pagination');
        $params['limit'] = RECORDS_PER_PAGE;
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('adminController/student/inactive_student?');
        $config['total_rows'] = $this->Student_model->get_all_students_count_inactive($_SESSION['roleName'],$userBranch);
        $this->pagination->initialize($config);        
        $data['students'] = $this->Student_model->get_all_students_inactive($_SESSION['roleName'],$userBranch,$params);
        $data['_view'] = 'student/index';
        $this->load->view('layouts/main',$data);
    }

    //non-real function
    /*function remove($id){

        $id = base64_decode($id);
        //access control start
        $cn = $this->router->fetch_class().''.'.php';
        $mn = $this->router->fetch_method();        
        if(!$this->_has_access($cn,$mn)) {redirect('adminController/error_cl/index');}
        //access control ends
        
        $student = $this->Student_model->get_student($id);
        if(isset($student['id'])){

            $this->db->trans_start();
            $idd = $this->Student_model->delete_student($id,$student['mobile']);  
            $this->db->trans_complete();
            if($this->db->trans_status() === FALSE){
                $this->session->set_flashdata('flsh_msg', TRAN_FAILED_MSG);
                redirect('adminController/student/index');
            }elseif($idd){
                 $this->session->set_flashdata('flsh_msg', DEL_MSG);
                redirect('adminController/student/index');
            }else
                redirect('adminController/student/index');
            }
        else
            show_error(ITEM_NOT_EXIST);
    } */ 

    function ajax_gettax_detail()
    {
        $cgst = $this->Package_master_model->get_tax_detail('CGST');
        $sgst = $this->Package_master_model->get_tax_detail('SGST');
        $cgst_tax_per = (!empty($cgst))?$cgst['tax_per']:0;
        $sgst_tax_per = (!empty($sgst))?$sgst['tax_per']:0;
        $tax_arr = array('cgst_per'=>$cgst_tax_per,'sgst_per'=>$sgst_tax_per);
        echo json_encode($tax_arr);
    }
    
}
