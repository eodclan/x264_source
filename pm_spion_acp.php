<?php
if (is_dir($_SERVER["DOCUMENT_ROOT"] . "include")) $doc_root = $_SERVER["DOCUMENT_ROOT"];
else $doc_root = $_SERVER["DOCUMENT_ROOT"] . "/";

require_once("include/bittorrent.php");

dbconn();
loggedinorreturn();

check_access(UC_BOSS);
security_tactics();

if (isset($_GET["action"])) $action = trim(format_comment($_GET["action"]));
elseif (isset($_POST["action"])) $action = trim(format_comment($_POST["action"]));
else $action = "view";

function delete()
{
  print("<table class='table'>");
  print("    <tr>");
  print("      <td>");
  print("        <center>");
  print("          <a href=\"" . $_SERVER[PHP_SELF] . "?&page=" .$_GET[page]. "action=" .$_GET[action]. "&box=" .$_GET[box]. "&check=yes\"><input type=\"submit\" value=\"Alle Markieren\"></a>");
  print("          <a href=\"" . $_SERVER[PHP_SELF] . "?&page=" .$_GET[page]. "action=" .$_GET[action]. "&box=" .$_GET[box]. "&check=no\"><input type=\"submit\" value=\"Markierung aufheben\"></a>");
  print("          <input type=\"submit\" value=\"Markierte Löschen\">");
  print("          <a href=\"" . $_SERVER[PHP_SELF] . "?action=alleloeschen\" onclick=\"return confirm('Sicher ? Bist du dir ganz sicher das du alle Pms löschen willst ?');\"><input type=\"submit\" value=\"Alle PMs Löschen\"></a>");
  print("        </form>");
  print("      </center>");
  print("    </td>");
  print("  </tr>");
  print("</table>");
  print("<br />");
}

function pmspion()
{
  print("<table class='table'>");
  print("    <tr>");
  print("      <td>");
  print("        <center>");	
  print("        <form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"GET\">");
  print("          <input type=\"hidden\" value=\"pmspion\" name=\"action\">");
  print("          <font color=\"#FF0000\">Mitglied Suchen:</font>&nbsp;<input type=\"text\" size=\"30\" name=\"search\">");
  print("          <input type=\"submit\" value=\"Suchen\">");
  print("        </form>");
  print("      </center>");
  print("    </td>");
  print("  </tr>");
  print("</table>");  
}

function cleaner()
{
  print("<table class='table'>");
  print("    <tr>");
  print("      <td>");
  print("        <center>");	
  print("        <form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"POST\">");
  print("          <input type=\"hidden\" value=\"mcleaner\" name=\"action\">");
  print("          <input type=\"submit\" value=\"PM Cleaner\">");
  print("        </form>");
  print("      </center>");
  print("    </td>");
  print("  </tr>");
  print("</table>");  
}

function view()
{
  print("<table class='table'>");
  print("    <tr>");
  print("      <td>");
  print("        <center>");	
  print("      <center>");
  print("          <a href=\"" . $_SERVER[PHP_SELF] . "\"><input type=\"submit\" value=\"Zur&uuml;ck zur Hauptseite\"></a>");
  print("      </center>");
  print("    </td>");
  print("  </tr>");
  print("</table>");
}

x264_bootstrap_header("Alle PMs - PM Spion - Alle PMs löschen - PM Cleaner - Repair DB");

?>
<script type="text/javascript" language="JavaScript">
 function alle_auswaehlen(field)
 {
   for(i=0; i<field.length; i++)
     field[i].checked = true;
 }
</script>
<?

if (($action == "delete") AND (get_user_class() >= UC_SYSOP))
{
    $do  = "DELETE FROM messages WHERE id IN (" . implode(", ", $_POST[delmp]) . ")";
    $res = mysql_query($do) or sqlerr(__FILE__, __LINE__);
echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> PMs gel&ouml;scht
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";

    print("<table class='table table-bordered table-striped'>");
    print("  <tr>");
    print("    <td><font color=\"#008000\">Alle ausgewählten Pms wurden erfolgreich gelöscht.</font></td>");
    print("  </tr>");
    print("  <tr>");
    print("    <td><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>");
    print("  </tr>");
    print("</table>");
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>"; 	
    die;
}

if (($action == "alleloeschen") AND (get_user_class() >= UC_SYSOP))
{
    $sql  = "TRUNCATE TABLE messages";
    $res  = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
    $sql1 = "ALTER TABLE `messages` AUTO_INCREMENT =1";
    $res1 = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
    write_log("Nachrichten wurden gelöscht von $CURUSER[username]");
echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> PMs gel&ouml;scht
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";

    print("<table class='table'>");
    print("  <tr>");
    print("    <td><font color=\"#008000\">Alle Pms wurden erfolgreich gelöscht.</font></td>");
    print("  </tr>");
    print("  <tr>");
    print("    <td><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>");
    print("  </tr>");
    print("</table>");
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>"; 
    die;
}

/////////////////////////////////////////////////////////
//       markierte Einträge löschen (tote User)        //
/////////////////////////////////////////////////////////
if (($action == "tdelete") AND (get_user_class() >= UC_SYSOP))
{
    $x     = implode(", ", $_POST[delmsg]);
    $query = "DELETE FROM messages WHERE receiver IN (" . $x . ")";
    $res   = mysql_query($query) or sqlerr(__FILE__, __LINE__);

echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> PMs gel&ouml;scht
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	
    print("<table class='table'>");
    print("  <tr>");
    print("    <td><font color=\"#008000\">Alle Pms gelöschter User wurden erfolgreich gelöscht.</font></td>");
    print("  </tr>");
    print("  <tr>");
    print("    <td><center><b><a href=\"" . $_SERVER[PHP_SELF] . "?action=mcleaner\"><font color=\"#FF0000\">Zurück zum PM Cleaner</font></a></b>&nbsp;oder&nbsp;<b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>");
    print("  </tr>");
    print("</table>");
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>"; 
    die;
}

/////////////////////////////////////////////////////////
//       markierte Einträge löschen (gelöschte)        //
/////////////////////////////////////////////////////////
if (($action == "totaldeleted") AND (get_user_class() >= UC_SYSOP))
{
    $x     = implode(", ", $_POST[deletedmsg]);
    $query = "DELETE FROM messages WHERE folder_in=0 AND receiver IN (" . $x . ")";
    $res   = mysql_query($query) or sqlerr(__FILE__, __LINE__);

echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> PMs gel&ouml;scht
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	
    print("<table class='table'>");
    print("  <tr>");
    print("    <td><font color=\"#008000\">Alle überflüssigen Pms wurden erfolgreich gelöscht.</font></td>");
    print("  </tr>");
    print("  <tr>");
    print("    <td><center><b><a href=\"" . $_SERVER[PHP_SELF] . "?action=mcleaner\"><font color=\"#FF0000\">Zurück zum PM Cleaner</font></a></b>&nbsp;oder&nbsp;<b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>");
    print("  </tr>");
    print("</table>");
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>"; 	
    die;
}

if (($action == "repairdb") AND (get_user_class() >= UC_SYSOP))
{
    $tables     = "";
    $sql        = "SHOW TABLES FROM `" . $mysql_db . "`";
    $tablesshow = mysql_query($sql) or sqlerr(__FILE__, __LINE__);

    while (list($table) = mysql_fetch_row($tablesshow))
    {
    $tables .= "`" . mysql_real_escape_string($table) . "`,";
    }
    $tables .= "...";
    $tables  = str_replace(",...", "", $tables);

    $sql1       = "OPTIMIZE TABLE " . $tables . "";
    $res1       = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
    $sql2       = "REPAIR TABLE " . $tables . "";
    $res2       = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);

echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> DB Repair System
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	
	
    print("<table class='table'>");
    print("  <tr>");
    print("    <td><font color=\"#008000\">Datenbank wurde erfolgreich Repariert und Optimiert.</font></td>");
    print("  </tr>");
    print("  <tr>");
    print("    <td><center><b><a href=\"" . $_SERVER[PHP_SELF] . "?action=mcleaner\"><font color=\"#FF0000\">Zurück zum PM Cleaner</font></a></b>&nbsp;oder&nbsp;<b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>");
    print("  </tr>");
    print("</table>");
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>"; 	
    die;
}

////////////////////////////////////////////////////
//       alle gelöschten Einträge anzeigen        //
////////////////////////////////////////////////////
if (($action == "delmsg"))
{
  $anz_deleted = 0;
  $anz_user    = 0;
  print("<form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"post\">");
  print("<table class='table'>");
  print(" <tr>");
  print("   <td class=\"tablea\" colspan=\"3\">");
  print("     <center>");
  print("       <input type=\"hidden\" value=\"mcleaner\" name=\"action\">");
  print("       <input type=\"submit\" value=\"&uuml;berfl&uuml;ssige Nachrichten\" name=\"go\">");
  print("       <a href=\"" . $_SERVER[PHP_SELF] . "\"><input type=\"submit\" value=\"Zur&uuml;ck zur Hauptseite\"></a>");
  print("     </center>");
  print("   </td>");
  print(" </tr>");
  print("</table>");
  print("</form>");
  print("<br />");
  print("<form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"post\" name=\"formular\">");
  print("<table class='table'>");
  print(" <tr>");
  print("   <td align=\"right\">");
  print("    <input type=\"button\" value=\"alles markieren\" name=\"go\" onclick=\"alle_auswaehlen(document.formular['deletedmsg[]'])\">&nbsp;&nbsp;");
  print("    <input type=\"hidden\" value=\"totaldeleted\" name=\"action\">");
  print("    <input type=\"submit\" value=\"endg&uuml;ltig L&ouml;schen\" name=\"go\">");
  print("   </td>");
  print(" </tr>");
  print(" <tr>");
  print("   <td class=\"tabletitle\" width=\"80\"><b>ID</b></td>");
  print("   <td class=\"tabletitle\"><b>Anz. Nachrichten</b></td>");
  print("   <td class=\"tabletitle\" width=\"80\"><b>L&ouml;schen</b></td>");
  print(" </tr>");

  $sql = "SELECT id, receiver, folder_in FROM messages WHERE folder_in=0 GROUP BY receiver";
  $res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
  while($daten = mysql_fetch_array($res))
  {
    $id             = intval($daten["receiver"]);
    $res_sql        = "SELECT id, username, class, enabled, warned, donor FROM users WHERE id = '$id' LIMIT 1";
    $res_user       = mysql_query($res_sql) or sqlerr(__FILE__, __LINE__);
    $daten_usr      = mysql_fetch_array($res_user);
    $icons          = array("enabled" => $daten_usr["enabled"], "warned" => $daten_usr["warned"], "donor" => $daten_usr["donor"]);
    $name           = "<a href=\"userdetails.php?id=".intval($daten_usr["id"]). "\"><font class=\"".get_class_color($daten_usr["class"])."\">".format_comment($daten_usr["username"])."</font></a>&nbsp;" .get_user_icons($icons). "";

    if ($daten["folder_in"] == 0)
    {
      $res_msg_sql  = "SELECT COUNT(*) AS anz FROM messages WHERE folder_in=0 AND receiver = '$id' LIMIT 1";
      $res_msg      = mysql_query($res_msg_sql) or sqlerr(__FILE__, __LINE__);
      $anz_msg      = mysql_fetch_array($res_msg);
      $anz_deleted += intval($anz_msg["anz"]);
      $anz_user ++;

      print(" <tr>");
      print("   <td class=\"tablea\">" . $id . "</td>");
      print("   <td class=\"tablea\">Der User " . $name . " hat noch <font color=\"red\"><b>" . $anz_msg["anz"] . "</b></font> gel&ouml;schte Nachrichten</td>");
      print("   <td bgcolor=\"red\"><center><input type=\"checkbox\" name=\"deletedmsg[]\" value=\"" . $id . "\" /></center></td>");
      print(" </tr>");
    }
  }
  print(" <tr>");
  print("   <td><center>gefundene Nachrichten: <b>" . $anz_deleted . "</b> von " . $anz_user . " Benutzern</center></td>");
  print(" </tr>");
  print(" <tr>");
  print("   <td><center><font color=red><b>.: Achtung: Danach aber unbedingt eine <a href=\"" . $_SERVER[PHP_SELF] . "?action=repairdb\">DB-Optimierung</a> machen :.</b></font></center></td>");
  print(" </tr>");
  print("</table>");
  print("</form>");
  die;
}

if (($action == "pmspion"))
{
if ((!isset($_GET["id"])) AND (!isset($_GET["co"])))
{
  $search = trim($_GET["search"]);

  if($search != "")
  {
   $query = "username LIKE " . sqlesc("%$search%") . " AND status = 'confirmed'";
   if ($search)
   $q     = "search = " . format_comment($search);

   $sql   = "SELECT id, username, class, enabled, warned, donor FROM users WHERE $query ORDER BY username LIMIT 1";
   $res   = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
   $num   = mysql_num_rows($res);

   echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Viewer
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";

  view();
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";   
   

   print("<table class='table'>");
   print("  <tr>");
   print("    <td class=\"tabletitle\"><b>Mitglied</b></td>");
   print("    <td class=\"tabletitle\"><b>Empfangen</b></td>");
   print("    <td class=\"tabletitle\"><b>Versendet</b></td>");
   print("  </tr>");
   for ($i = 0; $i < $num; ++$i)
   {
    $arr     = mysql_fetch_assoc($res);
    $icons   = array("enabled" => $arr["enabled"], "warned" => $arr["warned"], "donor" => $arr["donor"]);
    $name    = "<a href=\"userdetails.php?id=".intval($arr["id"]). "\"><font class=\"".get_class_color($arr["class"])."\">".format_comment($arr["username"])."</font></a>&nbsp;" .get_user_icons($icons). "";

    $sql1    = "SELECT COUNT(*) from messages where receiver = " . intval($arr["id"]) . " LIMIT 1";
    $doquery = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
    $dorow   = mysql_fetch_row($doquery);

    $sql2    = "SELECT COUNT(*) from messages where sender = " . intval($arr["id"]) . " LIMIT 1";
    $odquery = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
    $odrow   = mysql_fetch_row($odquery);
   }
   print("  <tr>");
   print("    <td class=\"tablea\"><center>" . $name . "</center></td>");
   print("    <td class=\"tablea\"><center><a href=\"" . $_SERVER[PHP_SELF] . "?action=pmspion&id=" .intval($arr["id"]). "&co=receiver\"><b>" .$dorow[0]. "</b></a></center></a></td>");
   print("    <td class=\"tablea\"><center><a href=\"" . $_SERVER[PHP_SELF] . "?action=pmspion&id=" .intval($arr["id"]). "&co=sender\"><b>" .$odrow[0]. "</b></a></center></td>");
   print("  </tr>");
   print ("</table>");
   die;
  }
  else
  {
   echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Fehler
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>"; 	  
   print("<table class='table'>");
   print("  <tr>");
   print("    <td><font color=\"#FF0000\">Keine Aktion!</font></td>");
   print("  </tr>");
   print("  <tr>");
   print("    <td><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>");
   print("  </tr>");
   print("</table>");
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";     
   die;
  }
}

if((isset($_GET["id"])) AND (isset($_GET["co"])))
{
if ((!isset($_GET["id"])) OR (!isset($_GET["co"])))
{
   echo"
                       <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Fehler
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>"; 
 print("<table class='table'>");
 print("  <tr>");
 print("    <td><font color=\"#FF0000\">Der Zugriff zu dieser Seite ist dir nicht gestattet!</font></td>");
 print("  </tr>");
 print("  <tr>");
 print("    <td><center><b><a href=\"" . $_SERVER[PHP_SELF] . "\"><font color=\"#008000\">weiter &rArr;</font></a></b></center></td>");
 print("  </tr>");
 print("</table>");
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";  
 die;
}

$id  = intval($_GET["id"]);
$co  = format_comment($_GET["co"]);

$sql = "SELECT * , UNIX_TIMESTAMP(added) as utadded FROM messages WHERE $co = $id ORDER BY added DESC";
$res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res))
{
 if (intval($arr["sender"]) != 0)
 {
  $sql2    = "SELECT username, class, enabled, warned, donor FROM users WHERE id = " . intval($arr["sender"]) . " LIMIT 1";
  $res2    = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
  $arr2    = mysql_fetch_assoc($res2);
  $icons   = array("enabled" => $arr2["enabled"], "warned" => $arr2["warned"], "donor" => $arr2["donor"]);
  $sender  = "<a href=\"userdetails.php?id=".intval($arr["sender"]). "\"><font class=\"".get_class_color($arr2["class"])."\">" . (format_comment($arr2["username"])?format_comment($arr2["username"]):"[Gelöscht]") . "</font></a>&nbsp;" .get_user_icons($icons). "";
  }
  else
  $sender  = "<font color=\"#FF0000\">System</font>";

  $sql3    = "SELECT username, class, enabled, warned, donor FROM users WHERE id = " . intval($arr["receiver"]) . " LIMIT 1";
  $res3    = mysql_query($sql3) or sqlerr(__FILE__, __LINE__);
  $arr3    = mysql_fetch_assoc($res3);
  $icon    = array("enabled" => $arr3["enabled"], "warned" => $arr3["warned"], "donor" => $arr3["donor"]);
  $empfang = "<a href=\"userdetails.php?id=".intval($arr["receiver"]). "\"><font class=\"".get_class_color($arr3["class"])."\">" . (format_comment($arr3["username"])?format_comment($arr3["username"]):"[Gelöscht]") . "</font></a>&nbsp;" .get_user_icons($icon). "";
  $timeago = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]));

   echo"
                       <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Nachricht an ( $empfang ) als Empfänger
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";  
 
  print("<table class='table'>");
  print("  <tr>");
  print("    <td class=\"tablea\"><b>Von: " . $sender . "</b></td>");
  print("    <td class=\"tablea\"><b>An: " . $empfang . "</b></td>");
  print("    <td class=\"tablea\"><b>Betreff: <font color=\"#FFFFFF\">" . $arr["subject"] . "</font></b></td>");
  print("    <td class=\"tablea\"><b>" . get_date_time($arr["utadded"] , $CURUSER["tzoffset"] ) . " (Alter: " . $timeago . ")</b></td>");
  print("  </tr>");
  print("</table>");

  print("<table class='table'>");
  print("  <tr>");
  print("    <td class=\"tablea\" align=\"left\">" . format_comment($arr["msg"]) . "</td>");
  print("  </tr>");
  print("</table>");
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>"; 
  }
   echo"
                       <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Viewer
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>"; 
  view();
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>"; 
  die;
 }
}

if (($action == "mcleaner"))
{
  $anz_zuviel = 0;
  $fail_user  = 0;
   echo"
                       <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Viewer
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";  
  print("<form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"post\">");
  print("<table class='table'>");
  print(" <tr>");
  print("   <td class=\"tablea\" colspan=\"3\">");
  print("     <center>");
  print("       <input type=\"hidden\" value=\"delmsg\" name=\"action\">");
  print("       <input type=\"submit\" value=\"gel&ouml;schte Nachrichten\" name=\"go\">");
  print("       <a href=\"" . $_SERVER[PHP_SELF] . "\"><input type=\"submit\" value=\"Zur&uuml;ck zur Hauptseite\"></a>");
  print("     </center>");
  print("   </td>");
  print(" </tr>");
  print("</table>");
  print("</form>");
  print("<br />");
  print("<form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"post\" name=\"formular\">");
  print("<table class='table'>");
  print(" <tr>");
  print("   <td align=\"right\">");
  print("    <input type=\"button\" value=\"alles markieren\" name=\"go\" onclick=\"alle_auswaehlen(document.formular['delmsg[]'])\">&nbsp;&nbsp;");
  print("    <input type=\"hidden\" value=\"tdelete\" name=\"action\">");
  print("    <input type=\"submit\" value=\"L&ouml;schen\" name=\"go\">");
  print("   </td>");
  print(" </tr>");
  print(" <tr>");
  print("   <td class=\"tabletitle\" width=\"80\"><b>ID</b></td>");
  print("   <td class=\"tabletitle\"><b>Anz. Nachrichten</b></td>");
  print("   <td class=\"tabletitle\" width=\"80\"><b>L&ouml;schen</b></td>");
  print(" </tr>");

  $sql = "SELECT id, receiver FROM messages GROUP BY receiver";
  $res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
  while($daten = mysql_fetch_array($res))
  {
    $id        = intval($daten["receiver"]);
    $res_sql   = "SELECT username FROM users WHERE id = '$id' LIMIT 1";
    $res_user  = mysql_query($res_sql) or sqlerr(__FILE__, __LINE__);
    $daten_usr = mysql_fetch_array($res_user);

    if ($daten_usr["username"] == "")
    {
      $res_msg_sql = "SELECT COUNT(*) AS anz FROM messages WHERE receiver = '$id' LIMIT 1";
      $res_msg     = mysql_query($res_msg_sql) or sqlerr(__FILE__, __LINE__);
      $anz_msg     = mysql_fetch_array($res_msg);
      $anz_zuviel += intval($anz_msg["anz"]);
      $fail_user ++;
      print(" <tr>");
      print("   <td class=\"tablea\">" . $id . "</td>");
      print("   <td class=\"tablea\">Der User wurde nicht gefunden und hat noch <font color=\"red\"><b>" . $anz_msg["anz"] . "</b></font> Nachrichten</td>");
      print("   <td bgcolor=\"red\"><center><input type=\"checkbox\" name=\"delmsg[]\" value=\"" . $id . "\" /></center></td>");
      print(" </tr>");
    }
  }

  print(" <tr>");
  print("   <td><center>gefundene Nachrichten: <b>" . $anz_zuviel . "</b> von " . $fail_user . " nichtgefundenen Benutzern</center></td>");
  print(" </tr>");
  print(" <tr>");
  print("   <td><center><font color=red><b>.: Achtung: Danach aber unbedingt eine <a href=\"" . $_SERVER[PHP_SELF] . "?action=repairdb\">DB-Optimierung</a> machen :.</b></font></center></td>");
  print(" </tr>");
  print("</table>");
  print("</form>");
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>"; 
x264_bootstrap_footer();			
  die;
}

//////////PAGER////////////////
  $sql1    = "SELECT COUNT(*) FROM messages LIMIT 1";
  $res1    = mysql_query($sql1) or sqlerr(__FILE__, __LINE__);
  $row     = mysql_fetch_array($res1);
  $count   = $row[0];
  $perpage = 50;
  //list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $_SERVER["PHP_SELF"] ."?");
//////////END PAGER///////////
  $sql     = "SELECT * FROM messages ORDER BY id DESC $limit";
  $res     = mysql_query($sql) or sqlerr(__FILE__, __LINE__);

if (($action == "view"))
{
echo"
                       <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> PMs
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	 
  pmspion();
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";	
  
   echo"
                       <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> PM Cleaner
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";  
 
  cleaner();
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";    
  
  //echo $pagertop;

   echo"
                       <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> PMs
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";   

  print("<table class='table'>");
  print("<form action=\"" . $_SERVER[PHP_SELF] . "\" method=\"POST\">");
  print(" <input type=\"hidden\" value=\"delete\" name=\"action\">");
  print("  <tr>");
  print("    <td class=\"tabletitle\"><b>Sender</b></td>");
  print("    <td class=\"tabletitle\"><b>Empfänger</b></td>");
  print("    <td class=\"tabletitle\"><b>Text</b></td>");
  print("    <td class=\"tabletitle\"><b>Datum</b></td>");
  print("    <td class=\"tabletitle\"><b>Löschen</b></td>");
  print("  </tr>");

  if (mysql_num_rows($res) == 0)
  {
    print("  <tr>");
    print("    <td class=\"tablea\" colspan=\"6\"><i><font size=\"+2\" color=\"#FF0000\"><center>Keine Nachrichten</center></font></i></td>");
    print("  </tr>");
  }
  else
    while ($arr = mysql_fetch_array($res))
    {
      $sql2     = "SELECT username, class, enabled, warned, donor FROM users WHERE id = " . $arr["receiver"] . " LIMIT 1";
      $res2     = mysql_query($sql2) or sqlerr(__FILE__, __LINE__);
      $arr2     = mysql_fetch_assoc($res2);
      $icons    = array("enabled" => $arr2["enabled"], "warned" => $arr2["warned"], "donor" => $arr2["donor"]);
      $rname    = "<a href=\"userdetails.php?id=".intval($arr["receiver"]). "\"><font class=\"".get_class_color($arr2["class"])."\">".format_comment($arr2["username"])."</font></a>&nbsp;" .get_user_icons($icons). "";
      $receiver = "$rname";

      $sql3     = "SELECT username, class, enabled, warned, donor FROM users WHERE id = " . $arr["sender"] . " LIMIT 1";
      $res3     = mysql_query($sql3) or sqlerr(__FILE__, __LINE__);
      $arr3     = mysql_fetch_assoc($res3);
      $icons    = array("enabled" => $arr3["enabled"], "warned" => $arr3["warned"], "donor" => $arr3["donor"]);
      $sname    = "<a href=\"userdetails.php?id=".intval($arr["sender"]). "\"><font class=\"".get_class_color($arr3["class"])."\">".format_comment($arr3["username"])."</font></a>&nbsp;" .get_user_icons($icons). "";
      $sender   = "$sname";
      if($arr["sender"] == 0)
      $sender   = "<font color=\"#FF0000\"><b>System</b></font>";

      if($arr["unread"] == "yes")
      $read     = "<font color=\"#FF0000\"><b>Nein</b></font>";
      else
      $read     = "<font color=\"#008000\"><b>Ja</b></font>";

      $msg      = format_comment($arr["msg"]);
      $added    = format_comment($arr["added"]);
      $subjekt  = format_comment($arr["subject"]);

      print("  <tr>");
      print("    <td class=\"tablea\"><center>" . $sender . "</center></td>");
      print("    <td class=\"tablea\"><center>" . $receiver . "</center></td>");
      print("    <td class=\"tablea\" align=\"left\"><center><font color=\"#FF0000\"><b>Betreff:</b></font>&nbsp;<font color=\"#FFFFFF\"><b>" . $subjekt . "</b></font><center><br />" . $msg . "</td>");
      print("    <td class=\"tablea\"><center>" . $added . "</center></td>");
      if ($_GET["check"] == "yes")
      print("    <td class=\"tablea\" align=\"center\"><input type=\"checkbox\" checked name=\"delmp[]\" value=\"" . $arr["id"] . "\"></td>");
      else
      print("    <td class=\"tablea\" align=\"center\"><input type=\"checkbox\" name=\"delmp[]\" value=\"" . $arr["id"] . "\"></td>");
      print("  </tr>");
    }
   print ("</table>");
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>"; 
}
   echo"
                       <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Einstellungen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>"; 

  delete();
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";   
x264_bootstrap_footer();
?>