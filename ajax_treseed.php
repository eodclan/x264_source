<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");
dbconn();
loggedinorreturn();

header('Content-Type: text/html; charset=iso-8859-1');

$userid   = intval($CURUSER["id"]);
$reseedid = intval($_POST["reseedid"]);
$ajax     = (($_POST["ajax"]== "yes") ? "yes" : "no");

if (($ajax == "yes") && ($reseedid != 0) && ($userid != 0))
{
    $now = get_date_time();

    $sql  = "SELECT last_reseed FROM torrents WHERE id = " . $reseedid . " LIMIT 1";
    $time = $db -> querySingleItem($sql);
    $diff = "+" . get_config_data("RESEED_DIFF") . " hours";

    $soll = ($time == "0000-00-00 00:00:00" ? $now : $time);
    $soll = strtotime($soll . " " . $diff);
    $soll = date("Y-m-d H:i:s", $soll);

    $datum = substr($soll, 5, 2) . " " . substr($soll, 8, 2) . ", " . substr($soll, 0, 4) . substr($soll, 10);

    $sql    = "SELECT COUNT(seeder) FROM peers WHERE torrent = " . $reseedid;
    $seeder = $db -> querySingleItem($sql);

    if ( ($time != "0000-00-00 00:00:00") && ($soll >= $now) && ($seeder > 1) )
    {
        print("Reseed kann nicht erstellt werden");
    }

    $sql = "UPDATE torrents SET last_reseed = '" . $now . "' WHERE id = " . $reseedid . " LIMIT 1";
    $db -> execute($sql);

    $sql = "SELECT completed.user_id, " .
           "       completed.torrent_id, " .
           "       torrents.name, " .
           "       users.id " .

           "FROM completed " .

           "INNER JOIN users    ON (completed.user_id = users.id) " .
           "INNER JOIN torrents ON (torrents.id = " . $reseedid . ") " .

           "WHERE completed.torrent_id = " . $reseedid;
    $data = $db -> queryObjectArray($sql);

    foreach ($data AS $key => $val)
    {
        $titel  = "Reseedanfrage für Torrent " . $val["name"];
        $pn_msg = "[u]" . $now . "[/u]\nDer User " . $CURUSER["username"] . " fragt nach einem Reseed von [url=tfilesinfo.php?id=" . $reseedid . "]" .
                  $val["name"]."[/url] !\nSolltest du das File noch auf Platte haben wäre es sehr nett wenn du noch ein bisschen Seeden würdest.\n\nDanke";

        sendPersonalMessage(0, $val["id"], $titel, $pn_msg, PM_FOLDERID_INBOX, 0);
    }

    print("Der Reseed wurde ausgef&uuml;hrt.");

    die;
}
else
{
    print("Ung&uuml;ltige Funktion");
}
?>