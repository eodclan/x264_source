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

dbconn(false);
loggedinorreturn();

check_access(UC_BOSS);
security_tactics();

$remove = intval($_GET['remove']);
if (is_valid_id($remove))
{
 mysql_query("DELETE FROM bans WHERE id = $remove LIMIT 1") or sqlerr();
 write_log("autoban","Ban $remove wurde von $CURUSER[id] ($CURUSER[username]) gelöscht!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && get_user_class() >= UC_ADMINISTRATOR)
{
 $first = trim($_POST["first"]);
 $last = trim($_POST["last"]);
 $comment = trim($_POST["comment"]);

 if (!$first || !$last || !$comment)
 stderr("Error", "Formulardaten fehlen.");

 $first = ip2long($first);
 $last = ip2long($last);

 if ($first == -1 || $last == -1)
 stderr("Error", "Falsche IP addresse.");

 $comment = sqlesc($comment);
 $added = sqlesc(get_date_time());

 mysql_query("INSERT INTO bans (added, addedby, first, last, comment) VALUES($added, ".intval($CURUSER["id"]).", $first, $last, $comment)") or sqlerr(__FILE__, __LINE__);
 header("Location: $BASEURL$_SERVER[REQUEST_URI]");
 die;
}

$res = mysql_query("SELECT * FROM bans ORDER BY added DESC") or sqlerr();

x264_admin_header("Security Tactics Bans");

if (mysql_num_rows($res) == 0)
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Security Tactics Bans
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<a href='javascript:void(0)' class='uppercase'>Keine Bans vorhanden</a>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
else
{
print "
                        <div class='col-sm-6'>
                            <div class='card'>
                                <div class='card-header'>
                                    <strong>Security Tactics</strong>
                                    <small>Bans</small>
                                </div>
                                <div class='card-block'>";
	
 while ($arr = mysql_fetch_assoc($res))
 {
  $r2 = mysql_query("SELECT username FROM users WHERE id=".intval($arr[addedby])." LIMIT 1") or sqlerr();
  $a2 = mysql_fetch_assoc($r2);

  $arr["first"] = long2ip($arr["first"]);
  $arr["last"] = long2ip($arr["last"]);

print "
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='name'>Hinzugef&uuml;gt:</label>
                                                ".$arr["added"]."
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='ccnumber'>Erste IP:</label>
                                                ".$arr['first']."
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='ccnumber'>Letzte IP:</label>
                                                ".$arr['last']."
                                            </div>
                                        </div>
                                    </div>									
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='ccnumber'>Von:</label>
                                                <a href='userdetails.php?id=".intval($arr["addedby"])."'>".$a2["username"]."</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='ccnumber'>Kommentar:</label>
                                                ".$arr["comment"]."
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>										
                                                <a href='bans_acp.php?remove=".intval($arr["id"])."'>L&ouml;schen</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->	";	
 }
print"
							
                                </div>
                            </div>
                        </div>";
}

if (get_user_class() >= UC_DEV)
{
print "
<form action='" . $_SERVER[PHP_SELF] . "' method='POST'>
                        <div class='col-sm-6'>
                            <div class='card'>
                                <div class='card-header'>
                                    <strong>Security Tactics</strong>
                                    <small>Bans</small>
                                </div>
                                <div class='card-block'>
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='name'>Hinzugef&uuml;gen:</label>
                                                ".$arr["added"]."
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='ccnumber'>Erste IP</label>
                                                <input type='text' class='form-control' name='first' size='40'>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='ccnumber'>Letzte IP</label>
                                                <input type='text' class='form-control' name='last' size='40'>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='ccnumber'>Kommentar</label>
                                                <input type='text' class='form-control' name='comment' size='40'>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <input type='submit' class='form-control' value='Okay' class='btn'>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->								
                                </div>
                            </div>
                        </div>
</form>";
}
x264_admin_footer();
?>