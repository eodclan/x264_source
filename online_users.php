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

require_once(dirname(__FILE__) . "/include/bittorrent.php");

header('Content-Type: text/html; charset=iso-8859-1');

dbconn(true);
loggedinorreturn();


// Online User Anzeige
#$dt          = time() - 9600;
$dt          = time() - 15600;
$dt          = sqlesc(get_date_time($dt));
$maxdt       = get_date_time(time() - 21600*28);
$activeusers = "\n";
$sql         = "SELECT id,username FROM users WHERE status='confirmed' ORDER BY id DESC LIMIT 1";
$a           = $db -> querySingleArray($sql);
$latestuser  = "<a href='userdetails.php?id=".$a["id"]."'><font color='lightgrey'><b>". $a["username"]."</b></font></a>";

if ($CURUSER["class"] >= UC_SYSOP)
{
  $class_hidden  = "AND class <= 255";
  $class_hidden2 = UC_DEV;
}
else
{
  $class_hidden  = "AND class <= ".UC_DEV." AND class <= 255";
  $class_hidden2 = UC_DEV;
}

$sql            = "SELECT id, username, class, afk , upperstatus, donor, warned, added, anonymous FROM users WHERE last_access >= ".$dt." ".$class_hidden." AND last_access <= NOW() ORDER BY class DESC,username";
$res            = $db -> queryObjectArray($sql);
$activeusers_no = count($res);
$sql            = "SELECT COUNT(*) FROM torrents WHERE visible='yes'";
$active         = $db -> querySingleItem($sql);
$sql            = "SELECT COUNT(*) FROM users";
$register       = $db -> querySingleItem($sql);
$restuser       = $GLOBALS["MAX_USERS"] - $register;

foreach($res as $arr)
{
  $activeusers .= "                          ";

  $username_normal = "<a href='userdetails.php?id=".$arr["id"]."'><font class='".get_class_color($arr["class"])."'><b>".$arr["username"]."</b></font></a>".get_user_icons($arr);
  $username_anon_u = "<font class='".get_class_color($arr["class"]) . "'>*Anonym*</font>".get_user_icons($arr);
  $username_hidden = "<a href='/userdetails.php?id=".$arr["id"]."'><font class='".get_class_color($arr["class"])."'><b><i>".$arr["username"]."</i></b></font></a>".get_user_icons($arr);
  $username_self   = "<a href='/userdetails.php?id=".$arr["id"]."'><font class='".get_class_color($arr["class"])."'><b><i>".$arr["username"]."</i></b></font></a>".get_user_icons($arr);

  if ($CURUSER["username"] == $arr["username"])
    $activeusers .= "&nbsp;<nobr>" . $username_self . ",</nobr>\n";
  else
  {
    if (($CURUSER["class"] >= UC_SYSOP))
      $activeusers .= "&nbsp;<nobr>" . $username_hidden . ",</nobr>\n";

    

    if (($CURUSER["class"] >= UC_ADMINISTRATOR) && ($CURUSER["class"] < UC_SYSOP))
      $activeusers .= "&nbsp;<nobr>" . $username_normal . ",</nobr>\n";

    

    if (($CURUSER["class"] < UC_ADMINISTRATOR))
      $activeusers .= "&nbsp;<nobr>" . $username_normal . ",</nobr>\n";
  }
}

if ($activeusers == "\n")
  $activeusers = "Keine aktiven Mitglieder in den letzten 15 Minuten.";
else
  $activeusers = substr($activeusers,0,(strlen($activeusers)-10))."</nobr>\n";


$maxuseron = get_config_data('MAX_USERS');
$maxuseron = explode("|",$maxuseron);

if($maxuseron[0] < $activeusers_no)
{
  set_config_data("MAX_USERS", $activeusers_no."|".time());
  $maxuseron[0] = $activeusers_no;
  $datum        = date("d.m.Y");
  $zeit         = date("H:i:s");
}
else
{
  $datum = date("d.m.Y", $maxuseron[1]);
  $zeit  = date("H:i:s", $maxuseron[1]);
}

$constants = get_defined_constants ();
foreach( array_reverse(array_keys($constants)) as $x)
{
  if (substr($x,0,3) == "UC_" && constant($x) <= $class_hidden2 && get_user_class_name(constant($x)) != "---")
  {
    if($defclasses)$defclasses .=" | ";
    $defclasses .="<font class='".get_class_color(constant($x))."'><b>".get_user_class_name(constant($x))."</b></font>";
  }
}

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-info-circle'></i>Momentan aktive Torrents: ".$active." | Momentan aktive Mitglieder: ".$activeusers_no." | Neuestes Mitglied: ".$latestuser."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";

if ($register < $GLOBALS["MAX_USERS"])
{

}
print "
		<div>".$defclasses."</div>
		<div>".$activeusers . "</a></div>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

// Ende Online User Anzeige

// AFK System (Auto Logout)
$sql = "UPDATE users SET afk = 'no' WHERE last_access < ".$dt." AND afk='yes'";
$db -> execute($sql);
// Ende AFR System (Auto Logout)

include("ajax_pm_system.php");
?>