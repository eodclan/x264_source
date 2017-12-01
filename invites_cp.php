<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");
dbconn();
loggedinorreturn();

if (get_user_class() < UC_POWER_USER)
  stderr("Nicht möglich","Du musst Poweruser sein um jemand Inviten zu können");
  
$action = ($_GET['action']?htmlentities(trim($_GET['action'])):"start");

if ($action == "start")
{
 x264_header("Invites");

  print "
                      <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-usd'></i> Invite System
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block text-center'>
                  <table cellpadding='4' cellspacing='1' border='0' style='width:100%' class='table table-bordered table-striped table-condensed'>
                    <tr>
                      <td width='100%' class='tablea'>
                        <center>
                          <br>
                          <b>WICHTIG:</b><br>
                          Das Invite-System ist <font color=red><b>NICHT</b></font> dazu gedacht Unbekannte<br>
                          einzuladen wie z.B. in Foren-Threads oft gelesen Suche Invite für XYZ-Tracker !<br>
                          Invited Leute die ihr <b><font color=red>kennt und denen Ihr vertraut</font></b>, <br>
                          sonst könnten wir auch einfach die Anmeldung offen lassen...
                          <br>
                          <br>
                          <ul id='maintab' class='shadetabs'>
                            <li class='selected'><a href='".$_SERVER['PHP_SELF']."?action=user' rel='ajaxcontentarea'><font color='red'>Deine Inviteuser</font></a></li>
                            <li><a href='".$_SERVER['PHP_SELF']."?action=codes' rel='ajaxcontentarea'><font color='red'>Deine Codes</font></a></li>
                            <li><a href='".$_SERVER['PHP_SELF']."?action=new' rel='ajaxcontentarea'><font color='red'>Neuen Invitecode erstellen</font></a></li>
                          </ul>
                        </center>
                        <div id='ajaxcontentarea' class='contentstyle'></div>
                        <script type='text/javascript'>
                          startajaxtabs('maintab')
                        </script>
                      </td>
                    </tr>
                  </table>
                  <br>
                  <br>
                  <table cellpadding='4' cellspacing='1' border='0' style='width:100%' class='table table-bordered table-striped table-condensed'>
                    <tr><td class='tabletitle' colspan='10' width='100%' style='text-align: center'><span class='normalfont'><b>Kurzanleitung</b></span></td></tr>
                    <tr>
                      <td width='100%' class='tablea'>
                        <center>
                          <br>
                          <b>Deine Inviteuser</b>:<br>
                          Hier siehen Sie alle User die von dir Invited wurden. <br>
                          Jeder mit dem Status Pending muss von Ihnen noch manuell bestätigt werden, dazu einfach das Häkchen setzen und auf den Absendebutton klicken. <br>
                          Die bereits bestätigten User sieht ihr inklusive deren Ratio, Mail-Adresse usw.<br>
                          <br>
                          <b>Deine Codes</b>:<br>
                          Hier sehen Sie alle Invite Codes die von dir generiert wurden und noch nicht genutzt wurden.<br>
                          Sofern neben den Code keine Email Adresse steht können Sie diesen Code an einen beliebigen Bekannten abgeben.<br>
                          Jeden Code können Sie jederzeit wieder löschen.<br>
                          <br>
                          <b>Neuen Invitecode erstellen</b>:<br>
                          Hier können Sie neue Invite Codes erstellen.<br>
                          Sie können Optional noch eine Email Adresse angeben. Der Invite Code wird dann an der jeweiligen Email Adresse geschickt und der Account kann auch nur
                          mit der angegeben Email Adresse erstellt werden.<br>
                          <br>
                          <b>Bedenke</b>:<br>
                          <b>Vergesst nicht, dass jeder eingeladene User auf euch zurückzuführen ist d.h.</b>:<br>
                          macht er groben Unfug indem er z.B. cheated oder nur leeched, ist das auch auf euch zurückzuführen, überlegt euch also bitte wen ihr invited.<br>
                          <br>
                        </center>
                      </td>
                    </tr>
                  </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

  x264_footer();
}
elseif($action == "user")
{
  header('Content-Type: text/html; charset=iso-8859-1');
  
  $ret = mysql_query("SELECT id, username, class, email, uploaded, downloaded, status, warned, enabled, email FROM users WHERE invitedby = ".$CURUSER['id']) or sqlerr(__FILE__,__LINE__);
  $num = mysql_num_rows($ret);

  print "
                  <center>
                    <form name='confirm' action='".$_SERVER['PHP_SELF']."?action=confirm' method='post'>
                      <table cellpadding='4' cellspacing='1' border='0' style='width:50%' class='table table-bordered table-striped table-condensed'>
                        <tr><td class='tabletitle' colspan='10' width='100%' style='text-align: center'><span class='normalfont'><b>Von dir Invitete User (".$num.")</b></span></td></tr>
                        <tr>
                          <td class='tableb'><b>Benutzername</b></td>
                          <td class='tableb'><b>Email</b></td>
                          <td class='tableb'><b>Upload</b></td>
                          <td class='tableb'><b>Download</b></td>
                          <td class='tableb'><b>Ratio</b></td>
                          <td class='tableb'><b>Status</b></td>
                          <td class='tableb'><b>Bestätigen?</b></td>
                        </tr>";

  if(!$num)
    print "
                        <tr>
                          <td colspan='7' class='tableb'>Momentan nichts hier</td>
                        </tr>";
  else
  {
    while ($arr = mysql_fetch_assoc($ret))
    {
      if($arr['status'] != "pending")
        print "
                        <tr>
                          <td class='tableb'><b><a href='/userdetails.php?id=".$arr['id']."'><font class='".get_class_color($arr['class'])."'>".$arr['username']."</font></a></b></td>
                          <td class='tableb'><b>".$arr['email']."</b></td>
                          <td class='tableb'><b>".mksize($arr['uploaded'])."</b></td>
                          <td class='tableb'><b>".mksize($arr['downloaded'])."</b></td>
                          <td class='tableb'><b>".($arr['downloaded']?"<font color='".get_ratio_color($arr["uploaded"]/$arr["downloaded"])."'>".number_format($arr["uploaded"]/$arr["downloaded"], 3)."</font>":"-- Inf --")."</b></td>
                          <td class='tableb'><b><font color='".($arr['enabled']=="yes"?"green'>Bestätigt":"red'>Gesperrt")."</font></b></td>
                          <td class='tablea'></td>
                        </tr>";
      else
        print "
                        <tr>
                          <td class='tableb'><b><a href='/userdetails.php?id=".$arr['id']."'><font class='".get_class_color($arr['class'])."'>".$arr['username']."</font></a></b></td>
                          <td class='tableb'><b>".$arr['email']."</b></td>
                          <td class='tableb' colspan='3'><center><i>Hier steht noch nichts</i></center></td>
                          <td class='tableb'><b><font color='yellow'>Wartet</font></b></td>
                          <td class='tablea'><input type='checkbox' name='conusr[]' value='".$arr['id']."'></td>
                        </tr>";
      
    }
  }
  print "
                        <tr>
                          <td colspan='6' class='tableb' colspan='6'></td>
                          <td class='tablea'><input type='submit' value='Bestätigen'></td>
                        </tr>
                      </table>
                    </form>
                  </center>";
}
elseif($action=="codes")
{
  header('Content-Type: text/html; charset=iso-8859-1');

  $res = mysql_query("SELECT id, inviteid, invite, time_invited, email FROM invites WHERE inviter = ".$CURUSER['id']." AND confirmed='no'") or sqlerr(__FILE__,__LINE__);
  $num = mysql_num_rows($res);
  
  print "
                  <center>
                    <table cellpadding='4' cellspacing='1' border='0' style='width:50%' class='table table-bordered table-striped table-condensed'>
                      <tr><td class='tabletitle' colspan='10' width='100%' style='text-align: center'><span class='normalfont'><b>Deine Invite Codes (".$num.")</b></span></td></tr>
                      <tr>
                        <td class='tableb'><b>Invite Code</b></td>
                        <td class='tableb'><b>Erstellt am</b></td>
                        <td class='tableb'><b>Email</b></td>
                        <td class='tableb'><b>Optionen</b></td>
                      </tr>";
  
  if(!$num)
    print "
                      <tr>
                        <td colspan='4' class='tableb'>Momentan nichts hier</td>
                      </tr>";
  else
  {
    while ($arr = mysql_fetch_assoc($res))
    {
      print "
                      <tr>
                        <td class='tableb'>".$arr['invite']."</td>
                        <td class='tableb'>".$arr['time_invited']."</td>
                        <td class='tableb'>".($arr['email']?$arr['email']:"Keine Angegeben")."</td>
                        <td class='tablea'>
                          <center>
                            <a href='".$_SERVER["PHP_SELF"]."?action=del&id=".$arr['id']."' onclick='Check = confirm('Wollen Sie den Code wirklich löschen?'); if(Check == false) return false;'><i class='fa fa-trash-o' alt='Invite löschen' title='Invite löschen'></i></a>
                            <a href='/signup.php?invite=".$arr['invite']."' onclick='alert('Bitte benutzen Sie die Browser Funktion zum Kopieren des Links');return false;'><i class='fa fa-link' alt='Invite Link' title='Invitelink (Rechtsklick -> Linkadresse kopieren'></i></a>
                          </center>
                        </td>
                      </tr>";
    }
  }
  print "
                    </table>
                  </center>";
}
elseif($action=="new")
{
  header('Content-Type: text/html; charset=iso-8859-1');
  
  $res = mysql_query("SELECT invites FROM users WHERE id=".$CURUSER['id']) or sqlerr(__FILE__,__LINE__);
  $arr = mysql_fetch_assoc($res);
  
  if($arr['invites'] == 0)
  {
    print "
                  <center>
                    <table cellpadding='4' cellspacing='1' border='0' style='width:100%' class='table table-bordered table-striped table-condensed'>
                      <tr><td class='tabletitle' colspan='10' width='100%' style='text-align: center'><span class='normalfont'><b>Nicht möglich</b></span></td></tr>
                      <tr>
                        <td width='100%' class='tablea'>
                          <center>
                            <br>
                            Sie haben zur Zeit leider keine Invites zur Verfügung
                          </center>
                        </td>
                      </tr>
                    </table>
                  </center>";
    die();
  }

  print "
                  <center>
                    <form name='confirm' action='".$_SERVER['PHP_SELF']."?action=takenew' method='post'>
                      <table cellpadding='4' cellspacing='1' border='0' style='width:50%' class='table table-bordered table-striped table-condensed'>
                        <tr><td class='tabletitle' colspan='10' width='100%' style='text-align: center'><span class='normalfont'><b>Neuen InviteCode erstellen (Noch ".$arr['invites']." möglich)</b></span></td></tr>
                        <tr>
                          <td class='tableb'><b>Email Adresse</b><br><i>Optional</i></td>
                          <td class='tablea'><input type='text' name='email' size='100'></td>
                        </tr>
                      </table>
                      <br>
                      <table cellpadding='4' cellspacing='1' border='0' style='width:50%' class='table table-bordered table-striped table-condensed'>
                        <tr><td class='tabletitle' colspan='10' width='100%' style='text-align: center'><span class='normalfont'><b>Erstellen?</b></span></td></tr>
                        <tr><td class='tablea'><center><input type='submit' value='Invite Code erstellen'></center></td></tr>
                      </table>
                    </form>
                  </center>";
}
elseif($action=="confirm")
{
  $con = $_POST['conusr'];
  
  foreach($con as $c)
  {
    $conusr[] = intval($c);
  }
  
  if ($conusr)
  {
    $res = mysql_query("SELECT email FROM users WHERE id IN (".implode(", ",$conusr).") AND status='pending'") or sqlerr(__FILE__,__LINE__);
  
    mysql_query("UPDATE users SET status = 'confirmed' WHERE id IN (".implode(", ",$conusr).") AND status='pending'") or sqlerr(__FILE__,__LINE__);

    $message = "Hallo,\n\n".
               "Dein Account wurde eben freigeschalten. Du kannst dich sofort einloggen\n\n".
               $GLOBALS['BASEURL']."/login.php\n\n".
               "Bitte Faq und Regeln lesen bevor du irgendetwas saugts\n\n".
               "Viel Glück und Spass auf ".$GLOBALS['SITENAME'];


    while ($arr = mysql_fetch_assoc($res))
      mail($arr['email'], $GLOBALS['SITENAME']." Account Confirmation", $message, "From: ".$GLOBALS['SITEEMAIL']);
  }

  header("Location: ".$_SERVER['PHP_SELF']);
  die();
}
elseif($action=="del")
{
  $id = intval($_GET['id']);
  
  if (!$id)
    stderr("Fehler", "Ungültige ID");

  $res = mysql_query("SELECT inviter FROM invites WHERE id = ".$id) or sqlerr(__FILE__,__LINE__);
  $arr = mysql_fetch_assoc($res);
  
  if (!$arr['inviter'])
    stderr("Fehler", "Unbekannte ID");

  if ($arr['inviter'] != $CURUSER['id'])
    stderr("Fehler", "Sie haben nicht das Recht diesen InviteCode zu löschen");
    
  mysql_query("DELETE FROM invites WHERE id=".$id) or sqlerr(__FILE__,__LINE__);
  mysql_query("UPDATE users SET invites = invites + 1 WHERE id=".$CURUSER['id']) or sqlerr(__FILE__,__LINE__);

  header("Location: ".$_SERVER['PHP_SELF']);
}
elseif($action=="takenew")
{
  $email = htmlentities(trim($_POST['email']));
  $res   = mysql_query("SELECT invites FROM users WHERE id = ".$CURUSER['id']) or sqlerr(__FILE__,__LINE__);
  $arr   = mysql_fetch_assoc($res);

  if ($arr['invites'] == 0)
    stderr("Nicht möglich","Sie haben zur Zeit leider keine Invites zur Verfügung");

  if ($email)
  {
    if (!validemail($email))
      stderr("Fehler","Die E-Mail Adresse sieht nicht so aus, als ob sie gültig wäre.");

    $res = mysql_query("SELECT id FROM users WHERE email=".sqlesc($email)) or sqlerr(__FILE__,__LINE__);
    $num = mysql_num_rows($res);
    
    if ($num)
      stderr("Fehler","Die angegebene Email Adresse kann nicht benutzt werden");
  }

  $hash = md5(mt_rand(1,1000000));

  mysql_query("INSERT INTO invites (inviter, invite, time_invited, email) VALUES (".$CURUSER['id'].", ".sqlesc($hash).", ".sqlesc(get_date_time()).", ".sqlesc($email).")") or sqlerr(__FILE__,__LINE__);
  mysql_query("UPDATE users SET invites = invites - 1 WHERE id = ".$CURUSER['id']) or sqlerr(__FILE__,__LINE__);

  if ($email)
  {
    $message = "Hallo,\n\n".
               "Für dich wurde soeben ein Invite für ".$GLOBALS['SITENAME']." hinterlegt.\n\n".
               "Das heißt Sie können sich jetzt Registrieren!!\n\n".
               "Benutzen Sie Bitte den unten stehenden Link um sich zu registrieren\n\n".
               $GLOBALS['BASEURL']."/signup.php?invite=".$hash."&email=".urlencode($email)."\n\n".
               "Wir und ".$CURUSER['username']." (Dein Inviter) wünschen dir jetzt schon viel Spaß auf ".$GLOBALS['SITENAME'];

    mail($email, $GLOBALS['SITENAME']." Invite", $message, "From: ".$GLOBALS['SITEEMAIL']);
  }

  header("Location: ".$_SERVER['PHP_SELF']);
  die();
}
elseif($action=="email")
{
  $id = intval($_GET['id']);

  if (!$id)
    stderr("Fehler", "Ungültige ID");

  $res = mysql_query("SELECT inviter FROM invites WHERE id = ".$id) or sqlerr(__FILE__,__LINE__);
  $arr = mysql_fetch_assoc($res);

  if (!$arr['inviter'])
    stderr("Fehler", "Unbekannte ID");

  if ($arr['inviter'] != $CURUSER['id'])
    stderr("Fehler", "Das ist nicht dein Invite Code");

  x264_header("Invites");
  print "
                  <center>
                    <form name='confirm' action='".$_SERVER['PHP_SELF']."?action=takemail' method='post'>
                    <input type='hidden' name='id' value='".$id."'>
                      <table cellpadding='4' cellspacing='1' border='0' style='width:50%' class='table table-bordered table-striped table-condensed'>
                        <tr><td class='tabletitle' colspan='10' width='100%' style='text-align: center'><span class='normalfont'><b>Invite Mail Senden</b></span></td></tr>
                        <tr>
                          <td class='tableb'><b>Email Adresse</b></td>
                          <td class='tablea'><input type='text' name='email' size='100'></td>
                        </tr>
                      </table>
                      <br>
                      <table cellpadding='4' cellspacing='1' border='0' style='width:50%' class='table table-bordered table-striped table-condensed'>
                        <tr><td class='tabletitle' colspan='10' width='100%' style='text-align: center'><span class='normalfont'><b>Senden?</b></span></td></tr>
                        <tr><td class='tablea'><center><input type='submit' value='Email Senden'></center></td></tr>
                      </table>
                    </form>
                  </center>";
  x264_footer();
}
elseif($action=="takemail")
{
  $id = intval($_POST['id']);
  $email = htmlentities(trim($_POST['email']));

  if (!$id)
    stderr("Fehler", "Ungültige ID");

  $res = mysql_query("SELECT inviter, invite FROM invites WHERE id = ".$id) or sqlerr(__FILE__,__LINE__);
  $arr = mysql_fetch_assoc($res);

  if (!$arr['inviter'])
    stderr("Fehler", "Unbekannte ID");

  if ($arr['inviter'] != $CURUSER['id'])
    stderr("Fehler", "Das ist nicht dein Invite Code");
    
  if (!validemail($email))
    stderr("Fehler","Die E-Mail Adresse sieht nicht so aus, als ob sie gültig wäre.");

  $res = mysql_query("SELECT id FROM users WHERE email=".sqlesc($email)) or sqlerr(__FILE__,__LINE__);
  $num = mysql_num_rows($res);

  if ($num)
    stderr("Fehler","Die angegebene Email Adresse kann nicht benutzt werden");

  mysql_query("UPDATE invites SET email = ".sqlesc($email)." WHERE id =".$id) or sqlerr(__FILE__,__LINE__);

  $message = "Hallo,\n\n".
             "Für dich wurde soeben ein Invite für ".$GLOBALS['SITENAME']." hinterlegt.\n\n".
             "Das heißt Sie können sich jetzt Registrieren!!\n\n".
             "Benutzen Sie Bitte den unten stehenden Link um sich zu registrieren\n\n".
             $GLOBALS['BASEURL']."/signup.php?invite=".$arr['invite']."&email=".urlencode($email)."\n\n".
             "Wir und ".$CURUSER['username']." (Dein Inviter) wünschen dir jetzt schon viel Spaß auf ".$GLOBALS['SITENAME'];

  mail($email, $GLOBALS['SITENAME']." Invite", $message, "From: ".$GLOBALS['SITEEMAIL']);

  header("Location: ".$_SERVER['PHP_SELF']);
  die();
}
else
  die("Ung&uuml;tige Option");
?>