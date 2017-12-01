<?php
// ************************************************************************************//
// * X264 Source
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2015 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//

require_once("include/bittorrent.php");

dbconn(false);

function hex2bin($hexdata) {

   for ($i=0;$i<strlen($hexdata);$i+=2) {
     $bindata.=chr(hexdec(substr($hexdata,$i,2)));
   }

   return $bindata;
}

$res = mysql_query("SELECT * FROM `users` WHERE `passkey`=".sqlesc(hex2bin($_GET["passkey"])));
if (mysql_num_rows($res)) {
    $udata = mysql_fetch_assoc($res);
    echo "User ".$udata["username"]." <a href=\"userdetails.php?id=".$udata["id"]."\">( ".$udata["id"]." )</a>";
} else
    echo "Nix gefunden :("

?>