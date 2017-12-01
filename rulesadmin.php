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
loggedinorreturn();
check_access(UC_SYSOP);
security_tactics();

x264_bootstrap_header("Rules");

$action = $_GET['action'];
$Rules = new Rules();

switch($action) {
	case '':
			$Rules->RulesAdmin();
			break;
	case 'createcategory':
			$Rules->CreateRulesCategoryForm();
			break;
	case 'docreatecategory':
			$Rules->CreateRulesCategoryDo();
			break;
	case 'createquestion':
			$Rules->CreateRulesQuestionForm();
			break;
	case 'docreatequestion':
			$Rules->CreateRulesQuestionDo();
			break;
	case 'editcategory':
			$Rules->EditRulesCategoryForm($_GET['cid']);
			break;
	case 'doeditcategory':
			$Rules->EditRulesCategoryDo();
			break;
	case 'editquestion':
			$Rules->EditRulesQuestionForm($_GET['qid']);
			break;
	case 'doeditquestion':
			$Rules->EditRulesQuestionDo();
			break;
	case 'deletecategory':
			$Rules->deleteCategory($_GET['cid']);
			break;
	case 'deletequestion':
			$Rules->deleteQuestion($_GET['qid']);
			break;
}

x264_bootstrap_footer();
?>