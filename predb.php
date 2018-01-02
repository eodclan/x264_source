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

dbconn(false);
x264_header("PreDB Database");
loggedinorreturn();

print "
<script>
function showRSS(str) {
  if (str.length==0) { 
    document.getElementById('rssOutput').innerHTML='';
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById('rssOutput').innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open('GET','ajax_predb.php?q='+str,true);
  xmlhttp.send();
}
</script>

                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i> PreDB Database Browse
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<div class='x264_uspr_right_label'><label>PreDB Database</label><b>Die Abfrage dauert 2 bis 5 Sekunden.</b></div>
									<div class='x264_uspr_right_label'><label><i class='fa fa-arrow-right'></i></label><b>	
									<form>
										<select onchange='showRSS(this.value)'>
											<option value=''>PreDB ausw&auml;hlen:</option>
											<option value='srrdb'>Srrdb</option>
											<option value='nfohump'>Nfohump</option>
											<option value='rlslogappz'>Rlslog Appz</option>				
										</select>
									</form></b></div>	
									<div id='rssOutput'>Die PreDB's werden hier aufgelistet ...</div>				
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";

x264_footer();
?>