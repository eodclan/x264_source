<?php
// ************************************************************************************//
// * D€ Source 2014
// ************************************************************************************//
// * Author: D@rk-€vil™
// * 
// * Copyright (c) 2013 - 2014 D@rk-€vil™
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//
require "include/bittorrent.php";
dbconn(false);

loggedinorreturn();
security_tactics();

$script_name = $_SERVER["SCRIPT_FILENAME"];
if (get_user_class() < UC_MODERATOR);

if(isset($_POST['submit']) && $_POST['type'] != ""){
  $typdel = "";
  if($_POST['type'] == 'x')
    $typdel = "WHERE `typ`=''";
  elseif($_POST['type'] == 'all')
    $typdel = "";
  else 
    $typdel = "WHERE `typ`='".htmlentities(stripslashes(mysql_real_escape_string($_POST['type'])))."'";
    
  if(mysql_query("DELETE FROM sitelog $typdel"))
    header("location: ".$_SERVER['PHP_SELF']."?cleand=ok&type=".$_POST['type']);
  else
    header("location: ".$_SERVER['PHP_SELF']."?cleand=notok&type=".$_POST['type']);
}
        
$types = array("torrentupload" => "Torrent hochgeladen", 
"torrentedit" => "Torrent bearbeitet", 
"torrentdelete" => "Torrent gelöscht", 
"torrentgranted" => "Torrent freigeschaltet", 
"commentpost" => "Kommentar schreiben",
"promotion" => "Beförderung", 
"demotion" => "Degradierung",
"addwarn" => "Verwarnung erteilt", 
"remwarn" => "Verwarnung entfernt",
"security_tactics" => "Security Tactics",
"accenabled" => "Account aktiviert",
"parked" => "Account parken", 
"accdisabled" => "Account deaktiviert", 
"accdeleted" => "Account gelöscht",
"passkeyreset" => "PassKey neu gesetzt", 
"passkeyadminreset" => "PassKey vom Team neu generiert", 
"cleaner" => "User-Profil bearbeitet",
"ctracker" => "Versuchte Angriffe",
"modmessages" => "Mod Nachrichten",
"autowarn" => "Systemverwarnungen", 
"autodewarn" => "Systemverwarnungen entfernt", 
"cleanup" => "Cleanup",
"cleanuperr" => "Cleanuperror",
"denied" => "Unerlaubte Zugriffe",
"x" => "Logs ohne Type",  
"all" => "Alle Logs leeren");
$typeopt ="";
foreach ($types as $type => $name) {
        $typeopt .= "<option value='$type'>$name</option>\n";
    }

function get_typ_name($typ)
{
    switch ($typ) {
        case "torrentupload": return "<font color=Magenta>Torrent hochgeladen</font>";
        case "torrentedit": return "<font color=Magenta>Torrent bearbeitet</font>";
        case "torrentdelete": return "<font color=Magenta>Torrent gelöscht</font>";
        case "torrentgranted":return "<font color=Magenta>Torrent freigeschaltet</font>";
        case "commentpost": return "<font color=Magenta>Kommentar schreiben</font>";
        case "promotion": return "<font color=lime>Beförderung</font>";
        case "demotion": return "<font color=lime>Degradierung</font>";
        case "addwarn": return "<font color=yellow>Verwarnung erteilt</font>";
        case "remwarn": return "<font color=yellow>Verwarnung entfernt</font>";
        case "security_tactics": return "<font color=lime>Security Tactics</font>";
        case "accenabled": return "<font color=Blue>Account aktiviert</font>";
        case "parked": return "<font color=Blue><font color=Blue>Account parken</font>";
        case "accdisabled": return "<font color=Blue>Account deaktiviert</font>";
        case "accdeleted": return "<font color=Blue>Account gelöscht</font>";
        case "passkeyreset": return "<font color=Orange>PassKey neu gesetzt</font>";
        case "passkeyadminreset": return "<font color=Orange>PassKey neu gesetzt von Staff</font>";
        case "cleaner": return "<font color=Orange>User-Profil bearbeitet</font>";
        case "ctracker": return "Versuchte Angriffe";
        case "modmessages": return "Mod Nachrichten";
        case "autowarn": return "Systemverwarnungen";
        case "autodewarn": return "Systemverwarnungen entfernt";
        case "cleanup": return "<font color=red>Cleanup</font>";
		case "cleanuperr": return "<font color=red>Cleanup fehlgeschlagen</font>";
        case "denied": return "<font color=red>Unerlaubte Zugriffe</font>";
    } 
} 

$timerange = array(3600 => "1 Stunde",
    3 * 3600 => "3 Stunden",
    6 * 3600 => "6 Stunden",
    9 * 3600 => "9 Stunden",
    12 * 3600 => "12 Stunden",
    18 * 3600 => "18 Stunden",
    24 * 3600 => "1 Tag",
    2 * 24 * 3600 => "2 Tage",
    3 * 24 * 3600 => "3 Tage",
    4 * 24 * 3600 => "4 Tage",
    5 * 24 * 3600 => "5 Tage",
    6 * 24 * 3600 => "6 Tage",
    7 * 24 * 3600 => "1 Woche",
    14 * 24 * 3600 => "2 Wochen"
    );

$types = array('torrentupload', 'torrentedit', 'torrentdelete', 'torrentgranted','commentpost', 'promotion', 'demotion', 'addwarn', 'remwarn', 'security_tactics', 'accenabled', 'accdisabled', 'accdeleted', 'parked', 'ctracker', 'modmessages', 'passkeyreset', 'passkeyadminreset', 'cleanup', 'cleanuperr', 'denied',); 
// delete items older than two weeks
$secs = 14 * 24 * 3600;
x264_bootstrap_header("Site log");
mysql_query("DELETE FROM sitelog WHERE " . time() . " - UNIX_TIMESTAMP(added) > $secs") or sqlerr(__FILE__, __LINE__);
$where = "WHERE ";
$typelist = Array();

if (isset($_GET["types"])) {
    foreach ($_GET["types"] as $type) {
        $typelist[] = sqlesc($type);
    } 
    $where .= "typ IN (" . implode(",", $typelist) . ") AND ";
} 

if (isset($_GET["timerange"]))
    $where .= time() . "-UNIX_TIMESTAMP(added)<" . intval($_GET["timerange"]);
else {
    $where .= time() . " - UNIX_TIMESTAMP(added) < 432000";
    $_GET["timerange"] = 432000;
} 

if($_GET['cleand']){
echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Site Log gel&ouml;scht
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<font size='3' color='".($_GET['cleand'] == 'ok' ? "green'>Der Logtype ".htmlentities($types[$_GET['type']])." wurde erfolgreich geleert" : "red'> Der Logtype ".htmlentities($types[$_GET['type']])." konnte nich geleert werden")."</font></font>
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
                                    <i class='fa fa-edit'></i>Site Log l&ouml;schen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<form method='post' action='".$_SERVER['PHP_SELF']."'><center>
										<div>Wähle den Logtype der geleert werden soll:</div>
										<select name='type'>
											<option value=''>Logtype wählen</option>
												$typeopt
										</select>
										<input type='submit' name='submit' value='Leeren'>
									</form>
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
                                    <i class='fa fa-edit'></i>Site Log auswahl
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<form action='log.php' method='get'><a name='log'></a>";
$I = 0;

foreach ($types as $type)
{
    if ($I == 4)
    {
        $I = 0;
    }

    if (($type != "viewlog") || (get_user_class() >= UC_SYSOP))
    {
	echo"
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>";	
       print("<input type=\"checkbox\" name=\"types[]\" value=\"$type\"");
       if (in_array(sqlesc($type), $typelist))
          print(" checked=checked");

       print("> <a href=\"" . $_SERVER["PHP_SELF"] . "?timerange=" . intval($_GET["timerange"]) . "&amp;types[]=$type&amp;filter=1#log\">" . get_typ_name($type) . "</a>                                            </div>
                                        </div>
                                    </div>");
       $I++;
    }
} 

echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Site Log Einstellungen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>					
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>";

if ($I < 4)
    echo "<div colspan=\"" . (4 - $I) . "\" >&nbsp;\n";
print("<div class=\"x264_nologged_inp\"><a href=\"log.php?timerange=" . intval($_GET["timerange"]) . "&amp;filter=1#log\">Alle anzeigen</a></div><div class=\"x264_tfile_add_inc\" align=\"center\">Zeitraum: <select name=\"timerange\" size=\"1\">\n");
foreach ($timerange as $range => $desc) {
    print "<option value=\"$range\"";
    if (intval($_GET["timerange"]) == $range)
        echo " selected=\"selected\"";
    print ">$desc</option>\n";
} 

print("</select>
		<div><input type=\"submit\" name=\"filter\" value=\"Filtern\"></div></div>
		</form>
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>");


if (isset($_GET["filter"])) {

echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Site Log Ergebnis
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>";
	
    $res = mysql_query("SELECT typ, added, txt FROM sitelog $where ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);

    if (mysql_num_rows($res) == 0)
        print("<div class='x264_title_table'>Es liegen keine Ereignisse mit den gewünschten Typen vor.</div>\n");
    else {
        print("<div class='x264_title_table'>Es wurden " . mysql_num_rows($res) . " Ereignisse mit den gewünschten Typen gefunden.</div>\n");
		print"
                  <th>Datum</th>
                  <th>Zeit</th>
                  <th>Typ</th>
                  <th>Ereignis</th>
                </tr>
                </thead>
                <tbody>";
        while ($arr = mysql_fetch_assoc($res))
        {
            $typ = get_typ_name($arr["typ"]);
           if (($arr["typ"] != "viewlog") || (get_user_class() >= UC_SYSOP))
            {
               $date = substr($arr['added'], 0, strpos($arr['added'], " "));
               $time = substr($arr['added'], strpos($arr['added'], " ") + 1);
               $text = trim(str_replace("S&L bei","S&amp;L bei",$arr[txt]));
			   print"				
                </tbody>
                <tfoot>
                <tr>
                  <th>".$date."</th>
                  <th>".$time."</th>
                  <th>".$typ."</th>
                  <th>".$text."</th>
                </tr>
                </tfoot>";			   
            }
        } 

    }
    print("<div class='x264_title_table'>Alle Zeitangaben sind lokal.</div>\n");
	
echo"
              </table>
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";	
} 

x264_bootstrap_footer();
?>