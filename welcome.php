<!doctype html>
<?php
 if (isset($_GET["lang"])){
	 $lang= $_GET["lang"];
 }else{
	$lang= "en";
 } 
?>
<html lang="<?php echo $lang ?>">
<?php
	require("helpers/langproc.php");
	require("bin/service.php");
	
	$pagelang = new getlangString($lang, "welcome");
	$pagecontent = $pagelang->getPageContent();
	$pagetitle = $pagelang->getPageTitle();
	
	
	  
//render html head section
include("inc/head.php");
?>
<body>
<?php
	
include("inc/topnav.php");
include("inc/intro.php");
include("inc/login.php");
include("inc/footer.php");

?>
</body>
</html>