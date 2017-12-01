<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");
dbconn();
loggedinorreturn();

$action  = htmlentities($_GET['action']);
$teambox = ($_POST['teambox'] == "yes" || $_GET['teambox'] == "yes"?true:false);
$header  = ($_GET['header'] == "yes" ?true:false);
$tabelle = ($teambox?"teambox":"shoutbox");
$history = (intval($_GET['history']) == 1?true:false);
$delid   = intval($_POST['delid']);

function decode_unicode_url($str) {
    $res = '';

    $i = 0;
    $max = strlen($str) - 6;
    while ($i <= $max) {
        $character = $str[$i];
        if ($character == '%' && $str[$i + 1] == 'u') {
        $value = hexdec(substr($str, $i + 2, 4));
        $i += 6;

        if ($value < 0x0080) // 1 byte: 0xxxxxxx
            $character = chr($value);
        else if ($value < 0x0800) // 2 bytes: 110xxxxx 10xxxxxx
            $character =
                chr((($value & 0x07c0) >> 6) | 0xc0)
                . chr(($value & 0x3f) | 0x80);
        else // 3 bytes: 1110xxxx 10xxxxxx 10xxxxxx
            $character =
                chr((($value & 0xf000) >> 12) | 0xe0)
                . chr((($value & 0x0fc0) >> 6) | 0x80)
                . chr(($value & 0x3f) | 0x80);
        } else
            $i++;

        $res .= $character;
    }

    return $res . substr($str, $i);
}


if (isset($_POST['afk']))
{
  $afk = ($_POST['afk'] == "no"?"no":"yes");

  if ($afk == "yes")
  {
    $text = "Der User ".$CURUSER['username']." ist jetzt AFK";
    $db -> updateRow(array("afk" => "yes"),"users","id=".$CURUSER['id']);
  }
  else
  {
    $text = "Der User ".$CURUSER['username']." ist zurück vom AFK";
    $db -> updateRow(array("afk" => "no"),"users","id=".$CURUSER['id']);
  }
  if ($text)
  {
    $data = array(
      "userid"   => "0",
      "username" => "System",
      "date"     => time(),
      "text"     => htmlentities($text),
      "text_c"   => format_comment(htmlentities($text), false)
    );
    $db -> insertRow($data,"shoutbox");
    if (get_user_class() >= UC_MODERATOR)
    {
      $db -> insertRow($data,"teambox");
    }
  }
}


if ($teambox && get_user_class() < UC_MODERATOR)
  die("<font color=red>Zugriff Verweigert</font>");

if ($delid)
{
  if (is_numeric($delid))
  {
    $sql = "SELECT userid FROM ".$tabelle." WHERE id=".$delid;
    $uid  = $db -> querySingleItem($sql);
  }
  else
  {
    die("<center>Invalid message ID</center>");
  }

  if (get_user_class() >= UC_MODERATOR || $uid == $CURUSER['id'])
  {
    $sql = "DELETE FROM ".$tabelle." WHERE id=".intval($delid);
    $db -> execute($sql);
  }
}

if ($action == "pc" || $action == "pview")
{
  if (isset($_GET['uid']))
  {
    $uid = intval($_GET['uid']);
  }
  else
    die("Fehlende Daten");

  $sql       = "SELECT username, class FROM users WHERE id=".$uid;
  $arr       = $db -> querySingleArray($sql);
  
  $empfanger = $arr['username'];
  $class     = $arr['class'];

  if (!$empfanger)
    die("<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
        'http://www.w3.org/TR/html4/loose.dtd'>
<html>
  <head>
    <title>".$title."</title>
    <META HTTP-EQUIV='content-type' content='text/html;charset=iso-8859-1'>
    <META HTTP-EQUIV='Content-Style-Type' content='text/css'>
    <META HTTP-EQUIV='Content-Script-Type' content='text/javascript'>
    ".$meta."
    <link rel='stylesheet' href='/design/x264_black/x264.php' type='text/css'>
    <link rel='stylesheet' href='/classcolor.php' type='text/css'>
    <script type='text/javascript' src='/design/x264_black/js/lightbox.js'></script>
    <script type='text/javascript' src='/design/x264_black/js/rainbowtext.js'></script>
    <style type='text/css'>
      A {color: #0000FF; font-weight: bold; }
      A:hover {color: #FF0000;}
      .small {color: #696969; font-size: 9pt; font-weight: bold; font-family: tahoma; }
      .date {font-size: 9pt;}
      BODY
      {
        color: #FFFFFF;
        SCROLLBAR-3DLIGHT-COLOR: #004E98;
        SCROLLBAR-ARROW-COLOR: #004E98;
        SCROLLBAR-DARKSHADOW-COLOR: #FFFFFF;
        SCROLLBAR-BASE-COLOR: #FFFFFF;
      }
      
      div.menue 
      {
        border:nonr;
        width:20px;
      }
        
      div.menue div.title 
      {
        color:#000000;
      }
        
      div.menue div.menue-container 
      {
        display:none;
        background-color: #f2f2f2;
        padding:5px;
      }
        
      div.menue div.title:hover div.menue-container 
      {
        display:block;
        width:190px;
        position:absolute;
        border-left: solid 1px #ddd;
        border-right: solid 1px #ddd;
        border-bottom: solid 1px #ddd;
        margin-left:-1px;
      }
        
      div.menue div.title:hover div.headline 
      {
        border-bottom: solid 1px #ddd;
      }
        
      div.menue div.title div.headline 
      {
        cursor:pointer;
        padding: 2px 5px;
        font-weight:bold;
        color:#777;
      }
        
      div.menue div.menue-item 
      {
        border:solid 1px #ddd;
        padding:3px;
        margin: 3px;
        background-color: #FFFFFF;
        cursor:pointer;
        color:#000000;
      }

      div.menue div.menue-item:hover 
      {
        border:solid 1px #ddd;
        padding:3px;
        margin: 3px;
        background-color: #000000;
        cursor:pointer;
        color:#FFFFFF;
        text-decoration: none;
      }
    </style>
  </head>
<body>
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Ungültige Daten</h1>
    <center>
<img class='floatcontainer doc_header' src='/design/x264_black/header.png' alt='logo' style='width: 90%; height: 60px;border: 4px double #7E7E7E; border-radius: 0 60px; margin: 0 auto;' ><br><br>
<div  style=\"background-color:#D90000; width:60%; border:2px solid #FFFFFF; border-radius:0 16px;\">
<font size=\"3\" style=\"font-family:'Times New Roman',Times,serif;'\" color=\"#FFFFFF\">
        Ungültige Daten
</font>
</div>
</div>
  </body>
</html>");

  $pmsg = trim($_POST['msg']);

  if ($pmsg)
  {
    $data              = array(
      "added"     => time(),
      "absender"  => $CURUSER['id'],
      "empfanger" => $uid,
      "msg"       => $pmsg,
      "unread"    => "yes"
    );
    $db -> insertRow($data, "privatechat");
  }

  $title = "Private Chat mit ".$empfanger;
  $body  = "<body onload=\"document.prchat.msg.focus()\">";

  if ($action == "pview")
    $meta  = "<META HTTP-EQUIV=REFRESH CONTENT='10; URL=".$_SERVER['PHP_SELF']."?uid=".$uid."&amp;action=pview'>";
}
else
{
  $title = "Shoutbox";
  $body  = "<body>";
}

if ($action == "edit")
  $title .= "eintrag edditieren";

header("Content-Type: text/html; charset=iso-8859-1");
header("Pragma: No-cache");
header("Expires: 300");
header("Cache-Control: private");

if ($action == "pc" || $action == "pview" || $action == "edit" ||$history || $header)
{
  $sql = "SELECT uri FROM design WHERE id = ".$CURUSER["design"];
  $ss_a  = $db -> querySingleItem($sql);

  if (!$ss_a)
  {
    $sql = "SELECT uri FROM design WHERE default = 'yes'";
    $ss_a  = $db -> querySingleItem($sql);
  }
  
  $GLOBALS["ss_uri"] = $ss_a;
  
  print
"<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
        'http://www.w3.org/TR/html4/loose.dtd'>
<html>
  <head>
    <title>".$title."</title>
    <META HTTP-EQUIV='content-type' content='text/html;charset=iso-8859-1'>
    <META HTTP-EQUIV='Content-Style-Type' content='text/css'>
    <META HTTP-EQUIV='Content-Script-Type' content='text/javascript'>
    ".$meta."
    <link rel='stylesheet' href='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]."/ex1080.php' type='text/css'>
    <link rel='stylesheet' href='/classcolor.php' type='text/css'>
    <script type='text/javascript' src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]."/js/lightbox.js'></script>
    <script type='text/javascript' src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]."/js/rainbowtext.js'></script>
    <style type='text/css'>
      A {color: #0000FF; font-weight: bold; }
      A:hover {color: #FF0000;}
      .small {color: #696969; font-size: 9pt; font-weight: bold; font-family: tahoma; }
      .date {font-size: 9pt;}
      BODY
      {
        color: #FFFFFF;
        SCROLLBAR-3DLIGHT-COLOR: #004E98;
        SCROLLBAR-ARROW-COLOR: #004E98;
        SCROLLBAR-DARKSHADOW-COLOR: #FFFFFF;
        SCROLLBAR-BASE-COLOR: #FFFFFF;
      }
      
      div.menue 
      {
        border:nonr;
        width:20px;
      }
        
      div.menue div.title 
      {
        color:#000000;
      }
        
      div.menue div.menue-container 
      {
        display:none;
        background-color: #f2f2f2;
        padding:5px;
      }
        
      div.menue div.title:hover div.menue-container 
      {
        display:block;
        width:190px;
        position:absolute;
        border-left: solid 1px #ddd;
        border-right: solid 1px #ddd;
        border-bottom: solid 1px #ddd;
        margin-left:-1px;
      }
        
      div.menue div.title:hover div.headline 
      {
        border-bottom: solid 1px #ddd;
      }
        
      div.menue div.title div.headline 
      {
        cursor:pointer;
        padding: 2px 5px;
        font-weight:bold;
        color:#777;
      }
        
      div.menue div.menue-item 
      {
        border:solid 1px #ddd;
        padding:3px;
        margin: 3px;
        background-color: #FFFFFF;
        cursor:pointer;
        color:#000000;
      }

      div.menue div.menue-item:hover 
      {
        border:solid 1px #ddd;
        padding:3px;
        margin: 3px;
        background-color: #000000;
        cursor:pointer;
        color:#FFFFFF;
        text-decoration: none;
      }
    </style>
  </head>
  ".$body;
}

if ($history)
  print "
    <center><h1>".($teambox?"Teambox":"Shoutbox")." History</h1></center>";

if ($CURUSER['shoutpost'] != "yes")
{
  stdmsg("Sorry...", "Es ist Dir nicht gestattet, in der Shoutbox zu posten!");
  exit;
}

$action = htmlentities($_GET['action']);

if ($action == 'edit')
{
  $id  = intval($_GET['id']);
  $id2 = intval($_POST['id']);

  if ($id)
    $sbid = $id;
  elseif ($id2)
    $sbid = $id2;
  else
    die();

  //$sbtext  = html_entity_decode(mb_convert_encoding(strtr($_POST['sbtext'], $map), 'UTF-8', 'ISO-8859-1'), ENT_QUOTES, 'UTF-8');
  //$sbtext  = w1250_to_utf8($_POST['sbtext']);
  $sbtext  = mb_convert_encoding(urldecode(decode_unicode_url($_POST['sbtext'])), "ISO-8859-1");
  $sql     = "SELECT userid, text, class FROM ".$tabelle.", users WHERE users.id = ".$tabelle.".userid AND ".$tabelle.".id = ".$sbid;
  $editarr = $db -> querySingleArray($sql);
  $edituid = $editarr['userid'];
  //$editshb = $editarr['text'];
  $editshb = mb_convert_encoding(urldecode(decode_unicode_url($editarr['text'])), "ISO-8859-1");
  $editcls = $editarr['class'];

  if (get_user_class() >= UC_MODERATOR)
  {
    if (get_user_class() < $editcls)
    {
      die("Du willst doch nicht etwa den Beitrag eines Ranghöheren Mitglieds ändern wollen");
    }
  }
  elseif ($edituid != $CURUSER['id'])
  {
    die("Das ist nicht dein Beitrag den du edditieren willst");
  }

  if ($id2 && $sbtext)
  {
  
    $db -> updateRow(array("text" => $sbtext),$tabelle, "id = ".$id2);
    print "Erfolgreich";
  }
  elseif ($id)
  {
    print"
      <form name='edit' action='".$_SERVER["PHP_SELF"]."?action=edit".($teambox?"&amp;teambox=yes":"")."' method='post'>
        <input type='hidden' name='id' value='".$id."'>
        <input type='text' name='sbtext' id='shbox_text' size='60' value='".$editshb."'>
        <input type='submit' class=btn value='Edit'>
      </form>";
  }
  else
  {
    die("Hmm. iwas ist grad schiefgelaufen");
  }
  print "
  </body>
</html>";
  exit();
}
elseif ($action == "pc")
{
  print "

                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-pause'></i>Private Chat System
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
<div  style=\"background-color:#D90000; width:80%; border:2px solid #FFFFFF; border-radius:0 16px;\">
	  <font size=\"3\" style=\"font-family:'Times New Roman',Times,serif;'\" color=\"#FFFFFF\">
        Privater Chat mit :&nbsp;
        <font size=\"4\" style=\"font-family:'Times New Roman',Times,serif;'\" color=\"#222222\"title='Das ist dein Chatpartner!'>".$empfanger."</font><br>
      </font></div>
      <br>
      <script type='text/javascript'>
        function mySubmit()
        {
          setTimeout('document.prchat.reset()',50);
        }
      </script>
      <form method='post' name='prchat' action='".$_SERVER['PHP_SELF']."?action=pview&amp;uid=".$uid."' onSubmit='mySubmit()' target='pc".$uid."'>
        <input type='text' name='msg' id='shbox_text' size='40' class='btn btn-flat btn-primary fc-today-button'><input type='submit' name='send' value='GO' class='btn btn-flat btn-primary fc-today-button'>
      </form>
      <br>
    </center>
    <br>
    <iframe src='".$_SERVER['PHP_SELF']."?action=pview&amp;uid=".$uid."' width='100%' height='245' frameborder='0' name='pc".$uid."' marginwidth='0' marginheight='0'></iframe>
</div>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div> 
  </body>
</html>";
  exit();
}
elseif ($action == "pview")
{
  $sql  = "SELECT added, msg, absender FROM privatechat WHERE ( absender = ".$CURUSER['id']." AND empfanger = ".$uid." ) OR ( absender = ".$uid." AND empfanger = ".$CURUSER['id']." ) ORDER BY added DESC LIMIT 20";
  $res2 = $db -> queryObjectArray($sql);


  if($res2)
  {
    foreach ($res2 as $arr2)
    {
      if ($arr2['absender'] == $uid)
      {
        $nick = $empfanger;
        $color = $class;
      }
      else
      {
        $nick = $CURUSER['username'];
        $color = $CURUSER['class'];
      }
      $time = strftime("%H:%M",$arr2['added']);
      $msg = format_comment($arr2['msg']);
      print "
  <b><span class='date'>(".$time.")</span> <font class=".get_class_color($color).">".$nick."</font> : ".$msg."</b><br>";
    }
  }
  print "
  </body>
</html>";
  $db -> execute("UPDATE privatechat SET unread = 'no' WHERE absender = ".$uid." AND empfanger = ".$CURUSER['id']);
  $msg = mb_convert_encoding(urldecode(decode_unicode_url($_POST['msg'])), "ISO-8859-1");
  $date_time = time()-(3600*24);
  $db -> execute("DELETE FROM privatechat WHERE added <= ".sqlesc($date_time)." AND unread = 'no'");
  exit();
}
else
{
  $text = mb_convert_encoding(urldecode(decode_unicode_url($_POST['shbox_text'])), "ISO-8859-1");
  //$text = iconv('windows-1252', 'UTF-8', $text);
  $send = $_POST['sent'];

  if (get_user_class() >= UC_ADMINISTRATOR)
  {
    if ($action == 'delshout')
    {
      $teambox = ($_GET['teambox'] == "yes" || $_POST['tb'] == "yes"?true:false);
      $tabelle = ($teambox?"teambox":"shoutbox");

      $db -> execute("TRUNCATE TABLE ".$tabelle);

      $text    = trim("[b]I'm horny and that's why the shoutbox is now empty.[/b]");
      $send    = "yes";
      $system  = "yes";

      print "
    <center><font color=red>".($teambox?"Teambox":"Shoutbox")." erfolgreich geleert</font></center>";
    }
  }

  if($send == "yes" && $text != "")
  {
    if ($_POST['jamestext'] == "yes" && !$teambox)
    {
      $system="yes";
      $text = "[b]".$text."[/b]";
    }
    
    if ($system == 'yes')
    {
      $userid   = 0;
      $username = "System";
    }
    else
    {
      $userid   = $CURUSER['id'];
      $username = $CURUSER['username'];
    }

    if (ereg("\<(a|A)\ (href|HREF|Href|HrEf|hReF)", $text))
      $text='';


    if(substr($text, 0, 1) == "/")
    {
      include(dirname(__FILE__) . "/sbfunctions.php");
    }
    else
    {
      if ($text != "")
      {
        $data = array(
          "userid"   => $userid,
          "username" => $username,
          "date"     => time(),
          "text"     => htmlentities($text),
          "text_c"   => format_comment(htmlentities($text), false)
        );
        $db -> insertRow($data, $tabelle);
      }

      $jamestext = strtolower($text);
      if (ereg("tactics",$jamestext) && !$teambox)
      {
        include(dirname(__FILE__) . "/james.php");
      }
    }
  }

  if ($teambox)
  {
    echo "
    <div class='table table-bordered table-striped table-condensed text-center'>Backend ACP Zugangsdaten: | Nickname: ".$GLOBALS["SECIRITYTACTICS_NICK"]." | Passwort: ".$GLOBALS["SECIRITYTACTICS_PASSWORD"]."</div>";
  }
  
  include("ajax_shoutbox_radio.php");

  if (!$history)
  {
    $limit = " LIMIT 50";
  }
  else
  {
    $limit = NULL;
  }
  $sql = "SELECT ".$tabelle.".*, users.username, users.class, users.donor, users.enabled, users.warned, users.afk FROM ".$tabelle." LEFT JOIN users AS users ON users.id=".$tabelle.".userid ORDER BY id DESC".$limit;
  $res = $db -> queryObjectArray($sql);
  
  if (!$res)
  {
    print "\n";
  }
  else
  {
    print "
    <table border='0' cellspacing='1' cellpadding='1' width='100%' align='left' class='tableinborder'>";
    foreach ($res as $arr)
    {
      if ($arr['userid'] == $CURUSER['id'])
      {
        $color = "yellow";
      }
      elseif (ereg(strtolower($CURUSER['username']),strtolower($arr['text'])))
      {
        $color = "red";
      }
      else
      {
        $color = "";
      }

      $date = "".strftime("%H:%M",$arr['date'])."";

      if (empty($arr['username']))
      {
        $arr['username'] = "Tactics";
        $arr['class']    = UC_SYSOP;
      }

      $nick = "<b><font class='".get_class_color($arr['class'])."'>".$arr['username']."</font></b>";
      $username = $arr["username"];

      if ($arr["userid"] != $CURUSER["id"] && $arr['username'] != "James")
      {
      		$nick = "<a onClick=\"javascript:add_at('$username')\"><font size='2'>".$nick."</font></a>";
      }
        
      if ($CURUSER['sbtorrentpost'] == "no" && ($arr["userid"] == 1 || $arr['userid'] == 2))
      {
        $arr['text'] = "";
      }

      if ($CURUSER['xxx'] == "no" && $arr["userid"] == 2)
      {
        $arr['text'] = "";
      }

      if ($arr['text'])
      {$thistimestamp = strftime("%d",$arr['date']);
      if (isset($lasttimestamp) && $thistimestamp != $lasttimestamp)
      {
        setlocale(LC_TIME, 'de_DE@euro');
        echo "
      <tr style='width:100%'>    
        <td width='10' colspan='4'><center><font size='2' color='red'><b>&#8226; - Tageswechsel: Beiträge von ".strftime("%A %d . %B %G",$arr['date'])." - &#8226;</b></font></center><td>
      </tr>";      
      }
      $lasttimestamp = $thistimestamp;
        print "
      <tr style='width:100%'>
        <td width='10' class='x264_warp_shoutbox_framework_tablea'>
          <div class='menue'>
            <div class='title'>
              <div class='x264_warp_shoutbox_framework_tablea' style='float:left;'><img src='/pic/st_dwn.png' alt='Menü öffnen' border='0' style='width:20;hight:20;'></div>
              <div class='menue-container'>".
                (get_user_class() >= UC_MODERATOR || $arr["userid"] == $CURUSER["id"]?($arr['username'] != "James"?"
                <div class='menue-item'><a onclick=\"javascript:sbedit('".$arr['id']."')\"><img src='/pic/edit.png' alt='' border='0' style='width:20;hight:20'> Beitrag Edditieren</a></div>":"")."
                <div class='menue-item'><a onclick=\"javascript:delpost('".$arr['id']."')\"><img src='/pic/delete.gif' alt='' border='0' style='width:20;hight:20'> Beitrag löschen</a></div>":"").
                ($arr['username'] != $CURUSER['username'] && $arr['username'] != "James"?"
                <div class='menue-item'><a onclick=\"javascript:pchat('".$arr['userid']."')\"><img src='/pic/chat.png' alt='' border='0' style='width:20;hight:20'> PrivatChat mit ".$arr['username']."</a></div>
                <div class='menue-item'><a onclick=\"window.open('/messages.php?action=send&receiver=".$arr['userid']."','pm".$arr['username']."')\" target='_blank'><img src='/pic/pm/mail_generic.png' border='0' style='width:20;hight:20'> PM an ".$arr['username']."</a></div>":"").
                (get_user_class() >= UC_MODERATOR?"
                <div class='menue-item'><a onclick=\"window.open('".($arr['username'] == "James"?"/james.php":"/userdetails.php?id=".$arr['userid'])."','profil".$arr['username']."')\" target='_blank'><img src='/pic/personal.png' alt='' border='0' style='width:20;hight:20'>".($arr['username']=="James"?"James Verwaltung öffnen":"Profil von ".$arr['username']." öffnen")."</a></div>":"")."
                <div class='menue-item'><a onclick=\"add_at('".$arr['username']."')\"><img src='/pic/stift.png' alt='' border='0' style='width:20;hight:20'> Nick in die Shout schreiben</span></a></div>
              </div>
            </div>
          </div>
        </td>
        <td width='10' class='x264_warp_shoutbox_framework_tablea'><span class='date".$color."'><font size='2'>".$date."</font></span></td>
        <td width='10%' class='x264_warp_shoutbox_framework_tablea'><font size='2'>".$nick.get_user_icons($arr)."</font></td>
        <td width='90%'class='x264_warp_shoutbox_framework_tablea'><font size='2'>".format_comment($arr['text'], false)."</font></td>
      </tr>";
      }
    }
    print"
    </table>";
  }
}
if ($action == "pc" || $action == "pview" || $action == "edit" ||$history || $header)
echo "
</body>
</html>";
$delover50res = mysql_query("SELECT `id` FROM `shoutbox` ORDER BY `id` DESC LIMIT 35,50")or sqlerr(__FILE__, __LINE__);
$delover50row= mysql_fetch_array($delover50res);
mysql_query("DELETE FROM `shoutbox` WHERE `id` < '".$delover50row['id']."' ")or sqlerr(__FILE__, __LINE__);  
?>