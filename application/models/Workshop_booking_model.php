<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Rajan Bansal
 *
 **/

 
class Workshop_booking_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all_workshop_bookings_dates(){

        $this->db->distinct('');
        $this->db->select('todayDate');
        $this->db->from('students_enquiry');
        $this->db->where('formType',"workshop");
        $this->db->order_by('enquiry_id', 'DESC');
        return $this->db->get()->result_array();
    }

    function getEnquiry_mobileEmail($enquiry_id){

        $this->db->select('mobile,email,country_code');
        $this->db->from('students_enquiry');
        $this->db->where('enquiry_id', $enquiry_id);
        return $this->db->get()->row_array();
    }

    /*
     * Get all students enquiry count
     */
    function get_all_workshop_booking_count($enquiry_purpose_id)
    {
        $this->db->from('students_enquiry');
        if($enquiry_purpose_id>0){
           $this->db->where('enquiry_purpose_id',$enquiry_purpose_id); 
        }else{} 

        $this->db->where('formType','workshop');
        return $this->db->count_all_results();
    } 

     function get_all_workshop_booking_count_filterDate($filterDate)
    {
        $this->db->from('students_enquiry');
        $this->db->where('todayDate',$filterDate);
        $this->db->where('formType','workshop');
        return $this->db->count_all_results();
    } 

    /*
     * Get all students enquiry count
     */
    function get_all_pwise_enquiry_count($enquiry_purpose_id)
    {
        $this->db->from('students_enquiry');
        $this->db->where(array('enquiry_purpose_id'=>$enquiry_purpose_id));
        $this->db->where('formType','workshop');
        return $this->db->count_all_results();
    }

    /*
     * Get all students enquiry count
     */
    function get_all_oc_enquiry_count($enquiry_purpose_id)
    {
        $this->db->from('students_enquiry');
        $this->db->where(array('enquiry_purpose_id'=>$enquiry_purpose_id));
        $this->db->where('formType','workshop');
        return $this->db->count_all_results();
    }

    /*
     * Get all students enquiry count
     */
    function get_all_pp_enquiry_count($enquiry_purpose_id)
    {
        $this->db->from('students_enquiry');
        $this->db->where(array('enquiry_purpose_id'=>$enquiry_purpose_id));
        $this->db->where('formType','workshop');
        return $this->db->count_all_results();
    }

    /*
     * Get all students enquiry count
     */
    function get_all_ic_enquiry_count($enquiry_purpose_id)
    {
        $this->db->from('students_enquiry');
        $this->db->where(array('enquiry_purpose_id'=>$enquiry_purpose_id));
        $this->db->where('formType','workshop');
        return $this->db->count_all_results();
    }

    /*
     * Get all students enquiry count
     */
    function get_all_sv_enquiry_count($enquiry_purpose_id)
    {
        $this->db->from('students_enquiry');
        $this->db->where(array('enquiry_purpose_id'=>$enquiry_purpose_id));
        $this->db->where('formType','workshop');
        return $this->db->count_all_results();
    }

    /*
     * Get all students enquiry count
     */
    function get_all_no_enquiry_count()
    {
        $this->db->from('students_enquiry');
        $this->db->where(array('isReplied'=>0)); 
        $this->db->where('formType','workshop');
        return $this->db->count_all_results();
    } 
    

    function get_all_workshop_bookings($enquiry_purpose_id,$params = array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            se.`enquiry_id`,
            se.`enquiry_no`,
            s.`fname`,
            s.`lname`,
            s.`dob`,
            s.`email`,
            s.`is_email_verified`,
            s.`is_otp_verified`,
            s.`country_code`,
            s.`mobile`,
            se.formType,
            se.courseName,
            se.`free_demo`,
            se.`isReplied`,
            se.`is_transfered`,
            se.`message`,
            se.`created`,
            s.id as student_id,
            s.UID');
        $this->db->from('`students_enquiry` se');
        $this->db->join('`students` s', 's.`id`= se.`student_id`', 'left');
        $this->db->where('se.formType','workshop');
        $this->db->order_by('se.enquiry_id', 'DESC'); 
        return $this->db->get('')->result_array();
    }

    function get_all_workshop_booking_filterDate($filterDate,$params = array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            se.`enquiry_id`,
            se.`enquiry_no`,
            s.`fname`,
            s.`lname`,
            s.`dob`,
            s.`email`,
            s.`is_email_verified`,
            s.`is_otp_verified`,
            s.`country_code`,
            s.`mobile`,
            s.id as student_id,
            s.UID,            
            se.`isReplied`,
            se.`is_transfered`,
            se.`message`,
            se.`created`,
            se.`formType`,
            se.`courseName`           
        ');
        $this->db->from('`students_enquiry` se');
        $this->db->join('`students` s', 's.`id`= se.`student_id`');
        $this->db->where('se.todayDate',$filterDate);
        $this->db->where('se.formType','workshop');
        $this->db->order_by('enquiry_id', 'DESC'); 
        return $this->db->get('')->result_array();
    }

    function get_all_pwise_enquiry($enquiry_purpose_id,$params = array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            se.`enquiry_id`,
            se.`fname`,
            se.`lname`,
            se.`dob`,
            se.`email`,
            se.`is_otp_verified`,
            se.`country_code`,
            se.`mobile`,
            se.`free_demo`,
            se.`isReplied`,
            se.`message`,
            se.`created`,
            tm.`test_module_name`,
            pgm.`programe_name`,
            cl.`center_name`,
            epm.`enquiry_purpose_name`,
            cnt.`name` as `country_name`,
            s.id as student_id,s.UID
        ');
        $this->db->from('`students_enquiry` se');
        $this->db->join('`enquiry_purpose_masters` epm', 'epm.`id`= se.`enquiry_purpose_id`', 'left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= se.`test_module_id`', 'left');
        $this->db->join('`programe_masters` pgm', 'pgm.`programe_id`= se.`programe_id`', 'left');
        $this->db->join('`country` cnt', 'cnt.country_id = se.country_id', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= se.`center_id`', 'left');
        $this->db->join('`students` s', 's.`mobile`= se.`mobile`', 'left');
        $this->db->where(array('enquiry_purpose_id'=>$enquiry_purpose_id));
        $this->db->order_by('enquiry_id', 'DESC'); 
        return $this->db->get('')->result_array();
    }

    function get_all_enquiry_not_replied($params = array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            se.`enquiry_id`,
            se.`enquiry_no`,
            s.`fname`,
            s.`lname`,
            s.`dob`,
            s.`email`,
            s.`is_otp_verified`,
            s.`mobile`,
            s.`country_code`,                        
            se.`is_transfered`,
            se.`isReplied`,
            se.`message`,
            se.`created`,           
            epm.`enquiry_purpose_name`,
            s.id as student_id,
            s.id as student_id,s.UID
        ');
        $this->db->from('`students_enquiry` se');
        $this->db->join('`enquiry_purpose_masters` epm', 'epm.`id`= se.`enquiry_purpose_id`', 'left');
        $this->db->join('`students` s', 's.`id`= se.`student_id`', 'left');
        $this->db->where(array('isReplied'=>0)); 
        $this->db->order_by('enquiry_id', 'DESC'); 
        return $this->db->get('')->result_array();
    }

    function get_enquiry_data($enquiry_id){

        $this->db->select('fname,lname,mobile,email,country_code,UID,id,enquiry_no');
        $this->db->from('students');
        $this->db->join('`students_enquiry`', 'students_enquiry.`student_id`= students.`id`', 'left');
        $this->db->where('enquiry_id', $enquiry_id);
        return $this->db->get()->row_array();
    }

    function get_enquiry($enquiry_id){

        //return $this->db->get_where('students_enquiry',array('enquiry_id'=>$enquiry_id))->row_array();
        $this->db->select('
            se.`enquiry_id`,
            se.`enquiry_no`,
            s.`fname`,
            s.`lname`,
            s.`dob`,
            s.`email`,
            s.`is_email_verified` as is_otp_verified,
            s.`country_code`,
            s.`mobile`,
            se.`free_demo`,
            se.`isReplied`,
            se.`message`,
            se.`created`,
            tm.`test_module_name`,
            pgm.`programe_name`,
            cl.`center_name`,
            epm.`enquiry_purpose_name`,
            cnt.`name` as `country_name`,
        ');
        $this->db->from('`students_enquiry` se');
        $this->db->join('`enquiry_purpose_masters` epm', 'epm.`id`= se.`enquiry_purpose_id`', 'left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= se.`test_module_id`', 'left');
        $this->db->join('`programe_masters` pgm', 'pgm.`programe_id`= se.`programe_id`', 'left');
        $this->db->join('`country` cnt', 'cnt.country_id = se.country_id', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= se.`center_id`', 'left');
        $this->db->join('`students` s', 's.`id`= se.`student_id`', 'left');
        $this->db->where(array('enquiry_id'=> $enquiry_id)); 
        return $this->db->get('')->row_array();
    }    

    function get_std_enquiry($id){

        return $this->db->get_where('students_enquiry',array('student_id'=>$id))->result_array();
    }

    function get_preReplies($enquiry_id){

        return $this->db->get_where('students_enquiry_reply',array('enquiry_id'=>$enquiry_id))->result_array();
    }   

    function get_all_reply($enquiry_id){

        $this->db->select('
            se.message as student_query,
            date_format(se.created, "%D %b %y %I:%i %p") as sent_on,
            ser.admin_reply,
            date_format(ser.created, "%D %b %y %I:%i %p") as replied_on
        ');
        $this->db->from('`students_enquiry` se');       
        $this->db->join('`students_enquiry_reply` ser', 'se.`enquiry_id`= ser.`enquiry_id`', 'left');
        $this->db->where(array('se.enquiry_id'=>$enquiry_id));
        $this->db->order_by('ser.created', 'DESC');
        return $this->db->get('')->result_array();
    }    

    function get_std_inbox($id,$programe_id,$test_module_id){

        $this->db->select('
            se.message as student_query,
            date_format(se.created, "%D %b %y %I:%i %p") as sent_on,
            ser.admin_reply,
            date_format(ser.created, "%D %b %y %I:%i %p") as replied_on
        ');
        $this->db->from('`students_enquiry` se');       
        $this->db->join('`students_enquiry_reply` ser', 'se.`enquiry_id`= ser.`enquiry_id`', 'left');
        $this->db->where(array('se.student_id'=> $id,'se.programe_id'=> $programe_id,'se.test_module_id'=> $test_module_id));
        $this->db->order_by('ser.created', 'DESC');
        return $this->db->get('')->result_array();
    } 
    
    function add_reply($params)
    {
        $this->db->insert('students_enquiry_reply',$params);
        return $this->db->insert_id();
    }

    function add_enquiry($params)
    {        
        $this->db->insert('students_enquiry',$params);
        return $this->db->insert_id();        
    }
   

    function getOTP($enquiry_id){

        $this->db->select('students.OTP');
        $this->db->from('`students_enquiry`');
        $this->db->join('students', 'students_enquiry.`student_id`= students.`id`', 'inner');
        $this->db->where(array('enquiry_id'=> $enquiry_id));
        return $this->db->get('')->row_array();

    }

    function update_enquiry($enquiry_id,$params)
    {
       /*  $this->db->where('enquiry_id',$enquiry_id);
        $this->db->join('`student` ser', 'se.`enquiry_id`= ser.`enquiry_id`', 'left');
        return $this->db->update('students_enquiry',$params); */
       /*  $this->db->set('students.active',1);
        $this->db->set('students.is_otp_verified',1);
        $this->db->where('students_enquiry.enquiry_id',$enquiry_id);
      //  $this->db->join('`students_enquiry`', 'students_enquiry.`student_id`= students.`id`', 'inner');
        return $this->db->update("UPDATE `students` INNER JOIN students_enquiry ON `students_enquiry`.`student_id`=students.id SET students.`active` = 1, `is_otp_verified` = 1 WHERE `students_enquiry`.`enquiry_id` = '2';");  */
        if (DEFAULT_COUNTRY == 101) //india
        {
            return  $query = $this->db->query("UPDATE `students` INNER JOIN students_enquiry ON `students_enquiry`.`student_id`=students.id SET students.`active` = 1, `is_otp_verified` = 1 WHERE `students_enquiry`.`enquiry_id` = '$enquiry_id'");
        }
        else {
            return  $query = $this->db->query("UPDATE `students` INNER JOIN students_enquiry ON `students_enquiry`.`student_id`=students.id SET students.`active` = 1, `is_email_verified` = 1 WHERE `students_enquiry`.`enquiry_id` = '$enquiry_id'");
        }
       

    }

    function get_student_by_enqid($enquiry_id)
    {
        $this->db->select('student_id');
        $this->db->from('`students_enquiry`');      
        $this->db->where(array('enquiry_id'=> $enquiry_id));
        return $this->db->get('')->row_array();

    }
    function get_enquirydatabyid($id)
    {
    return $this->db->get_where('leads',array('lead_id'=>$id))->row_array();
    //print_r($this->db->last_query());exit;
    }

    function getWorkshopPageSettings() {
        $this->db->select("id,active");
        $this->db->from("workshop_page_settings");
        return $this->db->get('')->row_array();
    }

    function addWorkshopPageSetting($params) {
        $this->db->insert('workshop_page_settings',$params);
        return $this->db->insert_id();
    }

    function updateWorkshopPageSetting($params,$id) {
        $this->db->where('id',$id);
        return $this->db->update('workshop_page_settings',$params);
    }
}
