<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Neelu
 *
 **/
class Center_division_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    /*
     * Get division by center_id
     */
    function get_center_divisions_ids($center_id)
    {  
		$data=$this->db->select('division_id')->get_where('center_divisions',array('center_id'=>$center_id))->result_array();
		$results=array();
	    foreach($data as $val){
		   
		   $results[]=$val['division_id'];
	    }
	    return $results;
	   
    }

    function getCenterDivisions($center_id){

        $this->db->select('dm.id,dm.division_name');
        $this->db->from('division_masters dm');
        $this->db->join('center_divisions cd', 'cd.division_id = dm.id','left');
        $this->db->where(array('cd.center_id'=>$center_id));
        return $this->db->get('')->result_array();
    }
}
