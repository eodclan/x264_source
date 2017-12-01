<?php
// ************************************************************************************//
// * X264 Source
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 4.3
// * 
// * Copyright (c) 2015 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//
require "include/bittorrent.php";

dbconn(false);
loggedinorreturn();

$self = explode ("?", $_SERVER["PHP_SELF"]);
$self = $self[0];
$self = preg_replace("/(.+?)\/(.+?)/is",  "\\2", $self); //Now it don't cares in which folder the file is.  
$self = preg_replace('/\//', '', $self);  //then $self is everytime the basefile even if the $action is set.

function bark($msg)
{
    x264_header();
    stdmsg("Error", $msg);
    x264_footer();
    exit;
} 

function get_domain($ip)
{
    $dom = @gethostbyaddr($ip);
    if ($dom == $ip || @gethostbyname($dom) != $ip)
        return "<a href='whois.php?ip=".$ip."' target='nvwhois'>".$ip."</a>";
    else {
        $dom = strtoupper($dom);
        return "<a href='whois.php?ip=".$ip."' target=\"nvwhois\">".$ip."</a> (".$dom.")";
    } 
}

function get_domain2($ip)
{
    $dom = @gethostbyaddr($ip);
    if ($dom == $ip || @gethostbyname($dom) != $ip)
        return "".$ip."";
    else {
        $dom = strtoupper($dom);
        return "".$ip." (".$dom.")";
    } 
}  

function maketable($res)
{
    $ret = "\n";
    while ($arr = mysql_fetch_assoc($res)) {
        if ($arr["downloaded"] > 0) {
            $ratio = number_format($arr["uploaded"] / $arr["downloaded"], 3);
            $ratio = "<font color=" . get_ratio_color($ratio) . ">$ratio</font>";
        } else
        if ($arr["uploaded"] > 0)
            $ratio = "Inf.";
        else
            $ratio = "---";
        $catimage = htmlspecialchars($arr["image"]);
        $catname = htmlspecialchars($arr["catname"]);
        $ttl = (28 * 24) - floor((time() - sql_timestamp_to_unix_timestamp($arr["added"])) / 3600);
        if ($ttl == 1) $ttl .= "<br>hour";
        else $ttl .= "<br>hours";
        $size = str_replace(" ", "<br>", mksize($arr["size"]));
        $uploaded = str_replace(" ", "<br>", mksize($arr["uploaded"]));
        $downloaded = str_replace(" ", "<br>", mksize($arr["downloaded"]));
        $seeders = number_format($arr["seeders"]);
        $leechers = number_format($arr["leechers"]);
        $ret .= "<a href='tfilesinfo.php?id=".$arr["torrent"]."&amp;hit=1'><b>" . htmlspecialchars($arr["torrentname"]) . "</b></a><br>\n";
    } 
    $ret .= "<br>\n";
    return $ret;
} 

function makecomptable($res)
{
    $ret = "<table class='tableinborder' border='0' cellspacing='1' cellpadding='4' width='100%' summary='none'>" . "<tr><td class='tablecat' style='text-align:center'>Typ</td><td class='tablecat' width='100%'>Name</td>\n <td class='tablecat' style='text-align:center'>Fertiggestellt</td><td class=tablecat>Se.</td><td class=tablecat>Le.</td><td class=tablecat>Hochgel.</td><td class=tablecat>Runtergel.</td></tr>\n";
    while ($arr = mysql_fetch_assoc($res)) {
        $catimage = htmlspecialchars($arr["image"]);
        $catname = htmlspecialchars($arr["catname"]);
        $ret .= "<tr><td class='tableb' style='padding: 0px'><img src='" . $GLOBALS["PIC_BASE_URL"] . $catimage . "' alt='$catname' title='$catname' width='42' height='42'></td>\n<td class=tablea>";
        if ($arr["torrent_origid"] > 0) {
            $seeders = number_format($arr["seeders"]);
            $leechers = number_format($arr["leechers"]);
            $ret .= "<a href='tfilesinfo.php?id=".$arr["torrent"]."&amp;hit=1'><b>" . htmlspecialchars($arr["torrent_name"]) . "</b></a></td>";
            $ret .= "<td class='tableb' style='text-align:center'>" . str_replace(" ", "<br>", date("d.m.Y H:i:s", sql_timestamp_to_unix_timestamp($arr["complete_time"]))) . "</td>";
            $ret .= "<td class='tablea' style='text-align:right'>".$seeders."</td>";
            $ret .= "<td class='tableb' style='text-align:right\">".$leechers."</td>";
            $ret .= "<td class='tablea' style='text-align:right' nowrap='nowrap'>" . mksize($arr["uploaded"]) . "<br>@ " . mksize($arr["uploaded"] / max(1, $arr["uploadtime"])) . "/s</td>";
            $ret .= "<td class='tablea' style='text-align:right' nowrap='nowrap'>" . mksize($arr["downloaded"]) . "<br>@ " . mksize($arr["downloaded"] / max(1, $arr["downloadtime"])) . "/s</td>";
            $ret .= "</tr>\n";
        } else {
            $ret .= "<b>" . htmlspecialchars($arr["torrent_name"]) . "</b>";
            $ret .= "</td><td class='tableb' style='text-align:center'>" . str_replace(" ", "<br>", date("d.m.Y H:i:s", sql_timestamp_to_unix_timestamp($arr["complete_time"]))) . "</td>";
            $ret .= "<td class='tablea' style='text-align:center' colspan='4'>Gelöscht</td></tr>\n";
        } 
    } 

    $ret .= "</table>\n";
    return $ret;
} 

if (isset($_GET["id"]))
$id = intval($_GET["id"]);
elseif ($_POST["userid"])
$id = intval($_POST["userid"]);
else
$id = intval($CURUSER["id"]);

if (!is_valid_id($id))
    bark("Bad ID $id.");

$r = @mysql_query("SELECT * FROM users WHERE id=$id") or sqlerr();
$user = mysql_fetch_array($r) or bark("No user with ID $id.");
if ($user["status"] == "pending") die;
$r = mysql_query("SELECT id, name, added, seeders, leechers, category FROM torrents WHERE `activated`='yes' AND owner=$id ORDER BY added DESC") or sqlerr();
if (mysql_num_rows($r) > 0) {
    $torrents = "<table class='tableinborder' border='0' cellspacing='1' cellpadding='4' width='100%'  summary='none'>\n" . "<tr><td class='tablecat'>Typ</td><td class='tablecat' width='100%'>Name</td><td class=tablecat>Hochgeladen</td><td class=tablecat>Seeder</td><td class=tablecat>Leecher</td></tr>\n";
    while ($a = mysql_fetch_assoc($r)) {
        $r2 = mysql_query("SELECT name, image FROM categories WHERE id=".$a["category"]) or sqlerr(__FILE__, __LINE__);
        $a2 = mysql_fetch_assoc($r2);
        $cat = "<img src='" . $GLOBALS["PIC_BASE_URL"] . $a2["image"] . "' alt='".$a2["name"]."'>";
        $torrents .= "<tr><td class='tableb' style='padding: 0px'>$cat</td><td class='tablea'><a href='tfilesinfo.php?id=" . $a["id"] . "&amp;hit=1'><b>" . htmlspecialchars($a["name"]) . "</b></a></td>" . "<td class=tableb align=center>" . str_replace(" ", "<br>", date("d.m.Y H:i:s", sql_timestamp_to_unix_timestamp($a["added"]))) . "</td>" . "<td class=tablea align=right>$a[seeders]</td><td class=tableb align=right>$a[leechers]</td></tr>\n";
    } 
    $torrents .= "</table>";
} 

if ($GLOBALS["CLIENT_AUTH"] == "CLIENT_AUTH_PASSKEY")
    $announceurl = preg_replace("/\\{KEY\\}/", preg_replace_callback('/./s', "hex_esc", str_pad($user["passkey"], 8)), $GLOBALS["PASSKEY_ANNOUNCE_URL"]);
else
    $announceurl = $GLOBALS["ANNOUNCE_URLS"];

$addr = "";
$addr2 = "";
$peer_addr = "";
if ($user["ip"] && (get_user_class() >= UC_MODERATOR || $user["id"] == $CURUSER["id"])) {
    $ip = $user["ip"];
	if (get_user_class() >= UC_MODERATOR) {
		$addr = get_domain($ip);
	}
	else
	{
		$addr = get_domain2($ip);
	}	
    $res = mysql_query("SELECT DISTINCT(ip) AS ip FROM peers WHERE userid=".$id);
    if (mysql_num_rows($res)) {
        while ($peer_ip = mysql_fetch_assoc($res)) {
            if ($peer_addr != "")
                $peer_addr .= "<br>";
				if (get_user_class() >= UC_MODERATOR) {
					$peer_addr .= get_domain($peer_ip["ip"]);
				}
				else
				{
					$peer_addr .= get_domain2($peer_ip["ip"]);
				}					
        } 
    } 
} 
if ($user["added"] == "0000-00-00 00:00:00") {
    $joindate = 'N/A';
    $down_per_day = "";
    $upped_per_day = "";
} else {
    $joindate = "$user[added] (Vor " . get_elapsed_time(sql_timestamp_to_unix_timestamp($user["added"])) . ")";
    $days_regged = round((time() - sql_timestamp_to_unix_timestamp($user["added"])) / 86400);
    if ($days_regged) {
        $down_per_day = "(" . mksize(floor($user["downloaded"] / $days_regged)) . " / Tag)";
        $upped_per_day = "(" . mksize(floor($user["uploaded"] / $days_regged)) . " / Tag)";
    } 
} 
$lastseen = $user["last_access"];
if ($lastseen == "0000-00-00 00:00:00")
    $lastseen = "nie";
else {
    $lastseen .= " (Vor " . get_elapsed_time(sql_timestamp_to_unix_timestamp($lastseen)) . ")";
} 
$res = mysql_query("SELECT COUNT(*) FROM comments WHERE user=" . $user[id]) or sqlerr();
$arr3 = mysql_fetch_row($res);
$torrentcomments = $arr3[0];

$res = mysql_query("SELECT name,flagpic FROM countries WHERE id=$user[country] LIMIT 1") or sqlerr();
if (mysql_num_rows($res) == 1) {
    $arr = mysql_fetch_assoc($res);
    $country = "<img src='" . $GLOBALS["PIC_BASE_URL"] . "flag/" . $arr["flagpic"] . "' alt='" . $arr["name"] . "' style='margin-left: 8pt;vertical-align: middle;'>";
} 

$userData = mysql_query("SELECT
                                 (SELECT COUNT(1) FROM `peers` WHERE `userid` = " . intval($CURUSER['id']) . " AND `seeder` = 'yes' ) AS `userSeeds`,          
                                 (SELECT COUNT(1) FROM `peers` WHERE `userid` = " . intval($CURUSER['id']) . " AND `seeder` = 'no'  ) AS `userLeeches`        
                             FROM
                                 `users`
                             WHERE
                                 `id` = " . intval($CURUSER['id'])
                           ) OR sqlerr(__FILE__, __LINE__);

$stats = mysql_fetch_assoc($userData);

$seeds             = $stats['userSeeds'];
$leeches           = $stats['userLeeches']; 

    if ($tlimits['seeds'] >= 0) {
        if ($tlimits['seeds'] - $seeds < 1) {
            $seedwarn = ' style="background-color: red; color: white;"';
        }
        $tlimits['seeds'];
    }
    else {
        $tlimits['seeds'] = NULL;    
    }

    if ($tlimits['leeches'] >= 0)
    {
        if ($tlimits['leeches'] - $leeches < 1) {
            $leechwarn = ' style="background-color: red; color: white;"';
        }
        $tlimits['leeches'];
    }
    else {
        $tlimits['leeches'] = NULL;
    }
$res = mysql_query("SELECT torrent,added,uploaded,downloaded,torrents.name as torrentname,categories.name as catname,size,image,category,seeders,leechers FROM peers LEFT JOIN torrents ON peers.torrent = torrents.id LEFT JOIN categories ON torrents.category = categories.id WHERE userid=$id AND seeder='no'") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) > 0)
$leeching = "";

if (!$_GET["allleech"])
  $limit_leech = "";
else
  $limit_leech = "";

$res = mysql_query("SELECT torrent,added,traffic.uploaded,traffic.downloaded,torrents.name as torrentname,categories.name as catname,size,image,category,seeders,leechers FROM peers JOIN traffic ON peers.userid = traffic.userid AND peers.torrent = traffic.torrentid JOIN torrents ON peers.torrent = torrents.id JOIN categories ON torrents.category = categories.id WHERE peers.userid=$id AND seeder='no'$limit_leech") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) > 0)
  $leeching = maketable($res);
$seeding = "";
if (!$_GET["allseed"])
  $limit_seed = "";
else
  $limit_seed = "";

$res = mysql_query("SELECT torrent,added,traffic.uploaded,traffic.downloaded,torrents.name as torrentname,categories.name as catname,size,image,category,seeders,leechers FROM peers JOIN traffic ON peers.userid = traffic.userid AND peers.torrent = traffic.torrentid JOIN torrents ON peers.torrent = torrents.id JOIN categories ON torrents.category = categories.id WHERE peers.userid=$id AND seeder='yes'$limit_seed") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) > 0)
  $seeding = maketable($res);
$completed = "";
if (get_user_class() >= UC_MODERATOR || (isset($CURUSER) && $CURUSER["id"] == $user["id"])) {
    if (!$_GET["allcompleted"])
        $limit_comp = " LIMIT 3";
    else
        $limit_comp = "";
    $res = mysql_query("SELECT torrent_id as torrent,torrent_name,complete_time,torrents.seeders as seeders,torrents.leechers as leechers,torrents.id as torrent_origid,categories.name as catname,image,traffic.uploaded,traffic.downloaded,traffic.uploadtime,traffic.downloadtime FROM completed LEFT JOIN traffic ON completed.torrent_id = traffic.torrentid AND completed.user_id = traffic.userid LEFT JOIN torrents ON completed.torrent_id = torrents.id LEFT JOIN categories ON completed.torrent_category = categories.id WHERE user_id=$id ORDER BY complete_time DESC$limit_comp");
    if (mysql_num_rows($res) > 0)
        $completed = makecomptable($res);
} 

x264_header("Benutzerprofil von " . $user["username"]);
$enabled = $user["enabled"] == 'yes';
$acceptrules = $user["accept_rules"] == 'no';
$allowupload = $user["allowupload"] == 'yes';

$acctdata = mysql_fetch_assoc(mysql_query("SELECT `baduser` FROM `accounts` WHERE `userid`=$id"));
$baduser = $acctdata["baduser"];

if ($success == 'yes' )
stdsuccess("Profil erfolgreich geändert");

?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-user'></i> Benutzerprofil von: <?=$user["username"];?>
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class="table table-bordered table-striped table-condensed">
                        <tbody>								
<?
if (!$enabled)
{
print "
									<span><i class='fa fa-ban'></i></span> Dieser Account wurde gebannt!";	
	
}
if ($CURUSER["id"] != $user["id"]) {
?>
                            <tr>
                                <td><img src="<?=htmlspecialchars($user["avatar"]);?>" alt="" style="margin-top:15px;max-width:60px;max-height:60px;" /></td>
								<td>
									<?if($CURUSER['id'] != $id){ // Team kann allen schicken
									echo "
										<form method='get' action='messages.php' class='btn btn-flat btn-primary fc-today-button'>
											<input type='hidden' name='action' value='send'>
											<input type='hidden' name='receiver' value='" . $user["id"] . "'>
											<input type='submit' value='Nachricht senden' style='height: 23px'>
										</form>";
									}else{				
										if($CURUSER['id'] == $id){ // Man kann sich keine selbst schicken
											echo '<a href="#nogo" class="btn btn-flat btn-primary fc-today-button">Du kannst dir keine Nachricht schicken</a>';
										}else if($user['acceptpms'] == 'yes'){ // Möchte PM´s
											echo '<a href="messages.php?a=send&amp;sendid='.$id.'" class="btn btn-flat btn-primary fc-today-button">Nachricht schicken</a>';
										}else if($user['acceptpms'] == 'no'){ // Möchte keine PM´s
											echo '<a href="#nogo" class="btn btn-flat btn-primary fc-today-button">Möchte keine Nachricht bekommen</a>';
										}else if($user['acceptpms'] == 'friends'){ // Möchte keine PM´s
											echo '<a href="#nogo" class="btn btn-flat btn-primary fc-today-button">Möchte keine Nachricht bekommen</a>';	
										}			
									}
									?>								
								</td>
                            </tr>			
							<?
							if ((get_user_class() >= UC_MODERATOR && $user["class"] < get_user_class()) || $CURUSER['id'] == 1 || get_user_class() == 255)
							{
							?>			
                            <tr>
                                <td>User bearbeiten</td>
                                <td><a href="change_to_users.php?id=<?=$user["id"];?>" onclick="WhatRestSee();" style="float:left;"> Jetzt <?=$user["username"];?>`s Account bearbeiten</a></td>
                            </tr>
                            <tr>
                                <td>Titel</td>
                                <td><?=$user["title"]?></td>
                            </tr>							
							<?		
							}			
							?>							
                            <tr>
                                <td>Friend System</td>
                                <td>
								<?
								$r = mysql_query("SELECT id FROM friends WHERE userid=$CURUSER[id] AND friendid=$id") or sqlerr(__FILE__, __LINE__);
								$friend = mysql_num_rows($r);
								$r = mysql_query("SELECT id FROM blocks WHERE userid=$CURUSER[id] AND blockid=$id") or sqlerr(__FILE__, __LINE__);
								$block = mysql_num_rows($r);
								if ($friend)
								print "
								<a href=friends.php?action=delete&type=friend&targetid=".$id.">Der Freund entfernen</a>";elseif ($block)	print " - <a href=friends.php?action=delete&type=block&targetid=".$id.">Von Blockliste entfernen</a>";
								else {
								print "
								Zu der Buddy Liste hinzufügen <a href='friends.php?action=add&amp;type=friend&amp;targetid=".$id."'>Ja</a> - Zu der Blockliste hinzufügen <a href='friends.php?action=add&amp;type=block&amp;targetid=".$id."'>Ja</a>";		
								} 
								?>								
								</td>
                            </tr>
							<?
							if (get_user_class() >= UC_MODERATOR)
							{
							?>
                            <tr>
                                <td>Mitglied seit</td>
                                <td><?=$joindate;?></td>
                            </tr>
                            <tr>
                                <td>Zuletzt aktiv</td>
                                <td><?=$lastseen;?></td>
                            </tr>
                            <tr>
                                <td>Rang</td>
                                <td><?=get_user_class_name($user['class']);?></td>
                            													
							
							</tr>
							<?
							if ($user['browser'] != '') $browser = htmlsafechars($user['browser']);
							?>							
                            <tr>
                                <td>Browser</td>
                                <td><?=$browser;?></td>
                            </tr>
                            <tr>
                                <td>Download</td>
                                <td><?=mksize($user["downloaded"])?> <?=$down_per_day?></td>
                            </tr>
                            <tr>
                                <td>Upload</td>
                                <td><?=mksize($user["uploaded"])?> <?=$upped_per_day?></td>
                            </tr>
                            <tr>
                                <td>IPv4</td>
                                <td><?=$addr ?></td>
                            </tr>
                            <tr>
                                <td>IPv6</td>
                                <td>Dieser User besitzt keine IPv6!</td>
                            </tr>
                            <tr>
                                <td>E-Mail</td>
                                <td><?=$user[email];?></td>
                            </tr>							
                            <tr>
                                <td>Peer-Adressen</td>
                                <td><?=$peer_addr ?></td>
                            </tr>
							<?							
							if ($seeding)
							{
							print "
                            <tr>
                                <td>Im Seed</td>
                                <td>" . $seeding . "</td>
                            </tr>";
							}

							if ($leeching)
							{
							print "
                            <tr>
                                <td>Im Leech</td>
                                <td>" . $leeching . "</td>
                            </tr>";	
							}
							?>
                            <tr>
                                <td>Signatur</td>
                                <td><?=format_comment($user["info"]);?></td>
                            </tr>
							<?
							}
							?>							
<?}else{?>
                            <tr>
                                <td><img src="<?=htmlspecialchars($user["avatar"]);?>" alt="" style="margin-top:15px;max-width:60px;max-height:60px;" /></td>
                                <td>
								<?if($CURUSER['id'] != $id){ // Team kann allen schicken
									echo "
										<form method='get' action='messages.php' class='btn btn-flat btn-primary fc-today-button'>
											<input type='hidden' name='action' value='send'>
											<input type='hidden' name='receiver' value='" . $user["id"] . "'>
											<input type='submit' value='Nachricht senden' style='height: 23px'>
										</form>";
								}else{				
								if($CURUSER['id'] == $id){ // Man kann sich keine selbst schicken
									echo '<a href="#nogo" class="btn btn-flat btn-primary fc-today-button">Du kannst dir keine Nachricht schicken</a>';
								}else if($user['acceptpms'] == 'yes'){ // Möchte PM´s
									echo '<a href="messages.php?a=send&amp;sendid='.$id.'" class="btn btn-flat btn-primary fc-today-button">Nachricht schicken</a>';
								}else if($user['acceptpms'] == 'no'){ // Möchte keine PM´s
									echo '<a href="#nogo" class="btn btn-flat btn-primary fc-today-button">Möchte keine Nachricht bekommen</a>';
								}else if($user['acceptpms'] == 'friends'){ // Möchte keine PM´s
									$is_friend = mysql_ein_datenfeld("SELECT COUNT(*) FROM friends WHERE (userid = '".$CURUSER['id']."' AND friendid = '".$id."') OR (friendid = '".$CURUSER['id']."' AND userid = '".$id."') ");
									if($is_friend == '1'){
									echo '<a href="messages.php?a=send&amp;sendid='.$id.'" class="btn btn-flat btn-primary fc-today-button">Nachricht schicken</a>';
									}else{
									echo '<a href="#nogo" class="btn btn-flat btn-primary fc-today-button">Möchte keine Nachricht bekommen</a>';
									}		
								}			
								}?>								
								</td>
                            </tr>								
                            <tr>
                                <td>Titel</td>
                                <td><?=$user["title"]?></td>
                            </tr>
                            <tr>
                                <td>Mitglied seit</td>
                                <td><?=$joindate;?></td>
                            </tr>
                            <tr>
                                <td>Zuletzt aktiv</td>
                                <td><?=$lastseen;?></td>
                            </tr>	
                            <tr>
                                <td>Rang</td>
                                <td><?=get_user_class_name($user['class']);?></td>
                            </tr>
                            <tr>
                                <td>Download</td>
                                <td><?=mksize($user["downloaded"])?> <?=$down_per_day?></td>
                            </tr>
                            <tr>
                                <td>Upload</td>
                                <td><?=mksize($user["uploaded"])?> <?=$upped_per_day?></td>
                            </tr>
                            <tr>
                                <td>E-Mail</td>
                                <td><?=$user[email];?></td>
                            </tr>
							<?
							if ($user['browser'] != '') $browser = htmlsafechars($user['browser']);
							?>							
                            <tr>
                                <td>Browser</td>
                                <td><?=$browser;?></td>
                            </tr>
                            <tr>
                                <td>Signatur</td>
                                <td><?=format_comment($user["info"]);?></td>
                            </tr>
<?
if ($seeding)
{
print "
                            <tr>
                                <td>Im Seed</td>
                                <td>Du hast momentan " . $seeds . $tlimits['seeds'] . " Torrents im Seed.</td>
                            </tr>";
}
else
{
print "
                            <tr>
                                <td>Im Seed</td>
                                <td>Du hast momentan keine Torrents im Seed.</td>
                            </tr>";
}

if ($CURUSER["id"] == $user["id"] || get_user_class() == UC_MODERATOR)
if ($leeching)
{
print "
                            <tr>
                                <td>Im Leech</td>
                                <td>Du hast momentan " . $leeches . $tlimits['leeches'] . " Torrents als Leech.</td>
                            </tr>";	
}
else
{
print "
                            <tr>
                                <td>Im Leech</td>
                                <td>Du Leechs momentan keine Torrents.</td>
                            </tr>";	
}
?>		
	</div>

<?
}
?>
                        </tbody>
                    </table>

                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?
x264_footer();
?>