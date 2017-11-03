<div id="intro" class="jumbotron jumbotron-fluid text-center text-white">
 
 <?php

	if($o->error ) echo "<h4>".$o->error_message."</h4>";
	else{
		?>
  <!-- <h1><?php //echo $pagecontent["summary"] ?></h1>-->
  <h3><?php echo $pagecontent["summary"] ?></h3><br/>
  
  <?php
		$s = new summaryBlock();
		
		
		$tlabels = array("hashrate"=>$pagecontent["label7"],"gpus"=>$pagecontent["label5"],"total_alive" =>$pagecontent["label4"], "rigs"=>$pagecontent["label3"],"capacity"=>$pagecontent["label12"]);
		
		$tvalues = array("hashrate"=>$alldata["total_hash"],"alive_gpus"=>$alldata["alive_gpus"],"total_gpus" =>$alldata["total_gpus"], "alive_rigs"=>$alldata["alive_rigs"],"total_rigs"=>$alldata["total_rigs"],"capacity"=>$alldata["capacity"]);
	?>	
<!-- Tital Hash, Capacity, Ris and GPus -->
	<div>

	<?php $s->totalInfo($tvalues, $tlabels) ?>

</div>
<!-- Total Power, Avg. Temperature-->
<div>
</div>	
	<?php	
		$miners_summary = $alldata['per_info'];
		foreach($miners_summary as $algo_miner=>$sum_info){
		?>
     <div class="summary_wrapper"> 
        <div class="summary_block">
              
            <?php 
					$s->summaryMiner($algo_miner, get_algo($algo_miner), $pagecontent["label1"]); 
            		$s->summaryInfo($pagecontent["label2"], $sum_info["hash"], NULL , algoUnits(get_algo($algo_miner))); 
            		$s->summaryInfo($pagecontent["label3"], $sum_info["per_alive_rigs"]."/".$sum_info["per_total_rigs"], $pagecontent["label4"]);
					$s->summaryInfo($pagecontent["label5"], $sum_info["per_alive_gpus"]."/".$sum_info["per_total_gpus"], $pagecontent["label4"]);
					$s->summaryInfo($pagecontent["label6"], date('H:i d/m', $sum_info["current_time"])); 
			
			?>
              
         </div> 
        
	   	</div> 
		<?php 
		}
		?>

	<?php 
	}
	
?>
</div>
