<?php
echo '<label for="algo">Algo: </label>';
echo '<select id="algo" name="algo" value="">';
if (isset($_POST["algo"]) && !empty($_POST["algo"])){
	switch ($_POST["algo"]) {
	case "shibs":
		echo '<option value="shibs" selected 	>Shamir IBS (RSA)</option>';
		echo '<option value="scibs"		>Schnorr IBS (DSA)</option>';
		echo '<option value="ecibs"		>ECSchnorr IBS (ECDSA)</option>';
		echo '<option value="bfibe"		>Boneh-Franklin IBE (BLS)</option>';
		break;
	case "scibs":
		echo '<option value="shibs"		>Shamir IBS (RSA)</option>';
		echo '<option value="scibs" selected	>Schnorr IBS (DSA)</option>';
		echo '<option value="ecibs"		>ECSchnorr IBS (ECDSA)</option>';
		echo '<option value="bfibe"		>Boneh-Franklin IBE (BLS)</option>';
		break;
	case "ecibs":
		echo '<option value="shibs"		>Shamir IBS (RSA)</option>';
		echo '<option value="scibs"		>Schnorr IBS (DSA)</option>';
		echo '<option value="ecibs" selected 	>ECSchnorr IBS (ECDSA)</option>';
		echo '<option value="bfibe"		>Boneh-Franklin IBE (BLS)</option>';
		break;
	case "bfibe":
		echo '<option value="shibs"		>Shamir IBS (RSA)</option>';
		echo '<option value="scibs"		>Schnorr IBS (DSA)</option>';
		echo '<option value="ecibs"		>ECSchnorr IBS (ECDSA)</option>';
		echo '<option value="bfibe" selected 	>Boneh-Franklin IBE (BLS)</option>';
		break;
	default:
	}
}else{
	echo '<option value="shibs"		>Shamir IBS (RSA)</option>';
	echo '<option value="scibs"		>Schnorr IBS (DSA)</option>';
	echo '<option value="ecibs"		>ECSchnorr IBS (ECDSA)</option>';
	echo '<option value="bfibe"		>Boneh-Franklin IBE (BLS)</option>';
}
echo '</select>';
?>

