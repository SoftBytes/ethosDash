<?php
//this file defines site properties, services and statuses
//localhost:8888/ethosdash/bin/service.php
class siteService
{
	
	public $SITE_URL = "localhost:8888/ethosdash/";
	public $SITE_STATUS = "maintenance"; //options: maintenance, online
	public $SITE_REDIRECT = FALSE;
	public $SITE_REDIRECT_URL;
	const _VERSION = "0.1 beta";
	public $ETHOS_ID;
	public $SITE_LANG;
	public $DEMO_ETHOS_ID = "000000";
	
	//site status check
	
	function __construct($ethosid, $lang=NULL){
		//perform status check and route user to maintenance page URL
		
		if($this->SITE_STATUS == "maintenance"){
			 
			echo $this->SITE_STATUS;
				//header('Location: http://'.$this->SITE_URL.'maintenance.php?lang='.is_null($lang)?'en':$lang);
				//exit;
		}else
			
			echo "Status is not online!";
			
			/*
			// if no ethOS ID go welcome page with deafule english language
			if(is_null($ethosid)){
				
				header('Location: http://'.$this->SITE_URL.'welcome.php?lang='.is_null($lang)?'en':$lang);
				exit;
			// else got to main (summary) page	
			}else{
				$this->routeDash($ethosid, $lang);
				
			}*/
		}

	//user's ethosID
	function routeDash($ethosid, $lang){
		//if new user or session has no cookies stored
		$this->ETHOS_ID = $ethosid;
		header('Location: http://'.$this->SITE_URL.'main.php?id='.$ethosid.'&lang='.is_null($lang)?'en':$lang);
		exit;
	}
	
}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Service</title>
</head>
	<h3>Service Page</h3>
	
	<?php  
	//if ethosID is not defined use DEMO id
//
$ETHOSID = isset($_GET["id"])?$_GET["id"]:null;
$lang = "en";
$site = new siteService($ETHOSID, $lang);
//echo "Ethos ID: ".$site->ETHOS_ID;
	
	?>

<body>
</body>
</html>