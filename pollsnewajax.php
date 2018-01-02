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

header("Pragma: No-cache");
header("Expires: 300");
header("Cache-Control: private");
header("Content-Type: text/html; charset=iso-8859-1");

if (!$CURUSER)
stderr("Error", "Permission denied.");

if ($CURUSER)
{
$ss_a = @mysql_fetch_assoc(@mysql_query("SELECT `uri` FROM `stylesheets` WHERE `id`=" . $CURUSER["stylesheet"]));
if ($ss_a) $GLOBALS["ss_uri"] = $ss_a["uri"]; 
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="content-language" content="de">

<!--____________STYLESHEET DER USER (FÜR SHOUTBOX) START_______________-->
<link rel="stylesheet" href="<?=$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/"?>x264.php" type="text/css">
<!--____________STYLESHEET DER USER (FÜR SHOUTBOX) ENDE________________-->
</head>
<body>

<?php
function getRandomImageFileName($path)
  {
    $result = "";
    $ar = array();

    $handle=opendir($path);

    while ($file = readdir ($handle))
    {
       if ($file != "." && $file != "..")
       {
          if (! is_dir($file))
          {
            $sub = substr($file, -4);
            if ($sub == ".png" || $sub == ".jpg" || $sub == ".gif" || $sub == ".bmp")
               $ar[] = $file;
          }
       }
    }
    closedir($handle);

    $max = count($ar);

    if ($max > 0)
    {
       srand ((double)microtime()*1000000);
       $max -= 1;
       $p = rand(0,$max);
       $result = $ar[$p];
    }

    return $result;
  }


$pollsettings = mysql_query("SELECT * FROM
pollsnewsettings WHERE setting != ''") or die(mysql_error()); 

while($settingsresult = mysql_fetch_array($pollsettings)){

$pollset[$settingsresult['setting']]=$settingsresult['value'];
}


$poll = mysql_query("
SELECT 
pollsnew.*,
pollsnew.id AS pollid,
pollsnewvotes.*,
pollsnewvotes.userid AS voterid
FROM pollsnew 
LEFT JOIN pollsnewvotes ON pollsnewvotes.userid=".$CURUSER['id']." AND pollsnewvotes.voteid=pollsnew.id
".($pollset['rand'] == 'yes' && !$_GET['voted'] && !$_GET['votethis'] ? "WHERE dauer > '".time()."'" : "").($_GET['voted'] ? "WHERE pollsnew.id=".(0+$_GET['voted']) : "").($_GET['votethis'] ? "WHERE pollsnew.id=".(0+$_GET['votethis']) : "")."
ORDER BY ".($pollset['rand'] == 'yes' && !$_GET['votet'] && !$_GET['votethis'] ? "RAND()" :  "pollsnew.id" )."  DESC limit 1") or die(mysql_error()); 

$Result = mysql_fetch_array($poll);

$BereitsAbgestimmt = "";

$Result['votes'] = (!$Result['votes'] ? 0 : $Result['votes']);


if(time() > $Result['dauer'] || $Result['votes'] >= $Result['maxvotes'] || $_GET['view'] == 'results' || $Result['end'] == 'yes')
{ 


    $BereitsAbgestimmt = "j"; 
} 



if($_POST['voteid'])
{

  $id = 0 + $_POST['voteid'];
  $time = time();
  
  
  $ifvotet = mysql_fetch_array(mysql_query("SELECT userid,votes FROM pollsnewvotes WHERE voteid=$id and userid='".$CURUSER['id']."'"));
  
  
  $BereitsAbgestimmt = $_POST['BereitsAbgestimmt'];
  
  if($_POST['Antwort'] == '0'){
  
  if($ifvotet)
    mysql_query("UPDATE pollsnewvotes SET votes='".$_POST['maxvotes']."', realvotes='".$ifvotet['votes']."' WHERE voteid=$id and userid=".$CURUSER['id']."");
  else
    mysql_query("INSERT INTO pollsnewvotes (abgestimmt, userid, voteid, votes, realvotes) VALUES ('$time', '".$CURUSER['id']."', '$id', '".$_POST['maxvotes']."', '".$ifvotet['votes']."')"); 
            
   header("location: ".$_SERVER['PHP_SELF']."?voted=$id");
   exit;
  }
  else{
    
    
    if($_POST["Antwort"] == '') {
    header("location: ".$_SERVER['PHP_SELF']."?voted=$id");
    exit;
    }
    
    if($BereitsAbgestimmt == 'j'){
    				
    		$SQL = "antworten".$_POST['Antwort']."=antworten".$_POST['Antwort']."+1";
    		
        mysql_query("UPDATE pollsnew SET $SQL WHERE id='".$id."'"); 
            
        if($ifvotet)
          mysql_query("UPDATE pollsnewvotes SET votes=votes+1, realvotes=realvotes+1 WHERE voteid=$id and userid=".$CURUSER['id']."");
        else
          mysql_query("INSERT INTO pollsnewvotes (abgestimmt, userid, voteid, votes, realvotes) VALUES ('$time', '".$CURUSER['id']."', '$id', '1', '1')"); 
            
        header("location: ".$_SERVER['PHP_SELF']."?voted=$id");
        exit;
    }
  }
}

if($Result['pollid']){

echo"<center><b>".$Result['frage']."</b><br><br></center>";
echo"
<table border=0 cellpadding=0 cellspacing=0 width=100% align=center> 
  <tr>"; 

if($BereitsAbgestimmt == 'j' ) 
{ 

  $StimmenInsgesamt=0;
  
    for ($i=1;$i<=$Result['anzantworten'];$i++) {
      if($Result["antwort".$i.""]){
        $StimmenInsgesamt = $StimmenInsgesamt+$Result["antworten$i"];
      }
       
    }
  
  for ($i=1;$i<=$Result['anzantworten'];$i++) {
  			
    if($Result["antwort".$i.""]){ 
    
          if($StimmenInsgesamt != 0) { 
          
            $Prozent = $Result["antworten".$i.""]/$StimmenInsgesamt*100; 
            
          }else{ 
          
            $Prozent = 0; 
            
          } 
  
          $ProzentBalken = sprintf("%.0f", $Prozent*3.5); 
          $Prozent = sprintf("%.0f", $Prozent); 
  
  
  
  if ($Result['balken'] == 'z'){
  
    $fileName = getRandomImageFileName("pic/balken/");
      
echo"
    <tr> 
      <td width='50%'>
        <b>&nbsp;&nbsp;".$Result["antwort".$i.""]."</b>
      </td> 
      <td width='50%'><img height='11' src='pic/balken/".$fileName."' width='5'><img height='11' src='pic/balken/".$fileName."' title='".$Result["antworten".$i.""]." Stimmen' width='$ProzentBalken'><img height='11' src='pic/balken/".$fileName."' width='5'>
      <small>$Prozent%</small>
      </td> 
    </tr>";
  
   }else{
  
echo"
    <tr> 
      <td width='50%' >
        <b>&nbsp;&nbsp;".$Result["antwort".$i.""]."</b>
      </td> 
      <td width='50%'><img height='11' src='pic/balken/".$Result['balken'].".gif' width='5'><img height='11' src='pic/balken/".$Result['balken'].".gif' title='".$Result["antworten".$i.""]." Stimmen' width='$ProzentBalken'><img height='11' src='pic/balken/".$Result['balken'].".gif' width='5'>
      <small>$Prozent%</small>
      </td> 
    </tr>";
   
        }   
    }
    	
  } 
echo"</table>";     
} 
else 
{ 

echo"
<form method='post' action='' name='voting' >
<input name='BereitsAbgestimmt' id='BereitsAbgestimmt' type='hidden' value='j'>
<input type=hidden id='maxvotes' name='maxvotes' value='".$Result['maxvotes']."'>";

for ($i=1;$i<=$Result['anzantworten'];$i++) {

  if($Result["antwort".$i.""]){ 
  
  echo" 
    <tr> 
      <td align='right'>
        <input name='Antwort[]' id='Antwort' type='radio' value='$i' onclick=\"chares('$i');\">
      </td> 
      <td>
        <b>".$Result["antwort".$i.""]."</b>
      </td> 
    </tr>"; 
  
    }
}
echo"
    <input name='res' id='res' type='hidden' value=''>
    <input name='voteid' id='voteid' type='hidden' value='".$Result['pollid']."'> 
    <tr> 
      <td align='right'>
        <input name='Antwort[]' type='radio' value='0' onclick=\"chares('0');\">
      </td> 
      <td>
        Ich will keine Stimme abgeben, ich möchte nur das Ergebnis sehen!
      </td> 
    </tr>
  </table>
    <center><br>
        Du hast ".($Result['votes'] == 0 ? "noch keine Stimme abgegeben" : "beteits ".$Result['votes']." von maximal <b>".$Result['maxvotes']."</b> Stimmen abgegeben")."
      <br>
      <input name='Abstimmen' type='submit' value='Abstimmen' onclick=\"javascript:savevote('".$Result['pollid']."');return false;\">
      
</form>"; 

  
} 



if($BereitsAbgestimmt == 'j'){
  $spacer = "abgegebene Stimmen $StimmenInsgesamt ".($Result['votes'] < $Result['maxvotes'] ? "<br><br><a href=\"javascript:vote('".$Result['pollid']."');\"><b>Voten</b></a>" :"");
}else{
  $spacer = "&nbsp;<br><a href=\"javascript:viewresult('?voted=".$Result['pollid']."&view=results');\"><b>Ergebnisse anzeigen</b></a>";
}
//<br><br><a href=\"javascript:savevote('".$Result['pollid']."');\">fghfghf</a>
echo "<br><center>$spacer</center>";

if( get_user_class() >= UC_MODERATOR)
echo"<br><center><a href=\"addpollnew.php\">Adminstration</a></center>";


}
