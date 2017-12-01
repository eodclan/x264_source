<?php
// ************************************************************************************//
// * D€ Source 2017
// ************************************************************************************//
// * Author: D@rk-€vil™
// ************************************************************************************//
// * Version: 1.7
// * 
// * Copyright (c) 2017 D@rk-€vil™. All rights reserved.
// ************************************************************************************//
// * License Typ: Creative Commons licenses
// ************************************************************************************// 
class RSSFeed
{
  private $XML = NULL;
  private $RSS = array();
  
  private $D_CHAN_SEP   = "channel";
  private $D_RSS_TAGS   = "title,link,description,category,generator,language,lastBuildDate";
  private $D_RSS_DTAGS  = "";
  private $D_ITEM_SEP   = "item";
  private $D_ITEM_TAGS  = "pubDate,guid,title,link,description,image,content:encoded";
  private $D_ITEM_DTAGS = "enclosure|url|length|type";
  
  public $CHAN_SEP      = NULL;
  public $RSS_TAGS      = NULL;
  public $RSS_DTAGS     = NULL;
  public $ITEM_SEP      = NULL;
  public $ITEM_TAGS     = NULL;
  public $ITEM_DTAGS    = NULL;
  
  public function __construct($url)
  {
    $this -> XML = new xmlParser($url);

    $rss = $this -> XML -> getTagItem("rss","version");

    if ($rss <= 1)
    {
      die("Invalid RSS Feed");
    }
  }
  
  public function parseFeed()
  {  
    $RSS_TAGS   = array_unique(array_merge(explode(",",$this -> D_RSS_TAGS),explode(",",$this -> RSS_TAGS)));
    $RSS_DTAGS  = array_unique(array_merge(explode(",",$this -> D_RSS_DTAGS),explode(",",$this -> RSS_DTAGS)));
    $ITEM_TAGS  = array_unique(array_merge(explode(",",$this -> D_ITEM_TAGS),explode(",",$this -> ITEM_TAGS)));
    $ITEM_DTAGS = array_unique(array_merge(explode(",",$this -> D_ITEM_DTAGS),explode(",",$this -> ITEM_DTAGS)));

    $new = array();
    foreach ($RSS_DTAGS as $item)
    {
      $item = explode("|",$item);
      $temp = $item[0];
      unset($item[0]);
      
      $new[$temp] = $item;
    }
    $RSS_DTAGS = $new;

    $new = array();
    foreach ($ITEM_DTAGS as $item)
    {
      $item = explode("|",$item);
      $temp = $item[0];
      unset($item[0]);
      
      $new[$temp] = $item;
    }
    $ITEM_DTAGS = $new;
     
    $CHAN_SEP = (isset($this -> CHAN_SEP)?$this -> CHAN_SEP:$this -> D_CHAN_SEP);
    $ITEM_SEP = (isset($this -> ITEM_SEP)?$this -> ITEM_SEP:$this -> D_ITEM_SEP);
            
    $channelcount = $this -> XML -> openSection($CHAN_SEP);
    
    for ($c = 1; $c <= $channelcount; $c++)
    {
      $this -> RSS[$c] = array();
      
      foreach($RSS_TAGS as $tag)
      {
        $data = $this -> XML -> getTagData($tag);
        
        if ($data)
        {
          $this -> RSS[$c][$tag] = $data;
        }
      }  
      
      foreach($RSS_DTAGS as $tag => $items)
      {
        $arr = array();
        foreach($items as $item)
        {
          $data = $this -> XML -> getTagItem($tag,$item);
          if ($data)
          {
            $arr[$item] = $data;
          }
        }
        $this -> RSS[$c][$tag] = $arr;
      }

      if ($this -> XML -> openSection("image"))
      {
        $url = $this -> XML -> getTagData("url");
        $link = $this -> XML -> getTagData("link");
        $title = $this -> XML -> getTagData("title");
        $this -> XML -> CloseSection();
    
        if ($url && $link && $title)
        {
          $this -> RSS[$c]["image"]["url"] = $url;
          $this -> RSS[$c]["image"]["link"] = $link;
          $this -> RSS[$c]["image"]["title"] = $title;
        }
         $this -> XML -> CloseSection();
      }
          
      $itemcount = $this -> XML -> openSection($ITEM_SEP);
      
      $this -> RSS[$c]['items'] = array();
      
      for ($i = 1; $i <= $itemcount; $i++)
      {
        $this -> RSS[$c]['items'][$i] = array();
      
        foreach($ITEM_TAGS as $tag)
        {
          $data = $this -> XML -> getTagData($tag);
        
          if ($data)
          {
            $this -> RSS[$c]['items'][$i][$tag] = $data;
          }
        }                     
      
        foreach($ITEM_DTAGS as $tag => $items)
        {
          $arr = array();
          foreach($items as $item)
          { 
            $data = $this -> XML -> getTagItem($tag,$item);
            if ($data)
            {
              $arr[$item] = $data;
            }
          }
          $this -> RSS[$c]['items'][$i][$tag] = $arr;
        }
        $this -> XML -> nextSectionItem();
      }
      
      $this -> XML -> CloseSection();
      $this -> XML -> nextSectionItem();
    }
    $this -> XML -> CloseSection();
  }
  
  public function getOutput()
  {
    return $this -> RSS;  
  }

  private function mksize($bytes)
  {
    foreach (array('',' KB',' MB',' GB',' TB',' PB') AS $i => $k) 
    {
      if ($bytes < 1024) 
      {
        break;
      }
      $bytes /= 1024;
    }
    return number_format($bytes, 2, ",", ".") . $k;
  }
  
  public function getHTMLoutput($channel = NULL)
  {
    if ($channel == NULL)
    {
      $RSS = $this -> RSS;
    }
    else
    {
      $RSS = array($this -> RSS[$channel]);
    }
    
    foreach($RSS as $chan)
    {
      print "
    <center>";
      if (isset($chan['title']))
      {
        print "
      <table size='1000px'>
        <tr>
          <td size='100%' style='text-align:center'><font size=5>".$chan['title']."</font></td>".(isset($chan['image'])?"
          <td style='text-align:right'><a href='".$chan['image']['link']."'><img src='".$chan['image']['url']."' title='".$chan['image']['title']."'></td>":"")."
        </tr>
      </table>"; 
      }
      
      if (isset($chan['description']))
      {
        print "
      <table size='1000px'>
        <tr>
          <td size='100%' style='text-align:center'><font size=4>".(isset($chan['link'])?$chan['link']."<br>":"").$chan['description']."</font></td>
        </tr>
      </table>";
      }
      
      if(isset($chan['items']))
      {
        print "
      <table size='1000px'>";
        foreach($chan['items'] as $item)
        {
          print (isset($item['title'])?"
        <tr>
          <td colspan=2><a href='".$item['link']."'>".$item['title']."</a>".(isset($item['pubDate'])?"<br>".$item['pubDate']:"")."</td>
        </tr>":"")."
        <tr>";
        
          if(isset($item['enclosure']) && isset($item['enclosure']['type']) && isset($item['enclosure']['url']) && isset($item['enclosure']['length']))
          {
            if(strpos($item['enclosure']['type'],"image") !== false)
            {
              print "
            <td><img src='".$item['enclosure']['url']."' alt=''></td>";
            }  
            else
            {
              $bits = explode("/", $url);
              $filename = $bits[count($bits) - 1]; 
              $download = "<a href='".$item['enclosure']['url']."'>".$filename."</a> (".$item['enclosure']['type'].") ".$this -> mksize($item['enclosure']['length']);
            }
          }
          
          print "
            <td>".$item['description']."</td>
          </tr>";
        }
        print "
        </table>";
      }
    }
  }
}

class xmlParser
{
  private $ConnectionHandle = NULL;
  private $host             = NULL;
  private $header           = NULL;
  private $XML              = NULL;
  private $DATA             = NULL;
  private $Section          = array();
  private $reason           = NULL;
  private $CurSection       = NULL;
  private $SecCount         = 0;
    
  public function __construct($url)
  {
    if (strpos($url, "http://") !== false)
    {
      $con = explode("/",$url);
    
      $host = explode(":",$con[2]);
      $port = isset($host[1]) && is_numeric($host[1])?$host[1]:80;
      $host = $host[0];
    
      unset($con[0]);
      unset($con[1]);
      unset($con[2]);
    
      $pfad = implode("/",$con);
    
      $this -> openConnection($host,$port) or $this -> error();
      $this -> getXmlData($pfad) or $this -> error();
      $this -> closeConnection() or $this -> error();
    }
    else
    {
      $this -> XML = file_get_contents($url);
      $this -> DATA = $this -> XML;      
    }
  }
  
  private function openConnection($host, $port)
  {
    $this -> ConnectionHandle = @fsockopen($host, $port, $errno, $errstr, 2);
    $this -> host = $host;
    if (!$this -> ConnectionHandle) 
    {
      $this -> reason = "Host Offline";
      return false;
    }
    
    return true;
  }
  
  private function getXmlData($pfad = NULL)
  { 
    $request  = "GET /".$pfad." HTTP/1.0\r\n";
    $request .= "Host: ".$this -> host."\r\n";
    $request .= "Connection: close\r\nUser-Agent: Mozilla/5.0 (compatible;)\r\n\r\n";
    fputs ($this -> ConnectionHandle, $request);

    $retr = "";
    while (!feof($this -> ConnectionHandle)) 
    {
      $retr .= fgets($this -> ConnectionHandle, 128);
    }
    
    $pos = strpos($retr, "\r\n\r\n");
    $this -> header = substr($retr, 0, $pos); 
    $this -> parse_header();
      
    if ($this -> header['HTTP/1.1'] == "200 OK")
    {
      $this -> XML = substr($retr, $pos + 4);
      $this -> DATA = $this -> XML;
      return true;
    }
    else
    {
      $this -> reason = $this -> header['HTTP/1.1'];
      return false;
    }
  }
  
  private function parse_header()
  {
    $header = explode("\r\n", $this -> header);
    
    $status = explode(" ",$header[0]);
    
    $http = $status[0];
    unset($status[0]);
    unset($header[0]);
    
    $this -> header = array();
    $this -> header[$http] = implode(" ",$status);  
    
    foreach($header as $i)
    {
      $i = explode(":",$i);
      $this -> header[trim($i[0])] = trim($i[1]);
    } 
  }
  
  public function getTagData($tag)
  {
    preg_match('/\<'.$tag.'\>(.*?)\<\/'.$tag.'\>/is', $this -> DATA, $match);
    if (isset($match[1]))
    {
      if (strpos($match[1],"<![CDATA[") !== false)
      {
        preg_match('/\<\!\[CDATA\[(.*?)\]\]\>/is', $match[1], $match);
      }
      return $this -> convert($match[1]);
    }
    else
    {
      return false;
    }
  }
  
  public function getTagItem($tag,$item)
  {
    preg_match('/\<'.$tag.'(.*?)\>/is', $this -> DATA, $match);
    if (!isset($match[1]))
    {
      return false;
    }
    
    preg_match('/'.$item.'\=\"(.*?)\"/is', $match[1], $match);
    if (isset($match[1]))
    {
      if (strpos($match[1],"<![CDATA[") !== false)
      {
        preg_match('/\<\!\[CDATA\[(.*?)\]\]\>/is', $match[1], $match);
      }
      return $this -> convert($match[1]);
    }
    else
    {
      return false;
    } 
  }
  
  public function openSection($sectionname)
  {
    preg_match_all('/\<'.$sectionname.'\>(.*?)\<\/'.$sectionname.'\>/is', $this -> DATA, $matches);
        
    if (isset($matches[1][0]))
    {
      $this -> SecCount++;
    
      $this -> Section[$this -> SecCount] = array(0, $sectionname, $matches[1], $this -> CurSection);
      $this -> CurSection = $this -> SecCount;    
      $this -> DATA = $matches[1][0];
      return count($matches[1]);
    }
    else
    {
      return false;
    }
    
    return count($matches[1]);
  }
  
  public function nextSectionItem()
  {
    if (isset($this -> Section[$this -> CurSection][0]))
    {
      $this -> Section[$this -> CurSection][0]++;
      if (isset($this -> Section[$this -> CurSection][2][$this -> Section[$this -> CurSection][0]]))
      {
        $this -> DATA = $this -> Section[$this -> CurSection][2][$this -> Section[$this -> CurSection][0]];
        return true;
      }
    }
    return false;
  }
  
  public function prevSectionItem()
  {
    if (isset($this -> Section[$this -> CurSection][0]))
    {
      $this -> Section[$this -> CurSection][0]--;
      if (isset($this -> Section[$this -> CurSection][2][$this -> Section[$this -> CurSection][0]]))
      {
        $this -> DATA = $this -> Section[$this -> CurSection][2][$this -> Section[$this -> CurSection][0]];
        return true;
      }
    }
    return false;    
  }
  
  public function getSectionItem($item)
  {
    if (isset($this -> Section[$this -> CurSection][0]))
    {
      $this -> Section[$this -> CurSection][0] = $item;
      if (isset($this -> Section[$this -> CurSection][2][$this -> Section[$this -> CurSection][0]]))
      {
        $this -> DATA = $this -> Section[$this -> CurSection][2][$this -> Section[$this -> CurSection][0]];
        return true;
      }
    }
    return false;  
  }
  
  public function closeSection()
  {
    $oldsec = (isset($this -> CurSection)?$this -> CurSection:0);
    if (isset($this -> Section[$oldsec][3]))
    {
      $this -> CurSection = $this -> Section[$oldsec][3];
      unset($this -> Section[$oldsec]);
    
      if ($this -> CurSection == NULL)
      {
        $this -> DATA = $this -> XML;
        $this -> CurSection = 0; 
      }
      else
      {
        $this -> DATA = $this -> Section[$this -> CurSection][2][$this -> Section[$this -> CurSection][0]];
      }
      return true;
    }
    return false;
  }
  
  private function closeConnection()
  { 
    if (fclose($this -> ConnectionHandle))
    {
      return true;
    } 
    else
    {
      $this -> reason = "Connection can not be closed";
      return false;      
    }
  }
  
  private function convert($string)
  {
    return str_replace(array("ö", "ä", "ü", "ß", "Ö",  "Ä", "Ü", "é", "�"),
           array("&ouml;", "&auml;", "&uuml;",  "&szlig;", "&Ouml;", "&Auml;", "&Uuml;","�"), 
           $string);
  }
  
  private function error()
  {
    die("XML File can not be loaded:<br>".$this->reason);
  }
}
?>