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

$agent = $_SERVER['HTTP_USER_AGENT'];

if(preg_match("/MSIE/i",$agent)) 
{
	header('Location: browser.php');
	exit;
}

session_start();

if ($_POST['take'] == 'yes')
{
hit_start();

$res = mysql_query("SELECT COUNT(*) FROM users") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);
if ($arr[0] >= $GLOBALS["MAX_USERS"])
	stderr_nologged("Fehler", "Sorry, das Benutzerlimit wurde erreicht. Bitte versuche es später erneut.");

if (!mkglobal("wantusername:wantpassword:passagain:email"))
	die();

function bark($msg) {
  x264_header_nologged();
	stderr_nologged("Registrierung fehlgeschlagen!", $msg);
  x264_footer_nologged();
  exit;
}

function validusername($username)
{
	if ($username == "")
	  return false;

	// The following characters are allowed in user names
	$allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

	for ($i = 0; $i < strlen($username); ++$i)
	  if (strpos($allowedchars, $username[$i]) === false)
	    return false;

	return true;
}

function isportopen($port)
{
	global $HTTP_SERVER_VARS;
	$sd = @fsockopen($HTTP_SERVER_VARS["REMOTE_ADDR"], $port, $errno, $errstr, 1);
	if ($sd)
	{
		fclose($sd);
		return true;
	}
	else
		return false;
}

function isproxy()
{
	$ports = array(80, 88, 1075, 1080, 1180, 1182, 2282, 3128, 3332, 5490, 6588, 7033, 7441, 8000, 8080, 8085, 8090, 8095, 8100, 8105, 8110, 8888, 22788);
	for ($i = 0; $i < count($ports); ++$i)
		if (isportopen($ports[$i])) return true;
	return false;
}

session_start();

$wantusername = htmlentities(strip_tags(trim($_POST['wantusername'])));
$wantpassword = htmlentities(strip_tags(trim($_POST['wantpassword'])));
$passagain    = htmlentities(strip_tags(trim($_POST['passagain'])));
$secure_code  = htmlentities(strip_tags(trim($_POST['secure_code'])));
$email        = htmlentities(strip_tags(trim($_POST['email'])));

if ($GLOBALS['proofcodeon'])
if ($_SESSION["proofcode"] == "" || $_POST["proofcode"] == "" || strtolower($_POST["proofcode"]) != strtolower($_SESSION["proofcode"]))
        bark("Der Anmeldungscode ist ungültig.");

if (empty($wantusername) || empty($wantpassword) || empty($email))
	bark("Du musst alle Felder ausfüllen.");

if (strlen($wantusername) > 12)
	bark("Sorry, Dein Benutzername ist zu lang (Maximum sind 12 Zeichen)");

if ($wantpassword != $passagain)
	bark("Die Passwörter stimmen nicht überein! Du musst Dich vertippt haben. bitte versuche es erneut!");

if (strlen($wantpassword) < 6)
	bark("Sorry, Dein Passwort ist zu kurz (Mindestens 6 Zeichen)");

if (strlen($secure_code) < 4)
    bark("Sorry, Dein Secure Code zu gross oder zu klein, max 4 Stellen...)");	

if (strlen($wantpassword) > 40)
	bark("Sorry, Dein Passwort ist zu lang (Maximal 40 Zeichen)");

if ($wantpassword == $wantusername)
	bark("Sorry, Dein Passwort darf nicht mit Deinem Benutzernamen identisch sein.");

if (!validemail($email))
	bark("Die E-Mail Adresse sieht nicht so aus, als ob sie gültig wäre.");

if (!validusername($wantusername))
	bark("Ungültiger Benutzername.");

// check if email addy is already in use
$a = (@mysql_fetch_row(@mysql_query("select count(*) from users where email='$email'"))) or die(mysql_error());
if ($a[0] != 0)
  bark("Die E-Mail Adresse $email wird schon verwendet.");

// Trash-/Freemail Anbieter sind nicht gewünscht.
if ($GLOBALS['emailvalidation'] != "true")
foreach ($GLOBALS["EMAIL_BADWORDS"] as $badword) {
    if (preg_match("/".preg_quote($badword)."/i", $email))
	stderr_nologged("Anmeldung fehlgeschlagen", "Trash-Mails können bei uns nicht benutzt werden!");
}

hit_count();

$secret = mksecret();
$wantpasshash = md5($secret . $wantpassword . $secret);
$editsecret = mksecret();
$passkey = mksecret(8);

$arr = mysql_fetch_assoc(mysql_query("SELECT `id` FROM `design` WHERE `default`='yes'"));
$design = $arr["id"];

if ($GLOBALS['emailvalidation'] != "false")
$status = 'pending';
else
$status = 'confirmed';

$ret = mysql_query("INSERT INTO users (username, passhash, passkey, secret, editsecret, email, status, secure_code, design, added) VALUES (" .
		implode(",", array_map("sqlesc", array($wantusername, $wantpasshash, $passkey, $secret, $editsecret, $email, $status, $secure_code, $design))) .
		",'" . get_date_time() . "')");

if (!$ret) {
	if (mysql_errno() == 1062)
		bark("Der Benutzername existiert bereits!");
	bark("borked");
}

$id = mysql_insert_id();

//write_log("User account $id ($wantusername) was created");

$text = "Herzlich Willkommen bei ".$GLOBALS["SITENAME"]." ".$wantusername."!";
$date = time();
mysql_query("INSERT INTO shoutbox (id, username, date, text) VALUES (NULL, ".sqlesc('Tactics').", ".$date.", ".sqlesc($text).")") or sqlerr(__FILE__, __LINE__);
  
$text1 = "Ein neuer User hat sich registriert: ".$wantusername."!";
$date = time();
mysql_query("INSERT INTO teambox (id, username, date, text) VALUES (NULL, ".sqlesc('Tactics').", ".$date.", ".sqlesc($text1).")") or sqlerr(__FILE__, __LINE__);
  

$psecret = md5($editsecret);

$body = 'Du oder jemand anderes hat auf {'.$GLOBALS["SITENAME"].'} einen neuen Account erstellt und
diese E-Mail Adresse ('.$email.') dafür verwendet.

Wenn Du den Account nicht erstellt hast, ignoriere diese Mail. In diesem
Falle wirst Du von uns keine weiteren Nachrichten mehr erhalten. Die
Person, die Deine E-Mail Adresse benutzt hat, hatte die IP-Adresse
{'.$_SERVER["REMOTE_ADDR"].'}. Bitte antworte nicht auf diese automatisch
erstellte Nachricht

Um die Anmeldung zu bestätigen, folge bitte dem folgenden Link:

'.$DEFAULTBASEURL.'/confirm.php?id='.$id.'&secret='.$psecret.'

Wenn du dies getan hast, wirst Du in der Lage sein, Deinen neuen Account zu
verwenden. Wenn die Aktivierung fehlschlägt, oder Du diese nicht vornimmst,
wird Dein Account innerhalb der nächsten Tage wieder gelöscht.
Wir empfehlen Dir dringlichst, die Regeln und die FAQ zu lesen, bevor Du
unseren Tracker verwendest.';


if ($GLOBALS['emailvalidation'] != "false")
{
sendmail($email, $GLOBALS["SITENAME"]." Anmeldebestätigung", $body);
header("Refresh: 0; url=ok.php?type=signup&email=" . urlencode($email));
}
else
header("Refresh: 0; url=ok.php?type=confirm");
hit_end();
}

if ($_SESSION["proofcode"] != "" && $_POST["proofcode"] != "" && strtolower($_POST["proofcode"]) == strtolower($_SESSION["proofcode"]))
    $code_ok = TRUE;
else
    $code_ok = FALSE;

if ($code_ok || !$GLOBALS['proofcodeon']) {
    $res = mysql_query("SELECT COUNT(*) FROM users") or sqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_row($res);
    if ($arr[0] >= $GLOBALS["MAX_USERS"]) {
            $_SESSION["proofcode"] = "";
            stderr_nologged("Sorry", "Das aktuelle Benutzerlimit wurde erreicht. Inactive Accounts werden regelmäßig gelöscht, versuche es also einfach später nochmal...");
    }
} else {
    /* Zufallsgenerator initialisieren */
    srand(microtime()*360000);
    
    /* Im Code benutzte Zeichen */
    $chars = "0123456789ABCDEFGHIJKLMNOPSTUWXYZ";
    
    /* Zeichenfolge generieren */
    $_SESSION["proofcode"] = "";
    for ($I=0; $I<6; $I++) $_SESSION["proofcode"] .= $chars[rand(0, strlen($chars)-1)];
}

x264_header_nologged("Anmeldung");

if ($success == 'yes')
stdsuccess("Registrieren");

if ($code_ok || $GLOBALS['proofcodeon'] != 'yes') {
echo"	
			<div class='row'>
				<div class='col-lg-12'>
					<div class='card'>
						<div class='card-header'>
							<i class='fa fa-sign-out'></i>Registrieren
							<div class='card-actions'>
								<a href='#' class='btn-close'><i class='icon-close'></i></a>
							</div>
						</div>
						<div class='card-block'>
						<table class='table table-bordered table-striped table-condensed'>
							<thead>
								<tr>
									<td>Dein Secure Code darf nicht mit 0 anfangen!</td>
								</tr>
							</thead>
						</table>				
						<form method='post' action='".$self."' autocomplete='on'>
							<input type='hidden' name='proofcode' value='".$_SESSION['proofcode']."' >
							<input type='hidden' name='take' value='yes'>						
						<div class='input-group mb-1'>
                            <span class='btn btn-flat btn-primary'><i class='icon-user'></i>
                            </span>
                            <input name='wantusername' required='required' type='text' class='form-control text-left btn btn-flat btn-primary fc-today-button' placeholder='Username'>
                        </div>

                        <div class='input-group mb-1'>
                            <span class='btn btn-flat btn-primary'>@</span>
                            <input name='email' required='required' type='text' class='form-control text-left btn btn-flat btn-primary fc-today-button' placeholder='E-Mail'>
                        </div>

                        <div class='input-group mb-1'>
                            <span class='btn btn-flat btn-primary'><i class='icon-lock'></i>
                            </span>
                            <input name='wantpassword' required='required' type='password' class='form-control text-left btn btn-flat btn-primary fc-today-button' placeholder='Password'>
                        </div>

                        <div class='input-group mb-2'>
                            <span class='btn btn-flat btn-primary'><i class='icon-lock'></i>
                            </span>
                            <input name='passagain' required='required' type='password' class='form-control text-left btn btn-flat btn-primary fc-today-button' placeholder='Repeat password'>
                        </div>
						
                        <div class='input-group mb-2'>
                            <span class='btn btn-flat btn-primary'><i class='icon-lock'></i>
                            </span>
                            <input name='secure_code' required='required' maxlength='4' type='secure_code' class='form-control text-left btn btn-flat btn-primary fc-today-button' placeholder='Secure Code'>
                        </div>						

                        <input type='submit' class='btn btn-flat btn-primary fc-today-button' value='Account Erstellen'>
						</form>						
                    </div>
                </div>
            </div>
		</div>";
} else {
echo"	
			<div class='row'>
				<div class='col-lg-12'>
					<div class='card'>
						<div class='card-header'>
							<i class='fa fa-sign-out'></i>Registrieren
							<div class='card-actions'>
								<a href='#' class='btn-close'><i class='icon-close'></i></a>
							</div>
						</div>
						<div class='card-block'>
					<form method='post' action='".$self."' autocomplete='on'>
                        <div class='input-group mb-2'>
                            <img src='proofimg.php?=SID' width='250' height='80' alt='Der Browser muss Grafiken anzeigen können, um die Anmeldung durchzuführen!'>
                        </div>	
                        <div class='input-group mb-2'>
                            <span class='btn btn-flat btn-primary'><i class='icon-lock'></i>
                            </span>
                            <input id='passwordsignup' name='proofcode' required='required' type='text' placeholder='my captcha code' data-icon='x' class='form-control text-left btn btn-flat btn-primary fc-today-button' />
                        </div>

                        <input type='submit' class='btn btn-flat btn-primary fc-today-button' value='Code prüfen'>										
					</form>					
                    </div>
                </div>
            </div>
		</div>";
}
x264_footer_nologged();
?>