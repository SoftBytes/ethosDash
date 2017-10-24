<?php
 if (isset($_GET["lang"])){
	 $lang= $_GET["lang"];
 }else{
	$lang= "en";
 }

if(!isset($_GET["id"]) ){
	//let service to handle request with no ID
	$site = new siteService(null, $lang);
}
else $ethos_id= $_GET["id"];


?>

<!doctype html>
<html lang="<?= $lang ?>">
<?php

	require("helpers/langproc.php");
	require("controller/ethosclient.php");
	require("helpers/algos.php");


	$c = new getlangString($lang, "main");
	$pagecontent = $c->getPageContent();
	$pagetitle = $c->getPageTitle();

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
include("inc/summary.php");



?>
</body>
</html>