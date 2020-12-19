<html>
<head>
<title>Minimal TCP Stateful PKG</title>
<link rel="stylesheet" href="css/kmnew.css">
</head>
<body>

<!-- navbar-->
<?php require 'nav.php'?>

<div class="container">
	<div><h1>PKG keystoreInit.</h1></div>
	<div><p>initializes the keystore.</p></div>
	<div class = "little-container"><br><br><br>
		<form action="kmnew.php" method="post">
			<div class = "super-little-container">

				<div class = "flex-item-left">
					<div><label>CKEY Algo: </label></div><br>
					<div><label>CKEY Key-Spec:</label></div><br>
					<div><label>KeyStore Password:</label></div><br>
				</div>

				<div class = "flex-item-right">
					<div>
						<select id="kalgo" name="kalgo" value="">
						<option value="RSA" selected>RSA</option>';
						</select>
					</div><br>

					<div>
						<!-- <label>e.g., 2048</label> -->
						<input type="text" id="ks" name="ks" placeholder="  e.g., 2048" style="width:300px;"
						value="<?php
							if (isset($_POST["ks"]) || !empty($_POST["ks"])) {
								echo $_POST["ks"];
							}
						?>">
					</div><br>

					<div>
						<input type="password" id="ksass" name="kspass" style="width:300px;">
					</div><br>
				</div>
			</div>
			<div>
				<button class = "submit" type="submit" value="Submit">Submit</button>
			</div>
		<form>
	</div>
</div>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (!isset($_POST["kalgo"]) || empty($_POST["kalgo"])) {
		die("ckey generation algo. unspecified");
	}

	if (!isset($_POST["ks"]) || empty($_POST["ks"])) {
		die("keyspec. unspecified");
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
	$in .= '"kalgo":"'.trim($_POST["kalgo"],"\r\n").'",';
	$in .= '"ks":"'.trim($_POST["ks"],"\r\n").'",';
	$in .= '"kspass":"'.$_POST["kspass"].'",';
	$in .= '"service":"kmnew"';
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
