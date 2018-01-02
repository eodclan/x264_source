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
loggedinorreturn();

check_access(UC_DEV);
security_tactics();

if (get_user_class() < UC_DEV) $action = "";
elseif (isset($_POST["action"])) $action = htmlentities(trim($_POST["action"]));
elseif (isset($_GET["action"])) $action = htmlentities(trim($_GET["action"]));
else $action = "view";

x264_admin_header("Tracker Config");

$CONF["PIC_URL"] = $GLOBALS["ADMIN_BOOTSTRAP_PATTERN"].$GLOBALS["ss_uri"]."/";
$dbname          = "config";

if ($action == "delete")
{
  $id  = intval($_GET["id"]);
if (isset($_POST["accept"]))
{
  $sql = "DELETE FROM ".$dbname." WHERE id = " . $id . " LIMIT 1";
  mysql_query($sql);
  
  $result = "<h1 class='x264_im_logo'>Der Konfigurationseintrag (" . $id . ") wurde erfolgreich gel&ouml;scht.</h1>";

print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Konfigurationseintrag " . $id . " l&ouml;schen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<table id='example1' class='table table-bordered table-striped'>
										<tr>
										<td>				
											" . $result . "
										</td>
										<td>
											<a href='" . $_SERVER["PHP_SELF"] . "'>Weiter</a>
										</td>
										</tr>
									</table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";	
}
else
{
print "
<form method='post' action='" . $_SERVER["PHP_SELF"] . "?action=delete&amp;id=".$id."'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Zusammenbruch der Webseitenstruktur wahrscheinlich! Konfigurationseintrag '" . $id . "' mitsamt <b>ALLEN</b> Werten l&ouml;schen?
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<input type='hidden' name='accept' value='1' /><input type='submit' value='Ja!' >
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</form>";
}

}
if ($action == "update")
{
  $id        = intval($_POST["id"]);

  if (trim(strtoupper($_POST["name"])) != "" && $id)
  {
  	$_POST["bereich"] = ($_POST["neubereich"] != "" ? $_POST["neubereich"] : $_POST["bereich"]);
    $sql = "UPDATE ".$dbname." SET name = " . sqlesc(str_replace(" ", "_", trim($_POST["name"]))) . ",  title = " . sqlesc(trim($_POST["title"])) . ",  descr = " . sqlesc(trim($_POST["descr"])) . ", ordernum = ".sqlesc(intval($_POST["ordernum"])).", bereich = ".sqlesc(trim($_POST["bereich"]))." WHERE id = " . $id . " LIMIT 1";
    $err = mysql_query($sql) or sqlerr(__FILE__, __LINE__);

    if ($err) $result = "<h1 class='x264_im_logo'>Der Konfigurationseintrag " . $name . " wurde erfolgreich ge&auml;ndert.</h1>";
    else $result = "<h1 class='x264_im_logo'>Fehler beim Bearbeiten des Konfigurationseintrags  " . $name . "</h1><br>" . $sql;
    
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Konfigurationseintrag " . $id . " l&ouml;schen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
				 <td>
					" . $result . "
				</td>
				 <td>
					<a href='" . $_SERVER["PHP_SELF"] . "'>Weiter</a>
                 </td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
  }
  else
  {
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Konfigurationseintrag " . $id . " l&ouml;schen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
				 <td>
					Es sind nicht alle Angaben vollständig (Interner Name fehlt!)
				 </td>
				<td>
					<a href=\"javascript:history.back()\">Zur&uuml;ck</a>
				</td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";  
  }
}
if ($action == "edit" && is_numeric($_GET["id"]))
{
  $id  = intval($_GET["id"]);
  $sql = "SELECT * FROM ".$dbname." WHERE id = " . $id . " LIMIT 1";
  $res = mysql_query($sql) or sqlerr(__FILE__, __LINE__);
  $arr = mysql_fetch_assoc($res);
  
print "
<form method='post' action='" . $_SERVER["PHP_SELF"] . "'>
                        <div class='col-sm-6'>
                            <div class='card'>
                                <div class='card-header'>
                                    <strong>Konfigurationseintrag <b>" . $arr["title"] . "</b></strong>
                                    <small>bearbeiten</small>
                                </div>
                                <div class='card-block'>
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='name'>Interner Name:</label>
                                                <input type='text' class='form-control' value='" . $arr["name"] . "' onclick='alert('Interne Namen ändern hat empfindlichen Einfluss auf die Stabilität der Webseitenstruktur! Änderung NICHT empfohlen');' name='name' size='50' />
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='ccnumber'>Titel</label>
                                                <input type='text' class='form-control' value='" . $arr["title"] . "' name='title' size='50' />
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='ccnumber'>Beschreibung</label>
                                                <textarea cols='61'  class='form-control' rows='5' name='descr'>" . $arr["descr"] . "</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='ccnumber'>Wichtigkeit (Zahl!)</label>
                                                <input type='text'  class='form-control' name='ordernum' value='".$arr["ordernum"]."' size='5' />
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->";
  
  $ress = mysql_query("SELECT DISTINCT bereich FROM ".$dbname." ORDER BY id ASC");
  $bereiche = "<select name=\"bereich\" >";
  while ($ergs = mysql_fetch_assoc($ress))
  { $bereiche .= "<option value=\"".$ergs["bereich"]."\" ".($ergs["bereich"] == $arr["bereich"] ? "selected=\"selected\"" : "")." >".$ergs["bereich"]."</option>";  }
  $bereiche .= "</select>";
  
print "
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <label for='ccnumber'>Bereich</label>
                                                ".$bereiche." <br />oder neuer Bereich: <input type='text' name='neubereich' class='form-control' size='35' />
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                            <div class='form-group'>
                                                <input type='submit' /><input type='hidden' value='update' name='action' /><input type='hidden'  class='form-control' value='" . $id . "' name='id' />
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->									
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</form>";
}

if ($action == "insert")
{
  $name = str_replace(" ", "_", trim($_POST["name"]));

  if ($name != "")
  {
  	$_POST["bereich"] = ($_POST["neubereich"] != "" ? $_POST["neubereich"] : $_POST["bereich"]);
    $sql = "INSERT INTO ".$dbname." (id, name, title, descr, ordernum, bereich) VALUES (NULL , " . sqlesc($name) . ", " . sqlesc(trim($_POST["title"])) . ", " . sqlesc(trim($_POST["descr"])) . ",".sqlesc(intval($_POST["ordernum"]))."," . sqlesc(trim($_POST["bereich"])) . ")";
    $err = mysql_query($sql) or sqlerr(__FILE__, __LINE__);

    if ($err) $result = "<h1 class='x264_im_logo'>Der Konfigurationseintrag " . trim($_POST["title"]) . " wurde erfolgreich angelegt.</h1>";
    else $result = "<h1 class='x264_im_logo'>Fehler beim Anlegen des Konfigurationseintrags  " . $name . "</h1><br>" . $sql;
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Neuen Eintrag erstellen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<table id='example1' class='table table-bordered table-striped'>
										<tr>
										<td>				
											" . $result . "
										</td>
										<td>
											<a href='" . $_SERVER["PHP_SELF"] . "'>Weiter</a>
										</td>
										</tr>
									</table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
  }
  else
  {
print "
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Neuen Eintrag erstellen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<table id='example1' class='table table-bordered table-striped'>
										<tr>
										<td>				
											Es sind nicht alle Angaben vollständig (Interner Name fehlt!)
										</td>
										<td>
											<a href=\"javascript:history.back()\">Zur&uuml;ck</a>
										</td>
										</tr>
									</table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";
  }
}

if ($action == "new")
{
print "
<form method='post' action='" . $_SERVER["PHP_SELF"] . "'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Neuen Eintrag erstellen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
                  <th>Interner Name:</th>
                  <th>Titel:</th>
                  <th>Beschreibung:</th>
                  <th>Wichtigkeit (Zahl!):</th>
                  <th>Bereich:</th>
                  <th>Speichern:</th>				  
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>
					<input type='text' name='name' size='15' />
                  </td>
                  <td>
					<input type='text'  name='title' size='15' />
                  </td>
                  <td>
					<textarea cols='15' rows='5' name='descr'></textarea>
                  </td>
                  <td>
					<input type='text' name='ordernum' size='5' />
                  </td>";		
  
  $ress = mysql_query("SELECT DISTINCT bereich FROM ".$dbname." ORDER BY id ASC");
  $bereiche = "<select name=\"bereich\" >";
  while ($ergs = mysql_fetch_assoc($ress))
  { $bereiche .= "<option value=\"".$ergs["bereich"]."\">".$ergs["bereich"]."</option>";  }
  $bereiche .= "</select>";

print "		
                  <td>
					".$bereiche." <br />oder neuer Bereich: <input type='text' name='neubereich' size='11' />
                  </td>
                  <td>
					<input type='submit' /><input type='hidden' value='insert' name='action' />
                  </td>
                </tbody>
                <tfoot>
                <tr>
                  <th>Interner Name:</th>
                  <th>Titel:</th>
                  <th>Beschreibung:</th>
                  <th>Wichtigkeit (Zahl!):</th>
                  <th>Bereich:</th>
                  <th>Speichern:</th>
                </tr>
                </tfoot>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>			  
</form>";  
}
if ($action == "view")
{
	 if ($_SERVER["REQUEST_METHOD"] == "POST")
	 {
       $allconf = mysql_query("SELECT name,id FROM ".$dbname."");
       while ($each = mysql_fetch_assoc($allconf))
       {
	 	   mysql_query("UPDATE ".$dbname." SET wert=".sqlesc($_POST[$each["name"]])." WHERE id=".$each["id"]);
       }      
	 }

print "
<form method='post' action='" . $_SERVER["PHP_SELF"] . "'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Tracker Config System
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
              <table id='example1' class='table table-bordered table-striped'>
                <thead>
                <tr>
				 <td>";	 

  $ress = mysql_query("SELECT DISTINCT bereich FROM ".$dbname." ORDER BY bereich ASC");
  while ($ergs = mysql_fetch_assoc($ress))
    {
  $c = 0;
print "
<h3 class='box-title' summary=''>".$ergs["bereich"]."</h1>
	<div class='show_stats_value'>";
print("	
	<div class='x264_title_table'><img id=\"".str_replace(" ", "_", $ergs["bereich"])."img\" src=\"".$GLOBALS["ADMIN_BOOTSTRAP_PATTERN"]."".$GLOBALS["ss_uri"]."/plus.gif\" alt=\"Auf/Zuklappen\" title=\"Auf/Zuklappen\" onclick=\" if (document.getElementById('".str_replace(" ", "_", $ergs["bereich"])."').style.display == 'none'){ document.getElementById('".str_replace(" ", "_", $ergs["bereich"])."'+'img').src = '".$GLOBALS["ADMIN_BOOTSTRAP_PATTERN"]."".$GLOBALS["ss_uri"]."/minus.gif'; document.getElementById('".str_replace(" ", "_", $ergs["bereich"])."').style.display = 'block'; } else { document.getElementById('".str_replace(" ", "_", $ergs["bereich"])."'+'img').src = '".$GLOBALS["ADMIN_BOOTSTRAP_PATTERN"]."".$GLOBALS["ss_uri"]."/plus.gif'; document.getElementById('".str_replace(" ", "_", $ergs["bereich"])."').style.display = 'none'; }\" />   <b>".$ergs["bereich"]."</b></div>\n");
print "	
	<div id='".str_replace(" ", "_", $ergs["bereich"])."' style='display:none;'>
	<div summary='".str_replace(" ", "_", $ergs["bereich"])."' style='width:100%' cellpadding='5' cellspacing='1'>";

       $sql = "SELECT * FROM ".$dbname." WHERE bereich='".$ergs["bereich"]."' ORDER BY ordernum DESC";
       $res = mysql_query($sql);
       while ($configs = mysql_fetch_assoc($res))
       { 
       $edit   = "<a href=\"" . $_SERVER["PHP_SELF"] . "?action=edit&amp;id=" . $configs["id"] . "\" onclick=\" return confirm('Dies bearbeitet die Beschreibung und andere Grundlegende Dinge dieses Konfigurationseintrags, nicht dessen Wert. Trotzdem fortfahren?');\" ><img src=\"".$GLOBALS["ADMIN_BOOTSTRAP_PATTERN"]."".$GLOBALS["ss_uri"]."/edit.png\" alt=\"Bearbeiten\" title=\"Bearbeiten\" style=\"vertical-align: middle;border:none;width:16px;height:16px;\" /></a>";
       $delete = "<a href=\"" . $_SERVER["PHP_SELF"] . "?action=delete&amp;id=" . $configs["id"] . "\" onclick=\" return confirm('Die Löschung von Konfigurationen kann zu Seitenausfällen führen. Möchten sie diese Konfigurationseinstellung trotzdem löschen?');\" ><img src=\"".$GLOBALS["ADMIN_BOOTSTRAP_PATTERN"]."".$GLOBALS["ss_uri"]."/editdelete.png\" alt=\"L&ouml;schen\" title=\"L&ouml;schen\" style=\"vertical-align: middle;border:none;width:16px;height:16px;\" /></a>";
       print"			
			<div class='x264_title_table'>
				<div class='x264_tcon_log'>
					<div class='x264_nologged_inp'>".$configs["title"]."</div>
					<div class='x264_tcon_inc'><input type='text' value='".$configs["wert"]."' name='".$configs["name"]."' size='50' /></div>
					<div class='x264_tcon_inc'>".$configs["name"]."</div>
					<div class='x264_tcon_inc'>".$configs["ordernum"]."</div>
					<div class='x264_tcon_inc'>".$edit.$delete."</div>
				</div>	
			</div>";
       }
print "		
		<div class='x264_nologged_inp'><input type=\"submit\" value=\"Speichern\" /></div>
		<div class='x264_title_table'>  &nbsp;  </div>
	</div>
	</div>
	</div>	"; 
    }
print "		
	</div>
</div>
				</center>
				</td>
				 </tr>
                </tbody>
              </table>
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>		
</form>";
print "
		  
<form method='post' action='" . $_SERVER["PHP_SELF"] . "'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>Tracker Config System - Neuer Eintrag anlegen
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>
									<input type='submit' value='Neu anlegen' />    <input type='hidden' value='new' name='action' />
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>
</form>"; 
}
x264_admin_footer();
?>