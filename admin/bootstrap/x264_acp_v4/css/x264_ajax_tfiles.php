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

.stepcarousel{
	position: relative;
	border: 1px solid black;
	overflow: scroll;
	height: 251px;
}

.stepcarousel .belt{
	position: absolute;
	margin-left: auto;
	margin-right: auto;
}

.stepcarousel{
	margin-left: auto;
	margin-right: auto;;
	overflow: hidden;
	margin: 10px;
	width: 920px;
}

.panel{
	margin-left: auto;
	margin-right: auto;
	overflow: hidden;
	margin: 10px;
	width: 940px;
}

#mygallery {
	margin-left: auto;
	margin-right: auto;
	overflow: hidden;
}

.x264_wrapper_ajax_tfiles{
	width:77%;
	height:195px;
	border:1px inset 0 0 6px rgba(19, 19, 19, 1);
	background-color: rgba(20,20,20,1);
	text-align:left;
	margin:auto;
	margin-bottom:20px;
	padding:10px;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	border:none 5px #49c1f4;
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
	border-bottom-left-radius: 15px;
	border-bottom-right-radius: 15px;
	border-top: 1px solid #000;
	border-left: 1px solid #000;
	border-right: 1px solid #000;
	border-bottom: 1px solid #000;
	z-index: 1;
}

.x264_ajax_tfiles_inp{
	width:440px;
	background-color: rgb(19,19,19);
	display:block;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	text-align:center;
	margin:0 auto 8px auto;
    border:inherit 6px #000000;
    -moz-border-radius-topleft: 0px;
    -moz-border-radius-topright:5px;
    -moz-border-radius-bottomleft:0px;
    -moz-border-radius-bottomright:5px;
    -webkit-border-top-left-radius:0px;
    -webkit-border-top-right-radius:5px;
    -webkit-border-bottom-left-radius:0px;
    -webkit-border-bottom-right-radius:5px;
    border-top-left-radius:0px;
    border-top-right-radius:5px;
    border-bottom-left-radius:0px;
    border-bottom-right-radius:5px;
    -moz-box-shadow: 0px 1px 9px #000000;
    -webkit-box-shadow: 0px 1px 9px #000000;
    box-shadow: 0px 1px 9px #000000;	
}

.x264_ajax_tfiles_br{
	height:15px;
}

#aktuell_overall{
	position:fixed;
	margin:195px 0 0 32px;
}
.to_img_link{
	width:88px;
	height:89px;
	margin-left: auto;
	margin-right: auto;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
}
/*Button oben mit slide nach unten und etwas nach außen*/
ul.top-ul, ul.top-ul ul {padding:0; margin:0; list-style:none; width:100px; font-family:arial, sans-serif;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}
/*Button oben*/
ul.top-ul{width:0px; height:0px; position:relative; z-index:100;}
/*Button oben*/
ul.top-ul li.top-li {width:0px; height:0px; float:left; position:relative;}
ul.top-ul li.top-li a.top-a {
	display:block; 
	position:absolute; 
	margin:36px 0 0 -25px; 
	text-decoration:none;
	background-image:url(../images/new_ups.png);
	display:block;
	width:24px;
	height:105px;
}
/*breite ohne inhalt*/
ul.top-ul li.top-li div.drop {height:0; overflow:hidden; left:-1px; top:20px; width:970px; position:absolute; z-index:500;
-o-transition: height 1s ease-in-out;
-moz-transition: height 1s ease-in-out;
-webkit-transition: height 1s ease-in-out;
}

/*hintergrund von oben nach unten*/
ul.top-ul li.top-li div.drop em {
	display:block; width:960px; margin-left:3px;height:210px; opacity:0.9;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;

}

/*menü slider nach unten top:-1000px; = geschwindigkeit von oben border:1px dotted blue;*/
ul.top-ul li.top-li div.drop ul.drop-ul {
	position:absolute;
	left:15px; 
	top:-120px;
	margin-top:10px;
	border:1px inset 0 0 6px rgba(0,0,0,0.8); 
	padding-bottom:10px;
-o-transition: 1s ease-in-out;
-moz-transition: 1s ease-in-out;
-webkit-transition: all 1s ease-in-out;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
}

/* menü wo canon steht*/
ul.top-ul li.top-li div.drop ul.drop-ul li.drop-li {
	position:relative; width:100px; height:100px; float:left; z-index:100;}
/* menü wo canon steht der link noch nicht zu sehen*/
ul.top-ul li.top-li div.drop ul.drop-ul li.drop-li a.drop-a {
	display:block; width:100px; float:left; text-decoration:none; line-height:16px;}
/* menü wo canon steht das bild noch nicht zu sehen*/
ul.top-ul li.top-li div.drop ul.drop-ul li.drop-li a.drop-a img {
	display:block; 
	border:0; 
	position:absolute; 
	margin:20px 0 0 20px; 
	z-index:-1; 
	opacity:1;
-o-transition: 0.4s ease-in-out;
-moz-transition: 0.4s ease-in-out;
-webkit-transition: all 0.4s ease-in-out;
}
/* menü wo canon steht*/
ul.top-ul li.top-li div.drop ul.drop-ul li.drop-li a b {
	display:block; 
	width:100px;height:60px; 
	padding-top:90px; 
	text-align:center; 
	cursor:pointer; 
	font-weight:normal; 
	opacity:0; 
-o-transition: 0.4s ease-in-out;
-moz-transition: 0.4s ease-in-out;
-webkit-transition: all 0.4s ease-in-out;
}
/* menü wo canon steht*/
ul.top-ul li.top-li:hover div.drop ul.drop-ul li.drop-li:hover > a img {opacity:0.5;}
/* menü wo canon steht*/
ul.top-ul li.top-li:hover div.drop ul.drop-ul li.drop-li:hover > a b {opacity:1;}
/* menü wo canon steht*/
ul.top-ul li.top-li:hover div.drop {height:212px;} /*check*/
/* menü wo canon steht*/
ul.top-ul li.top-li:hover div.drop:hover {height:212px;} /*check*/
/* menü wo canon steht*/
ul.top-ul li.top-li:hover div.drop ul.drop-ul {top:0;}
/* border:1px dotted blue;########################################*/
ul.top-ul li.top-li div.drop ul.drop-ul div.fly {position:absolute; left:100px; top:-1px; width:0; height:113px; overflow:hidden;
-o-transition: width 1s ease-in-out;
-moz-transition: width 1s ease-in-out;
-webkit-transition: width 1s ease-in-out;
}
/* border:1px dotted blue;##############################################*/
ul.top-ul li.top-li div.drop ul.drop-ul div.fly ul.fly-ul {
	position:absolute; 
	left:-920px; 
	top:10px; 
	width:820px; 
	height:90px; 
	padding-right:10px;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
-o-transition: 1s ease-in-out;
-moz-transition: 1s ease-in-out;
-webkit-transition: all 1s ease-in-out;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
}
/* border:1px dotted blue;*/

ul.top-ul li.top-li div.drop ul.drop-ul div.fly ul.fly-ul li.fly-li {
	float:left; 
	position:relative; 
	height:90px; 
	z-index:100;
}
/* border:1px dotted blue;*/
ul.top-ul li.top-li div.drop ul.drop-ul div.fly ul.fly-ul li.fly-li a.fly-a {
	display:block; 
	width:56px; 
	height:80px;
	float:left; 
	text-decoration:none; 
	margin:5px 0 0 5px;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
}
/* border:1px dotted blue;*/
ul.top-ul li.top-li div.drop ul.drop-ul div.fly ul.fly-ul li.fly-li a.fly-a img {
	display:block; 
	border:0; 
	position:absolute;
	z-index:-1; 
	opacity:1;
-o-transition: 0.4s ease-in-out;
-moz-transition: 0.4s ease-in-out;
-webkit-transition: all 0.4s ease-in-out;
}
/* border:1px dotted blue;*/
ul.top-ul li.top-li div.drop ul.drop-ul div.fly ul.fly-ul li.fly-li a.fly-a b {
	display:block; 
	height:65px; 
	text-align:center; 
	font-size:12px; 
	padding-top:35px; 
	opacity:0;
-o-transition: 0.4s ease-in-out;
-moz-transition: 0.4s ease-in-out;
-webkit-transition: all 0.4s ease-in-out;
}
/* border:1px dotted blue;*/
ul.top-ul li.top-li:hover div.drop ul.drop-ul li.drop-li:hover div.fly {width:915px;}
/* border:1px dotted blue;*/
ul.top-ul li.top-li:hover div.drop ul.drop-ul li.drop-li:hover div.fly ul.fly-ul {left:0;}
/* border:1px dotted blue;*/
ul.top-ul li.top-li:hover div.drop ul.drop-ul li.drop-li:hover div.fly ul.fly-ul li:hover > a img {opacity:0.5;}
/* border:1px dotted blue;*/
ul.top-ul li.top-li:hover div.drop ul.drop-ul li.drop-li:hover div.fly ul.fly-ul li:hover > a b {opacity:1;}

#in_em_1, #in_em_2, #in_em_3, #in_em_4, #in_em_5, #in_em_6, #in_em_7, #in_em_8, #in_em_9, #in_em_10, #in_em_11, #in_em_12, #in_em_13{
	display:none;
	position:absolute;
	margin:102px 0 0 102px;
	width:820px;
	height:240px;
}
.in_em_info{
	width:320px;
	height:180px;
	margin:2px 0 0 95px;
	margin-left: auto;
	margin-right: auto;	
}
.in_em_info2{
	width:320px;
	height:180px;
	margin:2px 0 0 95px;
	float:right;	
}
.in_em_info_name{
	font-size:14px;
	font-weight:bold;
	margin:3px 0 0 0;
}
.in_em_info_name_b{
	font-size:12px;
	font-weight:bold;
	margin:3px 0 0 0;
}
.in_em_info_cat{
	position:absolute;
	margin:7px 0 0 5px;
}
.in_em_info_name_b span{
    display:block;
	width:100px;
	float:left;
}
.send_fly{
	margin:15px 0 0 4px;
}

#kat_haupt_wrap, #kat_cat_wrap, #kat_cat_wrapp{
border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	padding:20px;
	width:700px;
	margin:auto;
}
#kat_set_color_wrap{
	position:absolute;
	margin:0 0 0 600px;
}
#style_hand_kat{
	position:absolute;
	width:24px;
	height:24px;
	margin:-15px 0 0 580px;
	cursor:pointer;
}
.kat_cat_pic_name{
	margin:2px 0 0 0;
	text-align:center;
	font-weight:bold;
	font-size:13px;
	color: #000000;
	line-height:16px;
	text-shadow: 1px 1px 0px #eee;
	height:16px;
}
.kat_cat_pic_name_b{
	text-align:center;
	font-size:10px;
	line-height:120px;
	text-shadow: 1px 1px 0px #000;
	height:120px;
	color:#fff;
}
.kat_er_wrap{
	margin:4px 0 0 14px;
	width:100px;
	height:40px;
	font-weight:bold;
	line-height:38px;
	float:left;
}
.back_cat_wrap{
	float:left;
}
.kat_cat_pic{
	position:absolute;
	background-image:url(../images/cat_pic.png);
	background-repeat:no-repeat;
	width:120px;
	height:185px;
	margin-left: auto;
	margin-right: auto;
}
.back_cat_pic{
	position:absolute;
	width:73px;
	height:35px;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	margin:2px 0 0 3px;
}
#back_cat_pic_change{
	position:absolute;
	width:73px;
	height:35px;
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	margin:2px 0 0 3px;
}
.kat_h_wr{
	width:100px;
	margin:10px 0 0 14px;
	float:left;
}
.kat_sort_button{
	background-image:url(../images/cat_pic.png);
	width:80px;
	height:40px;
	display:block;
	float:left;
	text-align:center;
	line-height:35px;
	margin:0 0 0 14px;
	text-shadow: 1px 1px 0px #000;
}
#popup_noch_to{
    position:absolute;
    margin:300px 0 0 200px;
	width:256px;
	height:200px;
border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
    padding:10px;
	text-align:center;
	z-index:100;
}
.cat_xxx_fil{
	width:250px;
	height:24px;
	line-height:24px;
	padding-left:10px;
	margin-top:5px;
	font-weight:bold;
border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}

