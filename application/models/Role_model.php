<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class Role_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function clean_assigned_role()
    {
        if(ENVIRONMENT=='development' or ENVIRONMENT=='testing'){
            $this->db->truncate('controller_list');
            $this->db->truncate('method_list');
            $this->db->truncate('role_access');
            return 1;
        }else{
            return 0;
        }        
    } 

    function getAllmethod($cid){

        $this->db->select('m.method_name');
        $this->db->from('method_list m');
        $this->db->join('role_access ra', 'ra.method_id= m.id'); 
        //$this->db->where(array('role_id'=>$_SESSION['roleId'],'ra.controller_id'=>$cid));
		$this->db->where(array('role_id'=>$_SESSION['roleId']));		
        return $this->db->get('')->result_array();
    }   

    function getsearchMethodCount($controller_id){

        $query = '';
        if($controller_id!=''){
            $query .= " `controller_id` = ".$controller_id." and ";
        }
        $x = $this->db->query('
                select 
                id
            from `method_list`
            where '.$query.' `id` > 0
            ');
        return $x->result_array();
    }

    function searchMethod($controller_id){

        $query = '';
        if($controller_id!=''){
            $query .= " m.`controller_id` = ".$controller_id." and ";
        }
        $x = $this->db->query('
                select 
                m.*,c.controller_name
            from `method_list` m
            left join controller_list c on m.controller_id= c.id
            where '.$query.' m.`id` > 0
            ');
        return $x->result_array();
        //print_r($this->db->last_query());exit;

    }

    function get_role($id)
    {
        return $this->db->get_where('roles',array('id'=>$id))->row_array();
    }    
    
    function get_method_desc($method_id){

        $this->db->select('method_alias,method_desc');
        $this->db->from('method_list');
        $this->db->where(array('id'=>$method_id));
        return $this->db->get('')->row_array();
    }

    function get_module_desc($controller_id){

        $this->db->select('controller_alias,controller_desc');
        $this->db->from('controller_list');
        $this->db->where(array('id'=>$controller_id));
        return $this->db->get('')->row_array();
    }

    function getRoleName($id){
        $this->db->select('name');
        $this->db->from('roles');
        $this->db->where(array('id'=>$id));
        return $this->db->get('')->row_array();
    }

    function get_controller($id)
    {
        return $this->db->get_where('controller_list',array('id'=>$id))->row_array();
    }

    function get_method($id)
    {
        return $this->db->get_where('method_list',array('id'=>$id))->row_array();
    }

    function get_role_data($id)
    {        
        $this->db->select('name');
        $this->db->from('roles');
        $this->db->where(array('id'=>$id));
        return $this->db->get('')->result_array();
    }

    function get_all_roles_count()
    {
        $this->db->from('roles');
        return $this->db->count_all_results();
    }

    function get_all_controller_count(){

        $this->db->from('controller_list');
        return $this->db->count_all_results();
    }

    function get_all_method_count(){

        $this->db->from('method_list');
        return $this->db->count_all_results();
    }

    function get_all_roles($params = array())
    {
        $this->db->order_by('name', 'ASC');
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get('roles')->result_array();
    }

    function get_all_controller($params = array()){
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get('controller_list')->result_array();
    }

    function get_all_methods($controller_id){
        
        //return $this->db->get_where('method_list',array('controller_id'=>$controller_id))->result_array();
        $this->db->select('
            id,
            controller_id,
            method_name,
            method_alias,
            method_desc
        ');
        $this->db->from('method_list');
        $this->db->where(array('controller_id'=>$controller_id));
        $this->db->order_by('method_alias ASC');
        return $this->db->get('')->result_array();
    }

    function get_all_method_list($params){
        
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('c.controller_name,c.id,m.id,m.controller_id,m.active,m.method_name,m.method_desc,m.method_alias');
        $this->db->from('method_list m');
        $this->db->join('controller_list c', 'c.id= m.controller_id');        
        $this->db->order_by('c.controller_name ASC');
        return $this->db->get('')->result_array();

    }

    function getMenuController($role_id,$role_name){       
        
        $this->db->distinct('ra.controller_id');
        $this->db->select('
            ra.controller_id,
            c.id,
            c.controller_name,
            c.controller_alias,
            c.menuIcon
        ');
        $this->db->from('role_access ra');
        $this->db->join('controller_list c', 'ra.controller_id= c.id','left');
        $this->db->where(array('ra.role_id'=>$role_id));
        //$this->db->order_by('c.menuPriority ASC');
        return $this->db->get('')->result_array();
    }

    function getMenuMethod($role_id,$cid){
        
        $this->db->select('
            ra.id,
            ra.method_id,            
            m.id,
            m.method_name,
            m.method_alias,
            m.menuIcon
        ');
        $this->db->from('role_access ra'); 
        $this->db->join('method_list m', 'ra.method_id= m.id');
        $this->db->where(array('ra.role_id'=>$role_id,'ra.controller_id'=>$cid));
        return $this->db->get('')->result_array();
    }

    function truncate_cm(){
        $this->db->query('truncate controller_list');
        $this->db->query('truncate method_list');
    }

    function get_all_roles_active()
    {   
        return $this->db->get_where('roles',array('active'=>1))->result_array();        
    }

    function get_all_roles_active_not_super_admin()
    {   
        return $this->db->get_where('roles',array('active'=>1,'name!='=>'Super Admin'))->result_array();        
    }        
    
    function add_role($params)
    {
        $this->db->from('roles');
        $this->db->where(array('name'=>$params['name']));
        $count = $this->db->count_all_results();        
        if($count>0){
            return 'duplicate';
        }else{
            $this->db->insert('roles',$params);
            return $this->db->insert_id();
        }
    }
    
    function add_access($params)
    {
        $this->db->insert('role_access',$params);
        return $this->db->insert_id();
    }

    function update_access($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('role_access',$params);
        //print_r($this->db->last_query());exit;
    }

    function update_method_desc($id,$params){

        $this->db->where('id',$id);
        return $this->db->update('method_list',$params);
    }

    function update_module_desc($id,$params){

        $this->db->where('id',$id);
        return $this->db->update('controller_list',$params);
    }

    function add_controller($params)
    {
        $this->db->insert('controller_list',$params);
        return $this->db->insert_id();
    }

    function add_method($params)
    {
        $this->db->insert('method_list',$params);
        return $this->db->insert_id();
    }

    function update_role($id,$params)
    {
        $this->db->from('roles');
        $this->db->where(array('name'=>  $params['name'], 'id!='=>$id));
        $count = $this->db->count_all_results();       
        if($count>0){
            return 'duplicate';
        }else{
            $this->db->where('id',$id);
            $this->db->update('roles',$params);
            return 'updated';
        }
    }

    function update_controller($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('controller_list',$params);
    }

    /*function resetMenuPriority($params)
    {
        return $this->db->update('controller_list',$params);
    }*/    
    
    function delete_role($id)
    {        
        $this->db->delete('role_access',array('role_id'=>$id));
        $this->db->delete('user_role',array('role_id'=>$id));
        return $this->db->delete('roles',array('id'=>$id));
    }
    
    function delete_controller($id)
    {
        $this->db->delete('method_list',array('controller_id'=>$id));
        return $this->db->delete('controller_list',array('id'=>$id));
    }

    function delete_method($id)
    {
        return $this->db->delete('method_list',array('id'=>$id));
    }

    function delete_role_access($id)
    {
        return $this->db->delete('role_access',array('role_id'=>$id));
    }    

    function check_controller($controller_name){

        $this->db->select('id');
        $this->db->from('controller_list');
        $this->db->where(array('controller_name'=>$controller_name));
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function check_method($method_name,$controller_id){

        $this->db->select('id');
        $this->db->from('method_list');
        $this->db->where(array('method_name'=>$method_name,'controller_id'=>$controller_id));
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function check_duplicate_access($role_id,$controller_id,$method_id){

        $this->db->select('id');
        $this->db->from('role_access');
        $this->db->where(array('role_id'=>$role_id,'controller_id'=>$controller_id,'method_id'=>$method_id));
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function check_role_acess($role_id,$controller_id,$method_id){

        $this->db->from('role_access');
        $this->db->where(array('role_id'=>$role_id, 'controller_id'=> $controller_id,'method_id'=>$method_id));
        return $this->db->count_all_results(); 
        //print_r($this->db->last_query());exit;
    }
	function _has_access_($cn=null,$mn=null){
		
	    if(empty($cn) || empty($mn)){
			
			$cn = $this->router->fetch_class().''.'.php';
			$mn = $this->router->fetch_method();
		}
		if(empty(strstr($cn,".php"))){
			$cn =$cn.'.php';
		}
        $method_id =null;
        $controller_id = null;
		if(!empty($cn) && !empty($mn)){
            
			$role_id=$_SESSION['roleId'];
			$role_name=$_SESSION['roleName'];
			if($role_name != ADMIN){
				$controller_data = $this->Role_model->check_controller($cn);
				foreach ($controller_data as $c) {
					$controller_id=$c['id'];
				}
				$method_data = $this->Role_model->check_method($mn,$controller_id);
				foreach ($method_data as $m) {
					$method_id=$m['id'];
				}
				$num = $this->Role_model->check_role_acess($role_id,$controller_id,$method_id);
					if($num<=0){
						return false;
					}else{
						return true;
					}
			}else{
				return true;
			}
		}else{
			return false;
		}        
    }
}
