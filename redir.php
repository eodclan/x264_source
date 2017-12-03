<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");

define("REDIR_EXTERNAL", 1);
define("REDIR_INTERNAL", 2);

function check_domain($domain)
{
if (in_array(strtolower($domain), $GLOBALS["DEFAULTBASEURL"]))
return REDIR_INTERNAL;       
return REDIR_EXTERNAL;
}
function clean_urls($url)
{
$scriptPatterns = array('/document.cookie/i','/javascript/i','/<+script/i', '/(%3C)+script/i', '/(&lt;)+script/i', '/(<)+script/i','/<+javascript/i', '/(%3C)+javascript/i', '/(&lt;)+javascript/i', '/(<)+javascript/i');
$phpPatterns    = array("'+>\?'","'<+\?'", "'(%3C)+\?'", "'(&lt;)+\?'", "'(&gt;)+\?'", "'(<)+\?'");
$url = @preg_replace('/\.\.\//', '', $url);
$url = @preg_replace($scriptPatterns, 'NOSCRIPT', $url);
$url = @preg_replace($phpPatterns, 'NOPHP', $url);
return $url;
}

$url = '';

while (list($var,$val) = each($_GET))
    $url .= "&$var=$val";

$i = strpos($url, "&url=");

if ($i !== false)
    $url = substr($url, $i + 5);

if (substr($url, 0, 4) == "www.")
    $url = "http://" . $url;

// Determine redirection target (inside/outside)    
$port = strpos($url, ":", 7);
$slash = strpos($url, "/", 7);

// We make no differentiation between FALSE and 0, because there should
// be no / or : directly after the "http://".
if ($port == FALSE && $slash == FALSE)
    $type = REDIR_EXTERNAL;

if ($port == FALSE && $slash > 0)
    $type = check_domain(substr($url, 7, $slash-7));

if ($port > 0 && $slash == FALSE)
    $type = check_domain(substr($url, 7, $port-7));

if ($type == REDIR_EXTERNAL)
{
$url=htmlspecialchars($url);
print("<html><head><meta http-equiv=refresh content='0;url=http://anonym.to/?$url'></head><body>\n");
print("<table border=0 width=100% height=100%><tr><td><h2 align=center>Du wirst jetzt umgeleitet nach:<br>\n");
print("$url</h2></td></tr></table></body></html>\n");
}

else 
{
    // HTTP redirect
    header("Location: $url");
}
?> 