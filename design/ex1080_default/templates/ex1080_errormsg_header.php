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
			<script type='text/javascript' src='/design/ex1080_default/js/siteloader.js'></script>
			<style>
				#initial-loader{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;width:100%;background:#212121;position:fixed;z-index:10000;top:0;left:0;bottom:0;right:0;transition:opacity .4s ease-out}#initial-loader .initial-loader-top{display:flex;align-items:center;justify-content:space-between;width:200px;border-bottom:1px solid #2d2d2d;padding-bottom:5px}#initial-loader .initial-loader-top > *{display:block;flex-shrink:0;flex-grow:0}#initial-loader .initial-loader-bottom{padding-top:10px;color:#5C5C5C;font-family:-apple-system,'Helvetica Neue',Helvetica,'Segoe UI',Arial,sans-serif;font-size:12px}@keyframes spin{100%{transform:rotate(360deg)}}#initial-loader .loader g{transform-origin:50% 50%;animation:spin .5s linear infinite}body.loading {overflow: hidden !important} body.loaded #initial-loader{opacity:0}.initial-loader_bg{padding: 0.75rem 1.25rem;margin-bottom: 0;color: #FFFFFF;background: rgb(15,15,15);border: 1px solid rgb(35,35,35);-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;opacity:1;}
			</style>");

echo"
</head>
<body class='app header-fixed aside-menu-fixed aside-menu-hidden loading'>
<div id='initial-loader'>
    <div class='initial-loader_bg'>
        <div class='initial-loader-top'>
		<a class='initial-loader-bottom navbar-brand' href='login.php'><i class='fa " . $GLOBALS["SITENAME_LOGO"] . "'></i> " . $GLOBALS["SITENAME"] . "</a>
            <div class='loader loader--style1'>
                <svg version='1.1' id='loader-1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='30px' height='30px' viewbox='0 0 40 40' enable-background='new 0 0 40 40' xml:space='preserve'>
                    <g>
                        <path fill='#2d2d2d' d='M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z'/>
                        <path fill='#2c97de' d='M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0C22.32,8.481,24.301,9.057,26.013,10.047z'/>
                        
                    </g>
                </svg>
            </div>
        </div>
        <div class='initial-loader-bottom'>
            Loading. Please Wait. <i class='fa fa-cricle' style='opacity: 0'></i>
        </div>
    </div>
</div>
<div id='dhtmltooltip'></div>
<div id='overDiv' style='position:absolute; visibility:hidden; z-index:auto;'></div>
<div id='loading-layer'></div>
    <header class='app-header navbar'>
        <button class='navbar-toggler mobile-sidebar-toggler hidden-lg-up' type='button'>?</button>
        <a class='navbar-brand' href='" . $GLOBALS["DEFAULTBASEURL"] . "/index.php'><i class='fa " . $GLOBALS["SITENAME_LOGO"] . "'></i> " . $GLOBALS["SITENAME"] . "</a>
        <ul class='nav navbar-nav hidden-md-down'>
            <li class='nav-item'>
				<a class='nav-link navbar-toggler sidebar-toggler' href='#'><i class='fa icon-menu'></i></a>
            </li>					
        </ul>
    </header>";
?>