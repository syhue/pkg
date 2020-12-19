<?php
echo '<label for="exm">Expiry Mode:</label>';
echo '<select id="exm" name="exm" value="">';
if (isset($_POST["exm"]) && !empty($_POST["exm"])){
	switch ($_POST["exm"]) {
	case "<d":
		echo '<option value="<y"		>Expire on Year</option>';
		echo '<option value="=y"		>Valid for Year</option>';
		echo '<option value="<d" selected 	>Expire on Day</option>';
		break;
	case "<y":
		echo '<option value="<y" selected	>Expire on Year</option>';
		echo '<option value="=y"		>Valid for Year</option>';
		echo '<option value="<d" 	 	>Expire on Day</option>';
		break;
	case "=y":
		echo '<option value="<y"		>Expire on Year</option>';
		echo '<option value="=y" selected	>Valid for Year</option>';
		echo '<option value="<d"  		>Expire on Day</option>';
		break;
	default:
	}
}else{
	echo '<option value="<y"		>Expire on Year</option>';
	echo '<option value="=y"		>Valid for Year</option>';
	echo '<option value="<d"  		>Expire on Day</option>';
}
echo '</select></br>';
echo '<label for="exv">Expiry Value:</label></br>';
echo '<input type="number" id="exv" name="exv" style="width:100px;"';
echo 'value="';
if (isset($_POST["exv"]) || !empty($_POST["exv"])) {
	echo $_POST["exv"];
}else{
	echo '1';
}
echo '">';
?>

