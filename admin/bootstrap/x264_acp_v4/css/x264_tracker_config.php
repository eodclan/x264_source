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
.x264_tcon_klicks{
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
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tcon_inc{
	background-color: rgb(26,26,26);
	width:55%;	
	display:block;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	text-align:center;
	margin:0 auto 3px auto;
	padding-left:250px;
	padding:5px;
	-o-border-radius:3px 3px 3px 3px;
	-icab-border-radius:3px 3px 3px 3px;
	-khtml-border-radius:3px 3px 3px 3px;
	-moz-border-radius:3px 3px 3px 3px;
	-webkit-border-radius:3px 3px 3px 3px;
	border-radius:3px 3px 3px 3px;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tcon_lab{
	padding-left:3px;
}
.x264_tcon_inp{
	width:150px;
	float:left;
	margin:50px 0 0 0;
	background-color: rgb(26,26,26);
	color:#ccc;
	-o-border-radius:3px 3px 3px 3px;
	-icab-border-radius:3px 3px 3px 3px;
	-khtml-border-radius:3px 3px 3px 3px;
	-moz-border-radius:3px 3px 3px 3px;
	-webkit-border-radius:3px 3px 3px 3px;
	border-radius:3px 3px 3px 3px;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tcon_inputs{
	background-color: #131313; 
	background: url(framework/imput_2k15.png) repeat-x;
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
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tcon_inputs_button{
	background-color: #131313; 
	background: url(framework/imput_2k15.png) repeat-x;
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
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tcon_inputs_special{
	background-color: #131313; 
	background: url(framework/imput_2k15.png) repeat-x;
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
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tcon_inputs_textarea{
	background-color: #131313; 
	background: url(framework/textarea_2k15_2.png) repeat-x;
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
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tcon_inputs_checked{
	background-color: #131313; 
	background: url(framework/imput_2k15.png) repeat-x;
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
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tcon_title{
	font-size: 14px;
	color: #999;
	background: url(framework/tabletitle_2k15.png) repeat-x;
	border: 1px solid #000height:30px;
	font-weight:bold;
	text-decoration: none;
	line-height:30px;
	text-align:center;
}
.x264_tcon_foot{
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
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tcon_wrap_log{
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
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tcon_wrap_cap{
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
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tcon_table{
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
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tcon_klicks:hover{
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}