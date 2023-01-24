<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

class Student_journey_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }    
    /*
     * Get role by id
     */
    function get_journey($id)
    {
        //return $this->db->get_where('student_journey',array('student_id'=>$id))->result_array();

        $this->db->select('
            sj.student_identity,
            sj.details,
            date_format(sj.created, "%D %b %y %I:%i %p") as created,
            date_format(sj.modified, "%D %b %y %I:%i %p") as modified,
            u.id,           
            u.fname as fnameu,
            u.lname as lnameu,
        ');
        $this->db->from('`student_journey` sj');      
        $this->db->join('`user` u', 'u.`id`= sj.`by_user`', 'left');        
        $this->db->where(array('sj.student_id'=>$id));     
        return $this->db->get('')->result_array();  
    }

    function update_studentJourney($params){

        /*$this->db->where('student_id', $params['student_id']);
        $this->db->where('student_identity', $params['student_identity']);
        $query = $this->db->get('student_journey');
        $count_row = $query->num_rows();
        if($count_row > 0) {          
            return 0;
        }else{          
            $this->db->insert('student_journey',$params);
            return $this->db->insert_id();
        }*/ 
        $this->db->insert('student_journey',$params);
        return $this->db->insert_id();       
    }
    

    

    
}
