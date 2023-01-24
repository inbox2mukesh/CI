<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 
class Gender_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    /*
     * Get gender by id
     */
    function get_gender($id)
    {
        return $this->db->get_where('gender',array('id'=>$id))->row_array();
    }
    /*
     * Get all gender count
     */
    function get_all_gender_count()
    {
        $this->db->from('gender');
        return $this->db->count_all_results();
    }  
    

    function get_all_gender_active()
    {
        $this->db->where('active', '1');
        $this->db->order_by('gender_name', 'ASC');
        return $this->db->get('gender')->result_array();
    }

    function getGenderById($id)
    {
        $this->db->select('gender_name');
        $this->db->where(array('id'=> $id,'active'=>1));
        return $this->db->get('gender')->row_array();
    }

    function get_all_gender()
    {
        $this->db->select('id,gender_name,active');
        $this->db->from('gender');
        $this->db->order_by('gender_name', 'ASC');        
        return $this->db->get('')->result_array();
    }
    /*
     * function to add new gender
     */
    function add_gender($params)
    {
        $this->db->insert('gender',$params);
        return $this->db->insert_id();
    }    
    /*
     * function to update gender
     */
    function update_gender($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('gender',$params);
    } 
    /*
     * function to delete gender
     */
    function delete_gender($id)
    {
        return $this->db->delete('gender',array('id'=>$id));
    }

    
}
