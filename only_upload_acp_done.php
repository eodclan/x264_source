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

dbconn(false);
loggedinorreturn();
check_access(UC_SYSOP);
security_tactics();

if (get_user_class() >= UC_SYSOP)
{ 


$action = $_POST["action"];

if ($action == "yes") 
mysql_query("UPDATE torrents SET free='yes', wonly='yes'  WHERE free='no'") or sqlerr(__FILE__, __LINE__);


if ($action == "no")
mysql_query("UPDATE torrents SET free='no', wonly='no' WHERE wonly='yes'") or sqlerr(__FILE__, __LINE__);

 

    header("Location: " . $GLOBALS["BASEURL"]);
    die;
}
else
print("<p style=\"text-align:center;font-size:12pt;\"><b>Dir ist es nicht erlaubt, hier zuzugreifen</b></p>");
?>