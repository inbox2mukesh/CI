<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Neelu
 *
 */
 
 class Division_master_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function getDivisionName($division_id){       
        
        $this->db->select('division_name');
        $this->db->from('division_masters');    
        $this->db->where('id', $division_id);
        return $this->db->get()->row_array();
    }
    function getAllDivisionName($division_id){       
        
        $this->db->select('id,division_name');
        $this->db->from('division_masters');    
        $this->db->where_in('id', $division_id);
        $data=$this->db->get()->result_array();
		$dataNew=array();
		foreach($data as $val){
			
			$dataNew[$val['id']]=$val['division_name'];
		}
		return $dataNew;
    }
    function get_division($id)
    {
        return $this->db->get_where('division_masters',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all division count
     */
    function get_all_division_count()
    {
        $this->db->from('division_masters');
        return $this->db->count_all_results();
    }
        
    /*
     * Get all division
     */
    function get_all_division($params = array())
    {   
	
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);			
        }
        $this->db->select('*');
        $this->db->from('division_masters');
		$this->db->order_by('modified', 'DESC');
        return $this->db->get()->result_array();
    }

    function get_all_division_active(){       
        
        $this->db->select('id,division_name');
        $this->db->from('division_masters');    
        $this->db->where('active', 1);  
        $this->db->order_by('id', 'ASC');
        return $this->db->get()->result_array();
    }
    
    /*
     * function to add new division_masters
     */
    function add_division($params)
    {
        $this->db->from('division_masters');
        $this->db->where(array('division_name'=>  $params['division_name']));
        $count = $this->db->count_all_results();        
        if($count>0){
            return 'duplicate';
        }else{
            $this->db->insert('division_masters',$params);
            return $this->db->insert_id();
        }
    }    
    
    function update_division($id,$params,$division_name_old)
    { 
        if($division_name_old==$params['division_name']){
            $this->db->where('id',$id);
            $this->db->update('division_masters',$params);
            return 1;
        }else{            
            $this->db->where(array('division_name'=> $params['division_name']));
            $query = $this->db->get('division_masters');
            $count_row = $query->num_rows();
            if($count_row > 0){          
                return 2;
            }else{
                $this->db->where('id',$id);
                $this->db->update('division_masters',$params);
                return 1;
            }
        }
    }

    function delete_division($id)
    {
        return $this->db->delete('division_masters',array('id'=>$id));
    }
}
