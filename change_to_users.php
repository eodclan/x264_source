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
dbconn(false); 
loggedinorreturn();

check_access(UC_MODERATOR);
security_tactics();

function bark($msg)
{
  x264_header();
  stdmsg("Error", $msg);
  x264_footer();
  exit;
}

function uhrzeit($index = 0)
{
  $out ="                   <option value=\"no\" " . ((intval($index == 0)) ? "selected" : "") . ">Uhrzeit</option>\n";
  for ($i=1; $i <= 24; $i++)
    $out .= "                   <option value=\"" . $i . "\"" . ((intval($index == $i)) ? "selected" : "") . ">" . $i . ":00</option>\n";
  return $out;
}  

function get_domain($ip)
{
    $host = `host $ip`;
    $host = trim(trim(strtoupper(end ( explode (' ', $host)))),".");
    return "<a href=\"whois.php?ip=$ip\" target=\"nvwhois\">$ip</a> ($host)";
} 

function get_user_class_image($class)
{
  switch ($class)
  {
    case UC_USER:
      return "ucuser.png";
    case UC_POWER_USER:
      return "ucpoweruser.png";
    case UC_XTREMUSER:
      return "ucxuser.png";
    case UC_DJ:
      return "ucradiodj.png";
    case UC_VIP:
      return "ucvip.png";
    case UC_PARTNER:
      return "ucpartner.png";
    case UC_EHRENMITGLIED:
      return "ucehrenmitglied.png";
    case UC_UPLOADER:
      return "ucuploader.png";
    case UC_MODERATOR:
      return "ucmoderator.png";
    case UC_ADMINISTRATOR:
      return "ucadministrator.png";
    case UC_BADMIN:
      return "ucbadmin.png";
    case UC_IRC_OP:
      return "ucircop.png";
    case UC_SYSOP:
      return "ucsysop.png";
    case UC_BCODER:
      return "ucbcoder.png";
    case UC_DEV:
      return "uctech.png";
    case 127:
      return "ucowner.png";
  }
  return "";
}

if ($CURUSER)
{
//  $ss_a = @mysql_fetch_assoc(@mysql_query("SELECT `uri` FROM `design` WHERE `id`=" . $CURUSER["stylesheet"])) or sqlerr(__FILE__, __LINE__);
//  if ($ss_a) $GLOBALS["ss_uri"] = $ss_a["uri"];
}

if (!$GLOBALS["ss_uri"])
{
  ($r = mysql_query("SELECT `uri` FROM `design` WHERE `default`='yes'")) or sqlerr(__FILE__, __LINE__);
  ($a = mysql_fetch_assoc($r)) or die(mysql_error());
  $GLOBALS["ss_uri"] = $a["uri"];
}

function maketable($res)
{
  $ret = "
    <table class=table table-bordered table-striped table-condensed border=0 cellspacing=1 cellpadding=4 width=\"100%\">
      <tr>
        <td class=tablecat align=center>Typ</td>
        <td class=tablecat width=\"100%\">Name</td>
        <td class=tablecat align=center>TTL</td>
        <td class=tablecat align=center>Größe</td>
        <td class=tablecat align=right>Se.</td>
        <td class=tablecat align=right>Le.</td>
        <td class=tablecat align=center>Hochgel.</td>
        <td class=tablecat align=center>Runtergel.</td>
        <td class=tablecat align=center>Ratio</td>
      </tr>";

  while ($arr = mysql_fetch_assoc($res))
  {
    if ($arr["downloaded"] > 0)
    {
      $ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3);
      $ratio = "<font color=" . get_ratio_color($ratio) . ">$ratio</font>";
    }
    else
      if ($arr["uploaded"] > 0)
        $ratio = "Inf.";
      else
        $ratio = "---";

    $catimage = htmlspecialchars($arr["image"]);
    $catname = htmlspecialchars($arr["catname"]);

    $ttl = (28 * 24) - floor((time() - sql_timestamp_to_unix_timestamp($arr["added"])) / 3600);

    if ($ttl == 1)
      $ttl .= "<br>hour";
    else
      $ttl .= "<br>hours";

    $size = str_replace(" ", "<br>", mksize($arr["size"]));
    $uploaded = str_replace(" ", "<br>", mksize($arr["uploaded"]));
    $downloaded = str_replace(" ", "<br>", mksize($arr["downloaded"]));
    $seeders = number_format($arr["seeders"]);
    $leechers = number_format($arr["leechers"]);
    $smallname2 =substr(htmlspecialchars($arr["torrentname"]) , 0, 30);

    if ($smallname2 != htmlspecialchars($arr["torrentname"]))
      $smallname2 .= '...';

    $ret .= "
      <tr>
        <td class=table table-bordered table-striped table-condensed style='padding: 0px'><img src=\"/pic" .$catimage . "\" alt=\"$catname\" title=\"$catname\" width=50 height=50></td>
        <td class=tablea><a href=details.php?id=$arr[torrent]&amp;hit=1><b>$smallname2</b></a></td>
        <td class=table table-bordered table-striped table-condensed align=center>$ttl</td><td class=tablea align=center>$size</td>
        <td class=table table-bordered table-striped table-condensed align=right>$seeders</td><td class=tablea align=right>$leechers</td>
        <td class=table table-bordered table-striped table-condensed align=center>$uploaded</td>
        <td class=tablea align=center>$downloaded</td>
        <td class=table table-bordered table-striped table-condensed align=center>$ratio</td></tr>";

  }
  $ret .= "
      </tr>
    </table>";
  return $ret;
} 

function makegroups($res)
{
  $ret = "";
  while ($arr = mysql_fetch_assoc($res))
  {
    $grpName=$arr["name"];
    $ret .= "
        <tr><td class='table table-bordered table-striped table-condensed'><center><b>$grpName</b><br>".($arr["banner"]?"<img src=\"$arr[banner]\" alt=\"$catname\" title=\"$catname\" border=0>":"")."</center></td></tr>";
  }
  $ret .= "\n";
  return $ret;
} 

function makecomptable($res)
{
  global $user;
  $ret="";
  $ret= "
    <table class=table table-bordered table-striped table-condensed border=0 cellspacing=1 cellpadding=4 width=\"100%\">
      <tr>
        <td class=tablecat style=\"text-align:center\"><font color=white><b>Hier siehst du welche Files du noch Seeden musst, und welche du bereits entfernen kannst!!</b></font></td>
          <table class=tablea border=0 cellspacing=1 cellpadding=4 width=\"100%\">
            <tr>
              <td class=tablea style=\"text-align:center\"><b>Wurde ausreichend geseedet<img src= pic/seedok.png></b></td>
              <td class=tablea style=\"text-align:center\"><b>Ist noch zu seeden <img src= pic/seedno.png></b></td>
              <td bgcolor=green style=\"text-align:center\"><b>Seedest du im Moment</b></td>
              <td bgcolor=red   style=\"text-align:center\"><b>Seedest du nicht</b></td>
              <table class=table table-bordered table-striped table-condensed border=0 cellspacing=1 cellpadding=4 width=\"100%\">
              <tr><td class=tablecat style=\"text-align:center\">Typ</td>
              <td class=tablecat width=\"100%\">Name</td>
              <td class=tablecat>Fertiggestellt</td>
              <td class=tablecat>Se.</td>
              <td class=tablecat>Le.</td>
              <td class=tablecat>Hochgel.</td>
              <td class=tablecat>Runtergel.</td>
              <td class=tablecat>Seeddauer</td>
              <td class=tablecat>Ratio</td>
              <td class=tablecat>&nbsp;</td>
            </tr>";

  while ($arr = mysql_fetch_assoc($res))
  {
    if ($arr["downloaded"] > 0)
      $ratio = $arr["uploaded"] / $arr["downloaded"];
    else
      if ($arr["uploaded"] > 0)
        $ratio = "Inf.";
      else
        $ratio = "---";

    $time = FormatTimeDiff(1, $arr["seedtime"], 'dhms');
    $time = (($time["d"] == 1) ? $time["d"] . " Tag " : $time["d"] . " Tage ") . (($time["h"] <= 9) ? "0" . $time["h"] : $time["h"]) . ":" . (($time["m"] <= 9) ? "0" . $time["m"] : $time["m"]) . ":" . (($time["s"] <= 9) ? "0" . $time["s"] : $time["s"]);
    $catimage = htmlspecialchars($arr["image"]);
    $catname = htmlspecialchars($arr["catname"]);
    $ret .= "
            <tr>
              <td class=\"table table-bordered table-striped table-condensed\" style=\"padding: 0px\"><img src=\"/pic" . $catimage . "\" alt=\"$catname\" title=\"$catname\" width=42 height=42></td>";

    if ($arr["torrent_origid"] > 0)
    {
      $seeders = number_format($arr["seeders"]);
      $leechers = number_format($arr["leechers"]);

      if (strlen($arr["torrent_name"]) > 45)
        $displayname = substr($arr["torrent_name"], 0, 45) . "...";
      else
        $displayname = $arr["torrent_name"];

      $ret .= "
              <td class=\"tablea\" nowrap><a href=\"details.php?id=$arr[torrent]\"><b>" . htmlspecialchars($displayname) . "</b></a></td>
              <td class=\"table table-bordered table-striped table-condensed\" style=\"text-align:center\">" . str_replace(" ", "<br />", date("d.m.Y H:i:s", sql_timestamp_to_unix_timestamp($arr["complete_time"]))) . "</td>
              <td class=\"tablea\" style=\"text-align:right\">$seeders</td>
              <td class=\"table table-bordered table-striped table-condensed\" style=\"text-align:right\">$leechers</td>
              <td class=\"tablea\" style=\"text-align:right\" nowrap=\"nowrap\">" . mksize($arr["uploaded"]) . "<br>@ " . mksize($arr["uploaded"] / max(1, $arr["uploadtime"])) . "/s</td>
              <td class=\"table table-bordered table-striped table-condensed\" style=\"text-align:right\" nowrap=\"nowrap\">" . mksize($arr["downloaded"]) . "<br>@ " . mksize($arr["downloaded"] / max(1, $arr["downloadtime"])) . "/s</td>
              <td class=\"tablea\" style=\"text-align:left\"><font color='".($arr["onlyupload"]=="yes"?($arr["seedtime"]>604800?"green":"red"):($arr["seedtime"]>172800?"green":"red"))."'>".$time."</font></td>
              <td class=\"table table-bordered table-striped table-condensed\" style=\"text-align:right\"><font color=" . get_ratio_color($ratio).">".number_format($ratio, 3)."</font></td>";

      $qry = mysql_query("SELECT * FROM peers WHERE torrent='$arr[torrent]' AND userid='$user[id]'") or print(mysql_error());
      $ret .= "
              <td bgcolor=".(mysql_num_rows($qry)>0?"green":"red")."><img border='0' src='pic/".($arr["free"]=="yes"?($arr["seedtime"]>604800?"seedok.png' title='Ausreichend geseedet!'":($ratio>1?"seedok.png' title='Ausreichend geseedet!'":"seedno.png' title='Nicht ausreichend geseedet!'")):($arr["seedtime"]>172800?"seedok.png' title='Ausreichend geseedet!'":($ratio>0.7?"seedok.png' title='Ausreichend geseedet!'":"seedno.png' title='Nicht ausreichend geseedet!'")))."></td>
            </tr>";
    }
    else
    {
      $ret .= "
              <td class=\"tablea\" nowrap><b>" . htmlspecialchars($arr["torrent_name"]) . "</b></td>
              <td class=\"table table-bordered table-striped table-condensed\" style=\"text-align:center\">" . str_replace(" ", "<br />", date("d.m.Y H:i:s", sql_timestamp_to_unix_timestamp($arr["complete_time"]))) . "</td>
              <td class=\"tablea\" style=\"text-align:center\" colspan=\"4\">Gelöscht</td></tr>\n";
    }
  }

  $ret .= "
            </tr>
          </table>";
  return $ret;
}

$id = intval($_GET["id"]);

if (!is_valid_id($id))
  $id = $CURUSER['id'];

$r = @mysql_query("SELECT * FROM users WHERE id=$id") or sqlerr(__FILE__, __LINE__);
$user = mysql_fetch_array($r) or bark("No user with ID $id.");

if ($user["status"] == "pending")
  die;
  
$r = mysql_query("SELECT id, name, seeders, leechers, category FROM torrents WHERE owner=$id ORDER BY name") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($r) > 0)
{
  $torrents = "
      <table class=\"coltable\" cellspacing=\"1\" cellpadding=\"5\">
        <tr>
          <td class=\"colhead\">Type</td>
          <td class=\"colhead\">Name</td>
          <td class=\"colhead\">Seeders</td>
          <td class=\"colhead\">Leechers</td>
        </tr>";
              
  while ($a = mysql_fetch_assoc($r))
  {
		$r2 = mysql_query("SELECT name, image FROM categories WHERE id=$a[category]") or sqlerr(__FILE__, __LINE__);
		$a2 = mysql_fetch_assoc($r2);
		$cat = "<img src=\"pic/$a2[image]\" alt=\"$a2[name]\"/>";
    $torrents .= "
        <tr>
          <td class=\"tablea\">$cat</td>
          <td class=\"tablea\"><a href=\"details.php?id=" . $a["id"] . "&amp;hit=1\"><b>" . htmlspecialchars($a["name"]) . "</b></a></td>
          <td class=\"tablea\" align=\"right\">$a[seeders]</td>
          <td class=\"tablea\" align=\"right\">$a[leechers]</td>
        </tr>";
  }
  $torrents .= "
        </table>";
}

$addr = "";
$peer_addr = "";
if ($user["ip"] && (get_user_class() >= UC_MODERATOR || $user["id"] == $CURUSER["id"]))
{
  $ip = $user["ip"];
  $addr = get_domain($ip);

  $res = mysql_query("SELECT DISTINCT(ip) AS ip FROM peers WHERE userid=$id") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($res))
  {
    while ($peer_ip = mysql_fetch_assoc($res))
    {
      if ($peer_addr != "")
        $peer_addr .= "<br>";
      $peer_addr .= get_domain($peer_ip["ip"]);
    }
  }
}
 
if ($user[added] == "0000-00-00 00:00:00")
  $joindate = 'N/A';
else
  $joindate = "$user[added] (Vor " . get_elapsed_time(sql_timestamp_to_unix_timestamp($user["added"])) . " )";

$lastseen = $user["last_access"];

if ($lastseen == "0000-00-00 00:00:00")
  $lastseen = "never";
else
  $lastseen .= " (Vor " . get_elapsed_time(sql_timestamp_to_unix_timestamp($lastseen)) . " )";

$res = mysql_query("SELECT COUNT(*) FROM comments WHERE user=" . $user[id]) or sqlerr(__FILE__, __LINE__);
$arr3 = mysql_fetch_row($res);
$torrentcomments = $arr3[0];
$res = mysql_query("SELECT COUNT(*) FROM posts WHERE userid=" . $user[id]) or sqlerr(__FILE__, __LINE__);
$arr3 = mysql_fetch_row($res);
$forumposts = $arr3[0];

$res = mysql_query("SELECT name,flagpic FROM countries WHERE id=$user[country] LIMIT 1") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) == 1)
{
  $arr = mysql_fetch_assoc($res);
  $country = "<td class=\"embedded\"><img src=\"pic/flag/$arr[flagpic]\" alt=\"$arr[name]\" style='margin-left: 8pt'/></td>";
}

$res = mysql_query("SELECT torrent,added,uploaded,downloaded,torrents.name as torrentname,categories.name as catname,size,image,category,seeders,leechers FROM peers LEFT JOIN torrents ON peers.torrent = torrents.id LEFT JOIN categories ON torrents.category = categories.id WHERE userid=$id AND seeder='no'") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) > 0)
$leeching = "";

if (!$_GET["allleech"])
  $limit_leech = "";
else
  $limit_leech = "";

$res = mysql_query("SELECT torrent,added,traffic.uploaded,traffic.downloaded,torrents.name as torrentname,categories.name as catname,size,image,category,seeders,leechers FROM peers JOIN traffic ON peers.userid = traffic.userid AND peers.torrent = traffic.torrentid JOIN torrents ON peers.torrent = torrents.id JOIN categories ON torrents.category = categories.id WHERE peers.userid=$id AND seeder='no'$limit_leech") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) > 0)
  $leeching = maketable($res);


$seeding = "";
if (!$_GET["allseed"])
  $limit_seed = "";
else
  $limit_seed = "";

$res = mysql_query("SELECT torrent,added,traffic.uploaded,traffic.downloaded,torrents.name as torrentname,categories.name as catname,size,image,category,seeders,leechers FROM peers JOIN traffic ON peers.userid = traffic.userid AND peers.torrent = traffic.torrentid JOIN torrents ON peers.torrent = torrents.id JOIN categories ON torrents.category = categories.id WHERE peers.userid=$id AND seeder='yes'$limit_seed") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) > 0)
  $seeding = maketable($res);

if (!$_GET["alluploads"])
  $limit_uploads = "";
else
  $limit_uploads = "";

$r = mysql_query("SELECT id, name, added, seeders, leechers, category FROM torrents WHERE `activated`='yes' AND owner=$id ORDER BY added DESC$limit_uploads") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($r) > 0)
{
  $torrents = "
    <table class=table table-bordered table-striped table-condensed border=0 cellspacing=1 cellpadding=4 width=\"100%\">
      <tr>
        <td class=tablecat>Typ</td>
        <td class=tablecat width=\"100%\">Name</td>
        <td class=tablecat>Hochgeladen</td>
        <td class=tablecat>Seeder</td>
        <td class=tablecat>Leecher</td>
      </tr>";
      
  while ($a = mysql_fetch_assoc($r))
  {
    $r2 = mysql_query("SELECT name, image FROM categories WHERE id=$a[category]") or sqlerr(__FILE__, __LINE__);
    $a2 = mysql_fetch_assoc($r2);
    $cat = "<img src=\"/pic" . $a2["image"] . "\" alt=\"$a2[name]\" title=\"$a2[name]\">";
    $smallname3 =substr(htmlspecialchars($a["name"]) , 0, 30);

    if ($smallname3 != htmlspecialchars($a["name"]))
      $smallname3 .= '...';
    $torrents .= "
      <tr>
        <td class=table table-bordered table-striped table-condensed style='padding: 0px'>$cat</td>
        <td class=tablea><a href=details.php?id=" . $a["id"] . "&hit=1><b>$smallname3</b></a></td>
        <td class=table table-bordered table-striped table-condensed align=center>" . str_replace(" ", "<br />", date("d.m.Y H:i:s", sql_timestamp_to_unix_timestamp($a["added"]))) . "</td>
        <td class=tablea align=right>$a[seeders]</td>
        <td class=table table-bordered table-striped table-condensed align=right>$a[leechers]</td>
      </tr>";
  }
  $torrents .= "
    </table>";
} 

$completed = "";

if (get_user_class() >= UC_MODERATOR || (isset($CURUSER) && $CURUSER["id"] == $user["id"]))
{
  if (!$_GET["allcompleted"])
    $limit_comp = " ";
  else
    $limit_comp = "";

  $res = mysql_query("SELECT torrent_id as torrent,torrent_name,complete_time,torrents.seeders as seeders,torrents.leechers as leechers,torrents.id as torrent_origid,categories.name as catname,image,traffic.uploaded,traffic.downloaded,traffic.seedtime,traffic.uploadtime,traffic.downloadtime FROM completed LEFT JOIN traffic ON completed.torrent_id = traffic.torrentid AND completed.user_id = traffic.userid LEFT JOIN torrents ON completed.torrent_id = torrents.id LEFT JOIN categories ON completed.torrent_category = categories.id WHERE user_id=$id ORDER BY complete_time DESC $limit_comp") or sqlerr(__FILE__, __LINE__);

  if (mysql_num_rows($res) > 0)
    $completed = makecomptable($res);
} 

$grpres = mysql_query("select teams.* from teams,teammembers where teams.id=teammembers.teamid and teammembers.userid=$user[id] order by teams.sort") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($grpres) > 0)
  $groups = makegroups($grpres);

if($user["id"]!=$CURUSER["id"])
{
  $grpsel="";
  $grpres=mysql_query("select teams.* from teams,teammembers where teams.id=teammembers.teamid and teammembers.userid=$CURUSER[id] and teammembers.leader='yes' order by teams.sort") or sqlerr(__FILE__, __LINE__);
  while($grparr=mysql_fetch_assoc($grpres))
  {
    $grp2=mysql_fetch_row(mysql_query("select count(id) from teammembers where teamid=$grparr[id] and userid=$user[id]")) or sqlerr(__FILE__, __LINE__);
    if($grp2[0]==0)
      $grpsel.="<option value=\"$grparr[id]\">$grparr[name]-".ucfirst($grparr["typ"])."</option>";
  }
  if($grpsel!="")
    $grpsel="<select name=\"group\"><option value=\"0\">---[ Bitte ausw&auml;hlen ]---</option>$grpsel</select>";
  else
    unset($grpsel);
}

$enabled        = $user["enabled"] == 'yes';
$webseed        = $user["webseed"] == 'yes';
$adsl           = $user["adsl"] == 'yes';
$vdsl           = $user["vdsl"] == 'yes';
$shoutpost      = $user["shoutpost"] == 'yes';
$curshoutpost   = $arr["shoutpost"];
$acceptrules    = $user["accept_rules"] == 'no';
$allowupload    = $user["allowupload"] == 'yes';
$allowdownload  = $user["allowdownload"] == 'yes';
$beobachtung    = $user["beobachtung"];
$beobachtet_von = $user["beobachtet_von"];
$shoutpost      = $user["shoutpost"] == 'yes';
$enabled        = $user["enabled"] == 'yes';

$accsql         = "SELECT `baduser` FROM `accounts` WHERE `userid`=$id";
$accres         = mysql_query($accsql) or sqlerr(__FILE__, __LINE__."<hr>".$sql);
$acctdata       = mysql_fetch_assoc($accres);
$baduser        = $acctdata["baduser"];

x264_header("Details for " . $user["username"]);




//////////////////////
//                  //
// Mod Task Bereich //
//                  //
//////////////////////

if ((get_user_class() >= UC_MODERATOR && $user["class"] < get_user_class()) || $CURUSER['id'] == 18815 || get_user_class() == 127)
{
  $trackerconfig = explode("|",htmlentities(trim(get_config_data('TRACKERCONF'))));
  if ($trackerconfig[3] == "off")
    stdmsg("Achtung","Profilbearbeiten ist zur Zeit deaktiviert. Änderungen werden nicht gespeichert!!");
  
  print "
<script type=\"text/javascript\">
  function togglediv()
  {
    var mySelect = document.getElementById('tselect');
    var myDiv = document.getElementById('tlimitdiv');

    if (mySelect.options[mySelect.selectedIndex].value == \"manual\")
        myDiv.style.visibility = 'visible';
    else
        myDiv.style.visibility = 'hidden';
  }
  function togglepic(picid, formid)
  {
    var pic = document.getElementById(picid);
    var form = document.getElementById(formid);
    
    if(form.value == 'plus')
    {
        pic.src = '/pic/minus.gif';
        form.value = 'minus';
    }else{
        pic.src = 'pic/plus.gif';
        form.value = 'plus';
    }
  }
  function pcenterdiv()
  {
    var mySelect = document.getElementById('class');
    var myDiv    = document.getElementById('pcenter');

    if (mySelect.options[mySelect.selectedIndex].value == ".UC_PARTNER.")
        myDiv.style.display = 'inline';
    else
        myDiv.style.display = 'none';
  }
</script>";

  $bbfilecount = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS cnt FROM bitbucket WHERE user=$id"));

  $resteams=mysql_query("select * from teams order by sort");
  $selectgroup="";
  while($teams=mysql_fetch_assoc($resteams))
    $selectgroup.="<option value=$teams[id]>$teams[name] (".ucfirst($teams[typ]).")</option>";

  if($selectgroup)
    $selectgroup="<select name=team><option value=0>Kein Team</option>$selectgroup</select>";
    
  $resteams=mysql_query("select * from teams order by sort");
  $selectgroup="";
  while($teams=mysql_fetch_assoc($resteams))
    $selectgroup.="<option value=$teams[id]>$teams[name] (".ucfirst($teams[typ]).")</option>";

  if($selectgroup)
    $selectgroup="<select name=team><option value=0>Kein Team</option>$selectgroup</select>";

  $res = mysql_query("SELECT msg,name,torrent_id,`status` FROM nowait LEFT JOIN torrents ON torrents.id=torrent_id WHERE user_id=$id");

  $avatar = htmlspecialchars($user["avatar"]);
  $info = htmlspecialchars($user["info"]);

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-user'></i> Benutzerprofil von: " . htmlspecialchars($user[username]) . " bearbeiten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
  print "
<table cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:90%\" class=\"table table-bordered table-striped table-condensed\">
  <tr>
    <td width=\"100%\" class=\"tablea\">
      <form method=\"post\" action=\"change_to_users_staff_done_acp.php\">
        <input type=\"hidden\" name=\"action\" value=\"edituser\">
        <input type=\"hidden\" name=\"userid\" value='$id'>
        <input type=\"hidden\" name=\"returnto\" value='change_to_users.php?id=$id'>
        <table class=\"table table-bordered table-striped table-condensed\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">
          <tr>
            <td class=table table-bordered table-striped table-condensed>Username ändern</td>
            <td class=tablea colspan=2 align=left><input type=text size=52 name=username class='btn btn-flat btn-primary fc-today-button text-left' value=\"" . htmlspecialchars($user[username]) . "\">
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Titel</td>
            <td class=tablea colspan=2 align=left><input type=text size=60 name=title class='btn btn-flat btn-primary fc-today-button text-left' value=\"" . htmlspecialchars($user[title]) . "\">
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Secure Code</td>
            <td class=tablea colspan=2 align=left><input name=\"secure_code\" class='btn btn-flat btn-primary fc-today-button text-left' type=text value=$user[secure_code]></td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Avatar&nbsp;URL</td>
            <td class=tablea colspan=2 align=left><input type=text size=60 name=avatar class='btn btn-flat btn-primary fc-today-button text-left' value=\"$avatar\">
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>User&nbsp;Info</td>
            <td class=tablea colspan=2 align=left><textarea cols=60 rows=6 name=info class='btn btn-flat btn-primary fc-today-button text-left'>$info</textarea></td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>E-mail ändern</td>
            <td class=tablea colspan=2 align=left><input type=text size=52 class='btn btn-flat btn-primary fc-today-button text-left' name=email value=\"" . htmlspecialchars($user[email]) . "\">
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Passwort ändern</td>
            <td class=tablea colspan=2 align=left><input type=\"password\" class='btn btn-flat btn-primary fc-today-button text-left' name=\"chpassword\" size=\"52\" /></td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Passwort wdh.  </td>
            <td class=tablea colspan=2 align=left><input type=\"password\" class='btn btn-flat btn-primary fc-today-button text-left' name=\"passagain\" size=\"52\" /></td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Start/Stop&nbsp;Events</td>
            <td class=tablea colspan=2 align=left><a href=\"startstoplog.php?op=user&amp;uid=" . $user["id"] . "\" class='btn btn-flat btn-primary fc-today-button text-left'>Ereignisse anzeigen</a></td>
          </tr>";
        
  if ($bbfilecount["cnt"])
    print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>BitBucket</td><td class=tablea colspan=2 align=left>
              <a href=\"bitbucket.php?id=$id\" class='btn btn-flat btn-primary fc-today-button text-left'>BitBucket-Inhalt dieses Benutzers anzeigen / bearbeiten</a> (" . $bbfilecount["cnt"] . " Datei(en))
            </td>
          </tr>";

  if ($CURUSER["class"] < UC_DEV)

  if($user["class"]<get_user_class()||get_user_class()>=UC_DEV)
    print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>Anonym</td>
            <td class=tablea colspan=2 align=left>
              <input type=checkbox name=anon value=yes" . ($user["anon"] == "yes" ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'> Wird bei den Torrents als Anonym aufgelistet
            </td>
          </tr>";

  if($selectgroup)
    print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>Groupzuweisung</td>
            <td class=tablea colspan=2 align=left>$selectgroup</td>
          </tr>";
   
  if (get_user_class() == UC_MODERATOR && $user["class"] > UC_UPLOADER)
    print "
          <input type=hidden name=class value=$user[class]";
  else
  {
    print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>Klasse</td>
            <td class=tablea colspan=2 align=left>
              <select name=class id=class onchange=\"pcenterdiv();\" class='btn btn-flat btn-primary fc-today-button text-left'>";
    if ($CURUSER['id'] == 711)
      $maxclass = UC_DEV;
    elseif (get_user_class() == UC_MODERATOR)
      $maxclass = UC_PROMOTER;
    elseif (get_user_class() == UC_SYSOP)
      $maxclass = UC_SYSOP;
    else
      $maxclass = get_user_class() - 1;

    for ($i = 0; $i <= $maxclass; ++$i)
      if (get_user_class_name($i) != "")
        print "
                <option value=$i" . ($user["class"] == $i ? " selected" : "") . ">$prefix" . get_user_class_name($i)."</option>";
    print "
              </select>";


    print "
            </td>
          </tr>";
  }


  print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>Torrentbegrenzung</td>
            <td class=tablea colspan=2 align=left>
              <select id=\"tselect\" name=\"limitmode\" size=\"1\" onchange=\"togglediv();\" class='btn btn-flat btn-primary fc-today-button text-left'>
                <option value=\"auto\"" . ($user["tlimitall"] == 0?" selected=\"selected\"":"") . ">Automatisch</option>
                <option value=\"unlimited\"" . ($user["tlimitall"] == -1?" selected=\"selected\"":"") . ">Unbegrenzt</option>
                <option value=\"manual\"" . ($user["tlimitall"] > 0?" selected=\"selected\"":"") . ">Manuell</option>
              </select>
              <div id=\"tlimitdiv\" style=\"display: inline;" . ($user["tlimitall"] <= 0?"visibility:hidden;":"") . "\" class='btn btn-flat btn-primary fc-today-button text-left'>&nbsp;&nbsp;&nbsp;
                Seeds: <input type=\"text\" size=\"2\" maxlength=\"2\" name=\"maxseeds\" value=\"" . ($user["tlimitseeds"] > 0?$user["tlimitseeds"]:"") . "\">
                Leeches: <input type=\"text\" size=\"2\" maxlength=\"2\" name=\"maxleeches\" value=\"" . ($user["tlimitleeches"] > 0?$user["tlimitleeches"]:"") . "\">
                Gesamt: <input type=\"text\" size=\"2\" maxlength=\"2\" name=\"maxtotal\" value=\"" . ($user["tlimitall"] > 0?$user["tlimitall"]:"") . "\">
              </div>
            </td>
          </tr>";

  $res = mysql_query("SELECT msg,name,torrent_id,`status` FROM nowait LEFT JOIN torrents ON torrents.id=torrent_id WHERE user_id=$id");
  if (mysql_num_rows($res))
  {
    print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>Wartezeit&nbsp;aufheben</td>
            <td class=tablea colspan=2 align=left>
              <table class=table table-bordered table-striped table-condensed border=0 cellspacing=1 cellpadding=4 width=\"100%\">
                <tr>
                  <td class=tablea width=\"100%\">Torrent / Grund</td>
                  <td class=tablea>Status</td>
                </tr>";
    while ($arr = mysql_fetch_assoc($res))
    {
      print "
                <tr>
                  <td>
                    <p><b><a href=\"details.php?id=$arr[torrent_id]\">" . htmlspecialchars($arr["name"]) . "</a></b></p>
                    <p>" . htmlspecialchars($arr["msg"]) . "
                  </td>";
      if ($arr["status"] == "pending")
      {
        print "
                  <td valign=\"middle\" nowrap=\"nowrap\">
                    <input type=\"radio\" name=\"wait[$arr[torrent_id]]\" value=\"yes\"" . ($arr["status"] == "granted"?" checked=\"checked\"":"") . "> Akzeptieren<br>
                    <input type=\"radio\" name=\"wait[$arr[torrent_id]]\" value=\"no\"" . ($arr["status"] == "rejected"?" checked=\"checked\"":"") . "> Ablehnen<br>
                    <input type=\"radio\" name=\"wait[$arr[torrent_id]]\" value=\"\"" . ($arr["status"] == "pending"?" checked=\"checked\"":"") . "> Nichts tun
                  </td>
                </tr>";
      }
      else
        print "
                  <td valign=\"middle\" align=\"center\">" . ($arr["status"] == "granted"?"Akzeptiert":"Abgelehnt") . "</td>
                </tr>";
    }
    print "
              </table>
            </td>
          </tr>";
  }

  if (get_user_class() >= UC_ADMINISTRATOR)
  {
    print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>Upload ändern</td>
            <td class=tablea align=center>
              <img src='/pic/plus.gif' id=uppic onClick=togglepic('uppic','upchange')>
              <input type=text name=amountup size=10 class='btn btn-flat btn-primary fc-today-button text-left'>
            </td>
            <td class=tablea>
              <select name=formatup class='btn btn-flat btn-primary fc-today-button text-left'>
                <option value=mb>MB</option>
                <option value=gb>GB</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Download ändern</td>
            <td class=tablea align=center>
              <img src='/pic/plus.gif' id=downpic onClick=togglepic('downpic','downchange')>
              <input type=text name=amountdown size=10 class='btn btn-flat btn-primary fc-today-button text-left'>
            </td>
            <td class=tablea>
              <select name=formatdown class='btn btn-flat btn-primary fc-today-button text-left'>
                <option value=mb>MB</option>
                <option value=gb>GB</option>
              </select>
            </td>
          </tr>";
  }
  
  print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>Webseeder</td>
            <td class=tablea colspan=2 align=left>
              <input type=checkbox name=webseed value=yes" . ($user["webseed"] == "yes" ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'> Dieser User ist ein Webseeder
            </td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Kommentare</td>
            <td class=tablea colspan=2 align=left>
              <div style=\"width:100%;height:150px;overflow:auto;\">
                <table class=\"table table-bordered table-striped table-condensed\" width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">
                  <tr>
                    <td class=tablecat colspan=10>
                      <center><b>Mod-Kommentare von ".htmlspecialchars($user["username"])."</b></center>
                    </td>
                  </tr>
                  <tr>
                    <td class=tablea>Datum</td>
                    <td class=tablea>Von</td>
                    <td class=tablea>Kommentar</td>";
  if (get_user_class() >= UC_SYSOP)
    print "
                    <td class=tablea>Löschen</td>";
  print "
                  </tr>";
              
  $modcommentres = mysql_query("SELECT `modcomments`.`id`,`modcomments`.`added`,`modcomments`.`userid`,`modcomments`.`moduid`,`modcomments`.`txt`,`users`.`username` FROM `modcomments` LEFT JOIN `users` ON `users`.`id`=`modcomments`.`moduid` WHERE `userid`=$id ORDER BY `added` DESC");
  while ($comment = mysql_fetch_assoc($modcommentres))
  {
    $comment["added"] = str_replace(" ", "&nbsp;", $comment["added"]);
    print "
                  <tr>
                    <td class=table table-bordered table-striped table-condensed valign=\"top\">".$comment["added"]."</td>
                    <td class=table table-bordered table-striped table-condensed valign=\"top\">";
    if ($comment["moduid"] == 0 || $comment["moduid"] == 1)
      print "System";
    elseif ($comment["username"] == "")
      print "<i>Gelöscht</i>";
    else
      print "<a href=\"userdetails.php?id=".$comment["moduid"]."\">".$comment["username"]."</a>";
    print "</td>
                    <td class=table table-bordered table-striped table-condensed valign=\"top\">".format_comment(stripslashes($comment["txt"]))."</td>";
    if (get_user_class() >= UC_SYSOP)
      print "
                    <td bgcolor=#FF0000><center><input type=\"checkbox\" name=\"delmodcom[]\" value=\"".$comment["id"]."\" /></center></td>
                  </tr>";
  }

  if (mysql_num_rows($modcommentres) == 0)
    print "
                  <tr>
                    <td class=table table-bordered table-striped table-condensed colspan=\"5\" style=\"text-align:left;vertical-align:middle;\"><center>Keine Mod-Kommentare Vorhanden</center></td>
                  </tr>";
  print "
                </table>
              </div>
              <br>Hinzufügen:&nbsp;&nbsp;<input type=\"text\" size=\"50\" name=\"modcomment\" class='btn btn-flat btn-primary fc-today-button text-left'>
            </td>
          </tr>";

  $warned = $user["warned"] == "yes";
  print "
          <tr>
            <td class=table table-bordered table-striped table-condensed " . (!$warned ? " rowspan=4": " rowspan=3") . ">Verwarnt</td>
            <td class=tablea align=left width=20%>
              " . ($warned ? "
              <input name=warned value='yes' type=radio checked class='btn btn-flat btn-primary fc-today-button text-left'>Ja
              <input name=warned value='no' type=radio class='btn btn-flat btn-primary fc-today-button text-left'>Nein" :
              "Noch nicht verwarnt") . "
            </td>";

  if ($warned)
  {
    $warneduntil = $user['warneduntil'];
    if ($warneduntil == '0000-00-00 00:00:00')
      print "
            <td class=tablea align=center>(willkürliche Dauer)</td>
          </tr>";
    else
    {
      print "
            <td class=tablea align=center>Bis $warneduntil (noch " . mkprettytime(strtotime($warneduntil) - time()) . ")</td>
          </tr>";
    }
  }
  else
  {
    print "
            <td class=tablea>Verwarnen für
              <select name=warnlength class='btn btn-flat btn-primary fc-today-button text-left'>
                <option value=0>------</option>
                <option value=1>1 Woche</option>
                <option value=2>2 Wochen</option>
                <option value=3>3 Wochen</option>
                <option value=4>4 Wochen</option>
                <option value=8>8 Wochen</option>
                <option value=255>Unbefristet</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class=tablea colspan=2 align=left>
              PM Kommentar (BBCode erlaubt):<br>
              <textarea cols=\"60\" rows=\"4\" name=\"warnpm\" class='btn btn-flat btn-primary fc-today-button text-left'></textarea><br>
              <input id=\"addwarnratio\" type=\"checkbox\" name=\"addwarnratio\" value=\"yes\">
              <label for=\"addwarnratio\">&nbsp;Ratiostats zu Mod-Kommentar hinzufügen</label>
            </td>
          </tr>";
  }

  $elapsedlw = get_elapsed_time(sql_timestamp_to_unix_timestamp($user["lastwarned"]));
  print "
          <tr>
            <td class=tablea>Anzahl Verwarnungen</td>
            <td class=tablea align=left>$user[timeswarned]</td>
          </tr>";

  if ($user["timeswarned"] == 0)
    print "
          <tr>
            <td class=tablea >Zuletzt verwarnt</td>
            <td class=tablea align=left>Bis jetzt nicht.</td>
          </tr>";
  else
  {
    if ($user[warnedby] != "System")
    {
      $res = mysql_query("SELECT id, username FROM users WHERE id =".$user[warnedby]."") or sqlerr(__FILE__,__LINE__);
      $arr = mysql_fetch_assoc($res);
      $warnedby = "[by <u><a href=userdetails.php?id=".$arr['id'].">".$arr['username']."]</u>";
    }
    else
      $warnedby = "[by System]";

    print "
          <tr>
            <td class=tablea>Zuletzt verwarnt</td>
            <td class=tablea align=left>$user[lastwarned]&nbsp;($elapsedlw&nbsp;her)&nbsp;&nbsp;&nbsp;$warnedby</td>
          </tr>";
  }
    
  print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>PassKey</td>
            <td class=tablea colspan=2 align=left><input type=checkbox name=chpasskey value=1 class='btn btn-flat btn-primary fc-today-button text-left'> <b>PassKey des Users neu generieren.</b></td>
          </tr>";

  $zeiten = explode(",", $user["seed_angaben"]);
  print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>Seed-Zeiten</td>
            <td class=tablea colspan=2 align=lefe>
              <input type=checkbox name=all_seed value=yes ".($zeiten[0] == 1?" checked=checked":"")." class='btn btn-flat btn-primary fc-today-button text-left'> User Seeded 24 Stunden ohne Einschr&auml;nkungen.<br>
              <hr>
              Montag -- Freitag&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <select name=seed_wo_st class='btn btn-flat btn-primary fc-today-button text-left'>
".uhrzeit($zeiten[1])."
              </select> bis
              <select name=seed_wo_end class='btn btn-flat btn-primary fc-today-button text-left'>
".uhrzeit($zeiten[2])."
              </select>
              <hr>Samstag und Sonntag
              <select name=seed_we_st class='btn btn-flat btn-primary fc-today-button text-left'>
".uhrzeit($zeiten[3])."
              </select> bis
              <select name=seed_we_end class='btn btn-flat btn-primary fc-today-button text-left'>
".uhrzeit($zeiten[4])."
              </select>
            </td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Seed Angaben</td>
            <td class=tablea colspan=2 align=left><input type=checkbox name=delseed value=1 class='btn btn-flat btn-primary fc-today-button text-left'> <b>Seed Zeit angaben des Users löschen.</b></td>
          </tr>";

  if($beobachtung == 'no')
    print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>User beobachten</td>
            <td class=tablea colspan=2 align=left><input type=checkbox name=beobachtung value=1 class='btn btn-flat btn-primary fc-today-button text-left'> User beobachten</td>
          </tr>";
  elseif($beobachtung == 'yes')
    print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>Beobachtung:</td>
            <td class=tablea colspan=2 align=left>Dieser User wird bereits von $beobachtet_von beobachtet!</td>
          </tr>";
  print "
            <td class=table table-bordered table-striped table-condensed>Secure System</td>
            <td class=tablea colspan=2 align=left>
              <input name=acceptrules value='no' type=radio" . ($acceptrules ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'>Ja
              <input name=acceptrules value='yes' type=radio" . (!$acceptrules ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'>Nein
            </td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Shoutbox eintäge erlauben</td>
            <td class=tablea colspan=2 align=left>
              <input name=shoutpost value='yes' type=radio" . ($shoutpost ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'>Ja
              <input name=shoutpost value='no' type=radio" . (!$shoutpost ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'>Nein
            </td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Torrent-Upload sperren</td>
            <td class=tablea align=left colspan=2>
              <input name=denyupload value='yes' type=radio" . (!$allowupload ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'>Ja
              <input name=denyupload value='no' type=radio" . ($allowupload ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'>Nein
            </td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Torrent-Download sperren</td>
            <td class=tablea align=left colspan=2>
              <input name=denydownload value='yes' type=radio" . (!$allowdownload  ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'>Ja
              <input name=denydownload value='no' type=radio" . ($allowdownload ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'>Nein
            </td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Bad User <img src=\"" . $GLOBALS["PIC_BASE_URL"] . "help.png\" style=\"vertical-align:middle;\" title=\"Bewirkt, dass dieser Benutzer nur ungültige Peer-IPs erhält\" alt=\"Bewirkt, dass dieser Benutzer nur ungültige Peer-IPs erhält\"></td>
            <td class=tablea align=left>
              <input name=baduser value='yes' type=radio" . ($baduser ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'>Ja <input name=baduser value='no' type=radio" . (!$baduser ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'>Nein
            </td><td class=tablea align=left><a href=\"startstoplog.php?op=acclist&amp;id=$id\" class='btn btn-flat btn-primary fc-today-button text-left'>Liste ehem. Accounts anzeigen</a></td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Flush Torrents:</td>
            <td class=tablea colspan=2 align=left>Flush Torrents, <a href=takeflush.php?id=$user[id]>$user[username]</a>!</td>
          </tr>
          <tr>
            <td class=table table-bordered table-striped table-condensed>Aktiviert</td>
            <td class=tablea align=left>
              <input name=enabled value='yes' type=radio" . ($enabled ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'>Ja
              <input name=enabled value='no' type=radio" . (!$enabled ? " checked" : "") . " class='btn btn-flat btn-primary fc-today-button text-left'>Nein
            </td>
            <td class=tablea align=left>Grund: <input type=text name=disablereason size=40 class='btn btn-flat btn-primary fc-today-button text-left'></td>
          </tr>";

  print "
          <tr>
            <td class=table table-bordered table-striped table-condensed>Java Alert senden</td>
            <td class=tablea align=left colspan=2>
              <input name=javaalert type=text size=100 class='btn btn-flat btn-primary fc-today-button text-left'>
            </td>
          </tr>";

  if ($trackerconfig[3] != "off")
    print"
          <tr>
            <td class=tablecat colspan=3 align=center><input type=submit class=btn value='Okay' class='btn btn-flat btn-primary fc-today-button text-left'></td>
          </tr>";
  print "
          <input type=hidden id=upchange name=upchange value=plus>
          <input type=hidden id=downchange name=downchange value=plus>
        </table>
        <br>
      </form>
    </td>
  </tr>
  </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}
x264_footer();

?>