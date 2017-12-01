<?php
require_once "db_setup.php";
/************************************************************
* Tracker configuration
* 
* Please read the comments before changing anything!
* Database configuration: see secrets.php
**************************************************************/
mysql_connect("$mysql_host", "$mysql_user", "$mysql_pass");
mysql_select_db($mysql_db);

$cres = mysql_query("SELECT name, wert FROM config");
while($carr=mysql_fetch_assoc($cres))
{
  $name = $carr['name'];
  $wert = $carr['wert'];
  $GLOBALS[$name] = $wert;
}

define ("CLIENT_AUTH_IP", "0");
define ("CLIENT_AUTH_PASSKEY", "1");

define ("PASSKEY_USE_PARAM", "1");
define ("PASSKEY_USE_SUBDOMAIN", "0");

define ("DOWNLOAD_REWRITE", "0");
define ("DOWNLOAD_ATTACHMENT", "1");

if (isset($_SERVER['HTTP_HOST']))
{
  switch ($_SERVER['HTTP_HOST'])
  {
    case "yourdomain.com":
    case "yourdomain.com:443":
      $conffile = "ex1080_setup.php";
      break;
    default:
      Header("Location: http://www.google.ru");
  }
  include (dirname(__FILE__)."/settings/".$conffile);
}

// Badwords in email addresses, matches everywhere
$GLOBALS["EMAIL_BADWORDS"] = array(
    "sofort-mail", 
    "lycos", 
    "yahoo", 
    "km4bi.com", 
    "hotmail", 
    "spamgourmet", 
    "trash-mail",
    "freenet.de",
    "rocketmail",
    "mailinator",
    "msn.com",
    "msn.de",
    "spammotel",
    "fakemail",
    "germanmail",
    "discardmail",
    "spacemail",
    "mail.ru",
    "mytrashmail",
    "jetable",
    "spam.la",
    "spamgourmet.com",
    "ok.de",
    "byom.de",
    // DynDNS.org Hosts anfang
    "fastmail.co.uk",
    "gmail.com",
    "live.fr",
    "test.de",
    "dvrdns",
    "dynalias",
    "dyndns",
    "game-host.org",
    "game-server.cc",
    "getmyip.com",
    "gotdns",
    "ham-radio-op.net",
    "homedns",
    "homeftp",
    "homelinux",
    "homeunix",
    "is-a-geek",
    "isa-geek",
    "kicks-ass",
    "raf.edu.rs",
    "mine.nu",
    "myphotos.cc",
    "podzone",
    "roshdypharmacies.com",
    "servegame",
    "shacknet.nu",
    // DynDNS.org Hosts ende
    "dyn.pl",
    "bbth3c",
);

// Array of banned peer ids. Match is done only at the beginning of the string.
$GLOBALS["BAN_PEERIDS"] = array(
    "A\x02\x06\x09-",
    "-ÄZ{Ü"
);

// Array of banned user agents, only exact matches
$GLOBALS["BAN_USERAGENTS"] = array(
    "Azureus 2.1.0.0",
    "Azureus 2.2.0.3_B1",
    "Azureus 2.2.0.3_B4",
    "Azureus 2.2.0.3_B29",
    "BitComet",
    "Python-urllib/2.0a1"
);

?>