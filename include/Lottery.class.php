<?php
// ************************************************************************************//
// * Lottery Class v 0.4 
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

class Lottery {
    // version 
    const LOTTERY_VERSION        = '0.4';
    // 1 until 2 + superint are booby prizes
    const BYTES_FOR_ONE          =  52428800;  // 50mb
    const BYTES_FOR_ONE_SZ       = 104857600;  // 100mb 
    const BYTES_FOR_TWO          = 209715200;  // 200mb
    const BYTES_FOR_TWO_SZ       = 419430400;  // 400mb
    // percents for the winning classes
    const PERCENT_FOR_THREE      =  1;  // 1%  from jackpot
    const PERCENT_FOR_THREE_SZ   =  2;  // 2%  from jackpot
    const PERCENT_FOR_FOUR       =  3;  // 3%  from jackpot
    const PERCENT_FOR_FOUR_SZ    =  4;  // 4%  from jackpot
    const PERCENT_FOR_FIVE       = 10;  // 10% from jackpot
    const PERCENT_FOR_FIVE_SZ    = 15;  // 15% from jackpot
    const PERCENT_FOR_SIX        = 25;  // 25% from jackpot
    const PERCENT_FOR_SIX_SZ     = 40;  // 40% from jackpot
    // lottery config vars
    private $lottoName           = '';
    private $lottoActive         = false;
    private $withSuperInt        = false;
    private $lottoWinHour        = 0;
    private $lottoDays           = Array();
    private $jackpot             = 0;
    private $lastLottoNumbers    = Array();
    private $lastSuperInt        = 0;
    private $lastDrawing         = 0;
    private $lastInfoMessage     = 0;
    private $drawCount           = 0;
    private $playerWonCount      = 0;
    private $jackpotOutput       = 0;
    private $aboCount            = 0;
    private $inactiveAbos        = 0;
    // lottery draw vars for internal use
    private $winnerArray         = Array();
    private $winnerMessages      = Array();
    private $newNumbers          = Array();
    private $newSuperInt         = NULL;
    private $decreaseJackpot     = 0;
    private $userRefund          = 0;
    private $winningClassOne     = 0;
    private $winningClassOneSZ   = 0;
    private $winningClassTwo     = 0;
    private $winningClassTwoSZ   = 0;
    private $winningClassThree   = 0;
    private $winningClassThreeSZ = 0;
    private $winningClassFour    = 0;
    private $winningClassFourSZ  = 0;
    private $winningClassFive    = 0;
    private $winningClassFiveSZ  = 0;
    private $winningClassSix     = 0;
    private $winningClassSixSZ   = 0;
    private $byteForThree        = 0;
    private $byteForThreeSZ      = 0;
    private $byteForFour         = 0;
    private $byteForFourSZ       = 0;
    private $byteForFive         = 0;
    private $byteForFiveSZ       = 0;
    private $byteForSix          = 0;
    private $byteForSixSZ        = 0;

    /**
    * construct the class with needed vars 
    * if $checkForPlay: self check for start the draw
    * @param bool $checkForPlay
    * @return object Lottery
    */
    function __construct($checkForPlay = false) {
        $lottoQuery  = mysql_query("SELECT 
                                        *,
                                        (SELECT
                                             COUNT(1)
                                         FROM
                                             `lotto_abonnement`
                                        ) AS `lottoCount`,
                                        (SELECT
                                             COUNT(1)
                                         FROM
                                             `lotto_abonnement`
                                         WHERE
                                             `abo_length` = 0
                                         OR
                                             `abo_userNumbers` IS NULL
                                        ) AS `inactiveAbos`
                                    FROM
                                        `lotto_config`"
                                  ) OR sqlerr(__FILE__,__LINE__);
        $lottoConfig = mysql_fetch_assoc($lottoQuery);
        
        $this->lottoName        = $lottoConfig['lottery_name'];
        $this->lottoActive      = $lottoConfig['lottery_active'] == 'yes' ? true : false;
        $this->withSuperInt     = $lottoConfig['lottery_withSuperInt'] == 'yes' ? true : false;
        $this->lottoWinHour     = $lottoConfig['lottery_winHour'];
        $this->lottoDays        = !empty($lottoConfig['lottery_days']) ? explode(',', $lottoConfig['lottery_days']) : false;
        $this->jackpot          = $lottoConfig['lottery_jackpot'];
        $this->lastLottoNumbers = !empty($lottoConfig['lottery_lastNumber']) ? explode(',', $lottoConfig['lottery_lastNumber']) : false;
        $this->lastSuperInt     = $lottoConfig['lottery_lastSuperInt'];
        $this->lastDrawing      = $lottoConfig['lottery_lastDrawing'];
        $this->lastInfoMessage  = $lottoConfig['lottery_lastInfoMessage'];
        $this->drawCount        = $lottoConfig['lottery_drawCount'];
        $this->playerWonCount   = $lottoConfig['lottery_playerWonCount'];
        $this->jackpotOutput    = $lottoConfig['lottery_jackpotOutput'];
        $this->aboCount         = $lottoConfig['lottoCount'];
        $this->inactiveAbos     = $lottoConfig['inactiveAbos'];
        
        if($checkForPlay !== false) {
            $this->checkForPlay();
        }
    }

    /*************************************************************
    |                   PUBLIC GET METHODS                       |
    |                                                            |
    *************************************************************/
    
    /**
    * get the version from this lottery
    * @return string
    */
    public function getVersion() {
        return self::LOTTERY_VERSION;
    }
    
    /**
    * get the lotto name
    * @return string
    */
    public function getLottoName() {
        return $this->lottoName;
    }

    /**
    * get the Lottery active status
    * @return bool
    */
    public function getLottoActiveStatus() {
        return $this->lottoActive;
    }
    
    /**
    * return status for Lottery with superInt
    * @return bool
    */
    public function withSuperInt() {
        return $this->withSuperInt;
    }
    
    /**
    * get the hour for draw
    *  @return int
    */
    public function getWinHour() {
        return $this->lottoWinHour;
    }

    /**
    * get the days for draw
    * @return array
    */
    public function getDrawDays() {
        return $this->lottoDays;
    }

    /**
    * get the jackpot
    * @param bool $humanReadable
    * @return mixed vars
    */
    public function getJackpot($humanReadable = false) {
        if (!$humanReadable) {
            return $this->jackpot;
        }
        else {
            return mksize($this->jackpot);
        }
    }
    
    /**
    * get the last lotto numbers
    * @param bool $humanReadable
    * @return mixed vars
    */
    public function getLastNumbers($humanReadable = false) {
        if (!$humanReadable) {
            return $this->lastLottoNumbers;
        }
        else {
            return implode(', ', $this->lastLottoNumbers);
        }
        
    }

    /**
    * get the last superInt
    * @return int
    */
    public function getLastSuperInt() {
        return $this->lastSuperInt;
    }
    
    /**
    * get the time of last draw
    * @param bool $humanReadable
    * @return mixed vars
    */
    public function getLastDrawing($humanReadable = false) {
        if (!$humanReadable) {
            return $this->lastDrawing;
        }
        else {
            return strftime("%d.%m.%Y - %H:%M", $this->lastDrawing);
        }
    }
    
    /**
    * get the time of last Info Message
    * @param bool $humanReadable
    * @return mixed vars
    */
    public function getLastInfoMessage($humanReadable = false) {
        if(!$humanReadable) {
            return $this->lastInfoMessage;
        }
        else {
            return strftime("%d.%m.%Y - %H:%M", $this->lastInfoMessage);
        }
    }
    
    /**
    * get count of draws
    * @return int
    */
    public function getDrawCount() {
        return $this->drawCount;
    }    
    
    /**
    * get the sum of jackpot outputs
    * @param bool $humanReadable
    * @return mixed vars
    */
    public function getJackpotOutput($humanReadable = false) {
        if (!$humanReadable) {
            return $this->jackpotOutput;
        }
        else {
            return mksize($this->jackpotOutput);
        }
    }

    /**
    * get count from abos 
    * @return int
    */
    public function getAboCount() {
        return $this->aboCount;
    }
    
    /**
    * get count of inactive abos
    * @param bool $getRestActive 
    */
    public function getInactiveAbos($getRestActive = false) {
        if (!$getRestActive) {
            return $this->inactiveAbos; 
        }
        else {
            return $this->aboCount > 0 ?  $this->aboCount - $this->inactiveAbos : 0;  
         }
    }
    
    /**
    * get a count from all winners
    * @return int
    */
    public function getWinnerCount() {
        return $this->playerWonCount;
    }

    /**
    * make a Manual Draw
    */
    public function makeManualDraw() {
        $this->makeDraw();
    }

    /*************************************************************
    |                   PUBLIC SET METHODS                       |
    |                                                            |
    *************************************************************/
    
    /**
    * inserts a new statistic log
    * @param string $type
    * @param int $userID (0 = Lottery Bot)
    * @param int $aboID
    * @param string $message 
    * @return bool 
    */
    public function insertStatsLogs($type = '', $userID = 0, $aboID = 0, $message = '') {
        $statsEvents = Array('incoming', 'outgoing', 'userWin', 'buyAbo', 'deleteAbo', 'newNumbers');
        if(!in_array($type, $statsEvents) || !is_numeric($userID) || empty($message) || !is_numeric($aboID)) {
           return false; 
        }
        return mysql_query("INSERT INTO
                                `lotto_stats`
                            SET
                                `stats_event`      = " . sqlesc($type)    . ",
                                `stats_userID`     = " . intval($userID)  . ",
                                `stats_aboID`      = " . intval($aboID)   . ",
                                `stats_desc`       = " . sqlesc($message) . ",
                                `stats_insertDate` = " . time()
                          ) OR sqlerr(__FILE__,__LINE__);
    }                                                                                                           

    /**
    * updates the user upload, $upOrDown true == +
    * @param int $userID
    * @param int $bytes
    * @param bool 
    */
    public function updateUserUpload($userID = 0, $bytes = 0, $upOrDown = false) {
        if (!is_numeric($bytes)) {
            return false;
        }
        return $updateUpload = mysql_query("UPDATE
                                                `users`
                                            SET
                                                `uploaded` = `uploaded` " . ($upOrDown === false ? '- ' : '+ ') . $bytes . "
                                            WHERE
                                                `id` = " . intval($userID)
                                          ) OR sqlerr(__FILE__,__LINE__);
    }

    /**
    * updates the lottery jackpot, $upOrDown true == +
    * @param int $bytes
    * @param bool $upOrDown
    */
    public function updateLotteryJackpot($bytes = 0, $upOrDown = false) {
        if (!is_numeric($bytes)) {
            return false;
        }
        return mysql_query("UPDATE
                                `lotto_config`
                            SET
                                `lottery_jackpot` = `lottery_jackpot` " . ($upOrDown === false ? '- ' : '+ ') . $bytes . "
                            WHERE
                                `lottery_name` = " . sqlesc($this->lottoName)
                          ) OR sqlerr(__FILE__,__LINE__);
    }

    /*************************************************************
    |               PRIVATE METHODS FOR INTERNAL USE             |
    |                                                            |
    *************************************************************/
        
    /**
    * generate new numbers
    * @param int $count
    * @param int $min
    * @param int $max
    * @return array
    */
    private function generateLottoNumbers($count, $min = 0, $max = NULL)
    {
        $array = range($min, ($max === NULL ? getrandmax() : $max));
        shuffle($array);
        for ($i = 0; $i < $count; ++$i) {
            $numbers[] = $array[$i];
        }
        return is_array($numbers) ? $numbers : false;
    }
    
    /**
    * generate a new SuperInt
    * @param int $min
    * @param int $max
    * @return int
    */
    private function generateSuperInt($min, $max = NULL) {
        $superInt = rand($min, $max === NULL ? getrandmax() : $max);
        return !empty($superInt) ? $superInt : false;
    }

    /**
    * this function checks the time to start the draw
    * OR time to send the Info Message
    */
    private function checkForPlay() {
        if ($this->lottoActive === false) {
            return false;
        }
        $dayNow         = date('j', time());
        $dayLastDraw    = date('j', $this->lastDrawing);
        $dayLastInfoPM  = date('j', $this->lastInfoMessage);
        $hourNow        = date('G');
        $hourForMessage = $this->lottoWinHour == 0 ? 23 : $this->lottoWinHour - 1;
        
        if (in_array(date('w'), $this->lottoDays) && $hourNow == $hourForMessage && $dayNow != $dayLastInfoPM) {
            $this->sendInfoMessage();
        }
        if (in_array(date('w'), $this->lottoDays) && $dayNow != $dayLastDraw && $hourNow == $this->lottoWinHour) {
            $this->makeDraw();
        }                   
    }
    
    /**
    * set aboWonCount + 1 and log the overall won bytes
    * @param mixed $aboID
    * @param mixed $winBytes
    */
    private function aboStatisticUpdate($aboID = 0, $winBytes = 0) {
        if (!is_numeric($winBytes)) {
            return false;
        }
        return mysql_query("UPDATE
                                `lotto_abonnement`
                            SET
                                `abo_aboWonBytes` = `abo_aboWonBytes` + " . $winBytes . ",
                                `abo_aboWonCount` = `abo_aboWonCount` + 1
                            WHERE
                                `abo_id` = " . intval($aboID)
                          ) OR sqlerr(__FILE__,__LINE__);

    }
    
    /**
    * set abos length - 1 
    * set timestamp for last draw
    */
    private function aboCountDown() {
        return mysql_query("UPDATE
                                `lotto_abonnement`
                           SET
                                `abo_length`      = `abo_length` - 1,
                                `abo_lastDrawing` = " . time() . "
                           WHERE
                                `abo_length` > 0
                           AND
                                `abo_userNumbers` IS NOT NULL
                   ") OR sqlerr(__FILE__,__LINE__);
    }            
    
    /**
    * update the configs from the lottery
    * like jackpot and statistics
    * @param array $winnerArray
    * @param array $newNumbers
    * @param int $newSuperInt
    * @param int $decreaseJackpot
    */
    private function updateLotteryConfig($winnerArray, $newNumbers, $newSuperInt = 0, $decreaseJackpot = 0) {
        if (!is_numeric($decreaseJackpot)) {
            return false;
        }
        return mysql_query("UPDATE
                                `lotto_config`
                            SET
                                " . ($this->withSuperInt === false ? '' : '`lottery_lastSuperInt` = '.intval($newSuperInt) . ',') . "
                                `lottery_jackpot`        = `lottery_jackpot` - " . $decreaseJackpot . ",
                                `lottery_lastNumber`     = " . sqlesc(implode(',', $newNumbers)) . ",
                                `lottery_lastDrawing`    = " . time() . ",
                                `lottery_drawCount`      = `lottery_drawCount` + 1,
                                `lottery_playerWonCount` = `lottery_playerWonCount` + " . count($winnerArray) . ",
                                `lottery_jackpotOutput`  = `lottery_jackpotOutput` + " . $decreaseJackpot . "
                            WHERE
                                `lottery_name` = " . sqlesc($this->lottoName) ."
                   ") OR sqlerr(__FILE__,__LINE__);
    }
    
    /**
    * send the Info Messages
    */
    private function sendInfoMessage() {
        $aboMessageQuery = mysql_query("SELECT
                                            `abo_userID`
                                        FROM
                                            `lotto_abonnement`
                                        WHERE
                                            `abo_infoMessage` = 'yes'
                                        AND
                                            `abo_length` > 0
                                        AND
                                            `abo_userNumbers` IS NULL
                                        OR
                                            `abo_lastNumberChange` < " . (time() - 86400) . "
                                        GROUP BY
                                            `abo_userID`
                                      ") OR sqlerr(__FILE__,__LINE__);
        
        if (mysql_num_rows($aboMessageQuery) > 0) {
            $subject  = 'Lotterie Info';
            $message  = 'Die Lotterie startet um ' . $this->lottoWinHour .' Uhr![br][br]';
            $message .= 'Wenn Du Deine Zahlen &auml;ndern m&ouml;chtest schau in den Abo Manager![br][br]Viel Erfolg w&uuml;nscht der Lotterie Bot!'; 
            while ($aboMessage = mysql_fetch_assoc($aboMessageQuery))
            {
                sendPersonalMessage(0, $aboMessage['abo_userID'], $subject, $message, PM_FOLDERID_INBOX, 0);
            }
            mysql_query("UPDATE
                             `lotto_config`
                         SET
                             `lottery_lastInfoMessage` = " . time() . "
                         WHERE 
                             `lottery_name` = " . sqlesc($this->lottoName)
                       ) OR sqlerr(__FILE__,__LINE__);
        }
    }
 
    /**
    * make numbers and the winner array
    */
    private function getLotteryWinner() {
        $this->newNumbers  = $this->generateLottoNumbers(6, 1, 49);
        $this->newSuperInt = $this->withSuperInt === false ? false : $this->generateSuperInt(0, 9); 
        // get the abos with a lifetime bigger as 0 
        $userAboQuery = mysql_query("SELECT
                                         *
                                     FROM
                                         `lotto_abonnement`
                                     WHERE
                                         `abo_length` > 0
                                     AND
                                         `abo_userNumbers` IS NOT NULL"
                                   ) OR sqlerr(__FILE__,__LINE__);
        if (mysql_num_rows($userAboQuery) > 0) {
            // check numbers and build the winner array
            while ($userAbo = mysql_fetch_assoc($userAboQuery))
            { 
                $aUserNumbers = explode(',', $userAbo['abo_userNumbers']);
                $iWinCount    = 0;
                $bSuperInt    = false;
                $aWhich       = Array();
                
                // usernumber match with new numbers, select the matched numbers
                foreach ($aUserNumbers AS $vUserNumber) 
                {
                    if(in_array($vUserNumber, $this->newNumbers)) {
                        $iWinCount++;
                        $aWhich[] = $vUserNumber;
                    } 
                }
                
                // superint is activ, user superint match with new supernint, abo have booked the superint
                if ($userAbo['abo_superInt'] == $this->newSuperInt && $userAbo['abo_superIntActive'] == 'yes') {
                    $bSuperInt = true;
                }
                
                // builds the winner array if the abo won
                if($iWinCount > 0) {
                    $this->winnerArray[] = Array('winAboID'       => $userAbo['abo_id'],               // aboID
                                                 'winUserID'      => $userAbo['abo_userID'],           // userID
                                                 'winCount'       => $iWinCount,                       // count of right numbers 
                                                 'winSuperInt'    => $bSuperInt,                       // correctly super int true / false
                                                 'userNumbers'    => implode(',', $aWhich),            // right numbers in game
                                                 'withSuperInt'   => $userAbo['abo_superIntActive'],   // abo have booked super int yes / no
                                                 'userSuperInt'   => $userAbo['abo_superInt'],         // user super int
                                                 'aboInfoMessage' => $userAbo['abo_superIntActive']    // info message yes / no       
                                                );
                }
            }
        }
        else {
            return false;
        }
        return true;
    }

    /**
    * generate the winning classes
    */
    private function makeWinningClasses() {
        if (count($this->winnerArray)) {
            foreach ($this->winnerArray AS $winningCount)
            {
                switch ($winningCount['winCount'])
                {
                    case 1 :
                        $winningCount['winSuperInt'] === false ? $this->winningClassOne++   : $this->winningClassOneSZ++;
                    break;
                    case 2 :
                        $winningCount['winSuperInt'] === false ? $this->winningClassTwo++   : $this->winningClassTwoSZ++;
                    break;
                    case 3 :
                        $winningCount['winSuperInt'] === false ? $this->winningClassThree++ : $this->winningClassThreeSZ++;
                    break;
                    case 4 :
                        $winningCount['winSuperInt'] === false ? $this->winningClassFour++  : $this->winningClassFourSZ++;
                    break;
                    case 5 :
                        $winningCount['winSuperInt'] === false ? $this->winningClassFive++  : $this->winningClassFiveSZ++;
                    break;
                    case 6 :
                        $winningCount['winSuperInt'] === false ? $this->winningClassSix++   : $this->winningClassSixSZ++;
                    break;
                }            
            }
        }        
        // calculate the price for users in the matched winning class
        if ($this->winningClassThree > 0) {
            $this->byteForThree   = ($this->jackpot / 100 * self::PERCENT_FOR_THREE)    / $this->winningClassThree;
        }
        if ($this->winningClassThreeSZ > 0) {
            $this->byteForThreeSZ = ($this->jackpot / 100 * self::PERCENT_FOR_THREE_SZ) / $this->winningClassThreeSZ;
        }
        if ($this->winningClassFour > 0) {
            $this->byteForFour    = ($this->jackpot / 100 * self::PERCENT_FOR_FOUR)     / $this->winningClassFour; 
        }
        if ($this->winningClassFourSZ > 0) {
            $this->byteForFourSZ  = ($this->jackpot / 100 * self::PERCENT_FOR_FOUR_SZ)  / $this->winningClassFourSZ;
        }
        if ($this->winningClassFive > 0) {
            $this->byteForFive    = ($this->jackpot / 100 * self::PERCENT_FOR_FIVE)     / $this->winningClassFive;
        }
        if ($this->winningClassFiveSZ > 0) {
            $this->byteForFiveSZ  = ($this->jackpot / 100 * self::PERCENT_FOR_FIVE_SZ)  / $this->winningClassFiveSZ;
        }
        if ($this->winningClassSix > 0) {
            $this->byteForSix     = ($this->jackpot / 100 * self::PERCENT_FOR_SIX)      / $this->winningClassSix;
        }
        if ($this->winningClassSixSZ > 0) {
            $this->byteForSixSZ   = ($this->jackpot / 100 * self::PERCENT_FOR_SIX_SZ)   / $this->winningClassSixSZ;
        }
    }

    /**
    * make a new draw
    */
    private function makeDraw() {
        $this->getLotteryWinner();
        $this->makeWinningClasses();
        // check in which winning class is the user and allocate the price
        if (count($this->winnerArray)) {
            foreach ($this->winnerArray AS $winner)
            {
                $this->userRefund = 0;
                switch ($winner['winCount'])
                {
                    case 1 :
                        switch ($winner['winSuperInt'])
                        {
                            case true :
                                $this->userRefund = self::BYTES_FOR_ONE_SZ;
                            break;
                            default   :
                                $this->userRefund = self::BYTES_FOR_ONE;
                            break;  
                        }
                    break;
                    case 2 :
                        switch ($winner['winSuperInt'])
                        {
                            case true :
                                $this->userRefund = self::BYTES_FOR_TWO_SZ;
                            break;
                            default   :
                                $this->userRefund = self::BYTES_FOR_TWO;
                            break;  
                        }
                    break;
                    case 3 :
                        switch ($winner['winSuperInt'])
                        {
                            case true :
                                $this->userRefund = $this->byteForThreeSZ;
                            break;
                            default   :
                                $this->userRefund = $this->byteForThree;
                            break;  
                        }
                    break;
                    case 4 :
                        switch ($winner['winSuperInt'])
                        {
                            case true :
                                $this->userRefund = $this->byteForFourSZ;
                            break;
                            default   :
                                $this->userRefund = $this->byteForFour;
                            break;  
                        }
                    break;
                    case 5 :
                        switch ($winner['winSuperInt'])
                        {
                            case true :
                                $this->userRefund = $this->byteForFiveSZ;
                            break;
                            default   :
                                $this->userRefund = $this->byteForFive;
                            break;  
                        }
                    break;
                    case 6 :
                        switch ($winner['winSuperInt'])
                        {
                            case true :
                                $this->userRefund = $this->byteForSixSZ;
                            break;
                            default   :
                                $this->userRefund = $this->byteForSix;
                            break;  
                        }
                    break;
                }
                // collect the deductions for the jackpot
                $this->decreaseJackpot += $this->userRefund; 
              
                // add the price to users upload
                $this->updateUserUpload($winner['winUserID'], $this->userRefund, true);
                
                // update the users abo
                $this->aboStatisticUpdate($winner['winAboID'], $this->userRefund);
                
                // if info message on, creates the message, one for all winning abos
                if ($winner['aboInfoMessage'] == 'yes') {
                    $this->winnerMessages[$winner['winUserID']] .= 'Abonnement ID: ' . $winner['winAboID'] . '[br]';
                    $this->winnerMessages[$winner['winUserID']] .= 'Mit deinem Lottoschein hast du ' . $winner['winCount'] . ' Richtige ' . ($winner['winSuperInt'] !== false ? '+ Superzahl' : '') .'![br]';
                    $this->winnerMessages[$winner['winUserID']] .= 'Deine Zahlen die gewonnen haben: ' . str_replace(',', ', ', $winner['userNumbers']) . ($winner['winSuperInt'] !== false ? ' und Superzahl ' . $winner['userSuperInt']  : '') . ' ![br]';
                    $this->winnerMessages[$winner['winUserID']] .= 'Du hast ' .mksize($this->userRefund) . ' auf deinem Upload Konto gutgeschrieben bekommen![br][br]';
                }
                
                // updates the lottery statistics
                $statsInfo = 'Lotterie Gewinn: '. mksize($this->userRefund) . '! ' . $winner['winCount'] .' Richtige (' . str_replace(',', ', ', $winner['userNumbers']) . ($winner['winSuperInt'] !== false ? ' + Superzahl ' . $winner['userSuperInt'] : '') . ')';
                $this->insertStatsLogs('userWin', $winner['winUserID'], $winner['winAboID'], $statsInfo);
            }
        }
        // now we send the message with all infos about the prices
        if (count($this->winnerMessages)) {
            foreach ($this->winnerMessages AS $kUserID => $vMessage)
            {
                $subject   = 'Lotterie Gewinn';
                $vMessage .= 'Weiterhin viel Erfolg![br]mfg Lotterie Bot';
                sendPersonalMessage(0, $kUserID, $subject, $vMessage, PM_FOLDERID_INBOX, 0);
            }
        }        
          
        // all abos have played 
        $this->aboCountDown();
                
        // jackpot updates and lottery config updates
        $this->updateLotteryConfig($this->winnerArray, $this->newNumbers, $this->newSuperInt, $this->decreaseJackpot);
            
        // updates the lottery statistics for jackpot outgoing prices and new numbers
        if (count($this->winnerArray)) {
            $statsInfo = 'Gewinn Verteilung: '. mksize($this->decreaseJackpot) . '! ' . count($this->winnerArray) .' Gewinner.';
        }
        else {
            $statsInfo = 'Keine Gewinner! Keine Jackpot Ausgaben!';    
        }
        $statsNewNumbers = 'Neue Zahlen: ' . implode(', ', $this->newNumbers) . ($this->withSuperInt !== false ? '! Neue Superzahl: ' . $this->newSuperInt . '!': '');
        $this->insertStatsLogs('outgoing', 0, 0, $statsInfo);
        $this->insertStatsLogs('newNumbers', 0, 0, $statsNewNumbers);
    }
}
