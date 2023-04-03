<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

class User_model extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
    }

    function checkEmail($email=null){

        // $this->db->from('user'); 
        // $this->db->where(array('email'=>$email,'active'=>1,'portal_access'=>1));       
        // return $this->db->count_all_results();
        $this->db->select('email,personal_email');
        $this->db->from('user');
        $this->db->where(array('email'=>$email,'active'=>1,'portal_access'=>1));
        $this->db->or_where('personal_email',$email);
        return $this->db->get('')->row_array();

    }

    public function auto_init_erp_softly(){

        if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){
            //transaction
            $this->db->truncate('announcements');            
            $this->db->truncate('classroom_documents');
            $this->db->truncate('classroom_documents_class');
            $this->db->truncate('classroom_documents_content_type');
            $this->db->truncate('classroom_documents_section');
            $this->db->truncate('classroom_post');
            $this->db->truncate('classroom_documents_section'); 
            
            $this->db->truncate('mock_test_dates');
            $this->db->truncate('mock_test_report_ielts');        
            $this->db->truncate('mock_test_report_masters');
            $this->db->truncate('mock_test_report_pte');
            $this->db->truncate('mock_test_report_toefl'); 
            
            $this->db->truncate('refund_request');
            $this->db->truncate('waiver_request');
            $this->db->truncate('session_booking');            
            
            $this->db->truncate('student_journey');
            $this->db->truncate('student_package');
            $this->db->truncate('student_class_posts');
            $this->db->truncate('student_class_posts_reply');         
            $this->db->truncate('student_transaction_history');
            $this->db->truncate('students_enquiry');
            $this->db->truncate('students_enquiry_reply');
            $this->db->truncate('student_documents');
            $this->db->truncate('student_withdrawl');
            $this->db->truncate('student_attendance');
            $this->db->truncate('student_attendance_main');
            $this->db->truncate('students_counseling');
            //$this->db->delete('students',array('id'=>$id));
            $params=array('wallet'=>0,'waitingToken'=>0, 'profileUpdate'=>0,'loggedIn'=>0,'password'=>'fc5529b02a56939dca55d28baad15eba');
            $this->db->update('students',$params);
            $this->db->truncate('user_token');
        }
        
    }

    public function auto_init_erp_hardly(){

        if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){

            $this->db->truncate('`controller_list`');
            $this->db->truncate('`method_list`');
            $this->db->truncate('`role_access`');
            $this->db->truncate('`trainer_access_list`');
            $this->db->truncate('`user_activity`');
            $this->db->truncate('`user_batch`');
            $this->db->truncate('`user_branch`');
            $this->db->truncate('`user_country`');
            $this->db->truncate('`user_divisions`');         
            $this->db->truncate('`user_token`');
            
            $this->db->truncate('`agent_record`');
            $this->db->truncate('`announcements`');
            $this->db->truncate('`batch_master`');
            $this->db->truncate('`classroom`');
            $this->db->truncate('`classroom_documents`');
            $this->db->truncate('`classroom_documents_class`');
            $this->db->truncate('`classroom_documents_content_type`');
            $this->db->truncate('`classroom_documents_section`');
            $this->db->truncate('`classroom_post`');            
            $this->db->truncate('`content_type_masters`');            
            $this->db->truncate('`counseling_sessions`');
            $this->db->truncate('`counseling_sessions_general_info`');
            $this->db->truncate('`counseling_sessions_group`');
            $this->db->truncate('`counseling_session_centers`');
            $this->db->truncate('`counseling_session_course`');
            $this->db->truncate('`course_timing`');            
            $this->db->truncate('`designation_masters`');            
            $this->db->truncate('`division_masters`');
            $this->db->truncate('`document_type_masters`');
            $this->db->truncate('`enquiry_purpose_division`');
            $this->db->truncate('`enquiry_purpose_masters`');            
            $this->db->truncate('`faq_master`');            
            $this->db->truncate('`followup_master`');
            $this->db->truncate('`free_resources`');
            $this->db->truncate('`free_resources_section`');
            $this->db->truncate('`free_resources_test`');
            $this->db->truncate('`free_resources_topic`');
            $this->db->truncate('`free_resources_topic_data`');
            $this->db->truncate('`galleries`');
            $this->db->truncate('`leads`');
            $this->db->truncate('`lead_followup`');
            $this->db->truncate('`live_lectures`');
            $this->db->truncate('`mock_test_dates`');
            $this->db->truncate('`mock_test_report_ielts`');
            $this->db->truncate('`mock_test_report_masters`');
            $this->db->truncate('`mock_test_report_pte`');
            $this->db->truncate('`news`');
            $this->db->truncate('`news_tags`');            
            $this->db->truncate('`online_class_schedules`');
            $this->db->truncate('`other_contents`'); 
            $this->db->truncate('`package_batch`');
            $this->db->truncate('`package_category`');
            $this->db->truncate('`package_masters`');
            $this->db->truncate('`package_timing`');
            $this->db->truncate('`photo`');
            $this->db->truncate('`practice_package_category`');
            $this->db->truncate('`practice_package_masters`');            
            $this->db->truncate('`provinces`');
            $this->db->truncate('`provinces_images`');
            $this->db->truncate('`qualification_masters`');            
            $this->db->truncate('`refund_request`'); 
            $this->db->truncate('`session_booking`');
            $this->db->truncate('`source_masters`');
            $this->db->truncate('`source_masters_om`');
            $this->db->truncate('`students`');
            //$this->db->delete('students',array('id'=>$id));
            //$params=array('wallet'=>0,'waitingToken'=>0, 'profileUpdate'=>0,'loggedIn'=>0,'password'=>'fc5529b02a56939dca55d28baad15eba');
            //$this->db->update('students',$params);
            $this->db->truncate('`students_counseling`');
            $this->db->truncate('`students_enquiry`');
            $this->db->truncate('`students_enquiry_reply`');
            $this->db->truncate('`student_attendance`');
            $this->db->truncate('`student_attendance_main`');
            $this->db->truncate('`student_class_posts`');
            $this->db->truncate('`student_class_posts_reply`');
            $this->db->truncate('`student_documents`');
            $this->db->truncate('`student_journey`');
            $this->db->truncate('`student_package`');
            $this->db->truncate('`student_promocodes`');
            $this->db->truncate('`student_transaction_history`');
            $this->db->truncate('`student_withdrawl`');
            $this->db->truncate('students_counseling');            
            $this->db->truncate('`checkout_page_history`');           
            $this->db->truncate('`url_slug`');
            $this->db->truncate('`videos`');
            $this->db->truncate('`waiver_request`');      
            $this->db->truncate('`wosa_keys`');            
        }
        
    }

    public function verifyToken($employeeCode){      
        
        $this->db->select('token,status');
        $this->db->from('user_token'); 
        $this->db->where('username',$employeeCode);       
        return $this->db->get('')->row_array();
    }

    public function verifyAccess($employeeCode){

        $this->db->select('portal_access');
        $this->db->from('user'); 
        $this->db->where('employeeCode',$employeeCode);       
        return $this->db->get('')->row_array();
    }

    public function updateUserToken($employeeCode,$params_token){

        $this->db->where('username',$employeeCode);
        return $this->db->update('user_token',$params_token);
    }

    public function addUserToken($params_token){ 

        $this->db->insert('user_token',$params_token);
        return $this->db->insert_id();        
    }

    public function checkTokenCount($employeeCode){
        $this->db->from('user_token');
        $this->db->where(array('username'=> $employeeCode));
        return $this->db->count_all_results();  
    }

    public function clean_employee_tran(){

        if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){
            //$this->db->delete('user_activity',array('activity_id>'=>0));
            $this->db->delete('user_branch',array('user_branch_id>'=>0)); 
            $this->db->delete('trainer_access_list',array('user_test_module_id>'=>0));    
            $this->db->delete('user_batch',array('user_batch_id>'=>0));
            $this->db->delete('user_country',array('user_country_id>'=>0));
            $this->db->delete('user_reporting_manager',array('user_id>'=>0));        
            $this->db->delete('user_divisions',array('user_id>'=>0));
            $this->db->delete('user_role',array('user_id>'=>1));
            $this->db->delete('user_token',array('id>'=>1));
            return 1;
        }else{
            return 0;
        }
    }

    public function getUserActivityToday_count($UserId,$todaystr,$today2){

        $this->db->from('user_activity');
        $this->db->where(array('by_user'=>$UserId,'dateStr<='=>$todaystr,'dateStr>='=>$today2));
        return $this->db->count_all_results();
    }


    public function update_user_active_one($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `active`=".$active." WHERE ".$pk." = ".$id." ");
    }

    public function update_user_active_null($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `active`= 0,`portal_access`=0 WHERE ".$pk." = ".$id." ");
    }

    public function remove_trainer_access_($user_test_module_id,$user_id){

        return $this->db->delete('trainer_access_list',array('user_test_module_id'=>$user_test_module_id,'user_id'=>$user_id));
    }

    public function deactivateEmployeeOnExitDate($todaystr){

        $params = array('active'=> 0);
        $this->db->where(array('DOE_str<='=>$todaystr,'DOE_str!='=>''));
        return $this->db->update('user',$params);
        //echo $this->db->last_query();die;
    }

    public function check_user_division_count($user_id){

        $this->db->from('user_divisions');
        $this->db->where(array('user_id'=> $user_id,'division_id!='=>''));
        return $this->db->count_all_results();
    }

    public function check_user_functional_branch_count($user_id){

        $this->db->from('user_branch');
        $this->db->where(array('user_id'=> $user_id,'center_id!='=>''));
        return $this->db->count_all_results();
    }

    public function getUserSpecialAccess($user_id){

        $this->db->select('waiver_power,waiver_upto,refund_power,portal_access');
        $this->db->from('user'); 
        $this->db->where(array('id'=>$user_id));      
        return $this->db->get('')->row_array();
    }    

    public function searchUserActivity($params=array(),$totalRowscount = false){
        if(isset($params['limit']) && isset($params['offset']) && $totalRowscount == false){
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('ua.activity_id,ua.student_package_id,ua.latitude,ua.longitude,ua.activity_name,ua.description,ua.country,ua.state,ua.city,ua.IP_address,ua.isProxy,ua.isSuspicious,ua.created,CONCAT(u.fname, " ", u.lname) full_name,ua.by_user,cl.center_name');
        $this->db->from('user_activity ua'); 
        $this->db->join('user u','u.id = ua.by_user');
        $this->db->join('center_location cl','cl.center_id = u.center_id_home');

        if(isset($params['center_id']) && !empty($params["center_id"])) {
            $this->db->where_in('u.center_id_home',$params["center_id"]);
        }

        if(isset($params['employee_id']) && !empty($params["employee_id"])) {
            $this->db->where_in('ua.by_user',$params["employee_id"]);
        }

        if(isset($params['active']) && !empty($params["active"])) {
            $this->db->where_in('u.active',$params["active"]); 
        }

        if(isset($params['from_date']) && !empty($params["from_date"])) {
            $this->db->where('STR_TO_DATE(ua.created,"%Y-%m-%d %H:%i") >= ',$params["from_date"]);
        }

        if(isset($params['to_date']) && !empty($params["to_date"])) {
            $this->db->where('STR_TO_DATE(ua.created,"%Y-%m-%d %H:%i") <= ',$params["to_date"]);
        }

        $this->db->order_by('ua.created DESC');
        
        if($totalRowscount == true) {
            return $this->db->count_all_results();
        }
        else {
            return $this->db->get('')->result_array();
        }
    }

    public function doLogin($employeeCode,$password,$checkadmin=false){
                           
        $query = $this->db->query("select user.id,user.employeeCode,user.fname,user.lname,user.email,user.country_code_offc,user.mobile,user.waiver_upto,user.residential_address,user.created,roles.name as role_name,roles.id as role_id,center_location.center_name as homeBranch,center_location.center_id as homeBranchId,refund_power,waiver_power,waiver_upto from user "
             ." LEFT JOIN user_role ON user_role.user_id=user.id"
             ." LEFT JOIN roles ON roles.id=user_role.role_id" 
             ." LEFT JOIN center_location ON center_location.center_id=user.center_id_home"
             ." WHERE user.password='".md5($password)."' and user.portal_access='1' and user.employeeCode='".$employeeCode."' and user.active='1' ");
        //echo $this->db->last_query();die;
        return $query->result();
    }

    public function check_personal_mobile_availibility($personal_contact){
        $this->db->from('user');
        $this->db->where(array('personal_contact'=> $personal_contact));
        return $this->db->count_all_results();
    }

    public function check_personal_mobile_availibility_edit($personal_contact,$personal_contact_old){
        if($personal_contact==$personal_contact_old){
            return 0;
        }else{
            $this->db->from('user');
            $this->db->where(array('personal_contact'=> $personal_contact));
            return $this->db->count_all_results();
        }        
    }

    public function check_personal_email_availibility($email){ 

        $this->db->from('user');
        $this->db->where(array('personal_email'=> $email));
        return $this->db->count_all_results();
    }

    public function check_employeeCode_availibility($employeeCode){
        $this->db->from('user');
        $this->db->where(array('employeeCode'=> $employeeCode));
        return $this->db->count_all_results();
    }

    public function check_employeeCode_availibility_edit($employeeCode,$employeeCode_old){

        $this->db->from('user');
        if($employeeCode==$employeeCode_old){
            return 0;
        }else{        
            $this->db->where(array('employeeCode'=> $employeeCode));
            return $this->db->count_all_results();
        }        
    }
    
    public function check_official_email_availibility($email,$OfficialEmail_old){ 

        if($email==$OfficialEmail_old){
            return 0;
        }else{
            $this->db->from('user');
            $this->db->where(array('email'=> $email));
            return $this->db->count_all_results();
        }        
    }

    public function getUserFunctionalBranch($userId){
        
        $roleName = $_SESSION['roleName'];
        if($roleName==ADMIN){
            $this->db->select('c.center_id');
            $this->db->from('center_location c'); 
            $this->db->join('center_divisions cd', 'cd.center_id = c.center_id','left');
            $this->db->where(array('c.active'=>1,'cd.division_id'=>1));
        }else{
            $this->db->distinct('');
            $this->db->select('center_id');
            $this->db->from('user_branch'); 
            $this->db->where('user_id',$userId);
        }               
        return $this->db->get('')->result_array();
    }

    public function getUserHomeBranch($userId){

        $this->db->select('center_id_home');
        $this->db->from('user'); 
        $this->db->where('id',$userId);       
        return $this->db->get('')->row_array();
    }

    public function getOfficialEmail($user_id){

        $this->db->select('email');
        $this->db->from('user'); 
        $this->db->where('id',$user_id);       
        return $this->db->get('')->row_array();
    }

    public function getUserAccessAsTrainer($UserId){
        
        $this->db->select('tal.test_module_id,tal.programe_id,tal.category_id,ub.batch_id,br.center_id');
        $this->db->join('user_branch br', 'br.user_id = tal.user_id','left');
        $this->db->join('user_batch ub', 'ub.user_id = tal.user_id','left');
        $this->db->from('trainer_access_list tal');
        $this->db->where('tal.user_id',$UserId);
        $this->db->order_by('tal.user_test_module_id','ASC');       
        return $this->db->get('')->result_array();
    }

    public function getUserFunctionalBatch($userId){

        $this->db->distinct('');
        $this->db->select('batch_id');
        $this->db->from('user_batch'); 
        $this->db->where('user_id',$userId);       
        return $this->db->get('')->result_array();
    }

    public function getUserFunctionalCountry($userId){

        $this->db->distinct('');
        $this->db->select('country_id');
        $this->db->from('user_country'); 
        $this->db->where('user_id',$userId);       
        return $this->db->get('')->result_array();
    }           
    
    function get_user($id)
    {
        return $this->db->get_where('user',array('id'=>$id))->row_array();
    }

    function get_user_data($id)
    {
        $this->db->select('id,employeeCode, image, fname, lname, gender, center_id_home, dob, MA, DOJ, DOE, email, emp_designation, country_code_pers, personal_email, mobile, country_code_offc, personal_contact, country_id, state_id, city_id, residential_address, active, by_user');
        $this->db->from('user'); 
        $this->db->where('id',$id);       
        return $this->db->get('')->row_array();
    }

    

    function update_user_pwd($email,$params)
    {                    
        //$password = $params['password'];
        return $this->db->query("update `user` SET 
            `password` = '".$params['password']."'
            where email = '".$email."' 
        ");
    }

    function get_all_user_count()
    {
        $this->db->from('user u');
        $this->db->join('user_role ur', 'ur.user_id = u.id','left');
        //$this->db->where(array('ur.role_id!='=>EMPLOYEE_ROLE_ID));
        return $this->db->count_all_results();
    }

    function get_all_employee_count($roleName,$userBranch){
        
        $this->db->from('user u');        
        if($roleName==ADMIN){
        }else{
            if($userBranch){
                $this->db->join('user_branch ub', 'ub.user_id = u.id','left');
                $this->db->where_in('ub.center_id', $userBranch);
            }else{
                $userBranch=0;
                $this->db->join('user_branch ub', 'ub.user_id = u.id','left');
                $this->db->where_in('ub.center_id', $userBranch);
            }                        
        }      
        return $this->db->count_all_results();
    }        
    
    function get_all_user($params = array()){
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('u.id,u.employeeCode,u.image,u.fname,u.lname,u.personal_email,u.personal_contact,u.waiver_upto,u.active,
            ur.role_id, r.name,g.gender_name,cl.center_name');
        $this->db->from('user u');
        $this->db->join('user_role ur', 'ur.user_id = u.id','left');
        $this->db->join('roles r', 'r.id = ur.role_id','left');
        $this->db->join('gender g', 'g.id = u.gender','left');
        $this->db->join('center_location cl', 'cl.center_id = u.center_id_home','left');
        $this->db->order_by('u.fname ASC');
        return $this->db->get('')->result_array();
    }

    function getEmployeeCode($id){

        $this->db->select('employeeCode');
        $this->db->from('user');
        $this->db->where(array('id'=>$id));
        return $this->db->get('')->row_array();
    }

    function getPersonalMobile($id){

        $this->db->select('personal_contact');
        $this->db->from('user');
        $this->db->where(array('id'=>$id));
        return $this->db->get('')->row_array();
    }

    function getUserInfo($id){

        $this->db->select('employeeCode,fname,lname,email,personal_email');
        $this->db->from('user');
        $this->db->where(array('id'=>$id));
        return $this->db->get('')->row_array();
    }

    function get_all_user_forReference(){        
        
        $this->db->select('id,employeeCode,fname,lname');
        $this->db->from('user');
        $this->db->order_by('fname ASC');
        return $this->db->get('')->result_array();
    }

    function get_all_employee($roleName,$userBranch,$params = array()){
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            u.id,
            u.employeeCode,
            u.image,
            u.fname,
            u.lname,
            dm.designation_name,
            ur.role_id,
            r.name,
            cl.center_name,
            u.country_code_offc,
            u.mobile,
            u.email,
            u.dob,
            u.DOJ,
            u.DOE,
            u.active, 
            u.portal_access, 
            u.waiver_power,u.waiver_upto,u.refund_power          
        ');
        $this->db->from('user u');
        $this->db->join('user_role ur', 'ur.user_id = u.id','left');
        $this->db->join('user_branch ub', 'ub.user_id = u.id','left');
        $this->db->join('roles r', 'r.id = ur.role_id','left');
        $this->db->join('designation_masters dm', 'dm.id = u.emp_designation','left');
        $this->db->join('center_location cl', 'cl.center_id = u.center_id_home','left');
        if($roleName==ADMIN){
        }else{
            if(!empty($userBranch)){
                $this->db->where_in('ub.center_id', $userBranch);
            }else{
                $userBranch=0;
                $this->db->where_in('ub.center_id', $userBranch);
            }           
        }
        $this->db->order_by('u.modified DESC');
        $this->db->group_by('u.id');
        return $this->db->get('')->result_array();
    }

    function get_user_view($id){
        
        $this->db->select('`u`.`id` AS `id`, `u`.`employeeCode` AS `employeeCode`, `u`.`image` AS `image`, `u`.`fname` AS `fname`, `u`.`lname` AS `lname`, `dm`.`designation_name` AS `designation_name`, `ur`.`role_id` AS `role_id`, `r`.`name` AS `name`, `cl`.`center_name` AS `center_name`, `u`.`country_code_offc` AS `country_code_offc`, `u`.`mobile` AS `mobile`, `u`.`email` AS `email`, `u`.`dob` AS `dob`, `u`.`DOJ` AS `DOJ`, `u`.`active` AS `active`, `u`.`portal_access` AS `portal_access`, `u`.`waiver_power` AS `waiver_power`, `u`.`waiver_upto` AS `waiver_upto`, `u`.`refund_power` AS `refund_power` ');
        $this->db->from('user u');
        $this->db->join('center_location cl', '`cl`.`center_id` = `u`.`center_id_home`','left');
        $this->db->join('user_role ur', '`ur`.`user_id` = `u`.`id`','left');
        $this->db->join('roles r', '`r`.`id` = `ur`.`role_id`','left');
        $this->db->join('designation_masters dm', '`dm`.`id` = `u`.`emp_designation`','left');
        $this->db->where(array('u.id'=>$id));
        return $this->db->get('')->result_array();
    }     

    function get_all_trainer_active($roleName,$userBranch){

        $this->db->distinct('');
        $this->db->select('u.id as trainer_id,u.fname,u.lname, 
            ur.role_id');
        $this->db->from('user u');
        $this->db->join('user_role ur', 'ur.user_id = u.id','left');
        $this->db->join('roles r', 'r.id = ur.role_id','left');
        $this->db->join('user_branch ub', 'ub.user_id = u.id','left');
        $this->db->where(array('u.active'=>1));
        $this->db->like('r.name', TRAINER);
        if($roleName==ADMIN){ 
        }else{
            if($userBranch){
                $this->db->where_in('ub.center_id', $userBranch);
            }else{
                $userBranch=0;
                $this->db->where_in('ub.center_id', $userBranch);
            }            
        }        
        return $this->db->get('')->result_array();
        //echo $this->db->last_query();die;
    }

    function get_all_user_waiver(){

        $this->db->select('u.id,u.employeeCode,u.fname,u.lname,u.mobile,u.waiver_upto');
        $this->db->from('user u');
        $this->db->join('user_role ur', 'ur.user_id = u.id');
        $this->db->join('roles r', 'r.id = ur.role_id');
        $this->db->where(array('u.active'=>1,'u.waiver_power'=>1));
        $this->db->order_by('u.id', 'DESC'); 
        return $this->db->get()->result_array();
    }    

    function get_all_user_refund(){

        $this->db->select('u.id,u.employeeCode,u.fname,u.lname,u.mobile');
        $this->db->from('user u');
        $this->db->join('user_role ur', 'ur.user_id = u.id');
        $this->db->join('roles r', 'r.id = ur.role_id');
        $this->db->where(array('u.active'=>1,'u.refund_power'=>1));
        $this->db->order_by('u.id', 'DESC'); 
        return $this->db->get()->result_array();
    }

    function get_user_roleName($id){

        $this->db->select('r.name');
        $this->db->from('user_role ur');
        $this->db->join('roles r', 'r.id = ur.role_id');
        $this->db->where(array('ur.user_id'=>$id));
        return $this->db->get('')->row_array();
    }   

    function get_user_role($id){

        $this->db->select('role_id');
        $this->db->from('user_role');
        $this->db->where(array('user_id'=>$id));
        return $this->db->get('')->row_array();
    }   

    function get_mobileEmail($id){

        $this->db->select('email,mobile');
        $this->db->from('user');
        $this->db->where(array('id'=>$id));
        return $this->db->get('')->row_array();
    }    

    function get_user_country($id){
        
        $this->db->select('uc.country_id,cnt.name');
        $this->db->from('user_country uc');
        $this->db->join('country cnt', 'cnt.country_id = uc.country_id','left');
        $this->db->where(array('uc.user_id'=>$id));
        return $this->db->get('')->result_array();
    }

    function get_user_branch($id){
        
        $this->db->select('ub.center_id,cl.center_name');
        $this->db->from('user_branch ub');
        $this->db->join('center_location cl', 'cl.center_id = ub.center_id','left');
        $this->db->where(array('ub.user_id'=>$id));
        return $this->db->get('')->result_array();
    }    

    function get_user_test_module($id){
        
        $this->db->select('ut.test_module_id,tm.test_module_name');
        $this->db->from('user_test_module ut');
        $this->db->join('test_module tm', 'tm.test_module_id = ut.test_module_id', 'left');
        $this->db->where(array('ut.user_id'=>$id));
        return $this->db->get('')->result_array();
    }

    function get_user_batch($id){
        
        $this->db->select('ub.user_batch_id,ub.batch_id,b.batch_name,ub.user_id');
        $this->db->from('user_batch ub');
        $this->db->join('`batch_master` b', 'b.`batch_id`= ub.`batch_id`', 'left');
        $this->db->where(array('ub.user_id'=>$id));
        return $this->db->get('')->result_array();
    }

    function get_trainer_access_list($id){

        $this->db->select('tal.user_test_module_id,tm.test_module_name,pgm.programe_name,tal.category_id,tal.user_id');
        $this->db->from('trainer_access_list tal');
        $this->db->join('test_module tm', 'tm.test_module_id = tal.test_module_id');
        $this->db->join('`programe_masters` pgm', 'pgm.`programe_id`= tal.`programe_id`');
        //$this->db->join('`category_masters` cat', 'cat.`category_id`= tal.`category_id`');
        $this->db->where(array('tal.user_id'=>$id));
        return $this->db->get('')->result_array();
    }

    function check_duplicate_trainer_access($test_module_id,$programe_id,$category_ids,$user_id){

        $this->db->where(array('test_module_id'=> $test_module_id,'programe_id'=> $programe_id,'category_id'=>$category_ids, 'user_id'=> $user_id));
        $query = $this->db->get('trainer_access_list');
        $count = $query->num_rows();
        if($count > 0) {          
            return 2;
        }else{          
            return 1;
        }
    }    

    function add_trainer_profile($params){
       
        $this->db->where(array('test_module_id'=> $params['test_module_id'],'programe_id'=> $params['programe_id'],'category_id'=> $params['category_id'],'user_id'=> $params['user_id']));
        $query = $this->db->get('trainer_access_list');
        $count = $query->num_rows();
        if($count > 0) {          
            return 'duplicate';
        }else{          
            $this->db->insert('trainer_access_list',$params);
            return $this->db->insert_id();
        }
    }
    
    function add_user($params)
    {
        $this->db->insert('user',$params);
        return $this->db->insert_id();
    }

    function add_user_country($params){

        $this->db->from('user_country');
        $this->db->where(array('user_id'=>$params['user_id'],'country_id'=>$params['country_id']));
        $c = $this->db->count_all_results();
        if($c==0){
           $this->db->insert('user_country',$params);
           return $this->db->insert_id(); 
        }else{
            return 0;
        }        
    } 

    function add_user_branch($params){

        $this->db->from('user_branch');
        $this->db->where(array('user_id'=>$params['user_id'],'center_id'=>$params['center_id']));
        $c = $this->db->count_all_results();
        if($c==0){
           $this->db->insert('user_branch',$params);
           return $this->db->insert_id(); 
        }else{
            return 0;
        }        
    }    

    function add_user_batch($params){

        $this->db->from('user_batch');
        $this->db->where(array('user_id'=>$params['user_id'],'batch_id'=>$params['batch_id']));
        $c = $this->db->count_all_results();
        if($c==0){
           $this->db->insert('user_batch',$params);
           return $this->db->insert_id(); 
        }else{
            return 0;
        }        
    }

    function update_user($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('user',$params);
    }

    function change_password($id,$params)
    {
        $this->db->where(array('id'=>$id));
        return $this->db->update('user',$params);
    }

    function check_old_pwd($id,$pwd){

        $this->db->select('password');
        $this->db->from('user');        
        $this->db->where(array('id'=>$id,'password'=>$pwd));
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }    
    
    function delete_user($id){
            
        //$this->db->delete('user_role',array('user_id'=>$id));
        //$this->db->delete('user_branch',array('user_id'=>$id));
        //$this->db->delete('user_country',array('user_id'=>$id));
        //$this->db->delete('user_test_module',array('user_id'=>$id));
        //$this->db->delete('user_programe',array('user_id'=>$id));
        //$this->db->delete('user_batch',array('user_id'=>$id));
        //$this->db->delete('user_category',array('user_id'=>$id));        
        //$this->db->delete('center_heads',array('user_id'=>$id));        
        //$this->db->delete('center_academy_managements',array('user_id'=>$id));
        //$this->db->delete('center_visa_managements',array('user_id'=>$id));
        //$this->db->delete('department_executive_management_tier',array('user_id'=>$id));
        //$this->db->delete('department_management_tier',array('user_id'=>$id));
        //$this->db->delete('user_divisions',array('user_id'=>$id));
        //$this->db->delete('user_activity',array('by_user'=>$id));
        //$this->db->delete('user',array('id'=>$id));
    }

    function delete_User_Country($country_id,$user_id){ 

        return $this->db->delete('user_country',array('user_id'=>$user_id,'country_id'=>$country_id));
    }

    function delete_User_Branch($center_id,$user_id){  

        return $this->db->delete('user_branch',array('user_id'=>$user_id,'center_id'=>$center_id));
    }

    function delete_User_Batch($user_batch_id,$user_id){  

        return $this->db->delete('user_batch',array('user_batch_id'=>$user_batch_id, 'user_id'=>$user_id));
        //print_r($this->db->last_query());exit;
    }

    function remove_trainer_access($user_id){  

         $this->db->delete('user_batch',array('user_id'=>$user_id));
         $this->db->delete('trainer_access_list',array('user_id'=>$user_id));
        //print_r($this->db->last_query());exit;
    }

    /*Add New Function Start*/
    /*get user in division*/
    function get_user_division($id){
        
        $this->db->select('ub.division_id,dm.division_name');
        $this->db->from('user_divisions ub');
        $this->db->join('division_masters dm', 'dm.id  = ub.division_id','left');
        $this->db->where(array('ub.user_id'=>$id));
        return $this->db->get('')->result_array();
        
    }
    /*add user in division*/
    function add_user_division($params){

        $this->db->from('user_divisions');
        $this->db->where(array('user_id'=>$params['user_id'],'division_id'=>$params['division_id']));
        $c = $this->db->count_all_results();
        if($c==0){
           $this->db->insert('user_divisions',$params);
           return $this->db->insert_id(); 
        }else{
            return 0;
        }        
    }

    function delete_User_Division($division_id,$user_id){
        
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_divisions');
        $totalDivision=$query->num_rows();

        if($this->db->delete('user_divisions',array('user_id'=>$user_id,'division_id'=>$division_id))){

            #delete  user division Branch  
            $this->db->select('center_id');
            $this->db->from('user_branch');
            $this->db->where('user_id',$user_id);
            $center_ids=$this->db->get('')->result_array();
            $center_ids_data=array(); 
            foreach($center_ids as $key=>$val){

                $this->db->select('division_id');
                $this->db->from('center_divisions');
                $this->db->where('center_id',$val['center_id']);
                $division_ids=$this->db->get('')->result_array();
                $division_ids=array_column($division_ids, 'division_id');
                if(count($division_ids) ==1 && in_array($division_id,$division_ids) &&  $totalDivision > 1){

                    $this->db->delete('user_branch',array('user_id'=>$user_id,'center_id'=>$val['center_id']));
                }else if(in_array($division_id,$division_ids) &&  $totalDivision ==1){

                    $this->db->delete('user_branch',array('user_id'=>$user_id,'center_id'=>$val['center_id']));
                }
            }
            return 1;
        }else{
            return 0;
        }
    }
    
    /*get user List By user Functional Branch ID */
    function getUserListByFunctionalBranchId($center_id){
		
        $this->db->select('u.id,u.employeeCode,u.fname,u.lname');
        $this->db->from('user_branch ub');
        $this->db->join('user u', 'u.id = ub.user_id');
        $this->db->join('user_role ur', 'ur.user_id = u.id');
        $this->db->where(array('ub.center_id'=>$center_id,'u.active'=>1));
        return $this->db->get('')->result_array();
		
    }
    /*get user List By user Functional Branch ID And division Id */
    function getUserListByFunctionalBranchIdAndDivisionId($center_id,$division_id=array()){
        
        $this->db->select('u.id,u.employeeCode,u.fname,u.lname');
        $this->db->from('user_branch ub');
        $this->db->join('user u', 'u.id = ub.user_id');
        $this->db->join('user_role ur', 'ur.user_id = u.id');
        $this->db->join('user_divisions ud', 'ud.user_id = u.id','left');
		$this->db->where('u.active',1);
        $this->db->where(array('ub.center_id'=>$center_id));
		$this->db->where_in('ud.division_id',$division_id);
        $data=$this->db->get('')->result_array();
        $results=array();
        foreach($data as $key=>$val){
            $results[$val['id']]=$val;
        }
        return $results;
    }
    /*get user List By user list*/
    function getUserListByDivisionId($division_id=array()){
		
        $this->db->select('u.id,u.employeeCode,u.fname,u.lname');
        $this->db->from('user u');
        $this->db->join('user_role ur', 'ur.user_id = u.id','left');
		$this->db->join('user_divisions ud', 'ud.user_id = u.id','left');
        $this->db->where('u.active',1);
		$this->db->where_in('ud.division_id',$division_id);
        $results=$this->db->get('')->result_array();
        $users=array();
        foreach($results as $key=>$data){
            $users[$data['id']]=$data;
        }
        return $users;
    }
	 /*get user List By user list*/
    function getUserList(){
        $this->db->select('u.id,u.employeeCode,u.fname,u.lname');
        $this->db->from('user u');
        $this->db->join('user_role ur', 'ur.user_id = u.id','left');
        $results=$this->db->get('')->result_array();
        $users=array();
        foreach($results as $key=>$data){
            
            $users[$data['id']]=$data;
        }
        return $users;
    }
    /*get user department  fetchdata from three table*/
    function get_user_centralised_department($id){
        
        $this->db->select('ub.user_id,ub.department_id,dm.department_name');
        $this->db->from('department_executive_management_tier ub');
        $this->db->join('department_masters dm', 'dm.id  = ub.department_id','left');
        $this->db->where(array('ub.user_id'=>$id));
        $department_executive_management_tier=$this->db->get('')->result_array();
        $department=array();
        foreach($department_executive_management_tier as $key=>$department_data){
            
            $department_id=$department_data['department_id'];
            $department_name=$department_data['department_name'];
            $department[$department_id]=$department_name;
        }
        $this->db->select('ub.user_id,ub.department_id,dm.department_name');
        $this->db->from('department_management_tier ub');
        $this->db->join('department_masters dm', 'dm.id  = ub.department_id','left');
        $this->db->where(array('ub.user_id'=>$id));
        $department_management_tier=$this->db->get('')->result_array();
        foreach($department_management_tier as $key=>$department_data){
            
            $department_id=$department_data['department_id'];
            $department_name=$department_data['department_name'];
            $department[$department_id]=$department_name;
        }
        
        $this->db->select('ub.user_id,ub.department_id,dm.department_name');
        $this->db->from('department_employee_tier ub');
        $this->db->join('department_masters dm', 'dm.id  = ub.department_id','left');
        
        $this->db->where('find_in_set("'.$id.'", ub.user_id) <> 0');
        $department_employee_tier=$this->db->get('')->result_array();
        foreach($department_employee_tier as $key=>$department_data){
            
            $department_id=$department_data['department_id'];
            $department_name=$department_data['department_name'];
            $department[$department_id]=$department_name;
        }
        //pr($department);
        return $department;
    }
    /* get user department  fetchdata from three table*/
    function get_user_decentralised_department($id){
        
        $this->db->select('ub.user_id,ub.department_id,dm.department_name');
        $this->db->from('center_department_executive_management_tier ub');
        $this->db->join('department_masters dm', 'dm.id  = ub.department_id','left');
        
        $this->db->where(array('ub.user_id'=>$id));
        $department_executive_management_tier=$this->db->get('')->result_array();
        $department=array();
        foreach($department_executive_management_tier as $key=>$department_data){
            
            $department_id=$department_data['department_id'];
            $department_name=$department_data['department_name'];
            $department[$department_id]=$department_name;
        }
        $this->db->select('ub.user_id,ub.department_id,dm.department_name');
        $this->db->from('center_department_management_tier ub');
        $this->db->join('department_masters dm', 'dm.id  = ub.department_id','left');
        $this->db->where(array('ub.user_id'=>$id));
        $department_management_tier=$this->db->get('')->result_array();
        foreach($department_management_tier as $key=>$department_data){
            
            $department_id=$department_data['department_id'];
            $department_name=$department_data['department_name'];
            $department[$department_id]=$department_name;
        }
        
        $this->db->select('ub.user_id,ub.department_id,dm.department_name');
        $this->db->from('center_department_employee_tier ub');
        $this->db->join('department_masters dm', 'dm.id  = ub.department_id','left');
        
        $this->db->where('find_in_set("'.$id.'", ub.user_id) <> 0');
        $department_employee_tier=$this->db->get('')->result_array();
        foreach($department_employee_tier as $key=>$department_data){
            
            $department_id=$department_data['department_id'];
            $department_name=$department_data['department_name'];
            $department[$department_id]=$department_name;
        }
        //pr($department);
        return $department;
        
    }
    /*Add New Function End*/

    /**
     * 
     * @param int $branch_id
     * @param int $division_id
     * @return type
     */
    public function getUsersByBranchId(int $branch_id, int $division_id) {
        return $this->db->select('u.id, u.employeeCode, CONCAT(u.fname, " ", u.lname) full_name')
                        ->from('user as u')
                        ->join('user_branch ub', 'ub.user_id = u.id')
                        ->join('user_divisions ud', 'ud.user_id = u.id')
                        ->where(['ub.center_id' => $branch_id, 'ud.division_id' => $division_id, 'u.active' => 1])
                        ->group_by('u.id')
                        ->get()->result_array();
    }

    public function getAllUsersList($params = array()) {
        $this->db->select('u.id, u.employeeCode, CONCAT(u.fname, " ", u.lname) full_name');
        $this->db->from('user u');
        $this->db->join('user_branch ub', 'ub.user_id = u.id');
        
        if(isset($params["branch_id"]) && !empty($params["branch_id"])) {
            $this->db->where_in("ub.center_id",$params["branch_id"]);
        }
        if(isset($params["division_id"]) && !empty($params["division_id"])) {
            $this->db->join('user_divisions ud', 'ud.user_id = u.id');
            $this->db->where("ud.division_id = $params[division_id]");
        }
        if(isset($params["active"]) && !empty($params["active"])) {
            $this->db->where_in("u.active",$params["active"]);
        }

        if(isset($params["employee_id"]) && !empty($params["employee_id"])) {
            $this->db->where_in("u.id",$params["employee_id"]);
        }

        $this->db->group_by('u.id');
        return $this->db->get()->result_array();
    }

    /**
     * getUsersByDivisionId will be used to get list of employees in selected division
     * 
     * @param int $division_id
     * @return type
     */
    public function getUsersByDivisionId(int $division_id) {
        return $this->db->select('u.id, u.employeeCode, u.fname, u.lname')
                        ->from('user as u')
                        ->join('user_divisions as ud', 'ud.user_id=u.id')
                        ->where('ud.division_id', $division_id)
                        ->get()->result_array();
    }
    
    public function getUsersByCenterDepatment($center_id,$department_id) {
		
        $data=$this->db->select('u.id, u.employeeCode, u.fname, u.lname')
                        ->from('user as u')
                        ->join('center_department_employee_tier cde', 'cde.user_id = u.id','LEFT')
                        ->join('center_department_executive_management_tier cdem', 'cdem.user_id = u.id', 'LEFT')
                        ->join('center_department_management_tier cdm', 'cdm.user_id = u.id', 'LEFT')
						->group_start()
						->group_start()
						->where('cde.department_id',$department_id)
						->where('cde.center_id',$center_id)
						->group_end()
						->or_group_start()
						->where('cdem.department_id',$department_id)
						->where('cdem.center_id',$center_id)
						->group_end()
						->or_group_start()
						->where('cdm.department_id',$department_id)
						->where('cdm.center_id',$center_id)
						->group_end()
						->group_end()
						->where('u.active',1)
						->group_by('u.id')
                        ->get()->result_array();
			#echo $this->db->last_query();			
			return $data;			
    }
	public function getUsersByDepatment($department_id) {
		
        $data=$this->db->select('u.id, u.employeeCode, u.fname, u.lname')
                        ->from('user as u')
                        ->join('department_employee_tier cde', 'cde.user_id = u.id','LEFT')
                        ->join('department_executive_management_tier cdem', 'cdem.user_id = u.id', 'LEFT')
                        ->join('department_management_tier cdm', 'cdm.user_id = u.id', 'LEFT')->
						where('u.active',1)->group_start()->or_where('cde.department_id',$department_id)->or_where('cdem.department_id',$department_id)->or_where('cdm.department_id',$department_id)->group_end()->group_by('u.id')
                        ->get()->result_array();
		#echo $this->db->last_query();
        return $data;
    }
    public function getUserActivityToday2($UserId,$todaystr,$today2,$params=array()){
        if(isset($params['limit']) && isset($params['offset'])){
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('ua.activity_id,ua.student_package_id,ua.latitude,ua.longitude,ua.activity_name,ua.description,ua.country,ua.state,ua.city,ua.IP_address,ua.isProxy,ua.isSuspicious,ua.created,CONCAT(u.fname, " ", u.lname) full_name,ua.by_user,cl.center_name');
        $this->db->from('user_activity ua'); 
        $this->db->join('user u','u.id = ua.by_user');
        $this->db->join('center_location cl','cl.center_id = u.center_id_home','left');
        $this->db->where(array('ua.by_user'=>$UserId,'ua.dateStr<='=>$todaystr,'ua.dateStr>='=>$today2,'ua.status'=>1)); 
        $this->db->order_by('ua.modified DESC'); 
        $this->db->limit(1000);     
        return $this->db->get('')->result_array();
    }

    public function getUserActivityToday($UserId,$todaystr,$params=array()){
        if(isset($params['limit']) && isset($params['offset'])){
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('ua.activity_id,ua.student_package_id,ua.latitude,ua.longitude,ua.activity_name,ua.description,ua.country,ua.state,ua.city,ua.IP_address,ua.isProxy,ua.isSuspicious,ua.created,CONCAT(u.fname, " ", u.lname) full_name,ua.by_user,cl.center_name');
        $this->db->from('user_activity ua'); 
        $this->db->join('user u','u.id = ua.by_user');
        $this->db->join('center_location cl','cl.center_id = u.center_id_home');
        $this->db->where(array('ua.by_user'=>$UserId,'ua.dateStr'=>$todaystr,'ua.status'=>1)); 
        $this->db->order_by('ua.modified DESC');      
        return $this->db->get('')->result_array();
    }
}