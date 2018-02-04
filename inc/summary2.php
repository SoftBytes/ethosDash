<div id = "intro" class="jumbotron text-white text-center vertical_top">
 
 <?php
	
	//get total power
	  $sum_power = $stats->totalPower($alldata["rigs"]);

	//if($o->error ) echo "<h4>".$o->error_message."</h4>";
	//else{

		$tlabels = array("hashrate"=>$pagecontent["label7"],"gpus"=>$pagecontent["label5"],"total_alive" =>$pagecontent["label4"], "rigs"=>$pagecontent["label3"],"capacity"=>$pagecontent["label12"], "sum_power"=>$pagecontent["label17"]);
		
		$tvalues = array("hashrate"=>$alldata["total_hash"],"alive_gpus"=>$alldata["alive_gpus"],"total_gpus" =>$alldata["total_gpus"], "alive_rigs"=>$alldata["alive_rigs"],"total_rigs"=>$alldata["total_rigs"],"capacity"=>$alldata["capacity"], "sum_power"=>$sum_power);
		
		
	?>	
<!-- Total Hash, Capacity, Miners, calculator -->
	<div class="summary_block">
	<?php 
		$s->totalInfo($tvalues, $tlabels) ;
		//$s->sumhashInfo($stats->sumbyAlgo($alldata['per_info']));
	?>

	</div>
	<div class="summary_block">
	<?php
	foreach($stats->sumbyAlgo($alldata['per_info']) as $algo=>$hash){

				$s->displayHashStats($algo,$hash);
				//echo '<pre>' . print_r($calculator->coininfo[$algo], true) . '</pre>';
				//echo $s->displayCalculator2($hash, $calculator->coininfo[$algo], $calculator->defaults[$algo]);
				
			}
	
	?>	
	</div>
	<div  class="summary_block">
		<h5><?php echo $pagecontent["label21"]; ?>:</h5>
		<?php 

			$miners_summary = $alldata['per_info'];//information from miners as per_info
			$pools_stats=$stats->minerPools($alldata['rigs']);
			//$miners_details = 
			foreach($miners_summary as $algo_miner=>$sum_info){

						$s->summaryMiner($algo_miner, get_algo($algo_miner), $pagecontent["label21"]); 
						//$s->summaryInfo($pagecontent["label2"], $sum_info["hash"], NULL , algoUnits(get_algo($algo_miner)));
						$s->minerPool($pools_stats[$algo_miner]);
						//$s->summaryInfo($pagecontent["label3"], $sum_info["per_alive_rigs"]."/".$sum_info["per_total_rigs"], //$pagecontent["label4"]);
						//$s->summaryInfo($pagecontent["label5"], $sum_info["per_alive_gpus"]."/".$sum_info["per_total_gpus"], //$pagecontent["label4"]);
						//$s->summaryInfo($pagecontent["label6"], date('H:i d/m', $sum_info["current_time"])); 
			}
			?>
	</div>
	<?php
	
	//$s->sumhashInfo($stats->sumbyAlgo($alldata['per_info']));
	if(!$callWTM->error && !$callWTM->json_error){
			
			$response = $callWTM->response_content;

			$calculator= new wtmCalculator();
			//organise coins in array - coininfo
			$calculator->coinsByAlgo($response);
		//sorted coins
		    $calculator->coinsSorted($response);
			//get deafulat rates as array - defaults
			$calculator->wtmDefaults();
		
		//power by Algo
		$powerbyAlgo= $stats->powerbyAlgo($alldata['rigs']);
		//hash summary by Algorithm
		$hashbyAlgo= $stats->sumbyAlgo($alldata['per_info']);
			
?>
				<div class="summary_block" style="max-width: 350px;">
				<h5>Mining Calculator</h5>
				
				<?php			
				//$s->totalInfo($tvalues, $tlabels) ;
			foreach($stats->sumbyAlgo($alldata['per_info']) as $algo=>$hash){
				//echo "<div style=\"text-align:left;\"><span>".$algo."</span><br/>";
				//$s->displayHashStats($algo,$hash);
				//echo '<pre>' . print_r($calculator->coininfo[$algo], true) . '</pre>';
				echo $s->displayCalculator2($hash, $calculator->coininfo[$algo], $calculator->defaults[$algo],$algo, $powerbyAlgo[$algo]);
				//echo "</div>";
			}
			echo $s->wtmLink($hashbyAlgo, $powerbyAlgo);
					?>
					
		</div>

		<?php
		//echo '<pre>' . print_r($calculator->coinsorted, true) . '</pre>';
		/*foreach($calculator->coinsorted as $value){
				echo $value['tag']." ".$value['btc_revenue']."<br/>";
		}*/
		//$myalgos= array("Ethash"=>110,"Equihash"=>1500, "CryptoNight"=>2200);
		//echo $s->displayCalculator3($stats->sumbyAlgo($miners_summary),$calculator->coinsorted, $calculator->defaults);
		?>
		
		<?php
		//echo "CURL Error: ".$callapi->error_message." error code:".$callapi->error_code."<br/>";
		//echo "Cannot get data for coins info.";
			
			
			
	}else{
		//echo "Respones status code:".$callapi->curl_status_code;
	//	$response = $callWTM->response_content;
//		
//		$calculator= new wtmCalculator();
//		//organise coins in array - coininfo
//	    $calculator->coinsByAlgo($response);
//	    //get deafulat rates as array - defaults
//	    $calculator->wtmDefaults();
//		//miners_rates
//		$myalgos= array("Ethash"=>110,"Equihash"=>1500, "CryptoNight"=>2200);
//			
//		//echo '<pre>' . print_r($calculator->defaults, true) . '</pre>';
//		//display coins
//		echo $s->displayCalculator($myalgos,$calculator->coininfo, $calculator->defaults);	
	}
	?>
</div>
