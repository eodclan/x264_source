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

x264_admin_header("P-Chat Viewer ACP");

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Privat Chat Info
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<a href='javascript:void(0)' class='uppercase'>Bewahre bitte die Verl&auml;ufe und sage dieses nicht weiter.</a>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>

                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Privat Chat Info
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>";
$res2 = mysql_query("SELECT * FROM privatechat ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);

while ($arr2 = mysql_fetch_assoc($res2))
{
  $res3 = mysql_query("SELECT class, username FROM users WHERE id=".$arr2['absender']) or sqlerr(__FILE__, __LINE__);
  $arr3 = mysql_fetch_array($res3);
  $res4 = mysql_query("SELECT class, username FROM users WHERE id=".$arr2['empfanger']) or sqlerr(__FILE__, __LINE__);
  $arr4 = mysql_fetch_array($res4);  
  $time = strftime("%H:%M",$arr2['added']);
  $msg = format_comment($arr2['msg']);
  print "
											<tr><td>  
												<font class=".get_class_color($arr3['class']).">".$arr3['username']." </font><font class=".get_class_color($arr4['class']).">".$arr4['username']."</font> : ".$msg."
											</td></tr>";
}
print "

                </tbody>
              </table>					
									</ul>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

x264_admin_footer();
?>