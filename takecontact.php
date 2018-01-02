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
if ($_SERVER["REQUEST_METHOD"] != "POST")
 stderr("Fehler", "<h2><center>Art der Methode</center></h2>");

   dbconn();

    loggedinorreturn();

       $msg = trim($_POST["msg"]);
       $subject = trim($_POST["subject"]);

       if (!$msg)
    stderr("Fehler","<h2><center>Bitte trage etwas als Nachricht ein!");

       if (!$subject)
    stderr("Fehler","<h2><center>Kein Betreff vorhanden!</center></h2>");

     $added = "'" . get_date_time() . "'";
     $userid = $CURUSER['id'];
     $message = sqlesc($msg);
     $subject = sqlesc($subject);

 mysql_query("INSERT INTO staffmessages (sender, added, msg, subject) VALUES($userid, $added, $message, $subject)") or sqlerr(__FILE__, __LINE__);

       if ($_POST["returnto"])
 {
   header("Location: " . $_POST["returnto"]);
   die;
 }

x264_header_nologged("Team PM erfolgreich versendet");

echo"
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Team PM erfolgreich versendet</h1>
	<div class='x264_title_content'>
		<div class='x264_title_div'>Danke für deine Team PM. Wir werden uns bemühen dir schnellstens zu Antworten.</div>
	</div>
</div>
</div>";

x264_footer_nologged();
exit;
?>
