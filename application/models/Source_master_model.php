<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

class Source_master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_source_duplicacy($source_name,$source_id=null){

        $this->db->from('source_masters');
        $this->db->where('source_name', $source_name);
        if(!empty($source_id)){
			
			$this->db->where('id !=', $source_id); 
		}		
        return $this->db->count_all_results();
    }
	
    function get_source($id)
    {
        return $this->db->get_where('source_masters',array('id'=>$id))->row_array();
    }
    function get_source_om($source_id)
    {
        return $this->db->get_where('source_masters_om',array('source_id'=>$source_id))->result_array();
    }
	
    function get_all_source_count()
    {
        $this->db->from('source_masters');
        return $this->db->count_all_results();
    }

    function get_all_source($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('*');
        $this->db->from('source_masters');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result_array();
    }

    function get_all_source_active(){       
        
        $this->db->select('id,source_name');
        $this->db->from('source_masters');    
        $this->db->where('active', 1);  
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result_array();
    }

    function add_source($params)
    {
        $this->db->insert('source_masters',$params);
        return $this->db->insert_id();
    }
	function add_om($params)
    {
        $this->db->insert('source_masters_om',$params);
        return $this->db->insert_id();
    }
    function update_source($id,$params)
    {   
	    $this->db->where('id',$id);
	    if($this->db->update('source_masters',$params)){
			return $id;
		}else{
			return 0;
		}
    }

    function delete_source($id)
    {
        return $this->db->delete('source_masters',array('id'=>$id));
    }
	function delete_source_om($source_id)
    {
        return $this->db->delete('source_masters_om',array('source_id'=>$source_id));
    }
    
    /**
     * 
     * @param string $origin_type
     * @param string $origin
     * @param string $medium
     * @param array $ids
     * @return array
     */
    public function getOriginMediumSource(string $origin_type, string $origin, string $medium, array $ids = []) {
        if ($ids) {
            $this->db->where_not_in('sm.id', $ids);
        }
        return $this->db->select('sm.*')->from('source_masters sm')->join('source_masters_om smo', 'smo.source_id = sm.id')->where(['smo.origin_type' => $origin_type, 'smo.origin' => $origin, 'smo.medium' => $medium])->get()->result_array();
    }

}
