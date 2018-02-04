<?php


   require("helpers/langproc.php");
   require("controller/ethosclient.php");
   require("helpers/algos.php");
   require("view/mainview.php");

   require("model/wtm-client.php");
   require("controller/profcalc.php");

    //fetch langugae specific page content
   $c = new getlangString($lang, "main");
   $pagecontent = $c->getPageContent();
   $pagetitle = $c->getPageTitle();


	  //ethOS Client API call
	 $o = new ethosClient($ethos_id, "summary");
	 $url= $o->getURL();
	 $o->sendRequest($url);
	 $ethos_response =  $o->response_content;

	 if(!$o->json_error && is_array($ethos_response)){

	 	$alldata= $ethos_response;

	 	$s = new summaryBlock();
	 	$stats = new analyseJSON();


	 	$powerbyAlgo= $stats->powerbyAlgo($alldata['rigs']);

	 	$hashbyAlgo= $stats->sumbyAlgo($alldata['per_info']);
	 	$callWTM->wtmLink($hashbyAlgo,$powerbyAlgo);
	 	$callWTM->sendRequestwithParams();

	 	?>
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

	 			</div>

	 <?php

	 }


?>