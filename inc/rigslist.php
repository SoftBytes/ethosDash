<?php	
	$allrigs = $alldata["rigs"];
	
	$rg = new rigsTable($allrigs, $pagecontent);
	$gpuinfo=$stats->getAllGPU($allrigs);
	?>
<div class="container">
	<div class="riglist_wrapper">

		<?php

			//$rg->rigslistHeader();

			$rigs_gpus = array("alive_gpus"=>$alldata["alive_gpus"],"total_gpus" =>$alldata["total_gpus"], "alive_rigs"=>$alldata["alive_rigs"],"total_rigs"=>$alldata["total_rigs"],"capacity"=>$alldata["capacity"],"rig_label"=>$pagecontent['label3'],"gpu_label"=>$pagecontent['label5'],"capacity_label"=>$pagecontent['label12']);

			$rg->statsRigsGpus($rigs_gpus);
			$rg->rigslist($allrigs);
		?>

	</div>
</div>
