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
.x264_pm_system_user {
	float: left;
	width:50%;
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	border:none 5px #000000;
	-moz-border-radius: 21px;
	-webkit-border-radius: 21px;
	border-radius: 21px;
	text-align:center;
}

.x264_pm_system_staff {
	float: left;
	width:25%;
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	border:none 5px #000000;
	-moz-border-radius: 21px;
	-webkit-border-radius: 21px;
	border-radius: 21px;
	text-align:center;
}

.x264_pm_display_2k16 { 
	border: 1px solid rgba(15,15,15,0.4); 
	border-radius: 5px;
	background: #131313;
	color: #fff;
	font: 12px/1.5 "Lucida Sans","Lucida Grande", Lucida, sans;
	padding: 8px;
	box-shadow: 
		0px 1px 9px rgba(0,0,0,0.8), 
		inset 0 1px 0 rgba(255,255,255,0.2), 
		inset 0 -1px 0 rgba(255,255,255,0.1), 
		inset 1px 0 0 rgba(255,255,255,0.1),
		inset -1px 0 0 rgba(255,255,255,0.1);
	position: relative;
	-webkit-transition: all 0.2s linear;
	-webkit-animation: popItIn .3s ease-in-out 0s;
}

/*pseudo elements*/

	
	/*logo*/
	.x264_pm_display_2k16:after {
		position: absolute;
		width: 4px;
		height: 4px;
		border-radius: 50%;
		background-color: #999;
		background-image: -webkit-linear-gradient(top, rgba(0,0,0,.2) 10%, rgba(0,0,0,.7) 55%,rgba(0,0,0,.3) 100%);
		left: 49%;
		top: auto;
		bottom: 3px;
	}
	
	#emergency.x264_pm_display_2k16:after {
		background-color: red;
	}

/* x264_pm_display_2k16_glossy shine */
.x264_pm_display_2k16_gloss {
	position: absolute;
	width: 105%;
	height: 100%;
	left: -9px;
	top: -9px;
	z-index: 4;
	border-radius: 5px;
	background: -webkit-linear-gradient(25deg, rgba(255,255,255,0) 0%,rgba(255,255,255,0) 59%,rgba(255,255,255,0.2) 59%, rgba(255,255,255,0) 100%) no-repeat;
	-webkit-mask-image: -webkit-linear-gradient(top, rgba(0,0,0,1) 0%, rgba(0,0,0,0.2) 40%, rgba(0,0,0,0.1) 75%, rgba(0,0,0,0) 90%, rgba(0,0,0,0) 100%);
	-webkit-animation: fuckYeahx264_pm_display_2k16_gloss .5s ease-in-out 0s;
}

/*display area*/
.x264_pm_display_2k16 > div {
	background-color: #666;
	background-image: -webkit-linear-gradient(top, rgba(0,0,0,0.6) 0%,rgba(0,0,0,0) 100%);
	padding: 6px;
	border: 1px solid #000;
	box-shadow: 
		inset 0 1px 0 rgba(255,255,255,0.01),
		inset 0 -1px 3px rgba(255,255,255,0.1),
		inset 1px 0 2px rgba(255,255,255,0.05), 
		inset -1px 0 2px rgba(255,255,255,0.05);
	position: relative;
	-webkit-transition: all 0.2s linear;
}
	
	/*display bottom glow*/
	.x264_pm_display_2k16 > div:before {
		position: absolute;
		background: -webkit-radial-gradient(bottom, ellipse cover, rgba(0, 142, 189, .1) 0%, rgba(125,185,232,.15) 50%, rgba(125,185,232,0) 100%);
	}
	
	#emergency.x264_pm_display_2k16 > div:before {
		background: -webkit-radial-gradient(bottom, ellipse cover, rgba(135, 0, 0, .45) 0%, rgba(135, 0, 0, .2) 50%, rgba(135, 0, 0, 0) 100%);
	}

.x264_pm_display_2k16:hover {
	box-shadow: 
		0px 1px 15px rgba(0,0,0,0.9), 
		inset 0 1px 0 rgba(255,255,255,0.25), 
		inset 0 -1px 0 rgba(255,255,255,0.15), 
		inset 1px 0 0 rgba(255,255,255,0.15),
		inset -1px 0 0 rgba(255,255,255,0.15);
}

.x264_pm_display_2k16:hover > div {
	background-color: #777;
}

.x264_pm_display_2k16_icon {
	float: left;
	margin: 0 10px 0 0;
	display: block;
	text-align: center;
	line-height: 36px;
	width: 36px;
	height: 36px;
	overflow: hidden;
	background-repeat: no-repeat;
	background-position: center center;
	background: none !important;
	border-radius: 4px;
}
.x264_pm_display_2k16_icon img{
	max-width: 36px;
	min-width: 36px;
	max-height: 36px;
	min-height: 36px;
	vertical-align: middle;
	margin: 0;
	padding: 0;
	float: left;
}

.x264_pm_display_2k16_title,
.x264_pm_display_2k16_message,
.x264_pm_display_2k16_icon {
	position: relative;
	z-index: 5;
}

.x264_pm_display_2k16_title {
	font-size: 13px;
	margin: 0 0 2px 0;
	padding: 0 0 0 48px;
	color: #fff;
	text-shadow: 0 1px 0 #000;
	-webkit-transition: all 0.2s linear;
	position: relative;
	-webkit-mask-image: -webkit-linear-gradient(top, rgba(0,0,0,1) 30%,rgba(0,0,0,.6) 65%,rgba(0,0,0,1) 100%);
	background-clip: text;
}

.x264_pm_display_2k16_message {
	padding: 0 0 0 48px;
	margin: 0;
	color: #000;
	text-shadow: 0 1px 0 rgba(255,255,255,0.1);
}


/* Animations */

@-webkit-keyframes popItIn {
  0% {
	top: -100px;
	opacity: 0;
  }
  100% { 
   	top: 0;
   	opacity: 1;
  }
}

@-webkit-keyframes fuckYeahx264_pm_display_2k16_gloss {
	0% { 
		background-position: 0 -100px;
	}
	100% { 
		background-position: 0 0;
	}
}
