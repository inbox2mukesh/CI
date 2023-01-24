<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 class Other_contents_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    
    function get_contents($content_id)
    {
        return $this->db->get_where('other_contents',array('content_id'=>$content_id))->row_array();
    }

    function getContentsAPI($content_type){

    	$this->db->select('content_title,content_desc');
        $this->db->from('other_contents');    
        $this->db->where(array('active'=> 1,'content_type'=>$content_type));
        return $this->db->get()->row_array();
    }
    
    
    function get_all_contents_count()
    {
        $this->db->from('other_contents');
        return $this->db->count_all_results();
    }
        
   
    function get_all_contents($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('*');
        $this->db->from('other_contents');
        $this->db->order_by('content_id', 'DESC');
        return $this->db->get()->result_array();
    }

    function get_all_contents_active(){       
        
        $this->db->select('content_id,content_title,content_type');
        $this->db->from('other_contents');    
        $this->db->where('active', 1);  
        $this->db->order_by('content_title', 'ASC');
        return $this->db->get()->result_array();
    } 

      

    function getcontentsName($content_id){       
        
        $this->db->select('content_title');
        $this->db->from('other_contents');    
        $this->db->where('content_id', $content_id);
        return $this->db->get()->row_array();
    }    
        
    
    function add_contents($params)
    {
        $this->db->insert('other_contents',$params);
        return $this->db->insert_id();
    }
    
    
    function update_contents($content_id,$params)
    {
        $this->db->where('content_id',$content_id);
        return $this->db->update('other_contents',$params);
    }
    
    
    function delete_contents($content_id)
    {
        return $this->db->delete('other_contents',array('content_id'=>$content_id));
    }
}
