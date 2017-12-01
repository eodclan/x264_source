
function MakeArrayt(n){
   this.length=n;
   for(var i=0; i<=n; i++) this[i]=i;
   return this
}

hex=new MakeArrayt(15);
hex[10]="A"; hex[11]="B"; hex[12]="C"; hex[13]="D"; hex[14]="E"; hex[15]="F";

function ToHext(x){
var h = Math.floor(x/16);
var l = x%16;
h     = hex[h]+""; 
l     = hex[l]+""; 
var s = h+""+l;
   return s;
}

function dez_konv(p)
{
if (p == "A") p = 10;
if (p == "B") p = 11;
if (p == "C") p = 12;
if (p == "D") p = 13;
if (p == "E") p = 14;
if (p == "F") p = 15;
return p;
}

function ToDezt(x)
{
var p1 = x.substring(0,1);
var p2 = x.substring(1,2);
p1 = dez_konv(p1)*16;
p2 = dez_konv(p2);
return parseInt(p1)+parseInt(p2);
}

function fall (col,val)
{
return ToHext(ToDezt(col)-Math.floor(val));
}

function raise (col,val)
{
return ToHext(ToDezt(col)+Math.floor(val));
}

function instance_bigger(col1,col2,col3,ins,rev)
{
if (!rev) var instanz1 = new Array(1,3,5);
else      var instanz1 = new Array(1,5,3);

var ret = new Array(5);
if (col1 > col2 && col1 > col3)
     if (col2 >= col3)         
       {
       ret[0]  = col1-col3; // pool
       ret[1]  = col2-col3; // cur
	ret[2]  = col3;
	ret[3]  = instanz1[ins];
	}

ret[4] = "Bigger vers "+ins+" ins "+ret[3];  // Debug

return ret;
}

function instance_lower(col1,col2,col3,ins,rev)
{
if (!rev) var instanz1 = new Array(2,4,6);
else      var instanz1 = new Array(6,4,2);

var ret = new Array(5);
if (col1 < col2 && col1 < col3)
     if (col2 >= col3)    
       {
       ret[0]  = col2-col1; // pool
       ret[1]  = col3-col1; // cur
	ret[2]  = col1;
	ret[3]  = instanz1[ins];
	}

ret[4] = "Lower vers "+ins+" ins "+ret[3];  // Debug
return ret;
}


function rainbowt(text,par,buch,rev){
if (!par)
par = "FF0000";
if (par.length > 6)
par = par.substring(0,6);
while (par.length < 6)
par = "0"+par;
if (!buch)
buch = 100;
if (!rev)
rev = 0;


var pool = 0;
var cur   = 0;
var cur_t = 0;
var base  = 0;
var midd  = 0;
var ins   = 0;
var red_v = new Array(0,1);
var gre_v = new Array(0,1);
var blu_v = new Array(0,1);
var par_red = par.substring(0,2);
var par_gre = par.substring(2,4);
var par_blu = par.substring(4,6);
var base_red= 0;
var base_gre= 0;
var base_blu= 0;
var color = par_red+par_gre+par_blu;
var dez_red = ToDezt(par_red);
var dez_gre = ToDezt(par_gre);
var dez_blu = ToDezt(par_blu);
var erg = new Array(3); 
var tmp = new Array(3);

tmp = instance_bigger(dez_red,dez_gre,dez_blu,0,rev);
if (tmp[0])
   erg = tmp;
else
{
tmp = instance_bigger(dez_gre,dez_blu,dez_red,1,rev);
    if (tmp[0])
       erg = tmp;
    else
    {
    tmp = instance_bigger(dez_blu,dez_red,dez_gre,2,rev);
        if (tmp[0])
           erg = tmp;

        else
	 {
	 tmp = instance_lower(dez_blu,dez_gre,dez_red,0,rev);
	     if (tmp[0])
		 erg = tmp;
	     else
	     {
	     tmp = instance_lower(dez_red,dez_blu,dez_gre,1,rev);
		  if (tmp[0])
		     erg = tmp;
		  else
		  {
		  tmp = instance_lower(dez_gre,dez_red,dez_blu,2,rev);
		      if (tmp[0])
			  erg = tmp;
		  }
	     }
	 }

    }
}
pool       = erg[0];
cur_t      = erg[1];
base       = erg[2];
ins_t      = erg[3];
midd       = base+cur_t;

if (!pool)
{
pool  = 255;
cur_t = base_red;
base  = 0;
ins_t = Math.floor(base_red/(255/2)+1); 
midd       = base+cur_t;
}


if (text.length > 1)
var step = (6*pool)/(text.length-1)*Math.ceil((text.length-1)/buch);

base_red = dez_red-base;
base_gre = dez_gre-base;
base_blu = dez_blu-base;

while (text.match("&nbsp;"))
text = text.replace("&nbsp;"," ");

for(i=0;i < text.length;i++)
	{

       cur = i*step;
	ins = Math.floor(cur/pool)+6+(ins_t-1);
       cur = cur%pool;
if (!rev)
{
      //  Hauptfunktion
      if (ins%6+1 == 1)
       color = fall(par_red, -1*(pool-base_red)     )+raise(par_gre,(    -base_gre+cur))+raise(par_blu,(    -base_blu    )); 
      if (ins%6+1 == 2)
       color = fall(par_red,(-1*(pool-base_red)+cur))+raise(par_gre,(pool-base_gre    ))+raise(par_blu,(    -base_blu    ));  
      if (ins%6+1 == 3)
       color = fall(par_red,          base_red      )+raise(par_gre,(pool-base_gre    ))+raise(par_blu,(    -base_blu+cur));
      if (ins%6+1 == 4)
       color = fall(par_red,          base_red      )+raise(par_gre,(pool-base_gre-cur))+raise(par_blu,(pool-base_blu    )); 
      if (ins%6+1 == 5)
       color = fall(par_red,          base_red -cur )+raise(par_gre,(    -base_gre    ))+raise(par_blu,(pool-base_blu    ));
      if (ins%6+1 == 6)
       color = fall(par_red,(-1*(pool-base_red))    )+raise(par_gre,(    -base_gre    ))+raise(par_blu,(pool-base_blu-cur));

} else {

      //  Reverse
      if (ins%6+1 == 1)
       color = fall(par_red, -1*(pool-base_red)     )+raise(par_gre,(    -base_gre    ))+raise(par_blu,(    -base_blu+cur)); 
      if (ins%6+1 == 2)
       color = fall(par_red,(-1*(pool-base_red)+cur))+raise(par_gre,(    -base_gre    ))+raise(par_blu,(pool-base_blu    ));  
      if (ins%6+1 == 3)
       color = fall(par_red,          base_red      )+raise(par_gre,(    -base_gre+cur))+raise(par_blu,(pool-base_blu    ));
      if (ins%6+1 == 4)
       color = fall(par_red,          base_red      )+raise(par_gre,(pool-base_gre    ))+raise(par_blu,(pool-base_blu-cur)); 
      if (ins%6+1 == 5)
       color = fall(par_red,          base_red -cur )+raise(par_gre,(pool-base_gre    ))+raise(par_blu,(    -base_blu    ));
      if (ins%6+1 == 6)
       color = fall(par_red,(-1*(pool-base_red))    )+raise(par_gre,(pool-base_gre-cur))+raise(par_blu,(    -base_blu    ));

}
      if (par_red == par_gre && par_red == par_blu)
      {
       cur = i*((2*pool)/(text.length-1))+(pool-base_red);
	ins = Math.floor(cur/(pool/3))+1;
       cur = cur%pool;
      if (ins%2+1 == 1)
      color = raise(par_red,(     -base_red +cur))+raise(par_gre,(     -base_gre +cur))+raise(par_blu,(     -base_blu +cur)); 
      else
      color = raise(par_red,((pool-base_red)-cur))+raise(par_gre,((pool-base_gre)-cur))+raise(par_blu,((pool-base_blu)-cur)); 
      }

document.write("<FONT COLOR='#"+color+"'>"+text.substring(i,i+1)+"<"+"/FONT>");
	}



}