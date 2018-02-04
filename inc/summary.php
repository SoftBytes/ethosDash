<?php
$powerbyAlgo= $stats->powerbyAlgo($alldata['rigs']);
//hash summary by Algorithm
$hashbyAlgo= $stats->sumbyAlgo($alldata['per_info']);
$callWTM->wtmLink($hashbyAlgo,$powerbyAlgo);
$callWTM->sendRequestwithParams();
//echo $callWTM->url;

?>


<div id = "intro" class="jumbotron jumbotron-fluid text-white text-center">

 <?php
	//validate wtm api call
	if($callWTM->error || $callWTM->json_error){
		$display_calculator = false;
		echo $callWTM->error_message."<br/>";
		echo $callWTM->url;
	}
	else {
		$display_calculator = true;
		$response = $callWTM->response_content;
		$calculator= new wtmCalculator();
		//organise coins in array - coininfo
		$calculator->coinsByAlgo($response);
		//sorted coins
		//$calculator->coinsSorted($response);
		//get deafulat rates as array - defaults
		$calculator->wtmDefaults();
		//power by Algo
		//$powerbyAlgo= $stats->powerbyAlgo($alldata['rigs']);
		//hash summary by Algorithm
		//$hashbyAlgo= $stats->sumbyAlgo($alldata['per_info']);

	}
	//get total power
	  $sum_power = $stats->totalPower($alldata["rigs"]);


	//if($o->error ) echo "<h4>".$o->error_message."</h4>";
	//else{

		$tlabels = array("hashrate"=>$pagecontent["label7"],"gpus"=>$pagecontent["label5"],"total_alive" =>$pagecontent["label4"], "rigs"=>$pagecontent["label3"],"capacity"=>$pagecontent["label12"], "sum_power"=>$pagecontent["label17"]);

		$tvalues = array("hashrate"=>$alldata["total_hash"],"alive_gpus"=>$alldata["alive_gpus"],"total_gpus" =>$alldata["total_gpus"], "alive_rigs"=>$alldata["alive_rigs"],"total_rigs"=>$alldata["total_rigs"],"capacity"=>$alldata["capacity"], "sum_power"=>$sum_power);


	?>
<!-- Tital Hash, Capacity, Ris and GPus -->
<div class="summary_wrapper" id="">

<?php
		if($display_calculator){
		?>
		<div class="summary_block">
		<?php
		//echo $s->displayMilestonePeriod($calculator->get1BTCdays($calculator->coininfo, $hashbyAlgo, $calculator->defaults), $pagecontent["forecast"],$pagecontent["1btcforecast"]);
		echo $s->displayMilestonePeriod($calculator->get1BTCdays2($calculator->coininfo, $hashbyAlgo), $pagecontent["forecast"],$pagecontent["1btcforecast"]);
		?>
		</div>
		<?php
		}
	?>
		<div class="summary_block">
	<?php
		$s->totalInfo($tvalues, $tlabels) ;
		//$s->sumhashInfo($stats->sumbyAlgo($alldata['per_info']));
	?>
	</div>
</div>

	<?php

	//$s->sumhashInfo($stats->sumbyAlgo($alldata['per_info']));
	if($display_calculator){


?>
				<div class="summary_wrapper" id="topCoins">
				<div class="summary_block">
				<h5><?php echo $pagecontent["calculator"]; ?></h5>

				<?php
				//$s->totalInfo($tvalues, $tlabels) ;
			foreach($stats->sumbyAlgo($alldata['per_info']) as $algo=>$hash){
				//echo "<div style=\"text-align:left;\"><span>".$algo."</span><br/>";
				//$s->displayHashStats($algo,$hash);
				//echo '<pre>' . print_r($calculator->coininfo[$algo], true) . '</pre>';
				//echo $s->displayCalculator($hash, $calculator->coininfo[$algo], $calculator->defaults[$algo],$algo, $powerbyAlgo[$algo]);
				echo $s->displayCalculatorParams($hash, $calculator->coininfo[$algo],$algo, $powerbyAlgo[$algo], sizeof($calculator->coininfo));
				//echo "</div>";
			}
			echo $s->wtmLink($hashbyAlgo, $powerbyAlgo, $pagecontent["poweredby"], $pagecontent["wtmlinknote"]);
					?>

					</div></div>
		<?php
		//echo "CURL Error: ".$callapi->error_message." error code:".$callapi->error_code."<br/>";
		//echo "Cannot get data for coins info.";



	}else{
		//echo "Respones status code:".$callapi->curl_status_code;

	}
	?>
<div  class="summary_wrapper">
		<div class="summary_block">
	<?php
	foreach($stats->sumbyAlgo($alldata['per_info']) as $algo=>$hash){

				$s->displayHashStats($algo,$hash);
	}

	?>
</div>
<div class="summary_block">
	<h5><?php echo $pagecontent["label21"]; ?></h5>
	<?php

		$miners_summary = $alldata['per_info'];//information from miners as per_info
		$pools_stats=$stats->minerPools($alldata['rigs']);
		//$miners_details =
		foreach($miners_summary as $algo_miner=>$sum_info){

					$s->summaryMiner($algo_miner, get_algo($algo_miner), $pagecontent["label21"]);
					$s->minerPool($pools_stats[$algo_miner]);
		}
		?>
	</div>


</div>

</div>

