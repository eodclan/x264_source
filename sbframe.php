<?php
require_once(dirname(__FILE__)."/include/bittorrent.php");
dbconn();
loggedinorreturn();

if ($_POST['modus'] == "close")
{
  die();
}

$what = ($_POST['what'] == "imghost"?"Imghost":"Smilies");
  print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-crosshairs'></i> ".$what."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<table class='table table-bordered table-striped table-condensed'>
										<tr>";

if ($what == "Imghost")
{
  $res = $db -> queryObjectArray("SELECT filename FROM imghost WHERE user = ".$CURUSER['id']);

  if ($res)
  {
    $i = 0;
    foreach($res as $arr)
    {
      if ($i == 16)
      {
        print "
            </tr>
            <tr>";
        $i = 0;
      }
      print "     
              <a onclick=\"javascript:addSmilie('[imghost=".$arr['filename']."]','shbox_text');showframe('".$what."','close');\"><img src='".$arr['filename']."' alt=''></a>";
      ++$i;
    }
    if ($i != 8)
    { 
      print "
              <td colspan=".(8-$i).">";
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
    if ($i == 12)
    {
      print "
            </tr>
            <tr>";
      $i = 0;
    }
    print "                            
              <td style='text-align:center'><a onclick=\"javascript:addSmilie('".$key."','shbox_text');showframe('".$what."');\"><img src='/pic/smilies/".$val."' alt='".$key."' title='".$key."' style='width:50%;'></a></td>";
      ++$i;
  }
  if ($i != 12)
  { 
    print "
";
  }  
}

print "
            </tr>
          </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

?> 