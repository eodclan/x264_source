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

if (!preg_match("/^(\\d{1,3})\\.(\\d{1,3})\\.(\\d{1,3})\\.(\\d{1,3})$/", $_GET["ip"])) {
    echo "Keine gültige IP angegeben!";
    die();
}

$parts = explode(".", $_GET["ip"]);
foreach($parts as $part) {
    if (intval($part)<0 || intval($part)>255) {
    echo "Keine gültige IP angegeben!";
    die();
    }
}

$querry = $_GET["ip"];

x264_header("WHOIS-Abfrage zur IP ".$_GET["ip"]);
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-users'></i>WHOIS-Abfrage zur IP <?=$_GET["ip"];?>
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
<?
  $WhoIsServer = "whois.geektools.com";
  if((empty($querry) == false) && (empty($WhoIsServer) == false)){
    $fps = fsockopen ("$WhoIsServer", 43, $errno, $errstr) or die(printf("<div class='table table-bordered table-striped table-condensed'>Sorry, beim Verbindungsaufbau zum Whois-Server ist ein Fehler aufgetreten!</div><br><br>\n"));
    set_socket_blocking($fps, 0);
    fputs($fps, "$querry\n");
    $result = "<div class='table table-bordered table-striped table-condensed'>\n";
    while(!feof($fps)){
    $result .= fgets($fps, 2048);
    }
    $result .= "</div><br><br>\n";
    fclose($fps); 
  }else{
    $result = "<div class='table table-bordered table-striped table-condensed'>Sorry, Sie haben vergessen, die zu pr&uuml;fende Domain- oder IP-Adresse einzugeben!</div>\n";
  }
  echo $result;
?>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
	
<?x264_footer();?>