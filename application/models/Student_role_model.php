<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 
class Student_role_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get student_role by role_id
     */
    function get_student_role($role_id)
    {
        return $this->db->get_where('student_role',array('role_id'=>$role_id))->row_array();
    }
    
    /*
     * Get all student_role count
     */
    function get_all_student_role_count()
    {
        $this->db->from('student_role');
        return $this->db->count_all_results();
    }
        
    /*
     * Get all student_role
     */
    function get_all_student_role($params = array())
    {
        $this->db->order_by('role_id', 'desc');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('student_role')->result_array();
    }
        
    /*
     * function to add new student_role
     */
    function add_student_role($params)
    {
        $this->db->insert('student_role',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update student_role
     */
    function update_student_role($role_id,$params)
    {
        $this->db->where('role_id',$role_id);
        return $this->db->update('student_role',$params);
    }
    
    /*
     * function to delete student_role
     */
    function delete_student_role($role_id)
    {
        return $this->db->delete('student_role',array('role_id'=>$role_id));
    }
}
