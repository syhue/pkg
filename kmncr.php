<html>
<head>
<title>Minimal TCP Stateful PKG</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<!-- navbar-->
<?php require 'nav.php'?>

<h1>PKG ckeycrtRegister.</h1>
<p>register a certificate for the signing key.</p>

<form action="kmncr.php" method="post">

<!-- USK field-->
<label for"kta">CKEY Certificate</label>
</br>
<textarea id="kta" name="kta" rows="40" cols="75">
<?php
	if (isset($_POST["kta"]) || !empty($_POST["kta"])) {
		echo $_POST["kta"];
	}
?>
</textarea>
</br>
</br>

<input type="submit" value="Submit">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (!isset($_POST["kta"]) || empty($_POST["kta"])) {
		die("keytextfield A. unspecified");
	}

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

	//trim kta from newlines and replace with empty
	//temporarily, the crt is passed after the JSON, which the tcp service reads all
	$tka = trim(preg_replace('/\s+/', '', $_POST["kta"]));

	$in = '{';
	$in .= '"service":"kmncr",';
	$in .= '"crt":"'.trim(preg_replace('/[(\r\n)\n]+/', '\\n', $_POST["kta"])).'"';
	$in .= '}'."\r\n";
	//only do the below if the PEM file has newlines
	//$in .= trim($_POST["kta"],"\r\n")."\r\n"; //separate from the json

	$out = '';

	socket_write($sock, $in, strlen($in));
	socket_shutdown($sock, 1); //shutdown socket for writing

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
