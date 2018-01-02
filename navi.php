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

check_access(UC_DEV);
security_tactics();
x264_admin_header("Menu Management");

$act = htmlentities($_GET["act"]);

$ha    = htmlentities(mysql_real_escape_string($_POST["haupt"]));
$cl    = htmlentities(mysql_real_escape_string($_POST["class"]));
$ur    = htmlentities(mysql_real_escape_string($_POST["url"]));
$na    = htmlentities(mysql_real_escape_string($_POST["name"]));
$ti    = htmlentities(mysql_real_escape_string($_POST["title"]));
$ic    = htmlentities(mysql_real_escape_string($_POST["icon"])); 
$id    = htmlentities(mysql_real_escape_string($_POST["id"])); 
$or    = intval(mysql_real_escape_string($_POST["order"])); 
$ac    = htmlentities($_GET["action"]);
$gid   = htmlentities($_GET["id"]);  
$inid  = htmlentities($_GET["inid"]); 
$co    = htmlentities($_GET["confirm"]);
$sichtbarkeit .= "
                      <tr><td>Sichtbarkeit:</td><td>
                        <select name=\"class\" style=\"width: 110px;\">";  
$sql = "SELECT * FROM userclass WHERE style = 1 ORDER BY id ASC";
$res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
while ($brr = mysql_fetch_array($res))
{
  $sichtbarkeit .= "
                          <option value=\"".$brr["class"]."\"   " . ($brr["class"] == $arr["class"]   ? " checked" : "") . ">".$brr["classname"]."</option>";
}
$sichtbarkeit .= "
                        </select></td></tr>";
if ($ac == "reorder") 
{ 
  foreach($or as $id => $position) mysql_query("UPDATE `menu` SET `order`='$position' WHERE id='$id'"); header("Refresh: 0; url=".$_SERVER["PHP_SELF"].""); 
}
if ($ac == "edit" && isset($gid)) 
{ 
print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Menu Punkt Bearbeiten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>";  
  $res = mysql_query("SELECT * FROM `menu` WHERE `id`='$gid' LIMIT 1");
  while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) 
  { 
    $arr["name"] = $arr["name"]; $arr["icon"] = $arr["icon"]; $arr["url"] = $arr["url"];
    if ($arr["type"] == "unter") 
    { 
      ?>
<!-- action=editunter !!BEGINNT!! -->        
                  <form method="post" action="<?=$_SERVER["PHP_SELF"]?>?action=editunter">
                    <table border="1" cellspacing="0" cellpadding="10" align="center">
                      <tr><td>ID:</td><td><?=$arr["id"]?> <input type="hidden" name="id" value="<?=$arr["id"]?>" /></td></tr>
                      <tr><td>Name:</td><td><input style="width: 300px;" type="text" name="name" value="<?=$arr["name"]?>" /></td></tr>
                      <tr><td>Icon:</td><td><input style="width: 300px;" type="text" name="icon" value="<?=$arr["icon"]?>" /></td></tr>						  
                      <tr><td>URL:</td><td><input style="width: 300px;" type="text" name="url" value="<?=$arr["url"]?>" /></td></tr>				  
                      <?=$sichtbarkeit?> 
                      <tr><td>Kategorie:</td>
                        <td>
                          <select style="width: 300px;" name="haupt">
      <?php 
      $res2 = mysql_query("SELECT `id`, `name`, `icon` FROM `menu` WHERE `type`='haupt' ORDER BY `order` ASC"); 
      while ($arr2 = mysql_fetch_array($res2, MYSQL_BOTH)) 
      { 
        $selected = ($arr2["id"] == $arr["haupt"]) ? " selected=\"selected\"" : ""; 
        ?>
                            <option value="<?=$arr2["id"]?>" <?=$selected?>><?=$arr2["name"]?><?=$arr2["icon"]?></option>
        <?php 
      } 
      ?>
                          </select>
                        </td>
                      </tr>
                      <tr><td colspan="2" align="center"><input type="submit" name="edit" value="Edit" style="width: 60px;"></td></tr>
                    </table>
                  </form>
<!-- action=editunter !!ENDET!! -->
      <?php 
    } 
    if ($arr["type"] == "haupt") 
    { 
    ?>
<!-- action=editsect !!BEGINNT!! -->        
                  <form method="post" action="<?=$_SERVER["PHP_SELF"]?>?action=editsect">
                    <table border="1" cellspacing="0" cellpadding="10" align="center">
                      <tr><td>ID:</td><td><?=$arr["id"]?> <input type="hidden" name="id" value="<?=$arr["id"]?>" /></td></tr>
                      <tr><td>Title:</td><td><input style="width: 300px;" type="text" name="title" value="<?=$arr["name"]?>" /></td></tr>
                      <tr><td>Icon:</td><td><input style="width: 300px;" type="text" name="icon" value="<?=$arr["icon"]?>" /></td></tr>					  
                      <tr><td>URL:</td><td><input style="width: 300px;" type="text" name="url" value="<?=$arr["url"]?>" /></td></tr>					  
                      <?=$sichtbarkeit?>   
                      <tr><td colspan="2" align="center"><input type="submit" name="edit" value="Edit" style="width: 60px;"></td></tr>
                    </table>
                  </form>
<!-- action=editsect !!ENDET!! -->
    <?php 
    } 
  }
print"
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>"; 
}
if ($ac == "editunter" && $id != NULL && $na != NULL && $ic != NULL  && $ur != NULL && $cl != NULL && $ha != NULL) 
{   
  mysql_query("UPDATE `menu` SET `name`='$na', `icon`='$ic', `url`='$ur', `class`='$cl', `haupt`='$ha' WHERE id='$id'"); 
  header("Refresh: 0; url=".$_SERVER["PHP_SELF"].""); 
}
if ($ac == "editsect"  && $id != NULL && $ti != NULL && $ur != NULL && $ic != NULL && $cl != NULL) 
{   
  mysql_query("UPDATE `menu` SET `name`='$ti', `icon`='$ic', `url`='$ur', `class`='$cl',`haupt`='0' WHERE id='$id'"); 
  header("Refresh: 0; url=".$_SERVER["PHP_SELF"].""); 
}
if ($ac == "delete" && isset($gid)) 
{ 
  if ($co == "yes") 
  { 
    mysql_query("DELETE FROM `menu` WHERE `id`='$gid' LIMIT 1"); 
    header("Refresh: 0; url=".$_SERVER["PHP_SELF"]."");  
  }
  else 
  {
print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Punkt L&ouml;schen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>";	
    ?>
                  <table border="1" cellspacing="0" cellpadding="5" align="center" width="95%">
                    <tr><td align="center">Bitte dr&uuml;cke <a href="<?=$_SERVER["PHP_SELF"]?>?action=delete&amp;id=<?=$gid?>&amp;confirm=yes">hier</a> zum L&ouml;schen.</td></tr>
                  </table>
    <?php
print"
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
  } 
}
if ($ac == "addunter" && $inid) 
{
print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Punkt Hinzuf&uuml;gen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>";  
  ?>
                  <form method="post" action="<?=$_SERVER["PHP_SELF"]?>?action=addnewunter">
                    <table border="1" cellspacing="0" cellpadding="10" align="center">
                      <tr><td>Titel:</td><td><input style="width: 300px;" type="text" name="name" value=""></td></tr>
                      <tr><td>URL:</td><td><input style="width: 300px;" type="text" name="url" value="" /></td></tr>
                      <tr><td>Icon:</td><td><input style="width: 300px;" type="text" name="icon" value="" /></td></tr>					  
                      <?=$sichtbarkeit?> 
                      <tr><td>Abteil:</td><td><select style="width: 300px;" name="haupt">
  <?php 
  $res = mysql_query("SELECT `id`, `name`, `icon` FROM `menu` WHERE `type`='haupt' ORDER BY `order` ASC");
  while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) 
  { 
    $selected = ($arr["id"] == $inid) ? " selected=\"selected\"" : ""; 
    ?>
                      <option value="<?=$arr["id"]?>" <?=$selected?>><?=$arr["name"]?><?=$arr["icon"]?></option>
    <?php 
  } 
  ?>                    </select></td></tr>
                      <tr><td colspan="2" align="center"><input type="submit" name="edit" value="Add" style="width: 60px;"></td></tr>
                    </table>
                  </form>
  <?php
print"
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}
if ($ac == "addsection") 
{
print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Menupunkt hinzuf&uuml;gen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>";   
  ?>
                  <form method="post" action="<?=$_SERVER["PHP_SELF"]?>?action=addnewsect">
                    <table border="1" cellspacing="0" cellpadding="10" align="center">
                      <tr><td>Title:</td><td><input style="width: 300px;" type="text" name="title" value=""></td></tr>
                      <tr><td>URL:</td><td><input style="width: 300px;" type="text" name="url" value="<?=$arr["url"]?>" /></td></tr>
                      <tr><td>Icon:</td><td><input style="width: 300px;" type="text" name="icon" value="" /></td></tr>					  
                      <?=$sichtbarkeit?> 
                      <tr><td colspan="2" align="center"><input type="submit" name="edit" value="Add" style="width: 60px;"></td></tr>
                    </table>
                  </form>
  <?php
print"
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}
if ($ac == "addnewunter" && $na != NULL && $ic != NULL && $ur != NULL && $cl != NULL && $ha != NULL) 
{ 
  $res = mysql_query("SELECT MAX(`order`) FROM `menu` WHERE `type`='unter' AND `haupt`='$ha'"); 
  while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) 
  $order = $arr[0] + 1; 
  mysql_query("INSERT INTO `menu` (`type`, `name`, `icon`, `url`, `class`, `haupt`, `order`) VALUES ('unter', '$na', '$ic', '$ur', '$cl', '$ha', '$order')"); 
  header("Refresh: 0; url=".$_SERVER["PHP_SELF"]."");  
}
if ($ac == "addnewsect" && $ti != NULL && $ur != NULL && $cl != NULL) 
{   
  $res = mysql_query("SELECT MAX(`order`) FROM `menu` WHERE `type`='haupt'"); 
  while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) 
  $order = $arr[0] + 1; 
  mysql_query("INSERT INTO `menu` (`type`, `name`, `icon`, `url`, `class`, `haupt`, `order`) VALUES ('haupt', '$ti',, '$ic' '$ur', '$cl', '0', '$order')"); 
  header("Refresh: 0; url=".$_SERVER["PHP_SELF"].""); 
}

print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Menu Management
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>";
$res = mysql_query("SELECT `id`, `name`, 'icon', `class`, `order` FROM `menu` WHERE `type`='haupt' ORDER BY `order` ASC"); 
while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) 
{ 
  $menu_haupt[$arr["id"]]["title"] = $arr["name"]; 
  $menu_haupt[$arr["id"]]["icon"] = $arr["icon"];  
  $menu_haupt[$arr["id"]]["class"] = $arr["class"];  
  $menu_haupt[$arr["id"]]["order"] = $arr["order"]; 
}
$res = mysql_query("SELECT `id`, `name`, 'icon', `class`, `haupt`, `order` FROM `menu` WHERE `type`='unter' ORDER BY `order` ASC"); 
while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) 
{ 
  $menu_haupt[$arr["haupt"]]["items"][$arr["id"]]["name"] = $arr["name"];
  $menu_haupt[$arr["haupt"]]["items"][$arr["id"]]["icon"] = $arr["icon"];  
  $menu_haupt[$arr["haupt"]]["items"][$arr["id"]]["class"] = $arr["class"];   
  $menu_haupt[$arr["haupt"]]["items"][$arr["id"]]["order"] = $arr["order"]; 
}
if (isset($menu_haupt)) 
{ 
  foreach ($menu_haupt as $id => $temp) 
  { 
    if (!array_key_exists("title", $menu_haupt[$id])) 
    { 
      foreach ($menu_haupt[$id]["items"] as $id2 => $temp) 
      { 
        $menu_orphaned[$id2]["name"] = $menu_haupt[$id]["items"][$id2]["name"];
        $menu_orphaned[$id2]["icon"] = $menu_haupt[$id]["items"][$id2]["icon"];		
        $menu_orphaned[$id2]["class"] = $menu_haupt[$id]["items"][$id2]["class"]; 
        unset($menu_haupt[$id]); 
      } 
    } 
  } 
  ?>
                <form method="post" action="<?=$_SERVER["PHP_SELF"]?>?action=reorder">
  <?php 
  foreach ($menu_haupt as $id => $temp) 
  { 
    ?>
                  <br />
                  <table border="1" cellspacing="0" cellpadding="5" align="center" width="95%">
                    <tr>
                      <td class="colhead" align="center" colspan="2">Position</td>
                      <td class="colhead" align="left">Menu-Punkte:</td>
                      <td class="colhead" align="left">Icon:</td>					  
                      <td class="colhead" align="center">Sichtbarkeit</td>
                      <td class="colhead" align="center">Aktionen</td>
                    </tr>
                    <tr>
                      <td align="center" width="40">
                        <select name="order[<?=$id?>]\">       
    <?php 
    for ($n=1; $n <= count($menu_haupt); $n++) 
    { 
      $sel = ($n == $menu_haupt[$id]["order"]) ? " selected=\"selected\"" : ""; 
      ?>   
                          <option value="<?=$n?>" <?=$sel?>><?=$n?></option>         
      <?php 
    } 
    ?>
                        </select>    
                      </td>
                      <td align="center" width="40">&nbsp;</td>
                      <td><b><?=$menu_haupt[$id]["title"]?></b></td>
                      <td align="center" width="60"><?=$menu_haupt[$id]["icon"]?></td>					  
                      <td align="center" width="60"><font color="<?=get_class_color($menu_haupt[$id]["class"])?>"><?=get_user_class_name($menu_haupt[$id]["class"])?></font></td>
                      <td align="center" width="60">
                        <a href="<?=$_SERVER["PHP_SELF"]?>?action=edit&amp;id=<?=$id?>">Bearbeiten</a> 
                        <a href="<?=$_SERVER["PHP_SELF"]?>?action=delete&amp;id=<?=$id?>">L&ouml;schen</a>
                      </td>
                    </tr>
    <?php  
    if (array_key_exists("items", $menu_haupt[$id])) 
    { 
      foreach ($menu_haupt[$id]["items"] as $id2 => $temp) 
      { 
        ?>
                    <tr>
                      <td align="center" width="40">&nbsp;</td>
                      <td align="center" width="40">
                        <select name="order[<?=$id2?>]">
        <?php 
        for ($n=1; $n <= count($menu_haupt[$id]["items"]); $n++) 
        { 
          $sel = ($n == $menu_haupt[$id]["items"][$id2]["order"]) ? " selected=\"selected\"" : ""; 
          ?>           
                          <option value="<?=$n?>" <?=$sel?>><?=$n?></option>
          <?php 
        } 
        ?>
                        </select>
                      </td>
                      <td><?=$menu_haupt[$id]["items"][$id2]["name"]?></td>
                      <td align="center" width="60"><?=$menu_haupt[$id]["items"][$id2]["icon"]?></td>					  
                      <td align="center" width="60"><font color="<?=get_class_color($menu_haupt[$id]["items"][$id2]["class"])?>"><?=get_user_class_name($menu_haupt[$id]["items"][$id2]["class"])?></font></td>
                      <td align="center" width="60">
                        <a href="<?=$_SERVER["PHP_SELF"]?>?action=edit&amp;id=<?=$id2?>">Bearbeiten</a> 
                        <a href="<?=$_SERVER["PHP_SELF"]?>?action=delete&amp;id=<?=$id2?>">L&ouml;schen</a>
                      </td>
                    </tr>    
        <?php 
      } 
    } 
    ?>
                    <tr><td colspan="5" align="center"><a href="<?=$_SERVER["PHP_SELF"]?>?action=addunter&amp;inid=<?=$id?>">Neuen punkt Hinzuf&uuml;gen</a></td></tr>
                  </table>
    <?php 
  } 
} 
if (isset($menu_orphaned)) 
{ 
  ?>
                  <br />
                  <table border="1" cellspacing="0" cellpadding="5" align="center" width="95%">;
                    <tr><td align="center" colspan="3"><b style="color: #FF0000">Orphaned Items</b></td>
                    <tr>
                      <td class="colhead" align="left">unter Title</td>
                      <td class="colhead" align="center">Status</td>
                      <td class="colhead" align="center">Actions</td>
                    </tr>
  <?php 
  foreach ($menu_orphaned as $id => $temp) 
  { 
    ?>
                    <tr>
                      <td><?=$menu_orphaned[$id]["name"]?></td>
					  <td align="center" width="60"><?=$menu_orphaned[$id]["icon"]?></td>
                      <td align="center" width="60"><font color="<?=get_class_color($menu_orphaned[$id]["class"])?>"><?=get_user_class_name($menu_orphaned[$id]["class"])?></font></td>
                      <td align="center" width="60px">
                        <a href="<?=$_SERVER["PHP_SELF"]?>?action=edit&amp;id=<?=$id?>">Bearbeiten</a> 
                        <a href="<?=$_SERVER["PHP_SELF"]?>?action=delete&amp;id=<?=$id?>">L&ouml;schen</a>
                      </td>
                    </tr>
    <?php 
  } 
  ?>
                  </table>
  <?php 
} 
?>
                  <br />
                  <table border="1" cellspacing="0" cellpadding="5" align="center" width="95%">
                    <tr><td align="center"><a href="<?=$_SERVER["PHP_SELF"]?>?action=addsection">Neuen Men&uuml;-Abteil erstellen </a></td></tr>
                  </table>
                  <p align="center"><input type="submit" name="reorder" value="Men&uuml; Sortieren"></p>
                </form>
                <center>Wenn du hier dr&uuml;ckst wird dein Men&uuml; Sortiert </center>
<?php
print"
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
x264_admin_footer();
?>