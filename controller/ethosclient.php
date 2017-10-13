
	<?php
	class ethosClient 
	{
		public $ethosid;
		public $uri = "ethosdistro.com";
		public $action; //posiible values: summary, graph
		public $worker;
		public $det_type;
		public $error;
		public $error_message;
		public $error_code;
		public $response_content;


		function __construct($ethos_id, $action, $worker = NULL, $type = NULL){
			$this->action = $action;
			$this->ethosid = $ethos_id;
			$this->worker = $worker;
			$this->det_type = $type;		
		}

		function getURL(){
			
			//construct URL for HTTP request, note! Type is require if graphs are called with worker name
			//$request_url = "http://".$this->ethosid.".".$this->uri.(!is_null($this->worker)?"/graphs/?rig=".$this->worker.(!is_null($this->det_type)?"&type=".$this->det_type."&":""):"?")."jason=yes";
			if($this->action == "summary") 
			$request_url = "http://".$this->ethosid.".".$this->uri."?json=yes";
			else $request_url = "http://".$this->ethosid.".".$this->uri."/graphs/?rig=".$this->worker."&type=".$this->det_type."&json=yes";

			return $request_url;

		}
		
		function sendRequest($request_url){
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $request_url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET"
			));
		
			$response = curl_exec($curl);
			$err = curl_error($curl);

			
			$curl_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

			//ideally we need first make a call and see if ethosID is valid, and/or we're not getting errors, but for now I'll omit this part
			if ($err) {
			  
				$this->error = true;
				$this->error_message = "cURL Error #:" . $err;
				$this->error_code = $curl_status_code;
				//echo $this->error_message;
			
			} else {
				
				//if there was no curl error, but reposne is not Status=200 OK
				/*
				if($curl_status_code != 200)
				{
					$JSON_response = json_decode($response, TRUE);
					//check that response has valid JSON content
					if(json_last_error() != JSON_ERROR_NONE)
					{
						$response = stripslashes($response);
						$JSON_response = json_decode($response, TRUE);
					}
					if(json_last_error()) 
					{
						throw new ParseException("Returned JSON format is not proper. Could possibly be version mismatch");
					}
					$error_message = $JSON_response['response']['error']['message'];
					$error_code = $JSON_response['response']['error']['code'];
					throw new ServerException($error_code, $error_message, $this->action, $HTTP_status_code); 
				}
				else{
					
					$JSON_response = json_decode($response, true);
					//check that response has valid JSON content
					if(json_last_error() != JSON_ERROR_NONE)
					{
						$response = stripslashes($response);
						$JSON_response = json_decode($response, TRUE);
					}
					
				}*/
				
				//$JSON_response = json_decode($response, TRUE);
				$this->response_content = $response;
				//return $response;

			}
			

			curl_close($curl);
		}
		
			/**
		* ParseException is thrown if the server has responded but client was not able to parse the response. Possible reasons could be version mismatch.The client might have to be updated to a newer version.
	*/

	}
	class ParseException extends Exception
	{
			/**
				* @var string The error message sent by the server.
			*/
		private $error_message;

			/**
				* @internal Creates a new Parse_Exception instance.
			*/

		function __construct($error_message) 
		{
				$this->error_message = $error_message;
		}

			/**
				* Get the complete response content as sent by the server.
				* @return string The complete response content.
			*/

		function getResponseContent()
		{
				return "Error Message :". $this->error_message;
		}
	}

/**
				*ServerException is thrown if the report server has recieved the request but did not process the request due to some error. 
	*/

	class ServerException extends Exception
	{
		/**
			* @var int The error code sent by the server.
		*/
		private $error_code;
		/**
			* @var string The error message sent by the server.
		*/
		private $error_message;
		/**
			* @var string The action to be performed over the resource specified by the uri.
		*/
		private $action;
		/**
			* @var int The http status code for the request.
		*/
		private $curl_status_code;
		
		/**
			* @internal Creates a new Server_Exception instance.
		*/
		
		function __construct($error_code, $error_message, $action, $curl_status_code) 
		{
	       	$this->error_code = $error_code;
	        $this->error_message = $error_message;
	        $this->action = $action;
	        $this->HTTP_status_code = $curl_status_code;
		}
		
		/**
			* Get the error message sent by the server.
			* @return string The error message.
		*/
		
		function getErrorMessage()
		{
			return $this->error_message;
		}
		
		/**
			* Get the error code sent by the server.
			* @return int The error code.
		*/
		
		function getErrorCode()
		{
			return $this->error_code;
		}
		
		/**
			* Get The action to be performed over the resource specified by the uri.
			* @return string The action.
		*/
		
		function getAction()
		{
			return $this->action;
		}
		
		/**
			* Get the http status code for the request.
			* @return int The http status code.
		*/
		
		function getHTTPStatusCode()
		{
			return $this->HTTP_status_code;
		}
		
		/**
			* Get the complete response content as sent by the server. 
			* @return string The complete response content.
		*/
		
		function toString()
    	{
    		$str1 = "HttpStatusCode: $this->HTTP_status_code Error Code: $this->error_code";
    		$str2 = "Action: $this->action Error Message: $this->error_message";
        	return "ServerException ( ".$str1." ".$str2." )";
    	}
	}
?>