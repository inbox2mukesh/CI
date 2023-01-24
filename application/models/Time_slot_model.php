<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Time_slot_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_timeslot_duplicacy($time_slot,$type){

        $this->db->from('time_slot_master');
        $this->db->where(array('time_slot'=> $time_slot, 'type'=>$type));      
        return $this->db->count_all_results();
    }

    function check_timeslot_duplicacy2($time_slot,$time_slot_id,$type){
        
        $this->db->from('time_slot_master');
        $this->db->where(array('time_slot'=>$time_slot,'id!='=>$time_slot_id, 'type'=>$type));
        return $this->db->count_all_results();
    }

    function get_all_time_slots()
    {
        $this->db->select('time_slot,type');
        $this->db->from('time_slot_master');
        $this->db->where('active', '1');
        $this->db->order_by('type', 'ASC');
        $this->db->order_by('time_slot', 'ASC');
        return $this->db->get()->result_array();
    }

   
    function get_time_slot($id)
    {
        return $this->db->get_where('time_slot_master',array('id'=>$id))->row_array();
    }
    
    
    function get_all_time_slots_count()
    {
        $this->db->from('time_slot_master');
        return $this->db->count_all_results();
    }
        
   
    function get_all_time_slots_active($params = array())
    {
        $this->db->where('active', '1');
        $this->db->order_by('id', 'desc');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('time_slot_master')->result_array();
    }

    function get_all_time_slotss($params = array())
    {       
        $this->db->order_by('time_slot', 'ASC');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('time_slot_master')->result_array();
    }

    
    function add_time_slot($params)
    {        
        $time_slot =  $params['time_slot'];
        $type =  $params['type'];
        $this->db->where('time_slot', $time_slot);
        $this->db->where('type', $type);
        $query = $this->db->get('time_slot_master');
        $count_row = $query->num_rows();
        if($count_row > 0) {          
            return FALSE;
        }else{          
            $this->db->insert('time_slot_master',$params);
            return $this->db->insert_id();
        }       
    }

    function dupliacte_time_slot($time_slot){

        $this->db->where('time_slot', $time_slot);
        $query = $this->db->get('time_slot_master');
        $count_row = $query->num_rows();
        if($count_row > 0){          
            return 'FALSE';
        }else{
            return 'TRUE';
        }
    }
    
   
    function update_time_slot($id,$params){
        
        $this->db->where('id',$id);
        return $this->db->update('time_slot_master',$params);
    }
    
   
    function delete_time_slot($id){
        
        return $this->db->delete('time_slot_master',array('id'=>$id));
    }
    
    function getTimeSlotsList($params = array())
    {
        $this->db->where('active', '1');
        $this->db->order_by('time_slot', 'asc');
        $results=$this->db->get('time_slot_master')->result_array();
		$times=array();
		foreach($results as $key=>$val){			
			$times[$val['id']]=$val;
		}
		return $times;
    }

    
}
