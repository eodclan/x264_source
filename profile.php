<?php
// ************************************************************************************//
// * D€ Source 2018
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2017 - 2018 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************// 
require_once(dirname(__FILE__) . "/include/engine.php");
dbconn(false);
loggedinorreturn();

function uhrzeit($index = 0)
{
  $out ="
                            <option value='no' ".((intval($index == 0)) ? "selected='selected'" : "").">0</option>";
  for ($i=1; $i <= 24; $i++)
    $out .= "
                            <option value='".$i."'".((intval($index == $i)) ? "selected" : "").">".$i.":00</option>";
  return $out;
}

function line($text, $success=true)
{
  global $updatetxt;

  $updatetxt[] = array("text" => $text, "success" => $success);
}

function check_nickname($nick = "")
{
  global $CURUSER;
  if (!$nick)
    return true;
    
  $r = mysql_query("SELECT id FROM users WHERE username = ".sqlesc($nick)." OR ircmainnick = ".sqlesc($nick)." OR ircaltnick = ".sqlesc($nick)." LIMIT 1") or sqlerr(__FILE__, __LINE__);
  $a = mysql_fetch_array($r);

  if ($a['id'] == $CURUSER['id'])
    return true;

  if(is_numeric($a['id']))
    return false;
  else
    return true;
}

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  $sql = "SELECT
                  *
          FROM
                  users
          WHERE
                  id = ".$CURUSER['id'];

  $arr = $db -> querySingleArray($sql);


  $updateset = array();
  $updatetxt = array();

  $statbox = htmlentities(trim($_POST['statbox']));
  if ($arr['statbox'] != $statbox)
  {
    $updateset['statbox'] = $statbox;
    line("Ratiostatbox");
  }

  $acceptpms = htmlentities(strip_tags(trim($_POST['acceptpms'])));
  if ($arr['acceptpms'] != $acceptpms)
  {
    $updateset['acceptpms'] = $acceptpms;
    line("PN's akzeptieren");
  }

  $deletepms = ($_POST['deletepms'] == "yes"?"yes":"no");
  if ($arr['deletepms'] != $deletepms)
  {
    $updateset['deletepms'] = $deletepms;
    line("PN löschen");
  }

  $savepms = ($_POST['savepms'] == "yes"?"yes":"no");
  if ($arr['savepms'] != $savepms)
  {
    $updateset['savepms'] = $savepms;
    line("PN Speichern");
  }

  $acceptemails = htmlentities(strip_tags(trim($_POST['acceptemails'])));
  if ($arr['accept_email'] != $acceptemails)
  {
    $updateset['accept_email'] = $acceptemails;
    line("Emails akzeptieren");
  }


  $notifs = ($_POST['pmnotif'] == 'yes' ? "[pm]" : "");
  $notifs .= ($_POST['emailnotif'] == 'yes' ? "[email]" : "");

  if ($arr['notifs'] != $notifs)
  {
    $updateset['notifs'] = $notifs;
    line("Emailbenachrichtigung");
  }

  $xxx = ($_POST['xxx'] == "yes"?"yes":"no");
  if ($GLOBALS['SHOURTNAME'] == "|X264|") $xxx = "yes";
  if ($arr['xxx'] != $xxx)
  {
    $updateset['xxx'] = $xxx;
    line("XXX Files");
  }

  $useruploads = ($_POST['useruploads'] == "yes"?"yes":"no");
  if ($arr['hideuseruploads'] != $useruploads)
  {
    $updateset['hideuseruploads'] = $useruploads;
    line("Useruploads");
  }

  $torrentlist = ($_POST['torrentlist'] == "yes"?"yes":"no");
  if ($arr["oldtorrentlist"] != $torrentlist)
  {
    $updateset['oldtorrentlist'] = $torrentlist;
    line("Torrent Browse System");
  }
  
  $ajax_tfiles = ($_POST['ajax_tfiles'] == "yes"?"yes":"no");
  if ($arr["ajax_tfiles"] != $ajax_tfiles)
  {
    $updateset['ajax_tfiles'] = $ajax_tfiles;
    line("Ajax Torrent Home Display");
  }

  $design_loader = ($_POST['design_loader'] == "ajax"?"ajax":"static");
  if ($arr["design_loader"] != $design_loader)
  {
    $updateset['design_loader'] = $design_loader;
    line("Site Loader");
  }  

  $torrentsperpage = intval($_POST['torrentsperpage']);
  if ($arr['torrentsperpage'] != $torrentsperpage)
  {
    $updateset['torrentsperpage'] = $torrentsperpage;
    line("Torrents pro Seite");
  }
  
  $avatars = ($_POST['avatars'] == "yes"?"yes":"no");
  if ($arr['avatars'] != $avatars)
  {
    $updateset['avatars'] = $avatars;
    line("Avataranzeige");
  }  
  
  $secure_code = htmlentities(strip_tags(intval($_POST["secure_code"])));
  if ($arr["secure_code"] != $secure_code)
  {
    if ($secure_code > 999999999999 || $secure_code <= 000000000000)
    {
      line("Secure Code zu gross oder zu klein, max 12 Stellen...", false);
    }
    else
    {
      $updateset['secure_code'] = $secure_code;
      line("Secure Code ");
    }
  }

if (get_user_class() >= UC_PARTNER) {
  $bootstrap_design = intval($_POST['bootstrap_design']);
  if ($arr['bootstrap_design'] != $bootstrap_design)
  {
    $updateset['bootstrap_design'] = $bootstrap_design;
    line("Backend ACP Design");
  }  
} 
  
  $design = intval($_POST['design']);
  if ($arr['design'] != $design)
  {
    $updateset['design'] = $design;
    line("Design");
  } 

  $country = intval($_POST['country']);
  if ($arr['country'] != $country)
  {
    $updateset['country'] = $country;
    line("Land");
  }
  
  $avatar = htmlentities(strip_tags(trim($_POST['avatar'])));
  if ($arr['avatar'] != $avatar)
  {
    if (!is_image($avatar))
    {
      line("Deine Avatar URL ist nicht erlaubt!",false);
    }
    else
    {
      $updateset['avatar'] = $avatar;
      line("Avatar URL");
    }
  }   

  $anonymous = ($_POST['anonymous'] == "yes"?"yes":"no");
  if ($arr['anonymous'] != $anonymous)
  {
    $updateset['anonymous'] = $anonymous;
    line("Profil verstecken");
  }

  $anon = ($_POST['anon'] == "yes"?"yes":"no");
  if ($arr['anon'] != $anon)
  {
    $updateset['anon'] = $anon;
    line("Anonym in den Torrents");
  }

  $log_ratio = ($_POST['log_ratio'] == "yes"?"yes":"no");
  if ($arr['log_ratio'] != $log_ratio)
  {
    $updateset['log_ratio'] = $log_ratio;
    line("Ratio Histogram");
  }

  $wgeturl = ($_POST['wgeturl'] == "yes"?"yes":"no");
  if ($arr['wgeturl'] != $wgeturl)
  {
    $updateset['wgeturl'] = $wgeturl;
    line("wGet Url");
  }
 
  $info = htmlentities(strip_tags(trim($_POST["info"])));
  if ($arr["info"] != $info)
  {
    if ($info > 250)
    {
      line("Info zu gross oder zu klein.", false);
    }
    else
    {		
      $updateset['info'] = $info;
      line("Info ");
    }
  }  

  $pcoff = ($_POST['pcoff'] == "yes"?"yes":"no");
  if ($arr['pcoff'] != $pcoff)
  {
    $updateset['pcoff'] = $pcoff;
    line("PC Status");
  }

  if (!check_seedtime($arr['seed_angaben']))
  {
    $all_seed        = ($_POST["all_seed"]    == "yes" ? "1" : "0");
    $seed_wo_start   = ($_POST["seed_wo_st"]  == "no" ? 0 : intval($_POST["seed_wo_st"]));
    $seed_wo_end     = ($_POST["seed_wo_end"] == "no" ? 0 : intval($_POST["seed_wo_end"]));
    $seed_we_start   = ($_POST["seed_we_st"]  == "no" ? 0 : intval($_POST["seed_we_st"]));
    $seed_we_end     = ($_POST["seed_we_end"] == "no" ? 0 : intval($_POST["seed_we_end"]));

    $seed_angaben    = $all_seed . "," . $seed_wo_start . "," . $seed_wo_end . "," . $seed_we_start . "," . $seed_we_end;

    if ($seed_angaben != "0,0,0,0,0")
    {
      if(check_seedtime($seed_angaben))
      {
        $updateset['seed_angaben'] = $seed_angaben;
        line("Seedzeit");
      }
      else
      {
        line("Sie haben ungültige Seedzeiten angegeben (Mindestend 6 Stunden pro Tag)",false);
      }
    }
  }

  $dsl_speed = htmlentities(trim($_POST['dsl_speed']));
  if ($arr['dsl_speed'] != $dsl_speed)
  {
    $updateset['dsl_speed'] = $dsl_speed;
    line("DSL Speed");
  }

  $email = htmlentities(trim($_POST['email']));
  if ($email != $CURUSER["email"])
  {
    if (!validemail($email))
    {
		  line("Das scheint keine gültige E-Mail Adresse zu sein.",false);
    }
    else
    {
      $sql = "SELECT
                      COUNT(*)
              FROM
                      users
              WHERE
                      email=" . sqlesc($email);
      if ($db -> querySingleItem($sql) > 0)
      {
		    line("Die E-Mail Adresse ".$email." wird bereits verwendet.",false);
      }
      else
      {
          $sec         = mksecret();
	      $hash        = md5($sec . $email . $sec);
          $obemail     = urlencode($email);
          $updateset[] = "editsecret = " .$sec;
	      $body =
          "Du hast in Auftrag gegeben, dass Dein Profil (Benutzername ".$CURUSER["username"].")\n".
          "auf ".$GLOBALS["SITENAME"]." mit dieser E-Mail Adresse ".$email." als Kontaktadresse aktualisiert\n".
          "werden soll.\n\n".
          "Wenn Du dies nicht beauftragt hast, ignoriere bitte diese Mail. Die Person, die\n".
          "Deine E-Mail Adresse eingegeben hat, hatte die IP-Adresse ".$_SERVER["REMOTE_ADDR"].".\n".
          "Bitte antworte nicht auf diese automatisch generierte Nachricht.\n\n".
          "Um die Aktualisierung Deines Profils abzuschließen, klicke auf folgenden Link:\n\n".

          "".$GLOBALS["DEFAULTBASEURL"]."/confirmemail.php?id=".$CURUSER["id"]."&secret=".$hash."&email=".$obemail."\n\n".
          "Die neue E-Mail Adresse wird dann in Deinem Profil erscheinen. Wenn Du\n".
          "diesen Link nicht anklickst, wird Dein Profil unverändert bleiben.";

	      mail($email, $GLOBALS["SITENAME"]." Profiländerungsbestätigung", $body, "From: ".$GLOBALS["SITEEMAIL"]);
	      line("Email zur Emailverifikation verschickt");
      }
    }
  }

  $chpassword = trim($_POST['chpassword']);
  $passagain  = trim($_POST['passagain']);

  if ($chpassword && $passagain)
  {
    if (strlen($chpassword) > 40)
    {
      line("Sorry, Dein Passwort ist zu lang (Maximal 40 Zeichen)",false);
    }
    else
    {
      if ($chpassword != $passagain)
      {
		    line("Die Passwörter stimmen nicht überein! Du musst Dich vertippt haben. bitte versuche es erneut!",false);
      }
      else
      {

        $sec = mksecret();
        $passhash = md5($sec . $chpassword . $sec);

        $updateset['secret']   = $sec;
        $updateset['passhash'] = $passhash;
	      logincookie($CURUSER["id"], $passhash);
	      line("Passwort geändert");
      }
    }
  }

  if (count($updateset) > 0)
  {
    $db -> updateRow($updateset,"users","id = ".$CURUSER['id']);
  }
  else
  {
    line("Profil wurde nicht geändert");
  }

  session_unset();
  $sql = "SELECT
                  *
          FROM
                  users
          WHERE
                  id = ".$CURUSER["id"];
  $userdata = $db -> querySingleArray($sql);
  $_SESSION["userdata"] = $userdata;
  $GLOBALS['CURUSER']   = $userdata;
}

$sql = "SELECT
                  COUNT(*) AS messages,
                  (SELECT
                            COUNT(*)
                   FROM
                            messages
                   WHERE
                            receiver = ".$CURUSER["id"]."
                   AND
                            folder_in <> 0
                   AND
                            unread = 'yes'
                  ) AS unread,
                  (SELECT
                            COUNT(*)
                   FROM
                            messages
                   WHERE
                            sender = ".$CURUSER["id"]."
                   AND
                            folder_out<>0
                  ) AS outbox
        FROM
                  messages
        WHERE
                  receiver = ".$CURUSER["id"]."
        AND
                  folder_in<>0";

$arr = $db -> querySingleArray($sql);

$messages    = $arr['messages'];
$unread      = $arr['unread'];
$outmessages = $arr['outbox'];


$sql = "SELECT
                  *
        FROM
                  users
        WHERE
                  id = ".$CURUSER['id'];

$arr = $db -> querySingleArray($sql);


x264_header($arr["username"] . "s Profil", false);

if(isset($_GET['disable']) AND $_GET['disable'] == 'ok'){
	$mod_msg = "Der Benutzer: ".$CURUSER["username"]." möchte seinen Account aufgeben. Bitte Benutzer überprüfen und dann entscheiden, ob die Daten gelöscht werden können. Bitte keine Benutzer-Daten unnötig horten!";
	$userid = $CURUSER['id'];
	$subject = "Benutzer möchte Account aufgeben";
	$message = sqlesc($mod_msg);
	$subject = sqlesc($subject);
	$staffmessages = array('sender'  => $userid,
				  'added'   => time(),
				  'msg'     => $message,
				  'subject' => $subject);
	
	$db -> insertRow($staffmessages, "staffmessages");
	print"
<div id='toast-container' class='toast-top-full-width'>
	<div class='toast toast-success' aria-live='polite' style=''>
		<div class='toast-title'>Du hast dein Account aufgegeben! </div>
		<div class='toast-message'>Das Team wurde darüber informiert und wird jetzt alles nötige in die Wege leiten.</div>
	</div>
</div>";
}

$trackerdienste = $GLOBALS["PROFILE_CHANGE"];
if ($trackerdienste[0] == "0")
{
  stderr("Achtung","Profil bearbeiten ist zur Zeit deaktiviert.");
  die();
}
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-bar-chart'></i>Profil Navi
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
<script>
function ShowIDU(){
	if(document.getElementById('x264_profile_startseite').style.display == 'none'){
	document.getElementById('x264_profile_startseite').style.display = 'block';
	document.getElementById('x264_profile_torrents').style.display = 'none';
	document.getElementById('x264_profile_leitung').style.display = 'none';
	document.getElementById('x264_profile_sicherheit').style.display = 'none';
	document.getElementById('x264_profile_design').style.display = 'none';
	CheckIfEdit('taken');
	}else{
	document.getElementById('x264_profile_startseite').style.display = 'none';
	CheckIfEdit('giveup');
	}
}

function ShowTORRENTS(){
	if(document.getElementById('x264_profile_torrents').style.display == 'none'){
	document.getElementById('x264_profile_torrents').style.display = 'block';
	document.getElementById('x264_profile_leitung').style.display = 'none';
	document.getElementById('x264_profile_sicherheit').style.display = 'none';
	document.getElementById('x264_profile_design').style.display = 'none';
	document.getElementById('x264_profile_startseite').style.display = 'none';	
	CheckIfEdit('taken');
	}else{
	document.getElementById('x264_profile_torrents').style.display = 'none';
	CheckIfEdit('giveup');
	}
}

function ShowLEITUNG(){
	if(document.getElementById('x264_profile_leitung').style.display == 'none'){
	document.getElementById('x264_profile_leitung').style.display = 'block';
	document.getElementById('x264_profile_torrents').style.display = 'none';
	document.getElementById('x264_profile_sicherheit').style.display = 'none';
	document.getElementById('x264_profile_design').style.display = 'none';
	document.getElementById('x264_profile_startseite').style.display = 'none';	
	CheckIfEdit('taken');
	}else{
	document.getElementById('x264_profile_leitung').style.display = 'none';
	CheckIfEdit('giveup');
	}
}

function ShowSECURE(){
	if(document.getElementById('x264_profile_sicherheit').style.display == 'none'){
	document.getElementById('x264_profile_sicherheit').style.display = 'block';
	document.getElementById('x264_profile_torrents').style.display = 'none';
	document.getElementById('x264_profile_leitung').style.display = 'none';
	document.getElementById('x264_profile_design').style.display = 'none';
	document.getElementById('x264_profile_startseite').style.display = 'none';	
	CheckIfEdit('taken');
	}else{
	document.getElementById('x264_profile_sicherheit').style.display = 'none';
	CheckIfEdit('giveup');
	}
}

function ShowDESIGN(){
	if(document.getElementById('x264_profile_design').style.display == 'none'){
	document.getElementById('x264_profile_design').style.display = 'block';
	document.getElementById('x264_profile_torrents').style.display = 'none';
	document.getElementById('x264_profile_leitung').style.display = 'none';
	document.getElementById('x264_profile_sicherheit').style.display = 'none';
	document.getElementById('x264_profile_startseite').style.display = 'none';	
	CheckIfEdit('taken');
	}else{
	document.getElementById('x264_profile_design').style.display = 'none';
	CheckIfEdit('giveup');
	}
}
</script>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>
								<td><a href='profile.php' class='navLink'><i class='fa fa-single fa-home' title='Home'></i></a></td>	
								<td><a href='#startseite' onclick='ShowIDU(); display: none;' class='navLink'><i class='fa fa-star'></i>  Startseite</a></td>
								<td><a href='#torrents' onclick='ShowTORRENTS(); display: none;' class='navLink'><i class='fa fa-archive'></i>  Torrents</a></td>
								<td><a href='#leitung' onclick='ShowLEITUNG(); display: none;' class='navLink'><i class='fa fa-wifi'></i>  Leitung</a></td>
								<td><a href='#design' onclick='ShowDESIGN(); display: none;' class='navLink'><i class='fa fa-bar-chart'></i>  Design</a></td>		
								<td><a href='#secure' onclick='ShowSECURE(); display: none;' class='navLink'><i class='fa fa-bank'></i>  Sicherheit</a></td>	
                            </tr>
                        </tbody>
                    </table>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>	
								<td>Willkommen in dein Profil Bearbeiten <a href='userdetails.php?id=".$arr['id']."'>".$arr['username']."</a>!</td>
								<td>Du kannst nur was Speichern, wenn du auch eine Einstellung geändert hast!</td>
                            </tr>
                        </tbody>
                    </table>					
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";					
if (count($updatetxt) > 0)
{
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-bar-chart'></i>Profil Bearbeiten - Speicherung
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>";
	foreach ($updatetxt as $row)
	{	
    print "
                            <tr>	
								<td>".$row['text'].":</td><td>".($row['success']?"Erfolgreich":"Fehlgeschlagen")."</td>
                            </tr>";
	}
print "
                        </tbody>
                    </table>								
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}
					
print"	
<div id='x264_profile_startseite' style='display: none;'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-bar-chart'></i>Profil Bearbeiten - Startseite
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>";
print "
	<form method='POST' action='".$_SERVER['PHP_SELF']."'>";

print "
								<td>XXX Files:</td><td>Nein <input type='radio' class='btn btn-flat btn-primary fc-today-button' id='sbyes' name='xxx' value='yes'".($arr["xxx"]=="yes"?" checked='checked'":"")."> Ja <input type='radio' id='sbno' name='xxx' value='no'".($arr["xxx"]=="no" || !$arr["xxx"]?" checked='checked'":"")."></td>
                            </tr>
                            <tr>							
								<td>Land:</td><td><select name='country' class='btn btn-flat btn-primary fc-today-button btn-secondary dropdown-toggle'>
						<option value='0'>---- Keines ausgew&auml;hlt ----</option>";
$sql = "SELECT
                  id,
                  name
        FROM
                  countries
        ORDER BY
                  name";
$ct_r = $db -> queryObjectArray($sql);
if ($ct_r)
{
  foreach ($ct_r as $ct_a)
  {
    print "
                            <option value='".$ct_a['id']."'".($arr["country"] == $ct_a['id'] ? " selected" : "").">".$ct_a['name']."</option>";
  }
}

print "
					</select></td>
                            </tr>
                            <tr>							
								<td>Avatar URL:</td><td><input name='avatar' size='60' value='".htmlspecialchars($arr["avatar"])."' class='btn btn-flat btn-primary fc-today-button'></td>
                            </tr>
                            <tr>							
								<td>Avatare anzeigen:</td><td><input type='checkbox' class='btn btn-flat btn-primary fc-today-button' name='avatars'".($arr["avatars"] == "yes" ? " checked='checked'" : "")." value='yes'> User mit niedriger Bandbreite, sollten diese Option deaktivieren.</td>
                            </tr>
                            <tr>							
								<td>Anonym bleiben:</td><td>Ja <input type='checkbox' class='btn btn-flat btn-primary fc-today-button' name='anonymous'".($arr["anonymous"] == "yes" ? " checked" : "")." value='yes'> Bei den Torrents und auch beim Profil <input type='checkbox' class='btn btn-flat btn-primary fc-today-button' name='anon' value='yes'".($arr["anon"]=="yes"?" checked":"")."></td>
                            </tr>
                            <tr>							
								<td>Ajax Torrent Home Display:</td><td>Ajax D€ Torrent Display <input type='radio' class='btn btn-flat btn-primary fc-today-button' name='ajax_tfiles'".($arr["ajax_tfiles"] == "yes" ? " checked='checked'" : "")." value='yes'> Ajax NV Torrent Display <input type='radio' class='btn btn-flat btn-primary fc-today-button' name='ajax_tfiles'".($arr["ajax_tfiles"] == "no" ? " checked='checked'" : "")." value='ajax_tfiles'></td>
                            </tr>							
                            <tr>							
								<td>Signatur:</td><td><textarea name='info' cols='60' rows='4' class='btn btn-flat btn-primary fc-today-button'>".$arr["info"]."</textarea></td>
                            </tr>
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>					
</div>";								


print"	
<div id='x264_profile_torrents' style='display: none;'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-bar-chart'></i>Profil Bearbeiten - Torrents
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>							
								<td>Useruploads:</td><td><input type='radio' id='useruploadsno' name='useruploads' value='no'".($arr["hideuseruploads"]=="no"?" checked='checked'":"")."><br /> Nur Uploads von Uploadern und Staffmitgliedern anzeigen <input type='radio' id='useruploadsyes' name='useruploads' value='yes'".($arr["hideuseruploads"]=="yes"?" checked='checked'":"")."></td>
                            </tr>
                            <tr>							
								<td>Torrent Browse System:</td><td><input type='radio' id='torrentlistold' name='torrentlist' value='no'".($arr["oldtorrentlist"]=="no"?" checked='checked'":"")."> Ajax System</td>
                            </tr>
                            <tr>							
								<td>Ratio-Histogramm:</td><td>Ja <input type='checkbox' name='log_ratio'".($arr["log_ratio"] == "yes" ? " checked" : "")." value='yes'> Nein <input type='checkbox' name='log_ratio'".($arr["log_ratio"] == "no" ? " checked" : "")." value='no'></td>
                            </tr>
                            <tr>							
								<td>wget-Kommando:</td><td>Ja <input type='checkbox' name='wgeturl'".($arr["wgeturl"] == "yes" ? " checked" : "")." value='yes'></td>
                            </tr>
                            <tr>							
								<td>Torrents pro Seite:</td><td><input type='text' size='10' class='btn btn-flat btn-primary fc-today-button' name='torrentsperpage' value=".$arr['torrentsperpage']."> Default = 0</td>
                            </tr>";

print "
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</div>";

print"	
<div id='x264_profile_design' style='display: none;'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-bar-chart'></i>Profil Bearbeiten - Design
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>							
								<td>Information:</td><td>Bei ein Ajax Design wird jeden Aufruf per Ajax abgefragt und bei Static passiert eine Ajax abfrage nicht.</td>
							</tr>
                            <tr>							
								<td>Site Loader:</td><td>Ajax <input type='radio' class='btn btn-flat btn-primary fc-today-button' name='design_loader'".($arr["design_loader"] == "ajax" ? " checked='checked'" : "")." value='ajax'> Static <input type='radio' class='btn btn-flat btn-primary fc-today-button' name='design_loader'".($arr["design_loader"] == "static" ? " checked='checked'" : "")." value='static'></td>
                            </tr>";
if (get_user_class() >= UC_PARTNER) {			
print "
                            <tr>							
								<td>Backend ACP Design:</td><td><select name='bootstrap_design' class='btn btn-flat btn-primary fc-today-button'>";
$sql = "SELECT
                    *
        FROM
                    bootstrap_design";

$ss_r = $db -> queryObjectArray($sql);
$ss_sa = array();
if ($ss_r)
{
  foreach ($ss_r as $ss_a)
  {
    $ss_id           = $ss_a["id"];
    $ss_name         = $ss_a["name"];
    $ss_sa[$ss_name] = $ss_id;
  }
}
ksort($ss_sa);
reset($ss_sa);
while (list($ss_name, $ss_id) = each($ss_sa))
{
  print "
                            <option value='".$ss_id."'".($ss_id == $arr["bootstrap_design"]?" selected":"").">".$ss_name."</option>";
}
print "
				</select>
								</td>
							</tr>";			
}			
print "
                            <tr>							
								<td>Design:</td><td><select name='design' class='btn btn-flat btn-primary fc-today-button'>";
$sql = "SELECT
                    *
        FROM
                    design";

$ss_r = $db -> queryObjectArray($sql);
$ss_sa = array();
if ($ss_r)
{
  foreach ($ss_r as $ss_a)
  {
    $ss_id           = $ss_a["id"];
    $ss_name         = $ss_a["name"];
    $ss_sa[$ss_name] = $ss_id;
  }
}
ksort($ss_sa);
reset($ss_sa);
while (list($ss_name, $ss_id) = each($ss_sa))
{
  print "
                            <option value='".$ss_id."'".($ss_id == $arr["design"]?" selected":"").">".$ss_name."</option>";
}
print "
				</select>
								</td>
							</tr>				
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>				
</div>";

print"	
<div id='x264_profile_leitung' style='display: none;'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-wifi'></i>Profil Bearbeiten - Leitung
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>							
								<td>PC Status:</td><td>PC Nachts an <input type='radio' name='pcoff'".($arr["pcoff"] == "yes" ? " checked='checked'" : "")." value='yes'> PC Nachts aus <input type='radio' name='pcoff'".($arr["pcoff"] == "no" ? " checked='checked'" : "")." value='no'></td>
                            </tr>";

$zeiten = explode(",",$arr['seed_angaben']);
print "
                            <tr>							
								<td>Seed Zeiten:</td><td>
														Ich Seede 24 Stunden ohne Einschr&auml;nkungen. ".(!check_seedtime($arr['seed_angaben'])?"
														<input type='checkbox' name='all_seed' value='yes' ".($zeiten[0] == 1 ? " checked='checked'" : "").">
														<hr>
														Montag -- Freitag&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<select name='seed_wo_st' class='btn btn-flat btn-primary fc-today-button'>".uhrzeit($zeiten[1])."
														</select> bis
														<select name='seed_wo_end' class='btn btn-flat btn-primary fc-today-button'>".uhrzeit($zeiten[2])."
														</select>
														<hr>
														Samstag und Sonntag
														<select name='seed_we_st' class='btn btn-flat btn-primary fc-today-button'>".uhrzeit($zeiten[3])."
														</select> bis
														<select name='seed_we_end' class='btn btn-flat btn-primary fc-today-button'>".uhrzeit($zeiten[4]) . "
														</select>
														<hr>
														Mindestens 6 Stunden / Tag müssen angegeben werden":"
														Seed Zeit Angaben sind bereits gesetzt und nicht mehr Änderbar.")."</td>
                            </tr>
                            <tr>							
								<td>DSL Speed:</td><td>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "0" ? " checked='checked'" : "")." value='0'> Keine Angabe<br>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "DSL 1000" ? " checked='checked'" : "")." value='DSL 1000'> DSL 1000<br>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "DSL 2000" ? " checked='checked'" : "")." value='DSL 2000'> DSL 2000<br>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "DSL 6000" ? " checked='checked'" : "")." value='DSL 6000'>DSL 6000<br>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "DSL 16000"? " checked='checked'" : "")." value='DSL 16000'>DSL 16000<br>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "VDSL 20000" ? " checked='checked'" : "")." value='VDSL 20000'>VDSL 20000<br>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "VDSL 25000" ? " checked='checked'" : "")." value='VDSL 25000'>VDSL 25000<br>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "VDSL 30000" ? " checked='checked'" : "")." value='VDSL 30000'>VDSL 30000<br>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "VDSL 50000" ? " checked='checked'" : "")." value='VDSL 50000'>VDSL 50000<br>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "VDSL 100000" ? " checked='checked'" : "")." value='VDSL 100000'>VDSL 100000<br>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "VDSL 150000" ? " checked='checked'" : "")." value='VDSL 150000'>VDSL 150000<br>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "VDSL 200000" ? " checked='checked'" : "")." value='VDSL 200000'>VDSL 200000<br>
									<input type='radio' name='dsl_speed'".($arr["dsl_speed"] == "Root" ? " checked='checked'" : "")." value='Root'>Webseeder (Bitte dem Team noch mitteilen!)
								</td>
                            </tr>								
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</div>";

print"	
<div id='x264_profile_sicherheit' style='display: none;'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-bar-chart'></i>Profil Bearbeiten - Sicherheit
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>							
								<td>Secure Code:</td><td><input type='text' size='12' class='btn btn-flat btn-primary fc-today-button' maxlength='4' name='secure_code' value=".$arr['secure_code']."></td>
                            </tr>
                            <tr>							
								<td>E-Mail Addresse:</td><td><input type='text' class='btn btn-flat btn-primary fc-today-button' name='email' size='50' value='".htmlspecialchars($arr["email"])."'></td>
                            </tr>
                            <tr>							
								<td>Passwort &auml;ndern:</td><td><input type='password' name='chpassword' size='50' id='newpwd1' class='btn btn-flat btn-primary fc-today-button'></td>
                            </tr>
                            <tr>							
								<td>Passwort wiederholen:</td><td><input type='password' name='passagain' size='50' class='btn btn-flat btn-primary fc-today-button'></td>
                            </tr>
                            <tr>							
								<td>PNs akzeptieren:</td><td>Alle <input type='radio' name='acceptpms'".($arr["acceptpms"] == "yes" ? " checked='checked'" : "")." value='yes'> Nur Freunde <input type='radio' name='acceptpms'".($arr["acceptpms"] == "friends" ? " checked='checked'" : "")." value='friends'> Nur Team <input type='radio' name='acceptpms'".($arr["acceptpms"] == "no" ? " checked='checked'" : "")." value='no'></td>
                            </tr>
                            <tr>							
								<td>PNs l&ouml;schen:</td><td>Bei Antwort PN l&ouml;schen <input type='checkbox' name='deletepms'".($arr["deletepms"] == "yes" ? " checked='checked'" : "")." value='yes'></td>
                            </tr>
                            <tr>							
								<td>PNs speichern:</td><td>Bei Antwort PN speichern <input type='checkbox' name='savepms'".($arr["savepms"] == "yes" ? " checked='checked'" : "")." value='yes'></td>
                            </tr>
                            <tr>							
								<td>E-Mails akzeptieren:</td><td>Alle <input type='radio' name='acceptemails'".($arr["accept_email"] == "yes" ? " checked='checked'" : "")." value='yes'> Nur Freunde <input type='radio' name='acceptemails'".($arr["accept_email"] == "friends" ? " checked='checked'" : "")." value='friends'> Nur Team <input type='radio' name='acceptemails'".($arr["accept_email"] == "no" ? " checked='checked'" : "")." value='no'></td>
                            </tr>
                            <tr>							
								<td>eMail Benachrichtigung:</td><td>Wenn ich eine PN erhalten habe. <input type='checkbox' name='pmnotif'".(strpos($arr['notifs'], "[pm]") !== false ? " checked='checked'" : "")." value='yes'> Wenn ein Torrent in den unten markierten Kategorien hochgeladen wurde. <input type='checkbox' name='emailnotif'".(strpos($arr['notifs'], "[email]") !== false ? " checked='checked'" : "")." value='yes'></td>
                            </tr>
                            <tr>							
								<td>Account aufgeben:</td><td><a href='profile.php?disable=ok'>Mein Account jetzt aufgeben</a></td>
                            </tr>							
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</div>";

if ($trackerdienste[0] != "0")
{
  print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-bar-chart'></i>Profil Bearbeiten - Speichern
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>							
								<td>Einstellung speichern:</td><td><input type='submit' value='Ok!' class='btn btn-flat btn-primary fc-today-button'> <input type='reset' value='Zur&uuml;cksetzen!' class='btn btn-flat btn-primary fc-today-button'></td>
                            </tr>

		</form>
                        </tbody>
                    </table>		
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}					

x264_footer();
?>