<div class="container text-center col-10 col-sm-4 col-lg-3 col-xl-2">

      <form action="index.php" method="get" class="form">
       <input type="hidden" value="<?php echo $lang ?>" name="lang" />
        <div id="formGroup" class="form-group">
          <h2 class="form-signin-heading"><?php echo $pagecontent["login_title"] ?></h2>
          <label for="id" class="sr-only">EthOS ID</label>
          <div class="inner-addon right-addon">
            <i id="spinner" class="fa fa-spinner text-primary" aria-hidden="true"></i>
            <input type="text" id="id" name="id" class="form-control" placeholder="EthOS ID" minlength="6" maxlength="6" required autofocus>
          </div>
          <button id="submit" class="btn btn-lg btn-success btn-block mt-2" type="submit"><?php echo $pagecontent["login_button"] ?></button>
        </div>
      </form>

</div> <!-- /container -->