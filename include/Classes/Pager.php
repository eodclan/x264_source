<?php
function pager ($torrentsperpage, $count, $href, $opts = array())
{
  if (isset($_GET["page"]))
  {
    $page = intval($_GET["page"]);
    if ($page < 0) $page = 0;
  }

  $page_anz = ceil($count / $torrentsperpage);
  $pager_size = 10;
  $pager = "<br /><div class=\"x264_pager_breadcrumb\"><span class=\"x264_pager_left\"></span><ul>";

  if ($page_anz > 1)
  {
     $url     = "<li><a href=\"{$href}page=%d\" class=\"btn btn-primary btn-sm text-center\" title=\"%s\" >%s</a></li>";
     $url_set = "<li class=\"btn btn-flat btn-primary fc-today-button active\" style=\"padding: 7px 7px 5px 5px;\">%s</li>";

     if ($page > 0)
     {
        $pager .= sprintf($url, 0, "Anfang", "&lArr;");
        $pager .= sprintf($url, $page - 1, "Zur&uuml;ck", "&larr;");
     }

     if ($count > $pager_size)
     {
        $startpage = max($page - intval($pager_size / 2), 0);
        $endpage   = min($page + intval($pager_size / 2), $page_anz) +1;

        $anzahl = ($page * 2) + 1;
        if ($endpage > $page_anz) $endpage = $page_anz;
        if ($anzahl <= $pager_size) $endpage = $pager_size;
        if (($endpage - $page) <= ($pager_size / 2)) $startpage = $endpage - $pager_size - 1;
     }
     else
     {
        $startpage = 0;
        $endpage   = $count;
     }

     for($i = $startpage; $i < $endpage; $i++)
     {
        $start = $i * $torrentsperpage + 1;
        $ende  = $start + $torrentsperpage - 1;
        if ($i != $page) $pager .= sprintf($url, $i, "Torrents " . $start . "-" . $ende, $i + 1);
        else $pager .= sprintf($url_set, ($i + 1));
     }

     if ($page < $page_anz - 1)
     {
        $pager .= sprintf($url, $page + 1, "Weiter", "&rarr;");
        $pager .= sprintf($url, $page_anz - 1, "Ende", "&rArr;");
     }

    $pager .= "</ul><span class=\"x264_pager_right\"></span></div>\n<br>\n";

    $start = $page * $torrentsperpage;
    return array($pager, $pager, "LIMIT $start, $torrentsperpage");
  }
}  
?>