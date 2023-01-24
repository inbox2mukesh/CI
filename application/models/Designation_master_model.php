<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 class Designation_master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_compalint_subject_duplicacy($designation_name){

        $this->db->from('designation_masters');
        $this->db->where('designation_name', $designation_name);      
        return $this->db->count_all_results();
    }

    function check_compalint_subject_duplicacy2($designation_name,$designation_id){
        
        $this->db->from('designation_masters');
        $this->db->where(array('designation_name'=>$designation_name,'id!='=>$designation_id));
        return $this->db->count_all_results();
    }

    function get_designation($id)
    {
        return $this->db->get_where('designation_masters',array('id'=>$id))->row_array();
    }
    
    function get_all_designation_count()
    {
        $this->db->from('designation_masters');
        return $this->db->count_all_results();
    }

    function get_all_designation($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('*');
        $this->db->from('designation_masters');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result_array();
    }

    function get_all_designation_active(){       
        
        $this->db->select('id,designation_name');
        $this->db->from('designation_masters');    
        $this->db->where('active', 1);  
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result_array();
    }

    function add_designation($params)
    {
        $this->db->where('designation_name', $params['designation_name']);
        $query = $this->db->get('designation_masters');
        $count = $query->num_rows();
        if($count > 0) {          
            return 2;
        }else{          
            $this->db->insert('designation_masters',$params);
            $this->db->insert_id();
            return 1;
        }
    }

    function update_designation($id,$params,$designation_name_old)
    {
        if($designation_name_old==$params['designation_name']){
            $this->db->where('id',$id);
            $this->db->update('designation_masters',$params);
            return 1;
        }else{            
            $this->db->where(array('designation_name'=> $params['designation_name']));
            $query = $this->db->get('designation_masters');
            $count_row = $query->num_rows();
            if($count_row > 0){          
                return 2;
            }else{
                $this->db->where('id',$id);
                $this->db->update('designation_masters',$params);
                return 1;
            }
        }
    }

    function delete_designation($id)
    {
        return $this->db->delete('designation_masters',array('id'=>$id));
    }
}
