<?php
require_once("include/bittorrent.php");
hit_start();
dbconn();
hit_count();

function update_topic_last_post($topicid) {
$res = mysql_query("SELECT id FROM posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
$arr = mysql_fetch_row($res) or die("Es sind keine BeitrÃ¤ge vorhanden.");
$postid = $arr[0];

mysql_query("UPDATE topics SET lastpost=$postid WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
}

$application = $_GET["application"];

############################################
///// Beitrag erstellen /////

if ($application == 'go_to_application') {

$res = mysql_query("SELECT * FROM forums WHERE guest = 'yes'") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) == 0)
stderr("Deine Bewerbung","<b><p>Zur Zeit ist eine Bewerbung nicht m&ouml;glich.</p></b>");


$arr = mysql_fetch_assoc($res);

  //---- Create topic

$email1 = htmlentities(strip_tags(trim($_POST["email"])));
if (!$email1)
stderr("Deine Bewerbung", "<b><p>Du musst eine E-Mail Adresse angeben sonst geht es nicht!</p></b>");
$email = htmlentities(strip_tags(trim(sqlesc($email1))));

$user1 = htmlentities(strip_tags(trim($_POST["user"])));
if (!$user1)
stderr("Deine Bewerbung", "<b><p>Du musst einen Usernamen angeben sonst geht es nicht!</p></b>");
$user = htmlentities(strip_tags(trim(sqlesc($user1))));

$subject1 = htmlentities(strip_tags(trim($_POST["subject"])));
if (!$subject1)
stderr("Deine Bewerbung", "<b><p>Du musst einen Betreff angeben sonst geht es nicht!</p></b>");
$subject = htmlentities(strip_tags(trim(sqlesc($subject1))));

$userid = 10000;
$forumid = $arr["id"];

mysql_query("INSERT INTO topics (userid, forumid, subject, guestuser, guestname, guestmail) VALUES($userid, $forumid, $subject, 'yes', $user, $email)") or sqlerr(__FILE__, __LINE__);

$topicid = mysql_insert_id();

  //------ Insert post

$added = "'" . get_date_time() . "'";
$body1 = htmlentities(strip_tags(trim($_POST["body"])));
$body = htmlentities(strip_tags(trim(sqlesc($body1))));

mysql_query("INSERT INTO posts (topicid, userid, added, body, guestuser, guestname, guestmail) VALUES($topicid, $userid, $added, $body, 'yes', $user, $email)") or sqlerr(__FILE__, __LINE__);

$postid = mysql_insert_id();

mysql_query("UPDATE forums SET postcount = postcount + 1 WHERE id=$forumid") or sqlerr(__FILE__, __LINE__);
mysql_query("UPDATE forums SET topiccount = topiccount + 1 WHERE id=$forumid") or sqlerr(__FILE__, __LINE__);

  //------ Update topic last post

update_topic_last_post($topicid);


stderr("Deine Bewerbung","<b><p>Deine Bewerbung wurde erfolgreich gesendet.<br><center><a href=\"login.php#tologin\">Zur&uuml;ck</a></p></b></center>");

}
############################################


///// Beitrag erstellen /////
x264_header_nologged("Your application");

?>
<p><br /></p>
	<a class="hiddenanchor" id="toregister"></a>
	<a class="hiddenanchor" id="tologin"></a>
                <div id="x264_nologged_wrapper">
                    <div id="x264_nologged_wrap" style="width:750px;height:600px;margin-left: auto;margin-right: auto;">
                        <div id="login" class="animate form">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?application=go_to_application" method="post" name="body" enctype="multipart/form-data">
				<input type='hidden' name='take' value='yes'>
                                <h1 class="x264_im_logo">Your application<br /></h1>
				<br />
				<p>
					Bitte beachten Sie Folgendes: Ihre Bewerbung wird von unserem Team überprüft und bei erfolgreicher Anmeldung werden Sie benachrichtigt.
                                </p>								
                                <p>
                                    <label for="username" class="uname" data-icon="u" > Deine E-Mail Adresse </label><input type="text" name="email" size="50" maxlength="60">
                                </p>								
                                <p>
                                    <label for="username" class="uname" data-icon="e" > Dein Username </label><input type="text" name="user" size="50" maxlength="60">
                                </p>
                                <p> 		
                                    <label for="username" class="uname" data-icon="p" > Dein Betreff </label><input type="text" name="subject" size="96" maxlength="255">
                                </p>
                                <p>
                                    <label for="username" class="uname" > Deine Bewerbungsnachricht </label><? textbbcode("body","body","$arr[body]")?>
                                </p>
                                <p class="login button"> 
                                    <input type="submit" value="Bewerbung versenden" class="btn">
				</p>
                                <p class="change_link">
									Schon ein Mitglied ? <a class="button-more" href="login.php#tologin">Login</a>										
				</p>								
				</form>
                        </div>
					</div>
				</div>
</p>
<?
x264_footer_nologged();
die;
?>