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
class Staffrules {
	
	var $SmartyTemplateDir = 'include/templates/';
	var $SmartyCompileDir = 'include/templates_c/';
	
	// Konstruktor
	function __construct() {
		define('SMARTY_TEMPLATES_DIR',$this->SmartyTemplateDir);
		define('SMARTY_TEMPLATES_C_DIR',$this->SmartyCompileDir);
		include ('include/Classes/Smarty/libs/Smarty.class.php');
	}

	function StaffrulesList() {
		$smarty = new Smarty();
		
		$get_categories = mysql_query("SELECT id, name, short FROM staffrules_categories ORDER BY id DESC");
		
		while($categories_data = mysql_fetch_object($get_categories)) {
			$categories[] = array('ID' => $categories_data->id,
								  'NAME' => $categories_data->name,
								  'SHORT' => $categories_data->short);
			
			$get_questions = mysql_query("SELECT id, category, question, answer FROM staffrules_questions WHERE category = ".$categories_data->id);
			while($questions_data = mysql_fetch_object($get_questions)) {
				$aq[] = array('CAT_ID' => $questions_data->category,
							  'ID' => $questions_data->id,
							  'QUESTION' => $questions_data->question,
							  'ANSWER' => $questions_data->answer);
			}
		}
		$smarty->assign('categories',$categories);
		$smarty->assign('aq',$aq);
		$smarty->display('staffrules_overview.tpl.html');
	}
	
	function StaffrulesAdmin() {
		$smarty = new Smarty();
		
		$get_categories = mysql_query("SELECT id, name, short FROM staffrules_categories ORDER BY id DESC");
		
		while($categories_data = mysql_fetch_object($get_categories)) {
			$categories[] = array('ID' => $categories_data->id,
								  'NAME' => $categories_data->name,
								  'SHORT' => $categories_data->short);
			
			$get_questions = mysql_query("SELECT id, category, question, answer FROM staffrules_questions WHERE category = ".$categories_data->id);
			while($questions_data = mysql_fetch_object($get_questions)) {
				$aq[] = array('CAT_ID' => $questions_data->category,
							  'ID' => $questions_data->id,
							  'QUESTION' => $questions_data->question,
							  'ANSWER' => $questions_data->answer);
			}
		}
		$smarty->assign('categories',$categories);
		$smarty->assign('aq',$aq);
		$smarty->assign('PIC_URL',$GLOBALS["PIC_BASE_URL"]);
		$smarty->display('staffrules_admin_overview.tpl.html');
	}
	
	function CreateStaffrulesCategoryForm() {
		$smarty = new Smarty();
		$smarty->assign('CREATE_CATEGORY',1);
		$smarty->display('staffrules_create_category.tpl.html');
	}
	
	function CreateStaffrulesCategoryDo() {
		$smarty = new Smarty();
		$smarty->assign('CREATE_CATEGORY_DO',1);
		
		if(empty($_POST['name']) || empty($_POST['short'])) {
			$smarty->assign('EMPTY',1);
		} else {
			$name = $this->escapeForSql($_POST['name']);
			$short = $this->escapeForSql($_POST['short']);
			
			mysql_query("INSERT INTO staffrules_categories (name,short) VALUES ('$name','$short')") or sqlerr();
			
			$smarty->assign('SUCCESS',1);
		}
		$smarty->display('staffrules_create_category.tpl.html');
	}
	
	function CreateStaffrulesQuestionForm() {
		$smarty = new Smarty();
		$smarty->assign('CREATE_QUESTION',1);
		$smarty->assign('categories', $this->getStaffrulesCategoriesAsArray());
		$smarty->display('staffrules_create_question.tpl.html');
	}
	
	function CreateStaffrulesQuestionDo() {
		$smarty = new Smarty();
		$smarty->assign('CREATE_QUESTION_DO',1);
		
		if(empty($_POST['question']) || empty($_POST['answer'])) {
			$smarty->assign('EMPTY',1);
		} else {
			$question = $this->escapeForSql($_POST['question']);
			$answer = $this->escapeForSql($_POST['answer']);
			$category = intval($_POST['category']);
			
			mysql_query("INSERT INTO staffrules_questions (question,answer,category) VALUES ('$question','$answer','$category')") or sqlerr();
			
			$smarty->assign('SUCCESS',1);
		}
		$smarty->display('staffrules_create_question.tpl.html');
	}
	
	function EditStaffrulesCategoryForm($id) {
		$smarty = new Smarty();
		$smarty->assign('EDIT_CATEGORY',1);
		
		$cid = intval($_GET['cid']);
		$get_category = mysql_query("SELECT id, name, short FROM staffrules_categories WHERE id =".$cid);
		$category_data = mysql_fetch_object($get_category);
		$category = array('ID' => $category_data->id,
						  'NAME' => $category_data->name,
						  'SHORT' => $category_data->short);
		
		$smarty->assign('category',$category);
		$smarty->display('staffrules_edit_category.tpl.html');
	}
	
	function EditStaffrulesCategoryDo() {
		$smarty = new Smarty();
		$smarty->assign('EDIT_CATEGORY_DO',1);
		if(empty($_POST['name']) || empty($_POST['short'])) {
			$smarty->assign('CID',intval($_POST['cid']));
			$smarty->assign('EMPTY',1);
		} else {
			$name = $this->escapeForSql($_POST['name']);
			$short = $this->escapeForSql($_POST['short']);
			$cid = $this->escapeForSql($_POST['cid']);
		
			if(!empty($cid)) {
				mysql_query("UPDATE staffrules_categories SET name='".$name."', short='".$short."' WHERE id = ".$cid) or sqlerr();
			}
				
			$smarty->assign('SUCCESS',1);
		}
		$smarty->display('staffrules_edit_category.tpl.html');
	}
	
	function EditStaffrulesQuestionForm($id) {
		$smarty = new Smarty();
		$smarty->assign('EDIT_QUESTION',1);
		
		$qid = intval($_GET['qid']);
		$get_question = mysql_query("SELECT id, category, question, answer FROM staffrules_questions WHERE id =".$qid);
		$question_data = mysql_fetch_object($get_question);
		$question = array('ID' => $question_data->id,
						  'CATEGORY' => $question_data->category,
						  'QUESTION' => $question_data->question,
						  'ANSWER' => $question_data->answer);
		
		$smarty->assign('question',$question);
		$smarty->assign('categories',$this->getStaffrulesCategoriesAsArray());
		$smarty->display('staffrules_edit_question.tpl.html');
	}
	
	function EditStaffrulesQuestionDo() {
		$smarty = new Smarty();
		$smarty->assign('EDIT_QUESTION_DO',1);
		if(empty($_POST['question']) || empty($_POST['answer'])) {
			$smarty->assign('QID',intval($_POST['qid']));
			$smarty->assign('EMPTY',1);
		} else {
			$question = $this->escapeForSql($_POST['question']);
			$answer = $this->escapeForSql($_POST['answer']);
			$category = intval($_POST['category']);
			$qid = $this->escapeForSql($_POST['qid']);
		
			if(!empty($qid)) {
				mysql_query("UPDATE staffrules_questions SET question='".$question."', answer='".$answer."', category='".$category."' WHERE id = ".$qid) or sqlerr();
			}
				
			$smarty->assign('SUCCESS',1);
		}
		$smarty->display('staffrules_edit_question.tpl.html');
	}
	
	function deleteCategory($id) {
		$cid = intval($id);
		mysql_query("DELETE FROM staffrules_categories WHERE id = ".$cid);
		mysql_query("DELETE FROM staffrules_questions WHERE category = ".$cid);
		header("location: staffrulesadmin.php");
	}
	
	function deleteQuestion($id) {
		$qid = intval($id);
		mysql_query("DELETE FROM staffrules_questions WHERE id = ".$qid);
		header("location: staffrulesadmin.php");
	}
	
	function getStaffrulesCategoriesAsArray() {
		$get_categories_data = mysql_query("SELECT id, name FROM staffrules_categories ORDER BY id DESC");
		while($all_categories = mysql_fetch_object($get_categories_data)) {
			$categories_array[] = array('ID' => $all_categories->id,
										'NAME' => $all_categories->name); 
		}
		return $categories_array;
	}
	
	function escapeForSql($var) {
		$var = mysql_real_escape_string($var);
		return $var;
	}
	
	
}
?>