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
require_once(dirname(__FILE__)."/include/benc.php");

dbconn();

$trackerdienste = $GLOBALS["TF_DOWNLOAD"];
if ($trackerdienste[0] == "0")
{
  stdmsg("Achtung","Torrent Dwonload ist zur Zeit deaktiviert.");
  x264_footer();
  die();
}
  
if ($GLOBALS["DOWNLOAD_METHOD"] == DOWNLOAD_REWRITE)
{
  if (!preg_match('/\\/download\\/(\d{1,10})\\/(.+)\.torrent$/', $_SERVER["REQUEST_URI"], $matches))
  {
    stderr("Ungültige Daten");
  }

  $id = intval($matches[1]);
}
else
{
  $id = intval($_GET["torrent"]);
}

if (!$id)
{
  stderr("Fehlende Daten");
}

$row = $db -> querySingleArray("SELECT name, activated FROM torrents WHERE id = ".$id);

$fn  = $GLOBALS["SHORTNAME"] ."/torrents/$id.torrent";

if (!$row || !is_file($fn) || !is_readable($fn) || $row["activated"] != "yes")
{
  stderr("Torrentfile nicht gefunden. Bitte Staff benachrichtigen");
}
    
if ($GLOBALS["MEMBERSONLY"])
{
  loggedinorreturn();

  $wait = get_wait_time($CURUSER["id"], $id);
  if ($wait > 0)
  {
    stderr("Fehler","Du hast für diesen Torrent noch Wartezeit abzuwarten.\nDu kannst erst Torrent-Dateien herunterladen, wenn die\nWartezeit abgelaufen ist!");
  }

  if($CURUSER["allowdownload"] == "no")
  {
    stderr("Fehler","Dein Torrentdownload ist deaktiviert!");
  }

  if (!check_seedtime($CURUSER["seed_angaben"]))
  {
    stderr("Fehler","Du hast deine Seedzeiten nicht angegeben!");
  }
}

$db -> execute("UPDATE torrents SET hits = hits + 1 WHERE id = ".$id);

header("Content-Type: application/x-bittorrent");
header("Content-Transfer-Encoding: binary");

if ($GLOBALS["DOWNLOAD_METHOD"] == DOWNLOAD_ATTACHMENT)
{
  $row["name"] = eregi_replace(" ",".",$row["name"]);
  $row["name"] = eregi_replace("\"","",$row["name"]);
  $row["name"] = eregi_replace("'","",$row["name"]);
  header("Pragma: private");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Content-Disposition: attachment; filename=\"".$GLOBALS["SHORTTORRENT"]."".$row["name"].".torrent\"");
}

if ($GLOBALS["CLIENT_AUTH"] == CLIENT_AUTH_PASSKEY && $GLOBALS["MEMBERSONLY"])
{
  $downloadhash = md5($CURUSER['secret'].mksecret().$CURUSER['secret']);

  $data = array(
    "hash"      => $downloadhash,
    "userid"    => $CURUSER['id'],
    "torrentid" => $id,
    "added"     => get_date_time()
  );
  
  $db -> insertRow($data,"downloadtickets");
  
  if (intval($_GET['ssl']) == 1)
  {
    $announce_url = preg_replace("/\\{KEY\\}/", $downloadhash, $GLOBALS["PASSKEY_SSL_ANNOUNCE_URL"]);
  }
  else
  {
    $announce_url = preg_replace("/\\{KEY\\}/", $downloadhash, $GLOBALS["PASSKEY_ANNOUNCE_URL"]);
  }

  $torrent = bdec_file($fn, filesize($fn));
  $torrent["value"]["announce"] = array("type" => "string", "value" => $announce_url);
  $torrent["value"]["nvuserid"] = array("type" => "integer", "value" => $CURUSER["id"]);
  $comment = "Powered by D€ Source 2018 from ".$GLOBALS["SITENAME"];
  $created = $GLOBALS["SITENAME"];
  $torrent["value"]["comment"] = array("type" => "string", "value" => $comment);
  $torrent["value"]["created by"] = array("type" => "string", "value" => $created);
  $torrentdata = benc($torrent);

  //header("Content-Length: ".strlen($torrentdata));
    
  echo $torrentdata;
}
else
{
  //header("Content-Length: ".filesize($fn));
  readfile($fn);
}
?>