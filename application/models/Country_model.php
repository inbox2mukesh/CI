<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

class Country_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all_country_count()
    {
        $this->db->from('country');
        return $this->db->count_all_results();
    }    

    function getsearchCountryCount($country,$we_deal,$status){ 
        
        $query = '';
        if($country!=''){
            $query .= " `name` LIKE '%".$country."%' and ";
        }
        if($we_deal!=''){
            $query .= " `we_deal?` = ".$we_deal." and ";
        }
        if($status!=''){
            $query .= " `active` = ".$status." and";
        }
        $x = $this->db->query('
                select 
                country_id
            from `country`
            where '.$query.' `country_id` > 0
            ');
        return $x->result_array();
    } 

    /*function searchCountry($country,$we_deal,$status,$params){
        
        $query = '';
        if(isset($params) && !empty($params)){
            $query .= $this->db->limit($params['limit'], $params['offset']);
            $limit = $params['limit'];
            $offset = $params['offset'];

            $l = $limit.','.$offset;
        }
        if($country!=''){
            $query .= " `name` LIKE '%".$country."%' and ";
        }
        if($we_deal!=''){
            $query .= " `we_deal?` = ".$we_deal." and ";
        }
        if($status!=''){
            $query .= " `active` = ".$status." and";
        }
        $x = $this->db->query('
                select 
                *
            from `country`
            where '.$query.' `country_id` > 0 LIMIT '.$limit.' OFFSET '.$offset.'
            ');
        return $x->result_array();
        //print_r($this->db->last_query());exit;        
    }*/
    

    function searchCountry($params=array(),$totalRowsCount=false) {
        $this->db->select('*');
        $this->db->from('country');

        if(isset($params["search"]) && !empty($params["search"])) {
            $this->db->where("(LOWER(`name`) LIKE '%$params[search]%' || LOWER(`currency_code`) LIKE '%$params[search]%' || LOWER(`country_code`) LIKE '%$params[search]%' || LOWER(`iso3`) LIKE '%$params[search]%')");
        }
        if(isset($params["we_deal"]) && $params["we_deal"] != Null) {
            $this->db->where('`we_deal?`', $params["we_deal"]);
        }
        if(isset($params["status"]) && $params["status"] != Null) {
            $this->db->where('`active`', $params["status"]);
        }
        
        if(isset($params['limit']) && isset($params['offset']) && !$totalRowsCount){
            $this->db->limit($params['limit'], $params['offset']);
        }

        if($totalRowsCount == true){
            return $this->db->count_all_results();
        }
        else {
           return $this->db->get('')->result_array();
        }
        //print_r($this->db->last_query());exit;        
    }

    function get_all_country($params = array())
    {
        $this->db->order_by('modified', 'DESC');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('country')->result_array();
    }

    function get_all_active_countries_with_active_physical_branches($divisionId=""){
        $this->db->select('ct.country_id,ct.name');
        $this->db->from('country ct');
        $this->db->join('center_location cl','cl.country_id = ct.country_id');

        if($divisionId) {
            $this->db->join('center_divisions cd','cd.center_id = cl.center_id');
            $this->db->where("cd.division_id = $divisionId");
        }
        
        $this->db->where("cl.active = 1");
        $this->db->where("cl.physical_branch = 1");
        $this->db->where("cl.independent_body = 0");
		$this->db->where("ct.currency_code <> ''");
        $this->db->where("ct.active = 1");
        
        $this->db->order_by('ct.name','ASC');
        $this->db->group_by('ct.country_id');
        return $this->db->get('')->result_array();
    }

    function get_all_active_countries_with_active_outhouse_locations(){
        $this->db->select('ct.country_id,ct.name');
        $this->db->from('country ct');
        $this->db->join('outhouse_locations ol','ol.country_id = ct.country_id');
        $this->db->join('outhouse_location_types olt','olt.location_id = ol.id');
        $this->db->where("ol.active = 1");
        $this->db->where("olt.location_type = 3"); // 3 Event location_type
        $this->db->order_by('ct.name','ASC');
        $this->db->group_by('ct.country_id');
        return $this->db->get('')->result_array();
    }

    function get_all_active_physical_branches_by_country_id($countryId="",$divisionId=""){
        if($countryId) {
            $this->db->select('cl.center_id,cl.center_name');
            $this->db->from('center_location cl');
            $this->db->join('country ct','ct.country_id = cl.country_id');
        
            if($divisionId) {
                $this->db->join('center_divisions cd','cd.center_id = cl.center_id');
                $this->db->where("cd.division_id = $divisionId");
            }
            
            $this->db->where("cl.active = 1");
            $this->db->where("cl.physical_branch = 1");
            $this->db->where("cl.independent_body = 0");
            $this->db->where("ct.currency_code <> ''");
            $this->db->where("ct.active = 1");
            $this->db->where("ct.country_id = $countryId");
            
            $this->db->order_by('cl.center_name','ASC');
            //$this->db->group_by('cl.center_id');
            return $this->db->get('')->result_array();
        }
    }

    function getAllCountryName()
    {  
        $this->db->select('country_id,name');
        $this->db->from('country');
        $this->db->where('active',1);
        $this->db->order_by('name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function get_india_country_only()
    {        
        $this->db->where(array('active'=>1,'name='=>'India'));
        $this->db->order_by('name', 'ASC');
        return $this->db->get('country')->result_array();
    }
    
    function get_country_code()
    {   
        $this->db->select('iso3,country_code');   
        $this->db->where(array('active'=>1));
        $this->db->where('country_code !=', '');
        $this->db->order_by('country_code', 'ASC');
        return $this->db->get('country')->result_array();
    }

    function get_currency_code(){   

        $this->db->select("country_id,currency_code,name");   
        $this->db->where(array('active'=>1));
        //$this->db->where('currency_code is NOT NULL', NULL, FALSE);
        $this->db->where('currency_code !=', '');
        $this->db->order_by('name', 'ASC');
        $data=$this->db->get('country')->result_array();
        $country_code=array();
        foreach($data as $key=>$val){            
            $country_code[$val['country_id']]=$val;
        }
        return $country_code;   
    }

    function getCountry($center_id){

        $this->db->select('country_id');
        $this->db->from('center_location');
        $this->db->where('center_id',$center_id);
        return $this->db->get('')->row_array();
    }

    function Get_country_byId($country_id){

        $this->db->select('name');
        $this->db->from('country');
        $this->db->where('country_id',$country_id);
        return $this->db->get('')->row_array();
    }

    function getAllCountryNameAPI()
    {  
        $this->db->select('country_id,name');
        $this->db->from('country');
        $this->db->where(array('active'=>1,'name!='=>'India'));
        $this->db->order_by('name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function getAllCountryNameAPI_deal()
    {  
        $this->db->select('country_id,name');
        $this->db->from('country');
        $this->db->where(array('active'=>1,'we_deal?'=>1));
        $this->db->order_by('name', 'ASC');
        return $this->db->get('')->result_array();
    }

    function getCountryName($country_id)
    {  
        $this->db->select('name');
        $this->db->from('country');
        $this->db->where(array('country_id'=>$country_id));
        return $this->db->get('')->row_array();
    }

    function getAllCountryCode(){

        $this->db->select('country_code,iso3');
        $this->db->from('country');
        $this->db->where(array('active'=>1,'country_code !='=>''));
        $this->db->order_by('iso3', 'ASC');
        return $this->db->get('')->result_array();
    }

    function get_country($id)
    {
        return $this->db->get_where('country',array('country_id'=>$id))->row_array();
    }

    function get_country_id($country_code){

        $this->db->select("country_id");
        $this->db->from('country');    
        $this->db->where(array('country_code'=>$country_code));        
        return $this->db->get()->row_array();
    }

    function get_all_country_active($params = array())
    {
        $this->db->order_by('name', 'ASC');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->where(array('active'=>1));
        return $this->db->get('country')->result_array();
    }

    function get_all_country_active_except_india()
    {        
        $this->db->where(array('active'=>1,'name!='=>'India','we_deal?'=>1));
        $this->db->order_by('name', 'ASC');
        return $this->db->get('country')->result_array();
    }

    function add_country($params)
    {
        $this->db->insert('country',$params);
        return $this->db->insert_id();
    }

    function update_country($id,$params)
    {
        $this->db->where('country_id',$id);
        return $this->db->update('country',$params);
    }

    function delete_country($id)
    {
        return $this->db->delete('country',array('country_id'=>$id));
    }

    function getCountryNameAPI()
    {   
        $this->db->select('country_id,name');
        $this->db->where(array('active'=>1));
        $this->db->where('country_code !=', '');
        $this->db->order_by('name', 'ASC');
        return $this->db->get('country')->result_array();
    }
	
	function getPhoneLimitAPI($country_code){

       $this->db->select('min_phoneNo_limit,phoneNo_limit');
	   $this->db->where('iso3', $country_code);
       $this->db->where('active',1);
       return $this->db->get('country')->result_array();
    }
}