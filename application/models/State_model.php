<?php

/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

class State_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getsearchStateCount($country, $status)
    {

        $query = '';
        if ($country != '') {
            $query .= " `country_id` = " . $country . " and ";
        }
        if ($status != '') {
            $query .= " `active` = " . $status . " and";
        }
        $x = $this->db->query('
                select 
                state_id
            from `state`
            where ' . $query . ' `state_id` > 0
            ');
        return $x->result_array();
    }

    function searchState($params = array(), $totalRowsCount = false)
    {
        $this->db->select('st.*,cnt.name');
        $this->db->from('`state` st');
        $this->db->join('`country` cnt', 'st.`country_id` = cnt.`country_id`');
        $this->db->where('st.`state_id` > 0');

        if (isset($params['limit']) && isset($params['offset']) && !$totalRowsCount) {
            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['search']) && !empty($params['search'])) {
            $this->db->where("(LOWER(st.state_name) LIKE '%$params[search]%' || LOWER(cnt.name) LIKE '%$params[search]%')");
        }

        if (isset($params['country_id']) && !empty($params['country_id'])) {
            $this->db->where(array('st.country_id' => $params['country_id']));
        }

        if (isset($params['status']) && $params['status'] != Null) {
            $this->db->where(array('st.active' => $params['status']));
        }

        if ($totalRowsCount == true) {
            return $this->db->count_all_results();
        } else {
            return $this->db->get('')->result_array();
        }
        //print_r($this->db->last_query());exit;        
    }

    function get_state($state_id)
    {
        return $this->db->get_where('state', array('state_id' => $state_id))->row_array();
    }

    function get_all_state_count()
    {
        $this->db->from('state');
        return $this->db->count_all_results();
    }

    function get_all_state($params = array())
    {
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('st.`state_id`,st.`state_name`,st.`active`, cnt.`name`');
        $this->db->from('state st');
        $this->db->join('`country` cnt', 'st.`country_id`=cnt.`country_id`');
        $this->db->order_by('cnt.`name`', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_all_state_active($params = array())
    {

        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('st.`state_id`,st.`state_name`,st.`active`, cnt.`name`');
        $this->db->from('state');
        $this->db->join('country', 'country.id = st.country_id', 'left');
        $this->db->where('st.active', 1);
        $this->db->order_by('state_id', 'desc');
        return $this->db->get()->result_array();
    }

    function get_all_state_by_country($country_id)
    {

        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('st.`state_id`,st.`state_name`');
        $this->db->from('state st');
        $this->db->join('country', 'country.country_id = st.country_id');
        $this->db->where('st.country_id', $country_id);
        return $this->db->get()->result_array();
    }

    function getStateName($state_id)
    {

        $this->db->select('state_name');
        $this->db->from('state');
        $this->db->where(array('state_id' => $state_id));
        return $this->db->get()->row_array();
    }

    function get_state_list($country_id)
    {

        $this->db->select('state_id,state_name');
        $this->db->from('state');
        $this->db->where(array('country_id' => $country_id, 'active' => 1));
        $this->db->order_by('state_name', 'desc');
        return $this->db->get()->result_array();
    }

    function get_state_list_with_country_name($country_id)
    {
        $this->db->select('st.state_id,CONCAT(st.state_name," - ",ct.name) as state_name');
        $this->db->from('state st');
        $this->db->join('country ct', 'ct.country_id = st.country_id');
        $this->db->where(array('st.country_id' => $country_id, 'st.active' => 1));
        $this->db->order_by('st.state_name', 'desc');
        return $this->db->get()->result_array();
    }

    function get_state_list_with_country_name_according_to_active_outhouse_location($country_id,$location_type=0)
    {
        $this->db->select('st.state_id,CONCAT(st.state_name," - ",ct.name) as state_name');
        $this->db->from('state st');
        $this->db->join('outhouse_locations ol', 'ol.state_id = st.state_id');
        $this->db->join('country ct', 'ct.country_id = st.country_id');
        if($location_type) {
            $this->db->join('outhouse_location_types  olt', 'olt.location_id = ol.id');
            $this->db->where('olt.location_type', $location_type);
        }
        $this->db->where(array('st.country_id' => $country_id, 'st.active' => 1, 'ol.active' => 1));
        $this->db->group_by('st.state_id');
        $this->db->order_by('st.state_name', 'desc');
        return $this->db->get()->result_array();
    }

    function add_state($params)
    {
        $state_name =  $params['state_name'];
        $country_id =  $params['country_id'];
        $this->db->where('state_name', $state_name);
        $this->db->where('country_id', $country_id);
        $query = $this->db->get('state');
        $count_row = $query->num_rows();
        if ($count_row > 0) {
            return FALSE;
        } else {

            $this->db->insert('state', $params);
            return $this->db->insert_id();
        }
    }

    function dupliacte_state($country_id, $state_name)
    {

        $this->db->where('state_name', $state_name);
        $this->db->where('country_id', $country_id);
        $query = $this->db->get('state');
        $count_row = $query->num_rows();
        if ($count_row > 0) {
            return 'DUPLICATE';
        } else {

            return 'NOT DUPLICATE';
        }
    }

    function update_state($state_id, $params)
    {
        $this->db->where('state_id', $state_id);
        return $this->db->update('state', $params);
    }

    function delete_state($state_id)
    {
        return $this->db->delete('state', array('state_id' => $state_id));
    }
}
