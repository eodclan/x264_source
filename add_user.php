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
check_access(UC_ADMINISTRATOR);
security_tactics();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  if ($_POST["username"] == "" || $_POST["password"] == "" || $_POST["email"] == "" || $_POST["secure_code"] == "")
    stderr("Fehler", "Formulardaten unvollständig.");

  if ($_POST["password"] != $_POST["password2"])
    stderr("Fehler", "Passwörter sind nicht identisch.");

  $username = sqlesc($_POST["username"]);
  $password = $_POST["password"];
  $email = sqlesc($_POST["email"]);
  $secure_code = $_POST["secure_code"];
  $secret = mksecret();
  $passkey = sqlesc(mksecret(8));
  $passhash = sqlesc(md5($secret . $password . $secret));
  $secret = sqlesc($secret);
  $res = mysql_query("SELECT `id` FROM `design` WHERE `default`='yes'") or sqlerr(__FILE__, __LINE__);
  $arr = mysql_fetch_assoc($res);
  $design = $arr["id"];

  mysql_query("INSERT INTO users (added, last_access, secret, username, passhash, passkey, status, email, secure_code, design) VALUES(NOW(), NOW(), ".$secret.", ".$username.", ".$passhash.", ".$passkey.", 'confirmed', ".$email.", ".$secure_code.", ".$design.")") or sqlerr(__FILE__, __LINE__);

  header("Location: /userdetails.php?id=".mysql_insert_id());
  die;
}

x264_admin_header("Account erstellen");
?>
<form method="post" action="add_user.php">
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Account Info
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<a href='javascript:void(0)' class='uppercase'>Beachte bitte, dass du dir den User genau vorher ansehen solltest.<br />Der User sollte dir auch ein Screenshot von ein anderen Tracker senden.</a>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>

                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Account Hinzuf&uuml;gen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>			
									<ul class='chart-legend clearfix'>
										<li>Benutzername: <br /><input type="text" name="username" size="40"></li>
										<li>Passwort: <br /><input type="password" name="password" size="40"></li>
										<li>Passwort wdh.: <br /><input type="password" name="password2" size="40"></li>
										<li>Secure Code: <br /><input type="secure_code" name="secure_code" size="40"></li>
										<li>E-Mail: <br /><input type="text" name="email" size="40"></li>
										<li><input type="submit" value="Okay" class="btn"></li>					
									</ul>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</form>
<?
x264_admin_footer();
?>