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
require_once(dirname(__FILE__) . "/include/class_pager.php");

$page = ( ($_GET['page'] > 0) ? intval($_GET['page']) : 1 ); 

hit_start();
dbconn(false);
hit_count();
loggedinorreturn();

x264_header($CURUSER["username"] . "'s torrents");

$where = "WHERE owner = " . $CURUSER["id"] . " AND banned != 'yes'";
$res = mysql_query("SELECT COUNT(*) FROM torrents $where");
$row = mysql_fetch_array($res);
$count = $row[0];

if (!$count) {
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> My Torrents
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									Du hast noch keine Torrents hochgeladen.
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}
else {
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> My Torrents
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";

	list($pagertop, $pagerbottom, $limit) = pager(20, $count, "mytorrents.php?");

	$res = mysql_query("SELECT torrents.type, torrents.activated, torrents.comments, torrents.leechers, torrents.seeders,  ROUND(torrents.ratingsum / torrents.numratings, 1) AS rating, torrents.id, torrents.last_action, categories.name AS cat_name, categories.image AS cat_pic, torrents.name, torrents.filename, save_as, numfiles, added, size, views, visible, hits, times_completed, category FROM torrents LEFT JOIN categories ON torrents.category = categories.id $where ORDER BY id DESC $limit");
    
	print($pagertop);

	torrenttable($res, "mytorrents");

	print($pagerbottom);
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

}

x264_footer();

hit_end();

?>