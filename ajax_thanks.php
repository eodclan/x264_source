<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");
dbconn();
loggedinorreturn();

header('Content-Type: text/html; charset=iso-8859-1');

$userid    = intval($CURUSER["id"]);
$torrentid = intval($_POST["torrentid"]);
$ajax      = (($_POST["ajax"]== "yes") ? "yes" : "no");

if (($ajax == "yes") && ($torrentid != 0) && ($userid != 0))
{
  mysql_query("INSERT INTO thanks (torrentid, userid) VALUES (" . $torrentid . ", " . $userid . ")") or sqlerr(__FILE__,__LINE__);
  $count_sql = mysql_query("SELECT COUNT(*) FROM thanks WHERE torrentid = " . $torrentid) or sqlerr(__FILE__,__LINE__);

  if (mysql_num_rows($count_sql) == 0)
    $thanksby = "Es hat sich noch keiner Bedankt";
  else
  {
    $thanked_sql = mysql_query("SELECT thanks.userid, users.username, users.class FROM thanks INNER JOIN users ON thanks.userid = users.id WHERE thanks.torrentid = " . $torrentid);
    while ($thanked_row = mysql_fetch_assoc($thanked_sql))
    {
      $userid   = $thanked_row["userid"];
      $username = $thanked_row["username"];
      $thanksby .= "<a href=\"" . $BASEURL . "/userdetails.php?id=" . $userid . "\"><font class=\"" . get_class_color($thanked_row["class"]) . "\">" . $username . "</font></a>, ";
    }
    if ($thanksby)
      $thanksby = substr($thanksby, 0, -2);
  }
  $thanksby = "<div id=\"ajax\">" . $thanksby . "</div>";

  print $thanksby;
  die;
}

?>