<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 class Enquiry_purpose_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get enquiry_purpose_master by id
     */
    function get_enquiry_purposefront($id)
    {
        return $this->db->get_where('enquiry_purpose_masters',array('URLslug'=>$id))->row_array();
    }

    function get_enquiry_purpose($id)
    {
        return $this->db->get_where('enquiry_purpose_masters',array('id'=>$id))->row_array();
    }
    /*
     * Get all enquiry_purpose count
     */
    function get_all_enquiry_purpose_count()
    {
        $this->db->from('enquiry_purpose_masters');
        return $this->db->count_all_results();
    }
        
    /*
     * Get all enquiry_purpose
     */
    function get_all_enquiry_purpose($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('*');
        $this->db->from('enquiry_purpose_masters');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result_array();
    }

    function get_all_enquiry_purpose_active(){       
        
        $this->db->select('enquiry_purpose_masters.id,enquiry_purpose_name,about_service,image,URLslug');
        $this->db->from('enquiry_purpose_masters');    
        $this->db->join('`enquiry_purpose_division`', 'enquiry_purpose_division.enquiry_purpose_id= enquiry_purpose_masters.id', 'left');
        $this->db->where(array('active'=>1,'division_id'=>2));
        $this->db->where('URLslug IS NOT NULL');
        $this->db->order_by('enquiry_purpose_name', 'ASC');
         return $this->db->get()->result_array();
       // print_r($this->db->last_query());exit;
    } 
    function get_all_enquiry_purpose_active_all(){       
        $this->db->distinct('');
        $this->db->select('enquiry_purpose_masters.id,enquiry_purpose_name');
        $this->db->from('enquiry_purpose_masters');  
        $this->db->join('`enquiry_purpose_division`', 'enquiry_purpose_division.enquiry_purpose_id= enquiry_purpose_masters.id', 'left'); 
        $this->db->where( array('enquiry_purpose_masters.active'=>1));  
        if(DEFAULT_COUNTRY==101)
        {           
            $this->db->where('division_id',1);
        }
        $this->db->order_by('enquiry_purpose_division.division_id', 'ASC');
        return $this->db->get()->result_array();
    }    
        
    /*
     * function to add new enquiry_purpose_master
     */
    function add_enquiry_purpose($params)
    {
        $this->db->insert('enquiry_purpose_masters',$params);
        return $this->db->insert_id();
    }
	
    /*
     * function to update enquiry_purpose_master
     */
    function update_enquiry_purpose($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('enquiry_purpose_masters',$params);
    }
    /*
     * function to delete enquiry_purpose_master
     */
    function delete_enquiry_purpose($id)
    {
        return $this->db->delete('enquiry_purpose_masters',array('id'=>$id));
    }
    
	//Add New Function 
    /*
     * function to delete enquiry_purpose_division
     */
	 
	 function getAllActiveEnquiryPurposeByDivisionId($division_id=array())
    {   
        $this->db->select('enquiry_purpose_masters.id,event_type_master.enquiry_purpose_name ');
        $this->db->from('enquiry_purpose_masters');
		$this->db->where('enquiry_purpose_masters.active',1);
		$this->db->join('enquiry_purpose_division', 'enquiry_purpose_masters.id= enquiry_purpose_division.enquiry_purpose_id','left');
		$this->db->where_in('enquiry_purpose_division.division_id',$division_id);
        $this->db->order_by('enquiry_purpose_masters.enquiry_purpose_name ', 'ASC');
        return $this->db->get()->result_array();
    }
	
	function getDivisionByeEnquiryPurposeId($enquiry_purpose_id)
    {   
        $this->db->select('enquiry_purpose_division.enquiry_purpose_id,enquiry_purpose_division.division_id
		,division_masters.division_name');
        $this->db->from('enquiry_purpose_division');
		//$this->db->where('division_masters.active',1);
		$this->db->where('enquiry_purpose_division.enquiry_purpose_id',$enquiry_purpose_id);
		$this->db->join('division_masters', 'division_masters.id= enquiry_purpose_division.division_id','left');
        $this->db->order_by('division_masters.division_name', 'ASC');
        return $this->db->get()->result_array();
    }
	
    function delete_enquiry_purpose_division($enquiry_purpose_id,$division_id)
    {
       
		return $this->db->delete('enquiry_purpose_division',array('enquiry_purpose_id'=>$enquiry_purpose_id,'division_id'=>$division_id));
    }
	
	function add_enquiry_purpose_division($params)
    {
        $this->db->from('enquiry_purpose_division');
        $this->db->where(array('enquiry_purpose_id'=>$params['enquiry_purpose_id'],'division_id'=>$params['division_id']));
        $c = $this->db->count_all_results();
		if($c==0){
			
            $this->db->insert('enquiry_purpose_division',$params);
            return $this->db->insert_id();
		}
    }

    function get_enquiry_purpose_based_on_session_booking(){       
        $this->db->distinct('');
        $this->db->select('enquiry_purpose_masters.id,enquiry_purpose_name');
        $this->db->from('students_counseling');  
        
        $this->db->join('`enquiry_purpose_masters`', 'enquiry_purpose_masters.id=students_counseling.service_id', 'left');  
        $this->db->join('`enquiry_purpose_division`', 'enquiry_purpose_division.enquiry_purpose_id= enquiry_purpose_masters.id', 'left'); 
        $this->db->where( array('enquiry_purpose_masters.active'=>1));  
        $this->db->order_by('enquiry_purpose_division.division_id', 'ASC');
        return $this->db->get()->result_array();
    }    
    function get_all_enquiry_purpose_academic_active(){       
        
        $this->db->select('enquiry_purpose_masters.id,enquiry_purpose_name,about_service,image,URLslug');
        $this->db->from('enquiry_purpose_masters');    
        $this->db->join('`enquiry_purpose_division`', 'enquiry_purpose_division.enquiry_purpose_id= enquiry_purpose_masters.id', 'left');
        $this->db->where(array('active'=>1,'division_id'=>1));
        $this->db->where('URLslug IS NOT NULL');
        $this->db->order_by('enquiry_purpose_name', 'ASC');
         return $this->db->get()->result_array();
       // print_r($this->db->last_query());exit;
    } 

    function get_all_enquiry_purpose_by_division($division_id)
    {
        $this->db->select('enquiry_purpose_masters.id,enquiry_purpose_name,about_service,image,URLslug');
        $this->db->from('enquiry_purpose_masters');    
        $this->db->join('`enquiry_purpose_division`', 'enquiry_purpose_division.enquiry_purpose_id= enquiry_purpose_masters.id', 'left');
        $this->db->where(array('active'=>1,'division_id'=>$division_id));
       // $this->db->where('URLslug IS NOT NULL');
        $this->db->order_by('enquiry_purpose_name', 'ASC');
         return $this->db->get()->result_array();

         //print_r($this->db->last_query());exit;
    }

    /****
     *  insert banner image
     */
    function insert_banner($params=null)
    {
        $this->db->insert('visa_banner',$params);
    }
    function select_banner()
    {
        $this->db->select('*')
             ->from('visa_banner');
        return $this->db->get()->result_array();
    }
	
}
