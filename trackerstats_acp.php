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
dbconn();
loggedinorreturn();
check_access(UC_TEAMLEITUNG);
security_tactics();

x264_admin_header('Interne Statistik');
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Tracker Stats ACP
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>
		<?	
		$torrents 	= number_format(get_row_count("torrents"));
		$aktive 	= number_format(get_row_count("torrents", "WHERE visible = 'yes'"));
		$inaktive 	= number_format(get_row_count("torrents", "WHERE visible = 'no'"));
		$naktive 	= number_format(get_row_count("torrents", "WHERE activated = 'no'"));

		$peers 		= number_format(get_row_count("peers"));
		$seeder 	= get_row_count("peers", "WHERE seeder = 'yes'");
		$leecher 	= get_row_count("peers", "WHERE seeder = 'no'");
		if($leecher != 0){$pratio = number_format(($seeder / $leecher) * 100,0);}else{$pratio = number_format($seeder * 100);}

		$traffic 	= mysql_ein_datensatz("SELECT SUM(downloaded) AS totaldl, SUM(uploaded) AS totalul FROM users");
		$totalup 	= $traffic['totalul'];
		$totaldl 	= $traffic['totaldl'];
		$totalg 	= $totalup + $totaldl;
		$totalr 	= $totalup / $totaldl;
		$req_all 	= get_row_count("requests");
		$req_erf 	= get_row_count("requests", "WHERE closedate != '0'");
		$req_ratio	= $req_erf/($req_all/100);
		
		$ist_jahr = date("Y", time());
		$ist_month = date("n", time());
		$ist_day = date("j", time());
		$heute = mktime(0, 0, 0, $ist_month, $ist_day, $ist_jahr);
		$gestern = mktime(0, 0, 0, $ist_month, ($ist_day-1), $ist_jahr);

		$heute_up 	= get_row_count("torrents", "WHERE UNIX_TIMESTAMP(added) > ".$heute." ");
		$geste_up 	= get_row_count("torrents", "WHERE UNIX_TIMESTAMP(added) >= ".$gestern." AND UNIX_TIMESTAMP(added) <= ".$heute." ");
		?>
		<h2>Torrents</h2>
		<div class="show_stats_value"><label>Gesamt:</label><div class="show_stats_erg"><?=$torrents;?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Aktive:</label><div class="show_stats_erg"><?=$aktive;?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Inaktive:</label><div class="show_stats_erg"><?=$inaktive;?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Noch nicht Aktivierte:</label><div class="show_stats_erg"><?=$naktive;?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Erfüllte Request´s:</label><div class="show_stats_erg"><?=$req_erf." von ".$req_all." erfüllt. (".round($req_ratio, 2)."%)";?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Uploads Gestern:</label><div class="show_stats_erg"><?=$geste_up;?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Uploads Heute:</label><div class="show_stats_erg"><?=$heute_up;?></div><br class="clear" /></div>
		<br />
		<h2>Peers</h2>
		<div class="show_stats_value"><label>Gesamt:</label><div class="show_stats_erg"><?=$peers;?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Seeders:</label><div class="show_stats_erg"><?=$seeder;?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Leechers:</label><div class="show_stats_erg"><?=$leecher;?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Seeder/Leecher Ratio (%):</label><div class="show_stats_erg"><?=$pratio;?></div><br class="clear" /></div>
		<br />
		<h2>Traffic</h2>
		<div class="show_stats_value"><label>Gesamt:</label><div class="show_stats_erg"><?=mksize($totalg);?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Gesamt Download:</label><div class="show_stats_erg"><?=mksize($totaldl);?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Gesamt Upload:</label><div class="show_stats_erg"><?=mksize($totalup);?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Total Ratio:</label><div class="show_stats_erg"><?=number_format(($totalr),3);?></div><br class="clear" /></div>
		<?
		$registered = number_format(get_row_count("users"));
		$unverified = number_format(get_row_count("users", "WHERE status = 'pending' "));
		
		?>
		<h2>Benutzer</h2>
		<div class="show_stats_value"><label>Gesamt registriert:</label><div class="show_stats_erg"><?=$registered;?></div><br class="clear" /></div>
		<div class="show_stats_value"><label>Unbestätigt:</label><div class="show_stats_erg"><?=$unverified;?></div><br class="clear" /></div>
		<br />
		<h2>Monatliche Benutzerregistrierungen</h2>
		<?$res = mysql_query('SELECT RPAD(added, 7, "") AS dates, COUNT(RPAD(added, 7, "")) AS counts FROM users GROUP BY dates ORDER BY dates DESC');
		while($data = mysql_fetch_object($res)){?>
		<div class="show_stats_value"><label><?=$data -> dates;?></label><div class="show_stats_erg"><? echo "<b style='float:left;width:50px;'>".$data -> counts."</b> (".number_format(($data -> counts / 30),1);?> am tag)</div><br class="clear" /></div>
		<?}?>
		<br />
		<h2>Benutzer-Klassen</h2>
		<?$query = "SELECT name, color, class FROM userclass ORDER BY class DESC";
		$result = mysql_query($query);
		$i=1;
		while($data = mysql_fetch_object($result)){
		if($i != 1){
		$count_class = mysql_ein_datenfeld("SELECT COUNT(*) FROM users WHERE class = '".$data -> class."' ");?>
		<div class="show_stats_value">
			<label style="color:#<?=$data -> color;?>;"><?=$data -> name;?>:</label>
			<div class="show_stats_erg"><?=$count_class;?></div>
			<br class="clear" />
		</div>		
		<?}$i++;}
		$swi_sec = $_POST['sec']+0;
		switch($swi_sec){
			case "5":	$timelie = '5 Minuten'; $secundelie = 300;break;
			case "15":	$timelie = '15 Minuten'; $secundelie = 900;break;
			case "30":	$timelie = '30 Minuten'; $secundelie = 1800;break;
			case "60":	$timelie = '60 Minuten'; $secundelie = 3600;break;
			case "2":	$timelie = '2 Stunden'; $secundelie = 7200;break;
			case "24":	$timelie = '24 Stunden'; $secundelie = 86400;break;

			default:	$timelie = '60 Minuten'; $secundelie = 3600;
		}
		
		$dt = time() - $secundelie;
		$user_count = mysql_ein_datenfeld("SELECT COUNT(*) FROM users LEFT JOIN users ON users.id = users.id WHERE UNIX_TIMESTAMP(last_access) >= ".$dt." ");
		$res = mysql_query("SELECT users.id, users.username, users.class AS ucl, users.webseed
		FROM users 
		LEFT JOIN users ON users.id = users.id 
		WHERE UNIX_TIMESTAMP(last_access) >= ".$dt." 
		ORDER BY users.class DESC, users.username ASC");
		$i=1;
		$newest = mysql_ein_datensatz("SELECT id, username, class FROM users WHERE status = 'confirmed' ORDER BY id DESC LIMIT 1");
		$highest = mysql_ein_datenfeld("SELECT class FROM userclass ORDER BY class DESC LIMIT 1 ");
		?>
		<br />
		<h2>Unser neustes Mitglied: <a href="userdetails.php?id=<?=$newest['id'];?>" style="<?=get_class_color($newest['class']);?>"><?=$newest['username'];?></a></h2>
		<div id="show_stats_alluser">
			Die Tracker Stats sind für das Team gedacht und nicht für dritte Personen.
		</div>		
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>	
<?
x264_admin_footer();
?>