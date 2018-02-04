<nav class="navbar bg-inverse navbar-inverse navbar-toggleable-md sticky-top">
  <div class="container">
   <div class="navbar-brand navbar-left" id="logo"><a href="index.php" class="navbar-brand">
        <img src="assets/images/small_logo.svg" width="60" style="text" />
	   </a><?php echo isset($ethos_id)?$ethos_id:"ethosDash" ?></div>
    
    <button class="navbar-toggler navbar-toggler-right-sm float-right mt-4" type="button" data-toggle="collapse" data-target="#myContent">
      <span class="navbar-toggler-icon"></span>
    </button>

   <div class="collapse navbar-collapse" id="myContent">
	   <div class="navbar display-inline exchanges"></div>
	   <!--<div class="display-inline whitetext"><div class="coin_info">&nbsp;</div><div style="position: relative; top: 11px;" class="coin_info"><span class="stats_label">USD </span></div></div>-->
   <?php
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
  <div class="navbar display-inline mr-auto"></div>
   <!--  <div class="navbar-nav navbar mr-auto">
      
       <a href="welcome.php?lang=<?php echo $lang ?>" class="nav-item nav-link active menu_item"><?php echo $topnavcontent["menu1"] ?></a>
        <a href="#rigslist" class="nav-item nav-link menu_item"><?php echo $topnavcontent["menu2"] ?></a>
        <a href="aboutus.php?lang=<?php echo $lang ?>" class="nav-item nav-link menu_item"><?php echo $topnavcontent["menu3"] ?></a>
     </div>end navbar-nav navbar -->
	   
	<div name="login" id="login">
     <form class="navbar-form navbar-left form-group" action="main.php" method="get">
		<input type="hidden" value="<?php echo $lang ?>" name="lang" />
      <div class="input-group">
        <input class="form-control" type="text" name="id" id="id" placeholder="<?php echo $topnavcontent["login_placeholder"] ?>">
        <span class="input-group-btn">
          <button class="btn"  type="submit"><?php echo $topnavcontent["login_button"] ?></button>
        </span>
		  
      </div>
     </form>
	   </div>
    <div class="navbar-right" id="lang_selector">
    
 	 	<a  href="https://<?php echo $_SERVER['SERVER_NAME']. ($_SERVER['SERVER_NAME']=="localhost"?":".$_SERVER['SERVER_PORT']:""). $_SERVER['PHP_SELF'] ?>?lang=en<?php echo (isset($_GET['id'])?"&id=".$_GET['id']:"") ?>" target="_self">
		 	<img src="assets/images/<?php echo ($lang=="en"?"lang_en_active":"lang_en") ?>.svg" width="40" style="text"></a>

			 <a  href="https://<?php echo $_SERVER['SERVER_NAME']. ($_SERVER['SERVER_NAME']=="localhost"?":".$_SERVER['SERVER_PORT']:""). $_SERVER['PHP_SELF'] ?>?lang=ru<?php echo (isset($_GET['id'])?"&id=".$_GET['id']:"") ?>" target="_self">
			 <img src="assets/images/<?php echo ($lang=="ru"?"lang_ru_active":"lang_ru") ?>.svg" width="40" style="text"></a>
	</div>
    </div>  <!-- end collapse -->

  </div> <!-- end container -->
</nav>