<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Photo_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_photo($id)
    {
        return $this->db->get_where('photo',array('id'=>$id))->row_array();
    }

    function get_all_photo_count()
    {
        $this->db->from('photo');
        return $this->db->count_all_results();
    }

    function get_all_photo_active_limit()
    {
        $this->db->select('
            `id`, 
            `image`,
            `active`,
            `created`
        ');
        $this->db->from('`photo`');
        $this->db->where('active',1);
        $this->db->order_by('`created` DESC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
    }

    function get_all_photo_active()
    {
        $this->db->select('
            `id`, 
            `image`,
            `active`,
            `created`
        ');
        $this->db->from('`photo`');
        $this->db->where('active',1);
        $this->db->order_by('`created` DESC');
        $this->db->limit(50);
        return $this->db->get('')->result_array();
    }

    function get_all_photo($params = array())
    {       
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            `id`, 
            `image`,
            `active`,
            `created`
        ');
        $this->db->from('`photo`');
        $this->db->order_by('`created` DESC');
        return $this->db->get('')->result_array();
    }    

    function add_photo($params)
    {
        $this->db->insert('photo',$params);
        return $this->db->insert_id();
    }

    function update_photo($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('photo',$params);
    }
    
    
    function delete_photo($id)
    {
        return $this->db->delete('photo',array('id'=>$id));
    }

    
    function update_one($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `active`=".$active." WHERE ".$pk." = ".$id." ");
        //print_r($this->db->last_query());exit;
    }

    function update_null($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `active`= NULL WHERE ".$pk." = ".$id." ");
        //print_r($this->db->last_query());exit;
    }

    
}
