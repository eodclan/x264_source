<?php 
/**
 * TSStatus: Teamspeak 3 viewer for php5
 * @author Sebastien Gerard <sebeuu@gmail.com>
 * @see http://tsstatus.sebastien.me/
 * 
 * 
 **/

$enableGenerator = false;









$host = isset($_POST["host"]) ? $_POST["host"] : "";
$port = isset($_POST["port"]) ? intval($_POST["port"]) : 10011;
$sid = isset($_POST["sid"]) ? intval($_POST["sid"]) : 1;
$showNicknameBox = !isset($_POST["showNicknameBox"]);
$decodeUTF8 = isset($_POST["decodeUTF8"]);
$timeout = isset($_POST["timeout"]) ? intval($_POST["timeout"]) : 2;

if($timeout < 1) $timeout = 0;
else if($timeout > 10) $timeout = 10;

$absoluteDir = dirname(__FILE__) . "/";
$wwwDir = substr($_SERVER["SCRIPT_NAME"], 0, strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);

$htmlCode = '<link rel="stylesheet" type="text/css" href="' . $wwwDir . 'tsstatus.css" />
<script type="text/javascript" src="' . $wwwDir . 'tsstatus.js"></script>';
echo $htmlCode;

$phpCode = '<?php
require_once("' . $absoluteDir . 'tsstatus.php");
$tsstatus = new TSStatus("' . $host . '", ' . $port . ', ' . $sid .');
$tsstatus->imagePath = "' . $wwwDir . 'img/";
$tsstatus->showNicknameBox = ' . ($showNicknameBox ? "true" : "false") . ';
$tsstatus->decodeUTF8 = ' . ($decodeUTF8 ? "true" : "false") . ';
$tsstatus->timeout = ' . $timeout . ';
echo $tsstatus->render();
?>';

?>
<html>
<head>
<title>TSStatus generator</title>
<style type="text/css">
body, table{
	font-family: Verdana;
	font-size: 12px;
}
h3{
	font-size: 14px;
	padding-bottom: 4px;
	border-bottom: 1px solid #aaa;
}
.warning{
	color: red;
}
</style>
</head>
<body>
<h3>TSStatus generator</h3>
<form action="" method="post">
<table>
	<tr>
		<th>Host</th>
		<td><input type="text" name="host" value="<?php echo htmlentities($host); ?>" /></td>
		<td>Your Teamspeak server hostname or ip</td>
	</tr>
	<tr>
		<th>Query port</th>
		<td><input type="text" name="port" value="<?php echo $port; ?>" /></td>
		<td>Server's query port, not the client port! (default 10011)</td>
	</tr>
	<tr>
		<th>Server Id</th>
		<td><input type="text" name="sid" value="<?php echo $sid; ?>" /></td>
		<td></td>
	</tr>
	<tr>
		<th>Timeout</th>
		<td><input type="text" name="timeout" value="<?php echo $timeout; ?>" /></td>
		<td>The timeout, in seconds, for connect, read, write operations</td>
	</tr>
	<tr>
		<th></th>
		<td><input type="checkbox" name="showNicknameBox" <?php echo (!$showNicknameBox ? "checked" : "") ?> /> Hide nickname box</td>
		<td></td>
	</tr>
	<tr>
		<th></th>
		<td><input type="checkbox" name="decodeUTF8" <?php echo ($decodeUTF8 ? "checked" : "") ?> /> Decode UTF8</td>
		<td>Try this option if you have problem with some special characters</td>
	</tr>
	<?php if ($enableGenerator):?>
	<tr>
		<td colspan="3"><input type="submit" value="Test TSStatus!" /></td>
	</tr>
	<?php endif;?>
</table>
</form>

<?php

if($enableGenerator)
{
	if($host != "")
	{
		echo "<h3>TSStatus result</h3>\n";

		require_once($absoluteDir . "tsstatus.php");
		$tsstatus = new TSStatus($host, $port, $sid);
		$tsstatus->imagePath  = $wwwDir . "img/";
		$tsstatus->showNicknameBox = $showNicknameBox;
		$tsstatus->decodeUTF8 = $decodeUTF8;
		echo $tsstatus->render();
		
		echo "<h3>HTML code</h3>\n";
		highlight_string($htmlCode);
		echo "<h3>PHP code</h3>\n";
		highlight_string($phpCode);
		echo "<h3>Full page sample</h3>\n";
		highlight_string("<html>\n<head>\n<title>TSStatus</title>\n$htmlCode\n</head>\n<body>\n$phpCode\n</body>\n</html>");
		
		echo '<br /><br /><br /><div class="warning">Don\'t forget to disable this script once finished testing!</div>';
	}
}
else 
{
	echo '
	<div class="warning">
		This script is disabled by default for security purposes!<br />
		To enable the script you have to edit <strong>tsstatusgen.php</strong> and replace <strong>$enableGenerator = false;</strong> by <strong>$enableGenerator = true;</strong> on <strong>line 10</strong><br />
		Don\'t forget to disable this script once finished testing!
	</div>';
}
?>

</body>
</html>
