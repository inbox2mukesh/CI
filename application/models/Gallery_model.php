<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Gallery_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get role by id
     */
    function get_gallery($id)
    {
        return $this->db->get_where('galleries',array('id'=>$id))->row_array();
    }
    
    /*
     * Get all roles count
     */
    function get_all_gallery_count()
    {
        $this->db->from('galleries');
        return $this->db->count_all_results();
    }

    function get_all_gallery_active()
    {
        $this->db->order_by('id', 'desc');  
        $this->db->where('active', 1);           
        return $this->db->get('galleries')->result_array();
    }
        
    /*
     * Get all roles
     */
    function get_all_gallery($params = array())
    {
        $this->db->order_by('id', 'desc');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('galleries')->result_array();
    }
    
    function add_gallery($params)
    {
        $this->db->insert('galleries',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update role
     */
    function update_gallery($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('galleries',$params);
    }
    
    /*
     * function to delete role
     */
    function delete_gallery($id)
    {
        return $this->db->delete('galleries',array('id'=>$id));
    }

     /*
     * function to update 
     */
    function update_one($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `active`=".$active." WHERE ".$pk." = ".$id." ");
        //print_r($this->db->last_query());exit;
    }

    function update_null($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `active`= 0 WHERE ".$pk." = ".$id." ");
        //print_r($this->db->last_query());exit;
    }

    /*
     * function to update 
     */
    function update_one_enq($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `enqActive`=".$active." WHERE ".$pk." = ".$id." ");
    }

    function update_null_enq($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `enqActive`= NULL WHERE ".$pk." = ".$id." ");
    }

    function update_one_hasAcademy($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `hasAcademy`=".$active." WHERE ".$pk." = ".$id." ");
    }

    function update_null_hasAcademy($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `hasAcademy`= NULL WHERE ".$pk." = ".$id." ");
    }

    function update_one_hasVISA($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `hasVISA`=".$active." WHERE ".$pk." = ".$id." ");
    }

    function update_null_hasVISA($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `hasVISA`= NULL WHERE ".$pk." = ".$id." ");
    }

    /*
     * function to update 
     */
    function update_one_is_team($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `is_team`=".$active." WHERE ".$pk." = ".$id." ");
        //print_r($this->db->last_query());exit;
    }

    function update_null_is_team($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `is_team`= NULL WHERE ".$pk." = ".$id." ");
        //print_r($this->db->last_query());exit;
    }

    /*
     * function to update 
     */
    function update_rf($id, $fresh, $table, $pk, $todaystr)
    {        
        if($fresh==0){
            $fresh=1;
        }else{
           $fresh=0; 
        }
        return $this->db->query("UPDATE ".$table." SET `fresh`=".$fresh." , `today`=".$todaystr." WHERE ".$pk." = ".$id." ");
    }

    
}
