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

require_once(dirname(__FILE__) . "/include/bittorrent.php");
dbconn();
loggedinorreturn();

x264_bootstrap_header("Style Manager");

check_access(UC_DEV);
security_tactics();

if (get_user_class() < UC_DEV) adddeniedlog(); {
if($_GET['id1']) {
$id4 = sqlesc($_GET[id1]);
mysql_query("DELETE FROM design WHERE id = $id4");
}
}
if (get_user_class() >= UC_DEV) {
	if($_GET['id']) {
	$id = $_GET['id'];
	$uri = $_GET['uri'];
	$name = $_GET['name'];
	$designer = $_GET['designer'];
	$version = $_GET['version'];	
	$editid = $_GET['editid'];
if ($editid) {
$query = "
		UPDATE design SET
		id = '$id',
		uri = '$uri',
		name = '$name',
		designer = '$designer', 
		version = '$version',
		where id = $editid";
}
else
{
$query = "
		INSERT INTO design SET
		id = '$id',
		uri = '$uri',
		name = '$name',
		designer = '$name', 
		version = '$version'";	
}
$sql = mysql_query($query);
if($sql) {
$success = TRUE;
} else {
$success = FALSE;
}
}
if($success == TRUE) {
/* stdpmsg("Erfolgreich", "Du hast den Sms Spenden id Code ".$CURUSER["username"]." erfolgreich eingetragen!<br />Du wirst jetzt weitergeleitet!"); */
print("<meta http-equiv=\"refresh\" content=\"0; URL=themecp.php\">");

}
}

if (get_user_class() < UC_DEV)
{
  stdmsg("Sorry...", "Zutritt verweigert!!!");
  stdfoot();
  exit;
}

if (get_user_class() >= UC_DEV) {
echo("
<form name='form1' method='get' action='" . $_SERVER['PHP_SELF'] . "'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Theme System Info
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
<table class='table'>");		

if ($_GET['editid']) {
	$editid = $_GET['editid'];
	$query = "SELECT * FROM design where id = '".$editid."'";
	$sql = mysql_query($query);
	$row = mysql_fetch_array($sql);
	$id = $_GET['id'];
	$uri = $_GET['uri'];
	$name = $_GET['name'];
	$designer = $_GET['designer'];
	$version = $_GET['version'];	
}
echo("
	<tr>
		<td class='tablea'>Theme ID:</td><td class='tablea' align='left'><input type='text' size='50' value='$id' name='id'/></td>
	</tr>
	<tr>	 
		<td class='tablea'>URI:</td><td class='tablea' align='left'><input type='text' size='50' value='$uri' name='uri'/></td>
	</tr>
	<tr>	
		<td class='tablea'>Name:</td><td class='tablea' align='left'><input type='text' size='50' value='$url' name='name'/></td>
	</tr>
	<tr>	
		<td class='tablea'>Designer:</td><td class='tablea' align='left'><input type='text' size='50' value='$designer' name='designer'/></td>
	</tr>
	<tr>	
		<td class='tablea'>Version:</td><td class='tablea' align='left'><input type='text' size='50' value='$version' name='version'/></td>
	</tr>
	<tr>	
		<td class='tablea'><div align='center'><input type='hidden' name='editid' value='$id'/></div></td>
	</tr>		
	<tr>
		<td class='tablea'>Hinzuf&uuml;gen:</td><td class='tablea' align='left'><div align='left'><input value='Theme Hinzuf&uuml;gen' type='submit'/></div></td>
	</tr>
</table>	
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</form>");
}

echo("
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Theme Info
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>");

	$res = mysql_query("
						SELECT * 
						FROM design") 
						or sqlerr(__FILE__,__LINE__);

while ($arr = mysql_fetch_assoc($res))
{
	$res2 = mysql_query("
						SELECT COUNT(*) 
						AS count 
						FROM users 
						WHERE design = ".$arr['id']) 
						or sqlerr(__FILE__,__LINE__);

	$arr2 = mysql_fetch_assoc($res2);

echo("
            <div class='box-body no-padding'>
              <table class='table'>
                <tr>
                  <th>Theme ID: ".$arr['id']."</th>
                </tr>
                <tr>
                  <td>Name: ".$arr['name']."</td>
                </tr>
                <tr>
                  <td>URI: ".$arr['uri']."</td>
                </tr>
                <tr>
                  <td>Default: ".($arr['default']=='yes'?'Ja':'Nein')."</td>
                </tr>
                <tr>
                  <td>Nutzer: ".$arr2['count']."</td>
                </tr>
                <tr>
                  <td>Version: ".$arr['version']."</td>
                </tr>
                <tr>
                  <td>Designer: ".$arr['version']."</td>
                </tr>");
}
echo("
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>");

x264_bootstrap_footer();
?>