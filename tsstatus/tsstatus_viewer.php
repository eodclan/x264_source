<?php
require_once(dirname(__FILE__)."../../include/engine.php");
dbconn();
loggedinorreturn();

if ($CURUSER)
{
  $ss_a = @mysql_fetch_assoc(@mysql_query("SELECT `uri` FROM `design` WHERE `id`=" . $CURUSER["design"]));
  if ($ss_a) $GLOBALS["ss_uri"] = $ss_a["uri"];
}

if (!$GLOBALS["ss_uri"])
{
  ($r = mysql_query("SELECT `uri` FROM `design` WHERE `default`='yes'")) or die(mysql_error());
  ($a = mysql_fetch_assoc($r)) or die(mysql_error());
  $GLOBALS["ss_uri"] = $a["uri"];
}

$ts3_ip 	= $GLOBALS["TS3_IP"];
$ts3_port 	= $GLOBALS["TS3_PORT"];

print"
<link rel='stylesheet' type='text/css' href='/tsstatus/ts3ssv.css' />
<script type='text/javascript' src='/tsstatus/ts3ssv.js'></script>";

require_once("/home/your_folder/tsstatus/ts3ssv.php");
$ts3ssv = new ts3ssv($ts3_ip, 10011);
$ts3ssv->useServerPort(9987);
$ts3ssv->imagePath = "/tsstatus/img/default/";
$ts3ssv->timeout = 2;
$ts3ssv->hideEmptyChannels = false;
$ts3ssv->hideParentChannels = false;
$ts3ssv->showNicknameBox = false;
$ts3ssv->showPasswordBox = true;
echo $ts3ssv->render();
?>

