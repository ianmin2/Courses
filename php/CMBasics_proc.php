<?php

$funcName = @$_REQUEST['method'];

//Check if the email address Provided is a valid email address
if(@$_REQUEST['email'] != ""){
	
	if(!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)){
		$respArray = array("response" => "ERROR", "data" => array("message" => "That email is invalid!", "command" => "$('#emol').focus();"));
		echo $_REQUEST['callback'].'('.json_encode($respArray).')';
		die;
	}
	
}


include "CMBasics_proc_validate.php";
$basicVal = new CMBasicsValidation(@$_REQUEST['id'], @$_REQUEST['nom'], @$_REQUEST['country'], @$_REQUEST['institution'], @$_REQUEST['school'], @$_REQUEST['department'], @$_REQUEST['major'], @$_REQUEST['minor'], @$_REQUEST['student'], @$_REQUEST['identification'], @$_REQUEST['passkey'], @$_REQUEST['email'], @$_REQUEST['google'], @$_REQUEST['yahoo'], @$_REQUEST['live'], @$_REQUEST['facebook'], @$_REQUEST['linkedin'], @$_REQUEST['twitter'], @$_REQUEST['course'], @$_REQUEST['grade'], @$_REQUEST['aim'], @$_REQUEST['comment'], @$_REQUEST['dates'], @$_REQUEST['callback'], @$_REQUEST['loginKey']);

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
		
		#//Get courses for an institution
		case "getInstCourses":
			$basicVal->getInstCoursesValidate();
		break;
		
		#//Fetching a User's courses
		case "getMyCourses":
			$basicVal->getMyCoursesValidate();
		break;
		
		#//Fetch A course for progress editing
		case "getCourseById":
			$basicVal->getCourseByIdValidate();
		break;
		
		#//Mapping major to courses
		case "mapMajor":
			$basicVal->mapMajorValidate();
		break;
		
		#//unMapping a major to courses
		case "unmapMajor":
			$basicVal->unmapMajorValidate();
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
		
		#//Perform a user login
		case "doPasskeyLogin":
			$basicVal->doPasskeyLoginValidate();
		break;
		
		#//Perform a user login
		case "doSecureAuth":
			$basicVal->doSecureAuthValidate();
		break;
		
		#//Handling the "method not found error"
		default:
			$respArray = array("response" => "ERROR", "data" => array("message" => "Failed to understand the given command.", "command" => ""));
			echo $_REQUEST['callback'].'('.json_encode($respArray).')';
			exit;
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