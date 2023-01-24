<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 class Course_type_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function check_course_type_duplicacy($batch_name){

        $this->db->from('course_timing');
        $this->db->where('course_timing', $batch_name);      
        return $this->db->count_all_results();
    }
    function check_course_type_duplicacy2($name,$id){
        
        $this->db->from('course_timing');
        $this->db->where(array('course_timing'=>$name,'id!='=>$id));
        return $this->db->count_all_results();
    }
    function get_course_type($id)
    {
        return $this->db->get_where('course_timing',array('id'=>$id))->row_array();
    }    
    function get_all_course_type_count()
    {
        $this->db->from('course_timing');
        return $this->db->count_all_results();
    }
    function get_all_course_type($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('*');
        $this->db->from('course_timing');
        $this->db->order_by('modified', 'DESC');
        return $this->db->get()->result_array();
    }
    function getBatchName($batch_id){       
        
        $this->db->select('batch_name');
        $this->db->from('batch_master');    
        $this->db->where('batch_id', $batch_id);
        return $this->db->get()->row_array();
    }      
    function add_course_type($params)
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
    function update_course_type($batch_id,$params,$batch_name_old)
    { 
        if($batch_name_old==$params['course_timing']){           
            $this->db->where('id',$batch_id);
            $this->db->update('course_timing',$params);
            return 1;
        }else{                     
            $this->db->where(array('course_timing'=> $params['course_timing']));
            $query = $this->db->get('course_timing');
            $count_row = $query->num_rows();
            if($count_row > 0){              
                return 2;
            }else{               
                $this->db->where('id',$batch_id);
                $this->db->update('course_timing',$params);               
                return 1;
            }
        }
    }     
}
