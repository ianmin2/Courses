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

//GET A LIST OF COURSES OFFERED BY AN INSTITUTION

	function getInstCourses( $institution ){

		$this->connection->query("SELECT * FROM courses WHERE cour_inst='$institution' ",true );
		$course_list = $_SESSION['query'];
		
		$courses = array();
		$course = array();
		
		while($cour_data = mysqli_fetch_array($course_list)){
			$course['id'] = $cour_data['id']; 
			$course['code'] = $cour_data['cour_code'];
			$course['name'] = $cour_data['cour_name'];
			$courses[] = $course;
		}
		
		if(count($courses) > 0){
			$respArray = $this->makeResponse("SUCCESS", "Course List successfully generated",  $courses );
			echo $this->jsoncallback."(".json_encode($respArray).")";
		}else{
			$respArray = $this->makeResponse("ERROR","There are no courses currently associated with your institution", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
		}
			
	}
	
	
	//GET A LIST OF COURSES PRESCRIBED FOR A MAJOR
	
	function getMyCourses($institution, $major, $id){
		
		$this->connection->query("SELECT * FROM merger WHERE merg_inst='$institution' AND merg_maj='$major'",true);
		$outline = $_SESSION['query'];
		
		$courses = array();
		while($data = mysqli_fetch_array($outline)){
			$courses[] = $data['merg_course'];
		}
		
		$new_courses_arr = array();
		$old_courses_arr = array();
		
		foreach($courses as $course){
			
			$this->connection->query("SELECT * FROM courses WHERE id='$course'",true);
			$course_info = $_SESSION['query'];
			
			while($dat = mysqli_fetch_array($course_info)){
				$cData['id'] 		=  $dat['id'];
				$cData['name'] 		=  $dat['cour_name'];
				$cData['code'] 		=  $dat['cour_code'];
				$cData['weight'] 	=  $dat['cour_weight'];
			}
			
			//$course_arr[] =  $cData;
			//DANGER ZONE!
			$this->connection->num_rows("SELECT * FROM progress WHERE prog_course='$cData[id]' AND prog_student='$id' AND prog_grade<>'' ", true);
			$is_excempt = $_SESSION['num_rows'];
			
			if($is_excempt == 1){
				$old_courses_arr[] = $cData;
			}else{
				$new_courses_arr[] =  $cData;
			}
			
								
		}
		
		$course_arr = array("done" => $old_courses_arr, "undone" => $new_courses_arr);
		
		$respArray = $this->makeResponse("SUCCESS", "" , $course_arr);
		echo $this->jsoncallback."(".json_encode($respArray).")";	
		
		
		
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
			
			$this->connection->query("SELECT * FROM students WHERE stud_identification='$identification' AND stud_passkey='$passkey' ",true);
			$details = $_SESSION['query'];
			
			while($detail = mysqli_fetch_array($details)){
			
				$command['id'] 			= "localStorage.setItem('id', '".$detail['id']."');"; 
				$command['inst'] 		= "localStorage.setItem('inst', '".$detail['stud_inst']."');";  
				$command['name'] 		= "localStorage.setItem('name', '".$detail['stud_name']."');"; 
				$command['major'] 		= "localStorage.setItem('major', '".$detail['stud_major']."');";  
				$command['minor'] 		= "localStorage.setItem('minor', '".$detail['stud_minor']."');"; 
				$command['dept'] 		= "localStorage.setItem('dept', '".$detail['stud_dept']."');";  
				$command['school'] 		= "localStorage.setItem('school', '".$detail['stud_school']."');"; 
				$command['country'] 	= "localStorage.setItem('country', '".$detail['stud_country']."');"; 
				$command['loginKey']	= "localStorage.setItem('loginKey', '".$loginKey."');";
				$command['identification']	= "localStorage.setItem('identification', '".$identification."');";
				$command['authenticate']	= "doBasicLoginAuth();";
			}
			
			
			
			//$respArray = $this->makeResponse("SUCCESS", "Successfully Authenticated!", "localStorage.setItem('identification', '".$identification."'); localStorage.setItem('loginKey', '".$loginKey."'); doBasicLoginAuth();");
			$respArray = $this->makeResponse("SUCCESS", "Successfully Authenticated!", $command);
			echo $this->jsoncallback."(".json_encode($respArray).")";
			
		}else{
			
			//Check if the given username exists
			$this->connection->num_rows("SELECT * FROM students WHERE stud_identification='$identification'", true);
			$numTimes = $_SESSION['num_rows'];
			
			//If the username exists,
			if($numTimes == 1){
				
				$respArray = $this->makeResponse( "ERROR", "You have entered an incorrect password!", "data");
				//Inform them that the password they provided is wrong
				echo $this->jsoncallback."(".json_encode($respArray).")";
				
			}else{
				
				$respArray = $this->makeResponse( "ERROR", "That identification number is not yet registered!", "data");
				//Inform them that that username remains unregistered
				echo $this->jsoncallback."(".json_encode($respArray).")";
				
			}
			
			
		}
		
		
	}



/****************************************************************************************************************************************/
//CHECK IF THE USER TOKEN IS VALID

	function doSecureAuth( $loginKey, $identification ){
	
		if( $loginKey === $identification){
			
			$respArray = $this->makeResponse( "SUCCESS" , "AUTHENTICATED" , "" );				
			echo $this->jsoncallback."(".json_encode($respArray).")";
			
		}else{
			
			$respArray = $this->makeResponse( "ERROR" , "NO MATCH" , "localStorage.clear(); window.location = 'index.html';");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			
		}
		
	}


/****************************************************************************************************************************************/
//MAKING THE RESPONSE ARRAY

	private function makeResponse($response, $message, $command){
		
		return array( "response" => $response, "data" => array( "message" => $message, "command" => $command ) );
		
	}


/****************************************************************************************************************************************/
//CUSTOM DEVELOPER TESTING FEATURE
	function quackDev(){
	
		
		
	}


/****************************************************************************************************************************************/
//Map A major to a course	
	function mapMajor( $institution, $major, $course ){
		
		$this->connection->query("INSERT INTO merger ( merg_inst, merg_maj, merg_course ) VALUES ( '$institution', '$major', '$course' )", true);
		$result = $_SESSION['query'];
		
		if($result){
			$respArray = $this->makeResponse("SUCCESS"," Course Successfully added! "," ");
			echo $this->jsoncallback."(".json_encode($respArray).")";
		}else{
			$respArray = $this->makeResponse("ERROR"," Failed to add course! "," ");
			echo $this->jsoncallback."(".json_encode($respArray).")";
		}
	}

}

//CREATING AN INSTANCE OF THE CLASS
//$basics = new CMBasics($_REQUEST['callback']);




?>
