<?php


require_once("include/bittorrent.php");

dbconn(false);

loggedinorreturn();

$trackerconfig = explode("|",htmlentities(trim(get_config_data('TRACKERCONF'))));
if ($trackerconfig[4] == "off")
  stderr("Zur Zeit gesperrt","Torrentedit ist zur Zeit deaktiviert!");
  
function bark($msg) {
	genbark($msg, "Edit failed!");
}

function tr_status($status)
{
    //DUMMY
}

if (!mkglobal("id:name:descr:type"))
	bark("Fehlende Formulardaten!");

$id = 0 + $id;
if (!$id)
	die();



$GLOBALS["uploaderrors"] = Array();

$res = mysql_query("SELECT torrents.owner, torrents.numpics, torrents.nuked, torrents.nukereason, torrents.filename, torrents.save_as, torrents.activated, torrents.tvdb, users.class FROM torrents LEFT JOIN users ON torrents.owner=users.id WHERE torrents.id = $id");
$row = mysql_fetch_array($res);
if (!$row)
	die();

if ($CURUSER["id"] != $row["owner"] && !(get_user_class() >= UC_MODERATOR || ($row["activated"] == "no" && get_user_class() == UC_GUTEAM && $row["class"] < UC_UPLOADER)))
	bark("Das ist nicht Dein Torrent! Wie konnte das passieren?\n");

$updateset = array();

$fname = $row["filename"];
preg_match('/^(.+)\.torrent$/si', $fname, $matches);
$shortfname = $matches[1];
$highlight = $_POST['highlight'];
$nuked = $_POST['nuked'];
$nukereason = $_POST['nukereason'];
$tvdb = $_POST['tvdb'];
$dname = $row["save_as"];

$nfoaction = $_POST['nfoaction'];
if ($nfoaction == "update")
{
  $nfofile = $_FILES['nfo'];
  if (!$nfofile) die("No data " . var_dump($_FILES));
  if ($nfofile['size'] > 65535)
    bark("NFO is too big! Max 65,535 bytes.");
  $nfofilename = $nfofile['tmp_name'];
  if (@is_uploaded_file($nfofilename) && @filesize($nfofilename) > 0) {
    $nfo = str_replace("\x0d\x0d\x0a", "\x0d\x0a", file_get_contents($nfofilename));
    $updateset[] = "nfo = " . sqlesc($nfo);
    // Create NFO image
    gen_nfo_pic($nfo, $GLOBALS["BITBUCKET_DIR"]."/nfo-$id.png");
  }
}
else
  if ($nfoaction == "remove")
    $updateset[] = "nfo = ''";

$picaction = $_POST['picaction'];

if ($picaction == "update") {
    
    if ($row["numpics"] >0) {
        for ($I=1; $I<=$row["numpics"]; $I++) {
            @unlink($GLOBALS["BITBUCKET_DIR"]."/t-$id-$I.jpg");
            @unlink($GLOBALS["BITBUCKET_DIR"]."/f-$id-$I.jpg");
        }
    }
    
    // Handle picture uploads
    $picnum = 0;
    if ($_FILES["pic1"]["name"] != "") {
        if (torrent_image_upload($_FILES["pic1"], $id, $picnum+1))
            $picnum++;
    }
    
    if ($_FILES["pic2"]["name"] != "") {
        if (torrent_image_upload($_FILES["pic2"], $id, $picnum+1))
            $picnum++;
    }
    


    $updateset[] = "numpics = " . $picnum;
}

// BEGIN: Image Upload zu ImageShack by truenoir (#IM01)
if(!$resetimg)
{
  if($pic1) $updateset[] = "pic1='$pic1'";
  if($pic2) $updateset[] = "pic2='$pic2'";
  if($pic1th) $updateset[] = "pic1th='$pic1th'";
  if($pic2th) $updateset[] = "pic2th='$pic2th'";
}
else
{
  $updateset[] = "pic1=''";
  $updateset[] = "pic2=''";
  $updateset[] = "pic1th=''";
  $updateset[] = "pic2th=''";
}
// END: Image Upload zu ImageShack by truenoir (#IM01)

if ($_POST["stripasciiart"] == "1") {
    $descr = strip_ascii_art($descr);
}

$updateset[] = "seedspeed=".sqlesc($_POST["seedspeed"]);
$updateset[] = "name = " . sqlesc($name);
$updateset[] = "tvdb = " . sqlesc($tvdb);
// BEGIN: Groups Edition by truenoir
$updateset[] = "team = " . sqlesc(0+$_POST["team"]);
// END: Groups Edition by truenoir
$updateset[] = "search_text = " . sqlesc(searchfield("$shortfname $dname $torrent"));
$updateset[] = "descr = " . sqlesc($descr);
$updateset[] = "ori_descr = " . sqlesc($descr);
$updateset[] = "highlight = '".($_POST["highlight"]==1 ? 'yes' : 'no')."'";
if(get_user_class()>=UC_SYSOP)
$updateset[] = "multiplikator=".sqlesc($_POST["multiplikator"]);
$updateset[] = "language = " . sqlesc($_POST["language"]);
$updateset[] = "category = " . (0 + $type);
if(get_user_class()>=UC_ADMINISTRATOR)
       $updateset[] = "free = '".($_POST["free"]==1 ? 'yes' : 'no')."'";
	$updateset[] = "freeleech = '".($_POST["freeleech"]==1 ? 'yes' : 'no')."'";
$updateset[] = "nuked = '".($_POST["nuked"]==1 ? 'yes' : 'no')."'";
$updateset[] = "nuked = " . sqlesc($nuked);
$updateset[] = "nukereason = " . sqlesc($nukereason);

$freeuntil = $_POST["freeuntil"];
$freetime = $_POST["freetime"];
if($_POST["freetime"] AND empty($freeuntil)) { $error = 1; }
if($error == 1) {
die("Wenn du ein Zeit OU machen willst muss das Datum eingetragen sein");
}else{
if ($_POST["freeuntil"] > 0) {
$updateset[] = "freeuntil = " . sqlesc($freeuntil);
}

if ($_POST["freetime"]) {
$updateset[] = "freetime = 'yes'";
}else{
$updateset[] = "freetime = 'no'";
}
}
if ($CURUSER["admin"] == "yes") {
	if ($_POST["banned"]) {
		$updateset[] = "banned = 'yes'";
		$_POST["visible"] = 0;
	}
	else
		$updateset[] = "banned = 'no'";
}
// Only allow torrent to be visible/alive if activated
if ($row["activated"] == "yes")
    $updateset[] = "visible = '" . ($_POST["visible"] ? "yes" : "no") . "'";

mysql_query("UPDATE torrents SET " . join(",", $updateset) . " WHERE id = $id");

write_log("torrentedit", "Der Torrent <a href=\"tfilesinfo.php?id=$id\">$id ($name)</a> wurde von '<a href=\"userdetails.php?id=$CURUSER[id]\">$CURUSER[username]</a>' bearbeitet.");

if (count($GLOBALS["uploaderrors"])) {
    $errstr = "<p>Beim Hochladen der Vorschaubilder sind Fehler aufgetreten:</p><ul>";
    foreach ($GLOBALS["uploaderrors"] as $error)
        $errstr .= "<li>$error</li>\n";
    $errstr .= "</ul><p>Alle anderen Änderungen wurden jedoch übernommen. Bitte bearbeite den Torrent erneut, um ";
    $errstr .= "neue Vorschaubilder hochzuladen.</p>";
    $errstr .= "<p><a href=\"tfilesinfo.php?id=$id&edited=1\">Weiter zur Detailansicht des Torrents</p>";
    stderr("Fehler beim Bilderupload", $errstr);
}

$returl = "tfilesinfo.php?id=$id&edited=1";
if (isset($_POST["returnto"]))
	$returl .= "&returnto=" . urlencode($_POST["returnto"]);
header("Refresh: 0; url=$returl");



?>