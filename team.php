<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");
dbconn();
loggedinorreturn();
x264_header("Staff");
check_access(UC_VIP);
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-group'></i>Das Team von <?=$GLOBALS["SITENAME"];?>
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
<?

$act = $_GET["act"];
if (!$act) {
// Get current datetime
$dt = gmtime() - 60;
$dt = sqlesc(get_date_time($dt));
// Search User Database for Moderators and above and display in alphabetical order
$res = mysql_query("SELECT * FROM users WHERE class>=".UC_MODERATOR.
" AND status='confirmed' ORDER BY username" ) or sqlerr();

while ($arr = mysql_fetch_assoc($res))
{


$staff_table[$arr['class']]=$staff_table[$arr['class']].
"<a class='altlink' href='userdetails.php?id=".$arr['id']."'>".
$arr['username']."</a><a href='messages.php?action=send&receiver=".$arr['id']."'> <i class='fa fa-envelope-o'></i><a/><br>".
" ";
// Show 3 staff per row, separated by an empty column
++ $col[$arr['class']];
if ($col[$arr['class']]<=25)
$staff_table[$arr['class']]=$staff_table[$arr['class']]."";
else
{
$staff_table[$arr['class']]=$staff_table[$arr['class']]."</tr><tr height=15>";
$col[$arr['class']]=0;
}
}
?>
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>Developer's</th>
                                <th>Gründer's</th>
                                <th>Teamleitung's</th>
                                <th>SySop's</th>
                                <th>Administrator's</th>
                                <th>Moderator's</th>								
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?=$staff_table[UC_DEV]?></td>
                                <td><?=$staff_table[UC_BOSS]?></td>
                                <td><?=$staff_table[UC_TEAMLEITUNG]?></td>
                                <td><?=$staff_table[UC_SYSOP]?></td>
                                <td><?=$staff_table[UC_ADMINISTRATOR]?></td>
                                <td><?=$staff_table[UC_MODERATOR]?></td>								
                            </tr>
                        </tbody>
                    </table>
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