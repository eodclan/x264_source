<?php
class UserAgent 
{
  var $agent_id = 0;
  var $agent_name = "";

  function UserAgent( $agent_name )
  {
    if (strlen($agent_name) > 2) 
    {
      $agent_name = stripslashes($agent_name);
      preg_match("/^([^;]*).*$/", $agent_name, $m);
      $this->agent_name = $m[1];

      if ($agent = $this->getAgent()) 
      {
        $this->updateHits();

        if ($agent["aktiv"] == 0) 
        {
          err("Du benutzt einen gebannten Clienten. Bitte lies die FAQ!");
        }
      }
      else $this->insert();
    }
    else err("Was soll das den? n00b :D");
  }

  function getAgent()
  {
    $ret = false;

    $sql = "SELECT * FROM agents WHERE agent_name = '".addslashes($this->agent_name)."'";
    $qry = mysql_query($sql);
    $a = mysql_fetch_assoc($qry);

    if ($a["agent_id"] > 0) 
    {
      $this->agent_id = $a["agent_id"];
      $ret = $a;
    }

    return $ret;
  }

  function updateHits()
  {
    $sql = "UPDATE agents SET hits=hits+1 WHERE agent_id = '".$this->agent_id."'";
    mysql_query($sql);
  }

  function insert()
  {
    if (strlen($this->agent_name) > 2) 
    {
      $sql = "INSERT INTO agents VALUES ('', '".$this->agent_name."', 1, ".time().", 1)";
      mysql_query($sql);

      if (isset($_GET["passkey"])) 
      {
        $sql = "SELECT users.username, downloadtickets.userid FROM users,downloadtickets WHERE user.id = downloadtickets.userid AND hash = ".sqlesc($_GET['passkey']);
        $res = mysql_query($sql);
        $ret = mysql_fetch_assoc($res);
        $from = (isset($ret['username'])?$ret['username']:"Unbekannt");
      }
      else 
      {
        $from = "ohne Passkey";
      }
      
      $betreff = "Neuer Torrent-Client \"".$this->agent_name."\" !";
      $msg =  "Name    : " . $this->agent_name . "\n";
      if ($this->agent_name != $_SERVER["HTTP_USER_AGENT"]) 
      {
        $msg .= "Header  : " . $_SERVER["HTTP_USER_AGENT"] . "\n";
      }
      $msg .= "User : " . $from . "\n";
      $msg .= "IP      : " . $_SERVER['REMOTE_ADDR'] . "\n\n";
      $msg .= "Bitte gehe zur Client-Verwaltung um die Einstellungen zu überprüfen\n";
      $msg .= "Clients : [url=cp_agents.php]Cliens verwalten[/url]";

      if ($GLOBALS["SHORTNAME"] == "X264") 
      {
        $uid = 18815; 
      }
      else 
      {
        $uid = 18816;
      }
      sendPersonalMessage(0, $uid, $betreff, $msg, PM_FOLDERID_INBOX, 0);
    }
  }

  function getAll($order="first")
  {
    $ret = false;

    switch($order)
    {
      case "name":
        $order_by = "agent_name";
        break;
      case "hits":
        $order_by = "hits DESC";
        break;
      case "aktiv":
        $order_by = "aktiv";
        break;
      default:
        $order_by = "ins_date DESC";
    } 

    $sql = "SELECT * FROM agents ORDER BY $order_by";
    $qry = mysql_query($sql);
    while($a = mysql_fetch_assoc($qry))
    {
      $ret[] = $a;
    }

    return $ret;
  }

  function setAktiv($agent_id, $aktiv)
  {
    $agent_id = intval($agent_id);
    $aktiv = intval($aktiv);

    if ($agent_id) 
    {
      $sql = "UPDATE agents SET aktiv=$aktiv WHERE agent_id=$agent_id";
      mysql_query($sql);
    }
  }
}
?>