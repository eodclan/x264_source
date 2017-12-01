    <div class='app-body'>
        <div class='sidebar'>
<?
if (get_user_class() <= UC_MODERATOR)
{
?>
	<nav class='sidebar-nav'>
<?
}else{
?>
	<nav class='sidebar-nav'>		
<?
}
$res = mysql_query("SELECT `id`, `name`, `url`, `class`, `icon` FROM `menu` WHERE `type`='haupt' ORDER BY `order` ASC");
while ($arr = mysql_fetch_array($res, MYSQL_BOTH))
{
  $menu_haupt[$arr["id"]]["title"]  = $arr["name"];
  $menu_haupt[$arr["id"]]["url"]    = $arr["url"];
  $menu_haupt[$arr["id"]]["class"]  = $arr["class"];
  $menu_haupt[$arr["id"]]["icon"]  = $arr["icon"]; 
}
$res = mysql_query("SELECT `id`, `name`, `url`, `class`, `icon`, `haupt` FROM `menu` WHERE `type`='unter' ORDER BY `order` ASC");
while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) 
{
  $menu_haupt[$arr["haupt"]]["items"][$arr["id"]]["name"]   = $arr["name"];
  $menu_haupt[$arr["haupt"]]["items"][$arr["id"]]["url"]    = $arr["url"];
  $menu_haupt[$arr["haupt"]]["items"][$arr["id"]]["class"]  = $arr["class"]; 
  $menu_haupt[$arr["haupt"]]["items"][$arr["id"]]["icon"]  = $arr["icon"];
}
if (isset($menu_haupt)) 
{ 
  foreach ($menu_haupt as $id => $temp) 
  {
    if (!array_key_exists("title", $menu_haupt[$id])) 
    { 
      foreach ($menu_haupt[$id]["items"] as $id2 => $temp) 
      {
        $menu_orphaned[$id2]["name"]  = $menu_haupt[$id]["items"][$id2]["name"];
        $menu_orphaned[$id2]["url"]   = $menu_haupt[$id]["items"][$id2]["url"];
        $menu_orphaned[$id2]["class"] = $menu_haupt[$id]["items"][$id2]["class"];
        $menu_orphaned[$id2]["icon"] = $menu_haupt[$id]["items"][$id2]["icon"]; 
        unset($menu_haupt[$id]); 
      } 
    } 
  } 
  foreach ($menu_haupt as $id => $temp) 
  { 
    if ($CURUSER["class"] >= $menu_haupt[$id]["class"]) 
    { 
      ?>
                <ul class='nav'>
                    <li class='nav-title'>
                        <?=$menu_haupt[$id]["title"]?>
                    </li>
      <?php 
      if (array_key_exists("items", $menu_haupt[$id])) 
      { 
        ?>
                    <li class='nav-item'>
        <?php 
        foreach ($menu_haupt[$id]["items"] as $id2 => $temp) 
        { 
          if ($CURUSER["class"] >= $menu_haupt[$id]["items"][$id2]["class"]) 
          { 
            ?>
                        <a class='nav-link' href='<?=$menu_haupt[$id]["items"][$id2]["url"]?>'><i class='<?=$menu_haupt[$id]["items"][$id2]["icon"]?>'></i> <?=$menu_haupt[$id]["items"][$id2]["name"]?></a>
            <?php 
          } 
        } 
        ?>
                    </li>
        <?php 
      } 
      ?>
                </ul>       
      <?php 
    }
  }
}
print "
            </nav>
        </div>";
?>