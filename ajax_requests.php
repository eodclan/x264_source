<?
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
header('Content-Type: text/html; charset=iso-8859-1'); 
require_once(dirname(__FILE__) . "/include/engine.php");
dbconn();
loggedinorreturn();

if($_POST['ajax'] == "yes"){

	if(isset($_POST['request']) AND $_POST['request'] == 'requests'){
		
if (isset($_GET["action"])) $action = trim(htmlentities($_GET["action"]));
elseif (isset($_POST["action"])) $action = trim(htmlentities($_POST["action"]));
else $action = "view";

$can_mod    = UC_MODERATOR;

$res = mysql_query("SELECT * FROM categories ORDER BY name");
$cats="<select name=cat>\n";
while($r=mysql_fetch_assoc($res))
$cats.="<option value=$r[id]>$r[name]</option>\n";
$cats.="</select>\n";

if ($action == "insert")
{
    $cat                = intval($_POST["cat"]);
    $info             = htmlentities(trim($_POST["info"]));
    $added            = get_date_time(time());

    if ($_POST["prefix"] == 1)
    $titel = "<font color=red>Suche:&nbsp;</font>";
    else
    $titel = "<font color=green>Biete:&nbsp;</font>";

    $titel.= htmlentities(trim($_POST["titel"]));

    if($titel != "" && $info != "")
    {
     $sql    = "INSERT INTO requests SET user = " . intval($CURUSER["id"]) . ", kategorie = " . $cat . ",titel = " . sqlesc($titel) . ", info = " . sqlesc($info) . ", added = " . sqlesc($added) . "";
     $res    = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
     $sql1 = "INSERT INTO votes SET what = 'requests', user = " . intval($CURUSER["id"]) . ", voteid = " . mysql_insert_id();
     $res1 = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);

     if($CURUSER["anon"] == "yes")
     $text = "[color=".Lime."]Ein[/color] [color=".blue."]Anonymer[/color] [color=".Lime."]User hat einen neuen Request eingetragen. Guckt mal bitte ob jemand ihn erfüllen kann. Danke![/color] [url=" .$_SERVER["PHP_SELF"]. "]Hier klicken[/url]";
     else
     $text = "[color=".Lime."]Der User[/color] [color=".blue."]$CURUSER[username][/color] [color=".Lime."]hat einen neuen Request eingetragen. Guckt mal bitte ob jemand ihn erfüllen kann. Danke![/color] [url=" .$_SERVER["PHP_SELF"]. "]Hier klicken[/url]";

     $date = time();
     mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES ('id', " . sqlesc('0') . ", " . sqlesc('System') . ", $date, " . sqlesc($text) . ")");
     }
     else
        stderr("FEHLER", "Alle Felder m&uuml;ssen ausgef&uuml;llt werden!&nbsp;<a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a>");

     print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
     print("    <tr>\n");
     print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: <u>" . $titel . "</u> eingetragen :.</b></center></td>\n");
     print("    </tr>\n");
     print("    <tr>\n");
     print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
     print("    </tr>\n");
     print("</table>\n");
}

if (($action == "update") AND (get_user_class() >= $can_mod))
{
    $id                 = intval($_POST["id"]);
    $cat                = intval($_POST["cat"]);
    $info             = htmlentities(trim($_POST["info"]));

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
        stderr("FEHLER", "Alle Felder m&uuml;ssen ausgef&uuml;llt werden!&nbsp;<a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a>");

    print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
    print("    <tr>\n");
    print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: <u>" . $titel . "</u> bearbeitet :.</b></center></td>\n");
    print("    </tr>\n");
    print("    <tr>\n");
    print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
    print("    </tr>\n");
    print("</table>\n");
}

if (($action == "delete") AND (get_user_class() >= $can_mod))
{
        $voteid = intval($_GET["id"]);
        $sql        = "DELETE FROM votes WHERE what = 'requests' and voteid = " . $voteid . "";
        mysql_query($sql) or sqlerr(__FILE__, __LINE__);
        $sql1     = "DELETE FROM requests WHERE id =    " . $voteid . "";
        mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
        $sql3     = "DELETE FROM requestcomments WHERE commentid =    " . $voteid . "";
        mysql_query($sql3) or sqlerr(__FILE__, __LINE__);
        $sql2     = "SELECT titel FROM requests WHERE id = " . $voteid . " LIMIT 1";
        $res        = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
        $arr        = mysql_fetch_array($res);

        print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
        print("    <tr>\n");
        print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: <u>" . $arr["titel"] . "</u> gel&ouml;scht :.</b></center></td>\n");
        print("    </tr>\n");
        print("    <tr>\n");
        print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
        print("    </tr>\n");
        print("</table>\n");
}

if (($action == "edit") AND (get_user_class() >= $can_mod))
{
        $voteid = intval($_GET["id"]);
        $sql        = "SELECT * FROM requests WHERE id = " . $voteid . " LIMIT 1";
        $res        = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
        $arr        = mysql_fetch_array($res);

        print("\n<form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"POST\">\n");
        print("<input type=\"hidden\" value=\"update\" name=\"action\">\n");
        print("<input type=\"hidden\" value=\"" . intval($voteid) . "\" name=\"id\">\n");
        print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
        print("    <tr>\n");
        print("        <td class=\"tabletitle\" width=\"100%\" colspan=\"2\"><center><b>.: Request <u>" . $arr["titel"] . "</u> bearbeiten :.</b></center></td>\n");
        print("    </tr>\n");

        print("    <tr>\n");
        print("        <td class=\"tablea\">Kategorie</td>\n");
        print("        <td class=\"tablea\">" . $cats . "</td>\n");
        print("    </tr>\n");
        print("    <tr>\n");
        print("        <td class=\"tablea\">Prefix</td>\n");
        print("        <td class=\"tablea\"><select name=\"prefix\"><option value=\"1\">suche:</option>\n<option value=\"2\">biete:</option>\n</select></td>\n");
        print("    </tr>\n");
        print("    <tr>\n");
        print("        <td class=\"tablea\">Titel</td>\n");
        print("        <td class=\"tablea\"><input type=\"text\" name=\"titel\" value=\"" . $arr["titel"] . "\" size=\"80\"></td>\n");
        print("    </tr>\n");
        print("    <tr>\n");
        print("        <td class=\"tablea\">Beschreibung</td>\n");
        print("        <td class=\"tablea\"><textarea name=\"info\" cols=\"77\" rows=\"10\">" . htmlentities(trim($arr["info"])) . "</textarea></td>\n");
        print("    </tr>\n");

        print("    <tr>\n");
        print("        <td class=\"tabletitle\" width=\"100%\" colspan=\"2\"><center><input type=\"submit\" value=\"Speichern\"></center></td>\n");
        print("    </tr>\n");
        print("</table>\n");
        print("</form>\n");
}

if ($action == "closed")
{
        $tid = intval($_POST["tid"]);
        $id    = intval($_POST["id"]);

        if($tid > 0)
        {
        $sql        = "SELECT user FROM requests WHERE id = " . $id . " LIMIT 1";
        $res1     = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
        $arr        = mysql_fetch_array($res1);
        $res        = mysql_query("SELECT * FROM torrents where id = ".sqlesc($tid)); // Changed for PN
        if(mysql_num_rows($res) === 1 AND intval($arr["user"]) != intval($CURUSER["id"]))
        {
            $closedate = get_date_time(time());
            mysql_query("UPDATE requests SET closed = ".sqlesc($tid).", ruser = ".intval($CURUSER["id"]).", closedate = ".sqlesc($closedate)." where id = $id");
            $bonus = get_config_data("RSEED_BONUS");
            $bonus = str_replace(",", ".", $bonus);
            $bonus = floatval($bonus);
            mysql_query("UPDATE users SET seedbonus = seedbonus + $bonus WHERE id = '".intval($CURUSER["id"])."'") or sqlerr(__FILE__, __LINE__);
            $torrent = mysql_fetch_assoc($res);
            $r             = mysql_fetch_assoc(mysql_query("SELECT user, titel FROM requests where id = $id"));
            $a             = mysql_fetch_assoc(mysql_query("SELECT user FROM votes where voteid = $id"));
            $votesid = $a["user"];
            $destid    = $r["user"];
            if($CURUSER["anon"] == "yes") {
            $text = "[color=".Lime."]Ein[/color] [color=".blue."]Anonymer[/color] [color=".Lime."]User hat einen Request erfüllt. Vielen Dank dafür.[/color] [url=details.php?id=$tid][color=".blue."][b]$torrent[name][/b][/color][/url]";
            $user = "Ein [b]Anonymer*[/b] User";
            }else{
            $text = "[color=".Lime."]Der User[/color] [color=".blue."]$CURUSER[username][/color] [color=".Lime."]hat einen Request erfüllt. Vielen Dank dafür.[/color] [url=details.php?id=$tid][color=".blue."][b]$torrent[name][/b][/color][/url]";
            $user = "Der User [url=userdetails.php?id=$CURUSER[id]]$CURUSER[username][/url]";
            }
            $date = time();
            sendPersonalMessage(0, $destid, "Request erfüllt", "" .$user. " hat Deinen Request [b]$r[titel][/b] mit dem Torrent [url=details.php?id=$tid][b]$torrent[name][/b][/url] erfüllt.");
            sendPersonalMessage(0, $votesid, "Request erfüllt", "" .$user. " hat denn Request [b]$r[titel][/b] mit dem Torrent [url=details.php?id=$tid][b]$torrent[name][/b][/url] erfüllt.");
            mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES ('id'," . sqlesc('0') . ", " . sqlesc('System') . ", $date, " . sqlesc($text) . ")");

            print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
            print("    <tr>\n");
            print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: Request <u>" . $r["titel"] . "</u> erfüllt :.</b></center></td>\n");
            print("    </tr>\n");
            print("    <tr>\n");
            print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
            print("    </tr>\n");
            print("</table>\n");
        }
        else
            stderr("FEHLER","Ein Torrent mit der ID $tid gibt es nicht, oder es ist etwas anderes Falsch gelaufen.&nbsp;<a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a>");
    }
    else
        stderr("FEHLER","Du musst die ID des Torrents angeben (steht bei den Torrent-Details in der Browser-Zeile!)&nbsp;<a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a>");
}

if ($action == "vote")
{
            $voteid    = intval($_GET["id"]);
            $sql         = "SELECT id FROM votes WHERE what = 'requests' and voteid = $voteid and user = " . intval($CURUSER["id"]) . "";
            $res         = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
            $sql1        = "SELECT user FROM votes WHERE what = 'requests' and voteid = $voteid";
            $res1        = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);

            if(mysql_num_rows($res) === 0)
            {
            mysql_query("INSERT INTO votes (what,user,voteid) VALUES ('requests',$CURUSER[id],$voteid)");

            print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
            print("    <tr>\n");
            print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: Vote erfolgreich :.</b></center></td>\n");
            print("    </tr>\n");
            print("    <tr>\n");
            print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
            print("    </tr>\n");
            print("</table>\n");
            }
            else
            {
            print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
            print("    <tr>\n");
            print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: Alle User die gevotet haben :.</b></center></td>\n");
            print("    </tr>\n");
            while ($arr1 = mysql_fetch_array($res1))
            {

            $id            = intval($arr1["user"]);
            $sql2        = "SELECT username, class, added, avatar, uploaded, downloaded, webseed, vdsl, adsl, enabled, warned, donor, anon FROM users WHERE id = '$id'";
            $res2        = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
            $arr2        = mysql_fetch_array($res2);

            if ($arr2["added"] == "0000-00-00 00:00:00")
            $joindate = 'N/A';
            else
            $joindate = "Reg.: " . get_elapsed_time(sql_timestamp_to_unix_timestamp($arr2["added"])) . "";

            if ($arr2["avatar"])
            $avatarover = $arr2["avatar"];
            elseif (!$arr2["avatar"])
            $avatarover = $GLOBALS["PIC_BASE_URL"] . "default_avatar.gif";

            $uploaded     = mksize($arr2["uploaded"]);
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
            $webs = "<img src=pic/ws.jpg>";
            else
            $webs = "";

            if    ($arr2["adsl"] == "yes")
            $adsl = "<img src=pic/adsl.gif>";
            else
            $adsl = "";

            if    ($arr2["vdsl"] == "yes")
            $vdsl = "<img src=pic/vdsl.gif>";
            else
            $vdsl = "";

            $icons         = array("enabled" => $arr2["enabled"], "warned" => $arr2["warned"], "donor" => $arr2["donor"]);
            if(($arr2["anon"] == "yes") AND (get_user_class() < $can_mod))
            $voteuser    = "<font color=\"#FFFFFF\">Anonym*</font>";
            else
            $voteuser    = "<a href=userdetails.php?id=".$id. " onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=left ><br><center><img align=center src=$avatarover height=90 width=80></center><br> <font color=green>UP: $uploaded</font><br> <font color=darkred>DL: $downloaded</font><br>Ratio: <font color=" . get_ratio_color($ratio) . ">".$ratio."</font><br>$joindate<br><font color=red>$adsl $vdsl $webs </font></div>', CAPTION, '');\" onmouseout=\"return nd();\"><font class=".get_class_color($arr2["class"]).">".htmlentities($arr2["username"])."</a>&nbsp;" .get_user_icons($icons). "";

            print("    <tr>\n");
            print("        <td class=\"tablea\" width=\"100%\">" . $voteuser . "</td>\n");
            print("    </tr>\n");
            }
            print("    <tr>\n");
            print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
            print("    </tr>\n");
            print("</table>\n");
            }
}

if (($action == "voter") AND (get_user_class() >= $can_mod))
{
            $voteid    = intval($_GET["id"]);
            $sql1        = "SELECT user FROM votes WHERE what = 'requests' and voteid = $voteid";
            $res1        = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);

            print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
            print("    <tr>\n");
            print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: Alle User die gevotet haben :.</b></center></td>\n");
            print("    </tr>\n");
            while ($arr1 = mysql_fetch_array($res1))
            {

            $id            = intval($arr1["user"]);
            $sql2        = "SELECT username, class, added, avatar, uploaded, downloaded, webseed, vdsl, adsl, enabled, warned, donor, anon FROM users WHERE id = '$id'";
            $res2        = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
            $arr2        = mysql_fetch_array($res2);

            if ($arr2["added"] == "0000-00-00 00:00:00")
            $joindate = 'N/A';
            else
            $joindate = "Reg.: " . get_elapsed_time(sql_timestamp_to_unix_timestamp($arr2["added"])) . "";

            if ($arr2["avatar"])
            $avatarover = $arr2["avatar"];
            elseif (!$arr2["avatar"])
            $avatarover = $GLOBALS["PIC_BASE_URL"] . "default_avatar.gif";

            $uploaded     = mksize($arr2["uploaded"]);
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
            $webs = "<img src=pic/ws.jpg>";
            else
            $webs = "";

            if    ($arr2["adsl"] == "yes")
            $adsl = "<img src=pic/adsl.gif>";
            else
            $adsl = "";

            if    ($arr2["vdsl"] == "yes")
            $vdsl = "<img src=pic/vdsl.gif>";
            else
            $vdsl = "";

            $icons         = array("enabled" => $arr2["enabled"], "warned" => $arr2["warned"], "donor" => $arr2["donor"]);
            if(($arr2["anon"] == "yes") AND (get_user_class() < $can_mod))
            $voteuser    = "<font color=\"#FFFFFF\">Anonym*</font>";
            else
            $voteuser    = "<a href=userdetails.php?id=".$id. " onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=left ><br><center><img align=center src=$avatarover height=90 width=80></center><br> <font color=green>UP: $uploaded</font><br> <font color=darkred>DL: $downloaded</font><br>Ratio: <font color=" . get_ratio_color($ratio) . ">".$ratio."</font><br>$joindate<br><font color=red>$adsl $vdsl $webs </font></div>', CAPTION, '');\" onmouseout=\"return nd();\"><font class=".get_class_color($arr2["class"]).">".htmlentities($arr2["username"])."</a>&nbsp;" .get_user_icons($icons). "";

            print("    <tr>\n");
            print("        <td class=\"tablea\" width=\"100%\">" . $voteuser . "</td>\n");
            print("    </tr>\n");
            }
            print("    <tr>\n");
            print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
            print("    </tr>\n");
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

            print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
            print("    <tr>\n");
            print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: Request geöffnet :.</b></center></td>\n");
            print("    </tr>\n");
            print("    <tr>\n");
            print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
            print("    </tr>\n");
            print("</table>\n");
}

if ($action == "info")
{
         $infoid = intval($_GET["id"]);
         $sql        = "SELECT titel, info FROM requests WHERE id = " . $infoid . " LIMIT 1";
         $res        = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
         $arr        = mysql_fetch_array($res);

         print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
         print("    <tr>\n");
         print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: Beschreibung von " . $arr["titel"] . " :.</b></center></td>\n");
         print("    </tr>\n");
         print("    <tr>\n");
         print("        <td class=\"tablea\" width=\"100%\">" . $arr["info"] . "</td>\n");
         print("    </tr>\n");
         print("    <tr>\n");
         print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
         print("    </tr>\n");
         print("</table>\n");
}

if ($action == "comments")
{
        $voteid    = intval($_GET["id"]);
        $sql         = "SELECT titel, user FROM requests WHERE id = " . $voteid . " LIMIT 1";
        $res         = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
        $arr         = mysql_fetch_array($res);
        $sql1        = "SELECT id, comments, user, datum FROM requestcomments WHERE commentid = " . $voteid . " ORDER BY datum DESC";
        $res1        = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);

        print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
        print("    <tr>\n");
        print("        <td class=\"tabletitle\" colspan=\"3\" width=\"100%\"><center><b>.: Kommentare zu <u>" . $arr["titel"] . "</u> :.</b></center></td>\n");
        print("    </tr>\n");
        while ($arr1 = mysql_fetch_array($res1))
        {

        $id            = intval($arr1["user"]);
        $idd         = intval($arr1["id"]);
        $sql2        = "SELECT id, username, class, added, avatar, uploaded, downloaded, webseed, vdsl, adsl, enabled, warned, donor, anon FROM users WHERE id = '$id' LIMIT 1";
        $res2        = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
        $arr2        = mysql_fetch_array($res2);

        if ($arr2["added"] == "0000-00-00 00:00:00")
        $joindate = 'N/A';
        else
        $joindate = "Reg.: " . get_elapsed_time(sql_timestamp_to_unix_timestamp($arr2["added"])) . "";

        if ($arr2["avatar"])
        $avatarover = $arr2["avatar"];
        elseif (!$arr2["avatar"])
        $avatarover = $GLOBALS["PIC_BASE_URL"] . "default_avatar.gif";

        $uploaded     = mksize($arr2["uploaded"]);
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
        $webs = "<img src=pic/ws.jpg>";
        else
        $webs = "";

        if    ($arr2["adsl"] == "yes")
        $adsl = "<img src=pic/adsl.gif>";
        else
        $adsl = "";

        if    ($arr2["vdsl"] == "yes")
        $vdsl = "<img src=pic/vdsl.gif>";
        else
        $vdsl = "";

        $icons = array("enabled" => $arr2["enabled"], "warned" => $arr2["warned"], "donor" => $arr2["donor"]);
        if(($arr2["anon"] == "yes") AND (get_user_class() < $can_mod))
        $user    = "<font color=\"#FFFFFF\">Anonym*</font>";
        else
        $user    = "<a href=userdetails.php?id=".$id. " onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=left ><br><center><img align=center src=$avatarover height=90 width=80></center><br> <font color=green>UP: $uploaded</font><br> <font color=darkred>DL: $downloaded</font><br>Ratio: <font color=" . get_ratio_color($ratio) . ">".$ratio."</font><br>$joindate<br><font color=red>$adsl $vdsl $webs </font></div>', CAPTION, '');\" onmouseout=\"return nd();\"><font class=".get_class_color($arr2["class"]).">".htmlentities($arr2["username"])."</a>&nbsp;" .get_user_icons($icons). "";

        if    (mysql_num_rows($res1) != 0)
        $comments = "" . htmlentities(trim($arr1["comments"])) . "";
        else
        $comments = "<font color=\"#FF0000\">Keine Kommentare zu diesem Request</font>";

        $datum = htmlentities($arr1["datum"]);

        print("    <tr>\n");
        print("        <td class=\"tablea\" colspan=\"3\" width=\"100%\">" . $comments . "</td>\n");
        print("    </tr>\n");
        print("    <tr>\n");
        print("        <td class=\"tablea\" width=\"77%\"><font color=\"#FFFFFF\">Von:</font>&nbsp;" . $user . "&nbsp;</td>\n");
        if ((intval($arr2["id"]) == intval($CURUSER["id"])) AND ($id == intval($arr2["id"])) OR (get_user_class() >= $can_mod))
        print("        <td class=\"tablea\" width=\"6%\"><a href=\"" . $_SERVER[PHP_SELF] . "?action=commentedit&id=$voteid&idd=$idd\"><img src=\"$GLOBALS[PIC_BASE_URL]/edit.png\" border=\"0\" /></a>&nbsp;<a href=\"" . $_SERVER[PHP_SELF] . "?action=deletecomment&id=$voteid&idd=$idd\"><img src=\"$GLOBALS[PIC_BASE_URL]/buttons/button_none.gif\" border=\"0\" /></a></td>\n");
        else
        print("        <td class=\"tablea\" width=\"6%\"><center><img src=\"$GLOBALS[PIC_BASE_URL]/disabledbig.png\" border=\"0\" /></center></td>\n");
        print("        <td class=\"tablea\" width=\"17%\"><font color=\"#FFFFFF\">Am:</font>&nbsp;<font color=\"#FF0000\">" . $datum . "</font></td>\n");
        print("    </tr>\n");
        }
        print("    <tr>\n");
        print("        <td class=\"tablea\" colspan=\"3\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "?action=commentwrite&id=$voteid\"><font color=\"#FF0000\">Kommentar hinzufügen</font></a></b>&nbsp;oder&nbsp;<b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
        print("    </tr>\n");
        print("</table>\n");
}

if ($action == "commentwrite")
{
        $voteid    = intval($_GET["id"]);
        $sql         = "SELECT titel FROM requests WHERE id = " . $voteid . " LIMIT 1";
        $res         = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
        $arr         = mysql_fetch_array($res);
        $sql1        = "SELECT comments FROM requestcomments WHERE commentid = " . $voteid . " LIMIT 1";
        $res1        = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
        $arr1        = mysql_fetch_array($res1);

        print("\n<form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"POST\">\n");
        print("<input type=\"hidden\" value=\"insertcomment\" name=\"action\">\n");
        print("<input type=\"hidden\" value=\"" . intval($voteid) . "\" name=\"id\">\n");
        print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
        print("    <tr>\n");
        print("        <td class=\"tabletitle\" width=\"100%\" colspan=\"2\"><center><b>.: Kommentar zu " . $arr["titel"] . " eintragen :.</b></center></td>\n");
        print("    </tr>\n");

        print("    <tr>\n");
        print("        <td class=\"tablea\">Kommentar</td>\n");
        print("        <td class=\"tablea\"><textarea name=\"comments\" cols=\"77\" rows=\"10\"></textarea></td>\n");
        print("    </tr>\n");

        print("    <tr>\n");
        print("        <td class=\"tabletitle\" width=\"100%\" colspan=\"2\"><center><input type=\"submit\" value=\"Eintragen\"></center></td>\n");
        print("    </tr>\n");
        print("</table>\n");
        print("</form>\n");
}

if ($action == "insertcomment")
{
    $id            = intval($_POST["id"]);
    $comment = trim($_POST["comments"]);
    $datum     = get_date_time(time());
    $sql         = "SELECT user FROM requests WHERE id = " . $id . " LIMIT 1";
    $res         = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
    $arr         = mysql_fetch_array($res);
    $sql1        = "SELECT user FROM requestcomments WHERE commentid = " . $id . " ORDER BY datum DESC LIMIT 1";
    $res1        = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
    $arr1        = mysql_fetch_array($res1);
    $user        = intval($arr1["user"]);
    $userid    = intval($arr["user"]);

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
     print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
     print("    <tr>\n");
     print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: Fehler :.</b></center></td>\n");
     print("    </tr>\n");
     print("    <tr>\n");
     print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
     print("    </tr>\n");
     print("</table>\n");
    }

     print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
     print("    <tr>\n");
     print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: Kommentar eingetragen :.</b></center></td>\n");
     print("    </tr>\n");
     print("    <tr>\n");
     print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
     print("    </tr>\n");
     print("</table>\n");
}

if ($action == "commentedit")
{
        $voteid    = intval($_GET["id"]);
        $idd         = intval($_GET["idd"]);
        $sql         = "SELECT titel FROM requests WHERE id = " . $voteid . " LIMIT 1";
        $res         = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
        $arr         = mysql_fetch_array($res);

        print("\n<form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"POST\">\n");
        print("<input type=\"hidden\" value=\"insertcommentedit\" name=\"action\">\n");
        print("<input type=\"hidden\" value=\"" . intval($voteid) . "\" name=\"id\">\n");
        print("<input type=\"hidden\" value=\"" . intval($idd) . "\" name=\"idd\">\n");
        print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
        print("    <tr>\n");
        print("        <td class=\"tabletitle\" width=\"100%\" colspan=\"2\"><center><b>.: Kommentar zu " . $arr["titel"] . " bearbeiten :.</b></center></td>\n");
        print("    </tr>\n");

        print("    <tr>\n");
        print("        <td class=\"tablea\">Kommentar</td>\n");
        print("        <td class=\"tablea\"><textarea name=\"comments\" cols=\"77\" rows=\"10\"></textarea></td>\n");
        print("    </tr>\n");

        print("    <tr>\n");
        print("        <td class=\"tabletitle\" width=\"100%\" colspan=\"2\"><center><input type=\"submit\" value=\"&auml;ndern\"></center></td>\n");
        print("    </tr>\n");
        print("</table>\n");
        print("</form>\n");
}

if ($action == "insertcommentedit")
{
    $id            = intval($_POST["id"]);
    $idd         = intval($_POST["idd"]);
    $sql         = "SELECT id, user FROM requestcomments WHERE commentid = " . $id . " AND id = " . $idd . " LIMIT 1";
    $res         = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
    $arr         = mysql_fetch_array($res);
    $iddd        = intval($arr["id"]);
    $comment = trim($_POST["comments"]);
    $datum     = get_date_time(time());

    if($comment != "" AND (intval($CURUSER["id"]) == $arr["user"]) OR (get_user_class() >= $can_mod))
    {
        $sql = "UPDATE requestcomments SET comments = ".sqlesc($comment).", datum = ".sqlesc($datum)." WHERE commentid = " . $id . " AND id = " . $iddd . " LIMIT 1";
        mysql_query($sql) or sqlerr(__FILE__, __LINE__);
    }
    else
    {
     print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
     print("    <tr>\n");
     print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: Fehler :.</b></center></td>\n");
     print("    </tr>\n");
     print("    <tr>\n");
     print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
     print("    </tr>\n");
     print("</table>\n");
    }

     print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
     print("    <tr>\n");
     print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: Kommentar bearbeitet :.</b></center></td>\n");
     print("    </tr>\n");
     print("    <tr>\n");
     print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
     print("    </tr>\n");
     print("</table>\n");
}

if ($action == "deletecomment")
{
     $id    = intval($_POST["id"]);
     $idd = intval($_GET["idd"]);
     $sql = "SELECT id, user FROM requestcomments WHERE commentid = " . $id . " AND id = " . $idd . " LIMIT 1";
     $res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
     $arr = mysql_fetch_array($res);
     $iddd= intval($arr["id"]);

     if((intval($CURUSER["id"]) == $arr["user"]) OR (get_user_class() >= $can_mod))
     {
        $sql = "DELETE FROM requestcomments WHERE commentid =    " . $id . " AND id = " . $iddd . " LIMIT 1";
        mysql_query($sql) or sqlerr(__FILE__, __LINE__);
     }

     print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
     print("    <tr>\n");
     print("        <td class=\"tabletitle\" width=\"100%\"><center><b>.: Kommentar gelöscht :.</b></center></td>\n");
     print("    </tr>\n");
     print("    <tr>\n");
     print("        <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
     print("    </tr>\n");
     print("</table>\n");
}

if ($action == "view")
{
    print("\n<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
    print("    <tr>\n");
    print("        <td class=\"tabletitle\"><b>Kategorie</b></td>\n");
    print("        <td class=\"tabletitle\"><b>Titel</b></td>\n");
    print("        <td class=\"tabletitle\"><b>Von</b></td>\n");
    print("        <td class=\"tabletitle\"><b>Vom</b></td>\n");
    print("        <td class=\"tabletitle\"><b>Votes</b></td>\n");
    print("        <td class=\"tabletitle\"><b>Kommentare</b></td>\n");
    print("        <td class=\"tabletitle\"><b>Erf&uuml;llt</b></td>\n");
    print("        <td class=\"tabletitle\"><b>Optionen</b></td>\n");
    print("    </tr>\n");

    $sql1        = "SELECT count(titel) FROM requests";
    $res1        = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
    $row         = mysql_fetch_array($res1);
    $url         = " .$_SERVER[PHP_SELF]?";
    $count     = $row[0];
    $perpage = 15;
    list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $url);
    $sql         = "SELECT requests.*,count(votes.id) as votes,categories.name,categories.image,users.username,users.class,users.added,users.avatar,users.uploaded,users.downloaded,users.webseed,users.vdsl,users.adsl,users.enabled,users.warned,users.donor,users.anon FROM requests,votes,categories,users WHERE votes.what='requests' and votes.voteid=requests.id and categories.id=requests.kategorie and users.id=requests.user GROUP BY requests.id ORDER BY requests.added desc $limit";
    $res         = mysql_query($sql) or sqlerr(__FILE__, __LINE__);

    if (mysql_num_rows($res) == 0)
    {
        print("    <tr>\n");
        print("        <td class=\"tablea\" colspan=\"7\"><i><font size=\"+2\" color=\"#FF0000\"><center>Keine Requests eingetragen</center></font></i></td>\n");
        print("    </tr>\n");
    }
    else
        while ($arr = mysql_fetch_array($res))
        {
            $id         = intval($arr["id"]);

            $sql1         = "SELECT user, ruser, info, closedate, added FROM requests WHERE id = " . $id . " LIMIT 1";
            $res1         = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
            $self         = mysql_fetch_array($res1);
            $sql2         = "SELECT comments, user FROM requestcomments WHERE commentid = " . $id . " ORDER BY datum DESC LIMIT 1";
            $res2         = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
            $arr2         = mysql_fetch_array($res2);
            $sql3         = "SELECT id, username, class, anon FROM users WHERE id = " . intval($self["ruser"]) . " LIMIT 1";
            $res3         = mysql_query($sql3) or sqlerr(__FILE__, __LINE__);
            $arr3         = mysql_fetch_array($res3);
            $sql4         = "SELECT count(id) as commentvote FROM requestcomments WHERE commentid = " . $id . " GROUP BY commentid LIMIT 1";
            $res4         = mysql_query($sql4) or sqlerr(__FILE__, __LINE__);
            $arr4         = mysql_fetch_array($res4);
            $sql5         = "SELECT username, class, anon FROM users WHERE id = " . intval($arr2["user"]) . " LIMIT 1";
            $res5         = mysql_query($sql5) or sqlerr(__FILE__, __LINE__);
            $arr5         = mysql_fetch_assoc($res5);

            if(($arr5["anon"] == "yes") AND (get_user_class() < UC_MODERATOR))
            $cwname             = "<font color=white>Anonym*</font>";
            else
            $cwname             = "<font class=" . get_class_color($arr5["class"]) . ">" . htmlentities($arr5["username"]) . "</font>";

            $beschreibung = htmlentities($self["info"]);

            $kommentar        = htmlentities($arr2["comments"]);

            $datum                = sqlesc(get_date_time(gmtime() - 86400*4));

            $zeit                 = sqlesc($self["closedate"]);

            if(($arr3["anon"] == "yes") AND (get_user_class() < $can_mod))
            $erfüllt            = "<font color=white>Anonym*</font>";
            else
            $erfüllt            = "<font class=" . get_class_color($arr3["class"]) . ">" . htmlentities($arr3["username"]) . "</font>";

            if (($zeit <= $datum))
            $erfuellt            = "<font color=\"#FF0000\"><b>Erfüllt</b></font>";
            else
            $erfuellt            = "<font color=\"#008000\"><b>Erfüllt</b></font>";

            if (strlen($arr["titel"]) > 70)
            $titel                 = substr($arr["titel"], 0, 65) . "...";
            else
            $titel                 = $arr["titel"];

            if    ($arr["votes"] >= 2 AND $arr["votes"] <= 4)
            $votes = "<font color=\"#008000\">" . intval($arr["votes"]) . "</font>";
            elseif ($arr["votes"] >= 5)
            $votes = "<font color=\"#FF0000\">" . intval($arr["votes"]) . "</font>";
            else
            $votes = "<font color=\"#FFFFFF\">" . intval($arr["votes"]) . "</font>";

            if    ($arr2["comments"] != "")
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

            $uploaded     = mksize($arr["uploaded"]);
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
            $webs = "Webseed";
            else
            $webs = "";

            if    ($arr["adsl"] == "yes")
            $adsl = "ADSL";
            else
            $adsl = "";

            if    ($arr["vdsl"] == "yes")
            $vdsl = "VDSL";
            else
            $vdsl = "";

            $icons = array("enabled" => $arr["enabled"], "warned" => $arr["warned"], "donor" => $arr["donor"]);
            if(($arr["anon"] == "yes") AND (intval($self["user"]) != intval($CURUSER["id"])) AND (get_user_class() < $can_mod))
            $name    = "<font color=\"#FFFFFF\">Anonym*</font>";
            else
            $name    = "<a href=userdetails.php?id=".intval($arr["user"]). " onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=left><br><center><img align=center src=$avatarover height=90 width=80></center><br> <font color=green>UP: $uploaded</font><br> <font color=darkred>DL: $downloaded</font><br>Ratio: <font color=" . get_ratio_color($ratio) . ">".$ratio."</font><br>$joindate<br><font color=red>$adsl $vdsl $webs </font></div>', CAPTION, '');\" onmouseout=\"return nd();\"><font class=".get_class_color($arr["class"]).">".htmlentities($arr["username"])."</a>&nbsp;" .get_user_icons($icons). "";

            print("    <tr>\n");
            print("        <td class=\"tablea\"><center><img src=\"$GLOBALS[PIC_BASE_URL]/$arr[image]\"/></center></td>\n");
            print("        <td class=\"tablea\"><a href=\"" . $_SERVER[PHP_SELF] . "?action=info&id=$id\" onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=center><font color=red><b>Beschreibung</b></font><br><br>$beschreibung</div></td></tr></table>', CAPTION, '');\" onmouseout=\"return nd();\">" . $titel . "</a></td>\n");
            print("        <td class=\"tablea\">" . $name . "</td>\n");
            print("        <td class=\"tablea\">" . $self["added"] . "</td>\n");
            if ((get_user_class() >= $can_mod))
            print("        <td class=\"tablea\" style=\"text-align:center\"><a href=\"" . $_SERVER[PHP_SELF] . "?action=vote&id=$id\" onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=center><font color=red><b>Anleitung</b></font><br><br>Hier klicken um für das File zu Voten, hast du schon gevotet und klickst nochmal siehst du alle User die bisher gevotet haben, (gilt nur für User, ab Mod aufwärts bitte auf das V klicken um die User zu sehen die schon gevotet haben).</div></td></tr></table>', CAPTION, '');\" onmouseout=\"return nd();\"><b>" . $votes . "</b></a>&nbsp;-&nbsp;<a href=\"" . $_SERVER[PHP_SELF] . "?action=voter&id=$id\"><font color=\"#FFFFFF\"><b>V</b></font></a></td>\n");
            else
            print("        <td class=\"tablea\" style=\"text-align:center\"><a href=\"" . $_SERVER[PHP_SELF] . "?action=vote&id=$id\" onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=center><font color=red><b>Anleitung</b></font><br><br>Hier klicken um für das File zu Voten, hast du schon gevotet und klickst nochmal siehst du alle User die bisher gevotet haben.</div></td></tr></table>', CAPTION, '');\" onmouseout=\"return nd();\"><b>" . $votes . "</b></a></td>\n");
            print("        <td class=\"tablea\" style=\"text-align:center\">" . $comments ."&nbsp;-&nbsp;<a href=\"" . $_SERVER[PHP_SELF] . "?action=commentwrite&id=$id\"><b><font color=\"#008000\">Schreiben</font></b></a></td>\n");
            if(intval($arr["closed"]) < 1){
            print("        <td class=\"tablea\" style=\"text-align:center\"><form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"POST\" style=\"display: inline;\"><input type=\"hidden\" name=\"action\" value=\"closed\" /><input type=\"hidden\" name=\"id\" value=\"$id\" /><a href=\"" . $_SERVER[PHP_SELF] . "\" onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=center><font color=red><b>Anleitung</b></font><br><br>Du musst die ID (steht bei den Torrent-Details in der Browser(Adress)-Zeile ganz oben rechts!) des Torrents eintragen und dann mit ENTER best&auml;ttigen</div></td></tr></table>', CAPTION, '');\" onmouseout=\"return nd();\"><font color=\"#FF0000\"><b>ID:</b></font></a>&nbsp;<input type=\"text\" name=\"tid\" size=\"5\" maxlength=\"6\" /></form></td>\n");
            }else{
            print("        <td class=\"tablea\" style=\"text-align:center\"><a href=\"details.php?id=$arr[closed]\" onmouseover=\"return overlib('<table cellpadding=4 cellspacing=1 width=100% height=80><tr><td class=tablea align=center><b>Erfüllt von</b><br>$erfüllt<br><br><font color=red>Um zum File zu gelangen einfach Klicken</font></div></td></tr></table>', CAPTION, '');\" onmouseout=\"return nd();\">" . $erfuellt . "</a>\n");
            if ((get_user_class() >= $can_mod))
            print("        &nbsp;<a href=\"" . $_SERVER[PHP_SELF] . "?action=reopen&id=$id\"><img src=\"$GLOBALS[PIC_BASE_URL]/edit.png\" border=\"0\" /></a>\n");
            print("        </td>\n");
            }
            if ((get_user_class() >= UC_SYSOP) OR ($zeit <= $datum)){
            if ((get_user_class() >= $can_mod) OR (intval($self["user"]) == intval($CURUSER["id"])))
            print("        <td class=\"tablea\" style=\"text-align:center\"><a href=\"" . $_SERVER[PHP_SELF] . "?action=delete&id=$id\"><img src=\"$GLOBALS[PIC_BASE_URL]/buttons/button_none.gif\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"" . $_SERVER[PHP_SELF] . "?action=edit&id=$id\"><img src=\"$GLOBALS[PIC_BASE_URL]/edit.png\" border=\"0\" /></a></td>\n");
            else
            print("        <td class=\"tablea\" style=\"text-align:center\"><font color=\"#FF0000\"><b>Keine</b></font></td>\n");
            }else{
            print("        <td class=\"tablea\" style=\"text-align:center\"><font color=\"#FF0000\"><b>Keine</b></font></td>\n");
            }
            print("    </tr>\n");
        }
    print ("</table>\n");
 echo $pagerbottom;
}
	}
	else if(isset($_POST['request']) AND $_POST['request'] == 'addrequests'){
	
$res = mysql_query("SELECT * FROM categories ORDER BY name");
$cats="<select name=cat>\n";
while($r=mysql_fetch_assoc($res))
$cats.="<option value=$r[id]>$r[name]</option>\n";
$cats.="</select>\n";	
	
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
   $text = "[color=".Lime."]Ein[/color] [color=".blue."]Anonymer[/color] [color=".Lime."]User hat einen neuen Request eingetragen. Guckt mal bitte ob jemand ihn erfüllen kann. Danke![/color] [url=" .$_SERVER["PHP_SELF"]. "]Hier klicken[/url]";
   else
   $text = "[color=".Lime."]Der User[/color] [color=".blue."]$CURUSER[username][/color] [color=".Lime."]hat einen neuen Request eingetragen. Guckt mal bitte ob jemand ihn erfüllen kann. Danke![/color] [url=" .$_SERVER["PHP_SELF"]. "]Hier klicken[/url]";

   $date = time();
   mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES ('id', " . sqlesc('0') . ", " . sqlesc('System') . ", $date, " . sqlesc($text) . ")");
   }
   else
    stderr("FEHLER", "Alle Felder m&uuml;ssen ausgef&uuml;llt werden!&nbsp;<a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a>");

   print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
   print("  <tr>\n");
   print("    <td class=\"tabletitle\" width=\"100%\"><center><b>.: <u>" . $titel . "</u> eingetragen :.</b></center></td>\n");
   print("  </tr>\n");
   print("  <tr>\n");
   print("    <td class=\"tablea\" width=\"100%\"><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
   print("  </tr>\n");
   print("</table>\n");
}	
	
    print("\n<form action=\"takerequest.php\" method=\"POST\">\n");
    print("<input type=\"hidden\" value=\"insert\" name=\"action\">\n");
    print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%;\" class=\"tableinborder\">\n");
    print("    <tr>\n");
    print("        <td class=\"tablea\">Kategorie</td>\n");
    print("        <td class=\"tablea\">" .$cats. "</td>\n");
    print("    </tr>\n");
    print("    <tr>\n");
    print("        <td class=\"tablea\">Prefix</td>\n");
    print("        <td class=\"tablea\"><select name=\"prefix\"><option value=\"1\">suche:</option>\n<option value=\"2\">biete:</option>\n</select></td>\n");
    print("    </tr>\n");
    print("    <tr>\n");
    print("        <td class=\"tablea\">Titel</td>\n");
    print("        <td class=\"tablea\"><input type=\"text\" name=\"titel\" value=\"\" size=\"80\" maxlength=\"250\"></td>\n");
    print("    </tr>\n");
    print("    <tr>\n");
    print("        <td class=\"tablea\">Beschreibung</td>\n");
    print("        <td class=\"tablea\"><textarea name=\"info\" cols=\"77\" rows=\"10\">" . htmlentities(trim($arr["info"])) . "</textarea></td>\n");
    print("    </tr>\n");

    print("    <tr>\n");
    print("        <td class=\"tabletitle\" width=\"100%\" colspan=\"2\"><center><input type=\"submit\" value=\"Eintragen\"></center></td>\n");
    print("    </tr>\n");
    print("</table>\n");
    print("</form>\n");
}		
}
?>