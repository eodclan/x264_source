<?php
// ************************************************************************************//
// * EX 1080 Source
// ************************************************************************************//
// * Author: D@rk-�vil�
// ************************************************************************************//
// * Version: 1.0
// * 
// * Copyright (c) 2017 D@rk-�vil�. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//
  ob_start ("ob_gzhandler");
  ob_start("compress");
  header("Content-type: text/css;charset: UTF-8");
  header("Cache-Control: must-revalidate");
  $offset = 60 * 60 ;
  $ExpStr = "Expires: " . gmdate("D, d M Y H:i:s",time() + $offset) . " GMT";
  header($ExpStr);
  function compress($buffer) {
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    $buffer = str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),'',$buffer);
    $buffer = str_replace('{ ', '{', $buffer);
    $buffer = str_replace(' }', '}', $buffer);
    $buffer = str_replace('; ', ';', $buffer);
    $buffer = str_replace(', ', ',', $buffer);
    $buffer = str_replace(' {', '{', $buffer);
    $buffer = str_replace('} ', '}', $buffer);
    $buffer = str_replace(': ', ':', $buffer);
    $buffer = str_replace(' ,', ',', $buffer);
    $buffer = str_replace(' ;', ';', $buffer);
    $buffer = str_replace(';}', '}', $buffer);
    return $buffer;
  }
?>
@font-face{font-family:'Glyphicons Social';src:url('../fonts/glyphicons-social-regular.eot');src:url('../fonts/glyphicons-social-regular.eot?#iefix') format('embedded-opentype'),url('../fonts/glyphicons-social-regular.woff2') format('woff2'),url('../fonts/glyphicons-social-regular.woff') format('woff'),url('../fonts/glyphicons-social-regular.ttf') format('truetype'),url('../fonts/glyphicons-social-regular.svg#glyphicons_socialregular') format('svg')}.social{position:relative;top:1px;display:inline-block;font-family:'Glyphicons Social';font-style:normal;font-weight:normal;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.social.x05{font-size:12px}.social.x2{font-size:48px}.social.x3{font-size:72px}.social.x4{font-size:96px}.social.x5{font-size:120px}.social.light:before{color:#f2f2f2}.social.drop:before{text-shadow:-1px 1px 3px rgba(0,0,0,0.3)}.social.flip{-moz-transform:scaleX(-1);-o-transform:scaleX(-1);-webkit-transform:scaleX(-1);transform:scaleX(-1);filter:FlipH;-ms-filter:"FlipH"}.social.flipv{-moz-transform:scaleY(-1);-o-transform:scaleY(-1);-webkit-transform:scaleY(-1);transform:scaleY(-1);filter:FlipV;-ms-filter:"FlipV"}.social.rotate90{-webkit-transform:rotate(90deg);-moz-transform:rotate(90deg);-ms-transform:rotate(90deg);transform:rotate(90deg)}.social.rotate180{-webkit-transform:rotate(180deg);-moz-transform:rotate(180deg);-ms-transform:rotate(180deg);transform:rotate(180deg)}.social.rotate270{-webkit-transform:rotate(270deg);-moz-transform:rotate(270deg);-ms-transform:rotate(270deg);transform:rotate(270deg)}.social-pinterest:before{content:"\E001"}.social-dropbox:before{content:"\E002"}.social-google-plus:before{content:"\E003"}.social-jolicloud:before{content:"\E004"}.social-yahoo:before{content:"\E005"}.social-blogger:before{content:"\E006"}.social-picasa:before{content:"\E007"}.social-amazon:before{content:"\E008"}.social-tumblr:before{content:"\E009"}.social-wordpress:before{content:"\E010"}.social-instapaper:before{content:"\E011"}.social-evernote:before{content:"\E012"}.social-xing:before{content:"\E013"}.social-e-mail-envelope:before{content:"\E014"}.social-dribbble:before{content:"\E015"}.social-deviantart:before{content:"\E016"}.social-read-it-later:before{content:"\E017"}.social-linked-in:before{content:"\E018"}.social-gmail:before{content:"\E019"}.social-pinboard:before{content:"\E020"}.social-behance:before{content:"\E021"}.social-github:before{content:"\E022"}.social-youtube:before{content:"\E023"}.social-open-id:before{content:"\E024"}.social-foursquare:before{content:"\E025"}.social-quora:before{content:"\E026"}.social-badoo:before{content:"\E027"}.social-spotify:before{content:"\E028"}.social-stumbleupon:before{content:"\E029"}.social-readability:before{content:"\E030"}.social-facebook:before{content:"\E031"}.social-twitter:before{content:"\E032"}.social-instagram:before{content:"\E033"}.social-posterous-spaces:before{content:"\E034"}.social-vimeo:before{content:"\E035"}.social-flickr:before{content:"\E036"}.social-last-fm:before{content:"\E037"}.social-rss:before{content:"\E038"}.social-skype:before{content:"\E039"}.social-e-mail:before{content:"\E040"}.social-vine:before{content:"\E041"}.social-myspace:before{content:"\E042"}.social-goodreads:before{content:"\E043"}.social-apple:before{content:"\E044"}.social-windows:before{content:"\E045"}.social-yelp:before{content:"\E046"}.social-playstation:before{content:"\E047"}.social-xbox:before{content:"\E048"}.social-android:before{content:"\E049"}.social-ios:before{content:"\E050"}.social-wikipedia:before{content:"\E051"}.social-pocket:before{content:"\E052"}.social-steam:before{content:"\E053"}.social-soundcloud:before{content:"\E054"}.social-slideshare:before{content:"\E055"}.social-netflix:before{content:"\E056"}.social-paypal:before{content:"\E057"}.social-google-drive:before{content:"\E058"}.social-linux-foundation:before{content:"\E059"}.social-ebay:before{content:"\E060"}.social-bitbucket:before{content:"\E061"}.social-whatsapp:before{content:"\E062"}.social-buffer:before{content:"\E063"}.social-medium:before{content:"\E064"}.social-stackoverflow:before{content:"\E065"}.social-linux:before{content:"\E066"}.social-vk:before{content:"\E067"}.social-snapchat:before{content:"\E068"}.social-etsy:before{content:"\E069"}.social-stackexchange:before{content:"\E070"}