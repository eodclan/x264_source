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

$userid = $_GET['id'];
$action = $_GET['action'];

if (!$userid)
    $userid = $CURUSER['id'];

if (!is_valid_id($userid))
    stderr("Fehler", "Ung&uuml;ltige User-ID $userid!");

if ($userid != $CURUSER["id"])
    stderr("Fehler", "Zugriff verweigert!");

$res = mysql_query("SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
$user = mysql_fetch_array($res) or stderr("Fehler", "Es gibt keinen User mit der ID $userid!");
// action: add -------------------------------------------------------------
if ($action == 'add') {
    $targetid = $_GET['targetid'];
    $type = $_GET['type'];

    if (!is_valid_id($targetid))
        stderr("Fehler", "Ung&uuml;ltige User-ID $$targetid.");

    if ($type == 'friend') {
        $table_is = $frag = 'friends';
        $field_is = 'friendid';
    } elseif ($type == 'block') {
        $table_is = $frag = 'blocks';
        $field_is = 'blockid';
    } else
        stderr("Fehler", "Unbekannter Typ $type");

    $r = mysql_query("SELECT id FROM $table_is WHERE userid=$userid AND $field_is=$targetid") or sqlerr(__FILE__, __LINE__);
    if (mysql_num_rows($r) == 1)
        stderr("Fehler", "User-ID $targetid ist bereits in Deiner $table_is Liste.");

    mysql_query("INSERT INTO $table_is VALUES (0,$userid, $targetid)") or sqlerr(__FILE__, __LINE__);
    header("Location: $BASEURL/friends.php?id=$userid&".SID."#$frag");
    die;
} 
// action: delete ----------------------------------------------------------
if ($action == 'delete') {
    $targetid = $_GET['targetid'];
    $sure = $_GET['sure'];
    $type = $_GET['type'];

    if (!is_valid_id($targetid))
        stderr("Fehler", "Ung&uuml;ltige User-ID $userid.");

    if ($type=="block")
        $readtype = "blockierten Benutzer";
    else 
        $readtype = "Freund";
    
    if (!$sure)
        stderr("L&ouml;sche $readtype", "Möchtest Du wirklich einen $readtype aus der Liste entfernen? Klicke\n" . "<a href=?id=$userid&action=delete&type=$type&targetid=$targetid&sure=1>hier</a> wenn du Dir sicher bist.");

    if ($type == 'friend') {
        mysql_query("DELETE FROM friends WHERE userid=$userid AND friendid=$targetid") or sqlerr(__FILE__, __LINE__);
        if (mysql_affected_rows() == 0)
            stderr("Error", "No friend found with ID $targetid");
        $frag = "friends";
    } elseif ($type == 'block') {
        mysql_query("DELETE FROM blocks WHERE userid=$userid AND blockid=$targetid") or sqlerr(__FILE__, __LINE__);
        if (mysql_affected_rows() == 0)
            stderr("Fehler", "Kein blockierter Benutzer mit der ID $targetid gefunden");
        $frag = "blocks";
    } else
        stderr("Fehler", "Unknown type $type");

    header("Location: $BASEURL/friends.php?id=$userid&".SID."#$frag");
    die;
} 
// main body  -----------------------------------------------------------------
x264_header("Buddyliste f&uuml;r " . $user['username']);

if ($user["donor"] == "yes") $donor = "<td class=embedded><img src=\"".$GLOBALS["PIC_BASE_URL"]."starbig.gif\" alt='Donor' style='margin-left: 4pt'></td>";
if ($user["warned"] == "yes") $warned = "<td class=embedded><img src=\"".$GLOBALS["PIC_BASE_URL"]."warnedbig.gif\" alt='Warned' style='margin-left: 4pt'></td>";

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Buddyliste f&uuml;r ".$user["username"]." ".$donor." ".$warned." ".$country."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	
$i = 0;

$res = mysql_query("SELECT f.friendid as id, u.username AS name, u.class, u.avatar, u.title, u.donor, u.warned, u.enabled, u.last_access FROM friends AS f JOIN users as u ON f.friendid = u.id WHERE userid=$userid ORDER BY name") or sqlerr(__FILE__, __LINE__);

if (mysql_num_rows($res) == 0)
    $friends = "<div>Deine Buddyliste ist leer.</div>";
else
    while ($friend = mysql_fetch_array($res)) {
    $year = substr($friend['last_access'], 0, 4);
    $month = substr($friend['last_access'], 5, 2);
    $day = substr($friend['last_access'], 8, 2);
    $hour = substr($friend['last_access'], 11, 2);
    $mins = substr($friend['last_access'], 14, 2);

    $date_last_access = $day . "." . $month . "." . $year;

    $name_day = date("l", mktime(0, 0, 0, $month, $day, $year));

    if ($name_day == "Monday") $name_day = "Montag";
    if ($name_day == "Tuesday") $name_day = "Dienstag";
    if ($name_day == "Wednesday") $name_day = "Mittwoch";
    if ($name_day == "Thursday") $name_day = "Donnerstag";
    if ($name_day == "Friday") $name_day = "Freitag";
    if ($name_day == "Saturday") $name_day = "Samstag";
    if ($name_day == "Sunday") $name_day = "Sonntag";

    $title = $friend["title"];
    if (!$title)
        $title = get_user_class_name($friend["class"]);
    $body1 = "<h1 class='x264_im_logo'><a href=userdetails.php?id=" . $friend['id'] . ">" . $friend['name'] . "</a></h1>" .
    get_user_icons($friend) . " ($title)<br><br>Zuletzt gesehen am<br>" . $name_day . ", den " . $date_last_access . " " . substr($friend['last_access'], 11, 5) . " Uhr (vor " . get_elapsed_time(sql_timestamp_to_unix_timestamp($friend[last_access])) . ")";
    $body2 = "<br><h1 class='x264_im_logo'><a href=friends.php?id=$userid&action=delete&type=friend&targetid=" . $friend['id'] . ">L&ouml;schen</a></h1>" . "<br><h1 class='x264_im_logo'><a href=messages.php?action=send&amp;receiver=" . $friend['id'] . ">PN&nbsp;schicken</a></h1>";
    $avatar = ($CURUSER["avatars"] == "yes" ? htmlspecialchars($friend["avatar"]) : "");
    if (!$avatar)
        $avatar = $GLOBALS["PIC_BASE_URL"]."default_avatar.gif";
    if ($i % 2 == 0)
	echo("	
		<div>");
    else
    print("" .
        ($avatar ? "<div><img width=75px src=\"$avatar\"></div>" : "") . "</div>");
	echo("
		<div>".$body1."</div>
		<div>".$body2."</div>");
    print("</div>");
    if ($i % 2 == 1)
        print("
		<div>");
    else
        print("");
    $i++;
} 
if ($i % 2 == 1)
	print "
		<div>";
print($friends);
	print "
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
                                    <i class='fa fa-edit'></i> Blockierte Benutzer
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";

$res = mysql_query("SELECT b.blockid as id, u.username AS name, u.donor, u.warned, u.enabled, u.last_access FROM blocks AS b JOIN users as u ON b.blockid = u.id WHERE userid=$userid ORDER BY name") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) == 0)
    $blocks = "<div class='x264_title_table'>Du hast keine anderen Mitglieder blockiert.</div>";
else {
    $I = 0;
    while ($block = mysql_fetch_array($res)) {
        if (($I>0) && ($I%6 == 0))
            $blocks .= "</div>";
        $blocks .= "<div class='x264_title_table'>[<a href=friends.php?id=$userid&action=delete&type=block&targetid=" . $block['id'] . ">D</a>]&nbsp;<a href=userdetails.php?id=" . $block['id'] . "><b>" . $block['name'] . "</b></a>" .
        get_user_icons($block) . "</div>";
        $I++;
    }
    if ($I%6)
        $blocks .= "<div class='x264_title_table'>";
} 
print("$blocks\n
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>");

x264_footer();

?>