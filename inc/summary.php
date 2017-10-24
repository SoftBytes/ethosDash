<div id="intro" class="jumbotron jumbotron-fluid text-center text-white">
 
 <?php

	if($o->error ) echo "<h4>".$o->error_message."</h4>";
	else{
		?>
  <h1><?php echo $pagecontent["summary"] ?></h1>
  <h3><?php echo $pagecontent["sum_note"] ?></h3>
  
  <?php
		
		$summary = $alldata['per_info'];
				foreach($summary as $algo_miner=>$sum_info){
		?>
      <div class="summary_wrapper">
        <div class="summary_block_<?= ($algo_miner) ?>">
              <h3 class="card-title miner_summary_head_<?= $algo_miner; ?>"><?= get_algo($algo_miner) ?> </h3>
              <h5>Total Hash: <?= $sum_info["hash"]." ".($algo_miner=='claymore'?'MH/s':'Sol/s'); ?></h5>
              <h5>Total Rigs: <?= $sum_info["per_total_rigs"]; ?></h5>
              <h5>Offline: <?= $sum_info["per_total_rigs"]-$sum_info["per_alive_rigs"]; ?></h5>
              <span>Checked at: <?= date('H:i d/m', $sum_info["current_time"]); ?></span>
            </div> <!-- block summary end -->
        </div>
	    
		<?php 
		}
	}
	
?>

