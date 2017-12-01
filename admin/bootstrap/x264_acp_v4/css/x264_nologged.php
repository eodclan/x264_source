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
#x264_nologged_wrapper{
	 text-align: left;
	width:98,5%;
	height: 98,5;
	 margin: 0;
	 padding: 0;
	 margin: 0 auto;
	 font-family: "Trebuchet MS","Myriad Pro",Arial,sans-serif;
}

.x264_nologged_div{
	width:98,5%;
	padding:9px;
	background-color:rgba(20,20,20,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	border:none 5px #000000;
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
	border-bottom-left-radius: 15px;
	border-bottom-right-radius: 15px;
	text-align:left;
}

@font-face {
    font-family: 'FontomasCustomRegular';
    src: url('../fonts/fontomas-webfont.eot');
    src: url('../fonts/fontomas-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/fontomas-webfont.woff') format('woff'),
         url('../fonts/fontomas-webfont.ttf') format('truetype'),
         url('../fonts/fontomas-webfont.svg#FontomasCustomRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'FranchiseRegular';
    src: url('../fonts/franchise-bold-webfont.eot');
    src: url('../fonts/franchise-bold-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/franchise-bold-webfont.woff') format('woff'),
         url('../fonts/franchise-bold-webfont.ttf') format('truetype'),
         url('../fonts/franchise-bold-webfont.svg#FranchiseRegular') format('svg');
    font-weight: normal;
    font-style: normal;

}

.x264_nologged_inp{
	width:200px;
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

.x264_nologged_inpb{
	width:400px;
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

a.hiddenanchor{
	display: none;
}

#x264_nologged_wrap{
	width: 60%;
	right: 0px;
	min-height: 560px;	
	margin: 0px auto;	
	width: 500px;
	position: relative;	
}

#x264_nologged_wrap a{
	color: #D0AF7A;
	text-decoration: underline;
}

#x264_nologged_wrap h1{		
	color: #590700; 
	font-size: 32px;
	padding: 2px 0 10px 0;
	font-family: 'FranchiseRegular','Arial Narrow',Arial,sans-serif;
	font-weight: bold;
	text-align: center;
	padding-bottom: 10px;
}

#x264_nologged_wrap h1:after{		
	background: -moz-linear-gradient(left,  rgba(48,4,0,0) 0%, rgba(48,4,0,0.8) 15%, rgba(48,4,0,1) 19%, rgba(48,4,0,1) 20%, rgba(48,4,0,1) 50%, rgba(48,4,0,1) 81%, rgba(48,4,0,0.8) 85%, rgba(48,4,0,0) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(48,4,0,0)), color-stop(15%,rgba(48,4,0,0.8)), color-stop(19%,rgba(48,4,0,1)), color-stop(20%,rgba(48,4,0,1)), color-stop(50%,rgba(48,4,0,1)), color-stop(81%,rgba(48,4,0,1)), color-stop(85%,rgba(48,4,0,0.8)), color-stop(100%,rgba(48,4,0,0))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(left,  rgba(48,4,0,0) 0%,rgba(48,4,0,0.8) 15%,rgba(48,4,0,1) 19%,rgba(48,4,0,1) 20%,rgba(48,4,0,1) 50%,rgba(48,4,0,1) 81%,rgba(48,4,0,0.8) 85%,rgba(48,4,0,0) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(left,  rgba(48,4,0,0) 0%,rgba(48,4,0,0.8) 15%,rgba(48,4,0,1) 19%,rgba(48,4,0,1) 20%,rgba(48,4,0,1) 50%,rgba(48,4,0,1) 81%,rgba(48,4,0,0.8) 85%,rgba(48,4,0,0) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(left,  rgba(48,4,0,0) 0%,rgba(48,4,0,0.8) 15%,rgba(48,4,0,1) 19%,rgba(48,4,0,1) 20%,rgba(48,4,0,1) 50%,rgba(48,4,0,1) 81%,rgba(48,4,0,0.8) 85%,rgba(48,4,0,0) 100%); /* IE10+ */
	background: linear-gradient(to right,  rgba(48,4,0,0) 0%,rgba(48,4,0,0.8) 15%,rgba(48,4,0,1) 19%,rgba(48,4,0,1) 20%,rgba(48,4,0,1) 50%,rgba(48,4,0,1) 81%,rgba(48,4,0,0.8) 85%,rgba(48,4,0,0) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00300400', endColorstr='#00300400',GradientType=1 ); /* IE6-9 */
	content: " "; 
	display: block; 
	height: 2px; 
	margin-top: 5px; 
	width: 100%; 
}

#x264_nologged_wrap p{
	margin-bottom:25px;
}

#x264_nologged_wrap p:first-child{
	margin: 0px;
}

#x264_nologged_wrap label{
	color: #D0AF7A;
	position: relative;
}

::-webkit-input-placeholder  { 
	color: rgb(190, 188, 188); 
	font-style: italic;
}

input:-moz-placeholder,
textarea:-moz-placeholder{ 
	color: #D0AF7A;
	font-style: italic;
} 

#x264_nologged_wrap input:not([type="checkbox"]){
	width: 92%;
	margin-top: 2px;
	padding: 1px 5px 2px 32px;	
	border: 1px solid rgb(178, 178, 178);
	background-image(linear-gradient(#545454,#373738));
	color: #D0AF7A;
	-webkit-appearance: textfield;
	-webkit-box-sizing: content-box;
	  -moz-box-sizing : content-box;
	       box-sizing : content-box;
	-webkit-border-radius: 3px;
	   -moz-border-radius: 3px;
	        border-radius: 3px;
	-webkit-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
	   -moz-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
	        box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.6) inset;
	-webkit-transition: all 0.2s linear;
	   -moz-transition: all 0.2s linear;
	     -o-transition: all 0.2s linear;
	        transition: all 0.2s linear;
}

#x264_nologged_wrap input:not([type="checkbox"]):active,
#x264_nologged_wrap input:not([type="checkbox"]):focus{
    animation: 800ms ease-out 0s alternate none infinite glow;
    -webkit-animation: glow 800ms alternate infinite ease-out;
    background: linear-gradient(#333933, #222922) repeat scroll 0 0 rgba(0, 0, 0, 0);
    border-color: #339933;
    box-shadow: 0 0 5px rgba(0, 255, 0, 0.2), 0 0 5px rgba(0, 255, 0, 0.1) inset, 0 2px 0 #000000;
    color: #EEFFEE;
    outline: medium none;
} 

@keyframes glow {
0% {
    border-color: #339933;
    box-shadow: 0 0 5px rgba(0, 255, 0, 0.2), 0 0 5px rgba(0, 255, 0, 0.1) inset, 0 2px 0 #000000;
    z-index: 100;
}
100% {
    border-color: #66FF66;
    box-shadow: 0 0 20px rgba(0, 255, 0, 0.6), 0 0 10px rgba(0, 255, 0, 0.4) inset, 0 2px 0 #000000;
    z-index: 100;
}
}

@-webkit-keyframes glow /* Safari and Chrome */ {
0% {
    border-color: #339933;
    box-shadow: 0 0 5px rgba(0, 255, 0, 0.2), 0 0 5px rgba(0, 255, 0, 0.1) inset, 0 2px 0 #000000;
    z-index: 100;
}
100% {
    border-color: #66FF66;
    box-shadow: 0 0 20px rgba(0, 255, 0, 0.6), 0 0 10px rgba(0, 255, 0, 0.4) inset, 0 2px 0 #000000;
    z-index: 100;
}
}

[data-icon]:after {
    content: attr(data-icon);
    font-family: 'FontomasCustomRegular';
    color: #D0AF7A;
    position: absolute;
    left: 10px;
    top: 20px;
	width: 30px;
}

#x264_nologged_wrap p.button input{
	width: 30%;
	cursor: pointer;	
	background-color:0 -1px 0 rgba(0,0,0,.2);
	padding: 8px 5px;
	font-family: 'BebasNeueRegular','Arial Narrow',Arial,sans-serif;
	font-weight: bold;
	color: #D0AF7A;
	font-size: 14px;		
	margin-bottom: 10px;	
	text-shadow: 0 1px 1px rgba(0, 0, 0, 0.5);
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 6px;
	border: 1px solid rgba(91, 90, 90, 0.7);		
	-webkit-transition: all 0.2s linear;
	-moz-transition: all 0.2s linear;
	-o-transition: all 0.2s linear;
	transition: all 0.2s linear;
}

#x264_nologged_wrap p.button input:hover{
	cursor: pointer;
	background-image(linear-gradient(#545454,#373738));
	box-shadow(
		//-----Button Beveling-----
		//top dark bevel
		0 -1px 0 rgba(0,0,0,.2),
		//full bevel
		0 0 0 1px rgba(0,0,0,.3),
		//bottom highlight bevel
		0 1px 0 rgba(255,255,255,.05),
		//slight outer glow
		0 0 3px rgba(255,255,255,.2));
	border-radius(2px);
}

#x264_nologged_wrap p.button input:active,
#x264_nologged_wrap p.button input:focus{
	position: relative;
	border: 1px solid rgba(91, 90, 90, 0.7);
	background-color:rgba(19,19,19,1);	
	-webkit-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.9) inset;
	-moz-box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.9) inset;
	box-shadow: 0px 1px 4px 0px rgba(168, 168, 168, 0.9) inset;
}

p.login.button,
p.signin.button{
	text-align: right;
}

p.change_link{
	position: absolute;
	color: #D0AF7A;
	left: 0px;
	height: 10px;
	width: 440px;
	padding: 0 24px 12px;
	font-size: 12px	;
	text-align: right;
}

#x264_nologged_wrap p.change_link a {
	display: inline-block;
	font-weight: bold;
	padding: 2px 6px;
	color: #717171;
	margin-left: 10px;
	text-decoration: none;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	border: 1px solid rgb(203, 213, 214);
	-webkit-transition: all 0.4s linear;
	-moz-transition: all 0.4s  linear;
	-o-transition: all 0.4s linear;
	-ms-transition: all 0.4s  linear;
	transition: all 0.4s  linear;
}

#x264_nologged_wrap p.change_link a:hover {
	color: #D0AF7A;

}

#x264_nologged_wrap p.change_link a:active{
	position: relative;
	top: 1px;
}

#register,
#login{
	position: absolute;
	top: 0px;
	width: 88%;	
	padding: 18px 6% 60px 6%;
	margin: 0 0 35px 0;
	background-color:rgba(28,28,28,1);
	border: 1px solid #404040;
	border-radius: 10px;
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}

#register{	
	z-index: 21;
	opacity: 0;
}

#login{
	z-index: 22;
}

#toregister:target ~ #x264_nologged_wrap #register,
#tologin:target ~ #x264_nologged_wrap #login{
	z-index: 22;
	-webkit-animation-delay: .6s;
	-webkit-animation-timing-function: ease-in;
	-moz-animation-delay: .6s;
	-moz-animation-timing-function: ease-in;
	-o-animation-delay: .6s;
	-o-animation-timing-function: ease-in;
	-ms-animation-delay: .6s;
	-ms-animation-timing-function: ease-in;
	animation-delay: .6s;
	animation-timing-function: ease-in;
	-webkit-animation-name: scaleIn;
	-moz-animation-name: scaleIn;
	-ms-animation-name: scaleIn;
	-o-animation-name: scaleIn;
	animation-name: scaleIn;
}

#toregister:target ~ #x264_nologged_wrap #login,
#tokontakt:target ~ #x264_nologged_wrap #login,
#tokontakt:target ~ #x264_nologged_wrap #register,
#tologin:target ~ #x264_nologged_wrap #register,
{
	-webkit-animation-timing-function: ease-out;
	-moz-animation-timing-function: ease-out;
	-o-animation-timing-function: ease-out;
	-ms-animation-timing-function: ease-out;
	animation-timing-function: ease-out;
	-webkit-animation-name: scaleOut;
	-moz-animation-name: scaleOut;
	-ms-animation-name: scaleOut;
	-o-animation-name: scaleOut;
	animation-name: scaleOut;
}

.animate{
	-webkit-animation-duration: 0.5s;
	-webkit-animation-fill-mode: both;	
	-moz-animation-duration: 0.5s;
	-moz-animation-fill-mode: both;	
	-o-animation-duration: 0.5s;
	-o-animation-fill-mode: both;	
	-ms-animation-duration: 0.5s;
	-ms-animation-fill-mode: both;	
	animation-duration: 0.5s;
	animation-fill-mode: both;
}

.lt8 #x264_nologged_wrap input{
	padding: 10px 5px 10px 32px;
    width: 92%;
}
.lt8 #x264_nologged_wrap input[type=checkbox]{
	width: 10px;
	padding: 0;
}

.lt8 #x264_nologged_wrap h1{
	color: #066A75;
}

.lt8 #register{	
	display: none;
}

.lt8 #kontakt{	
	display: none;
}

.lt8 p.change_link,
.ie9 p.change_link{
	position: absolute;
	height: 90px;
	background: transparent;
}


/* -------------------
	Default State
-------------------- */
.inner {
        transition-property(all);
        transition-duration(.2s);
        transition-timing-function(ease-out);
}