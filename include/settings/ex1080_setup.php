<?php
/************************************************************
* Global settings
**************************************************************/
$GLOBALS["SHORTNAME"] = "_x264_";

// Set this to FALSE, if you have to do some time consuming maintenance
$GLOBALS["SITE_ONLINE"] = TRUE;

// Maximum size for uploaded .torrent files, default is 1 MB
$GLOBALS["MAX_TORRENT_SIZE"] =  1536 * 1536;

// Reannounce interval suggested to clients.
// Do not set this lower than about 20 minutes, since some clients
// do not honour this value, and rather do their reannounces at 30 minute
// intervals. This would result in concurrent timeouts for these peers.
$GLOBALS["ANNOUNCE_INTERVAL"] = 60 * 20;

// Minimum votes necessary to rate a torrent
$GLOBALS["MINVOTES"] = 1;

// Use IP or PassKey method for user authentication
// Valid values are CLIENT_AUTH_IP and CLIENT_AUTH_PASSKEY
$GLOBALS["CLIENT_AUTH"] = CLIENT_AUTH_PASSKEY;

// PassKey source, either by parameter "passkey=...", or by
// subdomain "http://passkey.tracker.net/announce.php"
// Use subdomain, if you have access to wildcard subdomains,
// but not mod_rewrite
$GLOBALS["PASSKEY_SOURCE"] = PASSKEY_USE_PARAM;

// Download method being used by the tracker to publish .torrent files.
// If you use themod_rewrite method, set this to DOWNLOAD_REWRITE, since
// this solution is most compatible. Otherwise, set it to DOWNLOAD_ATTACHMENT.
$GLOBALS["DOWNLOAD_METHOD"] = DOWNLOAD_ATTACHMENT;

$GLOBALS["SEED_DAYS"] = 2;  

/************************************************************
* Limits
*************************************************************/
// Unter dieser Ratio wird ein user verwarnt ;)
// Im hier gezeigten Beispiel wird der User verwarnt wenn er unter 0.2 ist :)
$GLOBALS["AUTO_WARN_MIN_RATIO"] = 0.6;

// Jeder User unter der oben gezeigten Ratio und mit einem Download von
// in diesem Beispiel 2 GB wird verwarnt :) (ANGABEN IN GB)
$GLOBALS["AUTO_WARN_DOWN"] = 10;

// Länge der Verwarnung die eintritt wenn die Werte von oben zutreffen
// (Angaben in Wochen x*7) in diesem Fall 2 Wochen
$GLOBALS["AUTO_WARN_LÄNGE"] = 2;

// Jeder automatisch verwarnte User der eine Ratio >= 0.6 hat dem wird die Verwarnung entfernt
// In diesem Beispiel ist es bei 0.6 Ratio
$GLOBALS["AUTO_REM_MIN_RATIO"] = 0.6;

//Automatischer Ban wenn ein User mehr als 8GB geleecht hat
$GLOBALS["AUTO_BAN_DOWN"] = 15;

//Und dabei nicht mal eine Ratio von über 0.2 hat :)
$GLOBALS["AUTO_BAN_MIN_RATIO"] = 0.6;

// Maximum size of files uploaded into the BitBucket in bytes
$GLOBALS["MAX_UPLOAD_FILESIZE"] = 1024 * 3024;

// Maximum size of the BitBucket per user in bytes
$GLOBALS["MAX_BITBUCKET_SIZE_USER"] = 3048 * 2024;

// Maximum size of the BitBucket for uploaders in bytes
$GLOBALS["MAX_BITBUCKET_SIZE_UPLOADER"] = 5 * 2024 * 2024;

// Number of categories displayed per row in torrent browser
$GLOBALS["BROWSE_CATS_PER_ROW"] = 7;

// Wait time only for leechers
// Be careful, as it is possible to cheat with the wait time if set to TRUE
$GLOBALS["ONLY_LEECHERS_WAIT"] = FALSE;

// Disallow leeching even if the wait time for a torrent is disabled
// Be careful, as it is still possible to cheat if set to TRUE
$GLOBALS["NOWAITTIME_ONLYSEEDS"] = FALSE;

// Rules for wait time
// Format is Max.Ratio:Max.UpGigs:Regtime:Waittime|...
// Regtime format is [#w][#d] or 0 and * for infinite, e.g.: 2w, 2w3d, 5d
// If no rule does match, the wait time is 0, otherwise the highest wait time
// of any rule that matches counts.
$GLOBALS["WAIT_TIME_RULES"] = "0";

// Rules for torrent limitation
// Format is Ratio:UpGigs:SeedsMax:LeechesMax:AllMax|...
// Ratio and UpGigs are "minimum" requirements.
$GLOBALS["TORRENT_RULES"] = "0:0:4:2:6|1.01,25:5:15:8:23|2.01,200:20:20:10:30|3.01,500:20:30:10:40|4.01,2:20:20:10:40";

// Maximum number of different IP addresses for each passkey/user
$GLOBALS["MAX_PASSKEY_IPS"] = 8;

// Threshold for ratio faker tool detection. If you allow root seeding,
// consider setting this so a high value, e.g. 4 MB/sec
$GLOBALS["RATIOFAKER_THRESH"] = 1024 * 1024;

// Alwas perfom a "deep" cleanup. On small trackers, you can set
// this to TRUE, but on large trackers with lots of torrents, you
// should set this to FALSE and do deep cleanups by running
//      docleanup.php?deep=1
// as a moderator or higher ranked user.
$GLOBALS["ALWAYS_DEEP_CLEAN"] = TRUE;


/************************************************************
* Timeout settings and intervals
*************************************************************/

// Max dead torrent timeout (days)
// Time after which torrents with 0 peers are marked as dead (invisible)
$GLOBALS["MAX_DEAD_TORRENT_TIME"] = 0;

// Max torrent TTL (days, 0 to disable)
// Time after which torrents are automatically deleted
$GLOBALS["MAX_TORRENT_TTL"] = 180;

// Max signup timeout (hours)
// Time given to an user to activate his/her account
$GLOBALS["SIGNUP_TIMEOUT"] = 48;

// Max inactive timeout (days)
// Period of inactivity/no logins after an user is deleted
$GLOBALS["INACTIVE_TIMEOUT"] = 42;

// Max disabled timeout (days)
// Period of time after a disabled user is deleted
$GLOBALS["DISABLED_TIMEOUT"] = 5;

// Lock timeout for forum threads (days, 0=disabled)
// Forum threads where last post was made x days ago will be locked
$GLOBALS["THREAD_LOCK_TIMEOUT"] = 7;

// Autoclean interval (seconds)
// Time between torrent and user cleanups. If the tracker suffers
// from high load, consider setting this to a higher value.
$GLOBALS["AUTOCLEAN_INTERVAL"] = 1800;

// Maximum personal message prune time (days, 0=disabled)
// Personal messages are getting deleted after this number of days,
// regardless of any user setting for PM folders.
$GLOBALS["PM_PRUNE_DAYS"] = 0;

// Lock timeout for forum threads (days, 0=disabled)
// Forum threads where last post was made x days ago will be locked
$GLOBALS["THREAD_LOCK_TIMEOUT"] = 7;
/************************************************************
* Path and URL settings
* 
* Paths are relative to index.php or absolute if beginning
* with / (or X:\ in Windows)
* All paths must not end with a trailing slash if not
* otherwise stated!
*************************************************************/

// Path where .torrent files are stored
// This path MUST NOT be publicly available. The download
// script takes care of delivering the files to users.
// Webserver MUST have write permission on this directory!
// No trailing slash.
$GLOBALS["TORRENT_DIR"] = "torrents";

// Path for the Tool Center
$GLOBALS["TOOL_DATA"] = "_x264_/tool_center";

// Maximum filesize in the Tools-Center in bytes
$GLOBALS["MAX_TOOL_SIZE"] = 6 * 1024 * 1024;

// Path where all Bit-Bucket files are stored. These are:
// User's files, torrent and NFO images
// This path MUST be a subdir of the tracker root, and MUST be
// publicly available, optionally with referrer check
// Webserver MUST have write permission on this directory!
// No trailing slash.
$GLOBALS["BITBUCKET_DIR"] = "_x264_/bitbucket";

// Relative or absolute URL where all images for the interface are stored.
// MUST include a trailing slash!
$GLOBALS["PIC_BASE_URL"] = "pic/";

// Relative or absolute URL to the portal, if it exists. Leave blank
// to hide the portal links.
$GLOBALS["PORTAL_LINK"] = "";
$GLOBALS["PORTAL"] = true;
// Valid tracker announce URLs
// The first entry will be displayed on the upload page
$GLOBALS["ANNOUNCE_URLS"] = array();
$GLOBALS["ANNOUNCE_URLS"][] = "https://yourdomain.com/announce.php";

// Announce URL with passkey placeholder
$GLOBALS["PASSKEY_ANNOUNCE_URL"] = "https://yourdomain.com/announce.php?passkey={KEY}";
$GLOBALS["PASSKEY_SSL_ANNOUNCE_URL"] = "https://yourdomain.com/announce.php?passkey={KEY}";

if ($_SERVER["HTTP_HOST"] == "")
    $_SERVER["HTTP_HOST"] = $_SERVER["SERVER_NAME"];
$GLOBALS["BASEURL"] = "https://" . $_SERVER["HTTP_HOST"];
if ($_SERVER["SERVER_PORT"] != 443)
    $GLOBALS["BASEURL"] .= ":".$_SERVER["SERVER_PORT"];

// Set this to your site URL, if automatic detection won't work
$GLOBALS["DEFAULTBASEURL"] = "https://yourdomain.com";
// Without http and https specify!
$GLOBALS['DOMAIN'] = "yourdomain.com";

// Array containing all domains which are used to reach the tracker
// This array is used in the redirector script to determine the type of redirect
// Do not add "http://" in front of the domain, and no trailing slash
$GLOBALS["TRACKERDOMAINS"] = array();
$GLOBALS["TRACKERDOMAINS"][] = "yourdomain.com";

// Set this to true to make this a tracker that only registered users may use
// Setting this to FALSE is currently not supported, sorry!
$GLOBALS["MEMBERSONLY"] = TRUE;

?>