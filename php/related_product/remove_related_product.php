<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
date_default_timezone_set('Asia/Kolkata');

if (isset($_GET['p_id']) && !empty($_GET['p_id']) && isset($_GET['id']) && !empty($_GET['id'])) {
	$p_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['p_id']));
	$id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));

	$sql = "DELETE FROM `related_product` WHERE `id`='$id'";
	if ($res = $connection->query($sql)) {
		header("location:../../related_product_list.php?p_id=$p_id");
	}else{
		header("location:../../related_product_list.php?p_id=$p_id");
	}
}


function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}

?>