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
.word_siteloader{
	color: #590700; 
	font-family: 'FranchiseRegular','Arial Narrow',Arial,sans-serif;
	font-size: 24px; 
	font-style: italic; 
	margin: 0 0 10px 2px; 
	text-align: center; 
	text-shadow: 2px 2px 1px #000000; 
	z-index: 2;
}

.word_siteloader:after{
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

.siteloader_warp {
	border:1px inset 0 0 6px rgba(0,0,0,0.8);
	background-color:rgba(19,19,19,1);
	text-align:left;
	margin:auto;
	margin-bottom:20px;
	padding:10px;
	box-shadow: inset 0 0 6px rgba(0,0,0,0.8), inset 0 1px 0 rgba(225,225,225,0.15), inset 0 0 2px rgba(225,225,225,0.1);
	border-radius:1px 1px 1px 1px;
	z-index: 1;
}

.loading {
    display: inline-block;

    position: relative;
    top: 50px;
    left: 50%;


    margin: -14px 0 0 -42px;
    padding: 10px;
    background: rgba(20, 20, 20, 0.9);
  
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
  
    -webkit-box-shadow: inset 0 0 5px #000, 0 1px 1px rgba(255, 255, 255, 0.1);
    -moz-box-shadow: inset 0 0 5px #000, 0 1px 1px rgba(255, 255, 255, 0.1);
    -ms-box-shadow: inset 0 0 5px #000, 0 1px 1px rgba(255, 255, 255, 0.1);
    -o-box-shadow: inset 0 0 5px #000, 0 1px 1px rgba(255, 255, 255, 0.1);
    box-shadow: inset 0 0 5px #000, 0 1px 1px rgba(255, 255, 255, 0.1);
}

.loading-dot {
    float: left;
    width: 8px;
    height: 8px;
    margin: 0 4px;
    background: white;
  
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
  
    opacity: 0;
  
    -webkit-box-shadow: 0 0 2px black;
    -moz-box-shadow: 0 0 2px black;
    -ms-box-shadow: 0 0 2px black;
    -o-box-shadow: 0 0 2px black;
    box-shadow: 0 0 2px black;
  
    -webkit-animation: loadingFade 1s infinite;
    -moz-animation: loadingFade 1s infinite;
    animation: loadingFade 1s infinite;
}

.loading-dot:nth-child(1) {
    -webkit-animation-delay: 0s;
    -moz-animation-delay: 0s;
    animation-delay: 0s;
}

.loading-dot:nth-child(2) {
    -webkit-animation-delay: 0.1s;
    -moz-animation-delay: 0.1s;
    animation-delay: 0.1s;
}

.loading-dot:nth-child(3) {
    -webkit-animation-delay: 0.2s;
    -moz-animation-delay: 0.2s;
    animation-delay: 0.2s;
}

.loading-dot:nth-child(4) {
    -webkit-animation-delay: 0.3s;
    -moz-animation-delay: 0.3s;
    animation-delay: 0.3s;
}

@-webkit-keyframes loadingFade {
    0% { opacity: 0; }
    50% { opacity: 0.8; }
    100% { opacity: 0; }
}

@-moz-keyframes loadingFade {
    0% { opacity: 0; }
    50% { opacity: 0.8; }
    100% { opacity: 0; }
}

@keyframes loadingFade {
    0% { opacity: 0; }
    50% { opacity: 0.8; }
    100% { opacity: 0; }
}