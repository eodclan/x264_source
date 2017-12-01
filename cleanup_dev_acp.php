<?php
if (empty($_SERVER["HTTP_HOST"])) 
	require_once(dirname(__FILE__)."/include/bittorrent.php");
	require_once(dirname(__FILE__) . "/include/Classes/Cleanup.php");

if (!empty($_SERVER["HTTP_HOST"])) 
{
  dbconn();
  loggedinorreturn();
    
  if (get_user_class() < UC_DEV)
    stderr("Fehler", "Zugriff verweigert.");
}


ini_set ('display_errors', 'On');

  error_reporting (E_ALL);
  // Oder so
  error_reporting(E_ALL & ~ E_NOTICE);

docleanup();

write_log("cleanup","Cleanup erfolgreich ausgefuehrt".(!empty($_SERVER["HTTP_HOST"])?" (Manuell ausgefuehrt durch ".$CURUSER['username'].")":""));

x264_bootstrap_header('Cleanup ACP');

check_access(UC_DEV);
security_tactics();
echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Cleanup ACP
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                                    <a href='javascript:void(0)' class='uppercase'>Cleanup erfolgreich abgeschlossen.</a>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

x264_bootstrap_footer();
?>
