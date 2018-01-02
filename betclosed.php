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
dbconn();
loggedinorreturn();

check_access(UC_MODERATOR);
security_tactics();

x264_header("Wettb&uuml;ro-Auszahlung");

print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Wettb&uuml;ro -- Gewinnauszahlung</h1>
	<div class='x264_title_content'>";
print("<table>\n");
print("  <tr>\n");
print("    <td class=\"tabletitle\"><center>Wette</center></td>\n");
print("    <td class=\"tabletitle\"><center>User</center></td>\n");
print("    <td class=\"tabletitle\"><center>Einsatz</center></td>\n");
print("    <td class=\"tabletitle\"><center>Gewinn</center></td>\n");
print("    <td class=\"tabletitle\"><center>Gutschrift</center></td>\n");
print("  </tr>\n");

$games     = "SELECT * FROM betting_games WHERE end = 1";
$res_games = mysql_query($games) or sqlerr(__FILE__,__LINE__);
while ($arr_games = mysql_fetch_array($res_games))
{
  if($arr_games[p_home] == $arr_games[p_guest])
    $tipp=0;
  elseif($arr_games[p_home] > $arr_games[p_guest])
    $tipp=1;
  elseif($arr_games[p_home] < $arr_games[p_guest])
    $tipp=2;

  $liste     = "SELECT * FROM betting_bet WHERE gid = " . $arr_games["gid"]." AND tip=" . $tipp;
  $res_liste = mysql_query($liste) or sqlerr(__FILE__,__LINE__);
  while ($arr_liste = mysql_fetch_array($res_liste))
  {
    $user     = "SELECT id, username, class, enabled, warned, donor, closed_gid FROM users WHERE id = " . $arr_liste["uid"] . " LIMIT 1";
    $res_user = mysql_query($user) or sqlerr(__FILE__,__LINE__);
    $arr_user = mysql_fetch_array($res_user);

    switch ($arr_liste["tip"])
    {
       case 0 : $gewinn = $arr_liste["insert"] * $arr_games["quote0"];
                $quote  = $arr_games["quote0"];
                break;
       case 1 : $gewinn = $arr_liste["insert"] * $arr_games["quote1"];
                $quote  = $arr_games["quote1"];
                break;
       case 2 : $gewinn = $arr_liste["insert"] * $arr_games["quote2"];
                $quote  = $arr_games["quote2"];
                break;
    }
    $gewinn = $gewinn * 1024 * 1024 * 1024;
    $link   = $_SERVER["PHP_SELF"] . "?action=bonus&amp;id=" . $arr_liste["uid"] . "&amp;bonus=" . $gewinn . "&amp;game=" . $arr_games["gid"] . "&amp;einsatz=" . $arr_liste["insert"];

$icons = array("enabled" => $r1["enabled"], "warned" => $r1["warned"], "donor" => $r1["donor"]);
$name = "<a href=userdetails.php?id=".htmlentities($arr_user["id"]). "><font class=".get_class_color($arr_user["class"]).">".htmlentities($arr_user["username"])."</a>&nbsp;" .get_user_icons($icons). "";

    print("  <tr>\n");
    print("    <td class=\"tablea\">" . $arr_games["gid"] . "</td>\n");
    print("    <td class=\"tablea\">" . $name . "</td>\n");
    print("    <td class=\"tablea\">" . mksize($arr_liste["insert"] * 1024 * 1024 * 1024) . "</td>\n");
    print("    <td class=\"tablea\">" . mksize($gewinn) . "&nbsp;( <font color=\"#FF0000\">" . $quote ."</font> )</td>\n");
    if ($arr_user["closed_gid"] == $arr_games["gid"] OR $arr_games["gid"] == $arr_liste["closed_gid"])
    print("    <td class=\"tablea\"><center><font color=\"#FF0000\">Schon bekommen</font></center></td>\n");
    else
    print("    <td class=\"tablea\"><center><a href=\"" . $link ."\"><font color=\"#008000\">Gutschrift</font></a></center></td>\n");
    print("  </tr>\n");
  }
}

print("</table>\n");

print("<br />");
print("<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\" class=\"tableinborder\">");
print("  <tr>");
print("    <td class=\"tableb\" width=\"100%\"><div align=\"center\"><a href=\"betedit.php\"><font color=\"#FF0000\">Wetten Bearbeiten</font></a>&nbsp;|&nbsp;<a href=\"betoverview.php\"><font color=\"#FF0000\">Wett&uuml;bersicht</font></a>&nbsp;|&nbsp;<a href=\"bet.php\"><font color=\"#FF0000\">Wetten</font></a></div></td>");
print("  </tr>");
print("</table>");
print("<br />");

if (htmlentities($_GET["action"]) == "bonus")
{

  $userid = intval($_GET["id"]);
  $bonus  = floatval($_GET["bonus"]);
  $out    = intval($_GET["einsatz"]);
  $game   = intval($_GET["game"]);

  $sql_user  = "UPDATE users SET uploaded = uploaded + " . $bonus . ", closed_gid = " . $game . " WHERE id = " . $userid . " LIMIT 1";
  $sql_bonus = "UPDATE `betting_games` SET `out` = `out` + '" . $out . "' WHERE `gid` = " . $game . " LIMIT 1";
  $sql_game  = "UPDATE `betting_bet` SET `closed_gid` = " . $game . " WHERE uid = " . $userid . " AND gid = " . $game . " LIMIT 1";
  //$sql_game  = "DELETE FROM betting_bet WHERE gid = " . $game . " AND uid = " . $userid . " LIMIT 1";
  $sql_spiel = "SELECT home, guest FROM betting_games WHERE gid = " . $game . " LIMIT 1";

  $res_spiel = mysql_query($sql_spiel) or sqlerr(__FILE__,__LINE__);
  $spiel     = mysql_fetch_array($res_spiel);
  $partie    = $spiel["home"] . " - " . $spiel["guest"];

  $betreff = "Wettbüro";
  $msg = "Du hast beim tippen " . $partie . " Glück gehabt und hast gewonnen, dein Gewinn (" . mksize($bonus) . ") wurde dir gutgeschrieben. mfg Staff!";
  sendPersonalMessage(0, $userid, $betreff, $msg, PM_FOLDERID_INBOX, 0);
  write_modcomment(htmlentities($userid), 0, "Hat beim Wetten " . $partie . " (" . mksize($bonus) . ") gewonnen.");

  $userr     = "SELECT id, username FROM users WHERE id = " . $userid;
  $res_userr = mysql_query($userr) or sqlerr(__FILE__,__LINE__);
  $arr_userr = mysql_fetch_array($res_userr);

  print("<table summary=\"\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" style=\"width:100%\" class=\"tableinborder\">\n");
  print("  <tr>\n");
  print("    <td class=\"tabletitle\" width=\"100%\">\n");
  print("      <center><b>Bonus für " . $arr_userr["username"] . "</b></center>\n");
  print("    </td>\n");
  print("  </tr>\n");
  print("  <tr>\n");
  print("    <td class=\"tablea\" width=\"100%\">\n");

  $result = mysql_query($sql_user) or sqlerr(__FILE__,__LINE__);
  if ($result) print("<font color=\"green\">OK: Bonus (" . mksize($bonus) . ") für User " . $arr_userr["username"] . " erfolgreich</font><br />\n");
  else print("<font color=\"red\">FEHLER: Bonus (" . mksize($bonus) . ") für User " . $arr_userr["username"] . " fehlgeschlagen</font><br />" . $sql_user . "\n");

  $result = mysql_query($sql_bonus) or sqlerr(__FILE__,__LINE__);
  if ($result) print("<font color=\"green\">OK: Gesamtbonus upgedatet</font><br />\n");
  else print("<font color=\"red\">FEHLER: Gesamtbonus-Update fehlgeschlagen</font><br />" . $sql_bonus . "\n");

  $result = mysql_query($sql_game) or sqlerr(__FILE__,__LINE__);
  if ($result) print("<font color=\"green\">OK: Spiel für den User (" . $userid . ") geschlossen</font><br />\n");
  else print("<font color=\"red\">FEHLER: Spiel für den User (" . $userid . ") nicht geschlossen</font><br />" . $sql_game . "\n");

  //$result = mysql_query($sql_game) or sqlerr(__FILE__,__LINE__);
  //if ($result) print("<font color=\"green\">OK: Wetteinsatz gelöscht</font><br />\n");
  //else print("<font color=\"red\">FEHLER: Löschen des Wetteinsatzes fehlgeschlagen</font><br />" . $sql_game . "\n");

  print("    </td>\n");
  print("  </tr>\n");
  print("  <tr>\n");
  print("    <td class=\"tabletitle\" width=\"100%\">\n");
  print("      <center><b><a href=\"" . $_SERVER["PHP_SELF"] . "\">Weiter</a></b></center>\n");
  print("    </td>\n");
  print("  </tr>\n");
  print("    <td class=\"tablea\">\n");
  print("</table>");

  x264_footer(true);
  exit;
}
print"
	</div>
</div>
</div>";
x264_footer(true);
?>