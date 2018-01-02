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
require_once(dirname(__FILE__) . "/include/Classes/ServerInfo.class.php");
dbconn();
loggedinorreturn();
check_access(UC_PARTNER);
security_tactics();
x264_admin_header("Backend ACP ".$GLOBALS["X264_STAFFACP_VERSION"]."");

		$peers 		= number_format(get_row_count("peers"));
		$seeder 	= get_row_count("peers", "WHERE seeder = 'yes'");
		$leecher 	= get_row_count("peers", "WHERE seeder = 'no'");
		if($leecher != 0){$pratio = number_format(($seeder / $leecher) * 100,0);}else{$pratio = number_format($seeder * 100);}

		$registered = number_format(get_row_count("users"));
		$torrents 	= number_format(get_row_count("torrents"));
		$inaktive 	= number_format(get_row_count("torrents", "WHERE visible = 'no'"));		
		$aktive 	= number_format(get_row_count("torrents", "WHERE visible = 'yes'"));
		$newest = mysql_ein_datensatz("SELECT id, username, class FROM users WHERE status = 'confirmed' ORDER BY id DESC LIMIT 1");
		$ist_jahr = date("Y", time());
		$ist_month = date("n", time());
		$ist_day = date("j", time());
		$heute = mktime(0, 0, 0, $ist_month, $ist_day, $ist_jahr);		
		$heute_up 	= get_row_count("torrents", "WHERE UNIX_TIMESTAMP(added) > ".$heute." ");

echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Willkommen im Backend ACP!
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
                                    Du hast nun hier die Möglichkeit zu deinen Rang bestimmte Funktionen zu machen.
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";		
		
if (get_user_class() >= UC_MODERATOR) {		
?>
	<div class='row'>
        <div class='col-sm-6 col-lg-3'>
            <div class='card'>
                <div class='card-block'>
                    <div class='h4 m-0'><?=$registered;?></div>
                    <div>Members</div>
                    <div class='progress progress-xs my-1'>
                        <div class='progress-bar bg-success' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                    </div>
                    <small class='text-muted'>Der neuste User ist <a href="userdetails.php?id=<?=$newest['id'];?>" style="<?=get_class_color($newest['class']);?>"><?=$newest['username'];?></a></small>
                </div>
            </div>
        </div>
        <!--/.col-->
        <div class='col-sm-6 col-lg-3'>
            <div class='card'>
                <div class='card-block'>
                    <div class='h4 m-0'><?=$aktive;?></div>
                    <div>Torrents</div>
                    <div class='progress progress-xs my-1'>
                        <div class='progress-bar bg-info' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                    </div>
                    <small class='text-muted'>Inaktive: <?=$inaktive;?></small>
                </div>
            </div>
        </div>
        <!--/.col-->
        <div class='col-sm-6 col-lg-3'>
            <div class='card'>
                <div class='card-block'>
                    <div class='h4 m-0'><?=$heute_up;?></div>
                    <div>Uploads Heute</div>
                    <div class='progress progress-xs my-1'>
                        <div class='progress-bar bg-warning' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                    </div>
                    <small class='text-muted'>Torrents insgesamt <?=$aktive;?></small>
                </div>
            </div>
        </div>
        <!--/.col-->
        <div class='col-sm-6 col-lg-3'>
            <div class='card'>
                <div class='card-block'>
                    <div class='h4 m-0'><?=$peers;?></div>
                    <div>Peers</div>
                    <div class='progress progress-xs my-1'>
                        <div class='progress-bar bg-danger' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                    </div>
                    <small class='text-muted'>Seeder/Leecher Ratio (%): <?=$pratio;?></small>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>
<?
// Last Forums
function tpic($laspr,$lastp,$locked)
{
  global $GLOBALS;
  $new =  "";
  if($lastp > $laspr)
    $new = 1;
  $topicpic = ($locked == 'yes' ? ($new ? "lockednew" : "locked") : ($new ? "unlockednew" : "unlocked"));
  $topicpicalt = ($locked == 'yes' ? ($new ? "Thema ist geschlossen und hat neue Beiträge" : "Thema ist geschlossen und hat keine neuen Beiträge") : ($new ? "Neue Beiträge vorhanden" : "Keine neuen Beiträge vorhanden"));
  return "<img src='".$GLOBALS["DESIGN_PATTERN"].$topicpic.".gif' alt='$topicpicalt' border=0>";
}

$number_of_topics = 3;

echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Die ".$number_of_topics." letzten Aussen Kontakt Forum Posts
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>

<table id='example1' class='table table-bordered table-striped'>
  <tr>
    <th>
      &nbsp;
    </th>
    <th>
      Thema
    </th>
    <th>
      Author
    </th>
    <th>
      Zugriffe
    </th>
    <th>
      Antworten
    </th>
    <th>
      Letzter Beitrag
    </th>
  </tr>";

$ltres = mysql_query("
SELECT
t.*,
p.id AS lpid, p.added AS lpdate,p.userid  AS lpuid,
p2.added AS tadded,
u1.class AS uclass, u1.username AS addername,
u2.class AS lpuclass, u2.username  AS lpaddername,
(SELECT COUNT(id) FROM posts where topicid = t.id) AS pcount,
(SELECT lastpostread FROM readposts WHERE userid=".$CURUSER['id']." AND topicid=t.id limit 1) AS lastpostread
FROM topics AS t
LEFT JOIN posts AS p ON p.id=(SELECT MAX(id) FROM posts WHERE topicid=t.id)
LEFT JOIN posts AS p2 ON p2.id=(SELECT MIN(id) FROM posts WHERE topicid=t.id)
LEFT JOIN users AS u1 ON u1.id=t.userid
LEFT JOIN users AS u2 ON u2.id=p.userid
LEFT JOIN forums ON forums.id=t.forumid
WHERE forums.minclassread <= ".$CURUSER['class']."
ORDER BY p.added DESC
LIMIT $number_of_topics"
)or sqlerr(__FILE__, __LINE__);

while($ltrow = mysql_fetch_array($ltres))
{
  $perpage = $CURUSER["postsperpage"];;
  if (!$perpage)
    $perpage = 24;
  $posts = $ltrow["pcount"];
  $pages = ceil($posts / $perpage);
  $menu = "";
  if ($pages > 1)
  {
    if($pages > 7)
    {
      for ($i = 1; $i <= ($pages-$pages+3); $i++)
      {
        $menu .= "<a href=forums.php?action=viewtopic&topicid=".$ltrow['id']."&page=$i>$i</a>";
        if ($menu and $i < 3)
         $menu .= ",\n";
      }

      $menu .= " ... ";
      for ($i = ($pages-2); $i <= $pages; $i++)
      {
        $menu .= "<a href=forums.php?action=viewtopic&topicid=".$ltrow['id']."&page=$i>$i</a>\n";
        if ($menu and $i < $pages)
          $menu .= ",\n";
      }
    }elseif($pages < 7)
    {
      for ($i = 1; $i <= $pages; $i++)
      {
        $menu .= "<a href=forums.php?action=viewtopic&topicid=".$ltrow['id']."&page=$i>$i</a>\n";
        if ($i < $pages)
          $menu .= ",\n";
        if($i == $pages && $i > 1)
          $menu .= "";
        }
      }
    }
echo "
  <tr>
    <td>
      ".tpic($ltrow['lastpostread'],$ltrow['lpid'],$ltrow['locked'])."
    </td>
    <td>
      <div style='float: left;'>
        ".($ltrow['sticky'] == 'yes' ? "Sticky: " : "") . "<a href='forums.php?action=viewtopic&topicid=".$ltrow['id']."'>".$ltrow['subject']."</a><br>".($menu ? "gehe zur Seite: <img src=pic/multipage.gif> $menu" :"")."
      </div>
      <div style='float: right;'>
        ".date("d.m.Y H:i:s",sql_timestamp_to_unix_timestamp($ltrow['tadded']))."
      </div>
    </td>
    <td>
      <a href='userdetails.php?id=".$ltrow['userid']."'>
        <font class=".get_class_color($ltrow['uclass'])."><b>".$ltrow['addername']."</b></font>
      </a>
    </td>
    <td>
      ".$ltrow['views']."
    </td>
    <td>
      ".$ltrow['pcount']."
    </td>
    <td>
      <a href='userdetails.php?id=".$ltrow['lpuid']."'>
        <font class=".get_class_color($ltrow['lpuclass'])."><b>".$ltrow['lpaddername']."</b></font>
      </a>
      <br>".date("d.m.Y H:i:s",sql_timestamp_to_unix_timestamp($ltrow['lpdate']))."
      <a href='forums.php?action=viewtopic&topicid=".$ltrow['id']."&page=".$ltrow['lastpost']."#".$ltrow['lastpost']."'>
        <img src=\"".$GLOBALS["DESIGN_PATTERN"]."/lastreply.gif\" border=0 alt=\"Jump to last post\" title=\"Jump to last post\" >
      </a>
    </td>
  </tr>";
}
print "
                      </td>
                    </tr>
                  </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

//Ende

}  
if (get_user_class() >= UC_BOSS) {

// format the uptime in case the browser doesn't support dhtml/javascript
// static uptime string
function format_uptime($seconds) {
  $secs = intval($seconds % 60);
  $mins = intval($seconds / 60 % 60);
  $hours = intval($seconds / 3600 % 24);
  $days = intval($seconds / 86400);
  
  if ($days > 0) {
    $uptimeString .= $days;
    $uptimeString .= (($days == 1) ? " day" : " days");
  }
  if ($hours > 0) {
    $uptimeString .= (($days > 0) ? ", " : "") . $hours;
    $uptimeString .= (($hours == 1) ? " hour" : " hours");
  }
  if ($mins > 0) {
    $uptimeString .= (($days > 0 || $hours > 0) ? ", " : "") . $mins;
    $uptimeString .= (($mins == 1) ? " minute" : " minutes");
  }
  if ($secs > 0) {
    $uptimeString .= (($days > 0 || $hours > 0 || $mins > 0) ? ", " : "") . $secs;
    $uptimeString .= (($secs == 1) ? " second" : " seconds");
  }
  return $uptimeString;
}

// read in the uptime (using exec)
$uptime = exec("cat /proc/uptime");
$uptime = split(" ",$uptime);
$uptimeSecs = $uptime[0];

// get the static uptime
$staticUptime = "".format_uptime($uptimeSecs);
?>
<script language="javascript">
<!--
var upSeconds=<?php echo $uptimeSecs; ?>;
function doUptime() {
var uptimeString = " ";
var secs = parseInt(upSeconds % 60);
var mins = parseInt(upSeconds / 60 % 60);
var hours = parseInt(upSeconds / 3600 % 24);
var days = parseInt(upSeconds / 86400);
if (days > 0) {
  uptimeString += days;
  uptimeString += ((days == 1) ? " day" : " days");
}
if (hours > 0) {
  uptimeString += ((days > 0) ? ", " : "") + hours;
  uptimeString += ((hours == 1) ? " hour" : " hours");
}
if (mins > 0) {
  uptimeString += ((days > 0 || hours > 0) ? ", " : "") + mins;
  uptimeString += ((mins == 1) ? " minute" : " minutes");
}
if (secs > 0) {
  uptimeString += ((days > 0 || hours > 0 || mins > 0) ? ", " : "") + secs;
  uptimeString += ((secs == 1) ? " second" : " seconds");
}
var span_el = document.getElementById("uptime");
var replaceWith = document.createTextNode(uptimeString);
span_el.replaceChild(replaceWith, span_el.childNodes[0]);
upSeconds++;
setTimeout("doUptime()",1000);
}
// -->
</script>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Server Status
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<pre><?php echo $staticUptime; ?></pre>
									<pre><?php system("uname -a"); ?></pre>
									<pre><?php system("df -h"); ?></pre>
									<pre><?php system("cat /proc/cpuinfo | grep \"model name\\|processor\""); ?></pre>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?	  
}
x264_admin_footer();
?>