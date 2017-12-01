
/**
 * TSStatus: Teamspeak 3 viewer for php5
 * @author Sebastien Gerard <sebeuu@gmail.com>
 * @see http://tsstatus.sebastien.me/
 * 
 **/

function tsstatusconnect(host, port, channel)
{
	var command = "ts3server://" + host + "/?port=" + port;
	var nick = "";
	var pass = "";
	
	if(document.getElementById("tsstatusNick") != null) nick = document.getElementById("tsstatusNick").value;
	if(nick != "")
	{
		command += "&nickname=" + nick;
		var dateExpire = new Date;
		dateExpire.setMonth(dateExpire.getMonth()+1);
		document.cookie = escape("tsstatus_" + host) + "=" + escape(nick) + "; expires=" + dateExpire.toGMTString();
	}
	
	if(document.getElementById("tsstatusPasswd") != null) pass = document.getElementById("tsstatusPasswd").value;
	if(pass != "")
	{
		command += "&password=" + pass;
		var dateExpire = new Date;
		dateExpire.setMonth(dateExpire.getMonth()+1);
		document.cookie = escape("tsstatus_" + host + "_pwd") + "=" + escape(pass) + "; expires=" + dateExpire.toGMTString();
	}
	
	if(channel != undefined)
	{
		command += "&channel=" + channel;
	}

	var popup = window.open(command);
	popup.close();
}
