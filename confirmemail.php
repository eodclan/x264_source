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

$id = 0 + $_GET["id"];
$md5 = $_GET["secret"];
$email = urldecode($_GET["email"]);

if (!$id)
	httperr();

dbconn();

$row = $db -> execute("SELECT editsecret FROM users WHERE id = ".$id."");

if (!$row)
	httperr();

$sec = hash_pad($row["editsecret"]);
if (preg_match('/^ *$/s', $sec))
	httperr();
if ($md5 != md5($sec . $email . $sec))
	httperr();

$row = $db -> execute("UPDATE users SET editsecret='', email=" . sqlesc($email) . " WHERE id=".$id." AND editsecret=" . sqlesc($row["editsecret"]));

if (!mysql_affected_rows())
	httperr();

header("Refresh: 0; url=userdetails.php?id=".$id."");
?>