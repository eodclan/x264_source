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
.menu {
  display: inline-block;
}
x264_tbody {
	padding: 40px;
	background-attachment: fixed;
	background-position: 50% 0;
	background-size: cover;	
}
@media screen and (max-width: 1000px) {
	x264_tbody {
		padding: 20px;
	}
}
@media screen and (max-width: 767px) {
	x264_tbody {
		padding: 10px;
	}
	aside {
		width: auto;
	}
}
.x264_lnavi {
border: 1px inset 0 0 6px rgba(19,19,19,1);
    background: url(../images/tcatRight.png);
    background-repeat: repeat-x;
    text-align: left;
    margin: auto;
    margin-bottom: 20px;
    padding: 10px;
    -webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
    box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
    border: none 5px #49c1f4;
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

#x264_lnavi {
border: 1px inset 0 0 6px rgba(19,19,19,1);
    background: url(../images/tcatRight.png);
    background-repeat: repeat-x;
    text-align: left;
    margin: auto;
    margin-bottom: 20px;
    padding: 10px;
    -webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
    box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
    border: none 5px #49c1f4;
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

.x264_tnavi {
top:-10px;
	width:98,5%;
	height: 34px;
	background: url(../images/tcatRight.png);
	background-repeat:repeat-x;
	background-color: rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	border:none 5px #000000;
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
	border-bottom-left-radius: 15px;
	border-bottom-right-radius: 15px;
	border-radius:15px 15px 15px 15px;
	border-top: 1px solid #000000;
	border-left: 1px solid #000000;
	border-right: 1px solid #000000;
	border-bottom: 1px solid #000;
}

/**/
/* defaults */
/**/
.x264_mega_menu,
.x264_mega_menu * {
	margin: 0;
	padding: 0;
	outline: none;
	border: 0;
	background: none;
}
.x264_mega_menu {
	font: normal normal 17px BebasNeueRegular,Arial,sans-serif;
}


/**/
/* level 1 */
/**/
.x264_mega_menu {
	position: relative;
	font: normal normal 17px BebasNeueRegular,Arial,sans-serif;
	z-index: 999;
	line-height: 0;
	text-align: right;
}
.x264_mega_menu:after {
	content: '';
	display: table;
	clear: both;
}
.x264_mega_menu li {
	position: relative;
	display: inline-block;
	float: left;
	padding: 5px;
	border-style: solid;
	border-color: rgba(0,0,0,.1);
	border-right-width: 1px;
	line-height: 45px;
	text-align: left;
	white-space: nowrap;
}
.x264_mega_menu li a {
	display: block;
	padding: 0 20px;
	text-decoration: none;
	color: #666;
	transition: background 0.4s, color 0.4s;
	-o-transition: background 0.4s, color 0.4s;
	-ms-transition: background 0.4s, color 0.4s;
	-moz-transition: background 0.4s, color 0.4s;
	-webkit-transition: background 0.4s, color 0.4s;
}
.x264_mega_menu li > div {
	position: absolute;
	z-index: 1000;
	top: 100%;
	left: -9999px;
	margin-top: 8px;
	background-repeat:repeat-x;
	background-color: rgba(20,20,20,1);
	box-shadow: 0 0 8px rgba(0,0,0,.3);
	opacity: 0;
	-o-transform-origin: 0% 0%;
	-ms-transform-origin: 0% 0%;
	-moz-transform-origin: 0% 0%;
	-webkit-transform-origin: 0% 0%;
	-o-transition: -o-transform 0.4s, opacity 0.4s;
	-ms-transition: -ms-transform 0.4s, opacity 0.4s;
	-moz-transition: -moz-transform 0.4s, opacity 0.4s;
	-webkit-transition: -webkit-transform 0.4s, opacity 0.4s;
}
.x264_mega_menu li > div:after {
	content: '';
	position: absolute;
	bottom: 100%;
	left: 0;
	width: 100%;
	height: 8px;
	background: transparent;	
}
.x264_mega_menu li > div:before {
	content: '';
	position: absolute;
	bottom: 100%;
	left: 24px;
	border-right: 5px solid transparent;
	border-bottom: 5px solid rgba(20,20,20,1);
	border-left: 5px solid transparent;
}
.x264_mega_menu li:hover > a,
.x264_mega_menu li.current > a {
	background: transparent;
	background: url(../images/navtab_selected.png) no-repeat bottom center;
	color: #fff;
}
.x264_mega_menu li:hover > div {
	left: 0;
	opacity: 1;
	-webkit-transform: translate(0, 0);
}
.x264_mega_menu .right {
	float: none;
	border-right-width: 0;
	border-left-width: 1px;
}
.x264_mega_menu .right > div {
	-o-transform-origin-x: 100%;
	-ms-transform-origin-x: 100%;
	-moz-transform-origin-x: 100%;
	-webkit-transform-origin-x: 100%;
}
.x264_mega_menu .right:hover > div {
	right: 0;
	left: auto;
}
.x264_mega_menu .right:hover > div:before {
	right: 24px;
	left: auto;
}
.x264_mega_menu .switcher {
	display: none;
}


/**/
/* level 2+ */
/**/
.x264_mega_menu li li {
	display: block;
	float: none;
	border-width: 0;
	border-top-width: 1px;
	line-height: 21px;
	white-space: normal;
}
.x264_mega_menu li li:first-child {
	border-top: 0;
}
.x264_mega_menu li li a {
	padding-top: 12px;
	padding-bottom: 12px;
}
.x264_mega_menu li li > div {
	top: 0;
	margin: 0 0 0 8px;
}
.x264_mega_menu li li > div:after {
	top: 0;
	right: 100%;
	bottom: auto;
	left: auto;
	width: 8px;
	height: 100%;
}
.x264_mega_menu li li > div:before {
	top: 22px;
	right: 100%;
	bottom: auto;
	left: auto;
	border-top: 5px solid transparent;
	border-right: 5px solid transparent;
	border-bottom: 5px solid transparent;
}
.x264_mega_menu li li:hover > div {
	left: 100%;
}
.x264_mega_menu .right li > div {
	margin: 0 8px 0 0;
	-o-transform-origin-x: 100%;
	-ms-transform-origin-x: 100%;
	-moz-transform-origin-x: 100%;
	-webkit-transform-origin-x: 100%;
}
.x264_mega_menu .right li > div:after {
	right: auto;
	left: 100%;
}
.x264_mega_menu .right li > div:before {
	right: auto;
	left: 100%;
	border-right: none;
	border-left: 5px solid transparent;
}
.x264_mega_menu .right li:hover > div {
	right: 100%;
	left: auto;
}


/**/
/* positions */
/**/
.x264_mega_menu-fixed {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
}
.x264_mega_menu-pos-bottom li > div {
	top: auto;
	bottom: 100%;
	margin: 0 0 8px;
	-o-transform-origin-y: 100%;
	-ms-transform-origin-y: 100%;
	-moz-transform-origin-y: 100%;
	-webkit-transform-origin-y: 100%;
}
.x264_mega_menu-pos-bottom li > div:after {
	top: 100%;
	bottom: auto;
}
.x264_mega_menu-pos-bottom li > div:before {
	top: 100%;
	bottom: auto;
	border-top: 5px solid transparent;
	border-right: 5px solid transparent;
	border-bottom: none;
	border-left: 5px solid transparent;
}
.x264_mega_menu-pos-bottom li li > div {
	top: auto;	
	bottom: 0;
}
.x264_mega_menu-pos-bottom li li > div:before {
	top: auto;
	bottom: 22px;
}
.x264_mega_menu-pos-bottom.x264_mega_menu-fixed {
	top: auto;
	bottom: 0;
}

.x264_mega_menu-pos-left li,
.x264_mega_menu-pos-right li {
	display: block;
	float: none;
	border-width: 0;
	border-top-width: 1px;
}
.x264_mega_menu-pos-left li:first-child,
.x264_mega_menu-pos-right li:first-child {
	border-top: 0;
}
.x264_mega_menu-pos-left li > div,
.x264_mega_menu-pos-right li > div {
	top: 0;	
}
.x264_mega_menu-pos-left li > div {
	margin: 0 0 0 8px;
}
.x264_mega_menu-pos-right li > div {
	margin: 0 8px 0 0;
	-o-transform-origin-x: 100%;
	-ms-transform-origin-x: 100%;
	-moz-transform-origin-x: 100%;
	-webkit-transform-origin-x: 100%;
}
.x264_mega_menu-pos-left li > div:after,
.x264_mega_menu-pos-right li > div:after {
	top: 0;
	bottom: auto;
	width: 8px;
	height: 100%;
}
.x264_mega_menu-pos-left li > div:after {
	right: 100%;
	left: auto;
}
.x264_mega_menu-pos-right li > div:after {
	right: auto;
	left: 100%;
}
.x264_mega_menu-pos-left li > div:before,
.x264_mega_menu-pos-right li > div:before {
	top: 22px;
	bottom: auto;
	border-top: 5px solid transparent;
	border-bottom: 5px solid transparent;
}
.x264_mega_menu-pos-left li > div:before {
	right: 100%;
	left: auto;
	border-right: 5px solid transparent;
}
.x264_mega_menu-pos-right li > div:before {
	right: auto;
	left: 100%;
	border-left: 5px solid transparent;
}
.x264_mega_menu-pos-left li:hover > div {
	left: 100%;
}
.x264_mega_menu-pos-right li:hover > div {
	right: 100%;
	left: auto;
}
.x264_mega_menu-pos-left .bottom > div,
.x264_mega_menu-pos-right .bottom > div {
	top: auto;
	bottom: 0;
	-o-transform-origin-y: 100%;
	-ms-transform-origin-y: 100%;
	-moz-transform-origin-y: 100%;
	-webkit-transform-origin-y: 100%;
}
.x264_mega_menu-pos-left .bottom > div:before,
.x264_mega_menu-pos-right .bottom > div:before {
	top: auto;
	bottom: 22px;
}
.x264_mega_menu-pos-right li li > div {
	margin: 0 8px 0 0;
	-o-transform-origin-x: 100%;
	-ms-transform-origin-x: 100%;
	-moz-transform-origin-x: 100%;
	-webkit-transform-origin-x: 100%;
}
.x264_mega_menu-pos-right li li > div:after {
	right: auto;
	left: 100%;
}
.x264_mega_menu-pos-right li li > div:before {
	right: auto;
	left: 100%;
	border-right: none;
	border-left: 5px solid transparent;
}
.x264_mega_menu-pos-right li li:hover > div {
	right: 100%;
	left: auto;
}
.x264_mega_menu-pos-left.x264_mega_menu-fixed {
	top: 0;
	right: auto;
	bottom: 0;
	left: 0;
	width: auto;
}
.x264_mega_menu-pos-right.x264_mega_menu-fixed {
	top: 0;
	right: 0;
	bottom: 0;
	left: auto;
	width: auto;
}


/**/
/* animations */
/**/
.x264_mega_menu-anim-slide li > div {
	-o-transform: translate(0, 60px);
	-ms-transform: translate(0, 60px);
	-moz-transform: translate(0, 60px);
	-webkit-transform: translate(0, 60px);	
}
.x264_mega_menu-pos-bottom.x264_mega_menu-anim-slide li > div {
	-o-transform: translate(0, -60px);
	-ms-transform: translate(0, -60px);
	-moz-transform: translate(0, -60px);
	-webkit-transform: translate(0, -60px);
}
.x264_mega_menu-anim-slide li:hover > div {
	-o-transform: translate(0, 0);
	-ms-transform: translate(0, 0);
	-moz-transform: translate(0, 0);
	-webkit-transform: translate(0, 0);	
}
.x264_mega_menu-anim-scale li > div {
	-o-transform: scale(0, 0);
	-ms-transform: scale(0, 0);
	-moz-transform: scale(0, 0);
	-webkit-transform: scale(0, 0);
}
.x264_mega_menu-anim-scale li:hover > div {
	-o-transform: scale(1, 1);
	-ms-transform: scale(1, 1);
	-moz-transform: scale(1, 1);
	-webkit-transform: scale(1, 1);
}
.x264_mega_menu-anim-flip {
	perspective: 2000px;
	-o-perspective: 2000px;
	-moz-perspective: 2000px;
	-webkit-perspective: 2000px;
}
.x264_mega_menu-anim-flip li > div {
	transform-style: preserve-3d;
	-o-transform: preserve-3d;
	-moz-transform-style: preserve-3d;
	-webkit-transform-style: preserve-3d;
	transform: rotateX(-75deg);
	-o-transform: rotateX(-75deg);
	-moz-transform: rotateX(-75deg);
	-webkit-transform: rotateX(-75deg);
}
.x264_mega_menu-anim-flip li:hover > div {
	transform: rotateX(0deg);
	-o-transform: rotateX(0deg);
	-moz-transform: rotateX(0deg);
	-webkit-transform: rotateX(0deg);
}


/**/
/* grid */
/**/
.x264_mega_menu .grid-column {
	float: left;
	background: transparent;
	border-left-width: 1px;
	border-left-style: solid;
}
.x264_mega_menu .grid-column:first-child {
	margin-left: 0;
	border-left: 0;
}
.x264_mega_menu .grid-column2,
.x264_mega_menu .grid-container2 {
	width: 155px;
}
.x264_mega_menu .grid-column3,
.x264_mega_menu .grid-container3 {
	width: 233px;
}
.x264_mega_menu .grid-column4,
.x264_mega_menu .grid-container4 {
	width: 311px;
}
.x264_mega_menu .grid-column5,
.x264_mega_menu .grid-container5 {
	width: 389px;
}
.x264_mega_menu .grid-column6,
.x264_mega_menu .grid-container6 {
	width: 467px;
}
.x264_mega_menu .grid-column7,
.x264_mega_menu .grid-container7 {
	width: 545px;
}
.x264_mega_menu .grid-column8,
.x264_mega_menu .grid-container8 {
	width: 623px;
}
.x264_mega_menu .grid-column9,
.x264_mega_menu .grid-container9 {
	width: 701px;
}
.x264_mega_menu .grid-column10,
.x264_mega_menu .grid-container10 {
	width: 779px;
}
.x264_mega_menu .grid-column11,
.x264_mega_menu .grid-container11 {
	width: 857px;
}
.x264_mega_menu .grid-column12,
.x264_mega_menu .grid-container12 {
	width: 935px;
}


/**/
/* icons */
/**/
.x264_mega_menu li a > .fa {
	display: block;
	float: left;
	width: 16px;
	margin: 0 10px 0 -4px;
  line-height: inherit;
  text-align: center;
}
.x264_mega_menu li a > .fa-single {
	float: none;
	margin: 0;
}
.x264_mega_menu li a > .fa-indicator {
	position: relative;
	top: -1px;
	float: none;
	display: inline-block;
	vertical-align: middle;
	width: auto;
	margin: 0 -10px 0 10px;
	font-size: 9px;
	line-height: 1;
	text-align: right;
}
.x264_mega_menu li li a > .fa-indicator {
	top: 0;
	float: right;
	display: block;
	line-height: inherit;
}


/**/
/* forms */
/**/
.x264_mega_menu form fieldset {
	display: block;	
	padding: 25px 30px;
}
.x264_mega_menu form fieldset + fieldset {
	border-top: 1px solid rgba(0,0,0,.1);
}
.x264_mega_menu form section {
	margin-bottom: 20px;
}
.x264_mega_menu form .input,
.x264_mega_menu form .textarea,
.x264_mega_menu form .radio,
.x264_mega_menu form .checkbox,
.x264_mega_menu form .button {
	position: relative;
	display: block;
}
.x264_mega_menu form .input input,
.x264_mega_menu form .textarea textarea {
	display: block;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	width: 100%;
	height: 39px;
	padding: 8px 10px;
	outline: none;
	border: 2px solid #e5e5e5;
	border-radius: 0;
	background: transparent;
	font: normal normal 20px BebasNeueRegular,Arial,sans-serif;
	color: #404040;
	appearance: normal;
	-moz-appearance: none;
	-webkit-appearance: none;
	transition: border-color 0.3s;
	-o-transition: border-color 0.3s;
	-ms-transition: border-color 0.3s;
	-moz-transition: border-color 0.3s;
	-webkit-transition: border-color 0.3s;
}
.x264_mega_menu form .textarea textarea {
	height: auto;
	resize: none;
}
.x264_mega_menu form .button {
	float: right;
	height: 39px;
	overflow: hidden;
	margin-left: 20px;
	padding: 0 20px;
	outline: none;
	border: 0;
	background-color: transparent;
	font: normal normal 20px BebasNeueRegular,Arial,sans-serif;
	text-decoration: none;
	color: #fff;
	cursor: pointer;
	opacity: 0.8;
	transition: opacity 0.2s;
	-o-transition: opacity 0.2s;
	-ms-transition: opacity 0.2s;
	-moz-transition: opacity 0.2s;
	-webkit-transition: opacity 0.2s;
}
.x264_mega_menu form .fa-append {
	position: absolute;
	top: 5px;
	right: 5px;
	width: 29px;
	height: 29px;
	padding-left: 3px;
	border-left: 1px solid #e5e5e5;
	line-height: 29px;
	text-align: center;
	color: #ccc;
}
.x264_mega_menu form .input .fa-append + input,
.x264_mega_menu form .textarea .fa-append + textarea {
	padding-right: 46px;
}
.x264_mega_menu form .row {
	margin: 0 -15px;
}
.x264_mega_menu form .row:after {
	content: '';
	display: table;
	clear: both;
}
.x264_mega_menu form .col {
	float: left;
	min-height: 1px;
	padding-right: 15px;
	padding-left: 15px;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
}
.x264_mega_menu form .col-6 {
	width: 50%;
}
.x264_mega_menu form .input:hover input,
.x264_mega_menu form .textarea:hover textarea,
.x264_mega_menu form .checkbox:hover i {
	border-color: #8dc9e5;
}
.x264_mega_menu form .button:hover {
	opacity: 1;
}
.x264_mega_menu form .input input:focus,
.x264_mega_menu form .textarea textarea:focus,
.x264_mega_menu form .checkbox input:focus + i {
	border-color: #2da5da;
}
.x264_mega_menu .search {
	border-left: 0;
}
.x264_mega_menu .search .input {
	margin: 3px 3px 3px 3px;
}
.x264_mega_menu .search .input input {
	width: 240px;
	padding-right: 65px;
}
.x264_mega_menu .search .button {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
}


/**/
/* pad */
/**/
@media screen and (max-width: 1000px) {
	.x264_mega_menu li a {
		padding: 0 15px;
	}
	.x264_mega_menu li a > .fa-indicator {
		margin-right: -5px;
	}
	
	.x264_mega_menu .grid-column2,
	.x264_mega_menu .grid-container2 {
		width: 117px;
	}
	.x264_mega_menu .grid-column3,
	.x264_mega_menu .grid-container3 {
		width: 176px;
	}
	.x264_mega_menu .grid-column4,
	.x264_mega_menu .grid-container4 {
		width: 235px;
	}
	.x264_mega_menu .grid-column5,
	.x264_mega_menu .grid-container5 {
		width: 294px;
	}
	.x264_mega_menu .grid-column6,
	.x264_mega_menu .grid-container6 {
		width: 353px;
	}
	.x264_mega_menu .grid-column7,
	.x264_mega_menu .grid-container7 {
		width: 412px;
	}
	.x264_mega_menu .grid-column8,
	.x264_mega_menu .grid-container8 {
		width: 471px;
	}
	.x264_mega_menu .grid-column9,
	.x264_mega_menu .grid-container9 {
		width: 530px;
	}
	.x264_mega_menu .grid-column10,
	.x264_mega_menu .grid-container10 {
		width: 589px;
	}
	.x264_mega_menu .grid-column11,
	.x264_mega_menu .grid-container11 {
		width: 648px;
	}
	.x264_mega_menu .grid-column12,
	.x264_mega_menu .grid-container12 {
		width: 707px;
	}
}


/**/
/* phone */
/**/
@media screen and (max-width: 767px) {
	x264_tbody {
    -webkit-text-size-adjust: none;
  }
	.x264_mega_menu .grid-column {
		float: none;
		width: auto;
		margin: 0;
		border: 0;
		border-top: 1px solid #d9d9d9;
	}
	.x264_mega_menu .grid-column:first-child {
		border-top: 0;
	}
  .x264_mega_menu form fieldset {
  	display: block;
  	padding: 15px 20px;
  }
	.x264_mega_menu form section {
		margin-bottom: 10px;
	}
  .x264_mega_menu form .row {
  	margin: 0 -10px;
  }
  .x264_mega_menu form .col {
		padding-right: 10px;
		padding-left: 10px;
	}
	
	
	.x264_mega_menu-response-to-stack > li {
		display: block;
		float: none;
		border: 0;
		border-top: 1px solid #d9d9d9;
	}
	.x264_mega_menu-response-to-stack > li:first-child {
		border-top: 0;
	}
	.x264_mega_menu-response-to-switcher > li {
		display: none;
		float: none;
		border: 0;
	}
	.x264_mega_menu-response-to-switcher > .switcher {
		display: block;
	}
	.x264_mega_menu-response-to-switcher:hover > li {
		display: block;
		border-top: 1px solid #d9d9d9;		
	}
	.x264_mega_menu-response-to-switcher:hover > .switcher {
		display: none;	
	}
	.x264_mega_menu-response-to-stack li > div,
	.x264_mega_menu-response-to-stack li > [class^="grid-container"],
	.x264_mega_menu-response-to-switcher li > div,
	.x264_mega_menu-response-to-switcher li > [class^="grid-container"] {
		top: 100%;
		bottom: auto;
		width: auto;
		margin: 8px 0 0 0;		
		-o-transform-origin: 0 0;
		-ms-transform-origin: 0 0;
		-moz-transform-origin: 0 0;
		-webkit-transform-origin: 0 0;
	}
	.x264_mega_menu-response-to-stack li > div:after,
	.x264_mega_menu-response-to-switcher li > div:after {
		top: auto;
		right: auto;
		bottom: 100%;
		left: 0;
		width: 100%;
		height: 8px;
	}
	.x264_mega_menu-response-to-stack li > div:before,
	.x264_mega_menu-response-to-switcher li > div:before {
		display: none;
	}
	.x264_mega_menu-response-to-stack li a > .fa,
	.x264_mega_menu-response-to-switcher li a > .fa {
		margin: 0 15px 0 0;
	}
	.x264_mega_menu-response-to-stack li:hover > div,
	.x264_mega_menu-response-to-stack li:hover > [class^="grid-container"],
	.x264_mega_menu-response-to-switcher li:hover > div,
	.x264_mega_menu-response-to-switcher li:hover > [class^="grid-container"] {
		right: 0;
		left: 51px;
	}
	.x264_mega_menu-response-to-stack li li > div,
	.x264_mega_menu-response-to-switcher li li > div {
		top: 100%;
		width: auto;
		margin: 8px 0 0 0;
	}
	.x264_mega_menu-response-to-stack li li > div:after,
	.x264_mega_menu-response-to-switcher li li > div:after {
		top: auto;
		right: auto;
		bottom: 100%;
		left: 0;
		width: 100%;
		height: 8px;
	}
	.x264_mega_menu-response-to-stack li li:hover > div,
	.x264_mega_menu-response-to-switcher li li:hover > div {
		right: 0;
		left: 51px;
	}
	.x264_mega_menu-response-to-stack .search .input input,
	.x264_mega_menu-response-to-switcher .search .input input {
		width: 100%;
	}	
	
  .x264_mega_menu-response-to-icons li {
  	position: static;
  	font-size: 0;
	}
	.x264_mega_menu-response-to-icons li a {
		padding: 0 10px;
	}
	.x264_mega_menu-response-to-icons li > div,
	.x264_mega_menu-response-to-icons li > [class^="grid-container"] {
		width: 100%;
	}
	.x264_mega_menu-response-to-icons li > div:before {
		display: none;
	}
	.x264_mega_menu-response-to-icons li a > .fa {
		margin: 0;
	}	
	.x264_mega_menu-response-to-icons li a > .fa-indicator {
		position: static;
		display: block;
		float: right;
		margin-left: 10px;
		line-height: 45px;
	}
	.x264_mega_menu-response-to-icons li li {
		position: relative;
		font-size: 13px;
	}
	.x264_mega_menu-response-to-icons li li > div,
	.x264_mega_menu-response-to-icons .right li > div {
		top: 100%;
		margin: 8px 0 0 0;
	}
	.x264_mega_menu-response-to-icons li li > div:after,
	.x264_mega_menu-response-to-icons .right li > div:after {
		top: auto;
		right: auto;
		bottom: 100%;
		left: 0;
		width: 100%;
		height: 8px;
	}
	.x264_mega_menu-response-to-icons li li:hover > div,
	.x264_mega_menu-response-to-icons .right li:hover > div {
		right: 0;
		left: 41px;
		width: auto;
	}
	.x264_mega_menu-response-to-icons li li a > .fa {
		margin-right: 10px;
	}
	.x264_mega_menu-response-to-icons li li a > .fa-indicator {
		margin-right: 0px;
	}
	.x264_mega_menu-response-to-icons.x264_mega_menu-anim-flip li li > div {
		top: 100%;
		margin: 8px 0 0 0;
		transform: rotateX(0deg);
		-moz-transform: rotateX(0deg);
		-webkit-transform: rotateX(0deg);
	}
	.x264_mega_menu-pos-bottom.x264_mega_menu-response-to-icons li li > div {
		top: auto;
		bottom: 100%;
		margin: 0 0 8px 0;
	}	
	.x264_mega_menu-pos-bottom.x264_mega_menu-response-to-icons li li > div:after {
		top: 100%;
		bottom: auto;
	}
}

.x264_mega_menu li:hover > a,
.x264_mega_menu li.current > a {
	color: #fff;
}


/**/
/* forms */
/**/
.x264_mega_menu form .input:hover input,
.x264_mega_menu form .textarea:hover textarea {
	border-color: #909090;
}
.x264_mega_menu form .button {
	
}
.x264_mega_menu form .input input:focus,
.x264_mega_menu form .textarea textarea:focus {
	border-color: #222;
}

/*!
 *  Font Awesome 4.0.3 by @davegandy - http://fontawesome.io - @fontawesome
 *  License - http://fontawesome.io/license (Font: SIL OFL 1.1, CSS: MIT License)
 */
/* FONT PATH
 * -------------------------- */
@font-face {
  font-family: 'FontAwesome';
  src: url('../icons/fontawesome-webfont.eot?v=4.0.3');
  src: url('../icons/fontawesome-webfont.eot?#iefix&v=4.0.3') format('embedded-opentype'), url('../icons/fontawesome-webfont.woff?v=4.0.3') format('woff'), url('../icons/fontawesome-webfont.ttf?v=4.0.3') format('truetype'), url('../icons/fontawesome-webfont.svg?v=4.0.3#fontawesomeregular') format('svg');
  font-weight: normal;
  font-style: normal;
}
.fa {
  display: inline-block;
  font-family: FontAwesome;
  font-style: normal;
  font-weight: normal;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
/* makes the font 33% larger relative to the icon container */
.fa-lg {
  font-size: 1.3333333333333333em;
  line-height: 0.75em;
  vertical-align: -15%;
}
.fa-2x {
  font-size: 2em;
}
.fa-3x {
  font-size: 3em;
}
.fa-4x {
  font-size: 4em;
}
.fa-5x {
  font-size: 5em;
}
.fa-fw {
  width: 1.2857142857142858em;
  text-align: center;
}
.fa-ul {
  padding-left: 0;
  margin-left: 2.142857142857143em;
  list-style-type: none;
}
.fa-ul > li {
  position: relative;
}
.fa-li {
  position: absolute;
  left: -2.142857142857143em;
  width: 2.142857142857143em;
  top: 0.14285714285714285em;
  text-align: center;
}
.fa-li.fa-lg {
  left: -1.8571428571428572em;
}
.fa-border {
  padding: .2em .25em .15em;
  border: solid 0.08em #eeeeee;
  border-radius: .1em;
}
.pull-right {
  float: right;
}
.pull-left {
  float: left;
}
.fa.pull-left {
  margin-right: .3em;
}
.fa.pull-right {
  margin-left: .3em;
}
.fa-spin {
  -webkit-animation: spin 2s infinite linear;
  -moz-animation: spin 2s infinite linear;
  -o-animation: spin 2s infinite linear;
  animation: spin 2s infinite linear;
}
@-moz-keyframes spin {
  0% {
    -moz-transform: rotate(0deg);
  }
  100% {
    -moz-transform: rotate(359deg);
  }
}
@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(359deg);
  }
}
@-o-keyframes spin {
  0% {
    -o-transform: rotate(0deg);
  }
  100% {
    -o-transform: rotate(359deg);
  }
}
@-ms-keyframes spin {
  0% {
    -ms-transform: rotate(0deg);
  }
  100% {
    -ms-transform: rotate(359deg);
  }
}
@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(359deg);
  }
}
.fa-rotate-90 {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=1);
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  transform: rotate(90deg);
}
.fa-rotate-180 {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
  -webkit-transform: rotate(180deg);
  -moz-transform: rotate(180deg);
  -ms-transform: rotate(180deg);
  -o-transform: rotate(180deg);
  transform: rotate(180deg);
}
.fa-rotate-270 {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
  -webkit-transform: rotate(270deg);
  -moz-transform: rotate(270deg);
  -ms-transform: rotate(270deg);
  -o-transform: rotate(270deg);
  transform: rotate(270deg);
}
.fa-flip-horizontal {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=0, mirror=1);
  -webkit-transform: scale(-1, 1);
  -moz-transform: scale(-1, 1);
  -ms-transform: scale(-1, 1);
  -o-transform: scale(-1, 1);
  transform: scale(-1, 1);
}
.fa-flip-vertical {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1);
  -webkit-transform: scale(1, -1);
  -moz-transform: scale(1, -1);
  -ms-transform: scale(1, -1);
  -o-transform: scale(1, -1);
  transform: scale(1, -1);
}
.fa-stack {
  position: relative;
  display: inline-block;
  width: 2em;
  height: 2em;
  line-height: 2em;
  vertical-align: middle;
}
.fa-stack-1x,
.fa-stack-2x {
  position: absolute;
  left: 0;
  width: 100%;
  text-align: center;
}
.fa-stack-1x {
  line-height: inherit;
}
.fa-stack-2x {
  font-size: 2em;
}
.fa-inverse {
  color: #ffffff;
}
/* Font Awesome uses the Unicode Private Use Area (PUA) to ensure screen
   readers do not read off random characters that represent icons */
.fa-glass:before {
  content: "\f000";
}
.fa-music:before {
  content: "\f001";
}
.fa-search:before {
  content: "\f002";
}
.fa-envelope-o:before {
  content: "\f003";
}
.fa-heart:before {
  content: "\f004";
}
.fa-star:before {
  content: "\f005";
}
.fa-star-o:before {
  content: "\f006";
}
.fa-user:before {
  content: "\f007";
}
.fa-film:before {
  content: "\f008";
}
.fa-th-large:before {
  content: "\f009";
}
.fa-th:before {
  content: "\f00a";
}
.fa-th-list:before {
  content: "\f00b";
}
.fa-check:before {
  content: "\f00c";
}
.fa-times:before {
  content: "\f00d";
}
.fa-search-plus:before {
  content: "\f00e";
}
.fa-search-minus:before {
  content: "\f010";
}
.fa-power-off:before {
  content: "\f011";
}
.fa-signal:before {
  content: "\f012";
}
.fa-gear:before,
.fa-cog:before {
  content: "\f013";
}
.fa-trash-o:before {
  content: "\f014";
}
.fa-home:before {
  content: "\f015";
}
.fa-file-o:before {
  content: "\f016";
}
.fa-clock-o:before {
  content: "\f017";
}
.fa-road:before {
  content: "\f018";
}
.fa-download:before {
  content: "\f019";
}
.fa-arrow-circle-o-down:before {
  content: "\f01a";
}
.fa-arrow-circle-o-up:before {
  content: "\f01b";
}
.fa-inbox:before {
  content: "\f01c";
}
.fa-play-circle-o:before {
  content: "\f01d";
}
.fa-rotate-right:before,
.fa-repeat:before {
  content: "\f01e";
}
.fa-refresh:before {
  content: "\f021";
}
.fa-list-alt:before {
  content: "\f022";
}
.fa-lock:before {
  content: "\f023";
}
.fa-flag:before {
  content: "\f024";
}
.fa-headphones:before {
  content: "\f025";
}
.fa-volume-off:before {
  content: "\f026";
}
.fa-volume-down:before {
  content: "\f027";
}
.fa-volume-up:before {
  content: "\f028";
}
.fa-qrcode:before {
  content: "\f029";
}
.fa-barcode:before {
  content: "\f02a";
}
.fa-tag:before {
  content: "\f02b";
}
.fa-tags:before {
  content: "\f02c";
}
.fa-book:before {
  content: "\f02d";
}
.fa-bookmark:before {
  content: "\f02e";
}
.fa-print:before {
  content: "\f02f";
}
.fa-camera:before {
  content: "\f030";
}
.fa-font:before {
  content: "\f031";
}
.fa-bold:before {
  content: "\f032";
}
.fa-italic:before {
  content: "\f033";
}
.fa-text-height:before {
  content: "\f034";
}
.fa-text-width:before {
  content: "\f035";
}
.fa-align-left:before {
  content: "\f036";
}
.fa-align-center:before {
  content: "\f037";
}
.fa-align-right:before {
  content: "\f038";
}
.fa-align-justify:before {
  content: "\f039";
}
.fa-list:before {
  content: "\f03a";
}
.fa-dedent:before,
.fa-outdent:before {
  content: "\f03b";
}
.fa-indent:before {
  content: "\f03c";
}
.fa-video-camera:before {
  content: "\f03d";
}
.fa-picture-o:before {
  content: "\f03e";
}
.fa-pencil:before {
  content: "\f040";
}
.fa-map-marker:before {
  content: "\f041";
}
.fa-adjust:before {
  content: "\f042";
}
.fa-tint:before {
  content: "\f043";
}
.fa-edit:before,
.fa-pencil-square-o:before {
  content: "\f044";
}
.fa-share-square-o:before {
  content: "\f045";
}
.fa-check-square-o:before {
  content: "\f046";
}
.fa-arrows:before {
  content: "\f047";
}
.fa-step-backward:before {
  content: "\f048";
}
.fa-fast-backward:before {
  content: "\f049";
}
.fa-backward:before {
  content: "\f04a";
}
.fa-play:before {
  content: "\f04b";
}
.fa-pause:before {
  content: "\f04c";
}
.fa-stop:before {
  content: "\f04d";
}
.fa-forward:before {
  content: "\f04e";
}
.fa-fast-forward:before {
  content: "\f050";
}
.fa-step-forward:before {
  content: "\f051";
}
.fa-eject:before {
  content: "\f052";
}
.fa-chevron-left:before {
  content: "\f053";
}
.fa-chevron-right:before {
  content: "\f054";
}
.fa-plus-circle:before {
  content: "\f055";
}
.fa-minus-circle:before {
  content: "\f056";
}
.fa-times-circle:before {
  content: "\f057";
}
.fa-check-circle:before {
  content: "\f058";
}
.fa-question-circle:before {
  content: "\f059";
}
.fa-info-circle:before {
  content: "\f05a";
}
.fa-crosshairs:before {
  content: "\f05b";
}
.fa-times-circle-o:before {
  content: "\f05c";
}
.fa-check-circle-o:before {
  content: "\f05d";
}
.fa-ban:before {
  content: "\f05e";
}
.fa-arrow-left:before {
  content: "\f060";
}
.fa-arrow-right:before {
  content: "\f061";
}
.fa-arrow-up:before {
  content: "\f062";
}
.fa-arrow-down:before {
  content: "\f063";
}
.fa-mail-forward:before,
.fa-share:before {
  content: "\f064";
}
.fa-expand:before {
  content: "\f065";
}
.fa-compress:before {
  content: "\f066";
}
.fa-plus:before {
  content: "\f067";
}
.fa-minus:before {
  content: "\f068";
}
.fa-asterisk:before {
  content: "\f069";
}
.fa-exclamation-circle:before {
  content: "\f06a";
}
.fa-gift:before {
  content: "\f06b";
}
.fa-leaf:before {
  content: "\f06c";
}
.fa-fire:before {
  content: "\f06d";
}
.fa-eye:before {
  content: "\f06e";
}
.fa-eye-slash:before {
  content: "\f070";
}
.fa-warning:before,
.fa-exclamation-triangle:before {
  content: "\f071";
}
.fa-plane:before {
  content: "\f072";
}
.fa-calendar:before {
  content: "\f073";
}
.fa-random:before {
  content: "\f074";
}
.fa-comment:before {
  content: "\f075";
}
.fa-magnet:before {
  content: "\f076";
}
.fa-chevron-up:before {
  content: "\f077";
}
.fa-chevron-down:before {
  content: "\f078";
}
.fa-retweet:before {
  content: "\f079";
}
.fa-shopping-cart:before {
  content: "\f07a";
}
.fa-folder:before {
  content: "\f07b";
}
.fa-folder-open:before {
  content: "\f07c";
}
.fa-arrows-v:before {
  content: "\f07d";
}
.fa-arrows-h:before {
  content: "\f07e";
}
.fa-bar-chart-o:before {
  content: "\f080";
}
.fa-twitter-square:before {
  content: "\f081";
}
.fa-facebook-square:before {
  content: "\f082";
}
.fa-camera-retro:before {
  content: "\f083";
}
.fa-key:before {
  content: "\f084";
}
.fa-gears:before,
.fa-cogs:before {
  content: "\f085";
}
.fa-comments:before {
  content: "\f086";
}
.fa-thumbs-o-up:before {
  content: "\f087";
}
.fa-thumbs-o-down:before {
  content: "\f088";
}
.fa-star-half:before {
  content: "\f089";
}
.fa-heart-o:before {
  content: "\f08a";
}
.fa-sign-out:before {
  content: "\f08b";
}
.fa-linkedin-square:before {
  content: "\f08c";
}
.fa-thumb-tack:before {
  content: "\f08d";
}
.fa-external-link:before {
  content: "\f08e";
}
.fa-sign-in:before {
  content: "\f090";
}
.fa-trophy:before {
  content: "\f091";
}
.fa-github-square:before {
  content: "\f092";
}
.fa-upload:before {
  content: "\f093";
}
.fa-lemon-o:before {
  content: "\f094";
}
.fa-phone:before {
  content: "\f095";
}
.fa-square-o:before {
  content: "\f096";
}
.fa-bookmark-o:before {
  content: "\f097";
}
.fa-phone-square:before {
  content: "\f098";
}
.fa-twitter:before {
  content: "\f099";
}
.fa-facebook:before {
  content: "\f09a";
}
.fa-github:before {
  content: "\f09b";
}
.fa-unlock:before {
  content: "\f09c";
}
.fa-credit-card:before {
  content: "\f09d";
}
.fa-rss:before {
  content: "\f09e";
}
.fa-hdd-o:before {
  content: "\f0a0";
}
.fa-bullhorn:before {
  content: "\f0a1";
}
.fa-bell:before {
  content: "\f0f3";
}
.fa-certificate:before {
  content: "\f0a3";
}
.fa-hand-o-right:before {
  content: "\f0a4";
}
.fa-hand-o-left:before {
  content: "\f0a5";
}
.fa-hand-o-up:before {
  content: "\f0a6";
}
.fa-hand-o-down:before {
  content: "\f0a7";
}
.fa-arrow-circle-left:before {
  content: "\f0a8";
}
.fa-arrow-circle-right:before {
  content: "\f0a9";
}
.fa-arrow-circle-up:before {
  content: "\f0aa";
}
.fa-arrow-circle-down:before {
  content: "\f0ab";
}
.fa-globe:before {
  content: "\f0ac";
}
.fa-wrench:before {
  content: "\f0ad";
}
.fa-tasks:before {
  content: "\f0ae";
}
.fa-filter:before {
  content: "\f0b0";
}
.fa-briefcase:before {
  content: "\f0b1";
}
.fa-arrows-alt:before {
  content: "\f0b2";
}
.fa-group:before,
.fa-users:before {
  content: "\f0c0";
}
.fa-chain:before,
.fa-link:before {
  content: "\f0c1";
}
.fa-cloud:before {
  content: "\f0c2";
}
.fa-flask:before {
  content: "\f0c3";
}
.fa-cut:before,
.fa-scissors:before {
  content: "\f0c4";
}
.fa-copy:before,
.fa-files-o:before {
  content: "\f0c5";
}
.fa-paperclip:before {
  content: "\f0c6";
}
.fa-save:before,
.fa-floppy-o:before {
  content: "\f0c7";
}
.fa-square:before {
  content: "\f0c8";
}
.fa-bars:before {
  content: "\f0c9";
}
.fa-list-ul:before {
  content: "\f0ca";
}
.fa-list-ol:before {
  content: "\f0cb";
}
.fa-strikethrough:before {
  content: "\f0cc";
}
.fa-underline:before {
  content: "\f0cd";
}
.fa-table:before {
  content: "\f0ce";
}
.fa-magic:before {
  content: "\f0d0";
}
.fa-truck:before {
  content: "\f0d1";
}
.fa-pinterest:before {
  content: "\f0d2";
}
.fa-pinterest-square:before {
  content: "\f0d3";
}
.fa-google-plus-square:before {
  content: "\f0d4";
}
.fa-google-plus:before {
  content: "\f0d5";
}
.fa-money:before {
  content: "\f0d6";
}
.fa-caret-down:before {
  content: "\f0d7";
}
.fa-caret-up:before {
  content: "\f0d8";
}
.fa-caret-left:before {
  content: "\f0d9";
}
.fa-caret-right:before {
  content: "\f0da";
}
.fa-columns:before {
  content: "\f0db";
}
.fa-unsorted:before,
.fa-sort:before {
  content: "\f0dc";
}
.fa-sort-down:before,
.fa-sort-asc:before {
  content: "\f0dd";
}
.fa-sort-up:before,
.fa-sort-desc:before {
  content: "\f0de";
}
.fa-envelope:before {
  content: "\f0e0";
}
.fa-linkedin:before {
  content: "\f0e1";
}
.fa-rotate-left:before,
.fa-undo:before {
  content: "\f0e2";
}
.fa-legal:before,
.fa-gavel:before {
  content: "\f0e3";
}
.fa-dashboard:before,
.fa-tachometer:before {
  content: "\f0e4";
}
.fa-comment-o:before {
  content: "\f0e5";
}
.fa-comments-o:before {
  content: "\f0e6";
}
.fa-flash:before,
.fa-bolt:before {
  content: "\f0e7";
}
.fa-sitemap:before {
  content: "\f0e8";
}
.fa-umbrella:before {
  content: "\f0e9";
}
.fa-paste:before,
.fa-clipboard:before {
  content: "\f0ea";
}
.fa-lightbulb-o:before {
  content: "\f0eb";
}
.fa-exchange:before {
  content: "\f0ec";
}
.fa-cloud-download:before {
  content: "\f0ed";
}
.fa-cloud-upload:before {
  content: "\f0ee";
}
.fa-user-md:before {
  content: "\f0f0";
}
.fa-stethoscope:before {
  content: "\f0f1";
}
.fa-suitcase:before {
  content: "\f0f2";
}
.fa-bell-o:before {
  content: "\f0a2";
}
.fa-coffee:before {
  content: "\f0f4";
}
.fa-cutlery:before {
  content: "\f0f5";
}
.fa-file-text-o:before {
  content: "\f0f6";
}
.fa-building-o:before {
  content: "\f0f7";
}
.fa-hospital-o:before {
  content: "\f0f8";
}
.fa-ambulance:before {
  content: "\f0f9";
}
.fa-medkit:before {
  content: "\f0fa";
}
.fa-fighter-jet:before {
  content: "\f0fb";
}
.fa-beer:before {
  content: "\f0fc";
}
.fa-h-square:before {
  content: "\f0fd";
}
.fa-plus-square:before {
  content: "\f0fe";
}
.fa-angle-double-left:before {
  content: "\f100";
}
.fa-angle-double-right:before {
  content: "\f101";
}
.fa-angle-double-up:before {
  content: "\f102";
}
.fa-angle-double-down:before {
  content: "\f103";
}
.fa-angle-left:before {
  content: "\f104";
}
.fa-angle-right:before {
  content: "\f105";
}
.fa-angle-up:before {
  content: "\f106";
}
.fa-angle-down:before {
  content: "\f107";
}
.fa-desktop:before {
  content: "\f108";
}
.fa-laptop:before {
  content: "\f109";
}
.fa-tablet:before {
  content: "\f10a";
}
.fa-mobile-phone:before,
.fa-mobile:before {
  content: "\f10b";
}
.fa-circle-o:before {
  content: "\f10c";
}
.fa-quote-left:before {
  content: "\f10d";
}
.fa-quote-right:before {
  content: "\f10e";
}
.fa-spinner:before {
  content: "\f110";
}
.fa-circle:before {
  content: "\f111";
}
.fa-mail-reply:before,
.fa-reply:before {
  content: "\f112";
}
.fa-github-alt:before {
  content: "\f113";
}
.fa-folder-o:before {
  content: "\f114";
}
.fa-folder-open-o:before {
  content: "\f115";
}
.fa-smile-o:before {
  content: "\f118";
}
.fa-frown-o:before {
  content: "\f119";
}
.fa-meh-o:before {
  content: "\f11a";
}
.fa-gamepad:before {
  content: "\f11b";
}
.fa-keyboard-o:before {
  content: "\f11c";
}
.fa-flag-o:before {
  content: "\f11d";
}
.fa-flag-checkered:before {
  content: "\f11e";
}
.fa-terminal:before {
  content: "\f120";
}
.fa-code:before {
  content: "\f121";
}
.fa-reply-all:before {
  content: "\f122";
}
.fa-mail-reply-all:before {
  content: "\f122";
}
.fa-star-half-empty:before,
.fa-star-half-full:before,
.fa-star-half-o:before {
  content: "\f123";
}
.fa-location-arrow:before {
  content: "\f124";
}
.fa-crop:before {
  content: "\f125";
}
.fa-code-fork:before {
  content: "\f126";
}
.fa-unlink:before,
.fa-chain-broken:before {
  content: "\f127";
}
.fa-question:before {
  content: "\f128";
}
.fa-info:before {
  content: "\f129";
}
.fa-exclamation:before {
  content: "\f12a";
}
.fa-superscript:before {
  content: "\f12b";
}
.fa-subscript:before {
  content: "\f12c";
}
.fa-eraser:before {
  content: "\f12d";
}
.fa-puzzle-piece:before {
  content: "\f12e";
}
.fa-microphone:before {
  content: "\f130";
}
.fa-microphone-slash:before {
  content: "\f131";
}
.fa-shield:before {
  content: "\f132";
}
.fa-calendar-o:before {
  content: "\f133";
}
.fa-fire-extinguisher:before {
  content: "\f134";
}
.fa-rocket:before {
  content: "\f135";
}
.fa-maxcdn:before {
  content: "\f136";
}
.fa-chevron-circle-left:before {
  content: "\f137";
}
.fa-chevron-circle-right:before {
  content: "\f138";
}
.fa-chevron-circle-up:before {
  content: "\f139";
}
.fa-chevron-circle-down:before {
  content: "\f13a";
}
.fa-html5:before {
  content: "\f13b";
}
.fa-css3:before {
  content: "\f13c";
}
.fa-anchor:before {
  content: "\f13d";
}
.fa-unlock-alt:before {
  content: "\f13e";
}
.fa-bullseye:before {
  content: "\f140";
}
.fa-ellipsis-h:before {
  content: "\f141";
}
.fa-ellipsis-v:before {
  content: "\f142";
}
.fa-rss-square:before {
  content: "\f143";
}
.fa-play-circle:before {
  content: "\f144";
}
.fa-ticket:before {
  content: "\f145";
}
.fa-minus-square:before {
  content: "\f146";
}
.fa-minus-square-o:before {
  content: "\f147";
}
.fa-level-up:before {
  content: "\f148";
}
.fa-level-down:before {
  content: "\f149";
}
.fa-check-square:before {
  content: "\f14a";
}
.fa-pencil-square:before {
  content: "\f14b";
}
.fa-external-link-square:before {
  content: "\f14c";
}
.fa-share-square:before {
  content: "\f14d";
}
.fa-compass:before {
  content: "\f14e";
}
.fa-toggle-down:before,
.fa-caret-square-o-down:before {
  content: "\f150";
}
.fa-toggle-up:before,
.fa-caret-square-o-up:before {
  content: "\f151";
}
.fa-toggle-right:before,
.fa-caret-square-o-right:before {
  content: "\f152";
}
.fa-euro:before,
.fa-eur:before {
  content: "\f153";
}
.fa-gbp:before {
  content: "\f154";
}
.fa-dollar:before,
.fa-usd:before {
  content: "\f155";
}
.fa-rupee:before,
.fa-inr:before {
  content: "\f156";
}
.fa-cny:before,
.fa-rmb:before,
.fa-yen:before,
.fa-jpy:before {
  content: "\f157";
}
.fa-ruble:before,
.fa-rouble:before,
.fa-rub:before {
  content: "\f158";
}
.fa-won:before,
.fa-krw:before {
  content: "\f159";
}
.fa-bitcoin:before,
.fa-btc:before {
  content: "\f15a";
}
.fa-file:before {
  content: "\f15b";
}
.fa-file-text:before {
  content: "\f15c";
}
.fa-sort-alpha-asc:before {
  content: "\f15d";
}
.fa-sort-alpha-desc:before {
  content: "\f15e";
}
.fa-sort-amount-asc:before {
  content: "\f160";
}
.fa-sort-amount-desc:before {
  content: "\f161";
}
.fa-sort-numeric-asc:before {
  content: "\f162";
}
.fa-sort-numeric-desc:before {
  content: "\f163";
}
.fa-thumbs-up:before {
  content: "\f164";
}
.fa-thumbs-down:before {
  content: "\f165";
}
.fa-youtube-square:before {
  content: "\f166";
}
.fa-youtube:before {
  content: "\f167";
}
.fa-xing:before {
  content: "\f168";
}
.fa-xing-square:before {
  content: "\f169";
}
.fa-youtube-play:before {
  content: "\f16a";
}
.fa-dropbox:before {
  content: "\f16b";
}
.fa-stack-overflow:before {
  content: "\f16c";
}
.fa-instagram:before {
  content: "\f16d";
}
.fa-flickr:before {
  content: "\f16e";
}
.fa-adn:before {
  content: "\f170";
}
.fa-bitbucket:before {
  content: "\f171";
}
.fa-bitbucket-square:before {
  content: "\f172";
}
.fa-tumblr:before {
  content: "\f173";
}
.fa-tumblr-square:before {
  content: "\f174";
}
.fa-long-arrow-down:before {
  content: "\f175";
}
.fa-long-arrow-up:before {
  content: "\f176";
}
.fa-long-arrow-left:before {
  content: "\f177";
}
.fa-long-arrow-right:before {
  content: "\f178";
}
.fa-apple:before {
  content: "\f179";
}
.fa-windows:before {
  content: "\f17a";
}
.fa-android:before {
  content: "\f17b";
}
.fa-linux:before {
  content: "\f17c";
}
.fa-dribbble:before {
  content: "\f17d";
}
.fa-skype:before {
  content: "\f17e";
}
.fa-foursquare:before {
  content: "\f180";
}
.fa-trello:before {
  content: "\f181";
}
.fa-female:before {
  content: "\f182";
}
.fa-male:before {
  content: "\f183";
}
.fa-gittip:before {
  content: "\f184";
}
.fa-sun-o:before {
  content: "\f185";
}
.fa-moon-o:before {
  content: "\f186";
}
.fa-archive:before {
  content: "\f187";
}
.fa-bug:before {
  content: "\f188";
}
.fa-vk:before {
  content: "\f189";
}
.fa-weibo:before {
  content: "\f18a";
}
.fa-renren:before {
  content: "\f18b";
}
.fa-pagelines:before {
  content: "\f18c";
}
.fa-stack-exchange:before {
  content: "\f18d";
}
.fa-arrow-circle-o-right:before {
  content: "\f18e";
}
.fa-arrow-circle-o-left:before {
  content: "\f190";
}
.fa-toggle-left:before,
.fa-caret-square-o-left:before {
  content: "\f191";
}
.fa-dot-circle-o:before {
  content: "\f192";
}
.fa-wheelchair:before {
  content: "\f193";
}
.fa-vimeo-square:before {
  content: "\f194";
}
.fa-turkish-lira:before,
.fa-try:before {
  content: "\f195";
}
.fa-plus-square-o:before {
  content: "\f196";
}
