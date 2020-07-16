<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if(isset($_GET['sub_id'])){
	$sub_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['sub_id']));  


   $sql = "UPDATE `sub_category` SET `delete_status`='2' WHERE `id`='$sub_id'";
    if ($result=$connection->query($sql)){

        $sql_p = "UPDATE `product` SET `is_delete`='2' WHERE `sub_cat_id`='$sub_id'";
        $connection->query($sql_p);
		header("location:../../category_list.php");
	}else{
        header("location:../../category_list.php");
    }
}else{
        header("location:../../category_list.php");
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>