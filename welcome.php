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
	
	$page = new getlangString($lang, "welcome");
	$pagecontent = $page->getPageContent();
	$pagetitle = $page->getPageTitle();
	  
	  
//render html head section
include("inc/head.php");
?>
<body>
<?php
	
include("inc/topnav.php");
include("inc/intro.php");
include("inc/login.php");

?>
</body>
</html>