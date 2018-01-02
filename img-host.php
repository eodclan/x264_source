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
require_once(dirname(__FILE__) . "/include/image_transform.php");
require_once(dirname(__FILE__) . "/include/gifresizer.php");
dbconn();
loggedinorreturn();
 
$trackerdienste = $GLOBALS["IMG_HOST"];
if ($trackerdienste[0] == "0")
{
  x264_header("Das Img-Host System ist zur Zeit deaktiviert.");
  stdmsg("Achtung","Das Img-Host System ist zur Zeit deaktiviert.");
  x264_footer();
  die();
}

if(isset($_GET['action']) AND $_GET['action'] == 'del'){
	$id = $_GET['id']+0;
	$del_name = x264_mariadb_ds("SELECT name, added, gif FROM img_host WHERE id = '".$id."' AND users = '".$CURUSER['id']."' LIMIT 1");
	if($del_name['gif'] == 'yes'){$endu = '.gif';}else{$endu = '.jpg';}
	@unlink($GLOBALS["BITBUCKET_DIR"]."/".date("W", $del_name['added'])."/pic-".$del_name['name'].$endu);
	@unlink($GLOBALS["BITBUCKET_DIR"]."/".date("W", $del_name['added'])."/thumb-".$del_name['name'].".jpg");
	mysql_query("DELETE FROM img_host WHERE id = '".$id."' AND users = '".$CURUSER['id']."' LIMIT 1");
}

if(isset($_GET['action']) AND $_GET['action'] == 'del_complete'){

	$query = "SELECT * FROM img_host WHERE users = '".$CURUSER['id']."' ";
	$result = mysql_query($query);
	while($data = mysql_fetch_object($result)){
	if($data -> gif == 'yes'){$endu = '.gif';}else{$endu = '.jpg';}
	@unlink($GLOBALS["BITBUCKET_DIR"]."/".date("W", $data -> added)."/pic-".$data -> name.$endu );
	@unlink($GLOBALS["BITBUCKET_DIR"]."/".date("W", $data -> added)."/thumb-".$data -> name.".jpg");
	}
	mysql_query("DELETE FROM img_host WHERE users = '".$CURUSER['id']."' ");	
}

if(isset($_POST['pic_upload'])){
	// -> Ist ein Bild vorhanden?
		$check_pic = $_FILES["pic"]["name"];
		if($check_pic == ""){$fout = true; $fout_info = "<span style='color:red;'>Du hast das Bild vergessen.</span>";}else{$fout = false;}
		
	// -> Dateiendung vom Bild
	if($fout != true){
		$check_pic2 = substr(strtolower($_FILES["pic"]["name"]), -4);
		if($check_pic2 != '.jpg' AND $check_pic2 != '.gif' AND $check_pic2 != '.png' AND $check_pic2 != 'jpeg'){
		$fout = true; $fout_info = "<span style='color:red;'>Dein Bild hat eine falsche Dateiendung (.jpg, .gif, .png oder .jpeg).</span>"; 
		}else{
		$fout = false;
		}
	}
	
	// -> Größe vom Bild
	if($fout != true){
	if($_FILES["pic"]["size"] > $GLOBALS["MAX_BITBUCKET_SIZE_USER"]){$fout = true; $fout_info = "<span style='color:red;'>Das Bild ist leider zu groß (max. 1 MB).</span>";}else{$fout = false; $size = $_FILES["pic"]["size"];}
	}
	
	// -> Breite vom Bild
	if($fout != true){
	$infosize = getimagesize($_FILES["pic"]['tmp_name']);	
	if ($infosize[0] > 3000){$fout = true; $fout_info = "<span style='color:red;'>Das Bild ist zu breit. Bitte nicht über 3000px breit. Dein Bild ist ".$infosize[0]."px breit.</span>";}else{$fout = false;}
	}
	// -> Bild bearbeiten und speichern
	
	if($fout != true){
		
		if(!is_dir($GLOBALS["BITBUCKET_DIR"]."/".date("W", time()))){
		mkdir($GLOBALS["BITBUCKET_DIR"]."/".date("W", time()),0777);
		mkdir($GLOBALS["BITBUCKET_DIR"]."/".date("W", time()),0777);
		}
		
		$breite = $infosize[0];
		$hoehe = $infosize[1];
		if($_FILES['pic']['tmp_name'] != ''){
				$mdstring = $CURUSER['username'].time();
				$name = md5($mdstring);
				$cover = $_FILES['pic']['tmp_name'];
				
				if($check_pic2 == '.jpg' OR $check_pic2 == '.png' OR $check_pic2 == 'jpeg'){
				
					$imageTransform->resize($cover, 1920, 1080);
					$imageTransform->quality($cover, 90);				
					$dst_file = $GLOBALS["BITBUCKET_DIR"]."/".date("W", time())."/pic-".$name.".jpg";
						if(move_uploaded_file($cover, $dst_file)){
						$first_check = true;
						$gif = "no";
						}else{
						$first_check = false;
						}
						
				}else if($check_pic2 == '.gif'){
				
					$gr = new gifresizer;	//New Instance Of GIFResizer
					$gr->temp_dir = "user_uploads/img-host/frames"; //Used for extracting GIF Animation Frames
					$gr->resize($cover,$GLOBALS["BITBUCKET_DIR"]."/".date("W", time())."/pic-".$name.".gif",$breite,$hoehe); //Resizing the animation into a new file.
					$dst_file = $GLOBALS["BITBUCKET_DIR"]."/".date("W", time())."/pic-".$name.".gif";
						if(file_exists($dst_file)){
						$first_check = true;
						$gif = "yes";
						}else{
						$first_check = false;
						}
						
				}
				
			if($first_check == true){
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
											width,
											gif
											)
											VALUES (NULL , '".$CURUSER['id']."', '".$name."', '".time()."', '".$size."', '".$hoehe."', '".$breite."', '".$gif."'  )";
				
					if(mysql_query($query)){
					$up_img = mysql_insert_id();
					header('Location: img-host.php?pop='.$up_img);exit;
					}				
				}
			}					
		}		
	}	
}
$seite = $_GET["seite"];
if(!isset($seite))
   {
   $seite = 1;
   }
$eintraege_pro_seite = 10;
$start = $seite * $eintraege_pro_seite - $eintraege_pro_seite;

$query = "SELECT * FROM img_host WHERE users = '".$CURUSER['id']."' LIMIT $start, $eintraege_pro_seite ";
$result = mysql_query($query);

$size_sum = x264_mariadb_df("SELECT SUM(size) FROM img_host WHERE users = '".$CURUSER['id']."' ");
$count_img = x264_mariadb_df("SELECT COUNT(*) FROM img_host WHERE users = '".$CURUSER['id']."' ");
$maxbucketsize = $GLOBALS["MAX_BITBUCKET_SIZE_USER"];
$percent = min(300,round($size_sum / $maxbucketsize * 100));
$widthh = $percent * 4;

$menge = $count_img;
$wieviel_seiten = $menge / $eintraege_pro_seite;
$seite_back = $seite-1;
$seite_forw = $seite+1;
$von = ceil($wieviel_seiten);

if(isset($_GET['pop'])){
	$popid = $_GET['pop']+0;
	if(is_numeric($popid) AND $popid != '0'){
		$ajax_pop = 'ok';
		$popimg = $popid;
	}
}
x264_header('Dein Image-Host System V2');
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Image-Host System
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
<script type="text/javascript">
			
	hs.align = "center";
	hs.transitions = ["expand", "crossfade"];
	hs.wrapperClassName = "dark borderless floating-caption";
	hs.fadeInOut = true;
	hs.dimmingOpacity = .90;
				
	// Add the controlbar
	hs.addSlideshow({
		slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .6,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
	
	// gallery config object
	var config1 = {
		slideshowGroup: 'group1',
		transitions: ['expand', 'crossfade']
	};
	
	function tu_push(text, tuid) {
	var TuId = tuid;
	var PushText = text;
	var PushIn = document.getElementById(TuId);
	PushIn.innerHTML = PushText;
	}

	function MakeUp(){
		if(document.getElementById('img_form').style.display == 'block'){
		document.getElementById('img_form').style.display = 'none';
		document.getElementById('js_b').innerHTML = 'Bild hochladen';
		}else{
		document.getElementById('img_form').style.display = 'block';
		document.getElementById('js_b').innerHTML = 'wieder schließen';
		}
	}

	function MakeInfoPop(){
		if(document.getElementById('img_info_pop').style.display == 'block'){
		document.getElementById('img_info_pop').style.display = 'none';
		document.getElementById('js_c').innerHTML = 'Informationen';
		}else{
		document.getElementById('img_info_pop').style.display = 'block';
		document.getElementById('js_c').innerHTML = 'Info ausblenden';
		}
	}

	function MakeOpaWeg(idnumber){
		document.getElementById('opa_' + idnumber).style.opacity = '1';
	}
	function MakeOpaWieder(idnumber){
		document.getElementById('opa_' + idnumber).style.opacity = '0.2';
	}
	function MakeInfoWeg(idnumber){
		document.getElementById('info_' + idnumber).style.opacity = '1';
	}
	function MakeInfoWieder(idnumber){
		document.getElementById('info_' + idnumber).style.opacity = '0.2';
	}

	function AjaxTakeImg(imgid, what, trans, workwith){
	
	if(trans != ''){
	document.getElementById('img_big_pic_b').style.opacity = '0';
	}
	
	var ajax = new tbdev_ajax();
	ajax.onShow ('');
	var varsString = "";
	ajax.requestFile = "ajax_img.php";
	ajax.setVar("imgid", imgid);
	ajax.setVar("ajax", "yes");
	ajax.setVar("what", what);
	ajax.setVar("transform", trans);
	ajax.setVar("workname", workwith);
	ajax.method = 'POST';
	ajax.element = 'img_big_picture';
	ajax.sendAJAX(varsString);
	

	window.setTimeout('MakeSee()', 2000);

	
	document.getElementById('img_big_picture').style.display = 'block';
	}
	
	function MakeSee(){
	document.getElementById('img_big_pic_b').style.opacity = '1';
	}
	
	function HideImgPop(){
	document.getElementById('img_big_picture').style.display = 'none';
	}
	
	
	
	<?if($ajax_pop == 'ok'){?>
	window.setTimeout('AjaxTakeImg("<?=$popimg;?>", "info", "", "", "")', 1000);
	<?}?>

</script>
	<div id="img_big_picture"></div>
	<div id="img_size_view_w">	
		<div id="img_upload"><a href="#nogo" class="textarea" id="js_b" onclick="MakeUp()">Bild hochladen</a></div>
		<div id="img_info_but"><a href="#nogo" class="textarea" id="js_c" onclick="MakeInfoPop()">Informationen</a></div>
		<div id="img_size_view_ww">
			<div id="img_size_view">
				<div  id="img_size_view_b" style="width:<?=$widthh;?>px; height:15px; background-image:url(design/ryg-verlauf.png); background-repeat:no-repeat;"></div>
			</div>
		</div>		
		<div style="float:left;margin:2px 0 0 10px;"><?echo mksize($size_sum)." von ".mksize($maxbucketsize)." in ".$count_img." Dateien belegt (".$percent."%)";?></div>		
	</div>
	
	<br class="clear" />
	
	<div id="img_form" <?if($fout_info != ''){echo 'style="display:block;"';}?>>
		<div id="img_info"><?=$fout_info;?></div>
		<form enctype="multipart/form-data" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
			<div class="tu_fields" style="float:left;margin:5px 0 0 20px;"><label>Image auswählen:</label>
				<div class="tu_fake">
					<input type="file" name="pic" onchange="tu_push(this.value, 'tug')" class="tu_fake_file" size="60" />
					<div class="tu_fakeinput"><div class="tu_in_fakeinput" id="tug" style="padding-left:5px;"></div><a href="#nogo" class="tu_file_button">Durchsuchen</a></div>
				</div>
			</div>
			
			<div style="margin:12px 50px 0 0;float:right;">
				<input type="submit"  name="pic_upload" class="stand_inp_but" value="hochladen" onfocus="this.blur()" />
			</div>
		</form>
	</div>
	
	<div id="img_info_pop">
	<b>Hier hast du die Möglichkeit einige Images zu speichern, um sie z.B. in Beschreibungen oder Kommentaren zu verwenden.</b>
	</div>
	
	<?if($count_img){?>
	<div style='text-align:center;margin:45px 0 10px 0;'>
	<?	
	for($a=0; $a < $wieviel_seiten; $a++){
	$b = $a + 1;
	if($seite == $b){echo "<a href='#nogo' class='textarea' onmouseover='return overlib(\"Aktuelle Seite\");' onmouseout='return nd();'>$b</a>";}else{echo "  <a href='?seite=$b' class='textarea' onmouseover='return overlib(\"Seite ".$b." von ".$von."\");' onmouseout='return nd();'>$b</a> ";}
	}
	echo "</div><div style='margin:-55px 0 0 0;width:920px;height:48px;'>";
	if($seite_back != 0){
	echo "<div style='width:48px;height:48px;float:left;'><a href='?seite=$seite_back' class='x264_title' onmouseover='return overlib(\"Eine Seite zurück\");' onmouseout='return nd();'></a></div>";
	}else{
	echo "<div style='width:48px;height:48px;float:left;'></div>";
	}	   
	if($seite_back != $b-1){
	echo "<div style='width:48px;height:48px;float:right;'><a href='?seite=$seite_forw' class='x264_title' onmouseover='return overlib(\"Eine Seite vor\");' onmouseout='return nd();'></a></div>";
	}else{
	echo "<div style='width:48px;height:48px;float:right;'></div>";
	}?>
	</div>
	<?}?>
	
	<div class="img_big_wrap">
	<?$i=1;while($data = mysql_fetch_object($result)){
	// Bildhöhe berechnen
	$img_info = getimagesize ( $GLOBALS["BITBUCKET_DIR"]."/".date("W", $data -> added)."/thumb-".$data -> name.".jpg" );
	$img_hoehe = $img_info[1];
	$img_hoehe = (165 - $img_hoehe) / 2;?>
	
	<div class="img_wrap">
		<div class="highslide-gallery">
			<div class="img_but_wrap" style="opacity:0.2;" id="opa_<?=$i;?>" onmouseover="MakeOpaWeg('<?=$i;?>');" onmouseout="MakeOpaWieder('<?=$i;?>');">
				<a href="img-host.php?id=<?=$data -> id;?>&amp;action=del" class="img_del_but" onclick="show_confirm_head(this);return false;"></a>
				<?if($data -> gif != 'yes'){?>
				<a href="#nogo" class="img_edit_but" onclick="AjaxTakeImg('<?=$data -> id;?>', 'edit', '', '');"></a>
				<?}?>				
				<a href="#nogo" class="img_info_but" onclick="AjaxTakeImg('<?=$data -> id;?>', 'info', '', '');"></a>
			</div>
			<div class="img_info_bottom" style="opacity:0.2;" id="info_<?=$i;?>" onmouseover="MakeInfoWeg('<?=$i;?>');" onmouseout="MakeInfoWieder('<?=$i;?>');">
			<?=mksize($data -> size);?> / <?=$data -> width;?>px&nbsp;&nbsp;x&nbsp;&nbsp;<?=$data -> height;?>px
			</div>
			<?if($data -> width > 165 OR $data -> height > 165){
			if($data -> gif == 'yes'){$endu = '.gif';}else{$endu = '.jpg';}
			?>
			<a href="<?=$GLOBALS["BITBUCKET_DIR"]."/".date("W", $data -> added)."/pic-".$data -> name.$endu;?>" alt="" style="margin-top:<?=$img_hoehe;?>px">
			<img src="<?=$GLOBALS["BITBUCKET_DIR"]."/".date("W", $data -> added)."/thumb-".$data -> name.".jpg";?>" alt="" style="margin-top:<?=$img_hoehe;?>px" />
			</a>
			<?}else{?>
			<img src="<?=$GLOBALS["BITBUCKET_DIR"]."/".date("W", $data -> added)."/thumb-".$data -> name.".jpg";?>" alt="" style="margin-top:<?=$img_hoehe;?>px" />
			<?}?>
		</div>
	</div>
	
	<?$i++;}if($i == 1){echo "<div id='img_no'>Du hast keine Bilder in deinem Image-Hoster gespeichert</div>";}?>
	<br class="clear" />
	</div>
	
	<?if($count_img){?>
	<div style='text-align:center;margin:15px 0 10px 0;'>
	<?	
	for($a=0; $a < $wieviel_seiten; $a++){
	$b = $a + 1;
	if($seite == $b){echo "<a href='#nogo' class='textarea' onmouseover='return overlib(\"Aktuelle Seite\");' onmouseout='return nd();'>$b</a>";}else{echo "  <a href='?seite=$b' class='textarea' onmouseover='return overlib(\"Seite ".$b." von ".$von."\");' onmouseout='return nd();'>$b</a> ";}
	}
	echo "</div><div style='margin:-30px 0 0 0;width:920px;height:48px;'>";
	if($seite_back != 0){
	echo "<div style='width:48px;height:48px;float:left;'><a href='?seite=$seite_back' class='x264_title' onmouseover='return overlib(\"Eine Seite zurück\");' onmouseout='return nd();'></a></div>";
	}else{
	echo "<div style='width:48px;height:48px;float:left;'></div>";
	}	   
	if($seite_back != $b-1){
	echo "<div style='width:48px;height:48px;float:right;'><a href='?seite=$seite_forw' class='x264_title' onmouseover='return overlib(\"Eine Seite vor\");' onmouseout='return nd();'></a></div>";
	}else{
	echo "<div style='width:48px;height:48px;float:right;'></div>";
	}?>
	</div>
	<?}?>
	
	<?if($count_img){?><div style="margin-top:20px;"><a href="img-host.php?action=del_complete" class="textarea" onclick="show_confirm_head(this);return false;">Alle Bilder auf einmal löschen</a></div><?}?>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
	
<?php
x264_footer();
?>