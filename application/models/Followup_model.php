<?php
/**
 * @package         WOSA
 * @subpackage      ----------
 * @author          Navjeet
 *
 **/

 
class Followup_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    /*
     * Get followup by id
     */
    function get_followup($id)
    {
        return $this->db->get_where('followup_master',array('id'=>$id))->row_array();
    }
    /*
     * Get all followup count
     */
    function get_all_followup_count()
    {
        $this->db->from('followup_master');
        return $this->db->count_all_results();
    }  
    

    function get_all_followup_active()
    {
        $this->db->where('active', '1');
        $this->db->order_by('title', 'ASC');
        return $this->db->get('followup_master')->result_array();
    }

    function getGenderById($id)
    {
        $this->db->select('gender_name');
        $this->db->where(array('id'=> $id,'active'=>1));
        return $this->db->get('gender')->row_array();
    }

    function get_all_followup()
    {
        $this->db->select('id,title,active');
        $this->db->from('followup_master');
        $this->db->order_by('title', 'ASC');        
        return $this->db->get('')->result_array();
    }
    /*
     * function to add new followup_master
     */
    function add_followup($params)
    {
        $this->db->insert('followup_master',$params);
        return $this->db->insert_id();
    }    
    /*
     * function to update followup_master
     */
    function update_followup($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('followup_master',$params);
    } 
    

    /* check duplicate title*/
    function duplicate_title($title){

        $this->db->where('title', $title);      
        $query = $this->db->get('followup_master');
        $count_row = $query->num_rows();
        if($count_row > 0) {          
            return 'DUPLICATE';
        }else{          
            return 'NOT DUPLICATE';
        }
    }

    function check_mobileInLead($mobile)
    {
        $this->db->from('leads');
        $this->db->where('mobile', $mobile); 
        return $this->db->count_all_results();
    }
    function get_last_leadNo()
    {
        //`lead_uid` FROM `leads`  order by lead_id desc limit 1
        $query = $this->db->query("SELECT `lead_uid` FROM `leads` order by lead_id desc limit 1");
        $row = $query->row();
        return $row->lead_uid;
    }

    function insert_lead($params)
    {
         $this->db->insert('leads',$params);
        return $this->db->insert_id();

    }
function get_all_leads($enquiry_purpose_id,$params = array())
{
//print_r($params);
$con_leadCreateddate = '';$con_active="";$con_pup='';$con_by_user='';
    $lim='';$con_search_text='';$con_lead_via='';
$sear_con="LEFT JOIN lead_followup ON (lead_followup.lead_id=leads.lead_id AND `flag`=1)";

if(!empty($params['search_text']))
{
    $con_search_text="AND (leads.fname LIKE '%".$params['search_text']."%' OR lead_uid LIKE '%".$params['search_text']."%' OR leads.email  LIKE '%".$params['search_text']."%' OR leads.mobile LIKE '%".$params['search_text']."%')";
}
if(!empty($params['lead_via']))
{
    $con_lead_via="AND lead_via='".$params['lead_via']."'";
}
if(!empty($params['active']))
{
    $con_active="AND leads.active='".$params['active']."'";
}
if(!empty($params['by_user']))
{
    $con_by_user="AND leads.by_user='".$params['by_user']."'";
}

if(!empty($params['leadCreateddate']))
{
    $leadCreateddate= explode(' - ',$params['leadCreateddate']);
    $leadCreateddate1=date_create($leadCreateddate[0]);
    $leadCreateddate1=date_format($leadCreateddate1,'d-m-Y');

    $leadCreateddate2=date_create($leadCreateddate[1]);
    $leadCreateddate2=date_format($leadCreateddate2,'d-m-Y');

    $minvalue_leadCreateddate=$leadCreateddate1;
    $maxvalue_leadCreateddate=$leadCreateddate2;
    $con_leadCreateddate.="AND leads.`todayDate` BETWEEN  '".$minvalue_leadCreateddate."' AND  '".$maxvalue_leadCreateddate."'";
}
if(!empty($params['enquiry_purpose_id']))
{
    $con_pup="AND leads.enquiry_purpose_id='".$params['enquiry_purpose_id']."'";
}

if(!empty($params['nxt_followupdate']) OR !empty($params['option_followup_status']) OR !empty($params['last_followupdate']))

    {
$con_nextdate="";
if(!empty($params['nxt_followupdate']))
{    
    $book_p= explode(' - ',$params['nxt_followupdate']);
    $minvalue_book_p=$book_p[0]." 00:00:00";
    $maxvalue_book_p=$book_p[1]." 23:59:59";
    $con_nextdate.="AND `next_followupdatetime` BETWEEN  '".$minvalue_book_p."' AND  '".$maxvalue_book_p."'";
}
if(!empty($params['last_followupdate']))
{    
    $book_last= explode(' - ',$params['last_followupdate']);
    $minvalue_book_last=$book_last[0]." 00:00:00";
    $maxvalue_book_last=$book_last[1]." 23:59:59";
    $con_nextdate.="AND `last_followupdatetime` BETWEEN  '".$minvalue_book_last."' AND  '".$maxvalue_book_last."'";
}
if(!empty($params['option_followup_status']))
{    
    $option_followup_status=$params['option_followup_status'];
     $con_nextdate.="AND `followup_status` ='".$option_followup_status."'";
}

 $sear_con="INNER JOIN lead_followup ON (lead_followup.lead_id=leads.lead_id AND `flag`=1 ".$con_nextdate.")";
}
if(isset($params) && !empty($params))
        {
            //$this->db->limit($params['limit'], $params['offset']);
            $lim="limit ".$params['offset'].','.$params['limit'];
        } 

        $query = $this->db->query("SELECT leads.`lead_id`, leads.`lead_uid`, leads.`fname`, leads.`lname`, leads.`email`, leads.`country_code`, leads.`mobile`, leads.`dob`, leads.`todayDate`, leads.`lead_via`, leads.`message`, leads.`created`, leads.`active`, enquiry_purpose_masters.`enquiry_purpose_name`,lead_followup.last_followupdatetime,lead_followup.next_followupdatetime,lead_followup.followup_status,lead_followup.followup_remark,leads.by_user,CONCAT(user.fname , ' ' , user.lname,' (',user.employeeCode,')') AS createdByName FROM `leads` LEFT JOIN enquiry_purpose_masters ON enquiry_purpose_masters.id = leads.enquiry_purpose_id LEFT JOIN user ON user.id=leads.by_user  $sear_con  WHERE 1 $con_search_text $con_lead_via $con_active $con_leadCreateddate $con_pup $con_by_user group by leads.lead_id order by lead_id DESC $lim");      
       
            return $query->result_array();    
            die();  
}

function get_all_leads_count($enquiry_purpose_id,$params = array())
{
    $con_lead_via ='';$con_leadCreateddate='';$con_active='';$con_pup='';$con_by_user='';
    $lim='';
if(isset($params) && !empty($params))
        {
            //$this->db->limit($params['limit'], $params['offset']);
            $lim="limit ".$params['offset'].','.$params['limit'];
        } 
$sear_con="LEFT JOIN lead_followup ON (lead_followup.lead_id=leads.lead_id AND `flag`=1)";

if(!empty($params['search_text']))
{
    $con_search_text="AND (fname LIKE '%".$params['search_text']."%' OR lead_uid LIKE '%".$params['search_text']."%' OR email  LIKE '%".$params['search_text']."%' OR mobile LIKE '%".$params['search_text']."%')";
}
if(!empty($params['lead_via']))
{
    $con_lead_via="AND lead_via='".$params['lead_via']."'";
}
if(!empty($params['active']))
{
    $con_active="AND leads.active='".$params['active']."'";
}
if(!empty($params['by_user']))
{
    $con_by_user="AND leads.by_user='".$params['by_user']."'";
}

if(!empty($params['leadCreateddate']))
{
    $leadCreateddate= explode(' - ',$params['leadCreateddate']);
    $leadCreateddate1=date_create($leadCreateddate[0]);
    $leadCreateddate1=date_format($leadCreateddate1,'d-m-Y');

    $leadCreateddate2=date_create($leadCreateddate[1]);
    $leadCreateddate2=date_format($leadCreateddate2,'d-m-Y');

    $minvalue_leadCreateddate=$leadCreateddate1;
    $maxvalue_leadCreateddate=$leadCreateddate2;
    $con_leadCreateddate.="AND leads.`todayDate` BETWEEN  '".$minvalue_leadCreateddate."' AND  '".$maxvalue_leadCreateddate."'";
}
if(!empty($params['enquiry_purpose_id']))
{
    $con_pup="AND leads.enquiry_purpose_id='".$params['enquiry_purpose_id']."'";
}

if(!empty($params['nxt_followupdate']) OR !empty($params['option_followup_status']) OR !empty($params['last_followupdate']))

    {
$con_nextdate="";
if(!empty($params['nxt_followupdate']))
{    
    $book_p= explode(' - ',$params['nxt_followupdate']);
    $minvalue_book_p=$book_p[0]." 00:00:00";
    $maxvalue_book_p=$book_p[1]." 23:59:59";
    $con_nextdate.="AND `next_followupdatetime` BETWEEN  '".$minvalue_book_p."' AND  '".$maxvalue_book_p."'";
}
if(!empty($params['last_followupdate']))
{    
    $book_last= explode(' - ',$params['last_followupdate']);
    $minvalue_book_last=$book_last[0]." 00:00:00";
    $maxvalue_book_last=$book_last[1]." 23:59:59";
    $con_nextdate.="AND `last_followupdatetime` BETWEEN  '".$minvalue_book_last."' AND  '".$maxvalue_book_last."'";
}
if(!empty($params['option_followup_status']))
{    
    $option_followup_status=$params['option_followup_status'];
     $con_nextdate.="AND `followup_status` ='".$option_followup_status."'";
}

 $sear_con="INNER JOIN lead_followup ON (lead_followup.lead_id=leads.lead_id AND `flag`=1 ".$con_nextdate.")";
}
       // $sear_con="LEFT JOIN lead_followup ON (lead_followup.lead_id=leads.lead_id AND `flag`=1)";

         $query_st = "SELECT leads.`lead_id`, leads.`lead_uid`, leads.`fname`, leads.`lname`, leads.`email`, leads.`country_code`, leads.`mobile`, leads.`dob`, leads.`todayDate`, leads.`lead_via`, leads.`message`, leads.`created`, leads.`active`, enquiry_purpose_masters.`enquiry_purpose_name`,lead_followup.last_followupdatetime,lead_followup.next_followupdatetime,lead_followup.followup_status FROM `leads` LEFT JOIN enquiry_purpose_masters ON enquiry_purpose_masters.id = leads.enquiry_purpose_id  $sear_con  WHERE 1 $con_leadCreateddate "; 
         if($con_active != "")
         {
            $query_st .= $con_active;
         }
         if($con_lead_via != "")
         {
            $query_st .= $con_search_text;
         }
         if($con_lead_via != "")
         {
            $query_st .= $con_lead_via;
         }
         if($con_leadCreateddate != "")
         {
            $query_st .= $con_leadCreateddate;
         }
         $query_st .= "$con_pup $con_by_user group by leads.lead_id $lim";
         $query =  $this->db->query($query_st);    
          return $query->num_rows();
             //return $query->result_array();
            //return $query->count_all_results();  
            die(); 

       /* $this->db->from('leads se');
        $this->db->join('`enquiry_purpose_masters` epm', 'epm.`id`= se.`enquiry_purpose_id`', 'left');
        if($enquiry_purpose_id>0){
           $this->db->where('enquiry_purpose_id',$enquiry_purpose_id); 
        }else{} 

        return $this->db->count_all_results();*/
    } 

     function getLeadStatusById($id)
    {
        $this->db->select('active');
        $this->db->where(array('lead_id'=> $id));
        return $this->db->get('leads')->row_array();
    }

    /*
     * function to update followup_master
     */
    function update_leads($id,$params)
    {
        $this->db->where('lead_id',$id);
        return $this->db->update('leads',$params);
    } 

    /*
     * function to add new leads followup
     */
    function followup_create($params)
    {
        $this->db->insert('lead_followup',$params);
        return $this->db->insert_id();
    } 

    function view_followup($lead_id)
    {    
        $this->db->select('followup_status,next_followupdatetime,followup_remark,title');
        $this->db->from('lead_followup');
        $this->db->order_by('followupId', 'DESC'); 
        $this->db->join('`followup_master`', 'followup_master.`id`= lead_followup.`followup_status`', 'inner');  
        $this->db->where(array('lead_id'=> $lead_id));     
        return $this->db->get('')->result_array();      
    } 
    function getLastFollowupDetail($id)
    {
        $this->db->select('followup_status,last_followupdatetime,next_followupdatetime');
        $this->db->where(array('lead_id'=> $id));
        $this->db->limit(1);
        $this->db->order_by('followupId','desc');   
        return $this->db->get('lead_followup')->row_array();
    }

    function update_followupleads($id,$params)
    {
        $this->db->where('lead_id',$id);
        return $this->db->update('lead_followup',$params);
    } 
    function get_todayleads()
    {
       $today=date('Y-m-d');
       $sear_con="INNER JOIN lead_followup ON (lead_followup.lead_id=leads.lead_id AND `flag`=1 and lead_followup.next_followupdatetime like '%".$today."%')"; 
        $query = $this->db->query("SELECT leads.`lead_id`, leads.`lead_uid`, leads.`fname`, leads.`lname`, leads.`email`, leads.`country_code`, leads.`mobile`, leads.`dob`, leads.`todayDate`, leads.`lead_via`, leads.`message`, leads.`created`, leads.`active`, enquiry_purpose_masters.`enquiry_purpose_name`,lead_followup.last_followupdatetime,lead_followup.next_followupdatetime,lead_followup.followup_status,leads.by_user,CONCAT(user.fname , ' ' , user.lname,' (',user.employeeCode,')') AS createdByName FROM `leads` LEFT JOIN enquiry_purpose_masters ON enquiry_purpose_masters.id = leads.enquiry_purpose_id LEFT JOIN user ON user.id=leads.by_user $sear_con  WHERE 1  group by leads.lead_id ");      
        $num= $query->num_rows();
         return $query->result_array();
        if($num >0)
        {

        }

    }

    function get_leadNo_Byid($id)
    {
        $this->db->select('lead_uid');
        $this->db->where('lead_id',$id);         
        return $this->db->get('leads')->row_array();
    }

    
}
