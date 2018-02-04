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
		?>
<!--		<nav aria-label="Search results">
		<ul class="pagination justify-content-end">
  <li  class="page-item"><a class="page-link" href="#">1</a></li>
  <li class="page-item active"><a class="page-link" href="#">2</a></li>
  <li  class="page-item"><a class="page-link" href="#">3</a></li>
  <li  class="page-item"><a class="page-link" href="#">4</a></li>
  <li  class="page-item"><a class="page-link" href="#">5</a></li>
</ul>
		</nav>-->
		<?php
			$rg->rigslist($allrigs);
		?>

	</div>
</div>
