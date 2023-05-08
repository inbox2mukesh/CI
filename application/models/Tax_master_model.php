<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Vikrant
 *
 **/
class Tax_master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    /*
     * Get tax_master by id
     */
    function get_tax_master($id)
    {
        return $this->db->get_where('tax_master',array('id'=>$id))->row_array();
    }
    /*
     * Get all tax_master count
     */
    function get_all_tax_master_count()
    {
        $this->db->from('tax_master');
        return $this->db->count_all_results();
    }
    /*
     * Get all tax_master
     */
    function get_all_tax_master($params = array())
    {
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('T.*');
        $this->db->from('tax_master T'); 
        $this->db->order_by('T.`id`', 'DESC');
        return $this->db->get()->result_array();
    }
    
    function get_all_tax_active()
    {
        $this->db->select('T.`id`, T.`tax_name`');
        $this->db->from('test_master T');  
		$this->db->where('T.active', 1);
        $this->db->order_by('T.`tax_name`', 'ASC');
        return $this->db->get()->result_array();
    }

	function dupliacte_tax_master($id,$params){
        if($id>0){
            $this->db->where('id !=', $id);
        }
        $this->db->where(['tax_name'=> $params['tax_name'], 'tax_per'=> $params['tax_per']]);
        $query = $this->db->get('tax_master');
        $count_row = $query->num_rows();
        if ($count_row > 0) {          
            return 'DUPLICATE';
         } else {          
            return 'NOT DUPLICATE';
         }
    }
	
    function add_tax_master($params)
    {
        $this->db->insert('tax_master',$params);
        return $this->db->insert_id();
    }
   
    function update_tax_master($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('tax_master',$params);
    }
    
}
