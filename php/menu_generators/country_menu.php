<?php

	chdir("../../");
	$id 	= "test.php";
	$connect = true;
	include "main.php";
	
	$connection->query("select * from country",true);
	$con = $_SESSION['query'];
	
	while($c = mysqli_fetch_array($con)){
		echo '<option value="'.$c['id'].'">'.$c['coun_name'].'</option>';
	}

?>