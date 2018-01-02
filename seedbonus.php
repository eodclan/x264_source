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

$res99 = mysql_query("SELECT seedbonus FROM users WHERE id=".$CURUSER['id']) or sqlerr(__FILE__, __LINE__);
$arr99 = mysql_fetch_assoc($res99);
$bonus = $arr99['seedbonus'];
  
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  $option = intval($_POST["option"]);
  
  $res = mysql_query("SELECT * FROM bonus WHERE id=".$option);
  $arr = mysql_fetch_assoc($res);

  if($bonus >= $arr['points'])
  {
    if($arr['art'] == "traffic")
    {
      $modcomment = "User hat ".$arr['points']." Punkte gegen Upload eingetauscht.";
      mysql_query("UPDATE users SET uploaded = uploaded + ".$arr['menge'].", seedbonus = seedbonus - ".$arr['points']." WHERE id = ".$CURUSER['id']) or sqlerr(__FILE__, __LINE__);
      write_modcomment($CURUSER['id'], $CURUSER["id"], $modcomment);
      $bonus = $bonus - $arr['points'];
    }
    elseif($arr['art'] == "invite")
    {
      $modcomment = "User hat ".$arr['points']." Punkte gegen Einladungen eingetauscht.";
      mysql_query("UPDATE users SET invites = invites + ".$arr['menge'].", seedbonus = seedbonus - ".$arr['points']." WHERE id = ".$CURUSER['id']) or sqlerr(__FILE__, __LINE__);
      write_modcomment($CURUSER['id'], $CURUSER["id"], "$modcomment");
      $bonus = $bonus - $arr['points'];
    }
    elseif($arr['art'] == "seedbonus")
    {
      $modcomment = "User hat ".$arr['points']." Punkte gegen Seedbonus eingetauscht.";
      mysql_query("UPDATE users SET seedbonus = seedbonus + ".$arr['menge'].", seedbonus = seedbonus + ".$arr['points']." WHERE id = ".$CURUSER['id']) or sqlerr(__FILE__, __LINE__);	  
      write_modcomment($CURUSER['id'], $CURUSER["id"], $modcomment);
      $bonus = $bonus - $arr['points'];	  
    }
    elseif ($arr["art"] == "vip")
    {
      $modcomment = "User hat ".$arr['points']." Punkte gegen VIP eingetauscht.";
      mysql_query("UPDATE users SET seedbonus = seedbonus - ".$arr['menge'].", seedbonus = seedbonus - ".$arr['points'].", class = '5' WHERE id = ".$CURUSER['id']) or sqlerr(__FILE__, __LINE__);
      write_modcomment($CURUSER['id'], $CURUSER["id"], $modcomment);
      $bonus = $bonus - $arr['points'];
    }
    elseif($arr['art'] == "invite")
    {
      $modcomment = "User hat ".$arr['points']." Punkte gegen Einladungen eingetauscht.";
      mysql_query("UPDATE users SET invites = invites + ".$arr['menge'].", seedbonus = seedbonus - ".$arr['points']." WHERE id = ".$CURUSER['id']) or sqlerr(__FILE__, __LINE__);
      write_modcomment($CURUSER['id'], $CURUSER["id"], "$modcomment");
      $bonus = $bonus - $arr['points'];
    }	
    else
    {
      stderr("Fehler","Falscher Typ");
    }
  }
  else
  {
    stderr("Fehler","Nicht genug Punkte");
  }
}

x264_header("Seed Bonus Shop");

$bonus = number_format($bonus, 1, '.', '');

echo "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-usd'></i> Seed Bonus Shop Information
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block text-center'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <tbody>
								<tr>
									<td>Für was bekomm ich Punkte gutgeschrieben?</td>
									<td>Du bekommst für jede Stunde, die du mehr als 10kb/sec seedest, 1,5 Punkt.</td>
									<td>Für jeden Torrent den Du hochlädst erhälst Du 30 Punkte.</td>
									<td>Für jeden Torrent Download den Du komplett herunter geladen hast erhälst Du 2 Punkte.</td>
								</tr>
                        </tbody>
                    </table>									
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>

                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-usd'></i> Seed Bonus Shop | Dein aktueller Stand : ".$bonus."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <tbody>";

$res = mysql_query("SELECT * from bonus order by id") or sqlerr(__FILE__,__LINE__);
while ($arr = mysql_fetch_assoc($res))
{
echo"
		<tr>
			<td>Option:</td><td> ".$arr["id"]."</td>
			<td>Info:</td><td>".$arr["bonusname"]."</b>".$arr["description"]."</td>
			<td>Einsatz:</td><td>".$arr["points"]."</td>
			<td>
				<form method=post action=".$_SERVER['PHP_SELF'].">
				<input type=\"hidden\" name=\"option\" value=\"".$arr["id"]."\">";
              
  if($bonus >= $arr["points"])
  {
echo "
				<input type=submit name=submit value=\"Einwechseln!\" class=\"btn btn-flat btn-primary fc-today-button\">";
  }
  else
  {
echo "
				<input type=submit name=submit value=\"Nicht möglich!\" class=\"btn btn-flat btn-primary fc-today-button\" disabled>";					
  }
echo "
				</form>
			</td>
		</tr>";  

}

echo "
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";		

x264_footer();
?>