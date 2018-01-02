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
DEFINE("DB_SERVER", $mysql_host);
DEFINE("DB_USER", $mysql_user);
DEFINE("DB_PASSWORT", $mysql_pass);
DEFINE("DB", $mysql_db);

class MySQL
{
   /**
     * gobale MySQL-Definition.
     *
     * @access public
     * @var    string
     */
	protected $mysql;

   /**
     * Erweiterung, um verschiedene Datenbanken anzusprechen.
     *
     * @access public
     * @var    string
     */
	protected $ext;

   /**
     * Server der MySQL-Datenbank.
     *
     * @access public
     * @var    string
     */
	protected $mysqlHost;

   /**
     * User-Name der MySQL-Datenbank.
     *
     * @access public
     * @var    string
     */
	protected $mysqlUser;

   /**
     * Passwort der MySQL-Datenbank.
     *
     * @access public
     * @var    string
     */
	protected $mysqlPassword;

   /**
     * Name der MySQL-Datenbank.
     *
     * @access public
     * @var    string
     */
	protected $mysqlDatabase;

   /**
     * MySQL-Verbindung.
     *
     * @access public
     * @var    resource
     */
	protected $connectionHandle;

   /**
     * Zähler für die SQL-Abfragen.
     *
     * @access public
     * @var    integer
     */
    protected $sqlcounter = 0;

   /**
     * Anzahl der Zeilen innerhalb der Abfrage.
     *
     * @access public
     * @var    integer
     */
    protected $rowcount = 0;

   /**
     * Zeitpsanne der SQL-Abfragen.
     *
     * @access public
     * @var    integer
     */
    protected $dbtime = 0;

   /**
     * Gesamtzeit aller SQL-Abfragen.
     *
     * @access public
     * @var    float
     */
    protected $starttime;


   /**
     * MySQL-Klasse für PHP4 erstellen
     *
     * @access    public
     */
    function MySQL($database = "")
    {
         return $this -> __construct($database = "");
    }

   /**
     * MySQL-Klasse erstellen
     *
     * @access    public
     * @param     string    Auswahl einer anderen DB möglich
     * @return    boolean
     */
    function __construct($database = "")
    {
        global $BASEURL;

        if (trim($database) != "") $ext = "_" . strtolower(trim($database));
        else $ext = "";

        if ($ext == "")
        {
            $this -> mysqlHost     = DB_SERVER;
            $this -> mysqlUser     = DB_USER;
            $this -> mysqlPassword = DB_PASSWORT;
            $this -> mysqlDatabase = DB;
        }
        else
        {
            $host = "db_server"   . $ext;
            $user = "db_user"     . $ext;
            $pwd  = "db_password" . $ext;
            $dbs  = "db"          . $ext;

            global $$host, $$user, $$pwd, $$dbs;

            $this -> mysqlHost     = $$host;
            $this -> mysqlUser     = $$user;
            $this -> mysqlPassword = $$pwd;
            $this -> mysqlDatabase = $$dbs;
        }

        $this -> connectionHandle = @mysql_connect($this -> mysqlHost, $this -> mysqlUser, $this -> mysqlPassword, TRUE);

        if (!$this -> connectionHandle)
        {
print "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
 <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='de'>
  <head>
    <title>Datenbankfehler :: Verbindungs-Fehler</title>
    <meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />
    <link rel='stylesheet' type='text/css' href='/design/ex1080_default/ex1080.php' />
    <base href='" . $BASEURL . "' />
  </head>
  <body>
<div class='x264_wrapper_content_out_mount' style='max-width:600px;'>
<h1 class='x264_im_logo'>Keine Verbindung zur Datenbank m&ouml;glich</h1>
	<div class='x264_title_content'>
		<div class='x264_title_table'>" . mysql_errno() . "</div>
		<div class='x264_title_table'>" . mysql_error() . "</div>
		<div class='x264_title_table'>" . $$host . "</div>
		<div class='x264_title_table'>" . $$user . "</div>
		<div class='x264_title_table'>" . $$pwd . "</div>
		<div class='x264_title_table'>" . $$dbs . "</div>		
	</div>
</div>
</div>
  </body>
</html>";

            $this -> mysql = FALSE;
            die();
        }

        if(!@mysql_select_db($this -> mysqlDatabase, $this -> connectionHandle))
        {
print "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
 <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='de'>
  <head>
    <title>Datenbankfehler :: Verbindungs-Fehler</title>
    <meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />
    <link rel='stylesheet' type='text/css' href='/design/ex1080_default/ex1080.php' />
    <base href='" . $BASEURL . "' />
  </head>
  <body>
<div class='x264_wrapper_content_out_mount' style='max-width:600px;'>
<h1 class='x264_im_logo'>Keine Verbindung zur Datenbank m&ouml;glich</h1>
	<div class='x264_title_content'>
		<div class='x264_title_table'>" . mysql_errno() . "</div>
		<div class='x264_title_table'>" . mysql_error() . "</div>		
	</div>
</div>
</div>
  </body>
</html>";

            $this -> mysql = FALSE;
            die();
        }

        $this -> starttime = $this -> microtime_float();

//        register_shutdown_function(array($this, "__destruct"));
    }


   /**
     * MySQL-Klasse und MySQL-Verbindung löschen
     *
     * @access    public
     */
    function __destruct()
    {
        global $BASEURL;

        if ($this -> connectionHandle)
        {
            $this -> resetStatistics();

            if (!@mysql_close($this -> connectionHandle))
            {
print "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
 <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='de'>
  <head>
    <title>Datenbankfehler :: Verbindungs-Fehler</title>
    <meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />
    <link rel='stylesheet' type='text/css' href='/design/ex1080_default/ex1080.php' />
    <base href='" . $BASEURL . "' />
  </head>
  <body>
<div class='x264_wrapper_content_out_mount' style='max-width:600px;'>
<h1 class='x264_im_logo'>Keine Verbindung zur Datenbank m&ouml;glich</h1>
	<div class='x264_title_content'>
		<div class='x264_title_table'>" . mysql_error() . "</div>		
	</div>
</div>
</div>
  </body>
</html>";
                die();
            }
        }
    }


   /**
     * Klassenzeitmessung
     *
     * @access    private
     * @return    float
     */
    private function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return (floatval($usec) + floatval($sec));
    }


   /**
     * normale MySQL-Abfrage ausführen
     *
     * @access    public
     * @param     string
     *  $sql        string   SQL-Abfrage
     *  $escape     boolean  Legt fest, ob die Abfrage per Escape gefiltert wird
     * @return    resource oder bei Fehlern -1
     */
    function query($sql)
    {
        global $BASEURL;

        $time  = $this -> microtime_float();

        $query = $sql;
        //$query = mysql_real_escape_string($sql);
        //$query = str_replace("\\'", "'", $query);

        if ($result = @mysql_query($query, $this -> connectionHandle))
        {
            $this -> dbtime += $this -> microtime_float() - $time;
            $this -> sqlcounter++;
            $this -> rowcount++;
            return $result;

            mysql_free_result($result);
        }
        else
        {
print "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
 <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='de'>
  <head>
    <title>Abfragefehler</title>
    <meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />
    <link rel='stylesheet' type='text/css' href='/design/ex1080_default/ex1080.php' />
    <base href='" . $BASEURL . "' />
  </head>
  <body>
<div class='x264_wrapper_content_out_mount'>
<h1 class='x264_im_logo'>Abfragefehler</h1>
	<div class='x264_title_content' style='max-width:600px;'>
		<div class='x264_title_table'>" . mysql_errno() . "</div>
		<div class='x264_title_table'>" . mysql_error() . "</div>
		<div class='x264_title_table'>" . $sql . "</div>		
	</div>
</div>
</div>
  </body>
</html>";
            //return -1;
            die();
        }
    }


   /**
     * einzelne SELECT-MySQL-Abfrage ausführen und Array zurückliefern
     *
     * @access    public
     * @param     string
     *  $sql        string   SQL-Abfrage
     * @return    array oder bei Fehlern boolean
     */
    function queryObjectArray($sql)
    {
        if ($result = $this -> query($sql))
        {
            if (mysql_num_rows($result))
            {
                while ($row = mysql_fetch_array($result))
                {
                    $result_array[] = $row;
                }

                $this -> rowcount += sizeof($result_array);

                return $result_array;
            }
            else
            {
                return FALSE;
            }
        }
    }


   /**
     * einzelne SELECT-MySQL-Abfrage ausführen
     *
     * @access    public
     * @param     string
     *  $sql        string   SQL-Abfrage
     * @return    array oder bei Fehlern -1
     */
    function querySingleItem($sql)
    {
        if ($result = $this -> query($sql))
        {
            if(mysql_num_rows($result))
            {
                $row = mysql_fetch_array($result);

                return $row[0];
            }
            else
            {
                return -1;
            }
        }
    }


   /**
     * einzelnen SELECT-MySQL-Datensatz abrufen
     *
     * @access    public
     * @param     string
     *  $sql        string   SQL-Abfrage
     * @return    array oder bei Fehlern boolean
     */
    function querySingleArray($sql)
    {
        if ($result = $this -> query($sql))
        {
            if(mysql_num_rows($result))
            {
                $row = mysql_fetch_array($result);

                return $row;
            }
            else
            {
                return false;
            }
        }
    }


   /**
     * einzelnes MySQL-Komando ausführen
     * INSERT, DELETE, etc.
     *
     * @access    public
     * @param     string
     *  $sql        string   SQL-Abfrage
     * @return    boolean
     */
    function execute($sql)
    {
        if ($this -> query($sql))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


   /**
     * Anzeige der ID des zuletzt eingefügten Datensatzes
     *
     * @access    public
     * @param     string
     * @return    integer    bei Fehlern -1
     */
    function insertID()
    {
        return mysql_insert_id($this -> connectionHandle);
//        return $this -> connectionHandle;
    }


   /**
     * Anzeige der Anzahl aller Datensätze in einer Tabelle
     *
     * @access    public
     * @param     string
     *  $table      string   Name der Tabelle
     * @return    integer    bei Fehlern -1
     */
    function tableCount($table = "", $cond = "")
    {
        if (trim($table) != "")
        {
            $sql = "SELECT COUNT(*) FROM " . $table . (($cond != "") ? " " . trim($cond) : "");
            $res = $this -> query($sql);
            $row = mysql_fetch_array($res);

            return $row[0];
        }
        else
        {
            return -1;
        }
    }


   /**
     * liefert die größte ID innerhalb der Tabelle
     *
     * @access    public
     * @param     string
     *  $field      string   Name des Abfragefeldes
     *  $table      string   Name des Tabelle
     * @return    integer    bei Fehlern -1
     */
    function maxID($field = "id", $table = "")
    {
        if ((trim($field) != "") &&  (trim($table) != ""))
        {
            $sql = "SELECT MAX(" . $field . ") FROM " . $table;
            $res = $this -> query($sql);
            $row = mysql_fetch_array($res);

            return $row[0];
        }
        else
        {
            return -1;
        }
    }


   /**
     * liefert die kleinste ID innerhalb der Tabelle
     *
     * @access    public
     * @param     string
     *  $field      string   Name des Abfragefeldes
     *  $table      string   Name des Tabelle
     * @return    integer    bei Fehlern -1
     */
    function minID($field = "id", $table = "")
    {
        if ((trim($field) != "") &&  (trim($table) != ""))
        {
            $sql = "SELECT MIN(" . $field . ") FROM " . $table;
            $res = $this -> query($sql);
            $row = mysql_fetch_array($res);

            return $row[0];
        }
        else
        {
            return -1;
        }
    }


   /**
     * SQL-Injection-Geschütztes einfügen einer Tabellenzeile
     *
     * @access    public
     * @param     string
     *  $array      array    Datenarray mit den Einfügedaten
     *  $table      string   Name der Tabelle
     * @return    boolean
     */
    function insertRow($array = "", $table = "")
    {
        $CheckKey = array_keys($array);
        if((count($array) > 0) && (is_string($CheckKey[0]) == TRUE) && (trim($table) != ""))
        {
            $sql = "INSERT INTO " . $table . " (" . implode(", ", array_keys($array)) . ") VALUES(";
            foreach($array as $value)
            {
                $sql .= is_string($value) ? "'" . mysql_real_escape_string($value) . "', " : floatval($value) . ", ";
            }
            $sql = substr_replace($sql, "", -2) . ")";

            $this -> query($sql);

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


   /**
     * SQL-Injection-Geschütztes updaten einer Tabellenzeile
     *
     * @access    public
     * @param     string
     *  $array      array    Datenarray mit den Einfügedaten
     *  $table      string   Name der Tabelle
     *  $condition  string   Zusätzliche Parameter zum udaten
     * @return    boolean    bei Fehlern -1
     */
    function updateRow($array = "", $table = "", $condition = NULL)
    {
        $CheckKey = array_keys($array);
        if((count($array) > 0) && (is_string($CheckKey[0]) == TRUE) && (trim($table) != ""))
        {
            $sql = "UPDATE " . trim($table) . " SET ";
            foreach($array as $key => $value)
            {
                $sql .= $key . " = ";
                $sql .= is_string($value) ? "'" . mysql_real_escape_string($value) . "', " : floatval($value) . ", ";
            }
            $sql = substr_replace($sql, "", -2);

            if(!is_null($condition))
            {
                $sql .= " WHERE " . $condition . " LIMIT 1";
            }

            $this -> query($sql);

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


   /**
     * Anzeige der Laufzeitinformationen
     *
     * @access    public
     * @return    string
     */
    function showStatistics()
    {
        $totalTime = $this -> microtime_float() - $this -> starttime;

        echo $this -> rowcount . " Zeile(n) / " . $this -> sqlcounter . " Abfrage(n) - " .
             round($totalTime, 4) . " Sekunden (" . round(($totalTime - $this -> dbtime), 4) .
             " Sekunden PHP / " . round($this -> dbtime, 4) . " Sekunden SQL)";
    }


   /**
     * Rücksetzen der Laufzeitinformationen
     *
     * @access    public
     */
    function resetStatistics()
    {
        $this -> sqlcounter = 0;
        $this -> rowcount   = 0;
        $this -> dbtime     = 0;
        $this -> starttime  = $this -> microtime_float();
    }

}
function x264_mariadb_ds($query) {
	$erg=mysql_query($query);
	$r=mysql_fetch_array($erg);
	return($r);
}

function x264_mariadb_df($query) {
	$erg=mysql_query($query);
	$r=mysql_fetch_row($erg);
	return($r[0]);
}

function mysql_ein_datensatz($query) {
	$erg=mysql_query($query);
	$r=mysql_fetch_array($erg);
	return($r);
}

function mysql_ein_datenfeld($query) {
	$erg=mysql_query($query);
	$r=mysql_fetch_row($erg);
	return($r[0]);
}


error_reporting(0);
?>