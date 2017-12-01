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
// Lade Admin Klasse
include 'include/Classes/Admin.php';
dbconn(true);
	
x264_bootstrap_header("Administrator Panel Manager");

check_access(UC_ADMINISTRATOR);
security_tactics();

$action = $_GET['action'];
$Admin = new Admin();

switch($action) {
	case '':
			$Admin->AdminAdmin();
			break;
	case 'createcategory':
			$Admin->CreateAdminCategoryForm();
			break;
	case 'docreatecategory':
			$Admin->CreateAdminCategoryDo();
			break;
	case 'createquestion':
			$Admin->CreateAdminQuestionForm();
			break;
	case 'docreatequestion':
			$Admin->CreateAdminQuestionDo();
			break;
	case 'editcategory':
			$Admin->EditAdminCategoryForm($_GET['cid']);
			break;
	case 'doeditcategory':
			$Admin->EditAdminCategoryDo();
			break;
	case 'editquestion':
			$Admin->EditAdminQuestionForm($_GET['qid']);
			break;
	case 'doeditquestion':
			$Admin->EditAdminQuestionDo();
			break;
	case 'deletecategory':
			$Admin->deleteCategory($_GET['cid']);
			break;
	case 'deletequestion':
			$Admin->deleteQuestion($_GET['qid']);
			break;
}

x264_bootstrap_footer();
?>