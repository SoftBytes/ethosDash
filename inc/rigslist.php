<?php	
	$allrigs = $alldata["rigs"];
	$rg = new rigsTable();
	?>

<div class="riglist_wrapper">

<?php
	
	$rg->rigslistHeader();
	$rg->rigslist($allrigs);
?>

</div>
