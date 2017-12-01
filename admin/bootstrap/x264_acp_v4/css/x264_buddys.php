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
.x264_buddy_wrap{
	width:290px;
	float:left;
	margin:10px 0 0 12px;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_buddy_ava{
	width:100px;
	height:100px;
	overflow:hidden;
	margin:5px 10px 5px 5px;
	padding:5px;
	float:left;
	background-color:rgba(19,19,19,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_buddy_inf_wrap{
	float:left;
	margin:10px 0 0 0;
}
.x264_buddy_inf_d{
	margin:3px 0 0 5px;
}
.x264_buddy_inf_dm{
	margin:3px 0 5px 0px;
}
.x264_buddy_status{
	margin:5px 0 10px 10px;
}