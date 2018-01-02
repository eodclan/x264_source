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

header('Content-Type: text/html; charset=iso-8859-1');

dbconn(true);
loggedinorreturn();

// START: PM Display CSS3 by Str1k3r
  $teampm      = "";
  $modpm       = "";
  $pm          = "";
  $pchat       = "";
  $show        = false;
  
  if ($CURUSER)
  {
    $sql    = "SELECT COUNT(*) FROM messages WHERE folder_in != 0 AND receiver = ".$CURUSER["id"]." AND unread = 'yes'";
    $unread = $db -> querySingleItem($sql);

    if ($CURUSER['class'] >= UC_MODERATOR)
    {
      $sql        = "SELECT COUNT(*) FROM messages WHERE sender = 0 AND receiver = 0 AND mod_flag = 'open'";
      $unread_mod = $db -> querySingleItem($sql);
    }
  }

  if (get_user_class() >=UC_MODERATOR)
  { 
    $sql           = "SELECT COUNT(*) FROM staffmessages WHERE answered = 0";
    $staffmessages = $db -> querySingleItem($sql);
    if ($staffmessages > 0)
    {
      $show = true;
      $teampm = "
<div id='toast-container' class='toast-top-right'>
	<div class='toast toast-info' aria-live='polite' style=''>
		<div class='toast-title'>Team PM System </div>
		<div class='toast-message'><a href='".$BASEURL."/staffbox.php' target='_top'>".$staffmessages." offende Team-Nachricht!</a></div>
	</div>
</div>";
    }

    if ($unread_mod)
    {
      $show = true;
      $modpm = "
<div id='toast-container' class='toast-top-right'>
	<div class='toast toast-info' aria-live='polite' style=''>
		<div class='toast-title'>Mod PM System </div>
		<div class='toast-message'><a href='".$BASEURL."/messages.php?folder=-4' target='_top'>Du hast  ".$unread_mod." neue MOD-Nachricht" . ($unread_mod > 1 ? "en" : "") .  "!</a></div>
	</div>
</div>";
    }
  }

  if ($unread)
  {
    $show = true;
    $pm = "
<div id='toast-container' class='toast-top-right'>
	<div class='toast toast-info' aria-live='polite' style=''>
		<div class='toast-title'>PM System </div>
		<div class='toast-message'><a href='".$BASEURL."/messages.php' target='_top'>Du hast ".$unread." neue Nachricht" . ($unread > 1 ? "en" : "") . "!</a></div>
	</div>
</div>";
				
  }

  $sql = "SELECT absender FROM privatechat WHERE empfanger = ".$CURUSER['id']." AND unread = 'yes' LIMIT 1";
  $uid = $db -> querySingleItem($sql);

  if ($uid != -1)
  {
    $sql      = "SELECT username FROM users WHERE id =".$uid;
    $username = $db -> querySingleItem($sql);
    $show = true;
    $pchat = "
<div id='toast-container' class='toast-top-right'>
	<div class='toast toast-info' aria-live='polite' style=''>
		<div class='toast-title'>Privat Chat System</div>
		<div class='toast-message'><a onclick=\"javascript:myRef=window.open('/shoutbox.php?action=pc&uid=".$uid."','pchat".$uid."','left=20,top=20,width=500,height=500,toolbar=0,resizable=0,location=0,directories=0');myRef.focus();\">".$username." will ein Privat Chat!</a></div>
	</div>
</div>";	
  }			

if ($show)
{
  if (get_user_class() >= UC_ADMINISTRATOR) $width = "width='24%'"; else $width = "width='49%'";
  print "
 
									<div ".$width.">".$pm."</div>";
									if (get_user_class() >= UC_ADMINISTRATOR)
										print "
									<div ".$width.">".$teampm."</div>
									<div ".$width.">".$modpm."</div>";
									print "
									<div ".$width.">".$pchat."</div>";
}      
// ENDE: PM Display CSS3 by Str1k3r
?>