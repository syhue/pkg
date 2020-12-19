<html>
<head>
<title>Minimal PKG</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<!-- navbar-->
<?php require 'nav.php'?>

<h1>IBS chkTest.</h1>
<p>sample ibs verify test.</p>

<form action="ibschk.php" method="post">

<!-- USK field-->
<label for"kta">Master Public Key</label>
</br>
<textarea id="kta" name="kta" rows="12" cols="75">
<?php
	if (isset($_POST["kta"]) || !empty($_POST["kta"])) {
		echo $_POST["kta"];
	}
?>
</textarea>
</br>
</br>

<label for"jws">JWS</label>
</br>
<textarea id="jws" name="jws" rows="30" cols="75">
<?php
	if (isset($_POST["jws"]) || !empty($_POST["jws"])) {
		echo $_POST["jws"];
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
		die("master public key. unspecified");
	}

	if (!isset($_POST["jws"]) || empty($_POST["jws"])) {
		die("json web signature. unspecified");
	}

	$ipaddr = '127.0.0.1';
	$port = 6666;
	//$port = 6667; //vos test

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
	$in .= '"sig":"'.trim($_POST["jws"],"\r\n").'",';
	$in .= '"mpkpem":"'.trim(preg_replace('/[(\r\n)\n]+/', '\\n', $_POST["kta"])).'",';
	$in .= '"service":"ibschk"';
	$in .= '}'."\r\n";
	//only do the below if the PEM file has newlines
	//$in .= trim($_POST["kta"],"\r\n")."\r\n"; //separate from the json

	$out = '';

	socket_write($sock, $in, strlen($in));
	socket_shutdown($sock, 1); //shutdown socket for writing

	echo "Response:";
	echo "<br>";
	echo "<br>";
	echo "<textarea id=\"ktb\" name=\"ktb\" rows=\"12\" cols=\"75\">";
	while ($out = socket_read($sock, 2048)) {
		//echo nl2br($out);
		echo $out;
	}
	echo "</textarea>";
	socket_close($sock);
}
?>

</body>
</html>
