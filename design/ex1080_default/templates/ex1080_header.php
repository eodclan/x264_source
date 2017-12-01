<?php
echo("<!DOCTYPE html>
<html lang='en'>
<head>
        	<!-- ####################################################### -->
        	<!-- #   Powered by D€ Source 2017 Version 1.0.            # -->
        	<!-- #   Copyright (c) 2017 D@rk-€vil™.                    # -->
        	<!-- #   All rights reserved.                              # -->
        	<!-- ####################################################### -->");
			if ($CURUSER) { 
				session_unset();
				$_COOKIE["x264_tfid"] = mysql_fetch_assoc(mysql_query("SELECT id FROM users WHERE id = " . $CURUSER["id"]));
			}
			phpsessid_secure();
echo("			
			<meta charset='utf-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
			<title>".$title."</title>
			<link rel='shortcut icon' href='/design/ex1080_default/favicon.ico' type='image/x-icon'>
			<!-- Main styles for this application -->
			<link href='/design/ex1080_default/ex1080.php' rel='stylesheet'>
			<link rel='stylesheet' href='/classcolor.php' type='text/css' />
			<script type='text/javascript' src='/design/ex1080_default/js/siteloader.js'></script>");
			
if($CURUSER[design_loader] == "ajax"){
echo("	
			<style>
				#initial-loader{display:flex;align-items:center;justify-content:center;flex-wrap:wrap;width:100%;background:#212121;position:fixed;z-index:10000;top:0;left:0;bottom:0;right:0;transition:opacity .4s ease-out}#initial-loader .initial-loader-top{display:flex;align-items:center;justify-content:space-between;width:200px;border-bottom:1px solid #2d2d2d;padding-bottom:5px}#initial-loader .initial-loader-top > *{display:block;flex-shrink:0;flex-grow:0}#initial-loader .initial-loader-bottom{padding-top:10px;color:#5C5C5C;font-family:-apple-system,'Helvetica Neue',Helvetica,'Segoe UI',Arial,sans-serif;font-size:12px}@keyframes spin{100%{transform:rotate(360deg)}}#initial-loader .loader g{transform-origin:50% 50%;animation:spin .5s linear infinite}body.loading {overflow: hidden !important} body.loaded #initial-loader{opacity:0}.initial-loader_bg{padding: 0.75rem 1.25rem;margin-bottom: 0;color: #FFFFFF;background: rgb(15,15,15);border: 1px solid rgb(35,35,35);-webkit-box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;box-shadow: 0 0 6px 2px rgba(0,0,0,0.5) inset;opacity:1;}
			</style>");
} else {	
// Site Loader ende
}			
if($CURUSER[ajax_tfiles] == "yes"){
?>

<script type='text/javascript'>
        jQuery(document).ready(function ($) {

            var jssor_1_options = {
              $AutoPlay: 1,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $Cols: 4,
                $SpacingX: 4,
                $SpacingY: 4,
                $Orientation: 2,
                $Align: 0
              }
            };

            var jssor_1_slider = new $JssorSlider$('jssor_1', jssor_1_options);

            /*responsive code begin*/
            /*remove responsive code if you don't want the slider scales while window resizing*/
            function ScaleSlider() {
                var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 810);
                    jssor_1_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $(window).bind('load', ScaleSlider);
            $(window).bind('resize', ScaleSlider);
            $(window).bind('orientationchange', ScaleSlider);
            /*responsive code end*/
        });

function selectCat(main,cats) 
{ 
  catArr = cats.split(','); 
  if(document.getElementById(main).checked) 
    check = true; else 
    check = false; 
    for(i=0;i<catArr.length;i++) 
      document.getElementById('c' + catArr[i]).checked = check; 
}

</script>
<?php
} else {
// Ajax Tfiles ende
}
    $userData = mysql_query("SELECT
                                 `invites`,
                                 `downloaded`,
                                 `uploaded`,
                                 (SELECT COUNT(1) FROM `peers` WHERE `userid` = " . intval($CURUSER['id']) . " AND `seeder` = 'yes' ) AS `userSeeds`,          
                                 (SELECT COUNT(1) FROM `peers` WHERE `userid` = " . intval($CURUSER['id']) . " AND `seeder` = 'no'  ) AS `userLeeches`,
                                 (SELECT `connectable` FROM `peers` WHERE `userid` = " . intval($CURUSER['id']) . " LIMIT 1) AS `connectable`,
                                 (SELECT COUNT(1) FROM `messages` WHERE `folder_in`  AND `receiver` = " . $CURUSER["id"] . ") AS `messagesIn`,
                                 (SELECT COUNT(1) FROM `messages` WHERE `folder_out` AND `sender`   = " . $CURUSER["id"] . ") AS `messagesOut`          
                             FROM
                                 `users`
                             WHERE
                                 `id` = " . intval($CURUSER['id'])
                           ) OR sqlerr(__FILE__, __LINE__);
    $stats = mysql_fetch_assoc($userData);     
    $curuserdownloaded = $stats['downloaded'];
    $curuseruploaded   = $stats['uploaded'];
    $seeds             = $stats['userSeeds'];
    $leeches           = $stats['userLeeches'];
    $ratio             = $curuserdownloaded > 0 ? number_format($curuseruploaded / $curuserdownloaded, 3) : 'Inf.';
    $tlimits           = get_torrent_limits($CURUSER);
    $inbox             = $stats['messagesIn'];
    $sentbox           = $stats['messagesOut'];
    $connect           = $stats['connectable'];
    $invite           = $stats['invites'];
    $BASEURL           = $GLOBALS["DEFAULTBASEURL"];

    if ($ratio < 0.5) {
        $ratiowarn = ' style="background-color: red; color: white;"';
    }
    elseif ($ratio < 0.75) {
        $ratiowarn = ' style="background-color: #FFFF00; color: white;"';
    }

    if ($tlimits['seeds'] >= 0) {
        if ($tlimits['seeds'] - $seeds < 1) {
            $seedwarn = ' style="background-color: red; color: white;"';
        }
        $tlimits['seeds'] = ' / ' . $tlimits['seeds'];
    }
    else {
        $tlimits['seeds'] = NULL;    
    }

    if ($tlimits['leeches'] >= 0)
    {
        if ($tlimits['leeches'] - $leeches < 1) {
            $leechwarn = ' style="background-color: red; color: white;"';
        }
        $tlimits['leeches'] = ' / ' . $tlimits['leeches'];
    }
    else {
        $tlimits['leeches'] = NULL;
    }

    if ($tlimits['total'] >= 0)
    {
        if ($tlimits['total'] - $leeches + $seeds < 1) {
            $totalwarn = ' style="background-color: red; color:white;"';
        }
        $tlimits['total'] = ' / ' . $tlimits['total'];
    }
    else {
        $tlimits['total'] = NULL;
    }

    if(!empty($connect))
    {
        switch ($connect)
        {
            case 'yes' :
                $connectable = 'Ja';
            break;
            default    :
                $connectable = 'nicht Erreichbar'; 
            break;
        }
    }
    else {
        $connectable = '<a title="Keine Verbindung zur Zeit"><b><font color="red">Nein</font></b></a>';
    }
echo("
    <script>
        var ASSET_PATH_BASE = '" . $GLOBALS["DEFAULTBASEURL"] . "';
    </script>			
</head>");
$ts3_ip 	= $GLOBALS["TS3_IP"];
$ts3_port 	= $GLOBALS["TS3_PORT"];
if (isset($CURUSER) && $GLOBALS['OSTE_AKTIV'] === 1 && $CURUSER['class'] < UC_MODERATOR)
    echo oster_suche();
echo("
<body class='app header-fixed aside-menu-fixed aside-menu-hidden");
if($CURUSER[design_loader] == "ajax"){
echo(" loading'>	
<div id='initial-loader'>
    <div class='initial-loader_bg'>
        <div class='initial-loader-top'>
		<a class='initial-loader-bottom navbar-brand' href='index.php'><i class='fa " . $GLOBALS["SITENAME_LOGO"] . "'></i> " . $GLOBALS["SITENAME"] . "</a>
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
</div>");
} else {
echo("'>");	
// Site Loader ende
}
echo("
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
	    <li class='nav-item px-1'>
                <a class='nav-link' href='index.php'><i class='fa fa-home'></i> Home</a>
            </li>
	    <li class='nav-item px-1'>
                <a class='nav-link' href='tfiles.php'><i class='fa fa-download'></i> Browse</a>
            </li>
	    <li class='nav-item px-1'>
                <a class='nav-link' href='tfile_add.php'><i class='fa fa-upload'></i> Upload</a>
            </li>
	    <li class='nav-item px-1'>
                <a class='nav-link' href='rss.php'><i class='fa fa-rss'></i> RSS</a>
            </li>			
        </ul>		
		<ul class='nav navbar-nav ml-auto'>
            <li class='nav-item dropdown hidden-md-down'>
                <a class='nav-link dropdown-toggle nav-link' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
                    <i class='fa fa-area-chart'></i>
                </a>
                <div class='dropdown-menu dropdown-menu-right'>
                    <div class='dropdown-header text-center'>
                        <strong>Account</strong>
                    </div>
                    <a class='dropdown-item' href='#'>Hallo " . $CURUSER["username"] ."!</a>
                    <a class='dropdown-item' href='#'>Deine letzte Aktivit&auml;t war " . $CURUSER["last_login"] ."</a>
                    <a class='dropdown-item' href='#'>Heute ist der " . date("d.m.Y") . " und es ist " . date("H:i:s") ."</a>
                    <a class='dropdown-item' href='#'><i class='fa fa-bell-o'></i> Seeds<span class='badge badge-info'>" . $seeds . $tlimits['seeds'] . "</span></a>
                    <a class='dropdown-item' href='#'><i class='fa fa-envelope-o'></i> Leechs<span class='badge badge-success'>" . $leeches . $tlimits['leeches'] . "</span></a>
                    <a class='dropdown-item' href='#'><i class='fa fa-usd'></i> S-Bonus<span class='badge badge-seedbonus'>" . $CURUSER['seedbonus'] . "</span></a>
                    <a class='dropdown-item' href='#'><i class='fa fa-hourglass'></i> Ratio<span class='badge badge-ratio'>" . $ratio . "</span></a>
                    <a class='dropdown-item' href='#'><i class='fa fa-download'></i> Download<span class='badge badge-leechs'>" . mksize($curuserdownloaded) . "</span></a>
                    <a class='dropdown-item' href='#'><i class='fa fa-upload'></i> Upload<span class='badge badge-seeds'>" . mksize($curuseruploaded) . "</span></a>
                    <a class='dropdown-item' href='#'><i class='fa fa-tasks'></i> Erreichbar<span class='badge badge-danger'>" . $connectable . "</span></a>
                    <div class='dropdown-header'>
                        Optionen
                    </div>
                    <a class='dropdown-item' href='userdetails.php'><i class='fa fa-user'></i> Dein Profil</a>
                    <a class='dropdown-item' href='profile.php'><i class='fa fa-wrench'></i> Einstellungen</a>
                    <a class='dropdown-item' href='seedbonus.php'><i class='fa fa-usd'></i> Seed Bonus Shop</a>
                    <a class='dropdown-item' href='friends.php'><i class='fa fa-file'></i> Buddyliste</a>
                    <a class='dropdown-item' href='logout.php'><i class='fa fa-lock'></i> Logout</a>
                </div>
            </li>
            <li class='nav-item dropdown hidden-md-down'>			
                <a class='nav-link dropdown-toggle nav-link' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
                    <i class='fa fa-stack-exchange'></i>
                </a>					
                <div class='dropdown-menu dropdown-menu-right'>
                    <div class='dropdown-header text-center'>
                        <strong>Shoutbox Regeln!</strong>
					</div>
                    <a class='dropdown-item' href='#'>01. Die Shoutbox ist keine Spambox.</a>
                    <a class='dropdown-item' href='#'>02. Smileys sind Einzelgänger. Bitte keinen unnötigen Spam.</a>
                    <a class='dropdown-item' href='#'>03. Die Shoutbox dient nicht als Supportportal. Nutzt dazu unsere die Team PM Seite.</a>
                    <a class='dropdown-item' href='#'>04. Fremdwerbung jeglicher Art ist verboten.</a>
                    <a class='dropdown-item' href='#'>05. Provokationen werden ebenfalls nicht gerne gesehen.</a>
                    <a class='dropdown-item' href='#'>06. Beleidigung, Persönlichkeitsverletzung, Provokation, Mobbing oder Belästigung anderer sind nicht erlaubt.</a>
                    <a class='dropdown-item' href='#'>07. Fehler bzw Fehlermeldungen haben in der Shout nichts zu suchen. Diese sind dem Team per Team-PM mitzuteilen.</a>
                </div>                    
            </li>
            <li class='nav-item dropdown hidden-md-down'>			
                <a class='nav-link dropdown-toggle nav-link' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
                    <i class='fa icon-earphones-alt'></i>
                </a>					
                <div class='dropdown-menu dropdown-menu-right'>
                    <div class='dropdown-header text-center'>
                        <strong>Teamspeak</strong>
		    </div>
                    <i class='dropdown-item'>"); include("tsstatus/tsstatus_test.php"); echo("</i>
                </div>                    
            </li>
            <li class='nav-item dropdown hidden-md-down'>			
                <a class='nav-link dropdown-toggle nav-link' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
                    <i class='fa fa-music'></i>
                </a>					
                <div class='dropdown-menu dropdown-menu-right'>
                    <div class='dropdown-header text-center'>
                        <strong>Shoutcast</strong>
					</div>
                    <i class='dropdown-item'>"); include("ajax_radio.php"); echo("</i>
                </div>                    
            </li>
			<li class='nav-item dropdown hidden-md-down'>
				<a href='logout.php' title='Ausloggen'><i class='fa icon-logout'></i></a>
			</li>						
        </ul>		
    </header>");
?>