<?php
// ************************************************************************************//
// * D€ Source 2017
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 1.7
// * 
// * Copyright (c) 2017 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************// 
function define_user_class()
{
	$sql = "SELECT * FROM userclass ORDER BY class ASC";
	$res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);

	while ($arr = mysql_fetch_array($res))
	{
		$klasse = "UC_" . $arr["name"];
		define($klasse, $arr["class"]);
	}
}

function user_colors()
{
	$x   = "";
	$sql = "SELECT name, color FROM userclass ORDER BY class ASC";
	$res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);

	while ($arr = mysql_fetch_array($res))
		$x .= ".uc" . strtolower(str_replace("_", "", $arr["name"])) . " { color: " . $arr["color"] . " }\n";

	return $x;
}

// PM special folder IDs
define ("PM_FOLDERID_INBOX", "-1");
define ("PM_FOLDERID_OUTBOX", "-2");
define ("PM_FOLDERID_SYSTEM", "-3");
define ("PM_FOLDERID_MOD", "-4");

 
function get_row_count($table, $suffix = "")
{
    if ($suffix)
        $suffix = " $suffix";
    ($r = mysql_query("SELECT COUNT(*) FROM $table$suffix")) or die(mysql_error());
    ($a = mysql_fetch_row($r)) or die(mysql_error());
    return $a[0];
}

function stdmsg($heading, $text)
{
echo("
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>".$heading."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                                  ".$text."
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>");
}



function stderr($heading, $text)
{
	x264_header();
    stdmsg($heading, $text);
    x264_footer();
    die;
}

function stderr_nologged($heading, $text)
{
    x264_header_nologged();
    stdmsg($heading, $text);
    x264_footer_nologged();
    die;
}

function sqlerr($file = '', $line = '')
{
    print("<table border=0 bgcolor=blue align=left cellspacing=0 cellpadding=10 style='background: blue'>" . "<tr><td class=embedded><font color=white><h1>SQL Error</h1>\n" . "<b>" . mysql_error() . ($file != '' && $line != '' ? "<p>in $file, line $line</p>" : "") . "</b></font></td></tr></table>");
    die;
}
// Returns the current time in GMT in MySQL compatible format.
function get_date_time($timestamp = 0)
{
    if ($timestamp)
        return date("Y-m-d H:i:s", $timestamp);
    else
        return date("Y-m-d H:i:s");
}

function encodehtml($s, $linebreaks = true)
{
    $s = str_replace("<", "&lt;", str_replace("&", "&amp;", $s));
    if ($linebreaks)
        $s = nl2br($s);
    return $s;
}

function get_dt_num()
{
    return date("YmdHis");
}

function safename($fname)
{
    $_trSpec = array(
        '[' => '-', 
        'TN' => 'PC', 
        ']' => '-',
        'PC' => 'P-C', 
        'S' => 'S', 
        'Ü' => 'U',
        'ç' => 'c', 
        'g' => 'g', 
        'i' => 'i',
        'i' => 'i',
        'ö' => 'o', 
        's' => 's', 
        'ü' => 'u',
    );
    $enChars = array_values($_trSpec);
    $trChars = array_keys($_trSpec);
    $fname = str_replace($trChars, $enChars, $fname); 
    $fname=preg_replace("@[^A-Za-z0-9\-_.\/]+@i","-",$fname);
    $fname=strtolower($fname);
    return $fname;
}

// keep links as text

	function check_ip($ip){
		if($ip == ""){return false;}
		$ip_preg = preg_match("/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])" .
		"(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/", $ip );

		if($ip_preg && $ip != "127.0.0.1"){return true;}else{return false;}		 
	}
 
	function DNSLookup($ip = "", $mini = FALSE){
	global $BASEURL;

	if (!check_ip($ip)) return "FEHLER! - ung&uuml;ltige IP-Adresse";

	$format = ($mini == FALSE ? FALSE : TRUE);

	$inhalt = file_get_contents("http://www.dnsstuff.com/tools/ipall/?ip=" . $ip);

		if($format){
			$response = substr($inhalt, strpos($inhalt, "source):") + 8, strlen($inhalt));
			$response = substr($response, 0, strpos($response, "Country") - 1);
			$response = trim($response) . " ";
		}else{
			$response = substr($inhalt, strpos($inhalt, "<code>") + 6, strlen($inhalt));
			$response = substr($response, 0, strpos($response, "<a href="));
		}

		$response .= "<a href=\"" . $BASEURL . "/whois.php?ip=" . $ip . "\">" . $ip . "</a>";

		return "<pre style=\"text-align: left;\">" . $response . "</pre>";
	} 

function format_urls($s)
{
    return preg_replace("/(\A|[^=\]'\"a-zA-Z0-9])((http|https|ftp|https|ftps|irc|html|php):\/\/[^()<>\s]+)/i",
        "\\1<a href=\"redir.php?url=\\2\" target=\"_blank\">\\2</a>", $s);
}

// Finds last occurrence of needle in haystack
// in PHP5 use strripos() instead of this
function _strlastpos ($haystack, $needle, $offset = 0)
{
    $addLen = strlen ($needle);
    $endPos = $offset - $addLen;
    while (true) {
        if (($newPos = strpos ($haystack, $needle, $endPos + $addLen)) === false) break;
        $endPos = $newPos;
    }
    return ($endPos >= 0) ? $endPos : false;
}

function format_quotes($s)
{
    while ($old_s != $s) {
        $old_s = $s;
        // [quote]Text[/quote]
        $s = preg_replace("/\[quote\](.+?)\[\/quote\]/is",
            "<p><b>Zitat:</b></p><table class=\"tableinborder\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\"><tr><td class=\"inposttable\">\\1</td></tr></table><br>", $s);
        // [quote=Author]Text[/quote]
        $s = preg_replace("/\[quote=(.+?)\](.+?)\[\/quote\]/is",
            "<p><b>\\1 hat geschrieben:</b></p><table class=\"tableinborder\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\"><tr><td class=\"inposttable\">\\2</td></tr></table><br>", $s);
    }

    return $s;
}

function auto_post($subject = "Error - Subject Missing",$body = "Error - No Body") // Function to use the special system message forum
{
	$forumid = 9;  // Remember to change this if the forum is recreated for some reason.

	mysql_query( "INSERT INTO topics (userid, forumid, subject) VALUES(0, $forumid, $subject)") or sqlerr(__FILE__, __LINE__);

	$topicid = @mysql_insert_id();
	$added = "'" . get_date_time() . "'";

	mysql_query( "INSERT INTO posts (topicid, userid, added, body) " .
               "VALUES($topicid, 0, $added, $body)") or sqlerr(__FILE__, __LINE__);

	$res = mysql_query("SELECT id FROM posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
	$arr = mysql_fetch_row($res) or die("No post found");
	$postid = $arr[0];
	mysql_query("UPDATE topics SET lastpost=$postid WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
}

function auto_report($reason = "Error - No Body", $userid ) // Function to use the special system message forum
{
	global $CURUSER;

	$added = "'" . get_date_time() . "'";
	mysql_query("INSERT into report (reporter,reportid,typ,reason,tid) VALUES ('0','$userid', 'user', '$reason', $added)") or sqlerr();

}

function parser_rain($text,$options)
{
	$c = explode(" ", $options);
	if (is_array($c))
	foreach ($c as $g)
	{
		if (preg_match("/([#][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])/i",$g))
		$colorcode = substr($g,1,6);
    elseif (preg_match("/max=([0-9]+)/i",$g))
		$charlimit = preg_replace("/max=([0-9]+)/i","\\1",$g);
	}
	if (preg_match("/rev/i",$options))
	$reverse   = 1;

	return '<script type="text/javascript"> rainbowt("'.$text.'","'.$colorcode.'","'.$charlimit.'","'.$reverse.'");</script>';
}

function parser_block($text)
{
	$allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

	for($i=0; $i < strlen($text); $i++)
	{
		$letter = substr($text, $i, 1);

		if (strpos($allowedchars, $letter) === false) $l="blank";
		elseif (strtolower($letter) == $letter) $l = $letter;
		else $l = strtolower($letter)."g";

		$ret .= "<img src='/pic/letter/".$l.".gif' border='0' alt='".$letter."'>";
	}
	return $ret;
}

function parser_tvdb($tvdb)
{
	global $db;
  
	if ($tvdb == "System")
	{
		$class = UC_SYSOP;
	}
  
	return "<a href='redir.php?url=https://www.fernsehserien.de/suche/".$tvdb."' target='_blank'><b>".$tvdb."</b></a>";
}

function parser_radio_wunsch($parser_radio_wunsch)
{
	global $db;
  
	if ($parser_radio_wunsch == "System")
	{
		$class = UC_SYSOP;
	}
  
	return "Ich wünsche mir folgenden Musik Titel im Radio: <b>".$parser_radio_wunsch."</b>";
}

function is_image($src) {

    if(@getimagesize($src) !== false) {
        return(1);
    } else {
        return(0);
    }

}

function smart_wordwrap($string, $width = 75, $break = "\n") {
    // split on problem words over the line length
    $pattern = sprintf('/([^ ]{%d,})/', $width);
    $output = '';
    $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    foreach ($words as $word) {
        if (false !== strpos($word, ' ')) {
            // normal behaviour, rebuild the string
            $output .= $word;
        } else {
            // work out how many characters would be on the current line
            $wrapped = explode($break, wordwrap($output, $width, $break));
            $count = $width - (strlen(end($wrapped)) % $width);

            // fill the current line and add a break
            $output .= substr($word, 0, $count) . $break;

            // wrap any remaining characters from the problem word
            $output .= wordwrap(substr($word, $count), $width, $break, true);
        }
    }

    // wrap the final output
    return wordwrap($output, $width, $break);
}

function parser_nick($nick)
{
	global $db;
  
	if ($nick == "System")
	{
		$class = UC_SYSOP;
	}
	else
	{
		$class = $db -> querySingleItem("SELECT class FROM users WHERE username = ".sqlesc($nick));
	}
  
	return "<font class='".get_class_color($class)."'><b>".$nick."</b></font>";
}

function get_pretime($UploadDate, $DPreTime) {

      if ($DPreTime == 0)
        return;

   $st = $UploadDate - ($DPreTime + (date('I', $UploadDate) == 1 ? 60 * 60 * 2 : 60 * 60));
   $mins = floor($st / 60);
   $hours = floor($mins / 60);
   $days = floor($hours / 24);
   $week = floor($days / 7);
   $month = floor($week / 4);

   $week_elapsed = floor(($st - ($month * 4 * 7 * 24 * 60 * 60)) / (7 * 24 * 60 * 60));
   $days_elapsed = floor(($st - ($week * 7 * 24 * 60 * 60)) / (24 * 60 * 60));
   $hours_elapsed = floor(($st - ($days * 24 * 60 * 60)) / (60 * 60));
   $mins_elapsed = floor(($st - ($hours * 60 * 60)) / 60);
   $secs_elapsed = floor($st - $mins * 60);

   echo '<div class="desource_browse_torrent_table_inp_pretime">&nbsp;Pre Time: ';

   $pretime = "";

   if($secs_elapsed > 0)
      $pretime = "$secs_elapsed Sekunden " .$pretime;
   if($mins_elapsed > 0)
      $pretime = "$mins_elapsed Minuten, " .$pretime;
   if($hours_elapsed > 0)
      $pretime = "$hours_elapsed Stunden, " .$pretime;
   if($days_elapsed > 0)
      $pretime = "$days_elapsed Tage, " .$pretime;
   if($week_elapsed > 0)
      $pretime = "$week_elapsed Wochen, " .$pretime;
   if($month > 0)
      $pretime = "$month Months, " .$pretime;

    return $pretime . ' nach pre hochgeladen</div>';

}

function get_pretime_2($UploadDate, $DPreTime) {

if ($DPreTime == 0)
{
return;
}
else
{
print"Keine Pretime gefunden";
}

   $st = $UploadDate - ($DPreTime + (date('I', $UploadDate) == 1 ? 60 * 60 * 2 : 60 * 60));
   $mins = floor($st / 60);
   $hours = floor($mins / 60);
   $days = floor($hours / 24);
   $week = floor($days / 7);
   $month = floor($week / 4);

   $week_elapsed = floor(($st - ($month * 4 * 7 * 24 * 60 * 60)) / (7 * 24 * 60 * 60));
   $days_elapsed = floor(($st - ($week * 7 * 24 * 60 * 60)) / (24 * 60 * 60));
   $hours_elapsed = floor(($st - ($days * 24 * 60 * 60)) / (60 * 60));
   $mins_elapsed = floor(($st - ($hours * 60 * 60)) / 60);
   $secs_elapsed = floor($st - $mins * 60);


   $pretime = "";

   if($secs_elapsed > 0)
      $pretime = "$secs_elapsed Sekunden " .$pretime;
   if($mins_elapsed > 0)
      $pretime = "$mins_elapsed Minuten, " .$pretime;
   if($hours_elapsed > 0)
      $pretime = "$hours_elapsed Stunden, " .$pretime;
   if($days_elapsed > 0)
      $pretime = "$days_elapsed Tage, " .$pretime;
   if($week_elapsed > 0)
      $pretime = "$week_elapsed Wochen, " .$pretime;
   if($month > 0)
      $pretime = "$month Months, " .$pretime;

    return $pretime . ' nach pre hochgeladen';

}

function handleimage($com){
	$pic_pfad = trim($com);	
	$pos = strpos($pic_pfad, $GLOBALS["BASEURL"]);
	if ($pos !== false){
	$pic_pfad = $pic_pfad;
	}else{
	$pic_pfad = "pic/no_fremd.png";
	}
	$go_picly = "<img src='".$pic_pfad."' alt='' style='max-width:550px;' class='mx-auto d-block'/>";		
	return $go_picly;
}

function check_imageurl($url, $lightbox=true, $output = "")
{
  $allowed_domains= array(
    "http://" . $GLOBALS["DOMAIN"] . "",
    "https://" . $GLOBALS["DOMAIN"] . ""
  );
  
  $success = false;
  
  foreach ($allowed_domains as $domain)
  {
    $checkstring = substr($url,0,strlen($domain));
    
    if ($domain == $checkstring)
      $success = true;
  }
  
  if ($output == "boolean")
    return $success;

  if (!$success)
    $url = "/getpic.php?url=".urlencode($url);
  
  if ($lightbox)
  {
    return "<img src=\"".$url."\" style=\"max-width: 350px;\" border=\"0\"></div>";
  }
  else
  {
    return "<img src=\"".$url."\" alt=\"\" border=\"0\" class='mx-auto d-block' style=\"max-width:350px;\">";
  }
}

function check_tactics($url, $lightbox=false, $output = "")
{
 $allowed_domains= array(
    "http://" . $GLOBALS["DOMAIN"] . "",
    "https://" . $GLOBALS["DOMAIN"] . ""
  );
  
  $success = false;
  
  foreach ($allowed_domains as $domain)
  {
    $checkstring = substr($url,0,strlen($domain));
    
    if ($domain == $checkstring)
      $success = true;
  }
  
  if ($output == "boolean")
    return $success;

  if (!$success)
    $url = "/getpic.php?url=".urlencode($url);
  
  if ($lightbox)
  {
    return "<img src='".$url."' style='max-width:750px;' class='mx-auto d-block'></a>";
  }
  else
  {
    return "<img src='".$url."' style='max-width:750px;' class='mx-auto d-block'></a>";
  }
}

function format_comment($text, $strip_html = true)
{
    global $smilies, $privatesmilies;

	#### IMG Check by TITO #####
	$text_check = strtolower($text);
	$suche = '[img]';
	$var_check_eins = strchr ( $text_check, $suche );
	$suche_zwei = '.php';
	$var_check_zwei = strchr( $var_check_eins, $suche_zwei );
	if($var_check_zwei != ''){
	$text = '[img]'.$GLOBALS["DEFAULTBASEURL"].'/pic/secure_system.png[/img]';
	}else{
	$text = $text;
	}
	
	if (preg_match('/(<[^>].*?>)/e', $text)){$text = '';}
	
	############################
    $s = stripslashes($text); 
    // This fixes the extraneous ;) smilies problem. When there was an html escaped
    // char before a closing bracket - like >), "), ... - this would be encoded
    // to &xxx;), hence all the extra smilies. I created a new :wink: label, removed
    // the ;) one, and replace all genuine ;) by :wink: before escaping the body.
    // (What took us so long? :blush:)- wyz

    $s = explode("[eof]",$s);
    $s = $s['0'];
    $s = str_replace("\\r\\n", "[br]", $s);
    $s = str_replace("\n", "[br]", $s);
    $s = str_replace(array("\\r\\n", "\\n\\n"),"[br]",$s);
//    $s = str_replace("\\r\\n","[br]", $s);

//hierneu eingefügt-----------------
    $s = str_replace("cleanup_acp.php", "<img src=pic/secure_system.png alt=pic>", $s);
    $s = str_replace("bittorrent.php", "<img src=pic/secure_system.png alt=pic>", $s);
    $s = str_replace("logout.php", "<img src=pic/secure_system.png alt=pic>", $s);
    $s = str_replace("global.php", "<img src=pic/secure_system.png alt=pic>", $s);
    $s = str_replace("shoutbox.php", "<img src=pic/secure_system.png alt=pic>", $s);
    $s = str_replace("ajax_tfiles.php", "<img src=pic/secure_system.png alt=pic>", $s);
    $s = str_replace("change_to_users.php", "<img src=pic/secure_system.png alt=pic>", $s);
    $s = str_replace("change_to_users_staff_done_acp.php", "<img src=pic/secure_system.png alt=pic>", $s);
    $s = str_replace("add_user.php", "<img src=pic/secure_system.png alt=pic>", $s);
    $s = str_replace("staff_acp.php", "<img src=pic/secure_system.png alt=pic>", $s);
    $s = str_replace("sessioncheck.php", "<img src=pic/secure_system.png alt=pic>", $s);
    $s = str_replace("nosession.php", "<img src=pic/secure_system.png alt=pic>", $s);


    $s = stripslashes($s);
    // This fixes the extraneous ;) smilies problem. When there was an html escaped
    // char before a closing bracket - like >), "), ... - this would be encoded
    // to &xxx;), hence all the extra smilies. I created a new :wink: label, removed
    // the ;) one, and replace all genuine ;) by :wink: before escaping the body.
    // (What took us so long? :blush:)- wyz

    $s = str_replace(";)", ":wink:", $s);
    $s = str_replace(":)", ":-)", $s);

    if ($strip_html)
        $s = htmlspecialchars($s);

    $s = preg_replace("/\[nick=((\s|.)+?)\]/ie", "parser_nick('\\1')", $s); 

    $s = preg_replace("/\[tvdb=((\s|.)+?)\]/ie", "parser_tvdb('\\1')", $s); 

    $s = preg_replace("/\[radiowunsch=((\s|.)+?)\]/ie", "parser_radio_wunsch('\\1')", $s);	
	
     // [rain]Text[/rain] by Solstice
    $s = preg_replace("/\[rain=((\s|.|[ ])+?)\]((\s|.)+)\[\/rain\]/ie", "parser_rain('\\3','\\1')", $s);
    $s = preg_replace("/\[rain\]((\s|.)+?)\[\/rain\]/ie", "parser_rain('\\1',' ')", $s);

    $s = preg_replace("/\[blockcode\]((\s|.)+?)\[\/blockcode\]/ie", "parser_block('\\1')", $s);

    $s = preg_replace("/\[br\]/","<br>", $s);
    $s = preg_replace("/\[sttts=([^()<>\s]+?)\]((\s|.)+?)\[\/sttts\]/i","\\2", $s);
    $s = preg_replace("/\[sttts\]([^()<>\s]+?)\[\/sttts\]/i","\\1", $s);
    // [class=ucsysop]Text[/class]
    $s = preg_replace("/\[class=([a-zA-Z]+)\]((\s|.)+?)\[\/class\]/i","<font class=\"\\1\">\\2</font>", $s);
     // [center]Centered text[/center]
    $s = preg_replace("/\[center\]((\s|.)+?)\[\/center\]/i", "<center>\\1</center>", $s);
    // [list]List[/list]
    $s = preg_replace("/\[list\]((\s|.)+?)\[\/list\]/", "<ul>\\1</ul>", $s);
    // [list=disc|circle|square]List[/list]
    $s = preg_replace("/\[list=(disc|circle|square)\]((\s|.)+?)\[\/list\]/", "<ul type=\"\\1\">\\2</ul>", $s);
    // [list=1|a|A|i|I]List[/list]
    $s = preg_replace("/\[list=(1|a|A|i|I)\]((\s|.)+?)\[\/list\]/", "<ol type=\"\\1\">\\2</ol>", $s);
    // [*]
    $s = preg_replace("/\[\*\]/", "<li>", $s);
    // [b]Bold[/b]
    $s = preg_replace("/\[b\]((\s|.)+?)\[\/b\]/", "<b>\\1</b>", $s);
    // [i]Italic[/i]
    $s = preg_replace("/\[i\]((\s|.)+?)\[\/i\]/", "<i>\\1</i>", $s);
    // [u]Underline[/u]
    $s = preg_replace("/\[u\]((\s|.)+?)\[\/u\]/", "<u>\\1</u>", $s);
    // [u]Underline[/u]
    $s = preg_replace("/\[u\]((\s|.)+?)\[\/u\]/i", "<u>\\1</u>", $s);

    $s = preg_replace("/\[imghost=((\s|.)+?)\]/i", "<img src=\"_x264_/bitbucket/\\1\" alt=\"\" style=\"max-width:700px;\" border=\"0\"></a>", $s);  
    
// [img]http://www/image.gif[/img]
    $s = preg_replace("/\[img\](https:\/\/[^\s'\"<>]+(\.(jpg|gif|png)))\[\/img\]/ie", "check_tactics('\\1')", $s);
// [img=http://www/image.gif]
    $s = preg_replace("/\[img=([^\s'\"<>]+?)\]/ie", "check_tactics('\\1')", $s);
    // [color=blue]Text[/color]
    $s = preg_replace("/\[color=([a-zA-Z]+)\]((\s|.)+?)\[\/color\]/i",
        "<font color=\\1>\\2</font>", $s);

    $s = preg_replace("/\[color=(#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])\]((\s|.)+?)\[\/color\]/i", "<font color=\\1>\\2</font>", $s);
    $s = preg_replace("/\[lightbox\]([^\s'\"<>]+?)\[\/lightbox\]/ie", "check_imageurl('\\1',true)", $s);
// links will show as text with info
if (get_user_class() < UC_ADMINISTRATOR)
{
// [url=http://www.example.com]Text[/url]
    $s = preg_replace("/(\A|[^=\]'\"a-zA-Z0-9])((ftp|ftps|irc|swf|html|php):\/\/[^()<>\s]+)/i",
        "<font size=\"3\" style=\"font-family:'Times New Roman',Times,serif;'\" color=\"red\" ><b>Fehler:</b></font><font size=\"3\" style=\"font-family:'Times New Roman',Times,serif;'\" color=\"green\" ><b> Wir erlauben nur generierte Links.</b></font>", $s);
// [url]http://www.example.com[/url]
    $s = preg_replace("/\[url\]([^()<>\s]+?)\[\/url\]/i",
        "<font color=red size=\"2\"><b>Security Tactics System:</b></font><font color=green><b> We've saved your illegal or inappropriate access and directors were informed!</b></font>", $s);
}
else
{
   // [url=http://www.example.com]Text[/url]
    $s = preg_replace("/(\A|[^=\]'\"a-zA-Z0-9])((ftp|ftps|irc|swf|html|php):\/\/[^()<>\s]+)/i",
        "<font color=red><b>Achtung verbotener Link</b></font>: \\1 Text: \\2", $s);
    // [url]http://www.example.com[/url]
    $s = preg_replace("/\[url\]([^()<>\s]+?)\[\/url\]/i",
        "<font color=red>URL</font>: \\1", $s);
}
/*
// here is original UBB code setting
    // [url=http://www.example.com]Text[/url]
    $s = preg_replace("/\[url=([^()<>\s]+?)\]((\s|.)+?)\[\/url\]/i",
        "<a href=\"\\1\" target=\"\\_blank\">\\2</a>", $s);
    // [url]http://www.example.com[/url]
    $s = preg_replace("/\[url\]([^()<>\s]+?)\[\/url\]/i",
        "<a href=\"\\1\">\\1</a>", $s);
*/
    // [size=4]Text[/size]
    $s = preg_replace("/\[size=([1-7])\]((\s|.)+?)\[\/size\]/i",
        "<font size=\\1>\\2</font>", $s);
    // [font=Arial]Text[/font]
    $s = preg_replace("/\[font=([a-zA-Z ,]+)\]((\s|.)+?)\[\/font\]/i",
        "<font face=\"\\1\">\\2</font>", $s);
   // Quotes
    $s = format_quotes($s);
    // URLs
    $s = format_urls($s);
    // $s = format_local_urls($s);
    // Linebreaks
    //$s = nl2br($s);
    // [pre]Preformatted[/pre]
    $s = preg_replace("/\[pre\]((\s|.)+?)\[\/pre\]/i", "<tt><nobr>\\1</nobr></tt>", $s);
    // [nfo]NFO-preformatted[/nfo]
    $s = preg_replace("/\[nfo\]((\s|.)+?)\[\/nfo\]/i", "<tt><nobr><font face=\"MS Linedraw\" size=\"2\" style=\"font-size: 10pt; line-height: 10pt\">\\1</font></nobr></tt>", $s);
    // Maintain spacing
    $s = str_replace("  ", " &nbsp;", $s);

    reset($smilies);
    while (list($code, $url) = each($smilies))
    $s = str_replace($code, "<img src=\"".$GLOBALS['DEFAULTBASEURL']."/pic/smilies/$url\" border=\"0\" alt=\"" . htmlspecialchars($code) . "\">", $s);

    $s = str_replace(array("  ", "&amp;acute;", "&amp;quot;","&amp;lt;","&amp;gt;", "Ä", "Ö", "Ü", "ä", "ö", "ü", "ß", "&amp;Auml;", "&amp;Ouml;", "&amp;Uuml;", "&amp;auml;", "&amp;ouml;", "&amp;uuml;", "&amp;szlig;", "&amp;amp;"),
                     array(" &nbsp;", "&acute;", "&quot;","&lt;","&gt;", "&Auml;", "&Ouml;", "&Uuml;", "&auml;", "&ouml;", "&uuml;", "&szlig;", "&Auml;", "&Ouml;", "&Uuml;", "&auml;", "&ouml;", "&uuml;", "&szlig;", "&amp;"),
                     $s);
    $s = str_replace(array("Â´", "Ã¼", "Â°", "Ã¶", "Ã¤", "ÃŸ", "> <"),
                     array("&lsquo;", "&uuml;", "&quot;", "&ouml;", "&auml;", "&szlig;", ">&nbsp;<"),
                     $s);
					 					 
    return $s;
}

function get_user_class()
{
    global $CURUSER;
    return $CURUSER["class"];
}

function get_user_class_name($class = 0)
{
   $result = "";

   $sql = "SELECT classname FROM userclass WHERE class = " . intval($class) . " LIMIT 1";
   $res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
   if ($res)
   {
     $arr    = mysql_fetch_array($res);
     $result = $arr["classname"];
   }

   return $result;
}


function is_valid_user_class($class)
{
   $sql = "SELECT MIN(class) AS min, MAX(class) AS max FROM userclass";
   $res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
   $arr = mysql_fetch_array($res);

   return is_numeric($class) && floor($class) == $class && $class >= $arr["min"] && $class <= $arr["max"];
}

function is_valid_id($id)
{
    return is_numeric($id) && ($id > 0) && (floor($id) == $id);
}

function delete_acct($id)
{
    // Mailadresse holen
    $userinfo = @mysql_fetch_assoc(@mysql_query("SELECT `email`,`username`,`status` FROM `users` WHERE `id`=$id"));
    if ($userinfo["email"] && $userinfo["status"] == "confirmed") {
        $mailbody = "Dein Account auf ".$GLOBALS["SITENAME"]." wurde gelöscht. Dies ist entweder passiert,
weil Du Dich längere Zeit nicht mehr eingeloggt hast, oder Dein Account von einem
Administrator deaktiviert wurde.

Diese E-Mail dient dazu, Dich darüber zu informieren, dass Du diesen Account nun nicht
mehr nutzen kannst. Bitte antworte nicht auf diese E-Mail!";
        mail("\"" . $userinfo["username"] . "\" <" . $userinfo["email"] . ">", "Account gelöscht auf ".$GLOBALS["SITENAME"], $mailbody);
    }

    $res = mysql_query("DELETE FROM `users` WHERE `id`=$id") or sqlerr();
    // Verbliebene Wartezeitaufhebungen löschen
    mysql_query("DELETE FROM `nowait` WHERE `user_id`=$id");
    // PM-Ordner löschen
    mysql_query("DELETE FROM `pmfolders` WHERE `owner`=$id");
    // Torrent-Traffic
    mysql_query("DELETE FROM `traffic` WHERE `userid`=$id");
    // Modcomments
    mysql_query("DELETE FROM `modcomments` WHERE `userid`=$id");

    // Nachrichten löschen
    $res = mysql_query("SELECT `id` FROM `messages` WHERE `sender`=$id OR `receiver`=$id");
    $msgids = array();
    while ($msg = mysql_fetch_assoc($res))
        $msgids[] = $msg["id"];
    $msgids = implode(",", $msgids);
    deletePersonalMessages($msgids, $id);

    write_log("accdeleted", "Der Benutzer '".htmlspecialchars($userinfo["username"])."' mit der ID $id wurde aus der Datenbank gelöscht.");
}

function textbbcode($form,$text,$content="") {
    global $BASEURL, $privatesmilies;

    $button = $BASEURL . "/" . $GLOBALS["PIC_BASE_URL"] . "editor";
    $smilie = $BASEURL . "/" . $GLOBALS["PIC_BASE_URL"] . "smilies";

    $liste = "var smilieliste = [ ";
    foreach($privatesmilies AS $code => $url)
    {
        $liste .= "{ \"bild\" : \"" . $url . "\", \"code\" : \"" . $code . "\" }, ";
    }
    $liste = substr($liste, 0, -2) . " ];";

    print("\n<div style=\"text-align: left; width: 650px;\">\n" .
          "  <script type=\"text/javascript\" src=\"".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/js/editor.js\"></script>\n" .
          "  <script type=\"text/javascript\">edToolbar('" . $text . "','" . $button . "','true');</script>\n" .
          "  <textarea name=\"" . $text . "\" id=\"" . $text . "\" rows=\"16\" cols=\"100\" class=\"btn-primary fc-today-button\">" . $content . "</textarea>\n" .
          "  <script type=\"text/javascript\">\n" .
          "    " . $liste . "\n" .
          "    edSmilye('" . $text . "','" . $smilie . "','3');\n" .
          "  </script>\n" .
          "</div>\n" .
          "<br style=\"clear: left;\" />");
}

function textbbcode_none_style($form,$text,$content="") {
    global $BASEURL, $privatesmilies;

    $button = $BASEURL . "/" . $GLOBALS["PIC_BASE_URL"] . "editor";
    $smilie = $BASEURL . "/" . $GLOBALS["PIC_BASE_URL"] . "smilies";

    $liste = "var smilieliste = [ ";
    foreach($privatesmilies AS $code => $url)
    {
        $liste .= "{ \"bild\" : \"" . $url . "\", \"code\" : \"" . $code . "\" }, ";
    }
    $liste = substr($liste, 0, -2) . " ];";

    print("\n<div style=\"text-align: left; width: 650px;\">\n" .
          "  <script type=\"text/javascript\" src=\"".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/js/editor.js\"></script>\n" .
          "  <script type=\"text/javascript\">edToolbar('" . $text . "','" . $button . "','true');</script>\n" .
          "  <textarea name=\"" . $text . "\" id=\"" . $text . "\" style=\"float: left;\" rows=\"16\" cols=\"100\">" . $content . "</textarea>\n" .
          "  <script type=\"text/javascript\">\n" .
          "    " . $liste . "\n" .
          "    edSmilye('" . $text . "','" . $smilie . "','3');\n" .
          "  </script>\n" .
          "</div>\n" .
          "<br style=\"clear: left;\" />");
}

function textbbcode_edit($text, $aktive = TRUE) {
    global $BASEURL, $privatesmilies;

    $button = $BASEURL . "/" . $GLOBALS["PIC_BASE_URL"] . "editor";
    $smilie = $BASEURL . "/" . $GLOBALS["PIC_BASE_URL"] . "smilies";

    $liste = "var smilieliste = [ ";
    foreach($privatesmilies AS $code => $url)
    {
        $liste .= "{ \"bild\" : \"" . $url . "\", \"code\" : \"" . $code . "\" }, ";
    }
    $liste = substr($liste, 0, -2) . " ];";

    print("\n<div style=\"text-align: left; \">\n" .
          "  <script type=\"text/javascript\" src=\"".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/js/editor.js\"></script>\n" .
          "  <script type=\"text/javascript\">edToolbar('" . $text . "','" . $button . "','true');</script>\n" .
          "  <textarea name=\"" . $text . "\" id=\"" . $text . "\" rows=\"10\" cols=\"70\" class=\"btn btn-flat btn-primary fc-today-button\">" . $content . "</textarea>\n" .
          "  <script type=\"text/javascript\">\n" .
          "    " . $liste . "\n" .
          "    edSmilye('" . $text . "','" . $smilie . "','3');\n" .
          "  </script>\n" .
          "</div>");
}

// -------- Begins a main frame
function begin_main_frame()
{
    print("<table class=\"main\" width=\"750\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">" . "<tr><td class=\"embedded\">\n");
}
// -------- Ends a main frame
function end_main_frame()
{
    print("</td></tr></table>\n");
}

function begin_frame($caption = "", $center = false, $width = "100%")
{
  if ($center)
    $tdextra .= " style=\"text-align: center\"";

  print "
    <table cellpadding='4' cellspacing='1' border='0' style='width:".$width."' class='tableinborder'>
      <tr>
        <td class='tabletitle' colspan='10' width='100%' style='text-align: center'><b>".$caption."</b></td>
      </tr>
      <tr>
        <td width='100%' class='tablea'".$tdextra.">";
}

function attach_frame($padding = 10)
{
    print("</td></tr><tr><td class=\"tablea\" style=\"border-top: 0px\">\n");
}

function end_frame()
{
    print("</td></tr></table><br>\n");
}

function begin_table($fullwidth = false, $padding = 4)
{
    if ($fullwidth)
        $width = " width=\"100%\"";
    print("<table class=\"tableinborder\" $width border=\"0\" cellspacing=\"1\" cellpadding=\"$padding\">\n");
}

function end_table()
{
    print("</table><br>\n");
}
// -------- Inserts a smilies frame
// (move to globals)

function insert_smilies_frame($breite_tabelle = 800, $pro_zeile = 5, $private = "yes")
{
   print("<table summary=\"\" style=\"width:" . $breite_tabelle . "px;\" cellpadding=\"5\" cellspacing=\"1\" align=\"center\" border=\"0\" class=\"tableinborder\">\n");

   $sql = "SELECT * FROM smilies WHERE active = 'yes' " . (($private == "yes") ? "AND private = 'yes'" : "") . " ORDER BY id ASC";
   $res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);

   if (mysql_num_rows($res) > 0)
   {
     print("    <tr><td class=\"tabletitle\" colspan=\" . $pro_zeile . \"><center><b>" . mysql_num_rows($res) . "</b> " . (($private == "yes") ? "Standard-Smilieys" : "Smilieys gesamt") . "</center></td></tr>\n");
     $zeile = 0;
     while ($arr = mysql_fetch_array($res))
     {
       if ($zeile == 0) print("  <tr>\n");
 
       $pic = "pic/smilies/" . $arr["path"];
       list($width, $height, $type, $attr) = getimagesize($pic);
       print("    <td class=\"tablea\" valign=\"bottom\" width=\"100\">\n");
       print("      <center>\n");
       print("        <img src=\"" . $pic . "\" border=\"0\" title=\"" . $arr["code"] . "\" " . (($width > round($breite_tabelle/$pro_zeile)) ? "width=\"" . round($breite_tabelle/$pro_zeile) . "\"" : $attr ) . " />\n");
       print("        <br /><br />\n");
       print("        " . $arr["code"] . "\n");
       print("      </center>\n");
       print("     </td>\n");
       $zeile++;
       if ($zeile == $pro_zeile)
       {
         print("  </tr>\n");
         $zeile = 0;
       }
     }
     if (($zeile != $pro_zeile) && ($zeile != 0))
     {
        print("    <td class=\"tablea\" colspan=\"" . ($pro_zeile - $zeile) . "\">&nbsp;</td>\n");
        print("  </tr>\n");
     }
   }
   else
     print("    <tr><td class=\"tablea\"><i>keine Eintr&auml;ge gefunden</i></td></tr>\n");

   print("</table>\n");
}  

function sql_timestamp_to_unix_timestamp($s)
{
    return mktime(substr($s, 11, 2), substr($s, 14, 2), substr($s, 17, 2), substr($s, 5, 2), substr($s, 8, 2), substr($s, 0, 4));
}


function get_ratio_color($ratio)
{
    if ($ratio < 0.1) return "#ff0000";
    if ($ratio < 0.2) return "#ee0000";
    if ($ratio < 0.3) return "#dd0000";
    if ($ratio < 0.4) return "#cc0000";
    if ($ratio < 0.5) return "#bb0000";
    if ($ratio < 0.6) return "#aa0000";
    if ($ratio < 0.7) return "#990000";
    if ($ratio < 0.8) return "#880000";
    if ($ratio < 0.9) return "#770000";
    if ($ratio < 1) return "#660000";
    return "#00FF00";
}

function get_slr_color($ratio)
{
    if ($ratio < 0.025) return "#ff0000";
    if ($ratio < 0.05) return "#ee0000";
    if ($ratio < 0.075) return "#dd0000";
    if ($ratio < 0.1) return "#cc0000";
    if ($ratio < 0.125) return "#bb0000";
    if ($ratio < 0.15) return "#aa0000";
    if ($ratio < 0.175) return "#990000";
    if ($ratio < 0.2) return "#880000";
    if ($ratio < 0.225) return "#770000";
    if ($ratio < 0.25) return "#660000";
    if ($ratio < 0.275) return "#550000";
    if ($ratio < 0.3) return "#440000";
    if ($ratio < 0.325) return "#330000";
    if ($ratio < 0.35) return "#220000";
    if ($ratio < 0.375) return "#110000";
    return "#00FF00";
}

function get_class_color($class = 0)
{
   $result = "";

   $sql = "SELECT name FROM userclass WHERE class = " . intval($class) . " LIMIT 1";
   $res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
   if ($res)
   {
     $arr    = mysql_fetch_array($res);
     $result = "uc" . strtolower(str_replace("_", "", $arr["name"]));
   }

   return $result;
}

function write_log($typ, $text)
{
    $typ = sqlesc($typ);
    $text = sqlesc($text);
    $added = sqlesc(get_date_time());
    mysql_query("INSERT INTO `sitelog` (`typ`, `added`, `txt`) VALUES($typ, $added, $text)") or sqlerr(__FILE__, __LINE__);
}

function write_modcomment($uid, $moduid, $text)
{
    $text = sqlesc(stripslashes($text));
    mysql_query("INSERT INTO `modcomments` (`added`, `userid`, `moduid`, `txt`) VALUES (NOW(), $uid, $moduid, $text)");
}

function write_modcomment2($uid, $moduid, $text)
{
    $text = sqlesc(stripslashes($text));
    mysql_query("INSERT INTO `modcomments2` (`added`, `userid`, `moduid`, `txt`) VALUES (NOW(), $uid, $moduid, $text)");
}

function get_elapsed_time($ts)
{
    /* $mins = floot((gmtime() - $ts) / 60); */

    $mins = floor((time() - $ts) / 60);
    $hours = floor($mins / 60);
    $mins -= $hours * 60;
    $days = floor($hours / 24);
    $hours -= $days * 24;
    $weeks = floor($days / 7);
    $days -= $weeks * 7;
    $t = "";
    if ($weeks > 0)
        return "$weeks Woche" . ($weeks > 1 ? "n" : "");
    if ($days > 0)
        return "$days Tag" . ($days > 1 ? "en" : "");
    if ($hours > 0)
        return "$hours Stunde" . ($hours > 1 ? "n" : "");
    if ($mins > 0)
        return "$mins Minute" . ($mins > 1 ? "n" : "");
    return "< 1 Minute";
}

function hex_esc($matches)
{
    return sprintf("%02x", ord($matches[0]));
}


function get_wait_time($userid, $torrentid, $only_wait_check = false, $left = -1)
{
    $res = mysql_query("SELECT users.class, users.downloaded, users.uploaded, UNIX_TIMESTAMP(users.added) AS u_added, UNIX_TIMESTAMP(torrents.added) AS t_added, nowait.`status` AS `status` FROM users LEFT JOIN torrents ON torrents.id = $torrentid LEFT JOIN nowait ON nowait.user_id = $userid AND nowait.torrent_id = $torrentid WHERE users.id = $userid");
    $arr = mysql_fetch_assoc($res);

    if (($arr["status"] != "granted" || ($arr["status"] == "granted" && $left > 0 && $GLOBALS["NOWAITTIME_ONLYSEEDS"])) && $arr["class"] < UC_VIP) {
        $gigs = $arr["uploaded"] / 1073741824;
        $elapsed = floor((time() - $arr["t_added"]) / 3600);
        $regdays = floor((time() - $arr["u_added"]) / 86400);
        $ratio = (($arr["downloaded"] > 0) ? ($arr["uploaded"] / $arr["downloaded"]) : 1);

        $wait_times = explode("|", $GLOBALS["WAIT_TIME_RULES"]);

        $wait = 0;
        foreach ($wait_times as $rule) {
            $rule = explode(":", $rule, 4);
            // Format [#w][#d] or *
            // eg: 1w or 1w2d or 2d or * or 0
            preg_match("/([0-9]+w)?([0-9]+d)?|([\\*0])?/", $rule[2], $regrule);
            $regruledays = intval($regrule[1])*7 + intval($regrule[2]);

            if (($ratio < $rule[0] || $gigs < $rule[1]) && ($regruledays==0 || ($regruledays>0 && $regdays < $regruledays)))
                $wait = max($wait, $rule[3], 0);
        }

        if ($only_wait_check)
            return ($wait > 0);

        return max($wait - $elapsed, 0);
    }
    return 0;
}

function get_cur_wait_time($userid)
{
    $res = mysql_query("SELECT class, downloaded, uploaded, UNIX_TIMESTAMP(added) AS added FROM users WHERE users.id = $userid");
    $arr = mysql_fetch_assoc($res);

    if ($arr["class"] < UC_VIP) {
        $gigs = $arr["uploaded"] / 1073741824;
        $regdays = floor((time() - $arr["added"]) / 86400);
        $ratio = (($arr["downloaded"] > 0) ? ($arr["uploaded"] / $arr["downloaded"]) : 1);

        $wait_times = explode("|", $GLOBALS["WAIT_TIME_RULES"]);

        $wait = 0;
        foreach ($wait_times as $rule) {
            $rule = explode(":", $rule, 4);
            // Format [#w][#d] or *
            // eg: 1w or 1w2d or 2d or * or 0
            preg_match("/([0-9]+w)?([0-9]+d)?|([\\*0])?/", $rule[2], $regrule);
            $regruledays = intval($regrule[1])*7 + intval($regrule[2]);

            if (($ratio < $rule[0] || $gigs < $rule[1]) && ($regruledays==0 || ($regruledays>0 && $regdays < $regruledays)))
                $wait = max($wait, $rule[3], 0);
        }

        return $wait;
    }
    return 0;
}

function get_torrent_limits($userinfo)
{
    $limit = array("seeds" => -1, "leeches" => -1, "total" => -1);

    if ($userinfo["tlimitall"] == 0) {
        // Auto limit
        $ruleset = explode("|", $GLOBALS["TORRENT_RULES"]);
        $ratio = (($userinfo["downloaded"] > 0) ? ($userinfo["uploaded"] / $userinfo["downloaded"]) : (($userinfo["uploaded"] > 0) ? 1 : 0));
        $gigs = $userinfo["uploaded"] / 1073741824;

        $limit = array("seeds" => 0, "leeches" => 0, "total" => 0);
        foreach ($ruleset as $rule) {
            $rule_parts= explode(":", $rule);
            if ($ratio >= $rule_parts[0] && $gigs >= $rule_parts[1] && $limit["total"] <= $rule_parts[4]) {
                $limit["seeds"] = $rule_parts[2];
                $limit["leeches"] = $rule_parts[3];
                $limit["total"] = $rule_parts[4];
            }
        }
    } elseif ($userinfo["tlimitall"] > 0) {
        // Manual limit
        $limit["seeds"] = $userinfo["tlimitseeds"];
        $limit["leeches"] = $userinfo["tlimitleeches"];
        $limit["total"] = $userinfo["tlimitall"];
    }

    return $limit;
}

function resize_image($origfn, $tmpfile, $target_filename)
{
	// Bild laden
	if (preg_match("/(jp(e|eg|g))$/i", $origfn)) {
   		$img_pic = @imagecreatefromjpeg($tmpfile);
	}
	if (preg_match("/png$/i", $origfn)) {
   		$img_pic = @imagecreatefrompng($tmpfile);
	}
	if (preg_match("/gif$/i", $origfn)) {
   		$img_pic = @imagecreatefromgif($tmpfile);
	}

	if (!$img_pic)
        return FALSE;

    $size_x = imagesx($img_pic);
    $size_y = imagesy($img_pic);

    $tn_size_x = 150;
    $tn_size_y = (int)((float)$size_y / (float)$size_x * (float)150);

    // Thumbnail erzeugen
    $img_tn = imagecreatetruecolor($tn_size_x, $tn_size_y);
    imagecopyresampled($img_tn, $img_pic, 0, 0, 0, 0, $tn_size_x, $tn_size_y, $size_x, $size_y);

    // Bild speichern
    $dummy = imagejpeg($img_tn, $target_filename, 85);

    imagedestroy($img_tn);

    return $img_pic;
}

function torrent_image_upload($file, $id, $picnum)
{
	if (!isset($file) || $file["size"] < 1) {
		tr_status("err");
        array_push($GLOBALS["uploaderrors"], "Es wurden keine Daten von '".$file["name"]."' empfangen!");
        return FALSE;
    }

    if ($file["size"] > $GLOBALS["MAX_UPLOAD_FILESIZE"]) {
		tr_status("err");
        array_push($GLOBALS["uploaderrors"], "Die Bilddatei '".$file["name"]."' ist zu groß (max. ".mksizeint($GLOBALS["MAX_UPLOAD_FILESIZE"]).")!");
        return FALSE;
    }



    $i = strrpos($file["name"], ".");
	if ($i !== false)
	{
		$ext = strtolower(substr($file["name"], $i));
		if (($it == IMAGETYPE_GIF  && $ext != ".gif") ||
            ($it == IMAGETYPE_JPEG && $ext != ".jpg") ||
            ($it == IMAGETYPE_PNG  && $ext != ".png")) {
		    tr_status("err");
            array_push($GLOBALS["uploaderrors"], "Ung&uuml;tige Dateinamenerweiterung: <b>$ext</b>");
            return FALSE;
        }
		$filename .= $ext;
	}
	else {
		tr_status("err");
        array_push($GLOBALS["uploaderrors"], "Die Datei '".$file["name"]."' besitzt keine Dateinamenerweiterung.");
        return FALSE;
    }

    $img = resize_image($file["name"], $file["tmp_name"], $GLOBALS["SHORTNAME"] . "/torrentpics/t-$id-$picnum.jpg", 100);
    if ($img === FALSE) {
		tr_status("err");
        array_push($GLOBALS["uploaderrors"], "Das Bild '".$file["name"]."' konnte nicht verkleinert werden.");
        return FALSE;
    }
    $ret = imagejpeg($img, $GLOBALS["SHORTNAME"] . "/torrentpics/f-$id-$picnum.jpg", 85);
    imagedestroy($img);
    if (!$ret) {
		tr_status("err");
        array_push($GLOBALS["uploaderrors"], "Die Originalversion des Bildes '".$file["name"]."' konnte nicht auf dem Server gespeichert werden - bitte SysOp benachrichtigen!");
        return FALSE;
    } else {
        tr_status("ok");
        return TRUE;
    }
}

function strip_ascii_art($text)
{
    // First, remove all "weird" characters.
    $text = preg_replace("/[^a-zA-Z0-9öäüÖÄÜß\\-_?!&[\\]().,;:+=#*~@\\/\\\\'\"><\\s]/", "", $text);

    while ($text != $oldtext) {
        $oldtext = $text;
        // Remove all repeating umlauts
        $text = preg_replace("/[öäüÖÄÜß]{2,}/", "", $text);
        // Remove all "free" umlauts, not enclosed by other word chars
        $text = preg_replace("/(^|\\s)[öäüÖÄÜß]+(\\s|$)/sm", "", $text);
    }

    // Remove trailing spaces at end of line
    $text = preg_replace("/([\\t ]+)(\\s$)/m", "\\2", $text);

    return $text;
}

function gen_nfo_pic($nfotext, $target_filename)
{
    // Make array of NFO lines and break lines at 80 chars
    $nfotext = preg_replace('/\r\n/', "\n", $nfotext);
    $lines = explode("\n", $nfotext);
    for ($I=0;$I<count($lines);$I++) {
        $lines[$I] = chop($lines[$I]);
        $lines[$I] = wordwrap($lines[$I], 82, "\n", 1);
    }
    $lines = explode("\n", implode("\n", $lines));

    // Get longest line
    $cols = 0;
    for ($I=0;$I<count($lines);$I++) {

        $lines[$I] = chop($lines[$I]);
        if (strlen($lines[$I]) > $cols)
            $cols = strlen($lines[$I]);
    }

    // Allow a maximum of 500 lines of text
    $lines = array_slice($lines, 0, 500);

    // Get line count
    $linecnt = count($lines);

    // Load font
    $font = imageloadfont("terminal.gdf");
    if ($font < 5)
        die("Konnte das NFO-Font nicht laden. Admin benachrichtigen!");

    $imagewidth = $cols * imagefontwidth($font) + 1;
    $imageheight = $linecnt * imagefontheight($font) + 1;

    $nfoimage = imagecreate($imagewidth, $imageheight);
    $white = imagecolorallocate($nfoimage, 255, 255, 255);
    $black = imagecolorallocate($nfoimage, 0, 0, 0);

    for ($I=0;$I<$linecnt;$I++)
        imagestring($nfoimage, $font, 0, $I*imagefontheight($font), $lines[$I], $black);

    return imagepng($nfoimage, $target_filename);
}
function get_config_data($value = "")
{
  if ($value != "")
  {
    $query  = "SELECT wert FROM config WHERE name = '$value' LIMIT 1";
    $data   = mysql_fetch_array(mysql_query($query));
    return $data["wert"];
  }
  else
    return "!! Keine Daten angegeben !!";
}

function set_config_data($value = "", $new = "")
{
  if (($value != "") AND ($new != ""))
  {
    $query  = "UPDATE config SET wert = '$new' WHERE name = '$value' LIMIT 1";
    return mysql_query($query);
  }
  else
    return "!! Keine Daten angegeben !!";
}

function FormatTimeDiff($t1, $t2=null, $format='yfwdhms')
{
  $t2   = $t2 === null ? time() : $t2;
  $s    = abs($t2 - $t1);
  $sign = $t2 > $t1 ? 1 : -1;
  $out  = array();
  $left = $s;

  $format = array_unique(str_split(preg_replace('`[^yfwdhms]`', '', strtolower($format))));
  $format_count = count($format);

  $a = array('y'=>31556926, 'f'=>2629744, 'w'=>604800, 'd'=>86400, 'h'=>3600, 'm'=>60, 's'=>1);
  $i = 0;

  foreach($a as $k=>$v)
  {
    if(in_array($k, $format))
    {
       ++$i;
       if($i != $format_count)
       {
         $out[$k] = $sign * (int)($left / $v);
         $left = $left % $v;
       }
       else
         $out[$k] = $sign * ($left / $v);
    }
    else
     $out[$k] = 0;
  }
  return $out;
}

function ajaxframe($url,$caption = false,$center = false, $width = "100%",$autor = 10,$info = true,$refresh_button = true,$showtable = true)
{
  $frameid = '';
  $col_span = ($refresh_button === true ? ' colspan="2"' : '');
  $pool = '1234567890';
  $pool .= 'abcdefghijklmnopqurstuvwxyz';
  srand ((double)microtime()*1000000);
  for($index = 0; $index < 20; $index++)
  {
    $frameid .= substr($pool,(rand()%(strlen ($pool))), 1);
  }

  $tabletitle = ($caption !== false ? '<td class="tabletitle" width="100%" style="text-align: center"><b>'.$caption.'</b></td>' : '');
  $rf = ($refresh_button === true ? '<td class="tabletitle" style="text-align: center" width="100%">
        <a href="javascript:void(0);" onclick="tt2ajax_frames.getframeval(\''.$url.'\',\'tt2ajax_f_'.$frameid.'\');'.($autor >= 10 ? 'tt2ajax_frames.resetcount(\''.$frameid.'\');' : '').'"><b>Aktuallisieren</b></a></td>' : '');


  if ($showtable)
  echo'
  <table cellpadding="4" cellspacing="1" border="0" style="width:'.$width.';" class="tableinborder">
    '.($caption !== false || $refresh_button === true ? '<tr>'.$tabletitle.$rf.'</tr>' : '').'
    <tr>
      <td width="100%" class="tablea"'.$col_span.' '.($center ? 'style="text-align: center;"' : '').'>';

  echo '
        <div id="tt2ajax_f_'.$frameid.'" height="100px" style="display:inline;"></div>';

  if ($showtable)
  echo'
      </td>
    </tr>
    '.($autor >= 10 && $info === true ? '<tr>
      <td class="tabletitle" width="100%" style="text-align: center;"'.$col_span.'>
        Dieses Frame aktuallisiert sich automatisch alle '.(0+$autor).' Sekunden nächster Refresh in <span id="tt2ajax_fc_'.$frameid.'">&nbsp;</span>&nbsp;Sekunden
      </td>
    </tr>' : '').'
  </table> ';

  echo '
  <script type="text/javascript" language="javascript">
    tt2ajax_frames.init_ajaxframe(\''.$frameid.'\','.(0+$autor).',\''.$url.'\','.($info === true ? 'true' : 'false').');
  </script>';
}


function check_access($userclass, $log=true, $autowarn = true)
{
  global $CURUSER;

  // Prüfen ob User benötigte User Klasse besitzt
  if (get_user_class() < $userclass)
  {
    //x264_header("Zugriff Verweigert");

    // Variablen setzen
    $username    = htmlentities(trim($CURUSER["username"]));
    $userid      = intval($CURUSER["id"]);
    $added       = get_date_time();
    $warndauer   = 2;                        // Verwarndauer in Wochen
    $until       = sqlesc(get_date_time(time() + ($warndauer * 7 * 86400))); // Weeks * 7 (7 Tage/Woche) * 86400 (60*60*24 Sek/Tag)
    $ip          = ip2long($_SERVER['REMOTE_ADDR']);

    $stdmessage  = "Zugriff Verweigert";
    $usermessage = "Du hast versucht eine Seite zu betreten für die du nicht die nötige Berechtigung besitzt.";

    // Wenn User kein Staffuser und $autowarn = true
    if (get_user_class() < UC_MODERATOR && $autowarn)
    {
      // Logs schreiben
      if ($log)
      {
        if($CURUSER)
        {
          $deniedlogname = "Der Benutzer <a href='userdetails.php?id=".$userid."'>".$username."</a>";
          $staffmessage  = "Der Benutzer [URL=userdetails.php?id=".$userid."]".$username."[/URL]";
        }
        else
        {
          $deniedlogname = "Ein Benutzer mit der IP <a href='whois.php?ip=".$_SERVER['REMOTE_ADDR']."'> ".$_SERVER['REMOTE_ADDR']."</a>";
          $staffmessage  = "Ein Benutzer mit der IP [URL=whois.php?ip=".$_SERVER['REMOTE_ADDR']."]".$_SERVER['REMOTE_ADDR']."[/URL]";
        }
        $deniedlogname  .= " hat Zugriff auf die Datei <a href='".$_SERVER['REQUEST_URI']."'>".$_SERVER['REQUEST_URI']."</a> genommen";
        $staffmessage   .= " hat Zugriff auf die Datei [URL]".$_SERVER['REQUEST_URI']."[/URL] genommen";
        write_log("denied", $deniedlogname.".");
        $staffmessage   .= " die erst ab ".get_user_class_name($userclass)." verfügbar ist.";
        $stdmessage     .= "<br> Der Zugriff wurde geloggt und der Staff benachrichtigt.";
        $usermessage    .= "[br] Dieser Verstoß wurde dem Staff gemeldet!";
      }

      // autowarn = true?
      if ($autowarn)
      {
        if($CURUSER)
        {
          // Verwarnung setzen wenn User eingeloggt ist
          $query = "UPDATE users SET warned = 'yes', warneduntil = ".$until.", timeswarned = timeswarned+1, systemwarn = 'yes', lastwarned = ".sqlesc($added)." , warnedby = 'System' WHERE id = ".$userid." LIMIT 1";
          mysql_query($query) or sqlerr(__FILE__, __LINE__);
          write_modcomment($userid, "0", "Verwarnung erteilt.\nGrund: Hat versucht eine Seite zu betreten die erst ab den Rang ".get_user_class_name($userclass)." zugelassen ist!");
          $usermessage  .= "[br] Zusätzlich würdest du für ".$warndauer." Wochen verwarnt!";
          $stdmessage   .= "<br> Zusätzlich hast du eine Systemverwarnung bekommen";
          $staffmessage .= "[br] User wurde zusätzlich verwarnt";
          $warnlogmsg    = "Der User <href ='/userdetails.php?id=".$userid."'>".$username."</a> wurde automatisch für ".$warndauer." Wochen vom System verwarnt - Grund: Unerlaubter Seitenzugriff";
          sendPersonalMessage(0, $userid, "Systemverwarnung", $usermessage, PM_FOLDERID_SYSTEM, 0);
          write_log("addwarn",  $warnlogmsg);
          write_log("autowarn", $warnlogmsg);
        }
        else
        {
          // IP Sperre setzen wenn User nicht eingeloggt ist
          $query = "INSERT INTO bans (id, added, addedby, comment, first, last) VALUES (NULL, '".$added."', 0, 'System Sperre wegen unerlaubten Seitenzugriff', ".$ip.", ".$ip.")";
          mysql_query($query) or sqlerr(__FILE__, __LINE__);
          $stdmessage   .= "<br> Zusätzlich wurde deine IP gesperrt!";
          $staffmessage .= "[BR] IP Sperre wurde gesetzt";
        }
      }
      // Message an den Staff. Beliebig durch weitere Zeilen erweiterbar wenn mehrere PMs verschickt werden sollen
      sendPersonalMessage(0, "1", "Neugieriger User erwischt", $staffmessage, PM_FOLDERID_INBOX, 0);
    }
    // Error ausgeben
print"
	<div id='x264_error_wrap' style='text-align:left;width:700px;height:560px;margin-top:100px;padding:20px;'>
		<img src='".$GLOBALS["DEFAULTBASEURL"]."/pic/404.png' style='text-align:center;margin:40px 0 0 0;' />
		<div class='x264_error_wrap_info'>".$stdmessage."</div>
		<div style='text-align:center;margin:40px 0 0 0;'><a href='index.php' class='x264_new_error_klicks' style='width:200px;margin-left:240px;'>Back to WebSite</a></div>
	</div>";
    //stdmsg("Fehler", $stdmessage);
    //x264_footer();
    exit();
  }
}

function get_altacp($datei,$data = "")
{
  $config = explode("|",htmlentities(trim(get_config_data("ALTACPCONF"))));

  if ($config[0] == "off")
    return;

  $urlcode = "";
  $ret     = "";
  if (!is_array($data))
    $data = explode("|",$data);

  foreach ($data as $tag)
  {
    $tag = explode("=",$tag);
    $tag[0] = urlencode($tag[0]);
    $tag[1] = urlencode($tag[1]);
    $tag = $tag[0]."=".$tag[1];
    $urlcode .= $tag."&";
  }
  if ($urlcode != "&")
    $urlcode = "?".$urlcode;
  else
    $urlcode = "";

  $file = @fopen ("http://".$config[4].":".$config[5]."@".$config[1].":".$config[2].$config[3]."/".$datei.".php".$urlcode,"r");

  if (!$file)
    stderr("Fehler","ALTACP Server zur Zeit Offline");

  while (!feof($file))
    $ret .= fgets($file,200000);

  fclose($file);

  $return = explode("\n\n",$ret);

  switch ($return[0])
  {
    case "100":
      return true;
    case "101":
      $ret  = explode("\n",$return[1]);
      $ret2 = array();
      foreach ($ret as $zeile)
      {
        $zeile  = explode("|",$zeile);
        $ret2[] = $zeile;
      }
      return $ret2;
    case "102":
      $ret = explode("\n",$return[1]);
      return explode("|",$ret[0]);
    case "201":
      stderr("Fehler","Fehlende Daten für ALTACP Server");
    case "202":
      stderr("Fehler","User im ALTACP System nicht gefunden");
    case "301":
      return true;
    case "302":
      return false;
    case "400":
      return $return[1];
    case "401":
      return $return[1];
    case "500":
      stderr("Zugriff verweigert","Der Zugriff auf die ALTACP Datenbank wurde verweigert");
    case "501":
      stderr("Zugriff verweigert","Sie haben nicht die erforderlichen Rechte um diese Aktion auszuführen");
    case "502":
      stderr("Zugriff verweigert","Die angegebenen ALTACP Datenbank Zugangsdaten sind durch ein Admin gesperrt worden");
    case "503":
      stderr("Zugriff verweigert","Ungültige IP Adresse");
    case "800":
      stderr("Fehler","Der ALTACP Server hat einen Datenbankfehler gemeldet:<br>".$return[1]);
    default:
      stderr("Fehler","Der ALTACP hat einen nicht definierten Fehler gemeldet:<br>".$ret);
  }
}

function loadmodul($title)
{
  $file = dirname(__FILE__) . "/../modules/modules.".$title.".php";

  if(file_exists($file))
    include($file);
  else
    stdmsg("Fehler","Modul ".$file." Not found");
}

function smtp_mail($userid_email, $subject, $message, $htmlmail = false)
{
  global $db;

  $auth = explode("|",htmlentities(trim(get_config_data("SMTPAUTH"))));

  if (!$auth[0] || !$auth[1] || !$auth[2])
  {
    return false;
  }
  
  if(is_array($userid_email))
  {
    $email    = $userid_email['email'];
    $username = $userid_email['username'];
  }
  elseif(is_numeric($userid_email))
  {
    $sql = "SELECT username, email FROM users WHERE id = ".$userid_email;
    $arr = $db -> querySingleArray($sql);

    $email    = $arr['email'];
    $username = $arr['username'];
  }
  else
  {
    $email    = $userid_email;
    $username = $userid_email;
  }

  if (!validemail($email) || !$username)
  {
    return false;
  }

  $data = array(
    "TO" => array($username,$email),
    "HTML" => $htmlmail,
    "MAIL" => array($subject,$message)
  );
  
  $port = 25;
  $debug = true;
  
  if (is_array($data['BCC']))
  {
    $bcc = array();
    foreach($data['BCC'] as $row)
    {
      if (empty($row[1]))
      {
        $name = $row[0];
        $mail = $row[0];
      }
      else
      {
        $name = $row[0];
        $mail = $row[1];        
      }
      $bcc[] = $name." <".$mail.">";
    }
    $bcc = implode(", ",$bcc);
  }
  
  $send = array(
    "EHLO localhost",
    "AUTH LOGIN",
    base64_encode($auth[1]),
    base64_encode($auth[2]),
    "MAIL FROM: <".$GLOBALS['SITEEMAIL'].">",
    "RCPT TO: <".$data['TO'][1].">",
    "DATA",
    "MIME-Version: 1.0",
    "From: ".$GLOBALS['SITENAME']." <".$GLOBALS['SITEEMAIL'].">",
    "To: ".$data['TO'][0]." <".$data['TO'][1].">",
    "Bcc: ".$bcc,
    "Subject: ".$data['MAIL'][0],
    "Content-type: text/".($data['HTML'] === true?"html":"plain")."; charset=iso-8859-1",
    $data['MAIL'][1],
    ".",
    "QUIT",
  );

  $handle = fsockopen($auth[0],$port);

  foreach($send as $line)
  {
    fputs($handle, $line."\n");
  }
  
  fclose($handle);
  return true;
}


function check_seedtime($seedtime)
{
  $seedtime = explode(",",$seedtime);
  
  if($seedtime[0] == 1)
  {
    return true;
  }
  else
  {
    if ($seedtime[1] > $seedtime[2])
    {
      $seed1 = (($seedtime[1] - $seedtime[2]) <= 18?true:false);
    }
    else
    {
      $seed1 = (($seedtime[2] - $seedtime[1]) >= 6?true:false);
    }
    if ($seedtime[3] > $seedtime[4])
    {
      $seed2 = (($seedtime[3] - $seedtime[4]) <= 18?true:false);
    }
    else
    {
      $seed2 = (($seedtime[4] - $seedtime[3]) >= 6?true:false);
    }
    if ($seed1 && $seed2)
    {
      return true;
    }
  }
  return false;
}

function who_is_online_clean()
{
  $dt = sqlesc(get_date_time(time() - 1000));
  $online = array();

  $res_online = mysql_query("SELECT id FROM users WHERE last_access >= $dt AND last_access <= NOW()") or sqlerr(__FILE__, __LINE__);
  $res_page   = mysql_query("SELECT id FROM users WHERE page <> ''") or sqlerr(__FILE__, __LINE__);

  while ($arr_online = mysql_fetch_array($res_online))
    $online[] = $arr_online["id"];

  while ($arr_page = mysql_fetch_array($res_page))
    if (!in_array($arr_page["id"], $online))
      mysql_query("UPDATE users SET page = '' WHERE id = " . $arr_page["id"] . " LIMIT 1") or sqlerr(__FILE__, __LINE__);
}
?>