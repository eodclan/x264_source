<?php
require_once(dirname(__FILE__)."/include/bittorrent.php");
dbconn();
loggedinorreturn();

if ($_POST['modus'] == "close")
{
  die();
}

$radiow = ($_POST['radiow'] == "radio"?"Radio");
  print "
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>".$radiow."</b> <a href=\"javascript:showframe('".$radiow."','close');\"><img src='".$GLOBALS["DESIGN_PATTERN"]."x264_default/editdelete.png' alt='Schließen' border='0' title='Frame Schließen'></a></h1>
<div class='x264_title_content'>
	<div class='x264_title_table'>";

if ($radiow == "Radio")
{
  $res = $db -> queryObjectArray("SELECT filename FROM imghost WHERE user = ".$CURUSER['id']);

print '
<div class="x264_wrapper_content_out_mount">
<h1 class="x264_im_logo">Radio wunsch</h1>
<div class="x264_title_content">
            <form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'" method="post">
				<div class="x264_tfile_add_wrap_log">Hier drüber kannst du dir ein Musik wunsch im radio wünschen.</div>
				<br />		
				<h1 class="x264_im_logo">Gebe nun deine Radio wunsch Daten ein.</h1>
				<br />
				<div class="x264_tfile_add_wrap_log"><div class="x264_nologged_inp">Interpret: </div><div class="x264_tfile_add_inc"><input type="text" name="interpret" size="80" class="x264_tfile_add_inputs_special" /></div></div>			
				<br />			
				<div class="x264_tfile_add_wrap_log"><div class="x264_nologged_inp">Titel: </div><div class="x264_tfile_add_inc"><input type="text" name="titel" size="80" class="x264_tfile_add_inputs_special" /></div></div>
				<br />			
			</form>
</div>
</div>';  
  
}

print "
	</div>
</div>
</div>";

?> 