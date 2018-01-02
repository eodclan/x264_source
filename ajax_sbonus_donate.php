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
loggedinorreturn(); 

$from = (int) $_POST["from"];
$to = (int) $_POST["to"];
$amount = (int) $_POST["amount"];


mysql_query("UPDATE users SET seedbonus = seedbonus + '$amount' WHERE id = '$to' LIMIT 1");
mysql_query("UPDATE users SET seedbonus = seedbonus - '$amount' WHERE id = '$from' LIMIT 1"); 

if($CURUSER["id"] == $to) {
print("You can not pass bonuses themselves.");
} elseif($CURUSER["seedbonus"] <= $amount) {
	print("You do not have enough bonuses");
} else {
	print("Erfolgreich, deine Seed Bonus Spende wurde gesendet.");
}
?>