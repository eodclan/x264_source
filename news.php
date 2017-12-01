<?php
require_once(dirname(__FILE__) . "/include/bittorrent.php");
dbconn();
loggedinorreturn();

check_access(UC_ADMINISTRATOR);
security_tactics();

$action = $_GET["action"];

if ($action == 'delete')
{
  $newsid = $_GET["newsid"];
  if (!is_valid_id($newsid))
    stderr("Error", "Ungültige News-ID - Code 1.");

  $returnto = $_GET["returnto"];

  $sure = $_GET["sure"];
  if (!$sure)
print "
					<span><i class='fa fa-check-square-o'></i></span> Willst Du wirklich einen News-Eintrag löschen? Klicke <a href='news.php?action=delete&newsid=".$newsid."&returnto=".$returnto."&sure=1'>hier</a>, wenn Du Dir sicher bist.";	  
  mysql_query("DELETE FROM news WHERE id=$newsid") or sqlerr(__FILE__, __LINE__);

  if ($returnto != "")
    header("Location: $returnto");
  else
    $warning = "Der News-Eintrag wurde erfolgreich gelöscht.";
} 

if ($action == 'add')
{
  $title = $_POST["title"];
  if (!$title)
print "
					<span><i class='fa fa-check-square-o'></i></span> Der Titel darf nicht leer sein!";	  

  $body = trim($_POST["body"]);
  if (!$body)
print "
					<span><i class='fa fa-check-square-o'></i></span> Der Beitrag darf nicht leer sein!	";	  

  $added = $_POST["added"];
  if (!$added)
  $added = sqlesc(get_date_time());

  mysql_query("INSERT INTO news (userid, added, title, body) VALUES (" . $CURUSER['id'] . ", $added, " . sqlesc(stripslashes($title)) . ", " . sqlesc($body) . ")") or sqlerr(__FILE__, __LINE__);
  if (mysql_affected_rows() == 1)
    $warning = "News-Beitrag erfolgreich hinzugefügt.";
  else
print "
					<span><i class='fa fa-check-square-o'></i></span> Unbekannter Fehler...	";	  
} 

if ($action == 'edit')
{
  $newsid = $_GET["newsid"];

  if (!is_valid_id($newsid))
print "
					<span><i class='fa fa-check-square-o'></i></span> Ungültige News-ID - Code 2.";	  

  $res = mysql_query("SELECT * FROM news WHERE id=$newsid") or sqlerr(__FILE__, __LINE__);

  if (mysql_num_rows($res) != 1)
print "
					<span><i class='fa fa-check-square-o'></i></span> Kein News-Eintrag mit der ID ".$newsid." vorhanden.";	  

  $arr = mysql_fetch_array($res);

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $title = $_POST["title"];
    if (!$title)
print "
					<span><i class='fa fa-check-square-o'></i></span> Der Titel darf nicht leer sein!";		
    
    $body = $_POST['body'];
    if ($body == "")
print "
					<span><i class='fa fa-check-square-o'></i></span> Der Beitrag darf nicht leer sein!	";

    $title = sqlesc(stripslashes($title));
    $body = sqlesc(stripslashes($body));

    $editedat = sqlesc(get_date_time());

    mysql_query("UPDATE news SET title=$title,body=$body WHERE id=$newsid") or sqlerr(__FILE__, __LINE__);

    $returnto = $_POST['returnto'];

    if ($returnto != "")
      header("Location: $returnto");
    else
      $warning = "Der News-Beitrag wurde erfolgreich geändert.";
    }
    else
    {
      $returnto = $_GET['returnto'];
      x264_bootstrap_header();
echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>News-Beitrag bearbeiten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>";
      if ($warning)
        print("<p><font size=-3>($warning)</font></p>");
      print("<form method=\"post\" name=\"newsedit\" action=\"news.php?action=edit&newsid=$newsid\"><input type=\"hidden\" name=\"returnto\" value=\"$returnto\">\n");
      begin_table("TRUE");
       print("<tr><td class=\"tableb\">Titel:<br /><input type=\"text\" name=\"title\" size=\"80\" maxlength=\"255\" value=\"". htmlspecialchars(stripslashes($arr["title"])) ."\"></td></tr>\n");
        print "<tr><td class=\"tableb\" colspan=2>Text:<br />";
        textbbcode_none_style("newsedit","body", htmlspecialchars(stripslashes($arr["body"])));
        print "</td></tr>";
        print("<tr><td class=\"tableb\" colspan=\"2\"><br /><input type=submit value='Okay' class=btn></td></tr>\n");
        end_table();
        print("</form>\n");
echo"				  
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
?>
<script type="text/javascript">
_editor_url = "/htmlarea/";
_editor_lang = "de";
</script>
<script type="text/javascript" src="/htmlarea/htmlarea.js"></script>
<script type="text/javascript">
HTMLArea.replace("newseditor")
</script>
<?php	
        x264_bootstrap_footer();
        die;
    } 
} 
// Other Actions and followup    ////////////////////////////////////////////
x264_bootstrap_header("Site news");
echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>News-Beitrag schreiben
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>";

if ($warning)
    print("<p><font size=-3>($warning)</font></p>");
print("<form method=\"post\" name=\"add\" action=\"news.php?action=add\">\n");
begin_table("TRUE");
print("<tr><td class=\"tableb\">Titel:<br /><input type=\"text\" name=\"title\"  size=\"80\" maxlength=\"255\"></td></tr>\n<tr><td class=\"tableb\" colspan=2>Text:<br />");
textbbcode_none_style("add","body","". htmlspecialchars(stripslashes($arr["body"])) .""); 
print("</tr><tr><td class=\"tableb\" colspan=\"2\"><br /><input type=submit value='Okay' class=btn></td></tr>\n");
end_table();
print("</form>\n");
?>
<script type="text/javascript">
_editor_url = "/htmlarea/";
_editor_lang = "de";
</script>
<script type="text/javascript" src="/htmlarea/htmlarea.js"></script>
<script type="text/javascript">
HTMLArea.replace("newseditor")
</script>
<?php	
echo"				  
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

$res = mysql_query("SELECT * FROM news ORDER BY added DESC") or sqlerr(__FILE__, __LINE__);

if (mysql_num_rows($res) > 0) {
echo"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>News-Beitrag bearbeiten
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <td>";	

    while ($arr = mysql_fetch_array($res)) {
        $newsid = $arr["id"];
        $title = htmlspecialchars($arr["title"]);
        $body = $arr["body"];
        $userid = $arr["userid"];
        $added = $arr["added"] . " (vor " . (get_elapsed_time(sql_timestamp_to_unix_timestamp($arr["added"]))) . ")";

        $res2 = mysql_query("SELECT username, donor FROM users WHERE id = $userid") or sqlerr(__FILE__, __LINE__);
        $arr2 = mysql_fetch_array($res2);

        $postername = $arr2["username"];

        if ($postername == "")
            $by = "unknown[$userid]";
        else
            $by = "<a href=userdetails.php?id=$userid><b>$postername</b></a>" .
            ($arr2["donor"] == "yes" ? "<img src=\"".$GLOBALS["PIC_BASE_URL"]."donor.png\" alt='Donor'>" : "");

        begin_table(TRUE);
        print("<tr><td>");
        print("<b>$title</b><br>");
        print("$added&nbsp;---&nbsp;by&nbsp$by");
        print(" - <a href=?action=edit&newsid=$newsid><b><img alt=\"Change\" border=\"0\" src=\"". $GLOBALS['DEFAULTBASEURL'] ."/". $GLOBALS['PIC_BASE_URL'] ."/edit.gif\" style=\"vertical-align: middle;\" title=\"Change\"></b></a>");
        print(" - <a href=?action=delete&newsid=$newsid><b><img alt=\"Remove\" border=\"0\" src=\"". $GLOBALS['DEFAULTBASEURL'] ."/". $GLOBALS['PIC_BASE_URL'] ."/delete.gif\" style=\"vertical-align: middle;\" title=\"Remove\"></b></a>");
        print("</td></tr>\n");
        print("<tr><td>". format_comment($arr['body']) . "</td></tr>\n");
        end_table();
    } 
echo"				  
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
} else
print "
	<div class='row'>
        <div class='col-lg-12'>
            <div class='card'>
                <div class='card-header'>
                    <i class='fa fa-align-justify'></i> News
                </div>
                <div class='card-block'>
					<span><i class='fa fa-check-square-o'></i></span> Keine News vorhanden	
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>";
x264_bootstrap_footer();
die;

?>