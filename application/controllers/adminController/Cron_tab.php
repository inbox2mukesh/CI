<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/
class Cron_tab extends MY_Controller{

    function __construct(){
        parent::__construct();
        $this->load->database();
    }  

    function cronJob_createPackHoldDataHistory(){
        
        $this->load->model('Student_package_model');       
        $packHoldData = $this->Student_package_model->getPackHoldData();
        $holdDateTo= '';
        $holdDateTo = date('d-m-Y', strtotime($holdDateTo. ' + 1 days'));
        $remarks = "Pack On hold is realeased on $holdDateTo ";
        foreach ($packHoldData as $phd) {
            $holdDateTo= $phd['holdDateTo'];
            $params1 = array(
                'student_package_id'=>$phd['student_package_id'],
                'student_id'=>$phd['student_id'],
                'type'=>NULL,
                'cat'=>NULL,
                'amount'=>0,
                'remarks'=>$remarks,
                'file'=>$phd['application_file'],
                'by_user'=>NULL
            );
            $idd1=$this->Student_package_model->update_transaction($params1); 
            if($idd1){
                $params2 = array(
                    'holdDateFrom'=>'',
                    'holdDateTo'=>'',
                    'application_file'=>NULL,
                );
                $idd2=$this->Student_package_model->update_student_pack($phd['student_package_id'],$params2);
            }else{

            }
        }
    }  

    function cronJob_fetchCRSLeads(){       
       $this->load->model('Immigration_tools_model');
       $cronData = $this->Immigration_tools_model->cron_get_all_crs_score(); 
    }

    function cronJob_custom_fetchCRSLeads(){        
        $this->load->model('Immigration_tools_model');
        $cronData = $this->Immigration_tools_model->cron_get_all_crs_score();
        redirect('adminController/lead_management/crs_list');
    }

    function cronJob_copydbtotesting(){

        $testingdb = $this->load->database('testingdb', TRUE);            
        // testing database info get
        $testingdatabase=$testingdb->database;
        $testinghostname=$testingdb->hostname;
        $testingusername=$testingdb->username;
        $testingpassword=$testingdb->password;
            
        /// live database info get
        $database=$this->db->database;
        $hostname=$this->db->hostname;
        $username=$this->db->username;
        $password=$this->db->password; 
 
        $sourceDbName = $database;
        $destinationDbName = $testingdatabase;
        $connection = new PDO('mysql:host='.$hostname.';dbname=' . $database, $username, $password);

        $tables = $connection->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        $connection->exec("USE {$destinationDbName}");

        foreach ($tables as $tableName) {
            $truncateCommand = $connection->query("truncate table `{$destinationDbName}`.`{$tableName}`");
            $createCommand = $connection->query("SHOW CREATE TABLE `{$sourceDbName}`.`{$tableName}`")->fetchColumn(1);
            $carefulCreateCommand = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $createCommand);
            
            $connection->exec($carefulCreateCommand);
            echo "Table `{$tableName}` created" . PHP_EOL;
          
            $connection->exec("INSERT INTO `{$destinationDbName}`.`{$tableName}` SELECT * FROM `{$sourceDbName}`.`{$tableName}`");
            echo "Data for table `{$tableName}` copied" . PHP_EOL;
        }

    }   


    function cronJob_copydbtotesting_role(){

        $testingdb = $this->load->database('testingdb', TRUE);
            
        // testing database info get
        $testingdatabase=$testingdb->database;
        $testinghostname=$testingdb->hostname;
        $testingusername=$testingdb->username;
        $testingpassword=$testingdb->password;
            
        // live database info get
        $database=$this->db->database;
        $hostname=$this->db->hostname;
        $username=$this->db->username;
        $password=$this->db->password; 
 
        $sourceDbName = $database;
        $destinationDbName = $testingdatabase;
        $connection = new PDO('mysql:host='.$hostname.';dbname=' . $database, $username, $password);

        $tables = $connection->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        $connection->exec("USE {$destinationDbName}");

        foreach($tables as $tableName){

            if($tableName=="role_access"){
            $truncateCommand = $connection->query("truncate table `{$destinationDbName}`.`{$tableName}`");
            $createCommand = $connection->query("SHOW CREATE TABLE `{$sourceDbName}`.`{$tableName}`")->fetchColumn(1);
            $carefulCreateCommand = str_replace("CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $createCommand);
            
            $connection->exec($carefulCreateCommand);
            // echo "Table `{$tableName}` created" . PHP_EOL;          
            $connection->exec("INSERT INTO `{$destinationDbName}`.`{$tableName}` SELECT * FROM `{$sourceDbName}`.`{$tableName}`");
            //echo "Data for table `{$tableName}` copied" . PHP_EOL;
            }
        }
    }

    function cronJob_is_correct_logged_in(){
        
        $this->load->model('User_model'); 
        $user = $this->session->userdata(SESSION_VAR);

        $verifyAccess = $this->User_model->verifyAccess($_SESSION['employeeCode']);
        $portal_access = $verifyAccess['portal_access'];

        $verifyToken = $this->User_model->verifyToken($_SESSION['employeeCode']);
        $userToken = $verifyToken['token'];
        $status = $verifyToken['status'];

        if($userToken == $_SESSION['token']){
           
            if(empty($user)){
                echo $logoutReason = STO;
            }else{
                if($portal_access!=1){
                    echo $logoutReason = PAR;
                }else{
                    echo 1;
                }
            }

        }else{
           echo $logoutReason = MDL;
        }
    }
    // Added by Vikram 6 dec 2022
    function cronJob_is_student_correct_logged_in(){
        
        $this->load->model('Student_model'); 
        $user = $this->session->userdata('student_login_data');
        $verifyAccess = $this->Student_model->verifyAccess($user->id);
        $is_student_active = $verifyAccess['active'];
        $verifyToken = $this->Student_model->verifyToken($user->id);
        $userToken = $verifyToken['token'];
        $status = $verifyToken['status'];

        if(empty($userToken)) {
            echo TRUE;
        } else if($userToken == $user->token){
           
            if(empty($user)){
                echo $logoutReason = STO;
            }else{

                if($is_student_active != 1){
                    echo $logoutReason = PAR;
                }else{
                    echo TRUE;
                }
            }

        }else{
           echo $logoutReason = MDL;
        }
    }

    function cronJob_deactivateApprovedRefundNotUsedAfterTwoDays(){
        $this->load->model('Refund_model');
        $today = date('d-m-Y');
        $todayStr = strtotime($today);
        $this->Refund_model->deactivateApprovedRefundNotUsedAfterTwoDays($todayStr);
    }

    function cronJob_deactivateApprovedWaiverNotUsedAfterTwoDays(){        
        $this->load->model('Waiver_model');
        $today = date('d-m-Y');
        $todayStr = strtotime($today);
        $this->Waiver_model->deactivateApprovedWaiverNotUsedAfterTwoDays($todayStr);
    }

    function cronJob_backupAttendance(){
        $this->load->model('Student_attendance_model');
        $today = date('d-m-Y');
        $strDate = strtotime($today);
        $backupAttendance = $this->Student_attendance_model->backupAttendance($strDate);
    }  

    function cronJob_updateDueCommittmentDate(){
        $this->load->model('Student_package_model');
        //do blank if due is 0        
        $this->Student_package_model->updateDueCommittmentDate();
    } 

    function cronJob_suspendPackAfterDueCommittmentDate(){
        $this->load->model('Student_package_model');
        $today = date('d-m-Y');
        $yesterday = date('d-m-Y', strtotime($today. ' - 1 days'));
        $yesterdayStr = strtotime($yesterday);
        $cronData = $this->Student_package_model->suspendPackAfterDueCommittmentDate($yesterdayStr);
    }    
    
    function cronJob_startPackOnHold(){
        $this->load->model('Package_master_model');
        $today=date('d-m-Y');
        $cronData = $this->Package_master_model->startPackOnHold($today); 
    }
    function cronJob_activatePackWhichIsOnHold_finished(){
        $this->load->model('Package_master_model');
        $today=date('d-m-Y');
        $cronData = $this->Package_master_model->activatePackWhichIsOnHold_finished($today);
    }
    function cronJob_DeactivateExpiredPack()
    {
        
        $this->load->model('Package_master_model');
        $today=strtotime(date('d-m-Y')." -24 hours");
        $cronData = $this->Package_master_model->DeactivateExpiredPack($today);
    }
    function cronJob_calculateIrrDuesForExpiredPack(){
        $this->load->model('Student_package_model');
        //$today=date('d-m-Y');
        $today=strtotime(date('d-m-Y'));
        $cronData = $this->Student_package_model->calculateIrrDuesForExpiredPack($today);
    }
       
    function cronJob_startPackByStartDate(){
        $this->load->model('Package_master_model');
        $today=strtotime(date('d-m-Y'));
        $cronData = $this->Package_master_model->startPackByStartDate($today);
    }
    function cronJob_deactiveCounsellingSession(){        
        $this->load->model('Counseling_session_model');
        $current_DateTime = date("d-m-Y G:i:0");
        
        $list = $this->Counseling_session_model->gettodaycounselling($current_DateTime);
        foreach($list as $key => $lists)
        {
            // strtotime($current_DateTime.' + '.$lists['duration'].' minute');
            $current_DateTimeStr = strtotime($current_DateTime.' + '.$lists['duration'].' minute'); 
            $cronData = $this->Counseling_session_model->deactivate_shedule($current_DateTimeStr);
        }
        // pr($list);
        
    }
    
}
