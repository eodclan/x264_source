<?php
require_once("include/bittorrent.php");
dbconn();
loggedinorreturn();

if(intval($_GET["id"]) != 0)
{
   $titel  = "Wette editieren";
   $neu    = FALSE;
   $action = $_SERVER["PHP_SELF"] . "?id=" . intval($_GET[id]);
   $topic  = "Details zu Spiel Nr.: " . intval($_GET[id]);
   $box    = "<input type=\"hidden\" name=\"edit\" value=\"true\">";
   $button = "<input type=\"submit\" value=\"Editieren\"></center>";
}
else
{
   $titel  = "Wette neu anlegen";
   $neu    = TRUE;
   $action = $_SERVER["PHP_SELF"];
   $topic  = "Spiel neu erstellen";
   $box    = "<input type=\"hidden\" name=\"neu\" value=\"true\">";
   $button = "<input type=\"submit\" value=\"Spiel anlegen\"></center>";
}

x264_header($titel);

check_access(UC_ADMINISTRATOR);
security_tactics();
?>
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'><?=$titel?></h1>
	<div class='x264_title_content'>
<?
if(!empty($_POST[edit]) && ($_POST[edit] == "true"))
{
  /////Anfang Eintragen der Wette/////
  /////Quote formatieren/////
  $quote1 = str_replace(",",".",htmlentities($_POST[quote1]));
  $quote0 = str_replace(",",".",htmlentities($_POST[quote0]));
  $quote2 = str_replace(",",".",htmlentities($_POST[quote2]));

  /////Eingabe überprüfen////// ([0-9]|\.)/
  if($_POST[home]!="" && $_POST[guest]!="")
  {
     if(!preg_match("/[0-9.]/", $quote1) or !preg_match("/[0-9.]/", $quote1) or !preg_match("/[0-9.]/", $quote1))
     {
         echo "Fehler in der Eingabe";
     }
     else
     {
         if($_POST[home]!="" && $_POST[guest]!="")
         {
             $sql="UPDATE `betting_games` SET home='".$_POST[home]."' , guest='".$_POST[guest]."' , time='".(strtotime($_POST[jahr]."-".$_POST[monat]."-".$_POST[tag]." ".$_POST[stunde].":".$_POST[minute].":00"))."' , quote1='$quote1', quote0='$quote0', quote2='$quote2' , type='".$_POST[type]."', madeby='".$CURUSER[id]."', end='".$_POST[end]."', p_home='".$_POST[p_home]."', p_guest='".$_POST[p_guest]."' WHERE gid=".$_GET[id].";";
//             print($sql);
             mysql_query($sql);
         }
     }
  }
print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Erfolgreich editiert</h1>
	<div class='x264_title_content'>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ok:</div><div class='x264_tfile_add_inc'><a href='betoverview.php'>Zurück zur Übersicht</a></div></div>	
		<div class='x264_title_table'><div class='x264_nologged_inp'>Wette anlegen:</div> <div class='x264_tfile_add_inc'><a href=\"" . $_SERVER["PHP_SELF"] . "\">eine weitere Wette anlegen</a></div></div>		
	</div>
</div>
</div>";  
  x264_footer();
  exit;
  /////Ende Eintragen der Wette/////
}

if(!empty($_POST[neu]) && ($_POST[neu] == "true"))
{
  /////Anfang Eintragen der Wette/////
  /////Quote formatieren/////
  $quote1 = str_replace(",",".",htmlentities($_POST[quote1]));
  $quote0 = str_replace(",",".",htmlentities($_POST[quote0]));
  $quote2 = str_replace(",",".",htmlentities($_POST[quote2]));

  /////Eingabe überprüfen////// ([0-9]|\.)/
  if($_POST[home]!="" && $_POST[guest]!="")
  {
     if(!preg_match("/[0-9.]/", $quote1) or !preg_match("/[0-9.]/", $quote1) or !preg_match("/[0-9.]/", $quote1))
     {
         echo "Fehler in der Eingabe";
     }
     else
     {
         if($_POST[home]!="" && $_POST[guest]!="")
         {
             $home   = htmlentities($_POST[home]);
             $guest  = htmlentities($_POST[guest]);
             $time   = (strtotime($_POST[jahr]."-".$_POST[monat]."-".$_POST[tag]." ".$_POST[stunde].":".$_POST[minute].":00"));
             $quote1 = htmlentities($quote1);
             $quote0 = htmlentities($quote0);
             $quote2 = htmlentities($quote2);
             $type   = htmlentities($_POST[type]);

             $sql="INSERT INTO betting_games (home,guest,time,quote1,quote0,quote2,type,madeby) VALUES ('$home','$guest','$time','$quote1','$quote0','$quote2','$type','$CURUSER[id]')";
//             print($sql);
             mysql_query($sql);
         }
     }
  }
print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Erfolgreich editiert</h1>
	<div class='x264_title_content'>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ok:</div><div class='x264_tfile_add_inc'><a href='betoverview.php'>Zurück zur Übersicht</a></div></div>	
		<div class='x264_title_table'><div class='x264_nologged_inp'>Wette anlegen:</div> <div class='x264_tfile_add_inc'><a href=\"" . $_SERVER["PHP_SELF"] . "\">eine weitere Wette anlegen</a></div></div>		
	</div>
</div>
</div>";  
  x264_footer();
  exit;
  /////Ende Eintragen der Wette/////
}

if (!$neu)
{
  $sql = "SELECT * FROM betting_games WHERE gid=".intval($_GET[id]);
  $req = mysql_query($sql);
  $r0  = mysql_fetch_assoc($req);
}

//Erstellen der Auswahlfelder
for($var=1;$var<32;$var++)
{
  if ($var <= 9) $var = "0" . $var;
  if($var==date("d",$r0[time]))
    $sel=" selected";
  else
    $sel="";
  $day=$day."<option".$sel.">".$var."</option>";
}
$day="<select name='tag' size='1'>".$day."</select>";
$sel="";

for($var=1;$var<13;$var++)
{
  if ($var <= 9) $var = "0" . $var;
  if($var==date("n",$r0[time])){
    $sel=" selected";
  }else{
    $sel="";
  }
  $mon=$mon."<option".$sel.">".$var."</option>";
}
$mon="<select name='monat' size='1'>".$mon."</select>";
$sel="";

for($var=date("Y");$var<(date("Y")+2);$var++)
{
  if($var==date("Y",$r0[time]))
    $sel=" selected";
  else
    $sel="";
  $yea=$yea."<option".$sel.">".$var."</option>";
}
$yea="<select name='jahr' size='1'>".$yea."</select>";
$sel="";

for($var=0;$var<24;$var++)
{
  if ($var <= 9) $var = "0" . $var;
  if($var==date("H",$r0[time]))
    $sel=" selected";
  else
    $sel="";
  $hou=$hou."<option".$sel.">".$var."</option>";
}
$hou="<select name='stunde' size='1'>".$hou."</select>";
$sel="";

for($var=0;$var<60;$var++)
{
  if ($var <= 9) $var = "0" . $var;
  if($var==date("i",$r0[time]))
    $sel=" selected";
  else
    $sel="";
  $min=$min."<option".$sel.">".$var."</option>";
}
$min="<select name='minute' size='1'>".$min."</select>";
$sel="";

?>
<form action='<?= $action ?>' method='POST'>
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'><?=$topic?></h1>
	<div class='x264_title_content'>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Spielbeginn</div><div class='x264_tfile_add_inc'><?=$day."-".$mon."-".$yea." - ".$hou.":".$min?></div></div>	
		<div class='x264_title_table'><div class='x264_nologged_inp'>Heim:</div> <div class='x264_tfile_add_inc'><input type=text value="<?=$r0[home];?>" name=home></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ausw&auml;rts:</div> <div class='x264_tfile_add_inc'><input type=text value="<?=$r0[guest];?>" name=guest></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Typ:</div>
		<div class='x264_tfile_add_inc'>
			<select name="type">
				<option value="1.Bundesliga"<?=($r0[type] == "1.Bundesliga") ? " selected" : "" ?>>1.Bundesliga</option>
				<option value="2.Bundesliga"<?=($r0[type] == "2.Bundesliga") ? " selected" : "" ?>>2.Bundesliga</option>
				<option value="Champions League"<?=($r0[type] == "Champions League") ? " selected" : "" ?>>Champions League</option>
				<option value="DFB Pokal"<?=($r0[type] == "DFB Pokal") ? " selected" : "" ?>>DFB Pokal</option>
				<option value="UEFA Cup"<?=($r0[type] == "UEFA Cup") ? " selected" : "" ?>>UEFA Cup</option>
				<option value="EM 2008"<?=($r0[type] == "EM 2008") ? " selected" : "" ?>>EM 2020</option>
			</select>		
		</div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Quote Heim:</div> <div class='x264_tfile_add_inc'><input type=text value="<?=$r0[quote1];?>" name=quote1></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Quote Unendschieden:</div> <div class='x264_tfile_add_inc'><input type=text value="<?=$r0[quote0];?>" name=quote0></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Quote Ausw&auml;rts:</div> <div class='x264_tfile_add_inc'><input type=text value="<?=$r0[quote2];?>" name=quote2></div></div>		
		<div class='x264_title_table'><div class='x264_nologged_inp'>Wette Beenden:</div><div class='x264_tfile_add_inc'><input type=text value="<?=($_GET["close"] == 1) ? "1" : $r0[end];?>" name=end> (Zum beenden eine <font color="#FF0000">1</font> setzen ansonsten <font color="#FF0000">leer</font> lassen)</div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Endstand Heim:</div> <div class='x264_tfile_add_inc'><input type=text value="<?=$r0[p_home];?>" name=p_home></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Endstand Gast:</div> <div class='x264_tfile_add_inc'><input type=text value="<?=$r0[p_guest];?>" name=p_guest></div></div>	
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ok:</div> <div class='x264_tfile_add_inc'><?=$box . $button?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Wett Optionen:</div> <div class='x264_tfile_add_inc'><a href="betoverview.php"><font color="#FF0000">Zur&uuml;ck zur &Uuml;bersicht</font></a>&nbsp;|&nbsp;<a href="bet.php"><font color="#FF0000">Zur&uuml;ck zu den Wetten</font></a>&nbsp;|&nbsp;<a href="betclosed.php"><font color="#FF0000">Wetten beenden</font></div></div>			
	</div>
</div>
</div>
</form>	
<?

x264_footer();
?>