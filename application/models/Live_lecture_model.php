<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/ 
class Live_lecture_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    function getRecordedLectures_filter($classroom_id,$contentType_id,$search_text,$startdate,$enddate,$limit=null,$offset=null){  
        
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->select(' ll.live_lecture_id,            
            ll.live_lecture_title,
            ll.screenshot,
            ll.video_url,
            ll.lecture_date as created,
            ctm.content_type_name
        ');
        $this->db->from('`live_lectures` ll');  
        $this->db->join('`content_type_masters` ctm', 'ctm.`id`= ll.`content_type_id`');
        $this->db->where(array('ll.classroom_id'=>$classroom_id,'ll.active'=>1));
         if($contentType_id){
            $this->db->where(array('ll.content_type_id'=>$contentType_id));            
        }else{ }
        if($search_text){
            $this->db->like('ll.live_lecture_title', $search_text);
        }
        if($startdate){
            $this->db->where(array('ll.lecture_strdate>='=>$startdate,'ll.lecture_strdate<='=>$enddate));            
        }
        $this->db->order_by('ll.created', 'DESC');
        //$this->db->limit(9);
        return $this->db->get('')->result_array();
    }

    function getRecordedLectures($classroom_id,$startdate,$enddate,$limit=null,$offset=null){
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->select('ll.live_lecture_id,           
            ll.live_lecture_title,
            ll.screenshot,
            ll.video_url,
            ll.lecture_date as created,
            ctm.content_type_name
        ');
        $this->db->from('`live_lectures` ll');  
        $this->db->join('`content_type_masters` ctm', 'ctm.`id`= ll.`content_type_id`');
        $this->db->where(array('ll.classroom_id'=>$classroom_id,'ll.active'=>1));
        if($startdate){
            $this->db->where(array('ll.lecture_strdate>='=>$startdate,'ll.lecture_strdate<='=>$enddate));            
        }
        $this->db->order_by('ll.created', 'DESC');
        // $this->db->limit(9);
        return $this->db->get('')->result_array();
    }
    function getRecordedLectures_count($classroom_id,$contentType_id,$search_text,$startdate,$enddate,$limit=null,$offset=null)
    {
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->select('             
            ll.live_lecture_id,
        ');
        $this->db->from('`live_lectures` ll');  
        $this->db->join('`content_type_masters` ctm', 'ctm.`id`= ll.`content_type_id`');
        $this->db->where(array('ll.classroom_id'=>$classroom_id,'ll.active'=>1));
        if($startdate){
            $this->db->where(array('ll.lecture_strdate>='=>$startdate,'ll.lecture_strdate<='=>$enddate));            
        }
        if($contentType_id){
            $this->db->where(array('ll.content_type_id'=>$contentType_id));            
        }else{ }
        if($search_text){
            $this->db->like('ll.live_lecture_title', $search_text);
        }
        $this->db->order_by('ll.created', 'DESC');
        // $this->db->limit(9);
        return $this->db->get('')->num_rows();
       // print_r($this->db->last_query());exit;
    }
    
   
    function get_live_lecture($live_lecture_id)
    {
        return $this->db->get_where('live_lectures',array('live_lecture_id'=>$live_lecture_id))->row_array();
    }

    function get_recorded_lectures_cat($test_module_id,$programe_id)
    {   
        $this->db->distinct('');
        $this->db->select('category_id,category_name');
        $this->db->from('category_masters');
        $this->db->where(array('test_module_id'=>$test_module_id,'programe_id'=>$programe_id));
        $this->db->order_by('category_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_recorded_lectures_cat_new($classroom_id)
    {        
        $this->db->select('test_module_id,programe_id');
        $this->db->from('classroom');
        $this->db->where(array('id'=>$classroom_id));
        return $this->db->get()->row_array();
    }

    function dupliacte_live_lecture_check($classroom_id,$video_url){

        $this->db->where(array('classroom_id'=> $classroom_id,'video_url'=> $video_url));        
        $query = $this->db->get('live_lectures');
        $count_row = $query->num_rows();
        if($count_row > 0) {          
            return 'NOT DUPLICATE';
        }else{ 
            return 'NOT DUPLICATE';
        }
    }

    function get_all_live_lectures_count($rawArr){

        $this->db->from('live_lectures'); 
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
     
    function get_all_live_lectures($rawArr,$params = array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            ll.live_lecture_id, 
            ll.live_lecture_title,
            ll.video_url,
            ll.screenshot,
            ll.lecture_date,
            ll.active,
            cr.`classroom_name`,
            ctm.`content_type_name`
        ');
        $this->db->from('`live_lectures` ll');
        $this->db->join('`classroom` cr', 'cr.`id`= ll.`classroom_id`', 'left');
        $this->db->join('`content_type_masters` ctm', 'ctm.`id`= ll.`content_type_id`', 'left');
        if(!empty($rawArr)){                   
            $this->db->where_in('ll.classroom_id', $rawArr);
        }else{
            $rawArr=[];                   
            //$this->db->where_in('ll.classroom_id', $rawArr);
        }                
        $this->db->order_by('ll.live_lecture_id', 'DESC');
        return $this->db->get('')->result_array();
    }    

    function get_liveLecture_cat($test_module_id,$programe_id){

        $this->db->select('cat.category_id, cat.`category_name`');
        $this->db->from('`category_masters` cat');        
        $this->db->join('`programe_masters` pgm', 'pgm.`programe_id`= cat.`programe_id`', 'left');
        $this->db->where(array('cat.programe_id'=> $programe_id, 'cat.active'=>1, 'cat.test_module_id'=> $test_module_id  ));
        $this->db->not_like('cat.category_name', 'ET1');
        $this->db->order_by('cat.modified','DESC');
        return $this->db->get('')->result_array();
    }    

    function get_liveLecture($category_id){       
        
        $this->db->select('ll.live_lecture_id, ll.live_lecture_title,ll.short_desc,ll.video_url,ll.screenshot');
        $this->db->from('`live_lectures` ll');
        $this->db->where(array('ll.category_id'=> $category_id,'ll.active'=>1));
        $this->db->order_by('live_lecture_id', 'desc');
        return $this->db->get('')->result_array();
    }    
        
    /*
     * function to add new live_lecture
     */
    function add_live_lecture($params)
    {
        $this->db->insert('live_lectures',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update live_lecture
     */
    function update_live_lecture($live_lecture_id,$params)
    {
        $this->db->where('live_lecture_id',$live_lecture_id);
        return $this->db->update('live_lectures',$params);
    }
    
    /*
     * function to delete live_lecture
     */
    function delete_live_lecture($live_lecture_id)
    {
        return $this->db->delete('live_lectures',array('live_lecture_id'=>$live_lecture_id));
    }

    
    function get_live_lectures_short_listening($classroom_id)
    {  
        $this->db->select('             
            live_lecture_title,
            video_url,
            date_format(created, "%D %b %y %I:%i %p") as created,
        ');
        $this->db->from('`live_lectures`');   
        $this->db->where(array('classroom_id'=>$classroom_id,'category_id'=>'Listening','active'=>1));
        $this->db->order_by('created', 'DESC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
    }

    function get_live_lectures_long_listening($classroom_id)
    {  
        $this->db->select('             
            live_lecture_title,
            video_url,
            date_format(created, "%D %b %y %I:%i %p") as created,
        ');
        $this->db->from('`live_lectures`');   
        $this->db->where(array('classroom_id'=>$classroom_id,'category_id'=>'Listening','active'=>1));
        $this->db->order_by('created', 'DESC');
        return $this->db->get('')->result_array();
    }

    function get_live_lectures_short_reading($classroom_id)
    {  
        $this->db->select('             
            live_lecture_title,
            video_url,
            date_format(created, "%D %b %y %I:%i %p") as created,
        ');
        $this->db->from('`live_lectures`');   
        $this->db->where(array('classroom_id'=>$classroom_id,'category_id'=>'Reading','active'=>1));
        $this->db->order_by('created', 'DESC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
    }

    function get_live_lectures_long_reading($classroom_id)
    {  
        $this->db->select('             
            live_lecture_title,
            video_url,
            date_format(created, "%D %b %y %I:%i %p") as created,
        ');
        $this->db->from('`live_lectures`');   
        $this->db->where(array('classroom_id'=>$classroom_id,'category_id'=>'Reading','active'=>1));
        $this->db->order_by('created', 'DESC');
        return $this->db->get('')->result_array();
    }

    function get_live_lectures_short_writing($classroom_id)
    {  
        $this->db->select('             
            live_lecture_title,
            video_url,
            date_format(created, "%D %b %y %I:%i %p") as created,
        ');
        $this->db->from('`live_lectures`');   
        $this->db->where(array('classroom_id'=>$classroom_id,'category_id'=>'Writing','active'=>1));
        $this->db->order_by('created', 'DESC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
    }

    function get_live_lectures_long_writing($classroom_id)
    {  
        $this->db->select('             
            live_lecture_title,
            video_url,
            date_format(created, "%D %b %y %I:%i %p") as created,
        ');
        $this->db->from('`live_lectures`');   
        $this->db->where(array('classroom_id'=>$classroom_id,'category_id'=>'Writing','active'=>1));
        $this->db->order_by('created', 'DESC');
        return $this->db->get('')->result_array();
    }

    function get_live_lectures_short_speaking($classroom_id)
    {  
        $this->db->select('             
            live_lecture_title,
            video_url,
            date_format(created, "%D %b %y %I:%i %p") as created,
        ');
        $this->db->from('`live_lectures`');   
        $this->db->where(array('classroom_id'=>$classroom_id,'category_id'=>'Speaking','active'=>1));
        $this->db->order_by('created', 'DESC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
    }

    function get_live_lectures_long_speaking($classroom_id)
    {  
        $this->db->select('             
            live_lecture_title,
            video_url,
            date_format(created, "%D %b %y %I:%i %p") as created,
        ');
        $this->db->from('`live_lectures`');   
        $this->db->where(array('classroom_id'=>$classroom_id,'category_id'=>'Speaking','active'=>1));
        $this->db->order_by('created', 'DESC');
        return $this->db->get('')->result_array();
    }
}
