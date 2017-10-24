<nav class="navbar bg-inverse navbar-inverse navbar-toggleable-md sticky-top">
  <div class="container">
    <a href="index.php" class="navbar-brand">
        <img src="assets/images/logo.png" width="60" style="text">
        ethOS Dashboard
    </a>
    <button class="navbar-toggler navbar-toggler-right-sm float-right mt-2" type="button" data-toggle="collapse" data-target="#myContent">
      <span class="navbar-toggler-icon"></span>
    </button>

   <div class="collapse navbar-collapse" id="myContent">
    <div class="navbar-nav navbar mr-auto">
       <a href="welcome.php?lang=<?php echo $lang ?>" class="nav-item nav-link active"><?php echo $pagecontent["menu1"] ?></a>
        <a href="#" class="nav-item nav-link"><?php echo $pagecontent["menu2"] ?></a>
        <a href="#" class="nav-item nav-link"><?php echo $pagecontent["menu3"] ?></a>

        <?php
		/*

        if ($_SERVER['REQUEST_URI'] != "/rigSettings/login.php") {
            echo "<a href='logout.php' class='nav-item nav-link'>Logout</a>";
          }
		 */
        ?>

     </div><!-- end navbar-nav navbar -->

     <form class="navbar-form navbar-right form-group" style="margin-top: 10px">

      <div class="input-group">
        <input class="form-control" type="text" name="search" id="search" placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-outline-success">GO</button>
        </span>
      </div>

     </form>
    </div>  <!-- end collapse -->

  </div> <!-- end container -->
</nav>