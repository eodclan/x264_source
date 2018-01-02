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

header('Content-Type: text/html; charset=iso-8859-1');

dbconn();
loggedinorreturn();

//get the q parameter from URL
$q=$_GET["q"];

//find out which feed was selected
if($q=="newshost") {
	$xml=("http://www.srrdb.com/feed/srrs");
} elseif($q=="nfohump") {
	$xml=("http://www.nfohump.com/rss/rss_all.xml");
} elseif($q=="srrdb") {
	$xml=("http://www.srrdb.com/feed/srrs");
} elseif($q=="rlslogappz") {
	$xml=("http://www.rlslog.net/category/applications/feed/");  
}

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);

//get elements from "<channel>"
	$channel=$xmlDoc->getElementsByTagName('channel')->item(0);
	$channel_title = $channel->getElementsByTagName('title')
	->item(0)->childNodes->item(0)->nodeValue;
	$channel_link = $channel->getElementsByTagName('link')
	->item(0)->childNodes->item(0)->nodeValue;
	$channel_desc = $channel->getElementsByTagName('description')
	->item(0)->childNodes->item(0)->nodeValue;

//get and output "<item>" elements
$x=$xmlDoc->getElementsByTagName('item');
for ($i=0; $i<=25; $i++) {
	$item_title=$x->item($i)->getElementsByTagName('title')
	->item(0)->childNodes->item(0)->nodeValue;
	$item_link=$x->item($i)->getElementsByTagName('link')
	->item(0)->childNodes->item(0)->nodeValue;
	$item_desc=$x->item($i)->getElementsByTagName('description')
	->item(0)->childNodes->item(0)->nodeValue;
echo("<div class='table table-bordered table-striped table-condensed'><label><a href='tfiles.php?showsearch=1&search=" . $item_title . "&blah=0&incldead=0&orderby=added&sort=desc'><i class='fa fa-search'></i></a></label> <b>" . $item_title . "</b></div>");

}
?>