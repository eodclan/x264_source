<? 
require_once("include/bittorrent.php"); 

dbconn(); 

//---------------------------------nur ab mods aufwärts--------------------
if ($_SERVER["HTTP_HOST"] != "") {
    loggedinorreturn();
    
check_access(UC_MODERATOR);
security_tactics();
}
//---------------------------------nur ab mods aufwärts--------------------

loggedinorreturn();

$id = 0 + $_GET["id"];
$res=mysql_query("SELECT * FROM peers WHERE userid = $id");
while($r=mysql_fetch_assoc($res))
{
  if($r["seeder"]=="yes") 
    mysql_query("UPDATE torrents SET seeders = seeders - 1 WHERE id = $r[torrent]");
  else
    mysql_query("UPDATE torrents SET leechers = leechers - 1 WHERE id = $r[torrent]");
}
mysql_query("DELETE FROM peers WHERE userid = $id");

header("Refresh: 0; url=userdetails.php?id=$id");
?>