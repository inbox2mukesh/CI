<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 class Document_type_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_doc_type_duplicacy($document_type_name){

        $this->db->from('document_type_masters');
        $this->db->where('document_type_name', $document_type_name);      
        return $this->db->count_all_results();
    }

    function check_doc_type_duplicacy2($document_type_name,$document_type_id){
        
        $this->db->from('document_type_masters');
        $this->db->where(array('document_type_name'=>$document_type_name,'id!='=>$document_type_id));
        return $this->db->count_all_results();
    }

    function getDocumentType($document_type){
        
        $this->db->select('document_type_name');
        $this->db->from('`document_type_masters`');    
        $this->db->where(array('id'=>$document_type));
        return $this->db->get('')->row_array();
    }

    function getDocumentExpiryType($docTypeid){
        
        $this->db->select('have_expiry_date');
        $this->db->from('`document_type_masters`');    
        $this->db->where(array('id'=>$docTypeid));
        return $this->db->get('')->row_array();
    }
    
    function get_document_type($id)
    {
        return $this->db->get_where('document_type_masters',array('id'=>$id))->row_array();
    }

    function get_all_document_type_count()
    {
        $this->db->from('document_type_masters');
        return $this->db->count_all_results();
    }

    function get_all_document_type($params = array())
    {  
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }  
        $this->db->select('*');
        $this->db->from('document_type_masters');
        $this->db->order_by('id', 'desc');
        return $this->db->get()->result_array();
    }

    function get_all_document_type_active(){       
        
        $this->db->select('id,document_type_name');
        $this->db->from('document_type_masters');    
        $this->db->where('active', 1);  
        $this->db->order_by('document_type_name', 'asc');
        return $this->db->get()->result_array();
    }

    function get_passport_document_type(){       
        
        $this->db->select('id,document_type_name');
        $this->db->from('document_type_masters');    
        $this->db->where(array('active'=> 1,'document_type_name'=>'Passport'));  
        return $this->db->get()->result_array();
    }

    function add_document_type($params)
    {
        $this->db->where('document_type_name', $params['document_type_name']);
        $query = $this->db->get('document_type_masters');
        $count = $query->num_rows();
        if($count > 0) {          
            return 2;
        }else{          
            $this->db->insert('document_type_masters',$params);
            $this->db->insert_id();
            return 1;
        }
    }

    function update_document_type($id,$params,$document_type_name_old)
    {
        if($document_type_name_old==$params['document_type_name']){
            $this->db->where('id',$id);
            $this->db->update('document_type_masters',$params);
            return 1;
        }else{            
            $this->db->where(array('document_type_name'=> $params['document_type_name']));
            $query = $this->db->get('document_type_masters');
            $count_row = $query->num_rows();
            if($count_row > 0){          
                return 2;
            }else{
                $this->db->where('id',$id);
                $this->db->update('document_type_masters',$params);
                return 1;
            }
        }
    }

    function delete_document_type($id)
    {
        return $this->db->delete('document_type_masters',array('id'=>$id));
    }
}
