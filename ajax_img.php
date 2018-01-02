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
header('Content-Type: text/html; charset=iso-8859-1'); 
require_once(dirname(__FILE__) . "/include/engine.php");
require_once(dirname(__FILE__) . "/include/image_transform.php");
require_once(dirname(__FILE__) . "/include/gifresizer.php");
dbconn();
loggedinorreturn();

if($_POST['ajax'] == "yes"){

if($_POST['what'] == "info"){
$picid = $_POST['imgid']+0;

$pic_werte = x264_mariadb_ds("SELECT * FROM img_host WHERE id = '".$picid."' AND users = '".$CURUSER['id']."' ");

// Bildhöhe berechnen
$img_info = getimagesize ( $GLOBALS["BITBUCKET_DIR"]."/".date("W", $pic_werte['added'])."/thumb-".$pic_werte['name'].".jpg" );
$img_hoehe = $img_info[1];
$img_hoehe = (198 - $img_hoehe) / 2;
if($pic_werte['gif'] == 'yes'){$endu = '.gif';}else{$endu = '.jpg';}
?>
	<a href="#nogo" onclick="HideImgPop();" class="img_del_but" style="position:absolute;margin:-12px 0 0 598px;"></a>
	
	<div style="float:left;margin:65px 0 0 60px;font-weight:bold;">
		<div style="float:left;width:150px;opacity:0.6;">Hochgeladen am: </div>
		<div style="float:left;width:150px;"><? echo date("d.m.Y  H:i", $pic_werte['added']). " Uhr"; ?></div>
	</div>
	<div style="float:left;margin:2px 0 0 60px;font-weight:bold;">
		<div style="float:left;width:150px;opacity:0.6;">Größe: </div>
		<div style="float:left;width:150px;"><?=mksize($pic_werte['size']); ?></div>
	</div>
	<div style="float:left;margin:2px 0 0 60px;font-weight:bold;">
		<div style="float:left;width:150px;opacity:0.6;">Breite: </div>
		<div style="float:left;width:150px;"><?=$pic_werte['width']."px"; ?></div>
	</div>
	<div style="float:left;margin:2px 0 0 60px;font-weight:bold;">
		<div style="float:left;width:150px;opacity:0.6;">Höhe: </div>
		<div style="float:left;width:150px;"><?=$pic_werte['height']."px"; ?></div>
	</div>
	
	<a href="#nogo" onclick="HideImgPop();" class="del_24" style="position:absolute;margin:-12px 0 0 528px;"></a>	
	
	<div class="tu_fields" style="float:left;margin:20px 0 0 0;width:565px;"><label style="width:200px;">Vorschaubild BBCode (klein):</label>
		<input type="text" value="[img]<?=$GLOBALS["DEFAULTBASEURL"]."/".$GLOBALS["BITBUCKET_DIR"]."/".date("W", $pic_werte['added'])."/thumb-".$pic_werte['name'].".jpg";?>[/img]" onfocus="this.select();" style="width:350px;" class="btn btn-flat btn-primary fc-today-button" />
	</div>
	<div class="tu_fields" style="float:left;margin:5px 0 0 0;width:565px;"><label style="width:200px;">Vorschaubild Direktlink (klein):</label>
		<input type="text" value="<?=$GLOBALS["DEFAULTBASEURL"]."/".$GLOBALS["BITBUCKET_DIR"]."/".date("W", $pic_werte['added'])."/thumb-".$pic_werte['name'].".jpg";?>" onfocus="this.select();" style="width:350px;" class="btn btn-flat btn-primary fc-today-button" />
	</div>
	
	<div class="tu_fields" style="float:left;margin:20px 0 0 0;width:565px;"><label style="width:200px;">Bild BBCode (originalgröße):</label>
		<input type="text" value="[img]<?=$GLOBALS["DEFAULTBASEURL"]."/".$GLOBALS["BITBUCKET_DIR"]."/".date("W", $pic_werte['added'])."/pic-".$pic_werte['name'].$endu;?>[/img]" onfocus="this.select();" style="width:350px;" class="btn btn-flat btn-primary fc-today-button" />
	</div>
	<div class="tu_fields" style="float:left;margin:5px 0 0 0;width:565px;"><label style="width:200px;">Bild Direktlink (originalgröße):</label>
		<input type="text" value="<?=$GLOBALS["DEFAULTBASEURL"]."/".$GLOBALS["BITBUCKET_DIR"]."/".date("W", $pic_werte['added'])."/pic-".$pic_werte['name'].$endu;?>" onfocus="this.select();" style="width:350px;" class="btn btn-flat btn-primary fc-today-button" />
	</div>
	
	<div class="tu_fields" style="float:left;margin:20px 0 0 0;width:565px;"><label style="width:200px;">Bild BBCode (klein -> groß):</label>
		<input type="text" value="[URL=<?=$GLOBALS["DEFAULTBASEURL"]."/".$GLOBALS["BITBUCKET_DIR"]."/".date("W", $pic_werte['added'])."/thumb-".$pic_werte['name'].".jpg";?>][img]<?=$GLOBALS["DEFAULTBASEURL"]."/".$GLOBALS["BITBUCKET_DIR"]."/".date("W", $pic_werte['added'])."/pic-".$pic_werte['name'].$endu;?>[/img][/URL]" onfocus="this.select();" style="width:350px;" class="btn btn-flat btn-primary fc-today-button" />
	</div>

<?}

	if($_POST['what'] == "edit" AND $endu != 'gif'){
	$picid = $_POST['imgid']+0;
	$pic_werte = x264_mariadb_ds("SELECT * FROM img_host WHERE id = '".$picid."' AND users = '".$CURUSER['id']."' ");
	
	if($_POST['workname'] == ""){
		$work_name	= md5($CURUSER['username'].time());
		$file 		= $GLOBALS["BITBUCKET_DIR"]."/".date("W", $pic_werte['added'])."/pic-".$pic_werte['name'].".jpg";	
		$newfile 	= $GLOBALS["BITBUCKET_DIR"]."/".$work_name.".jpg";
		$set_name 	= $work_name;
		copy($file, $newfile);
	}
	
	if($_POST['transform'] == "flip"){
		$workname = $_POST['workname'];
		$set_name = md5($CURUSER['username'].time());		
		$src_file = $GLOBALS["BITBUCKET_DIR"]."/".$workname.".jpg";
		$dst_file = $GLOBALS["BITBUCKET_DIR"]."/".$set_name.".jpg";
		$imageTransform->flipflop($src_file, 'flip', $dst_file);
		
	}else if($_POST['transform'] == "flop"){
		$workname = $_POST['workname'];
		$set_name = md5($CURUSER['username'].time());		
		$src_file = $GLOBALS["BITBUCKET_DIR"]."/".$workname.".jpg";
		$dst_file = $GLOBALS["BITBUCKET_DIR"]."/".$set_name.".jpg";
		$imageTransform->flipflop($src_file, 'flop', $dst_file);

	}else if($_POST['transform'] == "gray"){
		$workname = $_POST['workname'];
		$set_name = md5($CURUSER['username'].time());		
		$src_file = $GLOBALS["BITBUCKET_DIR"]."/".$workname.".jpg";
		$dst_file = $GLOBALS["BITBUCKET_DIR"]."/".$set_name.".jpg";
		$imageTransform->gray($src_file, $dst_file);

	}else if($_POST['transform'] == "save"){
		$workname = $_POST['workname'];		
		$src_file = $GLOBALS["BITBUCKET_DIR"]."/".$workname.".jpg";
		$dst_file = $GLOBALS["BITBUCKET_DIR"]."/".date("W", $pic_werte['added'])."/pic-".$pic_werte['name'].".jpg";
		
		if(copy($src_file, $dst_file)){
		$src_file = $GLOBALS["BITBUCKET_DIR"]."/".$workname.".jpg";
		$dst_file_thumb	= $GLOBALS["BITBUCKET_DIR"]."/".date("W", $pic_werte['added'])."/thumb-".$pic_werte['name'].".jpg";
		copy($dst_file, $dst_file_thumb);				
		$imageTransform->resize($dst_file_thumb, 165, 165);								
		$imageTransform->quality($dst_file_thumb, 100);
		}
		
		$set_name = $workname;		
		$save_info = "<div id='trans_save_info'>Veränderungen gespeichert -> <a href='javascript:location.reload()'>Veränderungen aktualisieren</a></div>";
		
	}else if($_POST['transform'] == "save_kopie"){
		$workname = $_POST['workname'];		
		$src_file = $GLOBALS["BITBUCKET_DIR"]."/".$workname.".jpg";				
		$mdstring = $CURUSER['username'].time();
		$name = md5($mdstring);
		$dst_file = $GLOBALS["BITBUCKET_DIR"]."/".date("W", time())."/pic-".$name.".jpg";
								
		if(copy($src_file, $dst_file)){
		
			$dst_file_thumb	= $GLOBALS["BITBUCKET_DIR"]."/".date("W", time())."/thumb-".$name.".jpg";
			copy($dst_file, $dst_file_thumb);				
			$imageTransform->resize($dst_file_thumb, 165, 165);								
			$imageTransform->quality($dst_file_thumb, 90);
			if(file_exists($dst_file_thumb)){
			
				$query = "INSERT INTO img_host (
										id ,
										users ,
										name ,
										added ,
										size ,
										height ,
										width
										)
										VALUES (NULL , '".$CURUSER['id']."', '".$name."', '".time()."', '".$pic_werte['size']."', '".$pic_werte['height']."', '".$pic_werte['width']."'  )";
			
				if(mysql_query($query)){
				$save_info = "<div id='trans_save_info_a'>Veränderungen als Kopie gespeichert -> <a href='javascript:location.reload()'>Veränderungen aktualisieren</a></div>";
				}else{
				$save_info = "<div id='trans_save_info_b'>Fehler beim speichern</div>";
				}				
			}
			
		}
		
		$set_name = $workname;		
		
	}
	
	// Bildhöhe berechnen
	$img_info  = getimagesize ( $GLOBALS["BITBUCKET_DIR"]."/".$set_name.".jpg" );
	$bildbreite = $img_info[0];
	$bildhoehe = $img_info[1];

	$width = $bildbreite;
	$height = $bildhoehe;
	$max_height = 360;
	$max_width = 360;

	if ($height > $max_height) {
	   $width = ($max_height / $height) * $width;
	   $height = $max_height;
	}

	if ($width > $max_width) {
	   $height = ($max_width / $width) * $height;
	   $width = $max_width;
	}

	$img_hoehe = $height;
	$img_hoehe = (400 - $img_hoehe) / 2;
	
	$dir = $GLOBALS["BITBUCKET_DIR"];
	$fileArray = array();
	foreach (glob($dir."/*") as $filename) {
	$diff = time() - fileatime($filename);
		if($diff > 120){
			unlink($filename);
		}
	}
	
echo $save_info;	
?>
<div id="trans_loader"></div>
<a href="#nogo" onclick="HideImgPop();" class="del_24" style="position:absolute;margin:-12px 0 0 568px;"></a>
<a href="#nogo" id="trans_flip" onclick="AjaxTakeImg('<?=$picid;?>', 'edit', 'flip', '<?=$set_name;?>');" onmouseover="return overlib('Horizontal Spiegeln');" onmouseout="return nd();"></a>
<a href="#nogo" id="trans_flop" onclick="AjaxTakeImg('<?=$picid;?>', 'edit', 'flop', '<?=$set_name;?>');" onmouseover="return overlib('Vertikal Spiegeln');" onmouseout="return nd();"></a>
<a href="#nogo" id="trans_gray" onclick="AjaxTakeImg('<?=$picid;?>', 'edit', 'gray', '<?=$set_name;?>');" onmouseover="return overlib('Schwarzweiß ACHTUNG: Beim rückgängig machen der Farben, gehen alle Spiegelungen verloren.');" onmouseout="return nd();"></a>
<a href="#nogo" id="trans_gray_b" onclick="AjaxTakeImg('<?=$picid;?>', 'edit', '', '');" onmouseover="return overlib('Farben zurück holen ACHTUNG: Alle Spiegelungen gehen verloren.');" onmouseout="return nd();"></a>
<a href="#nogo" id="trans_save" onclick="AjaxTakeImg('<?=$picid;?>', 'edit', 'save', '<?=$set_name;?>');" onmouseover="return overlib('Speichern');" onmouseout="return nd();"></a>
<a href="#nogo" id="trans_save_kopie" onclick="AjaxTakeImg('<?=$picid;?>', 'edit', 'save_kopie', '<?=$set_name;?>');" onmouseover="return overlib('Als Kopie Speichern. Das Original bleibt erhalten.');" onmouseout="return nd();"></a>
<div id="img_big_pic_edit">	
	<img id="img_big_pic_b" style="width:<?=$width;?>px;height:<?=$height;?>px;margin-top:<?=$img_hoehe;?>px;opacity:0;" src="<?=$GLOBALS["BITBUCKET_DIR"]."/".$set_name.".jpg";?>" alt="" />		
</div>

<?}}?>