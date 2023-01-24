<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 
class Classroom_post_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    
    function get_classroom_post($id)
    {
        return $this->db->get_where('classroom_post',array('id'=>$id))->row_array();
    }

    

    function get_all_classroom_post_count($rawArr){ 

        $this->db->from('classroom_post');        
            if(!empty($rawArr)){                   
                $this->db->where_in('classroom_id', $rawArr);
            }else{
                $rawArr=[];                   
                //$this->db->where_in('classroom_id', $rawArr);
            }          
        return $this->db->count_all_results();
        //print_r($this->db->last_query());exit;
    }

     
    function get_all_classroom_post($rawArr,$params = array()){ 

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            cp.id, 
            cp.subject,
            cp.body,
            cp.media_file,
            cp.active,
            cr.classroom_name
        ');   
        $this->db->from('`classroom_post` cp');
        $this->db->join('`classroom` cr', 'cr.`id`= cp.`classroom_id`');  
        
            if(!empty($rawArr)){                   
                $this->db->where_in('cp.classroom_id', $rawArr);
            }else{
                $rawArr=[];                   
                //$this->db->where_in('cp.classroom_id', $rawArr);
            }  
          
        $this->db->order_by('cp.id', 'DESC');
        return $this->db->get('')->result_array();
    }   
        
    
    function add_classroom_post($params)
    {
        $this->db->insert('classroom_post',$params);
        return $this->db->insert_id();
    }
    
    
    function update_classroom_post($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('classroom_post',$params);
    }
    
   
    function delete_classroom_post($id)
    {
        return $this->db->delete('classroom_post',array('id'=>$id));
    }

   
}
