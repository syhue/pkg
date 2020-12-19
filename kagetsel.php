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
$in .= '"service":"kaget"';
$in .= '}'."\r\n";

$buf = '';
$out = '';

socket_write($sock, $in, strlen($in));
while ($out = socket_read($sock, 2048)) {
	$buf .= $out;
}
socket_close($sock);

$ka = preg_split("/\r\n|\n|\r/", $buf);

if( $ka[0] == 'java.lang.NullPointerException'){
	die($ka[0]);
}else{
$kan = count($ka)-2;
echo '<label for="algo">Key Alias ('.$kan.'): </label>';
echo '<select id="alias" name="alias" value="">';
foreach ($ka as &$v) {
	if(!empty($v) && $v != 'ckey'){
		if (isset($_POST["alias"]) && !empty($_POST["alias"]) && $_POST["alias"] == $v){
			echo '<option value="'.$v.'" selected>'.$v.'</option>';
		}else{
			echo '<option value="'.$v.'">'.$v.'</option>';
		}
	}
}
echo '</select>';
}

?>

