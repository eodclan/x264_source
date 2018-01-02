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
check_access(UC_SYSOP);
security_tactics();
x264_admin_header("Only Upload ACP");

if (get_user_class() >= UC_TEAMLEITUNG)
{
$res1 = mysql_query("SELECT torrents.wonly FROM torrents WHERE wonly='yes'") or sqlerr();

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Only Upload ACP Info
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<a href='javascript:void(0)' class='uppercase'>Wenn das Only Upload eingeschaltet oder ausschaltest wird, dann wirst du automatisch wieder auf die Index umgeleitet.</a>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

if (mysql_num_rows($res1) == 0)
{
print "
<form method='post' action='only_upload_acp_done.php'>  
<input type='hidden' name='action' value='yes'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Only Upload Status
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<ul class='chart-legend clearfix'>
										<li>Aktiv: <font color=green>&nbsp;&nbsp;&nbsp;Nein</font></li>
										<li><input type=submit value='Einschalten'></li>
									</ul>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</form>";
}
else
{
print "
<form method='post' action='only_upload_acp_done.php'>  
<input type='hidden' name='action' value='no'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Only Upload Status
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<ul class='chart-legend clearfix'>
										<li>Aktiv: <font color=green>&nbsp;&nbsp;&nbsp;Ja</font></li>
										<li><input type=submit value='Ausschalten'></li>
									</ul>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</form>";
}
}
else
print "
<form method='post' action='only_upload_acp_done.php'>  
<input type='hidden' name='action' value='no'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Only Upload Status
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<ul class='chart-legend clearfix'>
										<li>Dir ist es nicht erlaubt, hier zuzugreifen</li>
									</ul>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</form>";	
x264_admin_footer();
?>