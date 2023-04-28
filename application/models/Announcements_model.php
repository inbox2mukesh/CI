<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 
class Announcements_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    
    function get_announcements($id)
    {
        return $this->db->get_where('announcements',array('id'=>$id))->row_array();
    }

    function get_student_announcement($classroom_id,$limit=null,$offset=null){
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->select('
            id,             
            subject,
            body,
            media_file,
            date_format(modified, "%D %b %Y %I:%i %p") as created,
        ');
        $currentdate = date('Y-m-d H:i:s');
        $this->db->from('`announcements`');
        $this->db->where(array('classroom_id'=>$classroom_id,'active'=>1,'start_date >='=>$currentdate));
        $this->db->order_by('modified', 'DESC');       
        return $this->db->get('')->result_array();

    }
    function get_student_announcement_count($classroom_id,$limit=null,$offset=null){
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->select('id');
        $this->db->from('`announcements`');
        $this->db->where(array('classroom_id'=>$classroom_id,'active'=>1));           
        return $this->db->get('')->num_rows();
    }

    function get_all_student_announcement($classroom_id){

        $this->db->select('
            id,             
            subject,
            body,
            media_file,
            date_format(modified, "%D %b %y %I:%i %p") as created,
        ');
        $this->db->from('`announcements`');
        $this->db->where(array('classroom_id'=>$classroom_id,'active'=>1));
        $this->db->order_by('modified', 'DESC');
        return $this->db->get('')->result_array();

    }

    function get_all_announcements_count($rawArr,$classroom_id=0){

        $this->db->from('announcements'); 
        if($classroom_id>0){
            $this->db->where('classroom_id', $classroom_id);  
        }else{
            if(!empty($rawArr)){                   
                $this->db->where_in('classroom_id', $rawArr);
            }else{
                $rawArr=[];                   
                //$this->db->where_in('classroom_id', $rawArr);
            }  
        }   
        return $this->db->count_all_results();
        //print_r($this->db->last_query());exit;        
    }

    function get_all_announcements($rawArr,$params = array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            anc.id, 
            anc.subject,
            anc.body,
            anc.media_file,
            anc.active,
            cr.classroom_name
        ');
        $this->db->from('`announcements` anc');
        $this->db->join('`classroom` cr', 'cr.`id`= anc.`classroom_id`');
        if(!empty($rawArr)){                   
            $this->db->where_in('anc.classroom_id', $rawArr);
        }else{
            $rawArr=[];                   
            //$this->db->where_in('anc.classroom_id', $rawArr);
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get('')->result_array();
    }   
        
    
    function add_announcements($params)
    {
        $this->db->insert('announcements',$params);
        return $this->db->insert_id();
    }
    
    
    function update_announcements($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('announcements',$params);
    }
    
   
    function delete_announcements($id)
    {
        return $this->db->delete('announcements',array('id'=>$id));
    }

   
}
