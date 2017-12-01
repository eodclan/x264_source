function setExternalLinks() {
    if (!document.getElementsByTagName) {
        return null;
    }
    var anchors = document.getElementsByTagName("a");
    for (var i=0;i < anchors.length;i++) {
        var anchor = anchors[i];
        if (anchor.getAttribute("href") && anchor.getAttribute("rel") == "external") {
            anchor.setAttribute("target", "blank");
        }
    }
}
//window.onload = setExternalLinks;
window.setTimeout('setExternalLinks()', 200);

	function countdown() {
		startDatum=new Date(); // Aktuelles Datum

		// Countdown berechnen und anzeigen, bis Ziel-Datum erreicht ist
		if(startDatum<zielDatum)  {

			var jahre=0, monate=0, tage=0, stunden=0, minuten=0, sekunden=0;

			// Jahre
			while(startDatum<zielDatum) {
				jahre++;
				startDatum.setFullYear(startDatum.getFullYear()+1);
			}
			startDatum.setFullYear(startDatum.getFullYear()-1);
			jahre--;

			// Monate
			while(startDatum<zielDatum) {
				monate++;
				startDatum.setMonth(startDatum.getMonth()+1);
			}
			startDatum.setMonth(startDatum.getMonth()-1);
			monate--;

			// Tage
			while(startDatum.getTime()+(24*60*60*1000)<zielDatum){
				tage++;
				startDatum.setTime(startDatum.getTime()+(24*60*60*1000));
			}

			// Stunden
			stunden=Math.floor((zielDatum-startDatum)/(60*60*1000));
			startDatum.setTime(startDatum.getTime()+stunden*60*60*1000);

			// Minuten
			minuten=Math.floor((zielDatum-startDatum)/(60*1000));
			startDatum.setTime(startDatum.getTime()+minuten*60*1000);

			// Sekunden
			sekunden=Math.floor((zielDatum-startDatum)/1000);
			// Anzeige formatieren
			if(jahre==0){jahre="0000 - ";}else if(jahre<10){jahre="000"+jahre+" - ";}else if(jahre<100){jahre="00"+jahre+" - ";}else if(jahre<1000){jahre="0"+jahre+" - ";}else{jahre=jahre+" - ";}
			if(monate<10){monate="0"+monate+" - ";}else{monate=monate+" - ";}
			if(tage<10){tage="0"+tage+" - ";}else{tage=tage+" - ";}
			if(stunden<10){stunden="0"+stunden+" - ";}else{stunden=stunden+" - ";}
			if(minuten<10){minuten="0"+minuten+" - ";}else{minuten=minuten+" - ";}
			if(sekunden<10){sekunden="0"+sekunden;}else{sekunden=sekunden;}
			

			document.getElementById("in_time").value=jahre+monate+tage+stunden+minuten+sekunden;
			setTimeout('countdown()',200);
		}
		// Anderenfalls alles auf Null setzen
		else document.getElementById("in_time").value="0000 - 00 - 00 - 00 - 00 - 00";
	}
	
	function countdown_details() {
		startDatumd=new Date(); // Aktuelles Datum
		
		// Countdown berechnen und anzeigen, bis Ziel-Datum erreicht ist
		if(startDatumd<zielDatumd)  {

			var jahred=0, monated=0, taged=0, stundend=0, minutend=0, sekundend=0;

			// Jahre
			while(startDatumd<zielDatumd) {
				jahred++;
				startDatumd.setFullYear(startDatumd.getFullYear()+1);
			}
			startDatumd.setFullYear(startDatumd.getFullYear()-1);
			jahred--;

			// Monate
			while(startDatumd<zielDatumd) {
				monated++;
				startDatumd.setMonth(startDatumd.getMonth()+1);
			}
			startDatumd.setMonth(startDatumd.getMonth()-1);
			monated--;

			// Tage
			while(startDatumd.getTime()+(24*60*60*1000)<zielDatumd) {
				taged++;
				startDatumd.setTime(startDatumd.getTime()+(24*60*60*1000));
			}

			// Stunden
			stundend=Math.floor((zielDatumd-startDatumd)/(60*60*1000));
			startDatumd.setTime(startDatumd.getTime()+stundend*60*60*1000);

			// Minuten
			minutend=Math.floor((zielDatumd-startDatumd)/(60*1000));
			startDatumd.setTime(startDatumd.getTime()+minutend*60*1000);

			// Sekunden
			sekundend=Math.floor((zielDatumd-startDatumd)/1000);

			// Anzeige formatieren
			if(jahred==0){jahred="0000 - ";}else if(jahred<10){jahred="000"+jahred+" - ";}else if(jahred<100){jahred="00"+jahred+" - ";}else if(jahred<1000){jahred="0"+jahred+" - ";}else{jahred=jahred+" - ";}
			if(monated<10){monated="0"+monated+" - ";}else{monated=monated+" - ";}
			if(taged<10){taged="0"+taged+" - ";}else{taged=taged+" - ";}
			if(stundend<10){stundend="0"+stundend+" - ";}else{stundend=stundend+" - ";}
			if(minutend<10){minutend="0"+minutend+" - ";}else{minutend=minutend+" - ";}
			if(sekundend<10){sekundend="0"+sekundend;}else{sekundend=sekundend;}
			
			document.getElementById("in_time_details").value=jahred+monated+taged+stundend+minutend+sekundend;
			setTimeout('countdown_details()',200);
		}
		// Anderenfalls alles auf Null setzen
		else document.getElementById("in_time_details").value="0000 - 00 - 00 - 00 - 00 - 00";
	}
	
