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
        $today=strtotime(date('d-m-Y'));
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
    function cronJob_run_role(){      
               
        $controllers = get_filenames(APPPATH . 'controllers/adminController', FALSE, TRUE);
        foreach($controllers as $k => $v ){
            if(strpos($v, '.php') === FALSE){
                unset($controllers[$k] );
            }
        }
        foreach($controllers as $controller){            
            $excludedController=array(
                'Dashboard.php','Ckeditor.php','Login.php','Error_cl.php','Cron_tab.php','Forgot_password.php','Gender.php','Leads.php','Time_slot_master.php','Student_post.php','Discount.php','Classroom_post.php','Common.php','Url_slug.php','Sitemap.php',
            );
            if(in_array($controller, $excludedController)){

            }else{
                $controller_data = $this->Role_model->check_controller($controller);
                if(count($controller_data)>0){
                    $id = $controller_data[0]['id'];
                    $params = array(
                        'controller_name' => $controller,
                    );
                    $this->Role_model->update_controller($id,$params);
                    $controller_id=$id;

                }else{
                    $params = array(
                        'controller_name' => $controller,
                        'controller_alias' => $controller,
                    );
                    $controller_id = $this->Role_model->add_controller($params);
                } 
                include_once APPPATH . 'controllers/adminController/' . $controller;
                $methods = get_class_methods(str_replace( '.php', '', $controller));
                if(!empty($methods) && (is_array($methods) || is_object($methods))){
                foreach($methods as $method){ 

                    $excludedMethod=array(                    
                        'walk_dir', 
                        'CheckImgExt', 
                        'browse',
                        'get_instance',
                        'logout',
                        'Forgot_password', 
                        'profile_', 
                        'change_password',
                        'dashboard',
                        'crypto_rand_secure_',
                        'getUnicode_',
                        'schedule_discount',
                        'morning_attendance_',
                        'evening_attendance_',
                        'addUserActivity',
                        'clear_all_',
                        'displayRefundHistory_',
                        'adjust_online_and_inhouse_pack_',
                        'adjust_practice_pack_',
                        'student_transaction_', 
                        'user_activity_',
                        'set_erp_softly',
                        'set_erp_hardly',
                        'add_money_to_wallet',
                    );  
                    if(in_array($method, $excludedMethod)){              

                    }else{

                        $method_data = $this->Role_model->check_method($method,$controller_id);
                        if(count($method_data)>0){
                        }else{                   
                            if(substr($method, 0, 5) === "ajax_" or substr($method, 0, 9) === "sendEmail" or substr($method, 0, 7) === "sendSMS" or substr($method, 0, 1) === "_" or substr($method, 0, 8) === "cronJob_" or substr($method, 0, 5) === "auto_"){
                                $bool=0;
                            }else{
                                $bool=1;
                            }
                            if($bool==1){
                                $params = array(
                                    'controller_id'=>$controller_id,
                                    'method_name' => $method,
                                    'method_alias' => $method,
                                );
                                $this->Role_model->add_method($params);
                            }else{

                            }                        
                        }                    
                    }         
                    
                }
            }                
            }           

        } 
       
    }
    
    /****
     *  update site map
     *  
     */
    function cronJob_updatesitemap()
    {
        //access control ends
        //create all website links only take ancher tags
        $html = file_get_contents(site_url());
        $docm = new DOMDocument();
        @$docm -> loadHTML($html);
        $xp = new DOMXPath($docm);
        // Only pull back A tags with an href attribute starting with "http".
        $res = $xp -> query('//a[starts-with(@href, "http")]/@href');
        if ($res -> length > 0)
        {  
            foreach ($res as $node)
            {    
                if (strpos($node -> nodeValue, site_url()) !== false) {    
                        if($node -> nodeValue !=site_url()."sitemap")
                        {
                        $values[] = $node->nodeValue;   
                        }  
                }
            }
            $ress=array_unique($values);   

        }
        //--------ends----------
        //--------Create Xml file for generated links----------
        $dom = new DOMDocument();
		$dom->encoding = 'utf-8';
		$dom->xmlVersion = '1.0';
		$dom->formatOutput = true;
        $xml_file_name = 'sitemap.xml';
        $root = $dom->createElement('urlset');
        $attr_xmlns = new DOMAttr('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $attr_xmlnsxsi = new DOMAttr('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $attr_schemaLocation = new DOMAttr('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9');
		$root->setAttributeNode($attr_xmlns);
		$root->setAttributeNode($attr_xmlnsxsi);
		$root->setAttributeNode($attr_schemaLocation);
        sort($ress);
        foreach($ress as $val)
        {
            $label_url = $dom->createElement('url');
            $child_node_loc = $dom->createElement('loc', $val);    
            $label_url->appendChild($child_node_loc);    
            $child_node_lastmod = $dom->createElement('lastmod', '2023-02-01T10:25:21+00:00');    
            $label_url->appendChild($child_node_lastmod);    
            $child_node_gpriority = $dom->createElement('priority', '1.00');    
            $label_url->appendChild($child_node_gpriority);            
            $root->appendChild($label_url);
        }	
		$dom->appendChild($root);
	    $dom->save($xml_file_name);

    }
}
