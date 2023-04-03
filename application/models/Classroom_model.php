<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class  Classroom_model extends CI_Model{
    function __construct(){

        parent::__construct();
    }

    function check_classroom_name_duplicacy($classroom_name){

        $this->db->from('classroom');
        $this->db->where('classroom_name', $classroom_name);      
        return $this->db->count_all_results();
    }

    function check_classroom_name_duplicacy2($classroom_name,$classroom_id){
        
        $this->db->from('classroom');
        $this->db->where(array('classroom_name'=> $classroom_name,'id!='=>$classroom_id));      
        return $this->db->count_all_results();
    }

    function show_classroom_desc($classroom_id){
        
        $this->db->select('cr.id,tm.test_module_name,pgm.programe_name,cr.category_id,b.batch_name');
        $this->db->from('classroom cr');
        $this->db->join('`test_module` tm', 'cr.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'cr.`programe_id`= pgm.`programe_id`');
        $this->db->join('`batch_master` b', 'b.`batch_id`= cr.`batch_id`');
        $this->db->where('cr.id', $classroom_id);
        return $this->db->get('')->row_array();
    }

    function loadClassroom($test_module_id,$programe_id,$category_id,$batch_id,$center_id,$userBranch){

        $this->db->select('cr.id,cr.classroom_name,cr.active,tm.test_module_name,pgm.programe_name,cr.category_id,b.batch_name,cl.center_name');
        $this->db->from('classroom cr');
        $this->db->join('`test_module` tm', 'cr.`test_module_id`=tm.`test_module_id`', 'left');
        $this->db->join('`programe_masters` pgm', 'cr.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`batch_master` b', 'b.`batch_id`= cr.`batch_id`', 'left');
        $this->db->join('center_location cl', 'cl.center_id = cr.center_id', 'left'); 
        if($test_module_id){
            $this->db->where('cr.test_module_id',$test_module_id);
        }else{ 

        }
        if($programe_id){
            $this->db->where('cr.programe_id',$programe_id);
        }else{ 

        }

        if($category_id){
            $this->db->where('cr.category_id',$category_id);
        }else{

        }
        
        if($batch_id){
            $this->db->where('cr.batch_id',$batch_id);
        }else{ 

        }
        if($center_id){
            $this->db->where('cr.center_id',$center_id);
        }else{ 
            if(!empty($userBranch)){
               $this->db->where_in('cr.center_id',$userBranch); 
            }            
        }
        return $this->db->get()->result_array();
        //print_r($this->db->last_query());exit;
    }

    function loadClassroom2($test_module_id,$programe_id,$category_id,$batch_id,$center_id,$userBranch){
        $this->db->select('cr.id,cr.classroom_name,cr.active,tm.test_module_name,pgm.programe_name,cr.category_id,b.batch_name,cl.center_name');
        $this->db->from('classroom cr');
        $this->db->join('`test_module` tm', 'cr.`test_module_id`=tm.`test_module_id`', 'left');
        $this->db->join('`programe_masters` pgm', 'cr.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`batch_master` b', 'b.`batch_id`= cr.`batch_id`', 'left');
        $this->db->join('center_location cl', 'cl.center_id = cr.center_id', 'left'); 
        if($test_module_id){
            $this->db->where('cr.test_module_id',$test_module_id);
        }else{ 

        }
        if($programe_id){
            $this->db->where('cr.programe_id',$programe_id);
        }else{ 

        }

        if($category_id){
            $this->db->where('cr.category_id',$category_id);
        }else{

        }
        
        if($batch_id){
            $this->db->where('cr.batch_id',$batch_id);
        }else{ 

        }
        if($center_id){
            $this->db->where('cr.center_id',$center_id);
        }else{ 
            if(!empty($userBranch)){
               $this->db->where_in('cr.center_id',$userBranch); 
            }            
        }
        return $this->db->get()->result_array();
        //print_r($this->db->last_query());exit;
    }

    function findClassroom($test_module_id,$programe_id,$category_id,$batch_id,$center_id){ 

        $this->db->select('id');
        $this->db->from('classroom');
        $this->db->where(array('test_module_id'=>$test_module_id,'programe_id'=>$programe_id,'category_id'=>$category_id,'batch_id'=>$batch_id,'center_id'=>$center_id));
        return $this->db->get()->row_array();
        //print_r($this->db->last_query());exit;
    }    
    
    function get_classroom($id){

        $this->db->select('*');
        $this->db->from('classroom');
        $this->db->where('id',$id); 
        return $this->db->get()->row_array();
    }

    function Get_classroom_data($id){

        $this->db->select('classroom_name');
        $this->db->from('classroom');
        $this->db->where('id',$id); 
        return $this->db->get()->row_array();
    }

    function get_all_classroom_active($classroom_id){

        $this->db->select('id,classroom_name');
        $this->db->from('classroom');
        if($classroom_id>0){
            $this->db->where(array('active'=>1,'id'=>$classroom_id));
        }else{
          $this->db->where('active',1);
        }         
        return $this->db->get()->result_array();
    }     

    function classroom_student_count($classroom_id){

        $this->db->from('students s');
        $this->db->join('`student_package` spkg', 'spkg.`student_id`= s.`id`');
        $this->db->where('spkg.classroom_id', $classroom_id);     
        return $this->db->count_all_results();
    }    

    function classroom_docs_count($classroom_id){

        $this->db->from('classroom_documents_class');
        $this->db->where('classroom_id', $classroom_id);      
        return $this->db->count_all_results();
    }

    function classroom_live_lectures_count($classroom_id){

        $this->db->from('live_lectures');
        $this->db->where('classroom_id', $classroom_id);      
        return $this->db->count_all_results();
    } 

    function classroom_post_count($classroom_id){

        $this->db->from('student_class_posts');
        $this->db->where('classroom_id', $classroom_id);      
        return $this->db->count_all_results();
    }

    function classroom_announcements_count($classroom_id){

        $this->db->from('announcements');
        $this->db->where('classroom_id', $classroom_id);      
        return $this->db->count_all_results();
    }

    function get_classroomID_by_access($test_module_id,$programe_id,$category_id,$batch_id,$center_id){

        $this->db->select('
            `id`,
        ');
        $this->db->from('`classroom`');
        $this->db->where(array('test_module_id'=> $test_module_id,'programe_id'=>$programe_id,'category_id'=>$category_id,'batch_id'=>$batch_id,'center_id'=>$center_id));
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }

    function get_classroom_by_access($test_module_id,$programe_id,$category_id,$batch_id,$center_id,$params = array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            cr.`id`, 
            cr.`classroom_name`,                                   
            cr.`active`,
            cr.`category_id`,
            tm.`test_module_name`,
            pgm.`programe_name`,
            b.`batch_name`,
            cl.center_name
        ');
        $this->db->from('`classroom` cr');
        $this->db->where(array('cr.test_module_id'=> $test_module_id,'cr.programe_id'=>$programe_id,'cr.category_id'=>$category_id,'cr.batch_id'=>$batch_id,'cr.center_id'=>$center_id));        
        $this->db->join('`test_module` tm', 'cr.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'cr.`programe_id`= pgm.`programe_id`');
        $this->db->join('`batch_master` b', 'b.`batch_id`= cr.`batch_id`');
        $this->db->join('center_location cl', 'cl.center_id = cr.center_id');               
        $this->db->order_by('cr.`id` DESC');
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }
    
    function get_all_classroom($roleName=null,$userBranch=[],$params = array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            cr.`id`, 
            cr.`classroom_name`,                                   
            cr.`active`,
            cr.`category_id`,
            tm.`test_module_name`,
            pgm.`programe_name`,
            b.`batch_name`,
            cl.center_name
        ');
        $this->db->from('`classroom` cr');        
        if($roleName==ADMIN){

        }else{            
            if($userBranch){                   
                $this->db->where_in('cr.center_id', $userBranch);
            }else{
                $userBranch=0;                   
                $this->db->where_in('cr.center_id', $userBranch);
            }
        }
        $this->db->join('`test_module` tm', 'cr.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'cr.`programe_id`= pgm.`programe_id`');
        $this->db->join('`batch_master` b', 'b.`batch_id`= cr.`batch_id`');
        $this->db->join('center_location cl', 'cl.center_id = cr.center_id');               
        $this->db->order_by('cr.`id` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function get_all_classroomID($roleName,$userBranch){
        
        $this->db->select('
            `id`,
        ');
        $this->db->from('`classroom`');        
        if($roleName==ADMIN){

        }else{            
            if($userBranch){                   
                $this->db->where_in('center_id', $userBranch);
            }else{
                $userBranch=0;                   
                $this->db->where_in('center_id', $userBranch);
            }
        }               
        $this->db->order_by('`id` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function classroomStudent($classroom_id,$params = array()){
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('s.id,s.student_identity,s.UID,s.fname,s.lname,s.dob,s.gender,s.profile_pic,s.active,g.`gender_name`');
        $this->db->from('`students` s'); 
        $this->db->join('`student_package` spkg', 'spkg.`student_id`= s.`id`');       
        $this->db->join('`gender` g', 'g.`id`= s.`gender`', 'left');
        $this->db->where('spkg.classroom_id', $classroom_id);                     
        $this->db->order_by('s.`id` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    } 
function classroomDocs($classroom_id,$params = array()){

        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
         $this->db->select('classroom_documents.id,classroom_documents.title,classroom_documents.total_section,classroom_documents.active,classroom.classroom_name ');
 		//$this->db->select('classroom_documents.*');
        $this->db->from('classroom_documents_class cdc');
		$this->db->order_by('cdc.id', 'desc');
		$this->db->where('cdc.classroom_id', $classroom_id);
		$this->db->join('classroom_documents', 'classroom_documents.id = cdc.classroom_documents_id');
		$this->db->join('classroom', 'classroom.id = cdc.classroom_id');
		$results=array();
        $classroom_documents =$this->db->get()->result_array();
         return $classroom_documents;
    } 
    function classroomLectures($classroom_id,$params = array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            ll.live_lecture_id, 
            ll.live_lecture_title,
            ll.video_url,
            ll.screenshot,
            ll.active,
            cr.`classroom_name`,
        ');
        $this->db->from('`live_lectures` ll');
        $this->db->join('`classroom` cr', 'cr.`id`= ll.`classroom_id`', 'left'); 
        $this->db->where('ll.classroom_id', $classroom_id);       
        $this->db->order_by('ll.live_lecture_id', 'DESC');
        return $this->db->get('')->result_array();
    }

    function ClassroomPost($classroom_id,$params = array()){

        $this->db->select('
            scp.post_id,
            scp.post_text,
            scp.post_image,
            scp.isReplied,
            scp.active,
            date_format(scp.created, "%D %b %y %I:%i %p") as created,
            cr.`classroom_name`,
            s.`UID`,
            s.`fname`,
            s.`lname`,
            s.`mobile`,
            s.`email`
        ');
        $this->db->from('`student_class_posts` scp'); 
        $this->db->join('`students` s', 's.`id`= scp.`student_id`');
        $this->db->join('`classroom` cr', 'cr.`id`= scp.`classroom_id`', 'left'); 
        $this->db->where('scp.classroom_id', $classroom_id);
        $this->db->order_by('scp.post_id', 'desc');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;

    }

    function classroomAnnouncements($classroom_id,$params){

        $this->db->select('
            anc.`id`,             
            anc.`subject`,
            anc.`body`,
            anc.`media_file`,
            date_format(anc.`modified`, "%D %b %y %I:%i %p") as created,
            anc.`active`,
            cr.classroom_name
        ');
        $this->db->from('`announcements` anc');
        $this->db->join('`classroom` cr', 'cr.`id`= anc.`classroom_id`', 'left');
        $this->db->where('anc.classroom_id', $classroom_id);
        $this->db->order_by('anc.modified', 'DESC');
        return $this->db->get('')->result_array();
    }

    function get_prev_category($id){

        $this->db->select('
            category_id
        ');
        $this->db->from('`classroom`');
        $this->db->where('id', $id);
        return $this->db->get('')->row_array();
    }

    function dupliacte_classroom($classroom_name,$test_module_id,$programe_id,$category_id,$batch_id,$center_id){

        /*$this->db->where(array('classroom_name'=>$classroom_name,'test_module_id'=> $test_module_id,'programe_id'=> $programe_id,'batch_id'=> $batch_id,'category_id'=>$category_id,'center_id'=>$center_id));*/
        $this->db->where(array('test_module_id'=> $test_module_id,'programe_id'=> $programe_id,'category_id'=>$category_id,'batch_id'=> $batch_id,'center_id'=>$center_id));      
        $query = $this->db->get('classroom');
        $count_row = $query->num_rows();
        if($count_row > 0) {          
            return 2;
        }else{ 
            return 1;
        }
    }

    function dupliacte_classroom2($classroom_name,$test_module_id,$programe_id,$category_id,$batch_id,$center_id){

        $this->db->where(array('test_module_id'=> $test_module_id,'programe_id'=> $programe_id,'category_id'=>$category_id,'batch_id'=> $batch_id,'center_id'=>$center_id));
        /*$this->db->or_where(array('test_module_id'=> $test_module_id,'programe_id'=> $programe_id,'batch_id'=> $batch_id,'category_id'=>$category_id,'center_id'=>$center_id)); */      
        $query = $this->db->get('classroom');
        $count_row = $query->num_rows();
        if($count_row > 0) {          
            return 2;
        }else{ 
            return 1;
        }
    }

    function add_classroom($params)
    {
        $this->db->insert('classroom',$params);
        return $this->db->insert_id();
    }

    function update_classroom($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('classroom',$params);
    } 
    
    function delete_classroom($id)
    {
        $this->db->delete('classroom',array('id'=>$id));
        return $this->db->delete('online_class_schedules',array('classroom_id'=>$id));
    }  
 function getContentTypeByClassroomDocumentsId($classroom_documents_id){
		
		
		$this->db->select('ctm.id,ctm.content_type_name,cdc.classroom_documents_id');
        $this->db->from('classroom_documents_content_type cdc');
        $this->db->join('content_type_masters ctm', 'ctm.id = cdc.content_type_id');
        $this->db->where(array('cdc.classroom_documents_id'=>$classroom_documents_id));
		$results=$this->db->get('')->result_array();
		return $results;
		
	}
	
    
}
