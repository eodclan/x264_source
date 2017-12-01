<?
require "include/bittorrent.php";

dbconn();

loggedinorreturn();

check_access(UC_SYSOP);
security_tactics();

x264_bootstrap_header("Mass Mail");

if ($_POST['message'] != "")
{
	$num=0;
	foreach( array_keys($_POST) as $x)
	{ 
		if (substr($x,0,3) == "UC_")
		{  
			$querystring .= " OR class = ".constant($x);  
			$classnames .= substr($x,3).", ";  $num++; 
		}
	} 
	$res = mysql_query("SELECT id, username, email FROM users WHERE id = 1".
	$querystring) or sqlerr(__FILE__, __LINE__); 
	$from_email = "noreply@power-castle.ml"; //site email 
        $subject = substr(trim($_POST["subject"]), 0, 80); 
	if ($subject == "") $subject = "(No subject)"; 
	$subject = "Fw: $subject";  
	$msg = trim($_POST["message"]); 
	while($arr = mysql_fetch_array($res))
		{ 
 		$to = $arr[email]; 
		$message = $msg;
		$success = mail($to, $subject, $message, "From: noreply@power-castle.ml", "-f noreply@power-castle.ml");
	
 		}
	print("<b>Mass Mail succesfully sent.</b><br>");
}
?>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Massen E-Mail System
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>				
<form method=post action="massmail.php">
<b>E@Mail an Mitglieder Rang (Die du anwählst):</b>
<?
$numclasses=0;
$constants = get_defined_constants ();
foreach( array_keys($constants) as $x)
{
if (substr($x,0,3) == "UC_"){
echo "<td><input name=\"".$x."\" type=\"checkbox\" value=1>".substr($x,3)."</td>";
if ($numclasses==5)
echo "<tr></tr><tr></tr>";
$numclasses++;
  }
}
echo "</table>";
		?>
		<input type="hidden" name="numclasses" value="<? echo $numclasses; ?>"/></td></tr>
		<tr><td class="tableb">Betreff</td><td><input type=text size=88 name="subject"></textarea></td></tr>
		<tr><td class="tableb">Nachricht</td><td><textarea cols=88 rows=10 name="message"></textarea></td></tr>
		<tr><td align="center" colspan=2><input type="submit" value="Okay" class="btn" /></td></tr>
		<tr><td class=tablecatob colspan=2><center>&nbsp;</center></td></tr>
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>		
		</form>
<? 
x264_bootstrap_footer(); 
?>