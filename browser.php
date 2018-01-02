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

x264_header_nologged('Browser nicht unterstützt');

print "
<div class='x264_wrapper_content_out_mount' style='text-align:left;width:700px;height:560px;margin-top:100px;padding:20px;'>
<br /><h1 class='x264_im_logo'>Willkommen bei ".$GLOBALS["SITENAME"]."</h1>
		<br />
		<div class='x264_nologged_div'>
			Dieses Web-Projekt verwendet aktuelle Standards,<br /> 
			die der Zeit angemessen sind! Mit diesen,<br /> 
			kann man eine Website benutzerfreundlicher und ansehnlicher gestalten.<br /> 
			Außerdem kann man mit denen Features realisieren, die bald auf keiner Website mehr fehlen werden.
			<br />
			<br />
			<b>
			Leider verwendest du momentan einen Browser, der nicht alle moderne Standards vollständig unterstützt.
			<br />
			Bei vielen Browsern, wird nicht die nötige Zeit oder Willen investiert, um wirklich Up To Date zu sein. 
			<br />
			Bei einigen verzichtet man bewusst darauf, da deren Benutzer einfach diese Seiten erst gar nicht besuchen wollen.
			</b>
			<br />
			<br />
			Wir haben uns allerdings dazu entschieden, zu den Vorreitern zu gehören und nicht dazu gezwungen zu werden, 
			<br />			
			veraltete Standards zu verwenden, damit man ja alle Browser unsere Seiten korrekt darstellen und verstehen.
			<br />
			<br />
			Außerdem haben Umfragen ergeben, dass ca. 90% der Benutzer, die diese Art Community nutzen, eh schon den <b>FireFox</b> 
			als ihren Lieblings-Browser verwenden! 
			<br />
			Diese spricht doch eigentlich schon für sich.<br />
			<br />
			<b>
			Achtet auch bitte darauf, euern Browser immer auf den aktuellen Stand zu halten!
			</b>
			<br />
			<br />
			<span style='text-decoration:underline;'>Aktuell unterstützte Browser:</span>
			<br />
			<br />
			<b>
			&bull; Mozilla FireFox</b><br /><b>
			&bull; Google Chrome</b>
		</div>
</div>";
	
x264_footer_nologged();
?>