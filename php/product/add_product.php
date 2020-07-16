<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
date_default_timezone_set('Asia/Kolkata');

if(isset($_POST['add_product']) && !empty($_POST['add_product'])){

	$name = $connection->real_escape_string(mysql_entities_fix_string($_POST['name']));
    $category = $connection->real_escape_string(mysql_entities_fix_string($_POST['category']));
    $sub_category = $connection->real_escape_string(mysql_entities_fix_string($_POST['sub_category']));
    $brand = $connection->real_escape_string(mysql_entities_fix_string($_POST['brand']));
    $description = $connection->real_escape_string(mysql_entities_fix_string($_POST['description']));
    $price = $connection->real_escape_string(mysql_entities_fix_string($_POST['price']));
    $mrp = $connection->real_escape_string(mysql_entities_fix_string($_POST['mrp']));

    $stock = $connection->real_escape_string(mysql_entities_fix_string($_POST['stock']));

    $expiry_date = $connection->real_escape_string(mysql_entities_fix_string($_POST['expiry_date']));
    $popular = $connection->real_escape_string(mysql_entities_fix_string($_POST['popular']));
    $tranding = $connection->real_escape_string(mysql_entities_fix_string($_POST['tranding']));
   
   $sql_p_check = "SELECT * FROM `product` WHERE `name`='$name' AND `sub_cat_id`='$sub_category' AND `is_delete`='1'";
   if ($res_p_check = $connection->query($sql_p_check)) {
       if ($res_p_check->num_rows > 0) {
            header("location:../../add_product_form.php?msg=5");
            die();
       }
   } 


    $image = $_FILES['image'];
    $image_name = null;
    if (!empty($image['name'])) {

        $image_size = $image['size'];
        if ($image_size > 2097152 || $image_size < 2 ) {
                header("location:../../add_product_form.php?msg=6");
                die();
        }

        $product_image_name   = $image['name'];
        $product_image_tmp_name = $image['tmp_name'];
        $ext_explode = explode(".",$product_image_name);
        $ext = strtolower(end($ext_explode));
        if( $ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='bmp' || $ext=='gif' ){
            $image_name = md5(uniqid()).date('Y-m-d').".".$ext;
            $path = "../../uploads/product_image/".$image_name ;
            $image_api_image_url ="uploads/product_image/".$image_name ;
            move_uploaded_file($product_image_tmp_name,$path);

            include_once("ak_php_img_lib_1.0.php");
            $thumb_path = "../../uploads/product_image/thumb/".$image_name;
            $wmax = 250;
            $hmax = 200;
            ak_img_resize($path,$thumb_path, $wmax, $hmax, $ext);

        }else{
            header("location:../../add_product_form.php?msg=4");
            die();
        }
    }
    $date = date('Y-m-d');
    $created_at = date("Y-m-d H:i:s");
    if (!empty($sub_category)) {
        $sql ="INSERT INTO `product`(`id`, `brand_id`,`name`, `category_id`, `sub_cat_id`, `description`,`mrp`, `price`, `image`,`stock`, `is_delete`, `is_tranding`,`is_popular`, `expiry_date`, `created_at`) VALUES (null,'$brand','$name','$category','$sub_category','$description','$mrp','$price','$image_name','$stock','1','$popular','$tranding','$expiry_date','$created_at')";
    }else{
         $sql ="INSERT INTO `product`(`id`,`brand_id`, `name`, `category_id`, `sub_cat_id`, `description`,`mrp`, `price`, `image`,`stock`, `is_delete`,  `is_tranding`,`is_popular`, `expiry_date`,  `created_at`) VALUES (null,'$brand','$name','$category',null,'$description','$mrp','$price','$image_name','$stock','1','$popular','$tranding','$expiry_date','$created_at')";
    }
   
    if ($result=$connection->query($sql)){
        header("location:../../add_product_form.php?msg=1");
	}else{
        header("location:../../add_product_form.php?msg=2");
    }
}else{
    header("location:../../add_product_form.php?msg=3");
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>