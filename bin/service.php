<?php
//this file defines site properties, services and statuses
class siteService
{
	
	public $_SITE_URL = "localhost:8888/ethosdash/";
	public $_SITE_STATUS = "online"; //options: maintenance, redirect
	public $_SITE_REDIRECT = FALSE;
	public $SITE_REDIRECT_URL;
	const _VERSION = "0.1";
	public $ETHOS_ID;
	public $_SITE_LANG;
	public $DEMO_ETHOS_ID = "000000";
	
	//site status check
	function __construct($ethosid, $status=NULL){
		
		//force status to a optional parameter $status from above
		if(!is_null($status)) $this->_SITE_STATUS = $status;
		
		//perform status check and route user to redirect URL
		if($this->_SITE_STATUS != "online"){
			$this->_SITE_REDIRECT = TRUE;
			$this->_SITE_REDIRECT_URL = $this->_SITE_URL.$this->_SITE_STATUS.".php";
			header('Location: http://'.$this->_SITE_REDIRECT_URL);
			exit;
		
			// else got to main (summary) page
		}else $this->route_panel(is_null($ethosid)?$this->DEMO_ETHOS_ID:$ethosid);
	}
	
	//user's ethosID
	function route_panel($ethosid){
		//if new user or session has no cookies stored
		$this->ETHOS_ID = $ethosid;
		header('Location: http://'.$this->ETHOS_ID.'.ethosdistro.com');
		exit;
	}
	
}
//if ethosID is not defined use DEMO id
$ETHOSID = isset($_GET["id"])?$_GET["id"]:null;
$_SITE_STATUS = "online";
$site = new siteService($ETHOSID, $_SITE_STATUS);
	//echo "Ethos ID: ".$site->ETHOS_ID;

?>