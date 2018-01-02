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
require_once(dirname(__FILE__) . "/include/engine.php");
dbconn();
logoutcookie (htmlentities(strip_tags(trim(htmlspecialchars($CURUSER["id"])))));
$text = "Der User ".$CURUSER["username"]." hat sich ausgeloggt !";
$date=time();
mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES (NULL," . sqlesc('0') . ", " . sqlesc('Tactics') . ", $date, " . sqlesc($text) . ")");  
Header("Location: $BASEURL/");
?>