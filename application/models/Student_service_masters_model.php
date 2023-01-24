<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 
class Student_service_masters_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get live_lecture by service_id
     */
    function get_service_masters($service_id)
    {
        return $this->db->get_where('student_service_masters',array('service_id'=>$service_id))->row_array();
    }

    function get_serviceShortCode($service_id){

        $this->db->select('
            short_code,service_name
        ');
        $this->db->from('student_service_masters');
        $this->db->where('service_id',$service_id);
        return $this->db->get('')->row_array();
    }

     /*
     * Get all live_lectures ALL
     */
    function get_all_services()
    {  
        $this->db->select('
            service_id,service_name,short_code
        ');
        $this->db->from('`student_service_masters');
        $this->db->where('active',1);
        $this->db->order_by('service_name', 'DESC');
        return $this->db->get('')->result_array();
    }

    function get_all_services_for_addStd()
    {  
        $array=[2,3,7,14];
        $this->db->select('
            service_id,service_name,short_code
        ');
        $this->db->from('`student_service_masters');
        $this->db->where('active',1);
        $this->db->where_in('service_id', $array);
        $this->db->order_by('service_name', 'DESC');
        return $this->db->get('')->result_array();
    }

    function get_all_services_for_editStd()
    {  
        $array=[1,10,11,15];
        $this->db->select('
            service_id,service_name,short_code
        ');
        $this->db->from('`student_service_masters');
        $this->db->where('active',1);
        $this->db->where_not_in('service_id', $array);
        $this->db->order_by('service_name', 'DESC');
        return $this->db->get('')->result_array();
    }

    function get_all_services_for_addEnq()
    {  
        $array=[10];
        $this->db->select('
            service_id,service_name,short_code
        ');
        $this->db->from('`student_service_masters');
        $this->db->where('active',1);
        $this->db->where_in('service_id', $array);
        $this->db->order_by('service_name', 'DESC');
        return $this->db->get('')->result_array();
    }
    

   
}
