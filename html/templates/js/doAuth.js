$(function(){
	$__result 			= $("#result");
	$__command			= $("#command"); 
	//$("head").append("<link rel='stylesheet' href='style/style.css' >");	
});


	function mapMajor($_course){
		
			$_institution = localStorage.getItem("inst");
			$_major		  = localStorage.getItem("major");
			
				 $.ajax({
				
						url : 'http://localhost/courses/php/CMBasics_proc.php',
						data: { method:"mapMajor", institution:$_institution, major:$_major, course:$_course },
						dataType:'jsonp',
						success: function(resp){
						
							if(resp["response"] == "SUCCESS" ){
								$__result.html(resp['data']['message']);
								$__command.html("<script>" + resp['data']['command'] + "</script>");																
							}else if(resp["response"] == "ERROR" ){
								$__result.html(resp["data"]["message"]);
								$__command.html("<script>" + resp['data']['command'] + "</script>");
							}else{
								$__result.html("UNDEFINED RESPONSE MESSAGE.");
							}
							
						
						}
						
			 });
			
		}
		
		
		
		
		function unmapMajor($_course){
		
			$_institution = localStorage.getItem("inst");
			$_major		  = localStorage.getItem("major");
			
				 $.ajax({
				
						url : 'http://localhost/courses/php/CMBasics_proc.php',
						data: { method:"unmapMajor", institution:$_institution, major:$_major, course:$_course },
						dataType:'jsonp',
						success: function(resp){
						
							if(resp["response"] == "SUCCESS" ){
								$__result.html(resp['data']['message']);
								$__command.html("<script>" + resp['data']['command'] + "</script>");																
							}else if(resp["response"] == "ERROR" ){
								$__result.html(resp["data"]["message"]);
								$__command.html("<script>" + resp['data']['command'] + "</script>");
							}else{
								$__result.html("UNDEFINED RESPONSE MESSAGE.");
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
					success: function(resp){
													
						//If the user's credentials are correct, set a unique identification Key  to authenticate the user.					
						if(resp["response"] == "SUCCESS"){
								
							$__command.html( "<script>" + resp["data"]["command"] + "</script>" );
																						
						}else{
							
							$__command.html( "<script>" + resp["data"]["command"] + "</script>" );
							
						}
						
						
						
					}
			
							
			});	
		
	}




	function makeList($data){
		$_out = "";
		
		for($dat in $data){
		
			$identy = noSpace($data[$dat]['name'] + $data[$dat]['code']);
			
			$_out = $_out + " <tr id='" + $identy +"' > <td class='id'> " + $data[$dat]['id'] + "</td> <td class='code'> " +  $data[$dat]['code'] + "</td>  <td class='name'> " + $data[$dat]['name'] + "</td>  <td id='tick'> <input type='submit' onClick='javascript:mapMajor("+ $data[$dat]['id'] + ")' value='+' > <input type='submit' onClick='javascript:unmapMajor("+ $data[$dat]['id'] + ")' value='-' ></td></tr> <tr><td colspan='4'><hr></td></tr>";
			
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
			$u_course = $u_course + " <tr id='"+ noSpace($__undone[$_course]['name']) +"'> <td class='c_code'>" + $__undone[$_course]['code'] + "</td> <td class='c_name' >" + $__undone[$_course]['name'] + "</td> <td class='c_weight'>" + $__undone[$_course]['weight'] + "</td> <td class='c_grade'>  <button onClick='javascript:updateProgress(" + $__undone[$_course]['id']  + ");' > Edit </button> </td> </tr> ";
			
		}
		
		for($_course in $__done){
			
			$prep_arr = Array();
			$prep_arr['command'] = "window.localStorage.setItem('curr_course', "+   $__done[$_course]['name'] + " );";
			
			$d_course = $d_course + " <tr id='"+ noSpace($__done[$_course]['name']) +"'> <td class='c_code'>" + $__done[$_course]['code'] + "</td> <td class='c_name' >" + $__done[$_course]['name'] + "</td> <td class='c_weight'>" + $__done[$_course]['weight'] + "</td> <td class='c_grade'>  <button onClick=' updateProgress(" + $__done[$_course]['id']  + ");' > Edit </button> </td> </tr> ";
			
		}
		
		
		$_results_ = Array();
		$_results_["done"] 		= $d_course;
		$_results_["undone"] 	= $u_course;
		
		return $_results_;
		//console.log($_results_)
		
		
	}
	
	
	function updateProgress($courseId){
		
		$.ajax({
			 
							url : 'http://localhost/courses/php/CMBasics_proc.php',
							data: { method:'getCourseById', id : $courseId , identification :localStorage.getItem('id') },
							dataType:'jsonp',
							success: function(resp){
								console.log(resp)
								if(resp["response"] == "SUCCESS"){
									
									$__result.html('');
									$('body').html('<div id="cours_data"> <div id="c_grade"></div> <br><br> <div id="c_aim"></div> <br><br> <div id="c_comment"></div> <div id="btn"></div></div>');
									
									//alert(resp['data']['message'][0]['prog_grade']);
									
									/*
									if(resp['data']['message'][0]['prog_grade'] == "" || resp['data']['message'][0]['prog_grade'] == 0){
										$gVal = "ENTER A GRADE "
									}else{
										 $gVal = resp['data']['message'][0]['prog_grade'];
									}
									*/
									$c_id 		= resp['data']['message'][0]['id']
									$c_grade 	= resp['data']['message'][0]['prog_grade']
									$c_aim		= resp['data']['message'][0]['prog_aim']
									$c_comment 	= resp['data']['message'][0]['prog_comment']
									
									
									$grade 		= '<input id="grade" value="'+ $c_grade +'" placeholder=" ACTUAL GRADE "> ';
									$aim		= '<input id="aim" value="' + $c_aim + '" placeholder= "EXPECTED GRADE" >';
									$comment 	= '<textarea id="comment" maxlength="50"> ' + $c_comment + ' </textarea>';
									
									$btn 		= '<button id="update"> UPDATE </button>';
									
									$("#c_grade").html($grade);
									$("#c_aim").html($aim);
									$("#c_comment").html($comment);
									$("#btn").html($btn);
									
																		
									$("#update").click(function(e) {
                                        
										$.ajax({
											url : 'http://localhost/courses/php/CMBasics_proc.php',
											data: { method:'updateProgress', id : $c_id , student:localStorage.getItem('id'), course:$courseId, grade: $("#grade").val(), aim: $("#aim").val(), comment: $("#comment").val()  },
											dataType:'jsonp',
											success: function(resp){
												
												alert(resp['data']['message']);
												
											}
										});
										
                                    });
									
									
									
									//console.log(resp['data']['message']);
									
									
									
								}else if(resp["response"] == "ERROR"){
									$__result.html(resp['data']['message']);
									$__command.html("<script>" + resp['data']['command'] + "</script>");
								}else{
									$__result.html("UNDEFINED RESPONSE MESSAGE.");
								}
								
							}
							
		 });
		 
		
	}
		
		