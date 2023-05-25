<?php
/**
 * @package         WOSA
 * @subpackage      -------
 * @author          Navjeet
 *
 **/
 class Counseling_session_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function empty_counselling()
    {
        $this->db->truncate('counseling_sessions');
        $this->db->truncate('counseling_sessions_group');
    }
    function getSessionBookingReport($params){

        $query='';
        $session_type = $params['session_type'];
        $test_module_id = $params['test_module_id'];
        $test_module_id = implode(',', $test_module_id);
        $center_id = $params['center_id'];
        $center_id = implode(',', $center_id);
        $date_from = $params['date_from'];
        $date_to = $params['date_to'];
        $is_attended = $params['is_attended'];

        if($session_type){
            $query .= " sess.session_type = '".$session_type."' and ";
        }
        if(!empty($center_id)){
            $query .= " sess.center_id IN(".$center_id.") and ";
        }
        if(!empty($test_module_id)){
            $query .= " sess.test_module_id IN(".$test_module_id.") and ";
        }
        if($date_from!='' and $date_to!=''){
            $df = strtotime($date_from);
            $dt = strtotime($date_to);            
            $query .= " sess.booking_date_str >= ".$df." and sess.booking_date_str <= ".$dt." and ";
        }        
        if($is_attended==0 or $is_attended==1){
            $query .= " sess.is_attended = ".$is_attended." ";
        }else{
            $query .= " sess.is_attended = 2";
        }       

        $x = $this->db->query('
            select 
            sess.booking_id,
            sess.session_type,            
            date_format(sess.booking_date, "%D %b %y") as `booking_date`,
            date_format(sess.created, "%D %b %y") as `created`,
            sess.booking_time_slot,
            sess.`booking_link`,
            sess.`is_attended`,
            sess.`remarks`,
            pgm.programe_name,
            tm.test_module_name,
            cl.center_name,
            s.id,
            s.fname,
            s.lname,
            s.UID
        from session_booking sess
        left join test_module tm on sess.test_module_id = tm.test_module_id
        left join programe_masters pgm on sess.programe_id = pgm.programe_id
        left join center_location cl on sess.center_id = cl.center_id
        left join students s on sess.student_id = s.id
        where '.$query.' order by sess.booking_date_str desc limit 100');
        return $x->result_array();
        //print_r($this->db->last_query());exit;

    }

    function getSessionBookingReportByUID($student_id){

        $x = $this->db->query('
            select 
            sess.booking_id,
            sess.session_type,            
            date_format(sess.booking_date, "%D %b %y") as `booking_date`,
            date_format(sess.created, "%D %b %y") as `created`,
            sess.booking_time_slot,
            sess.`booking_link`,
            sess.`is_attended`,
            sess.`remarks`,
            pgm.programe_name,
            tm.test_module_name,
            cl.center_name,
            s.id,
            s.fname,
            s.lname,
            s.UID
        from session_booking sess
        left join test_module tm on sess.test_module_id = tm.test_module_id
        left join programe_masters pgm on sess.programe_id = pgm.programe_id
        left join center_location cl on sess.center_id = cl.center_id
        left join students s on sess.student_id = s.id
        where sess.student_id='.$student_id.' order by sess.booking_date_str desc limit 10');
        return $x->result_array();
        //print_r($this->db->last_query());exit;

    }

    function get_student_counselling($id,$token){

        $this->db->select(' 
            sess.booking_id,
            sess.session_type,            
            date_format(sess.booking_date, "%D %b %y") as `booking_date`,
            date_format(sess.created, "%D %b %y") as `created`,
            sess.booking_time_slot,
            sess.`booking_link`,
            sess.`is_attended`,
            sess.`remarks`,
            pgm.programe_name,
            tm.test_module_name,
            cl.center_name
        ');
        $this->db->from('`session_booking` sess');
        $this->db->join('`test_module` tm', 'sess.`test_module_id`=tm.`test_module_id`');        
        $this->db->join('`programe_masters` pgm', 'sess.`programe_id`= pgm.`programe_id`');        
        $this->db->join('`center_location` cl', 'cl.`center_id`= sess.`center_id`', 'left');        
        if($token=='Bysid'){
            $this->db->where(array('sess.student_id'=>$id));
        }else{
            //$this->db->where(array('sess.student_package_id'=>$id));
        }               
        $this->db->order_by('sess.`booking_date_str` DESC');
        return $this->db->get('')->result_array();
    }

    function getStudentCounsellingAPI($id){

        $this->db->select(' 
            
            sess.session_type,            
            date_format(sess.booking_date, "%D %b %y") as `booking_date`,
            date_format(sess.created, "%D %b %y") as `created`,
            sess.booking_time_slot,
            sess.`booking_link`,
            sess.`is_attended`,
            sess.`remarks`,
            pgm.programe_name,
            tm.test_module_name,
            cl.center_name
        ');
        $this->db->from('`session_booking` sess');
        $this->db->join('`test_module` tm', 'sess.`test_module_id`=tm.`test_module_id`');        
        $this->db->join('`programe_masters` pgm', 'sess.`programe_id`= pgm.`programe_id`');        
        $this->db->join('`center_location` cl', 'cl.`center_id`= sess.`center_id`', 'left');        
        $this->db->where(array('sess.student_id'=>$id));
        $this->db->order_by('sess.`booking_date_str` DESC');
        return $this->db->get('')->result_array();
    }    

    function get_all_booked_counselling_list_countold($roleName,$userBranch)
    {       
        $this->db->from('students_counseling');
             
        return $this->db->count_all_results();
    }
    function get_all_booked_counselling_list_completed($session_type=NULL,$session_paymentStatus=NULL,$session_date=NULL,$session_pdate=NULL,$service_id=NULL,$booking_pdate=NULL,$payment_type=NULL,$params = array())
    {
       if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select(' `sess.id`, `is_otp_verified`, `todayDate`, `fname`, `lname`, `email`, `dob`, `country_code`, `mobile`, `sess.session_id`, `cs.session_type`, `booking_date`, `booking_date_str`, `booking_time_slot`, `cs.amount`, `sess.active`, `payment_status`, `txn_id`, `payment_date`, `payment_gross`, `response`, `sess.created`,enquiry_purpose_name as service_name,attended,remark,sess.message,sess.created,sessBookingNo,payment_type,payment_id,sess.method,cphc.modified as payment_date,cphc.checkout_token_no,cphc.page, `sess.response`');
        $this->db->from('`students_counseling` sess');
        if($session_type){
            $this->db->where(array('sess.session_type'=>$session_type));            
        }
        if($session_otp !=NULL){
            $this->db->where(array('sess.is_otp_verified'=>$session_otp));            
        }
        if($session_paymentStatus !=NULL){
            $this->db->where(array('sess.payment_status'=>$session_paymentStatus));            
        }
        if($service_id !=NULL){
            $this->db->where(array('sess.service_id'=>$service_id));            
        }
        if($payment_type !=NULL){
            $this->db->where(array('sess.payment_type'=>$payment_type));            
        }       
        if($session_date !=NULL){
            $psession_date= explode(' - ',$session_date);        
            $minvaluepsession_date=$psession_date[0];
           // $minvaluepsession_date=date_create($minvaluepsession_date);
           // $minvaluepsession_date=date_format($minvaluepsession_date,"d-m-Y");
            $maxvaluepsession_date=$psession_date[1];
            //$maxvaluepsession_date=date_create($maxvaluepsession_date);
          //  $maxvaluepsession_date=date_format($maxvaluepsession_date,"d-m-Y");
            $this->db->where("sess.booking_date >= '$minvaluepsession_date' AND sess.booking_date<='$maxvaluepsession_date'");            
        }
        if($booking_pdate !=NULL){
        $book_p= explode(' - ',$booking_pdate);
        $minvalue_book_p=$book_p[0]."T00:00:00Z";
        $maxvalue_book_p=$book_p[1]."T23:59:59Z";
        $this->db->where("DATE(sess.created) BETWEEN '$minvalue_book_p' AND '$maxvalue_book_p'");            
        }
        if($session_pdate !=NULL){
        $p= explode(' - ',$session_pdate);
        $minvalue=$p[0]."T00:00:00Z";
        $maxvalue=$p[1]."T23:59:59Z";       
        $this->db->where("payment_date BETWEEN '$minvalue' AND '$maxvalue'");            
        }
        $this->db->join('checkout_page_history_counselling cphc', 'cphc.checkout_token_no= sess.checkout_token_no');
        $this->db->join('enquiry_purpose_masters service', 'service.id= sess.service_id','left');
        $this->db->join('counseling_sessions cs', 'cs.id= sess.session_id');
        $this->db->order_by('sess.`created` DESC');
        $this->db->where(array('payment_status'=>'succeeded'));      
        return $this->db->get('')->result_array();
   
    }


    function get_all_booked_counselling_list($session_type=NULL,$session_paymentStatus=NULL,$session_date=NULL,$session_pdate=NULL,$service_id=NULL,$booking_pdate=NULL,$payment_type=NULL,$params = array()){

       if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select(' `sess.id`, `is_otp_verified`, `todayDate`, `fname`, `lname`, `email`, `dob`, `country_code`, `mobile`, `sess.session_id`, `cs.session_type`, `booking_date`, `booking_date_str`, `booking_time_slot`, `cs.amount`, `sess.active`, `payment_status`, `txn_id`, `payment_date`, `payment_gross`, `response`, `sess.created`,enquiry_purpose_name as service_name,attended,remark,sess.message,sess.created,sessBookingNo,payment_type,payment_id,sess.method,cphc.modified as payment_date,cphc.checkout_token_no,cphc.page, `sess.response`');

        $this->db->from('`students_counseling` sess');
        if($session_type){
            $this->db->where(array('sess.session_type'=>$session_type));            
        }
         if($payment_type !=NULL){
            $this->db->where(array('sess.payment_type'=>$payment_type));            
        }        
        if($session_paymentStatus !=NULL){
            $this->db->where(array('sess.payment_status'=>$session_paymentStatus));            
        }
        if($service_id !=NULL){
            $this->db->where(array('sess.service_id'=>$service_id));            
        }       
        if($session_date !=NULL){
        $psession_date= explode(' - ',$session_date);
        $minvaluepsession_date=$psession_date[0];
       // $minvaluepsession_date=date_create($minvaluepsession_date);
       // $minvaluepsession_date=date_format($minvaluepsession_date,"d-m-Y");
        $maxvaluepsession_date=$psession_date[1];
        //$maxvaluepsession_date=date_create($maxvaluepsession_date);
       // $maxvaluepsession_date=date_format($maxvaluepsession_date,"d-m-Y");          
       if($booking_pdate !=NULL){
        $book_p= explode(' - ',$booking_pdate);
        $minvalue_book_p=$book_p[0]."T00:00:00Z";
        $maxvalue_book_p=$book_p[1]."T23:59:59Z";
        $this->db->where("DATE(sess.created) BETWEEN '$minvalue_book_p' AND '$maxvalue_book_p'");            
        }
        $this->db->where("sess.booking_date >= '$minvaluepsession_date' AND sess.booking_date<='$maxvaluepsession_date'");
        }
        if($session_pdate !=NULL){
         $p= explode(' - ',$session_pdate);        
            $minvalue=$p[0]."T00:00:00Z";
            $maxvalue=$p[1]."T23:59:59Z";          
           $this->db->where("payment_date BETWEEN '$minvalue' AND '$maxvalue'");            
        }
       
        $this->db->join('checkout_page_history_counselling cphc', 'cphc.checkout_token_no= sess.checkout_token_no');
        $this->db->join('enquiry_purpose_masters service', 'service.id= sess.service_id','left');
        $this->db->join('counseling_sessions cs', 'cs.id= sess.session_id');
        $this->db->order_by('sess.`created` DESC');
       return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;   
    }
    function get_all_booked_counselling_list_count($session_type=NULL,$session_paymentStatus=NULL,$session_date=NULL,$session_pdate=NULL,$service_id=NULL,$payment_type=NULL,$params = array()){

        if(isset($params) && !empty($params))
         {
             $this->db->limit($params['limit'], $params['offset']);
         }
         $this->db->select(' `sess.id`');
 
         $this->db->from('`students_counseling` sess');
         if($session_type){
             $this->db->where(array('sess.session_type'=>$session_type));            
         }
          if($payment_type !=NULL){
             $this->db->where(array('sess.payment_type'=>$payment_type));            
         }        
         if($session_paymentStatus !=NULL){
             $this->db->where(array('sess.payment_status'=>$session_paymentStatus));            
         }
         if($service_id !=NULL){
             $this->db->where(array('sess.service_id'=>$service_id));            
         }       
         if($session_date !=NULL){
         $psession_date= explode(' - ',$session_date);
         $minvaluepsession_date=$psession_date[0];
         $minvaluepsession_date=date_create($minvaluepsession_date);
         $minvaluepsession_date=date_format($minvaluepsession_date,"d-m-Y");
         $maxvaluepsession_date=$psession_date[1];
         $maxvaluepsession_date=date_create($maxvaluepsession_date);
         $maxvaluepsession_date=date_format($maxvaluepsession_date,"d-m-Y");          
         $this->db->where("sess.booking_date BETWEEN '$minvaluepsession_date' AND '$maxvaluepsession_date'");
         }
         if($session_pdate !=NULL){
          $p= explode(' - ',$session_pdate);        
             $minvalue=$p[0]."T00:00:00Z";
             $maxvalue=$p[1]."T23:59:59Z";          
            $this->db->where("payment_date BETWEEN '$minvalue' AND '$maxvalue'");            
         }
           if($booking_pdate !=NULL){
             $book_p= explode(' - ',$booking_pdate);       
             $minvalue_book_p=$book_p[0];
             $maxvalue_book_p=$book_p[1];      
             $this->db->where("sess.created BETWEEN '$minvalue_book_p' AND '$maxvalue_book_p'");            
         }
         $this->db->join('checkout_page_history_counselling cphc', 'cphc.checkout_token_no= sess.checkout_token_no');
         $this->db->join('enquiry_purpose_masters service', 'service.id= sess.service_id','left');
         $this->db->join('counseling_sessions cs', 'cs.id= sess.session_id');
         $this->db->order_by('sess.`created` DESC');
         // $this->db->get('')->result_array();
         return $this->db->count_all_results();
         //print_r($this->db->last_query());exit;   
     }

    function getSessionType(){

        $this->db->distinct('');
        $this->db->select('session_type');
        $this->db->from('counseling_sessions_group');
        $this->db->where(array('active'=>1));
        return $this->db->get('')->result_array();
    }

    function getSessionTypeAll(){

        $this->db->distinct('');
        $this->db->select('session_type');
        $this->db->from('counseling_sessions_group');
        //$this->db->where(array('active'=>1));
        return $this->db->get('')->result_array();
    }
    
    function getSessionTypeIDs_timeslot($session_type){

        $this->db->select('id as counseling_sessions_group_id');
        $this->db->from('counseling_sessions_group');
        $this->db->where(array('session_type'=>$session_type,'active'=>1));
        return $this->db->get('')->result_array();
    }

    function getSessionTypeIDs(){

        $this->db->select('id as counseling_sessions_group_id');
        $this->db->from('counseling_sessions_group');
        $this->db->where(array('active'=>1));
        return $this->db->get('')->result_array();
    }

    function getCSGroupId($course_id){

        $this->db->distinct('');
        $this->db->select('csc.counseling_sessions_group_id');
        $this->db->from('counseling_session_course csc');
        $this->db->join('counseling_sessions_group csg', 'csg.id= csc.counseling_sessions_group_id');  
        $this->db->where('csg.active', 1);
        $this->db->where_in('csc.course_id', $course_id);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }    

    function getSessionTypeIDs_byBranch($branch_id){

        $this->db->distinct('');
        $this->db->select('csc.counseling_sessions_group_id');
        $this->db->from('counseling_session_centers csc');
        $this->db->join('counseling_sessions_group csg', 'csg.id= csc.counseling_sessions_group_id');  
        $this->db->where('csg.active', 1);
        $this->db->where(array('csc.center_id'=>$branch_id));
        return $this->db->get('')->result_array();
    }

    function getSessionCourse($arr){
        
        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('counseling_session_course csc');
        $this->db->join('test_module tm', 'tm.test_module_id= csc.course_id'); 
        $this->db->join('counseling_sessions_group csg', 'csg.id= csc.counseling_sessions_group_id');  
        $this->db->where('csg.active', 1);      
        $this->db->where_in('csc.counseling_sessions_group_id', $arr);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getAllSessionCourse(){
        
        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('counseling_session_course csc');
        $this->db->join('test_module tm', 'tm.test_module_id= csc.course_id');        
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getSessionBranch($arr){
        
        $this->db->distinct('');
        $this->db->select('cl.center_id,cl.center_name');
        $this->db->from('counseling_session_centers csc');
        $this->db->join('center_location cl', 'cl.center_id= csc.center_id'); 
        $this->db->join('counseling_sessions_group csg', 'csg.id= csc.counseling_sessions_group_id'); 
        $this->db->where('csg.active', 1);       
        $this->db->where_in('csc.counseling_sessions_group_id', $arr);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getSessionDates($arr){

        $this->db->distinct('');
        $this->db->select('session_date,session_type,amount,duration');
        $this->db->from('counseling_sessions'); 
        $this->db->where(array('active'=>1));       
        $this->db->where_in('counseling_sessions_group_id', $arr);
        $this->db->order_by('session_date','ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }    

    function Get_session_timeSlot($session_type,$date,$arr){

        $this->db->distinct('');
        $this->db->select('time_slot,counseling_sessions_group_id,id');
        $this->db->from('counseling_sessions'); 
        $this->db->where(array('session_type'=> $session_type,'session_date'=> $date,'active'=>1));  
       $this->db->where_in('counseling_sessions_group_id', $arr);
          $this->db->order_by('session_date_time','ASC');
        return $this->db->get('')->result_array();

        
        //print_r($this->db->last_query());exit;
    }

    function GetStartEndDate($session_type,$arr){

        $this->db->select('session_date_from,session_date_to');
        $this->db->from('counseling_sessions_group'); 
        $this->db->where(array('session_type'=> $session_type,'active'=>1));  
        $this->db->where_in('id', $arr);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;

    }

    function Get_final_session($session_type,$date,$time_slot){

        $this->db->select('counseling_sessions_group_id,zoom_link,amount,id');
        $this->db->from('counseling_sessions');
        $this->db->where(array('session_type'=>$session_type,'session_date'=>$date,'time_slot'=>$time_slot,'active'=>1));
        return $this->db->get('')->result_array();
       // print_r($this->db->last_query());exit;
    }
    
    /*
     * Get counseling session by id
     */
    function get_counseling_session($id)
    {
        return $this->db->get_where('counseling_sessions',array('id'=>$id))->row_array();
    }
    
    function get_counseling_sessions_group($id)
    {
        return $this->db->get_where('counseling_sessions_group',array('id'=>$id))->row_array();
    }
    /*
     * Get all counseling session count
     */
    function get_all_counseling_sessions_group_count($params)
    {
       @$counselingSessionSearch=$params['counselingSessionSearch'];
        $counseling_sessions_group_ids=array();
        $counseling_session_course_group_ids=$counseling_session_centers_group_ids=array();
        
        if(!empty($counselingSessionSearch['counseling_session_course'])){
            
            $counseling_session_course=$counselingSessionSearch['counseling_session_course'];
            $this->db->select('counseling_sessions_group_id');
            $this->db->from('counseling_session_course');
            $this->db->group_by('counseling_sessions_group_id');
            $this->db->where_in('course_id',$counseling_session_course);
            $counseling_session_course_group_ids = $this->db->get()->result_array();
            $counseling_session_course_group_ids=array_column($counseling_session_course_group_ids,'counseling_sessions_group_id');
            $counseling_sessions_group_ids=array_merge($counseling_sessions_group_ids,$counseling_session_course_group_ids);
            //pr($counseling_session_course_group_ids);
            if(empty($counseling_session_course_group_ids)){
                return 0;
            }
            //pr($counseling_sessions_group_ids,);
        }
        
        if(!empty($counselingSessionSearch['counseling_session_centers'])){
            
            $counseling_session_centers=$counselingSessionSearch['counseling_session_centers'];
            $this->db->select('counseling_sessions_group_id');
            $this->db->from('counseling_session_centers');
            $this->db->group_by('counseling_sessions_group_id');
            $this->db->where_in('center_id',$counseling_session_centers);
            $counseling_session_centers_group_ids = $this->db->get()->result_array();
            $counseling_session_centers_group_ids=array_column($counseling_session_centers_group_ids,'counseling_sessions_group_id');
            
            $counseling_sessions_group_ids=array_merge($counseling_sessions_group_ids,$counseling_session_centers_group_ids);
            //pr($counseling_session_centers_group_ids);
            if(empty($counseling_session_centers_group_ids)){
                return 0;
            }
            //pr($counseling_sessions_group_ids,);
        }
        if(!empty($counseling_session_course_group_ids) && !empty($counseling_session_centers_group_ids)){
            
            $counseling_sessions_group_ids = array_intersect($counseling_session_course_group_ids, $counseling_session_centers_group_ids);
            
            $counseling_sessions_group_ids = array_values($counseling_sessions_group_ids);
            //pr($counseling_session_course_group_ids);
            //pr($counseling_session_centers_group_ids,1);
        }
        
        $counseling_sessions_group_ids=array_unique($counseling_sessions_group_ids);
        //pr($counseling_sessions_group_ids,1);
        
        $this->db->select('*');
        $this->db->from('counseling_sessions_group');
        @$counselingSessionSearch=$params['counselingSessionSearch'];
        if(!empty($counseling_sessions_group_ids)){
            
            $this->db->where_in('id',$counseling_sessions_group_ids);
        }
        if(!empty($counselingSessionSearch['session_type'])){
            
            $this->db->where('session_type',$counselingSessionSearch['session_type']);
        }
        if(!empty($counselingSessionSearch['session_date'])){
            
            
            $session_date=$counselingSessionSearch['session_date'];
            $session_date_array=explode(' - ',$session_date);
            $start_date=trim($session_date_array[0]);
            $end_date=trim($session_date_array[1]);
            $this->db->where('((session_date_from BETWEEN "'.$start_date. '" and "'.$end_date.'") OR (session_date_to BETWEEN "'.$start_date. '" and "'.$end_date.'"))');
        }
        return $this->db->count_all_results();
        
        
    }
    function get_all_counseling_session_group($params = array())
    {  

        @$counselingSessionSearch=$params['counselingSessionSearch'];
        $counseling_sessions_group_ids=array();
        $counseling_session_course_group_ids=$counseling_session_centers_group_ids=array();
        
        if(!empty($counselingSessionSearch['counseling_session_course'])){
            
            $counseling_session_course=$counselingSessionSearch['counseling_session_course'];
            $this->db->select('counseling_sessions_group_id');
            $this->db->from('counseling_session_course');
            $this->db->group_by('counseling_sessions_group_id');
            $this->db->where_in('course_id',$counseling_session_course);
            $counseling_session_course_group_ids = $this->db->get()->result_array();
            $counseling_session_course_group_ids=array_column($counseling_session_course_group_ids,'counseling_sessions_group_id');
            $counseling_sessions_group_ids=array_merge($counseling_sessions_group_ids,$counseling_session_course_group_ids);
            //pr($counseling_session_course_group_ids);
            if(empty($counseling_session_course_group_ids)){
                return array();
            }
            //pr($counseling_sessions_group_ids,);
        }
        
        if(!empty($counselingSessionSearch['counseling_session_centers'])){
            
            $counseling_session_centers=$counselingSessionSearch['counseling_session_centers'];
            $this->db->select('counseling_sessions_group_id');
            $this->db->from('counseling_session_centers');
            $this->db->group_by('counseling_sessions_group_id');
            $this->db->where_in('center_id',$counseling_session_centers);
            $counseling_session_centers_group_ids = $this->db->get()->result_array();
            $counseling_session_centers_group_ids=array_column($counseling_session_centers_group_ids,'counseling_sessions_group_id');
            
            $counseling_sessions_group_ids=array_merge($counseling_sessions_group_ids,$counseling_session_centers_group_ids);
            //pr($counseling_session_centers_group_ids);
            if(empty($counseling_session_centers_group_ids)){
                return array();
            }
            //pr($counseling_sessions_group_ids,);
        }
        if(!empty($counseling_session_course_group_ids) && !empty($counseling_session_centers_group_ids)){
            
            $counseling_sessions_group_ids = array_intersect($counseling_session_course_group_ids, $counseling_session_centers_group_ids);
            
            $counseling_sessions_group_ids = array_values($counseling_sessions_group_ids);
            //pr($counseling_session_course_group_ids);
            //pr($counseling_session_centers_group_ids,1);
        }
        $counseling_sessions_group_ids=array_unique($counseling_sessions_group_ids);
        //pr($counseling_sessions_group_ids,1);
        
        $this->db->select('*');
        $this->db->from('counseling_sessions_group');
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        if(!empty($counselingSessionSearch['session_type'])){
            
            $this->db->where('session_type',$counselingSessionSearch['session_type']);
        }
        if(!empty($counseling_sessions_group_ids)){
            
            $this->db->where_in('id',$counseling_sessions_group_ids);
        }
        
        if(!empty($counselingSessionSearch['session_date'])){
            
            
            $session_date=$counselingSessionSearch['session_date'];
            $session_date_array=explode(' - ',$session_date);
            $start_date=trim($session_date_array[0]);
            $end_date=trim($session_date_array[1]);
            $this->db->where('((session_date_from BETWEEN "'.$start_date. '" and "'.$end_date.'") OR (session_date_to BETWEEN "'.$start_date. '" and "'.$end_date.'"))');

        }
        // $this->db->group_by('session_date_from');
        $this->db->order_by('id','desc');
        return $this->db->get()->result_array();
        
        
    }
    function getCounselingSessionsGroupTimeSlotBySessionsGroupId($counseling_sessions_group_id){
        
        $this->db->select('time_slot');
        $this->db->from('counseling_sessions');
        $this->db->where('counseling_sessions_group_id',$counseling_sessions_group_id);
        $this->db->group_by('time_slot');
        $this->db->order_by('time_slot','asc');
        $data=$this->db->get()->result_array();
        return $data;
        
    }
    function getMaxSessionDateTimeStrBYSessionGroupID($counseling_sessions_group_id){
        
        $this->db->select('MAX(session_date_time_str) as session_end_date_time_str');
        $this->db->from('counseling_sessions');
        $this->db->where('counseling_sessions_group_id',$counseling_sessions_group_id);
        $data=$this->db->get()->row_array();
        $session_end_date_time_str=$data['session_end_date_time_str'];
        return $session_end_date_time_str;
        
    }
    
    function get_all_counseling_session_active_count($counseling_sessions_group_id)
    {
        $this->db->select('*');
        $this->db->from('counseling_sessions');
        $this->db->where('counseling_sessions_group_id',$counseling_sessions_group_id);
        $this->db->where('active',1);
        return $this->db->count_all_results();   
    }
    function get_all_counseling_session_count($counseling_sessions_group_id,$params)
    {   
    
        @$counselingSessionSearch=$params['counselingSessionSearch'];
        $counseling_sessions_ids=array();
        $counseling_session_course_ids=$counseling_session_centers_ids=array();
        
        if(!empty($counselingSessionSearch['counseling_session_course'])){
            
            $counseling_session_course=$counselingSessionSearch['counseling_session_course'];
            $this->db->select('counseling_session_id');
            $this->db->from('counseling_session_course');
            $this->db->group_by('counseling_session_id');
            $this->db->where_in('course_id',$counseling_session_course);
            $this->db->where('counseling_sessions_group_id',$counseling_sessions_group_id);
            $counseling_session_course_ids = $this->db->get()->result_array();
            $counseling_session_course_ids=array_column($counseling_session_course_ids,'counseling_session_id');
            $counseling_sessions_ids=array_merge($counseling_sessions_ids,$counseling_session_course_ids);
            if(empty($counseling_session_course_ids)){
                return 0;
            }
        }
        if(!empty($counselingSessionSearch['counseling_session_centers'])){
            
            $counseling_session_centers=$counselingSessionSearch['counseling_session_centers'];
            $this->db->select('counseling_session_id');
            $this->db->from('counseling_session_centers');
            $this->db->group_by('counseling_session_id');
            $this->db->where_in('center_id',$counseling_session_centers);
            $this->db->where('counseling_sessions_group_id',$counseling_sessions_group_id);
            
            $counseling_session_centers_ids = $this->db->get()->result_array();
            $counseling_session_centers_ids=array_column($counseling_session_centers_ids,'counseling_session_id');
            
            $counseling_sessions_ids=array_merge($counseling_sessions_ids,$counseling_session_centers_ids);
            if(empty($counseling_session_centers_ids)){
                
                return 0;
            }
        }
        if(!empty($counseling_session_course_ids) && !empty($counseling_session_centers_ids)){
            
            $counseling_sessions_ids = array_intersect($counseling_session_course_ids, $counseling_session_centers_ids);
            
            $counseling_sessions_ids = array_values($counseling_sessions_ids);
        }
        $counseling_sessions_ids=array_unique($counseling_sessions_ids);
        
        $this->db->select('*');
        $this->db->from('counseling_sessions');
        $this->db->where('counseling_sessions_group_id',$counseling_sessions_group_id);
        if(!empty($counseling_sessions_ids)){
            
            $this->db->where_in('id',$counseling_sessions_ids);
        }
        if(!empty($counselingSessionSearch['session_date'])){
            
            
            $session_date=$counselingSessionSearch['session_date'];
            $session_date_array=explode(' - ',$session_date);
            $start_date=trim($session_date_array[0]);
            $end_date=trim($session_date_array[1]);
            $this->db->where('(session_date BETWEEN "'.$start_date. '" and "'.$end_date.'")');
        }
        if(!empty($counselingSessionSearch['counseling_session_time_slot'])){
            
            
            $counseling_session_time_slot=$counselingSessionSearch['counseling_session_time_slot'];
            $this->db->where('time_slot',$counseling_session_time_slot);
        }
        
        //$this->db->group_by('session_date');
        return $this->db->count_all_results();   
    }
    /*
     * Get all counseling session
     */
    function get_all_counseling_session($counseling_sessions_group_id,$params = array())
    {    
        
        
        @$counselingSessionSearch=$params['counselingSessionSearch'];
        $counseling_sessions_ids=array();
        $counseling_session_course_ids=$counseling_session_centers_ids=array();
        //pr($counselingSessionSearch);
        if(!empty($counselingSessionSearch['counseling_session_course'])){
            
            $counseling_session_course=$counselingSessionSearch['counseling_session_course'];
            $this->db->select('counseling_session_id');
            $this->db->from('counseling_session_course');
            $this->db->group_by('counseling_session_id');
            $this->db->where_in('course_id',$counseling_session_course);
            $this->db->where('counseling_sessions_group_id',$counseling_sessions_group_id);
            $counseling_session_course_ids = $this->db->get()->result_array();
            $counseling_session_course_ids=array_column($counseling_session_course_ids,'counseling_session_id');
            $counseling_sessions_ids=array_merge($counseling_sessions_ids,$counseling_session_course_ids);
            if(empty($counseling_session_course_ids)){
                return array();
            }
        }
        if(!empty($counselingSessionSearch['counseling_session_centers'])){
            
            $counseling_session_centers=$counselingSessionSearch['counseling_session_centers'];
            $this->db->select('counseling_session_id');
            $this->db->from('counseling_session_centers');
            $this->db->group_by('counseling_session_id');
            $this->db->where_in('center_id',$counseling_session_centers);
            $this->db->where('counseling_sessions_group_id',$counseling_sessions_group_id);
            
            $counseling_session_centers_ids = $this->db->get()->result_array();
            $counseling_session_centers_ids=array_column($counseling_session_centers_ids,'counseling_session_id');
            
            $counseling_sessions_ids=array_merge($counseling_sessions_ids,$counseling_session_centers_ids);
            if(empty($counseling_session_centers_ids)){
                return array();
            }
        }
        if(!empty($counseling_session_course_ids) && !empty($counseling_session_centers_ids)){
            
            $counseling_sessions_ids = array_intersect($counseling_session_course_ids, $counseling_session_centers_ids);
            
            $counseling_sessions_ids = array_values($counseling_sessions_ids);
        }
        $counseling_sessions_ids=array_unique($counseling_sessions_ids);
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('*');
        $this->db->from('counseling_sessions');
        $this->db->where('counseling_sessions_group_id',$counseling_sessions_group_id);
        
        if(!empty($counseling_sessions_ids)){
            
            $this->db->where_in('id',$counseling_sessions_ids);
        }
        if(!empty($counselingSessionSearch['session_date'])){
            
            
            $session_date=$counselingSessionSearch['session_date'];
            $session_date_array=explode(' - ',$session_date);
            $start_date=trim($session_date_array[0]);
            $end_date=trim($session_date_array[1]);
            $this->db->where('(session_date BETWEEN "'.$start_date. '" and "'.$end_date.'")');
        }
        if(!empty($counselingSessionSearch['counseling_session_time_slot'])){
            
            
            $counseling_session_time_slot=$counselingSessionSearch['counseling_session_time_slot'];
            $this->db->where('time_slot',$counseling_session_time_slot);
        }
        $this->db->order_by('session_date_time_str', 'asc');
        $results=array();
        return $this->db->get()->result_array();
        
    }
    function get_all_counseling_session_active($params){       
    
       if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('cs.*,csc.counseling_session_id');
        $this->db->from('counseling_sessions as cs');
        $this->db->join('counseling_session_centers csc', 'csc.counseling_session_id= cs.id');
        $this->db->group_by('cs.id');
        $this->db->where('cs.active', 1);  
        $this->db->order_by('cs.id', 'desc');
        return $this->db->get()->result_array();
    }    
        
    /*
     * function to add new department_master
     */
    function add_c_session($params)
    {
        $this->db->insert('counseling_sessions',$params);
        return $this->db->insert_id();
    }
    function add_counseling_session($params)
    {
        $this->db->insert('students_counseling',$params);
        return $this->db->insert_id();
    }
    function update_counseling_session($id,$params)
    {
        $this->db->where('id',$id);
        if($this->db->update('counseling_sessions',$params)){
            return true;
        }
    }
    function _add_counseling_sessions_group($params)
    {
        $this->db->insert('counseling_sessions_group',$params);
        return $this->db->insert_id();
    }
    /*
     * function to update counseling sessions
    */
    function update_counseling_session_group($id,$params)
    {
        $this->db->where('id',$id);
        if($this->db->update('counseling_sessions_group',$params)){
            return true;
        }
    }
    
    /*
     * function to delete counseling_sessions
     */
    function delete_counseling_session($id)
    {
        $this->db->delete('counseling_sessions',array('id'=>$id));
        $this->db->delete('counseling_session_centers',array('counseling_session_id'=>$id));
        $this->db->delete('counseling_session_course',array('counseling_session_id'=>$id));
    }
    
    function delete_counseling_session_group($id)
    {
        $this->db->delete('counseling_sessions_group',array('id'=>$id));
        $this->db->delete('counseling_sessions',array('counseling_sessions_group_id'=>$id));
        $this->db->delete('counseling_session_centers',array('counseling_sessions_group_id'=>$id));
        $this->db->delete('counseling_session_course',array('counseling_sessions_group_id'=>$id));
    }
    
    function add_counseling_session_center($params){

        $this->db->from('counseling_session_centers');
        $this->db->where(array('counseling_session_id'=>$params['counseling_session_id'],'center_id'=>$params['center_id']));
        $c = $this->db->count_all_results();
        if($c==0){
           $this->db->insert('counseling_session_centers',$params);
           return $this->db->insert_id(); 
        }else{
            return 0;
        }        
    }
    function add_counseling_session_course($params){

        $this->db->from('counseling_session_course');
        $this->db->where(array('counseling_session_id'=>$params['counseling_session_id'],'course_id'=>$params['course_id']));
        $c = $this->db->count_all_results();
        if($c==0){
           $this->db->insert('counseling_session_course',$params);
           return $this->db->insert_id(); 
        }else{
            return 0;
        }        
    }
    function add_counseling_session_time_slots($counseling_session_id,$params,$old_counseling_session_id=null){
        
        if(!empty($old_counseling_session_id)){
          $this->db->where('counseling_session_id',$old_counseling_session_id);
          $this->db->delete('counseling_session_time_slots');
        }
        if(!empty($params)){
           $this->db->insert_batch('counseling_session_time_slots',$params);
           $id=$this->db->insert_id();
           $total_time_slot=count($params);
           $this->db->where('id ',$counseling_session_id);
           $this->db->update('counseling_sessions',array('total_time_slot'=>$total_time_slot));
           return $id;
        }else{
            return 0;
        }
    }
    
    function getCenterByCounselingSessionId($counseling_session_id){
        
        $this->db->select('cl.center_id,cl.center_name,csc.counseling_session_id');
        $this->db->from('counseling_session_centers csc');
        $this->db->join('center_location cl', 'cl.center_id= csc.center_id','left');
        $this->db->where(array('csc.counseling_session_id'=>$counseling_session_id));
        $results=$this->db->get('')->result_array();
        $centers=array();
        foreach($results as $key=>$data){
            $centers[$data['center_id']]=$data;
        }
        return $centers;
    }
    function getCourseByCounselingSessionId($counseling_session_id){
        
        $this->db->select('cl.test_module_id ,cl.test_module_name,csc.counseling_session_id');
        $this->db->from('counseling_session_course csc');
        $this->db->join('test_module cl', 'cl.test_module_id = csc.course_id','left');
        
        $this->db->where(array('csc.counseling_session_id'=>$counseling_session_id));
        $results=$this->db->get('')->result_array();
        $centers=array();
        foreach($results as $key=>$data){
            $centers[$data['test_module_id']]=$data;
        }
        return $centers;
    }
    
    function getCenterByCounselingSessionsGroupId($counseling_sessions_group_id){
        
        $this->db->select('cl.center_id,cl.center_name,csc.counseling_session_id');
        $this->db->from('counseling_session_centers csc');
        $this->db->join('center_location cl', 'cl.center_id= csc.center_id','left');
        $this->db->where(array('csc.counseling_sessions_group_id'=>$counseling_sessions_group_id));
        $results=$this->db->get('')->result_array();
        $centers=array();
        foreach($results as $key=>$data){
            $centers[$data['center_id']]=$data;
        }
        return $centers;
    }
    
    function getCourseByCounselingSessionsGroupId($counseling_sessions_group_id){
        
        $this->db->select('cl.test_module_id ,cl.test_module_name,csc.counseling_session_id');
        $this->db->from('counseling_session_course csc');
        $this->db->join('test_module cl', 'cl.test_module_id = csc.course_id','left');
        
        $this->db->where(array('csc.counseling_sessions_group_id'=>$counseling_sessions_group_id));
        $results=$this->db->get('')->result_array();
        $centers=array();
        foreach($results as $key=>$data){
            $centers[$data['test_module_id']]=$data;
        }
        return $centers;
    }
    
    function getTimeSlotByCounselingSessionId($counseling_session_id){
        
        $this->db->select('uh.counseling_session_id,uh.time_slot_id,uh.active,tsm.time_slot');
        $this->db->from('counseling_session_time_slots uh');
        $this->db->join('time_slot_master tsm', 'tsm.id= uh.time_slot_id');
        $this->db->where(array('uh.counseling_session_id'=>$counseling_session_id));
        
        $this->db->order_by('tsm.time_slot', 'asc');
        $results=$this->db->get('')->result_array();
        //$this->db->last_query();
        $dataNew=array();
        $i=1;
        foreach($results as $data){
            
            $dataNew[$i]=$data;
            $i++;
        }
        return $dataNew;
        
    }
    function delete_counseling_session_course($counseling_session_id,$course_id){ 
        return $this->db->delete('counseling_session_course',array('course_id'=>$course_id,'counseling_session_id'=>$counseling_session_id));
    }
    function delete_counseling_session_centers($counseling_session_id,$center_id){ 
        return $this->db->delete('counseling_session_centers',array('center_id'=>$center_id,'counseling_session_id'=>$counseling_session_id));
    }
    
    
    function ChekTimeSlotList(){
        
        
        $this->db->select('cs.*');
        $this->db->from('counseling_sessions as cs');
        $this->db->where('cs.active', 1);  
        $this->db->order_by('cs.session_date_time_str', 'asc');
        $results=$this->db->get()->result_array();
        //pr($results,1);
        $data=array();
        foreach($results as $key=>$result){
            
            $session_date=$result['session_date'];
            $time_slot=$result['time_slot'];
            $session_type=$result['session_type'];
            $id=$result['id'];
            //$this->db->select('center_id');
           // $this->db->from('counseling_session_centers');
            //$this->db->where('counseling_session_id', $id);
            $sub_array=array();
                $sub_array['id']=$id;
                $sub_array['session_date']=$session_date;
                $sub_array['time_slot']=$time_slot;
                $sub_array['center_id']=0;
                $sub_array['session_type']=$session_type;
                $data[]=$sub_array;
            /*$branchs=$results=$this->db->get()->result_array();
            
            if(!empty($branchs)){
                
                foreach($branchs as $branch){
                    $sub_array=array();
                    $sub_array['id']=$id;
                    $sub_array['session_date']=$session_date;
                    $sub_array['time_slot']=$time_slot;
                    $sub_array['center_id']=$branch['center_id'];
                    $sub_array['session_type']=$session_type;
                    $data[]=$sub_array;
                }
                
            }else{
                $sub_array=array();
                $sub_array['id']=$id;
                $sub_array['session_date']=$session_date;
                $sub_array['time_slot']=$time_slot;
                $sub_array['center_id']=0;
                $sub_array['session_type']=$session_type;
                $data[]=$sub_array;
            }*/
            
            //$sub_array=array('id'=>);
            //$data[$session_date][]=
        }
        return $data;
        
    }
    
    function gettodaycounselling($todaystr)
    {
        // echo strtotime($todaystr);
        $this->db->select('id,duration,counseling_sessions_group_id')
            ->where(array('session_date_time_str <='=>strtotime($todaystr),'active'=>1));
        return $this->db->get('counseling_sessions')->result_array();
    }
    function deactivate_shedule($todaystr){

        $params = array('active'=> 0);
        $this->db->where('session_date_time_str <=',$todaystr);
        $this->db->update('counseling_sessions',$params);
        
        // $this->db->where('session_from_to_date <=',$todaystr);
        $this->db->where('session_end_date_time_str <=',$todaystr);
        $this->db->update('counseling_sessions_group',$params);
    }

    function deactivate_shedule_new($id,$groupid)
    {
        $params = array('active'=> 0);
        $this->db->where('id',$id);
        $this->db->update('counseling_sessions',$params);
        
        $this->db->where('id',$groupid);
        $this->db->update('counseling_sessions_group',$params);

    }

     function checkStudentExistence($data){

        $this->db->select('id,active,is_otp_verified');
        $this->db->from('`students_counseling`');        
        $this->db->where(array('mobile'=>$data)); 
        $this->db->or_where(array('email'=>$data));    
        return $this->db->get('')->row_array();
    }
     function getOTP($id)
     {

        $this->db->select('OTP');
        $this->db->from('`students_counseling`');       
        $this->db->where(array('id'=>$id));
        return $this->db->get('')->row_array();
    }
    function update_campaign($id,$params)
    {
        $this->db->where('id',$id);
        if($this->db->update('students_counseling',$params)){
            return true;
        }
    }
    function update_student_session($id,$params)
    {
        $this->db->where('id',$id);
        if($this->db->update('students_counseling',$params)){
            return true;
        }
    }
    function get_student_session($id)
     {

        $this->db->select('`sc.id`, `sc.OTP`, `sc.is_otp_verified`, `sc.todayDate`, `sc.fname`, `sc.lname`, `sc.email`, `sc.dob`, `sc.country_code`, `sc.mobile`, `sc.session_id`, `sc.session_type`, `sc.service_id`, `sc.message`, `sc.booking_date`, `sc.booking_date_str`, `sc.booking_time_slot`, `sc.amount`, `sc.active`, `sc.payment_status`, `sc.txn_id`, `sc.payment_date`, `sc.payment_gross`, `sc.response`, `sc.attended`, `sc.remark`, `sc.created`, `sc.modified`,service.enquiry_purpose_name,counseling_sessions.duration,counseling_sessions.amount,sessBookingNo');
        $this->db->from('`students_counseling` sc');       
        $this->db->where(array('sc.id'=>$id));
        $this->db->join('enquiry_purpose_masters service', 'service.id= sc.service_id','left');
         $this->db->join('counseling_sessions', 'counseling_sessions.id= sc.session_id','left');
        return $this->db->get('')->row_array();
    }
    function Get_session_detail($id){

        $this->db->select('amount');
        $this->db->from('counseling_sessions');
        $this->db->where(array('id'=>$id));
        return $this->db->get('')->row_array();
    }

    function get_all_payment_status()
    {
        $this->db->select('payment_status');
        $this->db->from('students_counseling');
       $this->db->group_by('payment_status'); 
        return $this->db->get('')->result_array();

    }

    function get_general_info()
    {
        $this->db->select('id,description');
        $this->db->from('counseling_sessions_general_info');       
      return $this->db->get('')->result_array();    

    }
     function get_general_info_byid($id)
    {
        $this->db->select('id,description');
        $this->db->from('counseling_sessions_general_info'); 
         $this->db->where(array('id'=>$id));      
      return $this->db->get('')->row_array();    

    }  

    function update_general_info_byid($id,$params)
    {
        $this->db->where('id',$id);
        if($this->db->update('counseling_sessions_general_info',$params)){
            return true;
        }
    }


    function get_all_booked_counselling_list_completed_csv($session_type=0,$booking_pdate=0,$session_datew=0,$service_id=0,$session_pdate=0,$payment_type=0){

        /*if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }*/


        $this->db->select('`sess.id`, `is_otp_verified`, `todayDate`, `fname`, `lname`, `email`, `dob`, `country_code`, `mobile`, `session_id`, `cs.session_type`, `booking_date`, `booking_date_str`, `booking_time_slot`, `cs.amount`, `sess.active`, `payment_status`, `txn_id`, `payment_date`, `payment_gross`, `response`, `sess.created`,enquiry_purpose_name as service_name,attended,remark,,sess.message,sess.created,sessBookingNo,payment_type');

        $this->db->from('`students_counseling` sess');
        if($session_type){
            $this->db->where(array('sess.session_type'=>$session_type));            
        }
        if($session_otp !=0){
            $this->db->where(array('sess.is_otp_verified'=>$session_otp));            
        }
        if(($payment_type !=0 && $payment_type !='' )){
            $this->db->where(array('sess.payment_type'=>$payment_type));            
        }
        if($session_paymentStatus !=0){
            $this->db->where(array('sess.payment_status'=>$session_paymentStatus));            
        }
        if($service_id !=0){
            $this->db->where(array('sess.service_id'=>$service_id));
            
        }
       
        if($session_datew !=0){
         $psession_date= explode(' - ',$session_datew);
         //print_r($p);
           // $date=date_create($session_date);
           //$dt=date_format($date,"Y-m-d");
            $minvaluepsession_date=$psession_date[0];
            $minvaluepsession_date=date_create($minvaluepsession_date);
           $minvaluepsession_date=date_format($minvaluepsession_date,"d-m-Y");

            $maxvaluepsession_date=$psession_date[1];
            $maxvaluepsession_date=date_create($maxvaluepsession_date);
           $maxvaluepsession_date=date_format($maxvaluepsession_date,"d-m-Y");
            //$this->db->where(array('sess.booking_date'=>$session_date));

            $this->db->where("sess.booking_date BETWEEN '$minvaluepsession_date' AND '$maxvaluepsession_date'");
            
        }
        if($booking_pdate !=0){
         $book_p= explode(' - ',$booking_pdate);
         //print_r($p);
           // $date=date_create($session_date);
           //$dt=date_format($date,"Y-m-d");
            $minvalue_book_p=$book_p[0].' 00:00:00';
            $maxvalue_book_p=$book_p[1].' 23:59:59';
            //$this->db->where(array('sess.booking_date'=>$session_date));

            $this->db->where("sess.created BETWEEN '$minvalue_book_p' AND '$maxvalue_book_p'");
            
        }
        if($session_pdate !=0){
         $p= explode(' - ',$session_pdate);
         //print_r($p);
           // $date=date_create($session_date);
           //$dt=date_format($date,"Y-m-d");
            $minvalue=$p[0]."T00:00:00Z";
            $maxvalue=$p[1]."T23:59:59Z";
            //$this->db->where(array('sess.booking_date'=>$session_date));

            $this->db->where("payment_date BETWEEN '$minvalue' AND '$maxvalue'");
            
        }
        $this->db->join('enquiry_purpose_masters service', 'service.id= sess.service_id','left');
         $this->db->join('counseling_sessions cs', 'cs.id= sess.session_id');
        $this->db->order_by('sess.`created` DESC');
        $this->db->where(array('payment_status'=>'completed'));
       // $this->db->where("payment_status=completed");
    return $this->db->get('')->result_array();
   //print_r($this->db->last_query());exit;
   
    }
/*
      function get_last_sessionNo()
    {
        $this->db->select('sessBookingNo');
        $this->db->from('students_counseling');
        return $this->db->get('')->result_array();

    }*/
     function get_last_sessionNo()
    {
        $query = $this->db->query("SELECT `sessBookingNo` FROM `students_counseling`  order by id desc limit 1");
        $row = $query->row();
        return $row->sessBookingNo;
    }

    function get_all_booked_counselling_list_completed_count($roleName,$userBranch)
    {       
        $this->db->from('students_counseling');
        $this->db->join('enquiry_purpose_masters service', 'service.id= students_counseling.service_id','left');
        $this->db->join('counseling_sessions cs', 'cs.id= students_counseling.session_id');
        $this->db->where(array('payment_status'=>'completed'));
        return $this->db->count_all_results();
    }

    


}
