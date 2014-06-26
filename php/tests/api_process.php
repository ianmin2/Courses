<?php

	mysql_connect("localhost", "root", "146450f7");
	mysql_select_db("courses");

	function getAllUsers(){

		$user_sql = mysql_query("select * from country");
		$users    = array();

		while($user = mysql_fetch_array($user_sql)){
			$users[] = $user;
			//echo $user."<br/>";
		}

		$users = json_encode($users);

		echo $_GET['jsoncallback'].'('.$users.')';

	}

	if(function_exists($_GET['method'])){
		$_GET['method']();
	}else{
		echo $_GET['jsoncallback'].'('.json_encode("The called function is undefined!.<br />").')';
		
	}

?>
