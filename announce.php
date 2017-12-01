<?php
// ************************************************************************************//
// * X264 Source
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 3.0
// * 
// * Copyright (c) 2015 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//
require_once(dirname(__FILE__) . "/include/bittorrent.php");
require_once(dirname(__FILE__) . "/include/benc.php");
require_once(dirname(__FILE__) . "/include/dagent.class.php");

hit_start();
  
function hex2bin1($hexdata)
{
  for ($i=0;$i<strlen($hexdata);$i+=2)
  {
    $bindata.=chr(hexdec(substr($hexdata,$i,2)));
  }
  return $bindata;
}

function err($msg)
{
  benc_resp(array("failure reason" => array(type => "string", value => $msg)));
  hit_end();
  exit();
}

function benc_resp($d)
{
  benc_resp_raw(benc(array(type => "dictionary", value => $d)));
}

function benc_resp_raw($x)
{
  header("Content-Type: text/plain");
  header("Pragma: no-cache");
  print($x);
}

function check_ip_limit()
{
  global $userid;

  $res = mysql_query("SELECT DISTINCT(ip) AS ip FROM peers WHERE userid=$userid");
  $count = 0;
  $found = FALSE;
  while ($row = mysql_fetch_assoc($res))
  {
    $count++;
    if ($row["ip"] == $ip)
    {
      $found = TRUE;
      break;
    }
  }
    
  if (!$found && $count >= $GLOBALS["MAX_PASSKEY_IPS"])
    err("Zu viele unterschiedliche IPs fuer diesen Benutzer (max ".$GLOBALS["MAX_PASSKEY_IPS"].")");
}

dbconn(false);

$trackerdienste = explode("|",htmlentities(trim($GLOBALS["TF_DOWNLOAD"])));
if ($trackerdienste[0] == "0")
  err("Das Tracker Announce System ist momentan in der Wartung!");
 
new UserAgent($_SERVER["HTTP_USER_AGENT"]);

$req = "info_hash:peer_id:!ip:port:uploaded:downloaded:left:!event";
if ($GLOBALS["CLIENT_AUTH"] == CLIENT_AUTH_PASSKEY)
{
  if ($GLOBALS["PASSKEY_SOURCE"] == PASSKEY_USE_PARAM)
  {
    $req .= ":passkey";
    if (preg_match("/^([a-f0-9]{16})\\?(.*?)\\=(.*)$/is", $_GET["passkey"], $m))
    {
      $_GET["passkey"] = $m[1];
      $_GET[$m[2]] = $m[3];
    }
  }
  if ($GLOBALS["PASSKEY_SOURCE"] == PASSKEY_USE_SUBDOMAIN) {
  preg_match("/^([a-f0-9]{16})\\./i", $_SERVER["HTTP_HOST"], $m);
  if (strlen($m[1])==16)
    $passkey = $m[1];
  else
    err("Fehlender Parameter fuer Announce: passkey");
  }
}

foreach (explode(":", $req) as $x)
{
  if ($x[0] == "!")
  {
    $x = substr($x, 1);
    $opt = 1;
  }
  else
    $opt = 0;

  if (!isset($_GET[$x]))
  {
    if (!$opt)
      err("Fehlender Parameter fuer Announce: $x");

    continue;
  }
  $GLOBALS[$x] = unesc($_GET[$x]);
}

foreach (array("info_hash","peer_id") as $x)
{
  if (strlen($GLOBALS[$x]) != 20)
    err("Ungueltiger Wert fuer $x (" . strlen($GLOBALS[$x]) . " - " . urlencode($GLOBALS[$x]) . ")");
}

foreach ($GLOBALS["BAN_PEERIDS"] as $banned_id)
{
  if (substr($GLOBALS["peer_id"],0,strlen($banned_id)) == $banned_id)
    err("Du benutzt einen gebannten Client. Bitte lies das FAQ!");
}

$ip          = getip();
$origip      = $ip;
$port        = 0 + $port;
$origport    = $port;
$downloaded  = 0 + $downloaded;
$uploaded    = 0 + $uploaded;
$left        = 0 + $left;
$rsize       = 50;

foreach(array("num want", "numwant", "num_want") as $k)
{
  if (isset($_GET[$k]))
  {
    $rsize = 0 + $_GET[$k];
    break;
  }
}

$agent = $_SERVER["HTTP_USER_AGENT"];

if (ereg("^Mozilla\\/", $agent) || ereg("^Opera\\/", $agent) || ereg("^Links ", $agent) || ereg("^Lynx\\/", $agent))
  err("Dieser Torrent ist dem Tracker nicht bekannt");

if (!$port || $port > 0xffff)
  err("Ungueltiges TCP-Port");

if (!isset($event))
  $event = "";

$seeder = ($left == 0) ? "yes" : "no";

hit_count();

$res     = mysql_query("SELECT id, name, category, torrents.multiplikator, banned, free, activated, seeders + leechers AS numpeers, UNIX_TIMESTAMP(added) AS ts FROM torrents WHERE " . hash_where("info_hash", $info_hash));
$torrent = mysql_fetch_assoc($res);

if (!$torrent)
  err("Dieser Torrent ist dem Tracker nicht bekannt");

if ($torrent["activated"] != "yes")
  err("Dieser Torrent ist dem Tracker nicht bekannt");

$torrentid = $torrent["id"];
$fields    = "seeder, peer_id, ip, port, uploaded, downloaded, userid";

$numpeers  = $torrent["numpeers"];
$limit     = "";

if ($numpeers > $rsize)
  $limit = "ORDER BY RAND() LIMIT $rsize";
  
$res = mysql_query("SELECT $fields FROM peers WHERE torrent = $torrentid AND connectable = 'yes' $limit");

$resp = "d" . benc_str("interval") . "i" . $GLOBALS["ANNOUNCE_INTERVAL"] . "e" . benc_str("peers") . "l";
unset($self);
while ($row = mysql_fetch_assoc($res))
{
  $row["peer_id"] = hash_pad($row["peer_id"]);

  if ($row["peer_id"] === $peer_id)
  {
    $userid = $row["userid"];
    $self = $row;
    continue;
  }

  $resp .= "d" .
  benc_str("ip") . benc_str($row["ip"]) .
  benc_str("peer id") . benc_str($row["peer_id"]) .
  benc_str("port") . "i" . $row["port"] . "e" . "e";
}

$resp .= "ee";

$selfwhere = "torrent = $torrentid AND " . hash_where("peer_id", $peer_id);

if (!isset($self))
{
  $res = mysql_query("SELECT $fields FROM peers WHERE $selfwhere");
  $row = mysql_fetch_assoc($res);
  if ($row)
  {
    $userid = $row["userid"];
    $self = $row;
  }
}

if (!isset($self))
{
  if ($GLOBALS["CLIENT_AUTH"] == CLIENT_AUTH_PASSKEY)
  {
//    $rz = mysql_query("SELECT id, uploaded, downloaded, class, tlimitseeds, tlimitleeches, tlimitall FROM users WHERE passkey=".sqlesc(hex2bin1($passkey))." AND enabled = 'yes' ORDER BY last_access DESC LIMIT 1") or err("Tracker error 2");
    $downloaddata = $db -> querySingleArray("SELECT id, userid, torrentid FROM downloadtickets WHERE hash = ".sqlesc($passkey));
    if (!is_numeric($downloaddata['userid']))
      err("Ungueltiger PassKey. Lies das FAQ!11");
    $rz = mysql_query("SELECT id, uploaded, downloaded, class, tlimitseeds, tlimitleeches, tlimitall FROM users WHERE id=".$downloaddata['userid']) or err("Tracker error 2");
    if ($MEMBERSONLY && mysql_num_rows($rz) == 0 && $downloadid['torrentid'] != $torrentid)
      err("Ungueltiger PassKey. Lies das FAQ!22");

    mysql_query("UPDATE downloadticket SET last_action = NOW() WHERE id=".$downloaddata['id']);
  }
  else
  {
    $rz = mysql_query("SELECT id, uploaded, downloaded, class, tlimitseeds, tlimitleeches, tlimitall FROM users WHERE ip=".sqlesc($ip)." AND enabled = 'yes' ORDER BY last_access DESC LIMIT 1") or err("Tracker error 2");
    if ($MEMBERSONLY && mysql_num_rows($rz) == 0)
      err("Unbekannte IP. Lies das FAQ!");
  }

  $az = mysql_fetch_assoc($rz);
  $userid = $az["id"];

  $wait = get_wait_time($az["id"], $torrentid, FALSE, $left);
  if (($left > 0 || !$GLOBALS["ONLY_LEECHERS_WAIT"]) && $wait)
    err("Wartezeit (noch " . ($wait) . "h) - Bitte lies das FAQ!");
    
  if ($az["tlimitall"] >= 0)
  {
    $arr = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS cnt FROM peers WHERE userid=$userid"));
    $numtorrents = $arr["cnt"];
    $arr = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS cnt FROM peers WHERE userid=$userid AND seeder='yes'"));
    $seeds = $arr["cnt"];
    $leeches = $numtorrents - $seeds;
    $limit = get_torrent_limits($az);

    if (($limit["total"] > 0) &&(($numtorrents >= $limit["total"]) || ($left == 0 && $seeds >= $limit["seeds"]) || ($left > 0 && $leeches >= $limit["leeches"])))
      err("Maximales Torrent-Limit erreicht ($limit[seeds] Seeds, $limit[leeches] Leeches, $limit[total] Gesamt)");
  }

  check_ip_limit();

  $res = mysql_query("SELECT * FROM `traffic` WHERE `userid`=$userid AND `torrentid`=$torrentid");
  if (@mysql_num_rows($res) == 0)
  mysql_query("INSERT INTO `traffic` (`userid`,`torrentid`) VALUES ($userid, $torrentid)");
}
else
{
  if ($GLOBALS["CLIENT_AUTH"] == CLIENT_AUTH_PASSKEY)
  {
    $res = mysql_query("SELECT passkey,id FROM users WHERE id=$userid AND enabled = 'yes'");
    $pkrow = mysql_fetch_assoc($res);
    $passkey = hex2bin1($passkey);

    $downloaddata = $db -> querySingleArray("SELECT id, userid, torrentid FROM downloadtickets WHERE hash = ".sqlesc($_GET['passkey']));
    if (!is_numeric($downloaddata['userid']))
      err("Ungueltiger PassKey. Lies das FAQ!11");
            
    check_ip_limit();

    mysql_query("UPDATE downloadtickets SET last_action = NOW() WHERE id=".$downloaddata['id']);
  }
    
  $upthis = max(0, $uploaded - $self["uploaded"]);
  $downthis = max(0, $downloaded - $self["downloaded"]);
  $multiplikator = ($torrent["multiplikator"] == 0?1:$torrent["multiplikator"]);
  $arr = mysql_fetch_assoc(mysql_query("SELECT UNIX_TIMESTAMP(last_action) AS lastaction FROM peers WHERE $selfwhere"));
  $interval = time() - $arr["lastaction"];

  if ($interval == 0)
    $interval = 1;

  if ($upthis > 0 || $downthis > 0)
  {
    if ($self["seeder"] == "yes")
      mysql_query("UPDATE `traffic` SET `downloaded`=`downloaded`+$downthis, `uploaded`=`uploaded`+$upthis, `uploadtime`=`uploadtime`+$interval WHERE `userid`=$userid AND `torrentid`=$torrentid");
    else
      mysql_query("UPDATE `traffic` SET `downloaded`=`downloaded`+$downthis, `uploaded`=`uploaded`+$upthis, `downloadtime`=`downloadtime`+$interval,`uploadtime`=`uploadtime`+$interval WHERE `userid`=$userid AND `torrentid`=$torrentid");
      mysql_query("UPDATE users SET uploaded = uploaded + $upthis*$multiplikator". ($torrent['free']=='no'?", downloaded = downloaded + $downthis ":' '). "WHERE id=$userid") or err("Tracker error 3");
  }
}

if($seeder == "yes")
  mysql_query("UPDATE traffic SET seedtime = seedtime + " . $interval . " WHERE userid = " . $userid . " AND torrentid = " . $torrentid . " LIMIT 1");

$acctdata = mysql_fetch_assoc(mysql_query("SELECT baduser FROM accounts WHERE userid=$userid"));
if ($acctdata["baduser"]==1)
{
  $resarr = bdec($resp);
  for ($I=0; $I<count($resarr["value"]["peers"]["value"]); $I++)
  {
    $tmpip = $resarr["value"]["peers"]["value"][$I]["value"]["ip"]["value"];
    $resarr["value"]["peers"]["value"][$I]["value"]["port"]["value"] += mt_rand(100,250);
        
    $rndnum = mt_rand(1,254);
    $resarr["value"]["peers"]["value"][$I]["value"]["ip"]["value"] = preg_replace("/\\.(\\d{1,3})$/", ".$rndnum", $tmpip);
  }
  $resp = benc($resarr);
    
  $rndnum = mt_rand(1,254);
  $ip = preg_replace("/\\.(\\d{1,3})$/", ".$rndnum", $ip);
  $port += mt_rand(100,250);
}

function whitelist($agent)
{
  $arr = Array("-UT1500-", "-UT1600-", "-UT1610-", "-UT1720-", "M6-0-0", "-UT1730-", "-UT1750-", "-UT1770-", "-UT1800-", "-UT1810-", "-UT1820",-"exbc\09", "-DE0559-", "-KT2220-", "-KT2100-", "-KT21DV-", "-KT2240-", "-KT2270-" , "-HL0290-", "-lt0B70-", "-lt0B20-", "-BC0070-", "T03B", "T03D", "T03E", "T03F", "T03H", "T03I", "-TR1060-", "-AZ2502-", "-AZ2504-");
  foreach($arr as $oked)
  {
    if($oked == substr($agent,0,strlen($oked)))
      return;
  }
  err("Du benutzt einen gesperrten clienten.Siehe erlaubte clienten auf Tracker");
}

whitelist($peer_id);

function portblacklisted($port)
{
  if ($port >= 411 && $port <= 413)
    return true;
  if ($port >= 6881 && $port <= 6889)
    return true;
  if ($port == 1214)
    return true;
  if ($port >= 6346 && $port <= 6347)
    return true;
  if ($port == 4662)
    return true;
  if ($port == 6699)
    return true;
  return false;
}

$updateset = array();

if ($event == "stopped")
{
  if (isset($self))
  {
    mysql_query("DELETE FROM peers WHERE $selfwhere");
    if (mysql_affected_rows())
    {
      if ($self["seeder"] == "yes")
        $updateset[] = "seeders = seeders - 1";
      else
        $updateset[] = "leechers = leechers - 1";
    }

    $up = ($self["uploaded"]);
    $down = ($self["downloaded"]);
    mysql_query("UPDATE snatched SET seeder = 'no', last_action = NOW(), ruploaded = ruploaded + $up, rdownloaded = rdownloaded + $down where userid = '$userid' and torrentid = '$torrentid'");
  }
  mysql_query("INSERT INTO startstoplog (userid,event,`datetime`,torrent,ip,peerid,useragent) VALUES ($userid,'stop',NOW(),$torrentid,".sqlesc($_SERVER["REMOTE_ADDR"]).",".sqlesc($peer_id).",".sqlesc($agent).")");
    
  $announcedelay = @mysql_fetch_assoc(@mysql_query("SELECT * FROM `announcedelay` WHERE `peer_id`=".sqlesc($peer_id)));

  if (is_array($announcedelay))
  {
    if ($announcedelay["first"] && $announcedelay["second"] && $announcedelay["quantity"])
    {
      $duration1 = $announcedelay["second"]-$announcedelay["first"];
      $duration2 = time() - $announcedelay["second"];
      if ($duration1 < 310 && $duration2 < 10 && $uploaded - $announcedelay["quantity"] == 0)
      {
        write_modcomment($userid, 0, "announce.php: Evtl. Ratiomaker 0.5+ benutzt: ".mksize($uploaded)." Upload / ".mksize($downloaded)." Download, Fake Rate: ".mksize($uploaded / $duration1)."/sek, Delays: {$duration1}s / {$duration2}s");
      }
    }
  }
    
  $resp = benc_resp(array("failure reason" => array(type => "string", value => "Kein Fehler - Torrent gestoppt.")));
}
else
{
  if ($event == "completed")
  {
    $updateset[] = "times_completed = times_completed + 1";
    mysql_query("INSERT INTO completed (user_id, torrent_id, torrent_name, torrent_category, complete_time) VALUES ($userid, $torrentid, ".sqlesc($torrent["name"]).", ".$torrent["category"].", NOW())");
    mysql_query("INSERT INTO snatched (torrentid,userid,ruploaded,rdownloaded,seeder,completedat,finished) VALUES ($torrentid,$userid,$uploaded,$downloaded,'yes',NOW(),'yes')");
	//Torrent Download erfolgreich - Seed Bonus System
	$tfbonus = get_config_data("TFDL_SEED_BONUS");
	$tfbonus = str_replace(",", ".", $tfbonus);
	$tfbonus = floatval($tfbonus);
	mysql_query("UPDATE users SET seedbonus = seedbonus + $tfbonus WHERE id = '".intval($CURUSER["id"])."'") or sqlerr(__FILE__, __LINE__);
  }

  if (isset($self))
  {
    $announcedelay = @mysql_fetch_assoc(@mysql_query("SELECT * FROM `announcedelay` WHERE `peer_id`=".sqlesc($peer_id)));
    if (is_array($announcedelay))
    {
      if ($announcedelay["second"] == 0)
        mysql_query("UPDATE `announcedelay` SET `second`=UNIX_TIMESTAMP(),`quantity`=$uploaded WHERE `peer_id`=".sqlesc($peer_id));
    }
        
    mysql_query("UPDATE peers SET uploaded = $uploaded, downloaded = $downloaded, to_go = $left, last_action = NOW(), seeder = '$seeder'" . ($seeder == "yes" && $self["seeder"] != $seeder ? ", finishedat = " . time() : "") . " WHERE $selfwhere");
    if (mysql_affected_rows() && $self["seeder"] != $seeder)
    {
      if ($seeder == "yes")
      {
        $updateset[] = "seeders = seeders + 1";
        $updateset[] = "leechers = leechers - 1";
      }
      else
      {
        $updateset[] = "seeders = seeders - 1";
        $updateset[] = "leechers = leechers + 1";
      }
    }
  }
  else
  {
    if (portblacklisted($origport))
      err("Der TCP-Port $origport ist nicht erlaubt.");
    else
    {
      $sockres = @fsockopen($origip, $origport, $errno, $errstr, 5);
      if (!$sockres)
        $connectable = "no";
      else
      {
        $connectable = "yes";
        @fclose($sockres);
      }
    }

    $ret = mysql_query("INSERT INTO peers (connectable, torrent, peer_id, ip, port, uploaded, downloaded, to_go, started, last_action, seeder, userid, agent, uploadoffset, downloadoffset) VALUES ('$connectable', $torrentid, " . sqlesc($peer_id) . ", " . sqlesc($ip) . ", $port, $uploaded, $downloaded, $left, NOW(), NOW(), '$seeder', $userid, " . sqlesc($agent) . ", $uploaded, $downloaded)");
    if ($ret)
    {
      if ($seeder == "yes")
        $updateset[] = "seeders = seeders + 1";
      else
        $updateset[] = "leechers = leechers + 1";
    }
    mysql_query("INSERT INTO startstoplog (userid,event,`datetime`,torrent,ip,peerid,useragent) VALUES ($userid,'start',NOW(),$torrentid,".sqlesc($_SERVER["REMOTE_ADDR"]).",".sqlesc($peer_id).",".sqlesc($agent).")");
    mysql_query("INSERT INTO announcedelay (peer_id, first) VALUES (".sqlesc($peer_id).", UNIX_TIMESTAMP())");
    mysql_query("DELETE FROM announcedelay WHERE `first`<UNIX_TIMESTAMP()-900");
  }
}

if ($seeder == "yes")
{
  if ($torrent["banned"] != "yes")
    $updateset[] = "visible = 'yes'";
  $updateset[] = "last_action = NOW()";
}

if (count($updateset))
  mysql_query("UPDATE torrents SET " . join(",", $updateset) . " WHERE id = $torrentid");

benc_resp_raw($resp);
hit_end();
?>