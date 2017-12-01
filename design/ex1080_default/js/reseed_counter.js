var end = "";

function toSt2(n)
{
  var s = '';
  if (n < 10) s += '0';

  return (s + n).toString();
}

function countdown(id)
{
  var d     = new Date();
  var count = Math.floor(end.getTime() - d.getTime());
  var torr  = id;

  if(count > 0)
  {
    var div = document.getElementById('counter');

    count = Math.floor(count/1000);
    var seconds = toSt2(count%60);

    count = Math.floor(count/60);
    var minutes = toSt2(count%60);

    count = Math.floor(count/60);
    var hours = toSt2(count%24);

    count = Math.floor(count/24);
    var days = count;

    var s = "";

    if (days > 0) s = days + ' Tage ';

    div.innerHTML = s + hours + ':' + minutes + ':' + seconds;

    setTimeout('countdown("' + torr + '")', 1000);
  }
  else
  {
    if (count < 0)
    {
      var div = document.getElementById('reseed');

      div.innerHTML = '\n<a href="javascript:send_reseed(' + torr + ');" class="button" style="width: 250px;">Dr&uuml;cke hier, f&uuml;r eine Anfrage.</a>\n' +
                      'div id="loading-layer" style="display:none; font-family: Verdana; font-size: 11px; width:200px; height:50px; background:#FFFFFF; padding:10px; text-align:center; border:1px solid #000000;">\n' +
                      '  <div style="font-weight:bold;" id="loading-layer-text">Senden. Bitte warten ...</div><br />\n' +
                      '</div>\n';
    }
  }
}