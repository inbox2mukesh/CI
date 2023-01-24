<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Category_master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_category_arr($prev_category){

        $this->db->select('`category_id`');   
        $this->db->from('category_masters');    
        $this->db->where_in('category_id',$prev_category);
        return $this->db->get()->result_array();
        //print_r($this->db->last_query());exit;
    }

    function get_category_master($category_id)
    {
        return $this->db->get_where('category_masters',array('category_id'=>$category_id))->row_array();
    }

    function get_all_testModule(){

        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('category_masters cat');
        $this->db->join('test_module tm', 'tm.test_module_id = cat.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function getProgramByCourse($test_module_id){

        $this->db->distinct('');
        $this->db->select('pgm.programe_id,pgm.programe_name');
        $this->db->from('category_masters cat');
        $this->db->where('cat.test_module_id',$test_module_id);
        $this->db->join('programe_masters pgm', 'pgm.programe_id = cat.programe_id');
        $this->db->order_by('pgm.programe_name', 'ASC');
        return $this->db->get()->result_array();
    }
    
    function get_all_category_masters_count($test_module_id)
    {
        $this->db->from('category_masters'); 
        if($test_module_id>0){
           $this->db->where('test_module_id',$test_module_id); 
        }else{}               
        return $this->db->count_all_results();
    }
    
    function get_all_category_masters($test_module_id,$params = array())
    {        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('cat.`category_id`,cat.`category_name`,cat.`active`, pgm.`programe_name`,tm.`test_module_name`');
        $this->db->from('category_masters cat');        
        $this->db->join('`test_module` tm', 'tm.`test_module_id`=cat.`test_module_id`'); 
        $this->db->join('`programe_masters` pgm', 'cat.`programe_id`=pgm.`programe_id`');
        if($test_module_id>0){
            $this->db->where('cat.test_module_id',$test_module_id);
        }else{
            
        }
        return $this->db->get()->result_array();
    }    

    function get_category_name($category_id){

        $this->db->select('category_name');
        $this->db->from('category_masters'); 
        $this->db->where('category_id', $category_id);      
        return $this->db->get()->row_array();
        //print_r($this->db->last_query());exit;
    }

    function get_category_id($category_name,$programe_id){

        $this->db->select('category_id,test_module_id');
        $this->db->from('category_masters'); 
        $this->db->where(array('category_name'=> $category_name,'programe_id'=>$programe_id));
        return $this->db->get()->row_array();
        //print_r($this->db->last_query());exit;
    }    

    function get_all_category_masters_active($params = array()){
       
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        } 
        $this->db->select('`category_id`,`category_name`,`programe_name`,tm.test_module_name');
        $this->db->from('category_masters');
        $this->db->join('programe_masters', 'programe_masters.programe_id = category_masters.programe_id', 'left');
        $this->db->join('test_module tm', 'tm.test_module_id = category_masters.test_module_id', 'left');
        $this->db->where('category_masters.active', 1);  
        $this->db->order_by('tm.test_module_name', 'DESC');
        return $this->db->get()->result_array();
    }          

    function get_category_forPack($test_module_id, $programe_id){ 
        
        $this->db->select('`cat.category_id`,`cat.category_name`, tm.`test_module_name`,pgm.`programe_name`');
        $this->db->from('category_masters cat');
        $this->db->join('test_module tm', 'tm.test_module_id = cat.test_module_id', 'left');
        $this->db->join('programe_masters pgm', 'pgm.programe_id = cat.programe_id', 'left');
        $this->db->where(array('cat.test_module_id'=>$test_module_id, 'cat.programe_id'=>$programe_id,'cat.active'=>1)); 
        $this->db->order_by('cat.category_id', 'desc');
        return $this->db->get()->result_array();
    }

    function get_category_forPackMulti($test_module_id, $programe_id){ 
        
        $this->db->select('`cat.category_id`,`cat.category_name`, tm.`test_module_name`,pgm.`programe_name`');
        $this->db->from('category_masters cat');
        $this->db->join('test_module tm', 'tm.test_module_id = cat.test_module_id', 'left');
        $this->db->join('programe_masters pgm', 'pgm.programe_id = cat.programe_id', 'left');
        $this->db->where_in(array('cat.test_module_id'=>$test_module_id, 'cat.programe_id'=>$programe_id,'cat.active'=>1));
        $this->db->order_by('cat.category_id', 'desc');
        return $this->db->get()->result_array();
    }
    
    function add_category_master($params)
    {
        $this->db->insert('category_masters',$params);
        return $this->db->insert_id();         
    }

    function dupliacte_category_master($test_module_id,$programe_id,$category_name){

        $this->db->where('category_name', $category_name);
        $this->db->where('programe_id', $programe_id);
        $this->db->where('test_module_id', $test_module_id);
        //$this->db->where('category_id!=', $category_id);
        $query = $this->db->get('category_masters');
        $count_row = $query->num_rows();
        if($count_row > 0) {          
            return 'DUPLICATE';
        }else{          
            return 'NOT DUPLICATE';
        }
    }

    function dupliacte_category_master2($test_module_id,$programe_id,$category_name,$category_id){

        $this->db->where('category_name', $category_name);
        $this->db->where('programe_id', $programe_id);
        $this->db->where('test_module_id', $test_module_id);
        $this->db->where('category_id!=', $category_id);
        $query = $this->db->get('category_masters');
        $count_row = $query->num_rows();
        if($count_row > 0) {          
            return 'DUPLICATE';
        }else{          
            return 'NOT DUPLICATE';
        }
    }

    function update_category_master($category_id,$params)
    {
        $this->db->where('category_id',$category_id);
        return $this->db->update('category_masters',$params);
    }    
    
    function delete_category_master($category_id)
    {
        //return 0;
        return $this->db->delete('category_masters',array('category_id'=>$category_id));
    }
    
    function getAllTestModuleList(){

        $this->db->distinct('');
        $this->db->select('cat.*');
        $this->db->from('category_masters cat');
        $this->db->order_by('cat.category_name', 'ASC');
		$this->db->group_by('cat.category_name');
		$this->db->where('cat.active',1);  
        return $this->db->get()->result_array();
    }
}
