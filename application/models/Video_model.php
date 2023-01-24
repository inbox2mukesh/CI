<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 
class Video_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get video by video_id
     */
    function get_video($video_id)
    {
        return $this->db->get_where('videos',array('video_id'=>$video_id))->row_array();
    }    


    function dupliacte_video_check($video_url){

        $this->db->where(array('classroom_id'=> $classroom_id,'video_url'=> $video_url));        
        $query = $this->db->get('videos');
        $count_row = $query->num_rows();
        if($count_row > 0) {          
            return 'NOT DUPLICATE';
        }else{ 
            return 'NOT DUPLICATE';
        }
    }

    function get_all_videos_count(){

        $this->db->from('videos ll');        
        return $this->db->count_all_results();
    }

     
    function get_all_videos($params = array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            video_id,
            video_url,
            active,
        ');
        $this->db->from('`videos`');               
        $this->db->order_by('video_id', 'DESC');
        return $this->db->get('')->result_array();
    } 

    function get_all_videos_active(){

        $this->db->select('
            video_id,
            video_url,
        ');
        $this->db->from('`videos`');  
        $this->db->where('active',1);             
        $this->db->order_by('video_id', 'DESC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
    }  
        
    /*
     * function to add new video
     */
    function add_video($params)
    {
        $this->db->insert('videos',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update video
     */
    function update_video($video_id,$params)
    {
        $this->db->where('video_id',$video_id);
        return $this->db->update('videos',$params);
    }
    
    /*
     * function to delete video
     */
    function delete_video($video_id)
    {
        return $this->db->delete('videos',array('video_id'=>$video_id));
    }

    
    
}
