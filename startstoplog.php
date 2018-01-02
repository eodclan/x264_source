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
check_access(UC_MODERATOR);

function startStopTable($result)
{
    if (mysql_num_rows($result)>0) {
	begin_table();
	echo "<tr><td class=tablecat>User</td><td class=tablecat>IP</td><td class=tablecat>Torrent</td><td class=tablecat>Start</td><td class=tablecat>Stop</td><td class=tablecat>Dauer</td><td class=tablecat>Peer-ID</td><td class=tablecat>User-Agent</td></tr>\n";
	$lastevent = "stop";
	$lasttorrent = 0;
	$starttime = 0;
	
	while ($arr = mysql_fetch_assoc($result)) {
	    if ($arr["username"] == "")
		$arr["username"] = "<i>Gelöscht</i>";
	    else
		$arr["username"] = htmlspecialchars($arr["username"]);
	    
	    if ($arr["torrentname"] == "")
	        $arr["torrentname"] = "<i>Gelöscht</i>";
	    else
	        if (strlen($arr["torrentname"])>40)
		    $arr["torrentname"] = htmlspecialchars(substr($arr["torrentname"], 0, 40)."...");
		else
		    $arr["torrentname"] = htmlspecialchars($arr["torrentname"]);
				
	    // STOP-Event nach STOP-Event --> Sollte nicht passieren
	    if ($arr["event"] == "stop" && $lastevent == "stop") {
		echo "<tr><td class=tablea><a href=\"userdetails.php?id=".$arr["userid"]."\">".$arr["username"]."</a></td>\n";
		echo "<td class=tableb><a href=\"whois.php?ip=".$arr["ip"]."\" target=\"nvwhois\">".$arr["ip"]."</a></td>\n";
		echo "<td class=tablea><a href=\"tfilesinfo.php?id=".$arr["torrent"]."\">".$arr["torrentname"]."</a></td>\n";
		echo "<td class=tableb style=\"text-align:center\"><b>Unbekannt (Eintr. gel.?)</b></td>\n";
		echo "<td class=tablea style=\"text-align:center\">".$arr["datetime"]."</td>\n";
		echo "<td class=tableb style=\"text-align:right\">???</td>";
                echo "<td class=tablea nowrap=\"nowrap\">".htmlentities($arr["peerid"])."</td>";
                echo "<td class=tableb nowrap=\"nowrap\">".htmlspecialchars($arr["useragent"])."</td></tr>\n";
	    }
	    // START-Event mit vorhergehendem STOP-Event
	    elseif ($arr["event"] == "start" && $lastevent == "stop") {
    		echo "<tr><td class=tablea><a href=\"userdetails.php?id=".$arr["userid"]."\">".$arr["username"]."</a></td>\n";
		echo "<td class=tableb><a href=\"whois.php?ip=".$arr["ip"]."\" target=\"nvwhois\">".$arr["ip"]."</a></td>\n";
		echo "<td class=tablea><a href=\"tfilesinfo.php?id=".$arr["torrent"]."\">".$arr["torrentname"]."</a></td>\n";
		echo "<td class=tableb style=\"text-align:center\">".$arr["datetime"]."</td>\n";
	    }
	    // START-Event ohne vorherigen STOP-Event (Timeout)
	    elseif ($arr["event"] == "start" && $lastevent == "start") {
		if ($lasttorrent) {
		    echo "<td class=tablea style=\"text-align:center\"><b>Unbekannt (Timeout)</b></td>\n";
		    echo "<td class=tableb style=\"text-align:right\">???</td>";
                    echo "<td class=tablea nowrap=\"nowrap\">".htmlentities($arr["peerid"])."</td>";
                    echo "<td class=tableb nowrap=\"nowrap\">".htmlspecialchars($arr["useragent"])."</td></tr>\n";
		}
		echo "<tr><td class=tablea><a href=\"userdetails.php?id=".$arr["userid"]."\">".$arr["username"]."</a></td>\n";
		echo "<td class=tableb><a href=\"whois.php?ip=".$arr["ip"]."\" target=\"nvwhois\">".$arr["ip"]."</a></td>\n";
		echo "<td class=tablea><a href=\"tfilesinfo.php?id=".$arr["torrent"]."\">".$arr["torrentname"]."</a></td>\n";
		echo "<td class=tableb style=\"text-align:center\">".$arr["datetime"]."</td>\n";
	    }
	    // STOP-Event mit vorherigem START-Event und gleicher Torrent
	    elseif ($arr["event"] == "stop" && $lasttorrent == $arr["torrent"] && $lastevent == "start") {
	        echo "<td class=tablea style=\"text-align:center\">".$arr["datetime"]."</td>\n";
		echo "<td class=tableb style=\"text-align:right\" nowrap=\"nowrap\">".mkprettytime(strtotime($arr["datetime"])-$starttime)."</td>";
                echo "<td class=tablea nowrap=\"nowrap\">".htmlentities($arr["peerid"])."</td>";
                echo "<td class=tableb nowrap=\"nowrap\">".htmlspecialchars($arr["useragent"])."</td></tr>\n"; 
	    }
	    // STOP-Event mit vorherigem START-Event und anderer Torrent
	    elseif ($arr["event"] == "stop" && $lasttorrent != $arr["torrent"] && $lastevent == "start") {
		echo "<td class=tablea style=\"text-align:center\"><b>Unbekannt (Timeout)</b></td>\n";
		echo "<td class=tableb style=\"text-align:right\">???</td>";
                echo "<td class=tablea nowrap=\"nowrap\">".htmlentities($arr["peerid"])."</td>";
                echo "<td class=tableb nowrap=\"nowrap\">".htmlspecialchars($arr["useragent"])."</td></tr>\n";
	    }
	    if ($arr["event"] == "start")
	        $starttime = strtotime($arr["datetime"]);
			    
	    $lastevent = $arr["event"];
	    $lasttorrent = $arr["torrent"];
	}
        if ($lastevent == "start") {
    	    echo "<td class=tablea style=\"text-align:center\"><b>Unbekannt (Timeout)</b></td>\n";
	    echo "<td class=tableb style=\"text-align:right\">???</td>";
            echo "<td class=tablea nowrap=\"nowrap\">".htmlentities($arr["peerid"])."</td>";
            echo "<td class=tableb nowrap=\"nowrap\">".htmlspecialchars($arr["useragent"])."</td></tr>\n";
	}
	end_table();
    } else {
	echo "<p>Die Suche ergab leider keine Treffer.</p>";
    }
}


x264_header("Start/Stop Log (Auswertung)");
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-user'></i> Start/Stop Log (Auswertung)
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
?>
		<tr>Bitte eine Aktion wählen:</tr>
			<td>
				<li><a href="startstoplog.php?op=acchistory">Benutzer mit mehr als einem angemeldeten Account (History)</a></li>
				<li><a href="startstoplog.php?op=dblacc">Doppelaccount-Suche</a></li>
				<li><a href="startstoplog.php?op=often">H&auml;ufige Starts/Stops</a></li>
			</td>
		</tr>
<?php
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

if ($_GET["op"]) {
    switch($_GET["op"]) {
        case "acclist":
	    $udata =@mysql_fetch_assoc(@mysql_query("SELECT `username` FROM `accounts` WHERE `userid`=".intval($_GET["id"])));
		print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-user'></i> Ehemalige Accounts
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";		
            //begin_frame("Ehemalige Accounts", FALSE, "650px;");

            if (!is_array($udata)) {
                echo "<p>Dieser Benutzer hat noch keine Einträge!</p>";
                break;
            } else {
		echo "<p>Ehemalige Accounts von Benutzer \"".htmlspecialchars($udata["username"])."\":</p>\n";
	    }
            
            begin_table();
            echo "<tr><td class=tablecat>Unique ID</td><td class=tablecat>User</td><td class=tablecat>E-Mail</td><td class=tablecat>Letzter Zugriff</td><td class=tablecat>BAD</td></tr>\n";

            $query = "SELECT DISTINCT(`chash`) FROM `accounts` WHERE `userid`=".intval($_GET["id"]);
	    $hashres = mysql_query($query);
	    $accs = 0;
	    while ($hash = mysql_fetch_assoc($hashres)) {
                $userres = mysql_query("SELECT * FROM `accounts` WHERE `chash`=".sqlesc($hash["chash"])." AND `userid`<>".intval($_GET["id"]));
		if (mysql_num_rows($userres) == 0)
		    continue;
	        $newrow = 1;
        	echo "<tr><td class=tablea style=\"text-align:center;vertical-align:middle;\" rowspan=".mysql_num_rows($userres).">".$hash["chash"]."</td>\n";
        	while ($userdata = mysql_fetch_assoc($userres)) {
            	    if ($newrow == 1)
                	$newrow = 0;
            	    else
                	echo "<tr>";
            	    echo "<td class=tablea style=\"text-align:left;vertical-align:middle;\"><a href=\"userdetails.php?id=".$userdata["userid"]."\">".$userdata["username"]."</a></td>\n";
            	    echo "<td class=tablea style=\"text-align:left;vertical-align:middle;\">".htmlspecialchars($userdata["email"])."</td>\n";
            	    echo "<td class=tablea style=\"text-align:center;vertical-align:middle;\">".str_replace(" ", "&nbsp;", htmlspecialchars($userdata["lastaccess"]))."</td>\n";
            	    echo "<td class=tablea style=\"text-align:center;vertical-align:middle;\">".($userdata["baduser"]?"<img src=\"".$GLOBALS["PIC_BASE_URL"]."warned.gif\" alt=\"BAD User\">":"")."</td>\n";
            	    echo "</tr>\n";
		    $accs++;
        	}
	    }
	    if ($accs == 0)
		echo "<tr><td colspan=\"5\" class=tablea style=\"text-align:left;vertical-align:middle;\">Keine (bekannten) ehemaligen Accounts.</td></tr>\n";
	    
            end_table();
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
            break;
            
        case "acchistory":
            // Aufräumen (6 Wochen alte Einträge löschen)
            mysql_query("DELETE FROM `accounts` WHERE UNIX_TIMESTAMP(`lastaccess`) < (UNIX_TIMESTAMP()-3628800)");
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-user'></i> Benutzer mit mehr als einem angemeldeten Account
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";

            $query = "SELECT `chash`,COUNT(*) AS `cnt` FROM `accounts` GROUP BY `chash` ORDER BY `lastaccess` DESC";
            $result = mysql_query($query);
            
            begin_table();
            echo "<tr><td class=tablecat>Unique ID</td><td class=tablecat>User</td><td class=tablecat>E-Mail</td><td class=tablecat>Letzter Zugriff</td><td class=tablecat>BAD</td><td class=tablecat> </td><td class=tablecat> </td></tr>\n";
            while ($chash = mysql_fetch_assoc($result)) {
                if ($chash["cnt"] == 1) continue;
                $userres = mysql_query("SELECT `accounts`.*,`users`.`username` AS `unamecheck`,`users`.`enabled` FROM `accounts` LEFT JOIN `users` ON `users`.`id`=`accounts`.`userid` WHERE `chash`=".sqlesc($chash["chash"]));
                $newrow = 1;
                echo "<tr><td class=tablea style=\"text-align:center;vertical-align:middle;\" rowspan=".$chash["cnt"].">".$chash["chash"]."</td>\n";
                while ($userdata = mysql_fetch_assoc($userres)) {
                    if ($newrow == 1)
                        $newrow = 0;
                    else
                        echo "<tr>";
                    echo "<td class=tablea style=\"text-align:left;vertical-align:middle;\"><a href=\"userdetails.php?id=".$userdata["userid"]."\">".$userdata["username"]."</a></td>\n";
                    echo "<td class=tablea style=\"text-align:left;vertical-align:middle;\">".htmlspecialchars($userdata["email"])."</td>\n";
                    echo "<td class=tablea style=\"text-align:center;vertical-align:middle;\">".str_replace(" ", "&nbsp;", htmlspecialchars($userdata["lastaccess"]))."</td>\n";
                    echo "<td class=tablea style=\"text-align:center;vertical-align:middle;\">".($userdata["baduser"]?"<img src=\"".$GLOBALS["PIC_BASE_URL"]."warned.gif\" alt=\"BAD User\">":"")."</td>\n";
                    echo "<td class=tablea style=\"text-align:center;vertical-align:middle;\">".($userdata["enabled"]!="yes"?"<img src=\"".$GLOBALS["PIC_BASE_URL"]."disabled.png\" alt=\"Deaktiviert\">":"")."</td>\n";
                    echo "<td class=tablea style=\"text-align:center;vertical-align:middle;\"><img src=\"".$GLOBALS["PIC_BASE_URL"]."button_o".($userdata["unamecheck"]!=$userdata["username"]?"ff":"n")."line2.gif\" alt=\"\"></td>\n";
                    echo "</tr>\n";
                }

            }
            end_table();
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
            break;
            
        case "dblacc":
            // Aufräumen
            mysql_query("DELETE FROM startstoplog WHERE UNIX_TIMESTAMP(`datetime`) < (UNIX_TIMESTAMP()-864000)");
            
            $query = "SELECT DISTINCT(ip), COUNT(DISTINCT(userid)) as cnt FROM startstoplog GROUP BY ip ORDER BY cnt DESC,userid,`datetime` DESC";
            $result = mysql_query($query);

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-user'></i> Doppelaccount-Auswertung
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
            begin_table();
            echo "<tr><td class=tablecat>IP</td><td class=tablecat>Users</td><td class=tablecat>Torrents</td><td class=tablecat>Zugriff</td></tr>\n";
	    while ($ipaddr = mysql_fetch_assoc($result)) {
                // Abbrechen bei nur einem Zugriff für diese IP!
                if ($ipaddr["cnt"] == 1) break;
            
                echo "<tr><td class=tablea align=center valign=middle rowspan=".$ipaddr["cnt"].">".$ipaddr["ip"]."</td>\n";
                $userres = mysql_query("SELECT users.username,users.warned,users.enabled,users.added,startstoplog.userid,startstoplog.torrent,torrents.name,startstoplog.datetime FROM startstoplog LEFT JOIN torrents ON startstoplog.torrent = torrents.id LEFT JOIN users ON users.id=startstoplog.userid WHERE startstoplog.ip=".sqlesc($ipaddr["ip"])." GROUP BY startstoplog.userid ORDER BY startstoplog.datetime DESC");
                $newrow = 1;
		$lasttime = 0;
                while ($userdata = mysql_fetch_assoc($userres)) {
		    if ($userdata["name"] != "" && strlen($userdata["name"])>50)
			$userdata["name"] = substr($userdata["name"], 0, 50) . "...";
            	    if ($newrow == 1)
	        	$newrow = 0;
    	    	    else
    	    		echo "<tr>";
    	    	    echo "<td class=tableb align=left><a href=\"userdetails.php?id=".$userdata["userid"]."\">".($userdata["username"]!=""?htmlspecialchars($userdata["username"]):"<i>Gelöscht</i>")."</a>";
		    echo get_user_icons($userdata);
		    echo "</td>\n";
    	    	    echo "<td class=tablea align=left><a href=\"tfilesinfo.php?id=".$userdata["torrent"]."\">".($userdata["name"]!=""?htmlspecialchars($userdata["name"]):"<i>Gelöscht</i>")."</a></td>\n";
            	    echo "<td class=tableb align=center>";
		    if ($lasttime>0) {
			echo "<div style=\"width:100%;height:2px;background-color:";
			$curtime = strtotime($userdata["datetime"]);
			$diff = abs($lasttime - $curtime);
			if ($diff <= 3600)
			    echo "#FF0000";
			elseif ($diff > 3600 && $diff <= 86400)
			    echo "#FF8000";
			elseif ($diff > 86400 && $diff <= 172800)
			    echo "#FFFF00";
			else
			    echo "#00FF00";
			echo ";\"></div>";
		    } else {
			$lasttime = strtotime($userdata["datetime"]);
		    }
		    echo str_replace(" ", "&nbsp;", htmlspecialchars($userdata["datetime"]))."</td></tr>\n";
                }
            }
            end_table();
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
            break;
        case "often":
            break;
        case "user":
	    $_GET["uid"] = intval($_GET["uid"]);
	    $result = mysql_query("SELECT username FROM users WHERE id=".sqlesc($_GET["uid"])." LIMIT 1");
	    if (mysql_num_rows($result)==0) {
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-user'></i> Start-/Stop-Log - Benutzer nicht gefunden
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Start-/Stop-Log - Benutzer nicht gefunden</h1>
	<div class='x264_title_content'>";			
		//begin_frame("Start-/Stop-Log - Benutzer nicht gefunden");
		echo "<p>Es wurde kein Benutzer mit der ID ".$_GET["uid"]." gefunden.</p>";
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
		break;
	    }
	    $userinfo = mysql_fetch_assoc($result);
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-user'></i> Start-/Stop-Log für Benutzer ".htmlspecialchars($userinfo["username"])."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
";	
	    $query = "SELECT startstoplog.*,users.username,torrents.name AS torrentname FROM startstoplog,users,torrents WHERE startstoplog.userid=".sqlesc($_GET["uid"])." AND users.id=startstoplog.userid AND torrents.id=startstoplog.torrent ORDER BY torrent DESC,peerid ASC,`datetime` ASC";
	    $result = mysql_query($query);
	    startStopTable($result);

            break;
	case "ipsearch":
	    //begin_frame("Nach IP-Adresse suchen", FALSE, "650px");
?>
<form action="<?=$PHP_SELF?>?op=ipsearch" method="post">
<?php begin_table(); ?>
<tr><td class="tableb">IP-Adresse(n) eingeben:</td><td class="tablea"><input type="text" size="60" name="ipaddr" value="<?=htmlspecialchars($_POST["ipaddr"])?>"></td></tr>
<tr><td class="tablea" style="text-align:center" colspan="2"><input type="submit" name="ipsearch" value="Suchen"></td></tr>
<?php end_table(); ?>
</form>
<?
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";	    
	    if (isset($_POST["ipsearch"])) {
	        $addrs = explode(",", $_POST["ipaddr"]);
	        $ip_addrs = array();
	        foreach ($addrs as $ip)
	            array_push($ip_addrs, sqlesc($ip));
	        $ip_addrs = implode(",", $ip_addrs);
		$query = "SELECT startstoplog.*,users.username,torrents.name AS torrentname FROM startstoplog,users,torrents WHERE startstoplog.ip IN (".$ip_addrs.") AND users.id=startstoplog.userid AND torrents.id=startstoplog.torrent ORDER BY userid ASC,torrent DESC,peerid ASC,`datetime` ASC";
		$result = mysql_query($query);
		startStopTable($result);
	    } else {
		echo "<p>Keine IP(s) angegeben! Mehrere IPs mit Kommas trennen.</p>";
	    }

	    //end_frame();
	    break;
        default:
            //begin_frame("Fehler");
            echo "<p>Keine gültige Aktion!</p>";
    }
    //end_frame();
}
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
x264_footer();
?>