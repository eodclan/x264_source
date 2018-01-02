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

hit_start();

$action = $_GET["action"];

dbconn(false);

hit_count();

loggedinorreturn();

if ($action == "add") {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $torrentid = 0 + $_POST["tid"];
        if (!is_valid_id($torrentid))
            stderr("Fehler", "Ungültige ID $torrentid.");

        $res = mysql_query("SELECT name FROM torrents WHERE id = $torrentid") or sqlerr(__FILE__, __LINE__);
        $arr = mysql_fetch_array($res);
        if (!$arr)
            stderr("Fehler", "Kein Torrent mit der ID ID $torrentid vorhanden.");

        $text = trim($_POST["text"]);
        if (!$text)
            stderr("Fehler", "Du musst Text eingeben!");

        mysql_query("INSERT INTO comments (user, torrent, added, text, ori_text) VALUES (" . $CURUSER["id"] . ",$torrentid, '" . get_date_time() . "', " . sqlesc($text) . "," . sqlesc($text) . ")");

        $newid = mysql_insert_id();

        mysql_query("UPDATE torrents SET comments = comments + 1 WHERE id = $torrentid");

        header("Refresh: 0; url='details.php?id=$torrentid&ampviewcomm=$newid#comm$newid'");

        hit_end();
        die;
    } 

    $torrentid = 0 + $_GET["tid"];
    if (!is_valid_id($torrentid))
        stderr("Fehler", "Ungültige ID $torrentid.");

    $res = mysql_query("SELECT name FROM torrents WHERE id = $torrentid") or sqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_array($res);
    if (!$arr)
        stderr("Fehler", "Kein Torrent mit der ID ID $torrentid vorhanden.");

        
    if (strlen($arr["name"])>50)
        $arr["name"] = substr($arr["name"], 0, 50)."...";
        
    x264_header("Einen Kommentar für \"" . $arr["name"] . "\" hinzufügen");

    begin_frame("Einen Kommentar für \"" . htmlspecialchars($arr["name"]) . "\" hinzufügen", FALSE, "500px");
    print("<form method=\"post\" action=\"comment.php?action=add\">\n");
    print("<input type=\"hidden\" name=\"tid\" value=\"$torrentid\"/>\n");
    print("<textarea name=\"text\" rows=\"10\" cols=\"80\"></textarea>\n");
    print("<p align=\"center\"><input type=\"button\" value=\"Smilie-Legende\" onclick=\"window.open('smilies.php','smilies','')\">&nbsp;<input type=\"submit\" class=btn value=\"Und ab!\" /></p></form>\n");
    end_frame();

    $res = mysql_query("SELECT comments.id, text, comments.added, username, users.id as user, users.avatar FROM comments LEFT JOIN users ON comments.user = users.id WHERE torrent = $torrentid ORDER BY comments.id DESC LIMIT 5");

    $allrows = array();
    while ($row = mysql_fetch_array($res))
    $allrows[] = $row;

    if (count($allrows)) {
        begin_frame("Neueste Kommentare zuerst, in umgekehrter Reihenfolge");
        commenttable($allrows);
        end_frame();
    } 

    x264_footer();
    hit_end();
    die;
} elseif ($action == "edit") {
    $commentid = 0 + $_GET["cid"];
    if (!is_valid_id($commentid))
        stderr("Fehler", "Ungültige ID $commentid.");

    $res = mysql_query("SELECT c.*, t.name FROM comments AS c JOIN torrents AS t ON c.torrent = t.id WHERE c.id=$commentid") or sqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_array($res);
    if (!$arr)
        stderr("Fehler", "Ungülltige ID $commentid.");

    if ($arr["user"] != $CURUSER["id"] && get_user_class() < UC_MODERATOR)
        stderr("Fehler", "Zugriff verweigert.");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $text = $_POST["text"];
        $returnto = $_POST["returnto"];

        if ($text == "")
            stderr("Fehler", "Der Kommentar-Text darf nicht leer sein!");

        $text = sqlesc($text);

        $editedat = sqlesc(get_date_time());

        mysql_query("UPDATE comments SET text=$text, editedat=$editedat, editedby=$CURUSER[id] WHERE id=$commentid") or sqlerr(__FILE__, __LINE__);

        if ($returnto)
            header("Location: $returnto");
        else
            header("Location: $BASEURL/browse.php?".SID); // change later ----------------------
        
        hit_end();
        die;
    } 

    x264_header("Kommentar für \"" . $arr["name"] . "\" bearbeiten");

    begin_frame("Kommentar für \"" . htmlspecialchars($arr["name"]) . "\" bearbeiten", FALSE, "500px");
    print("<form method=\"post\" action=\"comment.php?action=edit&amp;cid=$commentid\">\n");
    print("<input type=\"hidden\" name=\"returnto\" value=\"" . $_SERVER["HTTP_REFERER"] . "\" />\n");
    print("<input type=\"hidden\" name=\"cid\" value=\"$commentid\" />\n");
    print("<textarea name=\"text\" rows=\"10\" cols=\"80\">" . htmlspecialchars(stripslashes($arr["text"])) . "</textarea></p>\n");
    print("<p align=\"center\"><input type=\"button\" value=\"Smilie-Legende\" onclick=\"window.open('smilies.php','smilies','')\">&nbsp;<input type=\"submit\" class=btn value=\"Und ab!\" /></p></form>\n");
    end_frame();
    
    x264_footer();
    hit_end();
    die;
} elseif ($action == "delete") {
    if (get_user_class() < UC_MODERATOR)
        stderr("Fehler", "Zugriff verweigert.");

    $commentid = 0 + $_GET["cid"];

    if (!is_valid_id($commentid))
        stderr("Fehler", "Ungültige ID $commentid.");

    $sure = $_GET["sure"];

    if (!$sure) {
        $referer = $_SERVER["HTTP_REFERER"];
        stderr("Kommentar löschen", "Du bist im Begriff, einen Kommentar zu Löschen. Klicke \n" . "<a href=?action=delete&cid=$commentid&sure=1" .
            ($referer ? "&returnto=" . urlencode($referer) : "") . ">hier</a> wenn Du Dir sicher bist.");
    } 

    $res = mysql_query("SELECT torrent FROM comments WHERE id=$commentid") or sqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_array($res);
    if ($arr)
        $torrentid = $arr["torrent"];

    mysql_query("DELETE FROM comments WHERE id=$commentid") or sqlerr(__FILE__, __LINE__);
    if ($torrentid && mysql_affected_rows() > 0)
        mysql_query("UPDATE torrents SET comments = comments - 1 WHERE id = $torrentid");

    $returnto = $_GET["returnto"];

    if ($returnto)
        header("Location: $returnto");
    else
        header("Location: $BASEURL/browse.php?".SID); // change later ----------------------
    
    hit_end();
    die;
} elseif ($action == "vieworiginal") {
    if (get_user_class() < UC_MODERATOR)
        stderr("Fehler", "Zugriff verweigert.");

    $commentid = 0 + $_GET["cid"];

    if (!is_valid_id($commentid))
        stderr("Fehler", "Ungültige ID $commentid.");

    $res = mysql_query("SELECT c.*, t.name FROM comments AS c JOIN torrents AS t ON c.torrent = t.id WHERE c.id=$commentid") or sqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_array($res);
    if (!$arr)
        stderr("Fehler", "Ungültige ID $commentid.");

    x264_header("Originaler Kommentar");
    print("<h1>Ursprünglicher Inhalt des Kommentars #$commentid</h1><p>\n");
    print("<table width=500 border=1 cellspacing=0 cellpadding=5>");
    print("<tr><td class=comment>\n");
    echo htmlspecialchars(stripslashes($arr["ori_text"]));
    print("</td></tr></table>\n");

    $returnto = $_SERVER["HTTP_REFERER"];
    // $returnto = "details.php?id=$torrentid&amp;viewcomm=$commentid#$commentid";
    if ($returnto)
        print("<p><font size=small>(<a href=$returnto>Zurück</a>)</font></p>\n");

    x264_footer();
    hit_end();
    die;
} else
    stderr("Fehler", "Unbekannte Aktion $action");

die;

?>