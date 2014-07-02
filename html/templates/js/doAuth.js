$(function(){
	$__result 			= $("#result");
	$__command			= $("#command"); 	
});


	function mapMajor($_course){
		
			$_institution = localStorage.getItem("inst");
			$_major		  = localStorage.getItem("major");
			
				 $.ajax({
				
						url : 'http://localhost/courses/php/CMBasics_proc.php',
						data: { method:"mapMajor", institution:$_institution, major:$_major, course:$_course },
						dataType:'jsonp',
						success: function(mapDat){	
						
							
						
							if(mapDat["response"] == "SUCCESS" ){
								$("#result").html( mapDat['data']['message']);																
							}else if(mapDat["response"] == "ERROR" ){
								$("#result").html( mapDat["data"]["message"]);
							}else{
								$("#result").html(mapDat);	
							}
								
								
						
						}
						
			 });
			
		}




	function noSpace($data){
	
    	return $data.replace(/ /g,"_");
		
	}



	
	//Basic Authentication to ensure that the security key has been set
	function doBasicLoginAuth(){
		
		$__loginKey = localStorage.getItem("loginKey");
		$__identification = localStorage.getItem("identification");
		
		if($__loginKey == null || $__loginKey == "" || $__identification == null || $__identification == ""){
			
			window.location = "do_Login.html";
			
		}else{
			
			window.location = "main_panel.html";
			
		}	
		
	}




	function doSecureAuth(){
		
		$__loginKey = localStorage.getItem("loginKey");
		$__identification = localStorage.getItem("identification");
		
			
		
		 $.ajax({
			 
							url : 'http://localhost/courses/php/CMBasics_proc.php',
							data: { method:'doSecureAuth', loginKey : $__loginKey, identification : $__identification  },
							dataType:'jsonp',
							success: function(lresp){
															
								//If the user's credentials are correct, set a unique identification Key  to authenticate the user.					
								if(lresp["response"] == "SUCCESS"){
										
									$("#result").html( "<script>" + lresp["data"]["command"] );
																								
								}else{
									
									$("#result").html( "<script>" + lresp["data"]["command"] );
									
								}
								
								
						
							}
					
							
					 });	
		
	}




	function makeList($data){
		$_out = "";
		
		for($dat in $data){
		
			$identy = noSpace($data[$dat]['name'] + $data[$dat]['code']);
			
			$_out = $_out + " <tr id='" + $identy +"' > <td class='id'> " + $data[$dat]['id'] + "</td> <td class='code'> " +  $data[$dat]['code'] + "</td>  <td class='name'> " + $data[$dat]['name'] + "</td>  <td id='tick'> <input type='submit' onClick='javascript:mapMajor("+ $data[$dat]['id'] + ")' value='add' ></td></tr> <tr><td colspan='4'><hr></td></tr>";
			
		}
		
		return $_out;
		
		
	}



	function getMyCourses($_course_list){
		
			
		$__done = $_course_list['done'];
		$__undone = $_course_list['undone'];
		
		//console.log($__undone);
		//code , id , name, weight
		
		$d_course = "";
		$u_course = "";
		
		//make a list of the undone courses.
		for($_course in $__undone){
			
			$u_course = $u_course + " <tr id='"+ noSpace($__undone[$_course]['name']) +"'> <td class='c_code'>" + $__undone[$_course]['code'] + "</td> <td class='c_name' >" + $__undone[$_course]['name'] + "</td> <td class='c_weight'>" + $__undone[$_course]['weight'] + "</td> <td class='c_grade'>  <button onClick='javascript:addGrade(" + $__undone[$_course]['id']  + ");' > Edit </button> </td> </tr> ";
			
		}
		
		for($_course in $__done){
			
			$d_course = $d_course + " <tr id='"+ noSpace($__done[$_course]['name']) +"'> <td class='c_code'>" + $__done[$_course]['code'] + "</td> <td class='c_name' >" + $__done[$_course]['name'] + "</td> <td class='c_weight'>" + $__done[$_course]['weight'] + "</td> <td class='c_grade'>  <button onClick='javascript:addGrade(" + $__done[$_course]['id']  + ");' > Edit </button> </td> </tr> ";
			
		}
		
		
		$_results_ = Array();
		$_results_["done"] 		= $d_course;
		$_results_["undone"] 	= $u_course;
		
		return $_results_;
		
		
	}
	
	
	function addGrade($courseId){
		
		/* $.ajax({
			 
							url : 'http://localhost/courses/php/CMBasics_proc.php',
							data: { method:'doSecureAuth', loginKey : $__loginKey, identification : $__identification  },
							dataType:'jsonp',
							success: function(lresp){
								
								
							}
							
		 });
		 */
		
	}
		
		