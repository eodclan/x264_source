<?php
require_once("include/bittorrent.php");
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