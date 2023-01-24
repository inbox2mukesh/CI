<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 
class User_role_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function get_user_role($role_id)
    {
        return $this->db->get_where('user_role',array('role_id'=>$role_id))->row_array();
    }
    
    /*
     * Get all user_role count
     */
    function get_all_user_role_count()
    {
        $this->db->from('user_role');
        return $this->db->count_all_results();
    }

    function check_user_role($id)
    {
        $this->db->from('user_role');
        $this->db->where('user_id', $id);
        return $this->db->count_all_results();
    }

    function get_all_user_role($params = array())
    {
        $this->db->order_by('role_id', 'desc');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('u.fname,u.lname,u.email,r.id, r.name,ur.user_id, ur.role_id');
        $this->db->from('user_role ur');
        $this->db->join('user u','u.id=ur.user_id', 'left');
        $this->db->join('roles r','r.id=ur.role_id', 'left');
        return $this->db->get('')->result_array();
    }        
   
    function add_user_role($params)
    {
        $this->db->insert('user_role',$params);
        return $this->db->insert_id();
    }    
    
    function update_user_role($id,$params)
    {
        $this->db->where('user_id',$id);
        return $this->db->update('user_role',$params);
    }    
   
    function delete_user_role($role_id)
    {
        return $this->db->delete('user_role',array('role_id'=>$role_id));
    }
}
