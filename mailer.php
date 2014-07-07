<?php
/*
	* Author: Ian Innocent 
	* For: The Connection
*/
@session_start();
class mailer{
	
	public $id 			= "mailer.php";
	public $from ;		
	public $reply_to;
	public $selfname;
	
		
	public $headers;		public $message;			public $image_url; 
	public $to;				public $subject;			public $content;
	public $to_name;		public $action;				public $csslink; 
	public $messageT;		public $jsoncallback;
	
	public function __construct($to_name ,$to_email, $subject, $message_content, $from, $reply_to, $action, $jsoncallback){
		
		$this->jsoncallback = $jsoncallback;
		
		if(@$to_email != '' && @$subject != '' && @$message_content != ''){
			
			$this->to 			= strip_tags( $to_email);
			
			$this->to_name		= $to_name;
			
			$this->subject 		= $subject;
			
			$this->content		= $message_content;
			
			$this->from 		= @$from;
			
			$this->reply_to  	= @$reply_to;
			
			$this->action		= $action;
			
			$this->selfname		= $subject;
			
			$random_hash = md5(date('r', time())); 
			
			//define the headers we want passed. Note that they are separated with \r\n
			$this->headers = "From: strip_tags($this->from)\r\nReply-To: strip_tags($this->reply_to)";
			//add boundary string and mime type specification
			$this->headers .= "\r\nContent-Type:  application/json; boundary=\"PHP-alt-".$random_hash."\""; 
			
			/*
			//Email body
			$this->message = "<html><body><link rel='stylesheet' href='".$this->csslink."'>";
			//Custom header image
			//$this->message .= "<img src="'.@$this->image_url.'" alt="The_Connection Mailer Descriptive Image!" />';
			$this->message .= "<table rules='all' style='border-color: #666;' cellpadding='10'>";
			$this->message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" .@$this->to_name. "</td></tr>";
			$this->message .= "<tr><td><strong>Email:</strong> </td><td>" .@$this->to. "</td></tr>";
			$this->message .= "<tr><td><strong>Message Type:</strong> </td><td>" .@$this->subject. "</td></tr>";
			$this->message .= "<tr><td><strong>Details:</strong> </td><td>" .@$this->content. "</td></tr>";
			$this->message .= "</table>";
			$this->message .= "</body></html>";
			*/
				
		


		
			
			$this->message = "";
			//Custom header image
			$this->message .= "<!DOCTYPE HTML><html><meta lang='en' charset='utf-8' >head></head><body>";
			$this->message .= "Name: " .@$this->to_name. "<br />";
			$this->message .= "Email: " .@$this->to. "<br />";
			$this->message .= "Concerning: " .@$this->subject. "<br />";
			$this->message .= "Details: <br/>" .@$this->content. "<br />";
			$this->message .= "<br />";
			$this->message .= "</body></html>";
			
			
			
			$this->messageT = "";
			//Custom header image
			$this->messageT .= "\n\r";
			$this->messageT .= "Name: " .@$this->to_name. "\n\r";
			$this->messageT .= "Email: " .@$this->to. "\n\r";
			$this->messageT .= "Message Type: " .@$this->subject. "\n\r";
			$this->messageT .= "Details: " .@$this->content. "\n\r";
			$this->messageT .= "\n\r";
			//$this->message .= "\n\r ";
			
			
$this->message = <<<IARA_MAILER


IARA_MAILER;

			
			if($this->action == 'sendmail'){
				$this->sendmail();
			}
			
			/*
			//Worth considering / [debateable]
			//check for the actions that may exist 
			//send email [sendmail]
			//verify registration [verify]
			//recover lost password [recovery]
			*/
					 
		}else{
			$respArray = makeResponse("ERROR", "ERROR: Failed to Initialize Mailer! ", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}
		
	}
	
	
	
	
	private function sendmail(){
		/*
		if(mail($this->to, $this->subject, $this->messageT, $this->headers)){
			$_SESSION['mailed'] = true;
		}else{
			$_SESSION['mailed'] = false;
		}
		*/
		
		@$this->truemail();
	}
	

	private function truemail(){
		
		$uri = 'https://mandrillapp.com/api/1.0/messages/send.json';
				
		$postString = '{
		"key": "C2JgjLf0pN0os9FMvJrc7Q",
		"message": {
			"html":  '.@json_encode($this->message).',
			"text": '.@json_encode($this->messageT).',
			"subject": '.@json_encode($this->subject).',
			"from_email": '.@json_encode($this->from).',
			"from_name": "UEAB| RoomReservation",
			"to": [
				{
					"email": '.@json_encode($this->to).',
					"name": '.@json_encode($this->to_name).'
				}
			],
			"headers": {
				
			},
			"track_opens": true,
			"track_clicks": true,
			"auto_text": true,
			"url_strip_qs": true,
			"preserve_recipients": true,
		
			"merge": true,
			"global_merge_vars": [
		
			],
			"merge_vars": [
		
			],
			"tags": [
		
			],
			"google_analytics_domains": [
		
			],
			"google_analytics_campaign": "...",
			"metadata": [
		
			],
			"recipient_metadata": [
		
			],
			"attachments": [
		
			]
		},
		"async": false
		}';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $uri);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		
		//$result = curl_exec($ch);
		//echo $result;
		if(curl_exec($ch)){
			$respArray = makeResponse("SUCCESS", "Message Sent", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}else{
			$respArray = makeResponse("ERROR", "Error: Failed to sending message!", "");
			echo $this->jsoncallback."(".json_encode($respArray).")";
			exit;
		}
				
	}

	//THE SIMPLE RESPONSE STANDARDING FUNCTION
	function makeResponse($response, $message, $command){
		
		return array( "response" => $response, "data" => array( "message" => $message, "command" => $command ) );
		
	}
		
		
		
//End of class		
}


?>		



