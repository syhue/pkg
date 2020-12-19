<html>
<head>
<title>Minimal TCP Stateful PKG</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<!-- navbar-->
<?php require 'nav.php'?>

<h1>PKG mskDel.</h1>
<p>deletes a masterkey from the keystore.</p>

<form action="mskdel.php" method="post">

<?php require 'kagetsel.php'?>
</br>
</br>

<input type="submit" value="Submit">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (!isset($_POST["alias"]) || empty($_POST["alias"])) {
		die("keyalias. unspecified");
	}

	$ipaddr = '127.0.0.1';
	$port = 6666;

	$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	if ($sock === false) {
		echo "failed: " . socket_strerror(socket_last_error()) . "\n";
	}

	//echo "Attempting to connect to '$ipaddr' on port '$port'...";
	$res = socket_connect($sock, $ipaddr, $port);
	if ($res === false) {
		echo "failed: ($res) " . socket_strerror(socket_last_error($sock)) . "\n";
	}

	$in = '{';
	$in .= '"alias":"'.trim($_POST["alias"],"\r\n").'",';
	$in .= '"service":"mskdel"';
	$in .= '}'."\r\n";

	$out = '';

	socket_write($sock, $in, strlen($in));

	echo "Response:";
	echo "<br>";
	echo "<br>";
	echo "<pre>";
	while ($out = socket_read($sock, 2048)) {
		//echo nl2br($out);
		echo $out;
	}
	echo "</pre>";
	socket_close($sock);
}
?>

</body>
</html>
