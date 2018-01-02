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
check_access(UC_ADMINISTRATOR);
security_tactics();

$action = ($_POST["a"] == "filter" ? "suche" : "view");


function vergleich($str1 = "", $str2 = "")
{
    $a = trim($str1);
    $b = trim($str2);

    if ($a == "" || $b == "") return -1;

    $dist = levenshtein($a, $b);

    $str1len = strlen($a);
    $str2len = strlen($b);

    if($str1len > $str2len)
    {
        $pct = ( ($str1len - $dist) / $str1len ) *100;
    }
    else
    {
        $pct = ( ($str2len - $dist) / $str2len ) *100;
    }

    return intval($pct);
}

function getFadedColor($pPercentage)
{
    $pCol = "#FF0000";

    $pPercentage = 100 - $pPercentage;
    $rgbValues = array_map( 'hexDec', str_split( ltrim($pCol, '#'), 2 ) );
        
    for ($i = 0, $len = count($rgbValues); $i < $len; $i++)
    {
        $rgbValues[$i] = decHex( floor($rgbValues[$i] + (255 - $rgbValues[$i]) * ($pPercentage / 100) ) );
    }
    
    return '#' . implode('', $rgbValues);
}



x264_admin_header("Doppel-Benutzer-Suche");
?>
<script type="text/javascript">

function expandCollapse(Id)
{
    var plusMinusImg = document.getElementById("plusminus" + Id);
    var detailRow    = document.getElementById("details" + Id);


    if (detailRow.style.display == "none")
    {
        plusMinusImg.src        = "<?=$BASEURL . "/" . $GLOBALS["PIC_BASE_URL"]?>minus.gif";
        detailRow.style.display = "block";
    }
    else
    {
        plusMinusImg.src        = "<?=$BASEURL . "/" . $GLOBALS["PIC_BASE_URL"]?>plus.gif";
        detailRow.style.display = "none";
    }
}

</script>

<?php
if ($action == "view")
{
print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>User Foundation System
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	
    print("<form action=\"\" method=\"post\">\n" .
          "  <input type=\"hidden\" name=\"a\" value=\"filter\" />\n" .
          "    <legend> Suchparameter </legend>\n" .
          "    <div style=\"color: #FF0000; font-weight: bold; margin: 10px 0px 10px 0px;\">\n" .
          "      !!ACHTUNG -- Die Suche dauert je nach Datenmenge einige Zeit und verbraucht entsprechend Performance!!\n" .
          "    </div>\n" .
          "    <label for=\"such_nach\">Suchen nach: \n" .
          "      <input type=\"radio\" name=\"such_nach\" value=\"yes\" checked=\"checked\" />eMail\n" .
          "      <input type=\"radio\" name=\"such_nach\" value=\"no\" />Username\n" .
          "    </label>\n" .
          "    <label for=\"such_diff\">Genauigkeit: \n" .
          "      <select name=\"such_diff\">\n" .
          "        <option value=\"0\">-- Bitte ausw&auml;hlen --</option>\n");

          for ($i = 50; $i <= 100; $i += 5)
              print("        <option value=\"" . $i . "\">" . $i . "%</option>\n");

    print("      </select>\n" .
          "    </label>\n" .
          "    <input type=\"submit\" value=\"Suche starten\" />\n" .
          "</form><br />");
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";		  
}
elseif ($action == "suche")
{
    $sql   = "SELECT id, username, class, email, uploaded, downloaded, added FROM users ORDER BY id ASC";
    $data1 = $db -> queryObjectArray($sql);

    $data2    = $data1;                       // Kopie anlegen; dann beim bearbeiten gefundene daraus löschen
    $doppelte = array();                      // Daten der Doppelten Mail-Addy's
    $diff     = intval($_POST["such_diff"]);  // Mit welcher Genauigkeit soll geprüft werden
    $check    = 0;                            // Vergleich initialisieren

    $wie = ($_POST["such_nach"] == "yes" ? TRUE : FALSE);

    if ($diff >= 50)
    {

        foreach ($data1 AS $key1 => $val1)
        {
            if ($wie) $such1 = substr($val1["email"], 0, strpos($val1["email"], "@"));
            else      $such1 = $val1["username"];

            $neu   = array();
            $neu[] = $data1[$key1];

            foreach($data2 AS $key2 => $val2)
            {
                if ($data1[$key1]["id"] != $data2[$key2]["id"])  // nicht mit sich selbst vergleichen
                {
                    if ($wie) $such2 = substr($val2["email"], 0, strpos($val2["email"], "@"));
                    else      $such2 = $val2["username"];

                    $check = vergleich($such1, $such2);

                    if ($check >= $diff)
                    {
                        $data2[$key2]["proz"] = $check;  // Warscheinlichkeit einfügen

                        $neu["double"][] = $data2[$key2];

                        unset($data2[$key2]);            // aus Kopie löschen, um Dopplungen zu mindern
                    }
                    $check = 0;
                }
            }

            if (count($neu) >= 2)
            {
                $doppelte[] = $neu;

                unset($neu);
            }
        }
    }
print"
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                    <i class='fa fa-edit'></i>User Foundation System Info
                                    <div class='card-actions'>
                                        <a href='#' class='btn-close'><i class='icon-close'></i></a>
                                    </div>
                                </div>
                                <div class='card-block'>";	
    print("<div style=\"margin-bottom: 20px;\">\n" .
          "  <u>" . count($doppelte) . " Treffer</u> bei der Suche nach " . ($wie ? "eMail" : "Usernamen") . " mit <b>" . $diff . "%</b> Genauigkeit<br />\n" .
          "  <br /><a href=\"" . $BASEURL . $_SERVER["PHP_SELF"] . "\">neue Suche starten</a>\n" .
          "</div>\n" .
          "<div style=\"margin-left: 100px; text-align: left;\">\n" .
          "  <div class=\"tabletitle\" style=\"float:left; height:22px; padding:5px 0px 0px 10px; width: 200px; border: 1px solid #000000;\">Username</div>\n" .
          "  <div class=\"tabletitle\" style=\"float:left; height:22px; padding:5px 0px 0px 10px; width: 250px; border: 1px solid #000000;\">eMail-Addy</div>\n" .
          "  <div class=\"tabletitle\" style=\"float:left; height:22px; padding:5px 0px 0px 10px; width: 150px; border: 1px solid #000000;\">UL / DL</div>\n" .
          "  <div class=\"tabletitle\" style=\"float:left; height:22px; padding:5px 0px 0px 10px; width: 150px; border: 1px solid #000000;\">Registriert</div>\n" .
          "</div>\n");

   foreach($doppelte AS $key => $val)
   {
       $anzahl = count($val["double"]);

       $link = "<a href=\"javascript:expandCollapse('" . $val[0]["id"] . "');\"><img id=\"plusminus" . $val[0]["id"] . "\" src=\"" . $BASEURL . "/" . $GLOBALS["PIC_BASE_URL"] . "/plus.gif\" alt=\"\" border=\"0\" /></a>";

       print("<div style=\"margin-left: 100px; text-align: left;\">\n" .
             "  <div class=\"tablea\" style=\"float:left; height:22px; padding:5px 0px 0px 10px; width: 200px; border: 1px solid #000000;\">" . $link . " " . $val[0]["username"] . " (" . $anzahl . ")</div>\n" .
             "  <div class=\"tablea\" style=\"float:left; height:22px; padding:5px 0px 0px 10px; width: 250px; border: 1px solid #000000;\">" . $val[0]["email"] . "</div>\n" .
             "  <div class=\"tablea\" style=\"float:left; height:22px; padding:5px 0px 0px 10px; width: 150px; border: 1px solid #000000;\">" . mksize($val[0]["uploaded"]) . "/" . mksize($val[0]["downloaded"]) . "</div>\n" .
             "  <div class=\"tablea\" style=\"float:left; height:22px; padding:5px 0px 0px 10px; width: 150px; border: 1px solid #000000;\">" . $val[0]["added"] . "</div>\n" .
             "  <div style=\"width: 100%; display: none; height: " . (count($val["double"]) * 22) . "px;\" id=\"details" . $val[0]["id"] . "\">\n");

       foreach($val["double"] AS $num => $usr)
       {
             $farbe = getFadedColor($usr["proz"]);
             $farbe = str_pad($farbe, 7, "0", STR_PAD_RIGHT);

             print("    <div class=\"tablea\" style=\"float:left; height:22px; padding:5px 0px 0px 10px; width: 200px; border: 1px solid #000000; background-color: " . $farbe . ";\">" . $usr["username"] . "<span style=\"float: right;\">" . $usr["proz"] . "%</span></div>\n" .
                   "    <div class=\"tablea\" style=\"float:left; height:22px; padding:5px 0px 0px 10px; width: 250px; border: 1px solid #000000; background-color: " . $farbe . ";\">" . $usr["email"] . "</div>\n" .
                   "    <div class=\"tablea\" style=\"float:left; height:22px; padding:5px 0px 0px 10px; width: 150px; border: 1px solid #000000; background-color: " . $farbe . ";\">" . mksize($usr["uploaded"]) . "/" . mksize($usr["downloaded"]) . "</div>\n" .
                   "    <div class=\"tablea\" style=\"float:left; height:22px; padding:5px 0px 0px 10px; width: 150px; border: 1px solid #000000; background-color: " . $farbe . ";\">" . $usr["added"] . "</div>\n");
       }

       print("  </div>\n" .
             "</div>\n" .
             "<br style=\"clear: both;\" />\n");
   }
print"
                                </div>
                            </div>
                        </div>
                        <!--/col-->
                    </div>";   
}

x264_admin_footer();
?>