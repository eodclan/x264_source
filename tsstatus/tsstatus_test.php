<?php
require_once(dirname(__FILE__)."../../include/engine.php");
dbconn();
loggedinorreturn();

class TSStatus
{
	private $_host;
	private $_qport;
	private $_sid;
	private $_socket;
	private $_updated;
	private $_serverDatas;
	private $_channelDatas;
	private $_userDatas;
	private $_serverGroupFlags;
	private $_channelGroupFlags;

	public $imagePath;
	public $decodeUTF8;
	public $showNicknameBox;
	public $timeout;

	public function TSStatus($host, $queryPort, $serverId)
	{
		$this->_host = $host;
		$this->_qport = $queryPort;
		$this->_sid = $serverId;

		$this->_socket = null;
		$this->_updated = false;
		$this->_serverDatas = array();
		$this->_channelDatas = array();
		$this->_userDatas = array();
		$this->_serverGroupFlags = array();
		$this->_channelGroupFlags = array();

		$this->imagePath = "img/";
		$this->decodeUTF8 = false;
		$this->showNicknameBox = true;
		$this->timeout = 2;

		$this->setServerGroupFlag(6, 'servergroup_300.png');
		$this->setChannelGroupFlag(5, 'changroup_100.png');
		$this->setChannelGroupFlag(6, 'changroup_200.png');
	}

	private function unescape($str)
	{
		$find = array('\\\\', 	"\/", 		"\s", 		"\p", 		"\a", 	"\b", 	"\f", 		"\n", 		"\r", 	"\t", 	"\v");
		$rplc = array(chr(92),	chr(47),	chr(32),	chr(124),	chr(7),	chr(8),	chr(12),	chr(10),	chr(3),	chr(9),	chr(11));

		return str_replace($find, $rplc, $str);
	}

	private function parseLine($rawLine)
	{
		$datas = array();
		$rawItems = explode("|", $rawLine);
		foreach ($rawItems as $rawItem)
		{
			$rawDatas = explode(" ", $rawItem);
			$tempDatas = array();
			foreach($rawDatas as $rawData)
			{
				$ar = explode("=", $rawData, 2);
				$tempDatas[$ar[0]] = isset($ar[1]) ? $this->unescape($ar[1]) : "";
			}
			$datas[] = $tempDatas;
		}
		return $datas;
	}

	private function sendCommand($cmd)
	{
		fputs($this->_socket, "$cmd\n");
		$response = "";
		do
		{
			$response .= fread($this->_socket, 8096);
		}while(strpos($response, 'error id=') === false);

		if(strpos($response, "error id=0") === false)
		{
			throw new Exception("TS3 Server returned the following error: " . $this->unescape(trim($response)));
		}

		return $response;
	}

	private function queryServer()
	{
		$this->_socket = @fsockopen($this->_host, $this->_qport, $errno, $errstr, $this->timeout);
		if($this->_socket)
		{
			@socket_set_timeout($this->_socket, $this->timeout);
			$isTs3 = trim(fgets($this->_socket)) == "TS3";
			if(!$isTs3) throw new Exception("Not a Teamspeak 3 server/bad query port");

			$response = "";
			$response .= $this->sendCommand("use sid=" . $this->_sid);
			$response .= $this->sendCommand("serverinfo");
			$response .= $this->sendCommand("channellist -topic -flags -voice -limits");
			$response .= $this->sendCommand("clientlist -uid -away -voice -groups");

			$this->disconnect();

			if($this->decodeUTF8) $response = utf8_decode($response);

			return $response;
		}
		else throw new Exception("Socket error: $errstr [$errno]");
	}

	private function disconnect()
	{
		@fputs($this->_socket, "quit\n");
		@fclose($this->_socket);
	}

	private function sortUsers($a, $b)
	{
		return strcasecmp($a["client_nickname"], $b["client_nickname"]);
	}

	private function update()
	{
		$response = $this->queryServer();

		$lines = explode("error id=0 msg=ok\n\r", $response);
		if(count($lines) == 5)
		{
			$this->_serverDatas = $this->parseLine($lines[1]);
			$this->_serverDatas = $this->_serverDatas[0];

			$this->_channelDatas = $this->parseLine($lines[2]);
			$this->_userDatas = $this->parseLine($lines[3]);
			usort($this->_userDatas, array($this, "sortUsers"));

			$this->_updated = true;
		}
		else $this->error = "Invalid server response";

	}
 
	private function renderFlags($flags)
	{
		$out = "";
		foreach ($flags as $flag) $out .= '<img src="' . $this->imagePath . $flag . '" />';
		return $out;
	}

	private function renderUsers($parentId)
	{
		$out = "";
		foreach($this->_userDatas as $user)
		{
			if($user["client_type"] == 0 && $user["cid"] == $parentId)
			{
				$icon = "16x16_player_off.png";
				if($user["client_away"] == 1) $icon = "24x24_away.png";
				else if($user["client_flag_talking"] == 1) $icon = "16x16_player_on.png";
				else if($user["client_output_hardware"] == 0) $icon = "16x16_hardware_output_muted.png";
				else if($user["client_output_muted"] == 1) $icon = "16x16_output_muted.png";
				else if($user["client_input_hardware"] == 0) $icon = "16x16_hardware_input_muted.png";
				else if($user["client_input_muted"] == 1) $icon = "16x16_input_muted.png";

				$flags = array();
				if(isset($this->_channelGroupFlags[$user["client_channel_group_id"]])) $flags[] = $this->_channelGroupFlags[$user["client_channel_group_id"]];
				$serverGroups = explode(",", $user["client_servergroups"]);
				foreach ($serverGroups as $serverGroup) if(isset($this->_serverGroupFlags[$serverGroup])) $flags[] = $this->_serverGroupFlags[$serverGroup];

				$out .= '
				<div class="tsstatusItem">
					<div class="tsstatusLabel">
						<img src="' . $this->imagePath . $icon . '" />' . $user["client_nickname"] . '
					</div>
					<div class="tsstatusFlags">
						' . $this->renderFlags($flags) . '
					</div>
				</div>';
			}
		}
		return $out;
	}

	private function renderChannels($parentId)
	{
		$out = "";
		foreach ($this->_channelDatas as $channel)
		{
			if($channel["pid"] == $parentId)
			{
				$icon = "16x16_channel_green.png";
				if( $channel["channel_maxclients"] > -1 && ($channel["total_clients"] >= $channel["channel_maxclients"])) $icon = "16x16_channel_red.png";
				else if( $channel["channel_maxfamilyclients"] > -1 && ($channel["total_clients_family"] >= $channel["channel_maxfamilyclients"])) $icon = "16x16_channel_red.png";
				else if($channel["channel_flag_password"] == 1) $icon = "16x16_channel_yellow.png";

				$flags = array();
				if($channel["channel_flag_default"] == 1) $flags[] = '16x16_default.png';
				if($channel["channel_needed_talk_power"] > 0) $flags[] = '16x16_moderated.png';
				if($channel["channel_flag_password"] == 1) $flags[] = '16x16_register.png';

				$link = "javascript:tsstatusconnect('" . $this->_host . "','" . $this->_serverDatas["virtualserver_port"] . "','" . htmlentities($channel["channel_name"]) . "')";

				$out .= '
				<div class="tsstatusItem">
					<div class="tsstatusLabel">
						<a href="' . $link . '">
							<img src="' . $this->imagePath . $icon . '" />' . $channel["channel_name"] . '
						</a>
					</div>
					<div class="tsstatusFlags">
						' . $this->renderFlags($flags) . '
					</div>
					' . (count($this->_userDatas) > 0 ? $this->renderUsers($channel["cid"]) : '') . $this->renderChannels($channel["cid"]) . '
				</div>';
			}
		}
		return $out;
	}

	private function renderNickNameBox()
	{
		$cookieName = "tsstatus_" . str_replace(".", "_", $this->_host);
		$nickname = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : "";
		$out = '<div class="tsstatusNickname">Dein Nickname: <input type="text" id="tsstatusNick" value="' . $nickname . '" /></div><br />';
		return $out;
	}

	public function clearServerGroupFlags()
	{
		$this->_serverGroupFlags = array();
	}

	public function setServerGroupFlag($serverGroupId, $image)
	{
		$this->_serverGroupFlags[$serverGroupId] = $image;
	}

	public function clearChannelGroupFlags()
	{
		$this->_channelGroupFlags = array();
	}

	public function setChannelGroupFlag($channelGroupId, $image)
	{
		$this->_channelGroupFlags[$channelGroupId] = $image;
	}

	public function render()
	{
		try
		{
			$out = '<div class="tsstatus">' . "\n";
			$this->update();

			if ($this->showNicknameBox) $out .= $this->renderNickNameBox();
			$out .= '<div class="tsstatusServerName"><a href="javascript:tsstatusconnect(\'' . $this->_host . "','" . $this->_serverDatas["virtualserver_port"] . '\')"><img src="' . $this->imagePath . '16x16_server_green.png" />' . $this->_serverDatas["virtualserver_name"] . "</a></div>\n";
			if(count($this->_channelDatas) > 0) $out .= $this->renderChannels(0);
			$out .= "</div>\n";
		}
		catch (Exception $ex)
		{
			$this->disconnect();
			$out = '<div class="tsstatuserror">' . $ex->getMessage() . '</div>';
		}
		return $out;
	}
}

if ($CURUSER)
{
  $ss_a = @mysql_fetch_assoc(@mysql_query("SELECT `uri` FROM `design` WHERE `id`=" . $CURUSER["stylesheet"]));
  if ($ss_a) $GLOBALS["ss_uri"] = $ss_a["uri"];
}

if (!$GLOBALS["ss_uri"])
{
  ($r = mysql_query("SELECT `uri` FROM `design` WHERE `default`='yes'")) or die(mysql_error());
  ($a = mysql_fetch_assoc($r)) or die(mysql_error());
  $GLOBALS["ss_uri"] = $a["uri"];
}

$ts3_ip 	= $GLOBALS["TS3_IP"];
$ts3_port 	= $GLOBALS["TS3_PORT"];

print '
<script type="text/javascript" src="/tsstatus/tsstatus.js"></script>
<link rel="stylesheet" type="text/css" href="/tsstatus/tsstatus.css">';
$tsstatus = new TSStatus($ts3_ip, 10011, 1);
$tsstatus->imagePath = "/tsstatus/img/";
$tsstatus->showNicknameBox = false;
$tsstatus->decodeUTF8 = true;
$tsstatus->timeout = 2;
echo $tsstatus->render();
print '';

