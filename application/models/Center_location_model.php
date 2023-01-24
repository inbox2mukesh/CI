<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

class Center_location_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getNonOverseasIsPhysicalBranch(){       
        
        $this->db->select('center_id,center_name');
        $this->db->from('center_location');
        $this->db->where(array('active'=>1,'is_overseas'=>0,'physical_branch'=>1));
        $this->db->order_by('center_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function getNonOverseasIsNotPhysicalBranch($centerId=0){
        
        $this->db->select('center_id,center_name');
        $this->db->from('center_location');
        $this->db->where(array('active'=>1,'is_overseas'=>0,'physical_branch'=>0));
        if($centerId) {
            $this->db->where("center_id",$centerId);
        }
        $this->db->order_by('center_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function getAllActivePhysicalBranches($countryIds=array()) {
        $this->db->select('center_id,center_name');
        $this->db->from('center_location');
        $this->db->where(array('active'=>1,'physical_branch' => 1));
        if($countryIds) {
            $this->db->where_in("country_id",$countryIds);
        }
        $this->db->order_by('center_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    /*function Get_all_rt_branch(){

        $this->db->distinct('');
        $this->db->select('cl.center_id,cl.center_name');
        $this->db->from('center_location cl');
        $this->db->join('real_test_dates_seats rtds', 'rtds.center_id = cl.center_id');
        $this->db->order_by('cl.center_name', 'ASC');
        return $this->db->get()->result_array();
    }*/

    /*function Get_rt_branch($rt_id)
    {   
        $this->db->distinct('');
        $this->db->select('cl.center_id,cl.center_name');
        $this->db->from('center_location cl');
        $this->db->where(array('rtds.reality_test_id'=>$rt_id));
        $this->db->join('real_test_dates_seats rtds', 'rtds.center_id = cl.center_id');
        $this->db->order_by('cl.center_name', 'ASC');
        return $this->db->get()->result_array();
    }*/

    function getNonOverseasBranch()
    {        
        
        $this->db->select('center_id,center_name');
        $this->db->from('center_location');
        $this->db->where(array('active'=>1,'is_overseas'=>0));
        $this->db->order_by('center_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function get_all_center_location_non_overseas($params = array()){
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('cl.center_id,cl.feedbackLink,UPPER(cl.center_name) as center_name,cl.contact,cl.email,cl.zip_code,cl.address_line_1,cl.latitude,cl.longitude,cl.active,cnt.name,st.state_name,ct.city_name');
        $this->db->from('center_location cl');
        $this->db->join('country cnt', 'cnt.country_id = cl.country_id' ,'left');
        $this->db->join('state st', 'st.state_id = cl.state_id' ,'left');
        $this->db->join('city ct', 'ct.city_id = cl.city_id' ,'left');
        $this->db->where(array('cl.active'=>1,'cl.is_overseas'=>0));
        $this->db->order_by('cl.center_name', 'ASC');
        return $this->db->get('')->result_array();
    }
    
    function get_all_center_location_overseas($params = array()){
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('cl.center_id,cl.feedbackLink,UPPER(cl.center_name) as center_name,cl.contact,cl.email,cl.zip_code,cl.address_line_1,cl.latitude,cl.longitude,cl.active,cnt.name,st.state_name,ct.city_name');
        $this->db->from('center_location cl');
        $this->db->join('country cnt', 'cnt.country_id = cl.country_id' ,'left');
        $this->db->join('state st', 'st.state_id = cl.state_id' ,'left');
        $this->db->join('city ct', 'ct.city_id = cl.city_id' ,'left');
        $this->db->where(array('cl.active'=>1,'cl.is_overseas'=>1));
        $this->db->order_by('cl.center_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function funtionalBranchListByDivision($division_ids){

        $this->db->distinct('');
        $this->db->select('cl.center_id,cl.center_name');
        $this->db->from('center_location cl');
        $this->db->join('center_divisions cd', 'cd.center_id = cl.center_id');
        $this->db->where(array('cl.active'=>1));
        $this->db->where_in('cd.division_id', $division_ids);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }    
   
    function get_center_location($center_id)
    {
        return $this->db->get_where('center_location',array('center_id'=>$center_id))->row_array();
    }

    function get_centerName($center_id)
    {
        $this->db->select('center_name');
        $this->db->from('center_location');
        $this->db->where(array('center_id'=>$center_id));
        return $this->db->get('')->row_array();
    }

    function get_centerCode($center_id)
    {
        $this->db->select('center_code');
        $this->db->from('center_location');
        $this->db->where(array('center_id'=>$center_id));
        return $this->db->get('')->row_array();
    }

    /*function Get_feedback_branch_link()
    {
        $this->db->select('center_name,feedbackLink');
        $this->db->from('center_location');
        $this->db->where(array('active'=>1,'physical_branch'=>1,'feedbackLink!='=>''));
        return $this->db->get('')->result_array();
    }*/

    function get_centerId($center_name)
    {
        $this->db->select('center_id');
        $this->db->from('center_location');
        $this->db->where(array('center_name'=>$center_name));
        return $this->db->get('')->row_array();
    }
    
   
    function get_all_center_location_count()
    {
        $this->db->from('center_location');
        return $this->db->count_all_results();
    }
        
    
    function get_all_center_location($params = array())
    {
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('cl.center_id,cl.center_code,cl.feedbackLink,cl.center_name,cl.contact,cl.email,cl.active,cnt.name,st.state_name,ct.city_name,cl.physical_branch,cl.is_overseas');
        $this->db->from('center_location cl');
        $this->db->join('country cnt', 'cnt.country_id = cl.country_id','left');
        $this->db->join('state st', 'st.state_id = cl.state_id','left');
        $this->db->join('city ct', 'ct.city_id = cl.city_id','left');
        $this->db->order_by('cl.modified', 'DESC');
        return $this->db->get('')->result_array();
    }

    
    function get_all_center_location_active($params = array())
    {        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('cl.center_id,cl.feedbackLink,cl.center_code,cl.center_name,cl.contact,cl.email,cl.zip_code,cl.address_line_1,cl.latitude,cl.longitude,cl.active,cnt.name,st.state_name,ct.city_name');
        $this->db->from('center_location cl');
        $this->db->join('country cnt', 'cnt.country_id = cl.country_id');
        $this->db->join('state st', 'st.state_id = cl.state_id');
        $this->db->join('city ct', 'ct.city_id = cl.city_id');
        $this->db->where(array('cl.active'=>1));
        $this->db->order_by('cl.center_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function get_overall_active_center_location($params = array())
    {
        $this->db->from('center_location');
        $this->db->where(array('active'=>1));
        $this->db->order_by('center_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    
    function get_all_branch_location($country_id)
    {  
        $this->db->select('cl.center_name,cl.contact,cl.email,cl.zip_code,cl.address_line_1,cl.latitude,cl.longitude,cnt.name,st.state_name,ct.city_name');
        $this->db->from('center_location cl');
        $this->db->join('country cnt', 'cnt.country_id = cl.country_id');
        $this->db->join('state st', 'st.state_id = cl.state_id');
        $this->db->join('city ct', 'ct.city_id = cl.city_id');
        $this->db->where(array('cl.active'=>1 ,'cl.country_id'=>$country_id));
        $this->db->order_by('ct.city_name ASC','st.state_name ASC');
        return $this->db->get('')->result_array();
    }

    
    function get_all_branch()
    {  
        $this->db->select('cl.center_id,cl.center_name,ct.city_name');
        $this->db->from('center_location cl');
        $this->db->join('city ct', 'ct.city_id = cl.city_id');
        $this->db->where(array('cl.active'=>1,'cl.is_overseas'=>0));
        $this->db->order_by('ct.city_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function getAcademyBranchRest($arr){

        $this->db->distinct('');
        $this->db->select('cl.center_id');
        $this->db->from('center_location cl');
        $this->db->join('center_divisions cd', 'cd.center_id = cl.center_id');
        $this->db->join('division_masters dm', 'dm.id = cd.division_id');
        $this->db->where(array('cl.active'=>1,'cl.is_overseas'=>0,'dm.division_name'=>'Academy'));
        $this->db->where_not_in('cl.center_id',$arr);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getAcademyBranch($roleName,$userBranch){

        $this->db->distinct('');
        $this->db->select('cl.center_id,cl.center_name');
        $this->db->from('center_location cl');
        $this->db->join('center_divisions cd', 'cd.center_id = cl.center_id');
        $this->db->join('division_masters dm', 'dm.id = cd.division_id');
        if($roleName != ADMIN && $userBranch){
            $this->db->where_in('cl.center_id',$userBranch); 
            $this->db->where(array('cl.active'=>1,'dm.division_name'=>'Academy','cl.independent_body'=>0,'cl.is_overseas'=>0));    
        }else{
           $this->db->where(array('cl.active'=>1,'dm.division_name'=>'Academy','cl.independent_body'=>0,'cl.is_overseas'=>0)); 
        }        
        $this->db->order_by('cl.center_name', 'ASC');
        return $this->db->get('')->result_array();
    }
	
	function getFunctionalBranchByCountry($country_id,$roleName,$userBranch) 
    {  
        $this->db->select('cl.center_id,cl.center_name,ct.name as country_name');
        $this->db->from('center_location cl');
        $this->db->join('country ct','ct.country_id = cl.country_id');
        $this->db->where('cl.active',1);
        if(is_array($country_id)) {
            $country_id = join(",",$country_id);
        }

        $this->db->where("cl.country_id in ($country_id)");
        if($roleName != ADMIN && $userBranch){
            $this->db->where_in('cl.center_id',$userBranch);     
        }
		//$this->db->where(array('country_id'=>$country_id));       
        return $this->db->get('')->result_array();
        
    }

    function getFunctionalBranch($roleName,$userBranch){  

        $this->db->select('cl.center_id,cl.center_name');
        $this->db->from('center_location cl');
        $this->db->where(array('cl.is_overseas'=>0,'cl.active'=>1,'cl.independent_body'=>0));
        if($roleName==ADMIN){
        }else{
            $this->db->where_in('center_id',$userBranch);            
        }
        return $this->db->get('')->result_array();        
    }

    function getFunctionalBranchWithoutOnline($roleName,$userBranch)
    {  
        $this->db->select('center_id,center_name');
        $this->db->from('center_location');
        $this->db->where(array('active'=>1,'is_overseas'=>0));
        if($roleName==ADMIN){
            $this->db->where(array('center_id!='=>ONLINE_BRANCH_ID));
        }else{
            $this->db->where(array('center_id!='=>ONLINE_BRANCH_ID));
            $this->db->where_in('center_id',$userBranch);            
        }
        return $this->db->get('')->result_array();        
    }

    function get_branch_country_id_by_branch_id($branch_ids=array()) {
        $this->db->distinct();
        $this->db->select('country_id');
        $this->db->from('center_location');
        $this->db->where(array('active' =>  1));
        if($branch_ids) {
            $branch_ids = join(",",$branch_ids);
            $this->db->where("center_id in ($branch_ids)");
        }
       
        $this->db->order_by('country_id', 'ASC');
        $result = $this->db->get('')->result_array(); 
        $arr    = array_column($result,"country_id");
        return $arr;
    }

    
    function get_all_branch_short()
    {  
        $this->db->select('center_name');
        $this->db->from('center_location');
        $this->db->where('active',1);
        $this->db->order_by('center_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function GetBranchAddress($center_id)
    {  
        $this->db->select('address_line_1');
        $this->db->from('center_location');
        $this->db->where('center_id',$center_id);
        return $this->db->get('')->row_array();
    }

    function get_all_branch_short_enq()
    {  
        $this->db->select('center_id,center_name');
        $this->db->from('center_location');
        $this->db->where(array('active'=>1, 'physical_branch'=>1,'is_overseas'=>0));
        $this->db->order_by('center_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function get_branch(){

        $this->db->select('center_id,center_name');
        $this->db->from('center_location');
        $this->db->where(array('active'=>1));
        $this->db->order_by('center_name', 'ASC');
        return $this->db->get('')->result_array();
    }
    

    function get_center_name($center_id){

        $this->db->select('center_name');
        $this->db->from('center_location');
        $this->db->where('center_id',$center_id);
        return $this->db->get('')->row_array();
    }        
    
    function add_center_location($params){
        
        $this->db->where(array('center_name'=> $params['center_name'],'center_code'=> $params['center_code']));
        $query = $this->db->get('center_location');
        $count = $query->num_rows();
        if($count > 0) {          
            return 'exist';
        }else{          
            $this->db->insert('center_location',$params);
            return $this->db->insert_id();
            //return 1;
        }
    }    
    
    function update_center_location($center_id,$params,$center_name_old,$center_code_old){
        
        if($center_name_old==$params['center_name'] and $center_code_old==$params['center_code']){
            $this->db->where('center_id',$center_id);
            $this->db->update('center_location',$params);
            return 1;
        }else{
            $this->db->group_start();
            $this->db->or_where('center_name',$params['center_name']);
            $this->db->or_where('center_code',$params['center_code']);
            $this->db->group_end();
            $this->db->where('center_id!=', $center_id);
            $query = $this->db->get('center_location');
            $count_row = $query->num_rows();
            if($count_row > 0){          
                return 2;
            }else{
                $this->db->where('center_id',$center_id);
                $this->db->update('center_location',$params);
                return 1;
            }
        }
    }    
    
    function delete_center_location($center_id)
    {
        $this->db->delete('center_location',array('center_id'=>$center_id));
        //$this->db->delete('center_heads',array('center_id'=>$id));
        //$this->db->delete('center_academy_managements',array('center_id'=>$id));
        //$this->db->delete('center_visa_managements',array('center_id'=>$id));
    }

    
    function getAllCountry()
    {  
        $this->db->select('country_id,iso3,name,phonecode,flag,phoneNo_limit');
        $this->db->from('country');
        $this->db->where('active',1);
        $this->db->order_by('name', 'ASC');
        return $this->db->get('')->result_array();
    }

    
    function getAllState($country_id)
    {  
        $this->db->select('state_id,state_name');
        $this->db->from('state');
        $this->db->where(array('country_id'=>$country_id, 'active'=>1,));
        $this->db->order_by('state_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    
    function getAllCity($state_id)
    {  
        $this->db->select('city_id,city_name');
        $this->db->from('city');
        $this->db->where(array('state_id'=>$state_id, 'active'=>1,));
        $this->db->order_by('city_name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function getAllForeignCountry()
    {  
        $this->db->select('country_id,iso3,name,phonecode,flag,phoneNo_limit');
        $this->db->from('country');
        $this->db->where(array('active'=>1,'name!='=>'India'));
        $this->db->order_by('name', 'ASC');
        return $this->db->get('')->result_array();
    }

    /*New Add Function Start*/
    
    function add_division_branch($params){
        
        if(!empty($params)){    
           
           $center_id=$params[0]['center_id'];
           $this -> db -> where('center_id', $center_id);
           $this -> db -> delete('center_divisions');
           $this->db->insert_batch('center_divisions',$params);
           return $this->db->insert_id();
        }else{
            return 0;
        }        
    }
    
    /*function add_center_heads($params){

        $this->db->from('center_heads ');
        $this->db->where(array('user_id'=>$params['user_id'],'center_id'=>$params['center_id']));
        $c = $this->db->count_all_results();
        if($c==0){
            
           $this->db->insert('center_heads ',$params);
           return $this->db->insert_id(); 
        }else{
            return 0;
        }        
    }*/
    
    function delete_user_center_head($center_id,$user_id){ 
    
        return $this->db->delete('center_heads',array('user_id'=>$user_id,'center_id'=>$center_id));
    }
    function add_center_visa_managements($params){

        $this->db->from('center_visa_managements ');
        $this->db->where(array('user_id'=>$params['user_id'],'center_id'=>$params['center_id']));
        $c = $this->db->count_all_results();
        if($c==0){
            
           $this->db->insert('center_visa_managements ',$params);
           return $this->db->insert_id(); 
        }else{
            return 0;
        }        
    }
    
    function delete_user_center_visa_managements($center_id,$user_id){ 
    
        return $this->db->delete('center_visa_managements',array('user_id'=>$user_id,'center_id'=>$center_id));
    }
    function add_center_academy_managements($params){

        $this->db->from('center_academy_managements');
        $this->db->where(array('user_id'=>$params['user_id'],'center_id'=>$params['center_id']));
        $c = $this->db->count_all_results();
        if($c==0){
            
           $this->db->insert('center_academy_managements',$params);
           return $this->db->insert_id(); 
        }else{
            return 0;
        }        
    }
    
    function delete_user_center_academy_managements($center_id,$user_id){
        return $this->db->delete('center_academy_managements',array('user_id'=>$user_id,'center_id'=>$center_id));
    }

    public function getBranchesByDivisions($division_id, $isInBody = false) {
		
        if ($isInBody == true) {
            $this->db->where(array('cl.independent_body' => 1));
        }
        if ($isInBody == false) {
            $this->db->where(array('cl.independent_body' => 0));
        }
        if ($isInBody == true) {
            $this->db->where(array('cl.physical_branch' => 0));
        }
        $this->db->select('cl.center_id,cl.center_name');
        $this->db->from('center_location cl');
        $this->db->join('center_divisions cd', 'cd.center_id = cl.center_id','left');
        //$this->db->join('department_masters dm', 'cd.division_id = dm.division_id');
        $this->db->where(array('cl.active' => 1, 'cl.is_overseas' => 0));
        $this->db->where('cd.division_id', $division_id);
		$this->db->group_by('cl.center_id');
        return $this->db->get()->result_array();
    }

    /*New Add Function End*/
}
