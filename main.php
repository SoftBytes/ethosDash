<?php
 if (isset($_GET["lang"])){
	 $lang= $_GET["lang"];
 }else{
	$lang= "en";
 }
include("bin/service.php");
if(!isset($_GET["id"]) ){
	//let service to handle request with no ID
	$site = new siteService(null, $lang);
}
else $ethos_id= $_GET["id"];


?>

<!doctype html>
<html lang="<?php echo $lang ?>">
<?php
	
	require("helpers/langproc.php");
	require("controller/ethosclient.php");
	require("helpers/algos.php");
	require("view/mainview.php");
	  
	//language controller class
	$c = new getlangString($lang, "main");
	$pagecontent = $c->getPageContent();
	$pagetitle = $c->getPageTitle();
	
	 //ethOS Client API call
	$o = new ethosClient($ethos_id, "summary");
	$url= $o->getURL();
	$o->sendRequest($url); 
	$ethos_response =  $o->response_content;
	$alldata= json_decode($ethos_response, true);
	  
	  
//render html head section
include("inc/head.php");
?>
<body>
<?php
include("inc/topnav.php");

//UI Summary Handler
$s = new summaryBlock();
include("inc/summary.php");
	

	
?>
</body>
</html>