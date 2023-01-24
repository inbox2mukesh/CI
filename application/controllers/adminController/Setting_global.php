<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Haroon
 *
 **/ 
class Setting_global extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
		if (!$this->_is_logged_in()) {
            redirect("/");
        }        
      	//$this->load->model("Account_model");	         
    }
	
	

function syncdb() {

	$cn = $this->router->fetch_class() . "" . ".php";
	$mn = $this->router->fetch_method();
	if (!$this->_has_access($cn, $mn)) {
		redirect("adminController/error_cl/index");
	}

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
			//echo "Table `{$tableName}` created" . PHP_EOL;
		  
			$connection->exec("INSERT INTO `{$destinationDbName}`.`{$tableName}` SELECT * FROM `{$sourceDbName}`.`{$tableName}`");
			//echo "Data for table `{$tableName}` copied" . PHP_EOL;
		}
		
			$by_user=$_SESSION['UserId'];
			
			
		
				$activity_name= 'Manual Synced database';
				$description= 'Live data sync to Testing server';
				$res=$this->addUserActivity($activity_name,$description,$student_package_id=0,$by_user);
		
		echo 1;	

}
	

    
}
