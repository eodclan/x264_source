<?php
// ************************************************************************************//
// * D€ Source 2017
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 1.7
// * 
// * Copyright (c) 2017 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************// 

// DB and Config Engine
require_once(dirname(__FILE__) . "/db_setup.php");
require_once(dirname(__FILE__) . "/config.php");
require_once(dirname(__FILE__) . "/Classes/MySQL.php");
require_once(dirname(__FILE__) . "/Classes/MemCache.php");

// Global Engine
require_once(dirname(__FILE__) . "/global.php");
require_once(dirname(__FILE__) . "/pmfunctions.php");
require_once(dirname(__FILE__) . "/browser_system.php");

// Clean File Engine
require_once(dirname(__FILE__) . "/Classes/Cleanup.php");

// SMTP Engine
require_once(dirname(__FILE__) . "/SMTP/smtp.lib.php");
require_once(dirname(__FILE__) . "/Classes/Smtp.php");

// Page Engine
require_once(dirname(__FILE__) . "/Classes/Userlogin.php");
require_once(dirname(__FILE__) . "/Classes/Pager.php");
require_once(dirname(__FILE__) . "/Lottery.class.php");
require_once(dirname(__FILE__) . "/Classes/Shoutcast_inc.php");

// Secure Engine
require_once(dirname(__FILE__) . "/ctracker.php");
require_once(dirname(__FILE__) . "/security_tactics_system.php");
require_once(dirname(__FILE__) . "/Classes/Sha512.php");

// Session Secure name
define(SESSION, "security");

function local_user()
{
    global $_SERVER;
 
    return $_SERVER["SERVER_ADDR"] == $_SERVER["REMOTE_ADDR"];
}

$db = new MySQL();
$mc1 = NEW CACHE();  

function stdsuccess($text = "Aktion erfolgreich")
{
	include("".$GLOBALS["TEMPLATES_SYSTEM"]. "x264_stdsuccess.php");
}

//The New validip Function
function validip($ip='', $ip_type=''){

    $validip=false;

    if($ip_type=='ipv4'){

        //validates IPV4
        $validip = filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV4);
    }
    elseif($ip_type=='ipv6'){

        //validates IPV6
        $validip = filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV6);
    }
    else{

        //validates IPV4 and IPV6
        $validip = filter_var($ip, FILTER_VALIDATE_IP);
    }

    if($isValid == $ip){

        $validip=true;
    }

    return $validip;
}

function dbconn($autoclean = false)
{
  define_user_class();
  userlogin();
  ctracker();
  set_smilies();
	if ($autoclean)
        register_shutdown_function("autoclean");
}

function newmsg($heading = '', $text = '', $div = 'success', $htmlstrip = false)
{
    if ($htmlstrip) {
        $heading = htmlspecialchars(trim($heading));
        $text = htmlspecialchars(trim($text));
    }
    $htmlout='';
    $htmlout.="<table class=\"main\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td class=\"embedded\">\n";
    $htmlout.="<div class=\"$div\">" . ($heading ? "<b>$heading</b><br />" : "") . "$text</div></td></tr></table>\n";
    return $htmlout;
}
function newerr($heading = '', $text = '', $die = true, $div = 'error', $htmlstrip = false)
{
    $htmlout='';
    $htmlout.= newmsg($heading, $text, $div, $htmlstrip);
    print x264_header() .$htmlout . x264_footer();
    if ($die)
    die;
}
function datetimetransform($input) // OUTPUTS SERVERTIME REPLACE THIS FUNCTION IF YOU HAVE USER DEFINED TIMEZONES
{
    $todayh = getdate($input);
    if ($todayh["seconds"] < 10) {
        $todayh["seconds"] = "0" . $todayh["seconds"] . "";
    }
    if ($todayh["minutes"] < 10) {
        $todayh["minutes"] = "0" . $todayh["minutes"] . "";
    }
    if ($todayh["hours"] < 10) {
        $todayh["hours"] = "0" . $todayh["hours"] . "";
    }
    if ($todayh["mday"] < 10) {
        $todayh["mday"] = "0" . $todayh["mday"] . "";
    }
    if ($todayh["mon"] < 10) {
        $todayh["mon"] = "0" . $todayh["mon"] . "";
    }
    $sec = $todayh['seconds'];
    $min = $todayh['minutes'];
    $hours = $todayh['hours'];
    $d = $todayh['mday'];
    $m = $todayh['mon'];
    $y = $todayh['year'];
    $input = "$d-$m-$y $hours:$min:$sec";
    return $input;
}

function set_smilies()
{
  global $privatesmilies;
  global $smilies;

  $smilies        = array();
  $privatesmilies = array();

  $sql = "SELECT code, path, private FROM smilies WHERE active = 'yes' ORDER BY id ASC";
  $res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
  while ($arr = mysql_fetch_array($res))
  {
    $key = trim($arr["code"]);
    $smilies[$key] = trim($arr["path"]);
    if ($arr["private"] == "yes") $privatesmilies[$key] = trim($arr["path"]);
  }
} 
 
// Php 6 Specialchars
function htmlsafechars($txt = '')
{
    $txt = preg_replace("/&(?!#[0-9]+;)(?:amp;)?/s", '&amp;', $txt);
    $txt = str_replace(array(
        "<",
        ">",
        '"',
        "'"
    ) , array(
        "&lt;",
        "&gt;",
        "&quot;",
        '&#039;'
    ) , $txt);
    return $txt;
}

// PHP 5 & PHP 7 REAL IP
function getip()
{
    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $ip = getenv('REMOTE_ADDR');
        }
    }

    return $ip;
} 

function trim_it($name, $count){
	$name2=strlen($name);
	$name0=$name;
	$name=substr($name, 0, $count) . "...";
	if($name2 > $count)
		return $name;
	else return $name0;
}


function makehours($date)  // by Solstice
{
$arr1 = explode(" ","$date");
$timebig = explode("-","$arr1[0]");
$timetiny = explode(":","$arr1[1]");
$yearreg = $timebig[0];
$monthreg = $timebig[1];
$dayreg = $timebig[2];
$hourreg = $timetiny[0];


$hours = ( ($yearreg*365*24)+($monthreg*30*24)+($dayreg*24)+$hourreg );

return $hours;
}

function bb_err($type)
{
$error[0] = true;
$error[1] = $type;
return $error;
}

function get_secure($hash = "")
{
  global $CURUSER, $db;

  if ($hash != "")
  {
     $query = "SELECT users_secure, hash FROM users_secure WHERE hash = '" . trim($hash) . "' AND id = " . intval($CURUSER["id"]) . " LIMIT 1";
     $data  = mysql_fetch_array($db -> query($query, FALSE));

     $kontrolle = SHA512(trim($data["users_secure"]));
     $read_hash = trim($data["hash"]);

     if ($kontrolle == $read_hash) return TRUE;
     else return FALSE;
  }
  else
    return FALSE;
}

function set_secure($secure = "", $hash = "")
{
  global $CURUSER, $db;

  $data = array();

  if((trim($secure) != "") && (trim($hash) != "") && $CURUSER)
  {
     $sql = "SELECT * FROM users_secure WHERE id = " . intval($CURUSER["id"]);
     $res = $db -> query($sql);

     if (mysql_num_rows($res) > 0)
     {
        $data["users_secure"] = trim($secure);
        $data["hash"]   = trim($hash);
        $cond           = "id = " . intval($CURUSER["id"]);
        $db -> updateRow($data, "users_secure", $cond);
     }
     else
     {
        $data["users_secure"] = trim($secure);
        $data["hash"]   = trim($hash);
        $data["id"]     = intval($CURUSER["id"]);

        $db -> insertRow($data, "users_secure");
     }

     return TRUE;
  }
  else
    return FALSE;
}

function zufalls_string ($max = 8)
{
    srand ((double)microtime()*1000000);
    $zufall = rand();
    $max    = intval($max);

    $return = substr(md5($zufall) , 0 , $max);

    return $return;
}

function begin_session()
{
	session_regenerate_id();
	$_SESSION['valid'] = 1;
	$_SESSION['PHPSESSID'] = crypt(sha1(md5(md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']))));
}

function phpsessid_secure($salting)
{
	$GLOBALS["SALTING_REGISTER"] = $salting;
	
	$currentCookieParams = session_get_cookie_params();  
    $sidvalue = session_id();  
    setcookie(  
		'PHPSESSID',//name
		'x264_tfid',//name
		'x264_pkey',//name
		'x264_phkey',//name			
		'x264_skey',//name			
		$sidvalue,//value  
		0,//expires at end of session  
		$currentCookieParams['path'],//path  
		$currentCookieParams['domain'],//domain  
		true //secure  
	);  
	
	 // Prevents javascript XSS attacks aimed to steal the session ID
	ini_set('session.cookie_httponly', 1);

	// **PREVENTING SESSION FIXATION**
	// Session ID cannot be passed through URLs
	ini_set('session.use_only_cookies', 1);

	// Uses a secure connection (HTTPS) if possible
	ini_set('session.cookie_secure', 1);
}

function secure_login_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        return '';
    } else {
        return $url;
    }
}

function hashit($var,$addtext="",$addsecure="02fb9ff482dfb6d9baf1a56b6d1f1703f643eeb1204b3012391f8ee63bfe4f4e")
{
    return sha1(sha1(sha1(sha1(sha1(sha1(md5("X264 Source ".$addtext.$var.$addtext."".$addsecure." is the best recoded Source from 2015....")))))));
}

function saltPassword($password, $salt)
{
     return hash('sha256', $password . $salt);
} 

function logincookie($id, $passhash, $salting, $PHPSESSID, $updatedb = 1, $expires = 0x7fffffff)
{
    global $db;
	
	$expires = time() + 42000;

	@session_cache_expire (30);
	@set_time_limit (0);
	@set_magic_quotes_runtime (0);

	phpsessid_secure($salting);
		
	setcookie("x264_tfid", $id, $expires,  "/");
	setcookie("x264_pkey", $passhash, $expires, "/");
	setcookie("PHPSESSID", hashit($PHPSESSID), $expires,  "/");	
	setcookie("x264_skey", hashit($id,$passhash), $expires,  "/");	

    if ($updatedb)
        mysql_query("UPDATE users SET last_login = NOW() WHERE id = $id");
} 

function logoutcookie()
{
    global $CURUSER, $db;

    $data = array();
    $data["session"] = "";
    $db -> updateRow($data, "users", "id = " . $CURUSER["id"]);

    $data = array();
    $data["users_secure"] = "";
    $data["hash"]   = "";
    $db -> updateRow($data, "users_secure", "id = " . $CURUSER["id"]);

	setcookie("x264_tfid", "", 0x7fffffff,  "/");
	setcookie("x264_pkey", "", 0x7fffffff,  "/");
	setcookie("x264_skey", "", 0x7fffffff,  "/");
	setcookie("x264_phkey", "", 0x7fffffff,  "/");
	setcookie("x264_skeyc", "", 0x7fffffff,  "/");
	setcookie("PHPSESSID", "", 0x7fffffff,  "/");		
	
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000, $params["path"],
        $params["domain"], $params["secure"], $params["httponly"]
		);
	} 	
	
    session_unset();
    session_destroy();
} 

function loggedinorreturn()
{
  global $CURUSER, $DEFAULTBASEURL;
  if (!$CURUSER)
  {
    header("Location: /login.php#tologin");
    exit();
  }
}

function autoclean()
{
    $now = time();
    $docleanup = 0;

    $res = mysql_query("SELECT value_u FROM avps WHERE arg = 'lastcleantime'");
    $row = mysql_fetch_array($res);
    if (!$row) {
        mysql_query("INSERT INTO avps (arg, value_u) VALUES ('lastcleantime',$now)");
        return;
    } 
    $ts = $row[0];
    if ($ts + $GLOBALS["AUTOCLEAN_INTERVAL"] > $now)
        return;
    mysql_query("UPDATE avps SET value_u=$now WHERE arg='lastcleantime' AND value_u = $ts");
    if (!mysql_affected_rows())
        return;

    docleanup();
} 

function unesc($x)
{
    if (get_magic_quotes_gpc())
        return stripslashes($x);
    return $x;
} 

function mksize($bytes)
{
    if ($bytes < 1000 * 1024)
        return number_format($bytes / 1024, 2, ",", ".") . " KB";
    elseif ($bytes < 1000 * 1048576)
        return number_format($bytes / 1048576, 2, ",", ".") . " MB";
    elseif ($bytes < 1000 * 1073741824)
        return number_format($bytes / 1073741824, 2, ",", ".") . " GB";
    elseif ($bytes < 1000 * 1099511627776)
        return number_format($bytes / 1099511627776, 2, ",", ".") . " TB";
    else
        return number_format($bytes / 1125899906842624, 2, ",", ".") . " PB";
} 

function mksizeint($bytes)
{
    $bytes = max(0, $bytes);
    if ($bytes < 1000)
        return number_format(floor($bytes), 0, ",", ".") . " B";
    elseif ($bytes < 1000 * 1024)
        return number_format(floor($bytes / 1024), 0, ",", ".") . " KB";
    elseif ($bytes < 1000 * 1048576)
        return number_format(floor($bytes / 1048576), 0, ",", ".") . " MB";
    elseif ($bytes < 1000 * 1073741824)
        return number_format(floor($bytes / 1073741824), 0, ",", ".") . " GB";
    elseif ($bytes < 1000 * 1099511627776)
        return number_format(floor($bytes / 1099511627776), 0, ",", ".") . " TB";
    else
        return number_format(floor($bytes / 1125899906842624), 0, ",", ".") . " PB";
} 

function deadtime()
{
    return time() - floor($GLOBALS["ANNOUNCE_INTERVAL"] * 1.3);
} 

function mkprettytime($s)
{
    if ($s < 0)
        $s = 0;
    $t = array();
    foreach (array("60:sec", "60:min", "24:hour", "0:day") as $x) {
        $y = explode(":", $x);
        if ($y[0] > 1) {
            $v = $s % $y[0];
            $s = floor($s / $y[0]);
        } else
            $v = $s;
        $t[$y[1]] = $v;
    } 

    if ($t["day"])
        return $t["day"] . "d " . sprintf("%02d:%02d:%02d", $t["hour"], $t["min"], $t["sec"]);
    if ($t["hour"])
        return sprintf("%d:%02d:%02d", $t["hour"], $t["min"], $t["sec"]); 
    // if ($t["min"])
    return sprintf("%d:%02d", $t["min"], $t["sec"]); 
    // return $t["sec"] . " secs";
} 

function mkglobal($vars)
{
    if (!is_array($vars))
        $vars = explode(":", $vars);
    foreach ($vars as $v) {
        if (isset($_GET[$v]))
            $GLOBALS[$v] = unesc($_GET[$v]);
        elseif (isset($_POST[$v]))
            $GLOBALS[$v] = unesc($_POST[$v]);
        else
            return 0;
    } 
    return 1;
} 

function tr($x, $y, $noesc = 0)
{
    if ($noesc)
        $a = $y;
    else {
        $a = htmlspecialchars($y);
        $a = str_replace("\n", "<br>\n", $a);
    } 
    print("<tr><td class=\"tableb\" valign=\"top\" align=\"left\">$x</td><td class=\"tablea\" valign=\"top\" align=left>$a</td></tr>\n");
}

function validfilename($name)
{
    return preg_match('/^[^\\0-\\x1f:\\\\\\/?*\\xff#<>|]+$/si', $name);
} 

function validemail($email)
{
    return preg_match('/^[\w.-]+@([\w.-]+\.)+[a-z]{2,6}$/is', $email);
} 

function sqlesc($x)
{
    return "'" . mysql_real_escape_string($x) . "'";
} 

function sqlwildcardesc($x)
{
    return str_replace(array("%", "_"), array("\\%", "\\_"), mysql_real_escape_string($x));
} 

function urlparse($m)
{
    $t = $m[0];
    if (preg_match(',^\w+://,', $t))
        return "<a href=\"$t\">$t</a>";
    return "<a href=\"http://$t\">$t</a>";
} 

function parsedescr($d, $html)
{
    if (!$html) {
        $d = htmlspecialchars($d);
        $d = str_replace("\n", "\n<br>", $d);
    } 
    return $d;
} 

function ratiostatbox()
{
    global $CURUSER;

    if ($CURUSER) {
        $ratio = ($CURUSER["downloaded"] > 0?number_format($CURUSER["uploaded"] / $CURUSER["downloaded"], 3, ",", "."):"Inf.");
        $seedsarr = @mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `cnt` FROM `peers` WHERE `userid`=" . $CURUSER["id"] . " AND `seeder`='yes'"));
        $seeds = $seedsarr["cnt"];
        $leechesarr = @mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `cnt` FROM `peers` WHERE `userid`=" . $CURUSER["id"] . " AND `seeder`='no'"));
        $leeches = $leechesarr["cnt"];
        $tlimits = get_torrent_limits($CURUSER);

        if ($ratio < 0.5) {
            $ratiowarn = " style=\"background-color:red;color:white;\"";
        } elseif ($ratio < 0.75) {
            $ratiowarn = " style=\"background-color:#FFFF00;color:black;\"";
        } 

        if ($tlimits["seeds"] >= 0) {
            if ($tlimits["seeds"] - $seeds < 1)
                $seedwarn = " style=\"background-color:red;color:white;\"";
            $tlimits["seeds"] = " / " . $tlimits["seeds"];
        } else
            $tlimits["seeds"] = "";
        if ($tlimits["leeches"] >= 0) {
            if ($tlimits["leeches"] - $leeches < 1)
                $leechwarn = " style=\"background-color:red;color:white;\"";
            $tlimits["leeches"] = " / " . $tlimits["leeches"];
        } else
            $tlimits["leeches"] = "";
        if ($tlimits["total"] >= 0) {
            if ($tlimits["total"] - $leeches + $seeds < 1)
                $totalwarn = " style=\"background-color:red;color:white;\"";
            $tlimits["total"] = " / " . $tlimits["total"];
        } else
            $tlimits["total"] = "";

	include("".$GLOBALS["TEMPLATES_SYSTEM"]. "x264_ratiostatbox.php");
	} 
} 

// Design System
function x264_header($title = "", $msgalert = true)
{

  global $CURUSER, $_SERVER, $PHP_SELF, $db, $mc1;

    if (!$GLOBALS["SITE_ONLINE"])
	die("Die Seite ist momentan aufgrund von Wartungsarbeiten nicht verfügbar.<br>");

    if ($_COOKIE['x264_skeyc'] != "dccc6c1fa2b15e4523ac10bc21bea12187eebb682c0425357e9043825c3af4c7")
	header("LOCATION: /sessioncheck.php");

    header("Content-Type: text/html; charset=iso-8859-1");
    header("Pragma: No-cache");
    header("Expires: 300");
    header("Cache-Control: private");

    if ($title == "")
        $title = $GLOBALS["SITENAME"];
    else
        $title = $GLOBALS["SITENAME"] . " :: " . htmlspecialchars($title);

    if ($CURUSER) {
        $ss_a = @mysql_fetch_assoc(@mysql_query("SELECT `uri` FROM `design` WHERE `id`=" . $CURUSER["design"]));
        if ($ss_a) $GLOBALS["ss_uri"] = $ss_a["uri"];
    } 

    if (!$GLOBALS["ss_uri"]) {
        ($r = mysql_query("SELECT `uri` FROM `design` WHERE `default`='yes'")) or die(mysql_error());
        ($a = mysql_fetch_assoc($r)) or die(mysql_error());
        $GLOBALS["ss_uri"] = $a["uri"];
    }

    if ($msgalert && $CURUSER) {
        $res = mysql_query("SELECT COUNT(*) FROM `messages` WHERE `folder_in`<>0 AND `receiver`=" . $CURUSER["id"] . " && `unread`='yes'") or die("OopppsY!");
        $arr = mysql_fetch_row($res);
        $unread = $arr[0];
        if ($CURUSER["class"] >= UC_MODERATOR) {
            $res = mysql_query("SELECT COUNT(*) FROM `messages` WHERE `sender`=0 AND `receiver`=0 && `mod_flag`='open'") or die("OopppsY!");
            $arr = mysql_fetch_row($res);
            $unread_mod = $arr[0];
        } 
    }

    ctracker();
    ini_set('session.use_only_cookies', 1);
	
    include("".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/templates/ex1080_header.php");
	
    if ($CURUSER)
    {
	include("".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/templates/ex1080_tnavi.php");
	include("".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/templates/ex1080_content.php"); 
    }
}

// Admin Bootstrap Design System
function x264_bootstrap_header($title = "", $msgalert = true)
{

  global $CURUSER, $_SERVER, $PHP_SELF, $db, $mc1;

    if (!$GLOBALS["SITE_ONLINE"])
	die("Die Seite ist momentan aufgrund von Wartungsarbeiten nicht verfügbar.<br>");

    header("Content-Type: text/html; charset=iso-8859-1");
    header("Pragma: No-cache");
    header("Expires: 300");
    header("Cache-Control: private");

    if ($title == "")
        $title = $GLOBALS["SITENAME"];
    else
        $title = $GLOBALS["SITENAME"] . " :: " . htmlspecialchars($title);

    if (get_user_class() >= UC_PARTNER) {
        $ss_a = @mysql_fetch_assoc(@mysql_query("SELECT `uri` FROM `bootstrap_design` WHERE `id`=" . $CURUSER["bootstrap_design"]));
        if ($ss_a) $GLOBALS["ss_uri"] = $ss_a["uri"];
    } 

    if (!$GLOBALS["ss_uri"]) {
        ($r = mysql_query("SELECT `uri` FROM `bootstrap_design` WHERE `default`='yes'")) or die(mysql_error());
        ($a = mysql_fetch_assoc($r)) or die(mysql_error());
        $GLOBALS["ss_uri"] = $a["uri"];
    }

    if ($msgalert && $CURUSER) {
        $res = mysql_query("SELECT COUNT(*) FROM `messages` WHERE `folder_in`<>0 AND `receiver`=" . $CURUSER["id"] . " && `unread`='yes'") or die("OopppsY!");
        $arr = mysql_fetch_row($res);
        $unread = $arr[0];
        if ($CURUSER["class"] >= UC_MODERATOR) {
            $res = mysql_query("SELECT COUNT(*) FROM `messages` WHERE `sender`=0 AND `receiver`=0 && `mod_flag`='open'") or die("OopppsY!");
            $arr = mysql_fetch_row($res);
            $unread_mod = $arr[0];
        } 
    }

    ctracker();
    ini_set('session.use_only_cookies', 1);

    include("".$GLOBALS["ADMIN_BOOTSTRAP_PATTERN"]."".$GLOBALS["ss_uri"]. "/templates/ex1080_header.php");
	
    if (get_user_class() >= UC_PARTNER) {
	include("".$GLOBALS["ADMIN_BOOTSTRAP_PATTERN"]."".$GLOBALS["ss_uri"]. "/templates/ex1080_mnavi.php");
	include("".$GLOBALS["ADMIN_BOOTSTRAP_PATTERN"]."".$GLOBALS["ss_uri"]. "/templates/ex1080_content.php"); 
    }
}

function x264_header_nologged($title = "", $msgalert = true)
{
    global $CURUSER, $_SERVER, $PHP_SELF, $db, $mc1;

    if (!$GLOBALS["SITE_ONLINE"])
	die("Die Seite ist momentan aufgrund von Wartungsarbeiten nicht verfügbar.<br>");

    if ($_COOKIE['x264_skeyc'] != "dccc6c1fa2b15e4523ac10bc21bea12187eebb682c0425357e9043825c3af4c7")
	header("LOCATION: /sessioncheck.php");

    header("Content-Type: text/html; charset=iso-8859-1");
    header("Pragma: No-cache");
    header("Expires: 300");
    header("Cache-Control: private");

    if ($title == "")
        $title = $GLOBALS["SITENAME"];
    else
        $title = $GLOBALS["SITENAME"] . " :: " . htmlspecialchars($title);

    if ($CURUSER)
    {
	$ss_a = @mysql_fetch_assoc(@mysql_query("SELECT `uri` FROM `design` WHERE `id`=" . $CURUSER["design"]));
	if ($ss_a) $GLOBALS["ss_uri"] = $ss_a["uri"];
    }
    $GLOBALS["ss_uri"] = $row["uri"];
    if (!$GLOBALS["ss_uri"])
    {
	$r = mysql_query("SELECT `uri` FROM `design` WHERE `default`='yes'") or sqlerr(__FILE__, __LINE__);
	$a = mysql_fetch_assoc($r);
	$GLOBALS["ss_uri"] = $a["uri"];
    }

    if ($msgalert && $CURUSER) {
        $res = mysql_query("SELECT COUNT(*) FROM `messages` WHERE `folder_in`<>0 AND `receiver`=" . $CURUSER["id"] . " && `unread`='yes'") or die("OopppsY!");
        $arr = mysql_fetch_row($res);
        $unread = $arr[0];
        if ($CURUSER["class"] >= UC_MODERATOR) {
            $res = mysql_query("SELECT COUNT(*) FROM `messages` WHERE `sender`=0 AND `receiver`=0 && `mod_flag`='open'") or die("OopppsY!");
            $arr = mysql_fetch_row($res);
            $unread_mod = $arr[0];
        } 
    }
	ctracker();
	include("".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/templates/ex1080_header_nologged.php");
	include("".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/templates/ex1080_tnavi_nologged.php"); 	
	include("".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/templates/ex1080_content_nologged.php");
 
}

// Design System
function x264_errormsg_header($title = "", $msgalert = true)
{

  global $CURUSER, $_SERVER, $PHP_SELF, $db, $mc1;

    if (!$GLOBALS["SITE_ONLINE"])
	die("Die Seite ist momentan aufgrund von Wartungsarbeiten nicht verfügbar.<br>");

    if ($_COOKIE['x264_skeyc'] != "dccc6c1fa2b15e4523ac10bc21bea12187eebb682c0425357e9043825c3af4c7")
	header("LOCATION: /sessioncheck.php");

    header("Content-Type: text/html; charset=iso-8859-1");
    header("Pragma: No-cache");
    header("Expires: 300");
    header("Cache-Control: private");

    if ($title == "")
        $title = $GLOBALS["SITENAME"];
    else
        $title = $GLOBALS["SITENAME"] . " :: " . htmlspecialchars($title);

    if ($CURUSER) {
        $ss_a = @mysql_fetch_assoc(@mysql_query("SELECT `uri` FROM `design` WHERE `id`=" . $CURUSER["design"]));
        if ($ss_a) $GLOBALS["ss_uri"] = $ss_a["uri"];
    } 

    if (!$GLOBALS["ss_uri"]) {
        ($r = mysql_query("SELECT `uri` FROM `design` WHERE `default`='yes'")) or die(mysql_error());
        ($a = mysql_fetch_assoc($r)) or die(mysql_error());
        $GLOBALS["ss_uri"] = $a["uri"];
    }

    if ($msgalert && $CURUSER) {
        $res = mysql_query("SELECT COUNT(*) FROM `messages` WHERE `folder_in`<>0 AND `receiver`=" . $CURUSER["id"] . " && `unread`='yes'") or die("OopppsY!");
        $arr = mysql_fetch_row($res);
        $unread = $arr[0];
        if ($CURUSER["class"] >= UC_MODERATOR) {
            $res = mysql_query("SELECT COUNT(*) FROM `messages` WHERE `sender`=0 AND `receiver`=0 && `mod_flag`='open'") or die("OopppsY!");
            $arr = mysql_fetch_row($res);
            $unread_mod = $arr[0];
        } 
    }

    ctracker();
    ini_set('session.use_only_cookies', 1);
	
    include("".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/templates/ex1080_errormsg_header.php");
    include("".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/templates/ex1080_errormsg_tnavi.php");
    include("".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/templates/ex1080_errormsg_content.php"); 

}

function x264_footer()
{
    global $CURUSER, $_SERVER, $RUNTIME_START;
    $query = mysql_query("SELECT COUNT(*) AS attacks FROM sitelog WHERE typ = 'ctracker'") or sqlerr();
    $row   = mysql_fetch_array($query);

    include("".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/templates/ex1080_footer.php");
}

function x264_bootstrap_footer()
{
    global $CURUSER, $_SERVER, $RUNTIME_START;
    $query = mysql_query("SELECT COUNT(*) AS attacks FROM sitelog WHERE typ = 'ctracker'") or sqlerr();
    $row   = mysql_fetch_array($query);

    include("".$GLOBALS["ADMIN_BOOTSTRAP_PATTERN"]."".$GLOBALS["ss_uri"]. "/templates/ex1080_footer.php");
}

function x264_errormsg_footer()
{
    global $CURUSER, $_SERVER, $RUNTIME_START;
    $query = mysql_query("SELECT COUNT(*) AS attacks FROM sitelog WHERE typ = 'ctracker'") or sqlerr();
    $row   = mysql_fetch_array($query);

    include("".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/templates/ex1080_errormsg_footer.php");
}

function x264_footer_nologged()
{
    global $CURUSER, $_SERVER, $RUNTIME_START;
    $query = mysql_query("SELECT COUNT(*) AS attacks FROM sitelog WHERE typ = 'ctracker'") or sqlerr();
    $row   = mysql_fetch_array($query);
	
    include("".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/templates/ex1080_footer_nologged.php");	
}

function x264_div_pretime($x, $y, $noesc = 0)
{
  if ($noesc)
    $a = $y;
  else
  {
    $a = htmlspecialchars($y);
    $a = str_replace("\n", "<br>\n", $a);
  }
  print "<div class='x264_title_table'><h1 class='x264_im_logo'>".$x."".$a."</h1></div>\n";
} 

function genbark($x, $y)
{
    x264_header($y);
	include("".$GLOBALS["TEMPLATES_SYSTEM"]. "x264_genbark.php");
    x264_footer();
    exit();
} 

function httperr($code = 404)
{
    include("system.php");
    exit();
} 

function gmtime()
{
    return strtotime(get_date_time());
} 

function deletetorrent($id, $owner = 0, $comment = "")
{
    global $CURUSER;

    $torrent = mysql_fetch_assoc(mysql_query("SELECT name,numpics FROM torrents WHERE id = $id")); 
    // Delete pictures associated with torrent
    if ($torrent["numpics"] > 0) {
        for ($I = 1; $I <= $torrent["numpics"]; $I++) {
            @unlink($GLOBALS["BITBUCKET_DIR"] . "/t-$id-$I.jpg");
            @unlink($GLOBALS["BITBUCKET_DIR"] . "/f-$id-$I.jpg");
        } 
    } 
    // Delete NFO image
    @unlink($GLOBALS["BITBUCKET_DIR"] . "/nfo-$id.png");
    mysql_query("DELETE FROM torrents WHERE id = $id");
    mysql_query("DELETE FROM traffic WHERE torrentid = $id");
    foreach(explode(".", "peers.files.comments.ratings.nowait") as $x)
    mysql_query("DELETE FROM $x WHERE torrent = $id");
    @unlink($GLOBALS["TORRENT_DIR"] . "/$id.torrent"); 
    // Send notification to owner if someone else deleted the torrent
    if ($CURUSER && $owner > 0 && $CURUSER["id"] != $owner) {
        $msg = sqlesc("Dein Torrent '$torrent[name]' wurde von [url=$DEFAULTBASEURL/userdetails.php?id=" . $CURUSER["id"] . "]" . $CURUSER["username"] . "[/url] gelï¿½t.\n\n[b]Grund:[/b]\n" . $comment);
        sendPersonalMessage(0, $owner, "Einer Deiner Torrents wurde gelï¿½t", $msg, PM_FOLDERID_SYSTEM, 0);
    } 
}

function commenttable($rows)
{
    global $CURUSER, $HTTP_SERVER_VARS;

    $count = 0;
    foreach ($rows as $row) {
        begin_table(true);
        print("<colgroup><col width=\"150\"><col width=\"600\"></colgroup>\n");
        print("<tr><td colspan=\"2\" class=\"tablecat\">#" . $row["id"] . " by ");
        if (isset($row["username"])) {
            $title = $row["title"];
            if ($title == "")
                $title = get_user_class_name($row["class"]);
            else
                $title = htmlspecialchars($title);
            print("<a name=\"comm" . $row["id"] . "\" href=\"userdetails.php?id=" . $row["user"] . "\"><b>" .
                htmlspecialchars($row["username"]) . "</b></a>" . get_user_icons(array("donor" => $row["donor"], "enabled" => $row["enabled"], "warned" => $row["warned"])) . " ($title)\n");
        } else
            print("<a name=\"comm" . $row["id"] . "\"><i>(Gelï¿½t)</i></a>\n");

        print(" am " . $row["added"] .
            ($row["user"] == $CURUSER["id"] || get_user_class() >= UC_MODERATOR ? " - [<a href=\"comment.php?action=edit&amp;cid=$row[id]\">Bearbeiten</a>]" : "") .
            (get_user_class() >= UC_MODERATOR ? " - [<a href=\"comment.php?action=delete&amp;cid=$row[id]\">Lï¿½en</a>]" : "") .
            ($row["editedby"] && get_user_class() >= UC_MODERATOR ? " - [<a href=\"comment.php?action=vieworiginal&amp;cid=$row[id]\">Original anzeigen</a>]" : "") . "</td></tr>\n");
        $avatar = ($CURUSER["avatars"] == "yes" ? htmlspecialchars($row["avatar"]) : "");
        if (!$avatar)
            $avatar = $GLOBALS["PIC_BASE_URL"] . "default_avatar.gif";
        $text = stripslashes(format_comment($row["text"]));
        if ($row["editedby"])
            $text .= "<p><font size=\"1\" class=\"small\">Zuletzt von <a href=\"userdetails.php?id=".$row["editedby"]."\"><b>".$row["username"]."</b></a> am ".$row["editedat"]." bearbeitet</font></p>\n";
print(" <tr valign=\"top\">\n
        <td class=\"tableb\" align=\"center\" style=\"padding: 0px;width: 150px\"><img width=\"150\" src=\"".$avatar."\" alt=\"Avatar von ".$row["username"]."\"></td>\n
        p<td class=\"tablea\">".$text."</td>\n
        </tr>\n
     ");
        end_table();
    } 
} 

function searchfield($s)
{
    return preg_replace(array('/[^a-z0-9]/si', '/^\s*/s', '/\s*$/s', '/\s+/s'), array(" ", "", "", " "), $s);
} 

function genrelist()
{
    $ret = array();
    $res = mysql_query("SELECT id, name FROM categories ORDER BY name");
    while ($row = mysql_fetch_array($res))
    $ret[] = $row;
    return $ret;
} 

function linkcolor($num)
{
    if ($num == 0)
        return "red";
    return "black";
} 

function ratingpic($num)
{
    $r = round($num * 2) / 2;
    if ($r < 1 || $r > 5)
        return;
    return "<img src=\"" . $GLOBALS["PIC_BASE_URL"] . "$r.gif\" border=\"0\" alt=\"rating: $num / 5\" >";
} 

function browse_sortlink($field, $params)
{
    if ($field == $_GET["orderby"]) {
        return "browse.php?orderby=$field&amp;sort=" . ($_GET["sort"] == "asc" ? "desc" : "asc") . "&amp;$params";
    } else {
        return "browse.php?orderby=$field&amp;sort=" . ($_GET["sort"] == "desc" ? "desc" : "asc") . "&amp;$params";
    } 
} 

include("".$GLOBALS["TEMPLATES_SYSTEM"]. "x264_torrenttable.php");

function hit_start()
{
	global $RUNTIME_START, $RUNTIME_TIMES; 
	// $RUNTIME_TIMES = posix_times();
	$RUNTIME_START = gettimeofday();
} 

function hit_count()
{
	return;
	global $RUNTIME_CLAUSE;
	if (preg_match(',([^/]+)$,', $_SERVER["SCRIPT_NAME"], $matches))
		$path = $matches[1];
	else
		$path = "(unknown)";
	$period = date("Y-m-d H") . ":00:00";
	$RUNTIME_CLAUSE = "page = " . sqlesc($path) . " AND period = '$period'";
	$update = "UPDATE hits SET count = count + 1 WHERE $RUNTIME_CLAUSE";
	mysql_query($update);
		if (mysql_affected_rows())
			return;
		$ret = mysql_query("INSERT INTO hits (page, period, count) VALUES (" . sqlesc($path) . ", '$period', 1)");
		if (!$ret)
			mysql_query($update);
} 

function hit_end()
{
	return;
	global $RUNTIME_START, $RUNTIME_CLAUSE, $RUNTIME_TIMES;
	if (empty($RUNTIME_CLAUSE))
		return;
	$now = gettimeofday();
	$runtime = ($now["sec"] - $RUNTIME_START["sec"]) + ($now["usec"] - $RUNTIME_START["usec"]) / 1000000;
	$ts = posix_times();
	$sys = ($ts["stime"] - $RUNTIME_TIMES["stime"]) / 100;
	$username = ($ts["utime"] - $RUNTIME_TIMES["utime"]) / 100;
	mysql_query("UPDATE hits SET runs = runs + 1, runtime = runtime + $runtime, user_cpu = user_cpu + $username, sys_cpu = sys_cpu + $sys WHERE $RUNTIME_CLAUSE");
} 

function hash_pad($hash)
{
	return str_pad($hash, 20);
}

function mksecret($len = 20)
{
    $return = "";
    $len    = intval($len);

    for ($i = 0; $i < $len; $i++)
      $return .= chr(mt_rand(0, 255));

    return $return;
} 

function hash_where($name, $hash)
{
	$shhash = preg_replace('/ *$/s', "", $hash);
	return "($name = " . sqlesc($hash) . " OR $name = " . sqlesc($shhash) . ")";
	} 

function get_user_icons($arr, $big = false)
{
	if ($big) {
		$donorpic = "starbig.png";
		$warnedpic = "warnedbig.gif";
		$disabledpic = "disabledbig.png";
		$newbiepic = "pacifierbig.png";
		$style = "style=\"margin-left:4pt;vertical-align:middle;\"";
	} else {
		$donorpic = "star.png";
		$warnedpic = "warned.gif";
		$disabledpic = "disabled.png";
		$newbiepic = "pacifier.png";
		$style = "style=\"margin-left:2pt;vertical-align:middle;\"";
	} 

	if (isset($arr["warned"]) && $arr["warned"] == "yes")
		$pics .= "<img src=\"" . $GLOBALS["PIC_BASE_URL"] . $warnedpic . "\" alt=\"Verwarnt\" title=\"Dieser Benutzer wurde verwarnt\" border=0 $style>";

	if (isset($arr["enabled"]) && $arr["enabled"] == "no")
		$pics .= "<img src=\"" . $GLOBALS["PIC_BASE_URL"] . $disabledpic . "\" alt=\"Deaktiviert\" title=\"Dieser Benutzer ist deaktiviert\" border=0 $style>";
}

function oster_suche()
{

    global $CURUSER;
      
    $egg = mt_rand(0, 200);

    if ($egg == 1)
    {
    
        $gewinn = mt_rand(500, 10000);
             
        mysql_query("UPDATE users SET uploaded = uploaded + " . ($gewinn * 1024 * 1024) . " WHERE id = " . $CURUSER['id'] . " LIMIT 1") OR sqlerr(__FILE__, __LINE__);
  	
	write_log("modmessages", "<b><font color=red>Ein User hat ein Osterei gefunden!!</font></b>");

        return
        '<div class="siteloader_warp" style="position:absolute;width:400px;height:400px;">                              
		<div style="font-weight:bold" id="sb_loading-layer-text">
		<div class="word_siteloader" align="center">Osterei gefunden!</div>
		<div class="loading">
			<img src="' . $GLOBALS['DESIGN_PATTERN'] . 'ostereier/' . (mt_rand(0,4)) . '.gif" alt="[Osterei]" style="margin-top:30px;height:170px;" />
			Du hast ein Osterei gefunden!
			Im Osterei waren ' . number_format($gewinn / 1000,1,".",",") . ' GB an Upload versteckt!
			<p style="text-align:right;font-size:10pt;font-style:italic;padding: 30px 10px 5px 5px;"><a href="javascript:void(0);" onclick="document.getElementById(\'osterei\').style.display=\'none\';">Fenster ausblenden</a></p>		
		</div>
	</div>';
  
    }

  return;   
} 
?>