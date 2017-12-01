<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");
dbconn();
loggedinorreturn();

function error($meldung = "")
{
  print("<table summary=\"\" style=\"width:80%\" cellpadding=\"5\" cellspacing=\"1\" align=\"center\" border=\"0\" class=\"tableinborder\">\n");
  print("  <tr>\n");
  print("    <td class=\"tabletitle\">Fehler</td>\n");
  print("  </tr>\n");
  print("  <tr>\n");
  print("    <td class=\"tablea\">" . $meldung . "</td>\n");
  print("  </tr>\n");
  print("  <tr>\n");
  print("    <td class=\"tablea\"><center><b><a href=\"javascript:history.back()\">zur&uuml;ck</a></b></center></td>\n");
  print("  </tr>\n");
  print("</table>\n");
  stdfoot();
  die;
}

if (isset($_POST["action"])) $action = htmlentities(trim($_POST["action"]));
elseif (isset($_GET["action"])) $action = htmlentities(trim($_GET["action"]));
else $action = "view";

$pro_zeile = 5;
$breite_tabelle = 800;

check_access(UC_TEAMLEITUNG);
security_tactics();
x264_bootstrap_header("Smilie Manager ACP");

print "
                       <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Smilie Manager ACP
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>";


if ($action == "insert")
{
  $name   = $_FILES["smilie"]["name"];
  $tmp    = $_FILES["smilie"]["tmp_name"];

  $code    = trim(htmlentities($_POST["code"]));
  $active  = (($_POST["active"] == "yes") ? "yes" : "no");
  $private = (($_POST["private"] == "yes") ? "yes" : "no");

  $bild = dirname(__FILE__) . "/pic/smilies/" . $name;
  $status = "";

  if (is_file($bild)) error("Dieser Smilie existiert schon!");
  else $status .= "Smilie <font color=\"green\">" . $name . "</font> ist noch nicht vorhanden.<br />";

  $sql = "SELECT id FROM smilies WHERE code = " . sqlesc($code);
  $err = mysql_num_rows(mysql_query($sql));
  if ($err > 0) error("Dieser Smilie-Code wird schon verwendet!");
  else $status .= "Smilie-Code <font color=\"green\">" . $code . "</font> wird noch nicht verwendet.<br />";

  $err = move_uploaded_file($tmp,$bild);
  if ($err) $status .= "Smilie-Bild <font color=\"green\">erfolgreich</font> nach <u>" . $bild . "</u> verschoben.<br />";
  else error("Smilie-Bild konnte nicht verschoben werden!<br />" . $bild);

  $sql = "INSERT INTO smilies ( id , code , path , active , private ) VALUES ( NULL , " . sqlesc($code) . ", " . sqlesc($name) . ", " . sqlesc($active) . ", " . sqlesc($private) . ")";
  $err = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
  if ($err) $status .= "Smilie <font color=\"green\">erfolgreich</font> in die Datenbank eingetragen.";
  else error("Fehler beim Eintragen in die Datenbank!<br />" . $sql);

  print("<table summary=\"\" style=\"width:500px;\" cellpadding=\"5\" cellspacing=\"1\" align=\"center\" border=\"0\" class=\"tableinborder\">\n");
  print("  <tr>\n");
  print("    <td class=\"tablea\">" . $status . "</td>\n");
  print("  </tr>\n");
  print("  <tr>\n");
  print("    <td class=\"tabletitle\" ><center><a href=\"" . $_SERVER["PHP_SELF"] . "\" target=\"_self\">Weiter &rArr;</a></center></td>\n");
  print("  </tr>\n");
  print("</table>\n");
}

if ($action == "new")
{
  print("\n<form method=\"post\" action=\"" . $_SERVER["PHP_SELF"] . "\" enctype=\"multipart/form-data\" >\n");
  print("<input type=\"hidden\" value=\"insert\" name=\"action\">\n");
  print("<table summary=\"\" style=\"width:500px;\" cellpadding=\"5\" cellspacing=\"1\" align=\"center\" border=\"0\" class=\"tableinborder\">\n");
  print("  <tr>\n");
  print("    <td class=\"tabletitle\" colspan=\"2\"><center>Smilie hinzuf&uuml;gen</center></td>\n");
  print("  </tr>\n");

  print("  <tr>\n");
  print("    <td class=\"tablea\" width=\"70\">Bild</td>\n");
  print("    <td class=\"tablea\"><input type=\"file\" name=\"smilie\" size=\"50\"></td>\n");
  print("  </tr>\n");
  print("  <tr>\n");
  print("    <td class=\"tablea\" width=\"70\">Code</td>\n");
  print("    <td class=\"tablea\"><input type=\"text\" value=\"\" name=\"code\" size=\"50\"></td>\n");
  print("  </tr>\n");
  print("  <tr>\n");
  print("    <td class=\"tablea\" width=\"70\">Aktiv</td>\n");
  print("    <td class=\"tablea\"><input type=\"checkbox\" value=\"yes\" name=\"active\" /></td>\n");
  print("  </tr>\n");
  print("  <tr>\n");
  print("    <td class=\"tablea\" width=\"70\">Privat</td>\n");
  print("    <td class=\"tablea\"><input type=\"checkbox\" value=\"yes\" name=\"private\" /></td>\n");
  print("  </tr>\n");

  print("  <tr>\n");
  print("    <td class=\"tabletitle\" colspan=\"2\"><center><input type=\"submit\"></center></td>\n");
  print("  </tr>\n");
  print("</table>\n");
  print("</form>\n\n");
}

if ($action == "delete")
{
  $id  = intval($_GET["id"]);
  $name = trim($_GET["name"]);

  $sql = "DELETE FROM smilies WHERE id = " . $id . " LIMIT 1";
  $err = mysql_query($sql) or sqlerr(__FILE__, __LINE__);

  $bild = dirname(__FILE__) . "/pic/smilies/" . $name;
  if (is_file($bild)) $del = @unlink($bild);

  print("<table summary=\"\" style=\"width:500px;\" cellpadding=\"5\" cellspacing=\"1\" align=\"center\" border=\"0\" class=\"tableinborder\">\n");
  print("  <tr>\n");
  print("    <td class=\"tabletitle\" ><center>Smilie <b>" . $id . "</b> l&ouml;schen</center></td>\n");
  print("  </tr>\n");

  print("  <tr>\n");
  if ($del) print("    <td class=\"tablea\" ><font color=\"green\">Smilie <b>" . $name . "</b> erfolgreich gel&ouml;scht</font></td>\n");
  else print("    <td class=\"tablea\" ><font color=\"red\">Fehler beim l&ouml;schen von Smilie <b>" . $name . "</b><br />" . $bild . "</td>\n");
  print("  </tr>\n");

  print("  <tr>\n");
  if ($err) print("    <td class=\"tablea\" ><font color=\"green\">Smilie-Daten <b>" . $id . "</b> erfolgreich entfernt</font></td>\n");
  else print("    <td class=\"tablea\" ><font color=\"red\">Fehler beim entfernen der Smilie_Daten <b>(" . $id . ")</b></font><br />" . $sql . "</td>\n");
  print("  </tr>\n");

  print("  <tr>\n");
  print("    <td class=\"tablea\" ><center><a href=\"" . $_SERVER["PHP_SELF"] . "\" target=\"_self\">Weiter &rArr;</a></center></td>\n");
  print("  </tr>\n");

  print("</table>\n");}

if ($action == "update")
{
  $id      = intval($_POST["id"]);
  $code    = htmlentities(trim($_POST["code"]));
  $pfad    = htmlentities(trim($_POST["path"]));
  $active  = (($_POST["active"] == "yes") ? "yes" : "no");
  $private = (($_POST["private"] == "yes") ? "yes" : "no");

  $sql = "UPDATE smilies SET code = " . sqlesc($code) . ", path = " . sqlesc($pfad) . ", active = " . sqlesc($active) . ", private = " . sqlesc($private) . " WHERE id = " . $id . " LIMIT 1";
  $err = mysql_query($sql) or sqlerr(__FILE__, __LINE__);

  print("<table summary=\"\" style=\"width:500px;\" cellpadding=\"5\" cellspacing=\"1\" align=\"center\" border=\"0\" class=\"tableinborder\">\n");
  print("  <tr>\n");
  print("    <td class=\"tabletitle\" ><center>Smilie <b>" . $id . "</b> bearbeiten</center></td>\n");
  print("  </tr>\n");

  print("  <tr>\n");
  if ($err) print("    <td class=\"tablea\" ><font color=\"green\">Smilie <b>" . $id . "</b> erfolgreich bearbeiten</font></td>\n");
  else print("    <td class=\"tablea\" ><font color=\"red\">Fehler beim bearbeiten von Smilie <b>" . $arr["id"] . "</b></font><br />" . $sql . "</td>\n");
  print("  </tr>\n");

  print("  <tr>\n");
  print("    <td class=\"tablea\" ><center><a href=\"" . $_SERVER["PHP_SELF"] . "\" target=\"_self\">Weiter &rArr;</a></center></td>\n");
  print("  </tr>\n");

  print("</table>\n");
}

if ($action == "edit")
{
  $sql = "SELECT * FROM smilies WHERE id = " . intval($_GET["id"]) . " LIMIT 1";
  $res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
  $arr = mysql_fetch_array($res);

  print("\n<form method=\"post\" action=\"" . $_SERVER["PHP_SELF"] . "\">\n");
  print("<input type=\"hidden\" value=\"update\" name=\"action\">\n");
  print("<input type=\"hidden\" value=\"" . $arr["id"] . "\" name=\"id\">\n");
  print("<table summary=\"\" style=\"width:500px;\" cellpadding=\"5\" cellspacing=\"1\" align=\"center\" border=\"0\" class=\"tableinborder\">\n");
  print("  <tr>\n");
  print("    <td class=\"tabletitle\" colspan=\"2\"><center>Smilie <b>" . $arr["id"] . "</b> bearbeiten</center></td>\n");
  print("  </tr>\n");

  print("  <tr>\n");
  print("    <td class=\"tablea\" width=\"70\">Vorschau</td>\n");
  print("    <td class=\"tablea\"><img src=\"pic/smilies/" . $arr["path"] . "\" border=\"0\" /></td>\n");
  print("  </tr>\n");

  print("  <tr>\n");
  print("    <td class=\"tablea\" width=\"70\">Bild</td>\n");
  print("    <td class=\"tablea\"><input type=\"text\" value=\"" . $arr["path"] . "\" name=\"path\" size=\"50\"><br />Pfad relativ zu <u>pic/smilies/</u></td>\n");
  print("  </tr>\n");
  print("  <tr>\n");
  print("    <td class=\"tablea\" width=\"70\">Code</td>\n");
  print("    <td class=\"tablea\"><input type=\"text\" value=\"" . $arr["code"] . "\" name=\"code\" size=\"50\"></td>\n");
  print("  </tr>\n");
  print("  <tr>\n");
  print("    <td class=\"tablea\" width=\"70\">Aktiv</td>\n");
  print("    <td class=\"tablea\"><input type=\"checkbox\" value=\"yes\" name=\"active\"" . (($arr["active"] == "yes") ? " checked" : "") . " /></td>\n");
  print("  </tr>\n");
  print("  <tr>\n");
  print("    <td class=\"tablea\" width=\"70\">Privat</td>\n");
  print("    <td class=\"tablea\"><input type=\"checkbox\" value=\"yes\" name=\"private\"" . (($arr["private"] == "yes") ? " checked" : "") . " /></td>\n");
  print("  </tr>\n");

  print("  <tr>\n");
  print("    <td class=\"tabletitle\" colspan=\"2\"><center><input type=\"submit\"></center></td>\n");
  print("  </tr>\n");
  print("</table>\n");
  print("</form>\n\n");
}

if ($action == "view")
{
   print("<table summary=\"\" style=\"width:" . $breite_tabelle . "px;\" cellpadding=\"5\" cellspacing=\"1\" align=\"center\" border=\"0\" class=\"tableinborder\">\n");
   print("    <tr><td class=\"tabletitle\"><center><a href=\"" . $_SERVER["PHP_SELF"] . "?action=new\">einen neuen Smilie hinzuf&uuml;gen</a></center></td></tr>\n");
   print("</table>\n");
   print("<br />\n");
   print("<table summary=\"\" style=\"width:" . $breite_tabelle . "px;\" cellpadding=\"5\" cellspacing=\"1\" align=\"center\" border=\"0\" class=\"tableinborder\">\n");

   $sql = "SELECT * FROM smilies ORDER BY id ASC";
   $res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);

   if (mysql_num_rows($res) > 0)
   {
     print("    <tr><td class=\"tabletitle\" colspan=\" . $pro_zeile . \"><center><b>" . mysql_num_rows($res) . "</b> Eintr&auml;ge gefunden</center></td></tr>\n");
     $zeile = 0;
     while ($arr = mysql_fetch_array($res))
     {
       if ($zeile == 0) print("  <tr>\n");
 
       $edit   = "<a href=\"" . $_SERVER["PHP_SELF"] . "?action=edit&amp;id=" . $arr["id"] . "\"><img src=\"".$GLOBALS["PIC_BASE_URL"]."edit.png\" width=\"16\" height=\"16\" alt=\"Bearbeiten\" title=\"Bearbeiten\" style=\"vertical-align: middle;border:none\"></a>";
       $delete = "<a href=\"" . $_SERVER["PHP_SELF"] . "?action=delete&amp;id=" . $arr["id"] . "&amp;name=" . $arr["path"] . "\"><img src=\"".$GLOBALS["PIC_BASE_URL"]."editdelete.png\" width=\"16\" height=\"16\" alt=\"L&ouml;schen\" title=\"L&ouml;schen\" style=\"vertical-align: middle;border:none\"></a>";
       $pic = "pic/smilies/" . $arr["path"];
       list($width, $height, $type, $attr) = getimagesize($pic);
       print("    <td class=\"tablea\" valign=\"bottom\" width=\"100\">\n");
       print("      <center>\n");
       print("        <img src=\"" . $pic . "\" border=\"0\" title=\"" . $arr["code"] . "\" " . (($width > round($breite_tabelle/$pro_zeile)) ? "width=\"" . round($breite_tabelle/$pro_zeile) . "\"" : $attr ) . " />\n");
       print("        <br /><br />\n");
       print("        Smilie ist " . (($arr["active"] == "yes") ? "<font color=\"green\">aktiv</font>" : "<font color=\"red\">deaktiviert</font>") . "\n");
       print(" / " . (($arr["private"] == "yes") ? "<font color=\"yellow\">Privat</font>" : "<font color=\"blue\">Public</font>") . "\n");
       print("        <br />\n");
       print("        " . $edit . "\n        " . $delete . "\n");
       print("      </center>\n");
       print("     </td>\n");
       $zeile++;
       if ($zeile == $pro_zeile)
       {
         print("  </tr>\n");
         $zeile = 0;
       }
     }
     if (($zeile != $pro_zeile) && ($zeile != 0))
     {
        print("    <td class=\"tablea\" colspan=\"" . ($pro_zeile - $zeile) . "\">&nbsp;</td>\n");
        print("  </tr>\n");
     }
   }
   else
     print("    <tr><td class=\"tablea\"><i>keine Eintr&auml;ge gefunden</i></td></tr>\n");

   print("</table>\n");
}

print"
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

x264_bootstrap_footer(true);
?> 