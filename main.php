<?php
/*
	* Author: 	Ian Innocent
	* For: 		CourseMate
*/

/* Database connection variables ... and more! */

@session_start;

date_default_timezone_set("Africa/Nairobi");
$this_site = "http://tumaini.tk/tests/courses";

$db = 'u644087195_cmate'; $host = 'mysql.0hosting.org'; $user = 'u644087195_cmate'; 
$pass = 'iarasoft';

/*End of database connection variable declaration*/
if (@$jsoncallback == ""){$jsoncallback = $_REQUEST['callback'];}
//If the page resource identifier is provided
if(@$id != ''){

// WARNING ONLY ADD PAGES THAT ARE FULLY CLASSES OR PURELY FUNCTIONS TO THIS ARRAY Else Face the wrath of a broken connection 
	$ids = array('',
				 'mailer.php',			//Primary
				 'obsfucate.php',		//primary
				 'the_connection.php', 	//Primary
				 );
	
	//find the position of the given page-id in the above array
	$pos = array_search($id, $ids);
	
	//if the given page-id is non existent in the array give it's position [currently 'NULL'] the value 'unknown'
	if($ids[$pos]==''){$ids[$pos] = 'unknown';}
	
	//Loop through the entire resource array			
	for($i = 0; $i <= (count($ids)-1); $i++){
		
		//if the current position in the array is not the current one, include the given resource page 
		if($i <> $pos){	
				 
			if($ids[$i] != ''){
				include "$ids[$i]";	
			}
			
		} 
		
	}

	//Establish a database connection where required
	if(@$connect){
		
		//Establishing a database connection courtesy of the imported  resource files
		$connection = new connection($db, $host, $user, $pass, $jsoncallback);
	}

//If the page resource identifier is not provided
}else{
	
	$respArray = makeResponse("ERROR", "Critical Error: Failed to recognize application!", "");
	echo $jsoncallback."(".json_encode($respArray).")"; 
	die;
	
}

/*******************************************************
	SIMPLE FUNCTIONS PLACED TO BE COPIED TO THE ACTUAL PAGES WHERE NEEDED
*/

function makeResponse($response, $message, $command){
		
		return array( "response" => $response, "data" => array( "message" => $message, "command" => $command ) );
		
}


function sanitize($value){

	return htmlspecialchars(str_replace("'","\'",$value));	

}

function makeCookie($cname, $cval, $days){
	
		$days = ($days * 24 * 60 * 60 * 1000);
		@setcookie($cname,$cval,$days);
}

/******************************************************

*/

?>