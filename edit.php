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

hit_start();

if (!mkglobal("id"))
	die();

$id = 0 + $id;
if (!$id)
	die();

dbconn();
hit_count();
loggedinorreturn();

$trackerconfig = explode("|",htmlentities(trim(get_config_data('TRACKERCONF'))));
if ($trackerconfig[4] == "off")
  stderr("Zur Zeit gesperrt","Torrentedit ist zur Zeit deaktiviert!");

$res = mysql_query("SELECT torrents.*,users.class FROM torrents LEFT JOIN users ON torrents.owner=users.id WHERE torrents.id = $id");
$row = mysql_fetch_array($res);
if (!$row)
	die();
$team=$row["team"];
$grpsel="";
$grpres=mysql_query("select distinct teams.id,teams.name from teams, teammembers where teammembers.teamid=teams.id and teammembers.userid=$CURUSER[id] and teams.typ='crew' group by teams.id order by teams.name");
while($grparr=mysql_fetch_assoc($grpres))
{
  $grpsel.="<option value=\"$grparr[id]\">$grparr[name]</option>";
}
$grpsel="<select name=\"team\"><option value=\"0\">---[ Bitte auswählen ]---</option>$grpsel</select>";
x264_header("Torrent \"" . $row["name"] . "\" bearbeiten");

if (!isset($CURUSER) || !($CURUSER["id"] == $row["owner"] || get_user_class() >= UC_MODERATOR || ($row["activated"] == "no" && get_user_class() == UC_MODERATOR && $row["class"] < UC_UPLOADER))) {
?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-edit"></i> Du darfst diesen Torrent nicht bearbeiten
                                    <div class="card-actions">
                                        <a href="#" class="btn-close"><i class="icon-close"></i></a>
                                    </div>
                                </div>
                                <div class="card-block">
									Du bist nicht der rechtm&auml;&szlig;ige Besitzer, oder Du bist nicht korrekt
									<a href="login.php?returnto=<?=urlencode($_SERVER["REQUEST_URI"])?>&amp;nowarn=1">eingeloggt</a>.
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?
}
else {
	print("<form method=post action=takeedit.php enctype=multipart/form-data>\n");
	print("<input type=\"hidden\" name=\"id\" value=\"$id\">\n");
	if (isset($_GET["returnto"]))
		print("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars($_GET["returnto"]) . "\" />\n");
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-info-circle'></i>Torrent bearbeiten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
<table class="table table-bordered table-striped table-condensed">
<?        
	tr("Torrent Name", "<input type=\"text\" name=\"name\" value=\"" . htmlspecialchars($row["name"]) . "\" size=\"80\" class='btn btn-flat btn-primary fc-today-button' />", 1);
	tr("TVDB Titel", "<input type=\"text\" name=\"tvdb\" value=\"" . htmlspecialchars($row["tvdb"]) . "\" size=\"80\" class='btn btn-flat btn-primary fc-today-button' />", 1);	
	tr("NFO Datei", "<input type=radio name=nfoaction value='keep' class='btn btn-flat btn-primary fc-today-button' checked>Aktuelle beibehalten<br>".
	"<input type=radio name=nfoaction value='update' class='btn btn-flat btn-primary fc-today-button'>Ändern:<br><input type=file name=nfo size=60 class='btn btn-flat btn-primary fc-today-button'>", 1);
if ((strpos($row["ori_descr"], "<") === false) || (strpos($row["ori_descr"], "&lt;") !== false))
  $c = "";
else
  $c = " checked";

    tr("Bilder", "<input type=radio name=picaction value='keep' class='btn btn-flat btn-primary fc-today-button' checked>Aktuelle beibehalten<br>"
	   ."<input type=radio name=picaction value='update'class='btn btn-flat btn-primary fc-today-button' >Ändern (leer lassen, um Bilder zu löschen):<br>"
       ."$s<input type=\"file\" name=\"pic1\" size=\"80\" class='btn btn-flat btn-primary fc-today-button'><br>(Optional. Wird oberhalb der "
       ."Torrentbeschreibung angezeigt. Max. Größe: ".mksizeint($GLOBALS["MAX_UPLOAD_FILESIZE"]).")<br><br>\n"
       ."<input type=\"file\" name=\"pic2\" size=\"80\" class='btn btn-flat btn-primary fc-today-button'><br>(Optional. Wird oberhalb der "
       ."Torrentbeschreibung angezeigt. Max. Größe: ".mksizeint($GLOBALS["MAX_UPLOAD_FILESIZE"]).")\n", 1);
  
	tr("Beschreibung", "<textarea name=\"descr\" rows=\"15\" cols=\"80\" class='btn btn-flat btn-primary fc-today-button'>" . htmlspecialchars($row["ori_descr"]) . "</textarea>".
       "<br><input type=\"checkbox\" name=\"stripasciiart\" value=\"1\" class='btn btn-flat btn-primary fc-today-button'> ASCII-Art automatisch entfernen" .
       "<br>(HTML ist <b>nicht</b> erlaubt. Klick <a href=tags.phpclass='btn btn-flat btn-primary fc-today-button' >hier</a>, f&uuml;r die Ansicht des BB-Codes.)", 1);
tr("Highlight", "<input type='checkbox' name='highlight'" . (($row["highlight"] == "yes") ? " checked='checked'" : "" ) . " value='1' />Als Kino Highlight markieren.", 1);    

if(get_user_class()>=UC_SYSOP) {
      tr("Multiplikator", "<select name='multiplikator' class='btn btn-flat btn-primary fc-today-button'><option value=1".($row["multiplikator"]=="1"?" selected":"").">1x</option><option value=2".($row["multiplikator"]=="2"?" selected":"").">2x</option><option value=5".($row["multiplikator"]=="5"?" selected":"").">5x</option><option value=10".($row["multiplikator"]=="10"?" selected":"").">10x</option></select>", 1);
}
tr("Sprache", "<input type=radio name=language" . ($row["language"] == "na" ? " checked" : "") . " value=na>N/A <input type=radio name=language" . ($row["language"] == "deutsch" ? " checked" : "") . " value=deutsch>Deutsch <input type=radio name=language" . ($row["language"] == "englisch" ? " checked" : "") . " value=englisch>Englisch <input type=radio name=language" . ($row["language"] == "multi" ? " checked" : "") . " value=multi>Multi",1);

	
$newcats .= "<select name=\"type\">\n<option value=\"0\">(ausw&auml;hlen)</option>\n"; 
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
tr("Typ", $newcats, 1);   
// BEGIN: Groups Edition by truenoir
  tr("Group", $grpsel, 1);
// END: Groups Edition by truenoir
              $ss="<select name=\"seedspeed\" class='btn btn-flat btn-primary fc-today-button'>\n
<option".(($row["seedspeed"] == "12 KB/s") ? " selected" : "" ).">12 KB/s</option>
<option".(($row["seedspeed"] == "16 KB/s") ? " selected" : "" ).">16 KB/s</option>
<option".(($row["seedspeed"] == "20 KB/s") ? " selected" : "" ).">20 KB/s</option>
<option".(($row["seedspeed"] == "28 KB/s") ? " selected" : "" ).">28 KB/s</option>
<option".(($row["seedspeed"] == "32 KB/s") ? " selected" : "" ).">32 KB/s</option>
<option".(($row["seedspeed"] == "44 KB/s") ? " selected" : "" ).">44 KB/s</option>
<option".(($row["seedspeed"] == "50 KB/s") ? " selected" : "" ).">50 KB/s</option>
<option".(($row["seedspeed"] == "60 KB/s") ? " selected" : "" ).">60 KB/s</option>
<option".(($row["seedspeed"] == "70 KB/s") ? " selected" : "" ).">70 KB/s</option>
<option".(($row["seedspeed"] == "80 KB/s") ? " selected" : "" ).">80 KB/s</option>
<option".(($row["seedspeed"] == "100 KB/s") ? " selected" : "" ).">100 KB/s</option>
<option".(($row["seedspeed"] == "200 KB/s") ? " selected" : "" ).">200 KB/s</option>
<option".(($row["seedspeed"] == "300 KB/s") ? " selected" : "" ).">300 KB/s</option>
<option".(($row["seedspeed"] == "500 KB/s") ? " selected" : "" ).">500 KB/s</option>
<option".(($row["seedspeed"] == "1 MB/s") ? " selected" : "" ).">1 MB/s</option>
<option".(($row["seedspeed"] == "1,5 MB/s") ? " selected" : "" ).">1,5 MB/s</option>
<option".(($row["seedspeed"] == "2 MB/s") ? " selected" : "" ).">2 MB/s</option>
<option".(($row["seedspeed"] == "2,5 MB/s") ? " selected" : "" ).">2,5 MB/s</option>
<option".(($row["seedspeed"] == "3 MB/s") ? " selected" : "" ).">3 MB/s</option>
<option".(($row["seedspeed"] == "3,5 MB/s") ? " selected" : "" ).">3,5 MB/s</option>
<option".(($row["seedspeed"] == "4 MB/s") ? " selected" : "" ).">4 MB/s</option>
<option".(($row["seedspeed"] == "4,5 MB/s") ? " selected" : "" ).">4,5 MB/s</option>
<option".(($row["seedspeed"] == "5 MB/s") ? " selected" : "" ).">5 MB/s</option>
<option".(($row["seedspeed"] == "&lt;5 MB/s") ? " selected" : "" ).">&lt;5 MB/s</option>
</select>";
tr("Seed Speed",$ss."Wie schnell seedest du das Torrent?",1);
	tr("Visible", "<input type=\"checkbox\" name=\"visible\"" . (($row["visible"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" class='btn btn-flat btn-primary fc-today-button'/> Visible on main page<br /><table border=0 cellspacing=0 cellpadding=0 width=420><tr><td class=embedded>Note that the torrent will automatically become visible when there's a seeder, and will become automatically invisible (dead) when there has been no seeder for a while. Use this switch to speed the process up manually. Also note that invisible (dead) torrents can still be viewed or searched for, it's just not the default.</td></tr></table>", 1);

	if ($CURUSER["class"] >= UC_MODERATOR)
		tr("Gebannt", "<input type=\"checkbox\" name=\"banned\"" . (($row["banned"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\" class='btn btn-flat btn-primary fc-today-button'/> Diesen Torrent bannen", 1);

            if(get_user_class()>=UC_SYSOP)
               tr("Only Upload", "<input type='checkbox' name='free'" . (($row["free"] == "yes") ? " checked='checked'" : "" ) . " value='1' /> Only Upload (Nur die Upload Stats werden gezählt)", 1);
		tr("FreeLeech", "<input type='checkbox' name='freeleech'" . (($row["freeleech"] == "yes") ? " checked='checked'" : "" ) . " value='1' />Torrent auf Freeleech setzen", 1);
        tr("Nuked", "<input type='checkbox' name='nuked'" . (($row["nuked"] == "yes") ? " checked='checked'" : "" ) . " value='1' /> Nuked", 1);
tr("Nuke Grund", "<input type=\"text\" name=\"nukereason\" value=\"" . htmlspecialchars($row["nukereason"]) . "\" size=\"80\" class='btn btn-flat btn-primary fc-today-button' />", 1);
if(get_user_class()>=UC_CODER){
                tr("Zeit-OU ", "<input type=\"text\" size=\"20\" name=\"freeuntil\"><b><font color=red>&nbsp;Datum eintragen bis wann OU sein soll (Format Jahr-Monat-Tag)</font></b>".
                "<br><input type=\"checkbox\" name=\"freetime\"" . (($row["freetime"] == "yes") ? " checked=\"checked\"" : "" ) . " value=\"1\"> Zeit OU jetzt setzen", 1);
                }

// BEGIN: Image Upload zu ImageShack by truenoir (#IM01)
  tr("BitBucket", "<input type='checkbox' name='resetimg' value='1' /> Bilder aus dem BitBucket verwenden, nicht ImageShack", 1);
// END: Image Upload zu ImageShack by truenoir (#IM01)
	print("<tr><td class=\"tablea\" colspan=\"2\" align=\"center\"><input type=\"submit\" value='Edit it!' class='btn btn-flat btn-primary fc-today-button'> <input type=reset value='Revert changes' class='btn btn-flat btn-primary fc-today-button'></td></tr>\n");
	print("</table>\n");
	print("</form>\n");
	print("<br>\n");
	print("<form method=\"post\" action=\"delete.php\">\n");
  print("<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" style=\"width:650px;\" class=\"table table-bordered table-striped table-condensed\">\n");
  print("<tr class=\"tabletitle\"><td colspan=\"2\"><span class=\"normalfont\"><center><b>Torrent löschen.</b> Grund:</b></center></span></td></tr>");
  print("<td class=\"tableb\"><input name=\"reasontype\" type=\"radio\" value=\"1\">&nbsp;Tot </td><td class=\"tablea\"> 0 Seeder, 0 Leecher = 0 Peers gesamt</td></tr>\n");
  print("<tr><td class=\"tableb\"><input name=\"reasontype\" type=\"radio\" value=\"2\" class='btn btn-flat btn-primary fc-today-button'>&nbsp;Doppelt</td><td class=\"tablea\"><input type=\"text\" size=\"60\" name=\"reason[]\" class='btn btn-flat btn-primary fc-today-button'></td></tr>\n");
  print("<tr><td class=\"tableb\"><input name=\"reasontype\" type=\"radio\" value=\"3\" class='btn btn-flat btn-primary fc-today-button'>&nbsp;Nuked</td><td class=\"tablea\"><input type=\"text\" size=\"60\" name=\"reason[]\" class='btn btn-flat btn-primary fc-today-button'></td></tr>\n");
  print("<tr><td class=\"tableb\"><input name=\"reasontype\" type=\"radio\" value=\"4\" class='btn btn-flat btn-primary fc-today-button'>&nbsp;Regelbruch</td><td class=\"tablea\"><input type=\"text\" size=\"60\" name=\"reason[]\" class='btn btn-flat btn-primary fc-today-button'>(req)</td></tr>");
  print("<tr><td class=\"tableb\"><input name=\"reasontype\" type=\"radio\" value=\"5\" class='btn btn-flat btn-primary fc-today-button' checked>&nbsp;Anderer</td><td class=\"tablea\"><input type=\"text\" size=\"60\" name=\"reason[]\" class='btn btn-flat btn-primary fc-today-button'>(req)</td></tr>\n");
	print("<input type=\"hidden\" name=\"id\" value=\"$id\">\n");
	if (isset($_GET["returnto"]))
		print("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars($_GET["returnto"]) . "\" />\n");
  print("<td class=\"tablea\" colspan=\"2\" align=\"center\"><input type=submit value='Löschen!' class='btn btn-flat btn-primary fc-today-button'></td></tr>\n");
  print("</table>");
	print("</form>\n");
	print("</p>\n");
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}

x264_footer();
hit_end();
?>