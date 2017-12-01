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

/* Page Wrapper
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

#pageWrapper {
	background:rgba(13, 13, 13, 1) url(../images/pageTopBG.png) repeat-x top left;
	width:100%;
	margin-left: auto;
	margin-right: auto;
	overflow:hidden;
}
.pageBottom {
	background:url(../images/pageBottomBG.png) repeat-x bottom left;
}
.pageWrap {
	width:990px;
	margin:0 auto 0 auto;
}

/* Top Bar
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
#topBar {
	height:39px;
	width:99%;
	line-height: 39px;
	padding: 9px;
	color: #a2a2a2
	margin-left: auto;
	margin-right: auto;
}
.topBarWelcome {
	float: left;
}
.socialBox {
	float: right;
	height: 24px;
	line-height: 24px;
	padding-top:6px;
}
.socialBox span {
	padding-right:6px;
}
.socialBox img {
	vertical-align: middle;
}

/* Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
.above_body {
	background:none;
}
.doc_header {

	height:100px;
	position: relative
}
#headerMain {

	height:100px;
	position: relative;
}
#logo {
	position: absolute;
	top:8px;
	left:19px;
}


/* Content
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
#contentOutline {
	background: url(../images/contentOutlineTopBG.png) repeat-x top left;
}
.contentOutlineBottom {
	background: url(../images/contentOutlineBottomBG.png) repeat-x bottom left;
}
.contentOutlineTL {
	background:url(../images/contentOutlineTL.png) no-repeat top left;
}
.contentOutlineTR {
	background:url(../images/contentOutlineTR.png) no-repeat top right;
}
.contentOutlineBL {
	background:url(../images/contentOutlineBL.png) no-repeat bottom left;
}
.contentOutlineBR {
	background: url(../images/contentOutlineBR.png) no-repeat bottom right;
	padding: 17px 15px 57px 15px;
}
#contentBox {}
#contentBody {
	background:#000;
	padding:0 20px;
}



/* Navbar
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
#navigation {
	background: url(../images/navigationBG.png) no-repeat top center;
	height: 20px;
	padding: 0 20px;
	margin-bottom: 0;
}
.navbar {
	-moz-border-radius-bottomleft: 0 !important;
	-moz-border-radius-bottomright: 0 !important;
	-webkit-border-bottom-left-radius: 0 !important;
	-webkit-border-bottom-right-radius: 0 !important;
}
.navbar {
	background:none;
	position:relative;
	height:109px;
	font:   12px Arial, Calibri, Verdana, Geneva, sans-serif;
	color:#989898;
	width:100%;
	padding:0;
	margin:0;
}
.navbar {
	background: url(../images/navBG.png) repeat-x top left;
	height: 109px;
	position: relative;
}
.navLeft {
	background: url(../images/navLeft.png) no-repeat top left;
	height: 109px;
}
.navRight {
	background: url(../images/navRight.png) no-repeat top right;
	height: 109px;
}
#navtabs ul.floatcontainer {
	margin-top:16px;
}
#navtabs ul.floatcontainer a:link, #navtabs ul.floatcontainer a:visited {
	line-height:27px;
	height:27px;
}
.navbar a { color:#989898; }
.navbar a:hover { color:#205ec0; }

.navtabs ul li:first-child {
	margin-left: 14px;
	text-indent: 0;
}
.navtabs li:last-child {
	background:none;
}
.navtabs {
	background:none;
	padding-left:0;
}
.navtabs ul {
	position:absolute;
	top:60px;
	left:0px;
	width:100%;
/* This is to fix RTL menu issue under Opera */
        direction:ltr;
}
.navtabs li {
	background:url(../images/navSplit.png) no-repeat right;
	float:left;
	padding-right:1px;
}
.navtabs ul li {
	background:none;
}
.navtabs ul li {
	border-right: 0;
	position: relative;
}
.navtabs li a {
	height:60px;
	line-height:60px;
}
.navtabs li a.navtab {
	display:block;
	min-width:60px;
	width:auto !important;
	width:60px;
	_min-width:75px;
	_width:auto !important;
	_width:75px;
	text-align:center;
	color:#989898;
	font:  normal 18px arial, helvetica, sans-serif;
	text-decoration:none;
	line-height:57px;
	height:57px;
	padding:3px 10px 0 10px;
	background:none;
}
.navtabs li a.navtab:hover {
	background:none;
	color:#205ec0;
}
.navtabs li.selected {
	color:#205ec0;
	height:60px;
}
.navtabs li.selected a.navtab {
	background:none;
	color:#205ec0;
	position:relative;
	top:-px;
	padding-top:px;
	z-index:10;
}

.navtabs ul.floatcontainer {
	color:#205ec0;
	height:60px;
}
.navtabs ul.floatcontainer a.navtab {
	background:none;
	color:#205ec0;
	position:relative;
	top:-px;
	padding-top:px;
	z-index:10;
}
.navtabs ul.floatcontainer li a,
.navbar_advanced_search li a {
	text-decoration:none;
	font:   12px Arial, Calibri, Verdana, Geneva, sans-serif;
	line-height:27px;
}
.navtabs ul.floatcontainer li {
	padding:0 3px 0 0;
}
.navtabs ul.floatcontainer li li {
	padding:0 2px;
}
.navtabs ul.floatcontainer li a {
	color:#7d7d7d;
	font-weight:400;
	padding:2px 3.3333333333333px;
	z-index:3001;
}

.navbar_advanced_search li {
	height:27px;
	display:block;
	clear:both;
}

.navbar_advanced_search li a {
	color:#989898;
}

.navbar_advanced_search li a:hover {
	color:#205ec0;
	text-decoration:none;
}

.navtabs ul.floatcontainer li a:hover {
	color:#ededed;
	text-decoration:none;
}

.navtabs ul.floatcontainer .popupbody li > a {
	padding:0pxpx 10px;
	text-indent: 0;
	color: ;
}

.navtabs ul.floatcontainer li a.popupctrl {
	-moz-border-radius:3px;
	-webkit-border-radius:3px;	
	border:solid px transparent;
	_border: none;
	background:transparent url(../images/arrow.png) no-repeat right center;
	padding-right:15px;
        _background-image:url('../images/arrow.gif');
	color:#7d7d7d;
}
.navtabs ul.floatcontainer li:hover a.popupctrl {
	background:#000 url(../images/arrow.png) no-repeat right center;
}

.navtabs ul.floatcontainer li:hover a.popupctrl.active,
.navtabs ul.floatcontainer li a.popupctrl.active {
	background:#000 url(../images/arrow.png) no-repeat right center;
}
.navtabs ul.floatcontainer li:hover a.popupctrl.active,
.navtabs ul.floatcontainer li a.popupctrl.active,
.navtabs ul.floatcontainer li a:hover.popupctrl {
	color:#fff;
}


/* tcat Bars (Title Bars for Forum Home, Forum Display & Postbit)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
.tcat {
	background: url(../images/tcatBG.png) repeat-x left top;
	float: left;
	width: 100%;
	color: #fff;
	height:41px;
	clear:both;
	padding:0;
	margin:8px 0 0 0;
	border:0;
	position:relative;
}
.tcatLeft {
	background: url(../images/tcatLeft.png) no-repeat left top;
	height:41px;
}
.tcatRight {
	background: url(../images/tcatRight.png) no-repeat right top;
	height:41px;
}
.tcat .forumtitle {
	font-weight:700;

}
.tcat .tcatDesc {
	color:#a8c4ff;
	text-shadow:1px 1px #3a0000;
	font-size:12px;
	font-weight:400;
}
.tcat h2 {
	padding-left:16px;
	font:   bold 16px arial, helvetica, sans-serif;
	line-height:41px;
	float:left;
}
.tcat a:link, .tcat a:visited {
	color:#fff;
}
.tcat a:hover {

}
.tcat .tcatCollapse {
	position:absolute;
	top:8px;
	right:8px;
}
/* tcat Thread List Controls - Forumdisplay */
.tcat_threadlist_controls {
	float:right;
	padding-right:8px;
}
.forumdisplaypopups, #forumdisplaypopups {
	clear:both;
}
.tcat_threadlist_controls h6 {
	height:41px;
	line-height:41px;
	padding:0;
	display:block;
	font-size:12px;
}
.forumdisplaypopups a.popupctrl, .forumdisplaypopups.popupgroup .popupmenu a.popupctrl,
.postlist_popups h6 a.popupctrl, .postlist_popups.popupgroup .popupmenu h6 a.popupctrl {
	background:none;
	display:block;
	_display:41px;
	height:41px;
	line-height:41px;
	font-family:arial, helvetica, sans-serif;
	font-weight:bold;
	font-size:12px;
	font-weight:700;
	color:#fff;
	padding:0 10px;
	border: 0;
	float: left;
	clear: right;
}
.forumdisplaypopups a:hover.popupctrl, .forumdisplaypopups.popupgroup .popupmenu a:hover.popupctrl,
.postlist_popups h6 a:hover.popupctrl, .postlist_popups.popupgroup .popupmenu h6 a:hover.popupctrl {
	border: 0;
	color:#fff;
	text-decoration:underline;
}
#postlist_popups a, .postlist_popups a {
	color: #fff;
	_border: none;
}
#postlist_popups a:hover, .postlist_popups a:hover {
	color: #fff;
	text-decoration:underline;
}
#postlist_popups .popupmenu:hover a.popupctrl, #postlist_popups .popupmenu:hover .popupctrl a.popupctrl.active, .postlist_popups .popupmenu:hover a.popupctrl, .postlist_popups .popupmenu:hover .popupctrl a.popupctrl.active {
	border: 0;
}

#postlist_popups ul li {
	color:#8a8a8a;
}
#postlist_popups ul li a, .postlist_popups ul li a {
	color:#8a8a8a;
	_border: none;
}

#postlist_popups ul li a:hover, .postlist_popups ul li a:hover {
	color:#8a8a8a;
	text-decoration:underline;
}

#forumdisplaypopups ul a, .forumdisplaypopups ul a {
	color:#8a8a8a;
}

