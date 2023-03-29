<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 class Student_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();        
    }

    function add_money_to_wallet(){
        
        if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){
            return $this->db->query("update `students` SET 
            `wallet` = '100000'
            where active = 1 
            ");
        }else{
            return false;
        }
    }

    function getWalletAmount_API($sid){

        $this->db->select('CONCAT("'.CURRENCY.' ", FORMAT(`wallet`/100,2)) AS wallet');
        $this->db->from('`students`');       
        $this->db->where(array('id'=>$sid));
        return $this->db->get('')->row_array();
    }

    function getWalletTransactionHistory($student_id){

        $this->db->select('
            sw.id,
            sw.withdrawl_method,
            sw.withdrawl_amount,
            sw.deposited_amount,
            sw.withdrawl_image,
            sw.withdrawl_tran_id,
            sw.remarks,
            sw.created,
            u.fname,
            u.lname,
        ');
        $this->db->from('`student_withdrawl` sw');
        $this->db->join('`user` u', 'u.`id`= sw.`by_user`','left');    
        $this->db->where(array('sw.student_id'=>$student_id));
        $this->db->order_by('sw.id', 'DESC');
        return $this->db->get('')->result_array();
    }

    function getWalletTransactionHistoryAPI($student_id){

        $this->db->select('
            sw.id,
            sw.withdrawl_method,            
            CONCAT("'.CURRENCY.' ", FORMAT(sw.`withdrawl_amount`/100,2)) AS withdrawl_amount,
            CONCAT("'.CURRENCY.' ", FORMAT(sw.`deposited_amount`/100,2)) AS deposited_amount,
            sw.withdrawl_image,
            sw.withdrawl_tran_id,
            sw.remarks,
            sw.created,
            u.fname,
            u.lname,
        ');
        $this->db->from('`student_withdrawl` sw');
        $this->db->join('`user` u', 'u.`id`= sw.`by_user`');    
        $this->db->where(array('sw.student_id'=>$student_id));
        $this->db->order_by('sw.id', 'DESC');
        return $this->db->get('')->result_array();
    }

    /*function check_student($params){

        $this->db->from('students');
        $this->db->where(array('country_code'=>$params['country_code'],'mobile'=>$params['mobile']));
        return $this->db->count_all_results();
    }*/

    function getSudentDocuments($student_id){

        $this->db->select('sd.id,sd.document_file,sd.document_no,sd.document_expiry,sd.created,dtm.document_type_name');
        $this->db->from('`student_documents` sd');   
        $this->db->join('`document_type_masters` dtm', 'dtm.`id`= sd.`document_type`');    
        $this->db->where(array('student_id'=>$student_id));
        return $this->db->get('')->result_array();
    }

    function getSudentPassport($student_id){

        $this->db->select('id,document_file,document_no,document_expiry');
        $this->db->from('`student_documents`');    
        $this->db->where(array('student_id'=>$student_id,'document_type'=>4,'active'=>1));
        $this->db->order_by('id', 'DESC');
        return $this->db->get('')->result_array();
    }

    function RTdocFieldDisplay($student_id){

        $docTypeIn = [1,2,3,4,5];
        $this->db->from('student_documents');
        $this->db->where(array('student_id'=> $student_id));
        $this->db->where_in('document_type', $docTypeIn);
        return $this->db->count_all_results();
    }    

    function getOTP($lastId){

        $this->db->select('OTP,center_id,today,country_code,mobile');
        $this->db->from('`students`');       
        $this->db->where(array('id'=>$lastId));
        return $this->db->get('')->row_array();
    }

    function getInternalFeedbackLeadDeatils($lastId){

        $this->db->select('OTP,country_code,mobile,email,fname,username');
        $this->db->from('`students`');       
        $this->db->where(array('id'=>$lastId));
        return $this->db->get('')->row_array();
    }

    function get_UID($id){

        $this->db->select('UID,plain_pwd');
        $this->db->from('`students`');       
        $this->db->where(array('id'=>$id));
        return $this->db->get('')->row_array();
    }

    function getStudentCurrentStatus($id){

        $this->db->select('student_identity,center_id,test_module_id,programe_id');
        $this->db->from('`students`');       
        $this->db->where(array('id'=>$id));
        return $this->db->get('')->row_array();
    }

    function getWalletAmount($sid){

        $this->db->select('wallet');
        $this->db->from('`students`');       
        $this->db->where(array('id'=>$sid));
        return $this->db->get('')->row_array();
    }

    function getMax_WaitingToken($todaystr,$center_id){

        return $this->db->query('SELECT MAX(waitingToken) AS `maxid` FROM `students` where today ='.$todaystr.' and center_id = '.$center_id.'')->row()->maxid;
    }

    function get_count($test_module_id, $programe_id, $batch_id, $center_id)
    {        
        $this->db->from('students');
        $this->db->where(array('test_module_id'=> $test_module_id, 'programe_id'=> $programe_id, 'batch_id'=> $batch_id, 'center_id'=> $center_id));
        return $this->db->count_all_results();
    }

    function check_studentLogin($username, $password)
    { 
        $this->db->from('students');
        $this->db->where('password', md5($password));
        $this->db->where('active', 1);
        $this->db->group_start()
        ->where('username',$username)
        ->or_where('email',$username)
        ->or_where('mobile',$username)
        ->or_where('UID',$username)
        ->group_end();
        return $this->db->count_all_results();
        //print_r($this->db->last_query());exit;
    }

   
    function check_std_email_availibility($email)
    {        
        $this->db->from('students');
        $this->db->where(array('email'=> $email));
        return $this->db->count_all_results();
    }

    function check_std_email_availibility_fp($email)
    {        
        $this->db->from('students');
        $this->db->where(array('email'=> $email,'active'=>1));
        return $this->db->count_all_results();
    }

    
    function check_std_mobile_availibility($mobile)
    {        
        $this->db->from('students');
        $this->db->where(array('mobile'=> $mobile));
        return $this->db->count_all_results();
    } 

    function checkStudentExistence($mobile,$email){

        $this->db->select('id,fresh,active,is_otp_verified,is_email_verified');
        $this->db->from('`students`');
       // $this->db->where(array('mobile'=> $mobile,'email'=>$email));       
       $this->db->where(array('mobile'=>$mobile)); 
       $this->db->or_where(array('email'=>$email));    
        return $this->db->get('')->row_array();
    }

   
    function get_all_students_trans_count($student_package_id,$student_id)
    {
        $this->db->from('student_transaction_history');
        $this->db->where(array('student_package_id'=> $student_package_id,'student_id'=>$student_id));
        return $this->db->count_all_results();
    }

    function get_all_students_trans($student_package_id,$student_id){

        $this->db->select('            
            CONCAT("'.CURRENCY.' ", FORMAT(sth.`amount`/100,2)) AS amount,
            sth.created as created,
            sth.modified as modified,
            sth.type,
            sth.remarks,
            sth.file,                       
            u.fname as fnameu,
            u.lname as lnameu,
            u.id as uid,
        ');
        $this->db->from('`student_transaction_history` sth');
        //$this->db->join('`students` s', 's.`id`= sth.`student_id`', 'left');       
        $this->db->join('`user` u', 'u.`id`= sth.`by_user`', 'left');        
        $this->db->where(array('sth.student_package_id'=>$student_package_id, 'sth.student_id'=>$student_id));     
        return $this->db->get('')->result_array();
    }

    function mobile_no_exists($mobile){
        $this->db->select('id,fname');
        return $this->db->get_where('students',array('mobile'=>$mobile))->row_array();
    }

    function check_status($mobile){

        $this->db->select('active');
        return $this->db->get_where('students',array('mobile'=>$mobile))->result_array();
    }

    function get_student($id)
    {  
        $this->db->select('*');
        $this->db->from('students');
        $this->db->where(array('id'=> $id));
        return $this->db->get('')->row_array();      
    }

    function get_student_short($id){

        $this->db->select('fname,email,username,UID,mobile');
        $this->db->from('students');
        $this->db->where(array('id'=> $id));
        return $this->db->get('')->row_array();
    }

    function get_studentId($username,$password){
        
        $this->db->select('id');
        $this->db->from('students');
        $this->db->where('password', md5($password));
        $this->db->where('active', 1);
        $this->db->group_start()
        ->where('username',$username)
        ->or_where('email',$username)
        ->or_where('mobile',$username)
        ->or_where('UID',$username)
        ->group_end();
        return $this->db->get('')->row_array();
    }

    function get_studentService($id){
        
        $this->db->select('service_id,programe_id,test_module_id,center_id');
        $this->db->from('students');
        $this->db->where(array('id'=> $id));
        return $this->db->get('')->row_array();
    }

    function get_studentId_byEmail($email){
        
        $this->db->select('id');
        $this->db->from('students');
        $this->db->where(array('email'=> $email));
        return $this->db->get('')->row_array();
    }

    function get_studentId_byMobile($country_code,$mobile){
        
        $this->db->select('id');
        $this->db->from('students');
        $this->db->where(array('country_code'=>$country_code, 'mobile'=> $mobile));
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }

    function get_studentfull_profile($id){

        $this->db->select('
            s.id,
            s.UID,
            s.profileUpdate,
            s.loggedIn,
            s.is_otp_verified,
            s.is_email_verified,
            s.profile_pic,
            s.fname,
            s.lname,
            s.father_name,
            s.country_code,
            s.country_iso3_code,
            s.dob,
            s.gender,
            s.email,
            s.mobile,
            s.residential_address,
            s.`zip_code`,
            g.`gender_name`,
            state.state_name,
            city.city_name,
            country.iso3 as country_name,
            country.name as country_namefull,
            CONCAT("INR ", FORMAT(s.`wallet`/100,2)) AS wallet,
            student_token.token,
            s.country_id,
            s.state_id,
            s.city_id,
            s.plain_pwd
        ');
        $this->db->from('`students` s');
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->join('`state`', 'state.`state_id`= s.`state_id`','left');
        $this->db->join('`city`', 'city.city_id= s.`city_id`', 'left');
        $this->db->join('`country`', 'country.country_id= s.`country_id`', 'left');
        $this->db->join('`student_token`', 'student_token.`student_id`= s.`id`','left');
        $this->db->where(array('s.id'=>$id));     
        return $this->db->get('')->row_array();
        
    } 


    function get_studentfull_profile_admin($id){

        $this->db->select('
            s.id,
            CONCAT("'.CURRENCY.' ", FORMAT(s.`wallet`/100,2)) AS wallet,
            s.student_identity,
            s.UID,s.profileUpdate,
            s.loggedIn,
            s.is_otp_verified,
            s.is_email_verified,
            s.profile_pic,
            s.fname,
            s.lname,
            s.father_name,
            s.country_code,
            s.dob,
            s.gender,
            s.email,
            s.mobile,
            s.residential_address, 
            pgm.programe_id, 
            pgm.`programe_name`,
            g.`gender_name`,
            tm.test_module_id, 
            tm.test_module_name,
            cl.center_name,
            sm.source_name
        ');
        $this->db->from('`students` s');
        $this->db->join('`test_module` tm', 's.`test_module_id`=tm.`test_module_id`','left');
        $this->db->join('`programe_masters` pgm', 's.`programe_id`=pgm.`programe_id`','left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left');
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->join('`source_masters` sm', 'sm.`id`= s.`source_id`', 'left');
        $this->db->where(array('s.id'=>$id));     
        return $this->db->get('')->row_array();
    }

    function get_studentfull_profileDashborad($id){

        $this->db->select('
            s.id,
            s.profileUpdate,
            s.fname,
            s.lname,
            s.father_name,
            s.country_code,
            s.country_iso3_code,
            s.dob,
            s.gender,
            s.residential_address,
            g.`gender_name`,
            s.mobile,
            s.email,
            s.mother_name,
            s.mother_dob,
            s.father_dob,
            s.parents_anniversary,
            s.gaurdian_contact,
            s.qualification_id,
            s.int_country_id,
            s.source_id,
            s.gar_country_code,
            s.is_otp_verified, 
            s.country_id,
            s.city_id,
            s.state_id,
            s.`zip_code`,           
            state.state_name,
            city.city_name,   
                   
        ');
        $this->db->from('`students` s');
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->join('`state`', 'state.`state_id`= s.`state_id`','left');
        $this->db->join('`city`', 'city.city_id= s.`city_id`', 'left');
        $this->db->join('`country`', 'country.country_id= s.`country_id`', 'left');
        $this->db->where(array('s.id'=>$id));     
        return $this->db->get('')->row_array();
    }  

    /*
     * Get student by student_id
     */
    function get_student_info($id){

        $this->db->distinct('');
        $this->db->select('s.id,s.programe_id,s.fname,s.lname,s.dob,s.gender,s.email,s.mobile,s.residential_address, pgm.`programe_name`,g.`gender_name`');
        $this->db->from('`students` s');        
        $this->db->join('`programe_masters` pgm', 's.`programe_id`= pgm.`programe_id`', 'left'); 
        $this->db->join('`student_results` sr', 'sr.`student_id`= s.`id`', 'left'); 
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->where(array('s.id'=>$id));     
        return $this->db->get('')->result_array();      
    }

    
    function get_student_info_forSMS($id)
    {       
        $this->db->select('fname,email,mobile,country_id');
        $this->db->from('`students`');   
        $this->db->where(array('id'=>$id));     
        return $this->db->get('')->row_array();      
    }    

    /*
     * Get all students count INACTIVE
     */
    function get_all_students_count_inactive($roleName,$userBranch)
    {
        $this->db->from('students');
        if($roleName==ADMIN){            
            $this->db->where(array('active'=>0));
        }else{
            if($userBranch){
                $this->db->where(array('active'=>0));
                $this->db->where_in('center_id', $userBranch);
            }else{
                $userBranch=0;
                $this->db->where(array('active'=>0));
                $this->db->where_in('center_id', $userBranch);
            }                        
        }        
        return $this->db->count_all_results();
    }
    
    function get_all_students_count_ol()
    {
        $this->db->from('students');
        $this->db->where(array('active'=>1,'fresh'=>1));
        return $this->db->count_all_results();
    }

    function get_all_student_request($roleName,$userBranch){

        $this->db->select('id,UID,fname,lname');
        $this->db->from('`students`');
        if($roleName==ADMIN){            
            $this->db->where(array('active'=> 1));
        }else{
            if($userBranch){
                $this->db->where(array('active'=>1));
                $this->db->where_in('center_id', $userBranch);
            }else{
                $userBranch=0;
                $this->db->where(array('active'=>1));
                $this->db->where_in('center_id', $userBranch);
            }                        
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get('')->result_array();
    }


    function get_all_student_waiver($roleName,$userBranch){

        $this->db->select('id,UID,fname,lname');
        $this->db->from('`students`');
        if($roleName==ADMIN){            
            $this->db->where(array('active'=> 1));
        }else{
            if($userBranch){
                $this->db->where(array('active'=>1));
                $this->db->where_in('center_id', $userBranch);
            }else{
                $userBranch=0;
                $this->db->where(array('active'=>1));
                $this->db->where_in('center_id', $userBranch);
            }                        
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get('')->result_array();
    }

    function get_all_student_refund($roleName,$userBranch){

        /*$this->db->select('id,UID,fname,lname');
        $this->db->from('`students`');
        if($roleName==ADMIN){            
            $this->db->where(array('active'=> 1));
        }else{
            if($userBranch){
                $this->db->where(array('active'=>1));
                $this->db->where_in('center_id', $userBranch);
            }else{
                $userBranch=0;
                $this->db->where(array('active'=>1));
                $this->db->where_in('center_id', $userBranch);
            }                        
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get('')->result_array();*/

        $this->db->distinct('');
        $this->db->select('id,UID,fname,lname');
        $this->db->from('`students` s');
        $this->db->join('`student_package` sp','sp.`student_id`= s.`id`','left');
        if($roleName==ADMIN){            
            $this->db->where(array('sp.active'=> 1));
        }else{
            if($userBranch){
                $this->db->where(array('sp.active'=>1));
                $this->db->where_in('s.center_id', $userBranch);
            }else{
                $userBranch=0;
                $this->db->where(array('sp.active'=>1));
                $this->db->where_in('s.center_id', $userBranch);
            }                        
        }
        $this->db->order_by('s.id', 'DESC');
        return $this->db->get('')->result_array();
    }

    function get_all_students_count($roleName,$userBranch)
    {       
        $this->db->from('students');
        if($roleName==ADMIN){            
            $this->db->where(array('fresh'=>2));
        }else{
            if($userBranch){
                $this->db->where(array('fresh'=>2));
                $this->db->where_in('center_id', $userBranch);
            }else{
                $userBranch=0;
                $this->db->where(array('fresh'=>2));
                $this->db->where_in('center_id', $userBranch);
            }                        
        }      
        return $this->db->count_all_results();
    }

    
    function get_all_students($roleName,$userBranch,$params = array())
    {   
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('SUM(amount_due) as amount_due,s.id,s.is_otp_verified,s.is_email_verified,s.all_center_id,s.student_identity,s.UID,s.fname,s.lname,s.email,s.country_code,s.mobile,s.active,s.loggedIn,pgm.`programe_name`,tm.test_module_name,cl.center_name');
        $this->db->from('`students` s');        
        $this->db->join('`programe_masters` pgm','s.`programe_id`= pgm.`programe_id`','left');
        $this->db->join('`test_module` tm','tm.`test_module_id`= s.`test_module_id`', 'left');
        $this->db->join('`center_location` cl','cl.`center_id`= s.`center_id`', 'left');
        $this->db->join('`student_package` spkg','spkg.`student_id`= s.`id`', 'left');
        if($roleName==ADMIN){
            $this->db->where(array('s.fresh>'=>0,'s.active'=>1));
        }else{
            
            $brCount = count($userBranch);
            $where='';
            if($userBranch){
                $i=0;
                foreach ($userBranch as $ub){
                    if($i<$brCount-1){
                        $where .= "FIND_IN_SET('".$ub."', s.`all_center_id`) OR "; 
                    }else{
                        $where .= "FIND_IN_SET('".$ub."', s.`all_center_id`) ";
                    }                    
                    $i++;
                }                                
                $this->db->where(array('s.fresh>'=>0,'s.active'=>1));
                $this->db->where($where);
            }else{
                $userBranch=0;
                $i=0;
                foreach ($userBranch as $ub){
                    if($i<$brCount-1){
                        $where .= "FIND_IN_SET('".$ub."', s.`all_center_id`) OR "; 
                    }else{
                        $where .= "FIND_IN_SET('".$ub."', s.`all_center_id`) ";
                    }                    
                    $i++;
                }                                
                $this->db->where(array('s.fresh>'=>0,'s.active'=>1));
                //$this->db->where($where);
            }           
        }        
        $this->db->order_by('s.modified', 'desc');
        $this->db->group_by('s.id');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }    

    function get_all_students_inactive($roleName,$userBranch,$params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('s.id,s.student_identity,s.UID,s.fname,s.lname,s.email,s.mobile,s.profile_pic,s.active,s.loggedIn,pgm.`programe_name`,tm.test_module_name,cl.center_name');
        $this->db->from('`students` s');        
        $this->db->join('`programe_masters` pgm', 's.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= s.`test_module_id`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left');
        if($roleName==ADMIN){            
            $this->db->where(array('s.active'=> 0));
        }else{
            if($userBranch){
                $this->db->where(array('s.active'=>0));
                $this->db->where_in('s.center_id', $userBranch);
            }else{
                $userBranch=0;
                $this->db->where(array('s.active'=>0));
                $this->db->where_in('s.center_id', $userBranch);
            }                        
        }
        $this->db->order_by('s.id', 'DESC');
        //$this->db->group_by('s.id');     
        return $this->db->get('')->result_array();
    }

     /*
     * Get all students Acad
     */
    function get_all_students_ol($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('s.id,s.student_identity,s.UID,s.fname,s.lname,s.email,s.country_code,s.mobile,s.profile_pic,s.active,s.loggedIn,pgm.`programe_name`,tm.test_module_name,cl.center_name');
        $this->db->from('`students` s');        
        $this->db->join('`programe_masters` pgm', 's.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= s.`test_module_id`', 'left');
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left');
        $this->db->where(array('s.active'=>1, 'fresh'=>1));
        $this->db->order_by('s.id', 'desc');
        return $this->db->get('')->result_array();
    }
    
    function get_student_name($student_id){

        $this->db->select('fname,mobile,email,center_id');
        $this->db->from('`students`'); 
        $this->db->where(array('id'=>$student_id));     
        return $this->db->get('')->row_array();
    } 

    function getPassword($id){

        $this->db->select('password');
        $this->db->from('`students`'); 
        $this->db->where(array('id'=>$id));     
        return $this->db->get('')->row_array();
    }  

    function getMax_UID(){
        return $this->db->query('SELECT MAX(UID) AS `maxid` FROM `students`')->row()->maxid;
    }        
    
    function add_document($params)
    {        
        $this->db->insert('student_documents',$params);
        return $this->db->insert_id();
    }    

    function add_withdrawl($params){
        $this->db->insert('student_withdrawl',$params);
        return $this->db->insert_id();
    }
    function update_session_status($booking_id,$params)
    {                    
        $this->db->where('booking_id',$booking_id);
        return $this->db->update('session_booking',$params);
    }  
    
    
    function update_student($id,$params)
    {                    
        $this->db->where('id',$id);
        return $this->db->update('students',$params);
    }

    function update_student_wallet($student_id,$restAmount){     

        return $this->db->query("update `students` SET 
            `wallet` = `wallet` + '".$restAmount."'
            where id = '".$student_id."' 
        ");
    }  

    function update_student_wallet_payment($student_id,$restAmount){     

        return $this->db->query("update `students` SET 
            `wallet` = '".$restAmount."'
            where id = '".$student_id."' 
        ");
    }
    
    function delete_student($id,$mobile){
       
        //$this->db->delete('students',array('id'=>$id));             
        $this->db->delete('student_journey',array('student_id'=>$id));
        $this->db->delete('student_package',array('student_id'=>$id));
        $this->db->delete('student_transaction_history',array('student_id'=>$id));
        $this->db->delete('waiver_request',array('student_id'=>$id));
        $this->db->delete('refund_request',array('student_id'=>$id));
        $this->db->delete('reality_test_booking',array('student_id'=>$id));
        $this->db->delete('student_class_posts',array('student_id'=>$id));
        $this->db->delete('walkin',array('mobile'=>$mobile));  
        $this->db->delete('students_enquiry',array('mobile'=>$mobile));  
        $this->db->delete('student_documents',array('student_id'=>$id));
        $this->db->delete('student_withdrawl',array('student_id'=>$id));
        $this->db->delete('student_attendance',array('student_id'=>$id));
        $this->db->delete('student_attendance_main',array('student_id'=>$id));
        $this->db->delete('session_booking',array('student_id'=>$id));
        $params=array('wallet'=>0);
        $this->db->where('id',$id);
        $this->db->update('students',$params);
    }

    function delete_all_student_tran(){
       
       if(ENVIRONMENT!='production'){
            //$this->db->delete('students',array('id'=>$id));
            $this->db->delete('student_journey',array('student_id>'=>0));
            $this->db->delete('student_package',array('student_id>'=>0));
            $this->db->delete('student_transaction_history',array('student_id>'=>0));
            $this->db->delete('waiver_request',array('student_id>'=>0));
            $this->db->delete('refund_request',array('student_id>'=>0));            
            $this->db->delete('student_class_posts',array('student_id>'=>0));
            $this->db->delete('students_enquiry',array('enquiry_id>'=>0));
            $this->db->delete('students_enquiry_reply',array('enquiry_id>'=>0));  
            $this->db->delete('student_documents',array('student_id>'=>0));
            $this->db->delete('student_withdrawl',array('student_id>'=>0));
            $this->db->delete('student_attendance',array('student_id>'=>0));
            $this->db->delete('student_attendance_main',array('student_id>'=>0));
            $this->db->delete('mock_test_report_ielts',array('id>'=>0));
            $this->db->delete('mock_test_report_pte',array('id>'=>0)); 
            $this->db->delete('mock_test_report_toefl',array('id>'=>0));           
            $this->db->delete('student_promocodes',array('student_id>'=>0));
            $this->db->delete('session_booking',array('student_id>'=>0));
            $params=array('wallet'=>0,'waitingToken'=>0, 'profileUpdate'=>0,'loggedIn'=>0,'password'=>'7f1f4376ae77615de2f68908cb83c3b8');
            $this->db->update('students',$params);
        }
    }

    
    function getMailData($student_package_id){        
        
        $this->db->select('
            s.fname,
            s.email,
            s.mobile,
            s.username,
            pkg.`package_name`,
            pkg.`amount` AS amount,
            pkg.`discounted_amount` AS discounted_amount,
            spkg.`package_duration` as duration,
            spkg.`payment_id`,
            FORMAT(spkg.`amount_paid`/100,2) AS amount_paid,
            FORMAT(spkg.`waiver`/100,2) AS waiver,
            FORMAT(spkg.`other_discount`/100,2) AS other_discount,           
            FORMAT(spkg.`amount_due`/100,2) AS amount_due,
            FORMAT(spkg.`amount_refund`/100,2) AS amount_refund,           
            spkg.`waiver_by`,
            spkg.`currency`,
            spkg.`method`,
            spkg.subscribed_on as `subscribed_on`,
            spkg.expired_on as `expired_on`,
            spkg.requested_on as `requested_on`,
            spkg.`pack_type`,
        ');
        $this->db->from('`students` s');       
        $this->db->join('`student_package` spkg', 'spkg.`student_id`= s.`id`', 'left');
        $this->db->join('`package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`', 'left');
        $this->db->where(array('spkg.student_package_id'=> $student_package_id));
        return $this->db->get('')->row_array();
    }

    function getMailData_pp($student_package_id){        
        
        $this->db->select('
            s.fname,
            s.email,
            s.mobile,
            s.username,
            s.UID,
            pkg.`package_name`,
            pkg.`amount` AS amount,
            pkg.`discounted_amount` AS discounted_amount,
            spkg.`package_duration` as duration,
            spkg.`payment_id`,
            FORMAT(spkg.`amount_paid`/100,2) AS amount_paid,
            FORMAT(spkg.`waiver`/100,2) AS waiver,
            FORMAT(spkg.`other_discount`/100,2) AS other_discount,
            FORMAT(spkg.`amount_due`/100,2) AS amount_due,
            FORMAT(spkg.`amount_refund`/100,2) AS amount_refund,
            spkg.`method`,
            spkg.`waiver_by`,
            spkg.subscribed_on as `subscribed_on`,
            spkg.expired_on as `expired_on`,
            spkg.requested_on as `requested_on`,          
            pgm.`programe_name`,
            tm.test_module_name,
            cl.center_name,
            spkg.`currency`,
            spkg.`pack_type`,
        ');
        $this->db->from('`students` s');       
        $this->db->join('`student_package` spkg', 'spkg.`student_id`= s.`id`', 'left');
        $this->db->join('`practice_package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`', 'left');
        $this->db->join('`programe_masters` pgm', 's.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 's.`test_module_id`= tm.`test_module_id`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left');
        //$this->db->where(array('s.id'=> $sid));
        $this->db->where(array('spkg.student_package_id'=> $student_package_id));
        return $this->db->get('')->row_array();
    }
    
    function getMailData_forReg($student_id)
    { 
        $this->db->select('
            fname,
            lname,            
            email,
            username,
            country_code,
            mobile,
            center_id,
            test_module_id,
            programe_id,
            UID
        ');
        $this->db->from('`students`'); 
        $this->db->where(array('id'=> $student_id));
        return $this->db->get('')->row_array();
    }
    

    function get_tm_pgm_b($id,$center_id){

        $this->db->select('cl.center_name');
        $this->db->from('`students` s');        
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left');
        $this->db->where(array('s.id'=>$id, 's.center_id'=>$center_id));     
        return $this->db->get('')->row_array();
    }

    function get_mobile($id){

        $this->db->select('mobile');
        $this->db->from('`students`');
        $this->db->where(array('id'=>$id));     
        return $this->db->get('')->row_array();
    }
    
    /*function search_students($params){        
        
        $query='';
        $cf = $params['cf'];
        if($cf!=''){ 

            $query.= " s.fname LIKE '%".$cf."%' or ";
            $query.= " s.lname LIKE '%".$cf."%' or ";
            $query.= " s.email LIKE '%".$cf."%' or ";
            $query.= " s.mobile LIKE '%".$cf."%' or";
            $query.= " s.UID LIKE '%".$cf."%' ";
        }         
        $x = $this->db->query('select SUM(amount_due) as amount_due,s.id,s.loggedIn,s.all_center_id,s.student_identity,s.UID,s.fname,s.lname,s.email,s.mobile,s.profile_pic,s.active, pgm.programe_name,tm.test_module_name,cl.center_name 
        from students s
        left join test_module tm on tm.test_module_id = s.test_module_id
        left join programe_masters pgm on pgm.programe_id = s.programe_id
        left join center_location cl on cl.center_id = s.center_id
        left join student_package spkg on spkg.student_id = s.id
        where '.$query.' group by s.id');
        return $x->result_array(); 
        //print_r($this->db->last_query());exit;
    }*/

    function get_all_walkin_count($test_module_id)
    {
        $this->db->from('students');
        if($test_module_id>0){
           $this->db->where(array('test_module_id'=>$test_module_id,'fresh<'=>2)); 
        }else{
            $this->db->where(array('fresh<'=>2));
        }
        return $this->db->count_all_results();
    }

    function get_all_walkin_count_verified()
    {
        $this->db->from('students');        
        $this->db->where(array('is_otp_verified'=>1,'fresh<'=>2));
        return $this->db->count_all_results();
    } 

    function get_all_walkin_count_non_verified()
    {
        $this->db->from('students');        
        $this->db->where(array('is_otp_verified'=>0,'fresh<'=>2));
        return $this->db->count_all_results();
    }

    function get_all_walkin_count_active()
    {
        $this->db->from('students');        
        $this->db->where(array('active'=>1,'fresh<'=>2));
        return $this->db->count_all_results();
    }

    function get_all_walkin_count_inactive()
    {
        $this->db->from('students');        
        $this->db->where(array('active'=>0,'fresh<'=>2));
        return $this->db->count_all_results();
    }

    function get_all_walkin_count_today()
    {
        $today = date('d-m-Y');
        $todaystr = strtotime($today);
        $this->db->from('students');
        $this->db->where(array('today'=> $todaystr,'fresh<'=>2));
        return $this->db->count_all_results();
    }

    function get_all_walkin_count_fresh()
    {
        $this->db->from('students');        
        $this->db->where(array('fresh'=>0));
        return $this->db->count_all_results();
    }

    function get_all_walkin_count_revisit()
    {
        $this->db->from('students');        
        $this->db->where(array('fresh'=>1));
        return $this->db->count_all_results();
    } 

    function getPassportDoc($id){

        $this->db->from('student_documents');        
        $this->db->where(array('student_id'=>$id, 'document_type'=>4,'document_file!='=>'','active'=>1));
        return $this->db->count_all_results();
    }  

    function get_all_walkin($test_module_id,$params = array())
    {        
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('s.id,s.fresh,s.student_identity,s.waitingToken,s.fname,s.lname,s.dob,s.gender,s.email,s.country_code,s.mobile,s.active, pgm.`programe_name`,g.`gender_name`,tm.test_module_name,cl.center_name,cnt.name,q.qualification_name');
        $this->db->from('`students` s');        
        $this->db->join('`programe_masters` pgm', 's.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= s.`test_module_id`', 'left'); 
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left'); 
        $this->db->join('`country` cnt', 'cnt.`country_id`= s.`int_country_id`', 'left');
        $this->db->join('`qualification_masters` q', 'q.`id`= s.`qualification_id`', 'left');       
        if($test_module_id>0){
            $this->db->where(array('s.test_module_id'=> $test_module_id,'fresh<'=>2));
        }else{
            $this->db->where(array('fresh<'=>2));
        }
        $this->db->order_by('s.waitingToken', 'ASC');
        return $this->db->get('')->result_array();
    }

    function get_all_walkin_verified($params = array())
    {        
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('s.id,s.fresh,s.student_identity,s.waitingToken,s.fname,s.lname,s.dob,s.gender,s.email,s.country_code,s.mobile,s.active, pgm.`programe_name`,g.`gender_name`,tm.test_module_name,cl.center_name,cnt.name,q.qualification_name');
        $this->db->from('`students` s');        
        $this->db->join('`programe_masters` pgm', 's.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= s.`test_module_id`', 'left'); 
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left'); 
        $this->db->join('`country` cnt', 'cnt.`country_id`= s.`int_country_id`', 'left');
        $this->db->join('`qualification_masters` q', 'q.`id`= s.`qualification_id`', 'left');       
        $this->db->where(array('s.is_otp_verified'=> 1,'fresh<'=>2));        
        $this->db->order_by('s.waitingToken', 'ASC');
        return $this->db->get('')->result_array();
    }

    
    function get_all_walkin_non_verified($params = array())
    {        
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('s.id,s.fresh,s.student_identity,s.waitingToken,s.fname,s.lname,s.dob,s.gender,s.email,s.country_code,s.mobile,s.active, pgm.`programe_name`,g.`gender_name`,tm.test_module_name,cl.center_name,cnt.name,q.qualification_name');
        $this->db->from('`students` s');        
        $this->db->join('`programe_masters` pgm', 's.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= s.`test_module_id`', 'left'); 
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left'); 
        $this->db->join('`country` cnt', 'cnt.`country_id`= s.`int_country_id`', 'left');
        $this->db->join('`qualification_masters` q', 'q.`id`= s.`qualification_id`', 'left');       
        $this->db->where(array('s.is_otp_verified'=> 0,'fresh<'=>2));        
        $this->db->order_by('s.waitingToken', 'ASC');
        return $this->db->get('')->result_array();
    }

    
    function get_all_walkin_active($params = array())
    {        
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('s.id,s.fresh,s.student_identity,s.waitingToken,s.fname,s.lname,s.dob,s.gender,s.email,s.country_code,s.mobile,s.active, pgm.`programe_name`,g.`gender_name`,tm.test_module_name,cl.center_name,cnt.name,q.qualification_name');
        $this->db->from('`students` s');        
        $this->db->join('`programe_masters` pgm', 's.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= s.`test_module_id`', 'left'); 
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left'); 
        $this->db->join('`country` cnt', 'cnt.`country_id`= s.`int_country_id`', 'left');
        $this->db->join('`qualification_masters` q', 'q.`id`= s.`qualification_id`', 'left');       
        $this->db->where(array('s.active'=> 1,'fresh<'=>2));        
        $this->db->order_by('s.waitingToken', 'ASC');
        return $this->db->get('')->result_array();
    }

    
    function get_all_walkin_inactive($params = array())
    {        
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('s.id,s.fresh,s.student_identity,s.waitingToken,s.fname,s.lname,s.dob,s.gender,s.email,s.country_code,s.mobile,s.active, pgm.`programe_name`,g.`gender_name`,tm.test_module_name,cl.center_name,cnt.name,q.qualification_name');
        $this->db->from('`students` s');        
        $this->db->join('`programe_masters` pgm', 's.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= s.`test_module_id`', 'left'); 
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left'); 
        $this->db->join('`country` cnt', 'cnt.`country_id`= s.`int_country_id`', 'left');
        $this->db->join('`qualification_masters` q', 'q.`id`= s.`qualification_id`', 'left');       
        $this->db->where(array('s.active'=> 0,'fresh<'=>2));        
        $this->db->order_by('s.waitingToken', 'ASC');
        return $this->db->get('')->result_array();
    }

    
    function get_all_walkin_today($params = array())
    {        
        $today = date('d-m-Y');
        $todaystr = strtotime($today);
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('s.id,s.fresh,s.student_identity,s.waitingToken,s.fname,s.lname,s.dob,s.gender,s.email,s.country_code,s.mobile,s.active, pgm.`programe_name`,g.`gender_name`,tm.test_module_name,cl.center_name,cnt.name,q.qualification_name');
        $this->db->from('`students` s');        
        $this->db->join('`programe_masters` pgm', 's.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= s.`test_module_id`', 'left'); 
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left'); 
        $this->db->join('`country` cnt', 'cnt.`country_id`= s.`int_country_id`', 'left');
        $this->db->join('`qualification_masters` q', 'q.`id`= s.`qualification_id`', 'left');       
        $this->db->where(array('s.today'=> $todaystr,'fresh<'=>2));        
        $this->db->order_by('s.waitingToken', 'ASC');
        return $this->db->get('')->result_array();
    }

    
    function get_all_walkin_fresh($params = array())
    {        
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('s.id,s.fresh,s.student_identity,s.waitingToken,s.fname,s.lname,s.dob,s.gender,s.email,s.country_code,s.mobile,s.active, pgm.`programe_name`,g.`gender_name`,tm.test_module_name,cl.center_name,cnt.name,q.qualification_name');
        $this->db->from('`students` s');        
        $this->db->join('`programe_masters` pgm', 's.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= s.`test_module_id`', 'left'); 
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left'); 
        $this->db->join('`country` cnt', 'cnt.`country_id`= s.`int_country_id`', 'left');
        $this->db->join('`qualification_masters` q', 'q.`id`= s.`qualification_id`', 'left');       
        $this->db->where(array('s.fresh'=> 0));        
        $this->db->order_by('s.waitingToken', 'ASC');
        return $this->db->get('')->result_array();
    }

    
    function get_all_walkin_revisit($params = array())
    {        
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('s.id,s.fresh,s.student_identity,s.waitingToken,s.fname,s.lname,s.dob,s.gender,s.email,s.country_code,s.mobile,s.active, pgm.`programe_name`,g.`gender_name`,tm.test_module_name,cl.center_name,cnt.name,q.qualification_name');
        $this->db->from('`students` s');        
        $this->db->join('`programe_masters` pgm', 's.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= s.`test_module_id`', 'left'); 
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= s.`center_id`', 'left'); 
        $this->db->join('`country` cnt', 'cnt.`country_id`= s.`int_country_id`', 'left');
        $this->db->join('`qualification_masters` q', 'q.`id`= s.`qualification_id`', 'left');       
        $this->db->where(array('s.fresh'=> 1));        
        $this->db->order_by('s.waitingToken', 'ASC');
        return $this->db->get('')->result_array();
    }

    function getstudentInfo($student_id){

        $this->db->select('fname,lname,UID');
        $this->db->from('`students`'); 
        $this->db->where(array('id'=>$student_id));     
        return $this->db->get('')->row_array();
    } 

    function getstudentBranch($student_id){

        $this->db->select('center_id');
        $this->db->from('`students`'); 
        $this->db->where(array('id'=>$student_id));     
        return $this->db->get('')->row_array();
    }

    function getStudentID_byUID($UID){

        $this->db->select('id');
        $this->db->from('`students`'); 
        $this->db->where(array('UID'=>$UID));     
        return $this->db->get('')->row_array();
    }
    
    /**
     * getStudentFullInfoById will be used to get row of student details of selected student id
     * 
     * @param int $student_id
     * @return array|null
     */
    public function getStudentFullInfoById(int $student_id) {
        return $this->db->select('*')
                        ->from('students')
                        ->where('id', $student_id)
                        ->get()->row_array();
    }
    
    /**
     * 
     * @param int $student_id
     * @param array $data
     * @return type
     */
    public function updateStudentParams(int $student_id, array $data) {
        $this->db->where('id', $student_id);
        return $this->db->update('students', $data);
    }
    
    /**
     * 
     * @param array $params
     * @return int
     */
    public function storeStudent(array $params) {
        if (isset($params['mobile']) && $params['mobile'] != '') {
            $row = $this->db->select('id')->from('students')->where('mobile', $params['mobile'])->get()->row();
            if ($row) {
                return $row->id;
            } else {
                $this->db->insert('students', $params);
                return $this->db->insert_id();
            }
        } else {
            $this->db->insert('students', $params);
            return $this->db->insert_id();
        }
    }

    /**
     * 
     * @param string $country_code
     * @param string $mobile
     * @return array
     */
    public function getStudentsByMobileNumber(string $country_code, string $mobile) {
        return $this->db->select('*')
                        ->from('students')
                        ->where(['country_code' => $country_code, 'mobile' => $mobile])
                        ->group_by('id')
                        ->get()->result_array();
    }

    /**
     * 
     * @param string $country_code
     * @param string $mobile
     * @return array
     */
    public function getStudentInfoByMobileNumber(string $country_code, string $mobile) {
        return $this->db->select('*')
                        ->from('students')
                        ->where(['country_code' => $country_code, 'mobile' => $mobile])
                        ->group_by('id')
                        ->get()->row_array();
    }

    function add_student($params)
    {        
        $this->db->from('students');
        $this->db->where(array('email'=>  $params['email']));
        $email_count = $this->db->count_all_results();

        $this->db->from('students');
        $this->db->where(array('mobile'=>  $params['mobile']));
        $mobile_count = $this->db->count_all_results();
        if($email_count+$mobile_count>0){
            return 'duplicate';
        }else{
            $this->db->insert('students',$params);
            return $this->db->insert_id();
        }       
    }
    // Added by Vikram 6 dec 2022
    /**
     * Summary of updateUserToken
     * @param mixed $employeId
     * @param mixed $params_token
     * @return mixed
     */
    public function updateStudentToken($student_id,$params_token){

        $this->db->where('student_id',$student_id);
        return $this->db->update('student_token',$params_token);
    }
    /**
     * Summary of addUserToken
     * @param mixed $params_token
     * @return mixed
     */
    public function addStudentToken($params_token){ 

        $this->db->insert('student_token',$params_token);
        return $this->db->insert_id();        
    }
    /**
     * Summary of checkTokenCount
     * @param mixed $employeId
     * @return mixed
     */
    public function checkTokenCount($student_id){
        $this->db->from('student_token');
        $this->db->where(array('student_id'=> $student_id));
        return $this->db->count_all_results();  
    }
    /**
     * Summary of verifyToken
     * @param mixed $student_id
     * @return mixed
     */
    public function verifyToken($student_id){      
        
        $this->db->select('token,status');
        $this->db->from('student_token'); 
        $this->db->where('student_id',$student_id);       
        return $this->db->get('')->row_array();
    }
    /**
     * Summary of verifyAccess
     * @param mixed $student_id
     * @return mixed
     */
    public function verifyAccess($student_id){

        $this->db->select('active');
        $this->db->from('students'); 
        $this->db->where('id',$student_id);       
        return $this->db->get('')->row_array();
    }
    function get_student_address($id){

        $this->db->select('s.residential_address,s.`zip_code`,state.state_name,city.city_name,country.name as country_name');
        $this->db->from('`students` s');       
        $this->db->join('`state`', 'state.`state_id`= s.`state_id`','left');
        $this->db->join('`city`', 'city.city_id= s.`city_id`', 'left');
        $this->db->join('`country`', 'country.country_id= s.`country_id`', 'left');
        $this->db->where(array('s.id'=>$id));     
        return $this->db->get('')->row_array();
    } 

     function updateFourmoduleStatus($student_id,$params)
     {

        $this->db->where('student_package_id',$student_id);
        return $this->db->update('student_package',$params);
    }
    function verfiy_StudentOTP($email,$opt)
    {
        $this->db->select('id');
        $this->db->from('students');     
        $this->db->where(array('email'=>$email,'OTP'=>$opt));     
        return $this->db->get('')->row_array();
         //print_r($this->db->last_query());exit;

    }
    function verfiy_StudentOTP_by_mobile($country_code,$mobile,$opt)
    {
        $this->db->select('id');
        $this->db->from('students');     
        $this->db->where(array('country_code'=>$country_code,'mobile'=>$mobile,'OTP'=>$opt));     
        return $this->db->get('')->row_array();
        // print_r($this->db->last_query());exit;

    }
    function checkStudentExistenceBoth($mobile,$email){

        $this->db->select('id,fresh,active,is_otp_verified,is_email_verified');
        $this->db->from('`students`');
       // $this->db->where(array('mobile'=> $mobile,'email'=>$email));       
       $this->db->where(array('mobile'=>$mobile)); 
       $this->db->or_where(array('email'=>$email));    
        return $this->db->get('')->row_array();
    }

}
