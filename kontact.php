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

$action = $_GET["action"];

############################################
///// Beitrag erstellen /////

if ($action == 'add') {

$res = mysql_query("SELECT * FROM forums WHERE guest = 'yes'") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) == 0)
stderr_nologged("Forumsbeitrag erstellen","<b><p>Zur Zeit ist kein Forum f&uuml;r Gastbeitr&auml;ge freigegeben.</p></b>");


$arr = mysql_fetch_assoc($res);

  //---- Create topic

$email1 = htmlentities(strip_tags(trim($_POST["email"])));
if (!$email1)
stderr_nologged("Staff Kontakt", "<b><p>Du musst eine E-Mail Adresse angeben sonst geht es nicht!</p></b>");
$email = htmlentities(strip_tags(trim(sqlesc($email1))));

$user1 = htmlentities(strip_tags(trim($_POST["user"])));
if (!$user1)
stderr_nologged("Staff Kontakt", "<b><p>Du musst einen Usernamen angeben sonst geht es nicht!</p></b>");
$user = htmlentities(strip_tags(trim(sqlesc($user1))));

$subject1 = htmlentities(strip_tags(trim($_POST["subject"])));
if (!$subject1)
stderr_nologged("Staff Kontakt", "<b><p>Du musst einen Betreff angeben sonst geht es nicht!</p></b>");
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


stderr_nologged("Staff Kontakt","<b><p>Die Nachricht wurde erfolgreich gesendet.<br><center><a href=\"login.php#tologin\">Zur&uuml;ck</a></p></b></center>");

}
############################################


///// Beitrag erstellen /////
x264_header_nologged("Contact");

?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Contact
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>?action=add" method="post" name="body" enctype="multipart/form-data">
										<input type='hidden' name='take' value='yes'>
										Bitte beachten Sie Folgendes: Ihre E-Mail-Adresse muss mit Ihrem Konto übereinstimmen.<br /><br />
										Sollten Sie ein Account bei uns haben wollen, dann können Sie dies auch über unser Kontakt Formular befragen.<br />
										<div class='input-group mb-1'>
											<span class='btn btn-flat btn-primary'>@</span>
											<input name="email" type="email" required title="my e-mail required" placeholder="E-Mail" data-icon="x" class="form-control text-left btn btn-flat btn-primary fc-today-button">
										</div>
										<div class='input-group mb-1'>
											<span class='btn btn-flat btn-primary'><i class='icon-user'></i></span>
											<input name="user" type="text" required title="username required" placeholder="Username" data-icon="x" class="form-control text-left btn btn-flat btn-primary fc-today-button">
										</div>
										<div class='input-group mb-1'>
											<span class='btn btn-flat btn-primary'><i class='icon-drawer'></i></span>										
											<input type="text" name="subject" required title="my e-mail required" placeholder="Betreff" data-icon="x" class="form-control text-left btn btn-flat btn-primary fc-today-button">
										</div>
										<? textbbcode("body","body","$arr[body]")?>
										<input type="submit" value="Nachricht versenden" class="btn btn-flat btn-primary fc-today-button">								
									</form>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?
x264_footer_nologged();
die;
?>