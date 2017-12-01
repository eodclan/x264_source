// Shoutbox Funktionen

function add_at(name) 
{
  window.parent.document.shbox.shbox_text.value+='[nick='+name+'] ';
  window.parent.document.shbox.shbox_text.focus();
}

function startshout()
{
  var TeamboxHidden = document.getElementById('teamboxhidden');
  var ajax = new sb_ajax();
  ajax.onShow ('');
  var varsString = "";
  ajax.requestFile = "shoutbox.php";
  ajax.setVar("teambox", TeamboxHidden.value);
  ajax.method = 'POST';
  ajax.element = 'sbox';
  ajax.sendAJAX(varsString);
  window.setTimeout('startshout();', 30000);
}

function sendsbtext()
{
  var TeamboxHidden = document.getElementById('teamboxhidden');
  var SBText = document.getElementById('shbox_text');
  var JamesHidden = document.getElementById('jameshidden');
  var ajax = new sb_ajax();
  ajax.onShow ('');
  var varsString = "";
  ajax.requestFile = "shoutbox.php";
  ajax.setVar("teambox", TeamboxHidden.value);
  ajax.setVar("shbox_text", encodeURIComponent(SBText.value));
  ajax.setVar("jamestext", JamesHidden.value);
  ajax.setVar("sent", "yes");
  ajax.method = 'POST';
  ajax.element = 'sbox';
  ajax.sendAJAX(varsString);
  mySubmit();
}

function mySubmit()
{
  setTimeout('document.shbox.reset()',50);
}

function pchat(id)
{
  myRef  = window.open('/shoutbox.php?action=pc&uid='+id,'pchat'+id,'left=20,top=20,width=500,height=500,toolbar=0,resizable=0,location=0,directories=0');
  myRef.focus();
}

function sbedit(id)
{
  var TeamboxHidden = document.getElementById('teamboxhidden');

  myRef  = window.open('/shoutbox.php?action=edit&id='+id+(TeamboxHidden.value == "yes"?"&teambox=yes":""),'edit'+id,'left=20,top=20,width=500,height=50,toolbar=0,resizable=0,location=0,directories=0');
  myRef.focus();
}

function delpost(id)
{
  var TeamboxHidden = document.getElementById('teamboxhidden');
  var ajax = new sb_ajax();
  ajax.onShow ('');
  var varsString = "";
  ajax.requestFile = "shoutbox.php";
  ajax.setVar("teambox", TeamboxHidden.value);
  ajax.setVar("delid", id);
  ajax.method = 'POST';
  ajax.element = 'sbox';
  ajax.sendAJAX(varsString);
}

function refresh()
{
  var TeamboxHidden = document.getElementById('teamboxhidden');
  
  var ajax = new sb_ajax();
  ajax.onShow ('');
  var varsString = "";
  ajax.requestFile = "shoutbox.php";
  ajax.setVar("teambox", TeamboxHidden.value);
  ajax.method = 'POST';
  ajax.element = 'sbox';
  ajax.sendAJAX(varsString);
}

function radio()
{
  radio  = window.open("doRwunsch('obj')"); 
}

function delsb()
{
  var TeamboxHidden = document.getElementById('teamboxhidden');
  Check = confirm ("Wollen sie wirklich die "+(TeamboxHidden.value == "no"?"Shoutbox":"Teambox")+" leeren?");
  if (Check==true)
  {
    var ajax = new sb_ajax();
    ajax.onShow ('');
    var varsString = "";
    ajax.requestFile = "shoutbox.php";
    ajax.setVar("action", "delshout");
    ajax.setVar("teambox", TeamboxHidden.value);
    ajax.method = 'GET';
    ajax.element = 'sbox';
    ajax.sendAJAX(varsString);
  }
  else
  {
    alert('Abbruch durch Benutzer');
  }
}

function winop()
{
  windop = window.open("smilies.php","mywin","");
}

function showshout()
{
  var SBButton  = document.getElementById('sbbutton');
  var SBSmilies = document.getElementById('sbsmilies');
  var SBForm    = document.getElementById('sbform');
  var SBFrame   = document.getElementById('sbox');
  
  SBButton.disabled       = 'disabled';
  SBButton.value          = "Bitte Warten...";
  SBSmilies.style.display = "inline";
  SBForm.style.display    = "inline";
  SBFrame.style.height    = "400px";
  
  window.setTimeout('startshout();', 2000);
}

function showframe(what, modus)
{
  var ajax = new sb_ajax();
  ajax.onShow ('');
  var varsString = "";
  ajax.requestFile = "sbframe.php";
  ajax.setVar("modus", modus);
  ajax.setVar("what", what);
  ajax.method = 'POST';
  ajax.element = 'sbframe';
  ajax.sendAJAX(varsString);
}

function addSmilie(code, obj)
{
  textarea = document.getElementById(obj); 
  doAddTags(code, '', obj);
  textarea.focus();
}

function afk()
{
  var TeamboxHidden = document.getElementById('teamboxhidden');
  var AfkButton     = document.getElementById('afkbutton');
  var AfkHidden     = document.getElementById('afkhidden');

  if (AfkHidden.value == 'no')
  {
    AfkHidden.value = 'yes';
    AfkButton.value = 'Bin zurьck';
  }
  else
  {
    AfkHidden.value = 'no';
    AfkButton.value = 'Mich AFK setzen';
  }

  var ajax = new sb_ajax();
  ajax.onShow ('');
  var varsString = "";
  ajax.requestFile = "shoutbox.php";
  ajax.setVar("teambox", TeamboxHidden.value);
  ajax.setVar("afk", AfkHidden.value);
  ajax.method = 'POST';
  ajax.element = 'sbox';
  ajax.sendAJAX(varsString);
}

function jamestxt()
{
  var JamesHidden = document.getElementById('jameshidden');
  var JamesButton = document.getElementById('jamesbutton');

  if (JamesHidden.value == 'no')
  {
    JamesButton.value = 'Text als James: ON';
    JamesHidden.value = 'yes';
  }
  else
  {
    JamesButton.value = 'Text als James: OFF';
    JamesHidden.value = 'no';
  }
}

function rwunsch()
{
  var ajax = new sb_ajax();
  ajax.onShow ('');
  var varsString = "";
  ajax.requestFile = "sbwunsch.php";
  ajax.setVar("modus", modus);
  ajax.setVar("radiow", radiow);
  ajax.method = 'POST';
  ajax.element = 'sbframe';
  ajax.sendAJAX(varsString);
}

function showteambox()
{
  var TeamboxHidden = document.getElementById('teamboxhidden');
  var TeamboxButton = document.getElementById('teamboxbutton');
  var SBTruncate    = document.getElementById('sbtruncate');
  var JamesHidden   = document.getElementById('jameshidden');
  var JamesButton   = document.getElementById('jamesbutton');

  if (TeamboxHidden.value == 'no')
  {
    TeamboxButton.value  = 'Shoutbox anzeigen';
    TeamboxHidden.value  = 'yes';
    SBTruncate.value     = 'Lцsche Teambox';
    JamesButton.disabled = 'disabled';
    JamesButton.value    = 'Text als James: OFF';
    JamesHidden.value    = 'no';
  }
  else
  {
    TeamboxButton.value  = 'Teambox anzeigen';
    TeamboxHidden.value  = 'no';
    SBTruncate.value     = 'Lцsche SB';
    JamesButton.disabled = '';
  }
  
  refresh();
}

function sbhistory()
{
  var TeamboxHidden = document.getElementById('teamboxhidden');

  windop = window.open("shoutbox.php?history=1"+(TeamboxHidden.value == "yes"?"&teambox=yes":""),"his","");
}

// Editor Code
var textarea;
var content;

function edToolbar(obj, url, png)
{
  if (png == 'true')
  {
    var end = "png";
  }
  else
  {
    var end = "gif";
  }

  var fontoptions  = new Array("Arial", "Arial Black", "Arial Narrow", "Book Antiqua", "Century Gothic", "Comic Sans MS",
                               "Courier New", "Fixedsys", "Franklin Gothic Medium", "Garamond", "Georgia", "Impact",
                               "Lucida Console", "Lucida Sans Unicode", "Microsoft Sans Serif", "Palatino Linotype",
                               "System", "Tahoma", "Times New Roman", "Trebuchet MS", "Verdana");
  var sizeoptions  = new Array(1, 2, 3, 4, 5, 6, 7);
  var coloroptions = new Array("#000000", "#8A4117", "#667C26", "#254117", "#2B3856", "#000080", "#4B0082",
                               "#2F4F4F", "#8B0000", "#FF8C00", "#808000", "#008000", "#008080", "#0000FF",
                               "#708090", "#696969", "#FF0000", "#F4A460", "#9ACD32", "#48D1CC", "#4169E1",
                               "#800080", "#808080", "#FF00FF", "#FFA500", "#FFFF00", "#00FF00", "#00FFFF",
                               "#00BFFF", "#9932CC", "#C0C0C0", "#FFC0CB", "#F5DEB3", "#FFFACD", "#98FB98",
                               "#AFEEEE", "#ADD8E6", "#DDA0DD", "#FFFFFF");

  document.write("<div class=\"desource_warp_shoutbox_bbcode\">\n" +
                 "  <div style=\"float: left;\">\n" +
                 "    <img class=\"button\" src=\"" + url + "/removeformat." + end + "\" name=\"btnBold\" title=\"Formatierung entfernen\" onClick=\"doRemoveTags('" + obj + "')\" \/>\n" +
                 "    <img src=\"" + url + "/separator.gif\" \/>\n" +
                 "  </div>\n" +

                 "  <div style=\"float: left;\">\n" +
                 "    <div style=\"padding:2px; float:left;\">Schriftart</div>\n" +
                 "    <div style=\"float:left;\"><img class=\"button\" src=\"" + url + "/menupop." + end + "\" id=\"popFont\" onClick=\"showpopup('font','popFont')\" \/></div>\n" +
                 "    <div style=\"padding:2px; float:left;\">Gr&ouml;&szlig;e</div>\n" +
                 "    <div style=\"float:left;\"><img class=\"button\" src=\"" + url + "/menupop." + end + "\" id=\"popSize\" onClick=\"showpopup('size','popSize')\" \/></div>\n" +
                 "    <img src=\"" + url + "/separator.gif\" \/>\n" +
                 "  </div>\n" +

                 "  <div style=\"float: left;\">\n" +
                 "    <img class=\"button\" src=\"" + url + "/bold." + end + "\" name=\"btnBold\" title=\"Fett\" onClick=\"doAddTags('[b]','[/b]','" + obj + "')\" \/>\n" +
                 "    <img class=\"button\" src=\"" + url + "/italic." + end + "\" name=\"btnItalic\" title=\"Kursiv\" onClick=\"doAddTags('[i]','[/i]','" + obj + "')\" \/>\n" +
                 "    <img class=\"button\" src=\"" + url + "/underline." + end + "\" name=\"btnUnderline\" title=\"Unterstrichen\" onClick=\"doAddTags('[u]','[/u]','" + obj + "')\" \/>\n" +
                 "    <img class=\"button\" src=\"" + url + "/pre." + end + "\" name=\"btnPre\" title=\"Blockschrift\" onClick=\"doAddTags('[pre]','[/pre]','" + obj + "')\" \/>\n" +
                 "    <img src=\"" + url + "/separator.gif\" \/>\n" +
                 "  </div>\n" +

                 "  <div style=\"float: left;\">\n" +
                 "    <div style=\"float:left;\"><img class=\"button\" src=\"" + url + "/color." + end + "\" id=\"popColor\" title=\"Textfarbe\" onClick=\"showpopup('color','popColor')\" \/></div>\n" +
                 "    <div style=\"float:left;\"><img class=\"button\" src=\"" + url + "/menupop." + end + "\" id=\"popFont\" onClick=\"showpopup('color','popColor')\" \/></div>\n" +
                 "    <img src=\"" + url + "/separator.gif\" \/>\n" +
                 "  </div>\n" +

                 "  <div style=\"float: left;\">\n" +
                 "    <img class=\"button\" src=\"" + url + "/link." + end + "\" name=\"btnLink\" title=\"URL Link\" onClick=\"doURL('" + obj + "')\" \/>\n" +
                 "    <img class=\"button\" src=\"" + url + "/tvdb." + end + "\" name=\"btnLink\" title=\"TVDB Text\" onClick=\"doTVDB('" + obj + "')\" \/>\n" +
                 "    <img class=\"button\" src=\"" + url + "/radiowunsch." + end + "\" name=\"btnLink\" title=\"Radio Wunsch\" onClick=\"doRwunsch('" + obj + "')\" \/>\n" +				 
                 "    <img class=\"button\" src=\"" + url + "/unlink." + end + "\" name=\"btnunLink\" title=\"Links entfernen\" onClick=\"doRemoveURL('" + obj + "')\" \/>\n" +
                 "    <img class=\"button\" src=\"" + url + "/image." + end + "\" name=\"btnPicture\" title=\"Bild\" onClick=\"doImage('" + obj + "')\" />\n" +
                 "    <img src=\"" + url + "/separator.gif\" \/>\n" +
                 "    <img class=\"button\" src=\"" + url + "/quote." + end + "\" name=\"btnQuote\" title=\"Zitat\" onClick=\"doAddTags('[quote]','[/quote]','" + obj + "')\" \/>\n" +
                 "    <img src=\"" + url + "/separator.gif\" \/>\n" +
                 "    <a href=\"javascript:showframe('smilies','open');\"><img class=\"button\" src=\"" + url + "/smilie." + end + "\" name=\"btnSmilie\" onmouseover=\"return overlib('Hier sind unsere Smilies.');\" onmouseout=\"return nd();\" \/></a>\n" +
                 "  </div>\n" +
                 "</div>\n" +
                 "<br style=\"clear: left;\" />\n");

  document.write("<div id=\"font\" style=\"display: none; z-index: 100; border: 1px solid black; overflow: auto; width: 120px; height: 120px;\">\n");
  for (var i = 0; i < fontoptions.length; i++)
  {
    document.write("  <div class=\"button\" style=\"font-family:'" + fontoptions[i] + "'; color: #000000;\" onClick=\"doSetFont('" + fontoptions[i] + "','" + obj + "')\">" + fontoptions[i] + "</div>\n");
  }
  document.write("</div>\n");

  document.write("<div id=\"size\" style=\"display: none; z-index: 100; border: 1px solid black; text-align: center;\">\n");

  for (var i = 0; i < sizeoptions.length; i++)
  {
    document.write("  <font class=\"button\" size=\"" + sizeoptions[i] + "\" color=\"#000000\" onClick=\"doSetSize('" + sizeoptions[i] + "','" + obj + "')\">" + sizeoptions[i] + "</font><br \/>\n");
  }
  document.write("</div>\n");

  document.write("<div id=\"color\" style=\"display: none; z-index: 100; border: 1px solid black; text-align: center;\">\n");
  for (var i = 0; i < coloroptions.length; i++)
  {
    if ( (i % 8 == 0) && (i != 0) )
    {
      document.write("  <br style=\"clear: left;\" />\n");
    }

    document.write("  <div class=\"button\" style=\"background-color: " + coloroptions[i] + "; width: 15px; height: 15px; float: left;\" onClick=\"doSetColor('" + coloroptions[i] + "','" + obj + "')\"></div>\n");
  }
  document.write("</div>\n");
}

function edSmilye(obj, url, anz)
{
  anz = parseInt(anz);
  document.write("<div class=\"smiliebar\" id=\"smiliebar\" style=\"float: left;\">\n");

  for (var i = 0; i < smilieliste.length; i++)
  {
    var einzel = smilieliste[i];
    var code   = einzel.code;
    var bild   = einzel.bild;

    if ( (i % anz == 0) && (i != 0) )
    {
      document.write("  <br style=\"clear: left;\" />\n");
    }

    document.write("  <div style=\"float:left; text-align:center;  width:30px; height:30px;\"><img class=\"button\" src=\"" + url +  "/" + bild + "\" name=\"\" title=\"" + code + "\" onClick=\"doAddTags('"  + code + "','','" + obj + "')\" \/></div>\n");
  }
  document.write("</div>\n");
}

function doViewSmilie(div)
{
  var box = document.getElementById(div);

  if (box.style.display == "none")
  {
    box.style.display = "inline";
  }
  else
  {
    box.style.display = "none";
  }
}

function doRemoveTags(obj)
{
  textarea = document.getElementById(obj);
  var txt = textarea.value;
  var simpel_strip  = new Array('b', 'i', 'u', 'center', 'pre', 'quote');
  var complex_strip = new Array('font', 'color', 'size');
  var tag;

  // Einfache Tags entfernen \\
  for (tag in simpel_strip)
  {
    var opentag    = '['  + simpel_strip[tag] + ']';
    var closetag   = '[/' + simpel_strip[tag] + ']';
    var stopindex  = 0;
    var startindex = 0;

    if (typeof iterations == 'undefined')
    {
      var iterations = -1;
    }

    while ((startindex = stripos(txt, opentag)) !== false && iterations != 0)
    {
      iterations --;
      if ((stopindex = stripos(txt, closetag)) !== false)
      {
        var text = txt.substr(startindex + opentag.length, stopindex - startindex - opentag.length);
        txt = txt.substr(0, startindex) + text + txt.substr(stopindex + closetag.length);
      }
      else
      {
        break;
      }
    }
  }

  // komplexe Tags mit Parametern entfernen \\
  for (tag in complex_strip)
  {
    var opentag    = '['  + complex_strip[tag] + '=';
    var closetag   = '[/' + complex_strip[tag] + ']';
    var stopindex  = 0;
    var startindex = 0;

    if (typeof iterations == 'undefined')
    {
      var iterations = -1;
    }

    while ((startindex = stripos(txt, opentag)) !== false && iterations != 0)
    {
      iterations --;
      if ((stopindex = stripos(txt, closetag)) !== false)
      {
        var openend = stripos(txt, ']', startindex);
        if (openend !== false && openend > startindex && openend < stopindex)
        {
          var text = txt.substr(openend + 1, stopindex - openend - 1);
          txt = txt.substr(0, startindex) + text + txt.substr(stopindex + closetag.length);
        }
        else
        {
          break;
        }
      }
      else
      {
        break;
      }
    }
  }

  // Bereinigten Code zurьckgeben \\
  textarea.value = txt;
}

function doRemoveURL(obj)
{
  textarea = document.getElementById(obj);

  var txt        = textarea.value;
  var opentag    = '[url=';
  var closetag   = '[/url]';
  var stopindex  = 0;
  var startindex = 0;

  if (typeof iterations == 'undefined')
  {
    var iterations = -1;
  }

  while ((startindex = stripos(txt, opentag)) !== false && iterations != 0)
  {
    iterations --;
    if ((stopindex = stripos(txt, closetag)) !== false)
    {
      var openend = stripos(txt, ']', startindex);
      if (openend !== false && openend > startindex && openend < stopindex)
      {
        var text = txt.substr(openend + 1, stopindex - openend - 1);
        txt = txt.substr(0, startindex) + text + txt.substr(stopindex + closetag.length);
      }
      else
      {
        break;
      }
    }
    else
    {
      break;
    }
  }

  var opentag    = '[url]';
  var closetag   = '[/url]';
  var stopindex  = 0;
  var startindex = 0;

  if (typeof iterations == 'undefined')
  {
    var iterations = -1;
  }

  while ((startindex = stripos(txt, opentag)) !== false && iterations != 0)
  {
    iterations --;
    if ((stopindex = stripos(txt, closetag)) !== false)
    {
      var text = txt.substr(startindex + opentag.length, stopindex - startindex - opentag.length);
      txt = txt.substr(0, startindex) + text + txt.substr(stopindex + closetag.length);
    }
    else
    {
      break;
    }
  }

  textarea.value = txt;
}

function doImage(obj)
{
  textarea = document.getElementById(obj);
  var url = prompt('Bitte Bild-URL angeben:','http://');
  var scrollTop = textarea.scrollTop;
  var scrollLeft = textarea.scrollLeft;

  if (url != '' && url != null)
  {
    if (document.selection)
    {
      textarea.focus();
      var sel = document.selection.createRange();
      sel.text = '[img]' + url + '[/img]';
    }
    else
    {
      var len = textarea.value.length;
      var start = textarea.selectionStart;
      var end = textarea.selectionEnd;
      var sel = textarea.value.substring(start, end);
      var rep = '[img]' + url + '[/img]';

      textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
      textarea.scrollTop = scrollTop;
      textarea.scrollLeft = scrollLeft;
    }
  }
}

function doTVDB(obj)
{
  textarea = document.getElementById(obj);
  var url = prompt('Bitte TVDB Titel angeben:','Stargate ect.');
  var scrollTop = textarea.scrollTop;
  var scrollLeft = textarea.scrollLeft;

  if (url != '' && url != null)
  {
    if (document.selection)
    {
      textarea.focus();
      var sel = document.selection.createRange();
      sel.text = '[tvdb=' + url + ']';
    }
    else
    {
      var len = textarea.value.length;
      var start = textarea.selectionStart;
      var end = textarea.selectionEnd;
      var sel = textarea.value.substring(start, end);
      var rep = '[tvdb=' + url + ']';

      textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
      textarea.scrollTop = scrollTop;
      textarea.scrollLeft = scrollLeft;
    }
  }
}

function doRwunsch(obj)
{
  textarea = document.getElementById(obj);
  var text = prompt('Gebe nun dein Radio Wunsch ein:','Interpret - Titel');
  var scrollTop = textarea.scrollTop;
  var scrollLeft = textarea.scrollLeft;

  if (text != '' && text != null)
  {
    if (document.selection)
    {
      textarea.focus();
      var sel = document.selection.createRange();
      sel.text = '[radiowunsch=' + text + ']';
    }
    else
    {
      var len = textarea.value.length;
      var start = textarea.selectionStart;
      var end = textarea.selectionEnd;
      var sel = textarea.value.substring(start, end);
      var rep = '[radiowunsch=' + text + ']';

      textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
      textarea.scrollTop = scrollTop;
      textarea.scrollLeft = scrollLeft;
    }
  }
}

function doURL(obj)
{
  textarea = document.getElementById(obj);
  var url = prompt('Bitte eine URL angeben:','http://');
  var scrollTop = textarea.scrollTop;
  var scrollLeft = textarea.scrollLeft;

  if (url != '' && url != null)
  {
    if (document.selection)
    {
      textarea.focus();
      var sel = document.selection.createRange();

      if(sel.text=="")
      {
        sel.text = '[url]'  + url + '[/url]';
      }
      else
      {
        sel.text = '[url=' + url + ']' + sel.text + '[/url]';
      }
    }
    else
    {
      var len = textarea.value.length;
      var start = textarea.selectionStart;
      var end = textarea.selectionEnd;
      var sel = textarea.value.substring(start, end);

      if(sel=="")
      {
        var rep = '[url]' + url + '[/url]';
      }
      else
      {
        var rep = '[url=' + url + ']' + sel + '[/url]';
      }

      textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
      textarea.scrollTop = scrollTop;
      textarea.scrollLeft = scrollLeft;
    }
  }
}

function doAddTags(tag1,tag2,obj)
{
  textarea = document.getElementById(obj);

  if (document.selection)
  {
    // Code for IE
    textarea.focus();
    var sel = document.selection.createRange();
    sel.text = tag1 + sel.text + tag2;
  }
  else
  {
    // Code for Mozilla Firefox
    var len = textarea.value.length;
    var start = textarea.selectionStart;
    var end = textarea.selectionEnd;
    var scrollTop = textarea.scrollTop;
    var scrollLeft = textarea.scrollLeft;
    var sel = textarea.value.substring(start, end);
    var rep = tag1 + sel + tag2;

    textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
    textarea.scrollTop = scrollTop;
    textarea.scrollLeft = scrollLeft;
  }
}

function doSetSize(size,obj)
{
  textarea = document.getElementById(obj);
  size     = parseInt(size);

  if (document.selection)
  {
    // Code for IE
    textarea.focus();
    var sel = document.selection.createRange();
    sel.text = "[size=" + size + "]" + sel.text + "[/size]";
  }
  else
  {
    // Code for Mozilla Firefox
    var len = textarea.value.length;
    var start = textarea.selectionStart;
    var end = textarea.selectionEnd;
    var scrollTop = textarea.scrollTop;
    var scrollLeft = textarea.scrollLeft;
    var sel = textarea.value.substring(start, end);
    var rep = "[size=" + size + "]" + sel + "[/size]";

    textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
    textarea.scrollTop = scrollTop;
    textarea.scrollLeft = scrollLeft;
  }

  document.getElementById("size").style.display = "none";
}

function doSetFont(font,obj)
{
  textarea = document.getElementById(obj);

  if (document.selection)
  {
    // Code for IE
    textarea.focus();
    var sel = document.selection.createRange();
    sel.text = "[font=" + font + "]" + sel.text + "[/font]";
  }
  else
  {
    // Code for Mozilla Firefox
    var len = textarea.value.length;
    var start = textarea.selectionStart;
    var end = textarea.selectionEnd;
    var scrollTop = textarea.scrollTop;
    var scrollLeft = textarea.scrollLeft;
    var sel = textarea.value.substring(start, end);
    var rep = "[font=" + font + "]" + sel + "[/font]";

    textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
    textarea.scrollTop = scrollTop;
    textarea.scrollLeft = scrollLeft;
  }

  document.getElementById("font").style.display = "none";
}

function doSetColor(color,obj)
{
  textarea = document.getElementById(obj);

  if (document.selection)
  {
    // Code for IE
    textarea.focus();
    var sel = document.selection.createRange();
    sel.text = "[color=" + color + "]" + sel.text + "[/color]";
  }
  else
  {
    // Code for Mozilla Firefox
    var len = textarea.value.length;
    var start = textarea.selectionStart;
    var end = textarea.selectionEnd;
    var scrollTop = textarea.scrollTop;
    var scrollLeft = textarea.scrollLeft;
    var sel = textarea.value.substring(start, end);
    var rep = "[color=" + color + "]" + sel + "[/color]";

    textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
    textarea.scrollTop = scrollTop;
    textarea.scrollLeft = scrollLeft;
  }

  document.getElementById("color").style.display = "none";
}

function doList(tag1,tag2,obj)
{
  textarea = document.getElementById(obj);

  if (document.selection)
  {
    // Code for IE
    textarea.focus();
    var sel = document.selection.createRange();
    var list = sel.text.split('\n');

    for(var i = 0; i < list.length; i++)
    {
      list[i] = '[*]' + list[i];
    }
    sel.text = tag1 + '\n' + list.join("\n") + '\n' + tag2;
  }
  else
  {
    // Code for Firefox
    var len = textarea.value.length;
    var start = textarea.selectionStart;
    var end = textarea.selectionEnd;
    var scrollTop = textarea.scrollTop;
    var scrollLeft = textarea.scrollLeft;
    var sel = textarea.value.substring(start, end);
    var list = sel.split('\n');

    for(var i = 0; i < list.length; i++)
    {
      list[i] = '[*]' + list[i];
    }

    var rep = tag1 + '\n' + list.join("\n") + '\n' +tag2;

    textarea.value =  textarea.value.substring(0,start) + rep + textarea.value.substring(end,len);
    textarea.scrollTop = scrollTop;
    textarea.scrollLeft = scrollLeft;
  }
}

function stripos ( f_haystack, f_needle, f_offset )
{
  var haystack = (f_haystack + '').toLowerCase();
  var needle   = (f_needle   + '').toLowerCase();
  var index    = 0;

  if ((index = haystack.indexOf(needle, f_offset)) !== -1)
  {
    return index;
  }
  return false;
}

function showpopup(div, wer)
{
  var menu   = document.getElementById(div);
  var sender = document.getElementById(wer);

  if (menu.style.display == "none")
  {
    var pos  = getPosition(sender);

    if (wer == "popFont")
    {
      menu.style.left = (pos.x - 58) + "px";
    }
    else if (wer == "popColor")
    {
      menu.style.left = pos.x + "px";
    }
    else
    {
      menu.style.left = (pos.x - 40) + "px";
    }

    menu.style.top             = (pos.y + 17) + "px";
    menu.style.backgroundColor = "#FFFFFF";
    menu.style.padding         = "3px";
    menu.style.position        = "absolute";
    menu.style.display         = "inline";
  }
  else
  {
    menu.style.display = "none";
  }
}

function getPosition(was)
{
  var div     = was;
  var tagname = "";
  var x       = 0;
  var y       = 0;

  while ((typeof(div) == "object") && (typeof(div.tagName) != "undefined"))
  {
    var tagname = div.tagName.toUpperCase();
    y += div.offsetTop;
    x += div.offsetLeft;

    if (tagname == "BODY")
    {
      div = 0;
    }

    if (typeof(div) == "object")
    {
      if (typeof(div.offsetParent) == "object")
      {
        div = div.offsetParent;
      }
    }

  }

  var position = new Object();
  position.x = x;
  position.y = y;

  return position;
}

//Ajax Engine

function sb_ajax(file)
{
  this.AjaxFailedAlert = "Ваш браузер не поддерживает расширенные возможности управления сайтом, мы настоятельно рекомендуем сменить браузер.\n";
  this.requestFile = file;
  this.method = "POST";
  this.URLString = "";
  this.encodeURIString = true;
  this.execute = false;
  this.loading_fired        = 0;
  this.centerdiv          = null;
  this.onLoading = function() { };
  this.onLoaded = function() { };
  this.onInteractive = function() { };
  this.onCompletion = function() { };
  this.onShow = function( message )
  {
    if ( ! this.loading_fired )
    {
      this.loading_fired = 1;
      // Change text?
      if ( message )
      {
        document.getElementById( 'sb_loading-layer-text' ).innerHTML = message;
      }
        this.centerdiv         = new center_div();
        this.centerdiv.divname = 'sb-loading-layer';
        this.centerdiv.move_div();
    }
    return;
  };

  this.onHide = function()
  {
    try
    {
      if ( this.centerdiv && this.centerdiv.divobj )
      {
        this.centerdiv.clear_div();
      }
    }
    catch(e)
    {
    }
    this.loading_fired = 0;
    return;
  };
  this.createAJAX = function()
  {
    try
    {
      this.xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e)
    {
      try
      {
        this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch (err)
      {
        this.xmlhttp = null;
      }
    }
    if(!this.xmlhttp && typeof XMLHttpRequest != "undefined")
    this.xmlhttp = new XMLHttpRequest();
    if (!this.xmlhttp)
    {
      this.failed = true;
    }
  };
  this.setVar = function(name, value)
  {
    if (this.URLString.length < 3)
    {
      this.URLString = name + "=" + value;
    }
    else
    {
      this.URLString += "&" + name + "=" + value;
    }
  }
  this.encVar = function(name, value)
  {
    var varString = encodeURIComponent(name) + "=" + encodeURIComponent(value);
    return varString;
  }
  this.encodeURLString = function(string)
  {
    varArray = string.split('&');
    for (i = 0; i < varArray.length; i++)
    {
      urlVars = varArray[i].split('=');
      if (urlVars[0].indexOf('amp;') != -1)
      {
        urlVars[0] = urlVars[0].substring(4);
      }
      varArray[i] = this.encVar(urlVars[0],urlVars[1]);
    }
    return varArray.join('&');
  }
  this.encodeVAR = function(url)
  {
    url = url.toString();
    var regcheck = url.match(/[\x90-\xFF]/g);
    if ( regcheck )
    {
      for (var i = 0; i < i.length; i++)
      {
        url = url.replace(regcheck[i], '%u00' + (regcheck[i].charCodeAt(0) & 0xFF).toString(16).toUpperCase());
      }
    }
    return escape(url).replace(/\+/g, "%2B");
  }
  this.runResponse = function()
  {
    eval(this.response);
  }
  this.sendAJAX = function(urlstring)
  {
    this.responseStatus = new Array(2);
    if(this.failed && this.AjaxFailedAlert)
    {
      alert(this.AjaxFailedAlert);
    }
    else
    {
      if (urlstring)
      {
        if (this.URLString.length)
        {
          this.URLString = this.URLString + "&" + urlstring;
        }
        else
        {
          this.URLString = urlstring;
        }
      }
      if (this.encodeURIString)
      {
        var timeval = new Date().getTime();
        this.URLString = this.encodeURLString(this.URLString);
        //this.setVar("rndval", timeval);
      }
      if (this.element)
      {
        this.elementObj = document.getElementById(this.element);
      }
      if (this.xmlhttp)
      {
        var self = this;
        if (this.method == "GET")
        {
          var totalurlstring = this.requestFile + "?" + this.URLString;
          this.xmlhttp.open(this.method, totalurlstring, true);
        }
        else
        {
          this.xmlhttp.open(this.method, this.requestFile, true);
        }
        if (this.method == "POST")
        {
          try
          {
            this.xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded')
          }
          catch (e)
          {
          }
        }
        this.xmlhttp.send(this.URLString);
        this.xmlhttp.onreadystatechange = function()
        {
          switch (self.xmlhttp.readyState)
          {
            case 1:
              self.onLoading();
              break;
            case 2:
              self.onLoaded();
              break;
            case 3:
              self.onInteractive();
              break;
            case 4:
              self.response = self.xmlhttp.responseText;
              self.responseXML = self.xmlhttp.responseXML;
              self.responseStatus[0] = self.xmlhttp.status;
              self.responseStatus[1] = self.xmlhttp.statusText;
              self.onCompletion();
              if(self.execute)
              {
                self.runResponse();
              }
              if (self.elementObj)
              {
                var elemNodeName = self.elementObj.nodeName;
                elemNodeName.toLowerCase();
                self.onHide();
                if (elemNodeName == "input" || elemNodeName == "select" || elemNodeName == "option" || elemNodeName == "textarea")
                {
                  if (self.response == 'error')
                  {
                    alert('Доступ отклонен');
                  }
                  else
                  {
                    self.elementObj.value = self.response;
                  }
                }
                else
                {
                  if (self.response == 'error')
                  {
                    alert('Доступ отклонен');
                  }
                  else
                  {
                     self.elementObj.innerHTML = self.response;
                  }
                }
              }
              self.URLString = "";
              break;
          }
        };
      }
    }
  };
  this.createAJAX();
}