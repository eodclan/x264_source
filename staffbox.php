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
check_access(UC_MODERATOR);
security_tactics();

$action = $_GET["action"];
$actionn=(int)$_GET['actionn'];
$actionn=($actionn<1?0:$actionn>3?0:$actionn);
$uid = $_GET['id'];

if($actionn && !empty($uid)) {
$uida=explode('o',$uid);
foreach($uida as $key => $value)
$uida[$key]='id='. sqlesc((int)abs($value));
$uids=implode(" OR ",$uida);
if($actionn==2) {
$query="UPDATE staffmessages SET answered=1, answeredby = $CURUSER[id] WHERE  (". $uids .")";
$type = "beantwortet";
}
else
{
$query="DELETE FROM staffmessages WHERE (". $uids .")";
$type = "gelöscht";
}

$num=count($uida);
mysql_query($query);
}

///////////////////////////
// Zeige Team Nachrichten //
/////////////////////////

if (!$action) {

if (get_user_class() < UC_MODERATOR)
stderr("Fehler", "Zugriff Verweigert.");

x264_admin_header();
?>
<script type="text/javascript">
function checkAll(ref)
{
var chkAll = document.getElementById('checkAll');
var checks = document.getElementsByName('cbox');
var uid = document.getElementById('id');
var boxLength = checks.length;
var allChecked = true;
var uids = "";

if(ref==1) {
for(i=0;i<boxLength;i++) {
checks[i].checked=chkAll.checked;
if(chkAll.checked==true)
uids += checks[i].value+"o";
}
} else {
for(i=0;i<boxLength;i++) {
if(checks[i].checked==true)
uids += checks[i].value+"o";
else
allChecked=false;
}
chkAll.checked=allChecked;
}
uid.value=uids.substring(0,uids.length-1);
}
</script>
<?

$res = mysql_query("SELECT count(id) FROM staffmessages") or die(mysql_error());
$row = mysql_fetch_array($res);

$url = " .$_SERVER[PHP_SELF]?";
$count = $row[0];
$perpage = 20;
//list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, $url);



if ($count == 0) {
print("
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Team PM System
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>Keine Nachrichten Vorhanden
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>");
}
else {

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Team PM System
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
            <div class='box-body'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <th>Anliegen</th>
                  <th>Mitglied</th>
                  <th>Empfangen</th>
                  <th>Datum</th>
                  <th>Bearbeitet</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>";

$res = mysql_query("SELECT staffmessages.id, staffmessages.added, staffmessages.subject, staffmessages.answered, staffmessages.answeredby, staffmessages.sender, staffmessages.answer, users.username FROM staffmessages INNER JOIN users on staffmessages.sender = users.id ORDER BY id desc $limit");

while ($arr = mysql_fetch_assoc($res))
{
if ($arr[answered])
{
$res3 = mysql_query("SELECT username FROM users WHERE id=$arr[answeredby]");
$arr3 = mysql_fetch_assoc($res3);
$answered = "<font color=green><b>Ja - <a href=userdetails.php?id=$arr[answeredby]><b>$arr3[username]</b></a> (<a href=staffbox.php?action=viewanswer&pmid=$arr[id]>Status Ansehen</a>)</b></font>";
}
else
$answered = "<font color=red><b>Nein</b></font>";

$pmid = $arr["id"];

print"
				  </td>
                  <td><a href=/staffbox.php?action=viewpm&pmid=$pmid><b>$arr[subject]</b></td>
                  <td><a href=userdetails.php?id=$arr[sender]><b>$arr[username]</b></a></td>
                  <td>".$arr[added]."</td>
                  <td>".$answered."</td>
                </tr>";
?>

				<td class=tablea align="center" valign="middle" class="tablea">
					<input name="cbox" type="checkbox" onClick="checkAll(2)" value="<?=$arr[id]?>">
				</td>
<?
}
print"
                </tbody>
                <tfoot>
                <tr>
                  <th>Anliegen</th>
                  <th>Mitglied</th>
                  <th>Empfangen</th>
                  <th>Datum</th>
                  <th>Bearbeitet</th>
                </tr>
                </tfoot>
              </table>";

?>
				<td class=tablea align="center" valign="middle" class="tablea">
					Alle&nbsp;<input id='checkAll' type='checkbox' onClick='checkAll(1)' value=''>
				</td>
<form action="staffbox.php" method="get">
<input name="id" id="id" type="hidden" value="">
&nbsp;Aktion:&nbsp;
<select name="actionn" size="1">
<option value="1">-Auswählen-</option>
<option value="2">Bearbeitet</option>
<option value="3">Löschen</option>
</select>&nbsp;<input id="Submit" value="Senden" type="submit">
</form>

<?
echo $pagerbottom;
print("</form>");
}
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
x264_admin_footer();
}

//////////////////////////
// Nachrichten Ansehen //
//////////////////////////

if ($action == "viewpm")
{

if (get_user_class() < UC_MODERATOR)
stderr("Fehler", "Zugriff Verweigert.");

$pmid = 0 + $_GET["pmid"];

$ress4 = mysql_query("SELECT id, subject, sender, added, msg, answeredby, answered, readed FROM staffmessages WHERE id=$pmid");
$arr4 = mysql_fetch_assoc($ress4);

if ($arr4['readed'] == "no")
{
  mysql_query("UPDATE staffmessages SET readed = ".sqlesc($CURUSER['id']."|".time())." WHERE id = ".$pmid);
}
else
{
  $data = explode("|",$arr4['readed']);
  if ($data[0] != $CURUSER['id'])
  {  
    if ((time() - $data[1]) > 300)
    {
      mysql_query("UPDATE staffmessages SET readed = ".sqlesc($CURUSER['id']."|".time())." WHERE id = ".$pmid);
    }
    else
    {
      $pminfo = mysql_query("SELECT username FROM users WHERE id = ".$data[0]);
      $pmarr  = mysql_fetch_assoc($pminfo);
      $pmshow = true;
    }
  }
}  

$answeredby = $arr4["answeredby"];

$rast = mysql_query("SELECT username FROM users WHERE id=$answeredby");
$arr5 = mysql_fetch_assoc($rast);

$senderr = "" . $arr4["sender"] . "";

if (is_valid_id($arr4["sender"]))
{
$res2 = mysql_query("SELECT username FROM users WHERE id=" . $arr4["sender"]) or sqlerr();
$arr2 = mysql_fetch_assoc($res2);
$sender = "<a href='userdetails.php?id=$senderr'>" . ($arr2["username"] ? $arr2["username"]:"[Gelöscht]") . "</a>";
}
else
$sender = "System";

$subject = $arr4["subject"];

if ($arr4["answered"] == '0') {
$answered = "<font color=red><b>Nein</b></font>";
}
else {
$answered = "<font color=green><b>Ja</b></font> von <a href=userdetails.php?id=$answeredby>$arr5[username]</a> (<a href=staffbox.php?action=viewanswer&pmid=$pmid>Antwort Ansehen</a>)";
}

if ($arr4["answered"] == '0') {
$setanswered = "[<a href=/staffbox.php?action=setanswered&id=$arr4[id]>Setze als Beantwortet</a>]";
}
else {
$setanswered = "";
}

$iidee = $arr4["id"];

    x264_admin_header("Team-PM ansehen");
    if ($pmshow === true)
{
  stdmsg("Achtung", $pmarr['username']." betrachtet seit ".get_date_time($data[1])." diese Team PM. Bitte lasse diesem Teammitglied den Vortritt.");
}
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Team PM System
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
print("<table class='table'>\n");
print("<tr>");	
$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr4["added"]));
    ?>
  <colgroup>
    <col width="50">
    <col>
  </colgroup>
  <tr>
    <td class="tablecat" colspan="2"><b>Betreff:</b> <?=$subject?></td>
  </tr>
  <tr>
    <td class="tableb"><b>Absender:</b></td>
    <td class="tablea"><b><?=$sender?></b> am <?=$arr4["added"]?> (vor <?=$elapsed?>)</td>
  </tr>
  <tr>
    <td class="tableb"><b>Bearbeitet:</b></td>
    <td class=tablea><?=$answered?>&nbsp;&nbsp;<?=$setanswered?></td>
  </tr>
  <tr>
    <td class="tableb" valign="top"><b>Nachricht:</b></td>
    <td class="tablea"><?=format_comment($arr4["msg"])?></td>
  </tr>
  <tr>
    <td class="tablea" style="text-align:center;" colspan="2">
<?php
   print(($arr4["sender"] ? "<a href=/staffbox.php?action=answermessage&receiver=" . $arr4["sender"] . "&answeringto=$iidee><input type=submit class=btn value=Antworten></a>" : "<input type=submit class=btn value=Antworten>") ."");
   ?>
</td>
  </tr>
<?php
print("</tr></table>\n");
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
x264_admin_footer();
}

//////////////////////////
// Antworten Ansehen //
//////////////////////////

if ($action == "viewanswer")
{

if (get_user_class() < UC_MODERATOR)
stderr("Fehler", "Zugriff Verweigert.");

$pmid = 0 + $_GET["pmid"];

$ress4 = mysql_query("SELECT id, subject, sender, added, msg, answeredby, answered, answer FROM staffmessages WHERE id=$pmid");
$arr4 = mysql_fetch_assoc($ress4);

$answeredby = $arr4["answeredby"];

$rast = mysql_query("SELECT username FROM users WHERE id=$answeredby");
$arr5 = mysql_fetch_assoc($rast);

if (is_valid_id($arr4["sender"]))
{
$res2 = mysql_query("SELECT username FROM users WHERE id=" . $arr4["sender"]) or sqlerr();
$arr2 = mysql_fetch_assoc($res2);
$sender = "<a href=userdetails.php?id=" . $arr4["sender"] . ">" . ($arr2["username"]?$arr2["username"]:"[Gelöscht]") . "</a>";
}
else
$sender = "System";

if ($arr4['subject'] == "") {
$subject = "No subject";
}

else {
$subject = "<a style='color: green' href=staffbox.php?action=viewpm&pmid=$pmid>$arr4[subject]</a>";
}


$iidee = $arr4["id"];

if ($arr4[answer] == "") {

$answer = "Diese Nachricht wurde bisher noch nicht beantwortet!";
}

else {

$answer = $arr4["answer"];
}


    x264_admin_header("Antwort Ansicht");
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Team PM System - Anworten ansehen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
print("<table class='table'>\n");
print("<tr>");	

$elapsed = get_elapsed_time(sql_timestamp_to_unix_timestamp($arr4["added"]));

    ?>
  <tr>
    <td class="tablecat" colspan="2"><b>Betreff:</b> <?=$subject?></td>
  </tr>
  <tr>
    <td class="tableb"><b>Bearbeiter:</b></td>
    <td class="tablea"><b><a href=userdetails.php?id=<?=$answeredby?>><?=$arr5[username]?></a></b> beantwortete die Nachricht von <?=$sender?></td>
  </tr>
  <tr>
    <td class="tableb"><b>Erhalten:</b></td>
    <td class="tablea">vor <?=$elapsed?></td>
  </tr>
  <tr>
    <td class="tableb" valign="top"><b>Antwort:</b></td>
    <td class="tablea"><?=format_comment($answer)?></td>
  </tr>

    <?php
print("</tr></table><br />\n");
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
    x264_admin_footer();

}


//////////////////////////
// Beantwortung der Nachricht //
//////////////////////////

if ($action == "answermessage") {

if (get_user_class() < UC_MODERATOR)
stderr("Fehler", "Zugriff Verweigert");

$answeringto = $_GET["answeringto"];
$receiver = 0 + $_GET["receiver"];

if (!is_valid_id($receiver))
die;

$res = mysql_query("SELECT * FROM users WHERE id=$receiver") or die(mysql_error());
$user = mysql_fetch_assoc($res);

if (!$user)
stderr("Fehler", "Keinen User gefunden mit der ID.");

$res2 = mysql_query("SELECT * FROM staffmessages WHERE id=$answeringto") or die(mysql_error());
$array = mysql_fetch_assoc($res2);

x264_admin_header("Antwort zur Team PM", false);

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Team PM System - Anworten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
print("<table class='table'>\n");
print("<tr>");	
    ?>
<form action=?action=takeanswer method="post" name="message" enctype="multipart/form-data">
<? if ($_GET["returnto"] || $_SERVER["HTTP_REFERER"]) { ?>
<input type=hidden name=returnto value=<?=$_GET["returnto"] ? $_GET["returnto"] : $_SERVER["HTTP_REFERER"]?>>
<? } ?>
  <colgroup>
    <col width="50">
    <col>
  </colgroup>
  <tr>
    <td class="tableb" valign="top"><b>Nachricht:</b></td>
    <td class=tablea align=left input type=text style='padding: 0px'><? textbbcode_none_style("message","msg","$body")?></td>
  </tr>
  <tr>
    <td class="tablec"<?=$replyto?" colspan=2":""?> colspan=2 align=center><input type=submit value="Und ab!" class=btn>
     <input type=hidden name=receiver value=<?=$receiver?>>
     <input type=hidden name=answeringto value=<?=$answeringto?>>
     </form>
    </td>
  </tr>

    <?php
print("</tr></table><br />\n");
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
    x264_admin_footer();
}


//////////////////////////
// Antwort Abschicken //
//////////////////////////

$ress4 = mysql_query("SELECT staffmessages.subject FROM staffmessages ORDER BY id desc");
$arr4 = mysql_fetch_assoc($ress4);
$subject = $arr4["subject"];


if ($action == "takeanswer") {


if ($_SERVER["REQUEST_METHOD"] != "POST")
stderr("Fehler", "Methode");

if (get_user_class() < UC_MODERATOR)
stderr("Fehler", "Zugriff verweigert");

$receiver = 0 + $_POST["receiver"];
$answeringto = $_POST["answeringto"];

if (!is_valid_id($receiver))
stderr("Fehler","Falsche ID");

$userid = $CURUSER["id"];

$msg = trim($_POST["msg"]);

$message = sqlesc($msg);

$added = "'" . get_date_time() . "'";

if (!$msg)
stderr("Fehler","Bitte eine Nachricht eingeben!");

sendPersonalMessage($userid, $receiver, "Team-PM Antwort - " . $subject . "", "[size=2][b]" . $msg . "[/b][/size]", PM_FOLDERID_INBOX, 0);

mysql_query("UPDATE staffmessages SET answer=$message WHERE id=$answeringto") or sqlerr(__FILE__, __LINE__);

mysql_query("UPDATE staffmessages SET answered='1', answeredby='$userid' WHERE id=$answeringto") or sqlerr(__FILE__, __LINE__);

header("Location: staffbox.php?action=viewpm&pmid=$answeringto");
die;
}

?>