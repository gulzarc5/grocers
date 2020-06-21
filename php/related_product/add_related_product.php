<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
date_default_timezone_set('Asia/Kolkata');

if (isset($_POST['p_id']) && !empty($_POST['p_id']) && isset($_POST['related_id']) && !empty($_POST['related_id'])) {
	$p_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['p_id']));
	$related_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['related_id']));

	$check_related_id = "SELECT * FROM `related_product` WHERE `product_id`='$p_id' AND `related_to_id`='$related_id'";
	if ($res_check_related = $connection->query($check_related_id)) {
		if ($res_check_related->num_rows > 9) {
			header("location:../../add_related_product_form.php?p_id=$_POST[p_id]&page=1005&msg=3");
			die();
		}
	}
	$date = date("Y-m-d H:i:s");
	$sql = "INSERT INTO `related_product`(`product_id`, `related_to_id`, `created_at`) VALUES ('$p_id','$related_id','$date')";
	if ($res = $connection->query($sql)) {
		header("location:../../add_related_product_form.php?p_id=$_POST[p_id]&page=1005&msg=1");
	}else{
		header("location:../../add_related_product_form.php?p_id=$_POST[p_id]&page=1005&msg=2");
	}
}


function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}

?>