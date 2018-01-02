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
require_once(dirname(__FILE__) . "/include/xml.class.php");
dbconn();
loggedinorreturn();

function get_rss_data($URL){
	if (!preg_match("/http\:\/\/(([\w\.\-]+)(\:(.+?))?@)?([\w\.\-]+)\:?(\d*)(\/?\S*)/i", $URL, $match)) return false;
	$fhandle = @fsockopen($match[5], ($match[6] > 0?$match[6]:80), $errno, $errstr, 2);
  	//$fhandle = fsockopen($match[5], ($match[6] > 0?$match[6]:80), $errno, $errstr, 2);

  	if (!$fhandle){
    		return false;
  	}else{
    		$request = "GET " . ($match[7] <> ""?$match[7]:"/") . " HTTP/1.0\r\n";
    		$request .= "Host: " . $match[5] . "\r\n";
    		if ($match[2] != ""){
      			$authstring = base64_encode($match[2] . ":" . $match[4]);
      			$request .= "Authorization: Basic " . $authstring . "\r\n";
    		}
    		$request .= "Connection: close\r\nUser-Agent: Mozilla/5.0 (compatible;)\r\n\r\n";

    		fputs ($fhandle, $request);

    		$retr = "";
    		while (!feof($fhandle)){
      			$retr .= fgets($fhandle, 128);
    		}

    		fclose($fhandle);

    		$pos = strpos($retr, "\r\n\r\n");
    		$header = substr($retr, 0, $pos - 1);
    		$data = substr($retr, $pos + 4);
    		return array("header" => $header, "data" => $data);
  	}
}

function parse($data){
  	$ret = array();
  	$ret['name'] = $data[0]['children'][0]['children'][0]['tagData'];
  	$ret['data'] = array();
  
  	for($n = 7; $n < 17; $n++){
    		$line = array();
    		for($a = 0; $a < 7; $a++){
      			$name = $data[0]['children'][0]['children'][$n]['children'][$a]['name'];
      			$line[$name] = $data[0]['children'][0]['children'][$n]['children'][$a]['tagData'];
      			if (!$line[$name]){
        			$line[$name] = $data[0]['children'][0]['children'][$n]['children'][$a]['attrs']['URL'];
      			}
      			$line[$name] = str_replace(array("ö", "ä", "ü", "ß", "Ö", "Ä", "Ü"),array("&ouml;", "&auml;", "&uuml;", "&szlig;", "&Ouml;", "&Auml;", "&Uuml;"), $line[$name]);
    		}
    		$ret['data'][] = $line;
  	}
  	return $ret;
}

x264_header("Kino News");

$url = "http://www.cinema.de/kino/neu-im-kino/rss.xml";
$res = get_rss_data($url);

if ($res){
  	$XMLParser = new xml2Array();
  	$data      = parse($XMLParser -> parse($res["data"]));
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-user'></i> Kino News
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	
?>
                    <table class="table table-bordered table-striped table-condensed">
                        <tbody>	
		<tr><td><?=$data['name'];?></td></tr>
		<?
			foreach($data['data'] as $line){
		?>
		<tr><td><?=$line['TITLE'];?></div><div class='x264_tfile_add_inc'><img src="<?=$line['ENCLOSURE'];?>" style="width:120px;height:80px;" alt="<?=$line['TITLE'];?>" /></td></tr>	
		<tr><td>Kinostart:</div> <div class='x264_tfile_add_inc'><?=$line['PUBDATE'];?></td></tr>
		<tr><td>Beschreibung:</div> <div class='x264_tfile_add_inc'><?=$line['DESCRIPTION'];?></td></tr>
		<tr><td>Link:</div> <div class='x264_tfile_add_inc'><a href="<?=$line['LINK'];?>"><?=$line['LINK'];?></a></td></tr>
		<?}?>		

<?
print"
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
}else{
	stderr("Fehler","Service zur Zeit nicht verfügbar");
}
x264_footer();
?>