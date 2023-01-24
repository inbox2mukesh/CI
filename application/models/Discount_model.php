<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Prabhat
 *
 **/

class Discount_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getPromocode($promoCodeId){

        //$this->db->select('discount_code');
        $this->db->select('*');
        $this->db->from('`discount`');     
        $this->db->where(array('id'=>$promoCodeId));
        return $this->db->get('')->row_array();
    }

    function getBulkPromocode($bulk_id,$promoCodeId){

        $this->db->select('discount_code');
        $this->db->from('`discount_bulk`');     
        $this->db->where(array('bulk_id'=>$bulk_id,'discount_id'=>$promoCodeId));
        return $this->db->get('')->row_array();
    }

    function getBulkPromocodeId($bulk_promocode){

        $this->db->select('db.discount_id,db.bulk_id');
        $this->db->from('`discount_bulk` db');  
        $this->db->join('`discount` d', 'd.`id`= db.`discount_id`');     
        $this->db->where(array('db.discount_code'=>$bulk_promocode,'db.active'=>1,'d.active'=>1));
        return $this->db->get('')->row_array();
    }

    function getBulkRemainingPromocodeCountByPromocodeId($promocodeId,$showAll=false) {
        $this->db->select('*');
        $this->db->from('`discount_bulk` db');  
        $this->db->join('`discount` d', 'd.`id`= db.`discount_id`');     
        $this->db->where("db.discount_id = $promocodeId");

        if(!$showAll) {
            $this->db->where('db.active = 1');
        }
        return $this->db->count_all_results();
    }

    function deactivate_discount($todaystr){

        $params = array('active'=> 0);
        $this->db->where('`strEndDate`<=',$todaystr);
        return $this->db->update('discount',$params);
        //print_r($this->db->last_query());exit;
    }

    function update_remaining_uses($promoCodeId){

        return $this->db->query("update `discount` SET 
            `remaining_uses` = `remaining_uses`-1
            where id = '".$promoCodeId."' 
        ");
    }

    function update_bulk_remaining_uses($bulk_id,$promoCodeId){

        return $this->db->query("update `discount_bulk` SET 
            `active` = 0
            where discount_id = '".$promoCodeId."' and bulk_id = '".$bulk_id."'
        ");
    }
       
    function getApplicableGeneralPromocode_forOffline($package_id,$type_of_discount,$appliedProducts,$center_id,$country_id,$test_module_id,$packPrice,$currentDateTimeStr){
    	 
  		$where='';
  		$where .= "FIND_IN_SET('".$center_id."', d.`appliedBranches`) AND ";
  		$where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`) AND ";
  		$where .= "FIND_IN_SET('".$package_id."', d.`appliedPackages`)";

    	$this->db->select('d.id,d.start_date,d.start_time,d.end_date,d.end_time,d.disc_name,d.discount_code,d.type_of_discount,d.discount_type,d.max_discount,d.not_exceeding,d.min_purchase_value,d.uses_per_user,cnt.name');
        $this->db->from('discount d');
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`'); 
        $this->db->where(array('d.type_of_discount'=> $type_of_discount,'d.appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.country_id'=> $country_id,'d.remaining_uses>'=>0));
        $this->db->where($where);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function isApplicableBulkPromocode_forOffline($package_id,$type_of_discount,$appliedProducts,$center_id,$country_id,$test_module_id,$packPrice,$currentDateTimeStr,$bulk_promocode){
         
        $where='';
        $where .= "FIND_IN_SET('".$center_id."', d.`appliedBranches`) AND ";
        $where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`) AND ";
        $where .= "FIND_IN_SET('".$package_id."', d.`appliedPackages`)";

        $this->db->select('d.id');
        $this->db->from('discount d');
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`');
        $this->db->join('`discount_bulk` db', 'db.`discount_id`= d.`id`'); 
        $this->db->where(array('d.type_of_discount'=> $type_of_discount,'d.appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.country_id'=> $country_id,'d.remaining_uses>'=>0,'db.discount_code'=>$bulk_promocode));
        $this->db->where($where);
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }

    function getApplicableGeneralPromocode_forOnline($package_id,$type_of_discount,$appliedProducts,$center_id,$test_module_id,$packPrice,$currentDateTimeStr){
    	 
  		$where='';
  		$where .= "FIND_IN_SET('".$center_id."', d.`appliedBranches`) AND ";
  		$where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`) AND ";
  		$where .= "FIND_IN_SET('".$package_id."', d.`appliedPackages`)";

    	$this->db->select('d.id,d.start_date,d.start_time,d.end_date,d.end_time,d.disc_name,d.discount_code,d.type_of_discount,d.discount_type,d.max_discount,d.not_exceeding,d.min_purchase_value,d.uses_per_user,cnt.name');
        $this->db->from('discount d'); 
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`');        
        $this->db->where(array('d.type_of_discount'=> $type_of_discount,'d.appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.remaining_uses>'=>0));
        $this->db->where($where);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }  

    function isApplicableBulkPromocode_forOnline($package_id,$type_of_discount,$appliedProducts,$center_id,$test_module_id,$packPrice,$currentDateTimeStr,$bulk_promocode){
         
        $where='';
        $where .= "FIND_IN_SET('".$center_id."', d.`appliedBranches`) AND ";
        $where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`) AND ";
        $where .= "FIND_IN_SET('".$package_id."', d.`appliedPackages`)";

        $this->db->select('d.id');
        $this->db->from('discount d'); 
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`');
        $this->db->join('`discount_bulk` db', 'db.`discount_id`= d.`id`');        
        $this->db->where(array('d.type_of_discount'=> $type_of_discount,'d.appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.remaining_uses>'=>0,'db.discount_code'=>$bulk_promocode));
        $this->db->where($where);
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }

    function getApplicableGeneralPromocode_forPracticePack($package_id,$type_of_discount,$appliedProducts,$center_id,$test_module_id,$packPrice,$currentDateTimeStr){

    	$where='';
  		$where .= "FIND_IN_SET('".$center_id."', d.`appliedBranches`) AND ";
  		$where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`) AND ";
  		$where .= "FIND_IN_SET('".$package_id."', d.`appliedPackages`)";

    	$this->db->select('d.id,d.start_date,d.start_time,d.end_date,d.end_time,d.disc_name,d.discount_code,d.type_of_discount,d.discount_type,d.max_discount,d.not_exceeding,d.min_purchase_value,d.uses_per_user,cnt.name');
        $this->db->from('discount d');  
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`');       
        $this->db->where(array('d.type_of_discount'=> $type_of_discount,'d.appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.remaining_uses>'=>0));
        $this->db->where($where);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;

    }

    function isApplicableBulkPromocode_forPracticePack($package_id,$type_of_discount,$appliedProducts,$center_id,$test_module_id,$packPrice,$currentDateTimeStr,$bulk_promocode){

        $where='';
        $where .= "FIND_IN_SET('".$center_id."', d.`appliedBranches`) AND ";
        $where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`) AND ";
        $where .= "FIND_IN_SET('".$package_id."', d.`appliedPackages`)";

        $this->db->select('d.id');
        $this->db->from('discount d');  
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`');
        $this->db->join('`discount_bulk` db', 'db.`discount_id`= d.`id`');       
        $this->db->where(array('d.type_of_discount'=> $type_of_discount,'d.appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.remaining_uses>'=>0,'db.discount_code'=>$bulk_promocode));
        $this->db->where($where);
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;

    }

    function getApplicableGeneralPromocode_forRealityTest($appliedProducts,$type_of_discount,$test_module_id,$packPrice,$currentDateTimeStr){

    	$where='';
  		$where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`) ";

    	$this->db->select('d.id,d.start_date,d.start_time,d.end_date,d.end_time,d.disc_name,d.discount_code,d.type_of_discount,d.discount_type,d.max_discount,d.not_exceeding,d.min_purchase_value,d.uses_per_user,cnt.name');
        $this->db->from('discount d');  
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`');       
        $this->db->where(array('d.type_of_discount'=> $type_of_discount,'d.appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.remaining_uses>'=>0));
        $this->db->where($where);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function isApplicableBulkPromocode_forRealityTest($appliedProducts,$type_of_discount,$test_module_id,$packPrice,$currentDateTimeStr,$bulk_promocode){

        $where='';
        $where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`) ";

        $this->db->select('d.id');
        $this->db->from('discount d');  
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`');   
        $this->db->join('`discount_bulk` db', 'db.`discount_id`= d.`id`');    
        $this->db->where(array('d.type_of_discount'=> $type_of_discount,'d.appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.remaining_uses>'=>0,'db.discount_code'=>$bulk_promocode));
        $this->db->where($where);
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }    

    function getApplicableSpecialPromocode($package_id,$type_of_discount,$appliedProducts,$center_id,$country_id,$test_module_id,$packPrice,$email,$mobile,$currentDateTimeStr){

        $where='';
        if($center_id){
        	$where .= "FIND_IN_SET('".$center_id."', d.`appliedBranches`) AND ";
        	$where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`) AND ";
  			$where .= "FIND_IN_SET('".$package_id."', d.`appliedPackages`)";
        }else{        	
        	$where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`) AND ";
  			$where .= "FIND_IN_SET('".$package_id."', d.`appliedPackages`)";
        }

    	$this->db->select('d.id,d.start_date,d.start_time,d.end_date,d.end_time,d.disc_name,d.discount_code,d.type_of_discount,d.discount_type,d.max_discount,d.not_exceeding,d.min_purchase_value,d.uses_per_user,cnt.name');
        $this->db->from('discount d');
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`');
        $this->db->where(array('d.country_id'=> $country_id, 'd.type_of_discount'=> $type_of_discount,'appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.remaining_uses>'=>0));
        $this->db->where($where);
        $this->db->group_start();
            $this->db->or_where('email',$email);
            $this->db->or_where('phoneNumber',$mobile);
        $this->db->group_end();
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getApplicableSpecialPromocode_rt($package_id,$type_of_discount,$appliedProducts,$test_module_id,$packPrice,$email,$mobile,$currentDateTimeStr){

        $where='';        
        $where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`)";

        $this->db->select('d.id,d.start_date,d.start_time,d.end_date,d.end_time,d.disc_name,d.discount_code,d.type_of_discount,d.discount_type,d.max_discount,d.not_exceeding,d.min_purchase_value,d.uses_per_user,cnt.name');
        $this->db->from('discount d');
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`');
        $this->db->where(array('d.country_id'=> @$country_id, 'd.type_of_discount'=> $type_of_discount,'appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.remaining_uses>'=>0));
        $this->db->where($where);
        $this->db->group_start();
            $this->db->or_where('email',$email);
            $this->db->or_where('phoneNumber',$mobile);
        $this->db->group_end();
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getApplicableSpecialPromocode_eb($type_of_discount,$appliedProducts,$test_module_id,$packPrice,$email,$mobile,$currentDateTimeStr){

        $where='';        
        $where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`)";

        $this->db->select('d.id,d.start_date,d.start_time,d.end_date,d.end_time,d.disc_name,d.discount_code,d.type_of_discount,d.discount_type,d.max_discount,d.not_exceeding,d.min_purchase_value,d.uses_per_user,cnt.name');
        $this->db->from('discount d');
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`');
        $this->db->where(array('d.type_of_discount'=> $type_of_discount,'d.appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.remaining_uses>'=>0));
        $this->db->where($where);$this->db->group_start();
            $this->db->or_where('email',$email);
            $this->db->or_where('phoneNumber',$mobile);
        $this->db->group_end();
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }


    function getApplicableGeneralPromocode_exam($appliedProducts,$type_of_discount,$test_module_id,$packPrice,$currentDateTimeStr){

        $where='';
        $where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`) ";

        $this->db->select('d.id,d.start_date,d.start_time,d.end_date,d.end_time,d.disc_name,d.discount_code,d.type_of_discount,d.discount_type,d.max_discount,d.not_exceeding,d.min_purchase_value,d.uses_per_user,cnt.name');
        $this->db->from('discount d');  
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`');       
        $this->db->where(array('d.type_of_discount'=> $type_of_discount,'d.appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.remaining_uses>'=>0));
        $this->db->where($where);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function isApplicableBulkPromocode_exam($appliedProducts,$type_of_discount,$test_module_id,$packPrice,$currentDateTimeStr,$bulk_promocode){

        $where='';
        $where .= "FIND_IN_SET('".$test_module_id."', d.`appliedTestType`) ";

        $this->db->select('d.id');
        $this->db->from('discount d');  
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`');
        $this->db->join('`discount_bulk` db', 'db.`discount_id`= d.`id`');       
        $this->db->where(array('d.type_of_discount'=> $type_of_discount,'d.appliedProducts'=> $appliedProducts,'d.active'=>1,'d.min_purchase_value<='=> $packPrice,'d.remaining_uses>'=>0,'db.discount_code'=>$bulk_promocode));
        $this->db->where($where);
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }

    function getSpecialPromocodes($mobile,$email){
                
        $this->db->select('d.end_date,d.end_time,d.discount_code,d.discount_type,d.max_discount,d.not_exceeding,d.min_purchase_value,uses_per_user,d.active');
        $this->db->from('discount d');        
        $this->db->where(array('d.remaining_uses>'=>0));
        $this->db->group_start();
            $this->db->or_where('email',$email);
            $this->db->or_where('phoneNumber',$mobile);
        $this->db->group_end();
        $this->db->order_by('d.strEndDate','ASC');
        $this->db->limit(3);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getDiscountRanges($id){

    	$this->db->select('range_from,range_to,range_discount');
        $this->db->from('discount_ranges');
        $this->db->where('discount_id',$id);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getDiscountDetailsForApply($id){

        $this->db->select('`strDate`, `strEndDate`, `disc_name`, `type_of_discount`, `discount_type`, `max_discount`, `not_exceeding`, `min_purchase_value`, `user_per_code`, `uses_per_user`, `remaining_uses`, `appliedProducts`, `discount_code`,cnt.currency_code');
        $this->db->from('discount d');
        $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`'); 
        $this->db->where('d.id',$id);
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }

    function getStudentPromocodeValidity($promoCodeId,$student_id){

        $this->db->from('student_promocodes');
        $this->db->where(array('student_id'=>$student_id,'promoCodeId'=>$promoCodeId,'bulk_id'=>0));
        return $this->db->count_all_results();
    }

    function getStudentBulkPromocodeValidity($promoCodeId,$bulk_id,$student_id){

        $this->db->from('student_promocodes');
        $this->db->where(array('student_id'=>$student_id,'promoCodeId'=>$promoCodeId,'bulk_id>'=>0));
        return $this->db->count_all_results();
    }

    function checkrangeCount($promoCodeId){

        $this->db->from('discount_ranges');
        $this->db->where(array('discount_id'=>$promoCodeId));
        return $this->db->count_all_results();
    }

    function finalRangeDiscount($promoCodeId,$packPrice){

        $this->db->select('range_discount');
        $this->db->from('discount_ranges');        
        $this->db->where(array('discount_id'=>$promoCodeId,'range_from<='=>$packPrice,'range_to>='=>$packPrice));
        return $this->db->get('')->row_array();
    }

    function get_discount($id)
    {
        return $this->db->get_where('discount',array('id'=>$id))->row_array();
    } 
	
	function get_range_discount($id)
    {

        $this->db->from('discount_ranges');        
        $this->db->where(array('discount_id'=>$id));
		$this->db->order_by('disc_rangeId','ASC');
        return $this->db->get('')->result_array();		
       // return $this->db->get_where('discount_ranges',array('discount_id'=>$id))->row_array();
    }  

    function get_byUser($id){

        $this->db->select('by_user');
        $this->db->from('discount');        
        $this->db->where(array('id'=>$id));
        return $this->db->get('')->row_array();
    }

    function get_all_discount_count()
    {
        $this->db->from('discount');
        return $this->db->count_all_results();
    }

    function get_all_general_discount_count($roleName,$params = array()){
        $by_user= $_SESSION['UserId'];
        $this->db->select('
            *
        ');		
        $this->db->from('discount dnt');
        $this->db->join('`discount_countries` dc', 'dc.`discount_id`=dnt.`id`');
		$this->db->join('`country` cnt', 'cnt.`country_id`=dc.`country_id`');
        if($roleName!=ADMIN){  
		$this->db->where('dnt.by_user',$by_user);
        }
		$this->db->where('dnt.type_of_discount','General');
        $this->db->order_by('dnt.id','DESC');
        return $this->db->count_all_results();

        //    $by_user= $_SESSION['UserId'];
        //     $this->db->select('
        //         *
        //     ');		
        //     $this->db->from('discount dnt');
        // 	$this->db->join('`country` cnt', 'cnt.`country_id`=dnt.`country_id`');
        //     if($roleName!=ADMIN){  
        // 	$this->db->where('dnt.by_user',$by_user);
        //     }
        // 	$this->db->where('dnt.type_of_discount','General');
        //     $this->db->order_by('dnt.id','DESC');
        //     return $this->db->count_all_results();
    }
	
	function get_all_special_discount_count($roleName,$params = array())
    {
        $by_user= $_SESSION['UserId'];
        $this->db->select('*');
        $this->db->from('discount dnt');
        $this->db->join('discount_countries dc','dc.discount_id = dnt.id');
		$this->db->join('`country` cnt', 'cnt.`country_id` = dc.`country_id`');
        if($roleName!=ADMIN){  
		    $this->db->where('dnt.by_user',$by_user);
        }
		$this->db->where('dnt.type_of_discount','Special');
        $this->db->order_by('dnt.id','DESC');
        return $this->db->count_all_results();
	    /* 
        $this->db->select('
            *
        ');
        $this->db->from('discount dnt');
		$this->db->join('`country` cnt', 'cnt.`country_id`=dnt.`country_id`');
        if($roleName!=ADMIN){  
		$this->db->where('dnt.by_user',$by_user);
        }
		$this->db->where('dnt.type_of_discount','Special');
        $this->db->order_by('dnt.id','DESC');
        return $this->db->count_all_results(); */
    }
	
	function get_all_bulk_discount_count($roleName,$params = array())
    {
	    $by_user= $_SESSION['UserId'];
        $this->db->select('*');
        $this->db->from('discount dnt');
        $this->db->join('`discount_countries` dc', 'dc.`discount_id` = dnt.`id`');
		$this->db->join('`country` cnt', 'cnt.`country_id` = dc.`country_id`');
        if($roleName!=ADMIN){  
		$this->db->where('dnt.by_user',$by_user);
        }
		$this->db->where('dnt.type_of_discount','Bulk');
        $this->db->order_by('dnt.id','DESC');
        return $this->db->count_all_results();
    }
    
    function get_all_discount($params = array()){
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $by_user= $_SESSION['UserId'];
        $this->db->select('
            *
        ');
        $this->db->select('cnt.name,dnt.*');
		$this->db->from('discount dnt');
		$this->db->join('`country` cnt', 'cnt.`country_id`=dnt.`country_id`');
        $this->db->where('dnt.by_user',$by_user);
		$this->db->where('dnt.type_of_discount','General');
        $this->db->order_by('dnt.id','DESC');
        return $this->db->get('')->result_array();
    }
	
	 
	
	function get_all_discount_general($roleName,$params = array()){
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $by_user= $_SESSION['UserId'];

        //$this->db->select('*');
		$this->db->select('cnt.name,dnt.*');
        $this->db->from('discount dnt');
        $this->db->join('`discount_countries` dc', 'dc.`discount_id`= dnt.`id`');
		$this->db->join('`country` cnt', 'cnt.`country_id` = dc.`country_id`');
		
        if($roleName!=ADMIN){
		    $this->db->where('dnt.by_user',$by_user);
        }
		
		$this->db->where('dnt.type_of_discount','General');
		if(!empty($params['dData']['txtSearch'])){
	
		    //$this->db->like('dnt.disc_name',$params['dData']['txtSearch']);
		    $where = '(dnt.disc_name like "%'.$params['dData']['txtSearch'].'%" or dnt.discount_code like "%'.$params['dData']['txtSearch'].'%")';
		    $this->db->where($where);
		} else {
	
            if(!empty($params['dData']['country_id'])){
                //print_r($params['dData']);
                $country_id=implode(",",$params['dData']['country_id']);
                //echo $country_id;
                $this->db->where("dc.country_id IN (".$country_id.")",NULL, false);
                
                }
                
                if(!empty($params['dData']['appliedProducts'])){
                $appliedProducts=$params['dData']['appliedProducts'];
                //$this->db->where("dnt.appliedProducts IN (".$appliedProducts.")",NULL, false);
                $this->db->where('dnt.appliedProducts',$appliedProducts);
                }
                
                if(!empty($params['dData']['appliedBranches'])){
                $appliedBranches=implode("|",$params['dData']['appliedBranches']);
                //$this->db->where("dnt.appliedBranches IN (".$appliedBranches.")",NULL, false);
                $this->db->where('CONCAT(",", dnt.appliedBranches, ",") REGEXP ",('.$appliedBranches.'),"');
                //$this->db->where_in('dnt.appliedBranches',str_replace("'","",$appliedBranches));
                }
                
                
                if(!empty($params['dData']['appliedTestType'])){
                $appliedTestType=implode("|",$params['dData']['appliedTestType']);
                //$this->db->where("dnt.appliedTestType1 IN (".$appliedTestType.")",NULL, false);
                $this->db->where('CONCAT(",", dnt.appliedTestType, ",") REGEXP ",('.$appliedTestType.'),"');

                //$this->db->where_in('dnt.appliedTestType',str_replace("'","",$appliedTestType));
                }
                
                
                if(!empty($params['dData']['appliedPackages'])){
                $appliedPackages=implode("|",$params['dData']['appliedPackages']);
                $this->db->where('CONCAT(",", dnt.appliedPackages, ",") REGEXP ",('.$appliedPackages.'),"');
                //$this->db->where("dnt.appliedPackages IN (".$appliedPackages.")",NULL, false);
                //$this->db->where_in('dnt.appliedPackages',str_replace("'","",$appliedPackages));
                }
                
                if(!empty($params['dData']['status'])){
                $this->db->where('dnt.active',$params['dData']['status']);
                }
                
                if(!empty($params['dData']['start_date']) && empty($params['dData']['end_date'])){
                $this->db->where('dnt.start_date',date('Y-m-d', strtotime($params['dData']['start_date'])));
                }
                
                if(!empty($params['dData']['end_date']) && empty($params['dData']['start_date'])){
                $this->db->where('dnt.end_date',date('Y-m-d', strtotime($params['dData']['start_date'])));
                }
                
                if(!empty($params['dData']['end_date']) && !empty($params['dData']['start_date'])){
                $this->db->where('(start_date BETWEEN "'. date('Y-m-d', strtotime($params['dData']['start_date'])). '" and "'. date('Y-m-d', strtotime($params['dData']['end_date'])).'" or end_date BETWEEN "'. date('Y-m-d', strtotime($params['dData']['start_date'])). '" and "'. date('Y-m-d', strtotime($params['dData']['end_date'])).'")');
                }
            
            }
            $this->db->order_by('dnt.id','DESC');
            return $this->db->get('')->result_array();
		
        /* if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $by_user= $_SESSION['UserId'];
        $this->db->select('
            *
        ');
		
		
		
		$this->db->select('cnt.name,dnt.*');
        $this->db->from('discount dnt');
		$this->db->join('`country` cnt', 'cnt.`country_id`=dnt.`country_id`');
		
       if($roleName!=ADMIN){  
		$this->db->where('dnt.by_user',$by_user);
        }
		
		$this->db->where('dnt.type_of_discount','General');
		if(!empty($params['dData']['txtSearch'])){
	
		//$this->db->like('dnt.disc_name',$params['dData']['txtSearch']);
		$where = '(dnt.disc_name like "%'.$params['dData']['txtSearch'].'%" or dnt.discount_code like "%'.$params['dData']['txtSearch'].'%")';
		$this->db->where($where);
		} else {
	
if(!empty($params['dData']['country_id'])){
			//print_r($params['dData']);
			$country_id=implode(",",$params['dData']['country_id']);
			//echo $country_id;
			$this->db->where("dnt.country_id IN (".$country_id.")",NULL, false);
			
			}
			
			if(!empty($params['dData']['appliedProducts'])){
			$appliedProducts=$params['dData']['appliedProducts'];
			//$this->db->where("dnt.appliedProducts IN (".$appliedProducts.")",NULL, false);
			$this->db->where('dnt.appliedProducts',$appliedProducts);
			}
			
			if(!empty($params['dData']['appliedBranches'])){
			$appliedBranches=implode("|",$params['dData']['appliedBranches']);
			//$this->db->where("dnt.appliedBranches IN (".$appliedBranches.")",NULL, false);
			$this->db->where('CONCAT(",", dnt.appliedBranches, ",") REGEXP ",('.$appliedBranches.'),"');
			//$this->db->where_in('dnt.appliedBranches',str_replace("'","",$appliedBranches));
			}
			
			
			if(!empty($params['dData']['appliedTestType'])){
			$appliedTestType=implode("|",$params['dData']['appliedTestType']);
			//$this->db->where("dnt.appliedTestType1 IN (".$appliedTestType.")",NULL, false);
			$this->db->where('CONCAT(",", dnt.appliedTestType, ",") REGEXP ",('.$appliedTestType.'),"');

			//$this->db->where_in('dnt.appliedTestType',str_replace("'","",$appliedTestType));
			}
			
			
			if(!empty($params['dData']['appliedPackages'])){
			$appliedPackages=implode("|",$params['dData']['appliedPackages']);
			$this->db->where('CONCAT(",", dnt.appliedPackages, ",") REGEXP ",('.$appliedPackages.'),"');
			//$this->db->where("dnt.appliedPackages IN (".$appliedPackages.")",NULL, false);
			//$this->db->where_in('dnt.appliedPackages',str_replace("'","",$appliedPackages));
			}
			
			if(!empty($params['dData']['status'])){
			$this->db->where('dnt.active',$params['dData']['status']);
			}
			
			if(!empty($params['dData']['start_date']) && empty($params['dData']['end_date'])){
			$this->db->where('dnt.start_date',date('Y-m-d', strtotime($params['dData']['start_date'])));
			}
			
			if(!empty($params['dData']['end_date']) && empty($params['dData']['start_date'])){
			$this->db->where('dnt.end_date',date('Y-m-d', strtotime($params['dData']['start_date'])));
			}
			
			if(!empty($params['dData']['end_date']) && !empty($params['dData']['start_date'])){
			$this->db->where('(start_date BETWEEN "'. date('Y-m-d', strtotime($params['dData']['start_date'])). '" and "'. date('Y-m-d', strtotime($params['dData']['end_date'])).'" or end_date BETWEEN "'. date('Y-m-d', strtotime($params['dData']['start_date'])). '" and "'. date('Y-m-d', strtotime($params['dData']['end_date'])).'")');
			}
		
		}
        $this->db->order_by('dnt.id','DESC');
        return $this->db->get('')->result_array(); */
    }
	
	
	 function get_all_discount_special($roleName,$params = array()){
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $by_user= $_SESSION['UserId'];
        //$this->db->select('*');
		$this->db->select('cnt.name,dnt.*');
        $this->db->from('discount dnt');
        $this->db->join('`discount_countries` dc', 'dc.`discount_id` = dnt.`id`');
		$this->db->join('`country` cnt', 'cnt.`country_id` = dc.`country_id`');
		if($roleName!=ADMIN){  
		    $this->db->where('dnt.by_user',$by_user);
        }
        
		$this->db->where('dnt.type_of_discount','Special');
		if(!empty($params['dData']['txtSearch'])){
	       $where = '(dnt.disc_name like "%'.$params['dData']['txtSearch'].'%" or dnt.discount_code like "%'.$params['dData']['txtSearch'].'%")';
		  $this->db->where($where);
		//$this->db->like('dnt.disc_name',$params['dData']['txtSearch']);
		} else {
	
            if(!empty($params['dData']['country_id'])){
                //print_r($params['dData']);
                $country_id=implode(",",$params['dData']['country_id']);
                //echo $country_id;
                $this->db->where("dc.country_id IN (".$country_id.")",NULL, false);
			}
			
			if(!empty($params['dData']['appliedProducts'])){
                $appliedProducts=$params['dData']['appliedProducts'];
                //$this->db->where("dnt.appliedProducts IN (".$appliedProducts.")",NULL, false);
                $this->db->where('dnt.appliedProducts',$appliedProducts);
			}
			
			if(!empty($params['dData']['appliedBranches'])){
			$appliedBranches=implode("|",$params['dData']['appliedBranches']);
			//$this->db->where("dnt.appliedBranches IN (".$appliedBranches.")",NULL, false);
			$this->db->where('CONCAT(",", dnt.appliedBranches, ",") REGEXP ",('.$appliedBranches.'),"');
			//$this->db->where_in('dnt.appliedBranches',str_replace("'","",$appliedBranches));
			}
			
			
			if(!empty($params['dData']['appliedTestType'])){
			$appliedTestType=implode("|",$params['dData']['appliedTestType']);
			//$this->db->where("dnt.appliedTestType1 IN (".$appliedTestType.")",NULL, false);
			$this->db->where('CONCAT(",", dnt.appliedTestType, ",") REGEXP ",('.$appliedTestType.'),"');

			//$this->db->where_in('dnt.appliedTestType',str_replace("'","",$appliedTestType));
			}
			
			
			if(!empty($params['dData']['appliedPackages'])){
			$appliedPackages=implode("|",$params['dData']['appliedPackages']);
			$this->db->where('CONCAT(",", dnt.appliedPackages, ",") REGEXP ",('.$appliedPackages.'),"');
			//$this->db->where("dnt.appliedPackages IN (".$appliedPackages.")",NULL, false);
			//$this->db->where_in('dnt.appliedPackages',str_replace("'","",$appliedPackages));
			}
			
			if(!empty($params['dData']['status'])){
			$this->db->where('dnt.active',$params['dData']['status']);
			}
			
			if(!empty($params['dData']['start_date']) && empty($params['dData']['end_date'])){
			$this->db->where('dnt.start_date',date('Y-m-d', strtotime($params['dData']['start_date'])));
			}
			
			if(!empty($params['dData']['end_date']) && empty($params['dData']['start_date'])){
			$this->db->where('dnt.end_date',date('Y-m-d', strtotime($params['dData']['start_date'])));
			}
			
			if(!empty($params['dData']['end_date']) && !empty($params['dData']['start_date'])){
			$this->db->where('(start_date BETWEEN "'. date('Y-m-d', strtotime($params['dData']['start_date'])). '" and "'. date('Y-m-d', strtotime($params['dData']['end_date'])).'" or end_date BETWEEN "'. date('Y-m-d', strtotime($params['dData']['start_date'])). '" and "'. date('Y-m-d', strtotime($params['dData']['end_date'])).'")');
			}
		
		}
        $this->db->order_by('dnt.id','DESC');
        return $this->db->get('')->result_array();

        /* if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $by_user= $_SESSION['UserId'];
        $this->db->select('
            *
        ');
		$this->db->select('cnt.name,dnt.*');
        $this->db->from('discount dnt');
		$this->db->join('`country` cnt', 'cnt.`country_id`=dnt.`country_id`');
		 if($roleName!=ADMIN){  
		$this->db->where('dnt.by_user',$by_user);
        }
        
		$this->db->where('dnt.type_of_discount','Special');
		if(!empty($params['dData']['txtSearch'])){
	       $where = '(dnt.disc_name like "%'.$params['dData']['txtSearch'].'%" or dnt.discount_code like "%'.$params['dData']['txtSearch'].'%")';
		  $this->db->where($where);
		//$this->db->like('dnt.disc_name',$params['dData']['txtSearch']);
		} else {
	
            if(!empty($params['dData']['country_id'])){
			//print_r($params['dData']);
			$country_id=implode(",",$params['dData']['country_id']);
			//echo $country_id;
			$this->db->where("dnt.country_id IN (".$country_id.")",NULL, false);
			
			}
			
			if(!empty($params['dData']['appliedProducts'])){
			$appliedProducts=$params['dData']['appliedProducts'];
			//$this->db->where("dnt.appliedProducts IN (".$appliedProducts.")",NULL, false);
			$this->db->where('dnt.appliedProducts',$appliedProducts);
			}
			
			if(!empty($params['dData']['appliedBranches'])){
			$appliedBranches=implode("|",$params['dData']['appliedBranches']);
			//$this->db->where("dnt.appliedBranches IN (".$appliedBranches.")",NULL, false);
			$this->db->where('CONCAT(",", dnt.appliedBranches, ",") REGEXP ",('.$appliedBranches.'),"');
			//$this->db->where_in('dnt.appliedBranches',str_replace("'","",$appliedBranches));
			}
			
			
			if(!empty($params['dData']['appliedTestType'])){
			$appliedTestType=implode("|",$params['dData']['appliedTestType']);
			//$this->db->where("dnt.appliedTestType1 IN (".$appliedTestType.")",NULL, false);
			$this->db->where('CONCAT(",", dnt.appliedTestType, ",") REGEXP ",('.$appliedTestType.'),"');

			//$this->db->where_in('dnt.appliedTestType',str_replace("'","",$appliedTestType));
			}
			
			
			if(!empty($params['dData']['appliedPackages'])){
			$appliedPackages=implode("|",$params['dData']['appliedPackages']);
			$this->db->where('CONCAT(",", dnt.appliedPackages, ",") REGEXP ",('.$appliedPackages.'),"');
			//$this->db->where("dnt.appliedPackages IN (".$appliedPackages.")",NULL, false);
			//$this->db->where_in('dnt.appliedPackages',str_replace("'","",$appliedPackages));
			}
			
			if(!empty($params['dData']['status'])){
			$this->db->where('dnt.active',$params['dData']['status']);
			}
			
			if(!empty($params['dData']['start_date']) && empty($params['dData']['end_date'])){
			$this->db->where('dnt.start_date',date('Y-m-d', strtotime($params['dData']['start_date'])));
			}
			
			if(!empty($params['dData']['end_date']) && empty($params['dData']['start_date'])){
			$this->db->where('dnt.end_date',date('Y-m-d', strtotime($params['dData']['start_date'])));
			}
			
			if(!empty($params['dData']['end_date']) && !empty($params['dData']['start_date'])){
			$this->db->where('(start_date BETWEEN "'. date('Y-m-d', strtotime($params['dData']['start_date'])). '" and "'. date('Y-m-d', strtotime($params['dData']['end_date'])).'" or end_date BETWEEN "'. date('Y-m-d', strtotime($params['dData']['start_date'])). '" and "'. date('Y-m-d', strtotime($params['dData']['end_date'])).'")');
			}
		
		}
        $this->db->order_by('dnt.id','DESC');
        return $this->db->get('')->result_array(); */
    }
	
	function get_all_discount_bulk($roleName,$params = array()){
        // print_r($params);
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $by_user= $_SESSION['UserId'];
		//die("dsfds");
		$this->db->select('cnt.name,dnt.*');
        $this->db->from('discount dnt');
        $this->db->join('`discount_countries` dc', 'dc.`discount_id` = dnt.`id`');
		$this->db->join('`country` cnt', 'cnt.`country_id` = dc.`country_id`');
        if($roleName!=ADMIN){  
		$this->db->where('dnt.by_user',$by_user);
        }
		$this->db->where('dnt.type_of_discount','Bulk');
		if(!empty($params['dData']['txtSearch'])){
	$where = '(dnt.disc_name like "%'.$params['dData']['txtSearch'].'%" or dnt.phoneNumber = "'.$params['dData']['txtSearch'].'" or dnt.email = "'.$params['dData']['txtSearch'].'")';
		$this->db->where($where);
		//$this->db->like('dnt.disc_name',$params['dData']['txtSearch']);
		} else {
	
			if(!empty($params['dData']['country_id'])){
			//print_r($params['dData']);
			$country_id=implode(",",$params['dData']['country_id']);
			//echo $country_id;
			$this->db->where("dc.country_id IN (".$country_id.")",NULL, false);
			
			}
			
			if(!empty($params['dData']['appliedProducts'])){
			$appliedProducts=$params['dData']['appliedProducts'];
			//$this->db->where("dnt.appliedProducts IN (".$appliedProducts.")",NULL, false);
			$this->db->where('dnt.appliedProducts',$appliedProducts);
			}
			
			if(!empty($params['dData']['appliedBranches'])){
			$appliedBranches=implode("|",$params['dData']['appliedBranches']);
			//$this->db->where("dnt.appliedBranches IN (".$appliedBranches.")",NULL, false);
			$this->db->where('CONCAT(",", dnt.appliedBranches, ",") REGEXP ",('.$appliedBranches.'),"');
			//$this->db->where_in('dnt.appliedBranches',str_replace("'","",$appliedBranches));
			}
			
			
			if(!empty($params['dData']['appliedTestType'])){
			$appliedTestType=implode("|",$params['dData']['appliedTestType']);
			//$this->db->where("dnt.appliedTestType1 IN (".$appliedTestType.")",NULL, false);
			$this->db->where('CONCAT(",", dnt.appliedTestType, ",") REGEXP ",('.$appliedTestType.'),"');

			//$this->db->where_in('dnt.appliedTestType',str_replace("'","",$appliedTestType));
			}
			
			
			if(!empty($params['dData']['appliedPackages'])){
			$appliedPackages=implode("|",$params['dData']['appliedPackages']);
			$this->db->where('CONCAT(",", dnt.appliedPackages, ",") REGEXP ",('.$appliedPackages.'),"');
			//$this->db->where("dnt.appliedPackages IN (".$appliedPackages.")",NULL, false);
			//$this->db->where_in('dnt.appliedPackages',str_replace("'","",$appliedPackages));
			}
			
			if(!empty($params['dData']['status'])){
			$this->db->where('dnt.active',$params['dData']['status']);
			}
			
			if(!empty($params['dData']['start_date']) && empty($params['dData']['end_date'])){
			$this->db->where('dnt.start_date',date('Y-m-d', strtotime($params['dData']['start_date'])));
			}
			
			if(!empty($params['dData']['end_date']) && empty($params['dData']['start_date'])){
			$this->db->where('dnt.end_date',date('Y-m-d', strtotime($params['dData']['start_date'])));
			}
			
			if(!empty($params['dData']['end_date']) && !empty($params['dData']['start_date'])){
			$this->db->where('(start_date BETWEEN "'. date('Y-m-d', strtotime($params['dData']['start_date'])). '" and "'. date('Y-m-d', strtotime($params['dData']['end_date'])).'" or end_date BETWEEN "'. date('Y-m-d', strtotime($params['dData']['start_date'])). '" and "'. date('Y-m-d', strtotime($params['dData']['end_date'])).'")');
			}
		
		}
        $this->db->order_by('dnt.id','DESC');
        return $this->db->get('')->result_array();
       /* // print_r($params);
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $by_user= $_SESSION['UserId'];
        $this->db->select('
            *
        ');
		//die("dsfds");
		$this->db->select('cnt.name,dnt.*');
        $this->db->from('discount dnt');
		$this->db->join('`country` cnt', 'cnt.`country_id`=dnt.`country_id`');
        if($roleName!=ADMIN){  
		$this->db->where('dnt.by_user',$by_user);
        }
		$this->db->where('dnt.type_of_discount','Bulk');
		if(!empty($params['dData']['txtSearch'])){
	$where = '(dnt.disc_name like "%'.$params['dData']['txtSearch'].'%" or dnt.phoneNumber = "'.$params['dData']['txtSearch'].'" or dnt.email = "'.$params['dData']['txtSearch'].'")';
		$this->db->where($where);
		//$this->db->like('dnt.disc_name',$params['dData']['txtSearch']);
		} else {
	
			if(!empty($params['dData']['country_id'])){
			//print_r($params['dData']);
			$country_id=implode(",",$params['dData']['country_id']);
			//echo $country_id;
			$this->db->where("dnt.country_id IN (".$country_id.")",NULL, false);
			
			}
			
			if(!empty($params['dData']['appliedProducts'])){
			$appliedProducts=$params['dData']['appliedProducts'];
			//$this->db->where("dnt.appliedProducts IN (".$appliedProducts.")",NULL, false);
			$this->db->where('dnt.appliedProducts',$appliedProducts);
			}
			
			if(!empty($params['dData']['appliedBranches'])){
			$appliedBranches=implode("|",$params['dData']['appliedBranches']);
			//$this->db->where("dnt.appliedBranches IN (".$appliedBranches.")",NULL, false);
			$this->db->where('CONCAT(",", dnt.appliedBranches, ",") REGEXP ",('.$appliedBranches.'),"');
			//$this->db->where_in('dnt.appliedBranches',str_replace("'","",$appliedBranches));
			}
			
			
			if(!empty($params['dData']['appliedTestType'])){
			$appliedTestType=implode("|",$params['dData']['appliedTestType']);
			//$this->db->where("dnt.appliedTestType1 IN (".$appliedTestType.")",NULL, false);
			$this->db->where('CONCAT(",", dnt.appliedTestType, ",") REGEXP ",('.$appliedTestType.'),"');

			//$this->db->where_in('dnt.appliedTestType',str_replace("'","",$appliedTestType));
			}
			
			
			if(!empty($params['dData']['appliedPackages'])){
			$appliedPackages=implode("|",$params['dData']['appliedPackages']);
			$this->db->where('CONCAT(",", dnt.appliedPackages, ",") REGEXP ",('.$appliedPackages.'),"');
			//$this->db->where("dnt.appliedPackages IN (".$appliedPackages.")",NULL, false);
			//$this->db->where_in('dnt.appliedPackages',str_replace("'","",$appliedPackages));
			}
			
			if(!empty($params['dData']['status'])){
			$this->db->where('dnt.active',$params['dData']['status']);
			}
			
			if(!empty($params['dData']['start_date']) && empty($params['dData']['end_date'])){
			$this->db->where('dnt.start_date',date('Y-m-d', strtotime($params['dData']['start_date'])));
			}
			
			if(!empty($params['dData']['end_date']) && empty($params['dData']['start_date'])){
			$this->db->where('dnt.end_date',date('Y-m-d', strtotime($params['dData']['start_date'])));
			}
			
			if(!empty($params['dData']['end_date']) && !empty($params['dData']['start_date'])){
			$this->db->where('(start_date BETWEEN "'. date('Y-m-d', strtotime($params['dData']['start_date'])). '" and "'. date('Y-m-d', strtotime($params['dData']['end_date'])).'" or end_date BETWEEN "'. date('Y-m-d', strtotime($params['dData']['start_date'])). '" and "'. date('Y-m-d', strtotime($params['dData']['end_date'])).'")');
			}
		
		}
        $this->db->order_by('dnt.id','DESC');
        return $this->db->get('')->result_array(); */
    }
	
	
	function get_products($productIds){
		$products=array();
		$productIds=explode(",",$productIds);
		
		if(in_array(1,$productIds)) {
		$products[]="Inhouse pack";
		}
		if(in_array(2,$productIds)) {
		$products[]="Online pack";
		}
		if(in_array(3,$productIds)) {
		$products[]="Practice Pack";
		}
		if(in_array(4,$productIds)) {
		$products[]="Reality Test";
		}
		if(in_array(5,$productIds)) {
		$products[]="Exam Booking";
		}
        
        return $products;
    }
	
	function get_branch($branchids){

		$branchids=explode(",",$branchids);
        $this->db->select('center_name');
		$this->db->from('center_location');
       // $this->db->where_in('center_id',$branchids);
		$branchids=implode("|",$branchids);
		$this->db->where('CONCAT(",", center_id, ",") REGEXP ",('.$branchids.'),"');
        return $this->db->get('')->result_array();
    }
	
	function get_testype($testtypeids){

        $testtypeids=explode(",",$testtypeids);
        $this->db->select('tm.test_module_id,tm.test_module_name');
		$this->db->from('test_module tm');
		$this->db->where(array('tm.active'=> 1));
		$testtypeids=implode("|",$testtypeids);
		$this->db->where('CONCAT(",", tm.test_module_id, ",") REGEXP ",('.$testtypeids.'),"');
        return $this->db->get('')->result_array();
    }  
	
	
	function get_package($appliedProducts,$appliedBranches,$testtypeids,$appliedPackages,$min_purchase_value){
	$result="";
		$products=explode(",",$appliedProducts);
        $testtypeids=explode(",",$testtypeids);
		$branches=explode(",",$appliedBranches);
		$packages=explode(",",$appliedPackages);
		/*print_r($testtypeids);
		print_r($branches);
		die();*/
		
		if(in_array(4,$products) || in_array(5,$products)) {
		$result="";
		} else if(in_array(2,$products)) {
			$result=$this->get_online_package_by_testtype($testtypeids,"");
			} else if(in_array(3,$products)) {
			$result=$this->get_package_list_by_testtype($testtypeids,"");
			}  else if(in_array(1,$products)) {
			$result=$this->get_offline_package_by_testtype($testtypeids,"",$branches,$packages);
			}

        return $result;
    }  
	
	function get_all_discount_country($params = array()){
        
        $this->db->select('country_id,name');
        $this->db->from('country');
		$this->db->where("currency_code <> ''");
        $this->db->order_by('name','ASC');
        return $this->db->get('')->result_array();
    }
	
	function get_online_package_by_testtype($test_module_id,$min_purchase_value){

        $this->db->select('
            pkg.`package_id`,
            pkg.`package_name`,
            CONCAT("Rs ", pkg.`amount`) AS amount,
            CONCAT("Rs ", pkg.`discounted_amount`) AS discounted_amount,
            CONCAT("Days ", pkg.`duration`) AS duration, 
            
        ');
        $this->db->from('package_masters pkg');
        //$this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`','left');
        if(count($test_module_id)>0){
				$test_module_id=implode("|",$test_module_id);
				$this->db->where('CONCAT(",", pkg.test_module_id, ",") REGEXP ",('.$test_module_id.'),"');
     		   $this->db->where(array('is_offline'=>0)); 
        }else{
            $this->db->where(array('pkg.active'=>1,'pkg.is_offline'=>0));
        }
		if($min_purchase_value>0) {
		$this->db->where("discounted_amount >= $min_purchase_value");
		}
        $this->db->order_by('pkg.`package_name` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }
	
	function get_offline_package_by_testtype($test_module_id,$min_purchase_value,$branch_id,$packages)
    {

        $this->db->select('
            pkg.`package_id`,
            pkg.`package_name`,
            CONCAT("Rs ", pkg.`amount`) AS amount,
            CONCAT("Rs ", pkg.`discounted_amount`) AS discounted_amount,
            CONCAT("Days ", pkg.`duration`) AS duration, 
           
        ');
        $this->db->from('package_masters pkg');
        //$this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`','left');
        if(count($test_module_id)>0){
           $test_module_id=implode("|",$test_module_id);
			$this->db->where('CONCAT(",", pkg.test_module_id, ",") REGEXP ",('.$test_module_id.'),"');
			
			$branch_id=implode("|",$branch_id);
			$this->db->where('CONCAT(",", pkg.center_id, ",") REGEXP ",('.$branch_id.'),"');

		   if(!empty($packages)){
		   $packages=implode("|",$packages);
			$this->db->where('CONCAT(",", pkg.package_id, ",") REGEXP ",('.$packages.'),"');
	
		   }
		   $this->db->where(array('pkg.active'=>1,'is_offline'=>1)); 
        }else{
            $this->db->where(array('pkg.is_offline'=>1));
        }
		
		if($min_purchase_value>0) {
		$this->db->where("discounted_amount >= $min_purchase_value");
		}
		
        $this->db->order_by('pkg.`package_name` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }
	
	
	 function get_package_list_by_testtype($test_module_id,$min_purchase_value){       
        
        $this->db->select('
            pkg.`package_id`,
            pkg.`package_name`,
            CONCAT("Rs ", pkg.`amount`) AS amount,
            CONCAT("Rs ", pkg.`discounted_amount`) AS discounted_amount,
            CONCAT("Days ", pkg.`duration`) AS duration
        ');
        $this->db->from('practice_package_masters pkg');
		//$this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`','left');
		if(count($test_module_id)>0){
		
		$test_module_id=implode("|",$test_module_id);
			$this->db->where('CONCAT(",", pkg.test_module_id, ",") REGEXP ",('.$test_module_id.'),"');
		
        //$this->db->where_in('pkg.test_module_id',$test_module_id); 
		}
		if($min_purchase_value>0) {
		$this->db->where("discounted_amount >= $min_purchase_value");
		}
		
		$this->db->where(array('pkg.active'=>1));
        $this->db->order_by('pkg.package_name', 'ASC');
        return $this->db->get()->result_array();
    }
	
	
	 function get_all_real_test($test_module_id){


	$test_module_id=implode("|",$test_module_id);
			

        $this->db->select('

            dc.`id`, 

            dc.`title`,

            dc.`date`,

            dc.`strdate`,

            dc.`time_slot1`,

            dc.`time_slot2`,

            dc.`time_slot3`,

            dc.`amount`,           

            dc.`active`,

            pgm.`programe_name`,

            tm.`test_module_name`,

            tm.`test_module_id`,

        ');

        $this->db->from('`real_test_dates` dc');

        $this->db->join('`programe_masters` pgm', 'dc.`programe_id`= pgm.`programe_id`');

        $this->db->join('`test_module` tm', 'dc.`test_module_id`=tm.`test_module_id`');        

        //$this->db->join('`center_location` cl', 'cl.`center_id`=dc.`center_id`', 'left');

      $this->db->where('CONCAT(",", dc.test_module_id, ",") REGEXP ",('.$test_module_id.'),"');

         

      

        return $this->db->get('')->result_array();

        //print_r($this->db->last_query());exit;
    }

	
	function get_all_test_module_active_by_country_product_base($country_id,$products){       
        
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('test_module tm');  
		if(!in_array(INDIA_ID,$country_id) && $products==4) {
		    //$this->db->where_in('tm.test_module_id1', '2,3');  
		    $this->db->where("tm.test_module_id IN (1,2,3)",NULL, false);
		}
        $this->db->where(array('tm.active'=> 1));  
        $this->db->order_by('test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }


	 function get_discount_currency_code($country_id)
		{
		
//print_r($country_id);

        $this->db->from('country');  
		if(is_array($country_id)) {
		    $country_id=implode("|",$country_id);
			$this->db->where('CONCAT(",", country_id, ",") REGEXP ",('.$country_id.'),"');
		    //$this->db->where("country_id IN (".$country_id.")",NULL, false);
		} else {
		 $this->db->where('country_id', $country_id);
		} 

        $currency_codes=$this->db->get()->row_array();
		return $currency_codes['currency_code'];
		
		
			
		}
		
		
		function getDiscountDetails($discount_id)
		{
            $this->db->select('dnt.*');
            $this->db->from('discount dnt');
            $this->db->join('`discount_countries` dc', 'dc.`discount_id`= dnt.`id`');
            $this->db->join('`country` cnt', 'cnt.`country_id` = dc.`country_id`');
            //$this->db->where('dnt.user_id',$by_user);
            $this->db->where('dnt.id',$discount_id);
            //$this->db->order_by('dnt.id','DESC');
            return $this->db->get()->row_array();
				/* $this->db->from('discount dnt');
				$this->db->join('`country` cnt', 'cnt.`country_id`=dnt.`country_id`');
				//$this->db->where('dnt.user_id',$by_user);
				$this->db->where('dnt.id',$discount_id);
				//$this->db->order_by('dnt.id','DESC');
				return $this->db->get()->row_array(); */
		
			//return $this->db->get_where('discount',array('id'=>$discount_id))->row_array();
			
		} 
		
		
		
		
		function check_phone($phone)
		{
			$chkph= $this->db->get_where('students',array('mobile'=>$phone))->row_array();
			if(isset($chkph) && !empty($chkph)) {
			return 1;
			} else {
			return 0;
			}
		} 
		
	function check_email($email)
		{
			$chkph= $this->db->get_where('students',array('email'=>$email))->row_array();
			if(isset($chkph) && !empty($chkph)) {
			return 1;
			} else {
			return 0;
			}
		}	
		
	/*function get_discount_branchbyproductId($country_id)
		{
			$currency_codes= $this->db->get_where('country',array('country_id'=>$products))->row_array();
			return $currency_codes['currency_code'];
		}  	*/
		 
        
    /*
     * function to add new discount
     */
    function add_discount($params)
    {
        $this->db->from('discount');
        $this->db->where(array('discount_code'=>$params['discount_code'],'type_of_discount1'=>$params['type_of_discount']));
        $count = $this->db->count_all_results();
        if($count==0){
            $this->db->insert('discount',$params);
            return $this->db->insert_id();
        }else{
            return 'duplicate';
        }
        
    }  
    
    
     function add_discount_b($params)
    {
       /* $this->db->from('discount');
        $this->db->where(array('discount_code'=>$params['discount_code'],'type_of_discount'=>$params['type_of_discount']));
        $count = $this->db->count_all_results();
        if($count==0){*/
            $countryIds         = $params["country_id"];
            $countryCurrency    = $params["currency_code"];

            unset($params['country_id']);

            $this->db->insert('discount',$params);
            $lastId = $this->db->insert_id();

            if($lastId) {
                foreach($countryIds as $country_id) {
                    $discountLocations['country_id']    = $country_id;
                    $discountLocations['discount_id']   = $lastId;
                    $this->db->insert('discount_countries',$discountLocations);
                }

                return $lastId;
            }

        /*}else{
            return 'duplicate';
        }*/
        
    }   
	
	function add_range_discount($params)
    {

        if(!empty($params)){
            $this->db->insert('discount_ranges',$params);
            return $this->db->insert_id();
        }else{
            return 'duplicate';
        }
        
    } 
	
	
	
	
	
    function add_bulk_discount($params)
    {
        $this->db->from('discount_bulk');
        $this->db->where(array('discount_code'=>$params['discount_code']));
        $count = $this->db->count_all_results();
        if($count==0){
            $this->db->insert('discount_bulk',$params);
            return $this->db->insert_id();
        }else{
            return 'duplicate';
        }
        
    } 
	
	
	  function add_special_discount($params)
    {
        $this->db->from('discount');
        $this->db->where(array('discount_code'=>$params['discount_code']));
        $count = $this->db->count_all_results();
        if($count==0){
            $this->db->insert('discount_bindto',$params);
            return $this->db->insert_id();
        }else{
            return 'duplicate';
        }
        
    } 
   
   
   
    function update_discount($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('discount',$params);
    }
    
    
    function edit_dates_discount($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('discount',$params);
    }


    

	
 /*
     * function to update 
     */
    function update_one($id, $active, $table, $pk)
    {        
        return $this->db->query("UPDATE ".$table." SET `active`=".$active." WHERE ".$pk." = ".$id." ");
        //print_r($this->db->last_query());exit;
    }
	
	
	function get_all_discount_bulk_csv($discount_id){
        

        $by_user= $_SESSION['UserId'];
        $this->db->select('
            *
        ');
		//die("dsfds");
		$this->db->select('blk.bulk_id,blk.discount_code,dnt.disc_name');
        $this->db->from('discount dnt');
		$this->db->join('`discount_bulk` blk', 'blk.`discount_id`=dnt.`id`');
        $this->db->where('blk.discount_id',$discount_id);
        $this->db->where('dnt.by_user',$by_user);
		$this->db->where('dnt.type_of_discount','Bulk');
        
        
        $this->db->order_by('blk.bulk_id','ASC');
        return $this->db->get('')->result_array();
		
		}
        
        function get_all_schedule_discount(){
    		
            //die("dsfds");
    		//$this->db->select('blk.bulk_id,blk.discount_code,dnt.disc_name');
            $this->db->from('discount');
    		$this->db->where('type_of_discount','Special');
            $this->db->where('active',2);
             $this->db->order_by('id','ASC');
            return $this->db->get('')->result_array();		
		}

        function getDiscountCurrency($promoCodeId){
            
            $this->db->select('d.id,cnt.currency_code');
            $this->db->from('discount d');
            $this->db->join('`country` cnt', 'cnt.`country_id`= d.`country_id`'); 
            $this->db->where(array('d.id'=> $promoCodeId));
            return $this->db->get('')->row_array();
            //print_r($this->db->last_query());exit;
        }
    
    
}
