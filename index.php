<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ethOS Dashboard</title>
</head>
<?php
include("bin/service.php");

$ETHOSID = isset($_GET["id"])?$_GET["id"]:null;
$LANG = isset($_GET["lang"])?$_GET["lang"]:"en";
$SERVICE = new siteService($ETHOSID, $LANG);

?>
<body>
</body>
</html>