<?php
 if (isset($_GET["lang"])){
	 $lang= $_GET["lang"];
 }else{
	$lang= "en";
 } 
	
require("controller/ethosclient.php");
require("helpers/langproc.php");
//require("controller/ethosclient.php");
	
	$c = new getlangString($lang, "welcome");
	$pagecontent = $c->getPageContent();
	$pagetitle = $c->getPageTitle();
?>

<html lang="<?php echo $lang ?>">
<head>
	<title><?php echo $pagetitle ?></title>
</head>
<body>
<?php
	
	//echo '<pre>' . print_r($pagecontent, true) . '</pre>';
	echo "<h4>".$pagecontent["str1"]."</h4>";
	
	
	
 
	$o = new ethosClient("fd99b1", "summary");
	$url= $o->getURL();
	echo $url."<br/>";
	
	
	echo $o->error_message;
	
	$o->sendRequest($url); 
	$ethos_response =  $o->response_content;
	
	
	if($o->error ) echo $o->error_message;
	else echo $o->error_code;
	/**/
	
	$alldata= json_decode($ethos_response, true);
	
	    	//summary - per_info
		$summary = $alldata['per_info'];
		foreach($summary as $algo_miner=>$sum_info){
		?>
		<div>
		<h3><?php echo $algo_miner ?> </h3>
			<h5>Total Hash: <?php echo $sum_info["hash"]." ".($algo_miner=='claymore'?'MH/s':'Sol/s'); ?></h5>
			<h5>Total Rigs: <?php echo $sum_info["per_total_rigs"]; ?></h5>
			<h5>Offline: <?php echo $sum_info["per_total_rigs"]-$sum_info["per_alive_rigs"]; ?></h5>
			<h5>GPUs: <?php echo $sum_info["per_alive_gpus"]."/".$sum_info["per_total_gpus"]; ?></h5>
			<span>Checked at: <?php echo date('H:i d/m', $sum_info["current_time"]); ?></span>
	    </div>
	    
		<?php 
		}
	//f1810f
	//$g = new ethosClient("fd99b1","graph","f1810f","temp");
	//echo $g->getURL()."<br/>";
	
	//if($g->error) echo $g->error;
	//else 
	
?>

</body>
</html>