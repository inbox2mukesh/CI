<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Harpreet
 *
 **/

 class Visa_banner_model extends CI_Model
{

    
    /****
     *  insert banner image
     */
    function insert_banner($params=null)
    {
        $this->db->insert('visa_banner',$params);
        return $this->db->insert_id();
    }
    function select_banner($limit=0)
    {
        $this->db->select('visa_banner.*,CONCAT(u.fname," ",u.lname) as username')
             ->from('visa_banner')
             ->join('user u','u.id=visa_banner.added_by');
             if($limit !=0)
             {
                $this->db->limit($limit);
             }
             $this->db->order_by('id', 'desc');
        return $this->db->get()->result_array();
    }
    function get_banner_by_id($id)
    {
        $this->db->select('banner_img')
             ->from('visa_banner')
             ->where('id',$id);
        return $this->db->get()->row();

    }
    function remove_banner($id)
    {
        return $this->db->delete('visa_banner',array('id'=>$id));
    }

}