<?php
//this file defines site properties, services and statuses
class siteService
{
	
	public $SITE_URL = "localhost:8888/ethosdash/";
	public $SITE_STATUS = "online"; //options: maintenance, redirect
	public $SITE_REDIRECT = FALSE;
	public $SITE_REDIRECT_URL;
	const _VERSION = "0.1 beta";
	public $ETHOS_ID;
	public $SITE_LANG;
	public $DEMO_ETHOS_ID = "000000";
	
	//site status check
	function __construct($ethosid, $lang=NULL){
		
		//force status to a optional parameter $status from above
		if(!is_null($lang)) $this->SITE_LANG = $lang;
		else $this->SITE_LANG = "en";
		
		//perform status check and route user to redirect URL
		if($this->SITE_STATUS  == "maintenance"){
			
			//echo $this->SITE_STATUS;
				$this->routeMaintenance();
		
			// else got to main (summary) page
		}else{
			
			if(is_null($ethosid)){
				
				$this->routeWelcome();
			// else got to main (summary) page	
			}else{
				
				$this->routeDash($ethosid);
				
			}
			
			//
			
		} 
	}
	
	//user's ethosID
	function routeDash($ethosid){
		//if new user or session has no cookies stored
		$this->ETHOS_ID = $ethosid;
		header('Location: http://'.$this->SITE_URL.'main.php?id='.$this->ETHOS_ID.'&lang='.$this->SITE_LANG);
		exit;
	}
	
	function routeWelcome(){
		//if new user or session has no cookies stored
		header('Location: http://'.$this->SITE_URL.'welcome.php?lang='.$this->SITE_LANG);
		exit;
	}
	
	function routeMaintenance(){
		//if new user or session has no cookies stored
		header('Location: http://'.$this->SITE_URL.'maintenance.php?lang='.$this->SITE_LANG);
		exit;
	}
	
}
//if ethosID is not defined use DEMO id
//$ETHOSID = isset($_GET["id"])?$_GET["id"]:null;
//$SITE_LANG = "en";
//$site = new siteService($ETHOSID, $SITE_LANG);
	//echo "Ethos ID: ".$site->ETHOS_ID;

?>