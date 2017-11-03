
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
		public $curl_status_code;
		public $json_error;


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

			
			$this->curl_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

			//ideally we need first make a call and see if ethosID is valid, and/or we're not getting errors, but for now I'll omit this part
			if ($err) {
			  
				$this->error = true;
				$this->error_message = "cURL Error #:" . $err;
					
				//echo $this->error_message;
			
			} else {
				
				//if there was no curl error, but reposne is not Status=200 OK
				
				if($this->curl_status_code != 200)
				{
					$JSON_response = json_decode($response, TRUE);
					//check that response has valid JSON content
					$this->error = true;
					$this->error_message = $JSON_response['response']['error']['message'];
					$this->error_code = $JSON_response['response']['error']['code'];
				
				}
				else{
					
					$JSON_response = json_decode($response, true);
					//check that response has valid JSON content
					if(json_last_error() != "JSON_ERROR_NONE")
					{
						$this->json_error= json_last_error();
					}
					
				}
				
				//$JSON_response = json_decode($response, TRUE);
				$this->response_content = $JSON_response;
				//return $response;

			}
			

			curl_close($curl);
		}
		

	}
	
?>