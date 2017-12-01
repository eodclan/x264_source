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
// Lade Admin CP Klasse
include 'include/Classes/Admin.php';
dbconn(true);
x264_bootstrap_header("Administrator Panel");

check_access(UC_MODERATOR);
security_tactics();

$Admin = new Admin();
$Admin->AdminList();

x264_bootstrap_footer();
?>