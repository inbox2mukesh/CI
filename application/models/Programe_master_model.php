<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 
class Programe_master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_programe_duplicacy($programe_name){

        $this->db->from('programe_masters');
        $this->db->where('programe_name', $programe_name);      
        return $this->db->count_all_results();
    }

    function check_programe_duplicacy2($programe_name,$programe_id){
        
        $this->db->from('programe_masters');
        $this->db->where(array('programe_name'=>$programe_name,'programe_id!='=>$programe_id));
        return $this->db->count_all_results();
    }

    function getTestPrograme($test_module_id){

        $this->db->distinct('');
        $this->db->select('pgm.`programe_id`, pgm.`programe_name`');
        $this->db->from('`category_masters` cat');  
        $this->db->join('programe_masters pgm', 'cat.programe_id = pgm.programe_id', 'INNER');
        $this->db->where(array('cat.test_module_id'=> $test_module_id,'cat.active'=>1));
        $this->db->order_by('pgm.programe_name', 'ASC');
        return $this->db->get('')->result_array();
        
    }

    function get_programe_master($programe_id)
    {
        return $this->db->get_where('programe_masters',array('programe_id'=>$programe_id))->row_array();
    }    
    
    function get_all_programe_masters_count()
    {
        $this->db->from('programe_masters');
        return $this->db->count_all_results();
    }        
    
    function get_all_programe_masters_active($params = array())
    {
        $this->db->where('active', '1');
        $this->db->order_by('programe_id', 'desc');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('programe_masters')->result_array();
    }

    function getFunctionalPrograme($roleName,$userPrograme)
    {
        $this->db->select('programe_id,programe_name');
        $this->db->from('programe_masters'); 
        if($roleName==ADMIN){
            $this->db->where('active', 1);
        }else{
            if(!empty($userPrograme)){
                $this->db->where('active', 1);
                $this->db->where_in('programe_id',$userPrograme);  
            }else{
                $this->db->where('active', 1);
            }
                      
        }
        return $this->db->get()->result_array();
    }

    function getPgm_forStudent()
    { 
        $this->db->where(array('active'=>1,'programe_id!='=>12));
        $this->db->order_by('programe_name', 'ASC');
        return $this->db->get('programe_masters')->result_array();
    }

    function get_all_programe_masters($params = array())
    {       
        $this->db->order_by('modified', 'DESC');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('programe_masters')->result_array();
    }

    function getProgram(){

        $this->db->select('`programe_id`, `programe_name`');
        $this->db->from('`programe_masters`');        
        $this->db->where(array('active'=> 1));
        $this->db->order_by('programe_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function getProgram_bc(){

        $this->db->select('`programe_id`, `programe_name`');
        $this->db->from('`programe_masters`');        
        $this->db->where(array('active'=> 1));
        $this->db->order_by('programe_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function getProgramName($programe_id){

        $this->db->select('`programe_name`');
        $this->db->from('`programe_masters`');        
        $this->db->where('programe_id', $programe_id);
        return $this->db->get('')->row_array();
    }        
    
    function add_programe_master($params)
    {  
        $this->db->where('programe_name', $params['programe_name']);
        $query = $this->db->get('programe_masters');
        $count = $query->num_rows();
        if($count > 0) {          
            return 2;
        }else{          
            $this->db->insert('programe_masters',$params);
            $this->db->insert_id();
            return 1;
        }       
    }    

    function update_programe_master($programe_id,$params,$programe_name_old){
        
        if($programe_name_old==$params['programe_name']){
            $this->db->where('programe_id',$programe_id);
            $this->db->update('programe_masters',$params);
            return 1;
        }else{            
            $this->db->where(array('programe_name'=> $params['programe_name']));
            $query = $this->db->get('programe_masters');
            $count_row = $query->num_rows();
            if($count_row > 0){          
                return 2;
            }else{
                $this->db->where('programe_id',$programe_id);
                $this->db->update('programe_masters',$params);
                return 1;
            }
        }        
    }
    
    function delete_programe_master($programe_id){
        //return 0;
        return $this->db->delete('programe_masters',array('programe_id'=>$programe_id));
    }
}
