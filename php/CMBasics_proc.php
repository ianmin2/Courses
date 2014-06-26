<?php

$funcName = @$_REQUEST['method'];

//Check if the email address Provided is a valid email address
if(@$_REQUEST['email'] != ""){
	
	if(!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)){
		echo $_REQUEST['callback'].'('.json_encode("That email is invalid!<br />").')';
		die;
	}
	
}


include "CMBasics_proc_validate.php";
$basicVal = new CMBasicsValidation(@$_REQUEST['id'], @$_REQUEST['nom'], @$_REQUEST['country'], @$_REQUEST['institution'], @$_REQUEST['school'], @$_REQUEST['department'], @$_REQUEST['major'], @$_REQUEST['minor'], @$_REQUEST['student'], @$_REQUEST['identification'], @$_REQUEST['passkey'], @$_REQUEST['email'], @$_REQUEST['google'], @$_REQUEST['yahoo'], @$_REQUEST['live'], @$_REQUEST['facebook'], @$_REQUEST['linkedin'], @$_REQUEST['twitter'], @$_REQUEST['course'], @$_REQUEST['grade'], @$_REQUEST['aim'], @$_REQUEST['comment'], @$_REQUEST['dates'], @$_REQUEST['callback']);

if(@$funcName != ""){
	
	switch ($funcName){
		
		#//Adding an institution
		case "addInstitution":
			$basicVal->addInstitutionValidate();
		break;
		
		#//Draw an institution list based on country
		case "getInstitution":
			$basicVal->getInstitutionValidate();
		break;
		
		#//Adding a school
		case "addSchool":
			$basicVal->addSchoolValidate();
		break;
		
		#//Retreiving a list of schools
		case "getSchools":
			$basicVal->getSchoolsValidate();
		break;
		
		#//Adding a department
		case "addDepartment":
			$basicVal->addDepartmentValidate();
		break;
		
		#//Get a list of departments
		case "getDepartments":
			$basicVal->getDepartmentsValidate();
		break;
		
		#//Adding a major
		case "addMajor":
			$basicVal->addMajorValidate();
		break;
		
		
		#//Get a list of majors
		case "getMajors":
			$basicVal->getMajorsValidate();
		break;
		
		#//Adding a course
		case "addCourse":
			$basicVal->addCourseValidate();
		break;
		
		#//Adding a student
		case "addStudent":
			$basicVal->addStudentValidate();
		break;
		
		#//updating a student
		case "updateStudent":
			$basicVal->updateStudentValidate();
		break;
		
		#//Adding a progress file
		case "addProgress":
			$basicVal->addProgressValidate();
		break;
		
		#//Updating a progress file
		case "updateProgress":
			$basicVal->updateProgressValidate();
		break;
		
		#//Custom developer feature tester
		case "quackDev":
			$basicVal->doQuackDev();
		break;
		
		#//Handling the "method not found error"
		default:
			echo $_REQUEST['callback'].'('.json_encode("Failed to understand the given command.<br />").')';
		break;
		
	}	
	
}


/*
if(function_exists($_GET['method'])){
		$_GET['method']();
	}else{
		echo $_GET['callback'].'('."The called function is undefined!".')';
	}
*/

?>