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
check_access(UC_DEV);
security_tactics();

x264_admin_header('Memcached System');

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Memcached System Info
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<a href='javascript:void(0)' class='uppercase'>Hiermit kannst du schauen, ob dass Memcached System richtig läuft.</a>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>

                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Memcached System Status
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";

$memcache = new Memcache;
$memcache->connect('localhost', 11211) or die ("Verbindung konnte nicht Hergestellt werden.");

$version = $memcache->getVersion();
echo "
<table class='table table-bordered table-striped'>
<td>Server's version: ".$version."</td>\n";

$tmp_object = new stdClass;
$tmp_object->str_attr = 'test';
$tmp_object->int_attr = 123;

$memcache->set('key', $tmp_object, false, 10) or die ("Daten konnten nicht auf dem Server gespeichert werden.");
echo "<td>Speichern von Daten im Cache (Daten werden innerhalb von 10 Sekunden ab)</td>";

$get_result = $memcache->get('key');
echo "<td>Die Daten aus dem Cache-Speicher:</td>";

echo "<td>";
var_dump($get_result);
echo "/<td>
</tr>
</table>";
print "
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";


x264_admin_footer();
?>