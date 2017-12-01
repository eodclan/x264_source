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
ob_start("ob_gzhandler");
require "include/bittorrent.php";
// Lade Staffrules Klasse
include 'include/Classes/Staffrules.php';

dbconn(true);
x264_bootstrap_header("Staff Rules");
check_access(UC_MODERATOR);
security_tactics();

$Staffrules = new Staffrules();
$Staffrules->StaffrulesList();

x264_bootstrap_footer();
?>