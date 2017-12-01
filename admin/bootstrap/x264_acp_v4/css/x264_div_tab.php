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
#x264_div_tab_wrap{
	border: 2px solid #111;
	border-radius: 1px 1px 1px 1px;
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8),inset 0 1px 0 rgba(225,225,225,0.15),inset 0 0 2px rgba(225,225,225,0.1);
	background: radial-gradient(ellipse at center, #262626 0%,rgb(26,26,26) 100%);
	overflow: auto;
	width:100%;
	margin:auto;
	text-align:center;
}
#x264_div_tab_wrap_error{
	background: radial-gradient(ellipse at center, #262626 0%,rgb(26,26,26) 100%);
	width:650px;
	height:215px;
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
.x264_div_tab_inp{
	width:250px;
	float:left;
	margin:5px 0 0 0;
	background-color: rgb(26,26,26);
	color:#ccc;
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
.x264_div_tab_klicks{
	background-color: rgb(26,26,26);
	width:100%;
	height:20px;
	display:block;
	float:left;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	line-height:20px;
	text-align:center;
	outline-style:none;
	margin-left:10px;
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
.x264_div_tab_inc{
	width:370px;
	float:left;
	border:1px solid #404040;
	margin:1px 0 0 0;
	background-color:#414141;
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
.x264_div_tab_lab{
	padding-left:3px;
}
.x264_div_tab_inputs{
	background-color: rgb(26,26,26);
	width:50%;
	height:35px;
	display:block;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	line-height:20px;
	text-align:center;
	margin:0 auto 3px auto;
	padding:5px;
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
.x264_div_tab_inputs_button{
	background-color: rgb(26,26,26);
	width:20%;
	height:20px;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	text-align:center;
	margin:0 auto 3px auto;
	padding:3px;
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
.x264_div_tab_inputs_special{
	background-color: rgb(26,26,26);
	width:50%;
	display:block;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	line-height:20px;
	text-align:center;
	margin:0 auto 3px auto;
	padding:5px;
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
.x264_div_tab_inputs_textarea{
	background-color: rgb(26,26,26);
	width:60%;
	display:block;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	line-height:20px;
	text-align:center;
	margin:0 auto 3px auto;
	padding:5px;
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
.x264_div_tab_inputs_checked{
	background-color: rgb(26,26,26);
	width:5%;
	display:block;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	line-height:20px;
	text-align:center;
	margin:0 auto 3px auto;
	padding:5px;
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
.x264_div_tab_title{
	font-size: 14px;
	color: #999;
	background: linear-gradient(#2E2E2E,#1A1A1A,#000000);
	border: 1px solid #000height:30px;
	font-weight:bold;
	text-decoration: none;
	line-height:30px;
	text-align:center;
}
.x264_div_tab_foot{
	background-color: rgb(26,26,26);
	width:340px;
	height:30px;
	display:block;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	line-height:30px;
	text-align:center;
	margin:0 auto 3px auto;
	padding:5px;
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
.x264_div_tab_wrap_log{
	background-color: rgb(26,26,26);
	width:75%;	
	display:block;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	text-align:center;
	margin:0 auto 3px auto;
	padding-left:29px;
	padding:5px;
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
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8),inset 0 1px 0 rgba(225,225,225,0.15),inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_div_tab_wrap_cap{
	border:1px solid #606060;
	height:30px;
	width:270px;
	line-height:28px;
	margin:0 auto 3px auto;
	padding:5px;
	background-color:#303030;
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
.x264_div_tab_table{
	background-color: rgb(26,26,26);
	width:100%;
	height:20px;
	display:block;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	line-height:20px;
	text-align:center;
	line-height:20px;
	margin:0 auto 3px auto;
	padding:5px;
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
.x264_div_tab_klicks:hover{
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}