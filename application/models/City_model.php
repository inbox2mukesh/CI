<?php

/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

class City_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getsearchCityCount($country, $state_id, $status)
    {

        $query = '';
        if ($country != '') {
            $query .= " `country_id` = " . $country . " and ";
        }
        if ($state_id != '') {
            $query .= " `state_id` = " . $state_id . " and ";
        }
        if ($status != '') {
            $query .= " `active` = " . $status . " and";
        }
        $x = $this->db->query('
                select 
                city_id
            from `city`
            where ' . $query . ' `city_id` > 0
            ');
        return $x->result_array();
    }

    function searchCity($params = array(), $totalRowsCount = false)
    {
        $this->db->select('ct.*,st.state_name,cnt.name');
        $this->db->from('`city` ct');
        $this->db->join('`country` cnt', 'cnt.`country_id` = ct.`country_id`');
        $this->db->join('`state` st', 'st.`state_id` = ct.`state_id`');
        $this->db->where('ct.`city_id` > 0');

        if (isset($params['limit']) && isset($params['offset']) && !$totalRowsCount) {
            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['search']) && !empty($params['search'])) {
            $this->db->where("(LOWER(ct.city_name) LIKE '%$params[search]%' || LOWER(st.state_name) LIKE '%$params[search]%' || LOWER(cnt.name) LIKE '%$params[search]%')");
        }

        if (isset($params['country_id']) && !empty($params['country_id'])) {
            $this->db->where(array('ct.country_id' => $params['country_id']));
        }

        if (isset($params['state_id']) && !empty($params['state_id'])) {
            $this->db->where(array('ct.state_id' => $params['state_id']));
        }

        if (isset($params['status']) && $params['status'] != Null) {
            $this->db->where(array('ct.active' => $params['status']));
        }

        if ($totalRowsCount == true) {
            return $this->db->count_all_results();
        } else {
            return $this->db->get('')->result_array();
        }
        //print_r($this->db->last_query());exit;        
    }

    function Get_all_rt_city()
    {

        $this->db->distinct('');
        $this->db->select('ct.city_id,ct.city_name');
        $this->db->from('city ct');
        $this->db->join('real_test_dates_seats rtds', 'rtds.city_id = ct.city_id');
        $this->db->order_by('ct.city_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function getCityName($city_id)
    {

        $this->db->select('city_name');
        $this->db->from('city');
        $this->db->where('city_id', $city_id);
        return $this->db->get()->row_array();
    }

    function getCityId($city_name)
    {

        $this->db->select('city_id');
        $this->db->from('city');
        $this->db->where('city_name', $city_name);
        return $this->db->get()->row_array();
    }

    function get_city($city_id)
    {
        return $this->db->get_where('city', array('city_id' => $city_id))->row_array();
    }

    /*
     * Get all city count
     */
    function get_all_city_count()
    {
        $this->db->from('city');
        return $this->db->count_all_results();
    }

    /*
     * Get all city
     */
    function get_all_city($params = array())
    {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('st.`state_id`,st.`state_name`,cnt.`name`,c.city_id,c.`city_name`,c.`state_id`,c.`country_id`,c.`active`');
        $this->db->from('city c');
        $this->db->join('`country` cnt', 'c.`country_id`=cnt.`country_id`', 'left');
        $this->db->join('`state` st', 'st.`state_id`=c.`state_id`');
        $this->db->order_by('cnt.`name`', 'ASC');
        return $this->db->get()->result_array();
    }


    function get_all_city_active($params = array())
    {

        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('st.`state_id`,st.`state_name`,cnt.`name`,c.city_id,c.`city_name`,c.`state_id`,c.`country_id`');
        $this->db->from('city c');
        $this->db->join('`country` cnt', 'st.`country_id`=cnt.`country_id`');
        $this->db->join('`state` st', 'st.`state_id`=c.`state_id`');
        $this->db->order_by('cnt.`name`', 'ASC');
        return $this->db->get()->result_array();
    }

    /*
     * function to add new city
     */
    function add_city($params)
    {

        $country_id =  $params['country_id'];
        $state_id =  $params['state_id'];
        $city_name =  $params['city_name'];
        $this->db->where('city_name', $city_name);
        $this->db->where('country_id', $country_id);
        $this->db->where('state_id', $state_id);
        $query = $this->db->get('city');
        $count_row = $query->num_rows();
        if ($count_row > 0) {
            return FALSE;
        } else {

            $this->db->insert('city', $params);
            return $this->db->insert_id();
        }
    }

    function update_city($city_id, $params)
    {
        $this->db->where('city_id', $city_id);
        return $this->db->update('city', $params);
    }

    function delete_city($city_id)
    {
        return $this->db->delete('city', array('city_id' => $city_id));
    }

    function get_city_list($state_id)
    {
        $this->db->select('city_id,city_name');
        $this->db->from('city');
        $this->db->where(array('state_id' => $state_id, 'active' => 1));
        $this->db->order_by('city_name', 'desc');
        return $this->db->get()->result_array();
    }

    function get_city_list_according_to_active_outhouse_location($state_id,$location_type=0)   
    {
        $this->db->select('ct.city_id,ct.city_name');
        $this->db->from('city ct');
        $this->db->join('outhouse_locations ol', 'ol.city_id = ct.city_id');
        if($location_type) {
            $this->db->join('outhouse_location_types  olt', 'olt.location_id = ol.id');
            $this->db->where('olt.location_type', $location_type);
        }
        $this->db->where(array('ct.state_id' => $state_id, 'ct.active' => 1, 'ol.active' => 1));
        $this->db->group_by('ct.city_id');
        $this->db->order_by('city_name', 'desc');
        return $this->db->get()->result_array();
    }
}