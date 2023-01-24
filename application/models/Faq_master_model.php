<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Faq_master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all_faq_filter($search_text){
        $this->db->select('fq.`id`,fq.`question`,fq.`answer`,tm.`test_module_name`');
        $this->db->from('faq_master fq');        
        $this->db->join('`test_module` tm', 'tm.`test_module_id`=fq.`test_module_id`');
        $this->db->where(array('fq.active'=>1));
        if($search_text)
        {
            $array = array('fq.`question`' => $search_text);
            $this->db->like($array);           
        }
        $this->db->order_by('fq.id', 'DESC');        
        return $this->db->get()->result_array();
    }
    
    function get_faq_master($id)
    {
        return $this->db->get_where('faq_master',array('id'=>$id))->row_array();
    }

    function get_all_testModule(){

        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('faq_master fq');
        $this->db->join('test_module tm', 'tm.test_module_id = fq.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    /*
     * Get all faq_master count
     */
    function get_all_faq_master_count()
    {
        $this->db->from('faq_master');
        /*if($test_module_id>0){
           $this->db->where('test_module_id',$test_module_id); 
        }else{} */
        return $this->db->count_all_results();
    }

    /*
     * Get all faq_master
     */
    function get_all_faq_master($params = array())
    {        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('fq.`id`,fq.`question`,fq.`answer`,fq.`active`');
        $this->db->from('faq_master fq');
        $this->db->order_by('fq.id', 'DESC');        
        /*$this->db->join('`test_module` tm', 'tm.`test_module_id`=fq.`test_module_id`');
        if($test_module_id>0){
            $this->db->where('fq.test_module_id',$test_module_id);
        }else{
            
        }*/
        return $this->db->get()->result_array();
    }

    function get_all_faq(){
        $this->db->select('fq.`id`,fq.`question`,fq.`answer`,tm.`test_module_name`');
        $this->db->from('faq_master fq');        
        $this->db->join('`test_module` tm', 'tm.`test_module_id`=fq.`test_module_id`');
        $this->db->where(array('fq.active'=>1));
        $this->db->order_by('fq.id', 'DESC');        
        return $this->db->get()->result_array();
    }
     
    /*
     * function to add new fqegory_master
     */
    function add_faq_master($params)
    {
        $this->db->insert('faq_master',$params);
        return $this->db->insert_id();         
    }
    
    /*
     * function to update fqegory_master
     */
    function update_faq_master($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('faq_master',$params);
    }
    
    /*
     * function to delete fqegory_master
     */
    function delete_faq_master($id)
    {
        return $this->db->delete('faq_master',array('id'=>$id));
    }
}
