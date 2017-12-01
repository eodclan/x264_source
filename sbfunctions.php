<?php
$ftext = explode(" ",$text);
$funktion = $ftext[0];
$ftext = eregi_replace($funktion." ","",$text);

switch ($funktion)
{
  case "/kiss":
    $sbtext =  "[b][class=".get_class_color($CURUSER['class'])."]".$CURUSER['username']."[/class][color=lime] gibt [/color][color=yellow]".$ftext."[/color][color=lime] einen Kuss[/color][/b]";
    break;
  case "/tritt":
    $sbtext =  "[b][class=".get_class_color($CURUSER['class'])."]".$CURUSER['username']."[/class][color=lime] tritt [/color][color=yellow]".$ftext."[/color][color=lime] kräftig in den Hintern[/color][/b]";
    break;
  default:
    $alert = "Die Funktion $funktion gibt es hier nicht";
}

$date   = time();

if ($sbtext)
  mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES ( NULL ," . sqlesc('0') . ", " . sqlesc('Tactics') . ", $date, " . sqlesc($sbtext) . ")");

?>
