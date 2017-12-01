<?php
require_once("include/bittorrent.php");

dbconn();
loggedinorreturn();

function Tag($tag)
{
  switch($tag)
  {
     case "Monday"    : return "Mo";
                        break;
     case "Tuesday"   : return "Di";
                        break;
     case "Wednesday" : return "Mi";
                        break;
     case "Thursday"  : return "Do";
                        break;
     case "Friday"    : return "Fr";
                        break;
     case "Saturday"  : return "Sa";
                        break;
     case "Sunday"    : return "So";
                        break;

  }
}

x264_header("Wettb&uuml;ro Details");
check_access(UC_ADMINISTRATOR);
security_tactics();
?>
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Wettb&uuml;ro Details</h1>
	<div class='x264_title_content'>
<?
if(htmlentities($_GET["action"]) == "delete")
{
  begin_frame("Wette Löschen");
  $id = intval($_GET["id"]);
  mysql_query("DELETE FROM betting_games WHERE gid = '$id'") or sqlerr(__FILE__,__LINE__);
  mysql_query("DELETE FROM betting_bet WHERE gid = '$id'") or sqlerr(__FILE__,__LINE__);
?>
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Wette erfolgreich gelöscht</h1>
	<div class='x264_title_content'>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Erfolgreich</div><div class='x264_tfile_add_inc'><a href="<?=$_SERVER["PHP_SELF"] ?>">Weiter</a></div></div>		
	</div>
</div>
</div>
<?
}
if($_GET[id]!=""){
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Details zu Spiel Nr.:</div><div class='x264_tfile_add_inc'><?=$_GET[id]?></div></div>
<?
$sql="SELECT * FROM betting_games WHERE gid=".$_GET[id];
$req0=mysql_query($sql);
while($r0=mysql_fetch_assoc($req0)){

$datum = getdate($r0[time]);

?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Spielbeginn</div><div class='x264_tfile_add_inc'><?=Tag($datum[weekday]).date(" j.m.Y G:i",$r0[time])?></div></div>	
		<div class='x264_title_table'><div class='x264_nologged_inp'>Heim:</div> <div class='x264_tfile_add_inc'><?=$r0[home];?></div></div>
<?
if($r0[end]=="0"){
$status="Noch nicht beendet";
}else{
$status=$r0[p_home].":".$r0[p_guest];
}
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ergebnis:</div> <div class='x264_tfile_add_inc'><?=$status;?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ausw&auml;rts:</div><div class='x264_tfile_add_inc'><?=$r0[guest];?></div></div>	
		<div class='x264_title_table'><div class='x264_nologged_inp'>Quote Heim:</div> <div class='x264_tfile_add_inc'><?=$r0[quote1];?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Quote Unendschieden:</div> <div class='x264_tfile_add_inc'><?=$r0[quote0];?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Quote Ausw&auml;rts:</div><div class='x264_tfile_add_inc'><?=$r0[quote2];?></div></div>	
<?
$sql="SELECT id, username, class, enabled, warned, donor FROM users WHERE id=".$r0[madeby];
$req=mysql_query($sql);
$req=mysql_fetch_assoc($req);

$icons = array("enabled" => $req["enabled"], "warned" => $req["warned"], "donor" => $req["donor"]);
$name = "<a href=userdetails.php?id=".htmlentities($r0["madeby"]). "><font class=".get_class_color($req["class"]).">".htmlentities($req["username"])."</a>&nbsp;" .get_user_icons($icons). "";
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ok:</div> <div class='x264_tfile_add_inc'><?=$name;?></div></div>
<?
}
$sql="SELECT * FROM betting_bet WHERE gid=".$_GET[id];
$req0=mysql_query($sql);
while($r0=mysql_fetch_assoc($req0)){
?>
  <tr>
<?
$sql="SELECT id, username, class, enabled, warned, donor FROM users WHERE id=".$r0[uid];
$req1=mysql_query($sql);
$r1=mysql_fetch_assoc($req1);

$icons = array("enabled" => $r1["enabled"], "warned" => $r1["warned"], "donor" => $r1["donor"]);
$namee = "<a href=userdetails.php?id=".htmlentities($r0["uid"]). "><font class=".get_class_color($r1["class"]).">".htmlentities($r1["username"])."</a>&nbsp;" .get_user_icons($icons). "";
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>User:</div> <div class='x264_tfile_add_inc'><a href=userdetails.php?id=<?=$r0[uid];?>><?=$namee?></a></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Tipp:</div><div class='x264_tfile_add_inc'><?=$r0[tip];?></div></div>	
		<div class='x264_title_table'><div class='x264_nologged_inp'>Einsatz:</div> <div class='x264_tfile_add_inc'><?=$r0[insert];?> GB</div></div>
<?
}
?>
	</div>
</div>
</div>
<?
}
?>
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Verf&uuml;gbare Wetten</h1>
	<div class='x264_title_content'>
<?

// $sql="SELECT * FROM betting_games ORDER BY gid DESC";
$sql="SELECT * FROM betting_games ORDER BY time ASC";
$req=mysql_query($sql);
while($r=mysql_fetch_assoc($req)){

$datum = getdate($r[time]);

/////Anfang Status/////
if($r[end]==0){
$status="Laufend";
}else{
$status="Ende";
}
/////Ende Status/////
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Spielbeginn:</div><div class='x264_tfile_add_inc'><?=Tag($datum[weekday]).date(" j.m.Y G:i",$r[time])?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Heim:</div><div class='x264_tfile_add_inc'><?=$r[home];?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ausw&auml;rts:</div><div class='x264_tfile_add_inc'><?=$r[guest];?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Status</div><div class='x264_tfile_add_inc'><?=$status;?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Einnahmen</div><div class='x264_tfile_add_inc'><?=$r[in];?> GB</div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ausgaben:</div><div class='x264_tfile_add_inc'><?=$r[out];?> GB</div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ergebnis:</div><div class='x264_tfile_add_inc'><?=$r[p_home].":".$r[p_guest];?></div></div>
<?
$sql="SELECT * FROM betting_bet WHERE gid=".$r[gid];
$req2=mysql_query($sql);
$r2=mysql_num_rows($req2);
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>User:</div><div class='x264_tfile_add_inc'><?=$r2;?> User</div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Details:</div><div class='x264_tfile_add_inc'><a href=<?=$PHP_SELF?>?id=<?=$r[gid]?>>Details</a></div></div>		
<?
if((($r[madeby] == $CURUSER[id]) || (get_user_class() >= UC_ADMINISTRATOR)) && ($r[end]==0)){
$close="<a href=betedit.php?id=".$r[gid]."&amp;close=1>Schlie&szlig;en</a>";
}else{
$close="<font color=\"red\">Nicht erlaubt</font>";
}

if((($r[madeby] == $CURUSER[id]) || (get_user_class() >= UC_ADMINISTRATOR)) && ($r[end]==0)){
$edit="<a href=betedit.php?id=".$r[gid].">Editieren</a>";
}else{
$edit="<font color=\"red\">Nicht erlaubt</font>";
}

if(($r[madeby] == $CURUSER[id]) || (get_user_class() >= UC_ADMINISTRATOR)){
$delete="<a href=$PHP_SELF?action=delete&amp;id=".$r[gid].">L&ouml;schen</a>";
}else{
$delete="<font color=\"red\">Nicht erlaubt</font>";
}
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Schlie&szlig;en:</div><div class='x264_tfile_add_inc'><?=$close;?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Editieren:</div><div class='x264_tfile_add_inc'><?=$edit;?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>L&ouml;schen:</div><div class='x264_tfile_add_inc'><?=$delete;?></div></div><br class="clear" />		
<?
}
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Wettb&uuml;ro Einstellungen</div><div class='x264_tfile_add_inc'><a href="betedit.php"><font color="#FF0000">Wetten Bearbeiten</font></a>&nbsp;|&nbsp;<a href="bet.php"><font color="#FF0000">Wetten</font></a>&nbsp;|&nbsp;<a href="betclosed.php"><font color="#FF0000">Wetten beenden</font></a></div></div>
	</div>
</div>
</div>
<?
x264_footer();
?>