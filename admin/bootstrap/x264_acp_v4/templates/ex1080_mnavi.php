<?php	
$res = mysql_query("SELECT `id`, `name`, `url`, `class` FROM `staffacpmenu` WHERE `type`='haupt' ORDER BY `order` ASC");
while ($arr = mysql_fetch_array($res, MYSQL_BOTH)) 
{
  $menu_haupt[$arr["id"]]["title"]  = $arr["name"];
  $menu_haupt[$arr["id"]]["url"]    = $arr["url"];
  $menu_haupt[$arr["id"]]["class"]  = $arr["class"]; 
}
$res = mysql_query("SELECT `id`, `name`, `url`, `class`, `haupt` FROM `staffacpmenu` WHERE `type`='unter' ORDER BY `order` ASC");
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
    print "

            <nav class='sidebar-nav'>
                <ul class='nav'>
                    <li class='nav-item'>
                        <a class='nav-link' href='backend_acp.php'><i class='icon-speedometer'></i> Dashboard</a>
                    </li>
                    <li class='nav-title'>
                        Navigation
                    </li>";
 
  foreach ($menu_haupt as $id => $temp) 
  { 
    if ($CURUSER["class"] >= $menu_haupt[$id]["class"]) 
    { 
?>

                    <li class='nav-item nav-dropdown'>
                        <a class='nav-link nav-dropdown-toggle' href='#'><i class='icon-puzzle'></i> <?=$menu_haupt[$id]["title"]?></a>
                        <ul class='nav-dropdown-items'>		  
      <?php 
      if (array_key_exists("items", $menu_haupt[$id])) 
      { 
        foreach ($menu_haupt[$id]["items"] as $id2 => $temp) 
        { 
          if ($CURUSER["class"] >= $menu_haupt[$id]["items"][$id2]["class"]) 
          { 
            ?>

                            <li class='nav-item'>
                                <a class='nav-link' href='<?=$menu_haupt[$id]["items"][$id2]["url"]?>'><i class='icon-puzzle'></i> <?=$menu_haupt[$id]["items"][$id2]["name"]?></a>
                            </li>
            <?php 
          } 
        } 
      }
     ?>
                        </ul>
                    </li>
     <?  
    } 
  } 
}
    print "

                </ul>
            </nav>
        </div>";
?>