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
ob_start("ob_gzhandler");
require_once(dirname(__FILE__) . "/include/engine.php");

// Lade Admin CP Klasse
require_once(dirname(__FILE__) . "include/Classes/Admin.php");

dbconn(true);
x264_admin_header("Administrator Panel");

check_access(UC_MODERATOR);
security_tactics();

$Admin = new Admin();
$Admin->AdminList();

x264_admin_footer();
?>