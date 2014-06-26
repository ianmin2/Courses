<?php

/*
	A packaged all in one approach to the solutions
*/

chdir("../");

class CMBasics{

	public $connection;
	
	public function __construct(){
		
		$id = "responses.php";
		$connect = true;
		
		include "main.php";
		$this->connection = $connection;

	}

/****************************************************************************************************************************************/
//ADDING A NEW INSTITUTION

	function addInstitution($name, $country){

		$this->connection->query("INSERT INTO institution (inst_name, inst_country) VALUES ('$name','$country')", true);
		if($_SESSION['query']){
			return "Institution Successfully Added";
		}else{
			return "Failed to add institution!";		
		}	

	}

/****************************************************************************************************************************************/
//ADDING A SCHOOL TO AN INSTITUTION

	function addSchool($name, $institution){

		$this->connection->query("INSERT INTO school (scho_name, scho_inst) VALUES('$name','$institution')",true);
		if($_SESSION['query']){
			return "School Successfully Added";
		}else{
			return "Failed to add school!";		
		}	

	}

}

/****************************************************************************************************************************************/
//ADDING A DEPARTMENT TO A SCHOOL

	function addDepartment($name, $school, $institution){

		$this->connection->query("INSERT INTO department (dept_name, dept_school, dept_inst) VALUES ('$name', '$school', '$institution')",true);
		if($_SESSION['query']){
			return "Department Successfully Added";
		}else{
			return "Failed to add department!";		
		}

	}


/****************************************************************************************************************************************/
//ADDING MAJORS?MINORS OFFERED BY THE DEPARTMENT

	function addMajor($name, $department, $institution){

		$this->connection->query("INSERT INTO majors (majr_name, majr_dept, majr_inst) VALUES ('$name', '$department', '$institution')",true);
		if($_SESSION['query']){
			return "Major Successfully Added";
		}else{
			return "Failed to add major!";		
		}

	}

/****************************************************************************************************************************************/
//ADDING COURSES TO A MAJOR?MINOR

	function addCourse($name, $major, $institution){

		$this->connection->query("INSERT INTO courses (cour_name, cour_major, cour_inst) VALUES ('$name', '$major', '$institution',)",true);
		if($_SESSION['query']){
			return "Course Successfully Added";
		}else{
			return "Failed to add course!";		
		}	
	
	}

/****************************************************************************************************************************************/
//ADDING STUDENTS WHO PICK COURSES

	function addStudent($name, $institution, $major, $minor, $identification, $passkey, $google, $yahoo, $live, $facebook, $linkedin, $twitter){

		$this->connection->query("INSERT INTO students (stud_name, stud_inst, stud_major, stud_minor, stud_identification, stud_passkey, stud_google, stud_yahoo, stud_live, stud_facebook, stud_linkedin, stud_twitter) VALUES ('$name', '$institution', '$major', '$minor', '$identification', '$passkey', '$google', '$yahoo', '$live', '$facebook', '$linkedin', '$twitter' )",true);
		if($_SESSION['query']){
			return "Student Successfully Added";
		}else{
			return "Failed to add Student!";		
		}	

	}

//UPDATING STUDENT DETAILS

	function updateStudent($name, $institution, $major, $minor, $identification, $passkey, $google, $yahoo, $live, $facebook, $linkedin, $twitter){

		$this->connection->query("UPDATE students set stud_name='$name', stud_inst='$institution', stud_major='$major', stud_minor='$minor', stud_passkey='$passkey', stud_google='$google', stud_yahoo='$yahoo', stud_live='$live', stud_facebook='$facebook', stud_linkedin='$linkedin', stud_twitter='$twitter' WHERE stud_identification='$identification')",true);
		if($_SESSION['query']){
			return "Student  details Successfully Changed";
		}else{
			return "Failed to change Student details!";		
		}		

	}
	

/****************************************************************************************************************************************/
//ADDING THE PROGRESS OF STUDENTS THAT PICK COURSES

	function addProgress($student, $course, $grade, $aim, $comment, $date){

		if($grade == ""){$grade = "NG";}if($aim == ""){$aim = "ND";}

		$this->connection->query("INSERT INTO progress (prog_student, prog_course, prog_grade, prog_aim, prog_comment, prog_date) VALUES ('$student', '$course', '$grade', '$aim', '$comment', '$date')",true);
		if($_SESSION['query']){
			return "Student progress data Successfully added";
		}else{
			return "Failed to add Student progress data!";		
		}

	}

//UPDATING THE STUDENT COURSE PROGRESS

	function updateProgress($id, $student, $course, $grade, $aim, $comment, $dates){

		$this->connection->query("UPDATE progress SET prog_course='$course', prog_grade='$grade', prog_aim='$aim', prog_comment='$comment', prog_date='$dates' WHERE id='$id' AND prog_student='$student'",true);
		if($_SESSION['query']){
			return "Student progress data Successfully updated";
		}else{
			return "Failed to update Student progress data!";		
		}	

	}



/****************************************************************************************************************************************/
//CREATING AN INSTANCE OF THE CLASS

$basics = new CMBasics();



?>
