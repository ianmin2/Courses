<?php

/*
	A packaged all in one approach to the solutions
*/

chdir("../");

class CMBasics{

	public $connection, $jsoncallback;
	
	public function __construct($jsoncallback){
		
		$id = "responses.php";
		$connect = true;
		include "main.php";
		//Store the object in a global class variable
		$this->connection = $connection;
		
		//destroy the pre-existing object to save memory
		unset($connection);
		
		$this->jsoncallback = $jsoncallback;
			 
	}

/****************************************************************************************************************************************/
//ADDING A NEW INSTITUTION

	function addInstitution( $nom, $country){

		$this->connection->aQuery("INSERT INTO institution (inst_name, inst_country) VALUES ('$nom','$country')", true, "Institution Successfully Added", "Failed to add institution!");
		
	}
	
	
/****************************************************************************************************************************************/
//FETCHING A LIST OF INSTITUTIONS

	function getInstitution($inst_country){
	
		$this->connection->printQueryResults("SELECT * FROM institution WHERE inst_country='$inst_country'",true);
		
	}

	function getAllInstitutions(){
		
		$this->connection->printQueryResults("SELECT * FROM institution",true);
				
	}



/****************************************************************************************************************************************/
//ADDING A SCHOOL TO AN INSTITUTION

	function addSchool( $nom, $institution){

		$this->connection->aQuery("INSERT INTO school (scho_name, scho_inst) VALUES('$nom','$institution')",true,"School Successfully Added","Failed to add school!");
		
	}

	
/****************************************************************************************************************************************/
//GET A LIST OF SCHOOLS IN AN INSTITUTION

	function getSchools($institution){
	
		$this->connection->printQueryresults("SELECT * FROM school WHERE scho_inst='$institution'",true);
		
	}


/****************************************************************************************************************************************/
//ADDING A DEPARTMENT TO A SCHOOL

	function addDepartment( $nom, $school, $institution){

		$this->connection->aQuery("INSERT INTO department (dept_name, dept_school, dept_inst) VALUES ('$nom', '$school', '$institution')",true,"Department Successfully Added","Failed to add department!");
		
	}
	
	
/****************************************************************************************************************************************/
//GET A LIST OF DEPARTMENTS IN A SCHOOL IN A GIVEN INSTITUTION

	function getDepartments( $institution, $school ){

		$this->connection->printQueryResults("SELECT * FROM department WHERE dept_school='$school' AND dept_inst='$institution' ",true);
		
	}
	


/****************************************************************************************************************************************/
//ADDING MAJORS?MINORS OFFERED BY THE DEPARTMENT 

	function addMajor( $nom, $department, $institution){

		$this->connection->aQuery("INSERT INTO majors (majr_name, majr_dept, majr_inst) VALUES ('$nom', '$department', '$institution')",true,"Major Successfully Added","Failed to add major!");
		
	}
	
/****************************************************************************************************************************************/
//GET A LIST OF MAJORS?MINORS OFFERED BY THE DEPARTMENT 

	function getMajors( $department, $institution){

		$this->connection->printQueryResults("SELECT * FROM majors WHERE  majr_dept='$department' AND majr_inst='$institution' ",true);		
		
	}
	
	
/****************************************************************************************************************************************/
//ADDING COURSES TO A MAJOR?MINOR

	function addCourse( $nom, $department, $institution, $course){

		$this->connection->aQuery("INSERT INTO courses (cour_name, cour_dept, cour_inst, cour_code) VALUES ('$nom', '$department', '$institution', '$course')",true,"Course Successfully Added","Failed to add course!");
			
	}

/****************************************************************************************************************************************/
//ADDING STUDENTS WHO PICK COURSES

	function addStudent( $nom, $institution, $major, $minor, $identification, $email, $passkey, $google, $yahoo, $live, $facebook, $linkedin, $twitter, $department, $school, $country){

		$this->connection->aQuery("INSERT INTO students (stud_name, stud_inst, stud_major, stud_minor, stud_identification, stud_email, stud_passkey, stud_google, stud_yahoo, stud_live, stud_facebook, stud_linkedin, stud_twitter, stud_dept, stud_school, stud_country) VALUES ('$nom', '$institution', '$major', '$minor', '$identification', '$email', '$passkey', '$google', '$yahoo', '$live', '$facebook', '$linkedin', '$twitter', '$department', '$school', '$country' )",true,"Student Successfully Added","Failed to add Student!");
		
	}

//UPDATING STUDENT DETAILS

	function updateStudent( $nom, $institution, $major, $minor, $identification, $passkey, $google, $yahoo, $live, $facebook, $linkedin, $twitter, $department, $school, $country){

		$this->connection->aQuery("UPDATE students set stud_name='$nom', stud_inst='$institution', stud_major='$major', stud_minor='$minor',  stud_google='$google', stud_yahoo='$yahoo', stud_live='$live', stud_facebook='$facebook', stud_linkedin='$linkedin', stud_twitter='$twitter', stud_dept='$department', stud_school='$school', stud_country='$country' WHERE stud_identification='$identification' AND stud_passkey='$passkey')",true, "Student  details Successfully Changed","Failed to change Student details!" );
		
	}

	
//FETCH A LIST OF ALL STUDENTS BY MAJOR IN AN INSTITUTION
	function getStudentByMajor($major, $institution){
		
		$this->connection->printQueryResults("SELECT * FROM students WHERE stud_major='$major' AND stud_inst='$institution'",true);
		
	}
	

//FETCH A LIST OF ALL STUDENTS BY DEPARTMENT IN AN INSTITUTION
	function getStudentByDepartment($department, $institution){
		
		$this->connection->printQueryResults("SELECT * FROM students WHERE stud_dept='$department' AND stud_inst='$institution'",true);
		
	}
	

//FETCH A LIST OF ALL STUDENTS BY SCHOOL IN AN INSTITUTION
	function getStudentBySchool($school, $institution){
		
		$this->connection->printQueryResults("SELECT * FROM students WHERE stud_school='$school' AND stud_inst='$institution'",true);
		
	}
	

//FETCH A LIST OF ALL STUDENTS BY INSTITUTION IN A COUNTRY
	function getStudentByInstitution($institution, $country){
		 
		$this->connection->printQueryResults("SELECT * FROM students WHERE stud_inst='$institution' AND stud_country='$country'",true);
		
	}
	

/****************************************************************************************************************************************/
//ADDING THE PROGRESS OF STUDENTS THAT PICK COURSES

	function addProgress( $student, $course, $grade, $aim, $comment, $dates){

		if($grade == ""){$grade = "NG";}if($aim == ""){$aim = "ND";}

		$this->connection->aQuery("INSERT INTO progress (prog_student, prog_course, prog_grade, prog_aim, prog_comment, prog_date) VALUES ('$student', '$course', '$grade', '$aim', '$comment', '$dates')",true,"Progress data Successfully added","Failed to add progress data!");
		
	}

//UPDATING THE STUDENT COURSE PROGRESS

	function updateProgress( $id, $student, $course, $grade, $aim, $comment, $dates){

		$this->connection->aQuery("UPDATE progress SET prog_course='$course', prog_grade='$grade', prog_aim='$aim', prog_comment='$comment', prog_date='$dates' WHERE id='$id' AND prog_student='$student'",true,"Student progress data Successfully updated","Failed to update Student progress data!");
		
	}

/****************************************************************************************************************************************/
//LOGING IN A USER

	function doPasskeyLogin( $identification, $passkey, $loginKey ){
		
		//Check if a user with the given username and password exists
		$this->connection->num_rows("SELECT * FROM students WHERE stud_identification='$identification' AND stud_passkey='$passkey' ",true);
		$numTimes = $_SESSION['num_rows'];
		
		//If the user exists, set the required credentials
		if($numTimes == 1){
			
			$respArray = array( "response" => "SUCCESS", "data" => array("message" => "Successfully Authenticated!", "command" => "localStorage.setItem('identification', '".$identification."'); localStorage.setItem('loginKey', '".$loginKey."'); doBasicLoginAuth();"));
			echo $this->jsoncallback."(".json_encode($respArray).")";
			
		}else{
			
			//Check if the given username exists
			$this->connection->num_rows("SELECT * FROM students WHERE stud_identification='$identification'", true);
			$numTimes = $_SESSION['num_rows'];
			
			//If the username exists,
			if($numTimes == 1){
				
				$respArray = array("response" => "You have entered an incorrect password!", "data" => "");
				//Inform them that the password they provided is wrong
				echo $this->jsoncallback."(".json_encode($respArray).")";
				
			}else{
				
				$respArray = array("response" => "That identification number is not yet registered!", "data" => "");
				//Inform them that that username remains unregistered
				echo $this->jsoncallback."(".json_encode($respArray).")";
				
			}
			
			
		}
		
		
	}



/****************************************************************************************************************************************/
//CHECK IF THE USER TOKEN IS VALID

	function doSecureAuth( $loginKey, $identification ){
	
		if( $loginKey === $identification){
			
			$respArray = array("response"=>"SUCCESS", "data" => array("message" => "AUTHENTICATED", "command" => "") );				
			echo $this->jsoncallback."(".json_encode($respArray).")";
			
		}else{
			
			$respArray = array("response"=>"ERROR", "data" => array("message" => "NO MATCH", "command" => "localStorage.clear(); window.location = 'index.html';") );
			echo $this->jsoncallback."(".json_encode($respArray).")";
			
		}
		
	}

/****************************************************************************************************************************************/
//CUSTOM DEVELOPER TESTING FEATURE
	function quackDev(){
	
		
		
	}
	
	

}

//CREATING AN INSTANCE OF THE CLASS
//$basics = new CMBasics($_REQUEST['callback']);




?>
