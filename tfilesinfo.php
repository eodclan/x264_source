<?php
// ************************************************************************************//
// * X264 Source
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 5.5
// * 
// * Copyright (c) 2015 - 2016 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//
require_once(dirname(__FILE__) . "/include/bittorrent.php");
require_once(dirname(__FILE__) . "/include/bt_client_functions.php");  
require_once(dirname(__FILE__) . "/include/imdb.class.php");

function leech_sort($a, $b)
{
  if (isset($_GET["usort"]))
  {
    return seed_sort($a, $b);
  }
  $x = $a["to_go"];
  $y = $b["to_go"];
  if ($x == $y)
  {
    return 0;
  }
  elseif ($x < $y)
  {
    return -1;
  }
  else
  {
    return 1;
  }
}

function seed_sort($a, $b)
{
  $x = $a["uploaded"];
  $y = $b["uploaded"];
  if ($x == $y)
  {
    return 0;
  }
  elseif ($x < $y)
  {
    return 1;
  }
  else
  {
    return -1;
  }
}

function dltable($name, $arr, $torrent)
{
  global $CURUSER, $db;

  $s = "<b>" . count($arr) . " $name</b>\n";
  if (!count($arr))
  {
    return $s;
  }

  $s .= "
          <table width='90%' class='table table-bordered table-striped table-condensed' border='0' cellspacing='1' cellpadding='4'>
            <tr>
              <td class='table table-bordered table-striped table-condensed'>Benutzer/IP</td>
              <td class='table table-bordered table-striped table-condensed' style='text-align:center'>Hochgeladen</td>
              <td class='table table-bordered table-striped table-condensed' style='text-align:center'>Runtergeladen</td>
              <td class='table table-bordered table-striped table-condensed' style='text-align:center'>Ratio</td>
              <td class='table table-bordered table-striped table-condensed' style='text-align:center'>Fertig</td>
              <td class='table table-bordered table-striped table-condensed' style='text-align:center'>Verbunden</td>
              <td class='table table-bordered table-striped table-condensed' style='text-align:center'>Unt&auml;tig</td>
              <td class='table table-bordered table-striped table-condensed' style='text-align:center'>Client</td>
            </tr>";

  $mod = get_user_class() >= UC_MODERATOR;
  $now = time();
  foreach ($arr as $e)
  {
    $sql = "SELECT
                    username,
                    privacy,
                    class,
                    webseed,
                    vdsl,
                    adsl,
                    donor,
                    enabled,
                    warned,
                    added,
                    anon
            FROM
                    users
            WHERE
                    id=".$e['userid']."
            LIMIT 1";
            
    $una = $db -> querySingleArray($sql);
    $tdclass = ($CURUSER && $e["userid"] == $CURUSER["id"] ? " class='inposttable'": " class='tableb'");
    if ($una["privacy"] == "strong")
    {
      continue;
    }
    $s .= "
            <tr>";

    if ($una["username"])
    {
      if($una["anon"]=="no"||get_user_class()>=UC_MODERATOR)
      {
        $s .= "
            <td".$tdclass." nowrap='nowrap'>
              <a href='userdetails.php?id=".$e['userid']."'><font class='".get_class_color($una["class"])."'><b>".$una['username']."</b></font></a>&nbsp;".get_user_icons($una).($mod?"<br>
              <a href='whois2.php?ip=".$e['ip']."' target='nvwhois'>".$e['ip']."</a>":"")."
            </td>";
      }
      else
      {
        $s .= "
            <td".$tdclass." nowrap='nowrap'><b>Anonym*</b></td>";
      }
    }
    else
    {
      $s .= "
            <td".$tdclass.">".($mod ? $e["ip"] : "xxx.xxx.xxx.xxx")."</td>";
    }

    $revived = $e["revived"] == "yes";
    $s .= "
            <td".$tdclass." style='text-align:right'>".mksize($e["uploaded"])."</td>
            <td".$tdclass." style='text-align:right'>".mksize($e["downloaded"])."</td>";

    if ($e["downloaded"])
    {
      $ratio = floor(($e["uploaded"] / $e["downloaded"]) * 1000) / 1000;
      $s .= "
            <td".$tdclass." style='text-align:right'><font color='".get_ratio_color($ratio)."'>".number_format($ratio, 3)."</font></td>";
    }
    else
    {
      if ($e["uploaded"])
      {
        $s .= "
            <td".$tdclass." style='text-align:right'>Inf.</td>";
      }
      else
      {
        $s .= "
            <td".$tdclass." style='text-align:right'>---</td>";
      }
    }

    $s .= "
            <td".$tdclass." style='text-align:right'>
              <div title='".sprintf("%.2f%%", 100 * (1 - ($e["to_go"] / $torrent["size"]))) . "' style='border:1px solid black;padding:0px;width:40px;height:10px;'>
                <div style='border:none;width:".sprintf("%.2f", 40 * (1 - ($e["to_go"]/$torrent["size"])))."px;height:10px;background-image:url(".$GLOBALS["PIC_BASE_URL"]."ryg-verlauf-small.png);background-repeat:no-repeat;'></div>
              </div>
            </td>
            <td".$tdclass." nowrap='nowrap' style='text-align:right'>".mkprettytime($now - $e["st"])."</td>
            <td".$tdclass." style='text-align:right'>".mkprettytime($now - $e["la"])."</td>
            <td".$tdclass." style='text-align:left'>".htmlspecialchars(getagent($e["agent"], $e["peer_id"]))."</td>
          </tr>";
  }
  $s .= "
        </table>";
  return $s;
} 

function get_traffics($trres,$torrsize,$owner)
{
  global $GLOBALS;

  if(count($trres) > 0)
  {
    $ret = "<table class='table table-bordered table-striped table-condensed'>
            <tr>
              <div>User</div>
              <div colspan='2'>Download</div>
              <div>Aktiv ges.</div>
              <div>Upload</div>
              <div>Aktiv ges.</div>
              <div>FR</div>
              <div>Completed</div>
            </tr>";
            
    foreach($trres as $r)
    {
      $dnrat = number_format($r["downloaded"] * 100 / $torrsize, 1);
      if($r["downloaded"] > 0)
      {
        $uprat = number_format($r["uploaded"] / $r["downloaded"], 3);
        $uprat = "<font color='".get_ratio_color($uprat)."'>".$uprat."</font>";
      }
      elseif($r["uploaded"] > 0)
      {
        $uprat = "Inf.";
      }
      else
      {
        $uprat = "---";
      }
      $tolow=($r["downloaded"] < $torrsize && $owner != $r["username"]);
      $ret .= "
            <tr align='right'>
              <td class='table table-bordered table-striped table-condensed' align='left' nowrap>".($r["anon"] == "yes" && get_user_class() < UC_MODERATOR ? "
                Anonym*" : "
                <a href='usertfilesinfo.php?id=".$r['userid']."'><font class='".get_class_color($r["class"])."'>".$r['username']."</font></a>")." ".
                (isset($r["enabled"]) && $r["enabled"] == "no"?"
                <img src='".$GLOBALS["PIC_BASE_URL"]."disabled.png' alt='Deaktiviert' title='Dieser Benutzer ist deaktiviert' border='0'>":"")." ".
                (isset($r["warned"]) && $r["warned"] == "yes"? "
                <img src='".$GLOBALS["PIC_BASE_URL"]."warned.gif' alt='Verwarnt' title='Dieser Benutzer wurde verwarnt' border=0>":"")." ".
                ($owner === $r["username"]?"
                (Masterseeder)":"")."
              </div>
              <td class='table table-bordered table-striped table-condensed' nowrap>".($tolow ? "<span style='color:red'>" : "").mksize($r["downloaded"]).($tolow ? "</span>" : "")."</div>
              <td class='table table-bordered table-striped table-condensed' nowrap>".($tolow ? "<span style='color:red'>" : "").$dnrat." %".($tolow ? "</span>" : "")."</div>
              <td ".($r["downloadtime"] <= $r["uploadtime"] ? "class='table table-bordered table-striped table-condensed'":"style='background-color:red'")." nowrap>".mkprettytime($r["downloadtime"])."</div>
              <td class='table table-bordered table-striped table-condensed' nowrap>".mksize($r["uploaded"])."</div>
              <td class='table table-bordered table-striped table-condensed' nowrap>".mkprettytime($r["uploadtime"])."</div>
              <td class='table table-bordered table-striped table-condensed' nowrap>".$uprat."</div>
              <td class='table table-bordered table-striped table-condensed' nowrap>".($r["udt"]>0?date("d.m.Y H:i",$r["udt"]):"")."</div>
            </tr>";
    }
    $ret.="
          </table>";
  }
  else
  {
    $ret="<b>Bisher ist noch kein Traffic für diesen Torrent verzeichnet worden<b>";
  }
  return $ret;
}

dbconn(false);
loggedinorreturn();

$id = intval($_GET["id"]);

if (!isset($id) || !$id)
{
  stderr("Fehler","Ungültige ID");
}

if(get_user_class()>=UC_MODERATOR)
{
  $sql = "SELECT
                  traffic.*,
                  users.username,
                  users.enabled,
                  users.warned,
                  users.class,
                  users.anon
          FROM
                  traffic,
                  users
          WHERE
                  traffic.userid = users.id
          AND
                  torrentid='".$id."'
          ORDER BY
                  traffic.downloaded,
                  users.username";
  $trres = $db -> queryObjectArray($sql);
}

$sql =  "SELECT
                  torrents.seedspeed,
                  torrents.nuked,
                  torrents.nukereason,
                  torrents.free,
                  torrents.seeders,
		    torrents.preTime,
                  torrents.banned,
                  torrents.leechers,
                  torrents.info_hash,
                  torrents.filename,
                  LENGTH(torrents.nfo) AS nfosz,
                  UNIX_TIMESTAMP() - UNIX_TIMESTAMP(torrents.last_action) AS lastseed,
                  torrents.numratings,
                  torrents.name,
                  torrents.highlight,
                  torrents.team,
                  IF (torrents.numratings < " . $GLOBALS["MINVOTES"] . ", NULL, ROUND(torrents.ratingsum / torrents.numratings, 1)) AS rating,
                  torrents.pic1,
                  torrents.pic2,
                  torrents.pic1th,
                  torrents.pic2th,
                  torrents.owner,
                  torrents.gu_agent,
                  torrents.save_as,
                  torrents.descr,
                  torrents.multiplikator,
                  torrents.language,
                  torrents.visible,
                  torrents.size,
                  torrents.activated,
                  torrents.added,
                  torrents.views,
                  torrents.hits,
                  torrents.times_completed,
                  torrents.id,
                  torrents.type,
                  torrents.numfiles,
                  torrents.numpics,
                  torrents.nfo,
                  torrents.preTime,				  
                  torrents.imdb,				  
                  categories.name AS cat_name,
                  categories.image AS cat_image,
                  users.username,
                  users.anon, users.adsl,
                  users.webseed,
                  users.vdsl,
                  users.class
         FROM
                  torrents
         LEFT JOIN
                  categories
         ON
                  torrents.category = categories.id
         LEFT JOIN
                  users
         ON
                  torrents.owner = users.id
         WHERE
                  torrents.id = ".$id;

$row = $db -> querySingleArray($sql);

$owned = $moderator = 0;

if ($CURUSER["id"] == $row["owner"])
{
  $owned = 1;
}
elseif (get_user_class() >= UC_MODERATOR || ($row["activated"] == "no" && $row["class"] < UC_UPLOADER))
{
  $owned = $moderator = 1;
}

if (!$row || ($row["banned"] == "yes" && !$moderator))
{
  stderr("Fehler", "Es existiert kein Torrent mit der ID ".$id.".");
}

if (!$owned && $row["activated"] != "yes")
{
  stderr("Fehler", "Es existiert kein Torrent mit der ID ".$id.".");
}

if ($_GET["hit"])
{
  $db -> execute("UPDATE torrents SET views = views + 1 WHERE id = ".$id);
  if ($_GET["tocomm"])
  {
    header("Location: tfilesinfo.php?id=".$id."&page=0&" . SID . "#startcomments");
  }
  elseif ($_GET["filelist"])
  {
    header("Location: tfilesinfo.php?id=".$id."&filelist=1&" . SID . "#filelist");
  }
  elseif ($_GET["toseeders"])
  {
    header("Location: tfilesinfo.php?id=".$id."&dllist=1&" . SID . "#seeders");
  }
  elseif ($_GET["todlers"])
  {
    header("Location: tfilesinfo.php?id=".$id."&dllist=1&" . SID . "#leechers");
  }
  elseif ($_GET["tosnatchers"])
  {
    header("Location: tfilesinfo.php?id=".$id."&snatcher=1&" . SID . "#snatcher");
  }
  else
  {
    header("Location: tfilesinfo.php?id=".$id."&" . SID);
  }
  exit();
} 

if ($_GET["activate"] && $moderator && $row["activated"] != "yes")
{
  $db -> execute("UPDATE torrents SET activated = 'yes', added = NOW() WHERE id = " . $row["id"]);
  $db -> execute("UPDATE users SET gus = gus + 1, aktgus = aktgus + 1  WHERE id = " . $row["owner"]);
  sendPersonalMessage(0, $row["owner"], "Dein Torrent wurde von einem Moderator freigeschaltet!", "Dein Torrent \"[url=".$DEFAULTBASEURL."/tfilesinfo.php?id=" . $row["id"] . "]" . $row["name"] . "[/url]\" wurde von [url=".$DEFAULTBASEURL."/usertfilesinfo.php?id=" . $CURUSER["id"] . "]" . $CURUSER["username"] . "[/url] freigeschaltet. Du musst nun die Torrent-Datei erneut vom Tracker herunterladen, und kannst dann mit dem Seeden beginnen.\n\nBei Fragen lies bitte zuerst das [url=".$DEFAULBASEURL."/faq.php]FAQ[/url]!", PM_FOLDERID_SYSTEM);
  if (get_cur_wait_time($row["owner"]))
  {
    $data = array(
      "user_id"    => $row["owner"],
      "torrent_id" => $row["id"],
      "status"     => "granted",
      "grantor"    => $CURUSER["id"],
      "msg"        => "Automatische Wartezeitaufhebung durch Torrent-Freischaltung"
    );
    $db -> insertRow($data,"nowait");
  }
  write_log("torrentgranted", "Der Torrent <a href='tfilesinfo.php?id=" . $row["id"] . "'>" . htmlspecialchars($row["name"]) . "</a> wurde von '<a href='usertfilesinfo.php?id=".$CURUSER['id']."'>".$CURUSER['username']."</a>' freigeschaltet.");
  stderr("Torrent freigeschaltet", "Der Torrent wurde freigeschaltet, und ist nun über die Torrent-Suche auffindbar. Ebenso kann der Besitzer nun beginnen, den Torrent zu seeden. Eine Persönliche Nachricht wurde an den Uploader versendet, die ihn über die Freischaltung informiert.");
}

if ($_GET["agenttakeover"] == "acquire" && $row["gu_agent"] == 0 && $moderator && $row["activated"] != "yes")
{
  $row["gu_agent"] = $CURUSER["id"];
  $db -> updateRow(array("gu_agent" => $CURUSER['id']),"torrents","id=".$row['id']);
}

if ($_GET["agenttakeover"] == "release" && $row["gu_agent"] == $CURUSER["id"] && $moderator && $row["activated"] != "yes")
{
  $row["gu_agent"] = 0;
  $db -> updateRow(array("gu_agent" => "0"),"torrents","id=".$row['id']);
}

if (!isset($_GET["page"]))
{
  x264_header("Details zu Torrent \"" . $row["name"] . "\"");
  
	$trackerdienste = $GLOBALS["TF_DOWNLOAD"];
	if ($trackerdienste[0] == "0")
	{
		stdmsg("Achtung","Torrent Download ist zur Zeit deaktiviert.");
		x264_footer();
		die();		
	}	  
  
  $spacer = "";
  if (!$_GET["snatcher"])
  {
    $snatchersmax = "LIMIT 10";
  }
  else
  {
    $snatchersmax = "";
  }

  $sql = "SELECT
                  DISTINCT(user_id) as id,
                  username,
                  class,
                  anon,
                  peers.id as peerid
          FROM
                  completed,
                  users
          LEFT JOIN
                  peers
          ON
                  peers.userid = users.id
          AND
                  peers.torrent = ".$id."
          AND
                  peers.seeder = 'yes'
          WHERE
                  completed.user_id = users.id
          AND
                  completed.torrent_id = ".$id."
          ORDER BY
                  complete_time
          DESC
                 ".$snatchersmax;

  $res = $db -> queryObjectArray($sql);
  $last10users = "";
  
  if ($res)
  {
    foreach ($res as $arr)
    {
      if ($last10users)
      {
        $last10users .= ", ";
      }
      if($arr["anon"] == "yes" && get_user_class() < UC_MODERATOR)
      {
        $last10users .= ($arr["peerid"] > 0?"<b>":"")."Anonym*".($arr["peerid"] > 0?"</b>":"");
      }
      else
      {
        $arr["username"] = "<font class='" . get_class_color($arr["class"]) . "'>" . $arr["username"] . "</font>";
        if ($arr["peerid"] > 0)
        {
          $arr["username"] = "<b>" . $arr["username"] . "</b>";
        }
        $last10users .= "<a href='usertfilesinfo.php?id=" . $arr["id"] . "'>" . $arr["username"] . "</a>";
      }
    }
  }

  if ($last10users == "")
  {
    $last10users = "Diesen Torrent hat noch niemand fertiggestellt.";
  }
  else
  {
    $last10users .= "<br><br>(Fettgedruckte User seeden noch)";
  }

  if(get_user_class() >= UC_MODERATOR && $trres)
  {
    if(!$_GET["aclist"])
    {
      $trlist = count($trres)." User sind/waren aktiv";
    }
    else
    {
      $trlist = get_traffics($trres,$row["size"],$row["username"]);
    }
  }

  if ($_GET["edited"])
  {
echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Erfolgreich bearbeitet!
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<p>Der Torrent wurde erfolgreich geändert. Die Änderungen sind sofort für andere sichtbar.</p>";
    if (isset($_GET["returnto"]))
    {
      echo "<p><b>Gehe dorthin zur&uuml;ck, von <a href=\"" . htmlspecialchars($_GET["returnto"]) . "\">wo Du gekommen bist</a>.</b></p>\n";
    }
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
  }
  elseif (isset($_GET["searched"]))
  {
    begin_frame("Suche", false, "650px");
    echo "<p>Deine Suche nach \"" . htmlspecialchars($_GET["searched"]) . "\" hat ein einzelnes Ergebnis zur&uuml;ckgegeben:</p>\n";
    end_frame();
  }
  elseif ($_GET["thanks"])
  {
    begin_frame("Danke hinzugefügt", false, "650px");
    echo "<p>Dein Dank wurde gespeichert</p>\n";
    end_frame();
  }
  elseif ($_GET["nothanks"])
  {
    begin_frame("Danke hinzugefügen nicht möglich", false, "650px");
    echo "<p>Du hast dich schon bedankt oder es ist ein Datenbankfehler</p>\n";
    end_frame();
  }

  $s = $row["name"];

  print "

                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-download'></i> ".$row["name"].($row["class"] < UC_UPLOADER?" <font color='red'>[GU]</font>":"")."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
	
	
  $sql   = "SELECT
                      id,
                      seeders,
                      leechers,
                      name,
                      size,
                      added,
                      seedspeed
            FROM
                      torrents
            WHERE
                      id > ".$id."
            ORDER BY
                      id
            LIMIT 1";

  $row13 = $db -> querySingleArray($sql);
  $idsv  = $row13["id"];
  if ($idsv >= 1)
  {
    $name = $row13['name'];
    $name = str_replace('_', ' ' , $name);
    $name = str_replace('.', ' ' , $name);
    $name = substr($name, 0, 35). "...";

  }


  $sql   = "SELECT
                      id,
                      seeders,
                      leechers,
                      name,
                      size,
                      added,
                      seedspeed
            FROM
                      torrents
            WHERE
                      id < $id
            ORDER BY
                      id desc
            LIMIT 1";
  $row12 = $db -> querySingleArray($sql);
  $idsz  = $row12["id"];
  if ($idsz >= 1)
  {
    $name1 = $row12['name'];
    $name1 = str_replace('_', ' ' , $name1);
    $name1 = str_replace('.', ' ' , $name1);
    $name1 = substr($name1, 0, 35). "...";

  }
	
  print "
<script>
function ShowNFO(){
	if(document.getElementById('x264_nfo').style.display == 'none'){
	document.getElementById('x264_nfo').style.display = 'block';
	document.getElementById('x264_details_view').style.display = 'none';
	document.getElementById('x264_filelist_view').style.display = 'none';
	document.getElementById('x264_imdb_view').style.display = 'none';	
	CheckIfEdit('taken');
	}else{
	document.getElementById('x264_nfo').style.display = 'none';
	CheckIfEdit('giveup');
	}
}

function ShowDETAILS(){
	if(document.getElementById('x264_details_view').style.display == 'none'){
	document.getElementById('x264_details_view').style.display = 'block';
	document.getElementById('x264_nfo').style.display = 'none';
	document.getElementById('x264_filelist_view').style.display = 'none';
	document.getElementById('x264_imdb_view').style.display = 'none';	
	CheckIfEdit('taken');
	}else{
	document.getElementById('x264_details_view').style.display = 'none';
	CheckIfEdit('giveup');
	}
}

function ShowFILELIST(){
	if(document.getElementById('x264_filelist_view').style.display == 'none'){
	document.getElementById('x264_filelist_view').style.display = 'block';
	document.getElementById('x264_nfo').style.display = 'none';
	document.getElementById('x264_details_view').style.display = 'none';
	document.getElementById('x264_imdb_view').style.display = 'none';	
	CheckIfEdit('taken');
	}else{
	document.getElementById('x264_filelist_view').style.display = 'none';
	CheckIfEdit('giveup');
	}
}

function ShowIMDB(){
	if(document.getElementById('x264_imdb_view').style.display == 'none'){
	document.getElementById('x264_imdb_view').style.display = 'block';
	document.getElementById('x264_details_view').style.display = 'none';
	document.getElementById('x264_filelist_view').style.display = 'none';
	document.getElementById('x264_nfo').style.display = 'none';	
	CheckIfEdit('taken');
	}else{
	document.getElementById('x264_imdb_view').style.display = 'none';
	CheckIfEdit('giveup');
	}
}
</script>

                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>";
	
  $url = "edit.php?id=" . $row["id"];
  if (isset($_GET["returnto"]))
  {
    $addthis  = "&amp;returnto=" . urlencode($_GET["returnto"]);
    $url     .= $addthis;
    $keepget .= $addthis;
  }
  $editlink = "".$url."";

  $waittime = get_wait_time($CURUSER["id"], $id);

  if ($row["activated"] != "yes")
  {
    if ($moderator)
    {
      print "
      Freischalten: ";
      if ($row["gu_agent"] > 0)
      {
        $sql      = "SELECT
                            username
                     FROM
                            users
                     WHERE
                            id=".$row["gu_agent"];
        $gu_agent = $db -> querySingleItem($sql);
        print "<font color='red'>Dieser Gast-Upload wird bereits von <b><a href='usertfilesinfo.php?id=".$row["gu_agent"]."'>".htmlspecialchars($gu_agent)."</a></b> bearbeitet. ";
        if ($row["gu_agent"] == $CURUSER["id"])
        {
          print "(<a class='index' href='tfilesinfo.php?id=" . $row["id"] . "&amp;agenttakeover=release'>Bearbeitung abgeben</a>)";
        }
        print "<br>";
      }
      else
      {
        print "<a class='index' href='tfilesinfo.php?id=" . $row["id"] . "&amp;agenttakeover=acquire'>Bearbeitung dieses Gastuploads übernehmen</a><br>";
      }
      print "<a class='index' href='tfilesinfo.php?id=" . $row["id"] . "&amp;activate=1'>Torrent freischalten</a></div>
      </tr>";
    }
    else
    {
      print "
        Freischalten: Dieser Torrent muss erst von einem Moderator freigeschaltet werden, bevor er sichtbar wird.";
    }
  }
  else
  {
    if ($waittime)
    {
      print "Wartezeit aktiv";
    }
    else
    {
      if ($GLOBALS["DOWNLOAD_METHOD"] == DOWNLOAD_REWRITE)
        $download_url = "download/" . $id . "/" . rawurlencode($row["filename"]);
      else
        $download_url = "download.php?torrent=" . $id;

 
      {
        if ($CURUSER["allowdownload"]=="yes")
        {
          if (!check_seedtime($CURUSER['seed_angaben']))
          {
            print "
								<td><a href='profile.php#no_dsl_speed_found' class='navLink'><i class='fa fa-expeditedssl' title='Bitte dein Profil bearbeiten!'></i> Bitte dein Profil bearbeiten!</a></td>";
          }
          else
          {
            print "
								<td><a href='".$download_url."' class='navLink'><i class='fa fa-download' title='Download'></i> Download</a></td>";
          }
        }
        else
        {
          print "
								<td><a href='#no_dl_found' class='navLink'><i class='fa fa-expeditedssl' title='DL de-aktiv bei dir!'></i> DL de-aktiv bei dir!</a></td>";
        }
      }
    }
  }
  if ($row["nfosz"] > 0)
  {  
    print"
								<td><a href='download_nfo.php?id=".$row['id']."&amp;action=downloadNFO' class='navLink'><i class='fa fa-download' title='Download NFO'></i> Download NFO</a></td>";
  }
  else
  {
    print"
								<td><a href='#no_nfo_found' class='navLink'><i class='fa fa-legal' title='Keine NFO vorhanden'></i> Keine NFO vorhanden</a></td>";
  }
  
    print"  
	".(isset($row["username"]) ? ($row["anon"] == "yes" && get_user_class() < UC_MODERATOR?"":
	("")):
	"
								").($owned? $spacer."<td><a href='".$editlink."' class='navLink'><i class='fa fa-edit' title='Bearbeiten'></i> Bearbeiten</a></td>":"")."	
								<td><a href='#nogo' onclick='ShowDETAILS();' class='navLink'><i class='fa fa-info-circle' title='Bearbeiten'></i> Details</a></td>
								<td><a href='#nogo' onclick='ShowFILELIST();' class='navLink'><i class='fa fa-file-o' title='Bearbeiten'></i> Datei liste</a></td>
								<td><a href='#nogo' onclick='ShowNFO(); display: none;' class='navLink'><i class='fa fa-expeditedssl' title='Bearbeiten'></i> Beschreibung</a></td>";
		
if (!empty($row["imdb"]))
{
print "
								<td><a href='#nogo' onclick='ShowIMDB(); display: none;' class='navLink'><i class='fa fa-unlock' title='Bearbeiten'></i> IMDB Info</a></td>";
}
else
{
print"
								<td><a href='#no_imdb_found' class='navLink'><i class='fa fa-lock' title='Bearbeiten'></i> IMDB not found</a></td>";
}	
			
print"
                            </tr>
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
	
print"  
  <div id='x264_details_view'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-download'></i> ".$row["name"]." - Details
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>";

  $poster  = $GLOBALS["SHORTNAME"] ."/torrentpics/t-" . $row["id"] . "-1.jpg";
  $fposter = $GLOBALS["SHORTNAME"] ."/torrentpics/f-" . $row["id"] . "-1.jpg";    
  $tname = str_replace('.', ' ' , $row['name']);
  
if (!empty($row["numpics"]))
{
    print "
                            <tr>
								<td>
									<img src='".$poster."' style='margin-top:15px;max-width:160px;max-height:160px;' class='mx-auto d-block' data-toggle='modal' data-target='#primaryModal'>
								</td>
								<td><img src='".$GLOBALS["DESIGN_PATTERN"] ."/sl_free_zone.png' style='margin-top:15px;max-width:160px;max-height:160px;' class='mx-auto d-block'></td>
							</tr>
<div class='modal fade show' id='primaryModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' style='display: none;'>
    <div class='modal-dialog modal-primary' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title'>".trim_it($tname,24)."</h4>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
            </div>
            <div class='modal-body'>
                <p><img src='".$poster."' style='margin-top:15px;width:360px;height:360px;' class='mx-auto d-block'></p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>";

}

  print"
                            <tr>  
								<td>Bedanke dich beim Uploader:</td><td>";

// -- Ajax-Danke Anfang -- //
$torrentid      = intval($_GET["id"]);
$sql_count      = "SELECT COUNT(*) FROM thanks WHERE torrentid = " . $torrentid;
$res_count      = mysql_query($sql_count) or sqlerr(__FILE__, __LINE__);
$arr_count      = mysql_fetch_array($res_count);
$count          = $arr_count[0];
$thanks_user    = "";
$can_not_thanks = false;

if ($count == 0)
  $thanks_user = "Es hat sich noch keiner bedankt!";
else
{
  $thanked_sql = mysql_query("SELECT thanks.userid, users.username, users.class FROM thanks INNER JOIN users ON thanks.userid = users.id WHERE thanks.torrentid = " . $torrentid);
  while ($thanked_row = mysql_fetch_array($thanked_sql))
  {
    if ($thanked_row["userid"] == $CURUSER["id"]) $can_not_thanks = true;

    $userid   = intval($thanked_row["userid"]);
    $username = htmlentities(trim($thanked_row["username"]));
    $thanks_user .= "<a href=\"" . $BASEURL . "/userdetails.php?id=" . $userid . "\"><font class=\"" . get_class_color($thanked_row["class"]) . "\">" . $username . "</font></a>, ";
  }
  if ($thanks_user)
    $thanks_user = substr($thanks_user, 0, -2);
}

$thanksby  = "\n<script language=\"javascript\" type=\"text/javascript\" src=\"" . $GLOBALS["DESIGN_PATTERN"] . "". $GLOBALS["ss_uri"]."/js/ajax.js\"></script>";
$thanksby .= "<script language=\"javascript\" type=\"text/javascript\" src=\"" . $GLOBALS["DESIGN_PATTERN"] . "". $GLOBALS["ss_uri"]."/js/ajax-danke.js\"></script>";

$thanksby .= "<div id=\"ajax\">" . $thanks_user . "";
$thanksby .= ($can_not_thanks == false ? "\n<a class=\"button\" href=\"javascript:send(" . $torrentid . ");\">Danke sagen</a>" : "");
$thanksby .= "</div>";

$thanksby .= "<div id=\"loading-layer\">";
$thanksby .= "</div>";

print" 																		".$thanksby."</td>
							</tr>
                            <tr>";
//tr("Bedankt haben sich:",$thanksby,1);
// -- Ajax-Danke zu Ende -- //  

//Ajax Reseed System
  print"
								<td>Reseed Anfragen:</td><td>";
  
print("<script type=\"text/javascript\" src=\"" . $GLOBALS["DESIGN_PATTERN"] . "". $GLOBALS["ss_uri"]."/js/reseed_counter.js\"></script>" .
      "<script type=\"text/javascript\" src=\"" . $GLOBALS["DESIGN_PATTERN"] . "". $GLOBALS["ss_uri"]."/js/ajax.js\"></script>" .
      "<script type=\"text/javascript\" src=\"" . $GLOBALS["DESIGN_PATTERN"] . "". $GLOBALS["ss_uri"]."/js/ajax-reseed.js\"></script>");

$now = get_date_time();

$sql  = "SELECT last_reseed FROM torrents WHERE id = " . $id . " LIMIT 1";
$time = $db -> querySingleItem($sql);
$diff = "+" . get_config_data("RESEED_DIFF") . " hours";

$soll = ($time == "0000-00-00 00:00:00" ? $now : $time);
$soll = strtotime($soll . " " . $diff);
$soll = date("Y-m-d H:i:s", $soll);

$sql    = "SELECT COUNT(seeder) FROM peers WHERE torrent = " . $id;
$seeder = $db -> querySingleItem($sql);

if ($seeder > 1)
{
    $reseed = "kein Reseed m&ouml;glich, da genug Seeder vorhanden sind";
}
else
{
    if ( ($time == "0000-00-00 00:00:00") || ($soll < $now) )
    {
        $reseed = "<div id=\"reseed\">" .
                  "  <a href=\"javascript:send_reseed(" . $id . ");\" class=\"button\" style=\"width: 215px;\">Dr&uuml;cke hier, f&uuml;r eine Anfrage.</a>" .
                  "  <div id=\"loading-layer\" style=\"display:none; font-family: Verdana; font-size: 11px; width:200px; height:50px; background:#FFFFFF; padding:10px; text-align:center; border:1px solid #000000;\">" .
                  "    <div style=\"font-weight:bold;\" id=\"loading-layer-text\">Senden. Bitte warten ...</div>" .
                  "  </div>" .
                  "</div>";

    }
    else
    {
        $datum = substr($soll, 5, 2) . " " . substr($soll, 8, 2) . ", " . substr($soll, 0, 4) . substr($soll, 10);

        $reseed = "<div id=\"reseed\">" .
                  "  <script type=\"text/javascript\">" .
                  "    window.onload = function()" .
                  "    {" .
                  "        end = new Date('" . $datum . "');" .
                  "        countdown(\"" . $id . "\");" .
                  "    };" .
                  "  </script>" .
                  "  <span id=\"counter\">XX:XX:XX</span> bis zum n&auml;chsten Reseed..." .
                  "</div>";
    }
}

//tr("Reseed Anfrage", $reseed, 1);
print"															".$reseed."</td>
							</tr>
                            <tr>";  
 	  
print"
								<td>Torrent Info's von:</td><td>".$row["name"]."</td>
							</tr>
                            <tr>";

if (!empty($row["added"]))
{
print "
								<td>PreTime:</td><td>".$row['added']." (-1 GMT)</td>
							</tr>
                            <tr>";
}
else
{
print"
								<td>PreTime:</td><td>Keine Pretime gefunden!</td>
							</tr>";
}
 
print "
                            <tr>
								<td>Kategorie:</td><td>".$row['cat_name']."</td>
							</tr>
                            <tr>";
      
 
print "
								<td>Sprache:</td><td>";
        
  switch ($row["language"])
  {
    case "deutsch":
      print "Deutsch";
      break;
    case "englisch":
      print "Englisch";
      break;
    case "multi":
      print "Mehrere Sprachen";
      break;
    default:
      print "Bei diesem Torrent wurde die Sprache nicht gewählt";
      break;
  }

  print"
								</td>
							</tr>
                            <tr>
								<td>Highlight:</td><td>".($row["highlight"] == "yes"?"Ja":"Nein")."</td>
							</tr>
                            <tr>";
  
  $sql = "SELECT
                    COUNT(*)
          FROM
                    users
          WHERE
                    id IN (SELECT
                                    userid
                           FROM
                                    traffic
                           WHERE
                                    torrentid = ".$row['id']."
                           )
          AND
                    webseed = 'yes'
          AND
                    id IN (SELECT
                                    userid
                           FROM
                                    peers
                           WHERE
                                    torrent = ".$row['id']."
                           AND
                                    seeder = 'yes'
                           )";
  $ha2 = $db -> querySingleItem($sql);
  $sql = "SELECT
                    COUNT(*)
          FROM
                    users
          WHERE
                    id IN (SELECT
                                    userid
                           FROM
                                    traffic
                           WHERE
                                    torrentid = ".$row['id'].")
          AND
                    webseed = 'yes'
          AND
                    id IN (SELECT
                                    userid
                           FROM
                                    peers
                           WHERE
                                    torrent = ".$row['id']."
                           AND
                                    seeder ='no'
                          )";
  $ha6 = $db -> querySingleItem($sql);
  $ha8 = $ha2 + $ha6;

  print "
								<td>Web-Seeder:</td><td><font color=".($ha2 != "0"?"lime> ". $ha2 :"red>Nein")."</font></td>
							</tr>
                            <tr>";
	  	

if (get_user_class() >= UC_MODERATOR) {
  print "
								<td>Hochgeladen von:</td><td>".$row["username"]."</td>								
							</tr>
                            <tr>";
}
		
  $sql = "SELECT
                    COUNT(*)
          FROM
                    users
          WHERE
                    id IN (SELECT
                                    userid
                           FROM
                                    traffic
                           WHERE
                                    torrentid = ".$row['id']."
                           )
          AND
                    vdsl = 'yes'
          AND
                    id IN (SELECT
                                    userid
                           FROM
                                    peers
                           WHERE
                                    torrent = ".$row['id']."
                           AND
                                    seeder = 'yes'
                           )";
  $ha11 = $db -> querySingleItem($sql);

  $sql = "SELECT
                    COUNT(*)
          FROM
                    users
          WHERE
                    id IN (SELECT
                                    userid
                           FROM
                                    traffic
                           WHERE
                                    torrentid = ".$row['id'].")
          AND
                    vdsl = 'yes'
          AND
                    id IN (SELECT
                                    userid
                           FROM
                                    peers
                           WHERE
                                    torrent = ".$row['id']."
                           AND
                                    seeder ='no'
                          )";
  $ha13 = $db -> querySingleItem($sql);

  $ha14 = $ha11 + $ha13;


   $sql = "SELECT
                    COUNT(*)
          FROM
                    users
          WHERE
                    id IN (SELECT
                                    userid
                           FROM
                                    traffic
                           WHERE
                                    torrentid = ".$row['id']."
                           )
          AND
                    adsl = 'yes'
          AND
                    id IN (SELECT
                                    userid
                           FROM
                                    peers
                           WHERE
                                    torrent = ".$row['id']."
                           AND
                                    seeder = 'yes'
                           )";
  $ha3 = $db -> querySingleItem($sql);

  $sql = "SELECT
                    COUNT(*)
          FROM
                    users
          WHERE
                    id IN (SELECT
                                    userid
                           FROM
                                    traffic
                           WHERE
                                    torrentid = ".$row['id'].")
          AND
                    adsl = 'yes'
          AND
                    id IN (SELECT
                                    userid
                           FROM
                                    peers
                           WHERE
                                    torrent = ".$row['id']."
                           AND
                                    seeder ='no'
                          )";
  $ha9 = $db -> querySingleItem($sql);

  $ha1 = $ha3 + $ha9;

  print "
								<td>Only Upload:</td><td><font color=".($row["free"] == "yes"?"lime>Ja":"red>Nein")."</font></td>								
							</tr>
                            <tr>
								<td>Größe:</td><td>".mksize($row["size"]) . " (" . number_format($row["size"]) . " Bytes)"."</td>								
							</tr>
                            <tr>
								<td>Seed Speed:</td><td>".$row["seedspeed"]."</td>								
							</tr>
                            <tr>
								<td>Downloads abgeschlossen:</td><td>" . $row["times_completed"] . " mal</td>								
							</tr>";
							
  if (!$_GET["dllist"])
  {
    print "
								<td>Peers:</td><td><a href='tfilesinfo.php?id=".$id."&amp;dllist=1".$keepget."#seeders' class='sublink'>Peers anzeigen</a></td>
							</tr>
                            <tr>
								<td>Details:</td><td>".$row["seeders"]." Seeder, ".$row["leechers"]." Leecher = ".($row["seeders"] + $row["leechers"])." Peer(s) gesamt</td>								
							</tr>
                            <tr>";
  }
  else
  {
    $downloaders = array();
    $seeders     = array();
    $sql         = "SELECT
                              peer_id,
                              seeder,
                              ip,
                              port,
                              traffic.uploaded AS uploaded,
                              traffic.downloaded AS downloaded,
                              traffic.downloadtime AS downloadtime,
                              traffic.uploadtime AS uploadtime,
                              to_go,
                              UNIX_TIMESTAMP(started) AS st,
                              connectable,
                              agent,
                              UNIX_TIMESTAMP(last_action) AS la,
                              peers.userid
                    FROM
                              peers
                    LEFT JOIN
                              traffic
                    ON
                              peers.userid = traffic.userid
                    AND
                              peers.torrent = traffic.torrentid
                    WHERE
                              torrent = ".$id;
    $subres = $db -> queryObjectArray($sql);
    if ($subres)
    {
      foreach ($subres as $subrow)
      {
        if ($subrow["seeder"] == "yes")
        {
          $seeders[] = $subrow;
        }
        else
        {
          $downloaders[] = $subrow;
        }
      }
    }

    usort($seeders, "seed_sort");
    usort($downloaders, "leech_sort");

    print "
								<td><a href='tfilesinfo.php?id=".$id.$keepget."' class='sublink'>Peers verbergen</a></td>
								<td>".dltable("Seeder", $seeders, $row)."</td>								
							</tr>
                            <tr>
								<td><a href='tfilesinfo.php?id=".$id.$keepget."' class='sublink'>Peers verbergen</a></td>
								<td>".dltable("Leecher", $downloaders, $row)."</td>								
							</tr>
                            <tr>";
  }								
print"							
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</div>
  <div id='x264_filelist_view' style='display: none;'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-download'></i> ".$row["name"]." - Datei liste
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>
								<td>Dateien: ".$row["numfiles"]." Dateien</td>
							</tr>";

      $sql    = "SELECT
                          *
                 FROM
                          files
                 WHERE
                          torrent = ".$id."
                 ORDER BY
                          id";
      $subres = $db -> queryObjectArray($sql);
      foreach ($subres as $subrow)
      {
        print "
								<td>Datei:</td>
							</tr>
                            <tr>							
								<td>".$subrow["filename"]."</td>
							</tr>";
      }
      print "
	  
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</div>
  <div id='x264_imdb_view' style='display: none;'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-download'></i> ".$row["name"]." - IMDB Info
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>";
			$imdbimg = "<img src='".$GLOBALS["SHORTNAME"] ."/torrentpics/t-" . $row["id"] . "-1.jpg' class='logo-image'>";
			$imdbnr = "http://www.imdb.com/title/tt".$row["imdb"]."/";
			$oIMDB = new IMDB('http://www.imdb.com/title/tt'.$row["imdb"].'/');
			if($oIMDB->isReady){

				//$cover 	= '<img src="imdb-data/'.$oIMDB->getPoster().'" id="imdb_cover" alt="" />';
				$title 	= $oIMDB->getTitle();
				$year 		= $oIMDB->getYear();
				$runtime	= $oIMDB->getRuntime();
				$releasedate	= $oIMDB->getReleaseDate();
				$cast		= $oIMDB->getCast(5);
				$regie		= $oIMDB->getDirector();
				$writer	= $oIMDB->getWriter();
				$genre		= $oIMDB->getGenre();
				$land		= $oIMDB->getCountry();
				$rating	= $oIMDB->getRating();
				$votes		= $oIMDB->getVotes();
				$url		= $oIMDB->getUrl();
				$plot		= $oIMDB->getPlot(550);
			}else {echo '<p>Keine Informationen gefunden!</p>';}
			?>
								<td><?=$title;?></td><td>from the Year <?=$year;?></td>								
							</tr>
                            <tr>			
								<td>Regisseur:</td><td><?=$regie;?></td>								
							</tr>
                            <tr>
								<td>Drehbuchautor:</td><td><?=$writer;?></td>								
							</tr>
                            <tr>
								<td>Besetzung:</td><td><?=$cast;?></td>								
							</tr>
                            <tr>
								<td>Kinostart:</td><td><?=$releasedate;?></td>								
							</tr>
                            <tr>
								<td>Genre:</td><td><?=$genre;?></td>								
							</tr>
                            <tr>
								<td>Länge:</td><td><?=$runtime;?></td>								
							</tr>
                            <tr>
								<td>Land:</td><td><?=$land;?></td>								
							</tr>
                            <tr>
								<td>Bewertung:</td><td><?=$rating;?> / 10 Punkte</td>								
							</tr>
                            <tr>
								<td>IMDB-Link:</td><td><a href="redir.php?url=<?=$imdbnr;?>" rel='external'><?=$imdbnr;?></a></td>								
							</tr>
                            <tr>
								<td>Inhalt:</td><td><?=$plot;?></td>								
							</tr>


<?
 
print"  
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</div>			

  <div id='x264_nfo' style='display: none;'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-download'></i> ".$row["name"]." - Beschreibung
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>";
        
  if (!empty($row["descr"]))
  {
	$text = format_comment($row["descr"]);
    $text = wordwrap($text, 2420, "<br />");
    print $text;	
	
	//$descr = preg_replace('/\r?\n|\r/','<br/>', $descr);
	//$descr = str_replace(array("\r\n","\r","\n"),"<br/>", $descr);
	//$descr = nl2br($descr);
   //print "<pre><font size=1  border='0' style='width: 98%; padding: 5px; margin-left: auto; margin-right: auto;'>";
    //print "".$row["descr"]."";   
   //print format_comment($row["descr"]);
   //print "</font></pre><br>";
  }
  else
  {
	// NFO ALS TEXT
	//$nfo = htmlspecialchars($row["nfo"]);
    //$nfo = preg_replace("/[^\\x20-\\x7e\\x0a\\x0d]/", " ", $nfo);
    //$nfo = str_replace("\\r\\n", "\n", $nfo);
    //$nfo = str_replace(array("\\r\\n", "\\n\\n"),"<br>",$nfo);	
    //$nfo = wordwrap($nfo, 75, "<br />");
    //print "<pre><font size=1 style='font-size: 10pt; line-height: 10pt'>";	
    //print $nfo;
	//print"</font></pre><br>";
	// NFO ALS BILD
    $nfo = htmlspecialchars($row["nfo"], 30);
    $nfo = preg_replace("/[^\\x20-\\x7e\\x0a\\x0d]/", " ", $nfo);
    $nfo = str_replace("\\r\\n", "\n", $nfo);
    $nfo = str_replace(array("\r\n","\n\r","\r"),"<br>",$nfo);
    print "<img src='/".$GLOBALS["SHORTNAME"]."/nfo/nfo-".$row['id'].".png' border='0' style='width: 860px; padding: 5px; margin-left: auto; margin-right: auto;'>";
  } 
  } 
print"
                            <tr>
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</div>";

x264_footer();
?>