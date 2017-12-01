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

require_once(dirname(__FILE__)."/include/bittorrent.php");
require_once(dirname(__FILE__)."/include/gennavi.php");

dbconn();
loggedinorreturn();

header('Content-Type: text/html; charset=iso-8859-1');
?>