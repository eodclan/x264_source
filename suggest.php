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

if (strlen($_GET['q']) > 3) 
{
  $q = str_replace(" ",".",sqlesc("%".$_GET['q']."%"));
  $q2 = str_replace("."," ",sqlesc("%".$_GET['q']."%"));
  $result = mysql_query("SELECT name FROM torrents WHERE name LIKE {$q} OR name LIKE {$q2} ORDER BY id DESC LIMIT 0,10;");
  if (mysql_numrows($result) > 0) 
  {
    for ($i = 0; $i < mysql_numrows($result); $i++) 
    {
      $name = mysql_result($result,$i,"name");
      $name = trim(str_replace("\t","",$name));
      print $name;
      if ($i != mysql_numrows($result)-1) 
      {
        print "\r\n";
      }
    }
  }
}
?> 