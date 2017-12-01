<?php

require(__DIR__ . '/include/bittorrent.php');

dbconn(false);

loggedinorreturn();

$ViewerConfig = array(
    'FontColor'         => array(0,0,0),       # Schriftfarbe ( R,G,B ) ( Nur Bild! )
    'BackColor'         => array(255,255,255), # Hintergrundfarbe ( R,G,B )  ( Nur Bild! )
    'RemoveBack'      => true,                 # Hintergrund der NFO durchsichtig ( true / false ) ( Nur Bild! )
    'WordWrapCnt'     => 45,                  # Maximale Anzahl Zeichen pro Zeile
    'MaxLines'         => 300,                 # Maximale Zeilen
    'downloadPrefix' => '[PC]',         # Prefix des Dateinamens beim Download
    'writeLog'         => true                 # Trackerlog Eintrag beim bearbeiten
);

$TorrentID = isset($_GET['id']) && is_valid_id($_GET['id']) ? intval($_GET['id']) : 0;
$Action    = isset($_GET['action']) ? $_GET['action'] : '';

$getTorrent = mysql_query(
    "SELECT 
        name, nfo, owner
    FROM 
        torrents
    WHERE 
        id = {$TorrentID} 
    LIMIT 1") or sqlerr(__FILE__, __LINE__);
        
$Torrent = mysql_fetch_assoc($getTorrent) or die('Torrent nicht gefunden');
        
if (isset($_POST['nfo']) && ($CURUSER['class'] > UC_MODERATOR || $Torrent['owner'] == $CURUSER['id']))
{
    
    if (trim($_POST['nfo']) == '')
    {
    
        die('NFO darf nicht leer sein!');
    
    }
    
    header('Content-Type: text/html; charset=utf-8');
    
    $NFO = iconv('UTF-8', 'CP866', $_POST['nfo']);
    
    mysql_query(
        "UPDATE 
            torrents 
        SET 
            nfo  = '" . mysql_real_escape_string($NFO) . "' 
        WHERE 
            id = {$TorrentID} 
        LIMIT 1") or sqlerr(__FILE__, __LINE__);
    
    // NFO Bild updaten, kann entfernt werden wenn Bilder nicht genutzt wird!
    gen_nfo_pic($NFO. '/_x264_/nfo/nfo-' . $TorrentID . '.png'); 
    
    if ($ViewerConfig['writeLog'] === true)
    {
    
        write_log('nfo_edited', 'NFO zu "<a href="tfilesinfo.php?id=' . $TorrentID . '">' . htmlspecialchars($Torrent['name']) . '</a>" bearbeitet von <a href="usertfilesinfo.php?id=' . $CURUSER['id'] . '"><span class="' . get_class_color($CURUSER['class']) . '">' . htmlspecialchars($CURUSER['username']) . '</span></a>');
    
    }
    
    header('Location: download_nfo.php?id=' . $TorrentID);
    
}
        
switch ($Action)
{

    // NFO-Bild aus Datenbank generieren
    case 'genNFOPic':
    
        $lines = explode("\n", $Torrent['nfo']);
                
        // Lange Zeilen umbrechen
        for ($I = 0;$I < count($lines); $I++) 
        {

            $lines[$I] = trim($lines[$I]);
            $lines[$I] = wordwrap($lines[$I], $ViewerConfig['WordWrapCnt'], "\n", 1);
        
        }
        
        // Längste Zeile auslesen
        $cols = 0;
        for ($i = 0; $i < count($lines); $i++) 
        {
                
            $lines[$i] = trim($lines[$i]);
            if (strlen($lines[$i]) > $cols)
            {
                
                $cols = strlen($lines[$i]);
            
            }
            
        }
            
        // Maximale Zeilen
        $lines = array_slice($lines, 0, $ViewerConfig['MaxLines']);

        $linecnt = count($lines);
            
        // Font laden
        if (($font = imageloadfont(__DIR__ . '/terminal.gdf')) < 5)
        {
            
            die('Font error!');
                
        }
            
        // Bild erstellen
        $imagewidth = $cols * imagefontwidth($font) + 1;
        $imageheight = $linecnt * imagefontheight($font) + 1;
            
        $nfoimage = imagecreate($imagewidth, $imageheight);        
        
        $BackC = imagecolorallocate($nfoimage, $ViewerConfig['BackColor'][0], $ViewerConfig['BackColor'][1], $ViewerConfig['BackColor'][2]);    
        $FontC = imagecolorallocate($nfoimage, $ViewerConfig['FontColor'][0], $ViewerConfig['FontColor'][1], $ViewerConfig['FontColor'][2]);
        
        if ($ViewerConfig['RemoveBack'] === true)
        {
            
            imagecolortransparent($nfoimage, $BackC);
            
        }
        
        // Text auf Bild schreiben    
        for ($I=0; $I < $linecnt; $I++)
        {
            
            imagestring($nfoimage, $font, 0, $I*imagefontheight($font), $lines[$I], $FontC);
            
        }
            
        // Bild ausgeben
        header("Content-Type: image/png"); 
            
        imagepng($nfoimage);
    
    break;
    
    // Formatierten Text ausgeben
    case 'textView':

        $NFOContent = htmlspecialchars(iconv('CP866', 'UTF-8', $Torrent['nfo']));    
        
        $lines = explode("\n", $NFOContent);
        
        // Lange Zeilen umbrechen
        for ($I = 0; $I < count($lines); $I++) 
        {
        
            if (empty($lines[$I]))
            {
            
                unset($lines[$I]);
            
                continue;
            
            }
        
            $lines[$I] = rtrim($lines[$I]);
        
            $lines[$I] = wordwrap($lines[$I], $ViewerConfig['WordWrapCnt']);
        
        }
        
        // Maximale Zeilen
        $lines = array_slice($lines, 0, $ViewerConfig['MaxLines']);
            
        $NFOContent = implode("\n", $lines);    
                
        // URLs formatieren
        $NFOContent = preg_replace("/(\A|[^=\]'\"a-zA-Z0-9])((http:\/\/|ftp:\/\/|https:\/\/|ftps:\/\/|irc:\/\/|www.)[^()<>\"'\s]+)/i", 
                                    ' <a class="link" target="_blank" href="http://www.anonym.to/?\\2">\\2</a>', $NFOContent);
    
        // Ausgabe
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de">
        <head>
          <title>NFOViewer - TextView zu "' . htmlspecialchars($Torrent['name']) . '"</title>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
          <style type="text/css">
            body { white-space:pre;font-family:monospace,Courier,\'Lucida Console\';font-size:12px;line-height:15px;color:#000; }
            .url { color:red; } 
          </style>
        </head>
        <body>' . $NFOContent . '</body>
        </html>';

    break;    
    
    // Plaintext ausgeben
    case 'plainView' : 
            
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de">
        <head>
          <title>NFOViewer - PlainView zu "' . htmlspecialchars($Torrent['name']) . '"</title>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
          <style type="text/css">
            body { white-space:pre;font-family:monospace,Courier,\'Lucida Console\';font-size:12px;line-height:15px;color:#000; }
            .url { color:red; } 
          </style>
        </head>
        <body>' . htmlspecialchars(utf8_encode($Torrent['nfo'])) . '</body>
        </html>';
    
    break;
    
    // NFO herunterladen
    case 'downloadNFO' :
        
        // Set header
        header('Content-Type: application/nfo');
        // header('Content-Length: ' . strlen($Torrent['nfo']));
        header('Content-Disposition: attachment; filename=' . $ViewerConfig['downloadPrefix'] . htmlspecialchars(stripslashes($Torrent['name'])) . '.nfo'); 
                
        echo $Torrent['nfo'];
    
    break;
    
    // NFO bearbeiten
    case 'editNFO' :
        
        // Bearbeitung nur erlauben wenn >= Mod oder Uploader des Torrents 
        if ($CURUSER['class'] < UC_MODERATOR && $Torrent['owner'] != $CURUSER['id'])
        {
        
            die('Zugriff verweigert');
        
        }
        
        // Ausgabe
        echo 
        '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="de">
        <head>
          <title>NFOViewer - NFO zu "' . htmlspecialchars($Torrent['name']) . '" bearbeiten</title>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
          <style type="text/css">
            textarea { color:#000;border:1px solid #000;white-space:pre;width:100%;height:550px;font-family: monospace;font-size:12px;line-height:15px;overflow:scroll; }
          </style>
        </head>
        <body>
          <form method="post" action="download_nfo.php?id=' . $TorrentID . '">
            <textarea rows="20" cols="20" name="nfo">' . iconv('CP866', 'UTF-8', $Torrent['nfo']) . '</textarea>
            <div style="margin:10px 0;">
              <input type="submit" value="Speichern" />
            </div>
          </form>
        </body>
        </html>';
    
    break;
    
    // Standard NV Ansicht
    default :
    case 'imageView' : 
        
        x264_header();
        
        begin_frame('NFO zu <a href="tfilesinfo.php?id=' . $TorrentID . '">' . htmlspecialchars($Torrent['name']) . '</a>', false, '500px');
        
        begin_table(true);
        
        echo 
        '<tr>
          <td class="tableb" style="text-align:center;">
            <a href="download_nfo.php?id=' . $TorrentID . '&amp;action=downloadNFO">Download NFO</a> | 
            <a href="download_nfo.php?id=' . $TorrentID . '&amp;action=textView">Als Text anzeigen</a> | 
            <a href="download_nfo.php?id=' . $TorrentID . '&amp;action=plainView">Plain anzeigen</a> 
            ' . ($CURUSER['class'] > UC_MODERATOR || $Torrent['owner'] == $CURUSER['id'] ? '| <a href="download_nfo.php?id=' . $TorrentID . '&amp;action=editNFO">NFO bearbeiten</a>' : '') . '
          </td>
        </tr>
        <tr>
          <td class="tablea" style="text-align:center;padding:5px;">
            <img src="download_nfo.php?action=genNFOPic&amp;id=' . $TorrentID . '" alt="Lade NFO">
          </td>
        </tr>';
        
        end_table();
        
        end_frame();
        
        x264_footer();
        
    break;
        
}

?>