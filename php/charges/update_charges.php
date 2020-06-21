<?php

include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";


if (isset($_POST['id']) && isset($_POST['amount'])) {

	$id = $_POST['id'];
	$amount = $_POST['amount'];

	if (!empty($id) && count($id) > 0) {

		for ($i=0; $i < count($id); $i++) { 
			$amounts = $connection->real_escape_string(mysql_entities_fix_string($amount[$i]));
			$ids =  $connection->real_escape_string(mysql_entities_fix_string($id[$i]));
			$sql = "UPDATE `charges` SET `amount`='$amounts' WHERE `id`='$ids'";
			$res = $connection->query($sql);
		}
	}

	header("location:../../charges_form.php");
    die();
}else{
	 header("location:../../charges_form.php");
     die();
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>