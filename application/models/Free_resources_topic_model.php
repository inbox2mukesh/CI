<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 class Free_resources_topic_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_topic_duplicacy($topic){

        $this->db->from('free_resources_topic');
        $this->db->where('topic', $topic);      
        return $this->db->count_all_results();
    }

    function check_topic_duplicacy2($topic,$topic_id){
        
        $this->db->from('free_resources_topic');
        $this->db->where(array('topic'=>$topic,'topic_id!='=>$topic_id));
        return $this->db->count_all_results();
    }

    function get_topic($topic_id)
    {
        return $this->db->get_where('free_resources_topic',array('topic_id'=>$topic_id))->row_array();
    }
    
    function get_all_topic_count()
    {
        $this->db->from('free_resources_topic');
        return $this->db->count_all_results();
    }

    function get_all_topic($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('*');
        $this->db->from('free_resources_topic');
        $this->db->order_by('modified', 'DESC');
        return $this->db->get()->result_array();
    }

    function get_all_topic_active(){       
        
        $this->db->select('topic_id,topic');
        $this->db->from('free_resources_topic');    
        $this->db->where('active', 1);  
        $this->db->order_by('topic', 'ASC');
        return $this->db->get()->result_array();
    }     

    function getFunctionalBatch($userBatch){ 

        $this->db->select('batch_id,topic');
        $this->db->from('free_resources_topic'); 
            if(!empty($userBatch)){
                $this->db->where('active', 1);
                $this->db->where_in('batch_id',$userBatch); 
            }
        $this->db->order_by('topic', 'ASC');
        return $this->db->get()->result_array();
    }  

    function getBatchName($batch_id){       
        
        $this->db->select('topic');
        $this->db->from('free_resources_topic');    
        $this->db->where('batch_id', $batch_id);
        return $this->db->get()->row_array();
    }  
    
    function add_topic($params)
    {
        $this->db->where('topic', $params['topic']);
        $query = $this->db->get('free_resources_topic');
        $count = $query->num_rows();
        if($count > 0) {          
            return 2;
        }else{          
            $this->db->insert('free_resources_topic',$params);
            $this->db->insert_id();
            return 1;
        }      
    }
    
    function update_topic($topic_id,$params,$topic_old)
    { 
        if($topic_old==$params['topic']){
            $this->db->where('topic_id',$topic_id);
            $this->db->update('free_resources_topic',$params);
            return 1;
        }else{            
            $this->db->where(array('topic'=> $params['topic']));
            $query = $this->db->get('free_resources_topic');
            $count_row = $query->num_rows();
            if($count_row > 0){          
                return 2;
            }else{
                $this->db->where('topic_id',$topic_id);
                $this->db->update('free_resources_topic',$params);
                return 1;
            }
        }
    }
    
    function delete_batch($batch_id)
    {
        return $this->db->delete('free_resources_topic',array('batch_id'=>$batch_id));
    }
}
