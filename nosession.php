<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");

header("Content-Type: text/html; charset=iso-8859-1");
header("Pragma: No-cache");
header("Expires: 300");
header("Cache-Control: private");
?>

<!DOCTYPE html>
<html lang='en'>
<head>
        	<!-- ####################################################### -->
        	<!-- #   Powered by EX 1080 Source Version 1.0.            # -->
        	<!-- #   Copyright (c) 2017 D@rk-€vil™.                    # -->
        	<!-- #   All rights reserved.                              # -->
        	<!-- ####################################################### -->			
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
			<link rel='shortcut icon' href='img/favicon.png'>
			<title><?=$GLOBALS["SITENAME"]?></title>
			<!-- Icons -->
			<link href='/design/ex1080_default/css/font-awesome.min.css' rel='stylesheet'>
			<link href='/design/ex1080_default/css/simple-line-icons.css' rel='stylesheet'>
			<!-- Premium Icons -->
			<link href='/design/ex1080_default/css/glyphicons.css' rel='stylesheet'>
			<link href='/design/ex1080_default/css/glyphicons-filetypes.css' rel='stylesheet'>
			<link href='/design/ex1080_default/css/glyphicons-social.css' rel='stylesheet'>
			<!-- Main styles for this application -->
			<link href='/design/ex1080_default/ex1080.php' rel='stylesheet'>
			<script type='text/javascript' src='/design/ex1080_default/js/siteloader.js'></script>
</head>
<body class='app header-fixed aside-menu-fixed aside-menu-hidden'>
<div id='dhtmltooltip'></div>
<div id='overDiv' style='position:absolute; visibility:hidden; z-index:auto;'></div>
<div id='loading-layer'></div>
    <header class='app-header navbar'>
        <button class='navbar-toggler mobile-sidebar-toggler hidden-lg-up' type='button'>?</button>
        <a class='navbar-brand' href='index.php'>eX1080 Source</a>
        <ul class='nav navbar-nav hidden-md-down'>
            <li class='nav-item'>
				<a class='nav-link navbar-toggler sidebar-toggler' href='#'><i class='fa fa-stack-exchange'></i></a>
            </li>					
        </ul>
    </header>    <div class='app-body'>
        <div class='sidebar'>
	   <nav class='sidebar-nav'>	
                <ul class='nav'>	
                    <li class='nav-title'>
                        No Logged
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='login.php#tologin'><i class='fa fa-sign-in'></i> Login</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='register.php#toregister'><i class='icon-speedometer'></i> Register</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='kontact.php#toregister'><i class='icon-speedometer'></i> Contact</a>
                    </li>
            </nav>
        </div> 
        <!-- Main content -->
        <main class='main'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Session Checking System
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'> 
									Deine Session wird nicht unterst&uuml;tzt!
									Du wirst daher nun ausgeloggt, nach den ausloggen kannst du dich wieder einlogggen!
									<script type="text/javascript">
										window.location.href='index.php';
									</script>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
					
            </div>
            <!-- /.conainer-fluid -->
        </main>

    </div>
    <footer class='app-footer'>
        Powered by eX1080 Source Version <?=$GLOBALS["X264VERSION"]?>
        <span class='float-right'>
            <?=$GLOBALS["X264COPYRIGHT"]?>
        </span>
    </footer>
    <!-- Bootstrap and necessary plugins -->
    <script src='/design/ex1080_default/js/libs/jquery.min.js'></script>
    <script src='/design/ex1080_default/js/libs/tether.min.js'></script>
    <script src='/design/ex1080_default/js/libs/bootstrap.min.js'></script>
    <script src='/design/ex1080_default/js/libs/pace.min.js'></script>
    <!-- GenesisUI main scripts -->
    <script src='/design/ex1080_default/js/app.js'></script>
    <!-- Plugins and scripts required by this views -->
    <script src='/design/ex1080_default/js/libs/toastr.min.js'></script>
    <script src='/design/ex1080_default/js/libs/gauge.min.js'></script>
    <script src='/design/ex1080_default/js/libs/moment.min.js'></script>
    <script src='/design/ex1080_default/js/libs/daterangepicker.js'></script>
    <!-- Custom scripts required by this view -->
    <script src='/design/ex1080_default/js/views/main.js'></script>
</body>
</html>