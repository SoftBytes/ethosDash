<?php

function getTimeZonefromIP(){
	// first line of PHP
	$ip     = $_SERVER['REMOTE_ADDR']; // means we got user's IP address 
	$json   = file_get_contents( 'http://smart-ip.net/geoip-json/' . $ip); // this one service we gonna use to obtain timezone by IP
	// maybe it's good to add some checks (if/else you've got an answer and if json could be decoded, etc.)
	$ipData = json_decode( $json, true);

	if ($ipData['timezone']) {
		$tz = new DateTimeZone( $ipData['timezone']);
		$now = new DateTime( 'now', $tz); // DateTime object corellated to user's timezone
	} else {
	   $tz = new DateTimeZone('UTC');
	}
	return $tz;
}

?>