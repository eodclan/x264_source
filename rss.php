<?php
require_once(dirname(__FILE__)."/include/bittorrent.php");
dbconn();

function noFeed()
{
    echo "<item>\n<title>Nicht eingeloggt oder kein RSS-Feed verfügbar!</title>\n";
    echo "<category domain=\"$DEFAULTBASEURL\">(Keine Kategorie)</category>\n";
    echo "<nfo>Der RSS-Feed ist nur verfügbar, wenn Du eingeloggt bist, Cookies aktiviert hast, und der Administrator diese Funktion aktiviert hat.</nfo>\n";
    echo "<link>".$DEFAULTBASEURL."/login.php</link>";
    echo "</item></channel>\n</rss>\n";
    die();
}

header("Content-type: application/xml");

echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n<rss version=\"2.0\">\n<channel>\n";
echo "<title>".$GLOBALS["SITENAME"]." RSS-Feed</title>\n<link>".$GLOBALS["DEFAULTBASEURL"]."</link>\n<description>".$GLOBALS["SITENAME"]." - Aktuelle Torrents</description>\n<language>de-de</language><copyright>Powered by ".$GLOBALS["SITENAME"]."</copyright> \n";

if (!isset($GLOBALS["CURUSER"]) || !$GLOBALS["DYNAMIC_RSS"])
    noFeed();

$query = "SELECT `id`,`name`,`descr`,`filename`,`category` FROM `torrents` WHERE `activated`='yes' ";
if ($_GET["categories"] == "profile") {
    $categories = Array();
    @preg_match_all("/\\[cat(\\d+)\\]/", $CURUSER['notifs'], $catids);
    for ($I=0; $I<count($catids[1]);$I++)
        array_push($categories, $catids[1][$I]);
    if (count($categories) > 0) {
        $categories = implode(",", $categories);
        $query .= "AND `category` IN ($categories) ";
    }
}
$res = mysql_query($query."ORDER BY `added` DESC LIMIT 30");
 
while ($arr = mysql_fetch_assoc($res)) {
    $cat = $cats[$arr["category"]];
    echo "<item>\n<title>" . htmlspecialchars($arr["name"]) . "</title>\n";
    echo "<category domain=\"$DEFAULTBASEURL/tfiles.php?cat=" . $arr["category"] . "\">" . htmlspecialchars($cat) . "</category>\n";
    echo "<nfo><a href='$DEFAULTBASEURL/download_nfo.php?id=" . $arr["id"] . "&amp;action=downloadNFO'></a></nfo>\n<download><a href='$DEFAULTBASEURL/download.php?torrent=" . $arr["id"] . "'></a></download>\n<link>$DEFAULTBASEURL/";
    if ($_GET["type"] == "directdl")
        echo "download/" . $arr["id"] . "/" . htmlspecialchars($arr["filename"]);
    else
        echo "tfilesinfo.php?id=" . $arr["id"] . "&amp;hit=1";
    echo "</link>\n</item>\n";
} 
echo "</channel>\n</rss>";
?>