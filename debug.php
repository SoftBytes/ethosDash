<?php
 if (isset($_GET["lang"])){
	 $lang= $_GET["lang"];
 }else{
	$lang= "en";
 } 
	
require("controller/ethosclient.php");
require("helpers/langproc.php");
require("controller/datalyser.php");
require("model/bittrex-client.php");
//require("controller/ethosclient.php");
	
	$c = new getlangString($lang, "welcome");
	$pagecontent = $c->getPageContent();
	$pagetitle = $c->getPageTitle();
?>

<html lang="<?php echo $lang ?>">
<head>
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<title><?php echo $pagetitle ?></title>
</head>
<body>
<?php
	
	//echo '<pre>' . print_r($pagecontent, true) . '</pre>';
	//echo "<h4>".$pagecontent["str1"]."</h4>";
	
	
	
 
	$o = new ethosClient("russia", "summary");
	//$o = new ethosClient("fd99b1", "summary");
	$url= $o->getURL();
	echo $url."<br/>";
	
	
	echo $o->error_message;
	
	$o->sendRequest($url); 
	$ethos_response =  $o->response_content;
	
	
	if($o->error ) echo $o->error_message;
	else echo $o->error_code;
	/**/
	
	$alldata= $ethos_response;
	  
	$d = new analyseJSON();
	
	$callExchange=new bittrexClient();
	  
	$tradepairs=array("BTC"=>"USDT-BTC","ETH"=>"USDT-ETH","ZEC"=>"USDT-ZEC","XMR"=>"USDT-XMR");
	   $tradevalues=array();
	   foreach ($tradepairs as $pair=>$value){
		   $call = $callExchange->sendRequest($value);
		   $tradevalues = $callExchange->response_content;
		   
		   echo '<pre>' . print_r($callExchange->curl_status_code, true) . '</pre>';
		   echo '<pre>' . print_r($callExchange->response_content, true) . '</pre>';
	   }
	?>
	
	<div style="color: aqua;">
	<?php  
	
	  
	echo '<pre>' . print_r($alldata, true) . '</pre>';
		
	?>
	
	</div>
	<?php 
	
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
	    <div>
		<?php 
		}
		
		$rigsdata=$alldata['rigs'];
	
		$gpuinfo=$d->getAllGPU($rigsdata);
			//echo '<pre>' . print_r($gpuinfo, true) . '</pre>';
	
	foreach($gpuinfo as $rigname=>$gpus){
		
		//echo '<pre>' . print_r($gpus, true) . '</pre>';
	}
	
	$gpu_json = file_get_contents("model/gpu-info.json");
			$gpu_info = json_decode($gpu_json, true);
	echo json_last_error();
	//echo '<pre>' . print_r($gpu_info, true) . '</pre>';
	//f1810f
	//$g = new ethosClient("fd99b1","graph","f1810f","temp");
	//echo $g->getURL()."<br/>";
	
	//if($g->error) echo $g->error;
	//else 
	
?>
	</div>
	<div><span class="label label-success">test</span></div>
</body>
</html>