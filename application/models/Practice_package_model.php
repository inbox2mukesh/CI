<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Practice_package_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_prev_category($package_id){

        $this->db->select('category_id');
        $this->db->from('practice_package_category');
        $this->db->where(array('package_id'=>$package_id));
        return $this->db->get()->result_array();
    }

    function add_package_category($params){
        
        $this->db->insert('practice_package_category',$params);
        return $this->db->insert_id();
    }

    function getPackCategory($package_id){

        $this->db->select('cat.category_name');
        $this->db->from('practice_package_category pc');
        $this->db->join('category_masters cat', 'cat.category_id = pc.category_id');
        $this->db->where(array('pc.package_id'=>$package_id));
        return $this->db->get()->result_array();
    }

    function check_package_duplicacy($params,$package_id){        

        $this->db->from('practice_package_masters pkg');
        $this->db->where(array(
                'pkg.center_id'=>$params['center_id'],
                'pkg.package_name'=>$params['package_name'],
                'pkg.discounted_amount'=>$params['discounted_amount'],
                'pkg.duration_type'=>$params['duration_type'],
                'pkg.duration'=>$params['duration'],
                'pkg.test_module_id'=>$params['test_module_id'],
                'pkg.programe_id'=>$params['programe_id'],
                'pkg.mock_test_count'=>$params['mock_test_count'],
                'pkg.reading_test_count'=>$params['reading_test_count'],
                'pkg.listening_test_count'=>$params['listening_test_count'],
                'pkg.writing_test_count'=>$params['writing_test_count'],
                'pkg.speaking_test_count'=>$params['speaking_test_count'],
                'pkg.country_id'=>$params['country_id'],
                'pkg.package_id!='=>$package_id,
            )
        );
        return $this->db->count_all_results();
    }

    function delete_package_category($package_id){
        $this->db->delete('practice_package_category',array('package_id'=>$package_id)); 
    }

    function getPackInfo_forPromocode($package_id)
    {
        $this->db->select('test_module_id,discounted_amount,active');
        $this->db->from('practice_package_masters');
        $this->db->where(array('package_id'=>$package_id));
        return $this->db->get()->row_array();
    }

    function getpp_PackActiveCount($id){

        $this->db->from('student_package');
        $this->db->where(array('student_id'=>$id,'pack_type'=>'practice','active'=>1));
        return $this->db->count_all_results();
    }

    function getpp_PackTakenCount($id){

        $this->db->from('student_package');
        $this->db->where(array('student_id'=>$id,'pack_type'=>'practice'));
        return $this->db->count_all_results();
    }
    
    
    function get_package($package_id)
    {
        //return $this->db->get_where('practice_package_masters',array('package_id'=>$package_id))->row_array();
        $this->db->select('
            pkg.*,
            dt.duration_type as duration_type_name
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->where(array('pkg.package_id'=>$package_id));
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }

    function getPackPrice($package_id){

        $this->db->select('discounted_amount');
        $this->db->from('practice_package_masters'); 
        $this->db->where('package_id',$package_id);        
        return $this->db->get()->row_array();
    }

    function get_all_testModule(){

        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('practice_package_masters ppm');
        $this->db->join('test_module tm', 'tm.test_module_id = ppm.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_all_packages_count($test_module_id)
    {
        $this->db->from('practice_package_masters');
        if($test_module_id>0){
           $this->db->where('test_module_id',$test_module_id); 
        }else{}
        return $this->db->count_all_results();
    }

    function search_practice_package_masters($test_module_id,$params = array(),$totalRowsCount=false)
    {
        if(isset($params["limit"]) && isset($params["offset"]) && !$totalRowsCount)
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`discounted_amount`,
            pkg.`amount`,
            pkg.`duration`,
            pkg.`active`,
            pkg.`publish`,
            pkg.`image`,
            pkg.`currency_code`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            dt.duration_type as duration_type_name,
            cnt.name as country_name,
            cl.center_name
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= pkg.`center_id`');
        $this->db->join('`practice_package_category` pc', 'pc.`package_id`= pkg.`package_id`');
        $this->db->join('`category_masters` cm', 'cm.`category_id`= pc.`category_id`');
        $this->db->join('`country` cnt', 'cnt.`country_id`= pkg.`country_id`');

        if(isset($params["search"]) && !empty($params["search"]) && $params["search"] != strtolower(PREFIX_PRACTICE_PACK_ID)) {
            $this->db->where("(LOWER(pkg.package_name) LIKE '%$params[search]%' || LOWER(tm.test_module_name) LIKE '%$params[search]%' || LOWER(pgm.programe_name) LIKE '%$params[search]%' || LOWER(cm.category_name) LIKE '%$params[search]%' || LOWER(dt.duration_type) LIKE '%$params[search]%' || LOWER(cnt.name) LIKE '%$params[search]%')");
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
        if(isset($params["duration"]) && !empty($params["duration"])) {
            $this->db->where(array('pkg.duration'=>$params["duration"]));
        }
        if(isset($params["duration_type"]) && !empty($params["duration_type"])) {
            $this->db->where(array('pkg.duration_type'=>$params["duration_type"]));
        }
        if(isset($params["status"]) && $params['status'] !== "") {
            $this->db->where(array('pkg.active' => $params["status"]));
        }

        if($test_module_id>0){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id));
        }

        $this->db->group_by('pkg.package_id');
      //  $this->db->order_by('tm.`test_module_name` ASC');

        $this->db->order_by('pkg.`modified` DESC');
        
        if($totalRowsCount == true) {
            return $this->db->count_all_results();
        }
        else {
            return $this->db->get('')->result_array();
        }
    }

    function get_all_packages($test_module_id,$params = array(),$totalRowsCount = false)
    {   

        if(isset($params["limit"]) && isset($params["offset"]) && !$totalRowsCount) {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`discounted_amount`,
            pkg.`amount`,
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
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`center_location` cl', 'cl.`center_id`= pkg.`center_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`'); 
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->join('`country` cnt', 'cnt.`country_id`= pkg.`country_id`');

        if($test_module_id>0){
            $this->db->where('pkg.test_module_id',$test_module_id);
        }else{
            
        }       
       // $this->db->order_by('pkg.`amount` ASC');
        $this->db->order_by('pkg.`modified` DESC');

        if($totalRowsCount == true) {
            return $this->db->count_all_results();
        }
        else {
            return $this->db->get('')->result_array();
        }
        //print_r($this->db->last_query());exit;
    }  
    
    function update_practice_package_master_active_inactive_publish_unpublish_on_web($packageids=array(),$params=array()) {
        $this->db->where_in('package_id',$packageids);
        return $this->db->update('practice_package_masters',$params);
    }
    

    /*
     * Get all packages IELTS
     */
    function get_all_package_active($country_id=NULL,$test_module_id,$programe_id,$duration,$limit=null,$offset=null,$category_id)
    {       
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`duration`,
            pkg.`discounted_amount`,
            pkg.`mock_test_count`,
            pkg.`reading_test_count`,
            pkg.`listening_test_count`,
            pkg.`writing_test_count`,
            pkg.`speaking_test_count`,
            pkg.`discounted_amount`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            tm.`test_module_id`,
            pgm.`programe_id`,
            cl.`center_id`,
            GROUP_CONCAT(DISTINCT cat.`category_name` SEPARATOR ", ") as category_name,
            `dur_type`.`duration_type`,
            `pkg`.`currency_code`,
            `pkg`.`image`,
             cl.`center_name`,
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl','cl.`center_id`=pkg.`center_id`','left');
        $this->db->join('`practice_package_category` pcat','pcat.`package_id`=pkg.`package_id`','left');
        $this->db->join('`category_masters` cat','cat.`category_id`=pcat.`category_id`','left');
         $this->db->join('`duration_type` dur_type','dur_type.`id`=pkg.`duration_type`','left');
         if($test_module_id){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id));
        }else{ }
        if($programe_id){
            $this->db->where(array('pkg.programe_id'=>$programe_id));
        }else{ }
        
        if($duration){
            $this->db->where(array('pkg.duration'=>$duration));
        }else{ }
        if($category_id){
            $this->db->join('`practice_package_category` pcat_temp','pcat_temp.`package_id`=pkg.`package_id`');
            $this->db->where(array('pcat_temp.category_id'=>$category_id));
        }else{ }
        $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'pkg.country_id'=>$country_id));
        $this->db->group_by('pkg.package_id');
        $this->db->order_by('pkg.`package_id` DESC');
         return  $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function get_all_package_active_count($country_id=NULL,$test_module_id,$programe_id,$duration,$limit=null,$offset=null,$category_id)
    {       
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->select('pkg.`package_id`');
        $this->db->from('`practice_package_masters` pkg');
      
        if($test_module_id){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id));
        }else{ }
        if($programe_id){
            $this->db->where(array('pkg.programe_id'=>$programe_id));
        }else{ }
        
        if($duration){
            $this->db->where(array('pkg.duration'=>$duration));
        }else{ }
        $this->db->join('`package_category` pcat','pcat.`package_id`=pkg.`package_id`','left');
        $this->db->join('`category_masters` cat','cat.`category_id`=pcat.`category_id`','left');
        $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'pkg.country_id'=>$country_id));
        $this->db->group_by('pkg.package_id');
        $this->db->order_by('pkg.`package_id` DESC');
        if($category_id){
            $this->db->where(array('pcat.category_id'=>$category_id));
        }else{ }
        return $this->db->get('')->num_rows();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all packages IELTS
     */
    function get_all_ielts_package_active()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`duration`,
            pkg.`discounted_amount`,
            pgm.`programe_name`,
            tm.`test_module_name`,
        ');
        $this->db->from('`practice_package_masters` pkg');
       $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->where(array('pkg.test_module_id'=>IELTS_ID, 'pkg.active'=>1));
        $this->db->order_by('pkg.`amount` ASC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

     /*
     * Get all packages PTE
     */
    function get_all_pte_package_active()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`duration`,
            pkg.`discounted_amount`,
            pgm.`programe_name`,
            tm.`test_module_name`
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->where(array('pkg.test_module_id'=>PTE_ID, 'pkg.active'=>1));
        $this->db->order_by('pkg.`amount` ASC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function add_package($params)
    {
        $this->db->insert('practice_package_masters',$params);
        return $this->db->insert_id();
    }

    function update_package($package_id,$params)
    {
        $this->db->where('package_id',$package_id);
        return $this->db->update('practice_package_masters',$params);
    }

    function delete_package($package_id)
    {
        return $this->db->delete('practice_package_masters',array('package_id'=>$package_id));
    }

    function get_all_pp_active()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`duration`,
            pkg.`discounted_amount`,
            pkg.`mock_test_count`,
            pkg.`reading_test_count`,
            pkg.`listening_test_count`,
            pkg.`writing_test_count`,
            pkg.`speaking_test_count`,
            pgm.`programe_name`,
            tm.`test_module_name`,
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->where(array('pkg.active'=>1));
        $this->db->order_by('pkg.`created` DESC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all package_masters IELTS
     */
    function get_all_cd_ielts_pp_active()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pkg.`mock_test_count`,
            pkg.`reading_test_count`,
            pkg.`listening_test_count`,
            pkg.`writing_test_count`,
            pkg.`speaking_test_count`,
            pgm.`programe_name`,
            tm.`test_module_name`,
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->where(array('pkg.test_module_id'=>IELTS_CD_ID, 'pkg.active'=>1));
        $this->db->order_by('pkg.`created` DESC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all package_masters IELTS
     */
    function get_all_cd_ielts_pp_active_long()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pkg.`mock_test_count`,
            pkg.`reading_test_count`,
            pkg.`listening_test_count`,
            pkg.`writing_test_count`,
            pkg.`speaking_test_count`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            tm.`test_module_id`,
            pgm.`programe_id`,
            cl.`center_id`,
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl','cl.`center_id`=pkg.`center_id`','left');
        $this->db->where(array('pkg.test_module_id'=>IELTS_CD_ID, 'pkg.active'=>1));
        $this->db->order_by('pkg.`created` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

     /*
     * Get all package_masters IELTS
     */
    function get_all_ielts_pp_active()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`mock_test_count`,
            pkg.`duration`,
            pkg.`reading_test_count`,
            pkg.`listening_test_count`,
            pkg.`writing_test_count`,
            pkg.`speaking_test_count`,
            pgm.`programe_name`,
            tm.`test_module_name`,
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->where(array('pkg.test_module_id'=>IELTS_ID, 'pkg.active'=>1));
        $this->db->order_by('pkg.`created` DESC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all package_masters IELTS
     */
    function get_all_ielts_pp_active_long()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pkg.`mock_test_count`,
            pkg.`reading_test_count`,
            pkg.`listening_test_count`,
            pkg.`writing_test_count`,
            pkg.`speaking_test_count`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            tm.`test_module_id`,
            pgm.`programe_id`,
            cl.`center_id`,
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl','cl.`center_id`=pkg.`center_id`','left');
        $this->db->where(array('pkg.test_module_id'=>IELTS_ID, 'pkg.active'=>1));
        $this->db->order_by('pkg.`created` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all package_masters IELTS
     */
    function get_all_pte_pp_active()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pkg.`mock_test_count`,
            pkg.`reading_test_count`,
            pkg.`listening_test_count`,
            pkg.`writing_test_count`,
            pkg.`speaking_test_count`,
            pgm.`programe_name`,
            tm.`test_module_name`,
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->where(array('pkg.test_module_id'=>PTE_ID, 'pkg.active'=>1));
        $this->db->order_by('pkg.`created` DESC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all package_masters IELTS
     */
    function get_all_pte_pp_active_long()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pkg.`mock_test_count`,
            pkg.`reading_test_count`,
            pkg.`listening_test_count`,
            pkg.`writing_test_count`,
            pkg.`speaking_test_count`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            tm.`test_module_id`,
            pgm.`programe_id`,
            cl.`center_id`,
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl','cl.`center_id`=pkg.`center_id`','left');
        $this->db->where(array('pkg.test_module_id'=>PTE_ID, 'pkg.active'=>1));
        $this->db->order_by('pkg.`created` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all package_masters IELTS
     */
    function get_all_se_pp_active()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pkg.`mock_test_count`,
            pkg.`reading_test_count`,
            pkg.`listening_test_count`,
            pkg.`writing_test_count`,
            pkg.`speaking_test_count`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            tm.`test_module_id`,
            pgm.`programe_id`,
            cl.`center_id`,
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl','cl.`center_id`=pkg.`center_id`','left');
        $this->db->where(array('pkg.test_module_id'=>SE_ID, 'pkg.active'=>1));
        $this->db->order_by('pkg.`created` DESC');
        $this->db->limit(4);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    /*
     * Get all package_masters IELTS
     */
    function get_all_se_pp_active_long()
    {       
        $this->db->select('
            pkg.`package_id`, 
            pkg.`package_name`,
            pkg.`package_desc`,
            pkg.`amount`,
            pkg.`discounted_amount`,
            pkg.`duration`,
            pkg.`mock_test_count`,
            pkg.`reading_test_count`,
            pkg.`listening_test_count`,
            pkg.`writing_test_count`,
            pkg.`speaking_test_count`,
            pgm.`programe_name`,
            tm.`test_module_name`,
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->where(array('pkg.test_module_id'=>SE_ID, 'pkg.active'=>1));
        $this->db->order_by('pkg.`created` DESC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function get_package_list($test_module_id,$programe_id){       
        
        $this->db->select('
            package_id,
            package_name,
            CONCAT("'.CURRENCY.' ", `amount`) AS amount,
            CONCAT("'.CURRENCY.' ", `discounted_amount`) AS discounted_amount,            
            dt.`duration_type`,
            `duration`,
        ');
        $this->db->from('practice_package_masters');
        $this->db->join('`duration_type` dt', 'dt.`id`= practice_package_masters.`duration_type`');
        $this->db->where(array('test_module_id'=> $test_module_id,'programe_id'=> $programe_id,'practice_package_masters.active'=>1));  
        $this->db->order_by('package_name', 'ASC');
        return $this->db->get()->result_array();
    }

    function get_student_pack_subscribed($id,$token){

        $this->db->select(' 
            pkg.package_id,
            pkg.package_name,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`amount`/100,2)) AS package_cost,  
            CONCAT("'.CURRENCY.' ", pkg.discounted_amount) AS discounted_amount,
            CONCAT(pkg.duration, " Days") as package_duration,
            spkg.`student_id`,
            spkg.`student_package_id`, 
            spkg.`order_id`,
            spkg.`payment_id`,
            spkg.`method`,
            spkg.`tran_id`,
            spkg.`payment_file`,
            spkg.`application_file`,
            spkg.`due_commitment_date`,
            spkg.`active` as package_status,
            spkg.`packCloseReason`,
            spkg.`is_terminated`,
            spkg.`package_duration`,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`waiver`/100,2)) AS waiver,
            spkg.waiver_by,
            CONCAT("'.CURRENCY.' ", FORMAT(spkg.`other_discount`/100,2)) AS other_discount,
            FORMAT(spkg.`amount_paid`/100,2) AS amount_paid,
            FORMAT(spkg.`ext_amount`/100,2) AS ext_amount,
            FORMAT(spkg.`amount_due`/100,2) AS amount_due,
            FORMAT(spkg.`irr_dues`/100,2) AS irr_dues,
            FORMAT(spkg.`amount_refund`/100,2) AS amount_refund,
            FORMAT(spkg.`amount_paid_by_wallet`/100,2) AS amount_paid_by_wallet,
            spkg.subscribed_on_str as `subscribed_on`,
            spkg.expired_on_str as `expired_on`,
            spkg.requested_on as `requested_on`,
            spkg.`expired_on` as expired_on2,
            spkg.`subscribed_on` as subscribed_on2,
            pgm.programe_name,
            pgm.programe_id,
            tm.test_module_name,
            tm.test_module_id,
            cl.center_name,
            cl.center_id,
            `holdDateFrom`,
            `holdDateTo`,
        ');
        $this->db->from('`student_package` spkg');
        $this->db->join('`practice_package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= spkg.`center_id`', 'left');
        if($token=='Bysid'){
            $this->db->where(array('spkg.student_id'=>$id,'pack_type'=>'practice','spkg.status'=>'succeeded'));
        }else{
            $this->db->where(array('spkg.student_package_id'=>$id,'pack_type'=>'practice','spkg.status'=>'succeeded'));
        }               
        $this->db->order_by('spkg.`student_package_id` DESC');
        return $this->db->get('')->result_array();
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
            pkg.`active`,
            pgm.`programe_name`,
            tm.`test_module_name`,
            cl.`center_name`,
            cl.`center_id`,
            `pkg`.`currency_code`,
            `dur_type`.`duration_type`,
            GROUP_CONCAT(DISTINCT cat.`category_name`  SEPARATOR ", ") as category_name,
            GROUP_CONCAT(DISTINCT cat.`category_id`) as category_id,
            tm.`test_module_id`,
            pgm.`programe_id`,
            spkg.`subscribed_on`,
            spkg.`expired_on`,
        ');
        $this->db->from('`practice_package_masters` pkg');
        $this->db->join('`test_module` tm', 'pkg.`test_module_id`=tm.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'pkg.`programe_id`= pgm.`programe_id`','left');
        $this->db->join('student_package spkg', 'spkg.package_id= pkg.package_id','left');
        $this->db->join('`practice_package_category` pcat','pcat.`package_id`=pkg.`package_id`','left');
        $this->db->join('`category_masters` cat','cat.`category_id`=pcat.`category_id`','left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= pkg.`center_id`', 'left');
        $this->db->join('`duration_type` dur_type','dur_type.`id`=pkg.`duration_type`','left');
        $this->db->where('pkg.package_id',$package_id);
        $this->db->group_by('pkg.package_id');
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }

    function Get_pp_TestModule($country_id=null){

        $this->db->distinct('');
        $this->db->select('tm.test_module_id,tm.test_module_name');
        $this->db->from('practice_package_masters pkg');
         $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'pkg.country_id'=>$country_id));
        $this->db->join('test_module tm', 'tm.test_module_id = pkg.test_module_id', 'left');
        $this->db->order_by('tm.test_module_name', 'ASC');
        return $this->db->get()->result_array();
    }

     function Get_pp_programe($country_id){

        $this->db->distinct('');
        $this->db->select('pgm.programe_id,pgm.programe_name');
        $this->db->from('practice_package_masters pkg');
        $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'pkg.country_id'=>$country_id));
        $this->db->join('programe_masters pgm', 'pgm.programe_id = pkg.programe_id', 'left');
        $this->db->order_by('pgm.programe_name', 'ASC');
        return $this->db->get()->result_array();
    }
    function Get_pp_duration($country_id,$test_module_id, $programe_id,$category_id){       

        $this->db->distinct('');
        $this->db->select('pkg.duration,dt.duration_type');
        $this->db->from('practice_package_masters pkg');
        $this->db->join('`duration_type` dt', 'dt.`id`= pkg.`duration_type`');
        $this->db->where(array('pkg.active'=>1,'pkg.publish'=>1,'pkg.country_id'=>$country_id));
        if($test_module_id){
            $this->db->where(array('pkg.test_module_id'=>$test_module_id));
        }
        if ($programe_id) {
            $this->db->where(array('pkg.programe_id' => $programe_id));
        }
        if($category_id)
        {
            $this->db->join('`practice_package_category` pkg_cat', 'pkg_cat.`package_id`= pkg.`package_id`');
            $this->db->where(array('pkg_cat.category_id' => $category_id));
        }
        $this->db->order_by('pkg.duration', 'ASC');
        return $this->db->get()->result_array();
    }

    function Get_onlineCourse_category($test_module_id,$programe_id,$duration){

        $this->db->distinct('');
        $this->db->select('cat.category_id,category_name');
        $this->db->from('practice_package_masters pkg');
        $this->db->join('`practice_package_category` pkg_cat', 'pkg_cat.`package_id`= pkg.`package_id`');
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
       // print_r($this->db->last_query());exit;
    }
    
}
