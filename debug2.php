<html lang="ru_RU">
<head>
	<title>Debug file</title>
</head>
<body>

<?php
/*
$language = "ru_RU";
putenv("LANG=".$language);
setlocale(LC_ALL, $language);

$domain = "messages";
bindtextdomain($domain, "Locale");
*/
$locale = 'ru_RU'; // Pretend this came from the Accept-Language header
$locale_dir = 'Lang'; // your .po and .mo files should be at $locale_dir/$locale/LC_MESSAGES/messages.{po,mo}

setlocale(LC_ALL, "ru_RU.UTF-8");
putenv("LANGUAGE=ru_RU.UTF-8");
//setenv("LANGUAGE=$locale");

bindtextdomain('messages', 'Lang/ru_RU');
textdomain('messages');

echo gettext("Welcome to ethOS Dashboard")."<br/>";
echo gettext("Enter ethOS panel ID or your custom location set in your config file.")."<br/>";
echo gettext("View your hashing stats summary and monitor your rigs state.")."<br/>";
echo gettext("Update rig settings, change coins, miners and pools, and save changes into config file.")."<br/>";

echo "<br />";
require("controller/ethosclient.php");
//require("controller/ethosclient.php");

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
		<h3><?= $algo_miner ?> </h3>
			<h5>Total Hash: <?= $sum_info["hash"]." ".($algo_miner=='claymore'?'MH/s':'Sol/s'); ?></h5>
			<h5>Total Rigs: <?= $sum_info["per_total_rigs"]; ?></h5>
			<h5>Offline: <?= $sum_info["per_total_rigs"]-$sum_info["per_alive_rigs"]; ?></h5>
			<h5>GPUs: <?= $sum_info["per_alive_gpus"]."/".$sum_info["per_total_gpus"]; ?></h5>
			<span>Checked at: <?= date('H:i d/m', $sum_info["current_time"]); ?></span>
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