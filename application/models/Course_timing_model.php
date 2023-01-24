<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

class Course_timing_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_course_timing_duplicacy($course_timing){

        $this->db->from('course_timing');
        $this->db->where('course_timing', $course_timing);      
        return $this->db->count_all_results();
    }

    function check_course_timing_duplicacy2($course_timing,$id){
        
        $this->db->from('course_timing');
        $this->db->where(array('course_timing'=>$course_timing,'id!='=>$id));
        return $this->db->count_all_results();
    }

    function get_course_timing($id)
    {
        return $this->db->get_where('course_timing',array('id'=>$id))->row_array();
    }
    
    function get_all_course_timing_count()
    {
        $this->db->from('course_timing');
        return $this->db->count_all_results();
    }

    function get_all_course_timing($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('*');
        $this->db->from('course_timing');
        $this->db->order_by('course_timing', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_all_course_timing_active(){       
        
        $this->db->select('id,course_timing');
        $this->db->from('course_timing');    
        $this->db->where('active', 1);  
        $this->db->order_by('course_timing', 'ASC');
        return $this->db->get()->result_array();
    } 

    function getcourse_timingName($id){       
        
        $this->db->select('course_timing');
        $this->db->from('course_timing');    
        $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }  
    
    function add_course_timing($params)
    {
        $this->db->where('course_timing', $params['course_timing']);
        $query = $this->db->get('course_timing');
        $count = $query->num_rows();
        if($count > 0) {          
            return 2;
        }else{          
            $this->db->insert('course_timing',$params);
            $this->db->insert_id();
            return 1;
        }      
    }
    
    function update_batch($id,$params,$course_timing_old)
    { 
        if($course_timing_old==$params['course_timing']){
            $this->db->where('id',$id);
            $this->db->update('course_timing',$params);
            return 1;
        }else{            
            $this->db->where(array('course_timing'=> $params['course_timing']));
            $query = $this->db->get('course_timing');
            $count_row = $query->num_rows();
            if($count_row > 0){          
                return 2;
            }else{
                $this->db->where('id',$id);
                $this->db->update('course_timing',$params);
                return 1;
            }
        }
    }    
    
    function delete_batch($id)
    {
        return $this->db->delete('course_timing',array('id'=>$id));
    }
}
