              <tr><td class="tabletitle" style="padding: 4px;"><b><?=htmlspecialchars($CURUSER["username"])?> :.</b></td></tr>
              <tr><td class="tablea" style="padding-left: 4px;">
	            <table cellspacing="0" cellpadding="2" border="0" style="width:140px;" summary="none">
		          <tr><td><b>Download:</b></td><td style="text-align:right"><?=mksize($CURUSER["downloaded"])?></td></tr>
		          <tr><td><b>Upload:</b></td><td style="text-align:right"><?=mksize($CURUSER["uploaded"])?></td></tr>
		          <tr><td><b>Ratio:</b></td><td style="text-align:right;color:<?=get_ratio_color($ratio)?>"><?=$ratio?></td></tr>
		          <tr><td colspan="2">&nbsp;</td></tr>
		          <tr<?=$seedwarn?>><td><b>Seeds:</b></td><td style="text-align:right"><?=$seeds . $tlimits["seeds"]?></td></tr>
		          <tr<?=$leechwarn?>><td><b>Leeches:</b></td><td style="text-align:right"><?=$leeches . $tlimits["leeches"]?></td></tr>
		          <tr<?=$totalwarn?>><td><b>Gesamt:</b></td><td style="text-align:right"><?=($seeds + $leeches) . $tlimits["total"]?></td></tr>
		        </table>
              </td></tr>