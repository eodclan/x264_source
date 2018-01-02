<?php
// ************************************************************************************//
// * Lottery PHP File v 0.4 
// ************************************************************************************//
// * Copyright (c) 2010 DefCon3
// * 
// * Co Author tantetoni2  [ THX for JavaScript development! ]
// * 
// ************************************************************************************//
// * Dieses unsichtbare Copyright muss bestehen bleiben.
// * Mit entfernung des Unsichtbaren Copyrights machen sie sich Strafbar.
// * Der Lizenztraeger sowie Rechteinhaber ist allein DefCon3.
// * Sollten Sie diese Hinweise nicht achten kann dies fuer Sie rechtliche Folgen haben.
// ************************************************************************************//

require_once(dirname(__FILE__) . "/include/engine.php");
dbconn();
loggedinorreturn();

$canViewAbos   = UC_MODERATOR;
$canEditConfig = UC_ADMINISTRATOR;
$canManualDraw = UC_SYSOP;
$toDo          = isset($_POST['toDo']) ? htmlentities($_POST['toDo']) : 'info';
$Error         = false;
$saveSuccess   = false;
$Message       = '';

if ($CURUSER['class'] < $canViewAbos) {
    $naviSize = '540px';
}
else if ($CURUSER['class'] >= $canViewAbos && $CURUSER['class'] < $canEditConfig) {
    $naviSize = '625px';
}
else if ($CURUSER['class'] >= $canEditConfig) {
    $naviSize = '775px';
}

x264_header();

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-gamepad'></i> Lottery Navi
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
echo '<table class="table table-bordered table-striped table-condensed">
          <tr>
              <td>
                  <form name="naviInfo" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                  <input type="hidden" name="toDo" value="info" />
                  <input type="submit" value="&Uuml;bersicht" ' . ($toDo == 'info' ? 'class="btn btn-flat btn-primary fc-today-button"' : '') . ' />
                  </form>
              </td>
              <td>
                  <form name="naviAboCheck" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                  <input type="hidden" name="toDo" value="aboCheck" />
                  <input type="submit" value="Deine Abonnements" ' . ($toDo == 'aboCheck' || $toDo == 'aboManager' ? 'class="btn btn-flat btn-primary fc-today-button"' : '') . ' />
                  </form>
              </td>
              <td>
                  <form name="naviPayment" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                  <input type="hidden" name="toDo" value="payment" />
                  <input type="submit" value="Abonnements kaufen" ' . ($toDo == 'payment' ? 'class="btn btn-flat btn-primary fc-today-button"' : '') . ' />
                  </form>
              </td>
              <td>
                  <form name="naviLog" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                  <input type="hidden" name="toDo" value="log" />
                  <input type="submit" value="Lotterie Log" ' . ($toDo == 'log' ? 'class="btn btn-flat btn-primary fc-today-button"' : '') . ' />
                  </form>
              </td>
              <td>
                  <form name="naviFaq" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                  <input type="hidden" name="toDo" value="help" />
                  <input type="submit" value="F.A.Q." ' . ($toDo == 'help' ? 'class="btn btn-flat btn-primary fc-today-button"' : '') . ' />
                  </form>
              </td>';
if ($CURUSER['class'] >= $canEditConfig) {
    echo '    <td>
                  <form name="naviConfig" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                  <input type="hidden" name="toDo" value="config" />
                  <input type="submit" value="Lotterie Einstellungen" ' . ($toDo == 'config' ? 'class="btn btn-flat btn-primary fc-today-button"' : '') . ' />
                  </form>
              </td>';
}
if ($CURUSER['class'] >= $canViewAbos) {
    echo '    <td>
                  <form name="naviAdmin" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                  <input type="hidden" name="toDo" value="admin" />
                  <input type="submit" value="User Abos" ' . ($toDo == 'admin' ? 'class="btn btn-flat btn-primary fc-today-button"' : '') . ' />
                  </form>
              </td>';
}
echo '    </tr>
      </table>';
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";


switch ($toDo)
{
    case 'info' :
        $lotto       = NEW Lottery();
        $lastNumbers = $lotto->getLastNumbers();
        if ($lotto->getLottoActiveStatus() !== false) {
            $lottoDays    = $lotto->getDrawDays();
            $foreachCNT   = 1;
            $lottoDaysCnt = count($lottoDays);
            $daysToPlay   = '<br />Ziehungen sind am:<br />';
            $dayName = Array(0 => 'Sonntag',
                             1 => 'Montag',
                             2 => 'Dienstag',
                             3 => 'Mittwoch',
                             4 => 'Donnerstag',
                             5 => 'Freitag',
                             6 => 'Samstag'
                            ); 
            foreach ($lottoDays AS $lottoDay)
            {
                $daysToPlay .= $foreachCNT != $lottoDaysCnt ? '<b>' . $dayName[$lottoDay] . '</b>' . ($foreachCNT != $lottoDaysCnt - 1 ? ', ' : ' ') : ($lottoDaysCnt == 1 ? '' : 'und ').'<b>' . $dayName[$lottoDay].'</b>'; 
                ++$foreachCNT;
            }
            $daysToPlay .= ' jeweils um <b>' . $lotto->getWinHour() . ' Uhr</b>!'; 
        }
		print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-gamepad'></i> Lotterie &Uuml;bersicht f&uuml;r " . $lotto->getLottoName()  ." + Superzahl
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
        //begin_frame('Lotterie &Uuml;bersicht f&uuml;r ' . $lotto->getLottoName() . ($lotto->withSuperInt() !== false ? ' + Superzahl' : ''), true, '950px');
        echo '<br />
              <table cellspacing="0" align="center" style="width:438px;">
                  <tr>
                      <td class="table table-bordered table-striped table-condensed" style="border: 1px solid #CCCCCC; font-size: 12px;">Info</td>
                  </tr>
                  <tr>
                      <td style="font-size: 16px; text-align: left; height:90px; border: 1px solid #CCCCCC; color: #000000; background-color: #808080;">
                          ' . ($lotto->getLottoActiveStatus() !== false ? 'Die Lotterie ist <b>aktiv</b>!'. $daysToPlay : 'Zur Zeit ist die Lotterie nicht gestartet!<br />Schau sp&auml;ter nochmal rein.') . '
                      </td>
                  </tr>
              </table>
              <br />
              <table cellspacing="0" align="center" style="' . ($lotto->withSuperInt() !== false ? 'width:438px;' : 'width:388px;') . '">
                  <tr>
                      <td colspan="6" class="table table-bordered table-striped table-condensed" style="border: 1px solid #CCCCCC; font-size: 12px;">
                          Die letzten Zahlen vom 
                          ' . $lotto->getLastDrawing(true) . ' Uhr 
                      </td>
                      ' . ($lotto->withSuperInt() !== false ? '<td class="table table-bordered table-striped table-condensed" style="border: 1px solid #CCCCCC; font-size: 12px;">Superzahl</td>' : '') . '
                  </tr>
                  <tr >';
        foreach ($lastNumbers AS $lastNumber)
        {
            echo '<td style="border: 1px dotted #CCCCCC; font-weight: bold; font-size:14pt; color: #000000;  text-align: center; width: 61px; height: 61px; background-color:#808080; background-image:url(pic/kugel.png); background-repeat: no-repeat;">
                      ' . $lastNumber . '
                  </td>';
        }
        if ($lotto->withSuperInt() !== false) {
            echo '<td style="border: 1px dotted #FF0000; font-weight: bold; font-size:14pt; color: #000000;  text-align: center; width: 61px; height: 61px; background-color:#808080; background-image:url(pic/kugel.png); background-repeat: no-repeat;">
                      ' . $lotto->getLastSuperInt() . '
                  </td>';
        }
        echo '   </tr>
              </table>
              <br />
              <table cellspacing="0" align="center" style="width:438px;">
                  <tr>
                      <td colspan="3" class="table table-bordered table-striped table-condensed" style="border: 1px solid #CCCCCC; font-size: 12px;">Jackpot</td>
                  </tr>
                  <tr style="border: 1px solid #CCCCCC;">
                      <td style="border-left: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; margin-top: 0px; background-color:#808080; width: 120px; height: 187px; background-image:url(pic/geldhaufen.gif); background-repeat: no-repeat;">
                      <td style=" border-bottom: 1px solid #CCCCCC; margin-top: 0px; background-color:#808080; width:195px; color: #000000; font-weight:bold">
                          <span style="font-size: 17px; text-decoration: underline;"><blink>' . number_format($lotto->getJackpot() / 1024 / 1024 / 1024, 2) . ' GigaBytes</blink></span><br />
                          <br />
                          <span style="font-size: 13px;">' . number_format($lotto->getJackpot() / 1024 / 1024, 2) . ' MegaBytes</span><br /> 
                          <br />
                          <span style="font-size: 11px;">' . number_format($lotto->getJackpot() / 1024, 2) . ' KiloBytes</span><br /> 
                          <br />
                          <span style="font-size: 10px;">' . number_format($lotto->getJackpot(), 2) . ' Bytes</span>
                      </td>
                      <td style="border-bottom: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC; margin-top: 0px; background-color:#808080; width: 120px; height: 187px; background-image:url(pic/geldhaufen_right.gif); background-repeat: no-repeat;"></td>
                  </tr>
              </table>
              <br />
              <table cellspacing="0" align="center" style="width:438px;">
                  <tr>
                      <td class="table table-bordered table-striped table-condensed" style="border: 1px solid #CCCCCC; font-size: 12px;">Statistik</td>
                  </tr>
                  <tr>
                      <td style="font-size: 16px; vertical-align: top; text-align: left; height:140px; border: 1px solid #CCCCCC; color: #000000; background-color: #808080;">
                          Die Lotterie hatte bisher <b>' . $lotto->getDrawCount() . '</b> Ziehungen!
                          <br />
                          ' . ($lotto->getLastDrawing() > 0 ?  'Letzte Ziehung war am <b>' . $lotto->getLastDrawing(true) . ' Uhr</b>' :  '') . ' 
                          <br />
                          ' . ($lotto->getAboCount() > 0 ? 'Es sind zur Zeit <b>' . $lotto->getAboCount() . '</b> Abonnements gebucht,' : 'Es befinden sich zur Zeit keine Abonnements in der Lotterie!<br />Das bedeutet das Du gr&ouml;&szlig;ere Gewinnchancen hast!!') . '
                          <br />
                          ' . ($lotto->getAboCount() > 0 ?  ($lotto->getInactiveAbos() == 0 ? 'davon nehmen <b>alle</b> an der Verlosung teil!' : 'davon spielen <b>' . ($lotto->getInactiveAbos(true)) . '</b> Abos mit!' ) : '' ) . '
                          <br />
                          In <b>' . $lotto->getDrawCount() . '</b> Ziehungen haben <b>' . $lotto->getWinnerCount() . '</b> Lotterie Spieler insgesamt <b>' . $lotto->getJackpotOutput(true) . '</b> gewonnen!
                          ' . ($lotto->getWinnerCount() > 0 && $lotto->getJackpotOutput() > 0 ? 'Das entspricht im Ø <b>' .mksize($lotto->getJackpotOutput() / $lotto->getWinnerCount()).'</b> f&uuml;r jeden Gewinner!<br />' : '') . '
                      </td>
                  </tr>
              </table>
              <br />';
        print"	                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
    break;

    case 'aboCheck' :
        $lotto = NEW Lottery();
        if ($_POST['rebuildAbo'] == 'yes') {
            if (is_numeric($_POST['aboToRebuild']) && is_numeric($_POST['aboLength']) && is_numeric($_POST['aboPrice'])) {
                $rebuildAbo    = intval($_POST['aboToRebuild']);
                $rebuildLength = intval($_POST['aboLength']);
                $rebuildPrice  = $_POST['aboPrice'];
            }
            else {
                $Error   = true;
                $Message = 'Error: Die Werte sind fehlerhaft! Das waren keine Zahlen!!';
            }
            if ($rebuildPrice > $CURUSER['uploaded']) {
                $Error   = true;
                $Message = 'Error: Dein Upload reicht nicht aus! Dir fehlen '. mksize($rebuildPrice - $CURUSER['uploaded']) . '.';
            }
            if (!$Error) {
                $statsBuyAbo     = 'Abo Rebuild  (' . $rebuildLength . ' Ziehungen). Preis: ' . mksize($rebuildPrice);
                $statsIncoming   = 'Jackpot + ' . mksize($rebuildPrice) . ' durch Abo Rebuild!';
                $updateStatsAbo  = $lotto->insertStatsLogs('buyAbo', $CURUSER['id'], $rebuildAbo, $statsBuyAbo);
                $updateStatsInc  = $lotto->insertStatsLogs('incoming', $CURUSER['id'], $rebuildAbo, $statsIncoming);
                $decreaseUpload  = $lotto->updateUserUpload($CURUSER['id'], $rebuildPrice);
                $jackpotIncrease = $lotto->updateLotteryJackpot($rebuildPrice, true);
                $updateAbo       = mysql_query("UPDATE
                                                    `lotto_abonnement`
                                                SET
                                                    `abo_length` = " . $rebuildLength . "
                                                WHERE
                                                    `abo_id` = " . $rebuildAbo
                                              ) OR sqlerr(__FILE__,__LINE__);

                if ($decreaseUpload && $jackpotIncrease && $updateAbo && $updateStatsAbo && $updateStatsInc) {
                    $saveSuccess = true;
                    $Message     = 'Dein Abo wurde erfolgreich erneuert! Es wurden ' . mksize($rebuildPrice) . ' abgezogen.';
                }
                else {
                    $Error   = true;
                    $Message = 'Error: Beim speichern des Abonnement ist ein Fehler aufgetreten!';
                }                                              
            }
        }
        
        if ($_POST['delAbo'] == 'yes') {
            if (is_numeric($_POST['aboID']) && $_POST['aboID'] > 0) {
                $aboToDel = intval($_POST['aboID']);
            }
            else {
                $Error   = true;
                $Message = 'Error: Die Werte sind fehlerhaft! Das waren keine Zahlen!!';
            }
            if (!$Error) {
                $deleteAbo = mysql_query("DELETE FROM
                                              `lotto_abonnement`
                                          WHERE
                                              `abo_id` = " . $aboToDel . "
                                          LIMIT 1
                                        ") OR sqlerr(__FILE__,__LINE__);  
                $lotto       = NEW Lottery();
                $statsDelete = 'Abo entfernt! ID: ' . $aboToDel;
                $updateStats = $lotto->insertStatsLogs('deleteAbo', $CURUSER['id'], $aboToDel, $statsDelete);

                if ($deleteAbo && $updateStats) {
                    $saveSuccess = true;
                    $Message     = 'Dein Abonnement wurde erfolgreich entfernt.';
                }
                else {
                    $Error   = true;
                    $Message = 'Error: Beim entfernen ist ein Fehler aufgetreten!';
                }
            }
            
        }
        
        $haveAbo       = false;
        $aboCheckQuery = mysql_query("SELECT 
                                          * 
                                      FROM
                                          `lotto_abonnement`
                                      WHERE
                                          `abo_userID` = ".intval($CURUSER['id'])."
                                      ORDER BY 
                                          `abo_purchaseDate`
                                    ") OR sqlerr(__FILE__,__LINE__);
        if (mysql_num_rows($aboCheckQuery) > 0) {
            $haveAbo = true;
        }
        
        switch($haveAbo)
        {
            case false :
                $aboOutput = '<form name="aboPurchase" method="post" action="' . $_SERVER['PHP_SELF'] . '"> 
                              <input type="hidden" name="toDo" value="payment" />
                                  <table class="table table-bordered table-striped table-condensed" cellspacing="0" width="100%"> 
                                      <tr>
                                          <td>
                                              Du hast noch keine Lottorie Abonnements!
                                              <br />
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              <input type="submit" value="Abonnements kaufen!" />
                                          </td>
                                      </tr>
                                  </table>
                              </form>';
            break;
            
            case true :
                $aboCnt      = 1;
                $lenghtColor = '';
                $aboOutput   = '<table class="table table-bordered table-striped table-condensed" cellspacing="0" width="100%">
                                    <tr>
                                        <td>Nr.</td>
                                        <td>Kauf Datum</td>
                                        <td>Zahlen</td>
                                        <td>Gewonnen</td>
                                        <td>Gewinn</td>
                                        <td>Ziehungen</td>
                                        <td>mit Superzahl</td>
                                        <td>Info Message</td>
                                        <td>&nbsp;</td>
                                    </tr>';
                $winnerCount  = 0;
                $winningBytes = 0;
                $aboLengthAll = 0;
                while ($userAbo = mysql_fetch_assoc($aboCheckQuery))
                {
                    if ($userAbo['abo_length'] >= 0 && $userAbo['abo_length'] <= 6) {
                        $lenghtColor = '#CC0000';
                    }
                    else if ($userAbo['abo_length'] >= 7 && $userAbo['abo_length'] <= 15) {
                        $lenghtColor = '#FFFF00';
                    }
                    else if ($userAbo['abo_length'] >= 16 && $userAbo['abo_length'] <= 25) {
                        $lenghtColor = '#CCFF00';
                    }
                    else if ($userAbo['abo_length'] >= 26 && $userAbo['abo_length'] <= 35) {
                        $lenghtColor = '#99FF00';
                    }
                    else if ($userAbo['abo_length'] >= 36 && $userAbo['abo_length'] <= 45) {
                        $lenghtColor = '#66FF00';
                    }
                    else if ($userAbo['abo_length'] >= 46 && $userAbo['abo_length'] <= 55) {
                        $lenghtColor = '#33FF00';
                    }
                    else if ($userAbo['abo_length'] >= 56) {
                        $lenghtColor = '#00FF00';
                    }
                    $winningCount += $userAbo['abo_aboWonCount'];
                    $winningBytes += $userAbo['abo_aboWonBytes'];
                    $aboLengthAll += $userAbo['abo_length'];
                    $deadAbo       = false;
                    switch ($userAbo['abo_length'])
                    {
                        case 0  :
                            $deadAbo       = true;
                            $aboToBuyQuery = mysql_query("SELECT
                                                              `aboPack_desc`,
                                                              `aboPack_lenght`,
                                                              " . ($userAbo['abo_superIntActive'] == 'no' ? '`aboPack_price`,' : '`aboPack_priceSuperInt`,') . "
                                                              `aboPack_reduce`
                                                          FROM
                                                              `lotto_aboPacks`
                                                          WHERE
                                                              `aboPack_id` = " . $userAbo['abo_aboPackId']
                                                        ) OR sqlerr(__FILE__,__LINE__);
                            $aboToBuy = mysql_fetch_assoc($aboToBuyQuery);
                            
                            $formButton = '<form name="rebuildAbo_' . $userAbo['abo_id'] . '" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                               <input type="hidden" name="toDo" value="aboCheck" />
                                               <input type="hidden" name="rebuildAbo" value="yes" />
                                               <input type="hidden" name="aboToRebuild" value="' . $userAbo['abo_id'] . '" />
                                               <input type="hidden" name="aboLength" value="' . $aboToBuy['aboPack_lenght'] . '" />
                                               <input type="hidden" name="aboPrice" value="' . ($userAbo['abo_superIntActive'] == 'no' ? $aboToBuy['aboPack_price'] : $aboToBuy['aboPack_priceSuperInt']) . '"  />
                                               <input type="submit" value="Abo Erneuern!" onclick="return confirm(\''. $aboToBuy['aboPack_desc'] . ($userAbo['abo_superIntActive'] == 'yes' ? ' + Superzahl im Wert von ' . mksize($aboToBuy['aboPack_priceSuperInt']) :  ' im Wert von ' . mksize($aboToBuy['aboPack_price'])) . ' kaufen?\');" />
                                           </form>
                                           <br />
                                           <form name="delAbo_' . $userAbo['abo_id'] . '" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                               <input type="hidden" name="toDo" value="aboCheck" />
                                               <input type="hidden" name="delAbo" value="yes" />
                                               <input type="hidden" name="aboID" value="' . $userAbo['abo_id'] . '" />
                                               <input type="submit" value="Abo L&ouml;schen!" onclick="return confirm(\'Dein abgelaufenes Abo wirklich l&ouml;schen?\');" />
                                           </form>';
                        break;
                        default :
                            $formButton = '<form name="aboOption_' . $userAbo['abo_id'] . '" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                               <input type="hidden" name="toDo" value="aboManager" />
                                               <input type="hidden" name="aboID" value="' . $userAbo['abo_id'] . '" />
                                               <input type="submit" value="Abo Manager" />
                                           </form>';
                        break;
                    }
                    $showNumber = $userAbo['abo_userNumbers'] != NULL ? 
                                      str_replace(',', ', ', $userAbo['abo_userNumbers']) . ($userAbo['abo_superIntActive'] == 'yes' ? ' (' . $userAbo['abo_superInt'] . ')' : '')
                                      : 
                                      'Keine!';
                    $aboOutput .= '<tr>
                                       <td ' . ($deadAbo !== false ? 'style="background-color: #FF6142 ! important; text-decoration: line-through;"' : '') . '>' . $aboCnt . '.</td>
                                       <td ' . ($deadAbo !== false ? 'style="background-color: #FF6142 ! important; text-decoration: line-through;"' : '') . '>' . strftime("%d.%m.%Y - %H:%M",$userAbo['abo_purchaseDate']) . ' Uhr</td>
                                       <td ' . ($deadAbo !== false ? 'style="background-color: #FF6142 ! important; text-decoration: line-through;"' : '') . '>' . $showNumber . '</td>
                                       <td ' . ($deadAbo !== false ? 'style="background-color: #FF6142 ! important; text-decoration: line-through;"' : '') . '>' . $userAbo['abo_aboWonCount'] . ' mal</td>
                                       <td ' . ($deadAbo !== false ? 'style="background-color: #FF6142 ! important; text-decoration: line-through;"' : '') . '>' . mksize($userAbo['abo_aboWonBytes']) . '</td>
                                       <td style="color:' . $lenghtColor . '; ' . ($deadAbo !== false ? 'background-color: #FF6142 ! important;' : '') . ' ">' . intval($userAbo['abo_length']) . '</td>
                                       <td ' . ($deadAbo !== false ? 'class="btn btn-flat btn-primary fc-today-button"' : '') . '><img src="/pic/superIntActive_' . $userAbo['abo_superIntActive'] . '.png" title="Superzahl ist ' . ($userAbo['abo_superIntActive'] == 'no' ? 'nicht ' : '') . 'gebucht!" /></td>
                                       <td ' . ($deadAbo !== false ? 'class="btn btn-flat btn-primary fc-today-button"' : '') . '><img src="/pic/pm_notifs_' . $userAbo['abo_infoMessage'] . '.png" title="Benachrichtigung ' . ($userAbo['abo_infoMessage'] == 'yes' ? 'eingeschaltet' : 'ausgeschaltet') . '" /></td>
                                       <td ' . ($deadAbo !== false ? 'class="btn btn-flat btn-primary fc-today-button"' : '') . '>' . $formButton . '</td>
                                   </tr>';
                    $aboCnt++;
                }
                $aboOutput .= '    <tr>
                                       <td style="border-bottom: none ! important;">Ø</td>
                                       <td style="border-bottom: none ! important;">&nbsp;</td>
                                       <td style="border-bottom: none ! important;">&nbsp;</td>
                                       <td style="border-bottom: none ! important;">insg. ' . $winningCount . '</td>
                                       <td style="border-bottom: none ! important;">insg. ' . mksize($winningBytes) . '</td>
                                       <td style="border-bottom: none ! important;">insg. ' . $aboLengthAll . '</td>
                                       <td style="border-bottom: none ! important;">&nbsp;</td>
                                       <td style="border-bottom: none ! important;">&nbsp;</td>
                                       <td style="border-bottom: none ! important;">&nbsp;</td>
                                   </tr>
                                   <tr>
                                       <td colspan="9" align="center" style="border-bottom: none ! important;">
                                           <form name="aboPurchase" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                               <br />
                                               <input type="hidden" name="toDo" value="payment" />
                                               <input type="submit" value="Weitere Abonnements kaufen!" style="width:190px ! important;"/>
                                           </form>
                                       </td>
                                   </tr>
                               </table>';     
            break;
        }
		print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-gamepad'></i> Deine Lotterie Abonnements
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
        //begin_frame('Deine Lotterie Abonnements', false, '950px');
        echo $aboOutput;
        print"	                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
    break;

    case 'aboManager' :
        $canChangeNumber = false;
        if (is_numeric($_POST['aboID'])) {
            $aboIdToManage = intval($_POST['aboID']);
        }
        else {
            $Error   = true;
            $Message = 'Error: Die Werte sind fehlerhaft! Das waren keine Zahlen!!';
        }
        if ($_POST['saveNumbers'] == 'yes') {
            $lottoNumbers = $_POST['lottoNumbers'];
            $numberCNT    = count(explode(',',$lottoNumbers));
            $superInt     = $_POST['superInt'];
            $superIntActive = $_POST['superIntActive'] == 'yes' ? 'yes' : 'no';
            if ($numberCNT < 6) {
                $Error   = true;
                $Message = 'Error: Du musst 6 Zahlen markieren! Versuche es erneut.';
            }
            if ($superInt < 0 || $superInt > 9) {
                $Error   = true;
                $Message = 'Error: Die Werte sind fehlerhaft! Ausserhalb des Zahlenbereichs!!';
            }
            if ($superInt == NULL && $_POST['superIntActive'] == 'yes') {
                $Error   = true;
                $Message = 'Error: Gebe eine Superzahl an! Versuche es erneut.';
            }
            if (!$Error) {
                switch ($superIntActive)
                {
                    case 'no'  :
                        $updateNumbers = mysql_query("UPDATE
                                                          `lotto_abonnement`
                                                      SET
                                                          `abo_userNumbers`      = " . sqlesc($lottoNumbers) . ",
                                                          `abo_lastNumberChange` = " . time() . "
                                                      WHERE
                                                          `abo_id` = " . $aboIdToManage
                                                    ) OR sqlerr(__FILE__,__LINE__);
                        if ($updateNumbers) {
                            $saveSuccess = true;
                            $Message     = 'Deine Lottozahlen (' . str_replace(',', ', ', $lottoNumbers) . ') wurden erfolgreich gespeichert!';
                        }
                        else {
                            $Error   = true;
                            $Message = 'Error: Beim speichern ist ein Fehler aufgetreten!';
                        }
                    break;
                
                    case 'yes' :
                        $updateNumbers = mysql_query("UPDATE
                                                          `lotto_abonnement`
                                                      SET
                                                          `abo_userNumbers`      = " . sqlesc($lottoNumbers) . ",
                                                          `abo_superInt`         = " . $superInt . ",
                                                          `abo_lastNumberChange` = " . time() . "
                                                      WHERE
                                                          `abo_id` = " . $aboIdToManage
                                                    ) OR sqlerr(__FILE__,__LINE__);
                        if ($updateNumbers) {
                            $saveSuccess = true;
                            $Message     = 'Deine Lottozahlen (' . str_replace(',', ', ', $lottoNumbers) . ') + Superzahl (' . $superInt . ') wurden erfolgreich gespeichert!';
                        }
                        else {
                            $Error   = true;
                            $Message = 'Error: Beim speichern ist ein Fehler aufgetreten!';
                        }
                    break;
                }
            }
        }
        
        if ($_POST['changeInfo']) {
            $infoMessage  = $_POST['changeInfo'] == 'yes' ? 'yes' : 'no';
            $updateOption = mysql_query("UPDATE
                                             `lotto_abonnement`
                                         SET
                                             `abo_infoMessage` = '" . $infoMessage . "'
                                         WHERE
                                             `abo_id` = " . $aboIdToManage
                                       ) OR sqlerr(__FILE__,__LINE__);
            if ($updateOption) {
                $saveSuccess = true;
                $Message     = $infoMessage == 'yes' ? 'Benachrichtigung erfolgreich eingeschaltet!' : 'Benachrichtigung erfolgreich ausgeschaltet!';
            }
            else {
                $Error   = true;
                $Message = 'Error: Beim speichern ist ein Fehler aufgetreten!';
            }
        }
        
        if ($_POST['buySuperInt'] == 'yes') {
            $lotto          = NEW Lottery();
            $priceInB       = intval($_POST['realPrice']);
            $draws          = intval($_POST['drawsLeft']);
            $statsBuyAbo    = 'Abo Kauf (' . $draws . ' x Superzahl einzeln). Preis: ' . mksize($priceInB);
            $statsIncoming  = 'Jackpot + ' . mksize($priceInB) . ' durch Superzahl kauf!';
            $updateStatsAbo = $lotto->insertStatsLogs('buyAbo', $CURUSER['id'], $aboIdToManage, $statsBuyAbo);
            $updateStatsInc = $lotto->insertStatsLogs('incoming', $CURUSER['id'], $aboIdToManage, $statsIncoming);
            $userUpdate     = $lotto->updateUserUpload($CURUSER['id'], $priceInB);
            $jackpotUpdate  = $lotto->updateLotteryJackpot($priceInB, true);
            $aboUpdate      = mysql_query("UPDATE
                                               `lotto_abonnement`
                                           SET
                                               `abo_superIntActive` = 'yes'
                                           WHERE
                                               `abo_id` = " . $aboIdToManage
                                         ) OR sqlerr(__FILE__,__LINE__);

            if ($userUpdate && $jackpotUpdate && $aboUpdate && $updateStatsAbo && $updateStatsInc) {
                $saveSuccess = true;
                $Message     = 'Superzahl im Wert von '. mksize($priceInB) .' gekauft! (' . $draws . ' Ziehungen)';
            }
            else {
                $Error   = true;
                $Message = 'Error: Beim speichern ist ein Fehler aufgetreten!';
            }
        }
         
        if ($aboIdToManage) {
            $aboToManageQuery = mysql_query("SELECT
                                                 *
                                             FROM
                                                 `lotto_abonnement`
                                             WHERE
                                                 `abo_id` = " . $aboIdToManage
                                           ) OR sqlerr(__FILE__,__LINE__);
            $abo = mysql_fetch_assoc($aboToManageQuery);
             
            $dayNow        = date("j", time());
            $monthNow      = date("n", time());
            $dayLastDraw   = date("j", $abo['abo_lastNumberChange']);
            $monthLastDraw = date("n", $abo['abo_lastNumberChange']);
            
            if (($dayNow != $dayLastDraw || $dayNow == $dayLastDraw && $monthLastDraw != $monthNow) && $abo['abo_length'] > 0) {
                $canChangeNumber = true;    
            }

            if ($abo['abo_superIntActive'] == 'no') { 
                $superIntDay = 52428800; // 50 mb
                $drawsLeft   = $abo['abo_length'];
                $price       = $drawsLeft * $superIntDay;
                $tenPercent  = $price / 100 * 10; // wollen ja ne "arbeits entschaedigung haben die mit in den jackpot geht"
                $realPrice   = $price + $tenPercent;
                
                if ($realPrice < $CURUSER['uploaded']) {
                    $buyButton   = '<br />
                                    <form name="buySuperInt" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                        <input type="hidden" name="toDo" value="aboManager" />
                                        <input type="hidden" name="aboID" value="' . $abo['abo_id'] . '" />
                                        <input type="hidden" name="buySuperInt" value="yes" />
                                        <input type="hidden" name="drawsLeft" value="' . $drawsLeft . '" />
                                        <input type="hidden" name="realPrice" value="' . $realPrice . '" />
                                        <input type="submit" value="Superzahl buchen" onclick="return confirm(\'Das kostet Dich (' . mksize($price) . ') + 10% Aufwandskosten. Es wird mit in den Jackpot gelegt! \');" />
                                    </form>';
                }
            }
            		print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-gamepad'></i> Deine Abo Einstellungen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
            //begin_frame('Deine Abo Einstellungen', false, '950px');
            echo '<table cellspacing="0" width="100%" align="center">
                      <tr>
                          <td width="50%" valign="top">
                              <table class="table table-bordered table-striped table-condensed" cellspacing="0" width="100%">
                                  <tr>
                                      <td colspan="2" class="table table-bordered table-striped table-condensed" style="color: #FFFFFF ! important; border: 1px solid #cccccc ! important;" align="center">&Uuml;berblick</td>
                                  </tr>
                                  <tr>
                                      <td>Kaufdatum:</td>
                                      <td>' . strftime("%d.%m.%Y - %H:%M",$abo['abo_purchaseDate']) . ' Uhr</td>
                                  </tr>
                                  <tr>
                                      <td>Abo mit Superzahl:</td>
                                      <td>' . ($abo['abo_superIntActive'] == 'yes' ? 'Superzahl ist aktiv' : 'Superzahl ist nicht gebucht '.$buyButton) . '</td>
                                  </tr>
                                  <tr>
                                      <td>Verbleibende Ziehungen:</td>
                                      <td>' . $abo['abo_length'] . '</td>
                                  </tr>
                                  <tr>
                                      <td>Benachrichtigung:</td>
                                      <td>' . ($abo['abo_infoMessage'] == 'yes' ? 'Du wirst per PM informiert!' : 'Du wirst nicht informiert!') . '</td>
                                  </tr>
                                  <tr>
                                      <td>Letzte Ziehung am:</td>
                                      <td>' . ($abo['abo_lastDrawing'] > 0 ? strftime("%d.%m.%Y - %H:%M",$abo['abo_lastDrawing']).' Uhr' : 'Das Los hat noch nicht gespielt!') . '</td>
                                  </tr>
                                  <tr>
                                      <td>Zahlen zuletzt ge&auml;ndert:</td>
                                      <td>' . ($abo['abo_lastNumberChange'] > 0 ? strftime("%d.%m.%Y - %H:%M",$abo['abo_lastNumberChange']).' Uhr' : 'Zahlen wurden noch nie ge&auml;ndert') . '</td>
                                  </tr>
                                  <tr>
                                      <td>Deine Lottozahlen:</td>
                                      <td>' . ($abo['abo_userNumbers'] != '' ? str_replace(',', ', ',$abo['abo_userNumbers']) : 'Zahlen wurden noch nicht angegeben!') . '</td>
                                  </tr>
                                  <tr>
                                      <td>Deine Superzahl:</td>
                                      <td>' . ($abo['abo_superIntActive'] == 'yes' ? $abo['abo_superInt'] : 'Superzahl ist nicht gebucht!') . '</td>
                                  </tr>
                                  <tr>
                                      <td colspan="2" class="table table-bordered table-striped table-condensed" style="color: #FFFFFF ! important; border: 1px solid #cccccc ! important;" align="center">Einstellungen</td>
                                  </tr>
                                  <tr>
                                      <td>
                                          <acronym style="cursor: help;" title="Beschreibung?" onclick="toggle(\'messageInfo\');">Benachrichtigung:</acronym>
                                      </td>
                                      <td>
                                          <form name="changeOption" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                              <input type="hidden" name="toDo" value="aboManager" />
                                              <input type="hidden" name="aboID" value="' . $abo['abo_id'] . '" />
                                              <input type="radio" name="changeInfo" value="yes" ' . ($abo['abo_infoMessage'] == 'yes' ? 'checked="checked"' : '') . ' /> Aktiviert
                                              <input type="radio" name="changeInfo" value="no"  ' . ($abo['abo_infoMessage'] == 'no'  ? 'checked="checked"' : '') . ' /> Deaktiviert
                                              <br /><br /><input type="submit" value="&Auml;nderung speichern" />
                                          </form>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td colspan="2">
                                          <div id="messageInfo" style="display: none; font-family: Verdana;">
                                              <br />
                                              Bei eingeschalteter Benachrichtigung wirst Du &uuml;ber folgende<br />
                                              Aktionen informiert:<br />
                                              <br />
                                              • Du gewinnst im Lotto mit mindestens 1 richtigen Zahl.<br />
                                              • Du hast bis 1 Stunde vor Ziehung Deine Zahlen nicht<br />&nbsp;&nbsp;&nbsp;angegeben oder zuletzt vor einem Tag ge&auml;ndert.
                                          </div>
                                      </td>
                                  </tr>
                              </table>
                          </td>
                          <td width="50%">
                              <table cellspacing="0" style="text-align: center; width:100%;">
                                  <tr>
                                      <td class="table table-bordered table-striped table-condensed" style="border: 1px solid #cccccc ! important; font-weight: bold; color: #ffffff">Dein Lottoschein</td>
                                  </tr>
                                  <tr>
                                      <td>
                                          <table class="table table-bordered table-striped table-condensed">
                                              <tr>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                                  <td id="z1"  onclick="DClotto.lottoclick(this, 1);">1</td>
                                                  <td id="z2"  onclick="DClotto.lottoclick(this, 2);">2</td>
                                                  <td id="z3"  onclick="DClotto.lottoclick(this, 3);">3</td>
                                                  <td id="z4"  onclick="DClotto.lottoclick(this, 4);">4</td>
                                                  <td id="z5"  onclick="DClotto.lottoclick(this, 5);">5</td>
                                                  <td id="z6"  onclick="DClotto.lottoclick(this, 6);">6</td>
                                                  <td id="z7"  onclick="DClotto.lottoclick(this, 7);">7</td>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                              </tr>
                                              <tr>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                                  <td id="z8"  onclick="DClotto.lottoclick(this, 8);">8</td>
                                                  <td id="z9"  onclick="DClotto.lottoclick(this, 9);">9</td>
                                                  <td id="z10" onclick="DClotto.lottoclick(this, 10);">10</td>
                                                  <td id="z11" onclick="DClotto.lottoclick(this, 11);">11</td>
                                                  <td id="z12" onclick="DClotto.lottoclick(this, 12);">12</td>
                                                  <td id="z13" onclick="DClotto.lottoclick(this, 13);">13</td>
                                                  <td id="z14" onclick="DClotto.lottoclick(this, 14);">14</td>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                              </tr>
                                              <tr>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                                  <td id="z15" onclick="DClotto.lottoclick(this, 15);">15</td>
                                                  <td id="z16" onclick="DClotto.lottoclick(this, 16);">16</td>
                                                  <td id="z17" onclick="DClotto.lottoclick(this, 17);">17</td>
                                                  <td id="z18" onclick="DClotto.lottoclick(this, 18);">18</td>
                                                  <td id="z19" onclick="DClotto.lottoclick(this, 19);">19</td>
                                                  <td id="z20" onclick="DClotto.lottoclick(this, 20);">20</td>
                                                  <td id="z21" onclick="DClotto.lottoclick(this, 21);">21</td>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                              </tr>
                                              <tr>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                                  <td id="z22" onclick="DClotto.lottoclick(this, 22);">22</td>
                                                  <td id="z23" onclick="DClotto.lottoclick(this, 23);">23</td>
                                                  <td id="z24" onclick="DClotto.lottoclick(this, 24);">24</td>
                                                  <td id="z25" onclick="DClotto.lottoclick(this, 25);">25</td>
                                                  <td id="z26" onclick="DClotto.lottoclick(this, 26);">26</td>
                                                  <td id="z27" onclick="DClotto.lottoclick(this, 27);">27</td>
                                                  <td id="z28" onclick="DClotto.lottoclick(this, 28);">28</td>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                              </tr>
                                              <tr>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                                  <td id="z29" onclick="DClotto.lottoclick(this, 29);">29</td>
                                                  <td id="z30" onclick="DClotto.lottoclick(this, 30);">30</td>
                                                  <td id="z31" onclick="DClotto.lottoclick(this, 31);">31</td>
                                                  <td id="z32" onclick="DClotto.lottoclick(this, 32);">32</td>
                                                  <td id="z33" onclick="DClotto.lottoclick(this, 33);">33</td>
                                                  <td id="z34" onclick="DClotto.lottoclick(this, 34);">34</td>
                                                  <td id="z35" onclick="DClotto.lottoclick(this, 35);">35</td>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                              </tr>
                                              <tr>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                                  <td id="z36" onclick="DClotto.lottoclick(this, 36);">36</td>
                                                  <td id="z37" onclick="DClotto.lottoclick(this, 37);">37</td>
                                                  <td id="z38" onclick="DClotto.lottoclick(this, 38);">38</td>
                                                  <td id="z39" onclick="DClotto.lottoclick(this, 39);">39</td>
                                                  <td id="z40" onclick="DClotto.lottoclick(this, 40);">40</td>
                                                  <td id="z41" onclick="DClotto.lottoclick(this, 41);">41</td>
                                                  <td id="z42" onclick="DClotto.lottoclick(this, 42);">42</td>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                              </tr>
                                              <tr>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                                  <td id="z43" onclick="DClotto.lottoclick(this, 43);">43</td>
                                                  <td id="z44" onclick="DClotto.lottoclick(this, 44);">44</td>
                                                  <td id="z45" onclick="DClotto.lottoclick(this, 45);">45</td>
                                                  <td id="z46" onclick="DClotto.lottoclick(this, 46);">46</td>
                                                  <td id="z47" onclick="DClotto.lottoclick(this, 47);">47</td>
                                                  <td id="z48" onclick="DClotto.lottoclick(this, 48);">48</td>
                                                  <td id="z49" onclick="DClotto.lottoclick(this, 49);">49</td>
                                                  <td style="background-image: none ! important; cursor: default ! important;">&nbsp;</td>
                                              </tr>
                                          </table>
                                          <br />
                                          <table class="table table-bordered table-striped table-condenseds" ' . ($abo['abo_superIntActive'] == 'no' ? 'style="display:none;"' : '') . '>
                                              <tr>
                                                  <th colspan="10" style="text-align:center;font-size:25px;letter-spacing:8px;">S U P E R Z A H L</th>
                                              </tr>
                                              <tr>
                                                  <td id="sz0" onclick="DClotto.sZahl(this, 0);">0</td>
                                                  <td id="sz1" onclick="DClotto.sZahl(this, 1);">1</td>
                                                  <td id="sz2" onclick="DClotto.sZahl(this, 2);">2</td>
                                                  <td id="sz3" onclick="DClotto.sZahl(this, 3);">3</td>
                                                  <td id="sz4" onclick="DClotto.sZahl(this, 4);">4</td>
                                                  <td id="sz5" onclick="DClotto.sZahl(this, 5);">5</td>
                                                  <td id="sz6" onclick="DClotto.sZahl(this, 6);">6</td>
                                                  <td id="sz7" onclick="DClotto.sZahl(this, 7);">7</td>
                                                  <td id="sz8" onclick="DClotto.sZahl(this, 8);">8</td>
                                                  <td id="sz9" onclick="DClotto.sZahl(this, 9);">9</td>
                                              </tr>
                                          </table>
                                          <br />
                                          <form name="lottoNumbers" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                          <input type="hidden" name="toDo" value="aboManager" />
                                          <input type="hidden" name="aboID" value="' . $abo['abo_id'] . '" />
                                          <input type="hidden" name="superIntActive" value="' . $abo['abo_superIntActive'] . '" />
                                          <input type="hidden" name="saveNumbers" value="yes" />
                                              <table class="lottoform">
                                                  <tr>
                                                      <td>Lotto Zahlen</td>
                                                      <td>&nbsp;:&nbsp;<input type="text" name="lottoNumbers" id="lottochoise" size="15" readonly="readonly" /></td>
                                                  </tr>
                                                  <tr ' . ($abo['abo_superIntActive'] == 'no' ? 'style="display:none;"' : '') . '>
                                                      <td>Superzahl</td>
                                                      <td>&nbsp;:&nbsp;<input type="text" name="superInt" id="lottoszahl" size="2" readonly="readonly" /></td>
                                                  </tr>
                                                  <tr>
                                                      <td colspan="2" style="text-align: center;">
                                                          <input type="button" onclick="DClotto.lottoZufall();" value="Zufall" ' . ($canChangeNumber !== false ? '' : 'disabled="disabled"') . ' />
                                                          <input type="button" onclick="DClotto.lottoReset();" value="Zur&uuml;cksetzten" ' . ($canChangeNumber !== false ? '' : 'disabled="disabled"') . ' />
                                                          <input type="submit" value="' . ($canChangeNumber !== false ? 'Zahlen speichern!' : 'Zahlen wurden heute ge&auml;ndert!') . '" onclick="return confirm(\'Achtung: Du kannst nur einmal am Tag die zahlen &auml;ndern!\');" ' . ($canChangeNumber !== false ? '' : 'disabled="disabled"') . ' />
                                                      </td>
                                                  </tr>
                                              </table>
                                          </form>
                                      </td>
                                  </tr>
                              </table>                               
                          </td>
                      </tr>
                  </table>';
            print"	                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
         }
    break;

    case 'payment' :
        $lotto = NEW Lottery();
        if ($_POST['buyAbo'] == 'buy') {
            if ($lotto->getLottoActiveStatus() === false) {
                $Error   = true;
                $Message = 'Die Lotterie ist zur Zeit deaktiviert! Bei Fragen wende Dich an den Staff.';
            }
            if (is_numeric($_POST['price']) && is_numeric($_POST['aboLength'])) {
                $aboPrice  = $_POST['price'];
                $aboLength = intval($_POST['aboLength']);    
            }
            else {
                $Error   = true;
                $Message = 'Error: Die Werte sind fehlerhaft! Das waren keine Zahlen!!';
            }
            if ($aboPrice > $CURUSER['uploaded']) {
                $Error   = true;
                $Message = 'Dein Upload reicht nicht aus! Dir fehlen ' . mksize($aboPrice - $CURUSER['uploaded']) . '!';
            }
            if (is_numeric($_POST['aboPackId']) || $_POST['aboPackId'] >= 0 ) {
                $aboPackId = intval($_POST['aboPackId']);
            }
            else {
                $Error   = true;
                $Message = 'Error: Die Werte sind fehlerhaft! Das waren keine Zahlen!!';
            }
            $superInt  = $_POST['superInt'] == 'yes' ? 'yes' : 'no';
            if (!$Error) {
                $insertAbo     = mysql_query("INSERT INTO
                                                  `lotto_abonnement`
                                              SET
                                                  `abo_userID`         = " . intval($CURUSER['id']) . ",
                                                  `abo_aboPackId`      = " . $aboPackId . ",
                                                  `abo_purchaseDate`   = " . time() . ",
                                                  `abo_length`         = " . $aboLength . ",
                                                  `abo_superIntActive` = '" . $superInt . "'
                                            ") OR sqlerr(__FILE__,__LINE__);
                $newAboID       = mysql_insert_id();
                $updateUser     = $lotto->updateUserUpload($CURUSER['id'], $aboPrice);
                $updateJackpot  = $lotto->updateLotteryJackpot($aboPrice, true);
                $statsIncoming  = 'Jackpot + '. mksize($aboPrice) . ' durch ein Abo Kauf!';
                $statsBuyAbo    = 'Abo Kauf: ' . $aboLength . ' Ziehungen! ' . ($superInt == 'yes' ? 'Mit Superzahl!' : '') . ' Preis: ' . mksize($aboPrice);
                $updateStatsAbo = $lotto->insertStatsLogs('buyAbo', $CURUSER['id'], $newAboID, $statsBuyAbo);
                $updateStatsInc = $lotto->insertStatsLogs('incoming', $CURUSER['id'], $newAboID, $statsIncoming);

                if ($insertAbo && $updateUser && $updateJackpot && $updateStatsAbo && $updateStatsInc) {
                    $saveSuccess = true;
                    $Message     = 'Abonnement erfolgreich gekauft! Es wurden ' . mksize($_POST['price']) . ' vom Upload abgezogen! Gehe nun zu Deine Abonnements -> Abo Manager um die Zahlen zu bestimmen!';
                }
                else {
                    $Error   = true;
                    $Message = 'Error: Beim buchen des Abonnements ist ein Fehler aufgetreten!';
                }
            }       
        }
        $availableAbos = mysql_query("SELECT
                                          *
                                      FROM
                                          `lotto_aboPacks`
                                      ORDER BY
                                          `aboPack_lenght`
                                    ") OR sqlerr(__FILE__,__LINE__);
        
		print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-gamepad'></i> Abonnement Verkauf
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
        //begin_frame('Abonnement Verkauf',false,'950px');
        echo '<table class="table table-bordered table-striped table-condensed" cellspacing="0" width="100%">
                  <tr>
                      <td>&nbsp;<img id="img_help" onclick="toggle(\'help\');"  src="pic/visible.png" style="cursor: pointer;" /> <span onclick="toggle(\'help\');" style="cursor:help;font-weight: bold;">&nbsp;Beschreibung / Hilfe</span></td>
                  </tr>
                  <tr id="help" style="display:none;">
                      <td style="border-bottom: none;">
                          <br />
                          Beschreibung:<br />
                          - Klassische Lotterie nach 6 aus 49 mit Superzahl!<br />
                          - Dein Abo kannst du mit oder ohne Superzahl kaufen!<br />
                          <br />
                          Hilfe:<br />
                          - Lose die Du gekauft hast kannst Du nicht mehr umtauschen!<br />
                          - Du kannst einmal am Tag deine Zahlenkombination &auml;ndern!<br />
                          - Die Abonnement dauer sind nicht Tage sondern Ziehungen!<br />
                          - Achte beim kauf eines Abonnements auf die richtige Wahl!<br />
                          - Umso l&auml;nger ein Abonnement ist, umso mehr sparst du beim Kaufpreis!<br />
                          - Du hast ein Abo ohne Superzahl? Im Abo Manager kannst Du die Superzahl nachtr&auml;glich kaufen!<br />
                          <br />
                          Ungekl&auml;rte Fragen? Schau in die F.A.Q. oder wende Dich freundlich an das Team.<br /><br />
                      </td>
                  </tr>
              </table>
              <table class="paymenttable" cellspacing="0" width="100%">
                  <tr class="table table-bordered table-striped table-condensed">
                      <td>Ziehungen</td>
                      <td>Preis</td>
                      <td>Preis incl. Superzahl</td>
                      <td>Ersparniss</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                  </tr>';
              
        if ($lotto->getLottoActiveStatus() !== false) {
            if (mysql_num_rows($availableAbos) > 0) {
                $reduceColor = '';
                while ($abo = mysql_fetch_assoc($availableAbos))
                {
                    switch ($abo['aboPack_reduce'])
                    {
                        case '10.0' :
                            $reduceColor = '#FFFF00';
                        break;
                        case '12.5' :
                            $reduceColor = '#CCFF00';
                        break;
                        case '15.0' :
                            $reduceColor = '#99FF00';
                        break;
                        case '17.5' :
                            $reduceColor = '#66FF00';
                        break;
                        case '20.0' :
                            $reduceColor = '#33FF00';
                        break;
                        case '25.0' :
                            $reduceColor = '#00FF00';
                        break;
                        default     :
                            $reduceColor = '#FF0000';
                        break;
                    }
                    echo '<tr>
                              <td>' . $abo['aboPack_desc'] . '</td>
                              <td>' . mksize($abo['aboPack_price']) . '</td>
                              <td>' . mksize($abo['aboPack_priceSuperInt']) . '</td>
                              <td style="color: ' . $reduceColor . '">' . ($abo['aboPack_reduce'] == '00.0' ? '0%' : $abo['aboPack_reduce'].'%') . '</td>
                              <td>
                                  <form name="buyThisAbo_' . $abo['aboPack_id'] . '" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                      <input type="hidden" name="toDo" value="payment" />
                                      <input type="hidden" name="buyAbo" value="buy" />
                                      <input type="hidden" name="aboPackId" value="' . $abo['aboPack_id'] . '" />
                                      <input type="hidden" name="price" value="' . $abo['aboPack_price'] . '" />
                                      <input type="hidden" name="superInt" value="no" />
                                      <input type="hidden" name="aboLength" value="' . $abo['aboPack_lenght'] . '" />
                                      <input type="submit" value="Abo ohne Superzahl kaufen" ' . ($abo['aboPack_price'] > $CURUSER['uploaded'] ? 'disabled="disabled"' : '') . ' />
                                  </form>
                              </td>
                              <td>
                                  <form name="buyThisAboSuperInt_' . $abo['aboPack_id'] . '" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                      <input type="hidden" name="toDo" value="payment" />
                                      <input type="hidden" name="buyAbo" value="buy" />
                                      <input type="hidden" name="aboPackId" value="' . $abo['aboPack_id'] . '" />
                                      <input type="hidden" name="price" value="' . $abo['aboPack_priceSuperInt'] . '" />
                                      <input type="hidden" name="superInt" value="yes" />
                                      <input type="hidden" name="aboLength" value="' . $abo['aboPack_lenght'] . '" />
                                      <input type="submit" value="' . ($lotto->withSuperInt() !==  false ? 'Abo mit Superzahl kaufen' : 'Abo mit Superzahl ist deaktiviert') . '" ' . ($abo['aboPack_priceSuperInt'] > $CURUSER['uploaded'] || $lotto->withSuperInt() ===  false ? 'disabled="disabled"' : '') . ' />
                                  </form>
                              </td>
                          </tr>';
                } 
            }
            else {
                $Error    = true;
                $Message  = 'Zur Zeit wurden keine keine Lotto-Abonnements gefunden!';
                echo '<tr>
                          <td colspan="6">Zur Zeit wurden keine Lotto-Abonnements gefunden!</td>
                      </tr>';
            } 
        }
        else {
            $Error   = true;
            $Message = 'Zur Zeit ist die Lotterie deaktiviert! Bei Fragen wende Dich an den Staff.';
            echo '<tr>
                      <td colspan="6">Zur Zeit ist die Lotterie deaktiviert! Bei Fragen wende Dich an den Staff.</td>
                  </tr>';
        }
        echo '</table>';
        print"	                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
    break;

    case 'log' :
        $queryMe       = isset($_POST['queryMe'])       ? $_POST['queryMe']       : 10;
        $jackpotValues = isset($_POST['jackpotValues']) ? $_POST['jackpotValues'] :  1;
        $classChoose   = $_POST['classChoose'];
        $canViewAll    = false;
        $constants     = get_defined_constants();
        $classOption   = '<select name="classChoose" style="color: #000000; font-weight: bold; background-color: #eeeeee;">
                              <option value="">Alle R&auml;nge</option>';
        foreach (array_keys($constants) AS $x)
        {
           if (substr($x,0,3) == "UC_") {
               if ($x != 'UC_SUPERUPLOADER' && $x != 'UC_CO_ADMIN') {
                   $classOption .='<option value="' . constant($x) . '" ' . (constant($x) == $classChoose ? 'selected="selected"' : '') . '>' . get_user_class_name(constant($x)) . '</option>';
               }
           }
        }
        $classOption .= '</select>';
         
        switch ($_POST['direction'])
        {
            case 'forward' :
                $jackpotValues < 7 ? $jackpotValues++ : $jackpotValues = 1 ;
            break;
            case 'back'    :
                $jackpotValues > 1 ? $jackpotValues-- : $jackpotValues = 7 ;
            break;
            default :
            break;
        }
        switch ($queryMe)
        {
            case  0  :
                $limit = '';
            break;
            case 10  :
                $limit = 'LIMIT 10';
            break;
            case 25  :
                $limit = 'LIMIT 25';
            break;
            case 50  :
                $limit = 'LIMIT 50';
            break;
            case 75  :
                $limit = 'LIMIT 75';
            break;
        }
        switch ($jackpotValues)
        {
            case 1 :
                $titleDesc      = ' (Keine Sortierung)';
                $ButtonBack     = 'Gel&ouml;schte Abos';
                $ButtonForward  = 'Einnahmen';
                $whereWithValue = '';
            break;
            case 2 :
                $titleDesc      = ' (Einnahmen)';
                $ButtonBack     = 'Keine Sortierung'; 
                $ButtonForward  = 'Ausgaben';
                $whereWithValue = "WHERE `ls`.`stats_event` = 'incoming'";
            break;
            case 3 :
                $titleDesc      = ' (Ausgaben)';
                $ButtonBack     = 'Einnahmen';
                $ButtonForward  = 'Gewinner';
                $whereWithValue = "WHERE `ls`.`stats_event` = 'outgoing'";
            break;
            case 4 :
                $titleDesc      = ' (Gewinner)';
                $ButtonBack     = 'Ausgaben';
                $ButtonForward  = 'Abo Verk&auml;ufe';
                $whereWithValue = "WHERE `ls`.`stats_event` = 'userWin'";
            break;
            case 5 :
                $titleDesc      = ' (Abo Verk&auml;ufe)';
                $ButtonBack     = 'Gewinner';
                $ButtonForward  = 'Neue Nummern';
                $whereWithValue = "WHERE `ls`.`stats_event` = 'buyAbo'";
            break;
            case 6 :
                $titleDesc      = ' (Neue Nummern)';
                $ButtonBack     = 'Abo Verk&auml;ufe';
                $ButtonForward  = 'Gel&ouml;schte Abos';
                $whereWithValue = "WHERE `ls`.`stats_event` = 'newNumbers'";
            break;
            case 7 :
                $titleDesc      = ' (Gel&ouml;schte Abos)';
                $ButtonBack     = 'Neue Nummern';
                $ButtonForward  = 'Keine Sortierung';
                $whereWithValue = "WHERE `ls`.`stats_event` = 'deleteAbo'";
            break;
        } 
        if ($classChoose != NULL) {
            
            $whereWithValue != '' ? $whereWithValue .= ' AND `u`.`class` = ' . $classChoose .' ' : $whereWithValue = 'WHERE `u`.`class` = ' . $classChoose .' ';
        }
        if ($CURUSER['class'] >= $canViewAbos) {
            $title      = 'Alle Lotterie Logs' . $titleDesc;
            $canViewAll = true;
            $logQuery = "SELECT
                             `ls`.*,
                             `u`.`username` AS `userName`,
                             `u`.`class` AS `userClass`
                         FROM
                             `lotto_stats` AS `ls`
                         LEFT JOIN
                             `users` AS `u` 
                         ON 
                             `ls`.`stats_userID` = `u`.`id`
                         " . $whereWithValue . "   
                         ORDER BY
                             `ls`.`stats_insertDate` DESC " . $limit;
        }
        else {
            $title    = 'Deine Lotterie Logs';
            $logQuery = "SELECT
                             *,
                             (SELECT
                                 `username`
                              FROM
                                 `users`
                              WHERE
                                 `id` = `ls`.`stats_userID`
                             ) AS `userName`,
                             (SELECT
                                 `class`
                              FROM
                                 `users`
                              WHERE
                                 `id` = `ls`.`stats_userID`
                             ) AS `userClass`
                         FROM
                             `lotto_stats` AS `ls`
                         WHERE
                             `stats_userID` = " . intval($CURUSER['id']) . "
                         AND
                             `stats_event`  != 'outgoing'
                         OR
                             `stats_event` = 'newNumbers' 
                         ORDER BY
                             `stats_insertDate` DESC " . $limit;
        }
        $doLogQuery = mysql_query($logQuery) OR sqlerr(__FILE__,__LINE__);
        $logOutput  = '<table class="logtable" cellspacing="0" width="100%">
                           <tr>';
        if ($canViewAll !== false) {
            $logOutput .=     '<td style="border-bottom: none ! important; text-align: center;">
                                   <form name="changeOrder" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                       <input type="hidden" name="toDo" value="log" />
                                       <input type="hidden" name="queryMe" value="' . $queryMe . '" />
                                       <input type="hidden" name="jackpotValues" value="' . $jackpotValues . '" />
                                       <input type="hidden" name="classChoose" value="' . $classChoose . '" />
                                       <input type="hidden" name="direction" value="back" />
                                       <input type="submit" value="&laquo;&laquo; ' . $ButtonBack . '" />
                                   </form>
                               </td>';
        }
        $logOutput         .= '<td style="border-bottom: none ! important; text-align: center;">
                                   <form name="queryMe" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                   <input type="hidden" name="jackpotValues" value="' . $jackpotValues . '" />
                                   <input type="hidden" name="classChoose" value="' . $classChoose . '" />
                                   <input type="hidden" name="toDo" value="log" />    
                                       ' . ($canViewAll !== false ? $classOption : '') . '
                                       <select name="queryMe" style="color: #000000; font-weight: bold; background-color: #eeeeee;">
                                           <option value="10" ' . ($queryMe == 10 ? 'selected="selected"' : '' ). '>Anzahl</option>
                                           <option value="25" ' . ($queryMe == 25 ? 'selected="selected"' : '' ). '>Die letzten 25</option>
                                           <option value="50" ' . ($queryMe == 50 ? 'selected="selected"' : '' ). '>Die letzten 50</option>
                                           <option value="75" ' . ($queryMe == 75 ? 'selected="selected"' : '' ). '>Die letzten 75</option>
                                           <option value="0"  ' . ($queryMe == 0  ? 'selected="selected"' : '' ). '>Alle</option>
                                       </select>
                                       <input type="submit" value="Aktuallisieren" />
                                   </form>
                               </td>';
        if ($canViewAll !== false) {
            $logOutput .=     '<td style="border-bottom: none ! important; text-align: center;">
                                   <form name="changeOrder" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                                       <input type="hidden" name="toDo" value="log" />
                                       <input type="hidden" name="queryMe" value="' . $queryMe . '" />
                                       <input type="hidden" name="jackpotValues" value="' . $jackpotValues . '" />
                                       <input type="hidden" name="classChoose" value="' . $classChoose . '" />
                                       <input type="hidden" name="direction" value="forward" />
                                       <input type="submit" value="' . $ButtonForward . ' &raquo;&raquo;" />
                                   </form>
                               </td>';
        }
        $logOutput .=     '</tr>
                       </table>
                       <table class="logtable" cellspacing="0" width="100%">';
        if (mysql_num_rows($doLogQuery) > 0) {
            $logOutput .= '<tr>
                              <td style="text-decoration: underline; width: 22%">Datum</td>
                              <td style="text-decoration: underline; width: 13%;">Username</td>
                              <td style="text-decoration: underline; width: 16%;">Aktion</td>
                              <td style="text-decoration: underline;">Beschreibung</td>
                          </tr>';
            while ($logs = mysql_fetch_assoc($doLogQuery))
            {
                switch ($logs['stats_event'])
                {
                    case 'incoming'   :
                        $event = 'Jackpot Einnahmen';
                    break;
                    case 'outgoing'   :
                        $event = 'Jackpot Ausgaben';
                    break;
                    case 'userWin'    :
                        $event = 'User Gewinn';
                    break;
                    case 'buyAbo'     :
                        $event = 'Abo gekauft';
                    break;
                    case 'deleteAbo'  :
                        $event = 'Abo gel&ouml;scht';
                    break;
                    case 'newNumbers' :
                        $event = 'Neue Nummern';
                }
                $userName = $logs['stats_userID'] > 0 ? '<a href="userdetails.php?id=' . $logs['stats_userID'] . '"><font class="' . get_class_color($logs['userClass']) . '"><b>' . $logs['userName'] . '</b></font></a>' : '<b>Lotterie Bot</b>';
                $logOutput .= '<tr>
                                   <td>' . strftime("%d.%m.%Y - %H:%M", $logs['stats_insertDate']) . ' Uhr</td>
                                   <td>' . $userName . '</td>
                                   <td>' . $event . '</td>
                                   <td>' . $logs['stats_desc'] . '</td>
                               </tr>';                
            }
        }
        else {
            $logOutput .= '<tr>
                               <td colspan="4" style="text-align: center ! important; border-top: 1px dotted #cccccc;">Keine Logs vorhanden!</td>
                           </tr>';
        }
        $logOutput .= '</table>';
		print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-gamepad'></i> ".$title."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
        //begin_frame($title, false, '950px');
        echo $logOutput;
       print"	                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
    break;

    case 'help' :
				print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-gamepad'></i> FAQ
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
        //begin_frame('F.A.Q.', false, '950px');
        echo '<table class="table table-bordered table-striped table-condensed" cellspacing="0" width="100%">
                  <tr>
                      <td colspan="2">
                          <br />
                          &nbsp;Diese Lotterie ist ein Nachbau der klassischen Lotterie 6 aus 49 + Superzahl.<br />
                          &nbsp;Ab nun habt Ihr die M&ouml;glichkeit satte Gewinne einzufahren die zu Eurem Upload gerechnet werden.<br />
                          <br />
                          &nbsp;Wichtig: Alle Einnahmen f&uuml;r die Lotterie gehen in den Jackpot und stehen f&uuml;r jeden Spieler zur Verf&uuml;gung!<br />
                          <br />
                          &nbsp;Die einzelnen Tabs sind wie folgt aufgegliedert :
                          <br />&nbsp;<br />
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="border-bottom: none;">
                          <form name="helpInfo" method="post" action="' . $_SERVER['PHP_SELF'] . '"> 
                          <input type="hidden" name="toDo" value="info" />
                              <br />
                              &nbsp;<input type="submit" value="&Uuml;bersicht" />
                          </form>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2">
                          <br />
                          &nbsp;Hier seht Ihr generelle Info &uuml;ber die Lotterie.<br />
                          &nbsp;Jackpot, die letzten gezogenen Zahlen, Anzahl der Ziehungen und ein paar Statistiken!
                          <br />&nbsp;<br />
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="border-bottom: none;">
                          <form name="helpInfo" method="post" action="' . $_SERVER['PHP_SELF'] . '"> 
                          <input type="hidden" name="toDo" value="aboCheck" />
                             <br />
                             &nbsp;<input type="submit" value="Deine Abonnements"  /> &laquo;-&raquo; <input type="button" onclick="javascript:alert(\'Klicke auf Deine Abonnements um zu dem Abo Manager zu gelangen.\');" value="Abo Manager" />
                          </form>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2">
                          <br />
                          &nbsp;Hier sind alle Informationen &uuml;ber Eure gekauften Abonnements.<br />
                          &nbsp;Kaufdatum, aktuelle Zahlen, verbleibende Ziehungen und der Abo-Manager.<br />
                          &nbsp;Am rechtem Rand findet Ihr bei einem g&uuml;ltigen Abonnement den Abo-Manager mit dem Ihr<br />
                          &nbsp;auf mehr Details des Abonnements zugreifen k&ouml;nnt. Hier gebt Ihr auch die Tipps direkt ab,<br />
                          &nbsp;sprich Ihr stellt ein mit welchen Zahlen Ihr spielen wollt. Ebenfalls k&ouml;nnt Ihr hier die<br />
                          &nbsp;Benachrichtigung ein, - oder ausschalten. Ist die Benachrichtigung eingeschaltet, so erhaltet<br />
                          &nbsp;Ihr eine Erinnerungsmail kurz vor der Ziehung falls Ihr die Zahlen &auml;ndern m&ouml;chtet.<br />
                          &nbsp;Durch das Aktivieren erhaltet Ihr im Anschluss an der Ziehung auch eine PM wenn Ihr gewonnen habt,<br />
                          &nbsp;mit Anzahl der gewonnen Zahlen und auch der H&ouml;he des Gewinns.<br />
                          &nbsp;Ist das Abonnement schon abgelaufen, dann seht Ihr zwei Auswahlm&ouml;glichkeiten:<br />
                          &nbsp;- Abo erneuern: Ihr kauft das gleiche Abo erneut, Eure bisherigen Statistiken bleiben erhalten!<br />
                          &nbsp;- Abo L&ouml;schen: L&ouml;scht das von euch gekaufte Abo!
                          <br />&nbsp;<br />
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="border-bottom: none;">
                          <form name="helpInfo" method="post" action="' . $_SERVER['PHP_SELF'] . '"> 
                          <input type="hidden" name="toDo" value="payment" />
                              <br />
                             &nbsp;<input type="submit" value="Abonnements kaufen" />
                          </form>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2">
                          <br />
                          &nbsp;Gekaufte Abonnements k&ouml;nnen nicht umgetauscht werden!<br />
                          &nbsp;Die Kosten f&uuml;r die Lottoscheine werden von Eurem Upload abgezogen!<br />
                          &nbsp;Achtet bitte darauf, nicht zu viel auszugeben, da jede Bewegung des Uploads auch Eure Ratio beeinflusst!<br />
                          <br />
                          &nbsp;Wollt Ihr ein neues Abonnement kaufen, so seht Ihr unter diesem Tab eine Liste mit 12 m&ouml;glichen<br />
                          &nbsp;Abonnements mit 1 bis 84 Ziehungen mit oder ohne Superzahl.<br />
                          &nbsp;Des Weiteren gibt es hier auch die Angabe &uuml;ber Kosten u. Ersparnis gegen&uuml;ber Einzelkauf (1 Ziehung)<br />
                          &nbsp;Bitte Beachtet, die Lottoscheine werden nicht gleichzeitig gespielt, sondern immer nur einer pro Tag.<br />
                          &nbsp;M&ouml;chtet Ihr mit mehreren Scheinen am Tag spielen, so m&uuml;sst Ihr auch mehrere Abonnements kaufen.<br />
                          &nbsp;Die Anzahl der Lottoscheine bezieht sich somit auf die Anzahl der Tage die gespielt werden.<br />
                          <br />&nbsp;<br />
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="border-bottom: none;">
                          <form name="helpInfo" method="post" action="' . $_SERVER['PHP_SELF'] . '"> 
                          <input type="hidden" name="toDo" value="log" />
                              <br />
                              &nbsp;<input type="submit" value="Lotterie Log" />
                          </form>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2">
                          <br />
                          &nbsp;In dem Lotterie Log findet Ihr alle Aktionen die Euch betreffen!<br />
                          &nbsp;Eure Ausgaben, Einnahmen durch Lotterie Gewinne und Mitteilungen die Eure Abonnements betreffen.
                          <br />&nbsp;<br />
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2" style="border-bottom: none;">
                         <br />
                         &nbsp;<input type="button" value="Gewinn M&ouml;glichkeiten" onclick="javascript:alert(\'Klicke auf Abonnements kaufen! Nur mit einem Abo kannst Du gewinnen!\');" />
                      </td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none; width: 250px;"><br />&nbsp;1 richtige Zahl</td>
                      <td style="border-bottom: none;"><br />50mb</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;1 richtige Zahl &nbsp;&nbsp;&nbsp;&nbsp;+ Superzahl</td>
                      <td style="border-bottom: none;">100mb</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;2 richtige Zahlen</td>
                      <td style="border-bottom: none;">200mb</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;2 richtige Zahlen + Superzahl</td>
                      <td style="border-bottom: none;">400mb</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;3 richtige Zahlen</td>
                      <td style="border-bottom: none;">1% vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;3 richtige Zahlen + Superzahl</td>
                      <td style="border-bottom: none;">2% vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;4 richtige Zahlen</td>
                      <td style="border-bottom: none;">3% vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;4 richtige Zahlen + Superzahl</td>
                      <td style="border-bottom: none;">4% vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;5 richtige Zahlen</td>
                      <td style="border-bottom: none;">10% vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;5 richtige Zahlen + Superzahl</td>
                      <td style="border-bottom: none;">15% vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;6 richtige Zahlen</td>
                      <td style="border-bottom: none;">25% vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;6 richtige Zahlen + Superzahl<br />&nbsp;<br /></td>
                      <td style="border-bottom: none;">40% vom Jackpot<br />&nbsp;<br /></td>
                  </tr>
                  <tr>                  
                      <td colspan="2" style="border-bottom: none;">
                         <br />
                         &nbsp;<u>Beispiel:</u><br />
                         <br />
                         &nbsp;Nehmen wir an das der Lotterie Jackpot 750 GB enth&auml;lt!<br />
                      </td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none; width: 250px;"><br />&nbsp;1 richtige Zahl</td>
                      <td style="border-bottom: none;"><br />50mb Gewinn</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;1 richtige Zahl &nbsp;&nbsp;&nbsp;&nbsp;+ Superzahl</td>
                      <td style="border-bottom: none;">100mb Gewinn</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;2 richtige Zahlen</td>
                      <td style="border-bottom: none;">200mb Gewinn</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;2 richtige Zahlen + Superzahl</td>
                      <td style="border-bottom: none;">400mb Gewinn</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;3 richtige Zahlen</td>
                      <td style="border-bottom: none;">7.5 GB Gewinn vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;3 richtige Zahlen + Superzahl</td>
                      <td style="border-bottom: none;">15 GB Gewinn vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;4 richtige Zahlen</td>
                      <td style="border-bottom: none;">22.5 GB Gewinn vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;4 richtige Zahlen + Superzahl</td>
                      <td style="border-bottom: none;">30 GB Gewinn vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;5 richtige Zahlen</td>
                      <td style="border-bottom: none;">75 GB Gewinn vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;5 richtige Zahlen + Superzahl</td>
                      <td style="border-bottom: none;">112.5 GB Gewinn vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;6 richtige Zahlen</td>
                      <td style="border-bottom: none;">187.5 GB Gewinn vom Jackpot</td>
                  </tr>
                  <tr>
                      <td style="border-bottom: none;">&nbsp;6 richtige Zahlen + Superzahl<br />&nbsp;<br /></td>
                      <td style="border-bottom: none;">300 GB Gewinn vom Jackpot<br />&nbsp;<br /></td>
                  </tr>
                  <tr>                  
                  <tr>
                      <td colspan="2" style="border-bottom: none;">
                          <br />
                          &nbsp;<input type="button" value="F.A.Q." onclick="javascript:alert(\'Lese Dir zuerst die F.A.Q. durch. Bei Fragen wende Dich an den Staff!\');" />
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2">
                          <br />
                          &nbsp;Diese Zeilen. Sollten noch Fragen offen sein, so scheut Euch nicht uns eine Team-PM zu senden.<br />
                          &nbsp;Viel Erfolg und Gl&uuml;ck mit der Lotterie w&uuml;nscht Euch Euer T4Y - Team!
                          <br />&nbsp;<br />
                      </td>
                  </tr>
              </table>';
               print"	</div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
    break;
       
    case 'config' :  
        if ($CURUSER['class'] < $canEditConfig) {
            adddeniedlog();
        }
        if ($_POST['manualDraw'] == 'yes' && $CURUSER['class'] >= $canManualDraw) {
            $lotto = NEW Lottery();
            $lotto->makeManualDraw();
        }
        if ($_POST['deleteStats'] == 'yes' && $CURUSER['class'] >= $canManualDraw) {
            if ($_POST['logType'] === NULL) {
                $Error   = true;
                $Message = 'Error: Mindestens 1 Log Kategorie ankreuzen!';
            }
            else {
                $logTypes = false;
                foreach ($_POST['logType'] AS $logType)
                {
                    $logTypes .= ($logTypes !== false ? ', ' : '') . sqlesc($logType);
                }
                $whereWithValue = 'WHERE `stats_event` IN (' . $logTypes .  ') ';
            }
            switch ($_POST['timestamp'])
            {
                case 15  :
                case 30  :
                case 60  :
                case 90  :
                case 120 :
                case 240 :
                case 365 :
                    $whereWithValue .= 'AND `stats_insertDate` < ' . (time() - ($_POST['timestamp'] * 86400));
                break;
                case 'all' :
                    // save is save!
                break;
                default :
                    $Error   = true;
                    $Message = 'Error: Fehler mit der Zeitangabe!';
                break;
            }
            if (!$Error) {
                $delStats = mysql_query("DELETE FROM `lotto_stats` " . $whereWithValue) OR sqlerr(__FILE__, __LINE__);
                $delCount = mysql_affected_rows();
                if ($delStats && $delCount) {
                    $saveSuccess = true;
                    $Message     = 'In ' . count($_POST['logType']) . ' Log Kategorie' . (count($_POST['logType']) == 1 ? '' : 'n' ) . ' insg. ' . $delCount . ' Logs entfernt!';
                }
                else {
                    $Error   = true;
                    $Message = 'Error: Beim entfernen der Logs ist ein Fehler aufgetreten!';
                }
            }
        }
        if ($_POST['aboCleanup'] == 'cleanMe' && $CURUSER['class'] >= $canManualDraw) {
            switch ($_POST['deadTime'])
            {
                case 15  :
                case 30  :
                case 60  :
                case 90  :
                case 120 :
                case 240 :
                case 365 :
                    $timeOfInactive = 'AND `abo_lastDrawing` < ' . (time() - ($_POST['deadTime'] * 86400));
                break;
                case 'all' :
                    $timeOfInactive = '';
                break;
                default :
                    $Error   = true;
                    $Message = 'Error: Fehler mit der Zeitangabe!';
                break;                
            }
            $takeAbos = mysql_query("SELECT
                                         `abo_id`,
                                         `abo_userID`,
                                         (SELECT
                                              `username`
                                          FROM
                                              `users`
                                          WHERE
                                              `id` = `abo_userID`
                                         ) AS `userName`
                                     FROM
                                         `lotto_abonnement`
                                     WHERE
                                         `abo_length` = 0
                                         " . $timeOfInactive
                                   ) OR sqlerr(__FILE__, __LINE__);
            if (mysql_num_rows($takeAbos) > 0) {
                $lotto = NEW Lottery();
                $userAboToDel = Array();
                while ($abos = mysql_fetch_assoc($takeAbos))
                {
                    $subject = 'Lotterie Bot Info';
                    $pm      = 'Dein Abonnenement mit der ID ' . $abos['abo_id'] . ' wurde gel&ouml;scht![br][br]';
                    $pm     .= 'Grund: Abonnement' . ($_POST['deadTime'] != 'all' ? ' war &Auml;lter als ' . intval($_POST['deadTime']) . ' Tage und' : '') . ' hatte keine Ziehungen mehr![br]';
                    $pm     .= 'Um weiterhin Gewinnen zu k&ouml;nnen kannst Du Dir ein neues Abonnement anlegen![br][br]';
                    $pm     .= 'mfg Lotterie Bot';
                    sendPersonalMessage(0, $abos['abo_userID'], $subject, $pm, PM_FOLDERID_INBOX, 0);
                    $statsEntry = 'Abo von ' . $abos['userName'] . ' entfernt! 0 Ziehungen, &Auml;lter als ' . $_POST['deadTime'] . ' Tage!';
                    $lotto->insertStatsLogs('deleteAbo', 0, $abos['abo_id'], $statsEntry);
                    $userAboToDel[] = $abos['abo_id'];
                }
                $deleteInactiveAbos = mysql_query("DELETE FROM 
                                                       `lotto_abonnement`
                                                   WHERE
                                                       `abo_id` IN (" . implode(', ', $userAboToDel) . ")
                                                 ") OR sqlerr(__FILE__, __LINE__);
                $deleteCount = mysql_affected_rows();
                if (count($userAboToDel) == $deleteCount) {
                    $saveSuccess = true;
                    $Message     = $deleteCount . ' Abonnements wurden erfolgreich entfernt, die User wurden per PM informiert!';
                }
                else {
                    $Error   = true;
                    $Message = 'Error: Beim entfernen der Abonnements ist ein Fehler aufgetreten!';
                }
            }
            else {
                $Error   = true;
                $Message = 'Error: Keine Abonnenements gefunden!'; 
            }
        }
        if ($_POST['saveConfig'] == 'save') {
            $lotteryName  = htmlentities($_POST['lotteryName']);
            $lottoEnabled = $_POST['lottoEnabled'] == 'yes' ? 'yes' : 'no';
            $withSuperInt = $_POST['withSuperInt'] == 'yes' ? 'yes' : 'no';
            $drawingHour  = $_POST['winHour'] >= 0 || $_POST['winHour'] <= 23 ? intval($_POST['winHour']) : 20;
            if (is_array($_POST['lottoDays'])) {
                $lottoDays = implode(',', $_POST['lottoDays']);
            }
            if (is_numeric($_POST['jackpot'])) {
                $jackpot = $_POST['jackpot'];    
            }
            else {
                $Error   = true;
                $Message = 'Error: Ein Jackpot aus Buchstaben... Bitte nur Zahlen eingeben! (Beispiel: 123456)';
            }
            if ($lottoEnabled == 'yes' && !is_array($_POST['lottoDays'])) {
                $Error   = true;
                $Message = 'Error: Wenn Du die Lotterie aktivierst, solltest du mindestens 1 Tag angeben an der sie laufen soll!';
            }
            if (!$Error) {
                $update = mysql_query("UPDATE
                                           `lotto_config`
                                       SET 
                                           `lottery_active`       = '" . $lottoEnabled . "',
                                           `lottery_withSuperInt` = '" . $withSuperInt . "',
                                           `lottery_winHour`      = "  . $drawingHour . ",
                                           `lottery_days`         = "  . sqlesc($lottoDays) . ",
                                           `lottery_jackpot`      = "  . $jackpot . "
                                       WHERE
                                           `lottery_name`         = " . sqlesc($lotteryName) . "
                                      ") OR sqlerr(__FILE__,__LINE__);
                if ($update) {
                   $saveSuccess = true;
                   $Message     = 'Lotterie Einstellungen wurden korrekt gespeichert!';
                }
                else {
                    $Error   = true;
                    $Message = 'Error: Beim speichern ist ein Fehler aufgetreten!';
                }
            } 
        }
        $lotto = NEW Lottery();
        $winHour = '<select name="winHour" style="color: #000000; font-weight: bold; background-color: #eeeeee;">';
        for ( $hour = 0; $hour < 24; $hour++ )
        {
            $winHour .= '<option value="' . $hour . '" '.($lotto->getWinHour() == $hour ? 'selected="selected"' : '').'>' . $hour . '</option>';
        }
        $winHour .= '</select>';
        $aLottoDays = $lotto->getDrawDays();
		print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-gamepad'></i> Lotterie Einstellungen f&uuml;r " . $lotto->getLottoName()."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
        //begin_frame('Lotterie Einstellungen f&uuml;r ' . $lotto->getLottoName(), false,'950px');
        echo '<form name="lotteryConfig" method="post" action="' . $_SERVER['PHP_SELF'] . '">
              <input type="hidden" name="toDo" value="config" />
              <input type="hidden" name="saveConfig" value="save" />
              <input type="hidden" name="lotteryName" value="' . $lotto->getLottoName() . '" />
                  <table class="table table-bordered table-striped table-condensed" cellspacing="0" width="100%">
                      <tr>
                          <td colspan="2" style="text-align: left;">Lotterie Version ' . $lotto->getVersion() .'</td>
                      </tr>
                      <tr>
                          <td>Lotterie aktiv:</td>
                          <td>
                              <input type="radio" name="lottoEnabled" value="yes" ' . ($lotto->getLottoActiveStatus() !== false ? 'checked="checked"' : '') . ' /> Aktiviert
                              <input type="radio" name="lottoEnabled" value="no"  ' . ($lotto->getLottoActiveStatus() === false ? 'checked="checked"' : '') . ' /> Deaktiviert
                          </td>
                      </tr>
                      <tr>
                          <td>Lotterie mit Superzahl</td>
                          <td>
                              <input type="radio" name="withSuperInt" value="yes" ' . ($lotto->withSuperInt() !== false ? 'checked="checked"' : '') . ' /> Aktiviert
                              <input type="radio" name="withSuperInt" value="no"  ' . ($lotto->withSuperInt() === false ? 'checked="checked"' : '') . ' /> Deaktiviert
                          </td>
                      </tr>
                      <tr>
                          <td>Ziehung in Stunde</td>
                          <td>' . $winHour . '</td>
                      </tr>
                      <tr>
                          <td valign="top">An welchen Tagen ist die Ziehung</td>
                          <td>
                               <input type="checkbox" name="lottoDays[]" value="1" ' . (in_array(1, $aLottoDays) ? 'checked="checked"' : '') . ' /> Montag<br />
                               <input type="checkbox" name="lottoDays[]" value="2" ' . (in_array(2, $aLottoDays) ? 'checked="checked"' : '') . ' /> Dienstag<br />
                               <input type="checkbox" name="lottoDays[]" value="3" ' . (in_array(3, $aLottoDays) ? 'checked="checked"' : '') . ' /> Mittwoch<br />
                               <input type="checkbox" name="lottoDays[]" value="4" ' . (in_array(4, $aLottoDays) ? 'checked="checked"' : '') . ' /> Donnerstag<br />
                               <input type="checkbox" name="lottoDays[]" value="5" ' . (in_array(5, $aLottoDays) ? 'checked="checked"' : '') . ' /> Freitag<br />
                               <input type="checkbox" name="lottoDays[]" value="6" ' . (in_array(6, $aLottoDays) ? 'checked="checked"' : '') . ' /> Samstag<br />
                               <input type="checkbox" name="lottoDays[]" value="0" ' . (in_array(0, $aLottoDays) ? 'checked="checked"' : '') . ' /> Sonntag
                          </td>
                      </tr>
                      <tr>
                          <td valign="top">Jetztiger Jackpot</td>
                          <td>
                              <input type="text" name="jackpot" size="30" maxlength="30" value="' . $lotto->getJackpot() . '" /> Byte!<br />
                              Jetztiger Stand: ' . $lotto->getJackpot(true) . '
                          </td>
                      </tr>
                      <tr>
                          <td>Letzten Zahlen der Ziehung</td>
                          <td>' . $lotto->getLastNumbers(true) . '</td>
                      </tr>
                      <tr>
                          <td>Letzte gezogene Superzahl</td>
                          <td>' . $lotto->getLastSuperInt() . '</td>
                      </tr>
                      <tr>
                          <td>Letzte Ziehung am</td>
                          <td>' . $lotto->getLastDrawing(true) . ' Uhr</td>
                      </tr>
                      <tr>
                          <td colspan="2">
                              <br />
                              <center>
                                  <input type="submit" value="Speichern" /> <input type="reset" value="Abbrechen" />
                                  <br />&nbsp;<br />
                              </center>
                          </td>
                      </tr>
                  </table>
              </form>';
        if ($CURUSER['class'] >= $canManualDraw) {
            echo '<table class="table table-bordered table-striped table-condensed" cellspacing="0" width="100%">
                      <tr>
                          <td style="cursor: pointer;" onclick="toggle(\'configSuprise\')">
                              <br />
                              &nbsp;<img id="img_configSuprise" src="pic/visible.png" /> Deine Macht reicht aus um die erweiterten Optionen zu sehen!
                              <br />&nbsp;<br />
                          </td>
                      </tr>
                      <tr id="configSuprise" style="display: none;">
                          <td valign="top" style="text-align: center; width: 30%;">
                              <form name="manualDraw" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                              <input type="hidden" name="toDo" value="config" />
                              <input type="hidden" name="manualDraw" value="yes" />
                                  <br />
                                  May the Force be with you ... !
                                  <br />&nbsp;<br />
                                  &nbsp;<input type="submit" value="(! NOTFALL !) Manuelle Ziehung (! NOTFALL !)" onclick="return confirm(\'Die Ziehung wirklich manuell starten?\');"/>&nbsp;
                                  <br />&nbsp;<br />
                              </form>    
                          </td>
                          <td style="text-align: left;">
                              <form name="deleteStats" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                              <input type="hidden" name="toDo" value="config" />
                              <input type="hidden" name="deleteStats" value="yes" />
                                  <br />
                                  &nbsp;Lotterie Logs entfernen&nbsp;<br />
                                  <br />
                                  &nbsp;
                                  <select name="timestamp" style="color: #000000; font-weight: bold; background-color: #eeeeee;">
                                      <option value="all">Kein Zeitlimit</option>
                                      <option value="15"> 15 Tage</option>
                                      <option value="30">&Auml;lter als 30 Tage</option>
                                      <option value="60">&Auml;lter als 60 Tage</option>
                                      <option value="90">&Auml;lter als 90 Tage</option>
                                      <option value="120">&Auml;lter als 120 Tage</option>
                                      <option value="240">&Auml;lter als 240 Tage</option>
                                      <option value="365">&Auml;lter als 365 Tage</option>
                                  </select>
                                  <br /><br />
                                  <input type="checkbox" name="logType[]" value="incoming" /> Einnahmen<br />
                                  <input type="checkbox" name="logType[]" value="outgoing" /> Ausgaben<br />
                                  <input type="checkbox" name="logType[]" value="userWin" /> User Gewinne<br />
                                  <input type="checkbox" name="logType[]" value="buyAbo" /> Gekaufte Abos<br />
                                  <input type="checkbox" name="logType[]" value="deleteAbo" /> Gel&ouml;schte Abos<br />
                                  <input type="checkbox" name="logType[]" value="newNumbers" /> Neue Nummern<br />
                                  <br />
                                  &nbsp;<input type="submit" value="Logs l&ouml;schen!" onclick="return confirm(\'Die gew&auml;hlten Logs l&ouml;schen?\');"/>
                                  <br />&nbsp;<br />
                              </form>         
                          </td>
                          <td valign="top" style="text-align: center;  width: 50%;">
                              <form name="aboCleanup" method="post" action="' . $_SERVER['PHP_SELF'] . '">
                              <input type="hidden" name="toDo" value="config" />
                              <input type="hidden" name="aboCleanup" value="cleanMe" />
                                  <br />
                                  &nbsp;Abgelaufene Abonnements l&ouml;schen!&nbsp;<br />
                                  <br />
                                  &nbsp;Betroffene User werden per PM über den L&ouml;schvorgang informiert!&nbsp; 
                                  <br /><br />
                                  <select name="deadTime" style="color: #000000; font-weight: bold; background-color: #eeeeee;">
                                      <option value="all">Alle Abos ohne Ziehungen</option>
                                      <option value="15">Abgelaufen seit 15 Tagen</option>
                                      <option value="30">Abgelaufen seit 30 Tagen</option>
                                      <option value="60">Abgelaufen seit 60 Tagen</option>
                                      <option value="90">Abgelaufen seit 90 Tagen</option>
                                      <option value="120">Abgelaufen seit 120 Tagen</option>
                                      <option value="240">Abgelaufen seit 240 Tagen</option>
                                      <option value="365">Abgelaufen seit 365 Tagen</option>
                                  </select>
                                  <input type="submit" value="Tote Abonnements l&ouml;schen!" onclick="return confirm(\'Die Abonnements l&ouml;schen?\');"/><br />
                              </form> 
                          </td>
                      </tr>
                  </table>';
        }
        print"	                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
    break;
   
    case 'admin' :
        if ($CURUSER['class'] < $canViewAbos) {
            adddeniedlog();
        }
        $queryMeAdmin     = isset($_POST['queryMeAdmin']) ? $_POST['queryMeAdmin'] : 10;
        $classChooseAdmin = $_POST['classChooseAdmin'];
        $order            = $_POST['order'] == 'ASC' ? 'ASC' : 'DESC';
        $active           = isset($_POST['active']) ? $_POST['active'] : NULL;
        $constants        = get_defined_constants ();
        $classOptionAdmin = '<select name="classChooseAdmin" style="color: #000000; font-weight: bold; background-color: #eeeeee;">
                                 <option value="">Alle R&auml;nge</option>';
        foreach (array_keys($constants) AS $x)
        {
           if (substr($x,0,3) == "UC_") {
               if ($x != 'UC_SUPERUPLOADER' && $x != 'UC_CO_ADMIN') {
                   $classOptionAdmin .='<option value="' . constant($x) . '" ' . (constant($x) == $classChooseAdmin ? 'selected="selected"' : '') . '>' . get_user_class_name(constant($x)) . '</option>';
               }
           }
        }
        $classOptionAdmin .= '</select>';
        switch ($queryMeAdmin)
        {
            case  0  :
                $limit = '';
            break;
            case 10  :
                $limit = 'LIMIT 10';
            break;
            case 25  :
                $limit = 'LIMIT 25';
            break;
            case 50  :
                $limit = 'LIMIT 50';
            break;
            case 75  :
                $limit = 'LIMIT 75';
            break;
            case 100 :
                $limit = 'LIMIT 100';
            break;
        }
        if ($classChooseAdmin != NULL) {
            $whereWithValue = ' WHERE `u`.`class` = ' . $classChooseAdmin . ' ';
        }
        switch ($active)
        {
            case 'noNumbers' :
                $whereWithValue != '' ? $whereWithValue .= ' AND `la`.`abo_userNumbers` IS NULL ' : $whereWithValue = ' WHERE `la`.`abo_userNumbers` IS NULL ';
            break;
            case 'aboDead'   :
                $whereWithValue != '' ? $whereWithValue .= ' AND `la`.`abo_length` = 0 ' : $whereWithValue = ' WHERE `la`.`abo_length` = 0 ';
            break;
        }
        $userAboQuery = mysql_query("SELECT
                                         `la`.*,
                                         `u`.`username`,
                                         `u`.`class`
                                     FROM
                                         `lotto_abonnement` AS `la`
                                     LEFT JOIN
                                         `users` AS `u`
                                     ON
                                         `la`.`abo_userID` = `u`.`id`
                                     " . $whereWithValue . "
                                     ORDER BY
                                         `la`.`abo_purchaseDate` " . $order . "
                                     " . $limit
                                   ) OR sqlerr(__FILE__,__LINE__);
        
        $aboOutput = '<form method="post" name="adminButtons" action="' . $_SERVER['PHP_SELF'] . '">
                      <input type="hidden" name="toDo" value="admin" />
                      <input type="hidden" name="queryMeAdmin" value="' . $queryMeAdmin . '" />
                      <input type="hidden" name="classChooseAdmin" value="' . $classChooseAdmin . '" />
                      <input type="hidden" name="order" value="' . $order . '" />
                      <input type="hidden" name="active" value="' . $active . '" />
                          <table class="admintable" cellspacing="0" width="100%">
                              <tr>
                                  <td style="border-bottom: none ! important; text-align: center; height:30px;">
                                      ' . $classOptionAdmin . '
                                      <select name="queryMeAdmin" style="color: #000000; font-weight: bold; background-color: #eeeeee;">
                                          <option value="10"  ' . ($queryMeAdmin == 10  ? 'selected="selected"' : '' ). '>Anzahl</option>
                                          <option value="25"  ' . ($queryMeAdmin == 25  ? 'selected="selected"' : '' ). '>Die letzten 25</option>
                                          <option value="50"  ' . ($queryMeAdmin == 50  ? 'selected="selected"' : '' ). '>Die letzten 50</option>
                                          <option value="75"  ' . ($queryMeAdmin == 75  ? 'selected="selected"' : '' ). '>Die letzten 75</option>
                                          <option value="100" ' . ($queryMeAdmin == 100 ? 'selected="selected"' : '' ). '>Die letzten 100</option>
                                          <option value="0"   ' . ($queryMeAdmin == 0   ? 'selected="selected"' : '' ). '>Alle</option>
                                      </select>
                                      <select name="order" style="color: #000000; font-weight: bold; background-color: #eeeeee;">
                                          <option value="DESC" ' . ($order == 'DESC' ? 'selected="selected"' : '' ). '>Die Neuesten oben</option>
                                          <option value="ASC"  ' . ($order == 'ASC'  ? 'selected="selected"' : '' ). '>Die &Auml;ltesten oben</option>
                                      </select>
                                      <select name="active" style="color: #000000; font-weight: bold; background-color: #eeeeee;">
                                          <option value="">Alle Abos</option>
                                          <option value="noNumbers" ' . ($active == 'noNumbers' ? 'selected="selected"' : '' ) . '>Keine Zahlen angegeben</option>
                                          <option value="aboDead"   ' . ($active == 'aboDead'   ? 'selected="selected"' : '' ) . '>Abo Abgelaufen</option>
                                      </select>
                                      <input type="submit" value="Aktuallisieren" />
                                  </td>
                              </tr>
                          </table>
                      </form>
                      <table class="admintable" cellspacing="0" width="100%">';
        if (mysql_num_rows($userAboQuery) > 0) {
            while ($aboAdmin = mysql_fetch_assoc($userAboQuery)) 
            {
                $aboOutput .= '<tr>
                                   <td style="border-bottom: none; height: 25px;"><span onclick="toggle(' . $aboAdmin['abo_id'] . ');" style="cursor: help;">Abo ID: ' . $aboAdmin['abo_id'] . '</span><br /></td>
                                   <td style="border-bottom: none; height: 25px;">von <a href="userdetails.php?id=' . $aboAdmin['abo_userID'] . '"><font class="' . get_class_color($aboAdmin['class']) . '"><b>' . $aboAdmin['username'] . '</b></font></a></td>
                                   <td style="border-bottom: none; height: 25px;">Kauf Datum: ' . strftime("%d.%m.%Y - %H:%M", $aboAdmin['abo_purchaseDate']) . ' Uhr</td>
                                   <td style="border-bottom: none; height: 25px;">' . ($aboAdmin['abo_length'] > 0 ? 'mit ' . $aboAdmin['abo_length'] .' verbleibenden Ziehungen!' : ' Abo ist abgelaufen!') . '</td>
                                   <td style="text-align: center; border-bottom: none;"><img id="img_' . $aboAdmin['abo_id'] . '" onclick="toggle(' . $aboAdmin['abo_id'] . ');"  src="pic/visible.png" style="cursor: pointer;" /></td>
                               </tr>
                               <tr>
                                   <td colspan="5">
                                       <table id="' . $aboAdmin['abo_id'] . '" style="display:none;" class="admintable" cellspacing="0" width="100%">
                                           <tr>
                                               <td style="border-bottom: none; width:50%;">
                                                   <br />Letze Ziehung: ' .($aboAdmin['abo_lastDrawing'] > 0 ? strftime("%d.%m.%Y - %H:%M", $aboAdmin['abo_lastDrawing']) . ' Uhr.' : 'Nie gespielt!') . '<br />
                                                   Superzahl ist ' . ($aboAdmin['abo_superIntActive'] == 'yes' ? 'gebucht' : 'nicht gebucht') . '
                                               </td>
                                               <td style="border-bottom: none; width:50%;">
                                                   <br />Zahlen zuletzt ge&auml;ndert: ' .($aboAdmin['abo_lastNumberChange'] > 0 ? strftime("%d.%m.%Y - %H:%M", $aboAdmin['abo_lastNumberChange']).' Uhr!' : 'Nie!'  ). '<br />
                                                   Info PM: ' . ($aboAdmin['abo_infoMessage'] == 'yes' ? 'aktiviert' : 'deaktiviert') . '
                                               </td>
                                           </tr>
                                           <tr>
                                               <td style="border-bottom: none; width:50%;">
                                                   Nummern: ' .($aboAdmin['abo_userNumbers'] != NULL ? str_replace(',', ', ', $aboAdmin['abo_userNumbers']) : 'Keine Zahlen angegeben!')  . '<br />
                                                   ' . ($aboAdmin['abo_superIntActive'] == 'yes' ? 'Superzahl: ' . $aboAdmin['abo_superInt'] : 'Keine Superzahl') . '<br />&nbsp;<br />
                                               </td>
                                               <td style="border-bottom: none; width:50%;">
                                                   Gewinn: '. mksize($aboAdmin['abo_aboWonBytes']) .'<br />
                                                   ' . ($aboAdmin['abo_aboWonCount'] > 0 ? $aboAdmin['abo_aboWonCount'] . ' gewonnen!' : 'Nie gewonnen!') . '<br />&nbsp;<br />
                                               </td>
                                               
                                           </tr>
                                       </table>
                                   </td>
                               </tr>';
            }
        }
        else {
            $aboOutput .= '<tr>
                               <td style="border-bottom: none; text-align: center;">
                                   ' . ($queryMeAdmin != 10 || $classChooseAdmin != NULL || $active != NULL ? 'Keine Suchergebnisse gefunden!<br />&nbsp;<br />' : 'Keine Abonnements in der Lotterie!<br />&nbsp;<br />') . '
                               </td>
                           </tr>';
        } 
        $aboOutput .= '</table>';
		print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-gamepad'></i> Gebuchte Abonnenemts
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
        //begin_frame('Gebuchte Abonnenemts', false, '950px');
        echo $aboOutput;
        print"	                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
    break;
}
x264_footer();

if ($Error || $saveSuccess) {
    echo '<script type="text/javascript">
              alert(\'' . $Message . '\');
          </script>';
} 