<?php
function sendmail($email,$header,$msg)
{

// initiate smtp object
$mail = new smtp;
// connect to smtp server, write your isp smtp url here the random port is 25
$mail->open($GLOBALS['SMTP_MAILSERVER'], $GLOBALS['SMTP_PORT']);
// Remove // for secure mode
//$mail->start_tls();
// Write your auth stuff here if nott add // before
$mail->auth($GLOBALS['SMTP_USERID'], $GLOBALS['SMTP_PASS']);

// Write your email address here  [email]noreply@gmail.com[/email]
$mail->from($GLOBALS['SMTP_MAIL']);


$mail->to("$email");

$mail->subject("$header");


// E-Mail TExt
$mail->body("$msg");

$mail->send();

$mail->close();  

}

?>