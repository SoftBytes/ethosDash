 <?php
	require("../model/bittrex-client.php");
    $callExchange=new bittrexClient();
	$tradepairs=array("BTC"=>"USDT-BTC","ETH"=>"USDT-ETH","ZEC"=>"USDT-ZEC","XMR"=>"USDT-XMR");
	   $tradevalues=array();
	   
	   foreach ($tradepairs as $pair=>$value){
		   $call=$callExchange->sendRequest($value);
		   $tradevalues = $callExchange->response_content;
		   ?>
	   <div id = "coin_rates" class="display-inline whitetext"><div class="coin_info"><img src="assets/images/<?php echo $pair; ?>.svg" width="30" style="text"></div><div class="coin_info"><?php echo round($tradevalues["result"][0]["Last"],1) ?>&nbsp;<img src="assets/images/<?php echo ($tradevalues["result"][0]["Last"]>=$tradevalues["result"][0]["PrevDay"]?"arrowup_green":"arrowdown_red") ?>.svg" height="12" style="text"><span class="stats_label display_75"><?php echo ($tradevalues["result"][0]["Last"]>=$tradevalues["result"][0]["PrevDay"]?round($tradevalues["result"][0]["Last"]/$tradevalues["result"][0]["PrevDay"]*100 -100,1):round(100-$tradevalues["result"][0]["Last"]/$tradevalues["result"][0]["PrevDay"]*100,1)) ?>%</span></div></div>
		   <?php
	   }
	?>