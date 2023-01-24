<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Navjeet
 *
 **/

 class Become_agent_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get enquiry_purpose_master by id
     */
    function get_enquiry_purpose($id)
    {
        return $this->db->get_where('enquiry_purpose_masters',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all enquiry_purpose count
     */
    function get_all_agent_count()
    {
        $this->db->from('agent_record');
        return $this->db->count_all_results();
    }
        
    /*
     * Get all enquiry_purpose
     */
    function get_all_agent($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('*');
        $this->db->from('agent_record');
        $this->db->order_by('agent_id', 'desc');
        return $this->db->get()->result_array();
    }

    function get_all_enquiry_purpose_active(){       
        
        $this->db->select('id,enquiry_purpose_name,image');
        $this->db->from('enquiry_purpose_masters');    
        $this->db->where('active', 1);  
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result_array();
    }    
        
    /*
     * function to add new enquiry_purpose_master
     */
    function booking_detail_save($params)
    {
        $this->db->insert('agent_record',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update enquiry_purpose_master
     */
    function update_enquiry_purpose($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('enquiry_purpose_masters',$params);
    }
    
    /*
     * function to delete enquiry_purpose_master
     */
    function delete_enquiry_purpose($id)
    {
        return $this->db->delete('enquiry_purpose_masters',array('id'=>$id));
    }
    
}
