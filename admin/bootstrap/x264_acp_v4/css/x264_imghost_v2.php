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
#img_no{
	width:500px;
	text-align:center;
	margin:auto;
	padding:150px 0 200px 0;
	font-size:15px;
	font-weight:bold;
}
#img_form{
	display:none;
	position:absolute;
	width:702px;
	height:125px;
	margin:10px 0 0 105px;
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	z-index:100;
}
#img_info_pop{
	display:none;
	position:absolute;
	width:682px;
	height:105px;
	margin:10px 0 0 105px;
	padding:10px;
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	z-index:100;
}
#img_info{
	width:654px;
	height:22px;
	line-height:22px;
	float:left;
	margin:10px 0 5px 20px;
	padding:0 0 0 10px;
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}

#img_big_wrap{
	width:25%;
	height:60%;	
	padding-bottom:14px;
	margin-top:10px;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}

.img_big_wrap{
	width:913px;
	height:386px;
	padding-bottom:14px;
	margin-top:10px;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.img_wrap{
	width:165px;
	height:165px;
	float:left;
	margin:14px 0 0 14px;
	text-align:center;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
#img_upload{
	float:right;
	width:110px;
	margin:2px 0 0 0;
	text-align:right;
}
#img_info_but{
	float:left;
	width:180px;
	margin:2px 0 0 0;
	text-align:left;
}
#img_size_view_w{	
	width:920px;
	margin:50px 0 0 2px;
}
#img_size_view_ww{
	width:302px;
	height:17px;
	float:left;
	padding:2px 0 0 2px;
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
#img_size_view{
	background-image:url(../loadbarbg.png);
	width:300px;
	height:15px;	
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
#img_size_view_b{
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
}
.img_but_wrap{
	position:absolute;
	width:60px;
	height:20px;
	margin:2px 0 0 2px;
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
.img_info_bottom{
	width:161px;
	height:15px;
	position:absolute;
	margin:142px 0 0 -1px;
	line-height:13px;
	text-align:center;
	font-size:10px;
	padding-left:4px;
	cursor:help;
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
}
.img_del_but{
	background-image:url(../del_16.png);
	width:16px;
	height:16px;
	float:left;
	display:block;
	margin:2px 0 0 2px;
}
.img_edit_but{
	background-image:url(../edit_16.png);
	width:16px;
	height:16px;
	display:block;
	float:left;
	margin:2px 0 0 2px;
}
.img_info_but{
	background-image:url(../img-info.png);
	width:16px;
	height:16px;
	display:block;
	float:left;
	margin:2px 0 0 2px;
}
#img_big_picture{
	display:none;
	position:fixed;
	width:580px;
	height:445px;
	padding:20px;
	margin:-50px 0 0 130px;
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	z-index:3000;
}
#img_big_pic_a{
	width:200px;
	height:200px;
	text-align:center;
	float:left;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
#img_big_pic_b{
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
#img_big_pic_edit{
	position:absolute;
	margin:22px 0 0 90px;
	width:400px;
	height:400px;
	text-align:center;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
#trans_flip{
	background-image:url(../flip-horizontal.png);
	width:48px;
	height:48px;
	display:block;
	position:absolute;
	margin:25px 0 0 10px;
}
#trans_flop{
	background-image:url(../flip-vertical.png);
	width:48px;
	height:48px;
	display:block;
	position:absolute;
	margin:125px 0 0 10px;
}
#trans_gray{
	background-image:url(../trans-color-icon.png);
	width:48px;
	height:48px;
	display:block;
	position:absolute;
	margin:250px 0 0 10px;
}

#trans_gray_b{
	background-image:url(../trans-color-back-icon.png);
	width:48px;
	height:48px;
	display:block;
	position:absolute;
	margin:375px 0 0 10px;
}

#trans_save{
	background-image:url(../save-mail.png);
	width:48px;
	height:48px;
	display:block;
	position:absolute;
	margin:375px 0 0 520px;
}
#trans_save_kopie{
	background-image:url(../save-kopie.png);
	width:48px;
	height:48px;
	display:block;
	position:absolute;
	margin:250px 0 0 520px;
}
#trans_save_info{
	position:absolute;
	margin:435px 0 0 90px;
	font-weight:bold;
	color:green;
}
#trans_save_info_a{
	position:absolute;
	margin:435px 0 0 90px;
	font-weight:bold;
	color:green;
}
#trans_save_info_b{
	position:absolute;
	margin:435px 0 0 90px;
	font-weight:bold;
	color:red;
}
#trans_loader{
	background-image:url(../ajax-loader.gif );
	width:126px;
	height:22px;
	position:absolute;
	margin:200px 0 0 230px;
}























