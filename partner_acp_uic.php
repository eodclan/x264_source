<?php
// ************************************************************************************//
// * D€ Source 2018
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2017 - 2018 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************// 
require_once(dirname(__FILE__) . "/include/engine.php");
dbconn();
loggedinorreturn();
check_access(UC_PARTNER);
security_tactics();

$id = intval($_GET["id"]);

$sql = "SELECT 
				id,
				username,
				email,
				enabled,
				added,
				last_login,
				session,
				ip,
				class

		FROM 
				users
		WHERE
                class='0' LIKE '$nick%' ORDER BY username LIMIT 10000";
				
$alleuser = $db -> queryObjectArray($sql);

x264_admin_header("Partner ACP - User Info Center");
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-gavel'></i> Partner ACP - User Info Center
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered table-striped table-condensed'>
										<thead>
											<tr>
												<td>Wegen unserer Tracker Sicherheit bekommt ihr nur 60 Zeichen bei der Session angezeigt!</td>
											</tr>
										</thead>
									</table>
									<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered table-striped table-condensed'>
										<thead>
											<tr>
												<td>Wegen unserer Tracker Sicherheit bekommt ihr nur 9 Zeichen bei der IP angezeigt!</td>
											</tr>
										</thead>
									</table>									
									<div id='dataTables'>
									<table cellpadding='0' cellspacing='0' border='0' class='table table-bordered table-striped table-condensed'>
										<thead>
											<tr>
												<th>Username</th>
												<th>E-Mail</th>
												<th>IP</th>
												<th>Session</th>
											</tr>
										</thead>
										<tbody>
										<?php
											foreach($alleuser AS $key => $arr){
										echo '
											<tr>
												<td>' . $arr['username'] . '</td>
												<td>' . $arr['email'] . '</td>
												<td>' . trim_it($arr['ip'],9) . '</td>
												<td>' . trim_it($arr['session'],60) . '</td>
											</tr>';
											}
										?>
										</tbody>
									</table>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php
x264_admin_footer();
?>