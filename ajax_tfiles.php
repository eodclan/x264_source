<?
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
check_access(UC_USER);

$abfrage = "SELECT 
DISTINCT(`torrents`.`id`) AS id,
`torrents`.`name`, `torrents`.`category`,`torrents`.`times_completed`, `torrents`.`size`, `torrents`.`free`, `torrents`.`numpics`,
(SELECT `name` FROM `categories` WHERE `id`=`torrents`.`category`) AS catname,
(SELECT COUNT(`id`) FROM `peers` WHERE `torrent`=`torrents`.`id` AND `seeder` = 'yes') AS seeder,
(SELECT COUNT(`id`) FROM `peers` WHERE `torrent`=`torrents`.`id` AND `seeder` != 'yes') AS leecher
FROM `torrents`
WHERE `torrents`.`numpics` <> '' AND `torrents`.`activated` !='no'
ORDER BY `torrents`.`added` DESC LIMIT 30";
$query = mysql_query($abfrage) or sqlerr(__FILE__,__LINE__);

if(mysql_num_rows($query) == 0 && $CURUSER[xxx] == "no")
{
echo "
            <div>
					<img src='" . $GLOBALS["DESIGN_PATTERN"] . "/nofiles.png'/>
            </div>";
}
else
{
   while($arr = mysql_fetch_assoc($query))
   {
      $tname = str_replace('.', ' ' , $arr['name']);
  
      
echo"

            <div>
                <a href='tfilesinfo.php?id=".$arr['id']."&hit=1'>
					<img data-u='image' src='".$GLOBALS["TORRENT_POSTERS"]."f-".$arr['id']."-1.jpg'/>";
					
					// Only Upload anzeige Anfang
					$sql = "SELECT count(*) FROM torrents WHERE wonly='yes'";
					$res = $db -> querySingleItem($sql);

					if ($res != 0)
					{
echo "
					<span class='text-center' style='position:sticky;top: 0.5px;left: 253px;font-size:12pt;padding: 0.25rem 0.30rem;margin-bottom: 0;color: #FFFFFF;background: rgb(15,15,15);border: 1px solid rgb(35,35,35);-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;opacity:1;'>
						Only Upload!
					</span>	";
}
// Only Upload Anzeige Ende 					
echo "					
					<span class='text-center' style='position:sticky;top: 302.5px;left: 123px;font-size:12pt;padding: 0.25rem 0.30rem;margin-bottom: 0;color: #FFFFFF;background: rgb(15,15,15);border: 1px solid rgb(35,35,35);-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;opacity:1;'>
						".trim_it($tname,44)."
					</span>				
				</a>
                <div data-u='thumb'>
					<img class='i'  src='".$GLOBALS["TORRENT_POSTERS"]."f-".$arr['id']."-1.jpg' />
                    <div class='t'>".trim_it($tname,13)."</div>
                    <div class='c'>Size: ".mksize($arr['size'])." | Seeds: ".$arr['seeder']." Leechs: ".$arr['leecher']."</div>
                </div>
            </div>";
   }
}
?>