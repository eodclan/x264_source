<?php
// ************************************************************************************//
// * D€ Source
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 1.x
// * 
// * Copyright (c) 2015 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//
require_once(dirname(__FILE__) . "/bittorrent.php");

function security_tactics($msg=true)
{
	// Secure Settings
	$securenick = $GLOBALS["SECIRITYTACTICS_NICK"];
	$securepass = $GLOBALS["SECIRITYTACTICS_PASSWORD"];
	$securename = "STS:4.0";

	// Secure Error System
	if ($_SERVER["PHP_AUTH_USER"] == "" || $_SERVER["PHP_AUTH_PW"] == "" || $_SERVER["PHP_AUTH_USER"] != $securenick || $_SERVER["PHP_AUTH_PW"] != $securepass)
	{
		header("HTTP/1.0 401 Unauthorized");
		header("WWW-Authenticate: Basic realm=$securename");
		
		$added       = get_date_time();
		$ip          = ip2long($_SERVER['REMOTE_ADDR']);  		
		
		x264_errormsg_header("Security Tactics System");

		print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-warning'></i> Error
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
      					<div class='error-page'>
        					<div class='error-content'>
          						<h3><i class='fa fa-warning text-red'></i> Oops! Something went wrong.</h3>
          						<p>
								We've saved your illegal or inappropriate access and directors were informed! <a href='index.php' style='color:#555;'>Back to WebSite</a>
          						</p>
        					</div>
      					</div>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>"; 

		x264_errormsg_footer();
		// Message from Security Tactics System
		$subject = "Security Tactics System";
		$msg = "Es hat sich jemand ins Security Tactics System eingelogt! Die IP lautet: ".$_SERVER['REMOTE_ADDR']." !";
		write_log("security_tactics", "<b><font color=red>Achtung: Es hat sich jemand ins Security Tactics System eingelogt!</font></b>");
		mysql_query("INSERT INTO messages (poster, sender, receiver, folder_in, subject, added, msg) VALUES(0, 0, '".$GLOBALS["SECIRITYTACTICS_MSG1"]."', -1, " .sqlesc($subject) . ", '" . get_date_time() . "', " .sqlesc($msg) . ")") or sqlerr(__FILE__, __LINE__);
		mysql_query("INSERT INTO messages (poster, sender, receiver, folder_in, subject, added, msg) VALUES(0, 0, '".$GLOBALS["SECIRITYTACTICS_MSG2"]."', -1, " .sqlesc($subject) . ", '" . get_date_time() . "', " .sqlesc($msg) . ")") or sqlerr(__FILE__, __LINE__);
		die();
	}
}
?>