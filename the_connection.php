<?php
/*
	* Author: Ian Innocent 
	* For: The Connection
*/
 @session_start();

class connection{
	
	public $db_name;	public $db_host; 		public $db_username;
	public $db_passwd;      public $jsoncallback;

//The class constructor	
	public function __construct($db_name, $db_host, $db_username, $db_passwd, $jsoncallback){
		
		$this->jsoncallback = $jsoncallback;
	
		if(@$db_host != '' && @$db_name != '' && @$db_username != ''){
			$this->db_host 		= 	@$db_host;
			$this->db_name 		= 	@$db_name;
			$this->db_passwd 	= 	@$db_passwd;
			$this->db_username 	= 	@$db_username;
			$this->db_connect();
			
		}else{
			echo $this->jsoncallback."(".json_encode("<error><center><h2><code style='color:#F00;'>Critical Error:<code style='color:green;'> Could recognize database connection criteria!").")";
			exit;
		}
	
	}
	
// The database connector!

	public final function db_connect(){
		
		$this->con = mysqli_connect($this->db_host,$this->db_username,$this->db_passwd,$this->db_name);
		
		if (mysqli_connect_errno($this->con)){
			echo $this->jsoncallback."(".json_encode("<error><center><h2><code style='color:#F00;'>Response: <code style='color:green;'>".mysqli_connect_error()).")";
		}
	}
	
	public function die_on_err($stops){
		
		if(@$stops){
			$_SESSION['query_error'] = array();
			$_SESSION['query_error'][] = mysqli_error($this->con);
			
			echo $this->jsoncallback."(".json_encode("<error><center><h2><code style='color:#F00;'>CRITICAL ERROR: <code style='color:green;'> ".mysqli_error($this->con)).")";
			exit;
		}else{
			
			if(!isset($_SESSION['query_error'])){$_SESSION['query_error'] = array();} 
			$_SESSION['query_error'][] = mysqli_error($this->con);
			
		}
		
	}
	
	public function query($statement, $stops){  
	
		$_SESSION['query'] = mysqli_query($this->con,"$statement")or $this->die_on_err($stops); 
		
	}
	
	public function aQuery($statement, $stops, $success, $failure){  
	
		$_SESSION['query'] = mysqli_query($this->con,"$statement")or $this->die_on_err($stops);
		
		if($_SESSION['query']){
			
			echo  $this->jsoncallback."(".json_encode($success).")";
			
		}else{
			
			echo  $this->jsoncallback."(".json_encode($failure).")";
			
		} 
		
	}
	
	
	public function num_rows($statement, $stops){
		
		$this->query($statement, $stops);
		$stmt = $_SESSION['query'];
		$_SESSION['num_rows'] = mysqli_num_rows( $stmt );
				
	}
	
	//SIMPLE RETURN RESULTS EXECUTOR
	function printQueryResults($statement, $bool){
		
		$this->query("$statement",$bool);
		$elementArr = $_SESSION['query'];
		
		$elements = array();
		while($element = mysqli_fetch_array($elementArr)){
			$elements[] = $element;
		}
		
		echo $this->jsoncallback."(".json_encode($elements).")";
		
	}
	
	
	public function error_alert($status){
		if(@$status){
			
			if(@count($_SESSION['query_error']) > 0){
				echo $this->jsoncallback."(".json_encode('<error> Device Error: '.@implode("<br />",$_SESSION['query_error'])).")";
				unset($_SESSION['query_error']); 
				return;
			}else{
				return; 
			}
			
		}
	}
	
//End of Class	
}

	
