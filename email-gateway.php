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

$id = intval($_GET["id"]);
if (!$id)
    stdmsg("Fehler", "Ungültige oder Fehlende ID.");

$res = mysql_query("SELECT `username`, `class`, `email`, `accept_email` FROM `users` WHERE `id`=$id");
$arr = mysql_fetch_assoc($res) or stdmsg("Fehler", "Der Benutzer existiert nicht.");

if ($id == $CURUSER["id"])
    stdmsg("Fehler", "Du kannst Dir nicht selber eine E-Mail senden.");

// Moderatoren und höhere User können immer Mails senden und empfangen!
if ($arr["class"] < UC_MODERATOR && $CURUSER["class"] < UC_MODERATOR) {
    if ($arr["accept_email"] ==  "no")
        stdmsg("Fehler", "Dieser Benutzer ist kein Team-Mitglied, und akzeptiert keine E-Mails.");
    
    if ($arr["accept_email"] ==  "friends") {
        $r = mysql_query("SELECT `id` FROM `friends` WHERE `userid`=".$id." AND `friendid`=".$CURUSER["id"]) or sqlerr(__FILE__,__LINE__);
        if (mysql_num_rows($r) == 0)
            stdmsg("Fehler", "Dieser Benutzer ist kein Team-Mitglied, und akzeptiert E-Mails nur von Freunden.");
    }
    
    $r = mysql_query("SELECT `id` FROM `blocks` WHERE `userid`=".$id." AND `blockid`=".$CURUSER["id"]) or sqlerr(__FILE__,__LINE__);
    if (mysql_num_rows($r) > 0)
        stdmsg("Fehler", "Dieser Benutzer ist kein Team-Mitglied, und akzeptiert von Dir keine E-Mails.");
}

x264_header("E-Mail Gateway System");

$username = htmlspecialchars($arr["username"]);

if ($HTTP_SERVER_VARS["REQUEST_METHOD"] == "POST")
{
	$to = $arr["email"];

	$from = substr(trim($_POST["from"]), 0, 80);
	if ($from == "") $from = "Anonym";

	$from_email = substr(trim($_POST["from_email"]), 0, 80);
	if ($from_email == "") $from_email = "noreply@example.com";
	if (!strpos($from_email, "@")) stdmsg("Fehler", "Die angegebene E-Mail-Adresse scheint ungültig zu sein.");

	$from = "$from <$from_email>";

	$subject = substr(trim($_POST["subject"]), 0, 80);
	if ($subject == "") $subject = "(Kein Betreff)";
	$subject = "FW: $subject";

	$message = trim($_POST["message"]);
	if ($message == "") stdmsg("Fehler", "Du musst eine Nachricht eingeben!");

	$message = "Nachricht gesendet von ".$HTTP_SERVER_VARS["REMOTE_ADDR"]." am " . date("Y-m-d H:i:s") . ".\n" .
		"Hinweis: Wenn Du auf diese Nachricht antwortest, gibst Du Deine E-Mail-Adresse preis.\n" .
		"---------------------------------------------------------------------\n\n" .
		$message . "\n\n" .
		"---------------------------------------------------------------------\n".$GLOBALS["SITENAME"]." E-Mail Gateway System\n";

	$success = mail($to, $subject, $message, "From: $from");

	if ($success)
		stdmsg("Erfolg", "Die E-Mail wurde erfolgreich gesendet.");
	else
		stdmsg("Fehler", "Die Mail konnte nicht versendet werden. Entweder ist das Mail-System des Servers nicht verfügbar oder nicht korrekt konfiguriert.");
}
?>
<form method="post" action="email-gateway.php?id=<?=$id?>">
<?
print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Eine E-Mail an ".$username." senden</h1>
	<div class='x264_title_content'>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Dein Name</div><div class='x264_tfile_add_inc'><input type='text' name='from' size='40'></div></div>	
		<div class='x264_title_table'><div class='x264_nologged_inp'>Deine E-Mail</div> <div class='x264_tfile_add_inc'><input type='text' name='from_email' size='40'></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Betreff</div> <div class='x264_tfile_add_inc'><input type='text' name='subject' size='60'></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Nachricht</div> <div class='x264_tfile_add_inc'><input type='text' name='subject' size='60'></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>E-Mail verschicken</div> <div class='x264_tfile_add_inc'><input type='submit' value='E-Mail senden' class='btn'></div></div>
	</div>
</div>
</div>";
?>
</form>
<?
x264_footer();
?>