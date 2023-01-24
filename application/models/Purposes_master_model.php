<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Ashok Kumar
 *
 * */
class Purposes_master_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * This function will return count of all tags in lms_purposes_master table
     * 
     * @return any
     */
    public function getPurposesMasterCount(array $params = []) {
        $this->db->from('lms_purposes_master');
		 $this->db->where('lms_purposes_master.p_id',$params['p_id']);
        return $this->db->count_all_results();
    }

    /**
     * This function will return all rows from lms_purposes_master table
     * 
     * @param array $params
     * @return type
     */
    public function getPurposesList(array $params = []) {
		
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
			
        }
        return $this->db->select('lms_purposes_master.*, division_masters.division_name')
                ->from('lms_purposes_master')
                ->join('division_masters', 'division_masters.id = lms_purposes_master.division_id', 'LEFT')->where('lms_purposes_master.p_id',$params['p_id'])
                ->get()->result();
    }
    
    /**
     * This function will return all rows where active = 1 from lms_purposes_master table
     * 
     * @param array $params
     * @return type
     */
    public function getActivePurposesList(array $params = []) {	
        if (isset($params) && !empty($params)) {
            $this->db->limit($params['limit'], $params['offset']);
			
        }
        return $this->db->select('lms_purposes_master.*, division_masters.division_name')
                ->from('lms_purposes_master')
                ->join('division_masters', 'division_masters.id = lms_purposes_master.division_id', 'LEFT')
                ->where('lms_purposes_master.active', '1')
                ->get()->result();
    }

    /**
     * This function will return all rows from lms_purposes_master table
     * 
     * @return type
     */
    public function getPurposesParentsList() {
        return $this->db->select('lms_purposes_master.*, division_masters.division_name')
                ->from('lms_purposes_master')
                ->join('division_masters', 'division_masters.id = lms_purposes_master.division_id', 'LEFT')
                ->where('p_id', '0')
                ->get()->result();
    }

    /**
     * This function will return a row from lms_purposes_master table
     * 
     * @param int $id
     * @return type
     */
    public function getPurposeDetails(int $id) {
        return $this->db->select('*')
                        ->from('lms_purposes_master')
                        ->where('id', $id)
                        ->get()->row();
    }

    /**
     * This function will store a tag's row in lms_purposes_master table
     * 
     * @param array $params
     * @return int|null
     */
    public function storePurpose(array $params) {
        $this->db->insert('lms_purposes_master', $params);
        return $this->db->insert_id();
    }

    /**
     * This function will update a tag's row in lms_purposes_master table
     * 
     * @param int $_id
     * @param string $oldTitle
     * @param array $params
     * @return type
     */
    public function updatePurpose(int $_id, string $oldTitle, array $params) {
		$this->db->where('id', $_id);
        if($this->db->update('lms_purposes_master', $params)){
			return $_id;
		}else{
			return 0;
		}
    }

    /**
     * This function will return a row from lms_purposes_master table
     * 
     * @param int $p_id
     * @return type
     */
    public function getPurposeChildren(int $p_id) {
        return $this->db->select('*')
                        ->from('lms_purposes_master')
                        ->where('p_id', $p_id)
                        ->get()->result();
    }
    public function getPurposeChildrenByDivisionId(int $p_id,$division_id) {
		
		return $this->db->select('*')
		->from('lms_purposes_master')
		->where('p_id', $p_id)->where('division_id', $division_id)
		->get()->row_array();
    }
	public function getPurposeChildrenIsPrimary(int $p_id) {
		
		return $this->db->select('*')
		->from('lms_purposes_master')
		->where('p_id', $p_id)->where('is_primary',1)
		->get()->row_array();
    }
    /**
     * 
     * @param int $id
     * @return string
     */
    public function getParent(int $id) {
		
        $row = $this->db->select('p_id,name')->from('lms_purposes_master')->where(['id' => $id])->get()->row();
        if ($row) {
			if($row->p_id > 0){
				
				$row1 = $this->db->select('p_id,name')->from('lms_purposes_master')->where(['id' => $row->p_id])->get()->row();
				if ($row1) {
					return $row->name.'->'.$row1->name;
				}else{
					return $row->name;
				}
			}else{
				return $row->name;
			}
        } else {
            return 'N/A';
        }
    }
	
	public function isChild(int $id) {
		
        $row = $this->db->select('id')->from('lms_purposes_master')->where(['p_id' => $id])->get()->row();
        if($row){
			return 1; 
        } else {
            return 0;
        }
    }
	
	public function addPurposeMedium(array $params) {
        $this->db->insert('lms_purposes_om', $params);
        return $this->db->insert_id();
    }
	
	public function getSourceActive($origin_type,$origin,$medium) {
		
		$this->db->select('S.source_name,S.id');
		$this->db->from('source_masters_om as SM');
		$this->db->join('source_masters as S','S.id = SM.source_id','LEFT');
		$this->db->where(array('SM.origin_type'=>$origin_type,'SM.origin'=>$origin,'SM.medium'=>$medium,'S.active'=>1));
        $this->db->order_by("S.source_name");	
		return $this->db->get('')->result_array();
    }
	
	public function getMediumPurpose($origin_type,$origin,$medium) {
		
		$this->db->select('PM.name,PM.id,PM.is_primary');
		$this->db->from('lms_purposes_om as PO');
		$this->db->join('lms_purposes_master as PM','PM.id = PO.purpose_id','LEFT');
		$this->db->where(array('PO.origin_type'=>$origin_type,'PO.origin'=>$origin,'PO.medium'=>$medium));
        $this->db->order_by("PM.id");	
		return $this->db->get('')->result_array();
    }
	public function getPrimaryPurpose($purpose_id=null) {
		
		$this->db->select('*');
		$this->db->from('lms_purposes_master as PM');
		$this->db->where(array('PM.id'=>$purpose_id));
        $this->db->order_by("PM.id");	
		$purpose_data=$this->db->get('')->row_array();
		return $purpose_data;
    }
	function getRealityTest($course,$program)
    {
		$this->db->distinct();
        $this->db->select('RT.id,RT.title,RT.date,RT.amount');
        $this->db->from('`real_test_dates` as RT');
        //$this->db->join('`category_masters` as CM', 'CM.test_module_id= RT.test_module_id','LEFT');
        $this->db->where(array('RT.test_module_id'=>$course,'RT.active'=>1));
		//$this->db->where(array('CM.programe_id'=>$program));
        return $this->db->get()->result_array();
    }
	
	function getTestPrograme($test_module_id){

        $this->db->distinct('');
        $this->db->select('pgm.`programe_id`, pgm.`programe_name`');
        $this->db->from('`category_masters` cat');  
        $this->db->join('programe_masters pgm', 'cat.programe_id = pgm.programe_id', 'LEFT');
        $this->db->where(array('cat.test_module_id'=> $test_module_id));
        $this->db->order_by('pgm.programe_name', 'ASC');
        return $this->db->get('')->result_array();
    }
	
	function getAllActiveEventTypeByDivisionId($division_id=array())
    {   
        $this->db->select('event_type_master.id,event_type_master.eventTypeTitle');
        $this->db->from('event_type_master');
		$this->db->where('event_type_master.active',1);
		$this->db->join('event_type_division', 'event_type_master.id= event_type_division.event_type_id','LEFT');
		$this->db->where_in('event_type_division.division_id',$division_id);
        $this->db->order_by('event_type_master.eventTypeTitle', 'ASC');
        return $this->db->get()->result_array();
    }
	
	function getAllCountryActive_deal()
    {  
        $this->db->select('country_id,name');
        $this->db->from('country');
        $this->db->where(array('active'=>1,'we_deal?'=>1));
        $this->db->order_by('name', 'ASC');
        return $this->db->get('')->result_array();
    }
	
	function getAcademyEventActive($course,$eventTypeId,$division_id)
    {  
        $today    = date("Y-m-d G:i:0");
		$todaystr =strtotime($today);
        $this->db->select('events.id,events.eventId,events.eventTitle');
		$this->db->from('event_location_test_type');
		$this->db->join('events', 'events.id= event_location_test_type.event_id','LEFT');
		$this->db->where_in('events.eventStatus',array(2,3));
		$this->db->where('events.active',1);
		//$this->db->where('events.eventWebsiteView',1);
		//$this->db->where('events.eventBookingEndDateTimeStr >= ',$todaystr);
		$this->db->where('events.division_id',$division_id);
		$this->db->where('events.eventTypeId',$eventTypeId);
		$this->db->where('event_location_test_type.test_type_id',$course);
		$this->db->group_by('events.id');
        $this->db->order_by("events.eventStartDateTimeStr");
        return $this->db->get('')->result_array();
		
    }
	
	function getVisaEventActive($country_id,$eventTypeId,$division_id)
    {  
        $today    = date("Y-m-d G:i:0");
		$todaystr =strtotime($today);
        $this->db->select('events.id,events.eventId,events.eventTitle');
		$this->db->from('event_location_countries');
		$this->db->join('events', 'events.id= event_location_countries.event_id','LEFT');
		$this->db->where_in('events.eventStatus',array(2,3));
		$this->db->where('events.active',1);
		//$this->db->where('events.eventWebsiteView',1);
		//$this->db->where('events.eventBookingEndDateTimeStr >= ',$todaystr);
		$this->db->where('events.division_id',$division_id);
		$this->db->where('events.eventTypeId',$eventTypeId);
		$this->db->where('event_location_countries.country_id',$country_id);
		$this->db->group_by('events.id');
        $this->db->order_by("events.eventStartDateTimeStr");
        return $this->db->get('')->result_array();
    }
	
	function getExamCityActive()
    {  
        $this->db->select('OL.id,CT.city_name,OL.location_name');
		$this->db->from('outhouse_locations as OL');
		$this->db->join('outhouse_location_types as OLT', 'OLT.location_id= OL.id','LEFT');
		$this->db->join('city as CT', 'CT.city_id= OL.city_id','LEFT');
		$this->db->where('OL.active',1);
		$this->db->where('OLT.location_type',2); // 2 = Exam Booking
		//$this->db->group_by('CT.city_name');   // Discussed with Neelu Sir
		$this->db->order_by("CT.city_name");
        return $this->db->get('')->result_array();
    }
	
	function getExamListActive($course,$program,$locationid)
    {  
        $this->db->select('EM.id,EM.exam_date,OL.location_name');
		$this->db->from('exam_venue_dates as EM');
		$this->db->join('outhouse_locations as OL', 'OL.id = EM.location_id','LEFT');
		$this->db->where('EM.test_module_id',$course);
		$this->db->where('EM.programe_id',$program);
		$this->db->where('OL.id',$locationid);
		$this->db->where('EM.active',1);
		$this->db->order_by("EM.exam_date",'ASC');
        return $this->db->get('')->result_array();
		//print_r($this->db->last_query());
    }
	
	function getAllQualificationActive()
    {  
        $this->db->select('id,qualification_name');
        $this->db->from('qualification_masters');
        $this->db->where(array('active'=>1));
        $this->db->order_by('qualification_name', 'ASC');
        return $this->db->get('')->result_array();
    }
	
	function getAllWorkExperienceActive()
    {  
        $this->db->select('id,work_experience');
        $this->db->from('work_experience_master');
        $this->db->where(array('active'=>1));
        $this->db->order_by('id', 'ASC');
        return $this->db->get('')->result_array();
    }
	
	function getAllIndustryTypeActive()
    {  
        $this->db->select('id,industry_type');
        $this->db->from('industry_type_master');
        $this->db->where(array('active'=>1));
        $this->db->order_by('industry_type', 'ASC');
        return $this->db->get('')->result_array();
    }
	
	function getOnlinePackageActive($course,$program)
    {  
        $this->db->select('package_id,package_name');
		$this->db->from('package_masters');
		$this->db->where('test_module_id',$course);
		$this->db->where('programe_id',$program);
		$this->db->where('is_offline',0);
		$this->db->where('active',1);
		$this->db->order_by("package_id",'ASC');
        return $this->db->get('')->result_array();
		//print_r($this->db->last_query());
    }
	
	function getOnlineCoachingProgram(){

        $this->db->select('`programe_id`, `programe_name`');
        $this->db->from('`programe_masters`');  
        $this->db->where(array('active'=> 1));
        $this->db->order_by('programe_name', 'ASC');
        return $this->db->get('')->result_array();
    }
	
	function getAllInhouseCoachingBranchActive(){

        $this->db->select('`center_id`, `center_name`');
        $this->db->from('`center_location`');  
        $this->db->where(array('active'=> 1,'physical_branch'=>1,'is_overseas'=>0));
        $this->db->order_by('center_name', 'ASC');
        return $this->db->get('')->result_array();
    }
	
	function getInhousePackageActive($branch,$course,$program)
    {  
        $this->db->select('package_id,package_name');
		$this->db->from('package_masters');
		$this->db->where('center_id',$branch);
		$this->db->where('test_module_id',$course);
		$this->db->where('programe_id',$program);
		$this->db->where('is_offline',1);
		$this->db->where('active',1);
		$this->db->order_by("package_id",'ASC');
        return $this->db->get('')->result_array();
		//print_r($this->db->last_query());
    }
	
	function getPracticePackPackageActive($course,$program)
	{
		$this->db->select('package_id,package_name');
		$this->db->from('practice_package_masters');
		$this->db->where('test_module_id',$course);
		$this->db->where('programe_id',$program);
		$this->db->where('active',1);
		$this->db->order_by("package_id",'ASC');
        return $this->db->get('')->result_array();
	}

	/**
	 * 
	 * @param int $parent_id
	 * @param int $division_id
	 * @return type
	 */
	public function getMediumPurposeById(int $parent_id, int $division_id) {
		$this->db->select('PM.name,PM.id');
		$this->db->from('lms_purposes_master as PM');
		$this->db->where(array('PM.p_id' => $parent_id, 'PM.division_id' => $division_id, 'PM.is_primary' => 1));
		$this->db->order_by("PM.id");
		return $this->db->get()->row();
	}
	
	function getComplaintSubjectByProductId($product_id)
    {  
        $this->db->select('C.id,C.subject');
		$this->db->from('complaint_subject_product  as CSD');
		$this->db->join('complaint_subject as C', 'C.id = CSD.complaint_subject_id','LEFT');
		$this->db->where('CSD.product_id',$product_id);
		$this->db->where('C.active',1);
		$this->db->order_by("C.subject",'ASC');
        return $this->db->get('')->result_array();
    }
	function getFeedbackSubjectByProductId($product_id)
    {  
	
	    $this->db->select('C.id,C.topic as subject');
		$this->db->from('feedback_topic_product  as CSD');
		$this->db->join('feedback_topic  as C', 'C.id = CSD.feedback_topic_id','LEFT');
		$this->db->where('CSD.product_id',$product_id);
		$this->db->where('C.active',1);
		$this->db->order_by("subject",'ASC');
        return $this->db->get('')->result_array();
    }
	function getGeneralAssistanceSubjectByProductId($product_id)
    {  
        $this->db->select('C.id,C.subject');
		$this->db->from('general_assistance_subjects_product as CSD');
		$this->db->join('general_assistance_subjects  as C', 'C.id = CSD.general_assistance_subjects_id','LEFT');
		$this->db->where('CSD.product_id',$product_id);
		$this->db->where('C.active',1);
		$this->db->order_by("C.subject",'ASC');
        return $this->db->get('')->result_array();
    }
}
