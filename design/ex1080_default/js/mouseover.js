if (document.layers) {navigator.family = "nn4"}
if (document.all) {navigator.family = "ie4"}
if (window.navigator.userAgent.toLowerCase().match("gecko")) {navigator.family = "gecko"}

// zeigt die PopUp-Box
function info(titl,a){
	 desc = "<table style=\"width:200px;\">\n"
         +"<tr><td style=\"text-align:center;\" class=\"tablea\">"+titl+"</td></tr>\n"
         +"<tr><td style=\"text-align:left;\"  class=\"tableb\" >"+a+"</td></tr>\n"
         +"</table>\n";

if(navigator.family =="nn4") {
        document.object1.write(desc);
        document.object1.close();
        document.object1.left=(mousex+15)+"px";
        document.object1.top=(mousey-5)+"px";
        }
else if(navigator.family =="ie4"){
        object1.innerHTML=desc;
        object1.style.pixelLeft=(mousex+15)+"px";
        object1.style.pixelTop=(mousey-5)+"px";
        }
else if(navigator.family =="gecko"){
        document.getElementById("object1").innerHTML=desc;
        document.getElementById("object1").style.left=(mousex+15)+"px";
        document.getElementById("object1").style.top=(mousey-5)+"px";
        }
}

//  versteckt die PopUp-Box
function hideLayer(){
        if(navigator.family =="nn4") {eval(document.object1.write(""));}
        else if(navigator.family =="ie4"){object1.innerHTML=""; }
        else if(navigator.family =="gecko") {document.getElementById("object1").innerHTML="";}
}