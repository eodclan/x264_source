<?php
// ************************************************************************************//
// * D€ Source 2018
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 2.0
// * 
// * Copyright (c) 2017 - 2018 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************// 
require_once(dirname(__FILE__) . "/include/engine.php");
dbconn(false);
loggedinorreturn();

initFolder();

$GLOBALS["FOLDER"] = intval($_REQUEST["folder"]);
if ($GLOBALS["FOLDER"] == 0) $GLOBALS["FOLDER"] = PM_FOLDERID_INBOX;

if ($CURUSER["class"] < UC_MODERATOR && $GLOBALS["FOLDER"] == PM_FOLDERID_MOD)
    stderr("Fehler", "Du hast keinen Zugriff auf diesen Ordner");

if ($GLOBALS["FOLDER"] > 0)
    $res = mysql_query("SELECT * FROM `pmfolders` WHERE id=".$GLOBALS["FOLDER"]." AND `owner`=".$CURUSER["id"]);
else {
    switch ($GLOBALS["FOLDER"]) {
    case PM_FOLDERID_INBOX:
            $foldername = "__inbox";
            break;
    case PM_FOLDERID_OUTBOX:
            $foldername = "__outbox";
            break;
    case PM_FOLDERID_SYSTEM:
            $foldername = "__system";
            break;
    case PM_FOLDERID_MOD:
            $foldername = "__mod";
            break;
    default:
            $foldername = "__invalid";
            break;
    }
    $res = mysql_query("SELECT * FROM `pmfolders` WHERE name='".$foldername."' AND `owner`=".$CURUSER["id"]);
}

if (mysql_num_rows($res) == 0)
    stderr("Fehler", "Der angegebene Ordner ist ungültig!");

$finfo = mysql_fetch_assoc($res);

if (isset($_GET["sortfield"]) && in_array($_GET["sortfield"], array('added','subject','sendername','receivername'))) {
    if (isset($_GET["sortorder"]) && in_array($_GET["sortorder"], array("ASC", "DESC"))) {
        $finfo["sortfield"] = $_GET["sortfield"];
        $finfo["sortorder"] = $_GET["sortorder"];
        
        mysql_query("UPDATE `pmfolders` SET `sortfield`=".sqlesc($_GET["sortfield"]).",`sortorder`=".sqlesc($_GET["sortorder"])." WHERE `id`=".$finfo["id"]);
    }
}

if ($GLOBALS["PM_PRUNE_DAYS"] > 0 && ($finfo["prunedays"] == 0 || $finfo["prunedays"] > $GLOBALS["PM_PRUNE_DAYS"]))
    $finfo["prunedays"] = $GLOBALS["PM_PRUNE_DAYS"];

// Action-Mapping
if (isset($_REQUEST["reply"]))      $_REQUEST["action"] = "reply";
if (isset($_REQUEST["delete"]))     $_REQUEST["action"] = "delete";
if (isset($_REQUEST["move"]))       $_REQUEST["action"] = "move";
if (isset($_REQUEST["markread"]))   $_REQUEST["action"] = "markread";
if (isset($_REQUEST["markunread"])) $_REQUEST["action"] = "markunread";
if (isset($_REQUEST["markclosed"])) $_REQUEST["action"] = "markclosed";
if (isset($_REQUEST["markopen"]))   $_REQUEST["action"] = "markopen";

if (isset($_REQUEST["action"])) {
    // Aktionen ohne Nachrichten
    switch ($_REQUEST["action"]) {
        case "createfolder":
            createFolderDialog();
            die();
        case "deletefolder":
            deleteFolderDialog();
            die();
        case "config":
            folderConfigDialog();
            die();
        case "send":
            sendMessageDialog();
            die();
    }

    if ((!isset($_REQUEST["id"]) || intval($_REQUEST["id"]) == 0) && !is_array($_REQUEST["selids"]))
        stderr("Fehler", "Keine Nachricht für diese Aktion ausgewählt!");
    
    // selids numerisch machen!
    if (is_array($_REQUEST["selids"])) {
        for ($I=0; $I<count($_REQUEST["selids"]); $I++) {
            $_REQUEST["selids"][$I] = intval($_REQUEST["selids"][$I]);
        }
    }
    
    checkMessageOwner();
    
    if (isset($_REQUEST["id"])) {
        $selids = intval($_REQUEST["id"]);
    } elseif (is_array($_REQUEST["selids"])) {
        $selids = implode(",", $_REQUEST["selids"]);
    }

    switch ($_REQUEST["action"]) {
        case "markopen":
            mysql_query("UPDATE `messages` SET `mod_flag`='open' WHERE `id` IN ($selids)");
            break;
        case "markclosed":
            mysql_query("UPDATE `messages` SET `mod_flag`='closed' WHERE `id` IN ($selids)");
            break;
        case "markread":
            mysql_query("UPDATE `messages` SET `unread`='' WHERE `id` IN ($selids)");
            break;
        case "markunread":
            mysql_query("UPDATE `messages` SET `unread`='yes' WHERE `id` IN ($selids)");
            break;
        case "reply":
            if ((!isset($_REQUEST["id"]) || intval($_REQUEST["id"]) == 0))
                stderr("Fehler", "Die Nachrichten-ID kann nur über den Parameter 'id' übergeben werden - was probierst Du da?!?");
            sendMessageDialog(intval($_REQUEST["id"]));
            die();
        case "read":
            displayMessage(intval($_REQUEST["id"]));
            die();
        case "delete":
            deletePersonalMessages($selids);
            break;
        case "move":
            if ($GLOBALS["FOLDER"] == PM_FOLDERID_SYSTEM || $GLOBALS["FOLDER"] == PM_FOLDERID_MOD)
                stderr("Fehler", "Aus diesem Ordner können keine Nachrichten verschoben werden!");
            
            $target_folder = intval($_REQUEST["to_folder"]);
            if ($target_folder == 0) {
                selectTargetFolderDialog($selids);
                die();
            }
            
            if ($target_folder == PM_FOLDERID_SYSTEM || $target_folder == PM_FOLDERID_MOD)
                stderr("Fehler", "In diesen Ordner können keine Nachrichten verschoben werden!");
                
            if ($target_folder != PM_FOLDERID_INBOX && $target_folder != PM_FOLDERID_OUTBOX)
                checkFolderOwner($target_folder);
                
            mysql_query("UPDATE `messages` SET `folder_in`=".intval($_REQUEST["to_folder"])." WHERE `id` IN ($selids) AND `folder_in`=".$GLOBALS["FOLDER"]." AND `receiver`=".$CURUSER["id"]);
            mysql_query("UPDATE `messages` SET `folder_out`=".intval($_REQUEST["to_folder"])." WHERE `id` IN ($selids) AND `folder_out`=".$GLOBALS["FOLDER"]." AND `sender`=".$CURUSER["id"]);
            break;
    }

}

switch ($GLOBALS["FOLDER"]) {
    case PM_FOLDERID_INBOX:
        $finfo["name"] = "Posteingang";
        break;
    case PM_FOLDERID_OUTBOX:
        $finfo["name"] = "Postausgang";
        break;
    case PM_FOLDERID_SYSTEM:
        $finfo["name"] = "Systemnachrichten";
        break;
    case PM_FOLDERID_MOD:
        $finfo["name"] = "Mod-Benachrichtigungen";
        break;
}

x264_header("Nachrichten");
?>
<script type="text/javascript">

function selectAll()
{
    var I=1;
    var check = document.forms['msgform'].elements['selall'].checked;

    while (eval("document.forms['msgform'].elements['chkbox" + I + "']") != 'undefined') {
        eval("document.forms['msgform'].elements['chkbox" + I + "']").checked = check;
        I++;
    }
}

</script>

<form id="msgform" method="post" action="messages.php">
<input type="hidden" name="folder" value="<?=$GLOBALS["FOLDER"]?>">
<table summary='none' cellspacing="10" cellpadding="0" border="0">
  <colgroup>
    <col width="100%">
    <col width="200">
  </colgroup>
  <tr>
    <td valign="top">
<?php
print"	
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-envelope-o'></i>Nachrichten - ".htmlspecialchars($finfo["name"])."
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	

begin_table(TRUE);
?>
<colgroup>
  <col width="16">
  <col width="55%">
  <col width="15%">
  <col width="15%">
  <col width="15%">
  <col width="48">
</colgroup>
<tr>
  <th class="x264_title_table"><input onclick="selectAll();" type="checkbox" id="selall" name="selall" value="1" class="btn btn-flat btn-primary fc-today-button"></th>
  <th class="x264_title_table" nowrap="nowrap"><? if ($finfo["sortfield"] == "subject") echo ($finfo["sortorder"]=="ASC"?'<img src="'.$GLOBALS["PIC_BASE_URL"].'pm/up.png" style="vertical-align:middle" alt="up">&nbsp;':'<i class="fa fa-sort-down"></i>&nbsp;'); ?><a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;sortfield=subject&amp;sortorder=<? if ($finfo["sortfield"] == "subject") echo ($finfo["sortorder"]=="ASC"?"DESC":"ASC"); else echo $finfo["sortorder"]; ?>">Betreff</a></th>
  <th class="x264_title_table" nowrap="nowrap"><? if ($finfo["sortfield"] == "sendername") echo ($finfo["sortorder"]=="ASC"?'<img src="'.$GLOBALS["PIC_BASE_URL"].'pm/up.png" style="vertical-align:middle" alt="up">&nbsp;':'<i class="fa fa-sort-down"></i>&nbsp;'); ?><a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;sortfield=sendername&amp;sortorder=<? if ($finfo["sortfield"] == "sendername") echo ($finfo["sortorder"]=="ASC"?"DESC":"ASC"); else echo $finfo["sortorder"]; ?>">Absender</a></th>
  <th class="x264_title_table" nowrap="nowrap"><? if ($finfo["sortfield"] == "receivername") echo ($finfo["sortorder"]=="ASC"?'<img src="'.$GLOBALS["PIC_BASE_URL"].'pm/up.png" style="vertical-align:middle" alt="up">&nbsp;':'<i class="fa fa-sort-down"></i>&nbsp;'); ?><a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;sortfield=receivername&amp;sortorder=<? if ($finfo["sortfield"] == "receivername") echo ($finfo["sortorder"]=="ASC"?"DESC":"ASC"); else echo $finfo["sortorder"]; ?>">Empfänger</a></th>
  <th class="x264_title_table" nowrap="nowrap"><? if ($finfo["sortfield"] == "added") echo ($finfo["sortorder"]=="ASC"?'<img src="'.$GLOBALS["PIC_BASE_URL"].'pm/up.png" style="vertical-align:middle" alt="up">&nbsp;':'<i class="fa fa-sort-down"></i>&nbsp;'); ?><a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;sortfield=added&amp;sortorder=<? if ($finfo["sortfield"] == "added") echo ($finfo["sortorder"]=="ASC"?"DESC":"ASC"); else echo $finfo["sortorder"]; ?>">Datum</a></th>
  <th class="x264_title_table">&nbsp;</th>
</tr>
<?php

if ($GLOBALS["FOLDER"] == PM_FOLDERID_MOD) {
    // Nachrichten älter als 7 Tage löschen
    mysql_query("DELETE FROM `messages` WHERE `folder_in`=".PM_FOLDERID_MOD." AND `sender`=0 AND `receiver`=0 AND UNIX_TIMESTAMP(`added`)<".(time()-7*86400));
    if ($_REQUEST["closed"]==1)
        $msgres = mysql_query("SELECT `messages`.`id`,`messages`.`folder_in`,`messages`.`folder_out`,`messages`.`mod_flag`,'0' AS `sender`,'0' AS`receiver`,`messages`.`unread`,`messages`.`subject`,`messages`.`added`,'System' AS `sendername`,'Tracker-Team' AS `receivername`  FROM `messages` WHERE `folder_in`=".PM_FOLDERID_MOD." AND `receiver`=0 AND `mod_flag`='closed' ORDER BY ".$finfo["sortfield"]." ".$finfo["sortorder"]);
    else
        $msgres = mysql_query("SELECT `messages`.`id`,`messages`.`folder_in`,`messages`.`folder_out`,`messages`.`mod_flag`,'0' AS `sender`,'0' AS`receiver`,`messages`.`unread`,`messages`.`subject`,`messages`.`added`,'System' AS `sendername`,'Tracker-Team' AS `receivername`  FROM `messages` WHERE `folder_in`=".PM_FOLDERID_MOD." AND `receiver`=0 AND `mod_flag`='open' ORDER BY ".$finfo["sortfield"]." ".$finfo["sortorder"]);        
} else {
    // Nachrichten löschen, falls Pruning gewünscht
    if ($finfo["prunedays"] > 0) {
        $prunetime = time()-$finfo["prunedays"]*86400;
        mysql_query("DELETE FROM `messages` WHERE `folder_out`=0 AND `folder_in`=".$GLOBALS["FOLDER"]." AND `receiver`=".$CURUSER["id"]." AND UNIX_TIMESTAMP(`added`)<".$prunetime);
        mysql_query("DELETE FROM `messages` WHERE `folder_in`=0 AND `folder_out`=".$GLOBALS["FOLDER"]." AND `sender`=".$CURUSER["id"]." AND UNIX_TIMESTAMP(`added`)<".$prunetime);
        mysql_query("UPDATE `messages` SET `folder_in`=0 WHERE `folder_in`=".$GLOBALS["FOLDER"]." AND `receiver`=".$CURUSER["id"]." AND UNIX_TIMESTAMP(`added`)<".$prunetime);
        mysql_query("UPDATE `messages` SET `folder_out`=0 WHERE `folder_out`=".$GLOBALS["FOLDER"]." AND `sender`=".$CURUSER["id"]." AND UNIX_TIMESTAMP(`added`)<".$prunetime);
    }
    $msgres = mysql_query("SELECT `messages`.`id`,`messages`.`folder_in`,`messages`.`folder_out`,`messages`.`sender`,`messages`.`receiver`,`messages`.`unread`,`messages`.`subject`,`messages`.`added`,`sender`.`username` AS `sendername`,`receiver`.`username` AS `receivername`  FROM `messages` LEFT JOIN `users` AS `sender` ON `sender`.`id`=`messages`.`sender` LEFT JOIN `users` AS `receiver` ON `receiver`.`id`=`messages`.`receiver` WHERE (`folder_in`=".$GLOBALS["FOLDER"]." AND `receiver`=".$CURUSER["id"].") OR (`folder_out`=".$GLOBALS["FOLDER"]." AND `sender`=".$CURUSER["id"].") ORDER BY ".$finfo["sortfield"]." ".$finfo["sortorder"]);
}

if (mysql_num_rows($msgres) == 0) {
    echo '<tr><td class="x264_title_table" colspan="6">Dieser Ordner enthält keine Nachrichten.</td></tr>'."\n";
} else {
    $msgnr = 1;
    while ($msg = mysql_fetch_assoc($msgres)) {
        messageLine($msg, $msgnr);
        $msgnr++;
    }

?>
<tr>
  <td class="x264_title_table" colspan="6">
    <table summary='none' cellspacing="2" cellpadding="2" border="0">
      <tr>
        <td class='x264_im_logo'>Ausgewählte Nachrichten:</td>
<?php if ($GLOBALS["FOLDER"] != PM_FOLDERID_MOD) { ?>
        <td>
          <input type="submit" name="delete" value="Löschen" class="btn btn-flat btn-primary fc-today-button">
          <input type="submit" name="markread" value="Als gelesen markieren" class="btn btn-flat btn-primary fc-today-button">
          <input type="submit" name="markunread" value="Als ungelesen markieren" class="btn btn-flat btn-primary fc-today-button"></td>
      </tr>
<?php if ($GLOBALS["FOLDER"] != PM_FOLDERID_SYSTEM) { ?>
      <tr>
        <td class='x264_im_logo'>...verschieben nach:</td>
        <td>
          <select name="to_folder" size="1">
            <option>** Bitte Ordner auswählen **</option>
            <option value="<?=PM_FOLDERID_INBOX?>">Posteingang</option>
            <option value="<?=PM_FOLDERID_OUTBOX?>">Postausgang</option>
<?php
        getFolders(0, 0, TRUE);
?>
          </select>
          <input type="submit" name="move" value="Verschieben" class="btn btn-flat btn-primary fc-today-button">
        </td>
<?php
        }
    } else {
?>
        <td><input type="submit" name="markclosed" value="Als erledigt markieren" class="btn btn-flat btn-primary fc-today-button"></td>
        <td><input type="submit" name="markopen" value="Als ausstehend markieren" class="btn btn-flat btn-primary fc-today-button"></td>
        <?php
    }
?>
        </tr>
    </table>
  </td>
</tr>
<?php
}
end_table();
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
?>
    </td>
    <td valign="top">
<?php
echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-envelope-o'></i> Ordner
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";

begin_table(TRUE);
// Hauptordner
folderLine(PM_FOLDERID_INBOX, "Posteingang", "fa fa-inbox");
folderLine(PM_FOLDERID_OUTBOX, "Postausgang", "fa fa-envelope-o");
folderLine(PM_FOLDERID_SYSTEM, "Systemnachrichten", "fa fa-file-text-o");
    
if ($CURUSER["class"] >= UC_MODERATOR) {
    folderLine(PM_FOLDERID_MOD, "Mod-Benachrichtigungen", "fa fa-circle-o text-red");
    folderLine(PM_FOLDERID_MOD, "Erledigt", "fa fa-circle-o text-yellow", 1);
}

getFolders();
end_table();
?>
        <i class="fa fa-folder"></i>&nbsp;<a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=createfolder">Ordner erstellen</a><br>
        <i class="fa fa-folder-open"></i>&nbsp;<a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=config">Ordner konfigurieren</a><br>
        <? if ($GLOBALS["FOLDER"] > 0) { ?>
        <i class="fa fa-trash-o"></i>&nbsp;<a href="messages.php?folder=<?=$GLOBALS["FOLDER"]?>&amp;action=deletefolder">Ordner löschen</a><br>
        <? } ?>
        <br>
        <?php
?>
    </td>
  </tr>
</table>
</form>
</div>
<?php
x264_footer();
?>