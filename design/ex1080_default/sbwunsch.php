<?php
require_once(dirname(__FILE__)."/include/bittorrent.php");
dbconn();
loggedinorreturn();

if ($_POST['modus'] == "close")
{
  die();
}

$radiow = ($_POST['radiow'] == "imghost"?"Imghost":"Smilies");
  print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>".$radiow."</b> <a href=\"javascript:showframe('".$radiow."','close');\"><img src='".$GLOBALS["DESIGN_PATTERN"]."x264_default/editdelete.png' alt='Schließen' border='0' title='Frame Schließen'></a></h1>
<div class='x264_title_content'>
	<div class='x264_title_table'>";

if ($radiow == "Imghost")
{
  $res = $db -> queryObjectArray("SELECT filename FROM imghost WHERE user = ".$CURUSER['id']);

  if ($res)
  {
    $i = 0;
    foreach($res as $arr)
    {
      if ($i == 8)
      {
        print "
            </div>
            <div class='x264_title_table'>";
        $i = 0;
      }
      print "     
              <div class='x264_title_table_staff'><a class='x264_smilies_bar' onclick=\"javascript:addSmilie('[imghost=".$arr['filename']."]','shbox_text');showframe('".$radiow."','close');\"><img src='".$arr['filename']."' alt='' width='80px'></a></div>";
      ++$i;
    }
    if ($i != 8)
    { 
      print "
              <div class='x264_title_table_staff' colspan=".(8-$i).">";
    }
  }
  else
  {
    print "Dein Imghost ist leer";
  }
}
else
{
  $i = 0;
  foreach($smilies as $key => $val)
  {
    if ($i == 5)
    {
      print "
            </div>
            <div class='x264_title_table'>";
      $i = 0;
    }
    print "                            
              <div class='x264_title_table_staff'><a class='x264_smilies_bar' onclick=\"javascript:addSmilie('".$key."','shbox_text');showframe('".$radiow."');\"><img src='/pic/smilies/".$val."' alt='".$key."' title='".$key."' style='max-width:50px'></a></div>";
      ++$i;
  }
  if ($i != 5)
  { 
    print "
              <div class='x264_title_table_staff' colspan=".(5-$i).">";
  }  
}

print "
	</div>
</div>
</div>";

?> 