<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Rajan Bansal
 *
 **/
 
class Timezone_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getActiveTimeZoneList() {
        $this->db->from('timezone_masters');
        $this->db->where(array('active'=> 1));      
        return $this->db->get()->result_array();
    }

    function get_timezone_utc_by_country_id($countryId="") {
        $this->db->from('timezone_masters');
        $this->db->where(array('country_id'=> $countryId,'active' => 1));
        return $this->db->get()->result_array();
    }
    
    function get_timezone_by_timezone_id($timezoneId="") {
        $this->db->from('timezone_masters');
        $this->db->where(array('timezone_id'=> $timezoneId));
        return $this->db->get()->row_array();
    }
}
