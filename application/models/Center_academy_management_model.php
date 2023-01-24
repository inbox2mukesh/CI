<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Neelu
 *
 **/
class Center_academy_management_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_center_academy_management_users($center_id)
    {  
		$this->db->select('u.id,u.employeeCode,u.fname,u.lname,uh.center_id');
        $this->db->from('center_academy_managements uh');
        $this->db->join('user u', 'u.id = uh.user_id','left');
        $this->db->where(array('uh.center_id'=>$center_id));
        return $this->db->get('')->result_array();
    }
}
