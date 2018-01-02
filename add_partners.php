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

if (get_user_class() >= UC_TEAMLEITUNG) {
if($_GET['id1']) {
$id4 = sqlesc($_GET[id1]);
mysql_query("DELETE FROM partner WHERE id = $id4");
}
}
///////////////////// Neue Funktionen hinzufügen \\\\\\\\\\\\\\
if (get_user_class() >= UC_TEAMLEITUNG) {
if($_GET['pa_name']) {
$pa_name = $_GET['pa_name'];
$pa_banurl = $_GET['pa_banurl'];
$pa_url = $_GET['pa_url'];
$editid = $_GET['editid'];
if ($editid) {
$query = "UPDATE partner SET
titel = '$pa_name',
banner = '$pa_banurl',
link = '$pa_url' where id = $editid";
}
else
{
$query = "INSERT INTO partner SET
titel = '$pa_name',
banner = '$pa_banurl',
link = '$pa_url'";
}
$sql = mysql_query($query);
if($sql) {
$success = TRUE;
} else {
$success = FALSE;
}
}
if($success == TRUE) {
$text = "Es wurde eine neue Partnerschaft eingegangen! Auf eine gute Partnerschaft ".$pa_name."!";
$data = array(
  "userid"   => $sbid,
  "username" => "System",
  "date"     => time(),
  "text"     => $text,
  "text_c"   => format_comment(htmlentities($text), false)
);
$db -> insertRow($data, "shoutbox");
header("Location:  " . $_SERVER['PHP_SELF'] . "");

}
}

///////////////////// Neue Funktionen hinzufügen \\\\\\\\\\\\\\
if (get_user_class() >= UC_TEAMLEITUNG) {
if($_GET['pa_name1']) {
$pa_name1 = $_GET['pa_name1'];
$pa_banurl1 = $_GET['pa_banurl1'];
$pa_url1 = $_GET['pa_url1'];
$editid1 = $_GET['editid1'];
if ($editid1) {
$query = "UPDATE toppartner SET
titel1 = '$pa_name1',
banner1 = '$pa_banurl1',
link1 = '$pa_url1' where id1 = $editid1";
}
else
{
$query = "INSERT INTO toppartner SET
titel1 = '$pa_name1',
banner1 = '$pa_banurl1',
link1 = '$pa_url1'";
}
$sql = mysql_query($query);
if($sql) {
$success = TRUE;
} else {
$success = FALSE;
}
}
if($success == TRUE) {
header("Location:  " . $_SERVER['PHP_SELF'] . "");

}
}

///////////////////// Neue Funktionen hinzufügen \\\\\\\\\\\\\\
if (get_user_class() >= UC_TEAMLEITUNG) {
if($_GET['pa_name2']) {
$pa_name2 = $_GET['pa_name2'];
$pa_banurl2 = $_GET['pa_banurl2'];
$pa_url2 = $_GET['pa_url2'];
$editid2 = $_GET['editid2'];
if ($editid2) {
$query = "UPDATE sponsor SET
titel2 = '$pa_name2',
banner2 = '$pa_banurl2',
link2 = '$pa_url2' where id2 = $editid2";
}
else
{
$query = "INSERT INTO sponsor SET
titel2 = '$pa_name2',
banner2 = '$pa_banurl2',
link2 = '$pa_url2'";
}
$sql = mysql_query($query);
if($sql) {
$success = TRUE;
} else {
$success = FALSE;
}
}
if($success == TRUE) {
header("Location:  " . $_SERVER['PHP_SELF'] . "");

}
}
x264_bootstrap_header("Partner Verwaltung");

if (get_user_class() < UC_TEAMLEITUNG)
{
  stdmsg("Sorry...", "Zutritt verweigert!!!");
  stdfoot();
  exit;
}

///////////////////// Neue Optionen hinzufügen \\\\\\\\\\\\\\
if (get_user_class() >= UC_TEAMLEITUNG) {
if ($_GET['editid']) {
$editid = $_GET['editid'];
$query = "SELECT * FROM partner where id = '".$editid."'";
$sql = mysql_query($query);
$row = mysql_fetch_array($sql);
$id = $row['id'];
$tite = $row['titel'];
$banner = $row['banner'];
$url = $row['link'];
}
echo"
<form name='form1' method='get' action='".$_SERVER['PHP_SELF']."'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Partner Hinzuf&uuml;gen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<ul class='chart-legend clearfix'>
										<li>Name vom Partner: <br /><input type='text' size='50' value='".$titel."' name='pa_name'/></li>
										<li>Banner-Url: <br /><input type='text' size='50' value='$banner' name='pa_banurl'/></li>
										<li>Url zur Seite: <br /><input type='text' size='50' value='$url' name='pa_url'/></li>
										<li><br /><input value='Add' type='submit'/></li>					
									</ul>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</form>";
}
$query = "SELECT * FROM partner";
$sql = mysql_query($query);
while ($row = mysql_fetch_array($sql)) {
$id = $row['id'];
$titel = $row['titel'];
$banner = $row['banner'];
$url = $row['link'];

echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Partner - ".$titel."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<ul class='chart-legend clearfix'>
										<li>".$titel."</li>
										<li><a href=".$url." target=_blank><IMG SRC=".$banner."  WIDTH=440 HEIGHT=100 border=0></a></li>
										<li><a href='". $_SERVER['PHP_SELF'] . "?editid=$id'><input value='Edit' type='submit'/></a></li>
										<li><a href='". $_SERVER['PHP_SELF'] . "?id1=$id'><input value='Delete' type='submit'/></a></li>					
									</ul>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}
x264_bootstrap_footer();
?>