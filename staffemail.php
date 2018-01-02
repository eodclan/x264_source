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
loggedinorreturn();

$action = $_GET['action'];

x264_admin_header("E-Mail versenden");

check_access(UC_MODERATOR);
security_tactics();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
if ($action == 'domail') {

	$to = substr(trim($_POST["to"]), 0, 80);

	$from = substr(trim($_POST["from"]), 0, 80);
	if ($from == "") $from = "Anonym";

	$from_email = substr(trim($_POST["from_email"]), 0, 80);
	if ($from_email == "") $from_email = "webmaster@power-castle.ml";
	if (!strpos($from_email, "@")) stderr("Fehler", "Die angegebene E-Mail-Adresse scheint ungültig zu sein.");

	$from = "$from <$from_email>";

	$subject = substr(trim($_POST["subject"]), 0, 80);
	if ($subject == "") stderr("Fehler", "Du musst einen Betreff eingeben!");
	$subject = "$subject";
	$subjecttext = "Betreff: $subject";
	$subjectfoot = "Bitte denk daran, dass wir dir nicht auf diese E-Mail antworten können.";

	$body = htmlentities(strip_tags(trim($_POST["body"])));
	if ($body == "") stderr("Fehler", "Du musst eine Nachricht eingeben!");

	$message = "Nachricht vom ".$GLOBALS["SITENAME"]." am " . date("Y-m-d H:i:s") . ".\n" .
		"---------------------------------------------------------------------\n\n" .
                "$subjecttext" . "\n" .
		"$body" . "\n" .
		"---------------------------------------------------------------------\n\n" .		
		"$subjectfoot" . "";		
		

	$success = mail($to, $subject, $message, "From: $from");

	if ($success)
		print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Aussen Kontakt - Antworten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									Die E-Mail wurde erfolgreich gesendet.
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
	else
		print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Aussen Kontakt - Antworten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									Die Mail konnte nicht versendet werden. Entweder ist das Mail-System des Servers nicht verfügbar oder nicht korrekt konfiguriert.
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
 }
}

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Aussen Kontakt - Antworten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>";

if ($action == 'send') {
$postid = $_GET["postid"];
mysql_query("UPDATE posts SET answer='yes' WHERE id=$postid AND answer='no'") or sqlerr(__FILE__, __LINE__);

$email = htmlentities(strip_tags(trim($_GET["email"])));

$user = htmlentities(strip_tags(trim($_GET["user"])));

$title = htmlentities(strip_tags(trim($_GET["title"])));

$body["text"] = ("Hallo $user,\n");
}

?>
<form method="post" action="staffemail.php?action=domail">
<input type="hidden" name="from_email" value="<?=$GLOBALS["SITEEMAIL"]?>">
<input type="hidden" name="from" value="<?=$GLOBALS["SITENAME"]?>">

<table align="center" cellpadding="4" cellspacing="1" border="0" width="600" class="tableinborder">
<tr><td class="tableb">E-Mail Adresse</td><td class="tablea"><input type="text" name="to" size="50" value="<?=$email?>"></td></tr>
<tr><td class="tableb">Betreff</td><td class="tablea"><input type="text" name="subject" size="73" value="<?=$title?>"></td></tr>
<tr><td class="tableb">Nachricht</td><td class="tablea"><textarea name=body cols=70 rows=10><?=$body[text]?></textarea></td></tr>
<tr><td class="tableb" colspan="2" style="text-align:center"><input type="submit" value="E-Mail senden" class="btn"></td></tr>
</table></form>

<?php
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
x264_admin_footer();
?>