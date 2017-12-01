<?
require "include/bittorrent.php";
dbconn(false);
loggedinorreturn();

x264_header("Team PM", false);
?>
<form action="takecontact.php" method="post" name="message" enctype="multipart/form-data">
<? if ($_GET["returnto"] || $_SERVER["HTTP_REFERER"]) { ?>
<input type=hidden name=returnto value=<?=$_GET["returnto"] ? $_GET["returnto"] : $_SERVER["HTTP_REFERER"]?>>
<? } ?>

		<div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-edit'></i>Team PM an das <?=$GLOBALS["SITENAME"]?> Team schicken
                    <div class='card-actions'>
                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                    </div>
                </div>
                <div class='card-block'>
                    <form class='form-horizontal'>
                        <div class='form-group'>
                            <label class='form-control-label' for='prependedInput'>Betreff</label>
                            <div class='controls'>
                                <div class='input-prepend input-group'>
                                    <input type="text" name="subject" class="btn btn-primary fc-today-button" size="80" maxlength="30" value="<?=$replyto?" colspan=2":""?>">
                                </div>
                                <p class='help-block'>Bitte einen aussagekr&auml;ftigen Betreff.</p>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label class='form-control-label' for='appendedInput'>Nachricht</label>
                            <div class='controls'>
                                <div class='input-group'>
                                    <? textbbcode("message","msg","$body","support")?>
                                </div>
                            </div>
                        </div>
                        <div class='form-actions'>
                            <input type="submit" name="send" value="Nachricht senden" class='btn btn-primary fc-today-button'>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php
x264_footer();
?>