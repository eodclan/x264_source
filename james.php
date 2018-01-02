<?
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
$phpself  = substr($_SERVER['PHP_SELF'], 1, strlen($_SERVER['PHP_SELF'])-1);
$filename = substr(__FILE__, strlen(__FILE__)-strlen($phpself), strlen($phpself));
if ($phpself != $filename )
{
  $status = $GLOBALS["SB_BOT_ENGINE"];
  if ($jamestext && $status == "on")
  {
    srand(microtime()*1000000);
    $res = mysql_query("SELECT * FROM jamescat") or sqlerr(__FILE__, __LINE__);
    while ($arr = mysql_fetch_assoc($res))
    {
      if (ereg($arr['catname'],$jamestext))
      {
        $sbtext = array();
        $res2 = mysql_query("SELECT text FROM jamestext WHERE catid=".$arr['id']) or sqlerr(__FILE__, __LINE__);
        while ($arr2 = mysql_fetch_assoc($res2))
        {
          $sbtext[] = $arr2['text'];
        }
      }
    }
    if (count($sbtext) == 0)
    {
      $res = mysql_query("SELECT * FROM jamescat WHERE catname = 'not'") or sqlerr(__FILE__, __LINE__);
      $arr = mysql_fetch_array($res);
      $sbtext = array();
      $res2 = mysql_query("SELECT text FROM jamestext WHERE catid=".$arr['id']) or sqlerr(__FILE__, __LINE__);
      while ($arr2 = mysql_fetch_assoc($res2))
      {
        $sbtext[] = $arr2['text'];
      }
    } 
    $zufall = rand(0,count($sbtext)-1);
    $sbtext = $sbtext[$zufall];
    
    function random_torrent()
    {
      $res = mysql_query("SELECT name,id FROM torrents WHERE visible='yes' AND category != 27 ORDER BY RAND() LIMIT 1") or sqlerr(__FILE__, __LINE__);
      $arr = mysql_fetch_assoc($res);
      return "[sttts=/details.php?id=".$arr['id']."]".$arr['name']."[/sttts]";
    }
    
    function newest_torrent()
    {
      $res = mysql_query("SELECT name,id FROM torrents WHERE visible='yes' AND category != 27 ORDER BY added DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
      $arr = mysql_fetch_assoc($res);
      return "[sttts=/details.php?id=".$arr['id']."]".$arr['name']."[/sttts]";
    }

    function versionsinfo()
    {
      $ret = "James Shoutbox Bot Version 2.5 ( 04.03.2010 )[br][br]Versionsinfo: [br]Botverwaltung V1.2[br]Botengine V2.5[br][br]Made for VisionX Tracker by Tara-Maus[br][br]Momentan zur Verfügung stehende Schlagwörter:[br][br]";

      $res = mysql_query("SELECT catname FROM jamescat WHERE catname != 'not'") or sqlerr(__FILE__, __LINE__);
      while ($arr = mysql_fetch_assoc($res))
       $ret .= $arr['catname'].", ";

      return $ret;
    }

    function streamstatus()
    {
      $stats1 = get_sc_stats1();
      $stats2 = get_sc_stats2();
      
      $ret = "Radio Stats[br]Radio 1:";
      
      if ($stats1["streamstatus"] == 1)
        $ret .= "[/color][color=red] ".$stats1['servertitle']."[/color][color=lime] mit [/color][color=yellow]".$stats1["songtitle"]."[/color][color=lime] [sttts=http://".$GLOBALS["SC_HOSTNAME1"].":".$GLOBALS["SC_PORT1"]."/listen.pls]Reinhören[/sttts][br]";
      else
        $ret .= "[/color][color=red] Radio Offline[/color][color=lime] Leider kein DJ am Mischpult[br]";

      $ret .= "Radio 2:";
      
      if ($stats2["streamstatus"] == 1)
        $ret .= "[/color][color=red] ".$stats2['servertitle']."[/color][color=lime] mit [/color][color=yellow]".$stats2["songtitle"]."[/color][color=lime] [sttts=http://".$GLOBALS["SC_HOSTNAME2"].":".$GLOBALS["SC_PORT2"]."/listen.pls]Reinhören[/sttts][br]";
      else
        $ret .= "[/color][color=red] Radio Offline[/color][color=lime] Leider kein DJ am Mischpult[br]";
      return $ret;
    }
    
    if (ereg("versionsinfo",$jamestext))
      $sbtext = $jamestext;

    if ($sbtext)
    {
      $sbtext = eregi_replace("NICKNAME",$CURUSER['username'],$sbtext);
      $sbtext = eregi_replace("RANDTORRENT",random_torrent(),$sbtext);
      $sbtext = eregi_replace("NEWTORRENT",newest_torrent(),$sbtext);
      $sbtext = eregi_replace("STREAMSTATUS",streamstatus(),$sbtext);
      $sbtext = eregi_replace("TIME",date("H:i")." Uhr und ".date("s")." Sekunden",$sbtext);
      if (ereg("versionsinfo",$sbtext))
        $sbtext = versionsinfo();
      $sbtext = eregi_replace("&auml;","ä",$sbtext);
      $sbtext = eregi_replace("&ouml;","ö",$sbtext);
      $sbtext = eregi_replace("&uuml;","ü",$sbtext);
      $sbtext = eregi_replace("&Auml;","Ä",$sbtext);
      $sbtext = eregi_replace("&Ouml;","Ö",$sbtext);
      $sbtext = eregi_replace("&Uuml;","Ü",$sbtext);
      $sbtext = eregi_replace("&szlig;","ß",$sbtext);
      $sbtext = "[b][color=lime]".$sbtext."[/color][/b]";
      $date   = time()+1;

      if (ereg("systemcheck",$jamestext))
        $sbtext = "[b][color=red]Alle Systeme laufen Fehlerfrei[/color][/b]";

      if ($sbtext)
        mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES ( NULL ," . sqlesc('0') . ", " . sqlesc('System') . ", $date, " . sqlesc($sbtext) . ")");
    }
  }
}
else
{
  require_once(dirname(__FILE__) . "/include/engine.php");
  dbconn();
  loggedinorreturn();
  
   if (get_user_class() < UC_DEV)
  {
    stderr("Fehler","Zugriff zu dieser Seite ist Ihnen untersagt");
    exit();
  }
  
  function table_start($titel)
  {
    print "
      <table class='tableinborder'  border='0' cellspacing='1' cellpadding='4' width='100%'>
        <tr>
          <td class='tabletitle' colspan='3'><center><b>$titel</b></center></td>
        </tr>";
  }

  function table_end()
  {
    print "
      </table>";
  }

  function catlist() 
  {
    $ret = array();
    $res = mysql_query("SELECT * FROM jamescat ORDER BY catname");
    while ($row = mysql_fetch_array($res)) 
    {
      $ii            = array();
      $ii['id']      = $row['id'];
      $ii['catid']   = $row['catid'];
      $ii['catname'] = $row['catname'];
      $ret[]         = $ii;
    }
    return $ret;
  }

  function table_zeile($bez, $beschr, $id = 0,$uid=0)
  {
    if($uid)
    {
      $res=mysql_query("SELECT username,class FROM users WHERE id=".$uid) or sqlerr(__FILE__, __LINE__);
      $arr=mysql_fetch_assoc($res);
      $user = $arr['username'];
    }
    
    if ($user)
      $user="<a href='/userdetails.php?id=".$uid."' target='_blanc'><font class=".get_class_color($arr['class']).">".$user."</font></a>";
    else
      $user="<i>Unbekannt</i>";
      
    print "
        <tr>
          <td class='tableb' width='20%'>$bez</td>
          <td class='tablea' width='65%'>$beschr</td>
          <td class='tablea' width='65%'>$user</td>";
    if ($id)
    {
      print"
          <td class='tableb' width='5%'><center><a href='".$_SERVER["PHP_SELF"]."?action=edit&id=$id'><img src='pic/edit.png' alt='Bearbeiten' title='Bearbeiten' style='border: medium none ; vertical-align: middle;' height='16' width='16'></a>  <a href='".$_SERVER["PHP_SELF"]."?action=del&id=$id'><img src='pic/editdelete.png' alt='L&ouml;schen' title='L&ouml;schen' style='border: medium none ; vertical-align: middle;'' height='16' width='16'></center></a></td>
        </tr>";
    }
  }

  function form_start($name, $act)
  {
    if ($act)
      $act ="?action=".$act;
    print "
      <form name='".$name."' action='".$_SERVER["PHP_SELF"].$act."' method='post'>";
  }

  function form_end($value)
  {
    table_start("Verf&uuml;bare Optionen");
    print "
      <script language=javascript>
      function zuruck() 
      {
        window.location.href='".$_SERVER["PHP_SELF"]."';
      }
      </script>    
      <tr>
        <td class='tableb' width='30%'><center><input type='submit' class=btn value='$value'></center></td>
        <td class='tablea' width='30%'></td>
        <td class='tableb' width='30%'><center><input type='button' name='back' value='Zur&uuml;ck' onclick='javascript:zuruck()'></center></td>
      </tr>";
    table_end();
    print "
      <tr><td class='tablea' align='center' colspan='2'></td></tr>
      </form>";
  }

  if (isset($_GET['action']))
  {
    $action = htmlentities(trim($_GET['action']));
  }
  else 
  {
    $action = "view";
  }
  
  if ($action == "view")
  {
    x264_header("James Bot V2 Verwaltung");
    table_start("Aktuelle Textvorlagen");
    $res = mysql_query("SELECT * FROM jamescat ORDER BY catname") or sqlerr(__FILE__, __LINE__);
    while ($arr = mysql_fetch_assoc($res))
    {
      $res2 = mysql_query("SELECT * FROM jamestext WHERE catid=".$arr['id']) or sqlerr(__FILE__, __LINE__);
      while ($arr2 = mysql_fetch_assoc($res2))
      {
        table_zeile($arr['catname'],format_comment($arr2['text'],false),$arr2['id'],$arr2['uid']);
      }
    }
    table_end();
    table_start("James Administration");
    $james = $GLOBALS["SB_BOT_ENGINE"];
    if ($james == "off") $jt="James Anschalten";
    elseif ($james == "on") $jt="James Abschalten";
    print "
      <script language=javascript>
      function catview() 
      {
        window.location.href='".$_SERVER["PHP_SELF"]."?action=catview';
      }
      function add() 
      {
        window.location.href='".$_SERVER["PHP_SELF"]."?action=add';
      }
      function james() 
      {
        window.location.href='".$_SERVER["PHP_SELF"]."?action=james';
      }
      </script>    
      <tr>
        <td class='tableb' width='30%'><center><input type='button' name='catview' value='Schlagw&ouml;rter' onclick='javascript:catview()'></center></td>
        <td class='tablea' width='30%'><center><input type='button' name='James' value='$jt' onclick='javascript:james()'></center></td>
        <td class='tableb' width='30%'><center><input type='button' name='add' value='Neue Textvorlage' onclick='javascript:add()'></center></td>
      </tr>";
    table_end();
    $take = htmlentities(trim($_GET['take']));
    if ($take)
    {
      if     ($take == 'add')       $text   = "Textvorlage erfolgreich hinzugef&uuml;gt";
      elseif ($take == 'edit')      $text   = "Textvorlage erfolgreich edditiert";
      elseif ($take == 'del')       $text   = "Textvorlage erfolgreich gel&ouml;scht";
      elseif ($take == 'jameson')   $text   = "Bot erfolgreich abgeschaltet";
      elseif ($take == 'jamesoff')  $text   = "Bot erfolgreich angeschaltet";
      else                     $notake = true;
      if (!$notake)
      {
        print "
        <script language=javascript>
        javascript:alert('".$text."')
        </script>";
      }
    }
    x264_footer();
    exit();
  }
  elseif ($action == "add")
  {
    x264_header("James Bot V2 Verwaltung - Textvorlage hinzuf&uuml;gen");
    form_start("acpdel", "takeadd");
    table_start("Textvorlage hinzuf&uuml;gen");
	  tr("Textvorlage", "<textarea name='text' rows='15' cols='80'></textarea><br><small>Hier den James Text einf&uuml;gen. Bitte anstelle des Username den Platzhalter NICKNAME und wenn eine Uhrzeitangabe eingebunden werden soll den Platzhalter TIME verwenden.</small>", 1);
    $s   = "<select name='cat'>\n<option value='0'>(ausw&auml;hlen)</option>\n";
    $cat = catlist();
    foreach ($cat as $row)
    {
      $s .= "<option value='".$row['id']."'>".$row['catname']."</option>\n";
    }
    tr("Schlagwort", $s, 1);
    table_end();
    form_end("Speichern");
    x264_footer();
    exit();
  }
  elseif ($action == "takeadd")
  {
    $text = htmlentities(trim($_POST['text']));
    $cat  = htmlentities(trim($_POST['cat']));

    if (!$text)
    {
      stderr("Fehler","Du hast keine Textvorlage angegeben" );
      exit();
    }
    
    if (!$cat)
    {
      stderr("Fehler","Kein Schlagwort angegeben");
      exit();
    }
    mysql_query("INSERT INTO jamestext (id, catid, text, uid) VALUES (NULL, ".sqlesc($cat).", ".sqlesc($text).",".$CURUSER['id'].")") or sqlerr(__FILE__, __LINE__);
    Header("Location: ".$_SERVER["PHP_SELF"]."?take=add");
    exit();  
  }
  elseif ($action == "edit")
  {
    $id = intval($_GET['id']);
    if (!$id)
    {
      stderr("Fehler", "Fehlende ID");
      exit();
    }
    $res = mysql_query("SELECT * FROM jamestext WHERE id = ".$id);
    $row = mysql_fetch_array($res);
    x264_header("James Bot V2 Verwaltung - Textvorlage bearbeiten");
    form_start("edit","takeedit");
    table_start("Textvorlage bearbeiten");
    print "<input type='hidden' name='id' value='$id'>";
    tr("Beschreibung", "<textarea name='text' rows='15' cols='80'>".$row['text']."</textarea><br><small>Hier den James Text einf&uuml;gen. Bitte anstelle des Username den Platzhalter NICKNAME und wenn eine Uhrzeitangabe eingebunden werden soll den Platzhalter TIME verwenden.</small>", 1);
    $s   = "<select name=\"cat\">\n<option value=\"0\">(ausw&auml;hlen)</option>\n";
    $cat = catlist();
    foreach ($cat as $subrow) 
    {
	   $s .= "<option value='".$subrow['id']."'";
	   if ($subrow['id'] == $row['catid'])
	     $s .= " selected='selected'";
	   $s .= ">".$subrow['catname']."</option>\n";
    }  
    tr("Schlagwort", $s, 1);
    table_end();  
    form_end("Edditieren");
    x264_footer();
    exit();
  }
  elseif ($action == "takeedit")
  {
    $id   = intval($_POST['id']);
    $text = htmlentities(trim($_POST['text']));
    $cat  = htmlentities(trim($_POST['cat']));
    if (!$id)
    {
      stderr("Fehler","Fehlende ID" );
      exit();  
    }
    if (!$text)
    {
      stderr("Fehler","Du hast keine Textvorlage angegeben" );
      exit();
    }
    if (!$cat)
    {
      stderr("Fehler","Kein Schlagwort angegeben");
      exit();
    }
    mysql_query("UPDATE jamestext SET catid = ".sqlesc($cat).", text = ".sqlesc($text)." WHERE id = ".$id) or sqlerr(__FILE__, __LINE__);  
    Header("Location: ".$_SERVER["PHP_SELF"]."?take=edit");
    exit();  
  }
  elseif ($action == "del")
  {
    $id = intval($_GET['id']);
    if (!$id)
    {
      stderr("Fehler", "Fehlende ID");
      exit();
    }
    $res  = mysql_query("SELECT * FROM jamestext WHERE id = ".$id) or sqlerr(__FILE__, __LINE__);  
    $arr  = mysql_fetch_array($res);
    $res2 = mysql_query("SELECT catname FROM jamescat WHERE id = ".$arr['catid']) or sqlerr(__FILE__, __LINE__);
    $arr2 = mysql_fetch_array($res2);  
    x264_header("James Bot V2 Verwaltung - Textvorlage l&ouml;schen");
    form_start("del","takedel");
    table_start("Textvorlage l&ouml;schen");  
    print "<input type='hidden' name='id' value='$id'>";
    table_zeile($arr2['catname'],$arr['text']);
    print "<tr><td class='tablea' colspan='3'>Wollen Sie diesen Eintrag wirklich l&ouml;schen</td></tr>";
    form_end("L&ouml;schen");
    table_end();
    x264_header();
    exit();  
  }
  elseif ($action == "takedel")
  {
    $id = intval($_POST['id']);
    if (!$id)
    {
      stderr("Fehler","Fehlende ID");
      exit();
    }
    mysql_query("DELETE FROM jamestext WHERE id= ".$id) or sqlerr(__FILE__, __LINE__);
    Header("Location: ".$_SERVER["PHP_SELF"]."?take=del");
    exit();
  }
  elseif ($action == "catview")
  {
    x264_header("James Bot V2 Verwaltung - Schlagwortansicht");
    table_start("Schlagwortansicht");
    print "
      <tr>
        <td class='tableb' width='95%'>Schlagwort</td>
        <td class='tableb' width='5%'>Admin</td>
      </tr>";  
    $cat  = catlist();
    foreach ($cat as $row)
    {
      print "
        <tr>
          <td class='tablea' width='95%'>".$row['catname']."</td>
          <td class='tableb' width='5%'><a href='".$_SERVER["PHP_SELF"]."?action=catedit&id=".$row['id']."'><img src='pic/edit.png' alt='Bearbeiten' title='Bearbeiten' style='border: medium none ; vertical-align: middle;' height='16' width='16'></a>  <a href='".$_SERVER["PHP_SELF"]."?action=catdel&id=".$row['id']."'><img src='pic/editdelete.png' alt='L&ouml;schen' title='L&ouml;schen' style='border: medium none ; vertical-align: middle;'' height='16' width='16'></a></td>
        </tr>";   
    }
    table_end();
    table_start("Verf&uuml;gbare Optionen");
    print "
      <script language=javascript>
      function mainpage() 
      {
        window.location.href='index.php';
      }
      function catadd() 
      {
        window.location.href='".$_SERVER["PHP_SELF"]."?action=catadd';
      }
      function zuruck() 
      {
        window.location.href='".$_SERVER["PHP_SELF"]."';
      }
      </script>    
      <tr>
        <td class='tableb' width='30%'><center><input type='button' name='mainpage' value='Zur&uuml;ck zur Startseite' onclick='javascript:mainpage()'></center></td>
        <td class='tablea' width='30%'><center><input type='button' name='catadd' value='Neu Anlegen' onclick='javascript:catadd()'></center></td>
        <td class='tableb' width='30%'><center><input type='button' name='back' value='Zur&uuml;ck' onclick='javascript:zuruck()'></center></td>
      </tr>";
    table_end();
    $take = htmlentities(trim($_GET['take']));
    if ($take)
    {
      if     ($take == 'add')  $text   = "Schlagwort erfolgreich hinzugef&uuml;gt";
      elseif ($take == 'edit') $text   = "Schlagwort erfolgreich edditiert";
      elseif ($take == 'del')  $text   = "Schlagwort erfolgreich gel&ouml;scht";
      else                     $notake = true;
      if (!$notake)
      {
        print "
        <script language=javascript>
        javascript:alert('".$text."')
        </script>";
      }
    }
    x264_footer();
    exit();
  }
  elseif ($action == "catadd")
  {
    x264_header("James Bot V2 Verwaltung - Schlagwort hinzuf&uuml;gen");
    form_start("add","takecatadd");
    table_start("Schlagwort hinzuf&uuml;gen");
    tr("Schlagwort:","<input type='text' name='catname' size='80'>", 1);
    table_end();
    form_end("Speichern");
    x264_footer();
    exit();
  }
  elseif ($action == "takecatadd")
  {
    $catname = strtolower(htmlentities(trim($_POST['catname'])));
    if (!$catname)
    {
      stderr("Fehler","Es wurde kein Schlagwort angegeben");
      exit();
    }
    elseif (strlen($catname) > 20)
    {
      stderr("Fehler","Schlagwort zu lang<br>Max. 20 Zeichen");
      exit();
    }
    $res = mysql_query("SELECT id FROM jamescat WHERE catname ='".$catname."'") or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) != 0)
    {
      stderr("Fehler","Schlagwort schon vorhanden");
      exit();
    }
    mysql_query("INSERT INTO jamescat (id, catname) VALUES (NULL, ".sqlesc($catname).")") or sqlerr(__FILE__, __LINE__);
    Header("Location: ".$_SERVER["PHP_SELF"]."?action=catview&take=add");
    exit();
  }
  elseif ($action == "catedit")
  {
    $id = intval($_GET['id']);
    if (!$id)
    {
      stderr("Fehler", "Fehlende ID");
      exit();
    }
    $res = mysql_query("SELECT * FROM jamescat WHERE id = ".$id);
    $row = mysql_fetch_array($res);
    x264_header("James Bot V2 Verwaltung - Schlagwort bearbeiten");
    form_start("edit","takecatedit");
    table_start("Schlagwort bearbeiten");
    print "<input type='hidden' name='id' value='$id'>";
    tr("Schlagwort:","<input type='text' value='".$row['catname']."' name='catname' size='80'>", 1);
    table_end();   
    form_end("Speichern");
  }
  elseif ($action == "takecatedit")
  {
    $id      = intval($_POST['id']);
    $catname = strtolower(htmlentities(trim($_POST['catname'])));
    if (!$id)
    {
      stderr("Fehler","Fehlende ID");
      exit();
    }
    if (!$catname)
    {
      stderr("Fehler","Es wurde kein Schlagwort angegeben");
      exit();
    }
    elseif (strlen($catname) > 20)
    {
      stderr("Fehler","Schlagwort zu lang<br>Max. 20 Zeichen");
      exit();
    }
    $res = mysql_query("SELECT id FROM jamescat WHERE catname ='".$catname."'") or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($res) != 0)
    {
      stderr("Fehler","Schlagwort schon vorhanden");
    }
    mysql_query("UPDATE jamescat SET catname = ".sqlesc($catname)." WHERE id=".$id) or sqlerr(__FILE__, __LINE__);
    Header("Location: ".$_SERVER["PHP_SELF"]."?action=catview&take=edit");
    exit();
  }
  elseif ($action == "catdel")
  {
    $id = intval($_GET['id']);
    if (!$id)
    {
      stderr("Fehler", "Fehlende ID");
      exit();
    }
    $res = mysql_query("SELECT * FROM jamescat WHERE id = ".$id);
    $row = mysql_fetch_array($res);
    x264_header("James Bot V2 Verwaltung - Schlagwort l&ouml;schen");
    form_start("del","takecatdel");
    table_start("Schlagwort l&ouml;schen");
    print "
      <input type='hidden' name='id' value='$id'>
      <tr>
        <td class='tablea'>".$row['catname']."</a></td>
      </tr>
      <tr>
        <td class='tableb' colspan='2'>Wollen Sie wirklich dieses Schlagwort und alle Eintr&auml;ge die damit zugeordnet sind l&ouml;schen?</td>
      </tr>";
    table_end();
    form_end("L&ouml;schen");
    x264_footer();
    exit();  
  }
  elseif ($action == "takecatdel")
  {
    $id = intval($_POST['id']);
    if (!$id)
    {
      stderr("Fehler","Fehlende ID");
      exit();
    }
    mysql_query("DELETE FROM jamescat WHERE id= ".$id) or sqlerr(__FILE__, __LINE__);
    mysql_query("DELETE FROM jamestext WHERE catid= ".$id) or sqlerr(__FILE__, __LINE__);
    Header("Location: ".$_SERVER["PHP_SELF"]."?action=catview&take=del");
    exit();
  }
  elseif ($action == "james")
  {
    $status = $GLOBALS["SB_BOT_ENGINE"];
    
    if ($status == "on")
    {
      set_config_data("JAMES","off");
      $sbtext = "James Bot V2.1 wurde abgeschaltet";      
    }
    if ($status == "off")
    {
      set_config_data("JAMES","on");
      $sbtext = "James Bot V2.1 wurde angeschaltet";      
    }
    if ($sbtext)
    {
      $sbtext="[b][color=lime]".$sbtext."[/color][/b]";
      $date=time();
      mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES ( NULL ," . sqlesc('0') . ", " . sqlesc('System') . ", $date, " . sqlesc($sbtext) . ")");
      Header("Location: ".$_SERVER["PHP_SELF"]."?take=james$status");
      exit();
    }
    stderr("Fehler","Irgendwas ist grad schiefgelaufen");
    exit();
  }
  else
  {
    stderr("Fehler","Unzul&auml;ssiger Seitenaufruf");
    exit();
  }
}
?>