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

x264_admin_header("Nameserver Lookup");

check_access(UC_DEV);
security_tactics();

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Nameserver Lookup Info
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<a href='javascript:void(0)' class='uppercase'>Hier drüber kannst du die Users schön nach verfolgen.</a>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>

                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Nameserver Lookup
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>					
		<table class='table'>
			<tr>
				<td>";

$send=intval(substr(GetParam("psend"),0,1));
$domip=substr(GetParam("pdomip"),0,80);
$err_text="";
if(trim($domip)=="")
  $err_text.="Bitte geben Sie einen Domainnamen oder eine IP-Adresse an.";	

print "	
		Beispiele: www.google.com</td>
                </tr>
                <tr>
		oder eine IP-Adresse im Format <em>n.n.n.n</em> (n = Zahl zwischen 0 und 255)</td>
                </tr>
                <tr>";

if(($send == "1") && ($err_text != "")){
  echo "
		Fehler";
  echo "
		".$err_text."";
}		

print "		
		<form action='".GetParam("PHP_SELF", "S")."' method='post'>
		<td>
		Domain oder IP: <input type='text' name='pdomip' size='30' maxlength='50' value='".$domip."'>
		</td>
                </tr>
                <tr>
		<td><input type='submit' value='NSLookup' name='submit'><input type='hidden' value='1' name='psend'></td>
                </tr>
                <tr>		
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

if(($send == "1") && ($err_text == "")) {
  $DB_File="whois.dat";
  $domip=strtolower($domip);

  if(ereg("^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$",$domip))
    LookupIP($domip);
  else
    LookupDomain($domip);
}

function LookupIP($IP) {
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Nameserver Lookup Info
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
		<table class='table'>
			<tr>
				<td>Eingabe: <a href='http://".$IP."'>".$IP."</a></td>
			</tr>
			<tr>
				<td>Ergebnis:</td>
			</tr>
			<tr>";
  
  $Domain=gethostbyaddr($IP);
  if((!$Domain) || ($Domain==$IP))
    $Domain="Der Domainname konnte nicht ermittelt werden.";

  $AliasArry=gethostbynamel($Domain);
  if(isset($AliasArray)){
    foreach($a as $AliasArray)
      $Alias.=$a."<br>";
  }else{
      $Alias="Unbekannt";
  }
  
print "		
				<td>IP-Adresse: ".$IP."</td>
                </tr>
                <tr>
				<td>Domainname: ".$Domain."</td>
                </tr>
                <tr>				
				<td>Alias-Adressen: ".$Alias."</td>
                </tr>
		</table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}

function LookupDomain($Domain) {
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Nameserver Lookup Info
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
				<table class='table'>
				<tr>
				<td>Eingabe: <a href='http://".$Domain."'>".$Domain."</a></td>
                </tr>
                <tr>				
				<td>Ergebnis:</td>
                </tr>
                <tr>";
  
  $IP=gethostbyname($Domain);
  if((!$IP) || ($IP==$Domain))
    $IP="Die IP-Adresse konnte nicht ermittelt werden.";

  $AliasArry = gethostbynamel($Domain);
  if(isset($AliasArray)){
    foreach($a as $AliasArray)
      $Alias.=$a."<br>";
  }else{
    $Alias="Unbekannt";
  }
  
print "		
		<td>IP-Adresse: ".$IP."</td>
                </tr>
                <tr>		
		<td>Domainname: ".$Domain."</td>
                </tr>
                <tr>		
		<td>Alias-Adressen: ".$Alias."</td>	
		</tr>
		</table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}

function GetParam($ParamName, $Method = "P", $DefaultValue = "") {
  if ($Method == "P") {
    if (isset($_POST[$ParamName])) return $_POST[$ParamName]; else return $DefaultValue;
  } else if ($Method == "G") {
    if (isset($_GET[$ParamName])) return $_GET[$ParamName]; else return $DefaultValue;
  } else if ($Method == "S") {
    if (isset($_SERVER[$ParamName])) return $_SERVER[$ParamName]; else return $DefaultValue;
  }
}

x264_admin_footer(); 
?>