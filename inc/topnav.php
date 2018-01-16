<nav class="navbar bg-inverse navbar-inverse navbar-toggleable-md sticky-top">
  <div class="container">
    <a href="index.php" class="navbar-brand">
        <img src="assets/images/small_logo.svg" width="60" style="text">
            </a>
    <button class="navbar-toggler navbar-toggler-right-sm float-right mt-2" type="button" data-toggle="collapse" data-target="#myContent">
      <span class="navbar-toggler-icon"></span>
    </button><br>
<div class="navbar-brand navbar-left" id="logo"><h2><?php echo isset($ethos_id)?$ethos_id:"ethosDash" ?></h2></div>
   <div class="collapse navbar-collapse" id="myContent">
   
    <div class="navbar-nav navbar mr-auto">
      
       <a href="welcome.php?lang=<?php echo $lang ?>" class="nav-item nav-link active menu_item"><?php echo $topnavcontent["menu1"] ?></a>
        <a href="#rigslist" class="nav-item nav-link menu_item"><?php echo $topnavcontent["menu2"] ?></a>
        <a href="aboutus.php?lang=<?php echo $lang ?>" class="nav-item nav-link menu_item"><?php echo $topnavcontent["menu3"] ?></a>

        <?php
		/*

        if ($_SERVER['REQUEST_URI'] != "/rigSettings/login.php") {
            echo "<a href='logout.php' class='nav-item nav-link'>Logout</a>";
          }
		 */
        ?>

     </div><!-- end navbar-nav navbar -->
	   
	
     <form class="navbar-form navbar-left form-group" action="index.php" method="get" name="login" id="login">
		<input type="hidden" value="<?php echo $lang ?>" name="lang" />
      <div class="input-group">
        <input class="form-control" type="text" name="id" id="id" placeholder="<?php echo $topnavcontent["login_placeholder"] ?>">
        <span class="input-group-btn">
          <button class="btn btn-default"  type="submit"><?php echo $topnavcontent["login_button"] ?></button>
        </span>
		  
      </div>
     </form>
    
    <div class="navbar-right" id="lang_selector">
    
 	 	<a  href="http://<?php echo $_SERVER['SERVER_NAME']. ($_SERVER['SERVER_NAME']=="localhost"?":".$_SERVER['SERVER_PORT']:""). $_SERVER['PHP_SELF'] ?>?lang=en<?php echo (isset($_GET['id'])?"&id=".$_GET['id']:"") ?>" target="_self">
		 	<img src="assets/images/<?php echo ($lang=="en"?"lang_en_active":"lang_en") ?>.svg" width="40" style="text"></a>

			 <a  href="http://<?php echo $_SERVER['SERVER_NAME']. ($_SERVER['SERVER_NAME']=="localhost"?":".$_SERVER['SERVER_PORT']:""). $_SERVER['PHP_SELF'] ?>?lang=ru<?php echo (isset($_GET['id'])?"&id=".$_GET['id']:"") ?>" target="_self">
			 <img src="assets/images/<?php echo ($lang=="ru"?"lang_ru_active":"lang_ru") ?>.svg" width="40" style="text"></a>
	</div>
    </div>  <!-- end collapse -->

  </div> <!-- end container -->
</nav>