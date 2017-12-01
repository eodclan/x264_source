// ************************************************************************************//
// * Lottery JavaScript v 0.4 
// ************************************************************************************//
// * Copyright (c) 2010 DefCon3
// * 
// * Co Author tantetoni2  [ THX for javascript development! ]
// * 
// ************************************************************************************//
// * Dieses unsichtbare Copyright muss bestehen bleiben.
// * Mit entfernung des Unsichtbaren Copyrights machen sie sich Strafbar.
// * Der Lizenztraeger sowie Rechteinhaber ist allein DefCon3.
// * Sollten Sie diese Hinweise nicht achten kann dies fuer Sie rechtliche Folgen haben.
// ************************************************************************************//
function toggle(ElementID) 
{
    var el  = document.getElementById(ElementID);
    var pic = document.getElementById('img_'+ElementID);
    if (el.style.display == 'block' || el.style.display == '') {
        el.style.display = 'none';
        pic.src = '/pic/visible.png';
    } else {
        el.style.display = 'block';
        pic.src = '/pic/hidden.png';
    }
}

var DClotto = 
{   
    clickcount  : 0,
    superzahl   : null,
    zahlen      : new Array(),
    
    in_array : function(needle,  argStrict) 
    {
      	var found = false, key, strict = !!argStrict;
      
      	for (key in this.zahlen) {
        		if ((strict && this.zahlen[key] === needle) || (!strict && this.zahlen[key] == needle)) {
        			 found = true;
        			 break;
        		}
      	}
      	return found;
    },
    
    mark : function(el)
    {
        el.style.backgroundColor = '#FF6142';
        el.style.fontWeight = 'bold';
    },
    
    unmark : function(el)
    {
        el.style.backgroundColor = '#808080';
        el.style.fontWeight = '';
    },
        
    sZahl : function(el, num)
    {
        if (this.superzahl == num) {
            this.superzahl = null;
            this.unmark(el);
        } else if (this.superzahl === null) {
            this.superzahl = num;
            this.mark(el);
        } else {
            this.unmark(document.getElementById('sz'+this.superzahl));
            this.superzahl = num;
            this.mark(el);
        }
        
        this.lottoFormVal();
    },    
        
    lottoclick : function(el, num)
    {
        if (this.in_array(num) === false && this.clickcount <= 5) {
            this.mark(el);
            this.zahlen[this.zahlen.length] = num;
            ++this.clickcount;
        } else if (this.in_array(num) === true) {
            this.unmark(el);
            --this.clickcount;
            var tempArr = new Array();
            
            for (var i = 0; i < this.zahlen.length; ++i) {
                if (this.zahlen[i] != num){
                    tempArr[tempArr.length] = this.zahlen[i];
                }
            }

            this.zahlen = tempArr;
        }
        this.lottoFormVal();
    },
    
    lottoFormVal : function()
    {
        document.getElementById('lottochoise').value = this.zahlen.join(',');
        document.getElementById('lottoszahl').value = (this.superzahl === null ? '' : this.superzahl);
    },
    
    lottoReset : function()
    {
        this.zahlen = new Array();
      	this.clickcount = 0;
      	this.superzahl = null;
      	
      	for (var i = 1; i <= 49; i++) {		
      		  this.unmark(document.getElementById('z'+i));
      	}
      	for (var i = 0; i <= 9; i++) {		
      		  this.unmark(document.getElementById('sz'+i));
      	}
      	
      	this.lottoFormVal();
    },
    
    lottoZufall : function()
    {
      	var x = 0;
      	var key;
      	
      	this.lottoReset();
      	
      	while (x < 6) {
        		var rzahl = 1+Math.floor(Math.random() * 49);
        		if (this.in_array(rzahl) === false)	{
          			this.zahlen[x] = rzahl;		
          			x++;		
        		}	else {
        		    continue;
        		}
      	}
      	
      	for (var i = 0; i < this.zahlen.length; ++i) {
            this.mark(document.getElementById('z'+this.zahlen[i]));
      		  this.lottoFormVal(this.zahlen[i]);
      		  ++this.clickcount;
      	}
      	var rszahl = 0+Math.floor(Math.random() * 10);
      	this.sZahl(document.getElementById('sz'+rszahl), rszahl);
    }
}