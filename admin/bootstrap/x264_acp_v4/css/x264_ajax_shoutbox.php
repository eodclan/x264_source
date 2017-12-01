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
	font-family: 'ds_c';
	src: url('../fonts/ds_c.ttf') format('ds_c'),
	url('../fonts/ds_c.ttf') format('ds_c'),
	url('../fonts/ds_c.ttf') format('truetype');
}

.x264_warp_shoutbox_framework_tablea{
	border:2px solid #111;
	border-radius:1px 1px 1px 1px;
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	background: rgba(30,30,30,1);
	overflow:hidden;
	border-radius:1px 1px 1px 1px;
}

.x264_warp_shoutbox_framework_time
	font-family: 'FranchiseRegular','Arial Narrow',Arial,sans-serif;
	font-size: 14px; 
	font-style: italic; 
	color: rgba(19,19,19,1);{
	border:2px solid #111;
	border-radius:1px 1px 1px 1px;
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	background-color:rgba(20,20,20,1);
	overflow:hidden;
	border-radius:1px 1px 1px 1px;
}

.x264_warp_shoutbox_bbcode{
	border:2px solid #111;
	border-radius:1px 1px 1px 1px;
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	background-color:rgba(20,20,20,1);
	border-radius:1px 1px 1px 1px;
	overflow:auto;
}

.x264_warp_shoutbox_framework{
	border:2px solid #111;
	border-radius:1px 1px 1px 1px;
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	background-color:rgba(20,20,20,1);
	border-radius:1px 1px 1px 1px;
	overflow:auto;
}

#x264_warp_shoutbox{
	height:28px;
	width:99.9%;
	line-height:26px;
	background-color:#1A1A1A;
	border:1px solid #000000;
	overflow:auto;
}

#x264_warp_shoutbox_tab{
	width:100px;
	height:20px;
	position:absolute;
	margin:3px 0 0 5px;
}

#x264_warp_shoutbox_tab2{
	width:100px;
	height:20px;
	position:absolute;
	margin:3px 0 0 90px;
}

#x264_warp_shoutbox_tab3{
	font-family:ds_c;
	font-size: 17px;
	width:280px;
	height:20px;
	position:absolute;
	margin:3px 0 0 3px;
}

#x264_warp_shoutbox_tab4{
	width:190px;
	height:20px;
	position:absolute;
	margin:3px 0 0 145px;
}

#x264_warp_shoutbox_shoutcast{
	width:650px;
	height:20px;
	position:absolute;
	margin:3px 0 0 263px;
}

#x264_warp_shoutbox_smilies{
	background-color:#1A1A1A;
	border:1px solid #000000;
	width:650px;
	height:20px;
	position:absolute;
	margin:3px 0 0 263px;
}

.x264_warp_shoutbox_tab{
	background-color:#1A1A1A;
	border:1px solid #000000;
}

#x264_warp_shoutbox_navi{
	padding-left:14%;
	padding-right:11%;
	width:74%;
	margin:10px;
}

#x264_warp_shoutbox_smilie_navi{
	background:linear-gradient(-45deg,#191919,#111111,#333333,#111111,#191919);
	height:44px;
	width:90%;
	border: 5px double #0A0A0A;
	border-radius: 0px 60px;
	box-shadow:0 0 8px #000;
	margin:auto;
}

.x264_warp_shoutbox_innavi{
	text-align:center;
	position:relative;
	height:40px;
	z-index:20;
	perspective:100px;
	margin:0;
}

.ul.x264_warp_shoutbox_ul_inc li a.x264_warp_shoutbox_ul_inc{
	display:block;
	text-decoration:none;
	margin-top:10px;
	float:left;
	height:25px;
	font-family:Lucida-Console,serif;
	font-size:15px;
	font-weight:400;
	line-height:25px;
	border-radius:4px 4px 4px 4px;
	box-shadow:0 1px 5px #190707;
}

.ul.x264_warp_shoutbox_ul_inc li:hover a.x264_warp_shoutbox_ul_inc{
	border-radius:4px 4px 4px 4px;
	box-shadow:inset 0 1px 2px #190707;
}

.x264_warp_sb_smilies1{position:relative;z-index:24}.x264_warp_sb_smilies1 span{background:linear-gradient(-45deg,#191919,#111,#333,#111,#191919);border:2px solid black;border-radius:30px 0;display:block;font-family:Verdana,Arial,Helvetica,sans-serif;position:absolute;left:-15em;top:35px;padding:15px;text-decoration:none;transition:opacity .6s ease-in-out 0s,visibility 1s ease-in-out 0s;visibility:hidden;width:41em;height:17em;z-index:25}.bt_smilies1:hover{z-index:25}.x264_warp_sb_smilies1:hover span{position:absolute;visibility:visible}
.x264_warp_sb_smilies2{position:relative;z-index:24}.x264_warp_sb_smilies2 span{background:linear-gradient(-45deg,#191919,#111,#333,#111,#191919);border:2px solid black;border-radius:30px 0;display:block;font-family:Verdana,Arial,Helvetica,sans-serif;position:absolute;left:-5em;top:35px;padding:15px;text-decoration:none;transition:opacity .6s ease-in-out 0s,visibility 1s ease-in-out 0s;visibility:hidden;width:42em;height:18em;z-index:25}.bt_smilies2:hover{z-index:25}.x264_warp_sb_smilies2:hover span{opacity:1;position:absolute;visibility:visible}
.x264_warp_sb_smilies3{position:relative;z-index:24}.x264_warp_sb_smilies3 span{background:linear-gradient(-45deg,#191919,#111,#333,#111,#191919);border:2px solid black;border-radius:30px 0;display:block;font-family:Verdana,Arial,Helvetica,sans-serif;position:absolute;left:-15em;top:35px;padding:15px;text-decoration:none;transition:opacity .6s ease-in-out 0s,visibility 1s ease-in-out 0s;visibility:hidden;width:42em;height:19em;z-index:25}.bt_smilies3:hover{z-index:25}.x264_warp_sb_smilies3:hover span{opacity:1;position:absolute;visibility:visible}
.x264_warp_shoutbox_ts3{position:relative;z-index:24}.bt_ts3 span{background:linear-gradient(-45deg,#191919,#111,#333,#111,#191919);border:2px solid black;border-radius:30px 0;display:block;font-family:Verdana,Arial,Helvetica,sans-serif;position:absolute;top:20px;left:-5em;padding:5px;position:absolute;text-decoration:none;top:35px;transition:opacity .6s ease-in-out 0s,visibility 1s ease-in-out 0s;visibility:hidden;width:18.2em;height:22.7em;z-index:25}.bt_ts3:hover{z-index:25}.bt_ts3:hover span{opacity:1;position:absolute;visibility:visible}

.x264_sb_smilies {
	position: relative;
	z-index: 24;
}
.x264_sb_smilies span {
    border: 2px dotted #000000; 
    box-shadow:0px 0px 20px #000000;
    border-radius:3px 3px 3px 3px;
    background-image: url('anonymous.png');
    display: block;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    opacity : 0.89999997615814208984375;
    padding: 10px;
    position: absolute;
    text-decoration: none;
    top: 25px;
    transition: opacity 0.6s ease-in-out 0s, visibility 1s ease-in-out 0s;
    visibility: hidden;
    width: 750px;
    z-index: 25;
}
.x264_sb_smilies:hover {
    z-index: 25;
}
.x264_sb_smilies:hover span {
    opacity : 0.89999997615814208984375;
    position: absolute;
    visibility: visible;
}
