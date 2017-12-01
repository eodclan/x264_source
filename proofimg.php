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
function putChar($char, $index)
{
    global $codeimage;
    
    /* Verfügbare Schriften */
    $fonts = Array("Hang_the_DJ.ttf", "comic.ttf", /*"dc_s.ttf",*/ "dauphinn.ttf");
    
    /* Schriftart festlegen */
    $usedfont = "proof/fonts/" . $fonts[rand(0, count($fonts)-1)];
    /* Schriftgröße festlegen */
    $size = rand(18, 36);
    /* Schrift-Winkel festlegen */
    $angle = rand(-45, 45);
    
    /* Bounding Box ermitteln */
    $sizeinfo = imagettfbbox($size, $angle, $usedfont, $char);
    
    /* Rechteckkoordinaten des Boundary-Polygons ermitteln */
    $minx = min($sizeinfo[0], $sizeinfo[2], $sizeinfo[4], $sizeinfo[6]);
    $miny = min($sizeinfo[1], $sizeinfo[3], $sizeinfo[5], $sizeinfo[7]);
    $maxx = max($sizeinfo[0], $sizeinfo[2], $sizeinfo[4], $sizeinfo[6]);
    $maxy = max($sizeinfo[1], $sizeinfo[3], $sizeinfo[5], $sizeinfo[7]);
    
    /* Ausmaße des Rechtecks berechnen */
    $textwidth = $maxx - $minx;
    $textheight = $maxy - $miny;
    
    /* Textposition festlegen, damit der Text innerhalb der Bildgrenzen erscheint */
    $textleft = rand(-$minx, 50-$textwidth-$minx) + ($index*50);
    $texttop = rand(-$miny, 80-$textheight-$miny);
    
    /* Text darstellen */
    imagettftext($codeimage, $size, $angle, $textleft, $texttop, $textcolor, $usedfont, $char);

}

session_start();
$prooftext = $_SESSION["proofcode"];

/* Zufallsgenerator initialisieren */
srand(microtime()*360000);


/* Bild erstellen und Textfarbe (Schwarz) alloziieren */
$codeimage = imagecreatetruecolor(300, 80);
$textcolor = imagecolorallocate($codeimage, 0, 0, 0);

/* Hintergrund laden und einkopieren */
$bkg = imagecreatefrompng("proof/bkg/" . rand(1, 14) . ".png");
imagecopy($codeimage, $bkg, 0, 0, 0, 0, 300, 80);
imagedestroy($bkg);

/* 0-3 Artefakte (Störungen) */
$artifactcnt = rand(0,3);
/* Artefakte laden und einkopieren */
for($I=0; $I<$artifactcnt; $I++) {
	$artifact = imagecreatefrompng("proof/artifacts/" . rand(1, 15) . ".png");
	imagecopy($codeimage, $artifact, rand(0, 300-imagesx($artifact)), rand(0, 80-imagesy($artifact)), 0, 0, imagesx($artifact), imagesy($artifact));
	imagedestroy($artifact);
}

/* 6-20 Linien */
$linecnt = rand(6, 20);
/* Linien zufällig zeichnen */
for($I=0; $I<$linecnt; $I++) {
	$linecolor = imagecolorallocate($codeimage, rand(0, 128), rand(0, 128), rand(0, 128));
	imageline($codeimage, rand(0, 300), rand(0, 80), rand(0, 300), rand(0, 80), $linecolor);
}

for ($I=0;$I<6;$I++) {
    putChar($prooftext[$I], $I);
}

/* Bild ausgeben */
header("Content-Type: image/jpeg");
imagejpeg($codeimage, NULL, 50);

/* Bild zerstören */
imagedestroy($codeimage);

?>