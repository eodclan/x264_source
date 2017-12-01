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
.x264_tfiles_wrapper_go{
	background: radial-gradient(ellipse at center, #262626 0%,rgb(26,26,26) 100%);
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
	border-bottom-left-radius: 5px;
	border-bottom-right-radius: 5px;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.x264_tfiles_wrapper_catpic{
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;	
	position: absolute;
	float:left;	
}
.x264_tfiles_wrapper_size {
	float: left;
	width: 150px;
	height: 18px;
	display: block;
	font-weight: bold;
	font-size: 12px;
	line-height: 17px;
	padding: 0 0 0 10px;
	margin: 4px 0 0 90px;
	margin-bottom:10px;
	-o-border-radius: 6px 6px 6px 6px;
	-icab-border-radius: 6px 6px 6px 6px;
	-khtml-border-radius: 6px 6px 6px 6px;
	-webkit-border-radius: 6px 6px 6px 6px;
	border-radius: 6px 6px 6px 6px;
	overflow: hidden;
	text-shadow: 1px 1px 2px #000;
	background: #1a1a1a;
	border: 1px solid #000000;
	-o-box-shadow: 0px 2px 6px #000;
	-icab-box-shadow: 0px 2px 6px #000;
	-khtml-box-shadow: 0px 2px 6px #000;
	-webkit-box-shadow: 0px 2px 6px #000;
	box-shadow: 0px 2px 6px #000;
}
.x264_tfiles_wrapper_files {
	float: left;
	width: 250px;
	height: 18px;
	display: block;
	font-weight: bold;
	font-size: 12px;
	line-height: 17px;
	padding: 0 0 0 10px;
	margin: 4px 0 0 90px;
	margin-bottom:10px;
	-o-border-radius: 6px 6px 6px 6px;
	-icab-border-radius: 6px 6px 6px 6px;
	-khtml-border-radius: 6px 6px 6px 6px;
	-webkit-border-radius: 6px 6px 6px 6px;
	border-radius: 6px 6px 6px 6px;
	overflow: hidden;
	text-shadow: 1px 1px 2px #000;
	background: #1a1a1a;
	border: 1px solid #000000;
	-o-box-shadow: 0px 2px 6px #000;
	-icab-box-shadow: 0px 2px 6px #000;
	-khtml-box-shadow: 0px 2px 6px #000;
	-webkit-box-shadow: 0px 2px 6px #000;
	box-shadow: 0px 2px 6px #000;
}
.x264_tfiles_wrapper_info {
	float: left;
	width: 150px;
	height: 18px;
	display: block;
	font-weight: bold;
	font-size: 12px;
	line-height: 17px;
	padding: 0 0 0 10px;
	margin: 4px 0 0 90px;
	-o-border-radius: 6px 6px 6px 6px;
	-icab-border-radius: 6px 6px 6px 6px;
	-khtml-border-radius: 6px 6px 6px 6px;
	-webkit-border-radius: 6px 6px 6px 6px;
	border-radius: 6px 6px 6px 6px;
	overflow: hidden;
	text-shadow: 1px 1px 2px #000;
	border: 1px solid #000000;
	-o-box-shadow: 0px 2px 6px #000;
	-icab-box-shadow: 0px 2px 6px #000;
	-khtml-box-shadow: 0px 2px 6px #000;
	-webkit-box-shadow: 0px 2px 6px #000;
	box-shadow: 0px 2px 6px #000;	
	background-color: rgb(26,26,26);
}
.x264_tfiles_wrapper_sl {
	float: right;
	width: 150px;
	height: 18px;
	display: block;
	font-weight: bold;
	font-size: 12px;
	line-height: 17px;
	padding: 0 0 0 10px;
	margin: 4px 0 0 90px;
	-o-border-radius: 6px 6px 6px 6px;
	-icab-border-radius: 6px 6px 6px 6px;
	-khtml-border-radius: 6px 6px 6px 6px;
	-webkit-border-radius: 6px 6px 6px 6px;
	border-radius: 6px 6px 6px 6px;
	overflow: hidden;
	text-shadow: 1px 1px 2px #000;
	border: 1px solid #000000;
	-o-box-shadow: 0px 2px 6px #000;
	-icab-box-shadow: 0px 2px 6px #000;
	-khtml-box-shadow: 0px 2px 6px #000;
	-webkit-box-shadow: 0px 2px 6px #000;
	box-shadow: 0px 2px 6px #000;	
	background-color: rgb(26,26,26);
}
.x264_tfiles_wrapper_name {
	float: left;
	width: 600px;
	height: 18px;
	display: block;
	font-weight: bold;
	font-size: 12px;
	line-height: 17px;
	padding: 0 0 0 10px;
	margin: 4px 0 0 90px;
	-o-border-radius: 6px 6px 6px 6px;
	-icab-border-radius: 6px 6px 6px 6px;
	-khtml-border-radius: 6px 6px 6px 6px;
	-webkit-border-radius: 6px 6px 6px 6px;
	border-radius: 6px 6px 6px 6px;
	overflow: hidden;
	text-shadow: 1px 1px 2px #000;
	background: #1a1a1a;
	border: 1px solid #000000;
	-o-box-shadow: 0px 2px 6px #000;
	-icab-box-shadow: 0px 2px 6px #000;
	-khtml-box-shadow: 0px 2px 6px #000;
	-webkit-box-shadow: 0px 2px 6px #000;
	box-shadow: 0px 2px 6px #000;
}

#x264_wrap_details_name {
	width: 840px;
	height: 32px;
	float: left;
	margin: 0 0 10px 4px;
	line-height: 32px;
	text-align: center;
	overflow: hidden;
	-o-box-shadow: 0px 0px 3px #000;
	-icab-box-shadow: 0px 0px 3px #000;
	-khtml-box-shadow: 0px 0px 3px #000;
	-webkit-box-shadow: 0px 0px 3px #000;
	box-shadow: 0px 0px 3px #000;
	border: 1px solid #404040;
	background-color: #212121;
}

.x264_wrap_details {
	width:96,5%;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	background-color:rgba(20,20,20,1);
	text-align:left;
	margin:auto;
	margin-bottom:20px;
	padding:10px;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	border:none 5px #000000;
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
	border-bottom-left-radius: 15px;
	border-bottom-right-radius: 15px;
	z-index: 1;
}

#x264_details_menu_sys {
	padding:0; 
	list-style:none;
	margin-left:auto;
	margin-right:auto; 
	height:30px;
}
#x264_details_menu_sys li {float:left;}
#x264_details_menu_sys li a {
	display:block; 
	border: 1px inset 0 0 6px rgba(0,0,0,0.8);
	background: url(../images/tcatRight.png);
	background-repeat: repeat-x;
	background-color: rgba(20,20,20,1);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	height:30px; line-height:30px;
	text-decoration: none;
	font-size:12px;
	font-family:verdana, arial, sans-serif;
	text-align:center;
	overflow:hidden;
	position:relative;
	z-index:10;
	margin-right:-1px;
}
#x264_details_menu_sys li a b {
	display:block; 
	height:100px; 
	width:100%; 
	position:absolute; 
	left:0; 
	border: 1px inset 0 0 6px rgba(0,0,0,0.8); 
	background: url(../images/tcatRight.png);
	background-repeat: repeat-x;
	background-color: rgba(20,20,20,1);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset; 
	z-index:-1;
}
#x264_details_menu_sys li a:hover {}
#x264_details_menu_sys li a:hover b {top:-30px;}
#x264_details_menu_sys li a.current b {top:-30px;}

.x264_wrap_details_a {
	float: left;	
}

.x264_wrap_details_b {	
	float: right;
}

#x264_wrap_details_cover {
	width: 250px;
	float: left;
	margin: 10px 0 0 10px;
	padding: 10px;
	border: 1px solid #404040;
	-o-box-shadow: 0px 0px 5px #000;
	-icab-box-shadow: 0px 0px 5px #000;
	-khtml-box-shadow: 0px 0px 5px #000;
	-webkit-box-shadow: 0px 0px 5px #000;
	box-shadow: 0px 0px 5px #000;
	background-color: #212121;
}

.x264_wrap_details_download {
	width: 250px;
	float: left;
	margin: 10px 0 0 10px;
	padding: 10px;
	border: 1px solid #404040;
	-o-box-shadow: 0px 0px 5px #000;
	-icab-box-shadow: 0px 0px 5px #000;
	-khtml-box-shadow: 0px 0px 5px #000;
	-webkit-box-shadow: 0px 0px 5px #000;
	box-shadow: 0px 0px 5px #000;
	background-color: #212121;
}

.x264_wrap_details_edit {
	width: 250px;
	float: left;
	margin: 10px 0 0 10px;
	padding: 10px;
	border: 1px solid #404040;
	-o-box-shadow: 0px 0px 5px #000;
	-icab-box-shadow: 0px 0px 5px #000;
	-khtml-box-shadow: 0px 0px 5px #000;
	-webkit-box-shadow: 0px 0px 5px #000;
	box-shadow: 0px 0px 5px #000;
	background-color: #212121;
}

.x264_wrap_details_hashwert {
	width: 250px;
	float: left;
	margin: 10px 0 0 10px;
	padding: 10px;
	border: 1px solid #404040;
	-o-box-shadow: 0px 0px 5px #000;
	-icab-box-shadow: 0px 0px 5px #000;
	-khtml-box-shadow: 0px 0px 5px #000;
	-webkit-box-shadow: 0px 0px 5px #000;
	box-shadow: 0px 0px 5px #000;
	background-color: #212121;
}

#x264_wrap_details_right {
	width: 870px;
	height: 99%;
	float: left;
	margin: 10px 0 0 10px;
	padding: 10px;
	border: 1px solid #404040;
	-o-box-shadow: 0px 0px 5px #000;
	-icab-box-shadow: 0px 0px 5px #000;
	-khtml-box-shadow: 0px 0px 5px #000;
	-webkit-box-shadow: 0px 0px 5px #000;
	box-shadow: 0px 0px 5px #000;
	background-color: #212121;
}

#x264_wrap_details_left {
	width: 870px;
	height: 99%;
	float: left;
	margin: 10px 0 0 10px;
	padding: 10px;
	border: 1px solid #404040;
	-o-box-shadow: 0px 0px 5px #000;
	-icab-box-shadow: 0px 0px 5px #000;
	-khtml-box-shadow: 0px 0px 5px #000;
	-webkit-box-shadow: 0px 0px 5px #000;
	box-shadow: 0px 0px 5px #000;
	background-color: #212121;
}

#x264_wrap_details_info {
	width: 250px;
	height: 390px;
	float: left;
	margin: 10px 0 0 10px;
	padding: 10px;
	border: 1px solid #404040;
	-o-box-shadow: 0px 0px 5px #000;
	-icab-box-shadow: 0px 0px 5px #000;
	-khtml-box-shadow: 0px 0px 5px #000;
	-webkit-box-shadow: 0px 0px 5px #000;
	box-shadow: 0px 0px 5px #000;
	background-color: #212121;
}

#nfo_header_pop {
    display: none;
    position: absolute;
    width: 682px;
    height: 105px;
    margin: 10px 0 0 105px;
    padding: 10px;
    background-color: rgba(20,20,20,1);
    border: 1px inset 0 0 6px rgba(0,0,0,0.8);
    -webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
    box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
    z-index: 100;
}



.pagenav {
    float        : right;
    padding-right: 10px;
    display      : block;
}

.pagenav_table{
    border    : 0px;
    text-align: center;
    width     : 900px;
}

.pagenav_top {
    margin-top: 5px;
}

.pagenav span {
    display: block;
    float  : left;
    clear  : right;
}

.pagenav span a {
    font           : normal 13px Tahoma, Calibri, Verdana, Geneva, sans-serif;
    border         : 1px solid #CEDFEB;
    height         : 15.99px;
    padding        : 2px 4px;
    margin-left    : 1px;
    background     : #EEF9E4 none;
    text-decoration: none;
    color          : #417394;
}

.pagenav span a:hover {
    border: 1px solid #417394;
}

.pagenav span.prev_next a,
.pagenav span.first_last a {
    position: relative;
    top     : -2px;
}

.pagenav span.prev_next a img,
.pagenav span.first_last a img {
    position: relative;
    display : inline;
    top     : 3px;
}

.pagenav span.selected a {
    background : #759FBB;
    color      : #FFFFFF;
    border     : 1px solid #417394;
    height     : 15.99px;
    font-weight: bold;
    padding    : 2px 4px;
    margin-left: 1px;
}

.pagenav .separator {
    background: #EEF9E4 none;
    border    : 1px solid #CEDFEB;
    height    : 15.99px;
    color     : #417394;
    padding   : 2px;
    top       : -3px;
    position  : relative;
}