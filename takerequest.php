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
require_once(dirname(__FILE__) . "/include/engine.php");

dbconn();

x264_header("Erfolgreich");

if (isset($_GET["action"])) $action = trim(htmlentities($_GET["action"]));
elseif (isset($_POST["action"])) $action = trim(htmlentities($_POST["action"]));
else $action = "view";

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
   print("    <td class=\"tablea\" width=\"100%\"><center><b><a href=\"request-center.php\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>\n");
   print("  </tr>\n");
   print("</table>\n");
}
x264_footer();
?>