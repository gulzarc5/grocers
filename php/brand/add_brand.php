<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if(isset($_POST['name']) ){
	$brand = $connection->real_escape_string(mysql_entities_fix_string($_POST['name']));
    //echo $brand;
    $category = $connection->real_escape_string(mysql_entities_fix_string($_POST['category']));
    // $sub_category = $connection->real_escape_string(mysql_entities_fix_string($_POST['sub_category']));
    $image = $_FILES['image'];
    $image_name = null;
    if (!empty($image['name'])) {
        $image_size = $image['size'];
        if ($image_size > 2097152 || $image_size < 2 ) {
                header("location:../../add_brand_form.php?msg=6");
                die();
        }

        $brand_image_name   = $image['name'];
        $brand_image_tmp_name = $image['tmp_name'];
        $ext_explode = explode(".",$brand_image_name);
        $ext = strtolower(end($ext_explode));
        if( $ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='bmp' || $ext=='gif' ){
            $image_name = md5(uniqid()).date('y-m-d').".".$ext;
            $path = "../../uploads/brand/".$image_name ;
            move_uploaded_file($brand_image_tmp_name,$path);

            include_once("../product/ak_php_img_lib_1.0.php");
            $thumb_path = "../../uploads/brand/thumb/".$image_name;
            $wmax = 600;
            $hmax = 600;
            ak_img_resize($path,$thumb_path, $wmax, $hmax, $ext);

        }else{
            header("location:../../add_brand_form.php?msg=4");
            die();
        }
    }


    $sql ="INSERT INTO `brands`(`name`,`image`,`category_id`,`sub_category_id`) VALUES ('$brand','$image_name','$category',null)";
    if ($result=$connection->query($sql)){
    
		header("location:../../add_brand_form.php?msg=1");
	}else{
        header("location:../../add_brand_form.php?msg=2");
    }
}else{
        header("location:../../add_brand_form.php?msg=3");
    }




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>