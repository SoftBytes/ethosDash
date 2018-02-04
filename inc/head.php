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
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<!-- D3.js -->
	<script src="https://d3js.org/d3.v3.min.js"></script>
    <script src="https://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/d3-style.css">

    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>

    <!-- JAVASCRIPT START -->
    <!-- Personal JS file -->
    <script src="assets/js/script.js"></script>
    <!-- Babel ECMASCRIPT Translater -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.29/browser.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
    <script src="assets/js/raphael-2.1.4.min.js"></script>
    <script src="assets/js/justgage.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script src="assets/js/gpuchart.js"></script>
	<script language="javascript" type="text/javascript">
	function timeConverter(UNIX_timestamp){
	  var a = new Date(UNIX_timestamp * 1000);
	  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
	  var year = a.getFullYear();
	  var month = months[a.getMonth()];
	  var date = a.getDate();
	  var hour = a.getHours();
	  var min = a.getMinutes();
	  var sec = a.getSeconds();
	  var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
	  document.write(time);
	}
	
	</script>
 <link rel="stylesheet" type="text/css" href="assets/css/gauge-svg.css">
    <!-- BOOTSTRAP START -->
    <!-- Latest compiled and minified CSS -->
    <!--   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <title><?php echo $pagetitle ?></title>
</head>