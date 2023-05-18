<?php

class Error_log_detail_model extends CI_model{
    
    function __construct()
    {
        parent::__construct();
    }
    function insert_log($params)
    {
        $this->db->insert('error_log_detail', $params);
        return $this->db->insert_id();
    }
    function getlist($params)
    {
        if(!empty($params))
        {
            $this->db->like($params);
        }
        $this->db->order_by('id', 'desc');
        return $this->db->get('error_log_detail')->result_array();
    }
}