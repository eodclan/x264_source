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
.x264_pager_tcrumb{position:relative; height:30px;}
.x264_pager_breadcrumb{position:relative; height:30px;}
.x264_pager_breadcrumb ul{position:relative; margin:0 5px 0 5px; padding:0; height:30px;}
.x264_pager_breadcrumb ul li{padding:0; margin:0; list-style:none; float:left; height:30px display:inline;}
.x264_pager_breadcrumb ul li a{font:12px Arial, Helvetica, sans-serif; color:rgb(255,255,255); text-decoration:none; line-height:30px; display:block; padding:0 17px 0 15px; }
.x264_pager_breadcrumb ul li a:hover {text-decoration:underline; color:rbg(255,255,255);}
.x264_pager_breadcrumb ul li a.active{background:none; color:rgb(255,255,255);}
.x264_pager_breadcrumb ul li a.active:hover {text-decoration:none;}
.x264_pager_breadcrumb .x264_pager_left{position:absolute; top:0px; left:0px; width:10px; height:30px; display:block; z-index:1;}
.x264_pager_breadcrumb .x264_pager_right{position:absolute; top:0px; right:0px; width:10px; height:30px; display:block; z-index:1;}



.pagination-container {
    padding-top: 13px;
    padding-bottom: 13px;
    font-size: 14px;
    text-align: center;
    color: #bfbfbf;
    font-weight: bold;
    background: #121212;
    border: #2d2d2d solid 1px;
    margin-bottom: 30px;
    border-top-right-radius: 6px;
    border-top-left-radius: 6px;
    font-family: Arial;
  text-align: center;
}

.pagination-item {
  list-style-type: none;
  display: inline-block;
  border-right: 1px solid #d7dadb;
  transform: scale(1) rotate(19deg) translateX(0px) translateY(0px) skewX(-10deg) skewY(-20deg);
}

.pagination-item:hover,
.pagination-item.is-active {
  background-color: #fa4248;
  border-right: 1px solid #fff;
}
.pagination-item:hover .pagination-link,
.pagination-item.is-active .pagination-link {
  color: #fff;
}

.pagination-item.first-number {
  border-left: 1px solid #d7dadb;
}

.pagination-link {
  padding: 1.1em 1.6em;
  display: inline-block;
  text-decoration: none;
  color: #8b969c;
  transform: scale(1) rotate(0deg) translateX(0px) translateY(0px) skewX(20deg) skewY(0deg);
}

.pagination-item--wide {
  list-style-type: none;
  display: inline-block;
}

.pagination-item--wide.first {
  margin: 0 1em 0 0;
}

.pagination-item--wide.last {
  margin: 0 0 0 1em;
}

.pagination-link--wide {
  text-decoration: none;
  color: #8b969c;
  padding: 1.1em 1.6em;
}

.pagination-link--wide:hover {
  color: #fa4248;
}

.pagination-link--wide.first:before,
.pagination-link--wide.last:after {
  font-family: 'entypo';
  speak: none;
  font-style: normal;
  font-weight: normal;
  font-variant: normal;
  text-transform: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

.pagination-link--wide.first::before {
  content: "\E765";
  margin-right: 0.5em;
}

.pagination-link--wide.last::after {
  content: "\E766";
  margin-left: 0.5em;
}
