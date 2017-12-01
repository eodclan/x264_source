<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");
dbconn();

header('Content-Type: text/html; charset=iso-8859-1'); 


$stats1 = get_sc_stats1();

function listener($stats)
{
  global $db;
  $adresses = array();

  for ($i=0; $i < count($stats["listeners"]); $i++)
  {
    $ip = gethostbyname($stats["listeners"][$i]["hostname"]);

    $adresses[] = sqlesc($ip);
  }
  
  if (count($adresses) == 0)
  {
    return;
  }
  
  $sql = "SELECT id, username, class FROM users WHERE ip IN (".implode(", ",$adresses).") ORDER BY class DESC, username";
  $res = $db -> queryObjectArray($sql);

  if (!$res)
  {
    return;
  }
  
  $activeusers = array();
  foreach($res as $arr)
  {
    $activeusers[] = "
      <a href='userdetails.php?id=".$arr["id"]."'><b><font class=".get_class_color($arr["class"]).">".
      $arr["username"]."</font></b></a>&nbsp;".get_user_icons($arr);
  }
  
  $activeusers = implode(", ",$activeusers);

  if ($stats["streamstatus"] == 1 && $activeusers != "")
  {
    $ret = "
    		".$activeusers."";
  }
  return $ret;
}

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

$listener = array(
  "1" => listener($stats1)
);

print "
".($stats1["streamstatus"] == 1?"
<div><img src='/design/djonair.png' style='width:100%;' align='center'></div>
<div>
	<div id='radiolistener1' style='display:none'>".$listener['1']."</div>
	Reinhören: <a href='http://".$GLOBALS["RADIO_IP"].":".$GLOBALS["RADIO_PORT"]."/listen.pls'>
		<img src='pic/radiolisten.png' valign='bottom' hight='15' alt='Reinh&ouml;ren' title='Reinh&ouml;ren' style='vertical-align: middle;' width='15' border='0'>
		</a>
	</div>
	<div >
		DJ: ".$stats1["servertitle"]." ".($stats1["servergenre"]?"<font color='yellow'>(".$stats1["servergenre"].")</font>":"")."
	</div>
	<div >
		Akt.: ".intval($stats1["currentlisteners"])." <font color='red'>/</font> Max: ".intval($stats1["maxlisteners"])." </b>
	</div>
	<div >
		Zuh&ouml;rer: <br><br>".$listener['1']."
	</div>
	":"
	<div >
		<img src='/design/djoffair.png' style='height:60px;' align='center'>
	</div>
	<div >
		Momentan kein DJ Online!
	</div>")."
</div>";
?>