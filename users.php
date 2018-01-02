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
dbconn();
loggedinorreturn();

x264_header("Members von ".$GLOBALS["SITENAME"]."");
check_access(UC_MODERATOR);

$res = mysql_query("SELECT * FROM users WHERE username LIKE 'a%' ORDER BY username LIMIT 50");
$num = mysql_num_rows($res);
$ut ="";
$ut .= "<center><table cellspacing=1 cellpadding=4 border=0>\n";
$ut .= "<tr><td class=colhead align=left>Username</td><td class=colhead>Registriert seid:</td><td class=colhead>Letzter Login</td><td class=colhead>Land</td><td class=colhead align=left>Rang</td></tr>\n";
for ($i = 0; $i < $num; ++$i)
{
  $arr = mysql_fetch_assoc($res);
  if ($arr['country'] > 0)
  {
    $cres = mysql_query("SELECT name,flagpic FROM countries WHERE id=$arr[country]");
    if (mysql_num_rows($cres) == 1)
    {
      $carr = mysql_fetch_assoc($cres);
      $country = "<td style='padding: 0px' align=center><img src=pic/flag/{$carr['flagpic']} alt=". htmlspecialchars($carr['name']) ."></td>";
    }
  }
  else
    $country = "<td align=center>---</td>";
  if ($arr['added'] == '0000-00-00 00:00:00')
    $arr['added'] = '-';
  if ($arr['last_access'] == '0000-00-00 00:00:00')
    $arr['last_access'] = '-';
  $ut .= "<tr><td align=left><a href=userdetails.php?id=$arr[id]><b>$arr[username]</b></a>" .($arr["donated"] > 0 ? "<img src=/pic/star.gif border=0 alt='Donor'>" : "")."</td>" .
  "<td>$arr[added]</td><td>$arr[last_access]</td>$country".
    "<td align=left>" . get_user_class_name($arr['class']) . "</td></tr>\n";
}
$ut .= "</table>\n";

?>
<script language="Javascript">
  
var lasttext = "";

function usearch(hehe) {
  
  var texxt = document.getElementById("usearch").value;

  if(texxt != lasttext || hehe == 1)
  {
    document.getElementById("loading").innerHTML = '<img src="pic/loading.gif" width="16" height="16">';
    lasttext = texxt;
    window.location.href = '#usearch=' + escape(texxt);
    
    try{
    uajax.abort()
    }
    catch(e){
    }

    var url = 'ajax_users.php?text=' + escape(texxt) + '&rand=' + Math.random();;
    if(window.XMLHttpRequest)
    {
      uajax = new XMLHttpRequest();
    }
    else
    {
      uajax = new ActiveXObject("Microsoft.XMLHTTP");
    }
    uajax.open("GET", url, true);    
    uajax.onreadystatechange = ugo;
    uajax.send(null);
    
	}
	
	
}

function ugo() {
  if (uajax.readyState == 4) {
	  if (uajax.status == 200) {
		
      var urespons = uajax.responseText;
      document.getElementById("userdiv").innerHTML = urespons;
      
      document.getElementById("loading").innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	  }
  }
}
</script>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa icon-people'></i>Members von <?=$GLOBALS["SITENAME"];?>
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
					<div>User suchen:</div><div><input type="text" size="30" name="usearch" onkeyup="usearch();" id="usearch"></div></div>
					<div>Member Liste:</div><div>&nbsp;&nbsp;<var id="loading"></var>				<div id="userdiv"><?=$ut?></div>
					<script type="text/javascript">
						var url = window.location.href;
						var pos = url.indexOf('#usearch=');
						if(pos > -1)
						{
							var ord = url.substr(pos+9);

							if(ord.length > 1)
							{
								document.getElementById('usearch').value = ord;
								usearch(ord);
							}
						}
					</script></div></div>		
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
<?php
x264_footer();
?>