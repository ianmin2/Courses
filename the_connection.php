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
			
			$respArray = makeResponse( "ERROR", "Critical Error: Could recognize database connection criteria!" , "");
			echo  $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}
	
	}
	
// The database connector!

	public final function db_connect(){
		
		$this->con = mysqli_connect($this->db_host,$this->db_username,$this->db_passwd,$this->db_name);
		
		if (mysqli_connect_errno($this->con)){
			
			$respArray = makeResponse( "ERROR", "Response: ".mysqli_connect_error(), "");
			echo  $this->jsoncallback."(".json_encode($respArray).")";
			exit;
			
		}
	}
	
	
	public function die_on_err($stops){
		
		if(@$stops){
			$_SESSION['query_error'] = array();
			$_SESSION['query_error'][] = mysqli_error($this->con);
			
			$respArray = makeResponse( "ERROR", "CRITICAL ERROR: ".mysqli_error($this->con), "");
			echo  $this->jsoncallback."(".json_encode($respArray).")";
			exit;
			
		}else{
			
			if(!isset($_SESSION['query_error'])){
				
				$_SESSION['query_error'] = array();
				
			} 
			
			$_SESSION['query_error'][] = mysqli_error($this->con);
			
		}
		
	}
	
	public function query($statement, $stops){  
	
		$_SESSION['query'] = mysqli_query($this->con,"$statement")or $this->die_on_err($stops); 
		
	}
	
	public function aQuery($statement, $stops, $success, $failure, $command ){  
	
		$_SESSION['query'] = mysqli_query($this->con,"$statement")or $this->die_on_err($stops);
		
		if($_SESSION['query']){
			
			
			$respArray = makeResponse( "SUCCESS", $success , $command);
			echo  $this->jsoncallback."(".json_encode($respArray).")";
			exit;
			
		}else{
			
			$respArray = makeResponse( "ERROR", $failure , $command);
			echo  $this->jsoncallback."(".json_encode($respArray).")";
			exit;
			
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
		
		$respArray = makeResponse( "SUCCESS", $elements , "");
		echo  $this->jsoncallback."(".json_encode($respArray).")";
		exit;		
		
	}
	
	
	public function error_alert($status){
		if(@$status){
			
			if(@count($_SESSION['query_error']) > 0){
				
				$err = $_SESSION['query_error'];
				unset($_SESSION['query_error']); 
				return  makeResponse("ERROR", $err, "" );
				
			}else{
				return; 
			}
			
		}
	}
	
	
	
	private function makeResponse($response, $message, $command){
		
		return array( "response" => $response, "data" => array( "message" => $message, "command" => $command ) );
		
	}
	
//End of Class	
}

	
