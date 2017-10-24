<?php
	class getlangString{
		
		public $pageLang;
		
		public $pageName;
		
		public $pageContent;
		
		public $pageTitle;
		
		const _LANGPATH = "Lang";
		
		function __construct($lang, $page){
			$this->pageLang = $lang;
			$this->pageName = $page;
			$this->pageContent = file_get_contents(self::_LANGPATH."/".$this->pageLang."/".$this->pageName.".json");
			//$this->pageTitle  = self::getPageTitle();
		}
				
		
		function getPageContent(){
			
			$json = json_decode($this->pageContent, true); // decode the JSON into an associative array
			return $json["data"];
			
		}
		
		function getPageTitle(){
			$json = json_decode($this->pageContent, true); // decode the JSON into an associative array
			return $json["data"]["title"];
			
		}
		
	}
?>