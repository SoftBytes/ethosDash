
	<?php
	class ethosClient 
	{
		public $ethosid;
		public $uri = "ethosdistro.com";
		public $worker;
		public $det_type;

		function __construct($ethos_id, $worker = NULL, $type = NULL){
			$this->ethosid = $ethos_id;
			$this->worker = $worker;
			$this->det_type = $type;		
		}

		function getURL(){

			$request_url = "http://".$this->ethosid.".".$this->uri.(!is_null($this->worker)?"/graphs/?rig=".$this->worker.(!is_null($this->det_type)?"&type=".$this->det_type."&":""):"?")."jason=yes";

			return $request_url;

		}


	}

	?>