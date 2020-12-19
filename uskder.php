<html>
<head>
<title>Minimal TCP Stateful PKG</title>
<link rel="stylesheet" href="style.css">
<script src="util.js"></script>
</head>
<body>

<!-- navbar-->
<?php require 'nav.php'?>

<h1>PKG KeyDer.</h1>
<p>derive userkey from using a master secret key.</p>

<form action="uskder.php" method="post">

<?php require 'kagetsel.php'?>
</br>
</br>

<!-- Username field -->
<label for="usn">Public Username</label></br>
<input type="text" id="usn" name="usn" style="width:300px;">
</br>
</br>

<?php require 'exv.php'?>
</br>
</br>

<label>MSK Password</label></br>
<input type="password" id="kspass" name="kspass" value="
<?php
	if (isset($_POST["kspass"]) || !empty($_POST["kspass"])) {
		echo $_POST["kspass"];
	}
?>"
>
</br>
</br>

<label>USK Password (optional)</label></br>
<input type="password" id="ukpass" name="ukpass">
</br>
</br>

<label>Prepend MPK (Create userkey bundle)</label>
<input type="checkbox" id="prepend_mpk" name="prepend_mpk"
<?php
	if (isset($_POST["prepend_mpk"]) || !empty($_POST["prepend_mpk"])) {
		if( $_POST["prepend_mpk"] === "on"){
			echo "checked";
		}
	}
?>
>
</br>
</br>

<!-- submit button -->
<input type="submit" value="Submit">

</form>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

	if (!isset($_POST["alias"])) {
		die("keyalias. unspecified");
	}

	if (!isset($_POST["usn"]) || empty($_POST["usn"])) {
		die("public username. unspecified");
	}

	if (!isset($_POST["exm"]) || empty($_POST["exm"])) {
		die("expiry mode. unspecified");
	}

	if (!isset($_POST["exv"]) || empty($_POST["exv"])) {
		die("expiry value. unspecified");
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
	$in .= '"alias":"'.trim($_POST["alias"],"\r\n").'",';
	$in .= '"usn":"'.trim($_POST["usn"],"\r\n").'",';
	$in .= '"exm":"'.trim($_POST["exm"],"\r\n").'",';
	$in .= '"exv":"'.trim($_POST["exv"],"\r\n").'",';
	$in .= '"kspass":"'.$_POST["kspass"].'",';
	$in .= '"ukpass":"'.$_POST["ukpass"].'",';
	if ($_POST["prepend_mpk"] === "on"){
		$in .= '"prepend_mpk":"true",';
	}else{
		$in .= '"prepend_mpk":"false",';
	}
	$in .= '"service":"uskder"';
	$in .= '}'."\r\n";
	$out = '';

	socket_write($sock, $in, strlen($in));

	echo "Response:";
	echo "<br>";
	echo "<br>";
	echo "<textarea id=\"kta\" name=\"kta\" rows=\"10\" cols=\"75\">";
	while ($out = socket_read($sock, 2048)) {
		//echo nl2br($out);
		echo $out;
	}
	echo "</textarea>";
	echo "</br>";
	echo "</br>";
	//download button
	echo "<button onclick=saveTextAsFile('".$_POST["usn"].".usk','kta')>";
	echo "Download as file</button>";
	socket_close($sock);
}
?>

</body>
</html>
