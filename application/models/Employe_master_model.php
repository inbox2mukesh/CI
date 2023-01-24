<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 class Employe_master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get our_employes by id
     */
    function get_employe($id)
    {
        return $this->db->get_where('our_employes',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all batch count
     */
    function get_all_employe_count()
    {
        $this->db->from('our_employes');
        return $this->db->count_all_results();
    }
        
    /*
     * Get all batch
     */
    function get_all_employe($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('e.*,d.designation_name,cl.center_name,g.gender_name');
        $this->db->from('our_employes e');
        $this->db->join('`center_location` cl', 'cl.`center_id`= e.`emp_branch`', 'left');
        $this->db->join('`designation_masters` d', 'd.`id`= e.`emp_designation`', 'left');
        $this->db->join('gender g', 'g.id = e.emp_gender','left');
        $this->db->order_by('e.id', 'desc');
        return $this->db->get()->result_array();
    }

    function get_all_employe_active(){       
        
        $this->db->select('id,employe_name');
        $this->db->from('our_employes');    
        $this->db->where('active', 1);  
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result_array();
    }

    function get_all_team(){

        $this->db->select('e.id,e.image,e.emp_name,d.designation_name,cl.center_name');
        $this->db->from('our_employes e');
        $this->db->join('`center_location` cl', 'cl.`center_id`= e.`emp_branch`', 'left');
        $this->db->join('`designation_masters` d', 'd.`id`= e.`emp_designation`', 'left');
        $this->db->where(array('e.is_team'=>1));
        $this->db->order_by('e.DOJ', 'DESC'); 
        return $this->db->get()->result_array();
    }    
        
    /*
     * function to add new our_employes
     */
    function add_employe($params)
    {
        $this->db->insert('our_employes',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update our_employes
     */
    function update_employe($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('our_employes',$params);
    }
    
    /*
     * function to delete our_employes
     */
    function delete_employe($id)
    {
        return $this->db->delete('our_employes',array('id'=>$id));
    }
}
