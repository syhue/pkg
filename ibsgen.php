<html>
<head>
<title>Minimal PKG</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<!-- navbar-->
<?php require 'nav.php'?>

<h1>IBS genTest.</h1>
<p>sample ibs generation.</p>

<form action="ibsgen.php" method="post">

<!-- USK field-->
<label for"kta">User Secret Key</label>
</br>
<textarea id="kta" name="kta" rows="15" cols="75">
<?php
	if (isset($_POST["kta"]) || !empty($_POST["kta"])) {
		echo $_POST["kta"];
	}
?>
</textarea>
</br>
</br>

<!-- Msg field-->
<label for"msg">Message</label>
</br>
<textarea id="msg" name="msg" rows="10" cols="75">
<?php
	if (isset($_POST["msg"]) || !empty($_POST["msg"])) {
		echo $_POST["msg"];
	}
?>
</textarea>
</br>
</br>

<label>USK Password (optional)</label></br>
<input type="password" id="ukpass" name="ukpass">
</br>
</br>

<input type="submit" value="Submit">

</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (!isset($_POST["kta"]) || empty($_POST["kta"])) {
		die("user secret key. unspecified");
	}

	if (!isset($_POST["msg"]) || empty($_POST["msg"])) {
		die("message. unspecified");
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
	$in .= '"msg":"'.$_POST["msg"].'",';
	$in .= '"ukpass":"'.$_POST["ukpass"].'",';
	$in .= '"uskpem":"'.trim(preg_replace('/[(\r\n)\n]+/', '\\n', $_POST["kta"])).'",';
	$in .= '"service":"ibsgen"';
	$in .= '}'."\r\n";
	//only do the below if the PEM file has newlines
	//$in .= trim($_POST["kta"],"\r\n")."\r\n"; //separate from the json

	$out = '';

	socket_write($sock, $in, strlen($in));
	socket_shutdown($sock, 1); //shutdown socket for writing

	echo "Response:";
	echo "<br>";
	echo "<br>";
	echo "<textarea id=\"ktb\" name=\"ktb\" rows=\"10\" cols=\"75\">";
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
