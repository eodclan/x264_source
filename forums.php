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

$action = $_GET["action"];
global $CURUSER;
$userid = $CURUSER["id"];

//-------- Forum Online
check_access(UC_MODERATOR);
security_tactics();

function set_forum_online() 
{
	$trackerdienste = $GLOBALS["FORUM_ONLINE"];
	if ($trackerdienste[0] == "0")
	{
		stdmsg("Achtung","Das Forum ist gerade deaktiviert.");
		x264_admin_footer();
		die();
	}
}

//-------- Returns the minimum read/write class levels of a forum

function get_forum_access_levels($forumid) {

$res = mysql_query("SELECT minclassread, minclasswrite, minclasscreate FROM forums WHERE id=$forumid") or sqlerr(__FILE__, __LINE__);

if (mysql_num_rows($res) != 1)
return false;

$arr = mysql_fetch_assoc($res);
return array("read" => $arr["minclassread"], "write" => $arr["minclasswrite"], "create" => $arr["minclasscreate"]);
}

//-------- Returns the forum ID of a topic, or false on error

function get_topic_forum($topicid) {
$res = mysql_query("SELECT forumid FROM topics WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

if (mysql_num_rows($res) != 1)
return false;

$arr = mysql_fetch_row($res);
return $arr[0];
}

//-------- Returns the ID of the last post of a forum

function update_topic_last_post($topicid) {
$res = mysql_query("SELECT id FROM posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res) or die("Es sind keine Beiträge vorhanden.");
$postid = $arr[0];

mysql_query("UPDATE topics SET lastpost=$postid WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
}

function get_forum_last_post($forumid) {
$res = mysql_query("SELECT lastpost FROM topics WHERE forumid=$forumid ORDER BY lastpost DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);
$postid = $arr[0];

if ($postid)
return $postid;

else
return 0;
}


  //-------- Inserts a quick jump menu

  function insert_quick_jump_menu($currentforum = 0)
  {
    print("<form method=get action=? name=jump>");

    print("<input type=hidden name=action value=viewforum>");

    print("<select name=forumid onchange=\"if(this.options[this.selectedIndex].value != -1){ forms['jump'].submit() }\">");

    $res = mysql_query("SELECT * FROM forums ORDER BY fid") or sqlerr(__FILE__, __LINE__);

    while ($arr = mysql_fetch_assoc($res)) {

    if (get_user_class() >= $arr["minclassread"])
    print("<option value=" . $arr["id"] . ($currentforum == $arr["id"] ? " selected>" : ">") . $arr["name"] . "");
    }

    print("</select>");

    print("&nbsp;<input type=submit value='Und ab!'>");

    print("</form>");
  }



//-------- Inserts a compose frame

function insert_compose_frame($id, $newtopic = true, $quote = false) {
global $maxsubjectlength, $CURUSER;

if ($newtopic) {
$res = mysql_query("SELECT name, allowpoll FROM forums WHERE id=$id") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res) or stderr("Forum Fehler", "<b><p>Falsche Foren ID.</p></b>");
$forumname = $arr["name"];
$allowpoll = $arr["allowpoll"];

print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>".$GLOBALS["SITENAME"]." Forum - Thema erstellen</h1>
	<div class='x264_title_content'>";

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"99%\" class=\"tableinborder\">
<tr><td align=\"center\" colspan=\"2\" width=\"100%\" class=\"x264_wrapper_content_out_mount\"><span class=\"normalfont\"><b>Neues Thema im Forum: <a href=?action=viewforum&forumid=$id><i>\"$forumname\"</i></a> erstellen</b></span></td></tr>");

} else {
$res = mysql_query("SELECT * FROM topics WHERE id=$id") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res) or stderr("Forum Fehler", "<b><p>Das Thema konnte nicht gefunden werden.</p></b>");
$subject = $arr["subject"];

print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>".$GLOBALS["SITENAME"]." Forum - Antwort erstellen</h1>
	<div class='x264_title_content'>";

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"99%\" class=\"tableinborder\">
<tr><td align=\"center\" colspan=\"2\" width=\"100%\" class=\"x264_wrapper_content_out_mount\"><span class=\"normalfont\"><b>Antwort zum Thema <a href=?action=viewtopic&topicid=$id><i>$subject</i></a> erstellen</b></span></td></tr>");

}
print("<form action=\"?action=post\" method=\"post\" name=\"body\" enctype=\"multipart/form-data\">");

if ($newtopic)
print("<input type=\"hidden\" name=\"forumid\" value=\"$id\">");

else
print("<input type=\"hidden\" name=\"topicid\" value=\"$id\">");


if ($newtopic)
print("<tr><td class=\"tableb\"><b>Thema:</b></td><td class=\"inposttable\"><input type=\"text\" size=\"110\" maxlength=\"$maxsubjectlength\" name=\"subject\" border=\"0\" height=\"15\"></td></tr>");

if ($quote) {
$postid = $_GET["postid"];
if (!is_valid_id($postid))
die;

$res = mysql_query("SELECT posts.*, users.username, users.info FROM posts JOIN users ON posts.userid = users.id WHERE posts.id=$postid") or sqlerr(__FILE__, __LINE__);

if (mysql_num_rows($res) != 1)
stderr(" Forum Fehler", "<b><p>Es ist kein Thema mit der ID $postid vorhanden.</p></b>");

$arr = mysql_fetch_assoc($res);
$info = $arr[info];
}

$body1 = "" . $arr["body"] . "";
if ($info) {
$body1 .= "\n\n$info";
}

$body[text] = ($quote?(("[quote=".htmlspecialchars($arr["username"])."]".$body1."[/quote]")):"");
?>
<tr><td class="tableb"><b>Text:</b></td><td align="left" class="tablea" input type="text" style="padding: 0px"><? textbbcode("body","body","$body[text]")?></td></tr>
<?

if ($newtopic) {
print("<tr><td colspan=\"2\" class=\"tableb\">&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" name=\"bedanko\" value=\"2\" style=\"vertical-align: middle;\"> <b>Danke-Button aktivieren.</b></td></tr>");
}


if ($newtopic && ($allowpoll == "yes")) {

print("</table>");
print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"99%\" class=\"tableinborder\">");
print("<tr><td class=\"tablea\">");
print("<b><p>Wenn du zu dem Thema keine Umfrage hinzufügen möchtest, dann lass die Felder einfach leer.</p></b>");
print("</td></tr></table>");

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"99%\" class=\"tableinborder\">
<tr><td align=\"center\" width=\"100%\" class=\"x264_wrapper_content_out_mount\"><span class=\"normalfont\"><b>Umfrage erstellen</b></span></td></tr>");

?>
<tr><td align="center" class="tablea" style="padding: 0px">
<table align="center" border="0" cellspacing="0" cellpadding="5">
<tr><td class="tableb">Frage <font color="red">*</font></td><td class="tablea" align="left"><input name="question" size="100" maxlength="255" value="<?=htmlspecialchars($poll["question"])?>"></td></tr>
<tr><td class="tableb">Antwort 1 <font color="red">*</font></td><td class="tablea" align="left"><input name="option0" size="100" maxlength="150" value="<?=htmlspecialchars($poll["option0"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 2 <font color="red">*</font></td><td class="tablea" align="left"><input name="option1" size="100" maxlength="150" value="<?=htmlspecialchars($poll["option1"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 3</td><td class="tablea" align="left"><input name="option2" size="100" maxlength="150" value="<?=htmlspecialchars($poll["option2"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 4</td><td class="tablea" align="left"><input name="option3" size="100" maxlength="150" value="<?=htmlspecialchars($poll["option3"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 5</td><td class="tablea" align="left"><input name="option4" size="100" maxlength="150" value="<?=htmlspecialchars($poll["option4"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 6</td><td class="tablea" align="left"><input name="option5" size="100" maxlength="150" value="<?=htmlspecialchars($poll["option5"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 7</td><td class="tablea" align="left"><input name="option6" size="100" maxlength="150" value="<?=htmlspecialchars($poll["option6"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 8</td><td class="tablea" align="left"><input name="option7" size="100" maxlength="150" value="<?=htmlspecialchars($poll["option7"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 9</td><td class="tablea" align="left"><input name="option8" size="100" maxlength="150" value="<?=htmlspecialchars($poll["option8"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 10</td><td class="tablea" align="left"><input name="option9" size="100" maxlength="150" value="<?=htmlspecialchars($poll["option9"])?>"><br></td></tr>
<tr><td class="tableb">Sortieren</td><td class="tablea" align="left">
<input type="radio" name="sort" value="yes" <?=$poll["sort"] == "yes" ? " checked" : "" ?> style="vertical-align: middle;"> Ja
<input type="radio" name="sort" value="no" <?=$poll["sort"] == "no" ? " checked" : "" ?> style="vertical-align: middle;"> Nein
</td></tr>
</table>
<p><font color="red">*</font> Bei einer Umfrage müssen mindestens diese Felder ausgefüllt sein!</p>
</td></tr>
</table>
<?
} else {

print("</td></tr></table>");
}

print("<p align=\"center\"><input type=\"submit\" value=\"Und ab!\" class=\"btn\"></form></p>");


  //------ Get 10 last posts if this is a reply

if (!$newtopic) {
$postres = mysql_query("SELECT * FROM posts WHERE topicid=$id ORDER BY id DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"99%\" class=\"tableinborder\">
<tr><td align=\"center\" width=\"100%\" class=\"x264_wrapper_content_out_mount\"><span class=\"normalfont\"><b>Die 10 letzten Beiträge in umgekehrter Reihenfolge</b></span></td></tr>
<tr><td class=\"tablea\">");

while ($post = mysql_fetch_assoc($postres)) {

  //-- Get poster details

$userres = mysql_query("SELECT * FROM users WHERE id=" . $post["userid"] . " LIMIT 1") or sqlerr(__FILE__, __LINE__);
$user = mysql_fetch_assoc($userres);

if ($user["avatar"]) {
$avatar = ("<img style=\"width:100px;\" src=\"".htmlspecialchars($user["avatar"])."\">");

} else {
$avatar = ("<img style=\"max-width:100px;\" src=\"".$GLOBALS["PIC_BASE_URL"]."default_avatar.gif\">");
}

print("<br><table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"700\" class=\"tableinborder\">
<tr><td colspan=\"2\" width=\"100%\" class=\"tablecat\"><span class=\"normalfont\"><b>Vom:</b> " . $post["added"] . "</span></td></tr>");

print("<tr><td align=\"center\" valign=\"top\" class=\"tableb\" width=\"100\">");
print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\" width=\"100\">
<tr><td align=\"center\" valign=\"top\" class=\"tabled\" width=\"100\">$avatar</td></tr>");
print("<tr><td class=\"tabled\" width=\"100\">
<font class=\"".get_class_color($user["class"])."\"><b>".$user["username"]."</b></font>
</td></tr></table>");

$body = "<div style=\"width:100%;min-height:100px;overflow:auto;\">" . format_comment($post["body"]) . "</div>";
if (is_valid_id($post['editedby'])) {
$res4 = mysql_query("SELECT id, username, class, anon FROM users WHERE id=$post[editedby]");
if (mysql_num_rows($res4) == 1) {
$arr4 = mysql_fetch_assoc($res4);
if ($arr4[anon] == no  || (($arr4[id] == $CURUSER[id]) || get_user_class() >= UC_MODERATOR)) {
$body .= "<p><font class=\"smallfont\">Zuletzt bearbeitet von <a href=\"userdetails.php?id=$post[editedby]\"><b><font class=\"".get_class_color($arr4["class"])."\">$arr4[username]</font></b></a> am $post[editedat]</font>.</p>";

} else {
$body .= "<p><font class=\"smallfont\">Zuletzt bearbeitet von <b><font class=\"".get_class_color($arr4["class"])."\">$arr4[username]</font></b> am $post[editedat]</font>.</p>";
  }
 }
}

print("</td><td class=\"tablea\" valign=\"top\" width=\"650\">$body</td></tr>");
print("</table>");
}

print("<br><table align=\"center\" cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"700\" class=\"tableinborder\">");
print("<tr><td width=\"20%\" class=\"tablec\">&nbsp;<form method=\"post\" action=\"forums.php?action=search\" style=\"display:inline\"><input type=\"submit\" value=\"Suche\"></form></td>");
print("<td width=\"80%\" class=\"tablec\" align=\"right\">");

print("".insert_quick_jump_menu()."");

print("</td></tr></table>");
print("</td></tr></table>");
}

print "	
		</div>
</div>
</div>";
}

  //-------- Global variables

$maxsubjectlength = 40;
$postsperpage = $CURUSER["postsperpage"];
if (!$postsperpage) $postsperpage = 25;

  //-------- Action: New topic

if ($action == "newtopic") {
$forumid = $_GET["forumid"];

if (!is_valid_id($forumid))
die;

x264_admin_header("".$GLOBALS["SITENAME"]." Forum");
set_forum_online();
insert_compose_frame($forumid);

print "	
		</div>
</div>
</div>";
x264_admin_footer();
die;
}

  //-------- Action: Post

if ($action == "post") {
$forumid = 0 + $_POST["forumid"];
$topicid = 0 + $_POST["topicid"];

if (!is_valid_id($forumid) && !is_valid_id($topicid))
   stderr("Forum Fehler", "<b><p>Falsche Foren oder Themen ID.</p></b>");

$newtopic = $forumid > 0;
$subject = $_POST["subject"];

if ($newtopic) {
$subject = trim($subject);

if (!$subject)
   stderr("Forum Fehler", "<b><p>Du musst eine Überschrift eingeben.</p></b>");

if (strlen($subject) > $maxsubjectlength)
    stderr("Forum Fehler", "<b><p>Die Überschrift hat die maxlänge von $maxsubjectlength Buchstaben erreicht.</p></b>");
}

else
$forumid = get_topic_forum($topicid) or stderr("Forum Fehler", "<b><p>Die Themen ID ist falsch.</p></b>");

  //------ Make sure sure user has write access in forum

$arr = get_forum_access_levels($forumid) or stderr("Forum Fehler", "<b><p>Die Themen ID ist falsch.</p></b>");

if (get_user_class() < $arr["write"] || ($newtopic && get_user_class() < $arr["create"]))
   stderr("Forum Fehler", "<b><p>Dir fehlen die Rechte um hier etwas schreiben zu können.</p></b>");

$body = trim($_POST["body"]);

if ($body == "")
   stderr("Forum Fehler", "<b><p>Der Inhalt darf nicht leer sein.</p></b>");

$userid = $CURUSER["id"];

if ($newtopic) {

  //---- Create topic

$subject = sqlesc($subject);

mysql_query("INSERT INTO topics (userid, forumid, subject) VALUES($userid, $forumid, $subject)") or sqlerr(__FILE__, __LINE__);

$topicid = mysql_insert_id() or stderr("Forum Fehler", "<b><p>Die Themen ID konnte nicht gefunden werden.</p></b>");

$polltopic = mysql_query("SELECT id FROM topics ORDER BY id DESC LIMIT 1");
$polltopicfetch = mysql_fetch_assoc($polltopic);
$polltopic2 = $polltopicfetch["id"];

  $question = $_POST["question"];
  $option0 = $_POST["option0"];
  $option1 = $_POST["option1"];
  $option2 = $_POST["option2"];
  $option3 = $_POST["option3"];
  $option4 = $_POST["option4"];
  $option5 = $_POST["option5"];
  $option6 = $_POST["option6"];
  $option7 = $_POST["option7"];
  $option8 = $_POST["option8"];
  $option9 = $_POST["option9"];
  $option10 = $_POST["option10"];
  $sort = $_POST["sort"];

  if ($question || $option0 || $option1)
 {
  	mysql_query("INSERT INTO forum_polls VALUES(0" .
		", '" . get_date_time() . "'" .
    ", " . sqlesc($question) .
    ", " . sqlesc($option0) .
    ", " . sqlesc($option1) .
    ", " . sqlesc($option2) .
    ", " . sqlesc($option3) .
    ", " . sqlesc($option4) .
    ", " . sqlesc($option5) .
    ", " . sqlesc($option6) .
    ", " . sqlesc($option7) .
    ", " . sqlesc($option8) .
    ", " . sqlesc($option9) .
    ", " . sqlesc($option10) .
    ", " . sqlesc($sort) .
    ", " . sqlesc($polltopic2) .
  	")") or sqlerr(__FILE__, __LINE__);
 }

  //------ Insert post

		$added = get_date_time();
		$body = $body;

		$pos = array();
			$pos["topicid"] = $topicid;
			$pos["userid"]  = $userid;
			$pos["added"]   = $added;
			$pos["body"]    = $body;
		$db -> insertRow($pos, "posts");

		$postid = $db -> insertID();

		$setbedanko = ($_POST["bedanko"] == "2" ? "yes" : "no");
		if ($setbedanko == 'yes')
		{
			$bedanko = 2;
		} 
		else 
		{
			$bedanko = 1;
		}
		$db -> execute("UPDATE posts SET bedanko = '$bedanko' WHERE id = '$postid'");
		$db -> execute("UPDATE forums SET postcount = postcount + 1 WHERE id=$forumid");
		$db -> execute("UPDATE forums SET topiccount = topiccount + 1 WHERE id=$forumid");
} else {

  //---- Make sure topic exists and is unlocked

$res = mysql_query("SELECT * FROM topics WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res) or stderr("Forum Fehler", "<b><p>Die Themen ID konnte nicht gefunden werden.</p></b>");

if ($arr["locked"] == 'yes' && get_user_class() < UC_MODERATOR)
   stderr("Forum Fehler", "<b><p>Dieses Thema ist geschlossen.</p></b>");

  //---- Get forum ID

	$added = get_date_time();
	$body = $body;

	$pos = array();
		$pos["topicid"] = $topicid;
		$pos["userid"]  = $userid;
		$pos["added"]   = $added;
		$pos["body"]    = $body;
	$db -> insertRow($pos, "posts");
	
	$postid = $db -> insertID(); 
	$db -> execute("UPDATE users SET topic='yes' WHERE topic='no'");
	$db -> execute("UPDATE forums SET postcount = postcount + 1 WHERE id=$forumid");
}
  //------ Update topic last post

update_topic_last_post($topicid);

  //------ All done, redirect user to the post

$headerstr = "Location: $BASEURL/forums.php?action=viewtopic&topicid=$topicid&page=last";

if ($newtopic)
header($headerstr);

else
header("$headerstr#$postid");
die;
}

  //-------- Action: vote

if ($action == "vote") {
    
    $choice = $_POST["choice"];
    $returnto = $_POST["returnto"];
    $topicidvote = $_POST["topicidvote"];
    if ($CURUSER && $choice != "" && $choice < 256 && $choice == floor($choice))
    {
        $respoll = mysql_query("SELECT * FROM forum_polls WHERE topicid=$topicidvote") or sqlerr();
        $arrpoll = mysql_fetch_assoc($respoll) or die("No poll");
        $pollid = $arrpoll["id"];
        $userid = $CURUSER["id"];
        $respoll = mysql_query("SELECT * FROM forum_pollanswers WHERE pollid=$pollid && userid=$userid") or sqlerr();
        $arrpoll = mysql_fetch_assoc($respoll);
        if ($arrpoll)
            die("Doppelter Vote");
        mysql_query("INSERT INTO forum_pollanswers VALUES(0, $pollid, $userid, $choice)") or sqlerr();
        if (mysql_affected_rows() != 1)
            stderr("Forum Fehler", "<b><p>Es ist ein Fehler aufgetreten, deine Stimme konnte leider nicht gezählt werden.</p></b>");
        header("Location: $returnto".SID);
        die;
    }
}

  //-------- Action: View topic

if ($action == "viewtopic") {
$topicid = $_GET["topicid"];
$page = $_GET["page"];

if (!is_valid_id($topicid))
die;

$userid = $CURUSER["id"];

  //------ Get topic info

$res = mysql_query("SELECT * FROM topics WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res) or stderr("Forum Fehler", "<b><p>Das Thema konnte nicht gefunden werden.</p></b>");

$locked = ($arr["locked"] == 'yes');
$subject = $arr["subject"];
$sticky = $arr["sticky"] == "yes";
$forumid = $arr["forumid"];

  //------ Update hits column

mysql_query("UPDATE topics SET views = views + 1 WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

  //------ Get forum

$res = mysql_query("SELECT * FROM forums WHERE id=$forumid") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res) or die("Forum = NULL");

$forum = $arr["name"];

if ($CURUSER["class"] < $arr["minclassread"])
   stderr("Forum Fehler", "<b><p>Du hast keine Leserechte in diesem Forum.</p></b>");

  //------ Get post count

$res = mysql_query("SELECT COUNT(*) FROM posts WHERE topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);

$postcount = $arr[0];

  //------ Make page menu

$pagemenu = "<p>\n";
$perpage = $postsperpage;
$pages = ceil($postcount / $perpage);

if ($page[0] == "p") {
$findpost = substr($page, 1);
$res = mysql_query("SELECT id FROM posts WHERE topicid=$topicid ORDER BY added") or sqlerr(__FILE__, __LINE__);
$i = 1;

while ($arr = mysql_fetch_row($res)) {
if ($arr[0] == $findpost)
break;
++$i;
}
$page = ceil($i / $perpage);
}

if ($page == "last")
$page = $pages;

else {
if($page < 1)
$page = 1;

elseif ($page > $pages)
$page = $pages;
}

$offset = $page * $perpage - $perpage;

for ($i = 1; $i <= $pages; ++$i) {
if ($i == $page)
$pagemenu .= "<center><font class=gray><b>$i</b></font><center>";

else
$pagemenu .= "<a href=?action=viewtopic&topicid=$topicid&page=$i><b>$i</b></a>";
}

if ($page == 1)
$pagemenu .= "<br><font class=gray><b>&lt;&lt; Zurück</b></font>";

else
$pagemenu .= "<br><a href=?action=viewtopic&topicid=$topicid&page=".($page - 1)."><b>&lt;&lt; Zurück</b></a>";
$pagemenu .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

if ($page == $pages)
$pagemenu .= "<font class=gray><b>Nächste &gt;&gt;</b></font></p>\n";

else
$pagemenu .= "<a href=?action=viewtopic&topicid=$topicid&page=".($page + 1)."><b>Nächste &gt;&gt;</b></a></p>";

  //------ Get posts

$res = mysql_query("SELECT * FROM posts WHERE topicid=$topicid ORDER BY id LIMIT $offset,$perpage") or sqlerr(__FILE__, __LINE__);

x264_admin_header("".$GLOBALS["SITENAME"]." Forum");
set_forum_online();
print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>".$GLOBALS["SITENAME"]." Forum</h1>
	<div class='x264_title_content'>";


  //------ Print table

print("<a name=top><table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"99%\" class=\"tableinborder\">
<tr><td width=\"100%\" class=\"x264_wrapper_content_out_mount\"><span class=\"smalfont\"><a href=\"forums.php\"><b>".$GLOBALS["SITENAME"]." Forum</b></a> - <a href=\"forums.php?action=viewforum&forumid=$forumid\"><b>$forum</b></a> - <b><i>\"$subject\"</i></b></span></td></tr>
<tr><td class=\"tablea\"><br>");


  //------ Get poll info


    $respoll = mysql_query("SELECT * FROM forum_polls WHERE topicid=$topicid") or sqlerr();
    $arrpoll = mysql_fetch_assoc($respoll);
    if (is_array($arrpoll)) {
        $pollid = $arrpoll["id"];
        $question = $arrpoll["question"];
        $o = array($arrpoll["option0"], $arrpoll["option1"], $arrpoll["option2"], $arrpoll["option3"], $arrpoll["option4"],
            $arrpoll["option5"], $arrpoll["option6"], $arrpoll["option7"], $arrpoll["option8"], $arrpoll["option9"],
            $arrpoll["option10"]);

        // check if user has already voted
        $respoll = mysql_query("SELECT * FROM forum_pollanswers WHERE pollid=$pollid AND userid=$userid") or sqlerr();
        $arr2poll = mysql_fetch_assoc($respoll);

    print("<a name=top><table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"700\" class=\"tableinborder\">
           <tr><td width=\"100%\" class=\"x264_wrapper_content_out_mount\"><span class=\"smalfont\"><b>Umfrage: $question</b></span></td></tr>
           <tr><td class=\"tablea\"><br>");

    $voted = $arr2poll;

    if ($voted)
    {

        // display results
        if ($arrpoll["selection"])
            $uservote = $arrpoll["selection"];
        else
            $uservote = -1;
        // we reserve 255 for blank vote.
        $respoll = mysql_query("SELECT selection FROM forum_pollanswers WHERE pollid=$pollid AND selection < 20") or sqlerr();
        $tvotes = mysql_num_rows($respoll);
        $vs = array();
        $os = array();

        // count votes
        while ($arr2poll = mysql_fetch_row($respoll))
            $vs[$arr2poll[0]] += 1;

        reset($o);
        for ($i = 0; $i < count($o); ++$i)
            if ($o[$i])
                $os[$i] = array($vs[$i], $o[$i]);

        function srt($a,$b)
        {
            if ($a[0] > $b[0]) return -1;
            if ($a[0] < $b[0]) return 1;
            return 0;
        }

        // now os is an array like this: array(array(123, "Option 1"), array(45, "Option 2"))
        if ($arrpoll["sort"] == "yes")
            usort($os, srt);

        print("<table border=0 cellspacing=0 cellpadding=2>");
        $i = 0;
        while ($a = $os[$i])
        {
            if ($i == $uservote)
                $a[1] .= "&nbsp;*";
            if ($tvotes == 0)
                $p = 0;
            else
                $p = round($a[0] / $tvotes * 100);

        print("<tr><td nowrap align=left>" . $a[1] . "&nbsp;&nbsp;</td><td align=left>" .
        "<img src=\"".$GLOBALS["DEinfoN_PATTERN"].$GLOBALS["ss_uri"]."/vote_left".(($i%5)+1).".gif\"><img src=\"".$GLOBALS["DEinfoN_PATTERN"].$GLOBALS["ss_uri"]."/vote_middle".(($i%5)+1).".gif\" height=9 width=" . ($p * 5) .
        "><img src=\"".$GLOBALS["DEinfoN_PATTERN"].$GLOBALS["ss_uri"]."/vote_right".(($i%5)+1).".gif\"> $p%</td></tr>");
        $i++;
        }
        print("</table>");
        $tvotes = number_format($tvotes);
        print("<p align=center>Abgebene Stimmen: $tvotes</p>");

    } else {

        print("<form method=post action=\"?action=vote&topicid=$topicid\">");
        $i = 0;
        while ($a = $o[$i])
        {
            print("<input type=radio name=choice value=$i>$a<br>");
            ++$i;
        }
    print("<br>");
    print("<input type=radio name=choice value=255>Ich will keine Stimme abgeben, ich m&ouml;chte nur das Ergebnis sehen!<br>");
    print("<input type=\"hidden\" name=\"returnto\" value=\"$BASEURL$_SERVER[REQUEST_URI]\">");
    print("<input type=\"hidden\" name=\"topicidvote\" value=\"$topicid\">");
    print("<p align=center><input type=submit value='Vote!' class=btn></p>");
    print("</form>");
    }
?>
</td></tr>
</table><br>
<?
}

$arr = get_forum_access_levels($forumid) or die;
$maypost = get_user_class() >= $arr["write"];

if (get_user_class() >= UC_MODERATOR)
$aktion = ("<form method=\"post\" action=\"forums.php?action=reply&topicid=$topicid\" style=\"display:inline\"><input type=\"submit\" value=\"Antworten\"></form>");
else

if ($locked && get_user_class() < UC_MODERATOR && $maypost) {
$aktion = ("<input type=\"submit\" value=\"Thema geschlossen\">");
} else {
if (!$locked && !$maypost) {
$aktion = ("<input type=\"submit\" value=\"Keine Schreibrechte\">");
} else {
$aktion = ("<form method=\"post\" action=\"forums.php?action=reply&topicid=$topicid\" style=\"display:inline\"><input type=\"submit\" value=\"Antworten\"></form>");
 }
}


$pc = mysql_num_rows($res);
$pn = 0;
$r = mysql_query("SELECT lastpostread FROM readposts WHERE userid=" . $CURUSER["id"] . " AND topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$a = mysql_fetch_row($r);
$lpr = $a[0];

if (!$lpr)
mysql_query("INSERT INTO readposts (userid, topicid) VALUES($userid, $topicid)") or sqlerr(__FILE__, __LINE__);

while ($arr = mysql_fetch_assoc($res)) {
++$pn;
$postid = $arr["id"];
$posterid = $arr["userid"];
$added = $arr["added"];
$body = $arr["body"];
$email = $arr["guestmail"];
$user = $arr["guestname"];
$answer = $arr["answer"];
$bedanko = $arr["bedanko"];

  //---- Get poster thanks

$resa = mysql_query("SELECT * FROM postthanks WHERE topicid = $topicid") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($resa) > 0) {
while ($arra = mysql_fetch_array($resa)) {
$ptuserid = $arra["userid"];
$ptpostid = $arra["postid"];

$resb = mysql_query("SELECT id, username, class, anon FROM users WHERE id = $ptuserid") or print(mysql_error());
while ($arrb = mysql_fetch_assoc($resb)) {
if ($thanks) $thanks .= ",\n";

if ($arrb[anon] == no  || (($arrb[id] == $CURUSER[id]) || get_user_class() >= UC_MODERATOR)) {
$thanks .= "<a href=userdetails.php?id=" . $arrb["id"] . "><font class=".get_class_color($arrb["class"])."><b>" . $arrb["username"] . "</b></font></a>";
} else {
$thanks .= "<font class=".get_class_color($arrb["class"])."><b>" . $arrb["username"] . "</b></font>";
   }
  }
 }
}

$thanksbutton = ("<form method=\"post\" action=\"forums.php?action=thanks&topicid=$topicid&postid=$postid&userid=$userid\" style=\"display:inline\"><input type=\"submit\" value=\"Bedanken\"></form>");


  //---- Get poster details

$res2 = mysql_query("SELECT * FROM users WHERE id=$posterid") or sqlerr(__FILE__, __LINE__);
$arr2 = mysql_fetch_assoc($res2);
$anon = $arr2[anon];
$info = $arr2[info];

$dt = time() - 180;
$dt = sqlesc(get_date_time($dt)); 

$postername = ("<font class=\"".get_class_color($arr2['class'])."\">$arr2[username]</font>");

if ($arr[guestuser] == "yes") {
$by = "<b>Gast: $arr[guestname]</b>";
} else {
if ($arr2[username] == "") {
$by = "<b>Gelöscht</b>";

} else {
if ($anon && (($posterid == $CURUSER[id]) || get_user_class() >= UC_MODERATOR)) {
$by = "<a href=userdetails.php?id=$posterid><b>$postername</b></a>" . ($arr2["donor"] == "yes" ? " <img src=\"".
$GLOBALS["PIC_BASE_URL"]."star.gif\" title=\"Dieses Mitglied hat gespendet\">" : "") . ($arr2["enabled"] == "no" ? "<img src=\"".
$GLOBALS["PIC_BASE_URL"]."disabled.gif\" title=\"Dieses Mitglied wurde gesperrt\" style='margin-left: 2px'>" : ($arr2["warned"] == "yes" ? "<a href=rules.php#warning class=altlink><img src=\"".$GLOBALS["PIC_BASE_URL"]."warned.gif\" title=\"Dieses Mitglied wurde verwarnd\" border=\"0\"></a>" : "")) . "";

} else {
$by = "<b>$postername</b>";
 }
}
}
print("<a name=$postid>");

if ($pn == $pc) {
print("<a name=last>");
if ($postid > $lpr)
mysql_query("UPDATE readposts SET lastpostread=$postid WHERE userid=$userid AND topicid=$topicid") or sqlerr(__FILE__, __LINE__);
}

if ($arr2["avatar"]) {
$avatar = ("<img style=\"width:120px;\" src=\"".htmlspecialchars($arr2["avatar"])."\">");

} else {
$avatar = ("<img style=\"max-width:120px;\" src=\"".$GLOBALS["PIC_BASE_URL"]."default_avatar.gif\">");
}

$res3 = mysql_query("SELECT COUNT(*) FROM posts WHERE userid=$posterid") or sqlerr(__FILE__, __LINE__);
$arr3 = mysql_fetch_row($res3);
$forumposts = $arr3[0];


print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"770\" class=\"tableinborder\">
<tr><td align=\"center\" class=\"tabled\">$by</td>
<td class=\"tabled\" style=\"vertical-align: middle;\">
<table width=\"100%\"><tr><td class=\"tabled\"><b>Vom:</b> $added</td>
<td align=\"right\" class=\"tabled\" style=\"vertical-align: middle;\">");


if ($arr["guestuser"] == "no") {
print("$aktion");
} else {
if ($arr["guestuser"] == "yes" && $arr["answer"] == "no") {
print("<form method=\"post\" action=\"staffemail.php?action=send&email=$email&user=$user&title=$subject&postid=$postid\" style=\"display:inline\"><input type=\"submit\" value=\"Antworten\"></form>");
} else {

print("<form method=\"post\" action=\"forums.php?action=answer&topicid=$topicid&postid=$postid\" style=\"display:inline\"><input type=\"submit\" value=\"Bearbeitet\"></form>");
 }
}


if ($arr[guestuser] == "no") {
if (!$locked && $maypost) {
print("&nbsp;<form method=\"post\" action=\"forums.php?action=quotepost&topicid=$topicid&postid=$postid\" style=\"display:inline\"><input type=\"submit\" value=\"Zitieren\"></form>");
}
if (($CURUSER["id"] == $posterid && !$locked) || get_user_class() >= UC_MODERATOR) {
print("&nbsp;<form method=\"post\" action=\"forums.php?action=edit&postid=$postid&forumid=$forumid\" style=\"display:inline\"><input type=\"submit\" value=\"Bearbeiten\"></form>");
}
if (get_user_class() >= UC_MODERATOR) {
print("&nbsp;<form method=\"post\" action=\"forums.php?action=deletepost&postid=$postid&forumid=$forumid\" style=\"display:inline\"><input type=\"submit\" value=\"Löschen\"></form>");
}
}

if ($arr[guestuser] == "no") {
print("&nbsp;<form method=\"post\" action=\"treport.php?postid=$postid\" style=\"display:inline\"><input type=\"submit\" value=\"Melden\"></form>");
}
print("&nbsp;<a href=\"#top\"><img src=\"".$GLOBALS["PIC_BASE_URL"]."top.gif\" border=0 title='Top'></a></td></tr></table></td></tr>");

print("<tr><td align=\"center\" valign=\"top\" class=\"tableb\" width=\"120\">");

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"0\" border=\"0\" width=\"100\">
<tr><td align=\"center\" valign=\"top\" class=\"tabled\" width=\"120\">$avatar</td></tr>");
print("<tr><td class=\"tabled\" width=\"120\">");

if ($forumposts && (($posterid == $CURUSER[id]) || get_user_class() >= UC_MODERATOR)) {
print("Beiträge: <a href=\"userhistory.php?action=viewposts&id=$posterid\">$forumposts</a>");

} else {
print("Beiträge: $forumposts");
}
print("</td></tr></table>");

$body1 = "".format_comment($arr["body"])."";

if ($bedanko == "2") {
$body1 .= "<br>$thanksbutton<br>";
}

if ($thanks && $ptpostid == $postid) {
$body1 .= "<br>Für diesen Beitrag haben sich bedankt:";
$body1 .= "<br>$thanks";
}

if (is_valid_id($arr['editedby'])) {
$res4 = mysql_query("SELECT id, username, class, anon FROM users WHERE id=$arr[editedby]");
if (mysql_num_rows($res4) == 1) {
$arr4 = mysql_fetch_assoc($res4);
if ($arr4[anon] == no  || (($arr4[id] == $CURUSER[id]) || get_user_class() >= UC_MODERATOR)) {
$body1 .= "<br><br><font class=\"smallfont\">Zuletzt bearbeitet von <a href=\"userdetails.php?id=$arr[editedby]\"><b><font class=\"".get_class_color($arr4["class"])."\">$arr4[username]</font></b></a> am $arr[editedat]</font>.";

} else {
$body1 .= "<br><br><font class=\"smallfont\">Zuletzt bearbeitet von <b><font class=\"".get_class_color($arr4["class"])."\">$arr4[username]</font></b> am $arr[editedat]</font>.";
  }
 }
}

if ($info) {
$body1 .= "<br>____________________<br>".format_comment($info)."";
}

print("</td><td class=\"tablea\" valign=\"top\" width=\"650\"><div style=\"width:100%;min-height:100px;overflow:auto;\">".$body1."</div></td></tr>");

print("<tr><td align=\"center\" class=\"tableb\">");
print("&nbsp;".("'" . $arr2['last_access'] . "'" > $dt?"<font color=\"green\"><b>Online</b></font>":"<font color=\"red\"><b>Offline</b></font>") . "");
print("</td><td class=\"tableb\">");

if ($arr[guestuser] == "no") {
if ($CURUSER[id] != $posterid) {
print("&nbsp;<form method=\"post\" action=\"messages.php?action=send&receiver=$posterid\" style=\"display:inline\"><input type=\"submit\" value=\"PN\" class=\"btn\"></form>");
print("&nbsp;<form method=\"post\" action=\"friends.php?action=add&targetid=$posterid&type=friend\" style=\"display:inline\"><input type=\"hidden\" name=\"type\" value=\"friend\"><input type=\"submit\" value=\"Freund\" class=\"btn\"></form>");
print("&nbsp;<form method=\"post\" action=\"friends.php?action=add&targetid=$posterid&type=block\" style=\"display:inline\"><input type=\"hidden\" name=\"type\" value=\"block\"><input type=\"submit\" value=\"Blocken\" class=\"btn\"></form>");
}
if ($arr2[anon] == no  || (($posterid == $CURUSER[id]) || get_user_class() >= UC_MODERATOR)) {
if ($arr2["icq"]) {
print("&nbsp;<img style=\"vertical-align: middle;\" src=\"http://web.icq.com/whitepages/online?icq=".$arr2["icq"]."&img=5\"  alt=\"icq\" title=\"icq\" border=\"0\"> ".htmlspecialchars($arr2["icq"])."");
}
if ($arr2["msn"]) {
print("&nbsp;<img style=\"vertical-align: middle;\" src=\"".$GLOBALS["PIC_BASE_URL"]."/messenger/msn.gif\" alt=\"msn\" title=\"msn\" border=\"0\"> ".htmlspecialchars($arr2["msn"])."");
}
if ($arr2["aim"]) {
print("&nbsp;<img style=\"vertical-align: middle;\" src=\"".$GLOBALS["PIC_BASE_URL"]."/messenger/aim.gif\" alt=\"aim\" title=\"aim\" border=\"0\"> ".htmlspecialchars($arr2["aim"])."");
}
if ($arr2["yahoo"]) {
print("&nbsp;<img style=\"vertical-align: middle;\" src=\"".$GLOBALS["PIC_BASE_URL"]."/messenger/yahoo.gif\" alt=\"yahoo\" title=\"yahoo\" border=\"0\"> ".htmlspecialchars($arr2["yahoo"])."");
}
if ($arr2["skype"]) {
print("&nbsp;<img style=\"vertical-align: middle;\" src=\"http://mystatus.skype.com/smallicon/".$arr2["skype"]."\" alt-\"skype\" title=\"skype\" border=\"0\"> ".htmlspecialchars($arr2["skype"])."");
  }
 }
}

print("</td></tr></table><br>");
}

print("<table align=\"center\" cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">");
print("<tr><td width=\"20%\" class=\"tabled\"><form method=\"post\" action=\"forums.php?action=search\" style=\"display:inline\"><input type=\"submit\" value=\"Suche\"></form></td>");
print("<td width=\"80%\" class=\"tabled\" align=\"right\">");

print("".insert_quick_jump_menu()."");

print("</td></tr></table>");
print("</td></tr></table>");

print($pagemenu);


  //------ Mod options

if (get_user_class() >= UC_MODERATOR) {
$res = mysql_query("SELECT id, name, minclasswrite FROM forums ORDER BY name") or sqlerr(__FILE__, __LINE__);

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"700\" class=\"tableinborder\">
<tr><td align=\"center\" colspan=\"2\" width=\"100%\" class=\"x264_wrapper_content_out_mount\"><span class=\"normalfont\"><b>Mod-Panel</b></span></td></tr>");

print("<form method=\"post\" action=\"?action=setsticky\">");
print("<input type=\"hidden\" name=\"topicid\" value=\"$topicid\">");
print("<input type=\"hidden\" name=\"returnto\" value=\"$BASEURL$_SERVER[REQUEST_URI]\">");
print("<tr><td class=\"tableb\" align=\"right\"><b>Sticky:</b>&nbsp;</td>");
print("<td class=\"tablea\"><input type=\"radio\" name=\"sticky\" value=\"yes\" ".($sticky ? " checked" : "")."> Ja <input type=\"radio\" name=\"sticky\" value=\"no\" ".(!$sticky ? " checked" : "")."> Nein&nbsp;");
print("<input type=\"submit\" value=\"Und ab!\"></td></tr>");
print("</form>");

print("<form method=\"post\" action=\"?action=setlocked\">");
print("<input type=\"hidden\" name=\"topicid\" value=\"$topicid\">");
print("<input type=\"hidden\" name=\"returnto\" value=\"$BASEURL$_SERVER[REQUEST_URI]\">");
print("<tr><td class=\"tableb\" align=\"right\"><b>Schliessen:</b>&nbsp;</td>");
print("<td class=\"tablea\"><input type=\"radio\" name=\"locked\" value=\"yes\" ".($locked ? " checked" : "")."> Ja <input type=\"radio\" name=\"locked\" value=\"no\" ".(!$locked ? " checked" : "")."> Nein&nbsp;");
print("<input type=\"submit\" value=\"Und ab!\"></td></tr>");
print("</form>");

print("<form method=\"post\" action=\"?action=renametopic\">");
print("<input type=\"hidden\" name=\"topicid\" value=\"$topicid\">");
print("<input type=\"hidden\" name=\"returnto\" value=\"$BASEURL$_SERVER[REQUEST_URI]\">");
print("<tr><td class=\"tableb\" align=\"right\"><b>Titel Editieren:</b>&nbsp;</td>");
print("<td class=\"tablea\"><input type=\"text\" name=\"subject\" size=\"60\" maxlength=\"$maxsubjectlength\" value=\"".htmlspecialchars($subject)."\">&nbsp;");
print("<input type=\"submit\" value=\"Und ab!\"></td></tr>");
print("</form>");

print("<form method=\"post\" action=\"?action=movetopic&topicid=$topicid&\">");
print("<input type=\"hidden\" name=\"forumid2\" value=\"$forumid\">");
print("<tr><td align=\"right\" class=\"tableb\"><b>Verschieben nach:</b>&nbsp;</td>");
print("<td class=\"tablea\"><select name=\"forumid1\">");

while ($arr = mysql_fetch_assoc($res))
if ($arr["id"] != $forumid && get_user_class() >= $arr["minclasswrite"])
print("<option value=\"".$arr["id"]."\">".$arr["name"]."");

print("</select> <input type=\"submit\" value=\"Und ab!\"></td></tr>");
print("</form>");

print("<form method=\"get\" action=\"forums.php\">");
print("<input type=\"hidden\" name=\"action\" value=\"deletetopic\">");
print("<input type=\"hidden\" name=\"topicid\" value=\"$topicid\">");
print("<input type=\"hidden\" name=\"forumid\" value=\"$forumid\">");
print("<tr><td align=\"right\" class=\"tableb\"><b>Thread löschen:</b>&nbsp;");
print("</td><td class=\"tablea\"><input type=\"checkbox\" name=\"sure\" value=\"2\" style=\"vertical-align: middle;\">&nbsp;");
print("<input type=\"submit\" value=\"Und ab!\"></td></tr>");
print("</form>");
print("</table>");

}

print "	
		</div>
</div>
</div>";
x264_admin_footer();
die;
}

  //-------- Action: Thanks

if ($action == "thanks") {
$userid = $_GET["userid"];
$topicid = $_GET["topicid"];
$postid = $_GET["postid"];

if (!is_valid_id($topicid))
   stderr("Forum Fehler", "<b><p>Falsche Beitrags ID $postid.</p></b>");

mysql_query("INSERT INTO postthanks (id,topicid,postid,userid) VALUES (id,$topicid,$postid,$userid)") or sqlerr(__FILE__, __LINE__);

header("Location: $BASEURL/forums.php?action=viewtopic&topicid=$topicid");
die;
}

  //-------- Action: Answer

if ($action == "answer") {
$postid = $_GET["postid"];
$topicid = $_GET["topicid"];

if (!is_valid_id($postid))
   stderr("Forum Fehler", "<b><p>Falsche Beitrags ID $postid.</p></b>");

mysql_query("UPDATE posts SET answer='no' WHERE id=$postid AND answer='yes'") or sqlerr(__FILE__, __LINE__);

header("Location: $BASEURL/forums.php?action=viewtopic&topicid=$topicid");
die;
}

  //-------- Action: Quote

if ($action == "quotepost") {
$topicid = $_GET["topicid"];

if (!is_valid_id($topicid))
   stderr("Forum Fehler", "<b><p>Falsche Themen ID $topicid.</p></b>");

x264_admin_header("".$GLOBALS["SITENAME"]." Forum");
set_forum_online();
insert_compose_frame($topicid, false, true);

x264_admin_footer();
die;
}

  //-------- Action: Reply

if ($action == "reply") {
$topicid = $_GET["topicid"];

if (!is_valid_id($topicid))
die;

x264_admin_header("".$GLOBALS["SITENAME"]." Forum");
set_forum_online();
insert_compose_frame($topicid, false);

x264_admin_footer();
die;
}

  //-------- Action: Move topic

if ($action == "movetopic") {
$forumid1 = $_POST["forumid1"];
$topicid = $_GET["topicid"];
$forumid2 = $_POST["forumid2"];

if (!is_valid_id($forumid1) || !is_valid_id($topicid) || get_user_class() < UC_MODERATOR)
die;

  // Make sure topic and forum is valid

$res = @mysql_query("SELECT minclasswrite FROM forums WHERE id=$forumid1") or sqlerr(__FILE__, __LINE__);

if (mysql_num_rows($res) != 1)
   stderr("Forum Fehler", "<b><p>Das Forum konnte nicht gefunden werden.</p></b>");

$arr = mysql_fetch_row($res);

if (get_user_class() < $arr[0])
die;

$res = @mysql_query("SELECT subject,forumid FROM topics WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

if (mysql_num_rows($res) != 1)
   stderr("Forum Fehler", "<b><p>Das Thema konnte nicht gefunden werden.</p></b>");

$arr = mysql_fetch_assoc($res);

if ($arr["forumid"] != $forumid1)
@mysql_query("UPDATE topics SET forumid=$forumid1 WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

$res = mysql_query("SELECT COUNT(*) FROM posts WHERE topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);

$postcount = $arr[0];

 mysql_query("UPDATE forums SET postcount = postcount + $postcount WHERE id=$forumid1") or sqlerr(__FILE__, __LINE__);
 mysql_query("UPDATE forums SET topiccount = topiccount + 1 WHERE id=$forumid1") or sqlerr(__FILE__, __LINE__);
 mysql_query("UPDATE forums SET postcount = postcount - $postcount WHERE id=$forumid2") or sqlerr(__FILE__, __LINE__);
 mysql_query("UPDATE forums SET topiccount = topiccount - 1 WHERE id=$forumid2") or sqlerr(__FILE__, __LINE__);

  // Redirect to forum page

header("Location: $BASEURL/forums.php?action=viewforum&forumid=$forumid1");
die;
}

  //-------- Action: Delete topic

if ($action == "deletetopic") {
	$topicid = $_GET["topicid"];
	$forumid = $_GET["forumid"];

	if (!is_valid_id($topicid) || get_user_class() < UC_MODERATOR)
		die;

	$sure = $_GET["sure"];

	if ($sure == "") 
	{
    		stderr("Thema löschen", "<b><p>Du hast kein Thema zum löschen ausgewählt!</p></b>");
	}

	if ($sure == "2") 
	{
    		stderr("Thema löschen", "<b><p>Du bist im Begriff dieses Thema zu löschen?  Klicke <a href=?action=deletetopic&topicid=$topicid&forumid=$forumid&sure=1>HIER</a> wenn du dir sicher bist!</p></b>");
	}

	$arr = $db -> querySingleArray("SELECT COUNT(*) FROM posts WHERE topicid=$topicid");
	$postcount = $arr[0];

	$db -> execute("DELETE FROM topics WHERE id=$topicid");
	$db -> execute("DELETE FROM posts WHERE topicid=$topicid");
	$db -> execute("DELETE FROM readposts WHERE topicid=$topicid");
	$db -> execute("UPDATE forums SET postcount = postcount - $postcount WHERE id=$forumid");
	$db -> execute("UPDATE forums SET topiccount = topiccount - 1 WHERE id=$forumid");

	$arr = $db -> querySingleArray("SELECT id FROM forum_polls WHERE topicid=$topicid");
	$topicidpoll = $arr["id"];
	$db -> execute("DELETE FROM forum_pollanswers WHERE pollid=$topicidpoll");
	$db -> execute("DELETE FROM forum_polls WHERE topicid=$topicid");


header("Location: $BASEURL/forums.php?action=viewforum&forumid=$forumid");
die;
}

  //-------- Action: Edit post

if ($action == "editpost") {
$postid = $_GET["postid"];

if (!is_valid_id($postid))
die;

$res = mysql_query("SELECT * FROM posts WHERE id=$postid") or sqlerr(__FILE__, __LINE__);

if (mysql_num_rows($res) != 1)
   stderr("Forum Fehler", "<b><p>Es ist kein Beitrag mit der ID $postid vorhanden.</p></b>");

$arr = mysql_fetch_assoc($res);
$res2 = mysql_query("SELECT locked, subject FROM topics WHERE id = " . $arr["topicid"]) or sqlerr(__FILE__, __LINE__);
$arr2 = mysql_fetch_assoc($res2);

if (mysql_num_rows($res) != 1)
   stderr("Forum Fehler", "<b><p>Es ist kein Thema mit der ID $postid vorhanden.</p></b>");

$locked = ($arr2["locked"] == 'yes');

if (($CURUSER["id"] != $arr["userid"] || $locked) && get_user_class() < UC_MODERATOR)
    stderr("Forum Fehler", "<b><p>Du hast keine Berechtigung um diesen Beitrag zu ändern!</p></b>");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$subject = $_POST['subject'];

if ($subject == "")
    stderr("Forum Fehler", "<b><p>Das Thema darf nicht leer sein!</p></b>");

$subject = sqlesc($subject);

mysql_query("UPDATE topics SET subject=$subject WHERE id = " . $arr["topicid"]) or sqlerr(__FILE__, __LINE__);


$body = $_POST['body'];

if ($body == "")
    stderr("Forum Fehler", "<b><p>Der Inhalt darf nicht leer sein!</p></b>");

$body = sqlesc($body);
$editedat = sqlesc(get_date_time());

mysql_query("UPDATE posts SET body=$body, editedat=$editedat, editedby=$CURUSER[id] WHERE id=$postid") or sqlerr(__FILE__, __LINE__);

$setbedanko = ($_POST["bedanko"] == "2" ? "yes" : "no");
if ($setbedanko == 'yes'){
$bedanko = 2;
} else {
$bedanko = 1;
}
mysql_query("UPDATE posts SET bedanko = '$bedanko' WHERE id = '$postid'") or sqlerr(__FILE__, __LINE__);

  $question = $_POST["question"];
  $option0 = $_POST["option0"];
  $option1 = $_POST["option1"];
  $option2 = $_POST["option2"];
  $option3 = $_POST["option3"];
  $option4 = $_POST["option4"];
  $option5 = $_POST["option5"];
  $option6 = $_POST["option6"];
  $option7 = $_POST["option7"];
  $option8 = $_POST["option8"];
  $option9 = $_POST["option9"];
  $sort = $_POST["sort"];

  if ($question || $option0 || $option1) {
  mysql_query("UPDATE forum_polls SET " .
  "question = " . sqlesc($question) . ", " .
  "option0 = " . sqlesc($option0) . ", " .
  "option1 = " . sqlesc($option1) . ", " .
  "option2 = " . sqlesc($option2) . ", " .
  "option3 = " . sqlesc($option3) . ", " .
  "option4 = " . sqlesc($option4) . ", " .
  "option5 = " . sqlesc($option5) . ", " .
  "option6 = " . sqlesc($option6) . ", " .
  "option7 = " . sqlesc($option7) . ", " .
  "option8 = " . sqlesc($option8) . ", " .
  "option9 = " . sqlesc($option9) . ", " .
  "sort = " . sqlesc($sort) . " " .
  "WHERE topicid = ".$arr["topicid"]."") or sqlerr(__FILE__, __LINE__);
  }

  $pollid = $_POST["pollid"];
  $delpoll = $_POST["delpoll"];
  if ($delpoll == "yes") {
  mysql_query("DELETE FROM forum_pollanswers WHERE pollid = $pollid") or sqlerr();
  mysql_query("DELETE FROM forum_polls WHERE topicid = ".$arr["topicid"]."") or sqlerr();
  }

$returnto = $_POST["returnto"];

if ($returnto != "") {
$returnto .= "&page=p$postid#$postid";
header("Location: $returnto");

} else
stderr("Beitrag bearbeiten", "<b><p>Der Beitrag wurde erfolgreich bearbeitet!</p></b>");
 }
}

if ($action == "edit") {
$postid = $_GET["postid"];

if (!is_valid_id($postid))
die;

$forumid = $_GET["forumid"];

if (!is_valid_id($forumid))
die;

$respo = mysql_query("SELECT allowpoll FROM forums WHERE id=$forumid") or sqlerr(__FILE__, __LINE__);
$arrpo = mysql_fetch_assoc($respo) or stderr("Forum Fehler", "<b><p>Falsche Foren ID.</p></b>");
$allowpoll = $arrpo["allowpoll"];

$res = mysql_query("SELECT * FROM posts WHERE id=$postid") or sqlerr(__FILE__, __LINE__);

if (mysql_num_rows($res) != 1)
   stderr("Forum Fehler", "<b><p>Es ist kein Beitrag mit der ID $postid vorhanden.</p></b>");

$arr = mysql_fetch_assoc($res);
$res2 = mysql_query("SELECT locked, userid, subject FROM topics WHERE id = " . $arr["topicid"]) or sqlerr(__FILE__, __LINE__);
$arr2 = mysql_fetch_assoc($res2);

if (mysql_num_rows($res) != 1)
   stderr("Forum Fehler", "<b><p>Es ist kein Thema mit der ID $postid vorhanden.</p></b>");

$locked = ($arr2["locked"] == 'yes');

if (($CURUSER["id"] != $arr["userid"] || $locked) && get_user_class() < UC_MODERATOR)
    stderr("Forum Fehler", "<b><p>Du hast keine Berechtigung um diesen Beitrag zu ändern!</p></b>");

x264_admin_header("".$GLOBALS["SITENAME"]." Forum");
set_forum_online();
print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>".$GLOBALS["SITENAME"]." Forum - Beitrag bearbeiten</h1>
	<div class='x264_title_content'>";

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"770\" class=\"tableinborder\">
<tr><td align=\"center\" colspan=\"2\" width=\"100%\" class=\"x264_wrapper_content_out_mount\"><span class=\"normalfont\"><b>Beitrag zum Thema <a href=?action=viewtopic&topicid=".$arr["topicid"]."><i>".$arr2[subject]."</i></a> bearbeiten</b></span></td></tr>");

print("<form action=\"?action=editpost&postid=$postid\" method=\"post\" name=\"body\" enctype=\"multipart/form-data\">");
print("<input type=hidden name=returnto value=\"forums.php?action=viewtopic&topicid=".$arr["topicid"]."\">");

?>
<tr><td class="tableb"><b>Thema:</b></td><td class="tablea"><input type="text" name="subject" size="100" maxlength="255" value="<?=htmlspecialchars($arr2["subject"])?>"></td></tr>
<tr><td class="tableb"><b>Text:</b></td><td class="tablea" align="left" input type="text" style="padding: 0px"><? textbbcode("body","body","$arr[body]")?></td></tr>
<?

$resc = mysql_query("SELECT id FROM posts WHERE topicid=$arr[topicid] ORDER BY id ASC LIMIT 1") or sqlerr(__FILE__, __LINE__);
$arrc = mysql_fetch_assoc($resc);

if ($arr[userid] == $arr2[userid] && $arrc[id] == $postid) {
print("<tr><td colspan=\"2\" class=\"tableb\">&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" name=\"bedanko\" value=\"2\" style=\"vertical-align: middle;\"> <b>Danke-Button aktivieren.</b></td></tr>");
}

print("</td></tr></table>");

if ($allowpoll == "yes") {
$respoll = mysql_query("SELECT * FROM forum_polls WHERE topicid = ".$arr["topicid"]."") or sqlerr();
$arrpoll = mysql_fetch_assoc($respoll);
$pollnum = mysql_num_rows($respoll);

if (($CURUSER["id"] == $arr2["userid"]) || (get_user_class() >= UC_MODERATOR)) {

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"99%\" class=\"tableinborder\">
<tr><td align=\"center\" width=\"100%\" class=\"x264_wrapper_content_out_mount\"><span class=\"normalfont\"><b>Umfrage zum Thema <a href=?action=viewtopic&topicid=".$arr["topicid"]."><i>".$arr2[subject]."</i></a> bearbeiten</b></span></td></tr>");

print("<input type=\"hidden\" name=\"pollid\" value=\"".$arrpoll["id"]."\">");
?>
<tr><td align="center" class="tablea" style="padding: 0px">
<table align="center" border="0" cellspacing="0" cellpadding="5">
<tr><td class="tableb">Frage <font color="red">*</font></td><td class="tablea" align="left"><input name="question" size="100" maxlength="255" value="<?=htmlspecialchars($arrpoll["question"])?>"></td></tr>
<tr><td class="tableb">Antwort 1 <font color="red">*</font></td><td class="tablea" align="left"><input name="option0" size="100" maxlength="150" value="<?=htmlspecialchars($arrpoll["option0"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 2 <font color="red">*</font></td><td class="tablea" align="left"><input name="option1" size="100" maxlength="150" value="<?=htmlspecialchars($arrpoll["option1"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 3</td><td class="tablea" align="left"><input name="option2" size="100" maxlength="150" value="<?=htmlspecialchars($arrpoll["option2"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 4</td><td class="tablea" align="left"><input name="option3" size="100" maxlength="150" value="<?=htmlspecialchars($arrpoll["option3"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 5</td><td class="tablea" align="left"><input name="option4" size="100" maxlength="150" value="<?=htmlspecialchars($arrpoll["option4"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 6</td><td class="tablea" align="left"><input name="option5" size="100" maxlength="150" value="<?=htmlspecialchars($arrpoll["option5"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 7</td><td class="tablea" align="left"><input name="option6" size="100" maxlength="150" value="<?=htmlspecialchars($arrpoll["option6"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 8</td><td class="tablea" align="left"><input name="option7" size="100" maxlength="150" value="<?=htmlspecialchars($arrpoll["option7"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 9</td><td class="tablea" align="left"><input name="option8" size="100" maxlength="150" value="<?=htmlspecialchars($arrpoll["option8"])?>"><br></td></tr>
<tr><td class="tableb">Antwort 10</td><td class="tablea" align="left"><input name="option9" size="100" maxlength="150" value="<?=htmlspecialchars($arrpoll["option9"])?>"><br></td></tr>
<tr><td class="tableb">Sortieren</td><td class="tablea">
<input type="radio" name="sort" value="yes" <?=$arrpoll["sort"] == "yes" ? " checked" : "" ?> style="vertical-align: middle;"> Ja
<input type="radio" name="sort" value="no" <?=$arrpoll["sort"] == "no" ? " checked" : "" ?> style="vertical-align: middle;"> Nein
</td></tr>
<tr><td class="tableb">Löschen</td><td class="tablea">
<input type="checkbox" name="delpoll" value="yes" style="vertical-align: middle;"> Umfrage löschen.</td></tr>

</td></tr>
</table>
<p><font color="red">*</font> Bei einer Umfrage müssen mindestens diese Felder ausgefüllt sein!</p>
</td></tr>
</table>
<?
 }
}

print("<p align=\"center\"><input type=\"submit\" value=\"Und ab!\" class=\"btn\"></form></p>");

print "	
		</div>
</div>
</div>";
x264_admin_footer();
die;
}
  //-------- Action: Delete post

if ($action == "deletepost") {
$forumid = $_GET["forumid"];
$postid = $_GET["postid"];
$sure = $_GET["sure"];

if (get_user_class() < UC_MODERATOR || !is_valid_id($postid))
die;

  //------- Get topic id

$res = mysql_query("SELECT topicid FROM posts WHERE id=$postid") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res) or stderr("Forum Fehler", "<b><p>Der Beitrag wurde nicht gefunden!</p></b>");

$topicid = $arr[0];

  //------- We can not delete the post if it is the only one of the topic

$res = mysql_query("SELECT COUNT(*) FROM posts WHERE topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);

if ($arr[0] < 2)
   stderr("Forum Fehler", "<b><p>Der Beitrag kann nicht gelöscht werden, es ist der erste Beitrag dieses Themas. Klicke <a href=?action=deletetopic&topicid=$topicid&forumid=$forumid&sure=1>HIER</a> um das Thema zu löschen.</p></b>");

  //------- Get the id of the last post before the one we're deleting

$res = mysql_query("SELECT id FROM posts WHERE topicid=$topicid AND id < $postid ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);

if (mysql_num_rows($res) == 0)
$redirtopost = "";

else {
$arr = mysql_fetch_row($res);
$redirtopost = "&page=p$arr[0]#$arr[0]";
}

  //------- Make sure we know what we do :-)

if (!$sure) {
   stderr("Beitrag löschen", "<b><p>Bist du dir sicher das du diesen Beitrag löschen willst? Klicke <a href=?action=deletepost&postid=$postid&forumid=$forumid&sure=1>HIER</a> wenn du dir sicher bist.</p></b>");
}

  //------- Delete post

$forumid = $_GET["forumid"];
mysql_query("DELETE FROM posts WHERE id=$postid") or sqlerr(__FILE__, __LINE__);
mysql_query("DELETE FROM readposts WHERE topicid=$topicid") or sqlerr(__FILE__, __LINE__);
mysql_query("UPDATE forums SET postcount = postcount - 1 WHERE id=$forumid") or sqlerr(__FILE__, __LINE__);

  //------- Update topic

update_topic_last_post($topicid);
header("Location: $BASEURL/forums.php?action=viewtopic&topicid=$topicid$redirtopost");
die;
}

  //-------- Action: Lock topic

if ($action == "locktopic") {
$forumid = $_GET["forumid"];
$topicid = $_GET["topicid"];
$page = $_GET["page"];

if (!is_valid_id($topicid) || get_user_class() < UC_MODERATOR)
die;

mysql_query("UPDATE topics SET locked='yes' WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
header("Location: $BASEURL/forums.php?action=viewforum&forumid=$forumid&page=$page");
die;
}

  //-------- Action: Unlock topic

if ($action == "unlocktopic") {
$forumid = $_GET["forumid"];
$topicid = $_GET["topicid"];
$page = $_GET["page"];

if (!is_valid_id($topicid) || get_user_class() < UC_MODERATOR)
die;

mysql_query("UPDATE topics SET locked='no' WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
header("Location: $BASEURL/forums.php?action=viewforum&forumid=$forumid&page=$page");
die;
}

  //-------- Action: Set locked on/off

if ($action == "setlocked") {
$topicid = 0 + $_POST["topicid"];

if (!$topicid || get_user_class() < UC_MODERATOR)
die;

$locked = sqlesc($_POST["locked"]);
mysql_query("UPDATE topics SET locked=$locked WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
header("Location: $_POST[returnto]");
die;
}

  //-------- Action: Set sticky on/off

if ($action == "setsticky") {
$topicid = 0 + $_POST["topicid"];

if (!topicid || get_user_class() < UC_MODERATOR)
die;

$sticky = sqlesc($_POST["sticky"]);
mysql_query("UPDATE topics SET sticky=$sticky WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
header("Location: $_POST[returnto]");
die;
}

  //-------- Action: Rename topic

if ($action == 'renametopic') {

if (get_user_class() < UC_MODERATOR)
die;

$topicid = $_POST['topicid'];

if (!is_valid_id($topicid))
die;

$subject = $_POST['subject'];

if ($subject == '')
   stderr("Forum Fehler", "<b><p>Du musst einen neuen Titel eintragen!</p></b>");

$subject = sqlesc($subject);
mysql_query("UPDATE topics SET subject=$subject WHERE id=$topicid") or sqlerr();
$returnto = $_POST['returnto'];

if ($returnto)
header("Location: $returnto");
die;
}

  //-------- Action: View forum

if ($action == "viewforum") {
$forumid = $_GET["forumid"];

if (!is_valid_id($forumid))
die;

$page = $_GET["page"];
$userid = $CURUSER["id"];

  //------ Get forum name

$res = mysql_query("SELECT name, minclassread FROM forums WHERE id=$forumid") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res) or die;
$forumname = $arr["name"];

if (get_user_class() < $arr["minclassread"])
die("Kein Zugriff");

  //------ Page links

  //------ Get topic count

$perpage = $CURUSER["topicsperpage"];

if (!$perpage) $perpage = 20;
$res = mysql_query("SELECT COUNT(*) FROM topics WHERE forumid=$forumid") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);
$num = $arr[0];

if ($page == 0)
$page = 1;
$first = ($page * $perpage) - $perpage + 1;
$last = $first + $perpage - 1;

if ($last > $num)
$last = $num;
$pages = floor($num / $perpage);

if ($perpage * $pages < $num)
++$pages;

  //------ Build menu

$menu = "<center><b>\n";
$lastspace = false;

for ($i = 1; $i <= $pages; ++$i) {

if ($i == $page)
$menu .= "<font class=gray>$i</font>\n";

elseif ($i > 3 && ($i < $pages - 2) && ($page - $i > 3 || $i - $page > 3)) {

if ($lastspace)
continue;
$menu .= "... \n";
$lastspace = true;

} else {
$menu .= "<center><a href=?action=viewforum&forumid=$forumid&page=$i>$i</a></center>\n";
$lastspace = false;
}

if ($i < $pages)
$menu .= "</b>|<b>\n";
}

$menu .= "<br>\n";

if ($page == 1)
$menu .= "<font class=gray>&lt;&lt; Zurück</font>";

else
$menu .= "<a href=?action=viewforum&forumid=$forumid&page=" . ($page - 1) . ">&lt;&lt; Zurück</a>";
$menu .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

if ($last == $num)
$menu .= "<font class=gray>Nächste &gt;&gt;</font>";

else
$menu .= "<a href=?action=viewforum&forumid=$forumid&page=" . ($page + 1) . ">Nächste &gt;&gt;</a>";
$menu .= "</b></center>";
$offset = $first - 1;

  //------ Get topics data

$topicsres = mysql_query("SELECT * FROM topics WHERE forumid=$forumid ORDER BY sticky, lastpost DESC LIMIT $offset,$perpage") or stderr("SQL Fehler", mysql_error());

x264_admin_header("".$GLOBALS["SITENAME"]." Forum");
set_forum_online();
$numtopics = mysql_num_rows($topicsres);

print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>".$GLOBALS["SITENAME"]." Forum</h1>
	<div class='x264_title_content'>";

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"99%\" class=\"tableinborder\">
<tr><td class=\"tablea\">");

if ($numtopics > 0) {
print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"tableinborder\">");
print("<tr><td class=\"x264_wrapper_content_out_mount\" width=\"40%\"><b>Themen</b></td><td align=\"center\" class=\"x264_wrapper_content_out_mount\" width=\"10%\"><b>Antworten</b></td><td align=\"center\" class=\"x264_wrapper_content_out_mount\" width=\"10%\"><b>Klicks</b></td><td class=\"x264_wrapper_content_out_mount\" width=\"15%\"><b>Themenstarter</b></td><td class=\"x264_wrapper_content_out_mount\" width=\"25%\"><b>Letzte Antwort</b></td></tr>");

while ($topicarr = mysql_fetch_assoc($topicsres)) {
$topicid = $topicarr["id"];
$topic_userid = $topicarr["userid"];
$topic_views = $topicarr["views"];
$views = number_format($topic_views);
$locked = $topicarr["locked"] == "yes";
$sticky = $topicarr["sticky"] == "yes";


  //---- Get reply count

$res = mysql_query("SELECT COUNT(*) FROM posts WHERE topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);
$posts = $arr[0];
$replies = max(0, $posts - 1);
$tpages = floor($posts / $postsperpage);

if ($tpages * $postsperpage != $posts)
++$tpages;

if ($tpages > 1) {
$topicpages = " (<img src=\"".$GLOBALS["PIC_BASE_URL"]."multipage.gif\">";

for ($i = 1; $i <= $tpages; ++$i)
$topicpages .= " <a href=?action=viewtopic&topicid=$topicid&page=$i>$i</a>";
$topicpages .= ")";
}

else
$topicpages = "";

  //---- Get userID and date of last post

$res = mysql_query("SELECT * FROM posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_assoc($res);
$lppostid = 0 + $arr["id"];
$lpuserid = 0 + $arr["userid"];
$lpadded = "<nobr>" . $arr["added"] . "</nobr>";

  //------ Get name of last poster

$res1 = mysql_query("SELECT * FROM users WHERE id=$lpuserid") or sqlerr(__FILE__, __LINE__);

if($topicarr["guestuser"] == "yes") {
$lpusername = "<b>Gast: $arr[guestname]</b>";
} else {
if (mysql_num_rows($res) == 1) {
$arr1 = mysql_fetch_assoc($res1);

if($arr1[username] == "") {
$lpusername = "<b>Gelöscht</b>";

} else {
if ($arr1[anon] == no  || (($lpuserid == $CURUSER[id]) || get_user_class() >= UC_MODERATOR)) {
$lpusername = ("<a href=userdetails.php?id=$lpuserid><font class=".get_class_color($arr1["class"])."><b>$arr1[username]</b></font></a>");

} else {
$lpusername = ("<font class=".get_class_color($arr1["class"])."><b>$arr1[username]</b></font>");
   }
  }
 }
}

  //------ Get author
$res2 = mysql_query("SELECT username, class, anon FROM users WHERE id=$topic_userid") or sqlerr(__FILE__, __LINE__);
$arr2 = mysql_fetch_assoc($res2);

if($topicarr["guestuser"] == "yes") {
$lpauthor = "<b>Gast: $topicarr[guestname]</b>";
} else {
if($arr2[username] == "") {
$lpauthor = "<b>Gelöscht</b>";

} else {
if ($arr2[anon] == no  || (($topic_userid == $CURUSER[id]) || get_user_class() >= UC_MODERATOR)) {
$lpauthor = ("<a href=userdetails.php?id=$topic_userid><font class=".get_class_color($arr2["class"])."><b>$arr2[username]</b></a>");

} else {
$lpauthor = ("<font class=".get_class_color($arr2["class"])."><b>$arr2[username]</b>");
  }
 }
}

  //---- Print row

$r = mysql_query("SELECT lastpostread FROM readposts WHERE userid=$userid AND topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$a = mysql_fetch_row($r);
$new = !$a || $lppostid > $a[0];
$topicpic = ($locked ? ($new ? "lockednew" : "locked") : ($new ? "unlockednew" : "unlocked"));
$subject = ($sticky ? "Sticky: " : "") . "<a href=?action=viewtopic&topicid=$topicid><b>" . encodehtml($topicarr["subject"]) . "</b></a>$topicpages";

$arr = get_forum_access_levels($forumid) or die;
$maypost = get_user_class() >= $arr["write"] && get_user_class() >= $arr["create"];

$respoll = mysql_query("SELECT COUNT(*) FROM forum_polls WHERE topicid = $topicid") or sqlerr(__FILE__, __LINE__);
$arrpoll = mysql_fetch_row($respoll);
$fpoll = $arrpoll[0];
$pollpic = "<img src=\"".$GLOBALS["PIC_BASE_URL"]."poll.gif\">";

if ($fpoll == 1) {
print("<tr><td class=\"tablea\"><img src=\"".$GLOBALS["PIC_BASE_URL"]."".$topicpic.".gif\"> $subject $pollpic</td>");
} else {
print("<tr><td class=\"tablea\"><img src=\"".$GLOBALS["PIC_BASE_URL"]."".$topicpic.".gif\"> $subject</td>");
}

print("<td align=\"center\" class=\"tablea\">$replies</td>
<td align=\"center\" class=\"tablea\">$views</td>
<td class=tablea>$lpauthor</td>
<td class=\"tablea\"><b>Von:</b> $lpusername <br><b>Am: </b>$lpadded</td></tr>");
}

print("</table><br>");

print("<table align=\"center\" cellpadding=\"2\" cellspacing=\"o\" border=\"0\" width=\"100%\"><tr><td class=\"tabled\">
<table cellpadding=\"2\" cellspacing=\"o\" border=\"0\"><tr><td class=\"tabled\"><form method=\"get\" action=\"?\"><input type=\"hidden\" name=\"action\" value=\"viewunread\"><input type=\"submit\" value=\"Ungelesene Antworten\" class=\"btn\"></form></td>");

if (!$maypost) {
print("<td width=\"25%\" class=\"tabled\"><input type=\"submit\" value=\"Keine Schreibrechte\" class=\"btn\"></td>");
}

if ($maypost) {
print("<td width=\"25%\" class=\"tabled\"><form method=\"get\" action=\"?\"><input type=\"hidden\" name=\"action\" value=\"newtopic\"><input type=\"hidden\" name=\"forumid\" value=\"$forumid\"><input type=\"submit\" value=\"Neues Thema\" class=\"btn\"></form></td>");
}
print("<td width=\"75%\" class=\"tabled\" align=\"right\">");

print("".insert_quick_jump_menu()."");

print("</td></tr></table>");
print("</td></tr></table>");

print("<br>&nbsp;<img src=\"".$GLOBALS["PIC_BASE_URL"]."unlockednew.gif\">&nbsp;<b>Neue Antworten</b>&nbsp;&nbsp;&nbsp;
<img src=\"".$GLOBALS["PIC_BASE_URL"]."unlocked.gif\">&nbsp;<b>Gelesene Antworten</b>&nbsp;&nbsp;&nbsp;
<img src=\"".$GLOBALS["PIC_BASE_URL"]."lockednew.gif\">&nbsp;<b>Neue Geschlossene Themen</b>&nbsp;&nbsp;&nbsp;
<img src=\"".$GLOBALS["PIC_BASE_URL"]."locked.gif\">&nbsp;<b>Gelesene Geschlossene Themen</b>
");

print($menu);

} else {
$arr = get_forum_access_levels($forumid) or die;
$maypost = get_user_class() >= $arr["write"] && get_user_class() >= $arr["create"];

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"tableinborder\">");
print("<tr><td class=\"x264_wrapper_content_out_mount\" width=\"40%\"><b>Themen</b></td><td align=\"center\" class=\"x264_wrapper_content_out_mount\" width=\"10%\"><b>Antworten</b></td><td align=\"center\" class=\"x264_wrapper_content_out_mount\" width=\"10%\"><b>Klicks</b></td><td class=\"x264_wrapper_content_out_mount\" width=\"15%\"><b>Themenstarter</b></td><td class=\"x264_wrapper_content_out_mount\" width=\"25%\"><b>Letzte Antwort</b></td></tr>");
print("<tr><td colspan=\"5\" class=\"tablea\"><b><p>Es wurden keine Themen gefunden.</p></b></td></tr>");
print("<tr><td colspan=\"5\" class=\"tableb\">
<table align=\"center\" cellpadding=\"2\" cellspacing=\"o\" border=\"0\" width=\"100%\"><tr><td width=\"25%\" class=\"tabled\"><form method=\"get\" action=\"?\"><input type=\"hidden\" name=\"action\" value=\"viewunread\"><input type=\"submit\" value=\"Ungelesene Antworten\" class=\"btn\"></form></td>");

if (!$maypost) {
print("<td width=\"25%\" class=\"tabled\"><input type=\"submit\" value=\"Keine Schreibrechte\" class=\"btn\"></td>");
}

if ($maypost) {
print("<td width=\"25%\" class=\"tabled\"><form method=\"get\" action=\"?\"><input type=\"hidden\" name=\"action\" value=\"newtopic\"><input type=\"hidden\" name=\"forumid\" value=\"$forumid\"><input type=\"submit\" value=\"Neues Thema\" class=\"btn\"></form></td>");
}
print("<td width=\"75%\" class=\"tabled\" align=\"right\">");

print("".insert_quick_jump_menu()."");

print("</td></tr></table>");
print("</td></tr></table>");

print("<br>&nbsp;<img src=\"".$GLOBALS["PIC_BASE_URL"]."unlockednew.gif\">&nbsp;<b>Neue Antworten</b>&nbsp;&nbsp;&nbsp;
<img src=\"".$GLOBALS["PIC_BASE_URL"]."unlocked.gif\">&nbsp;<b>Gelesene Antworten</b>&nbsp;&nbsp;&nbsp;
<img src=\"".$GLOBALS["PIC_BASE_URL"]."lockednew.gif\">&nbsp;<b>Neue Geschlossene Themen</b>&nbsp;&nbsp;&nbsp;
<img src=\"".$GLOBALS["PIC_BASE_URL"]."locked.gif\">&nbsp;<b>Gelesene Geschlossene Themen</b><br>");
}

print("</td></tr></table>");
print "	
		</div>
</div>
</div>";
x264_admin_footer();
die;
}

  //-------- Action: View unread posts

if ($action == "viewunread") {
$userid = $CURUSER['id'];
$maxresults = 10;

$res = mysql_query("SELECT id, userid, forumid, subject, guestuser, lastpost FROM topics ORDER BY lastpost") or sqlerr(__FILE__, __LINE__);

x264_admin_header("".$GLOBALS["SITENAME"]." Forum");
set_forum_online();
print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>".$GLOBALS["SITENAME"]." Forum</h1>
	<div class='x264_title_content'>";

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"99%\" class=\"tableinborder\">
<tr><td class=\"tablea\">");

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"tableinborder\">");
print("<tr><td class=\"x264_wrapper_content_out_mount\" width=\"25%\"><b>Forum</b></td><td class=\"x264_wrapper_content_out_mount\" width=\"50%\"><b>Thema</b></td><td class=\"x264_wrapper_content_out_mount\" width=\"25%\"><b>Letzer Beitrag</b></td></tr>");


$n = 0;
$uc = get_user_class();

while ($arr = mysql_fetch_assoc($res)) {
$topicid = $arr['id'];
$forumid = $arr['forumid'];

  // Find last post ID

$lastpostid = get_forum_last_post($forumid);

  // Get last post info

$post_res = mysql_query("SELECT * FROM posts WHERE id=$lastpostid") or sqlerr(__FILE__, __LINE__);

if (mysql_num_rows($post_res) == 1) {
$post_arr = mysql_fetch_assoc($post_res) or die("Falsche Foren-ID last_post");
$lastposterid = $post_arr["userid"];
$lastpostdate = $post_arr["added"];


if($post_arr["guestuser"] == "no") {
$user_res = mysql_query("SELECT username, class, anon FROM users WHERE id=$lastposterid") or sqlerr(__FILE__, __LINE__);
$user_arr = mysql_fetch_assoc($user_res);
$lastposter = ("<font class=".get_class_color($user_arr["class"])."><b>".htmlspecialchars($user_arr["username"])."</b></font>");

if ($user_arr[anon] == no  || (($lastposterid == $CURUSER[id]) || get_user_class() >= UC_MODERATOR)) {
$lastpost = "<b>Von:</b> <a href=\"userdetails.php?id=$lastposterid\">$lastposter</a><br><b>Am:</b> $lastpostdate";

} else {
$lastpost = "<b>Von:</b> $lastposter<br><b>Am:</b> $lastpostdate";
  }
} else {
$lastpost = "<b>Von: Gast: $post_arr[guestuser]</b><br><b>Am:</b> $lastpostdate";
 }
}

  //---- Check if post is read

$r = mysql_query("SELECT lastpostread FROM readposts WHERE userid=$userid AND topicid=$topicid") or sqlerr(__FILE__, __LINE__);
$a = mysql_fetch_row($r);

if ($a && $a[0] == $arr['lastpost'])
continue;

  //---- Check access & get forum name

$r = mysql_query("SELECT name, minclassread FROM forums WHERE id=$forumid") or sqlerr(__FILE__, __LINE__);
$a = mysql_fetch_assoc($r);

if ($uc < $a['minclassread'])
continue;
++$n;

if ($n > $maxresults)
break;

$forumname = $a['name'];

print("<tr><td class=\"tablea\"><img src=\"".$GLOBALS["PIC_BASE_URL"]."unlockednew.gif\"> <a href=\"?action=viewforum&amp;forumid=$forumid\"><b>$forumname</b></a></a></td>
<td class=\"tablea\"><a href=\"?action=viewtopic&topicid=$topicid&page=last#last\"><b>".htmlspecialchars($arr["subject"])."</b></a></td><td class=\"tablea\">$lastpost</td></tr>");
}

if ($n == 0) {
print("<tr><td colspan=\"3\" class=\"tablea\"><b><p>Es wurden keine ungelesenen Themen gefunden.</p></b></td></tr>");
}
print("</table><br>");

print("<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr><td colspan=\"3\" class=\"tabled\"><table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">");
print("<tr><td width=\"20%\" class=\"tabled\"><form method=\"post\" action=\"forums.php?action=search\" style=\"display:inline\"><input type=\"submit\" value=\"Suche\"></form></td>");
print("<td width=\"8%\" class=\"tabled\" align=\"right\">");

print("".insert_quick_jump_menu()."");

print("</td></tr></table>");
print("</td></tr></table>");

print("<br>&nbsp;<img src=\"".$GLOBALS["PIC_BASE_URL"]."unlockednew.gif\">&nbsp;<b>Neue Antworten</b>&nbsp;&nbsp;&nbsp;
<img src=\"".$GLOBALS["PIC_BASE_URL"]."unlocked.gif\">&nbsp;<b>Gelesene Antworten</b>&nbsp;&nbsp;&nbsp;
<img src=\"".$GLOBALS["PIC_BASE_URL"]."lockednew.gif\">&nbsp;<b>Neue Geschlossene Themen</b>&nbsp;&nbsp;&nbsp;
<img src=\"".$GLOBALS["PIC_BASE_URL"]."locked.gif\">&nbsp;<b>Gelesene Geschlossene Themen</b><br>
");
if ($n > $maxresults) {
print("<b><p>Es wurden mehr als $maxresults ungelesene Threads gefunden, die ersten $maxresults werden angezeigt.</p></b>");
}


print("</table>");

print "	
		</div>
</div>
</div>";
x264_admin_footer();
die;
}


  //---- Search

if ($action == "search") {
x264_admin_header("".$GLOBALS["SITENAME"]." Forum");
set_forum_online();
print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>".$GLOBALS["SITENAME"]." Forum</h1>
	<div class='x264_title_content'>";

$keywords = trim($_GET["keywords"]);

if ($keywords != "") {
$perpage = 50;
$page = max(1, 0 + $_GET["page"]);
$ekeywords = sqlesc($keywords);

$res = mysql_query("SELECT COUNT(*) FROM posts WHERE MATCH (body) AGAINST ($ekeywords)") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res);
$hits = 0 + $arr[0];

if ($hits == 0) {
print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"500\" class=\"tableinborder\">");
print("<tr><td width=\"100%\" class=\"tablea\"><span class=\"normalfont\"><b>Suche nach: <i>\"".htmlspecialchars($keywords)."\"</i></b></span><br>
<b><p>Es wurden keine passenden Einträge gefunden!</p></b></td></tr>");
print("<tr><td align=\"center\" colspan=\"4\" class=\"tableb\"><form method=\"post\" action=\"forums.php?action=search\" style=\"display:inline\"><input type=\"submit\" value=\"Suche\"></form></td></tr>");

print("</table>");

} else {

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"99%\" class=\"tableinborder\">
<tr><td class=\"tablea\">");

$pages = 0 + ceil($hits / $perpage);

if ($page > $pages) $page = $pages;
for ($i = 1; $i <= $pages; ++$i)
if ($page == $i)
$pagemenu1 .= "<center><b>$i</b><center>";

else
$pagemenu1 .= "<a href=\"/forums.php?action=search&amp;keywords=" . htmlspecialchars($keywords) . "&amp;page=$i\"><b>$i</b></a>";

if ($page == 1)
$pagemenu2 = "<b>&lt;&lt; Zurück</b>";

else
$pagemenu2 = "<a href=\"/forums.php?action=search&amp;keywords=" . htmlspecialchars($keywords) . "&amp;page=" . ($page - 1) . "\"><b>&lt;&lt; Zurück</b></a>";
$pagemenu2 .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";

if ($page == $pages)
$pagemenu2 .= "<b>Nächste &gt;&gt;</b>";

else
$pagemenu2 .= "<a href=\"/forums.php?action=search&amp;keywords=" . htmlspecialchars($keywords) . "&amp;page=" . ($page + 1) . "\"><b>Nächste &gt;&gt;</b></a>";
$offset = ($page * $perpage) - $perpage;

$res = mysql_query("SELECT * FROM posts WHERE MATCH (body) AGAINST ($ekeywords) LIMIT $offset,$perpage") or sqlerr(__FILE__, __LINE__);
$num = mysql_num_rows($res);

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"tableinborder\">");
print("<tr><td class=\"x264_wrapper_content_out_mount\" width=\"30%\"><b>Forum</b></td><td class=\"x264_wrapper_content_out_mount\" width=\"35%\"><b>Thema</b></td><td align=\"center\" class=\"x264_wrapper_content_out_mount\" width=\"10%\"><b>Beiträge</b></td><td class=\"x264_wrapper_content_out_mount\" width=\"25%\"><b>Geschrieben von</b></td></tr>");

for ($i = 0; $i < $num; ++$i) {
$post = mysql_fetch_assoc($res);
$res2 = mysql_query("SELECT forumid, subject FROM topics WHERE id=$post[topicid]") or sqlerr(__FILE__, __LINE__);
$topic = mysql_fetch_assoc($res2);

$res3 = mysql_query("SELECT name, minclassread FROM forums WHERE id=$topic[forumid]") or sqlerr(__FILE__, __LINE__);
$forum = mysql_fetch_assoc($res3);

if ($forum["name"] == "" || $forum["minclassread"] > $CURUSER["class"]) {
--$hits;
continue;
}

$res4 = mysql_query("SELECT username, class, anon FROM users WHERE id=$post[userid]") or sqlerr(__FILE__, __LINE__);
$user = mysql_fetch_assoc($res4);
$username = ("<font class=\"".get_class_color($user["class"])."\"><b>$user[username]</b></font>");


if($post["guestuser"] == "yes") {
$lastpost = "<b>Von: Gast: $post[guestuser]</b><br><b>Am:</b> $post[added]";
} else {

if ($user["username"] == "") {
$lastpost = "<b>Von: Gelöscht</b><br><b>Am:</b> $post[added]";

} else {
if ($user[anon] == no  || (($post[userid] == $CURUSER[id]) || get_user_class() >= UC_MODERATOR)) {
$lastpost = "<b>Von: <a href=\"userdetails.php?id=$post[userid]\">$username</b></a><br><b>Am:</b> $post[added]";

} else {
$lastpost = "<b>Von: $username</b><br><b>Am:</b> $post[added]";
  }
 }
}

print("<tr><td class=\"tablea\"><a href=\"?action=viewforum&amp;forumid=$topic[forumid]\"><b>" . htmlspecialchars($forum["name"]) . "</b></a></td><td class=\"tablea\"><a href=\"?action=viewtopic&amp;topicid=$post[topicid]&amp;page=p$post[id]#$post[id]\"><b>" . htmlspecialchars($topic["subject"]) . "</b></a></td><td align=\"center\" class=\"tablea\">$post[id]</td><td class=\"tablea\">$lastpost</td></tr>");
}

print("<tr><td colspan=\"4\" class=\"tableb\"><table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">");
print("<tr><td width=\"20%\" class=\"tabled\"><form method=\"post\" action=\"forums.php?action=viewunread\" style=\"display:inline\"><input type=\"submit\" value=\"Ungelesene Themen\"></form></td>");
print("<td width=\"20%\" class=\"tabled\">&nbsp;</td>
<td width=\"60%\" class=\"tabled\" align=\"right\">");

print("".insert_quick_jump_menu()."");

print("</td></tr></table>");
print("</td></tr></table>");

print("<b><p>Es wurde".($hits != 1 ? "n" : "")." $hits Post".($hits != 1 ? "s" : "")." gefunden</p></b>");
print("<center><p>$pagemenu2<br>$pagemenu1</p></center>");

print("</td></tr></table>");

}

print "	
		</div>
</div>
</div>";
x264_admin_footer();
die;
}

print("<form method=\"get\" action=\"/forums.php?\"><input type=\"hidden\" name=\"action\" value=\"search\">");

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"500\" class=\"tableinborder\">");
print("<tr><td class=\"tablea\"valign=\"top\"><b>Suchbegriff</b></td><td class=\"tablea\"><input type=\"text\" size=\"55\" name=\"keywords\" value=\"" . htmlspecialchars($keywords) ."\"><br><font class=\"small\" size=\"-1\">Gib einen oder mehrere Suchbegriffe ein.<br>Sehr lange oder kurze Begriffe werden automatisch ignoriert.</font></td></tr>");

print("<tr><td align=\"center\" colspan=\"2\" class=\"tableb\"><input type=\"submit\" value=\"Und ab!\" class=\"btn\"></td></tr>");

print("</table>");

print "	
		</div>
</div>
</div>";
x264_admin_footer();
die;
}

  //-------- Handle unknown action

if ($action != "")
stderr("Forum Fehler", "<b><p>Unbekannte Action '$action'.</p></b>");

  //-------- Get forums

$forums_res = mysql_query("SELECT * FROM forums ORDER BY sort, name") or sqlerr(__FILE__, __LINE__);

x264_admin_header("".$GLOBALS["SITENAME"]." Forum");
set_forum_online();

#####################################################################################

///// Forum User by dontcha Start /////

mysql_query("UPDATE users SET forum_access='" . get_date_time() . "' WHERE id={$CURUSER["id"]}");// or die(mysql_error());
$forum_t = gmtime() - 180; //you can change this value to whatever span you want
$forum_t = sqlesc(get_date_time($forum_t));
$res = mysql_query("SELECT id, username, class, donor, warned, added, enabled FROM users WHERE forum_access >= $forum_t AND anon='no' ORDER BY forum_access DESC") or print(mysql_error());
$forumusers_no = mysql_num_rows($res);


        while ($arr = mysql_fetch_assoc($res))
        {
        if ($forumusers) $forumusers .= " \n";
        $hide = mysql_query("SELECT anon, username FROM users WHERE id=$arr[id]") or die;
        $hide1 = mysql_fetch_array($hide);

        if ($CURUSER["class"]>= UC_MODERATOR) {
        $username = $hide1["username"];
        $k1 = " (";
        $k2 = ")";
        }


        if($hide1["anon"] == "yes") 
        {
        $arr["username"] = "<font class=\"".get_class_color($arr["class"])."\">*Anonym*</font>";
        if ($CURUSER["class"]>= UC_MODERATOR) {
        $arr["username"] .= "$k1<font class=\"".get_class_color($arr["class"])."\">".$username."</font>$k2";
        }
        }

        if (($hide1["anon"] == "yes") AND ($CURUSER["class"]< UC_MODERATOR)) 
        {
        $forumusers .= "<b>$arr[username]</b>";
        } 
        elseif (($hide1["anon"] == "yes") AND ($CURUSER["class"]>= UC_MODERATOR)) {
        $forumusers .= "<a href=\"userdetails.php?id=" . $arr["id"] . "\"><b>" . $arr["username"] . "</b></a>";
        } 
        else 
        {
        $forumusers .= "<a href=\"userdetails.php?id=" . $arr["id"] . "\"><b>" .  $arr["username"] . "</b></a>";
        }

        $forumusers .= "&nbsp;".get_user_icons($arr);
        }
        if (!$forumusers)
        $forumusers = "keine User online.";



$topiccount = mysql_query("select sum(topiccount) as topiccount from forums");
$row1 = mysql_fetch_array($topiccount);
$topiccount = $row1[topiccount];
$postcount = mysql_query("select sum(postcount) as postcount from forums");
$row2 = mysql_fetch_array($postcount);
$postcount = $row2[postcount];

///// Forum User by dontcha Ende /////

##############################################################################

print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>".$GLOBALS["SITENAME"]." Forum</h1>
	<div class='x264_title_content'>";

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"99%\" class=\"tableinborder\">
<tr><td class=\"tablea\">");

$forums_cat = mysql_query("SELECT * FROM forum_cats ORDER BY sort, name") or sqlerr(__FILE__, __LINE__);
while ($forums_catarr = mysql_fetch_assoc($forums_cat)) {
if (get_user_class() < $forums_catarr["minclassread"])
continue;

$forumcat = $forums_catarr["fid"];
$forumcatname = $forums_catarr["name"];

$forums_res = mysql_query("SELECT * FROM forums WHERE fid=$forumcat ORDER BY sort, name") or sqlerr(__FILE__, __LINE__);

print("<table align=\"center\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"tableinborder\">");
print("<tr><td class=\"x264_wrapper_content_out_mount\"><b>$forumcatname</b></td><td align=\"center\" class=\"x264_wrapper_content_out_mount\"><b>Themen</b></td><td align=\"center\" class=\"x264_wrapper_content_out_mount\"><b>Beiträge</b></td><td class=\"x264_wrapper_content_out_mount\"><b>Letzter Beitrag</b></td></tr>");

while ($forums_arr = mysql_fetch_assoc($forums_res)) {
if (get_user_class() < $forums_arr["minclassread"])
continue;

$forumid = $forums_arr["id"];
$forumname = htmlspecialchars($forums_arr["name"]);
$forumdescription = htmlspecialchars($forums_arr["description"]);
$topiccount = number_format($forums_arr["topiccount"]);
$postcount = number_format($forums_arr["postcount"]);

  // Find last post ID

$lastpostid = get_forum_last_post($forumid);

  // Get last post info

$post_res = mysql_query("SELECT * FROM posts WHERE id=$lastpostid") or sqlerr(__FILE__, __LINE__);

if (mysql_num_rows($post_res) == 1) {
$post_arr = mysql_fetch_assoc($post_res) or die("Falsche Forum-ID.");
$lastposterid = $post_arr["userid"];
$lastpostdate = $post_arr["added"];
$lasttopicid = $post_arr["topicid"];
$user_res = mysql_query("SELECT username, class, anon FROM users WHERE id=$lastposterid") or sqlerr(__FILE__, __LINE__);
$user_arr = mysql_fetch_assoc($user_res);

$topic_res = mysql_query("SELECT subject FROM topics WHERE id=$lasttopicid") or sqlerr(__FILE__, __LINE__);
$topic_arr = mysql_fetch_assoc($topic_res);
$lasttopic1 = htmlspecialchars($topic_arr['subject']);

if (strlen($topic_arr['subject']) > 25) 
$lasttopic = substr($topic_arr['subject'], 0, 25) . "..."; 
else 
$lasttopic = $topic_arr['subject']; 



if($post_arr["guestuser"] == "yes") {
$lastposter = "<b>Gast: $post_arr[guestname]</b>";
} else {

if ($user_arr["username"] == "") {
$lastposter = "<b>Gelöscht</b>";

} else {
if ($user_arr[anon] == no  || (($posterid == $CURUSER[id]) || get_user_class() >= UC_MODERATOR)) {
$lastposter = ("<a href=\"userdetails.php?id=$post[userid]\"><font class=".get_class_color($user_arr["class"])."><b>".htmlspecialchars($user_arr["username"])."</a></b></font>");

} else {
$lastposter = ("<font class=".get_class_color($user_arr["class"])."><b>".htmlspecialchars($user_arr["username"])."</b></font>");
  }
 }
}

$lastpost = "<b>Von:</b> $lastposter<br><b>Am:</b> $lastpostdate<br><b>In:</b> <a href=?action=viewtopic&topicid=$lasttopicid&amp;page=p$lastpostid#$lastpostid>$lasttopic</a>";


$r = mysql_query("SELECT lastpostread FROM readposts WHERE userid=$CURUSER[id] AND topicid=$lasttopicid") or sqlerr(__FILE__, __LINE__);
$a = mysql_fetch_row($r);

if ($a && $a[0] >= $lastpostid)
$img = "unlocked";

else
$img = "unlockednew";

} else {
$lastpost = "Keine Themen vorhanden.";
$img = "unlocked";
}

print("<tr><td class=\"tablea\" width=\"60%\"><img src=\"".$GLOBALS["PIC_BASE_URL"].$img.".gif\"> <a href=\"?action=viewforum&forumid=$forumid\"><b>$forumname</b></a><br>$forumdescription</td>
<td align=\"center\" class=\"tablea\" width=\"5%\">$topiccount</td>
<td align=\"center\" class=\"tablea\" width=\"10%\">$postcount</td>
<td class=\"tablea\" width=\"25%\">$lastpost</td></tr>");
 }
print("</table><br>");
}

print("<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr><td colspan=\"4\" class=\"tabled\"><table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr>");

print("<td width=\"20%\" class=\"tabled\"><form method=\"post\" action=\"forums.php?action=viewunread\" style=\"display:inline\"><input type=\"submit\" value=\"Ungelesene Themen\"></form></td>
<td width=\"20%\" class=\"tabled\"><form method=\"post\" action=\"forums.php?action=search\" style=\"display:inline\"><input type=\"submit\" value=\"Suche\"></form></td>
<td width=\"80%\" class=\"tabled\" align=\"right\">");

print("".insert_quick_jump_menu()."");

print("</td></tr></table>");
print("</td></tr></table>");

print("<br>&nbsp;<img src=\"".$GLOBALS["PIC_BASE_URL"]."unlockednew.gif\">&nbsp;<b>Neue Antworten</b>&nbsp;&nbsp;&nbsp;
<img src=\"".$GLOBALS["PIC_BASE_URL"]."unlocked.gif\">&nbsp;<b>Gelesene Antworten</b>&nbsp;&nbsp;&nbsp;
<img src=\"".$GLOBALS["PIC_BASE_URL"]."lockednew.gif\">&nbsp;<b>Neue Geschlossene Themen</b>&nbsp;&nbsp;&nbsp;
<img src=\"".$GLOBALS["PIC_BASE_URL"]."locked.gif\">&nbsp;<b>Gelesene Geschlossene Themen</b><br>");

print("</td></tr></table>");


?>
<br>
<table align="center" cellpadding="4" cellspacing="1" border="0" width="99%" class="tableinborder">
 <tr class="x264_wrapper_content_out_mount" width="100%">
  <td colspan="10" width="100%"><span class="normalfont">
   <font color=#FF0000><b>Forum-Stats: </b></font> User <?=$forumusers_no?> Aktiv | Post´s <?=$postcount?> | Topic´s  <?=$topiccount?> |
 </span>
</td>
 </tr>
 <tr><td width="100%" class="tablea">
  <table cellpadding="0" cellspacing="1" border="0" style="width:100%" class="tableinborder" align="center"> 
    <div>
      <font size="-2"><?=$forumusers?></font>
     </div>
    </td>
   </table>
  </td>
 </tr>
</table>
<?

print "	
		</div>
</div>
</div>";
x264_admin_footer();
?>