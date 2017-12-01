var tt2coolajax =
{
    loadWindow    : true,
    response      : null,
    onErrorReturn : false,
    
    getEL: function(selector)
    {
        if (selector.nodeType) {
             return selector;
        }
        else if (typeof selector == 'string') {
            if (document.getElementById) {
                 selector = document.getElementById(selector);
            }
            else if (document.all) {
                selector = document.all[selector];
            }
            else if (document.layers) {
                selector = document.layers[selector];
            }
            
            return selector;
        } else {
            return false;
        }
    },
     
    removeLoader : function()
    {
        var el = this.getEL('tt2coolajaxloader');
        el.parentNode.removeChild(el);
    },
    
    showLoader : function()
    {
        if (this.loadWindow === true) {
            var el = document.createElement('div');
            el.id = 'tt2coolajaxloader';
            el.style.position = 'absolute';
            el.style.border = 'solid 1px #000000';
            el.style.color = '#000000';
            el.style.backgroundColor = '#ffffff';
            el.style.width = '200px'
            el.style.top = '50%';
            el.style.left = '50%';
            el.style.marginLeft = '-100px'; 
            el.style.zIndex = '9999999999'; 
            document.body.appendChild(el);
          }
    },
    
    setLoadMsg : function(msg)
    {
        if (this.loadWindow === true) {
            var el = this.getEL('tt2coolajaxloader');
            el.innerHTML = '<b style="color:#000000;">'+msg+'</b>';
        }
    },
    
    ajaxRequest : function()
    {
          try {
                return new ActiveXObject('Msxml2.XMLHTTP');
          }    catch(e) {}
          try    {
                return new ActiveXObject('Microsoft.XMLHTTP');
          }    catch(e) {}
          try    {
                return new XMLHttpRequest();
          }    catch(e) {}
      
          alert('XMLHttpRequest wird von Deinem Browser nicht unterst&uuml;tzt.');
      
          return false;
    },
  
    getajax : function(request, div, callback)
    {
        if (this.loadWindow === true) {
            this.showLoader();
        }
            
        switch (request.readyState) 
        {
            case 0:
                this.setLoadMsg('<center><img src="pic/loading.gif" alt="" border="0"><br>Daten werden gesendet</center>');
            break;
            
            case 1:
                this.setLoadMsg('<center><img src="pic/loading.gif" alt="" border="0"><br>Daten werden geladen</center>');
            break;
            
            case 2:
            case 3:
                this.setLoadMsg('<center><img src="pic/loading.gif" alt="" border="0"><br>Daten geladen</center>');
            break;
            
            case 4:
                var r,s;
   
                if (request.status == 200) {
                
                    this.response = request.responseText;
                    r = request.responseText;
                    s = 'complete'; 
                    
                    var el = this.getEL(div);
                    
                    if (el === false) {
                        alert('Element nicht gefunden');
                        s = 'error';
                        if (this.onErrorReturn === true) {
                            return false;
                        }
                    }
                    
                    el.innerHTML = r;
                }   
                else {
                    if (request.status == 404) {
                        s = 404;
                    } 
                    else {
                        s = 'error';
                    }
                    if (this.onErrorReturn === true) return false;
                } 
            
                if (callback && callback instanceof Function) {
                    callback(r, s);
                } 
                if (this.loadWindow === true) {
                    this.removeLoader();
                }
        
            break;
            
            default:
                return;
            break;
        }    
    },
    
    senddata : function(url, method, str, div, callback)
    {
        if (!callback) {
            callback = false;
        }
       
        var bustcache = (url.indexOf("?")!=-1)? "&bustcache="+new Date().getTime() : "?bustcache="+new Date().getTime();
            var request = this.ajaxRequest();
  
            if (str === false) {
                var str = null;
        }

        request.onreadystatechange = function() { tt2coolajax.getajax(request, div, callback); };
                
        if (method == 'POST') {
            request.open('POST', url+bustcache,true);
            request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            request.send(str);
        } 
        else {
            request.open('GET', url+bustcache, true);
            request.send(null);
        }
    }
}


var MassMail = 
{
    in_array : function (array, find)
    {
        for (var i = 0; i < array.length; ++i) {
            if (find == array[i]) { return true; }
        }
        return false;
    },

    addclass : function(checkBox, Class)
    {
        var tempClasses = [];
        var curClasses  = [];
        
        if (document.massMailForm.to.value.length > 0) {
            curClasses = document.massMailForm.to.value.split(',');
        }
        
        if(!this.in_array(curClasses, Class)) {
            curClasses[curClasses.length] = Class;
            document.massMailForm.to.value = curClasses.join(',');
            checkBox.checked = 'checked';
        } 
        else {
            for (var j = 0; j < curClasses.length; ++j) 
            {
                if (curClasses[j] != Class && curClasses[j] != '') {
                    tempClasses[tempClasses.length] = curClasses[j];
                }
            }
            if (tempClasses.length > 0) {
                document.massMailForm.to.value = tempClasses.join(',');
            }
            else {
                document.massMailForm.to.value = '';
            }
            checkBox.checked = '';
        }
    },

    beginSend : function()
    {
        if (document.massMailForm.to.value.length == 0) {
            alert('Bitte Userklasse wählen');
            return false;
        }
        if (document.massMailForm.betreff.value.length == 0) {
            alert('Bitte Betreff eingeben');
            return false;
        }
        if (document.massMailForm.text.value.length == 0) {
            alert('Bitte Nachricht eingeben');
            return false;
        }
        
        var POSTDATA = 'to=' + encodeURIComponent(document.massMailForm.to.value) 
                        + '&mailsend=mailsend&step=1&text=' + encodeURIComponent(document.massMailForm.text.value) 
                        + '&betreff=' + encodeURIComponent(document.massMailForm.betreff.value);
        
        tt2coolajax.getEL('massMail_info').style.display = 'block';
        tt2coolajax.getEL('massMail_form').style.display = 'none';
        
        tt2coolajax.senddata('massMail_.php', 'POST', POSTDATA, 'massMail_info', function(response, status)
        {
            if (response == 1 || status != 'complete') {
                alert('Es ist ein Fehler ausgetreten');
                return false;
            }
            
            MassMail.callback(response);
        });   
    },
    
    nextStep : function(count, mailsSended, receivers)
    {
        var POSTDATA = 'to=' + encodeURIComponent(receivers) + '&mailsSended=' + encodeURIComponent(mailsSended)
                        + '&mailsend=mailsend&step=2&count=' + encodeURIComponent(count);
        
        tt2coolajax.senddata('massMail_.php', 'POST', POSTDATA, 'massMail_info', function(response, status)
        {
            if (response == 1 || status != 'complete') {
                alert('Es ist ein Fehler ausgetreten');
                return false;
            }
            
            MassMail.callback(response);
        });
    },
    
    createResponsHolder : function(response)
    {
        var el = document.createElement('div');
        el.id = 'response_holder';
        el.style.display = 'none';
        el.innerHTML = response;
        document.body.appendChild(el);
    },
    
    removeResponsHolder : function(response)
    {
        tt2coolajax.getEL('response_holder').parentNode.removeChild(tt2coolajax.getEL('response_holder'));
    },
    
    callback : function(response)
    {
        this.createResponsHolder(response);
        var receivers   = tt2coolajax.getEL('response_holder').getElementsByTagName('div')[0].innerHTML;
        var count       = tt2coolajax.getEL('response_holder').getElementsByTagName('div')[1].innerHTML;
        var mailsSended = tt2coolajax.getEL('response_holder').getElementsByTagName('div')[2].innerHTML;
        var info        = tt2coolajax.getEL('response_holder').getElementsByTagName('div')[3].innerHTML;
        var rest        = tt2coolajax.getEL('response_holder').getElementsByTagName('div')[4].innerHTML;
        
        this.removeResponsHolder();
        
        tt2coolajax.getEL('massMail_info').innerHTML = info;
        
        if (rest > 0) {
            setTimeout(function() {MassMail.nextStep(count, mailsSended, receivers);}, 1500);
        } 
        else {
            setTimeout(function() 
            {
                tt2coolajax.getEL('massMail_info').style.display = 'none';
                tt2coolajax.getEL('massMail_form').style.display = 'block';
                document.massMailForm.to.value      = '';
                document.massMailForm.text.value    = '';
                document.massMailForm.betreff.value = '';
                
                for (i = 0; i < document.getElementsByTagName('input').length; ++i) 
                { 
                    box = document.getElementsByTagName('input')[i]; 
              
                    if(box.type == 'checkbox' && box.name == 'classes[]') {
                        box.checked = ''; 
                    }
                }
                
                alert('Es wurden Erfolgreich ' + count + ' Emails versendet');
                
            }, 1500);
        }
    }
}
