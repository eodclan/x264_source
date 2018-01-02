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

// Lade Staffrules Klasse
require_once(dirname(__FILE__) . "/include/Classes/Staffrules.php");
dbconn(true);
loggedinorreturn();
if (get_user_class() < UC_TEAMLEITUNG)
	stderr("Error", "Permission denied.");

check_access(UC_SYSOP);
security_tactics();
x264_admin_header("Staff Rules");	

$action = $_GET['action'];
$Staffrules = new Staffrules();

switch($action) {
	case '':
			$Staffrules->StaffrulesAdmin();
			break;
	case 'createcategory':
			$Staffrules->CreateStaffrulesCategoryForm();
			break;
	case 'docreatecategory':
			$Staffrules->CreateStaffrulesCategoryDo();
			break;
	case 'createquestion':
			$Staffrules->CreateStaffrulesQuestionForm();
			break;
	case 'docreatequestion':
			$Staffrules->CreateStaffrulesQuestionDo();
			break;
	case 'editcategory':
			$Staffrules->EditStaffrulesCategoryForm($_GET['cid']);
			break;
	case 'doeditcategory':
			$Staffrules->EditStaffrulesCategoryDo();
			break;
	case 'editquestion':
			$Staffrules->EditStaffrulesQuestionForm($_GET['qid']);
			break;
	case 'doeditquestion':
			$Staffrules->EditStaffrulesQuestionDo();
			break;
	case 'deletecategory':
			$Staffrules->deleteCategory($_GET['cid']);
			break;
	case 'deletequestion':
			$Staffrules->deleteQuestion($_GET['qid']);
			break;
}

x264_admin_footer();
?>