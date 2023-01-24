<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

class Qualification_master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_qualification_name_duplicacy($qualification_name){

        $this->db->from('qualification_masters');
        $this->db->where('qualification_name', $qualification_name);      
        return $this->db->count_all_results();
    }

    function check_qualification_name_duplicacy2($qualification_name,$qualification_id){
        
        $this->db->from('qualification_masters');
        $this->db->where(array('qualification_name'=>$qualification_name,'id!='=>$qualification_id));
        return $this->db->count_all_results();
    }

    function get_qualification($id)
    {
        return $this->db->get_where('qualification_masters',array('id'=>$id))->row_array();
    }

    function get_all_qualification_count()
    {
        $this->db->from('qualification_masters');
        return $this->db->count_all_results();
    }

    function get_all_qualification($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('*');
        $this->db->from('qualification_masters');
        $this->db->order_by('qualification_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_all_qualification_active(){       
        
        $this->db->select('id,qualification_name');
        $this->db->from('qualification_masters');    
        $this->db->where('active', 1);  
        $this->db->order_by('qualification_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function add_qualification($params)
    {
        $this->db->from('qualification_masters');
        $this->db->where(array('qualification_name'=>$params['qualification_name']));
        $count = $this->db->count_all_results();        
        if($count>0){
            return 2;
        }else{
            $this->db->insert('qualification_masters',$params);
            $this->db->insert_id();
            return 1;
        }
    }

    function update_qualification($id,$params,$qualification_name_old)
    {
        if($qualification_name_old==$params['qualification_name']){
            $this->db->where('id',$id);
            $this->db->update('qualification_masters',$params);
            return 1;
        }else{            
            $this->db->where(array('qualification_name'=> $params['qualification_name']));
            $query = $this->db->get('qualification_masters');
            $count_row = $query->num_rows();
            if($count_row > 0){          
                return 2;
            }else{
                $this->db->where('id',$id);
                $this->db->update('qualification_masters',$params);
                return 1;
            }
        }
    }

    function delete_qualification($id)
    {
        return $this->db->delete('qualification_masters',array('id'=>$id));
    }
}
