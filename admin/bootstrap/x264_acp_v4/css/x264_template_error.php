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
#x264_error_wrap{
	background: radial-gradient(ellipse at center, #262626 0%,rgb(26,26,26) 100%);
	width:650px;
	height:500px;
	margin:auto;
	text-align:center;
	margin-top:50px;
	-o-border-radius:3px 3px 3px 3px;
	-icab-border-radius:3px 3px 3px 3px;
	-khtml-border-radius:3px 3px 3px 3px;
	-moz-border-radius:3px 3px 3px 3px;
	-webkit-border-radius:3px 3px 3px 3px;
	border-radius:3px 3px 3px 3px;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_error_wrap_info{
	border: 2px solid #111;
	border-radius: 3px 3px 3px 3px;
	box-shadow: 0 0 6px rgba(0,0,0,0.8),inset 0 1px 0 rgba(225,225,225,0.15),inset 0 0 2px rgba(225,225,225,0.1);
	background-color:rgba(19,19,19,1);
	text-align: center;
}
.x264_new_error_klicks{
	background-color: rgb(26,26,26);
	width:140px;
	height:20px;
	display:block;
	float:left;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	line-height:20px;
	text-align:center;
	outline-style:none;
	border:1px solid #606060;
	margin-left:10px;
	-o-border-radius:18px 18px 18px 18px;
	-icab-border-radius:18px 18px 18px 18px;
	-khtml-border-radius:18px 18px 18px 18px;
	-moz-border-radius:18px 18px 18px 18px;
	-webkit-border-radius:18px 18px 18px 18px;
	border-radius:18px 18px 18px 18px;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_new_error_klicks:hover{
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}