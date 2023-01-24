<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Neelu
 *
 */
 class Content_type_masters_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
    }

    function check_content_type_duplicacy($content_type_name){

        $this->db->from('content_type_masters');
        $this->db->where('content_type_name', $content_type_name);      
        return $this->db->count_all_results();
    }

    function check_content_type_duplicacy2($content_type_name,$content_type_id){
        
        $this->db->from('content_type_masters');
        $this->db->where(array('content_type_name'=>$content_type_name,'id!='=>$content_type_id));
        return $this->db->count_all_results();
    }

    function Get_recorded_lecture_content_type($classroom_id){

        $this->db->distinct('');
        $this->db->select('ctm.id,ctm.content_type_name');
        $this->db->from('content_type_masters ctm');
        $this->db->join('`live_lectures` ll', 'll.`content_type_id`= ctm.`id`');    
        $this->db->where(array('ll.active'=> 1,'ll.classroom_id'=>$classroom_id));  
        $this->db->order_by('content_type_name', 'ASC');
        return $this->db->get()->result_array();
    }    
   
    function get_content_type($id)
    {
        return $this->db->get_where('content_type_masters',array('id'=>$id))->row_array();
    }

    function get_all_content_type_count()
    {
        $this->db->from('content_type_masters');
        return $this->db->count_all_results();
    }

    function get_all_content_type($params = array())
    {   
	
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
			
        }
        $this->db->select('*');
        $this->db->from('content_type_masters');
		$this->db->order_by('id', 'desc');
        return $this->db->get()->result_array();
    }
    function get_all_content_type_active(){       
        
        $this->db->select('id,content_type_name');
        $this->db->from('content_type_masters');    
        $this->db->where('active', 1);  
        $this->db->order_by('content_type_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function add_content_type($params)
    {
        $this->db->insert('content_type_masters',$params);
        return $this->db->insert_id();
    }

    function update_content_type($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('content_type_masters',$params);
    }
    
    function delete_content_type($id)
    {
        return $this->db->delete('content_type_masters',array('id'=>$id));
    }

   
}
