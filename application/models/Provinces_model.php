<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 
class Provinces_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    
    function get_provinces($id)
    {
        return $this->db->get_where('provinces',array('id'=>$id))->row_array();
    }

    function get_all_provinces_count(){

        $this->db->from('provinces');        
        return $this->db->count_all_results();
    }

    function get_all_provinces($params = array()){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            id, 
            province_name,
            active,
        ');
        $this->db->from('`provinces`'); 
        $this->db->order_by('`created` DESC');     
        return $this->db->get('')->result_array();
    }

    function getProvincesShort(){
        
        $this->db->select('
            id, 
            province_name,
            about,
            parent_image,
        ');
        $this->db->from('`provinces`'); 
        $this->db->where(array('active'=>1));
        $this->db->order_by('`province_name` ASC');     
        return $this->db->get('')->result_array();
    }

    function getProvincesLong($id){
        
        $this->db->select('
            id, 
            province_name,
            parent_image,            
            about,
            education,
            jobs,
            way_of_life,
        ');
        $this->db->from('`provinces`'); 
        $this->db->where(array('active'=>1,'id'=>$id)); 
        return $this->db->get('')->row_array();
    }

    function getprovincesImages($id){

        $this->db->select('image');
        $this->db->from('`provinces_images`'); 
        $this->db->where(array('province_id'=>$id));
        return $this->db->get('')->result_array();
    }
        
    
    function add_provinces($params)
    {
        $this->db->insert('provinces',$params);
        return $this->db->insert_id();
    }

    function add_provinces_image($params)
    {
		$this->db->insert('provinces_images',$params);
        return $this->db->insert_id();
    }
    
    
    function update_provinces($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('provinces',$params);
    }
    
   
    function delete_provinces($id)
    {
        return $this->db->delete('provinces',array('id'=>$id));
    }

    function delete_provinces_images($id){

        return $this->db->delete('provinces_images',array('province_id'=>$id));
    }

   
}
