<?php
function torrenttable_row_oldschool($torrent_info)
{
    global $CURUSER;

    if (strlen($torrent_info["name"]) > 38)
        $displayname = substr($torrent_info["name"], 0, 38) . "...";
    else
        $displayname = $torrent_info["name"];

    $returnto = "&amp;returnto=" . urlencode($_SERVER["REQUEST_URI"]);
    $baselink = "tfilesinfo.php?id=" . $torrent_info["id"];
    if ($torrent_info["variant"] == "index") {
        $baselink .= "&amp;hit=1";
        $filelistlink = $baselink . "&amp;filelist=1";
        $commlink = $baselink . "&amp;tocomm=1";
        $seederlink = $baselink . "&amp;toseeders=1";
        $leecherlink = $baselink . "&amp;todlers=1";
        $snatcherlink = $baselink . "&amp;tosnatchers=1";
    } else {
        $baselink .= $returnto;
        $filelistlink = $baselink . "&amp;filelist=1#filelist";
        $commlink = $baselink . "&amp;page=0#startcomments";
        $seederlink = $baselink . "&amp;dllist=1#seeders";
        $leecherlink = $baselink . "&amp;dllist=1#leechers";
        $snatcherlink = $baselink . "&amp;snatcher=1#snatcher";
    } 

    if ($torrent_info["leechers"])
        $ratio = $torrent_info["seeders"] / $torrent_info["leechers"];
    elseif ($torrent_info["seeders"])
        $ratio = 1;
    else
        $ratio = 0;

    $seedercolor = get_slr_color($ratio);

    ?>
<div class="x264_tfiles_wrapper_go_ab_mt">  
 <?php
    if (!isset($torrent_info["cat_pic"]))
        if ($torrent_info["cat_name"] != "")
            echo "<a href=\"tfiles.php?cat=" . $torrent_info["category"] . "\">" . $torrent_info["cat_name"] . "</a>";
        else
            echo "-";
        else
            echo "<a href=\"tfiles.php?cat=" . $torrent_info["category"] . "\"><img src=\"" . $GLOBALS["DESIGN_PATTERN"] . "". $GLOBALS["ss_uri"]."/". $GLOBALS["CATEGORY_PATTERN"]."" . $torrent_info["cat_pic"] . "\" alt=\"" . $torrent_info["cat_name"] . "\" title=\"" . $torrent_info["cat_name"] . "\" border=\"0\">" . $torrent_info["cat_name"] . "</a>";

        ?>
</div>
  <td class="tablea" style="text-align:left;vertical-align:middle;" nowrap="nowrap">
  <?php if (isset($torrent_info["uploaderclass"]) && $torrent_info["uploaderclass"] < UC_UPLOADER) {
            echo '<font color="red">[GU]</font> ';
        } 

        ?><a href="<?=$baselink?>" title="<?=htmlspecialchars($torrent_info["name"]);

        ?>"><b><?=htmlspecialchars($displayname)?></b></a><?php if ($torrent_info["variant"] != "guestuploads" && $torrent_info["is_new"]) echo " <font style=\"color:red\">[NEU]</font>";

	?>
	</td>
  <?php if ($torrent_info["variant"] == "mytorrents") {
            ?>
  <td class="tablea" style="text-align:center;vertical-align:middle;" nowrap="nowrap"><a href="edit.php?id=<?=$torrent_info["id"] . $returnto?>">Bearbeiten</a></td>
  <td class="tablea" style="text-align:center;vertical-align:middle;" nowrap="nowrap"><?=($torrent_info["visible"] == "yes"?"Ja":"Nein")?></td>
  <?php } elseif ($torrent_info["variant"] == "guestuploads") {
            ?>
  <td class="tablea" style="text-align:center;vertical-align:middle;" nowrap="nowrap"><?php if ($torrent_info["gu_agent"] > 0) echo "Ja";
            else echo "<font color=\"red\">Nein</font>";
            ?></td>  
  <?php } elseif ($torrent_info["has_wait"]) {

            ?>
  <td class="tablea" style="text-align:center;vertical-align:middle;" nowrap="nowrap"><?php echo "<font color=\"", $torrent_info["wait_color"], "\">", $torrent_info["wait_left"], "<br>Std.</font>";

            ?></td>
  <?php } 

        ?>
  <td class="tablea" style="text-align:right;vertical-align:middle;" nowrap="nowrap"><a href="<?=$filelistlink?>"><?=$torrent_info["numfiles"]?></a></td>
  <td class="tablea" style="text-align:right;vertical-align:middle;" nowrap="nowrap"><a href="<?=$commlink?>"><?=$torrent_info["comments"]?></a></td>
  <td class="tablea" style="text-align:center;vertical-align:middle;" nowrap="nowrap"><?=str_replace("&nbsp;", "<br>", $torrent_info["added"])?></td>
  <td class="tablea" style="text-align:center;vertical-align:middle;" nowrap="nowrap"><?=str_replace(" ", "<br>", $torrent_info["ttl"])?></td>
  <td class="tablea" style="text-align:center;vertical-align:middle;" nowrap="nowrap"><?=str_replace(" ", "<br>", mksize($torrent_info["size"]))?></td>
  <td class="tablea" style="text-align:center;vertical-align:middle;" nowrap="nowrap"><div style="border:1px solid black;padding:0px;width:60px;height:10px;"><div style="border:none;width:<?=60 * $torrent_info["dist"] / 100?>px;height:10px;background-image:url(<?=$GLOBALS["CATEGORY_PATTERN"]?>ryg-verlauf-small.png);background-repeat:no-repeat;"></div></div></td>
  <td class="tablea" style="text-align:center;vertical-align:middle;" nowrap="nowrap"><a href="<?=$snatcherlink?>"><?=$torrent_info["times_completed"]?></a></td>
  <td class="tablea" style="text-align:center;vertical-align:middle;" nowrap="nowrap"><a href="<?=$seederlink?>"><font color="<?=$seedercolor?>"><?=intval($torrent_info["seeders"])?></font></a></td>
  <td class="tablea" style="text-align:center;vertical-align:middle;" nowrap="nowrap"><a href="<?=$leecherlink?>"><font color="<?=linkcolor($torrent_info["seeders"])?>"><?=intval($torrent_info["leechers"])?></font></a></td>
  <td class="tablea" style="text-align:left;vertical-align:middle;" nowrap="nowrap">D:&nbsp;<?=$torrent_info["dlspeed"]?>&nbsp;KB/s<br>U:&nbsp;<?=$torrent_info["ulspeed"]?>&nbsp;KB/s</td>
  <?php if ($torrent_info["variant"] == "index") {

            ?>
  <td class="tablea" style="text-align:left;vertical-align:middle;" nowrap="nowrap"><?=$torrent_info["uploaderlink"]?></td>
  <?php } 

        ?>  

<?php
    } 	

    function torrenttable_row($torrent_info)
    {
        global $CURUSER;

	
    if (strlen($torrent_info["name"]) > 38)
        $displayname = substr($torrent_info["name"], 0, 38) . "...";
    else
        $displayname = $torrent_info["name"];

        $returnto = "&amp;returnto=" . urlencode($_SERVER["REQUEST_URI"]);
        $baselink = "tfilesinfo.php?id=" . $torrent_info["id"];
        if ($torrent_info["variant"] == "index") {
            $baselink .= "&amp;hit=1";
            $filelistlink = $baselink . "&amp;filelist=1";
            $commlink = $baselink . "&amp;tocomm=1";
            $seederlink = $baselink . "&amp;toseeders=1";
            $leecherlink = $baselink . "&amp;todlers=1";
            $snatcherlink = $baselink . "&amp;tosnatchers=1";
        } else {
            $baselink .= $returnto;
            $filelistlink = $baselink . "&amp;filelist=1#filelist";
            $commlink = $baselink . "&amp;page=0#startcomments";
            $seederlink = $baselink . "&amp;dllist=1#seeders";
            $leecherlink = $baselink . "&amp;dllist=1#leechers";
            $snatcherlink = $baselink . "&amp;snatcher=1#snatcher";
        } 

        if ($torrent_info["leechers"])
            $ratio = $torrent_info["seeders"] / $torrent_info["leechers"];
        elseif ($torrent_info["seeders"])
            $ratio = 1;
        else
            $ratio = 0;

        $seedercolor = get_slr_color($ratio);

        $res = mysql_query("SELECT DISTINCT(user_id) as id, username, class, peers.id as peerid FROM completed,users LEFT JOIN peers ON peers.userid=users.id AND peers.torrent=" . $torrent_info["id"] . " AND peers.seeder='yes' WHERE completed.user_id=users.id AND completed.torrent_id=" . $torrent_info["id"] . " ORDER BY complete_time DESC LIMIT 10");

        $last10users = "";
        while ($arr = mysql_fetch_assoc($res)) {
            if ($last10users) $last10users .= ", ";
            $arr["username"] = "<font class=\"" . get_class_color($arr["class"]) . "\">" . $arr["username"] . "</font>";
            if ($arr["peerid"] > 0) {
                $arr["username"] = "<b>" . $arr["username"] . "</b>";
            } 
            $last10users .= "<a href=\"userdetails.php?id=" . $arr["id"] . "\">" . $arr["username"] . "</a>";
        } 	
		
        if ($last10users == "")
            $last10users = "Diesen Torrent hat noch niemand fertiggestellt.";
        else
            $last10users .= "<br><br>(Fettgedruckte User seeden noch)";

        if ($GLOBALS["DOWNLOAD_METHOD"] == DOWNLOAD_REWRITE)
            $download_url = "download/" . $torrent_info["id"] . "/" . rawurlencode($torrent_info["filename"]);
        else
            $download_url = "download.php?torrent=" . $torrent_info["id"];

		
        ?>
	<tr class="table table-bordered table-striped table-condensed">
		<td width="8%">
		<?php
			echo "<a class=\"btn  btn-primary btn-sm text-center\" width=\"6%\" href=\"tfiles.php?cat=" . $torrent_info["category"] . "\"><span width=\"6%\" class=\"btn btn-primary btn-sm text-center\">Kategorie</span><br><span width=\"6%\" class=\"btn btn-primary btn-sm text-center\">" . $torrent_info["cat_name"] . "</span></a>";
		?>
		</th>
		<th width="40%">
			<a href="<?=$baselink?>"><h6><?=trim_it($torrent_info["name"],78)?></h6>
				<?php
				if (!empty($torrent_info["added"]))
				{
				?>
				<span class="btn  btn-primary btn-sm text-center"><i class="icon icon-eye"></i> Pretime: <?=$torrent_info["added"]?> (-1 GMT)</span>
				<?php
				}
				else
				{
				?>
				<span class="btn  btn-primary btn-sm text-center"><i class="icon icon-eye"></i> Pretime: Keine Pretime gefunden!</span>
				<?php
				}
				?>
			</a>
		</td>
		<td width="8%"><span class="btn  btn-primary btn-sm text-center"><i class="fa fa-file-text-o"></i> <?=$torrent_info["numfiles"]?></td>
		<td width="8%"><span class="btn  btn-primary btn-sm text-center"><i class="icon icon-pie-chart"></i> <?=mksize($torrent_info["size"])?></td>
		<td width="5%"><span class="btn  btn-primary btn-sm text-center"><i class="fa fa-toggle-down"></i>&nbsp;<?=intval($torrent_info["seeders"])?></span><br><span class="btn  btn-primary btn-sm text-center"><i class="fa fa-toggle-up"></i>&nbsp;<?=intval($torrent_info["leechers"])?></span></td>
	</tr>

<?php
        } 

        function torrenttable($res, $variant = "index", $addparam = "")
        {
            global $CURUSER; 

    if (strlen($torrent_info["name"]) > 38)
        $displayname = substr($torrent_info["name"], 0, 38) . "...";
    else
        $displayname = $torrent_info["name"];
            // Sortierkriterien entfernen
            $addparam_nosort = preg_replace(array("/orderby=(.*?)&amp;/i", "/sort=(.*?)&amp;/i"), array("", ""), $addparam); 
            // Hat dieser Benutzer Wartezeit?
            $has_wait = get_wait_time($CURUSER["id"], 0, true);

            ?>
<script type="text/javascript">

function expandCollapse(torrentId)
{
    var plusMinusImg = document.getElementById("plusminus"+torrentId);
    var detailRow = document.getElementById("details"+torrentId);

    if (plusMinusImg.src.indexOf("<?=$GLOBALS["DESIGN_PATTERN"] . $GLOBALS["ss_uri"]?>/plus.gif") >= 0) {
        plusMinusImg.src = "<?=$GLOBALS["DESIGN_PATTERN"] . $GLOBALS["ss_uri"]?>/minus.gif";
        detailRow.style.display = "block";
    } else {
        plusMinusImg.src = "<?=$GLOBALS["DESIGN_PATTERN"] . $GLOBALS["ss_uri"]?>/plus.gif";
        detailRow.style.display = "none";
    }
}

</script>

<?php

            if ($CURUSER["oldtorrentlist"] == "yes") {

                ?>
<table border="0" cellspacing="1" cellpadding="4" class="tableinborder" style="width:100%" summary="none">
<tr>
  <td class="tablecat" align="center">Typ</td>
  <td class="tablecat" align="left">Name</td>
  <?php if ($variant == "mytorrents") {

                    ?>
  <td class="tablecat" align="center">Bearbeiten</td>
  <td class="tablecat" align="center">Sichtbar</td>  
  <?php } elseif ($variant == "guestuploads") {

                    ?>
  <td class="tablecat" align="center">In&nbsp;Bearbeitung</td>
  <?php } elseif ($has_wait) {

                    ?>
  <td class="tablecat" align="center">Wartez.</td>  
  <?php } 

                ?>
  <td class="tablecat" align="right">Dateien</td>
  <td class="tablecat" align="right">Komm.</td>
  <td class="tablecat" align="center">Hinzugef.</td>
  <td class="tablecat" align="center">TTL</td>
  <td class="tablecat" align="center">Gr&ouml;&szlig;e</td>
  <td class="tablecat" align="center">Verteilung</td>
  <td class="tablecat" align="center">Fertig</td>
  <td class="tablecat" align="right">Seeder</td>
  <td class="tablecat" align="right">Leecher</td>
  <td class="tablecat" align="left">&Oslash;&nbsp;Geschw.</td>
  <?php if ($variant == "index") {

                    ?>
  <td class="tablecat" align="center">Uploader</td>          
  <?php } 

                ?>
</tr>               
            <?php
            } else {

                ?>
<table border="0" cellspacing="1" cellpadding="0" class="tableinborder" style="width:100%" summary="none">
  <colgroup>
    <col width="32">
    <col width="100%">
    <col width="22">
  </colgroup>
            <?php		

            } while ($row = mysql_fetch_assoc($res)) {
                $id = $row["id"];

                $torrent_info = array();
                $torrent_info["id"] = $row["id"];
                $torrent_info["name"] = htmlspecialchars($row["name"]);
                $torrent_info["activated"] = (isset($row["activated"])?$row["activated"]:"yes");
                $torrent_info["gu_agent"] = (isset($row["gu_agent"])?$row["gu_agent"]:0);
                $torrent_info["filename"] = $row["filename"];
                $torrent_info["variant"] = $variant;
                $torrent_info["category"] = $row["category"];
                $torrent_info["cat_name"] = $row["cat_name"];
                //$torrent_info["cat_hname"] = mysql_query("SELECT * FROM categories where type = 1 LEFT JOIN categories ON category = categories.name");
                //$torrent_info["cat_hname"] = mysql_query("SELECT * FROM categories where type = 1 LEFT JOIN SELECT * FROM categories where categories.name");				
				$torrent_info["preTime"] = $row["preTime"];
                $torrent_info["type"] = $row["type"];
                $torrent_info["numfiles"] = ($row["type"] == "single"?1:$row["numfiles"]);
                $torrent_info["size"] = $row["size"];
                $torrent_info["times_completed"] = intval($row["times_completed"]);
                $torrent_info["seeders"] = $row["seeders"];
                $torrent_info["leechers"] = $row["leechers"];
                $torrent_info["uploaderlink"] = (isset($row["username"]) ? ("<a href=\"userdetails.php?id=" . $row["owner"] . "\"><b>" . htmlspecialchars($row["username"]) . "</b></a>") : "<i>(Gel�t)</i>");
                $torrent_info["added"] = str_replace(" ", "&nbsp;", date("H:i:s", sql_timestamp_to_unix_timestamp($row["added"])));
                $torrent_info["comments"] = $row["comments"];
                $torrent_info["visible"] = $row["visible"];
                $torrent_info["last_action"] = str_replace(" ", "&nbsp;", date("d.m.Y H:i:s", sql_timestamp_to_unix_timestamp($row["last_action"])));

                if (isset($row["cat_pic"]) && $row["cat_pic"] != "")
                    $torrent_info["cat_pic"] = $row["cat_pic"];

                if (isset($row["uploaderclass"]))
                    $torrent_info["uploaderclass"] = $row["uploaderclass"];

                $torrent_info["has_wait"] = $has_wait;
                if ($has_wait) {
                    $torrent_info["wait_left"] = get_wait_time($CURUSER["id"], $id);
                    $torrent_info["wait_color"] = dechex(floor(127 * ($wait_left) / 48 + 128) * 65536);
                } 

                $speedres = mysql_query("SELECT ROUND(AVG((downloaded - downloadoffset) / (UNIX_TIMESTAMP() - UNIX_TIMESTAMP(`started`)))/1024, 2) AS dlspeed, ROUND(AVG((uploaded - uploadoffset) / (UNIX_TIMESTAMP() - UNIX_TIMESTAMP(`started`)))/1024, 2) AS ulspeed FROM peers WHERE torrent=$id");
                $speed = mysql_fetch_assoc($speedres);
                if ($speed["dlspeed"] == 0) $speed["dlspeed"] = "0";
                if ($speed["ulspeed"] == 0) $speed["ulspeed"] = "0";
                $torrent_info["dlspeed"] = $speed["dlspeed"];
                $torrent_info["ulspeed"] = $speed["ulspeed"];

                $distres = mysql_query("SELECT ROUND(AVG((" . $row["size"] . " - `to_go`) / " . $row["size"] . " * 100),2) AS `dist` FROM `peers` WHERE torrent=$id");
                $dist = mysql_fetch_assoc($distres);
                $torrent_info["dist"] = $dist["dist"];

                $ttl = (28 * 24) - floor((time() - sql_timestamp_to_unix_timestamp($row["added"])) / 3600);
                if ($ttl == 1) $ttl .= " Stunde";
                else $ttl .= " Stunden";
                $torrent_info["ttl"] = $ttl;

                $newadd = "";

                $torrentunix = sql_timestamp_to_unix_timestamp($row["added"]);
                $accessunix = sql_timestamp_to_unix_timestamp($CURUSER["last_access"]);

                if ($torrentunix >= $accessunix)
                    $torrent_info["is_new"] = true;

                if ($CURUSER["oldtorrentlist"] == "yes") {
                    torrenttable_row_oldschool($torrent_info);
                } else {
                    torrenttable_row($torrent_info);
                } 
            } 

            ?>
</table>
<?php
            return $rows;
        } 
?>