<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome</title>
<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
	<h4>Welcome</h4>
	<?php
	$language = "en_AU";
putenv("LANG=".$language);
setlocale(LC_ALL, $language);

$domain = "messages_new";
bindtextdomain($domain, "Locale");

echo gettext("welcome")."<br/>";
	?>
</body>
</html>