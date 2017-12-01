<?php
require "include/bittorrent.php";
dbconn();
loggedinorreturn();

x264_header("Partner Trackers");

print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-users'></i>Bitte den Header nehmen um uns zu verlinken
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<div><IMG SRC=design/powercastle.png  class='mx-auto d-block' WIDTH=560 HEIGHT=100 border=2></div>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";


$query = "SELECT * FROM partner ORDER BY RAND()";
$sql = mysql_query($query);
while ($row = mysql_fetch_array($sql)) {
$id = $row['id'];
$titel = $row['titel'];
$banner = $row['banner'];
$url = $row['link'];

print "
					
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-users'></i>".$titel."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
					<div><a href=redir.php?url=".$url." target=_blank><IMG SRC=".$banner."  class='mx-auto d-block' WIDTH=560 HEIGHT=100 border=2></a></div>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}

x264_footer();
?>