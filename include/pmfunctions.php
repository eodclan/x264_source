<?php
// ************************************************************************************//
// * X264 Source
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2015 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************//

/***************************************************
 * "Heute" und "Gestern" ersetzen
 ***************************************************/
function messageDate($date)
{
    $today = date("Y-m-d");
    $yesterday = date("Y-m-d", time()-24*3600);
    
    $date = preg_replace(":$today:", "<b>Heute</b>", $date);
    $date = preg_replace(":$yesterday:", "<b>Gestern</b>", $date);
    $date = preg_replace(": :", ", ", $date);

    return $date;
}

/***************************************************
 * Nachricht(en) löschen
 ***************************************************/
function deletePersonalMessages($delids, $userid = 0)
{
    global $CURUSER;
    
    if ($userid == 0)
        $userid = $CURUSER["id"];
    
    mysql_query("DELETE FROM `messages` WHERE `id` IN ($delids) AND `folder_in`=0 AND `folder_out`=".$GLOBALS["FOLDER"]." AND `sender`=".$userid);
    mysql_query("DELETE FROM `messages` WHERE `id` IN ($delids) AND `folder_out`=0 AND `folder_in`=".$GLOBALS["FOLDER"]." AND `receiver`=".$userid);
    mysql_query("UPDATE `messages` SET `folder_in`=0 WHERE `id` IN ($delids) AND `folder_in`=".$GLOBALS["FOLDER"]." AND `receiver`=".$userid);
    mysql_query("UPDATE `messages` SET `folder_out`=0 WHERE `id` IN ($delids) AND `folder_out`=".$GLOBALS["FOLDER"]." AND `sender`=".$userid);
}

/***************************************************
 * Ordner rekursiv löschen
 ***************************************************/
function deletePMFolder($folder, $msgaction, $msgtarget)
{
    global $CURUSER;
    
    // Unterordner löschen
    $res = mysql_query("SELECT `id` FROM `pmfolders` WHERE `parent`=".$folder);
    while ($subfolder = mysql_fetch_assoc($res))
        deletePMFolder($subfolder["id"], $msgaction, $msgtarget);
    
    // Nachrichten verschieben oder löschen
    $res = mysql_query("SELECT `id` FROM `messages` WHERE (`folder_in`=".$folder." AND `receiver`=".$CURUSER["id"].") OR (`folder_out`=".$folder." AND `sender`=".$CURUSER["id"].")");
    $msgids = array();
    while ($msg = mysql_fetch_assoc($res))
        $msgids[] = $msg["id"];
    $msgids = implode(",", $msgids);
    
    if ($msgaction == "delete")
        deletePersonalMessages($msgids);
    elseif ($msgaction == "move") {
        mysql_query("UPDATE `messages` SET `folder_in`=$msgtarget WHERE `id` IN ($msgids) AND `folder_in`=$folder AND `receiver`=".$CURUSER["id"]);
        mysql_query("UPDATE `messages` SET `folder_out`=$msgtarget WHERE `id` IN ($msgids) AND `folder_out`=$folder AND `sender`=".$CURUSER["id"]);
    }
    
    // Ordner löschen
    mysql_query("DELETE FROM `pmfolders` WHERE `id`=$folder");
}

/***************************************************
 * Ordner für Benutzer initialisieren, falls nötig
 ***************************************************/
function initFolder()
{
    global $CURUSER;
    
    $arr = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `cnt` FROM `pmfolders` WHERE `owner`=".$CURUSER["id"]." AND `name` LIKE '__%'"));
    
    if ($arr["cnt"] == 0) {
        // Ordner erstellen
        mysql_query("INSERT INTO `pmfolders` (`owner`,`name`,`sortfield`,`sortorder`) VALUES (".$CURUSER["id"].",'__inbox','added','DESC')");
        mysql_query("INSERT INTO `pmfolders` (`owner`,`name`,`sortfield`,`sortorder`) VALUES (".$CURUSER["id"].",'__outbox','added','DESC')");
        mysql_query("INSERT INTO `pmfolders` (`owner`,`name`,`sortfield`,`sortorder`) VALUES (".$CURUSER["id"].",'__system','added','DESC')");
        mysql_query("INSERT INTO `pmfolders` (`owner`,`name`,`sortfield`,`sortorder`) VALUES (".$CURUSER["id"].",'__mod','added','DESC')");
    }
}

/***************************************************
 * Ordner-Link anzeigen
 ***************************************************/
function folderLine($id, $name, $image, $indent = 0, $mode = 'normal')
{
    global $CURUSER;
    
    $name = htmlspecialchars($name);
    $active = $id == $GLOBALS["FOLDER"];
    $linkadd = "";
       
    // Ungelesene Nachrichten
    if ($id != PM_FOLDERID_MOD)
        $arr = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `receiver`=$CURUSER[id] AND `folder_in`=$id AND `unread`='yes'"));
    else {
        if ($name == "Erledigt") {
            $active = $active && $_REQUEST["closed"] == 1;
            $arr["cnt"] = 0;
            $linkadd = "&amp;closed=1";
        } else {
            $active = $active && !isset($_REQUEST["closed"]);
            $arr = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `receiver`=0 AND `mod_flag`='open'"));
        }
    }
    $unread = $arr["cnt"];
    
    switch ($mode) {
        case "option":
            echo '<option value="'.$id.'">'.($indent?str_repeat ("&nbsp;&nbsp;&nbsp;", $indent):'').' '.$name.'</option>'."\n";
            break;
            
        case "normal":
            echo '<tr><td class="'.($active?'table-bordered':'table-bordered').'" style="text-align: left;padding:0px;" nowrap="nowrap"><a href="messages.php?folder='.$id.$linkadd.'" style="display:block;padding:4px;'.($indent?'padding-left:'.($indent*16+4).'px;':'').'text-decoration:none;"><i class="'.$image.'"></i>&nbsp;'.$name.($unread>0?'&nbsp;(<b>'.$unread.'</b>)':'').'</a></td></tr>'."\n";
            break;
    
        case "config":
            echo '<tr><td class="'.($active?'table-bordered':'table-bordered').'" style="text-align: left;padding:0px;" nowrap="nowrap"><a href="messages.php?folder='.$id.'" style="display:block;padding:4px;'.($indent?'padding-left:'.($indent*16+4).'px;':'').'text-decoration:none;"><i class="'.$image.'"></i>&nbsp;'.$name.($unread>0?'&nbsp;(<b>'.$unread.'</b>)':'').'</a></td></tr>'."\n";
            break;
    }
}

/***************************************************
 * Benutzerdefinierte Ordner rekursiv anzeigen
 ***************************************************/
function getFolders($currentFolder = 0, $indent = 0, $mode = 'normal', $exclude = 0)
{
    global $CURUSER;
    
    // Benutzerdefinierte Ordner
    $folder_res = mysql_query("SELECT * FROM `pmfolders` WHERE `owner`=".$CURUSER["id"]." AND `parent`=".$currentFolder." ORDER BY `name` ASC");
    
    while ($folder = mysql_fetch_assoc($folder_res)) {
        if (substr($folder["name"], 0, 2) == "__")
            continue;
        
        if ($exclude && $folder["id"] == $exclude)
            continue;
            
        folderLine($folder["id"], $folder["name"], "folder.png", $indent, $mode);
        getFolders($folder["id"], $indent+1, $mode);
    }
}

/***************************************************
 * Nachrichtenzeile
 ***************************************************/
function messageLine($arr, $msgnr)
{
    global $CURUSER;
    
    if ($arr["sender"] == 0)
        $senderlink = "System";
    elseif ($arr["sendername"]!="")
        $senderlink = '<a href="userdetails.php?id='.$arr["sender"].'">'.htmlspecialchars($arr["sendername"]).'</a>';
    else
        $senderlink = "---";
    
    if ($arr["receiver"] == 0)
        $receiverlink = "Tracker-Team";
    elseif ($arr["receivername"]!="")
        $receiverlink = '<a href="userdetails.php?id='.$arr["receiver"].'">'.htmlspecialchars($arr["receivername"]).'</a>';
    else
        $receiverlink = "---";
        
    $arr["added"] = messageDate($arr["added"]);

    $unread_image = "";
    if ($arr["folder_in"] == PM_FOLDERID_MOD) {
        if ($arr["mod_flag"]=="open") {
            $unread = TRUE;
            $unread_image .= "fa-map";
            $unread_image_title = "Zu Bearbeiten";
        } else {
            $unread = FALSE;
            $unread_image .= "ok.png";
            $unread_image_title = "Erledigt";
        }
    } else {
        if ($arr["unread"]=="yes") {
            $unread = TRUE;
            $unread_image .= "fa-mail-reply";
            $unread_image_title = "Ungelesen";
        } else {
            $unread = FALSE;
            $unread_image .= "fa-mail-forward";
            $unread_image_title = "Gelesen";
        }
    }

?>
<tr>
  <td class="table-bordered"><input id="chkbox<?=$msgnr?>" type="checkbox" name="selids[]" value="<?=$arr["id"]?>" class="btn btn-flat btn-primary fc-today-button"></td>
  <td class="table-bordered"><a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=mark<?=($arr["folder_in"] == PM_FOLDERID_MOD?($unread?"closed":"open"):($unread?"read":"unread"))?>&amp;id=<?=$arr["id"]?>"><i class="fa <?=$unread_image?>"></i></a>&nbsp;<a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=read&amp;id=<?=$arr["id"]?>"><?=($unread?"<b>".htmlspecialchars($arr["subject"])."</b>":htmlspecialchars($arr["subject"]))?></a></td>
  <td class="table-bordered"><?=$senderlink?></td>
  <td class="table-bordered"><?=$receiverlink?></td>
  <td class="table-bordered" nowrap="nowrap"><?=$arr["added"]?></td>
  <td class="table-bordered" nowrap="nowrap">
    <? if ($arr["receiver"] > 0) { ?>
    <a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=delete&amp;id=<?=$arr["id"]?>"><i class="fa fa-trash-o" title="Nachricht löschen"></i></a>
    <? } else { ?>
    <i class="fa fa-trash" title="Nachricht löschen"></i>
    <? } ?>
    
    <? if ($arr["receiver"] == $CURUSER["id"] && $arr["sender"] > 0 && $senderlink != "---") { ?>
    <a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=reply&amp;id=<?=$arr["id"]?>"><i class="fa fa-envelope-o" title="Nachricht Antworten"></i></a>
    <? } else { ?>
    <img src="<?=$GLOBALS["PIC_BASE_URL"]?>pm/mail_reply_disabled.png" alt="Antworten" title="Antworten" style="border:none;">
    <? } ?>
    
    <? if ($arr["receiver"] > 0 && $arr["sender"] > 0) { ?>
    <a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=move&amp;id=<?=$arr["id"]?>"><i class="fa fa-exchange" title="Nachricht verschieben"></i></a>
    <? } else { ?>
    <i class="fa fa-exchange" title="Nachricht verschieben"></i>
    <? } ?>
  </td>
</tr>
<?php
}

/***************************************************
 * Besitzerrechte der gewählten Nachricht(en) prüfen
 ***************************************************/
function checkMessageOwner($owner = "")
{
    global $CURUSER;

    if ($owner == "") {
        // Anhängig von action entscheiden, ob Sender oder Receiver stimmen muss
        switch ($_REQUEST["action"]) {
            case "markopen":
            case "markclosed":
                if ($CURUSER["class"] < UC_MODERATOR)
                    stderr("Fehler", "Du hast für diese Aktion keine ausreichende Berechtigung!");
                $owner = "team";
                break;
                
            case "markread":
            case "markunread":
            case "reply":
                $owner = "receiver";
                break;
                
            case "delete":
            case "move":
                $owner = "any";
                break;
                
            case "read":
                if ($CURUSER["class"] < UC_MODERATOR)
                    $owner = "any";
                else
                    $owner = "any+team";
                break;
    
            default:
                stderr("Fehler", "Diese Aktion ist ungültig!");
        }
    }
    
    if (isset($_REQUEST["id"])) {
        $msgid = intval($_REQUEST["id"]);
        $tgtcount = 1;
        if ($owner == "receiver")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id`=$msgid AND `receiver`=".$CURUSER["id"]." AND folder_in <> 0";
        elseif ($owner == "any")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id`=$msgid AND ((`receiver`=".$CURUSER["id"]." AND folder_in <> 0) OR (`sender`=".$CURUSER["id"]." AND folder_out <> 0))";
        elseif ($owner == "team")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id`=$msgid AND `receiver`=0 AND `sender`=0 AND `folder_in`=".PM_FOLDERID_MOD;
        elseif ($owner == "any+team")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id`=$msgid AND ((`receiver`=0 AND `sender`=0 AND `folder_in`=".PM_FOLDERID_MOD.") OR ((`receiver`=".$CURUSER["id"]." AND folder_in <> 0) OR (`sender`=".$CURUSER["id"]." AND folder_out <> 0)))";
    } elseif (is_array($_REQUEST["selids"])) {
        $tgtcount = count($_REQUEST["selids"]);
        $selids = implode(",", $_REQUEST["selids"]);
        if ($owner == "receiver")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id` IN ($selids) AND `receiver`=".$CURUSER["id"]." AND folder_in <> 0";
        elseif ($owner == "any")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id` IN ($selids) AND ((`receiver`=".$CURUSER["id"]." AND folder_in <> 0) OR (`sender`=".$CURUSER["id"]." AND folder_out <> 0))";
        elseif ($owner == "team")
            $query = "SELECT COUNT(*) AS `cnt` FROM `messages` WHERE `id` IN ($selids) AND `receiver`=0 AND `sender`=0 AND `folder_in`=".PM_FOLDERID_MOD;
    }
    
    $arr = mysql_fetch_assoc(mysql_query($query));

    if ($arr["cnt"] <> $tgtcount)
        stderr("Fehler", "<p>Du hast für mindestens eine der ausgewählten Nachrichten keine ausreichende Berechtigung für die gewünschte Aktion.</p><p>Beachte, dass Du nur Nachrichten als gelesen bzw. ungelesen markieren kannst, die Du empfangen hast!</p>");
}

/***************************************************
 * Besitzerrechte des Ordners prüfen
 ***************************************************/
function checkFolderOwner($folder)
{
    global $CURUSER;

    if ($folder <= 0)
        stderr("Fehler", "Du hast keinen bzw. einen ungültigen Zielordner ausgewählt.");
    
    $arr = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS `cnt` FROM `pmfolders` WHERE `id`=".intval($folder)." AND `owner`=".$CURUSER["id"]));

    if ($arr["cnt"] == 0)
        stderr("Fehler", "Du hast nicht die erforderlichen Zugriffsrechte für den angegebenen Ordner, oder der Ordner existiert nicht.");
}

/***************************************************
 * Persönliche Nachricht erstellen
 ***************************************************/
function sendPersonalMessage($sender, 
                              $receiver, 
                              $subject, 
                              $body, 
                              $folder_in = PM_FOLDERID_INBOX, 
                              $folder_out = PM_FOLDERID_OUTBOX, 
                              $mod_flag = "")
{
    global $CURUSER;
    
    if ($sender == $CURUSER["id"] && $receiver > 0) {
        $user = @mysql_fetch_assoc(mysql_query("SELECT `notifs`,`email`,UNIX_TIMESTAMP(`last_access`) as `la` FROM `users` WHERE `id`=$receiver"));
        if (!is_array($user))
            stderr("Fehler", "Der Empfänger konnte nicht ermittelt werden.");
    }
    
    $queryset = array();
    $queryset[] = $sender;
    $queryset[] = $receiver;
    $queryset[] = $folder_in;
    $queryset[] = $folder_out;
    $queryset[] = "NOW()";
    $queryset[] = sqlesc($subject);
    $queryset[] = sqlesc($body);
    $queryset[] = sqlesc($mod_flag);
    
    $query = "INSERT INTO `messages` (`sender`,`receiver`,`folder_in`,`folder_out`,`added`,`subject`,`msg`,`mod_flag`) VALUES (";
    $query .= implode(",", $queryset).")";
    
    mysql_query($query);
    $msgid = mysql_insert_id();
    
    // Benachrichtigen, wenn Nachricht von einem User an einen anderen versendet wurde
    if ($sender == $CURUSER["id"] && $receiver > 0 && strpos($user["notifs"], "[pm]") !== FALSE) {
        if (time() - $user["la"] >= 300) {
            $body = <<<EOD
Du hast eine neue persönliche Nachricht von {$CURUSER["username"]} erhalten!

Du kannst die untenstehende URL benutzen, um die Nachricht anzusehen.
Du musst Dich eventuell einloggen, um die Nachricht zu sehen.

$DEFAULTBASEURL/messages.php?action=read&id=$msgid

--
{$GLOBALS["SITENAME"]}
EOD;
            @mail($user["email"], "Du hast eine Nachricht von ".$CURUSER["username"]." erhalten!",
	    	$body, "From: ".$GLOBALS["SITEEMAIL"]);
        }
    }
}

/***************************************************
 * Neuen Ordner erstellen
 ***************************************************/
function createFolderDialog()
{
    global $CURUSER;
    
    if (isset($_POST["docreate"])) {
        $parent = intval($_POST["parent"]);
        $prunedays = intval($_POST["prunedays"]);
        
        if ($GLOBALS["PM_PRUNE_DAYS"] > 0 && $prunedays == 0)
            $prunedays = $GLOBALS["PM_PRUNE_DAYS"];
        
        if ($parent > 0)
            checkFolderOwner($parent);
        elseif ($parent < 0)
            stderr("Fehler", "Du hast keinen gültigen Ordner ausgewählt, unter dem der neue Ordner erstellt werden soll.");
            
        if ($_POST["foldername"] == "")
            stderr("Fehler", "Du musst einen Ordnernamen angeben!");
            
        if (substr($_POST["foldername"], 0, 2) == "__")
            stderr("Fehler", "Der Ordnername darf nicht mit __ beginnen!");
            
        if (strlen($_POST["foldername"]) > 120)
            stderr("Fehler", "Der angegebene Ordnername ist zu lang. Es sind maximal 120 Zeichen erlaubt.");
            
        if ($GLOBALS["PM_PRUNE_DAYS"] > 0 && $prunedays > $GLOBALS["PM_PRUNE_DAYS"])
            stderr("Fehler", "Die maximale Vorhaltezeit beträgt ".$GLOBALS["PM_PRUNE_DAYS"]." Tage.");
            
        if (!in_array($_POST["sortfield"], array('added','subject','sendername','receivername')))
            stderr("Fehler", "Das angegebene Sortierfeld ist ungültig.");
            
        if ($_REQUEST["sortorder"] != "ASC" && $_POST["sortorder"] != "DESC")
            stderr("Fehler", "Die angegebene Sortierreihenfolge ist ungültig.");
            
        // Alles OK, Ordner erstellen
        $queryset = array();
        $queryset[] = $parent;
        $queryset[] = $CURUSER["id"];
        $queryset[] = sqlesc($_POST["foldername"]);
        $queryset[] = sqlesc($_POST["sortfield"]);
        $queryset[] = sqlesc($_POST["sortorder"]);
        $queryset[] = $prunedays;
        $query = "INSERT INTO `pmfolders` (`parent`,`owner`,`name`,`sortfield`,`sortorder`,`prunedays`) VALUES (";
        $query .= implode(",", $queryset) . ")";

        mysql_query($query);
        
        stderr("Ordner erfolgreich erstellt", "<p>Der Ordner '".htmlspecialchars($_POST["foldername"])."' wurde erfolgreich erstellt.</p><p><a href=\"messages.php?folder=".mysql_insert_id()."\">Weiter zum neuen Ordner</a><br><a href=\"messages.php?folder=".$GLOBALS["FOLDER"]."\">Zurück zum zuletzt aufgerufenen Ordner</a></p>");
    }

    x264_header("Neuen PM-Ordner erstellen");
    //begin_frame('<img src="'.$GLOBALS["PIC_BASE_URL"].'pm/folder_new22.png" height="22" alt="new" style="vertical-align: middle;width:22"> Neuen PM-Ordner erstellen', FALSE, "600px;");
    ?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-envelope-o'></i> Neuen PM-Ordner erstellen
                                    <div class='card-actions'>									
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>	
<form action="messages.php" method="post">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<input type="hidden" name="action" value="createfolder">
    <?php
    begin_table(TRUE);
    ?>
  <tr>
    <td class="table-bordered">Ordnername:</td>
    <td class="table-bordered"><input type="text" name="foldername" size="60" maxlength="120" class="btn btn-flat btn-primary fc-today-button"></td>
  </tr>
  <tr>
    <td class="table-bordered">Erstellen in Ordner:</td>
    <td class="table-bordered">
      <select name="parent" size="6" style="width: 450px;">
        <option value="0" selected="selected">Oberste Ebene</option>
        <?php getFolders(0, 1, TRUE); ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="table-bordered">Sortieren nach:</td>
    <td class="table-bordered">
      <select name="sortfield" size="1">
        <option value="subject">Betreff</option>
        <option value="sendername">Absender</option>
        <option value="receivername">Empfänger</option>
        <option value="added" selected="selected">Datum</option>
      </select>
      <select name="sortorder" size="1">
        <option value="ASC">Aufsteigend</option>
        <option value="DESC" selected="selected">Absteigend</option>
      </select>
    </td>
  </tr>
  <tr>
    <td class="table-bordered">Vorhaltezeit (Tage):</td>
    <td class="table-bordered"><input type="text" name="prunedays" size="10" maxlength="5" class="btn btn-flat btn-primary fc-today-button"> (<?=($GLOBALS["PM_PRUNE_DAYS"]?"Maximal ".$GLOBALS["PM_PRUNE_DAYS"]." Tage, 0 oder leer für Maximum":"0 oder leer für unbegrenzte Vorhaltezeit")?>)</td>
  </tr>
  <tr>
    <td class="table-bordered" colspan="2" style="text-align:center"><input type="submit" name="docreate" value="Ordner erstellen" class="btn btn-flat btn-primary fc-today-button"></td>
  </tr>
    <?php
    end_table();
    ?>
</form>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
    <?php
    //end_frame();
    x264_footer();
}

/***************************************************
 * Ordner konfigurieren
 ***************************************************/
function folderConfigDialog()
{
    global $CURUSER, $finfo;
    
    switch ($finfo["name"]) {
        case "__inbox":
            $changename = FALSE;
            $finfo["name"] = "Posteingang";
            break;
    
        case "__outbox":
            $changename = FALSE;
            $finfo["name"] = "Posteingang";
            break;
            
        case "__system":
            $changename = FALSE;
            $finfo["name"] = "Systemnachrichten";
            break;
            
        case "__mod":
            stderr("Fehler", "An diesem Ordner können keine Einstellungen vorgenommen werden.");
            break;
            
        default:
            $changename = TRUE;
    }
    
    if (isset($_POST["dosave"])) {
        $prunedays = intval($_POST["prunedays"]);
        
        if ($GLOBALS["PM_PRUNE_DAYS"] > 0 && $prunedays == 0)
            $prunedays = $GLOBALS["PM_PRUNE_DAYS"];
        
        if ($changename && $_POST["foldername"] == "")
            stderr("Fehler", "Du musst einen Ordnernamen angeben!");
            
        if ($changename && substr($_POST["foldername"], 0, 2) == "__")
            stderr("Fehler", "Der Ordnername darf nicht mit __ beginnen!");
            
        if ($changename && strlen($_POST["foldername"]) > 120)
            stderr("Fehler", "Der angegebene Ordnername ist zu lang. Es sind maximal 120 Zeichen erlaubt.");
            
        if ($GLOBALS["PM_PRUNE_DAYS"] > 0 && $prunedays > $GLOBALS["PM_PRUNE_DAYS"])
            stderr("Fehler", "Die maximale Vorhaltezeit beträgt ".$GLOBALS["PM_PRUNE_DAYS"]." Tage.");
            
        if (!in_array($_POST["sortfield"], array('added','subject','sendername','receivername')))
            stderr("Fehler", "Das angegebene Sortierfeld ist ungültig.");
            
        if ($_REQUEST["sortorder"] != "ASC" && $_POST["sortorder"] != "DESC")
            stderr("Fehler", "Die angegebene Sortierreihenfolge ist ungültig.");
            
        // Alles OK, Ordner erstellen
        $queryset = array();
        if ($changename)
            $queryset[] = "`name` = ".sqlesc($_POST["foldername"]);
        $queryset[] = "`sortfield` = ".sqlesc($_POST["sortfield"]);
        $queryset[] = "`sortorder` = ".sqlesc($_POST["sortorder"]);
        $queryset[] = "`prunedays` = ".$prunedays;
        $query = "UPDATE `pmfolders` SET ".implode(",", $queryset)." WHERE `id`=".$finfo["id"];
        
        mysql_query($query);
        
        stderr("Ordner erfolgreich geändert", "<p>Der Ordner '".htmlspecialchars($_POST["foldername"])."' wurde erfolgreich geändert.</p><p><a href=\"messages.php?folder=".$GLOBALS["FOLDER"]."\">Zurück zum zuletzt aufgerufenen Ordner</a></p>");
    }
    
    x264_header("Ordner '".$finfo["name"]."' konfigurieren");
    //begin_frame('<img src="'.$GLOBALS["PIC_BASE_URL"].'pm/configure22.png" height="22" alt="Konfigurieren" style="vertical-align: middle;width:22"> Ordner \''.htmlspecialchars($finfo["name"]).'\' konfigurieren', FALSE, "600px;");
print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-envelope-o'></i> Ordner ".htmlspecialchars($finfo["name"])." konfigurieren
                                    <div class='card-actions'>									
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	
    ?>								
<form action="messages.php" method="post">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<input type="hidden" name="action" value="config">
    <?php
    begin_table(TRUE);
    ?>
  <tr>
    <td class="table-bordered">Ordnername:</td>
    <td class="table-bordered"><? if ($changename) { ?><input type="text" name="foldername" size="60" maxlength="120" class="btn btn-flat btn-primary fc-today-button" value="<?=htmlspecialchars($finfo["name"])?>"><? } else { echo htmlspecialchars($finfo["name"]); } ?></td>
  </tr>
  <tr>
    <td class="table-bordered">Sortieren nach:</td>
    <td class="table-bordered">
      <select name="sortfield" size="1">
        <option value="added"<?=($finfo["sortfield"]=="added"?' selected="selected"':'')?>>Datum</option>
        <option value="subject"<?=($finfo["sortfield"]=="subject"?' selected="selected"':'')?>>Betreff</option>
        <option value="sendername"<?=($finfo["sortfield"]=="sendername"?' selected="selected"':'')?>>Absender</option>
        <option value="receivername"<?=($finfo["sortfield"]=="receivername"?' selected="selected"':'')?>>Empfänger</option>
      </select>
      <select name="sortorder" size="1">
        <option value="ASC"<?=($finfo["sortorder"]=="ASC"?' selected="selected"':'')?>>Aufsteigend</option>
        <option value="DESC"<?=($finfo["sortorder"]=="DESC"?' selected="selected"':'')?>>Absteigend</option>
      </select>
    </td>
  </tr>
  <tr>
    <td class="table-bordered">Vorhaltezeit (Tage):</td>
    <td class="table-bordered"><input type="text" name="prunedays" size="10" maxlength="5" class="btn btn-flat btn-primary fc-today-button" value="<?=$finfo["prunedays"]?>"> (<?=($GLOBALS["PM_PRUNE_DAYS"]?"Maximal ".$GLOBALS["PM_PRUNE_DAYS"]." Tage, 0 oder leer für Maximum":"0 oder leer für unbegrenzte Vorhaltezeit")?>)</td>
  </tr>
  <tr>
    <td class="table-bordered" colspan="2" style="text-align:center"><input type="submit" name="dosave" value="Einstellungen übernehmen" class="btn btn-flat btn-primary fc-today-button"></td>
  </tr>
    <?php
    end_table();
    ?>
<form>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
    <?php
    //end_frame();
    x264_footer();
}

/***************************************************
 * Ordner löschen
 ***************************************************/
function deleteFolderDialog()
{
    global $CURUSER, $finfo;

    if ($GLOBALS["FOLDER"] < 0)
        stderr("Fehler", "Die Standardordner können nicht gelöscht werden!");

    if (isset($_POST["dodelete"])) {
        if ($_POST["msgaction"] != "delete" && $_POST["msgaction"] != "move")
            stderr("Fehler", "Falsche Operation für Nachrichten!");
            
        if ($_POST["msgaction"] == "move") {
            if (!isset($_POST["to_folder"]) || intval($_POST["to_folder"]) == 0)
                stderr("Fehler", "Du musst einen Zielordner für die Nachrichten auswählen!");
        
            $target_folder = intval($_POST["to_folder"]);
            
            if ($target_folder == PM_FOLDERID_SYSTEM || $target_folder == PM_FOLDERID_MOD)
                stderr("Fehler", "In diesen Ordner können keine Nachrichten verschoben werden!");
                
            if ($target_folder != PM_FOLDERID_INBOX && $target_folder != PM_FOLDERID_OUTBOX)
                checkFolderOwner($target_folder);
        } else {
            $target_folder = 0;
        }
        
        deletePMFolder($GLOBALS["FOLDER"], $_POST["msgaction"], $target_folder);
        
        stderr("Ordner erfolgreich gelöscht", "<p>Der Ordner '".htmlspecialchars($finfo["name"])."' wurde erfolgreich gelöscht.</p><p><a href=\"messages.php?folder=".PM_FOLDERID_INBOX."\">Zurück zum Posteingang</a></p>");
    }

    x264_header("Ordner '".$finfo["name"]."' löschen");
    //begin_frame('<img src="'.$GLOBALS["PIC_BASE_URL"].'pm/editdelete22.png" height="22" alt="" style="vertical-align: middle;width:22"> '."Ordner '".htmlspecialchars($finfo["name"])."' löschen", FALSE, "600px;");
print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-envelope-o'></i> Ordner '".htmlspecialchars($finfo["name"])."' löschen
                                    <div class='card-actions'>									
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
    ?>								
<p>Du bist im Begriff, den Ordner '<?=htmlspecialchars($finfo["name"])?>' und alle enthaltenen Unterordner zu löschen.
Bitte gib an, was mit den enthaltenen Nachrichten geschehen soll, und klicke zur Bestätigung auf 'Löschen'.</p>
<form action="messages.php" method="post">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<input type="hidden" name="action" value="deletefolder">
    <?
    begin_table(TRUE);
    ?>
  <tr>
    <td class="table-bordered"><input type="radio" name="msgaction" value="delete" checked="checked" class="btn btn-flat btn-primary fc-today-button"> Nachrichten löschen</td>
  </tr>
  <tr>
    <td class="table-bordered">
      <input type="radio" name="msgaction" value="move" class="btn btn-flat btn-primary fc-today-button"> Nachrichten verschieben nach: 
        <select name="to_folder" size="1" class="btn btn-flat btn-primary fc-today-button">
        <option>** Bitte Ordner auswählen **</option>
        <option value="<?=PM_FOLDERID_INBOX?>">Posteingang</option>
        <option value="<?=PM_FOLDERID_OUTBOX?>">Postausgang</option>
        <?php
                getFolders(0, 0, 'option', $GLOBALS["FOLDER"]);
        ?>
        </select>
    </td>
  </tr>
  <tr>
    <td class="table-bordered" style="text-align:center;">
      <input type="submit" name="dodelete" value="Löschen" class="btn btn-flat btn-primary fc-today-button">
    </td>
  </tr>
    <?
    end_table();
    ?>
</form>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
    <?
    //end_frame();
    x264_footer();

}

/***************************************************
 * Zielordner für Verschieben auswählen
 ***************************************************/
function selectTargetFolderDialog($selids)
{
    x264_header("Nachricht(en) verschieben");
    //begin_frame('<img src="'.$GLOBALS["PIC_BASE_URL"].'pm/2rightarrow22.png" height="22" alt="rechts" style="vertical-align: middle;width:22"> Nachricht(en) verschieben', FALSE, "600px;");
    ?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-envelope-o'></i> Nachricht(en) verschieben
                                    <div class='card-actions'>									
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>	
<center>
<p>Bitte wähle einen Zielordner aus, in den Du die Nachricht(en) verschieben willst:</p>
<form action="messages.php" method="post">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<? if (strpos($selids, ",") === FALSE) { ?>
<input type="hidden" name="id" value="<?=$selids?>">
<? } else {
    $arr = explode(",", $selids);
    for ($I=0; $I<count($arr); $I++)
        echo '<input type="hidden" name="selids[]" value="'.$arr[$I].'">'."\n";
   }
?>
<p>
<select name="to_folder" size="1">
<option>** Bitte Ordner auswählen **</option>
<option value="<?=PM_FOLDERID_INBOX?>">Posteingang</option>
<option value="<?=PM_FOLDERID_OUTBOX?>">Postausgang</option>
<?php
        getFolders(0, 0, 'option');
?>
</select>
<input type="submit" name="move" value="Verschieben" class="btn btn-flat btn-primary fc-today-button">
<input type="submit" value="Abbrechen" class="btn btn-flat btn-primary fc-today-button">
</p>
</center>
</form>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?
    //end_frame();
    x264_footer();
}

/***************************************************
 * Nachricht anzeigen
 ***************************************************/
function displayMessage()
{
    global $CURUSER;
    
    if ((!isset($_REQUEST["id"]) || intval($_REQUEST["id"]) == 0))
        stderr("Fehler", "Die Nachrichten-ID kann nur über den Parameter 'id' übergeben werden - was probierst Du da?!?");

    $msg = mysql_fetch_assoc(mysql_query("SELECT `messages`.*,`sender`.`username` AS `sendername`,`receiver`.`username` AS `receivername`  FROM `messages` LEFT JOIN `users` AS `sender` ON `sender`.`id`=`messages`.`sender` LEFT JOIN `users` AS `receiver` ON `receiver`.`id`=`messages`.`receiver` WHERE `messages`.`id`=".intval($_REQUEST["id"])));

    if ($msg["unread"] == 'yes' && $msg["receiver"] == $CURUSER["id"])
        mysql_query("UPDATE `messages` SET `unread`='' WHERE `id`=".$msg["id"]);
    
    $msg["added"] = messageDate($msg["added"]);
    
    if ($msg["sendername"] == "") {
        if ($msg["sender"] == 0)
            $msg["sendername"] = "System";
        else
            $msg["sendername"] = "Gelöscht";
        $sender_valid = FALSE;
    } else {
        $sender_valid = TRUE;
    }
    
    if ($msg["receivername"] == "") {
        if ($msg["receiver"] == 0)
            $msg["receivername"] = "Team";
        else
            $msg["receivername"] = "Gelöscht";
        $receiver_valid = FALSE;
    } else {
        $receiver_valid = TRUE;
    }
    
    x264_header("Persönliche Nachricht lesen");
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-envelope-o'></i> PM System - Nachricht lesen
                                    <div class='card-actions'>
					<a href='#' class='btn btn-sm btn-info float-left' onclick='javascript:window.print();'><i class='fa fa-print'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
print("<table class=table table-bordered table-striped table-condensed align=center>\n");
print("<tr>");		
    //begin_frame('<img src="'.$GLOBALS["PIC_BASE_URL"].'pm/mail_generic22.png" height="22" alt="" style="vertical-align: middle;width:22"> Persönliche Nachricht lesen', FALSE, "600px;");
    ?>
<form action="messages.php" method="post">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<input type="hidden" name="action" value="read">
<input type="hidden" name="id" value="<?=$msg["id"]?>">
<? if ($sender_valid) { ?>
<input type="hidden" name="receiver" value="<?=$msg["sender"]?>">
<? } ?>

  <colgroup>
    <col style="width:50">
    <col>
  </colgroup>
  <tr>
    <td class="table-bordered" colspan="2"><b>Betreff:</b> <?=htmlspecialchars($msg["subject"])?></td>
  </tr>
  <tr>
    <td class="table-bordered"><b>Absender:</b></td>
    <td class="table-bordered"><?=($sender_valid?'<a href="userdetails.php?id='.$msg["sender"].'">'.htmlspecialchars($msg["sendername"]).'</a>':htmlspecialchars($msg["sendername"]))?></td>
  </tr>
  <tr>
    <td class="table-bordered"><b>Empfänger:</b></td>
    <td class="table-bordered"><?=($receiver_valid?'<a href="userdetails.php?id='.$msg["receiver"].'">'.htmlspecialchars($msg["receivername"]).'</a>':htmlspecialchars($msg["receivername"]))?></a></td>
  </tr>
  <tr>
    <td class="table-bordered"><b>Datum:</b></td>
    <td class="table-bordered"><?=$msg["added"]?></td>
  </tr>
  <tr>
    <td class="table-bordered" valign="top"><b>Nachricht:</b></td>
    <td class="table-bordered"><?=format_comment($msg["msg"])?></td>
  </tr>
  <tr>
    <td class="table-bordered" style="text-align:center;" colspan="2">
      <? if ($msg["folder_in"] != PM_FOLDERID_MOD) { ?>
      <input type="submit" name="delete" value="Nachricht löschen" class="btn btn-flat btn-primary fc-today-button">
      <? if ($msg["receiver"] == $CURUSER["id"] && $msg["sender"] > 0 && $msg["sendername"] != "Gelöscht") { ?>
      <input type="submit" name="reply" value="Antworten" class="btn btn-flat btn-primary fc-today-button">
      <? } ?>
        <select name="to_folder" size="1" class="btn btn-flat btn-primary fc-today-button">
            <option>** Bitte Ordner auswählen **</option>
            <option value="<?=PM_FOLDERID_INBOX?>">Posteingang</option>
            <option value="<?=PM_FOLDERID_OUTBOX?>">Postausgang</option>
<?php
        getFolders(0, 0, TRUE);
?>
          </select>
          <input type="submit" name="move" value="Verschieben" class="btn btn-flat btn-primary fc-today-button">
      <? } ?>
      <? if ($msg["folder_in"] == PM_FOLDERID_MOD && $msg["mod_flag"] == "open") { ?>
      <input type="submit" name="markclosed" value="Als erledigt markieren" class="btn btn-flat btn-primary fc-today-button">
      <? } elseif ($msg["folder_in"] == PM_FOLDERID_MOD && $msg["mod_flag"] == "closed") { ?>
      <input type="submit" name="markopen" value="Als ausstehend markieren" class="btn btn-flat btn-primary fc-today-button">
      <? } ?>
    </td>
  </tr>
    <?php
print("</tr></table><br />\n");
print"                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
    x264_footer();

}

function sendMessageDialog($replymsg = 0)
{
    global $CURUSER;
    
    if ($replymsg) {
        $res = mysql_query("SELECT `messages`.*,`users`.`username` AS `sendername` FROM `messages` LEFT JOIN `users` ON `messages`.`sender`=`users`.`id` WHERE `messages`.`id`=".$replymsg);
        if (@mysql_num_rows($res) == 1) {
            $is_reply = TRUE;
            $msg = mysql_fetch_assoc($res);
            
            if ($msg["sendername"] == "")
                stderr("Fehler", "Der gewünschte Empfänger existiert nicht!");
            
            $action = "beantworten";
            $image = "mail_reply22.png";
            if (substr($msg["subject"], 0, 4) != "Re: ")
                $msg["subject"] = "Re: ".$msg["subject"];
            $body = "\n\n\n[quote=".$msg["sendername"]."]".stripslashes($msg["msg"])."[/quote]";
            $receiver = $msg["sender"];
        } else
            stderr("Fehler", "Die zu beantwortende Nachricht existiert nicht mehr.");
    } else {
        $res = mysql_query("SELECT `id` AS `sender`, `username` AS `sendername` FROM `users` WHERE `id`=".intval($_REQUEST["receiver"]));
        if (@mysql_num_rows($res) == 1) {
            $msg = mysql_fetch_assoc($res);
        } else
            stderr("Fehler", "Der gewünschte Empfänger existiert nicht!");
            
        $is_reply = FALSE;
        $action = "versenden";
        $image = "mail_send22.png";
        $receiver = intval($_REQUEST["receiver"]);
    }
    
    if ($receiver == $CURUSER["id"])
        stderr("Fehler", "Du kannst keine Nachricht an Dich selbst versenden!");
    
    // Prüfen, ob Empfänger die Nachricht erhalten möchte
    $res = mysql_query("SELECT `acceptpms`, `notifs`, UNIX_TIMESTAMP(`last_access`) as `la` FROM `users` WHERE `id`=".$receiver) or sqlerr(__FILE__, __LINE__);
    $user = mysql_fetch_assoc($res);
    
    if (get_user_class() < UC_GUTEAM)
    {
        if ($user["acceptpms"] == "yes") {
            $res2 = mysql_query("SELECT * FROM blocks WHERE userid=$receiver AND blockid=".$CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
            if (mysql_num_rows($res2) == 1)
                stderr("Abgelehnt", "Dieser Benutzer hat PNs von Dir blockiert.");
        } elseif ($user["acceptpms"] == "friends") {
            $res2 = mysql_query("SELECT * FROM friends WHERE userid=$receiver AND friendid=".$CURUSER["id"]) or sqlerr(__FILE__, __LINE__);
            if (mysql_num_rows($res2) != 1)
                stderr("Abgelehnt", "Dieser Benutzer akzeptiert nur PNs von Benutzern auf seiner Freundesliste.");
        } elseif ($user["acceptpms"] == "no")
            stderr("Abgelehnt", "Dieser Benutzer akzeptiert keine PNs.");
    }
    
    if (isset($_POST["send"])) {
        if ($_POST["subject"] == "")
            stderr("Fehler", "Du musst einen Betreff angeben!");
            
        if (strlen($_POST["subject"]) > 250)
            stderr("Fehler", "Der Betreff ist zu lang (maximal 250 Zeichen)!");
            
        if ($_POST["body"] == "")
            stderr("Fehler", "Du musst einen Nachrichtentext angeben!");
            
        if (strlen($_POST["body"]) > 5000)
            stderr("Fehler", "Der Nachrichtentext ist zu lang. Bitte kürze den Text auf unter 5.000 Zeichen!");
            
        if ($_POST["save"] == "yes")
            $folder_out = PM_FOLDERID_OUTBOX;
        else
            $folder_out = 0;
            
        sendPersonalMessage($CURUSER["id"], $receiver, stripslashes($_POST["subject"]), stripslashes($_POST["body"]), PM_FOLDERID_INBOX, $folder_out);
        
        if ($is_reply && $_POST["delorig"] == "yes") {
            // Keine weitere Prüfung nötig, da wir sonst nicht bis hierher kämen!
            deletePersonalMessages($replymsg);
        }
        
        stderr("Nachricht erfolgreich versendet!", 'Die Nachricht wurde erfolgreich versendet.<p><a href="messages.php?folder='.$GLOBALS["FOLDER"].'">Zurück zum zuletzt angezeigten Ordner</a></p>');
    }
    
    
    x264_header("Nachricht $action");
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-envelope-o'></i>PM System - Nachricht ".$action."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";
print("<table class=table table-bordered table-striped table-condensed align=center>\n");
print("<tr>");		
    //begin_frame('<img src="'.$GLOBALS["PIC_BASE_URL"].'pm/'.$image.'" height="22" alt="Image" style="vertical-align: middle;width:22"> Nachricht '.$action, FALSE, "600px;");
?>
<form action="messages.php" method="post">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<input type="hidden" name="action" value="<?=($is_reply?"reply":"send")?>">
<input type="hidden" name="id" value="<?=$msg["id"]?>">
<input type="hidden" name="receiver" value="<?=$msg["sender"]?>">
    <?php
    begin_table(TRUE);
    ?>
  <colgroup>
    <col style="width:50">
    <col>
  </colgroup>
  <tr>
    <td class="table-bordered"><b>Empfänger:</b></td>
    <td class="table-bordered"><a href="userdetails.php?id=<?=$msg["sender"]?>"><?=htmlspecialchars($msg["sendername"])?></a></td>
  </tr>
  <tr>
    <td class="table-bordered"><b>Betreff:</b></td>
    <td class="table-bordered"><input type="text" name="subject" size="78" maxlength="250" class="btn btn-flat btn-primary fc-today-button" value="<?=htmlspecialchars($msg["subject"])?>"></td>
  </tr>
  <tr>
    <td class="table-bordered" valign="top"><b>Nachricht:</b></td>
    <td class="table-bordered"><? textbbcode("message","body","$body","support")?></td>
  </tr>
  <tr>
    <td class="table-bordered"><b>Optionen:</b></td>
    <td class="table-bordered">
      <? if ($is_reply) { ?>
      <input type="checkbox" name="delorig" class="btn btn-flat btn-primary fc-today-button" value="yes" <?=$CURUSER['deletepms'] == 'yes'?"checked":""?>> Nachricht l&ouml;schen, auf die Du antwortest<br>
      <? } ?>
      <input type="checkbox" name="save" class="btn btn-flat btn-primary fc-today-button" value="yes" <?=$CURUSER['savepms'] == 'yes'?"checked":""?>> Nachricht im Postausgang speichern
  </tr>
  <tr>
    <td class="table-bordered" style="text-align:center;" colspan="2">
      <input type="submit" name="send" value="Nachricht senden" class="btn btn-flat btn-primary fc-today-button">
    </td>
  </tr>
    <?php
print("</tr></table><br />\n");
print"                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
    x264_footer();
}

?>