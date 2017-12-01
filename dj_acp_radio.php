<?php
require_once(dirname(__FILE__)."/include/bittorrent.php");
require_once(dirname(__FILE__) . "/include/Classes/Shoutcast.php");
dbconn();
loggedinorreturn();
check_access(UC_DJ);
security_tactics();

x264_bootstrap_header("Radio Server Interface");

function ConvertSeconds($seconds) { 
    $tmpseconds = substr("00".$seconds % 60, -2); 
    if ($seconds > 59) { 
        if ($seconds > 3599) { 
            $tmphours = substr("0".intval($seconds / 3600), -2); 
            $tmpminutes = substr("0".intval($seconds / 60 - (60 * $tmphours)), -2); 
            
            return ($tmphours.":".$tmpminutes.":".$tmpseconds); 
        } else { 
            return ("00:".substr("0".intval($seconds / 60), -2).":".$tmpseconds); 
        } 
    } else { 
        return ("00:00:".$tmpseconds); 
    } 
} 

$shoutcast = new ShoutCast();
$shoutcast->host = $GLOBALS["RADIO_IP"];
$shoutcast->port = $GLOBALS["RADIO_PORT"];
$shoutcast->passwd = $GLOBALS["RADIO_PASSWORD"];

echo"
                       <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Radio Server Zugangsdaten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
		<table border='0' cellpadding='0' cellspacing='0'>
			<tr><td>Radio IP:</td><td>".$GLOBALS["RADIO_IP"]."</td></tr>
			<tr><td>Radio Port:</td><td>".$GLOBALS["RADIO_PORT"]."</td></tr>
			<tr><td>Radio Passwort:</td><td>".$GLOBALS["RADIO_PASSWORD"]."</td></tr>";
if (get_user_class() >= UC_MODERATOR) {
echo"		
			<tr><td>Admin Panel:</td><td><a href=http://".$GLOBALS["RADIO_IP"].":".$GLOBALS["RADIO_PORT"]."/admin.cgi> In das Radio Admin Panel</a></td></tr>
			<tr><td>Admin Passwort:</td><td> ".$GLOBALS["RADIO_ADMIN_PASSWORD"]."</td></tr>";
}
echo"
		</table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";


echo"
                       <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> Radio Server Interface
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";

if ($shoutcast->openstats()) { 
    // We got the XML, gogogo!.. 
    if ($shoutcast->GetStreamStatus()) { 
echo"
		<table border='0' cellpadding='0' cellspacing='0'>
			<tr><td>".$shoutcast->GetServerTitle()."</b> (".$shoutcast->GetCurrentListenersCount()." of ".$shoutcast->GetMaxListenersCount()." listeners, peak: ".$shoutcast->GetPeakListenersCount().")</td></tr>
			<tr><td><b>Server URL: </b></td><td><a href=\"".$shoutcast->GetServerURL()."\">".$shoutcast->GetServerURL()."</a></td></tr>
			<tr><td><b>Server Titel: </b></td><td>".$shoutcast->GetServerTitle()."</td></tr><tr><td colspan=2>&nbsp;</td></tr>
			<tr><td><b>Current Song: </b></td><td>".$shoutcast->GetCurrentSongTitle()."</td></tr>
			<tr><td><b>Durchschnittliche Zuh&ouml;rer Zeit: </b></td><td>".ConvertSeconds($shoutcast->GetAverageListenTime())."</td></tr><tr><td colspan=2>&nbsp;</td></tr>			
			<tr><td><b>IRC: </b></td><td>".$shoutcast->GetIRC()."</td></tr>
			<tr><td><b>AIM: </b></td><td>".$shoutcast->GetAIM()."</td></tr>
			<tr><td><b>ICQ: </b></td><td>".$shoutcast->GetICQ()."</td></tr><tr><td colspan=2>&nbsp;</td></tr>
			<tr><td><b>Web Zugriffsz&auml;hler: </b></td><td>".$shoutcast->GetWebHitsCount()."</td></tr>
			<tr><td><b>Stream-Hits Zugriffsz&auml;hler: </b></td><td>".$shoutcast->GetStreamHitsCount()."</td></tr>
		</table>";
		
		
echo"
		<table border='0' cellpadding='0' cellspacing='0'>
			<tr><td colspan=2>&nbsp;</td></tr>
			<tr><td><b>Song history: </b></td>
				<td>";
        $history = $shoutcast->GetSongHistory(); 
        if (is_array($history)) { 
            for ($i=0;$i<sizeof($history);$i++) { 
                echo "[".$history[$i]["playedat"]."] - ".$history[$i]["title"]."<br />"; 
            } 
        } else { 
            echo "No song history available.."; 
        }
echo"
				</td></tr><tr><td colspan=2>&nbsp;</td></tr>
			<tr><td><b>Zuh&ouml;rer: </b></td>
				<td>"; 
        $listeners = $shoutcast->GetListeners(); 
        if (is_array($listeners)) { 
            for ($i=0;$i<sizeof($listeners);$i++) { 
                echo "[".$listeners[$i]["uid"]."] - ".$listeners[$i]["hostname"]." using ".$listeners[$i]["useragent"].", connected for ".ConvertSeconds($listeners[$i]["connecttime"])."<br>\n"; 
            } 
        } else { 
            echo "Momentan gibt es keine Zuh&ouml;rer!"; 
        }
echo"
				</td></tr>"; 		
    } else {
echo"		
			<tr><td><b>Stream Status: </b></td>
				<td>";		
        echo "Momentan ist kein DJ Online."; 
    } 
} else { 
    // Ohhh, damnit.. 
    echo $shoutcast->geterror();
echo"
				</td></tr>";	
}
echo"
		</table>"; 		
		
echo"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
	  
x264_bootstrap_footer();
?>