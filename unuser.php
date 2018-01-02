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
check_access(UC_MODERATOR);
security_tactics();
x264_admin_header("Unbestätigte User");

$action=(int)$_GET['action'];
$action=($action<1?0:$action>2?0:$action);
$uid = $_GET['uid'];
if($action && !empty($uid)) {
$uida=explode('o',$uid);
foreach($uida as $key => $value)
$uida[$key]='id='. sqlesc((int)abs($value));
$uids=implode(" OR ",$uida);
if($action==1) {
$query="UPDATE users SET status='confirmed',editsecret='',enabled='yes' WHERE status='pending' AND (". $uids. ")";
$type='confirmed';
} else {
$query="DELETE FROM users WHERE status='pending' AND (". $uids .")";
$type='deleted';
}
$num=count($uida);
mysql_query($query);
$arow=(int)mysql_affected_rows();
echo "<p>$arow of $num user accts $type</p><br>";
}

$page=(int)$_GET['page'];
$perpage=30;

$arr=mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM users WHERE status='pending'"));
$pages=($pp=floor($arr[0] / $perpage))+($pp*$perpage < $arr[0]?1:0);
$page=($page<1?1:$page>$pages?$pages:$page);
for ($i=1;$i<=$pages;++$i)
$pagemenu.=($i!=$page?"<a href=?page=$i>":'')."<b>$i</b>".($i!=$page?'</a>':'')."\n";
$browsemenu.=($page>1?'<a href=?page='.($page-1).'>':'').'<b>&lt;&lt; Zurueck</b>'.($page>1?'</a>':'');
$browsemenu.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$browsemenu.=($page<$pages?'<a href=?page='.($page+1).'>':'').'<b>Weiter &gt;&gt;</b>'.($page<$pages?'</a>':'');

$offset=($page*$perpage)-$perpage;
$res=mysql_query("SELECT * FROM users WHERE status='pending' LIMIT $offset,$perpage");
if (mysql_errno())
	print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Unbestätigte User
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									Momentan keine User vorhanden!
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
$num=mysql_num_rows($res);
print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Unbestätigte User
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
?>
<script type="text/javascript">
<!-- Begin Un/CheckAll
function checkAll(ref)
{
var chkAll = document.getElementById('checkAll');
var checks = document.getElementsByName('cbox');
var uid = document.getElementById('uid');
var boxLength = checks.length;
var allChecked = true;
var uids = "";

if(ref==1) {
for(i=0;i<boxLength;i++) {
checks[i].checked=chkAll.checked;
if(chkAll.checked==true)
uids += checks[i].value+"o";
}
} else {
for(i=0;i<boxLength;i++) {
if(checks[i].checked==true)
uids += checks[i].value+"o";
else
allChecked=false;
}
chkAll.checked=allChecked;
}
uid.value=uids.substring(0,uids.length-1);
}
// End -->
</script>


<tr class=tablecat align="left" valign="middle">
<td class=tablecat><input id="checkAll" type="checkbox" onClick="checkAll(1)" value="">&nbsp;Alle</td>
<td class=tablecat>Mitglieds-ID</td>
<td class=tablecat>Mitglied</td>
<td class=tablecat>E-mail</td>
<td class=tablecat>Registriert</td>
</tr>
<?
for ($i=0;$i<$num;++$i)
{
$arr=mysql_fetch_assoc($res);
if ($arr['added'] == '0000-00-00 00:00:00')
$arr['added'] = '-';
?>
<tr>
<td class=tableb align="center" valign="middle" class="tablea">
<input name="cbox" type="checkbox" onClick="checkAll(2)" value="<?=$arr[id]?>">
</td>
<td class="tablea">&nbsp;<?=$arr['id']?></td>
<td class="tableb">&nbsp;<?=$arr['username']?></td>
<td class="tablea">&nbsp;<?=$arr['email']?></td>
<td class="tableb">&nbsp;<?=$arr['added']?></td>
</tr>
<?
}
if(!$num) {
?>
<tr class="tableb"><td align="center" colspan="5">Nichts</td></tr>
<?
}
?>
<tr>
<td class=tableb colspan="3" align="center" valign="middle" class="bottom">
<form action="" method="get" name="pending">
<input name="uid" id="uid" type="hidden" value="">
&nbsp;Aktion:&nbsp;
<select name="action" size="1">
<option value="1" selected>Freischalten</option>
<option value="2">Entfernen</option>
</select>&nbsp;<input id="Submit" type="submit" <?=($num?'':'disabled')?>>
</form>
</td>
<td class=tableb colspan="2" align="center" valign="middle" class="bottom">
<?=$browsemenu?><br><?=$pagemenu?>
</td>
</tr>
<?
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
x264_admin_footer();
?>