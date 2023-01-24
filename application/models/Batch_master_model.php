<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 class Batch_master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_batch_duplicacy($batch_name){

        $this->db->from('batch_master');
        $this->db->where('batch_name', $batch_name);      
        return $this->db->count_all_results();
    }

    function check_batch_duplicacy2($batch_name,$batch_id){
        
        $this->db->from('batch_master');
        $this->db->where(array('batch_name'=>$batch_name,'batch_id!='=>$batch_id));
        return $this->db->count_all_results();
    }

    function get_batch($batch_id)
    {
        return $this->db->get_where('batch_master',array('batch_id'=>$batch_id))->row_array();
    }
    
    function get_all_batch_count()
    {
        $this->db->from('batch_master');
        return $this->db->count_all_results();
    }

    function get_all_batch($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('*');
        $this->db->from('batch_master');
        $this->db->order_by('modified', 'DESC');
        return $this->db->get()->result_array();
    }

    function get_all_batch_active(){       
        
        $this->db->select('batch_id,batch_name');
        $this->db->from('batch_master');    
        $this->db->where('active', 1);  
        $this->db->order_by('batch_name', 'ASC');
        return $this->db->get()->result_array();
    }     

    function getFunctionalBatch($userBatch){ 

        $this->db->select('batch_id,batch_name');
        $this->db->from('batch_master'); 
            if(!empty($userBatch)){
                $this->db->where('active', 1);
                $this->db->where_in('batch_id',$userBatch); 
            }
        $this->db->order_by('batch_name', 'ASC');
        return $this->db->get()->result_array();
    }  

    function getBatchName($batch_id){       
        
        $this->db->select('batch_name');
        $this->db->from('batch_master');    
        $this->db->where('batch_id', $batch_id);
        return $this->db->get()->row_array();
    }  
    
    function add_batch($params)
    {
        $this->db->where('batch_name', $params['batch_name']);
        $query = $this->db->get('batch_master');
        $count = $query->num_rows();
        if($count > 0) {          
            return 2;
        }else{          
            $this->db->insert('batch_master',$params);
            $this->db->insert_id();
            return 1;
        }      
    }
    
    function update_batch($batch_id,$params,$batch_name_old)
    { 
        if($batch_name_old==$params['batch_name']){
            $this->db->where('batch_id',$batch_id);
            $this->db->update('batch_master',$params);
            return 1;
        }else{            
            $this->db->where(array('batch_name'=> $params['batch_name']));
            $query = $this->db->get('batch_master');
            $count_row = $query->num_rows();
            if($count_row > 0){          
                return 2;
            }else{
                $this->db->where('batch_id',$batch_id);
                $this->db->update('batch_master',$params);
                return 1;
            }
        }
    }
    
    function delete_batch($batch_id)
    {
        return $this->db->delete('batch_master',array('batch_id'=>$batch_id));
    }
}
