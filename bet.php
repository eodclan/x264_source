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

/////Anfang Einsatz OK (nur diese Zeile)/////

if(($_POST["tippen"] == "ok") && ($_GET[bet]!="ok"))
{

   /////Anfang Wette berprüfen und setzen/////
   if($_POST[tip] != "" && $_POST[insert] != "")
   {

      $insert = str_replace(",",".",htmlentities($_POST[insert]));

      /////Prüfen auf Ganzzahl/////
      if($insert != round($insert,0))
      {
         header("Location: " . $GLOBALS["BASEURL"] . $_SERVER["PHP_SELF"] ."?err=1");
         die();
      }

      /////Prüfen auf Positiv/////
      if($insert <= 0)
      {
         header("Location: " . $GLOBALS["BASEURL"] . $_SERVER["PHP_SELF"] ."?err=5");
         die();
      }

      if ($insert > 100) $insert = 100;

      /////Prüfen auf genug Upload,Ratio usw/////
      $sql="SELECT uploaded, downloaded FROM users WHERE id=".$CURUSER[id];
      $req=mysql_query($sql);
      $upl=mysql_fetch_assoc($req);
      $ratio = number_format($upl["uploaded"] / $upl["downloaded"], 3);
      $upload = ($upl["uploaded"]-$insert*1024*1024*1024);
      $uplratio = number_format($upload / $upl["downloaded"], 3);
      if(($upl[uploaded] < $insert*1024*1024*1024) OR ($ratio < 0.700) OR ($uplratio < 0.700))
      {
         header("Location: " . $GLOBALS["BASEURL"] . $_SERVER["PHP_SELF"] ."?err=2");
         die();
      }

      /////Prüfen der Zeit/////
      $sql="SELECT time FROM betting_games WHERE gid=".$_POST[gid];
      $req=mysql_query($sql);
      $r=mysql_fetch_assoc($req);
      if(time() > $r[time])
      {
         header("Location: " . $GLOBALS["BASEURL"] . $_SERVER["PHP_SELF"] ."?err=3");
         die();
      }

      /////Prüfen auf Vorhanden/////
      $sql="SELECT * FROM betting_bet WHERE gid=".$_POST[gid]." AND uid=".$CURUSER[id];
      $req=mysql_query($sql);
      if(mysql_num_rows($req)>0)
      {
         header("Location: " . $GLOBALS["BASEURL"] . $_SERVER["PHP_SELF"] ."?err=4");
         die();
      }

      /////Setzen des Einsatzes/////
      $sql="INSERT INTO `betting_bet` (`uid`,`gid`,`tip`,`insert`) VALUES ('".intval($CURUSER[id])."','".intval($_POST[gid])."','".intval($_POST[tip])."','".$insert."')";
      mysql_query($sql);

      /////Abziehen des Uploads/////
      $sql="Update users SET `uploaded`=`uploaded`-".($insert*1024*1024*1024)." WHERE id=".$CURUSER[id];
      mysql_query($sql);

      ///// Setzen der Werte in der users /////
      $sql="UPDATE users SET `bet_out`=`bet_out`+".$insert." WHERE id=".$CURUSER[id];
      mysql_query($sql);

      ///// Setzen der Werte in der users /////
      $sql="UPDATE users SET `bet_games`=`bet_games`+1 WHERE id=".$CURUSER[id];
      mysql_query($sql);

      /////Eintragen der GBs/////
      $sql=" UPDATE `betting_games` SET `in` = `in`+'".$insert."' WHERE `gid` =".$_POST[gid];
      mysql_query($sql);
      header("Location: " . $GLOBALS["BASEURL"] . $_SERVER["PHP_SELF"] ."?bet=ok");
      die();

      ///// Modcomment eintragen /////
      write_modcomment($CURUSER["id"], 0, "Hat beim Wetten $insert GB gesetzt.");
   }

   x264_header("Wettb&uuml;ro");
   /////Anfang Tabellen bei bet!=OK/////
?>
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Wettb&uuml;ro</h1>
	<div class='x264_title_content'>
<?
   /////Errorausgaben/////
   $error = intval($_GET["err"]);

   if($error == 1)
      echo "<font color=\"#FF0000\">Der Einsatz ist keine runde Zahl</font>";

   if($error == 2)
      echo "<font color=\"#FF0000\">Du besitzt nicht genügend Upload oder deine Ratio ist bzw wird nach dem Einsatz zu schlecht</font>";

   if($error == 3)
      echo "<font color=\"#FF0000\">Der Einsatz wurde zu spät abgegeben</font>";

   if($error == 4)
      echo "<font color=\"#FF0000\">Du hast bei dieser Wette schon gewettet</font>";

   if($error == 5)
      echo "<font color=\"#FF0000\">Das war wohl nix ;)</font>";

   /////Ende Einsatz OK/////
}
else
{
x264_header("Wettb&uuml;ro");
  /////Anfang Tabellen bei bet==ok/////
?>
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Wettb&uuml;ro</h1>
	<div class='x264_title_content'>
<?

   /////Errorausgaben/////
   $error = intval($_GET["err"]);

   if($error == 1)
      echo "<font color=\"#FF0000\">Der Einsatz ist keine runde Zahl</font>";

   if($error == 2)
      echo "<font color=\"#FF0000\">Du besitzt nicht genügend Upload oder deine Ratio ist bzw wird nach dem Einsatz zu schlecht</font>";

   if($error == 3)
      echo "<font color=\"#FF0000\">Der Einsatz wurde zu spät abgegeben</font>";

   if($error == 4)
      echo "<font color=\"#FF0000\">Du hast bei dieser Wette schon gewettet</font>";

   if($error == 5)
      echo "<font color=\"#FF0000\">Das war wohl nix ;)</font>";

   /////Ende Einsatz OK/////

if(($_GET[bet]=="ok"))
  echo "<font color=\"#FF0000\">Einsatz erfolgreich</font>";
}
if (get_user_class() >= UC_ADMINISTRATOR){
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Wettb&uuml;ro Einstellungen</div><div class='x264_tfile_add_inc'><a href="betedit.php"><font color="#FF0000">Wetten Bearbeiten</font></a>&nbsp;|&nbsp;<a href="betoverview.php"><font color="#FF0000">Wett&uuml;bersicht</font></a>&nbsp;|&nbsp;<a href="betclosed.php"><font color="#FF0000">Wetten beenden</font></a></div></div>
<?
}
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Verf&uuml;gbare Wetten</div><div class='x264_tfile_add_inc'>Hier sind die Verf&uuml;gbare Wetten aufgelistet.</div></div>
<?

/////Anfang Verfügbare Wetten/////
$zeit = time()+300;
// $sql = "SELECT * FROM betting_games WHERE time > ".$zeit." AND end = '0' ORDER BY time ASC";
$sql = "SELECT * FROM betting_games WHERE end = '0' ORDER BY time ASC";
$req = mysql_query($sql);
while($row = mysql_fetch_assoc($req))
{
  $sql1 = "SELECT * FROM betting_bet WHERE uid = ".$CURUSER[id]." AND gid= ".$row[gid];
  $req2 = mysql_query($sql1);
  if(mysql_num_rows($req2) < 1)
  {
     $sql2 = "SELECT * FROM betting_bet WHERE gid=".$row[gid];
     $r3   = mysql_query($sql2);

     $datum = getdate($row[time]);
?>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
     <input type="hidden" name="gid" value="<?=$row[gid];?>">
     <input type="hidden" name="tippen" value="ok">
		<div class='x264_title_table'><div class='x264_nologged_inp'>Typ:</div><div class='x264_tfile_add_inc'><?=$row[type]?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Spielbeginn:</div><div class='x264_tfile_add_inc'><?=Tag($datum[weekday]).date(" j.m.Y G:i",$row[time])?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Heim:</div><div class='x264_tfile_add_inc'><?=$row[home];?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>&nbsp;&nbsp;Heim&nbsp;&nbsp;&nbsp;:</div><div class='x264_tfile_add_inc'><input type="radio" name="tip" value="1"><?=$row[quote1]?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>&nbsp;Unent.&nbsp;:</div><div class='x264_tfile_add_inc'><input type="radio" name="tip" value="0"><?=$row[quote0]?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ausw&auml;rts:</div><div class='x264_tfile_add_inc'><input type="radio" name="tip" value="2"><?=$row[quote2]?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ausw&auml;rts:</div><div class='x264_tfile_add_inc'><?=$row[guest];?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Einsatz:</div><div class='x264_tfile_add_inc'><input type="text" name="insert" size="5"><br><input type="submit" value="Wetten"></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>User:</div><div class='x264_tfile_add_inc'><?=mysql_num_rows($r3) ?> User</div></div>		
		<br />	 
   </form>
<?


  }
}
/////Ende Verfügbare Wetten/////

/////Anfang laufende Wetten/////
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Laufende Wetten</div><div class='x264_tfile_add_inc'>Hier sind die Laufende Wetten aufgelistet.</div></div>
<?
$sql="SELECT * FROM betting_bet WHERE uid=".$CURUSER[id];
$req=mysql_Query($sql);
while($r=mysql_fetch_assoc($req))
{
  $sql="SELECT * FROM betting_games WHERE gid=".$r[gid]." AND end=0";
  $req2=mysql_Query($sql);
  while($r2=mysql_fetch_assoc($req2))
  {
    if($r[tip]=="0")
      $tip="U";

    if($r[tip]=="1")
      $tip="H";

    if($r[tip]=="2")
      $tip="A";

    $sql8="SELECT * FROM betting_games WHERE time>".$zeit." AND gid=".$r[gid]." AND end=0 ORDER BY time ASC";
    $req8=mysql_query($sql8);
    while($row8=mysql_fetch_assoc($req8))
    {
      $datum = getdate($r2[time]);

      $sql="SELECT * FROM betting_bet WHERE gid=".$r2[gid];
      $r3=mysql_query($sql);
      $sql="SELECT quote".$r[tip]." FROM betting_games WHERE gid=".$r2[gid];
      $r4=mysql_query($sql);
      $r4=mysql_fetch_assoc($r4);
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Typ:</div><div class='x264_tfile_add_inc'><?=$row8[type]?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Spielbeginn:</div><div class='x264_tfile_add_inc'><?=Tag($datum[weekday]).date(" j.m.Y G:i",$r2[time])?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Heim:</div><div class='x264_tfile_add_inc'><?=$r2[home];?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Tipp:</div><div class='x264_tfile_add_inc'><?=$tip;?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ausw&auml;rts</div><div class='x264_tfile_add_inc'><?=$r2[guest];?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Einsatz:</div><div class='x264_tfile_add_inc'><?=$r[insert];?> GB</div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>M&ouml;gl.Gewinn:</div><div class='x264_tfile_add_inc'><?=($r[insert]*$r4["quote".$r[tip]]) ?> GB</div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>User:</div><div class='x264_tfile_add_inc'><?=mysql_num_rows($r3) ?> User</div></div>		
		<br />
<?
    }
  }
}

/////Ende laufende Wetten/////

/////Anfang beendete Wetten/////
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Beendete Wetten</div><div class='x264_tfile_add_inc'>Hier sind die Beendete Wetten aufgelistet.</div></div>
<?
$sql="SELECT * FROM betting_games WHERE end=1 AND time>".(time()-(60*60*24*7));
$req=mysql_Query($sql);
while($r=mysql_fetch_assoc($req)){
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Typ:</div><div class='x264_tfile_add_inc'><?=$r[type]?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Heim:</div><div class='x264_tfile_add_inc'><?=$r[home];?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ergebnis:</div><div class='x264_tfile_add_inc'><?=$r[p_home].":".$r[p_guest];?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ausw&auml;rts</div><div class='x264_tfile_add_inc'><?=$r[guest];?></div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Gewinner:</div><div class='x264_tfile_add_inc'><?=$r[insert];?> GB</div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>M&ouml;gl.Gewinn:</div><div class='x264_tfile_add_inc'><?=($r[insert]*$r4["quote".$r[tip]]) ?> GB</div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>User:</div><div class='x264_tfile_add_inc'><?=mysql_num_rows($r3) ?> User</div></div>		
<?
if($r[p_home] == $r[p_guest]){
$tipp=0;
}
if($r[p_home] > $r[p_guest]){
$tipp=1;
}
if($r[p_home] < $r[p_guest]){
$tipp=2;
}

$sql="SELECT * FROM betting_bet WHERE gid=".$r[gid]." AND tip=".$tipp;
$wins=mysql_num_rows(mysql_query($sql));
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>User:</div><div class='x264_tfile_add_inc'><?=$wins;?> User</div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Einnahmen:</div><div class='x264_tfile_add_inc'><?=$r[in];?> GB</div></div>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Ausgaben:</div><div class='x264_tfile_add_inc'><?=$r[out];?> GB</div></div>		
		<br />

<?
}
/////Ende beendete Wetten/////
?>
		<div class='x264_title_table'><div class='x264_nologged_inp'>Regeln</div><div class='x264_tfile_add_inc'>Jeder User kann pro Spiel nur einmal Wetten<br><br>Der Mindesteinsatz betr&auml;gt 1GB und das Maximum 100GB<br><br>Der Einsatz wird sofort vom Upload abgezogen<br><br>Letzter m&ouml;glicher Einsatz ist 5 Minuten vor Spielbeginn<br><br>Eine gesetzte Wette kann nicht zur&uuml;ckgezogen werden<br><br>Beendete Wetten werden 1 Woche lang angezeigt<br><br>Wenn ein User gewinnt wird der Einsatz mit der Quote multipliziert und bekommt es sofort gut geschrieben.</div></div>
	</div>
</div>
</div>
<?
x264_footer();
?>