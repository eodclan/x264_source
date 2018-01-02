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
$act = $_GET["act"];

check_access(UC_BOSS);
security_tactics();

$id    = htmlentities(mysql_real_escape_string($_POST["id"])); 
$name  = htmlentities(mysql_real_escape_string($_POST["name"]));
$type  = htmlentities(mysql_real_escape_string($_POST["type"]));
$haupt = htmlentities(mysql_real_escape_string($_POST["haupt"]));
$image = htmlentities(mysql_real_escape_string($_POST["image"]));
$inid  = htmlentities($_GET["inid"]); 
$gid   = htmlentities($_GET["id"]);
$ac    = htmlentities($_GET["action"]);
$co    = htmlentities($_GET["confirm"]);

x264_admin_header("Kategorie Verwaltung");
     
if ($ac == "edit" && isset($gid)) 
{
  print"
                      <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Update Kategorie
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
  //begin_frame("Update Kategorie"); 
  $res = mysql_query("SELECT * FROM `categories` WHERE `id`='$gid' LIMIT 1");
  while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) 
  { 
    ?>
<form method="post" action="<?=$_SERVER["PHP_SELF"]?>?action=editcat">
  <input type="hidden" name="id" value="<?=$arr["id"]?>"> 
  <table border="1" cellspacing="0" cellpadding="10" align="center">
    <tr><td>Name:</td><td><input style="width: 300px;" type="text" name="name" value="<?=$arr["name"]?>"></td></tr>
    <tr><td>Bild:</td><td><input style="width: 300px;" type="text" name="image" value="<?=$arr["image"]?>"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" name="edit" value="Update" style="width: 60px;"></td></tr>
  </table>
</form> 
    <?php 
  } 
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
  //end_frame("Update Kategorie");
}
if ($ac == "editcat") 
{                           
  mysql_query("UPDATE `categories` SET `name`='$name', `image`='$image' WHERE id='$id'"); 
  header("Refresh: 0; url=".$_SERVER["PHP_SELF"]."");  
}
if ($ac == "addunter" && $inid) 
{
  
  print"
                      <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Neue Kategorie
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";  
  
  //begin_frame("Neue Kategorie"); 
  ?>
<form method="post" action="<?=$_SERVER["PHP_SELF"]?>?action=addnewcat">
  <input type="hidden" name="type" value="2">
  <input type="hidden" name="haupt" value="<?=$inid?>">  
  <table border="1" cellspacing="0" cellpadding="10" align="center">
    <tr><td>Name:</td><td><input style="width: 300px;" type="text" name="name" value=""></td></tr>
    <tr><td>Bild:</td><td><input style="width: 300px;" type="text" name="image" value=""></td></tr>    
    <tr><td colspan="2" align="center"><input type="submit" name="edit" value="Add" style="width: 60px;"></td></tr>
  </table>
</form>
  <?php
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}
if ($ac == "addnewcat") 
{  
  mysql_query("INSERT INTO `categories` (`type`, `name`, `image`, `haupt`) VALUES ('$type', '$name', '$image', '$haupt')"); 
  header("Refresh: 0; url=".$_SERVER["PHP_SELF"].""); 
 
}
if ($ac == "delete" && isset($gid)) 
{ 
  if ($co == "yes") 
  { 
    mysql_query("DELETE FROM `categories` WHERE `id`='$gid' LIMIT 1"); 
    header("Refresh: 0; url=".$_SERVER["PHP_SELF"]."");  
  }
  else 
  {

  print"
                      <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Kategorie L&ouml;schen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	
	
    //begin_frame("Kategorie L&ouml;schen"); 
    ?>
<table border="1" cellspacing="0" cellpadding="5" align="center" width="95%">
  <tr>
    <td align="center">Bitte dr&uuml;cke <a href="<?=$_SERVER["PHP_SELF"]?>?action=delete&amp;id=<?=$gid?>&amp;confirm=yes">hier</a> zum L&ouml;schen.</td>
  </tr>
</table>
    <?php
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
  } 
}
if ($ac == "edith" && isset($gid)) 
{
  print"
                      <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Update Hauptkategorie
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	  
  
  //begin_frame("Update Hauptkategorie"); 
  $res = mysql_query("SELECT * FROM `categories` WHERE `id`='$gid' LIMIT 1");
  while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) 
  { 
    ?>
<form method="post" action="<?=$_SERVER["PHP_SELF"]?>?action=edithcat">
  <input type="hidden" name="id" value="<?=$arr["id"]?>"> 
  <table border="1" cellspacing="0" cellpadding="10" align="center">
    <tr><td>Name:</td><td><input style="width: 300px;" type="text" name="name" value="<?=$arr["name"]?>"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" name="edit" value="Update" style="width: 60px;"></td></tr>
  </table>
</form> 
    <?php 
  } 
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}
if ($ac == "edithcat") 
{                           
  mysql_query("UPDATE `categories` SET `name`='$name' WHERE id='$id'"); 
  header("Refresh: 0; url=".$_SERVER["PHP_SELF"]."");  
}
if ($ac == "addhauptcat") 
{
 
  print"
                      <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Hauptkategorie hinzuf&uuml;gen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";  
  
  //begin_frame("Hauptkategorie hinzuf&uuml;gen"); 
  ?>
<form method="post" action="<?=$_SERVER["PHP_SELF"]?>?action=addnewhcat">
  <input type="hidden" name="type" value="1">
  <input type="hidden" name="haupt" value="0">
  <input type="hidden" name="image" value="">  
  <table border="1" cellspacing="0" cellpadding="10" align="center">
    <tr><td>Name:</td><td><input style="width: 300px;" type="text" name="name" value=""></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" name="edit" value="Add" style="width: 60px;"></td></tr>
  </table>
</form>
  <?php
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}
if ($ac == "addnewhcat") 
{  
  mysql_query("INSERT INTO `categories` (`type`, `name`, `image`, `haupt`) VALUES ('$type', '$name', '$image', '$haupt')"); 
  header("Refresh: 0; url=".$_SERVER["PHP_SELF"].""); 
}

  print"
                      <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Kategorie Verwaltung
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
//begin_frame("Kategorie Verwaltung");
$res = mysql_query("SELECT * FROM categories where type = 1") OR sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res)) 
{
  $newcats .= ' <table  style="width:100%;text-align:center;" summary="none" border="0" cellspacing="1" cellpadding="5" class="tableinborder">';
  $newcats .= '   <tr>';
  $newcats .= '     <td class="tabletitle" colspan="4">' . $arr["name"] . ' <a href="' . $_SERVER["PHP_SELF"] . '?action=edith&amp;id=' . $arr["id"] . '">Bearbeiten</a> <a href="' . $_SERVER["PHP_SELF"] . '?action=delete&amp;id=' . $arr["id"] . '">L&ouml;schen</a> <a href="' . $_SERVER["PHP_SELF"] . '?action=addunter&amp;inid=' . $arr["id"] . '">Neue Kategorie</a></td>';
  $newcats .= '   </tr>';
  $newcats .= '   <tr>';
  $newcats .= '     <td class="tablea" width="25%">Image</td>';  
  $newcats .= '     <td class="tablea" width="25%">Name:</td>';
  $newcats .= '     <td class="tablea" width="25%">Hauptcat:</td>';
  $newcats .= '     <td class="tablea" width="25%">Aktion:</td>';
  $newcats .= '    </tr>'; 
  $resa = mysql_query("SELECT * FROM categories where haupt = " . $arr["id"] . "") OR sqlerr(__FILE__, __LINE__);
  while ($arra = mysql_fetch_assoc($resa)) 
  {
    $newcats .= '   <tr>';
    $newcats .= '     <td class="tablea" width="25%"><img src="' . $GLOBALS["ADMIN_BOOTSTRAP_PATTERN"] . ''. $GLOBALS["ss_uri"].'/'. $GLOBALS["CATEGORY_PATTERN"].'' . $arra["image"] . '" alt="' . $arra["image"] . '" title="' . $arra["name"] . '_Kategoriebild">&nbsp;' . $arra["image"] . '</td>';    
    $newcats .= '     <td class="tablea" width="25%">' . $arra["name"] . '</td>';
    $newcats .= '     <td class="tablea" width="25%">' . $arra["haupt"] . '</td>';
    $newcats .= '     <td class="tablea" width="25%"><a href="' . $_SERVER["PHP_SELF"] . '?action=edit&amp;id=' . $arra["id"] . '">Bearbeiten</a> <a href="' . $_SERVER["PHP_SELF"] . '?action=delete&amp;id=' . $arra["id"] . '">L&ouml;schen</a></td>';
    $newcats .= '    </tr>'; 
  }
  $newcats .= "   </table>\n";  
  $newcats .= "   <br />\n";
}
$newcats .= ' <table  style="width:100%;text-align:center;" summary="none" border="0" cellspacing="1" cellpadding="5" class="tableinborder">';
$newcats .= '   <tr>';
$newcats .= '     <td class="tablea"><p align="center"><a href="' . $_SERVER["PHP_SELF"] . '?action=addhauptcat">Neue Haupt-Kategorie Erstellen</a></p></td>';
$newcats .= '   </tr>';
$newcats .= ' </table>';  
print ($newcats);
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
x264_admin_footer();
?>