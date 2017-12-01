<?php

function userlogin()
{
    global $SITE_ONLINE, $mc1, $db;
    unset($GLOBALS["CURUSER"]);

	$user = $_SESSION["userdata"]["username"];
	$sql  = "SELECT * FROM users WHERE username = '" . $user . "' LIMIT 1";
	$row  = mysql_fetch_array($db -> query($sql, FALSE));
	$_SESSION[SESSION] = $row;
	$GLOBALS["CURUSER"]   = $_SESSION[SESSION];	
	$secure = $row["session"];
	
    $dt = TIME_NOW;	
    $ip = getip();
    $nip = ip2long($ip);
    $res = mysql_query("SELECT * FROM bans WHERE $nip >= first AND $nip <= last") or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) > 0) {
        header("HTTP/1.0 403 Forbidden");
        print("<html><body><h1>403 Forbidden</h1>Unauthorized IP address.</body></html>\n");
        die;
    } 
    // Secure System
    if (!$SITE_ONLINE || (!isset($_SESSION[SESSION])))
        return;

    if (isset($_SESSION["userdata"]))
    {
        if (get_secure($secure) == FALSE)
        {
            print("
					<div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-warning'></i> Security Tactics System
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block text-center'>
									Die Sicherheits-Daten sind ung&uuml;ltig...<br>
									Du wirst nun automatisch ausgeloggt...<br>
									Dannach einfach neu einloggen...
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>");
			session_regenerate_id();
			unset($CURUSER);
			unset($GLOBALS['CURUSER']);

			header("Location: logout.php");
			die();
        }
    } else {
        // Session ok, also alles ok beim Einloggen...
        $id = 0 + $_COOKIE["x264_tfid"];
        if (!$id || strlen($_COOKIE["x264_pkey"]) != 32)
            return;
        $res = mysql_query("SELECT * FROM users WHERE id = $id AND enabled='yes' AND status = 'confirmed'"); // or die(mysql_error());
        $row = mysql_fetch_array($res);
        if (!$row)
            return;
        $sec = hash_pad($row["secret"]);
        if ($_COOKIE["x264_pkey"] !== $row["passhash"])
            return;

        $row['ip'] = $ip;
        $GLOBALS["CURUSER"] = $row;
		$GLOBALS["SALTING_REGISTER"] = $row;
        $_SESSION["userdata"] = $row;

        if (isset($_COOKIE["x264_phkey"])) {
            $res = mysql_query("SELECT * FROM `accounts` WHERE `userid`=" . $GLOBALS["CURUSER"]["id"] . " AND `chash`=" . sqlesc($_COOKIE["x264_phkey"]));
            if (mysql_num_rows($res))
                mysql_query("UPDATE `accounts` SET `lastaccess`=NOW() WHERE `userid`=" . $GLOBALS["CURUSER"]["id"]);
            else {
                $res = mysql_query("SELECT * FROM `accounts` WHERE `chash`=" . sqlesc($_COOKIE["x264_phkey"]));
                if (mysql_num_rows($res)) {
                    $data = mysql_fetch_assoc($res);
                    $baduser = $data["baduser"];
                } else {
                    $baduser = 0;
                } 
                mysql_query("INSERT INTO `accounts` (`userid`,`chash`,`lastaccess`,`username`,`email`,`baduser`) VALUES (" . $row["id"] . "," . sqlesc($_COOKIE["x264_phkey"]) . ", NOW(), " . sqlesc($row["username"]) . ", " . sqlesc($row["email"]) . ", " . $baduser . ")");
            } 
        } else {
            $res = mysql_query("SELECT * FROM `accounts` WHERE `userid`=" . $GLOBALS["CURUSER"]["id"]);
            if (mysql_num_rows($res)) {
                mysql_query("UPDATE `accounts` SET `lastaccess`=NOW() WHERE `userid`=" . $GLOBALS["CURUSER"]["id"]);
                $data = mysql_fetch_assoc($res);
                $hash = $data["chash"];
            } else {
                $hash = sha1(md5($row["username"] . mksecret() . $row["username"]));
                mysql_query("INSERT INTO `accounts` (`userid`,`chash`,`lastaccess`,`username`,`email`,`baduser`) VALUES (" . $row["id"] . "," . sqlesc($hash) . ", NOW(), " . sqlesc($row["username"]) . ", " . sqlesc($row["email"]) . ", 0)");
            } 
            setcookie("x264_phkey", sha1($hash), 0x7fffffff, "/");
			setcookie("x264_skey", sha1($id,$passhash), 0x7fffffff, $expires,  "/");
			setcookie("PHPSESSID", sha1(hashit($PHPSESSID)), 0x7fffffff, $expires,  "/");
        } 
    }	

    if ($GLOBALS["CURUSER"]["id"] != 1010) 
        // Letzten Zugriff aktualisieren
        mysql_query("UPDATE users SET last_access='" . date("Y-m-d H:i:s") . "', ip='$ip' WHERE id=" . $GLOBALS["CURUSER"]["id"]); // or die(mysql_error());
    if ($GLOBALS["CURUSER"]["accept_rules"] == "no" && !preg_match("/(takeprofedit|rules|faq|logout|delacct)\\.php$/", $_SERVER["PHP_SELF"])) {
	x264_header_nologged();
	print "
	<div class='x264_wrapper_content_out_mount'>
	<h1 class='x264_im_logo'>So nicht!</h1>
	<div class='x264_title_content'>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Information</div><div class='x264_tfile_add_inc'>Du hast dich leider nicht Regelkonform verhalten, daher wurde dein Account in das Secure System verschoben!</div></div>
	</div>";
	x264_footer_nologged();
	die();
    } 
}
?>