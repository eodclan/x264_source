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
  ob_start ("ob_gzhandler");
  ob_start("compress");
  header("Content-type: text/css;charset: UTF-8");
  header("Cache-Control: must-revalidate");
  $offset = 60 * 60 ;
  $ExpStr = "Expires: " . gmdate("D, d M Y H:i:s",time() + $offset) . " GMT";
  header($ExpStr);
  function compress($buffer) {
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    $buffer = str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),'',$buffer);
    $buffer = str_replace('{ ', '{', $buffer);
    $buffer = str_replace(' }', '}', $buffer);
    $buffer = str_replace('; ', ';', $buffer);
    $buffer = str_replace(', ', ',', $buffer);
    $buffer = str_replace(' {', '{', $buffer);
    $buffer = str_replace('} ', '}', $buffer);
    $buffer = str_replace(': ', ':', $buffer);
    $buffer = str_replace(' ,', ',', $buffer);
    $buffer = str_replace(' ;', ';', $buffer);
    $buffer = str_replace(';}', '}', $buffer);
    return $buffer;
  }
?>
.faq_box {
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	border:none 5px #000000;
	-moz-border-radius: 21px;
	-webkit-border-radius: 21px;
	border-radius: 21px;
}
.faq_head {
font-size: 14px;
color: #999;
	background: url(framework/tabletitle_2k15.png) repeat-x;
border: 1px solid #000height:30px;
}
.faq_head .normalfont {
font-size: 14px;
color: #999;
	background: url(framework/tabletitle_2k15.png) repeat-x;
border: 1px solid #000height:30px;
}
.faq_head .normalfont a {
font-size: 14px;
color: #999;
	background: url(framework/tabletitle_2k15.png) repeat-x;
border: 1px solid #000height:30px;
    text-decoration: none;
}
.faq_head .normalfont a:hover {
font-size: 14px;
color: #999;
	background: url(framework/tabletitle_2k15.png) repeat-x;
border: 1px solid #000height:30px;
    text-decoration: underline;
}
.faq_ul{
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	border:none 5px #000000;
	-moz-border-radius: 21px;
	-webkit-border-radius: 21px;
	border-radius: 21px;
}

.faq_tableb {
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	border:none 5px #000000;
	-moz-border-radius: 21px;
	-webkit-border-radius: 21px;
	border-radius: 21px;
    height: 100%;
    padding: 5px;
}
.faq_tablea {
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	border:none 5px #000000;
	-moz-border-radius: 21px;
	-webkit-border-radius: 21px;
	border-radius: 21px;
    overflow: hidden;
}
.faq_question_box {
    margin: 3px auto;
    width: 720px;
}
.faq_question_box .faq_tableb {
font-size: 14px;
color: #999;
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	border:none 5px #000000;
	-moz-border-radius: 21px;
	-webkit-border-radius: 21px;
	border-radius: 21px;
border: 1px solid #000height:30px;
    height: 24px;
    padding: 0px 0px 0px 5px;
}
.faq_question_box .faq_tablea {
    border-left: 1px #000000 solid;
    border-bottom: 1px #000000 solid;
    border-right: 1px #000000 solid;
    padding: 5px;
}
.faq_question_box .faq_tableb .normalfont {
    position: relative;
    top: 3px;
    font-weight: bold;
}