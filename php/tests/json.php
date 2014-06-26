<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JSON to PHP</title>
<script src="js2php.js" ></script>
<script>
			
	
	
		var person = new Array();
		person['fname'] = "Ian";
		person['mname'] = "Innocent";
		person['lname'] = "Mbae";
		person['age']   = "22";
		person['user']  = "ianmin2";
		
		var json = js2php(person);
		$.post("json.php",{json:json},function(d){
			console.log(d);
			$body.append("function json2obj($str){return json_decode(stripslashes($str));}$array = json2obj(d);echo $array->fname.'<br/>'.$array->mname.'<br/>'.$array->lname.'<br/>'.$array->age.'<br/>'.$array->user; ");
		});
		
	
</script>
</head>

<body>

<?php
/*
	function json2obj($str){
		return json_decode(stripslashes($str));
	}
	
	$array = json2obj($_POST["json"]);
	
	echo $array->fname."<br/>".$array->mname."<br/>".$array->lname."<br/>".$array->age."<br/>".$array->user;
	
	/*
	For associative arrays
	foreach($array as $obj){
		
		echo $array->fname."<br/>".$array->mname."<br/>".$array->lname."<br/>".$array->age."<br/>".$array->user;
		
	}
	
	*/



