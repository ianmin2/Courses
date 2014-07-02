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
