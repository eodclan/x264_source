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
hit_start();
dbconn(false);
loggedinorreturn();
hit_count();
$newcats .= "<table summary=\"\" style=\"width:100%;\" cellpadding=\"5\" cellspacing=\"1\" align=\"center\" border=\"0\" class=\"table-bordered\">\n"; 
$res = mysql_query("SELECT * FROM categories where type = 1") OR sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res)) 
{
  $newcats .= "<tr><td class=\"table-bordered\" style=\"font-weight:bold;\" nowrap=\"nowrap\"><div class='checkbox icheck'><label class='switch switch-text switch-primary'><input id=\"h" . $arr["id"] . "\" name=\"h" . $arr["id"] . "\" class=\"switch-input\" value=\"1\" onclick=\"selectCat(&quot;h" . $arr["id"] . "&quot;,&quot;"; 
  $resa = mysql_query("SELECT * FROM categories where haupt = " . $arr["id"] . "") OR sqlerr(__FILE__, __LINE__);
  while ($arra = mysql_fetch_assoc($resa)) 
  {
    $newcats .= "" . $arra["id"] . ",";
  }
  $newcats .= "&quot;)\" type=\"checkbox\"><span class='switch-label' data-on='On' data-off='Off'></span><span class='switch-handle'></span></label>&nbsp;<a href=\"" . $_SERVER["PHP_SELF"] . "?showsearch=1&amp;";
  $resb = mysql_query("SELECT * FROM categories where haupt = " . $arr["id"] . "") OR sqlerr(__FILE__, __LINE__);
  while ($arrb = mysql_fetch_assoc($resb)) 
  {
    $newcats .= "c" . $arrb["id"] . "=1&amp;";
  }   
  $newcats .= "search=&amp;incldead=0&amp;orderby=added&amp;sort=desc\">" . $arr["name"] . "</a></div></td>\n<td class=\"tablea\" nowrap=\"nowrap\">";
  $resa = mysql_query("SELECT * FROM categories where haupt = " . $arr["id"] . "") OR sqlerr(__FILE__, __LINE__); 
  while ($arra = mysql_fetch_assoc($resa)) 
  {
    $newcats .= "<div style=\"float:left;padding:0 15px 0 0;\"><div class='checkbox icheck'><label class='switch switch-text switch-primary'><input id=\"c" . $arra["id"] . "\" name=\"c" . $arra["id"] . "\" class=\"switch-input\" value=\"1\" type=\"checkbox\"><span class='switch-label' data-on='On' data-off='Off'></span><span class='switch-handle'></span></label>&nbsp;<a href=\"" . $_SERVER["PHP_SELF"] . "?cat=" . $arra["id"] . "&amp;showsearch=1\">" . $arra["name"] . "</a></div></div>\n"; 
  }   
  $newcats .= "</td></tr>\n";
}
$newcats .= "</table>\n";  
$cats = genrelist();

$searchstr = unesc($_GET["search"]);
$cleansearchstr = searchfield($searchstr);
if (empty($cleansearchstr))
  unset($cleansearchstr);

$addparam = "";
$wherea = array("`activated`='yes'");
$wherecatina = array();

if ($_GET["incldead"] == 1)
{
  $addparam .= "incldead=1&amp;";
  if (!isset($CURUSER) || get_user_class < UC_ADMINISTRATOR)
    $wherea[] = "banned != 'yes'";
} elseif ($_GET["incldead"] == 2)
{
  $addparam .= "incldead=2&amp;";
  $wherea[] = "visible = 'no'";
}
else
  $wherea[] = "visible = 'yes'";
// BEGIN: Groups Edition by truenoir
$team=0+$_GET["team"];

$grpsel="";
$grpres=mysql_query("select * from teams where typ='crew'") or sqlerr(__FILE__, __LINE__);
while($grparr=mysql_fetch_assoc($grpres))
  $grpsel.="<option value=\"$grparr[id]\"".($team==$grparr["id"]? " selected":"").">$grparr[name]</option>";

if($grpsel!="")
  $grpsel="<select name=\"team\"><option value=\"0\"".($team==0?" selected":"").">---[ ALLE ]---</option>$grpsel</select>";
else
  unset($grpsel);

if ($team>0) 
  $wherea[] = "team = ".sqlesc($team);
// END: Groups Edition by truenoir
$category = intval($_GET["cat"]);

$all = $_GET["all"];
$blah = $_GET['blah'];
if (!$all)
{
  if (!$_GET && $CURUSER["notifs"])
  {
    $all = true;
    foreach ($cats as $cat)
    {
      $all &= $cat[id];
      if (strpos($CURUSER["notifs"], "[cat" . $cat[id] . "]") !== false)
      {
        $wherecatina[] = $cat[id];
        $addparam .= "c$cat[id]=1&amp;";
      }
    }
  }
  elseif ($category)
  {
    if (!is_valid_id($category))
      stderr("Error", "Invalid category ID $category.");
    $wherecatina[] = $category;
    $addparam .= "cat=$category&amp;";
  }
  else
  {
    $all = true;
    foreach ($cats as $cat)
    {
      $all &= $_GET["c$cat[id]"];
      if ($_GET["c$cat[id]"])
      {
        $wherecatina[] = $cat[id];
        $addparam .= "c$cat[id]=1&amp;";
      }
    }
  }
} 

$orderby = "ORDER BY ";

if ($_GET["orderby"] != "")
    $addparam .= "orderby=" . urlencode($_GET["orderby"]) . "&amp;";

switch ($_GET["orderby"])
{
  case "name":
    $orderby .= "torrents.name";
    break;
  case "type":
    $orderby .= "categories.name";
    break;
  case "files":
    $orderby .= "torrents.numfiles";
    break;
  case "comments":
    $orderby .= "torrents.comments";
    break;
  case "added":
    $orderby .= "torrents.added";
    break;
  case "size":
    $orderby .= "torrents.size";
    break;
  case "snatched":
    $orderby .= "torrents.times_completed";
    break;
  case "seeds":
    $orderby .= "torrents.seeders";
    break;
  case "leeches":
    $orderby .= "torrents.leechers";
    break;
  case "uppedby":
    $orderby .= "users.username";
    break;
  default:
    $_GET["orderby"] = "added";
    $orderby .= "torrents.added";
    break;
} 

$orderby_sel = array(
  "name" => "Torrent-Name",
  "type" => "Kategorie",
  "files" => "Anzahl Dateien",
  "comments" => "Anzahl Kommentare",
  "added" => "Upload-Datum",
  "size" => "Gesamtgröße",
  "snatched" => "Anzahl heruntergeladen",
  "seeds" => "Anzahl Seeder",
  "leeches" => "Anzahl Leecher",
  "uppedby" => "Uploader"
);

switch ($_GET["sort"])
{
  case "asc":
    $orderby .= " ASC";
    $addparam .= "sort=asc&amp;";
    break;
  default:
  case "desc":
    $addparam .= "sort=desc&amp;";
    $orderby .= " DESC";
    break;
} 

if ($all)
{
  $wherecatina = array();
  $addparam = "";
} 

if ($_GET["showsearch"] == 1)
{
  $CURUSER["displaysearch"] = "yes";
  mysql_query("UPDATE users SET displaysearch='yes' WHERE id=".$CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
  $_SESSION["userdata"]["displaysearch"] = "yes";
}
elseif (isset($_GET["showsearch"]) && $_GET["showsearch"] == 0)
{
  $CURUSER["displaysearch"] = "no";
  mysql_query("UPDATE users SET displaysearch='no' WHERE id=".$CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
  $_SESSION["userdata"]["displaysearch"] = "no";
}

if (count($wherecatina) > 1)
  $wherecatin = implode(",", $wherecatina);
elseif (count($wherecatina) == 1)
  $wherea[] = "category = $wherecatina[0]";


$wherebase = $wherea;

if (isset($cleansearchstr))
{
  if ($blah == 0)
  {
    $wherea[] = "torrents.name LIKE (" . sqlesc($searchstr) . ")";
  }
  elseif ($blah == 1)
  {
    $wherea[] = "MATCH (search_text, ori_descr) AGAINST (" . sqlesc($searchstr) . ")";
  }
  elseif ($blah == 2)
  {
    $wherea[] = "MATCH (search_text, ori_descr) AGAINST (" . sqlesc($searchstr) . ")";
  }
  $addparam .= "search=" . urlencode($searchstr) . "&";
} 

$where = implode(" AND ", $wherea);
if ($wherecatin)
  $where .= ($where ? " AND " : "") . "category IN(" . $wherecatin . ")";

if ($where != "")
  $where = "WHERE $where";

$emp = "";
global $CURUSER;
if ($CURUSER["xxx"] == 'yes' && $where !="")
{
  $emp = "AND category != '27'";
  $where = "$where AND category != '27'";
}

if ($CURUSER["xxx"] == 'yes' && $where =="")
{
  $emp = "AND category != '27'";
  $where = "WHERE category != '27'";
}

$sql = "SELECT COUNT(*) FROM torrents $where";
$res = mysql_query($sql) or sqlerr(__FILE__, __LINE__."<hr>".$sql);
$row = mysql_fetch_array($res);
$count = $row[0];

if (!$count && isset($cleansearchstr))
{
  $wherea = $wherebase;
  $orderby = "ORDER BY added DESC";
  $searcha = explode(" ", $cleansearchstr);
  $sc = 0;
  foreach ($searcha as $searchss)
  {
    if (strlen($searchss) <= 1)
    continue;
    $sc++;
    if ($sc > 5)
      break;
    $ssa = array();
    if ($blah == 0)
    {
      foreach (array("torrents.name") as $sss)
        $ssa[] = "$sss LIKE '%" . sqlwildcardesc($searchss) . "%'";
      $wherea[] = "(" . implode(" OR ", $ssa) . ")";
    }
    elseif ($blah == 1)
    {
      foreach (array("search_text", "ori_descr") as $sss)
        $ssa[] = "$sss LIKE '%" . sqlwildcardesc($searchss) . "%'";
      $wherea[] = "(" . implode(" OR ", $ssa) . ")";
    }
    elseif ($blah == 2)
    {
      foreach (array("search_text", "ori_descr") as $sss)
        $ssa[] = "$sss LIKE '%" . sqlwildcardesc($searchss) . "%'";
      $wherea[] = "(" . implode(" OR ", $ssa) . ")";
    }
  }
  if ($sc)
  {
    $where = implode(" AND ", $wherea);
    if ($where != "")
      $where = "WHERE $where";
    $res = mysql_query("SELECT COUNT(*) FROM torrents LEFT JOIN users ON torrents.owner = users.id $where") or sqlerr(__FILE__, __LINE__);
    $row = mysql_fetch_array($res);
    $count = $row[0];
  }
} 


$torrentsperpage = $CURUSER["torrentsperpage"];
if (!$torrentsperpage)
  $torrentsperpage = 15;

if ($count)
{
list($pagertop, $pagerbottom, $limit) = pager($torrentsperpage, $count, "tfiles.php?" . $addparam);
  $query = "SELECT torrents.freeleech, torrents.free, torrents.language, torrents.team, torrents.descr, torrents.numpics, torrents.id, torrents.multiplikator, torrents.highlight, torrents.nuked, torrents.nukereason, torrents.category, torrents.leechers, torrents.seeders, torrents.name, torrents.times_completed, torrents.size, torrents.added, torrents.last_action, torrents.comments,torrents.numfiles,torrents.filename,torrents.owner,IF(torrents.nfo <> '', 1, 0) as nfoav," .
    // "IF(torrents.numratings < ".$GLOBALS["MINVOTES"].", NULL, ROUND(torrents.ratingsum / torrents.numratings, 1)) AS rating, categories.name AS cat_name, categories.image AS cat_pic, users.username FROM torrents LEFT JOIN categories ON category = categories.id LEFT JOIN users ON torrents.owner = users.id $where $orderby $limit";
    "categories.name AS cat_name, categories.image AS cat_pic, users.username, users.anon, users.class AS uploaderclass FROM torrents LEFT JOIN categories ON category = categories.id LEFT JOIN users ON torrents.owner = users.id $where $orderby $limit";
    $res = mysql_query($query) or sqlerr(__FILE__, __LINE__);
}
else
  unset($res);
  

if (isset($cleansearchstr))
  x264_header("Suchergebnisse für \"$searchstr\"");
else
  x264_header();
 //////////////////Seed Hilfe Ruf/////////////////////A////////////////////////////////////////////////////////  
$res1=mysql_query("SELECT torrents.id, torrents.name, torrents.free, UNIX_TIMESTAMP(torrents.preTime) AS preTime, count(IF(peers.seeder=\"no\",1,NULL)) AS leech_cnt,  count(IF(peers.seeder=\"yes\",1,NULL)) AS seed_cnt, torrents.times_completed as snatched FROM torrents, peers WHERE  torrents.id=peers.torrent GROUP BY torrents.id ORDER BY seed_cnt, leech_cnt DESC") or sqlerr(__FILE__, __LINE__);
   
$needseed="";

while($r1=mysql_fetch_assoc($res1))
{
  if($r1["seed_cnt"]>0)
    break;
  $res2=mysql_query("SELECT * FROM completed WHERE torrent_id=".$r1["id"]) or sqlerr(__FILE__, __LINE__);
  while($r2=mysql_fetch_assoc($res2))
  {
    if ($CURUSER["id"]==$r2["user_id"])
    {
      $needseed.="<tr><td class=tableb><a  href=\"tfilesinfo.php?id=$r1[id]\">$r1[name]</a>".($r[free]=="yes"?$GLOBALS["TFILES_TEXT"]:"")."</td><td  class=tablea>$r1[seed_cnt]</td><td class=tableb>$r1[leech_cnt]</td><td class=tablea>$r1[snatched]</td></tr>\n";
    }
  }
}


?>
<form method="get" action="tfiles.php">
<input type="hidden" name="showsearch" value="1">
<?php
if ($CURUSER["displaysearch"] == "yes")
{
echo"
    <div class='row'>
		<div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Kategorien
					<div class='card-actions'>
						<a href='#' class='btn-close'><i class='icon-close'></i></a>		
					</div>					
                </div>
                <div class='card-block'>";
print ($newcats);
    ?>
			<table class='table table-hover table-outline mb-0 hidden-sm-down'>
				<tbody>
				<tr>
				<td>Suchen:&nbsp;<input type="text" id="searchinput" name="search" autocomplete="off" onclick="suggest(event.keyCode,this.value);" onkeyup="suggest(event.keyCode,this.value);" onkeypress="return noenter(event.keyCode);" value="<?= htmlspecialchars($searchstr) ?>" class="btn btn-flat btn-primary fc-today-button" />
				<script language="JavaScript" src="<?=$GLOBALS["DESIGN_PATTERN"]; ?><?=$GLOBALS["ss_uri"]; ?>/js/suggest.js" type="text/javascript"></script>
				<div id="suggcontainer">
					<div id="suggestions"></div>
				</div>
				</td>		
			<td colspan="<?=$GLOBALS["BROWSE_CATS_PER_ROW"]?>">
				<input type="submit" value="Suchen / Aktualisieren" class="btn btn-flat btn-primary fc-today-button" />				
				<select name="incldead" id="select" class="btn btn-flat btn-primary fc-today-button">
					<option value="0">aktive Torrents</option>
					<option value="1"<?php print($_GET["incldead"] == 1 ? " selected" : ""); ?>>alle Torrents</option>
					<option value="2"<?php print($_GET["incldead"] == 2 ? " selected" : ""); ?>>tote Torrents</option>
				</select> </td>
                            </tr>
                        </tbody>							
					</table>			
			<?  
  $alllink = "<table class='table table-hover table-outline mb-0 hidden-sm-down'><tbody><tr><td><a href='tfiles.php?all=1&amp;showsearch=1' style='text-align:center;'><b>Alle anzeigen</b></a></td></tr></tbody></table>";
		
  $ncats = count($cats);
  $nrows = ceil($ncats / $GLOBALS["BROWSE_CATS_PER_ROW"]);
  $lastrowcols = $ncats % $GLOBALS["BROWSE_CATS_PER_ROW"];
  if ($lastrowcols != 0)
  {
    if ($GLOBALS["BROWSE_CATS_PER_ROW"] - $lastrowcols != 1)
    {
      print("<div rowspan=\"" . ($GLOBALS["BROWSE_CATS_PER_ROW"] - $lastrowcols - 1) . "\"></div>");
    }
    print("<div style=\"text-align:center;\">$alllink</div>\n");
  }

  if ($ncats % $GLOBALS["BROWSE_CATS_PER_ROW"] == 0)
    print("$alllink");
 
} else {
?>
			<table class='table table-hover table-outline mb-0 hidden-sm-down'>
				<tbody>
				<tr>
			<td><a href="tfiles.php?<?=$addparam?>showsearch=1<?php if ($_GET["page"] > 0) echo "&amp;page=" . intval($_GET["page"]); ?>"><img src="<?=$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]?>/plus.gif" alt="+" title="Aufklappen" border="0"> <b>Kategorien / Suchen</b></a></td>
                            </tr>
                        </tbody>							
					</table>		
<?php 
}
?>

                </div>
            </div>
        </div>
	</div>
<?php

echo"
    <div class='row'>
		<div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> Release Groups
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>					
                </div>
                <div class='card-block'>
					<table class='table table-hover table-outline mb-0 hidden-sm-down'>
                        <tbody>
                            <tr>
                                <td class='text-center'>
									<a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_01"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_01"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_02"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_02"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_03"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_03"]."</a>
                                </td>
                                <td class='text-center'>
									<a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_04"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_04"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_05"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_05"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_06"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_06"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_07"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_07"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_08"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_08"]."</a>
                                </td>
                            </tr>
                            <tr>
                                <td class='text-center'>
									<a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_09"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_09"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_10"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_10"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_11"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_11"]."</a>
                                </td>
                                <td class='text-center'>
									<a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_12"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_12"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_13"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_13"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_14"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_14"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_15"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_15"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_16"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_16"]."</a>
                                </td>
                            </tr>                            <tr>
                                <td class='text-center'>
									<a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_17"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_17"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_18"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_18"]."</a>
                                </td>
                                <td class='text-center'>
                                    <a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_19"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_19"]."</a>
                                </td>
                                <td class='text-center'>
									<a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_20"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_20"]."</a>
                                </td>
                                <td class='text-center'>
									<a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_21"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_21"]."</a>								
                                </td>
                                <td class='text-center'>
									<a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_22"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_22"]."</a>								
                                </td>
                                <td class='text-center'>
									<a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_23"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_23"]."</a>								
                                </td>
                                <td class='text-center'>
									<a href='tfiles.php?showsearch=1&search=-".$GLOBALS["TF_RL_24"]."&blah=0&incldead=0&orderby=added&sort=desc' class='btn btn-primary btn-sm'>".$GLOBALS["TF_RL_24"]."</a>								
								</td>								
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</div>";
?>

</form>
<?php
if (isset($cleansearchstr)) {
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Deine Suche von
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<?=htmlspecialchars($searchstr)?>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?php
} 
if ($count) {
echo"
                    <div class='row ng-scope'' ng-view='' autoscroll='true'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> " . $GLOBALS["SITENAME"] . " Torrents
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	
?>
					<table class="table-bordered">
                        <thead>
<?
    torrenttable($res, "index", $addparam);
?>
                        </thead>
                    </table>
					<table class="table-bordered">
                        <thead>					
<?
    print($pagerbottom);
?>
                        </thead>
                    </table>
<?					
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";	
} else {
    if (isset($cleansearchstr)) {
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Nichts gefunden!
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									Es existieren keine Torrents, die deinen Suchkriterien entsprechen!
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?php
} else {
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Nichts gefunden!
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									Keine Torrents vorhanden!
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?php
} 
} 
x264_footer();
hit_end();
?>