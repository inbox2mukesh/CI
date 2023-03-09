<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Neelu
 *
 **/
 class Free_resources_modal extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function free_resource_check($id){
        
        $this->db->from('free_resources');
        $this->db->where(array('URLslug'=> $id,'active'=>1));
        return $this->db->count_all_results();
    }

    function getFreeResourceCourse(){

        $this->db->distinct('');
        $this->db->select('
            tm.test_module_id,
            tm.test_module_name,
        ');
        $this->db->from('free_resources_test frt');
        $this->db->join('test_module tm', 'tm.test_module_id= frt.test_module_id');
        $this->db->where('tm.active', 1);
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function getFreeResourceContentType(){

        $this->db->distinct('');
        $this->db->select('
            ctm.id,
            ctm.content_type_name,
        ');
        $this->db->from('free_resources fr');
        $this->db->join('content_type_masters ctm', 'ctm.id= fr.content_type_id');
        $this->db->where('fr.active', 1);
        $this->db->order_by('ctm.content_type_name', 'ASC');
        return $this->db->get()->result_array();
    }

    /*function getFreeResourceContents(){

        $this->db->select('
            ctm.content_type_name,
            fr.id,
            fr.isPinned,
            fr.title,
            fr.description,
            CONCAT("'.base_url('./uploads/free_resources/image/').'", fr.image) as image,
            date_format(fr.created, "%D %b %Y") as `created`,
        ');
        $this->db->from('free_resources fr');
        $this->db->join('content_type_masters ctm', 'ctm.id= fr.content_type_id');
        $this->db->where('fr.active', 1);
        $this->db->order_by('fr.id', 'DESC');
        $this->db->limit(9);
        return $this->db->get()->result_array();
    }*/



    function getFreeResourceContents($content_test_type=0){

        $this->db->select('
            ctm.content_type_name,
            fr.id,
            fr.isPinned,
            fr.title,
            fr.description,
            fr.URLslug,
            CONCAT("'.base_url('./uploads/free_resources/image/').'", fr.image) as image,
            date_format(fr.modified, "%D %b %Y") as `created`,
        ');
        $this->db->from('free_resources fr');
        $this->db->join('content_type_masters ctm', 'ctm.id= fr.content_type_id');
        $this->db->where('URLslug IS NOT NULL');
        $this->db->where('fr.active', 1);
        $this->db->order_by('fr.id', 'DESC');
        $this->db->limit(12);
        return $this->db->get()->result_array();
    }

    function getFreeResourceFilterTestType($test_type,$content_test_type,$upload_time,$search_text)
    {
        if($upload_time !="")
        {

            if($upload_time == 'week')
            {
                $firstday = date('Y-m-d', strtotime("this week"));  
                $enddate=date('Y-m-d');    
            }
            else if($upload_time == 'month')// this month
            {
               $firstday = date('Y-m-01'); // hard-coded '01' for first day
               $enddate  = date('Y-m-t');
            }
            else if($upload_time == '6month')// last 6th month from current month
            {
                $firstday = date("Y-m-01", strtotime("-5 months"));                 
                $enddate  = date('Y-m-t');                
            }
            else if($upload_time == 'year')// This year
            {
                $firstday = date("Y-01-01");                     
                $enddate  = date("Y-12-31");
            }
            else if($upload_time == 'lastyear')// last year
            {
                $firstday = date("Y-01-01", strtotime("-1 year"));                     
                $enddate  = date("Y-12-31", strtotime("-1 year"));
            }
        }       
                
        if($test_type != "" AND $content_test_type == "") 
        {
            $this->db->select('
           ctm.content_type_name,
            fr.id,
            fr.isPinned,
            fr.title,
            fr.description,
            fr.URLslug,
            CONCAT("'.base_url('./uploads/free_resources/image/').'", fr.image) as image,
            date_format(fr.modified, "%D %b %Y") as `created`,
        ');
        $this->db->from('free_resources_topic_data frt');
        $this->db->join('free_resources fr', 'fr.id=frt.free_resources_id');
        $this->db->join('content_type_masters ctm', 'ctm.id= fr.content_type_id');
        $this->db->where('frt.topic_id', $test_type);
        $this->db->where('URLslug IS NOT NULL');
        $this->db->where('fr.active', 1);
        if($search_text){
        $this->db->like('fr.title', $search_text);
        }
        if($upload_time !="")
        {
            $this->db->where('DATE(fr.modified) >=', $firstday);
            $this->db->where('DATE(fr.modified) <=', $enddate);
        }
        $this->db->limit(9);

        return $this->db->get()->result_array();

        }
        else if($test_type != "" AND $content_test_type != "")
        {
            $this->db->select('
           ctm.content_type_name,
            fr.id,
            fr.isPinned,
            fr.title,
            fr.description,
            fr.URLslug,
            CONCAT("'.base_url('./uploads/free_resources/image/').'", fr.image) as image,
            date_format(fr.modified, "%D %b %Y") as `created`,
        ');
        $this->db->from('free_resources_topic_data frt');
        $this->db->join('free_resources fr', 'fr.id=frt.free_resources_id');
        $this->db->join('content_type_masters ctm', 'ctm.id= fr.content_type_id');
        $this->db->where('frt.topic_id', $test_type);
        $this->db->where('fr.active', 1);
        $this->db->where('URLslug IS NOT NULL');
         if($search_text){
        $this->db->like('fr.title', $search_text);
        }
        if($content_test_type)
        {
      
        $this->db->where('fr.content_type_id', $content_test_type);
        }
        $this->db->limit(9);
        return $this->db->get()->result_array();
        }
        else {
             $this->db->select('
            ctm.content_type_name,
            fr.id,
            fr.isPinned,
            fr.title,
            fr.description,
            fr.URLslug,
            CONCAT("'.base_url('./uploads/free_resources/image/').'", fr.image) as image,
            date_format(fr.modified, "%D %b %Y") as `created`,
        ');
        $this->db->from('free_resources fr');
        $this->db->join('content_type_masters ctm', 'ctm.id= fr.content_type_id');
        if($content_test_type)
        {
      
        $this->db->where('fr.content_type_id', $content_test_type);
        }
         if($search_text){
        $this->db->like('fr.title', $search_text);
        }
         if($upload_time !="")
        {
            $this->db->where('DATE(fr.modified) >=', $firstday);
            $this->db->where('DATE(fr.modified) <=', $enddate);
        }
        $this->db->where('fr.active', 1);
        $this->db->where('URLslug IS NOT NULL');
        $this->db->order_by('fr.id', 'DESC');
        $this->db->limit(9);
         return $this->db->get()->result_array();
       //  print_r($this->db->last_query());exit;
        }
        

    }

    function getFreeResourceContentsFeatured(){

        $this->db->select('
            ctm.content_type_name,
            fr.id,
            fr.isPinned,
            fr.title,
            fr.description,
            fr.URLslug,
            CONCAT("'.base_url('./uploads/free_resources/image/').'", fr.image) as image,
            date_format(fr.created, "%D %b %Y") as `created`,
        ');
        $this->db->from('free_resources fr');
        $this->db->join('content_type_masters ctm', 'ctm.id= fr.content_type_id');
        $this->db->where(array('fr.active'=> 1,'fr.ispinned'=>1));
        $this->db->order_by('fr.id', 'DESC');
        $this->db->limit(4);
        return $this->db->get()->result_array();
    }
    function getFreeResourceContentsTopic($id){

        // $this->db->select('
        //     tm.test_module_name,
        // ');
        // $this->db->from('free_resources_topic_data');
        // $this->db->join('test_module tm', 'tm.test_module_id= frt.test_module_id');
        // $this->db->where('frt.free_resources_id', $id);
        // return $this->db->get()->result_array();

        
		$this->db->select('free_resources_topic.topic');
        $this->db->from('free_resources_topic_data');
        $this->db->join('free_resources_topic', 'free_resources_topic.topic_id = free_resources_topic_data.topic_id','left');
        $this->db->where(array('free_resources_id'=>$id));
        return $results=$this->db->get('')->result_array();
		// $tests=array();    
		// foreach($results as $key=>$data)
        // {
		// 	$tests[$data['topic_id']]=$data;           
		// }
		// return $tests;	

    }

    function getFreeResourceContentsCourse($id){

        $this->db->select('
            tm.test_module_name,
        ');
        $this->db->from('free_resources_test frt');
        $this->db->join('test_module tm', 'tm.test_module_id= frt.test_module_id');
        $this->db->where('frt.free_resources_id', $id);
        return $this->db->get()->result_array();

    }

    function getFreeResourceContentSpecific($id){

        $this->db->select('
            ctm.content_type_name,
            fr.id,
            fr.title,
            fr.isPinned,
            fr.description,
            fr.URLslug,
            CONCAT("'.base_url('./uploads/free_resources/image/').'", fr.image) as image,
            date_format(fr.created, "%D %b %Y") as `created`,
        ');
        $this->db->from('free_resources fr');
        $this->db->join('content_type_masters ctm', 'ctm.id= fr.content_type_id');
        $this->db->where('fr.URLslug', $id);
        return $this->db->get()->result_array();

    }

    function getFreeResourceSections($id){

        $this->db->select('            
            section,
            type
        ');
        $this->db->from('free_resources_section');
        $this->db->where('free_resources_id', $id);
        $this->db->order_by('section_number', 'ASC');
        return $this->db->get()->result_array();

    }
    
    function get_free_resources($id)
    {
        return $this->db->get_where('free_resources',array('id'=>$id))->row_array();
    }
    
    function get_all_free_resources_count()
    {
        $this->db->select('cs.*');
        $this->db->from('free_resources as cs');
        return $this->db->count_all_results();
    }
        
    
    function get_all_free_resources($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('cs.*,ctm.content_type_name');
        $this->db->from('free_resources as cs');
		$this->db->join('content_type_masters ctm', 'ctm.id= cs.content_type_id');
		$this->db->order_by('cs.id', 'desc');
		$results=array();
        return $this->db->get()->result_array();
        
    }

	function getFreeResourcesById($id)
    {  
        $this->db->select('cs.*,ctm.content_type_name');
        $this->db->from('free_resources as cs');
		$this->db->join('content_type_masters ctm', 'ctm.id= cs.content_type_id');
		$this->db->where('cs.id',$id); 
		$this->db->order_by('cs.id', 'desc');
		$results=array();
        return $this->db->get()->row_array();
        
    }

    function get_all_free_resources_active($params= array()){       
        
		if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('cs.*,ctm.content_type_name');
        $this->db->from('free_resources as cs');
		$this->db->join('content_type_masters ctm', 'ctm.id= cs.content_type_id');
		$this->db->where('cs.active', 1);  
		$this->db->order_by('cs.id', 'desc');
        return $this->db->get()->result_array();
    }    
        
   
    function add_free_resources($params)
    {
        $this->db->insert('free_resources',$params);
        return $this->db->insert_id();
    }
    
    function update_free_resources($id,$params)
    {
        $this->db->where('id',$id);
        if($this->db->update('free_resources',$params)){
			return true;
		}
    }

    function delete_free_resources($id)
    {
        $this->db->delete('free_resources',array('id'=>$id));
		$this->db->delete('free_resources_section',array('free_resources_id'=>$id));
		$this->db->delete('free_resources_test',array('free_resources_id'=>$id));
		
    }
	
	function add_free_resources_test($params){

        $this->db->from('free_resources_topic_data');
        $this->db->where(array('free_resources_id'=>$params['free_resources_id'],'topic_id'=>$params['topic_id']));
        $c = $this->db->count_all_results();
        if($c==0){
           $this->db->insert('free_resources_topic_data',$params);
           return $this->db->insert_id(); 
        }else{
            return 0;
        }        
    }
	
	function add_free_resources_section($free_resources_id,$params,$old_free_resources_id=null){
		
		if(!empty($old_free_resources_id)){
			
		  $this->db->where('free_resources_id',$old_free_resources_id);
          $this->db->delete('free_resources_section');
		  
		} 
		if(!empty($params)){
			
           $this->db->insert_batch('free_resources_section',$params);
           $id=$this->db->insert_id();
		   $total_section=count($params);
		   $this->db->where('id ',$free_resources_id);
		   $this->db->update('free_resources',array('total_section'=>$total_section));
           return $id;
        }else{
            return 0;
        }
	}
	
	function getTestByFreeResourcesId($free_resources_id){
		
		$this->db->select('free_resources_topic.topic_id,free_resources_topic.topic,free_resources_topic_data.free_resources_id');
        $this->db->from('free_resources_topic_data');
        $this->db->join('free_resources_topic', 'free_resources_topic.topic_id = free_resources_topic_data.topic_id','left');
        $this->db->where(array('free_resources_id'=>$free_resources_id));
        $results=$this->db->get('')->result_array();
		$tests=array();    
		foreach($results as $key=>$data)
        {
			$tests[$data['topic_id']]=$data;           
		}
		return $tests;		
	}
	
	function getSectionByFreeResourcesId($free_resources_id){
		
		$this->db->select('*');
        $this->db->from('free_resources_section');
        $this->db->where(array('free_resources_id'=>$free_resources_id));
		$this->db->order_by('section_number', 'asc');
        $results=$this->db->get('')->result_array();
		$dataNew=array();
		$i=1;
		foreach($results as $data){
			
			$dataNew[$i]=$data;
			$i++;
		}
		return $dataNew;
	}
	
	function delete_free_resources_test($free_resources_id,$test_module_id){ 
        return $this->db->delete('free_resources_topic_data',array('free_resources_id'=>$free_resources_id,'topic_id'=>$test_module_id));
    }
    function getFreeResourceContentsShort($content_test_type=0){

        $this->db->select('
            ctm.content_type_name,
            fr.id,
            fr.isPinned,
            fr.title,
            fr.description,
            fr.URLslug,
            CONCAT("'.base_url('./uploads/free_resources/image/').'", fr.image) as image,
            date_format(fr.modified, "%D %b %Y") as `created`,
        ');
        $this->db->from('free_resources fr');
        $this->db->join('content_type_masters ctm', 'ctm.id= fr.content_type_id');
        $this->db->where('fr.active', 1);
      
        $this->db->order_by('fr.id', 'DESC');
        $this->db->limit(3);
        return $this->db->get()->result_array();
    }
    function getFreeResourceContentSpecificLimited($id){

        $this->db->select('
            ctm.content_type_name,
            fr.id,
            fr.title,
            fr.isPinned,
            fr.description,
            fr.URLslug,
            CONCAT("'.base_url('./uploads/free_resources/image/').'", fr.image) as image,
            date_format(fr.created, "%D %b %Y") as `created`,
        ');
        $this->db->from('free_resources fr');
        $this->db->join('content_type_masters ctm', 'ctm.id= fr.content_type_id');
        $this->db->where('fr.URLslug!=', $id);
        $this->db->limit(5);
        return $this->db->get()->result_array();

    }
}
