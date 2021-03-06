<?php
// ************************************************************************************//
// * D� Source 2018
// ************************************************************************************//
// * Author: D@rk-�vil�
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2017 - 2018 D@rk-�vil�. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************// 
// Leer Lassen f�r Direct Connect
$picloaderurl = "";

$url          = trim($_GET['url']);

if (!$url)
  die();

function get_file_extension()
{
  global $url;

  $ext_arr = explode(".",$url);
  $count   = count($ext_arr);
  $ext     = $ext_arr[($count-1)];

  return $ext;
}

function get_filename()
{
  global $url;

  $file_arr = explode("/", $url);
  $count    = count($file_arr);
  $filename = $file_arr[($count-1)];
  
  return $filename;
}

function get_http_data()
{
  global $url, $picloaderurl;
  
  if ($picloaderurl)
    $get_url = $picloaderurl."?url=".urlencode($url);
  else
    $get_url = $url;

  $connect = @fopen ($get_url,"r");

  if (!$connect)
  {
    die();
  }

  while (!feof($connect))
  {
    $ret .= fgets($connect,2000);
  }

  $ext      = get_file_extension();
  $filename = get_filename();

  fclose($connect);
  return array("data" => $ret, "ext" => $ext, "filename" => $filename);
}

$data = get_http_data();


if ($data['data'] && $data['ext'] && $data['filename'])
{
  header("Content-Disposition: filename=\"".$data['filename']."\"");
  Header("Content-Type: image/".$data['ext']);
  print $data['data'];
}
?>