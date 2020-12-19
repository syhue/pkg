<html>
<head>
<title>Minimal TCP Stateful PKG</title>
<link rel="stylesheet" href="style.css">
<script src="util.js"></script>
</head>
<body>

<!-- navbar-->
<?php require 'nav.php'?>

<h1>PKG ckeycrtChainList.</h1>
<p>obtain certificate chain for ckey</p>

<?php
$ipaddr = '127.0.0.1';
$port = 6666;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($sock === false) {
	die("failed: " . socket_strerror(socket_last_error()) . "\n");
}

//echo "Attempting to connect to '$ipaddr' on port '$port'...";
$res = socket_connect($sock, $ipaddr, $port);
if ($res === false) {
	die("failed: ($res) " . socket_strerror(socket_last_error($sock)) . "\n");
}

$in = '{';
$in .= '"service":"kmvcr"';
$in .= '}'."\r\n";

$out = '';

socket_write($sock, $in, strlen($in));

echo "Response:";
echo "<br>";
echo "<br>";
echo "<textarea id=\"kta\" name=\"kta\" rows=\"40\" cols=\"75\">";
while ($out = socket_read($sock, 2048)) {
	//echo nl2br($out);
	echo $out;
}
echo "</textarea>";
echo "</br>";
echo "</br>";
//download button
echo "<button onclick=saveTextAsFile('ckey.crt','kta')>";
echo "Download as file</button>";
socket_close($sock);
?>

</body>
</html>
