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
	
x264_admin_header("Administrator Panel Manager");

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

x264_admin_footer();
?>