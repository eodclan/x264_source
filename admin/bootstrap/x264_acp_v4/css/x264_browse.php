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
.x264_torrent_table_block_a{
	overflow:hidden;
	float:left;
	width:10%;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}

.x264_torrent_table_block_b {
	overflow:hidden;
	float:left;
	width:19%;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);	
}

.x264_torrent_table_block_c {
	overflow:hidden;
	float:left;
	width:62%;
	height:80px;	
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);	
}

.x264_torrent_table_block_d {
	overflow:hidden;
    float:left;
	width:9%;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);	
}

.x264_torrent_table_inp_uploader{
	overflow:hidden;
	margin:auto;
	text-align:center;	
	width:99%;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_torrent_table_inp_language{
	overflow:hidden;
	width:99%;
	margin: 0px auto;	
	text-align:center;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_torrent_table_inp_cat{
	overflow:hidden;
	width:99%;
	margin: 0px auto;	
	text-align:center;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}

.x264_torrent_table_inp_dl{
	overflow:hidden;
	margin:auto;
	width:99%;
	text-align:center;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}

.x264_torrent_table_inp_pretime{
	overflow:hidden;
	margin:auto;
	width:99%;
	text-align:center;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_torrent_table_inp_tname{
	overflow:hidden;
	margin:auto;
	width:99%;	
	text-align:center;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_torrent_table_inp_hinweis{
	overflow:hidden;
	margin:auto;
	color:#DDA0DD;
	width:99%;
	height: 40px;	
	text-align:center;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}

.x264_torrent_table_inp_datum{
	overflow:hidden;
	margin:auto;
	text-align:center;	
	width:99%;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_torrent_table_inp_completed{
	overflow:hidden;
	margin:auto;
	text-align:center;	
	width:99%;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_torrent_table_inp_comments{
	overflow:hidden;
	margin:auto;
	text-align:center;	
	width:99%;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_torrent_table_inp_sl{
	overflow:hidden;
	margin:auto;
	text-align:center;	
	width:99%;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
}
.x264_browse_torrent_table_log{
	overflow:hidden;
	width:90%;
	display:block;
	color:#ccc;
	font-weight:bold;
	text-decoration: none;
	text-align:center;
	margin:0 auto 3px auto;
	padding:5px;
	-webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-moz-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-icab-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-khtml-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	-o-box-shadow: 0 0 20px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8),inset 0 1px 0 rgba(225,225,225,0.15),inset 0 0 2px rgba(225,225,225,0.1);
}

.x264_browse_torrent_table_cap{
	overflow:hidden;
	background-image: url(framework/bg_2k15.png);
	background-repeat: repeat-x;
	border:1px solid #606060;
	width:99%;
	height: 100%;
	margin:auto;
	padding:5px;
}

.x264_warp_br{
	height: 8px;
	margin:auto;
}