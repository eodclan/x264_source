<?php
// ************************************************************************************//
// * X264 Source
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2015 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//
require_once("include/bittorrent.php");
hit_start();
dbconn();
hit_count();

$agent = $_SERVER['HTTP_USER_AGENT'];

if(preg_match("/MSIE/i",$agent)) 
{
	header('Location: browser.php');
	exit;
}

if ($_POST['take'] == 'yes')
{
if (!mkglobal("username:password:secure_code"))
	die("Hier ist was faul...");

function bark($text = "Entweder ist dein Benutzername oder Passwort oder Secure Code ungültig")
{
  stderr_nologged("Login fehlgeschlagen!", $text);
}

session_start();

$ip   = getip();
$username = htmlentities(strip_tags(trim($_POST['username'])));
$password = htmlentities(strip_tags(trim($_POST['password'])));
$secure_code = htmlentities(strip_tags(trim($_POST['secure_code'])));
$rand = zufalls_string(20);
$hash = SHA512($rand);

$res = mysql_query("SELECT * FROM users WHERE username = " . sqlesc($username) . " AND status = 'confirmed'");
$row = mysql_fetch_assoc($res);

if (!$row)
	bark("Diesen User gibt es nicht");

if ($row['secure_code'] != "")
  {
    if ($row["passhash"] != md5($row["secret"] . $password . $row["secret"]) || $row["secure_code"] != $secure_code)
      bark();
}

if ($secure_code == "" && $row["secure_code"] == "")
        bark("Du musst dein Secure Code bei den Login angeben!");  

if ($row["enabled"] == "no")
	bark("Dieser Account wurde deaktiviert.");

logincookie($row["id"], $row["passhash"]);

$_SESSION[SESSION]       = $row;
$_SESSION[SESSION]["ip"] = $ip;
$GLOBALS["CURUSER"]      = $_SESSION[SESSION];

$CURUSER["last_login"] = date("Y-m-d H:i:s");
$CURUSER["ip"]         = $ip;

set_secure($rand, $hash);

$data["session"]    = $hash;
$data["last_login"] = $CURUSER["last_login"];
$data["ip"]         = $CURUSER["ip"];
$db -> updateRow($data, "users", "id = " . $GLOBALS["CURUSER"]["id"]);

$ua=getBrowser();
$browser= "Browser: ".htmlspecialchars($ua['name'])." ".htmlspecialchars($ua['version']).". Os: " .htmlspecialchars($ua['platform']);

mysql_query("UPDATE users SET browser=' . sqlesc($browser) . ', last_access='" . date("Y-m-d H:i:s") . "', browser='$browser', ip='$ip' WHERE id=" . $row["id"]); // or die(mysql_error());

if (!empty($_POST["returnto"]))
	header("Location: ".$BASEURL.$_POST["returnto"]);
else
	header("Location: $BASEURL/".$GLOBALS['loginreturnto']."");

}

x264_header_nologged("Login");

unset($returnto);
if (!empty($_GET["returnto"])) {
	$returnto = $_GET["returnto"];
	if (!$_GET["nowarn"]) {
	}
}
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Login
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
								<form action='<?php echo secure_login_url($_SERVER['PHP_SELF']); ?>' method='post'>
								<input type='hidden' name='take' value='yes'>
								<div class='input-group mb-1'>
									<span class='btn btn-flat btn-primary'><i class='icon-user'></i>
									</span>
									<input name='username' type='text' required title='Username required' placeholder='Username' class='form-control text-left btn btn-flat btn-primary fc-today-button'>
								</div>

								<div class='input-group mb-1'>
									<span class='btn btn-flat btn-primary'><i class='icon-lock'></i></span>
									<input name='password' type='password' required title='Password required' placeholder='Password' class='form-control text-left btn btn-flat btn-primary fc-today-button'>
								</div>

								<div class='input-group mb-1'>
									<span class='btn btn-flat btn-primary'><i class='icon-lock'></i>
									</span>
									<input name='secure_code' type='secure_code' required title='Secure Code required' placeholder='Secure Code' class='form-control text-left btn btn-flat btn-primary fc-today-button'>
								</div>						

								<input type='submit' class='btn btn-flat btn-primary fc-today-button' value='Sign In'>
								<?
									if (isset($returnto))
										print("<input type=\"hidden\" name=\"returnto\" value=\"" . htmlspecialchars($returnto) . "\" />\n");
								?>	  
								</form>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?	
x264_footer_nologged();
hit_end();
?>