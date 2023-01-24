<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class  Attendance_model extends CI_Model{
    
    function __construct(){

        parent::__construct();
    }
    
    function add_attendance($params){

        $this->db->insert('student_attendance',$params);
        return $this->db->insert_id();
    }

    function get_attendance($student_id,$classroom_id,$sch_id,$date){ 

        $this->db->where(array('student_id'=>$student_id,'classroom_id'=>$classroom_id,'sch_id'=>$sch_id,'date'=>$date));
        $query = $this->db->get('student_attendance');
        return $query->num_rows();
    }
    
}
