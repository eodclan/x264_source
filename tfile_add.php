<?php
// ************************************************************************************//
// * X264 Source
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2015 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//
require_once(dirname(__FILE__)."/include/benc.php");
require_once(dirname(__FILE__)."/include/bittorrent.php");
require_once(dirname(__FILE__)."/include/imdb.class.php");
hit_start();
dbconn(false);
hit_count();
loggedinorreturn();

if ($CURUSER["allowupload"] != "yes")
{
	stderr("Sorry...", "Es ist Dir nicht gestattet, Torrents hochzuladen!");
}

if ($_SERVER['REQUEST_METHOD'] != "POST")
{
  $grpsel= NULL;
  $sql    = "SELECT DISTINCT teams.id, teams.name FROM teams, teammembers WHERE teammembers.teamid = teams.id AND teammembers.userid=".$CURUSER['id']." AND teams.typ = 'crew' GROUP BY teams.id ORDER BY teams.name";
  $grpres = $db -> queryObjectArray($sql);
  if ($grpres)
  {
    foreach($grpres AS $grparr)
    {
      $grpsel.="<div class='x264_profile'><option value=\"$grparr[id]\">$grparr[name]</option></div>";
    }
  }

  if($grpsel != "")
  {
    $grpsel="<div class='x264_profile'><select name=\"group\"><option value=\"0\">---[ Bitte auswählen ]---</option>$grpsel</select></div>";
  }
  else
  {
    unset($grpsel);
  }
  
$newcats .= "<select name=\"type\" class=\"btn btn-flat btn-primary fc-today-button btn-secondary dropdown-toggle\">\n<option value=\"0\">(ausw&auml;hlen)</option>\n"; 
$res = mysql_query("SELECT * FROM categories where type = 1") OR sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res)) 
{
  $newcats .= "<optgroup label=\"" . $arr["name"] . "\"\n>"; 
  $resa = mysql_query("SELECT * FROM categories where haupt = " . $arr["id"] . "") OR sqlerr(__FILE__, __LINE__);
  while ($arra = mysql_fetch_assoc($resa)) 
  {
    $newcats .= "<option value=\"" . $arra["id"] . "\">" . htmlspecialchars($arra["name"]) . "</option>\n";
  }
  $newcats .= "</optgroup>\n";
}
$newcats .= "</select>\n";

  $ss =   "<select name=\"seedspeed\" class=\"btn btn-flat btn-primary fc-today-button btn-secondary dropdown-toggle\">
            <option>12 KB/s</option>
            <option>16 KB/s</option>
            <option>20 KB/s</option>
            <option>28 KB/s</option>
            <option>32 KB/s</option>
            <option>44 KB/s</option>
            <option>50 KB/s</option>
            <option>60 KB/s</option>
            <option>70 KB/s</option>
            <option>80 KB/s</option>
            <option>100 KB/s</option>
            <option>200 KB/s</option>
            <option>300 KB/s</option>
            <option>500 KB/s</option>
            <option>1 MB/s</option>
            <option>1,5 MB/s</option>
            <option>2 MB/s</option>
            <option>2,5 MB/s</option>
            <option>3 MB/s</option>
            <option selected>3,5 MB/s</option>
            <option>4 MB/s</option>
            <option>4,5 MB/s</option>
            <option>5 MB/s</option>
            <option>&lt;5 MB/s</option>
          </select>";

x264_header("Upload");

$trackerdienste = $GLOBALS["TORRENT_UPLOAD_OFF"];
if ($trackerdienste[0] == "0")
{
  stdmsg("Achtung","Torrent Upload ist zur Zeit deaktiviert.");
  x264_footer();
  die();
}

print '
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-edit"></i> Torrent Upload
                                    <div class="card-actions">
                                        <a href="#" class="btn-close"><i class="icon-close"></i></a>
                                    </div>
                                </div>
                                <div class="card-block">
					<form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'" method="post">
					<input type="hidden" name="MAX_FILE_SIZE" value="'.$GLOBALS["MAX_TORRENT_SIZE"].'">
					<strong>Die Announce-URLs des Trackers ist:'.$GLOBALS["ANNOUNCE_URLS1"].'</strong>
					<div class="card-block">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label">Torrent Datei</label>
                            <div class="col-md-9">
                                <input type="file" name="file" size="80" class="btn btn-primary" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Name</label>
                            <div class="col-md-9">
                                <input type="text" name="name" size="80" class="btn btn-primary" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">NFO</label>
                            <div class="col-md-9">
                                <input type="file" name="nfo" size="80" class="btn btn-primary">
                                <span class="help-block">Jede NFO Datei ersetzt automatisch die Beschreibung.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="password-input">Cover</label>
                            <div class="col-md-9">
                                <input type="file" name="pic1" size="80" class="btn btn-primary">
                                <span class="help-block">Ein Cover ist immer Pflicht.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="textarea-input">Beschreibung</label>
                            <div class="col-md-9">
                                <textarea name="descr" rows="10" cols="80" class="btn btn-primary"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="select">ASCII-Art</label>
                            <div class="col-md-9">
								<label class="switch switch-text switch-primary">
									<input type="checkbox" name="stripasciiart" class="switch-input" checked="checked">
									<span class="switch-label" data-on="On" data-off="Off"></span>
									<span class="switch-handle"></span>
								</label>
								<span class="help-block">Die ASCII-Art Zeichen automatisch entfernen.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="select">Highlight Torrent</label>
                            <div class="col-md-9">
								<label class="switch switch-text switch-primary">
									<input type="checkbox" name="highlight" value="yes" class="switch-input">
									<span class="switch-label" data-on="On" data-off="Off"></span>
									<span class="switch-handle"></span>
								</label>
								<span class="help-block">Als Highlight Torrent markieren</span>
                            </div>
                        </div>						
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="select">Sprache</label>
                            <div class="col-md-9">
                                <input type=radio name=language value=na class="btn btn-primary"><img alt="P2P Release" src="pic/p2p.gif" title="P2P Release"> <input type=radio name=language checked value=deutsch class="btn btn-primary"><img alt="German Scene Release" src="pic/germany.gif" title="German Scene Release"> <input type=radio name=language value=englisch class="btn btn-primary"><img alt="English Scene Release" src="pic/england.gif" title="English Scene Release"> <input type=radio name=language value=multi class="btn btn-primary"><img alt="Dual Language Scene Release" src="pic/multi.gif" title="Dual Language Scene Release">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="select">Kategorie</label>
                            <div class="col-md-9">
                                '.$newcats.'
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="select">Seed Speed</label>
                            <div class="col-md-9">
                                '.$ss.'
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="multiple-select">Only Upload</label>
                            <div class="col-md-9">
                                <input type="checkbox" name="zaprosi" value="da">
								<span class="help-block">Torrents ab 5GB sind automatisch Only UP. Bei Files unter 5GB entscheidet das Team obs ein Only Upload wird oder nicht! Du bekommst eine PM über die Entscheidung.</span>
                            </div>
                        </div>
                	</div>
					<div class="card-footer">
					
					<button class="btn btn-flat btn-primary fc-today-button btn-ladda-progress ladda-button" type="submit" data-style="expand-right"><span class="ladda-label">Hochladen</span><span class="ladda-spinner"></span><div class="ladda-progress" style="width: 117px;"></div></button>

					</div>		
					</form>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>';

  x264_footer();
  hit_end();
  die();
}

ini_set("upload_max_filesize", $GLOBALS["MAX_TORRENT_SIZE"] + 2 * $GLOBALS["MAX_UPLOAD_FILESIZE"]);

$GLOBALS["uploaderrors"] = Array();

function tr_msg($msg)
{
  print "<tr><td class=\"table table-bordered table-striped table-condensed\" style=\"text-align:left;\">".$msg."</td>";
}

function tr_status($status)
{
  if ($status == "ok")
  {
   print" <td class='table table-bordered table-striped table-condensed' style='text-align:center;'><i class='fa fa-check-square-o'></i></td></tr>";
  }
  else
  {
   print" <td class='table table-bordered table-striped table-condensed' style='text-align:center;'><i class='fa fa-close'></i></td></tr>";
  }
  flush();
}

function abort($msg)
{
  print " 
		<tr class='table table-bordered table-striped table-condensed'>
			<td>Bitte beachten:</td><td> ".$msg."</td>
		</tr>
		</table>";
		x264_footer();
		die();
}



function dict_get($d, $k, $t)
{
  if ($d["type"] != "dictionary")
  {
    abort("Unerwarteter Fehler beim Dekodieren der Metadaten: Das ist kein Dictionary (".$d["type"].")!");
  }
  $dd = $d["value"];
  if (!isset($dd[$k]))
  {
    return;
  }
  $v = $dd[$k];
  if ($v["type"] != $t)
  {
    abort("Unerwarteter Fehler beim Dekodieren der Metadaten: Der Datentyp des Eintrags (".$v["type"].") enspricht nicht dem erwarteten Typ ($t)!");
  }
  return $v["value"];
}

//$group=intval($_POST["group"]);



foreach(explode(":", "descr:type:name") as $v)
{
  if (!isset($_POST[$v]))
  {
    stderr("Fehlende Formulardaten", "Die übergebenen Daten sind unvollständig. Bitte benutze das Upload-Formular, und fülle alle nötigen Felder aus!");
  }
}

if (!isset($_FILES["file"]))
{
  stderr("Fehlende Formulardaten", "Die übergebenen Daten sind unvollständig. Bitte benutze das Upload-Formular, und fülle alle nötigen Felder aus!");
}

x264_header();
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Dein Upload wird überprüft!
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>";
tr_msg("Dateiname der Torrent-Metadatei");
$f = $_FILES["file"];
$fname = unesc($f["name"]);
$highlight = unesc($_POST['highlight']);
if (empty($fname)) {
    tr_status("err");
    abort("Torrent-Metadatei hat keinen Dateinamen bzw. es wurde kein Torrent hochgeladen!");
}
if (!validfilename($fname)) {
    tr_status("err");
    abort("Der Dateiname der Torrent-Datei enthält ungültige Zeichen!");
}
if (!preg_match('/^(.+)\.torrent$/si', $fname, $matches)) {
    tr_status("err");
    abort("Der Torrent-Dateiname muss mit \".torrent\" enden.");
}
$tmpname = $f["tmp_name"];
if (!is_uploaded_file($tmpname)) {
    tr_status("err");
    abort("Beim Upload der Torrent-Metadatei ist etwas schiefgegangen...");
}
tr_status("ok");

tr_msg("Max. Größe der Torrent-Metadatei");
if ($f["size"] > $GLOBALS["MAX_TORRENT_SIZE"])
{
  tr_status("err");
  abort("Torrent-Metadatei ist zu groß (max. ".$GLOBALS["MAX_TORRENT_SIZE"]." Bytes)!");
}
if (!filesize($tmpname))
{
  tr_status("err");
  abort("Leere Torrent-Metadatei hochgeladen!");
}
tr_status("ok");

tr_msg("Dateiname der NFO-Datei");
$nfofile = $_FILES['nfo'];
/*
if ($nfofile['name'] == '')
{
  tr_status("err");
  abort("Die NFO hat keinen Dateinamen oder es wurde keine NFO-Datei hochgeladen!");
}
*/
tr_status("ok");

if ($nfofile['name'])
{
  tr_msg("Größe der NFO-Datei");
  if ($nfofile['size'] == 0)
  {
    tr_status("err");
    abort("0-byte NFO");
  }
  if ($nfofile['size'] > 65535)
  {
    tr_status("err");
    abort("NFO ist zu groß! Maximal 65535 Bytes (64 KB) sind erlaubt.");
  }
  tr_status("ok");

  $nfofilename = $nfofile['tmp_name'];

  tr_msg("Uploadstatus der NFO-Datei");
  if (@!is_uploaded_file($nfofilename))
  {
    tr_status("err");
    abort("NFO-Upload fehlgeschlagen");
  }
  
  tr_status("ok");
}

tr_msg("IMDB");
$imdb_ist = $GLOBALS["IMDB_DETAILS"];
$found = unesc($_POST["imdb"]);	
if($imdb_ist == '1'){	
	$nfofile = str_replace("\x0d\x0d\x0a", "\x0d\x0a", @file_get_contents($nfofilename));
	$to_check = sqlesc($nfofile);
	$found = strpos($to_check, 'imdb.com/title/tt')+17;
	if($found == 17){
		$found = strpos($to_check, 'imdb.de/title/tt')+16;
	}
	$imbd = substr($to_check, $found, 7);
	if(is_numeric($imbd)){
		$set_imdb = $imbd;		
	}else{
		$set_imdb = '';
	}	
}else{
	$set_imdb = '';	
}
tr_status("ok");

tr_msg("Torrent-Beschreibung");
$descr = unesc($_POST["descr"]);
if (!$descr && $nfofile['name'] == '')
{
  tr_status("err");
  abort("Du musst eine Beschreibung eingeben!");
}
if (strlen($descr) > 20000)
{
  tr_status("err");
  abort("Die angebene Beschreibung ist zu groß. Maximal 20000 Zeichen sind erlaubt!");
}
tr_status("ok");

if ($_POST["stripasciiart"] == "1")
{
  $descr = strip_ascii_art($descr);
}

tr_msg("Kategorie-Zuordnung");
$catid = intval($_POST["type"]);
if (!is_valid_id($catid))
{
  tr_status("err");
  abort("Du musst eine Kategorie angeben, welcher der Torrent zugeordnet werden soll.");
}
tr_status("ok");

$shortfname = $torrent = $matches[1];
if (!empty($_POST["name"]))
{
  $torrent = unesc($_POST["name"]);
}

tr_msg("Torrent-Metadatei dekodieren");
$dict = bdec_file($tmpname, $GLOBALS["MAX_TORRENT_SIZE"]);
if (!isset($dict))
{
  tr_status("err");
  abort("Was zum Teufel hast du da hochgeladen? Das ist jedenfalls keine gültige Torrent-Datei!");
}
tr_status("ok");

function dict_check($d, $s, $type = "")
{
  if ($type != "")
  {
    tr_msg("Integritätsprüfung der Metadaten ($type)");
  }
  if ($d["type"] != "dictionary")
  {
    tr_status("err");
    abort("Die Datei ist kein Benc-Dictionary.");
  }
  $a = explode(":", $s);
  $dd = $d["value"];
  $ret = array();
  foreach ($a as $k)
  {
    unset($t);
    if (preg_match('/^(.*)\((.*)\)$/', $k, $m))
    {
      $k = $m[1];
      $t = $m[2];
    }
    if (!isset($dd[$k]))
    {
      tr_status("err");
      abort("Es fehlt ein benötigter Schlüssel im Dictionary!");
    }
    if (isset($t))
    {
      if ($dd[$k]["type"] != $t)
      {
        tr_status("err");
        abort("Das Dictionary enthält einen ungültigen Eintrag (Tatsächlicher Datentyp entspricht nicht dem erwarteten)!");
      }
      $ret[] = $dd[$k]["value"];
    }
    else
    {
      $ret[] = $dd[$k];
    }
  }
  if ($type != "")
  {
    tr_status("ok");
  }
  return $ret;
}

list($ann, $info) = dict_check($dict, "announce(string):info", "Globales Dictionary");
list($dname, $plen, $pieces) = dict_check($info, "name(string):piece length(integer):pieces(string)", "Info-Dictionary");

tr_msg("Announce-URL");
/*
if (!in_array($ann, $GLOBALS["ANNOUNCE_URLS"], 1))
{
  tr_status("err");
  $errstr = "Ungültige Announce-URL! Muss eine der Folgenden sein:</p><ul>";
  sort($GLOBALS["ANNOUNCE_URLS"]);
  foreach ($GLOBALS["ANNOUNCE_URLS"] as $aurl)
  {
    $errstr .= "<li>".htmlspecialchars($aurl)."</li>";
  }
  abort($errstr . "</ul><p>");
}
*/
tr_status("ok");

tr_msg("Plausibilitätsprüfung und Einlesen der Dateiliste");
$totallen = dict_get($info, "length", "integer");
$filelist = array();
if ($totallen > 0)
{
  $filelist[] = array($dname, $totallen);
  $type = "single";
}
else
{
  $flist = dict_get($info, "files", "list");
  if (!isset($flist))
  {
    tr_status("err");
    abort("Es fehlen sowohl der \"length\"- als auch der \"files\"-Schlüssel im Info-Dictionary!");
  }
  if (!count($flist))
  {
    tr_status("err");
    abort("Der Torrent enthält keine Dateien");
  }
  $totallen = 0;
  foreach ($flist as $fn)
  {
    list($ll, $ff) = dict_check($fn, "length(integer):path(list)");
    $totallen += $ll;
    $ffa = array();
    foreach ($ff as $ffe)
    {
      if ($ffe["type"] != "string")
      {
        tr_status("err");
        abort("Ein Eintrag in der Dateinamen-Liste hat einen ungültigen Datentyp (".$ffe["type"].")");
      }
      if (preg_match('/^[.\\/^~][\/\^]*/', $ffe["value"]))
      {
        tr_status("err");
        abort("Eine Datei in der Torrent-Metadatei hat einen ungültigen Namen (".$ffe["value"].")");
      }
      $ffa[] = $ffe["value"];
    }
    if (!count($ffa))
    {
      bark("filename error");
    }
    $ffe = implode("/", $ffa);
    $filelist[] = array($ffe, $ll);
  }
  $type = "multi";
}
tr_status("ok");

tr_msg("Doppel Torrent Überprüfung");
$dateilist = $filelist;
shuffle($dateilist);
$datei = $dateilist[0];
$num = count($dateilist);
$sql = "SELECT torrent FROM files WHERE filename = ".sqlesc($datei[0])." AND size = ".$datei[1]." LIMIT 1";
$treffer = $db -> querySingleItem($sql);
if(intval($treffer))
{
  $sql  = "SELECT id, name, numfiles FROM torrents WHERE id=".$treffer." LIMIT 1";
  $data = $db -> querySingleArray($sql);

  if ($data['numfiles'] == $num)
  {
    tr_status("err");
    abort("<br>D-T: <a href='tfilesinfo.php?id=".$data['id']."'>".$data['name']."</a>");
  }
}
tr_status("ok");

tr_msg("Plausibilitätsprüfung der Piece-Hashes");
if (strlen($pieces) % 20 != 0)
{
  tr_status("err");
  abort("Die Länge der Piece-Hashes ist kein Vielfaches von 20!");
}
$numpieces = strlen($pieces)/20;
if ($numpieces != ceil($totallen/$plen))
{
  tr_status("err");
  abort("Die Anzahl Piecehashes stimmt nicht mit der Torrentlänge überein (".$numpieces." ungleich ".ceil($totallen/$plen).")!");
}
tr_status("ok");
// PreTime
	///// Funktionen für OrlyDB
	function get_match($regex,$content){
        	preg_match($regex,$content,$matches);
        	return $matches[1];
	}

	//gets the data from a URL
	function get_data($url){
        	$ch = curl_init();
        	$timeout = 3;
        	curl_setopt($ch,CURLOPT_URL,$url);
        	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        	$data = curl_exec($ch);
        	curl_close($ch);
        	return $data;
	}
	
$DBPreTime = 'Keine Pretime gefunden';

$FileName = str_replace('-', ' ', $shortfname);

//$OrlyDBContent = file_get_contents('http://predb.me/?search=' . $FileName);
$OrlyDBContent = "http://api.xrel.to/api/release/info.xml?dirname=".urlencode($$FileName);
//$orlyurl = "http://api.xrel.to/api/release/info.xml?dirname=" . $FileName);

//$orly_content = file_get_contents($OrlyDBContent);
$orly_content = get_data($OrlyDBContent);
//$SS = '/<span class="timestamp">(.*)<\/span>/isU';
$SS['time'] = @get_match('/<span class="timestamp">(.*)<\/span>/isU',$orly_content);
//$SS = @get_match('/<time>(.*)<\/time>/isU',$orly_content);
//$SS2 = '/<span class="timestamp">(.*)<\/span>/isU';
//$SS3 = '/<span class="timestamp">(.*)<\/span>/isU';

if (preg_match($SS, $OrlyDBContent, $PreTime))
{
    // Release gefunden
    $DBPreTime = $PreTime[1];

    tr_msg('Suche PreTime');
    tr_status('ok');

}
// EOF PreTime

$dict["value"]["info"]["value"]["private"] = array("type" => "integer", "value" => "1");
$dict["value"]["info"]["value"]["unique id"] = array("type" => "string", "value" => mksecret());
$infohash = pack("H*", sha1(benc($dict["value"]["info"])));
$torrent = str_replace("_", " ", $torrent);
$nfo = str_replace("\x0d\x0d\x0a", "\x0d\x0a", @file_get_contents($nfofilename));

tr_msg("Only Upload und Allmulti Check");
$free          = ($totallen >= 16106127360?"yes":"no");
$sql           = "SELECT multiplikator FROM torrents WHERE allmulti='yes' LIMIT 1";
$multi         = $db -> querySingleItem($sql);
$multiplikator = ($multi?$multi:1);
$sql           = "SELECT COUNT(*) FROM torrents WHERE wonly='yes'";
$wonly         = (($db -> querySingleItem($sql)) != 0?"yes":"no");
if ($wonly == "yes")
{
  $free = "yes";
}
tr_status("ok");

tr_msg("Torrent-Informationen in die Datenbank schreiben");
$data = array(
  "search_text"   => searchfield("$shortfname $dname $torrent"),
  "filename"      => $fname,
  "owner"         => $CURUSER["id"],
  "tsize"         => number_format($f["size"]),
  "language"      => $_POST["language"],
  "seedspeed"     => $_POST['seedspeed'],
  "visible"       => "no",
  "info_hash"     => $infohash,
  "preTime"       => $DBPreTime,
  "name"          => $torrent,  
  "size"          => $totallen,
  "numfiles"      => count($filelist),
  "type"          => $type,
  "descr"         => $descr,
  "ori_descr"     => $descr,
  "category"      => intval($_POST["type"]),
  "save_as"       => $dname,
  "added"         => get_date_time(),
  "last_action"   => get_date_time(),
  "nfo"           => $nfo,
  "imdb"	   	  => $set_imdb,
  "highlight"	  => $highlight, 
  "free"          => $free,
  "wonly"         => $wonly
);
$db -> insertRow($data,"torrents");

$id = $db -> insertID();
  
$db -> execute("DELETE FROM files WHERE torrent = ".$id);

mysql_query("DELETE FROM traffic WHERE torrentid = ".$id);
mysql_query("DELETE FROM oldtraffic WHERE torrentid = ".$id);

foreach ($filelist as $file)
{
  $data = array(
    "torrent"  => $id,
    "filename" => $file['0'],
    "size"     => $file['1']
  );

  $db -> insertRow($data, "files");
}
tr_status("ok");

tr_msg("Torrent-Datei auf dem Server speichern");
$fhandle = @fopen($GLOBALS["SHORTNAME"]."/".$GLOBALS["TORRENT_DIR"]."/".$id.".torrent", "w");
if ($fhandle)
{
  @fwrite($fhandle, benc($dict));
  @fclose($fhandle);
}
else
{
  tr_status("err");
  abort("Fehler beim Öffnen der Torrent-Datei auf dem Server (Schreibzugriff verweigert) - bitte SysOp benachrichtigen!");
}
tr_status("ok");
mysql_query("UPDATE torrents SET free = 'yes' WHERE id = ".$id." AND size > '5368709120'");
mysql_query("UPDATE torrents SET freeleech = 'yes' WHERE id = ".$id." AND size < '52428800'");
$bonus  = floatval(get_config_data("GU_UPLOAD_BONUS"));
$sql    = "UPDATE users SET uploaded = uploaded + ".$bonus.", upperbonus = upperbonus + 1, seedbonus = seedbonus + 30.0 WHERE id = ".$CURUSER['id']." LIMIT 1";
$db -> execute($sql);

write_log("torrentupload", "Der Torrent <a href=\"tfilesinfo.php?id=".$id."\">".$id." (".$torrent.")</a> wurde von '<a href=\"userdetails.php?id=".$CURUSER['id']."\">".$CURUSER['username']."</a>' hochgeladen.");

$picnum = 0;
if ($_FILES["pic1"]["name"] != "")
{
  tr_msg("Vorschaubild ".($picnum+1)." verkleinern und ablegen");
  if (torrent_image_upload($_FILES["pic1"], $id, $picnum+1))
  {
    $picnum++;
  }
  if (!empty($_POST['pic1']))
  {
    $pic1 = unesc($_POST['pic1']);
  }
}
else
{
  tr_msg("Vorschaubild ".($picnum+1)." verkleinern und ablegen");
  if (torrent_image_upload($_FILES["pic1"], $id, $picnum+1))
  {
    $picnum++;
  }
  if (!empty($_POST['pic1']))
  {
    $pic1 = unesc("" . $GLOBALS["DEFAULTBASEURL"] . "" . $GLOBALS["DESIGN_PATTERN"] . "/nofiles.png");
  }	
}

if ($_FILES["pic2"]["name"] != "")
{
  tr_msg("Vorschaubild ".($picnum+1)." verkleinern und ablegen");
  if (torrent_image_upload($_FILES["pic2"], $id, $picnum+1))
  {
    $picnum++;
  }
}

if ($picnum)
{
  $db ->updateRow(array("numpics" => $picnum),"torrents","id = ".$id);
}

tr_msg("NFO-Bild erzeugen");
if (gen_nfo_pic($nfo, $GLOBALS["SHORTNAME"]."/nfo/nfo-$id.png") == 0)
{
  tr_status("err");
}
else
{
    tr_status("ok");
}

$requestid = intval($_POST["request"]);
if ($requestid)
{
  $sql = "SELECT users.username, requests.userid, requests.request FROM requests inner join users on requests.userid = users.id where requests.id = ".$requestid;
  $arr = $db -> querySingleArray($sql);

  $filledurl= $BASEURL."/tfilesinfo.php?id=".$id;

  $data = array(
    "filled"   => $filledurl,
    "filledby" => $CURUSER['id']
  );

  $db -> updateRow($data, "requests", "id = ".$requestid);

  $msg = "Dein Request, [sttts=reqdetails.php?id=".$requestid."]".$arr['request']."[/sttts] wurde soeben erfüllt. Du kannst das File mit folgender URL ".$filledurl." herunterladen.  Please do not forget to leave thanks where due.  If for some reason this is not what you requested, please reset your request so someone else can fill it by following [URL=reqreset.php?requestid=" . $requestid . "]this[/url] link.  Bitte folge dem Link nicht wenn es nicht dein Request ist.";
  sendPersonalMessage(0, $arr['userid'] , "Request erfüllt", $msg, PM_FOLDERID_SYSTEM, 0);
}


if ($activated == "no")
{
  tr_msg("Gastuploader-Team und Moderatoren benachrichtigen");
  sendPersonalMessage(0, 0, "Der Benutzer ".$CURUSER["username"]." hat einen Torrent hochgeladen.", $mod_msg, PM_FOLDERID_MOD, 0, "open");
  tr_status("ok");
}

if ($_POST['zaprosi'] == "da")
{
  $data = array(
    "torrentid" => $id,
    "zaprosil"  => $CURUSER["id"]
  );
  $db -> insertRow($data, "onlyup");

  $mod_msg = "[b]Der Benutzer [sttts=userdetails.php?id=".$CURUSER["id"]."]".$CURUSER["username"]."[/sttts] hat einen Torrent hochgeladen mit einer Anfrage auf Only Upload:[/b][br][sttts=tfilesinfo.php?id=".$id."]".$torrent."[/sttts] (".$id.")[br]Bitte OnlyUpload Anfrage überprüfen --[br] Freigeben oder Verweigern [sttts=only.php]OnlyUpload Anfragen[/sttts]";

  $data = array(
    "sender"  => $CURUSER['id'],
    "added"   => get_date_time(),
    "msg"     => $mod_msg,
    "subject" => "Only Upload Anfrage"
  );
  $db -> insertRow($data, "staffmessages");
}

if($CURUSER['anon'] == "yes")
{
  $text = "Ein Anonymer User hat einen neuen Torrent hochgeladen: ".$torrent."";
}
else
{
  $text = "Der User ".$CURUSER['username']." hat einen neuen Torrent hochgeladen: ".$torrent."";
}

if ($_POST["type"] == 27)
{
  $sbid = 2;
}
else
{
  $sbid=0;
}

$data = array(
  "userid"   => $sbid,
  "username" => "System",
  "date"     => time(),
  "text"     => $text,
  "text_c"   => format_comment(htmlentities($text), false)
);
$db -> insertRow($data, "shoutbox");

print"
                            </tr>
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Dein Torrent Upload war erfolgreich!
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
print "
	<div class='x264_title_table'>Dein Torrent wurde erfolgreich hochgeladen. <b>Beachte</b> dass Dein Torrent erst sichtbar wird, wenn der erste Seeder verfügbar ist!</div>";

if (count($GLOBALS["uploaderrors"]))
{
  print "
	<div class='x264_title_table'>Beim Upload des Torrents ist mindestens ein unkritischer Fehler aufgetreten:</div>
  <ul>";

  foreach($GLOBALS["uploaderrors"] as $error)
  {
    print "
    <li>".$error."</li>";
  }
  print "
  </ul>";
}

if ($activated == "no") {
?>
<p><b>Da Du kein Uploader bist, wurde Dein Torrent als Gastupload gewertet, und muss
zuerst von einem Gastupload-Betreuer &uuml;berpr&uuml;ft und freigeschaltet werden.
Erst dann kannst Du den Torrent zum Seeden herunterladen.</b> Bitte sende uns keine
Nachrichten mit der Bitte um Freischaltung. Das Team wurde bereits per PN &uuml;ber
Deinen Upload benachrichtigt, und wird sich baldm&ouml;glichst darum k&uuml;mmern.</p>
<?php 
}else{
echo '<meta http-equiv="refresh" content="1; URL=tfilesinfo.php?id='.$id.'&amp;go=ok">';
}

print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
x264_footer();
hit_end();
?>