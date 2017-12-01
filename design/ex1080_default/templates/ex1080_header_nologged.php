<?php
echo("<!DOCTYPE html>
<html lang='en'>
<head>
        	<!-- ####################################################### -->
        	<!-- #   Powered by D€ Source 2017 Version 1.0.            # -->
        	<!-- #   Copyright (c) 2017 D@rk-€vil™.                    # -->
        	<!-- #   All rights reserved.                              # -->
        	<!-- ####################################################### -->			
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
			<title>".$title."</title>
			<link rel='shortcut icon' href='/design/ex1080_default/favicon.ico' type='image/x-icon'>
			<!-- Main styles for this application -->
			<link href='/design/ex1080_default/ex1080.php' rel='stylesheet'>
			<script type='text/javascript' src='/design/ex1080_default/js/siteloader.js'></script>");

echo"
</head>
<body class='app header-fixed aside-menu-fixed aside-menu-hidden'>
<div id='dhtmltooltip'></div>
<div id='overDiv' style='position:absolute; visibility:hidden; z-index:auto;'></div>
<div id='loading-layer'></div>
    <header class='app-header navbar'>
        <button class='navbar-toggler mobile-sidebar-toggler hidden-lg-up' type='button'>?</button>
        <a class='navbar-brand' href='index.php'><i class='fa " . $GLOBALS["SITENAME_LOGO"] . "'></i> " . $GLOBALS["SITENAME"] . "</a>
        <ul class='nav navbar-nav hidden-md-down'>
            <li class='nav-item'>
				<a class='nav-link navbar-toggler sidebar-toggler' href='#'><i class='fa icon-menu'></i></a>
            </li>					
        </ul>
    </header>";
?>