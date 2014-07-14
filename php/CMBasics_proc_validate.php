<?php
class CMBasicsValidation{

	public $id, $nom, $country, $institution, $school, $department, $major, $minor, $student, $identification, $passkey, $email, $google, $yahoo , $live, $facebook, $linkedin, $twitter, $course, $grade, $aim, $comment, $dates, $basics, $jsoncallback , $loginKey;

	private $obsfucate;

	public function __construct($id, $nom, $country, $institution, $school, $department, $major, $minor, $student, $identification, $passkey, $email,  $google, $yahoo , $live, $facebook, $linkedin, $twitter, $course, $grade, $aim, $comment, $dates, $jsoncallback, $loginKey ){

		$this->id				= $id;
		$this->nom 				= $nom;
		$this->country 			= $country;
		$this->institution		= $institution;
		$this->school			= $school;
		$this->department		= $department;
		$this->major			= $major;
		$this->minor 			= $minor;
		$this->identification	= strtoupper($identification);
		$this->passkey 			= $passkey;
		$this->email			= strtolower($email);
		$this->google 			= $google;
		$this->yahoo 			= $yahoo;
		$this->live 			= $live;
		$this->facebook 		= $facebook;
		$this->linkedin 		= $linkedin;
		$this->twitter 			= $twitter;
		$this->course			= $course;
		$this->grade 			= $grade;
		$this->aim 				= $aim;
		$this->comment 			= $comment;
		$this->dates 			= $dates;
		$this->student 			= $student;
		$this->jsoncallback     = $jsoncallback;
		$this->loginKey			= $loginKey;
				
		include "CMBasics.php";
		$this->basics = new CMBasics($jsoncallback);
		
		//INSTANTIATING THE OBSFUCATION CLASS 
		if($passkey != "" | $loginKey != ""){
			
				if(@$this->identification == ""){
					echo $this->jsoncallback."(".json_encode("You need to provide a username in order to gain access to the desired service!").")";
					exit;
				}
			
			$key 	=	"E|es/+r_qtTZd-kEQCDP5(74Z!*,rmD+z`-S ,Wa|zFb&ks21`Wc}f$.MO|4S|F_!".htmlspecialchars($this->identification).".|}KXz=AT_+RrC3$.Hn0}`xUIGqVYgUbIUrS/ylnhh/jAB3-q^a09L|`#^7W9~2VX/";
			$sel 	=	"U__@c(g81P]`+9VL} + CS,!Zrls1^fo%i8b-_+8A#he|%A8|&84.L|urx$.g$.GE";
			
			//The obsfucation object
			$this->obsfucate = new obsfucate($key, $sel);
						
		}
		
		
			
	}
	
	
	//String sanitizer 
	private function sanitize($value){

		$str = str_replace("'","\'",$value);
		return htmlspecialchars($str);	

	}
	
	
	//Institution addition validation
	function addInstitutionValidate(){
		
		if(@$this->nom == "" | @$this->country == ""){
			$respArray = $this->makeResponse("ERROR"," ALL FIELDS ARE REQUIRED! ","");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;	
		}else{
			$this->basics->addInstitution($this->sanitize($this->nom), $this->sanitize($this->country));
		}
		
	}
	
	
	//get a list of institutions in a given country
	function getInstitutionValidate(){
		if($this->country == ""){
			$respArray = $this->makeResponse("ERROR"," ALL FIELDS ARE REQUIRED! ","");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;		
		}else{
			$this->basics->getInstitution($this->country);
		}
	}
	
	
	//get a list of all institutions
	function getAllInstitutionsValidate(){
		if($this->country != ""){
			
			$this->basics->getAllInstitutions();
			
		}
	}
	
	
	//Add an institution to the grading table
	function startGradingValidate(){
		
		if($this->institution != "" || $this->country != ""){
			$this->basics->startGrading($this->sanitize($this->institution), $this->sanitize($this->country)); 
		}else{
			$respArray = $this->makeResponse("ERROR","FAILED TO ACQUIRE INSTITUTION NAME!","");
			echo $this->jsoncallback."(".json_encode($respArray).")";	
		}
		
	}
	
	
	//Set up an institution's grading system
	function setGradingValidate($ap,$a,$am,$bp,$b,$bm,$cp,$c,$cm,$dp,$d,$dm,$e,$f){
		
		if($this->institution != ""){
			$this->basics->setGrading($this->sanitize($this->institution),$this->sanitize($ap),$this->sanitize($a),$this->sanitize($am),$this->sanitize($bp),$this->sanitize($b),$this->sanitize($bm),$this->sanitize($cp),$this->sanitize($c),$this->sanitize($cm),$this->sanitize($dp),$this->sanitize($d),$this->sanitize($dm),$this->sanitize($e),$this->sanitize($f)); 	
		}else{
			$respArray = $this->makeResponse("ERROR","FAILED TO ACQUIRE INSTITUTION NAME!","");
			echo $this->jsoncallback."(".json_encode($respArray).")";	
		}
		
	}
	//Fetch the detailed institutional grading system
	function loadGradesValidate(){
		if($this->institution != ""){
			$this->basics->loadGrades($this->sanitize($this->institution));
		}else{
			echo $this->jsoncallback."(".json_encode($this->makeResponse("ERROR","You need to be loged in to access this service!","")).")";
		}
	}
	
	
	//School addition validation
	function addSchoolValidate(){
		
		if(@$this->nom == "" | @$this->institution == ""){
			$respArray = $this->makeResponse("ERROR"," ALL FIELDS ARE REQUIRED! ","");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			$this->basics->addSchool($this->sanitize($this->nom), $this->sanitize($this->institution));
		}
					
	}
	
	
	//School retreival validation
	function getSchoolsValidate(){
		
		if(@$this->institution == ""){
			$respArray = $this->makeResponse("ERROR"," PLEASE SELECT AN INSTITUTION! ","");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			$this->basics->getSchools($this->sanitize($this->institution));
		}
					
	}
	
	
	//Department addition validation
	function addDepartmentValidate(){
		
		if(@$this->nom == "" |  @$this->school == "" | @$this->institution == ""){
			$respArray = $this->makeResponse("ERROR"," ALL FIELDS ARE REQUIRED! ","");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			$this->basics->addDepartment($this->sanitize($this->nom), $this->sanitize($this->school), $this->sanitize($this->institution));
		}	
		
	}
	
	
	//Department retreival validation
	function getDepartmentsValidate(){
		
		if( @$this->school == "" | @$this->institution == ""){
			$respArray = $this->makeResponse("ERROR"," ALL FIELDS ARE REQUIRED! ","");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			$this->basics->getDepartments( $this->sanitize($this->institution), $this->sanitize($this->school) );
		}	
		
	}
	
	
	//Major addition validation
	function addMajorValidate(){
		
		if(@$this->nom == "" | @$this->department == "" | @$this->institution == ""){
			$respArray = $this->makeResponse("ERROR"," ALL FIELDS ARE REQUIRED! ","");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			$this->basics->addMajor($this->sanitize($this->nom), $this->sanitize($this->department), $this->sanitize($this->institution));
		}	
		
	}
	
	
	//Major retreival validation
	function getMajorsValidate(){
		
		if( @$this->department == "" | @$this->institution == "" ){
			$respArray = $this->makeResponse("ERROR"," ALL FIELDS ARE REQUIRED! ","");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			$this->basics->getMajors( $this->sanitize($this->department), $this->sanitize($this->institution) );
		}	
		
	}
	
	
	//Course addition validation
	function addCourseValidate(){
		
		if(@$this->nom == "" | @$this->department == "" | @$this->institution == "" | @$this->course == "" | @$this->grade == "" ){
			$respArray = $this->makeResponse("ERROR"," ALL FIELDS ARE REQUIRED! ","");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			$this->basics->addCourse($this->sanitize($this->nom), $this->sanitize($this->department), $this->sanitize($this->institution), $this->sanitize($this->course), $this->sanitize($this->grade));
		}	
		
	}
	
	//Institutional course validation
	function getInstCoursesValidate(){
		
		if(@$this->institution == ""){
			$respArray = $this->makeResponse("ERROR"," The Institution is required! ","");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			$this->basics->getInstCourses($this->sanitize($this->institution));
		}
		
	}
	
	
	//Get course by id validate [for progress table updating]
	 function getCourseByIdValidate(){
		 
		if(@$this->id != "" && @$this->identification != ""){
			$this->basics->getCourseById($this->sanitize($this->id), $this->sanitize($this->identification));
		}else{
			$respArray = $this->makeResponse("ERROR", "The Basic Program Blocks seem corrupt. Please Logout then login.", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}	 
		 
	}
	
	
	//Student addition validation
	function addStudentValidate(){
		
		if(@$this->nom == "" | @$this->institution == "" | @$this->major == "" | @$this->identification == "" | @$this->email == "" | @$this->department =="" | @$this->school == "" | @$this->country == "" | (@$this->passkey == ""  && @$this->google == "" && @$this->yahoo == "" && @$this->live == "" && @$this->facebook == "" && @$this->linkedin == "" && @$this->twitter == "" ) ){
			$respArray = $this->makeResponse("ERROR", "Essential fields and a form of identification are required!", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
						
			$this->basics->addStudent($this->sanitize($this->nom), $this->sanitize($this->institution), $this->sanitize($this->major), @$this->sanitize($this->minor), $this->sanitize($this->identification), $this->sanitize($this->email), @$this->obsfucate->makePass($this->sanitize($this->passkey)), @$this->sanitize($this->google), @$this->sanitize($this->yahoo), @$this->sanitize($this->live),  @$this->sanitize($this->facebook),  @$this->sanitize($this->linkedin), @$this->sanitize($this->twitter), @$this->sanitize($this->department), @$this->sanitize($this->school), @$this->sanitize($this->country));
		}	
	
	}
	
	//Student details update validation
	function updateStudentValidate(){
		
		if(@$this->institution == "" | @$this->identification == "" | @$this->passkey == ""){
			$respArray = $this->makeResponse("ERROR", "FAILED TO IDENTIFY USER BASED ON GIVEN CRITERIA!", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			$this->basics->updateStudent($this->sanitize($this->nom), $this->sanitize($this->institution), $this->sanitize($this->major), $this->sanitize($this->minor), $this->sanitize($this->identification), $this->obsfucate->makePass($this->sanitize($this->passkey)), $this->sanitize($this->google), $this->sanitize($this->yahoo), $this->sanitize($this->live), $this->sanitize($this->facebook),  $this->sanitize($this->linkedin), $this->sanitize($this->twitter), @$this->sanitize($this->department), @$this->sanitize($this->school), @$this->sanitize($this->country));
		}
	
	}
	
	
	//Fetch student by Major in Institution validation
	function getStudentByMajorValidate(){
		
		if(@$this->major == "" | @$this->institution == ""){
			$respArray = $this->makeResponse("ERROR", "Both the major and institution are required!", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			
			$this->basics->getStudentByMajor( $this->sanitize($this->major), $this->sanitize($this->institution) );
			
		}
		
	}
	//Fetch student by Department in Institution validation
	function getStudentByDepartmentValidate(){
		
		if(@$this->department == "" | @$this->institution == ""){
			$respArray = $this->makeResponse("ERROR", "Both the department and institution are required!", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			
			$this->basics->getStudentByDepartment( $this->sanitize($this->department), $this->sanitize($this->institution) );
			
		}
		
	}
	//Fetch student by Shoool in Institution validation
	function getStudentBySchoolValidate(){
		
		if(@$this->school == "" | @$this->institution == ""){
			$respArray = $this->makeResponse("ERROR", "Both the school and institution are required!", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			
			$this->basics->getStudentBySchool( $this->sanitize($this->school), $this->sanitize($this->institution) );
			
		}
		
	}
	//Fetch student by Institution in Country validation
	function getStudentByInstitutionValidate(){
		 
		if(@$this->country == "" | @$this->institution == ""){
			$respArray = $this->makeResponse("ERROR", "Both the country and institution are required!", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			
			$this->basics->getStudentByInstitution( $this->sanitize($this->institution), $this->sanitize($this->country) );
			
		}
		
		
	}	


	
	//progress addition validation
	function addProgressValidate(){
		
		if(@$this->student == "" | @$this->course == "" | @$this->grade == "" ){
			$respArray = $this->makeResponse("ERROR", "FAILED TO ADD PROGRESS BASED ON THE GIVEN CRITERIA!", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			$this->basics->addProgress($this->sanitize($this->student), $this->sanitize($this->course), $this->sanitize($this->grade), $this->sanitize($this->aim), $this->sanitize($this->comment), $this->sanitize($this->dates));
		}	
		
	}
	
	
	//Progress update validation
	function updateProgressValidate(){
		
		if(@$this->id == "" | @$this->student == "" | @$this->course == ""){
			$respArray = $this->makeResponse("ERROR", "ALL FIELDS ARE REQUIRED!", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			$this->basics->updateProgress($this->sanitize($this->id), $this->sanitize($this->student), $this->sanitize($this->course), $this->sanitize($this->grade), $this->sanitize($this->aim), $this->sanitize($this->comment));
		}	
		 
	}
	
	
	//Do a quick validation of the user
	function doPasskeyLoginValidate(){
		
		if(@$this->identification == "" | @$this->passkey == ""){	
			$respArray = $this->makeResponse("ERROR", "Your Username and Password are required to complete this task.", "");		
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			
			$this->basics->doPasskeyLogin(@$this->sanitize($this->identification) , @$this->obsfucate->makePass($this->sanitize($this->passkey)), $this->obsfucate->makeKey($this->sanitize($this->identification)) );
			
		}
		
	}
	
	
	//Do a user loginKey validation
	
	function doSecureAuthValidate(){
	
		if(	@$this->loginKey == "" || @$this->identification == ""){
			
			$respArray = $this->makeResponse("ERROR", "You need to login to access this service ", "localStorage.clear(); window.location='index.html'; ");
			
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
			
		}else{
			
			$this->basics->doSecureAuth(@$this->loginKey, @$this->obsfucate->makeKey($this->sanitize( $this->identification )) );
					
		}
		
	}
	
	//Generate a list of all the courses that a user is enrolled to
	function getMyCoursesValidate(){
		
		if(@$this->major != "" && @$this->institution != "" && @$this->id != ""){
			$this->basics->getMyCourses($this->sanitize($this->institution), $this->sanitize($this->major), $this->sanitize($this->id) );
		}else{
			$respArray = $this->makeResponse("ERROR"," The Major and Institution and Id are required! ", "doSecureAuth();");
			
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
			
		}
		
	}
	
	//Map a course to a major
	function mapMajorValidate(){
		
		if(@$this->major != "" && @$this->course != "" && @$this->institution != ""){
			$this->basics->mapMajor($this->sanitize($this->institution), $this->sanitize($this->major), $this->sanitize($this->course));
		}else{
			
			$respArray = $this->makeResponse("ERROR", " The Major, Course and Institution are required! ", "doSecureAuth();");
			
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
			
		}
		
	}
	
	//unmap a course from a major
	function unmapMajorValidate(){
		
		if(@$this->major != "" && @$this->course != "" && @$this->institution != ""){
			$this->basics->unmapMajor($this->sanitize($this->institution), $this->sanitize($this->major), $this->sanitize($this->course));
		}else{
			
			$respArray = $this->makeResponse("ERROR", " The Major, Course and Institution are required! ", "doSecureAuth();");
			
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
			
		}
		
	}
	
	
	//Standardized output array
	private function makeResponse($response, $message, $command){
		
		return array( "response" => $response, "data" => array( "message" => $message, "command" => $command ) );
		
	}
	
	
	//Password Recovery
	function getPasskeyValidate(){
		
		
		
	}
	
	
	//Custom Developer testing feature
	
	function doQuackDev(){
		$this->basics->quackDev();
	}
	
}
?>