<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

class Test_module_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_course_name_duplicacy($test_module_name){

        $this->db->from('test_module');
        $this->db->where('test_module_name', $test_module_name);      
        return $this->db->count_all_results();
    }

    function check_course_name_duplicacy2($test_module_name,$test_module_id){
        
        $this->db->from('test_module');
        $this->db->where(array('test_module_name'=> $test_module_name,'test_module_id!='=>$test_module_id));      
        return $this->db->count_all_results();
    }    
    
    function get_test_module($test_module_id)
    {
        return $this->db->get_where('test_module',array('test_module_id'=>$test_module_id))->row_array();
    }

    function get_all_test_module_count()
    {
        $this->db->from('test_module');
        return $this->db->count_all_results();
    }        
    
    function get_all_test_module($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('tm.test_module_id,tm.test_module_name,tm.test_module_desc,tm.active');
        $this->db->from('test_module tm');
        $this->db->order_by('tm.modified', 'DESC');
        return $this->db->get()->result_array();
    }
    
    function get_all_package_test_module()
    {   
        $this->db->distinct('');
        $this->db->select('pkg.test_module_id,tm.test_module_name');
        $this->db->from('package_masters pkg');
        $this->db->where(array('pkg.active'=> 1, 'pkg.is_offline'=>0));
        $this->db->join('test_module tm', 'tm.test_module_id = pkg.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_all_exam_test_module()
    {   
        $this->db->distinct('');
        $this->db->select('evd.test_module_id,tm.test_module_name');
        $this->db->from('exam_venue_dates evd');
        $this->db->where(array('evd.active'=> 1));
        $this->db->join('test_module tm', 'tm.test_module_id = evd.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }
    
    function get_all_offline_package_test_module()
    {   
        $this->db->distinct('');
        $this->db->select('pkg.test_module_id,tm.test_module_name');
        $this->db->from('package_masters pkg');
        $this->db->where(array('pkg.active'=> 1, 'pkg.is_offline'=>1));
        $this->db->join('test_module tm', 'tm.test_module_id = pkg.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }
    
    function get_all_practice_test_module()
    {   
        $this->db->distinct('');
        $this->db->select('pkg.test_module_id,tm.test_module_name');
        $this->db->from('practice_package_masters pkg');
        $this->db->where('pkg.active', 1);
        $this->db->join('test_module tm', 'tm.test_module_id = pkg.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }
    
    function get_all_testimonials_test_module()
    {   
        $this->db->distinct('');
        $this->db->select('tsmt.test_module_id,tm.test_module_name');
        $this->db->from('student_testimonials tsmt');
        $this->db->where('tsmt.active', 1);
        $this->db->join('test_module tm', 'tm.test_module_id = tsmt.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }
    
    function get_all_rr_test_module()
    {   
        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('recent_results rr');
        $this->db->where('rr.active', 1);
        $this->db->join('test_module tm', 'tm.test_module_id = rr.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }
    
    function get_all_rt_test_module()
    {   
        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('real_test_dates rr');
        $this->db->where('rr.active', 1);
        $this->db->join('test_module tm', 'tm.test_module_id = rr.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_all_test_module_active(){       
        
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('test_module tm');    
        $this->db->where(array('tm.active'=> 1));  
        $this->db->order_by('test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function getAllCourse(){       
        
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('test_module tm');    
        $this->db->where(array('tm.active'=> 1));  
        $this->db->order_by('test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function getFunctionalCourses($user_id){

        $this->db->distinct('');
        $this->db->select('test_module_id');
        $this->db->from('trainer_access_list'); 
        $this->db->where('user_id', $user_id);
        return $this->db->get()->result_array();
    }

    function getFunctionalCoursesList($userCourseAccess){  

        $this->db->select('test_module_id,test_module_name');
        $this->db->from('test_module'); 
        if(!empty($userCourseAccess)){ 
            $this->db->where('active', 1);
            $this->db->where_in('test_module_id',$userCourseAccess);
        }else{
            $this->db->where('active', 1);
        } 
        $this->db->order_by('test_module_name', 'ASC');
        return $this->db->get()->result_array();        
    }

    function get_all_test_module_enqActive(){       
        
        $this->db->select('test_module_id,test_module_name');
        $this->db->from('test_module');    
        $this->db->where('active', 1);  
        $this->db->order_by('test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_course($programe_id){       
        
        $this->db->select('test_module_id,test_module_name');
        $this->db->from('test_module');    
        $this->db->where(array('active'=>1));  
        $this->db->order_by('test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function getTestName($test_module_id){       
        
        $this->db->select('test_module_name');
        $this->db->from('test_module');   
        $this->db->where(array('test_module_id'=>$test_module_id));
        return $this->db->get()->row_array();
    }        
    
    function add_test_module($params){
        
        $this->db->where('test_module_name', $params['test_module_name']);
        $query = $this->db->get('test_module');
        $count = $query->num_rows();
        if($count > 0) {          
            return 2;
        }else{          
            $this->db->insert('test_module',$params);
            $this->db->insert_id();
            return 1;
        }
    }

    function update_test_module($test_module_id,$params,$test_module_name_old){

        if($test_module_name_old==$params['test_module_name']){
            $this->db->where('test_module_id',$test_module_id);
            $this->db->update('test_module',$params);
            return 1;
        }else{            
            $this->db->where(array('test_module_name'=> $params['test_module_name']));
            $query = $this->db->get('test_module');
            $count_row = $query->num_rows();
            if($count_row > 0){          
                return 2;
            }else{
                $this->db->where('test_module_id',$test_module_id);
                $this->db->update('test_module',$params);
                return 1;
            }
        }
    }

    function delete_test_module($test_module_id){

        return $this->db->delete('test_module',array('test_module_id'=>$test_module_id));
    }
}
