<?php
// ************************************************************************************//
// * X264 Source
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 4.0
// * 
// * Copyright (c) 2015 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//

$res = mysql_query("SELECT `id`, `name`, `url`, `class` FROM `menu` WHERE `type`='haupt' ORDER BY `order` ASC");
while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) 
{
  $menu_haupt[$arr["id"]]["title"]  = $arr["name"];
  $menu_haupt[$arr["id"]]["url"]    = $arr["url"];
  $menu_haupt[$arr["id"]]["class"]  = $arr["class"]; 
}
$res = mysql_query("SELECT `id`, `name`, `url`, `class`, `haupt` FROM `menu` WHERE `type`='unter' ORDER BY `order` ASC");
while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) 
{
  $menu_haupt[$arr["haupt"]]["items"][$arr["id"]]["name"]   = $arr["name"];
  $menu_haupt[$arr["haupt"]]["items"][$arr["id"]]["url"]    = $arr["url"];
  $menu_haupt[$arr["haupt"]]["items"][$arr["id"]]["class"]  = $arr["class"]; 
}
if (isset($menu_haupt)) 
{ 
  foreach ($menu_haupt as $id => $temp) 
  {
    if  (!array_key_exists("title", $menu_haupt[$id])) 
    { 
      foreach ($menu_haupt[$id]["items"] as $id2 => $temp) 
      {
        $menu_orphaned[$id2]["name"]  = $menu_haupt[$id]["items"][$id2]["name"];
        $menu_orphaned[$id2]["url"]   = $menu_haupt[$id]["items"][$id2]["url"];
        $menu_orphaned[$id2]["class"] = $menu_haupt[$id]["items"][$id2]["class"]; 
        unset($menu_haupt[$id]); 
      } 
    } 
  } 
  foreach ($menu_haupt as $id => $temp) 
  { 
    if ($CURUSER["class"] >= $menu_haupt[$id]["class"]) 
    { 
      ?>
	<div class='x264_lnavi'>  
		<h1 class='x264_im_logo'><?=$menu_haupt[$id]["title"]?></h1> 
      <?php 
      if (array_key_exists("items", $menu_haupt[$id])) 
      { 
        foreach ($menu_haupt[$id]["items"] as $id2 => $temp) 
        { 
          if ($CURUSER["class"] >= $menu_haupt[$id]["items"][$id2]["class"]) 
          { 
            ?>              
	<div class='x264_title_table'>
		<div class='x264_title'><a href='<?=$menu_haupt[$id]["items"][$id2]["url"]?>'><?=$menu_haupt[$id]["items"][$id2]["name"]?></a></div>
	</div>   
            <?php 
          } 
        } 
      }
     ?>
	</div>
     <?  
    } 
  } 
}

include("ajax_radio.php");
?>


	<div class='x264_lnavi'>  
		<h1 class='x264_im_logo'>Teamspeak</h1>
	<div class='x264_title_table'>
		<div class='x264_title'>
			<object data='tsstatus/tsstatus_test.php' type='text/html' width='140px' height='311px' scrolling='no'></object>
		</div>
		<div class='x264_title'>PW: PowerTS</div>
	</div>
	</div> 