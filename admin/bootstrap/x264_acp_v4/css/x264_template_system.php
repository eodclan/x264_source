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
@font-face {
	font-family: 'LeagueGothicRegular';
	src: url('../fonts/League_Gothic-webfont.eot');
	src: url('../fonts/League_Gothic-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/League_Gothic-webfont.woff') format('woff'),
         url('../fonts/League_Gothic-webfont.ttf') format('truetype'),
         url('../fonts/League_Gothic-webfont.svg#LeagueGothicRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'BebasNeueRegular';
    src: url('../fonts/bebasneue-webfont.eot');
    src: url('../fonts/bebasneue-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/bebasneue-webfont.woff') format('woff'),
         url('../fonts/bebasneue-webfont.ttf') format('truetype'),
         url('../fonts/bebasneue-webfont.svg#BebasNeueRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'BoycottRegular';
    src: url('../fonts/boycott_-webfont.eot');
    src: url('../fonts/boycott_-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/boycott_-webfont.woff') format('woff'),
         url('../fonts/boycott_-webfont.ttf') format('truetype'),
         url('../fonts/boycott_-webfont.svg#BoycottRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'ZeroIsRegular';
    src: url('../fonts/zero_and_zero_is-webfont.eot');
    src: url('../fonts/zero_and_zero_is-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/zero_and_zero_is-webfont.woff') format('woff'),
         url('../fonts/zero_and_zero_is-webfont.ttf') format('truetype'),
         url('../fonts/zero_and_zero_is-webfont.svg#Zero&ZeroIsRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'SnicklesRegular';
    src: url('../fonts/snickles-webfont.eot');
    src: url('../fonts/snickles-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/snickles-webfont.woff') format('woff'),
         url('../fonts/snickles-webfont.ttf') format('truetype'),
         url('../fonts/snickles-webfont.svg#SnicklesRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'QlassikRegular';
    src: url('../fonts/qlassik_tb-webfont.eot');
    src: url('../fonts/qlassik_tb-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/qlassik_tb-webfont.woff') format('woff'),
         url('../fonts/qlassik_tb-webfont.ttf') format('truetype'),
         url('../fonts/qlassik_tb-webfont.svg#QlassikMediumRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'GoodDogRegular';
    src: url('../fonts/gooddog-webfont.eot');
    src: url('../fonts/gooddog-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/gooddog-webfont.woff') format('woff'),
         url('../fonts/gooddog-webfont.ttf') format('truetype'),
         url('../fonts/gooddog-webfont.svg#GoodDogRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'TendernessRegular';
    src: url('../fonts/tenderness-webfont.eot');
    src: url('../fonts/tenderness-webfont.eot?#iefix') format('embedded-opentype'),
         url('../fonts/tenderness-webfont.woff') format('woff'),
         url('../fonts/tenderness-webfont.ttf') format('truetype'),
         url('../fonts/tenderness-webfont.svg#TendernessRegular') format('svg');
    font-weight: normal;
    font-style: normal;
}

.team_wrap{
	width:214px;
	float:left;
	margin:10px 0 0 12px;
	border:none 5px #000000;
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
	border-bottom-left-radius: 15px;
	border-bottom-right-radius: 15px;
	background-color:rgba(19,19,19,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	margin-left: auto;
	margin-right: auto;
	padding:20px;
	z-index: 1;	
}
.team_ava{
	width:60px;
	height:60px;
	overflow:hidden;
	margin:5px 10px 5px 5px;
	padding:5px;
	float:left;
	border:none 5px #000000;
}
.team_all_wrap{
	border:none 5px #000000;
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
	border-bottom-left-radius: 15px;
	border-bottom-right-radius: 15px;
	background-color:rgba(19,19,19,1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	z-index: 1;	
	padding-bottom:10px;
}

.alert-box {
    color:#555;
    border-radius:10px;
    font-family:Tahoma,Geneva,Arial,sans-serif;font-size:11px;
    padding:10px 10px 10px 36px;
    margin:10px;
}

.alert-box span {
    font-weight:bold;
    text-transform:uppercase;
}

.notice {
    background:rgba(20, 20, 20, 1) url('../images/notice.png') no-repeat 10px 50%;
    border:1px solid #8ed9f6;
}

.success {
    background:#e9ffd9 url('../images/success.png') no-repeat 10px 50%;
    border:1px solid #a6ca8a;
}

.x264_shadetabs {
	display: block;
	float: left;
	padding-left: 25px;
	list-style: none;
	border-width: 0;
	border-top-width: 1px;
	line-height: 21px;
	white-space: normal;
	font-family:tahoma,helvetica;
	color:#e7e7e7;
	font-size:14px;
	text-align: center;
	text-decoration: none;
	text-shadow: -1px 2px 3px #333333;
}

.x264_shadetabs{
	display: block;
	float: left;
	padding-left: 40px;
	list-style: none;
	border-width: 0;
	border-top-width: 1px;
	line-height: 21px;
	white-space: normal;
	font-family:tahoma,helvetica;
	color:#e7e7e7;
	font-size:14px;
	text-align: center;
	text-decoration: none;
	text-shadow: -1px 2px 3px #333333;
}

.x264_shadetabs li{
	display: block;
	float: left;
	padding-left: 40px;
	list-style: none;
	border-width: 0;
	border-top-width: 1px;
	line-height: 21px;
	white-space: normal;
	font-family:tahoma,helvetica;
	color:#e7e7e7;
	font-size:14px;
	text-align: center;
	text-decoration: none;
	text-shadow: -1px 2px 3px #333333;
}

.x264_shadetabs li a{
	display: block;
	float: left;
	padding-left: 40px;
	list-style: none;
	border-width: 0;
	border-top-width: 1px;
	line-height: 21px;
	white-space: normal;
	font-family:tahoma,helvetica;
	color:#e7e7e7;
	font-size:14px;
	text-align: center;
	text-decoration: none;
	text-shadow: -1px 2px 3px #333333;
}

.x264_shadetabs li a:visited{
	display: block;
	float: left;
	padding-left: 40px;
	list-style: none;
	border-width: 0;
	border-top-width: 1px;
	line-height: 21px;
	white-space: normal;
	font-family:tahoma,helvetica;
	color:#e7e7e7;
	font-size:14px;
	text-align: center;
	text-decoration: none;
	text-shadow: -1px 2px 3px #333333;
}

.x264_shadetabs li a:hover{
	display: block;
	float: left;
	padding-left: 40px;
	list-style: none;
	border-width: 0;
	border-top-width: 1px;
	line-height: 21px;
	white-space: normal;
	font-family:tahoma,helvetica;
	color:#e7e7e7;
	font-size:14px;
	text-align: center;
	text-decoration: none;
	text-shadow: -1px 2px 3px #333333;
}

.x264_shadetabs li.selected{
position: relative;
top: 1px;
}

.x264_shadetabs li.selected a{ /*selected main tab style */
background-color: #2E2E2E;
border: 1px solid ;
border-top-color: black;
border-right-color: black;
border-left-color: black;
border-bottom-color: black;
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;
}

.x264_shadetabs li.selected a:hover{ /*selected main tab style */
text-decoration: none;
}

.x264_left_sidebar {
	float: left;
	position: relative;
	width: 150px;
	z-index: 1;
}
.x264_sidebar{
	width: 18%;
 }

#x264_footer{
	overflow:hidden;
	width:100%;
	height:20px;
}

#x264_footer_content{
	width:100%;
	height:20px;
}

.x264_wrapper_br{
	height:20px;
}

.x264_tfiles_br{
	height:45px;
}

.x264_smilies_bar {
	width:15%;
	float: left;
	border:none 5px #000000;
	background-color:rgba(20, 20, 20, 1);
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	margin-left: auto;
	margin-right: auto;
	padding:20px;
	max-height:80%;
	z-index: 1;
}

.x264_profile{
	margin:5px 0 0 0;
	padding:2px;
	background: radial-gradient(ellipse at center, #262626 0%,rgb(26,26,26) 100%);
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
	border-bottom-left-radius: 15px;
	border-bottom-right-radius: 15px;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
}

#x264_footer_copyright{
	width:98,5%;
	padding:9px;
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

#x264_wrapper_welcome{
	width:98,5%;
	padding:9px;
	background: url(../img/back3.png);
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
	text-align:left;
}

.x264_wrapper_welcome_salting{
	text-align:right;
}

#x264_footer_copyright_mount{
	width:98,5%;
	height:30px
	margin-left: auto;
	margin-right: auto;
	line-height:30px;
	text-align:center;
	font-weight:bold;
	text-shadow: 0px 0px 5px rgba(0, 0, 0, 0.8), -1px -1px #000;
	padding: 10px;
	overflow:hidden;
	z-index: 1;
}

#x264_title_effect{
	background: -moz-linear-gradient(left center , rgba(30, 144, 255, 0) 0%, rgba(30, 144, 255, 0.8) 20%, rgba(30, 144, 255, 1) 53%, rgba(30, 144, 255, 0.8) 79%, rgba(30, 144, 255, 0) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
	background: -icab-linear-gradient(left center , rgba(30, 144, 255, 0) 0%, rgba(30, 144, 255, 0.8) 20%, rgba(30, 144, 255, 1) 53%, rgba(30, 144, 255, 0.8) 79%, rgba(30, 144, 255, 0) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
	background: -khtml-linear-gradient(left center , rgba(30, 144, 255, 0) 0%, rgba(30, 144, 255, 0.8) 20%, rgba(30, 144, 255, 1) 53%, rgba(30, 144, 255, 0.8) 79%, rgba(30, 144, 255, 0) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
	background: -webkit-linear-gradient(left center , rgba(30, 144, 255, 0) 0%, rgba(30, 144, 255, 0.8) 20%, rgba(30, 144, 255, 1) 53%, rgba(30, 144, 255, 0.8) 79%, rgba(30, 144, 255, 0) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
	background: -o-linear-gradient(left center , rgba(30, 144, 255, 0) 0%, rgba(30, 144, 255, 0.8) 20%, rgba(30, 144, 255, 1) 53%, rgba(30, 144, 255, 0.8) 79%, rgba(30, 144, 255, 0) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
	content: " ";
	display: block;
	height: 2px;
	margin-top: 5px;
	width: 100%;
}

#x264_footer_logo{
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	background-image:url(../framework/x264_footer_logo.png);
	background-position:0 0;
	width:319px;
	height:93px;
	margin-left: auto;
	margin-right: auto;
	cursor:pointer;
	overflow:hidden;
	margin-left: auto;
	margin-right: auto;
	border:none 5px #000000;
	-moz-border-radius: 31px;
	-webkit-border-radius: 31px;
	border-radius: 31px;
}

#x264_footer_logo:hover{
	background-position:0 -93px;
}


.x264_header{
	overflow:hidden;
	width:100%;
}

.x264_header_content{
	overflow:hidden;
}

.x264_header_logo{
	overflow:hidden;
	width:100%;
	height:120px;
	text-align: center;
}

#x264_wrapper_out_content{
	margin-left: auto;
	margin-right: auto;
	width:91%;
	background-color: rgb(11, 11, 11);
	border: 1px solid rgb(35, 35, 35);
	-webkit-border-top-left-radius: 10px;
	-moz-border-radius-topleft: 10px;
	-khtml-border-top-left-radius: 10px;
	border-top-left-radius: 10px;
	-webkit-border-top-right-radius: 10px;
	-moz-border-radius-topright: 10px;
	-khtml-border-top-right-radius: 10px;
	border-top-right-radius: 10px;
}

.x264_wrapper{
	width: 98.6%;
	overflow:hidden;
	class="support css-property">-webkit-box-sizing: content-box;
	-moz-box-sizing: content-box;
	box-sizing: content-box;
	border: none;
	color: rgba(255,255,255,1);
	text-align: center;
	-o-text-overflow: ellipsis;
	text-overflow: ellipsis;
background: rgba(15, 4, 0, 1);

	background-position: 50% 50%;
	-webkit-background-origin: padding-box;
	background-origin: padding-box;
	-webkit-background-clip: border-box;
	background-clip: border-box;
	-webkit-background-size: auto auto;
	background-size: auto auto;
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
	border-bottom-left-radius: 15px;
	border-bottom-right-radius: 15px;
	-moz-border-radius: 21px;
	-webkit-border-radius: 21px;
	border-radius: 21px;
	text-shadow: -1px 2px 3px #333333;
	margin-left: auto;
	margin-right: auto; 
}

#x264_wrapper{
	background-color:rgba(36, 36, 36, 1);
	border:1px inset 0 0 6px rgba(19, 19, 19, 1);
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	width: 98.6%;
	margin-left: auto;
	margin-right: auto;
	margin:0px auto auto;
	margin-bottom:250px;
}

.x264_wrapper_content{
	width: 98.6%;
	margin-left: auto;
	margin-right: auto;
	z-index: 1;

}

.x264_wrapper_content_out_mount{
	width:96,5%;
	border:1px inset 0 0 6px rgba(19, 19, 19, 1);
	background: url(../images/tcatRight.png);
	background-repeat:repeat-x;
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

#x264_wrapper_content_out_requests{
	width:96,5%;
	border:1px inset 0 0 6px rgba(19, 19, 19, 1);
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

h1.x264_im_logo{
	color: #606060; 
	font: normal normal 17px BebasNeueRegular,Arial,sans-serif;
	font-size: 17px;  
	color: rgb(255, 255, 255);
	padding-top: 9px;
	padding-bottom: 4px;
	padding-left: 10px;
	margin: -12px -10px 5px;
	height: 28px;
	text-transform: uppercase;
	text-align: center;
	letter-spacing: 1px;
	z-index: 2; 
}

h1.x264_im_logo:after{		
	content: " "; 
	display: block; 
	height: 2px; 
	margin-top: 5px; 
	width: 100%; 
}

.x264_system_table{
	width:72px;
	height:24px;
}

.x264_title_tablename {
	color: #590700; 
	font-family: 'FranchiseRegular','Arial Narrow',Arial,sans-serif;
	font-size: 14px; 
	font-style: italic; 
	margin: 0 0 10px 2px; 
	text-align: center; 
	text-shadow: 2px 2px 1px #000000; 
	z-index: 2;  
}

.x264_title_content_sitelog {
	margin-left: auto;
	margin-right: auto;
	border:2px solid #111;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	background-color:rgba(20,20,20,1);
	overflow:hidden;
	text-align:center;
}

.x264_title_sitelog_tab {
	float: left;
	width:270px;
	border:2px solid #111;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	background-color:rgba(20,20,20,1);
	overflow:hidden;
	text-align:center;
}
.x264_title_sitelog_tab_ergebnis {
	float: left;
	width:170px;
	border:2px solid #111;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	background-color:rgba(20,20,20,1);
	overflow:hidden;
	text-align:center;
}

.x264_title_sitelog_tab_ergebnis_text {
	float: left;
	width:370px;
	border:2px solid #111;
	-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;
	background-color:rgba(20,20,20,1);
	overflow:hidden;
	text-align:center;
}

.x264_title_tablename:after {
	background: -moz-linear-gradient(left,  hsla(0,0%,7%,0) 0%, hsla(0,0%,7%,0.8) 15%, hsla(0,0%,7%,1) 19%, hsla(0,0%,7%,1) 20%, hsla(0,0%,5%,1) 50%, hsla(0,0%,7%,1) 80%, hsla(0,0%,7%,1) 81%, hsla(0,0%,7%,0.8) 85%, hsla(0,0%,7%,0) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, right top, color-stop(0%,hsla(0,0%,7%,0)), color-stop(15%,hsla(0,0%,7%,0.8)), color-stop(19%,hsla(0,0%,7%,1)), color-stop(20%,hsla(0,0%,7%,1)), color-stop(50%,hsla(0,0%,5%,1)), color-stop(80%,hsla(0,0%,7%,1)), color-stop(81%,hsla(0,0%,7%,1)), color-stop(85%,hsla(0,0%,7%,0.8)), color-stop(100%,hsla(0,0%,7%,0))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(left,  hsla(0,0%,7%,0) 0%,hsla(0,0%,7%,0.8) 15%,hsla(0,0%,7%,1) 19%,hsla(0,0%,7%,1) 20%,hsla(0,0%,5%,1) 50%,hsla(0,0%,7%,1) 80%,hsla(0,0%,7%,1) 81%,hsla(0,0%,7%,0.8) 85%,hsla(0,0%,7%,0) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(left,  hsla(0,0%,7%,0) 0%,hsla(0,0%,7%,0.8) 15%,hsla(0,0%,7%,1) 19%,hsla(0,0%,7%,1) 20%,hsla(0,0%,5%,1) 50%,hsla(0,0%,7%,1) 80%,hsla(0,0%,7%,1) 81%,hsla(0,0%,7%,0.8) 85%,hsla(0,0%,7%,0) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(left,  hsla(0,0%,7%,0) 0%,hsla(0,0%,7%,0.8) 15%,hsla(0,0%,7%,1) 19%,hsla(0,0%,7%,1) 20%,hsla(0,0%,5%,1) 50%,hsla(0,0%,7%,1) 80%,hsla(0,0%,7%,1) 81%,hsla(0,0%,7%,0.8) 85%,hsla(0,0%,7%,0) 100%); /* IE10+ */
	background: linear-gradient(to right,  hsla(0,0%,7%,0) 0%,hsla(0,0%,7%,0.8) 15%,hsla(0,0%,7%,1) 19%,hsla(0,0%,7%,1) 20%,hsla(0,0%,5%,1) 50%,hsla(0,0%,7%,1) 80%,hsla(0,0%,7%,1) 81%,hsla(0,0%,7%,0.8) 85%,hsla(0,0%,7%,0) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00111111', endColorstr='#00111111',GradientType=1 ); /* IE6-9 */
	content: " "; 
	display: block; 
	height: 2px; 
	margin-top: 5px; 
	width: 100%;   
}

.x264_title{
	text-align:center;
	margin-left: auto;
	margin-right: auto;
	background-color: rgb(18, 18, 18);
	padding: 1px;
	border-bottom: 1px solid rgb(35, 35, 35);
	overflow:hidden;
}

.x264_title_content{
	text-align:center;
	margin-left: auto;
	margin-right: auto;
	background-color: rgb(18, 18, 18);
	padding: 1px;
	border-bottom: 1px solid rgb(35, 35, 35);
	overflow:hidden;
}

#x264_title_content{
	text-align:center;
	margin-left: auto;
	margin-right: auto;
	background-color: rgb(18, 18, 18);
	padding: 1px;
	border-bottom: 1px solid rgb(35, 35, 35);
	overflow:hidden;
}

.x264_title_table{
	text-align:center;
	margin-left: auto;
	margin-right: auto;
	background-color: rgb(18, 18, 18);
	padding: 1px;
	border-bottom: 1px solid rgb(35, 35, 35);
	overflow:hidden;
}

.x264_title_news_table{
	text-align:center;
	margin-left: auto;
	margin-right: auto;
	background-color: rgb(18, 18, 18);
	padding: 1px;
	border-bottom: 1px solid rgb(35, 35, 35);
	overflow:hidden;
}

.clients_a, .clients_b, .clients_c, .clients_d{
	height:20px;
	line-height:20px;
	float:left;
	padding-left:5px;
}
.clients_a{width:270px;}
.clients_b{width:100px;}
.clients_c{width:240px;}
.clients_d{width:100px;}

.clients_green, .clients_red{
	width:20px;
	height:10px;
	margin:5px 5px 0 0;
	float:left;
}
.clients_green{background-color:green;}
.clients_red{background-color:red;}

.clie_good, .clie_bad{
	width:296px;
	height:20px;
	margin:5px 0 0 5px;
	float:left;
	line-height:20px;
	text-align:center;
}
.clie_good{border:1px solid #0B610B;}
.clie_bad{border:1px solid #8A0808;}

.tag_wrap{
	width:420px;
	height:140px;
	float:left;
	margin:8px;	
	padding:10px;
}
.tag_a{
	letter-spacing:0.3em;	
	padding:5px;
	margin:0 0 5px 0;
}
.tag_b{	
	padding:5px;
	margin:0 0 5px 0;
}

#show_stats_wrap{
	padding:20px;
	margin:20px 0 0 0;
	border:1px solid #111;
	border:2px solid #111;
}
.show_stats_value{
	padding:5px;
	margin:0 0 3px 0;
	border:2px solid #111;
}
.show_stats_value label{
	display:block;
	float:left;
	width:300px;
	font-weight:bold;
	padding-left:5px;
}
.show_stats_erg{
	float:left;
}
.show_stats_balk1{
	width:402px;
	height:15px;
	background-image: url(../loadbarbg.gif); 
	background-repeat: repeat-x;
	border:2px solid #111;
}
.show_stats_balk2{
	width:402px;
	height:15px;
	float:left;
	margin-right:5px;
	background-image: url(../loadbarbg.gif); 
	background-repeat: repeat-x;
	border:2px solid #111;
}
#show_stats_alluser{
	padding:10px;
	text-align:center;
	border:2px solid #111;
}

#x264_slot_machine {
	width: 44%;
	margin-left: auto ;
	margin-right: auto ;
	background-color: rgba(28,28,28,1);
	border: 1px solid #404040;
	border-radius: 10px;
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8),inset 0 1px 0 rgba(225,225,225,0.15),inset 0 0 2px rgba(225,225,225,0.1);
}

.x264_slot_machine_pic {
	padding-left:115px;
}

#jquery-overlay {
	position: absolute;
	top: 0;
	left: 0;
	z-index: 90;
	width: 100%;
	height: 500px;
}
#jquery-lightbox {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	z-index: 100;
	text-align: center;
	line-height: 0;
}
#jquery-lightbox a img { border: none; }
#lightbox-container-image-box {
	position: relative;
	background-color: #fff;
	width: 250px;
	height: 250px;
	margin: 0 auto;
}
#lightbox-container-image { padding: 10px; }
#lightbox-loading {
	position: absolute;
	top: 40%;
	left: 0%;
	height: 25%;
	width: 100%;
	text-align: center;
	line-height: 0;
}
#lightbox-nav {
	position: absolute;
	top: 0;
	left: 0;
	height: 100%;
	width: 100%;
	z-index: 10;
}
#lightbox-container-image-box > #lightbox-nav { left: 0; }
#lightbox-nav a { outline: none;}
#lightbox-nav-btnPrev, #lightbox-nav-btnNext {
	width: 49%;
	height: 100%;
	zoom: 1;
	display: block;
}
#lightbox-nav-btnPrev { 
	left: 0; 
	float: left;
}
#lightbox-nav-btnNext { 
	right: 0; 
	float: right;
}
#lightbox-container-image-data-box {
	font: 10px Verdana, Helvetica, sans-serif;
	background-color: #fff;
	margin: 0 auto;
	line-height: 1.4em;
	overflow: auto;
	width: 100%;
	padding: 0 10px 0;
}
#lightbox-container-image-data {
	padding: 0 10px; 
	color: #666; 
}
#lightbox-container-image-data #lightbox-image-details { 
	width: 70%; 
	float: left; 
	text-align: left; 
}	
#lightbox-image-details-caption { font-weight: bold; }
#lightbox-image-details-currentNumber {
	display: block; 
	clear: left; 
	padding-bottom: 1.0em;	
}			
#lightbox-secNav-btnClose {
	width: 66px; 
	float: right;
	padding-bottom: 0.7em;	
}  