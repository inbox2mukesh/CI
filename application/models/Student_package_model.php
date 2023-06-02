<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/

 
class Student_package_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getPackHoldData(){

        $this->db->select('student_package_id,student_id,holdDateFrom,holdDateTo,application_file');
        $this->db->from('`student_package`');
        $this->db->where(array('onHold'=> 0,'active'=>1,'holdDateFrom!='=>'','holdDateTo!='=>'','application_file!='=>''));
        return $this->db->get('')->result_array();        
        //print_r($this->db->last_query());exit;
    }

    function checkDuplicateInhousePackBooking($package_id,$student_id,$type){

        $this->db->from('student_package');
        $this->db->where(array('package_id'=>$package_id,'student_id'=>$student_id,'pack_type'=>$type,'active'=>1));
        return $this->db->count_all_results();
    } 

    function getExamPackageId($student_package_id){

        $this->db->select('package_id');
        $this->db->from('`student_package`');
        $this->db->where(array('student_package_id'=> $student_package_id));
        return $this->db->get('')->row_array();
    }   

    function getAmountPaid($student_package_id){

        $this->db->select('amount_paid');
        $this->db->from('`student_package`');
        $this->db->where(array('student_package_id'=> $student_package_id));
        return $this->db->get('')->row_array();
    }

    function getBookedExamCourse($student_package_id){
        
        $this->db->select('test_module_id,programe_id');
        $this->db->from('`student_package`');
        $this->db->where(array('student_package_id'=> $student_package_id));
        return $this->db->get('')->row_array();
    }

    function getDues($student_package_id){

        $this->db->select('amount_due,irr_dues');
        $this->db->from('`student_package`');
        $this->db->where(array('student_package_id'=> $student_package_id));
        return $this->db->get('')->row_array();
    }

    function getCurrentDueCommittmentDate($student_package_id){

        $this->db->select('due_commitment_date');
        $this->db->from('`student_package`');
        $this->db->where(array('student_package_id'=> $student_package_id));
        return $this->db->get('')->row_array();
    }    

    function calculateIrrDuesForExpiredPack($today){

        return $this->db->query("update `student_package` SET             
            `irr_dues` = `irr_dues` + `amount_due`,
            `amount_due` = 0,
            `due_commitment_date` = ''
            where expired_on_str <= '".$today."'
        ");
    } 

    function updateDueCommittmentDate(){

        return $this->db->query("update `student_package` SET 
            `due_commitment_date` = '' 
            where amount_due <= 0
        ");
    }

    function updateNewDueCommittmentDate($student_package_id,$params){

       /* return $this->db->query("update `student_package` SET 
            `due_commitment_date` = '".$params['due_commitment_date']."' 
            where student_package_id = '".$student_package_id."' 
        "); */


        $this->db->where('student_package_id',$student_package_id);
        return $this->db->update('student_package',$params);
    }

    function suspendPackAfterDueCommittmentDate($yesterdayStr){

        return $this->db->query("update `student_package` SET 
            `active` = 0, `packCloseReason` = 'Due' where `amount_due` > 0 and due_commitment_date <= '".$yesterdayStr."'
        ");
        //print_r($this->db->last_query());exit;
    }

    function branchCollection($student_id){

        $this->db->distinct('');
        $this->db->select('GROUP_CONCAT(`center_id`) as `all_center_id`');
        $this->db->from('student_package');
        $this->db->where(array('student_id'=>$student_id,'center_id!='=>NULL));
        return $this->db->get()->row_array();
    }

    function get_pack_type($student_package_id){

        $this->db->select('pack_type');
        $this->db->from('`student_package`');
        $this->db->where(array('student_package_id'=> $student_package_id));
        return $this->db->get('')->row_array();
    }

    function getPackProfile($student_package_id){

        $this->db->select('
            test_module_id,programe_id,category_id,center_id,batch_id
        ');
        $this->db->from('`student_package`');
        $this->db->where(array('student_package_id'=> $student_package_id));
        return $this->db->get('')->row_array();
    }

    function getPackProfile2($id){

        $this->db->select('cr.classroom_name,tm.test_module_name,pgm.programe_name,cl.center_name,b.batch_name');
        $this->db->from('`student_package` spkg');        
        $this->db->join('`classroom` cr', 'cr.`id`= spkg.`classroom_id`','left');
         $this->db->join('`programe_masters` pgm', 'spkg.`programe_id`= pgm.`programe_id`','left');
        $this->db->join('`test_module` tm', 'tm.`test_module_id`= spkg.`test_module_id`', 'left');
        $this->db->join('`center_location` cl', 'cl.`center_id`= spkg.`center_id`', 'left');
        $this->db->join('`batch_master` b', 'b.`batch_id`= spkg.`batch_id`', 'left');
        $this->db->where(array('spkg.student_id'=> $id,'spkg.pack_type!='=>'reality test','spkg.active'=> 1));
        return $this->db->get('')->result_array();
        //print_r($this->db->last_query());exit;
    } 

    function get_reciept($sid,$student_package_id){

        $this->db->select('
            s.fname,
            s.lname,
            s.UID,
            s.mobile,
            s.country_code,
            s.email,
            spkg.`package_name`,
            FORMAT(spkg.`amount`/100,2) AS amount,
            pkg.`discounted_amount` AS discounted_amount,            
            CONCAT(pkg.`duration`, " Day(s)") as duration,
            spkg.`payment_id`,
            spkg.`order_id`,
            spkg.student_package_id,
            FORMAT(spkg.`amount_paid`/100,2) AS amount_paid,
            FORMAT(spkg.`waiver`/100,2) AS waiver,
            FORMAT(spkg.`other_discount`/100,2) AS other_discount,
            FORMAT(spkg.`amount_due`/100,2) AS amount_due,
            FORMAT(spkg.`amount_refund`/100,2) AS amount_refund,
            FORMAT(spkg.`cgst_amt`/100,2) AS cgst_amt,
            FORMAT(spkg.`sgst_amt`/100,2) AS sgst_amt,
            spkg.`method`,
            spkg.subscribed_on as `subscribed_on`,
            spkg.expired_on as `expired_on`,
            spkg.requested_on as `requested_on`,
            tm.`test_module_name`,
            pgm.`programe_name`,
            spkg.method,
            spkg.pack_type,
            spkg.currency,
        ');
        $this->db->from('`student_package` spkg');       
        $this->db->join('`students` s', 'spkg.`student_id`= s.`id`');
        $this->db->join('`package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`');
        $this->db->join('`test_module` tm','pkg.`test_module_id`=tm.`test_module_id`', 'left');
        $this->db->join('`programe_masters` pgm','pgm.`programe_id`=spkg.`programe_id`','left');
        $this->db->where(array('spkg.student_package_id'=> $student_package_id,'spkg.student_id'=>$sid));
        return $this->db->get('')->row_array();
        ///print_r($this->db->last_query());exit;
    } 

    function get_reciept_pp($sid,$student_package_id){

        $this->db->select('
            s.fname,
            s.lname,
            s.UID,
            s.mobile,
            s.country_code,
            s.email,
            spkg.`package_name`,
            FORMAT(spkg.`amount`/100,2) AS amount,
            pkg.`discounted_amount` AS discounted_amount,
            CONCAT(pkg.`duration`, " Day(s)") as duration,
            spkg.`payment_id`,
            spkg.`order_id`,
            spkg.student_package_id,
            FORMAT(spkg.`amount_paid`/100,2) AS amount_paid,
            FORMAT(spkg.`waiver`/100,2) AS waiver,
            FORMAT(spkg.`other_discount`/100,2) AS other_discount,
            FORMAT(spkg.`amount_due`/100,2) AS amount_due,
            FORMAT(spkg.`amount_refund`/100,2) AS amount_refund,
            FORMAT(spkg.`cgst_amt`/100,2) AS cgst_amt,
            FORMAT(spkg.`sgst_amt`/100,2) AS sgst_amt,
            spkg.`method`,spkg.pack_type,
            spkg.subscribed_on as `subscribed_on`,
            spkg.expired_on as `expired_on`,
            spkg.requested_on as `requested_on`,
            tm.`test_module_name`,
            pgm.`programe_name`,
            spkg.currency,
        ');
        $this->db->from('`student_package` spkg');       
        $this->db->join('`students` s', 'spkg.`student_id`= s.`id`');
        $this->db->join('`practice_package_masters` pkg', 'pkg.`package_id`= spkg.`package_id`');
        $this->db->join('`test_module` tm','pkg.`test_module_id`=tm.`test_module_id`', 'left');
        $this->db->join('`programe_masters` pgm','pgm.`programe_id`=spkg.`programe_id`','left');
        $this->db->where(array('spkg.student_package_id'=> $student_package_id,'spkg.student_id'=>$sid));
        return $this->db->get('')->row_array();
        //print_r($this->db->last_query());exit;
    }
    
    /*
     * Get pack status
     */
    function getPackStatus($id,$programe_id,$test_module_id)
    {
        $this->db->select('active as havePackage');
        $this->db->from('student_package');
        $this->db->where(array('student_id'=> $id,'programe_id'=> $programe_id,'test_module_id'=> $test_module_id, 'active'=>1));
        return $this->db->get()->row_array();
    }
    
    function get_sid($student_package_id)
    {
        $this->db->select('student_id,amount_paid');
        $this->db->from('student_package');
        $this->db->where(array('student_package_id'=> $student_package_id));
        return $this->db->get()->row_array();
    }

    function getPackExpiry($student_package_id)
    {
        $this->db->select('expired_on,expired_on_str,packCloseReason');
        $this->db->from('student_package');
        $this->db->where(array('student_package_id'=> $student_package_id));
        return $this->db->get()->row_array();
    }

    function getPackExpiry2($student_package_id)
    {
        $this->db->select('expired_on,holdDateFrom,holdDateTo,application_file');
        $this->db->from('student_package');
        $this->db->where(array('student_package_id'=> $student_package_id));
        return $this->db->get()->row_array();
    }

    function update_student_pack_payment($student_package_id,$params){
        // pr($params);

        $add_payment = $params['add_payment'];
        $active = $params['active'];
        $packCloseReason = $params['packCloseReason'];
        $cgst_amt = $params['cgst_amt'];
        $sgst_amt = $params['sgst_amt'];
        $amount_paid = $params['amount_paid'];
        $tax_detail = $params['tax_detail'];
        $total_amt_ext_tax =$params['total_amt_ext_tax'];
        if($params['due_commitment_date']){
          $due_commitment_date = $params['due_commitment_date'];
        }else{
          $due_commitment_date ='';
        }
        
        if($due_commitment_date){

            return $this->db->query("update `student_package` SET 
                `amount_paid` =`amount_paid` + '". $amount_paid."',
                `amount_due` = `amount_due` - '".$add_payment."',
                `active` = '".$active."',
                `due_commitment_date` = '".$due_commitment_date."',
                `packCloseReason` = '".$packCloseReason."',
                `cgst_amt` = `cgst_amt`+'".$cgst_amt."', 
                `sgst_amt` = `sgst_amt`+'".$sgst_amt."',
                `tax_detail` = '".$tax_detail."',
                `total_paid_ext_tax`= `total_paid_ext_tax`+'".$add_payment."'
                where student_package_id = '".$student_package_id."' 
            ");

        }else{
            return $this->db->query("update `student_package` SET 
                `amount_paid` =`amount_paid` + '". $amount_paid."',
                `amount_due` = `amount_due` - '".$add_payment."',
                `active` = '".$active."',                
                `packCloseReason` = '".$packCloseReason."',
                `cgst_amt` = `cgst_amt`+'".$cgst_amt."', 
                `sgst_amt` = `sgst_amt`+'".$sgst_amt."',
                `tax_detail` = '".$tax_detail."',
                `total_paid_ext_tax`= `total_paid_ext_tax`+'".$add_payment."'
                where student_package_id = '".$student_package_id."' 
            ");
        }
        
    }

    function update_student_pack_payment_for_waiver_remburse($student_package_id,$params){

        $add_payment = $params['add_payment'];
        $active = $params['active'];
        $by_user = $params['by_user'];
        $waiver_by = $params['waiver_by'];
        
        return $this->db->query("update `student_package` SET
            `amount_due` = `amount_due` - '".$add_payment."',
            `waiver` = `waiver` + '".$add_payment."',
            `active` = '".$active."',
            `by_user` = '".$by_user."',
            `waiver_by` = '".$waiver_by."'
            where student_package_id = '".$student_package_id."' 
        ");
    }

    function update_student_pack_payment_pack_extension($student_package_id,$params){

        $add_payment = $params['add_payment'];
        $expired_on = $params['expired_on'];
        $active = $params['active'];
        $total_tax = $params['total_tax'];
        $ext_total_amt = $params['ext_total_amt'];
        $ext_remarks = $params['ext_remarks'];
        // $total_amt = $params['total_amt'];
        // $tax_detail = $params['tax_detail'];
        return $this->db->query("update `student_package` SET
            `ext_amount` = `ext_amount` + '".$add_payment."',
            `ext_remarks` = '".$ext_remarks."',
            `expired_on` = '".$expired_on."',
            `expired_on_str` = '".strtotime($expired_on)."',
            `packCloseReason` = NULL,
            `active` = '".$active."' , 
            `ext_total_tax`= `ext_total_tax` + '".$total_tax."',
            `ext_total_amt`= `ext_total_amt` + '".$ext_total_amt."'
            where student_package_id = '".$student_package_id."' 
        ");
    }
    
    //partial refund
    function update_student_pack_payment_refund($student_package_id,$params){

        $add_payment = $params['add_payment'];
        $active = $params['active'];
        $packCloseReason = $params['packCloseReason'];
        $by_user = $params['by_user'];
        return $this->db->query("update `student_package` SET 
            `amount_paid` = `amount_paid` - '".$add_payment."',
            `amount_refund` = `amount_refund` + '".$add_payment."',
            `active` = '".$active."',
            `packCloseReason` = '".$packCloseReason."',
            `by_user` = '".$by_user."'
            where student_package_id = '".$student_package_id."' 
        ");
    }

    function update_student_pack_payment_full_refund($student_package_id,$params){

        $add_payment = $params['add_payment'];
        $active = $params['active'];
        $packCloseReason = $params['packCloseReason'];
        $by_user = $params['by_user'];

        return $this->db->query("update `student_package` SET 
            `amount_paid` = `amount_paid` - '".$add_payment."',
            `amount_refund` = `amount_refund` + '".$add_payment."',
            `active` = '".$active."' ,
            `by_user` = '".$by_user."' ,
            `packCloseReason`= '".$packCloseReason."'
            where student_package_id = '".$student_package_id."' 
        ");
    }

    function updateTranHistory($student_package_id,$tranHistory){

        return $this->db->query("update `student_package` SET 
            `tranHistory` = CONCAT(`tranHistory` , '".$tranHistory."')
            where student_package_id = '".$student_package_id."' 
        ");
    }

    function update_transaction($params){     

        $this->db->insert('student_transaction_history',$params);
        return $this->db->insert_id();  
    }

    function update_student_package($student_package_id,$params){     

        $cutting_amount = $params['cutting_amount'];
        $restAmount = $params['restAmount'];
        $packCloseReason= $params['packCloseReason'];
        $active = $params['active'];
        $by_user = $params['by_user'];

        return $this->db->query("update `student_package` SET 
            `amount_paid` = '".$cutting_amount."',
            `amount_paid_by_wallet` = 0,
            `amount_refund` = `amount_refund` + '".$restAmount."',
            `packCloseReason` = '".$packCloseReason."',
            `active` = '".$active."',
            `by_user` = '".$by_user."'
            where student_package_id = '".$student_package_id."' 
        ");  
    }

    function update_student_pack($student_package_id,$params){     

        $this->db->where('student_package_id',$student_package_id);
        return $this->db->update('student_package',$params);
    }

    function transferDueToIrrDue($student_package_id){

        return $this->db->query("update `student_package` SET             
            `irr_dues` = `irr_dues` + `amount_due`,
            `amount_due` = 0,
            `amount_paid_by_wallet` = 0,
            `due_commitment_date` = ''
            where student_package_id = '".$student_package_id."' 
        ");

    }

    function getDuesReportCount($params){

        $query='';
        $center_id = $params['center_id'];
        $pack_type = $params['pack_type'];
        $test_module_id = $params['test_module_id'];
        $programe_id = $params['programe_id'];
        $date_from = $params['date_from'];
        $date_to = $params['date_to'];

        if($center_id!=''){
            $query .= " spkg.center_id = ".$center_id." and ";
        }
        if($pack_type!=''){
            $query .= " spkg.pack_type = '$pack_type' and ";
        }
        if($test_module_id!=''){
            $query .= " spkg.test_module_id = ".$test_module_id." and ";
        }
        if($programe_id!=''){
            $query .= " spkg.programe_id = ".$programe_id." and ";
        }
        //echo $query;die;
        //$query .= " d.due_commitment_date = ".$date_from." and ";       

        $x = $this->db->query('select count(spkg.student_package_id) from student_package spkg
        where '.$query.' spkg.amount_due>0');
        return $x->result_array(); 
    }

    //today,yesterday,tomarrow
    function getDuesReportYTT($userBranch,$roleName,$params){

       //$df = strtotime($date_from);
       //$dt = strtotime($date_to);
        $query='';
        $branchStr='';
       foreach ($userBranch as $u) {
           $branchStr .= $u.',';
       }
       $branchStr = rtrim($branchStr, ',');

       $date_from = $params['date_from'];//due committ. date
       $date_to = $params['date_to'];//due committ. date
       if($roleName==ADMIN){  
            if($date_from!='' and $date_to!=''){
                $df = strtotime($date_from);
                $dt = strtotime($date_to);
                $query .= " spkg.due_commitment_date >= ".$df." and spkg.due_commitment_date <= ".$dt." and ";
            }
           
       }else{
            if($date_from!='' and $date_to!=''){
                $df = strtotime($date_from);
                $dt = strtotime($date_to);
                $query .= " spkg.due_commitment_date >= ".$df." and spkg.due_commitment_date <= ".$dt." and spkg.center_id in (".$branchStr.") and";
            }
       }         
       $x = $this->db->query('
                select 
                s.id,s.UID,s.fname,s.lname,
                spkg.student_package_id,
                spkg.pack_type,
                spkg.amount_due,
                spkg.due_commitment_date,
                cl.center_name
            from student_package spkg
            left join students s on s.id = spkg.student_id
            left join center_location cl on cl.center_id = spkg.center_id
            where '.$query.' spkg.amount_due > 0
            ');
        return $x->result_array();

    }

    function getDuesReport($params){

        $query='';
        $center_id = $params['center_id'];
        $center_id = implode(',', $center_id);
        $pack_type = $params['pack_type'];
        $dateType = $params['dateType'];
        
        if($pack_type=='offline' or $pack_type=='online'){
            $tableName='package_masters';
            $pk = 'package_id';
            $package_name='package_name';
        }elseif($pack_type=='practice'){
            $tableName='practice_package_masters';
            $pk = 'package_id';
            $package_name='package_name';
        }elseif($pack_type=='reality test'){
            $tableName='real_test_dates';
            $pk = 'id';
            $package_name='title';
        }else{
            $tableName='';
            $pk = '';
            $package_name='';
        }
        $test_module_id = $params['test_module_id'];
        $test_module_id = implode(',', $test_module_id);
        $programe_id = $params['programe_id'];
        $programe_id = implode(',', $programe_id);
        $date_from = $params['date_from'];//due committ. date
        $date_to = $params['date_to'];//due committ. date

        if(!empty($center_id) and $pack_type!='reality test'){
            $query .= " spkg.center_id IN(".$center_id.") and ";
        }
        if(!empty($center_id) and $pack_type=='reality test'){
            $query .= " spkg.enrolledBy_homeBranch IN(".$center_id.") and ";
        }
        if($pack_type!=''){
            $query .= " spkg.pack_type = '$pack_type' and ";
        }
        if(!empty($test_module_id)){
            $query .= " spkg.test_module_id IN(".$test_module_id.") and ";
        }
        if(!empty($programe_id)){
            $query .= " spkg.programe_id IN(".$programe_id.") and ";
        }
        if($date_from!='' and $date_to!=''){
            $df = strtotime($date_from);
            $dt = strtotime($date_to);
            if($dateType==1){
                $query .= " spkg.due_commitment_date >= ".$df." and spkg.due_commitment_date <= ".$dt." and ";
            }else if($dateType==2){
                $query .= " spkg.subscribed_on_str >= ".$df." and spkg.subscribed_on_str <= ".$dt." and ";
            }else{
                $query .= " spkg.due_commitment_date >= ".$df." and spkg.due_commitment_date <= ".$dt." and ";
            }
            
        }
        if($tableName){
            $x = $this->db->query('
            select 
            s.id,s.UID,s.fname,s.lname,
            spkg.student_package_id,
            spkg.pack_type,
            spkg.amount_due,
            spkg.due_commitment_date,
            spkg.subscribed_on_str,
            pkg.'.$package_name.',
            cl.center_name 
        from student_package spkg
        left join students s on s.id = spkg.student_id
        left join '.$tableName.' pkg on pkg.'.$pk.' = spkg.package_id
        left join center_location cl on cl.center_id = spkg.center_id
        where '.$query.' spkg.amount_due > 0');
        }else{
            $x = $this->db->query('
            select 
            s.id,s.UID,s.fname,s.lname,
            spkg.student_package_id,
            spkg.pack_type,
            spkg.amount_due,
            spkg.due_commitment_date,
            spkg.subscribed_on_str,
            cl.center_name
        from student_package spkg
        left join students s on s.id = spkg.student_id
        left join center_location cl on cl.center_id = spkg.center_id
        where '.$query.' spkg.amount_due > 0');
        }        
        return $x->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getIrrDuesReport($params){

        $query='';
        $center_id = $params['center_id'];
        $center_id = implode(',', $center_id);
        $pack_type = $params['pack_type'];
        $dateType = $params['dateType'];
        
        if($pack_type=='offline' or $pack_type=='online'){
            $tableName='package_masters';
            $pk = 'package_id';
            $package_name='package_name';
        }elseif($pack_type=='practice'){
            $tableName='practice_package_masters';
            $pk = 'package_id';
            $package_name='package_name';
        }elseif($pack_type=='reality test'){
            $tableName='real_test_dates';
            $pk = 'id';
            $package_name='title';
        }else{
            $tableName='';
            $pk = '';
            $package_name='';
        }
        $test_module_id = $params['test_module_id'];
        $test_module_id = implode(',', $test_module_id);
        $programe_id = $params['programe_id'];
        $programe_id = implode(',', $programe_id);
        $date_from = $params['date_from'];//subs. date
        $date_to = $params['date_to'];//subs. date

        if(!empty($center_id) and $pack_type!='reality test'){
            $query .= " spkg.center_id IN(".$center_id.") and ";
        }
        if(!empty($center_id) and $pack_type=='reality test'){
            $query .= " spkg.enrolledBy_homeBranch IN(".$center_id.") and ";
        }
        if($pack_type!=''){
            $query .= " spkg.pack_type = '$pack_type' and ";
        }
        if(!empty($test_module_id)){
            $query .= " spkg.test_module_id IN(".$test_module_id.") and ";
        }
        if(!empty($programe_id)){
            $query .= " spkg.programe_id IN(".$programe_id.") and ";
        }
        if($date_from!='' and $date_to!=''){
            $df = strtotime($date_from);
            $dt = strtotime($date_to);            
            $query .= " spkg.subscribed_on_str >= ".$df." and spkg.subscribed_on_str <= ".$dt." and ";                        
        }
        if($tableName){
            $x = $this->db->query('
            select 
            s.id,s.UID,s.fname,s.lname,
            spkg.student_package_id,
            spkg.pack_type,
            spkg.irr_dues,
            spkg.subscribed_on_str,
            pkg.'.$package_name.',
            cl.center_name 
        from student_package spkg
        left join students s on s.id = spkg.student_id
        left join '.$tableName.' pkg on pkg.'.$pk.' = spkg.package_id
        left join center_location cl on cl.center_id = spkg.center_id
        where '.$query.' spkg.irr_dues > 0');
        }else{
            $x = $this->db->query('
            select 
            s.id,s.UID,s.fname,s.lname,
            spkg.student_package_id,
            spkg.pack_type,
            spkg.irr_dues,
            spkg.subscribed_on_str,
            cl.center_name
        from student_package spkg
        left join students s on s.id = spkg.student_id
        left join center_location cl on cl.center_id = spkg.center_id
        where '.$query.' spkg.irr_dues > 0');
        }        
        return $x->result_array();
        //print_r($this->db->last_query());exit;
    }

    function getInhoseClassroom($student_id){

        $this->db->select('classroom_id');
        $this->db->from('`student_package`');
        $this->db->where(array('student_id'=> $student_id,'pack_type'=>'offline','active'=>1));
        return $this->db->get('')->row_array();
    }

    function get_pack_startdate($student_package_id){

        $this->db->select('subscribed_on_str,expired_on,subscribed_on');
        $this->db->from('`student_package`');
        $this->db->where(array('student_package_id'=> $student_package_id));
        return $this->db->get('')->row_array();
    }
    function get_student_pack_detail($student_package_id){

        $this->db->select('*');
        $this->db->from('`student_package`');
        $this->db->where(array('student_package_id'=> $student_package_id));
        return $this->db->get('')->row_array();
    }

    function identify_api($id,$test_module_id,$programe_id){
        $this->db->select('student_package_id');
        $this->db->from('`student_package`');
        $this->db->where(array('student_id'=> $id,'pack_type'=>'practice','status'=>'succeeded'));
        $this->db->or_where('pack_type','online');
        $num_rows=$this->db->get('')->num_rows();
        if($num_rows > 0)
        {
            $this->db->select('student_package_id');
            $this->db->from('`student_package`');
            $this->db->where(array('student_id'=> $id,'pack_type'=>'practice','status'=>'succeeded','test_module_id'=>$test_module_id,'programe_id'=>$programe_id));
            $this->db->or_where('pack_type','online');
            $num_rows2=$this->db->get('')->num_rows();
            if($num_rows2 > 0)   {
                return 2; // Call Re-Enrollment api
            }   
            else { 
                return 3;// Call Add-program api
            }        
        }
        else {
            return 1; // Call Enrollment api
        }
       // return $this->db->get('')->row_array();
    }
    
}
