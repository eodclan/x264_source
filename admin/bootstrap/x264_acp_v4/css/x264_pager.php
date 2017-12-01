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
.x264_pager_tcrumb{position:relative; height:30px; width:100%;}
.x264_pager_breadcrumb{position:relative; height:30px; width:100%;}
.x264_pager_breadcrumb ul{position:relative; margin:0 5px 0 5px; padding:0; height:30px; background:url('../x264_pager_breadcrumbImage.png') 0px -30px repeat-x;border:1px inset 0 0 6px rgba(0,0,0,0.8);-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;	box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;border:none 5px #000000;border-top-left-radius: 15px;border-top-right-radius: 15px;border-bottom-left-radius: 15px;border-bottom-right-radius: 15px;border-radius:15px 15px 15px 15px;border-top: 1px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;border-bottom: 1px solid #000;}
.x264_pager_breadcrumb ul li{padding:0; margin:0; list-style:none; float:left; height:30px display:inline;}
.x264_pager_breadcrumb ul li a{font:12px Arial, Helvetica, sans-serif; color:rgb(255,255,255); text-decoration:none; line-height:30px; display:block; background:url('../x264_pager_breadcrumbImage.png') 100% -60px no-repeat; padding:0 17px 0 15px; }
.x264_pager_breadcrumb ul li a:hover {text-decoration:underline; color:rbg(255,255,255);}
.x264_pager_breadcrumb ul li a.active{background:none; color:rgb(255,255,255);}
.x264_pager_breadcrumb ul li a.active:hover {text-decoration:none;}
.x264_pager_breadcrumb .x264_pager_left{position:absolute; top:0px; left:0px; width:10px; height:30px; display:block; z-index:1;}
.x264_pager_breadcrumb .x264_pager_right{position:absolute; top:0px; right:0px; width:10px; height:30px; display:block; z-index:1;}