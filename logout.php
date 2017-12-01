<?php
// ************************************************************************************//
// * X264 Source
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2015 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//
require_once("include/bittorrent.php");
dbconn();
//if (!isset($_GET['sessiontoken']) || !(strcmp($_GET['sessiontoken'], crypt (htmlspecialchars(session_id())) === 0))) {
//    die("Falscher, session token.");
//}
logoutcookie (htmlentities(strip_tags(trim(htmlspecialchars($CURUSER["id"])))));
$text = "Der User ".$CURUSER["username"]." hat sich ausgeloggt !";
$date=time();
mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES (NULL," . sqlesc('0') . ", " . sqlesc('Tactics') . ", $date, " . sqlesc($text) . ")");  
Header("Location: $BASEURL/");
?>