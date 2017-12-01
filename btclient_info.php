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
require_once("include/bittorrent.php");
include("include/dagent.class.php");

dbconn();
loggedinorreturn();

$query = "SELECT * FROM agents WHERE aktiv = '1' ORDER BY agent_name ASC";
$result = mysql_query($query);

$query_b = "SELECT * FROM agents WHERE aktiv = '0' ORDER BY agent_name ASC";
$result_b = mysql_query($query_b);
// agent_id 	agent_name 	hits 	ins_date 	aktiv

x264_header("BT-Clients");
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Erlaubte BT-Clients
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<div class='x264_uspr_right_label'>
										<a name="open"></a>
										<a href="#bann">Zu den gebannten</a>
									</div>
									<?
										while($data = mysql_fetch_object($result)){
									?>		    
									<div class="x264_uspr_right_label"><?=$data -> agent_name;?></div>		
									<?
										}
									?>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>

                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Gebannte BT-Clients
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<div class='x264_uspr_right_label'>
										<a name="bann"></a>
										<a href="#open" class="numbers_but">Zu den erlaubten</a>
									</div>
									<?
										while($data = mysql_fetch_object($result_b)){
									?>		    
									<div class="x264_uspr_right_label"><?=$data -> agent_name;?></div>		
									<?
										}
									?>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?
x264_footer();
?>