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
// Lade Rules Klasse
include 'include/Classes/Rules.php';

dbconn(true);
x264_header("Rules");

$Rules = new Rules();
$Rules->RulesList();

x264_footer();
?>