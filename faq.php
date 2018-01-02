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

// Lade Faq Klasse
require_once(dirname(__FILE__) . "/include/Classes/Faq.php");

dbconn(true);
x264_header("FAQ");

$Faq = new Faq();
$Faq->FaqList();

x264_footer();
?>