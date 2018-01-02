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

// Lade Rules Klasse
require_once(dirname(__FILE__) . "/include/Classes/Rules.php");

dbconn(true);
x264_header("Rules");

$Rules = new Rules();
$Rules->RulesList();

x264_footer();
?>