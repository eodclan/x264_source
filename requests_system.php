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

if (is_dir($_SERVER["DOCUMENT_ROOT"] . "include")) $doc_root = $_SERVER["DOCUMENT_ROOT"];
else $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";

require_once($doc_root . "include/engine.php");

dbconn();
loggedinorreturn();

if (get_user_class() < UC_USER){
stderr("Fehler","Zugriff erst ab Rang User!!!");
}

if (isset($_GET["action"])) $action = trim(htmlentities($_GET["action"]));
elseif (isset($_POST["action"])) $action = trim(htmlentities($_POST["action"]));
else $action = "view";

$can_mod  = UC_MODERATOR;

$res = mysql_query("SELECT * FROM categories where type = 1");
$cats="<select name=cat class=\"btn btn-flat btn-primary fc-today-button btn-secondary dropdown-toggle\">\n";
while($r=mysql_fetch_assoc($res))
$cats.="<option value=$r[id]>$r[name]</option>\n";
$cats.="</select>\n";
$newcats .= "<select name=\"type\" class=\"btn btn-flat btn-primary fc-today-button btn-secondary dropdown-toggle\">\n<option value=\"0\">(ausw&auml;hlen)</option>\n"; 
$res = mysql_query("SELECT * FROM categories where type = 1") OR sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res)) 
{
  $newcats .= "<optgroup label=\"" . $arr["name"] . "\"\n>"; 
  $resa = mysql_query("SELECT * FROM categories where haupt = " . $arr["id"] . "") OR sqlerr(__FILE__, __LINE__);
  while ($arra = mysql_fetch_assoc($resa)) 
  {
    $newcats .= "<option value=\"" . $arra["id"] . "\">" . htmlspecialchars($arra["name"]) . "</option>\n";
  }
  $newcats .= "</optgroup>\n";
}
$newcats .= "</select>\n";
function neu()
{
print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Eintragen
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> &Uuml;berpr&uuml;fe bitte ob dein Request schon gesucht wird!	
					<form action='" . $_SERVER[PHP_SELF] . "' method='POST'>
						<input type='hidden' value='neu' name='action'>
						<input type='submit' value='Request Eintragen' class='btn btn-primary btn-sm text-center'>
					</form>		
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";
}

x264_header("Requests System");

if ($action == "neu")
{
  print("\n<form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"POST\">\n");
  print("<input type=\"hidden\" value=\"insert\" name=\"action\">\n");
  
print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-balance-scale'></i>Request eintragen
                    <div class='card-actions'>
                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                    </div>
                </div>
                <div class='card-block'>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>Kategorie</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>
                                    " .$cats. "
                                </div>
                                <p class='help-block'>Bitte die richtige Kategorie nehmen!</p>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label class='form-control-label' for='appendedInput'>Prefix</label>
                            <div class='controls'>
                                <div class='input-group'>
                                    <select name='prefix' class='btn btn-flat btn-primary fc-today-button'><option value='1'>suche:</option><option value='2'>biete:</option></select>
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label class='form-control-label' for='appendedPrependedInput'>Titel</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>
                                    <input type='text' name='titel' value='' size='80' maxlength='250' class='btn btn-flat btn-primary fc-today-button'>
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label class='form-control-label' for='appendedInputButton'>Beschreibung</label>
                            <div class='controls'>
                                <div class='input-group'>
                                        <textarea name='info' cols='77' rows='10' class='btn btn-flat btn-primary fc-today-button'>" . htmlentities(trim($arr["info"])) . "</textarea>
                                </div>
                            </div>
                        </div>
                        <div class='form-actions'>
                            <input type='submit' value='Eintragen' class='btn btn-flat btn-primary fc-today-button'>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>"; 
  print("</form>\n");
}

if ($action == "insert")
{
  $cat        = intval($_POST["cat"]);
  $info       = htmlentities(trim($_POST["info"]));
  $added      = get_date_time(time());

  if ($_POST["prefix"] == 1)
  $titel = "<font color=red>Suche:&nbsp;</font>";
  else
  $titel = "<font color=green>Biete:&nbsp;</font>";

  $titel.= htmlentities(trim($_POST["titel"]));

  if($titel != "" && $info != "")
  {
   $sql  = "INSERT INTO requests SET user = " . intval($CURUSER["id"]) . ", kategorie = " . $cat . ",titel = " . sqlesc($titel) . ", info = " . sqlesc($info) . ", added = " . sqlesc($added) . "";
   $res  = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
   $sql1 = "INSERT INTO votes SET what = 'requests', user = " . intval($CURUSER["id"]) . ", voteid = " . mysql_insert_id();
   $res1 = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);

   if($CURUSER["anon"] == "yes")
   $text = "Ein Anonymer User hat einen neuen Request eingetragen. Guckt mal bitte ob jemand ihn erfüllen kannst. Danke!";
   else
   $text = "Der User $CURUSER[username] hat einen neuen Request eingetragen. Guckt mal bitte ob jemand ihn erfüllen kannst. Danke!";

   $date = time();
   mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES ('id', " . sqlesc('0') . ", " . sqlesc('System') . ", $date, " . sqlesc($text) . ")");
   }
   else
print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Fehler
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> Alle Felder m&uuml;ssen ausgef&uuml;llt werden!&nbsp;<a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";	   

print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request " . $titel . " eingetragen
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> <a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";
}

if (($action == "update") AND (get_user_class() >= $can_mod))
{
  $id         = intval($_POST["id"]);
  $cat        = intval($_POST["cat"]);
  $info       = htmlentities(trim($_POST["info"]));

  if ($_POST["prefix"] == 1)
  $titel = "<font color=red>Suche:&nbsp;</font>";
  else
  $titel = "<font color=green>Biete:&nbsp;</font>";

  $titel.= htmlentities(trim($_POST["titel"]));

  if($titel != "" && $info != "")
  {
  $sql = "UPDATE requests SET titel = " . sqlesc($titel) . ", info = " . sqlesc($info) . ", kategorie = " . sqlesc($cat) . " WHERE id = " . $id . " LIMIT 1";
  mysql_query($sql) or sqlerr(__FILE__, __LINE__);
  }
  else
    stderr("FEHLER", "Alle Felder m&uuml;ssen ausgef&uuml;llt werden!&nbsp;<a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>");

print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request " . $titel . " bearbeitet
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> <a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";
}

if (($action == "delete") AND (get_user_class() >= $can_mod))
{
    $voteid = intval($_GET["id"]);
    $sql    = "DELETE FROM votes WHERE what = 'requests' and voteid = " . $voteid . "";
    mysql_query($sql) or sqlerr(__FILE__, __LINE__);
    $sql1   = "DELETE FROM requests WHERE id =  " . $voteid . "";
    mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
    $sql3   = "DELETE FROM requestcomments WHERE commentid =  " . $voteid . "";
    mysql_query($sql3) or sqlerr(__FILE__, __LINE__);
    $sql2   = "SELECT titel FROM requests WHERE id = " . $voteid . " LIMIT 1";
    $res    = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
    $arr    = mysql_fetch_array($res);

print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request " . $arr["titel"] . " gel&ouml;scht
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> <a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";	
}

if (($action == "edit") AND (get_user_class() >= $can_mod))
{
    $voteid = intval($_GET["id"]);
    $sql    = "SELECT * FROM requests WHERE id = " . $voteid . " LIMIT 1";
    $res    = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
    $arr    = mysql_fetch_array($res);

    print("\n<form action='" . $_SERVER[PHP_SELF] . "' method='POST'>\n");
    print("<input type='hidden' value='update' name='action'>\n");
    print("<input type='hidden' value='" . intval($voteid) . "' name='id'>\n");
print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Request <u>" . $arr["titel"] . "</u> bearbeiten</h1>
	<div class='x264_title_content'>";
	
    print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
    print("  <tr>\n");
    print("    <td class=\"tablea\">Kategorie</td>\n");
    print("    <td class=\"tablea\">" . $cats . "</td>\n");
    print("  </tr>\n");
    print("  <tr>\n");
    print("    <td class=\"tablea\">Prefix</td>\n");
    print("    <td class=\"tablea\"><select name=\"prefix\"><option value=\"1\">suche:</option>\n<option value=\"2\">biete:</option>\n</select></td>\n");
    print("  </tr>\n");
    print("  <tr>\n");
    print("    <td class=\"tablea\">Titel</td>\n");
    print("    <td class=\"tablea\"><input type=\"text\" name=\"titel\" value=\"" . $arr["titel"] . "\" size=\"80\"></td>\n");
    print("  </tr>\n");
    print("  <tr>\n");
    print("    <td class=\"tablea\">Beschreibung</td>\n");
    print("    <td class=\"tablea\"><textarea name=\"info\" cols=\"77\" rows=\"10\">" . htmlentities(trim($arr["info"])) . "</textarea></td>\n");
    print("  </tr>\n");

    print("  <tr>\n");
    print("    <td class=\"tabletitle\" width=\"100%\" colspan=\"2\"><center><input type=\"submit\" value=\"Speichern\"></center></td>\n");
    print("  </tr>\n");
    print("</table>\n");
print"		
	</div>
</div>
</div>";	
    print("</form>\n");
}

if ($action == "closed")
{
    $tid = intval($_POST["tid"]);
    $id  = intval($_POST["id"]);

    if($tid > 0)
    {
    $sql    = "SELECT user FROM requests WHERE id = " . $id . " LIMIT 1";
    $res1   = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
    $arr    = mysql_fetch_array($res1);
    $res    = mysql_query("SELECT * FROM torrents where id = ".sqlesc($tid)); // Changed for PN
    if(mysql_num_rows($res) === 1 AND intval($arr["user"]) != intval($CURUSER["id"]))
    {
      $closedate = get_date_time(time());
      mysql_query("UPDATE requests SET closed = ".sqlesc($tid).", ruser = ".intval($CURUSER["id"]).", closedate = ".sqlesc($closedate)." where id = $id");
      $bonus = get_config_data("RSEED_BONUS");
      $bonus = str_replace(",", ".", $bonus);
      $bonus = floatval($bonus);
      mysql_query("UPDATE users SET seedbonus = seedbonus + $bonus WHERE id = '".intval($CURUSER["id"])."'") or sqlerr(__FILE__, __LINE__);
      $torrent = mysql_fetch_assoc($res);
      $r       = mysql_fetch_assoc(mysql_query("SELECT user, titel FROM requests where id = $id"));
      $a       = mysql_fetch_assoc(mysql_query("SELECT user FROM votes where voteid = $id"));
      $votesid = $a["user"];
      $destid  = $r["user"];
      if($CURUSER["anon"] == "yes") {
      $text = "Ein Anonymer User hat einen Request erledigt. Danke dir. $torrent[name]";
      $user = "Ein Anonymer* User";
      }else{
      $text = "Der User $CURUSER[username] hat einen Request erledigt. Vielen Dank dafür. $torrent[name]";
      $user = "Der User [url=userdetails.php?id=$CURUSER[id]]$CURUSER[username][/url]";
      }
      $date = time();
	  $subject = "Request System";
	  $msg = "Ein User hat dein Request bearbeitet! Bitte schau in unseren Request System nach dein Request.";
	  mysql_query("INSERT INTO messages (poster, sender, receiver, folder_in, subject, added, msg) VALUES(0, 0, '" .$destid. "', -1, " .sqlesc($subject) . ", '" . get_date_time() . "', " .sqlesc($msg) . ")") or sqlerr(__FILE__, __LINE__);	  
      //sendPersonalMessage(0, $destid, "Request erfüllt", "" .$user. " hat Deinen Request $r[titel] mit dem Torrent $torrent[name] erfüllt.");
      //sendPersonalMessage(0, $votesid, "Request erfüllt", "" .$user. " hat denn Request $r[titel] mit dem Torrent $torrent[name] erfüllt.");
      //mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES ('id'," . sqlesc('0') . ", " . sqlesc('System') . ", $date, " . sqlesc($text) . ")");

print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request " . $r["titel"] . " Erf&uuml;llt
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> <a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";	  	  
    }
    else
print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Fehler
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> Ein Torrent mit der ID $tid gibt es nicht, oder es ist etwas anderes Falsch gelaufen.&nbsp;<a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";		
  }
  else
print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Fehler
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> Du musst die ID des Torrents angeben (steht bei den Torrent-Details in der Browser-Zeile!)&nbsp;<a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";	  
}

if ($action == "vote")
{
      $voteid  = intval($_GET["id"]);
      $sql     = "SELECT id FROM votes WHERE what = 'requests' and voteid = $voteid and user = " . intval($CURUSER["id"]) . "";
      $res     = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
      $sql1    = "SELECT user FROM votes WHERE what = 'requests' and voteid = $voteid";
      $res1    = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);

      if(mysql_num_rows($res) === 0)
      {
      mysql_query("INSERT INTO votes (what,user,voteid) VALUES ('requests',$CURUSER[id],$voteid)");

print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Vote erfolgreich
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> <a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";	  	  
      }
      else
      {
      print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
      print("  <tr>\n");
      print("    <td class=\"tabletitle\" width=\"100%\"><center><b>.: Alle User die gevotet haben :.</b></center></td>\n");
      print("  </tr>\n");
      while ($arr1 = mysql_fetch_array($res1))
      {

      $id      = intval($arr1["user"]);
      $sql2    = "SELECT username, class, added, avatar, uploaded, downloaded, webseed, vdsl, adsl, enabled, warned, donor, anon FROM users WHERE id = '$id'";
      $res2    = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
      $arr2    = mysql_fetch_array($res2);

      if ($arr2["added"] == "0000-00-00 00:00:00")
      $joindate = 'N/A';
      else
      $joindate = "Reg.: " . get_elapsed_time(sql_timestamp_to_unix_timestamp($arr2["added"])) . "";

      if ($arr2["avatar"])
      $avatarover = $arr2["avatar"];
      elseif (!$arr2["avatar"])
      $avatarover = $GLOBALS["PIC_BASE_URL"] . "default_avatar.gif";

      $uploaded   = mksize($arr2["uploaded"]);
      $downloaded = mksize($arr2["downloaded"]);
      if ($arr2["downloaded"] > 0)
      {
      $ratio = number_format($arr2["uploaded"] / $arr2["downloaded"], 3);
      $ratio = "<font color=" . get_ratio_color($ratio) . ">$ratio</font>";
      }
      else
      if ($arr2["uploaded"] > 0)
      $ratio = "Inf.";
      else
      $ratio = "---";

      if ($arr2["webseed"] == "yes")
      $webs = "WEBSEED";
      else
      $webs = "";

      if  ($arr2["adsl"] == "yes")
      $adsl = "ADSL";
      else
      $adsl = "";

      if  ($arr2["vdsl"] == "yes")
      $vdsl = "VDSL";
      else
      $vdsl = "";

      $icons     = array("enabled" => $arr2["enabled"], "warned" => $arr2["warned"], "donor" => $arr2["donor"]);
      if(($arr2["anon"] == "yes") AND (get_user_class() < $can_mod))
      $voteuser  = "<font color=\"#FFFFFF\">Anonym*</font>";
      else
      $voteuser  = "<a href=userdetails.php?id=".$id. " onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=left ><br><center><img align=center src=$avatarover height=90 width=80></center><br> <font color=green>UP: $uploaded</font><br> <font color=darkred>DL: $downloaded</font><br>Ratio: <font color=" . get_ratio_color($ratio) . ">".$ratio."</font><br>$joindate<br><font color=red>$adsl $vdsl $webs </font></div>', CAPTION, '');\" onmouseout=\"return nd();\"><font class=".get_class_color($arr2["class"]).">".htmlentities($arr2["username"])."</a>&nbsp;" .get_user_icons($icons). "";

      print("  <tr>\n");
      print("    <td class=\"tablea\" width=\"100%\">" . $voteuser . "</td>\n");
      print("  </tr>\n");
      }
      print("  <tr>\n");
      print("    <td class=\"tablea\" width=\"100%\"><div class='alert-box notice'><span>notice: </span><a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a></div></td>\n");
      print("  </tr>\n");
      print("</table>\n");
      }
}

if (($action == "voter") AND (get_user_class() >= $can_mod))
{
      $voteid  = intval($_GET["id"]);
      $sql1    = "SELECT user FROM votes WHERE what = 'requests' and voteid = $voteid";
      $res1    = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);

      print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
      print("  <tr>\n");
      print("    <td class=\"tabletitle\" width=\"100%\"><center><b>.: Alle User die gevotet haben :.</b></center></td>\n");
      print("  </tr>\n");
      while ($arr1 = mysql_fetch_array($res1))
      {

      $id      = intval($arr1["user"]);
      $sql2    = "SELECT username, class, added, avatar, uploaded, downloaded, webseed, vdsl, adsl, enabled, warned, donor, anon FROM users WHERE id = '$id'";
      $res2    = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
      $arr2    = mysql_fetch_array($res2);

      if ($arr2["added"] == "0000-00-00 00:00:00")
      $joindate = 'N/A';
      else
      $joindate = "Reg.: " . get_elapsed_time(sql_timestamp_to_unix_timestamp($arr2["added"])) . "";

      if ($arr2["avatar"])
      $avatarover = $arr2["avatar"];
      elseif (!$arr2["avatar"])
      $avatarover = $GLOBALS["PIC_BASE_URL"] . "default_avatar.gif";

      $uploaded   = mksize($arr2["uploaded"]);
      $downloaded = mksize($arr2["downloaded"]);
      if ($arr2["downloaded"] > 0)
      {
      $ratio = number_format($arr2["uploaded"] / $arr2["downloaded"], 3);
      $ratio = "<font color=" . get_ratio_color($ratio) . ">$ratio</font>";
      }
      else
      if ($arr2["uploaded"] > 0)
      $ratio = "Inf.";
      else
      $ratio = "---";

      if ($arr2["webseed"] == "yes")
      $webs = "WEBSEED";
      else
      $webs = "";

      if  ($arr2["adsl"] == "yes")
      $adsl = "ADSL";
      else
      $adsl = "";

      if  ($arr2["vdsl"] == "yes")
      $vdsl = "VDSL";
      else
      $vdsl = "";

      $icons     = array("enabled" => $arr2["enabled"], "warned" => $arr2["warned"], "donor" => $arr2["donor"]);
      if(($arr2["anon"] == "yes") AND (get_user_class() < $can_mod))
      $voteuser  = "<font color=\"#FFFFFF\">Anonym*</font>";
      else
      $voteuser  = "<a href=userdetails.php?id=".$id. " onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=left ><br><center><img align=center src=$avatarover height=90 width=80></center><br> <font color=green>UP: $uploaded</font><br> <font color=darkred>DL: $downloaded</font><br>Ratio: <font color=" . get_ratio_color($ratio) . ">".$ratio."</font><br>$joindate<br><font color=red>$adsl $vdsl $webs </font></div>', CAPTION, '');\" onmouseout=\"return nd();\"><font class=".get_class_color($arr2["class"]).">".htmlentities($arr2["username"])."</a>&nbsp;" .get_user_icons($icons). "";

      print("  <tr>\n");
      print("    <td class=\"tablea\" width=\"100%\">" . $voteuser . "</td>\n");
      print("  </tr>\n");
      }
      print("  <tr>\n");
      print("    <td class=\"tablea\" width=\"100%\"><div class='alert-box notice'><span>notice: </span><a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a></div></td>\n");
      print("  </tr>\n");
      print("</table>\n");
}

if ($action == "reopen" AND get_user_class() >= $can_mod)
{
      $id = intval($_GET["id"]);
      mysql_query("UPDATE requests SET closed = 0, closedate = '0000-00-00 00:00:00' WHERE id = $id") or sqlerr(__FILE__, __LINE__);

      $bonus = get_config_data("RSEED_BONUS");
      $bonus = str_replace(",", ".", $bonus);
      $bonus = floatval($bonus);
      $ruser = mysql_fetch_assoc(mysql_query("SELECT ruser FROM requests WHERE id = $id"));
      mysql_query("UPDATE users SET seedbonus = seedbonus - $bonus WHERE id = '".$ruser["ruser"]."'") or sqlerr(__FILE__, __LINE__);

print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request geöffnet
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> <a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";	  
}

if ($action == "info")
{
     $infoid = intval($_GET["id"]);
     $sql    = "SELECT titel, info FROM requests WHERE id = " . $infoid . " LIMIT 1";
     $res    = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
     $arr    = mysql_fetch_array($res);

print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Beschreibung von " . $arr["titel"] . "
                </div>
                <div class='card-block'>
					<span>" . $arr["info"] . "</span>
					<span><i class='fa fa-check-square-o'></i></span> <a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";	 
}

if ($action == "comments")
{
    $voteid  = intval($_GET["id"]);
    $sql     = "SELECT titel, user FROM requests WHERE id = " . $voteid . " LIMIT 1";
    $res     = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
    $arr     = mysql_fetch_array($res);
    $sql1    = "SELECT id, comments, user, datum FROM requestcomments WHERE commentid = " . $voteid . " ORDER BY datum DESC";
    $res1    = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);

    print("<table summary='' cellpadding='4' cellspacing='1' border='0' style='width:100%;' class='tableinborder'>\n");
    print("  <tr>\n");
    print("    <td class='tabletitle' colspan='3' width='100%'><center><b>.: Kommentare zu <u>" . $arr["titel"] . "</u> :.</b></center></td>\n");
    print("  </tr>\n");
    while ($arr1 = mysql_fetch_array($res1))
    {

    $id      = intval($arr1["user"]);
    $idd     = intval($arr1["id"]);
    $sql2    = "SELECT id, username, class, added, avatar, uploaded, downloaded, webseed, vdsl, adsl, enabled, warned, donor, anon FROM users WHERE id = '$id' LIMIT 1";
    $res2    = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
    $arr2    = mysql_fetch_array($res2);

    if ($arr2["added"] == "0000-00-00 00:00:00")
    $joindate = 'N/A';
    else
    $joindate = "Reg.: " . get_elapsed_time(sql_timestamp_to_unix_timestamp($arr2["added"])) . "";

    if ($arr2["avatar"])
    $avatarover = $arr2["avatar"];
    elseif (!$arr2["avatar"])
    $avatarover = $GLOBALS["PIC_BASE_URL"] . "default_avatar.gif";

    $uploaded   = mksize($arr2["uploaded"]);
    $downloaded = mksize($arr2["downloaded"]);
    if ($arr2["downloaded"] > 0)
    {
    $ratio = number_format($arr2["uploaded"] / $arr2["downloaded"], 3);
    $ratio = "<font color=" . get_ratio_color($ratio) . ">$ratio</font>";
    }
    else
    if ($arr2["uploaded"] > 0)
    $ratio = "Inf.";
    else
    $ratio = "---";

    if ($arr2["webseed"] == "yes")
    $webs = "WEBSEED";
    else
    $webs = "";

    if  ($arr2["adsl"] == "yes")
    $adsl = "ADSL";
    else
    $adsl = "";

    if  ($arr2["vdsl"] == "yes")
    $vdsl = "VDSL";
    else
    $vdsl = "";

    $icons = array("enabled" => $arr2["enabled"], "warned" => $arr2["warned"], "donor" => $arr2["donor"]);
    if(($arr2["anon"] == "yes") AND (get_user_class() < $can_mod))
    $user  = "<font color='#FFFFFF'>Anonym*</font>";
    else
    $user  = "<a href=userdetails.php?id=".$id. " onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=left ><br><center><img align=center src=$avatarover height=90 width=80></center><br> <font color=green>UP: $uploaded</font><br> <font color=darkred>DL: $downloaded</font><br>Ratio: <font color=" . get_ratio_color($ratio) . ">".$ratio."</font><br>$joindate<br><font color=red>$adsl $vdsl $webs </font></div>', CAPTION, '');\" onmouseout=\"return nd();\"><font class=".get_class_color($arr2["class"]).">".htmlentities($arr2["username"])."</a>&nbsp;" .get_user_icons($icons). "";

    if  (mysql_num_rows($res1) != 0)
    $comments = "" . htmlentities(trim($arr1["comments"])) . "";
    else
    $comments = "<font color='#FF0000'>Keine Kommentare zu diesem Request</font>";

    $datum = htmlentities($arr1["datum"]);

    print("  <tr>\n");
    print("    <td class=\"tablea\" colspan=\"3\" width=\"100%\">" . $comments . "</td>\n");
    print("  </tr>\n");
    print("  <tr>\n");
    print("    <td class=\"tablea\" width=\"77%\"><font color=\"#FFFFFF\">Von:</font>&nbsp;" . $user . "&nbsp;</td>\n");
    if ((intval($arr2["id"]) == intval($CURUSER["id"])) AND ($id == intval($arr2["id"])) OR (get_user_class() >= $can_mod))
    print("    <td class=\"tablea\" width=\"6%\"><a href=\"" . $_SERVER[PHP_SELF] . "?action=commentedit&id=$voteid&idd=$idd\"><img src=\"$GLOBALS[PIC_BASE_URL]/edit.png\" border=\"0\" /></a>&nbsp;<a href=\"" . $_SERVER[PHP_SELF] . "?action=deletecomment&id=$voteid&idd=$idd\"><img src=\"$GLOBALS[PIC_BASE_URL]/buttons/button_none.gif\" border=\"0\" /></a></td>\n");
    else
    print("    <td class=\"tablea\" width=\"6%\"><center><img src=\"$GLOBALS[PIC_BASE_URL]/disabledbig.png\" border=\"0\" /></center></td>\n");
    print("    <td class=\"tablea\" width=\"17%\"><font color=\"#FFFFFF\">Am:</font>&nbsp;<font color=\"#FF0000\">" . $datum . "</font></td>\n");
    print("  </tr>\n");
    }
    print("  <tr>\n");
    print("    <td class=\"tablea\" colspan=\"3\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "?action=commentwrite&id=$voteid\"><font color=\"#FF0000\">Kommentar hinzufÃ¼gen</font></a></b>&nbsp;oder&nbsp;<b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
    print("  </tr>\n");
    print("</table>\n");
}

if ($action == "commentwrite")
{
    $voteid  = intval($_GET["id"]);
    $sql     = "SELECT titel FROM requests WHERE id = " . $voteid . " LIMIT 1";
    $res     = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
    $arr     = mysql_fetch_array($res);
    $sql1    = "SELECT comments FROM requestcomments WHERE commentid = " . $voteid . " LIMIT 1";
    $res1    = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
    $arr1    = mysql_fetch_array($res1);

    print("\n<form action='" . $_SERVER[PHP_SELF] . "' method='POST'>\n");
    print("<input type='hidden' value='insertcomment' name='action'>\n");
    print("<input type='hidden' value='" . intval($voteid) . "' name='id'>\n");

print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Kommentar zu " . $arr["titel"] . " eintragen
                </div>
                <div class='card-block'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>Kommentar</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>
                                    <textarea name='comments' cols='77' rows='10' class='btn btn-flat btn-primary fc-today-button'></textarea>
                                </div>
                                <p class='help-block'>Bitte die richtige Kategorie nehmen!</p>
                            </div>
                        </div>
                        <div class='form-actions'>
                            <input type='submit' value='Eintragen' class='btn btn-flat btn-primary fc-today-button'>
                        </div>		
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";	
    print("</form>\n");
}

if ($action == "insertcomment")
{
  $id      = intval($_POST["id"]);
  $comment = trim($_POST["comments"]);
  $datum   = get_date_time(time());
  $sql     = "SELECT user FROM requests WHERE id = " . $id . " LIMIT 1";
  $res     = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
  $arr     = mysql_fetch_array($res);
  $sql1    = "SELECT user FROM requestcomments WHERE commentid = " . $id . " ORDER BY datum DESC LIMIT 1";
  $res1    = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
  $arr1    = mysql_fetch_array($res1);
  $user    = intval($arr1["user"]);
  $userid  = intval($arr["user"]);

  if(intval($CURUSER["id"]) != $userid)
  {
    sendPersonalMessage(0, $userid, "Neues Kommentar", "Bei einem Request von dir, wurde ein neues Kommentar hinzugefügt. [url=" . $_SERVER[PHP_SELF] . "][b]Klicke Hier[/b][/url] dann kommst du zu den Requests.");
  }

  if(intval($CURUSER["id"]) != $user)
  {
    sendPersonalMessage(0, $user, "Neues Kommentar", "Bei einem Request wo du ein Kommentar geschrieben hast, wurde ein neues Kommentar hinzugefügt. [url=" . $_SERVER[PHP_SELF] . "][b]Klicke Hier[/b][/url] dann kommst du zu den Requests.");
  }

  if($comment != "")
  {
    $sql = "INSERT INTO requestcomments SET comments = ".sqlesc($comment).", user = ".intval($CURUSER["id"]).", datum = ".sqlesc($datum).", commentid = " . $id . "";
    mysql_query($sql) or sqlerr(__FILE__, __LINE__);
  }
  else
  {
print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Kommentar eingetragen
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> <a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";	  
  }
print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Kommentar eingetragen
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> <a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";
}

if ($action == "commentedit")
{
    $voteid  = intval($_GET["id"]);
    $idd     = intval($_GET["idd"]);
    $sql     = "SELECT titel FROM requests WHERE id = " . $voteid . " LIMIT 1";
    $res     = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
    $arr     = mysql_fetch_array($res);

    print("\n<form action='" . $_SERVER[PHP_SELF] . "' method='POST'>\n");
    print("<input type='hidden' value='insertcommentedit' name='action'>\n");
    print("<input type='hidden' value='" . intval($voteid) . "' name='id'>\n");
    print("<input type='hidden' value='" . intval($idd) . "' name='idd'>\n");

print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Kommentar zu " . $arr["titel"] . " bearbeiten
                </div>
                <div class='card-block'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>Kommentar</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>
                                    <textarea name='comments' cols='77' rows='10' class='btn btn-flat btn-primary fc-today-button'></textarea>
                                </div>
                                <p class='help-block'>Bitte die richtige Kategorie nehmen!</p>
                            </div>
                        </div>
                        <div class='form-actions'>
                            <input type='submit' value='&auml;ndern' class='btn btn-flat btn-primary fc-today-button'>
                        </div>		
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";		
    print("</form>\n");
}

if ($action == "insertcommentedit")
{
  $id      = intval($_POST["id"]);
  $idd     = intval($_POST["idd"]);
  $sql     = "SELECT id, user FROM requestcomments WHERE commentid = " . $id . " AND id = " . $idd . " LIMIT 1";
  $res     = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
  $arr     = mysql_fetch_array($res);
  $iddd    = intval($arr["id"]);
  $comment = trim($_POST["comments"]);
  $datum   = get_date_time(time());

  if($comment != "" AND (intval($CURUSER["id"]) == $arr["user"]) OR (get_user_class() >= $can_mod))
  {
    $sql = "UPDATE requestcomments SET comments = ".sqlesc($comment).", datum = ".sqlesc($datum)." WHERE commentid = " . $id . " AND id = " . $iddd . " LIMIT 1";
    mysql_query($sql) or sqlerr(__FILE__, __LINE__);
  }
  else
  {
print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Fehler
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> <a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";	  
  }
print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Kommentar bearbeitet
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> <a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";
}

if ($action == "deletecomment")
{
   $id  = intval($_POST["id"]);
   $idd = intval($_GET["idd"]);
   $sql = "SELECT id, user FROM requestcomments WHERE commentid = " . $id . " AND id = " . $idd . " LIMIT 1";
   $res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
   $arr = mysql_fetch_array($res);
   $iddd= intval($arr["id"]);

   if((intval($CURUSER["id"]) == $arr["user"]) OR (get_user_class() >= $can_mod))
   {
    $sql = "DELETE FROM requestcomments WHERE commentid =  " . $id . " AND id = " . $iddd . " LIMIT 1";
    mysql_query($sql) or sqlerr(__FILE__, __LINE__);
   }

print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request Kommentar gelöscht
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> <a href='" . $_SERVER[PHP_SELF] . "'><font color='#008000'>weiter &rArr;</font></a>	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";      
}

if ($action == "view")
{
  neu();

print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Request System
                </div>
                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>
                                <th>Kategorie</th>
                                <th>Titel</th>
                                <th>Von</th>
                                <th>Vom</th>
                                <th>Votes</th>
                                <th>Erf&uuml;llt</th>
                                <th>Optionen</th>								
                            </tr>
                        </thead>";

  $sql1    = "SELECT count(titel) FROM requests";
  $res1    = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
  $row     = mysql_fetch_array($res1);
  $url     = " .$_SERVER[PHP_SELF]?";
  $count   = $row[0];
  $perpage = 15;
  list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $url);
  $sql     = "SELECT requests.*,count(votes.id) as votes,categories.name,categories.image,users.username,users.class,users.added,users.avatar,users.uploaded,users.downloaded,users.webseed,users.vdsl,users.adsl,users.enabled,users.warned,users.donor,users.anon FROM requests,votes,categories,users WHERE votes.what='requests' and votes.voteid=requests.id and categories.id=requests.kategorie and users.id=requests.user GROUP BY requests.id ORDER BY requests.added desc $limit";
  $res     = mysql_query($sql) or sqlerr(__FILE__, __LINE__);

  if (mysql_num_rows($res) == 0)
  {
print "
					<span><i class='fa fa-check-square-o'></i></span> Keine Requests eingetragen";
  }
  else
    while ($arr = mysql_fetch_array($res))
    {
      $id     = intval($arr["id"]);

      $sql1     = "SELECT user, ruser, info, closedate, added FROM requests WHERE id = " . $id . " LIMIT 1";
      $res1     = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
      $self     = mysql_fetch_array($res1);
      $sql2     = "SELECT comments, user FROM requestcomments WHERE commentid = " . $id . " ORDER BY datum DESC LIMIT 1";
      $res2     = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
      $arr2     = mysql_fetch_array($res2);
      $sql3     = "SELECT id, username, class, anon FROM users WHERE id = " . intval($self["ruser"]) . " LIMIT 1";
      $res3     = mysql_query($sql3) or sqlerr(__FILE__, __LINE__);
      $arr3     = mysql_fetch_array($res3);
      $sql4     = "SELECT count(id) as commentvote FROM requestcomments WHERE commentid = " . $id . " GROUP BY commentid LIMIT 1";
      $res4     = mysql_query($sql4) or sqlerr(__FILE__, __LINE__);
      $arr4     = mysql_fetch_array($res4);
      $sql5     = "SELECT username, class, anon FROM users WHERE id = " . intval($arr2["user"]) . " LIMIT 1";
      $res5     = mysql_query($sql5) or sqlerr(__FILE__, __LINE__);
      $arr5     = mysql_fetch_assoc($res5);

      if(($arr5["anon"] == "yes") AND (get_user_class() < UC_MODERATOR))
      $cwname       = "<font color=white>Anonym*</font>";
      else
      $cwname       = "<font class=" . get_class_color($arr5["class"]) . ">" . htmlentities($arr5["username"]) . "</font>";

      $beschreibung = htmlentities($self["info"]);

      $kommentar    = htmlentities($arr2["comments"]);

      $datum        = sqlesc(get_date_time(gmtime() - 86400*4));

      $zeit         = sqlesc($self["closedate"]);

      if(($arr3["anon"] == "yes") AND (get_user_class() < $can_mod))
      $erfÃ¼llt      = "<font color=white>Anonym*</font>";
      else
      $erfÃ¼llt      = "<font class=" . get_class_color($arr3["class"]) . ">" . htmlentities($arr3["username"]) . "</font>";

      if (($zeit <= $datum))
      $erfuellt      = "<font color=\"#FF0000\"><b>Erf&uuml;llt</b></font>";
      else
      $erfuellt      = "<font color=\"#008000\"><b>Erf&uuml;llt</b></font>";

      if (strlen($arr["titel"]) > 70)
      $titel         = substr($arr["titel"], 0, 65) . "...";
      else
      $titel         = $arr["titel"];

      if  ($arr["votes"] >= 2 AND $arr["votes"] <= 4)
      $votes = "<font color=\"#008000\">" . intval($arr["votes"]) . "</font>";
      elseif ($arr["votes"] >= 5)
      $votes = "<font color=\"#FF0000\">" . intval($arr["votes"]) . "</font>";
      else
      $votes = "<font color=\"#FFFFFF\">" . intval($arr["votes"]) . "</font>";

      if  ($arr2["comments"] != "")
      $comments = "<a href=\"" . $_SERVER[PHP_SELF] . "?action=comments&id=$id\" onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=center><font color=red><b>Kommentar</b></font><br><br>$kommentar<br><br><font color=red>Von<br>$cwname</font></div></td></tr></table>', CAPTION, '');\" onmouseout=\"return nd();\"><b><font color=\"#008000\">Lesen</font></b></a>&nbsp;(" .intval($arr4["commentvote"]). ")";
      else
      $comments = "<font color=\"#FF0000\"><b>Lesen</b></font>&nbsp;(0)";

      if ($arr["added"] == "0000-00-00 00:00:00")
      $joindate = 'N/A';
      else
      $joindate = "Reg.: " . get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"])) . "";

      if ($arr["avatar"])
      $avatarover = $arr["avatar"];
      elseif (!$arr["avatar"])
      $avatarover = $GLOBALS["PIC_BASE_URL"] . "default_avatar.gif";

      $uploaded   = mksize($arr["uploaded"]);
      $downloaded = mksize($arr["downloaded"]);
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

      if ($arr["webseed"] == "yes")
      $webs = "WEBSEED";
      else
      $webs = "";

      if  ($arr["adsl"] == "yes")
      $adsl = "ADSL";
      else
      $adsl = "";

      if  ($arr["vdsl"] == "yes")
      $vdsl = "VDSL";
      else
      $vdsl = "";

      $icons = array("enabled" => $arr["enabled"], "warned" => $arr["warned"], "donor" => $arr["donor"]);
      if(($arr["anon"] == "yes") AND (intval($self["user"]) != intval($CURUSER["id"])) AND (get_user_class() < $can_mod))
      $name  = "<font color=\"#FFFFFF\">Anonym*</font>";
      else
      $name  = "<a href=userdetails.php?id=".intval($arr["user"]). " onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=left><br><center><img align=center src=$avatarover height=90 width=80></center><br> <font color=green>UP: $uploaded</font><br> <font color=darkred>DL: $downloaded</font><br>Ratio: <font color=" . get_ratio_color($ratio) . ">".$ratio."</font><br>$joindate<br><font color=red>$adsl $vdsl $webs </font></div>', CAPTION, '');\" onmouseout=\"return nd();\"><font class=".get_class_color($arr["class"]).">".htmlentities($arr["username"])."</a>&nbsp;" .get_user_icons($icons). "";

print"
                        <tbody>
                            <tr>
								<td><a class=\"btn  btn-primary btn-sm text-center\" width=\"6%\" href=\"tfiles.php?cat=".$arr[id]."\"><span width=\"6%\" class=\"btn btn-primary btn-sm text-center\">Kategorie</span><br><span width=\"6%\" class=\"btn btn-primary btn-sm text-center\">".$arr[name]."</span></a></td>
                                <td><a href='" . $_SERVER[PHP_SELF] . "?action=info&id=".$id."'>" . $titel . "</a></td>
                                <td>" . $name . "</td>
                                <td>" . $self["added"] . "</td>";
      if ((get_user_class() >= $can_mod))
print"
                                <td><a href='" . $_SERVER[PHP_SELF] . "?action=vote&id=".$id."'><b>" . $votes . "</b></a>&nbsp;-&nbsp;<a href='" . $_SERVER[PHP_SELF] . "?action=voter&id=".$id."'><font color='#FFFFFF'><b>V</b></font></a></td>";
      else
print"
								<td><a href='" . $_SERVER[PHP_SELF] . "?action=vote&id=".$id."'><b>" . $votes . "</b></a></td>
                                <td>" . $comments ."&nbsp;-&nbsp;<a href='" . $_SERVER[PHP_SELF] . "?action=commentwrite&id=".$id."'><b><font color='#008000'>Schreiben</font></b></a></td>";		  
      if(intval($arr["closed"]) < 1){
print"
                                <td><form action='" . $_SERVER[PHP_SELF] . "' method='POST' style='display: inline;'><input type='hidden' name='action' value='closed' /><input type='hidden' name='id' value='".$id."' /><a href='" . $_SERVER[PHP_SELF] . "'><font color='#FF0000'><b>ID:</b></font></a>&nbsp;<input type='text' name='tid' size='5' maxlength='6' /></form></td>";		  
      }else{
      print("    <td class=\"tablea\" style=\"text-align:center\"><a href=\"tfilesinfo.php?id=$arr[closed]\" onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=center><b>Erf&uuml;llt von</b><br>$erfÃ¼llt<br><br><font color=red>Um zum File zu gelangen einfach Klicken</font></div></td></tr></table>', CAPTION, '');\" onmouseout=\"return nd();\">" . $erfuellt . "</a>\n");	  
      if ((get_user_class() >= $can_mod))
      print"					<td><a href='" . $_SERVER[PHP_SELF] . "?action=reopen&id=".$id."'><i class='fa fa-edit'></i></a></td>";
      }
      if ((get_user_class() >= UC_SYSOP) OR ($zeit <= $datum)){
      if ((get_user_class() >= $can_mod) OR (intval($self["user"]) == intval($CURUSER["id"])))
      print("    <td class=\"tablea\" style=\"text-align:center\"><a href=\"" . $_SERVER[PHP_SELF] . "?action=delete&id=$id\"><img src='pic/delete.gif' border=\"0\" /></a>&nbsp;&nbsp;<a href=\"" . $_SERVER[PHP_SELF] . "?action=edit&id=$id\"><img src=\"$GLOBALS[PIC_BASE_URL]/edit.png\" border=\"0\" /></a></td>\n");
      else
      print("    <td class=\"tablea\" style=\"text-align:center\"><font color=\"#FF0000\"><b>Keine</b></font></td>\n");
      }else{
      print("    <td class=\"tablea\" style=\"text-align:center\"><font color=\"#FF0000\"><b>Keine</b></font></td>\n");
      }
    }
print"
                            </tr>
                        </tbody>
                    </table>";
 echo $pagerbottom;
print "
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";
}

x264_footer();
?>