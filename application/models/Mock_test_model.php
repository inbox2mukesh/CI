<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Mock_test_model extends CI_Model
{
    
    function __construct()
    {
        parent::__construct();
    }

    function getStudentPackageID($student_id,$booking_id){

        $this->db->select('student_package_id');
        $this->db->from('mock_test_booking');
        $this->db->where(array('student_id'=>$student_id,'booking_id'=>$booking_id));
        return $this->db->get()->row_array();
    }

    function get_ielts_report_count($id){

        $this->db->from('mock_test_report_ielts');
        $this->db->where(array('CSVgroupId'=>$id));
        return $this->db->count_all_results();
    }

    function get_pte_report_count($id){

        $this->db->from('mock_test_report_pte');
        $this->db->where(array('CSVgroupId'=>$id));
        return $this->db->count_all_results();
    }

    function get_toefl_report_count($id)
    {

        $this->db->from('mock_test_report_toefl');
        $this->db->where(array('CSVgroupId'=>$id));
        return $this->db->count_all_results();
    }

    function get_ielts_report($id, $params=array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('*');
        $this->db->where(array('CSVgroupId'=>$id));
        $this->db->from('`mock_test_report_ielts`');
        return $this->db->get('')->result_array();
    }

    function get_pte_report($id, $params=array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('*');
        $this->db->where(array('CSVgroupId'=>$id));
        $this->db->from('`mock_test_report_pte`');
        return $this->db->get('')->result_array();
    }

    function get_toefl_report($id, $params=array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('*');
        $this->db->where(array('CSVgroupId'=>$id));
        $this->db->from('`mock_test_report_toefl`');        
        return $this->db->get('')->result_array();
    }

    function getMtPackActiveCount($id){

        $this->db->from('mock_test_booking');
        $this->db->where(array('student_id'=>$id,'active'=>1));
        return $this->db->count_all_results();
    }

    function check_booking_duplicacy($mockity_test_id,$student_id,$programe_id_mt){

        $this->db->from('mock_test_booking');
        $this->db->where(array('mockity_test_id'=>$mockity_test_id,'student_id'=>$student_id,'programe_id_mt'=>$programe_id_mt));
        return $this->db->count_all_results();
    }

    function getAllRTUnique(){

        $this->db->distinct('');
        $this->db->select('rt.id,rt.title,rt.date');
        $this->db->from('mock_test_booking rtb');
        $this->db->join('mock_test_dates rt', 'rt.id = rtb.mockity_test_id', 'left');
        $this->db->order_by('rt.created', 'DESC');
        return $this->db->get()->result_array();
    }

    function get_all_booked_mt_count()
    {
        $this->db->from('mock_test_booking');
        return $this->db->count_all_results();
    }

    function get_all_booked_mt($mockity_test_id,$params = array())
    {
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
           
            rt.`title`,
            rt.`date`,        
            rtb.`time_slot`,
            rtb.`booking_id`,
            rtb.`pass_id`,
            s.`fname`,
            s.`lname`,
            s.`UID`,
            s.`country_code`,
            s.`mobile`,
            s.`email`,
            s.`is_otp_verified`,
            s.`active`
        ');
        $this->db->from('`mock_test_booking` rtb');
        $this->db->join('`mock_test_dates` rt', 'rtb.`mockity_test_id`= rt.`id`');
        $this->db->join('`students` s', 'rtb.`student_id`= s.`id`');       
        if($mockity_test_id>0){
            $this->db->where('rtb.mockity_test_id',$mockity_test_id);
        }else{
            
        }
        return $this->db->get('')->result_array();
    }

    function get_mt_booking($student_id)
    {
        
        $this->db->select('           
            rt.`title`,
            rt.`date`,        
            rtb.`time_slot`,
            rtb.`booking_id`,
            rtb.`pass_id`,
            s.`fname`,
            s.`lname`,
            s.`UID`,
            s.`country_code`,
            s.`mobile`,
            s.`email`,
            s.`is_otp_verified`,
            s.`active`
        ');
        $this->db->from('`mock_test_booking` rtb');
        $this->db->join('`mock_test_dates` rt', 'rtb.`mockity_test_id`= rt.`id`');
        $this->db->join('`students` s', 'rtb.`student_id`= s.`id`');       
        $this->db->where('rtb.student_id',$student_id);
        return $this->db->get('')->result_array();
    }

    function cancel_mt_booking($booking_id,$student_package_id,$amount_paid){

        $params1= array('active'=>0);
        $this->db->where('booking_id',$booking_id);
        $this->db->update('mock_test_booking',$params1);

        $params2= array('active'=>0,'amount_refund'=>$amount_paid,'amount_due'=>0);
        $this->db->where('student_package_id',$student_package_id);
        return $this->db->update('student_package',$params2);
    }

    function reactivate_mt_booking($booking_id){
        $params= array('active'=>1);
        $this->db->where('booking_id',$booking_id);
        return $this->db->update('mock_test_booking',$params);
    }

    function getMaxPassId($mockity_test_id){

        return $this->db->query('SELECT MAX(pass_id) AS `maxid` FROM `mock_test_booking` where `mockity_test_id`= '.$mockity_test_id.' ')->row()->maxid;
    }

    function get_mockity_test($id)
    {
        return $this->db->get_where('mock_test_dates',array('id'=>$id))->row_array();
    }

    function get_ieltsReport_row($id)
    {
        return $this->db->get_where('mock_test_report_ielts',array('id'=>$id))->row_array();
    }

    function get_pteReport_row($id)
    {
        return $this->db->get_where('mock_test_report_pte',array('id'=>$id))->row_array();
    }

    function get_toeflReport_row($id)
    {
        return $this->db->get_where('mock_test_report_toefl',array('id'=>$id))->row_array();
    }

    function get_mockityTest_list()
    { 
            $this->db->select('
                `id`,
                `title`, 
                `seats`,
                `date`,
                `venue`,
                `amount`
            ');
            $this->db->from('`mock_test_dates`'); 
            $this->db->where(array('active'=>1));       
            $this->db->order_by('`strdate` ASC');
            return $this->db->get('')->result_array();
            //print_r($this->db->last_query());exit;
    }

    function get_time_slot($id){ 

        $this->db->select('            
            `time_slot1`,
            `time_slot2`,
            `time_slot3`,
            `amount`
        ');
        $this->db->from('`mock_test_dates`');
        $this->db->where('id',$id);
        return $this->db->get('')->row_array();
    }

    function get_all_mt_report_ielts($UID){

        $this->db->select('
            rept.`id`,        
            rept.`Date_of_Test`, 
            rept.`Date_of_Report`,
            mst.title,          
            tm.`test_module_name`,
            pgm.`programe_name`
        ');
        $this->db->from('`mock_test_report_ielts` rept'); 
        $this->db->join('`mock_test_report_masters` mst', 'mst.`id`=rept.`CSVgroupId`');
        $this->db->join('`test_module` tm', 'mst.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'mst.`programe_id`=pgm.`programe_id`');
        $this->db->where('rept.Candidate_ID',$UID);
        $this->db->order_by('rept.`id` DESC');
        return $this->db->get('')->result_array();

    }

    function get_all_mt_report_pte($UID){

        $this->db->select('
            rept.`id`,        
            rept.`Date_of_Test`, 
            rept.`Date_of_Report`,
            mst.title,          
            tm.`test_module_name`,
            pgm.`programe_name`
        ');
        $this->db->from('`mock_test_report_pte` rept'); 
        $this->db->join('`mock_test_report_masters` mst', 'mst.`id`=rept.`CSVgroupId`');
        $this->db->join('`test_module` tm', 'mst.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'mst.`programe_id`=pgm.`programe_id`');
        $this->db->where('rept.Registration_ID',$UID);
        $this->db->order_by('rept.`id` DESC');
        return $this->db->get('')->result_array();

    }

    function get_all_mt_report_toefl($UID){

        $this->db->select('
            rept.`id`,        
            rept.`Date_of_Test`, 
            rept.`Date_of_Report`,
            mst.title,          
            tm.`test_module_name`,
            pgm.`programe_name`
        ');
        $this->db->from('`mock_test_report_toefl` rept'); 
        $this->db->join('`mock_test_report_masters` mst', 'mst.`id`=rept.`CSVgroupId`');
        $this->db->join('`test_module` tm', 'mst.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'mst.`programe_id`=pgm.`programe_id`');
        $this->db->where('rept.Registration_ID',$UID);
        $this->db->order_by('rept.`id` DESC');
        return $this->db->get('')->result_array();

    }

     function get_std_mt_report_data_ielts($UID){

        $this->db->select('
            `Test_Type`, 
            `Centre_Number`,
            `Candidate_Number`,        
            `Candidate_ID`, 
            `Date_of_Test`,
            `Date_of_Report`,
            `listening`, 
            `reading`,
            `writing`,        
            `speaking`, 
            `oa`,  
            `created`                  
        ');
        $this->db->from('`mock_test_report_ielts`');
        $this->db->where(array('Candidate_ID'=>$UID));
        return $this->db->get('')->result_array();
    }

    function get_std_mt_report_data_pte($UID){

        $this->db->select('
            `Test_Taker_ID`, 
            `Registration_ID`,
            `Test_Centre_ID`,        
            `Date_of_Test`, 
            `Date_of_Report`,
            `oa`,
            `listening`, 
            `reading`,
            `writing`,        
            `speaking`, 
            `gr`,
            `of`,
            `pr`,
            `sp`,
            `vo`,
            `wd`, 
            `created`                  
        ');
        $this->db->from('`mock_test_report_pte`');
        $this->db->where(array('Registration_ID'=>$UID));
        return $this->db->get('')->result_array();
    }

    function get_std_mt_report_data_toefl($UID){

        $this->db->select('
            `Test_Taker_ID`, 
            `Registration_ID`,
            `Test_Centre_ID`,        
            `Date_of_Test`, 
            `Date_of_Report`,
            `oa`,
            `listening`, 
            `reading`,
            `writing`,        
            `speaking`,
            `created`                  
        ');
        $this->db->from('`mock_test_report_toefl`');
        $this->db->where(array('Registration_ID'=>$UID));
        return $this->db->get('')->result_array();
    }

function get_mt_report_data_ielts($report_id,$UID){

    $this->db->select('

        rept.`Test_Type`, 
        rept.`Centre_Number`,
        rept.`Candidate_Number`,        
        rept.`Candidate_ID`, 
        rept.`Date_of_Test`,
        rept.Date_of_Report,
        rept.`listening`, 
        rept.`reading`,
        rept.`writing`,        
        rept.`speaking`, 
        rept.`oa`,
        s.`fname`,
        s.`lname`,
        s.`dob`,
        s.`profile_pic`,
        g.`gender_name`,
        cnt.`name` as country_name,        
    ');
    $this->db->from('`mock_test_report_ielts` rept');
    $this->db->join('`students` s', 's.`UID`=rept.`Candidate_ID`');
    $this->db->join('`country` cnt', 'cnt.`country_id`=s.`country_id`','left');
    $this->db->join('`gender` g', 'g.`id`=s.`gender`','left');
    $this->db->where(array('rept.id'=>$report_id,'rept.Candidate_ID'=>$UID));
    return $this->db->get('')->row_array();
}

function get_mt_report_data_pte($report_id,$UID){

    $this->db->select('

        rept.`Test_Taker_ID`, 
        rept.`Registration_ID`,
        rept.`Test_Centre_ID`,        
        rept.`Date_of_Test`, 
        rept.`Date_of_Report`,
        rept.oa,
        rept.`listening`, 
        rept.`reading`,
        rept.`writing`,        
        rept.`speaking`, 
        rept.`gr`,
        rept.`of`,
        rept.`pr`,
        rept.`sp`,
        rept.`vo`,
        rept.`wd`,
        s.`fname`,
        s.`lname`,
        s.`email`,
        s.`dob`,
        s.`profile_pic`,
        g.`gender_name`,
        cnt.`name` as country_name,        
    ');
    $this->db->from('`mock_test_report_pte` rept');
    $this->db->join('`students` s', 's.`UID`=rept.`Registration_ID`');
    $this->db->join('`country` cnt', 'cnt.`country_id`=s.`country_id`','left');
    $this->db->join('`gender` g', 'g.`id`=s.`gender`','left');
    $this->db->where(array('rept.id'=>$report_id,'rept.Registration_ID'=>$UID));
    return $this->db->get('')->row_array();
}

function get_mt_report_data_toefl($report_id,$UID){

    $this->db->select('

        rept.`Test_Taker_ID`, 
        rept.`Registration_ID`,
        rept.`Test_Centre_ID`,        
        rept.`Date_of_Test`, 
        rept.`Date_of_Report`,
        rept.oa,
        rept.`listening`, 
        rept.`reading`,
        rept.`writing`,        
        rept.`speaking`,
        s.`fname`,
        s.`lname`,
        s.`email`,
        s.`dob`,
        s.`profile_pic`,
        g.`gender_name`,
        cnt.`name` as country_name,        
    ');
    $this->db->from('`mock_test_report_toefl` rept');
    $this->db->join('`students` s', 's.`UID`=rept.`Registration_ID`');
    $this->db->join('`country` cnt', 'cnt.`country_id`=s.`country_id`','left');
    $this->db->join('`gender` g', 'g.`id`=s.`gender`','left');
    $this->db->where(array('rept.id'=>$report_id,'rept.Registration_ID'=>$UID));
    return $this->db->get('')->row_array();
}

    function saveCSV($params){

       $this->db->insert('mock_test_report_masters',$params);
       return $this->db->insert_id(); 
    }

    function saveCSVrecords_ielts($params){

        // $this->db->insert('mock_test_report_ielts',$params);
        $this->db->insert_batch('mock_test_report_ielts',$params);
        return $this->db->insert_id();
    }

    function saveCSVrecords_pte($params){

        $this->db->insert_batch('mock_test_report_pte',$params);
        return $this->db->insert_id();
    }

    function saveCSVrecords_toefl($params){

        $this->db->insert_batch('mock_test_report_toefl',$params);
        return $this->db->insert_id();
    }

    function get_all_mtcsv_count(){

        $this->db->from('mock_test_report_masters');        
        return $this->db->count_all_results();
    }

    function get_all_mt_csv($params){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            dc.`id`,
            dc.`test_module_id`, 
            dc.`title`,        
            dc.`active`,
            tm.`test_module_name`,
            pgm.`programe_name`
        ');
        $this->db->from('`mock_test_report_masters` dc');       
        $this->db->join('`test_module` tm', 'dc.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`=pgm.`programe_id`');
        $this->db->order_by('dc.`id` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }
    
    /*
     * Get mock_test by id
     */
    function get_mock_test($id)
    {
        return $this->db->get_where('mock_test_dates',array('id'=>$id))->row_array();
    }

     function get_mock_test_report($id)
    {
        return $this->db->get_where('mock_test_report_masters',array('id'=>$id))->row_array();
    }

    function get_all_testModule(){

        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('mock_test_dates rtd');
        $this->db->join('test_module tm', 'tm.test_module_id = rtd.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    /*
     * Get all schedules count IELTS
     */
    function get_all_mock_test_count($test_module_id)
    {
        $this->db->from('mock_test_dates');
        if($test_module_id>0){
           $this->db->where('test_module_id',$test_module_id); 
        }else{}
        return $this->db->count_all_results();
    }

    /*
     * Get all schedules count IELTS
     */
    function get_all_mock_test_count_inactive()
    {
        $this->db->from('mock_test_dates');
        $this->db->where('active',0);
        return $this->db->count_all_results();
    }   
     

    /*
     * Get all schedules 
     */
    function get_all_mock_test($test_module_id,$params = array())
    {   

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            dc.`id`, 
            dc.`title`,
            dc.`date`,
            dc.`strdate`,
            dc.`time_slot1`,
            dc.`time_slot2`,
            dc.`time_slot3`,
            dc.`seats`,
            dc.`venue`,
            dc.`amount`,           
            dc.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
        ');
        $this->db->from('`mock_test_dates` dc');
        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'dc.`test_module_id`=tm.`test_module_id`');        
        $this->db->join('`center_location` cl', 'cl.`center_id`=dc.`center_id`', 'left');
       if($test_module_id>0){
           $this->db->where('dc.test_module_id',$test_module_id); 
        }else{}
        $this->db->order_by('dc.`date` ASC, dc.`time_slot1` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }  
    
    /*
     * Get all RT
     */
    function get_all_mt()
    {        
        $this->db->select('
            dc.`id`, 
            dc.`title`, 
            dc.`date`,
            dc.`strdate`,
            dc.`time_slot1`,
            dc.`time_slot2`,
            dc.`time_slot3`,
            dc.`seats`,
            dc.`venue`,
            dc.`amount`,           
            dc.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
        ');
        $this->db->from('`mock_test_dates` dc');
        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'dc.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`=dc.`center_id`', 'left');
        $this->db->where(array('dc.active'=>1));
        $this->db->order_by('dc.`strdate` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all RT
     */
    function get_all_mt_short()
    {        
        $this->db->select('
            dc.`id`, 
            dc.`title`, 
            dc.`date`,
            dc.`strdate`,
            dc.`time_slot1`,
            dc.`time_slot2`,
            dc.`time_slot3`,
            dc.`seats`,
            dc.`venue`,
            dc.`amount`,           
            dc.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
        ');
        $this->db->from('`mock_test_dates` dc');
        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'dc.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`=dc.`center_id`', 'left');
        $this->db->where(array('dc.active'=>1));
        $this->db->order_by('dc.`strdate` ASC');
        $this->db->limit(6);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function get_booking_count($id){

        $this->db->from('mock_test_booking');        
        $this->db->where(array('mockity_test_id'=>$id,'active'=>1));
        return $this->db->count_all_results();        
    }

    /*
     * Get all schedules IELTS
     */
    function get_ielts_mt_short($params = array())
    {        
        $this->db->select('
            dc.`id`, 
            dc.`title`, 
            dc.`date`,
            dc.`strdate`,
            dc.`time_slot1`,
            dc.`time_slot2`,
            dc.`time_slot3`,
            dc.`seats`,
            dc.`venue`,
            dc.`amount`,           
            dc.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
        ');
        $this->db->from('`mock_test_dates` dc');
        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'dc.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`=dc.`center_id`', 'left');
        $this->db->where(array('dc.test_module_id'=>IELTS_ID, 'dc.active'=>1));
        $this->db->order_by('dc.`strdate` ASC');
        $this->db->limit(3);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

     /*
     * Get all schedules IELTS
     */
    function get_ielts_mt_long($params = array())
    {        
        $this->db->select('
            dc.`id`, 
            dc.`title`, 
            dc.`date`,
            dc.`strdate`,
            dc.`time_slot1`,
            dc.`time_slot2`,
            dc.`time_slot3`,
            dc.`seats`,
            dc.`venue`,
            dc.`amount`,           
            dc.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
        ');
        $this->db->from('`mock_test_dates` dc');
        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'dc.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`=dc.`center_id`', 'left');
        $this->db->where(array('dc.test_module_id'=>IELTS_ID, 'dc.active'=>1));
        $this->db->order_by('dc.`strdate` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all schedules CD IELTS
     */
    function get_cd_ielts_mt_short($params = array())
    {        
        $this->db->select('
            dc.`id`, 
            dc.`title`, 
            dc.`date`,
            dc.`strdate`,
            dc.`time_slot1`,
            dc.`time_slot2`,
            dc.`time_slot3`,
            dc.`seats`,
            dc.`venue`,
            dc.`amount`,           
            dc.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
        ');
        $this->db->from('`mock_test_dates` dc');
        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'dc.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`=dc.`center_id`', 'left');
        $this->db->where(array('dc.test_module_id'=>IELTS_CD_ID, 'dc.active'=>1));
        $this->db->order_by('dc.`strdate` ASC');
        $this->db->limit(3);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all schedules CD IELTS
     */
    function get_cd_ielts_mt_long($params = array())
    {        
        $this->db->select('
            dc.`id`, 
            dc.`title`, 
            dc.`date`,
            dc.`strdate`,
            dc.`time_slot1`,
            dc.`time_slot2`,
            dc.`time_slot3`,
            dc.`seats`,
            dc.`venue`,
            dc.`amount`,           
            dc.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
        ');
        $this->db->from('`mock_test_dates` dc');
        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'dc.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`=dc.`center_id`', 'left');
        $this->db->where(array('dc.test_module_id'=>IELTS_CD_ID, 'dc.active'=>1));
        $this->db->order_by('dc.`strdate` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all schedules IELTS
     */
    function get_pte_mt_short($params = array())
    {        
        $this->db->select('
            dc.`id`,  
            dc.`title`,
            dc.`date`,
            dc.`strdate`,
            dc.`time_slot1`,
            dc.`time_slot2`,
            dc.`time_slot3`,
            dc.`seats`,
            dc.`venue`,
            dc.`amount`,           
            dc.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
        ');
        $this->db->from('`mock_test_dates` dc');
        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'dc.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`=dc.`center_id`', 'left');
        $this->db->where(array('dc.test_module_id'=>PTE_ID, 'dc.active'=>1));
        $this->db->order_by('dc.`strdate` ASC');
        $this->db->limit(3);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

     /*
     * Get all schedules IELTS
     */
    function get_pte_mt_long($params = array())
    {        
        $this->db->select('
            dc.`id`,  
            dc.`title`,
            dc.`date`,
            dc.`strdate`,
            dc.`time_slot1`,
            dc.`time_slot2`,
            dc.`time_slot3`,
            dc.`seats`,
            dc.`venue`,
            dc.`amount`,           
            dc.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
        ');
        $this->db->from('`mock_test_dates` dc');
        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'dc.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`=dc.`center_id`', 'left');
        $this->db->where(array('dc.test_module_id'=>PTE_ID, 'dc.active'=>1));
        $this->db->order_by('dc.`strdate` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }


    /*
     * Get all schedules CD IELTS
     */
    function get_allEventDates_mt_short()
    {        
        $this->db->select('           
            CONCAT("book_mockity_test/index/", TO_BASE64(id) ) as `url`,
            `title`,            
            `date` as start,
        ');
        $this->db->from('`mock_test_dates');
        $this->db->where(array('active'=>1));
        $this->db->order_by('`strdate` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * function to add new schedule
     */
    function add_mock_test($params)
    {
        $this->db->insert('mock_test_dates',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update schedule
     */
    function update_mock_test($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('mock_test_dates',$params);
    }

    function update_ielts_reportRow($id,$params){

        $this->db->where('id',$id);
        return $this->db->update('mock_test_report_ielts',$params);
    }

    function update_pte_reportRow($id,$params){

        $this->db->where('id',$id);
        return $this->db->update('mock_test_report_pte',$params);
    }

    function update_toefl_reportRow($id,$params){

        $this->db->where('id',$id);
        return $this->db->update('mock_test_report_toefl',$params);
    }

    function update_mock_test_booking($booking_id,$params)
    {
        $this->db->where('booking_id',$booking_id);
        return $this->db->update('mock_test_booking',$params);
    }

    function deactivate_mock_test($todaystr){

        $params = array('active'=> 0);
         $this->db->where('`strdate` <= ',$todaystr);
        return $this->db->update('mock_test_dates',$params);
    }
    
    /*
     * function to delete schedule
     */
    function delete_mock_test($id)
    {
        return $this->db->delete('mock_test_dates',array('id'=>$id));
    }

    function delete_mock_test_report($id,$test_module_id)
    {
        $this->db->delete('mock_test_report_masters',array('id'=>$id));
        if($test_module_id==IELTS_ID or $test_module_id==IELTS_CD_ID){
            return $this->db->delete('mock_test_report_ielts',array('CSVgroupId'=>$id));
        }elseif($test_module_id==PTE_ID){
            return $this->db->delete('mock_test_report_pte',array('CSVgroupId'=>$id));
        }elseif($test_module_id==TOEFL_ID){
            return $this->db->delete('mock_test_report_toefl',array('CSVgroupId'=>$id));
        }else{
            return 0;
        }      
        
    }

    function search_mockty_test_schedule($params){

        $test_module_id = $params['test_module_id'];
        $programe_id = $params['programe_id'];
        $center_id = $params['center_id'];
        $from_date  = strtotime($params['from_date']);
        $to_date    = strtotime($params['to_date']);

        $this->db->select('
            dc.`id`, 
            dc.`title`, 
            dc.`date`,
            dc.`strdate`,
            dc.`time_slot1`,
            dc.`time_slot2`,
            dc.`time_slot3`,
            dc.`seats`,
            dc.`venue`,
            dc.`amount`,           
            dc.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
        ');
        $this->db->from('`mock_test_dates` dc');
        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'dc.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`=dc.`center_id`', 'left');
        if($test_module_id){
            $this->db->where('dc.test_module_id',$test_module_id);
        }else{
            //$this->db->where('dc.active',1);
            //$this->db->or_where('dc.active',0);
        }
        if($programe_id){
            $this->db->where('dc.programe_id',$programe_id);
        }else{
             //$this->db->where('dc.active',1);
             //$this->db->or_where('dc.active',0);
        }
        if($center_id){
            $this->db->where('dc.center_id',$center_id);
        }else{
             //$this->db->where('dc.active',1);
             //$this->db->or_where('dc.active',0);
        }
        
        $this->db->where('dc.`strdate` >= ',$from_date);
        $this->db->where('dc.`strdate` <= ',$to_date);
        $this->db->order_by('dc.`date` ASC, dc.`time_slot1` ASC');
        return $this->db->get('')->result_array();
    }

    /*
     * Get all schedules 
     */
    function get_mt_info($id)
    { 
        $this->db->select('
            dc.`id`, 
            dc.`title`,
            dc.`date`,
            dc.`strdate`,
            dc.`time_slot1`,
            dc.`time_slot2`,
            dc.`time_slot3`,
            dc.`seats`,
            dc.`venue`,
            dc.`amount`, 
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
        ');
        $this->db->from('`mock_test_dates` dc');
        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'dc.`test_module_id`= tm.`test_module_id`');        
        $this->db->join('`center_location` cl', 'cl.`center_id`= dc.`center_id`', 'left');
        $this->db->where('dc.id',$id);
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all schedules 
     */
    function get_mt_timeSlot_info($id)
    { 
        $this->db->select(' 
            `time_slot1`,
            `time_slot2`,
            `time_slot3`,
            `seats`
        ');
        $this->db->from('`mock_test_dates`');        
        $this->db->where('id',$id);
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }

    function get_mt_seats_availability($mockity_test_id,$time_slot){

        $this->db->from('mock_test_booking');
        $this->db->where(array('mockity_test_id'=>$mockity_test_id,'time_slot'=>$time_slot));
        return $this->db->count_all_results();
    }

    function getBookedRTDetails($booking_id,$student_id)
    {
        $this->db->select('
            s.fname,
            s.lname,
            s.UID,
            s.email,
            rt.`title`,
            rt.`date`,
            rt.`amount` as org_amount,
            date_format(rt.date, "%D %b %y") as `date2`,
            rtb.`time_slot`,
            rtb.`pass_id`,
            cl.`center_name`,
            date_format(rtb.created, "%D %b %y %I:%i %p") as `requested_on`           
        ');
        $this->db->from('`mock_test_booking` rtb');
        $this->db->join('`mock_test_dates` rt', 'rtb.`mockity_test_id`= rt.`id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= rt.`center_id`','left');
        $this->db->join('`students` s', 's.`id`= rtb.`student_id`');
        $this->db->where(array('rtb.booking_id'=>$booking_id, 'rtb.student_id'=>$student_id));
        return $this->db->get('')->row_array();
    }

    function get_student_booked_mt($id){
        
        $this->db->select('
            rt.`title`,
            rt.`date`,
            rt.`venue`,
            rt.`amount`,
            rtb.`student_package_id`,
            rtb.`booking_id`,           
            rtb.`time_slot`,
            rtb.`pass_id`,
            rtb.`active`,
            rtb.`created`,
            s.`id`,
            pgm.`programe_name`,            
        ');
        $this->db->from('`mock_test_booking` rtb');
        $this->db->join('`mock_test_dates` rt', 'rt.`id`= rtb.`mockity_test_id`');
        $this->db->join('`students` s', 'rtb.`student_id`= s.`id`');  
        $this->db->join('`programe_masters` pgm', 'pgm.`programe_id`= rtb.`programe_id_mt`');      
        $this->db->where(array('rtb.student_id'=>$id));
        $this->db->order_by('booking_id', 'DESC');
        return $this->db->get('')->result_array();
    }

    
    

    
}
