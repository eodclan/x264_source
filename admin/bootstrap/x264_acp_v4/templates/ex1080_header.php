<?php
echo("
<!DOCTYPE html>
<html>
	<head>
        	<!-- ####################################################### -->
        	<!-- #   Powered by D€ Source Version 1.0.                 # -->
        	<!-- #   Copyright (c) 2017 D@rk-€vil™.                    # -->
        	<!-- #   All rights reserved.                              # -->
        	<!-- ####################################################### -->
  	<title>".$title." | Dashboard</title>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
        <!-- Icons -->
        <link href='/admin/bootstrap/x264_acp_v4/assets/css/font-awesome.min.css' rel='stylesheet'>
        <link href='/admin/bootstrap/x264_acp_v4/assets/css/simple-line-icons.css' rel='stylesheet'>
        <!-- Main styles for this application -->
        <link href='/admin/bootstrap/x264_acp_v4/assets/css/style.css' rel='stylesheet'>");
    $userData = mysql_query("SELECT
                                 `downloaded`,
                                 `uploaded`,
                                 (SELECT COUNT(1) FROM `peers` WHERE `userid` = " . intval($CURUSER['id']) . " AND `seeder` = 'yes' ) AS `userSeeds`,          
                                 (SELECT COUNT(1) FROM `peers` WHERE `userid` = " . intval($CURUSER['id']) . " AND `seeder` = 'no'  ) AS `userLeeches`,
                                 (SELECT `connectable` FROM `peers` WHERE `userid` = " . intval($CURUSER['id']) . " LIMIT 1) AS `connectable`          
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
                $connectable = '<a title="Alles O.K! Gute Verbindung!"><b><font color="green">Ja</font></b></a>';
            break;
            default    :
                $connectable = '<a title="Du bist nicht Erreichbar!"><b><font color="red">nicht Erreichbar</font></b></a>'; 
            break;
        }
    }
    else {
        $connectable = '<a title="Keine Verbindung zur Zeit"><b><font color="red">Nein</font></b></a>';
    }
echo("
</head>
    <body class='navbar-fixed sidebar-nav fixed-nav'>
        <header class='navbar'>
            <div class='container-fluid'>
                <button class='navbar-toggler mobile-toggler hidden-lg-up' type='button'>&#9776;</button>
                <a class='navbar-brand' href='#'></a>
                <ul class='nav navbar-nav hidden-md-down'>
                    <li class='nav-item'>
                        <a class='nav-link navbar-toggler layout-toggler' href='#'>&#9776;</a>
                    </li>
                    <li class='nav-item p-x-1'>
                        <a class='nav-link' href='backend_acp.php'>Dashboard</a>
                    </li>");
if (get_user_class() >= UC_MODERATOR) {
echo("
                    <li class='nav-item p-x-1'>
                        <a class='nav-link' href='staffbox.php'>Team PMs</a>
                    </li>");
}
if (get_user_class() >= UC_SYSOP) {
echo("
                    <li class='nav-item p-x-1'>
                        <a class='nav-link' href='forummanager.php'>Forum Manager</a>
                    </li>");
}
echo("
                    <li class='nav-item p-x-1'>
                        <a class='nav-link' href='index.php'>Frontend</a>
                    </li>
                </ul>
                <ul class='nav navbar-nav pull-right hidden-md-down'>
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle nav-link' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
                            <span class='hidden-md-down'>".$CURUSER['username']."</span>
                        </a>
                        <div class='dropdown-menu dropdown-menu-right'>
                            <div class='dropdown-header text-xs-center'>
                                <strong>Stats</strong>
                            </div>
                            <a class='dropdown-item' href='#'><i class='fa fa-bell-o'></i> Seeds: <font class='userbar_font'>" . $seeds . $tlimits['seeds'] . "</font></a>
                            <a class='dropdown-item' href='#'><i class='fa fa-envelope-o'></i> Leechs: <font class='userbar_font'>" . $leeches . $tlimits['leeches'] . "</font></a>
                            <a class='dropdown-item' href='#'><i class='fa fa-tasks'></i> Seedbonus: <font class='userbar_font'>" . $CURUSER['seedbonus'] . "</font></a>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <div class='sidebar'>");

?>