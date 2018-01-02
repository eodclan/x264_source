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
hit_start();
dbconn();
hit_count();

if (!mkglobal("type"))
	die();

if ($type == "signup" && mkglobal("email")) {
	x264_header_nologged("Benutzeranmeldung");
echo("
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-usd'></i> Benutzeranmeldung
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block text-center'>
		<form action='".$GLOBALS["DEFAULTBASEURL"]."' autocomplete='on'>
		<input type='hidden' name='take' value='yes'>
		<div class='x264_title_content' style='margin-left:auto;margin-right:auto;'>
			<img src='/design/register-ok.png' class='logo-image'>
		</div>
		<div class='x264_title_content' style='margin-left:auto;margin-right:auto;'>
			Du bekommst in K&uuml;rze eine Best&auml;tigungsmail mit dem Aktivierungslink. Folge bitte den Anweisungen in der Mail! Solltest du keine E-Mail bekommen, dann wird dein Account von Hand freigeschaltet.
			<br />
			<input type='submit' value='Login now' class='form-control text-center btn btn-flat btn-primary fc-today-button' />
		</div>
		</form>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>");
	x264_footer_nologged();
}
elseif ($type == "confirmed") {
	x264_header_nologged("Account bereits aktiviert");
echo("
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-usd'></i> Benutzeranmeldung
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block text-center'>
		<form action='".$GLOBALS["DEFAULTBASEURL"]."' autocomplete='on'>
		<input type='hidden' name='take' value='yes'>
		<div class='x264_title_content' style='margin-left:auto;margin-right:auto;'>
			<img src='/design/register-ok.png' class='logo-image'>
		</div>
		<div class='x264_title_content' style='margin-left:auto;margin-right:auto;'>
			Dieser Account wurde bereits aktiviert.
			<br />			
			<input type='submit' value='Login now' class='form-control text-center btn btn-flat btn-primary fc-today-button' />
		</div>
		</form>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>");
	x264_footer_nologged();
}
elseif ($type == "confirm") {
	if (isset($CURUSER)) {
		x264_header_nologged("Account aktivieren");
echo("
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-usd'></i> Benutzeranmeldung
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block text-center'>
		<form action='".$GLOBALS["DEFAULTBASEURL"]."' autocomplete='on'>
		<input type='hidden' name='take' value='yes'>
		<div class='x264_title_content' style='margin-left:auto;margin-right:auto;'>
			<img src='/design/register-ok.png' class='logo-image'>
		</div>
		<div class='x264_title_content' style='margin-left:auto;margin-right:auto;'>
			Dein Account wurde aktiviert!
			<br />			
			<input type='submit' value='Login now' class='form-control text-center btn btn-flat btn-primary fc-today-button' />
		</div>
		</form>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>");
		x264_footer_nologged();
	}
	else {
		x264_header_nologged("Account aktivieren");
echo("
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-usd'></i> Benutzeranmeldung
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block text-center'>
		<form action='".$GLOBALS["DEFAULTBASEURL"]."' autocomplete='on'>
		<input type='hidden' name='take' value='yes'>
		<div class='x264_title_content' style='margin-left:auto;margin-right:auto;'>
			<img src='/design/register-ok.png' class='logo-image'>
		</div>
		<div class='x264_title_content' style='margin-left:auto;margin-right:auto;'>
			Dein Account wurde aktiviert!
			<br />			
			<input type='submit' value='Login now' class='form-control text-center btn btn-flat btn-primary fc-today-button' />
		</div>
		</form>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>");
		x264_footer_nologged();
	}
}
else
	die();

hit_end();
?>