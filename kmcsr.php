<html>
<head>
<title>Minimal TCP Stateful PKG</title>
<link rel="stylesheet" href="style.css">
<script src="util.js"></script>
</head>
<body>

<!-- navbar-->
<?php require 'nav.php'?>

<h1>PKG ckeyCSRObtain.</h1>
<p>obtains the csr of the keystore's signing key.</p>

<form action="kmcsr.php" method="post">

<label for="dn">Distinguished Name: </label>
<label>e.g. CN=localhost, O=MMU, OU=hybridpki devs</label>
</br>
<textarea id="dn" name="dn" rows=5 cols=75">
<?php
	if (isset($_POST["dn"]) || !empty($_POST["dn"])) {
		echo $_POST["dn"];
	}
?>
</textarea>
</br>
</br>

<label>Sign Algo: (please ensure same type as ckey)</label></br>
<select id="salgo" name="salgo" value="">
<option value="SHA256WithRSA" selected>SHA256WithRSA</option>';
<option value="SHA1WithRSA">SHA1WithRSA</option>';
</select>
</br>
</br>

<input type="submit" value="Submit">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (!isset($_POST["dn"]) || empty($_POST["dn"])) {
		die("distinguished name. unspecified");
	}

	if (!isset($_POST["salgo"])) {
		die("sign algo. unspecified");
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

	$in = '{';
	$in .= '"dn":"'.trim($_POST["dn"],"\r\n").'",';
	$in .= '"salgo":"'.trim($_POST["salgo"],"\r\n").'",';
	$in .= '"service":"kmcsr"';
	$in .= '}'."\r\n";

	$out = '';

	socket_write($sock, $in, strlen($in));

	echo "Response:";
	echo "<br>";
	echo "<br>";
	echo "<textarea id=\"kta\" name=\"kta\" rows=\"18\" cols=\"75\">";
	while ($out = socket_read($sock, 2048)) {
		//echo nl2br($out);
		echo $out;
	}
	echo "</textarea>";
	echo "</br>";
	echo "</br>";
	//download button
	echo "<button onclick=saveTextAsFile('ckey.csr','kta')>";
	echo "Download as file</button>";
	socket_close($sock);
}
?>

</body>
</html>
