<?php
    include "../admin_login_system/php_user_session_check.php";
	include "../database/connection.php";

    date_default_timezone_set('Asia/Kolkata');
    
	if (isset($_GET['id'])) {
    	$order_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));
        $s_date = $connection->real_escape_string(mysql_entities_fix_string($_GET['s_date']));
        $e_date = $connection->real_escape_string(mysql_entities_fix_string($_GET['e_date'])); 
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $time = date('H:i:s');

    	$sql = "UPDATE `orders` SET `status`='2' WHERE `id`='$order_id'";
    	if ($res = $connection->query($sql)) {
    		header("location:../../order_list.php?msg=1&s_date=$s_date&e_date=$e_date");
         	die();
    	}else{
    		header("location:../../order_list.php?msg=2&s_date=$s_date&e_date=$e_date");
         die();
    	}

	}else{
		header("location:../../order_list.php?msg=2&s_date=$s_date&e_date=$e_date");
         die();
	}

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}

?>