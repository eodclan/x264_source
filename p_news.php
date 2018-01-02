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
dbconn(true);
loggedinorreturn();
x264_header("Partner News");

$action = htmlentities($_GET["action"]);

if(empty($action)) {

$get_partnerpm = mysql_query("SELECT * FROM p_news ORDER BY id DESC");
if (get_user_class() >= UC_PARTNER){
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-users'></i>Partner News
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<div>Bedenke bitte unsere Regeln!<br /><br />Denn nur dann kannst du mit uns eine Partnerschaft aufrechterhalten!<br /><br />Mit freundlichen Grüßen<br /><br />Das ".$GLOBALS["SITENAME"]." Team</div>
									<div><a href='".$_SERVER['PHP_SELF']."?action=create_partnerpm'>Partner News hinzufügen</a></div>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-users'></i>Partner News
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
<table width="100%" border="0" cellspacing="1" cellpadding="4" class="tableinborder">
  <tr>
    <td class="x264_title_table">Tracker</td>
    <td class="x264_title_table">Datum</td>
    <td class="x264_title_table">Betreff</td>
    <td class="x264_title_table">Nachricht</td>
<?
if (get_user_class() >= UC_MODERATOR){
?>
    <td class="x264_title_table" colspan="2">Optionen</td>
<?
}
?>
  </tr>
<?
while($data_partnerpm = mysql_fetch_array($get_partnerpm)) {
?>
  <tr>
    <td class="x264_title_table" style="width:20%;"><?php echo htmlentities($data_partnerpm["tracker"]); ?></td>
    <td class="x264_title_table" style="width:20%;"><?php echo htmlentities($data_partnerpm["datum"]); ?></td>
    <td class="x264_title_table" style="width:20%;"><?php echo htmlentities($data_partnerpm["titel"]); ?></td>
    <td class="x264_title_table" style="width:40%;"><marquee style="width:95%;" direction='left' onmouseover='this.setAttribute('scrollamount', 0, 0);' onmouseout='this.setAttribute('scrollamount', 6, 0);' scrollamount='6'><?php echo htmlentities($data_partnerpm["text"]); ?></marquee></td>
<?
if (get_user_class() >= UC_MODERATOR){
?>
    <td class="x264_title_table" style="width:20%;"><center><a href="p_news.php?action=delete_partnerpm&id=<?php echo htmlentities($data_partnerpm["id"]); ?>"><img src='/pic/delete.gif' alt='' border='0' style='width:20;hight:20' title='Löschen'></a></center></td>
<?
}
?>
  </tr>
<? } ?>
</table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?
}
if($action == "create_partnerpm" AND get_user_class() >= UC_PARTNER) {
?>
<form method="post" action="p_news.php?action=create_partnerpm_do">
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-users'></i>Partner News Hinzufügen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<div>Tracker</div><div><input type="text" name="tracker" /></div>	
									<div>Betreff:</div> <div><input type="text" name="titel" /></div>
									<input type="hidden" name="username" value="<?=$CURUSER["username"]?>"/>
									<div>Nachricht:</div><div><input type="text" name="text" /></div>
									<div>Senden:</div><div><input name="submit" type="submit" value="Eintragen" /> <input name="reset" type="reset" /></div>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</form>
<?
}

if($action == "create_partnerpm_do" AND get_user_class() >= UC_PARTNER) {

$error = 0;
$tracker = $_POST["tracker"];
$titel = $_POST["titel"];
$username = $_POST["username"];
$text = $_POST["text"];

if(empty($tracker) OR empty($titel) OR empty($text)) { $error = 1; }

if($error == 1) {
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-users'></i>Partner News - Information
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									Du musst alle Felder ausfüllen! <a href="p_news.php?action=create_partnerpm">Zurück!</a>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?
} else {
mysql_query("INSERT INTO p_news (datum, von, titel, text, tracker) Values( Now(), ".sqlesc($username).", ".sqlesc($titel).", ".sqlesc($text).", ".sqlesc($tracker).")") or sqlerr(__FILE__,__LINE__);
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-users'></i>Partner News - Information
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									Du musst alle Felder ausfüllen! <a href="p_news.php">Weiter!</a>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?
}
}
if($action == "edit_partnerpm_do" AND get_user_class() >= UC_MODERATOR) {

$error = 0;
$id = $_GET["id"];
$tracker = $_POST["tracker"];
$titel = $_POST["titel"];
$text = $_POST["text"];

if(empty($tracker) OR empty($titel) OR empty($text)) { $error = 1; }
if($error == 1) {
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-users'></i>Partner News - Information
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									Du musst alle Felder ausfüllen! <a href="p_news.php?action=edit_partnerpm&id=<?=$id?>">Zurück!</a>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?
} else {
mysql_query("UPDATE p_news SET tracker='$tracker', titel='$titel', text='$text' WHERE id = '$id'");
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-users'></i>Partner News - Information
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									Partner News erfolgreich bearbeitet! <a href="p_news.php">Weiter!</a>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?
}
}
if($action == "delete_partnerpm" AND get_user_class() >= UC_MODERATOR) {

$id = $_GET["id"];
mysql_query("DELETE FROM p_news WHERE id = '$id'");
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-users'></i>Partner News - Information
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									Partner News erfolgreich gelöscht! <a href="p_news.php">Weiter!</a>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?
}
x264_footer();
?>