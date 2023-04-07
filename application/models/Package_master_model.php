<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Package_master_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function check_package_duplicacy($params,$package_id){

        $this->db->from('package_masters pkg');
        $this->db->where(array(
                'pkg.is_offline'        => $params['is_offline'],
                'pkg.center_id'         => $params['center_id'],
                'pkg.package_name'      => $params['package_name'],
                'pkg.discounted_amount' => $params['discounted_amount'],
                'pkg.duration_type'     => $params['duration_type'],
                'pkg.duration'          => $params['duration'],
                'pkg.test_module_id'    => $params['test_module_id'],
                'pkg.programe_id'       => $params['programe_id'],
                'pkg.country_id'        => $params['country_id'],
                'pkg.package_id!='      => $package_id,
            )
        );
        return $this->db->count_all_results();
    }

    function getOnlineOfflinePackInfo($package_id){

        $this->db->select('
            pkg.`package_id`,
            pkg.`is_offline`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            CONCAT("'.CURRENCY.' ",  pkg.`discounted_amount`) AS discounted_amount,
            pkg.`duration_type`,
            pkg.`duration`,
            pkg.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
            dt.duration_type
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= pkg.`center_id`');
        $this->db->where(array('pkg.package_id'=>$package_id));
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getPracticePackInfo($package_id){

        $this->db->select('
            pkg.`package_id`,            
            pkg.`package_name`,
            pkg.`package_desc`,           
            CONCAT("'.CURRENCY.' ",  pkg.`discounted_amount`) AS discounted_amount,
            pkg.`duration_type`,
            pkg.`duration`,
            pkg.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
            dt.duration_type
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= pkg.`center_id`');
        $this->db->where(array('pkg.package_id'=>$package_id));
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }
    function getPackCategorypp($package_id){

        $this->db->select('cat.category_name');
        $this->db->from('practice_package_category pc');
        $this->db->join('category_masters cat', 'cat.category_id = pc.category_id');
        $this->db->where(array('pc.package_id'=>$package_id));
        return $this->db->get()->result_array();
    }
    function getPackBatchpp($package_id){

        $this->db->select('b.batch_name,b.batch_id');
        $this->db->from('practice_package_masters pb');
        $this->db->join('batch_master b', 'b.batch_id = pb.center_id');
        $this->db->where(array('pb.package_id'=>$package_id));
        return $this->db->get()->result_array();
    }  
    function getPackCategory($package_id){

        $this->db->select('cat.category_name');
        $this->db->from('package_category pc');
        $this->db->join('category_masters cat', 'cat.category_id = pc.category_id');
        $this->db->where(array('pc.package_id'=>$package_id));
        return $this->db->get()->result_array();
    }

    function getPackCategoryId($package_id){

        $this->db->select('category_id');
        $this->db->from('package_category');
        $this->db->where(array('package_id'=>$package_id));
        $this->db->order_by('category_id','ASC');
        return $this->db->get()->result_array();
    }

    function getPackBatch($package_id){

        $this->db->select('b.batch_name,b.batch_id');
        $this->db->from('package_batch pb');
        $this->db->join('batch_master b', 'b.batch_id = pb.batch_id');
        $this->db->where(array('pb.package_id'=>$package_id));
        return $this->db->get()->result_array();
    }    

    function getPackTiming($package_id){

        $this->db->select('ct.course_timing');
        $this->db->from('package_timing pt');
        $this->db->join('course_timing ct', 'ct.id = pt.course_timing_id');
        $this->db->where(array('pt.package_id'=>$package_id));
        return $this->db->get()->result_array();
    }

    function get_prev_course_timing($package_id){

        $this->db->select('course_timing_id');
        $this->db->from('package_timing');
        $this->db->where(array('package_id'=>$package_id));
        return $this->db->get()->result_array();
    }

    function get_prev_batch($package_id){

        $this->db->select('batch_id');
        $this->db->from('package_batch');
        $this->db->where(array('package_id'=>$package_id));
        return $this->db->get()->result_array();
    }

    function get_prev_category($package_id){

        $this->db->select('category_id');
        $this->db->from('package_category');
        $this->db->where(array('package_id'=>$package_id));
        return $this->db->get()->result_array();
    }
    
    function getPackInfo_forPromocode($package_id)
    {
        $this->db->select('center_id,test_module_id,discounted_amount,active');
        $this->db->from('package_masters');
        $this->db->where(array('package_id'=>$package_id));
        return $this->db->get()->row_array();
    }

    function get_student_booked_rt2($student_package_id){

        $this->db->select('amount_paid,amount_paid_by_wallet,waiver,waiver_by,other_discount,amount_due,irr_dues,due_commitment_date,amount_refund,payment_file,packCloseReason');
        $this->db->from('student_package');
        $this->db->where(array('student_package_id'=>$student_package_id));
        return $this->db->get()->row_array();
    }
    
    function get_package_master($package_id)
    {
        //return $this->db->get_where('package_masters',array('package_id'=>$package_id))->row_array();
        $this->db->select('
            pkg.*,
            dt.duration_type as duration_type_name,
            ct.name as country_name,
            ct.country_id
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->join('`country` ct', 'ct.`country_id`= pkg.`country_id`');
        $this->db->where(array('pkg.package_id'=>$package_id));
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    } 
    function get_package_master_pp($package_id)
    {
        //return $this->db->get_where('package_masters',array('package_id'=>$package_id))->row_array();
        $this->db->select('
            pkg.*,
            dt.duration_type as duration_type_name,
            ct.name as country_name,
            ct.country_id
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->join('`country` ct', 'ct.`country_id`= pkg.`country_id`');
        $this->db->where(array('pkg.package_id'=>$package_id));
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }  

    function getPackageProfile($package_id){

        $this->db->select('
            center_id,test_module_id,programe_id
        ');
        $this->db->from('`package_masters`');
        $this->db->where(array('package_id'=>$package_id));
        return $this->db->get('')->row_array();
    }  

    function Get_offlineCourse_branch($country_id){

        $this->db->distinct('');
        $this->db->select('cl.center_id,cl.center_name');
        $this->db->from('package_masters pkg');
        $this->db->join('center_location cl', 'cl.center_id = pkg.center_id');
       $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'is_offline'=>1,'pkg.country_id'=>$country_id));      
        $this->db->order_by('cl.center_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function Get_offlineCourse_TestModule($country_id){

        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('package_masters pkg');
        $this->db->where(array('pkg.is_offline'=>1,'pkg.active'=>1,'pkg.country_id'=>$country_id));
        $this->db->join('test_module tm', 'tm.test_module_id = pkg.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function Get_onlineCourse_TestModule($country_id){

        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('package_masters pkg');
        //$this->db->where(array('pkg.is_offline'=>0,'pkg.active'=>1));
        $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'is_offline'=>0,'pkg.country_id'=>$country_id));
        $this->db->join('test_module tm', 'tm.test_module_id = pkg.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function Get_offlineCourse_programe($country_id){

        $this->db->distinct('');
        $this->db->select('pgm.programe_id,pgm.programe_name');
        $this->db->from('package_masters pkg');
        $this->db->where(array('pkg.is_offline'=>1,'pkg.active'=>1,'pkg.country_id'=>$country_id,'pkg.publish'=>1));
        $this->db->join('programe_masters pgm', 'pgm.programe_id = pkg.programe_id', 'left');
        $this->db->order_by('pgm.programe_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function Get_onlineCourse_programe($country_id){

        $this->db->distinct('');
        $this->db->select('pgm.programe_id,pgm.programe_name');
        $this->db->from('package_masters pkg');
        $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'is_offline'=>0,'pkg.country_id'=>$country_id));
        $this->db->join('programe_masters pgm', 'pgm.programe_id = pkg.programe_id', 'left');
        $this->db->order_by('pgm.programe_name', 'ASC');
        return $this->db->get()->result_array();
    }    

    function Get_onlineCourse_duration($country_id,$test_module_id,$programe_id,$category_id,$course_id=null){

        $this->db->distinct('');
        $this->db->select('pkg.duration,dt.duration_type');
        $this->db->from('package_masters pkg');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'is_offline'=>0,'pkg.country_id'=>$country_id));
        if($test_module_id){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id));
        }
        if($programe_id){
            $this->db->where(array('pkg.programe_id'=>$programe_id));
        }
        if($category_id)
        {
            $this->db->join('`package_category` pkg_cat', 'pkg_cat.`package_id`= pkg.`package_id`');
            $this->db->where(array('pkg_cat.category_id' => $category_id));
        }
        if ($course_id) {
            $this->db->join('`package_timing` type', 'type.`package_id`= pkg.`package_id`');
            $this->db->where(array('type.course_timing_id' => $course_id));
        }
        
        $this->db->order_by('pkg.duration', 'ASC');
        return $this->db->get()->result_array();
       //print_r($this->db->last_query());exit;
    }

    function Get_offlineCourse_duration($country_id){

        /* $this->db->distinct('');
        $this->db->select('duration');
        $this->db->from('package_masters pkg');
        $this->db->where(array('pkg.is_offline'=>1,'pkg.active'=>1));
        $this->db->order_by('pkg.duration', 'ASC');
        return $this->db->get()->result_array(); */

        $this->db->distinct('');
        $this->db->select('pkg.duration,dt.duration_type');
        $this->db->from('package_masters pkg');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'is_offline'=>1,'pkg.country_id'=>$country_id));
        $this->db->order_by('pkg.duration', 'ASC');
        return $this->db->get()->result_array();

    }    

    function Get_onlineCourse_category($test_module_id,$programe_id,$duration){


        $this->db->distinct('');
        $this->db->select('cat.category_id,category_name');
        $this->db->from('package_masters pkg');
        $this->db->join('`package_category` pkg_cat', 'pkg_cat.`package_id`= pkg.`package_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg_cat.`category_id`');
        $this->db->join('`duration_type` dur_type','dur_type.`id`=pkg.`duration_type`','left');
        if($test_module_id){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id));
        }
        if($test_module_id){
            $this->db->where(array('pkg.programe_id'=>$programe_id));
        }
        if($duration){
            $this->db->where(array('pkg.duration'=>$duration));
        }else{ }
        $this->db->order_by('cat.category_name', 'ASC');
        return $this->db->get()->result_array();


        // $this->db->distinct('');
        // $this->db->select('category_id,category_name');
        // $this->db->from('category_masters');
        // if($programe_id){
        //     $this->db->where(array('active'=>1,'test_module_id'=>$test_module_id,'programe_id'=>$programe_id));
        // }else{
        //     $this->db->where(array('active'=>1,'test_module_id'=>$test_module_id));
        // }
              
        
        // $this->db->order_by('category_name', 'ASC');
        // return $this->db->get()->result_array();
    }

    function Get_offlineCourse_category($test_module_id,$programe_id){

        $this->db->distinct('');
        $this->db->select('category_id,category_name');
        $this->db->from('category_masters');
        if($programe_id){
            $this->db->where(array('active'=>1,'test_module_id'=>$test_module_id,'programe_id'=>$programe_id));
        }else{
            $this->db->where(array('active'=>1,'test_module_id'=>$test_module_id));
        }        
        $this->db->order_by('category_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_all_testModule(){

        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('package_masters pkg');
        $this->db->join('test_module tm', 'tm.test_module_id = pkg.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_all_testModule_online(){

        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('package_masters pkg');
        $this->db->where(array('pkg.is_offline'=>0));
        $this->db->join('test_module tm', 'tm.test_module_id = pkg.test_module_id');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_all_testModule_offline(){

        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('package_masters pkg');        
        $this->db->where(array('pkg.is_offline'=>1));
        $this->db->join('test_module tm', 'tm.test_module_id = pkg.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function getPackPrice($package_id){

        $this->db->select('discounted_amount');
        $this->db->from('package_masters'); 
        $this->db->where('package_id',$package_id);        
        return $this->db->get()->row_array();
    }

    function get_all_testModule_tran(){

        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('student_package spkg');
        $this->db->join('test_module tm', 'tm.test_module_id = spkg.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_all_package_masters_count($test_module_id)
    {
        $this->db->from('package_masters');
        if($test_module_id>0){
           $this->db->where('test_module_id',$test_module_id); 
        }else{}
        return $this->db->count_all_results();
    }

    function get_online_package_masters_count($test_module_id)
    {
        $this->db->from('package_masters');
        if($test_module_id>0){
           $this->db->where(array('test_module_id'=>$test_module_id,'is_offline'=>0)); 
        }else{
            $this->db->where(array('is_offline'=>0));
        }
        return $this->db->count_all_results();
    } 

    function get_offline_package_masters_count($test_module_id)
    {
        $this->db->from('package_masters');
        if($test_module_id>0){
           $this->db->where(array('test_module_id'=>$test_module_id,'is_offline'=>1)); 
        }else{
            $this->db->where(array('is_offline'=>1));
        }
        return $this->db->count_all_results();
    }     

    
    function get_all_package_masters($test_module_id,$params = array())
    {
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            pkg.`package_id`,
            pkg.`is_offline`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pkg.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
            cl.`center_name`
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`','left');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= pkg.`center_id`', 'left');
        if($test_module_id>0){
            $this->db->where('pkg.test_module_id',$test_module_id);
        }else{
            
        }
        $this->db->order_by('tm.`test_module_name` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function search_online_package_masters($test_module_id,$params = array(),$totalRowsCount=false)
    {
        if(isset($params["limit"]) && isset($params["offset"]) && !$totalRowsCount)
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            pkg.`package_id`,
            pkg.`is_offline`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`discounted_amount`,
            pkg.`amount`,
            pkg.`duration_type`,
            pkg.`duration`,
            pkg.`active`,
            pkg.`publish`,
            pkg.`image`,
            pkg.`currency_code`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
            dt.duration_type as duration_type_name,
            cnt.name as country_name
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= pkg.`center_id`');
        $this->db->join('`package_category` pc', 'pc.`package_id`= pkg.`package_id`');
        $this->db->join('`package_batch` pb', 'pb.`package_id`= pkg.`package_id`');
        $this->db->join('`package_timing` pt', 'pt.`package_id`= pkg.`package_id`');
        $this->db->join('`category_masters` cm', 'cm.`category_id`= pc.`category_id`');
        $this->db->join('`batch_master` bm', 'bm.`batch_id`= pb.`batch_id`');
        $this->db->join('`course_timing` ct', 'ct.`id`= pt.`course_timing_id`');
        $this->db->join('`country` cnt', 'cnt.`country_id`= pkg.`country_id`');
        
        if(isset($params["search"]) && !empty($params["search"]) && $params["search"] != strtolower(PREFIX_ONLINE_PACK_ID)) {
            $this->db->where("(LOWER(pkg.package_name) LIKE '%$params[search]%' || LOWER(tm.test_module_name) LIKE '%$params[search]%' || LOWER(pgm.programe_name) LIKE '%$params[search]%' || LOWER(cm.category_name) LIKE '%$params[search]%' || LOWER(bm.batch_name) LIKE '%$params[search]%' || LOWER(ct.course_timing) LIKE '%$params[search]%' || LOWER(dt.duration_type) LIKE '%$params[search]%' || LOWER(cnt.name) LIKE '%$params[search]%')");
        }

        if(isset($params["prefix_id"]) && !empty($params["prefix_id"])) {
            $this->db->or_like('pkg.package_id',$params["prefix_id"]);
        }

        if(isset($params["country_id"]) && !empty($params["country_id"])) {
            $this->db->where_in('pkg.country_id',$params["country_id"]);
        }

        if(isset($params["programe_id"]) && !empty($params["programe_id"])) {
            $this->db->where(array('pkg.programe_id'=>$params["programe_id"]));
        }
        if(isset($params["category_id"]) && !empty($params["category_id"])) {
            $this->db->where_in('pc.category_id',$params["category_id"]);
        }
        if(isset($params["batch_id"]) && !empty($params["batch_id"])) {
            $this->db->where_in('pb.batch_id',$params["batch_id"]);
        }
        if(isset($params["duration"]) && !empty($params["duration"])) {
            $this->db->where(array('pkg.duration'=>$params["duration"]));
        }
        if(isset($params["duration_type"]) && !empty($params["duration_type"])) {
            $this->db->where(array('pkg.duration_type'=>$params["duration_type"]));
        }
        if(isset($params["course_timing"]) && !empty($params["course_timing"])) {
            $this->db->where_in('pt.course_timing_id',$params["course_timing"]); 
        }
        if(isset($params["status"]) && $params['status'] !== "") {
            $this->db->where(array('pkg.active' => $params["status"]));
        }

        if($test_module_id>0){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id,'is_offline'=>0));
        } else {
            $this->db->where(array('pkg.is_offline'=>0));
        }

        $this->db->group_by('pkg.package_id');
        $this->db->order_by('pkg.`modified` DESC');
        
        if($totalRowsCount == true) {
            return $this->db->count_all_results();
        }
        else {
            return $this->db->get('')->result_array();
        }
    }

    function get_online_package_masters($test_module_id,$params = array(),$totalRowsCount=false)
    {
        if(isset($params['limit']) && isset($params['offset']) && $totalRowsCount == false)
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            pkg.`package_id`,
            pkg.`is_offline`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`discounted_amount`,
            pkg.`amount`,
            pkg.`duration_type`,
            pkg.`duration`,
            pkg.`active`,
            pkg.`publish`,
            pkg.`image`,
            pkg.`currency_code`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
            dt.duration_type as duration_type_name,
            cnt.name as country_name
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= pkg.`center_id`');
        $this->db->join('`country` cnt', 'cnt.`country_id`= pkg.`country_id`');

        if($test_module_id>0){
           $this->db->where(array('pkg.test_module_id'=>$test_module_id,'is_offline'=>0)); 
        }else{
            $this->db->where(array('pkg.is_offline'=>0));
        }
        //$this->db->order_by('tm.`test_module_name` ASC');
        $this->db->order_by('pkg.`modified` DESC');
        
        if($totalRowsCount == true) {
            return $this->db->count_all_results();
        }
        else {
            return $this->db->get('')->result_array();
        }
        //print_r($this->db->last_query());exit;
    }

    function update_package_master_active_inactive_publish_unpublish_on_web($packageids=array(),$params=array()) {
        $this->db->where_in('package_id',$packageids);
        return $this->db->update('package_masters',$params);
    }

    function search_offline_package_masters($test_module_id,$params = array(),$totalRowsCount = false)
    {
        if(isset($params["limit"]) && isset($params["offset"]) && !$totalRowsCount)
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            pkg.`package_id`,
            pkg.`is_offline`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`discounted_amount`,
            pkg.`amount`,
            pkg.`duration_type`,
            pkg.`duration`,
            pkg.`active`,
            pkg.`publish`,
            pkg.`center_id`,
            pkg.`currency_code`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
            dt.duration_type as duration_type_name,
            cnt.name as country_name
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= pkg.`center_id`');
        $this->db->join('`package_category` pc', 'pc.`package_id`= pkg.`package_id`');
        $this->db->join('`package_batch` pb', 'pb.`package_id`= pkg.`package_id`');
        $this->db->join('`package_timing` pt', 'pt.`package_id`= pkg.`package_id`');
        $this->db->join('`category_masters` cm', 'cm.`category_id`= pc.`category_id`');
        $this->db->join('`batch_master` bm', 'bm.`batch_id`= pb.`batch_id`');
        $this->db->join('`course_timing` ct', 'ct.`id`= pt.`course_timing_id`');
        $this->db->join('`country` cnt', 'cnt.`country_id`= pkg.`country_id`');

        if(isset($params["search"]) && !empty($params["search"]) && $params["search"] != strtolower(PREFIX_INHOUSE_PACK_ID)) {
            $this->db->where("(LOWER(pkg.package_name) LIKE '%$params[search]%' || LOWER(tm.test_module_name) LIKE '%$params[search]%' || LOWER(pgm.programe_name) LIKE '%$params[search]%' || LOWER(cm.category_name) LIKE '%$params[search]%' || LOWER(bm.batch_name) LIKE '%$params[search]%' || LOWER(ct.course_timing) LIKE '%$params[search]%' || LOWER(dt.duration_type) LIKE '%$params[search]%' || LOWER(cl.center_name) LIKE '%$params[search]%' || LOWER(cnt.name) LIKE '%$params[search]%')");
        }

        if(isset($params["prefix_id"]) && !empty($params["prefix_id"])) {
            $this->db->or_like('pkg.package_id',$params["prefix_id"]);
        }

        if(isset($params["country_id"]) && !empty($params["country_id"])) {
            $this->db->where_in('pkg.country_id', $params["country_id"]);
        }
        if(isset($params["programe_id"]) && !empty($params["programe_id"])) {
            $this->db->where(array('pkg.programe_id'=>$params["programe_id"]));
        }
        if(isset($params["category_id"]) && !empty($params["category_id"])) {
            $this->db->where_in('pc.category_id',$params["category_id"]);
        }
        if(isset($params["center_id"]) && !empty($params["center_id"])) {
            $this->db->where_in('cl.center_id',$params["center_id"]);
        }
        if(isset($params["batch_id"]) && !empty($params["batch_id"])) {
            $this->db->where_in('pb.batch_id',$params["batch_id"]);
        }
        if(isset($params["duration"]) && !empty($params["duration"])) {
            $this->db->where(array('pkg.duration'=>$params["duration"]));
        }
        if(isset($params["duration_type"]) && !empty($params["duration_type"])) {
            $this->db->where(array('pkg.duration_type'=>$params["duration_type"]));
        }
        if(isset($params["course_timing"]) && !empty($params["course_timing"])) {
            $this->db->where_in('pt.course_timing_id',$params["course_timing"]); 
        }
        if(isset($params["status"]) && $params['status'] !== "") {
            $this->db->where(array('pkg.active' => $params["status"]));
        }

        if($test_module_id>0){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id,'pkg.is_offline'=>1)); 
        }else{
            $this->db->where(array('pkg.is_offline'=>1));
        }

        $this->db->group_by('pkg.package_id');
        $this->db->order_by('tm.`test_module_name` ASC');
        
        if($totalRowsCount == true) {
            return $this->db->count_all_results();
        }
        else {
            return $this->db->get('')->result_array();
        }
        //print_r($this->db->last_query());exit;
    } 

    function get_offline_package_masters($test_module_id,$params = array(),$totalRowsCount=false)
    {
        if(isset($params['limit']) && !empty($params['offset']) && $totalRowsCount == false)
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            pkg.`package_id`,
            pkg.`is_offline`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`discounted_amount`,
            pkg.`amount`,
            pkg.`duration_type`,
            pkg.`duration`,
            pkg.`active`,
            pkg.`publish`,
            pkg.`center_id`,
            pkg.`currency_code`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
            cnt.name as country_name,
            dt.duration_type as duration_type_name
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= pkg.`center_id`');
        $this->db->join('`country` cnt', 'cnt.`country_id`= pkg.`country_id`');
        
        if($test_module_id>0){
           $this->db->where(array('pkg.test_module_id'=>$test_module_id,'pkg.is_offline'=>1)); 
        }else{
            $this->db->where(array('pkg.is_offline'=>1));
        }
        $this->db->order_by('tm.`test_module_name` ASC');

        if($totalRowsCount == true) {
            return $this->db->count_all_results();
        }
        else {
            return $this->db->get('')->result_array();
        }
        //print_r($this->db->last_query());exit;
    } 

    function get_single_module_pack(){

        $this->db->distinct('');
        $this->db->select('pkg.category_id,cat.category_name');
        $this->db->from('package_masters pkg');
        $this->db->join('category_masters cat', 'cat.category_id = pkg.category_id', 'left');
        $this->db->where('pkg.category_id!=',NULL);
        $this->db->order_by('cat.category_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_all_package_active()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.active'=>1,'pkg.is_offline'=>0));
        $this->db->order_by('pkg.`package_id` DESC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function get_all_package_active_long()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.active'=>1,'pkg.is_offline'=>0));
        $this->db->order_by('pkg.`package_id` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function get_all_offline_package_active_long()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.active'=>1,'pkg.is_offline'=>1));
        $this->db->order_by('pkg.`package_id` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }
    
    function get_all_ielts_package_active()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.test_module_id'=>IELTS_ID, 'pkg.active'=>1,'pkg.is_offline'=>0));
        $this->db->order_by('pkg.`amount` ASC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    } 

    function get_all_cd_ielts_package_active()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.test_module_id'=>IELTS_CD_ID, 'pkg.active'=>1,'pkg.is_offline'=>0));
        $this->db->order_by('pkg.`amount` ASC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function get_all_ielts_package_active_long()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.test_module_id'=>IELTS_ID, 'pkg.active'=>1,'pkg.is_offline'=>0));
        $this->db->order_by('pkg.`amount` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    } 

    function get_all_cd_ielts_package_active_long()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.test_module_id'=>IELTS_CD_ID, 'pkg.active'=>1,'pkg.is_offline'=>0));
        $this->db->order_by('pkg.`amount` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    } 

    
    function get_all_offline_ielts_package_active_long()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.test_module_id'=>IELTS_ID, 'pkg.active'=>1,'pkg.is_offline'=>1));
        $this->db->order_by('pkg.`amount` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }
    
    function get_all_pte_package_active()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.test_module_id'=>PTE_ID, 'pkg.active'=>1));
        $this->db->order_by('pkg.`amount` ASC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }
    
    function get_all_pte_package_active_long()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.test_module_id'=>PTE_ID, 'pkg.active'=>1,'is_offline'=>0));
        $this->db->order_by('pkg.`amount` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }
    
    function get_all_offline_pte_package_active_long()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.test_module_id'=>PTE_ID, 'pkg.active'=>1,'is_offline'=>1));
        $this->db->order_by('pkg.`amount` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }
    
    function get_all_se_package_active()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.test_module_id'=>SE_ID, 'pkg.active'=>1));
        $this->db->order_by('pkg.`amount` ASC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function get_all_se_package_active_long()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`', 'left');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`category_masters` cat', 'cat.`category_id`= pkg.`category_id`', 'left');
        $this->db->where(array('pkg.test_module_id'=>SE_ID, 'pkg.active'=>1,'is_offline'=>0));
        $this->db->order_by('pkg.`amount` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function Get_online_pack($test_module_id,$programe_id,$category_id,$duration,$country_id,$course_type,$limit=null,$offset=null){
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }

        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            GROUP_CONCAT(DISTINCT cat.`category_name` SEPARATOR ", ") as category_name,
            GROUP_CONCAT(DISTINCT cat.`category_id`) as category_id,
            tm.`test_module_id`,
            pgm.`programe_id`,
            cl.`center_id`,
            `dur_type`.`duration_type`,
            GROUP_CONCAT(DISTINCT course_timing.course_timing  SEPARATOR ", ") as course_timing,
            `pkg`.`image`,
            `pkg`.`currency_code`,
            `pkg`.`country_id`,             
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm','pkg.`programe_id`=pgm.`programe_id`');
        $this->db->join('`test_module` tm','pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`package_category` pcat','pcat.`package_id`=pkg.`package_id`');
        $this->db->join('`category_masters` cat','cat.`category_id`=pcat.`category_id`');
        $this->db->join('`center_location` cl','cl.`center_id`=pkg.`center_id`');
        $this->db->join('`duration_type` dur_type','dur_type.`id`=pkg.`duration_type`');
        $this->db->join('`package_timing` pk_time','pk_time.`package_id`=pkg.`package_id`');
        $this->db->join('`course_timing`','course_timing.`id`=pk_time.`course_timing_id`');
        if($test_module_id){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id));
        }else{ }
        if($programe_id){
            $this->db->where(array('pkg.programe_id'=>$programe_id));
        }else{ }
        if($category_id){
            $this->db->join('`package_category` pcat_temp','pcat_temp.`package_id`=pkg.`package_id`');
            $this->db->where(array('pcat_temp.category_id'=>$category_id));
        }else{ }
        if($duration){
            $this->db->where(array('pkg.duration'=>$duration));
        }else{ }
        if($course_type){
          $this->db->join('`package_timing` pk_time1','pk_time1.`package_id`=pkg.`package_id`');
            $this->db->where(array('pk_time1.course_timing_id'=>$course_type));
        }else{ }
        $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'is_offline'=>0,'pkg.country_id'=>$country_id));
        $this->db->group_by('pkg.package_id');
        $this->db->order_by('pkg.created DESC','pkg.`amount` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }
    function Get_online_pack_count($test_module_id,$programe_id,$category_id,$duration,$country_id,$limit=null,$offset=null){
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->select('pkg.`package_id`');
        $this->db->from('`package_masters` pkg');     
        if($test_module_id){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id));
        }else{ }
        if($programe_id){
            $this->db->where(array('pkg.programe_id'=>$programe_id));
        }else{ }
        if($category_id){
            $this->db->where(array('pkg.category_id'=>$category_id));
        }else{ }
        if($duration){
            $this->db->where(array('pkg.duration'=>$duration));
        }else{ }
        $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'is_offline'=>0,'pkg.country_id'=>$country_id));
        $this->db->group_by('pkg.package_id');
        $this->db->order_by('pkg.created DESC','pkg.`amount` DESC');
        return $this->db->get('')->num_rows();
    }

    function Get_offline_pack($center_id,$test_module_id,$programe_id,$category_id,$duration,$country_id){

        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            GROUP_CONCAT(DISTINCT cat.`category_name`  SEPARATOR ", ") as category_name,
            tm.`test_module_id`,
            pgm.`programe_id`,
            cl.`center_id`,
            `dur_type`.`duration_type`,
            GROUP_CONCAT(DISTINCT course_timing.course_timing) as course_timing,
            `pkg`.`image`,
             `pkg`.`currency_code`,
             cl.`center_name`,
             `pkg`.`country_id`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm','pkg.`programe_id`=pgm.`programe_id`','left');
        $this->db->join('`test_module` tm','pkg.`test_module_id`=tm.`test_module_id`', 'left');
        $this->db->join('`package_category` pcat','pcat.`package_id`=pkg.`package_id`','left');
        $this->db->join('`category_masters` cat','cat.`category_id`=pcat.`category_id`','left');
        $this->db->join('`center_location` cl','cl.`center_id`=pkg.`center_id`','left');
        $this->db->join('`duration_type` dur_type','dur_type.`id`=pkg.`duration_type`','left');
        $this->db->join('`package_timing` pk_time','pk_time.`package_id`=pkg.`package_id`','left');
        $this->db->join('`course_timing`','course_timing.`id`=pk_time.`course_timing_id`','left');
        if($center_id){
            $this->db->where(array('pkg.center_id'=>$center_id));
        }else{ }

        if($test_module_id){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id));
        }else{ }
        if($programe_id){
            $this->db->where(array('pkg.programe_id'=>$programe_id));
        }else{ }
        if($category_id){
            $this->db->where(array('pkg.category_id'=>$category_id));
        }else{ }
        if($duration){
            $this->db->where(array('pkg.duration'=>$duration));
        }else{ }
      
        $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'is_offline'=>1,'pkg.country_id'=>$country_id));
        $this->db->group_by('pkg.package_id');
         return $this->db->get('')->result_array();
      //print_r($this->db->last_query());exit;
    }

    function Get_offline_pack_old($center_id,$test_module_id,$programe_id,$category_id,$duration){
        
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cat.`category_name`,
            tm.`test_module_id`,
            pgm.`programe_id`,
            cl.`center_id`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm','pkg.`programe_id`=pgm.`programe_id`','left');
        $this->db->join('`test_module` tm','pkg.`test_module_id`=tm.`test_module_id`', 'left');
        $this->db->join('`category_masters` cat','cat.`category_id`=pkg.`category_id`','left');
         $this->db->join('`center_location` cl','cl.`center_id`=pkg.`center_id`','left');
        if($center_id){
            $this->db->where(array('pkg.center_id'=>$center_id));
        }else{ }
        if($test_module_id){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id));
        }else{ }
        if($programe_id){
            $this->db->where(array('pkg.programe_id'=>$programe_id));
        }else{ }
        if($category_id){
            $this->db->where(array('pkg.category_id'=>$category_id));
        }else{ }
        if($duration){
            $this->db->where(array('pkg.duration'=>$duration));
        }else{ }

        $this->db->where(array('pkg.active'=>1,'is_offline'=>1));
        $this->db->order_by('pkg.`amount` ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }    

    function get_all_package($programe_id,$test_module_id,$id)
    {
        $this->db->select('`package_id`');
        $this->db->from('`student_package`');
        $this->db->where(array('student_id'=>$id, 'active'=>1));
        $up = $this->db->get('')->row_array();
        $package_id = $up['package_id'];

        if(!$package_id){

            $package_id=0;            
            $this->db->select('
            `package_id`, 
            `package_name`,
            `package_desc`,
            `amount`,
             CONCAT(`duration`, " Day(s)") as duration,
             IF(`package_id` = '.$package_id.', 1, 0) as bought,
            ');
            $this->db->from('`package_masters`');
            $this->db->where(array('programe_id'=>$programe_id,'test_module_id'=>$test_module_id, 'active'=>1));        
            $this->db->order_by('`amount` ASC');
            return $this->db->get('')->result_array();

        }else{

            $this->db->select('
            `package_id`,
            `package_name`,
            `package_desc`,
            `amount`,
            CONCAT(`duration`, " Day(s)") as duration,
             IF(package_id = '.$package_id.', 1, 0) as bought,                       
            ');
            $this->db->from('`package_masters`');
            $this->db->where(array('programe_id'=>$programe_id,'test_module_id'=>$test_module_id, 'active'=>1));        
            $this->db->order_by('`amount` ASC');
            return $this->db->get('')->result_array();
            //print_r($this->db->last_query());exit;
        }        
    }

    function get_all_package_history($id,$programe_id,$test_module_id){

        $this->db->select('         
            
            pkg.package_id,
            pkg.package_name,
            pkg.package_desc,
            CONCAT("'.CURRENCY.' ", pkg.amount) AS package_cost,
            CONCAT(pkg.duration, " Days") as package_duration,
            spkg.`student_package_id`, 
            spkg.`order_id`,
            spkg.`active` as package_status,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`amount`/100,2)) AS amount_paid,
            spkg.subscribed_on as `subscribed_on`,
            spkg.expired_on as `expired_on`,
            spkg.requested_on as `requested_on`,
        ');
        $this->db->from('`student_package` spkg');
        $this->db->join('`package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`');
        $this->db->where(array('spkg.programe_id'=>$programe_id,'spkg.test_module_id'=>$test_module_id, 'spkg.student_id'=>$id));
        $this->db->order_by('spkg.`requested_on` DESC');
        return $this->db->get('')->result_array();

    }

    function getOnlinePackTakenCount($id){

        $this->db->from('student_package');
        $this->db->where(array('student_id'=>$id,'pack_type'=>'online'));
        return $this->db->count_all_results();

    }
    
    function getOfflinePackTakenCount($id){

        $this->db->from('student_package');
        $this->db->where(array('student_id'=>$id,'pack_type'=>'offline'));
        return $this->db->count_all_results();
    }

    function getOnlinePackActiveCount($id){

        $this->db->from('student_package');
        $this->db->where(array('student_id'=>$id,'pack_type'=>'online','active'=>1));
        return $this->db->count_all_results();
    }

    function getExamActiveCount($id){

        $this->db->from('student_package');
        $this->db->where(array('student_id'=>$id,'pack_type'=>'exam','active>='=>1));
        return $this->db->count_all_results();
    }

    function getOfflinePackActiveCount($id){

        $this->db->from('student_package');
        $this->db->where(array('student_id'=>$id,'pack_type'=>'offline','active'=>1));
        return $this->db->count_all_results();
    }

    function getActiveOnlinePackCount($sid){  

        $this->db->from('student_package');
        $this->db->where(array('student_id'=> $sid,'pack_type'=>'online','active'=>1));
        return $this->db->count_all_results();
    }

    function getActiveOnlinePack($sid){  
        $this->db->select('package_id');
        $this->db->from('student_package');
        $this->db->where(array('student_id'=> $sid,'pack_type'=>'online','active'=>1));
        $this->db->order_by('`student_package_id` DESC');
        return $this->db->get('')->row_array();
    }

    function getActiveOnlinePackCategory($package_id){  
        $this->db->select('test_module_id, programe_id,category_id');
        $this->db->from('package_masters');
        $this->db->where(array('package_id'=> $package_id));
        return $this->db->get('')->row_array();
    }

    function get_student_pack_subscribed_online($id,$token){

        $this->db->select(' 
            pkg.package_id,
            pkg.package_name,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`amount`/100,2)) AS package_cost,  
            CONCAT("'.CURRENCY.' ", pkg.discounted_amount) AS discounted_amount,          
            spkg.package_duration,
            spkg.`student_id`,
            spkg.`student_package_id`, 
            spkg.`order_id`,
            spkg.`payment_id`,
            spkg.`method`,
            spkg.`packCloseReason`,
            spkg.`active` as package_status,
            spkg.is_terminated,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`waiver`/100,2)) AS waiver,
            spkg.waiver_by,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`other_discount`/100,2)) AS other_discount,
            FORMAT(spkg.`amount_paid`/100,2) AS amount_paid,            
            FORMAT(spkg.`ext_amount`/100,2) AS ext_amount,
            FORMAT(spkg.`amount_due`/100,2) AS amount_due,
            FORMAT(spkg.`irr_dues`/100,2) AS irr_dues,
            spkg.`due_commitment_date`,
            FORMAT(spkg.`amount_refund`/100,2) AS amount_refund,
            FORMAT(spkg.`amount_paid_by_wallet`/100,2) AS amount_paid_by_wallet,
            spkg.subscribed_on_str as `subscribed_on`,
            spkg.expired_on_str as `expired_on`,
            spkg.subscribed_on as `subscribed_on2`,
            spkg.expired_on as `expired_on2`,
            spkg.requested_on as `requested_on`,
            pgm.programe_name,
            tm.test_module_name,
            cl.center_name,
            spkg.classroom_id,
            cr.classroom_name,
            spkg.`onHold`,
            `holdDateFrom`,
            `holdDateTo`,
        ');
        $this->db->from('`student_package` spkg');
        $this->db->join('`package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= spkg.`center_id`', 'left');
        $this->db->join('`classroom` cr', 'cr.`id`= spkg.`classroom_id`', 'left');
        if($token=='Bysid'){
            $this->db->where(array('spkg.student_id'=>$id,'pack_type'=>'online','spkg.status'=>'succeeded'));
        }else{
            $this->db->where(array('spkg.student_package_id'=>$id,'pack_type'=>'online','spkg.status'=>'succeeded'));
        }               
        $this->db->order_by('spkg.`student_package_id` DESC');
        return $this->db->get('')->result_array();
    }

    function get_student_pack_subscribed_offline($id,$token){

        $this->db->select(' 
            pkg.package_id,
            spkg.package_name,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`amount`/100,2)) AS package_cost,            
            spkg.package_duration,
            spkg.`student_id`,
            spkg.`student_package_id`, 
            spkg.`order_id`,
            spkg.`payment_id`,
            spkg.`tran_id`,
            spkg.`payment_file`,
            spkg.`application_file`,
            spkg.`method`,
            spkg.`packCloseReason`,
            spkg.`active` as package_status,
            spkg.`is_terminated`,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`waiver`/100,2)) AS waiver,
            spkg.waiver_by,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`other_discount`/100,2)) AS other_discount,
            FORMAT(spkg.`amount_paid`/100,2) AS amount_paid,
            FORMAT(spkg.`ext_amount`/100,2) AS ext_amount,
            FORMAT(spkg.`amount_due`/100,2) AS amount_due,
            FORMAT(spkg.`irr_dues`/100,2) AS irr_dues,
            spkg.`due_commitment_date`,
            FORMAT(spkg.`amount_refund`/100,2) AS amount_refund,
            FORMAT(spkg.`amount_paid_by_wallet`/100,2) AS amount_paid_by_wallet,
            spkg.subscribed_on_str as `subscribed_on`,
            spkg.expired_on_str as `expired_on`,
            spkg.subscribed_on as `subscribed_on2`,
            spkg.expired_on as `expired_on2`,
            spkg.requested_on as `requested_on`,
            pgm.programe_name,
            tm.test_module_name,
            cl.center_name,
            cr.classroom_name,
            spkg.classroom_id,
        ');
        $this->db->from('`student_package` spkg');
        $this->db->join('`package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= spkg.`center_id`', 'left');
        $this->db->join('`classroom` cr', 'cr.`id`= spkg.`classroom_id`', 'left');
        if($token=='Bysid'){
            $this->db->where(array('spkg.student_id'=>$id,'pack_type'=>'offline','spkg.status'=>'succeeded'));
        }else{
            $this->db->where(array('spkg.student_id'=>$id,'pack_type'=>'offline','spkg.status'=>'succeeded'));
        }               
        $this->db->order_by('spkg.`student_package_id` DESC');
        return $this->db->get('')->result_array();
    }

    function getStudentExamSubscribed($id,$token){

        $this->db->select('
            evd.`id` as exam_id,
            evd.`exam_date`,
            evd.`city`,
            evd.`venue_name`,
            evd.`venue_address`,
            spkg.`student_id`,
            spkg.`student_package_id`, 
            spkg.`special_case`,
            spkg.`minor`,
            spkg.`exam_date` as `pte_date`,
            spkg.`pack_type`,
            spkg.`speaking_date`,
            spkg.`speaking_time_slot`,
            spkg.`result_date`,
            spkg.`student_id_thirdParty`,
            spkg.`pte_username`,
            spkg.`student_password`,
            spkg.`challan_no`,
            spkg.`order_id`,
            spkg.`payment_id`,
            spkg.`tran_id`,
            spkg.`payment_file`,
            spkg.`method`,
            spkg.`actualResultdate`,
            spkg.`listening`,
            spkg.`reading`,
            spkg.`writing`,
            spkg.`speaking`,
            spkg.`overAll`,
            spkg.`trf_File`,
            spkg.`reEvaluatedScore`,
            spkg.`reEvaluationMethod`,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`amount_paid_reEvaluation`/100,2)) AS amount_paid_reEvaluation,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`amount_paid_by_wallet_reEvaluation`/100,2)) AS amount_paid_by_wallet_reEvaluation,
            spkg.`reEvaluationTranId`,
            spkg.`reEvaluationPaymentScreenshot`,
            spkg.`cancelRemarks`,            
            spkg.`tranHistory`,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`rsAmount`/100,2)) AS rsAmount,
            spkg.`rsTranId`,
            spkg.`rsPaymentScreenshot`,
            spkg.`packCloseReason`,
            spkg.`active` as package_status,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`waiver`/100,2)) AS waiver,
            spkg.`waiver` as plainWaiver,
            spkg.waiver_by,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`other_discount`/100,2)) AS other_discount,
            spkg.`other_discount` as plainDiscount,
            FORMAT(spkg.`amount_paid`/100,2) AS amount_paid,
            spkg.`amount_paid` as plainAmount,
            spkg.`amount_paid_by_wallet` as plain_amount_paid_by_wallet,
            FORMAT(spkg.`amount_paid_by_wallet`/100,2) AS amount_paid_by_wallet,
            FORMAT(spkg.`amount`/100,2) AS amount,            
            FORMAT(spkg.`amount_refund`/100,2) AS amount_refund,
            spkg.requested_on as `requested_on`,
            pgm.programe_name,
            pgm.programe_id,
            tm.test_module_name,
            tm.test_module_id,
            lm.`language`,
        ');
        $this->db->from('`student_package` spkg');
        $this->db->join('`exam_venue_dates` evd', 'evd.`id`= spkg.`package_id`');
        $this->db->join('`test_module` tm', 'spkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'spkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`language_master` lm', 'lm.`id`= spkg.`first_language`');
        if($token=='Bysid'){
            $this->db->where(array('spkg.student_id'=>$id,'pack_type'=>'exam'));
        }else{
            $this->db->where(array('spkg.student_package_id'=>$id,'pack_type'=>'exam'));
        }               
        $this->db->order_by('spkg.`requested_on` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getStudentExamLead($id,$token){

        $this->db->select('
            evd.`id` as exam_id,
            evd.`exam_date`,
            evd.`city`,
            evd.`venue_name`,
            evd.`venue_address`,
            spkg.`student_id`,
            spkg.`student_package_id`, 
            spkg.`special_case`,
            spkg.`minor`,
            spkg.`exam_date` as `pte_date`,
            spkg.`payment_file`,
            spkg.`method`,
            spkg.`packCloseReason`,
            spkg.`active` as package_status,
            spkg.`is_terminated`,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`waiver`/100,2)) AS waiver,
            spkg.waiver_by,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`other_discount`/100,2)) AS other_discount,
            FORMAT(spkg.`amount_paid`/100,2) AS amount_paid,
            FORMAT(spkg.`amount_paid_by_wallet`/100,2) AS amount_paid_by_wallet,
            FORMAT(spkg.`amount`/100,2) AS amount,            
            FORMAT(spkg.`amount_refund`/100,2) AS amount_refund,
            spkg.requested_on as `requested_on`,
            pgm.programe_name,
            pgm.programe_id,
            tm.test_module_name,
            tm.test_module_id,
            lm.`language`,
        ');
        $this->db->from('`student_package` spkg');
        $this->db->join('`exam_venue_dates` evd', 'evd.`id`= spkg.`package_id`');
        $this->db->join('`test_module` tm', 'spkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'spkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`language_master` lm', 'lm.`id`= spkg.`first_language`');
        if($token=='Bysid'){
            $this->db->where(array('spkg.student_id'=>$id,'pack_type'=>'exam'));
        }else{
            $this->db->where(array('spkg.student_package_id'=>$id,'pack_type'=>'exam'));
        }               
        $this->db->order_by('spkg.`requested_on` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function get_student_pack_subscribed($id,$token){

        $this->db->select('
            pkg.package_id, 
            spkg.package_name,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`amount`/100,2)) AS package_cost,
            CONCAT("'.CURRENCY.' ", pkg.discounted_amount) AS discounted_amount,
            CONCAT(pkg.duration, " Days") as package_duration,
            spkg.`student_id`,
            spkg.`student_package_id`, 
            spkg.`pack_type`,
            spkg.`order_id`,
            spkg.`payment_id`,
            spkg.`tran_id`,
            spkg.`payment_file`,
            spkg.`application_file`,
            spkg.`method`,
            spkg.`packCloseReason`,
            spkg.`active` as package_status,
            spkg.`is_terminated`,
            spkg.`holdDateFrom`,
            spkg.`holdDateTo`,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`waiver`/100,2)) AS waiver,
            spkg.waiver_by,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`other_discount`/100,2)) AS other_discount,
            FORMAT(spkg.`amount_paid`/100,2) AS amount_paid,
            FORMAT(spkg.`ext_amount`/100,2) AS ext_amount,
            FORMAT(spkg.`amount_due`/100,2) AS amount_due,
            FORMAT(spkg.`irr_dues`/100,2) AS irr_dues,
            spkg.`due_commitment_date`,
            FORMAT(spkg.`amount_refund`/100,2) AS amount_refund,
            spkg.subscribed_on as `subscribed_on`,
            spkg.expired_on as `expired_on`,
            spkg.`expired_on` as expired_on2,
            spkg.requested_on as `requested_on`,
            pgm.programe_name,
            pgm.programe_id,
            tm.test_module_name,
            tm.test_module_id,
            cl.center_name,
            cl.center_id,
            b.batch_name,
        ');
        $this->db->from('`student_package` spkg');
        $this->db->join('`package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`batch_master` b', 'b.`batch_id`=spkg.`batch_id`','left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= spkg.`center_id`', 'left');
        if($token=='Bysid'){
            $this->db->where(array('spkg.student_id'=>$id));
        }else{
            $this->db->where(array('spkg.student_package_id'=>$id));
        }               
        $this->db->order_by('spkg.`requested_on` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }    

    function cur_pack($id,$token){

        $this->db->select(' 
            pkg.package_id,
            pkg.package_name, 
            spkg.`active` as package_status, 
            FORMAT(spkg.`amount_due`/100,2) AS amount_due,
            spkg.subscribed_on as `subscribed_on`,
            spkg.expired_on as `expired_on`,
            spkg.`subscribed_on` as subscribed_on2,
            spkg.`expired_on` as expired_on2,
            spkg.`classroom_id`,
            cr.`classroom_name`,
            cr.`active` as classroom_status,
            pkg.is_offline,
            spkg.student_package_id,
            spkg.packCloseReason,
            tm.`test_module_name`,
            pgm.`programe_name`,
            spkg.pack_type,
            GROUP_CONCAT(DISTINCT cat.`category_name`  SEPARATOR ", ") as category_name,
            GROUP_CONCAT(DISTINCT cat.`category_id`) as category_id,
            batch.batch_name
        ');
        $this->db->from('`student_package` spkg');
        $this->db->join('`package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`');
        $this->db->join('`classroom` cr', 'cr.`id`= spkg.`classroom_id`'); 
        $this->db->join('`package_category` pk_ctg', 'pk_ctg.`package_id`= pkg.`package_id`'); 
        $this->db->join('`batch_master` batch', 'batch.`batch_id`= spkg.`batch_id`');         
        $this->db->join('`test_module` tm','pkg.`test_module_id`=tm.`test_module_id`', 'left'); 
        $this->db->join('`programe_masters` pgm','pgm.`programe_id`=spkg.`programe_id`','left'); 
        $this->db->join('`category_masters` cat','cat.`category_id`=pk_ctg.`category_id`','left');     
        if($token=='Bysid'){
            $this->db->where(array('spkg.student_id'=>$id));
        }else{
            $this->db->where(array('spkg.student_package_id'=>$id));
        }  
        $this->db->where('spkg.status','succeeded'); 
        $this->db->group_by('spkg.student_package_id');            
        $this->db->order_by('spkg.`active` DESC,spkg.`requested_on` DESC');
       return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }
  
    

    function getAllOrder($id,$orderdate=null){

        $this->db->select(' 
            pkg.package_id,
            spkg.package_name,
            spkg.`student_package_id`,
            spkg.`active` as package_status,
            spkg.subscribed_on as `subscribed_on`,
            spkg.expired_on as `expired_on`,
            spkg.requested_on as `requested_on`,
            tm.`test_module_name`,
            pgm.`programe_name`,
            spkg.pack_type,            
        ');
        $this->db->from('`student_package` spkg');
        $this->db->join('`package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`');     
        $this->db->join('`test_module` tm','pkg.`test_module_id`=tm.`test_module_id`', 'left'); 
        $this->db->join('`programe_masters` pgm','pgm.`programe_id`=spkg.`programe_id`','left');  
        $this->db->where(array('spkg.student_id'=>$id));
        if($orderdate){
            $this->db->like('spkg.requested_on',$orderdate);
        }
        $this->db->where(array('spkg.status'=>'succeeded'));         
        $this->db->group_start();
        $this->db->or_where(array('spkg.pack_type'=>'offline'));
        $this->db->or_where(array('spkg.pack_type'=>'online'));
        $this->db->group_end();
        $this->db->order_by('spkg.`requested_on` DESC');
        $this->db->limit(5);
       return  $this->db->get('')->result_array();
    }

    function getAllOrder_pp($id,$orderdate=null)
    {
        $this->db->select(' 
            pkg.package_id,
            spkg.package_name,
            spkg.`student_package_id`,
            spkg.`active` as package_status,
            spkg.subscribed_on as `subscribed_on`,
            spkg.expired_on as `expired_on`,
            spkg.requested_on as `requested_on`, 
            tm.`test_module_name`,
            pgm.`programe_name`, 
            spkg.pack_type,           
        ');
        $this->db->from('`student_package` spkg');
        $this->db->join('`practice_package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`'); 
        if($orderdate){
            $this->db->like('spkg.requested_on',$orderdate);
        } 
        $this->db->where(array('spkg.status'=>'succeeded'));               
        $this->db->where(array('spkg.student_id'=>$id,'spkg.pack_type'=>'practice'));        
        $this->db->join('`test_module` tm','pkg.`test_module_id`=tm.`test_module_id`', 'left'); 
        $this->db->join('`programe_masters` pgm','pgm.`programe_id`=spkg.`programe_id`','left');
        $this->db->order_by('spkg.`requested_on` DESC');
        $this->db->limit(5);
        return $this->db->get('')->result_array();
    }  


    /*
     * Get all tran count IELTS
     */
    function get_all_transaction_count($roleName,$userBranch,$test_module_id)
    {
        $this->db->from('student_package');
        if($roleName==ADMIN){            
            if($test_module_id>0){
                $this->db->where(array('test_module_id'=>$test_module_id));
            }else{
                
            }
        }else{
            if($test_module_id>0){
                if($userBranch){
                    $this->db->where(array('test_module_id'=>$test_module_id));
                    $this->db->where_in('center_id', $userBranch);
                }else{
                    $userBranch=0;
                    $this->db->where(array('test_module_id'=>$test_module_id));
                    $this->db->where_in('center_id', $userBranch);
                }
            }else{
                if($userBranch){                    
                    $this->db->where_in('center_id', $userBranch);
                }else{
                    $userBranch=0;                    
                    $this->db->where_in('center_id', $userBranch);
                } 
            }                        
        } 
        return $this->db->count_all_results();
    }

    function get_all_package_history_admin($roleName,$userBranch,$params = array(),$test_module_id){

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('         
            
            pkg.package_id,
            pkg.package_name,
            spkg.`student_package_id`, 
            spkg.`email`,
            spkg.`contact`,
            spkg.`order_id`,
            spkg.`payment_id`,
            spkg.`method`,
            spkg.`active` as package_status,
            spkg.`pack_type`,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`amount`/100,2)) AS amount,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`amount_paid`/100,2)) AS amount_paid,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`waiver`/100,2)) AS waiver,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`other_discount`/100,2)) AS other_discount,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`amount_due`/100,2)) AS amount_due,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`amount_refund`/100,2)) AS amount_refund,
            spkg.subscribed_on `subscribed_on`,
            spkg.expired_on as `expired_on`,
            spkg.requested_on as `requested_on`,
            std.id,
            std.fname,
            std.lname,
        ');
            $this->db->from('`student_package` spkg');
            $this->db->join('`package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`', 'left');
            $this->db->join('`students` std', 'std.`id`= spkg.`student_id`');
            if($roleName==ADMIN){
                if($test_module_id>0){
                    $this->db->where(array('spkg.test_module_id'=> $test_module_id ));
                }else{

                }
            }else{
                if($test_module_id>0){
                    $this->db->where(array('spkg.test_module_id'=> $test_module_id ));
                    $this->db->where_in('spkg.center_id', $userBranch);
                }else{
                    $this->db->where_in('spkg.center_id', $userBranch);
                }
            }
            $this->db->where('spkg.status =', 'succeeded');    
            $this->db->order_by('spkg.`requested_on` DESC');
            return $this->db->get('')->result_array();
    } 

    function add_package_master($params)
    {
        $this->db->insert('package_masters',$params);
        return $this->db->insert_id();
    }

    // function add_package_countries($params=array()) {
    //     $this->db->insert('package_countries',$params);
    //     return $this->db->insert_id();
    // }

    function delete_package_course_timing($package_id){
        $this->db->delete('package_timing',array('package_id'=>$package_id)); 
    }

    function delete_package_batch($package_id){
        $this->db->delete('package_batch',array('package_id'=>$package_id)); 
    }

    function delete_package_category($package_id){
        $this->db->delete('package_category',array('package_id'=>$package_id)); 
    }    

    function add_package_course_timing($params){
         
        $this->db->insert('package_timing',$params);
        return $this->db->insert_id();
    }

    function add_package_batch($params){
        
        $this->db->insert('package_batch',$params);
        return $this->db->insert_id();
    }

    function add_package_category($params){
        
        $this->db->insert('package_category',$params);
        return $this->db->insert_id();
    }

    function update_package_master($package_id,$params)
    {
        $this->db->where('package_id',$package_id);
        return $this->db->update('package_masters',$params);
    }

    function delete_package_master($package_id)
    {
        return $this->db->delete('package_masters',array('package_id'=>$package_id));
    }

    function startPackOnHold($today){

        $params = array(
            'active' => 0,
            'onHold'=>1,
            'packCloseReason'=>'Pack On Hold'
        );
        $this->db->where(array('holdDateFrom'=>$today,'onHold'=>0));
        return $this->db->update('student_package',$params);

    }

    function activatePackWhichIsOnHold_finished($today){        
        $params = array(
            'active' => 1,
            'onHold'=>0,
            'packCloseReason'=>NULL
        );
        $this->db->where(array('holdDateTo_str'=>$today,'onHold'=>1));
        return $this->db->update('student_package',$params);
      // print_r($this->db->last_query());exit;
    }

    function DeactivateExpiredPack($today)
    {
        $params = array(
            'active' => 0,
            'packCloseReason'=>'Expired'
        );
        $this->db->where('expired_on_str<=',$today);
        return $this->db->update('student_package',$params);
    } 

    
    function getExpiredPackage(){

        $this->db->select('             
            pkg.`package_name`,
            spkg.`contact`,
            spkg.`email`,
            std.fname,
        ');
        $this->db->from('`student_package` spkg');
        $this->db->join('`package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`');
        $this->db->join('`students` std', 'std.`id`= spkg.`student_id`');
        $this->db->where(array('spkg.expired_on'=> TODAY,'spkg.active'=>0));
        return $this->db->get('')->result_array();
    }

    function get_package_list_online($test_module_id,$programe_id){       
        
        $this->db->select('
            pkg.`package_id`,
            pkg.`package_name`,
            dt.`duration_type`,
            pkg.`duration`,
            CONCAT("'.CURRENCY.' ", pkg.`discounted_amount`) AS discounted_amount,
            CONCAT("'.CURRENCY.' ", pkg.`amount`) AS amount,                        
        ');
        $this->db->from('package_masters pkg');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->where(array('pkg.test_module_id'=> $test_module_id,'pkg.programe_id'=> $programe_id,'pkg.active'=>1,'pkg.is_offline'=>0));  
        $this->db->order_by('pkg.discounted_amount', 'DESC');
        return $this->db->get()->result_array();
    }

    function get_package_list_offline($test_module_id,$programe_id,$center_id){       
        
        $this->db->select('
            pkg.`package_id`,
            pkg.`package_name`,
            dt.`duration_type`,
            pkg.`duration`,
            CONCAT("'.CURRENCY.' ", pkg.`discounted_amount`) AS discounted_amount,
            CONCAT("'.CURRENCY.' ", pkg.`amount`) AS amount,            
        ');
        $this->db->from('package_masters pkg');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->where(array('pkg.test_module_id'=> $test_module_id,'pkg.programe_id'=> $programe_id,'pkg.center_id'=> $center_id, 'pkg.active'=>1,'pkg.is_offline'=>1));  
        $this->db->order_by('pkg.discounted_amount', 'DESC');
        return $this->db->get()->result_array();
    }

    function getPackageDetails($package_id)
    {        
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            GROUP_CONCAT(DISTINCT cat.`category_name`  SEPARATOR ", ") as category_name,
            GROUP_CONCAT(DISTINCT cat.`category_id`) as category_id,
            tm.`test_module_id`,
            pgm.`programe_id`,
            cl.`center_id`,
            `dur_type`.`duration_type`,
            GROUP_CONCAT(DISTINCT course_timing.course_timing  SEPARATOR ", ") as course_timing,
            `pkg`.`image`,
             `pkg`.`currency_code`,
        ');
        $this->db->from('`package_masters` pkg');
        $this->db->join('`programe_masters` pgm','pkg.`programe_id`=pgm.`programe_id`','left');
        $this->db->join('`test_module` tm','pkg.`test_module_id`=tm.`test_module_id`', 'left');
         $this->db->join('`package_category` pcat','pcat.`package_id`=pkg.`package_id`','left');
        $this->db->join('`category_masters` cat','cat.`category_id`=pcat.`category_id`','left');
        $this->db->join('`center_location` cl','cl.`center_id`=pkg.`center_id`','left');
        $this->db->join('`duration_type` dur_type','dur_type.`id`=pkg.`duration_type`','left');
        $this->db->join('`package_timing` pk_time','pk_time.`package_id`=pkg.`package_id`','left');
        $this->db->join('`course_timing`','course_timing.`id`=pk_time.`course_timing_id`','left');
        $this->db->where('pkg.package_id',$package_id);
        $this->db->group_by('pkg.package_id');
        $this->db->order_by('pkg.`amount` ASC');
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }    
      /*Get PP test mobule*/
    function Get_pp_TestModule(){

        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('practice_package_masters pkg');
        $this->db->where(array('pkg.active'=>1));
        $this->db->join('test_module tm', 'tm.test_module_id = pkg.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function startPackByStartDate($today){
        return $this->db->query('UPDATE `student_package` SET `active` = 1, `packCloseReason` = NULL WHERE `subscribed_on_str` = '.$today.' AND `is_terminated` =0 AND `onHold` =0 AND `packCloseReason`!="Course switched"');
    }

    function getAllOrderDate($id)
    {
        $this->db->select('SUBSTRING(requested_on, 1,10) AS requested_on');
        $this->db->from('`student_package` spkg');
        $this->db->join('`package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`');        
        $this->db->where(array('spkg.student_id'=>$id));
        $this->db->group_start();
        $this->db->or_where(array('spkg.pack_type'=>'offline'));
        $this->db->or_where(array('spkg.pack_type'=>'online'));
        $this->db->group_end();
        $this->db->order_by('spkg.`requested_on` DESC');
        $this->db->group_by('spkg.requested_on');
        // $this->db->limit(5);
        return  $this->db->get('')->result_array();
    }
    function getAllOrderDate_pp($id){

        $this->db->select('SUBSTRING(requested_on, 1,10) AS requested_on');
        $this->db->from('`student_package` spkg');
        $this->db->join('`practice_package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`');        
        $this->db->where(array('spkg.student_id'=>$id,'spkg.pack_type'=>'practice'));                     
        $this->db->order_by('spkg.`requested_on` DESC');
        $this->db->group_by('spkg.requested_on');
        //$this->db->limit(5);
        return $this->db->get('')->result_array();
    }
    function get_all_package_payment($params = array())
    {
        $this->db->select('`history.id`, `history.student_id`, `history.student_package_id`, `history.checkout_token_no`, `history.page`, `history.active`, `history.created`, `history.modified`, std.fname,std.lname,spkg.payment_id,spkg.order_id,spkg.status,spkg.captured,spkg.payment_full_response,std.UID,std.mobile,std.email,state.state_name,city.city_name, pgm.`programe_name,batch_master.batch_name,spkg.subscribed_on,spkg.expired_on,tm.`test_module_name`,spkg.package_name,spkg.package_duration,spkg.pack_type,CONCAT(FORMAT(spkg.`amount`/100,2)) AS amount_paid,spkg.`currency`,country.name as country_name,std.country_code');
        $this->db->from('`checkout_page_history` history');       
        $this->db->join('`students` std', 'std.`id`= history.`student_id`');
        $this->db->join('`state`', 'state.`state_id`= std.`state_id`', 'left');
        $this->db->join('`city`', 'city.city_id= std.`city_id`', 'left');
        $this->db->join('`country`', 'country.country_id= std.`country_id`', 'left');
        $this->db->join('`student_package` spkg', 'spkg.`checkout_token_no`= history.`checkout_token_no`', 'INNER');
        $this->db->join('`test_module` tm','spkg.`test_module_id`=tm.`test_module_id`'); 
        $this->db->join('`programe_masters` pgm','pgm.`programe_id`=spkg.`programe_id`');  
        $this->db->join('batch_master', 'batch_master.batch_id = spkg.batch_id','left');
        $this->db->group_by('spkg.student_package_id');
        $this->db->order_by('history.created','DESC');
        if(!empty($params['payment_status']))
        {
        $this->db->where('spkg.status =', $params['payment_status']); 
        }
        if(!empty($params['payment_date']))
        {
            $this->db->like('history.created', $params['payment_date']);      
        }
       // $this->db->where('spkg.status =', 'succeeded'); 
        return $this->db->get('')->result_array();
        
    }
    function get_all_package_payment_count($params = array())
    {
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
           // $lim="limit ".$params['offset'].','.$params['limit'];
        } 
        $this->db->select('`history.id`, `history.student_id`, `history.student_package_id`, `history.checkout_token_no`, `history.page`, `history.active`, `history.created`, `history.modified`, std.fname,std.lname,spkg.payment_id,spkg.order_id,spkg.status,spkg.captured,spkg.payment_full_response,std.UID,std.mobile,std.email, spkg.subscribed_on,spkg.expired_on,spkg.package_name,spkg.package_duration,spkg.pack_type,CONCAT(FORMAT(spkg.`amount`/100,2)) AS amount_paid,spkg.`currency`,std.country_code');
        $this->db->from('`checkout_page_history` history');       
        $this->db->join('`students` std', 'std.`id`= history.`student_id`');              
        $this->db->join('`student_package` spkg', 'spkg.`checkout_token_no`= history.`checkout_token_no`', 'INNER');    
        $this->db->group_by('spkg.student_package_id');
        $this->db->order_by('history.created','DESC');
        if(!empty($params['payment_status']))
        {
        $this->db->where('spkg.status =', $params['payment_status']); 
        }       
        return $this->db->get('')->num_rows();
        
    }
    function get_success_package_payment()
    {
        $this->db->select('`history.id`, `history.student_id`, `history.student_package_id`, `history.checkout_token_no`, `history.page`, `history.active`, `history.created`, `history.modified`, std.fname,std.lname,spkg.payment_id,spkg.order_id,spkg.status,spkg.captured,spkg.payment_full_response,std.UID,std.mobile,std.email,state.state_name,city.city_name, pgm.`programe_name,batch_master.batch_name,spkg.subscribed_on,spkg.expired_on,tm.`test_module_name`,spkg.package_name,spkg.package_duration,spkg.pack_type,CONCAT(FORMAT(spkg.`amount`/100,2)) AS amount_paid,spkg.`currency`,country.name as country_name');
        $this->db->from('`checkout_page_history` history');       
        $this->db->join('`students` std', 'std.`id`= history.`student_id`');
        $this->db->join('`state`', 'state.`state_id`= std.`state_id`','left');
        $this->db->join('`city`', 'city.city_id= std.`city_id`', 'left');
        $this->db->join('`country`', 'country.country_id= std.`country_id`', 'left');
        $this->db->join('`student_package` spkg', 'spkg.`checkout_token_no`= history.`checkout_token_no`');
        $this->db->join('`test_module` tm','spkg.`test_module_id`=tm.`test_module_id`'); 
        $this->db->join('`programe_masters` pgm','pgm.`programe_id`=spkg.`programe_id`');  
        $this->db->join('batch_master', 'batch_master.batch_id = spkg.batch_id','left');
        $this->db->group_by('spkg.student_package_id');
        $this->db->order_by('history.created','DESC');
        $this->db->where('spkg.status =', 'succeeded'); 
        return $this->db->get('')->result_array();
    }

    function get_package_payment_status()
    {
        $this->db->select('spkg.status');
        $this->db->from('`checkout_page_history` history'); 
        $this->db->join('`student_package` spkg', 'spkg.`checkout_token_no`= history.`checkout_token_no`', 'INNER');
        $this->db->group_by('spkg.status');
        $this->db->order_by('spkg.status','ASC');
        return $this->db->get('')->result_array();        
    }
    function Get_onlineCourse_type($test_module_id,$programe_id,$category_id){
        $this->db->distinct('');
        $this->db->select('cat_time.course_timing,cat_time.id');
        $this->db->from('package_masters pkg');
        $this->db->join('`package_timing` type', 'type.`package_id`= pkg.`package_id`');
        $this->db->join('`course_timing` cat_time', 'cat_time.`id`= type.`course_timing_id`');       
        if($test_module_id){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id));
        }
        if($programe_id){
            $this->db->where(array('pkg.programe_id'=>$programe_id));
        }   
        if($category_id){
        $this->db->join('`package_category` pkg_cat', 'pkg_cat.`package_id`= pkg.`package_id`');
        $this->db->where(array('pkg_cat.category_id'=>$category_id));   
        }
        $this->db->order_by('cat_time.course_timing', 'ASC');
        return $this->db->get()->result_array(); 
             
    }

    function get_failed_fourmodule_data()
    {
        $this->db->select('std.fname,std.lname,std.email,std.mobile,std.UID,std.country_code,sp.fourmodule_api_called,sp.fourmodule_status,sp.fourmodule_response,sp.package_name,sp.package_duration,sp.subscribed_on,sp.expired_on,sp.student_package_id,tm.`test_module_name`,pgm.`programe_name,batch_master.batch_name,sp.fourmodule_json');
        $this->db->from('`student_package` sp');  
        $this->db->join('`students` std', 'std.`id`= sp.`student_id`'); 
        $this->db->join('`test_module` tm','sp.`test_module_id`=tm.`test_module_id`'); 
        $this->db->join('`programe_masters` pgm','pgm.`programe_id`=sp.`programe_id`');  
        $this->db->join('batch_master', 'batch_master.batch_id = sp.batch_id','left');   
        $this->db->order_by('sp.requested_on','DESC');
      //  $this->db->where('sp.fourmodule_api_called !=', '0'); 
        $this->db->where(array('sp.fourmodule_api_called !='=>0,'fourmodule_status='=>0));
        return $this->db->get('')->result_array();
    }
    function get_success_fourmodule_data()
    {
        $this->db->select('std.fname,std.lname,std.email,std.mobile,std.UID,std.country_code,sp.fourmodule_api_called,sp.fourmodule_status,sp.fourmodule_response,sp.package_name,sp.package_duration,sp.subscribed_on,sp.expired_on,sp.student_package_id,tm.`test_module_name`,pgm.`programe_name,batch_master.batch_name,sp.fourmodule_json');
        $this->db->from('`student_package` sp');  
        $this->db->join('`students` std', 'std.`id`= sp.`student_id`'); 
        $this->db->join('`test_module` tm','sp.`test_module_id`=tm.`test_module_id`'); 
        $this->db->join('`programe_masters` pgm','pgm.`programe_id`=sp.`programe_id`');  
        $this->db->join('batch_master', 'batch_master.batch_id = sp.batch_id','left');   
        $this->db->order_by('sp.requested_on','DESC');
      //  $this->db->where('sp.fourmodule_api_called !=', '0'); 
        $this->db->where(array('sp.fourmodule_api_called !='=>0,'fourmodule_status='=>1));
        return $this->db->get('')->result_array();
    }

    function get_pack_id($student_package_id)
    {
        $this->db->select('package_id,subscribed_on,pack_type');
        $this->db->from('`student_package`'); 
        $this->db->where(array('student_package_id'=>$student_package_id));
        return $this->db->get('')->row_array();  
    }
}
