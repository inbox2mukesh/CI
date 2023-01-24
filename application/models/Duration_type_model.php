<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 
class Duration_type_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_compalint_duration_type_duplicacy($duration_type){

        $this->db->from('duration_type');
        $this->db->where('duration_type', $duration_type);      
        return $this->db->count_all_results();
    }

    function check_compalint_duration_type_duplicacy2($duration_type,$duration_type_id){
        
        $this->db->from('duration_type');
        $this->db->where(array('duration_type'=>$duration_type,'id!='=>$duration_type_id));
        return $this->db->count_all_results();
    }

    function get_duration_type($id)
    {
        return $this->db->get_where('duration_type',array('id'=>$id))->row_array();
    }

    function get_all_duration_type_count()
    {
        $this->db->from('duration_type');       
        return $this->db->count_all_results();
    }

    function get_all_duration_type($params = array())
    {        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            id, 
            duration_type,
            active           
        ');
        $this->db->from('`duration_type`');       
        $this->db->order_by('id', 'desc');
        return $this->db->get('')->result_array();
    } 

    function get_all_duration_type_active()
    {  
        $this->db->select('
            id, 
            duration_type,  
        ');
        $this->db->from('`duration_type`');
        $this->db->where('active',1);       
        $this->db->order_by('duration_type', 'ASC');
        return $this->db->get('')->result_array();
    }
        
    
    function add_duration_type($params)
    {
        $this->db->where('duration_type', $params['duration_type']);
        $query = $this->db->get('duration_type');
        $count = $query->num_rows();
        if($count > 0) {          
            return 2;
        }else{          
            $this->db->insert('duration_type',$params);
            $this->db->insert_id();
            return 1;
        }
    }
    
    
    function update_duration_type($id,$params,$duration_type_old)
    {
        if($duration_type_old==$params['duration_type']){
            $this->db->where('id',$id);
            $this->db->update('duration_type',$params);
            return 1;
        }else{            
            $this->db->where(array('duration_type'=> $params['duration_type']));
            $query = $this->db->get('duration_type');
            $count_row = $query->num_rows();
            if($count_row > 0){          
                return 2;
            }else{
                $this->db->where('id',$id);
                $this->db->update('duration_type',$params);
                return 1;
            }
        }
    }
    
    function delete_duration_type($id)
    {
        return $this->db->delete('duration_type',array('id'=>$id));
    }

   
}
