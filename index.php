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
ob_start("ob_gzhandler");
require "include/bittorrent.php";

hit_start();
dbconn(true);
loggedinorreturn();

$agent = $_SERVER['HTTP_USER_AGENT'];

if(preg_match("/MSIE/i",$agent)) 
{
	header('Location: browser.php');
	exit;
}

x264_header("Home");

if ($GLOBALS['MEMBERS_NEWS_PUBLIC'] == 'yes' || $CURUSER) {

// Trackernews
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-newspaper-o'></i>News
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";


$sql = "SELECT * FROM news WHERE ADDDATE(added, INTERVAL 45 DAY) > NOW() ORDER BY added DESC LIMIT 10";
$res = $db -> queryObjectArray($sql);

if ($res)
{
  $first = TRUE;
  foreach($res as $arr)
  {
    $user_id    = $arr['userid'];
    $sql        = "SELECT username FROM users WHERE id=".$user_id;
    $username   = $db -> querySingleItem($sql);
    $news_date  = date("Y-m-d",strtotime($arr['added']));
    $news_year  = substr($news_date,0,4);
    $news_month = substr($news_date,5,2);
    $news_day   = substr($news_date,8,2);
    $news_date  = $news_day . "." . $news_month . "." . $news_year;
    $news_day   = date("l",mktime(0,0,0,$news_month,$news_day,$news_year));

    if ($news_day == "Monday")    $news_day = "Montag";
    if ($news_day == "Tuesday")   $news_day = "Dienstag";
    if ($news_day == "Wednesday") $news_day = "Mittwoch";
    if ($news_day == "Thursday")  $news_day = "Donnerstag";
    if ($news_day == "Friday")    $news_day = "Freitag";
    if ($news_day == "Saturday")  $news_day = "Samstag";
    if ($news_day == "Sunday")    $news_day = "Sonntag";


    if ($first)
    print "
					<div class='table table-bordered table-striped table-condensed col-md-12'>
                        <div class='drag ui-sortable-handle'>
                             <div class='sorting_1'><span class='normalfont'><i class='fa fa-newspaper-o'></i> ".htmlspecialchars($arr["title"])." </span><span style='float:right;' class='normalfont'><i class='fa fa-calendar-times-o'></i> Von <a class='altlink' href='userdetails.php?id=".$user_id."'>".$username."</a>, ".$news_day.", ".$news_date."</span></div>
						</div>
					</div>";
    if ($first)
      print "";
    else
      print "";		
    print "
					<div class='table table-bordered table-striped table-condensed col-md-12'>
                        <div class='drag ui-sortable-handle'> 
							<div class='sorting_1'>".(format_comment($arr['body']))."</div>
						</div>
					</div>";
    $first = FALSE;
  }

} else {
print "
					<i class='fa fa-check-square-o'></i> Keine News vorhanden!";

}
print "
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}
// Trackernews Ende

if ($GLOBALS['MEMBERS_PUBLIC'] == 'yes' || $CURUSER) {
	
if($CURUSER[ajax_tfiles] == "yes"){
// Torrentliste start
if($CURUSER[xxx] == "yes" && $row["cat_name"] == "XXX"){
$numpics = "" . $GLOBALS["DESIGN_PATTERN"] . "/nofiles.png";
} else {
$numpics = "".$GLOBALS["TORRENT_POSTERS"]."/t-".$row['id']."-3.jpg";
}

$name = '';
$i=1;
// torrentnamen aus der db holen und optionsfelder generieren

$query = mysql_query("SELECT 
DISTINCT(`torrents`.`id`) AS id,
`torrents`.`name`, `torrents`.`category`,`torrents`.`times_completed`, `torrents`.`size`, `torrents`.`free`, `torrents`.`numpics`,
(SELECT `name` FROM `categories` WHERE `id`=`torrents`.`category`) AS catname,
(SELECT COUNT(`id`) FROM `peers` WHERE `torrent`=`torrents`.`id` AND `seeder` = 'yes') AS seeder,
(SELECT COUNT(`id`) FROM `peers` WHERE `torrent`=`torrents`.`id` AND `seeder` != 'yes') AS leecher
FROM `torrents`
WHERE `torrents`.`numpics` <> '' AND `torrents`.`activated` !='no'
ORDER BY `torrents`.`added` DESC LIMIT 40") or sqlerr(__FILE__,__LINE__);



while($arr = mysql_fetch_assoc($query))
{
   $tname = str_replace('.',' ',$arr['name']);  
   $name .= "
                    <div class='dropdown-header' name='torrent' onchange='goToTorrent(this.options[this.selectedIndex].value);'>
                         ".trim_it($tname,75)." | File-Size: ".mksize($arr['size'])." | Seeder: ".$arr['seeder']." Leecher: ".$arr['leecher']." | Only Upload: <font color=".($arr["free"] == "yes"?"lime>Ja":"red>Nein")."</font>
                    </div>";
   $namex .= "
            <div>
                <img data-u='image' src='".$GLOBALS["TORRENT_POSTERS"]."f-".$arr['id']."-1.jpg' />
                <div data-u='thumb'>
                    <img class='i' src='".$GLOBALS["TORRENT_POSTERS"]."f-".$arr['id']."-1.jpg' />
                    <div class='t'>".trim_it($tname,44)."</div>
                    <div class='c'>Seeder: ".$arr['seeder']." Leecher: ".$arr['leecher']."</div>
                </div>
            </div>";					
   $i++;
}
	
// Ausgabe des Step Viewers
echo "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-cloud-download'></i>The Last Torrents
                                    <div class='card-actions'>									
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
    					<div id='jssor_1' style='position:relative;margin:0 auto;top:0px;left:0px;width:810px;height:300px;overflow:hidden;visibility:hidden;background-color:rgb(35,35,35);-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;'>
        					<div data-u='loading' style='position:absolute;top:0px;left:0px;background:url('/design/loading.gif') no-repeat 50% 50%;background-color:rgba(0, 0, 0, 0.7);'></div>
        					<div data-u='slides' style='cursor:default;position:relative;top:0px;left:0px;width:600px;height:300px;overflow:hidden;'>";
						include("ajax_tfiles.php");
			
echo "
        				</div>
        				<div data-u='thumbnavigator' class='jssort11' style='position:absolute;right:5px;top:0px;font-family:Arial, Helvetica, sans-serif;-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none;user-select:none;width:200px;height:300px;' data-autocenter='2'>
            				<div data-u='slides' style='cursor: default;'>
                				<div data-u='prototype' class='p'>
                    					<div data-u='thumbnailtemplate' class='tp'></div>
                				</div>
            				</div>
        				</div>
        				<span data-u='arrowleft' class='jssora02l' style='top:0px;left:8px;width:55px;height:55px;' data-autocenter='2'></span>
        				<span data-u='arrowright' class='jssora02r' style='top:0px;right:218px;width:55px;height:55px;' data-autocenter='2'></span>
					</div>								
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
} else {
// neue torrentliste bei Feudas start
if ($CURUSER)
{
  $torrent_date  = sqlesc(date("Y-m-d")." 00:00:00");
  $torrent_res   = mysql_query("SELECT id FROM torrents WHERE added >= ".$torrent_date) or sqlerr(__FILE__, __LINE__);
  $torrent_count = mysql_num_rows($torrent_res);
  $anz           = 10;
  $stunden       = (intval($CURUSER['tstdn']) != 0 ? intval($CURUSER['tstdn']):24);


?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-download'></i>The Last Torrents
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
          <ul id="maintab">
            <center>
              <li class="selected"><a href="ajax_listen_tfiles.php?action=last&anz=<?=$anz?>" class='btn btn-flat btn-primary fc-today-button' rel="ajaxcontentarea">Die neuesten <?=$anz?> Torrents</a></li>
<?
    if($CURUSER["xxx"] == 'no') 
    { 
?> 
              <li><a href="ajax_listen_tfiles.php?action=xxxday&stunden?<?=$stunden?>" class='btn btn-flat btn-primary fc-today-button' rel="ajaxcontentarea">XXX der letzten <?=$stunden?> Stunden</a></li>
              <li><a href="ajax_listen_tfiles.php?action=xxxlast&anz=<?=$anz?>" class='btn btn-flat btn-primary fc-today-button' rel="ajaxcontentarea">Die neusten <?=$anz?> XXX</a></li>
              <br>
              <br>
              <li><a href="ajax_listen_tfiles.php?action=highlight&anz=<?=$anz?>" class='btn btn-flat btn-primary fc-today-button' rel="ajaxcontentarea">Aktuelle Kinohits</a></li>
              <li><a href="ajax_listen_tfiles.php?action=onlyup&anz=<?=$anz?>" class='btn btn-flat btn-primary fc-today-button' rel="ajaxcontentarea">Die neusten Only Ups</a></li>
<? 
    } 
    else 
    { 
?>
              <li><a href="ajax_listen_tfiles.php?action=highlight&anz=<?=$anz?>" class='btn btn-flat btn-primary fc-today-button' rel="ajaxcontentarea">Aktuelle Kinohits</a></li>
              <li><a href="ajax_listen_tfiles.php?action=onlyup&anz=<?=$anz?>" class='btn btn-flat btn-primary fc-today-button' rel="ajaxcontentarea">Die neusten Only UP Torrents</a></li>
<? 
    } 
?>
            </center>
          <div id="ajaxcontentarea" class="x264_wrapper_ajax_tfiles"></div>
          <script type="text/javascript">
            startajaxtabs("maintab")
          </script>
        </ul>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>	
<?
}
}	
// Shoutbox
$button = $BASEURL . "/" . $GLOBALS["PIC_BASE_URL"] . "editor";
$smilie = $BASEURL . "/" . $GLOBALS["PIC_BASE_URL"] . "smilies";

$liste = "var smilieliste = [ ";
foreach($privatesmilies AS $code => $url)
{
  $liste .= "{ 'bild' : '" . $url . "', 'code' : '" . $code . "' }, ";
}
$liste = substr($liste, 0, -2) . " ];";

$sql      = "SELECT afk FROM users WHERE id=".$CURUSER['id'];
$afk      = $db -> querySingleItem($sql);

if ($afk == 'yes')
  $afktext = "Bin zurück!";
else
  $afktext = "Mich AFK setzen";
print "

<div id='tt2ajax_f_onlineusers' style='display:inline;'></div>
<script type='text/javascript' language='javascript'>
	tt2ajax_frames.init_ajaxframe('onlineusers',120,'online_users.php',false);
</script>	
			<script type='text/javascript' src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/js/shobox.js'></script>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-wechat'></i>Shoutbox								
                                    <div class='card-actions'>
										<a class='nav-link dropdown-toggle nav-link' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
											<i class='fa fa-tag'></i>
										</a>
										<div class='dropdown-menu dropdown-menu-right'>
											<div class='dropdown-header text-center'>
												<strong>Shoutbox Options</strong>
											</div>
											<script type='text/javascript'>edToolbar('shbox_text','" . $button . "','true');</script>
										</div>									
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>										
                                    </div>
                                </div>
                                <div class='card-block'>									
                      <div class='text' width='100%'>
                        <div style='text-align: left; height:25px; width: 100%; overflow: auto;' id='sbox'>
							<input type='hidden' id='sbbutton' onclick='javascript:showshout()'>
                        </div>						
						<div id='sbsmilies' style='display:none;'>
							<div id='sb-loading-layer'>
								<div class='sk-fading-circle'>
									<div class='sk-circle1 sk-circle'></div>
									<div class='sk-circle2 sk-circle'></div>
									<div class='sk-circle3 sk-circle'></div>
									<div class='sk-circle4 sk-circle'></div>
									<div class='sk-circle5 sk-circle'></div>
									<div class='sk-circle6 sk-circle'></div>
									<div class='sk-circle7 sk-circle'></div>
									<div class='sk-circle8 sk-circle'></div>
									<div class='sk-circle9 sk-circle'></div>
									<div class='sk-circle10 sk-circle'></div>
									<div class='sk-circle11 sk-circle'></div>
									<div class='sk-circle12 sk-circle'></div>
								</div>
							</div>
						</div>						
                        <div id='sbform' style='display:none;'>
                          <form name='shbox' method='post' action='\shoutbox.php?action=takeadd' onsubmit='sendsbtext();return false;'>
                            <center>
                              <input type='text' name='shbox_text' id='shbox_text' size='90' class='btn btn-flat btn-primary fc-today-button'>
                              <input type='submit' name='submit' style='width:115px'  value='Okay!' class='btn btn-flat btn-primary fc-today-button'>";
?>							  
							  <a href='javascript:showframe("smilies","open");' class='btn btn-flat btn-primary fc-today-button'><i class='fa fa-smile-o'></i></a><br><br>
<?
print "
                              <center>
                              ".(get_user_class() >= UC_MODERATOR?"
                              <input type='button' value='L&ouml;sche SB' id='sbtruncate' onclick='delsb();' class='btn btn-flat btn-primary fc-today-button'>":"
                              <input type='hidden' value='' id='sbtruncate'>")."
                              <input type='button' id='afkbutton' value='".$afktext."' onclick='afk()' class='btn btn-flat btn-primary fc-today-button'>
                              <input type='hidden' id='afkhidden' value='".$afk."' class='btn btn-flat btn-primary fc-today-button'>
							  <a href='#sbrefresh' onclick='refresh();' class='btn btn-flat btn-primary fc-today-button'><i class='fa fa-refresh'></i></a>".(get_user_class()>=UC_MODERATOR?"
                              <input type='button' value='Text als System: OFF' id='jamesbutton' onclick='jamestxt();' class='btn btn-flat btn-primary fc-today-button'>
                              <input type='button' value='Teambox anzeigen' id='teamboxbutton' onclick='showteambox();' class='btn btn-flat btn-primary fc-today-button'>":"")."
                              <input type='hidden' name='jameshidden' id='jameshidden' value='no' class='btn btn-flat btn-primary fc-today-button'>
                              <input type='hidden' id='teamboxhidden' name='teamboxhidden' value='no' class='btn btn-flat btn-primary fc-today-button'><br><br>
                            </center>
                          </form>
                        </div>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
		<div id='sbframe'></div></div>  
                  ".($CURUSER['bgshout'] == "1"?"
                  <script type='text/javascript'>showshout();</script>":"");
// Ende Shoutbox
// new poll system by tantetoni2
function getRandomImageFileName($path)
  {
    $result = "";
    $ar = array();
    $handle=opendir($path);
    while ($file = readdir ($handle))
    {
       if ($file != "." && $file != "..")
       {
          if (! is_dir($file))
          {
            $sub = substr($file, -4);
            if ($sub == ".png" || $sub == ".jpg" || $sub == ".gif" || $sub == ".bmp")
               $ar[] = $file;
          }
       }
    }
    closedir($handle);
    $max = count($ar);
    if ($max > 0)
    {
       srand ((double)microtime()*1000000);
       $max -= 1;
       $p = rand(0,$max);
       $result = $ar[$p];
    }
    return $result;
  }
 
$pollsettings = mysql_query("SELECT * FROM
pollsnewsettings WHERE setting != ''") or die(mysql_error()); 
while($settingsresult = mysql_fetch_array($pollsettings)){
$pollset[$settingsresult['setting']]=$settingsresult['value'];
}
if($pollset['ajax'] == 'yes'){
?>
<script type="text/javascript" src="<?=$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/"?>js/ajaxpollnew.js"></script>
<script language='javascript'>
getvote();
</script>
<?php
echo"
  <table width=100% align=center>
    <tr>
      <td  align=center>
        <div style='width:100%%;height:100%;overflow: auto;'><div id='poll' style='overflow: auto;'></div></div>
      </td>
    </tr>
 
  </table>
";
 
}else{
$pollsettings = mysql_query("SELECT * FROM
pollsnewsettings WHERE setting != ''") or die(mysql_error()); 
while($settingsresult = mysql_fetch_array($pollsettings)){
$pollset[$settingsresult['setting']]=$settingsresult['value'];
}
$poll = mysql_query("
SELECT 
pollsnew.*,
pollsnew.id AS pollid,
pollsnewvotes.*,
pollsnewvotes.userid AS voterid
FROM pollsnew 
LEFT JOIN pollsnewvotes ON pollsnewvotes.userid=".$CURUSER['id']." AND pollsnewvotes.voteid=pollsnew.id
".($pollset['rand'] == 'yes' && !$_GET['voted'] && !$_GET['votethis'] ? "WHERE dauer > '".time()."'" : "").($_GET['voted'] ? "WHERE pollsnew.id=".(0+$_GET['voted']) : "").($_GET['votethis'] ? "WHERE pollsnew.id=".(0+$_GET['votethis']) : "")."
ORDER BY ".($pollset['rand'] == 'yes' && !$_GET['votet'] && !$_GET['votethis'] ? "RAND()" :  "pollsnew.id" )."  DESC limit 1") or die(mysql_error()); 
$Result = mysql_fetch_array($poll);
$BereitsAbgestimmt = "";
$Result['votes'] = (!$Result['votes'] ? 0 : $Result['votes']);
 
if(time() > $Result['dauer'] || $Result['votes'] >= $Result['maxvotes'] || $_GET['view'] == 'results' || $Result['end'] == 'yes')
{ 
 
    $BereitsAbgestimmt = "j"; 
} 
 
if($_POST['voteid'])
{
  $id = 0 + $_POST['voteid'];
  $time = time();
 
 
  $ifvotet = mysql_fetch_array(mysql_query("SELECT userid,votes FROM pollsnewvotes WHERE voteid=$id and userid='".$CURUSER['id']."'"));
 
 
  $BereitsAbgestimmt = $_POST['BereitsAbgestimmt'];
 
  if($_POST['Antwort'] == '0'){
 
  if($ifvotet)
    mysql_query("UPDATE pollsnewvotes SET votes='".$_POST['maxvotes']."', realvotes='".$ifvotet['votes']."' WHERE voteid=$id and userid=".$CURUSER['id']."");
  else
    mysql_query("INSERT INTO pollsnewvotes (abgestimmt, userid, voteid, votes, realvotes) VALUES ('$time', '".$CURUSER['id']."', '$id', '".$_POST['maxvotes']."', '".$ifvotet['votes']."')"); 
 
   header("location: ".$_SERVER['PHP_SELF']."?voted=$id#poll");
   exit;
  }
  else{
 
 
    if($_POST["Antwort"] == '') {
    header("location: ".$_SERVER['PHP_SELF']."?voted=$id#poll");
    exit;
    }
 
    if($BereitsAbgestimmt == 'j'){
 
      $SQL = "antworten".$_POST['Antwort']."=antworten".$_POST['Antwort']."+1";
 
        mysql_query("UPDATE pollsnew SET $SQL WHERE id='".$id."'"); 
 
        if($ifvotet)
          mysql_query("UPDATE pollsnewvotes SET votes=votes+1, realvotes=realvotes+1 WHERE voteid=$id and userid=".$CURUSER['id']."");
        else
          mysql_query("INSERT INTO pollsnewvotes (abgestimmt, userid, voteid, votes, realvotes) VALUES ('$time', '".$CURUSER['id']."', '$id', '1', '1')"); 
 
        header("location: ".$_SERVER['PHP_SELF']."?voted=$id#poll");
        exit;
    }
  }
}
if($Result['pollid']){
print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-question'></i>Umfrage
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
echo"<center><b>".$Result['frage']."</b><br><br></center>";
echo"<a name=poll id=poll></a>
<table border='0' cellpadding='0' cellspacing='0' width='100%' class='text-center'> 
  <tr>"; 
if($BereitsAbgestimmt == 'j' ) 
{ 
  $StimmenInsgesamt=0;
 
    for ($i=1;$i<=$Result['anzantworten'];$i++) {
      if($Result["antwort".$i.""]){
        $StimmenInsgesamt = $StimmenInsgesamt+$Result["antworten$i"];
      }
 
    }
 
  for ($i=1;$i<=$Result['anzantworten'];$i++) {
 
    if($Result["antwort".$i.""]){ 
 
          if($StimmenInsgesamt != 0) { 
 
            $Prozent = $Result["antworten".$i.""]/$StimmenInsgesamt*100; 
 
          }else{ 
 
            $Prozent = 0; 
 
          } 
 
          $ProzentBalken = sprintf("%.0f", $Prozent*3.5); 
          $Prozent = sprintf("%.0f", $Prozent); 
 
 
 
  if ($Result['balken'] == 'z'){
 
    $fileName = getRandomImageFileName("pic/balken/");
 
echo"
    <tr> 
      <td width='50%'>
        <b>&nbsp;&nbsp;".$Result["antwort".$i.""]."</b>
      </td> 
      <td width='50%'><img height='11' src='pic/balken/".$fileName."' width='5'><img height='11' src='pic/balken/".$fileName."' title='".$Result["antworten".$i.""]." Stimmen' width='$ProzentBalken'><img height='11' src='pic/balken/".$fileName."' width='5'>
      <small>$Prozent%</small>
      </td> 
    </tr>";
 
   }else{
 
echo"
    <tr> 
      <td width='50%' >
        <b>&nbsp;&nbsp;".$Result["antwort".$i.""]."</b>
      </td> 
      <td width='50%'><img height='11' src='pic/balken/".$Result['balken'].".gif' width='5'><img height='11' src='pic/balken/".$Result['balken'].".gif' title='".$Result["antworten".$i.""]." Stimmen' width='$ProzentBalken'><img height='11' src='pic/balken/".$Result['balken'].".gif' width='5'>
      <small>$Prozent%</small>
      </td> 
    </tr>";
 
        }   
    }
 
  } 
echo"</table>";     
} 
else 
{ 
echo"
<form method='post' action='".$_SERVER['PHP_SELF']."' name='voting' >
<input name='BereitsAbgestimmt' id='BereitsAbgestimmt' type='hidden' value='j'>
<input type=hidden id='maxvotes' name='maxvotes' value='".$Result['maxvotes']."'>";
for ($i=1;$i<=$Result['anzantworten'];$i++) {
  if($Result["antwort".$i.""]){ 
 
  echo" 
    <tr> 
      <td align='right'>
        <input name='Antwort' id='Antwort' type='radio' value='$i' >
      </td> 
      <td>
        <b>".$Result["antwort".$i.""]."</b>
      </td> 
    </tr>"; 
 
    }
}
echo"
    <input name='res' id='res' type='hidden' value=''>
    <input name='voteid' id='voteid' type='hidden' value='".$Result['pollid']."'> 
    <tr> 
      <td align='right'>
        <input name='Antwort' type='radio' value='0'>
      </td> 
      <td>
        Ich will keine Stimme abgeben, ich möchte nur das Ergebnis sehen!
      </td> 
    </tr>
  </table>
    <center><br>
        Du hast ".($Result['votes'] == 0 ? "noch keine Stimme abgegeben" : "beteits ".$Result['votes']." von maximal <b>".$Result['maxvotes']."</b> Stimmen abgegeben")."
      <br>
      <input name='Abstimmen' type='submit' value='Abstimmen'>
 
</form>"; 
 
} 
 
if($BereitsAbgestimmt == 'j'){
  $spacer = "abgegebene Stimmen $StimmenInsgesamt ".($Result['votes'] < $Result['maxvotes'] ? "<br><br><a href=\"".$_SERVER['PHP_SELF']."?votethis=".$Result['pollid']."\"><b>Voten</b></a>" :"");
}else{
  $spacer = "&nbsp;<br><a href=\"".$_SERVER['PHP_SELF']."?voted=".$Result['pollid']."&view=results\"><b>Ergebnisse anzeigen</b></a>";
}
 
echo "<br><center>$spacer</center>";
 
if( get_user_class() >= UC_MODERATOR)
echo"<br><center><a href=\"addpollnew.php\">Adminstration</a></center>";
 
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}
}
// new poll system by tantetoni2 end

// Last Banned User
$sql = "SELECT username FROM users WHERE enabled = 'no' ORDER BY last_access LIMIT 30";
$res = $db -> queryObjectArray($sql);

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-pause'></i>Zuletzt gebannten User
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
if ($res)
{
  foreach ($res as $arr)
  {
    print "
                          <font class='ucuser'>".$arr['username']."</font> ";
  }
}
else
{
    print "<b>Zur Zeit keine gabannten User auf den Tracker</b>";
}
print "
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
//Ende
}
x264_footer();
?>