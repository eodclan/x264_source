<?php
ob_start("ob_gzhandler");

require_once("include/bittorrent.php");

hit_start();

dbconn(false);

loggedinorreturn();
hit_count();

$res = mysql_query("SELECT COUNT(*) FROM torrents WHERE visible='yes' AND torrents.highlight = 'yes'") or die(mysql_error());
$row = mysql_fetch_array($res);
$count = $row[0];

$torrentsperpage = $CURUSER["torrentsperpage"];
if (!$torrentsperpage)
    $torrentsperpage = 15;

if ($count) {
    list($pagertop, $pagerbottom, $limit) = pager($torrentsperpage, $count, "tfiles_highlight.php?" . $addparam);
    $query = "SELECT torrents.id, torrents.category, torrents.leechers, torrents.seeders, torrents.name, torrents.times_completed, torrents.size, torrents.added, torrents.last_action, torrents.comments,torrents.numfiles,torrents.filename,torrents.free, torrents.highlight, torrents.owner, torrents.numpics, torrents.multiplikator, torrents.language,IF(torrents.nfo <> '', 1, 0) as nfoav," .
    // "IF(torrents.numratings < ".$GLOBALS["MINVOTES"].", NULL, ROUND(torrents.ratingsum / torrents.numratings, 1)) AS rating, categories.name AS cat_name, categories.image AS cat_pic, users.username FROM torrents LEFT JOIN categories ON category = categories.id LEFT JOIN users ON torrents.owner = users.id WHERE visible='yes' AND torrents.highlight = 'yes' ORDER BY added DESC $limit";
    "categories.name AS cat_name, categories.image AS cat_pic, users.username, users.class AS uploaderclass FROM torrents LEFT JOIN categories ON category = categories.id LEFT JOIN users ON torrents.owner = users.id WHERE visible='yes' AND torrents.highlight = 'yes' ORDER BY added DESC $limit";
    $res = mysql_query($query) or die(mysql_error());
} else
    unset($res);
x264_header("" . $GLOBALS["SITENAME"] . " Highlight Torrents");
print"
    <div class='row'>
		<div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> " . $GLOBALS["SITENAME"] . " Highlight Torrents
					<div class='card-actions'>
						<a href='#' class='btn-close'><i class='icon-close'></i></a>		
					</div>					
                </div>
                <div class='card-block'>
					<table class='table-bordered'>
                        <thead>";

if ($count) {
    torrenttable($res, "index", $addparam);

    print($pagerbottom);
} 

print"
                        </thead>
                    </table>
				</div>
			</div>
		</div>
	</div>";
					
x264_footer();
hit_end();
?>