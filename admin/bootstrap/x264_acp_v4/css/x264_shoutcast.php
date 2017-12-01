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
.x264_shoutcast_tab_1 {
	float: left;
	width:20%;
	text-align:center;
	border:2px solid #111;
	border:none 5px #000000;
	border-top-left-radius: 1px;
	border-top-right-radius: 1px;
	border-bottom-left-radius: 1px;
	border-bottom-right-radius: 1px;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	background-color:rgba(20,20,20,1);
	overflow:hidden;
}

.x264_shoutcast_tab_2 {
	float: left;
	width:80%;
	text-align:center;
	border:2px solid #111;
	border:none 5px #000000;
	border-top-left-radius: 1px;
	border-top-right-radius: 1px;
	border-bottom-left-radius: 1px;
	border-bottom-right-radius: 1px;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	background-color:rgba(20,20,20,1);
	overflow:hidden;
}