<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

class Refund_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    function getRefundHistory($student_id){
        
        $this->db->select('
            w.id as wid,
            w.amount,
            w.remarks,
            w.active,
            w.created,
            w.approve,
            w.created,

            s.id as sid,

            u.id as to_id, 
            u.fname as to_fname,
            u.lname as to_lname,
            u.employeeCode as to_employeeCode ,

            uu.id as from_id, 
            uu.fname as from_fname,
            uu.lname as from_lname,
            uu.employeeCode as from_employeeCode ,

            uuu.id as ref_id, 
            uuu.fname as ref_fname,
            uuu.lname as ref_lname,
            uuu.employeeCode as ref_employeeCode ,
            
        ');
        $this->db->from('refund_request w');
        $this->db->join('user u', 'u.id = w.user_id','left');
        $this->db->join('students s', 's.id = w.student_id','left');
        $this->db->join('user uu', 'uu.id = w.by_user','left');
        $this->db->join('user uuu', 'uuu.id = w.ref_user_id','left');
        $this->db->where('w.student_id',$student_id);
        $this->db->order_by('w.id','DESC');
        return $this->db->get('')->result_array();

    }

    function deactivateApprovedRefundNotUsedAfterTwoDays($todayStr){

        $addTwodays = 172800;
        return $this->db->query("update `refund_request` SET 
            `active` = 0, `approve`=3
            where `active` = 1 and `approve`=1 and `approvedOn`+ 172800 <= '".$todayStr."'
        ");
    }    
    
    /*
     * Get refund_request by id
     */
    function get_refund($id)
    {
        return $this->db->get_where('refund_request',array('id'=>$id))->row_array();
    }  

    function get_byUser($id){

        $this->db->select('
            by_user            
        ');
        $this->db->from('refund_request');        
        $this->db->where(array('id'=>$id));
        return $this->db->get('')->row_array();

    }  
    
    /*
     * Get all refund_request count
     */
    function get_all_refund_request_count()
    {
        $this->db->from('refund_request');
        return $this->db->count_all_results();
    }

    function get_refund_approved_count($id,$by_user)
    {
        $this->db->from('refund_request');
        $this->db->where(array('student_id'=>$id, 'active'=>1,'by_user'=>$by_user, 'approve'=>1));
        return $this->db->count_all_results();
    }

    function get_refund_approved_details($id,$by_user){

        $this->db->select('
            w.id as wid,
            w.amount,
            w.remarks,
            uu.id as from_id, 
            uu.fname as from_fname,
            uu.lname as from_lname,
            uu.mobile as from_mobile            
        ');
        $this->db->from('refund_request w');
        $this->db->join('user uu', 'uu.id = w.user_id','left');
        $this->db->where(array('w.student_id'=>$id,'w.active'=>1,'w.by_user'=>$by_user,'w.approve'=>1));
        $this->db->order_by('w.id', 'desc');
        return $this->db->get('')->row_array();
    }
        
    /*
     * Get all refund_request
     */
    function get_all_refund_request($params = array()){
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $by_user= $_SESSION['UserId'];
        $this->db->select('
            w.id as wid,
            w.amount,
            w.remarks,
            w.active,
            w.created,
            w.approve,
            w.created,

            s.id as sid,
            s.fname as sfname,
            s.lname as slname,
            s.UID as UID,

            u.id as to_id, 
            u.fname as to_fname,
            u.lname as to_lname,
            u.mobile as to_mobile,

            uu.id as from_id, 
            uu.fname as from_fname,
            uu.lname as from_lname,
            uu.mobile as from_mobile,

            uuu.id as ref_id, 
            uuu.fname as ref_fname,
            uuu.lname as ref_lname,
            uuu.mobile as ref_mobile,
            
        ');
        $this->db->from('refund_request w');
        $this->db->join('user u', 'u.id = w.user_id','left');
        $this->db->join('students s', 's.id = w.student_id','left');
        $this->db->join('user uu', 'uu.id = w.by_user','left');
        $this->db->join('user uuu', 'uuu.id = w.ref_user_id','left');
        $this->db->where('w.user_id',$by_user);
        $this->db->or_where('w.by_user',$by_user);
        $this->db->order_by('w.id','DESC');
        return $this->db->get('')->result_array();
    }

    function get_std_refund_request($student_id){
        
        $this->db->select('
            w.id as wid,
            w.amount,
            w.remarks,
            w.active,
            w.created,
            w.approve,
            w.created,

            s.id as sid,
            s.fname as sfname,
            s.lname as slname,
            s.UID as UID,

            u.id as to_id, 
            u.fname as to_fname,
            u.lname as to_lname,
            u.mobile as to_mobile,

            uu.id as from_id, 
            uu.fname as from_fname,
            uu.lname as from_lname,
            uu.mobile as from_mobile,

            uuu.id as ref_id, 
            uuu.fname as ref_fname,
            uuu.lname as ref_lname,
            uuu.mobile as ref_mobile,
            
        ');
        $this->db->from('refund_request w');
        $this->db->join('user u', 'u.id = w.user_id','left');
        $this->db->join('students s', 's.id = w.student_id','left');
        $this->db->join('user uu', 'uu.id = w.by_user','left');
        $this->db->join('user uuu', 'uuu.id = w.ref_user_id','left');
        $this->db->where('w.student_id',$student_id);
        //$this->db->or_where('w.by_user',$by_user);
        $this->db->order_by('w.id','DESC');
        return $this->db->get('')->result_array();
    } 
        
    /*
     * function to add new refund_request
     */
    function add_refund_request($params)
    {
        $this->db->from('refund_request');
        $this->db->where(array('student_id'=>$params['student_id'], 'active'=>1,'approve!='=>2));
        $count = $this->db->count_all_results();
        if($count==0){
            $this->db->insert('refund_request',$params);
            return $this->db->insert_id();
        }else{
            return 'duplicate';
        }
        
    }    
    /*
     * function to update refund_request
     */
    function update_refund_request($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('refund_request',$params);
    }

    function approve_reject_refund($id,$value){

        $today = date('d-m-Y');
        $todayStr = strtotime($today);
        $params=array('approve'=>$value,'approvedOn'=>$todayStr);
        $this->db->where('id',$id);
        return $this->db->update('refund_request',$params);
    }

    function getStudentId($id){

        $this->db->select('student_id,amount');
        $this->db->from('waiver_request');
        $this->db->where('id',$id);
        return $this->db->get('')->row_array();

    }
    
    /*
     * function to delete refund_request
     */
    function delete_refund_request($id)
    {
        $this->db->delete('refund_request',array('id'=>$id));
        return $this->db->delete('refund_request',array('id'=>$id));
    }
    
}
