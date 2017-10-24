<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- For making responsive layouts work on mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Making compatible with ms edge browser -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- update this for description -->
    <!-- <meta name="Description" content="This is a template -- update this text"> -->
    <!-- update this for favicon -->
    <!-- <link rel="icon" href="/favicon.ico" type="image/x-icon"> -->
    <!-- link to normalizer/ cross browser css styles -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <!-- link to local css stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>

    <!-- JAVASCRIPT START -->
    <!-- Personal JS file -->
    <script src="js/script.js"></script>
    <!-- Babel ECMASCRIPT Translater -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.29/browser.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>

    <!-- BOOTSTRAP START -->
    <!-- Latest compiled and minified CSS -->
    <!--   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <title>Title</title>
</head>
<nav class="navbar bg-inverse navbar-inverse navbar-toggleable-md sticky-top">
  <div class="container">
    <a href="index.php" class="navbar-brand">
        <img src="./assets/logo.png" width="60" style="text">
        Miner Settings
    </a>
    <button class="navbar-toggler navbar-toggler-right-sm float-right mt-2" type="button" data-toggle="collapse" data-target="#myContent">
      <span class="navbar-toggler-icon"></span>
    </button>

   <div class="collapse navbar-collapse" id="myContent">
    <div class="navbar-nav navbar mr-auto">
       <a href="index.php" class="nav-item nav-link active">Home</a>
        <a href="#" class="nav-item nav-link">Contact</a>
        <a href="#" class="nav-item nav-link">About</a>

        <?php

        if ($_SERVER['REQUEST_URI'] != "/rigSettings/login.php") {
            echo "<a href='logout.php' class='nav-item nav-link'>Logout</a>";
          }
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
<body>