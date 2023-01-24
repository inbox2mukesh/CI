<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
 
class  Online_class_schedule_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_schedule($id){

        //return $this->db->get_where('online_class_schedules',array('id'=>$id))->row_array();
        $this->db->select('ocl.*');
        $this->db->from('online_class_schedules ocl');      
        $this->db->where('ocl.id',$id); 
        return $this->db->get()->row_array();
    }

    function get_all_schedule_count($rawArr,$classroom_id=0){

        $this->db->from('online_class_schedules'); 
        if($classroom_id>0){
          $this->db->where('classroom_id', $classroom_id);  
        }else{
          if(!empty($rawArr)){                   
                $this->db->where_in('classroom_id', $rawArr);
            }else{
                $rawArr=[];                   
                //$this->db->where_in('classroom_id', $rawArr);
            }  
        }   
        return $this->db->count_all_results();
        //print_r($this->db->last_query());exit;
    }

    
    function get_all_schedule($rawArr,$params=array(),$classroom_id=0){   

        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        $this->db->select('
            dc.`id`, 
            dc.`dateTime`,
            dc.`strdate`,
            dc.`dayname`,
            dc.`topic`,
            dc.`conf_URL`,                        
            dc.`active`,
            cr.classroom_name,
            dc.`class_duration`,                       
        ');
        $this->db->from('`online_class_schedules` dc');
        $this->db->join('`classroom` cr', 'cr.`id`=dc.`classroom_id`');     
        if($classroom_id>0){
          $this->db->where('dc.classroom_id', $classroom_id);  
        }else{
            if(!empty($rawArr)){                   
                $this->db->where_in('dc.classroom_id', $rawArr);
            }else{
                $rawArr=[];                   
                //$this->db->where_in('dc.classroom_id', $rawArr);
            }  
        }
        $this->db->order_by('dc.active', 'DESC');
        $this->db->order_by('dc.strdate', 'ASC');
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    function add_schedule($params){

        $this->db->insert('online_class_schedules',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update schedule
     */
    function update_schedule($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('online_class_schedules',$params);
    }

    function deactivate_shedule($todaystr){

        $params = array('active'=> 0);
        //$this->db->where('`strdate` <= ',$todaystr);
        $this->db->where('`strdate_end` <= ',$todaystr);
        return $this->db->update('online_class_schedules',$params);        
    }
    
    /*
     * function to delete schedule
     */
    function delete_schedule($id)
    {
        return $this->db->delete('online_class_schedules',array('id'=>$id));
    }

    

    function get_weekly_schedule($current_DateTimeStr,$classroom_id){ 

        $this->db->select('
            dc.`id`, 
            dc.`dateTime`,
            dc.`strdate`,
            dc.`dayname`,
            dc.`topic`,
            dc.`active`,
            dc.`class_duration`,
            dc.`conf_URL`,
           
        ');
        $this->db->from('`online_class_schedules` dc');      
        $this->db->where(array('dc.classroom_id'=>$classroom_id,'dc.active'=>1,'dc.`strdate` >= '=>$current_DateTimeStr));
        $this->db->order_by('dc.`strdate` ASC');
        $this->db->limit(3);
        return $this->db->get('')->result_array();
    }

    function get_weekly_schedule_all($current_DateTimeStr,$classroom_id,$limit=null,$offset=null,$search_text=null,$type,$filterclassdater)
    {
        
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->select('
            dc.`id`, 
            dc.`dateTime`,
            dc.`strdate`,
            dc.`dayname`,
            dc.`topic`,
            dc.`active`,
            dc.`class_duration`,
            dc.`conf_URL`,            
        ');
        $this->db->from('`online_class_schedules` dc'); 
        $this->db->where(array('dc.classroom_id'=>$classroom_id,'dc.active'=>1));

        
            if($filterclassdater)
            {
                $this->db->like('dc.dateTime', $filterclassdater);
            }
            
        
        else {
            $this->db->where('dc.`strdate` >=' ,$current_DateTimeStr);
        }

        if($search_text){
            $this->db->like('dc.topic', $search_text);
            }


        $this->db->order_by('dc.`strdate` ASC');        
         return $this->db->get('')->result_array();
     //print_r($this->db->last_query());exit;
    }

    function get_weekly_schedule_all_count($current_DateTimeStr,$classroom_id,$limit=null,$offset=null,$search_text=null,$type,$filterclassdater){
        if($limit !=null AND $offset !=null )
        {
            $this->db->limit($limit, $offset);
        }
        $this->db->select('dc.`id`');
        $this->db->from('`online_class_schedules` dc');            
        $this->db->where(array('dc.classroom_id'=>$classroom_id,'dc.active'=>1));
        if($filterclassdater)
        {
        $this->db->like('dc.dateTime', $filterclassdater);
        }    
        else {
        $this->db->where('dc.`strdate` >=' ,$current_DateTimeStr);
        }
        if($search_text){
            $this->db->like('dc.topic', $search_text);
            }
        $this->db->order_by('dc.`strdate` ASC');      
        return $this->db->get('')->num_rows();
        //print_r($this->db->last_query());exit;
    }
    function get_weekly_schedule_all_filter($current_DateTimeStr,$classroom_id,$search_text=null){

        $this->db->select('
            dc.`id`, 
            dc.`dateTime`,
            dc.`strdate`,
            dc.`dayname`,
            dc.`topic`,
            dc.`active`,
            dc.`class_duration`,
            dc.`conf_URL`,
          
        ');
        $this->db->from('`online_class_schedules` dc');      
       
        $this->db->where(array('dc.classroom_id'=>$classroom_id,'dc.active'=>1));
          if($search_text){
        $this->db->like('dc.topic', $search_text);
        }
         if($current_DateTimeStr){
        $this->db->like('dc.dateTime', $current_DateTimeStr);
        }
        $this->db->order_by('dc.`strdate` ASC');
        $this->db->limit(15);
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

   
    /*---- get classroom schcedule-----  */
    function getPackageSchedule($classroomid)
    {
        $currenttime=date('d-m-Y G:i:00');
        $currenttime=strtotime($currenttime);        
        $this->db->select('dateTime');
        $this->db->from('online_class_schedules');             
        $this->db->where(array('`strdate` >= '=>$currenttime,'active'=>1,'classroom_id'=>$classroomid));
        $this->db->order_by('strdate', 'ASC');
        $this->db->limit(1);
        return $this->db->get()->row_array(); 
    }
    

    function get_schedule_startenddate($params)
    {
        $class_id= $params['class_id'];
        $curr_date= $params['curr_date'];
        $st_date= $params['st_date'];
        $end_date= $params['end_date'];
        $this->db->select('`id`');
        $this->db->from('`online_class_schedules`'); 
        //$this->db->where("DATE_FORMAT(FROM_UNIXTIME(`strdate`), '%d-%m-%Y') ",'$curr_date');
        $this->db->where("DATE_FORMAT(FROM_UNIXTIME(`strdate`), '%d-%m-%Y')=", $curr_date);
        $this->db->where(array('classroom_id'=>$class_id,'active'=>1));
        if(isset($params['online_class_schedule']))
        {
            $con="AND id!='$params[online_class_schedule]'";
            $this->db->where("id !=", $params['online_class_schedule']);

        }
        $count= $this->db->get('')->num_rows();
        //print_r($this->db->last_query());exit;
        if($count >0)
        {
            // $sql="SELECT id FROM `online_class_schedules` WHERE classroom_id='$class_id' AND DATE_FORMAT(FROM_UNIXTIME(`strdate`), '%d-%m-%Y') = '$curr_date' AND (('$end_date' <=strdate) || ('$st_date' >=strdate_end))";    
            // $query = $this->db->query($sql);

            $sql="SELECT id FROM `online_class_schedules` WHERE classroom_id='$class_id' AND DATE_FORMAT(FROM_UNIXTIME(`strdate`), '%d-%m-%Y') = '$curr_date' $con ";    
            $query = $this->db->query($sql);
            $flag=0;
            foreach($query->result_array() as $val)
            {
              
                $sql="SELECT id FROM `online_class_schedules` WHERE id='$val[id]' AND DATE_FORMAT(FROM_UNIXTIME(`strdate`), '%d-%m-%Y') = '$curr_date' AND (('$end_date' <=strdate) || ('$st_date' >=strdate_end))";    
                $query = $this->db->query($sql);
                $count_num= $query->num_rows();
                if($count_num == 0)
                {
                    $flag=1;//duplicate found

                }
                //echo $count.'<br>';

            }
            
            if($flag == 1)
            {
                return "";
                
            }
            else {
                return 1;
            }

        }
        else {
        return 1;
        }


    
        // $this->db->select('id');
        // $this->db->from('online_class_schedules');        
        // $this->db->where(array('classroom_id'=> $params['class_id'],));
        // return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    }

    
    function deactivate_classshedule($todaystr,$classroom_id){

        $params = array('active'=> 0);
       // $this->db->where('`strdate_end` <= ',$todaystr);
        $this->db->where(array('classroom_id'=>$classroom_id,'active'=>1,'`strdate_end` <= '=>$todaystr));
          $this->db->update('online_class_schedules',$params);
        //print_r($this->db->last_query());exit;
    }

    function get_selectedclassroomschedule_count($classroom_id=0,$selecteddate,$edit_online_class_schedule){

        $this->db->from('online_class_schedules');        
        $this->db->where('classroom_id', $classroom_id);             
        $this->db->where("DATE_FORMAT(FROM_UNIXTIME(`strdate`), '%d-%m-%Y')=", $selecteddate);
        $this->db->where('id !=', $edit_online_class_schedule);    
        return $this->db->count_all_results();
        //print_r($this->db->last_query());exit;
    }
    
}
