<?php

require_once("include/bittorrent.php");

hit_start();

function bark($msg) {
  stdhead();
  stdmsg("Löschen fehlgeschlagen!", $msg);
  stdfoot();
  exit;
}

if (!mkglobal("id"))
	bark("Fehlenden Formulardaten");

$id = 0 + $id;
if (!$id)
	die();

dbconn();

hit_count();

loggedinorreturn();

$res = mysql_query("SELECT torrents.name,torrents.owner,torrents.seeders,torrents.activated,users.class FROM torrents LEFT JOIN users ON torrents.owner=users.id WHERE torrents.id = $id");
$row = mysql_fetch_array($res);
if (!$row)
	die();

if ($CURUSER["id"] != $row["owner"] && !(get_user_class() >= UC_MODERATOR || ($row["activated"] == "no" && get_user_class() == UC_GUTEAM && $row["class"] < UC_UPLOADER)))
	bark("Dir gehört der Torrent nicht! Wie konnte das passieren?\n");

$rt = 0 + $_POST["reasontype"];

if (!is_int($rt) || $rt < 1 || $rt > 5)
	bark("Ungültiger Grund ($rt).");

$r = $_POST["r"];
$reason = $_POST["reason"];

if ($rt == 1)
	$reasonstr = "Tot: 0 Seeder, 0 Leecher = 0 Peers gesamt";
elseif ($rt == 2)
	$reasonstr = "Doppelt" . ($reason[0] ? (": " . trim($reason[0])) : "!");
elseif ($rt == 3)
	$reasonstr = "Nuked" . ($reason[1] ? (": " . trim($reason[1])) : "!");
elseif ($rt == 4)
{
	if (!$reason[2])
		bark("Bitte beschreibe, welche Regel verletzt wurde.");
    $reasonstr = "NetVision Regeln verletzt: " . trim($reason[2]);
}
else
{
	if (!$reason[3])
		bark("Bitte gebe einen Grund an, warum dieser Torrent gelöscht werden soll.");
  $reasonstr = trim($reason[3]);
}

deletetorrent($id, $row["owner"], $reasonstr);

write_log("torrentdelete","Der Torrent $id ($row[name]) wurde von '<a href=\"userdetails.php?id=$CURUSER[id]\">$CURUSER[username]</a>' gelöscht ($reasonstr)\n");

x264_header("Torrent gelöscht!");

if (isset($_POST["returnto"]))
	$ret = "<a href=\"" . htmlspecialchars($_POST["returnto"]) . "\">Gehe dorthin zurück, von wo Du kamst</a>";
else
	$ret = "<a href=\"./\">Zurück zum Index</a>";

?>
<h2>Torrent gel&ouml;scht!</h2>
<p><?= $ret ?></p>
<?

x264_footer();

hit_end();

?>