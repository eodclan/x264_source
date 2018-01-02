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

$act = $_GET["act"];
$id = $_GET["id"];
// DELETE FORUM ACTION
if ($_GET['action'] == "del") {

if (get_user_class() < UC_MODERATOR)
stderr("Error", "<b><p>Aber Hallo Kollege, wat willst du denn hier?</p></b>");

if (!$id) {
header("Location: $PHP_SELF?act=forum&" . SID);
die();
} 

$result = mysql_query ("SELECT * FROM topics where forumid = '" . intval($_GET['id']) . "'"); 
if ($row = mysql_fetch_array($result)) {
do {
mysql_query ("DELETE FROM posts where topicid = '" . $row["id"] . "'") or sqlerr(__FILE__, __LINE__);

$res = mysql_query("SELECT id FROM forum_polls WHERE topicid = '" . $row["id"] . "'");
$arr = mysql_fetch_assoc($res);
$topicidpoll = $arr["id"];
mysql_query("DELETE FROM forum_pollanswers WHERE pollid=$topicidpoll");
mysql_query("DELETE FROM forum_polls WHERE topicid = '" . $row["id"] . "'");
}

while ($row = mysql_fetch_array($result));
} 
mysql_query ("DELETE FROM topics where forumid = '" . $_GET['id'] . "'") or sqlerr(__FILE__, __LINE__);
mysql_query ("DELETE FROM forums where id = '" . $_GET['id'] . "'") or sqlerr(__FILE__, __LINE__);

header("Location: $PHP_SELF?act=forum&" . SID);
die();
} 


// DELETE CATEGORY ACTION
if ($_GET['action'] == "delcat") {

if (get_user_class() < UC_MODERATOR)
stderr("Error", "<b><p>Aber Hallo Kollege, wat willst du denn hier?</p></b>");

if (!$id) {
header("Location: $PHP_SELF?act=forum&" . SID);
die();
} 

$result = mysql_query ("SELECT * FROM forum_cats where fid = '" . intval($_GET['id']) . "'"); 
if ($row = mysql_fetch_array($result)) {

while ($row = mysql_fetch_array($result));
} 
mysql_query ("DELETE FROM forum_cats where fid = '" . $_GET['id'] . "'") or sqlerr(__FILE__, __LINE__);

header("Location: $PHP_SELF?act=forum&" . SID);
die();
} 

// EDIT FORUM ACTION
if ($_POST['action'] == "editforum") {

if (get_user_class() < UC_MODERATOR)
stderr("Error", "<b><p>Aber Hallo Kollege, wat willst du denn hier?</p></b>");

if (!$name && !$desc && !$id) {
header("Location: $PHP_SELF?act=forum&" . SID);
die();
}

$updateset = array();
$sort        = $_POST["sort"];
$name        = $_POST["name"];
$desc        = $_POST["desc"];
$readclass   = $_POST["readclass"];
$writeclass  = $_POST["writeclass"];
$createclass = $_POST["createclass"];
$fid         = $_POST["fid"];
$allowpoll   = ($_POST["allowpoll"] != "" ? "yes" : "no");
$guest       = ($_POST["guest"] != "" ? "yes" : "no");

///////////////////////////////////////////////////////////////////////////////////////////////////////
if($guest != "yes") {
$updateset[] = "guest = '$guest'";
} else {
$res = mysql_query("SELECT * FROM forums WHERE guest = 'yes'") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) > 0) {
$arr = mysql_fetch_assoc($res);
$forumsid = $arr["id"];
$forumsname = $arr["name"];
stderr("Forum erstellen","<b><p>Du kannst nicht mehrere Foren für Gastbeiträge freigeben! Zur Zeit ist das Forum <i>\"".$forumsname."\"</i> mit der Forums-ID=\"".$forumsid."\" für Gastbeiträge freigegeben.</p></b>");
} else {
$updateset[] = "guest = '$guest'";
 }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////

$updateset[] = "sort = '$sort'";
$updateset[] = "name = " . sqlesc($name);
$updateset[] = "description = " . sqlesc($desc);
$updateset[] = "minclassread = '$readclass'";
$updateset[] = "minclasswrite = '$writeclass'";
$updateset[] = "minclasscreate = '$createclass'";
$updateset[] = "fid = '$fid'";
$updateset[] = "allowpoll = '$allowpoll'";

mysql_query("UPDATE forums SET " . implode(",", $updateset) . " WHERE id = " . $_POST["id"]) or sqlerr(__FILE__,__LINE__);
header("Location: $PHP_SELF?act=forum&" . SID);
die();
} 

// EDIT CATEGORY ACTION
if ($_POST['action'] == "editcat") {

if (get_user_class() < UC_MODERATOR)
stderr("Error", "<b><p>Aber Hallo Kollege, wat willst du denn hier?</p></b>");

if (!$name && !$id) {
header("Location: $PHP_SELF?act=forum&" . SID);
die();
} 

$updateset = array();
$sort        = $_POST["sort"];
$name        = $_POST["name"];
$readclass   = $_POST["readclass"];
$fid         = $_POST["fid"];

$updateset[] = "sort = '$sort'";
$updateset[] = "name = " . sqlesc($name);
$updateset[] = "minclassread = '$readclass'";
$updateset[] = "fid = '$fid'";

mysql_query("UPDATE forum_cats SET " . implode(",", $updateset) . " WHERE fid = " . $_POST["fid"]) or sqlerr(__FILE__,__LINE__);
header("Location: $PHP_SELF?act=forum&" . SID);
die();
} 


// ADD FORUM ACTION
if ($_POST['action'] == "addforum") {

if (get_user_class() < UC_MODERATOR)
stderr("Error", "<b><p>Aber Hallo Kollege, wat willst du denn hier?</p></b>");

$name = $_POST["name"];
if (!$name)
stderr("Forum erstellen","<b></p>Der Forenname darf nicht leer sein!</p></b>");

$description = $_POST["desc"];
if (!$description)
stderr("Forum erstellen","<b><p>Die Forenbeschreibung darf nicht leer sein!</p></b>");

if (!$name && !$desc) {
header("Location: $PHP_SELF?act=forum&" . SID);
die();
}

$updateset = array();
$sort        = $_POST["sort"];
$name        = $_POST["name"];
$desc        = $_POST["desc"];
$readclass   = $_POST["readclass"];
$writeclass  = $_POST["writeclass"];
$createclass = $_POST["createclass"];
$fid         = $_POST["fid"];
$allowpoll   = ($_POST["allowpoll"] != "" ? "yes" : "no");
$guest       = ($_POST["guest"] != "" ? "yes" : "no");

///////////////////////////////////////////////////////////////////////////////////////////////////////
if($guest != "yes") {
$updateset[] = "guest = '$guest'";
} else {
$res = mysql_query("SELECT * FROM forums WHERE guest = 'yes'") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) > 0) {
$arr = mysql_fetch_assoc($res);
$forumsid = $arr["id"];
$forumsname = $arr["name"];
stderr("Forum erstellen","<b><p>Du kannst nicht mehrere Foren für Gastbeiträge freigeben! Zur Zeit ist das Forum <i>\"".$forumsname."\"</i> mit der Forums-ID=\"".$forumsid."\" für Gastbeiträge freigegeben.</p></b>");
} else {
$updateset[] = "guest = '$guest'";
 }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////

$updateset[] = "sort = '$sort'";
$updateset[] = "name = " . sqlesc($name);
$updateset[] = "description = " . sqlesc($desc);
$updateset[] = "minclassread = '$readclass'";
$updateset[] = "minclasswrite = '$writeclass'";
$updateset[] = "minclasscreate = '$createclass'";
$updateset[] = "fid = '$fid'";
$updateset[] = "allowpoll = '$allowpoll'";

mysql_query("INSERT INTO forums SET " . implode(",", $updateset) . "") or sqlerr(__FILE__,__LINE__);

header("Location: $PHP_SELF?act=forum&" . SID);
die();
}

// ADD CATEGORY ACTION
if ($_POST['action'] == "addcat") {

if (get_user_class() < UC_MODERATOR)
stderr("Error", "<b><p>Aber Hallo Kollege, wat willst du denn hier?</p></b>");

$name = $_POST["name"];
if (!$name)
stderr("Kategorie erstellen","<b></p>Der Kategoriename darf nicht leer sein!</p></b>");

$minclassread = $_POST["readclass"];
$sort = $_POST["sort"];

$selectcat = mysql_query("SELECT `fid` FROM `forum_cats` ORDER BY fid DESC LIMIT 1");
$resultcat = mysql_fetch_array($selectcat);
$fid = $resultcat["fid"];
$fid1 = $fid+1;

mysql_query("INSERT INTO forum_cats (sort,  name,  minclassread,  fid) VALUES (" . $_POST['sort'] . ", " . sqlesc($_POST['name']) . ", " . $_POST['readclass'] . ", " . $fid1 . ")") or sqlerr(__FILE__, __LINE__);

header("Location: $PHP_SELF?act=forum&" . SID);
die();
}

check_access(UC_MODERATOR);
security_tactics();

if (get_user_class() < UC_MODERATOR) {
stderr("Error", "<b><p>Aber Hallo Kollege, wat willst du denn hier?</p></b>");

} else {
x264_admin_header("".$GLOBALS["SITENAME"]." Forum Manager");
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>".$GLOBALS["SITENAME"]." Forum Manager
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";

?>
<script language="JavaScript">
<!--
function confirm_delete(id) {
if(confirm('Bist du dir sicher das du das Forum löschen willst?')) {
self.location.href='<?php $PHP_SELF?> ?action=del&id='+id;
 }
}
function confirm_deletecat(id) {
if(confirm('Bist du dir sicher das du die Kategorie löschen willst?')) {
self.location.href='<?php $PHP_SELF?> ?action=delcat&id='+id;
 }
}
//-->
</script>

<?php

$forums_cat = mysql_query("SELECT * FROM forum_cats ORDER BY sort, name") or sqlerr(__FILE__, __LINE__);
while ($forums_catarr = mysql_fetch_assoc($forums_cat)) {
if (get_user_class() < $forums_catarr["minclassread"])
continue;

$forumcat = $forums_catarr["fid"];
$forumcatname = $forums_catarr["name"];

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\"  border=\"0\" width=\"100%\" class=\"tableinborder\">");
print("<tr><td width=\"40%\" class=\"tabletitle\"><b>ID:$forumcat $forumcatname &nbsp;&nbsp;<a href=\"".$PHP_SELF . "?act=editcat&id=".$forums_catarr["fid"]."\"><img src=\"".$GLOBALS["PIC_BASE_URL"]."edit.png\" alt=\"Bearbeiten\" title=\"Bearbeiten\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:confirm_deletecat('" . $forums_catarr["fid"] . "');\"><img src=\"".$GLOBALS["PIC_BASE_URL"]."editdelete.png\" alt=\"Löschen\" title=\"Löschen\" border=\"0\"></a></b></td><td width=\"8%\" align=\"center\" class=\"tabletitle\"><b>Themen</b></td><td width=\"8%\" align=\"center\" class=\"tabletitle\"><b>Beiträge</b></td><td width=\"12%\" align=\"center\" class=\"tabletitle\"><b>Lesen</b></td><td width=\"12%\" align=\"center\" class=\"tabletitle\"><b>Schreiben</b></td><td width=\"12%\" align=\"center\" class=\"tabletitle\"><b>Erstellen</b></td><td width=\"8%\" align=\"center\" class=\"tabletitle\"><b>Editieren</b></td></tr>");

$result = mysql_query ("SELECT  * FROM forums WHERE fid=$forumcat ORDER BY sort ASC");

if ($row = mysql_fetch_array($result)) {
do {
print("<tr><td class=\"tablea\"><b>ID:".$row["id"]."</b> <a href=\"forums.php?action=viewforum&forumid=".$row["id"]."\"><b>".$row["name"]."</b></a>");

if($row["guest"] == "yes") {
print("&nbsp;&nbsp;<img src=\"".$GLOBALS["PIC_BASE_URL"]."/user.png\" width=\"14\" height=\"14\" title=\"Dieses Forum ist für Gastbeiträge freigegeben.\">");
}

print("<br>".$row["description"]."</td>");
print("<td align=\"center\" class=\"tablea\">".$row["topiccount"]."</td><td align=\"center\" class=\"tablea\">".$row["postcount"]."</td><td class=\"tablea\">Min. ".get_user_class_name($row["minclassread"])."</td><td class=\"tablea\">Min. ".get_user_class_name($row["minclasswrite"])."</td><td class=\"tablea\">Min. ".get_user_class_name($row["minclasscreate"])."</td><td align=\"center\" class=\"tablea\"><a href=\"".$PHP_SELF . "?act=editforum&id=".$row["id"]."\"><img src=\"".$GLOBALS["PIC_BASE_URL"]."edit.png\" alt=\"Bearbeiten\" title=\"Bearbeiten\" border=\"0\"></a>&nbsp;&nbsp;&nbsp;<a href=\"javascript:confirm_delete('" . $row["id"] . "');\"><img src=\"".$GLOBALS["PIC_BASE_URL"]."editdelete.png\" alt=\"Löschen\" title=\"Löschen\" border=\"0\"></a></b></td></tr>");
}

while ($row = mysql_fetch_array($result));
print("</table>");

} else {
print "<tr><td colspan=\"7\" class=\"tablea\">Es wurden keine Foren gefunden!</td></tr></table>";
 }
}

print("<center><p><a href=\"forummanager.php?act=addforum\"><input type=\"submit\" value=\"Forum hinzufügen\" class=\"btn\"></a>&nbsp;&nbsp;<a href=\"forummanager.php?act=addcat\"><input type=\"submit\" value=\"Kategorie hinzufügen\" class=\"btn\"></a></p></center>");

if ($act == "addforum") {
?>
<form method="post" action="<?=$PHP_SELF?>">
<table align="center" cellpadding="4" cellspacing="1"  border="0" width="600" class="tableinborder">
<tr><td align="center" colspan="2" class="tabletitle"><span class=\"normalfont\"><b>Neues Forum erstellen</b></span></td></tr>
<tr><td class="tableb"><b>Forenname</b></td><td class="tablea"><input name="name" type="text" size="60" maxlength="60"></td></tr>
<tr><td class="tableb"><b>Forenbeschreibung</b></td><td class="tablea"><input name="desc" type="text" size="60" maxlength="200"></td></tr>

<?php
print("<tr><td class=tableb><b>Min. Leserechte</b></td><td class=tablea><select name=readclass>\n");
$maxclass = get_user_class();
for ($i = 0; $i <= $maxclass; ++$i)

if (get_user_class_name($i) != "")
print("<option value=$i" . ($row["minclassread"] == $i ? " selected" : "") . ">$prefix" . get_user_class_name($i) . "\n");
print("</select></td></tr>\n");


print("<tr><td class=tableb><b>Min. Schreibrechte</b></td><td class=tablea><select name=writeclass>\n");
$maxclass = get_user_class();
for ($i = 0; $i <= $maxclass; ++$i)

if (get_user_class_name($i) != "")
print("<option value=$i" . ($row["minclasswrite"] == $i ? " selected" : "") . ">$prefix" . get_user_class_name($i) . "\n");
print("</select></td></tr>\n");


print("<tr><td class=tableb><b>Min. Rechte Topic erstellen</b></td><td class=tablea><select name=createclass>\n");
$maxclass = get_user_class();
for ($i = 0; $i <= $maxclass; ++$i)

if (get_user_class_name($i) != "")
print("<option value=$i" . ($row["minclasscreate"] == $i ? " selected" : "") . ">$prefix" . get_user_class_name($i) . "\n");
print("</select></td></tr>\n");


print("<tr><td class=tableb><b>Forenrank</b></td><td class=tablea><select name=sort>\n");

$res = mysql_query ("SELECT sort FROM forums");
$nr = mysql_num_rows($res);
$maxclass = $nr + 1;
for ($i = 0; $i <= $maxclass; ++$i)
print("<option value=$i>$i");
?>

</select>
</td></tr>

<tr><td class="tableb"><b>Kategorierank</b></td><td class="tablea">
<select name=fid>

<?php
$res = mysql_query ("SELECT fid FROM forum_cats");
$nr = mysql_num_rows($res);
$maxclass = $nr;
for ($i = 0; $i <= $maxclass; ++$i)
print("<option value=$i>$i");
?>

</select>
</td></tr>

<tr><td class="tableb"><b>Umfragen</b></td><td class=tablea>
<?
print("<input type=\"checkbox\" name=\"allowpoll\"" . ($row["allowpoll"] == "yes" ? " checked\"checked\"" : "") . "> Umfragen im Forum erlauben.");
?>
</td></tr>

<tr><td class="tableb"><b>Gastbeiträge</b></td><td class=tablea>
<?
print("<input type=\"checkbox\" name=\"guest\"" . ($row["guest"] == "yes" ? " checked\"checked\"" : "") . "> Gastbeiträge im Forum erlauben.");
?>
</td></tr>

<tr><td align="center" colspan="2" class="tableb"><input type="hidden" name="action" value="addforum"><input type="submit" name="Submit" value="Erstellen"></td></tr>
</table>

<?php
}

// ADD CATEGORY

if ($act == "addcat") {
?>
<form method="post" action="<?=$PHP_SELF?>">
<table align="center" cellpadding="4" cellspacing="1"  border="0" width="600" class="tableinborder">
<tr><td align="center" colspan="2" class="tabletitle"><span class=\"normalfont\"><b>Neue Kategorie erstellen</b></span></td></tr>
<tr><td class="tableb"><b>Kategoriename</b></td><td class="tablea"><input name="name" type="text" size="60" maxlength="60"></td></tr>

<?php
print("<tr><td class=tableb><b>Min. Leserechte</b></td><td class=tablea><select name=readclass>\n");
$maxclass = get_user_class();
for ($i = 0; $i <= $maxclass; ++$i)

if (get_user_class_name($i) != "")
print("<option value=$i" . ($row["minclassread"] == $i ? " selected" : "") . ">$prefix" . get_user_class_name($i) . "\n");
print("</select></td></tr>\n");

?>
<tr><td class="tableb"><b>Kategorierank</b></td><td class="tablea">
<select name=sort>

<?php
$res = mysql_query ("SELECT sort FROM forum_cats");
$nr = mysql_num_rows($res);
$maxclass = $nr + 1;
for ($i = 0; $i <= $maxclass; ++$i)
print("<option value=$i>$i");
?>

</select>
</td></tr>
<tr><td align="center" colspan="2" class="tableb"><input type="hidden" name="action" value="addcat"><input type="submit" name="Submit" value="Erstellen"></td></tr>
</table>

<?php
}

if ($act == "editcat") {
// EDIT PAGE FOR THE CATEGORYS

$fid = $_GET["id"];

$result = mysql_query ("SELECT * FROM forum_cats where fid = '$fid'");

if ($row = mysql_fetch_array($result)) {
do {

?>
<form method="post" action="<?=$PHP_SELF?>">
<table align="center" cellpadding="4" cellspacing="1" border="0" width="600" class="tableinborder">
<tr><td align="center" colspan="2" class="tabletitle"><span class"normalfont"><b>Kategorie <i>"<?=$row["name"]?>" bearbeiten</b></span></td></tr>
<tr><td class="tableb"><b>Kategoriename</b></td><td class="tablea"><input name="name" type="text" size="50" maxlength="60" value="<?=$row["name"]?>"></td></tr>

<?php
print("<tr><td class=tableb><b>Min. Leserechte</b></td><td class=tablea><select name=readclass>\n");
$maxclass = get_user_class();
for ($i = 0; $i <= $maxclass; ++$i)

if (get_user_class_name($i) != "")
print("<option value=$i" . ($row["minclassread"] == $i ? " selected" : "") . ">$prefix" . get_user_class_name($i) . "\n");
print("</select></td></tr>\n");

?>
<tr><td class="tableb"><b>Kategorierank</b></td><td class="tablea">
<select name=sort>

<?php
$res = mysql_query ("SELECT sort FROM forum_cats");
$nr = mysql_num_rows($res);
$maxclass = $nr + 1;
for ($i = 0; $i <= $maxclass; ++$i)
print("<option value=$i" . ($row["sort"] == $i ? " selected" : "") . ">$i");

?>
</select></td></tr>
<tr><td align="center" colspan="2" class="tableb"><input type="hidden" name="action" value="editcat"><input type="hidden" name="fid" value="<?=$fid?>"><input type="submit" name="Submit" value="Kategorie editieren"></td></tr>
</table>

<?php
}
while ($row = mysql_fetch_array($result));
}
else {
print "Sorry, aber es wurde keine Kategorie gefunden!";
  }
 }

if ($act == "editforum") {
// EDIT PAGE FOR THE FORUMS

$id = $_GET["id"];

$result = mysql_query ("SELECT * FROM forums where id = '$id'");

if ($row = mysql_fetch_array($result)) {
do {

?>
<form method="post" action="<?=$PHP_SELF?>">
<table align="center" cellpadding="4" cellspacing="1" border="0" width="600" class="tableinborder">
<tr><td align="center" colspan="2" class="tabletitle"><span class"normalfont"><b>Forum <i>"<?=$row["name"]?>" bearbeiten</b></span></td></tr>
<tr><td class="tableb"><b>Forenname</b></td><td class="tablea"><input name="name" type="text" size="50" maxlength="60" value="<?=$row["name"]?>"></td></tr>
<tr><td class="tableb"><b>Forenbeschreibung</b></td><td class="tablea"><input name="desc" type="text" size="50" maxlength="200" value="<?=$row["description"]?>"></td></tr>

<?php
print("<tr><td class=tableb><b>Min. Leserechte</b></td><td class=tablea><select name=readclass>\n");
$maxclass = get_user_class();
for ($i = 0; $i <= $maxclass; ++$i)

if (get_user_class_name($i) != "")
print("<option value=$i" . ($row["minclassread"] == $i ? " selected" : "") . ">$prefix" . get_user_class_name($i) . "\n");
print("</select></td></tr>\n");


print("<tr><td class=tableb><b>Min. Schreibrechte</b></td><td class=tablea><select name=writeclass>\n");
$maxclass = get_user_class();
for ($i = 0; $i <= $maxclass; ++$i)

if (get_user_class_name($i) != "")
print("<option value=$i" . ($row["minclasswrite"] == $i ? " selected" : "") . ">$prefix" . get_user_class_name($i) . "\n");
print("</select></td></tr>\n");


print("<tr><td class=tableb><b>Min. Rechte Topic erstellen</b></td><td class=tablea><select name=createclass>\n");
$maxclass = get_user_class();
for ($i = 0; $i <= $maxclass; ++$i)

if (get_user_class_name($i) != "")
print("<option value=$i" . ($row["minclasscreate"] == $i ? " selected" : "") . ">$prefix" . get_user_class_name($i) . "\n");
print("</select></td></tr>\n");


print("<tr><td class=tableb><b>Forenrank</b></td><td class=tablea><select name=sort>\n");

$res = mysql_query ("SELECT sort FROM forums");
$nr = mysql_num_rows($res);
$maxclass = $nr + 1;
for ($i = 0; $i <= $maxclass; ++$i)
print("<option value=$i" . ($row["sort"] == $i ? " selected" : "") . ">$i");

?>
</select>
</td></tr>

<tr><td class="tableb"><b>Kategorierank</b></td><td class="tablea">
<select name=fid>

<?php
$res = mysql_query ("SELECT fid FROM forum_cats");
$nr = mysql_num_rows($res);
$maxclass = $nr;
for ($i = 0; $i <= $maxclass; ++$i)
print("<option value=$i" . ($row["fid"] == $i ? " selected" : "") . ">$i");

?>
</select>
</td></tr>

<tr><td class="tableb"><b>Umfragen</b></td><td class=tablea>
<?
print("<input type=\"checkbox\" name=\"allowpoll\"" . ($row["allowpoll"] == "yes" ? " checked\"checked\"" : "") . "> Umfragen im Forum erlauben.");
?>
</td></tr>

</td></tr>

<tr><td class="tableb"><b>Gastbeiträge</b></td><td class=tablea>
<?
print("<input type=\"checkbox\" name=\"guest\"" . ($row["guest"] == "yes" ? " checked\"checked\"" : "") . "> Gastbeiträge im Forum erlauben.");
?>
</td></tr>

<tr><td align="center" colspan="2" class="tableb"><input type="hidden" name="action" value="editforum"><input type="hidden" name="id" value="<?=$id?>"><input type="submit" name="Submit" value="Forum editieren"></td></tr>
</table>

<?php
}

while ($row = mysql_fetch_array($result));
} else {
print "Sorry, aber es wurde kein Forum gefunden!";
  }
 }
}
print "	
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
x264_admin_footer();
?>