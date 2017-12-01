var P91 = null;

function P91AUC_system(){

	if (window.XMLHttpRequest) {
	  P91 = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
	  try {
		P91 = new ActiveXObject("Msxml2.XMLHTTP");
	  } catch (ex) {
		try {
		  P91 = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (ex) {
		}
	  }
	}
}

function P91AUC_heuripoll() {

  if (P91.readyState == 4) {
    var heurixpoll = document.getElementById("poll");
    heurixpoll.innerHTML = P91.responseText;
  }
}


function getvote(){

  P91.open("GET", "pollsnewajax.php"); 
  P91.onreadystatechange = P91AUC_heuripoll;
  P91.send(null);
}

function vote(id){

  P91.open("GET", "pollsnewajax.php?votethis="+id);
  P91.onreadystatechange = P91AUC_heuripoll;
  P91.send(null);
}

function voted(id){

  P91.open("GET", "pollsnewajax.php?voted="+id); 
  P91.onreadystatechange = P91AUC_heuripoll;
  P91.send(null);
}

function viewresult(query){

  P91.open("GET", "pollsnewajax.php"+query); 
  P91.onreadystatechange = P91AUC_heuripoll;
  P91.send(null);

}

function chares(val){

document.getElementById('res').value = val;

}
/*
function savevote(id) {
   
  var radio  = checkradio(document.getElementById("Antwort"));
  
  
  
  P91.open("GET", "pollsnewajax.php?voteid="+id+"&BereitsAbgestimmt="+document.getElementById('BereitsAbgestimmt').value+"&Antwort="+radio+"&maxvotes="+document.getElementById('maxvotes').value); 
  P91.onreadystatechange = P91AUC_heuri;
  //P91.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  P91.send(null);
    
} 
*/
function savevote(id) {
  
  P91.open("POST", "pollsnewajax.php"); 
  P91.onreadystatechange = P91AUC_heuripoll;
  P91.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  P91.send("voteid="+id+"&BereitsAbgestimmt="+document.getElementById('BereitsAbgestimmt').value+"&Antwort="+document.getElementById('res').value+"&maxvotes="+document.getElementById('maxvotes').value);
    
} 



var heurix = P91AUC_system();

