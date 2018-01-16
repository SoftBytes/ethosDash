<div id = "intro" class="jumbotron jumbotron-fluid text-white text-center">
 
 <?php
	
	//get total power
	  $sum_power = $stats->totalPower($alldata["rigs"]);

	//if($o->error ) echo "<h4>".$o->error_message."</h4>";
	//else{

		$tlabels = array("hashrate"=>$pagecontent["label7"],"gpus"=>$pagecontent["label5"],"total_alive" =>$pagecontent["label4"], "rigs"=>$pagecontent["label3"],"capacity"=>$pagecontent["label12"], "sum_power"=>$pagecontent["label17"]);
		
		$tvalues = array("hashrate"=>$alldata["total_hash"],"alive_gpus"=>$alldata["alive_gpus"],"total_gpus" =>$alldata["total_gpus"], "alive_rigs"=>$alldata["alive_rigs"],"total_rigs"=>$alldata["total_rigs"],"capacity"=>$alldata["capacity"], "sum_power"=>$sum_power);
		
		
	?>	
<!-- Tital Hash, Capacity, Ris and GPus -->
<div class="summary_block">
	<?php 
		$s->totalInfo($tvalues, $tlabels) ;
		//$s->sumhashInfo($stats->sumbyAlgo($alldata['per_info']));
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
<div class="summary_block">
	<?php 
		//$s->totalInfo($tvalues, $tlabels) ;
		$s->sumhashInfo($stats->sumbyAlgo($alldata['per_info']));
	?>
</div>
	<?php 
	//}
	
?>
</div>
