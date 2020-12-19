<html>
<head>
<title>Minimal TCP Stateful PKG</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<!-- navbar-->
<?php require 'nav.php'?>

<h1>PKG mskInit.</h1>
<p>initializes a masterkey and register it to the keystore.</p>

<form action="mskini.php" method="post">

<!-- algo field-->
<?php require 'algo.php'?>
</br>
</br>

<label for="ks">Key Alias: </label>
<input type="text" id="alias" name="alias" style="width:300px;"
value="<?php
	if (isset($_POST["alias"]) || !empty($_POST["alias"])) {
		echo $_POST["alias"];
	}
?>">
</br>
</br>

<label for="ks">Key Spec: (2048, prime256v1, BLS12383)</label>
<input type="text" id="ks" name="ks" style="width:300px;"
value="<?php
	if (isset($_POST["ks"]) || !empty($_POST["ks"])) {
		echo $_POST["ks"];
	}
?>">
</br>
</br>

<label>MSK Password</label></br>
<input type="password" id="ksass" name="kspass">
</br>
</br>

<input type="submit" value="Submit">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (!isset($_POST["algo"])) {
		die("algo. unspecified");
	}

	if (!isset($_POST["alias"]) || empty($_POST["alias"])) {
		die("keyalias. unspecified");
	}

	if (!isset($_POST["ks"]) || empty($_POST["ks"])) {
		die("keyspec. unspecified");
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
	$in .= '"ks":"'.trim($_POST["ks"],"\r\n").'",';
	$in .= '"algo":"'.trim($_POST["algo"],"\r\n").'",';
	$in .= '"kspass":"'.$_POST["kspass"].'",';
	$in .= '"service":"mskini"';
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
