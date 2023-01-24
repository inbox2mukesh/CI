<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 class Student_attendance_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();        
    }

    function getAttendanceHistory($student_id,$pack_type,$classroom_id){
       // $pack_type='online';
        $this->db->select(' 
            att.id as attendance_id,
            att.morning,
            att.evening,
            att.date,
            att.time,
            att.created,
            att.by_user,
            u.id as uid,u.fname as ufname,u.lname as ulname,
            cr.classroom_name
        ');
        $this->db->from('student_attendance_main att');
        $this->db->join('`classroom` cr', 'cr.`id`= att.`classroom_id`');
        if($pack_type == "online"){
            $this->db->join('`user` u', 'u.`id`= att.`by_user`','left');
        }
        else { 
            $this->db->join('`user` u', 'u.`id`= att.`by_user`');
        }
         if($classroom_id){
            $this->db->where('att.classroom_id',$classroom_id);
        }else{ 

        } 
        $this->db->where(array('att.student_id'=>$student_id, 'att.type'=>$pack_type));
        $this->db->order_by('att.`strdate`', 'DESC');
        return  $this->db->get()->result_array();
       // print_r($this->db->last_query());exit;

    }

    function getAttendanceHistoryByMonth($student_id,$pack_type,$date,$classroom_id){

        // if($pack_type=='offline'){
        //     $pack_type='Inhouse';
        // }
        
       // $pack_type='online';
        $this->db->select(' 
            att.id as attendance_id,
            att.morning,
            att.evening,
            att.date,
            att.time,
            att.created,
            att.by_user,
            u.id as uid,u.fname as ufname,u.lname as ulname,
            cr.classroom_name
        ');
        $this->db->from('student_attendance_main att');
        $this->db->join('`classroom` cr', 'cr.`id`= att.`classroom_id`');
        if($pack_type == "online"){
            $this->db->join('`user` u', 'u.`id`= att.`by_user`','left');
        }
        else { 
            $this->db->join('`user` u', 'u.`id`= att.`by_user`');
        }
        if($classroom_id){
            $this->db->where('att.classroom_id',$classroom_id);
        }else{ 

        }        
        
       
        $this->db->where(array('att.student_id'=>$student_id, 'att.type'=>$pack_type));
        $this->db->like(array('att.date'=>$date));
        $this->db->order_by('att.`strdate`', 'DESC');
        return $this->db->get()->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getAttendanceHistoryByPresenseDay($student_id,$pack_type,$strDate,$classroom_id){

        
      //  $pack_type='online';
        $this->db->select(' 
            att.id as attendance_id,
            att.morning,
            att.evening,
            att.date,
            att.time,
            att.created,
            att.by_user,
            u.id as uid,u.fname as ufname,u.lname as ulname,
            cr.classroom_name
        ');
        $this->db->from('student_attendance_main att');
        if($classroom_id){
            $this->db->where('att.classroom_id',$classroom_id);
        }else{ 

        }        
        
        $this->db->join('`classroom` cr', 'cr.`id`= att.`classroom_id`');
        if($pack_type == "online"){
            $this->db->join('`user` u', 'u.`id`= att.`by_user`','left');
        }
        else { 
            $this->db->join('`user` u', 'u.`id`= att.`by_user`');
        }
       
        $this->db->where(array('att.student_id'=>$student_id, 'att.type'=>$pack_type,'att.strDate'=>$strDate));
        $this->db->order_by('att.`strdate`', 'DESC');
        return $this->db->get()->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getStudenId($attid){

        $this->db->select('student_id');
        $this->db->from('`student_attendance`');  
        $this->db->where(array('id'=>$attid));
        return $this->db->get('')->row_array();
    }

    function dupliacte_attendance($student_id,$type,$date){

        $this->db->where('student_id', $student_id);
        $this->db->where('type', $type);
        $this->db->where('date', $date);
        $query = $this->db->get('student_attendance');
        $count_row = $query->num_rows();
        if($count_row > 0){          
            return 'DUPLICATE';
        }else{          
            return 'NOT DUPLICATE';
        }
    }

    function add_attendance($params){

        $this->db->insert('student_attendance',$params);
        return $this->db->insert_id();
    }

    function add_attendance_in_main($params){

        $this->db->insert('student_attendance_main',$params);
        return $this->db->insert_id();
    }

    function update_attendance($id,$params)
    {                    
        $this->db->where('id',$id);
        return $this->db->update('student_attendance',$params);
    }

    function updateClassroom($student_id,$params){

        $this->db->where('student_id',$student_id);
        return $this->db->update('student_attendance',$params);
    }

    function backupAttendance($strDate){

        $a = $this->db->query("
            INSERT INTO `student_attendance_main` SELECT * FROM `student_attendance` WHERE `strDate`<='".$strDate."'; 
        ");
        $b = $this->db->query("
            DELETE FROM `student_attendance`
        ");
        $c = $a+$b;
        if($c){
            return 1;
        }else{
            return 0;
        }
    }

    function getAllMarkedStudents($attendanceCode){

        $this->db->select('student_id');
        $this->db->from('`student_attendance`');  
        $this->db->where(array('attendanceCode'=>$attendanceCode));
        return $this->db->get('')->result_array();
    }        

    function loadStudents($classroom_id){        
        
        $this->db->select('
            s.id,s.fname,s.lname,s.UID,
            spkg.student_package_id,
            cr.classroom_name,cr.id as classroom_id,
            cl.center_name,
            sat.id as attendance_id,
            sat.morning,
            sat.evening,
            sat.date,
            sat.time,
        ');
        $this->db->from('students s');
        $this->db->join('`student_package` spkg', 'spkg.`student_id`=s.`id`'); 
        $this->db->join('`classroom` cr', 'cr.`id`= spkg.`classroom_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= spkg.`center_id`'); 
        $this->db->join('`student_attendance` sat', 'sat.`student_id`= spkg.`student_id`','left');

        if($classroom_id){
            $this->db->where('spkg.classroom_id',$classroom_id);
        }else{ 

        }
        //$this->db->where(array('spkg.pack_type'=>'offline','spkg.active'=>1));
        $this->db->where(array('spkg.active'=>1));
        $this->db->group_by('s.id'); 
        return $this->db->get()->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getStudentByUID($UID,$byMonth2,$userBranch,$roleName){

        if($UID and !$byMonth2){

            $this->db->select('
                s.id,s.fname,s.lname,s.UID,
                spkg.student_package_id,spkg.pack_type,
                cr.classroom_name,cr.id as classroom_id,               
            ');
            $this->db->from('students s');
            $this->db->join('`student_package` spkg', 'spkg.`student_id`=s.`id`'); 
            $this->db->join('`classroom` cr', 'cr.`id`= spkg.`classroom_id`');
            /*$this->db->join('`center_location` cl', 'cl.`center_id`= spkg.`center_id`'); 
            $this->db->join('`test_module` tm', 'tm.`test_module_id`= spkg.`test_module_id`');
            $this->db->join('`programe_masters` pgm', 'pgm.`programe_id`= spkg.`programe_id`');
            $this->db->join('`batch_master` b', 'b.`batch_id`= spkg.`batch_id`');*/       
            if($roleName==ADMIN){
            }else{
                $this->db->where_in('spkg.center_id',$userBranch); 
            }        
            $this->db->where(array('s.UID'=>$UID,'spkg.pack_type'=>'online'));
            $this->db->group_by('s.id');

        }else if($UID and $byMonth2){

            $this->db->select('
                s.id,s.fname,s.lname,s.UID,
                spkg.student_package_id,spkg.pack_type,
                cr.classroom_name,cr.id as classroom_id,
                cl.center_name,
                tm.test_module_name,
                pgm.programe_name,
                b.batch_name,
                att.id as attid,att.date
            ');
            $this->db->from('students s');
            $this->db->join('`student_package` spkg', 'spkg.`student_id`=s.`id`'); 
            $this->db->join('`student_attendance_main` att', 'att.`student_id`= spkg.`student_id`');
            $this->db->join('`classroom` cr', 'cr.`id`= spkg.`classroom_id`');
            $this->db->join('`center_location` cl', 'cl.`center_id`= spkg.`center_id`'); 
            $this->db->join('`test_module` tm', 'tm.`test_module_id`= spkg.`test_module_id`');
            $this->db->join('`programe_masters` pgm', 'pgm.`programe_id`= spkg.`programe_id`');
            $this->db->join('`batch_master` b', 'b.`batch_id`= spkg.`batch_id`');
            if($roleName==ADMIN){
            }else{
                $this->db->where_in('spkg.center_id',$userBranch); 
            } 
            $this->db->where(array('s.UID'=>$UID,'spkg.pack_type'=>'online'));
            $this->db->like(array('att.date'=>$byMonth2));
            $this->db->group_by('s.id');

        }else{

        }
        
        return $this->db->get()->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getStudentByClassroom($classroom_id,$userBranch,$roleName){        
        
        $this->db->select('
            s.id,s.fname,s.lname,s.UID,
            spkg.student_package_id,spkg.pack_type,
            cr.classroom_name,cr.id as classroom_id,
            cl.center_name,
            tm.test_module_name,
            pgm.programe_name,
            b.batch_name
        ');
        $this->db->from('students s');
        $this->db->join('`student_package` spkg', 'spkg.`student_id`=s.`id`'); 
        $this->db->join('`classroom` cr', 'cr.`id`= spkg.`classroom_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= spkg.`center_id`'); 
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= spkg.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'pgm.`programe_id`= spkg.`programe_id`');
        $this->db->join('`batch_master` b', 'b.`batch_id`= spkg.`batch_id`');

        if($classroom_id){
            $this->db->where('spkg.classroom_id',$classroom_id);
        }else{ 

        }        
        
        $this->db->where('spkg.pack_type','online');
        $this->db->group_by('s.id'); 
        return $this->db->get()->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getStudentByMonth($classroom_id,$byMonth1,$userBranch,$roleName){

        $this->db->select('
        s.id,s.fname,s.lname,s.UID,
        spkg.student_package_id,spkg.pack_type,
        cr.classroom_name,cr.id as classroom_id,
        cl.center_name,
        tm.test_module_name,
        pgm.programe_name,
        b.batch_name,
        att.id as attid,att.date
    ');
    $this->db->from('students s');
    $this->db->join('`student_package` spkg', 'spkg.`student_id`=s.`id`'); 
    $this->db->join('`student_attendance_main` att', 'att.`student_id`= spkg.`student_id`');
    $this->db->join('`classroom` cr', 'cr.`id`= spkg.`classroom_id`');
    $this->db->join('`center_location` cl', 'cl.`center_id`= spkg.`center_id`'); 
    $this->db->join('`test_module` tm', 'tm.`test_module_id`= spkg.`test_module_id`');
    $this->db->join('`programe_masters` pgm', 'pgm.`programe_id`= spkg.`programe_id`');
    $this->db->join('`batch_master` b', 'b.`batch_id`= spkg.`batch_id`');
    
    /*if($classroom_id){
        $this->db->where('spkg.center_id',$center_id);
    }*/
    if($classroom_id){
        $this->db->where('spkg.classroom_id',$classroom_id);
    }
    $this->db->where(array('spkg.pack_type'=>'online'));
    $this->db->like(array('att.date'=>$byMonth1));
    $this->db->group_by('s.id');
    return $this->db->get()->result_array();
    //print_r($this->db->last_query());exit;
    }

    function getStudentByPresenseDay($classroom_id,$allPresent1,$userBranch,$roleName){
        $this->db->select('
            s.id,s.fname,s.lname,s.UID,
            spkg.student_package_id,spkg.pack_type,
            cr.classroom_name,cr.id as classroom_id,
            cl.center_name,
            tm.test_module_name,
            pgm.programe_name,
            b.batch_name,
            att.id as attid,att.strDate
        ');
        $this->db->from('students s');
        $this->db->join('`student_package` spkg', 'spkg.`student_id`=s.`id`'); 
        $this->db->join('`student_attendance_main` att', 'att.`student_id`= spkg.`student_id`');
        $this->db->join('`classroom` cr', 'cr.`id`= spkg.`classroom_id`');
        $this->db->join('`center_location` cl', 'cl.`center_id`= spkg.`center_id`'); 
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= spkg.`test_module_id`');
        $this->db->join('`programe_masters` pgm', 'pgm.`programe_id`= spkg.`programe_id`');
        $this->db->join('`batch_master` b', 'b.`batch_id`= spkg.`batch_id`');

        if($classroom_id){
            $this->db->where('spkg.classroom_id',$classroom_id);
        }else{ 

        }
        
        $this->db->where(array('spkg.pack_type'=>'online','att.strDate'=>$allPresent1));
        $this->db->group_start()
        ->where('att.morning',1)
        ->or_where('att.evening',1)
        ->group_end();        
        $this->db->group_by('s.id');
        return $this->db->get()->result_array();
        //print_r($this->db->last_query());exit;
    }    
    
}
