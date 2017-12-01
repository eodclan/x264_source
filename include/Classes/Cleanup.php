<?php
require_once(dirname(__FILE__) . "../../bittorrent.php");

function cler($cause)
{
write_log("cleanup","<font color=red>Der Cleanup ist fehlgeschlagen: ".$cause."</font>");
die();
}

function docleanup()
{
$clean = mysql_fetch_assoc(mysql_query("SELECT switch FROM cleanup"));
if (!$clean['switch'])
{
write_log("cleanup","<font color='red'>Der Cleanup wurde nicht durchgeführt da er deaktiviert ist</font>");
x264_header("Cleanup ACP");
echo"
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Cleanup ACP</h1>
	<div class='x264_title_content'>
		<div class='x264_title_div'>Cleanup abgebrochen, da vom Coder deaktiviert.</div>
	</div>
</div>
</div>";
x264_footer();
die();
}
$nclean =sqlesc(get_date_time(gmtime() + $GLOBALS[AUTOCLEAN_INTERVAL]));
write_log("cleanup", "Cleanup erfolgreich abgeschlossen -- nächste Cleanup @ $nclean");
mysql_query("UPDATE cleanup SET nclean = $nclean WHERE id = '0'") or sqlerr(__FILE__, __LINE__);


    $trackerconfig = $GLOBALS["CLEANUP_SYSTEM"];
    if ($trackerdienste[0] == "0")
        return;

  set_time_limit(0);
  ignore_user_abort(1);

  while (1)
  {
    // Collect all torrent ids from database
    $res = mysql_query("SELECT id FROM torrents");
    $all_torrents = array();
    while ($row = mysql_fetch_array($res))
    {
      $id = $row[0];
      $all_torrents[$id] = 1;
    }

    // Open torrent directory for scanning
    $dp = @opendir($GLOBALS["TORRENT_DIR"]);
    if (!$dp)
      break;

    // Collect all .torrent files matching "id.torrent" filename pattern
    $all_files = array();
    while (($file = readdir($dp)) !== false)
    {
      if (!preg_match('/^(\d+)\.torrent$/', $file, $m))
        continue;
      $id = $m[1];
      $all_files[$id] = 1;

      // If no database entry exists, delete the orphaned file
      if (!isset($all_torrents[$id]) || $all_torrents[$id] == 0)
        unlink($GLOBALS["TORRENT_DIR"] . "/$file");
    }
    closedir($dp);

    // Open bitbucket directory for scanning
    $dp = @opendir($GLOBALS["BITBUCKET_DIR"]);
    if (!$dp)
      break;

    // Collect all NFO files matching "nfo-id.png" filename pattern
    while (($file = readdir($dp)) !== false)
    {
      if (!preg_match('/^nfo-(\d+)\.png$/', $file, $m))
        continue;
      $id = $m[1];

      // If no database entry exists, delete the orphaned file
      if (!isset($all_torrents[$id]) || $all_torrents[$id] == 0)
        unlink($GLOBALS["BITBUCKET_DIR"] . "/$file");
    }
    closedir($dp);

    // No torrents or files to consider
    if (!count($all_torrents) && !count($all_files))
      break;

    // Enumerate and delete torrents which have no according .torrent file
    $delids = array();
    foreach (array_keys($all_torrents) as $k)
    {
      if (isset($all_files[$k]) && $all_files[$k])
        continue;
      $delids[] = $k;
      unset($all_torrents[$k]);
    }
    if (count($delids))
      mysql_query("DELETE FROM torrents WHERE id IN (" . join(",", $delids) . ")");

    // Enumerate and delete peers which have no according torrent in the DB
    $res = mysql_query("SELECT torrent FROM peers GROUP BY torrent");
    $delids = array();
    while ($row = mysql_fetch_array($res))
    {
      $id = $row[0];
      if (isset($all_torrents[$id]) && $all_torrents[$id])
        continue;
      $delids[] = $id;
    }
    if (count($delids))
      mysql_query("DELETE FROM peers WHERE torrent IN (" . join(",", $delids) . ")");

    // Enumerate and delete file entries which have no according torrent in the DB
    $res = mysql_query("SELECT torrent FROM files GROUP BY torrent");
    $delids = array();
    while ($row = mysql_fetch_array($res))
    {
      $id = $row[0];
      if ($all_torrents[$id])
        continue;
      $delids[] = $id;
    }
    if (count($delids))
      mysql_query("DELETE FROM files WHERE torrent IN (" . join(",", $delids) . ")");

    // Enumerate and delete wait time overrides which have no according torrent in the DB
    $res = mysql_query("SELECT torrent_id FROM nowait GROUP BY torrent_id");
    $delids = array();
    while ($row = mysql_fetch_array($res))
    {
      $id = $row[0];
      if ($all_torrents[$id])
        continue;
      $delids[] = $id;
    }
    if (count($delids))
      mysql_query("DELETE FROM nowait WHERE torrent_id IN (" . join(",", $delids) . ")");

    break;
  }

  // Delete inactive peers
  $deadtime = deadtime();
  mysql_query("DELETE FROM peers WHERE last_action < FROM_UNIXTIME($deadtime)");

  // Mark inactive torrents dead
  $deadtime -= $GLOBALS["MAX_DEAD_TORRENT_TIME"] * 86400;
  mysql_query("UPDATE torrents SET visible='no' WHERE visible='yes' AND last_action < FROM_UNIXTIME($deadtime)");

  // Delete newly registered user accounts which were not activated
  $deadtime = time() - $GLOBALS["SIGNUP_TIMEOUT"] * 3600;
  mysql_query("DELETE FROM users WHERE status = 'pending' AND added < FROM_UNIXTIME($deadtime) AND last_login < FROM_UNIXTIME($deadtime) AND last_access < FROM_UNIXTIME($deadtime)");

  // Update torrent stats (leechers, seeders, comments)
  $torrents = array();
  $res = mysql_query("SELECT torrent, seeder, COUNT(*) AS c FROM peers GROUP BY torrent, seeder");
  while ($row = mysql_fetch_assoc($res))
  {
    if ($row["seeder"] == "yes")
      $key = "seeders";
    else
      $key = "leechers";
    $torrents[$row["torrent"]][$key] = $row["c"];
  }

  $res = mysql_query("SELECT torrent, COUNT(*) AS c FROM comments GROUP BY torrent");
  while ($row = mysql_fetch_assoc($res))
  {
    $torrents[$row["torrent"]]["comments"] = $row["c"];
  }

  $fields = explode(":", "comments:leechers:seeders");
  $res = mysql_query("SELECT id, seeders, leechers, comments FROM torrents");
  while ($row = mysql_fetch_assoc($res))
  {
    $id = $row["id"];
    $torr = $torrents[$id];
    foreach ($fields as $field)
    {
      if (!isset($torr[$field]))
        $torr[$field] = 0;
    }
    $update = array();
    foreach ($fields as $field)
    {
      if ($torr[$field] != $row[$field])
        $update[] = "$field = " . $torr[$field];
    }
    if (count($update))
      mysql_query("UPDATE torrents SET " . implode(",", $update) . " WHERE id = $id");
  }
 
  // lock topics where last post was made more than x days ago
  if ($GLOBALS["THREAD_LOCK_TIMEOUT"])
  {
    $secs = $GLOBALS["THREAD_LOCK_TIMEOUT"] * 86400;
    $res = mysql_query("SELECT topics.id FROM topics JOIN posts ON topics.lastpost = posts.id AND topics.sticky = 'no' WHERE " . time() . " - UNIX_TIMESTAMP(posts.added) > $secs") or sqlerr(__FILE__, __LINE__);
    while ($arr = mysql_fetch_assoc($res))
      mysql_query("UPDATE topics SET locked='yes' WHERE id=$arr[id]") or sqlerr(__FILE__, __LINE__);
  }

  // remove expired warnings
  $res = mysql_query("SELECT id,username FROM users WHERE warned='yes' AND warneduntil < NOW() AND warneduntil <> '0000-00-00 00:00:00'") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($res) > 0)
  {
    $dt = sqlesc(get_date_time());
    $msg = "Deine Verwarnung wurde automatisch entfernt, und die Moderatoren darüber informiert, um evtl. gestellte Bedingungen erneut zu prüfen.\n";
    while ($arr = mysql_fetch_assoc($res))
    {
      $mod_msg = "[b]Eine Verwarnung ist abgelaufen![/b]\n\nBenutzer [url=userdetails.php?id=$arr[id]]" . $arr["username"] . "[/url] (".$GLOBALS["DEFAULTBASEURL"]."/userdetails.php?id=$arr[id])\n\nBitte die Verwarnungsbedingungen erneut prüfen und entsprechend reagieren.";
      mysql_query("UPDATE users SET warned = 'no', warneduntil = '0000-00-00 00:00:00' WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
      sendPersonalMessage(0, $arr["id"], "Deine Verwarnung ist abgelaufen", $msg, PM_FOLDERID_SYSTEM, 0);
      sendPersonalMessage(0, 0, "Die Verwarnung für '$arr[username]' ist abgelaufen", $mod_msg, PM_FOLDERID_MOD, 0, "open");
      write_log("remwarn", "Die Verwarnung für Benutzer '<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' ist abgelaufen und wurde vom System zurückgenommen.");
      write_modcomment($arr["id"], 0, "Verwarnung abgelaufen.");
    }
  }
  //Verwarnen bei schlechter Ratio by S4NE für die Netvision Source thx to fedepeco for the code

  //Ratio niedriger als $GLOBALS["AUTO_WARN_MIN_RATIO"]
  $minratio = $GLOBALS["AUTO_WARN_MIN_RATIO"];

  //Download mehr als $GLOBALS["AUTO_WARN_DOWN"] Gigabytes
  $downloaded = $GLOBALS["AUTO_WARN_DOWN"]*1024*1024*1024;

  //verwarnungslänge $GLOBALS["AUTO_WARN_LÄNGE"] Wochen
  $length = $GLOBALS["AUTO_WARN_LÄNGE"]*7;

  // Wir nutzen die NetVision Source und bei uns ist die KLasse User zur Zeit mit der Id 0 versehen wenn es bei euch anders sein sollte dann Tragt statt 0 eure id ein :)

  $res = mysql_query("SELECT id, username FROM users WHERE class = 0 AND enabled = 'yes' AND downloaded >= $downloaded AND warned = 'no' AND uploaded / downloaded < $minratio") or sqlerr(__FILE__, __LINE__);

  if (mysql_num_rows($res) > 0)
  {
    $dt = sqlesc(get_date_time());
    $msg = sqlesc("Du wurdest für " . $GLOBALS["AUTO_WARN_LÄNGE"] . " Wochen verwarnt wegen einer zu niedrigen Ratio.Deine Ratio muss mindestens " . $GLOBALS["AUTO_REM_MIN_RATIO"] . " betragen damit die Verwarnung wieder zurück genommen wird. Bitte lies die FAQ.");

    $until = sqlesc(get_date_time(gmtime() + (($length+1)*86400)));

    while ($arr = mysql_fetch_assoc($res))
    {
      mysql_query("UPDATE users SET permban = 'yes', systemwarn = 'yes', warned = 'yes', warneduntil = ".$until.", timeswarned = timeswarned +1, lastwarned = ".$dt.", warnedby = 'System' WHERE id=$arr[id]") or sqlerr(__FILE__, __LINE__);
      sendPersonalMessage(0, $arr["id"], "Verwarnt vom System - Grund schlechte Ratio", $msg, PM_FOLDERID_SYSTEM, 0);
      write_log("autowarn", "Der Benutzer '<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' wurde automatisch für " . $GLOBALS["AUTO_WARN_LÄNGE"] . " Wochen vom System verwarnt - Grund schlechte Ratio.");
      write_modcomment($arr["id"], 0, "Automatische Verwarnung vom System.");
    }
  }

  //Ende verwarnen...

  //Verwarnung wegnehmen bei erfüllten Auflagen by S4NE für die Netvision Source thx to fedepeco

  //Ratio ratio die benötigt wird damit die Verwarnung zurück genommen wird(im Moment 0.6)
  $minratio = $GLOBALS["AUTO_REM_MIN_RATIO"];

  $res = mysql_query("SELECT id, username FROM users WHERE class = 0 AND enabled = 'yes' AND systemwarn = 'yes' AND uploaded / downloaded >= $minratio AND warned = 'yes' AND permban = 'yes' AND warnedby = 'System'") or sqlerr(__FILE__, __LINE__);

  if (mysql_num_rows($res) > 0)
  {
    $dt = sqlesc(get_date_time());
    $msg = sqlesc("Deine verwarnung wurde vom System zurück genommen. Damit so etwas nicht noch einmal passiert halte deine Ratio über " . $GLOBALS["AUTO_REM_MIN_RATIO"] . " .\n");
    while ($arr = mysql_fetch_assoc($res))
    {
      mysql_query("UPDATE users SET warned = 'no', systemwarn = 'no', permban = 'no' WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
      sendPersonalMessage(0, $arr["id"], "Warnung entfernt - Grund Auflagen erfüllt", $msg, PM_FOLDERID_SYSTEM, 0);
      write_log("autodewarn", "Dem Benutzer '<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' wurde automatisch seine Verwarnung entfernt.");
      write_modcomment($arr["id"], 0, "Automatische Verwarnung vom System zurück genommen.");
    }
  }

  //End MOD...

  // Auto Bann wg Bad Ratio
  $date_time = get_date_time(time()-(3600*24*14));
  $kickratio = 0.4;
  $ipbann = true;

  $res = mysql_query("SELECT id, username, ip, email FROM users WHERE uploaded / downloaded < $kickratio AND enabled = 'yes' AND class = 0 AND added <= '".$date_time."'") or sqlerr(__FILE__, __LINE__);

  if (mysql_num_rows($res) > 0)
  {
    $dt = sqlesc(get_date_time());
    $betreff = "Account auf ".$GLOBALS["SITENAME"]." Deaktiviert";
    $msg = "Dein Account wurde automatisch vom System deaktiviert weil deine ShareRatio unter $kickratio gefallen ist";
    if ($ipbann)
      $msg .= "\nZusätzlich wurde deine IP Adresse vom System gabannt";
    $msg = sqlesc($msg."\n\nWir raten Ihnen ab einen neuen Account zu erstellen da wir diesen wieder sofort deaktivieren werden!\n\nWir bedauern dass wir diese Maßnahme einleiten mussten und wünschen Ihnen weiterhin viel Erfolg bei allen was Sie erreichen wollen\n\nMit freundlichen Grüßen\nVisionX");

    while ($arr = mysql_fetch_assoc($res))
    {
      mysql_query("UPDATE users SET warned = 'no', systemwarn = 'no', permban = 'no', enabled = 'no' WHERE id=".$arr['id']) or sqlerr(__FILE__, __LINE__);
      mail($arr['email'], $betreff, $msg, "From: ".$GLOBALS["SITEEMAIL"]);
      write_log("accdisabled", "Der Account '<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' wurde automatisch wegen Bad Ratio Deaktiviert.");
      write_modcomment($arr["id"], 0, "Account Deaktiviert[br]Grund: Bad Ratio");
      if ($ipbann)
      {
        $ip = ip2long($arr['ip']);
        mysql_query("INSERT INTO bans (id, added, addedby, comment, first, last) VALUES (NULL, ".$dt.", 0, 'Bad Ratio: Benutzer ".$arr['username']."', ".$ip.", ".$ip.")") or sqlerr(__FILE__, __LINE__);
      }
    }
  }
  // Autobann Ende

  // Verwarnung von gebannten Usern entfernen
  $res = mysql_query("SELECT id, username FROM users WHERE warned = 'yes' AND enabled = 'no'") or sqlerr(__FILE__, __LINE__);

  while ($arr = mysql_fetch_assoc($res))
  {
    write_log("remwarn", "Die Verwarnung von '<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' wurde automatisch entfernt da der Betreffende Account gebannt wurde");
    write_modcomment($arr["id"], 0, "Verwarnung vom System entfernt da Account Deaktiviert ist");
  }
  mysql_query("UPDATE users SET warned = 'no', systemwarn = 'no', permban = 'no' WHERE enabled = 'no'") or sqlerr(__FILE__, __LINE__);
  // Ende


  // promote power users
  $limit = 25 * 1024 * 1024 * 1024;
  $minratio = 1.1;
  $maxdt = sqlesc(get_date_time(time() - 86400 * 56));
  $res = mysql_query("SELECT id,username FROM users WHERE class = 0 AND uploaded >= $limit AND uploaded / downloaded >= $minratio AND added < $maxdt") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($res) > 0)
  {
    $dt = sqlesc(get_date_time());
    $msg = sqlesc("Glückwunsch, Du wurdest automatisch zum [b]Power User[/b] befördert. :)\nDu kannst Dir nun NFOs ansehen.");
    while ($arr = mysql_fetch_assoc($res))
    {
      mysql_query("UPDATE users SET class = 1 WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
      sendPersonalMessage(0, $arr["id"], "Du wurdest zum [b]Power User[/b] befördert", $msg, PM_FOLDERID_SYSTEM, 0);
      write_log("promotion", "Der Benutzer '<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' wurde automatisch zum Power User befördert.");
      write_modcomment($arr["id"], 0, "Automatische Beförderung zum Power User.");
    }
  }

  // promote xtreme users
  $limit = 200 * 1024 * 1024 * 1024;
  $minratio = 2.20;
  $maxdt = sqlesc(get_date_time(time() - 86400 * 88));
  $res = mysql_query("SELECT id,username FROM users WHERE class = 1 AND uploaded >= $limit AND uploaded / downloaded >= $minratio AND added < $maxdt") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($res) > 0)
  {
    $dt = sqlesc(get_date_time());
    $msg = sqlesc("Glückwunsch, Du wurdest automatisch zum [b]Xtreme User[/b] befördert. :)\nDu kannst nun mehr torrents laden.");
    while ($arr = mysql_fetch_assoc($res))
    {
      mysql_query("UPDATE users SET class = 3 WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
      sendPersonalMessage(0, $arr["id"], "Du wurdest zum [b]X-Treme User[/b] befördert", $msg, PM_FOLDERID_SYSTEM, 0);
      write_log("promotion", "Der Benutzer '<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' wurde automatisch zum Xtreme User befördert.");
      write_modcomment($arr["id"], 0, "Automatische Beförderung zum Xtreme User.");
    }
  }

  // demote power users
  $minratio = 1.09;
  $res = mysql_query("SELECT id,username FROM users WHERE class = 1 AND uploaded / downloaded < $minratio") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($res) > 0)
  {
    $dt = sqlesc(get_date_time());
    $msg = sqlesc("Du wurdest automatisch vom [b]Power User[/b] zum [b]User[/b] degradiert, da Deine Share-Ratio unter $minratio gefallen ist.");
    while ($arr = mysql_fetch_assoc($res))
    {
      mysql_query("UPDATE users SET class = 0 WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
      sendPersonalMessage(0, $arr["id"], "Du wurdest zum [b]User[/b]] degradiert", $msg, PM_FOLDERID_SYSTEM, 0);
      write_log("demotion", "Der Benutzer '<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' wurde automatisch zum User degradiert.");
      write_modcomment($arr["id"], 0, "Automatische Degradierung zum User.");
    }
  }

  // demote xtreme users
  $minratio = 2.19;
  $res = mysql_query("SELECT id,username FROM users WHERE class = 3 AND uploaded / downloaded < $minratio") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($res) > 0)
  {
    $dt = sqlesc(get_date_time());
    $msg = sqlesc("Du wurdest automatisch vom [b]Xtreme User[/b] zum [b]Power User[/b] degradiert, da Deine Share-Ratio unter $minratio gefallen ist.");
    while ($arr = mysql_fetch_assoc($res))
    {
      mysql_query("UPDATE users SET class = 1 WHERE id = $arr[id]") or sqlerr(__FILE__, __LINE__);
      sendPersonalMessage(0, $arr["id"], "Du wurdest zum [b]Power User[/b]] degradiert", $msg, PM_FOLDERID_SYSTEM, 0);
      write_log("demotion", "Der Benutzer '<a href=\"userdetails.php?id=$arr[id]\">$arr[username]</a>' wurde automatisch zum Power User degradiert.");
      write_modcomment($arr["id"], 0, "Automatische Degradierung zum Power User.");
    }
  }


  // Update stats
  $seeders = get_row_count("peers", "WHERE seeder='yes'");
  $leechers = get_row_count("peers", "WHERE seeder='no'");
  mysql_query("UPDATE avps SET value_u=$seeders WHERE arg='seeders'") or sqlerr(__FILE__, __LINE__);
  mysql_query("UPDATE avps SET value_u=$leechers WHERE arg='leechers'") or sqlerr(__FILE__, __LINE__);
  // update forum post/topic count
  $forums = mysql_query("select id from forums");
  while ($forum = mysql_fetch_assoc($forums))
  {
    $postcount = 0;
    $topiccount = 0;
    $topics = mysql_query("select id from topics where forumid=$forum[id]");
    while ($topic = mysql_fetch_assoc($topics))
    {
      $res = mysql_query("select count(*) from posts where topicid=$topic[id]");
      $arr = mysql_fetch_row($res);
      $postcount += $arr[0];
      ++$topiccount;
    }
    mysql_query("update forums set postcount=$postcount, topiccount=$topiccount where id=$forum[id]");
  }

  /////////Update Seederbonus/////////
  $res = mysql_query("SELECT DISTINCT torrent,last_action, userid FROM peers WHERE seeder = 'yes'") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($res) > 0)
  {
    while ($arr = mysql_fetch_assoc($res))
    {
      //$speedu = mysql_query("SELECT sum(((p.uploaded - p.uploadoffset )) / (unix_timestamp(p.last_action) - unix_timestamp(p.started))) AS speed FROM peers p INNER JOIN users u ON p.userid=u.id WHERE u.id=$arr[userid]");
      $seedres = mysql_query("SELECT seedtime FROM traffic WHERE userid = $arr[userid] AND torrentid = $arr[torrent]") or sqlerr(__FILE__, __LINE__);
      $seedarr = mysql_fetch_assoc($seedres);
      if ($seedarr['seedtime'] >= 604800)
        $uploadbonus = 2.500;
      else
        $uploadbonus = 1.500;

      //$tu = mysql_fetch_array($speedu);
      //if ($tu['speed'] >= '10240' || $uploadbonus != 1.500)
        mysql_query("UPDATE users SET seedbonus = seedbonus+$uploadbonus WHERE id = $arr[userid]") or sqlerr(__FILE__, __LINE__);
    }
  }
  /////////Update Seederbonus End////////

  // Delete old/dead and not activated torrents
  if ($GLOBALS["MAX_TORRENT_TTL"])
  {
    $days = $GLOBALS["MAX_TORRENT_TTL"];
    $dt = sqlesc(get_date_time(time() - ($days * 86400)));
    $deadtime = deadtime() - $GLOBALS["MAX_DEAD_TORRENT_TIME"] * 86400;
    $res = mysql_query("SELECT id, name, owner FROM torrents WHERE (added < $dt OR `activated`='no') AND `last_action` < FROM_UNIXTIME($deadtime)");
    while ($arr = mysql_fetch_assoc($res))
    {
      deletetorrent($arr["id"]);
      $msg = sqlesc("Dein Torrent '$arr[name]' wurde automatisch vom System gelöscht. (Inaktiv und älter als $days Tage).\n");
      sendPersonalMessage(0, $arr["owner"], "Einer Deiner Torrents wurde gelöscht", $msg, PM_FOLDERID_SYSTEM, 0);
      write_log("torrentdelete", "Torrent $arr[id] ($arr[name]) wurde vom System gelöscht (Inaktiv und älter als $days Tage)");
    }
  }

  //zeitOU einzelne torrents
  $resf = mysql_query("SELECT id, name, freeuntil FROM torrents WHERE free = 'no' AND freetime = 'yes'") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($resf) > 0)
  {
    $arr = mysql_fetch_array($resf);
    mysql_query("UPDATE torrents SET free ='yes' WHERE free='no' AND freetime = 'yes'") or sqlerr(__FILE__, __LINE__);
    $msg = "Der Torrent ".$arr["name"]." ist bis zum ".$arr["freeuntil"]." auf Only Upload\n";
    $freeou = mysql_query("SELECT id FROM users WHERE class < 25 AND enabled = 'yes'");
    while($outime=mysql_fetch_assoc($freeou))
      sendPersonalMessage(0, $outime["id"], $arr["name"], $msg, PM_FOLDERID_SYSTEM, 0);
  }
  $dt = sqlesc(get_date_time(gmtime()));
  $resg = mysql_query("SELECT id FROM torrents WHERE free = 'yes' AND freetime = 'yes' AND freeuntil = $dt") or sqlerr(__FILE__, __LINE__);
  if (mysql_num_rows($resg) > 0)
  {
    mysql_query("UPDATE torrents SET free = 'no', freetime = 'no', freeuntil = '0000-00-00'") or sqlerr(__FILE__, __LINE__);
  }
  // Delete old entries from start/stop log
  mysql_query("DELETE FROM startstoplog WHERE UNIX_TIMESTAMP(`datetime`) < (UNIX_TIMESTAMP()-864000)");

  // Delete orphaned entries from completed list (either torrent or user doesn't exist anymore)
  $res = mysql_query("SELECT completed.id FROM completed LEFT JOIN torrents ON completed.torrent_id=torrents.id LEFT JOIN users ON completed.user_id=users.id WHERE torrents.id IS NULL OR users.id IS NULL");
  $idlist = "";
  while ($id = mysql_fetch_assoc($res))
  {
    if ($idlist != "") $idlist .= ",";
    $idlist .= $id["id"];
  }

  if ($idlist != "") mysql_query("DELETE FROM completed WHERE id IN ($idlist)");

  // Delete orphaned friends
  $query = "SELECT `friends`.`id` AS `id` FROM `friends` LEFT JOIN `users` AS `myuser` ON `friends`.`userid`=`myuser`.`id` LEFT JOIN `users` AS `myfriend` ON `friends`.`userid`=`myfriend`.`id` WHERE `myuser`.`username` IS NULL OR `myfriend`.`username` IS NULL";
  $res = mysql_query($query);
  $idlist = "";
  while ($id = mysql_fetch_assoc($res))
  {
    if ($idlist != "") $idlist .= ",";
    $idlist .= $id["id"];
  }

  if ($idlist != "")
    mysql_query("DELETE FROM `friends` WHERE `id` IN ($idlist)");

  // Delete orphaned mod comments
  $res = mysql_query("SELECT `modcomments`.`userid` AS `id` FROM `modcomments` LEFT JOIN `users` ON `modcomments`.`userid`=`users`.`id` WHERE `users`.`id` IS NULL");
  $idlist = "";
  while ($id = mysql_fetch_assoc($res))
  {
    if ($idlist != "") $idlist .= ",";
    $idlist .= $id["id"];
  }

  if ($idlist != "")
    mysql_query("DELETE FROM `modcomments` WHERE `userid` IN ($idlist)");

  // Uploadbonus
  $uppbonus = array("0|10","10|25","25|60","60|100","100|150","150|300","300|450","450|600","600|750");
  foreach ($uppbonus as $uppb)
  {
    $uppb  = explode("|",$uppb);
    $uppgb = $uppb[1]*1024*1024*1024;

    $qry = "SELECT id FROM users WHERE upperbonus >= ".$uppb[1]." AND upperstatus = ".$uppb[0];

    $res = mysql_query($qry) or sqlerr(__FILE__, __LINE__);
    while ($arr = mysql_fetch_assoc($res))
    {
      mysql_query("UPDATE users SET uploaded = uploaded + ".$uppgb.", upperstatus= ".$uppb[1]." WHERE id=".$arr['id']) or sqlerr(__FILE__, __LINE__);
      $msg = sqlesc("Du hast ".$uppb[1]." GB Upload gutgeschrieben bekommen.");
      $subject = sqlesc("Glückwunsch, Du hast ".$uppb[1]." Upload-Punkte erreicht");
      sendPersonalMessage(0, $arr['id'], $subject, $msg, PM_FOLDERID_SYSTEM, 0);
    }

    $res = mysql_query("SELECT id FROM users WHERE upperbonus < ".$uppb[1]." AND upperstatus = ".$uppb[1]) or sqlerr(__FILE__, __LINE__);
    while ($arr = mysql_fetch_assoc($res))
    {
      mysql_query("UPDATE users SET uploaded = uploaded - ".$uppgb.", upperstatus= ".$uppb[0]." WHERE id=".$arr['id']) or sqlerr(__FILE__, __LINE__);
      $msg = sqlesc("Dir wurden ".$uppb[1]." GB Upload abgezogen.");
      $subject = sqlesc("Deine Upload-Punkte sind wieder unter ".$uppb[1]);
      sendPersonalMessage(0, $arr['id'], $subject, $msg, PM_FOLDERID_SYSTEM, 0);
    }
  }
  // Ende
   
   // Downloadtickets löschen die nicht benutzt wurden
  $days = 2;
  $ngtime = time()-(3600*24*$days);
  mysql_query("DELETE FROM downloadtickets WHERE added <= ".sqlesc(get_date_time($ngtime))." AND last_action = '0000-00-00 00:00:00'") or sqlerr(__FILE__, __LINE__);
   
  // Inaktive Downloadtickets löschen
  $days = 7;
  $intime = time()-(3600*24*$days);
  mysql_query("DELETE FROM downloadtickets WHERE last_action <= ".sqlesc(get_date_time($intime))." AND added <= ".sqlesc(get_date_time($ngtime))) or sqlerr(__FILE__, __LINE__);

  $lotto = NEW Lottery(true);
}

?>