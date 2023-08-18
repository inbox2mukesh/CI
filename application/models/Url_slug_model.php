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
    
    function getmetaDetails($page,$page_url)
    {
        if($page == 'articles')
        {
            $tablename = 'free_resources';
            $this->db->select('seo_title,seo_keywords,seo_desc');
            $this->db->from($tablename);
            $this->db->where('URLslug',$page_url);
            return $this->db->get()->result_array();
        }
        elseif($page == 'test-preparation-material')
        {
            $tablename = 'test_preparation_material';
            $this->db->select('seo_title,seo_keywords,seo_desc');
            $this->db->from($tablename);
            $this->db->where('URLslug',$page_url);
            return $this->db->get()->result_array();
        }
        else if($page == 'visa-services' || $page == 'online-coaching')
        {
            $tablename = 'enquiry_purpose_masters';
            $this->db->select('seo_title,seo_keywords,seo_desc');
            $this->db->from($tablename);
            $this->db->where('URLslug',$page_url);
            return $this->db->get()->result_array();
        }
        elseif($page == 'news-detail')
        {
            $tablename = 'news';
            $this->db->select('seo_title,seo_keywords,seo_desc');
            $this->db->from($tablename);
            $this->db->where('URLslug',$page_url);
            return $this->db->get()->result_array();
        }else{
            
        }
        
    }

}