<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Neelu
 *
 **/
 class Classroom_documents_modal extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function Get_shared_doc_content_type($classroom_id){
        $this->db->distinct('');
        $this->db->select('ctm.id,ctm.content_type_name');
        $this->db->from('content_type_masters ctm');
        $this->db->join('`classroom_documents_content_type` cd', 'cd.`content_type_id`= ctm.`id`');
        $this->db->join('`classroom_documents_class` cdc', 'cdc.`classroom_documents_id`= cd.`classroom_documents_id`');
        $this->db->where('cdc.classroom_id',$classroom_id);
        $this->db->order_by('ctm.content_type_name', 'ASC');
        return $this->db->get()->result_array();
    }
    function getClassroomDocsID_count($classroom_id,$limit=null,$offset=null)
    {
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
    	$this->db->select('classroom_documents_id');
        $this->db->from('classroom_documents_class');
        $this->db->join('classroom_documents', 'classroom_documents.id= classroom_documents_class.`classroom_documents_id`');		
        $this->db->where(array('classroom_documents_class.classroom_id'=>$classroom_id,'active'=>1));
		$this->db->order_by('classroom_documents_class.created', 'desc');
        return $this->db->get('')->num_rows();       
    }
    function getClassroomDocsID($classroom_id,$limit=null,$offset=null){
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
    	$this->db->select('classroom_documents_id');
        $this->db->from('classroom_documents_class');
        $this->db->join('classroom_documents', 'classroom_documents.id= classroom_documents_class.`classroom_documents_id`');		
        $this->db->where(array('classroom_documents_class.classroom_id'=>$classroom_id,'active'=>1,'total_section>'=>0));
		$this->db->order_by('classroom_documents_class.created', 'desc');
        return $this->db->get()->result_array();       
    }
    function getClassroomDocs($classroom_documents_id)
    {       
    	$this->db->select('
    		cd.id,
    		cd.title,
    		date_format(cd.created, "%D %b %y") as created
    	');
        $this->db->from(' classroom_documents cd');
		$this->db->where('cd.id',$classroom_documents_id); 
		$this->db->order_by('cd.created', 'desc');
        return $this->db->get()->row_array();
    }
    function getClassroomContentType($classroom_documents_id)
    {
    	$this->db->select('
    		ctm.content_type_name
    	');
        $this->db->from('classroom_documents_content_type ct');        
        $this->db->join('content_type_masters ctm', 'ctm.id = ct.content_type_id','left');
		$this->db->where('ct.classroom_documents_id',$classroom_documents_id); 
        return $this->db->get()->result_array();
    }
    function getClassroomContentDesc($classroom_documents_id)
    {
    	$this->db->select('
    		type,section
    	');
        $this->db->from('classroom_documents_section');
		$this->db->where('classroom_documents_id',$classroom_documents_id); 
		$this->db->order_by('section_number', 'ASC');
        return $this->db->get()->result_array();
    }
    function get_classroom_documents($id)
    {
        return $this->db->get_where('classroom_documents',array('id'=>$id))->row_array();
    }
    function get_all_classroom_documents_count($rawArr){
    	$this->db->from('classroom_documents_class'); 
            if(!empty($rawArr)){                   
                $this->db->where_in('classroom_id', $rawArr);
            }else{
                $rawArr=[];                   
                //$this->db->where_in('classroom_id', $rawArr);
            }  
            $this->db->group_by('classroom_documents_id');
        return $this->db->count_all_results();
        //print_r($this->db->last_query());exit;
    }
    function get_all_classroom_documents($rawArr,$params = array()){
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('cs.*');
        $this->db->from('classroom_documents as cs');
		$this->db->order_by('cs.id', 'desc');
		$results=array();
        $classroom_documents =$this->db->get()->result_array();
		foreach($classroom_documents  as $key=>$classroom_document){
			$classrooms=$this->getClassByClassroomDocumentsId($rawArr,$classroom_document['id']);
			if(empty($classrooms)){
				$classroom_documents[$key]['classroom_documents_class']=$classrooms;
			}else{
				$show_classroom_documents=false;
				foreach($classrooms as $classroom){
					if($classroom['delete_action']=='yes'){
						$show_classroom_documents=true;
					}
				}
				if($show_classroom_documents){
					$classroom_documents[$key]['classroom_documents_class']=$classrooms;
				}else{
					unset($classroom_documents[$key]);
				}
			}
		}
        return  $classroom_documents;
    }
	function getClassroomDocumentsById($id){ 
        $this->db->select('cs.*');
        $this->db->from('classroom_documents as cs');
		$this->db->where('cs.id',$id); 		
		$results=array();
        return $this->db->get()->row_array();
    }  
    /*
     * function to add new department_master
     */
    function add_classroom_documents($params)
    {
        $this->db->insert('classroom_documents',$params);
        return $this->db->insert_id();
    }
    /*
     * function to update counseling sessions
    */
    function update_classroom_documents($id,$params)
    {
        $this->db->where('id',$id);
        if($this->db->update('classroom_documents',$params)){
			return true;
		}
    }
    /*
     * function to delete counseling_sessions
     */
    function delete_classroom_documents($id)
    {
        $this->db->delete('classroom_documents',array('id'=>$id));
		$this->db->delete('classroom_documents_section',array('classroom_documents_id'=>$id));
		$this->db->delete('classroom_documents_class',array('classroom_documents_id'=>$id));
    }
	function add_classroom_documents_class($params){
        $this->db->from('classroom_documents_class');
        $this->db->where(array('classroom_documents_id'=>$params['classroom_documents_id'],'classroom_id'=>$params['classroom_id']));
        $c = $this->db->count_all_results();
        if($c==0){
           $this->db->insert('classroom_documents_class',$params);
           return $this->db->insert_id(); 
        }else{
            return 0;
        }        
    }
	function add_classroom_documents_content_type($params){
        $this->db->from('classroom_documents_content_type');
        $this->db->where(array('classroom_documents_id'=>$params['classroom_documents_id'],'content_type_id'=>$params['content_type_id']));
        $c = $this->db->count_all_results();
        if($c==0){
           $this->db->insert('classroom_documents_content_type',$params);
           return $this->db->insert_id(); 
        }else{
            return 0;
        }        
    }
	function add_classroom_documents_section($classroom_documents_id,$params,$old_classroom_documents_id=null){
		if(!empty($old_classroom_documents_id)){
		  $this->db->where('classroom_documents_id',$old_classroom_documents_id);
          $this->db->delete('classroom_documents_section');
		} 
		if(!empty($params)){
           $this->db->insert_batch('classroom_documents_section',$params);
           $id=$this->db->insert_id();
		   $total_section=count($params);
		   $this->db->where('id ',$classroom_documents_id);
		   $this->db->update('classroom_documents',array('total_section'=>$total_section));
           return $id;
        }else{
            return 0;
        }
	}
	function getClassByClassroomDocumentsId($rawArr,$classroom_documents_id){
			$classrooms=array();
			$this->db->select('cr.id,cr.classroom_name,csc.classroom_documents_id');
            $this->db->from('classroom_documents_class csc');
            $this->db->join('classroom cr', 'cr.id = csc.classroom_id');
            $this->db->where(array('csc.classroom_documents_id'=>$classroom_documents_id));
			$classrooms=$this->db->get('')->result_array();
			if(!empty($classrooms)){
					foreach($classrooms as $key=>$classroom){
					    $this->db->select('cr.id');
                        $this->db->from('classroom cr');
						$this->db->where('cr.id', $classroom['id']);						
						if(!empty($rawArr)){							
							$this->db->where_in('cr.id', $rawArr);
						}else{
							$rawArr = [];
							//$this->db->where_in('cr.id', $rawArr);
						}
						$count=$this->db->count_all_results();
						if($count > 0){
						    $classrooms[$key]['delete_action']='yes';
					    }else{
							$classrooms[$key]['delete_action']='no';
						}						
					}
			}
		//pr($classrooms);
		return $classrooms;
	}
	function getSectionByClassroomDocumentsId($classroom_documents_id){
		$this->db->select('*');
        $this->db->from('classroom_documents_section');
        $this->db->where(array('classroom_documents_id'=>$classroom_documents_id));
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
	function getContentTypeByClassroomDocumentsId($classroom_documents_id){
		$this->db->select('ctm.id,ctm.content_type_name,cdc.classroom_documents_id');
        $this->db->from('classroom_documents_content_type cdc');
        $this->db->join('content_type_masters ctm', 'ctm.id = cdc.content_type_id');
        $this->db->where(array('cdc.classroom_documents_id'=>$classroom_documents_id));
		$results=$this->db->get('')->result_array();
		return $results;
	}
	function delete_classroom_documents_class($classroom_documents_id,$classroom_id){
		$this->db->from('classroom_documents_class');
		$this->db->where('classroom_documents_id', $classroom_documents_id);
		$count=$this->db->count_all_results();
		if($count > 0){
             return $this->db->delete('classroom_documents_class',array('classroom_documents_id'=>$classroom_documents_id,'classroom_id'=>$classroom_id));
		}
    }
	function delete_classroom_documents_content_type($classroom_documents_id,$content_type_id){
		$this->db->from('classroom_documents_content_type');
		 $this->db->where('classroom_documents_id', $classroom_documents_id);
		$count=$this->db->count_all_results();
		if($count > 0){
             return $this->db->delete('classroom_documents_content_type',array('classroom_documents_id'=>$classroom_documents_id,'content_type_id'=>$content_type_id));
		}
    }
    function getCLDocsId_CTYPE($contenttype_id,$classroom_id,$searchtext,$limit=null,$offset=null){
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
    	$this->db->select('classroom_documents_content_type.classroom_documents_id,classroom_documents_class.classroom_id');
        $this->db->from('classroom_documents_content_type');
        $this->db->join('classroom_documents_class', 'classroom_documents_class.classroom_documents_id = classroom_documents_content_type.classroom_documents_id');
        if(!empty($searchtext))
        {
        	$this->db->join('classroom_documents', 'classroom_documents.id = classroom_documents_content_type.classroom_documents_id');
        	$this->db->like('classroom_documents.title', $searchtext);
        }
          if(!empty($contenttype_id))
        {
        	$this->db->where('classroom_documents_content_type.content_type_id',$contenttype_id);
        }
		//$this->db->where('content_type_id',$contenttype_id);
		$this->db->where(array('classroom_documents_class.classroom_id'=>$classroom_id));
		 $this->db->group_by('classroom_documents_content_type.classroom_documents_id'); 
		$this->db->order_by('classroom_documents_class.created', 'desc'); 
		 return $this->db->get()->result_array();
     //print_r($this->db->last_query());exit;
    }
    function getCLDocsId_CTYPE_count($contenttype_id,$classroom_id,$searchtext,$limit=null,$offset=null){
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
    	$this->db->select('classroom_documents_content_type.classroom_documents_id,classroom_documents_class.classroom_id');
        $this->db->from('classroom_documents_content_type');
        $this->db->join('classroom_documents_class', 'classroom_documents_class.classroom_documents_id = classroom_documents_content_type.classroom_documents_id');
        if(!empty($searchtext))
        {
        	$this->db->join('classroom_documents', 'classroom_documents.id = classroom_documents_content_type.classroom_documents_id');
        	$this->db->like('classroom_documents.title', $searchtext);
        }
          if(!empty($contenttype_id))
        {
        	$this->db->where('classroom_documents_content_type.content_type_id',$contenttype_id);
        }
		//$this->db->where('content_type_id',$contenttype_id);
		$this->db->where(array('classroom_documents_class.classroom_id'=>$classroom_id));
		 $this->db->group_by('classroom_documents_content_type.classroom_documents_id'); 
		$this->db->order_by('classroom_documents_class.created', 'desc'); 
        return $this->db->get('')->num_rows();     
         //print_r($this->db->last_query());exit;
    }
}
