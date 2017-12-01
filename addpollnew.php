<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");

dbconn(false);
loggedinorreturn();
x264_bootstrap_header("Umfragen ACP");

check_access(UC_ADMINISTRATOR);
security_tactics();
    
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

header("Content-Type: text/html; charset=iso-8859-1");

if($_POST['UmfrageAnlegen'] == "1"){ 
    
  if ($_POST['Frage'] == ''){
    echo"
    <script language='javascript'>
      alert('Du musst eine Frage eingeben!');
      document.location='".$_SERVER['PHP_SELF']."?edit=add_vote';
    </script>";  
  } 
  $kant="";
  $sql1="";
  $sql2="";
  
  for ($i=1;$i<$_POST['anz']+1;$i++) {
  
    if($_POST["Antwort$i"] == '')
      $kant = "1";
  
    if($sql1)$sql1 .=",";
    if($sql2)$sql2 .=",";
    
    $sql1 .="antwort$i";
    $sql2 .="'".htmlentities(stripslashes(mysql_real_escape_string($_POST["Antwort$i"])))."'";
  
  }
  
  if($kant == "1") {
  
    echo"
    <script language='javascript'>  
      alert('Du musst alle Antwortfelder ausfüllen!');
      document.location='".$_SERVER['PHP_SELF']."?do=add_vote';
    </script>";
            break;
            exit;
            die; 
  }

  $_tag = $_POST['tag'];
  $_monat = $_POST['monat'];
  $_jahr = $_POST['jahr'];
  $date = mktime(date ("H"),date ("i"),date ("s"), date ("m") , date ("d"), date("Y"));
  $_bis = mktime(date ("H"),date ("i"),date ("s"), date ($_monat) , date ($_tag), date($_jahr));
  
  if($_bis < $date){
    
    echo"
  <script language='javascript'>  
    alert('Das Enddatum darf nicht kleiner sein wie das Startdatum!');
    document.location='".$_SERVER['PHP_SELF']."?do=add_vote';
  </script>";
  
  }
  
  if($_POST['icon'] == "")
    $_POST['icon'] = "z";
          
          mysql_query("INSERT INTO pollsnew (frage, erstellt, anzantworten, dauer, balken, $sql1, maxvotes) VALUES ('".htmlentities(stripslashes(mysql_real_escape_string($_POST['Frage'])))."', '$date', '".$_POST['anz']."', '".$_bis."', '".trim($_POST['icon'])."', $sql2, '".$_POST['maxvotes']."' )")or die(mysql_error());
          
  echo"
  <script language='javascript'>  
    alert('Umfrage wurde hinzugefügt!');
    document.location='".$_SERVER['PHP_SELF']."';
  </script>";
      
} 

if (isset($_POST['makepoll']))
{

  if ($_POST['anzahl'] == "")
  {
    echo"
    <script language='javascript'>  
      alert('Es müssen mindestens 2 Anworten gewält werden!');
      document.location='".$_SERVER['PHP_SELF']."?do=add_vote';
    </script>";
  
  }

    echo"
    <center>
      <b>Neue Umfrage erstellen</b> 
    </center>
    <form action='".$_SERVER['PHP_SELF']."?do=add_vote' method='post'> 
    <input name='anz' type='hidden' value='".$_POST['anzahl']."'> 
    <input name='UmfrageAnlegen' type='hidden' value='1' class=form> 
    <table border=0 align=center> 
      <tr> 
        <td>
          Frage
        </td> 
        <td>
          <input name='Frage' size='40' type='text'>
        </td> 
      </tr>";  
  
  for ($i=1;$i<$_POST['anzahl']+1;$i++) {
  		
    echo"
      <tr>
        <td>
          Antwort $i
        </td>
    		<td>
          <input name='Antwort$i' size='30' type='text'>
        </td>
    	</tr>";	
  	
  	}
  
    echo"	
      <tr> 
        <td>
          Aktiv bis
        </td> 
        <td>
          Tag:
          <select name='tag' size='1' class=form>";
  
      $s_tag = 1;
     while($s_tag <= 31) {
        $check = "";
        if($s_tag == date("d")+1) { $check = " SELECTED "; }
           echo "
            <option  value=\"".$s_tag."\"".$check.">".$s_tag."</option>";
           $s_tag++;
    }
  
    echo"
          </select>
          Monat:
          <select name='monat' size='1' class=form>";
   
     $monate = array (1 => "Januar", 2 => "Februar", 3 => "März", 4 => "April", 5 => "Mai", 6 => "Juni", 7 => "July", 8 => "August", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Dezember");
     $i = 1;
     while($i <= 12) {
        $zahl = $i;
        if($i < 10) { $zahl = "0".$i; }
        $check = "";
        if($i == date("m")) { $check = " SELECTED ";  }
          echo "
            <option  value=\"".$zahl."\"".$check.">".$monate[$i]."</option>";
        $i++;
     }
  
    echo"
          </select>
          Jahr:
          <select name='jahr' size='1' class=form>";
  
    $s_jahr =  date("Y");
     while($s_jahr <= date("Y")+2) {
        $check = "";
        if($s_jahr == date("Y")) { $check = " SELECTED "; }
           echo "
            <option  value=\"".$s_jahr."\"".$check.">".$s_jahr."</option>";
           $s_jahr++;
    }
  
    echo"
          </select>
        </td>
      </tr>
      <tr>
        <td>
          Max Anzahl an<br>Votes pro User
        </td>
        <td>
          <select name='maxvotes' size='1'>";
               
    for ($i=1;$i<10;$i++) {
  		
  echo"
            <option value='$i'>$i</option>";
  	
  	}
  	
    echo"
          </select>
        </td>
      </tr>  
      <tr> 
        <td>
          Balken Farbe
        </td>
        <td>";
    
  $verz = opendir ( 'pic/balken' );
  $x=1;
  while ( $file = readdir ( $verz ) ){
  
    if ( $file != '.' && $file != '..' && $file !=  'Thumbs.db') {
    
      if($x==9){echo"<br>";$x=1;}
      
      $file2 = substr($file,0,-4);
      echo "
          <img src='pic/balken/$file' border='0' width='15' height='11'><input type=radio name=icon value='$file2' $checked>";
            
      $x++;
      
    }
  }
  
  closedir ( $verz ); 
  
    echo"
          Zufall<input type=radio name=icon value=z $checked2>
        </td> 
      </tr> 
      <tr> 
        <td align='center' colspan=2>
          <input name='Send' type='submit' value='Umfrage erstellen'>
        </td> 
      </tr> 
    </table> 
    </form>";
    
}else{

    echo"
    <form action='".$_SERVER['PHP_SELF']."?do=add_vote' method='post' name='fragen'> 
    <input name='makepoll' type='hidden' value='Weiter'>
      <table align=center>
        <tr>
          <td>
            <b>Umfrage anlegen</b>
          </td> 
        </tr>
        <tr>
          <td>
            Anzahl der Antworten
          </td>
          <td>
            <select name='anzahl' size='1' onchange=\"this.form.submit();\">
              <option value=''>Antworten</option>";
        
  for ($i=2;$i<=15;$i++) {
  		
    echo"
              <option value='$i'>$i</option>";
  	
  }
  	
    echo"
            </select>
            <input name='submit' type='submit' value='Weiter'>
          </td>
        </tr>
      </table>
    </form>";

  echo"
  <script language='javascript'>
  
  checked = false;
  
  function checkedAll () {
  
    if (checked == false){checked = true}else{checked = false}
    
  	for (var i = 0; i < document.getElementById('msgform').elements.length; i++) {
  	   document.getElementById('msgform').elements[i].checked = checked;
  	}
  }
  </script>
  
  <form action='".$_SERVER['PHP_SELF']."?do=add_vote' method='post' id='msgform'> 
  <input name='UmfrageAnzeigen' type='hidden' value=1> 
    <table style=\"width: 100%;\" class=\"tableinborder\" border=\"0\" cellpadding=\"4\" cellspacing=\"1\">
      <tr>
        <th colspan=7 class=tablecat align=center>
          <b>Umfragen</b>
        </td>
      </tr>
      <tr> 
        <td class=tablecat>
          Umfrage
        </td>
        <td class=tablecat>
          Gestartet am
        </td>
        <td class=tablecat>
          Endet am
        </td>
        <td class=tablecat>
          Aktiv
        </td>
        <td class=tablecat>
          Max Votes pro User
        </td>
        <td class=tablecat>
          Gesamte Votes
        </td>
        <td class=tablecat>
          <input type='checkbox' name='checkall' onclick='checkedAll();'>
        </td>
     </tr>";

  $ResultPointer = mysql_query("SELECT pollsnew.*,(SELECT SUM(realvotes) FROM pollsnewvotes WHERE voteid=pollsnew.id) AS sumreal FROM pollsnew ORDER BY id DESC"); 
  if(mysql_num_rows($ResultPointer) == 0){
  
    echo"
      <tr>
        <td class=tablea colspan=7 align=center>
          <b>Es sind keine Umfragen vorhanden</b>
        </td>
      </tr>";
  
  }
  
  while ( $Result = mysql_fetch_array($ResultPointer)){
  
    $StimmenInsgesamt=0;
    for ($i=1;$i<=$Result['anzantworten'];$i++) {
      if($Result["antwort".$i.""]){
        $StimmenInsgesamt = $StimmenInsgesamt+$Result["antworten$i"];
      }
       
    }
    
    $aktiv == "";
    $erstellt = $Result['erstellt'];
    $dauer = $Result['dauer'];
    $EW=60*60*24*$dauer;
    $ZA=$erstellt+$EW;
    $datea = date("d.m.Y, H:i",$erstellt);
    
    $dateb = date("d.m.Y, H:i",$dauer);
  
    if(time() > $dauer and $Result['end'] == 'yes'){
      $aktiv = "Wurde beendet und Zeit ist abgelaufen";
    }
    elseif(time() < $dauer and $Result['end'] == 'yes'){
      $aktiv = "Wurde beendet und Zeit läuft noch";
    }
    elseif(time() < $dauer && $Result['end'] == 'yes'){
      $aktiv = "Wurde beendet";
    }
    elseif(time() > $dauer && $Result['end'] == 'no'){
      $aktiv = "Zeit ist abgelaufen";
    }
    else{
      $aktiv = "Ja";
    }
        
    echo"
      <tr>
        <td class=tablea>
          <a href='".$_SERVER['PHP_SELF']."?edit=".$Result['id']."'><img src='pic/edit.gif' border=0 alt='ändern' titel='ändern'></a><a href='".$_SERVER['PHP_SELF']."?listvoter=".$Result['id']."' title='wer hat gevotet anzeigen'>".$Result['frage']."</a>
        </td>
        <td class=tablea>
          $datea
        </td>
        <td class=tablea>
          $dateb
        </td>
        <td class=tablea>
          $aktiv
        </td>
        <td class=tablea>
          ".$Result['maxvotes']."
        </td>
        <td class=tablea>
          Real: $StimmenInsgesamt | User: ".($Result['sumreal'] == 0 ? 0 : $Result['sumreal'])."
        </td>
        <td class=tablea>
          <input type='checkbox' name='x[]' value='".$Result['id']."' >
        </td>
      </tr>";
  
   }
    
  echo"
      <tr>
        <td class=tableb align=center colspan=7>
          <center>
          Aktion:
          <select name='do' size=1 onchange='this.form.submit();'>
            <option value='' >Aktion</option>
            <option value='view'>Markierte anzeigen</option>
            ".($CURUSER['class'] >= UC_ADMINISTRATOR ? "<option value='del'>Markierte löschen</option>
            <option value='end'>Umfrage/n beenden</option>
            <option value='start'>Umfrage/n starten</option>
            <option value='back'>Votezähler zurücksetzen</option>" : "" ).($CURUSER['class'] >= UC_SYSOP ? "
            <option value='settings'>Globale Einstellungen</option>" : "")."
          </select>
          <input name='Send' type='submit' value='Und los'>
        </td> 
      </tr> 
    </table> 
    </form>";
}


if(isset($_POST['x'],$_POST['UmfrageAnzeigen']) && $_POST['do'] == "del" ) 
{
  
  echo "Willst du diese Umfrage/n wirklich löschen?"; 
  
  foreach($_POST['x'] as $id){
  
    $id+=0;
    $ResultPointer = mysql_query("SELECT * FROM pollsnew WHERE id='$id'"); 
    $Result = mysql_fetch_array($ResultPointer); 
  
    echo"<br><font color=red>".$Result['frage']."</font>";
  
  }
  
  
  echo "
  <table>
    <tr>
      <td>
        <form name='dely' action='".$_SERVER['PHP_SELF']."' method='post'>";

  foreach($_POST['x'] as $id){
  
    $id+=0;
    echo"
          <input name='id[]' type='hidden' value='$id'>";
  
  }
  
  echo"
          <input name='dely' type='submit' value='Ja'>
        </form>
      </td>
      <td>
        <form name='deln' action='".$_SERVER['PHP_SELF']."' method='post'>
          <input name='UmfrageAnzeigen' type='hidden' value='1'>
          <input name='deln' type='submit' value='Nein'>
        </form>
      </td>
    </tr>
  </table>";
}

if (isset($_POST['dely']))
{
  foreach($_POST['id'] as $id){
  
    $id+=0;
    mysql_query("DELETE FROM pollsnew where id='$id'"); 
    
  }
  
  echo"
    <script language='javascript'>  
      alert('Umfrage wurde gelöscht!');
      document.location='".$_SERVER['PHP_SELF']."';
    </script>";

}

if(isset($_POST['x'],$_POST['UmfrageAnzeigen']) && $_POST['do'] == "view") { 
  
  foreach($_POST['x'] as $id){
            
    $id+=0;      
    
    $ResultPointer = mysql_query("SELECT * FROM pollsnew WHERE id='$id'"); 
    $Result = mysql_fetch_array($ResultPointer);
      
    echo"<center>";
    
    begin_frame("".$Result['frage']."",false, "500");
    
    echo"
      <table border=0 cellpadding=2 cellspacing=0 width='100%' align=center> 
        <tr>";  
        
    $StimmenInsgesamt=0;
    for ($i=0;$i<=$Result['anzantworten'];$i++) {
    
      $StimmenInsgesamt = $StimmenInsgesamt+$Result["antworten$i"]; 
        
    }
    
    $spacer = "abgegebene Stimmen $StimmenInsgesamt";
    
    for ($i=0;$i<$Result['anzantworten']+1;$i++) {
    		   		
      if($Result["antwort".$i.""]) { 
      
        if($StimmenInsgesamt != 0) 
          $Prozent = $Result["antworten".$i.""]/$StimmenInsgesamt*100; 
        else 
          $Prozent = 0; 
             
        $ProzentBalken = sprintf("%.0f", $Prozent*2.5); 
        $Prozent = sprintf("%.0f", $Prozent); 
                
          if ($Result['balken'] == 'z'){
          
            $fileName = getRandomImageFileName("pic/board/balken/");
            
            echo"
              <tr> 
                <td width='50%'>
                  <b>&nbsp;&nbsp;".$Result["antwort".$i.""]."</b>
                </td>
                  <td width='50%'><img height='11' src='pic/balken/".$fileName."' width='5'><img height='11' src='pic/balken/".$fileName."' title='".$Result["antworten".$i.""]." Stimmen' width='$ProzentBalken'><img height='11' src='pic/balken/".$fileName."' width='5'><small>$Prozent%</small>
                </td> 
              </tr>";
              
        }else{
      
            echo"
              <tr> 
                <td width='50%' >
                  <b>&nbsp;&nbsp;".$Result["antwort".$i.""]."</b>
                </td>
                <td width='50%'><img height='11' src='pic/balken/".$Result['balken'].".gif' width='5'><img height='11' src='pic/balken/".$Result['balken'].".gif' title='".$Result["antworten".$i.""]." Stimmen' width='$ProzentBalken'><img height='11' src='pic/balken/".$Result['balken'].".gif' width='5'><small>$Prozent%</small>
                </td>
              </tr>";
       
          } 
      } 
      	
    }    
          
       echo "
        <tr> 
          <td align='center' colspan='2' style='padding-bottom:5px;'>
            $spacer
          </td> 
        </tr>
      </table>";
      
      end_frame();
  }
  
}


if (isset($_POST['Umfrageedit'])){
  
  $_tag = $_POST['tag'];
  $_monat = $_POST['monat'];
  $_jahr = $_POST['jahr'];
  $date = mktime(date ("H"),date ("i"),date ("s"), date ("m") , date ("d"), date("Y"));  
  $bis = $_tag.$_monat.$_jahr;
  $_bis = mktime(date ("H"),date ("i"),date ("s"), date ($_monat) , date ($_tag), date($_jahr));
  
  $sql1="";
  for ($i=1;$i<=$_POST['anz'];$i++) {
  
    if($_POST["Antwort$i"] == '')
      $kant = "1";
    
    if($sql1)$sql1 .=", ";
    $sql1 .="antwort$i='".htmlentities(stripslashes(mysql_real_escape_string($_POST["Antwort$i"])))."'";
  
  }
   
  mysql_query("UPDATE pollsnew  SET frage='".htmlentities(stripslashes(mysql_real_escape_string($_POST['Frage'])))."',erstellt='".$date."',dauer='".$_bis."',balken='".trim($_POST['icon'])."',maxvotes='".$_POST['maxvotes']."', $sql1 WHERE id='".(0+$_POST['id'])."'");
  
  echo"
  <script language='javascript'>  
    alert('Umfrage wurde geändert!');
    document.location='".$_SERVER['PHP_SELF']."';
  </script>"; 
  
}

if (isset($_GET['edit'])){
 
  $ResultPointer = mysql_query("SELECT * FROM pollsnew WHERE id='".(0+$_GET['edit'])."'"); 
  $Result = mysql_fetch_array($ResultPointer);
          
  $datum = $Result['dauer'];
  $tag = date("d",$datum);
  $monat = date("m",$datum);
  $jahr = date("Y",$datum);
  
  echo"
  <form action='".$_SERVER['PHP_SELF']."' method='post'> 
  <input name='anz' type='hidden' value='".$Result['anzantworten']."'> 
  <input name='id' type='hidden' value='".$Result['id']."'>   
  <input name='Umfrageedit' type='hidden' value=1> 
  <table border=0 align=center> 
    <tr>
      <th colspan=3>
        Umfrage bearbeiten
      </th>
    </tr>
    <tr> 
      <td>
        Frage
      </td> 
      <td>
        <input name='Frage' size=40 type='text' value='".$Result['frage']."'>
      </td> 
    </tr>"; 

  for ($i=1;$i<=$Result['anzantworten'];$i++) {
  		
    echo"
    <tr>
      <td>
        Antwort $i
      </td>
      <td>
        <input name='Antwort$i' size='30' type='text' class=form value='".$Result["antwort$i"]."'>
      </td>
    </tr>";	
  	  
  	}
  
  echo"
    <tr> 
      <td>
        Aktiv bis
      </td>
      <td>
        Tag:
        <select name='tag' size='1' class=form>";
  
      $s_tag = 1;
     while($s_tag <= 31) {
        $check = "";
        if($s_tag == $tag) { $check = " SELECTED "; }
           echo "
            <option  value=\"".$s_tag."\"".$check.">".$s_tag."</option>\n";
           $s_tag++;
        }
  
  echo"
        </select>
        Monat:
        <select name='monat' size='1' class=form>";
  
     $monate = array (1 => "Januar", 2 => "Februar", 3 => "März", 4 => "April", 5 => "Mai", 6 => "Juni", 7 => "July", 8 => "August", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Dezember");
     $i = 1;
     while($i <= 12) {
        $zahl = $i;
        if($i < 10) { $zahl = "0".$i; }
        $check = "";
        if($i == $monat) { $check = " SELECTED ";  }
        echo "
          <option  value=\"".$zahl."\"".$check.">".$monate[$i]."</option>\n";
        $i++;
     }
  
  echo"
        </select>
        Jahr:
        <select name='jahr' size='1' class=form>";
  
    $s_jahr =  date("Y");
     while($s_jahr <= date("Y")+2) {
        $check = "";
        if($s_jahr == $jahr) { $check = " SELECTED "; }
           echo "
           <option  value=\"".$s_jahr."\"".$check.">".$s_jahr."</option>\n";
           $s_jahr++;
        }
  
  echo"
        </select>
      </td>
    </tr>
    <tr>
      <td>
        Max Anzahl an<br>Votes pro User
      </td>
      <td>
        <select name='maxvotes' size='1' class='form'>";
                 
    for ($i=1;$i<10;$i++) {
  			
      echo"
          <option value='$i' ".($Result['maxvotes'] == $i ? "selected" : "").">$i</option>\n";
  	
  	}
  	
  	echo"
        </select>
      </td>
    </tr>
    <tr> 
      <td>
        Balken Farbe
      </td>
      <td>";
    
  $verz = opendir ( 'pic/balken' );
  $x=1;
  while ( $file = readdir ( $verz ) ){
  
    if ( $file != '.' && $file != '..' && $file !=  'Thumbs.db'){
    
      if($x==9){echo"<br>";$x=1;}
      
      $file2 = substr($file,0,-4);
      echo "
          <img src='pic/balken/$file' border='0' width='15' height='11'><input type=radio name=icon value='$file2' ".($Result['balken'] == $file2 ? "checked" : "").">";
              
      $x++;
    
    }
  }
  
  closedir ( $verz ); 
  
  echo"
        Zufall<input type=radio name=icon value=z ".($Result['balken'] == "z" ? "checked" : "").">
      </td> 
    </tr>  
    <tr> 
      <td align='center' colspan=2>
        <input name='Send' type='submit' value='Umfrage ändern'>
        </form>
      </td> 
    </tr>
  </table>
  
  <form action='".$_SERVER['PHP_SELF']."?do=updateq' method='post' name='fragen'> 
  <input name='id' type='hidden' value='".$Result['id']."'>
  <input name='oldanz' type='hidden' value='".$Result['anzantworten']."'>
  <table align=center>
    <tr>
      <td>
        Antworten hinzufügen/entfernen
      </td>
      <td>
        <select name='anzahl' size='1' onchange=\"this.form.submit();\">";  
        
    for ($i=2;$i<=15;$i++) {
    		
      echo"
            <option value='$i' ".($Result['anzantworten'] == $i ? "selected" : "").">$i</option>\n";
    	
    }
    	
      echo"
          </select>
          <input name='submit' type='submit' value='Weiter'>
        </td>
      </tr>
    </table>
  </form>"; 
  
}

if($_GET['do'] == 'updateq'){

  mysql_query("UPDATE pollsnew set anzantworten='".(0+$_POST['anzahl'])."' where id='".$_POST['id']."' ")or die(mysql_error());
  
  echo"
  <script language='javascript'>  
    alert('Die Anzahl der Antworten wurde geändert!');
    document.location='".$_SERVER['PHP_SELF']."?edit=".$_POST['id']."';
  </script>"; 

}

if($_GET['listvoter']){
  
  
  $numposts  = mysql_query("SELECT COUNT(id) AS count FROM pollsnewvotes WHERE voteid='".$_GET['listvoter']."' ");  
  
  $ende = 100;
  $url   = '<a href="'.$_SERVER['PHP_SELF'].'?&listvoter='.(0+$_GET['listvoter']); 
  $_start = 0 + $_GET['start'];
   
  $anz = mysql_result($numposts, 0, 'count'); // Anzahl
  $ges = ceil($anz/$ende);
  
  $start  = !isset($_GET['start']) ? $start = 0 : $_GET['start']*$ende;
  $nStart = !isset($_GET['start']) ? $start = 0 : $_GET['start'];
  $link   = '';
  
  if ($anz > 0 )
   {
  if($nStart>=($ges)) {
  	die('Seite existiert nicht!');
  }
  
  if ($anz>$ende*8 and $start!==0)$link .=$url.'&start=0"><b><< Anfang</b></a> ';
  
  $link .= ($nStart==0 ? '' : $url.'&start='.($nStart-1).'"><b>< Zurück</b></a> ');
  if($ges>10) {
  	$ret  = array();
  	
  	for($i=1;$i<=$ges;$i++) {
  		$ret[] = (($i-1)!=$nStart ?  $url.'&start='.($i-1).'">['.$i.']</a> ' : $i.' ');
  	}
  	
  	if($nStart<4 && $nStart>1) {
  		for($j=0;$j<4+$nStart;$j++) {
  			$link .= $ret[$j];
  		}
  	} else {
  		for($j=0;$j<3;$j++) {
  			$link .= $ret[$j];
  		}
  	}
  	$link .= ($nStart<=($ges-5) ? ($nStart>=4 ? ' ... '.$ret[$nStart-1].$ret[$nStart].(isset($ret[$nStart+1]) ? $ret[$nStart+1] : '') : '') : '');
  	$link .= ' ... '.($nStart==$ges-4 ? $ret[$ges-4] : '').$ret[$ges-3].$ret[$ges-2].$ret[$ges-1];
  
  } else {
  	for($i=1;$i<=$ges;$i++) {
  		$link .= (($i-1)!=$nStart ? $url.'&start='.($i-1).'">['.$i.']</a> ' : $i.' ');
  	}
  }
  $link .= ($nStart==($ges-1) ? '' : ' '.$url.'&start='.($nStart+1).'"><b>Weiter ></b></a>');
  
  if ($anz>$ende*8 and $nStart != $ges-1)$link .=$url.'&start='.($ges-1).'"><b>Ende >></b></a>';
  
  
  }
  $_list = 0 + $_GET['list'];
  $_start = 0 + $_GET['start'];
  

  echo"
   ".($anz > $ende ? $link : "")."&nbsp;
  <table style=\"width: 100%;\" class=\"tableinborder\" border=\"0\" cellpadding=\"4\" cellspacing=\"1\">
    <tr>
      <th colspan=3 class=tablecat align=center>
        <b>Wer hat gevotet</b>
      </td>
    </tr>
    <tr> 
      <td class=tablecat>
        User
      </td>
      <td class=tablecat>
        Votes
      </td>
    </tr>";

  $ResultPointer = mysql_query("
  SELECT 
  pollsnewvotes.*,
  (SELECT frage FROM pollsnew WHERE id='".$_GET['listvoter']."') AS frage,
  (SELECT username FROM users WHERE id=pollsnewvotes.userid) AS username,
  (SELECT class FROM users WHERE id=pollsnewvotes.userid) AS class 
  FROM pollsnewvotes WHERE voteid='".$_GET['listvoter']."' ORDER BY username DESC LIMIT $start,$ende"); 
  if(mysql_num_rows($ResultPointer) == 0){
  
  echo"
    <tr>
      <td class=tablea colspan=5 align=center>
        <b>Es hat noch niemand gevotet</b>
      </td>
    </tr>";
  
  }
  while ( $Result = mysql_fetch_array($ResultPointer)){
  
    echo"
    <tr>
      <td class=tablea>
        <a href='userdetails.php?id=".$Result['userid']."'><font class='".get_class_color($Result['class'])."'>".$Result['username']."</font></a>
      </td>
      <td class=tablea>
        ".$Result['realvotes']."
      </td>
    </tr>";
  
  }

  echo"
  </table>
   ".($anz > $ende ? $link : "")."&nbsp;"; 
  
}

if(isset($_POST['x'],$_POST['UmfrageAnzeigen']) && $_POST['do'] == "end" ) 
{
  
  foreach($_POST['x'] as $id){
  
    $id+=0;
    mysql_query("UPDATE pollsnew SET end='yes' WHERE id='$id'"); 
          
  }
  
  echo"
  <script language='javascript'>  
    alert('Die markierten Umfragen wurden beendet!');
    document.location='".$_SERVER['PHP_SELF']."';
  </script>";

}

if(isset($_POST['x'],$_POST['UmfrageAnzeigen']) && $_POST['do'] == "back" ) 
{
  
  foreach($_POST['x'] as $id){
  
    $id+=0;
    mysql_query("UPDATE pollsnewvotes SET votes='0' WHERE voteid='$id'"); 
          
  }
  
  echo"
  <script language='javascript'>  
    alert('Der Votezähler für die User wurde bei den markierten Umfragen zurückgesetzt!');
    document.location='".$_SERVER['PHP_SELF']."';
  </script>";

}

if(isset($_POST['x'],$_POST['UmfrageAnzeigen']) && $_POST['do'] == "start" ) 
{
  
  foreach($_POST['x'] as $id){
  
    $id+=0;
    mysql_query("UPDATE pollsnew SET end='no' WHERE id='$id'"); 
          
  }
  
  echo"
  <script language='javascript'>  
    alert('Markierte Umfragen wurden gestartet, bedenke das du bei eventuel abgelaufenen Umfragen das Enddatum ändern musst damit diese wirklich wieder aktiv werden!');
    document.location='".$_SERVER['PHP_SELF']."';
  </script>";

}

if(isset($_POST['do']) and $_POST['do'] == 'settings'){


  $pollsettings = mysql_query("SELECT * FROM
pollsnewsettings WHERE setting != ''") or die(mysql_error()); 

  while($settingsresult = mysql_fetch_array($pollsettings)){

    $pollset[$settingsresult['setting']]=$settingsresult['value'];

  }
  
  echo"
  <br>
  <form name=settings method=post action=".$_SERVER['PHP_SELF'].">
  <input type=hidden name=savesettings value=1>
  <table style=\"width: 600px;\" class=\"tableinborder\" border=\"0\" cellpadding=\"4\" cellspacing=\"1\">
    <tr>
      <th colspan=2 class=tablecat align=center>
        <b>Globale Einstellungen</b>
      </td>
    </tr>
    <tr>
      <td class=tablea onmouseover=\"javascript:
      document.getElementById('tip').innerHTML = '<table style=\'width: 200px;\' class=tableinborder border=0 cellpadding=4 cellspacing=1><tr><td class=tablecat><center><b>Zufalls Umfrage</b></center></td></tr><tr><td class=tablea>Ist diese Option aktiviert so wird bei jedem laden der Seite eine andere Aktive Umfrage angezeigt</td></tr></table>';
      document.getElementById('tip').style.display = 'block';\" onmouseout=\"javascript:document.getElementById('tip').style.display = 'none';\">
        <b>Zufalls Umfrage</b>
      </td>
      <td class=tableb>
        <input type=checkbox name=rand  value='1' ".($pollset['rand'] == 'yes' ? "checked" : "").">
      </td>
    </tr>
    <tr>
      <td class=tablea onmouseover=\"javascript:
      document.getElementById('tip').innerHTML = '<table style=\'width: 200px;\' class=tableinborder border=0 cellpadding=4 cellspacing=1><tr><td class=tablecat><center><b>Ajax Benutzen</b></center></td></tr><tr><td class=tablea>Ist diese Option aktiviert so wird beim voten die Seite nicht neu geladen</td></tr></table>';
      document.getElementById('tip').style.display = 'block';\" onmouseout=\"javascript:document.getElementById('tip').style.display = 'none';\">
        <b>Ajax Benutzen</b>
      </td>
      <td class=tableb>
        <input type=checkbox name=ajax value='1' ".($pollset['ajax'] == 'yes' ? " checked" : "").">
      </td>
    </tr>
    <tr>
      <td class=tableb colspan=2>
        <center><input type=submit name=save value=speichern></center>
      </td>
    </tr>
  </table>
  <table>
    <tr>
      <td>
        <div id=tip style='display:none;position:absolute;z-index:1;' ></div>
      </td>
    </tr>
  </table>";

} 

if(isset($_POST['savesettings'])){

  $ajax = ($_POST['ajax'] == 1 ? "yes" : "no");
  $rand = ($_POST['rand'] == 1 ? "yes" : "no");
  
  mysql_query("UPDATE pollsnewsettings SET value='".mysql_real_escape_string(trim($ajax))."' WHERE setting='ajax'");
  mysql_query("UPDATE pollsnewsettings SET value='".mysql_real_escape_string(trim($rand))."' WHERE setting='rand'");

  echo"
  <script language='javascript'>  
    alert('Die Einstellungen wurden gespeichert!');
    document.location='".$_SERVER['PHP_SELF']."';
  </script>";

}

x264_bootstrap_footer();
?>
