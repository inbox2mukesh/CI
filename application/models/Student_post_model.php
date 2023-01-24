<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Student_post_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_studentpostUID($post_id)
    {
        $this->db->select('s.UID');
        $this->db->from('`student_class_posts_reply` pr');
        $this->db->join('`students` s', 's.`id`= pr.`by_student`');        
        $this->db->where('pr.post_id',$post_id);
        
        return $this->db->get('')->row_array();

    }
    function getPostReply($post_id){

        $this->db->select('*');
        $this->db->from('`student_class_posts_reply`');     
        $this->db->where(array('post_id'=>$post_id));
        $this->db->order_by('post_reply_id', 'DESC');
        return $this->db->get('')->result_array();
    }

    function getPostReplyAPI($post_id){

        $this->db->select('
            pr.post_reply_id,
            pr.post_reply_text,
            pr.post_reply_image,
            date_format(pr.created, "%D %b %y %I:%i %p") as created,
            u.fname as by_admin_fname,
            u.lname as by_admin_lname,
            u.employeeCode as by_admin_employeeCode,
            s.fname as by_student_fname,
            s.lname as by_student_lname,
            s.UID as by_UID,
        ');
        $this->db->from('`student_class_posts_reply` pr'); 
        $this->db->join('`user` u', 'u.`id`= pr.`by_user`', 'left'); 
        $this->db->join('`students` s', 's.`id`= pr.`by_student`', 'left');       
        $this->db->where(array('pr.post_id'=>$post_id));
        $this->db->order_by('pr.post_reply_id', 'DESC');
        return $this->db->get('')->result_array();
    }

    function add_student_post($params){

        $this->db->insert('student_class_posts',$params);
        return $this->db->insert_id();
    }

    function add_post_reply($params){

        $this->db->insert('student_class_posts_reply',$params);
        return $this->db->insert_id();
    } 

    function update_post($post_id,$params){

        $this->db->where('post_id',$post_id);
        return $this->db->update('student_class_posts',$params);

    }

    function getPost($post_id){

        $this->db->select('
            scp.post_id,
            scp.post_text,
            scp.post_image,
            date_format(scp.created, "%D %b %y %I:%i %p") as created,
            s.UID,
            s.country_code,
            s.fname,
            s.lname,
            s.email,
            s.mobile,
        ');
        $this->db->from('`student_class_posts` scp');  
        $this->db->join('`students` s', 's.`id`= scp.`student_id`');     
        $this->db->where(array('scp.post_id'=>$post_id));
        return $this->db->get('')->row_array();
    }

    function get_student_post($id,$classroom_id){

        $this->db->select('
            scp.post_id,
            scp.student_id,
            scp.post_text,
            scp.post_image,
            date_format(scp.created, "%D %b %y %I:%i %p") as created,            
            s.fname as by_student_fname,
            s.lname as by_student_lname,
            s.UID as by_UID,
        ');
        $this->db->from('`student_class_posts` scp');       
        $this->db->where(array('scp.classroom_id'=>$classroom_id,'scp.active'=>1));
        $this->db->join('`students` s', 's.`id`= scp.`student_id`', 'left');
        $this->db->order_by('scp.created', 'DESC');
        //$this->db->limit(5);
        return $this->db->get('')->result_array();
    }        


    function get_all_student_post_count($rawArr){
        
        $this->db->from('student_class_posts'); 
        if($classroom_id>0){
            $this->db->where('classroom_id', $classroom_id);  
        }else{
            if(!empty($rawArr)){                   
                $this->db->where_in('classroom_id', $rawArr);
            }else{
                $rawArr=[];                   
                $this->db->where_in('classroom_id', $rawArr);
            }  
        }   
        return $this->db->count_all_results();
        //print_r($this->db->last_query());exit;
    }

    function get_student_post_count($roleName,$userBranch,$userTest,$userPrograme,$userCategory,$userBatch,$student_id){   
        $this->db->from('student_class_posts scp'); 
        $this->db->join('`classroom` cr', 'cr.`id`= scp.`classroom_id`'); 
        $this->db->where(array('scp.active'=>1,'scp.student_id'=>$student_id));       
        if($roleName==ADMIN){            
                    
        }else{            

            if($userBranch){                   
                $this->db->where_in('cr.center_id', $userBranch);
            }else{
                $userBranch=0;                   
                $this->db->where_in('cr.center_id', $userBranch);
            } 

            if($userTest){                
                $this->db->where_in('cr.test_module_id', $userTest);
            }else{
            }

            if($userPrograme){                
                $this->db->where_in('cr.programe_id', $userPrograme);
            }else{
            }

            if($userCategory[0]=='ALL' or count($userCategory)>=4){ 
                
            }elseif(count($userCategory)<4 and count($userCategory)>0){
                $this->db->where_in('cr.category_name', $userCategory);
            }else{

            }

            if($userBatch){                
                $this->db->where_in('cr.batch_id', $userBatch);
            }else{
            }                                    
        }      
        return $this->db->count_all_results();
        //print_r($this->db->last_query());exit;
    }
    
    function get_all_student_post($rawArr,$params=array()){  

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            scp.post_id,
            scp.post_text,
            scp.post_image,
            scp.active,
            scp.isReplied,
            date_format(scp.created, "%D %b %y %I:%i %p") as created,
            s.id,
            s.UID,
            s.fname,
            s.lname,
            s.email,
            s.mobile,
            cr.classroom_name
        ');
        $this->db->from('`student_class_posts` scp');        
        $this->db->join('`students` s', 's.`id`= scp.`student_id`');
        $this->db->join('`classroom` cr', 'cr.`id`= scp.`classroom_id`');
        if(!empty($rawArr)){                   
            $this->db->where_in('scp.classroom_id', $rawArr);
        }else{
            $rawArr=[];                   
            $this->db->where_in('scp.classroom_id', $rawArr);
        }        
        $this->db->order_by('scp.post_id', 'desc');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function get_student_post_single($params=array(),$roleName,$userBranch,$userTest,$userPrograme,$userBatch,$student_id){  

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            scp.post_id,
            scp.post_text,
            scp.post_image,
            scp.active,
            date_format(scp.created, "%D %b %y %I:%i %p") as created,
            s.id,
            s.UID,
            s.fname,
            s.lname,
            s.email,
            s.mobile,
        ');
        $this->db->from('`student_class_posts` scp');        
        $this->db->join('`students` s', 's.`id`= scp.`student_id`');
        $this->db->where(array('scp.active'=>1,'scp.student_id'=>$student_id));        
        if($roleName==ADMIN){           

        }else{        

            if($userBranch){                
                $this->db->where_in('scp.center_id', $userBranch);
            }else{
                $userBranch=0;                
                $this->db->where_in('scp.center_id', $userBranch);
            }

            if($userTest){                
                $this->db->where_in('scp.test_module_id', $userTest);
            }else{
                $userTest=0;                
                $this->db->where_in('scp.test_module_id', $userTest);
            }

            if($userPrograme){                
                $this->db->where_in('scp.programe_id', $userPrograme);
            }else{
                $userPrograme=0;                
                $this->db->where_in('scp.programe_id', $userPrograme);
            }

            if($userBatch){                
                $this->db->where_in('scp.batch_id', $userBatch);
            }else{
                $userBatch=0;                
                $this->db->where_in('scp.batch_id', $userBatch);
            }
            
        }        
        $this->db->order_by('scp.post_id', 'desc');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all student posts
     */
    function get_student_post_admin($roleName,$userBranch,$userTest,$userPrograme,$userBatch,$student_id){         
        $this->db->select('
            scp.post_id,
            scp.post_text,
            scp.post_image,
            scp.active,
            date_format(scp.created, "%D %b %y %I:%i %p") as created,
            s.id,
            s.UID,
            s.fname,
            s.lname,
            s.email,
            s.mobile,
        ');
        $this->db->from('`student_class_posts` scp');        
        $this->db->join('`students` s', 's.`id`= scp.`student_id`');
        $this->db->where(array('scp.active'=>1,'scp.student_id'=>$student_id));        
        if($roleName==ADMIN){           

        }else{        

            if($userBranch){                
                $this->db->where_in('scp.center_id', $userBranch);
            }else{
                $userBranch=0;                
                $this->db->where_in('scp.center_id', $userBranch);
            }

            if($userTest){                
                $this->db->where_in('scp.test_module_id', $userTest);
            }else{
                $userTest=0;                
                $this->db->where_in('scp.test_module_id', $userTest);
            }

            if($userPrograme){                
                $this->db->where_in('scp.programe_id', $userPrograme);
            }else{
                $userPrograme=0;                
                $this->db->where_in('scp.programe_id', $userPrograme);
            }

            if($userBatch){                
                $this->db->where_in('scp.batch_id', $userBatch);
            }else{
                $userBatch=0;                
                $this->db->where_in('scp.batch_id', $userBatch);
            }
            
        }        
        $this->db->order_by('scp.post_id', 'desc');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    

    
}
