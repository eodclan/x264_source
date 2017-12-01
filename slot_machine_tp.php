<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");
dbconn(false);
loggedinorreturn();

x264_header("Slot Machine");

$HTMLOUT='';

/** page functions **/
function slot_image($type) {
    global $slot;
    if (isset($slot['images'][$type]))
        return $slot['images'][$type];
    else
        return '';
}

  function highroller($CURUSER) {
  if($CURUSER['uploaded'] > 3221225472) {
  return true;
}
  else    
  return false;
}

$slot['index']      = '<a href="slot_machine_tp.php"><b>Zurück</b></a>';
$slot['faces']      = array ('s_melon', 's_lemon', 's_kiwi', 's_orange', 's_evilgit', 's_seven');
$slot['bet_amount'] = (isset($_POST['bet_amount']) ? (int)$_POST['bet_amount'] : 0);
$slot['bet_value0'] = 524288000;
$slot['bet_value1'] = 104857600;
$slot['bet_value2'] = 262144000;
$slot['bet_value3'] = 524288000;
$slot['bet_value4'] = 786432000;
$slot['bet_value5'] = 1073741824;
$slot['bet_value6'] = 2147483648;
$slot['bet_value7'] = 5368709120;

$slot['values'] = array($slot['bet_value0'] => $slot['bet_value0'],
                        $slot['bet_value1'] => $slot['bet_value1'],
                        $slot['bet_value2'] => $slot['bet_value2'],
                        $slot['bet_value3'] => $slot['bet_value3'],
                        $slot['bet_value4'] => $slot['bet_value4'],
                        $slot['bet_value5'] => $slot['bet_value5'],
                        $slot['bet_value6'] => $slot['bet_value6'],
                        $slot['bet_value7'] => $slot['bet_value7']
                        );
                        
if (isset($slot['values'][$slot['bet_amount']]))
    $slot['bet_amount'] = $slot['values'][$slot['bet_amount']];
else
    $slot['bet_amount'] = 0;

  $slot['images'] = array('s_melon'  	 => '<img src="pic/slots/slots.001.png" height="51" Width="50" alt="" />',
                        's_melon'  		 => '<img src="pic/slots/s_melon.png" height="51" Width="50" alt="" />',
                        's_lemon'  		 => '<img src="pic/slots/s_lemon.png" height="51" Width="50" alt="" />',
                        's_kiwi'   		 => '<img src="pic/slots/s_kiwi.png" height="51" Width="50" alt="" />',
                        's_wog'   		 => '<img src="pic/slots/s_wog.png" height="51" Width="50" alt="" />',
                        's_superjack'    => '<img src="pic/slots/s_superjack.png" height="51" Width="50" alt="" />', 
                        's_orange' 		 => '<img src="pic/slots/s_orange.png" height="51" Width="50" alt="" />',
                        's_evilgit'		 => '<img src="pic/slots/s_evilgit.png" height="51" Width="50" alt="" />',
                        's_seven'  		 => '<img src="pic/slots/s_seven.png" height="51" Width="50" alt="" />'
                        );
        
$slot['payouts'] = array ('s_seven|s_seven|s_melon' => '2', 
                  's_seven|s_seven|s_lemon' => '3',
                  's_seven|s_seven|s_kiwi' => '4',
                  's_seven|s_seven|s_orange' => '5',
                  's_melon|s_melon|s_melon' => '15',
                  's_lemon|s_lemon|s_lemon' => '50',
                  's_kiwi|s_kiwi|s_kiwi' => '20',
                  's_orange|s_orange|s_orange' => '70',
                  's_seven|s_seven|s_seven' => '75',
                  's_evilgit|s_evilgit|s_evilgit' => '1000'
                  );

$wheel1 = array();
foreach ($slot['faces'] as $face)
    $wheel1[] = $face;

$wheel2 = array_reverse($wheel1);
$wheel3 = $wheel1;

if ($slot['bet_amount'] < 0)
    stderr('Sorry', 'Du kannst nicht spielen,pruefe dein Upload. '.$slot['index'], false);

if ($slot['bet_amount'] > $CURUSER['uploaded'])
    stderr('Sorry', 'Du hast nicht genug Upload um zu spielen '.$slot['index'], false);

$slot['new_karma'] = ($CURUSER['uploaded'] - $slot['bet_amount']);

if ($slot['bet_amount'] > ($CURUSER['uploaded'] / 2))     
stderr('Sorry', 'Du kannst nicht soviel Einsatz setzen '.$slot['index'].'.<br />Ein solches Risiko erlauben wir nicht! :)', false);
 
if (isset($_POST['payline']))
    list($start1, $start2, $start3) = unserialize($_POST['payline']);
else
    list($start1, $start2, $start3) = array(0, 0, 0);

//$_POST['payline'] = $_POST['payline'];

$stop1 = rand(count($wheel1)+$start1, 10 * count($wheel1)) % count($wheel1);
$stop2 = rand(count($wheel1)+$start2, 10 * count($wheel1)) % count($wheel1);
$stop3 = rand(count($wheel1)+$start3, 10 * count($wheel1)) % count($wheel1);

$result1 = $wheel1[$stop1];
$result2 = $wheel2[$stop2];
$result3 = $wheel3[$stop3];

print "
<script>
function ShowSLOT_MACHINE_INFO(){
	if(document.getElementById('x264_slot_machine_info').style.display == 'none'){
	document.getElementById('x264_slot_machine_info').style.display = 'block';
	CheckIfEdit('taken');
	}else{
	document.getElementById('x264_slot_machine_info').style.display = 'none';
	CheckIfEdit('giveup');
	}
}

function ShowSLOT_MACHINE_CARDS(){
	if(document.getElementById('x264_slot_machine_cards').style.display == 'none'){
	document.getElementById('x264_slot_machine_cards').style.display = 'block';
	CheckIfEdit('taken');
	}else{
	document.getElementById('x264_slot_machine_cards').style.display = 'none';
	CheckIfEdit('giveup');
	}
}
</script>

                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Slot Machine Navi
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>	
								<td><a href='#nogo' onclick='ShowSLOT_MACHINE_INFO();' class='navLink'><i class='fa fa-star'></i>  Spiel</a></td>
								<td><a href='#nogo' onclick='ShowSLOT_MACHINE_CARDS(); display: none;' class='navLink'><i class='fa fa-archive'></i>  Info</a></td>	
                            </tr>
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>					


  <div id='x264_slot_machine_info'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Slot Machine - Spiel
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
							<tr>
								<td>Bitte beachte, dass du auf dein Upload achtest!</td><td>Der Jackpot erhöht sich bei jeden Tipp um dein Einsatz!</td>
							</tr>";

if (highroller($CURUSER)){

  $res1 = mysql_query("SELECT * FROM slot_machine_tp") or sqlerr(__FILE__, __LINE__); //Daten holen
  $rows = mysql_fetch_array($res1);
  $HTMLOUT.= '<tr><td>Unser Jackpot ist im Moment bei:</td><td> '.mksize($rows["uploaded"]).'!</td></tr>'; 	
	
$HTMLOUT.= '
	<tr><td>Dein Ergebnis lautet:</td><td>'.slot_image($result1).' '.slot_image($result2).' '.slot_image($result3).'</td></tr>';

// main 

if (!$slot['bet_amount'])
	$HTMLOUT.= '';  	
else {
  $res1 = mysql_query("SELECT * FROM slot_machine_tp") or sqlerr(__FILE__, __LINE__); //Daten holen
  $rows = mysql_fetch_array($res1);	
	
	
    if ($slot['payouts'][$result1.'|'.$result2.'|'.$result3] == 75) {
        $HTMLOUT.= 'Du hast den Jackpot über : '.mksize($rows["uploaded"]).' Upload gewonnen '. $CURUSER["username"].'';
    mysql_query("UPDATE users SET uploaded = uploaded+ ".$rows['uploaded']." WHERE id =".$CURUSER['id']);
	mysql_query("update slot_machine_tp set uploaded=0 where id=1");
    $text = "[color=".Lime."]  Der User[/color] [color=".gold."]$CURUSER[username] [/color][color=".Lime."]hat den Jackpot der Slot Machine gewonnen.[/color]";
    $date = time();
    mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES ('id', " . sqlesc('0') . ", " . sqlesc('<font color=white>Tactics</font>') . ", $date, " . sqlesc($text) . ")") or sqlerr(__FILE__, __LINE__);	
    }
    elseif ($slot['payouts'][$result1.'|'.$result2.'|'.$result3] == 1000) {
        if($CURUSER['uploaded'] / 2 <= $slot['bet_amount']) {
            // best to check ratio... if they can't afford it
            $HTMLOUT.= 'Du gluecklicher du armer... I\'m still taking your original stake, though.. '.$slot['index'].'... ';
            mysql_query("UPDATE users SET uploaded = uploaded - ".$slot['bet_amount']." WHERE id =".$CURUSER['id']);
        }
        else {
            // if they can then this is such a bastard... but funny
            $HTMLOUT.='Looser! Du verlierst ein Zenhtel deines Uploads! HAHAHA... Die Slot Machine hat wieder zugeschlagen '.$CURUSER['username'].'\'du hast ein Zehntel deines Uploads verloren.';
            mysql_query("UPDATE users SET uploaded = uploaded*0.80 WHERE id =".$CURUSER['id']);
            $text = "[color=".Lime."]  Der User[/color] [color=".gold."]$CURUSER[username] [/color][color=".Lime."]hat ein Zehntel seines Uploads bei der Slot Machine verloren.[/color]";
            $date = time();
            mysql_query("INSERT INTO shoutbox (id, userid, username, date, text) VALUES ('id', " . sqlesc('0') . ", " . sqlesc('<font color=white>Tactics</font>') . ", $date, " . sqlesc($text) . ")") or sqlerr(__FILE__, __LINE__);           
        }
    }
    elseif (isset($slot['payouts'][$result1.'|'.$result2.'|'.$result3]) && $slot['payouts'][$result1.'|'.$result2.'|'.$result3] < 75) {
        // give the payout
        $HTMLOUT.= 'Du gewinnst : '.mksize($slot['payouts'][$result1.'|'.$result2.'|'.$result3]*$slot['bet_amount']).'.';
        mysql_query("UPDATE users SET uploaded = uploaded + ".$slot['payouts'][$result1.'|'.$result2.'|'.$result3]*$slot['bet_amount']." WHERE id =".$CURUSER['id']);
    }
    else {
        // ah gut... du verlierst... hehe
        $HTMLOUT.= 'Du verlierst: '.mksize($slot['bet_amount']).' , '.$CURUSER['username'].'';
        mysql_query("UPDATE users SET uploaded = uploaded - ".$slot['bet_amount']." WHERE id =".$CURUSER['id']);
		mysql_query("UPDATE slot_machine_tp SET uploaded = uploaded + ".$slot['bet_amount']." where id = 1");		
    }
   
}

// end main
$slots = md5(uniqid('slots'));

$HTMLOUT.= '<tr><td>Bitte dein Einsatz wählen!</td><td>
    <form method="post" name="slots" action="">
    <input type="hidden" name="payline" value="'.serialize(array($stop1, $stop2, $stop3)).'" />
    <select name="bet_amount">
    <option value="'.$slot['bet_value0'].'">500MB Upload</option>
    <option value="'.$slot['bet_value4'].'">750MB Upload</option>
    <option value="'.$slot['bet_value5'].'">1GB Upload</option>
	<option value="'.$slot['bet_value6'].'">2GB Upload</option>';

if (highroller($CURUSER))
    $HTMLOUT.= '<option value="'.$slot['bet_value7'].'">5GB Upload</option>';
 
$HTMLOUT.= '</select></td></tr>
<tr><td>Versuch dein Glück:</td><td><input type="submit" value="Versuch dein Glück jetzt!" />
</form>';
echo $HTMLOUT;
}
print "
   </td></tr>
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</div>					

<div id='x264_slot_machine_cards' style='display: none;'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Slot Machine - Infos
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                            <tr>  
								<td>Tipp x 2 Win</td><td><img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_seven.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_seven.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_lemon.png'></td>
                            </tr>
                            <tr>								
								<td>Tipp x 2 Win</td><td><img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_seven.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_seven.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_kiwi.png'></td>
                            </tr>
                            <tr>								
								<td>Tipp x 2 Win</td><td><img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_seven.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_seven.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_orange.png'></td>
                            </tr>
                            <tr>								
								<td>Tipp x 2 Win</td><td><img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_melon.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_melon.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_melon.png'></td>
                            </tr>
                            <tr>								
								<td>Tipp x 2 Win</td><td><img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_lemon.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_lemon.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_lemon.png'></td>
                            </tr>
                            <tr>								
								<td>Tipp x 3 Win</td><td><img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_kiwi.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_kiwi.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_kiwi.png'></td>
                            </tr>
                            <tr>								
								<td>Tipp x 4 Win</td><td><img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_orange.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_orange.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_orange.png'></td>
                            </tr>
                            <tr>							
								<td>Tipp x 4 Win</td><td><img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_seven.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_seven.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_seven.png'></td>
                            <tr>								
								<td>Tipp x 5 Win (Jackpot)</td><td><img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_evilgit.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_evilgit.png'>&nbsp;<img height=35 width=35 src='".$GLOBALS["DESIGN_PATTERN"].$GLOBALS["ss_uri"]. "/slots/s_evilgit.png'></td>
                            </tr>
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</div>";
x264_footer();
?>