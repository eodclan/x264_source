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
dbconn();
loggedinorreturn();

$xxxcat     = 27;   // Hier XXX Category eintragen 
$antdefault = 10;   // Defaultwert: Anzahl der angezeigten Files
$stundendef = 24;   // Anzahl der Stunden bei zeitlicher einschränkung

$action     = (isset($_GET['action']) ? htmlentities(trim($_GET['action'])) : "last"); 
$ant        = 10;
$stunden    = 24;

$date_time  = get_date_time(time()-(3600*$stunden));  

$sql        = "SELECT * FROM torrents where visible='yes' AND numpics >=1 ";

switch ($action)
{
  case "last": 
    $sql   .= "AND category != '".$xxxcat."' ORDER BY added DESC LIMIT ".$ant;
    $frame  = "DIE ".$ant." NEUESTEN TORRENTS";
    break;
  case "day":
    $sql   .= "AND added >= '".$date_time."' AND category != '".$xxxcat."' ORDER BY added DESC";
    $frame  = "DIE TORRENTS DER LETZEN ".$stunden." STUNDEN";
    break;
  case "xxxday":
    $sql   .= "AND added >= '".$date_time."' AND category = '".$xxxcat."' ORDER BY added DESC";
    $frame  = "DIE XXX TORRENTS DER LETZEN ".$stunden." STUNDEN";
    break;
  case "xxxlast":
    $sql   .= "AND category = '".$xxxcat."' ORDER BY added DESC LIMIT ".$ant;
    $frame  = "DIE ".$ant." NEUESTEN XXX TORRENTS";
    break;
  case "recommended":
    $sql   .= "AND category != '".$xxxcat."' AND recommended='yes' ORDER BY added DESC LIMIT ".$ant;
    $frame  = "DIE ".$ant." NEUESTEN EMPFOHLENEN TORRENTS";
    break;
  case "onlyup":
    $sql   .= "AND category != '".$xxxcat."' AND torrents.free = 'yes' ORDER BY added DESC LIMIT ".$ant;
    $frame  = "DIE ".$ant." NEUESTEN ONLY UP TORRENTS";
    break;
  case "freeleech":
    $sql   .= "AND category != '".$xxxcat."' AND torrents.freeleech = 'yes' ORDER BY added DESC LIMIT ".$ant;
    $frame  = "DIE ".$ant." NEUESTEN FREELEECH TORRENTS";
    break;
  case "multi":
    $sql   .= "AND category != '".$xxxcat."' AND multiplikator > '1' ORDER BY added DESC LIMIT ".$ant;
    $frame  = "DIE ".$ant." NEUESTEN MULTPLIKATOR TORRENTS";
    break;
  case "highlight":
    $sql   .= "AND category != '".$xxxcat."' AND torrents.highlight = 'yes' ORDER BY added DESC LIMIT ".$ant;
    $frame  = "DIE ".$ant." NEUESTEN KINO HIGHLIGHTS TORRENTS";
    break;
  default:
    die ("Ungüeltige Parameter");
}
print "
<div class='table table-bordered table-striped table-condensed text-center'>".$frame."</div>";
$result = mysql_query($sql) or sqlerr(__FILE__, __LINE__);  

if( mysql_num_rows($result) != 0 )
{
  print '
    <table class="table table-bordered table-striped table-condensed text-center">
      <tr>'; 
  $i=0;
    
  while( $row = mysql_fetch_assoc($result) )
    {        
    if($i == 10) 
    {
	print '
      </tr>
      <tr>';		
      $i=0;    
    }
        
    $id   = $row['id'];
	


    $res7 = mysql_query("SELECT name FROM categories WHERE id=".$row['category']) or sqlerr(__FILE__, __LINE__);  
    $arr7 = mysql_fetch_assoc($res7);
    $cat  = $arr7["name"];

    $res8 = mysql_query("SELECT users.webseed FROM users JOIN peers ON users.id = peers.userid WHERE peers.torrent=".$id." AND users.webseed ='yes' AND peers.seeder = 'yes'") or sqlerr(__FILE__, __LINE__);  
    if (mysql_num_rows($res8) > 0) 
      $wbs="<img src=pic/ws1.gif>&nbsp;";
    else
      $wbs="";

    $res81 = mysql_query("SELECT users.adsl FROM users JOIN peers ON users.id = peers.userid WHERE peers.torrent=".$id." AND users.adsl ='yes' AND peers.seeder = 'yes'") or sqlerr(__FILE__, __LINE__);      
    if (mysql_num_rows($res81) > 0)
      $adsl="<img src=pic/adsl.gif>&nbsp;";
    else
      $adsl="";

    $res91 = mysql_query("SELECT users.vdsl FROM users JOIN peers ON users.id = peers.userid WHERE peers.torrent=".$id." AND users.vdsl ='yes' AND peers.seeder = 'yes'") or sqlerr(__FILE__, __LINE__);  
    if (mysql_num_rows($res91) > 0) 
      $vdsl="<img src=pic/vdsl.gif>&nbsp;";
    else
      $vdsl="";

    if  ($row[multiplikator]=="2")
      $multi1="<p><font color=lime size=2><b>Multi Torrent:&nbsp;<img src=pic/multi2.gif>";
    else
      $multi1="";

    if  ($row[multiplikator]=="5") 
      $multi2="<p><font color=lime size=2><b>Multi Torrent:&nbsp;<img src=pic/multi5.gif>";
    else
      $multi2="";

    if  ($row[multipliktor]=="10") 
      $multi3="<p><font color=lime size=2><b>Multi Torrent:&nbsp;<img src=pic/multi10.gif>";
    else
      $multi3="";

    if($row['free'] == 'yes') 
      $free = '&nbsp;<img src=pic/free.gif>';
    else
      $free = '';

    if($row['freeleech'] == 'yes') 
      $freelech = '&nbsp;<img src=pic/freeleech.gif>';
    else
      $freelech = '';

    $name = $row['name'];
    $name = str_replace('_', ' ' , $name);
    $name = str_replace('.', ' ' , $name);
    $name = htmlentities(trim(substr($name, 0, 60) . ""));
    $hoch = $row['added'];

    $ws   = mysql_query("SELECT class, username, anon FROM users WHERE id=$row[owner] LIMIT 1") or sqlerr(__FILE__, __LINE__);  
    $uws  = mysql_fetch_array($ws);

    if ($CURUSER["class"] >= UC_MODERATOR)
    {
      $username = $uws["username"];
      $k1       = "<font color=lime><b> (</b></font>";
      $k2       = "<font color=lime><b>)</b></font>";
    }

    if ($uws["anon"] =="yes" && get_user_class() >= UC_MODERATOR)
    {
      $shout    = "<font color=red><b>Anonym</b></font>";
      $shout   .= $k1 . "&nbsp;<font class=\"".get_class_color($uws["class"])."\"><b>".$username."</b></font>&nbsp;" . $k2;
    }
    elseif ($uws["anon"] =="yes" && get_user_class() < UC_UPLOADER)
      $shout="<font color=red><b>Anonym</b></font>";
    
    $uprow = (isset($uws["username"]) ? ($uws["anon"]=="yes"?"".$shout."":("<b><font class=".get_class_color($uws["class"]).">" . htmlspecialchars($uws["username"]) . "</b>")) : "<i>Unbekannt</i>");
	$tname = str_replace('.', ' ' , $row['name']);

    print '
        <td class=tablea width="10%"><center>
          <div id="newTorrent'.$row['id'].'" style="display:none">
          <div class="newTorrent"><font color=red><b>Name:</b></font> <b>'.$name.'</b>
          <p><font color=red><b>Typ:</b></font> <font color=yellow><b>'.$cat.'</b></font>
          <p><b>Gr&ouml;sse: '.mksize($row['size']).'</b>
          <p><font color=#00FFFF><b>Hochgeladen von:</b></font> '.$uprow.'
          <p><font color=lime><b>Hochgeladen am:</b></font>&nbsp;<font color=skyblue><b>'.$hoch.'</b></font>
          </b><p>'.$wbs.$vdsl.$adsl.$free.$freeleech.$multi1.$multi2.$multi3.'</div></div>
          <a onmouseover="overlib(document.getElementById(\'newTorrent' . $row['id'] . '\').innerHTML, HEIGHT, 120, CENTER);" onmouseout="return nd();" href="tfilesinfo.php?id=' . $row['id'] . '&hit=1" target=_blank><img src='. $GLOBALS["TORRENT_POSTERS"] .'/t-' . $row['id'] . '-1.jpg width=50 height="75" border=0></a><br><font color=white><b>Seeder:&nbsp; '.$row['seeders'].'<br>Leecher:&nbsp;'.$row['leechers'].'</b>
        </td>';	
    $i++; 
  }
  print '
      </tr>
    </table>';
}
else
   echo "
<div class='table table-bordered table-striped table-condensed'>
<h1 class='text-center'>Torrent Information</h1>
	<div class='table table-bordered table-striped table-condensed'>
		<div class='text-center'><img src='" . $GLOBALS["DESIGN_PATTERN"] . "/nofiles.png' class='to_img_link logo-image' alt='' /></div>
		<div class='text-center'>Keine Torrents vorhanden!</div>
	</div>
</div>";
?>