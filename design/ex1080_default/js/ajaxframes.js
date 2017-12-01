var tt2ajax_frames = 
{
  ajaxframes : new Array(),
  
  init_ajaxframe : function (id,autor,url,info)
  {
    this.ajaxframes[id] = new Array();
    this.ajaxframes[id]['id'] = id;
    this.ajaxframes[id]['autor'] = autor;
    this.ajaxframes[id]['url'] = url;
    this.ajaxframes[id]['countdown'] = autor;
    this.ajaxframes[id]['info'] = info;
    this.docount(id);
    this.getframeval(url,'tt2ajax_f_'+id);
  },
  
  resetcount : function(id)
  {
    this.ajaxframes[id]['countdown'] = this.ajaxframes[id]['autor'];
  },

  docount : function(id)
  {
    if (this.ajaxframes[id]['countdown'] > 0)
    { 
      this.ajaxframes[id]['countdown']--;
    }
    else
    {
      this.getframeval(this.ajaxframes[id]['url'],'tt2ajax_f_'+id);
      this.ajaxframes[id]['countdown'] = this.ajaxframes[id]['autor'];
    }
    
    if(this.ajaxframes[id]['info'] === true)
    {
      var m = Math.floor(this.ajaxframes[id]['countdown']/60);    
      var s = this.ajaxframes[id]['countdown']%60; 
      if(s < 10) s = '0'+s;
      document.getElementById('tt2ajax_fc_'+id).innerHTML = '<b>'+m+':'+s+'</b>'; 
    }
    setTimeout(function(){ tt2ajax_frames.docount(id); },1000);
  },

  machRequest : function ()
  {
  	try
  	{
  		return new ActiveXObject('Msxml2.XMLHTTP');
  	}
  	catch(e) {}
  
  	try
  	{
  		return new ActiveXObject('Microsoft.XMLHTTP');
  	}
  	catch(e) {}
  
  	try
  	{
  		return new XMLHttpRequest();
  	}
  	catch(e) {}
  
  	alert('XMLHttpRequest wird von Deinem Browser nicht unterstützt.');
  
  	return false;
  },

  empfangen : function (request,div)
  {
  	if (request.readyState != 4)
  		return;
  
  	var daten = request.responseText;
  	document.getElementById(div).innerHTML = daten;
  },

  getframeval : function (url,div)
  {
    var bustcache = (url.indexOf("?")!=-1)? "&bustcache="+new Date().getTime() : "?bustcache="+new Date().getTime();
  	var request = this.machRequest();
  	request.onreadystatechange = function() { tt2ajax_frames.empfangen(request,div); }
  	request.open('GET', url+bustcache, true);
  	request.send(null);
  }
}