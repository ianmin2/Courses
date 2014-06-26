function js2php(object){

	var json = "{";

	for(property in object){

		if(typeof(value) == "string"){

			json += '"' + property + '":"' + value + '",';

		}else{
			
			if(!value[0]){ 

				json += '"' + property + '":' + js2php(value) + ',';
			
			}else{

				json += '"' + property + '":[';
				
				for(prop in value){
				
					json += '"' + value[prop] + '",';				

				} 
				
				
				json = json.substr(0, json.length-1) + "],";


			}

		}

	}

	return json.substr(0, json.length-1) + " }";
}


