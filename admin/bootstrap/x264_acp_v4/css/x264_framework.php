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
.cell_sl {
	float       : left;
	height      : 22px;
	padding     : 7px 0px 0px 5px;
	border      : 1px solid #000000;
	margin-left : -1px;
	margin-top  : -1px;
}

.cell_sl1 {
	float       : left;
	height      : 28px;
	padding     : 7px 0px 0px 5px;
	border      : 1px solid #000000;
	margin-left : -1px;
	margin-top  : -1px;
}

.lottotable td {
      width: 35px;
      height: 35px;
      text-align: center;
      vertical-align: middle;
      border: 1px dotted #cccccc;
      cursor: pointer;
      color: #000000;
      background-color: #808080;
      background-image: url(../pic/kugel_klein.png);
      background-repeat: no-repeat;
}

.lottotable {
      border-collapse: collapse;
      border: 2px solid #bbbbbb;
}

.lottotables {
      border-collapse: collapse;
      border: 2px solid #bbbbbb;
}

.lottotables th {
      width: 35px;
      height: 35px;
      text-align: center;
      vertical-align: middle;
      font-weight: bold;
      color: #000000;
      background-color: #808080;
}

.lottotables td {
      width: 35px;
      height: 35px;
      text-align: center;
      vertical-align: middle;
      border: 1px dotted #cccccc;
      cursor: pointer;
      color: #000000;
      background-color: #808080;
      background-image: url(../pic/kugel_klein.png);
      background-repeat: no-repeat;
}

.lottoform td {
    text-align: left;
}

.lottoform input[type=text] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}

.lottoform input[type=button] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}

.lottoform input[type=submit] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}

.abotable td {
    background-color: #808080;
    color: #000000;
    font-size: 12px;
    font-weight: bold;
    border-bottom: 1px dotted #cccccc;
    text-align: center;
    height: 25px;
}

.abotable input[type=submit] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
    width: 100px;
}

.paymenttable td {
    background-color: #808080;
    color: #000000;
    font-size: 12px;
    border-bottom: 1px dotted #cccccc;
    font-weight: bold;
    height: 25px;
    text-align: center; 
}

.paymenttable input[type=submit] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}

.helptable td {
    background-color: #808080;
    color: #000000;
    font-size: 12px;
    width: 100%;
}

.helptable tr {
    background-color: #808080;
    color: #000000;
    font-size: 12px;
    width: 100%;
}

.noAbo td {
    background-color: #808080;
    color: #000000;
    font-size: 12px;
    text-align: center;
    font-weight: bold;
}

.noAbo input[type=submit] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}

.navi input[type=submit] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}

.configtable td {
    background-color: #808080;
    color: #000000;
    border: 1px dotted #cccccc;
    font-weight: bold;
    font-size: 12px;
    height: 25px;    
}

.configtable input[type=submit] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}

.configtable input[type=reset] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}

.configtable input[type=text] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}

.managerTable td {
    background-color: #808080;
    color: #000000;
    border: 1px dotted #cccccc;
    font-weight: bold;
    
}

.managerTable input[type=submit] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}

.logtable td {
    background-color: #808080;
    color: #000000;
    font-size: 12px;
    font-weight: bold;
    border-bottom: 1px dotted #cccccc;
    text-align: left;
    height: 25px;
}

.logtable input[type=submit] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}

.helptable td {
    background-color: #808080;
    color: #000000;
    font-weight: bold;
    font-size: 12px;
    border-bottom: 1px dotted #cccccc;
    text-align: left;
    height: 25px;
}

.helptable input[type=button] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}


.admintable td {
    background-color: #808080;
    color: #000000;
    font-weight: bold;
    font-size: 12px;
    border-bottom: 1px dotted #cccccc;
    
    
} 

.admintable input[type=submit] {
    font-weight: bold;
    border: solid 1px #000000;
    background-color: #eeeeee;
    color: #000000;
}

.button{
    padding   : 1px;
    border    : 0px;
    cursor    : pointer;
}
.button:hover{
    background: #C1D2EE;
    color     : #000000;
    padding   : 0px;
    border    : 1px solid #316AC5;
    cursor    : pointer;
}

        div.menue {
             width:20px;
        }
        
        div.menue div.title {
            color:#000000;
        }
        
        div.menue div.menue-container {
            display:none;
	background-color: #111111;
	border: 2px solid #000000;
	box-shadow:0px 0px 6px #000000;
	-o-border-radius:3px 3px 3px 3px;
	-icab-border-radius:3px 3px 3px 3px;
	-khtml-border-radius:3px 3px 3px 3px;
	-moz-border-radius:3px 3px 3px 3px;
	-webkit-border-radius:3px 3px 3px 3px;
	border-radius:3px 3px 3px 3px;
            padding:5px;
        }
        
        div.menue div.title:hover div.menue-container {
            display:block;
            width:190px;
            position:absolute;
		background-color: #111111;
	border: 2px solid #000000;
	box-shadow:0px 0px 6px #000000;
	-o-border-radius:3px 3px 3px 3px;
	-icab-border-radius:3px 3px 3px 3px;
	-khtml-border-radius:3px 3px 3px 3px;
	-moz-border-radius:3px 3px 3px 3px;
	-webkit-border-radius:3px 3px 3px 3px;
	border-radius:3px 3px 3px 3px;
            margin-left:-1px;
        }
        
        div.menue div.title:hover div.headline {
            border-bottom: solid 1px #ddd;
        }
        
        div.menue div.title div.headline {
            cursor:pointer;
            padding: 2px 5px;
            font-weight:bold;
            color:#FFFFFF;
	background-color: #111111;
	border: 2px solid #000000;
	box-shadow:0px 0px 6px #000000;
	-o-border-radius:3px 3px 3px 3px;
	-icab-border-radius:3px 3px 3px 3px;
	-khtml-border-radius:3px 3px 3px 3px;
	-moz-border-radius:3px 3px 3px 3px;
	-webkit-border-radius:3px 3px 3px 3px;
	border-radius:3px 3px 3px 3px;
        }
        
        div.menue div.menue-item {
            padding:3px;
            margin: 3px;
	background-color: #111111;
	border: 2px solid #000000;
	box-shadow:0px 0px 6px #000000;
	-o-border-radius:3px 3px 3px 3px;
	-icab-border-radius:3px 3px 3px 3px;
	-khtml-border-radius:3px 3px 3px 3px;
	-moz-border-radius:3px 3px 3px 3px;
	-webkit-border-radius:3px 3px 3px 3px;
	border-radius:3px 3px 3px 3px;
            cursor:pointer;
            color:#FFFFFF;
        }

        div.menue div.menue-item:hover {
            padding:3px;
            margin: 3px;
	background-color: #111111;
	border: 2px solid #000000;
	box-shadow:0px 0px 6px #000000;
	-o-border-radius:3px 3px 3px 3px;
	-icab-border-radius:3px 3px 3px 3px;
	-khtml-border-radius:3px 3px 3px 3px;
	-moz-border-radius:3px 3px 3px 3px;
	-webkit-border-radius:3px 3px 3px 3px;
	border-radius:3px 3px 3px 3px;
            cursor:pointer;
            color:#FFFFFF;
            text-decoration: none;
        }