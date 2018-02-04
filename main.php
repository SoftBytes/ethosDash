<?php

session_start();



 if (isset($_GET["lang"])){
  	$_SESSION["lang"] = $_GET["lang"];
	 $lang = $_SESSION["lang"];
 }else{
	$lang= "en";
 }



include("bin/service.php");
if(!isset($_GET["id"]) ){

	//let service to handle request with no ID
	$site = new siteService(null, $lang);
}
else {
	$_SESSION["id"] = $_GET["id"];
	$ethos_id= $_SESSION["id"];
}


?>

<!doctype html>
<html lang="<?php echo $lang ?>">
<?php

	require("helpers/langproc.php");
	require("controller/ethosclient.php");
	require("helpers/algos.php");
	require("view/mainview.php");
	require("helpers/datetimezone.php");
	//include controller file for analysing rigs/gpus
	require("controller/datalyser.php");
	// require whattomine connector and calculator
	require("model/wtm-client.php");
	require("controller/profcalc.php");

	//fetch language specific menu and topnav content
	$topnavlang = new getlangString($lang, "topnav");
	$topnavcontent = $topnavlang->getPageContent();

	 //fetch langugae specific page content
	$c = new getlangString($lang, "main");
	$pagecontent = $c->getPageContent();
	$pagetitle = $c->getPageTitle();

	include("inc/head.php");

	 //ethOS Client API call
	$o = new ethosClient($ethos_id, "summary");
	$url= $o->getURL();
	$o->sendRequest($url);
	$ethos_response =  $o->response_content;




	//$alldata= json_decode($ethos_response, true);


//render html head section

?>
<body>
<?php
include("inc/topnav.php");

// echo "<p style='color:red'>HELLO!<p>";

	if(!$o->json_error && is_array($ethos_response)){

		$alldata= $ethos_response;
		//UI Summary Handler
		//$s = new summaryBlock();
		$s = new summaryBlock();
		$stats = new analyseJSON();
		include("inc/summary.php");
		include("inc/rigslist.php");

	}else{
		include("inc/locked_api.php");
	}


?>

</body>
</html>