<?php
// ************************************************************************************//
// * D€ Source 2018
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2017 - 2018 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************// 
require_once(dirname(__FILE__) . "/include/Classes/Shoutcast.php");

header('Content-Type: text/html; charset=iso-8859-1');

dbconn(true);
loggedinorreturn();

function ConvertSeconds($seconds) {
	$tmpseconds = substr("00".$seconds % 60, -2);
	if ($seconds > 59) {
		if ($seconds > 3599) {
			$tmphours = substr("0".intval($seconds / 3600), -2);
			$tmpminutes = substr("0".intval($seconds / 60 - (60 * $tmphours)), -2);
			
			return ($tmphours.":".$tmpminutes.":".$tmpseconds);
		} else {
			return ("00:".substr("0".intval($seconds / 60), -2).":".$tmpseconds);
		}
	} else {
		return ("00:00:".$tmpseconds);
	}
}

$shoutcast = new ShoutCast();
$shoutcast->host = $GLOBALS["RADIO_IP"];
$shoutcast->port = $GLOBALS["RADIO_PORT"];
$shoutcast->passwd = $GLOBALS["RADIO_PASSWORD"]; 


if ($shoutcast->openstats()) {
	// We got the XML, gogogo!..
	if ($shoutcast->GetStreamStatus()) {
		echo "
					<div class='table table-bordered table-striped table-condensed text-center'>Derzeitiges Lied: ".$shoutcast->GetCurrentSongTitle()." @ ".$shoutcast->GetBitRate()." kbps - Reinhören: <a href=http://".$GLOBALS["RADIO_IP"].":".$GLOBALS["RADIO_PORT"]."/listen.pls>Jetzt reinhören!</a></div>";
	} else {
		echo "
					<div class='table table-bordered table-striped table-condensed text-center'>Shoutcast: Momentan kein DJ Online!</div>";
	}
} else {
	// Ohhh, damnit..
		echo "
				<div class='table table-bordered table-striped table-condensed text-center'>";
		echo $shoutcast->geterror();
		echo "
				</div>";
}
?>