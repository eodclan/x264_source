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

/////////////////////////////////////////////////////////
//    Dokumentverzeichnis für das Löschen ermitteln    //
/////////////////////////////////////////////////////////
if (is_dir($_SERVER["DOCUMENT_ROOT"] . "include")) $doc_root = $_SERVER["DOCUMENT_ROOT"];
else $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";

if (is_dir($_SERVER["DOCUMENT_ROOT"] . "include")) $root = $_SERVER["DOCUMENT_ROOT"] . "include";
else $root = $_SERVER["DOCUMENT_ROOT"] . "/include";

require_once($root . "/engine.php");

dbconn();
loggedinorreturn();

check_access(UC_BOSS);
security_tactics();

if ($_POST["a"] == "") $action = "view";
else $action = htmlentities($_POST["a"]);

function bark($msg)
{
  genbark($msg, "Verarbeitung abgebrochen!");
}

function tabellen_zeile($inhalt, $error)
{
  if ($error)
  {
    print(" <tr>\n");
    print("  <td width=\"100%\" class=\"tablea\"><font color=\"green\">OK: " . $inhalt . " gel&ouml;scht</font></td>\n");
    print(" </tr>\n");
  }
  else
  {
    print(" <tr>\n");
    print("  <td width=\"100%\" class=\"tablea\"><font color=\"red\"><b>FEHLER: " . $inhalt . " nicht gel&ouml;scht</b></font></td>\n");
    print(" </tr>\n");
  }
}

x264_admin_header("Tote Torrents l�schen");
?>
<script type="text/javascript" language="JavaScript">
 function alle_auswaehlen(field)
 {
   for(i=0; i<field.length; i++)
     field[i].checked = true;
 }
</script>
<?php

//////////////////////////////////
//     Tote Torrents löschen    //
//////////////////////////////////
if ($action == "delete")
{
  if (empty($_POST["deltorr"]))
    bark("Du hast keine Torrents ausgew&auml;hlt.");

  print("<table style=\"width: 700px;\" class=\"tableinborder\" border=\"0\" cellpadding=\"4\" cellspacing=\"1\">\n");

  ////////////////////////////////////////////////////////////////////
  //    Dateien anhand der ID auf der Platte suchen und löschen     //
  ////////////////////////////////////////////////////////////////////
  $array_old_torrent = $_POST["deltorr"];
  for($i = 0; $i < count($array_old_torrent); $i++)
  {
    $bild_1   = $doc_root . $GLOBALS["BITBUCKET_DIR"] . "/f-" .   $array_old_torrent[$i] . "-1.jpg";
    $bild_2   = $doc_root . $GLOBALS["BITBUCKET_DIR"] . "/f-" .   $array_old_torrent[$i] . "-2.jpg";
    $bild_nfo = $doc_root . $GLOBALS["BITBUCKET_DIR"] . "/nfo-" . $array_old_torrent[$i] . ".png";
    $torrent  = $doc_root . $GLOBALS["TORRENT_DIR"]   . "/" .     $array_old_torrent[$i] . ".torrent";

    if (is_file($bild_1))   tabellen_zeile($bild_1,@unlink($bild_1));
    if (is_file($bild_2))   tabellen_zeile($bild_2,@unlink($bild_2));
    if (is_file($bild_nfo)) tabellen_zeile($bild_nfo,@unlink($bild_nfo));
    if (is_file($torrent))  tabellen_zeile($torrent,@unlink($torrent));
  }

  write_log("torrentdelete","<font color=red>Torrent Bereinigung erfolgreich abgeschlossen!</font>");

  ////////////////////////////////////////////
  //    SQL-Daten anhand der ID löschen     //
  ////////////////////////////////////////////
  $result = mysql_query("DELETE FROM torrents WHERE id IN (" . implode(", ", $_POST[deltorr]) . ")");
  tabellen_zeile("Torrent-Informationen",$result);
  $result = mysql_query("DELETE FROM snatched WHERE torrentid IN (" . implode(", ", $_POST[deltorr]) . ")");
  tabellen_zeile("Snatch-Informationen",$result);
  $result = mysql_query("DELETE FROM peers WHERE torrent IN (" . implode(", ", $_POST[deltorr]) . ")");
  tabellen_zeile("Peer-Daten",$result);
  $result = mysql_query("DELETE FROM comments WHERE torrent IN (" . implode(", ", $_POST[deltorr]) . ")");
  tabellen_zeile("Kommantare",$result);
  $result = mysql_query("DELETE FROM files WHERE torrent IN (" . implode(", ", $_POST[deltorr]) . ")");
  tabellen_zeile("Filedaten",$result);
  $result = mysql_query("DELETE FROM traffic WHERE torrentid IN (" . implode(", ", $_POST[deltorr]) . ")");
  tabellen_zeile("Traffik-Informationen",$result);

  print(" <tr>\n");
  print("  <td width=\"100%\" class=\"tabletitle\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\">weiter &rArr;</a></b></center></td>\n");
  print(" </tr>\n");
  print("</table>\n");
}

//////////////////////////////////
//     Tote Torrents anzeigen   //
//////////////////////////////////
if ($action == "view")
{
  //$perpage = 100;

  $death_days = 4;
  $death_time = sqlesc(get_date_time(gmtime() - ($death_days * 86400)));
  $res_death_torrents = mysql_query("SELECT id, name, owner, last_action FROM torrents WHERE last_action < $death_time and visible = 'no' ORDER BY last_action");
  $death_torrent_count = mysql_num_rows($res_death_torrents);

  print("<form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"post\" name=\"formular\">\n");
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>" . $death_torrent_count . " Tote Torrents (seit " . $death_days . " Tagen oder mehr)
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
  print"
	<div class='x264_title_content'>";  
  print("<table class=\"tableinborder\" border=\"0\" cellpadding=\"4\" cellspacing=\"1\">\n");
  print(" <tr>\n");
  print("   <td class=\"tabletitle\" colspan=\"5\" align=\"right\">\n");
  print("    <input type=\"button\" value=\"alles markieren\" name=\"go\" onclick=\"alle_auswaehlen(document.formular['deltorr[]'])\">&nbsp;&nbsp;\n");
  print("    <input type=\"hidden\" value=\"delete\" name=\"a\">\n");
  print("    <input type=\"submit\" value=\"L&ouml;schen\" name=\"go\">\n");
  print("   </td>\n");
  print(" </tr>\n");
  print(" <tr>\n");
  print("   <td class=\"tabletitle\" width=\"60\"><b>ID</b></td>\n");
  print("   <td class=\"tabletitle\" width=\"470\"><b>Name</b></td>\n");
  print("   <td class=\"tabletitle\" width=\"130\"><b>Uploader</b></td>\n");
  print("   <td class=\"tabletitle\" width=\"75\"><b>Letzte Aktivit&auml;t</b></td>\n");
  print("   <td class=\"tabletitle\" width=\"60\"><b>L&ouml;schen</b></td>\n");
  print(" </tr>\n");

  while ($death_torrent = @mysql_fetch_assoc($res_death_torrents))
  {
    $res_uploader_name = mysql_query("SELECT username FROM users WHERE id=$death_torrent[owner]");
    $uploader_name = mysql_fetch_assoc($res_uploader_name);
    print(" <tr>\n");
	print("  <td class=\"tablea\"><b><a href=\"tfilesinfo.php?id=" . $death_torrent[id] . "\">" . $death_torrent[id] . "</a></b></td>\n");	
    print("  <td class=\"tablea\"><b><a href=\"tfilesinfo.php?id=" . $death_torrent[id] . "\">" . $death_torrent[name] . "</a></b></td>\n");
    print("  <td class=\"tablea\"><a href=\"userdetails.php?id=" . $death_torrent[owner] . "\">". $uploader_name[username] . "</a></td>\n");
    print("  <td class=\"tablea\">" . $death_torrent[last_action] . "</td>\n");
    print("  <td class=\"tablea\"><center><input type=\"checkbox\" name=\"deltorr[]\" value=\"" . $death_torrent[id] . "\" /></center></td>\n");
    print(" </tr>\n");
  }

  print("</table>\n");
print"            </div>";  
  print("</form>\n");

echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";  
}

x264_admin_footer(true);
?>