<?
require "include/bittorrent.php";


dbconn(false);

loggedinorreturn();

check_access(UC_SYSOP);
security_tactics();

if (get_user_class() >= UC_SYSOP)
{ 


$action = $_POST["action"];

if ($action == "yes") 
mysql_query("UPDATE torrents SET free='yes', wonly='yes'  WHERE free='no'") or sqlerr(__FILE__, __LINE__);


if ($action == "no")
mysql_query("UPDATE torrents SET free='no', wonly='no' WHERE wonly='yes'") or sqlerr(__FILE__, __LINE__);

 

    header("Location: " . $GLOBALS["BASEURL"]);
    die;
}
else
print("<p style=\"text-align:center;font-size:12pt;\"><b>Dir ist es nicht erlaubt, hier zuzugreifen</b></p>");
?>