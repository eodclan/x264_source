<?php
require "include/bittorrent.php";

function mkbytes($amount, $unit)
{
    switch($unit)
    {
        case "GB":
            return 1024 * 1024 * 1024 * $amount;
            break;
        case "MB":
            return 1024 * 1024 * $amount;
            break;
        default:
            return $amount;
    }
}

dbconn();
loggedinorreturn();

check_access(UC_SYSOP);
security_tactics();

if ($_POST['message'] != "" && $_POST["subject"] != "")
{
    // get the checkbox group
    $class= $_POST["class"];

    // check for empty choice
    if (!isset($class)) stderr("Fehler!", "Bitte mindestens einen Benutzerrang als Empfänger auswählen!");

    // check for empty or negative amount
    if ($_POST["amount"] <= 0) stderr("Fehler!", "Der Betrag muss positiv und größer als 0 sein!");

    $num=0;
    foreach($class as $x)
    {
        if (substr($x,0,3) == "UC_")
        {
            if ($num < count($class) - 1) $querystring .= " class = " . constant($x) . " OR";
            else $querystring .= " class = " . constant($x);
            $classnames .= get_user_class_name(constant($x)).", ";
            $num++;
        }
    }

    if ($num == intval($_POST["numclasses"]))
    {
        // update upload
        $res = mysql_query("UPDATE `users` SET `uploaded` = `uploaded` + ". mkbytes($_POST["amount"], $_POST["unit"])) or sqlerr(__FILE__, __LINE__);
        // select users for pm
        $res = mysql_query("SELECT id FROM users");
        // message text
        $msg = $_POST['message']  . "\n\nNOTIZ: Dies ist eine Upload Gutschrift über ".$_POST["amount"]." ".$_POST["unit"]." für alle Benutzer";
    }
    else
    {
        // update upload
        $res = mysql_query("UPDATE `users` SET `uploaded` = `uploaded` + ". mkbytes($_POST["amount"], $_POST["unit"])." where".$querystring) or sqlerr(__FILE__, __LINE__);
        // select users for pm
        $res = mysql_query("SELECT id FROM users where".$querystring) or sqlerr(__FILE__, __LINE__);
        // message text
        $msg = $_POST['message']  . "\n\nNOTIZ: Dies ist eine Upload Gutschrift über ".$_POST["amount"]." ".$_POST["unit"]." für folgende Benutzerränge: " . substr($classnames,0,(strlen($classnames)-2));
    }

    $subject = $_POST['subject'];

    if ($_POST["fromsystem"] == "yes") $sender_id="0";
    else $sender_id = $CURUSER["id"];

    while($arr = mysql_fetch_row($res))
    {
        sendPersonalMessage($sender_id, $arr[0], $subject, $msg, PM_FOLDERID_INBOX, 0);
    }

    stderr("Erfolg!", "Massen Upload Gutschrift wurde erfolgreich gutgeschrieben an folgende Benutzerränge:<br>" . substr($classnames,0,(strlen($classnames)-2)) . "<br><a href=\"massgift.php\">Zurück</a>");
}else if ($HTTP_SERVER_VARS["REQUEST_METHOD"] == "POST") stderr("Fehler!", "Bitte die Felder Betreff und Nachricht ausfüllen!");

x264_bootstrap_header("Massen Upload Gutschrift");

?>
<form method=post action="massgift.php" name="massgift">
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Upload Gutschrift - Rang auswählen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
			<tr>
				<td>Upload Gutschrift an ausgew&auml;hlte R&auml;nge</td>
			</tr>
			<tr>
				<td>
                        <?
                            // determine user classes
                            $numclasses=0;
                            $constants = get_defined_constants();
                            foreach(array_keys($constants) as $x)
                            {
                                if (substr($x,0,3) == "UC_")
                                {
                                    echo "<div class='x264_title_sitelog_tab'><div class='x264_tfile_add_inc'><input name=\"class[]\" value=\"".$x."\" type=\"checkbox\">".get_user_class_name($constants[$x])."</div></div>\n";
                                    $numclasses++;
                                }
                            }
                        ?>		
				</td>
                </tr>
		</table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
					
<input type="hidden" name="numclasses" value="<? echo $numclasses; ?>" />
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Upload Gutschrift - Nachricht
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
			<tr>
				<td>Upload Gutschrift Menge</td>
			</tr>
			<tr>
				<td>Betreff: <input type=text size=71 name="subject" /></td>
			</tr>
			<tr>
				<td>Upload Menge: <input type=text size=10 name="amount" /> <select name="unit"><option>MB</option><option>GB</option></select></td>
			</tr>
			<tr>
				<td>Nachricht: <textarea cols=71 rows=10 name="message"></textarea></td>
			</tr>
			<tr>
				<td>Als System: <input type="checkbox" name="fromsystem" value="yes" />Den Versender als System angeben statt des Namen</td>
			</tr>
			<tr>
				<td><input type="submit" value="Abschicken" class="btn" /></td>
                </tr>
		</table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>	
</form>
<?
x264_bootstrap_footer();
?>