<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          navjeet
 *
 **/

 class Url_slug_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();        
    }
    function checkUrl($url,$type,$edit_id)
    {   
        if($type=='news')
        {
            $this->db->select('id');
            $this->db->from('news');
            $this->db->where('URLslug',$url);          
            $this->db->where('active','1');
            if($edit_id)
            {
                $this->db->where('id !=',$edit_id);

            }
        }	
       else if($type=='visaservice')
        {
            $this->db->select('id');
            $this->db->from('enquiry_purpose_masters');
            $this->db->where('URLslug',$url);          
            $this->db->where('active','1');
            if($edit_id)
            {
                $this->db->where('id !=',$edit_id);

            }
        }	
        else if($type=='freeresourse')
        {
            $this->db->select('id');
            $this->db->from('free_resources');
            $this->db->where('URLslug',$url);          
            $this->db->where('active','1');
            if($edit_id)
            {
                $this->db->where('id !=',$edit_id);

            }
        }
        
		$data=$this->db->count_all_results();
		if($data > 0){
			return true;
		}else{
			return 0;
		}
    }

}