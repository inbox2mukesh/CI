<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Marketing_popups_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function deactivate_popup($todaystr){
        
        $params = array('active'=> 0);
        $this->db->where('startDateStr>',$todaystr);
        $this->db->or_where('endDateStr<=',$todaystr);
        return $this->db->update('marketing_popups',$params);
    }

    function activate_popup($todaystr){
        
        $params = array('active'=> 1);
        $this->db->where(array('startDateStr'=>$todaystr));
        return $this->db->update('marketing_popups',$params);
    }
    
    function get_marketing_popups($id)
    {
        return $this->db->get_where('marketing_popups',array('id'=>$id))->row_array();
    }
    
    
    function get_all_marketing_popups_count()
    {
        $this->db->from('marketing_popups');
        return $this->db->count_all_results();
    }

    function get_all_marketing_popups_active()
    {
        $this->db->order_by('id', 'desc');  
        $this->db->where('active', 1);           
        return $this->db->get('marketing_popups')->result_array();
    }
        
    function get_all_marketing_popups_active_frontend()
    {
        $todayDate = date("d-m-Y");
        $this->db->order_by('id', 'desc'); 
        //$this->db->where(array('active'=>1,'start_date'=>$todayDate));  
        $this->db->where(array('active'=>1));         
        return $this->db->get('marketing_popups')->row_array();
        //print_r($this->db->last_query());
    }

    function get_all_marketing_popups($params = array())
    {
        $this->db->order_by('id', 'desc');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('marketing_popups')->result_array();
    }
        
    
    function add_marketing_popups($params)
    {
        $this->db->insert('marketing_popups',$params);
        return $this->db->insert_id();
    }
    
    
    function update_marketing_popups($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('marketing_popups',$params);
    }
    
    
    function delete_marketing_popups($id)
    {
        return $this->db->delete('marketing_popups',array('id'=>$id));
    }

    function getMarketingPopupAPI($params = array())
    {    
        $this->db->select('image,title,link,desc');
        $this->db->from('marketing_popups');
        $this->db->where(array('active'=>1));
        $this->db->order_by('`created` DESC');
        $this->db->limit(1);
        return $this->db->get()->result_array();
    }

     

    
}
