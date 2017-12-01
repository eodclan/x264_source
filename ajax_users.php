<?php
// ************************************************************************************//
// * X264 Source
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 3.0
// * 
// * Copyright (c) 2015 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//
require_once(dirname(__FILE__)."/include/bittorrent.php");
header("Content-Type: text/html; charset=iso-8859-1");
dbconn();
loggedinorreturn();

$nick = mysql_real_escape_string(trim($_GET["text"]));

if(strlen($nick) < 1)
$nick = "a";

$res = mysql_query("SELECT * FROM users WHERE username LIKE '$nick%' ORDER BY username LIMIT 50");

$count = mysql_num_rows($res);

$num = mysql_num_rows($res);
$ut ="";
$ut .= "<center><table cellspacing=1 cellpadding=4 border=0 class=tableinborder>\n";
$ut .= "<tr><td class=colhead align=left>Username</td><td class=colhead>Registriert</td><td class=colhead>Letzter Login</td><td class=colhead>Land</td><td class=colhead align=left>Rang</td></tr>\n";
for ($i = 0; $i < $num; ++$i)
{
  $arr = mysql_fetch_assoc($res);
  if ($arr['country'] > 0)
  {
    $cres = mysql_query("SELECT name,flagpic FROM countries WHERE id=$arr[country]");
    if (mysql_num_rows($cres) == 1)
    {
      $carr = mysql_fetch_assoc($cres);
      $country = "<td style='padding: 0px' align=center><img src=pic/{$pic_base_url}flag/{$carr['flagpic']} alt=". htmlspecialchars($carr['name']) ."></td>";
    }
  }
  else
    $country = "<td align=center>---</td>";
  if ($arr['added'] == '0000-00-00 00:00:00')
    $arr['added'] = '-';
  if ($arr['last_access'] == '0000-00-00 00:00:00')
    $arr['last_access'] = '-';
  $ut .= "<tr><td align=left><a href=userdetails.php?id=$arr[id]><b>$arr[username]</b></a>" .($arr["donated"] > 0 ? "<img src=/pic/star.gif border=0 alt='Donor'>" : "")."</td>" .
  "<td>$arr[added]</td><td>$arr[last_access]</td>$country".
    "<td align=left>" . get_user_class_name($arr["class"]). "</td></tr>\n";
}
$ut .= "</table>\n";
$ut .= "" . $count ." Members wurden gefunden";

echo $ut;
?>