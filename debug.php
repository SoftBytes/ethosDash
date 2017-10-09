<html>
<head>
	<title>Debug file</title>
</head>
<body>
<?php
require("controller/ethosclient.php");
 
	$o = new ethosClient("fd99b1");
	echo $o->getURL()."<br/>";
	
	//f1810f
	$g = new ethosClient("fd99b1","f1810f","temp");
	echo $g->getURL()."<br/>";
	
?>
</body>
</html>